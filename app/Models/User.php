<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'address1',
        'address2',
        'city',
        'state',
        'postal',
        'country',
        'dayphone',
        'evephone',
        'status',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function purchaseToken(){
        return $this->hasOne(PurchaseToken::class);
    }

    public function bonusToken(){
        return $this->hasOne(BonusToken::class);
    }

    public function makeupToken(){
        return $this->hasOne(MakeupToken::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class)->withPivot('type');
    }
}
