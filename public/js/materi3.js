/* =====================================================
   HELPER GLOBAL MATERI 3
===================================================== */
const MATERI3_ID = 'materi_3_segitiga_istimewa';

function simpanProgressMateri3(checkpointCode, points = 0, isSilent = false) {
    if (typeof window.updateProgress === 'function') {
        return window.updateProgress(
            MATERI3_ID,
            checkpointCode,
            points,
            isSilent
        );
    }

    console.warn('window.updateProgress belum tersedia. Pastikan script.js global sudah dimuat.');
    return Promise.resolve();
}

function selesaikanAktivitasMateri3(buttonSelector, resetCallback) {
    if (typeof window.tampilkanLatihanSelesai === 'function') {
        window.tampilkanLatihanSelesai(buttonSelector, resetCallback);
    }
}

function selesaikanKesempatanHabisMateri3(checkpointCode, buttonSelector, resetCallback) {
    simpanProgressMateri3(checkpointCode, 0);

    selesaikanAktivitasMateri3(
        buttonSelector,
        resetCallback
    );
}

function sedangUlangLatihanMateri3(buttonSelector) {
    const btn = document.querySelector(buttonSelector);
    return !!(btn && btn.getAttribute('data-latihan-ulang') === 'true');
}

function swalLatihanMateri3(buttonSelector, options) {
    const isUlang = sedangUlangLatihanMateri3(buttonSelector);
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
                judulSalah.includes('masih ada yang salah') ||
                judulSalah.includes('jawaban kurang tepat') ||
                judulSalah.includes('ada yang salah') ||
                judulSalah.includes('ada yang keliru')
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

function cekAdaKosong(inputElements) {
    return inputElements.some(input => {
        return input && input.value.trim() === '';
    });
}

function setValidasiMateri3(el, isValid) {
    if (!el) return;

    el.classList.remove(
        'is-valid',
        'is-invalid',
        'border-success',
        'border-danger',
        'text-success',
        'text-danger'
    );

    if (isValid) {
        el.classList.add('is-valid', 'border-success', 'text-success');
    } else {
        el.classList.add('is-invalid', 'border-danger', 'text-danger');
    }
}

function isiJawabanMateri3(kunciJawaban) {
    Object.entries(kunciJawaban).forEach(([id, jawaban]) => {
        const el = document.getElementById(id);
        if (el) {
            el.value = jawaban;
            setValidasiMateri3(el, true);
            el.disabled = true;
        }
    });
}

function resetInputMateri3(ids, feedbackId = null) {
    ids.forEach(id => {
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

    if (feedbackId) {
        const feedback = document.getElementById(feedbackId);
        if (feedback) feedback.innerHTML = '';
    }
}

const MATERI3_AKTIVITAS = {
    cp1: {
        checkpoint: 'm3_cp1_ayo_mengamati',
        selector: 'button[onclick="cekTab45()"]',
        poin: 10
    },
    cp2: {
        checkpoint: 'm3_cp2_contoh_1',
        selector: 'button[onclick="cekContoh1Interaktif()"]',
        poin: 15
    },
    cp3: {
        checkpoint: 'm3_cp_contoh_2_45',
        selector: 'button[onclick="cekContoh2_45()"]',
        poin: 15
    },
    cp4: {
        checkpoint: 'm3_cp3_contoh_2',
        selector: 'button[onclick="cekContoh1_30()"]',
        poin: 15
    },
    cp5: {
        checkpoint: 'm3_cp4_latihan_1',
        selector: 'button[onclick="cekSoal1()"]',
        poin: 20
    },
    cp6: {
        checkpoint: 'm3_cp5_latihan_2',
        selector: 'button[onclick="cekSoal2()"]',
        poin: 20
    },
    cp7: {
        checkpoint: 'm3_cp6_refleksi',
        selector: 'button[onclick="simpanRefleksiIstimewa()"]',
        poin: 10
    }
};

function resetTab45() {
    const ids = [
        'bc2', 'bc3', 'bc4', 'bc5', 'bc6', 'bcp',
        'h2_a', 'h2_b',
        'h3_a', 'h3_b',
        'h4_a', 'h4_b',
        'h5_a', 'h5_b',
        'h6_a', 'h6_b',
        'h7_a', 'h7_b'
    ];

    ids.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.value = '';
            el.disabled = false;
            el.classList.remove('is-valid', 'is-invalid');
        }
    });

    const feedback = document.getElementById('tab45_feedback');
    if (feedback) feedback.innerHTML = '';
}

