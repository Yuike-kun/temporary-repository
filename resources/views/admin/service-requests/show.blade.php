@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Detail Permintaan Layanan #{{ $serviceRequest->id }}</h1>
        <a href="{{ route('admin.service-requests.index') }}" class="btn btn-outline-secondary">
            <i data-lucide="arrow-left" class="size-4 mr-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Permintaan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6>Deskripsi</h6>
                        <p class="text-muted">{{ $serviceRequest->description ?? '-' }}</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Status</h6>
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
                                $statusColor = $statusColors[$serviceRequest->status] ?? 'bg-secondary';
                                $statusLabel = $statusLabels[$serviceRequest->status] ?? ucfirst($serviceRequest->status);
                            @endphp
                            <span class="badge {{ $statusColor }}">{{ $statusLabel }}</span>
                        </div>
                        <div class="col-md-6">
                            <h6>Tanggal Permintaan</h6>
                            <p class="text-muted">{{ $serviceRequest->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($serviceRequest->review)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Ulasan Pelanggan</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="mr-3">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $serviceRequest->review->rating)
                                    <i data-lucide="star" class="text-warning"></i>
                                @else
                                    <i data-lucide="star" class="text-muted"></i>
                                @endif
                            @endfor
                        </div>
                        <div>
                            <strong>{{ $serviceRequest->review->rating }}/5</strong>
                        </div>
                    </div>
                    <div class="border rounded p-3 bg-light">
                        {{ $serviceRequest->review->comment }}
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Pelanggan</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar bg-primary text-white rounded-circle size-10 mr-3">
                            <i data-lucide="user" class="size-5"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $serviceRequest->user->name ?? 'N/A' }}</h6>
                            <small class="text-muted">Pelanggan</small>
                        </div>
                    </div>
                    <div class="mb-2">
                        <i data-lucide="mail" class="size-4 text-muted mr-2"></i>
                        <span class="text-muted">{{ $serviceRequest->user->email ?? 'N/A' }}</span>
                    </div>
                    <div class="mb-2">
                        <i data-lucide="phone" class="size-4 text-muted mr-2"></i>
                        <span class="text-muted">{{ $serviceRequest->user->phone ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Bengkel</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar bg-success text-white rounded-circle size-10 mr-3">
                            <i data-lucide="home" class="size-5"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $serviceRequest->bengkel->name ?? 'N/A' }}</h6>
                            <small class="text-muted">Bengkel</small>
                        </div>
                    </div>
                    <div class="mb-2">
                        <i data-lucide="map-pin" class="size-4 text-muted mr-2"></i>
                        <span class="text-muted">{{ $serviceRequest->bengkel->address ?? 'N/A' }}</span>
                    </div>
                    <div class="mb-2">
                        <i data-lucide="phone" class="size-4 text-muted mr-2"></i>
                        <span class="text-muted">{{ $serviceRequest->bengkel->phone ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialize any necessary JavaScript here
    document.addEventListener('DOMContentLoaded', function() {
        // Add any JavaScript functionality needed for this page
    });
</script>
@endpush

@endsection
