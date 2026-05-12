// =====================================================
// CEK APAKAH SISWA SUDAH MEMILIKI KELAS
// =====================================================
let userHasKelas = false;
const kelasMeta = document.querySelector('meta[name="user-kelas-id"]');
if (kelasMeta && kelasMeta.getAttribute('content') && kelasMeta.getAttribute('content') !== '') {
    userHasKelas = true;
}

// Override fungsi updateProgress agar tidak menyimpan jika belum punya kelas
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

// ==========================================
// HALAMAN 1: AYO MENGAMATI (Tabel 45-45-90)
// ==========================================
function cekTab45() {
    const kunciJawaban = {
        'bc2': '2', 'bc3': '3', 'bc4': '4', 'bc5': '5', 'bc6': '6', 'bcp': 'p',
        'h2_a': '2', 'h2_b': '2',
        'h3_a': '3', 'h3_b': '2',
        'h4_a': '4', 'h4_b': '2',
        'h5_a': '5', 'h5_b': '2',
        'h6_a': '6', 'h6_b': '2',
        'h7_a': 'p', 'h7_b': '2'
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

            if (jawabanUser === jawabanBenar) {
                inputElement.classList.add('is-valid');
            } else {
                inputElement.classList.add('is-invalid');
                semuaBenar = false;
            }
        }
    }

    if (semuaBenar) {
        Swal.fire({
            icon: 'success',
            title: '+10 Poin!',
            text: 'Kamu berhasil menemukan pola hubungan sisi-sisi pada segitiga siku-siku sama kaki.',
            confirmButtonColor: '#198754'
        }).then((result) => {
            if (result.isConfirmed) {
                if (typeof updateProgress === 'function') {
                    updateProgress('materi_3_segitiga_istimewa', 'm3_cp1_ayo_mengamati', 10);
                }
            }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Kurang Tepat',
            text: 'Masih ada nilai yang keliru. Coba perhatikan lagi polanya ya!',
            confirmButtonColor: '#dc3545'
        });
    }
}

// ==========================================
// HALAMAN 0: CONTOH SOAL 1 (45-45-90)
// ==========================================
let attemptContoh1_45 = 0;

function cekContoh1Interaktif() {
    const kunciJawaban = {
        'c1i_dik_sudut': '45',
        'c1i_rasio_45_1': '1',
        'c1i_rasio_45_2': '1',
        'c1i_rasio_90': '2',
        'c1i_perbandingan_atas': '1',
        'c1i_perbandingan_bawah': '2',
        'c1i_sub_ab_angka': '15', // <- Ini yang tadi kurang
        'c1i_sub_rasio_ac': '1',  // <- Ini yang tadi kurang
        'c1i_sub_rasio_ab': '2',  // <- Ini yang tadi kurang
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
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Harap lengkapi semua kotak jawaban!', confirmButtonColor: '#198754' });
        return;
    }

    attemptContoh1_45++;
    let semuaBenar = true;

    inputElements.forEach(input => {
        if (input) {
            input.classList.remove('is-valid', 'is-invalid', 'border-success', 'border-danger', 'text-success', 'text-danger');
            let isCorrect = false;

            if (input.id === 'c1i_dik_ab') {
                let cleanVal = input.value.replace(/[\s\\{}]/g, '').toLowerCase();
                if (cleanVal === '15sqrt2' || cleanVal === '15akar2' || cleanVal === '15') isCorrect = true;
            } else {
                let userVal = input.value.trim().toLowerCase();
                isCorrect = userVal === kunciJawaban[input.id].toLowerCase();
            }

            if (isCorrect) {
                input.classList.add('is-valid', 'border-success', 'text-success');
            } else {
                input.classList.add('is-invalid', 'border-danger', 'text-danger');
                semuaBenar = false;
            }
        }
    });

    if (semuaBenar) {
        Swal.fire({ icon: 'success', title: '+15 Poin!', text: 'Langkah penyelesaian Contoh 1 sudah benar.', confirmButtonColor: '#198754' })
            .then((res) => { if (res.isConfirmed && typeof updateProgress === 'function') updateProgress('materi_3_segitiga_istimewa', 'm3_cp2_contoh_1', 15); });
        document.getElementById('c1i_feedback').innerText = "Jawaban Benar";
    } else {
        if (attemptContoh1_45 >= 3) {
            Swal.fire({ title: 'Kesempatan Habis', text: 'Lihat jawaban benar?', icon: 'error', showCancelButton: true, confirmButtonText: 'Tampilkan', confirmButtonColor: '#198754' })
                .then((res) => {
                    if (res.isConfirmed) {
                        inputElements.forEach(input => {
                            input.value = (input.id === 'c1i_dik_ab') ? '15\\sqrt{2}' : kunciJawaban[input.id];
                            input.classList.remove('is-invalid', 'border-danger', 'text-danger');
                            input.classList.add('is-valid', 'border-success', 'text-success');
                        });
                        if (typeof updateProgress === 'function') updateProgress('materi_3_segitiga_istimewa', 'm3_cp2_contoh_1', 15);
                    }
                });
        } else {
            Swal.fire({ title: 'Kurang Tepat', text: `Masih ada kotak salah (merah). Sisa: ${3 - attemptContoh1_45} kali.`, icon: 'error', confirmButtonColor: '#dc3545' });
        }
    }
}

