<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'status',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
    //    @return array<string, string>
     */
    // protected function casts(): array
    // {
    //     return [
    //         'password' => 'hashed',
    //         'latitude' => 'decimal:7',
    //         'longitude' => 'decimal:7',
    //         'commission_rate' => 'decimal:2',
    //         'earning_balance' => 'decimal:2',
    //         'wallet_balance' => 'decimal:2',
    //     ];
    // }

    public function restaurantCategories(): HasMany
    {
        return $this->hasMany(RestaurantCategory::class, 'restaurant_id');
    }

    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'restaurant_id');
    }

    public function customerOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function restaurantOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'restaurant_id');
    }

    public function deliveryOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'delivery_partner_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'customer_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'customer_id');
    }
    
    // public function offers()
    public function offers()
    {
        return $this->hasMany(RestaurantOffer::class, 'restaurant_id');
    }
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
}
