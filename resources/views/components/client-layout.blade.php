<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Clary') }} - Client Portal</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --color-midnight-900: #0f172a; --color-midnight-800: #1e293b; --color-midnight-700: #334155; }
        .dark { background-color: var(--color-midnight-900); }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-midnight-900 min-h-screen">

    <!-- Client Portal Header -->
    <header class="bg-white dark:bg-midnight-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                        <span class="text-white font-bold text-lg">C</span>
                    </div>
                    <span class="text-lg font-bold text-gray-900 dark:text-white">Client Portal</span>
                </a>

                <!-- User Menu -->
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600 dark:text-gray-300">{{ Auth::user()->name }}</span>
                    <div class="relative">
                        <button id="clientUserMenuBtn" class="flex items-center text-sm focus:outline-none">
                            <div class="h-9 w-9 rounded-full bg-gradient-to-tr from-blue-600 to-purple-500 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                            </div>
                        </button>
                        <div id="clientUserMenu" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-midnight-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-xl py-1 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-midnight-700">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-midnight-700">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-200 dark:border-gray-800 py-6 mt-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500 dark:text-gray-400">
            Powered by <span class="font-semibold text-blue-600 dark:text-blue-400">Clary</span>
        </div>
    </footer>

    <script>
        // User menu toggle
        (function() {
            const btn = document.getElementById('clientUserMenuBtn');
            const menu = document.getElementById('clientUserMenu');
            if (btn && menu) {
                document.addEventListener('click', e => {
                    if(!btn.contains(e.target) && !menu.contains(e.target)) menu.classList.add('hidden');
                });
                btn.addEventListener('click', e => {
                    e.preventDefault();
                    menu.classList.toggle('hidden');
                });
            }
        })();
    </script>
</body>
</html>
