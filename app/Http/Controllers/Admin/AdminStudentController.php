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
        $total    = \App\Models\User::where('roles', 'user')->count();
        return view('admin.students.index', compact('students', 'total'));
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
