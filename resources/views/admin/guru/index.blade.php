@extends('layouts.admin')

@section('title', 'Manajemen Data Guru • PythaLearn')

@push('head')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm mb-2">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">Manajemen Data Guru</h4>
            <button class="btn btn-success" id="btnTambahGuru">
                <i class="bi bi-person-plus"></i> Tambah Guru
            </button>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="guruTable" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Guru</th>
                            <th>Email Akun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="guruModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalTitle">Tambah Guru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="guruForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">
                <input type="hidden" name="guru_id" id="guruId">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap Guru <span class="text-danger">*</span></label>
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
                            <small class="text-muted mt-1 d-block" id="passHelp">Kosongkan jika tidak mengubah password</small>
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
                    <button type="submit" class="btn btn-success" id="btnSubmit">Simpan</button>
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
        var table = $('#guruTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.guru.data') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" }
        });

        $('#btnTambahGuru').click(function() {
            $('#guruForm')[0].reset();
            $('#modalTitle').text('Tambah Identitas Guru');
            $('#methodField').val('POST');
            $('#guruId').val('');
            $('#guruForm').attr('action', "{{ route('admin.guru.store') }}");
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            $('#password, #password_confirmation').prop('required', true);
            $('#passHelp').text('Minimal 6 karakter.');
            $('#guruModal').modal('show');
        });

        $(document).on('click', '.edit-guru', function() {
            var id = $(this).data('id');
            $.get("{{ url('admin/guru') }}/" + id + "/edit", function(data) {
                $('#modalTitle').text('Edit Data Guru');
                $('#methodField').val('PUT');
                $('#guruId').val(data.id);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#password, #password_confirmation').prop('required', false);
                $('#passHelp').text('Kosongkan jika tidak ingin merubah password.');
                $('#guruForm').attr('action', "{{ url('admin/guru') }}/" + data.id);
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $('#guruModal').modal('show');
            });
        });

        $('#guruForm').submit(function(e) {
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
                        $('#guruModal').modal('hide');
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
                    $.post("{{ url('admin/guru') }}/" + id + "/reset-password", { _token: "{{ csrf_token() }}" })
                    .done(function(res) {
                        Swal.fire('Berhasil', res.message, 'success');
                    });
                }
            });
        });

        $(document).on('click', '.delete-guru', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            Swal.fire({
                title: 'Hapus data guru?',
                text: 'Akun ' + name + ' akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/guru') }}/" + id,
                        type: 'POST',
                        data: { _token: "{{ csrf_token() }}", _method: 'DELETE' },
                        success: function(res) {
                            Swal.fire('Berhasil', res.message, 'success');
                            table.ajax.reload();
                        }
                    });
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