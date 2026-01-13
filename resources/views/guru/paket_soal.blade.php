@extends('layouts.guru')

@section('title', 'Kelola Paket Soal | PythaLearn')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold text">Kelola Paket Soal</h4>
        <button class="btn btn-primary" id="btnTambahPaket">
            <i class="bi bi-plus-lg me-1"></i> Tambah Paket
        </button>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tabelPaket">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Judul Paket</th>
                            <th>Tipe</th>
                            <th>Jumlah Butir Soal</th>
                            <th>Deskripsi</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($paketSoal as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $item->judul }}</td>
                                <td>
                                    @if($item->tipe == 'kuis')
                                        <span class="badge bg-info">Kuis</span>
                                    @elseif($item->tipe == 'evaluasi')
                                        <span class="badge bg-warning text-dark">Evaluasi</span>
                                    @elseif($item->tipe == 'streak')
                                        <span class="badge bg-danger">Streak 🔥</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $item->butir_soal_count }}</td>
                                <td class="text-muted small">{{ Str::limit($item->deskripsi, 60) }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning btn-edit" data-id="{{ $item->id }}" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-info text-white btn-lihat" data-id="{{ $item->id }}" title="Lihat Soal"> <i class="bi bi-eye"></i></button>
                                    <button class="btn btn-sm btn-danger btn-hapus" 
                                        data-id="{{ $item->id }}" 
                                        data-judul="{{ $item->judul }}" 
                                        title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>   
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada paket soal.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPaket" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered"> <div class="modal-content border-0 shadow-lg rounded-4"> <div class="modal-header bg-success text-white rounded-top-4 px-4 py-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-box-seam me-2 fs-4"></i> <h5 class="modal-title fw-bold" id="modalTitle">Tambah Paket Soal</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <form id="formPaket">
                    @csrf
                    <input type="hidden" id="paket_id" name="id">
                    <input type="hidden" id="_method" name="_method" value="POST">
                    
                    <div class="modal-body p-4"> <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary small text-uppercase">
                                <i class="me-1"></i> Judul Paket
                            </label>
                            <input type="text" class="form-control form-control-lg bg-light-subtle" 
                                name="judul" id="judul" required 
                                placeholder="Contoh: Kuis 1 Teorema Pythagoras">
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary small text-uppercase">
                                <i class="me-1"></i> Tipe Soal
                            </label>
                            <select class="form-select form-select-lg bg-light-subtle" name="tipe" id="tipe" required>
                                <option value="">-- Pilih Tipe --</option>
                                <option value="kuis">Kuis (Latihan)</option>
                                <option value="evaluasi">Evaluasi (Ujian)</option>
                                <option value="streak">Streak (Tantangan)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary small text-uppercase">
                                <i class="me-1"></i> Deskripsi
                            </label>
                            <textarea class="form-control bg-light-subtle" 
                                name="deskripsi" id="deskripsi" rows="4" required 
                                placeholder="Tuliskan petunjuk pengerjaan untuk siswa..."></textarea>
                        </div>
                    </div>
                    
                    <div class="modal-footer border-top-0 px-4 pb-4">
                        <button type="button" class="btn btn-light btn-lg rounded-3 px-4" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-success btn-lg rounded-3 px-4 shadow-sm">
                            <i class="me-1"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade mt-5" id="modalLihatSoal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                
                <div class="modal-header bg-success text-white px-4 py-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-file-text fs-4"></i>
                        <div>
                            <h5 class="modal-title fw-bold mb-0">Preview Soal</h5>
                            <small class="text-white-50" id="viewJudulPaket">Memuat...</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body bg-light p-4">
                    <div id="containerSoal" class="vstack gap-4">
                        <div class="text-center py-5">
                            <div class="spinner-border text-success" role="status"></div>
                            <p class="mt-2 text-muted fw-semibold">Sedang mengambil data soal...</p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-white px-4 py-3">
                    <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    
    // 1. Setup DataTable
    $('#tabelPaket').DataTable({
        language: { search: "Cari:", lengthMenu: "Tampilkan _MENU_", info: "Total _TOTAL_ data" },
        responsive: true
    });

    // 2. Buka Modal Tambah
    $('#btnTambahPaket').click(function() {
        $('#formPaket')[0].reset();
        $('#paket_id').val('');
        $('#_method').val('POST'); // Method POST untuk create
        $('#modalTitle').text('Tambah Paket Soal');
        $('#modalPaket').modal('show');
    });

    // 3. Buka Modal Edit (Ambil Data JSON)
    $(document).on('click', '.btn-edit', function() {
        let id = $(this).data('id');
        let url = `/guru/paket_soal/${id}/edit`;

        Swal.fire({ title: 'Memuat...', didOpen: () => Swal.showLoading() });

        $.get(url, function(res) {
            Swal.close();
            if(res.success) {
                $('#paket_id').val(res.data.id);
                $('#judul').val(res.data.judul);
                $('#tipe').val(res.data.tipe);
                $('#deskripsi').val(res.data.deskripsi);
                
                $('#_method').val('PUT'); // Ubah method jadi PUT
                $('#modalTitle').text('Edit Paket Soal');
                $('#modalPaket').modal('show');
            }
        });
    });

    // 4. Submit Form (Create & Update)
    $('#formPaket').on('submit', function(e) {
        e.preventDefault();
        
        let id = $('#paket_id').val();
        let method = $('#_method').val();
        let url = method === 'POST' ? '/guru/paket_soal' : `/guru/paket_soal/${id}`;
        
        let formData = $(this).serialize();

        Swal.fire({ title: 'Menyimpan...', didOpen: () => Swal.showLoading() });

        $.ajax({
            url: url,
            type: method === 'POST' ? 'POST' : 'POST', // Ajax jQuery tetap POST, tapi kirim _method PUT
            data: formData,
            success: function(res) {
                if(res.success) {
                    $('#modalPaket').modal('hide');
                    Swal.fire('Berhasil', res.message, 'success').then(() => location.reload());
                }
            },
            error: function(xhr) {
                Swal.fire('Error', 'Gagal menyimpan data', 'error');
            }
        });
    });

    // 5. Hapus Paket
    $(document).on('click', '.btn-hapus', function() {
        let id = $(this).data('id');
        let judul = $(this).data('judul');
        
        Swal.fire({
            title: 'Hapus Paket?',
            text: `Paket "${judul}" akan dihapus permanen!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/guru/paket_soal/${id}`,
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(res) {
                        Swal.fire('Terhapus!', res.message, 'success').then(() => location.reload());
                    },
                    error: function() {
                        Swal.fire('Gagal', 'Terjadi kesalahan saat menghapus', 'error');
                    }
                });
            }
        });
    });
});

