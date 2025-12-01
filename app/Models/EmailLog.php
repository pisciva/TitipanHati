<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $fillable = [
        'donation_id',
        'user_id',
        'email_to',
        'email_type',
        'email_content',
        'is_sent',
        'sent_at',
    ];

    protected $casts = [
        'is_sent' => 'boolean',
        'sent_at' => 'datetime',
    ];


    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}