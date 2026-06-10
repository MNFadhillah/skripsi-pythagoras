function simpanProgressMateri2(checkpointCode, points = 0, isSilent = true) {
    if (typeof window.updateProgress === 'function') {
        return window.updateProgress(
            'materi_2_tripel_pythagoras',
            checkpointCode,
            points,
            isSilent
        );
    }

    console.warn('window.updateProgress belum tersedia. Pastikan script.js global sudah dimuat.');
    return Promise.resolve();
}

function selesaikanAktivitasMateri2(buttonSelector, resetCallback) {
    if (typeof window.tampilkanLatihanSelesai === 'function') {
        window.tampilkanLatihanSelesai(buttonSelector, resetCallback);
    }
}

function sedangUlangLatihanMateri2(buttonSelector) {
    const btn = document.querySelector(buttonSelector);
    return !!(btn && btn.getAttribute('data-latihan-ulang') === 'true');
}

function swalLatihanMateri2(buttonSelector, options) {
    const isUlang = sedangUlangLatihanMateri2(buttonSelector);
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
                judulSalah.includes('masih ada yang salah')
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

/* =====================================================
   SUBBAB 2 : TRIPEL PYTHAGORAS
===================================================== */
const MAX_ATTEMPTS = 3;
let attemptMM = 0, attemptC1 = 0;
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


function resetMariMengingatTripel() {
    idsMM.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.value = '';
            el.disabled = false;
            el.classList.remove('is-valid', 'is-invalid');
        }
    });

    const feedbackA = document.getElementById('feedbackA');
    const feedbackB = document.getElementById('feedbackB');
    const kesimpulanA = document.getElementById('kesimpulanA');
    const kesimpulanB = document.getElementById('kesimpulanB');

    if (feedbackA) feedbackA.innerHTML = '';
    if (feedbackB) feedbackB.innerHTML = '';
    if (kesimpulanA) kesimpulanA.classList.add('d-none');
    if (kesimpulanB) kesimpulanB.classList.add('d-none');

    attemptMM = 0;
}

function resetPenyelidikanSegitiga() {
    const ids = [
        "c_1", "c2_1", "a_1", "b_1", "a2_1", "b2_1", "ab2_1", "sign_1", "nama_1",
        "c_2", "c2_2", "a_2", "b_2", "a2_2", "b2_2", "ab2_2", "sign_2", "nama_2",
        "c_3", "c2_3", "a_3", "b_3", "a2_3", "b2_3", "ab2_3", "sign_3", "nama_3"
    ];

    ids.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.value = '';
            el.disabled = false;
            el.classList.remove('is-valid', 'is-invalid');
            el.style.borderColor = '';
            el.style.borderWidth = '';
        }
    });

    const kesimpulan = document.getElementById('kesimpulan_penyelidikan');
    if (kesimpulan) kesimpulan.classList.add('d-none');

    kesempatanAyoMencoba = 3;
}

function resetContoh1Tripel() {
    idsC1.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.value = '';
            el.disabled = false;
            el.classList.remove('is-valid', 'is-invalid');
        }
    });

    const feedback = document.getElementById('c1_feedback');
    if (feedback) feedback.innerHTML = '';

    attemptC1 = 0;
}

function resetPolaTripel() {
    idsPola.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.value = '';
            el.disabled = false;
            el.classList.remove('is-valid', 'is-invalid');
        }
    });

    attemptPola = 0;
}

function resetTripel1() {
    idsTP1.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.value = '';
            el.disabled = false;
            el.classList.remove('is-valid', 'is-invalid');
        }
    });

    const feedback = document.getElementById('tp1_feedback');
    if (feedback) feedback.innerHTML = '';

    attemptTP1 = 0;
}

function resetTripel2() {
    idsTP2.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.value = '';
            el.disabled = false;
            el.classList.remove('is-valid', 'is-invalid');
        }
    });

    const feedback = document.getElementById('tp2_feedback');
    if (feedback) feedback.innerHTML = '';

    attemptTP2 = 0;
}

function resetLatihanTripel() {
    document.querySelectorAll('.input-soal1, .input-soal2').forEach(input => {
        input.value = '';
        input.disabled = false;
        input.classList.remove('is-valid', 'is-invalid');
    });

    const dropdowns = [
        'inp_compare_c_soal1',
        'inp_sign_soal1',
        'inp_compare_ab_soal1',
        'selectSoal1',
        'inp_compare_c_soal2',
        'inp_sign_soal2',
        'inp_compare_ab_soal2',
        'selectSoal2'
    ];

    dropdowns.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.value = '';
            el.disabled = false;
            el.classList.remove('is-valid', 'is-invalid');
        }
    });

    ['soal3', 'soal4', 'soal5'].forEach(name => {
        document.querySelectorAll(`input[name="${name}"]`).forEach(radio => {
            radio.checked = false;
            radio.disabled = false;
            radio.parentElement.classList.remove('bg-success', 'bg-danger', 'text-white');
        });
    });

    ['soal6', 'soal7', 'soal8'].forEach(name => {
        document.querySelectorAll(`input[name="${name}"]`).forEach(radio => {
            radio.checked = false;
            radio.disabled = false;
        });

        document.querySelectorAll(`input[name="${name}"] + label`).forEach(label => {
            label.className = 'btn btn-outline-success w-100 py-2 fw-bold';
        });
    });

    attemptLat = 0;
}
/* =====================================================
   HALAMAN 1: MARI MENGINGAT
===================================================== */
let sisaKesempatanDasar = 3;