// ==========================================
// HALAMAN 0: CONTOH SOAL 2 (45-45-90)
// ==========================================
let attemptContoh2_45 = 0;

function cekContoh2_45() {
    const kunciJawaban = {
        'c2_45_dik_ac': '20', 'c2_45_dik_sudut': '45', 'c2_45_rasio_45_1': '1', 'c2_45_rasio_45_2': '1', 'c2_45_rasio_90': '2',
        'c2_45_perbandingan_atas': '2', 'c2_45_perbandingan_bawah': '1',
        'c2_45_sub_ac': '20', 'c2_45_sub_rasio_ab': '2', 'c2_45_sub_rasio_ac': '1',
        'c2_45_pecahan_ac': '20', 'c2_45_pecahan_rasio_ab': '2', 'c2_45_pecahan_rasio_ac': '1',
        'c2_45_pindah_rasio_ab': '2', 'c2_45_pindah_angka_ac': '20', 'c2_45_pindah_rasio_ac': '1',
        'c2_45_ras_val_atas': '20', 'c2_45_ras_val_bawah': '2',
        'c2_45_rasionalkan_atas': '2', 'c2_45_rasionalkan_bawah': '2',
        'c2_45_hasil_pembilang_angka': '20', 'c2_45_hasil_pembilang_akar': '2', 'c2_45_hasil_penyebut': '2',
        'c2_45_hasil_akhir_angka': '10', 'c2_45_hasil_akhir_akar': '2'
    };

    const inputElements = Object.keys(kunciJawaban).map(id => document.getElementById(id));
    if (cekAdaKosong(inputElements)) {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Harap lengkapi semua kotak!', confirmButtonColor: '#198754' }); return;
    }

    attemptContoh2_45++;
    let semuaBenar = true;

    inputElements.forEach(input => {
        if (input) {
            input.classList.remove('is-valid', 'is-invalid', 'border-success', 'border-danger', 'text-success', 'text-danger');
            let isCorrect = input.value.trim() === kunciJawaban[input.id];
            if (isCorrect) {
                input.classList.add('is-valid', 'border-success', 'text-success');
            } else {
                input.classList.add('is-invalid', 'border-danger', 'text-danger');
                semuaBenar = false;
            }
        }
    });

    if (semuaBenar) {
        Swal.fire({ icon: 'success', title: 'Tepat!', text: 'Penyelesaian Contoh 2 sudah benar.', confirmButtonColor: '#198754' });
        document.getElementById('c2_45_feedback').innerText = "Jawaban Benar";
    } else {
        if (attemptContoh2_45 >= 3) {
            Swal.fire({ title: 'Kesempatan Habis', icon: 'error', showCancelButton: true, confirmButtonText: 'Tampilkan', confirmButtonColor: '#198754' })
                .then(res => {
                    if (res.isConfirmed) {
                        inputElements.forEach(input => {
                            input.value = kunciJawaban[input.id];
                            input.classList.remove('is-invalid', 'border-danger', 'text-danger');
                            input.classList.add('is-valid', 'border-success', 'text-success');
                        });
                    }
                });
        } else {
            Swal.fire({ title: 'Kurang Tepat', text: `Masih ada yang salah. Sisa: ${3 - attemptContoh2_45} kali.`, icon: 'error', confirmButtonColor: '#dc3545' });
        }
    }
}
// ==========================================
// HALAMAN 1: CONTOH SOAL 1 (30-60-90)
// ==========================================
let attemptContoh1_30 = 0;

