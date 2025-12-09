<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignView extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'campaign_id',
        'ip_address',
        'user_agent',
        'user_id',
        'viewed_at'
    ];

    protected $casts = [
        'viewed_at' => 'datetime'
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}