@extends('layouts.admin')

@section('title', 'Manajemen User • PythaLearn')

@push('head')
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid px-0">
    
    <div class="card border-0 shadow-sm mb-2">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">Manajemen User</h4>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#userModal" id="btnTambahUser">
            <i class="bi bi-person-plus"></i> Tambah User
        </button>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="usersTable" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Kelas</th>
                            <th>Points</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Large untuk Tambah/Edit User -->
<div class="modal fade" id="userModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalTitle">Tambah User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="userForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">
                <input type="hidden" name="user_id" id="userId">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
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
                            <input type="password" name="password" id="password" class="form-control">
                            <small class="text-muted">Kosongkan jika tidak mengubah password (untuk edit)</small>
                            <div class="invalid-feedback" id="password_error"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            <div class="invalid-feedback" id="password_confirmation_error"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="siswa">Siswa</option>
                                <option value="guru">Guru</option>
                                <option value="admin">Admin</option>
                            </select>
                            <div class="invalid-feedback" id="role_error"></div>
                        </div>
                        <div class="col-md-6" id="kelasGroup">
                            <label class="form-label">Kelas</label>
                            <select name="kelas_id" id="kelas_id" class="form-select">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="kelas_id_error"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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
    // DataTables
    var table = $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.users.data') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'role', name: 'role' },
            { data: 'kelas_name', name: 'kelas.name', orderable: false },
            { data: 'points', name: 'points' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" }
    });

    // Tampilkan/hide field kelas berdasarkan role
    function toggleKelasField() {
        if ($('#role').val() === 'siswa') {
            $('#kelasGroup').show();
            $('#kelas_id').prop('required', false); // optional
        } else {
            $('#kelasGroup').hide();
            $('#kelas_id').val('');
            $('#kelas_id').prop('required', false);
        }
    }
    $('#role').change(toggleKelasField);
    toggleKelasField();

    // Reset form modal untuk tambah
    $('#btnTambahUser').click(function() {
        $('#userForm')[0].reset();
        $('#modalTitle').text('Tambah User');
        $('#methodField').val('POST');
        $('#userId').val('');
        $('#userForm').attr('action', "{{ route('admin.users.store') }}");
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        $('#password').prop('required', true);
        $('#password_confirmation').prop('required', true);
        toggleKelasField();
    });

    // Edit user
    $(document).on('click', '.edit-user', function() {
        var id = $(this).data('id');
        $.get("{{ url('admin/users') }}/" + id + "/edit", function(data) {
            $('#modalTitle').text('Edit User');
            $('#methodField').val('PUT');
            $('#userId').val(data.id);
            $('#name').val(data.name);
            $('#email').val(data.email);
            $('#role').val(data.role);
            $('#kelas_id').val(data.kelas_id);
            $('#userForm').attr('action', "{{ url('admin/users') }}/" + data.id);
            $('#password').prop('required', false);
            $('#password_confirmation').prop('required', false);
            toggleKelasField();
            $('#userModal').modal('show');
        }).fail(function() { Swal.fire('Error', 'Gagal mengambil data user', 'error'); });
    });

    // Submit form via AJAX
    $('#userForm').submit(function(e) {
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
                    $('#userModal').modal('hide');
                    table.ajax.reload();
                });
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').text('');
                    $.each(errors, function(key, value) {
                        $('#'+key).addClass('is-invalid');
                        $('#'+key+'_error').text(value[0]);
                    });
                } else {
                    Swal.fire('Error', 'Terjadi kesalahan', 'error');
                }
            }
        });
    });

    // Reset password
    $(document).on('click', '.reset-pwd', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        Swal.fire({
            title: 'Reset password?',
            text: 'Password user '+name+' akan direset menjadi "password123"',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, reset!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("{{ url('admin/users') }}/" + id + "/reset-password", {
                    _token: "{{ csrf_token() }}"
                }).done(function(res) {
                    Swal.fire('Berhasil', res.message, 'success');
                    table.ajax.reload();
                }).fail(function() {
                    Swal.fire('Error', 'Gagal reset password', 'error');
                });
            }
        });
    });

    // Hapus user
    $(document).on('click', '.delete-user', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        Swal.fire({
            title: 'Hapus user?',
            text: 'User '+name+' akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/users') }}/" + id,
                    type: 'POST',  // ← ubah dari DELETE ke POST
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: 'DELETE'  // ← tambahkan ini untuk spoofing
                    },
                    success: function(res) {
                        Swal.fire('Berhasil', res.message, 'success');
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire('Error', xhr.responseJSON.message || 'Gagal hapus', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush