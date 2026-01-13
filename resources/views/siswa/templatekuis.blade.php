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
      background:#fbfdfb;
      font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, Arial;
    }

    .kuis-container {
      max-width:1400px;
    }

    .kuis-title h4 {
      color:#0b5e3f;
      font-weight:800;
    }

    /* Card utama */
    .question-card {
      min-height:550px;
      border-radius:12px;
      border:1px solid #e6ece8;
    }

    /* Header soal */
    .question-header {
      border-bottom:1px solid #e6ece8;
    }

    .question-number {
      color:#0b5e3f;
      font-weight:600;
    }

    .timer {
      color:#c82333;
      font-weight:600;
    }

    /* Gambar soal */
    .question-image {
      border-radius:8px;
      overflow:hidden;
      box-shadow:0 4px 12px rgba(0,0,0,0.08);
    }

    .question-image img {
      object-fit:contain;
      max-height:300px;
    }

    /* Opsi jawaban */
    .option-item {
      border:2px solid #e6ece8;
      border-radius:8px;
      cursor:pointer;
      transition:all 0.2s;
    }

    .option-item:hover {
      border-color:#cfe7dc;
      background:#f8fdfa;
    }

    .option-item.selected {
      border-color:#146b42;
      background:#f0f9f4;
    }

    /* Mode review */
    .option-item.correct {
      border-color:#28a745;
      background:#d4edda;
    }

    .option-item.incorrect {
      border-color:#dc3545;
      background:#f8d7da;
    }

    /* Panel nomor soal */
    .panel-sidebar {
      position:sticky;
      top:20px;
      border:1px solid #e6ece8;
      border-radius:12px;
      height:550px;
      display:flex;
      flex-direction:column;
    }

    .palette-grid {
      display:grid;
      grid-template-columns:repeat(5, 1fr);
      gap:10px;
      overflow-y:auto;
    }

    .num-btn {
      aspect-ratio:1;
      border:2px solid #0f593f;
      border-radius:8px;
      font-weight:600;
      cursor:pointer;
      transition:all 0.2s;
      display:flex;
      align-items:center;
      justify-content:center;
    }

    .num-btn.answered {
      background:#0f593f;
      color:white;
    }

    .num-btn.flagged {
      background:#fff3cd;
      border-color:#ffecb5;
      color:#664d03;
    }

    .num-btn.current {
      border-color:#146b42;
      background:#eaf6ef;
      color:#146b42;
    }

    /* Tombol */
    .btn-mulai {
      background:#146b42;
      color:white;
      font-weight:700;
      padding:10px 28px;
    }

    .btn-kembali {
      border:2px solid #146b42;
      color:#146b42;
      background:transparent;
      padding:8px 24px;
    }

    .btn-flag {
      background:#fff3cd;
      border:1px solid #ffecb5;
      color:#664d03;
    }

    /* Modal hasil */
    .score-circle {
      width:120px;
      height:120px;
      border-radius:50%;
      background:#146b42;
      color:white;
      display:flex;
      flex-direction:column;
      align-items:center;
      justify-content:center;
      margin:0 auto 20px;
    }

    .detail-item.correct {
      border-left:4px solid #28a745;
      background:#d4edda;
    }

    .detail-item.incorrect {
      border-left:4px solid #dc3545;
      background:#f8d7da;
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
    @media (max-width:768px) {
      .question-card {
        min-height:400px;
      }
      
      .panel-sidebar {
        height:400px;
        position:relative;
        top:0;
        margin-top:20px;
      }
      
      .palette-grid {
        grid-template-columns:repeat(4, 1fr);
      }
      
      .question-image img {
        max-height:200px;
      }
    }

    @media (max-width:576px) {
      .palette-grid {
        grid-template-columns:repeat(3, 1fr);
      }
      
      .score-circle {
        width:100px;
        height:100px;
      }
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
  class="py-4">



<div class="container kuis-container">

  <div class="kuis-title text-center mb-4">
    <h4>{{ $aktivitas->judul }}</h4>
    <p class="text-muted mb-0">
        <i class="bi bi-clock me-1"></i> Durasi: <span id="durasiLabel">...</span> Menit | 
        <i class="bi bi-star me-1"></i> Poin: {{ $aktivitas->poin_didapat }} XP
    </p>
  </div>

  <div id="instructionPage" class="card shadow-sm border-0">
    <div class="card-body">
      <h5 class="text-center mb-4">Petunjuk Pengerjaan</h5>
      
      <!-- @if($aktivitas->instruksi)
        <div class="alert alert-info text-center">
            {{ $aktivitas->instruksi }}
        </div>
      @endif -->

      <ol class="mb-4">
        <li>Tekan <b>MULAI</b> untuk mengerjakan aktivitas.</li>
        <li>Waktu pengerjaan akan dihitung mundur otomatis.</li>
        <li>Pastikan koneksi internet stabil.</li>
        <li>Jika waktu habis, jawaban akan tersimpan otomatis.</li>
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
          <div id="palette" class="palette-grid mb-3"></div>
          <div class="mt-auto">
            <button id="finishBtn" class="btn btn-success w-100">
              <i class="bi bi-check-circle"></i> Selesai Mengerjakan
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<div id="resultModal" class="modal fade" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Hasil Aktivitas</h5>
      </div>
      <div class="modal-body">
        <div class="text-center mb-4">
          <div class="score-circle mb-3 shadow">
            <span class="score-value display-4 fw-bold" id="finalScore">0</span>
            <span class="score-label small">Nilai Akhir</span>
          </div>
          <h4 class="text-success">{{ $aktivitas->judul }}</h4>
        </div>
        
        <div class="row g-3 mb-4">
          <div class="col-4">
            <div class="p-3 border rounded text-center bg-light">
              <h4 class="text-dark mb-0" id="totalSoal">0</h4>
              <small class="text-muted">Total</small>
            </div>
          </div>
          <div class="col-4">
            <div class="p-3 border rounded text-center bg-success-subtle">
              <h4 class="text-success mb-0" id="benarCount">0</h4>
              <small class="text-muted">Benar</small>
            </div>
          </div>
          <div class="col-4">
            <div class="p-3 border rounded text-center bg-danger-subtle">
              <h4 class="text-danger mb-0" id="salahCount">0</h4>
              <small class="text-muted">Salah</small>
            </div>
          </div>
        </div>
        
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Detail Pengerjaan</h6>
                <span class="badge bg-secondary">Review</span>
            </div>
            <div id="resultDetails" style="max-height: 300px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 6px;">
                </div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="reviewBtn" class="btn btn-outline-success">Review Jawaban</button>
        <button onclick="window.location.href='{{ $nextMateriUrl }}'" class="btn btn-success">Selesai & Lanjut</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
/* =============================
   SETUP VARIABEL GLOBAL
============================= */
// MENGAMBIL ID DARI BODY (UPDATED)
const AKTIVITAS_ID = document.body.dataset.aktivitasId; 
const MATERI_SEKARANG = document.body.dataset.materiSekarang;
const NEXT_MATERI_URL = document.body.dataset.nextMateriUrl || '/siswa/dashboard';
const BACK_MATERI_URL = document.body.dataset.backMateriUrl || '/siswa/dashboard';

let questions = [];
let answers = [];
let flagged = [];
let idx = 0;
let timeLeft = 0; // Default 0, nanti diisi dari API
let timerInterval = null;
let quizStarted = false;
let isReviewMode = false;
let quizResult = null;

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

// Tampilkan materi sekarang di UI (Opsional)
if (MATERI_SEKARANG) {
    const titleP = document.querySelector('.kuis-title p');
    if(titleP) {
        // Append text materi tanpa menghapus durasi/poin yang sudah ada
        // titleP.innerHTML += ` <br> <small class="text-muted">Materi: ${MATERI_SEKARANG}</small>`;
    }
}

/* =============================
   1. LOAD DATA DARI API (INIT)
============================= */
fetch(`/siswa/api/aktivitas/${AKTIVITAS_ID}/soal`)
  .then(async res => {

    // ====== KHUSUS STATUS AKTIVITAS (403) ======
    if (res.status === 403) {
      const data = await res.json();

      startBtn.disabled = true;
      startBtn.innerHTML = 'Kuis Belum Tersedia';
      startBtn.classList.remove('btn-success');
      startBtn.classList.add('btn-secondary');

      Swal.fire({
        icon: 'info',
        title: 'Kuis Belum Tersedia',
        text: data.error || 'Kuis ini belum dibuka oleh guru.',
        confirmButtonText: 'Mengerti'
      });

      // STOP eksekusi
      return null;
    }

    // ====== ERROR TEKNIS ======
    if (!res.ok) {
      throw new Error('Gagal memuat data');
    }

    return res.json();
  })
  .then(data => {
    if (!data) return; // dari kasus 403

    if (!data.soal || data.soal.length === 0) {
      Swal.fire({
        icon: 'warning',
        title: 'Soal Kosong',
        text: 'Paket soal belum memiliki butir soal.'
      });
      return;
    }

    questions = data.soal;
    answers = Array(questions.length).fill(null);
    flagged = Array(questions.length).fill(false);

    // SETUP DURASI
    if (data.durasi_menit) {
      timeLeft = data.durasi_menit * 60;
      const labelDurasi = document.getElementById('durasiLabel');
      if (labelDurasi) labelDurasi.textContent = data.durasi_menit;
    } else {
      timeLeft = 20 * 60;
    }

    // AKTIFKAN TOMBOL
    startBtn.disabled = false;
    startBtn.innerHTML = 'MULAI MENGERJAKAN';
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
  Swal.fire({
    title: 'Ulangi Aktivitas?',
    text: 'Apakah Anda yakin ingin mengulang?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Ya, Ulangi',
    confirmButtonColor: '#146b42'
  }).then((result) => {
    if (result.isConfirmed) location.reload();
  });
}

function kembaliKeMateri() {
  Swal.fire({
    title: 'Kembali?',
    text: 'Progres Anda tidak akan tersimpan.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, Keluar',
    confirmButtonColor: '#dc3545'
  }).then((result) => {
    if (result.isConfirmed) window.location.href = BACK_MATERI_URL;
  });
}

function lanjutKeMateriBerikutnya() {
    window.location.href = NEXT_MATERI_URL;
}

function aturTampilanTombolReview() {
  const nextMateriBtn = document.getElementById('nextMateriBtn');
  const ulangiBtn = document.getElementById('ulangiBtn');
  
  // Cek apakah URL selanjutnya valid
  const isSelesai = !NEXT_MATERI_URL || NEXT_MATERI_URL === '#' || NEXT_MATERI_URL.includes('dashboard');
  
  if (isSelesai) {
    if(nextMateriBtn) {
        nextMateriBtn.innerHTML = '<i class="bi bi-check-circle"></i> Selesai';
        nextMateriBtn.onclick = function() { window.location.href = '/siswa/dashboard'; };
    }
  } else {
    if(nextMateriBtn) {
        nextMateriBtn.innerHTML = '<i class="bi bi-arrow-right"></i> Lanjut Materi';
        nextMateriBtn.onclick = lanjutKeMateriBerikutnya;
    }
  }
  
  if (ulangiBtn) ulangiBtn.onclick = ulangiKuis;

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
  if(sidebarTitle) sidebarTitle.textContent = 'Review Jawaban';
  
  const actions = document.getElementById('reviewActions');
  if(actions) actions.classList.remove('d-none');
  
  aturTampilanTombolReview();
  renderQuestion(idx);
}

document.getElementById('resultModal').addEventListener('hidden.bs.modal', function () {
  if (!isReviewMode) masukModeReview();
});

/* =============================
   MULAI KUIS
============================= */
startBtn.onclick = () => {
  instructionPage.classList.add('d-none');
  quizPage.classList.remove('d-none');

  if (!quizStarted) {
    quizStarted = true;
    renderPalette();
    renderQuestion(0);
    startTimer();
  }
};

/* =============================
   EVENT LISTENERS BUTTON
============================= */
document.getElementById('backBtn').onclick = kembaliKeMateri;
const backReview = document.getElementById('backFromReviewBtn');
if(backReview) backReview.onclick = kembaliKeMateri;

const ulangiBtn = document.getElementById('ulangiBtn');
if(ulangiBtn) ulangiBtn.onclick = ulangiKuis;

if(reviewBtn) reviewBtn.onclick = masukModeReview;

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
  
  // Layout Soal (Gambar & Teks)
  if (hasImage) {
    contentHTML = `
      <div class="row g-4">
        <div class="col-md-6">
          <div class="question-image h-100 d-flex align-items-center justify-content-center bg-light">
            <img src="${q.image}" class="img-fluid" style="max-height:300px" alt="Gambar soal">
          </div>
        </div>
        <div class="col-md-6">
          ${q.text ? `<div class="mb-4 fs-5">${q.text.replace(/\\n/g, '<br>')}</div>` : ''}
          <div id="optionsContainer">
            ${renderOptionsHTML(q)}
          </div>
        </div>
      </div>
    `;
  } else {
    contentHTML = `
      <div>
        ${q.text ? `<div class="mb-4 fs-5">${q.text.replace(/\\n/g, '<br>')}</div>` : ''}
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

  flagBtn.innerHTML = flagged[i] 
    ? '<i class="bi bi-flag-fill"></i> Batal Tandai'
    : '<i class="bi bi-flag"></i> Tandai';
    
  prevBtn.disabled = i === 0;
  nextBtn.disabled = i === questions.length - 1;

  updatePalette();
}

/* =============================
   RENDER OPSI
============================= */
function renderOptionsHTML(q) {
  let optionsHTML = '';
  
  // Tampilkan kotak info benar/salah saat review
  if (isReviewMode && quizResult) {
    // Cari detail hasil untuk soal index ini (idx)
    // Perhatikan: urutan array 'questions' harus sama dengan urutan 'quizResult.detail'
    // Sebaiknya mapping by ID, tapi asumsi urutan sama:
    const soalResult = quizResult.detail[idx]; 
    
    // Fallback jika tidak ditemukan (safety)
    const isCorrect = soalResult ? soalResult.benar : false;
    // Ambil teks jawaban benar dari options
    const correctAnswerKey = q.kunci_jawaban; 
    const correctAnswerText = q.options[correctAnswerKey] ? q.options[correctAnswerKey].text : '-';
    
    optionsHTML += `
      <div class="alert ${isCorrect ? 'alert-success' : 'alert-danger'} mb-3">
        <div class="d-flex align-items-center">
          <i class="bi ${isCorrect ? 'bi-check-circle-fill' : 'bi-x-circle-fill'} me-2 fs-4"></i>
          <div>
            <strong>${isCorrect ? 'Jawaban Anda Benar' : 'Jawaban Anda Salah'}</strong>
            ${!isCorrect ? `<div class="small mt-1">Kunci Jawaban: <strong>${correctAnswerKey}. ${correctAnswerText}</strong></div>` : ''}
          </div>
        </div>
      </div>
    `;
  }

  // Render Pilihan A,B,C,D
  Object.entries(q.options).forEach(([key, opt]) => {
    let className = 'option-item p-3 mb-2';
    
    // Highlight jawaban yang dipilih user
    if (answers[idx] === key) className += ' selected';
    
    // Warna warni saat Review
    if (isReviewMode) {
      if (key === q.kunci_jawaban) {
        className += ' correct'; // Hijau untuk kunci
      } else if (answers[idx] === key && answers[idx] !== q.kunci_jawaban) {
        className += ' incorrect'; // Merah untuk jawaban salah user
      }
    }
    
    const isChecked = answers[idx] === key;
    
    optionsHTML += `
      <div class="${className}" data-key="${key}">
        <div class="form-check mb-0 pointer-events-none">
          <input class="form-check-input" type="radio" 
                 ${isChecked ? 'checked' : ''} 
                 ${isReviewMode ? 'disabled' : ''}>
          <label class="form-check-label w-100 cursor-pointer">
            <strong>${key}.</strong> ${opt.text}
          </label>
        </div>
      </div>
    `;
  });
  
  return optionsHTML;
}

function selectOption(key) {
  if (!isReviewMode) {
    answers[idx] = key;
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
    if (answers[i] !== null) className += ' answered';
    if (flagged[i]) className += ' flagged';
    
    // Warna palette saat review
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
  flagBtn.innerHTML = flagged[idx] 
    ? '<i class="bi bi-flag-fill"></i> Batal Tandai'
    : '<i class="bi bi-flag"></i> Tandai';
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
    
    // Format Menit:Detik
    const m = String(Math.floor(timeLeft / 60)).padStart(2, '0');
    const s = String(timeLeft % 60).padStart(2, '0');
    document.getElementById('timeText').textContent = `${m}:${s}`;

    // Peringatan Merah jika < 1 menit
    if (timeLeft < 60) {
        document.querySelector('.timer').classList.add('text-danger');
    }

    // Waktu Habis
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
  const belum = answers.filter(a => a === null).length;
  let config = {
    title: 'Selesaikan Aktivitas?',
    text: 'Apakah Anda yakin ingin mengumpulkan jawaban?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Ya, Selesaikan',
    confirmButtonColor: '#146b42'
  };

  if (belum > 0) {
    config.title = 'Masih ada soal kosong!';
    config.text = `Anda belum menjawab ${belum} soal. Yakin ingin mengumpulkan?`;
    config.icon = 'warning';
  }

  const result = await Swal.fire(config);
  if (result.isConfirmed) submitQuiz();
};

/* =============================
   SUBMIT KE SERVER (UPDATED PAYLOAD)
============================= */
function submitQuiz() {
  // Stop Timer
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
     if(!res.ok) throw new Error('Server Error');
     return res.json();
  })
  .then(data => {
    Swal.close();
    showResult(data);
  })
  .catch((error) => {
    console.error(error);
    Swal.fire({
      title: 'Gagal Menyimpan',
      text: 'Terjadi kesalahan koneksi. Silakan coba kirim ulang.',
      icon: 'error',
      confirmButtonText: 'Coba Lagi'
    }).then((res) => {
        if(res.isConfirmed) submitQuiz(); // Retry logic
    });
  });
}

/* =============================
   TAMPILKAN HASIL
============================= */
function showResult(result) {
  quizResult = result;
  
  // Isi Modal Hasil
  document.getElementById('finalScore').textContent = result.skor;
  document.getElementById('totalSoal').textContent = result.total_soal;
  document.getElementById('benarCount').textContent = result.jumlah_benar;
  document.getElementById('salahCount').textContent = result.total_soal - result.jumlah_benar;
  
  // Render Detail di Modal (Scrollable Area)
  const detailsContainer = document.getElementById('resultDetails');
  detailsContainer.innerHTML = '';
  
  result.detail.forEach((item, index) => {
    const detailDiv = document.createElement('div');
    // Styling baris per soal
    detailDiv.className = `p-2 mb-2 border-bottom ${item.benar ? 'bg-success-subtle' : 'bg-danger-subtle'}`;
    
    // Teks Soal dipotong
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
  
  // Tampilkan Modal
  resultModal.show();
}
</script>

</body>
</html>