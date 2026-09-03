<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Services;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminServicesController extends Controller
{
    public function indexService()
    {
        $services = Services::all();
        return view('admin.services.services', ['services' => $services]);
    }

    public function addService()
    {
        // No longer passes $consultations — link is a free-text URL field
        return view('admin.services.services_add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:100',
            'description'      => 'required|string|max:65000',
            // Only required when the checkbox is ticked
            'consultations_id' => 'nullable|url|max:2048',
        ]);

        // If checkbox not ticked, clear the URL
        if (! $request->boolean('has_link')) {
            $validated['consultations_id'] = null;
        }

        $service = Services::create($validated);

        return redirect()
            ->route('admin.services.details', $service->id)
            ->with('added', 'Service has been added.');
    }

    public function showService($id)
    {
        $services  = Services::findOrFail($id);
        return view('admin/services/services_details', ['services' => $services]);
    }

    public function editService($id)
    {
        $services = Services::findOrFail($id);
        // No longer passes $consultations
        return view('admin/services/services_edit', ['services' => $services]);
    }

    public function delete(Services $id)
    {
        $id->delete();
        return redirect()
            ->route('admin.services.dashboard')
            ->with('deleted', 'Service has been deleted.');
    }

    public function update(Request $request, Services $id)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:100',
            'description'      => 'required|string|max:65000',
            'consultations_id' => 'nullable|url|max:2048',
        ]);

        // If checkbox not ticked, clear the URL
        if (! $request->boolean('has_link')) {
            $validated['consultations_id'] = null;
        }

        $id->name             = $validated['name'];
        $id->description      = $validated['description'];
        $id->consultations_id = $validated['consultations_id'] ?? null;
        $id->save();

        return redirect()
            ->route('admin.services.details', $id)
            ->with('updated', 'Service has been updated.');
    }
}
