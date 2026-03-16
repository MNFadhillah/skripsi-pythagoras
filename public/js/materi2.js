/* =====================================================
   SUBBAB 2 : TRIPEL PYTHAGORAS
===================================================== */
const MAX_ATTEMPTS = 3;
let attemptMM = 0, attemptC1 = 0, attemptC2 = 0;
let attemptTP1 = 0, attemptTP2 = 0, attemptLat = 0;

function setValidasiElTripel(idOrEl, isValid) {
    const el = typeof idOrEl === 'string' ? document.getElementById(idOrEl) : idOrEl;
    if (!el) return;
    el.classList.remove('is-invalid', 'is-valid');
    el.classList.add(isValid ? 'is-valid' : 'is-invalid');
}

function cekKosong(ids) {
    return ids.some(id => {
        const el = document.getElementById(id);
        return !el || el.value.trim() === '';
    });
}

function disableSemua(ids) {
    ids.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.disabled = true;
    });
}
/* =====================================================
   HALAMAN 1: MARI MENGINGAT
===================================================== */
const idsMM = ['rumusA_1', 'rumusA_2', 'rumusA_3', 'rumusB_1', 'rumusB_2', 'rumusB_3'];

function showAnswerMariMengingat() {
    const answers = {
        'rumusA_1': 'a', 'rumusA_2': 'b', 'rumusA_3': 'c',
        'rumusB_1': 'b', 'rumusB_2': 'a', 'rumusB_3': 'c'
    };
    
    for (let id in answers) {
        const el = document.getElementById(id);
        if (el) {
            el.value = answers[id];
            setValidasiElTripel(el, true);
        }
    }
    
    disableSemua(idsMM);
    document.getElementById('kesimpulanA').classList.remove('d-none');
    document.getElementById('kesimpulanB').classList.remove('d-none');
    document.getElementById('feedbackA').innerHTML = '<span class="text-primary fw-bold">Ini adalah rumus yang benar.</span>';
    document.getElementById('feedbackB').innerHTML = '';
    
    // Update progress jika ditampikan jawaban
    if(typeof updateProgress === 'function') updateProgress('materi_2_tripel_pythagoras', 'm2_cp1_mari_mengingat');
}

