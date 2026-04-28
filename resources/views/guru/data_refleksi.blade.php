@extends('layouts.guru')

@section('title', 'Data Refleksi Siswa • PythaLearn')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <h4 class="fw-bold mb-0">Data Refleksi Siswa</h4>

            {{-- Sembunyikan filter jika guru tidak punya kelas --}}
            @if($hasClass && $dataRefleksi->isNotEmpty())
            <div class="d-flex align-items-center">
                <label for="filterMateri" class="fw-semibold me-2 text-nowrap">Filter Materi:</label>
                <select id="filterMateri" class="form-select form-select-sm shadow-none border-secondary text-success fw-semibold">
                    <option value="">Semua Materi</option>
                    <option value="Konsep Pythagoras">Konsep Pythagoras</option>
                    <option value="Tripel Pythagoras">Tripel Pythagoras</option>
                    <option value="Segitiga Istimewa">Segitiga Istimewa</option>
                    <option value="Penerapan Pythagoras">Penerapan Pythagoras</option>
                </select>
            </div>
            @endif
        </div>
    </div>

    {{-- Logika Penampilan Data --}}
    @if(!$hasClass)
        {{-- EMPTY STATE: GURU BELUM PUNYA KELAS --}}
        <div class="card shadow-sm border-0 bg-white rounded-3 mt-4">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle" style="width: 100px; height: 100px;">
                        <i class="bi bi-journal-x text-muted" style="font-size: 3rem;"></i>
                    </div>
                </div>
                <h5 class="fw-bold text-dark">Akses Terbatas</h5>
                <p class="text-muted mb-4">Anda belum ditugaskan untuk mengampu kelas manapun. Data refleksi siswa akan muncul setelah akun Anda ditautkan dengan sebuah kelas.</p>
            </div>
        </div>

    @elseif($dataRefleksi->isEmpty())
        {{-- EMPTY STATE: GURU PUNYA KELAS, TAPI BELUM ADA SISWA YANG MENGISI REFLEKSI --}}
        <div class="card shadow-sm border-0 bg-white rounded-3 mt-4">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle" style="width: 100px; height: 100px;">
                        <i class="bi bi-clipboard-x text-muted" style="font-size: 3rem;"></i>
                    </div>
                </div>
                <h5 class="fw-bold text-dark">Belum Ada Refleksi</h5>
                <p class="text-muted mb-0">Siswa di kelas Anda belum ada yang mengirimkan data refleksi pembelajaran.</p>
            </div>
        </div>

    @else
        {{-- TABEL UTAMA: DATA TERSEDIA --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabelRefleksi" class="table table-hover align-middle w-100">
                        <thead class="table-light">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="25%">Nama Siswa</th>
                                <th width="30%">Subbab Materi</th>
                                <th width="20%">Waktu Pengerjaan</th>
                                <th width="20%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataRefleksi as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td><strong>{{ $item->user->name ?? 'Siswa Dihapus' }}</strong></td>
                                <td>{{ ucwords(str_replace('_', ' ', $item->kode_materi)) }}</td>
                                <td>{{ $item->created_at->translatedFormat('d M Y, H:i') }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalRefleksi{{ $item->id }}">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- MODAL AREA (Berada di dalam @else tapi di luar tag tabel) --}}
        @foreach ($dataRefleksi as $item)
        <div class="modal fade" id="modalRefleksi{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-success text-white border-bottom-0">
                        <h5 class="modal-title fw-bold">Detail Refleksi Pembelajaran</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start pt-4">
                        <div class="alert alert-light border mb-4 shadow-sm">
                            <div class="row">
                                <div class="col-sm-6 mb-2 mb-sm-0">
                                    <span class="d-block small text-muted">Nama Siswa:</span>
                                    <strong class="text-dark fs-6">{{ $item->user->name ?? 'Anonim' }}</strong>
                                </div>
                                <div class="col-sm-6">
                                    <span class="d-block small text-muted">Materi Refleksi:</span>
                                    <strong class="text-success fs-6">{{ ucwords(str_replace('_', ' ', $item->kode_materi)) }}</strong>
                                </div>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-3 border-bottom pb-2">Jawaban Siswa:</h6>
                        
                        @if(is_array($item->jawaban))
                            @foreach($item->jawaban as $kunci => $jawaban)
                            <div class="mb-4">
                                <span class="d-block text-success small fw-bold text-uppercase mb-2">
                                    <i class="bi bi-chat-square-quote me-1"></i> {{ str_replace('_', ' ', $kunci) }}
                                </span>
                                <div class="p-3 bg-light rounded-3 border-start border-4 border-success text-dark">
                                    {{ $jawaban }}
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p class="text-muted text-center py-3">Format data tidak valid.</p>
                        @endif
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Cek apakah tabel ada sebelum inisialisasi (mencegah error jika masuk ke empty state)
        if ($('#tabelRefleksi').length > 0) {
            var table = $('#tabelRefleksi').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                },
                ordering: true,
                info: true,
                lengthChange: true,
                pageLength: 10,
                columnDefs: [
                    { orderable: false, targets: 4 },
                    { className: "text-center", targets: [0, 3, 4] }
                ]
            });

            // Logika Filter Kustom
            $('#filterMateri').on('change', function() {
                var materi = $(this).val();
                table.column(2).search(materi).draw();
            });
        }
    });
</script>
@endpush