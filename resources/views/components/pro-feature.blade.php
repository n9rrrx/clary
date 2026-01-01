@props(['feature', 'title' => 'Pro Feature', 'description' => null])

@php
    $user = auth()->user();
    $hasAccess = $user->canUseFeature($feature);
    
    $featureDescriptions = [
        'client_portal' => 'Give your clients direct access to view project progress and communicate with your team.',
        'custom_branding' => 'Add your agency logo and brand colors for a professional appearance.',
        'advanced_reports' => 'Get detailed analytics and insights about your projects, team, and revenue.',
        'file_attachments' => 'Attach files and documents to projects and tasks.',
    ];
    
    $description = $description ?? ($featureDescriptions[$feature] ?? 'This feature is available on Pro and Enterprise plans.');
@endphp

@if($hasAccess)
    {{-- User has access - render content normally --}}
    {{ $slot }}
@else
    {{-- Feature locked - show upgrade prompt --}}
    <div {{ $attributes->merge(['class' => 'relative']) }}>
        {{-- Blurred preview (optional slot content) --}}
        @if(isset($preview))
            <div class="pointer-events-none select-none opacity-40 blur-sm">
                {{ $preview }}
            </div>
        @endif
        
        {{-- Lock overlay --}}
        <div class="absolute inset-0 flex items-center justify-center bg-gray-50/80 dark:bg-midnight-900/80 backdrop-blur-sm rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-700">
            <div class="text-center p-6 max-w-sm">
                {{-- Lock icon --}}
                <div class="mx-auto w-12 h-12 rounded-full bg-gradient-to-br from-accent-500 to-purple-600 flex items-center justify-center mb-4 shadow-lg shadow-accent-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                
                {{-- Title --}}
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                    {{ $title }}
                </h3>
                
                {{-- Description --}}
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    {{ $description }}
                </p>
                
                {{-- Upgrade button --}}
                <a href="{{ route('subscription.manage') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-accent-500 to-purple-600 rounded-lg hover:from-accent-600 hover:to-purple-700 transition-all shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Upgrade to Pro
                </a>
            </div>
        </div>
    </div>
@endif
