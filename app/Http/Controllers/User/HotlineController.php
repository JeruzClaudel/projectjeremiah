<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Hotline;
use App\Models\SupportResource;

class HotlineController extends Controller
{
    public function index()
    {
        $hotlines  = Hotline::all();
        $resources = SupportResource::latest()->get();

        return view('user.hotlines.hotlines', [
            'entries'   => $hotlines,
            'resources' => $resources,
        ]);
    }

    public function show($id)
    {
        $hotline = Hotline::findOrFail($id);
        return view('user.hotlines.hotline_details', compact('hotline'));
    }
}
