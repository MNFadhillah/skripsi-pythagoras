/* =====================================================
   HELPER GLOBAL MATERI 4
===================================================== */
const MATERI4_ID = 'materi_4_penerapan_pythagoras';

const MATERI4_AKTIVITAS = {
    ap: {
        checkpoint: 'm4_cp1_apersepsi',
        selector: 'button[onclick="cekApersepsiLengkap()"]',
        reset: resetApersepsi
    },
    c1: {
        checkpoint: 'm4_cp2_contoh_1',
        selector: 'button[onclick="cekContoh1Penerapan()"]',
        reset: resetC1
    },
    c2: {
        checkpoint: 'm4_cp3_contoh_2',
        selector: 'button[onclick="cekContoh2Penerapan()"]',
        reset: resetC2
    },
    c3: {
        checkpoint: 'm4_cp4_contoh_3',
        selector: 'button[onclick="cekContoh3Penerapan()"]',
        reset: resetC3
    },
    s1: {
        checkpoint: 'm4_cp5_latihan_1',
        selector: 'button[onclick="cekSoal1()"]',
        reset: resetS1
    },
    s2: {
        checkpoint: 'm4_cp6_latihan_2',
        selector: 'button[onclick="cekSoal2()"]',
        reset: resetS2
    },
    s3: {
        checkpoint: 'm4_cp7_latihan_3',
        selector: 'button[onclick="cekSoal3()"]',
        reset: resetS3
    }
};

const JAWABAN_MATERI4 = {
    ap: {
        ap_step1: 'kabel',
        ap_step2: 'tambah',
        ap_step3: 'benar',
        ap_t1: 24,
        ap_j1: 10,
        ap_t2: 576,
        ap_j2: 100,
        ap_jum: 676,
        ap_akar: 676,
        ap_final: 26
    },
    c1: {
        c1_dik_ab: 40,
        c1_dik_bc: 30,
        c1_ditanya: 'AC',
        c1_rumus: 'AC',
        c1_ab: 40,
        c1_bc: 30,
        c1_ab_kuadrat: 1600,
        c1_bc_kuadrat: 900,
        c1_ac2: 2500,
        c1_akar_val: 2500,
        c1_ac: 50
    },
    c2: {
        c2_dik_mn: 20,
        c2_dik_no: 15,
        c2_ditanya: 'MO',
        c2_rumus: 'MO',
        c2_mn: 20,
        c2_no: 15,
        c2_mn_kuadrat: 400,
        c2_no_kuadrat: 225,
        c2_mo2: 625,
        c2_akar_val: 625,
        c2_mo: 25
    },
    c3: {
        c3_dik_dc: 15,
        c3_dik_da: 25,
        c3_dik_db: 17,
        c3_ditanya: 'AB',
        c3_da: 25,
        c3_dc1: 15,
        c3_da_kuadrat: 625,
        c3_dc1_kuadrat: 225,
        c3_ac2_val: 400,
        c3_ac: 20,
        c3_db: 17,
        c3_dc2: 15,
        c3_db_kuadrat: 289,
        c3_dc2_kuadrat: 225,
        c3_bc2_val: 64,
        c3_bc: 8,
        c3_ac_final: 20,
        c3_bc_final: 8,
        c3_ab: 12
    },
    s1: {
        s1_dik_ab: 40,
        s1_dik_bc: 30,
        s1_ditanya: 'AC',
        s1_rumus: 'AC',
        s1_ab: 40,
        s1_bc: 30,
        s1_ab_kuadrat: 1600,
        s1_bc_kuadrat: 900,
        s1_ac2: 2500,
        s1_akar_val: 2500,
        s1_ac: 50
    },
    s2: {
        s2_dik_ab: 24,
        s2_dik_ac: 25,
        s2_ditanya: 'BC',
        s2_rumus: 'BC',
        s2_ac: 25,
        s2_ab: 24,
        s2_ac_kuadrat: 625,
        s2_ab_kuadrat: 576,
        s2_bc2: 49,
        s2_akar_val: 49,
        s2_bc: 7
    },
    s3: {
        s3_dik_da: 20,
        s3_dik_ac: 16,
        s3_dik_db: 15,
        s3_ditanya: 'BC',
        s3_da: 20,
        s3_ac1: 16,
        s3_da_kuadrat: 400,
        s3_ac1_kuadrat: 256,
        s3_dc2_val: 144,
        s3_dc: 12,
        s3_db: 15,
        s3_dc2: 12,
        s3_db_kuadrat: 225,
        s3_dc2_kuadrat: 144,
        s3_bc2_val: 81,
        s3_bc: 9
    }
};

