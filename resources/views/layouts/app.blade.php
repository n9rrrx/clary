@php
    /**
     * ATLASSIAN-STYLE MULTI-TENANCY LOGIC
     * Tags from both Team Members (Users) and Clients
     */
    use App\Models\Client;
    use App\Models\User;
    use App\Models\Team;
    use Illuminate\Support\Facades\Auth;

    $teamMemberTags = [];
    $clientTags = [];
    $allTags = [];

    if (Auth::check()) {
        $user = Auth::user();
        $team = $user->currentTeam;

        if ($team) {
            // Get tags from team members
            $members = $team->members;
            foreach ($members as $member) {
                $memberTagsArray = is_string($member->tags) ? json_decode($member->tags, true) : ($member->tags ?? []);
                if (is_array($memberTagsArray)) {
                    foreach ($memberTagsArray as $tag) {
                        $tag = trim($tag);
                        if ($tag) {
                            $teamMemberTags[$tag] = ($teamMemberTags[$tag] ?? 0) + 1;
                            $allTags[$tag] = ($allTags[$tag] ?? 0) + 1;
                        }
                    }
                }
            }

            // Get tags from clients
            $clients = $team->clients;
            foreach ($clients as $client) {
                $clientTagsArray = is_string($client->tags) ? json_decode($client->tags, true) : ($client->tags ?? []);
                if (is_array($clientTagsArray)) {
                    foreach ($clientTagsArray as $tag) {
                        $tag = trim($tag);
                        if ($tag) {
                            $clientTags[$tag] = ($clientTags[$tag] ?? 0) + 1;
                            $allTags[$tag] = ($allTags[$tag] ?? 0) + 1;
                        }
                    }
                }
            }
        }

        // Sort by count and limit
        arsort($allTags);
        $tagCounts = array_slice($allTags, 0, 10, true);
    } else {
        $tagCounts = [];
    }

    $colors = [
        ['bg' => 'bg-purple-500', 'shadow' => 'rgba(168,85,247,0.4)'],
        ['bg' => 'bg-green-500',  'shadow' => 'rgba(34,197,94,0.4)'],
        ['bg' => 'bg-blue-500',   'shadow' => 'rgba(59,130,246,0.4)'],
        ['bg' => 'bg-orange-500', 'shadow' => 'rgba(249,115,22,0.4)'],
        ['bg' => 'bg-pink-500',   'shadow' => 'rgba(236,72,153,0.4)'],
        ['bg' => 'bg-cyan-500',   'shadow' => 'rgba(6,182,212,0.4)'],
        ['bg' => 'bg-amber-500',  'shadow' => 'rgba(245,158,11,0.4)'],
        ['bg' => 'bg-indigo-500', 'shadow' => 'rgba(99,102,241,0.4)'],
        ['bg' => 'bg-rose-500',   'shadow' => 'rgba(244,63,94,0.4)'],
        ['bg' => 'bg-teal-500',   'shadow' => 'rgba(20,184,166,0.4)'],
    ];
@endphp

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Clary') }}</title>
    <link rel="icon" type="image/svg+xml" href="/logos/logo-clary-spider.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Smooth Sidebar Transitions */
        #sidebar { transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .sidebar-text { transition: opacity 0.2s ease-in-out; opacity: 1; white-space: nowrap; }
        #sidebar.collapsed .sidebar-text { opacity: 0; display: none; }
        #sidebar.collapsed .sidebar-header { padding-left: 0; padding-right: 0; justify-content: center; }
        #sidebar.collapsed #sidebarToggleBtn { display: none; }
        #sidebar.collapsed #logo-link { justify-content: center; width: 100%; }
        #sidebar.collapsed .nav-item { justify-content: center; padding-left: 0; padding-right: 0; }
        #sidebar.collapsed .sidebar-footer { padding: 10px 0; justify-content: center; }
        .nav-tooltip { display: none; opacity: 0; transition: opacity 0.2s; }
        #sidebar.collapsed .nav-item:hover .nav-tooltip { display: block; opacity: 1; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-midnight-900 text-gray-600 dark:text-gray-400 font-sans antialiased h-screen flex overflow-hidden transition-colors duration-300">

