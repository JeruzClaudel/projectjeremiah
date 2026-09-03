<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportResource extends Model
{
    // Matches the actual columns present in support_resources
    protected $fillable = [
        'title',
        'description',
        'url',
        'type',
    ];
}
