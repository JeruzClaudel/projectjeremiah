<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Services;
use App\Http\Controllers\Controller;
use App\Models\Admin\Consultation;
use Illuminate\Http\Request;

class AdminServicesController extends Controller
{
    //
    public function indexService() {
        $services = Services::all();
        $page_data = ['services' => $services];
        return view('admin.services.services', $page_data);
    }

    public function addService(){
        $consultations = Consultation::all();
        return view('admin.services.services_add', compact('consultations'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:65000',
            'consultations_id' => 'nullable|string|max:10000',
        ]);

        $services = Services::create($validated);

        $id = $services->id;

        return redirect()->route('admin.services.details', $id)->with('added',  'Services has been added');
    }


    public function showService($id) {
        $services = Services::findOrFail($id);
        
        $page_data = ['services' => $services];

        return view('admin/services/services_details', $page_data);
    }

    /* EDIT  */
    public function editService($id) {
        $services = Services::findOrFail($id);
        $consultations = Consultation::all();

        return view('admin/services/services_edit', ['services' => $services, 'consultations' => $consultations]);
    }

    /* DELETE */
    public function delete (Services $id) {
        $id->delete();
        return redirect()->route('admin.services.dashboard')->with('deleted',  'Service has been deleted');
    }

    /* UPDATE */
    public function update(Request $request, Services $id) {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:65000',
            'consultations_id' => 'nullable|string|max:10000',
        ]);

        $id->name = $validated['name'];
        $id->description = $validated['description'];
        $id->consultations_id = $validated['consultations_id'] ?? null;

        $id->save();

        return redirect()->route('admin.services.details', $id)->with('updated',  'Services has been updated');
    }

}
