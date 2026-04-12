@extends('layouts.siswa')

@section('title', 'PythaLearn - Tripel Pythagoras')

@push('scripts')
    <script>
        window.completedCheckpoints = <?php echo json_encode($completedCheckpoints ?? []); ?>;
    </script>

    <script src="{{ asset('js/materi2.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
<div class="container">
    <div class="row align-items-center">
        <div class="col-lg-12">
            <h3 class="text-center">Tripel Pythagoras</h3>
        </div>
    </div>

    <nav>
        <ul class="pagination justify-content-center materi-pagination">
            <li class="page-item">
                <button class="page-link prev-btn">‹</button>
            </li>
            <li class="page-item active">
                <button class="page-link page-btn" data-page="0">1</button>
            </li>
            <li class="page-item">
                <button class="page-link page-btn" data-page="1">2</button>
            </li>
            <li class="page-item">
                <button class="page-link page-btn" data-page="2">3</button>
            </li>
            <li class="page-item">
                <button class="page-link page-btn" data-page="3">4</button>
            </li>
            <li class="page-item">
                <button class="page-link page-btn" data-page="4">5</button>
            </li>
            <li class="page-item">
                <button class="page-link next-btn">›</button>
            </li>
        </ul>
    </nav>

    <section class="materi-page" data-page="0">
        <section class="mb-4">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h4>Tujuan Pembelajaran</h4>
                </div>
                <div class="card-body">
                    <ol>
                        <li>Peserta didik mampu menghitung hipotenusa dan sisi segitiga siku-siku lainnya dengan teorema Pythagoras</li>
                        <li>Peserta didik mampu menemukan tripel Pythagoras</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h4 class="text-center mb-0">Ayo Mengingat</h4>
                </div>
                <div class="card-body">
                    
                    <p class="text-justify mb-4">
                        Ingatkah kamu dengan Teorema Pythagoras yang telah dipelajari sebelumnya? Teorema Pythagoras menyatakan bahwa jumlah dari kuadrat kedua sisi siku-siku segitiga pada segitiga siku-siku sama dengan kuadrat panjang sisi miringnya (hipotenusa). Perhatikan gambar segitiga siku-siku di bawah dan tentukan rumus yang berlaku!
                    </p>

                    <div class="border rounded p-4 mb-4 border-success">
                        <div class="row align-items-center">
                            <div class="col-md-6 text-center mb-4 mb-md-0">
                                <img src="{{ asset('images/segitiga_sikusiku_contoh.png') }}" alt="Segitiga Pythagoras" class="img-fluid" style="max-width: 350px; width: 100%;">
                            </div>
                            <div class="col-md-6 text-md-start text-center">
                                <p class="mb-3">Pada &Delta;ABC di samping jika siku-siku di C, maka AB = c, BC = a, AC = b sehingga</p>
                                
                                <p class="mb-3">
                                    sisi siku-siku (BC) &lt; sisi siku-siku (AC) &lt; sisi miring (AB)<br>
                                </p>
                                <p class="mb-3">
                                    
                                    <strong>a &lt; b &lt; c</strong>
                                </p>
                                <div class="mt-3 p-3 bg-light border border-success rounded shadow-sm">
                                    <p class="mb-2 fw-bold text-success text-center">Tentukan rumus Pythagoras yang berlaku di bawah ini!</p>
                                    <div class="d-flex justify-content-center gap-1 my-2 fw-bold align-items-center">
                                        <select id="rumusDasar_1" class="form-select form-select-sm text-center border-success" style="width:100px">
                                            <option value=""></option><option>a</option><option>b</option><option>c</option>
                                        </select>
                                        <span>² =</span>
                                        <select id="rumusDasar_2" class="form-select form-select-sm text-center border-success" style="width:100px">
                                            <option value=""></option><option>a</option><option>b</option><option>c</option>
                                        </select>
                                        <span>² +</span>
                                        <select id="rumusDasar_3" class="form-select form-select-sm text-center border-success" style="width:100px">
                                            <option value=""></option><option>a</option><option>b</option><option>c</option>
                                        </select>
                                        <span>²</span>
                                    </div>
                                    <div id="feedbackDasar" class="small fw-bold text-center mt-2"></div>
                                    <div class="text-center mt-4">
                                        <button class="btn btn-sm btn-success px-4" onclick="cekRumusDasar()">Cek Jawaban</button>
                                    </div>
                                </div>
                                </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    
                    <p class="text-justify">
                        Nah, aturan tersebut ternyata bisa dibalik untuk menguji jenis sebuah segitiga. Jika kita hanya mengetahui panjang ketiga sisi sebuah segitiga, kita bisa menentukan apakah segitiga tersebut siku-siku atau bukan menggunakan <strong>Kebalikan Teorema Pythagoras</strong>. Berbekal contoh di atas, coba selesaikan latihan berikut!
                    </p>

                    <div class="alert alert-light border-success">
                        <h5 class="fw-bold text-center mb-3">Kebalikan Teorema Pythagoras</h5>
                        
                        <div class="alert alert-light border-success">
                            <strong>Petunjuk Pengerjaan:</strong><br>
                            <ol class="mb-0">
                                <li>Perhatikan dua gambar segitiga di bawah ini.</li>
                                <li>Tentukan mana yang menjadi sisi miring (sisi terpanjang) pada masing-masing segitiga.</li>
                                <li>Pilih kombinasi sisi yang tepat pada kotak dropdown untuk membentuk rumus Teorema Pythagoras yang benar.</li>
                                <li>Pastikan semua pilihan sudah terisi sebelum menekan tombol <strong>Cek Jawaban</strong>.</li>
                            </ol>
                        </div>

                        <div class="row g-4 mt-1 justify-content-center">

                            <div class="col-md-6">
                                <div class="card h-100 border-success shadow-sm">
                                    <div class="card-body text-center p-3">
                                        <img src="/images/segitiga_sikusiku_diA.png" class="img-fluid mb-3" style="max-height:160px;">
                                        <p class="mb-2">Jika diketahui <strong>c &lt; b &lt; a</strong></p>

                                        <div class="d-flex justify-content-center gap-1 my-3 fw-bold align-items-center">
                                            <select id="rumusA_1" class="form-select form-select-sm text-center" style="width:120px">
                                                <option value=""></option><option>a</option><option>b</option><option>c</option>
                                            </select>
                                            <span>² =</span>
                                            <select id="rumusA_2" class="form-select form-select-sm text-center" style="width:120px">
                                                <option value=""></option><option>a</option><option>b</option><option>c</option>
                                            </select>
                                            <span>² +</span>
                                            <select id="rumusA_3" class="form-select form-select-sm text-center" style="width:120px">
                                                <option value=""></option><option>a</option><option>b</option><option>c</option>
                                            </select>
                                            <span>²</span>
                                        </div>

                                        <div id="feedbackA" class="small fw-bold"></div>
                                        <div id="kesimpulanA" class="alert alert-success mt-2 py-1 small d-none">
                                            Maka △ABC <strong>siku-siku di A</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card h-100 border-success shadow-sm">
                                    <div class="card-body text-center p-3">
                                        <img src="/images/segitiga_sikusiku_diB.png" class="img-fluid mb-3" style="max-height:160px;">
                                        <p class="mb-2">Jika diketahui <strong>a &lt; c &lt; b</strong></p>

                                        <div class="d-flex justify-content-center gap-1 my-3 fw-bold align-items-center">
                                            <select id="rumusB_1" class="form-select form-select-sm text-center" style="width:120px">
                                                <option value=""></option><option>a</option><option>b</option><option>c</option>
                                            </select>
                                            <span>² =</span>
                                            <select id="rumusB_2" class="form-select form-select-sm text-center" style="width:120px">
                                                <option value=""></option><option>a</option><option>b</option><option>c</option>
                                            </select>
                                            <span>² +</span>
                                            <select id="rumusB_3" class="form-select form-select-sm text-center" style="width:120px">
                                                <option value=""></option><option>a</option><option>b</option><option>c</option>
                                            </select>
                                            <span>²</span>
                                        </div>

                                        <div id="feedbackB" class="small fw-bold"></div>
                                        <div id="kesimpulanB" class="alert alert-success mt-2 py-1 small d-none">
                                            Maka △ABC <strong>siku-siku di B</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-lg btn-success px-5" onclick="cekMariMengingatTripel()">
                                Cek Jawaban
                            </button>
                        </div>
                        
                    </div>

                </div>
            </div>
        </section>
    </section>

    <section class="materi-page d-none" data-page="1">
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h4 class="text-center mb-0">Menentukan Jenis Segitiga</h4>
                    </div>

                    <div class="card-body">
                        <div class="mb-4">
                            <p class="text-justify text-dark">
                                Ingatkah kamu tentang materi Perbandingan Sudut pada Segitiga? Berdasarkan sudutnya, segitiga dapat dikelompokkan menjadi:
                            </p>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 shadow-sm border-1 bg-light">
                                        <img src="/images/segitiga_sikusiku_contoh.png" class="card-img-top p-3" style="height: 200px; object-fit: contain; width: 100%;" alt="Gambar Segitiga Siku-siku">
                                        <div class="card-body d-flex flex-column text-center text-dark">
                                            <h5 class="card-title fw-bold">Segitiga Siku-siku</h5>
                                            <p class="card-text mt-auto">Salah satu sudutnya tepat 90°.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 shadow-sm border-1 bg-light">
                                        <img src="/images/segitiga_lancip.png" class="card-img-top p-3" style="height: 200px; object-fit: contain; width: 100%;" alt="Gambar Segitiga Lancip">
                                        <div class="card-body d-flex flex-column text-center text-dark">
                                            <h5 class="card-title fw-bold">Segitiga Lancip</h5>
                                            <p class="card-text mt-auto">Ketiga sudutnya kurang dari 90°.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 shadow-sm border-1 bg-light">
                                        <img src="/images/segitiga_tumpul.png" class="card-img-top p-3" style="height: 200px; object-fit: contain; width: 100%;" alt="Gambar Segitiga Tumpul">
                                        <div class="card-body d-flex flex-column text-center text-dark">
                                            <h5 class="card-title fw-bold">Segitiga Tumpul</h5>
                                            <p class="card-text mt-auto">Salah satu sudutnya lebih dari 90°.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p class="text-justify text-dark mt-3">
                                Namun, bagaimana jika kita <strong>hanya mengetahui panjang ketiga sisinya</strong> tanpa memiliki alat pengukur sudut? Di sinilah Kebalikan Teorema Pythagoras dapat digunakan untuk menyelidiki jenis segitiga tersebut.
                            </p>
                        </div>

                        <div class="bg-light p-3 border border-dark rounded">
                            <h5 class="fw-bold text-center mb-2 text-dark">
                                Ayo Mencoba
                            </h5>
                            
                            <div class="alert alert-light border border-success border-1 shadow-sm mb-4 text-justify">
                                <strong>Petunjuk Pengerjaan:</strong> Tentukan jenis segitiga yang paling tepat berdasarkan panjang ketiga sisinya dengan mengikuti langkah-langkah dan mengisi pada kolom yang tersedia di bawah ini!
                            </div>

                            <div class="row g-4 justify-content-center">
                                
                                <div class="col-md-4">
                                    <div class="card h-100 border-dark shadow-sm">
                                        <div class="card-header bg-white border-bottom border-dark text-center">
                                            <span class="fw-bold text-dark">Segitiga Pertama</span>
                                        </div>
                                        <div class="card-body d-flex flex-column align-items-center">
                                            
                                            <div class="mb-3 text-center w-100">
                                                <img src="{{ asset('images/AyoMencoba_Tripel2.png') }}" class="img-fluid mb-2" style="height: 200px; object-fit: contain;" alt="Gambar Segitiga 1">
                                            </div>
                                            
                                            <div class="bg-white border border-secondary p-2 rounded w-100 text-center mb-3">
                                                <p class="small text-dark mb-0">
                                                    Panjang sisi segitiga pada gambar di atas adalah <strong>6 cm, 7 cm, dan 9 cm</strong>. Tentukan jenis segitiga yang terbentuk!
                                                </p>
                                            </div>
                                            
                                            <div class="text-center small text-dark w-100 mt-auto">
                                                <div class="mb-3">
                                                    <strong>1. Kuadrat sisi terpanjang:</strong><br>
                                                    \(c^2\) = <input type="number" id="c_1" class="form-control form-control-sm d-inline-block text-center border-dark mt-1" style="width: 100px;" placeholder="...">\(^2\) = <input type="number" id="c2_1" class="form-control form-control-sm d-inline-block text-center border-dark mt-1" style="width: 100px;" placeholder="...">
                                                </div>
                                                <div class="mb-3">
                                                    <strong>2. Jumlah kuadrat sisi lainnya:</strong><br>
                                                    \(a^2 + b^2\) <br> = <input type="number" id="a_1" class="form-control form-control-sm d-inline-block text-center border-dark mt-1" style="width: 100px;" placeholder="...">\(^2\) + <input type="number" id="b_1" class="form-control form-control-sm d-inline-block text-center border-dark mt-1" style="width: 100px;" placeholder="...">\(^2\)<br>
                                                    = <input type="number" id="a2_1" class="form-control form-control-sm d-inline-block text-center border-dark mt-1" style="width: 100px;" placeholder="..."> + <input type="number" id="b2_1" class="form-control form-control-sm d-inline-block text-center border-dark mt-1" style="width: 100px;" placeholder="..."><br>
                                                    = <input type="number" id="ab2_1" class="form-control form-control-sm d-inline-block text-center border-dark mt-1" style="width: 100px;" placeholder="...">
                                                </div>
                                                <div class="mb-3">
                                                    <strong>3. Bandingkan nilai kuadrat sisi terpanjang dengan sisi-sisi lainnya:</strong><br>
                                                    <div class="d-flex justify-content-center align-items-center mt-1">
                                                        <span class="fw-bold me-2">\(c^2\)</span>
                                                        <select id="sign_1" class="form-select form-select-sm d-inline-block text-center border-dark fw-bold" style="width: 100px;">
                                                            <option value=""></option>
                                                            <option value="<">&lt;</option>
                                                            <option value="=">=</option>
                                                            <option value=">">&gt;</option>
                                                        </select>
                                                        <span class="fw-bold ms-2">\(a^2 + b^2\)</span>
                                                    </div>
                                                </div>
                                                <div class="bg-light p-2 border border-secondary rounded">
                                                    <strong>4. Maka segitiga yang terbentuk adalah ...</strong><br>
                                                    <select id="nama_1" class="form-select form-select-sm border-dark mt-2 text-center fw-bold mx-auto" style="width: 150px;">
                                                        <option value="">-- Pilih Jenis --</option>
                                                        <option value="lancip">Segitiga Lancip</option>
                                                        <option value="siku">Segitiga Siku-siku</option>
                                                        <option value="tumpul">Segitiga Tumpul</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card h-100 border-dark shadow-sm">
                                        <div class="card-header bg-white border-bottom border-dark text-center">
                                            <span class="fw-bold text-dark">Segitiga Kedua</span>
                                        </div>
                                        <div class="card-body d-flex flex-column align-items-center">
                                            
                                            <div class="mb-3 text-center w-100">
                                                <img src="{{ asset('images/AyoMencoba_Tripel1.png') }}" class="img-fluid mb-2" style="height: 200px; object-fit: contain;" alt="Gambar Segitiga 2">
                                            </div>
                                            
                                            <div class="bg-white border border-secondary p-2 rounded w-100 text-center mb-3">
                                                <p class="small text-dark mb-0">
                                                    Panjang sisi segitiga pada gambar di atas adalah <strong>6 cm, 8 cm, dan 10 cm</strong>. Tentukan jenis segitiga yang terbentuk!
                                                </p>
                                            </div>
                                            
                                            <div class="text-center small text-dark w-100 mt-auto">
                                                <div class="mb-3">
                                                    <strong>1. Kuadrat sisi terpanjang:</strong><br>
                                                    \(c^2\) = <input type="number" id="c_2" class="form-control form-control-sm d-inline-block text-center border-dark mt-1" style="width: 100px;" placeholder="...">\(^2\) = <input type="number" id="c2_2" class="form-control form-control-sm d-inline-block text-center border-dark mt-1" style="width: 100px;" placeholder="...">
                                                </div>
                                                <div class="mb-3">
                                                    <strong>2. Jumlah kuadrat sisi lainnya:</strong><br>
                                                    \(a^2 + b^2\) <br> = <input type="number" id="a_2" class="form-control form-control-sm d-inline-block text-center border-dark mt-1" style="width: 100px;" placeholder="...">\(^2\) + <input type="number" id="b_2" class="form-control form-control-sm d-inline-block text-center border-dark mt-1" style="width: 100px;" placeholder="...">\(^2\)<br>
                                                    = <input type="number" id="a2_2" class="form-control form-control-sm d-inline-block text-center border-dark mt-1" style="width: 100px;" placeholder="..."> + <input type="number" id="b2_2" class="form-control form-control-sm d-inline-block text-center border-dark mt-1" style="width: 100px;" placeholder="..."><br>
                                                    = <input type="number" id="ab2_2" class="form-control form-control-sm d-inline-block text-center border-dark mt-1" style="width: 100px;" placeholder="...">
                                                </div>
                                                <div class="mb-3">
                                                    <strong>3. Bandingkan nilai kuadrat sisi terpanjang dengan sisi-sisi lainnya:</strong><br>
                                                    <div class="d-flex justify-content-center align-items-center mt-1">
                                                        <span class="fw-bold me-2">\(c^2\)</span>
                                                        <select id="sign_2" class="form-select form-select-sm d-inline-block text-center border-dark fw-bold" style="width: 100px;">
                                                            <option value=""></option>
                                                            <option value="<">&lt;</option>
                                                            <option value="=">=</option>
                                                            <option value=">">&gt;</option>
                                                        </select>
                                                        <span class="fw-bold ms-2">\(a^2 + b^2\)</span>
                                                    </div>
                                                </div>
                                                <div class="bg-light p-2 border border-secondary rounded">
                                                    <strong>4. Maka segitiga yang terbentuk adalah ...</strong><br>
                                                    <select id="nama_2" class="form-select form-select-sm border-dark mt-2 text-center fw-bold mx-auto" style="width: 150px;">
                                                        <option value="">-- Pilih Jenis --</option>
                                                        <option value="lancip">Segitiga Lancip</option>
                                                        <option value="siku">Segitiga Siku-siku</option>
                                                        <option value="tumpul">Segitiga Tumpul</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card h-100 border-dark shadow-sm">
                                        <div class="card-header bg-white border-bottom border-dark text-center">
                                            <span class="fw-bold text-dark">Segitiga Ketiga</span>
                                        </div>
                                        <div class="card-body d-flex flex-column align-items-center">
                                            
                                            <div class="mb-3 text-center w-100">
                                                <img src="{{ asset('images/AyoMencoba_Tripel3.png') }}" class="img-fluid mb-2" style="height: 200px; object-fit: contain;" alt="Gambar Segitiga 3">
                                            </div>
                                            
                                            <div class="bg-white border border-secondary p-2 rounded w-100 text-center mb-3">
                                                <p class="small text-dark mb-0">
                                                    Panjang sisi segitiga pada gambar di atas adalah <strong>8 cm, 9 cm, dan 13 cm</strong>. Tentukan jenis segitiga yang terbentuk!
                                                </p>
                                            </div>
                                            
                                            <div class="text-center small text-dark w-100 mt-auto">
                                                <div class="mb-3">
                                                    <strong>1. Kuadrat sisi terpanjang:</strong><br>
                                                    \(c^2\) = <input type="number" id="c_3" class="form-control form-control-sm d-inline-block text-center border-dark mt-1" style="width: 100px;" placeholder="...">\(^2\) = <input type="number" id="c2_3" class="form-control form-control-sm d-inline-block text-center border-dark mt-1" style="width: 100px;" placeholder="...">
                                                </div>
                                                <div class="mb-3">
                                                    <strong>2. Jumlah kuadrat sisi lainnya:</strong><br>
                                                    \(a^2 + b^2\) <br> = <input type="number" id="a_3" class="form-control form-control-sm d-inline-block text-center border-dark mt-1" style="width: 100px;" placeholder="...">\(^2\) + <input type="number" id="b_3" class="form-control form-control-sm d-inline-block text-center border-dark mt-1" style="width: 100px;" placeholder="...">\(^2\)<br>
                                                    = <input type="number" id="a2_3" class="form-control form-control-sm d-inline-block text-center border-dark mt-1" style="width: 100px;" placeholder="..."> + <input type="number" id="b2_3" class="form-control form-control-sm d-inline-block text-center border-dark mt-1" style="width: 100px;" placeholder="..."><br>
                                                    = <input type="number" id="ab2_3" class="form-control form-control-sm d-inline-block text-center border-dark mt-1" style="width: 100px;" placeholder="...">
                                                </div>
                                                <div class="mb-3">
                                                    <strong>3. Bandingkan nilai kuadrat sisi terpanjang dengan sisi-sisi lainnya:</strong><br>
                                                    <div class="d-flex justify-content-center align-items-center mt-1">
                                                        <span class="fw-bold me-2">\(c^2\)</span>
                                                        <select id="sign_3" class="form-select form-select-sm d-inline-block text-center border-dark fw-bold" style="width: 100px;">
                                                            <option value=""></option>
                                                            <option value="<">&lt;</option>
                                                            <option value="=">=</option>
                                                            <option value=">">&gt;</option>
                                                        </select>
                                                        <span class="fw-bold ms-2">\(a^2 + b^2\)</span>
                                                    </div>
                                                </div>
                                                <div class="bg-light p-2 border border-secondary rounded">
                                                    <strong>4. Maka segitiga yang terbentuk adalah ...</strong><br>
                                                    <select id="nama_3" class="form-select form-select-sm border-dark mt-2 text-center fw-bold mx-auto" style="width: 150px;">
                                                        <option value="">-- Pilih Jenis --</option>
                                                        <option value="lancip">Segitiga Lancip</option>
                                                        <option value="siku">Segitiga Siku-siku</option>
                                                        <option value="tumpul">Segitiga Tumpul</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            
                            <div class="col-12 text-center mt-3">
                                <button class="btn btn-success fw-bold px-5 py-2 shadow" onclick="cekPenyelidikanSegitiga()">
                                    <i class="fas fa-check-circle me-2"></i>Cek Jawaban
                                </button>
                            </div>
                            <div id="kesimpulan_penyelidikan" class="col-12 mt-5 d-none">
                                <div class="alert shadow-sm border-1 border-success border-1">
                                    <p class="text-dark mb-2">
                                        Berdasarkan jenis segitiga yang baru saja kamu temukan, kita dapat menyimpulkan bahwa Jika \(c\) adalah sisi terpanjang, serta \(a\) dan \(b\) adalah dua sisi lainnya, maka berlaku aturan berikut:
                                    </p>
                                    <ul class="text-dark mb-0">
                                        <li>Jika <strong>\(c^2 < a^2 + b^2\)</strong>, maka segitiga tersebut adalah <strong>Segitiga Lancip</strong>.</li>
                                        <li>Jika <strong>\(c^2 = a^2 + b^2\)</strong>, maka segitiga tersebut adalah <strong>Segitiga Siku-siku</strong>.</li>
                                        <li>Jika <strong>\(c^2 > a^2 + b^2\)</strong>, maka segitiga tersebut adalah <strong>Segitiga Tumpul</strong>.</li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="col-sm-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header text-center bg-light">
                            <h4 class="mb-0">Contoh 1</h4>
                        </div>
                        
                        <div class="card-body">
                            <div class="alert alert-light shadow-sm border-start border-success border-4" role="alert">
                                <div class="small">
                                    <strong>Petunjuk:</strong> Perhatikan soal dan ilustrasi gambar di bawah ini, kemudian lengkapi data yang diketahui dan selesaikan langkah perhitungannya.
                                </div>
                            </div>

                            <div class="row mt-4">
                                
                                <div class="col-md-5 mb-4 mb-md-0">
                                    
                                    <div class="text-justify mb-3">
                                        <p class="text-dark mb-0">
                                            Diketahui sebuah segitiga dengan panjang sisi-sisinya masing-masing sisi a = 17 cm, sisi b = 25 cm, dan sisi c = 38 cm. Tentukan jenis segitiga tersebut berdasarkan panjang sisi-sisinya!
                                        </p>
                                    </div>

                                    <div class="bg-white rounded-3 shadow-sm border p-3 d-flex justify-content-center align-items-center mb-4">
                                        <img src="/images/segitiga_contoh_1_materi2.png" class="img-fluid" style="max-height: 200px;" alt="Ilustrasi Segitiga">
                                    </div>
                                    
                                    <div class="card border mb-4 shadow-sm">
                                        <div class="card-header border-bottom bg-light">
                                            <h6 class="fw-bold mb-0 small text-dark">Diketahui</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <span style="width: 60px;">Sisi a:</span>
                                                <select id="c1_dik_a" class="form-select form-select-sm text-center border-secondary mx-2" style="width: 80px;">
                                                    <option value=""></option>
                                                    <option value="17">17</option>
                                                    <option value="25">25</option>
                                                    <option value="38">38</option>
                                                </select>
                                                <span>cm</span>
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                <span style="width: 60px;">Sisi b:</span>
                                                <select id="c1_dik_b" class="form-select form-select-sm text-center border-secondary mx-2" style="width: 80px;">
                                                    <option value=""></option>
                                                    <option value="17">17</option>
                                                    <option value="25">25</option>
                                                    <option value="38">38</option>
                                                </select>
                                                <span>cm</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span style="width: 60px;">Sisi c:</span>
                                                <select id="c1_dik_c" class="form-select form-select-sm text-center border-secondary mx-2" style="width: 80px;">
                                                    <option value=""></option>
                                                    <option value="17">17</option>
                                                    <option value="25">25</option>
                                                    <option value="38">38</option>
                                                </select>
                                                <span>cm</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card border shadow-sm">
                                        <div class="card-header border-bottom bg-light">
                                            <h6 class="fw-bold mb-0 small text-dark">Ditanya</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0 text-muted small">
                                                Jenis segitiga berdasarkan panjang sisi-sisinya = ...?
                                            </p>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-7">
                                    <div class="card h-100 border shadow-sm">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="fw-bold mb-0 small text-dark"><i class="fas fa-calculator me-2"></i>Langkah Penyelesaian</h6>
                                        </div>
                                        <div class="card-body bg-light">
                                            
                                            <div class="p-3 mb-3 bg-white border border-success rounded-3 shadow-sm text-center">
                                                <span class="d-block fw-bold text-dark mb-2 border-bottom pb-2">Tentukan sisi terpanjang (sisi c)</span>
                                                <div class="mt-2">
                                                    Sisi terpanjang adalah 
                                                    <select id="c1_sisi_c" class="form-select form-select-sm d-inline-block fw-bold text-center border-success text-success" style="width: 80px;">
                                                        <option value=""></option>
                                                        <option value="17">17</option>
                                                        <option value="25">25</option>
                                                        <option value="38">38</option>
                                                    </select> cm.
                                                </div>
                                            </div>

                                            <div class="p-3 mb-3 bg-white border border-success rounded-3 shadow-sm text-center">
                                                <span class="d-block fw-bold text-dark mb-2 border-bottom pb-2">Hitung kuadrat sisi terpanjang (c²)</span>
                                                <div class="mt-2 d-flex justify-content-center align-items-center gap-2">
                                                    <span class="fw-bold">c² =</span>
                                                    <div class="input-group input-group-sm" style="width: 80px;">
                                                        <input type="number" id="c1_c2_awal" class="form-control text-center" placeholder="...">
                                                        <span class="input-group-text">²</span>
                                                    </div>
                                                    <span class="fw-bold">=</span>
                                                    <input type="number" id="c1_c2_hasil" class="form-control form-control-sm text-center" style="width: 90px;" placeholder="...">
                                                </div>
                                            </div>

                                            <div class="p-3 mb-3 bg-white border border-success rounded-3 shadow-sm text-center">
                                                <span class="d-block fw-bold text-dark mb-2 border-bottom pb-2">Hitung jumlah kuadrat dua sisi lainnya (a² + b²)</span>
                                                <div class="mt-2 text-center">
                                                    <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                                                        <span class="fw-bold">a² + b² =</span>
                                                        <div class="input-group input-group-sm" style="width: 80px;">
                                                            <input type="number" id="c1_a2_awal" class="form-control text-center" placeholder="...">
                                                            <span class="input-group-text">²</span>
                                                        </div>
                                                        <span class="fw-bold">+</span>
                                                        <div class="input-group input-group-sm" style="width: 80px;">
                                                            <input type="number" id="c1_b2_awal" class="form-control text-center" placeholder="...">
                                                            <span class="input-group-text">²</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                                                        <span class="fw-bold ms-4">=</span>
                                                        <input type="number" id="c1_a2_hasil" class="form-control form-control-sm text-center" style="width: 80px;" placeholder="...">
                                                        <span class="fw-bold">+</span>
                                                        <input type="number" id="c1_b2_hasil" class="form-control form-control-sm text-center" style="width: 80px;" placeholder="...">
                                                    </div>
                                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                                        <span class="fw-bold ms-4">=</span>
                                                        <input type="number" id="c1_ab_total" class="form-control form-control-sm text-center fw-bold text-primary" style="width: 100px;" placeholder="...">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="p-3 bg-white border border-success rounded-3 shadow-sm text-center">
                                                <span class="d-block fw-bold text-dark mb-2 border-bottom pb-2">Bandingkan dan Simpulkan</span>
                                                <div class="d-flex justify-content-center align-items-center gap-3 mt-3 mb-3">
                                                    <span class="fw-bold fs-5">c²</span> 
                                                    <select id="c1_banding" class="form-select text-center fw-bold text-primary border-primary shadow-sm" style="width: 80px;">
                                                        <option value="">?</option>
                                                        <option value="<">&lt;</option>
                                                        <option value="=">=</option>
                                                        <option value=">">&gt;</option>
                                                    </select> 
                                                    <span class="fw-bold fs-5">a² + b²</span>
                                                </div>
                                                <div class="alert alert-success d-flex flex-wrap justify-content-center align-items-center gap-2 mb-0 py-2">
                                                    <span class="small text-dark">Jadi, segitiga tersebut adalah</span> 
                                                    <select id="c1_kesimpulan" class="form-select form-select-sm d-inline-block fw-bold text-success border-success shadow-sm" style="width: 150px;">
                                                        <option value="">Pilih Jenis...</option>
                                                        <option value="lancip">segitiga lancip</option>
                                                        <option value="siku-siku">segitiga siku-siku</option>
                                                        <option value="tumpul">segitiga tumpul</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mt-4 d-flex flex-column flex-xl-row justify-content-between align-items-center border-top pt-3">
                                                <div id="c1_feedback" class="small fw-bold mb-3 mb-xl-0"></div>
                                                <button class="btn btn-success px-4 fw-bold shadow-sm" onclick="cekContoh1Tripel()">
                                                    Cek Jawaban
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="materi-page d-none" data-page="2">
        <div class="row">
            <div class="col-12 mb-4">
                
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="text-center mb-0">Pola Tripel Pythagoras</h4>
                    </div>
                    <div class="card-body">
                        <p class="text-justify">
                            Pada materi sebelumnya, kalian telah belajar cara menentukan jenis segitiga berdasarkan sudutnya yaitu segitiga lancip, tumpul, atau siku-siku. 
                            Kita tahu bahwa syarat segitiga siku-siku adalah <strong>\(c^2 = a^2 + b^2\)</strong>. 
                            Nah, jika ketiga sisi segitiga siku-siku tersebut merupakan <strong>bilangan asli</strong> (bilangan bulat positif), 
                            maka ketiga bilangan tersebut memiliki sebutan khusus, yaitu <strong>Tripel Pythagoras</strong>.
                        </p>
                        <hr>
                        <p class="text-justify">
                            Jika kita memiliki sebuah tripel Pythagoras dasar, misalnya <strong>3, 4, dan 5</strong>. Kemudian kita mengalikan ketiga bilangan tersebut dengan bilangan lain (kelipatan), 
                            maka tiga bilangan baru yang dihasilkan <strong>juga akan membentuk tripel Pythagoras</strong>.
                        </p>

                        <div class="alert alert-light border-success text-center">
                            <p class="mb-2">Perhatikan gambar segitiga dan langkah pembuktian di bawah ini:</p>
                            <img src="/images/segitiga_tripel1.png" class="img-fluid mb-3" alt="Contoh 1" style="max-height:200px">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 shadow-sm border-dark">
                                    <div class="card-header bg-light text-center fw-bold border-bottom border-dark">
                                        Dikali dengan 2
                                    </div>
                                    <div class="card-body">
                                        <p class="text-center mb-2">Kalikan sisi awal (3, 4, 5) dengan 2:</p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-center align-middle border-dark">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th class="fw-bold">Sisi Awal</th>
                                                        <th class="fw-bold">Pengali</th>
                                                        <th class="fw-bold">Sisi Baru</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>x 2</td>
                                                        <td><input type="number" id="pola2_h1" class="form-control text-center mx-auto border-dark" style="width: 80px;" placeholder="..."></td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>x 2</td>
                                                        <td><input type="number" id="pola2_h2" class="form-control text-center mx-auto border-dark" style="width: 80px;" placeholder="..."></td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>x 2</td>
                                                        <td><input type="number" id="pola2_h3" class="form-control text-center mx-auto border-dark" style="width: 80px;" placeholder="..."></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <hr class="border-dark">
                                        <p class="fw-bold mb-2 text-center">Buktikan sisi baru yang terbentuk ke dalam rumus Pythagoras</p>
                                        <div class="text-center">
                                            <p class="mb-2">\(c^2 = a^2 + b^2\)</p>
                                            <p class="mb-2">
                                                <input type="number" id="pola2_c" class="form-control text-center d-inline-block border-dark" style="width: 70px;" placeholder="...">\(^2\) = 
                                                <input type="number" id="pola2_a" class="form-control text-center d-inline-block border-dark" style="width: 70px;" placeholder="...">\(^2\) + 
                                                <input type="number" id="pola2_b" class="form-control text-center d-inline-block border-dark" style="width: 70px;" placeholder="...">\(^2\)
                                            </p>
                                            <p class="mb-2">
                                                <input type="number" id="pola2_c2" class="form-control text-center d-inline-block border-dark" style="width: 80px;" placeholder="..."> = 
                                                <input type="number" id="pola2_a2" class="form-control text-center d-inline-block border-dark" style="width: 80px;" placeholder="..."> + 
                                                <input type="number" id="pola2_b2" class="form-control text-center d-inline-block border-dark" style="width: 80px;" placeholder="...">
                                            </p>
                                            <p class="mb-2">
                                                <input type="number" id="pola2_tot_kiri" class="form-control text-center d-inline-block border-dark fw-bold" style="width: 90px;" placeholder="..."> = 
                                                <input type="number" id="pola2_tot_kanan" class="form-control text-center d-inline-block border-dark fw-bold" style="width: 90px;" placeholder="...">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card h-100 shadow-sm border-dark">
                                    <div class="card-header bg-light text-center fw-bold border-bottom border-dark">
                                        Dikali dengan 3
                                    </div>
                                    <div class="card-body">
                                        <p class="text-center mb-2">Kalikan sisi awal (3, 4, 5) dengan 3:</p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-center align-middle border-dark">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th class="fw-bold">Sisi Awal</th>
                                                        <th class="fw-bold">Pengali</th>
                                                        <th class="fw-bold">Sisi Baru</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>x 3</td>
                                                        <td><input type="number" id="pola3_h1" class="form-control text-center mx-auto border-dark" style="width: 80px;" placeholder="..."></td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>x 3</td>
                                                        <td><input type="number" id="pola3_h2" class="form-control text-center mx-auto border-dark" style="width: 80px;" placeholder="..."></td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>x 3</td>
                                                        <td><input type="number" id="pola3_h3" class="form-control text-center mx-auto border-dark" style="width: 80px;" placeholder="..."></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <hr class="border-dark">
                                        <p class="fw-bold mb-2 text-center">Buktikan sisi baru yang terbentuk ke dalam rumus Pythagoras</p>
                                        <div class="text-center">
                                            <p class="mb-2">\(c^2 = a^2 + b^2\)</p>
                                            <p class="mb-2">
                                                <input type="number" id="pola3_c" class="form-control text-center d-inline-block border-dark" style="width: 70px;" placeholder="...">\(^2\) = 
                                                <input type="number" id="pola3_a" class="form-control text-center d-inline-block border-dark" style="width: 70px;" placeholder="...">\(^2\) + 
                                                <input type="number" id="pola3_b" class="form-control text-center d-inline-block border-dark" style="width: 70px;" placeholder="...">\(^2\)
                                            </p>
                                            <p class="mb-2">
                                                <input type="number" id="pola3_c2" class="form-control text-center d-inline-block border-dark" style="width: 80px;" placeholder="..."> = 
                                                <input type="number" id="pola3_a2" class="form-control text-center d-inline-block border-dark" style="width: 80px;" placeholder="..."> + 
                                                <input type="number" id="pola3_b2" class="form-control text-center d-inline-block border-dark" style="width: 80px;" placeholder="...">
                                            </p>
                                            <p class="mb-2">
                                                <input type="number" id="pola3_tot_kiri" class="form-control text-center d-inline-block border-dark fw-bold" style="width: 90px;" placeholder="..."> = 
                                                <input type="number" id="pola3_tot_kanan" class="form-control text-center d-inline-block border-dark fw-bold" style="width: 90px;" placeholder="...">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12 text-center">
                                <button class="btn btn-success fw-bold px-4 py-2" onclick="cekPolaTripel()">
                                    Cek Jawaban
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <div class="card shadow-sm border-1">
                    <div class="card-header bg-light">
                        <h4 class="text-center mb-0">Contoh Soal</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="small mb-2">
                                <strong>Petunjuk :</strong> Perhatikan soal di bawah ini, lengkapi titik-titik dan selesaikan langkah perhitungannya.
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 border-success shadow-sm">
                                    <div class="card-header text-center fw-bold bg-light">
                                        Contoh 1
                                    </div>
                                    <div class="card-body bg-light d-flex flex-column">
                                        <p class="mb-3 text-center">Apakah <strong>8, 16, dan 17</strong> adalah Tripel Pythagoras?</p>
                                        
                                        <p class="fw-bold mb-1 pb-1">Penyelesaian</p>
                                        <div class="mb-3 mt-2 d-flex align-items-center">
                                            <span class="me-2">Sisi terpanjang =</span>
                                            <select id="tp1_sisi_c" class="form-select form-select-sm text-center border-success text-success fw-bold" style="width: 80px;">
                                                <option value=""></option>
                                                <option value="8">8</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                            </select>
                                        </div>

                                        <div class="p-3 bg-white rounded border border-success text-center shadow-sm">
                                            <p class="mb-3 fw-bold border-bottom pb-2">
                                                \( c^2 = a^2 + b^2 \)
                                            </p>
                                            
                                            <div class="d-flex justify-content-center align-items-center gap-1 mb-2">
                                                <input type="number" id="tp1_step1_c" class="form-control form-control-sm text-center" style="width: 55px;" placeholder="...">² 
                                                <span class="mx-1">=</span>
                                                <input type="number" id="tp1_step1_b" class="form-control form-control-sm text-center" style="width: 55px;" placeholder="...">² 
                                                <span class="mx-1">+</span>
                                                <input type="number" id="tp1_step1_a" class="form-control form-control-sm text-center" style="width: 55px;" placeholder="...">²
                                            </div>
                                            
                                            <div class="d-flex justify-content-center align-items-center gap-1 mb-2">
                                                <input type="number" id="tp1_step2_c2" class="form-control form-control-sm text-center" style="width: 70px;" placeholder="..."> 
                                                <span class="mx-1">=</span>
                                                <input type="number" id="tp1_step2_b2" class="form-control form-control-sm text-center" style="width: 70px;" placeholder="..."> 
                                                <span class="mx-1">+</span>
                                                <input type="number" id="tp1_step2_a2" class="form-control form-control-sm text-center" style="width: 70px;" placeholder="...">
                                            </div>
                                            
                                            <div class="d-flex justify-content-center align-items-end gap-3 mt-3 pt-3 border-top">
                                                
                                                <div class="text-center">
                                                    <span class="d-block small text-muted fw-bold mb-1">\(c^2\)</span>
                                                    <input type="number" id="tp1_step3_c2_tot" class="form-control form-control-sm text-center fw-bold mx-auto" style="width: 80px;" placeholder="..."> 
                                                </div>
                                                
                                                <div>
                                                    <select id="tp1_sign" class="form-select form-select-sm text-center fw-bold text-primary border-primary shadow-sm" style="width: 65px;">
                                                        <option value="">?</option>
                                                        <option value="=">=</option>
                                                        <option value="!=">&ne;</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="text-center">
                                                    <span class="d-block small text-muted fw-bold mb-1">\(a^2 + b^2\)</span>
                                                    <input type="number" id="tp1_step3_ab_tot" class="form-control form-control-sm text-center fw-bold mx-auto" style="width: 80px;" placeholder="...">
                                                </div>

                                            </div>
                                        </div>

                                        <div class="alert alert-light border border-success mt-3 text-center mb-0 px-2 py-3 flex-grow-1 d-flex flex-column justify-content-center">
                                            <strong>Jadi,</strong> bilangan 8, 16 dan 17<br>
                                            <select id="tp1_kesimpulan" class="form-select form-select-sm mx-auto mt-2 fw-bold text-center border-success" style="max-width: 230px;">
                                                <option value="">-- Pilih Kesimpulan --</option>
                                                <option value="ya">Termasuk Tripel Pythagoras</option>
                                                <option value="tidak">Bukan Tripel Pythagoras</option>
                                            </select>
                                        </div>
                                        
                                        <div id="tp1_feedback" class="text-center small fw-bold mt-3"></div>
                                        <button class="btn btn-success mt-2 fw-bold shadow-sm" onclick="cekTripel1()">Cek Jawaban 1</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="card h-100 border-success shadow-sm">
                                    <div class="card-header text-center fw-bold bg-light">
                                        Contoh 2
                                    </div>
                                    <div class="card-body bg-light d-flex flex-column">
                                        <p class="mb-3 text-center">Apakah <strong>10, 24, dan 26</strong> adalah Tripel Pythagoras?</p>
                                        
                                        <p class="fw-bold mb-1 pb-1">Penyelesaian</p>
                                        <div class="mb-3 mt-2 d-flex align-items-center">
                                            <span class="me-2">Sisi terpanjang =</span>
                                            <select id="tp2_sisi_c" class="form-select form-select-sm text-center border-success text-success fw-bold" style="width: 80px;">
                                                <option value=""></option>
                                                <option value="10">10</option>
                                                <option value="24">24</option>
                                                <option value="26">26</option>
                                            </select>
                                        </div>

                                        <div class="p-3 bg-white rounded border border-success text-center shadow-sm">
                                            <p class="mb-3 fw-bold border-bottom pb-2">
                                                \( c^2 = a^2 + b^2 \)
                                            </p>
                                            
                                            <div class="d-flex justify-content-center align-items-center gap-1 mb-2">
                                                <input type="number" id="tp2_step1_c" class="form-control form-control-sm text-center" style="width: 55px;" placeholder="...">² 
                                                <span class="mx-1">=</span>
                                                <input type="number" id="tp2_step1_b" class="form-control form-control-sm text-center" style="width: 55px;" placeholder="...">² 
                                                <span class="mx-1">+</span>
                                                <input type="number" id="tp2_step1_a" class="form-control form-control-sm text-center" style="width: 55px;" placeholder="...">²
                                            </div>
                                            
                                            <div class="d-flex justify-content-center align-items-center gap-1 mb-2">
                                                <input type="number" id="tp2_step2_c2" class="form-control form-control-sm text-center" style="width: 70px;" placeholder="..."> 
                                                <span class="mx-1">=</span>
                                                <input type="number" id="tp2_step2_b2" class="form-control form-control-sm text-center" style="width: 70px;" placeholder="..."> 
                                                <span class="mx-1">+</span>
                                                <input type="number" id="tp2_step2_a2" class="form-control form-control-sm text-center" style="width: 70px;" placeholder="...">
                                            </div>
                                            
                                            <div class="d-flex justify-content-center align-items-end gap-3 mt-3 pt-3 border-top">
    
                                                <div class="text-center">
                                                    <span class="d-block small text-muted fw-bold mb-1">\(c^2\)</span>
                                                    <input type="number" id="tp2_step3_c2_tot" class="form-control form-control-sm text-center fw-bold mx-auto" style="width: 80px;" placeholder="..."> 
                                                </div>
                                                
                                                <div>
                                                    <select id="tp2_sign" class="form-select form-select-sm text-center fw-bold text-primary border-primary shadow-sm" style="width: 65px;">
                                                        <option value="">?</option>
                                                        <option value="=">=</option>
                                                        <option value="!=">&ne;</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="text-center">
                                                    <span class="d-block small text-muted fw-bold mb-1">\(a^2 + b^2\)</span>
                                                    <input type="number" id="tp2_step3_ab_tot" class="form-control form-control-sm text-center fw-bold mx-auto" style="width: 80px;" placeholder="...">
                                                </div>

                                            </div>
                                        </div>

                                        <div class="alert alert-light border border-success mt-3 text-center mb-0 px-2 py-3 flex-grow-1 d-flex flex-column justify-content-center">
                                            <strong>Jadi,</strong> bilangan 10, 24 dan 26<br>
                                            <select id="tp2_kesimpulan" class="form-select form-select-sm mx-auto mt-2 fw-bold text-center border-success" style="max-width: 230px;">
                                                <option value="">-- Pilih Kesimpulan --</option>
                                                <option value="ya">Termasuk Tripel Pythagoras</option>
                                                <option value="tidak">Bukan Tripel Pythagoras</option>
                                            </select>
                                        </div>

                                        <div id="tp2_feedback" class="text-center small fw-bold mt-3"></div>
                                        <button class="btn btn-success mt-2 fw-bold shadow-sm" onclick="cekTripel2()">Cek Jawaban 2</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="materi-page d-none" data-page="3">
        <div class="row justify-content-center">
            
            <div class="col-md-12">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <h4 class="text-center mb-0">Ayo Berlatih</h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="alert border-success shadow-sm bg-light" role="alert">
                            <h6 class="fw-bold"><i class="bi bi-info-circle-fill text-success me-2"></i>Petunjuk Pengerjaan:</h6>
                            <ol class="mb-0 ps-3" style="line-height: 1.7;">
                                <li class="mb-2">
                                    <strong>Perhatikan</strong> setiap perintah soal dengan teliti sebelum menjawab.
                                </li>
                                <li class="mb-2">
                                    <strong>Kerjakan</strong> 8 soal latihan berikut sesuai dengan bagiannya:
                                    <ul class="ps-3 mt-1" style="list-style-type: disc;">
                                        <li class="mb-1"><strong>Soal 1 - 2:</strong> Isilah kotak-kotak kosong dengan angka dan tanda perbandingan (<, >, =) yang tepat untuk membuktikan jenis segitiganya.</li>
                                        <li class="mb-1"><strong>Soal 3 - 5:</strong> Tentukan apakah kelompok bilangan pada tabel termasuk Tripel Pythagoras atau bukan (Pilih Ya/Tidak).</li>
                                        <li><strong>Soal 6 - 8:</strong> Pilih satu jawaban yang paling tepat dari opsi pilihan ganda yang tersedia.</li>
                                    </ul>
                                </li>
                                <li class="mb-2">
                                    Jika seluruh soal sudah terisi, klik tombol <strong>"Cek Semua Jawaban"</strong> di bagian paling bawah.
                                </li>
                                <li class="mb-2">
                                    Jawaban <strong>Benar</strong> akan ditandai dengan warna <span class="badge bg-success">Hijau</span>, sedangkan jawaban yang <strong>Salah</strong> atau kosong akan berwarna <span class="badge bg-danger">Merah</span>. Silakan perbaiki jika masih ada yang merah.
                                </li> 
                            </ol>
                        </div>
                        
                        <form id="formLatihan">
    
                            {{-- BAGIAN 1: JENIS SEGITIGA (SOAL 1 & 2) --}}
                            <h5 class="fw-bold text-center mb-4">Tentukan jenis segitiga dari kelompok sisi berikut!</h5>
                            
                            <div class="row g-4 mb-4">
                                {{-- SOAL 1 --}}
                                <div class="col-md-6">
                                    <h6 class="fw-bold">1. Sisi segitiga: 9, 12, 15</h6>
                                    <div class="card bg-light border-0 mt-2 h-100 shadow-sm">
                                        <div class="card-body">
                                            <p class="fw-bold text-decoration-underline mb-3">Penyelesaian:</p>
                                            
                                            <div class="d-flex align-items-center mb-3">
                                                <label class="me-2">Sisi terpanjang (\(c\)) =</label>
                                                <input type="number" class="form-control form-control-sm text-center border-secondary input-soal1" style="width: 80px;">
                                            </div>
                                            
                                            <div class="ps-1">
                                                <div class="row align-items-center g-1 mb-2">
                                                    <div class="col-auto">\(c^2\) = </div>
                                                    <div class="col-auto"><input type="number" class="form-control form-control-sm text-center px-1 input-soal1" style="width: 60px;"></div>
                                                    <div class="col-auto">\(^2\) = </div>
                                                    <div class="col-auto"><input type="number" class="form-control form-control-sm text-center px-1 fw-bold input-soal1" style="width: 75px;"></div>
                                                </div>
                                                
                                                <div class="row align-items-center g-1 mb-2">
                                                    <div class="col-auto">\(a^2 + b^2\) =</div>
                                                    <div class="col-auto"><input type="number" class="form-control form-control-sm text-center px-1 input-soal1" style="width: 50px;"></div>
                                                    <div class="col-auto">\(^2\) + </div>
                                                    <div class="col-auto"><input type="number" class="form-control form-control-sm text-center px-1 input-soal1" style="width: 50px;"></div>
                                                    <div class="col-auto">\(^2\)</div>
                                                </div>
                                                
                                                <div class="row align-items-center g-1 mb-3 ps-5 ms-3">
                                                    <div class="col-auto">=</div>
                                                    <div class="col-auto"><input type="number" class="form-control form-control-sm text-center px-1 input-soal1" style="width: 60px;"></div>
                                                    <div class="col-auto">+</div>
                                                    <div class="col-auto"><input type="number" class="form-control form-control-sm text-center px-1 input-soal1" style="width: 60px;"></div>
                                                    <div class="col-auto">=</div>
                                                    <div class="col-auto"><input type="number" class="form-control form-control-sm text-center px-1 fw-bold text-primary input-soal1" style="width: 75px;"></div>
                                                </div>
                                                
                                                <div class="d-flex align-items-end gap-2 mt-1 mb-2">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <label class="mb-1">\(c^2\)</label>
                                                        <input type="number" id="inp_compare_c_soal1" class="form-control form-control-sm text-center bg-white" style="width: 80px;" placeholder="...">
                                                    </div>
                                                    <select id="inp_sign_soal1" class="form-select form-select-sm text-center bg-white mb-0" style="width: 100px;">
                                                        <option value="">tanda</option>
                                                        <option value="<">&lt;</option>
                                                        <option value=">">&gt;</option>
                                                        <option value="=">=</option>
                                                    </select>
                                                    <div class="d-flex flex-column align-items-center">
                                                        <label class="mb-1">\(a^2 + b^2\)</label>
                                                        <input type="number" id="inp_compare_ab_soal1" class="form-control form-control-sm text-center bg-white" style="width: 80px;" placeholder="...">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex align-items-center bg-white p-3 rounded border shadow-sm mt-3">
                                                <span class="me-2 fw-bold small">Jadi, segitiga:</span>
                                                <select class="form-select form-select-sm w-auto fw-bold text-success border-success" id="selectSoal1">
                                                    <option selected disabled value="">-- Pilih --</option>
                                                    <option value="Siku-siku">Siku-siku</option>
                                                    <option value="Lancip">Lancip</option>
                                                    <option value="Tumpul">Tumpul</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- SOAL 2 --}}
                                <div class="col-md-6">
                                    <h6 class="fw-bold">2. Sisi segitiga: 6, 8, 12</h6>
                                    <div class="card bg-light border-0 mt-2 h-100 shadow-sm">
                                        <div class="card-body">
                                            <p class="fw-bold text-decoration-underline mb-3">Penyelesaian:</p>
                                            
                                            <div class="d-flex align-items-center mb-3">
                                                <label class="me-2">Sisi terpanjang (\(c\)) =</label>
                                                <input type="number" class="form-control form-control-sm text-center border-secondary input-soal2" style="width: 80px;">
                                            </div>
                                            
                                            <div class="ps-1">
                                                <div class="row align-items-center g-1 mb-2">
                                                    <div class="col-auto">\(c^2\) = </div>
                                                    <div class="col-auto"><input type="number" class="form-control form-control-sm text-center px-1 input-soal2" style="width: 60px;"></div>
                                                    <div class="col-auto">\(^2\) = </div>
                                                    <div class="col-auto"><input type="number" class="form-control form-control-sm text-center px-1 fw-bold input-soal2" style="width: 75px;"></div>
                                                </div>
                                                
                                                <div class="row align-items-center g-1 mb-2">
                                                    <div class="col-auto">\(a^2 + b^2\) =</div>
                                                    <div class="col-auto"><input type="number" class="form-control form-control-sm text-center px-1 input-soal2" style="width: 50px;"></div>
                                                    <div class="col-auto">\(^2\) + </div>
                                                    <div class="col-auto"><input type="number" class="form-control form-control-sm text-center px-1 input-soal2" style="width: 50px;"></div>
                                                    <div class="col-auto">\(^2\)</div>
                                                </div>
                                                
                                                <div class="row align-items-center g-1 mb-3 ps-5 ms-3">
                                                    <div class="col-auto">=</div>
                                                    <div class="col-auto"><input type="number" class="form-control form-control-sm text-center px-1 input-soal2" style="width: 60px;"></div>
                                                    <div class="col-auto">+</div>
                                                    <div class="col-auto"><input type="number" class="form-control form-control-sm text-center px-1 input-soal2" style="width: 60px;"></div>
                                                    <div class="col-auto">=</div>
                                                    <div class="col-auto"><input type="number" class="form-control form-control-sm text-center px-1 fw-bold text-primary input-soal2" style="width: 75px;"></div>
                                                </div>
                                                
                                                <div class="d-flex align-items-end gap-2 mt-1 mb-2">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <label class="mb-1">\(c^2\)</label>
                                                        <input type="number" id="inp_compare_c_soal2" class="form-control form-control-sm text-center bg-white" style="width: 80px;" placeholder="...">
                                                    </div>
                                                    <select id="inp_sign_soal2" class="form-select form-select-sm text-center bg-white mb-0" style="width: 100px;">
                                                        <option value="">tanda</option>
                                                        <option value="<">&lt;</option>
                                                        <option value=">">&gt;</option>
                                                        <option value="=">=</option>
                                                    </select>
                                                    <div class="d-flex flex-column align-items-center">
                                                        <label class="mb-1">\(a^2 + b^2\)</label>
                                                        <input type="number" id="inp_compare_ab_soal2" class="form-control form-control-sm text-center bg-white" style="width: 80px;" placeholder="...">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex align-items-center bg-white p-3 rounded border shadow-sm mt-3">
                                                <span class="me-2 fw-bold small">Jadi, segitiga:</span>
                                                <select class="form-select form-select-sm w-auto fw-bold text-success border-success" id="selectSoal2">
                                                    <option selected disabled value="">-- Pilih --</option>
                                                    <option value="Siku-siku">Siku-siku</option>
                                                    <option value="Lancip">Lancip</option>
                                                    <option value="Tumpul">Tumpul</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="my-5 opacity-25">
                            
                            {{-- BAGIAN 2: YA/TIDAK (SOAL 3, 4, 5) --}}
                            <div class="mb-5">
                                <h5 class="fw-bold text-center">Periksalah apakah bilangan-bilangan di bawah ini merupakan Tripel Pythagoras!</h5>
                                <div class="table-responsive mt-4">
                                    <table class="table table-bordered table-hover align-middle shadow-sm">
                                        <thead class="table-light text-center">
                                            <tr>
                                                <th style="width: 10%">No</th>
                                                <th style="width: 40%">Bilangan (Sisi)</th>
                                                <th style="width: 25%">Ya</th>
                                                <th style="width: 25%">Tidak</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <tr>
                                                <td class="fw-bold text-muted">3</td>
                                                <td class="fw-bold px-3">6, 8, 10</td>
                                                <td class="text-center"><input class="form-check-input" type="radio" name="soal3" value="ya"></td>
                                                <td class="text-center"><input class="form-check-input" type="radio" name="soal3" value="tidak"></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-muted">4</td>
                                                <td class="fw-bold px-3">7, 12, 14</td>
                                                <td class="text-center"><input class="form-check-input" type="radio" name="soal4" value="ya"></td>
                                                <td class="text-center"><input class="form-check-input" type="radio" name="soal4" value="tidak"></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-muted">5</td>
                                                <td class="fw-bold px-3">8, 15, 17</td>
                                                <td class="text-center"><input class="form-check-input" type="radio" name="soal5" value="ya"></td>
                                                <td class="text-center"><input class="form-check-input" type="radio" name="soal5" value="tidak"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <hr class="my-5 opacity-25">
                            
                            {{-- BAGIAN 3: PILIHAN GANDA (SOAL 6, 7, 8) --}}
                            <div class="mb-4">
                                <h5 class="fw-bold text-center mb-4">Pilihlah jawaban yang paling tepat!</h5>
                                
                                {{-- Soal 6 --}}
                                <div class="mb-4 p-3 bg-light rounded-3 shadow-sm">
                                    <h6 class="fw-bold mb-3">6. Manakah dari pasangan angka berikut yang membentuk Tripel Pythagoras?</h6>
                                    <div class="row g-3">
                                        <div class="col-md-4 col-12">
                                            <input type="radio" class="btn-check" name="soal6" id="s6A" value="A" autocomplete="off">
                                            <label class="btn btn-outline-success w-100 py-2 fw-bold" for="s6A">A. 7, 24, 25</label>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <input type="radio" class="btn-check" name="soal6" id="s6B" value="B" autocomplete="off">
                                            <label class="btn btn-outline-success w-100 py-2 fw-bold" for="s6B">B. 8, 20, 25</label>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <input type="radio" class="btn-check" name="soal6" id="s6C" value="C" autocomplete="off">
                                            <label class="btn btn-outline-success w-100 py-2 fw-bold" for="s6C">C. 10, 25, 27</label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Soal 7 --}}
                                <div class="mb-4 p-3 bg-light rounded-3 shadow-sm">
                                    <h6 class="fw-bold mb-3">7. Manakah kelompok sisi yang membentuk segitiga tumpul?</h6>
                                    <div class="row g-3">
                                        <div class="col-md-4 col-12">
                                            <input type="radio" class="btn-check" name="soal7" id="s7A" value="A" autocomplete="off">
                                            <label class="btn btn-outline-success w-100 py-2 fw-bold" for="s7A">A. 3, 4, 5</label>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <input type="radio" class="btn-check" name="soal7" id="s7B" value="B" autocomplete="off">
                                            <label class="btn btn-outline-success w-100 py-2 fw-bold" for="s7B">B. 5, 12, 14</label>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <input type="radio" class="btn-check" name="soal7" id="s7C" value="C" autocomplete="off">
                                            <label class="btn btn-outline-success w-100 py-2 fw-bold" for="s7C">C. 7, 24, 25</label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Soal 8 --}}
                                <div class="mb-4 p-3 bg-light rounded-3 shadow-sm">
                                    <h6 class="fw-bold mb-3">8. Kelompok bilangan berikut merupakan Tripel Pythagoras, KECUALI...</h6>
                                    <div class="row g-3">
                                        <div class="col-md-4 col-12">
                                            <input type="radio" class="btn-check" name="soal8" id="s8A" value="A" autocomplete="off">
                                            <label class="btn btn-outline-success w-100 py-2 fw-bold" for="s8A">A. 5, 12, 13</label>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <input type="radio" class="btn-check" name="soal8" id="s8B" value="B" autocomplete="off">
                                            <label class="btn btn-outline-success w-100 py-2 fw-bold" for="s8B">B. 9, 40, 41</label>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <input type="radio" class="btn-check" name="soal8" id="s8C" value="C" autocomplete="off">
                                            <label class="btn btn-outline-success w-100 py-2 fw-bold" for="s8C">C. 6, 12, 14</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2 col-md-4 mx-auto mt-2">
                                <button type="button" class="btn btn-success btn-lg fw-bold shadow-sm" onclick="cekLatihanTripel()">
                                    <i class="fas fa-check-circle me-2"></i> Cek Jawaban
                                </button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    <section class="materi-page d-none" data-page="4">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h4 class="mb-0">Rangkuman Materi</h4>
                    </div>
                    
                    <div class="card-body p-4 bg-white">
                        
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 30px; height: 30px;">1</div>
                            <div class="ms-3">
                                <p class="text-muted mb-0" style="line-height: 1.6;">
                                    <strong>Kebalikan Teorema Pythagoras:</strong> Jika kuadrat sisi terpanjang sebuah segitiga sama dengan jumlah kuadrat dua sisi lainnya, maka segitiga tersebut adalah segitiga siku-siku.
                                </p>
                                <ul class="text-muted mt-2 mb-0 ps-3" style="line-height: 1.6;">
                                    <li>Jika <strong>a &lt; b &lt; c</strong> dan didapat <strong>c² = a² + b²</strong>, maka siku-siku di C.</li>
                                    <li>Jika <strong>c &lt; b &lt; a</strong> dan didapat <strong>a² = b² + c²</strong>, maka siku-siku di A.</li>
                                    <li>Jika <strong>a &lt; c &lt; b</strong> dan didapat <strong>b² = a² + c²</strong>, maka siku-siku di B.</li>
                                </ul>
                            </div>
                        </div>

                        <hr class="border-secondary opacity-10 my-3">

                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 30px; height: 30px;">2</div>
                            <div class="ms-3">
                                <p class="text-muted mb-2" style="line-height: 1.6;">
                                    <strong>Menentukan Jenis Segitiga:</strong> Jika <strong>c</strong> adalah sisi terpanjang, kita dapat menentukan jenis segitiganya dengan membandingkan nilai <strong>c²</strong> dan <strong>a² + b²</strong>:
                                </p>
                                <ul class="text-muted mb-0 ps-3" style="line-height: 1.6;">
                                    <li class="mb-1">Jika <strong>c² = a² + b²</strong>, maka <strong>segitiga siku-siku</strong>.</li>
                                    <li class="mb-1">Jika <strong>c² &lt; a² + b²</strong>, maka <strong>segitiga lancip</strong>.</li>
                                    <li>Jika <strong>c² &gt; a² + b²</strong>, maka <strong>segitiga tumpul</strong>.</li>
                                </ul>
                            </div>
                        </div>

                        <hr class="border-secondary opacity-10 my-3">

                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 30px; height: 30px;">3</div>
                            <div class="ms-3">
                                <p class="text-muted mb-0" style="line-height: 1.6;">
                                    <strong>Sifat Kelipatan:</strong> Jika kita memiliki salah satu tripel Pythagoras (misalnya 3, 4, 5), maka kelipatannya juga membentuk tripel Pythagoras. <br>
                                    <em>Contoh:</em> 6, 8, 10 (dikali 2) atau 9, 12, 15 (dikali 3).
                                </p>
                            </div>
                        </div>

                        <hr class="border-secondary opacity-10 my-3">

                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 30px; height: 30px;">4</div>
                            <div class="ms-3">
                                <p class="text-muted mb-0" style="line-height: 1.6;">
                                    <strong>Tripel Pythagoras:</strong> adalah kelompok tiga bilangan asli (bilangan bulat positif) a, b, dan c yang memenuhi ketentuan <strong>c² = a² + b²</strong>, di mana c adalah bilangan terbesar (sisi miring). <br>
                                    <em>Contoh:</em> 3, 4, 5; 6, 8, 10; 9, 12, 15.
                                </p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h4 class="mb-0">Refleksi</h4>
                        <small class="text-muted">
                            Jawablah berdasarkan pemahamanmu terkait aktivitas Tripel Pythagoras
                        </small>
                    </div>
            
                    <div class="card-body p-4">
            
                        <div class="mb-4">
                            <label class="fw-semibold mb-2">
                                1. Apakah bilangan kuadrat dan akar kuadrat suatu bilangan merupakan bilangan dasar yang menentukan terbentuknya Teorema Pythagoras? Jelaskan.
                            </label>
            
                            <div class="mb-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ref_tri_1" id="ref_tri_1_ya" value="ya">
                                    <label class="form-check-label" for="ref_tri_1_ya">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ref_tri_1" id="ref_tri_1_tidak" value="tidak">
                                    <label class="form-check-label" for="ref_tri_1_tidak">Tidak</label>
                                </div>
                            </div>
            
                            <textarea class="form-control" rows="3" id="ref_tri_1_text" placeholder="Berikan penjelasanmu..."></textarea>
                        </div>
            
                        <div class="mb-4">
                            <label class="fw-semibold mb-2">
                                2. Bagaimana bentuk hubungan dari setiap sisi pada segitiga siku-siku? Apakah dari hubungan tersebut dapat dikaitkan dengan Teorema Pythagoras? Jelaskan.
                            </label>
                            <textarea class="form-control" rows="3" id="ref_tri_2_text" placeholder="Tuliskan pemahamanmu..."></textarea>
                        </div>
            
                        <div class="text-center mt-4">
                            <button class="btn btn-success fw-bold" onclick="cekRefleksiTripel()">Simpan Refleksi</button>
                        </div>
            
                        <div class="text-center mt-4">
                            <p>Setelah mempelajari materi tentang Menemukan Konsep Teorema Pythagoras. Silahkan kerjakan Kuis 2 - Tripel Pythagoras</p>
                        </div>
            
                    </div>
                </div>
            </div>

        </div>  
    </section>

    <nav>
        <ul class="pagination justify-content-center materi-pagination">
            <li class="page-item">
                <button class="page-link prev-btn">‹</button>
            </li>
            <li class="page-item active">
                <button class="page-link page-btn" data-page="0">1</button>
            </li>
            <li class="page-item">
                <button class="page-link page-btn" data-page="1">2</button>
            </li>
            <li class="page-item">
                <button class="page-link page-btn" data-page="2">3</button>
            </li>
            <li class="page-item">
                <button class="page-link page-btn" data-page="3">4</button>
            </li>
            <li class="page-item">
                <button class="page-link page-btn" data-page="4">5</button>
            </li>
            <li class="page-item">
                <button class="page-link next-btn">›</button>
            </li>
        </ul>
    </nav>

</div>
@endsection