<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Models\User\Hotline;

use App\Http\Controllers\Controller;

class HotlineController extends Controller
{
    public function index()
    {
        $hotlines = Hotline::all();

        $page_data = ['entries' => $hotlines];

        return view('user/hotlines/hotlines', $page_data);
    }
}
