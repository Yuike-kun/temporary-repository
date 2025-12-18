@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Daftar Permintaan Layanan</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pelanggan</th>
                            <th>Bengkel</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($serviceRequests as $request)
                            <tr>
                                <td>#{{ $request->id }}</td>
                                <td>{{ $request->user->name ?? 'N/A' }}</td>
                                <td>{{ $request->bengkel->name ?? 'N/A' }}</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-warning',
                                            'accepted' => 'bg-info',
                                            'otw' => 'bg-primary',
                                            'completed' => 'bg-success',
                                            'cancelled' => 'bg-secondary'
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Menunggu',
                                            'accepted' => 'Diterima',
                                            'otw' => 'Dalam Perjalanan',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan'
                                        ];
                                        $statusColor = $statusColors[$request->status] ?? 'bg-secondary';
                                        $statusLabel = $statusLabels[$request->status] ?? ucfirst($request->status);
                                    @endphp
                                    <span class="badge {{ $statusColor }}">{{ $statusLabel }}</span>
                                </td>
                                <td>{{ $request->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.service-requests.show', $request) }}" class="btn btn-sm btn-icon btn-outline-primary">
                                        <i data-lucide="eye" class="size-4"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">Tidak ada permintaan layanan</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($serviceRequests->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $serviceRequests->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
