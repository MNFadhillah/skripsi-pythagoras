@extends('layouts.siswa')

@section('title', 'Nilai Saya - PythaLearn')

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <h3>Nilai Saya</h3>
        </div>
    </div>

    {{-- 1. RANGKUMAN NILAI (TABEL ATAS) --}}
    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>Kuis 1</th>
                    <th>Kuis 2</th>
                    <th>Kuis 3</th>
                    <th>Kuis 4</th>
                    <th>Evaluasi</th>
                    <th class="bg-success text-white">Rata-rata</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach($rekapNilai as $item)
                    <td>
                        @if($item['nilai'] !== '-')
                        <span class="fw-bold">{{ $item['nilai'] }}</span>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                    @endforeach
                    <td class="fw-bold text-success" style="font-size: 1.1rem;">{{ $rataRata }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- 2. DROPDOWN PER KATEGORI (URUTAN TETAP) --}}
    <div class="row">
        <div class="col-12">
            <h3>Riwayat Pengerjaan</h3>
        </div>
    </div>
    @php
    $kkm = 70;
    $kategoriList = [
    ['id' => 'kuis-1', 'tag' => 'Kuis 1', 'keyword' => 'kuis 1'],
    ['id' => 'kuis-2', 'tag' => 'Kuis 2', 'keyword' => 'kuis 2'],
    ['id' => 'kuis-3', 'tag' => 'Kuis 3', 'keyword' => 'kuis 3'],
    ['id' => 'kuis-4', 'tag' => 'Kuis 4', 'keyword' => 'kuis 4'],
    ['id' => 'evaluasi', 'tag' => 'Evaluasi', 'keyword' => 'evaluasi'],
    ];
    @endphp

    <div class="accordion shadow-sm mb-5" id="accordionKategori">
        @foreach($kategoriList as $kat)
        @php
        // Cari data yang sesuai dengan keyword kategori ini
        $items = $riwayat->filter(function($row) use ($kat) {
        return str_contains(strtolower($row->paketSoal->judul ?? ''), $kat['keyword'])
        && $row->waktu_selesai != null;
        });
        @endphp

        <div class="accordion-item border-0 mb-2 shadow-sm rounded-3 overflow-hidden">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed bg-white text-dark fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $kat['id'] }}"> {{ $kat['tag'] }}
                    <span class="ms-2 badge bg-light text-muted border fw-normal" style="font-size: 0.7rem;">
                        {{ $items->count() }} Kali percobaan
                    </span>
                </button>
            </h2>
            <div id="{{ $kat['id'] }}" class="accordion-collapse collapse" data-bs-parent="#accordionKategori">
                <div class="accordion-body p-0 bg-light">
                    @if($items->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 bg-white">
                            <thead class="small text-muted bg-light">
                                <tr>
                                    <th class="ps-4">No</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Nilai</th>
                                    <th class="pe-4 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $idx => $row)
                                @php
                                $mulai = \Carbon\Carbon::parse($row->waktu_mulai)->timezone('Asia/Makassar');
                                $selesai = \Carbon\Carbon::parse($row->waktu_selesai)->timezone('Asia/Makassar');
                                $isLulus = $row->skor_akhir >= $kkm;
                                @endphp
                                <tr>
                                    <td class="ps-4">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $row->created_at->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $mulai->format('H:i') }} - {{ $selesai->format('H:i') }}</small>
                                    </td>
                                    <td class="fw-bold {{ $isLulus ? 'text-success' : 'text-danger' }}">
                                        {{ $row->skor_akhir }}
                                    </td>
                                    <td class="pe-4 text-center">
                                        <span class="badge {{ $isLulus ? 'bg-success' : 'bg-danger' }}">
                                            {{ $isLulus ? 'Tuntas' : 'Remedial' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-info-circle me-1"></i> Belum ada data pengerjaan untuk {{ $kat['tag'] }}.
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    .accordion-button:not(.collapsed) {
        color: #198754;
        background-color: #f8fdfa;
        box-shadow: none;
    }

    .accordion-button:focus {
        box-shadow: none;
    }

    .accordion-item {
        border: 1px solid #eee !important;
    }
</style>
@endsection