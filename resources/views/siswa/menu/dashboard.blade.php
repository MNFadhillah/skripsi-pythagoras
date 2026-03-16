@extends('layouts.siswa')

@section('title', 'Dashboard • PythaLearn')

@section('content')
<div class="container-fluid">
    
    {{-- Notifikasi Error/Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- === BAGIAN HEADER DASHBOARD === --}}
    <div class="row mb-4">
        <div class="col-12">
            
            @if(auth()->user()->kelas_id)
                {{-- === TAMPILAN JIKA SUDAH MASUK KELAS (FULL HIJAU) === --}}
                <div class="card shadow-sm border-0 text-white overflow-hidden" 
                     style="background: linear-gradient(135deg, #198754, #20c997);">
                    
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            
                            {{-- BAGIAN KIRI: Welcome Message --}}
                            <div class="col-md-6 border-end border-white border-opacity-25 mb-3 mb-md-0">
                                <h3 class="fw-bold mb-1">Dashboard</h3>
                                <p class="mb-0 opacity-90">
                                    Selamat datang, <strong>{{ auth()->user()->name }}</strong>!
                                </p>
                            </div>

                            {{-- BAGIAN KANAN: Info Kelas --}}
                            <div class="col-md-6 ps-md-4">
                                <h6 class="text-uppercase ls-1 opacity-75 mb-1" style="font-size: 0.8rem;">
                                    Kelas Anda
                                </h6>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h2 class="fw-bold mb-0 display-6">
                                            {{ auth()->user()->kelas->nama_kelas ?? 'Error' }}
                                        </h2>
                                        <p class="mb-0 mt-1 opacity-90 small">
                                            <i class="bi bi-person-badge me-1"></i> 
                                            Guru: {{ auth()->user()->kelas->guru->name ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            @else
                {{-- === TAMPILAN JIKA BELUM MASUK KELAS === --}}
                <div class="row align-items-center">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h3 class="mb-1">Dashboard</h3>
                        <p class="text-muted mb-0">Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>!</p>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-warning shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="text-warning me-2">
                                        <i class="bi bi-exclamation-circle-fill fs-5"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-0">Belum Masuk Kelas?</h6>
                                        <small class="text-muted">Masukkan token dari gurumu.</small>
                                    </div>
                                </div>
                                <form action="{{ route('siswa.gabung.kelas') }}" method="POST">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="token" class="form-control form-control-sm border-warning" placeholder="Token (cth: X7Y2Z)" required style="text-transform:uppercase;">
                                        <button class="btn btn-warning btn-sm text-white fw-bold" type="submit">Gabung</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
    {{-- === END HEADER === --}}


    {{-- STAT KARTU RINGKAS --}}
    <div class="row g-3 mb-4">  
        
        {{-- Kartu Progress --}}
        <div class="col-md-6">
            <div class="card border-success border-2 h-100 position-relative badge-card-hover">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="text-muted mb-1">Progress Pembelajaran</h5>
                        <div class="d-flex align-items-center">
                            
                            {{-- MUNCULKAN ANGKA PERSENTASE DI SINI --}}
                            <h2 class="mb-0 me-2 text-success">{{ $totalProgressKeseluruhan }}%</h2>
                            
                            <div class="progress flex-grow-1" style="height: 10px; width: 60px;">
                                {{-- UBAH LEBAR BAR SESUAI PERSENTASE --}}
                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $totalProgressKeseluruhan; ?>%"></div>
                            </div>
                        </div>
                        
                        {{-- TEKS DINAMIS BERDASARKAN PROGRESS --}}
                        <p class="small mt-2 mb-0 fw-semibold {{ $totalProgressKeseluruhan == 100 ? 'text-success' : 'text-muted' }}">
                            @if($totalProgressKeseluruhan == 100)
                                <i class="bi bi-check-circle-fill me-1"></i> Materi Selesai
                            @elseif($totalProgressKeseluruhan > 0)
                                Materi sedang berjalan...
                            @else
                                Belum ada progress
                            @endif
                        </p>
                        
                    </div>
                </div>

                {{-- TRIGGER UNTUK MEMBUKA MODAL PROGRES --}}
                <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#modalDetailProgres" onclick="loadDetailProgres()"></a>
            </div>
        </div>
        
        {{-- Kartu Lencana (Hijau, Dinamis & Bisa Diklik) --}}
        <div class="col-md-6">
            <div class="card border-success border-2 h-100 position-relative badge-card-hover">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="text-muted mb-1">Perolehan Lencana</h5>
                        
                        {{-- ANGKA LENCANA DINAMIS --}}
                        <h2 class="mb-0 text-success">{{ $earnedBadgesCount }}/{{ $totalBadgesCount }}</h2>
                        
                        {{-- NAMA LENCANA TERAKHIR DINAMIS --}}
                        <p class="small text-muted mt-2 mb-0">
                            Terakhir: <strong class="text-success">"{{ $lastBadgeName }}"</strong>
                        </p>
                    </div>
                </div>
                
                {{-- TRIGGER UNTUK MEMBUKA MODAL LENCANA --}}
                <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#modalLencana"></a>
            </div>
        </div>

    </div>

    {{-- PROFIL & AKTIVITAS --}}
    <div class="row g-3 mb-4">
      <div class="col-lg-6">
        {{-- Profil Siswa --}}
        <div class="card mb-3 h-100">
            <div class="card-header bg-success bg-opacity-10">
                <h5 class="mb-0 text-success"><i class="bi bi-person-circle me-2"></i>Profil Siswa</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center me-3"
                        style="width: 80px; height: 80px;">
                        <i class="bi bi-person-fill fs-1"></i>
                    </div>
                    <div>
                        <h4 class="mb-1">{{ auth()->user()->name }}</h4>
                        <small class="text-muted">{{ auth()->user()->email }}</small>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6 mb-2">
                        <div class="small text-muted">Status</div>
                        <div class="fw-medium text-capitalize">{{ auth()->user()->role }}</div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="small text-muted">Kelas</div>
                        <div class="fw-medium">
                            @if(auth()->user()->kelas)
                                <span class="badge bg-success">{{ auth()->user()->kelas->nama_kelas }}</span>
                            @else
                                <span class="badge bg-secondary">Belum Masuk Kelas</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
        
      <div class="col-lg-6">
          {{-- Profil Guru --}}
          <div class="card mb-3 h-100">
              <div class="card-header bg-success bg-opacity-10">
                  <h5 class="mb-0 text-success"><i class="bi bi-person-badge me-2"></i>Profil Guru</h5>
              </div>
              <div class="card-body">
                  @if(auth()->user()->kelas)
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center me-3"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-person-workspace fs-1"></i>
                        </div>
                        <div>
                            <h4 class="mb-1">{{ auth()->user()->kelas->guru->name ?? 'Nama Guru Tidak Tersedia' }}</h4>
                            <p class="mb-0 text-muted small">Guru Matematika</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-6 mb-2">
                            <div class="small text-muted">Email</div>
                            <div class="fw-medium text-break">{{ auth()->user()->kelas->guru->email ?? '-' }}</div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="small text-muted">Kode Kelas</div>
                            <div class="fw-medium font-monospace">{{ auth()->user()->kelas->token }}</div>
                        </div>
                    </div>
                  @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                        <p>Silakan bergabung ke kelas terlebih dahulu untuk melihat profil guru Anda.</p>
                    </div>
                  @endif
              </div>
          </div>
      </div>
    </div>

</div>

{{-- === MODAL KOLEKSI LENCANA === --}}
<div class="modal fade" id="modalLencana" tabindex="-1" aria-labelledby="modalLencanaLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded">
            
            <div class="modal-header border-0 bg-success text-white py-3">
                <h4 class="modal-title text-white fw-bold ms-2 mt-2" id="modalLencanaLabel">Koleksi Lencana
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>

                
            </div>
            
            <div class="modal-body p-4 pt-2 bg-success bg-opacity-10" style="min-height: 50vh">
                <p class="text-muted text-center mb-4 ">
                    Selesaikan materi dan kuis untuk mendapatkan semua lencana!
                </p>
                <div class="row justify-content-center g-4 mt-5 pt-4">

                    @forelse($allBadges as $badge)
                        @php
                            $isEarned = in_array($badge->id, $earnedBadgeIds);
                            
                            // --- LOGIKA DINAMIS TEKS TOOLTIP ---
                            $teksTooltip = $badge->description;
                            
                            // Jika BELUM didapat, ubah teks deskripsi menjadi kalimat petunjuk (Clue)
                            if (!$isEarned) {
                                $teksTooltip = str_replace('Berhasil menyelesaikan', 'Selesaikan', $teksTooltip);
                                $teksTooltip = str_replace('Berhasil menuntaskan', 'Tuntaskan', $teksTooltip);
                                $teksTooltip = str_replace('Berhasil lulus dari', 'Luluslah dari', $teksTooltip);
                                $teksTooltip = str_replace('Luar Biasa! Telah menyelesaikan', 'Selesaikan', $teksTooltip);
                            }
                        @endphp

                        <div class="col-4 col-sm-3 col-md-2 text-center badge-container">
                            
                            {{-- Gambar Lencana --}}
                            <img src="{{ asset('images/badges/' . $badge->image_path) }}" 
                                 alt="{{ $badge->name }}" 
                                 class="img-fluid badge-modal-img {{ $isEarned ? '' : 'locked-badge' }}">
                            
                            {{-- Nama Lencana --}}
                            <div class="mt-2 fw-bold {{ $isEarned ? 'text-success' : 'text-muted' }}" style="font-size: 0.75rem; text-transform: uppercase;">
                                {{ $badge->name }}
                            </div>

                            {{-- KOTAK CLUE / TOOLTIP --}}
                            <div class="custom-badge-tooltip shadow-sm">
                                {{ $teksTooltip }}
                            </div>

                        </div>
                    @empty
                        <div class="col-12 text-center text-muted py-4">
                            Data lencana belum tersedia.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
{{-- === MODAL DETAIL PROGRES SISWA === --}}
    <div class="modal fade" id="modalDetailProgres" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content rounded border-0 shadow">
                
                {{-- Header Modal --}}
                <div class="modal-header bg-success text-white py-3">
                    <h5 class="modal-title fw-bold">Progres Belajar</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body p-4 bg-light">
                    
                    {{-- Box Info Siswa & Total Progress --}}
                    <div class="bg-white rounded-3 p-4 mb-4 shadow-sm border">
                        <div class="row">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <span class="text-muted small d-block mb-1">Nama Siswa</span> 
                                <span class="text-dark fw-bold fs-5">{{ auth()->user()->name }}</span>
                            </div>
                            <div class="col-md-6 border-start">
                                <span class="text-muted small d-block mb-1">Kelas</span> 
                                <span class="text-dark fw-bold fs-5">
                                    {{ auth()->user()->kelas->nama_kelas ?? 'Belum Masuk Kelas' }}
                                </span>
                            </div>
                        </div>
                        
                        {{-- Bar Progress Keseluruhan --}}
                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-end mb-2">
                                <span class="text-dark fw-bold">Progres Keseluruhan</span>
                                <span class="fw-bold fs-4 {{ $totalProgressKeseluruhan == 100 ? 'text-success' : 'text-primary' }}">
                                    {{ $totalProgressKeseluruhan }}%
                                </span>
                            </div>
                            <div class="progress rounded-pill bg-light border" style="height: 14px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated rounded-pill {{ $totalProgressKeseluruhan == 100 ? 'bg-success' : 'bg-primary' }}" 
                                     role="progressbar" style="width: <?php echo e($totalProgressKeseluruhan); ?>%;"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Kontainer List Progres (Akan Diisi oleh Javascript) --}}
                    <div class="bg-white rounded-3 p-4 shadow-sm border" id="dtl_content">
                        <div class="text-center py-5">
                            <div class="spinner-border text-success" role="status"></div>
                            <p class="mt-2 text-muted fw-bold">Memuat data progres...</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
{{-- Tambahan CSS Sedikit agar interaktif --}}
@push('head')
<style>
    .badge-card-hover {
        transition: all 0.2s ease-in-out;
    }
    .badge-card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(40, 167, 69, 0.2) !important;
    }

    /* Efek untuk gambar lencana di modal */
    .badge-modal-img {
        max-width: 90px;
        width: 100%;
        transition: transform 0.3s ease;
        cursor: help; /* Kursor berubah jadi tanda tanya/bantuan */
    }
    
    .locked-badge {
        filter: grayscale(100%) brightness(65%) contrast(120%); 
        opacity: 0.85;
    }

    /* === STYLING CUSTOM TOOLTIP (CLUE) === */