function cekRumusDasar() {
    // Jika kesempatan sudah habis, hentikan fungsi
    if (sisaKesempatanDasar <= 0) {
        Swal.fire({
            icon: 'info',
            title: 'Kesempatan Habis',
            text: 'Kamu sudah mencoba 3 kali. Jawaban yang benar sudah ditampilkan di layar.',
            confirmButtonColor: '#3085d6'
        });
        return;
    }

    let r1 = document.getElementById("rumusDasar_1").value;
    let r2 = document.getElementById("rumusDasar_2").value;
    let r3 = document.getElementById("rumusDasar_3").value;
    let feedback = document.getElementById("feedbackDasar");

    // Validasi jika ada yang kosong
    if (r1 === "" || r2 === "" || r3 === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Belum Lengkap',
            text: 'Isi semua kotak pada rumus terlebih dahulu!',
            confirmButtonColor: '#3085d6'
        });
        return;
    }

    // Karena c adalah sisi miring, maka c² = a² + b² ATAU c² = b² + a²
    if (r1 === "c" && ((r2 === "a" && r3 === "b") || (r2 === "b" && r3 === "a"))) {
        simpanProgressMateri2('m2_cp1_rumus_dasar', 10);

        feedback.innerHTML = "<span class='text-success'>Tepat sekali! rumus Pythagoras yang berlaku pada segitiga di samping adalah c² = a² + b²</span>";

        kunciInputDasar();

        swalLatihanMateri2('button[onclick="cekRumusDasar()"]', {
            icon: 'success',
            title: '+10 Poin!',
            html: 'Rumus Pythagoras yang berlaku adalah: c² = a² + b²<br><small class="text-muted">Hebat, kamu ingat rumus dasarnya!</small>',
            confirmButtonColor: '#28a745'
        }).then(() => {
            selesaikanAktivitasMateri2(
                'button[onclick="cekRumusDasar()"]',
                resetRumusDasar
            );
        });

    } else {
        // Kurangi kesempatan jika salah
        sisaKesempatanDasar--;

        if (sisaKesempatanDasar > 0) {
            swalLatihanMateri2('button[onclick="cekRumusDasar()"]', {
                icon: 'error',
                title: 'Kurang Tepat',
                text: `Ingat, perhatikan kembali sisi-sisi pada segitiga siku-siku dan masukkan sisi yang benar! Sisa kesempatanmu: ${sisaKesempatanDasar} kali.`,
                confirmButtonColor: '#d33'
            });
            feedback.innerHTML = `<span class='text-danger'>Masih kurang tepat, Kesempatan mencoba: ${sisaKesempatanDasar}</span>`;
        } else {
            // Kondisi saat kesempatan mencapai 0
            Swal.fire({
                icon: 'error',
                title: 'Kesempatan Habis!',
                text: 'Kamu sudah mencoba 3 kali. Klik tombol di bawah untuk melihat jawaban yang benar.',
                confirmButtonText: 'Tampilkan Jawaban',
                confirmButtonColor: '#17a2b8',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("rumusDasar_1").value = "c";
                    document.getElementById("rumusDasar_2").value = "a";
                    document.getElementById("rumusDasar_3").value = "b";

                    setValidasiElTripel('rumusDasar_1', true);
                    setValidasiElTripel('rumusDasar_2', true);
                    setValidasiElTripel('rumusDasar_3', true);

                    feedback.innerHTML = "<span class='text-danger'>Kesempatan habis. Jawaban benar: c² = a² + b²</span>";

                    kunciInputDasar();

                    simpanProgressMateri2('m2_cp1_rumus_dasar', 0);

                    selesaikanAktivitasMateri2(
                        'button[onclick="cekRumusDasar()"]',
                        resetRumusDasar
                    );
                }
            });

            kunciInputDasar();
        }
    }
}

function kunciInputDasar() {
    document.getElementById("rumusDasar_1").disabled = true;
    document.getElementById("rumusDasar_2").disabled = true;
    document.getElementById("rumusDasar_3").disabled = true;
}

function resetRumusDasar() {
    ['rumusDasar_1', 'rumusDasar_2', 'rumusDasar_3'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.value = '';
            el.disabled = false;
            el.classList.remove('is-valid', 'is-invalid');
        }
    });

    const feedback = document.getElementById('feedbackDasar');
    if (feedback) {
        feedback.innerHTML = '';
    }

    sisaKesempatanDasar = 3;
}

const idsMM = ['rumusA_1', 'rumusA_2', 'rumusA_3', 'rumusB_1', 'rumusB_2', 'rumusB_3'];

function showAnswerMariMengingat(simpanProgress = true) {
    const answers = {
        'rumusA_1': 'a',
        'rumusA_2': 'b',
        'rumusA_3': 'c',
        'rumusB_1': 'b',
        'rumusB_2': 'a',
        'rumusB_3': 'c'
    };

    for (let id in answers) {
        const el = document.getElementById(id);
        if (el) {
            el.value = answers[id];
            setValidasiElTripel(el, true);
        }
    }

    disableSemua(idsMM);

    const kesimpulanA = document.getElementById('kesimpulanA');
    const kesimpulanB = document.getElementById('kesimpulanB');
    const feedbackA = document.getElementById('feedbackA');
    const feedbackB = document.getElementById('feedbackB');

    if (kesimpulanA) kesimpulanA.classList.remove('d-none');
    if (kesimpulanB) kesimpulanB.classList.remove('d-none');
    if (feedbackA) feedbackA.innerHTML = '';
    if (feedbackB) feedbackB.innerHTML = '';

    if (simpanProgress) {
        simpanProgressMateri2('m2_cp2_mari_mengingat', 0);

        selesaikanAktivitasMateri2(
            'button[onclick="cekMariMengingatTripel()"]',
            resetMariMengingatTripel
        );
    }
}

function cekMariMengingatTripel() {
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

    setValidasiElTripel('rumusA_1', a1 === 'a');
    setValidasiElTripel('rumusA_2', a2 === 'b' || a2 === 'c');
    setValidasiElTripel('rumusA_3', a3 === 'b' || a3 === 'c');
    setValidasiElTripel('rumusB_1', b1 === 'b');
    setValidasiElTripel('rumusB_2', b2 === 'a' || b2 === 'c');
    setValidasiElTripel('rumusB_3', b3 === 'a' || b3 === 'c');

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

    if (isABenar && isBBenar) {
        disableSemua(idsMM);

        simpanProgressMateri2('m2_cp2_mari_mengingat', 15);

        swalLatihanMateri2('button[onclick="cekMariMengingatTripel()"]', {
            icon: 'success',
            title: '+15 Poin!',
            html: 'Kamu berhasil merumuskan Kebalikan Teorema Pythagoras berdasarkan urutan panjang sisi-sisinya!<br><small class="text-muted">Luar biasa, pemahamanmu semakin tajam!</small>',
            confirmButtonColor: '#198754'
        }).then(() => {
            selesaikanAktivitasMateri2(
                'button[onclick="cekMariMengingatTripel()"]',
                resetMariMengingatTripel
            );
        });
    } else {
        attemptMM++;
        if (attemptMM >= MAX_ATTEMPTS) {
            Swal.fire({
                icon: 'info',
                title: 'Kesempatan Habis',
                text: 'Mari kita lihat jawaban yang benar beserta penjelasannya.',
                confirmButtonText: 'Tampilkan Jawaban',
                confirmButtonColor: '#0d6efd',
                allowOutsideClick: false
            }).then(() => showAnswerMariMengingat(true));
        } else {
            swalLatihanMateri2('button[onclick="cekMariMengingatTripel()"]', {
                icon: 'error',
                title: 'Kurang Tepat',
                text: `Jawabanmu masih ada yang keliru. Coba baca petunjuk merah di bawah gambar segitiga. Sisa kesempatan: ${MAX_ATTEMPTS - attemptMM}`,
                confirmButtonColor: '#dc3545'
            });
        }
    }
}

/* =====================================================
   HALAMAN 2: AYO MENCOBA
===================================================== */
let kesempatanAyoMencoba = 3;

const KUNCI_PENYELIDIKAN_TRIPEL = {
    segitiga1: {
        c: 9,
        c2: 81,
        a: 6,
        b: 7,
        a2: 36,
        b2: 49,
        ab2: 85,
        sign: "<",
        nama: "lancip"
    },
    segitiga2: {
        c: 10,
        c2: 100,
        a: 6,
        b: 8,
        a2: 36,
        b2: 64,
        ab2: 100,
        sign: "=",
        nama: "siku"
    },
    segitiga3: {
        c: 13,
        c2: 169,
        a: 8,
        b: 9,
        a2: 64,
        b2: 81,
        ab2: 145,
        sign: ">",
        nama: "tumpul"
    }
};

