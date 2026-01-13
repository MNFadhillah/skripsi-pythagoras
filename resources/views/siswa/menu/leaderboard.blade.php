@extends('layouts.siswa')

@section('title', 'PythaLearn')

@section('content')
<div class="container-fluid">
  {{-- HEADER --}}
  <div class="row align-items-center mb-4">
      <div class="col-lg-8">
          <h3 class="mb-1">Leaderboard</h3>
      </div>
  </div>
  {{-- TABEL LEADERBOARD LENGKAP (STATIC) --}}
  <div class="card">
      <div class="card-body p-0">
          <div class="table-responsive">
              <table class="table table-hover mb-0 align-middle">
                  <thead class="table-light">
                      <tr>
                          <th scope="col">Peringkat</th>
                          <th scope="col">Nama</th>
                          <th scope="col">Kelas</th>
                          <th scope="col">Total Poin</th>
                      </tr>
                  </thead>
                  <tbody>
                      {{-- Contoh 1–10, statis --}}
                      <tr>
                          <th scope="row">1</th>
                          <td>Ahmad Sappauni</td>
                          <td>VIII A</td>
                          <td>92</td>
                      </tr>
                      <tr>
                          <th scope="row">2</th>
                          <td>Muhammad Salman</td>
                          <td>VIII B</td>
                          <td>89</td>
                      </tr>
                      <tr>
                          <th scope="row">3</th>
                          <td>Muhammad Rifqi</td>
                          <td>VIII C</td>
                          <td>87</td>
                      </tr>
                      <tr>
                          <th scope="row">4</th>
                          <td>Habibi</td>
                          <td>VIII A</td>
                          <td>85</td>
                      </tr>

                      {{-- Baris contoh untuk "kamu" (misal rank 7) --}}
                      <tr class="table-success">
                          <th scope="row">5</th>
                          <td><i class="bi bi-person-fill me-1"></i>Nama Kamu</td>
                          <td>VIII B</td>
                          <td>80</td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>
@endsection
