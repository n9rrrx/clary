<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'user_id',      // REQUIRED in your DB
        'project_id',
        'title',        // CHANGED: was 'name'
        'description',
        'status',
        'priority',     // NEW: found in your DB
        'due_date',
        'assigned_to',  // Optional, but good to have
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
