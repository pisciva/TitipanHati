<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'user_id',
        'campaign_id',
        'donor_name',
        'donor_phone',
        'donor_email',
        'pickup_address',
        'pickup_city',
        'pickup_district',
        'pickup_postal_code',
        'pickup_notes',
        'pickup_date',
        'pickup_time_slot',
        'status',
    ];

    protected $casts = [
        'pickup_date' => 'date',
    ];

    // Relasi belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi belongs to Campaign
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    // Relasi One-to-Many dengan DonationItems
    public function items()
    {
        return $this->hasMany(DonationItem::class);
    }

    // Relasi One-to-Many dengan DonationTracking
    public function tracking()
    {
        return $this->hasMany(DonationTracking::class);
    }

    // Relasi One-to-Many dengan EmailLogs
    public function emailLogs()
    {
        return $this->hasMany(EmailLog::class);
    }

    // Helper: Get total items quantity
    public function totalQuantity()
    {
        return $this->items()->sum('quantity');
    }
}