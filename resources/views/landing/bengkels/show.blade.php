@push('script')
    <script src="{{ asset('assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>
@endpush

<x-layout.app>
    <div class="breadcrumb-bar breadcrumb-bg-06 text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title mb-2">{{ $bengkel->name }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="/"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('bengkels.grid') }}">Bengkel</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $bengkel->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <div class="row">
                
                <div class="col-lg-8 mb-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h3 class="mb-2">{{ $bengkel->name }}</h3>
                                    @if($bengkel->is_verified)
                                    <span class="badge bg-success">
                                        <i class="isax isax-shield-tick"></i> Terverifikasi
                                    </span>
                                    @endif
                                </div>
                                @if($bengkel->reviews_count > 0)
                                <div class="text-end">
                                    <div class="badge bg-warning text-dark fs-5 mb-1">
                                        <i class="isax isax-star1"></i> {{ number_format($bengkel->reviews_avg_rating, 1) }}
                                    </div>
                                    <div class="text-muted small">{{ $bengkel->reviews_count }} ulasan</div>
                                </div>
                                @endif
                            </div>

                            <hr>

                            <h5 class="mb-3"><i class="isax isax-info-circle text-primary"></i> Informasi Bengkel</h5>
                            
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-start">
                                        <i class="isax isax-user fs-4 text-primary me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Pemilik</small>
                                            <strong>{{ $bengkel->owner->name }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-start">
                                        <i class="isax isax-call fs-4 text-primary me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Telepon</small>
                                            <strong>{{ $bengkel->phone }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-start">
                                        <i class="isax isax-clock fs-4 text-primary me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Jam Operasional</small>
                                            <strong>{{ $bengkel->operating_hours }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-start">
                                        <i class="isax isax-calendar fs-4 text-primary me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Bergabung Sejak</small>
                                            <strong>{{ $bengkel->created_at->format('d M Y') }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <div class="d-flex align-items-start">
                                        <i class="isax isax-location fs-4 text-primary me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Alamat</small>
                                            <strong>{{ $bengkel->address }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mb-4">
                                <a href="https://www.google.com/maps?q={{ $bengkel->latitude }},{{ $bengkel->longitude }}" 
                                   target="_blank" 
                                   class="btn btn-outline-primary">
                                    <i class="isax isax-map"></i> Lihat di Google Maps
                                </a>
                                <a href="https://www.google.com/maps/dir/?api=1&destination={{ $bengkel->latitude }},{{ $bengkel->longitude }}" 
                                   target="_blank" 
                                   class="btn btn-outline-primary">
                                    <i class="isax isax-routing"></i> Petunjuk Arah
                                </a>
                                <a href="tel:{{ $bengkel->phone }}" class="btn btn-outline-success">
                                    <i class="isax isax-call-calling"></i> Hubungi
                                </a>
                            </div>

                            <hr>

                            <h5 class="mb-3"><i class="isax isax-setting-2 text-primary"></i> Layanan Tersedia</h5>
                            @if($bengkel->bengkelServices->count() > 0)
                            <div class="row">
                                @foreach($bengkel->bengkelServices as $bengkelService)
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="mb-2">
                                                <i class="isax isax-setting-3 text-primary"></i>
                                                {{ $bengkelService->service->name }}
                                            </h6>
                                            @if($bengkelService->service->description)
                                            <p class="text-muted small mb-0">{{ $bengkelService->service->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="alert alert-info">
                                <i class="isax isax-info-circle"></i> Belum ada layanan yang terdaftar
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="isax isax-message-text text-primary"></i> Ulasan Pelanggan</h5>
                        </div>
                        <div class="card-body">
                            @if($bengkel->reviews->count() > 0)
                                @foreach($bengkel->reviews as $review)
                                <div class="mb-4 pb-4 border-bottom">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1">{{ $review->user->name }}</h6>
                                            <div class="text-warning mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="isax isax-star1 paint-star"></i>
                                                    @else
                                                        <i class="isax isax-star"></i>
                                                    @endif
                                                @endfor
                                                <span class="text-dark ms-1">({{ $review->rating }}/5)</span>
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-0">{{ $review->review }}</p>
                                </div>
                                @endforeach
                            @else
                            <div class="text-center py-4">
                                <i class="isax isax-message-text" style="font-size: 48px; color: #ccc;"></i>
                                <p class="text-muted mt-3 mb-0">Belum ada ulasan untuk bengkel ini</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card mb-4 sticky-top" style="top: 20px;">
                        <div class="card-header bg-primary">
                            <h5 class="mb-0 text-white"><i class="isax isax-flash-circle"></i> Butuh Layanan Darurat?</h5>
                        </div>
                        <div class="card-body">
                            @auth
                                @if(auth()->user()->role->value === 'PUBLIC')
                                <p class="mb-3">Minta layanan darurat dari bengkel ini sekarang!</p>
                                <a href="{{ route('service-requests.create', ['bengkel_id' => $bengkel->id]) }}" 
                                   class="btn btn-primary w-100">
                                    <i class="isax isax-add-circle"></i> Minta Layanan Darurat
                                </a>
                                @else
                                <div class="alert alert-info mb-0">
                                    <i class="isax isax-info-circle"></i> 
                                    Fitur permintaan layanan hanya untuk pengguna umum
                                </div>
                                @endif
                            @else
                            <p class="mb-3">Masuk untuk dapat meminta layanan darurat dari bengkel ini</p>
                            <a href="{{ route('login') }}" class="btn btn-primary w-100 mb-2">
                                <i class="isax isax-login"></i> Masuk
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary w-100">
                                <i class="isax isax-user-add"></i> Daftar
                            </a>
                            @endauth
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="isax isax-location text-primary"></i> Lokasi</h5>
                        </div>
                        <div class="card-body p-0">
                            <iframe 
                                src="https://www.google.com/maps?q={{ $bengkel->latitude }},{{ $bengkel->longitude }}&output=embed" 
                                width="100%" 
                                height="300" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy">
                            </iframe>
                        </div>
                        <div class="card-body">
                            <p class="mb-2"><strong>Koordinat:</strong></p>
                            <p class="text-muted small mb-0">
                                Lat: {{ $bengkel->latitude }}<br>
                                Lng: {{ $bengkel->longitude }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layout.app>

<style>
.paint-star {
    color: #ffc107 !important;
}
</style>
