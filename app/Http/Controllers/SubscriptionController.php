<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;

class SubscriptionController extends Controller
{
    /**
     * Stripe Price IDs - Set these in your .env file
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
            'stripe_price_id' => null, // Will be set from env
        ],
        'enterprise' => [
            'name' => 'Enterprise',
            'price' => null, // Custom pricing
            'stripe_price_id' => null,
        ],
    ];

    public function __construct()
    {
        $this->plans['pro']['stripe_price_id'] = config('services.stripe.pro_price_id');
        $this->plans['enterprise']['stripe_price_id'] = config('services.stripe.enterprise_price_id');
    }

    /**
     * Show registration page for a specific plan
     */
    public function showRegistration(Request $request, string $plan = 'free')
    {
        if (!array_key_exists($plan, $this->plans)) {
            $plan = 'free';
        }

        $planDetails = $this->plans[$plan];
        $requiresPayment = $plan !== 'free';
        $intent = null;

        // Create SetupIntent for paid plans
        if ($requiresPayment && config('services.stripe.secret')) {
            try {
                if (Auth::check()) {
                    // For logged in users, use Cashier's method
                    $intent = Auth::user()->createSetupIntent();
                } else {
                    // For new users, create SetupIntent directly with Stripe
                    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
                    $intent = \Stripe\SetupIntent::create([
                        'usage' => 'off_session',
                    ]);
                }
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
     * Handle registration with optional subscription
     */
    public function register(Request $request)
    {
        $plan = $request->input('plan', 'free');
        $requiresPayment = $plan !== 'free' && array_key_exists($plan, $this->plans);

        // Base validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'plan' => ['required', 'string', 'in:free,pro,enterprise'],
        ];

        // Add payment validation for paid plans
        if ($requiresPayment) {
            $rules['payment_method'] = ['required', 'string'];
        }

        $request->validate($rules);

        // Create the user
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
            try {
                $user->createOrGetStripeCustomer();
                $user->updateDefaultPaymentMethod($request->payment_method);

                $priceId = $this->plans[$plan]['stripe_price_id'];

                if ($priceId) {
                    $user->newSubscription('default', $priceId)
                        ->trialDays(14)
                        ->create($request->payment_method);
                }
            } catch (\Exception $e) {
                // Log the error but don't fail registration
                \Log::error('Subscription creation failed: ' . $e->getMessage());

                // Update user plan to free if subscription fails
                $user->update(['plan' => 'free']);

                event(new Registered($user));
                Auth::login($user);

                return redirect(route('dashboard'))
                    ->with('warning', 'Account created but subscription failed. Please try adding payment method in settings.');
            }
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard'));
    }

    /**
     * Show subscription management page
     */
    public function manage()
    {
        $user = Auth::user();

        return view('subscription.manage', [
            'user' => $user,
            'plans' => $this->plans,
            'currentPlan' => $user->plan ?? 'free',
            'subscription' => $user->subscription('default'),
            'intent' => $user->createSetupIntent(),
        ]);
    }

    /**
     * Upgrade or change subscription
     */
    public function upgrade(Request $request)
    {
        $request->validate([
            'plan' => ['required', 'string', 'in:pro,enterprise'],
            'payment_method' => ['required_without:use_existing', 'string', 'nullable'],
        ]);

        $user = Auth::user();
        $plan = $request->plan;
        $priceId = $this->plans[$plan]['stripe_price_id'];

        if (!$priceId) {
            return back()->with('error', 'Invalid plan selected.');
        }

        try {
            // Update payment method if provided
            if ($request->payment_method) {
                $user->createOrGetStripeCustomer();
                $user->updateDefaultPaymentMethod($request->payment_method);
            }

            // Check if user has an existing subscription
            if ($user->subscribed('default')) {
                // Swap to new plan
                $user->subscription('default')->swap($priceId);
            } else {
                // Create new subscription
                $user->newSubscription('default', $priceId)
                    ->trialDays(14)
                    ->create($user->defaultPaymentMethod()->id ?? $request->payment_method);
            }

            $user->update(['plan' => $plan]);

            return back()->with('success', 'Subscription updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Subscription upgrade failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to update subscription. Please try again.');
        }
    }

    /**
     * Cancel subscription
     */
    public function cancel(Request $request)
    {
        $user = Auth::user();

        try {
            if ($user->subscribed('default')) {
                $user->subscription('default')->cancel();
            }

            // User keeps current plan until end of billing period
            return back()->with('success', 'Subscription cancelled. You\'ll have access until the end of your billing period.');
        } catch (\Exception $e) {
            \Log::error('Subscription cancellation failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to cancel subscription. Please try again.');
        }
    }

    /**
     * Resume a cancelled subscription
     */
    public function resume(Request $request)
    {
        $user = Auth::user();

        try {
            if ($user->subscription('default')?->onGracePeriod()) {
                $user->subscription('default')->resume();
                return back()->with('success', 'Subscription resumed successfully!');
            }

            return back()->with('error', 'No subscription to resume.');
        } catch (\Exception $e) {
            \Log::error('Subscription resume failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to resume subscription. Please try again.');
        }
    }

    /**
     * Download invoice
     */
    public function downloadInvoice(Request $request, string $invoiceId)
    {
        return Auth::user()->downloadInvoice($invoiceId, [
            'vendor' => 'Clary',
            'product' => 'Pro Subscription',
        ]);
    }
}

