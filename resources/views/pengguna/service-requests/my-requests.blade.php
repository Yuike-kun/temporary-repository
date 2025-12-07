<x-layout.dashboard>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Permintaan Layanan Saya</h6>
                        <a href="{{ route('service-requests.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-2"></i>Permintaan Baru
                        </a>
                    </div>
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

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID Permintaan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Bengkel</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Deskripsi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($serviceRequests as $request)
                                <tr>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0 px-3">#{{ $request->id }}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0 text-sm">{{ $request->bengkel->name }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $request->bengkel->phone }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs mb-0">{{ Str::limit($request->description, 50) }}</p>
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
                                        <a href="https://www.google.com/maps?q={{ $request->latitude }},{{ $request->longitude }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-info mb-0"
                                           title="Lihat Lokasi">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </a>
                                        @if(in_array($request->status->name, ['pending', 'accepted']))
                                        <form action="{{ route('service-requests.cancel', $request) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan permintaan ini?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-danger mb-0" title="Batalkan Permintaan">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <p class="text-secondary mb-0">Anda belum membuat permintaan layanan.</p>
                                        <a href="{{ route('service-requests.index') }}" class="btn btn-sm btn-primary mt-2">
                                            Minta Layanan Sekarang
                                        </a>
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
</x-layout.dashboard>
