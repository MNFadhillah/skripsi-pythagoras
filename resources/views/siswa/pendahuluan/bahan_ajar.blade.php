@extends('layouts.siswa')

@section('title', 'Bahan Ajar - PythaLearn')

@section('content')
<div class="row align-items-center mb-2">
    <div class="col-lg-8">
        <h3 class="mb-1">Bahan Ajar</h3>
    </div>
</div>

<section class="mb-4">
    <div class="card h-100">
        <div class="card-body p-0">
            @if($fileExists)
                <iframe
                    src="{{ $previewRoute }}#toolbar=1&navpanes=0&scrollbar=1&view=FitH"
                    style="width: 100%; height: 78vh; border: none;"
                    title="Preview Bahan Ajar Teorema Pythagoras">
                </iframe>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-file-earmark-x fs-1 text-muted"></i>
                    <p class="text-muted mt-3 mb-0">File bahan ajar belum tersedia.</p>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-3">
        @if($fileExists)
            <a href="{{ $downloadRoute }}" class="btn btn-success">
                <i class="bi bi-download me-2"></i>Download Bahan Ajar
            </a>
        @else
            <button class="btn btn-secondary" disabled>
                <i class="bi bi-exclamation-circle me-2"></i>File belum tersedia
            </button>
        @endif
    </div>
</section>
@endsection