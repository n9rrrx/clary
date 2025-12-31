<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Subscription') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="bg-yellow-100 dark:bg-yellow-900/30 border border-yellow-400 dark:border-yellow-700 text-yellow-700 dark:text-yellow-300 px-4 py-3 rounded-lg">
                    {{ session('warning') }}
                </div>
            @endif

            {{-- Current Plan --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Current Plan</h3>

                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-3">
                            <span class="text-2xl font-bold text-gray-900 dark:text-white capitalize">
                                {{ $currentPlan }}
                            </span>
                            @if($currentPlan === 'pro')
                                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-semibold rounded-full">
                                    ACTIVE
                                </span>
                            @endif
                        </div>

                        @if($subscription)
                            @if($subscription->onTrial())
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    Trial ends {{ $subscription->trial_ends_at->format('M d, Y') }}
                                </p>
                            @elseif($subscription->onGracePeriod())
                                <p class="text-sm text-yellow-600 dark:text-yellow-400 mt-1">
                                    Cancels on {{ $subscription->ends_at->format('M d, Y') }}
                                </p>
                            @endif
                        @endif
                    </div>

                    <div class="text-right">
                        @if($currentPlan === 'free')
                            <span class="text-3xl font-bold text-gray-900 dark:text-white">$0</span>
                            <span class="text-gray-500 dark:text-gray-400">/month</span>
                        @elseif($currentPlan === 'pro')
                            <span class="text-3xl font-bold text-gray-900 dark:text-white">$29</span>
                            <span class="text-gray-500 dark:text-gray-400">/user/month</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Upgrade Section (for free users) --}}
            @if($currentPlan === 'free')
                <div class="p-6 bg-gradient-to-r from-blue-600 to-indigo-600 shadow rounded-lg text-white">
                    <h3 class="text-lg font-semibold mb-2">Upgrade to Pro</h3>
                    <p class="text-blue-100 mb-4">Get unlimited projects, team members, and advanced analytics.</p>

                    <form method="POST" action="{{ route('subscription.upgrade') }}" id="upgrade-form">
                        @csrf
                        <input type="hidden" name="plan" value="pro">

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-blue-100 mb-2">Payment Method</label>
                            <div id="card-element" class="w-full p-3 rounded-lg bg-white/10 border border-white/20"></div>
                            <div id="card-errors" class="text-red-300 text-sm mt-2"></div>
                            <input type="hidden" name="payment_method" id="payment_method">
                        </div>

                        <button type="submit" id="upgrade-btn" class="w-full sm:w-auto px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition-colors">
                            <span id="btn-text">Start 14-Day Free Trial</span>
                            <span id="btn-loading" class="hidden">Processing...</span>
                        </button>
                    </form>
                </div>
            @endif

            {{-- Subscription Actions (for paid users) --}}
            @if($subscription && $currentPlan !== 'free')
                <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Manage Subscription</h3>

                    @if($subscription->onGracePeriod())
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            Your subscription is cancelled but you still have access until {{ $subscription->ends_at->format('M d, Y') }}.
                        </p>
                        <form method="POST" action="{{ route('subscription.resume') }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                                Resume Subscription
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('subscription.cancel') }}" onsubmit="return confirm('Are you sure you want to cancel your subscription?');">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
                                Cancel Subscription
                            </button>
                        </form>
                    @endif
                </div>

                {{-- Payment Method --}}
                <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Payment Method</h3>

                    @if($user->hasDefaultPaymentMethod())
                        @php $pm = $user->defaultPaymentMethod(); @endphp
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-8 bg-gray-100 dark:bg-gray-700 rounded flex items-center justify-center">
                                <span class="text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">{{ $pm->card->brand }}</span>
                            </div>
                            <div>
                                <p class="text-gray-900 dark:text-white">•••• •••• •••• {{ $pm->card->last4 }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Expires {{ $pm->card->exp_month }}/{{ $pm->card->exp_year }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No payment method on file.</p>
                    @endif
                </div>

                {{-- Billing History --}}
                <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Billing History</h3>

                    @if($user->invoices()->count() > 0)
                        <div class="space-y-3">
                            @foreach($user->invoices() as $invoice)
                                <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700 last:border-0">
                                    <div>
                                        <p class="text-gray-900 dark:text-white">{{ $invoice->date()->format('M d, Y') }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $invoice->total() }}</p>
                                    </div>
                                    <a href="{{ route('subscription.invoice', $invoice->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">
                                        Download
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No invoices yet.</p>
                    @endif
                </div>
            @endif

            {{-- Plan Comparison --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Compare Plans</h3>

                <div class="grid md:grid-cols-2 gap-6">
                    {{-- Free Plan --}}
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 {{ $currentPlan === 'free' ? 'ring-2 ring-blue-500' : '' }}">
                        <h4 class="font-semibold text-gray-900 dark:text-white">Starter (Free)</h4>
                        <ul class="mt-3 space-y-2 text-sm text-gray-600 dark:text-gray-400">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Up to 3 projects
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                2 team members
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Basic analytics
                            </li>
                        </ul>
                    </div>

                    {{-- Pro Plan --}}
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 {{ $currentPlan === 'pro' ? 'ring-2 ring-blue-500' : '' }}">
                        <h4 class="font-semibold text-gray-900 dark:text-white">Pro - $29/user/month</h4>
                        <ul class="mt-3 space-y-2 text-sm text-gray-600 dark:text-gray-400">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Unlimited projects
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Unlimited team members
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Advanced analytics
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Priority support
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($currentPlan === 'free')
        @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const stripe = Stripe('{{ config("services.stripe.key") }}');
                const elements = stripe.elements();

                const style = {
                    base: {
                        color: document.documentElement.classList.contains('dark') ? '#e5e7eb' : '#1f2937',
                        fontFamily: 'Inter, sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '16px',
                        '::placeholder': {
                            color: '#9ca3af'
                        }
                    },
                    invalid: {
                        color: '#ef4444',
                        iconColor: '#ef4444'
                    }
                };

                const cardElement = elements.create('card', { style: style });
                cardElement.mount('#card-element');

                cardElement.on('change', function(event) {
                    const displayError = document.getElementById('card-errors');
                    if (event.error) {
                        displayError.textContent = event.error.message;
                    } else {
                        displayError.textContent = '';
                    }
                });

                const form = document.getElementById('upgrade-form');
                const submitBtn = document.getElementById('upgrade-btn');
                const btnText = document.getElementById('btn-text');
                const btnLoading = document.getElementById('btn-loading');

                form.addEventListener('submit', async function(event) {
                    event.preventDefault();

                    submitBtn.disabled = true;
                    btnText.classList.add('hidden');
                    btnLoading.classList.remove('hidden');

                    const { setupIntent, error } = await stripe.confirmCardSetup(
                        '{{ $intent->client_secret }}',
                        {
                            payment_method: {
                                card: cardElement,
                                billing_details: {
                                    name: '{{ $user->name }}',
                                    email: '{{ $user->email }}'
                                }
                            }
                        }
                    );

                    if (error) {
                        document.getElementById('card-errors').textContent = error.message;
                        submitBtn.disabled = false;
                        btnText.classList.remove('hidden');
                        btnLoading.classList.add('hidden');
                    } else {
                        document.getElementById('payment_method').value = setupIntent.payment_method;
                        form.submit();
                    }
                });
            });
        </script>
        @endpush
    @endif
</x-app-layout>

