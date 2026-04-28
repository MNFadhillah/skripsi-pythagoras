@extends('layouts.guru')

@section('title', 'Pencapaian Siswa')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="fw-bold mb-0">Pencapaian Siswa</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- KONTEN UTAMA DENGAN TAB BOOTSTRAP --}}
    <div class="card shadow-sm border-1 rounded">
        <div class="card-header bg-white pt-3 pb-0 border-bottom-0">
            <ul class="nav nav-tabs" id="pencapaianTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold text-dark" id="leaderboard-tab" data-bs-toggle="tab" data-bs-target="#leaderboard" type="button" role="tab">Papan Peringkat</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold text-dark" id="progres-tab" data-bs-toggle="tab" data-bs-target="#progres" type="button" role="tab">Progres Belajar</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold text-dark" id="badges-tab" data-bs-toggle="tab" data-bs-target="#badges" type="button" role="tab">Rekap Lencana</button>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content" id="pencapaianTabsContent">

                {{-- TAB 1: LEADERBOARD (SEKARANG DATATABLES) --}}
                <div class="tab-pane fade show active" id="leaderboard" role="tabpanel">
                    <div class="table-responsive mt-2">
                        <table id="tableLeaderboard" class="table table-hover mb-0 align-middle table-bordered w-100">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" width="10%">Peringkat</th>
                                    <th>Nama Siswa</th>
                                    <th class="text-center" width="20%">Kelas</th>
                                    {{-- UBAH DI SINI: Judul kolom diubah menjadi Total Poin --}}
                                    <th class="text-center" width="20%">Total Poin</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Diisi oleh AJAX DataTables --}}
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TAB 2: PROGRES BELAJAR --}}
                <div class="tab-pane fade" id="progres" role="tabpanel">
                    <div class="table-responsive mt-2">
                        <table id="tableProgress" class="table table-bordered table-hover align-middle w-100">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" width="5%">No</th>
                                    <th class="text-center" width="35%">Nama Siswa</th>
                                    <th class="text-center" width="15%">Kelas</th>
                                    <th class="text-center" width="30%">Progres</th>
                                    <th class="text-center" width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Diisi oleh AJAX DataTables --}}
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TAB 3: REKAP LENCANA --}}
                <div class="tab-pane fade" id="badges" role="tabpanel">
                    <div class="row mt-3">
                        @forelse($badges as $badge)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100 border text-center p-4 shadow-sm d-flex flex-column">
                                @if($badge->image_path)
                                <img src="{{ asset('images/badges/' . $badge->image_path) }}" alt="{{ $badge->name }}" class="mx-auto mb-3" style="width: 120px;">
                                @else
                                <h1 class="display-3 mb-3">🏅</h1>
                                @endif

                                <h6 class="fw-bold mb-1">{{ $badge->name }}</h6>
                                <p class="text-muted small mb-3 flex-grow-1">{{ $badge->description ?? 'Lencana pencapaian.' }}</p>

                                {{-- TOMBOL DIRAIH OLEH --}}
                                <button class="btn btn-sm btn-outline-success rounded-pill mt-auto fw-bold show-badge-modal"
                                    data-id="{{ $badge->id }}"
                                    data-name="{{ $badge->name }}">
                                    <i class="bi bi-people-fill me-1"></i> Diraih oleh {{ $badge->users_count }} Siswa
                                </button>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center text-muted py-5">
                            <h5>Belum ada data lencana.</h5>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL DETAIL PROGRES (Clean & Minimalist) --}}
    <div class="modal fade" id="modalDetailProgres" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content rounded border-0 shadow">

                {{-- Header Modal --}}
                <div class="modal-header bg-success text-white py-3">
                    <h5 class="modal-title fw-bold" id="modalDetailLabel">Detail Pencapaian Siswa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4 bg-light">

                    {{-- Box Info Siswa & Total Progress --}}
                    <div class="bg-white rounded-3 p-4 mb-3 shadow-sm border">
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

                    {{-- Kontainer List Progres Detail --}}
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

    {{-- MODAL DETAIL LENCANA (BARU) --}}
    <div class="modal fade" id="modalDetailBadge" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold">Daftar Peraih Lencana</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="text-center mb-3">
                        <span class="text-muted small">Lencana:</span>
                        <h5 class="fw-bold text-dark mb-0" id="badgeModalName">-</h5>
                    </div>

                    <div class="bg-white rounded border p-3">
                        <ul class="list-group list-group-flush" id="badgeModalList">
                            <div class="text-center py-4">
                                <div class="spinner-border text-success spinner-border-sm" role="status"></div>
                                <span class="ms-2 text-muted">Memuat data...</span>
                            </div>
                        </ul>
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

        // Inisialisasi DataTables untuk Progres
        var tableProgress = $('#tableProgress').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('guru.pencapaian_siswa.data') }}",
                type: "GET",
                data: function(d) {
                    d.kelas_id = $('#filterKelas').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    className: 'text-center fw-bold text-muted'
                },
                {
                    data: 'nama',
                    name: 'nama',
                    className: 'fw-bold text-start'
                },
                {
                    data: 'kelas',
                    name: 'kelas',
                    className: 'text-center text-muted'
                },
                {
                    data: 'progress',
                    name: 'progress',
                    className: 'align-middle px-4'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                }
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
            }
        });

        // Inisialisasi DataTables untuk Leaderboard
        var tableLeaderboard = $('#tableLeaderboard').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('guru.pencapaian_siswa.data_leaderboard') }}",
                type: "GET",
                data: function(d) {
                    d.kelas_id = $('#filterKelas').val();
                }
            },
            columns: [{
                    data: 'peringkat',
                    className: 'text-center align-middle'
                },
                {
                    data: 'nama',
                    className: 'align-middle'
                },
                {
                    data: 'kelas',
                    className: 'text-center align-middle'
                },
                {
                    data: 'points',
                    className: 'text-center align-middle'
                }
            ],
            order: [],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
            }
        });

        // Pemicu saat dropdown Filter Kelas diubah
        $('#filterKelas').on('change', function() {
            tableProgress.ajax.reload();
            tableLeaderboard.ajax.reload();
        });

        // Event listener untuk tombol badge
        $(document).on('click', '.show-badge-modal', function() {
            var badgeId = $(this).data('id');
            var badgeName = $(this).data('name');

            $('#badgeModalName').text(badgeName);
            $('#modalDetailBadge').modal('show');
            $('#badgeModalList').html('<div class="text-center py-4"><div class="spinner-border text-success spinner-border-sm" role="status"></div><span class="ms-2 text-muted">Memuat daftar siswa...</span></div>');

            $.ajax({
                url: '/guru/pencapaian_siswa/badge/' + badgeId + '/detail',
                type: 'GET',
                success: function(res) {
                    let badgeIconHtml = '';
                    if (res.gambar_badge) {
                        badgeIconHtml = `<img src="${res.gambar_badge}" alt="icon" style="width: 100px; margin-bottom: 10px;"><br>`;
                    } else {
                        badgeIconHtml = `<h1 class="display-6 mb-2">🏅</h1>`;
                    }
                    $('#badgeModalName').html(badgeIconHtml + res.nama_badge);

                    let html = '';
                    if (res.peraih && res.peraih.length > 0) {
                        res.peraih.forEach(function(siswa) {
                            html += `<li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div><i class="bi bi-person-circle text-secondary me-2"></i> <span class="fw-bold">${siswa.nama}</span></div>
                                    <span class="badge bg-light text-dark border">${siswa.kelas}</span>
                                </li>`;
                        });
                    } else {
                        html = '<div class="text-center py-4 text-muted">Tidak ada siswa dari kelas Anda yang meraih lencana ini.</div>';
                    }
                    $('#badgeModalList').html(html);
                },
                error: function() {
                    $('#badgeModalList').html('<div class="text-center py-4 text-danger">Gagal memuat data.</div>');
                }
            });
        });
    });


    // ==========================================
    // FUNGSI MENAMPILKAN MODAL DETAIL
    // ==========================================
    function showDetailModal(userId) {
        // Tampilkan modal dan set ke loading state
        $('#modalDetailProgres').modal('show');
        $('#dtl_content').html('<div class="text-center py-5"><div class="spinner-border text-success" role="status"></div><p class="mt-2 text-muted fw-bold">Memuat data pencapaian...</p></div>');

        // Tarik data detail via AJAX
        $.ajax({
            url: '/guru/pencapaian_siswa/' + userId + '/detail',
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
                html += '<h6 class="fw-bold text-success text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 1px;">📚 Materi Pembelajaran</h6>';

                html += renderRow(res.materi.m1.nama, res.materi.m1.persen, res.materi.m1.info);
                html += renderRow(res.materi.m2.nama, res.materi.m2.persen, res.materi.m2.info);
                html += renderRow(res.materi.m3.nama, res.materi.m3.persen, res.materi.m3.info);
                html += renderRow(res.materi.m4.nama, res.materi.m4.persen, res.materi.m4.info);
                html += '</div>';

                // Section KUIS & EVALUASI
                html += '<div class="mt-4">';
                html += '<h6 class="fw-bold text-success text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 1px;">📝 Kuis & Evaluasi</h6>';

                html += renderRow(res.kuis.k1.nama, res.kuis.k1.persen);
                html += renderRow(res.kuis.k2.nama, res.kuis.k2.persen);
                html += renderRow(res.kuis.k3.nama, res.kuis.k3.persen);
                html += renderRow(res.kuis.k4.nama, res.kuis.k4.persen);
                html += renderRow(res.kuis.eval.nama, res.kuis.eval.persen);
                html += '</div>';

                $('#dtl_content').html(html);
            },
            error: function(xhr) {
                console.error(xhr.responseText); // Tambahkan log untuk memudahkan debug jika ada error 500
                $('#dtl_content').html('<div class="text-danger text-center py-4 fw-bold"><i class="bi bi-exclamation-triangle-fill fs-4 d-block mb-2"></i> Gagal memuat data dari server. Pastikan Route URL di AJAX sudah tepat.</div>');
            }
        });
    }
</script>
@endpush