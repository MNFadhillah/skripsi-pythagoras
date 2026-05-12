@extends('layouts.admin')

@section('title', 'Manajemen Kelas • PythaLearn')

@push('head')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm mb-2">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">Manajemen Kelas</h4>
            <div>
                <button class="btn btn-outline-success me-2" data-bs-toggle="modal" data-bs-target="#tokenGuruModal">
                    <i class="bi bi-key"></i> Atur Token Guru
                </button>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#kelasModal" id="btnTambahKelas">
                    <i class="bi bi-building-add"></i> Tambah Kelas
                </button>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="kelasTable" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Wali Kelas</th>
                            <th>Jumlah Siswa</th>
                            <th>Token</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Kelas -->
<div class="modal fade" id="kelasModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalTitle">Tambah Kelas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="kelasForm">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">
                <input type="hidden" name="kelas_id" id="kelasId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" required>
                        <div class="invalid-feedback" id="nama_kelas_error"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Wali Kelas (Guru)</label>
                        <select name="guru_id" id="guru_id" class="form-select">
                            <option value="">-- Pilih Guru --</option>
                            @foreach(\App\Models\User::where('role','guru')->get() as $guru)
                            <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="guru_id_error"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Token Kelas</label>
                        <input type="text" name="token" id="token" class="form-control" maxlength="10">
                        <small class="text-muted">Kosongkan untuk generate otomatis</small>
                        <div class="invalid-feedback" id="token_error"></div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="detailModalTitle">Detail Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailModalBody">
                Loading...
            </div>
        </div>
    </div>
</div>

