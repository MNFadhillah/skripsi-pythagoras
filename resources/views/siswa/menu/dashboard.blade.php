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
                                    Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>!
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
                {{-- === TAMPILAN JIKA BELUM MASUK KELAS (TETAP DIPISAH AGAR KONTRAS) === --}}
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
        <div class="col-md-4">
            <div class="card border-primary border-2 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="text-muted mb-1">Progress Pembelajaran</h5>
                        <div class="d-flex align-items-center">
                            <h2 class="mb-0 me-2">75%</h2>
                            <div class="progress flex-grow-1" style="height: 10px; width: 60px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                            </div>
                        </div>
                        <p class="small text-muted mt-2">Materi sedang berjalan</p>
                    </div>
                    <div class="display-6 text-primary">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-success border-2 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="text-muted mb-1">Perolehan Lencana</h5>
                        <h2 class="mb-0">4/8</h2>
                        <p class="small text-muted mt-2">Terakhir: "Ahli Pythagoras"</p>
                    </div>
                    <div class="display-6 text-success">
                        <i class="bi bi-patch-check-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-warning border-2 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="text-muted mb-1">Nilai Rata-rata</h5>
                        
                        {{-- PANGGIL VARIABEL RATA-RATA DISINI --}}
                        <h2 class="mb-0">{{ $rataRata }}</h2>
                        
                        <p class="small text-muted mt-2">
                            @if($rataRata >= 80)
                                Pertahankan prestasimu!
                            @elseif($rataRata > 0)
                                Terus tingkatkan belajarmu!
                            @else
                                Belum ada nilai masuk.
                            @endif
                        </p>
                    </div>
                    <div class="display-6 text-warning">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                </div>  
            </div>
        </div>
    </div>

    {{-- PROFIL & AKTIVITAS --}}
    <div class="row g-3 mb-4">
      <div class="col-lg-6">
        {{-- Profil Siswa --}}
        <div class="card mb-3 h-100">
            <div class="card-header bg-primary bg-opacity-10">
                <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Profil Siswa</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3"
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
                                <span class="badge bg-primary">{{ auth()->user()->kelas->nama_kelas }}</span>
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
                  <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Profil Guru</h5>
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

@endsection