<?php

namespace App\Http\Controllers;

use App\Models\Bengkel;
use Illuminate\Http\Request;

class BengkelController extends Controller
{
    public function index()
    {
        $bengkels = Bengkel::all();
        return view('bengkel.list.index', compact('bengkels'));
    }

    public function create()
    {
        return view('bengkel.list.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i',
            'is_verified' => 'boolean',
        ]);

        Bengkel::create($validatedData);

        return redirect()->route('bengkel.list.index')
            ->with('success', 'Bengkel berhasil dibuat.');
    }

    public function edit(Bengkel $bengkel)
    {
        return view('bengkel.list.update', compact('bengkel'));
    }

    public function update(Request $request, Bengkel $bengkel)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i',
            'is_verified' => 'boolean',
        ]);

        $bengkel->update($validatedData);

        return redirect()->route('bengkel.list.index')
            ->with('success', 'Bengkel berhasil diperbarui.');
    }

    public function destroy(Bengkel $bengkel)
    {
        $bengkel->delete();

        return redirect()->route('bengkel.list.index')
            ->with('success', 'Bengkel berhasil dihapus.');
    }

    public function indexMap() {
        $bengkels = Bengkel::where('is_verified', true)->get();
        return view('bengkel.map.index', compact('bengkels'));
    }
}
