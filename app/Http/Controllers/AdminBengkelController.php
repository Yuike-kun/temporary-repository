<?php

namespace App\Http\Controllers;

use App\Enum\UserRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminBengkelController extends Controller
{
    /**
     * Display a listing of admin bengkel accounts.
     */
    public function index()
    {
        $adminBengkels = User::where('role', UserRole::BENGKEL->value)->get();
        return view('admin-bengkel.index', compact('adminBengkels'));
    }

    /**
     * Show the form for creating a new admin bengkel account.
     */
    public function create()
    {
        return view('admin-bengkel.create');
    }

    /**
     * Store a newly created admin bengkel account.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['role'] = UserRole::BENGKEL;

        if ($request->hasFile('avatar')) {
            $validatedData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        User::create($validatedData);

        return redirect()->route('admin-bengkel.index')
            ->with('success', 'Akun Admin Bengkel berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified admin bengkel account.
     */
    public function edit(User $adminBengkel)
    {
        return view('admin-bengkel.update', compact('adminBengkel'));
    }

    /**
     * Update the specified admin bengkel account.
     */
    public function update(Request $request, User $adminBengkel)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $adminBengkel->id,
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $validatedData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $validatedData['role'] = UserRole::BENGKEL;

        $adminBengkel->update($validatedData);

        return redirect()->route('admin-bengkel.index')
            ->with('success', 'Akun Admin Bengkel berhasil diperbarui.');
    }

    /**
     * Remove the specified admin bengkel account.
     */
    public function destroy(User $adminBengkel)
    {
        $adminBengkel->delete();

        return redirect()->route('admin-bengkel.index')
            ->with('success', 'Akun Admin Bengkel berhasil dihapus.');
    }
}
