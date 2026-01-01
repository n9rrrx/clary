<?php

namespace App\Services;

use App\Models\User;
use App\Models\Project;
use App\Models\Client;

class PlanService
{
    /**
     * Get the limits for a specific plan
     */
    public function getLimits(string $plan): array
    {
        return config("plans.{$plan}.limits", config('plans.free.limits'));
    }

    /**
     * Get the features for a specific plan
     */
    public function getFeatures(string $plan): array
    {
        return config("plans.{$plan}.features", config('plans.free.features'));
    }

    /**
     * Check if user can create a new project
     */
    public function canCreateProject(User $user): bool
    {
        $limit = $this->getLimit($user, 'projects');
        
        if ($limit === null) {
            return true; // Unlimited
        }

        $team = $user->currentTeam;
        if (!$team) {
            return false;
        }

        $currentCount = Project::where('team_id', $team->id)->count();
        
        return $currentCount < $limit;
    }

    /**
     * Check if user can create a new client
     */
    public function canCreateClient(User $user): bool
    {
        $limit = $this->getLimit($user, 'clients');
        
        if ($limit === null) {
            return true;
        }

        $team = $user->currentTeam;
        if (!$team) {
            return false;
        }

        $currentCount = Client::where('team_id', $team->id)->count();
        
        return $currentCount < $limit;
    }

    /**
     * Check if user can add a new team member
     */
    public function canAddTeamMember(User $user): bool
    {
        $limit = $this->getLimit($user, 'team_members');
        
        if ($limit === null) {
            return true;
        }

        $team = $user->currentTeam;
        if (!$team) {
            return false;
        }

        // Count current members (excluding the owner)
        $currentCount = $team->members()->count();
        
        return $currentCount < $limit;
    }

    /**
     * Check if user has a specific feature
     */
    public function hasFeature(User $user, string $feature): bool
    {
        $plan = $user->plan ?? 'free';
        $features = $this->getFeatures($plan);
        
        return $features[$feature] ?? false;
    }

    /**
     * Get the limit for a specific resource
     */
    public function getLimit(User $user, string $resource): ?int
    {
        $plan = $user->plan ?? 'free';
        $limits = $this->getLimits($plan);
        
        return $limits[$resource] ?? null;
    }

    /**
     * Get the current count for a resource
     */
    public function getCurrentCount(User $user, string $resource): int
    {
        $team = $user->currentTeam;
        if (!$team) {
            return 0;
        }

        return match ($resource) {
            'projects' => Project::where('team_id', $team->id)->count(),
            'clients' => Client::where('team_id', $team->id)->count(),
            'team_members' => $team->members()->count(),
            default => 0,
        };
    }

    /**
     * Get remaining slots for a resource
     */
    public function getRemainingSlots(User $user, string $resource): ?int
    {
        $limit = $this->getLimit($user, $resource);
        
        if ($limit === null) {
            return null; // Unlimited
        }

        $current = $this->getCurrentCount($user, $resource);
        
        return max(0, $limit - $current);
    }

    /**
     * Get usage info for display (e.g., "2/3" or "5 (unlimited)")
     */
    public function getUsageDisplay(User $user, string $resource): string
    {
        $current = $this->getCurrentCount($user, $resource);
        $limit = $this->getLimit($user, $resource);

        if ($limit === null) {
            return "{$current} (unlimited)";
        }

        return "{$current}/{$limit}";
    }

    /**
     * Check if user is at or near limit (for showing warnings)
     */
    public function isNearLimit(User $user, string $resource, int $threshold = 1): bool
    {
        $remaining = $this->getRemainingSlots($user, $resource);
        
        if ($remaining === null) {
            return false; // Unlimited, never near limit
        }

        return $remaining <= $threshold;
    }

    /**
     * Check if user is at limit
     */
    public function isAtLimit(User $user, string $resource): bool
    {
        $remaining = $this->getRemainingSlots($user, $resource);
        
        if ($remaining === null) {
            return false;
        }

        return $remaining === 0;
    }
}
