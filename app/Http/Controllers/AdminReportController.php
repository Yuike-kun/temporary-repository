<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Enum\ServiceRequestStatus;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ServiceRequestsExport;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceRequest::with(['user', 'bengkel']);

        // Apply filters
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', ServiceRequestStatus::from($request->status));
        }

        if ($request->has('bengkel_id') && $request->bengkel_id) {
            $query->where('bengkel_id', $request->bengkel_id);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('bengkel', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $serviceRequests = $query->latest()->paginate(20);

        // Statistics
        $stats = [
            'total' => ServiceRequest::count(),
            'pending' => ServiceRequest::where('status', ServiceRequestStatus::pending)->count(),
            'accepted' => ServiceRequest::where('status', ServiceRequestStatus::accepted)->count(),
            'otw' => ServiceRequest::where('status', ServiceRequestStatus::otw)->count(),
            'completed' => ServiceRequest::where('status', ServiceRequestStatus::completed)->count(),
            'cancelled' => ServiceRequest::where('status', ServiceRequestStatus::cancelled)->count(),
        ];

        // Get bengkels for filter
        $bengkels = \App\Models\Bengkel::orderBy('name')->get();

        return view('admin.laporan.darurat', compact('serviceRequests', 'stats', 'bengkels'));
    }

    public function exportPdf(Request $request)
    {
        $query = ServiceRequest::with(['user', 'bengkel']);

        // Apply filters
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', ServiceRequestStatus::from($request->status));
        }

        if ($request->has('bengkel_id') && $request->bengkel_id) {
            $query->where('bengkel_id', $request->bengkel_id);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
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

        $pdf = Pdf::loadView('admin.laporan.pdf', [
            'serviceRequests' => $serviceRequests,
            'stats' => $stats,
            'filters' => [
                'status' => $request->status,
                'bengkel_id' => $request->bengkel_id,
                'date_from' => $request->date_from,
                'date_to' => $request->date_to,
            ]
        ]);

        $filename = 'Laporan_Darurat_' . now()->format('Y-m-d_His') . '.pdf';

        return $pdf->download($filename);
    }

    public function exportExcel(Request $request)
    {
        $filters = [
            'status' => $request->status,
            'bengkel_id' => $request->bengkel_id,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ];

        $filename = 'Laporan_Darurat_' . now()->format('Y-m-d_His') . '.xlsx';

        return Excel::download(new ServiceRequestsExport($filters), $filename);
    }
}