function cekContoh1_30() {
    const kunciJawaban = {
        'c1_30_dik_bc': '15', 'c1_30_dik_sudut': '30', 'c1_30_dik_siku': 'c',
        'c1_30_rasio_30': '1', 'c1_30_rasio_60': '3', 'c1_30_rasio_90': '2',
        'c1_30_perbandingan_atas': '1', 'c1_30_perbandingan_bawah': '3',
        'c1_30_sub_bc': '15', 'c1_30_sub_rasio_ac': '1', 'c1_30_sub_rasio_bc': '3',
        'c1_30_pecahan_bc': '15', 'c1_30_pecahan_rasio_ac': '1', 'c1_30_pecahan_rasio_bc': '3',
        'c1_30_pindah_rasio_ac': '1', 'c1_30_pindah_angka_bc': '15', 'c1_30_pindah_rasio_bc': '3',
        'c1_30_rasional_atas': '3', 'c1_30_rasional_bawah': '3',
        'c1_30_hasil_bagi': '3', 'c1_30_hasil_akhir_angka': '5', 'c1_30_hasil_akhir_akar': '3'
    };

    const inputElements = Object.keys(kunciJawaban).map(id => document.getElementById(id));
    if (cekAdaKosong(inputElements)) {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Harap lengkapi semua kotak!', confirmButtonColor: '#198754' }); return;
    }

    attemptContoh1_30++;
    let semuaBenar = true;

    inputElements.forEach(input => {
        if (input) {
            input.classList.remove('is-valid', 'is-invalid', 'border-success', 'border-danger', 'text-success', 'text-danger');

            let isCorrect = false;
            let userVal = input.value.trim().toLowerCase();

            // Pengecekan khusus untuk sifat komutatif perkalian (1 x 15 atau 15 x 1)
            if (input.id === 'c1_30_pindah_rasio_ac' || input.id === 'c1_30_pindah_angka_bc') {
                let val1 = document.getElementById('c1_30_pindah_rasio_ac').value.trim();
                let val2 = document.getElementById('c1_30_pindah_angka_bc').value.trim();

                // Jika isinya '1' dan '15' ATAU '15' dan '1', keduanya dianggap BENAR
                if ((val1 === '1' && val2 === '15') || (val1 === '15' && val2 === '1')) {
                    isCorrect = true;
                }
            } else {
                // Pengecekan normal untuk input lainnya
                isCorrect = userVal === kunciJawaban[input.id];
            }

            if (isCorrect) {
                input.classList.add('is-valid', 'border-success', 'text-success');
            } else {
                input.classList.add('is-invalid', 'border-danger', 'text-danger');
                semuaBenar = false;
            }
        }
    });

    if (semuaBenar) {
        Swal.fire({ icon: 'success', title: '+15 Poin!', text: 'Langkah penyelesaian Contoh 1 (30-60-90) sudah benar.', confirmButtonColor: '#198754' })
            .then((res) => { if (res.isConfirmed && typeof updateProgress === 'function') updateProgress('materi_3_segitiga_istimewa', 'm3_cp3_contoh_2', 15); });
        document.getElementById('c1_30_feedback').innerText = "Jawaban Benar";
    } else {
        if (attemptContoh1_30 >= 3) {
            Swal.fire({ title: 'Kesempatan Habis', icon: 'error', showCancelButton: true, confirmButtonText: 'Tampilkan', confirmButtonColor: '#198754' })
                .then(res => {
                    if (res.isConfirmed) {
                        inputElements.forEach(input => {
                            input.value = kunciJawaban[input.id];
                            input.classList.remove('is-invalid', 'border-danger', 'text-danger');
                            input.classList.add('is-valid', 'border-success', 'text-success');
                        });
                        if (typeof updateProgress === 'function') updateProgress('materi_3_segitiga_istimewa', 'm3_cp3_contoh_2', 15);
                    }
                });
        } else {
            Swal.fire({ title: 'Kurang Tepat', text: `Masih ada yang salah. Sisa: ${3 - attemptContoh1_30} kali.`, icon: 'error', confirmButtonColor: '#dc3545' });
        }
    }
}

// ==========================================
// HALAMAN 3: AYO BERLATIH - SOAL 1
// ==========================================
let attemptSoal1 = 0;
const maxAttemptsLatihan = 3;

