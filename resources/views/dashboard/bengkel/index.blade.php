<x-layout.dashboard>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Dashboard Bengkel</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <div class="icon icon-shape bg-gradient-warning shadow mx-auto mb-3" style="width: 60px; height: 60px;">
                                            <i class="fas fa-bell text-white text-lg opacity-10" style="line-height: 60px;"></i>
                                        </div>
                                        <h5 class="mb-3">Permintaan Layanan</h5>
                                        <p class="text-sm">Lihat dan kelola permintaan layanan masuk dari pelanggan.</p>
                                        <a href="{{ route('bengkel.service-requests.index') }}" class="btn btn-warning btn-sm">
                                            Lihat Permintaan
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <div class="icon icon-shape bg-gradient-info shadow mx-auto mb-3" style="width: 60px; height: 60px;">
                                            <i class="fas fa-tools text-white text-lg opacity-10" style="line-height: 60px;"></i>
                                        </div>
                                        <h5 class="mb-3">Layanan Anda</h5>
                                        <p class="text-sm">Kelola layanan bengkel dan informasi harga Anda.</p>
                                        <a href="#" class="btn btn-info btn-sm">
                                            Kelola Layanan
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
