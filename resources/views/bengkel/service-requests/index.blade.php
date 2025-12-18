<x-layout.dashboard>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6>Permintaan Layanan Masuk</h6>
                                <p class="text-sm mb-0">Kelola permintaan layanan dari pelanggan</p>
                            </div>
                            <div>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exportModal">
                                    Export PDF
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show mx-4" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mx-4" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Advanced Filters -->
                        <form method="GET" action="{{ route('bengkel.service-requests.index') }}" id="filterForm">
                            <div class="px-4 mb-3">
                                <div class="row g-3">
                                    <!-- Search Filter -->
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="text" name="search" id="searchInput" class="form-control" 
                                                   placeholder="Cari pelanggan atau masalah..." 
                                                   value="{{ request('search') }}">
                                        </div>
                                    </div>

                                    <!-- Date From Filter -->
                                    <div class="col-md-3">
                                        <input type="date" name="date_from" id="dateFrom" class="form-control" 
                                               placeholder="Dari Tanggal" 
                                               value="{{ request('date_from') }}">
                                    </div>

                                    <!-- Date To Filter -->
                                    <div class="col-md-3">
                                        <input type="date" name="date_to" id="dateTo" class="form-control" 
                                               placeholder="Sampai Tanggal" 
                                               value="{{ request('date_to') }}">
                                    </div>

                                    <!-- Sort Filter -->
                                    <div class="col-md-2">
                                        <select name="sort_by" id="sortBy" class="form-select" onchange="this.form.submit()">
                                            <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                            <option value="oldest" {{ request('sort_by') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                            <option value="customer" {{ request('sort_by') == 'customer' ? 'selected' : '' }}>Nama Pelanggan</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Filter Actions -->
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            Terapkan Filter
                                        </button>
                                        <a href="{{ route('bengkel.service-requests.index') }}" class="btn btn-secondary btn-sm">
                                            Reset
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden status input -->
                            <input type="hidden" name="status" id="statusInput" value="{{ request('status', 'all') }}">
                        </form>

                        <!-- Status Filter Pills -->
                        <div class="px-4 mb-3">
                            <ul class="nav nav-pills" id="statusFilter" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ request('status', 'all') == 'all' ? 'active' : '' }}" 
                                            type="button" onclick="filterByStatus('all')">
                                        Semua
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}" 
                                            type="button" onclick="filterByStatus('pending')">
                                        Menunggu
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ request('status') == 'accepted' ? 'active' : '' }}" 
                                            type="button" onclick="filterByStatus('accepted')">
                                        Diterima
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ request('status') == 'otw' ? 'active' : '' }}" 
                                            type="button" onclick="filterByStatus('otw')">
                                        Dalam Perjalanan
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}" 
                                            type="button" onclick="filterByStatus('completed')">
                                        Selesai
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ request('status') == 'cancelled' ? 'active' : '' }}" 
                                            type="button" onclick="filterByStatus('cancelled')">
                                        Dibatalkan
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <!-- Results Counter -->
                        <div class="px-4 mb-2">
                            <small class="text-muted">
                                Menampilkan <strong>{{ $serviceRequests->count() }}</strong> 
                                @if(request()->hasAny(['status', 'search', 'date_from', 'date_to']))
                                    dari <strong>{{ $bengkel->serviceRequests->count() }}</strong>
                                @endif
                                permintaan
                            </small>
                        </div>

                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="requestsTable">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase  text-xxs font-weight-bolder opacity-7 ps-2">
                                            Pelanggan</th>
                                        <th
                                            class="text-uppercase  text-xxs font-weight-bolder opacity-7 ps-2">
                                            Masalah</th>
                                        <th
                                            class="text-uppercase  text-xxs font-weight-bolder opacity-7 ps-2">
                                            Status</th>
                                        <th
                                            class="text-uppercase  text-xxs font-weight-bolder opacity-7 ps-2">
                                            Tanggal</th>
                                        <th class=" opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($serviceRequests as $request)
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-0 text-sm">{{ $request->user->name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $request->user->email }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs mb-0">{{ Str::limit($request->description, 60) }}</p>
                                            </td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'bg-gradient-warning',
                                                        'accepted' => 'bg-gradient-info',
                                                        'otw' => 'bg-gradient-primary',
                                                        'completed' => 'bg-gradient-success',
                                                        'cancelled' => 'bg-gradient-secondary',
                                                    ];
                                                    $statusLabels = [
                                                        'pending' => 'Menunggu',
                                                        'accepted' => 'Diterima',
                                                        'otw' => 'Dalam Perjalanan',
                                                        'completed' => 'Selesai',
                                                        'cancelled' => 'Dibatalkan',
                                                    ];
                                                    $statusColor = $statusColors[$request->status->name] ?? 'bg-gradient-secondary';
                                                    $statusLabel = $statusLabels[$request->status->name] ?? ucfirst($request->status->name);
                                                @endphp
                                                <span class="badge badge-sm {{ $statusColor }}">{{ $statusLabel }}</span>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $request->created_at->format('d M Y') }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ $request->created_at->format('H:i') }}</p>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('bengkel.service-requests.show', $request) }}"
                                                    class="btn btn-sm btn-primary mb-0" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <p class="text-secondary mb-0">
                                                    @if(request()->hasAny(['status', 'search', 'date_from', 'date_to']))
                                                        Tidak ada permintaan layanan yang sesuai dengan filter.
                                                    @else
                                                        Belum ada permintaan layanan.
                                                    @endif
                                                </p>
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

        <div class="row mt-4">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Menunggu</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $serviceRequests->where('status.name', 'pending')->count() }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                    <i class="ni ni-time-alarm text-lg opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Aktif</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $serviceRequests->whereIn('status.name', ['accepted', 'otw'])->count() }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-delivery-fast text-lg opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Selesai</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $serviceRequests->where('status.name', 'completed')->count() }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                    <i class="ni ni-check-bold text-lg opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $serviceRequests->count() }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                    <i class="ni ni-bullet-list-67 text-lg opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export PDF Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Export Laporan ke PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('bengkel.service-requests.export-pdf') }}" method="GET">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Filter Status</label>
                            <select name="status" class="form-select">
                                <option value="all">Semua Status</option>
                                <option value="pending">Menunggu</option>
                                <option value="accepted">Diterima</option>
                                <option value="otw">Dalam Perjalanan</option>
                                <option value="completed">Selesai</option>
                                <option value="cancelled">Dibatalkan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dari Tanggal</label>
                            <input type="date" name="date_from" class="form-control">
                            <small class="text-muted">Kosongkan untuk tidak membatasi</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="date" name="date_to" class="form-control">
                            <small class="text-muted">Kosongkan untuk tidak membatasi</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-download me-1"></i>Download PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function filterByStatus(status) {
                document.getElementById('statusInput').value = status;
                document.getElementById('filterForm').submit();
            }

            // Auto-submit on search after user stops typing
            let searchTimeout;
            document.getElementById('searchInput').addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    document.getElementById('filterForm').submit();
                }, 800);
            });

            // Auto-submit on date change
            document.getElementById('dateFrom').addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });

            document.getElementById('dateTo').addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        </script>
    @endpush
</x-layout.dashboard>
