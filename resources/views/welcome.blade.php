<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Clary') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Smooth floating for bottom cards */
        @keyframes float {
            0% { transform: translateY(0px) rotate(var(--tw-rotate)); }
            50% { transform: translateY(-10px) rotate(var(--tw-rotate)); }
            100% { transform: translateY(0px) rotate(var(--tw-rotate)); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        /* Chaotic floating for Background Icons */
        @keyframes float-around {
            0% { transform: translate(0, 0) scale(1) rotate(0deg); }
            25% { transform: translate(20px, -20px) scale(1.05) rotate(5deg); }
            50% { transform: translate(-15px, 15px) scale(0.95) rotate(-5deg); }
            75% { transform: translate(15px, 20px) scale(1.02) rotate(3deg); }
            100% { transform: translate(0, 0) scale(1) rotate(0deg); }
        }
        .animate-float-around {
            animation: float-around infinite ease-in-out alternate;
        }
    </style>
</head>
<body class="bg-[#FAF9F6] dark:bg-midnight-900 text-gray-800 dark:text-gray-100 font-sans antialiased h-screen w-full overflow-hidden relative selection:bg-accent-500 selection:text-white transition-colors duration-300">

<div class="absolute inset-0 -z-30 h-full w-full bg-[size:14px_24px]
            bg-[#FAF9F6] dark:bg-midnight-900
            bg-[linear-gradient(to_right,#80808015_1px,transparent_1px),linear-gradient(to_bottom,#80808015_1px,transparent_1px)]
            dark:bg-[linear-gradient(to_right,#ffffff08_1px,transparent_1px),linear-gradient(to_bottom,#ffffff08_1px,transparent_1px)]
            transition-colors duration-300">
</div>

<div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">

    <div class="absolute top-[10%] left-[8%] text-blue-500/50 dark:text-blue-400/40 animate-float-around" style="animation-duration: 25s;">
        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
    </div>

    <div class="absolute top-[15%] right-[12%] text-yellow-500/50 dark:text-yellow-400/40 animate-float-around" style="animation-delay: 5s; animation-duration: 28s;">
        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
    </div>

    <div class="absolute bottom-[15%] left-[10%] text-green-500/50 dark:text-green-400/40 animate-float-around" style="animation-delay: 2s; animation-duration: 32s;">
        <svg class="w-14 h-14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
    </div>

    <div class="absolute bottom-[20%] right-[15%] text-purple-500/50 dark:text-purple-400/40 animate-float-around" style="animation-delay: 8s; animation-duration: 24s;">
        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
    </div>

    <div class="absolute top-[45%] left-[15%] text-pink-500/60 dark:text-pink-400/50 animate-float-around" style="animation-delay: 12s; animation-duration: 35s;">
        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
    </div>

    <div class="absolute top-[50%] right-[15%] text-orange-500/60 dark:text-orange-400/50 animate-float-around" style="animation-delay: 15s; animation-duration: 29s;">
        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" /></svg>
    </div>

    <div class="absolute top-[8%] left-[45%] text-gray-400/50 dark:text-gray-500/40 animate-float-around" style="animation-delay: 3s; animation-duration: 40s;">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
    </div>
</div>


<div class="absolute top-8 right-8 z-50 flex items-center gap-4">
    <button id="themeToggle" class="p-2 rounded-full bg-white dark:bg-midnight-800 border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:text-accent-600 dark:hover:text-accent-400 shadow-sm transition-all hover:scale-105">
        <svg id="themeIcon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"></svg>
    </button>

    @if (Route::has('login'))
        @auth
            <div class="flex items-center gap-4 animate-fade-in-down">
                        <span class="text-gray-500 dark:text-gray-400 font-medium hidden sm:inline-block">
                            Hey, <span class="font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                        </span>
                <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-black dark:bg-white text-white dark:text-black text-sm font-semibold rounded-full hover:bg-gray-800 dark:hover:bg-gray-200 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center">
                    Dashboard
                    <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        @else
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-medium hover:text-black dark:hover:text-white transition-colors">
                    Sign in
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-6 py-2.5 bg-white dark:bg-midnight-800 border-2 border-black dark:border-white text-black dark:text-white text-sm font-bold rounded-full hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-all shadow-sm hover:shadow-lg">
                        Sign up
                    </a>
                @endif
            </div>
        @endauth
    @endif
</div>

<main class="h-full flex flex-col items-center justify-center relative pb-20 z-10">

    <div class="relative w-[30rem] h-[30rem] md:w-[38rem] md:h-[38rem] rounded-full
                        border border-white/40 dark:border-white/10
                        flex flex-col items-center justify-center
                        bg-gradient-to-b from-white to-gray-50 dark:from-midnight-800 dark:to-midnight-900
                        shadow-2xl z-20 overflow-hidden transition-all duration-300">

        <div class="absolute -top-[5%] left-1/2 -translate-x-1/2 w-[60%] h-[35%] bg-gradient-to-b from-white/90 to-transparent dark:from-blue-100/20 dark:to-transparent rounded-[100%] blur-xl opacity-80 pointer-events-none z-20"></div>

        <div class="absolute inset-0 rounded-full border-t border-white/80 dark:border-white/20 shadow-[inset_0_4px_20px_rgba(255,255,255,0.5)] dark:shadow-[inset_0_4px_20px_rgba(255,255,255,0.05)] pointer-events-none z-20"></div>

        <div class="absolute -bottom-[10%] left-1/2 -translate-x-1/2 w-[80%] h-[30%] bg-blue-100/30 dark:bg-blue-900/10 blur-3xl rounded-[100%] pointer-events-none z-0"></div>

        <h1 class="text-8xl md:text-9xl font-bold tracking-tighter text-gray-900 dark:text-white mb-2 mt-4 relative z-30 drop-shadow-sm">
            Clary
        </h1>

        <p class="text-lg md:text-xl text-gray-500 dark:text-gray-400 font-light mt-4 max-w-md text-center px-4 relative z-30">
            The clearest way to manage your agency projects & clients.
        </p>

    </div>

    <div class="absolute bottom-[-2%] md:bottom-[8%] flex items-center justify-center gap-6 md:gap-12 z-40 pointer-events-none w-full">

        <div class="w-32 h-32 md:w-44 md:h-44 bg-white/90 dark:bg-midnight-800/90 backdrop-blur-sm rounded-2xl border border-white/50 dark:border-gray-700 shadow-xl transform -rotate-12 flex flex-col items-center justify-center p-4 animate-float transition-colors duration-300" style="--tw-rotate: -12deg; animation-delay: 0s;">
            <div class="p-3 bg-purple-50 dark:bg-purple-900/30 rounded-full mb-2">
                <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
            <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Clients</span>
        </div>

        <div class="w-40 h-40 md:w-52 md:h-52 bg-white dark:bg-midnight-800 rounded-2xl border-2 border-gray-900 dark:border-gray-500 shadow-2xl transform rotate-6 flex flex-col items-center justify-center p-6 relative -top-10 animate-float transition-colors duration-300" style="--tw-rotate: 6deg; animation-delay: 1s;">
            <div class="text-center">
                <span class="text-5xl font-bold text-gray-900 dark:text-white block">10x</span>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-2 block">Faster Workflow</span>
            </div>
        </div>

        <div class="w-32 h-32 md:w-44 md:h-44 bg-white/90 dark:bg-midnight-800/90 backdrop-blur-sm rounded-2xl border border-white/50 dark:border-gray-700 shadow-xl transform rotate-[20deg] flex flex-col items-center justify-center p-4 animate-float transition-colors duration-300" style="--tw-rotate: 20deg; animation-delay: 2s;">
            <div class="p-3 bg-green-50 dark:bg-green-900/30 rounded-full mb-2">
                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Approved</span>
        </div>

    </div>

</main>

<script>
    (function() {
        const root = document.documentElement;
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');

        function isSystemDark() {
            return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        }

        function applyTheme(theme) {
            if (theme === 'dark') {
                root.classList.add('dark');
                themeIcon.innerHTML = '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 3v1m0 16v1m8.66-10h-1M4.34 12h-1M18.36 6.64l-.7.7M6.34 18.66l-.7.7M18.36 17.36l-.7-.7M6.34 5.34l-.7-.7\"/>';
            } else {
                root.classList.remove('dark');
                themeIcon.innerHTML = '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z\"/>';
            }
        }

        const stored = localStorage.getItem('theme');
        const initial = stored ? stored : (isSystemDark() ? 'dark' : 'light');
        applyTheme(initial);

        themeToggle.addEventListener('click', function() {
            const current = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
            const next = current === 'dark' ? 'light' : 'dark';
            localStorage.setItem('theme', next);
            applyTheme(next);
        });
    })();
</script>
</body>
</html>
