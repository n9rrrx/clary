<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Clary Portal') }}</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-midnight-900 text-gray-900 dark:text-gray-100 font-sans antialiased min-h-screen flex flex-col">

<nav class="bg-white dark:bg-midnight-800 border-b border-gray-200 dark:border-line">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded bg-accent-600 flex items-center justify-center text-white font-bold mr-3">C</div>
                <span class="font-bold text-lg tracking-tight">Clary <span class="text-accent-500 font-normal">Portal</span></span>
            </div>

            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-500 dark:text-gray-400">Welcome, {{ Auth::user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:text-red-500 transition-colors">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">
    {{ $slot }}
</main>

<footer class="border-t border-gray-200 dark:border-line bg-white dark:bg-midnight-800 py-6">
    <div class="max-w-7xl mx-auto px-4 text-center text-xs text-gray-500">
        &copy; {{ date('Y') }} Clary. Client Access Portal.
    </div>
</footer>
</body>
</html>
