<x-layout.dashboard>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Bengkel Tersedia</h6>
                    <p class="text-sm">Pilih bengkel untuk meminta layanan darurat kendaraan</p>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bengkel</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lokasi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Telepon</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jam Buka</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bengkels as $bengkel)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $bengkel->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">Pemilik: {{ $bengkel->user->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ Str::limit($bengkel->address, 50) }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $bengkel->phone }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ \Carbon\Carbon::parse($bengkel->open_time)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($bengkel->close_time)->format('H:i') }}
                                        </p>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('service-requests.show', $bengkel) }}" class="btn btn-sm btn-info mb-0">
                                            Lihat Detail
                                        </a>
                                        <a href="{{ route('service-requests.create', $bengkel) }}" class="btn btn-sm btn-primary mb-0">
                                            Minta Layanan
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <p class="text-secondary mb-0">Tidak ada bengkel terverifikasi saat ini.</p>
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
