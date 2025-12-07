<x-layout.dashboard>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Permintaan Layanan #{{ $serviceRequest->id }}</h6>
                        <a href="{{ route('bengkel.service-requests.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <h6 class="mb-3">Informasi Pelanggan</h6>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="text-sm mb-2"><strong>Nama:</strong> {{ $serviceRequest->user->name }}</p>
                            <p class="text-sm mb-2"><strong>Email:</strong> {{ $serviceRequest->user->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-sm mb-2"><strong>Tanggal Permintaan:</strong> {{ $serviceRequest->created_at->format('d M Y, H:i') }}</p>
                            <p class="text-sm mb-2"><strong>Status:</strong> 
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-gradient-warning',
                                        'accepted' => 'bg-gradient-info',
                                        'otw' => 'bg-gradient-primary',
                                        'completed' => 'bg-gradient-success',
                                        'cancelled' => 'bg-gradient-secondary'
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Menunggu',
                                        'accepted' => 'Diterima',
                                        'otw' => 'Dalam Perjalanan',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan'
                                    ];
                                    $statusColor = $statusColors[$serviceRequest->status->name] ?? 'bg-gradient-secondary';
                                    $statusLabel = $statusLabels[$serviceRequest->status->name] ?? ucfirst($serviceRequest->status->name);
                                @endphp
                                <span class="badge {{ $statusColor }}">{{ $statusLabel }}</span>
                            </p>
                        </div>
                    </div>

                    <hr class="horizontal dark">

                    <h6 class="mb-3">Deskripsi Masalah</h6>
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <p class="text-sm mb-0">{{ $serviceRequest->description }}</p>
                        </div>
                    </div>

                    <h6 class="mb-3">Lokasi Pelanggan</h6>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="text-sm mb-2"><strong>Latitude:</strong> {{ $serviceRequest->latitude }}</p>
                            <p class="text-sm mb-2"><strong>Longitude:</strong> {{ $serviceRequest->longitude }}</p>
                        </div>
                        <div class="col-md-6">
                            <a href="https://www.google.com/maps?q={{ $serviceRequest->latitude }},{{ $serviceRequest->longitude }}" 
                               target="_blank" 
                               class="btn btn-info btn-sm">
                                <i class="fas fa-map-marker-alt me-2"></i>Buka di Google Maps
                            </a>
                            <a href="https://www.google.com/maps/dir/?api=1&origin={{ $bengkel->latitude }},{{ $bengkel->longitude }}&destination={{ $serviceRequest->latitude }},{{ $serviceRequest->longitude }}" 
                               target="_blank" 
                               class="btn btn-primary btn-sm">
                                <i class="fas fa-directions me-2"></i>Dapatkan Arah
                            </a>
                        </div>
                    </div>

                    <hr class="horizontal dark">

                    @if($serviceRequest->status->name !== 'completed' && $serviceRequest->status->name !== 'cancelled')
                    <h6 class="mb-3">Perbarui Status</h6>
                    <form action="{{ route('bengkel.service-requests.update-status', $serviceRequest) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <select name="status" class="form-select" required>
                                    <option value="">-- Pilih Status Baru --</option>
                                    @if($serviceRequest->status->name === 'pending')
                                        <option value="accepted">Terima Permintaan</option>
                                        <option value="cancelled">Tolak Permintaan</option>
                                    @endif
                                    @if($serviceRequest->status->name === 'accepted')
                                        <option value="otw">Dalam Perjalanan</option>
                                        <option value="cancelled">Batalkan</option>
                                    @endif
                                    @if($serviceRequest->status->name === 'otw')
                                        <option value="completed">Tandai Sebagai Selesai</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-2"></i>Perbarui Status
                                </button>
                            </div>
                        </div>
                    </form>
                    @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Permintaan layanan ini sudah {{ $statusLabels[$serviceRequest->status->name] ?? $serviceRequest->status->name }}. Tidak ada tindakan lebih lanjut yang tersedia.
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="tel:{{ $serviceRequest->user->phone ?? '' }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-phone me-2"></i>Hubungi Pelanggan
                        </a>
                        <a href="mailto:{{ $serviceRequest->user->email }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-envelope me-2"></i>Email Pelanggan
                        </a>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $serviceRequest->user->phone ?? '') }}" 
                           target="_blank" 
                           class="btn btn-outline-success btn-sm">
                            <i class="fab fa-whatsapp me-2"></i>WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header pb-0">
                    <h6>Timeline Status</h6>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-one-side">
                        <div class="timeline-block mb-3">
                            <span class="timeline-step {{ $serviceRequest->status->name === 'completed' ? 'bg-success' : 'bg-secondary' }}">
                                <i class="fas fa-check"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Selesai</h6>
                                @if($serviceRequest->status->name === 'completed')
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                        {{ $serviceRequest->updated_at->format('d M Y, H:i') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step {{ in_array($serviceRequest->status->name, ['otw', 'completed']) ? 'bg-primary' : 'bg-secondary' }}">
                                <i class="fas fa-car"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Dalam Perjalanan</h6>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step {{ in_array($serviceRequest->status->name, ['accepted', 'otw', 'completed']) ? 'bg-info' : 'bg-secondary' }}">
                                <i class="fas fa-handshake"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Diterima</h6>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step bg-warning">
                                <i class="fas fa-clock"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Menunggu</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    {{ $serviceRequest->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layout.dashboard>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-2"></i>Update Status
                                </button>
                            </div>
                        </div>
                    </form>
                    @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        This service request has been {{ $serviceRequest->status->name }}. No further actions are available.
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="tel:{{ $serviceRequest->user->phone ?? '' }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-phone me-2"></i>Call Customer
                        </a>
                        <a href="mailto:{{ $serviceRequest->user->email }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-envelope me-2"></i>Email Customer
                        </a>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $serviceRequest->user->phone ?? '') }}" 
                           target="_blank" 
                           class="btn btn-outline-success btn-sm">
                            <i class="fab fa-whatsapp me-2"></i>WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            <!-- Status History/Timeline -->
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Status Timeline</h6>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-one-side">
                        <div class="timeline-block mb-3">
                            <span class="timeline-step {{ $serviceRequest->status->name === 'completed' ? 'bg-success' : 'bg-secondary' }}">
                                <i class="fas fa-check"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Completed</h6>
                                @if($serviceRequest->status->name === 'completed')
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                        {{ $serviceRequest->updated_at->format('d M Y, H:i') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step {{ in_array($serviceRequest->status->name, ['otw', 'completed']) ? 'bg-primary' : 'bg-secondary' }}">
                                <i class="fas fa-car"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">On The Way</h6>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step {{ in_array($serviceRequest->status->name, ['accepted', 'otw', 'completed']) ? 'bg-info' : 'bg-secondary' }}">
                                <i class="fas fa-handshake"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Accepted</h6>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step bg-warning">
                                <i class="fas fa-clock"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Pending</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    {{ $serviceRequest->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layout.dashboard>