function simpanProgressMateri4(checkpointCode, points = 0, isSilent = false) {
    if (typeof window.updateProgress === 'function') {
        return window.updateProgress(
            MATERI4_ID,
            checkpointCode,
            points,
            isSilent
        );
    }

    console.warn('window.updateProgress belum tersedia. Pastikan script.js global sudah dimuat.');
    return Promise.resolve();
}

function selesaikanAktivitasMateri4(buttonSelector, resetCallback) {
    if (typeof window.tampilkanLatihanSelesai === 'function') {
        window.tampilkanLatihanSelesai(buttonSelector, resetCallback);
    }
}

function selesaikanKesempatanHabisMateri4(checkpointCode, buttonSelector, resetCallback) {
    if (!sedangUlangLatihanMateri4(buttonSelector)) {
        simpanProgressMateri4(checkpointCode, 0);
    }

    selesaikanAktivitasMateri4(
        buttonSelector,
        resetCallback
    );
}

function sedangUlangLatihanMateri4(buttonSelector) {
    const btn = document.querySelector(buttonSelector);
    return !!(btn && btn.getAttribute('data-latihan-ulang') === 'true');
}

function swalLatihanMateri4(buttonSelector, options) {
    const isUlang = sedangUlangLatihanMateri4(buttonSelector);
    const finalOptions = { ...options };

    if (isUlang) {
        const title = String(finalOptions.title || '').trim();
        const icon = String(finalOptions.icon || '').trim();

        const isPopupPoin =
            icon === 'success' &&
            /^\+\d+\s*Poin!?$/i.test(title);

        if (isPopupPoin) {
            const isiLama = finalOptions.html || finalOptions.text || 'Jawabanmu benar.';

            finalOptions.icon = 'success';
            finalOptions.title = 'Jawaban Benar!';
            delete finalOptions.text;
            finalOptions.html = `
                ${isiLama}
                <br>
                <small class="text-muted d-block mt-2">
                    Ini latihan ulang, jadi poin dan progres tidak bertambah lagi.
                </small>
            `;
            finalOptions.confirmButtonColor = '#198754';
        }

        const judulSalah = title.toLowerCase();
        const isPopupSalah =
            icon === 'error' &&
            (
                judulSalah.includes('kurang tepat') ||
                judulSalah.includes('belum tepat') ||
                judulSalah.includes('masih ada') ||
                judulSalah.includes('jawaban kurang tepat') ||
                judulSalah.includes('ada yang salah') ||
                judulSalah.includes('keliru')
            );

        if (isPopupSalah) {
            const isiLama = finalOptions.html || finalOptions.text || 'Jawabanmu masih belum tepat.';

            finalOptions.icon = 'warning';
            finalOptions.title = 'Latihan Ulang: Masih Perlu Diperbaiki';
            delete finalOptions.text;
            finalOptions.html = `
                ${isiLama}
                <br><br>
                <small class="text-muted">
                    Ini hanya latihan ulang, jadi tidak memengaruhi poin atau progresmu.
                </small>
            `;
            finalOptions.confirmButtonText = 'Coba Perbaiki Lagi';
            finalOptions.confirmButtonColor = '#ffc107';
        }
    }

    return Swal.fire(finalOptions);
}

function pulihkanTombolMateri4(section) {
    const config = MATERI4_AKTIVITAS[section];
    if (!config) return;

    const btn = document.querySelector(config.selector);
    if (!btn) return;

    btn.disabled = false;
    btn.classList.remove('d-none', 'btn-info');
    btn.classList.add('btn-success');
    btn.innerHTML = 'Cek Jawaban';
}

