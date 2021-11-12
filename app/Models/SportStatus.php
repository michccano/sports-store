<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SportStatus extends Model
{
    use HasFactory;

    protected $table = 'sport_status';
    protected $fillable = [
        'sport_id',
        'league_id',
        'status',
        'sport_name',
        'sport_abbreviation',
        'league_name',
        'league_abbreviation',
        'sport_image',
        'modified_by',
        'playoffs_series',
    ];

}
