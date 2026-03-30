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
    document.getElementById('feedbackA').innerHTML = '';
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
    // Kunci Soal 1 (Siku-siku)
    const ans1 = [15, 15, 225, 9, 12, 81, 144, 225];
    const inputsSoal1 = document.querySelectorAll('.input-soal1');
    inputsSoal1.forEach((inp, i) => { inp.value = ans1[i]; setValidasiElTripel(inp, true); inp.disabled = true; });
    ['inp_compare_c_soal1', 'inp_sign_soal1', 'inp_compare_ab_soal1', 'selectSoal1'].forEach((id, i) => {
        const el = document.getElementById(id);
        el.value = ['225', '=', '225', 'Siku-siku'][i];
        setValidasiElTripel(el, true); el.disabled = true;
    });

    // Kunci Soal 2 (Tumpul)
    const ans2 = [12, 12, 144, 6, 8, 36, 64, 100];
    const inputsSoal2 = document.querySelectorAll('.input-soal2');
    inputsSoal2.forEach((inp, i) => { inp.value = ans2[i]; setValidasiElTripel(inp, true); inp.disabled = true; });
    ['inp_compare_c_soal2', 'inp_sign_soal2', 'inp_compare_ab_soal2', 'selectSoal2'].forEach((id, i) => {
        const el = document.getElementById(id);
        el.value = ['144', '>', '100', 'Tumpul'][i];
        setValidasiElTripel(el, true); el.disabled = true;
    });

    // Kunci Soal 3, 4, 5 (Ya/Tidak)
    const keysYT = { 'soal3': 'ya', 'soal4': 'tidak', 'soal5': 'ya' };
    for (let name in keysYT) {
        document.querySelector(`input[name="${name}"][value="${keysYT[name]}"]`).checked = true;
        document.querySelectorAll(`input[name="${name}"]`).forEach(r => {
            r.disabled = true; r.parentElement.classList.remove('bg-danger', 'text-white');
        });
        document.querySelector(`input[name="${name}"]:checked`).parentElement.classList.add('bg-success', 'text-white');
    }

    // Kunci Soal 6, 7, 8 (PG)
    const keysPG = { 'soal6': 'A', 'soal7': 'B', 'soal8': 'C' };
    for (let name in keysPG) {
        // Ceklis jawaban yang benar
        document.querySelector(`input[name="${name}"][value="${keysPG[name]}"]`).checked = true;
        
        // Kunci inputan
        document.querySelectorAll(`input[name="${name}"]`).forEach(r => r.disabled = true);
        
        // JURUS PAMUNGKAS: Paksa semua label kembali ke default murni (Tanpa bg-white)
        document.querySelectorAll(`input[name="${name}"] + label`).forEach(lbl => {
            lbl.className = 'btn btn-outline-success w-100 py-2 fw-bold'; 
        });
    }

    if(typeof updateProgress === 'function') updateProgress('materi_2_tripel_pythagoras', 'm2_cp6_ayo_berlatih');
}

