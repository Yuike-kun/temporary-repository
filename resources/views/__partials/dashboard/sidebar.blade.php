<div class="col-xl-3 col-lg-4 theiaStickySidebar">
    <div class="card user-sidebar mb-4">
        <div class="card-header user-sidebar-header">
            <div class="profile-content rounded-pill">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center justify-content-center">
                        <x-img class="img-fluid avatar avatar-lg rounded-circle me-1" src="assets/img/users/user-01.jpg"
                            alt="image"
                        />
                        <div>
                            <h6 class="fs-16">{{ auth()->user()->name }}</h6>
                            <span class="fs-14 text-gray-6">{{ auth()->user()->role }}</span>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="rounded-circle btn btn-light d-flex align-items-center justify-content-center p-1"
                                href="profile-settings.html"
                            ><i class="isax isax-edit-2 fs-14"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body user-sidebar-body">
            <ul>
                <li>
                    <a class="d-flex align-items-center" href="{{ route('dashboard') }}">
                        <i class="isax isax-element-2 me-2"></i>Dashboard
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center" href="{{ route('service-requests.index') }}">
                        <i class="isax isax-danger me-2"></i>Request Darurat
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center" href="{{ route('service-requests.my-requests') }}">
                        <i class="isax isax-clock me-2"></i>Riwayat Permintaan
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center" href="{{ route('bengkels.grid') }}">
                        <i class="isax isax-building me-2"></i>Daftar Bengkel
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center" href="{{ route('my-account.profile') }}">
                        <i class="isax isax-user me-2"></i>Akun Saya
                    </a>
                </li>

                <li class="logout-link">
                    <a href="{{ route('logout') }}" class="d-flex align-items-center pb-0">
                        <i class="isax isax-logout-1 me-2"></i>Logout
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
