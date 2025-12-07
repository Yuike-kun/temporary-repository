<x-layout.dashboard>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>{{ $bengkel->name }}</h6>
                        <a href="{{ route('service-requests.index') }}" class="btn btn-sm btn-secondary">Kembali ke Daftar</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-sm mb-2"><strong>Pemilik:</strong> {{ $bengkel->user->name }}</p>
                            <p class="text-sm mb-2"><strong>Email:</strong> {{ $bengkel->user->email }}</p>
                            <p class="text-sm mb-2"><strong>Telepon:</strong> {{ $bengkel->phone }}</p>
                            <p class="text-sm mb-2"><strong>Alamat:</strong> {{ $bengkel->address }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-sm mb-2"><strong>Jam Operasional:</strong></p>
                            <p class="text-sm mb-2">
                                {{ \Carbon\Carbon::parse($bengkel->open_time)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($bengkel->close_time)->format('H:i') }}
                            </p>
                            <p class="text-sm mb-2"><strong>Status:</strong> 
                                <span class="badge badge-sm bg-gradient-success">Terverifikasi</span>
                            </p>
                        </div>
                    </div>

                    <hr class="horizontal dark">

                    <h6 class="mb-3">Layanan Tersedia</h6>
                    @if($bengkel->bengkelServices && $bengkel->bengkelServices->count() > 0)
                    <div class="row">
                        @foreach($bengkel->bengkelServices as $bengkelService)
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body p-3">
                                    <p class="text-sm font-weight-bold mb-1">{{ $bengkelService->service->name ?? 'Layanan' }}</p>
                                    <p class="text-xs text-secondary mb-0">Harga: Rp {{ number_format($bengkelService->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-sm text-secondary">Belum ada layanan yang terdaftar.</p>
                    @endif

                    <hr class="horizontal dark">

                    <div class="text-center">
                        <a href="{{ route('service-requests.create', $bengkel) }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-wrench me-2"></i>Minta Layanan Darurat
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Peta Lokasi</h6>
                </div>
                <div class="card-body">
                    <div id="map" style="height: 400px; border-radius: 0.5rem;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mapDiv = document.getElementById('map');
        if (mapDiv) {
            mapDiv.innerHTML = '<div class="text-center p-5"><p class="text-secondary">Peta akan ditampilkan di sini</p><p class="text-xs">Latitude: {{ $bengkel->latitude }}<br>Longitude: {{ $bengkel->longitude }}</p></div>';
        }
    });
</script>
@endpush
</x-layout.dashboard>