function resetContoh1Interaktif() {
    const ids = [
        'c1i_dik_ab',
        'c1i_dik_sudut',
        'c1i_rasio_45_1',
        'c1i_rasio_45_2',
        'c1i_rasio_90',
        'c1i_perbandingan_atas',
        'c1i_perbandingan_bawah',
        'c1i_sub_ab_angka',
        'c1i_sub_rasio_ac',
        'c1i_sub_rasio_ab',
        'c1i_pecahan_rasio_ac',
        'c1i_pecahan_rasio_ab',
        'c1i_pecahan_ab_angka',
        'c1i_ks_rasio_ab',
        'c1i_ks_rasio_ac',
        'c1i_kali_silang_angka',
        'c1i_pindah_atas',
        'c1i_pindah_bawah',
        'c1i_hasil_hitung',
        'c1i_hasil_akhir'
    ];

    ids.forEach(id => {
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

    const feedback = document.getElementById('c1i_feedback');
    if (feedback) feedback.innerHTML = '';

    attemptContoh1_45 = 0;
}

function resetContoh2_45() {
    const ids = [
        'c2_45_dik_ac',
        'c2_45_dik_sudut',
        'c2_45_rasio_45_1',
        'c2_45_rasio_45_2',
        'c2_45_rasio_90',
        'c2_45_perbandingan_atas',
        'c2_45_perbandingan_bawah',
        'c2_45_sub_ac',
        'c2_45_sub_rasio_ab',
        'c2_45_sub_rasio_ac',
        'c2_45_pecahan_ac',
        'c2_45_pecahan_rasio_ab',
        'c2_45_pecahan_rasio_ac',
        'c2_45_pindah_rasio_ab',
        'c2_45_pindah_angka_ac',
        'c2_45_pindah_rasio_ac',
        'c2_45_ras_val_atas',
        'c2_45_ras_val_bawah',
        'c2_45_rasionalkan_atas',
        'c2_45_rasionalkan_bawah',
        'c2_45_hasil_pembilang_angka',
        'c2_45_hasil_pembilang_akar',
        'c2_45_hasil_penyebut',
        'c2_45_hasil_akhir_angka',
        'c2_45_hasil_akhir_akar'
    ];

    ids.forEach(id => {
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

    const feedback = document.getElementById('tab45_feedback');
    if (feedback) feedback.innerHTML = '';

    attemptTab45 = 0;
}

function resetContoh1_30() {
    const ids = [
        'c1_30_dik_bc',
        'c1_30_dik_sudut',
        'c1_30_dik_siku',
        'c1_30_rasio_30',
        'c1_30_rasio_60',
        'c1_30_rasio_90',
        'c1_30_perbandingan_atas',
        'c1_30_perbandingan_bawah',
        'c1_30_sub_bc',
        'c1_30_sub_rasio_ac',
        'c1_30_sub_rasio_bc',
        'c1_30_pecahan_bc',
        'c1_30_pecahan_rasio_ac',
        'c1_30_pecahan_rasio_bc',
        'c1_30_pindah_rasio_ac',
        'c1_30_pindah_angka_bc',
        'c1_30_pindah_rasio_bc',
        'c1_30_rasional_atas',
        'c1_30_rasional_bawah',
        'c1_30_hasil_bagi',
        'c1_30_hasil_akhir_angka',
        'c1_30_hasil_akhir_akar'
    ];

    ids.forEach(id => {
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

    const feedback = document.getElementById('c1_30_feedback');
    if (feedback) feedback.innerHTML = '';

    attemptContoh1_30 = 0;
}

function resetSoal1() {
    const ids = [
        's1_dik_c',
        's1_dik_a',
        's1_dik_ac',
        's1_ditanya',
        's1_rasio_45_1',
        's1_rasio_45_2',
        's1_rasio_90',
        's1_perbandingan_atas',
        's1_perbandingan_bawah',
        's1_pecahan_rasio_ab',
        's1_pecahan_rasio_ac',

        // Jika ID dobel di Blade sudah kamu ubah, ini ikut direset
        's1_pecahan_rasio_ab_2',
        's1_pecahan_rasio_ac_2',

        's1_pecahan_ac',
        's1_pindah_rasio_ab',
        's1_pindah_angka_ac',
        's1_pindah_rasio_ac',
        's1_hasil_hitung_angka',
        's1_hasil_hitung_akar',
        's1_final_angka',
        's1_final_akar'
    ];

    ids.forEach(id => {
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

    const feedback = document.getElementById('s1_feedback');
    if (feedback) feedback.innerHTML = '';

    attemptSoal1 = 0;
}

function resetSoal2() {
    const ids = [
        's2_dik_ef',
        's2_dik_e',
        's2_dik_siku',
        's2_ditanya',
        's2_rasio_30',
        's2_rasio_60',
        's2_rasio_90',
        's2_perbandingan_atas',
        's2_perbandingan_bawah',
        's2_pecahan_rasio_eg',
        's2_pecahan_rasio_ef',

        // Jika ID dobel di Blade sudah kamu ubah, ini ikut direset
        's2_pecahan_rasio_eg_2',
        's2_pecahan_rasio_ef_2',

        's2_pecahan_ef',
        's2_pindah_rasio_eg',
        's2_pindah_ef',
        's2_pindah_rasio_ef',
        's2_hasil_hitung_atas',
        's2_hasil_hitung_bawah',
        's2_final'
    ];

    ids.forEach(id => {
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

    const feedback = document.getElementById('s2_feedback');
    if (feedback) feedback.innerHTML = '';

    attemptSoal2 = 0;
}

let attemptTab45 = 0;
// ==========================================
// HALAMAN 1: AYO MENGAMATI (Tabel 45-45-90)
// ==========================================
function cekTab45() {
    const buttonSelector = 'button[onclick="cekTab45()"]';

    const kunciJawaban = {
        'bc2': '2',
        'bc3': '3',
        'bc4': '4',
        'bc5': '5',
        'bc6': '6',
        'bcp': 'p',
        'h2_a': '2',
        'h2_b': '2',
        'h3_a': '3',
        'h3_b': '2',
        'h4_a': '4',
        'h4_b': '2',
        'h5_a': '5',
        'h5_b': '2',
        'h6_a': '6',
        'h6_b': '2',
        'h7_a': 'p',
        'h7_b': '2'
    };

    let adaKosong = false;
    let semuaBenar = true;

    for (const id in kunciJawaban) {
        const inputElement = document.getElementById(id);
        if (inputElement && inputElement.value.trim() === "") {
            adaKosong = true;
            break;
        }
    }

    if (adaKosong) {
        Swal.fire({
            icon: 'warning',
            title: 'Belum Lengkap',
            text: 'Harap lengkapi semua kotak jawaban terlebih dahulu!',
            confirmButtonColor: '#198754'
        });
        return;
    }

    for (const [id, jawabanBenar] of Object.entries(kunciJawaban)) {
        const inputElement = document.getElementById(id);

        if (inputElement) {
            inputElement.classList.remove('is-valid', 'is-invalid');

            const jawabanUser = inputElement.value.trim().toLowerCase();

            if (jawabanUser === jawabanBenar.toLowerCase()) {
                inputElement.classList.add('is-valid');
            } else {
                inputElement.classList.add('is-invalid');
                semuaBenar = false;
            }
        }
    }

    attemptTab45++;

    if (semuaBenar) {
        simpanProgressMateri3('m3_cp1_ayo_mengamati', 10);

        swalLatihanMateri3(buttonSelector, {
            icon: 'success',
            title: '+10 Poin!',
            text: 'Kamu berhasil menemukan pola hubungan sisi-sisi pada segitiga siku-siku sama kaki.',
            confirmButtonColor: '#198754'
        }).then(() => {
            const feedback = document.getElementById('tab45_feedback');
            if (feedback) {
                feedback.innerHTML = `
                    <div class="alert mt-3 mb-0 small text-start border-success shadow-sm">
                        Berdasarkan pola pada tabel di atas, panjang sisi miring selalu
                        <strong>panjang sisi siku-siku × √2</strong>.
                        Jadi, perbandingan sisi segitiga 45°-45°-90° adalah
                        <strong>1 : 1 : √2</strong>.
                    </div>
                `;
            }

            selesaikanAktivitasMateri3(
                buttonSelector,
                resetTab45
            );
        });
    } else {
        if (attemptTab45 >= 3) {
            Swal.fire({
                icon: 'info',
                title: 'Kesempatan Habis',
                text: 'Mari kita lihat pola jawaban yang benar.',
                confirmButtonText: 'Tampilkan Jawaban',
                confirmButtonColor: '#0d6efd',
                allowOutsideClick: false
            }).then(() => {
                for (const [id, jawabanBenar] of Object.entries(kunciJawaban)) {
                    const inputElement = document.getElementById(id);
                    if (inputElement) {
                        inputElement.value = jawabanBenar;
                        inputElement.classList.remove('is-invalid');
                        inputElement.classList.add('is-valid');
                        inputElement.disabled = true;
                    }
                }

                const feedback = document.getElementById('tab45_feedback');
                if (feedback) {
                    feedback.innerHTML = `
                    <div class="alert mt-3 mb-0 small text-start border-success shadow-sm">
                        Berdasarkan pola pada tabel di atas, panjang sisi miring selalu
                        <strong>panjang sisi siku-siku × √2</strong>.
                        Jadi, perbandingan sisi segitiga 45°-45°-90° adalah
                        <strong>1 : 1 : √2</strong>.
                    </div>
                `;
                }

                selesaikanKesempatanHabisMateri3(
                    'm3_cp1_ayo_mengamati',
                    buttonSelector,
                    resetTab45
                );
            });

            return;
        }

        swalLatihanMateri3(buttonSelector, {
            icon: 'error',
            title: 'Kurang Tepat',
            text: `Masih ada nilai yang keliru. Sisa kesempatan: ${3 - attemptTab45} kali.`,
            confirmButtonColor: '#dc3545'
        });
    }
}
// ==========================================
// HALAMAN 0: CONTOH SOAL 1 (45-45-90)
// ==========================================
let attemptContoh1_45 = 0;

function cekContoh1Interaktif() {
    const buttonSelector = 'button[onclick="cekContoh1Interaktif()"]';

    const kunciJawaban = {
        'c1i_dik_sudut': '45',
        'c1i_rasio_45_1': '1',
        'c1i_rasio_45_2': '1',
        'c1i_rasio_90': '2',
        'c1i_perbandingan_atas': '1',
        'c1i_perbandingan_bawah': '2',
        'c1i_sub_ab_angka': '15',
        'c1i_sub_rasio_ac': '1',
        'c1i_sub_rasio_ab': '2',
        'c1i_pecahan_rasio_ac': '1',
        'c1i_pecahan_rasio_ab': '2',
        'c1i_pecahan_ab_angka': '15',
        'c1i_ks_rasio_ab': '2',
        'c1i_ks_rasio_ac': '1',
        'c1i_kali_silang_angka': '15',
        'c1i_pindah_atas': '15',
        'c1i_pindah_bawah': '2',
        'c1i_hasil_hitung': '15',
        'c1i_hasil_akhir': '15'
    };

    const inputElements = Object.keys(kunciJawaban).map(id => document.getElementById(id));
    inputElements.push(document.getElementById('c1i_dik_ab'));

    let adaKosong = false;

    for (const input of inputElements) {
        if (input && input.value.trim() === "") {
            adaKosong = true;
            break;
        }
    }

    if (adaKosong) {
        Swal.fire({
            icon: 'warning',
            title: 'Belum Lengkap',
            text: 'Harap lengkapi semua kotak jawaban!',
            confirmButtonColor: '#198754'
        });
        return;
    }

    attemptContoh1_45++;

    let semuaBenar = true;

    inputElements.forEach(input => {
        if (!input) return;

        input.classList.remove(
            'is-valid',
            'is-invalid',
            'border-success',
            'border-danger',
            'text-success',
            'text-danger'
        );

        let isCorrect = false;

        if (input.id === 'c1i_dik_ab') {
            const cleanVal = input.value.replace(/[\s\\{}]/g, '').toLowerCase();
            isCorrect =
                cleanVal === '15sqrt2' ||
                cleanVal === '15akar2' ||
                cleanVal === '15';
        } else {
            const userVal = input.value.trim().toLowerCase();
            isCorrect = userVal === kunciJawaban[input.id].toLowerCase();
        }

        if (isCorrect) {
            input.classList.add('is-valid', 'border-success', 'text-success');
        } else {
            input.classList.add('is-invalid', 'border-danger', 'text-danger');
            semuaBenar = false;
        }
    });

    if (semuaBenar) {
        const feedback = document.getElementById('c1i_feedback');
        if (feedback) feedback.innerText = "Jawaban Benar";

        simpanProgressMateri3('m3_cp2_contoh_1', 15);

        swalLatihanMateri3(buttonSelector, {
            icon: 'success',
            title: '+15 Poin!',
            text: 'Langkah penyelesaian Contoh 1 sudah benar.',
            confirmButtonColor: '#198754'
        }).then(() => {
            selesaikanAktivitasMateri3(
                buttonSelector,
                resetContoh1Interaktif
            );
        });

        return;
    }

    if (attemptContoh1_45 >= 3) {
        Swal.fire({
            title: 'Kesempatan Habis',
            text: 'Mari kita lihat jawaban yang benar.',
            icon: 'info',
            confirmButtonText: 'Tampilkan Jawaban',
            confirmButtonColor: '#0d6efd',
            allowOutsideClick: false
        }).then(() => {
            inputElements.forEach(input => {
                if (!input) return;

                if (input.id === 'c1i_dik_ab') {
                    input.value = '15sqrt2';
                } else {
                    input.value = kunciJawaban[input.id];
                }

                input.classList.remove('is-invalid', 'border-danger', 'text-danger');
                input.classList.add('is-valid', 'border-success', 'text-success');
                input.disabled = true;
            });

            const feedback = document.getElementById('c1i_feedback');
            if (feedback) feedback.innerText = "Ini adalah jawaban yang benar.";

            selesaikanKesempatanHabisMateri3(
                'm3_cp2_contoh_1',
                buttonSelector,
                resetContoh1Interaktif
            );
        });

        return;
    }

    swalLatihanMateri3(buttonSelector, {
        title: 'Kurang Tepat',
        text: `Masih ada kotak salah. Sisa kesempatan: ${3 - attemptContoh1_45} kali.`,
        icon: 'error',
        confirmButtonColor: '#dc3545'
    });
}

// ==========================================
// HALAMAN 0: CONTOH SOAL 2 (45-45-90)
// ==========================================
let attemptContoh2_45 = 0;

function cekContoh2_45() {
    const buttonSelector = 'button[onclick="cekContoh2_45()"]';

    const kunciJawaban = {
        'c2_45_dik_ac': '20',
        'c2_45_dik_sudut': '45',
        'c2_45_rasio_45_1': '1',
        'c2_45_rasio_45_2': '1',
        'c2_45_rasio_90': '2',
        'c2_45_perbandingan_atas': '2',
        'c2_45_perbandingan_bawah': '1',
        'c2_45_sub_ac': '20',
        'c2_45_sub_rasio_ab': '2',
        'c2_45_sub_rasio_ac': '1',
        'c2_45_pecahan_ac': '20',
        'c2_45_pecahan_rasio_ab': '2',
        'c2_45_pecahan_rasio_ac': '1',
        'c2_45_pindah_rasio_ab': '2',
        'c2_45_pindah_angka_ac': '20',
        'c2_45_pindah_rasio_ac': '1',
        'c2_45_ras_val_atas': '20',
        'c2_45_ras_val_bawah': '2',
        'c2_45_rasionalkan_atas': '2',
        'c2_45_rasionalkan_bawah': '2',
        'c2_45_hasil_pembilang_angka': '20',
        'c2_45_hasil_pembilang_akar': '2',
        'c2_45_hasil_penyebut': '2',
        'c2_45_hasil_akhir_angka': '10',
        'c2_45_hasil_akhir_akar': '2'
    };

    const inputElements = Object.keys(kunciJawaban).map(id => document.getElementById(id));

    if (cekAdaKosong(inputElements)) {
        Swal.fire({
            icon: 'warning',
            title: 'Belum Lengkap',
            text: 'Harap lengkapi semua kotak!',
            confirmButtonColor: '#198754'
        });
        return;
    }

    attemptContoh2_45++;

    let semuaBenar = true;

    inputElements.forEach(input => {
        if (!input) return;

        input.classList.remove(
            'is-valid',
            'is-invalid',
            'border-success',
            'border-danger',
            'text-success',
            'text-danger'
        );

        const isCorrect = input.value.trim().toLowerCase() === kunciJawaban[input.id].toLowerCase();

        if (isCorrect) {
            input.classList.add('is-valid', 'border-success', 'text-success');
        } else {
            input.classList.add('is-invalid', 'border-danger', 'text-danger');
            semuaBenar = false;
        }
    });

    if (semuaBenar) {
        const feedback = document.getElementById('c2_45_feedback');
        if (feedback) feedback.innerText = "Jawaban Benar";

        simpanProgressMateri3('m3_cp_contoh_2_45', 15);

        swalLatihanMateri3(buttonSelector, {
            icon: 'success',
            title: '+15 Poin!',
            text: 'Penyelesaian Contoh 2 sudah benar.',
            confirmButtonColor: '#198754'
        }).then(() => {
            selesaikanAktivitasMateri3(
                buttonSelector,
                resetContoh2_45
            );
        });

        return;
    }

    if (attemptContoh2_45 >= 3) {
        Swal.fire({
            title: 'Kesempatan Habis',
            text: 'Mari kita lihat jawaban yang benar.',
            icon: 'info',
            confirmButtonText: 'Tampilkan Jawaban',
            confirmButtonColor: '#0d6efd',
            allowOutsideClick: false
        }).then(() => {
            inputElements.forEach(input => {
                if (!input) return;

                input.value = kunciJawaban[input.id];
                input.classList.remove('is-invalid', 'border-danger', 'text-danger');
                input.classList.add('is-valid', 'border-success', 'text-success');
                input.disabled = true;
            });

            const feedback = document.getElementById('c2_45_feedback');
            if (feedback) feedback.innerText = "Ini adalah jawaban yang benar.";

            selesaikanKesempatanHabisMateri3(
                'm3_cp_contoh_2_45',
                buttonSelector,
                resetContoh2_45
            );
        });

        return;
    }

    swalLatihanMateri3(buttonSelector, {
        title: 'Kurang Tepat',
        text: `Masih ada yang salah. Sisa kesempatan: ${3 - attemptContoh2_45} kali.`,
        icon: 'error',
        confirmButtonColor: '#dc3545'
    });
}

// ==========================================
// HALAMAN 1: CONTOH SOAL 1 (30-60-90)
// ==========================================
let attemptContoh1_30 = 0;

function cekContoh1_30() {
    const buttonSelector = 'button[onclick="cekContoh1_30()"]';

    const kunciJawaban = {
        'c1_30_dik_bc': '15',
        'c1_30_dik_sudut': '30',
        'c1_30_dik_siku': 'C',
        'c1_30_rasio_30': '1',
        'c1_30_rasio_60': '3',
        'c1_30_rasio_90': '2',
        'c1_30_perbandingan_atas': '1',
        'c1_30_perbandingan_bawah': '3',
        'c1_30_sub_bc': '15',
        'c1_30_sub_rasio_ac': '1',
        'c1_30_sub_rasio_bc': '3',
        'c1_30_pecahan_bc': '15',
        'c1_30_pecahan_rasio_ac': '1',
        'c1_30_pecahan_rasio_bc': '3',
        'c1_30_pindah_rasio_ac': '1',
        'c1_30_pindah_angka_bc': '15',
        'c1_30_pindah_rasio_bc': '3',
        'c1_30_rasional_atas': '3',
        'c1_30_rasional_bawah': '3',
        'c1_30_hasil_bagi': '3',
        'c1_30_hasil_akhir_angka': '5',
        'c1_30_hasil_akhir_akar': '3'
    };

    const inputElements = Object.keys(kunciJawaban).map(id => document.getElementById(id));

    if (cekAdaKosong(inputElements)) {
        Swal.fire({
            icon: 'warning',
            title: 'Belum Lengkap',
            text: 'Harap lengkapi semua kotak!',
            confirmButtonColor: '#198754'
        });
        return;
    }

    attemptContoh1_30++;

    let semuaBenar = true;

    inputElements.forEach(input => {
        if (!input) return;

        input.classList.remove(
            'is-valid',
            'is-invalid',
            'border-success',
            'border-danger',
            'text-success',
            'text-danger'
        );

        let isCorrect = false;
        const userVal = input.value.trim().toLowerCase();
        const jawabanBenar = kunciJawaban[input.id].toLowerCase();

        // Khusus bagian perkalian: 1 × 15 atau 15 × 1 sama-sama benar
        if (input.id === 'c1_30_pindah_rasio_ac' || input.id === 'c1_30_pindah_angka_bc') {
            const val1 = document.getElementById('c1_30_pindah_rasio_ac')?.value.trim();
            const val2 = document.getElementById('c1_30_pindah_angka_bc')?.value.trim();

            isCorrect =
                (val1 === '1' && val2 === '15') ||
                (val1 === '15' && val2 === '1');
        } else {
            isCorrect = userVal === jawabanBenar;
        }

        if (isCorrect) {
            input.classList.add('is-valid', 'border-success', 'text-success');
        } else {
            input.classList.add('is-invalid', 'border-danger', 'text-danger');
            semuaBenar = false;
        }
    });

    if (semuaBenar) {
        const feedback = document.getElementById('c1_30_feedback');
        if (feedback) feedback.innerText = "Jawaban Benar";

        simpanProgressMateri3('m3_cp3_contoh_2', 15);

        swalLatihanMateri3(buttonSelector, {
            icon: 'success',
            title: '+15 Poin!',
            text: 'Langkah penyelesaian Contoh 1 pada segitiga 30°-60°-90° sudah benar.',
            confirmButtonColor: '#198754'
        }).then(() => {
            selesaikanAktivitasMateri3(
                buttonSelector,
                resetContoh1_30
            );
        });

        return;
    }

    if (attemptContoh1_30 >= 3) {
        Swal.fire({
            title: 'Kesempatan Habis',
            text: 'Mari kita lihat jawaban yang benar.',
            icon: 'info',
            confirmButtonText: 'Tampilkan Jawaban',
            confirmButtonColor: '#0d6efd',
            allowOutsideClick: false
        }).then(() => {
            inputElements.forEach(input => {
                if (!input) return;

                input.value = kunciJawaban[input.id];
                input.classList.remove('is-invalid', 'border-danger', 'text-danger');
                input.classList.add('is-valid', 'border-success', 'text-success');
                input.disabled = true;
            });

            const feedback = document.getElementById('c1_30_feedback');
            if (feedback) feedback.innerText = "Ini adalah jawaban yang benar.";

            selesaikanKesempatanHabisMateri3(
                'm3_cp3_contoh_2',
                buttonSelector,
                resetContoh1_30
            );
        });

        return;
    }

    swalLatihanMateri3(buttonSelector, {
        title: 'Kurang Tepat',
        text: `Masih ada yang salah. Sisa kesempatan: ${3 - attemptContoh1_30} kali.`,
        icon: 'error',
        confirmButtonColor: '#dc3545'
    });
}
// ==========================================
// HALAMAN 3: AYO BERLATIH - SOAL 1
// ==========================================
let attemptSoal1 = 0;
const maxAttemptsLatihan = 3;

function cekSoal1() {
    const buttonSelector = 'button[onclick="cekSoal1()"]';

    const kunciJawaban = {
        's1_dik_c': '90',
        's1_dik_a': '45',
        's1_dik_ac': '10',
        's1_ditanya': 'ab',
        's1_rasio_45_1': '1',
        's1_rasio_45_2': '1',
        's1_rasio_90': '2',
        's1_perbandingan_atas': '2',
        's1_perbandingan_bawah': '1',
        's1_pecahan_rasio_ab': '2',
        's1_pecahan_rasio_ac': '1',

        // Jika Blade sudah kamu ubah ID dobelnya menjadi _2
        's1_pecahan_rasio_ab_2': '2',
        's1_pecahan_rasio_ac_2': '1',

        's1_pecahan_ac': '10',
        's1_pindah_rasio_ab': '2',
        's1_pindah_angka_ac': '10',
        's1_pindah_rasio_ac': '1',
        's1_hasil_hitung_angka': '10',
        's1_hasil_hitung_akar': '2',
        's1_final_angka': '10',
        's1_final_akar': '2'
    };

    const inputElements = Object.keys(kunciJawaban)
        .map(id => document.getElementById(id))
        .filter(input => input !== null);

    let adaKosong = false;

    for (const input of inputElements) {
        if (input.value.trim() === "") {
            adaKosong = true;
            break;
        }
    }

    if (adaKosong) {
        Swal.fire({
            icon: 'warning',
            title: 'Belum Lengkap',
            text: 'Harap lengkapi semua kotak jawaban pada Soal 1!',
            confirmButtonColor: '#198754'
        });
        return;
    }

    attemptSoal1++;

    let semuaBenar = true;

    inputElements.forEach(input => {
        input.classList.remove(
            'is-valid',
            'is-invalid',
            'border-success',
            'border-danger',
            'text-success',
            'text-danger'
        );

        const userVal = input.value.trim().toLowerCase();
        const jawabanBenar = kunciJawaban[input.id].toLowerCase();

        const isCorrect = userVal === jawabanBenar;

        if (isCorrect) {
            input.classList.add('is-valid', 'border-success', 'text-success');
        } else {
            input.classList.add('is-invalid', 'border-danger', 'text-danger');
            semuaBenar = false;
        }
    });

    if (semuaBenar) {
        const feedback = document.getElementById('s1_feedback');
        if (feedback) feedback.innerHTML = '<span class="text-success fw-bold">Jawaban Latihan Benar.</span>';

        simpanProgressMateri3('m3_cp4_latihan_1', 20);

        swalLatihanMateri3(buttonSelector, {
            icon: 'success',
            title: '+20 Poin!',
            text: 'Jawaban Latihan Soal 1 kamu sudah benar.',
            confirmButtonColor: '#198754'
        }).then(() => {
            selesaikanAktivitasMateri3(
                buttonSelector,
                resetSoal1
            );
        });

        return;
    }

    if (attemptSoal1 >= 3) {
        Swal.fire({
            title: 'Kesempatan Habis',
            text: 'Mari kita lihat jawaban yang benar.',
            icon: 'info',
            confirmButtonText: 'Tampilkan Jawaban',
            confirmButtonColor: '#0d6efd',
            allowOutsideClick: false
        }).then(() => {
            inputElements.forEach(input => {
                input.value = kunciJawaban[input.id];
                input.classList.remove('is-invalid', 'border-danger', 'text-danger');
                input.classList.add('is-valid', 'border-success', 'text-success');
                input.disabled = true;
            });

            const feedback = document.getElementById('s1_feedback');
            if (feedback) feedback.innerHTML = '<span class="text-primary fw-bold">Ini adalah jawaban yang benar.</span>';

            selesaikanKesempatanHabisMateri3(
                'm3_cp4_latihan_1',
                buttonSelector,
                resetSoal1
            );
        });

        return;
    }

    swalLatihanMateri3(buttonSelector, {
        title: 'Kurang Tepat',
        text: `Masih ada kotak yang salah. Sisa kesempatan: ${3 - attemptSoal1} kali.`,
        icon: 'error',
        confirmButtonColor: '#dc3545'
    });
}

// ==========================================
// HALAMAN 3: AYO BERLATIH - SOAL 2
// ==========================================
let attemptSoal2 = 0;

function cekSoal2() {
    const buttonSelector = 'button[onclick="cekSoal2()"]';

    const kunciJawaban = {
        's2_dik_ef': '25',
        's2_dik_e': '60',
        's2_dik_siku': 'g',
        's2_ditanya': 'eg',
        's2_rasio_30': '1',
        's2_rasio_60': '3',
        's2_rasio_90': '2',
        's2_perbandingan_atas': '1',
        's2_perbandingan_bawah': '2',
        's2_pecahan_rasio_eg': '1',
        's2_pecahan_rasio_ef': '2',

        // Jika Blade sudah kamu ubah ID dobelnya menjadi _2
        's2_pecahan_rasio_eg_2': '1',
        's2_pecahan_rasio_ef_2': '2',

        's2_pecahan_ef': '25',
        's2_pindah_rasio_eg': '1',
        's2_pindah_ef': '25',
        's2_pindah_rasio_ef': '2',
        's2_hasil_hitung_atas': '25',
        's2_hasil_hitung_bawah': '2',
        's2_final': '12.5'
    };

    const inputElements = Object.keys(kunciJawaban)
        .map(id => document.getElementById(id))
        .filter(input => input !== null);

    let adaKosong = false;

    for (const input of inputElements) {
        if (input.value.trim() === "") {
            adaKosong = true;
            break;
        }
    }

    if (adaKosong) {
        Swal.fire({
            icon: 'warning',
            title: 'Belum Lengkap',
            text: 'Harap lengkapi semua kotak jawaban pada Soal 2!',
            confirmButtonColor: '#198754'
        });
        return;
    }

    attemptSoal2++;

    let semuaBenar = true;

    inputElements.forEach(input => {
        input.classList.remove(
            'is-valid',
            'is-invalid',
            'border-success',
            'border-danger',
            'text-success',
            'text-danger'
        );

        const userVal = input.value.trim().toLowerCase().replace(',', '.');
        const jawabanBenar = kunciJawaban[input.id].toLowerCase();

        const isCorrect = userVal === jawabanBenar;

        if (isCorrect) {
            input.classList.add('is-valid', 'border-success', 'text-success');
        } else {
            input.classList.add('is-invalid', 'border-danger', 'text-danger');
            semuaBenar = false;
        }
    });

    if (semuaBenar) {
        const feedback = document.getElementById('s2_feedback');
        if (feedback) feedback.innerHTML = '<span class="text-success fw-bold">Jawaban Latihan Benar.</span>';

        simpanProgressMateri3('m3_cp5_latihan_2', 20);

        swalLatihanMateri3(buttonSelector, {
            icon: 'success',
            title: '+20 Poin!',
            text: 'Jawaban Latihan Soal 2 kamu sudah benar.',
            confirmButtonColor: '#198754'
        }).then(() => {
            selesaikanAktivitasMateri3(
                buttonSelector,
                resetSoal2
            );
        });

        return;
    }

    if (attemptSoal2 >= 3) {
        Swal.fire({
            title: 'Kesempatan Habis',
            text: 'Mari kita lihat jawaban yang benar.',
            icon: 'info',
            confirmButtonText: 'Tampilkan Jawaban',
            confirmButtonColor: '#0d6efd',
            allowOutsideClick: false
        }).then(() => {
            inputElements.forEach(input => {
                input.value = kunciJawaban[input.id];
                input.classList.remove('is-invalid', 'border-danger', 'text-danger');
                input.classList.add('is-valid', 'border-success', 'text-success');
                input.disabled = true;
            });

            const feedback = document.getElementById('s2_feedback');
            if (feedback) feedback.innerHTML = '<span class="text-primary fw-bold">Ini adalah jawaban yang benar.</span>';

            selesaikanKesempatanHabisMateri3(
                'm3_cp5_latihan_2',
                buttonSelector,
                resetSoal2
            );
        });

        return;
    }

    swalLatihanMateri3(buttonSelector, {
        title: 'Kurang Tepat',
        text: `Masih ada kotak yang salah. Sisa kesempatan: ${3 - attemptSoal2} kali.`,
        icon: 'error',
        confirmButtonColor: '#dc3545'
    });
}
/* =====================================================
   REFLEKSI AKHIR (SEGITIGA ISTIMEWA - MATERI 3)
===================================================== */
function simpanRefleksiIstimewa() {
    const form = document.getElementById('formRefleksiMateri3');
    const formData = new FormData(form);
    const btnSubmit = document.getElementById('btnSimpanRefleksiIstimewa');
    const feedbackArea = document.getElementById('refleksi_feedback_istimewa');

    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

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

            // Simpan progres untuk Materi 3 (GANTI SESUAIKAN ID CHECKPOINT ANDA)
            if (typeof simpanProgressMateri3 === 'function') {
                simpanProgressMateri3('m3_cp_refleksi_istimewa', 10, false);
            }

            if (typeof swalLatihanMateri3 === 'function') {
                swalLatihanMateri3('button[onclick="simpanRefleksiIstimewa()"]', {
                    icon: 'success',
                    title: '+10 Poin!',
                    html: 'Refleksi Segitiga Istimewa kamu berhasil disimpan.<br><small class="text-muted">Siap untuk Kuis 3? Ayo uji pemahamanmu!</small>',
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
        console.error('Error Refleksi M3:', error);
        feedbackArea.innerHTML = `<div class="alert alert-danger py-2 small fw-bold mb-0">Terjadi kesalahan koneksi.</div>`;
        btnSubmit.innerHTML = 'Simpan Refleksi';
        btnSubmit.disabled = false;
    });
}

/* =====================================================
   AKTIFASI MODE REVIEW UNTUK MATERI 3
===================================================== */
document.addEventListener('DOMContentLoaded', function () {

    if (typeof window.setupReviewMode === 'function') {

        window.setupReviewMode(
            'm3_cp1_ayo_mengamati',
            'button[onclick="cekTab45()"]',
            function () {
                const ans = {
                    'bc2': '2', 'bc3': '3', 'bc4': '4', 'bc5': '5', 'bc6': '6', 'bcp': 'p',
                    'h2_a': '2', 'h2_b': '2',
                    'h3_a': '3', 'h3_b': '2',
                    'h4_a': '4', 'h4_b': '2',
                    'h5_a': '5', 'h5_b': '2',
                    'h6_a': '6', 'h6_b': '2',
                    'h7_a': 'p', 'h7_b': '2'
                };

                for (let id in ans) {
                    const el = document.getElementById(id);
                    if (el) {
                        el.value = ans[id];
                        el.classList.add('is-valid');
                        el.disabled = true;
                    }
                }

                const feedback = document.getElementById('tab45_feedback');
                if (feedback) {
                    feedback.innerHTML = `
                        <div class="alert mt-3 mb-0 small text-start border-success shadow-sm">
                            Berdasarkan pola pada tabel di atas, panjang sisi miring selalu
                            <strong>panjang sisi siku-siku × √2</strong>.
                            Jadi, perbandingan sisi segitiga 45°-45°-90° adalah
                            <strong>1 : 1 : √2</strong>.
                        </div>
                    `;
                }
            },
            resetTab45
        );

        window.setupReviewMode(
            'm3_cp2_contoh_1',
            'button[onclick="cekContoh1Interaktif()"]',
            function () {
                const ans = {
                    'c1i_dik_ab': '15sqrt2',
                    'c1i_dik_sudut': '45',
                    'c1i_rasio_45_1': '1',
                    'c1i_rasio_45_2': '1',
                    'c1i_rasio_90': '2',
                    'c1i_perbandingan_atas': '1',
                    'c1i_perbandingan_bawah': '2',
                    'c1i_sub_ab_angka': '15',
                    'c1i_sub_rasio_ac': '1',
                    'c1i_sub_rasio_ab': '2',
                    'c1i_pecahan_rasio_ac': '1',
                    'c1i_pecahan_rasio_ab': '2',
                    'c1i_pecahan_ab_angka': '15',
                    'c1i_ks_rasio_ab': '2',
                    'c1i_ks_rasio_ac': '1',
                    'c1i_kali_silang_angka': '15',
                    'c1i_pindah_atas': '15',
                    'c1i_pindah_bawah': '2',
                    'c1i_hasil_hitung': '15',
                    'c1i_hasil_akhir': '15'
                };

                for (let id in ans) {
                    const el = document.getElementById(id);
                    if (el) {
                        el.value = ans[id];
                        el.classList.add('is-valid', 'border-success', 'text-success');
                        el.disabled = true;
                    }
                }

                const feedback = document.getElementById('c1i_feedback');
                if (feedback) feedback.innerHTML = '<span class="text-success fw-bold">Penyelesaian selesai.</span>';
            },
            resetContoh1Interaktif
        );

        window.setupReviewMode(
            'm3_cp_contoh_2_45',
            'button[onclick="cekContoh2_45()"]',
            function () {
                const ans = {
                    'c2_45_dik_ac': '20',
                    'c2_45_dik_sudut': '45',
                    'c2_45_rasio_45_1': '1',
                    'c2_45_rasio_45_2': '1',
                    'c2_45_rasio_90': '2',
                    'c2_45_perbandingan_atas': '2',
                    'c2_45_perbandingan_bawah': '1',
                    'c2_45_sub_ac': '20',
                    'c2_45_sub_rasio_ab': '2',
                    'c2_45_sub_rasio_ac': '1',
                    'c2_45_pecahan_ac': '20',
                    'c2_45_pecahan_rasio_ab': '2',
                    'c2_45_pecahan_rasio_ac': '1',
                    'c2_45_pindah_rasio_ab': '2',
                    'c2_45_pindah_angka_ac': '20',
                    'c2_45_pindah_rasio_ac': '1',
                    'c2_45_ras_val_atas': '20',
                    'c2_45_ras_val_bawah': '2',
                    'c2_45_rasionalkan_atas': '2',
                    'c2_45_rasionalkan_bawah': '2',
                    'c2_45_hasil_pembilang_angka': '20',
                    'c2_45_hasil_pembilang_akar': '2',
                    'c2_45_hasil_penyebut': '2',
                    'c2_45_hasil_akhir_angka': '10',
                    'c2_45_hasil_akhir_akar': '2'
                };

                for (let id in ans) {
                    const el = document.getElementById(id);
                    if (el) {
                        el.value = ans[id];
                        el.classList.add('is-valid', 'border-success', 'text-success');
                        el.disabled = true;
                    }
                }

                const feedback = document.getElementById('c2_45_feedback');
                if (feedback) feedback.innerHTML = '<span class="text-success fw-bold">Penyelesaian selesai.</span>';
            },
            resetContoh2_45
        );

        window.setupReviewMode(
            'm3_cp3_contoh_2',
            'button[onclick="cekContoh1_30()"]',
            function () {
                const ans = {
                    'c1_30_dik_bc': '15',
                    'c1_30_dik_sudut': '30',
                    'c1_30_dik_siku': 'C',
                    'c1_30_rasio_30': '1',
                    'c1_30_rasio_60': '3',
                    'c1_30_rasio_90': '2',
                    'c1_30_perbandingan_atas': '1',
                    'c1_30_perbandingan_bawah': '3',
                    'c1_30_sub_bc': '15',
                    'c1_30_sub_rasio_ac': '1',
                    'c1_30_sub_rasio_bc': '3',
                    'c1_30_pecahan_bc': '15',
                    'c1_30_pecahan_rasio_ac': '1',
                    'c1_30_pecahan_rasio_bc': '3',
                    'c1_30_pindah_rasio_ac': '1',
                    'c1_30_pindah_angka_bc': '15',
                    'c1_30_pindah_rasio_bc': '3',
                    'c1_30_rasional_atas': '3',
                    'c1_30_rasional_bawah': '3',
                    'c1_30_hasil_bagi': '3',
                    'c1_30_hasil_akhir_angka': '5',
                    'c1_30_hasil_akhir_akar': '3'
                };

                for (let id in ans) {
                    const el = document.getElementById(id);
                    if (el) {
                        el.value = ans[id];
                        el.classList.add('is-valid', 'border-success', 'text-success');
                        el.disabled = true;
                    }
                }

                const feedback = document.getElementById('c1_30_feedback');
                if (feedback) feedback.innerHTML = '<span class="text-success fw-bold">Penyelesaian selesai.</span>';
            },
            resetContoh1_30
        );

        window.setupReviewMode(
            'm3_cp4_latihan_1',
            'button[onclick="cekSoal1()"]',
            function () {
                const ans = {
                    's1_dik_c': '90',
                    's1_dik_a': '45',
                    's1_dik_ac': '10',
                    's1_ditanya': 'AB',
                    's1_rasio_45_1': '1',
                    's1_rasio_45_2': '1',
                    's1_rasio_90': '2',
                    's1_perbandingan_atas': '2',
                    's1_perbandingan_bawah': '1',
                    's1_pecahan_rasio_ab': '2',
                    's1_pecahan_rasio_ac': '1',
                    's1_pecahan_rasio_ab_2': '2',
                    's1_pecahan_rasio_ac_2': '1',
                    's1_pecahan_ac': '10',
                    's1_pindah_rasio_ab': '2',
                    's1_pindah_angka_ac': '10',
                    's1_pindah_rasio_ac': '1',
                    's1_hasil_hitung_angka': '10',
                    's1_hasil_hitung_akar': '2',
                    's1_final_angka': '10',
                    's1_final_akar': '2'
                };

                for (let id in ans) {
                    const el = document.getElementById(id);
                    if (el) {
                        el.value = ans[id];
                        el.classList.add('is-valid', 'border-success', 'text-success');
                        el.disabled = true;
                    }
                }

                const feedback = document.getElementById('s1_feedback');
                if (feedback) feedback.innerHTML = '<span class="text-success fw-bold">Jawaban Latihan Benar.</span>';
            },
            resetSoal1
        );

        window.setupReviewMode(
            'm3_cp5_latihan_2',
            'button[onclick="cekSoal2()"]',
            function () {
                const ans = {
                    's2_dik_ef': '25',
                    's2_dik_e': '60',
                    's2_dik_siku': 'G',
                    's2_ditanya': 'EG',
                    's2_rasio_30': '1',
                    's2_rasio_60': '3',
                    's2_rasio_90': '2',
                    's2_perbandingan_atas': '1',
                    's2_perbandingan_bawah': '2',
                    's2_pecahan_rasio_eg': '1',
                    's2_pecahan_rasio_ef': '2',
                    's2_pecahan_rasio_eg_2': '1',
                    's2_pecahan_rasio_ef_2': '2',
                    's2_pecahan_ef': '25',
                    's2_pindah_rasio_eg': '1',
                    's2_pindah_ef': '25',
                    's2_pindah_rasio_ef': '2',
                    's2_hasil_hitung_atas': '25',
                    's2_hasil_hitung_bawah': '2',
                    's2_final': '12.5'
                };

                for (let id in ans) {
                    const el = document.getElementById(id);
                    if (el) {
                        el.value = ans[id];
                        el.classList.add('is-valid', 'border-success', 'text-success');
                        el.disabled = true;
                    }
                }

                const feedback = document.getElementById('s2_feedback');
                if (feedback) feedback.innerHTML = '<span class="text-success fw-bold">Jawaban Latihan Benar.</span>';
            },
            resetSoal2
        );

        // ---------------------------------------------------------
        // Latihan: Refleksi Belajar Materi 3 (Segitiga Istimewa)
        // ---------------------------------------------------------
        window.setupReviewMode(
            'm3_cp_refleksi_istimewa', 
            '#btnSimpanRefleksiIstimewa',
            function showAnswer() {
                const form = document.getElementById('formRefleksiMateri3');
                if (form) {
                    // Kunci semua textarea dan radio agar tidak bisa diedit lagi
                    form.querySelectorAll('textarea, input').forEach(el => {
                        el.disabled = true;
                    });
                }

                const btnSubmit = document.getElementById('btnSimpanRefleksiIstimewa');
                if (btnSubmit) {
                    btnSubmit.innerHTML = 'Tersimpan <i class="fas fa-check ms-1"></i>';
                    btnSubmit.classList.replace('btn-success', 'btn-secondary');
                    btnSubmit.disabled = true;
                }

                const feedbackArea = document.getElementById('refleksi_feedback_istimewa');
                if (feedbackArea) {
                    feedbackArea.innerHTML = `<div class="alert alert-success py-2 small fw-bold mb-0"><i class="fas fa-info-circle me-1"></i> Refleksi ini sudah kamu kerjakan.</div>`;
                }
            },
            null // <-- KUNCI: Set menjadi null agar tombol 'Ulangi Latihan' tidak muncul
        );
    }
});