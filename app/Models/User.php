<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'email',
        'password',
        'role',
        'google_id',
        'is_verified',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    // Relasi One-to-One dengan UserProfile
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    // Relasi One-to-Many dengan Donations
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    // Relasi One-to-Many dengan EmailLogs
    public function emailLogs()
    {
        return $this->hasMany(EmailLog::class);
    }
}