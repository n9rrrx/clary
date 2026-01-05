<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Billable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'current_team_id',
        'plan',
        'tags',
        'user_type',
        'designation',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tags' => 'array',
        ];
    }

    // --- TEAM RELATIONSHIPS ---

    /**
     * Get all teams this user belongs to
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_user')
            ->withPivot(['role', 'budget_limit', 'allowed_tabs'])
            ->withTimestamps();
    }

    /**
     * Get the user's current active team
     */
    public function currentTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'current_team_id');
    }

    /**
     * Get teams this user owns
     */
    public function ownedTeams()
    {
        return $this->hasMany(Team::class, 'owner_id');
    }

    /**
     * Check if user is owner of their current team
     */
    public function isOwnerOfCurrentTeam(): bool
    {
        return $this->currentTeam && $this->currentTeam->owner_id === $this->id;
    }

    /**
     * Get all projects this user is assigned to
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_user')
            ->withTimestamps();
    }

    /**
     * Get the client profile linked to this user (by email match)
     * This is used for the client portal
     */
    public function client()
    {
        return $this->hasOne(Client::class, 'email', 'email');
    }

    // --- PLAN HELPER METHODS ---

    /**
     * Get the user's current plan name
     */
    public function getPlanName(): string
    {
        return config("plans.{$this->plan}.name", 'Starter');
    }

    /**
     * Check if user can use a specific feature
     */
    public function canUseFeature(string $feature): bool
    {
        return app(\App\Services\PlanService::class)->hasFeature($this, $feature);
    }

    /**
     * Get the limit for a specific resource
     */
    public function getResourceLimit(string $resource): ?int
    {
        return app(\App\Services\PlanService::class)->getLimit($this, $resource);
    }

    /**
     * Check if user is on a paid plan
     */
    public function isOnPaidPlan(): bool
    {
        return in_array($this->plan, ['pro', 'enterprise']);
    }
}