function cekPenyelidikanSegitiga() {
    const kunci = KUNCI_PENYELIDIKAN_TRIPEL;

    const ids = [
        "c_1", "c2_1", "a_1", "b_1", "a2_1", "b2_1", "ab2_1", "sign_1", "nama_1",
        "c_2", "c2_2", "a_2", "b_2", "a2_2", "b2_2", "ab2_2", "sign_2", "nama_2",
        "c_3", "c2_3", "a_3", "b_3", "a2_3", "b2_3", "ab2_3", "sign_3", "nama_3"
    ];

    let emptyCount = 0;
    ids.forEach(id => {
        let el = document.getElementById(id);
        if (el && el.value.trim() === "") emptyCount++;
    });

    if (emptyCount === ids.length) {
        Swal.fire({ icon: 'warning', title: 'Belum Ada Jawaban!', text: 'Kamu belum mengisi satupun kotak jawaban. Silakan isi terlebih dahulu!', confirmButtonColor: '#ffc107' });
        return;
    } else if (emptyCount > 0) {
        Swal.fire({ icon: 'info', title: 'Belum Lengkap!', text: 'Masih ada kotak yang kosong. Silakan lengkapi semua isian terlebih dahulu.', confirmButtonColor: '#ffc107' });
        return;
    }

    let semuaBenar = true;

    function setMark(id, isCorrect) {
        let el = document.getElementById(id);
        el.style.borderWidth = "2px";
        if (isCorrect) el.style.borderColor = "#198754";
        else { el.style.borderColor = "#dc3545"; semuaBenar = false; }
    }

    function getVal(id) { return document.getElementById(id).value.trim(); }

    // Segitiga 1
    setMark("c_1", parseInt(getVal("c_1")) === kunci.segitiga1.c);
    setMark("c2_1", parseInt(getVal("c2_1")) === kunci.segitiga1.c2);
    let s1_a = parseInt(getVal("a_1")), s1_b = parseInt(getVal("b_1"));
    let s1_ab_valid = (s1_a === 6 && s1_b === 7) || (s1_a === 7 && s1_b === 6);
    setMark("a_1", s1_ab_valid); setMark("b_1", s1_ab_valid);
    let s1_a2 = parseInt(getVal("a2_1")), s1_b2 = parseInt(getVal("b2_1"));
    let s1_a2b2_valid = (s1_a2 === 36 && s1_b2 === 49) || (s1_a2 === 49 && s1_b2 === 36);
    setMark("a2_1", s1_a2b2_valid); setMark("b2_1", s1_a2b2_valid);
    setMark("ab2_1", parseInt(getVal("ab2_1")) === kunci.segitiga1.ab2);
    setMark("sign_1", getVal("sign_1") === kunci.segitiga1.sign);
    setMark("nama_1", getVal("nama_1") === kunci.segitiga1.nama);

    // Segitiga 2
    setMark("c_2", parseInt(getVal("c_2")) === kunci.segitiga2.c);
    setMark("c2_2", parseInt(getVal("c2_2")) === kunci.segitiga2.c2);
    let s2_a = parseInt(getVal("a_2")), s2_b = parseInt(getVal("b_2"));
    let s2_ab_valid = (s2_a === 6 && s2_b === 8) || (s2_a === 8 && s2_b === 6);
    setMark("a_2", s2_ab_valid); setMark("b_2", s2_ab_valid);
    let s2_a2 = parseInt(getVal("a2_2")), s2_b2 = parseInt(getVal("b2_2"));
    let s2_a2b2_valid = (s2_a2 === 36 && s2_b2 === 64) || (s2_a2 === 64 && s2_b2 === 36);
    setMark("a2_2", s2_a2b2_valid); setMark("b2_2", s2_a2b2_valid);
    setMark("ab2_2", parseInt(getVal("ab2_2")) === kunci.segitiga2.ab2);
    setMark("sign_2", getVal("sign_2") === kunci.segitiga2.sign);
    setMark("nama_2", getVal("nama_2") === kunci.segitiga2.nama);

    // Segitiga 3
    setMark("c_3", parseInt(getVal("c_3")) === kunci.segitiga3.c);
    setMark("c2_3", parseInt(getVal("c2_3")) === kunci.segitiga3.c2);
    let s3_a = parseInt(getVal("a_3")), s3_b = parseInt(getVal("b_3"));
    let s3_ab_valid = (s3_a === 8 && s3_b === 9) || (s3_a === 9 && s3_b === 8);
    setMark("a_3", s3_ab_valid); setMark("b_3", s3_ab_valid);
    let s3_a2 = parseInt(getVal("a2_3")), s3_b2 = parseInt(getVal("b2_3"));
    let s3_a2b2_valid = (s3_a2 === 64 && s3_b2 === 81) || (s3_a2 === 81 && s3_b2 === 64);
    setMark("a2_3", s3_a2b2_valid); setMark("b2_3", s3_a2b2_valid);
    setMark("ab2_3", parseInt(getVal("ab2_3")) === kunci.segitiga3.ab2);
    setMark("sign_3", getVal("sign_3") === kunci.segitiga3.sign);
    setMark("nama_3", getVal("nama_3") === kunci.segitiga3.nama);

    if (semuaBenar) {
        simpanProgressMateri2('m2_cp3_ayo_mencoba', 20);

        document.getElementById('kesimpulan_penyelidikan').classList.remove('d-none');

        swalLatihanMateri2('button[onclick="cekPenyelidikanSegitiga()"]', {
            icon: 'success',
            title: '+20 Poin!',
            html: 'Semua jawaban dan hasil penyelidikanmu sudah tepat.<br><small class="text-muted">Kamu hebat dalam menganalisis!</small>',
            confirmButtonColor: '#198754'
        }).then(() => {
            selesaikanAktivitasMateri2(
                'button[onclick="cekPenyelidikanSegitiga()"]',
                resetPenyelidikanSegitiga
            );
        });
    } else {
        kesempatanAyoMencoba--;
        if (kesempatanAyoMencoba > 0) {
            swalLatihanMateri2('button[onclick="cekPenyelidikanSegitiga()"]', {
                icon: 'error',
                title: 'Masih Ada yang Salah',
                html: `Periksa kembali jawabanmu. Kotak dengan garis tepi warna <b>merah</b> adalah jawaban yang belum tepat.<br><br><b>Sisa kesempatan: ${kesempatanAyoMencoba} kali</b>`,
                confirmButtonColor: '#dc3545'
            });
        } else {
            Swal.fire({
                icon: 'warning', title: 'Kesempatan Habis!', text: 'Kamu sudah mencoba 3 kali namun masih ada jawaban yang belum tepat. Ingin melihat kunci jawabannya?',
                showCancelButton: true, confirmButtonText: 'Tampilkan Jawaban', cancelButtonText: 'Tutup', confirmButtonColor: '#198754', cancelButtonColor: '#6c757d', allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) tampilkanJawabanPenyelidikan(kunci, true, true);
            });
        }
    }
}


