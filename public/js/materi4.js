document.addEventListener('DOMContentLoaded', function () {
    // ==========================================
    // 1. SISTEM NAVIGASI HALAMAN (PAGINATION)
    // ==========================================
    const pages = document.querySelectorAll('.materi-page');
    const pageBtns = document.querySelectorAll('.page-btn');
    const prevBtns = document.querySelectorAll('.prev-btn');
    const nextBtns = document.querySelectorAll('.next-btn');
    let currentPage = 0;

    function showPage(pageIndex) {
        pages.forEach((page, index) => {
            page.classList.toggle('d-none', index !== pageIndex);
        });

        document.querySelectorAll('.materi-pagination').forEach(pagination => {
            const btns = pagination.querySelectorAll('.page-btn');
            btns.forEach((btn, index) => {
                btn.parentElement.classList.toggle('active', index === pageIndex);
            });
        });

        currentPage = pageIndex;
        window.scrollTo(0, 0);
    }

    pageBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const pageIndex = parseInt(e.target.dataset.page);
            showPage(pageIndex);
        });
    });

    prevBtns.forEach(btn => btn.addEventListener('click', () => { if (currentPage > 0) showPage(currentPage - 1); }));
    nextBtns.forEach(btn => btn.addEventListener('click', () => { if (currentPage < pages.length - 1) showPage(currentPage + 1); }));

    // ==========================================
    // 2. INTERAKSI TOMBOL APERSEPSI (HALAMAN 1)
    // ==========================================
    const operatorBtns = document.querySelectorAll('.btn-operator');
    const rumusBtns = document.querySelectorAll('.btn-rumus');

    operatorBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            operatorBtns.forEach(b => b.classList.remove('active', 'btn-success', 'text-white'));
            this.classList.add('active', 'btn-success', 'text-white');
            document.getElementById('ap_step2').value = this.dataset.val;
        });
    });

    rumusBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            rumusBtns.forEach(b => b.classList.remove('active', 'btn-success', 'text-white'));
            this.classList.add('active', 'btn-success', 'text-white');
            document.getElementById('ap_step3').value = this.dataset.val;
        });
    });
});

// ==========================================
// GLOBAL VALIDATION SYSTEM & PROGRESS
// ==========================================
let attemptCounts = { ap: 0, c1: 0, c2: 0, c3: 0, s1: 0, s2: 0, s3: 0 };
const MAX_ATTEMPTS = 3;

// CEK KELAS & WRAP updateProgress (sama seperti materi lain)
let userHasKelas = false;
const kelasMeta = document.querySelector('meta[name="user-kelas-id"]');
if (kelasMeta && kelasMeta.getAttribute('content') && kelasMeta.getAttribute('content') !== '') {
    userHasKelas = true;
}

if (typeof window.updateProgress === 'undefined') {
    window.updateProgress = function (materiId, checkpointCode, earnedPoints = 0) {
        if (!userHasKelas) {
            Swal.fire({
                icon: 'info',
                title: 'Progres Tidak Tersimpan',
                text: 'Anda belum bergabung ke kelas. Progres latihan tidak akan disimpan. Silakan hubungi guru untuk bergabung ke kelas.',
                confirmButtonColor: '#0d6efd'
            });
            return Promise.resolve();
        }
        return fetch('/progress/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ materi_id: materiId, checkpoint: checkpointCode, points: earnedPoints })
        }).catch(err => console.error('Error update progress:', err));
    };
} else {
    const originalUpdateProgress = window.updateProgress;
    window.updateProgress = function (materiId, checkpointCode, earnedPoints = 0) {
        if (!userHasKelas) {
            Swal.fire({
                icon: 'info',
                title: 'Progres Tidak Tersimpan',
                text: 'Anda belum bergabung ke kelas. Progres latihan tidak akan disimpan. Silakan hubungi guru untuk bergabung ke kelas.',
                confirmButtonColor: '#0d6efd'
            });
            return Promise.resolve();
        }
        return originalUpdateProgress(materiId, checkpointCode, earnedPoints);
    };
}

// Mengecek apakah ada kotak yang kosong
function checkCompleteness(idArray) {
    let isComplete = true;
    idArray.forEach(id => {
        const el = document.getElementById(id);
        if (!el || el.value.trim() === '') isComplete = false;
    });
    return isComplete;
}

// Memberikan warna hijau/merah via class Bootstrap
function markStatus(id, isCorrect) {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.remove('is-valid', 'is-invalid');
    if (isCorrect) {
        el.classList.add('is-valid');
    } else {
        el.classList.add('is-invalid');
    }
}

// Cek nilai tunggal
function checkValue(id, expected) {
    const val = document.getElementById(id).value.trim();
    const isCorrect = val == expected;
    markStatus(id, isCorrect);
    return isCorrect;
}

// Cek nilai terbalik (Komutatif, misal A+B = B+A)
function checkCommutative(id1, id2, expected1, expected2) {
    const v1 = parseFloat(document.getElementById(id1).value);
    const v2 = parseFloat(document.getElementById(id2).value);

    let isCorrect = ((v1 === expected1 && v2 === expected2) || (v1 === expected2 && v2 === expected1));
    markStatus(id1, isCorrect);
    markStatus(id2, isCorrect);
    return isCorrect;
}

// Cek nilai terbalik yang bergantung pada hasil kuadratnya
function checkCommutativeWithSquares(id1, id2, id1Sq, id2Sq, exp1, exp2) {
    const v1 = parseFloat(document.getElementById(id1).value);
    const v2 = parseFloat(document.getElementById(id2).value);
    const v1Sq = parseFloat(document.getElementById(id1Sq).value);
    const v2Sq = parseFloat(document.getElementById(id2Sq).value);

    let c1 = false, c2 = false;
    if (v1 === exp1 && v2 === exp2) {
        c1 = true; if (v1Sq === exp1 * exp1 && v2Sq === exp2 * exp2) c2 = true;
    } else if (v1 === exp2 && v2 === exp1) {
        c1 = true; if (v1Sq === exp2 * exp2 && v2Sq === exp1 * exp1) c2 = true;
    }

    markStatus(id1, c1); markStatus(id2, c1);
    markStatus(id1Sq, c2); markStatus(id2Sq, c2);
    return c1 && c2;
}

// Paksa isi jawaban benar jika kesempatan habis
function fillAnswer(id, val) {
    const el = document.getElementById(id);
    el.value = val;
    markStatus(id, true);

    // Khusus untuk tombol pilihan Apersepsi
    if (id === 'ap_step2') {
        document.querySelectorAll('.btn-operator').forEach(b => b.classList.remove('active', 'btn-success', 'text-white'));
        document.querySelector(`.btn-operator[data-val="${val}"]`).classList.add('active', 'btn-success', 'text-white');
    }
    if (id === 'ap_step3') {
        document.querySelectorAll('.btn-rumus').forEach(b => b.classList.remove('active', 'btn-success', 'text-white'));
        document.querySelector(`.btn-rumus[data-val="${val}"]`).classList.add('active', 'btn-success', 'text-white');
    }
}

// Logika utama saat klik tombol periksa (dengan poin)
function processValidation(section, isComplete, isAllCorrect, btnElement, answerCallback, cpName, successMsg, earnedPoints) {
    if (!isComplete) {
        Swal.fire('Belum Lengkap!', 'Pilih dan isi semua kotak kosong terlebih dahulu ya!', 'warning');
        return;
    }

    if (isAllCorrect) {
        Swal.fire({
            icon: 'success',
            title: `+${earnedPoints} Poin!`,
            text: successMsg || 'Luar biasa! Jawaban dan perhitungan kamu tepat!'
        }).then(() => {
            if (typeof updateProgress === 'function') updateProgress('materi_4_penerapan_pythagoras', cpName, earnedPoints);
        });
        btnElement.classList.add('d-none'); // Sembunyikan tombol kalau sudah benar
    } else {
        attemptCounts[section]++;
        if (attemptCounts[section] >= MAX_ATTEMPTS) {
            Swal.fire({
                title: 'Kesempatan Habis',
                text: 'Jangan menyerah! Silakan klik "Tampilkan Jawaban" untuk mempelajari penyelesaian yang benar.',
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Tampilkan Jawaban',
                cancelButtonText: 'Tutup'
            }).then((result) => {
                if (result.isConfirmed) {
                    window[answerCallback]();
                }
            });

            // Ubah tombol jadi "Tampilkan Jawaban"
            btnElement.innerHTML = '<i class="fas fa-eye me-1"></i> Tampilkan Jawaban';
            btnElement.classList.remove('btn-success');
            btnElement.classList.add('btn-info');
            btnElement.setAttribute('onclick', answerCallback + '()');
        } else {
            Swal.fire('Kurang Tepat', `Masih ada isian kotak yang salah/merah. Ayo perbaiki! Sisa kesempatan: ${MAX_ATTEMPTS - attemptCounts[section]}`, 'error');
        }
    }
}

// ==========================================
// 3. APERSEPSI JEMBATAN BARITO (Poin 10)
// ==========================================
function cekApersepsiLengkap() {
    const btn = document.querySelector('button[onclick="cekApersepsiLengkap()"]');
    const inputs = ['ap_step1', 'ap_step2', 'ap_step3', 'ap_t1', 'ap_j1', 'ap_t2', 'ap_j2', 'ap_jum', 'ap_akar', 'ap_final'];
    if (!checkCompleteness(inputs)) return processValidation('ap', false, false, btn, 'showAnswerApersepsi', 'm4_cp1_apersepsi', '', 10);

    const s1 = checkValue('ap_step1', 'kabel');
    const s2 = document.getElementById('ap_step2').value === 'tambah';
    const s3 = document.getElementById('ap_step3').value === 'benar';

    const grp1 = checkCommutativeWithSquares('ap_t1', 'ap_j1', 'ap_t2', 'ap_j2', 24, 10);
    const jum = checkValue('ap_jum', 676);
    const akr = checkValue('ap_akar', 676);
    const fnl = checkValue('ap_final', 26);

    const isAllCorrect = s1 && s2 && s3 && grp1 && jum && akr && fnl;
    processValidation('ap', true, isAllCorrect, btn, 'showAnswerApersepsi', 'm4_cp1_apersepsi', 'Panjang kabel baja Jembatan Barito tersebut adalah 26 meter.', 10);
}

