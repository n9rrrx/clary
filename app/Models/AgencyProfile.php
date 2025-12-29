<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgencyProfile extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'company_email',
        'phone',
        'address',
        'tax_id',
        'bank_details',
    ];
}