$(document).ready(function() {
    
    // KETIKA TOMBOL LIHAT DIKLIK
    $(document).on('click', '.btn-lihat', function() {
        let id = $(this).data('id');
        
        // 1. Reset Modal & Tampilkan Loading
        $('#modalLihatSoal').modal('show');
        $('#viewJudulPaket').text('Loading...');
        $('#containerSoal').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-success"></div>
                <p class="mt-2 text-muted">Mengambil data...</p>
            </div>
        `);

        // 2. Request Data ke Server
        $.get(`/guru/paket_soal/${id}/json`, function(response) {

            
            if(!response.success) {
                $('#containerSoal').html('<div class="alert alert-danger">Gagal memuat data.</div>');
                return;
            }

            let paket = response.data;
            let soalList = paket.butir_soal;

            $('#viewJudulPaket').text(paket.judul); // Set Judul di Header

            // 3. Cek jika soal kosong
            if (!soalList || soalList.length === 0) {
                $('#containerSoal').html(`
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-clipboard-x display-1 opacity-25"></i>
                        <h5 class="mt-3">Belum ada soal</h5>
                        <p>Silakan tambahkan soal melalui menu "Kelola Soal".</p>
                    </div>
                `);
                return;
            }

            // 4. Render Soal ke HTML
            let htmlContent = '';
            
            soalList.forEach((item, index) => {
                // Parsing Opsi Jawaban (Safety Check)
                let options = item.opsi_jawaban;
                if (typeof options === 'string') {
                    try { options = JSON.parse(options); } catch (e) { options = {}; }
                }

                // Render Pilihan Ganda (Grid 2 Kolom)
                let opsiHtml = '<div class="row g-3 mt-2">';
                
                for (const [key, val] of Object.entries(options)) {

                    // ⬇️ NORMALISASI OPSI
                    let text = '';
                    let image = null;

                    if (typeof val === 'object' && val !== null) {
                        text = val.text ?? '';
                        image = val.image ?? null;
                    } else {
                        text = val;
                    }

                    let isKunci = (key == item.kunci_jawaban);

                    let cardClass = isKunci 
                        ? 'bg-success-subtle border-success text-success-emphasis' 
                        : 'bg-white border-secondary-subtle text-secondary';

                    let icon = isKunci 
                        ? '<i class="bi bi-check-circle-fill fs-5 text-success"></i>' 
                        : '<i class="bi bi-circle text-muted"></i>';

                    let imageHtml = '';
                    if (image) {
                        imageHtml = `
                            <div class="mt-2">
                                <img src="${image}" 
                                    class="img-fluid rounded border"
                                    style="max-height:120px; object-fit:contain">
                            </div>
                        `;
                    }

                    opsiHtml += `
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3 p-3 border rounded-3 h-100 ${cardClass}">
                                <div class="flex-shrink-0 fw-bold fs-5" style="width:25px">${key}</div>
                                <div class="flex-grow-1 small lh-sm">
                                    <div>${text}</div>
                                    ${imageHtml}
                                </div>
                                <div class="flex-shrink-0">${icon}</div>
                            </div>
                        </div>`;
                }

                opsiHtml += '</div>';

                // Tambahkan Pertanyaan (Ada Gambar?)
                let gambarHtml = '';

                if (item.gambar) {
                    gambarHtml = `
                        <div class="mb-3">
                            <img src="${item.gambar}" 
                                class="img-fluid rounded-3 border"
                                style="max-height:220px; object-fit:contain"
                                alt="Gambar soal">
                        </div>
                    `;
                }


                // Susun Kartu Soal Utama
                htmlContent += `
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-success rounded-pill px-3 py-2">No. ${index + 1}</span>
                                </div>
                                <div class="flex-grow-1">
                                    ${gambarHtml}
                                    <h6 class="fw-bold text-dark lh-base mb-0" style="font-size:1.05rem">
                                        ${item.pertanyaan || '(Tidak ada teks soal)'}
                                    </h6>

                                </div>
                            </div>
                            <hr class="border-secondary opacity-10 my-3">
                            ${opsiHtml}
                        </div>
                    </div>
                `;
            });

            $('#containerSoal').html(htmlContent);

        }).fail(function(xhr) {

            let msg = 'Terjadi kesalahan pada server.';

            if (xhr.status === 404) msg = 'Data paket soal tidak ditemukan.';
            if (xhr.status === 403) msg = 'Anda tidak memiliki akses.';
            if (xhr.status === 500) msg = 'Terjadi kesalahan internal server.';

            $('#containerSoal').html(`
                <div class="alert alert-danger text-center border-0 shadow-sm">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> 
                    ${msg}
                </div>
            `);
        });
    });
});
</script>
@endpush