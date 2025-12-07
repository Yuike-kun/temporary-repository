<x-layout.dashboard>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 col-12 mx-auto">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Minta Layanan dari {{ $bengkel->name }}</h6>
                        <a href="{{ route('service-requests.show', $bengkel) }}" class="btn btn-sm btn-secondary">Kembali</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('service-requests.store', $bengkel) }}" method="POST" id="serviceRequestForm">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Masalah *</label>
                            <textarea 
                                class="form-control @error('description') is-invalid @enderror" 
                                id="description" 
                                name="description" 
                                rows="5" 
                                required
                                placeholder="Mohon jelaskan masalah kendaraan Anda secara detail...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Jelaskan sejelas mungkin masalah yang Anda alami.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lokasi Anda Saat Ini *</label>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <input 
                                        type="text" 
                                        class="form-control @error('latitude') is-invalid @enderror" 
                                        id="latitude" 
                                        name="latitude" 
                                        placeholder="Latitude"
                                        value="{{ old('latitude') }}"
                                        required
                                        readonly>
                                    @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-2">
                                    <input 
                                        type="text" 
                                        class="form-control @error('longitude') is-invalid @enderror" 
                                        id="longitude" 
                                        name="longitude" 
                                        placeholder="Longitude"
                                        value="{{ old('longitude') }}"
                                        required
                                        readonly>
                                    @error('longitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-info" id="getCurrentLocation">
                                <i class="fas fa-map-marker-alt me-2"></i>Dapatkan Lokasi Saat Ini
                            </button>
                            <small class="form-text text-muted d-block mt-2">Klik tombol untuk mendeteksi lokasi Anda secara otomatis.</small>
                        </div>

                        <div class="alert alert-info">
                            <strong>Catatan:</strong> Bengkel akan diberitahu tentang permintaan layanan Anda dan dapat menerima atau menolaknya. Anda dapat melacak status permintaan Anda.
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('service-requests.show', $bengkel) }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                                <i class="fas fa-paper-plane me-2"></i>Kirim Permintaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const getCurrentLocationBtn = document.getElementById('getCurrentLocation');
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const submitBtn = document.getElementById('submitBtn');

        getCurrentLocationBtn.addEventListener('click', function() {
            if (navigator.geolocation) {
                getCurrentLocationBtn.disabled = true;
                getCurrentLocationBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mendapatkan lokasi...';
                
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        latitudeInput.value = position.coords.latitude;
                        longitudeInput.value = position.coords.longitude;
                        submitBtn.disabled = false;
                        
                        getCurrentLocationBtn.disabled = false;
                        getCurrentLocationBtn.innerHTML = '<i class="fas fa-check me-2"></i>Lokasi Diperoleh';
                        getCurrentLocationBtn.classList.remove('btn-info');
                        getCurrentLocationBtn.classList.add('btn-success');
                    },
                    function(error) {
                        alert('Error mendapatkan lokasi: ' + error.message);
                        getCurrentLocationBtn.disabled = false;
                        getCurrentLocationBtn.innerHTML = '<i class="fas fa-map-marker-alt me-2"></i>Dapatkan Lokasi Saat Ini';
                    }
                );
            } else {
                alert('Geolocation tidak didukung oleh browser Anda');
            }
        });

        if (latitudeInput.value && longitudeInput.value) {
            submitBtn.disabled = false;
        }
    });
</script>
@endpush
</x-layout.dashboard>
