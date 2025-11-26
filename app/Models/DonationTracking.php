<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationTracking extends Model
{
    public $timestamps = false; // Karena hanya pakai status_changed_at

    protected $fillable = [
        'donation_id',
        'status',
        'notes',
        'status_changed_at',
    ];

    protected $casts = [
        'status_changed_at' => 'datetime',
    ];

    // Relasi belongs to Donation
    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}