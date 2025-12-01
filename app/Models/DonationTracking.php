<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationTracking extends Model
{

    protected $table = 'donation_tracking';
    
    public $timestamps = false;

    protected $fillable = [
        'donation_id',
        'status',
        'notes',
        'status_changed_at',
    ];

    protected $casts = [
        'status_changed_at' => 'datetime',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}