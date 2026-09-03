<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportResource;
use Illuminate\Http\Request;

class AdminSupportResourceController extends Controller
{
    public function index()
    {
        $resources = SupportResource::latest()->get();
        return view('admin.support.index', compact('resources'));
    }

    public function add()
    {
        return view('admin.support.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'url'         => 'nullable|url|max:2048',
            'type'        => 'nullable|string|max:100',
        ]);

        SupportResource::create($validated);
        return redirect()->route('admin.support.index')
            ->with('success', 'Resource added successfully.');
    }

    public function edit($id)
    {
        $resource = SupportResource::findOrFail($id);
        return view('admin.support.edit', compact('resource'));
    }

    public function update(Request $request, $id)
    {
        $resource = SupportResource::findOrFail($id);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'url'         => 'nullable|url|max:2048',
            'type'        => 'nullable|string|max:100',
        ]);

        $resource->update($validated);
        return redirect()->route('admin.support.details', $id)
            ->with('success', 'Resource updated successfully.');
    }

    public function delete($id)
    {
        SupportResource::findOrFail($id)->delete();
        return redirect()->route('admin.support.index')
            ->with('success', 'Resource deleted.');
    }

    public function show($id)
    {
        $resource = SupportResource::findOrFail($id);
        return view('admin.support.details', compact('resource'));
    }
}
