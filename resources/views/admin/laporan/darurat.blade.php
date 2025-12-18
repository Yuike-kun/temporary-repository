<x-layout.dashboard-admin>
    <div class="container-fluid py-4 admin-report-black">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 fw-bold">Laporan Darurat</h4>
                        <p class="text-sm mb-0 text-muted">Monitor permintaan layanan darurat</p>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-dark btn-sm me-2" data-bs-toggle="modal"
                            data-bs-target="#exportExcelModal">
                            Excel
                        </button>
                        <button type="button" class="btn btn-outline-dark btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exportPdfModal">
                            PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-2 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3 text-center">
                        <p class="text-xs mb-1 text-muted">Total</p>
                        <h3 class="mb-0 fw-bold">{{ $stats['total'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3 text-center">
                        <p class="text-xs mb-1 text-muted">Menunggu</p>
                        <h3 class="mb-0 fw-bold">{{ $stats['pending'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3 text-center">
                        <p class="text-xs mb-1 text-muted">Diterima</p>
                        <h3 class="mb-0 fw-bold">{{ $stats['accepted'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3 text-center">
                        <p class="text-xs mb-1 text-muted">Perjalanan</p>
                        <h3 class="mb-0 fw-bold">{{ $stats['otw'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3 text-center">
                        <p class="text-xs mb-1 text-muted">Selesai</p>
                        <h3 class="mb-0 fw-bold">{{ $stats['completed'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3 text-center">
                        <p class="text-xs mb-1 text-muted">Dibatalkan</p>
                        <h3 class="mb-0 fw-bold">{{ $stats['cancelled'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <form method="GET" action="{{ route('admin.laporan.darurat') }}">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-3">
                                    <input type="text" name="search" class="form-control form-control-sm"
                                        placeholder="Cari nama, email, bengkel..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua
                                            Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                            Menunggu</option>
                                        <option value="accepted"
                                            {{ request('status') == 'accepted' ? 'selected' : '' }}>Diterima</option>
                                        <option value="otw" {{ request('status') == 'otw' ? 'selected' : '' }}>Dalam
                                            Perjalanan</option>
                                        <option value="completed"
                                            {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                                        <option value="cancelled"
                                            {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="bengkel_id" class="form-select form-select-sm">
                                        <option value="">Semua Bengkel</option>
                                        @foreach ($bengkels as $bengkel)
                                            <option value="{{ $bengkel->id }}"
                                                {{ request('bengkel_id') == $bengkel->id ? 'selected' : '' }}>
                                                {{ $bengkel->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="date" name="date_from" class="form-control form-control-sm"
                                        placeholder="Dari" value="{{ request('date_from') }}">
                                </div>
                                <div class="col-md-2">
                                    <input type="date" name="date_to" class="form-control form-control-sm"
                                        placeholder="Sampai" value="{{ request('date_to') }}">
                                </div>
                                <div class="col-md-2">
                                    <input type="number" name="year" class="form-control form-control-sm"
                                        placeholder="{{ now()->format('Y') }}" value="{{ request('year') }}"
                                        min="2000" max="{{ now()->format('Y') }}">
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-dark btn-sm w-100">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-xs fw-bold ps-3 border-0">ID</th>
                                        <th class="text-xs fw-bold border-0">Pelanggan</th>
                                        <th class="text-xs fw-bold border-0">Bengkel</th>
                                        <th class="text-xs fw-bold border-0">Deskripsi</th>
                                        <th class="text-xs fw-bold border-0">Lokasi</th>
                                        <th class="text-xs fw-bold text-center border-0">Status</th>
                                        <th class="text-xs fw-bold border-0">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($serviceRequests as $request)
                                        <tr>
                                            <td class="ps-3">
                                                <span class="text-xs fw-bold">#{{ $request->id }}</span>
                                            </td>
                                            <td>
                                                <div>
                                                    <p class="text-sm mb-0 fw-bold">{{ $request->user->name }}</p>
                                                    <p class="text-xs text-muted mb-0">{{ $request->user->email }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <p class="text-sm mb-0 fw-bold">{{ $request->bengkel->name }}</p>
                                                    <p class="text-xs text-muted mb-0">{{ $request->bengkel->phone }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs mb-0" style="max-width: 250px;">
                                                    {{ Str::limit($request->description, 60) }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs mb-0">
                                                    {{ number_format($request->latitude, 4) }},
                                                    {{ number_format($request->longitude, 4) }}
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $statusConfig = [
                                                        'pending' => ['color' => 'warning', 'label' => 'Menunggu'],
                                                        'accepted' => ['color' => 'info', 'label' => 'Diterima'],
                                                        'otw' => ['color' => 'primary', 'label' => 'Perjalanan'],
                                                        'completed' => ['color' => 'success', 'label' => 'Selesai'],
                                                        'cancelled' => [
                                                            'color' => 'secondary',
                                                            'label' => 'Dibatalkan',
                                                        ],
                                                    ];
                                                    $config = $statusConfig[$request->status->name] ?? [
                                                        'color' => 'secondary',
                                                        'label' => ucfirst($request->status->name),
                                                    ];
                                                @endphp
                                                <span
                                                    class="badge bg-{{ $config['color'] }} text-white">{{ $config['label'] }}</span>
                                            </td>
                                            <td>
                                                <div>
                                                    <p class="text-xs mb-0 fw-bold">
                                                        {{ $request->created_at->format('d M Y') }}</p>
                                                    <p class="text-xs text-muted mb-0">
                                                        {{ $request->created_at->format('H:i') }}</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5">
                                                <p class="text-muted mb-0">Tidak ada data</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if ($serviceRequests->hasPages())
                            <div class="px-3 py-2 bg-light border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        {{ $serviceRequests->firstItem() ?? 0 }} -
                                        {{ $serviceRequests->lastItem() ?? 0 }} dari {{ $serviceRequests->total() }}
                                    </small>
                                    {{ $serviceRequests->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export PDF Modal -->
    <div class="modal fade" id="exportPdfModal" tabindex="-1" aria-labelledby="exportPdfModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-bold" id="exportPdfModalLabel">Export PDF</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.laporan.darurat.export-pdf') }}" method="GET">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold">Status</label>
                            <select name="status" class="form-select form-select-sm">
                                <option value="all">Semua Status</option>
                                <option value="pending">Menunggu</option>
                                <option value="accepted">Diterima</option>
                                <option value="otw">Dalam Perjalanan</option>
                                <option value="completed">Selesai</option>
                                <option value="cancelled">Dibatalkan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold">Bengkel</label>
                            <select name="bengkel_id" class="form-select form-select-sm">
                                <option value="">Semua Bengkel</option>
                                @foreach ($bengkels as $bengkel)
                                    <option value="{{ $bengkel->id }}">{{ $bengkel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label text-xs fw-bold">Dari</label>
                                <input type="date" name="date_from" class="form-control form-control-sm">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label text-xs fw-bold">Sampai</label>
                                <input type="date" name="date_to" class="form-control form-control-sm">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label text-xs fw-bold">Tahun</label>
                                <input type="number" name="year" class="form-control form-control-sm"
                                    placeholder="{{ now()->format('Y') }}" value="{{ request('year') }}"
                                    min="2000" max="{{ now()->format('Y') }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-dark">Download</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Export Excel Modal -->
    <div class="modal fade" id="exportExcelModal" tabindex="-1" aria-labelledby="exportExcelModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-bold" id="exportExcelModalLabel">Export Excel</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.laporan.darurat.export-excel') }}" method="GET">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold">Status</label>
                            <select name="status" class="form-select form-select-sm">
                                <option value="all">Semua Status</option>
                                <option value="pending">Menunggu</option>
                                <option value="accepted">Diterima</option>
                                <option value="otw">Dalam Perjalanan</option>
                                <option value="completed">Selesai</option>
                                <option value="cancelled">Dibatalkan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold">Bengkel</label>
                            <select name="bengkel_id" class="form-select form-select-sm">
                                <option value="">Semua Bengkel</option>
                                @foreach ($bengkels as $bengkel)
                                    <option value="{{ $bengkel->id }}">{{ $bengkel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label text-xs fw-bold">Dari</label>
                                <input type="date" name="date_from" class="form-control form-control-sm">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label text-xs fw-bold">Sampai</label>
                                <input type="date" name="date_to" class="form-control form-control-sm">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label text-xs fw-bold">Tahun</label>
                                <input type="number" name="year" class="form-control form-control-sm"
                                    placeholder="{{ now()->format('Y') }}" value="{{ request('year') }}"
                                    min="2000" max="{{ now()->format('Y') }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-dark">Download</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .admin-report-black,
            .admin-report-black * {
                color: #000 !important;
            }

            .card {
                border-radius: 8px;
            }

            .table tbody tr {
                border-bottom: 1px solid #f1f1f1;
            }

            .table tbody tr:hover {
                background-color: #f8f9fa;
            }

            .badge {
                padding: 4px 10px;
                font-weight: 500;
                font-size: 11px;
            }

            .form-control,
            .form-select {
                border: 1px solid #dee2e6;
                border-radius: 6px;
            }

            .btn {
                border-radius: 6px;
                font-weight: 500;
            }
        </style>
    @endpush
</x-layout.dashboard-admin>
