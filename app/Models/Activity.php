<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = []; // Allows us to create data easily

    // An activity belongs to a User (Author)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // An activity belongs to a Client (Target)
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
