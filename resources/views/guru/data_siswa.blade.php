@extends('layouts.guru')

@section('title', 'Data Siswa • PythaLearn')

@section('content')
<div class="container-fluid">

{{-- HEADER & ACTIONS (Gaya Baru) --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                {{-- Kiri: Judul --}}
                <div class="col-md-6">
                    <h4 class="fw-bold mb-0">Data Siswa</h4>
                </div>

                {{-- Kanan: Filter & Export --}}
                <div class="col-md-6 d-flex justify-content-md-end gap-2 mt-3 mt-md-0">
                    
                    {{-- 1. Form Filter Kelas --}}
                    <form action="{{ url()->current() }}" method="GET" class="d-flex gap-2">
                        <select name="kelas_id" class="form-select shadow-sm" style="width: 200px;" onchange="this.form.submit()">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($dataKelas as $kelas)
                                <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    {{-- 2. Tombol Export (Dengan Logika Teks Dinamis) --}}
                    @php
                        $teksExport = "Export Semua";
                        if(request()->filled('kelas_id')) {
                            $kelasTerpilih = $dataKelas->firstWhere('id', request('kelas_id'));
                            if($kelasTerpilih) $teksExport = "Export " . $kelasTerpilih->nama_kelas;
                        }
                    @endphp
                    <a href="{{ route('guru.data_siswa.export', request()->query()) }}" class="btn btn-success text-white shadow-sm">
                        <i class="bi bi-file-earmark-excel me-1"></i> {{ $teksExport }}
                    </a>

                </div>
            </div>
        </div>
    </div>

    {{-- CARD TABLE --}}
    <div class="card border-1 shadow-sm rounded">
        <div class="card-body">
            {{-- TABLE SISWA --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="tabelSiswa">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th class="text-center">Nama Siswa</th>
                            <th class="text-center">Alamat Email</th>
                            <th class="text-center">Kelas</th> 
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataSiswa as $index => $siswa)
                            <tr>
                                <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                                <td class="fw-semibold text-dark">{{ $siswa->name }}</td>
                                <td class="text-muted">{{ $siswa->email }}</td>
                                <td class="text-center">
                                    <span class="badge bg-info text-dark shadow-sm">
                                        {{ $siswa->kelas->nama_kelas ?? 'Belum ada kelas' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        {{-- TOMBOL EDIT --}}
                                        <button class="btn btn-sm btn-outline-warning border-0 btn-edit-siswa"
                                                title="Edit Siswa"
                                                data-id="{{ $siswa->id }}"
                                                data-name="{{ $siswa->name }}"
                                                data-email="{{ $siswa->email }}">
                                            <i class="bi bi-pencil-square fs-6"></i>
                                        </button>

                                        {{-- TOMBOL HAPUS --}}
                                        <button class="btn btn-sm btn-outline-danger border-0"
                                                title="Hapus Siswa"
                                                onclick="hapusSiswa('{{ $siswa->id }}')">
                                            <i class="bi bi-trash fs-6"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

{{-- MODAL EDIT SISWA --}}
<div class="modal fade" id="modalEditSiswa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success">
                <h5 class="modal-title fw-bold text-white">Edit Data Siswa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditSiswa">
                <div class="modal-body bg-light">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_siswa_id" name="id">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Siswa</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Baru</label>
                        <input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak diubah">
                        <small class="text-muted">Minimal 6 karakter.</small>
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success text-white">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        // INISIALISASI DATATABLES
        $('#tabelSiswa').DataTable({
            "language": {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ nilai",
                emptyTable: "Belum ada data siswa.",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                },
                "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
                
            },
            "pageLength": 10,
            "columnDefs": [
                { "orderable": false, "targets": [0, 4] } // No dan Aksi tidak bisa disorting
            ]
        });

        // TAMPILKAN MODAL EDIT
        $(document).on('click', '.btn-edit-siswa', function () {
            $('#edit_siswa_id').val($(this).data('id'));
            $('#edit_name').val($(this).data('name'));
            $('#edit_email').val($(this).data('email'));
            new bootstrap.Modal(document.getElementById('modalEditSiswa')).show();
        });

        // PROSES UPDATE VIA AJAX
        $('#formEditSiswa').on('submit', function (e) {
            e.preventDefault();
            const id = $('#edit_siswa_id').val();
            
            Swal.fire({ title: 'Menyimpan...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

            $.ajax({
                url: `/guru/data_siswa/${id}`,
                type: 'PUT',
                data: $(this).serialize(),
                success: function (res) {
                    if (res.success) {
                        Swal.fire('Berhasil', res.message, 'success').then(() => location.reload());
                    }
                },
                error: function (xhr) {
                    let msg = xhr.responseJSON?.errors ? Object.values(xhr.responseJSON.errors).join('\n') : 'Gagal simpan';
                    Swal.fire('Error', msg, 'error');
                }
            });
        });
    });

    // PROSES HAPUS SISWA
    function hapusSiswa(id) {
        Swal.fire({
            title: 'Hapus Siswa?',
            text: 'Seluruh riwayat pengerjaan juga akan terhapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'Menghapus...', didOpen: () => Swal.showLoading() });
                $.ajax({
                    url: `/guru/data_siswa/${id}`,
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (res) {
                        Swal.fire('Terhapus!', res.message, 'success').then(() => location.reload());
                    }
                });
            }
        });
    }
</script>
@endpush