@extends('layouts.guru')

@section('title', 'Data Nilai Siswa')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold">Rekap Nilai Siswa</h4>
    </div>

    {{-- TABEL UTAMA --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tabelNilai">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th width="20%">Nama Siswa</th>
                            <th width="20%">Paket Soal</th>
                            <th class="text-center" width="8%">Skor</th>
                            <th width="12%">Tanggal</th>
                            <th class="text-center" width="8%">Mulai</th>
                            <th class="text-center" width="12%">Selesai</th>
                            <th class="text-center" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataNilai as $item)
                        
                        @php
                            $start = $item->waktu_mulai ? \Carbon\Carbon::parse($item->waktu_mulai) : null;
                            $end   = $item->waktu_selesai ? \Carbon\Carbon::parse($item->waktu_selesai) : null;
                            $durasiTeks = '-';
                            if ($start && $end) {
                                $diffMinutes = $start->diffInMinutes($end);
                                $durasiTeks = ($diffMinutes >= 60) 
                                    ? floor($diffMinutes / 60) . " jam " . ($diffMinutes % 60) . " mnt"
                                    : $diffMinutes . " menit";
                            }
                        @endphp

                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-bold text-truncate" style="max-width: 180px;">
                                    {{ $item->user->name ?? 'User Hilang' }}
                                </div>
                                <div class="small text-muted">{{ $item->user->email ?? '-' }}</div>
                            </td>
                            <td><div class="text-wrap small">{{ $item->paketSoal->judul ?? 'Paket Dihapus' }}</div></td>
                            <td class="text-center"><span class="badge bg-primary fs-6">{{ $item->skor_akhir }}</span></td>
                            <td class="small"><i class="bi bi-calendar-event text-muted"></i> {{ $start ? $start->translatedFormat('d M Y') : '-' }}</td>
                            <td class="text-center small">{{ $start ? $start->format('H:i') : '-' }}</td>
                            <td class="text-center small">
                                <div>{{ $end ? $end->format('H:i') : '-' }}</div>
                                @if($durasiTeks !== '-')
                                    <span class="badge bg-light text-secondary border rounded-pill px-2 mt-1 fw-normal" style="font-size: 0.7rem;">
                                        <i class="bi bi-hourglass-split"></i> {{ $durasiTeks }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-success text-white btn-analisis shadow-sm" 
                                        data-id="{{ $item->id }}" title="Lihat Analisis Jawaban">
                                    <i class="bi bi-grid-3x3 me-1"></i> Detail
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

{{-- MODAL ANALISIS & DETAIL --}}
<div class="modal fade" id="modalAnalisis" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" style="margin-top: 70px; height: calc(100vh - 100px);">
        <div class="modal-content rounded-4 border-0 h-100">
            
            <div class="modal-header bg-success text-white py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-card-checklist me-2"></i>Analisis & Detail Jawaban</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bg-light">
                {{-- INFO SISWA --}}
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body py-2">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="fw-bold mb-0 text-dark" id="analisisNama">-</h5>
                                <small class="text-muted" id="analisisPaket">-</small>
                            </div>
                            <div class="col-md-6 text-end">
                                <span class="badge bg-primary fs-4 px-3" id="analisisSkor">0</span>
                                <div class="small text-muted mt-1" id="analisisWaktu">-</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MATRIKS JAWABAN (HORIZONTAL) --}}
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white fw-bold border-bottom-0 py-2">
                        <i class="bi bi-grid-3x3 me-2"></i>Matriks Jawaban (1 = Benar, 0 = Salah)
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center mb-0" style="min-width: 800px;">
                                {{-- PERUBAHAN: Header Putih (bg-white) --}}
                                <thead class="bg-white text-secondary">
                                    <tr id="headNomorSoal"></tr> 
                                </thead>
                                {{-- Body Putih --}}
                                <tbody class="bg-white fs-6"> 
                                    <tr id="bodySkorSoal"></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- ACCORDION DETAIL SOAL (VERTIKAL) --}}
                <div class="accordion shadow-sm" id="accordionDetailSoal">
                    <div class="accordion-item border-0 rounded-3 overflow-hidden">
                        <h2 class="accordion-header" id="headingDetail">
                            <button class="accordion-button collapsed fw-bold bg-white py-3" 
                                    type="button" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#collapseDetail" 
                                    aria-expanded="false" 
                                    aria-controls="collapseDetail">
                                <i class="bi bi-list-ol me-2"></i> Lihat Rincian Soal & Jawaban Lengkap
                            </button>
                        </h2>
                        <div id="collapseDetail" class="accordion-collapse collapse" aria-labelledby="headingDetail" data-bs-parent="#accordionDetailSoal">
                            <div class="accordion-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light text-secondary small">
                                            <tr>
                                                <th class="text-center" width="5%">No</th>
                                                <th width="50%">Pertanyaan</th>
                                                <th class="text-center" width="15%">Jwb Siswa</th>
                                                <th class="text-center" width="15%">Kunci</th>
                                                <th class="text-center" width="15%">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyDetailVertikal"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Init DataTable Utama
    $('#tabelNilai').DataTable();

    // Variable global untuk instance modal
    let myModalAnalisis = new bootstrap.Modal(document.getElementById('modalAnalisis'));

    // EVENT KLIK TOMBOL ANALISIS
    $(document).on('click', '.btn-analisis', function() {
        let id = $(this).data('id');
        let url = "{{ route('guru.data_nilai.show', ':id') }}".replace(':id', id);

        Swal.fire({ title: 'Memuat Analisis...', didOpen: () => Swal.showLoading() });

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    let d = response.data;
                    
                    // 1. INFO HEADER
                    $('#analisisNama').text(d.user ? d.user.name : 'User Hilang');
                    $('#analisisPaket').text(d.paket_soal ? d.paket_soal.judul : '-');
                    $('#analisisSkor').text(d.skor_akhir);
                    let date = new Date(d.created_at);
                    $('#analisisWaktu').text(date.toLocaleDateString('id-ID') + ' ' + date.toLocaleTimeString('id-ID'));

                    // 2. BUILD TABEL
                    let htmlHead = '';
                    let htmlBody = '';
                    let htmlDetail = '';
                    let totalBenar = 0;

                    if (d.jawaban_siswa && d.jawaban_siswa.length > 0) {
                        d.jawaban_siswa.forEach((item, index) => {
                            let no = index + 1;
                            // Logika Benar/Salah (1/0)
                            let isBenar = parseInt(item.benar) === 1; 
                            if(isBenar) totalBenar++;

                            // A. Matriks Horizontal
                            // Header (Putih/Abu tipis)
                            htmlHead += `<th class="py-2 fw-normal" style="min-width:40px;">${no}</th>`;
                            
                            // Body (Warna Soft: Hijau/Merah)
                            let bgClass = isBenar ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger';
                            let val = isBenar ? '1' : '0';
                            htmlBody += `<td class="py-2 ${bgClass}">${val}</td>`;

                            // B. Detail Vertikal
                            let textSoal = '-';
                            let imgHtml = '';
                            if (item.butir_soal && item.butir_soal.pertanyaan) {
                                let raw = item.butir_soal.pertanyaan;
                                try {
                                    let obj = (typeof raw === 'object') ? raw : JSON.parse(raw);
                                    textSoal = obj.text ? String(obj.text).replace(/<[^>]*>?/gm, '') : '-';
                                    if(obj.image) {
                                        imgHtml = `<div class="mt-1"><a href="${obj.image}" target="_blank"><img src="${obj.image}" class="img-thumbnail" style="height:40px;"></a></div>`;
                                    }
                                } catch(e) { textSoal = raw; }
                            }

                            let badgeStatus = isBenar 
                                ? '<span class="badge bg-success fw-normal">Benar</span>'
                                : '<span class="badge bg-danger fw-normal">Salah</span>';
                            
                            // Warna baris detail (Merah muda jika salah, Putih jika benar)
                            let rowColorDetail = isBenar ? '' : 'table-danger'; 

                            htmlDetail += `
                                <tr class="${rowColorDetail}">
                                    <td class="text-center text-secondary">${no}</td>
                                    <td>
                                        <div class="text-wrap" style="max-width: 450px; font-size: 0.9rem;">${textSoal}</div>
                                        ${imgHtml}
                                    </td>
                                    <td class="text-center fw-bold fs-6">${item.jawaban || '-'}</td>
                                    <td class="text-center fw-bold text-success fs-6">${item.butir_soal.kunci_jawaban || '-'}</td>
                                    <td class="text-center">${badgeStatus}</td>
                                </tr>
                            `;
                        });

                        // Kolom Total
                        htmlHead += `<th class="bg-light text-secondary border-start">Jumlah</th><th class="bg-light text-primary border-start">Nilai</th>`;
                        htmlBody += `<td class="fw-bold border-start bg-light">${totalBenar}</td><td class="fw-bold text-primary bg-light border-start">${d.skor_akhir}</td>`;

                    } else {
                        htmlHead = '<th>-</th>';
                        htmlBody = '<td>No Data</td>';
                        htmlDetail = '<tr><td colspan="5" class="text-center py-3">Tidak ada data detail.</td></tr>';
                    }

                    // Render HTML
                    $('#headNomorSoal').html(htmlHead);
                    $('#bodySkorSoal').html(htmlBody);
                    $('#bodyDetailVertikal').html(htmlDetail);

                    // RESET Accordion (Tutup Paksa setiap kali modal dibuka)
                    $('#collapseDetail').removeClass('show'); 
                    $('#headingDetail button').addClass('collapsed').attr('aria-expanded', 'false');

                    Swal.close();
                    myModalAnalisis.show();
                }
            },
            error: function() {
                Swal.fire('Error', 'Gagal memuat data', 'error');
            }
        });
    });
});
</script>
@endpush