function tampilkanJawabanPenyelidikan(
    kunci = KUNCI_PENYELIDIKAN_TRIPEL,
    simpanProgress = true,
    tampilkanPopup = true
) {
    function setAns(id, val) {
        const el = document.getElementById(id);
        if (!el) return;

        el.value = val;
        el.style.borderColor = "#198754";
        el.style.borderWidth = "2px";
        el.disabled = true;
    }

    setAns("c_1", kunci.segitiga1.c);
    setAns("c2_1", kunci.segitiga1.c2);
    setAns("a_1", kunci.segitiga1.a);
    setAns("b_1", kunci.segitiga1.b);
    setAns("a2_1", kunci.segitiga1.a2);
    setAns("b2_1", kunci.segitiga1.b2);
    setAns("ab2_1", kunci.segitiga1.ab2);
    setAns("sign_1", kunci.segitiga1.sign);
    setAns("nama_1", kunci.segitiga1.nama);

    setAns("c_2", kunci.segitiga2.c);
    setAns("c2_2", kunci.segitiga2.c2);
    setAns("a_2", kunci.segitiga2.a);
    setAns("b_2", kunci.segitiga2.b);
    setAns("a2_2", kunci.segitiga2.a2);
    setAns("b2_2", kunci.segitiga2.b2);
    setAns("ab2_2", kunci.segitiga2.ab2);
    setAns("sign_2", kunci.segitiga2.sign);
    setAns("nama_2", kunci.segitiga2.nama);

    setAns("c_3", kunci.segitiga3.c);
    setAns("c2_3", kunci.segitiga3.c2);
    setAns("a_3", kunci.segitiga3.a);
    setAns("b_3", kunci.segitiga3.b);
    setAns("a2_3", kunci.segitiga3.a2);
    setAns("b2_3", kunci.segitiga3.b2);
    setAns("ab2_3", kunci.segitiga3.ab2);
    setAns("sign_3", kunci.segitiga3.sign);
    setAns("nama_3", kunci.segitiga3.nama);

    const kesimpulan = document.getElementById('kesimpulan_penyelidikan');
    if (kesimpulan) {
        kesimpulan.classList.remove('d-none');
    }

    if (simpanProgress) {
        simpanProgressMateri2('m2_cp3_ayo_mencoba', 0);
    }

    const setelahPopup = () => {
        if (simpanProgress) {
            selesaikanAktivitasMateri2(
                'button[onclick="cekPenyelidikanSegitiga()"]',
                resetPenyelidikanSegitiga
            );
        }
    };

    if (tampilkanPopup) {
        Swal.fire({
            icon: 'info',
            title: 'Kunci Jawaban Ditampilkan',
            text: 'Ini adalah langkah-langkah dan jawaban yang tepat untuk penyelidikan segitiga tersebut.',
            confirmButtonColor: '#3085d6'
        }).then(setelahPopup);
    } else {
        setelahPopup();
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

function showAnswerContoh1(simpanProgress = true) {
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
        const el = document.getElementById(id);
        if (el) {
            el.value = ans[id];
            setValidasiElTripel(id, true);
        }
    }

    disableSemua(idsC1);

    const feedback = document.getElementById('c1_feedback');
    if (feedback) {
        feedback.innerHTML = '<span class="text-primary">Ini adalah penyelesaian yang benar.</span>';
    }

    if (simpanProgress) {
        simpanProgressMateri2('m2_cp4_jenis_segitiga_1', 0);

        selesaikanAktivitasMateri2(
            'button[onclick="cekContoh1Tripel()"]',
            resetContoh1Tripel
        );
    }
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

    check('c1_dik_a', '17'); check('c1_dik_b', '25'); check('c1_dik_c', '38');
    check('c1_sisi_c', '38'); check('c1_c2_awal', '38'); check('c1_c2_hasil', '1444');

    const a2a = document.getElementById('c1_a2_awal').value;
    const b2a = document.getElementById('c1_b2_awal').value;
    const a2aCor = (a2a === '17' && b2a === '25') || (a2a === '25' && b2a === '17');
    setValidasiElTripel('c1_a2_awal', a2aCor); setValidasiElTripel('c1_b2_awal', a2aCor);
    if (!a2aCor) benar = false;

    const a2h = document.getElementById('c1_a2_hasil').value;
    const b2h = document.getElementById('c1_b2_hasil').value;
    const a2hCor = (a2h === '289' && b2h === '625') || (a2h === '625' && b2h === '289');
    setValidasiElTripel('c1_a2_hasil', a2hCor); setValidasiElTripel('c1_b2_hasil', a2hCor);
    if (!a2hCor) benar = false;

    check('c1_ab_total', '914'); check('c1_banding', '>'); check('c1_kesimpulan', 'tumpul');

    if (benar) {
        disableSemua(idsC1);

        simpanProgressMateri2('m2_cp4_jenis_segitiga_1', 15);

        swalLatihanMateri2('button[onclick="cekContoh1Tripel()"]', {
            icon: 'success',
            title: '+15 Poin!',
            html: 'Langkah penyelesaian Contoh 1 benar.<br><small class="text-muted">Bagus, kamu sangat jeli dalam menentukan jenis segitiga tumpul!</small>',
            confirmButtonColor: '#198754'
        }).then(() => {
            selesaikanAktivitasMateri2(
                'button[onclick="cekContoh1Tripel()"]',
                resetContoh1Tripel
            );
        });
    } else {
        attemptC1++;
        if (attemptC1 >= MAX_ATTEMPTS) {
            Swal.fire({ icon: 'info', title: 'Kesempatan Habis', text: 'Mari kita lihat jawaban yang benar.', confirmButtonText: 'Tampilkan Jawaban', confirmButtonColor: '#0d6efd', allowOutsideClick: false }).then(() => showAnswerContoh1(true));
        } else {
            swalLatihanMateri2('button[onclick="cekContoh1Tripel()"]', {
                icon: 'error',
                title: 'Kurang Tepat',
                text: `Jawaban anda masih ada yang kurang tepat. Sisa kesempatan: ${MAX_ATTEMPTS - attemptC1}`,
                confirmButtonColor: '#dc3545'
            });
        }
    }
}

/* =====================================================
   AKTIVITAS BARU: POLA TRIPEL PYTHAGORAS
===================================================== */
let attemptPola = 0;
const idsPola = [
    'pola2_h1', 'pola2_h2', 'pola2_h3', 'pola2_c', 'pola2_a', 'pola2_b', 'pola2_c2', 'pola2_a2', 'pola2_b2', 'pola2_tot_kiri', 'pola2_tot_kanan',
    'pola3_h1', 'pola3_h2', 'pola3_h3', 'pola3_c', 'pola3_a', 'pola3_b', 'pola3_c2', 'pola3_a2', 'pola3_b2', 'pola3_tot_kiri', 'pola3_tot_kanan'
];

function showAnswerPolaTripel(simpanProgress = true) {
    const ansPola = {
        'pola2_h1': 6,
        'pola2_h2': 8,
        'pola2_h3': 10,
        'pola2_c': 10,
        'pola2_a': 6,
        'pola2_b': 8,
        'pola2_c2': 100,
        'pola2_a2': 36,
        'pola2_b2': 64,
        'pola2_tot_kiri': 100,
        'pola2_tot_kanan': 100,

        'pola3_h1': 9,
        'pola3_h2': 12,
        'pola3_h3': 15,
        'pola3_c': 15,
        'pola3_a': 9,
        'pola3_b': 12,
        'pola3_c2': 225,
        'pola3_a2': 81,
        'pola3_b2': 144,
        'pola3_tot_kiri': 225,
        'pola3_tot_kanan': 225
    };

    for (let id in ansPola) {
        const el = document.getElementById(id);
        if (el) {
            el.value = ansPola[id];
            setValidasiElTripel(id, true);
        }
    }

    disableSemua(idsPola);

    if (simpanProgress) {
        simpanProgressMateri2('m2_cp5_pola_tripel', 0);

        selesaikanAktivitasMateri2(
            'button[onclick="cekPolaTripel()"]',
            resetPolaTripel
        );
    }
}

function cekPolaTripel() {
    if (cekKosong(idsPola)) {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Isi semua tabel dan kolom pembuktian terlebih dahulu!', confirmButtonColor: '#ffc107' });
        return;
    }

    let benar = true;
    const check = (id, val) => {
        const el = document.getElementById(id);
        const isCor = parseInt(el.value) === val;
        setValidasiElTripel(id, isCor);
        if (!isCor) benar = false;
    };

    check('pola2_h1', 6); check('pola2_h2', 8); check('pola2_h3', 10);
    check('pola2_c', 10);
    const p2_a = parseInt(document.getElementById('pola2_a').value);
    const p2_b = parseInt(document.getElementById('pola2_b').value);
    const p2_abCor = (p2_a === 6 && p2_b === 8) || (p2_a === 8 && p2_b === 6);
    setValidasiElTripel('pola2_a', p2_abCor); setValidasiElTripel('pola2_b', p2_abCor);
    if (!p2_abCor) benar = false;
    check('pola2_c2', 100);
    const p2_a2 = parseInt(document.getElementById('pola2_a2').value);
    const p2_b2 = parseInt(document.getElementById('pola2_b2').value);
    const p2_a2b2Cor = (p2_a2 === 36 && p2_b2 === 64) || (p2_a2 === 64 && p2_b2 === 36);
    setValidasiElTripel('pola2_a2', p2_a2b2Cor); setValidasiElTripel('pola2_b2', p2_a2b2Cor);
    if (!p2_a2b2Cor) benar = false;
    check('pola2_tot_kiri', 100); check('pola2_tot_kanan', 100);

    check('pola3_h1', 9); check('pola3_h2', 12); check('pola3_h3', 15);
    check('pola3_c', 15);
    const p3_a = parseInt(document.getElementById('pola3_a').value);
    const p3_b = parseInt(document.getElementById('pola3_b').value);
    const p3_abCor = (p3_a === 9 && p3_b === 12) || (p3_a === 12 && p3_b === 9);
    setValidasiElTripel('pola3_a', p3_abCor); setValidasiElTripel('pola3_b', p3_abCor);
    if (!p3_abCor) benar = false;
    check('pola3_c2', 225);
    const p3_a2 = parseInt(document.getElementById('pola3_a2').value);
    const p3_b2 = parseInt(document.getElementById('pola3_b2').value);
    const p3_a2b2Cor = (p3_a2 === 81 && p3_b2 === 144) || (p3_a2 === 144 && p3_b2 === 81);
    setValidasiElTripel('pola3_a2', p3_a2b2Cor); setValidasiElTripel('pola3_b2', p3_a2b2Cor);
    if (!p3_a2b2Cor) benar = false;
    check('pola3_tot_kiri', 225); check('pola3_tot_kanan', 225);

    if (benar) {
        simpanProgressMateri2('m2_cp5_pola_tripel', 15);

        swalLatihanMateri2('button[onclick="cekPolaTripel()"]', {
            icon: 'success',
            title: '+15 Poin!',
            html: 'Kamu berhasil membuktikan bahwa kelipatan dari Tripel Pythagoras juga merupakan Tripel Pythagoras!<br><small class="text-muted">Pola matematika yang indah!</small>',
            confirmButtonColor: '#198754'
        }).then(() => {
            selesaikanAktivitasMateri2(
                'button[onclick="cekPolaTripel()"]',
                resetPolaTripel
            );
        });
    } else {
        attemptPola++;
        let maxAtt = MAX_ATTEMPTS;
        if (attemptPola >= maxAtt) {
            Swal.fire({ icon: 'info', title: 'Kesempatan Habis', text: 'Mari kita lihat jawaban yang benar.', confirmButtonText: 'Tampilkan Jawaban', confirmButtonColor: '#0d6efd', allowOutsideClick: false }).then(() => {
                showAnswerPolaTripel(true);
            });
        } else {
            swalLatihanMateri2('button[onclick="cekPolaTripel()"]', {
                icon: 'error',
                title: 'Kurang Tepat',
                text: `Masih ada kotak yang berwarna merah. Coba hitung lagi dengan teliti! Sisa kesempatan: ${maxAtt - attemptPola}`,
                confirmButtonColor: '#dc3545'
            });
        }
    }
}

const idsTP1 = [
    'tp1_sisi_c', 'tp1_step1_c', 'tp1_step1_b', 'tp1_step1_a',
    'tp1_step2_c2', 'tp1_step2_b2', 'tp1_step2_a2',
    'tp1_step3_c2_tot', 'tp1_sign', 'tp1_step3_ab_tot',
    'tp1_kesimpulan'
];

function showAnswerTripel1(simpanProgress = true) {
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
        const el = document.getElementById(id);
        if (el) {
            el.value = ans[id];
            setValidasiElTripel(id, true);
        }
    }

    disableSemua(idsTP1);

    const feedback = document.getElementById('tp1_feedback');
    if (feedback) {
        feedback.innerHTML = '<span class="text-primary">Ini adalah penyelesaian yang benar.</span>';
    }

    if (simpanProgress) {
        simpanProgressMateri2('m2_cp6_contoh_tripel_1', 0);

        selesaikanAktivitasMateri2(
            'button[onclick="cekTripel1()"]',
            resetTripel1
        );
    }
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

    check('tp1_sisi_c', '17'); check('tp1_step1_c', '17');
    const a1 = document.getElementById('tp1_step1_a').value;
    const b1 = document.getElementById('tp1_step1_b').value;
    const s1Cor = (a1 === '8' && b1 === '16') || (a1 === '16' && b1 === '8');
    setValidasiElTripel('tp1_step1_a', s1Cor); setValidasiElTripel('tp1_step1_b', s1Cor);
    if (!s1Cor) benar = false;
    check('tp1_step2_c2', '289');
    const a2 = document.getElementById('tp1_step2_a2').value;
    const b2 = document.getElementById('tp1_step2_b2').value;
    const s2Cor = (a2 === '64' && b2 === '256') || (a2 === '256' && b2 === '64');
    setValidasiElTripel('tp1_step2_a2', s2Cor); setValidasiElTripel('tp1_step2_b2', s2Cor);
    if (!s2Cor) benar = false;
    check('tp1_step3_c2_tot', '289'); check('tp1_sign', '!='); check('tp1_step3_ab_tot', '320');
    check('tp1_kesimpulan', 'tidak');

    if (benar) {
        disableSemua(idsTP1);

        simpanProgressMateri2('m2_cp6_contoh_tripel_1', 15);

        swalLatihanMateri2('button[onclick="cekTripel1()"]', {
            icon: 'success',
            title: '+15 Poin!',
            html: 'BUKAN Tripel Pythagoras.<br><small class="text-muted">Kamu berhasil membedakan mana yang tripel!</small>',
            confirmButtonColor: '#198754'
        }).then(() => {
            selesaikanAktivitasMateri2(
                'button[onclick="cekTripel1()"]',
                resetTripel1
            );
        });
    } else {
        attemptTP1++;
        if (attemptTP1 >= MAX_ATTEMPTS) {
            Swal.fire({ icon: 'info', title: 'Kesempatan Habis', text: 'Mari kita lihat jawaban yang benar.', confirmButtonText: 'Tampilkan Jawaban', confirmButtonColor: '#0d6efd', allowOutsideClick: false }).then(() => showAnswerTripel1(true));
        } else {
            swalLatihanMateri2('button[onclick="cekTripel1()"]', {
                icon: 'error',
                title: 'Kurang Tepat',
                text: `Jawaban anda masih ada yang kurang tepat. Sisa kesempatan: ${MAX_ATTEMPTS - attemptTP1}`,
                confirmButtonColor: '#dc3545'
            });
        }
    }
}

