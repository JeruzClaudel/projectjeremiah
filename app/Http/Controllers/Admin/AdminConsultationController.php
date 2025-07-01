<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\Consultation;

class AdminConsultationController extends Controller
{
    public function index() {
        $consultation = Consultation::all();
        
        $page_data = ['consultations' => $consultation];

        return view('admin/consultation/consultation', $page_data);
    }

    public function show($id) {
        $consultation = Consultation::findOrFail($id);

        $page_data = ['consultation' => $consultation];

        return view('admin/consultation/consultation_details', $page_data);
    }

    public function add() {
        return view('admin/consultation/consultation_add');
    }

    public function edit($id) {
        $consultation = Consultation::findOrFail($id);

        return view('admin/consultation/consultation_edit', ['consultations' => $consultation]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:65000',
            'request_link' => 'required|string|max:10000',
        ]);

        $consultation = Consultation::create($validated);

        $id = $consultation->id;

        return redirect()->route('admin.consultation.details', $id)->with('added',  'Consultation link has been added');
    }

    public function update(Request $request, Consultation $id) {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:65000',
            'request_link' => 'required|string|max:10000',
        ]);

        $id->name = $validated['name'];
        $id->description = $validated['description'];
        $id->request_link = $validated['request_link'];

        $id->save();

        return redirect()->route('admin.consultation.details', $id)->with('updated',  'Consultation link has been updated');
    }

    public function delete (Consultation $id) {
        $id->delete();
        return redirect()->route('admin.consultation.dashboard')->with('deleted',  'Consultation link has been deleted');
    }
}
