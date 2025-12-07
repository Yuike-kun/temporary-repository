@push('script')
    <script src="{{ asset('assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>
@endpush

<x-layout.app>
    <div class="breadcrumb-bar breadcrumb-bg-06 text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title mb-2">Daftar Bengkel</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="/"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Bengkel</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">

            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('bengkels.grid') }}" class="row g-3">
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Cari bengkel berdasarkan nama atau lokasi...">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" type="submit">
                                <i class="isax isax-search-normal me-1"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">

                <div class="col-xl-3 col-lg-4 theiaStickySidebar">
                    <div class="card filter-sidebar mb-lg-0 mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Filter</h5>
                            <a class="fs-14 link-primary" href="{{ route('bengkels.grid') }}">Reset</a>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('bengkels.grid') }}">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Status Verifikasi</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="verified" value="1" 
                                               id="verified" {{ request('verified') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="verified">
                                            <i class="isax isax-shield-tick text-success"></i> Hanya Terverifikasi
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-medium">Urutkan</label>
                                    <select class="form-select" name="sort">
                                        <option value="">Default</option>
                                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                    </select>
                                </div>

                                <button class="btn btn-primary w-100" type="submit">Terapkan Filter</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9 col-lg-8">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">
                            <strong>{{ $bengkels->total() }}</strong> Bengkel Ditemukan
                        </h6>
                    </div>

                    <div class="row">
                        @forelse($bengkels as $bengkel)
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-img-top position-relative">
                                    <img src="{{ asset('assets/img/cruise/cruise-04.jpg') }}" 
                                         class="img-fluid" 
                                         alt="{{ $bengkel->name }}"
                                         style="height: 200px; object-fit: cover;">
                                    @if($bengkel->is_verified)
                                    <span class="badge bg-success position-absolute top-0 end-0 m-2">
                                        <i class="isax isax-shield-tick"></i> Terverifikasi
                                    </span>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title mb-2">
                                        <a href="{{ route('bengkels.show', $bengkel) }}" class="text-dark text-decoration-none">
                                            {{ $bengkel->name }}
                                        </a>
                                    </h5>
                                    
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            <i class="isax isax-user"></i> {{ $bengkel->owner->name }}
                                        </small>
                                    </div>

                                    @if($bengkel->reviews_count > 0)
                                    <div class="mb-2">
                                        <span class="badge bg-warning text-dark">
                                            <i class="isax isax-star1"></i> {{ number_format($bengkel->reviews_avg_rating, 1) }}
                                        </span>
                                        <small class="text-muted">({{ $bengkel->reviews_count }} ulasan)</small>
                                    </div>
                                    @endif

                                    <p class="card-text mb-2">
                                        <i class="isax isax-location text-primary"></i>
                                        <small>{{ Str::limit($bengkel->address, 50) }}</small>
                                    </p>

                                    <p class="card-text mb-2">
                                        <i class="isax isax-call text-primary"></i>
                                        <small>{{ $bengkel->phone }}</small>
                                    </p>

                                    <p class="card-text mb-3">
                                        <i class="isax isax-clock text-primary"></i>
                                        <small>{{ $bengkel->operating_hours }}</small>
                                    </p>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('bengkels.show', $bengkel) }}" class="btn btn-primary btn-sm flex-fill">
                                            <i class="isax isax-eye"></i> Lihat Detail
                                        </a>
                                        <a href="https://www.google.com/maps?q={{ $bengkel->latitude }},{{ $bengkel->longitude }}" 
                                           target="_blank" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="isax isax-map"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-footer bg-light">
                                    <small class="text-muted">
                                        <i class="isax isax-briefcase"></i> 
                                        {{ $bengkel->bengkel_services_count }} Layanan Tersedia
                                    </small>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body text-center py-5">
                                    <i class="isax isax-search-normal" style="font-size: 64px; color: #ccc;"></i>
                                    <h4 class="mt-4 mb-2">Tidak Ada Bengkel Ditemukan</h4>
                                    <p class="text-muted mb-4">Coba ubah kata kunci pencarian atau filter Anda</p>
                                    <a href="{{ route('bengkels.grid') }}" class="btn btn-primary">
                                        <i class="isax isax-refresh"></i> Reset Pencarian
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    @if($bengkels->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $bengkels->links() }}
                    </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
</x-layout.app>
