<x-layout.dashboard-admin>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Kelola Layanan: {{ $bengkel->name }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-4">
                            <i class="isax isax-info-circle"></i>
                            <strong>Informasi Bengkel:</strong><br>
                            Pemilik: {{ $bengkel->owner->name }}<br>
                            Alamat: {{ $bengkel->address }}<br>
                            Telepon: {{ $bengkel->phone }}
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Validation Error!</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.bengkel-services.update', $bengkel) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label class="form-label fw-bold">Pilih Layanan yang Tersedia</label>
                                <p class="text-muted small">Centang layanan yang disediakan oleh bengkel ini</p>

                                @if($allServices->count() > 0)
                                    <div class="row">
                                        @foreach($allServices as $service)
                                            <div class="col-md-6 mb-3">
                                                <div class="card h-100 {{ in_array($service->id, $assignedServiceIds) ? 'border-primary' : '' }}">
                                                    <div class="card-body">
                                                        <div class="form-check">
                                                            <input class="form-check-input" 
                                                                   type="checkbox" 
                                                                   name="services[]" 
                                                                   value="{{ $service->id }}" 
                                                                   id="service-{{ $service->id }}"
                                                                   {{ in_array($service->id, $assignedServiceIds) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="service-{{ $service->id }}">
                                                                <strong>{{ $service->name }}</strong>
                                                                @if($service->description)
                                                                    <br>
                                                                    <small class="text-muted">{{ $service->description }}</small>
                                                                @endif
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="isax isax-warning-2"></i>
                                        Belum ada layanan yang tersedia. Silakan tambahkan layanan terlebih dahulu di menu <a href="{{ route('service.index') }}">Master Layanan</a>.
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary" {{ $allServices->count() == 0 ? 'disabled' : '' }}>
                                    <i class="isax isax-tick-circle"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.bengkel-services.index') }}" class="btn btn-secondary">
                                    <i class="isax isax-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                @if($bengkel->bengkelServices->count() > 0)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Layanan Saat Ini</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Layanan</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bengkel->bengkelServices as $bengkelService)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><strong>{{ $bengkelService->service->name }}</strong></td>
                                            <td>{{ $bengkelService->service->description ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-layout.dashboard-admin>

<style>
.form-check-input:checked ~ .form-check-label {
    color: #0d6efd;
}
.card.border-primary {
    border-width: 2px;
}
</style>
