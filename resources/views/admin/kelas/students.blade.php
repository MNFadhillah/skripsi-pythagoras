@extends('layouts.admin')

@section('title', 'Kelola Siswa - {{ $kelas->nama_kelas }} • PythaLearn')

@section('content')
<div class="container-fluid px-0">

    <div class="card border-0 shadow-sm mb-2">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">Kelola Siswa: {{ $kelas->nama_kelas }}</h4>
            <a href="{{ route('admin.kelas.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Daftar Siswa di Kelas Ini -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-people-fill"></i> Siswa di Kelas {{ $kelas->nama_kelas }}
                </div>
                <div class="card-body" id="siswaDiKelasList">
                    @if($siswaDiKelas->count())
                        <div class="list-group">
                            @foreach($siswaDiKelas as $siswa)
                                <div class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $siswa->id }}">
                                    <div>
                                        <strong>{{ $siswa->name }}</strong><br>
                                        <small class="text-muted">{{ $siswa->email }}</small>
                                    </div>
                                    <button class="btn btn-sm btn-danger remove-student" data-id="{{ $siswa->id }}" data-name="{{ $siswa->name }}">
                                        <i class="bi bi-person-x"></i> Keluarkan
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Belum ada siswa di kelas ini.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Daftar Siswa Belum Punya Kelas -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-person-plus"></i> Siswa Belum Bergabung Kelas
                </div>
                <div class="card-body" id="siswaBelumList">
                    @if($siswaBelum->count())
                        <div class="list-group">
                            @foreach($siswaBelum as $siswa)
                                <div class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $siswa->id }}">
                                    <div>
                                        <strong>{{ $siswa->name }}</strong><br>
                                        <small class="text-muted">{{ $siswa->email }}</small>
                                    </div>
                                    <button class="btn btn-sm btn-success add-student" data-id="{{ $siswa->id }}" data-name="{{ $siswa->name }}">
                                        <i class="bi bi-person-plus"></i> Tambahkan
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Semua siswa sudah memiliki kelas.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Event delegation untuk tombol tambah siswa
    $(document).on('click', '.add-student', function() {
        var studentId = $(this).data('id');
        var studentName = $(this).data('name');
        Swal.fire({
            title: 'Tambahkan siswa?',
            text: 'Tambahkan ' + studentName + ' ke kelas {{ $kelas->nama_kelas }}?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, tambahkan'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.kelas.add-student', $kelas->id) }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        student_id: studentId
                    },
                    success: function(res) {
                        Swal.fire('Berhasil', res.message, 'success').then(() => {
                            location.reload(true);
                        });
                    },
                    error: function(xhr) {
                        let msg = xhr.responseJSON?.message || 'Gagal menambahkan siswa';
                        Swal.fire('Error', msg, 'error');
                    }
                });
            }
        });
    });

    // Event delegation untuk tombol keluarkan siswa
    $(document).on('click', '.remove-student', function() {
        var studentId = $(this).data('id');
        var studentName = $(this).data('name');
        Swal.fire({
            title: 'Keluarkan siswa?',
            text: 'Keluarkan ' + studentName + ' dari kelas {{ $kelas->nama_kelas }}?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, keluarkan'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/kelas') }}/{{ $kelas->id }}/remove-student/" + studentId,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: 'DELETE'
                    },
                    success: function(res) {
                        Swal.fire('Berhasil', res.message, 'success').then(() => {
                            location.reload(true);
                        });
                    },
                    error: function(xhr) {
                        let msg = xhr.responseJSON?.message || 'Gagal mengeluarkan siswa';
                        Swal.fire('Error', msg, 'error');
                    }
                });
            }
        });
    });
});
</script>
@endsection