function cekSoal1() {
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
        's1_pecahan_ac': '10',
        's1_pindah_rasio_ab': '2',
        's1_pindah_angka_ac': '10',
        's1_pindah_rasio_ac': '1',
        's1_hasil_hitung_angka': '10',
        's1_hasil_hitung_akar': '2',
        's1_final_angka': '10',
        's1_final_akar': '2'
    };

    const inputElements = Object.keys(kunciJawaban).map(id => document.getElementById(id));
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
            text: 'Harap lengkapi semua kotak jawaban pada Soal 1!',
            confirmButtonColor: '#198754'
        });
        return;
    }

    attemptSoal1++;
    let semuaBenar = true;

    inputElements.forEach(input => {
        if (input) {
            input.classList.remove('is-valid', 'is-invalid', 'border-success', 'border-danger', 'text-success', 'text-danger');
            let userVal = input.value.trim().toLowerCase();
            let isCorrect = userVal === kunciJawaban[input.id].toLowerCase();

            if (isCorrect) {
                input.classList.add('is-valid', 'border-success', 'text-success');
            } else {
                input.classList.add('is-invalid', 'border-danger', 'text-danger');
                semuaBenar = false;
            }
        }
    });

    if (semuaBenar) {
        Swal.fire({
            icon: 'success',
            title: '+20 Poin!',
            text: 'Jawaban Latihan Soal 1 kamu sudah benar.',
            confirmButtonColor: '#198754'
        }).then((result) => {
            if (result.isConfirmed) {
                if (typeof updateProgress === 'function') {
                    updateProgress('materi_3_segitiga_istimewa', 'm3_cp4_latihan_1', 20);
                }
            }
        });
    } else {
        if (attemptSoal1 >= maxAttemptsLatihan) {
            Swal.fire({
                title: 'Kesempatan Habis',
                text: 'Masih ada jawaban yang kurang tepat. Ingin melihat jawaban yang benar?',
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Tampilkan Jawaban',
                cancelButtonText: 'Tutup',
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    inputElements.forEach(input => {
                        input.value = kunciJawaban[input.id];
                        input.classList.remove('is-invalid', 'border-danger', 'text-danger');
                        input.classList.add('is-valid', 'border-success', 'text-success');
                    });
                    if (typeof updateProgress === 'function') {
                        updateProgress('materi_3_segitiga_istimewa', 'm3_cp4_latihan_1', 20);
                    }
                }
            });
        } else {
            let sisa = maxAttemptsLatihan - attemptSoal1;
            Swal.fire({
                title: 'Kurang Tepat',
                text: `Masih ada kotak yang salah (warna merah). Sisa kesempatan: ${sisa} kali.`,
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
        }
    }
}

// ==========================================
// HALAMAN 3: AYO BERLATIH - SOAL 2
// ==========================================
let attemptSoal2 = 0;

