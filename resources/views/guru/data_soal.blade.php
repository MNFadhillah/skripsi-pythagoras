@extends('layouts.guru')

@section('title', 'Data Soal | PythaLearn')

@section('content')
<div class="container-fluid">

    {{-- HEADER & FILTER --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                {{-- Judul --}}
                <div class="col-md-6">
                    <h4 class="mb-0 fw-bold">Data Soal</h4>
                </div>

                {{-- Filter & Tombol Aksi --}}
                <div class="col-md-6 d-flex justify-content-md-end gap-2 mt-3 mt-md-0">
                    
                    {{-- Filter Paket Soal --}}
                    <form action="{{ url()->current() }}" method="GET" class="d-flex gap-2">
                        <select name="paket_soal_id" class="form-select shadow-sm border-secondary-subtle" style="width: 300px;" onchange="this.form.submit()">
                            <option value="">-- Semua Paket --</option>
                            @foreach ($paketSoal as $paket)
                                <option value="{{ $paket->id }}" {{ request('paket_soal_id') == $paket->id ? 'selected' : '' }}>
                                    {{ $paket->judul }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    {{-- BUTTON GROUP --}}
                    <div class="d-flex gap-2">
                        {{-- Tombol Import --}}
                        <button class="btn btn-success text-nowrap shadow-sm" data-bs-toggle="modal" data-bs-target="#modalImportExcel">
                            <i class="bi bi-file-earmark-excel me-1"></i> Import
                        </button>
                        {{-- Tombol Tambah --}}
                        <button class="btn btn-primary text-nowrap shadow-sm" id="btnTambahSoal">
                            <i class="bi bi-plus-lg me-1"></i> Tambah
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FORM TAMBAH SOAL --}}
    <div class="card shadow-sm mb-4 d-none" id="formTambahSoal">
        <div class="card-header bg-light fw-semibold">
            <i class="bi bi-pencil-square me-1"></i> Tambah Soal Baru
        </div>

        <div class="card-body">
            <form id="formSoalBaru" method="POST" action="{{ route('guru.data_soal.store') }}" 
                enctype="multipart/form-data">
                @csrf

                {{-- PILIH TIPE SOAL --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Tipe Soal</label>
                    <select class="form-select" id="tipe_soal_tambah" name="tipe_soal" required >
                        <option value="pg">Pilihan Ganda</option>
                        <option value="isian">Isian Singkat</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Paket Soal</label>
                    <select name="paket_soal_id" class="form-select" required>
                        <option value="">-- Pilih Paket Soal --</option>
                        @foreach ($paketSoal as $paket)
                            <option value="{{ $paket->id }}">
                                {{ $paket->judul }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Pertanyaan</label>
                    <textarea name="pertanyaan" class="form-control" rows="4"placeholder="Tuliskan pertanyaan..." required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar Soal (opsional)</label>
                    <input type="file" name="gambar" id="gambar_soal" class="form-control" accept="image/*">
                    <small class="text-muted">jpg, png, webp (maks 2MB). Jika soal tidak mempunyai gambar kosongkan saja.</small>
                    <div id="preview_gambar" class="mt-2"></div>
                </div>

                {{-- WRAPPER OPSI (Hanya Muncul di PG) --}}
                <div id="wrapper_opsi_tambah">
                    <div class="row">
                        @foreach (['A','B','C','D'] as $opsi)
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Opsi {{ $opsi }}</label>
                                <input type="text" name="opsi[{{ $opsi }}][text]" class="form-control input-opsi-tambah" required>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kunci Jawaban</label>
                    
                    {{-- Input Kunci PG (Dropdown) --}}
                    <select name="kunci_jawaban_pg" id="kunci_pg_tambah" class="form-select">
                        <option value="">-- Pilih Kunci (A/B/C/D) --</option>
                        <option>A</option>
                        <option>B</option>
                        <option>C</option>
                        <option>D</option>
                    </select>

                    {{-- Input Kunci Isian (Text) --}}
                    <input type="text" name="kunci_jawaban_isian" id="kunci_isian_tambah" 
                        class="form-control d-none" 
                        placeholder="Tulis jawaban benarnya di sini (misal: 10 cm)" disabled>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> Simpan Soal
                    </button>
                    <button type="button" class="btn btn-secondary" id="btnBatalTambah">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- === MODAL IMPORT EXCEL === --}}
    <div class="modal fade" id="modalImportExcel" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-file-earmark-spreadsheet me-2"></i>Import Soal dari Excel</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formImportExcel" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info small">
                            <i class="bi bi-info-circle me-1"></i> Pastikan format Excel sesuai template.
                            <a href="{{ route('guru.data_soal.template') }}" class="fw-bold text-decoration-underline">Download Template Disini</a>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Paket Soal Tujuan</label>
                            <select name="paket_soal_id_import" class="form-select" required>
                                <option value="">-- Pilih Paket --</option>
                                @foreach ($paketSoal as $paket)
                                    <option value="{{ $paket->id }}">{{ $paket->judul }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Upload File Excel</label>
                            <input type="file" name="file_excel" class="form-control" accept=".xlsx, .xls, .csv" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Import Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- === MODAL EDIT SOAL === --}}
    <div class="modal fade" id="editSoalModal" tabindex="-1" aria-labelledby="editSoalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-success text-white fw-bold">
                    <h5 class="modal-title" id="editSoalModalLabel">Edit Soal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editSoalForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit_soal_id" name="id">
                        
                        {{-- TIPE SOAL EDIT --}}
                        <div class="mb-1">
                            <label class="form-label fw-bold">Tipe Soal</label>
                            <select class="form-select" id="edit_tipe_soal" name="tipe_soal" required>
                                <option value="pg">Pilihan Ganda</option>
                                <option value="isian">Isian Singkat</option>
                            </select>
                        </div>

                        <div class="mb-1">
                            <label for="edit_paket_soal_id" class="form-label">Paket Soal</label>
                            <select class="form-control" id="edit_paket_soal_id" name="paket_soal_id" required>
                                <option value="">Pilih Paket Soal</option>
                                @foreach($paketSoal as $paket)
                                    <option value="{{ $paket->id }}">{{ $paket->judul }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-1">
                            <label for="edit_pertanyaan_text" class="form-label">Pertanyaan</label>
                            <textarea class="form-control" id="edit_pertanyaan_text" name="pertanyaan_text" rows="3" required></textarea>
                        </div>
                        
                        <div class="mb-1">
                            <label class="form-label">Gambar Soal (Opsional)</label>
                            <div id="edit_gambar_preview" class="mb-2"></div>
                            <input type="file" class="form-control" id="edit_gambar" name="gambar" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar</small>
                        </div>

                        {{-- WRAPPER OPSI EDIT --}}
                        <div id="wrapper_opsi_edit">
                            <div class="row">
                                @foreach (['A','B','C','D'] as $opsi)
                                    <div class="col-md-6 mb-1">
                                        <label class="form-label">Opsi {{ $opsi }}</label>
                                        <input type="text" id="edit_opsi_{{ $opsi }}" name="opsi[{{ $opsi }}][text]" class="form-control input-opsi-edit">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-1">
                            <label class="form-label">Kunci Jawaban</label>
                            
                            {{-- Kunci PG --}}
                            <select name="kunci_jawaban_pg" id="edit_kunci_pg" class="form-select">
                                <option value="">-- Pilih Kunci (A/B/C/D) --</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>

                            {{-- Kunci Isian --}}
                            <input type="text" name="kunci_jawaban_isian" id="edit_kunci_isian" 
                                class="form-control d-none" 
                                placeholder="Tulis jawaban benarnya di sini" disabled>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- TABEL DATA SOAL --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="tabelSoal">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th class="text-center">Pertanyaan</th>
                            <th width="10%" class="text-center">Jenis</th>
                            <th width="10%" class="text-center">Gambar</th> 
                            <th width="20%">Paket Soal</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($soal as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                
                                {{-- KOLOM PERTANYAAN (TEXT SAJA) --}}
                                <td>
                                    @php
                                        $pertanyaanText = '';
                                        $hasImage = false; // Flag untuk cek gambar

                                        // LOGIKA CEK GAMBAR & BERSIHKAN TEKS
                                        if (is_array($item->pertanyaan)) {
                                            $pertanyaanText = $item->pertanyaan['text'] ?? '';
                                            if (!empty($item->pertanyaan['image']) || !empty($item->pertanyaan['gambar'])) {
                                                $hasImage = true;
                                            }
                                        } 
                                        elseif (is_string($item->pertanyaan)) {
                                            if (str_contains($item->pertanyaan, '[GAMBAR:') || preg_match('/\/storage\/soal\/[^\s"]+\./', $item->pertanyaan)) {
                                                $hasImage = true;
                                            }
                                            
                                            // Bersihkan teks untuk display
                                            if (str_contains($item->pertanyaan, '[GAMBAR:')) {
                                                $pertanyaanText = preg_replace('/\[GAMBAR:.*?\]/', '', $item->pertanyaan);
                                            } else {
                                                $pertanyaanText = preg_replace('/\/storage\/[^\s]+(\.(jpg|jpeg|png|gif|webp))/i', '', $item->pertanyaan);
                                            }
                                        }
                                        $pertanyaanText = preg_replace('/https?:\/\/[^\s]+/', '', $pertanyaanText);
                                    @endphp

                                    {{ \Illuminate\Support\Str::limit(trim($pertanyaanText), 80) }}
                
                                </td>

                                {{-- KOLOM JENIS SOAL --}}
                                <td class="text-center">
                                    @php
                                        $isIsian = empty($item->opsi_jawaban);
                                    @endphp

                                    @if($isIsian)
                                        <span>Isian</span>
                                    @else
                                        <span>Pilihan Ganda</span>
                                    @endif
                                </td>

                                {{-- KOLOM BARU: STATUS GAMBAR --}}
                                <td class="text-center">
                                    @if($hasImage)
                                        <span>Ada</span>
                                    @else
                                        <span>Tidak Ada</span>
                                    @endif
                                </td>



                                <td>{{ $item->paketSoal->judul ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-info btn-view-soal" data-id="{{ $item->id }}" title="Lihat Detail"><i class="bi bi-eye"></i></button>
                                        <button type="button" class="btn btn-warning btn-edit-soal" data-id="{{ $item->id }}" title="Edit Soal"><i class="bi bi-pencil"></i></button>
                                        <button type="button" class="btn btn-danger btn-hapus-soal" data-id="{{ $item->id }}" data-judul="{{ Str::limit(trim($pertanyaanText), 50) }}" title="Hapus Soal"><i class="bi bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL VIEW DETAIL --}}
    <div class="modal fade" id="modalViewSoal" tabindex="-1" aria-labelledby="modalViewSoalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold" id="modalViewSoalLabel">
                        <i class="bi bi-card-text me-2"></i>Detail Soal
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light" id="detailSoalContent"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // 1. Inisialisasi DataTable
    try {
        $('#tabelSoal').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ soal",
                emptyTable: "Belum ada data soal.",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                }
            },
            pageLength: 10,
            responsive: true,
            autoWidth: false,
            columnDefs: [
                { orderable: false, targets: [3, 5] }
            ]
        });


    } catch (error) { console.error('Error DataTables:', error); }

    // ==========================================
    // LOGIKA UI TIPE SOAL (TAMBAH)
    // ==========================================
    $('#tipe_soal_tambah').on('change', function() {
        if($(this).val() == 'isian') {
            // Mode Isian
            $('#wrapper_opsi_tambah').slideUp(); 
            $('.input-opsi-tambah').prop('required', false); // Matikan required opsi
            
            // Switch Kunci Jawaban
            $('#kunci_pg_tambah').addClass('d-none').prop('disabled', true);
            $('#kunci_isian_tambah').removeClass('d-none').prop('disabled', false);

        } else {
            // Mode PG
            $('#wrapper_opsi_tambah').slideDown();
            $('.input-opsi-tambah').prop('required', true); // Nyalakan required opsi
            
            // Switch Kunci Jawaban
            $('#kunci_pg_tambah').removeClass('d-none').prop('disabled', false);
            $('#kunci_isian_tambah').addClass('d-none').prop('disabled', true);
        }
    });

    // ==========================================
    // LOGIKA UI TIPE SOAL (EDIT)
    // ==========================================
    $('#edit_tipe_soal').on('change', function() {
        if($(this).val() == 'isian') {
            // Mode Isian
            $('#wrapper_opsi_edit').slideUp(); 
            $('.input-opsi-edit').prop('required', false);
            
            $('#edit_kunci_pg').addClass('d-none').prop('disabled', true);
            $('#edit_kunci_isian').removeClass('d-none').prop('disabled', false);
        } else {
            // Mode PG
            $('#wrapper_opsi_edit').slideDown();
            $('.input-opsi-edit').prop('required', true);
            
            $('#edit_kunci_pg').removeClass('d-none').prop('disabled', false);
            $('#edit_kunci_isian').addClass('d-none').prop('disabled', true);
        }
    });

    // Toggle Form Tambah
    $('#btnTambahSoal').on('click', function () {
        const form = $('#formTambahSoal');
        if (form.hasClass('d-none')) {
            form.hide().removeClass('d-none').slideDown(300);
            $('html, body').animate({ scrollTop: form.offset().top - 100 }, 300);
        } else {
            form.slideUp(300, function () { form.addClass('d-none'); });
        }
    });

    $('#btnBatalTambah').on('click', function() {
        $('#formTambahSoal').slideUp(300, function() { $(this).addClass('d-none'); });
    });

    // Preview Gambar Tambah
    document.getElementById('gambar_soal').addEventListener('change', function(e) {
        const preview = document.getElementById('preview_gambar');
        preview.innerHTML = '';
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '200px'; img.style.maxHeight = '150px'; img.className = 'img-thumbnail';
                preview.appendChild(img);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // SUBMIT TAMBAH
    $('#formSoalBaru').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        Swal.fire({ title: 'Menyimpan Soal', text: 'Mohon tunggu...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false, processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, confirmButtonColor: '#0b5e3f' }).then(() => { location.reload(); });
            },
            error: function (xhr) {
                let msg = 'Terjadi kesalahan';
                if (xhr.responseJSON?.errors) msg = Object.values(xhr.responseJSON.errors).map(v => v[0]).join('<br>');
                Swal.fire({ icon: 'error', title: 'Gagal', html: msg, confirmButtonColor: '#dc3545' });
            }
        });
    });

    // HAPUS SOAL
    $(document).on('click', '.btn-hapus-soal', function () {
        const id = $(this).data('id');
        const judul = $(this).data('judul');
        Swal.fire({
            title: 'Hapus Soal?',
            html: `<p>Yakin ingin menghapus soal?</p><strong>"${judul}"</strong>`,
            icon: 'warning',
            showCancelButton: true, confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal',
            confirmButtonColor: '#dc3545', cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'Menghapus...', didOpen: () => Swal.showLoading() });
                $.ajax({
                    url: `/guru/data_soal/${id}`, type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (res) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, confirmButtonColor: '#0b5e3f' }).then(() => { location.reload(); });
                    },
                    error: function () { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal menghapus', confirmButtonColor: '#dc3545' }); }
                });
            }
        });
    });

    // Helper Extrac Image
    function extractAndDisplayImages(text) {
        let imagesHTML = '';
        let processedText = text;
        const imageRegex = /(https?:\/\/[^\s]+\.(?:jpg|jpeg|png|gif|bmp|webp|svg))(?:\s|$)/gi;
        const matches = text.match(imageRegex);
        if (matches) {
            matches.forEach(url => {
                processedText = processedText.replace(url, '').trim();
                imagesHTML += `<div class="text-center my-3"><img src="${url}" class="soal-image" style="max-height:200px; max-width:100%; object-fit:contain;" onerror="this.style.display='none'" /></div>`;
            });
        }
        return { text: processedText, images: imagesHTML };
    }

    // VIEW DETAIL SOAL
    $(document).on('click', '.btn-view-soal', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const modalBody = $('#detailSoalContent');
        const modalElement = document.getElementById('modalViewSoal');
        const viewModal = bootstrap.Modal.getOrCreateInstance(modalElement);
        
        modalBody.html(`<div class="text-center py-5"><div class="spinner-border text-success"></div><p class="mt-3 text-muted">Loading...</p></div>`);
        viewModal.show();

        $.ajax({
            url: `/guru/data_soal/${id}/json`, type: 'GET', dataType: 'json',
            success: function(data) {
                let pertanyaan = '', imagesHTML = '';
                // Handle Pertanyaan
                if (typeof data.pertanyaan === 'string') {
                    const processed = extractAndDisplayImages(data.pertanyaan);
                    pertanyaan = processed.text; imagesHTML = processed.images;
                } else if (typeof data.pertanyaan === 'object') {
                    pertanyaan = data.pertanyaan.text || '';
                    let rawImg = data.pertanyaan.image || data.pertanyaan.gambar;
                    if (rawImg) {
                        let fullImgUrl = rawImg.startsWith('http') ? rawImg : window.location.origin + (rawImg.startsWith('/') ? '' : '/') + rawImg;
                        imagesHTML = `<div class="text-center my-4"><img src="${fullImgUrl}" class="img-fluid" style="max-height: 180px;" onerror="this.style.display='none'"></div>`;
                    }
                }
                
                // Handle Opsi (Cek jika null maka Isian)
                let opsiHTML = '';
                if(!data.opsi_jawaban || Object.keys(data.opsi_jawaban).length === 0){
                     opsiHTML = `<div class="alert alert-info border-0 shadow-sm"><i class="bi bi-pencil me-2"></i>Jenis Soal: <strong>Isian Singkat</strong></div>`;
                } else {
                    opsiHTML = '<div class="opsi-container">';
                    ['A','B','C','D'].forEach(key => {
                        if (data.opsi_jawaban && data.opsi_jawaban[key]) {
                            const opsi = data.opsi_jawaban[key];
                            const isCorrect = key === data.kunci_jawaban;
                            let teks = (typeof opsi === 'object') ? opsi.text : opsi;
                            let imgOpsi = (typeof opsi === 'object' && opsi.image) ? `<div class="mt-2"><img src="${opsi.image}" style="max-height:100px"></div>` : '';
                            opsiHTML += `<div class="opsi-item bg-white ${isCorrect ? 'border-success shadow-sm' : ''}"><strong class="${isCorrect ? 'text-success' : ''}">${key}.</strong> ${teks} ${imgOpsi}</div>`;
                        }
                    });
                    opsiHTML += '</div>';
                }
                let isIsian = !data.opsi_jawaban || Object.keys(data.opsi_jawaban).length === 0;

                let secondCardTitle = isIsian ? 'Kunci Jawaban:' : 'Jawaban / Opsi:';
                let secondCardContent = isIsian 
                    ? `<div class="p-2 bg-white border rounded">${data.kunci_jawaban}</div>` 
                    : opsiHTML;

                let bottomSection = isIsian
                    ? `
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <strong>Paket: </strong>${data.paket_soal}
                            </div>
                        </div>
                    `
                    : `
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Kunci: </strong>
                                <span class="badge bg-success">${data.kunci_jawaban}</span>
                            </div>
                            <div class="col-md-6 text-end">
                                <strong>Paket: </strong>${data.paket_soal}
                            </div>
                        </div>
                    `;

                modalBody.html(`
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="text-success fw-bold">Pertanyaan:</h6>
                            <div>${pertanyaan}</div>
                            ${imagesHTML}
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="text-success fw-bold">${secondCardTitle}</h6>
                            ${secondCardContent}
                        </div>
                    </div>

                    ${bottomSection}
                `);

            },
            error: function() { modalBody.html('<div class="alert alert-danger">Gagal memuat data.</div>'); }
        });
    });

    // SUBMIT IMPORT
    $('#formImportExcel').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let modalEl = document.getElementById('modalImportExcel');
        let modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();

        Swal.fire({ 
            title: 'Sedang Memproses...', html: 'Sistem sedang membaca file Excel.<br>Mohon jangan tutup halaman ini.',
            allowOutsideClick: false, didOpen: () => Swal.showLoading() 
        });

        $.ajax({
            url: "{{ route('guru.data_soal.import') }}", type: 'POST', data: formData,
            contentType: false, processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: res.message, confirmButtonColor: '#0b5e3f', confirmButtonText: 'Oke, Refresh Halaman' })
                .then((result) => { if(result.isConfirmed){ location.reload(); } });
            },
            error: function (xhr) {
                let msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Gagal mengimpor file.';
                Swal.fire({ icon: 'error', title: 'Gagal Import', text: msg, confirmButtonColor: '#dc3545' })
                .then(() => { modal.show(); });
            }
        });
    });

    // EDIT SOAL - POPULATE DATA
    $(document).on('click', '.btn-edit-soal', function () {
        const id = $(this).data('id');
        $('#editSoalForm')[0].reset();
        $('#edit_gambar_preview').html('');
        Swal.fire({ title: 'Memuat...', didOpen: () => Swal.showLoading() });

        $.get(`/guru/data_soal/${id}/edit-json`, function (res) {
            Swal.close();
            if (!res.success) return;
            
            $('#edit_soal_id').val(res.id);
            $('#edit_paket_soal_id').val(res.paket_soal_id);
            $('#edit_pertanyaan_text').val(res.pertanyaan);
            
            // LOGIKA DETEKSI TIPE SOAL
            // Jika opsi null atau kosong, berarti Isian
            let isIsian = (res.opsi == null || Object.keys(res.opsi).length === 0);

            if(isIsian) {
                // Set Dropdown Tipe
                $('#edit_tipe_soal').val('isian').trigger('change');
                // Isi Kunci Jawaban Text
                $('#edit_kunci_isian').val(res.kunci_jawaban);
            } else {
                // Set Dropdown Tipe
                $('#edit_tipe_soal').val('pg').trigger('change');
                // Isi Kunci Jawaban Dropdown
                $('#edit_kunci_pg').val(res.kunci_jawaban);
                // Isi Opsi A-D
                ['A','B','C','D'].forEach(key => {
                    let val = (res.opsi && res.opsi[key]) ? ((typeof res.opsi[key] === 'object') ? res.opsi[key].text : res.opsi[key]) : '';
                    $(`#edit_opsi_${key}`).val(val);
                });
            }

            if (res.gambar) {
                let imgUrl = res.gambar.startsWith('http') ? res.gambar : window.location.origin + (res.gambar.startsWith('/') ? '' : '/') + res.gambar;
                $('#edit_gambar_preview').html(`<img src="${imgUrl}" style="max-height:150px" class="img-thumbnail"><div class="small text-success">Gambar Terpasang</div>`);
            } else {
                $('#edit_gambar_preview').html('<div class="small text-muted">Tidak ada gambar</div>');
            }
            
            bootstrap.Modal.getOrCreateInstance(document.getElementById('editSoalModal')).show();
        });
    });

    // SUBMIT EDIT
    $('#editSoalForm').on('submit', function (e) {
        e.preventDefault();
        const id = $('#edit_soal_id').val();
        let formData = new FormData(this);
        formData.append('_method', 'PUT');
        Swal.fire({ title: 'Menyimpan...', didOpen: () => Swal.showLoading() });

        $.ajax({
            url: `/guru/data_soal/${id}`, type: 'POST', data: formData, contentType: false, processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                $('#editSoalModal').modal('hide');
                Swal.fire({ icon: 'success', title: 'Berhasil', timer: 1500, showConfirmButton: false }).then(() => { location.reload(); });
            },
            error: function (xhr) { Swal.fire('Gagal', xhr.responseJSON?.message || 'Error', 'error'); }
        });
    });
});     
</script>
@endpush