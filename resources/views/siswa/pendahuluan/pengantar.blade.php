@extends('layouts.siswa')

@section('title', 'PythaLearn')

@section('content')
    <div class="row align-items-center mb-2">
        <div class="col-lg-8">
            <h3 class="mb-1">Pengantar Bab</h3>
        </div>
    </div>

    <section class="mb-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card h-100">
                    <div class="card-header"><h5 class="mb-0"></i>Capaian Pembelajaran</h5></div>
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            Pada akhir fase D, peserta didik dapat menunjukkan kebenaran Teorema Pythagoras dan menggunakannya untuk menyelesaikan berbagai permasalahan dalam kehidupan sehari-hari. Selain itu, peserta didik mampu memanfaatkan konsep dan keterampilan matematika yang telah dipelajari pada fase ini.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="card h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            Bab ini bertujuan untuk mengembangkan kemampuan peserta didik dalam membuktikan kebenaran Teorema Pythagoras, menemukan dan menggunakan tripel Pythagoras, memahami karakteristik segitiga siku-siku istimewa, serta menerapkan Teorema Pythagoras dalam berbagai situasi kehidupan sehari-hari.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 ">
                <h3 class="mb-1 mt-3">Peta Konsep</h3>
                <div class="card mt-2 align-items-center p-4">
                    <img src="/images/petakonsep.webp" alt="peta_konsep">
                </div>
            </div>
        </div>
    </section>

@endsection
