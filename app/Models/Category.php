<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'type',
    ];

    // Relasi Many-to-Many dengan Campaigns
    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_categories');
    }
}