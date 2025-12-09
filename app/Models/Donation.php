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
        'pickup_province',
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


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }


    public function items()
    {
        return $this->hasMany(DonationItem::class);
    }


    public function tracking()
    {
        return $this->hasMany(DonationTracking::class);
    }


    public function emailLogs()
    {
        return $this->hasMany(EmailLog::class);
    }


    public function totalQuantity()
    {
        return $this->items()->sum('quantity');
    }
}