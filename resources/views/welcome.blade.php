<x-layout.app>
    <!-- Hero Section -->
    <section class="hero-section-three">
        <div class="container">
            <div class="hero-content">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="banner-content wow fadeInUp" data-wow-delay="0.3">
                            <h1 class="display-5 text-white">Layanan Darurat Kendaraan 24/7</h1>
                            <p class="text-white fs-5">Temukan bengkel terdekat dan dapatkan bantuan cepat saat kendaraan Anda bermasalah</p>
                        </div>
                        <div class="banner-form card wow fadeInUp mb-0" data-wow-delay="1.5">
                            <div class="card-body">
                                <form action="{{ route('bengkels.grid') }}" method="GET">
                                    <div class="row g-3 align-items-end">
                                        <div class="col-lg-8">
                                            <label class="form-label text-dark fw-medium">
                                                <i class="isax isax-search-normal me-2"></i>Cari Bengkel
                                            </label>
                                            <input type="text" 
                                                   name="search" 
                                                   class="form-control form-control-lg" 
                                                   placeholder="Masukkan nama bengkel atau lokasi...">
                                        </div>
                                        <div class="col-lg-4">
                                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                                <i class="isax isax-search-normal me-2"></i>Cari Bengkel
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="row g-3 mt-4">
                            <div class="col-md-4">
                                <a href="{{ route('bengkels.grid') }}" class="btn btn-outline-light btn-lg w-100">
                                    <i class="isax isax-location me-2"></i>
                                    Lihat Semua Bengkel
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('bengkels.grid', ['verified' => 1]) }}" class="btn btn-outline-light btn-lg w-100">
                                    <i class="isax isax-verify me-2"></i>
                                    Bengkel Terverifikasi
                                </a>
                            </div>
                            <div class="col-md-4">
                                @auth
                                    <a href="{{ route('service-request.create') }}" class="btn btn-warning btn-lg w-100">
                                        <i class="isax isax-danger me-2"></i>
                                        Request Darurat
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-warning btn-lg w-100">
                                        <i class="isax isax-danger me-2"></i>
                                        Request Darurat
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Hero Section -->

    <!-- Stats Section -->
    <section class="section bg-white">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-md-3 col-6">
                    <div class="stats-card">
                        <div class="stats-icon bg-primary-light text-primary mb-3 mx-auto" style="width: 60px; height: 60px; line-height: 60px; border-radius: 50%;">
                            <i class="isax isax-location" style="font-size: 28px;"></i>
                        </div>
                        <h2 class="fw-bold text-primary">{{ App\Models\Bengkel::count() }}+</h2>
                        <p class="text-muted mb-0">Bengkel Terdaftar</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stats-card">
                        <div class="stats-icon bg-success-light text-success mb-3 mx-auto" style="width: 60px; height: 60px; line-height: 60px; border-radius: 50%;">
                            <i class="isax isax-verify" style="font-size: 28px;"></i>
                        </div>
                        <h2 class="fw-bold text-success">{{ App\Models\Bengkel::where('is_verified', true)->count() }}+</h2>
                        <p class="text-muted mb-0">Bengkel Terverifikasi</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stats-card">
                        <div class="stats-icon bg-warning-light text-warning mb-3 mx-auto" style="width: 60px; height: 60px; line-height: 60px; border-radius: 50%;">
                            <i class="isax isax-setting-2" style="font-size: 28px;"></i>
                        </div>
                        <h2 class="fw-bold text-warning">{{ App\Models\Service::count() }}+</h2>
                        <p class="text-muted mb-0">Jenis Layanan</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stats-card">
                        <div class="stats-icon bg-info-light text-info mb-3 mx-auto" style="width: 60px; height: 60px; line-height: 60px; border-radius: 50%;">
                            <i class="isax isax-people" style="font-size: 28px;"></i>
                        </div>
                        <h2 class="fw-bold text-info">{{ App\Models\User::where('role', 'pengguna')->count() }}+</h2>
                        <p class="text-muted mb-0">Pengguna Aktif</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Stats Section -->

    <!-- Features Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fw-bold mb-3">Kenapa Memilih Kami?</h2>
                    <p class="text-muted">Platform terpercaya untuk menemukan bengkel dan layanan darurat kendaraan</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="feature-icon bg-primary-light text-primary mb-3" style="width: 60px; height: 60px; line-height: 60px; border-radius: 50%;">
                                <i class="isax isax-24-support" style="font-size: 28px;"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Layanan 24/7</h5>
                            <p class="text-muted mb-0">Akses bantuan darurat kapan saja, di mana saja. Bengkel siap melayani kebutuhan kendaraan Anda.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="feature-icon bg-success-light text-success mb-3" style="width: 60px; height: 60px; line-height: 60px; border-radius: 50%;">
                                <i class="isax isax-verify" style="font-size: 28px;"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Bengkel Terverifikasi</h5>
                            <p class="text-muted mb-0">Semua bengkel telah melalui proses verifikasi untuk memastikan kualitas layanan terbaik.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="feature-icon bg-warning-light text-warning mb-3" style="width: 60px; height: 60px; line-height: 60px; border-radius: 50%;">
                                <i class="isax isax-location" style="font-size: 28px;"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Lokasi Terdekat</h5>
                            <p class="text-muted mb-0">Temukan bengkel terdekat dari lokasi Anda dengan mudah melalui peta interaktif.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="feature-icon bg-info-light text-info mb-3" style="width: 60px; height: 60px; line-height: 60px; border-radius: 50%;">
                                <i class="isax isax-star-1" style="font-size: 28px;"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Review & Rating</h5>
                            <p class="text-muted mb-0">Baca ulasan dari pengguna lain untuk memilih bengkel dengan kualitas terbaik.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="feature-icon bg-danger-light text-danger mb-3" style="width: 60px; height: 60px; line-height: 60px; border-radius: 50%;">
                                <i class="isax isax-call" style="font-size: 28px;"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Kontak Langsung</h5>
                            <p class="text-muted mb-0">Hubungi bengkel secara langsung melalui telepon atau WhatsApp untuk respons cepat.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="feature-icon bg-secondary-light text-secondary mb-3" style="width: 60px; height: 60px; line-height: 60px; border-radius: 50%;">
                                <i class="isax isax-setting-2" style="font-size: 28px;"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Beragam Layanan</h5>
                            <p class="text-muted mb-0">Dari ganti ban, servis mesin, hingga derek kendaraan - semua tersedia dalam satu platform.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Features Section -->

    <!-- How It Works -->
    <section class="section bg-white">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fw-bold mb-3">Cara Kerja</h2>
                    <p class="text-muted">Dapatkan bantuan untuk kendaraan Anda dalam 3 langkah mudah</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 text-center">
                    <div class="position-relative mb-4">
                        <div class="bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <h2 class="mb-0 fw-bold">1</h2>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Cari Bengkel</h5>
                    <p class="text-muted">Gunakan fitur pencarian atau filter untuk menemukan bengkel terdekat dengan layanan yang Anda butuhkan.</p>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="position-relative mb-4">
                        <div class="bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <h2 class="mb-0 fw-bold">2</h2>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Pilih & Hubungi</h5>
                    <p class="text-muted">Lihat detail bengkel, baca review, dan hubungi langsung melalui telepon atau WhatsApp.</p>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="position-relative mb-4">
                        <div class="bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <h2 class="mb-0 fw-bold">3</h2>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Dapatkan Layanan</h5>
                    <p class="text-muted">Kendaraan Anda akan segera ditangani oleh teknisi profesional dari bengkel pilihan Anda.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- /How It Works -->

    <!-- CTA Section -->
    <section class="section bg-primary">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 text-center text-lg-start mb-4 mb-lg-0">
                    <h2 class="text-white fw-bold mb-3">Kendaraan Anda Bermasalah?</h2>
                    <p class="text-white mb-0 fs-5">Dapatkan bantuan sekarang juga dari bengkel terdekat dan terpercaya</p>
                </div>
                <div class="col-lg-4 text-center text-lg-end">
                    <a href="{{ route('bengkels.grid') }}" class="btn btn-light btn-lg px-4">
                        <i class="isax isax-search-normal me-2"></i>
                        Cari Bengkel Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- /CTA Section -->

</x-layout.app>
