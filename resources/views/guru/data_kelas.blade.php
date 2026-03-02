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

    <div class="modal fade" id="modalTambahKelas" tabindex="-1" aria-labelledby="modalTambahKelasLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold" id="modalTambahKelasLabel">Tambah Kelas Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('guru.data_kelas.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_kelas" class="form-label fw-bold">Nama Kelas</label>
                            <input type="text" 
                                name="nama_kelas" 
                                id="nama_kelas" 
                                class="form-control @error('nama_kelas') is-invalid @enderror" 
                                placeholder="Contoh: VIII A" 
                                required>
                            @error('nama_kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Sistem akan otomatis menggenerate Token setelah kelas disimpan.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success text-white px-4">Simpan Kelas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SweetAlert Success --}}
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: "{{ session('success') }}",
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        </script>
    @endif

    {{-- Tabel Utama --}}
    <div class="card shadow-sm border-1">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="tabelKelas">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th class="text-center">Nama Kelas</th>
                            <th class="text-center">Token</th>
                            <th class="text-center">Jumlah Siswa</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelas as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="fw-bold text-center">{{ $item->nama_kelas }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
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
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info text-dark rounded-pill px-3">
                                        {{ $item->siswa_count }} Siswa
                                    </span>
                                </td>
                                <td class="text-center">
                                    {{-- TOMBOL DETAIL (MATA) --}}
                                    <button class="btn btn-sm btn-info text-white me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetailKelas{{ $item->id }}"
                                            title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    {{-- TOMBOL EDIT --}}
                                    <button class="btn btn-sm btn-warning me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditKelas{{ $item->id }}"
                                            title="Edit Kelas">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    {{-- TOMBOL HAPUS --}}
                                    <form action="{{ route('guru.data_kelas.destroy', $item->id) }}"
                                          method="POST"
                                          class="d-inline form-hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus Kelas">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- ========================================== --}}
                            {{--           MODAL DETAIL (VIEW)              --}}
                            {{-- ========================================== --}}
                            <div class="modal fade" id="modalDetailKelas{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">

                                        {{-- HEADER --}}
                                        <div class="modal-header bg-success text-white">
                                            <div>
                                                <h5 class="modal-title fw-bold mb-0">
                                                    {{ $item->nama_kelas }}
                                                </h5>
                                                <small>Token: {{ $item->token }}</small>
                                            </div>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>

                                        {{-- BODY --}}
                                        <div class="modal-body">

                                            <div class="row">

                                                {{-- LIST SISWA --}}
                                                <div class="col-md-6 mb-3">
                                                    <h6 class="fw-bold mb-3">Daftar Siswa</h6>

                                                    @forelse($item->siswa as $siswa)
                                                        <div class="border rounded p-2 mb-2 bg-light">
                                                            <div class="fw-semibold">{{ $siswa->name }}</div>
                                                            <small class="text-muted">{{ $siswa->email }}</small>
                                                        </div>
                                                    @empty
                                                        <div class="text-muted small">
                                                            Belum ada siswa.
                                                        </div>
                                                    @endforelse
                                                </div>

                                                {{-- LIST AKTIVITAS --}}
                                                <div class="col-md-6 mb-3">
                                                    <h6 class="fw-bold mb-3">Aktivitas</h6>

                                                    @forelse($item->aktivitas as $akt)
                                                        <div class="border rounded p-2 mb-2 bg-light">
                                                            <div class="fw-semibold">{{ $akt->judul }}</div>
                                                            <small class="text-muted">
                                                                {{ ucfirst($akt->tipe ?? 'Kuis') }}
                                                            </small>
                                                        </div>
                                                    @empty
                                                        <div class="text-muted small">
                                                            Belum ada aktivitas.
                                                        </div>
                                                    @endforelse
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- AKHIR MODAL DETAIL --}}

                            {{-- Modal Edit (Tetap Disini) --}}
                            <div class="modal fade mt-5" id="modalEditKelas{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title fw-bold">Edit Kelas</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('guru.data_kelas.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Nama Kelas</label>
                                                    <input type="text" name="nama_kelas" class="form-control" value="{{ $item->nama_kelas }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success text-white fw-bold">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <img src="https://img.icons8.com/ios/100/cccccc/classroom.png" alt="Empty" style="width: 60px; opacity: 0.5;" class="mb-3">
                                    <p class="mb-0">Belum ada kelas yang dibuat.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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
        $('#tabelKelas').DataTable({
            language: { search: "Cari:", lengthMenu: "Tampilkan _MENU_", info: "Total _TOTAL_ data" },
            responsive: true
        });


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