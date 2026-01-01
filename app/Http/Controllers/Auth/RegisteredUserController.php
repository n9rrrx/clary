<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Team;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Stripe\Stripe;
use Stripe\SetupIntent;

class RegisteredUserController extends Controller
{
    /**
     * Stripe Price IDs
     */
    protected $plans = [
        'free' => [
            'name' => 'Starter',
            'price' => 0,
            'stripe_price_id' => null,
        ],
        'pro' => [
            'name' => 'Pro',
            'price' => 29,
            'stripe_price_id' => null,
        ],
        'enterprise' => [
            'name' => 'Enterprise',
            'price' => null,
            'stripe_price_id' => null,
        ],
    ];

    public function __construct()
    {
        $this->plans['pro']['stripe_price_id'] = config('services.stripe.pro_price_id');
        $this->plans['enterprise']['stripe_price_id'] = config('services.stripe.enterprise_price_id');
    }

    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        $plan = $request->query('plan', 'free');

        \Log::info('Registration page accessed', [
            'plan_param' => $plan,
            'all_query' => $request->query(),
            'url' => $request->fullUrl()
        ]);

        if (!array_key_exists($plan, $this->plans)) {
            $plan = 'free';
        }

        $planDetails = $this->plans[$plan];
        $requiresPayment = $plan !== 'free';
        $intent = null;

        // Create a SetupIntent for paid plans (without a customer - for new users)
        if ($requiresPayment && config('services.stripe.secret')) {
            try {
                Stripe::setApiKey(config('services.stripe.secret'));
                $intent = SetupIntent::create([
                    'usage' => 'off_session',
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to create SetupIntent: ' . $e->getMessage());
            }
        }

        return view('auth.register', [
            'plan' => $plan,
            'planDetails' => $planDetails,
            'requiresPayment' => $requiresPayment,
            'intent' => $intent,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $plan = $request->input('plan', 'free');
        $requiresPayment = $plan !== 'free' && array_key_exists($plan, $this->plans);
        
        \Log::info('Registration attempt', [
            'plan' => $plan,
            'requiresPayment' => $requiresPayment,
            'has_payment_method' => $request->has('payment_method'),
            'payment_method_value' => $request->payment_method ? substr($request->payment_method, 0, 20) . '...' : null,
        ]);

        // Base validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];

        // Add payment validation for paid plans
        if ($requiresPayment) {
            $rules['payment_method'] = ['required', 'string'];
        }

        $request->validate($rules);

        // Create the user as an Owner
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'owner',
            'plan' => $plan,
        ]);

        // Auto-create a team for the owner
        $team = Team::create([
            'name' => $request->name . "'s Team",
            'slug' => Str::slug($request->name . '-' . Str::random(4)),
            'owner_id' => $user->id,
        ]);

        // Set this as the user's current team
        $user->update(['current_team_id' => $team->id]);

        // Add owner to team_user pivot with full access
        $team->members()->attach($user->id, [
            'role' => 'owner',
            'budget_limit' => 0,
            'allowed_tabs' => json_encode(['projects', 'invoices', 'tasks', 'clients']),
        ]);

        // Handle paid subscription
        if ($requiresPayment && $request->payment_method) {
            \Log::info('Starting subscription creation for user', [
                'user_id' => $user->id,
                'plan' => $plan,
                'price_id' => $this->plans[$plan]['stripe_price_id'] ?? 'NOT SET',
            ]);
            
            try {
                \Log::info('Creating Stripe customer...');
                $user->createOrGetStripeCustomer();
                
                \Log::info('Updating default payment method...');
                $user->updateDefaultPaymentMethod($request->payment_method);

                $priceId = $this->plans[$plan]['stripe_price_id'];

                if ($priceId) {
                    \Log::info('Creating subscription with trial...', ['price_id' => $priceId]);
                    $user->newSubscription('default', $priceId)
                        ->trialDays(14)
                        ->create($request->payment_method);
                    \Log::info('Subscription created successfully!');
                } else {
                    \Log::warning('No price ID found for plan, skipping subscription', ['plan' => $plan]);
                }
            } catch (\Exception $e) {
                \Log::error('Subscription creation failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'user_id' => $user->id,
                ]);

                // Update user plan to free if subscription fails
                $user->update(['plan' => 'free']);

                event(new Registered($user));
                Auth::login($user);

                return redirect(route('dashboard', absolute: false))
                    ->with('warning', 'Account created but subscription failed. Please try adding payment method in settings.');
            }
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
