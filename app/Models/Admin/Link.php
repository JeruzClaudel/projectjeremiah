<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'name',
        'url',
        'icon',
        'category',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
