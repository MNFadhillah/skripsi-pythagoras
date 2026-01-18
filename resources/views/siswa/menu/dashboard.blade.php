@extends('layouts.siswa')

@section('title', 'Dashboard • PythaLearn')

@section('content')
<div class="container-fluid">
    {{-- HEADER --}}
    <div class="row align-items-center mb-4">
        <div class="col-lg-8">
            <h3 class="mb-1">Dashboard</h3>
            <p class="text-muted mb-0">Selamat datang kembali, <strong>Muhammad Nur Fadhillah</strong>!</p>
        </div>
    </div>

    {{-- STAT KARTU RINGKAS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-primary border-2 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="text-muted mb-1">Progress Pembelajaran</h5>
                        <div class="d-flex align-items-center">
                            <h2 class="mb-0 me-2">75%</h2>
                            <div class="progress flex-grow-1" style="height: 10px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <p class="small text-muted mt-2">3 dari 4 bab selesai</p>
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
                        <h2 class="mb-0">85.5</h2>
                        <p class="small text-muted mt-2">Tertinggi: 95 (Bab 3)</p>
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
        <div class="card mb-3">
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
                        <h4 class="mb-1">Muhammad Nur Fadhillah</h4>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6 mb-2">
                        <div class="small text-muted">NISN</div>
                        <div class="fw-medium">1234567890</div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="small text-muted">Kelas</div>
                        <div class="fw-medium">VIII-A</div>
                    </div>
                </div>
            </div>
        </div>
      </div>
        
      <div class="col-lg-6">
          {{-- Profil Guru --}}
          <div class="card mb-3">
              <div class="card-header bg-success bg-opacity-10">
                  <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Profil Guru</h5>
              </div>
              <div class="card-body">
                  <div class="d-flex align-items-center mb-3">
                      <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center me-3"
                          style="width: 80px; height: 80px;">
                          <i class="bi bi-person-workspace fs-1"></i>
                      </div>
                      <div>
                          <h4 class="mb-1">Ahmad, S.Pd.</h4>
                      </div>
                  </div>
                  
                  <div class="row">
                      <div class="col-6 mb-2">
                          <div class="small text-muted">NIP</div>
                          <div class="fw-medium">197512152000121001</div>
                      </div>
                      <div class="col-6 mb-2">
                          <div class="small text-muted">Mata Pelajaran</div>
                          <div class="fw-medium">Matematika</div>
                      </div>
                  </div>
            </div>
        </div>
      </div>
    </div>

<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline-item {
        position: relative;
    }
    
    .timeline-marker {
        position: absolute;
        left: -30px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }
    
    .timeline-content {
        padding-bottom: 15px;
        border-left: 2px solid #e9ecef;
        padding-left: 15px;
    }
    
    .timeline-item:last-child .timeline-content {
        border-left: none;
    }
    
    .bg-purple {
        background-color: #6f42c1 !important;
    }
    
    .text-purple {
        color: #6f42c1 !important;
    }
</style>
@endsection