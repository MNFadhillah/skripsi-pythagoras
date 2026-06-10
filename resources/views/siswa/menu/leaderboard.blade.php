@extends('layouts.siswa')

@section('title', 'Leaderboard - PythaLearn')

@push('head')
<style>
    .leaderboard-card {
        border: 0;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
    }

    .top-rank-card {
        border-radius: 14px;
        border: 1px solid #e9ecef;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        height: 100%;
    }

    .top-rank-card.rank-1 {
        border-top: 4px solid #ffc107;
    }

    .top-rank-card.rank-2 {
        border-top: 4px solid #adb5bd;
    }

    .top-rank-card.rank-3 {
        border-top: 4px solid #cd7f32;
    }

    .top-avatar {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #198754;
    }

    .table-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #198754;
    }

    .avatar-placeholder-top {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        background-color: #e9f7ef;
        color: #198754;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 30px;
    }

    .avatar-placeholder-table {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background-color: #e9f7ef;
        color: #198754;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .rank-circle {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background-color: #e9f7ef;
        color: #198754;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .current-user-row {
        background-color: #e9f7ef;
        font-weight: 600;
    }

    .point-text {
        color: #198754;
        font-weight: bold;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="row align-items-center mb-4">
        <div class="col-lg-8">
            <h3 class="mb-1">Leaderboard Kelas</h3>
            <p class="text-muted mb-0">
                Peringkat siswa di kelas
                <strong>{{ $kelasAktif ?? 'Belum Masuk Kelas' }}</strong>
                berdasarkan total poin yang dikumpulkan.
            </p>
        </div>
    </div>

    @if($leaderboardSorted->isEmpty())

    <div class="card leaderboard-card">
        <div class="card-body text-center py-5 text-muted">
            @if(($kelasAktif ?? '') === 'Belum Masuk Kelas')
            Kamu belum bergabung ke kelas, sehingga leaderboard belum tersedia.
            @else
            Belum ada data peringkat tersedia untuk kelas ini.
            @endif
        </div>
    </div>

    @else

    @php
    $topThree = $leaderboardSorted->take(3);
    $remainingLeaderboard = $leaderboardSorted->slice(3)->values();
    @endphp

    {{-- CARD PERINGKAT 1 - 3 --}}
    <div class="row g-3 mb-4">
        @foreach($topThree as $index => $data)
        @php
        $rank = $index + 1;
        $isCurrentUser = auth()->id() == $data['id'];
        $avatarUrl = $data['avatar'] ? asset('images/avatars/' . $data['avatar']) : null;
        @endphp

        <div class="col-md-4">
            <div class="card top-rank-card rank-{{ $rank }}">
                <div class="card-body text-center p-3">

                    <div class="mb-2">
                        @if($rank == 1)
                        <span class="badge bg-warning text-dark">Peringkat 1</span>
                        @elseif($rank == 2)
                        <span class="badge bg-secondary">Peringkat 2</span>
                        @else
                        <span class="badge text-white" style="background-color: #cd7f32;">Peringkat 3</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        @if($avatarUrl)
                        <img src="{{ $avatarUrl }}" alt="Avatar {{ $data['nama'] }}" class="top-avatar">
                        @else
                        <div class="avatar-placeholder-top">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        @endif
                    </div>

                    <h6 class="fw-bold mb-1">
                        {{ $data['nama'] }}

                        @if($isCurrentUser)
                        <span class="badge bg-success ms-1">Kamu</span>
                        @endif
                    </h6>

                    <div class="mb-2">
                        <span class="badge bg-light text-dark border">
                            {{ $data['kelas'] }}
                        </span>
                    </div>

                    <div class="point-text">
                        {{ number_format($data['poin'], 0, ',', '.') }} Pts
                    </div>

                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- TABEL PERINGKAT SELANJUTNYA --}}
    <div class="card leaderboard-card">
        <div class="card-header bg-white">
            <h5 class="mb-0 fw-bold">Peringkat Lainnya</h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">Peringkat</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Total Poin</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($remainingLeaderboard as $index => $data)
                        @php
                        $rank = $index + 4;
                        $isCurrentUser = auth()->id() == $data['id'];
                        $avatarUrl = $data['avatar'] ? asset('images/avatars/' . $data['avatar']) : null;
                        @endphp

                        <tr class="{{ $isCurrentUser ? 'current-user-row' : '' }}">
                            <th scope="row" class="ps-4">
                                <span class="rank-circle">
                                    {{ $rank }}
                                </span>
                            </th>

                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($avatarUrl)
                                    <img src="{{ $avatarUrl }}" alt="Avatar {{ $data['nama'] }}" class="table-avatar">
                                    @else
                                    <div class="avatar-placeholder-table">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    @endif

                                    <div>
                                        {{ $data['nama'] }}

                                        @if($isCurrentUser)
                                        <span class="badge bg-success ms-1">Kamu</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $data['kelas'] }}
                                </span>
                            </td>

                            <td class="point-text">
                                {{ number_format($data['poin'], 0, ',', '.') }} Pts
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                Belum ada peringkat lainnya.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    @endif

</div>
@endsection