// Array ID untuk Contoh 2 (Tripel 10,24,26)
const idsTP2 = [
    'tp2_sisi_c', 'tp2_step1_c', 'tp2_step1_b', 'tp2_step1_a',
    'tp2_step2_c2', 'tp2_step2_b2', 'tp2_step2_a2',
    'tp2_step3_c2_tot', 'tp2_sign', 'tp2_step3_ab_tot',
    'tp2_kesimpulan'
];

// Tampilkan jawaban benar untuk Contoh 2
function showAnswerTripel2(simpanProgress = true) {
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
        const el = document.getElementById(id);
        if (el) {
            el.value = ans[id];
            setValidasiElTripel(id, true);
        }
    }

    disableSemua(idsTP2);

    const feedback = document.getElementById('tp2_feedback');
    if (feedback) {
        feedback.innerHTML = '<span class="text-primary">Ini adalah penyelesaian yang benar.</span>';
    }

    if (simpanProgress) {
        simpanProgressMateri2('m2_cp7_contoh_tripel_2', 0);

        selesaikanAktivitasMateri2(
            'button[onclick="cekTripel2()"]',
            resetTripel2
        );
    }
}

// Cek jawaban Contoh 2
function cekTripel2() {
    if (cekKosong(idsTP2)) {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Lengkapi bagian yang masih kosong.', confirmButtonColor: '#ffc107' });
        return;
    }

    let benar = true;
    const check = (id, val) => {
        const el = document.getElementById(id);
        if (!el) return;
        const isCor = el.value === val;
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

        simpanProgressMateri2('m2_cp7_contoh_tripel_2', 15);

        swalLatihanMateri2('button[onclick="cekTripel2()"]', {
            icon: 'success',
            title: '+15 Poin!',
            html: 'TERMASUK Tripel Pythagoras.<br><small class="text-muted">Kamu berhasil membuktikan!</small>',
            confirmButtonColor: '#198754'
        }).then(() => {
            selesaikanAktivitasMateri2(
                'button[onclick="cekTripel2()"]',
                resetTripel2
            );
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
            }).then(() => showAnswerTripel2(true));
        } else {
            swalLatihanMateri2('button[onclick="cekTripel2()"]', {
                icon: 'error',
                title: 'Kurang Tepat',
                text: `Jawaban anda masih ada yang kurang tepat. Sisa kesempatan: ${MAX_ATTEMPTS - attemptTP2}`,
                confirmButtonColor: '#dc3545'
            });
        }
    }
}

