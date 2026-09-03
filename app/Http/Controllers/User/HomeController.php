<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Link;
use App\Models\Quotes;

class HomeController extends Controller
{
    public function index()
    {
        $quote = Quotes::inRandomOrder()->first();
        return view('welcome', compact('quote'));
    }
}
