<?php

namespace App\Http\Controllers;

use App\Models\Bengkel;
use App\Models\ServiceRequest;
use App\Enum\ServiceRequestStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    public function index()
    {
        $bengkels = Bengkel::where('is_verified', true)
            ->with('user', 'bengkelServices.service')
            ->get();
        
        return view('pengguna.bengkels.index', compact('bengkels'));
    }

    public function show(Bengkel $bengkel)
    {
        $bengkel->load('user', 'bengkelServices.service');
        return view('pengguna.bengkels.show', compact('bengkel'));
    }

    public function create(Bengkel $bengkel)
    {
        return view('pengguna.service-requests.create', compact('bengkel'));
    }

    public function store(Request $request, Bengkel $bengkel)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:1000',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ]);

        $serviceRequest = ServiceRequest::create([
            'bengkel_id' => $bengkel->id,
            'user_id' => Auth::id(),
            'description' => $validated['description'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'status' => ServiceRequestStatus::pending,
        ]);

        return redirect()
            ->route('service-requests.my-requests')
            ->with('success', 'Permintaan layanan berhasil dikirim!');
    }

    public function myRequests()
    {
        $serviceRequests = ServiceRequest::where('user_id', Auth::id())
            ->with('bengkel.user')
            ->latest()
            ->get();

        return view('pengguna.service-requests.my-requests', compact('serviceRequests'));
    }

    public function bengkelRequests()
    {
        $user = Auth::user();
        $bengkel = $user->bengkel;

        if (!$bengkel) {
            return redirect()->back()->with('error', 'Anda tidak memiliki bengkel yang terdaftar.');
        }

        $serviceRequests = ServiceRequest::where('bengkel_id', $bengkel->id)
            ->with('user')
            ->latest()
            ->get();

        return view('bengkel.service-requests.index', compact('serviceRequests', 'bengkel'));
    }

    public function bengkelRequestDetail(ServiceRequest $serviceRequest)
    {
        $user = Auth::user();
        $bengkel = $user->bengkel;

        if (!$bengkel || $serviceRequest->bengkel_id !== $bengkel->id) {
            abort(403, 'Akses tidak diizinkan ke permintaan layanan ini.');
        }

        $serviceRequest->load('user');

        return view('bengkel.service-requests.show', compact('serviceRequest', 'bengkel'));
    }

    public function updateStatus(Request $request, ServiceRequest $serviceRequest)
    {
        $user = Auth::user();
        $bengkel = $user->bengkel;

        if (!$bengkel || $serviceRequest->bengkel_id !== $bengkel->id) {
            abort(403, 'Akses tidak diizinkan ke permintaan layanan ini.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,otw,completed,cancelled',
        ]);

        $serviceRequest->update([
            'status' => ServiceRequestStatus::from($validated['status']),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Status permintaan layanan berhasil diperbarui!');
    }

    public function cancel(ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan ke permintaan layanan ini.');
        }

        if (!in_array($serviceRequest->status, [ServiceRequestStatus::pending, ServiceRequestStatus::accepted])) {
            return redirect()
                ->back()
                ->with('error', 'Tidak dapat membatalkan permintaan layanan yang sudah dalam proses atau selesai.');
        }

        $serviceRequest->update([
            'status' => ServiceRequestStatus::cancelled,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Permintaan layanan berhasil dibatalkan!');
    }
}