function showAnswerLatihan(simpanProgress = true) {
    const ans1 = [15, 15, 225, 9, 12, 81, 144, 225];
    const inputsSoal1 = document.querySelectorAll('.input-soal1');

    inputsSoal1.forEach((inp, i) => {
        inp.value = ans1[i];
        setValidasiElTripel(inp, true);
        inp.disabled = true;
    });

    ['inp_compare_c_soal1', 'inp_sign_soal1', 'inp_compare_ab_soal1', 'selectSoal1'].forEach((id, i) => {
        const el = document.getElementById(id);
        if (el) {
            el.value = ['225', '=', '225', 'Siku-siku'][i];
            setValidasiElTripel(el, true);
            el.disabled = true;
        }
    });

    const ans2 = [12, 12, 144, 6, 8, 36, 64, 100];
    const inputsSoal2 = document.querySelectorAll('.input-soal2');

    inputsSoal2.forEach((inp, i) => {
        inp.value = ans2[i];
        setValidasiElTripel(inp, true);
        inp.disabled = true;
    });

    ['inp_compare_c_soal2', 'inp_sign_soal2', 'inp_compare_ab_soal2', 'selectSoal2'].forEach((id, i) => {
        const el = document.getElementById(id);
        if (el) {
            el.value = ['144', '>', '100', 'Tumpul'][i];
            setValidasiElTripel(el, true);
            el.disabled = true;
        }
    });

    const keysYT = {
        'soal3': 'ya',
        'soal4': 'tidak',
        'soal5': 'ya'
    };

    for (let name in keysYT) {
        const inputBenar = document.querySelector(`input[name="${name}"][value="${keysYT[name]}"]`);
        if (inputBenar) {
            inputBenar.checked = true;
        }

        document.querySelectorAll(`input[name="${name}"]`).forEach(radio => {
            radio.disabled = true;
            radio.parentElement.classList.remove('bg-danger', 'text-white');
        });

        const checked = document.querySelector(`input[name="${name}"]:checked`);
        if (checked) {
            checked.parentElement.classList.add('bg-success', 'text-white');
        }
    }

    const keysPG = {
        'soal6': 'A',
        'soal7': 'B',
        'soal8': 'C'
    };

    for (let name in keysPG) {
        const inputBenar = document.querySelector(`input[name="${name}"][value="${keysPG[name]}"]`);
        if (inputBenar) {
            inputBenar.checked = true;
        }

        document.querySelectorAll(`input[name="${name}"]`).forEach(radio => {
            radio.disabled = true;
        });

        document.querySelectorAll(`input[name="${name}"] + label`).forEach(label => {
            label.className = 'btn btn-outline-success w-100 py-2 fw-bold';
        });

        const checked = document.querySelector(`input[name="${name}"]:checked`);
        if (checked) {
            const label = document.querySelector(`label[for="${checked.id}"]`);
            if (label) {
                label.className = 'btn btn-success w-100 py-2 fw-bold text-white';
            }
        }
    }

    if (simpanProgress) {
        simpanProgressMateri2('m2_cp8_ayo_berlatih', 0);

        selesaikanAktivitasMateri2(
            'button[onclick="cekLatihanTripel()"]',
            resetLatihanTripel
        );
    }
}

