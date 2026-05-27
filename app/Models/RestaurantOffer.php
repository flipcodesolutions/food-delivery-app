<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'offer_text',
        'banner',
        'expire_at',
        'is_active',
    ];

    protected $casts = [
        'expire_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function restaurant()
    {
        return $this->belongsTo(User::class, 'restaurant_id');
    }
}