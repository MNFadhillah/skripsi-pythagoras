@extends('layouts.guru')

@section('title', 'Dashboard Guru - PythaLearn')

@section('content')

  {{-- === BAGIAN UCAPAN SELAMAT DATANG (BARU) === --}}
  <div class="row mb-4">
    <div class="col-12">
      <div class="card shadow-sm border-0 bg-white">
        <div class="card-body p-4">
          <div class="d-flex align-items-center">
            {{-- Ikon Sambutan (Opsional) --}}
            <div class="me-3 bg-light rounded-circle p-3 text-primary">
              <i class="bi bi-person-workspace fs-3"></i>
            </div>
            
            {{-- Teks Sambutan --}}
            <div>
              <h4 class="fw-bold mb-1">Dashboard Guru</h4>
              <p class="mb-0 text-muted">
                Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>! 
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- === KARTU MENU DASHBOARD === --}}
  
  <div class="row mb-4">
    
    <div class="col-md-4 mb-3">
      <a href="{{ url('/guru/data_siswa') }}" class="dashboard-card text-decoration-none text-dark h-100 d-block">
        <div class="card-icon" style="background-color: #E8F5E9;">
          <i class="bi bi-people text-success"></i>
        </div>
        <h5>Data Siswa</h5>
      </a>
    </div>
    
    <div class="col-md-4 mb-3">
      <a href="{{ url('/guru/data_nilai') }}" class="dashboard-card text-decoration-none text-dark h-100 d-block">
        <div class="card-icon" style="background-color: #FFF3E0;">
          <i class="bi bi-list-check text-warning"></i>
        </div>
        <h5>Data Nilai</h5>
      </a>
    </div>
    
    <div class="col-md-4 mb-3">
      <a href="{{ url('/guru/data_kelas') }}" class="dashboard-card text-decoration-none text-dark h-100 d-block">
        <div class="card-icon" style="background-color: #E3F2FD;">
          <i class="bi bi-house text-primary"></i>
        </div>
        <h5>Data Kelas</h5>
      </a>
    </div>
  </div>

  <div class="row mb-4">
    
    <div class="col-md-4 mb-3">
      <a href="{{ url('/guru/paket_soal') }}" class="dashboard-card text-decoration-none text-dark h-100 d-block">
        <div class="card-icon" style="background-color: #E8F5E9;">
          <i class="bi bi-box text-success"></i>
        </div>
        <h5>Paket Soal</h5>
      </a>
    </div>
    
    <div class="col-md-4 mb-3">
      <a href="{{ route('guru.data_soal') }}" class="dashboard-card text-decoration-none text-dark h-100 d-block">
        <div class="card-icon" style="background-color: #E0F7FA;">
          <i class="bi bi-journal-text text-info"></i>
        </div>
        <h5>Data Soal</h5>
      </a>
    </div>

    <div class="col-md-4 mb-3">
      <a href="{{ route('guru.aktivitas.index') }}" class="dashboard-card text-decoration-none text-dark h-100 d-block">
        <div class="card-icon" style="background-color: #F3E5F5;">
          <i class="bi bi-book text-purple"></i>
        </div>
        <h5>Aktivitas Siswa</h5>
      </a>
    </div>
  </div>

@endsection