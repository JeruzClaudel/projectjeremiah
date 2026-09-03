<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SentimentKeyword extends Model
{
    protected $fillable = ['word', 'category'];
}
