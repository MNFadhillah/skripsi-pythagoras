@extends('layouts.siswa')

@section('title', 'PythaLearn - Profil Saya')

@section('content')
<div class="container py-2">
    <div class="row align-items-center mb-2">
        <div class="col">
            <h3>Profil Saya</h3>
        </div>
    </div>

    <div class="row g-3">
        {{-- Kolom Kiri: Profil + Statistik --}}
        <div class="col-lg-5">
            {{-- Kartu Profil --}}
            <div class="card shadow-sm border-1 rounded mb-2">
                <div class="card-body text-center p-3">
                    <div class="mb-2 d-flex justify-content-center">
                        @php
                        $avatarUrl = $user->avatar ? asset('images/avatars/' . $user->avatar) : asset('images/default-avatar.png');
                        @endphp
                        <div class="position-relative">
                            <img src="{{ $avatarUrl }}" id="profileImage" alt="Profile Picture"
                                class="rounded-circle shadow border border-3 border-success"
                                style="width: 100px; height: 100px; object-fit: cover; background-color: white;">
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted small mb-1">{{ $user->email }}</p>
                    <span class="badge bg-success px-2 py-1 rounded-pill mb-2">
                        {{ $user->kelas->nama_kelas ?? 'Belum Ada Kelas' }}
                    </span>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalGaleriAvatar">
                            <i class="bi bi-person-bounding-box me-1"></i>Galeri Avatar
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalEditProfile">
                            <i class="bi bi-gear-fill me-1"></i>Pengaturan Profil
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Koleksi Lencana --}}
        <div class="col-lg-7">
            
            {{-- Kartu Statistik (dipindah ke bawah profil) --}}
            <div class="card shadow-sm border-1 rounded  mb-3">
                <div class="card-header bg-white border-bottom py-2">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="bi bi-bar-chart-line-fill text-success me-2"></i>Statistik Belajar
                    </h6>
                </div>
                <div class="card-body p-2">
                    <div class="row g-2 text-center">
                        <div class="col-6 col-md-3">
                            <div class="p-2 bg-light rounded-2 border border-success border-opacity-25">
                                <h5 class="fw-bold text-success mb-0">{{ $user->points }}</h5>
                                <small class="text-muted">Perolehan Poin</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-2 bg-light rounded-2 border border-success border-opacity-25">
                                <h5 class="fw-bold text-success mb-0">{{ $totalProgress }}%</h5>
                                <small class="text-muted">Total Progres</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-2 bg-light rounded-2 border border-success border-opacity-25">
                                <h5 class="fw-bold text-success mb-0">{{ $rataRataKuis }}</h5>
                                <small class="text-muted">Rata-rata Kuis dan Evaluasi</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-2 bg-light rounded-2 border border-success border-opacity-25">
                                <h5 class="fw-bold text-success mb-0">{{ $totalLencanaTerkumpul }}</h5>
                                <small class="text-muted">Lencana didapat</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm border-1 rounded">
                <div class="card-header bg-white border-bottom py-2">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="bi bi-award-fill text-warning me-2"></i>Koleksi Lencana
                    </h6>
                </div>
                <div class="card-body p-3 overflow-auto">
                    <div class="row g-2 text-center">
                        @forelse($semuaLencana as $badge)
                        @php
                        $sudahDapat = in_array($badge->id, $lencanaSiswa);
                        @endphp
                        <div class="col-4 col-md-3">
                            <div class="badge-item p-2 {{ !$sudahDapat ? 'opacity-50' : '' }}"
                                @if(!$sudahDapat) style="filter: grayscale(100%);" @endif>
                                <img src="{{ asset('images/badges/' . $badge->image_path) }}" alt="{{ $badge->name }}"
                                    class="img-fluid mb-1" style="width: 55px;">
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