function cekSoal2() {
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
        's2_pecahan_ef': '25',
        's2_pindah_rasio_eg': '1',
        's2_pindah_ef': '25',
        's2_pindah_rasio_ef': '2',
        's2_hasil_hitung_atas': '25',
        's2_hasil_hitung_bawah': '2',
        's2_final': '12.5'
    };

    const inputElements = Object.keys(kunciJawaban).map(id => document.getElementById(id));
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
            text: 'Harap lengkapi semua kotak jawaban pada Soal 2!',
            confirmButtonColor: '#198754'
        });
        return;
    }

    attemptSoal2++;
    let semuaBenar = true;

    inputElements.forEach(input => {
        if (input) {
            input.classList.remove('is-valid', 'is-invalid', 'border-success', 'border-danger', 'text-success', 'text-danger');

            let userVal = input.value.trim().toLowerCase().replace(',', '.');
            let isCorrect = userVal === kunciJawaban[input.id].toLowerCase();

            if (isCorrect) {
                input.classList.add('is-valid', 'border-success', 'text-success');
            } else {
                input.classList.add('is-invalid', 'border-danger', 'text-danger');
                semuaBenar = false;
            }
        }
    });

    if (semuaBenar) {
        Swal.fire({
            icon: 'success',
            title: '+20 Poin!',
            text: 'Jawaban Latihan Soal 2 kamu sangat akurat.',
            confirmButtonColor: '#198754'
        }).then((result) => {
            if (result.isConfirmed) {
                if (typeof updateProgress === 'function') {
                    updateProgress('materi_3_segitiga_istimewa', 'm3_cp5_latihan_2', 20);
                }
            }
        });
    } else {
        if (attemptSoal2 >= maxAttemptsLatihan) {
            Swal.fire({
                title: 'Kesempatan Habis',
                text: 'Masih ada jawaban yang kurang tepat. Ingin melihat jawaban yang benar?',
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Tampilkan Jawaban',
                cancelButtonText: 'Tutup',
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    inputElements.forEach(input => {
                        input.value = (input.id === 's2_final') ? '12,5' : kunciJawaban[input.id];
                        input.classList.remove('is-invalid', 'border-danger', 'text-danger');
                        input.classList.add('is-valid', 'border-success', 'text-success');
                    });
                    if (typeof updateProgress === 'function') {
                        updateProgress('materi_3_segitiga_istimewa', 'm3_cp5_latihan_2', 20);
                    }
                }
            });
        } else {
            let sisa = maxAttemptsLatihan - attemptSoal2;
            Swal.fire({
                title: 'Kurang Tepat',
                text: `Masih ada kotak yang salah (warna merah). Sisa kesempatan: ${sisa} kali.`,
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
        }
    }
}
// ==========================================
// HALAMAN 4: REFLEKSI (SEGITIGA ISTIMEWA)
// ==========================================
async function simpanRefleksiIstimewa() {
    const jawaban1 = document.getElementById('ref_istimewa_1').value.trim();
    const jawaban2 = document.getElementById('ref_istimewa_2').value.trim();

    // 1. Validasi
    if (jawaban1 === '' || jawaban2 === '') {
        Swal.fire({
            icon: 'warning',
            title: 'Belum Lengkap',
            text: 'Harap isi kedua kotak ceritamu terlebih dahulu ya.',
            confirmButtonColor: '#ffc107'
        });
        return;
    }

    // 2. Siapkan Payload JSON
    const dataRefleksi = {
        kode_materi: 'materi_3_segitiga_istimewa',
        pemahaman_perbandingan: jawaban1,
        ide_penerapan: jawaban2
    };

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Animasi tombol loading
        const btnSubmit = document.querySelector('button[onclick="simpanRefleksiIstimewa()"]');
        const originalText = btnSubmit.innerText;
        btnSubmit.innerText = "Menyimpan...";
        btnSubmit.disabled = true;

        // 3. Kirim ke Backend
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

        // 4. Jika Sukses
        if (response.ok) {
            Swal.fire({
                icon: 'success',
                title: '+10 Poin!',
                text: 'Terima kasih atas refleksimu! Kamu sudah menyelesaikan seluruh materi Segitiga Istimewa.',
                confirmButtonColor: '#198754'
            }).then(() => {
                // Kunci form dan update progress setelah SweetAlert ditutup
                kunciFormRefleksiIstimewa();
                if (typeof updateProgress === 'function') {
                    updateProgress('materi_3_segitiga_istimewa', 'm3_cp6_refleksi', 10);
                }
            });
        } else {
            Swal.fire({ icon: 'error', title: 'Gagal', text: result.message || 'Terjadi kesalahan sistem.', confirmButtonColor: '#dc3545' });
            btnSubmit.innerText = originalText;
            btnSubmit.disabled = false;
        }

    } catch (error) {
        console.error('Error:', error);
        Swal.fire({ icon: 'error', title: 'Koneksi Terputus', text: 'Gagal terhubung ke server. Periksa jaringanmu.', confirmButtonColor: '#dc3545' });

        const btnSubmit = document.querySelector('button[onclick="simpanRefleksiIstimewa()"]');
        if (btnSubmit) {
            btnSubmit.innerText = "Simpan Refleksi";
            btnSubmit.disabled = false;
        }
    }
}

// Fungsi Helper untuk mengunci input
function kunciFormRefleksiIstimewa() {
    ['ref_istimewa_1', 'ref_istimewa_2'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.disabled = true;
            el.classList.add('is-valid'); // Hapus 'border-success' jika mau seragam dengan M1 & M2
        }
    });

    const btn = document.querySelector('button[onclick="simpanRefleksiIstimewa()"]');
    if (btn) {
        btn.disabled = true;
        btn.innerText = "Refleksi Tersimpan";
    }
}

