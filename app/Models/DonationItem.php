<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationItem extends Model
{
    protected $fillable = [
        'donation_id',
        'gender',
        'item_category',
        'quantity',
        'condition',
        'photo_url',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // Relasi belongs to Donation
    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}