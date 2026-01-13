@extends('layouts.guru')

@section('title', 'Dashboard Guru - PythaLearn')

@section('content')
  <!-- Main Dashboard Cards -->
  <div class="row mb-4">
    <div class="col-md-4 mb-3">
      <div class="dashboard-card">
        <div class="card-icon" style="background-color: #E8F5E9;">
          <i class="bi bi-people text-success"></i>
        </div>
        <h5>Data Siswa</h5>
      </div>
    </div>
    
    
    <div class="col-md-4 mb-3">
      <div class="dashboard-card">
        <div class="card-icon" style="background-color: #FFF3E0;">
          <i class="bi bi-list-check text-warning"></i>
        </div>
        <h5>Data Nilai</h5>
      </div>
    </div>
    
    <div class="col-md-4 mb-3">
      <div class="dashboard-card">
        <div class="card-icon" style="background-color: #E3F2FD;">
          <i class="bi bi-house text-primary"></i>
        </div>
        <h5>Data Kelas</h5>
      </div>
    </div>
  </div>

  <!-- Second Row Cards -->
  <div class="row mb-4">
    <div class="col-md-4 mb-3">
      <div class="dashboard-card">
        <div class="card-icon" style="background-color: #E8F5E9;">
          <i class="bi bi-journal-text text-success"></i>
        </div>
        <h5>Data Soal</h5>
      </div>
    </div>
    
    <div class="col-md-4 mb-3">
      <div class="dashboard-card">
        <div class="card-icon" style="background-color: #E0F7FA;">
          <i class="bi bi-calendar-check text-info"></i>
        </div>
        <h5>Aktivitas</h5>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="dashboard-card">
        <div class="card-icon" style="background-color: #F3E5F5;">
          <i class="bi bi-book text-purple"></i>
        </div>
        <h5>Data Pelajaran</h5>
      </div>
    </div>
  </div>

@endsection