function showAnswerApersepsi() {
    fillAnswer('ap_step1', 'kabel'); fillAnswer('ap_step2', 'tambah'); fillAnswer('ap_step3', 'benar');
    fillAnswer('ap_t1', 24); fillAnswer('ap_j1', 10);
    fillAnswer('ap_t2', 576); fillAnswer('ap_j2', 100);
    fillAnswer('ap_jum', 676); fillAnswer('ap_akar', 676); fillAnswer('ap_final', 26);
    document.querySelector('button[onclick="showAnswerApersepsi()"]').classList.add('d-none');
    if (typeof updateProgress === 'function') updateProgress('materi_4_penerapan_pythagoras', 'm4_cp1_apersepsi', 10);
}

// ==========================================
// 4. CONTOH PENERAPAN (Poin masing-masing 15)
// ==========================================
function cekContoh1Penerapan() {
    const btn = document.querySelector('button[onclick="cekContoh1Penerapan()"]');
    const inputs = ['c1_dik_ab', 'c1_dik_bc', 'c1_ditanya', 'c1_rumus', 'c1_ab', 'c1_bc', 'c1_ab_kuadrat', 'c1_bc_kuadrat', 'c1_akar_val', 'c1_ac'];
    if (!checkCompleteness(inputs)) return processValidation('c1', false, false, btn, 'showAnswerC1', 'm4_cp2_contoh_1', '', 15);

    const iDik = checkCommutative('c1_dik_ab', 'c1_dik_bc', 40, 30);
    const iDit = checkValue('c1_ditanya', 'AC') && checkValue('c1_rumus', 'AC');
    const iSub = checkCommutativeWithSquares('c1_ab', 'c1_bc', 'c1_ab_kuadrat', 'c1_bc_kuadrat', 40, 30);
    const akr = checkValue('c1_akar_val', 2500);
    const res = checkValue('c1_ac', 50);

    document.getElementById('c1_ac2').value = 2500; // Auto-fill readonly
    const isAllCorrect = iDik && iDit && iSub && akr && res;

    processValidation('c1', true, isAllCorrect, btn, 'showAnswerC1', 'm4_cp2_contoh_1', 'Langkah penyelesaian Contoh 1 sudah benar.', 15);
}

function showAnswerC1() {
    fillAnswer('c1_dik_ab', 40); fillAnswer('c1_dik_bc', 30); fillAnswer('c1_ditanya', 'AC'); fillAnswer('c1_rumus', 'AC');
    fillAnswer('c1_ab', 40); fillAnswer('c1_bc', 30); fillAnswer('c1_ab_kuadrat', 1600); fillAnswer('c1_bc_kuadrat', 900);
    fillAnswer('c1_akar_val', 2500); fillAnswer('c1_ac', 50); document.getElementById('c1_ac2').value = 2500;
    document.querySelector('button[onclick="showAnswerC1()"]').classList.add('d-none');
    if (typeof updateProgress === 'function') updateProgress('materi_4_penerapan_pythagoras', 'm4_cp2_contoh_1', 15);
}

function cekContoh2Penerapan() {
    const btn = document.querySelector('button[onclick="cekContoh2Penerapan()"]');
    const inputs = ['c2_dik_mn', 'c2_dik_no', 'c2_ditanya', 'c2_rumus', 'c2_mn', 'c2_no', 'c2_mn_kuadrat', 'c2_no_kuadrat', 'c2_akar_val', 'c2_mo'];
    if (!checkCompleteness(inputs)) return processValidation('c2', false, false, btn, 'showAnswerC2', 'm4_cp3_contoh_2', '', 15);

    const iDik = checkCommutative('c2_dik_mn', 'c2_dik_no', 15, 20);
    const iDit = checkValue('c2_ditanya', 'MO') && checkValue('c2_rumus', 'MO');
    const iSub = checkCommutativeWithSquares('c2_mn', 'c2_no', 'c2_mn_kuadrat', 'c2_no_kuadrat', 15, 20);
    const akr = checkValue('c2_akar_val', 625);
    const res = checkValue('c2_mo', 25);
    document.getElementById('c2_mo2').value = 625;

    const isAllCorrect = iDik && iDit && iSub && akr && res;
    processValidation('c2', true, isAllCorrect, btn, 'showAnswerC2', 'm4_cp3_contoh_2', 'Perhitungan jarak garis lurus ojek online sangat presisi.', 15);
}

function showAnswerC2() {
    fillAnswer('c2_dik_mn', 15); fillAnswer('c2_dik_no', 20); fillAnswer('c2_ditanya', 'MO'); fillAnswer('c2_rumus', 'MO');
    fillAnswer('c2_mn', 15); fillAnswer('c2_no', 20); fillAnswer('c2_mn_kuadrat', 225); fillAnswer('c2_no_kuadrat', 400);
    fillAnswer('c2_akar_val', 625); fillAnswer('c2_mo', 25); document.getElementById('c2_mo2').value = 625;
    document.querySelector('button[onclick="showAnswerC2()"]').classList.add('d-none');
    if (typeof updateProgress === 'function') updateProgress('materi_4_penerapan_pythagoras', 'm4_cp3_contoh_2', 15);
}