/* =====================================================
   AKTIFASI MODE REVIEW UNTUK MATERI 3 (FULL)
===================================================== */
document.addEventListener('DOMContentLoaded', function () {

    if (typeof window.setupReviewMode === 'function') {

        // 1. Ayo Mengamati (Tabel 45-45-90)
        window.setupReviewMode('m3_cp1_ayo_mengamati', 'button[onclick="cekTab45()"]',
            function () {
                const ans = {
                    'bc2': '2', 'bc3': '3', 'bc4': '4', 'bc5': '5', 'bc6': '6', 'bcp': 'p',
                    'h2_a': '2', 'h2_b': '2', 'h3_a': '3', 'h3_b': '2',
                    'h4_a': '4', 'h4_b': '2', 'h5_a': '5', 'h5_b': '2',
                    'h6_a': '6', 'h6_b': '2', 'h7_a': 'p', 'h7_b': '2'
                };
                for (let id in ans) {
                    let el = document.getElementById(id);
                    if (el) { el.value = ans[id]; el.classList.add('is-valid'); el.disabled = true; }
                }

                if (document.getElementById('tab45_feedback')) {
                    document.getElementById('tab45_feedback').innerHTML = `
                        <div class="alert mt-3 mb-0 small text-start border-success shadow-sm">
                            Berdasarkan pola pada tabel di atas, dapat dilihat bahwa panjang sisi miring (hipotenusa) selalu 
                            <strong>\\( \\text{panjang sisi siku-siku} \\times \\sqrt{2} \\)</strong>. 
                            Hal ini membuktikan bahwa perbandingan panjang sisi-sisi pada segitiga siku-siku sama kaki 
                            (sudut \\(45^\\circ\\)-\\(45^\\circ\\)-\\(90^\\circ\\)) akan selalu memiliki pola tetap, yaitu 
                            <strong>\\( 1 : 1 : \\sqrt{2} \\)</strong>.
                        </div>
                    `;

                    MathJax.typesetPromise();
                }
            },
            function () {
                const ids = ['bc2', 'bc3', 'bc4', 'bc5', 'bc6', 'bcp', 'h2_a', 'h2_b', 'h3_a', 'h3_b', 'h4_a', 'h4_b', 'h5_a', 'h5_b', 'h6_a', 'h6_b', 'h7_a', 'h7_b'];
                ids.forEach(id => {
                    let el = document.getElementById(id);
                    if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid'); el.disabled = false; }
                });

                if (document.getElementById('tab45_feedback')) document.getElementById('tab45_feedback').innerHTML = '';
            }
        );

        // 2. Contoh 1
        window.setupReviewMode('m3_cp2_contoh_1', 'button[onclick="cekContoh1Interaktif()"]',
            function () {
                const ans = {
                    'c1i_dik_ab': '15\\sqrt{2}', 'c1i_dik_sudut': '45', 'c1i_rasio_45_1': '1', 'c1i_rasio_45_2': '1', 'c1i_rasio_90': '2',
                    'c1i_perbandingan_atas': '1', 'c1i_perbandingan_bawah': '2', 'c1i_pecahan_rasio_ac': '1',
                    'c1i_pecahan_rasio_ab': '2', 'c1i_pecahan_ab_angka': '15', 'c1i_ks_rasio_ab': '2', 'c1i_ks_rasio_ac': '1',
                    'c1i_kali_silang_angka': '15', 'c1i_pindah_atas': '15', 'c1i_pindah_bawah': '2', 'c1i_hasil_hitung': '15',
                    'c1i_hasil_akhir': '15'
                };
                for (let id in ans) {
                    let el = document.getElementById(id);
                    if (el) { el.value = ans[id]; el.classList.add('is-valid', 'border-success', 'text-success'); el.disabled = true; }
                }
                if (document.getElementById('c1i_feedback')) {
                    document.getElementById('c1i_feedback').innerHTML = '<span class="text-success fw-bold">Penyelesaian Selesai.</span>';
                }
            },
            function () {
                const ids = ['c1i_dik_ab', 'c1i_dik_sudut', 'c1i_rasio_45_1', 'c1i_rasio_45_2', 'c1i_rasio_90', 'c1i_perbandingan_atas', 'c1i_perbandingan_bawah', 'c1i_pecahan_rasio_ac', 'c1i_pecahan_rasio_ab', 'c1i_pecahan_ab_angka', 'c1i_ks_rasio_ab', 'c1i_ks_rasio_ac', 'c1i_kali_silang_angka', 'c1i_pindah_atas', 'c1i_pindah_bawah', 'c1i_hasil_hitung', 'c1i_hasil_akhir'];
                ids.forEach(id => {
                    let el = document.getElementById(id);
                    if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid', 'border-success', 'text-success', 'border-danger', 'text-danger'); el.disabled = false; }
                });
                if (document.getElementById('c1i_feedback')) document.getElementById('c1i_feedback').innerHTML = '';
            }
        );

        // Setup Contoh 2 (45-45-90)
        window.setupReviewMode('m3_cp_contoh_2_45', 'button[onclick="cekContoh2_45()"]',
            function () {
                const ans = {
                    'c2_45_dik_ac': '20', 'c2_45_dik_sudut': '45', 'c2_45_rasio_45_1': '1', 'c2_45_rasio_45_2': '1', 'c2_45_rasio_90': '2',
                    'c2_45_perbandingan_atas': '2', 'c2_45_perbandingan_bawah': '1',
                    'c2_45_sub_ac': '20', 'c2_45_sub_rasio_ab': '2', 'c2_45_sub_rasio_ac': '1',
                    'c2_45_pecahan_ac': '20', 'c2_45_pecahan_rasio_ab': '2', 'c2_45_pecahan_rasio_ac': '1',
                    'c2_45_pindah_rasio_ab': '2', 'c2_45_pindah_angka_ac': '20', 'c2_45_pindah_rasio_ac': '1',
                    'c2_45_ras_val_atas': '20', 'c2_45_ras_val_bawah': '2',
                    'c2_45_rasionalkan_atas': '2', 'c2_45_rasionalkan_bawah': '2',
                    'c2_45_hasil_pembilang_angka': '20', 'c2_45_hasil_pembilang_akar': '2', 'c2_45_hasil_penyebut': '2',
                    'c2_45_hasil_akhir_angka': '10', 'c2_45_hasil_akhir_akar': '2'
                };
                for (let id in ans) {
                    let el = document.getElementById(id);
                    if (el) { el.value = ans[id]; el.classList.add('is-valid', 'border-success', 'text-success'); el.disabled = true; }
                }
            },
            function () {
                const ids = Object.keys(ans);
                ids.forEach(id => {
                    let el = document.getElementById(id);
                    if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid', 'border-success', 'text-success', 'border-danger', 'text-danger'); el.disabled = false; }
                });
            }
        );

        // Setup Contoh 1 (30-60-90)
        // Setup Contoh 1 (30-60-90)
        window.setupReviewMode('m3_cp3_contoh_2', 'button[onclick="cekContoh1_30()"]',
            function () {
                const ans = {
                    'c1_30_dik_bc': '15', 'c1_30_dik_sudut': '30', 'c1_30_dik_siku': 'C',
                    'c1_30_rasio_30': '1', 'c1_30_rasio_60': '3', 'c1_30_rasio_90': '2',
                    'c1_30_perbandingan_atas': '1', 'c1_30_perbandingan_bawah': '3',
                    'c1_30_sub_bc': '15', 'c1_30_sub_rasio_ac': '1', 'c1_30_sub_rasio_bc': '3',
                    'c1_30_pecahan_bc': '15', 'c1_30_pecahan_rasio_ac': '1', 'c1_30_pecahan_rasio_bc': '3',
                    'c1_30_pindah_rasio_ac': '1', 'c1_30_pindah_angka_bc': '15', 'c1_30_pindah_rasio_bc': '3',
                    'c1_30_rasional_atas': '3', 'c1_30_rasional_bawah': '3',
                    'c1_30_hasil_bagi': '3', 'c1_30_hasil_akhir_angka': '5', 'c1_30_hasil_akhir_akar': '3'
                };
                for (let id in ans) {
                    let el = document.getElementById(id);
                    if (el) { el.value = ans[id]; el.classList.add('is-valid', 'border-success', 'text-success'); el.disabled = true; }
                }
            },
            function () {
                // PERBAIKAN: Definisikan manual id kotak inputnya
                const ids = [
                    'c1_30_dik_bc', 'c1_30_dik_sudut', 'c1_30_dik_siku', 'c1_30_rasio_30',
                    'c1_30_rasio_60', 'c1_30_rasio_90', 'c1_30_perbandingan_atas', 'c1_30_perbandingan_bawah',
                    'c1_30_sub_bc', 'c1_30_sub_rasio_ac', 'c1_30_sub_rasio_bc', 'c1_30_pecahan_bc',
                    'c1_30_pecahan_rasio_ac', 'c1_30_pecahan_rasio_bc', 'c1_30_pindah_rasio_ac',
                    'c1_30_pindah_angka_bc', 'c1_30_pindah_rasio_bc', 'c1_30_rasional_atas',
                    'c1_30_rasional_bawah', 'c1_30_hasil_bagi', 'c1_30_hasil_akhir_angka', 'c1_30_hasil_akhir_akar'
                ];
                ids.forEach(id => {
                    let el = document.getElementById(id);
                    if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid', 'border-success', 'text-success', 'border-danger', 'text-danger'); el.disabled = false; }
                });

                // Reset counter percobaan agar siswa mendapat 3 kesempatan lagi
                attemptContoh1_30 = 0;
            }
        );

        // 4. Ayo Berlatih - Soal 1
        window.setupReviewMode('m3_cp4_latihan_1', 'button[onclick="cekSoal1()"]',
            function () {
                const ans = {
                    's1_dik_c': '90', 's1_dik_a': '45', 's1_dik_ac': '10', 's1_ditanya': 'AB',
                    's1_rasio_45_1': '1', 's1_rasio_45_2': '1', 's1_rasio_90': '2', 's1_perbandingan_atas': '2',
                    's1_perbandingan_bawah': '1', 's1_pecahan_rasio_ab': '2', 's1_pecahan_rasio_ac': '1', 's1_pecahan_ac': '10',
                    's1_pindah_rasio_ab': '2', 's1_pindah_angka_ac': '10', 's1_pindah_rasio_ac': '1', 's1_hasil_hitung_angka': '10',
                    's1_hasil_hitung_akar': '2', 's1_final_angka': '10', 's1_final_akar': '2'
                };
                for (let id in ans) {
                    let el = document.getElementById(id);
                    if (el) { el.value = ans[id]; el.classList.add('is-valid', 'border-success', 'text-success'); el.disabled = true; }
                }
                if (document.getElementById('s1_feedback')) document.getElementById('s1_feedback').innerHTML = '<span class="text-success fw-bold">Jawaban Latihan Benar.</span>';
            },
            function () {
                const ids = ['s1_dik_c', 's1_dik_a', 's1_dik_ac', 's1_ditanya', 's1_rasio_45_1', 's1_rasio_45_2', 's1_rasio_90', 's1_perbandingan_atas', 's1_perbandingan_bawah', 's1_pecahan_rasio_ab', 's1_pecahan_rasio_ac', 's1_pecahan_ac', 's1_pindah_rasio_ab', 's1_pindah_angka_ac', 's1_pindah_rasio_ac', 's1_hasil_hitung_angka', 's1_hasil_hitung_akar', 's1_final_angka', 's1_final_akar'];
                ids.forEach(id => {
                    let el = document.getElementById(id);
                    if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid', 'border-success', 'text-success', 'border-danger', 'text-danger'); el.disabled = false; }
                });
                if (document.getElementById('s1_feedback')) document.getElementById('s1_feedback').innerHTML = '';
            }
        );

        // 5. Ayo Berlatih - Soal 2
        window.setupReviewMode('m3_cp5_latihan_2', 'button[onclick="cekSoal2()"]',
            function () {
                const ans = {
                    's2_dik_ef': '25', 's2_dik_e': '60', 's2_dik_siku': 'G', 's2_ditanya': 'EG',
                    's2_rasio_30': '1', 's2_rasio_60': '3', 's2_rasio_90': '2', 's2_perbandingan_atas': '1',
                    's2_perbandingan_bawah': '2', 's2_pecahan_rasio_eg': '1', 's2_pecahan_rasio_ef': '2', 's2_pecahan_ef': '25',
                    's2_pindah_rasio_eg': '1', 's2_pindah_ef': '25', 's2_pindah_rasio_ef': '2', 's2_hasil_hitung_atas': '25',
                    's2_hasil_hitung_bawah': '2', 's2_final': '12,5'
                };
                for (let id in ans) {
                    let el = document.getElementById(id);
                    if (el) { el.value = ans[id]; el.classList.add('is-valid', 'border-success', 'text-success'); el.disabled = true; }
                }
                if (document.getElementById('s2_feedback')) document.getElementById('s2_feedback').innerHTML = '<span class="text-success fw-bold">Jawaban Latihan Benar.</span>';
            },
            function () {
                const ids = ['s2_dik_ef', 's2_dik_e', 's2_dik_siku', 's2_ditanya', 's2_rasio_30', 's2_rasio_60', 's2_rasio_90', 's2_perbandingan_atas', 's2_perbandingan_bawah', 's2_pecahan_rasio_eg', 's2_pecahan_rasio_ef', 's2_pecahan_ef', 's2_pindah_rasio_eg', 's2_pindah_ef', 's2_pindah_rasio_ef', 's2_hasil_hitung_atas', 's2_hasil_hitung_bawah', 's2_final'];
                ids.forEach(id => {
                    let el = document.getElementById(id);
                    if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid', 'border-success', 'text-success', 'border-danger', 'text-danger'); el.disabled = false; }
                });
                if (document.getElementById('s2_feedback')) document.getElementById('s2_feedback').innerHTML = '';
            }
        );

        // 6. Refleksi Review Mode
        window.setupReviewMode(
            'm3_cp6_refleksi',
            'button[onclick="simpanRefleksiIstimewa()"]',
            function () {
                // Panggil fungsi kunci saat status sudah 'completed'
                kunciFormRefleksiIstimewa();
            },
            function () {
                // Reset form jika di-restart
                ['ref_istimewa_1', 'ref_istimewa_2'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) { el.disabled = false; el.value = ''; el.classList.remove('is-valid'); }
                });

                const btn = document.querySelector('button[onclick="simpanRefleksiIstimewa()"]');
                if (btn) {
                    btn.disabled = false;
                    btn.innerText = "Simpan Refleksi";
                }
            }
        );

    }
});