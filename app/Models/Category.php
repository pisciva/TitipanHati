<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'type',
    ];


    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_categories');
    }
}