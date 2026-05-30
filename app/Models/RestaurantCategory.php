<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RestaurantCategory extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'restaurant_id',
        'name',
        'image',
        'status',
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'restaurant_id','id');
    }

    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'category_id');
    }
}
