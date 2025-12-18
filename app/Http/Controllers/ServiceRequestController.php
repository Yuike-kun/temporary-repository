<?php

namespace App\Http\Controllers;

use App\Models\Bengkel;
use App\Models\ServiceRequest;
use App\Enum\ServiceRequestStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function bengkelRequests(Request $request)
    {
        $user = Auth::user();
        $bengkel = $user->bengkel;

        if (!$bengkel) {
            return redirect()->back()->with('error', 'Anda tidak memiliki bengkel yang terdaftar.');
        }

        // Build query
        $query = ServiceRequest::where('bengkel_id', $bengkel->id)->with('user');

        // Apply status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', ServiceRequestStatus::from($request->status));
        }

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Apply date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'newest');
        switch ($sortBy) {
            case 'oldest':
                $query->oldest();
                break;
            case 'customer':
                $query->join('users', 'service_requests.user_id', '=', 'users.id')
                      ->orderBy('users.name')
                      ->select('service_requests.*');
                break;
            default: // newest
                $query->latest();
                break;
        }

        $serviceRequests = $query->get();

        return view('bengkel.service-requests.index', compact('serviceRequests', 'bengkel'));
    }

    /**
     * Display a listing of service requests for admin
     */
    public function adminIndex()
    {
        $serviceRequests = ServiceRequest::with(['user', 'bengkel'])
            ->latest()
            ->paginate(15);

        return view('admin.service-requests.index', compact('serviceRequests'));
    }

    /**
     * Display the specified service request for admin
     */
    public function adminShow(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load(['user', 'bengkel', 'review']);
        return view('admin.service-requests.show', compact('serviceRequest'));
    }

    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        $bengkel = $user->bengkel;

        if (!$bengkel) {
            return redirect()->back()->with('error', 'Anda tidak memiliki bengkel yang terdaftar.');
        }

        // Get filter parameters
        $status = $request->get('status');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        // Build query
        $query = ServiceRequest::where('bengkel_id', $bengkel->id)->with('user');

        // Apply filters
        if ($status && $status !== 'all') {
            $query->where('status', ServiceRequestStatus::from($status));
        }

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $serviceRequests = $query->latest()->get();

        // Calculate statistics
        $stats = [
            'total' => $serviceRequests->count(),
            'pending' => $serviceRequests->where('status', ServiceRequestStatus::pending)->count(),
            'accepted' => $serviceRequests->where('status', ServiceRequestStatus::accepted)->count(),
            'otw' => $serviceRequests->where('status', ServiceRequestStatus::otw)->count(),
            'completed' => $serviceRequests->where('status', ServiceRequestStatus::completed)->count(),
            'cancelled' => $serviceRequests->where('status', ServiceRequestStatus::cancelled)->count(),
        ];

        $pdf = Pdf::loadView('bengkel.service-requests.pdf', [
            'bengkel' => $bengkel,
            'serviceRequests' => $serviceRequests,
            'stats' => $stats,
            'filters' => [
                'status' => $status,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
            ]
        ]);

        $filename = 'Laporan_Permintaan_Layanan_' . $bengkel->name . '_' . now()->format('Y-m-d_His') . '.pdf';

        return $pdf->download($filename);
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
