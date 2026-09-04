<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminStudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('roles', 'user');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qb) use ($q) {
                $qb->where('name', 'like', "%{$q}%")
                   ->orWhere('email', 'like', "%{$q}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        if ($request->filled('program')) {
            $query->where('program', $request->program);
        }
        if ($request->filled('year_level')) {
            $query->where('year_level', $request->year_level);
        }

        $students = $query->latest()->get();
        $total    = User::where('roles', 'user')->count();
        return view('admin.students.index', compact('students', 'total'));
    }

    public function edit(User $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, User $student)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:users,email,' . $student->id,
            'program'    => 'nullable|string|max:100',
            'year_level' => 'nullable|string|max:100',
            'is_active'  => 'nullable|boolean',
        ]);

        $student->update([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'program'    => $validated['program'] ?? null,
            'year_level' => $validated['year_level'] ?? null,
            'is_active'  => $request->boolean('is_active', $student->is_active),
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', $student->name . '\'s account has been updated.');
    }

    public function toggleActive(User $student)
    {
        $student->update(['is_active' => ! $student->is_active]);
        $msg = $student->is_active ? 'Account activated.' : 'Account deactivated.';
        return back()->with('success', $msg);
    }

    public function destroy(User $student)
    {
        $student->delete();
        return back()->with('success', 'Student account deleted.');
    }
}
