<x-layout.dashboard-admin>

    <!-- Sambutan Admin -->
    <div class="mb-4">
        <div class="card border-0 shadow-sm bg-gradient p-4 position-relative overflow-hidden"
            style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">

            <!-- Icon dekoratif -->
            <div class="position-absolute top-0 end-0 opacity-25 pe-3 pt-3">
                <i data-lucide="sparkles" class="size-10 text-primary"></i>
            </div>

            <!-- Isi Sambutan -->
            <div class="d-flex align-items-center gap-3">
                <div
                    class="avatar bg-primary text-white rounded-circle size-12 d-flex align-items-center justify-content-center shadow-sm">
                    <i data-lucide="user-cog" class="size-6"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1 text-primary">Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}!</h4>
                    <p class="text-muted mb-0">
                        Hari ini, {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }} — pantau aktivitas terkini
                        sistem Anda.
                    </p>

                    <p class="text-muted mb-0">
                        Semoga hari Anda produktif. Berikut adalah ringkasan aktivitas dan laporan terkini yang siap
                        Anda pantau.
                    </p>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <!-- Jumlah Laporan Darurat -->
        <div class="col-md-6 col-lg-3 col-xxl-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="avatar bg-danger-subtle text-danger rounded size-12 mx-auto mb-3">
                        <i data-lucide="alert-triangle" class="size-6"></i>
                    </div>
                    <h2 class="fw-bold mb-1 text-danger">{{ $emergencyRequests }}</h2>
                    <p class="text-muted mb-0">Laporan Darurat</p>
                </div>
            </div>
        </div><!-- end col -->

        <!-- Kendaraan Sedang Ditangani -->
        <div class="col-md-6 col-lg-3 col-xxl-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="avatar bg-warning-subtle text-warning rounded size-12 mx-auto mb-3">
                        <i data-lucide="truck" class="size-6"></i>
                    </div>
                    <h2 class="fw-bold mb-1 text-warning">{{ $handledVehicles }}</h2>
                    <p class="text-muted mb-0">Kendaraan Ditangani</p>
                </div>
            </div>
        </div><!-- end col -->

        <!-- Jumlah Pengguna -->
        <div class="col-md-6 col-lg-3 col-xxl-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="avatar bg-success-subtle text-success rounded size-12 mx-auto mb-3">
                        <i data-lucide="users" class="size-6"></i>
                    </div>
                    <h2 class="fw-bold mb-1 text-success">{{$userCount}}</h2>
                    <p class="text-muted mb-0">Pengguna Terdaftar</p>
                </div>
            </div>
        </div><!-- end col -->

        <!-- Jumlah Admin Bengkel -->
        <div class="col-md-6 col-lg-3 col-xxl-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="avatar bg-primary-subtle text-primary rounded size-12 mx-auto mb-3">
                        <i data-lucide="wrench" class="size-6"></i>
                    </div>
                    <h2 class="fw-bold mb-1 text-primary">{{$bengkelCount}}</h2>
                    <p class="text-muted mb-0">Admin Bengkel</p>
                </div>
            </div>
        </div><!-- end col -->

        <!-- Laporan Aktivitas Harian -->
        <div class="col-lg-6 col-xxl-4 order-3 text-center mx-auto">
            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <h6 class="card-title flex-grow-1 mb-0">Laporan Aktivitas Harian</h6>
                    <div class="dropdown flex-shrink-0">
                        <a href="#!" class="link link-custom-primary" id="dailyReportDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i data-lucide="ellipsis" class="size-5"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dailyReportDropdown">
                            <li><a class="dropdown-item" href="#!">Mingguan</a></li>
                            <li><a class="dropdown-item" href="#!">Bulanan</a></li>
                            <li><a class="dropdown-item" href="#!">Tahunan</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div id="dailyWorkingReportsChart" dir="ltr"></div>
                    <div class="row g-1">
                        <div class="col-md-4">
                            <a href="#!" class="d-flex align-items-center gap-2">
                                <i class="fs-xs ri-circle-fill text-success flex-shrink-0"></i>
                                <div class="flex-grow-1">
                                    <h6 class="fw-normal mb-0">Siang <span class="text-muted">(45%)</span></h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#!" class="d-flex align-items-center gap-2">
                                <i class="fs-xs ri-circle-fill text-primary flex-shrink-0"></i>
                                <div class="flex-grow-1">
                                    <h6 class="fw-normal mb-0">Malam <span class="text-muted">(30%)</span></h6>
                            </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#!" class="d-flex align-items-center gap-2">
                                <i class="fs-xs ri-circle-fill text-warning flex-shrink-0"></i>
                                <div class="flex-grow-1">
                                    <h6 class="fw-normal mb-0">Pagi <span class="text-muted">(25%)</span></h6>
        </div>
                            </a>
                </div>
                    </div>
                </div>
        </div>
        </div><!-- end col -->
    </div>

</x-layout.dashboard-admin>
