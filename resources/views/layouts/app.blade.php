@php
    use App\Models\Client;
    use Illuminate\Support\Facades\Auth;

    $tagCounts = [];

    if (Auth::check()) {
        // LOGIC: Super Admin sees ALL, Agency Admin sees THEIR OWN
        if (Auth::user()->role === 'super_admin') {
            $clients = Client::all();
        } else {
            $clients = Client::where('user_id', Auth::id())->get();
        }

        $allTags = [];
        foreach ($clients as $client) {
            $tags = is_string($client->tags) ? json_decode($client->tags, true) : ($client->tags ?? []);

            if (is_array($tags)) {
                foreach ($tags as $tag) {
                    $allTags[] = trim($tag);
                }
            }
        }

        $tagCounts = array_count_values($allTags);
        arsort($tagCounts);
        $tagCounts = array_slice($tagCounts, 0, 5);
    }

    // Visual colors
    $colors = [
        ['bg' => 'bg-purple-500', 'shadow' => 'rgba(168,85,247,0.4)'],
        ['bg' => 'bg-green-500',  'shadow' => 'rgba(34,197,94,0.4)'],
        ['bg' => 'bg-blue-500',   'shadow' => 'rgba(59,130,246,0.4)'],
        ['bg' => 'bg-orange-500', 'shadow' => 'rgba(249,115,22,0.4)'],
        ['bg' => 'bg-pink-500',   'shadow' => 'rgba(236,72,153,0.4)'],
    ];
@endphp

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Clary') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-midnight-900 text-gray-600 dark:text-gray-400 font-sans antialiased h-screen flex overflow-hidden transition-colors duration-300">