function cekLatihanTripel() {
    let isKosong = false;

    // Cek form terisi penuh
    document.querySelectorAll('.input-soal1, .input-soal2').forEach(inp => { if (inp.value.trim() === "") isKosong = true; });
    const comps = [
        'inp_compare_c_soal1', 'inp_sign_soal1', 'inp_compare_ab_soal1', 'selectSoal1',
        'inp_compare_c_soal2', 'inp_sign_soal2', 'inp_compare_ab_soal2', 'selectSoal2'
    ];
    comps.forEach(id => { if (document.getElementById(id).value === "") isKosong = true; });

    ['soal3', 'soal4', 'soal5', 'soal6', 'soal7', 'soal8'].forEach(name => {
        if (!document.querySelector(`input[name="${name}"]:checked`)) isKosong = true;
    });

    if (isKosong) {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap!', text: 'Pastikan semua kotak isian dan pilihan sudah terjawab.', confirmButtonColor: '#ffc107' });
        return;
    }

    let benar = true;
    const chk = (el, cond) => {
        if(typeof el === 'string') el = document.getElementById(el);
        if(typeof setValidasiElTripel === 'function') setValidasiElTripel(el, cond);
        else { el.classList.remove('is-valid', 'is-invalid'); el.classList.add(cond ? 'is-valid' : 'is-invalid'); }
        if (!cond) benar = false;
    };

    // Validasi Soal 1 (9, 12, 15)
    const i1 = document.querySelectorAll('.input-soal1');
    const v1 = Array.from(i1).map(inp => parseInt(inp.value));
    chk(i1[0], v1[0] === 15); chk(i1[1], v1[1] === 15); chk(i1[2], v1[2] === 225);
    let ab1 = (v1[3] === 9 && v1[4] === 12) || (v1[3] === 12 && v1[4] === 9);
    chk(i1[3], ab1); chk(i1[4], ab1);
    let a2b2_1 = (v1[5] === 81 && v1[6] === 144) || (v1[5] === 144 && v1[6] === 81);
    if (v1[3] === 9 && v1[5] !== 81) a2b2_1 = false; if (v1[4] === 9 && v1[6] !== 81) a2b2_1 = false;
    if (v1[3] === 12 && v1[5] !== 144) a2b2_1 = false; if (v1[4] === 12 && v1[6] !== 144) a2b2_1 = false;
    chk(i1[5], a2b2_1); chk(i1[6], a2b2_1); chk(i1[7], v1[7] === 225);
    chk('inp_compare_c_soal1', document.getElementById('inp_compare_c_soal1').value === '225');
    chk('inp_sign_soal1', document.getElementById('inp_sign_soal1').value === '=');
    chk('inp_compare_ab_soal1', document.getElementById('inp_compare_ab_soal1').value === '225');
    chk('selectSoal1', document.getElementById('selectSoal1').value === 'Siku-siku');

    // Validasi Soal 2 (6, 8, 12)
    const i2 = document.querySelectorAll('.input-soal2');
    const v2 = Array.from(i2).map(inp => parseInt(inp.value));
    chk(i2[0], v2[0] === 12); chk(i2[1], v2[1] === 12); chk(i2[2], v2[2] === 144);
    let ab2 = (v2[3] === 6 && v2[4] === 8) || (v2[3] === 8 && v2[4] === 6);
    chk(i2[3], ab2); chk(i2[4], ab2);
    let a2b2_2 = (v2[5] === 36 && v2[6] === 64) || (v2[5] === 64 && v2[6] === 36);
    if (v2[3] === 6 && v2[5] !== 36) a2b2_2 = false; if (v2[4] === 6 && v2[6] !== 36) a2b2_2 = false;
    if (v2[3] === 8 && v2[5] !== 64) a2b2_2 = false; if (v2[4] === 8 && v2[6] !== 64) a2b2_2 = false;
    chk(i2[5], a2b2_2); chk(i2[6], a2b2_2); chk(i2[7], v2[7] === 100);
    chk('inp_compare_c_soal2', document.getElementById('inp_compare_c_soal2').value === '144');
    chk('inp_sign_soal2', document.getElementById('inp_sign_soal2').value === '>');
    chk('inp_compare_ab_soal2', document.getElementById('inp_compare_ab_soal2').value === '100');
    chk('selectSoal2', document.getElementById('selectSoal2').value === 'Tumpul');

    // Validasi Soal 3, 4, 5
    const keysYT = { 'soal3': 'ya', 'soal4': 'tidak', 'soal5': 'ya' };
    for (let name in keysYT) {
        const pil = document.querySelector(`input[name="${name}"]:checked`);
        document.querySelectorAll(`input[name="${name}"]`).forEach(r => r.parentElement.classList.remove('bg-success', 'bg-danger', 'text-white'));
        if (pil.value === keysYT[name]) pil.parentElement.classList.add('bg-success', 'text-white');
        else { pil.parentElement.classList.add('bg-danger', 'text-white'); benar = false; }
    }

    // Validasi Soal 6, 7, 8
    const keysPG = { 'soal6': 'A', 'soal7': 'B', 'soal8': 'C' };
    for (let name in keysPG) {
        const pil = document.querySelector(`input[name="${name}"]:checked`);
        
        // JURUS PAMUNGKAS: Reset semua label ke kondisi default murni dulu
        document.querySelectorAll(`input[name="${name}"] + label`).forEach(lbl => {
            lbl.className = 'btn btn-outline-success w-100 py-2 fw-bold';
        });

        const lblTerpilih = document.querySelector(`label[for="${pil.id}"]`);
        
        // Evaluasi
        if (pil.value !== keysPG[name]) {
            // Jika Salah: Timpa class-nya menjadi tombol merah (danger)
            lblTerpilih.className = 'btn btn-danger w-100 py-2 fw-bold text-white'; 
            benar = false;
        }
        // Jika Benar: Biarkan class default, karena Bootstrap otomatis menghijaukannya saat :checked
    }

    if (benar) {
        Swal.fire({ 
            icon: 'success', title: 'Benar Semua!', 
            // html: 'Kerja bagus, kamu telah menguasai jenis segitiga dan Tripel Pythagoras.<br><br><span style="color: #198754; font-size: 1.3em; font-weight: bold;">🪙 +30 Poin!</span>', 
            confirmButtonColor: '#198754' 
        }).then(() => {
            if(typeof updateProgress === 'function') updateProgress('materi_2_tripel_pythagoras', 'm2_cp6_ayo_berlatih'); // Beri reward 30 Poin
        });
    } else {
        if(typeof attemptLat !== 'undefined') attemptLat++;
        let curAtt = typeof attemptLat !== 'undefined' ? attemptLat : 1;
        let maxAtt = typeof MAX_ATTEMPTS !== 'undefined' ? MAX_ATTEMPTS : 3;

        if (curAtt >= maxAtt) {
            Swal.fire({
                icon: 'info', title: 'Kesempatan Habis', text: 'Mari pelajari jawaban yang benar.',
                confirmButtonText: 'Tampilkan Jawaban', confirmButtonColor: '#0d6efd', allowOutsideClick: false
            }).then(() => showAnswerLatihan());
        } else {
            Swal.fire({
                icon: 'error', title: 'Belum Tepat',
                text: `Masih ada jawaban merah/salah. Periksa kembali! Sisa kesempatan: ${maxAtt - curAtt}`,
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

/* =====================================================
   AKTIFASI MODE REVIEW UNTUK MATERI 2 (FULL)
===================================================== */
document.addEventListener('DOMContentLoaded', function () {
    
    if (typeof window.setupReviewMode === 'function') {

        // 1. Mari Mengingat
        window.setupReviewMode('m2_cp1_mari_mengingat', 'button[onclick="cekMariMengingatTripel()"]',
            function() {
                const ans = { 'rumusA_1': 'a', 'rumusA_2': 'b', 'rumusA_3': 'c', 'rumusB_1': 'b', 'rumusB_2': 'a', 'rumusB_3': 'c' };
                for (let id in ans) { let el = document.getElementById(id); if (el) { el.value = ans[id]; el.classList.add('is-valid'); el.disabled = true; } }
                if(document.getElementById('kesimpulanA')) document.getElementById('kesimpulanA').classList.remove('d-none');
                if(document.getElementById('kesimpulanB')) document.getElementById('kesimpulanB').classList.remove('d-none');
                if(document.getElementById('feedbackA')) document.getElementById('feedbackA').innerHTML = '';
            },
            function() {
                ['rumusA_1', 'rumusA_2', 'rumusA_3', 'rumusB_1', 'rumusB_2', 'rumusB_3'].forEach(id => {
                    let el = document.getElementById(id); if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid'); el.disabled = false; }
                });
                if(document.getElementById('kesimpulanA')) document.getElementById('kesimpulanA').classList.add('d-none');
                if(document.getElementById('kesimpulanB')) document.getElementById('kesimpulanB').classList.add('d-none');
                if(document.getElementById('feedbackA')) document.getElementById('feedbackA').innerHTML = '';
                if(document.getElementById('feedbackB')) document.getElementById('feedbackB').innerHTML = '';
            }
        );

        // 2. Contoh 1 (Tumpul)
        window.setupReviewMode('m2_cp2_jenis_segitiga_1', 'button[onclick="cekContoh1Tripel()"]',
            function() {
                const ans = { 'c1_dik_a': '17', 'c1_dik_b': '25', 'c1_dik_c': '38', 'c1_sisi_c': '38', 'c1_c2_awal': '38', 'c1_c2_hasil': '1444', 'c1_a2_awal': '17', 'c1_b2_awal': '25', 'c1_a2_hasil': '289', 'c1_b2_hasil': '625', 'c1_ab_total': '914', 'c1_banding': '>', 'c1_kesimpulan': 'tumpul' };
                for (let id in ans) { let el = document.getElementById(id); if (el) { el.value = ans[id]; el.classList.add('is-valid'); el.disabled = true; } }
                if(document.getElementById('c1_feedback')) document.getElementById('c1_feedback').innerHTML = '<span class="text-primary fw-bold">Ini adalah penyelesaian yang benar.</span>';
            },
            function() {
                ['c1_dik_a', 'c1_dik_b', 'c1_dik_c', 'c1_sisi_c', 'c1_c2_awal', 'c1_c2_hasil', 'c1_a2_awal', 'c1_b2_awal', 'c1_a2_hasil', 'c1_b2_hasil', 'c1_ab_total', 'c1_banding', 'c1_kesimpulan'].forEach(id => {
                    let el = document.getElementById(id); if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid'); el.disabled = false; }
                });
                if(document.getElementById('c1_feedback')) document.getElementById('c1_feedback').innerHTML = '';
            }
        );

        // 3. Contoh 2 (Lancip)
        window.setupReviewMode('m2_cp3_jenis_segitiga_2', 'button[onclick="cekContoh2Tripel()"]',
            function() {
                const ans = { 'c2_dik_a': '11', 'c2_dik_b': '13', 'c2_dik_c': '15', 'c2_sisi_c': '15', 'c2_c2_awal': '15', 'c2_c2_hasil': '225', 'c2_a2_awal': '11', 'c2_b2_awal': '13', 'c2_a2_hasil': '121', 'c2_b2_hasil': '169', 'c2_ab_total': '290', 'c2_banding': '<', 'c2_kesimpulan': 'lancip' };
                for (let id in ans) { let el = document.getElementById(id); if (el) { el.value = ans[id]; el.classList.add('is-valid'); el.disabled = true; } }
                if(document.getElementById('c2_feedback')) document.getElementById('c2_feedback').innerHTML = '<span class="text-primary fw-bold">Ini adalah penyelesaian yang benar.</span>';
            },
            function() {
                ['c2_dik_a', 'c2_dik_b', 'c2_dik_c', 'c2_sisi_c', 'c2_c2_awal', 'c2_c2_hasil', 'c2_a2_awal', 'c2_b2_awal', 'c2_a2_hasil', 'c2_b2_hasil', 'c2_ab_total', 'c2_banding', 'c2_kesimpulan'].forEach(id => {
                    let el = document.getElementById(id); if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid'); el.disabled = false; }
                });
                if(document.getElementById('c2_feedback')) document.getElementById('c2_feedback').innerHTML = '';
            }
        );

        // 4. Contoh Tripel 1
        window.setupReviewMode('m2_cp4_contoh_tripel_1', 'button[onclick="cekTripel1()"]',
            function() {
                const ans = { 'tp1_sisi_c': '17', 'tp1_step1_c': '17', 'tp1_step1_b': '16', 'tp1_step1_a': '8', 'tp1_step2_c2': '289', 'tp1_step2_b2': '256', 'tp1_step2_a2': '64', 'tp1_step3_c2_tot': '289', 'tp1_sign': '!=', 'tp1_step3_ab_tot': '320', 'tp1_kesimpulan': 'tidak' };
                for (let id in ans) { let el = document.getElementById(id); if (el) { el.value = ans[id]; el.classList.add('is-valid'); el.disabled = true; } }
                if(document.getElementById('tp1_feedback')) document.getElementById('tp1_feedback').innerHTML = '<span class="text-primary fw-bold">Ini adalah penyelesaian yang benar.</span>';
            },
            function() {
                ['tp1_sisi_c', 'tp1_step1_c', 'tp1_step1_b', 'tp1_step1_a', 'tp1_step2_c2', 'tp1_step2_b2', 'tp1_step2_a2', 'tp1_step3_c2_tot', 'tp1_sign', 'tp1_step3_ab_tot', 'tp1_kesimpulan'].forEach(id => {
                    let el = document.getElementById(id); if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid'); el.disabled = false; }
                });
                if(document.getElementById('tp1_feedback')) document.getElementById('tp1_feedback').innerHTML = '';
            }
        );

        // 5. Contoh Tripel 2
        window.setupReviewMode('m2_cp5_contoh_tripel_2', 'button[onclick="cekTripel2()"]',
            function() {
                const ans = { 'tp2_sisi_c': '26', 'tp2_step1_c': '26', 'tp2_step1_b': '24', 'tp2_step1_a': '10', 'tp2_step2_c2': '676', 'tp2_step2_b2': '576', 'tp2_step2_a2': '100', 'tp2_step3_c2_tot': '676', 'tp2_sign': '=', 'tp2_step3_ab_tot': '676', 'tp2_kesimpulan': 'ya' };
                for (let id in ans) { let el = document.getElementById(id); if (el) { el.value = ans[id]; el.classList.add('is-valid'); el.disabled = true; } }
                if(document.getElementById('tp2_feedback')) document.getElementById('tp2_feedback').innerHTML = '<span class="text-primary fw-bold">Ini adalah penyelesaian yang benar.</span>';
            },
            function() {
                ['tp2_sisi_c', 'tp2_step1_c', 'tp2_step1_b', 'tp2_step1_a', 'tp2_step2_c2', 'tp2_step2_b2', 'tp2_step2_a2', 'tp2_step3_c2_tot', 'tp2_sign', 'tp2_step3_ab_tot', 'tp2_kesimpulan'].forEach(id => {
                    let el = document.getElementById(id); if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid'); el.disabled = false; }
                });
                if(document.getElementById('tp2_feedback')) document.getElementById('tp2_feedback').innerHTML = '';
            }
        );

        // 6. Ayo Berlatih
        window.setupReviewMode('m2_cp6_ayo_berlatih', 'button[onclick="cekLatihanTripel()"]',
            function() {
                // Saat mode review diaktifkan, kita cukup memanggil fungsi showAnswerLatihan 
                // yang sudah kita buat sebelumnya untuk mengisi semua jawaban yang benar otomatis.
                if (typeof showAnswerLatihan === 'function') {
                    showAnswerLatihan();
                }
            },
            function() {
                // Fungsi Reset: Mengosongkan form jika mode review ditutup
                
                // 1. Reset Soal 1 & 2 (Isian Jenis Segitiga)
                document.querySelectorAll('.input-soal1, .input-soal2').forEach(inp => { 
                    inp.value = ''; 
                    inp.disabled = false; 
                    inp.classList.remove('is-valid', 'is-invalid'); 
                });
                
                const dropdowns = [
                    'inp_compare_c_soal1', 'inp_sign_soal1', 'inp_compare_ab_soal1', 'selectSoal1', 
                    'inp_compare_c_soal2', 'inp_sign_soal2', 'inp_compare_ab_soal2', 'selectSoal2'
                ];
                dropdowns.forEach(id => { 
                    const el = document.getElementById(id); 
                    if (el) { 
                        el.value = ''; 
                        el.disabled = false; 
                        el.classList.remove('is-valid', 'is-invalid'); 
                    } 
                });
                
                // 2. Reset Soal 3, 4, 5 (Radio Ya/Tidak)
                ['soal3', 'soal4', 'soal5'].forEach(name => {
                    document.querySelectorAll(`input[name="${name}"]`).forEach(r => { 
                        r.disabled = false; 
                        r.checked = false; 
                        r.parentElement.classList.remove('bg-success', 'bg-danger', 'text-white'); 
                    });
                });
                
                // 3. Reset Soal 6, 7, 8 (Pilihan Ganda A/B/C)
                ['soal6', 'soal7', 'soal8'].forEach(name => {
                    document.querySelectorAll(`input[name="${name}"]`).forEach(r => { 
                        r.disabled = false; 
                        r.checked = false; 
                    });
                    
                    // JURUS PAMUNGKAS: Bersihkan total sisa warna merah/putih dari sesi sebelumnya
                    document.querySelectorAll(`input[name="${name}"] + label`).forEach(lbl => { 
                        lbl.className = 'btn btn-outline-success w-100 py-2 fw-bold'; 
                    });
                });
            }
        );

        // 7. Refleksi
        window.setupReviewMode('m2_cp7_refleksi', 'button[onclick="cekRefleksiTripel()"]',
            function() {
                ['ref_tri_1_ya', 'ref_tri_1_tidak', 'ref_tri_1_text', 'ref_tri_2_text'].forEach(id => {
                    const el = document.getElementById(id); if (el) { el.disabled = true; el.classList.add('is-valid'); }
                });
            },
            function() {
                ['ref_tri_1_ya', 'ref_tri_1_tidak'].forEach(id => {
                    const el = document.getElementById(id); if (el) { el.disabled = false; el.checked = false; el.classList.remove('is-valid'); }
                });
                ['ref_tri_1_text', 'ref_tri_2_text'].forEach(id => {
                    const el = document.getElementById(id); if (el) { el.disabled = false; el.value = ''; el.classList.remove('is-valid', 'is-invalid'); }
                });
            }
        );

    }
});