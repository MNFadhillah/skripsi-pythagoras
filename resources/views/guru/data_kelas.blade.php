@extends('layouts.guru')

@section('title', 'Data Kelas • PythaLearn')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">Data Kelas</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKelas">
                <i class="bi bi-plus-lg me-1"></i> Tambah Kelas
            </button>
        </div>
    </div>

    {{-- SweetAlert Success --}}
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        </script>
    @endif

    {{-- Tabel --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tabelKelas">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Token (Kode)</th>
                            <th>Jumlah Siswa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelas as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-bold">{{ $item->nama_kelas }}</td>
                                <td>
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text"
                                               id="token-{{ $item->id }}"
                                               class="form-control text-center fw-bold text-primary bg-light"
                                               value="{{ $item->token }}"
                                               readonly>
                                        <button class="btn btn-outline-secondary"
                                                type="button"
                                                onclick="copyToken('{{ $item->id }}')">
                                            <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark rounded-pill px-3">
                                        {{ $item->siswa_count }} Siswa
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditKelas{{ $item->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <form action="{{ route('guru.data_kelas.destroy', $item->id) }}"
                                          method="POST"
                                          class="d-inline form-hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Modal Edit --}}
                            <div class="modal fade mt-5" id="modalEditKelas{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Kelas</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('guru.data_kelas.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Kelas</label>
                                                    <input type="text"
                                                           name="nama_kelas"
                                                           class="form-control"
                                                           value="{{ $item->nama_kelas }}"
                                                           required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Batal
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    Simpan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    Belum ada kelas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade mt-5" id="modalTambahKelas" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Buat Kelas Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('guru.data_kelas.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">
                            Nama Kelas <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="nama_kelas"
                               class="form-control"
                               placeholder="Contoh: X IPA 1"
                               required>
                    </div>
                    <div class="alert alert-info small mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        Token akan dibuat otomatis.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function copyToken(id) {
        let token = document.getElementById('token-' + id).value;
        navigator.clipboard.writeText(token);

        Swal.fire({
            icon: 'success',
            title: 'Token disalin',
            text: token,
            timer: 1500,
            showConfirmButton: false
        });
    }

    $(document).ready(function () {
        $('#tabelKelas').DataTable();

        $('.form-hapus').on('submit', function (e) {
            e.preventDefault();
            let form = this;

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data kelas tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
