<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Evaluasi - {{ $aktivitas->judul }}</title>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
body {
    background:#fffafa;
    font-family: "Inter", system-ui;
}

.evaluasi-title h4 {
    color:#b02a37;
    font-weight:800;
}

.question-card {
    min-height:550px;
    border-radius:12px;
    border:1px solid #f1d6d9;
}

.timer {
    color:#dc3545;
    font-weight:600;
}

.num-btn {
    aspect-ratio:1;
    border:2px solid #b02a37;
    border-radius:8px;
    font-weight:600;
    cursor:pointer;
    display:flex;
    align-items:center;
    justify-content:center;
}

.num-btn.answered {
    background:#b02a37;
    color:white;
}

.score-circle {
    width:120px;
    height:120px;
    border-radius:50%;
    background:#b02a37;
    color:white;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    margin:0 auto 20px;
}
</style>
</head>

<body data-aktivitas-id="{{ $aktivitas->id }}" class="py-4">

<div class="container">

    <!-- HEADER -->
    <div class="evaluasi-title text-center mb-4">
        <h4><i class="bi bi-award"></i> Evaluasi Akhir</h4>
        <p class="text-muted mb-0">
            <i class="bi bi-clock"></i> Durasi: 
            <span id="durasiLabel">...</span> Menit |
            <i class="bi bi-star"></i> Nilai Maksimal: {{ $aktivitas->poin_didapat }}
        </p>
    </div>

    <!-- INSTRUKSI -->
    <div id="instructionPage" class="card shadow-sm border-0">
        <div class="card-body text-center">
            <h5 class="mb-4">Petunjuk Evaluasi</h5>
            <ol class="text-start text-muted">
                <li>Tekan tombol MULAI untuk memulai evaluasi.</li>
                <li>Waktu berjalan otomatis.</li>
                <li>Pastikan koneksi stabil.</li>
                <li>Jawaban akan otomatis terkirim jika waktu habis.</li>
            </ol>

            <button id="startBtn" class="btn btn-danger btn-lg px-5 shadow">
                MULAI EVALUASI
            </button>
        </div>
    </div>

    <!-- HALAMAN SOAL -->
    <div id="quizPage" class="d-none mt-4">
        <div class="card question-card">
            <div class="card-header bg-white d-flex justify-content-between">
                <div>Soal No. <span id="qIndex">1</span></div>
                <div class="timer">
                    <i class="bi bi-clock"></i>
                    <span id="timeText">00:00</span>
                </div>
            </div>

            <div class="card-body">
                <div id="questionArea"></div>

                <div class="mt-4 text-end">
                    <button id="prevBtn" class="btn btn-outline-danger btn-sm">Sebelumnya</button>
                    <button id="nextBtn" class="btn btn-danger btn-sm">Berikutnya</button>
                    <button id="finishBtn" class="btn btn-success btn-sm">
                        <i class="bi bi-check-circle"></i> Selesai
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- MODAL HASIL -->
<div id="resultModal" class="modal fade" tabindex="-1" data-bs-backdrop="static">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header bg-danger text-white">
    <h5 class="modal-title">Hasil Evaluasi</h5>
</div>
<div class="modal-body text-center">

    <div class="score-circle">
        <span class="display-4 fw-bold" id="finalScore">0</span>
        <small>Nilai</small>
    </div>

    <p id="resultInfo"></p>

</div>
<div class="modal-footer">
    <button onclick="window.location.href='/siswa/dashboard'" class="btn btn-danger">
        Selesai
    </button>
</div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
const AKTIVITAS_ID = document.body.dataset.aktivitasId;

let questions = [];
let answers = [];
let idx = 0;
let timeLeft = 0;
let timerInterval;

const startBtn = document.getElementById('startBtn');
const quizPage = document.getElementById('quizPage');
const instructionPage = document.getElementById('instructionPage');
const resultModal = new bootstrap.Modal(document.getElementById('resultModal'));

fetch(`/siswa/api/evaluasi/${AKTIVITAS_ID}/soal`)
.then(res => res.json())
.then(data => {
    questions = data.soal;
    answers = Array(questions.length).fill(null);
    timeLeft = data.durasi_menit * 60;
    document.getElementById('durasiLabel').textContent = data.durasi_menit;
});

startBtn.onclick = () => {
    instructionPage.classList.add('d-none');
    quizPage.classList.remove('d-none');
    renderQuestion(0);
    startTimer();
};

function renderQuestion(i) {
    idx = i;
    document.getElementById('qIndex').textContent = i + 1;
    const q = questions[i];

    let html = `<div class="mb-3 fs-5">${q.text}</div>`;

    Object.entries(q.options).forEach(([key, opt]) => {
        html += `
            <div class="form-check mb-2">
                <input class="form-check-input" type="radio"
                    name="jawaban" value="${key}"
                    ${answers[i] === key ? 'checked' : ''}
                    onclick="answers[${i}]='${key}'">
                <label class="form-check-label">
                    ${key}. ${opt.text}
                </label>
            </div>
        `;
    });

    document.getElementById('questionArea').innerHTML = html;
}

document.getElementById('nextBtn').onclick = () => {
    if (idx < questions.length - 1) renderQuestion(idx + 1);
};

document.getElementById('prevBtn').onclick = () => {
    if (idx > 0) renderQuestion(idx - 1);
};

document.getElementById('finishBtn').onclick = () => {
    submitEvaluasi();
};

function startTimer() {
    timerInterval = setInterval(() => {
        timeLeft--;
        const m = String(Math.floor(timeLeft / 60)).padStart(2, '0');
        const s = String(timeLeft % 60).padStart(2, '0');
        document.getElementById('timeText').textContent = `${m}:${s}`;

        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            submitEvaluasi();
        }
    }, 1000);
}

function submitEvaluasi() {

    fetch('{{ route("siswa.kuis.submit") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            aktivitas_id: AKTIVITAS_ID,
            jawaban: questions.map((q, i) => ({
                soal_id: q.id,
                jawaban: answers[i]
            }))
        })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('finalScore').textContent = data.skor;
        document.getElementById('resultInfo').innerText =
            `Benar: ${data.jumlah_benar} dari ${data.total_soal} soal`;

        resultModal.show();
    });
}
</script>

</body>
</html>
