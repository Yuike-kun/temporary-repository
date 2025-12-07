<x-layout.dashboard-admin>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Kelola Layanan Bengkel</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Bengkel</th>
                                        <th>Pemilik</th>
                                        <th>Lokasi</th>
                                        <th>Layanan Tersedia</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bengkels as $bengkel)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <strong>{{ $bengkel->name }}</strong>
                                                @if($bengkel->is_verified)
                                                    <span class="badge bg-success ms-1">
                                                        <i class="isax isax-shield-tick"></i> Verified
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ $bengkel->owner->name }}</td>
                                            <td>{{ Str::limit($bengkel->address, 30) }}</td>
                                            <td>
                                                @if($bengkel->bengkelServices->count() > 0)
                                                    <span class="badge bg-primary">
                                                        {{ $bengkel->bengkelServices->count() }} Layanan
                                                    </span>
                                                    <div class="small text-muted mt-1">
                                                        {{ $bengkel->bengkelServices->pluck('service.name')->take(3)->implode(', ') }}
                                                        @if($bengkel->bengkelServices->count() > 3)
                                                            ...
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="badge bg-secondary">Belum ada layanan</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.bengkel-services.manage', $bengkel) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="isax isax-setting-2"></i> Kelola Layanan
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <i class="isax isax-box" style="font-size: 48px; color: #ccc;"></i>
                                                <p class="text-muted mt-2">Belum ada bengkel terdaftar</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.dashboard-admin>
