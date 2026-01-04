<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id', 'name', 'email', 'phone',
        'type', 'status', 'tags', 'address', 'budget'
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    /**
     * Get the team/workspace this client belongs to.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the projects for the client.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the invoices for the client.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the activities for the client.
     */
    public function activities()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function latestActivity()
    {
        return $this->hasOne(Activity::class)->latestOfMany();
    }
}
