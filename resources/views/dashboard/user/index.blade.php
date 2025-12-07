<x-layout.dashboard>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Selamat Datang di Dashboard Anda</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <div class="icon icon-shape bg-gradient-primary shadow mx-auto mb-3" style="width: 60px; height: 60px;">
                                            <i class="fas fa-wrench text-white text-lg opacity-10" style="line-height: 60px;"></i>
                                        </div>
                                        <h5 class="mb-3">Telusuri Bengkel</h5>
                                        <p class="text-sm">Temukan bengkel terverifikasi di dekat Anda untuk layanan darurat kendaraan.</p>
                                        <a href="{{ route('service-requests.index') }}" class="btn btn-primary btn-sm">
                                            Lihat Bengkel
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <div class="icon icon-shape bg-gradient-success shadow mx-auto mb-3" style="width: 60px; height: 60px;">
                                            <i class="fas fa-list-alt text-white text-lg opacity-10" style="line-height: 60px;"></i>
                                        </div>
                                        <h5 class="mb-3">Permintaan Saya</h5>
                                        <p class="text-sm">Lihat dan lacak semua permintaan layanan Anda beserta statusnya.</p>
                                        <a href="{{ route('service-requests.my-requests') }}" class="btn btn-success btn-sm">
                                            Lihat Permintaan Saya
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <div class="icon icon-shape bg-gradient-info shadow mx-auto mb-3" style="width: 60px; height: 60px;">
                                            <i class="fas fa-question-circle text-white text-lg opacity-10" style="line-height: 60px;"></i>
                                        </div>
                                        <h5 class="mb-3">Butuh Bantuan?</h5>
                                        <p class="text-sm">Mengalami masalah dengan kendaraan Anda? Minta bantuan sekarang!</p>
                                        <a href="{{ route('service-requests.index') }}" class="btn btn-info btn-sm">
                                            Minta Layanan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.dashboard>
