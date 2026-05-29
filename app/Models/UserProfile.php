<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
    'user_id',
    'wallet_balance',
    'profile_image',
];

public function user()
{
    return $this->belongsTo(User::class,'user_id');
}
}
