@extends('layouts.guru')

@section('title', 'Data Soal | PythaLearn')

@section('content')
<div class="container-fluid">

    <!-- Judul Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold">Data Soal </h4>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <button class="btn btn-primary" id="btnTambahSoal">
            <i class="bi bi-plus me-1"></i> Tambah Soal
        </button>
    </div>

    {{-- FORM TAMBAH SOAL --}}
    <div class="card shadow-sm mb-4 d-none" id="formTambahSoal">
        <div class="card-header bg-light fw-semibold">
            <i class="bi bi-pencil-square me-1"></i> Tambah Soal Baru
        </div>

        <div class="card-body">
            <!-- PERBAIKAN: Tambahkan enctype="multipart/form-data" -->
            <form id="formSoalBaru" method="POST" action="{{ route('guru.data_soal.store') }}" 
                enctype="multipart/form-data">
                @csrf

                <!-- PAKET SOAL -->
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
                
                <!-- PERTANYAAN -->
                <div class="mb-3">
                    <label class="form-label">Pertanyaan</label>
                    <textarea name="pertanyaan" class="form-control" rows="4"
                        placeholder="Tuliskan pertanyaan soal..." required></textarea>
                    <small class="text-muted">
                        * Jika soal memiliki gambar, tulis teks saja. Gambar akan diatur terpisah.
                    </small>
                </div>

                <!-- Upload Gambar -->
                <div class="mb-3">
                    <label class="form-label">Gambar Soal (opsional)</label>
                    <input type="file" name="gambar" id="gambar_soal" class="form-control" accept="image/*">
                    <small class="text-muted">jpg, png, webp (maks 2MB)</small>
                    <div id="preview_gambar" class="mt-2"></div>
                </div>

                <!-- OPSI JAWABAN -->
                <div class="row">
                    @foreach (['A','B','C','D'] as $opsi)
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Opsi {{ $opsi }}</label>
                            <input type="text" name="opsi[{{ $opsi }}][text]" class="form-control" required>
                        </div>
                    @endforeach
                </div>

                <!-- KUNCI JAWABAN -->
                <div class="mb-3">
                    <label class="form-label">Kunci Jawaban</label>
                    <select name="kunci_jawaban" class="form-select" required>
                        <option value="">-- Pilih Kunci --</option>
                        <option>A</option>
                        <option>B</option>
                        <option>C</option>
                        <option>D</option>
                    </select>
                </div>

                <!-- AKSI -->
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


    <!-- Modal Edit Soal -->
    <div class="modal fade mt-5" id="editSoalModal" tabindex="-1" aria-labelledby="editSoalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSoalModalLabel">Edit Soal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editSoalForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit_soal_id" name="id">
                        
                        <div class="mb-3">
                            <label for="edit_paket_soal_id" class="form-label">Paket Soal</label>
                            <select class="form-control" id="edit_paket_soal_id" name="paket_soal_id" required>
                                <option value="">Pilih Paket Soal</option>
                                @foreach($paketSoal as $paket)
                                    <option value="{{ $paket->id }}">{{ $paket->judul }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="edit_pertanyaan_text" class="form-label">Pertanyaan</label>
                            <textarea class="form-control" id="edit_pertanyaan_text" name="pertanyaan_text" rows="3" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Gambar Soal (Opsional)</label>
                            <div id="edit_gambar_preview" class="mb-2"></div>
                            <input type="file" class="form-control" id="edit_gambar" name="gambar" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar</small>
                            <!-- <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="edit_hapus_gambar" name="hapus_gambar" value="1">
                                <label class="form-check-label" for="edit_hapus_gambar">
                                    Hapus gambar saat ini
                                </label>
                            </div> -->
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Opsi Jawaban</label>
                            @foreach(['A', 'B', 'C', 'D'] as $opsi)
                            <div class="input-group mb-2">
                                <span class="input-group-text" style="width: 40px;">{{ $opsi }}</span>
                                <input type="text" class="form-control" id="edit_opsi_{{ $opsi }}" 
                                    name="opsi[{{ $opsi }}][text]" placeholder="Teks jawaban {{ $opsi }}" required>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="mb-3">
                            <label for="edit_kunci_jawaban" class="form-label">Kunci Jawaban</label>
                            <select class="form-control" id="edit_kunci_jawaban" name="kunci_jawaban" required>
                                <option value="">Pilih Kunci Jawaban</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Card Data Soal -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="tabelSoal">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Pertanyaan</th>
                            <th width="25%">Paket Soal</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($soal as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    @php
                                        $pertanyaanText = '';
                                        
                                        // FORMAT BARU: ARRAY ['text' => ..., 'gambar' => ...]
                                        if (is_array($item->pertanyaan)) {
                                            $pertanyaanText = $item->pertanyaan['text'] ?? '';
                                        } 
                                        // FORMAT LAMA: STRING (backward compatibility)
                                        elseif (is_string($item->pertanyaan)) {
                                            // Hapus bagian [GAMBAR:...] jika ada
                                            if (str_contains($item->pertanyaan, '[GAMBAR:')) {
                                                $pertanyaanText = preg_replace('/\[GAMBAR:.*?\]/', '', $item->pertanyaan);
                                            } else {
                                                // Hapus path gambar jika masih ada format lama tanpa [GAMBAR:]
                                                $pertanyaanText = preg_replace(
                                                    '/\/storage\/[^\s]+(\.(jpg|jpeg|png|gif|webp))/i',
                                                    '',
                                                    $item->pertanyaan
                                                );
                                            }
                                        }
                                        
                                        // Untuk keamanan, juga hapus URL lengkap jika ada
                                        $pertanyaanText = preg_replace('/https?:\/\/[^\s]+/', '', $pertanyaanText);
                                    @endphp

                                    {{ \Illuminate\Support\Str::limit(trim($pertanyaanText), 80) }}
                                    
                                    <!-- Tampilkan icon gambar jika ada -->
                                    @if(
                                        (is_array($item->pertanyaan) && !empty($item->pertanyaan['gambar'])) ||
                                        (is_string($item->pertanyaan) && str_contains($item->pertanyaan, '[GAMBAR:'))
                                    )
                                        <span class="badge bg-info ms-2">
                                            <i class="bi bi-image"></i> Ada Gambar
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $item->paketSoal->judul ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Aksi Soal">
                                        <!-- VIEW -->
                                        <button type="button"
                                            class="btn btn-info btn-view-soal"
                                            data-id="{{ $item->id }}"
                                            title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        <!-- EDIT -->
                                        <button type="button"
                                            class="btn btn-warning btn-edit-soal"
                                            data-id="{{ $item->id }}"
                                            title="Edit Soal">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <!-- DELETE -->
                                        <button type="button"
                                            class="btn btn-danger btn-hapus-soal"
                                            data-id="{{ $item->id }}"
                                            data-judul="{{ Str::limit(trim($pertanyaanText), 50) }}"
                                            title="Hapus Soal">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    Belum ada data soal.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<!-- Modal Lihat Detail Soal -->
<div class="modal fade" id="modalViewSoal" tabindex="-1" aria-labelledby="modalViewSoalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalViewSoalLabel">Detail Soal</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailSoalContent">
                <!-- Konten akan diisi via AJAX -->
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat data soal...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
    
@endsection

@push('styles')
<style>
/* Custom styling untuk SweetAlert */
.swal2-popup {
    border-radius: 12px;
    max-height: 85vh !important;
    margin-top: 2vh !important;
}

.swal2-container {
    overflow-y: auto !important;
    z-index: 1060 !important;
}

.swal2-title {
    color: #0b5e3f;
    font-weight: 600;
    padding-bottom: 10px;
    border-bottom: 1px solid #dee2e6;
    margin-bottom: 15px;
}

.swal2-html-container {
    text-align: left;
    max-height: 60vh;
    overflow-y: auto;
    padding-right: 5px;
}

.soal-image {
    /* max-width: 100%;
    max-height: 180px;  */
    object-fit: contain;
    border-radius: 6px;
    margin: 8px auto;
    display: block;
    border: 1px solid #dee2e6;
    background: #fff;
}


.opsi-container {
    margin: 15px 0;
}

.opsi-item {
    padding: 12px 15px;
    margin-bottom: 10px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
    background: #f8f9fa;
    transition: all 0.2s ease;
    position: relative;
}

.opsi-item.correct {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border: 2px solid #28a745;
    color: #155724;
    box-shadow: 0 2px 5px rgba(40, 167, 69, 0.2);
}

.opsi-item:hover {
    transform: translateX(5px);
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
}

.opsi-item .opsi-label {
    display: inline-block;
    width: 30px;
    font-weight: bold;
    color: #0b5e3f;
}

.opsi-item.correct .opsi-label {
    color: #155724;
}

.kunci-jawaban {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    border: 2px solid #ffc107;
    padding: 15px;
    border-radius: 8px;
    margin-top: 20px;
    font-weight: 600;
    color: #856404;
    text-align: center;
}

.kunci-jawaban i {
    margin-right: 8px;
}

.pertanyaan-content {
    line-height: 1.6;
    font-size: 16px;
    padding: 15px;
    background: white;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.meta-info {
    background: #e9ecef;
    padding: 12px 15px;
    border-radius: 6px;
    font-size: 14px;
    color: #495057;
    border-left: 4px solid #0b5e3f;
}

.meta-info strong {
    color: #0b5e3f;
}

/* Scrollbar styling */
.swal2-html-container::-webkit-scrollbar {
    width: 8px;
}

.swal2-html-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.swal2-html-container::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

.swal2-html-container::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
@endpush

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
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                }
            },
            pageLength: 10,
            responsive: true,
            autoWidth: false
        });
    } catch (error) {
        console.error('Error DataTables:', error);
    }

    // 2. Fungsi untuk mengekstrak dan menampilkan gambar dari teks
    function extractAndDisplayImages(text) {
        let imagesHTML = '';
        let processedText = text;
        
        // Regex untuk mendeteksi URL gambar (berbagai format)
        const imageRegex = /(https?:\/\/[^\s]+\.(?:jpg|jpeg|png|gif|bmp|webp|svg))(?:\s|$)/gi;
        const matches = text.match(imageRegex);
        
        if (matches && matches.length > 0) {
            matches.forEach(url => {
                // Hapus URL dari teks utama
                processedText = processedText.replace(url, '').trim();
                
                // Tambahkan HTML untuk gambar
                imagesHTML += `
                <div class="text-center my-3">
                    <img src="${url}"
                    class="soal-image"
                    style="
                        max-width: 100%;
                        max-height: 200px;
                        width: auto;
                        height: auto;
                        display: block;
                        margin: 0 auto;
                        object-fit: contain;
                    "
                    onerror="this.style.display='none'" />
                </div>
                `;
            });
        }
        
        // Coba format kedua untuk path lokal
        const localImageRegex = /(\/storage\/[^\s]+\.(?:jpg|jpeg|png|gif|bmp|webp|svg))(?:\s|$)/gi;
        const localMatches = text.match(localImageRegex);
        
        if (localMatches && localMatches.length > 0) {
            localMatches.forEach(path => {
                processedText = processedText.replace(path, '').trim();
                
                // Tambahkan base URL jika path relatif
                const fullUrl = path.startsWith('http') ? path : window.location.origin + path;
                
                imagesHTML += `
                    <div class="text-center my-4">
                        <img src="${fullUrl}" class="img-fluid soal-image" 
                             alt="Gambar soal"
                             onerror="this.style.display='none'">
                        <p class="text-muted small mt-2">Gambar soal</p>
                    </div>
                `;
            });
        }
        
        return {
            text: processedText,
            images: imagesHTML
        };
    }

    // 3. Fungsi untuk menampilkan detail soal
    function showDetailSoal(id) {
        Swal.fire({
            title: 'Memuat...',
            text: 'Sedang mengambil detail soal',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: `/guru/data_soal/${id}/json`,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                Swal.close();
                
                console.log('Data yang diterima:', data);
                
                // Proses pertanyaan
                let pertanyaan = '';
                let imagesHTML = '';
                
                if (data.pertanyaan) {

                    // CASE 1: STRING (Format Lama / Hasil Update)
                    // Menangani data string yang berisi teks + path gambar
                    if (typeof data.pertanyaan === 'string') {
                        const processed = extractAndDisplayImages(data.pertanyaan);
                        pertanyaan = processed.text;
                        imagesHTML = processed.images;
                    }

                    // CASE 2: OBJECT { text, image }
                    else if (typeof data.pertanyaan === 'object' && !Array.isArray(data.pertanyaan)) {
                        pertanyaan = data.pertanyaan.text || '';

                        // Ambil path gambar (prioritaskan 'image', fallback ke 'gambar')
                        let rawImg = data.pertanyaan.image || data.pertanyaan.gambar;

                        if (rawImg) {
                            let fullImgUrl = rawImg;

                            // LOGIKA TAMBAHAN:
                            // Jika path tidak diawali 'http' (berarti path relatif /storage/...), 
                            // kita tambahkan domain utama website di depannya.
                            if (!rawImg.startsWith('http')) {
                                fullImgUrl = window.location.origin + rawImg;
                            }

                            imagesHTML = `
                                <div class="text-center my-4">
                                    <img src="${fullImgUrl}" class="img-fluid soal-image" 
                                        alt="Gambar Soal"
                                        style="max-height: 250px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);"
                                        onerror="this.onerror=null; this.src=''; this.parentElement.innerHTML='<p class=\'text-danger small\'>Gagal memuat gambar. Cek storage:link</p>';">
                                </div>
                            `;
                        }
                    }

                    // CASE 3: ARRAY (Format Legacy lainnya)
                    else if (Array.isArray(data.pertanyaan)) {
                        pertanyaan = data.pertanyaan
                            .map(item => item.text || '')
                            .join(' ');
                    }
                }

              if (!pertanyaan.trim()) {
                  pertanyaan = '<em class="text-muted">Tidak ada teks pertanyaan</em>';
              }

                
                // Jika pertanyaan kosong setelah ekstraksi gambar, beri nilai default
                if (!pertanyaan || pertanyaan.trim() === '') {
                    pertanyaan = '<em class="text-muted">Tidak ada teks pertanyaan</em>';
                }

                // Proses opsi jawaban
                let opsiJawaban = {};
                try {
                    if (data.opsi_jawaban) {
                        if (typeof data.opsi_jawaban === 'string') {
                            opsiJawaban = JSON.parse(data.opsi_jawaban);
                        } else if (typeof data.opsi_jawaban === 'object') {
                            opsiJawaban = data.opsi_jawaban;
                        }
                    }
                } catch(e) {
                    console.error('Error parsing opsi jawaban:', e);
                    opsiJawaban = {};
                }
                
                // Format opsi untuk ditampilkan
                let opsiHTML = '<div class="opsi-container">';
                const kunciJawaban = data.kunci_jawaban || '';
                const urutanOpsi = ['A', 'B', 'C', 'D'];

                urutanOpsi.forEach(key => {
                    if (!data.opsi_jawaban || !data.opsi_jawaban[key]) return;

                    const opsi = data.opsi_jawaban[key];
                    const isCorrect = key === kunciJawaban;

                    let teksOpsi = '';
                    let gambarOpsi = '';

                    // STRING
                    if (typeof opsi === 'string') {
                        teksOpsi = opsi;
                    }

                    // OBJECT { text, image }
                    else if (typeof opsi === 'object') {
                        teksOpsi = opsi.text || '';
                        if (opsi.image) {
                            gambarOpsi = `
                                <div class="mt-2">
                                    <img src="${opsi.image}"
                                        class="soal-image"
                                        style="max-height:120px; display:block; margin-top:8px;">
                                </div>
                            `;
                        }
                    }

                    opsiHTML += `
                        <div class="opsi-item ${isCorrect ? 'correct' : ''}">
                            <span class="opsi-label">${key}.</span>
                            <span class="opsi-text">${teksOpsi || '<em>Tidak ada teks</em>'}</span>
                            ${gambarOpsi}
                        </div>
                    `;
                });

                opsiHTML += '</div>';


                pertanyaan = pertanyaan.replace(/\\n/g, '<br>');

                // Tampilkan popup dengan tinggi yang disesuaikan
                Swal.fire({
                    title: 'Detail Soal',
                    html: `
                        <div style="text-align: left;">
                            <div class="mb-4">
                                <h6 class="text-success mb-2">Pertanyaan:</h6>
                                <div class="pertanyaan-content">
                                    ${pertanyaan}
                                </div>
                            </div>
                            ${imagesHTML}
                            <div class="mb-4">
                                <h6 class="text-success mb-2">Opsi Jawaban:</h6>
                                ${opsiHTML}
                            </div>
                            <div class="kunci-jawaban">
                                <strong>Kunci Jawaban:</strong> 
                                ${kunciJawaban ? `<span class="badge bg-success ms-2">${kunciJawaban}</span>` : '<em class="text-muted ms-2">Belum diatur</em>'}
                            </div>
                            <div class="meta-info mt-3">
                                <small>
                                    <i class="bi bi-info-circle me-1"></i>
                                    <strong>Paket Soal:</strong> ${data.paket_soal || 'Tidak ada paket'}
                                </small>
                            </div>
                        </div>
                    `,
                    width: '800px',
                    heightAuto: true,
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#0b5e3f',
                    showCloseButton: true,
                    customClass: {
                        popup: 'border border-success',
                        container: 'swal2-container-custom'
                    },
                    didOpen: () => {
                        const container = Swal.getHtmlContainer();
                        container.style.maxHeight = '65vh';
                        container.style.overflowY = 'auto';
                    }
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error',
                    text: 'Gagal mengambil data soal. Silakan coba lagi.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc3545'
                });
            }
        });
    }

    // 4. Event listener untuk tombol view
    $(document).on('click', '.btn-view-soal', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        
        if (id) {
            showDetailSoal(id);
        } else {
            Swal.fire({
                title: 'ID tidak valid',
                text: 'ID soal tidak ditemukan',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        }
    });
});



