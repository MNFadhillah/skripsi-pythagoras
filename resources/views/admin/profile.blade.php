@extends('layouts.admin')

@section('title', 'Profil Admin | PythaLearn')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h4 class="mb-0 fw-bold"><i class="bi bi-person-badge text-success me-2"></i>Profil Saya</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-center py-5">
                    
                    <div class="position-relative d-inline-block mb-4">
                        @if($user->avatar)
                            <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Avatar" class="rounded-circle shadow" style="width: 140px; height: 140px; object-fit: cover; border: 4px solid #fff;">
                        @else
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center shadow mx-auto" style="width: 140px; height: 140px; font-size: 3.5rem; border: 4px solid #fff;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif

                        <button type="button" class="btn btn-sm btn-light rounded-circle shadow position-absolute bottom-0 end-0 mb-2 me-2" data-bs-toggle="modal" data-bs-target="#modalAvatar" style="width: 35px; height: 35px;" title="Ubah Foto Profil">
                            <i class="bi bi-camera-fill text-success"></i>
                        </button>
                    </div>

                    <h4 class="fw-bold mb-1" id="displayName">{{ $user->name }}</h4>
                    <p class="text-muted mb-3" id="displayEmail">{{ $user->email }}</p>
                    
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-4 py-2 rounded-pill mb-4">
                        Administrator
                    </span>

                    <button type="button" class="btn btn-outline-success px-4 rounded-pill fw-semibold" data-bs-toggle="modal" data-bs-target="#modalEditProfil">
                        <i class="bi bi-pencil-square me-1"></i> Edit Profil
                    </button>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7 mb-4">
            
            {{-- Statistik Cards --}}
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-primary text-white h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-white bg-opacity-25 rounded p-3 me-3">
                                <i class="bi bi-people-fill fs-3"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-normal opacity-75 small">Total Siswa</h6>
                                <h3 class="mb-0 fw-bold">{{ $totalSiswa }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-success text-white h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-white bg-opacity-25 rounded p-3 me-3">
                                <i class="bi bi-person-badge fs-3"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-normal opacity-75 small">Total Guru</h6>
                                <h3 class="mb-0 fw-bold">{{ $totalGuru }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-info text-white h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-white bg-opacity-25 rounded p-3 me-3">
                                <i class="bi bi-house-door fs-3"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-normal opacity-75 small">Total Kelas</h6>
                                <h3 class="mb-0 fw-bold">{{ $totalKelas }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-warning text-white h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-white bg-opacity-25 rounded p-3 me-3">
                                <i class="bi bi-journal-check fs-3"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-normal opacity-75 small">Total Aktivitas</h6>
                                <h3 class="mb-0 fw-bold">{{ $totalAktivitas }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Edit Profil -->
<div class="modal fade" id="modalEditProfil" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white border-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-person-lines-fill me-2"></i>Edit Informasi Akun</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formProfil">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-light" name="name" id="name" value="{{ $user->name }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary small">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control bg-light" name="email" id="email" value="{{ $user->email }}" required>
                    </div>

                    <hr class="text-muted opacity-25 mb-4">

                    <div class="alert alert-warning border-0 bg-warning-subtle small d-flex align-items-center mb-3">
                        <i class="bi bi-exclamation-triangle-fill fs-5 me-3 text-warning"></i>
                        <div>Kosongkan kolom password di bawah ini jika tidak ingin mengubahnya.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Password Baru</label>
                        <input type="password" class="form-control bg-light" name="password" id="password" placeholder="Minimal 6 karakter">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary small">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control bg-light" name="password_confirmation" id="password_confirmation" placeholder="Ketik ulang password baru">
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-success fw-bold py-2 rounded-3">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload Avatar -->
<div class="modal fade" id="modalAvatar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-0 pb-0">
                <h6 class="modal-title fw-bold text-success mb-0">Ubah Foto Profil</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pt-3 pb-4">
                <form id="formAvatar" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 text-start">
                        <label class="form-label small text-muted">Pilih gambar (JPG/PNG, Maks. 2MB)</label>
                        <input class="form-control form-control-sm" type="file" id="avatar" name="avatar" accept="image/jpeg, image/png, image/jpg" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm w-100 fw-bold">Upload Foto</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Edit Profil
    $('#formProfil').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        
        Swal.fire({
            title: 'Menyimpan...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: "{{ route('admin.profile.update') }}",
            type: 'POST',
            data: formData,
            success: function(res) {
                if(res.success) {
                    $('#displayName').text($('#name').val());
                    $('#displayEmail').text($('#email').val());
                    $('#password, #password_confirmation').val('');
                    $('#modalEditProfil').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                let errorMsg = 'Terjadi kesalahan saat menyimpan data.';
                if(xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    errorMsg = Object.values(errors)[0][0]; 
                }
                Swal.fire({ icon: 'error', title: 'Gagal!', text: errorMsg });
            }
        });
    });

    // Upload Avatar
    $('#formAvatar').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        Swal.fire({
            title: 'Mengupload...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: "{{ route('admin.profile.avatar') }}",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                if(res.success) {
                    $('#modalAvatar').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload(); 
                    });
                }
            },
            error: function(xhr) {
                let errorMsg = 'Gagal mengupload gambar. Pastikan format JPG/PNG dan maksimal 2MB.';
                Swal.fire({ icon: 'error', title: 'Gagal!', text: errorMsg });
            }
        });
    });
});
</script>
@endpush