function cekContoh3Penerapan() {
    const btn = document.querySelector('button[onclick="cekContoh3Penerapan()"]');
    const inputs = ['c3_dik_dc', 'c3_dik_da', 'c3_dik_db', 'c3_ditanya', 'c3_da', 'c3_dc1', 'c3_da_kuadrat', 'c3_dc1_kuadrat', 'c3_ac2_val', 'c3_ac', 'c3_db', 'c3_dc2', 'c3_db_kuadrat', 'c3_dc2_kuadrat', 'c3_bc2_val', 'c3_bc', 'c3_ac_final', 'c3_bc_final', 'c3_ab'];
    if (!checkCompleteness(inputs)) return processValidation('c3', false, false, btn, 'showAnswerC3', 'm4_cp4_contoh_3', '', 15);

    const iInfo = checkValue('c3_dik_dc', 15) && checkValue('c3_dik_da', 25) && checkValue('c3_dik_db', 17) && checkValue('c3_ditanya', 'AB');

    // AC
    const st1 = checkValue('c3_da', 25) && checkValue('c3_dc1', 15) && checkValue('c3_da_kuadrat', 625) && checkValue('c3_dc1_kuadrat', 225) && checkValue('c3_ac2_val', 400) && checkValue('c3_ac', 20);
    // BC
    const st2 = checkValue('c3_db', 17) && checkValue('c3_dc2', 15) && checkValue('c3_db_kuadrat', 289) && checkValue('c3_dc2_kuadrat', 225) && checkValue('c3_bc2_val', 64) && checkValue('c3_bc', 8);
    // AB
    const st3 = checkValue('c3_ac_final', 20) && checkValue('c3_bc_final', 8) && checkValue('c3_ab', 12);

    const isAllCorrect = iInfo && st1 && st2 && st3;
    processValidation('c3', true, isAllCorrect, btn, 'showAnswerC3', 'm4_cp4_contoh_3', 'Luar Biasa! Contoh 3 dengan 2 segitiga dipahami dengan baik.', 15);
}

function showAnswerC3() {
    fillAnswer('c3_dik_dc', 15); fillAnswer('c3_dik_da', 25); fillAnswer('c3_dik_db', 17); fillAnswer('c3_ditanya', 'AB');
    fillAnswer('c3_da', 25); fillAnswer('c3_dc1', 15); fillAnswer('c3_da_kuadrat', 625); fillAnswer('c3_dc1_kuadrat', 225); fillAnswer('c3_ac2_val', 400); fillAnswer('c3_ac', 20);
    fillAnswer('c3_db', 17); fillAnswer('c3_dc2', 15); fillAnswer('c3_db_kuadrat', 289); fillAnswer('c3_dc2_kuadrat', 225); fillAnswer('c3_bc2_val', 64); fillAnswer('c3_bc', 8);
    fillAnswer('c3_ac_final', 20); fillAnswer('c3_bc_final', 8); fillAnswer('c3_ab', 12);
    document.querySelector('button[onclick="showAnswerC3()"]').classList.add('d-none');
    if (typeof updateProgress === 'function') updateProgress('materi_4_penerapan_pythagoras', 'm4_cp4_contoh_3', 15);
}

// ==========================================
// 5. AYO BERLATIH (SOAL) Poin masing-masing 20
// ==========================================
function cekSoal1() {
    const btn = document.querySelector('button[onclick="cekSoal1()"]');
    const inputs = ['s1_dik_ab', 's1_dik_bc', 's1_ditanya', 's1_rumus', 's1_ab', 's1_bc', 's1_ab_kuadrat', 's1_bc_kuadrat', 's1_akar_val', 's1_ac'];
    if (!checkCompleteness(inputs)) return processValidation('s1', false, false, btn, 'showAnswerS1', 'm4_cp5_latihan_1', '', 20);

    const iDik = checkCommutative('s1_dik_ab', 's1_dik_bc', 40, 30);
    const iDit = checkValue('s1_ditanya', 'AC') && checkValue('s1_rumus', 'AC');
    const iSub = checkCommutativeWithSquares('s1_ab', 's1_bc', 's1_ab_kuadrat', 's1_bc_kuadrat', 40, 30);
    const akr = checkValue('s1_akar_val', 2500);
    const res = checkValue('s1_ac', 50);
    document.getElementById('s1_ac2').value = 2500;

    const isAllCorrect = iDik && iDit && iSub && akr && res;
    processValidation('s1', true, isAllCorrect, btn, 'showAnswerS1', 'm4_cp5_latihan_1', 'Jawaban Soal 1 tepat sekali. Jarak lurusnya adalah 50 meter.', 20);
}

function showAnswerS1() {
    fillAnswer('s1_dik_ab', 40); fillAnswer('s1_dik_bc', 30); fillAnswer('s1_ditanya', 'AC'); fillAnswer('s1_rumus', 'AC');
    fillAnswer('s1_ab', 40); fillAnswer('s1_bc', 30); fillAnswer('s1_ab_kuadrat', 1600); fillAnswer('s1_bc_kuadrat', 900);
    fillAnswer('s1_akar_val', 2500); fillAnswer('s1_ac', 50); document.getElementById('s1_ac2').value = 2500;
    document.querySelector('button[onclick="showAnswerS1()"]').classList.add('d-none');
    if (typeof updateProgress === 'function') updateProgress('materi_4_penerapan_pythagoras', 'm4_cp5_latihan_1', 20);
}

