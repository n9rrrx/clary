<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Create Account</h2>
        @if(isset($plan) && $plan === 'pro')
            <div class="mt-4">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="w-5 h-5 rounded bg-gradient-to-br from-accent-500 to-purple-600 flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">Pro</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">14 days free</span>
                </div>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Then ${{ $planDetails['price'] ?? 29 }}/month · Cancel anytime</p>
        @elseif(isset($plan) && $plan === 'enterprise')
            <div class="mt-4">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-lg bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800">
                    <span class="text-sm font-semibold text-purple-700 dark:text-purple-300">Enterprise</span>
                </div>
            </div>
        @else
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Get started for free</p>
        @endif
    </div>

    @php
        $plan = $plan ?? 'free';
        $requiresPayment = $requiresPayment ?? false;
        $hasIntent = isset($intent) && $intent;
    @endphp

    @if ($errors->any())
        <div class="p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 mb-4">
            <h3 class="text-sm font-medium text-red-700 dark:text-red-300 mb-2">Registration failed:</h3>
            <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('warning'))
        <div class="p-4 rounded-lg bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 mb-4">
            <p class="text-sm text-yellow-700 dark:text-yellow-300">{{ session('warning') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" id="registration-form" class="space-y-4">
        @csrf
        <input type="hidden" name="plan" value="{{ $plan }}">

        {{-- Name Field --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-accent-500 focus:border-transparent transition"
                   placeholder="John Doe">
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        {{-- Email Field --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-accent-500 focus:border-transparent transition"
                   placeholder="you@company.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        {{-- Password Fields in Grid --}}
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                <input id="password" type="password" name="password" required
                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-accent-500 focus:border-transparent transition"
                       placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-accent-500 focus:border-transparent transition"
                       placeholder="••••••••">
            </div>
        </div>

        @if($requiresPayment && $hasIntent)
            {{-- Payment Section --}}
            <div class="pt-4 mt-2 border-t border-gray-200 dark:border-gray-700">
                {{-- Payment Methods Header --}}
                <div class="flex items-center justify-between mb-3">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Payment Method</label>
                    <div class="flex items-center gap-2">
                        {{-- Visa --}}
                        <svg class="h-6" viewBox="0 0 48 32" fill="none">
                            <rect width="48" height="32" rx="4" fill="#1A1F71"/>
                            <path d="M19.5 21h-2.7l1.7-10.5h2.7L19.5 21zm11.3-10.2c-.5-.2-1.4-.4-2.4-.4-2.7 0-4.6 1.4-4.6 3.5 0 1.5 1.4 2.4 2.4 2.9 1.1.5 1.4.9 1.4 1.3 0 .7-.9 1-1.7 1-1.1 0-1.7-.2-2.6-.6l-.4-.2-.4 2.4c.7.3 1.9.5 3.1.5 2.9 0 4.7-1.4 4.8-3.6 0-1.2-.7-2.1-2.3-2.9-1-.5-1.6-.8-1.6-1.3 0-.4.5-.9 1.6-.9.9 0 1.6.2 2.1.4l.3.1.4-2.2zm7.1-.3h-2.1c-.7 0-1.2.2-1.5.9l-4.2 10.1h2.9l.6-1.6h3.6l.3 1.6h2.6l-2.2-11zm-3.5 7.1l1.1-3 .3-.9.2.8.6 3.1h-2.2zM15.2 10.5L12.5 18l-.3-1.5c-.5-1.8-2.2-3.7-4-4.7l2.5 9.2h3l4.4-10.5h-2.9z" fill="white"/>
                            <path d="M9.5 10.5H5l-.1.3c3.5.9 5.8 3 6.8 5.6l-1-5c-.2-.7-.7-.9-1.2-.9z" fill="#F9A51A"/>
                        </svg>
                        {{-- Mastercard --}}
                        <svg class="h-6" viewBox="0 0 48 32" fill="none">
                            <rect width="48" height="32" rx="4" fill="#000"/>
                            <circle cx="18" cy="16" r="10" fill="#EB001B"/>
                            <circle cx="30" cy="16" r="10" fill="#F79E1B"/>
                            <path d="M24 8.5a10 10 0 000 15 10 10 0 000-15z" fill="#FF5F00"/>
                        </svg>
                        {{-- Amex --}}
                        <svg class="h-6" viewBox="0 0 48 32" fill="none">
                            <rect width="48" height="32" rx="4" fill="#006FCF"/>
                            <path d="M8 16.5l-1.5-4h1.2l.9 2.5.9-2.5h1.2l-1.5 4v2.5H8v-2.5zm5.5 2.5h-1v-6.5h2.5c1.2 0 1.8.7 1.8 1.6 0 .7-.4 1.2-1 1.4l1.2 3.5h-1.1l-1.1-3.2h-1.3V19zm0-4.1h1.3c.5 0 .8-.3.8-.7s-.3-.7-.8-.7h-1.3v1.4zm7.5-.4h-2v1.2h2v.9h-2v1.5h2v.9h-3v-6.5h3v1zm2 4.5l1.8-3.3-1.7-3.2h1.2l1.1 2.2 1.1-2.2h1.2l-1.7 3.2 1.8 3.3h-1.2l-1.2-2.3-1.2 2.3h-1.2zm8 0h-1v-6.5h2.5c1.2 0 1.8.7 1.8 1.6 0 .7-.4 1.2-1 1.4l1.2 3.5h-1.1l-1.1-3.2h-1.3V19zm0-4.1h1.3c.5 0 .8-.3.8-.7s-.3-.7-.8-.7h-1.3v1.4zm7 4.1H37v-6.5h1v6.5z" fill="white"/>
                        </svg>
                        {{-- PayPal --}}
                        <svg class="h-6" viewBox="0 0 48 32" fill="none">
                            <rect width="48" height="32" rx="4" fill="#003087"/>
                            <path d="M18.5 9h4.8c2.5 0 4.2 1.5 3.8 4-.5 3.2-2.8 4.5-5.5 4.5h-1.3c-.4 0-.7.3-.8.7l-.6 3.8c0 .2-.2.4-.4.4h-2.7c-.3 0-.4-.2-.4-.5l2-12.4c.1-.3.3-.5.6-.5h.5z" fill="#009CDE"/>
                            <path d="M32.5 9h-4.8c-.3 0-.5.2-.6.5l-2 12.4c0 .3.1.5.4.5h2.4c.3 0 .5-.2.6-.5l.6-3.5c.1-.4.4-.7.8-.7h1.8c3.5 0 5.5-1.7 6-5 .2-1.4 0-2.5-.6-3.3-.7-.9-2-1.4-3.6-1.4z" fill="#003087"/>
                        </svg>
                    </div>
                </div>

                {{-- Card Input --}}
                <div id="card-element" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus-within:ring-2 focus-within:ring-accent-500 focus-within:border-transparent transition"></div>
                <div id="card-errors" class="text-red-500 text-xs mt-1"></div>
                <input type="hidden" name="payment_method" id="payment_method">

                {{-- Security Note --}}
                <div class="flex items-center gap-2 mt-3 text-xs text-gray-400">
                    <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>Secured by Stripe · You won't be charged during your 14-day trial</span>
                </div>
            </div>
        @elseif($requiresPayment && !$hasIntent)
            <div class="p-3 rounded-lg bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 text-sm text-yellow-700 dark:text-yellow-300">
                Payment not available. You'll start on the free plan.
            </div>
        @endif

        {{-- Submit Button --}}
        <button type="submit" id="submit-btn" class="w-full py-3 px-4 rounded-lg text-white font-semibold bg-accent-600 hover:bg-accent-500 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all flex items-center justify-center gap-2">
            <span id="btn-text">
                @if($requiresPayment && $hasIntent)
                    Start Free Trial
                @else
                    Create Account
                @endif
            </span>
            <span id="btn-loading" class="hidden">
                <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
        </button>
    </form>

    {{-- Footer Links --}}
    <div class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
        Already have an account?
        <a href="{{ route('login') }}" class="font-medium text-accent-600 hover:text-accent-500 dark:text-accent-400">Sign in</a>
    </div>

    @if($plan !== 'free')
        <div class="mt-2 text-center">
            <a href="{{ route('register') }}" class="text-xs text-gray-400 hover:text-gray-500">Or start with the free plan →</a>
        </div>
    @endif

    @if($requiresPayment && $hasIntent)
        @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const stripe = Stripe('{{ config("services.stripe.key") }}');
                const elements = stripe.elements();

                const style = {
                    base: {
                        color: document.documentElement.classList.contains('dark') ? '#f3f4f6' : '#111827',
                        fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '16px',
                        '::placeholder': { color: '#9ca3af' }
                    },
                    invalid: { color: '#ef4444', iconColor: '#ef4444' }
                };

                const cardElement = elements.create('card', {
                    style: style,
                    hidePostalCode: true
                });
                cardElement.mount('#card-element');

                cardElement.on('change', function(event) {
                    document.getElementById('card-errors').textContent = event.error ? event.error.message : '';
                });

                const form = document.getElementById('registration-form');
                const submitBtn = document.getElementById('submit-btn');
                const btnText = document.getElementById('btn-text');
                const btnLoading = document.getElementById('btn-loading');

                form.addEventListener('submit', async function(event) {
                    event.preventDefault();

                    submitBtn.disabled = true;
                    btnText.classList.add('hidden');
                    btnLoading.classList.remove('hidden');

                    const { setupIntent, error } = await stripe.confirmCardSetup(
                        '{{ $intent->client_secret ?? "" }}',
                        {
                            payment_method: {
                                card: cardElement,
                                billing_details: {
                                    name: document.getElementById('name').value,
                                    email: document.getElementById('email').value
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
</x-guest-layout>

