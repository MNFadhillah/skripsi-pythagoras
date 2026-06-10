@extends('layouts.guru')

@section('title', 'Kelola Kuis & Evaluasi | PythaLearn')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">Kelola Kuis & Evaluasi</h4>

            @if($hasClass)
            <button type="button" class="btn btn-success" id="btnTambah" data-bs-toggle="modal" data-bs-target="#modalForm">
                <i class="bi bi-plus-lg me-1"></i> Tambah Sesi
            </button>
            @endif
        </div>
    </div>

    @if(!$hasClass)
    <div class="card shadow-sm border-0 bg-white rounded-3 mt-4">
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle" style="width: 100px; height: 100px;">
                    <i class="bi bi-person-workspace text-muted" style="font-size: 3rem;"></i>
                </div>
            </div>
            <h5 class="fw-bold text-dark">Akses Terbatas</h5>
            <p class="text-muted mb-0">Anda belum ditugaskan untuk mengampu kelas manapun.<br>Fitur pembuatan sesi kuis dan evaluasi akan terbuka setelah Administrator menautkan akun Anda dengan sebuah kelas.</p>
        </div>
    </div>

    @else

    <div class="card shadow-sm border-1 rounded">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="tabelAktivitas">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Kuis / Evaluasi</th>
                            <th class="text-center">Kategori Sub-Materi</th>
                            <th class="text-center">Tipe</th>
                            <th class="text-center" width="8%">KKM</th>
                            <th class="text-center">Jadwal & Token</th>
                            <th class="text-center">Status Akses</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($aktivitas as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->judul }}</div>
                                <div class="small text-muted">Paket Soal: {{ $item->paket_soal->judul ?? 'Paket Tidak Ditemukan' }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border border-secondary">
                                    {{ ucfirst($item->kategori) }}
                                </span>
                            </td>
                            <td>
                                @if($item->tipe == 'evaluasi')
                                <span class="badge bg-warning text-dark mb-1">Evaluasi</span>
                                @else
                                <span class="badge bg-info mb-1">Kuis</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-success">{{ $item->kkm ?? '70' }}</span>
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
                                @php
                                $now = now();
                                $isTimeValid = $item->waktu_mulai && $item->waktu_selesai && $now->between($item->waktu_mulai, $item->waktu_selesai);
                                $isRealActive = $item->status == 1 && $isTimeValid;
                                $isExpired = $item->waktu_selesai && \Carbon\Carbon::parse($item->waktu_selesai)->isPast();
                                @endphp

                                @if($isRealActive)
                                <span class="badge bg-success rounded-pill px-3">AKTIF</span>
                                @elseif($item->status == 1 && $isExpired)
                                <span class="badge bg-danger rounded-pill px-3" title="Waktu Habis">KADALUARSA</span>
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
    @endif
</div>

{{-- Modal Form --}}
<div class="modal fade" id="modalForm" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg rounded overflow-hidden">
            <div class="modal-header bg-success text-white px-4 py-3">
                <h5 class="modal-title fw-bold mb-0" id="modalTitle">Buat Sesi Evaluasi / Kuis</h5>
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

                            <div class="mb-2">
                                <label class="form-label fw-semibold small text-secondary">Judul Sesi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-light border-0 py-2" name="judul" id="judul" required placeholder="Contoh: Kuis Pertemuan 1 - Konsep Pythagoras">
                            </div>

                            <div class="mb-2">
                                <label class="form-label fw-semibold small text-secondary">Kelas <span class="text-danger">*</span></label>
                                <select class="form-select bg-light border-0 py-2" name="kelas_id" id="kelas_id" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach($listKelas as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="form-label fw-semibold small text-secondary">Posisi Penempatan Menu <span class="text-danger">*</span></label>
                                <select class="form-select bg-light border-0 py-2" name="kategori" id="kategori" required>
                                    <option value="">-- Pilih Target Menu Siswa --</option>
                                    <option value="konsep">1. Menemukan Konsep Pythagoras</option>
                                    <option value="tripel">2. Tripel Pythagoras</option>
                                    <option value="istimewa">3. Segitiga Istimewa</option>
                                    <option value="penerapan">4. Penerapan Teorema</option>
                                    <option value="evaluasi">Evaluasi Akhir</option>
                                </select>
                                <div class="form-text small">Menentukan di sub-menu mana kuis/evaluasi ini akan muncul pada sidebar siswa.</div>
                            </div>

                            <div class="row g-3 mb-2">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small text-secondary">Tipe Evaluasi</label>
                                    <select class="form-select bg-light border-0 py-2" name="tipe" id="tipe" required>
                                        <option value="kuis">Kuis</option>
                                        <option value="evaluasi">Evaluasi</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small text-secondary">Poin Hadiah Gamifikasi</label>
                                    <input type="number" class="form-control bg-light border-0 py-2" name="poin_didapat" id="poin_didapat" value="100" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small text-secondary">KKM <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control bg-light border-0 py-2" name="kkm" id="kkm" value="70" min="0" max="100" required placeholder="Contoh: 70">
                                </div>
                            </div>

                            <div class="mb-2">
                                <label class="form-label fw-semibold small text-secondary">Hubungkan Paket Soal</label>
                                <select class="form-select bg-light border-0 py-2" name="paket_soal_id" id="paket_soal_id">
                                    <option value="">-- Pilih Paket Soal --</option>
                                    @foreach($listPaket as $paket)
                                    <option value="{{ $paket->id }}">{{ $paket->judul }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="form-label fw-semibold small text-secondary">Instruksi Pengerjaan</label>
                                <textarea class="form-control bg-light border-0" name="instruksi" id="instruksi" rows="3" placeholder="Tulis petunjuk pengerjaan untuk siswa..."></textarea>
                            </div>
                        </div>

                        <div class="col-lg-5 p-4 bg-light bg-opacity-25">
                            <h6 class="text-success fw-bold mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-calendar-check"></i> Aturan Kelola Akses
                            </h6>

                            <div class="mb-2">
                                <label class="form-label fw-semibold small text-secondary">Waktu Akses Dibuka</label>
                                <input type="datetime-local" class="form-control bg-white border shadow-sm" name="waktu_mulai" id="waktu_mulai">
                            </div>

                            <div class="mb-2">
                                <label class="form-label fw-semibold small text-secondary">Waktu Akses Ditutup</label>
                                <input type="datetime-local" class="form-control bg-white border shadow-sm" name="waktu_selesai" id="waktu_selesai">
                            </div>

                            <hr class="border-secondary opacity-25 my-4">

                            <div class="mb-2">
                                <label class="form-label fw-semibold small text-secondary">Durasi Sesi</label>
                                <div class="input-group shadow-sm">
                                    <input type="number" class="form-control border-end-0" name="durasi_menit" id="durasi_menit" value="60">
                                    <span class="input-group-text bg-white text-muted">Menit</span>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label class="form-label fw-semibold small text-secondary">Token Ujian</label>
                                <input type="text" class="form-control bg-white text-uppercase shadow-sm fw-bold" name="token" id="token" placeholder="-----" maxlength="6" style="letter-spacing: 3px; text-align: center;">
                            </div>

                            <div class="card border-0 mb-3 shadow-sm bg-white">
                                <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                                    <label class="form-check-label small fw-bold text-dark" for="status">
                                        Buka Akses Sekarang?
                                    </label>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" name="status" id="status" value="1" checked style="transform: scale(1.3);">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-2">
                                <button type="submit" class="btn btn-success rounded-3 px-5 shadow fw-bold w-100">
                                    <i class="bi bi-save me-1"></i> Simpan Sesi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-control:focus, .form-select:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.1);
        background-color: #fff !important;
    }
    #token::placeholder {
        letter-spacing: normal;
        font-weight: normal;
        font-size: 0.9rem;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Init DataTable
        $('#tabelAktivitas').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Lihat _MENU_",
                info: "Total _TOTAL_ sesi"
            },
            responsive: true
        });

        // Trigger otomatis dari halaman lain jika ada parameter URL
        const urlParams = new URLSearchParams(window.location.search);
        const triggerKelasId = urlParams.get('trigger_kelas_id');

        if (triggerKelasId) {
            $('#formAktivitas')[0].reset();
            $('#id').val('');
            $('#_method').val('POST');
            $('#modalTitle').text('Buat Sesi Baru');
            $('#status').prop('checked', true);
            $('#kelas_id').val(triggerKelasId);
            $('#modalForm').modal('show');
        }

        // Tombol Tambah Sesi
        $('#btnTambah').click(function() {
            $('#formAktivitas')[0].reset();
            $('#id').val('');
            $('#_method').val('POST');
            $('#modalTitle').text('Buat Sesi Baru');
            $('#status').prop('checked', true);
            $('#modalForm').modal('show');
        });

        // Tombol Edit Sesi
        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            let url = `/guru/kuis-evaluasi/${id}/edit`;

            Swal.fire({
                title: 'Memuat...',
                didOpen: () => Swal.showLoading()
            });

            $.get(url, function(res) {
                Swal.close();
                if (res.success) {
                    let d = res.data;
                    $('#id').val(d.id);
                    $('#judul').val(d.judul);
                    $('#kelas_id').val(d.kelas_id);
                    $('#kategori').val(d.kategori);
                    $('#tipe').val(d.tipe);
                    $('#poin_didapat').val(d.poin_didapat);
                    $('#paket_soal_id').val(d.paket_soal_id);
                    $('#kkm').val(d.kkm ?? 75); // Sinkronisasi KKM

                    if (d.waktu_mulai) $('#waktu_mulai').val(d.waktu_mulai.replace(' ', 'T').slice(0, 16));
                    if (d.waktu_selesai) $('#waktu_selesai').val(d.waktu_selesai.replace(' ', 'T').slice(0, 16));

                    $('#durasi_menit').val(d.durasi_menit);
                    $('#token').val(d.token);
                    $('#instruksi').val(d.instruksi);
                    $('#status').prop('checked', d.is_currently_active === true);

                    $('#_method').val('PUT');
                    $('#modalTitle').text('Edit Sesi');
                    $('#modalForm').modal('show');
                }
            }).fail(function() {
                Swal.close();
                Swal.fire('Error', 'Gagal memuat data', 'error');
            });
        });

        // Submit Form Sesi
        $('#formAktivitas').on('submit', function(e) {
            e.preventDefault();
            let id = $('#id').val();
            let method = $('#_method').val();
            let url = (method === 'POST') ? '/guru/kuis-evaluasi' : `/guru/kuis-evaluasi/${id}`;
            let formData = $(this).serialize();

            Swal.fire({
                title: 'Menyimpan...',
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(res) {
                    if (res.success) {
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
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    Swal.fire('Gagal', msg, 'error');
                }
            });
        });

        // Hapus Sesi
        $(document).on('click', '.btn-hapus', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Hapus Sesi?',
                text: "Data evaluasi ini akan dihapus secara permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Ya, Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/guru/kuis-evaluasi/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
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

        // Auto-Update Logika Waktu
        $('#status').change(function() {
            if ($(this).is(':checked')) {
                let durasi = parseInt($('#durasi_menit').val()) || 60;
                let now = new Date();
                now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                $('#waktu_mulai').val(now.toISOString().slice(0, 16));

                let selesai = new Date(now.getTime() + durasi * 60000);
                $('#waktu_selesai').val(selesai.toISOString().slice(0, 16));
            }
        });

        $('#durasi_menit').on('input', function() {
            let mulai = $('#waktu_mulai').val();
            if (mulai && $('#status').is(':checked')) {
                let durasi = parseInt($(this).val()) || 0;
                let start = new Date(mulai);
                let selesai = new Date(start.getTime() + durasi * 60000);
                selesai.setMinutes(selesai.getMinutes() - selesai.getTimezoneOffset());
                $('#waktu_selesai').val(selesai.toISOString().slice(0, 16));
            }
        });
    });
</script>
@endpush