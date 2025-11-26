<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $fillable = [
        'total_campaigns',
        'total_donations',
        'total_items_collected',
        'total_organizations',
        'recorded_date',
    ];

    protected $casts = [
        'recorded_date' => 'date',
        'total_campaigns' => 'integer',
        'total_donations' => 'integer',
        'total_items_collected' => 'integer',
        'total_organizations' => 'integer',
    ];
}