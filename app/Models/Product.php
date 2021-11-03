<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        "price",
        "weekly_price",
        "img",
        "status",
        "expire_date",
        "season_price_expire_date",
        "weekly_price_expire_date",
        "display_date",
        "delivery_method",
        "category_id"
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function orders(){
        return $this->belongsToMany(Order::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }
}
