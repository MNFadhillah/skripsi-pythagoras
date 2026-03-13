@extends('layouts.guru')

@section('title', 'Progres Siswa • Guru PythaLearn')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endpush

@section('content')
<div class="container-fluid">
    
    {{-- HEADER (Mengikuti Template Data Nilai Siswa) --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                {{-- Judul --}}
                <div class="col-md-6">
                    <h4 class="fw-bold mb-0">Progres Siswa</h4>
                </div>
                
                {{-- Filter & Action --}}
                <div class="col-md-6 d-flex justify-content-md-end gap-2 mt-3 mt-md-0">
                    
                    {{-- 1. Filter Kelas --}}
                    <div class="d-flex align-items-center gap-2">
                        <select id="filterKelas" class="form-select shadow-sm border-secondary-subtle" style="width: 200px;">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
    
    {{-- TABEL UTAMA (Bersih tanpa Header Tabel) --}}
    <div class="card shadow-sm border-1 rounded">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableProgress" class="table table-bordered table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th class="text-center" width="35%">Nama Siswa</th>
                            <th class="text-center" width="5%">Kelas</th>
                            <th class="text-center" width="40%">Progres</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Data diisi oleh DataTables melalui AJAX --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL DETAIL PROGRES (Clean & Minimalist) --}}
    <div class="modal fade" id="modalDetailProgres" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content rounded border-0 shadow">
                
                {{-- Header Modal disesuaikan dengan gaya modal riwayat --}}
                <div class="modal-header bg-success text-white py-3">
                    <h5 class="modal-title fw-bold" id="modalDetailLabel">Detail Progres Siswa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body p-4 bg-light">
                    
                {{-- Box Info Siswa & Total Progress --}}
                    <div class="bg-white rounded-3 p-4 mb-2 shadow-sm border">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <span class="text-muted small d-block mb-1">Nama Siswa</span> 
                                <span id="dtl_nama" class="text-dark fw-bold fs-5">-</span>
                            </div>
                            <div class="col-md-6 border-start">
                                <span class="text-muted small d-block mb-1">Email/ID</span> 
                                <span id="dtl_identitas" class="text-dark fw-bold">-</span>
                            </div>
                        </div>
                        
                        {{-- Bar Progress Keseluruhan --}}
                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-end mb-2">
                                <span class="text-dark fw-bold">Total Progres</span>
                                <span class="fw-bold fs-4" id="dtl_total_progres_text">0%</span>
                            </div>
                            <div class="progress rounded-pill bg-light border" style="height: 14px;">
                                <div id="dtl_total_progres_bar" class="progress-bar progress-bar-striped progress-bar-animated rounded-pill" role="progressbar" style="width: 0%;"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Kontainer List Progres --}}
                    <div class="bg-white rounded-3 p-4 shadow-sm border" id="dtl_content">
                        <div class="text-center py-5">
                            <div class="spinner-border text-success" role="status"></div>
                            <p class="mt-2 text-muted">Memuat detail...</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function() {
    
    // Inisialisasi DataTables
    var table = $('#tableProgress').DataTable({
        processing: false, 
        serverSide: false, 
        ajax: {
            url: "{{ route('guru.progres_siswa.data') }}",
            type: "GET",
            data: function (d) {
                // Ambil value filter kelas
                d.kelas_id = $('#filterKelas').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center fw-bold text-muted' },
            { data: 'nama', name: 'nama', className: 'fw-bold text-start' },
            { data: 'kelas', name: 'kelas', className: 'text-center text-muted' },
            { data: 'progress', name: 'progress', className: 'align-middle px-4' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: 'text-center' }
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ siswa",
            emptyTable: "Belum ada data progres.",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            },
            url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
        },
        pageLength: 10
    });

    // Pemicu saat dropdown Filter Kelas diubah
    $('#filterKelas').on('change', function() {
        table.ajax.reload();
    });
});

