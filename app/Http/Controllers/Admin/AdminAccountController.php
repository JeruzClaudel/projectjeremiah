<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminAccountController extends Controller
{
    public function index()
    {
        $accounts = User::where('roles', 'admin')->orWhere('roles', 'superadmin')->get();
        return view('admin.accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('admin.accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email|max:255',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'roles'    => 'admin',
        ]);

        return redirect()->route('admin.accounts.index')->with('success', 'Account created.');
    }

    public function edit(User $account)
    {
        return view('admin.accounts.edit', compact('account'));
    }

    public function update(Request $request, User $account)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $account->id,
        ]);

        $account->update(['name' => $request->name, 'email' => $request->email]);

        if ($request->filled('password')) {
            $request->validate(['password' => ['confirmed', Password::defaults()]]);
            $account->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.accounts.index')->with('success', 'Account updated.');
    }

    public function destroy(User $account)
    {
        $protectedIds = array_map('intval', explode(',', config('app.protected_admin_ids', '1,2')));

        if (in_array($account->id, $protectedIds)) {
            return back()->with('error', 'This account is protected and cannot be deleted.');
        }

        $account->delete();
        return redirect()->route('admin.accounts.index')->with('success', 'Account deleted.');
    }
}
