<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcapperRating extends Model
{
    use HasFactory;

    protected $table = 'ecapper_rating';

    protected $fillable = [
        'ecapper_id',
        'free',
        'lean',
        'reg',
        'strong',
        'topplay',
    ];
}
