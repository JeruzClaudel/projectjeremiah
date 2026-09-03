<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HighRiskAlert extends Model
{
    protected $fillable = [
        'freedom_wall_id',
        'sent_by',
        'recipients',
        'sent_at',
    ];

    protected $casts = [
        'recipients' => 'array',
        'sent_at'    => 'datetime',
    ];

    public function post()
    {
        return $this->belongsTo(FreedomWall::class, 'freedom_wall_id');
    }
}