<!-- Modal Token Guru -->
<div class="modal fade" id="tokenGuruModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Pengaturan Token Registrasi Guru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="tokenGuruForm">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-light border small text-muted">
                        Token ini adalah kode rahasia global yang harus dimasukkan oleh pendaftar yang memilih role <strong>Guru</strong> di halaman Registrasi.
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-success fw-bold">Token Pendaftaran Guru</label>
                        @php
                        $settingToken = \App\Models\Setting::where('key', 'guru_token')->first();
                        $tokenValue = $settingToken ? $settingToken->value : '';
                        @endphp
                        <input type="text" name="guru_token" id="input_guru_token" class="form-control" value="{{ $tokenValue }}" placeholder="Contoh: GURU-2026" required>
                        <div class="invalid-feedback" id="guru_token_error"></div>
                    </div>
                </div>
                <div class="modal-footer border-0">

                    <button type="submit" class="btn btn-success">Simpan Token</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="kelolaGuruModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white" style="background-color: #379080;">
                <h5 class="modal-title"><i class="bi bi-person-badge me-2"></i>Kelola Guru Pengampu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="kelolaGuruForm">
                @csrf
                <input type="hidden" name="kelas_id" id="kg_kelasId">

                <div class="modal-body">
                    <div class="alert alert-light border small text-muted mb-4">
                        Tentukan guru yang akan mengampu materi Teorema Pythagoras di kelas <strong id="kg_namaKelas" class="text-success"></strong>.
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Guru</label>
                        <select name="guru_id" id="kg_guru_id" class="form-select border-success">
                            <option value="">-- Kosongkan (Belum Ada Guru) --</option>
                            @foreach(\App\Models\User::where('role','guru')->get() as $guru)
                            <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">

                    <button type="submit" class="btn btn-success px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        var table = $('#kelasTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.kelas.data') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_kelas',
                    name: 'nama_kelas'
                },
                {
                    data: 'wali_kelas',
                    name: 'wali_kelas',
                    orderable: false
                },
                {
                    data: 'jumlah_siswa',
                    name: 'jumlah_siswa',
                    orderable: false
                },
                {
                    data: 'token',
                    name: 'token'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            }
        });

        // Tambah Kelas
        $('#btnTambahKelas').click(function() {
            $('#kelasForm')[0].reset();
            $('#modalTitle').text('Tambah Kelas');
            $('#methodField').val('POST');
            $('#kelasId').val('');
            $('#kelasForm').attr('action', "{{ route('admin.kelas.store') }}");
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').text('');
        });

        // Edit Kelas
        $(document).on('click', '.edit-kelas', function() {
            var id = $(this).data('id');
            $.get("{{ url('admin/kelas') }}/" + id + "/edit", function(data) {
                $('#modalTitle').text('Edit Kelas');
                $('#methodField').val('PUT');
                $('#kelasId').val(data.id);
                $('#nama_kelas').val(data.nama_kelas);
                $('#guru_id').val(data.guru_id);
                $('#token').val(data.token);
                $('#kelasForm').attr('action', "{{ url('admin/kelas') }}/" + data.id);
                $('#kelasModal').modal('show');
            }).fail(function() {
                Swal.fire('Error', 'Gagal mengambil data kelas', 'error');
            });
        });

        // Submit Form Kelas
        $('#kelasForm').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var method = $('#methodField').val();
            var formData = new FormData(this);
            formData.append('_method', method);
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.fire('Berhasil', res.message, 'success').then(() => {
                        $('#kelasModal').modal('hide');
                        table.ajax.reload();
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').text('');
                        $.each(errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key + '_error').text(value[0]);
                        });
                    } else {
                        Swal.fire('Error', 'Terjadi kesalahan', 'error');
                    }
                }
            });
        });

        // Hapus Kelas
        $(document).on('click', '.delete-kelas', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            Swal.fire({
                title: 'Hapus kelas?',
                text: 'Kelas ' + nama + ' akan dihapus. Siswa di kelas ini akan dikeluarkan (kelas menjadi kosong).',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/kelas') }}/" + id,
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: 'DELETE'
                        },
                        success: function(res) {
                            Swal.fire('Berhasil', res.message, 'success');
                            table.ajax.reload();
                        },
                        error: function() {
                            Swal.fire('Error', 'Gagal hapus kelas', 'error');
                        }
                    });
                }
            });
        });

        // Kelola Siswa (redirect ke halaman manage)
        $(document).on('click', '.manage-siswa', function() {
            var id = $(this).data('id');
            window.location.href = "{{ url('admin/kelas') }}/" + id + "/students";
        });

        $(document).on('click', '.detail-kelas', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            $('#detailModalTitle').text('Detail Kelas - ' + nama);
            $('#detailModalBody').html('<div class="text-center">Memuat data...</div>');
            $('#detailModal').modal('show');
            $.get('{{ url("admin/kelas") }}/' + id + '/detail', function(data) {
                $('#detailModalBody').html(data);
            }).fail(function() {
                $('#detailModalBody').html('<div class="alert alert-danger">Gagal memuat data.</div>');
            });
        });

        // Detail kelas
        $(document).on('click', '.detail-kelas', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            $('#detailModalTitle').text('Detail Kelas - ' + nama);
            $('#detailModalBody').html('<div class="text-center">Memuat data...</div>');
            $('#detailModal').modal('show');

            $.ajax({
                url: "{{ url('admin/kelas') }}/" + id + "/detail",
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    var html = '<div class="row">';
                    // Siswa
                    html += '<div class="col-md-6 mb-3"><h6 class="fw-bold mb-3">Daftar Siswa</h6>';
                    if (res.siswa.length) {
                        res.siswa.forEach(function(s) {
                            html += '<div class="border rounded p-2 mb-2 bg-light"><div class="fw-semibold">' + escapeHtml(s.name) + '</div><small class="text-muted">' + escapeHtml(s.email) + '</small></div>';
                        });
                    } else {
                        html += '<div class="text-muted small">Belum ada siswa.</div>';
                    }
                    html += '</div>';
                    // Aktivitas
                    html += '<div class="col-md-6 mb-3"><h6 class="fw-bold mb-3">Aktivitas</h6>';
                    if (res.aktivitas.length) {
                        res.aktivitas.forEach(function(a) {
                            html += '<div class="border rounded p-2 mb-2 bg-light"><div class="fw-semibold">' + escapeHtml(a.judul) + '</div><small class="text-muted">' + escapeHtml(a.tipe) + '</small></div>';
                        });
                    } else {
                        html += '<div class="text-muted small">Belum ada aktivitas.</div>';
                    }
                    html += '</div></div>';
                    $('#detailModalBody').html(html);
                },
                error: function() {
                    $('#detailModalBody').html('<div class="alert alert-danger">Gagal memuat data.</div>');
                }
            });
        });

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        // Submit Form Token Guru
        $('#tokenGuruForm').submit(function(e) {
            e.preventDefault();

            var tokenValue = $('#input_guru_token').val();
            var btnSubmit = $(this).find('button[type="submit"]');

            // Ubah state tombol
            btnSubmit.prop('disabled', true).text('Menyimpan...');
            $('#input_guru_token').removeClass('is-invalid');

            $.ajax({
                url: "{{ route('admin.pengaturan.token.update') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    guru_token: tokenValue
                },
                success: function(res) {
                    Swal.fire({
                        title: 'Berhasil',
                        text: res.message,
                        icon: 'success',
                        confirmButtonColor: '#198754' // Warna sukses (Hijau)
                    }).then(() => {
                        $('#tokenGuruModal').modal('hide');
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $('#input_guru_token').addClass('is-invalid');
                        $('#guru_token_error').text(errors.guru_token[0]);
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Terjadi kesalahan pada server.',
                            icon: 'error',
                            confirmButtonColor: '#d33'
                        });
                    }
                },
                complete: function() {
                    // Kembalikan state tombol
                    btnSubmit.prop('disabled', false).text('Simpan Token');
                }
            });
        });

        // ==========================================
        // FITUR KELOLA GURU (ASSIGN TEACHER)
        // ==========================================

        // 1. Saat tombol Kelola Guru diklik
        $(document).on('click', '.kelola-guru', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');

            // Tampilkan loading state jika perlu, lalu ambil data guru saat ini
            $.get("{{ url('admin/kelas') }}/" + id + "/edit", function(data) {
                $('#kg_kelasId').val(data.id);
                $('#kg_namaKelas').text(data.nama_kelas);
                $('#kg_guru_id').val(data.guru_id); // Set dropdown ke guru saat ini

                // Ubah action URL form agar mengarah ke endpoint update guru
                $('#kelolaGuruForm').attr('action', "{{ url('admin/kelas') }}/" + data.id + "/update-guru");
                $('#kelolaGuruModal').modal('show');
            }).fail(function() {
                Swal.fire('Error', 'Gagal memuat data guru kelas ini.', 'error');
            });
        });
        // 2. Submit Form Kelola Guru
        $('#kelolaGuruForm').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var btnSubmit = form.find('button[type="submit"]');

            btnSubmit.prop('disabled', true).text('Menyimpan...');

            $.ajax({
                url: url,
                type: 'POST', // Method overriding dengan _method=PUT di dalam form
                data: form.serialize(),
                success: function(res) {
                    Swal.fire({
                        title: 'Berhasil',
                        text: res.message,
                        icon: 'success',
                        confirmButtonColor: '#379080'
                    }).then(() => {
                        $('#kelolaGuruModal').modal('hide');
                        $('#kelasTable').DataTable().ajax.reload(null, false); // Refresh tabel tanpa mereset pagination
                    });
                },
                error: function(xhr) {
                    var pesanError = 'Terjadi kesalahan yang tidak diketahui.';

                    // Jika gagal karena validasi
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        pesanError = Object.values(errors)[0][0]; // Ambil pesan error pertama
                    }
                    // Jika gagal karena database (Exception 500)
                    else if (xhr.responseJSON && xhr.responseJSON.message) {
                        pesanError = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        title: 'Gagal Menyimpan!',
                        text: pesanError,
                        icon: 'error',
                        confirmButtonColor: '#d33'
                    });
                },
                complete: function() {
                    btnSubmit.prop('disabled', false).text('Simpan Perubahan');
                }
            });
        });

    });
</script>
@endpush