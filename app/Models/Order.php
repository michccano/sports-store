<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "total_bill",
        "card_payment_amount",
        "token_payment_amount",
        'user_id',
    ];
    public function products(){
        return $this->belongsToMany(Product::class)->withPivot('quantity','price');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