function cekMariMengingatTripel() {
    // 1 & 2. Cek apakah ada yang masih kosong (Belum Lengkap) -> NYAWA TIDAK BERKURANG
    if (cekKosong(idsMM)) {
        Swal.fire({ 
            icon: 'warning', 
            title: 'Belum Lengkap', 
            text: 'Lengkapi bagian dropdown yang masih kosong.', 
            confirmButtonColor: '#ffc107' 
        });
        return;
    }

    const a1 = document.getElementById('rumusA_1').value;
    const a2 = document.getElementById('rumusA_2').value;
    const a3 = document.getElementById('rumusA_3').value;
    const b1 = document.getElementById('rumusB_1').value;
    const b2 = document.getElementById('rumusB_2').value;
    const b3 = document.getElementById('rumusB_3').value;

    let isABenar = (a1 === 'a' && ((a2 === 'b' && a3 === 'c') || (a2 === 'c' && a3 === 'b')));
    let isBBenar = (b1 === 'b' && ((b2 === 'a' && b3 === 'c') || (b2 === 'c' && b3 === 'a')));

    // Berikan warna Validasi (Hijau / Merah) pada dropdown
    setValidasiElTripel('rumusA_1', a1 === 'a');
    setValidasiElTripel('rumusA_2', a2 === 'b' || a2 === 'c');
    setValidasiElTripel('rumusA_3', a3 === 'b' || a3 === 'c');
    setValidasiElTripel('rumusB_1', b1 === 'b');
    setValidasiElTripel('rumusB_2', b2 === 'a' || b2 === 'c');
    setValidasiElTripel('rumusB_3', b3 === 'a' || b3 === 'c');

    // --- SISIPAN LOGIKA FEEDBACK PER SEGITIGA ---
    let fbA = document.getElementById('feedbackA');
    let kesimpulanA = document.getElementById('kesimpulanA');
    if (isABenar) {
        fbA.innerHTML = "<span class='text-success mt-2 d-block'><strong>Tepat sekali!</strong> Karena <strong>c &lt; b &lt; a</strong>, dan <strong>a</strong> adalah sisi terpanjang (sisi miring). Sehingga <strong>a² = b² + c²</strong> merupakan segitiga siku-siku.</span>";
        kesimpulanA.classList.remove('d-none');
    } else {
        fbA.innerHTML = "<span class='text-danger mt-2 d-block'><strong>Kurang tepat.</strong> Perhatikan ukuran <strong>c &lt; b &lt; a</strong>. Perhatikan sisi terpanjangnya</span>";
        kesimpulanA.classList.add('d-none');
    }

    let fbB = document.getElementById('feedbackB');
    let kesimpulanB = document.getElementById('kesimpulanB');
    if (isBBenar) {
        fbB.innerHTML = "<span class='text-success mt-2 d-block'><strong>Tepat sekali!</strong> Karena <strong>a &lt; c &lt; b</strong>, dan <strong>b</strong> adalah sisi terpanjang (sisi miring). Sehingga <strong>b² = a² + c²</strong> merupakan segitiga siku-siku.</span>";
        kesimpulanB.classList.remove('d-none');
    } else {
        fbB.innerHTML = "<span class='text-danger mt-2 d-block'><strong>Kurang tepat.</strong> Perhatikan ukuran <strong>a &lt; c &lt; b</strong>. Perhatikan sisi terpanjangnya</span>";
        kesimpulanB.classList.add('d-none');
    }
    // --------------------------------------------

    // 5. Jika Benar Semua
    if (isABenar && isBBenar) {
        disableSemua(idsMM); // Kunci semua inputan agar tidak bisa diubah lagi
        
        Swal.fire({ 
            icon: 'success', 
            title: 'Tepat Sekali!', 
            text: 'Kamu berhasil merumuskan Kebalikan Teorema Pythagoras berdasarkan urutan panjang sisi-sisinya!', 
            confirmButtonColor: '#198754' 
        }).then(() => {
            if(typeof updateProgress === 'function') updateProgress('materi_2_tripel_pythagoras', 'm2_cp1_mari_mengingat');
        });
        
    } else {
        // 3. Jika Salah -> Kesempatan Berkurang
        attemptMM++; 
        
        // 4. Jika Salah dan Kesempatan Habis (3x) -> Tombol Tampilkan Jawaban
        if (attemptMM >= MAX_ATTEMPTS) {
            Swal.fire({
                icon: 'info',
                title: 'Kesempatan Habis',
                text: 'Mari kita lihat jawaban yang benar beserta penjelasannya.',
                confirmButtonText: 'Tampilkan Jawaban',
                confirmButtonColor: '#0d6efd',
                allowOutsideClick: false
            }).then(() => showAnswerMariMengingat());
            
        } else {
            // Jika Salah tapi masih ada kesempatan
            Swal.fire({
                icon: 'error',
                title: 'Kurang Tepat',
                text: `Jawabanmu masih ada yang keliru. Coba baca petunjuk merah di bawah gambar segitiga. Sisa kesempatan: ${MAX_ATTEMPTS - attemptMM}`,
                confirmButtonColor: '#dc3545'
            });
        }
    }
}
/* =====================================================
   HALAMAN 2: CONTOH 1 (TUMPUL)
===================================================== */
const idsC1 = [
    'c1_dik_a', 'c1_dik_b', 'c1_dik_c', 'c1_sisi_c',
    'c1_c2_awal', 'c1_c2_hasil', 'c1_a2_awal', 'c1_b2_awal',
    'c1_a2_hasil', 'c1_b2_hasil', 'c1_ab_total', 'c1_banding',
    'c1_kesimpulan'
];