{{-- === MODAL POP-UP GALERI AVATAR === --}}
<div class="modal fade" id="modalGaleriAvatar" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-success text-white py-3 border-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-person-bounding-box me-2"></i>Koleksi Karakter Avatar</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <p class="text-center text-muted small mb-4">Karakter avatar akan terbuka otomatis secara berurutan berdasarkan akumulasi pencapaian total poin belajarmu!</p>

                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-5 g-3 justify-content-center mb-4">
                    @foreach($daftarAvatar as $ava)
                    @php
                    $isOwned = $user->avatar === $ava['file'];
                    $isUnlocked = $user->points >= $ava['harga'];
                    @endphp
                    <div class="col text-center">
                        <div class="avatar-box p-3 border rounded-3 bg-white shadow-sm position-relative d-flex flex-column align-items-center h-100 {{ $isOwned ? 'border-success bg-success bg-opacity-10' : ($isUnlocked ? '' : 'bg-light opacity-75') }}" style="transition: transform 0.2s;">

                            {{-- Efek Grayscale gambar jika point belum mencapai target milestone --}}
                            <img src="{{ asset('images/avatars/' . $ava['file']) }}" alt="{{ $ava['nama'] }}" class="img-fluid rounded-circle mb-2 border"
                                @if(!$isUnlocked)
                                style="width: 75px; height: 75px; object-fit: cover; background: white; filter: grayscale(100%);"
                                @else
                                style="width: 75px; height: 75px; object-fit: cover; background: white;"
                                @endif>

                            {{-- KONDISI 1: JIKA SEDANG DIGUNAKAN --}}
                            @if($isOwned)
                            <span class="badge bg-success small mt-auto w-100 py-2"><i class="bi bi-check2-circle"></i> Digunakan</span>

                            {{-- KONDISI 2: SUDAH TERBUKA (MILESTONE TERCAPAI) TAPI SEDANG TIDAK DIPAKAI --}}
                            @elseif($isUnlocked)
                            <button type="button" class="btn btn-sm btn-success w-100 mt-auto btn-select-avatar" data-file="{{ $ava['file'] }}" data-harga="{{ $ava['harga'] }}" data-nama="{{ $ava['nama'] }}">
                                <i class="bi bi-check-circle"></i> Gunakan
                            </button>

                            {{-- KONDISI 3: MASIH TERKUNCI (POIN BELUM CUKUP) --}}
                            @else
                            <button type="button" class="btn btn-sm btn-secondary w-100 mt-auto text-wrap opacity-75" disabled style="font-size: 0.75rem;">
                                <i class="bi bi-lock-fill small"></i> Syarat: {{ $ava['harga'] }} P
                            </button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                <hr class="text-muted opacity-25">

                {{-- Fitur Unggah File Foto Sendiri --}}
                <div class="text-center bg-white p-3 border rounded-3 shadow-sm mt-4">
                    <label for="avatarInput" class="btn btn-sm btn-outline-secondary rounded-pill px-4 fw-bold mb-0" style="cursor: pointer;">
                        <i class="bi bi-upload me-1"></i> Unggah Foto Pribadi
                    </label>
                    <input type="file" id="avatarInput" style="opacity: 0; position: absolute; z-index: -1;" accept="image/png, image/jpeg, image/jpg">
                </div>
            </div>
        </div>
    </div>
</div>

{{-- === MODAL EDIT PROFIL === --}}
<div class="modal fade" id="modalEditProfile" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-success text-white py-3 border-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Profil</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('siswa.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
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
                <div class="modal-footer bg-light border-0">
                    <button type="submit" class="btn btn-success fw-bold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        // 1. Fitur Memilih Avatar Karakter Bawaan Sistem via AJAX
        $(document).on('click', '.btn-select-avatar', function() {
            let fileAvatar = $(this).data('file');
            let hargaAvatar = $(this).data('harga');
            let namaAvatar = $(this).data('nama');

            let konfirmasiText = `Apakah kamu ingin menggunakan avatar ini pada profilmu?`;

            Swal.fire({
                title: 'Ganti Avatar',
                text: konfirmasiText,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Pasang!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memperbarui Avatar...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    $.ajax({
                        url: "{{ route('siswa.profile.select_avatar') }}",
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            avatar_file: fileAvatar
                        },
                        success: function(res) {
                            if (res.success) {
                                $('#profileImage').attr('src', res.avatar_url);
                                $('#modalGaleriAvatar').modal('hide');

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: res.message
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        },
                        error: function(xhr) {
                            // Mencetak log error asli dari Laravel di tab Console browser (F12)
                            console.error("Detail Error Sistem:", xhr.responseText);
                            let msg = xhr.responseJSON?.message || 'Gagal mengubah avatar. Buka console browser untuk detailnya.';
                            Swal.fire('Gagal!', msg, 'error');
                        }
                    });
                }
            });
        });

        // 2. Fitur Unggah Foto Mandiri via Fetch API
        const avatarInput = document.getElementById('avatarInput');
        if (avatarInput) {
            avatarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
                    Swal.fire('Format Salah!', 'Pilih file gambar berformat JPG, JPEG, atau PNG.', 'warning');
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire('Terlalu Besar!', 'Ukuran gambar maksimal 2MB.', 'warning');
                    return;
                }

                const formData = new FormData();
                formData.append('avatar', file);

                Swal.fire({
                    title: 'Mengunggah...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                fetch('{{ route("siswa.profile.avatar") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => {
                                throw new Error(text)
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            document.getElementById('profileImage').src = data.avatar_url;
                            $('#modalGaleriAvatar').modal('hide');
                            Swal.fire('Berhasil!', data.message, 'success').then(() => location.reload());
                        } else {
                            Swal.fire('Gagal!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error("Detail Error Upload:", error.message);
                        Swal.fire('Error!', 'Terjadi kesalahan sistem saat mengunggah berkas.', 'error');
                    });
            });
        }
    });
</script>
@endpush