// ==========================================
// FUNGSI MENAMPILKAN MODAL DETAIL (PERPADUAN CLEAN & INFORMATIF)
// ==========================================
function showDetailModal(userId) {
    // Tampilkan modal dan set ke loading state
    $('#modalDetailProgres').modal('show');
    $('#dtl_content').html('<div class="text-center py-5"><div class="spinner-border text-success" role="status"></div><p class="mt-2 text-muted fw-bold">Memuat data progres...</p></div>');

    // Tarik data detail via AJAX
    $.ajax({
        url: '/guru/progres_siswa/' + userId + '/detail',
        type: 'GET',
        success: function(res) {
            // Isi Header Box (Identitas)
            $('#dtl_nama').text(res.nama);
            $('#dtl_identitas').text(res.identitas);

            let totalProg = res.total_progress;
            $('#dtl_total_progres_text').text(totalProg + '%');
            $('#dtl_total_progres_bar').css('width', totalProg + '%');

            // Logika warna untuk Total Progress
            if (totalProg === 100) {
                $('#dtl_total_progres_text').removeClass('text-primary').addClass('text-success');
                $('#dtl_total_progres_bar').removeClass('bg-primary').addClass('bg-success');
            } else {
                $('#dtl_total_progres_text').removeClass('text-success').addClass('text-primary');
                $('#dtl_total_progres_bar').removeClass('bg-success').addClass('bg-primary');
            }

            // Fungsi pembantu untuk merakit List dengan Progress Bar
            const renderRow = (title, percent, info = '') => {
                let statusHtml = '';
                let barColor = '';
                let titleClass = 'text-dark fw-bold'; 

                if (percent === 100) {
                    statusHtml = '<span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>Selesai</span>';
                    barColor = 'bg-success';
                } else if (percent > 0) {
                    statusHtml = `<span class="text-primary">${percent}%</span>`;
                    barColor = 'bg-primary';
                } else {
                    statusHtml = '<span class="text-muted"><i class="bi bi-dash-circle me-1"></i>Belum dikerjakan</span>';
                    barColor = 'bg-secondary';
                }

                let infoHtml = info && info !== 'Locked' ? `<span class="text-muted fw-normal small ms-1">(${info})</span>` : '';

                return `
                    <div class="py-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="${titleClass}" style="font-size: 0.95rem;">
                                ${title} ${infoHtml}
                            </div>
                            <div class="fw-bold" style="font-size: 0.9rem;">
                                ${statusHtml}
                            </div>
                        </div>
                        <div class="progress rounded-pill bg-light" style="height: 6px;">
                            <div class="progress-bar ${barColor} rounded-pill" role="progressbar" style="width: ${percent}%;"></div>
                        </div>
                    </div>
                `;
            };

            let html = '';

            // Section MATERI
            html += '<div class="mb-4">';
            html += '<h6 class="fw-bold text-success text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 1px;"> Materi Pembelajaran</h6>';
            
            html += renderRow(res.materi.m1.nama, res.materi.m1.persen, res.materi.m1.info);
            html += renderRow(res.materi.m2.nama, res.materi.m2.persen, res.materi.m2.info);
            html += renderRow(res.materi.m3.nama, res.materi.m3.persen, res.materi.m3.info);
            html += renderRow(res.materi.m4.nama, res.materi.m4.persen, res.materi.m4.info);
            html += '</div>';

            // Section KUIS & EVALUASI
            html += '<div class="mt-4">';
            html += '<h6 class="fw-bold text-success text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 1px;">Kuis & Evaluasi</h6>';
            
            html += renderRow(res.kuis.k1.nama, res.kuis.k1.persen);
            html += renderRow(res.kuis.k2.nama, res.kuis.k2.persen);
            html += renderRow(res.kuis.k3.nama, res.kuis.k3.persen);
            html += renderRow(res.kuis.k4.nama, res.kuis.k4.persen);
            html += renderRow(res.kuis.eval.nama, res.kuis.eval.persen);
            html += '</div>';

            $('#dtl_content').html(html);
        },
        error: function() {
            $('#dtl_content').html('<div class="text-danger text-center py-4 fw-bold"><i class="bi bi-exclamation-triangle-fill fs-4 d-block mb-2"></i> Gagal memuat data dari server.</div>');
        }
    });
}
</script>
@endpush