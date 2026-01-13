@extends('layouts.guru')

@section('title', 'Aktivitas Belajar | PythaLearn')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold">Aktivitas Siswa</h4>
        </div>
        <button class="btn btn-primary shadow-sm" id="btnTambah">
            <i class="bi bi-plus-lg me-1"></i>Tambah Aktivitas
        </button>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tabelAktivitas">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Judul Aktivitas</th>
                            <th>Kategori</th>
                            <th>Tipe</th>
                            <th>Jadwal & Token</th>
                            <th class="text-center">Status</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($aktivitas as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->judul }}</div>
                                <div class="small text-muted">Paket Soal: {{ $item->paket_soal->judul ?? 'Paket Tidak Ditemukan' }}
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border border-secondary">
                                    {{ ucfirst($item->kategori) }}
                                </span>
                            </td>
                            <td>
                                @if($item->tipe == 'streak')
                                    <span class="badge bg-danger mb-1"><i class="bi bi-fire"></i> Streak</span>
                                @elseif($item->tipe == 'evaluasi')
                                    <span class="badge bg-warning text-dark mb-1"><i class="bi bi-journal-check"></i> Evaluasi</span>
                                @else
                                    <span class="badge bg-info mb-1">Kuis</span>
                                @endif
                                <br>
                            </td>
                            <td>
                                <div class="small">
                                    <span class="text-secondary" title="Mulai"><i class="bi bi-play-fill"></i> {{ $item->waktu_mulai ? $item->waktu_mulai->format('d M, H:i') : '-' }}</span>
                                    <br>
                                    <span class="text-secondary" title="Selesai"><i class="bi bi-stop-fill"></i> {{ $item->waktu_selesai ? $item->waktu_selesai->format('d M, H:i') : '-' }}</span>
                                </div>
                                @if($item->token)
                                    <code class="text-primary fw-bold mt-1 d-inline-block">{{ $item->token }}</code>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->status)
                                    <span class="badge bg-success rounded-pill px-3">AKTIF</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-3">TIDAK AKTIF</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning btn-edit text-white" data-id="{{ $item->id }}" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <button class="btn btn-sm btn-danger btn-hapus" data-id="{{ $item->id }}" title="Hapus">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="modal fade mt-4" id="modalForm" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            
            <div class="modal-header bg-success text-white px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="modalTitle">Buat Aktivitas</h5>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <form id="formAktivitas">
                @csrf
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="_method" id="_method" value="POST">

                <div class="modal-body p-0">
                    <div class="row g-0">
                        
                        <div class="col-lg-7 p-4 border-end">
                            <h6 class="text-success fw-bold mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-journal-text"></i> Informasi Utama
                            </h6>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-secondary">Judul Aktivitas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-light border-0 py-2" name="judul" id="judul" required placeholder="Kuis 1 : Menemukan Konsep Teorema Pythagoras">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-secondary">Kategori Materi <span class="text-danger">*</span></label>
                                <select class="form-select bg-light border-0 py-2" name="kategori" id="kategori" required>
                                    <option value="">-- Pilih Posisi Menu --</option>
                                    <option value="konsep">1. Menemukan Konsep Pythagoras</option>
                                    <option value="tripel">2. Tripel Pythagoras</option>
                                    <option value="istimewa">3. Segitiga Istimewa</option>
                                    <option value="penerapan">4. Penerapan Teorema</option>
                                    <option value="evaluasi">Evaluasi Akhir</option>
                                </select>
                                <div class="form-text small">Menentukan di menu mana aktivitas ini akan muncul pada sidebar siswa.</div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-secondary">Tipe Aktivitas</label>
                                    <div class="input-group">
                                        <select class="form-select bg-light border-start-0 py-2" name="tipe" id="tipe" required>
                                            <option value="kuis">Kuis</option>
                                            <option value="evaluasi">Evaluasi</option>
                                            <option value="streak">Streak</option>
                                            <option value="materi">Materi Bacaan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-secondary">Poin Hadiah</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control bg-light border-0" name="poin_didapat" id="poin_didapat" value="100" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-secondary">Hubungkan Paket Soal</label>
                                <select class="form-select bg-light border-0 py-2" name="paket_soal_id" id="paket_soal_id">
                                    <option value="">-- Pilih Paket Soal --</option>
                                    @foreach($listPaket as $paket)
                                        <option value="{{ $paket->id }}">{{ $paket->judul }}</option>
                                    @endforeach
                                </select>
                            </div>

                             <div class="mb-0">
                                <label class="form-label fw-semibold small text-secondary">Instruksi / Catatan</label>
                                <textarea class="form-control bg-light border-0" name="instruksi" id="instruksi" rows="3" placeholder="Instruksi untuk siswa"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-5 p-4 bg-light bg-opacity-25">
                            <h6 class="text-success fw-bold mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-calendar-check"></i> Jadwal & Akses
                            </h6>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-secondary">Waktu Mulai</label>
                                <input type="datetime-local" class="form-control bg-white border shadow-sm" name="waktu_mulai" id="waktu_mulai">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-secondary">Waktu Selesai</label>
                                <input type="datetime-local" class="form-control bg-white border shadow-sm" name="waktu_selesai" id="waktu_selesai">
                            </div>

                            <hr class="border-secondary opacity-25 my-4">

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-secondary">Durasi (Menit)</label>
                                <div class="input-group shadow-sm">
                                    <input type="number" class="form-control border-end-0" name="durasi_menit" id="durasi_menit" value="60">
                                    <span class="input-group-text bg-white text-muted">Menit</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold small text-secondary">Token Masuk (Opsional)</label>
                                <input type="text" class="form-control bg-white text-uppercase shadow-sm fw-bold letter-spacing-2" name="token" id="token" placeholder="-----" maxlength="6" style="letter-spacing: 3px; text-align: center;">
                            </div>

                            <div class="card border-0 shadow-sm bg-white">
                                <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                                    <label class="form-check-label small fw-bold text-dark" for="status">
                                        Buka Akses Sekarang?
                                    </label>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" name="status" id="status" value="1" checked style="transform: scale(1.3);">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light border-top-0 px-4 py-3">
                    <button type="button" class="btn btn-link text-decoration-none text-muted fw-semibold me-auto" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-3 px-5 shadow fw-bold">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Styling tambahan agar input lebih cantik */
    .form-control:focus, .form-select:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.1);
        background-color: #fff !important; /* Jadi putih saat diketik */
    }
    
    /* Style khusus untuk input token */
    #token::placeholder {
        letter-spacing: normal;
        font-weight: normal;
        font-size: 0.9rem;
    }
    .bg-light-subtle { background-color: #f8f9fa !important; }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // 1. Setup DataTable
    $('#tabelAktivitas').DataTable({
        language: { search: "Cari:", lengthMenu: "Lihat _MENU_", info: "Total _TOTAL_ aktivitas" },
        responsive: true
    });

    // 2. Tombol Tambah
    $('#btnTambah').click(function() {
        $('#formAktivitas')[0].reset();
        $('#id').val('');
        $('#_method').val('POST');
        $('#modalTitle').text('Buat Aktivitas Baru');
        $('#status').prop('checked', true); // Default aktif
        $('#modalForm').modal('show');
    });

    // 3. Tombol Edit (Load Data)
    $(document).on('click', '.btn-edit', function() {
        let id = $(this).data('id');
        let url = `/guru/aktivitas/${id}/edit`;

        Swal.fire({ title: 'Memuat...', didOpen: () => Swal.showLoading() });

        $.get(url, function(res) {
            Swal.close();
            if(res.success) {
                let d = res.data;
                $('#id').val(d.id);
                $('#judul').val(d.judul);
                $('#kategori').val(d.kategori);
                $('#tipe').val(d.tipe);
                $('#poin_didapat').val(d.poin_didapat);
                $('#paket_soal_id').val(d.paket_soal_id);
                
                // Format tanggal untuk input datetime-local (YYYY-MM-DDTHH:mm)
                if(d.waktu_mulai) $('#waktu_mulai').val(d.waktu_mulai.replace(' ', 'T').slice(0, 16));
                if(d.waktu_selesai) $('#waktu_selesai').val(d.waktu_selesai.replace(' ', 'T').slice(0, 16));
                
                $('#durasi_menit').val(d.durasi_menit);
                $('#token').val(d.token);
                $('#instruksi').val(d.instruksi);
                $('#status').prop('checked', d.status == 1);

                $('#_method').val('PUT');
                $('#modalTitle').text('Edit Aktivitas');
                $('#modalForm').modal('show');
            }
        }).fail(function() {
            Swal.close();
            Swal.fire('Error', 'Gagal memuat data', 'error');
        });
    });

    // 4. Submit Form
    $('#formAktivitas').on('submit', function(e) {
        e.preventDefault();
        let id = $('#id').val();
        let method = $('#_method').val(); // POST atau PUT
        let url = (method === 'POST') ? '/guru/aktivitas' : `/guru/aktivitas/${id}`;
        
        let formData = $(this).serialize();

        Swal.fire({ title: 'Menyimpan...', didOpen: () => Swal.showLoading() });

        $.ajax({
            url: url,
            type: 'POST', // Browser form submit selalu POST
            data: formData,
            success: function(res) {
                if(res.success) {
                    $('#modalForm').modal('hide');
                    Swal.fire({
                        icon: 'success', 
                        title: 'Berhasil', 
                        text: res.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => location.reload());
                }
            },
            error: function(xhr) {
                let msg = 'Gagal menyimpan data';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire('Gagal', msg, 'error');
            }
        });
    });

    // 5. Hapus Data
    $(document).on('click', '.btn-hapus', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Hapus Aktivitas?',
            text: "Data ini akan dihapus secara permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/guru/aktivitas/${id}`,
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(res) {
                        Swal.fire('Terhapus!', res.message, 'success').then(() => location.reload());
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal menghapus data', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush