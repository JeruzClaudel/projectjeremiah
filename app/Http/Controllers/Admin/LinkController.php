<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function index()
    {
        $links = Link::latest()->get();
        return view('admin.link.index', compact('links'));
    }

    public function add()
    {
        return view('admin.link.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'url'       => 'required|url|max:2048',
            'icon'      => 'nullable|string|max:100',
            'category'  => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        Link::create([
            'name'      => $validated['name'],
            'url'       => $validated['url'],
            'icon'      => $validated['icon'] ?? null,
            'category'  => $validated['category'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.link.index')->with('success', 'Link added successfully.');
    }

    public function details($id)
    {
        $link = Link::findOrFail($id);
        return view('admin.link.details', compact('link'));
    }

    public function edit($id)
    {
        $link = Link::findOrFail($id);
        return view('admin.link.edit', compact('link'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'url'       => 'required|url|max:2048',
            'icon'      => 'nullable|string|max:100',
            'category'  => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        $link = Link::findOrFail($id);
        $link->update([
            'name'      => $validated['name'],
            'url'       => $validated['url'],
            'icon'      => $validated['icon'] ?? null,
            'category'  => $validated['category'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.link.details', $id)->with('success', 'Link updated.');
    }

    public function destroy($id)
    {
        Link::findOrFail($id)->delete();
        return redirect()->route('admin.link.index')->with('success', 'Link removed.');
    }
}
