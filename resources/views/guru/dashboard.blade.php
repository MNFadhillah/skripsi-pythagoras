@extends('layouts.guru')

@section('title', 'Dashboard Guru - PythaLearn')

@section('content')
<div class="container-fluid px-4">

    {{-- === BAGIAN UCAPAN SELAMAT DATANG === --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 bg-white rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        {{-- Ikon Sambutan --}}
                        <div class="me-3 bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="bi bi-person-workspace fs-3 text-primary"></i>
                        </div>
                        
                        {{-- Teks Sambutan --}}
                        <div>
                            <h4 class="fw-bold mb-1">Dashboard Guru</h4>
                            <p class="mb-0 text-muted">
                                Selamat datang, <strong>{{ auth()->user()->name }}</strong>!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- === KARTU MENU DASHBOARD === --}}
    <div class="row g-4">
        
        {{-- Data Siswa --}}
        <div class="col-md-6 col-lg-4">
            <a href="{{ url('/guru/data_siswa') }}" class="card text-decoration-none shadow-sm border-0 h-100 hover-card">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="rounded-3 p-3 me-3 d-flex align-items-center justify-content-center" style="background-color: #E8F5E9; width: 60px; height: 60px;">
                        <i class="bi bi-people fs-3 text-success"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Data Siswa</h5>
                        <small class="text-muted">Kelola data siswa</small>
                    </div>
                </div>
            </a>
        </div>

        {{-- pencapaian Siswa --}}
        <div class="col-md-6 col-lg-4">
            <a href="{{ url('/guru/pencapaian_siswa') }}" class="card text-decoration-none shadow-sm border-0 h-100 hover-card">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="rounded-3 p-3 me-3 d-flex align-items-center justify-content-center" style="background-color: #E8F5E9; width: 60px; height: 60px;">
                        <i class="bi bi-graph-up fs-3 text-success"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Pencapaian Siswa</h5>
                        <small class="text-muted">Lihat Pencapaian belajar siswa</small>
                    </div>
                </div>
            </a>
        </div>
        
        {{-- Data Nilai --}}
        <div class="col-md-6 col-lg-4">
            <a href="{{ url('/guru/data_nilai') }}" class="card text-decoration-none shadow-sm border-0 h-100 hover-card">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="rounded-3 p-3 me-3 d-flex align-items-center justify-content-center" style="background-color: #FFF3E0; width: 60px; height: 60px;">
                        <i class="bi bi-list-check fs-3 text-warning"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Data Nilai</h5>
                        <small class="text-muted">Rekapitulasi nilai</small>
                    </div>
                </div>
            </a>
        </div>
        
        {{-- Data Kelas --}}
        <div class="col-md-6 col-lg-4">
            <a href="{{ url('/guru/data_kelas') }}" class="card text-decoration-none shadow-sm border-0 h-100 hover-card">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="rounded-3 p-3 me-3 d-flex align-items-center justify-content-center" style="background-color: #E3F2FD; width: 60px; height: 60px;">
                        <i class="bi bi-house fs-3 text-primary"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Data Kelas</h5>
                        <small class="text-muted">Manajemen kelas</small>
                    </div>
                </div>
            </a>
        </div>

        {{-- Paket Soal --}}
        <div class="col-md-6 col-lg-4">
            <a href="{{ url('/guru/paket_soal') }}" class="card text-decoration-none shadow-sm border-0 h-100 hover-card">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="rounded-3 p-3 me-3 d-flex align-items-center justify-content-center" style="background-color: #E8F5E9; width: 60px; height: 60px;">
                        <i class="bi bi-box fs-3 text-success"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Paket Soal</h5>
                        <small class="text-muted">Bank soal</small>
                    </div>
                </div>
            </a>
        </div>
        
        {{-- Data Soal --}}
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('guru.data_soal') }}" class="card text-decoration-none shadow-sm border-0 h-100 hover-card">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="rounded-3 p-3 me-3 d-flex align-items-center justify-content-center" style="background-color: #E0F7FA; width: 60px; height: 60px;">
                        <i class="bi bi-journal-text fs-3 text-info"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Data Soal</h5>
                        <small class="text-muted">Daftar pertanyaan</small>
                    </div>
                </div>
            </a>
        </div>

        {{-- Aktivitas Siswa --}}
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('guru.aktivitas.index') }}" class="card text-decoration-none shadow-sm border-0 h-100 hover-card">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="rounded-3 p-3 me-3 d-flex align-items-center justify-content-center" style="background-color: #F3E5F5; width: 60px; height: 60px;">
                        <i class="bi bi-book fs-3" style="color: #9c27b0;"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Aktivitas Siswa</h5>
                        <small class="text-muted">Log pembelajaran</small>
                    </div>
                </div>
            </a>
        </div>

    </div>

</div>

{{-- Tambahan CSS Sedikit agar interaktif --}}
@push('head')
<style>
    .hover-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        background-color: #fcfcfc;
    }
</style>
@endpush

@endsection