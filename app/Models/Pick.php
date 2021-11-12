<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pick extends Model
{
    use HasFactory;

    protected $table = 'picks2';

    protected $fillable = [
        'ecapper_id',
        'title',
        'teaser',
        'body',
        'active_date',
        'expiration_date',
        'created_date',
        'price',
        'price_id',
        'sport',
        'type',
        'is_released',
        'is_featured',
        'outcome_wl',
        'purchases',
        'wl_processed_date',
        'is_done',
        'league_id',
        'event_id',
        'rating_type',
        'pitcher',
        'tplay_designation',
        'tplay_title',
        'selected_element',
        'element_value',
        'rot_id',
        'side',
        'team_name',
        'event_datetime',
        'ticket_type',
        'profit',
        'juice',
        'score',
        'grade_executed_by',
        'modified_by',
        'modified_datetime',
        'is_expired',
        'group_key',
    ];
}