function cekLatihanTripel() {
    let isKosong = false;
    document.querySelectorAll('.input-soal1, .input-soal2').forEach(inp => { if (inp.value.trim() === "") isKosong = true; });
    const comps = ['inp_compare_c_soal1', 'inp_sign_soal1', 'inp_compare_ab_soal1', 'selectSoal1', 'inp_compare_c_soal2', 'inp_sign_soal2', 'inp_compare_ab_soal2', 'selectSoal2'];
    comps.forEach(id => { if (document.getElementById(id).value === "") isKosong = true; });
    ['soal3', 'soal4', 'soal5', 'soal6', 'soal7', 'soal8'].forEach(name => { if (!document.querySelector(`input[name="${name}"]:checked`)) isKosong = true; });

    if (isKosong) {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap!', text: 'Pastikan semua kotak isian dan pilihan sudah terjawab.', confirmButtonColor: '#ffc107' });
        return;
    }

    let benar = true;
    const chk = (el, cond) => {
        if (typeof el === 'string') el = document.getElementById(el);
        setValidasiElTripel(el, cond);
        if (!cond) benar = false;
    };

    // Validasi Soal 1
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

    // Validasi Soal 2
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

    // Validasi Soal 3,4,5
    const keysYT = { 'soal3': 'ya', 'soal4': 'tidak', 'soal5': 'ya' };
    for (let name in keysYT) {
        const pil = document.querySelector(`input[name="${name}"]:checked`);
        document.querySelectorAll(`input[name="${name}"]`).forEach(r => r.parentElement.classList.remove('bg-success', 'bg-danger', 'text-white'));
        if (pil.value === keysYT[name]) pil.parentElement.classList.add('bg-success', 'text-white');
        else { pil.parentElement.classList.add('bg-danger', 'text-white'); benar = false; }
    }

    // Validasi Soal 6,7,8
    const keysPG = { 'soal6': 'A', 'soal7': 'B', 'soal8': 'C' };
    for (let name in keysPG) {
        const pil = document.querySelector(`input[name="${name}"]:checked`);
        document.querySelectorAll(`input[name="${name}"] + label`).forEach(lbl => { lbl.className = 'btn btn-outline-success w-100 py-2 fw-bold'; });
        const lblTerpilih = document.querySelector(`label[for="${pil.id}"]`);
        if (pil.value !== keysPG[name]) { lblTerpilih.className = 'btn btn-danger w-100 py-2 fw-bold text-white'; benar = false; }
    }

    if (benar) {
        simpanProgressMateri2('m2_cp8_ayo_berlatih', 25);

        swalLatihanMateri2('button[onclick="cekLatihanTripel()"]', {
            icon: 'success',
            title: '+25 Poin!',
            html: 'Selamat! Semua jawaban latihanmu benar.<br><small class="text-muted">Kamu telah menguasai Tripel Pythagoras!</small>',
            confirmButtonColor: '#198754'
        }).then(() => {
            selesaikanAktivitasMateri2(
                'button[onclick="cekLatihanTripel()"]',
                resetLatihanTripel
            );
        });
    } else {
        attemptLat++;
        let curAtt = attemptLat;
        let maxAtt = MAX_ATTEMPTS;
        if (curAtt >= maxAtt) {
            Swal.fire({ icon: 'info', title: 'Kesempatan Habis', text: 'Mari pelajari jawaban yang benar.', confirmButtonText: 'Tampilkan Jawaban', confirmButtonColor: '#0d6efd', allowOutsideClick: false }).then(() => showAnswerLatihan(true));
        } else {
            swalLatihanMateri2('button[onclick="cekLatihanTripel()"]', {
                icon: 'error',
                title: 'Belum Tepat',
                text: `Masih ada jawaban merah/salah. Periksa kembali! Sisa kesempatan: ${maxAtt - curAtt}`,
                confirmButtonColor: '#dc3545'
            });
        }
    }
}
/* =====================================================
   HALAMAN 5: REFLEKSI AKHIR (TRIPEL PYTHAGORAS)
===================================================== */
async function cekRefleksiTripel() {
    const isPilihanTerisi = document.querySelector('input[name="ref_tri_1"]:checked');
    const refTri1Text = document.getElementById('ref_tri_1_text').value.trim();
    const refTri2Text = document.getElementById('ref_tri_2_text').value.trim();

    // 1. Validasi
    if (!isPilihanTerisi) {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Pilih salah satu opsi pada pertanyaan nomor 1.', confirmButtonColor: '#ffc107' });
        return;
    }
    if (refTri1Text === '') {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Tolong ceritakan sedikit alasanmu di nomor 1 ya.', confirmButtonColor: '#ffc107' });
        return;
    }
    if (refTri2Text === '') {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Tolong tuliskan syarat Tripel Pythagoras di nomor 2.', confirmButtonColor: '#ffc107' });
        return;
    }

    // 2. Siapkan data JSON (Perhatikan nama field-nya kita sesuaikan dengan Materi 2)
    const dataRefleksi = {
        kode_materi: 'materi_2_tripel_pythagoras',
        kesulitan: isPilihanTerisi.value,
        cerita_kesulitan: refTri1Text,
        pemahaman_syarat: refTri2Text
    };

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Animasi tombol loading
        const btnSubmit = document.querySelector('button[onclick="cekRefleksiTripel()"]');
        const originalText = btnSubmit.innerText;
        btnSubmit.innerText = "Menyimpan...";
        btnSubmit.disabled = true;

        // 3. Kirim via Fetch
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

        // 4. Jika sukses
        if (response.ok) {
            simpanProgressMateri2('m2_cp9_refleksi', 10);

            kunciFormRefleksiTripel();

            Swal.fire({
                icon: 'success',
                title: '+10 Poin!',
                html: 'Refleksimu sudah tersimpan. Kamu Hebat!',
                confirmButtonColor: '#198754'
            });
        } else {
            Swal.fire({ icon: 'error', title: 'Gagal', text: result.message || 'Terjadi kesalahan sistem.', confirmButtonColor: '#dc3545' });
            btnSubmit.innerText = originalText;
            btnSubmit.disabled = false;
        }

    } catch (error) {
        console.error('Error:', error);
        Swal.fire({ icon: 'error', title: 'Koneksi Terputus', text: 'Gagal terhubung ke server. Coba lagi.', confirmButtonColor: '#dc3545' });
        const btnSubmit = document.querySelector('button[onclick="cekRefleksiTripel()"]');
        if (btnSubmit) {
            btnSubmit.innerText = "Simpan Refleksi";
            btnSubmit.disabled = false;
        }
    }
}

// Helper untuk mengunci form
function kunciFormRefleksiTripel() {
    ['ref_tri_1_ya', 'ref_tri_1_tidak', 'ref_tri_1_text', 'ref_tri_2_text'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.disabled = true;
            el.classList.add('is-valid');
        }
    });

    const btn = document.querySelector('button[onclick="cekRefleksiTripel()"]');
    if (btn) {
        btn.disabled = true;
        btn.innerText = "Refleksi Tersimpan";
    }
}