function showAnswerContoh1() {
    const ans = {
        'c1_dik_a': '17',
        'c1_dik_b': '25',
        'c1_dik_c': '38',
        'c1_sisi_c': '38',
        'c1_c2_awal': '38',
        'c1_c2_hasil': '1444',
        'c1_a2_awal': '17',
        'c1_b2_awal': '25',
        'c1_a2_hasil': '289',
        'c1_b2_hasil': '625',
        'c1_ab_total': '914',
        'c1_banding': '>',
        'c1_kesimpulan': 'tumpul'
    };
    for (let id in ans) {
        document.getElementById(id).value = ans[id];
        setValidasiElTripel(id, true);
    }
    disableSemua(idsC1);
    document.getElementById('c1_feedback').innerHTML = '<span class="text-primary">Ini adalah penyelesaian yang benar.</span>';
    updateProgress('materi_2_tripel_pythagoras', 'm2_cp2_jenis_segitiga_1');
}

function cekContoh1Tripel() {
    if (cekKosong(idsC1)) {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Lengkapi bagian yang masih kosong.', confirmButtonColor: '#ffc107' });
        return;
    }

    let benar = true;
    const check = (id, val) => {
        const isCor = document.getElementById(id).value === val;
        setValidasiElTripel(id, isCor);
        if (!isCor) benar = false;
    };

    check('c1_dik_a', '17');
    check('c1_dik_b', '25');
    check('c1_dik_c', '38');
    check('c1_sisi_c', '38');
    check('c1_c2_awal', '38');
    check('c1_c2_hasil', '1444');

    const a2a = document.getElementById('c1_a2_awal').value;
    const b2a = document.getElementById('c1_b2_awal').value;
    const a2aCor = (a2a === '17' && b2a === '25') || (a2a === '25' && b2a === '17');
    setValidasiElTripel('c1_a2_awal', a2aCor);
    setValidasiElTripel('c1_b2_awal', a2aCor);
    if (!a2aCor) benar = false;

    const a2h = document.getElementById('c1_a2_hasil').value;
    const b2h = document.getElementById('c1_b2_hasil').value;
    const a2hCor = (a2h === '289' && b2h === '625') || (a2h === '625' && b2h === '289');
    setValidasiElTripel('c1_a2_hasil', a2hCor);
    setValidasiElTripel('c1_b2_hasil', a2hCor);
    if (!a2hCor) benar = false;

    check('c1_ab_total', '914');
    check('c1_banding', '>');
    check('c1_kesimpulan', 'tumpul');

    if (benar) {
        disableSemua(idsC1);
        Swal.fire({ 
            icon: 'success', 
            title: 'Jawaban Benar Semua!', 
            text: 'Langkah penyelesaian Contoh 1 benar.', 
            confirmButtonColor: '#198754' 
        }).then(() => {
            // PERBAIKAN DI SINI: Cek dulu apakah fungsi ada sebelum dijalankan
            if (typeof updateProgress === 'function') {
                updateProgress('materi_2_tripel_pythagoras', 'm2_cp2_jenis_segitiga_1');
            } else {
                console.warn("Peringatan: Fungsi updateProgress belum dibuat atau belum diload.");
            }
        });
    } else {
        attemptC1++;
        if (attemptC1 >= MAX_ATTEMPTS) {
            Swal.fire({
                icon: 'info',
                title: 'Kesempatan Habis',
                text: 'Mari kita lihat jawaban yang benar.',
                confirmButtonText: 'Tampilkan Jawaban',
                confirmButtonColor: '#0d6efd',
                allowOutsideClick: false
            }).then(() => showAnswerContoh1());
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Kurang Tepat',
                text: `Jawaban anda masih ada yang kurang tepat. Sisa kesempatan: ${MAX_ATTEMPTS - attemptC1}`,
                confirmButtonColor: '#dc3545'
            });
        }
    }
}

/* =====================================================
   HALAMAN 2: CONTOH 2 (LANCIP)
===================================================== */
const idsC2 = [
    'c2_dik_a', 'c2_dik_b', 'c2_dik_c', 'c2_sisi_c',
    'c2_c2_awal', 'c2_c2_hasil', 'c2_a2_awal', 'c2_b2_awal',
    'c2_a2_hasil', 'c2_b2_hasil', 'c2_ab_total', 'c2_banding',
    'c2_kesimpulan'
];

