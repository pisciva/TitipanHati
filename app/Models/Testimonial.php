<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'type',
        'content',
        'rating',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rating' => 'integer',
    ];

    // Scope untuk testimonial aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}