<aside class="w-64 flex flex-col border-r border-gray-200 dark:border-line bg-white dark:bg-midnight-900 flex-shrink-0 transition-colors duration-300">
    <div class="h-16 flex items-center px-6 border-b border-gray-200 dark:border-line transition-colors duration-300">
        <div class="w-8 h-8 rounded bg-accent-600 flex items-center justify-center text-white font-bold mr-3 shadow-lg shadow-accent-500/30">
            C
        </div>
        <span class="text-gray-900 dark:text-gray-100 font-semibold tracking-wide">Clary</span>
    </div>

    <nav class="flex-1 overflow-y-auto py-6 px-3 flex flex-col">
        <div class="space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('dashboard') ? 'bg-gray-100 dark:bg-midnight-800 text-accent-600 dark:text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-midnight-800 hover:text-gray-900 dark:hover:text-white' }}">
                <svg class="mr-3 h-5 w-5 flex-shrink-0 {{ request()->routeIs('dashboard') ? 'text-accent-600 dark:text-white' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Dashboard
            </a>

            <a href="{{ route('clients.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('clients.*') ? 'bg-gray-100 dark:bg-midnight-800 text-accent-600 dark:text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-midnight-800 hover:text-gray-900 dark:hover:text-white' }}">
                <svg class="mr-3 h-5 w-5 flex-shrink-0 {{ request()->routeIs('clients.*') ? 'text-accent-600 dark:text-white' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Clients
            </a>

            <a href="{{ route('projects.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('projects.*') ? 'bg-gray-100 dark:bg-midnight-800 text-accent-600 dark:text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-midnight-800 hover:text-gray-900 dark:hover:text-white' }}">
                <svg class="mr-3 h-5 w-5 flex-shrink-0 {{ request()->routeIs('projects.*') ? 'text-accent-600 dark:text-white' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
                Projects
            </a>

            <a href="{{ route('tasks.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('tasks.*') ? 'bg-gray-100 dark:bg-midnight-800 text-accent-600 dark:text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-midnight-800 hover:text-gray-900 dark:hover:text-white' }}">
                <svg class="mr-3 h-5 w-5 flex-shrink-0 {{ request()->routeIs('tasks.*') ? 'text-accent-600 dark:text-white' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Tasks
            </a>

            <a href="{{ route('invoices.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('invoices.*') ? 'bg-gray-100 dark:bg-midnight-800 text-accent-600 dark:text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-midnight-800 hover:text-gray-900 dark:hover:text-white' }}">
                <svg class="mr-3 h-5 w-5 flex-shrink-0 {{ request()->routeIs('invoices.*') ? 'text-accent-600 dark:text-white' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Invoices
            </a>
        </div>

        <div class="mt-8 px-3">
            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-500 uppercase tracking-wider mb-3 px-3">Tags</h3>
            <div class="space-y-1">
                @if(count($tagCounts) > 0)
                    @foreach($tagCounts as $tagName => $count)
                        @php
                            $style = $colors[$loop->index % count($colors)];
                            $isActive = request('tag') == $tagName;
                        @endphp
                        <a href="{{ route('clients.index', ['tag' => $tagName]) }}" class="flex items-center justify-between px-3 py-1.5 rounded-md transition-colors hover:bg-gray-100 dark:hover:bg-midnight-800 group {{ $isActive ? 'bg-gray-100 dark:bg-midnight-800 ring-1 ring-accent-500' : '' }}">
                            <div class="flex items-center">
                                <span class="w-2 h-2 rounded-full {{ $style['bg'] }} mr-3" style="box-shadow: 0 0 8px {{ $style['shadow'] }}"></span>
                                <span class="text-sm text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white truncate max-w-[120px]">{{ $tagName }}</span>
                            </div>
                            <span class="text-xs text-gray-500 dark:text-gray-600">{{ $count }}</span>
                        </a>
                    @endforeach
                @else
                    <div class="px-3 text-xs text-gray-500 dark:text-gray-600 italic">
                        No tags found.<br>Create clients to see tags here.
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <div class="p-4 border-t border-gray-200 dark:border-line transition-colors duration-300">
        <a href="{{ route('profile.edit') }}" class="flex items-center group">
            <div class="h-9 w-9 rounded-full bg-gradient-to-tr from-accent-600 to-blue-500 flex items-center justify-center text-white font-bold text-sm shadow-md group-hover:ring-2 group-hover:ring-accent-500 transition-all">
                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-accent-500 transition-colors">
                    {{ Auth::user()->name ?? 'User' }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 capitalize">
                    {{-- Converts "super_admin" to "Super Admin" --}}
                    {{ str_replace('_', ' ', Auth::user()->role) }}
                </p>
            </div>
        </a>
    </div>
</aside>

<main class="flex-1 flex flex-col min-w-0 bg-gray-50 dark:bg-midnight-900 transition-colors duration-300 overflow-hidden">

    <header class="h-16 border-b border-gray-200 dark:border-line flex items-center justify-between px-8 bg-white dark:bg-midnight-900 flex-shrink-0 transition-colors duration-300">
        <div class="flex-1 max-w-lg">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" class="w-full bg-gray-100 dark:bg-midnight-800 text-gray-900 dark:text-gray-200 border-none rounded-md py-2 pl-10 placeholder-gray-500 focus:ring-1 focus:ring-accent-500 text-sm transition-colors duration-300" placeholder="Search across projects, clients...">
            </div>
        </div>

        <div class="ml-6 flex items-center space-x-4">
            <button id="notificationsBtn" class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-white transition-colors relative">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white dark:ring-midnight-900"></span>
            </button>

            <button id="themeToggle" class="flex items-center px-2 py-1 bg-gray-100 dark:bg-midnight-800 rounded text-gray-500 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors" title="Toggle theme">
                <svg id="themeIcon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                </svg>
            </button>

            <div class="relative">
                <button id="userMenuBtn" class="flex items-center text-sm focus:outline-none">
                    <div class="h-9 w-9 rounded-full bg-gradient-to-tr from-accent-600 to-blue-500 flex items-center justify-center text-white font-bold text-sm shadow-md">
                        {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                    </div>
                    <svg class="ml-2 h-4 w-4 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-midnight-800 border border-gray-200 dark:border-line rounded-md shadow-lg py-1 z-20 transition-all">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-midnight-700">Profile</a>

                    <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-midnight-700">Logout</button>
                    </form>
                </div>
            </div>

        </div>
    </header>

    <div class="flex-1 flex flex-col min-h-0 overflow-hidden">
        {{ $slot }}
    </div>

</main>

<script>
    // Theme Logic
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

    // User Menu Logic
    (function() {
        const btn = document.getElementById('userMenuBtn');
        const menu = document.getElementById('userMenu');

        document.addEventListener('click', function(e) {
            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        btn.addEventListener('click', function(e) {
            e.preventDefault();
            menu.classList.toggle('hidden');
        });
    })();
</script>

</body>
</html>