.badge-container {
        position: relative; 
    }

    .custom-badge-tooltip {
        position: absolute;
        bottom: 100%; /* Kembali ke atas */
        left: 50%;
        transform: translateX(-50%) translateY(10px);
        background-color: #155724; 
        color: #ffffff;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        width: 150px;
        text-align: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55); 
        z-index: 1055;
        pointer-events: none; 
        margin-bottom: 15px; /* Jarak antara tooltip dan gambar lencana */
    }

    /* Segitiga panah ke bawah */
    .custom-badge-tooltip::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -6px;
        border-width: 6px;
        border-style: solid;
        border-color: #155724 transparent transparent transparent;
    }

    /* Munculkan tooltip ke atas saat di-hover */
    .badge-container:hover .custom-badge-tooltip {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(-10px); /* Efek melompat ke atas */
    }
    .badge-container:hover .badge-modal-img {
        transform: scale(1.1);
    }
</style>
@endpush

@push('scripts')
<script>
    function loadDetailProgres() {
    const contentBox = document.getElementById('dtl_content');
    
    // Tampilkan loading
    contentBox.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-success" role="status"></div>
            <p class="mt-2 text-muted fw-bold">Memuat data progres...</p>
        </div>
    `;

    // Fetch data dari server
    fetch('/siswa/progres-detail', {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(res => {
        // Fungsi renderRow
        const renderRow = (title, percent, info = '') => {
            let statusHtml = '';
            let barColor = '';

            if (percent === 100) {
                statusHtml = '<span class="text-success">Selesai</span>';
                barColor = 'bg-success';
            } else if (percent > 0) {
                statusHtml = `<span class="text-primary">${percent}%</span>`;
                barColor = 'bg-primary';
            } else {
                statusHtml = '<span class="text-muted">Belum dikerjakan</span>';
                barColor = 'bg-secondary';
            }

            let infoHtml = info && info !== 'Locked' 
                ? `<span class="text-muted fw-normal small ms-1">(${info})</span>` 
                : '';

            return `
                <div class="py-3 border-bottom border-light">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="text-dark fw-bold" style="font-size: 0.95rem;">
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

        // Update total progress di header modal (jika elemen dengan ID ada)
        const totalBarColor = res.total_progress === 100 ? 'bg-success' : 'bg-primary';
        const totalTextColor = res.total_progress === 100 ? 'text-success' : 'text-primary';
        
        const elTotalText = document.getElementById('modal-total-text');
        const elTotalBar = document.getElementById('modal-total-bar');
        if(elTotalText && elTotalBar) {
            elTotalText.className = `fw-bold fs-4 ${totalTextColor}`;
            elTotalText.innerText = `${res.total_progress}%`;
            elTotalBar.className = `progress-bar progress-bar-striped progress-bar-animated rounded-pill ${totalBarColor}`;
            elTotalBar.style.width = `${res.total_progress}%`;
        }

        // Section Materi
        html += '<div class="mb-4">';
        html += '<div class="border-bottom pb-2 mb-3"><h6 class="fw-bold text-success text-uppercase mb-0" style="font-size: 0.85rem; letter-spacing: 1px;"><i class="bi bi-book-half me-2"></i>Materi Pembelajaran</h6></div>';
        html += renderRow(res.materi.m1.nama, res.materi.m1.persen, res.materi.m1.info);
        html += renderRow(res.materi.m2.nama, res.materi.m2.persen, res.materi.m2.info);
        html += renderRow(res.materi.m3.nama, res.materi.m3.persen, res.materi.m3.info);
        html += renderRow(res.materi.m4.nama, res.materi.m4.persen, res.materi.m4.info);
        html += '</div>';

        // Section Kuis & Evaluasi
        html += '<div class="mt-5">';
        html += '<div class="border-bottom pb-2 mb-3"><h6 class="fw-bold text-success text-uppercase mb-0" style="font-size: 0.85rem; letter-spacing: 1px;"><i class="bi bi-pencil-square me-2"></i>Kuis & Evaluasi</h6></div>';
        html += renderRow(res.kuis.k1.nama, res.kuis.k1.persen);
        html += renderRow(res.kuis.k2.nama, res.kuis.k2.persen);
        html += renderRow(res.kuis.k3.nama, res.kuis.k3.persen);
        html += renderRow(res.kuis.k4.nama, res.kuis.k4.persen);
        html += renderRow(res.kuis.eval.nama, res.kuis.eval.persen);
        html += '</div>';

        contentBox.innerHTML = html;
    })
    .catch(error => {
        console.error('Gagal memuat detail progres:', error);
        contentBox.innerHTML = '<div class="alert alert-danger">Gagal memuat data. Silakan coba lagi.</div>';
    });
}
</script>
@endpush

@endsection