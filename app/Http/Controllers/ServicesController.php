<?php

namespace App\Http\Controllers;

use App\Models\Admin\Consultation;
use App\Models\Admin\Counselor;
use App\Models\Admin\Services;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    //
    public function index() {
        $services = Services::all();
        $counselors = Counselor::all();
        $consultations = Consultation::all();
        return view('user.services.services', compact('services', 'counselors', 'consultations'));
    }

    public function showService($id)
    {
        $service = Services::with('consultation')->findOrFail($id);
        return view('user.services.services_details', compact('service'));
    }     
}

