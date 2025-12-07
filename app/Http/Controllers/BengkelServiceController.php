<?php

namespace App\Http\Controllers;

use App\Models\Bengkel;
use App\Models\Service;
use App\Models\BengkelService;
use Illuminate\Http\Request;

class BengkelServiceController extends Controller
{
    public function index()
    {
        $bengkels = Bengkel::with(['bengkelServices.service', 'owner'])->get();
        return view('admin.bengkel-services.index', compact('bengkels'));
    }

    public function manage(Bengkel $bengkel)
    {
        $bengkel->load(['bengkelServices.service', 'owner']);
        $allServices = Service::all();
        $assignedServiceIds = $bengkel->bengkelServices->pluck('service_id')->toArray();
        
        return view('admin.bengkel-services.manage', compact('bengkel', 'allServices', 'assignedServiceIds'));
    }

    public function update(Request $request, Bengkel $bengkel)
    {
        $request->validate([
            'services' => 'nullable|array',
            'services.*' => 'exists:services,id',
        ]);

        $bengkel->bengkelServices()->delete();

        if ($request->has('services')) {
            foreach ($request->services as $serviceId) {
                BengkelService::create([
                    'bengkel_id' => $bengkel->id,
                    'service_id' => $serviceId,
                ]);
            }
        }

        return redirect()->route('admin.bengkel-services.index')
            ->with('success', 'Layanan bengkel berhasil diperbarui.');
    }

    public function addService(Request $request, Bengkel $bengkel)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        BengkelService::create([
            'bengkel_id' => $bengkel->id,
            'service_id' => $request->service_id,
        ]);

        return redirect()->route('admin.bengkel-services.manage', $bengkel->id)
            ->with('success', 'Layanan berhasil ditambahkan ke bengkel.');
    }
}