function showAnswerContoh2() {
    const ans = {
        'c2_dik_a': '11',
        'c2_dik_b': '13',
        'c2_dik_c': '15',
        'c2_sisi_c': '15',
        'c2_c2_awal': '15',
        'c2_c2_hasil': '225',
        'c2_a2_awal': '11',
        'c2_b2_awal': '13',
        'c2_a2_hasil': '121',
        'c2_b2_hasil': '169',
        'c2_ab_total': '290',
        'c2_banding': '<',
        'c2_kesimpulan': 'lancip'
    };
    for (let id in ans) {
        document.getElementById(id).value = ans[id];
        setValidasiElTripel(id, true);
    }
    disableSemua(idsC2);
    document.getElementById('c2_feedback').innerHTML = '<span class="text-primary">Ini adalah penyelesaian yang benar.</span>';
    updateProgress('materi_2_tripel_pythagoras', 'm2_cp3_jenis_segitiga_2');
}

function cekContoh2Tripel() {
    if (cekKosong(idsC2)) {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Lengkapi bagian yang masih kosong.', confirmButtonColor: '#ffc107' });
        return;
    }

    let benar = true;
    const check = (id, val) => {
        const isCor = document.getElementById(id).value === val;
        setValidasiElTripel(id, isCor);
        if (!isCor) benar = false;
    };

    check('c2_dik_a', '11');
    check('c2_dik_b', '13');
    check('c2_dik_c', '15');
    check('c2_sisi_c', '15');
    check('c2_c2_awal', '15');
    check('c2_c2_hasil', '225');

    const a2a = document.getElementById('c2_a2_awal').value;
    const b2a = document.getElementById('c2_b2_awal').value;
    const a2aCor = (a2a === '11' && b2a === '13') || (a2a === '13' && b2a === '11');
    setValidasiElTripel('c2_a2_awal', a2aCor);
    setValidasiElTripel('c2_b2_awal', a2aCor);
    if (!a2aCor) benar = false;

    const a2h = document.getElementById('c2_a2_hasil').value;
    const b2h = document.getElementById('c2_b2_hasil').value;
    const a2hCor = (a2h === '121' && b2h === '169') || (a2h === '169' && b2h === '121');
    setValidasiElTripel('c2_a2_hasil', a2hCor);
    setValidasiElTripel('c2_b2_hasil', a2hCor);
    if (!a2hCor) benar = false;

    check('c2_ab_total', '290');
    check('c2_banding', '<');
    check('c2_kesimpulan', 'lancip');

    if (benar) {
        disableSemua(idsC2);
        Swal.fire({ icon: 'success', title: 'Jawaban Benar Semua!', text: 'Langkah penyelesaian Contoh 2 benar.', confirmButtonColor: '#198754' }).then(() => {
            updateProgress('materi_2_tripel_pythagoras', 'm2_cp3_jenis_segitiga_2');
        });
    } else {
        attemptC2++;
        if (attemptC2 >= MAX_ATTEMPTS) {
            Swal.fire({
                icon: 'info',
                title: 'Kesempatan Habis',
                text: 'Mari kita lihat jawaban yang benar.',
                confirmButtonText: 'Tampilkan Jawaban',
                confirmButtonColor: '#0d6efd',
                allowOutsideClick: false
            }).then(() => showAnswerContoh2());
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Kurang Tepat',
                text: `Jawaban anda masih ada yang kurang tepat. Sisa kesempatan: ${MAX_ATTEMPTS - attemptC2}`,
                confirmButtonColor: '#dc3545'
            });
        }
    }
}

/* =====================================================
   HALAMAN 3: CONTOH TRIPEL 1 & 2
===================================================== */
const idsTP1 = [
    'tp1_sisi_c', 'tp1_step1_c', 'tp1_step1_b', 'tp1_step1_a',
    'tp1_step2_c2', 'tp1_step2_b2', 'tp1_step2_a2',
    'tp1_step3_c2_tot', 'tp1_sign', 'tp1_step3_ab_tot',
    'tp1_kesimpulan'
];