function cekSoal2() {
    const btn = document.querySelector('button[onclick="cekSoal2()"]');
    const inputs = ['s2_dik_ab', 's2_dik_ac', 's2_ditanya', 's2_rumus', 's2_ac', 's2_ab', 's2_ac_kuadrat', 's2_ab_kuadrat', 's2_akar_val', 's2_bc'];
    if (!checkCompleteness(inputs)) return processValidation('s2', false, false, btn, 'showAnswerS2', 'm4_cp6_latihan_2', '', 20);

    const iDik = checkValue('s2_dik_ab', 24) && checkValue('s2_dik_ac', 25);
    const iDit = checkValue('s2_ditanya', 'BC') && checkValue('s2_rumus', 'BC');
    // Pengurangan wajib berurutan (Miring^2 - Tegak^2)
    const stp1 = checkValue('s2_ac', 25) && checkValue('s2_ab', 24) && checkValue('s2_ac_kuadrat', 625) && checkValue('s2_ab_kuadrat', 576);
    const stp2 = checkValue('s2_akar_val', 49) && checkValue('s2_bc', 7);
    document.getElementById('s2_bc2').value = 49;

    const isAllCorrect = iDik && iDit && stp1 && stp2;
    processValidation('s2', true, isAllCorrect, btn, 'showAnswerS2', 'm4_cp6_latihan_2', 'Tinggi menara berhasil dijawab dengan benar yaitu 7 meter.', 20);
}

function showAnswerS2() {
    fillAnswer('s2_dik_ab', 24); fillAnswer('s2_dik_ac', 25); fillAnswer('s2_ditanya', 'BC'); fillAnswer('s2_rumus', 'BC');
    fillAnswer('s2_ac', 25); fillAnswer('s2_ab', 24); fillAnswer('s2_ac_kuadrat', 625); fillAnswer('s2_ab_kuadrat', 576);
    fillAnswer('s2_akar_val', 49); fillAnswer('s2_bc', 7); document.getElementById('s2_bc2').value = 49;
    document.querySelector('button[onclick="showAnswerS2()"]').classList.add('d-none');
    if (typeof updateProgress === 'function') updateProgress('materi_4_penerapan_pythagoras', 'm4_cp6_latihan_2', 20);
}

function cekSoal3() {
    const btn = document.querySelector('button[onclick="cekSoal3()"]');
    const inputs = ['s3_dik_da', 's3_dik_ac', 's3_dik_db', 's3_ditanya', 's3_da', 's3_ac1', 's3_da_kuadrat', 's3_ac1_kuadrat', 's3_dc2_val', 's3_dc', 's3_db', 's3_dc2', 's3_db_kuadrat', 's3_dc2_kuadrat', 's3_bc2_val', 's3_bc'];
    if (!checkCompleteness(inputs)) return processValidation('s3', false, false, btn, 'showAnswerS3', 'm4_cp7_latihan_3', '', 20);

    const iInfo = checkValue('s3_dik_da', 20) && checkValue('s3_dik_ac', 16) && checkValue('s3_dik_db', 15) && checkValue('s3_ditanya', 'BC');

    // DC
    const st1 = checkValue('s3_da', 20) && checkValue('s3_ac1', 16) && checkValue('s3_da_kuadrat', 400) && checkValue('s3_ac1_kuadrat', 256) && checkValue('s3_dc2_val', 144) && checkValue('s3_dc', 12);
    // BC
    const st2 = checkValue('s3_db', 15) && checkValue('s3_dc2', 12) && checkValue('s3_db_kuadrat', 225) && checkValue('s3_dc2_kuadrat', 144) && checkValue('s3_bc2_val', 81) && checkValue('s3_bc', 9);

    const isAllCorrect = iInfo && st1 && st2;
    processValidation('s3', true, isAllCorrect, btn, 'showAnswerS3', 'm4_cp7_latihan_3', 'Analisis logika Soal 3 diselesaikan dengan sempurna!', 20);
}

