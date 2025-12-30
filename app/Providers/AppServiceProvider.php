<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Atlassian-style Role-based Permissions
        // Admin & Owner: Full access
        // Member: Can view and work on assigned tasks/projects
        // Viewer: Read-only

        Gate::define('view-projects', function (User $user) {
            return $this->hasTeamAccess($user, 'view');
        });

        Gate::define('view-tasks', function (User $user) {
            return $this->hasTeamAccess($user, 'view');
        });

        Gate::define('view-invoices', function (User $user) {
            // Only admin and owner can see invoices
            return $this->hasTeamAccess($user, 'admin');
        });

        Gate::define('create-projects', function (User $user) {
            return $this->hasTeamAccess($user, 'admin');
        });

        Gate::define('create-tasks', function (User $user) {
            return $this->hasTeamAccess($user, 'admin');
        });
    }

    /**
     * Check if user has team access at specified level
     */
    private function hasTeamAccess(User $user, string $level): bool
    {
        $team = $user->currentTeam;

        // No team = allow (will see empty content)
        if (!$team) return true;

        // Owner always has full access
        if ($team->owner_id === $user->id) return true;

        // Get role from pivot
        $membership = $user->teams()->where('team_id', $team->id)->first();
        $role = $membership?->pivot?->role ?? 'member';

        // Role hierarchy
        if ($level === 'view') {
            // Everyone can view (admin, member, viewer)
            return true;
        }

        if ($level === 'admin') {
            // Only admin and owner can do admin things
            return in_array($role, ['admin', 'owner']);
        }

        return false;
    }
}
