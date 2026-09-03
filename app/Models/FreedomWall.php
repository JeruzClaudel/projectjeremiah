<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreedomWall extends Model
{
    protected $fillable = [
        'postName',
        'student_email',
        'post',
        'program',
        'year_level',
        'sentiment',
        'ai_sentiment',
        'ai_emotion_category',
        'ai_confidence',
        'ai_counselor_note',
        'ai_flagged',
        'ai_raw',
    ];

    protected $casts = [
        'ai_flagged' => 'boolean',
        'ai_raw'     => 'array',
    ];
}