function showAnswerTripel1() {
    const ans = {
        'tp1_sisi_c': '17',
        'tp1_step1_c': '17',
        'tp1_step1_b': '16',
        'tp1_step1_a': '8',
        'tp1_step2_c2': '289',
        'tp1_step2_b2': '256',
        'tp1_step2_a2': '64',
        'tp1_step3_c2_tot': '289',
        'tp1_sign': '!=',
        'tp1_step3_ab_tot': '320',
        'tp1_kesimpulan': 'tidak'
    };
    for (let id in ans) {
        document.getElementById(id).value = ans[id];
        setValidasiElTripel(id, true);
    }
    disableSemua(idsTP1);
    document.getElementById('tp1_feedback').innerHTML = '<span class="text-primary">Ini adalah penyelesaian yang benar.</span>';
    updateProgress('materi_2_tripel_pythagoras', 'm2_cp4_contoh_tripel_1');
}

function cekTripel1() {
    if (cekKosong(idsTP1)) {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Lengkapi bagian yang masih kosong.', confirmButtonColor: '#ffc107' });
        return;
    }

    let benar = true;
    const check = (id, val) => {
        const isCor = document.getElementById(id).value === val;
        setValidasiElTripel(id, isCor);
        if (!isCor) benar = false;
    };

    check('tp1_sisi_c', '17');
    check('tp1_step1_c', '17');

    const a1 = document.getElementById('tp1_step1_a').value;
    const b1 = document.getElementById('tp1_step1_b').value;
    const s1Cor = (a1 === '8' && b1 === '16') || (a1 === '16' && b1 === '8');
    setValidasiElTripel('tp1_step1_a', s1Cor);
    setValidasiElTripel('tp1_step1_b', s1Cor);
    if (!s1Cor) benar = false;

    check('tp1_step2_c2', '289');

    const a2 = document.getElementById('tp1_step2_a2').value;
    const b2 = document.getElementById('tp1_step2_b2').value;
    const s2Cor = (a2 === '64' && b2 === '256') || (a2 === '256' && b2 === '64');
    setValidasiElTripel('tp1_step2_a2', s2Cor);
    setValidasiElTripel('tp1_step2_b2', s2Cor);
    if (!s2Cor) benar = false;

    check('tp1_step3_c2_tot', '289');
    check('tp1_sign', '!=');
    check('tp1_step3_ab_tot', '320');
    check('tp1_kesimpulan', 'tidak');

    if (benar) {
        disableSemua(idsTP1);
        Swal.fire({ icon: 'success', title: 'Jawaban Benar Semua!', text: 'BUKAN Tripel Pythagoras.', confirmButtonColor: '#198754' }).then(() => {
            updateProgress('materi_2_tripel_pythagoras', 'm2_cp4_contoh_tripel_1');
        });
    } else {
        attemptTP1++;
        if (attemptTP1 >= MAX_ATTEMPTS) {
            Swal.fire({
                icon: 'info',
                title: 'Kesempatan Habis',
                text: 'Mari kita lihat jawaban yang benar.',
                confirmButtonText: 'Tampilkan Jawaban',
                confirmButtonColor: '#0d6efd',
                allowOutsideClick: false
            }).then(() => showAnswerTripel1());
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Kurang Tepat',
                text: `Jawaban anda masih ada yang kurang tepat. Sisa kesempatan: ${MAX_ATTEMPTS - attemptTP1}`,
                confirmButtonColor: '#dc3545'
            });
        }
    }
}

const idsTP2 = [
    'tp2_sisi_c', 'tp2_step1_c', 'tp2_step1_b', 'tp2_step1_a',
    'tp2_step2_c2', 'tp2_step2_b2', 'tp2_step2_a2',
    'tp2_step3_c2_tot', 'tp2_sign', 'tp2_step3_ab_tot',
    'tp2_kesimpulan'
];

function showAnswerTripel2() {
    const ans = {
        'tp2_sisi_c': '26',
        'tp2_step1_c': '26',
        'tp2_step1_b': '24',
        'tp2_step1_a': '10',
        'tp2_step2_c2': '676',
        'tp2_step2_b2': '576',
        'tp2_step2_a2': '100',
        'tp2_step3_c2_tot': '676',
        'tp2_sign': '=',
        'tp2_step3_ab_tot': '676',
        'tp2_kesimpulan': 'ya'
    };
    for (let id in ans) {
        document.getElementById(id).value = ans[id];
        setValidasiElTripel(id, true);
    }
    disableSemua(idsTP2);
    document.getElementById('tp2_feedback').innerHTML = '<span class="text-primary">Ini adalah penyelesaian yang benar.</span>';
    updateProgress('materi_2_tripel_pythagoras', 'm2_cp5_contoh_tripel_2');
}

function cekTripel2() {
    if (cekKosong(idsTP2)) {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Lengkapi bagian yang masih kosong.', confirmButtonColor: '#ffc107' });
        return;
    }

    let benar = true;
    const check = (id, val) => {
        const isCor = document.getElementById(id).value === val;
        setValidasiElTripel(id, isCor);
        if (!isCor) benar = false;
    };

    check('tp2_sisi_c', '26');
    check('tp2_step1_c', '26');

    const a1 = document.getElementById('tp2_step1_a').value;
    const b1 = document.getElementById('tp2_step1_b').value;
    const s1Cor = (a1 === '10' && b1 === '24') || (a1 === '24' && b1 === '10');
    setValidasiElTripel('tp2_step1_a', s1Cor);
    setValidasiElTripel('tp2_step1_b', s1Cor);
    if (!s1Cor) benar = false;

    check('tp2_step2_c2', '676');

    const a2 = document.getElementById('tp2_step2_a2').value;
    const b2 = document.getElementById('tp2_step2_b2').value;
    const s2Cor = (a2 === '100' && b2 === '576') || (a2 === '576' && b2 === '100');
    setValidasiElTripel('tp2_step2_a2', s2Cor);
    setValidasiElTripel('tp2_step2_b2', s2Cor);
    if (!s2Cor) benar = false;

    check('tp2_step3_c2_tot', '676');
    check('tp2_sign', '=');
    check('tp2_step3_ab_tot', '676');
    check('tp2_kesimpulan', 'ya');

    if (benar) {
        disableSemua(idsTP2);
        Swal.fire({ icon: 'success', title: 'Jawaban Benar Semua!', text: 'ADALAH Tripel Pythagoras.', confirmButtonColor: '#198754' }).then(() => {
            updateProgress('materi_2_tripel_pythagoras', 'm2_cp5_contoh_tripel_2');
        });
    } else {
        attemptTP2++;
        if (attemptTP2 >= MAX_ATTEMPTS) {
            Swal.fire({
                icon: 'info',
                title: 'Kesempatan Habis',
                text: 'Mari kita lihat jawaban yang benar.',
                confirmButtonText: 'Tampilkan Jawaban',
                confirmButtonColor: '#0d6efd',
                allowOutsideClick: false
            }).then(() => showAnswerTripel2());
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Kurang Tepat',
                text: `Jawaban anda masih ada yang kurang tepat. Sisa kesempatan: ${MAX_ATTEMPTS - attemptTP2}`,
                confirmButtonColor: '#dc3545'
            });
        }
    }
}

/* =====================================================
   HALAMAN 4: AYO BERLATIH (LATIHAN KOMPLEKS)
===================================================== */
function showAnswerLatihan() {
    // Soal 1
    const keysSoal1 = { 'soal1a': 'ya', 'soal1b': 'tidak', 'soal1c': 'ya', 'soal1d': 'tidak', 'soal1e': 'ya' };
    for (let name in keysSoal1) {
        document.querySelector(`input[name="${name}"][value="${keysSoal1[name]}"]`).checked = true;
        document.querySelectorAll(`input[name="${name}"]`).forEach(r => {
            r.disabled = true;
            r.parentElement.classList.remove('bg-danger', 'text-white');
        });
        document.querySelector(`input[name="${name}"]:checked`).parentElement.classList.add('bg-success', 'text-white');
    }

    // Soal 2
    document.querySelector('input[name="soal2"][value="A"]').checked = true;
    document.querySelectorAll('input[name="soal2"]').forEach(r => r.disabled = true);
    document.querySelectorAll('input[name="soal2"] + label').forEach(lbl => {
        lbl.classList.remove('btn-danger', 'btn-success', 'text-white');
        lbl.classList.add('btn-outline-success');
    });
    document.querySelector(`label[for="soal2A"]`).classList.replace('btn-outline-success', 'btn-success');
    document.querySelector(`label[for="soal2A"]`).classList.add('text-white');

    // Soal 3
    const ans3 = [15, 15, 225, 9, 12, 81, 144, 225];
    const inputsSoal3 = document.querySelectorAll('.input-soal3');
    inputsSoal3.forEach((inp, i) => {
        inp.value = ans3[i];
        setValidasiElTripel(inp, true);
        inp.disabled = true;
    });

    const comps = ['inp_compare_c_soal3', 'inp_sign_soal3', 'inp_compare_ab_soal3', 'selectSoal3'];
    const compAns = ['225', '=', '225', 'Siku-siku'];
    comps.forEach((id, i) => {
        const el = document.getElementById(id);
        el.value = compAns[i];
        setValidasiElTripel(el, true);
        el.disabled = true;
    });

    updateProgress('materi_2_tripel_pythagoras', 'm2_cp6_ayo_berlatih');
}

