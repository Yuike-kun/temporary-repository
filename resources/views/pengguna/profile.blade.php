<x-layout.dashboard>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Pengaturan Akun Saya</h6>
                        <p class="text-sm">Kelola informasi profil Anda</p>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Terjadi kesalahan!</strong>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('my-account.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input 
                                            type="text" 
                                            class="form-control @error('name') is-invalid @enderror" 
                                            name="name" 
                                            value="{{ old('name', $user->name) }}"
                                            required
                                        >
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input 
                                            type="email" 
                                            class="form-control @error('email') is-invalid @enderror" 
                                            name="email" 
                                            value="{{ old('email', $user->email) }}"
                                            required
                                        >
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Password Baru</label>
                                        <input 
                                            type="password" 
                                            class="form-control @error('password') is-invalid @enderror" 
                                            name="password"
                                            placeholder="Kosongkan jika tidak ingin mengubah password"
                                        >
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Minimal 8 karakter</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Konfirmasi Password</label>
                                        <input 
                                            type="password" 
                                            class="form-control" 
                                            name="password_confirmation"
                                            placeholder="Ulangi password baru"
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Foto Profil</label>
                                        @if($user->avatar)
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $user->avatar) }}" 
                                                     alt="Current Avatar" 
                                                     class="img-thumbnail"
                                                     style="max-width: 150px;">
                                            </div>
                                        @endif
                                        <input 
                                            type="file" 
                                            class="form-control @error('avatar') is-invalid @enderror" 
                                            name="avatar"
                                            accept="image/jpeg,image/png,image/jpg"
                                        >
                                        @error('avatar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Format: JPG, JPEG, PNG (Maksimal 2MB)</small>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Simpan Perubahan
                                </button>
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Informasi Akun</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Tipe Akun:</strong> Pengguna</p>
                                <p><strong>Bergabung Sejak:</strong> {{ $user->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Terakhir Diperbarui:</strong> {{ $user->updated_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.dashboard>
