<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ $aktivitas->judul }}</title>

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            background: #fbfdfb;
            font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, Arial;
        }

        .kuis-container {
            max-width: 1400px;
        }

        .kuis-title h4 {
            color: #0b5e3f;
            font-weight: 800;
        }

        /* Card utama */
        .question-card {
            min-height: 550px;
            border-radius: 12px;
            border: 1px solid #e6ece8;
        }

        /* Header soal */
        .question-header {
            border-bottom: 1px solid #e6ece8;
        }

        .question-number {
            color: #0b5e3f;
            font-weight: 600;
        }

        .timer {
            color: #c82333;
            font-weight: 600;
        }

        /* Gambar soal */
        .question-image {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .question-image img {
            object-fit: contain;
            max-height: 300px;
        }

        /* Opsi jawaban */
        .option-item {
            border: 2px solid #e6ece8;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .option-item:hover {
            border-color: #cfe7dc;
            background: #f8fdfa;
        }

        .option-item.selected {
            border-color: #146b42;
            background: #f0f9f4;
        }

        /* Mode review */
        .option-item.correct {
            border-color: #28a745;
            background: #d4edda;
        }

        .option-item.incorrect {
            border-color: #dc3545;
            background: #f8d7da;
        }

        /* Panel nomor soal */
        .panel-sidebar {
            position: sticky;
            top: 20px;
            border: 1px solid #e6ece8;
            border-radius: 12px;
            height: 550px;
            display: flex;
            flex-direction: column;
        }

        .palette-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            overflow-y: auto;
        }

        .num-btn {
            aspect-ratio: 1;
            border: 2px solid #0f593f;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .num-btn:hover {
            border-color: #0b5e3f;
            background-color: #eaf6ef;
        }

        .num-btn.answered {
            border: 1px solid #0f593f;
            background-color: #0f593f;
            color: white;
        }

        .num-btn.current {
            border-color: #146b42;
            background-color: #eaf6ef;
            color: #000000;
        }

        /* Tombol */
        .btn-mulai {
            background: #146b42;
            color: white;
            font-weight: 700;
            padding: 10px 28px;
        }

        .btn-kembali {
            border: 2px solid #146b42;
            color: #146b42;
            background: transparent;
            padding: 8px 24px;
        }

        .btn-flag {
            background: #e0b114ff;
            border: 1px solid #ffecb5;
            color: #ffffff;
        }

        .btn-flag:hover {
            background: #fff3cd;
            border-color: #ffecb5;
            color: #664d03;
        }

        .num-btn.flagged {
            background: #fff3cd !important;
            border-color: #ffecb5 !important;
            color: #664d03 !important;
        }

        /* Modal hasil */
        .score-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: #146b42;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .detail-item.correct {
            border-left: 4px solid #28a745;
            background: #d4edda;
        }

        .detail-item.incorrect {
            border-left: 4px solid #dc3545;
            background: #f8d7da;
        }

        /* Style untuk tombol review actions */
        #reviewActions {
            margin-top: 10px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .question-card {
                min-height: 400px;
            }

            .panel-sidebar {
                height: 400px;
                position: relative;
                top: 0;
                margin-top: 20px;
            }

            .palette-grid {
                grid-template-columns: repeat(4, 1fr);
            }

            .question-image img {
                max-height: 200px;
            }
        }

        @media (max-width: 576px) {
            .palette-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .score-circle {
                width: 100px;
                height: 100px;
            }
        }

        /* Efek animasi pop-in untuk poin gamifikasi */
        @keyframes popIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            80% {
                transform: scale(1.15);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .pop-in-animation {
            animation: popIn 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }
    </style>
</head>

<body
    data-aktivitas-id="{{ $aktivitas->id }}"
    data-status="{{ $statusAktivitas['status'] }}"
    data-waktu-mulai="{{ $statusAktivitas['waktu_mulai'] }}"
    data-waktu-selesai="{{ $statusAktivitas['waktu_selesai'] }}"
    data-next-materi-url="{{ $nextMateriUrl }}"
    data-back-materi-url="{{ $backMateriUrl }}"
    data-is-evaluasi="{{ $isEvaluasi ? 'true' : 'false' }}"
    class="py-4">

    <div class="container kuis-container">

        <div class="kuis-title text-center mb-4">
            <h4>{{ $aktivitas->judul }}</h4>
            <p class="text-muted mb-0">
                <i class="bi bi-clock me-1"></i> Durasi: <span id="durasiLabel">...</span> Menit |
                <i class="bi bi-list-ol me-1"></i> Jumlah Soal: <span id="jumlahSoalLabelTitle">...</span> Butir |
                <i class="bi bi-star me-1"></i> Nilai Maksimal: {{ $aktivitas->poin_didapat }}
            </p>
        </div>

        <div id="instructionPage" class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="text-center mb-4">Petunjuk Pengerjaan</h5>

                <ol class="mb-4 text-muted" style="line-height: 1.8;">
                    <li>Aktivitas ini terdiri dari <strong class="text-dark"><span id="jumlahSoalLabelList">...</span> butir soal</strong>.</li>
                    <li>Tekan tombol <span class="fw-bold text-success">MULAI</span> di bawah untuk masuk ke halaman kuis.</li>
                    <li>Waktu pengerjaan akan <strong>dihitung mundur otomatis</strong> begitu Anda menekan tombol mulai.</li>
                    <li>Pastikan perangkat terhubung dengan <strong>koneksi internet yang stabil</strong>.</li>
                    <li>Kerjakan soal dengan teliti dan jujur.</li>
                    <li>Periksa kembali jawaban sebelum mengirimkan.</li>
                    <li>Jika waktu habis, jawaban yang sudah terisi akan <strong>tersimpan dan terkirim secara otomatis</strong>.</li>

                    @if($isEvaluasi)
                    <div class="alert alert-warning mt-3">
                        <i class="bi bi-exclamation-triangle"></i> Evaluasi hanya dapat dikerjakan <strong>satu kali</strong>. Pastikan Anda siap sebelum memulai.
                    </div>
                    @endif
                </ol>

                <div class="text-center">
                    <button id="startBtn" class="btn btn-success btn-lg px-5 shadow" disabled title="Menunggu aktivitas dibuka oleh guru">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Memuat Data...
                    </button>
                    <br><br>
                    <button id="backBtn" class="btn btn-outline-secondary btn-sm">Batal & Kembali</button>
                </div>
            </div>
        </div>

        <div id="quizPage" class="d-none mt-4">
            <div class="row g-3">

                <div class="col-lg-8 col-12">
                    <div class="card question-card h-100">
                        <div class="card-header question-header bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="question-number">Soal No. <span id="qIndex">1</span></div>
                                <div class="timer">
                                    <i class="bi bi-clock me-1"></i>
                                    <span id="timeText">00:00</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-body d-flex flex-column h-100">
                            <div class="flex-grow-1" id="questionArea"></div>

                            <div class="mt-auto pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <button id="flagBtn" class="btn btn-flag btn-sm">
                                            <i class="bi bi-flag"></i> Tandai
                                        </button>
                                        <div id="reviewActions" class="d-none d-inline-block ms-2">
                                            <button id="backFromReviewBtn" class="btn btn-outline-secondary btn-sm me-2">
                                                <i class="bi bi-arrow-left"></i> Kembali
                                            </button>
                                            <button id="nextMateriBtn" class="btn btn-primary btn-sm">
                                                <i class="bi bi-arrow-right"></i> Lanjut
                                            </button>
                                        </div>
                                    </div>
                                    <div class="nav-buttons">
                                        <button id="prevBtn" class="btn btn-outline-primary btn-sm" disabled>
                                            <i class="bi bi-chevron-left"></i> Sebelumnya
                                        </button>
                                        <button id="nextBtn" class="btn btn-primary btn-sm ms-2">
                                            Berikutnya <i class="bi bi-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="panel-sidebar bg-white p-3">
                        <h6 class="text-center mb-3">Nomor Soal</h6>
                        <div class="d-flex flex-wrap gap-2 justify-content-center mb-3 small" style="font-size: 0.8rem;">
                            <div class="d-flex align-items-center">
                                <span class="d-inline-block rounded border border-dark" style="width: 12px; height: 12px; background-color: #fff; margin-right: 4px;"></span> Belum dijawab
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="d-inline-block rounded border border-dark" style="width: 12px; height: 12px; background-color: #0f593f; margin-right: 4px;"></span> Sudah dijawab
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="d-inline-block rounded border border-dark" style="width: 12px; height: 12px; background-color: #fff3cd; margin-right: 4px;"></span> Ragu-ragu
                            </div>
                            <div class="d-flex align-items-center" id="legendaReview" style="display: none !important;">
                                <span class="d-inline-block rounded border border-dark" style="width: 12px; height: 12px; background-color: #dc3545; margin-right: 4px;"></span> Salah
                            </div>
                        </div>
                        <div id="palette" class="palette-grid mb-3"></div>
                        <div class="mt-auto">
                            <button id="finishBtn" class="btn btn-success w-100">Selesai Mengerjakan</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div id="resultModal" class="modal fade" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-success text-white py-2">
                    <h5 class="modal-title">Hasil Aktivitas</h5>
                </div>
                <div class="modal-body p-3">
                    <div class="text-center mb-2">
                        <div class="score-circle mb-2 shadow" style="width: 120px; height: 120px;">
                            <span class="score-value display-5 fw-bold" id="finalScore">0</span>
                            <span class="score-label small">Nilai</span>
                            <div id="gamificationPointPlaceholder" class="position-absolute top-0 start-100 translate-middle"></div>
                        </div>
                        <h5 class="text-success mb-1">{{ $aktivitas->judul }}</h5>
                        <div id="statusBadgeContainer" class="mt-1"></div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <div class="p-2 border rounded text-center bg-light">
                                <h5 class="text-dark mb-0" id="totalSoal">0</h5>
                                <small class="text-muted">Total</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 border rounded text-center bg-success-subtle">
                                <h5 class="text-success mb-0" id="benarCount">0</h5>
                                <small class="text-muted">Benar</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 border rounded text-center bg-danger-subtle">
                                <h5 class="text-danger mb-0" id="salahCount">0</h5>
                                <small class="text-muted">Salah</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h6 class="mb-0 small">Detail Pengerjaan</h6>
                            <span class="badge bg-secondary small">Review</span>
                        </div>
                        <div id="resultDetails" style="max-height: 200px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 6px; font-size: 0.8rem;"></div>
                    </div>
                </div>
                <div class="modal-footer py-2">
                    @if(!$isEvaluasi)
                    <button id="reviewBtn" class="btn btn-outline-success btn-sm">Review Jawaban</button>
                    @endif
                    <div id="resultActionButtons" class="d-inline-block">
                        <!-- Tombol dinamis -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        /* =============================
        SETUP VARIABEL GLOBAL
        ============================= */
        const AKTIVITAS_ID = document.body.dataset.aktivitasId;
        const MATERI_SEKARANG = document.body.dataset.materiSekarang;
        const NEXT_MATERI_URL = document.body.dataset.nextMateriUrl || '/siswa/dashboard';
        const BACK_MATERI_URL = document.body.dataset.backMateriUrl || '/siswa/dashboard';
        const IS_EVALUASI = document.body.dataset.isEvaluasi === 'true';
        const START_URL = "{{ route('siswa.kuis.start', $aktivitas->id) }}";
        const VIOLATION_URL = "{{ route('siswa.kuis.violation') }}";
        const QUIZ_DRAFT_KEY = `quiz_draft_${AKTIVITAS_ID}`;

        let bolehKeluarHalaman = false;
        let sedangSubmit = false;
        let pelanggaranCount = 0;
        const MAKS_PELANGGARAN = IS_EVALUASI ? 2 : 3;

        // --- VARIABEL DARI CONTROLLER UNTUK REMEDIAL ---
        const JUMLAH_PERCOBAAN = parseInt('{{ $jumlahPercobaan ?? 0 }}');
        const NILAI_PERTAMA = '{{ $nilaiPertama ?? "null" }}' === "null" ? null : parseInt('{{ $nilaiPertama }}');
        const KKM = parseInt('{{ $kkm ?? 70 }}');
        // -----------------------------------------------

        // ELEMENT REFERENCES
        const instructionPage = document.getElementById('instructionPage');
        const quizPage = document.getElementById('quizPage');
        const startBtn = document.getElementById('startBtn');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const finishBtn = document.getElementById('finishBtn');
        const flagBtn = document.getElementById('flagBtn');
        const resultModal = new bootstrap.Modal(document.getElementById('resultModal'));
        const reviewBtn = document.getElementById('reviewBtn');

        let questions = [];
        let answers = [];
        let flagged = [];
        let idx = 0;
        let timeLeft = 0;
        let timerInterval = null;
        let quizStarted = false;
        let isReviewMode = false;
        let quizResult = null;
        let waktuMulaiClient = null;



        /* =============================
        1. LOAD DATA DARI API (INIT)
        ============================= */
        fetch(`/siswa/api/aktivitas/${AKTIVITAS_ID}/soal`)
            .then(async res => {

                // ====== KHUSUS STATUS AKTIVITAS (403) ======
                if (res.status === 403) {
                    const data = await res.json();
                    startBtn.disabled = true;
                    const jenis = IS_EVALUASI ? 'Evaluasi' : 'Kuis';
                    startBtn.innerHTML = jenis + ' Belum Tersedia';
                    startBtn.classList.remove('btn-success');
                    startBtn.classList.add('btn-secondary');

                    Swal.fire({
                        icon: 'info',
                        title: jenis + ' Belum Tersedia',
                        text: data.error || (IS_EVALUASI ? 'Evaluasi ini belum dibuka oleh guru.' : 'Kuis ini belum dibuka oleh guru.'),
                        confirmButtonText: 'Mengerti'
                    });
                    return null;
                }

                // ====== ERROR TEKNIS ======
                if (!res.ok) {
                    throw new Error('Gagal memuat data');
                }

                return res.json();
            })
            .then(data => {
                if (!data) return;

                if (!data.jumlah_soal || data.jumlah_soal === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Soal Kosong',
                        text: 'Paket soal belum memiliki butir soal.'
                    });
                    return;
                }

                const jumlahSoal = data.jumlah_soal;

                const totalSoalTitle = document.getElementById('jumlahSoalLabelTitle');
                const totalSoalList = document.getElementById('jumlahSoalLabelList');

                if (totalSoalTitle) totalSoalTitle.textContent = jumlahSoal;
                if (totalSoalList) totalSoalList.textContent = jumlahSoal;

                // SETUP DURASI (Server-Side Validated)
                if (data.sisa_detik) {
                    timeLeft = data.sisa_detik; // Patuh pada sisa waktu dari database
                } else if (data.durasi_menit) {
                    timeLeft = data.durasi_menit * 60;
                } else {
                    timeLeft = 20 * 60;
                }

                const labelDurasi = document.getElementById('durasiLabel');
                if (labelDurasi) labelDurasi.textContent = data.durasi_menit || 20;

                // AKTIFKAN TOMBOL
                startBtn.disabled = false;

                if (adaKunciKuisAktifUntukAktivitasIni()) {
                    startBtn.innerHTML = 'LANJUT MENGERJAKAN';
                    startBtn.title = 'Lanjutkan kuis yang sedang berlangsung';
                } else {
                    startBtn.innerHTML = 'MULAI MENGERJAKAN';
                    startBtn.title = 'Mulai mengerjakan kuis';
                }

                startBtn.classList.remove('btn-secondary');
                startBtn.classList.add('btn-success');
            })
            .catch(err => {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal memuat data aktivitas. Silakan refresh halaman.'
                });
            });


        /* =============================
        FUNGSI NAVIGASI & UTILITAS
        ============================= */
        function ulangiKuis() {
            const jenisText = IS_EVALUASI ? 'Evaluasi' : 'Kuis';
            Swal.fire({
                title: `Ulangi ${jenisText}?`,
                text: 'Apakah Anda yakin ingin mengulang dari awal?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Ulangi',
                confirmButtonColor: '#146b42'
            }).then((result) => {
                if (result.isConfirmed) location.reload();
            });
        }

        function kembaliKeMateri() {
            if (!quizStarted) {
                hapusKunciKuisAktif();
            }
            if (quizStarted && !isReviewMode) {
                Swal.fire({
                    title: 'Kuis Sedang Berlangsung',
                    text: 'Anda tidak dapat kembali ke materi sebelum menyelesaikan kuis.',
                    icon: 'warning',
                    confirmButtonColor: '#146b42'
                });

                catatPelanggaran('manual_back_button', 'Siswa menekan tombol kembali saat kuis berlangsung.');
                return;
            }

            Swal.fire({
                title: 'Kembali?',
                text: 'Anda akan kembali ke materi.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Kembali',
                confirmButtonColor: '#146b42'
            }).then((result) => {
                if (result.isConfirmed) arahkanAman(BACK_MATERI_URL);
            });
        }

        function lanjutKeMateriBerikutnya() {
            arahkanAman(NEXT_MATERI_URL);
        }

        function aturTampilanTombolReview() {
            const nextMateriBtn = document.getElementById('nextMateriBtn');
            const ulangiBtn = document.getElementById('ulangiBtn');

            // Cek apakah sudah lulus (dari quizResult setelah submit)
            const isPassed = quizResult ? quizResult.is_passed : false;

            if (isPassed) {
                if (nextMateriBtn) {
                    nextMateriBtn.innerHTML = '<i class="bi bi-arrow-right"></i> Lanjut Materi';
                    nextMateriBtn.onclick = () => {
                        arahkanAman(NEXT_MATERI_URL);
                    };
                }
            } else {
                if (nextMateriBtn) {
                    nextMateriBtn.innerHTML = '<i class="bi bi-book"></i> Kembali Pelajari Materi';
                    nextMateriBtn.onclick = () => {
                        arahkanAman(BACK_MATERI_URL);
                    };
                }
            }

            if (ulangiBtn) ulangiBtn.onclick = ulangiKuis;
        }

        function arahkanAman(url) {
            bolehKeluarHalaman = true;
            window.location.href = url;
        }

        function simpanKunciKuisAktif() {
            localStorage.setItem('active_quiz_lock', JSON.stringify({
                aktivitas_id: AKTIVITAS_ID,
                quiz_url: window.location.href,
                violation_url: VIOLATION_URL,
                started_at: new Date().toISOString()
            }));
        }

        function hapusKunciKuisAktif() {
            localStorage.removeItem('active_quiz_lock');
        }

        function getKunciKuisAktif() {
            const rawLock = localStorage.getItem('active_quiz_lock');

            if (!rawLock) return null;

            try {
                return JSON.parse(rawLock);
            } catch (e) {
                localStorage.removeItem('active_quiz_lock');
                return null;
            }
        }

        function adaKunciKuisAktifUntukAktivitasIni() {
            const lock = getKunciKuisAktif();

            return lock && String(lock.aktivitas_id) === String(AKTIVITAS_ID);
        }

        function simpanDraftKuis() {
            if (!quizStarted) return;

            localStorage.setItem(QUIZ_DRAFT_KEY, JSON.stringify({
                answers: answers,
                flagged: flagged,
                idx: idx,
                updated_at: new Date().toISOString()
            }));
        }

        function muatDraftKuis() {
            const rawDraft = localStorage.getItem(QUIZ_DRAFT_KEY);

            if (!rawDraft) return false;

            try {
                const draft = JSON.parse(rawDraft);

                if (
                    Array.isArray(draft.answers) &&
                    Array.isArray(draft.flagged) &&
                    draft.answers.length === questions.length &&
                    draft.flagged.length === questions.length
                ) {
                    answers = draft.answers;
                    flagged = draft.flagged;

                    if (Number.isInteger(draft.idx) && draft.idx >= 0 && draft.idx < questions.length) {
                        idx = draft.idx;
                    } else {
                        idx = 0;
                    }

                    return true;
                }
            } catch (e) {
                localStorage.removeItem(QUIZ_DRAFT_KEY);
            }

            return false;
        }

        function hapusDraftKuis() {
            localStorage.removeItem(QUIZ_DRAFT_KEY);
        }

        window.__kuisGuard = window.__kuisGuard || {
            pengawasanTabAktif: false,
            terakhirPelanggaranTab: 0
        };

        function aktifkanPengawasanTab() {
            if (window.__kuisGuard.pengawasanTabAktif) {
                return;
            }

            window.__kuisGuard.pengawasanTabAktif = true;

            document.addEventListener('visibilitychange', function() {
                if (!quizStarted || isReviewMode || sedangSubmit || bolehKeluarHalaman) {
                    return;
                }

                if (document.hidden) {
                    const sekarang = Date.now();

                    if (sekarang - window.__kuisGuard.terakhirPelanggaranTab < 1500) {
                        return;
                    }

                    window.__kuisGuard.terakhirPelanggaranTab = sekarang;

                    tanganiPelanggaran(
                        'tab_hidden',
                        'Halaman kuis ditinggalkan atau siswa membuka tab/aplikasi lain.'
                    );
                }
            });
        }

        function catatPelanggaran(jenis, detail = '') {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            fetch(VIOLATION_URL, {
                method: 'POST',
                keepalive: true,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    aktivitas_id: AKTIVITAS_ID,
                    jenis: jenis,
                    detail: detail
                })
            }).catch(err => console.warn('Gagal mencatat pelanggaran:', err));
        }

        function tanganiPelanggaran(jenis, detail) {
            pelanggaranCount++;
            catatPelanggaran(jenis, detail);

            if (IS_EVALUASI && pelanggaranCount >= MAKS_PELANGGARAN) {
                Swal.fire({
                    icon: 'error',
                    title: 'Evaluasi Dikumpulkan Otomatis',
                    text: 'Anda beberapa kali meninggalkan halaman evaluasi. Jawaban akan dikumpulkan otomatis.',
                    confirmButtonColor: '#dc3545',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    submitQuiz();
                });

                return;
            }

            Swal.fire({
                icon: 'warning',
                title: 'Peringatan Kejujuran',
                html: `
            Sistem mendeteksi Anda meninggalkan halaman kuis/evaluasi.<br>
            Pelanggaran: <b>${pelanggaranCount}/${MAKS_PELANGGARAN}</b><br><br>
            Tetap fokus pada halaman pengerjaan.
        `,
                confirmButtonColor: '#146b42',
                allowOutsideClick: false
            });
        }


        /* =============================
        MODE REVIEW
        ============================= */
        function masukModeReview() {
            isReviewMode = true;
            resultModal.hide();

            finishBtn.classList.add('d-none');
            flagBtn.classList.add('d-none');

            const sidebarTitle = document.querySelector('.panel-sidebar h6');
            if (sidebarTitle) sidebarTitle.textContent = 'Review Jawaban';

            const actions = document.getElementById('reviewActions');
            if (actions) actions.classList.remove('d-none');

            aturTampilanTombolReview();
            renderQuestion(idx);
        }

        document.getElementById('resultModal').addEventListener('hidden.bs.modal', function() {
            if (!isReviewMode && !IS_EVALUASI) masukModeReview();
        });


        /* =============================
        MULAI KUIS DENGAN PERINGATAN
        ============================= */
        startBtn.onclick = () => {
            // JIKA SUDAH PERNAH MENGERJAKAN (Logika Pengayaan/Remedial)
            if (JUMLAH_PERCOBAAN > 0) {
                let pesanAlert = '';
                if (NILAI_PERTAMA >= KKM) {
                    pesanAlert = `Kamu sudah pernah mengerjakan kuis ini dengan nilai <b>${NILAI_PERTAMA}</b> (Lulus).<br><br>Kamu boleh mengerjakan lagi untuk latihan (Pengayaan), namun <b>nilai resmi yang tercatat di rapor akan tetap ${NILAI_PERTAMA}</b>. Lanjutkan?`;
                } else {
                    pesanAlert = `Kamu sedang melakukan <b>Remedial</b> (Nilai awal: ${NILAI_PERTAMA}).<br><br>Jika kali ini kamu mendapat nilai di atas KKM (${KKM}), maka nilai resmimu akan dibatasi maksimal sebesar <b>${KKM}</b>. Lanjutkan?`;
                }

                Swal.fire({
                    title: 'Informasi Pengerjaan Ulang',
                    html: pesanAlert,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        jalankanKuis();
                    }
                });
            } else {
                // Jika baru pertama kali
                jalankanKuis();
            }
        };


        async function jalankanKuis() {
            if (quizStarted) return;

            try {
                startBtn.disabled = true;
                startBtn.innerHTML = 'Menyiapkan Kuis...';

                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                const res = await fetch(START_URL, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                const data = await res.json();

                if (!res.ok) {
                    throw new Error(data.error || 'Gagal memulai kuis.');
                }

                questions = data.soal;
                answers = Array(questions.length).fill(null);
                flagged = Array(questions.length).fill(false);
                timeLeft = data.sisa_detik;

                const sedangMelanjutkan = adaKunciKuisAktifUntukAktivitasIni();

                if (sedangMelanjutkan) {
                    muatDraftKuis();
                } else {
                    hapusDraftKuis();
                }

                const totalSoalTitle = document.getElementById('jumlahSoalLabelTitle');
                const totalSoalList = document.getElementById('jumlahSoalLabelList');

                if (totalSoalTitle) totalSoalTitle.textContent = questions.length;
                if (totalSoalList) totalSoalList.textContent = questions.length;

                instructionPage.classList.add('d-none');
                quizPage.classList.remove('d-none');

                quizStarted = true;
                waktuMulaiClient = new Date();

                simpanKunciKuisAktif();

                aktifkanPengawasanTab();

                renderPalette();
                renderQuestion(idx);
                startTimer();

            } catch (err) {
                startBtn.disabled = false;
                startBtn.innerHTML = 'MULAI MENGERJAKAN';

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Memulai',
                    text: err.message,
                    confirmButtonColor: '#dc3545'
                });
            }
        }


        /* =============================
        EVENT LISTENERS BUTTON
        ============================= */
        document.getElementById('backBtn').onclick = kembaliKeMateri;
        const backReview = document.getElementById('backFromReviewBtn');
        if (backReview) backReview.onclick = kembaliKeMateri;

        const ulangiBtn = document.getElementById('ulangiBtn');
        if (ulangiBtn) ulangiBtn.onclick = ulangiKuis;

        if (reviewBtn) reviewBtn.onclick = masukModeReview;

        if (IS_EVALUASI && flagBtn) {
            flagBtn.style.display = 'none';
        }


        /* =============================
        RENDER SOAL
        ============================= */
        function renderQuestion(i) {
            idx = i;
            document.getElementById('qIndex').textContent = i + 1;

            const q = questions[i];
            const area = document.getElementById('questionArea');

            const hasImage = q.image && q.image.trim() !== '';

            let contentHTML = '';

            if (hasImage) {
                contentHTML = `
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="question-image h-100 d-flex align-items-center justify-content-center bg-light">
                                <img src="${q.image}" class="img-fluid" style="max-height:300px" alt="Gambar soal">
                            </div>
                        </div>
                        <div class="col-md-6">
                            ${q.text ? `<div class="mb-4 fs-5">${q.text.replace(/\n/g, '<br>')}</div>` : ''}
                            <div id="optionsContainer">
                                ${renderOptionsHTML(q)}
                            </div>
                        </div>
                    </div>
                `;
            } else {
                contentHTML = `
                    <div>
                        ${q.text ? `<div class="mb-4 fs-5">${q.text.replace(/\n/g, '<br>')}</div>` : ''}
                        <div id="optionsContainer">
                            ${renderOptionsHTML(q)}
                        </div>
                    </div>
                `;
            }

            area.innerHTML = contentHTML;

            if (!isReviewMode) {
                document.querySelectorAll('.option-item').forEach(item => {
                    const key = item.dataset.key;
                    item.onclick = () => selectOption(key);
                });
            }

            flagBtn.innerHTML = flagged[i] ?
                '<i class="bi bi-flag-fill"></i> Batal Tandai' :
                '<i class="bi bi-flag"></i> Tandai';

            prevBtn.disabled = i === 0;
            nextBtn.disabled = i === questions.length - 1;

            simpanDraftKuis();
            updatePalette();
        }

        /* =============================
        RENDER OPSI
        ============================= */
        function renderOptionsHTML(q) {
            let optionsHTML = '';
            const isIsian = !q.options || Object.keys(q.options).length === 0;

            // MODE ISIAN
            if (isIsian) {
                const userAnswer = answers[idx] || '';

                optionsHTML += `
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jawaban Anda:</label>
                        <input type="text"
                            class="form-control"
                            value="${userAnswer}"
                            ${isReviewMode ? 'disabled' : ''}
                            oninput="answers[idx] = this.value; simpanDraftKuis(); updatePalette();">
                    </div>
                `;

                if (isReviewMode && quizResult) {
                    const res = quizResult.detail[idx];
                    optionsHTML += `
                        <div class="alert ${res.benar ? 'alert-success' : 'alert-danger'}">
                            ${res.benar ? 'Jawaban Anda Benar' : `Jawaban Salah. Kunci: <strong>${q.kunci_jawaban}</strong>`}
                        </div>
                    `;
                }
                return optionsHTML;
            }

            // MODE PILIHAN GANDA
            Object.entries(q.options).forEach(([key, opt]) => {
                let className = 'option-item p-3 mb-2';

                if (answers[idx] === key) className += ' selected';

                if (isReviewMode) {
                    if (key === q.kunci_jawaban) className += ' correct';
                    else if (answers[idx] === key && answers[idx] !== q.kunci_jawaban) className += ' incorrect';
                }

                optionsHTML += `
                    <div class="${className}" data-key="${key}">
                        <strong>${key}.</strong> ${opt.text}
                    </div>
                `;
            });

            return optionsHTML;
        }

        function selectOption(key) {
            if (!isReviewMode) {
                answers[idx] = key;
                simpanDraftKuis();
                renderQuestion(idx);
                updatePalette();
            }
        }


        /* =============================
        PALETTE & NAVIGASI
        ============================= */
        function renderPalette() {
            const palette = document.getElementById('palette');
            palette.innerHTML = '';

            questions.forEach((_, i) => {
                const btn = document.createElement('button');
                btn.type = 'button';

                let className = 'num-btn btn';
                if (i === idx) className += ' current';
                if (answers[i] !== null && answers[i] !== '') className += ' answered';
                if (flagged[i]) className += ' flagged';

                if (isReviewMode && quizResult) {
                    const res = quizResult.detail[i];
                    if (res && res.benar) {
                        className += ' bg-success text-white border-success';
                    } else if (res && !res.benar) {
                        className += ' bg-danger text-white border-danger';
                    }
                }

                btn.className = className;
                btn.textContent = i + 1;
                btn.onclick = () => renderQuestion(i);
                palette.appendChild(btn);
            });
        }

        function updatePalette() {
            renderPalette();
        }

        flagBtn.onclick = () => {
            flagged[idx] = !flagged[idx];
            flagBtn.innerHTML = flagged[idx] ?
                '<i class="bi bi-flag-fill"></i> Batal Tandai' :
                '<i class="bi bi-flag"></i> Tandai';

            simpanDraftKuis();
            updatePalette();
        };

        prevBtn.onclick = () => idx > 0 && renderQuestion(idx - 1);
        nextBtn.onclick = () => idx < questions.length - 1 && renderQuestion(idx + 1);


        /* =============================
        TIMER & SUBMIT
        ============================= */
        function startTimer() {
            timerInterval = setInterval(() => {
                timeLeft--;

                const m = String(Math.floor(timeLeft / 60)).padStart(2, '0');
                const s = String(timeLeft % 60).padStart(2, '0');
                document.getElementById('timeText').textContent = `${m}:${s}`;

                if (timeLeft < 60) {
                    document.querySelector('.timer').classList.add('text-danger');
                }

                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    Swal.fire({
                        icon: 'info',
                        title: 'Waktu Habis!',
                        text: 'Jawaban Anda akan dikirim otomatis.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        submitQuiz();
                    });
                }
            }, 1000);
        }

        finishBtn.onclick = async () => {
            const belum = answers.filter(a => a === null || a === '').length;
            const ditandai = flagged.filter(f => f === true).length;
            const jenisText = IS_EVALUASI ? 'Evaluasi' : 'Kuis'; // Penanda kata dinamis

            let config = {
                title: `Selesaikan ${jenisText}?`,
                text: 'Apakah Anda yakin ingin mengumpulkan jawaban?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Selesaikan',
                confirmButtonColor: '#146b42'
            };

            if (belum > 0) {
                config.title = 'Masih ada soal kosong!';
                config.text = `Anda belum menjawab ${belum} soal. Yakin ingin mengumpulkan ${jenisText} ini?`;
                config.icon = 'warning';
            } else if (ditandai > 0) {
                config.title = 'Ada soal yang ditandai!';
                config.text = `Anda menandai ragu-ragu pada ${ditandai} soal. Yakin ingin mengumpulkan ${jenisText} ini?`;
                config.icon = 'warning';
            }

            const result = await Swal.fire(config);
            if (result.isConfirmed) submitQuiz();
        };


        /* =============================
        SUBMIT KE SERVER 
        ============================= */
        function submitQuiz() {
            sedangSubmit = true;
            bolehKeluarHalaman = true;

            clearInterval(timerInterval);

            Swal.fire({
                title: 'Menyimpan...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            fetch('{{ route("siswa.kuis.submit") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        aktivitas_id: AKTIVITAS_ID,
                        jawaban: questions.map((q, i) => ({
                            soal_id: q.id,
                            jawaban: answers[i]
                        }))
                    })
                })
                .then(res => {
                    if (!res.ok) throw new Error('Server Error');
                    return res.json();
                })
                .then(data => {
                    Swal.close();
                    showResult(data);
                })
                .catch((error) => {
                    console.error(error);

                    sedangSubmit = false;
                    bolehKeluarHalaman = false;

                    Swal.fire({
                        title: 'Gagal Menyimpan',
                        text: 'Terjadi kesalahan koneksi. Silakan coba kirim ulang.',
                        icon: 'error',
                        confirmButtonText: 'Coba Lagi'
                    }).then((res) => {
                        if (res.isConfirmed) submitQuiz();
                    });
                });
        }


        /* =============================
        TAMPILKAN HASIL
        ============================= */
        function showResult(result) {
            hapusKunciKuisAktif();
            hapusDraftKuis();

            quizResult = result;

            document.getElementById('finalScore').textContent = result.skor;
            document.getElementById('totalSoal').textContent = result.total_soal;
            document.getElementById('benarCount').textContent = result.jumlah_benar;
            document.getElementById('salahCount').textContent = result.total_soal - result.jumlah_benar;

            const statusContainer = document.getElementById('statusBadgeContainer');
            statusContainer.innerHTML = '';
            const statusBadge = document.createElement('span');
            statusBadge.className = `badge ${result.is_passed ? 'bg-success' : 'bg-danger'} fs-6 px-3 py-2`;
            statusBadge.textContent = result.is_passed ? '✓ LULUS' : '✗ REMEDIAL (TIDAK LULUS)';
            statusContainer.appendChild(statusBadge);

            // Tampilkan detail pengerjaan
            const detailsContainer = document.getElementById('resultDetails');
            detailsContainer.innerHTML = '';

            if (IS_EVALUASI) {
                detailsContainer.innerHTML = '<p class="text-center text-muted mt-3">Detail jawaban tidak ditampilkan untuk evaluasi.</p>';
            } else {
                result.detail.forEach((item, index) => {
                    const detailDiv = document.createElement('div');
                    detailDiv.className = `p-2 mb-2 border-bottom ${item.benar ? 'bg-success-subtle' : 'bg-danger-subtle'}`;
                    const shortText = item.pertanyaan ? item.pertanyaan.substring(0, 60) + (item.pertanyaan.length > 60 ? '...' : '') : 'Soal Gambar';
                    detailDiv.innerHTML = `
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold small">No. ${index + 1}</span>
                            <span class="badge ${item.benar ? 'bg-success' : 'bg-danger'}">${item.benar ? 'Benar' : 'Salah'}</span>
                        </div>
                        <div class="small text-muted mt-1">${shortText}</div>
                    `;
                    detailsContainer.appendChild(detailDiv);
                });
            }

            // Atur tombol aksi di modal footer
            const actionContainer = document.getElementById('resultActionButtons');
            actionContainer.innerHTML = '';

            if (!IS_EVALUASI) {
                if (result.is_passed) {
                    const nextBtn = document.createElement('button');
                    nextBtn.className = 'btn btn-success';
                    nextBtn.textContent = 'Selesai & Lanjut';
                    nextBtn.onclick = () => {
                        arahkanAman(result.next_url);
                    };
                    actionContainer.appendChild(nextBtn);
                } else {
                    const ulangiBtn = document.createElement('button');
                    ulangiBtn.className = 'btn btn-warning me-2';
                    ulangiBtn.textContent = 'Ulangi Kuis';
                    ulangiBtn.onclick = () => {
                        Swal.fire({
                            title: 'Remedial',
                            text: 'Jika Anda mengulang dan lulus, nilai maksimal yang akan tercatat adalah KKM (70). Lanjutkan?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Ulangi',
                            cancelButtonText: 'Batal'
                        }).then((res) => {
                            if (res.isConfirmed) arahkanAman(result.remedial_url);
                        });
                    };
                    actionContainer.appendChild(ulangiBtn);

                    const materiBtn = document.createElement('button');
                    materiBtn.className = 'btn btn-outline-secondary';
                    materiBtn.textContent = 'Kembali Pelajari Materi';
                    materiBtn.onclick = () => {
                        arahkanAman(result.materi_url);
                    };
                    actionContainer.appendChild(materiBtn);
                }
            } else {
                const selesaiBtn = document.createElement('button');
                selesaiBtn.className = 'btn btn-success';
                selesaiBtn.textContent = 'Selesai';
                selesaiBtn.onclick = () => {
                    arahkanAman('/siswa/dashboard');
                };
                actionContainer.appendChild(selesaiBtn);
            }

            resultModal.show();
            // --- LOGIKA MENAMPILKAN POIN GAMIFIKASI DI DALAM MODAL ---
            const pointPlaceholder = document.getElementById('gamificationPointPlaceholder');
            pointPlaceholder.innerHTML = ''; // Reset isi placeholder

            if (result.poin_diberikan && result.poin_didapat > 0) {
                // Beri jeda sedikit (300ms) agar modal terbuka dulu, baru poinnya "muncul"
                setTimeout(() => {
                    pointPlaceholder.innerHTML = `
                        <span class="badge bg-warning text-dark border border-white border-2 shadow pop-in-animation d-flex align-items-center" style="font-size: 0.95rem; padding: 0.5rem 0.75rem;">
                            <i class="bi bi-star-fill text-danger me-1"></i> +${result.poin_didapat} Poin
                        </span>
                    `;
                }, 300);
            }
        }
    </script>


</body>

</html>