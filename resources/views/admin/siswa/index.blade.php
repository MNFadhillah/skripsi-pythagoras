@extends('layouts.admin')

@section('title', 'Manajemen Data Siswa • PythaLearn')

@push('head')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm mb-2">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">Manajemen Data Siswa</h4>
            <div>
                <button class="btn btn-outline-success me-2" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="bi bi-file-earmark-excel"></i> Import Excel
                </button>
                <button class="btn btn-success" id="btnTambahSiswa">
                    <i class="bi bi-person-plus"></i> Tambah Siswa
                </button>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="siswaTable" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Email Akun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="siswaModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalTitleSiswa">Tambah Siswa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="siswaForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="methodFieldSiswa" value="POST">
                <input type="hidden" name="siswa_id" id="siswaId">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap Siswa <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" required>
                            <div class="invalid-feedback" id="name_error"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control" required>
                            <div class="invalid-feedback" id="email_error"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <div class="input-group has-validation">
                                <input type="password" name="password" id="password" class="form-control">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#password">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <div class="invalid-feedback" id="password_error"></div>
                            </div>
                            <small class="text-muted mt-1 d-block" id="passHelpSiswa">Kosongkan jika tidak mengubah password</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Password</label>
                            <div class="input-group has-validation">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#password_confirmation">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <div class="invalid-feedback" id="password_confirmation_error"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="importModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-file-earmark-excel me-2"></i>Import Data Siswa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="importSiswaForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-light border small text-muted mb-3">
                        <strong class="text-success">Aturan Baris Kepala (Heading Row) Excel:</strong><br>
                        Pastikan baris pertama Excel Anda memiliki nama kolom persis:
                        <code class="fw-bold text-dark">nama</code>,
                        <code class="fw-bold text-dark">email</code>, dan
                        <code class="fw-bold text-dark">password</code>.
                        <br><br>
                        <em>*Catatan: Jika kolom password dikosongkan, sistem akan otomatis menetapkannya menjadi <strong class="text-danger">password123</strong>.</em>
                    </div>

                    <div class="mb-4 text-center bg-light p-3 rounded border border-dashed">
                        <p class="small text-muted mb-2">Belum memiliki format Excel yang sesuai?</p>
                        <a href="{{ route('admin.siswa.template') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-download me-1"></i> Download Template Excel (.xlsx)
                        </a>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih File Excel Yang Sudah Diisi</label>
                        <input type="file" name="file_excel" class="form-control border-success" required accept=".xlsx, .xls">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-success px-4" id="btnSubmitImport">Mulai Proses Import</button>
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
        var table = $('#siswaTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.siswa.data') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
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

        $('#btnTambahSiswa').click(function() {
            $('#siswaForm')[0].reset();
            $('#modalTitleSiswa').text('Tambah Identitas Siswa');
            $('#methodFieldSiswa').val('POST');
            $('#siswaId').val('');
            $('#siswaForm').attr('action', "{{ route('admin.siswa.store') }}");
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            $('#password, #password_confirmation').prop('required', true);
            $('#passHelpSiswa').text('Minimal 6 karakter.');
            $('#siswaModal').modal('show');
        });

        $(document).on('click', '.edit-siswa', function() {
            var id = $(this).data('id');
            $.get("{{ url('admin/siswa') }}/" + id + "/edit", function(data) {
                $('#modalTitleSiswa').text('Edit Data Siswa');
                $('#methodFieldSiswa').val('PUT');
                $('#siswaId').val(data.id);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#password, #password_confirmation').prop('required', false);
                $('#passHelpSiswa').text('Kosongkan jika tidak ingin merubah password.');
                $('#siswaForm').attr('action', "{{ url('admin/siswa') }}/" + data.id);
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $('#siswaModal').modal('show');
            });
        });

        $('#siswaForm').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.fire('Berhasil', res.message, 'success').then(() => {
                        $('#siswaModal').modal('hide');
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
                    }
                }
            });
        });

        $(document).on('click', '.reset-pwd', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            Swal.fire({
                title: 'Reset password?',
                text: 'Password ' + name + ' akan direset menjadi "password123"',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, reset!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post("{{ url('admin/siswa') }}/" + id + "/reset-password", {
                            _token: "{{ csrf_token() }}"
                        })
                        .done(function(res) {
                            Swal.fire('Berhasil', res.message, 'success');
                        });
                }
            });
        });

        $(document).on('click', '.delete-siswa', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            Swal.fire({
                title: 'Hapus data siswa?',
                text: 'Akun ' + name + ' akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/siswa') }}/" + id,
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: 'DELETE'
                        },
                        success: function(res) {
                            Swal.fire('Berhasil', res.message, 'success');
                            table.ajax.reload();
                        }
                    });
                }
            });
        });

        // Submit Form Import Siswa via AJAX
        $('#importSiswaForm').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var btnSubmit = $('#btnSubmitImport');

            btnSubmit.prop('disabled', true).text('Sedang Mengimport...');

            $.ajax({
                url: "{{ route('admin.siswa.import') }}",
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.success) {
                        Swal.fire('Berhasil', res.message, 'success').then(() => {
                            $('#importModal').modal('hide');
                            form[0].reset();
                            table.ajax.reload(null, false); // Reload datatable siswa
                        });
                    }
                },
                error: function(xhr) {
                    var msg = 'Gagal memproses file Excel.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    Swal.fire('Gagal Import', msg, 'error');
                },
                complete: function() {
                    btnSubmit.prop('disabled', false).text('Mulai Proses Import');
                }
            });
        });

        $(document).on('click', '.toggle-password', function() {
            var targetSelector = $(this).data('target');
            var input = $(targetSelector);
            var icon = $(this).find('i');

            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('bi-eye-slash').addClass('bi-eye');
            }
        });
    });
</script>
@endpush