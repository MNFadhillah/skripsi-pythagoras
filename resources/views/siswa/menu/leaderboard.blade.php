@extends('layouts.siswa')

@section('title', 'Leaderboard - PythaLearn')

@section('content')
<div class="container-fluid">
  {{-- HEADER --}}
  <div class="row align-items-center mb-4">
      <div class="col-lg-8">
          <h3 class="mb-1">Leaderboard</h3>
      </div>
  </div>

  {{-- TABEL LEADERBOARD DINAMIS --}}
  <div class="card shadow-sm border-0">
      <div class="card-body p-0">
          <div class="table-responsive">
              <table class="table table-hover mb-0 align-middle">
                  <thead class="table-light">
                      <tr>
                          <th scope="col" class="ps-4">Peringkat</th>
                          <th scope="col">Nama</th>
                          <th scope="col">Kelas</th>
                          <th scope="col">Rata-rata</th>
                      </tr>
                  </thead>
                  <tbody>
                      @forelse($leaderboardSorted as $index => $data)
                          {{-- Cek apakah baris ini adalah user yang sedang login --}}
                          @php
                              $isCurrentUser = auth()->id() == $data['id'];
                              $rowClass = $isCurrentUser ? 'table-success fw-bold' : '';
                          @endphp

                          <tr class="{{ $rowClass }}">
                              {{-- Peringkat (Index + 1) --}}
                              <th scope="row" class="ps-4">
                                  @if($index + 1 == 1)1
                                  @elseif($index + 1 == 2)2
                                  @elseif($index + 1 == 3)3
                                  @else
                                      {{ $index + 1 }}
                                  @endif
                              </th>
                              
                              {{-- Nama Siswa --}}
                              <td>
                                  @if($isCurrentUser)
                                      <i class="bi bi-person-fill me-1"></i> {{ $data['nama'] }} (Kamu)
                                  @else
                                      {{ $data['nama'] }}
                                  @endif
                              </td>

                              {{-- Kelas --}}
                              <td>
                                  <span class="badge bg-light text-dark border">
                                      {{ $data['kelas'] }}
                                  </span>
                              </td>

                              {{-- Total Poin --}}
                              <td class="fw-bold text-primary">
                                  {{ $data['rata_rata'] }}
                              </td>
                          </tr>
                      @empty
                          <tr>
                              <td colspan="4" class="text-center py-5 text-muted">
                                  Belum ada data peringkat tersedia.
                              </td>
                          </tr>
                      @endforelse
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>
@endsection