function resetAktivitasMateri4(section, feedbackId = null) {
    const jawaban = JAWABAN_MATERI4[section] || {};

    Object.keys(jawaban).forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.value = '';
            el.disabled = false;
            el.classList.remove(
                'is-valid',
                'is-invalid',
                'border-success',
                'border-danger',
                'text-success',
                'text-danger'
            );
        }
    });

    if (section === 'ap') {
        document.querySelectorAll('.btn-operator, .btn-rumus').forEach(btn => {
            btn.disabled = false;
            btn.classList.remove('active', 'btn-success', 'text-white');
        });

        const step2 = document.getElementById('ap_step2');
        const step3 = document.getElementById('ap_step3');
        if (step2) step2.value = '';
        if (step3) step3.value = '';
    }

    if (feedbackId) {
        const feedback = document.getElementById(feedbackId);
        if (feedback) feedback.innerHTML = '';
    }

    attemptCounts[section] = 0;
    pulihkanTombolMateri4(section);
}

function isiJawabanMateri4(section) {
    const jawaban = JAWABAN_MATERI4[section] || {};

    Object.entries(jawaban).forEach(([id, value]) => {
        fillAnswer(id, value);
    });

    if (section === 'ap') {
        document.querySelectorAll('.btn-operator, .btn-rumus').forEach(btn => {
            btn.disabled = true;
        });
    }
}

function resetApersepsi() {
    resetAktivitasMateri4('ap', 'ap_feedback');
}

function resetC1() {
    resetAktivitasMateri4('c1', 'c1_feedback');
}

function resetC2() {
    resetAktivitasMateri4('c2', 'c2_feedback');
}

function resetC3() {
    resetAktivitasMateri4('c3', 'c3_feedback');
}

function resetS1() {
    resetAktivitasMateri4('s1', 's1_feedback');
}

function resetS2() {
    resetAktivitasMateri4('s2', 's2_feedback');
}

function resetS3() {
    resetAktivitasMateri4('s3', 's3_feedback');
}

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
    if (!el) return;

    el.value = val;
    markStatus(id, true);

    if (el.type !== 'hidden') {
        el.disabled = true;
    }

    // Khusus untuk tombol pilihan Apersepsi
    if (id === 'ap_step2') {
        document.querySelectorAll('.btn-operator').forEach(b => {
            b.classList.remove('active', 'btn-success', 'text-white');
        });

        const btn = document.querySelector(`.btn-operator[data-val="${val}"]`);
        if (btn) btn.classList.add('active', 'btn-success', 'text-white');
    }

    if (id === 'ap_step3') {
        document.querySelectorAll('.btn-rumus').forEach(b => {
            b.classList.remove('active', 'btn-success', 'text-white');
        });

        const btn = document.querySelector(`.btn-rumus[data-val="${val}"]`);
        if (btn) btn.classList.add('active', 'btn-success', 'text-white');
    }
}

