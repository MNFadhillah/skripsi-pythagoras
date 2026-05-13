@extends('layouts.admin')

@section('title', 'Dashboard Admin • PythaLearn')


@section('content')
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
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard Admin</h1>
    </div>

    <!-- Statistik Sederhana -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="bi bi-people fs-1 text-success"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Siswa</h6>
                            <h2 class="mb-0">{{ \App\Models\User::where('role','siswa')->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="bi bi-person-badge fs-1 text-info"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Guru</h6>
                            <h2 class="mb-0">{{ \App\Models\User::where('role','guru')->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="bi bi-layout-text-window fs-1 text-warning"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Kelas</h6>
                            <h2 class="mb-0">{{ \App\Models\Kelas::count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection