@extends('layouts.siswa')

@section('title', 'Nilai Saya - PythaLearn')

@section('content')
<div class="container-fluid">
    
    <div class="row mb-4">
        <div class="col-12">
            <h3><i class="fas fa-star text-warning"></i> Nilai</h3>
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 font-weight-bold">Rangkuman Hasil Pengerjaan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="thead-light">
                        <tr>
                            @foreach($rekapNilai as $item)
                                <th>{{ $item['nama_paket'] }}</th>
                            @endforeach
                            <th class="bg-success text-white">Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach($rekapNilai as $item)
                                <td>
                                    @if($item['nilai'] !== '-')
                                        <span class="font-weight-bold">
                                            {{ $item['nilai'] }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            @endforeach
                            <td class="font-weight-bold">{{ $rataRata }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 text-secondary font-weight-bold">Riwayat Detail Pengerjaan</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            {{-- TAMBAHKAN ID DISINI --}}
            <table class="table table-hover" id="tabelRiwayat">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Aktivitas</th>
                        <th>Tanggal</th>
                        <th>Waktu Pengerjaan</th>
                        <th>Nilai</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $index => $row)
                    
                    @php
                        // LOGIC PERHITUNGAN NILAI
                        $skorMurni = $row->skor_akhir;
                        $nilaiAkhir = $skorMurni;
                        $kkm = 70;
                        $isLulus = $nilaiAkhir >= $kkm;
                    @endphp

                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $row->paketSoal->judul ?? 'Paket #' . $row->paket_soal_id }}</strong>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($row->created_at)->translatedFormat('d M Y') }}
                        </td>
                        <td>
                            @php
                                $mulai = \Carbon\Carbon::parse($row->waktu_mulai);
                                $selesai = \Carbon\Carbon::parse($row->waktu_selesai);
                                $durasi = $mulai->diffInMinutes($selesai);
                            @endphp
                            {{ $mulai->format('H:i') }} - {{ $selesai->format('H:i') }} 
                            <small class="text-muted">({{ $durasi }} menit)</small>
                        </td>
                        
                        {{-- BAGIAN NILAI --}}
                        <td>
                            @if($isLulus)
                                <span style="font-size: 1.1em;">{{ $nilaiAkhir }}</span>
                            @else
                                <span style="font-size: 1.1em;">{{ $nilaiAkhir }}</span>
                            @endif
                        </td>

                        {{-- BAGIAN STATUS --}}
                        <td>
                            @if($isLulus)
                                <span class="text-success font-weight-bold">Tuntas</span>
                            @else
                                <span class="text-danger font-weight-bold">Belum Tuntas</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    {{-- Kosongkan body jika tidak ada data agar DataTables tidak error --}}
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection