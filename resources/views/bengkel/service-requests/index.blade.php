<x-layout.dashboard>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Permintaan Layanan Masuk</h6>
                    <p class="text-sm">Kelola permintaan layanan dari pelanggan</p>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mx-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mx-4" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="px-4 mb-3">
                        <ul class="nav nav-pills" id="statusFilter" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button">
                                    Semua
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pending-tab" data-bs-toggle="pill" data-bs-target="#pending" type="button">
                                    Menunggu
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="accepted-tab" data-bs-toggle="pill" data-bs-target="#accepted" type="button">
                                    Diterima
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="otw-tab" data-bs-toggle="pill" data-bs-target="#otw" type="button">
                                    Dalam Perjalanan
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="completed-tab" data-bs-toggle="pill" data-bs-target="#completed" type="button">
                                    Selesai
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id="requestsTable">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID Permintaan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pelanggan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Masalah</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($serviceRequests as $request)
                                <tr data-status="{{ $request->status->name }}">
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0 px-3">#{{ $request->id }}</p>
                                    </td>
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
                                                'cancelled' => 'bg-gradient-secondary'
                                            ];
                                            $statusLabels = [
                                                'pending' => 'Menunggu',
                                                'accepted' => 'Diterima',
                                                'otw' => 'Dalam Perjalanan',
                                                'completed' => 'Selesai',
                                                'cancelled' => 'Dibatalkan'
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
                                           class="btn btn-sm btn-primary mb-0"
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <p class="text-secondary mb-0">Belum ada permintaan layanan.</p>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('#statusFilter button');
        const rows = document.querySelectorAll('#requestsTable tbody tr[data-status]');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const targetStatus = this.id.replace('-tab', '');
                
                rows.forEach(row => {
                    const rowStatus = row.getAttribute('data-status');
                    
                    if (targetStatus === 'all' || targetStatus === rowStatus) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endpush
</x-layout.dashboard>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-gradient-warning',
                                                'accepted' => 'bg-gradient-info',
                                                'otw' => 'bg-gradient-primary',
                                                'completed' => 'bg-gradient-success',
                                                'cancelled' => 'bg-gradient-secondary'
                                            ];
                                            $statusColor = $statusColors[$request->status->name] ?? 'bg-gradient-secondary';
                                        @endphp
                                        <span class="badge badge-sm {{ $statusColor }}">{{ ucfirst($request->status->name) }}</span>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $request->created_at->format('d M Y') }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $request->created_at->format('H:i') }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('bengkel.service-requests.show', $request) }}" 
                                           class="btn btn-sm btn-primary mb-0"
                                           title="View Details">
                                            <i class="fas fa-eye"></i> Details
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <p class="text-secondary mb-0">No service requests yet.</p>
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

    <!-- Statistics Cards -->
    <div class="row mt-4">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Pending</p>
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
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Active</p>
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
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Completed</p>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('#statusFilter button');
        const rows = document.querySelectorAll('#requestsTable tbody tr[data-status]');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const targetStatus = this.id.replace('-tab', '');
                
                rows.forEach(row => {
                    const rowStatus = row.getAttribute('data-status');
                    
                    if (targetStatus === 'all' || targetStatus === rowStatus) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endpush
</x-layout.dashboard>
