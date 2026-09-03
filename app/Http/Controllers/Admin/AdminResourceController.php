<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportResource;

class AdminResourceController extends Controller
{
    public function index()
    {
        $resources = SupportResource::latest()->get();
        return view('admin.resources.index', compact('resources'));
    }
}
