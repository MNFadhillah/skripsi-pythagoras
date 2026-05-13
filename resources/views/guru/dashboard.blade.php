@extends('layouts.guru')

@section('title', 'Dashboard Guru - PythaLearn')

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
    @if(isset($hasClass) && !$hasClass)
    <div class="alert alert-info alert-dismissible fade show mb-3 border-0 shadow-sm" role="alert" style="background-color: #e8f5e9; color: #1b5e20;">
        <i class="bi bi-info-circle-fill me-2"></i>
        <strong>Informasi:</strong> Saat ini belum ada kelas yang ditugaskan kepada Anda. Anda tetap dapat menyiapkan <strong>Bank Soal</strong>, namun untuk mengelola siswa, silakan hubungi Administrator agar akun Anda ditautkan dengan kelas yang Anda ajar.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- === BAGIAN UCAPAN SELAMAT DATANG + INFO KELAS (DIPERKECIL) === --}}
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm border-0 bg-white rounded-3">
                <div class="card-body py-2 px-3">
                    <div class="row align-items-center">
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="me-2 bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                <i class="bi bi-person-workspace fs-5 text-primary"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Dashboard Guru</h5>
                                <p class="mb-0 text-muted small">
                                    Selamat datang, <strong>{{ auth()->user()->name }}</strong>!
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2 mt-md-0">
                            @if($hasClass)
                            <div class="bg-light rounded-3 p-2">
                                <h6 class="fw-bold mb-1 small"><i class="bi bi-house-door-fill text-success me-1"></i> Kelas yang Anda Ampu</h6>
                                @foreach($kelasList as $kelas)
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-1 mb-1">
                                    <div>
                                        <span class="fw-semibold small">{{ $kelas->nama_kelas }}</span>
                                        <small class="text-muted d-block" style="font-size: 0.7rem;">Token: {{ $kelas->token }}</small>
                                    </div>
                                    <span class="badge bg-success rounded-pill" style="font-size: 0.7rem;">{{ $kelas->siswa_count }} Siswa</span>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="bg-light rounded-3 p-2 text-center text-muted small border">
                                <i class="bi bi-journal-x fs-4 d-block mb-1"></i>
                                Belum ada kelas yang diampu.
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- === KARTU MENU DASHBOARD (UKURAN NORMAL) === --}}
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
                        <small class="text-muted">Informasi Kelas Anda</small>
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

@push('head')
<style>
    .hover-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        background-color: #fcfcfc;
    }
</style>
@endpush
@endsection