$(document).ready(function () {

    /* ===============================
       TOGGLE FORM TAMBAH SOAL
    =============================== */
    $('#btnTambahSoal').on('click', function () {
        const form = $('#formTambahSoal');

        if (form.hasClass('d-none')) {
            form.hide().removeClass('d-none').slideDown(300);
            $('html, body').animate({
                scrollTop: form.offset().top - 100
            }, 300);
        } else {
            form.slideUp(300, function () {
                form.addClass('d-none');
            });
        }
    });

    $('#btnBatalTambah').on('click', function () {
        $('#formTambahSoal').slideUp(300, function () {
            $(this).addClass('d-none');
        });
    });

    document.getElementById('gambar_soal').addEventListener('change', function(e) {
        const preview = document.getElementById('preview_gambar');
        preview.innerHTML = '';
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '200px';
                img.style.maxHeight = '150px';
                img.className = 'img-thumbnail';
                preview.appendChild(img);
            }
            
            reader.readAsDataURL(this.files[0]);
        }
    });

    /* ===============================
       SUBMIT FORM TAMBAH SOAL
    =============================== */
    $('#formSoalBaru').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        Swal.fire({
            title: 'Menyimpan Soal',
            text: 'Mohon tunggu...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: res.message ?? 'Soal berhasil ditambahkan',
                    confirmButtonColor: '#0b5e3f'
                }).then(() => {
                    location.reload();
                });
            },
            error: function (xhr) {
                let msg = 'Terjadi kesalahan';

                if (xhr.responseJSON?.errors) {
                    msg = Object.values(xhr.responseJSON.errors)
                        .map(v => v[0])
                        .join('<br>');
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    html: msg,
                    confirmButtonColor: '#dc3545'
                });
            }
        });
    });

        /* ===============================
        HAPUS SOAL
        =============================== */

    $(document).on('click', '.btn-hapus-soal', function () {

        const id = $(this).data('id');
        const judul = $(this).data('judul');
        const token = $('meta[name="csrf-token"]').attr('content');

        Swal.fire({
            title: 'Hapus Soal?',
            html: `
                <p>Apakah Anda yakin ingin menghapus soal berikut?</p>
                <strong>"${judul}"</strong>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Mohon tunggu',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                $.ajax({
                    url: `/guru/data_soal/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    success: function (res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            confirmButtonColor: '#0b5e3f'
                        }).then(() => {
                            location.reload(); // nanti bisa ganti datatable reload
                        });
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Soal gagal dihapus',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                });
            }
        });
    });

});

