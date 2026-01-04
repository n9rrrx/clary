<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Clary') }} - Crystal Clear Project Management</title>
    <link rel="icon" type="image/svg+xml" href="/logos/logo-clary-spider.svg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --clary-blue: #0066FF;
            --clary-purple: #6B4CE6;
            --clary-mint: #00D9B1;
            --clary-coral: #FF6B6B;
            --clary-amber: #FFB800;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Bricolage Grotesque', sans-serif;
        }

        /* Smooth Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-60px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(60px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        /* Floating path animations for SaaS icons */
        @keyframes floatPath1 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(20px, -30px) rotate(5deg); }
            50% { transform: translate(-10px, -50px) rotate(-3deg); }
            75% { transform: translate(30px, -20px) rotate(2deg); }
        }

        @keyframes floatPath2 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(-25px, 15px) rotate(-5deg); }
            50% { transform: translate(20px, 30px) rotate(3deg); }
            75% { transform: translate(-15px, 10px) rotate(-2deg); }
        }

        @keyframes floatPath3 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(15px, 25px) rotate(8deg); }
            50% { transform: translate(-20px, 15px) rotate(-5deg); }
            75% { transform: translate(10px, -20px) rotate(3deg); }
        }

        @keyframes floatPath4 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(-30px, -15px) rotate(-3deg); }
            50% { transform: translate(15px, -35px) rotate(5deg); }
            75% { transform: translate(-20px, 10px) rotate(-2deg); }
        }

        @keyframes floatPath5 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(25px, 20px) rotate(6deg); }
            50% { transform: translate(-15px, -25px) rotate(-4deg); }
            75% { transform: translate(20px, -10px) rotate(2deg); }
        }

        @keyframes floatPath6 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(-20px, -20px) rotate(-4deg); }
            50% { transform: translate(25px, 10px) rotate(6deg); }
            75% { transform: translate(-10px, 25px) rotate(-3deg); }
        }

        .floating-icon {
            will-change: transform;
            transition: opacity 0.3s ease;
        }

        .floating-icon:hover {
            animation-play-state: paused;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .scroll-reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .scroll-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, var(--clary-blue) 0%, var(--clary-purple) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .dark .gradient-text {
            background: linear-gradient(135deg, #60A5FA 0%, #A78BFA 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* CSS Mockup Styles */
        .mockup-window {
            background: white;
            border-radius: 12px;
            box-shadow:
                0 0 0 1px rgba(74, 144, 226, 0.15),
                0 20px 50px rgba(74, 144, 226, 0.15),
                0 8px 16px rgba(74, 144, 226, 0.12);
            overflow: hidden;
        }

        .dark .mockup-window {
            background: #152238;
            box-shadow:
                0 0 0 1px rgba(74, 144, 226, 0.2),
                0 20px 50px rgba(0,0,0,0.5),
                0 8px 16px rgba(0,0,0,0.3);
        }

        .mockup-header {
            height: 40px;
            background: linear-gradient(180deg, #f5f5f5 0%, #e8e8e8 100%);
            border-bottom: 1px solid #d0d0d0;
            display: flex;
            align-items: center;
            padding: 0 12px;
            gap: 6px;
        }

        .dark .mockup-header {
            background: linear-gradient(180deg, #1a2744 0%, #152238 100%);
            border-bottom: 1px solid #1e3a5f;
        }

        .mockup-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .mockup-dot.red { background: #FF5F56; }
        .mockup-dot.yellow { background: #FFBD2E; }
        .mockup-dot.green { background: #27C93F; }

        .mockup-content {
            padding: 24px;
        }

        /* Task Card Mockup */
        .task-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
        }

        .dark .task-card {
            background: #1a2744;
            border: 1px solid #1e3a5f;
        }

        .task-card:hover {
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(0,102,255,0.1);
        }

        .task-checkbox {
            width: 20px;
            height: 20px;
            border: 2px solid #cbd5e0;
            border-radius: 4px;
            flex-shrink: 0;
        }

        .task-checkbox.checked {
            background: var(--clary-blue);
            border-color: var(--clary-blue);
            position: relative;
        }

        .task-checkbox.checked::after {
            content: '✓';
            position: absolute;
            color: white;
            font-size: 12px;
            top: -2px;
            left: 3px;
        }

        .task-text {
            flex: 1;
            font-size: 14px;
            color: #2d3748;
        }

        .dark .task-text {
            color: #e2e8f0;
        }

        .task-tag {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .task-tag.urgent {
            background: #fee;
            color: #c53030;
        }

        .task-tag.high {
            background: #fff5e6;
            color: #c05621;
        }

        .task-tag.normal {
            background: #e6f7ff;
            color: #0066ff;
        }

        /* Budget Chart Mockup */
        .budget-bar {
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }

        .dark .budget-bar {
            background: #1e3a5f;
        }

        .budget-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--clary-blue), var(--clary-purple));
            border-radius: 4px;
            transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .budget-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .dark .budget-item {
            border-bottom: 1px solid #1e3a5f;
        }

        .budget-item:last-child {
            border-bottom: none;
        }

        /* Bento Grid */
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 16px;
            margin: 0 auto;
        }

        .bento-item {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 24px;
            padding: 32px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .dark .bento-item {
            background: #152238;
            border: 1px solid #1e3a5f;
        }

        .bento-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border-color: var(--clary-blue);
        }

        .bento-large {
            grid-column: span 4;
        }

        .bento-medium {
            grid-column: span 3;
        }

        .bento-small {
            grid-column: span 2;
        }

        @media (max-width: 1024px) {
            .bento-large,
            .bento-medium,
            .bento-small {
                grid-column: span 6;
            }
        }

        /* Stats Counter */
        .stat-number {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1;
            font-family: 'Bricolage Grotesque', sans-serif;
        }

        /* Shimmer Effect */
        .shimmer {
            background: linear-gradient(
                90deg,
                rgba(255,255,255,0) 0%,
                rgba(255,255,255,0.3) 50%,
                rgba(255,255,255,0) 100%
            );
            background-size: 1000px 100%;
            animation: shimmer 3s infinite;
        }

        /* Logo Wall */
        .logo-item {
            opacity: 0.4;
            transition: opacity 0.3s ease;
            filter: grayscale(100%);
        }

        .logo-item:hover {
            opacity: 1;
            filter: grayscale(0%);
        }

        html {
            scroll-behavior: smooth;
        }

        /* Custom Cursor for Premium Feel */
        @media (min-width: 1024px) {
            .cursor-fancy {
                cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="%230066FF" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg>'), auto;
            }
        }

        /* Noise Texture Overlay */
        .noise-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            opacity: 0.03;
            z-index: 100;
            background-image: url('data:image/svg+xml;utf8,<svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg"><filter id="noise"><feTurbulence type="fractalNoise" baseFrequency="0.9" numOctaves="4" stitchTiles="stitch"/></filter><rect width="100%" height="100%" filter="url(%23noise)"/></svg>');
        }
    </style>
</head>
<body class="bg-[#E8F4FD] dark:bg-gradient-to-b dark:from-[#0f1628] dark:to-[#1a2744] text-gray-900 dark:text-gray-100 antialiased overflow-x-hidden transition-colors duration-300">

<!-- Noise Texture -->
<div class="noise-overlay"></div>

<!-- Navigation -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-[#E8F4FD]/90 dark:bg-[#0f1628]/90 backdrop-blur-xl border-b border-blue-200/50 dark:border-blue-900/50">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-[#0066FF] to-[#6B4CE6] rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                    <span class="text-white font-bold text-xl">C</span>
                </div>
                <span class="text-2xl font-bold text-gray-900 dark:text-white" style="font-family: 'Bricolage Grotesque', sans-serif;">Clary</span>
            </div>

            <div class="hidden md:flex items-center gap-8">
                <a href="#features" class="text-gray-600 dark:text-gray-400 hover:text-[#0066FF] dark:hover:text-blue-400 transition-colors font-medium">Features</a>
                <a href="#how-it-works" class="text-gray-600 dark:text-gray-400 hover:text-[#0066FF] dark:hover:text-blue-400 transition-colors font-medium">How it works</a>
                <a href="#pricing" class="text-gray-600 dark:text-gray-400 hover:text-[#0066FF] dark:hover:text-blue-400 transition-colors font-medium">Pricing</a>
            </div>

            <div class="flex items-center gap-4">
                <button id="themeToggle" class="p-2.5 rounded-xl bg-blue-100/50 dark:bg-[#1a2744] border border-blue-200/60 dark:border-blue-800/50 hover:border-[#0066FF] dark:hover:border-blue-500 transition-all">
                    <svg id="themeIcon" class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"></svg>
                </button>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-gradient-to-r from-[#0066FF] to-[#6B4CE6] text-white font-semibold rounded-xl hover:shadow-xl hover:shadow-blue-500/30 transition-all hover:-translate-y-0.5">
                            Dashboard →
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hidden md:inline-block px-4 py-2 text-gray-600 dark:text-gray-400 font-medium hover:text-[#0066FF] transition-colors">
                            Sign in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-2.5 bg-gradient-to-r from-[#0066FF] to-[#6B4CE6] text-white font-semibold rounded-xl hover:shadow-xl hover:shadow-blue-500/30 transition-all hover:-translate-y-0.5">
                                Start Free Trial
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="relative pt-28 pb-16 lg:pt-36 lg:pb-24 px-6 overflow-hidden min-h-[90vh] flex items-center">
    <!-- Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <!-- Large gradient orbs -->
        <div class="absolute -top-40 -left-40 w-[600px] h-[600px] bg-gradient-to-br from-blue-400/40 to-cyan-300/30 dark:from-blue-600/20 dark:to-cyan-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -right-40 w-[500px] h-[500px] bg-gradient-to-bl from-purple-400/30 to-blue-400/20 dark:from-purple-600/15 dark:to-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 left-1/3 w-[400px] h-[400px] bg-gradient-to-tr from-blue-300/30 to-indigo-400/20 dark:from-blue-700/15 dark:to-indigo-600/10 rounded-full blur-3xl"></div>

        <!-- Subtle grid pattern -->
        <div class="absolute inset-0 opacity-[0.02] dark:opacity-[0.03]" style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2240%22 height=%2240%22><rect fill=%22none%22 stroke=%22%230066FF%22 stroke-width=%220.5%22 width=%2240%22 height=%2240%22/></svg>');"></div>

        <!-- Floating SaaS/Finance Icons (Background Layer) -->
        <div class="floating-icons-container absolute inset-0 pointer-events-none z-[1]">
            <!-- Chart Icon - Top Left Area -->
            <div class="floating-icon absolute top-[15%] left-[8%]" style="animation: floatPath1 12s ease-in-out infinite;">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500/70 to-cyan-500/70 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30 backdrop-blur-sm">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>

            <!-- Dollar Icon - Left Middle -->
            <div class="floating-icon absolute top-[45%] left-[3%]" style="animation: floatPath2 14s ease-in-out infinite;">
                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500/70 to-green-500/70 rounded-lg flex items-center justify-center shadow-lg shadow-emerald-500/30 backdrop-blur-sm">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Percentage Icon - Top Right -->
            <div class="floating-icon absolute top-[10%] right-[5%]" style="animation: floatPath3 10s ease-in-out infinite;">
                <div class="w-11 h-11 bg-gradient-to-br from-purple-500/70 to-indigo-500/70 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/30 backdrop-blur-sm">
                    <span class="text-white font-bold text-base">%</span>
                </div>
            </div>

            <!-- Layers Icon - Right Middle -->
            <div class="floating-icon absolute top-[55%] right-[2%]" style="animation: floatPath4 16s ease-in-out infinite;">
                <div class="w-10 h-10 bg-gradient-to-br from-amber-500/70 to-orange-500/70 rounded-lg flex items-center justify-center shadow-lg shadow-amber-500/30 backdrop-blur-sm">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>

            <!-- Lightning Icon - Bottom Left -->
            <div class="floating-icon absolute bottom-[15%] left-[12%]" style="animation: floatPath5 11s ease-in-out infinite;">
                <div class="w-9 h-9 bg-gradient-to-br from-yellow-500/70 to-amber-500/70 rounded-lg flex items-center justify-center shadow-lg shadow-yellow-500/30 backdrop-blur-sm">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            </div>

            <!-- Pie Chart Icon - Bottom Right -->
            <div class="floating-icon absolute bottom-[20%] right-[8%]" style="animation: floatPath6 13s ease-in-out infinite;">
                <div class="w-10 h-10 bg-gradient-to-br from-pink-500/70 to-rose-500/70 rounded-lg flex items-center justify-center shadow-lg shadow-pink-500/30 backdrop-blur-sm">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto relative z-10 w-full">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-8 items-center">

            <!-- Left Content -->
            <div class="text-left animate-fade-in-up">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 pl-3 pr-1 py-1 border-l-2 border-[#0066FF] text-sm font-medium text-[#0066FF] dark:text-blue-400 mb-6 uppercase tracking-wider">
                    <span>Agency Project Management</span>
                </div>

                <!-- Main Heading -->
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold mb-6 tracking-tight leading-[1.1]" style="font-family: 'Bricolage Grotesque', sans-serif;">
                    <span class="text-gray-900 dark:text-white">Manage Projects</span><br/>
                    <span class="gradient-text">With Clarity</span>
                    <span class="gradient-text">By Using Clary</span>
                </h1>

                <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 max-w-xl mb-8 leading-relaxed">
                    The all-in-one workspace for agencies who want to deliver projects on time, on budget, and stress-free. See everything clearly.
                </p>

                <!-- CTA Button -->
                <div class="flex flex-col sm:flex-row items-start gap-4 mb-8">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="group px-8 py-4 bg-gradient-to-r from-[#0066FF] to-[#4F46E5] text-white text-lg font-bold rounded-full hover:shadow-2xl hover:shadow-blue-500/40 transition-all hover:-translate-y-1 flex items-center gap-3">
                            Start a Project
                            <span class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </span>
                        </a>
                    @endif
                </div>

                <!-- Trust Indicators -->
                <div class="flex flex-wrap items-center gap-6 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>14-day free trial</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>No credit card</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Cancel anytime</span>
                    </div>
                </div>
            </div>

            <!-- Right Visual Area -->
            <div class="relative lg:h-[550px] flex items-center justify-center">

                <!-- Central Dashboard Preview -->
                <div class="relative z-10 w-full max-w-md transform lg:rotate-2 hover:rotate-0 transition-transform duration-500">
                    <div class="bg-white dark:bg-[#152238] rounded-2xl shadow-2xl shadow-blue-500/20 dark:shadow-blue-900/40 border border-blue-100 dark:border-blue-800/50 overflow-hidden">
                        <!-- Mini Header -->
                        <div class="bg-gradient-to-r from-[#0066FF] to-[#4F46E5] px-4 py-3 flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-white/30"></div>
                            <div class="w-3 h-3 rounded-full bg-white/30"></div>
                            <div class="w-3 h-3 rounded-full bg-white/30"></div>
                            <span class="ml-2 text-white/80 text-xs font-medium">Clary Dashboard</span>
                        </div>
                        <!-- Content -->
                        <div class="p-5">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <div class="text-sm font-bold text-gray-900 dark:text-white">Active Projects</div>
                                    <div class="text-2xl font-extrabold text-[#0066FF]">12</div>
                                </div>
                                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                </div>
                            </div>
                            <!-- Progress bars -->
                            <div class="space-y-3">
                                <div>
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-gray-600 dark:text-gray-400">Brand Redesign</span>
                                        <span class="text-green-500 font-medium">85%</span>
                                    </div>
                                    <div class="h-2 bg-gray-100 dark:bg-blue-900/30 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-green-400 to-emerald-500 rounded-full" style="width: 85%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-gray-600 dark:text-gray-400">Website Launch</span>
                                        <span class="text-blue-500 font-medium">62%</span>
                                    </div>
                                    <div class="h-2 bg-gray-100 dark:bg-blue-900/30 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-blue-400 to-indigo-500 rounded-full" style="width: 62%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-gray-600 dark:text-gray-400">Mobile App</span>
                                        <span class="text-purple-500 font-medium">45%</span>
                                    </div>
                                    <div class="h-2 bg-gray-100 dark:bg-blue-900/30 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-purple-400 to-pink-500 rounded-full" style="width: 45%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floating Icon Cards -->
                <!-- Task Card - Top Left -->
                <div class="absolute top-0 left-0 lg:-left-8 bg-white dark:bg-[#1a2744] p-4 rounded-2xl shadow-xl shadow-blue-500/10 border border-blue-100 dark:border-blue-800/50 animate-float z-20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-red-500 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-gray-900 dark:text-white">Tasks Done</div>
                            <div class="text-lg font-extrabold text-orange-500">247</div>
                        </div>
                    </div>
                </div>

                <!-- Team Card - Top Right -->
                <div class="absolute top-8 right-0 lg:-right-4 bg-white dark:bg-[#1a2744] p-4 rounded-2xl shadow-xl shadow-blue-500/10 border border-blue-100 dark:border-blue-800/50 animate-float z-20" style="animation-delay: 1s;">
                    <div class="flex items-center gap-3">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-500 to-rose-500 border-2 border-white dark:border-[#1a2744]"></div>
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 border-2 border-white dark:border-[#1a2744]"></div>
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-500 to-emerald-500 border-2 border-white dark:border-[#1a2744]"></div>
                        </div>
                        <div class="text-xs font-medium text-gray-600 dark:text-gray-400">+24 team</div>
                    </div>
                </div>

                <!-- Budget Card - Bottom Left -->
                <div class="absolute bottom-20 left-4 lg:-left-4 bg-white dark:bg-[#1a2744] p-4 rounded-2xl shadow-xl shadow-blue-500/10 border border-blue-100 dark:border-blue-800/50 animate-float z-20" style="animation-delay: 2s;">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-green-500 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-gray-900 dark:text-white">Revenue</div>
                            <div class="text-lg font-extrabold text-emerald-500">$127K</div>
                        </div>
                    </div>
                </div>

                <!-- Notification Card - Bottom Right -->
                <div class="absolute bottom-4 right-8 lg:right-0 bg-white dark:bg-[#1a2744] p-3 rounded-2xl shadow-xl shadow-blue-500/10 border border-blue-100 dark:border-blue-800/50 animate-float z-20" style="animation-delay: 1.5s;">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        </div>
                        <div class="text-xs">
                            <div class="font-bold text-gray-900 dark:text-white">New update!</div>
                            <div class="text-gray-500 dark:text-gray-400">Project delivered</div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</section>

<!-- Trusted By Section -->
<section class="py-16 px-6 border-y border-blue-200/50 dark:border-blue-900/50 bg-white/50 dark:bg-[#0f1628]/50 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto">
        <p class="text-center text-sm font-semibold text-gray-500 dark:text-gray-500 uppercase tracking-wider mb-12">
            Powering teams at world-class companies
        </p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-12 items-center justify-items-center">
            <div class="logo-item text-3xl font-bold text-gray-400 dark:text-gray-600">Acme Co.</div>
            <div class="logo-item text-3xl font-bold text-gray-400 dark:text-gray-600">Studio X</div>
            <div class="logo-item text-3xl font-bold text-gray-400 dark:text-gray-600">Creative Inc</div>
            <div class="logo-item text-3xl font-bold text-gray-400 dark:text-gray-600">Design Lab</div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-32 px-6 bg-gradient-to-b from-[#E8F4FD] to-[#D0E8FA] dark:from-[#0f1628] dark:to-[#152238]">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-4 gap-12 text-center">
            <div class="scroll-reveal">
                <div class="stat-number gradient-text mb-2">10K+</div>
                <p class="text-gray-600 dark:text-gray-400 font-medium">Active agencies</p>
            </div>
            <div class="scroll-reveal" style="transition-delay: 0.1s;">
                <div class="stat-number gradient-text mb-2">500K+</div>
                <p class="text-gray-600 dark:text-gray-400 font-medium">Projects delivered</p>
            </div>
            <div class="scroll-reveal" style="transition-delay: 0.2s;">
                <div class="stat-number gradient-text mb-2">99.9%</div>
                <p class="text-gray-600 dark:text-gray-400 font-medium">Uptime SLA</p>
            </div>
            <div class="scroll-reveal" style="transition-delay: 0.3s;">
                <div class="stat-number gradient-text mb-2">40%</div>
                <p class="text-gray-600 dark:text-gray-400 font-medium">Faster delivery</p>
            </div>
        </div>
    </div>
</section>

<!-- Feature Deep Dive 1: Task Management (Zig-Zag Left) -->
<section id="features" class="py-32 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <!-- Left: Mockup -->
            <div class="scroll-reveal order-2 lg:order-1">
                <div class="mockup-window animate-float">
                    <div class="mockup-header">
                        <div class="mockup-dot red"></div>
                        <div class="mockup-dot yellow"></div>
                        <div class="mockup-dot green"></div>
                    </div>
                    <div class="mockup-content">
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Website Redesign</h3>
                            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                <span>12 tasks</span>
                                <span>•</span>
                                <span>Due in 5 days</span>
                            </div>
                        </div>

                        <div class="task-card">
                            <div class="task-checkbox checked"></div>
                            <div class="task-text">Design system audit complete</div>
                            <div class="task-tag normal">Done</div>
                        </div>

                        <div class="task-card">
                            <div class="task-checkbox checked"></div>
                            <div class="task-text">Wireframes approved by client</div>
                            <div class="task-tag normal">Done</div>
                        </div>

                        <div class="task-card">
                            <div class="task-checkbox"></div>
                            <div class="task-text">High-fidelity mockups in progress</div>
                            <div class="task-tag high">High</div>
                        </div>

                        <div class="task-card">
                            <div class="task-checkbox"></div>
                            <div class="task-text">Client review scheduled tomorrow</div>
                            <div class="task-tag urgent">Urgent</div>
                        </div>

                        <div class="task-card">
                            <div class="task-checkbox"></div>
                            <div class="task-text">Development handoff documentation</div>
                            <div class="task-tag normal">Normal</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Content -->
            <div class="scroll-reveal order-1 lg:order-2">
                <div class="inline-flex items-center gap-2 pl-3 pr-1 py-1 border-l-2 border-[#0066FF] text-sm font-medium text-[#0066FF] dark:text-blue-400 mb-4 uppercase tracking-wider">
                    <span>Stay on top of tasks</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-6 tracking-tight" style="font-family: 'Bricolage Grotesque', sans-serif;">
                    Tasks that don't get lost in <span class="gradient-text">invisible tabs</span>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 leading-relaxed mb-8">
                    Every task lives in context. No more switching between tools or hunting through browser tabs. See what matters, when it matters, exactly where you need it.
                </p>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-[#0066FF] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <div>
                            <strong class="text-gray-900 dark:text-white">Smart priorities</strong>
                            <p class="text-gray-600 dark:text-gray-400">AI-powered urgency detection keeps critical work front and center</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-[#0066FF] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <div>
                            <strong class="text-gray-900 dark:text-white">Contextual everything</strong>
                            <p class="text-gray-600 dark:text-gray-400">Tasks, files, conversations - all connected, all accessible</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-[#0066FF] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <div>
                            <strong class="text-gray-900 dark:text-white">One-click delegation</strong>
                            <p class="text-gray-600 dark:text-gray-400">Assign, notify, and track without leaving your flow</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Feature Deep Dive 2: Budget Tracking (Zig-Zag Right) -->
<section class="py-32 px-6 bg-gradient-to-b from-[#D0E8FA] to-[#E8F4FD] dark:from-[#152238] dark:to-[#0f1628]">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <!-- Left: Content -->
            <div class="scroll-reveal">
                <div class="inline-flex items-center gap-2 pl-3 pr-1 py-1 border-l-2 border-[#6B4CE6] text-sm font-medium text-[#6B4CE6] dark:text-purple-400 mb-4 uppercase tracking-wider">
                    <span>Know where money goes</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-6 tracking-tight" style="font-family: 'Bricolage Grotesque', sans-serif;">
                    <span class="gradient-text">Budget logic</span> that actually makes sense
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 leading-relaxed mb-8">
                    Stop squinting at spreadsheets. See exactly where every dollar goes, get alerted before you go over budget, and make informed decisions with real-time financial visibility.
                </p>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-[#6B4CE6] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <div>
                            <strong class="text-gray-900 dark:text-white">Real-time tracking</strong>
                            <p class="text-gray-600 dark:text-gray-400">Time entries automatically update project budgets as they happen</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-[#6B4CE6] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <div>
                            <strong class="text-gray-900 dark:text-white">Smart alerts</strong>
                            <p class="text-gray-600 dark:text-gray-400">Get notified at 75%, 90%, and 100% budget utilization</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-[#6B4CE6] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <div>
                            <strong class="text-gray-900 dark:text-white">Profitability insights</strong>
                            <p class="text-gray-600 dark:text-gray-400">Understand margins across all projects and clients instantly</p>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Right: Mockup -->
            <div class="scroll-reveal">
                <div class="mockup-window animate-float">
                    <div class="mockup-header">
                        <div class="mockup-dot red"></div>
                        <div class="mockup-dot yellow"></div>
                        <div class="mockup-dot green"></div>
                    </div>
                    <div class="mockup-content">
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Q1 Project Budget</h3>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Overall utilization</span>
                                <span class="text-sm font-bold text-gray-900 dark:text-white">$127,500 of $150,000</span>
                            </div>
                            <div class="budget-bar mb-8">
                                <div class="budget-fill" style="width: 85%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="budget-item">
                                <div>
                                    <div class="font-semibold text-gray-900 dark:text-white text-sm mb-1">Design Services</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">$48,500 / $50,000</div>
                                </div>
                                <div class="budget-bar w-24">
                                    <div class="budget-fill" style="width: 97%"></div>
                                </div>
                            </div>

                            <div class="budget-item">
                                <div>
                                    <div class="font-semibold text-gray-900 dark:text-white text-sm mb-1">Development</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">$42,000 / $60,000</div>
                                </div>
                                <div class="budget-bar w-24">
                                    <div class="budget-fill" style="width: 70%"></div>
                                </div>
                            </div>

                            <div class="budget-item">
                                <div>
                                    <div class="font-semibold text-gray-900 dark:text-white text-sm mb-1">Content Creation</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">$22,000 / $25,000</div>
                                </div>
                                <div class="budget-bar w-24">
                                    <div class="budget-fill" style="width: 88%"></div>
                                </div>
                            </div>

                            <div class="budget-item">
                                <div>
                                    <div class="font-semibold text-gray-900 dark:text-white text-sm mb-1">Marketing</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">$15,000 / $15,000</div>
                                </div>
                                <div class="budget-bar w-24">
                                    <div class="budget-fill" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-900 rounded-lg">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-amber-600 dark:text-amber-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <div>
                                    <div class="text-sm font-semibold text-amber-900 dark:text-amber-100 mb-1">Budget Alert</div>
                                    <div class="text-xs text-amber-800 dark:text-amber-200">Design services at 97% capacity. Consider reallocation.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bento Grid - Secondary Features -->
<section class="py-32 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16 scroll-reveal">
            <h2 class="text-4xl md:text-5xl font-bold mb-6" style="font-family: 'Bricolage Grotesque', sans-serif;">
                Everything else you need,<br/>
                <span class="gradient-text">all in one place</span>
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                No more tool sprawl. Everything your agency needs to thrive.
            </p>
        </div>

        <div class="bento-grid">
            <!-- Security -->
            <div class="bento-item bento-medium scroll-reveal">
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h3 class="text-2xl font-bold mb-3" style="font-family: 'Bricolage Grotesque', sans-serif;">Enterprise Security</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    SOC 2 Type II certified. 256-bit encryption. GDPR compliant. Your data is Fort Knox-level secure.
                </p>
                <div class="mt-6 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-500">
                    <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    99.9% uptime SLA
                </div>
            </div>

            <!-- Speed -->
            <div class="bento-item bento-medium scroll-reveal" style="transition-delay: 0.1s;">
                <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="text-2xl font-bold mb-3" style="font-family: 'Bricolage Grotesque', sans-serif;">Lightning Fast</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Sub-100ms response times. Instant search. Real-time collaboration. No lag, no waiting, just flow.
                </p>
                <div class="mt-6 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-500">
                    <svg class="w-4 h-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Global CDN
                </div>
            </div>

            <!-- Sync -->
            <div class="bento-item bento-small scroll-reveal" style="transition-delay: 0.2s;">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
                <h3 class="text-xl font-bold mb-3" style="font-family: 'Bricolage Grotesque', sans-serif;">Real-time Sync</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                    Changes appear instantly across all devices. Always up to date.
                </p>
            </div>

            <!-- Integrations -->
            <div class="bento-item bento-large scroll-reveal" style="transition-delay: 0.3s;">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h3 class="text-3xl font-bold mb-3" style="font-family: 'Bricolage Grotesque', sans-serif;">Integrations that work</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed max-w-lg">
                            Connect with the tools you already use. Slack, Google Drive, Figma, GitHub, and 50+ more integrations that actually work the way you expect.
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-4 gap-4 mt-8">
                    <div class="aspect-square bg-blue-100/50 dark:bg-[#1a2744] rounded-xl flex items-center justify-center font-bold text-gray-400 dark:text-gray-600 text-xs hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">Slack</div>
                    <div class="aspect-square bg-blue-100/50 dark:bg-[#1a2744] rounded-xl flex items-center justify-center font-bold text-gray-400 dark:text-gray-600 text-xs hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">Drive</div>
                    <div class="aspect-square bg-blue-100/50 dark:bg-[#1a2744] rounded-xl flex items-center justify-center font-bold text-gray-400 dark:text-gray-600 text-xs hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">Figma</div>
                    <div class="aspect-square bg-blue-100/50 dark:bg-[#1a2744] rounded-xl flex items-center justify-center font-bold text-gray-400 dark:text-gray-600 text-xs hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">GitHub</div>
                    <div class="aspect-square bg-blue-100/50 dark:bg-[#1a2744] rounded-xl flex items-center justify-center font-bold text-gray-400 dark:text-gray-600 text-xs hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">Notion</div>
                    <div class="aspect-square bg-blue-100/50 dark:bg-[#1a2744] rounded-xl flex items-center justify-center font-bold text-gray-400 dark:text-gray-600 text-xs hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">Asana</div>
                    <div class="aspect-square bg-blue-100/50 dark:bg-[#1a2744] rounded-xl flex items-center justify-center font-bold text-gray-400 dark:text-gray-600 text-xs hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">Zapier</div>
                    <div class="aspect-square bg-blue-100/50 dark:bg-[#1a2744] rounded-xl flex items-center justify-center font-bold text-gray-400 dark:text-gray-600 text-xs hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">+50</div>
                </div>
            </div>

            <!-- Mobile -->
            <div class="bento-item bento-small scroll-reveal" style="transition-delay: 0.4s;">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-xl font-bold mb-3" style="font-family: 'Bricolage Grotesque', sans-serif;">Mobile Apps</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                    Native iOS and Android apps. Manage on the go.
                </p>
            </div>

            <!-- API -->
            <div class="bento-item bento-small scroll-reveal" style="transition-delay: 0.5s;">
                <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                </div>
                <h3 class="text-xl font-bold mb-3" style="font-family: 'Bricolage Grotesque', sans-serif;">Developer API</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                    Build custom workflows with our REST API.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section id="how-it-works" class="py-32 px-6 bg-gradient-to-b from-[#D0E8FA] to-[#E8F4FD] dark:from-[#152238] dark:to-[#0f1628]">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-20 scroll-reveal">
            <div class="inline-flex items-center gap-2 pl-3 pr-1 py-1 border-l-2 border-green-500 text-sm font-medium text-green-600 dark:text-green-400 mb-4 uppercase tracking-wider">
                <span>Get started fast</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold mb-6" style="font-family: 'Bricolage Grotesque', sans-serif;">
                Up and running in <span class="gradient-text">minutes, not days</span>
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                No complex setup. No training required. Just sign up and start managing projects like a pro.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 relative">
            <!-- Connecting Line -->
            <div class="hidden md:block absolute top-24 left-1/6 right-1/6 h-0.5 bg-gradient-to-r from-[#0066FF] via-[#6B4CE6] to-[#00D9B1]"></div>

            <!-- Step 1 -->
            <div class="scroll-reveal text-center relative">
                <div class="w-16 h-16 bg-gradient-to-br from-[#0066FF] to-[#4d8eff] rounded-2xl flex items-center justify-center mx-auto mb-6 text-white text-2xl font-bold shadow-lg shadow-blue-500/30 relative z-10">
                    1
                </div>
                <h3 class="text-2xl font-bold mb-4" style="font-family: 'Bricolage Grotesque', sans-serif;">Create your workspace</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Sign up in 30 seconds. Import your existing projects or start fresh with our templates.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="scroll-reveal text-center relative" style="transition-delay: 0.1s;">
                <div class="w-16 h-16 bg-gradient-to-br from-[#6B4CE6] to-[#9171f2] rounded-2xl flex items-center justify-center mx-auto mb-6 text-white text-2xl font-bold shadow-lg shadow-purple-500/30 relative z-10">
                    2
                </div>
                <h3 class="text-2xl font-bold mb-4" style="font-family: 'Bricolage Grotesque', sans-serif;">Invite your team</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Add team members with one click. Set permissions and get everyone on the same page instantly.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="scroll-reveal text-center relative" style="transition-delay: 0.2s;">
                <div class="w-16 h-16 bg-gradient-to-br from-[#00D9B1] to-[#00f5c8] rounded-2xl flex items-center justify-center mx-auto mb-6 text-white text-2xl font-bold shadow-lg shadow-emerald-500/30 relative z-10">
                    3
                </div>
                <h3 class="text-2xl font-bold mb-4" style="font-family: 'Bricolage Grotesque', sans-serif;">Start delivering</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Track progress, collaborate in real-time, and deliver projects faster than ever before.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section id="pricing" class="py-32 px-6 bg-[#D0E8FA] dark:bg-[#0f1628] transition-colors duration-300">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16 scroll-reveal">
            <div class="inline-flex items-center gap-2 pl-3 pr-1 py-1 border-l-2 border-amber-500 text-sm font-medium text-amber-600 dark:text-amber-400 mb-4 uppercase tracking-wider">
                <span>No surprises</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900 dark:text-white" style="font-family: 'Bricolage Grotesque', sans-serif;">
                Plans that <span class="gradient-text">scale with you</span>
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                Start free. Upgrade when you're ready. No hidden fees, ever.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto group/plans perspective-1000">

            <div class="scroll-reveal relative bg-white dark:bg-[#152238] border border-blue-200/60 dark:border-blue-900/50 rounded-3xl p-8
                        transform transition-all duration-500 ease-out
                        /* Default State */
                        opacity-100 scale-100 translate-y-0
                        /* When neighbor is hovered (Recede) */
                        group-hover/plans:opacity-60 group-hover/plans:scale-95 group-hover/plans:blur-[1px]
                        /* When THIS is hovered (Focus) */
                        hover:!opacity-100 hover:!scale-105 hover:!-translate-y-4 hover:!blur-0 hover:shadow-2xl hover:border-blue-400 dark:hover:border-blue-500 hover:z-10">

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2" style="font-family: 'Bricolage Grotesque', sans-serif;">Starter</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Perfect for freelancers</p>
                </div>
                <div class="mb-6">
                    <span class="text-5xl font-bold text-gray-900 dark:text-white" style="font-family: 'Bricolage Grotesque', sans-serif;">$0</span>
                    <span class="text-gray-500 dark:text-gray-400">/month</span>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center gap-3 text-gray-600 dark:text-gray-400">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Up to 3 projects
                    </li>
                    <li class="flex items-center gap-3 text-gray-600 dark:text-gray-400">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        2 team members
                    </li>
                    <li class="flex items-center gap-3 text-gray-600 dark:text-gray-400">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Basic analytics
                    </li>
                </ul>
                <a href="{{ route('register.plan', ['plan' => 'free']) }}" class="block w-full py-3 px-6 text-center font-semibold rounded-xl border-2 border-blue-200/60 dark:border-blue-800/50 text-gray-700 dark:text-gray-300 hover:bg-blue-50 hover:border-blue-500 hover:text-blue-600 transition-colors">
                    Get Started Free
                </a>
            </div>

            <div class="scroll-reveal relative bg-gradient-to-b from-[#0066FF] to-[#6B4CE6] rounded-3xl p-8 text-white shadow-2xl shadow-blue-500/30
                        transform transition-all duration-500 ease-out z-10
                        /* Default State (Already lifted) */
                        md:-translate-y-4 opacity-100 scale-100
                        /* When neighbor is hovered (Recede & Reset Lift) */
                        group-hover/plans:opacity-60 group-hover/plans:scale-95 group-hover/plans:translate-y-0 group-hover/plans:blur-[1px]
                        /* When THIS is hovered (Super Focus) */
                        hover:!opacity-100 hover:!scale-110 hover:!md:-translate-y-6 hover:!blur-0 hover:shadow-blue-500/60 hover:z-20" style="transition-delay: 0.1s;">

                <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 bg-gradient-to-r from-amber-400 to-orange-500 rounded-full text-xs font-bold text-white shadow-lg">
                    MOST POPULAR
                </div>
                <div class="mb-6">
                    <h3 class="text-xl font-bold mb-2" style="font-family: 'Bricolage Grotesque', sans-serif;">Pro</h3>
                    <p class="text-blue-100 text-sm">For growing agencies</p>
                </div>
                <div class="mb-6">
                    <span class="text-5xl font-bold" style="font-family: 'Bricolage Grotesque', sans-serif;">$29</span>
                    <span class="text-blue-100">/user/month</span>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Unlimited projects
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Unlimited team members
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Advanced analytics
                    </li>
                </ul>
                <a href="{{ route('register.plan', ['plan' => 'pro']) }}" class="block w-full py-3 px-6 text-center font-semibold rounded-xl bg-white text-[#0066FF] hover:bg-blue-100/50 transition-all shadow-lg">
                    Start Free Trial
                </a>
            </div>

            <div class="scroll-reveal relative bg-white dark:bg-[#152238] border border-blue-200/60 dark:border-blue-900/50 rounded-3xl p-8
                        transform transition-all duration-500 ease-out
                        /* Default State */
                        opacity-100 scale-100 translate-y-0
                        /* When neighbor is hovered (Recede) */
                        group-hover/plans:opacity-60 group-hover/plans:scale-95 group-hover/plans:blur-[1px]
                        /* When THIS is hovered (Focus) */
                        hover:!opacity-100 hover:!scale-105 hover:!-translate-y-4 hover:!blur-0 hover:shadow-2xl hover:border-purple-400 dark:hover:border-purple-500 hover:z-10" style="transition-delay: 0.2s;">

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2" style="font-family: 'Bricolage Grotesque', sans-serif;">Enterprise</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">For large organizations</p>
                </div>
                <div class="mb-6">
                    <span class="text-5xl font-bold text-gray-900 dark:text-white" style="font-family: 'Bricolage Grotesque', sans-serif;">Custom</span>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center gap-3 text-gray-600 dark:text-gray-400">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Everything in Pro
                    </li>
                    <li class="flex items-center gap-3 text-gray-600 dark:text-gray-400">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        SSO & SAML
                    </li>
                    <li class="flex items-center gap-3 text-gray-600 dark:text-gray-400">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Dedicated account manager
                    </li>
                </ul>
                <a href="#" class="block w-full py-3 px-6 text-center font-semibold rounded-xl border-2 border-blue-200/60 dark:border-blue-800/50 text-gray-700 dark:text-gray-300 hover:bg-purple-50 hover:border-purple-500 hover:text-purple-600 dark:hover:bg-purple-900/20 dark:hover:text-purple-300 transition-colors">
                    Contact Sales
                </a>
            </div>
        </div>
    </div>
</section>
<!-- Testimonials -->
<section class="py-32 px-6 bg-gradient-to-b from-[#E8F4FD] to-[#D0E8FA] dark:from-[#0f1628] dark:to-[#152238]">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16 scroll-reveal">
            <h2 class="text-4xl md:text-5xl font-bold mb-6" style="font-family: 'Bricolage Grotesque', sans-serif;">
                Loved by agencies,<br/>
                <span class="gradient-text">trusted by teams</span>
            </h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="scroll-reveal bg-white dark:bg-[#152238] border border-blue-200/60 dark:border-blue-900/50 rounded-2xl p-8 hover:border-[#0066FF] dark:hover:border-blue-500 transition-all hover:-translate-y-1">
                <div class="flex items-center gap-1 mb-4">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                </div>
                <p class="text-gray-700 dark:text-gray-300 mb-6 leading-relaxed">
                    "We switched from Asana and haven't looked back. Clary just gets how agencies work. Our delivery time dropped by 40% in the first month."
                </p>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold">
                        SK
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 dark:text-white">Sarah Kim</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Founder, Pixel Perfect Studio</div>
                    </div>
                </div>
            </div>

            <div class="scroll-reveal bg-white dark:bg-[#152238] border border-blue-200/60 dark:border-blue-900/50 rounded-2xl p-8 hover:border-[#0066FF] dark:hover:border-blue-500 transition-all hover:-translate-y-1" style="transition-delay: 0.1s;">
                <div class="flex items-center gap-1 mb-4">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                </div>
                <p class="text-gray-700 dark:text-gray-300 mb-6 leading-relaxed">
                    "The budget tracking finally makes sense. No more surprise overages or awkward client conversations. We see everything in real-time."
                </p>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                        MR
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 dark:text-white">Marcus Rodriguez</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Operations Lead, Brand Builders</div>
                    </div>
                </div>
            </div>

            <div class="scroll-reveal bg-white dark:bg-[#152238] border border-blue-200/60 dark:border-blue-900/50 rounded-2xl p-8 hover:border-[#0066FF] dark:hover:border-blue-500 transition-all hover:-translate-y-1" style="transition-delay: 0.2s;">
                <div class="flex items-center gap-1 mb-4">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                </div>
                <p class="text-gray-700 dark:text-gray-300 mb-6 leading-relaxed">
                    "Finally, a tool that doesn't require a PhD to use. Our whole team was onboarded in an afternoon. It just works. I am looking forward to use it more."
                </p>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center text-white font-bold">
                        EP
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 dark:text-white">Emma Park</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Creative Director, Spark Agency</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Final CTA -->
<section class="py-24 px-6 relative overflow-hidden bg-[#4A90E2] dark:bg-gradient-to-br dark:from-blue-900 dark:to-slate-900 transition-colors duration-500">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-white/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-16">

            <div class="w-full lg:w-1/2 relative perspective-1000">
                <div class="relative w-full max-w-[400px] mx-auto lg:mr-auto lg:ml-0">

                    <div class="bg-blue-300/30 backdrop-blur-sm border border-white/20 rounded-[3rem] p-4 h-[500px] w-full shadow-2xl relative overflow-hidden">
                        <div class="bg-blue-200/50 dark:bg-blue-800/50 w-full h-full rounded-[2.5rem] relative overflow-hidden flex flex-col items-center pt-12">
                            <div class="w-48 h-48 bg-gray-800 rounded-full flex items-center justify-center shadow-lg mb-6 group cursor-pointer hover:scale-105 transition-transform">
                                <svg class="w-24 h-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" /></svg>
                            </div>
                            <div class="w-32 h-4 bg-white/40 rounded-full mb-3"></div>
                            <div class="flex gap-2">
                                <div class="w-8 h-8 rounded-full bg-white/40"></div>
                                <div class="w-8 h-8 rounded-full bg-white/40"></div>
                                <div class="w-8 h-8 rounded-full bg-white/40"></div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute top-12 -right-4 md:-right-12 bg-white dark:bg-[#152238] p-4 rounded-2xl shadow-xl w-48 animate-float z-20 border border-gray-100 dark:border-blue-800/50">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-[10px] font-bold text-gray-400 uppercase">Payment Method</span>
                            <div class="flex -space-x-1">
                                <div class="w-4 h-4 rounded-full bg-red-500 opacity-80"></div>
                                <div class="w-4 h-4 rounded-full bg-yellow-500 opacity-80"></div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 p-2 bg-gray-50 dark:bg-[#1a2744]/50 rounded-lg">
                                <div class="w-3 h-3 rounded-full bg-gray-900 dark:bg-white"></div>
                                <div class="h-2 w-16 bg-gray-200 dark:bg-blue-800/50 rounded"></div>
                            </div>
                            <div class="flex items-center gap-2 p-2 rounded-lg opacity-50">
                                <div class="w-3 h-3 rounded-full border border-gray-300"></div>
                                <div class="h-2 w-12 bg-gray-200 dark:bg-blue-800/50 rounded"></div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute bottom-16 -left-4 md:-left-12 bg-white dark:bg-[#152238] p-5 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.2)] w-64 animate-float z-30 border border-gray-100 dark:border-blue-800/50" style="animation-delay: 2s;">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="font-bold text-gray-900 dark:text-white text-sm">Add New Card</h4>
                            <span class="text-gray-400 cursor-pointer">×</span>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <div class="text-[10px] text-gray-400 mb-1">Name on card</div>
                                <div class="text-xs font-medium text-gray-900 dark:text-gray-200">n9rrrx</div>
                            </div>
                            <div>
                                <div class="text-[10px] text-gray-400 mb-1">Card number</div>
                                <div class="text-xs font-medium text-gray-900 dark:text-gray-200 tracking-wider">•••• •••• •••• 4242</div>
                            </div>
                            <button class="w-full py-2 bg-[#0066FF] hover:bg-blue-600 text-white text-xs font-bold rounded-lg transition-colors mt-2">
                                Pay Now
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="w-full lg:w-1/2 text-left">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 tracking-tight leading-[1.1]" style="font-family: 'Bricolage Grotesque', sans-serif;">
                    Trusted Partner in<br>
                    Payment Solutions
                </h2>
                <p class="text-lg md:text-xl text-blue-50 dark:text-blue-200 mb-10 leading-relaxed max-w-lg">
                    An extensive network of partners, we help businesses accept and process payments in over 150 currencies globally!
                </p>

                <div class="flex flex-wrap items-center gap-4">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="group px-8 py-4 bg-white dark:bg-[#0f1628] text-[#0066FF] dark:text-blue-400 text-lg font-bold rounded-full hover:shadow-[0_0_30px_rgba(255,255,255,0.4)] transition-all transform hover:-translate-y-1 flex items-center gap-3">
                            Start Now
                            <span class="bg-blue-100 dark:bg-blue-900/50 p-1 rounded-full group-hover:translate-x-1 transition-transform">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </span>
                        </a>
                    @endif
                    <a href="#demo" class="px-8 py-4 bg-blue-500/20 border border-white/30 text-white text-lg font-bold rounded-full hover:bg-white/10 hover:border-white transition-all backdrop-blur-sm">
                        Book A Call
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Footer -->
<footer class="border-t border-blue-200/60 dark:border-blue-900/50 py-16 px-6 bg-white dark:bg-[#152238]">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-5 gap-12 mb-12">
            <div class="md:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-[#0066FF] to-[#6B4CE6] rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-xl">C</span>
                    </div>
                    <span class="text-2xl font-bold" style="font-family: 'Bricolage Grotesque', sans-serif;">Clary</span>
                </div>
                <p class="text-gray-600 dark:text-gray-400 max-w-sm mb-6">
                    Crystal-clear project management for modern agencies. Work smarter, deliver faster, stress less.
                </p>
                <div class="flex items-center gap-4">
                    <a href="#" class="text-gray-400 hover:text-[#0066FF] transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-[#0066FF] transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-[#0066FF] transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="font-bold text-gray-900 dark:text-white mb-4" style="font-family: 'Bricolage Grotesque', sans-serif;">Product</h4>
                <ul class="space-y-3">
                    <li><a href="#features" class="text-gray-600 dark:text-gray-400 hover:text-[#0066FF] dark:hover:text-blue-400 transition-colors">Features</a></li>
                    <li><a href="#pricing" class="text-gray-600 dark:text-gray-400 hover:text-[#0066FF] dark:hover:text-blue-400 transition-colors">Pricing</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#0066FF] dark:hover:text-blue-400 transition-colors">Integrations</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#0066FF] dark:hover:text-blue-400 transition-colors">Changelog</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-gray-900 dark:text-white mb-4" style="font-family: 'Bricolage Grotesque', sans-serif;">Company</h4>
                <ul class="space-y-3">
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#0066FF] dark:hover:text-blue-400 transition-colors">About</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#0066FF] dark:hover:text-blue-400 transition-colors">Blog</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#0066FF] dark:hover:text-blue-400 transition-colors">Careers</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#0066FF] dark:hover:text-blue-400 transition-colors">Contact</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-gray-900 dark:text-white mb-4" style="font-family: 'Bricolage Grotesque', sans-serif;">Legal</h4>
                <ul class="space-y-3">
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#0066FF] dark:hover:text-blue-400 transition-colors">Privacy</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#0066FF] dark:hover:text-blue-400 transition-colors">Terms</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#0066FF] dark:hover:text-blue-400 transition-colors">Security</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#0066FF] dark:hover:text-blue-400 transition-colors">GDPR</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-blue-200/50 dark:border-blue-900/50 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-500 dark:text-gray-400 text-sm">
                © 2026 Clary. All rights reserved.
            </p>
            <p class="text-gray-500 dark:text-gray-400 text-sm">
                Made with clarity and care
            </p>
        </div>
    </div>
</footer>

<script>
    // Theme Toggle
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
                themeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.66-10h-1M4.34 12h-1M18.36 6.64l-.7.7M6.34 18.66l-.7.7M18.36 17.36l-.7-.7M6.34 5.34l-.7-.7"/>';
            } else {
                root.classList.remove('dark');
                themeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>';
            }
        }

        const stored = localStorage.getItem('theme');
        const initial = stored ? stored : (isSystemDark() ? 'dark' : 'light');
        applyTheme(initial);

        themeToggle.addEventListener('click', function() {
            const current = root.classList.contains('dark') ? 'dark' : 'light';
            const next = current === 'dark' ? 'light' : 'dark';
            localStorage.setItem('theme', next);
            applyTheme(next);
        });
    })();

    // Scroll Reveal Animation
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.scroll-reveal').forEach(el => {
        observer.observe(el);
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Animate budget bars on scroll
    const budgetObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const fills = entry.target.querySelectorAll('.budget-fill');
                fills.forEach(fill => {
                    const width = fill.style.width;
                    fill.style.width = '0%';
                    setTimeout(() => {
                        fill.style.width = width;
                    }, 100);
                });
                budgetObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.mockup-window').forEach(el => {
        budgetObserver.observe(el);
    });
</script>
</body>
</html>
