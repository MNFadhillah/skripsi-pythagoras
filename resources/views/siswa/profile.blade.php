@extends('layouts.siswa')

@section('title', 'PythaLearn - Profil Saya')

@section('content')
<div class="container py-4">
    <div class="row align-items-center">
        <div class="col-lg-12">
            <h3>Profil Saya</h3>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card shadow-sm border-1 rounded mb-2">
                <div class="card-body text-center p-4">
                    {{-- Avatar & Form Upload --}}
                    <div class="mb-3 position-relative d-inline-block">
                        @php
                            $avatarUrl = $user->avatar ? asset('images/avatars/' . $user->avatar) : asset('images/default-avatar.png');
                        @endphp
                        
                        <img src="{{ $avatarUrl }}" id="profileImage" alt="Profile Picture" class="rounded-circle shadow-sm border border-3 border-success" style="width: 120px; height: 120px; object-fit: cover; background-color: white;">
                        
                        {{-- Tombol Edit Kamera Kecil di Pojok Bawah --}}
                        <label for="avatarInput" class="position-absolute bottom-0 end-0 bg-success text-white rounded-circle p-2 shadow" style="cursor: pointer; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; transform: translate(-5px, -5px);">
                            <i class="bi bi-camera-fill"></i>
                        </label>
                        
                        {{-- Input File Tersembunyi --}}
                        <input type="file" id="avatarInput" class="d-none" accept="image/png, image/jpeg, image/jpg">
                    </div>
                    <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    <span class="badge bg-success px-3 py-2 rounded-pill">{{ $user->kelas->nama_kelas }}</span>

                    <hr class="text-muted">

                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-success fw-bold" data-bs-toggle="modal" data-bs-target="#modalEditProfile">
                            <i class="bi bi-pencil-square me-1"></i> Edit Profil
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-7">
            
            <div class="card shadow-sm border-1 rounded mb-2">
                <div class="card-header bg-white border-bottom pb-0 pt-3">
                    <h5 class="fw-bold text-dark"><i class="bi bi-bar-chart-line-fill text-success me-2"></i>Statistik Belajar</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3 text-center">
                        <div class="col-md-4 col-6">
                            <div class="p-3 bg-light rounded-3 border border-success border-opacity-25">
                                <h3 class="fw-bold text-success mb-0">{{ $totalProgress }}%</h3>
                                <span class="small text-muted">Progres Materi Keseluruhan</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="p-3 bg-light rounded-3 border border-success border-opacity-25">
                                <h3 class="fw-bold text-success mb-0">{{ $rataRataKuis }}</h3>
                                <span class="small text-muted">Rata-rata Kuis dan Evaluasi</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="p-3 bg-light rounded-3 border border-success border-opacity-25">
                                <h3 class="fw-bold text-success mb-0">{{ $totalLencanaTerkumpul }}</h3>
                                <span class="small text-muted">Lencana Terkumpul</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm border-1 rounded mb-2">
                <div class="card-header bg-white border-bottom pb-0 pt-3">
                    <h5 class="fw-bold text-dark"><i class="bi bi-award-fill text-warning me-2"></i>Koleksi Lencana</h5>
                </div>
                <div class="card-body p-4">                    
                    <div class="row g-3 text-center">
                        @forelse($semuaLencana as $badge)
                            @php
                                // Cek apakah ID lencana ini ada di dalam array lencana yang sudah didapat siswa
                                $sudahDapat = in_array($badge->id, $lencanaSiswa);
                            @endphp
                            
                            <div class="col-md-3 col-6">
                                <div class="badge-item p-2 {{ !$sudahDapat ? 'opacity-50' : '' }}" @if(!$sudahDapat) style="filter: grayscale(100%);" @endif>
                                    <img src="{{ asset('images/badges/' . $badge->image_path) }}" alt="{{ $badge->name }}" class="img-fluid mb-2" style="width: 70px;">
                                    
                                    @if($sudahDapat)
                                        <h6 class="small fw-bold mb-0 text-success">{{ $badge->name }}</h6>
                                    @else
                                        <h6 class="small fw-bold mb-0 text-muted"><i class="bi bi-lock-fill"></i> Terkunci</h6>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted">
                                <p>Belum ada lencana yang tersedia di sistem.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- === MODAL EDIT PROFIL === --}}
<div class="modal fade" id="modalEditProfile" tabindex="-1" aria-labelledby="modalEditProfileLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            
            <div class="modal-header bg-success text-white py-3 border-0" style="border-radius: 1rem 1rem 0 0;">
                <h5 class="modal-title fw-bold" id="modalEditProfileLabel"><i class="bi bi-pencil-square me-2"></i>Edit Profil</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('siswa.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    
                    {{-- Tampilkan Error Validasi Jika Ada --}}
                    @if($errors->any())
                        <div class="alert alert-danger pb-0">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                    
                    <hr class="text-muted my-4">
                    <p class="small text-muted mb-3"><i class="bi bi-info-circle me-1"></i>Biarkan kosong jika tidak ingin mengubah password.</p>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Password Baru</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                    </div>
                    
                </div>
                <div class="modal-footer bg-light border-0" style="border-radius: 0 0 1rem 1rem;">
                    <button type="submit" class="btn btn-success fw-bold">Simpan Perubahan</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function editProfile() {
        Swal.fire({
            title: 'Edit Profil',
            text: 'Fitur edit profil akan segera hadir!',
            icon: 'info',
            confirmButtonColor: '#198754'
        });
    }

    // Fitur Upload Avatar
    document.getElementById('avatarInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        // Validasi ekstensi
        if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
            Swal.fire('Format Salah!', 'Pilih file gambar berformat JPG, JPEG, atau PNG.', 'warning');
            return;
        }

        // Validasi ukuran (Max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire('Terlalu Besar!', 'Ukuran gambar maksimal 2MB.', 'warning');
            return;
        }

        const formData = new FormData();
        formData.append('avatar', file);

        Swal.fire({
            title: 'Mengunggah...',
            text: 'Sedang memperbarui foto profil',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading() }
        });

        fetch('{{ route("siswa.profile.avatar") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update gambar langsung di halaman tanpa refresh
                document.getElementById('profileImage').src = data.avatar_url;
                
                // Jika mau sekalian update foto di pojok kanan atas (navbar), bisa pakai baris ini:
                // document.querySelector('.navbar-avatar-icon').src = data.avatar_url;
                
                Swal.fire('Berhasil!', data.message, 'success');
            } else {
                Swal.fire('Gagal!', data.message || 'Terjadi kesalahan sistem.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error!', 'Tidak dapat terhubung ke server.', 'error');
        });
    });


</script>
@endpush