function cekLatihanTripel() {
    let isKosong = false;

    // Cek Kosong Soal 1
    ['soal1a', 'soal1b', 'soal1c', 'soal1d', 'soal1e'].forEach(name => {
        if (!document.querySelector(`input[name="${name}"]:checked`)) isKosong = true;
    });
    // Cek Kosong Soal 2
    if (!document.querySelector('input[name="soal2"]:checked')) isKosong = true;
    // Cek Kosong Soal 3
    document.querySelectorAll('.input-soal3').forEach(inp => {
        if (inp.value.trim() === "") isKosong = true;
    });
    const comps = ['inp_compare_c_soal3', 'inp_sign_soal3', 'inp_compare_ab_soal3', 'selectSoal3'];
    if (cekKosong(comps)) isKosong = true;

    if (isKosong) {
        Swal.fire({ icon: 'warning', title: 'Lengkapi Dulu', text: 'Lengkapi bagian yang masih kosong.', confirmButtonColor: '#ffc107' });
        return;
    }

    let benar = true;

    // Validasi Soal 1
    const keysSoal1 = { 'soal1a': 'ya', 'soal1b': 'tidak', 'soal1c': 'ya', 'soal1d': 'tidak', 'soal1e': 'ya' };
    for (let name in keysSoal1) {
        const pil = document.querySelector(`input[name="${name}"]:checked`);
        document.querySelectorAll(`input[name="${name}"]`).forEach(r => r.parentElement.classList.remove('bg-success', 'bg-danger', 'text-white'));
        if (pil.value === keysSoal1[name]) {
            pil.parentElement.classList.add('bg-success', 'text-white');
        } else {
            pil.parentElement.classList.add('bg-danger', 'text-white');
            benar = false;
        }
    }

    // Validasi Soal 2
    const pilSoal2 = document.querySelector('input[name="soal2"]:checked');
    document.querySelectorAll('input[name="soal2"] + label').forEach(lbl => {
        lbl.classList.remove('btn-success', 'btn-danger', 'text-white');
        lbl.classList.add('btn-outline-success');
    });
    const lblTerpilih = document.querySelector(`label[for="${pilSoal2.id}"]`);
    if (pilSoal2.value === 'A') {
        lblTerpilih.classList.replace('btn-outline-success', 'btn-success');
        lblTerpilih.classList.add('text-white');
    } else {
        lblTerpilih.classList.replace('btn-outline-success', 'btn-danger');
        lblTerpilih.classList.add('text-white');
        benar = false;
    }

    // Validasi Soal 3
    const inputsSoal3 = document.querySelectorAll('.input-soal3');
    const valC = parseInt(inputsSoal3[0].value);
    const valC2 = parseInt(inputsSoal3[1].value);
    const valC2Res = parseInt(inputsSoal3[2].value);
    const valA = parseInt(inputsSoal3[3].value);
    const valB = parseInt(inputsSoal3[4].value);
    const valA2 = parseInt(inputsSoal3[5].value);
    const valB2 = parseInt(inputsSoal3[6].value);
    const valSum = parseInt(inputsSoal3[7].value);

    const chk = (el, cond) => {
        setValidasiElTripel(el, cond);
        if (!cond) benar = false;
    };
    chk(inputsSoal3[0], valC === 15);
    chk(inputsSoal3[1], valC2 === 15);
    chk(inputsSoal3[2], valC2Res === 225);

    let abBenar = (valA === 9 && valB === 12) || (valA === 12 && valB === 9);
    chk(inputsSoal3[3], abBenar);
    chk(inputsSoal3[4], abBenar);

    let a2b2Benar = (valA2 === 81 && valB2 === 144) || (valA2 === 144 && valB2 === 81);
    if (valA === 9 && valA2 !== 81) a2b2Benar = false;
    if (valA === 12 && valA2 !== 144) a2b2Benar = false;
    if (valB === 9 && valB2 !== 81) a2b2Benar = false;
    if (valB === 12 && valB2 !== 144) a2b2Benar = false;
    chk(inputsSoal3[5], a2b2Benar);
    chk(inputsSoal3[6], a2b2Benar);
    chk(inputsSoal3[7], valSum === 225);

    chk('inp_compare_c_soal3', document.getElementById('inp_compare_c_soal3').value === '225');
    chk('inp_sign_soal3', document.getElementById('inp_sign_soal3').value === '=');
    chk('inp_compare_ab_soal3', document.getElementById('inp_compare_ab_soal3').value === '225');
    chk('selectSoal3', document.getElementById('selectSoal3').value === 'Siku-siku');

    if (benar) {
        Swal.fire({ icon: 'success', title: 'Jawaban Benar Semua!', text: 'Luar biasa, semua jawaban latihan tepat.', confirmButtonColor: '#198754' }).then(() => {
            updateProgress('materi_2_tripel_pythagoras', 'm2_cp6_ayo_berlatih');
        });
    } else {
        attemptLat++;
        if (attemptLat >= MAX_ATTEMPTS) {
            Swal.fire({
                icon: 'info',
                title: 'Kesempatan Habis',
                text: 'Mari kita lihat jawaban yang benar.',
                confirmButtonText: 'Tampilkan Jawaban',
                confirmButtonColor: '#0d6efd',
                allowOutsideClick: false
            }).then(() => showAnswerLatihan());
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Jawaban Anda masih ada yang kurang tepat',
                text: `Sisa kesempatan: ${MAX_ATTEMPTS - attemptLat}`,
                confirmButtonColor: '#dc3545'
            });
        }
    }
}

