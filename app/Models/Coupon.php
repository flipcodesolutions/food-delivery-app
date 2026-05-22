<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'coupon_code',
        'discount_type',
        'discount_value',
        'minimum_order_amount',
        'expiry_date',
        'status',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'discount_value' => 'decimal:2',
            'minimum_order_amount' => 'decimal:2',
            'expiry_date' => 'date',
        ];
    }
}
