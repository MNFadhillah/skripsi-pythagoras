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
            title: 'Kerja Bagus!',
            text: 'Kamu berhasil menemukan pola hubungan sisi-sisi pada segitiga siku-siku sama kaki.',
            confirmButtonColor: '#198754'
        }).then((result) => {
            if (result.isConfirmed) {
                // SIMPAN PROGRESS: Materi 3 - CP 1
                if (typeof updateProgress === 'function') {
                    updateProgress('materi_3_segitiga_istimewa', 'm3_cp1_ayo_mengamati');
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
// HALAMAN 3: CONTOH SOAL 1
// ==========================================
let attemptContoh1 = 0;
const maxAttempts1 = 3;

function cekContoh1Interaktif() {
    const kunciJawaban = {
        'c1i_dik_sudut': '45',
        'c1i_rasio_45_1': '1',
        'c1i_rasio_45_2': '1',
        'c1i_rasio_90': '2',
        'c1i_perbandingan_atas': '1',
        'c1i_perbandingan_bawah': '2',
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
            text: 'Harap lengkapi semua kotak jawaban pada Contoh 1!',
            confirmButtonColor: '#198754'
        });
        return;
    }

    attemptContoh1++;
    let semuaBenar = true;

    inputElements.forEach(input => {
        if (input) {
            input.classList.remove('is-valid', 'is-invalid', 'border-success', 'border-danger', 'text-success', 'text-danger');
            let isCorrect = false;

            if (input.id === 'c1i_dik_ab') {
                let cleanVal = input.value.replace(/[\s\\{}]/g, '').toLowerCase();
                if (cleanVal === '15sqrt2' || cleanVal === '15akar2' || cleanVal === '15') {
                    isCorrect = true;
                }
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
        Swal.fire({
            icon: 'success',
            title: 'Tepat Sekali!',
            text: 'Langkah penyelesaian Contoh 1 sudah benar.',
            confirmButtonColor: '#198754'
        }).then((result) => {
            if (result.isConfirmed) {
                if (typeof updateProgress === 'function') {
                    updateProgress('materi_3_segitiga_istimewa', 'm3_cp2_contoh_1');
                }
            }
        });
    } else {
        if (attemptContoh1 >= maxAttempts1) {
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
                        input.value = (input.id === 'c1i_dik_ab') ? '15\\sqrt{2}' : kunciJawaban[input.id];
                        input.classList.remove('is-invalid', 'border-danger', 'text-danger');
                        input.classList.add('is-valid', 'border-success', 'text-success');
                    });
                    if (typeof updateProgress === 'function') {
                        updateProgress('materi_3_segitiga_istimewa', 'm3_cp2_contoh_1');
                    }
                }
            });
        } else {
            let sisa = maxAttempts1 - attemptContoh1;
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
// HALAMAN 3: CONTOH SOAL 2
// ==========================================
let attemptContoh2 = 0;

function cekContoh2Istimewa() {
    const kunciJawaban = {
        'c2_dik_bc': '15',
        'c2_dik_sudut': '30',
        'c2_dik_siku': 'c', // Toleransi huruf kecil C
        'c2_rasio_30': '1',
        'c2_rasio_60': '3',
        'c2_rasio_90': '2',
        'c2_perbandingan_atas': '1',
        'c2_perbandingan_bawah': '3',
        'c2_sub_bc_angka': '15',
        'c2_sub_rasio_ac': '1',
        'c2_sub_rasio_bc': '3',
        'c2_pecahan_bc_angka': '15',
        'c2_pecahan_rasio_ac': '1',
        'c2_pecahan_rasio_bc': '3',
        'c2_ks_rasio_bc': '3',
        'c2_ks_rasio_ac': '1',
        'c2_kali_silang_angka': '15',
        'c2_pindah_atas': '15',
        'c2_pindah_bawah': '3',
        'c2_hasil_hitung_angka': '5',
        'c2_hasil_hitung_akar': '3',
        'c2_hasil_akhir_angka': '5',
        'c2_hasil_akhir_akar': '3'
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
            text: 'Harap lengkapi semua kotak jawaban pada Contoh Soal 2!',
            confirmButtonColor: '#198754'
        });
        return;
    }

    attemptContoh2++;
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
            title: 'Luar Biasa!',
            text: 'Langkah penyelesaian Contoh 2 sudah benar seluruhnya.',
            confirmButtonColor: '#198754'
        }).then((result) => {
            if (result.isConfirmed) {
                if (typeof updateProgress === 'function') {
                    updateProgress('materi_3_segitiga_istimewa', 'm3_cp3_contoh_2');
                }
            }
        });
    } else {
        if (attemptContoh2 >= maxAttempts1) {
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
                        updateProgress('materi_3_segitiga_istimewa', 'm3_cp3_contoh_2');
                    }
                }
            });
        } else {
            let sisa = maxAttempts1 - attemptContoh2;
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
            title: 'Tepat Sekali!',
            text: 'Jawaban Latihan Soal 1 kamu sudah benar.',
            confirmButtonColor: '#198754'
        }).then((result) => {
            if (result.isConfirmed) {
                if (typeof updateProgress === 'function') {
                    updateProgress('materi_3_segitiga_istimewa', 'm3_cp4_latihan_1');
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
                        updateProgress('materi_3_segitiga_istimewa', 'm3_cp4_latihan_1');
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
            title: 'Hebat!',
            text: 'Jawaban Latihan Soal 2 kamu sangat akurat.',
            confirmButtonColor: '#198754'
        }).then((result) => {
            if (result.isConfirmed) {
                if (typeof updateProgress === 'function') {
                    updateProgress('materi_3_segitiga_istimewa', 'm3_cp5_latihan_2');
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
                        updateProgress('materi_3_segitiga_istimewa', 'm3_cp5_latihan_2');
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
// HALAMAN 4: REFLEKSI
// ==========================================
function simpanRefleksiIstimewa() {
    let jawaban1 = document.getElementById('ref_istimewa_1').value;
    let jawaban2 = document.getElementById('ref_istimewa_2').value;
    
    if (jawaban1.trim() === '' || jawaban2.trim() === '') {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Harap isi kedua kolom refleksi terlebih dahulu ya.',
            confirmButtonColor: '#198754'
        });
    } else {
        Swal.fire({
            icon: 'success',
            title: 'Refleksi Tersimpan',
            text: 'Terima kasih atas refleksimu! Kamu sudah menyelesaikan seluruh materi Segitiga Istimewa.',
            confirmButtonColor: '#198754'
        }).then((result) => {
            if (result.isConfirmed) {
                if (typeof updateProgress === 'function') {
                    updateProgress('materi_3_segitiga_istimewa', 'm3_cp6_refleksi');
                }
            }
        });
    }
}

/* =====================================================
   AKTIFASI MODE REVIEW UNTUK MATERI 3 (FULL)
===================================================== */
document.addEventListener('DOMContentLoaded', function () {
    
    if (typeof window.setupReviewMode === 'function') {

        // 1. Ayo Mengamati (Tabel 45-45-90)
        window.setupReviewMode('m3_cp1_ayo_mengamati', 'button[onclick="cekTab45()"]',
            function() {
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
                
                if(document.getElementById('tab45_feedback')) {
                    document.getElementById('tab45_feedback').innerHTML = `
                        <div class="alert mt-3 mb-0 small text-start border-success shadow-sm">
                            Berdasarkan pola pada tabel di atas, dapat dilihat bahwa panjang sisi miring (hipotenusa) selalu <strong>panjang sisi siku-siku dikali &radic;2</strong>. Hal ini membuktikan bahwa perbandingan panjang sisi-sisi pada segitiga siku-siku sama kaki (sudut 45&deg;-45&deg;-90&deg;) akan selalu memiliki pola tetap, yaitu <strong>1 : 1 : &radic;2</strong>.
                        </div>
                    `;
                }
            },
            function() {
                const ids = ['bc2', 'bc3', 'bc4', 'bc5', 'bc6', 'bcp', 'h2_a', 'h2_b', 'h3_a', 'h3_b', 'h4_a', 'h4_b', 'h5_a', 'h5_b', 'h6_a', 'h6_b', 'h7_a', 'h7_b'];
                ids.forEach(id => {
                    let el = document.getElementById(id); 
                    if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid'); el.disabled = false; }
                });
                
                if(document.getElementById('tab45_feedback')) document.getElementById('tab45_feedback').innerHTML = '';
            }
        );

        // 2. Contoh 1
        window.setupReviewMode('m3_cp2_contoh_1', 'button[onclick="cekContoh1Interaktif()"]',
            function() {
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
                if(document.getElementById('c1i_feedback')) {
                    document.getElementById('c1i_feedback').innerHTML = '<span class="text-success fw-bold">Penyelesaian Selesai.</span>';
                }
            },
            function() {
                const ids = ['c1i_dik_ab', 'c1i_dik_sudut', 'c1i_rasio_45_1', 'c1i_rasio_45_2', 'c1i_rasio_90', 'c1i_perbandingan_atas', 'c1i_perbandingan_bawah', 'c1i_pecahan_rasio_ac', 'c1i_pecahan_rasio_ab', 'c1i_pecahan_ab_angka', 'c1i_ks_rasio_ab', 'c1i_ks_rasio_ac', 'c1i_kali_silang_angka', 'c1i_pindah_atas', 'c1i_pindah_bawah', 'c1i_hasil_hitung', 'c1i_hasil_akhir'];
                ids.forEach(id => {
                    let el = document.getElementById(id); 
                    if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid', 'border-success', 'text-success', 'border-danger', 'text-danger'); el.disabled = false; }
                });
                if(document.getElementById('c1i_feedback')) document.getElementById('c1i_feedback').innerHTML = '';
            }
        );

        // 3. Contoh 2 
        window.setupReviewMode('m3_cp3_contoh_2', 'button[onclick="cekContoh2Istimewa()"]',
            function() {
                const ans = {
                    'c2_dik_bc': '15', 'c2_dik_sudut': '30', 'c2_dik_siku': 'C', 'c2_rasio_30': '1', 'c2_rasio_60': '3',
                    'c2_rasio_90': '2', 'c2_perbandingan_atas': '1', 'c2_perbandingan_bawah': '3', 'c2_sub_bc_angka': '15',
                    'c2_sub_rasio_ac': '1', 'c2_sub_rasio_bc': '3', 'c2_pecahan_bc_angka': '15', 'c2_pecahan_rasio_ac': '1',
                    'c2_pecahan_rasio_bc': '3', 'c2_ks_rasio_bc': '3', 'c2_ks_rasio_ac': '1', 'c2_kali_silang_angka': '15',
                    'c2_pindah_atas': '15', 'c2_pindah_bawah': '3', 'c2_hasil_hitung_angka': '5', 'c2_hasil_hitung_akar': '3',
                    'c2_hasil_akhir_angka': '5', 'c2_hasil_akhir_akar': '3'
                };
                for (let id in ans) { 
                    let el = document.getElementById(id); 
                    if (el) { el.value = ans[id]; el.classList.add('is-valid', 'border-success', 'text-success'); el.disabled = true; } 
                }
                if(document.getElementById('c2_feedback')) {
                    document.getElementById('c2_feedback').innerHTML = '<span class="text-success fw-bold">Penyelesaian Selesai.</span>';
                }
            },
            function() {
                const ids = ['c2_dik_bc', 'c2_dik_sudut', 'c2_dik_siku', 'c2_rasio_30', 'c2_rasio_60', 'c2_rasio_90', 'c2_perbandingan_atas', 'c2_perbandingan_bawah', 'c2_sub_bc_angka', 'c2_sub_rasio_ac', 'c2_sub_rasio_bc', 'c2_pecahan_bc_angka', 'c2_pecahan_rasio_ac', 'c2_pecahan_rasio_bc', 'c2_ks_rasio_bc', 'c2_ks_rasio_ac', 'c2_kali_silang_angka', 'c2_pindah_atas', 'c2_pindah_bawah', 'c2_hasil_hitung_angka', 'c2_hasil_hitung_akar', 'c2_hasil_akhir_angka', 'c2_hasil_akhir_akar'];
                ids.forEach(id => {
                    let el = document.getElementById(id); 
                    if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid', 'border-success', 'text-success', 'border-danger', 'text-danger'); el.disabled = false; }
                });
                if(document.getElementById('c2_feedback')) document.getElementById('c2_feedback').innerHTML = '';
            }
        );

        // 4. Ayo Berlatih - Soal 1
        window.setupReviewMode('m3_cp4_latihan_1', 'button[onclick="cekSoal1()"]',
            function() {
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
                if(document.getElementById('s1_feedback')) document.getElementById('s1_feedback').innerHTML = '<span class="text-success fw-bold">Jawaban Latihan Benar.</span>';
            },
            function() {
                const ids = ['s1_dik_c', 's1_dik_a', 's1_dik_ac', 's1_ditanya', 's1_rasio_45_1', 's1_rasio_45_2', 's1_rasio_90', 's1_perbandingan_atas', 's1_perbandingan_bawah', 's1_pecahan_rasio_ab', 's1_pecahan_rasio_ac', 's1_pecahan_ac', 's1_pindah_rasio_ab', 's1_pindah_angka_ac', 's1_pindah_rasio_ac', 's1_hasil_hitung_angka', 's1_hasil_hitung_akar', 's1_final_angka', 's1_final_akar'];
                ids.forEach(id => {
                    let el = document.getElementById(id); 
                    if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid', 'border-success', 'text-success', 'border-danger', 'text-danger'); el.disabled = false; }
                });
                if(document.getElementById('s1_feedback')) document.getElementById('s1_feedback').innerHTML = '';
            }
        );

        // 5. Ayo Berlatih - Soal 2
        window.setupReviewMode('m3_cp5_latihan_2', 'button[onclick="cekSoal2()"]',
            function() {
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
                if(document.getElementById('s2_feedback')) document.getElementById('s2_feedback').innerHTML = '<span class="text-success fw-bold">Jawaban Latihan Benar.</span>';
            },
            function() {
                const ids = ['s2_dik_ef', 's2_dik_e', 's2_dik_siku', 's2_ditanya', 's2_rasio_30', 's2_rasio_60', 's2_rasio_90', 's2_perbandingan_atas', 's2_perbandingan_bawah', 's2_pecahan_rasio_eg', 's2_pecahan_rasio_ef', 's2_pecahan_ef', 's2_pindah_rasio_eg', 's2_pindah_ef', 's2_pindah_rasio_ef', 's2_hasil_hitung_atas', 's2_hasil_hitung_bawah', 's2_final'];
                ids.forEach(id => {
                    let el = document.getElementById(id); 
                    if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid', 'border-success', 'text-success', 'border-danger', 'text-danger'); el.disabled = false; }
                });
                if(document.getElementById('s2_feedback')) document.getElementById('s2_feedback').innerHTML = '';
            }
        );

        // 6. Refleksi
        window.setupReviewMode('m3_cp6_refleksi', 'button[onclick="simpanRefleksiIstimewa()"]',
            function() {
                ['ref_istimewa_1', 'ref_istimewa_2'].forEach(id => {
                    const el = document.getElementById(id); 
                    if (el) { el.disabled = true; el.classList.add('is-valid', 'border-success'); }
                });
            },
            function() {
                ['ref_istimewa_1', 'ref_istimewa_2'].forEach(id => {
                    const el = document.getElementById(id); 
                    if (el) { el.disabled = false; el.value = ''; el.classList.remove('is-valid', 'border-success'); }
                });
            }
        );

    }
});