/* ==========================================
   LOGIKA EDIT SOAL (FINAL VERSION)
   ========================================== */

    // 1. KLIK TOMBOL EDIT (Load Data)
    $(document).on('click', '.btn-edit-soal', function () {
        const id = $(this).data('id');
        const url = `/guru/data_soal/${id}/edit-json`;

        // Reset form & tampilan
        $('#editSoalForm')[0].reset();
        $('#edit_gambar_preview').html('');
        // $('#edit_hapus_gambar').prop('checked', false);
        // $('#edit_hapus_gambar').closest('div').hide(); // Sembunyikan checkbox hapus dulu

        Swal.fire({ title: 'Memuat Data...', didOpen: () => Swal.showLoading() });

        $.get(url, function (res) {
            Swal.close();
            if (!res.success) return;

            // Isi Inputan Dasar
            $('#edit_soal_id').val(res.id);
            $('#edit_paket_soal_id').val(res.paket_soal_id);
            $('#edit_pertanyaan_text').val(res.pertanyaan);
            $('#edit_kunci_jawaban').val(res.kunci_jawaban);

            // Isi Opsi Jawaban
            ['A', 'B', 'C', 'D'].forEach(key => {
                let val = '';
                if (res.opsi && res.opsi[key]) {
                    // Handle format string atau object
                    val = (typeof res.opsi[key] === 'object') ? res.opsi[key].text : res.opsi[key];
                }
                $(`#edit_opsi_${key}`).val(val);
            });

            // LOGIKA PREVIEW GAMBAR
            if (res.gambar) {
                // Bikin URL lengkap
                let imgUrl = res.gambar;
                if (!imgUrl.startsWith('http')) {
                    // Bersihkan slash depan jika double
                    let cleanPath = imgUrl.startsWith('/') ? imgUrl.substring(1) : imgUrl;
                    imgUrl = window.location.origin + '/' + cleanPath;
                }

                $('#edit_gambar_preview').html(`
                    <div class="p-2 border rounded bg-light text-center">
                        <img src="${imgUrl}" class="img-fluid" 
                            style="max-height: 150px; border-radius: 5px;"
                            onerror="this.style.display='none'">
                        <div class="mt-1 small text-success fw-bold">
                            <i class="bi bi-check-circle"></i> Gambar Terpasang
                        </div>
                    </div>
                `);
                
                // Tampilkan opsi hapus gambar karena gambarnya ada
                // $('#edit_hapus_gambar').closest('div').slideDown();
            } else {
                $('#edit_gambar_preview').html(`
                    <div class="alert alert-secondary py-2 small mb-0">
                        <i class="bi bi-info-circle"></i> Tidak ada gambar saat ini
                    </div>
                `);
            }

            // Tampilkan Modal
            new bootstrap.Modal(document.getElementById('editSoalModal')).show();

        }).fail(function() {
            Swal.close();
            Swal.fire('Error', 'Gagal mengambil data soal', 'error');
        });
    });

    // 2. SUBMIT FORM EDIT
    $('#editSoalForm').on('submit', function (e) {
        e.preventDefault();

        const id = $('#edit_soal_id').val();
        const url = `/guru/data_soal/${id}`; // Route PUT
        let formData = new FormData(this);

        // Tambahkan method PUT untuk Laravel
        formData.append('_method', 'PUT');

        Swal.fire({ 
            title: 'Menyimpan Perubahan...', 
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading() 
        });

        $.ajax({
            url: url,
            type: 'POST', // Browser cuma support POST untuk upload file
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                if (res.success) {
                    $('#editSoalModal').modal('hide'); // Tutup modal
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload(); // Refresh halaman
                    });
                }
            },
            error: function (xhr) {
                let msg = 'Gagal menyimpan data.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire('Gagal', msg, 'error');
            }
        });
    });

</script>
@endpush