<?php

namespace App\Http\Controllers;

use App\Enum\UserRole;
use App\Models\User;
use App\Models\ServiceRequest;
use App\Models\BengkelService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // User Statistics
        $userCount = User::where('role', UserRole::PUBLIC->value)->count();
        $bengkelCount = User::where('role', UserRole::BENGKEL->value)->count();
        $newUsersThisWeek = User::where('created_at', '>=', $startOfWeek)->count();

        // Service Request Statistics
        $emergencyRequests = ServiceRequest::where('is_emergency', true)->count();
        $handledVehicles = ServiceRequest::whereIn('status', ['accepted', 'otw', 'completed'])->count();
        $pendingRequests = ServiceRequest::where('status', 'pending')->count();
        $completedRequests = ServiceRequest::where('status', 'completed')->count();
        $inProgressRequests = ServiceRequest::whereIn('status', ['accepted', 'otw'])->count();
        
        // Recent Activities
        $recentRequests = ServiceRequest::with(['user', 'bengkel'])
            ->latest()
            ->take(5)
            ->get();

        // Weekly Stats
        $weeklyStats = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $count = ServiceRequest::whereDate('created_at', $date)->count();
            $weeklyStats[] = [
                'day' => $date->shortDayName,
                'count' => $count
            ];
        }

        // Bengkel Services
        $popularServices = BengkelService::with('service')
            ->selectRaw('service_id, COUNT(*) as service_count')
            ->groupBy('service_id')
            ->orderByDesc('service_count')
            ->take(5)
            ->get();

        return view('dashboard.admin.index', [
            'userCount' => $userCount,
            'bengkelCount' => $bengkelCount,
            'emergencyRequests' => $emergencyRequests,
            'handledVehicles' => $handledVehicles,
            'pendingRequests' => $pendingRequests,
            'completedRequests' => $completedRequests,
            'inProgressRequests' => $inProgressRequests,
            'recentRequests' => $recentRequests,
            'weeklyStats' => $weeklyStats,
            'popularServices' => $popularServices,
            'newUsersThisWeek' => $newUsersThisWeek,
        ]);
    }
}
