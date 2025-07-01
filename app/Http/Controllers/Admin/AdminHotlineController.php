<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\Hotline;

class AdminHotlineController extends Controller
{
    public function index() {
        $hotlines = Hotline::all();
        
        $page_data = ['hotlines' => $hotlines];

        return view('admin/hotlines/hotlines', $page_data);
    }

    public function show($id) {
        $hotline = Hotline::findOrFail($id);

        $page_data = ['hotlines' => $hotline];

        return view('admin/hotlines/hotlines_details', $page_data);
    }

    public function add() {
        return view('admin/hotlines/hotlines_add');
    }

    public function edit($id) {
        $hotline = Hotline::findOrFail($id);

        return view('admin/hotlines/hotlines_edit', ['hotlines' => $hotline,]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone_number' => 'required|string|max:10000',
            'email' => 'required|string|max:10000',
            'availability' => 'required|string|max:10000',
            'site_link' => 'nullable|string|max:10000',
        ]);

        $hotline = Hotline::create($validated);

        $id = $hotline->id;

        return redirect()->route('admin.hotline.details', $id)->with('added', 'Hotline has been added');
    }

    public function update(Request $request, Hotline $id) {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone_number' => 'required|string|max:10000',
            'email' => 'required|string|max:10000',
            'availability' => 'required|string|max:10000',
            'site_link' => 'nullable|string|max:10000',
        ]);

        $id->name = $validated['name'];
        $id->phone_number = $validated['phone_number'];
        $id->email = $validated['email'];
        $id->availability = $validated['availability'];
        $id->site_link = $validated['site_link'];

        $id->save();

        return redirect()->route('admin.hotline.details', $id)->with('updated', 'Hotline has been updated');
    }

    public function delete(Hotline $id) {
        $id->delete();
        return redirect()->route('admin.hotline.dashboard')->with('deleted', 'Hotline has been deleted');
    }
}
