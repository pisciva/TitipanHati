<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'phone_number',
        'default_address',
        'default_province',
        'default_city',
        'default_district',
        'default_postal_code',
        'default_notes',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}