function showAnswerS3() {
    fillAnswer('s3_dik_da', 20); fillAnswer('s3_dik_ac', 16); fillAnswer('s3_dik_db', 15); fillAnswer('s3_ditanya', 'BC');
    fillAnswer('s3_da', 20); fillAnswer('s3_ac1', 16); fillAnswer('s3_da_kuadrat', 400); fillAnswer('s3_ac1_kuadrat', 256); fillAnswer('s3_dc2_val', 144); fillAnswer('s3_dc', 12);
    fillAnswer('s3_db', 15); fillAnswer('s3_dc2', 12); fillAnswer('s3_db_kuadrat', 225); fillAnswer('s3_dc2_kuadrat', 144); fillAnswer('s3_bc2_val', 81); fillAnswer('s3_bc', 9);
    document.querySelector('button[onclick="showAnswerS3()"]').classList.add('d-none');
    if (typeof updateProgress === 'function') updateProgress('materi_4_penerapan_pythagoras', 'm4_cp7_latihan_3', 20);
}
// ==========================================
// 6. VALIDASI REFLEKSI & SIMPAN PROGRESS (Materi 4)
// ==========================================
async function cekRefleksiPenerapan() {
    const r1 = document.querySelector('input[name="ref_penerapan_1"]:checked');
    const r1_text = document.getElementById('ref_penerapan_1_text').value.trim();
    const r2_text = document.getElementById('ref_penerapan_2_text').value.trim();

    // 1. Validasi
    if (!r1 || r1_text === "" || r2_text === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Kolom Kosong',
            text: 'Tolong pilih dan isi semua tanggapan refleksi dengan pemikiranmu sendiri ya!',
            confirmButtonColor: '#198754'
        });
        return;
    }

    // 2. Siapkan Payload JSON
    const dataRefleksi = {
        kode_materi: 'materi_4_penerapan_pythagoras',
        status_sketsa: r1.value,
        alasan_sketsa: r1_text,
        contoh_nyata: r2_text
    };

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Animasi tombol loading
        const btnSubmit = document.querySelector('button[onclick="cekRefleksiPenerapan()"]');
        const originalText = btnSubmit.innerHTML;
        btnSubmit.innerText = "Menyimpan...";
        btnSubmit.disabled = true;

        // 3. Kirim ke Database
        const response = await fetch('/siswa/refleksi/simpan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(dataRefleksi)
        });

        const result = await response.json();

        // 4. Jika Berhasil
        if (response.ok) {
            Swal.fire({
                icon: 'success',
                title: '+10 Poin!',
                text: 'Refleksi pemahamanmu berhasil disimpan. Selamat, kamu telah menuntaskan seluruh materi Bab Teorema Pythagoras!',
                confirmButtonColor: '#198754',
                confirmButtonText: '<i class="fas fa-flag-checkered me-2"></i> Selesai',
                allowOutsideClick: false
            }).then((resultAlert) => {
                if (resultAlert.isConfirmed) {

                    // Kunci Form
                    kunciFormRefleksiPenerapan();

                    // Update Progress Gamifikasi
                    if (typeof updateProgress === 'function') {
                        updateProgress('materi_4_penerapan_pythagoras', 'm4_cp8_refleksi', 10);
                    }

                    // Tampilkan Alert Persiapan Ujian
                    Swal.fire({
                        title: 'Siap Menguji Diri?',
                        text: 'Silakan persiapkan diri dengan baik sebelum beralih ke menu Evaluasi/Kuis Utama.',
                        icon: 'info',
                        confirmButtonColor: '#0d6efd'
                    });
                }
            });

        } else {
            Swal.fire({ icon: 'error', title: 'Gagal', text: result.message || 'Terjadi kesalahan sistem.', confirmButtonColor: '#dc3545' });
            btnSubmit.innerHTML = originalText;
            btnSubmit.disabled = false;
        }

    } catch (error) {
        console.error('Error:', error);
        Swal.fire({ icon: 'error', title: 'Koneksi Terputus', text: 'Gagal terhubung ke server. Periksa jaringanmu.', confirmButtonColor: '#dc3545' });

        const btnSubmit = document.querySelector('button[onclick="cekRefleksiPenerapan()"]');
        if (btnSubmit) {
            btnSubmit.innerHTML = '<i class="fas fa-save me-1"></i> Simpan Refleksi';
            btnSubmit.disabled = false;
        }
    }
}

// Fungsi Helper untuk mengunci input
function kunciFormRefleksiPenerapan() {
    ['ref_penerapan_1_ya', 'ref_penerapan_1_tidak'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.disabled = true;
    });

    ['ref_penerapan_1_text', 'ref_penerapan_2_text'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.disabled = true;
            el.classList.add('is-valid');
        }
    });

    const btn = document.querySelector('button[onclick="cekRefleksiPenerapan()"]');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-check-circle me-1"></i> Refleksi Tersimpan';
    }
}

