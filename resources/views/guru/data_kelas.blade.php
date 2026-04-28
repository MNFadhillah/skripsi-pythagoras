@extends('layouts.guru')

@section('title', 'Data Kelas • PythaLearn')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">Data Kelas</h4>
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
        document.addEventListener('DOMContentLoaded', function() {
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

    {{-- Tabel Utama / Empty State --}}
    @if($kelas->isEmpty())
    <div class="card shadow-sm border-0 bg-white rounded-3 mt-4">
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle" style="width: 100px; height: 100px;">
                    <i class="bi bi-journal-x text-muted" style="font-size: 3rem;"></i>
                </div>
            </div>
            <h5 class="fw-bold text-dark">Belum Ada Data Kelas</h5>
            <p class="text-muted mb-4">Anda belum ditugaskan untuk mengampu kelas manapun. Silakan hubungi Administrator untuk menautkan akun Anda dengan kelas.</p>
            {{-- Opsi: Hapus tombol ini jika Guru tidak boleh membuat kelas sendiri --}}
            <button class="btn btn-outline-success px-4" onclick="showNoClassAlert()">
                <i class="bi bi-info-circle me-1"></i> Info Lebih Lanjut
            </button>
        </div>
    </div>
    @else
    <div class="card shadow-sm border-1 mt-4">
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
                        @foreach($kelas as $index => $item)
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
                                <button class="btn btn-sm btn-info text-white me-1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalDetailKelas{{ $item->id }}"
                                    title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- PINDAHKAN MODAL DETAIL KE SINI (DILUAR TABEL TAPI MASIH DI DALAM @else) --}}
    @foreach($kelas as $item)
    <div class="modal fade" id="modalDetailKelas{{ $item->id }}" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <div>
                        <h5 class="modal-title fw-bold mb-0">{{ $item->nama_kelas }}</h5>
                        <small>Token: {{ $item->token }}</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
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
                            <div class="text-muted small">Belum ada siswa.</div>
                            @endforelse
                        </div>
                        {{-- LIST AKTIVITAS --}}
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold mb-3">Aktivitas</h6>
                            @forelse($item->aktivitas as $akt)
                            <div class="border rounded p-2 mb-2 bg-light">
                                <div class="fw-semibold">{{ $akt->judul }}</div>
                                <small class="text-muted">{{ ucfirst($akt->tipe ?? 'Kuis') }}</small>
                            </div>
                            @empty
                            <div class="text-muted small">Belum ada aktivitas.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    {{-- AKHIR PEMINDAHAN MODAL --}}
    @endif
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

    $(document).ready(function() {
        $('#tabelKelas').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_",
                info: "Total _TOTAL_ data"
            },
            responsive: true
        });


        $('.form-hapus').on('submit', function(e) {
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
    // Tambahkan ini di dalam <script> Anda
    function showNoClassAlert() {
        Swal.fire({
            icon: 'info',
            title: 'Informasi Kelas',
            text: 'Karena Anda belum ditugaskan ke kelas manapun, halaman data siswa dan rekapitulasi nilai belum dapat diakses. Anda tetap dapat menyiapkan soal di menu Paket Soal.',
            confirmButtonColor: '#379080',
            confirmButtonText: 'Mengerti'
        });
    }
</script>
@endpush