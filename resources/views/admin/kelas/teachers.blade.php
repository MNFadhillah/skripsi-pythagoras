@extends('layouts.admin')

@section('title', 'Kelola Guru - ' . $kelas->nama_kelas . ' • PythaLearn')

@section('content')
<div class="container-fluid px-0">

    <div class="card border-0 shadow-sm mb-2">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">Kelola Guru Pengampu: {{ $kelas->nama_kelas }}</h4>
            <a href="{{ route('admin.kelas.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white fw-bold">
                    <i class="bi bi-person-badge-fill"></i> Guru Pengampu Saat Ini
                </div>
                <div class="card-body">
                    @if($guruSaatIni)
                    <div class="border rounded p-3 bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold text-success mb-1">{{ $guruSaatIni->name }}</h5>
                            <p class="text-muted small mb-0"><i class="bi bi-envelope"></i> {{ $guruSaatIni->email }}</p>
                        </div>
                        <button class="btn btn-sm btn-danger remove-teacher" data-name="{{ $guruSaatIni->name }}">
                            <i class="bi bi-person-x"></i> Lepas Tugas
                        </button>
                    </div>
                    @else
                    <div class="text-center py-4 bg-light border rounded">
                        <i class="bi bi-person-exclamation text-muted" style="font-size: 2.5rem;"></i>
                        <p class="text-muted small mt-2 mb-0">Belum ada guru pengampu yang ditugaskan di kelas ini.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- SISI KANAN: DAFTAR GURU YANG TERDAFTAR DI SISTEM -->
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white fw-bold">
                    <i class="bi bi-list-check"></i> Pilih & Tugaskan Guru Pengampu
                </div>
                <div class="card-body">
                    @if($guruDaftar->count())
                    <div class="list-group">
                        @foreach($guruDaftar as $guru)
                        @php
                        $isCurrent = $guruSaatIni && $guruSaatIni->id === $guru->id;
                        $isAssignedToOther = $guru->is_assigned && !$isCurrent;
                        @endphp

                        <div class="list-group-item d-flex justify-content-between align-items-center {{ $isCurrent ? 'bg-success bg-opacity-10 border-success' : ($isAssignedToOther ? 'bg-light text-muted' : '') }}">
                            <div>
                                <strong class="{{ $isAssignedToOther ? 'text-muted' : 'text-dark' }}">{{ $guru->name }}</strong>

                                {{-- TAMPILKAN STATUS GURU --}}
                                @if($isCurrent)
                                <span class="badge bg-success ms-2">Aktif Mengampu Kelas Ini</span>
                                @elseif($isAssignedToOther)
                                <span class="badge bg-secondary ms-2">Mengampu: {{ $guru->kelas_yang_diampu }}</span>
                                @else
                                <span class="badge bg-primary ms-2">Belum Mengampu Kelas</span>
                                @endif
                                <br>
                                <small class="{{ $isAssignedToOther ? 'text-muted opacity-75' : 'text-muted' }}">{{ $guru->email }}</small>
                            </div>

                            {{-- LOGIKA TOMBOL --}}
                            @if($isCurrent)
                            <span class="text-success fw-bold small"><i class="bi bi-check border border-success rounded-circle"></i> Ditugaskan</span>
                            @elseif($isAssignedToOther)
                            <button class="btn btn-sm btn-secondary" disabled title="Guru sudah mengampu kelas lain">
                                <i class="bi bi-x-circle"></i> Mengampu Kelas Lain
                            </button>
                            @else
                            <button class="btn btn-sm btn-success add-teacher" data-id="{{ $guru->id }}" data-name="{{ $guru->name }}">
                                <i class="bi bi-check-circle"></i> Tugaskan
                            </button>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted">Tidak ada data guru yang ditemukan di sistem. Silakan tambah data guru terlebih dahulu.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Aksi Menugaskan Guru
        $(document).on('click', '.add-teacher', function() {
            var guruId = $(this).data('id');
            var guruName = $(this).data('name');

            Swal.fire({
                title: 'Tugaskan Guru?',
                text: 'Jadikan ' + guruName + ' sebagai pengampu kelas {{ $kelas->nama_kelas }}?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tugaskan',
                confirmButtonColor: '#198754'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.kelas.add-teacher', $kelas->id) }}",
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            guru_id: guruId
                        },
                        success: function(res) {
                            Swal.fire('Berhasil', res.message, 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            let msg = xhr.responseJSON?.message || 'Gagal menugaskan guru';
                            Swal.fire('Error', msg, 'error');
                        }
                    });
                }
            });
        });

        // Aksi Melepas Jabatan Guru Pengampu
        $(document).on('click', '.remove-teacher', function() {
            var guruName = $(this).data('name');

            Swal.fire({
                title: 'Lepas Tugas Guru?',
                text: 'Apakah Anda yakin ingin menghapus ' + guruName + ' dari posisi pengampu kelas {{ $kelas->nama_kelas }}?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, Lepas'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.kelas.remove-teacher', $kelas->id) }}",
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: 'DELETE'
                        },
                        success: function(res) {
                            Swal.fire('Berhasil', res.message, 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            let msg = xhr.responseJSON?.message || 'Gagal melepas tugas guru';
                            Swal.fire('Error', msg, 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection