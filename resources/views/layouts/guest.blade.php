<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Clary') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50 dark:bg-midnight-900 selection:bg-accent-500 selection:text-white">

    <div class="mb-6 text-center">
        <a href="/" class="flex flex-col items-center gap-2 group">
            <div class="w-12 h-12 rounded-lg bg-accent-600 flex items-center justify-center text-white font-bold text-2xl shadow-lg shadow-accent-500/20 group-hover:scale-105 transition-transform duration-300">
                C
            </div>
            <span class="text-xl font-bold text-gray-900 dark:text-white tracking-tight">Clary</span>
        </a>
    </div>

    <div class="w-full sm:max-w-md px-8 py-8 bg-white dark:bg-midnight-800 border border-gray-200 dark:border-line shadow-xl rounded-2xl overflow-hidden">
        {{ $slot }}
    </div>

    <div class="mt-6 text-center text-xs text-gray-400 dark:text-gray-500">
        &copy; {{ date('Y') }} Clary App. All rights reserved.
    </div>
</div>
</body>
</html>
