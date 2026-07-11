@extends('layouts.guru')

@section('title', 'Bahan Ajar • PythaLearn')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">Bahan Ajar</h4>
        </div>
    </div>

    {{-- Preview / Empty State --}}
    @if(!$fileExists)
        <div class="card shadow-sm border-0 bg-white rounded-3 mt-4">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle"
                        style="width: 100px; height: 100px;">
                        <i class="bi bi-file-earmark-x text-muted" style="font-size: 3rem;"></i>
                    </div>
                </div>
                <h5 class="fw-bold text-dark">File Bahan Ajar Belum Tersedia</h5>
                <p class="text-muted mb-0">
                    File bahan ajar belum dapat ditampilkan. Silakan hubungi Administrator untuk memperbarui file.
                </p>
            </div>
        </div>
    @else
        <div class="card shadow-sm border-1 mt-4">
            <div class="card-body p-0">
                <iframe
                    src="{{ $previewRoute }}#toolbar=1&navpanes=0&scrollbar=1&view=FitH"
                    style="width: 100%; height: 78vh; border: none;"
                    title="Preview Bahan Ajar Teorema Pythagoras">
                </iframe>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ $downloadRoute }}" class="btn btn-success">
                <i class="bi bi-download me-2"></i>Download Bahan Ajar
            </a>
        </div>
    @endif

</div>
@endsection