@extends('layouts.guru')

@section('title', 'Data Siswa • PythaLearn')

@section('content')
<div class="container-fluid">

{{-- HEADER --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            {{-- Judul Halaman --}}
            <h4 class="fw-bold mb-0">Data Siswa</h4>

            {{-- Tombol Biru Tanpa Icon --}}
            <button class="btn btn-primary shadow-sm"
                onclick="Swal.fire('Info', 'Fitur Belum Tersedia', 'info')">
                <i class="bi bi-plus-lg me-1"></i>Tambah Siswa
            </button>
        </div>
    </div>

    {{-- CARD TABLE --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">

            {{-- SEARCH --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text"
                            id="searchSiswa"
                            class="form-control"
                            placeholder="Cari nama atau email siswa...">
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tabelSiswa">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th width="10%">Avatar</th>
                            <th width="25%">Nama</th>
                            <th width="25%">Email</th>
                            <th width="20%">Tanggal Bergabung</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataSiswa as $index => $siswa)
                            <tr>
                                {{-- NOMOR --}}
                                <td class="text-center fw-semibold">
                                    {{ $dataSiswa->firstItem() + $index }}
                                </td>

                                {{-- AVATAR --}}
                                <td>
                                    <div class="rounded-circle bg-light border
                                        d-flex align-items-center justify-content-center"
                                        style="width:42px;height:42px;">
                                        <i class="bi bi-person-fill text-secondary fs-5"></i>
                                    </div>
                                </td>

                                {{-- NAMA --}}
                                <td class="fw-semibold text-dark">
                                    {{ $siswa->name }}
                                </td>

                                {{-- EMAIL --}}
                                <td class="text-muted">
                                    {{ $siswa->email }}
                                </td>

                                {{-- TANGGAL --}}
                                <td class="text-muted">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    {{ $siswa->created_at->translatedFormat('d M Y') }}
                                </td>

                                {{-- AKSI --}}
                                <td class="text-center">
                                    <div class="btn-group">

                                        {{-- EDIT (DUMMY) --}}
                                        <button class="btn btn-sm btn-outline-warning border-0"
                                            title="Edit"
                                            onclick="editSiswa('{{ $siswa->name }}')">
                                            <i class="bi bi-pencil-square fs-6"></i>
                                        </button>

                                        {{-- HAPUS (DUMMY / SIAP AKTIF) --}}
                                        <button class="btn btn-sm btn-outline-danger border-0"
                                            title="Hapus"
                                            onclick="hapusSiswa('{{ $siswa->id }}')">
                                            <i class="bi bi-trash fs-6"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-1 opacity-25"></i>
                                    <p class="mt-2 mb-0">Belum ada data siswa</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $dataSiswa->links() }}
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // SEARCH FILTER
    document.getElementById('searchSiswa').addEventListener('keyup', function () {
        let keyword = this.value.toLowerCase();
        document.querySelectorAll('#tabelSiswa tbody tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(keyword)
                ? ''
                : 'none';
        });
    });

    // EDIT (DUMMY)
    function editSiswa(nama) {
        Swal.fire({
            title: 'Edit Siswa',
            text: 'Fitur Belum Tesedia',
            icon: 'info'
        });
    }

    // HAPUS (SIAP DIAKTIFKAN)
    function hapusSiswa(id) {
        Swal.fire({
            title: 'Hapus Siswa?',
            text: 'Data siswa akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Berhasil',
                    'Fitur hapus belum diaktifkan.',
                    'success'
                );
            }
        });
    }
</script>
@endpush
