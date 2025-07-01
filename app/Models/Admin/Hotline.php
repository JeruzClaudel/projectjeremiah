<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotline extends Model
{
    /** @use HasFactory<\Database\Factories\Admin\HotlineFactory> */
    use HasFactory;

    protected $fillable = ['name', 'phone_number', 'email', 'availability', 'site_link'];
}