// Logika utama saat klik tombol periksa (dengan poin)
function processValidation(section, isComplete, isAllCorrect, btnElement, answerCallback, cpName, successMsg, earnedPoints) {
    const config = MATERI4_AKTIVITAS[section];
    const buttonSelector = config ? config.selector : null;
    const resetCallback = config ? config.reset : null;

    if (!isComplete) {
        Swal.fire({
            icon: 'warning',
            title: 'Belum Lengkap!',
            text: 'Pilih dan isi semua kotak kosong terlebih dahulu ya!',
            confirmButtonColor: '#ffc107'
        });
        return;
    }

    if (isAllCorrect) {
        if (buttonSelector && !sedangUlangLatihanMateri4(buttonSelector)) {
            simpanProgressMateri4(cpName, earnedPoints);
        }

        swalLatihanMateri4(buttonSelector, {
            icon: 'success',
            title: `+${earnedPoints} Poin!`,
            text: successMsg || 'Luar biasa! Jawaban dan perhitungan kamu tepat!',
            confirmButtonColor: '#198754'
        }).then(() => {
            if (buttonSelector && resetCallback) {
                selesaikanAktivitasMateri4(
                    buttonSelector,
                    resetCallback
                );
            }
        });

        return;
    }

    attemptCounts[section]++;

    if (attemptCounts[section] >= MAX_ATTEMPTS) {
        Swal.fire({
            title: 'Kesempatan Habis',
            text: 'Jangan menyerah! Mari kita lihat penyelesaian yang benar.',
            icon: 'info',
            confirmButtonText: 'Tampilkan Jawaban',
            confirmButtonColor: '#0d6efd',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                if (typeof window[answerCallback] === 'function') {
                    window[answerCallback]();
                }

                if (buttonSelector && resetCallback) {
                    selesaikanKesempatanHabisMateri4(
                        cpName,
                        buttonSelector,
                        resetCallback
                    );
                }
            }
        });

        return;
    }

    swalLatihanMateri4(buttonSelector, {
        icon: 'error',
        title: 'Kurang Tepat',
        text: `Masih ada isian kotak yang salah/merah. Ayo perbaiki! Sisa kesempatan: ${MAX_ATTEMPTS - attemptCounts[section]}`,
        confirmButtonColor: '#dc3545'
    });
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
    isiJawabanMateri4('ap');

    const feedback = document.getElementById('ap_feedback');
    if (feedback) {
        feedback.innerHTML = '<span class="text-primary fw-bold">Ini adalah jawaban yang benar.</span>';
    }
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
    isiJawabanMateri4('c1');

    const feedback = document.getElementById('c1_feedback');
    if (feedback) {
        feedback.innerHTML = '<span class="text-primary fw-bold">Ini adalah jawaban yang benar.</span>';
    }
}

function cekContoh2Penerapan() {
    const btn = document.querySelector('button[onclick="cekContoh2Penerapan()"]');
    const inputs = ['c2_dik_mn', 'c2_dik_no', 'c2_ditanya', 'c2_rumus', 'c2_mn', 'c2_no', 'c2_mn_kuadrat', 'c2_no_kuadrat', 'c2_akar_val', 'c2_mo'];
    if (!checkCompleteness(inputs)) return processValidation('c2', false, false, btn, 'showAnswerC2', 'm4_cp3_contoh_2', '', 15);

    // Disesuaikan: MN = 20, NO = 15
    const iDik = checkCommutative('c2_dik_mn', 'c2_dik_no', 20, 15);
    const iDit = checkValue('c2_ditanya', 'MO') && checkValue('c2_rumus', 'MO');

    // Disesuaikan: 20 -> 400, 15 -> 225
    const iSub = checkCommutativeWithSquares('c2_mn', 'c2_no', 'c2_mn_kuadrat', 'c2_no_kuadrat', 20, 15);
    const akr = checkValue('c2_akar_val', 625);
    const res = checkValue('c2_mo', 25);
    document.getElementById('c2_mo2').value = 625;

    const isAllCorrect = iDik && iDit && iSub && akr && res;
    processValidation('c2', true, isAllCorrect, btn, 'showAnswerC2', 'm4_cp3_contoh_2', 'Perhitungan jarak garis lurus ojek online sangat presisi.', 15);
}

