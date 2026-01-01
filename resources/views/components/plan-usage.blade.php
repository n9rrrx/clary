@props(['resource', 'showUpgrade' => true])

@php
    $planService = app(\App\Services\PlanService::class);
    $user = auth()->user();
    $current = $planService->getCurrentCount($user, $resource);
    $limit = $planService->getLimit($user, $resource);
    $isAtLimit = $planService->isAtLimit($user, $resource);
    $isNearLimit = $planService->isNearLimit($user, $resource);
    $isUnlimited = $limit === null;
    
    $resourceLabels = [
        'projects' => 'Projects',
        'clients' => 'Clients',
        'team_members' => 'Team Members',
    ];
    $label = $resourceLabels[$resource] ?? ucfirst($resource);
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center gap-3']) }}>
    {{-- Usage Badge --}}
    <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-medium {{ $isAtLimit ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' : ($isNearLimit ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400') }}">
        @if($isUnlimited)
            <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>{{ $current }} {{ $label }}</span>
            <span class="text-xs text-gray-400">(unlimited)</span>
        @else
            @if($isAtLimit)
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            @endif
            <span>{{ $current }}/{{ $limit }} {{ $label }}</span>
        @endif
    </div>

    {{-- Upgrade CTA (only for free users near/at limit) --}}
    @if($showUpgrade && !$isUnlimited && ($isAtLimit || $isNearLimit))
        <a href="{{ route('subscription.manage') }}" 
           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-gradient-to-r from-accent-500 to-purple-600 rounded-lg hover:from-accent-600 hover:to-purple-700 transition-all shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            Upgrade
        </a>
    @endif
</div>