/* =====================================================
   HALAMAN 5: REFLEKSI AKHIR (TRIPEL PYTHAGORAS)
===================================================== */
function cekRefleksiTripel() {
    // Mengecek apakah radio button (Ya/Tidak) sudah dipilih
    const isPilihanTerisi = document.querySelector('input[name="ref_tri_1"]:checked');

    // Mengecek apakah textarea 1 sudah diisi teks
    const isText1Terisi = document.getElementById('ref_tri_1_text') ? document.getElementById('ref_tri_1_text').value.trim().length > 0 : false;

    // Mengecek apakah textarea 2 sudah diisi teks
    const isText2Terisi = document.getElementById('ref_tri_2_text') ? document.getElementById('ref_tri_2_text').value.trim().length > 0 : false;

    // Jika ketiganya sudah diisi
    if (isPilihanTerisi && isText1Terisi && isText2Terisi) {

        // Panggil update progress dengan 2 parameter yang BENAR
        if (typeof updateProgress === 'function') {
            updateProgress('materi_2_tripel_pythagoras', 'm2_cp7_refleksi');
        }

        Swal.fire({
            icon: 'success',
            title: 'Terima Kasih!',
            text: 'Refleksimu sudah tersimpan. Silakan kerjakan Kuis 2!',
            confirmButtonColor: '#198754'
        });

    } else {
        // Jika ada yang masih kosong
        Swal.fire({
            icon: 'info',
            title: 'Belum Lengkap!',
            text: 'Tolong isi semua bagian refleksi terlebih dahulu ya.',
            confirmButtonColor: '#0d6efd'
        });
    }
}