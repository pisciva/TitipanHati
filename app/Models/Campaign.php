<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'organization_id',
        'title',
        'description',
        'banner_url',
        'province',
        'city',
        'target_quantity',
        'collected_quantity',
        'deadline',
        'status',
        'view_count',
    ];

    protected $casts = [
        'deadline' => 'date',
        'target_quantity' => 'integer',
        'collected_quantity' => 'integer',
        'view_count' => 'integer',
    ];


    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'campaign_categories');
    }


    public function donations()
    {
        return $this->hasMany(Donation::class);
    }


    public function isActive()
    {
        return $this->status === 'aktif';
    }


    public function progressPercentage()
    {
        if ($this->target_quantity == 0)
            return 0;
        return min(100, round(($this->collected_quantity / $this->target_quantity) * 100));
    }

    public function views()
    {
        return $this->hasMany(CampaignView::class);
    }

    public function uniqueViewsCount()
    {
        return $this->views()
            ->distinct('ip_address')
            ->count('ip_address');
    }
}