function showAnswerC2() {
    isiJawabanMateri4('c2');

    const feedback = document.getElementById('c2_feedback');
    if (feedback) {
        feedback.innerHTML = '<span class="text-primary fw-bold">Ini adalah jawaban yang benar.</span>';
    }
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
    isiJawabanMateri4('c3');

    const feedback = document.getElementById('c3_feedback');
    if (feedback) {
        feedback.innerHTML = '<span class="text-primary fw-bold">Ini adalah jawaban yang benar.</span>';
    }
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
    isiJawabanMateri4('s1');

    const feedback = document.getElementById('s1_feedback');
    if (feedback) {
        feedback.innerHTML = '<span class="text-primary fw-bold">Ini adalah jawaban yang benar.</span>';
    }
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
    isiJawabanMateri4('s2');

    const feedback = document.getElementById('s2_feedback');
    if (feedback) {
        feedback.innerHTML = '<span class="text-primary fw-bold">Ini adalah jawaban yang benar.</span>';
    }
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
    isiJawabanMateri4('s3');

    const feedback = document.getElementById('s3_feedback');
    if (feedback) {
        feedback.innerHTML = '<span class="text-primary fw-bold">Ini adalah jawaban yang benar.</span>';
    }
}
/* =====================================================
   REFLEKSI AKHIR (PENERAPAN PYTHAGORAS - MATERI 4)
===================================================== */
function simpanRefleksiPenerapan() {
    const form = document.getElementById('formRefleksiMateri4');
    const formData = new FormData(form);
    const btnSubmit = document.getElementById('btnSimpanRefleksiPenerapan');
    const feedbackArea = document.getElementById('refleksi_feedback_penerapan');

    // Validasi HTML5 bawaan
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    // Ubah tombol jadi loading
    btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    btnSubmit.disabled = true;
    feedbackArea.innerHTML = '';

    const targetUrl = form.getAttribute('action');

    fetch(targetUrl, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            feedbackArea.innerHTML = `<div class="alert alert-success py-2 small fw-bold mb-0">${data.message}</div>`;
            btnSubmit.innerHTML = 'Tersimpan <i class="fas fa-check ms-1"></i>';
            btnSubmit.classList.replace('btn-success', 'btn-secondary');

            // Simpan ke progres PythaLearn (10 Poin)
            // PASTIKAN ID 'm4_cp_refleksi_akhir' ADA DI DATABASE ANDA
            if (typeof simpanProgressMateri4 === 'function') {
                simpanProgressMateri4('m4_cp_refleksi_akhir', 10, false);
            }

            // Memanggil pop-up sukses SweetAlert
            if (typeof swalLatihanMateri4 === 'function') { 
                swalLatihanMateri4('button[onclick="simpanRefleksiPenerapan()"]', {
                    icon: 'success',
                    title: '+10 Poin!',
                    html: 'Refleksi akhirmu berhasil disimpan.<br><small class="text-muted">Siap untuk Kuis 4? Ayo buktikan kemampuanmu!</small>',
                    confirmButtonColor: '#198754'
                });
            }
        } else {
            feedbackArea.innerHTML = `<div class="alert alert-danger py-2 small fw-bold mb-0">Gagal menyimpan data.</div>`;
            btnSubmit.innerHTML = 'Coba Lagi';
            btnSubmit.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error Refleksi M4:', error);
        feedbackArea.innerHTML = `<div class="alert alert-danger py-2 small fw-bold mb-0">Terjadi kesalahan koneksi server.</div>`;
        btnSubmit.innerHTML = 'Simpan Refleksi';
        btnSubmit.disabled = false;
    });
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
                // Penyesuaian Kunci Jawaban di Review Mode
                const ans = {
                    'c2_dik_mn': '20', 'c2_dik_no': '15', 'c2_ditanya': 'MO', 'c2_rumus': 'MO',
                    'c2_mn': '20', 'c2_no': '15', 'c2_mn_kuadrat': '400', 'c2_no_kuadrat': '225',
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

        // ---------------------------------------------------------
        // Review Mode: Refleksi Belajar Materi 4 (Penerapan)
        // ---------------------------------------------------------
        window.setupReviewMode(
            'm4_cp_refleksi_akhir', // <-- Sesuaikan dengan ID checkpoint yang benar di sistem Anda
            '#btnSimpanRefleksiPenerapan',
            function showAnswer() {
                const form = document.getElementById('formRefleksiMateri4');
                if (form) {
                    form.querySelectorAll('textarea, input').forEach(el => {
                        el.disabled = true;
                    });
                }

                const btnSubmit = document.getElementById('btnSimpanRefleksiPenerapan');
                if (btnSubmit) {
                    btnSubmit.innerHTML = 'Tersimpan <i class="fas fa-check ms-1"></i>';
                    btnSubmit.classList.replace('btn-success', 'btn-secondary');
                    btnSubmit.disabled = true;
                }

                const feedbackArea = document.getElementById('refleksi_feedback_penerapan');
                if (feedbackArea) {
                    feedbackArea.innerHTML = `<div class="alert alert-success py-2 small fw-bold mb-0"><i class="fas fa-info-circle me-1"></i> Kamu sudah menyelesaikan refleksi akhir ini.</div>`;
                }
            },
            null // <-- Kunci fungsi ini agar form refleksi TIDAK DIBERSIHKAN saat mengulang latihan materi.
        );

    }
});