<aside id="sidebar" class="w-64 flex flex-col border-r border-gray-200 dark:border-line bg-white dark:bg-midnight-900 flex-shrink-0 relative z-20">

    <div class="sidebar-header h-16 flex items-center justify-between px-4 border-b border-gray-200 dark:border-line transition-all duration-300 overflow-hidden">
        <a href="{{ route('dashboard') }}" id="logo-link" class="flex items-center gap-3 overflow-hidden group focus:outline-none w-full">
            <div id="logo-container" class="w-8 h-8 flex-shrink-0 transition-all duration-200 group-hover:scale-110">
                <img src="/logos/logo-clary-spider.svg" alt="Clary" class="w-full h-full drop-shadow-lg">
            </div>
            <span class="sidebar-text font-semibold tracking-wide text-gray-900 dark:text-gray-100 whitespace-nowrap">Clary</span>
        </a>
        <button id="sidebarToggleBtn" class="sidebar-text p-1 rounded-md text-gray-400 hover:text-gray-600 dark:hover:text-white transition-colors focus:outline-none ml-auto">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto overflow-x-hidden py-6 px-3 flex flex-col space-y-1 scrollbar-hide">

        <a href="{{ route('dashboard') }}" class="nav-item group relative flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:bg-blue-600/10 hover:text-blue-600 dark:hover:text-blue-400' }}">
            <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
            <span class="sidebar-text ml-3">Dashboard</span>
            <div class="nav-tooltip fixed left-16 bg-gray-900 text-white text-xs px-2 py-1 rounded shadow-lg z-50 whitespace-nowrap ml-2">Dashboard</div>
        </a>

        @if(Auth::user()->isOwnerOfCurrentTeam())
            <a href="{{ route('team.index') }}" class="nav-item group relative flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('team.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:bg-blue-600/10 hover:text-blue-600 dark:hover:text-blue-400' }}">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                <span class="sidebar-text ml-3">User Management</span>
                <div class="nav-tooltip fixed left-16 bg-gray-900 text-white text-xs px-2 py-1 rounded shadow-lg z-50 whitespace-nowrap ml-2">User Management</div>
            </a>
            <a href="{{ route('people.index') }}" class="nav-item group relative flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('people.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:bg-blue-600/10 hover:text-blue-600 dark:hover:text-blue-400' }}">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                <span class="sidebar-text ml-3">People</span>
                <div class="nav-tooltip fixed left-16 bg-gray-900 text-white text-xs px-2 py-1 rounded shadow-lg z-50 whitespace-nowrap ml-2">People</div>
            </a>
            <a href="{{ route('subscription.manage') }}" class="nav-item group relative flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('subscription.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:bg-blue-600/10 hover:text-blue-600 dark:hover:text-blue-400' }}">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                <span class="sidebar-text ml-3">Subscription</span>
                <div class="nav-tooltip fixed left-16 bg-gray-900 text-white text-xs px-2 py-1 rounded shadow-lg z-50 whitespace-nowrap ml-2">Subscription</div>
            </a>
        @endif

        @can('view-projects')
            <a href="{{ route('projects.index') }}" class="nav-item group relative flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('projects.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:bg-blue-600/10 hover:text-blue-600 dark:hover:text-blue-400' }}">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
                <span class="sidebar-text ml-3">Projects</span>
                <div class="nav-tooltip fixed left-16 bg-gray-900 text-white text-xs px-2 py-1 rounded shadow-lg z-50 whitespace-nowrap ml-2">Projects</div>
            </a>
        @endcan

        @if(Auth::user()->isOwnerOfCurrentTeam())
            <a href="{{ route('clients.index') }}" class="nav-item group relative flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('clients.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:bg-blue-600/10 hover:text-blue-600 dark:hover:text-blue-400' }}">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                <span class="sidebar-text ml-3">Clients</span>
                <div class="nav-tooltip fixed left-16 bg-gray-900 text-white text-xs px-2 py-1 rounded shadow-lg z-50 whitespace-nowrap ml-2">Clients</div>
            </a>
        @endif

        @can('view-tasks')
            <a href="{{ route('tasks.index') }}" class="nav-item group relative flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('tasks.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:bg-blue-600/10 hover:text-blue-600 dark:hover:text-blue-400' }}">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                <span class="sidebar-text ml-3">Tasks</span>
                <div class="nav-tooltip fixed left-16 bg-gray-900 text-white text-xs px-2 py-1 rounded shadow-lg z-50 whitespace-nowrap ml-2">Tasks</div>
            </a>
        @endcan

        @can('view-invoices')
            <a href="{{ route('invoices.index') }}" class="nav-item group relative flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('invoices.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:bg-blue-600/10 hover:text-blue-600 dark:hover:text-blue-400' }}">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                <span class="sidebar-text ml-3">Invoices</span>
                <div class="nav-tooltip fixed left-16 bg-gray-900 text-white text-xs px-2 py-1 rounded shadow-lg z-50 whitespace-nowrap ml-2">Invoices</div>
            </a>
        @endcan

        <div class="mt-8">
            <h3 class="sidebar-text px-3 text-xs font-semibold text-gray-500 dark:text-gray-500 uppercase tracking-wider mb-3 whitespace-nowrap">Tags</h3>
            <div class="space-y-1">
                @if(count($tagCounts) > 0)
                    @foreach($tagCounts as $tagName => $count)
                        @php
                            $style = $colors[$loop->index % count($colors)];
                            $isActive = request('tag') == $tagName;
                            // Determine if this is a client tag or people tag
                            $isClientTag = isset($clientTags[$tagName]);
                            $isPeopleTag = isset($teamMemberTags[$tagName]);
                            // Route to clients if it's only a client tag, otherwise people
                            $tagRoute = ($isClientTag && !$isPeopleTag) ? route('clients.index', ['tag' => $tagName]) : route('people.index', ['tag' => $tagName]);
                        @endphp
                        <a href="{{ $tagRoute }}" class="nav-item group relative flex items-center px-3 py-1.5 rounded-md transition-colors {{ $isActive ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 ring-1 ring-blue-500' : 'hover:bg-blue-600/10 hover:text-blue-600 dark:hover:text-blue-400 text-gray-600 dark:text-gray-400' }}">
                            <div class="flex items-center justify-center flex-shrink-0 w-5 h-5">
                                <span class="w-2.5 h-2.5 rounded-full {{ $style['bg'] }}" style="box-shadow: 0 0 8px {{ $style['shadow'] }}"></span>
                            </div>
                            <div class="sidebar-text ml-3 flex-1 flex justify-between items-center overflow-hidden">
                                <span class="text-sm truncate group-hover:text-blue-600 dark:group-hover:text-blue-400">{{ $tagName }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-600 group-hover:text-blue-500">{{ $count }}</span>
                            </div>
                            <div class="nav-tooltip fixed left-16 bg-gray-900 text-white text-xs px-2 py-1 rounded shadow-lg z-50 whitespace-nowrap ml-2">{{ $tagName }}{{ $isClientTag ? ' (Client)' : '' }}</div>
                        </a>
                    @endforeach
                @else
                    <div class="sidebar-text px-3 text-xs text-gray-500 dark:text-gray-600 italic whitespace-nowrap overflow-hidden">No tags found.</div>
                @endif
            </div>
        </div>
    </nav>

    <div class="sidebar-footer p-4 border-t border-gray-200 dark:border-line transition-all duration-300">
        <a href="{{ route('profile.edit') }}" class="nav-item flex items-center group relative p-1 rounded hover:bg-blue-600/10 transition-colors">
            <div class="h-9 w-9 flex-shrink-0 rounded-full bg-gradient-to-tr from-accent-600 to-blue-500 flex items-center justify-center text-white font-bold text-sm shadow-md group-hover:ring-2 group-hover:ring-blue-500 transition-all">
                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
            </div>
            <div class="sidebar-text ml-3 overflow-hidden whitespace-nowrap">
                <p class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors truncate">{{ Auth::user()->name ?? 'User' }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 capitalize truncate">{{ str_replace('_', ' ', Auth::user()->role ?? 'Guest') }}</p>
            </div>
            <div class="nav-tooltip fixed left-16 bg-gray-900 text-white text-xs px-2 py-1 rounded shadow-lg z-50 whitespace-nowrap ml-2">Profile</div>
        </a>
    </div>
</aside>

<main class="flex-1 flex flex-col min-w-0 bg-gray-50 dark:bg-midnight-900 transition-colors duration-300 overflow-hidden">
    <header class="h-16 border-b border-gray-200 dark:border-line flex items-center justify-between px-8 bg-white dark:bg-midnight-900 flex-shrink-0 transition-colors duration-300">
        <div class="flex-1 max-w-lg">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </span>
                <input type="text" class="w-full bg-gray-100 dark:bg-midnight-800 text-gray-900 dark:text-gray-200 border-none rounded-md py-2 pl-10 placeholder-gray-500 focus:ring-1 focus:ring-accent-500 text-sm transition-colors duration-300" placeholder="Search...">
            </div>
        </div>
        <div class="ml-6 flex items-center space-x-4">
            <button id="notificationsBtn" class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-white transition-colors relative">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white dark:ring-midnight-900"></span>
            </button>
            <button id="themeToggle" class="flex items-center px-2 py-1 bg-gray-100 dark:bg-midnight-800 rounded text-gray-500 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                <svg id="themeIcon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"></svg>
            </button>
            <div class="relative">
                <button id="userMenuBtn" class="flex items-center text-sm focus:outline-none">
                    <div class="h-9 w-9 rounded-full bg-gradient-to-tr from-accent-600 to-blue-500 flex items-center justify-center text-white font-bold text-sm shadow-md">
                        {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                    </div>
                </button>
                <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-midnight-800 border border-gray-200 dark:border-line rounded-md shadow-lg py-1 z-50">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-midnight-700">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-midnight-700">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="flex-1 flex flex-col min-h-0 overflow-y-auto">
        {{ $slot }}
    </div>

</main>

<script>
    (function() {
        const sidebar = document.getElementById('sidebar');
        const logoLink = document.getElementById('logo-link');
        const toggleBtn = document.getElementById('sidebarToggleBtn');
        const expandedClass = 'w-64';
        const collapsedClass = 'w-20';
        function toggleSidebar() {
            const collapsed = sidebar.classList.toggle('collapsed');
            if (collapsed) { sidebar.classList.remove(expandedClass); sidebar.classList.add(collapsedClass); }
            else { sidebar.classList.remove(collapsedClass); sidebar.classList.add(expandedClass); }
            localStorage.setItem('sidebar-collapsed', collapsed);
        }
        logoLink.addEventListener('click', (e) => { if (sidebar.classList.contains('collapsed')) { e.preventDefault(); toggleSidebar(); } });
        toggleBtn.addEventListener('click', (e) => { e.preventDefault(); toggleSidebar(); });
        const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
        if (isCollapsed) { sidebar.classList.add('collapsed', collapsedClass); sidebar.classList.remove(expandedClass); }
    })();
    (function() {
        const root = document.documentElement;
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
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
        const initial = stored ? stored : (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        applyTheme(initial);
        themeToggle.addEventListener('click', function() {
            const next = root.classList.contains('dark') ? 'light' : 'dark';
            localStorage.setItem('theme', next);
            applyTheme(next);
        });
    })();
    (function() {
        const btn = document.getElementById('userMenuBtn');
        const menu = document.getElementById('userMenu');
        document.addEventListener('click', e => { if(!btn.contains(e.target) && !menu.contains(e.target)) menu.classList.add('hidden'); });
        btn.addEventListener('click', e => { e.preventDefault(); menu.classList.toggle('hidden'); });
    })();
</script>
@stack('scripts')
</body>
</html>