/* =====================================================
   AKTIFASI MODE REVIEW UNTUK MATERI 2 (FULL)
===================================================== */
document.addEventListener('DOMContentLoaded', function () {
    if (typeof window.setupReviewMode === 'function') {

        // 1. Rumus Dasar
        window.setupReviewMode(
            'm2_cp1_rumus_dasar',
            'button[onclick="cekRumusDasar()"]',
            function () {
                const ans = {
                    'rumusDasar_1': 'c',
                    'rumusDasar_2': 'a',
                    'rumusDasar_3': 'b'
                };

                for (let id in ans) {
                    const el = document.getElementById(id);
                    if (el) {
                        el.value = ans[id];
                        el.classList.add('is-valid');
                        el.disabled = true;
                    }
                }

                const feedback = document.getElementById('feedbackDasar');
                if (feedback) {
                    feedback.innerHTML = "<span class='text-success fw-bold'>Tepat sekali! rumus Pythagoras yang berlaku pada segitiga di samping adalah c² = a² + b²</span>";
                }
            },
            resetRumusDasar
        );

        // 2. Mari Mengingat
        window.setupReviewMode(
            'm2_cp2_mari_mengingat',
            'button[onclick="cekMariMengingatTripel()"]',
            function () {
                if (typeof showAnswerMariMengingat === 'function') {
                    showAnswerMariMengingat(false);
                }
            },
            function () {
                ['rumusA_1', 'rumusA_2', 'rumusA_3', 'rumusB_1', 'rumusB_2', 'rumusB_3'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.value = '';
                        el.classList.remove('is-valid', 'is-invalid');
                        el.disabled = false;
                    }
                });

                const kesimpulanA = document.getElementById('kesimpulanA');
                const kesimpulanB = document.getElementById('kesimpulanB');
                const feedbackA = document.getElementById('feedbackA');
                const feedbackB = document.getElementById('feedbackB');

                if (kesimpulanA) kesimpulanA.classList.add('d-none');
                if (kesimpulanB) kesimpulanB.classList.add('d-none');
                if (feedbackA) feedbackA.innerHTML = '';
                if (feedbackB) feedbackB.innerHTML = '';
            }
        );

        // 3. Ayo Mencoba
        window.setupReviewMode(
            'm2_cp3_ayo_mencoba',
            'button[onclick="cekPenyelidikanSegitiga()"]',
            function () {
                if (typeof tampilkanJawabanPenyelidikan === 'function') {
                    tampilkanJawabanPenyelidikan(KUNCI_PENYELIDIKAN_TRIPEL, false, false);
                }
            },
            function () {
                const ids = [
                    "c_1", "c2_1", "a_1", "b_1", "a2_1", "b2_1", "ab2_1", "sign_1", "nama_1",
                    "c_2", "c2_2", "a_2", "b_2", "a2_2", "b2_2", "ab2_2", "sign_2", "nama_2",
                    "c_3", "c2_3", "a_3", "b_3", "a2_3", "b2_3", "ab2_3", "sign_3", "nama_3"
                ];

                ids.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.value = '';
                        el.disabled = false;
                        el.style.borderColor = '';
                        el.style.borderWidth = '';
                        el.classList.remove('is-valid', 'is-invalid');
                    }
                });

                const kesimpulan = document.getElementById('kesimpulan_penyelidikan');
                if (kesimpulan) {
                    kesimpulan.classList.add('d-none');
                }
            }
        );

        // 4. Contoh 1 Jenis Segitiga
        window.setupReviewMode(
            'm2_cp4_jenis_segitiga_1',
            'button[onclick="cekContoh1Tripel()"]',
            function () {
                if (typeof showAnswerContoh1 === 'function') {
                    showAnswerContoh1(false);
                }
            },
            function () {
                idsC1.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.value = '';
                        el.classList.remove('is-valid', 'is-invalid');
                        el.disabled = false;
                    }
                });

                const feedback = document.getElementById('c1_feedback');
                if (feedback) {
                    feedback.innerHTML = '';
                }
            }
        );

        // 5. Pola Tripel Pythagoras
        window.setupReviewMode(
            'm2_cp5_pola_tripel',
            'button[onclick="cekPolaTripel()"]',
            function () {
                if (typeof showAnswerPolaTripel === 'function') {
                    showAnswerPolaTripel(false);
                }
            },
            function () {
                idsPola.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.value = '';
                        el.classList.remove('is-valid', 'is-invalid');
                        el.disabled = false;
                    }
                });
            }
        );

        // 6. Contoh Tripel 1
        window.setupReviewMode(
            'm2_cp6_contoh_tripel_1',
            'button[onclick="cekTripel1()"]',
            function () {
                if (typeof showAnswerTripel1 === 'function') {
                    showAnswerTripel1(false);
                }
            },
            function () {
                idsTP1.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.value = '';
                        el.classList.remove('is-valid', 'is-invalid');
                        el.disabled = false;
                    }
                });

                const feedback = document.getElementById('tp1_feedback');
                if (feedback) {
                    feedback.innerHTML = '';
                }
            }
        );

        // 7. Contoh Tripel 2
        window.setupReviewMode(
            'm2_cp7_contoh_tripel_2',
            'button[onclick="cekTripel2()"]',
            function () {
                if (typeof showAnswerTripel2 === 'function') {
                    showAnswerTripel2(false);
                }
            },
            function () {
                idsTP2.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.value = '';
                        el.classList.remove('is-valid', 'is-invalid');
                        el.disabled = false;
                    }
                });

                const feedback = document.getElementById('tp2_feedback');
                if (feedback) {
                    feedback.innerHTML = '';
                }
            }
        );

        // 8. Ayo Berlatih
        window.setupReviewMode(
            'm2_cp8_ayo_berlatih',
            'button[onclick="cekLatihanTripel()"]',
            function () {
                if (typeof showAnswerLatihan === 'function') {
                    showAnswerLatihan(false);
                }
            },
            function () {
                document.querySelectorAll('.input-soal1, .input-soal2').forEach(input => {
                    input.value = '';
                    input.disabled = false;
                    input.classList.remove('is-valid', 'is-invalid');
                });

                const dropdowns = [
                    'inp_compare_c_soal1',
                    'inp_sign_soal1',
                    'inp_compare_ab_soal1',
                    'selectSoal1',
                    'inp_compare_c_soal2',
                    'inp_sign_soal2',
                    'inp_compare_ab_soal2',
                    'selectSoal2'
                ];

                dropdowns.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.value = '';
                        el.disabled = false;
                        el.classList.remove('is-valid', 'is-invalid');
                    }
                });

                ['soal3', 'soal4', 'soal5'].forEach(name => {
                    document.querySelectorAll(`input[name="${name}"]`).forEach(radio => {
                        radio.disabled = false;
                        radio.checked = false;
                        radio.parentElement.classList.remove('bg-success', 'bg-danger', 'text-white');
                    });
                });

                ['soal6', 'soal7', 'soal8'].forEach(name => {
                    document.querySelectorAll(`input[name="${name}"]`).forEach(radio => {
                        radio.disabled = false;
                        radio.checked = false;
                    });

                    document.querySelectorAll(`input[name="${name}"] + label`).forEach(label => {
                        label.className = 'btn btn-outline-success w-100 py-2 fw-bold';
                    });
                });
            }
        );

        // 9. Refleksi
        window.setupReviewMode(
            'm2_cp9_refleksi',
            'button[onclick="cekRefleksiTripel()"]',
            function () {
                kunciFormRefleksiTripel();
            },
            function () {
                ['ref_tri_1_ya', 'ref_tri_1_tidak'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.disabled = false;
                        el.checked = false;
                        el.classList.remove('is-valid');
                    }
                });

                ['ref_tri_1_text', 'ref_tri_2_text'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.disabled = false;
                        el.value = '';
                        el.classList.remove('is-valid', 'is-invalid');
                    }
                });

                const btn = document.querySelector('button[onclick="cekRefleksiTripel()"]');
                if (btn) {
                    btn.disabled = false;
                    btn.innerText = "Simpan Refleksi";
                }
            }
        );
    }
});