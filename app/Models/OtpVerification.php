<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    protected $fillable = [
        'email',
        'otp',
        'expires_at',
        'used',
        'attempts',
        'sent_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'sent_at'    => 'datetime',
        'used'       => 'boolean',
    ];
}
