<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'description',
        'contact_email',
        'contact_phone',
        'address',
        'logo_url',
        'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    // Relasi One-to-Many dengan Campaigns
    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }
}