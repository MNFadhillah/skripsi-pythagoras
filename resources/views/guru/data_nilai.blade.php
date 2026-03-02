@extends('layouts.guru')

@section('title', 'Data Nilai Siswa')

@section('content')
<div class="container-fluid">
    {{-- HEADER --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                {{-- Judul --}}
                <div class="col-md-6">
                    <h4 class="fw-bold mb-0">Rekap Data Nilai Siswa</h4>
                </div>
                
                {{-- Filter & Action --}}
                <div class="col-md-6 d-flex justify-content-md-end gap-2 mt-3 mt-md-0">
                    
                    {{-- 1. Filter Kelas --}}
                    <form action="{{ route('guru.data_nilai') }}" method="GET" class="d-flex gap-2">
                        <select name="kelas_id" class="form-select shadow-sm border-secondary-subtle" style="width: 200px;" onchange="this.form.submit()">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($listKelas as $kls)
                                <option value="{{ $kls->id }}" {{ $kelasId == $kls->id ? 'selected' : '' }}>
                                    {{ $kls->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    {{-- 2. Logika Teks Tombol Export --}}
                    @php
                        $teksExport = "Export Semua"; // Default
                        
                        // Cek jika ada filter kelas yang aktif
                        if(isset($kelasId) && $kelasId != '') {
                            // Cari nama kelas dari list yang sudah ada (tanpa query ulang)
                            $kelasTerpilih = $listKelas->firstWhere('id', $kelasId);
                            if($kelasTerpilih) {
                                $teksExport = "Export " . $kelasTerpilih->nama_kelas;
                            }
                        }
                    @endphp

                    {{-- 3. Tombol Export Dinamis --}}
                    {{-- request()->all() memastikan filter tetap terbawa saat export --}}
                    <a href="{{ route('guru.data_nilai.export', request()->all()) }}" class="btn btn-success text-white shadow-sm text-nowrap">
                        <i class="bi bi-file-earmark-excel me-1"></i> {{ $teksExport }}
                    </a>
                    
                </div>
            </div>
        </div>
    </div>
    
    {{-- TABEL UTAMA --}}
    <div class="card shadow-sm border-1 rounded">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="tabelNilai">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th class="text-center">Nama Siswa</th>
                            <th class="text-center">Kelas</th>
                            <th class="text-center">Kuis 1</th>
                            <th class="text-center">Kuis 2</th>
                            <th class="text-center">Kuis 3</th>
                            <th class="text-center">Kuis 4</th>
                            <th class="text-center">Evaluasi</th>
                            <th class="text-center" width="10%">Riwayat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataSiswa as $siswa)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-start">
                                <div class="fw-bold text-truncate" style="max-width: 200px;">
                                    {{ $siswa['name'] }}
                                </div>
                                <div class="small text-muted">{{ $siswa['email'] }}</div>
                            </td>
                            <td>{{ $siswa['kelas'] }}</td>
                            
                            @foreach(['kuis_1', 'kuis_2', 'kuis_3', 'kuis_4', 'evaluasi'] as $key)
                            <td>
                                @php 
                                    $val = $siswa['nilai'][$key];
                                    $color = ($val === '-') ? 'bg-secondary' : ($key === 'evaluasi' ? 'bg-success' : 'bg-primary');
                                @endphp
                                <span class="badge {{ $color }} fs-6">
                                    {{ $val }}
                                </span>
                            </td>
                            @endforeach
                            
                            <td>
                                <button class="btn btn-sm btn-info text-white shadow-sm btn-riwayat" 
                                        data-user-id="{{ $siswa['user_id'] }}" 
                                        data-user-name="{{ $siswa['name'] }}"
                                        title="Lihat Riwayat Pengerjaan">
                                    <i class="bi bi-clock-history"></i>
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

{{-- MODAL RIWAYAT PENGERJAAN --}}
<div class="modal fade" id="modalRiwayat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded border-0 shadow">
            <div class="modal-header bg-success text-white py-3">
                <h5 class="modal-title fw-bold" id="modalRiwayatTitle">Riwayat Pengerjaan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>  
            <div class="modal-body bg-light" id="modalRiwayatBody">
                {{-- Diisi via AJAX --}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
        // 1. INISIALISASI DATATABLES TABEL UTAMA
        $('#tabelNilai').DataTable({
            "language": {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ nilai",
                emptyTable: "Belum ada data Nilai.",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                },
                "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
                
            },
            "pageLength": 10,
            "columnDefs": [
                { "orderable": false, "targets": [0, 8] }
            ],
            "order": [[1, 'asc']]
        });

        // 2. LOGIKA AJAX RIWAYAT (FIXED VERSION)
        $(document).on('click', '.btn-riwayat', function() {
            let userId = $(this).data('user-id');
            let userName = $(this).data('user-name');
            let url = "{{ route('guru.data_nilai.riwayat', ':id') }}".replace(':id', userId);

            $('#modalRiwayatTitle').html(`<i class="bi bi-clock-history me-2"></i>Riwayat: ${userName}`);
            $('#modalRiwayatBody').html('<div class="text-center my-5"><div class="spinner-border text-success"></div><p class="mt-2">Memuat data...</p></div>');
            
            let modalRiwayat = new bootstrap.Modal(document.getElementById('modalRiwayat'));
            modalRiwayat.show();

            $.ajax({
                url: url,
                type: 'GET',
                success: function(res) {
                    if(res.success) {
                        let data = res.data;
                        let html = '';

                        if(Object.keys(data).length === 0) {
                            html = '<div class="alert alert-warning text-center">Belum ada riwayat pengerjaan.</div>';
                        } else {
                            for (const [judulPaket, attempts] of Object.entries(data)) {
                                html += `<h5 class="fw-bold mt-4 mb-3 text-success text-uppercase">${judulPaket}</h5>`;
                                html += `<div class="card shadow-sm border-0 mb-4 rounded overflow-hidden">
                                            <div class="card-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover text-center mb-0" style="min-width: 900px;">
                                                        <thead class="bg-success text-white"> 
                                                            <tr>
                                                                <th width="8%" class="py-3">Percobaan</th>
                                                                <th width="12%">Tanggal</th>
                                                                <th width="10%">Mulai</th>
                                                                <th width="10%">Selesai</th>
                                                                <th width="8%">Nilai</th>
                                                                <th width="10%">Status</th>`;
                                
                                // Mencari jumlah soal terbanyak
                                let maxSoal = 0;
                                attempts.forEach(attempt => {
                                    if (attempt.total_soal > maxSoal) maxSoal = attempt.total_soal;
                                });

                                for (let i = 1; i <= maxSoal; i++) {
                                    html += `<th class="fw-bold">S${i}</th>`;
                                }
                                
                                html += `</tr></thead><tbody class="bg-white fs-6">`;

                                attempts.forEach((attempt, index) => {
                                    let badgeStatus = attempt.status_lulus 
                                            ? '<span class="badge bg-success rounded-pill px-3">Lulus</span>'
                                            : '<span class="badge bg-danger rounded-pill px-3">Tidak Lulus</span>';

                                    // --- PERBAIKAN DI SINI ---
                                    // Langsung pakai data dari Controller (tidak perlu split-split lagi)
                                    // Controller Anda sudah mengirimkan key: 'tanggal', 'jam_mulai', 'jam_selesai'
                                    
                                    html += `<tr>
                                                <td class="text-muted fw-bold">Ke-${index + 1}</td>
                                                <td>${attempt.tanggal}</td>
                                                <td class="fw-bold text-primary">${attempt.jam_mulai}</td>
                                                <td class="fw-bold text-danger">${attempt.jam_selesai}</td>
                                                <td class="fw-bold fs-5">${attempt.skor}</td>
                                                <td>${badgeStatus}</td>`;

                                    // Loop Jawaban (Matrix)
                                    for (let i = 0; i < maxSoal; i++) {
                                        if (i < attempt.matrix.length) {
                                            let isBenar = attempt.matrix[i];
                                            let icon = isBenar 
                                                ? '<i class="bi bi-check-circle-fill text-success fs-5"></i>' 
                                                : '<i class="bi bi-x-circle-fill text-danger fs-5"></i>';
                                            html += `<td>${icon}</td>`;
                                        } else {
                                            html += `<td class="text-muted">-</td>`;
                                        }
                                    }
                                    html += `</tr>`;
                                });

                                html += `</tbody></table></div></div></div>`;
                            }
                        }
                        $('#modalRiwayatBody').html(html);
                    }
                },
                error: function() {
                    $('#modalRiwayatBody').html('<div class="alert alert-danger text-center">Terjadi kesalahan saat mengambil data riwayat.</div>');
                }
            });
        });
    });
</script>
@endpush