/* =====================================================
   AKTIFASI MODE REVIEW UNTUK MATERI 4 (FULL)
   Menampilkan ulang jawaban jika checkpoint sudah selesai
===================================================== */
document.addEventListener('DOMContentLoaded', function () {
    if (typeof window.setupReviewMode === 'function') {

        // 1. Apersepsi
        window.setupReviewMode('m4_cp1_apersepsi', 'button[onclick="cekApersepsiLengkap()"]',
            function () {
                const ans = {
                    'ap_step1': 'kabel', 'ap_t1': '24', 'ap_j1': '10', 'ap_t2': '576',
                    'ap_j2': '100', 'ap_jum': '676', 'ap_akar': '676', 'ap_final': '26'
                };
                for (let id in ans) {
                    let el = document.getElementById(id);
                    if (el) { el.value = ans[id]; el.classList.add('is-valid'); el.disabled = true; }
                }

                // Set logic hidden/button states untuk operator dan rumus
                document.getElementById('ap_step2').value = 'tambah';
                document.getElementById('ap_step3').value = 'benar';
                document.querySelectorAll('.btn-operator, .btn-rumus').forEach(btn => btn.disabled = true);

                let btnOperator = document.querySelector('.btn-operator[data-val="tambah"]');
                let btnRumus = document.querySelector('.btn-rumus[data-val="benar"]');
                if (btnOperator) btnOperator.classList.replace('btn-outline-success', 'btn-success');
                if (btnOperator) btnOperator.classList.add('text-white');
                if (btnRumus) btnRumus.classList.replace('btn-outline-success', 'btn-success');
                if (btnRumus) btnRumus.classList.add('text-white');

                let feedback = document.getElementById('ap_feedback');
                if (feedback) feedback.innerHTML = '<span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> Apersepsi Selesai.</span>';
            },
            function () {
                const ids = ['ap_step1', 'ap_step2', 'ap_step3', 'ap_t1', 'ap_j1', 'ap_t2', 'ap_j2', 'ap_jum', 'ap_akar', 'ap_final'];
                ids.forEach(id => {
                    let el = document.getElementById(id);
                    if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid'); el.disabled = false; }
                });

                document.querySelectorAll('.btn-operator, .btn-rumus').forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove('btn-success', 'text-white');
                    btn.classList.add('btn-outline-success');
                });

                let feedback = document.getElementById('ap_feedback');
                if (feedback) feedback.innerHTML = '';
            }
        );

        // 2. Contoh 1
        window.setupReviewMode('m4_cp2_contoh_1', 'button[onclick="cekContoh1Penerapan()"]',
            function () {
                const ans = {
                    'c1_dik_ab': '40', 'c1_dik_bc': '30', 'c1_ditanya': 'AC', 'c1_rumus': 'AC',
                    'c1_ab': '40', 'c1_bc': '30', 'c1_ab_kuadrat': '1600', 'c1_bc_kuadrat': '900',
                    'c1_ac2': '2500', 'c1_akar_val': '2500', 'c1_ac': '50'
                };
                for (let id in ans) {
                    let el = document.getElementById(id);
                    if (el) { el.value = ans[id]; el.classList.add('is-valid'); el.disabled = true; }
                }
                let feedback = document.getElementById('c1_feedback');
                if (feedback) feedback.innerHTML = '<span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> Contoh 1 Selesai.</span>';
            },
            function () {
                const ids = ['c1_dik_ab', 'c1_dik_bc', 'c1_ditanya', 'c1_rumus', 'c1_ab', 'c1_bc', 'c1_ab_kuadrat', 'c1_bc_kuadrat', 'c1_ac2', 'c1_akar_val', 'c1_ac'];
                ids.forEach(id => {
                    let el = document.getElementById(id);
                    if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid'); el.disabled = false; }
                });
                let feedback = document.getElementById('c1_feedback');
                if (feedback) feedback.innerHTML = '';
            }
        );

        // 3. Contoh 2
        window.setupReviewMode('m4_cp3_contoh_2', 'button[onclick="cekContoh2Penerapan()"]',
            function () {
                const ans = {
                    'c2_dik_mn': '15', 'c2_dik_no': '20', 'c2_ditanya': 'MO', 'c2_rumus': 'MO',
                    'c2_mn': '15', 'c2_no': '20', 'c2_mn_kuadrat': '225', 'c2_no_kuadrat': '400',
                    'c2_mo2': '625', 'c2_akar_val': '625', 'c2_mo': '25'
                };
                for (let id in ans) {
                    let el = document.getElementById(id);
                    if (el) { el.value = ans[id]; el.classList.add('is-valid'); el.disabled = true; }
                }
                let feedback = document.getElementById('c2_feedback');
                if (feedback) feedback.innerHTML = '<span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> Contoh 2 Selesai.</span>';
            },
            function () {
                const ids = ['c2_dik_mn', 'c2_dik_no', 'c2_ditanya', 'c2_rumus', 'c2_mn', 'c2_no', 'c2_mn_kuadrat', 'c2_no_kuadrat', 'c2_mo2', 'c2_akar_val', 'c2_mo'];
                ids.forEach(id => {
                    let el = document.getElementById(id);
                    if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid'); el.disabled = false; }
                });
                let feedback = document.getElementById('c2_feedback');
                if (feedback) feedback.innerHTML = '';
            }
        );

        // 4. Contoh 3
        window.setupReviewMode('m4_cp4_contoh_3', 'button[onclick="cekContoh3Penerapan()"]',
            function () {
                const ans = {
                    'c3_dik_dc': '15', 'c3_dik_da': '25', 'c3_dik_db': '17', 'c3_ditanya': 'AB',
                    'c3_da': '25', 'c3_dc1': '15', 'c3_da_kuadrat': '625', 'c3_dc1_kuadrat': '225',
                    'c3_ac2_val': '400', 'c3_ac': '20', 'c3_db': '17', 'c3_dc2': '15',
                    'c3_db_kuadrat': '289', 'c3_dc2_kuadrat': '225', 'c3_bc2_val': '64', 'c3_bc': '8',
                    'c3_ac_final': '20', 'c3_bc_final': '8', 'c3_ab': '12'
                };
                for (let id in ans) {
                    let el = document.getElementById(id);
                    if (el) { el.value = ans[id]; el.classList.add('is-valid'); el.disabled = true; }
                }
                let feedback = document.getElementById('c3_feedback');
                if (feedback) feedback.innerHTML = '<span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> Contoh 3 Selesai.</span>';
            },
            function () {
                const ids = ['c3_dik_dc', 'c3_dik_da', 'c3_dik_db', 'c3_ditanya', 'c3_da', 'c3_dc1', 'c3_da_kuadrat', 'c3_dc1_kuadrat', 'c3_ac2_val', 'c3_ac', 'c3_db', 'c3_dc2', 'c3_db_kuadrat', 'c3_dc2_kuadrat', 'c3_bc2_val', 'c3_bc', 'c3_ac_final', 'c3_bc_final', 'c3_ab'];
                ids.forEach(id => {
                    let el = document.getElementById(id);
                    if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid'); el.disabled = false; }
                });
                let feedback = document.getElementById('c3_feedback');
                if (feedback) feedback.innerHTML = '';
            }
        );

        // 5. Soal Latihan 1
        window.setupReviewMode('m4_cp5_latihan_1', 'button[onclick="cekSoal1()"]',
            function () {
                const ans = {
                    's1_dik_ab': '40', 's1_dik_bc': '30', 's1_ditanya': 'AC', 's1_rumus': 'AC',
                    's1_ab': '40', 's1_bc': '30', 's1_ab_kuadrat': '1600', 's1_bc_kuadrat': '900',
                    's1_ac2': '2500', 's1_akar_val': '2500', 's1_ac': '50'
                };
                for (let id in ans) {
                    let el = document.getElementById(id);
                    if (el) { el.value = ans[id]; el.classList.add('is-valid', 'border-success', 'text-success'); el.disabled = true; }
                }
                let feedback = document.getElementById('s1_feedback');
                if (feedback) feedback.innerHTML = '<span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> Latihan 1 Selesai.</span>';
            },
            function () {
                const ids = ['s1_dik_ab', 's1_dik_bc', 's1_ditanya', 's1_rumus', 's1_ab', 's1_bc', 's1_ab_kuadrat', 's1_bc_kuadrat', 's1_ac2', 's1_akar_val', 's1_ac'];
                ids.forEach(id => {
                    let el = document.getElementById(id);
                    if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid', 'border-success', 'border-danger', 'text-success', 'text-danger'); el.disabled = false; }
                });
                let feedback = document.getElementById('s1_feedback');
                if (feedback) feedback.innerHTML = '';
            }
        );

        // 6. Soal Latihan 2
        window.setupReviewMode('m4_cp6_latihan_2', 'button[onclick="cekSoal2()"]',
            function () {
                const ans = {
                    's2_dik_ab': '24', 's2_dik_ac': '25', 's2_ditanya': 'BC', 's2_rumus': 'BC',
                    's2_ac': '25', 's2_ab': '24', 's2_ac_kuadrat': '625', 's2_ab_kuadrat': '576',
                    's2_bc2': '49', 's2_akar_val': '49', 's2_bc': '7'
                };
                for (let id in ans) {
                    let el = document.getElementById(id);
                    if (el) { el.value = ans[id]; el.classList.add('is-valid', 'border-success', 'text-success'); el.disabled = true; }
                }
                let feedback = document.getElementById('s2_feedback');
                if (feedback) feedback.innerHTML = '<span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> Latihan 2 Selesai.</span>';
            },
            function () {
                const ids = ['s2_dik_ab', 's2_dik_ac', 's2_ditanya', 's2_rumus', 's2_ac', 's2_ab', 's2_ac_kuadrat', 's2_ab_kuadrat', 's2_bc2', 's2_akar_val', 's2_bc'];
                ids.forEach(id => {
                    let el = document.getElementById(id);
                    if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid', 'border-success', 'border-danger', 'text-success', 'text-danger'); el.disabled = false; }
                });
                let feedback = document.getElementById('s2_feedback');
                if (feedback) feedback.innerHTML = '';
            }
        );

        // 7. Soal Latihan 3
        window.setupReviewMode('m4_cp7_latihan_3', 'button[onclick="cekSoal3()"]',
            function () {
                const ans = {
                    's3_dik_da': '20', 's3_dik_ac': '16', 's3_dik_db': '15', 's3_ditanya': 'BC',
                    's3_da': '20', 's3_ac1': '16', 's3_da_kuadrat': '400', 's3_ac1_kuadrat': '256',
                    's3_dc2_val': '144', 's3_dc': '12', 's3_db': '15', 's3_dc2': '12',
                    's3_db_kuadrat': '225', 's3_dc2_kuadrat': '144', 's3_bc2_val': '81', 's3_bc': '9'
                };
                for (let id in ans) {
                    let el = document.getElementById(id);
                    if (el) { el.value = ans[id]; el.classList.add('is-valid', 'border-success', 'text-success'); el.disabled = true; }
                }
                let feedback = document.getElementById('s3_feedback');
                if (feedback) feedback.innerHTML = '<span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> Latihan 3 Selesai.</span>';
            },
            function () {
                const ids = ['s3_dik_da', 's3_dik_ac', 's3_dik_db', 's3_ditanya', 's3_da', 's3_ac1', 's3_da_kuadrat', 's3_ac1_kuadrat', 's3_dc2_val', 's3_dc', 's3_db', 's3_dc2', 's3_db_kuadrat', 's3_dc2_kuadrat', 's3_bc2_val', 's3_bc'];
                ids.forEach(id => {
                    let el = document.getElementById(id);
                    if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid', 'border-success', 'border-danger', 'text-success', 'text-danger'); el.disabled = false; }
                });
                let feedback = document.getElementById('s3_feedback');
                if (feedback) feedback.innerHTML = '';
            }
        );
        // 8. Refleksi Review Mode
        window.setupReviewMode(
            'm4_cp8_refleksi',
            'button[onclick="cekRefleksiPenerapan()"]',
            function () {
                // Panggil fungsi kunci jika materi sudah dituntaskan sebelumnya
                kunciFormRefleksiPenerapan();
            },
            function () {
                // Reset form jika di-restart
                ['ref_penerapan_1_ya', 'ref_penerapan_1_tidak'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) { el.disabled = false; el.checked = false; }
                });

                ['ref_penerapan_1_text', 'ref_penerapan_2_text'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) { el.disabled = false; el.value = ''; el.classList.remove('is-valid'); }
                });

                const btn = document.querySelector('button[onclick="cekRefleksiPenerapan()"]');
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-save me-1"></i> Simpan Refleksi';
                }
            }
        );

    }
});