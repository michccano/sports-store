<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "invoice",
        "total_bill",
        "card_payment_amount",
        "token_payment_amount",
        "message_code",
        "transactionId",
        "cardNumber",
        'user_id',
    ];
    public function products(){
        return $this->belongsToMany(Product::class)->withPivot('quantity','price','type');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function seasonalProduct(){
        return $this->products()->wherePivot('type', 'seasonal');
    }
}
