<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $table = 'restaurant_profiles';
    protected $fillable = [
        'user_id',
        'restaurant_name',
        'detail',
        'logo',
        'opening_time',
        'closing_time',
        'commission_rate',
    ];
}
