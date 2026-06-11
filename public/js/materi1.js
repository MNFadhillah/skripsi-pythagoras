/* =====================================================
   1. NAVIGASI HALAMAN & SIDEBAR (MATERI 1)
===================================================== */
document.addEventListener('DOMContentLoaded', function () {
    const pages = document.querySelectorAll('.materi-page');
    const prevBtns = document.querySelectorAll('.prev-btn');
    const nextBtns = document.querySelectorAll('.next-btn');
    const pageBtns = document.querySelectorAll('.page-btn');
    const pageBtnsBottom = document.querySelectorAll('.page-btn-bottom');
    const savedPage = localStorage.getItem('materiPage1');

    let currentPage = 0;
    const totalPages = pages.length;

    function showPage(index) {
        if (index < 0 || index >= totalPages) return;

        pages.forEach(p => p.classList.add('d-none'));
        pages[index].classList.remove('d-none');

        currentPage = index;
        localStorage.setItem('materiPage1', index);

        const updateActiveBtn = (btns) => {
            btns.forEach(btn => {
                btn.parentElement.classList.remove('active');
                if (parseInt(btn.dataset.page) === index) btn.parentElement.classList.add('active');
            });
        };
        updateActiveBtn(pageBtns);
        if (pageBtnsBottom) updateActiveBtn(pageBtnsBottom);

        prevBtns.forEach(btn => {
            btn.disabled = (index === 0);
            btn.parentElement.classList.toggle('disabled', index === 0);
        });

        nextBtns.forEach(btn => {
            btn.disabled = (index === totalPages - 1);
            btn.parentElement.classList.toggle('disabled', index === totalPages - 1);
        });

        window.scrollTo({ top: 0, behavior: 'smooth' });
        initPageSpecificCode(index);
    }

    function initPageSpecificCode(pageIndex) {
        switch (pageIndex) {
            case 0:
                if (typeof initDragAndDropPage1 === 'function') initDragAndDropPage1();
                break;
            case 1:
                if (typeof initPageKuadrat === 'function') initPageKuadrat();
                if (typeof initPageAkar === 'function') initPageAkar();
                break;
            case 2:
                if (typeof initPage2 === 'function') initPage2();
                break;
            case 3:
                if (typeof initPage3 === 'function') initPage3();
                break;
            case 4:
                if (typeof initDragDropSoal3 === 'function') initDragDropSoal3();
                break;
        }
    }

    [pageBtns, pageBtnsBottom].forEach(btns => {
        if (btns) {
            btns.forEach(btn => {
                btn.addEventListener('click', () => showPage(parseInt(btn.dataset.page)));
            });
        }
    });

    prevBtns.forEach(btn => btn.addEventListener('click', () => showPage(currentPage - 1)));
    nextBtns.forEach(btn => btn.addEventListener('click', () => showPage(currentPage + 1)));

    const attachNav = (id, isNext) => {
        const btn = document.getElementById(id);
        if (btn) btn.addEventListener('click', () => showPage(isNext ? currentPage + 1 : currentPage - 1));
    };
    attachNav('nextPage', true);
    attachNav('nextPageBottom', true);
    attachNav('prevPage', false);
    attachNav('prevPageBottom', false);

    showPage(savedPage ? parseInt(savedPage) : 0);

    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('mainSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const body = document.body;

    if (toggleBtn) {
        toggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            if (window.innerWidth >= 992) body.classList.toggle('sidebar-closed');
            else {
                if (sidebar) sidebar.classList.toggle('active');
                if (overlay) overlay.classList.toggle('active');
            }
        });
    }
    if (overlay) {
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    }

    let cekSoal3 = document.getElementById('soal3_c2');
    if (cekSoal3) {
        cekSoal3.value = 225;
        document.getElementById('soal3_a2').value = 81;
        document.getElementById('soal3_b2').value = 144;
        document.getElementById('soal3_c2_val').value = 225;
        document.getElementById('soal3_a2_val').value = 81;
        document.getElementById('soal3_b2_val').value = 144;
    }
});

function simpanProgressMateri1(checkpointCode, points = 0, isSilent = true) {
    if (typeof window.updateProgress === 'function') {
        return window.updateProgress(
            'materi_1_konsep_pythagoras',
            checkpointCode,
            points,
            isSilent
        );
    }

    console.warn('window.updateProgress belum tersedia. Pastikan script.js global sudah dimuat.');
    return Promise.resolve();
}

function selesaikanAktivitasMateri1(buttonSelector, resetCallback) {
    if (typeof window.tampilkanLatihanSelesai === 'function') {
        window.tampilkanLatihanSelesai(buttonSelector, resetCallback);
    }
}

function selesaikanKesempatanHabisMateri1(checkpointCode, buttonSelector, resetCallback) {
    simpanProgressMateri1(checkpointCode, 0);

    selesaikanAktivitasMateri1(
        buttonSelector,
        resetCallback
    );
}

function sedangUlangLatihanMateri1(buttonSelector) {
    const btn = document.querySelector(buttonSelector);
    return !!(btn && btn.getAttribute('data-latihan-ulang') === 'true');
}

function swalLatihanMateri1(buttonSelector, options) {
    const isUlang = sedangUlangLatihanMateri1(buttonSelector);
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


/* =====================================================
   MATERI 1: VISUAL JEMBATAN DAN TAMPILAN TEKS
===================================================== */

function showPart(id) {
    // 1. Tampilkan label target (jangan sembunyikan yang lain)
    const target = document.getElementById(id);
    if (target) {
        target.classList.add('active');
    }

    // 2. Highlight teks yang diklik
    const clickedBtn = document.querySelector(`.clickable-text[onclick="showPart('${id}')"]`);
    if (clickedBtn) {
        clickedBtn.classList.add('active-text-clicked');
    }

    // 3. Tampilkan garis sesuai id
    if (id === 'text-tegak') {
        const line = document.getElementById('line-tegak');
        if (line) line.classList.add('active');
    } else if (id === 'text-datar') {
        const line = document.getElementById('line-datar');
        if (line) line.classList.add('active');
    } else if (id === 'text-miring') {
        const line = document.getElementById('line-miring');
        if (line) line.classList.add('active');
    }
}

function resetHighlight() {
    // Hapus semua label
    document.querySelectorAll('.overlay-text').forEach(el => el.classList.remove('active', 'show'));

    // Hapus semua garis
    document.querySelectorAll('.highlight-line').forEach(line => line.classList.remove('active'));

    // Hapus highlight teks
    document.querySelectorAll('.clickable-text').forEach(btn => btn.classList.remove('active-text-clicked'));

    // Hapus feedback kuis
    const feedback = document.getElementById('feedbackPesan');
    if (feedback) feedback.innerHTML = '';
}

// Fungsi kuis di bawah ini sudah bagus, tidak perlu diubah
function cekJawabanSegitigaSikuSiku() {
    const input = document.getElementById('inputJawaban');
    if (!input) return;
    const feedback = document.getElementById('feedbackPesan');
    const jawaban = input.value;
    const penjelasanBox = document.getElementById('penjelasan-pythagoras');

    feedback.className = 'fw-bold text-center mt-3';
    if (jawaban === '') {
        feedback.classList.add('text-warning');
        feedback.innerHTML = 'Silakan pilih jenis segitiga terlebih dahulu.';
        if (penjelasanBox) penjelasanBox.classList.add('d-none');
    } else if (jawaban === 'siku-siku') {
        feedback.classList.add('text-success');
        feedback.innerHTML = 'Tepat Sekali! Segitiga yang terbentuk adalah segitiga siku-siku.';
        if (penjelasanBox) {
            penjelasanBox.classList.remove('d-none');
            setTimeout(() => penjelasanBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 300);
        }
        simpanProgressMateri1('m1_cp1_segitiga_jembatan', 10);
    } else {
        feedback.classList.add('text-danger');
        feedback.innerHTML = 'Kurang tepat. Coba perhatikan kembali setiap sudut yang ada pada segitiga.';
        if (penjelasanBox) penjelasanBox.classList.add('d-none');
    }
}

const MATERI1_AKTIVITAS = {
    cp1: {
        checkpoint: 'm1_cp1_segitiga_jembatan',
        selector: 'button[onclick="cekJawabanSegitigaSikuSiku()"]',
        poin: 10
    },
    cp2: {
        checkpoint: 'm1_cp2_dragdrop_sisi',
        selector: '#check-matching',
        poin: 10
    },
    cp3: {
        checkpoint: 'm1_cp3_tabel_kuadrat',
        selector: '#btnCekKuadrat',
        poin: 10
    },
    cp4: {
        checkpoint: 'm1_cp4_isian_akar',
        selector: '#btnCekAkar',
        poin: 10
    },
    cp5: {
        checkpoint: 'm1_cp5_titik_siku',
        selector: 'button[onclick="cekJawabanSikusiku()"]',
        poin: 10
    },
    cp6: {
        checkpoint: 'm1_cp6_kuis_canvas',
        selector: '#btnPeriksaQuiz',
        poin: 15
    },
    cp7: {
        checkpoint: 'm1_cp7_tabel_penamaan_sisi',
        selector: 'button[onclick="checkAllAnswers()"]',
        poin: 15
    },
    cp8: {
        checkpoint: 'm1_cp8_tabel_luas_geogebra',
        selector: 'button[onclick="cekTabelGeoGebra()"]',
        poin: 15
    },
    cp9: {
        checkpoint: 'm1_cp9_kesimpulan_luas',
        selector: 'button[onclick*="cekPilihan"]',
        poin: 10
    },
    cp10: {
        checkpoint: 'm1_cp10_contoh_soal_1',
        selector: 'button[onclick="cekContoh1()"]',
        poin: 15
    },
    cp11: {
        checkpoint: 'm1_cp11_contoh_soal_2',
        selector: 'button[onclick="cekContoh2()"]',
        poin: 15
    },
    cp12: {
        checkpoint: 'm1_cp12_latihan_1',
        selector: 'button[onclick="cekLatihanAnalisis1()"]',
        poin: 20
    },
    cp13: {
        checkpoint: 'm1_cp13_latihan_2',
        selector: 'button[onclick="cekLatihanAnalisis2()"]',
        poin: 20
    },
    cp14: {
        checkpoint: 'm1_cp14_latihan_3',
        selector: 'button[onclick="cekLatihanAnalisis3()"]',
        poin: 20
    },
    cp15: {
        checkpoint: 'm1_cp15_refleksi_akhir',
        selector: 'button[onclick="cekRefleksi()"]',
        poin: 10
    }
};

/* =====================================================
   2. MATERI 1: DRAG & DROP SISI
===================================================== */
function initDragAndDropPage1() {
    let attemptCount = 0;
    const maxAttempts = 3;
    let isGameLocked = false;
    const dragSource = document.getElementById('drag-source');
    const checkBtn = document.getElementById('check-matching');
    const resetBtn = document.getElementById('reset-matching');
    const dropZones = document.querySelectorAll('.drop-zone[data-correct]');

    if (!dragSource || !checkBtn || dropZones.length === 0) return;

    document.querySelectorAll('.drag-item').forEach(item => {
        item.setAttribute('draggable', 'true');
        item.style.cursor = 'grab';
        item.ondragstart = (e) => {
            if (isGameLocked) { e.preventDefault(); return; }
            e.dataTransfer.setData('text/plain', e.target.id);
            e.dataTransfer.effectAllowed = 'move';
            setTimeout(() => e.target.classList.add('hide-while-dragging'), 0);
        };
        item.ondragend = (e) => {
            e.target.classList.remove('hide-while-dragging');
            e.target.style.cursor = 'grab';
        };
    });

    dropZones.forEach(zone => {
        zone.ondragover = (e) => {
            e.preventDefault();
            if (!isGameLocked) {
                zone.classList.add('bg-light-success');
                zone.style.borderStyle = 'solid';
            }
        };
        zone.ondragleave = (e) => {
            if (!isGameLocked) {
                zone.classList.remove('bg-light-success');
                if (!zone.classList.contains('correct-answer')) zone.style.borderStyle = 'dashed';
            }
        };
        zone.ondrop = (e) => {
            e.preventDefault();
            zone.classList.remove('bg-light-success');
            if (isGameLocked) return;
            const draggedElement = document.getElementById(e.dataTransfer.getData('text/plain'));
            if (draggedElement) {
                if (zone.children.length > 0) dragSource.appendChild(zone.querySelector('.drag-item'));
                zone.appendChild(draggedElement);
                zone.style.borderStyle = 'solid';
                zone.style.backgroundColor = '#f8f9fa';
                const fb = zone.parentNode.querySelector('.feedback-msg');
                if (fb) fb.innerHTML = '';
            }
        };
        zone.onclick = () => {
            if (!isGameLocked && zone.children.length > 0) {
                dragSource.appendChild(zone.querySelector('.drag-item'));
                zone.style.borderStyle = 'dashed';
                zone.style.borderColor = '#198754';
                zone.style.backgroundColor = '#f8f9fa';
                zone.classList.remove('correct-answer');
                const fb = zone.parentNode.querySelector('.feedback-msg');
                if (fb) fb.innerHTML = '';
            }
        };
    });

    resetBtn.onclick = () => {
        dragSource.innerHTML = '';
        document.querySelectorAll('.drag-item').forEach(item => {
            item.style.opacity = '1';
            item.classList.remove('hide-while-dragging');
            dragSource.appendChild(item);
        });
        dropZones.forEach(zone => {
            zone.style.borderStyle = 'dashed';
            zone.style.borderColor = '#198754';
            zone.style.backgroundColor = '#f8f9fa';
            zone.classList.remove('correct-answer', 'bg-light-success');
            const fb = zone.parentNode.querySelector('.feedback-msg');
            if (fb) fb.innerHTML = '';
        });
        const penguatan = document.getElementById('penguatan-materi-dragdrop');
        if (penguatan) {
            penguatan.classList.add('d-none');
            penguatan.classList.remove('animate__animated', 'animate__fadeInUp');
        }
        isGameLocked = false;
        attemptCount = 0;
        checkBtn.disabled = false;
    };

    checkBtn.onclick = () => {
        if (isGameLocked) return;
        let correctCount = 0;
        let filledCount = 0;

        dropZones.forEach(zone => {
            const item = zone.querySelector('.drag-item');
            const fb = zone.parentNode.querySelector('.feedback-msg');
            if (item) {
                filledCount++;
                if (item.getAttribute('data-value') === zone.getAttribute('data-correct')) {
                    correctCount++;
                    zone.style.borderColor = '#198754';
                    zone.style.backgroundColor = '#d1e7dd';
                    zone.classList.add('correct-answer');
                    if (fb) fb.innerHTML = '<span class="text-success small fw-bold">Jawaban Tepat!</span>';
                } else {
                    zone.style.borderColor = '#dc3545';
                    zone.style.backgroundColor = '#f8d7da';
                    if (fb) fb.innerHTML = '<span class="text-danger small fw-bold">Kurang Tepat</span>';
                }
            } else {
                if (fb) fb.innerHTML = '<span class="text-warning small fw-bold">Belum diisi</span>';
            }
        });

        if (filledCount < dropZones.length) {
            Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Silakan isi semua kotak jawaban/susunan gambar terlebih dahulu.', confirmButtonColor: '#ffc107' });
            return;
        }

        attemptCount++;
        if (correctCount === dropZones.length) {
            simpanProgressMateri1('m1_cp2_dragdrop_sisi', 10);
            isGameLocked = true;
            checkBtn.disabled = true;
            swalLatihanMateri1('#check-matching', {
                icon: 'success',
                title: '+10 Poin!',
                html: 'Kamu berhasil mencocokkan sisi-sisi segitiga siku-siku!<br><small class="text-muted">Terus semangat belajar!</small>',
                confirmButtonColor: '#198754'
            }).then((result) => {
                // Pindah ke SINI
                if (result.isConfirmed) {

                    const penguatan = document.getElementById('penguatan-materi-dragdrop');
                    if (penguatan) {
                        penguatan.classList.remove('d-none');
                        penguatan.classList.add('animate__animated', 'animate__fadeInUp');
                        setTimeout(() => penguatan.scrollIntoView({ behavior: 'smooth', block: 'center' }), 300);
                    }
                }

                selesaikanAktivitasMateri1('#check-matching', function () {
                    if (resetBtn) resetBtn.click();
                });
            });
        } else if (attemptCount >= maxAttempts) {
            isGameLocked = true;
            checkBtn.disabled = true;
            dropZones.forEach(zone => {
                const itemInZone = zone.querySelector('.drag-item');
                if (itemInZone) dragSource.appendChild(itemInZone);
            });
            dropZones.forEach(zone => {
                const correctVal = zone.getAttribute('data-correct');
                const correctItem = dragSource.querySelector(`.drag-item[data-value="${correctVal}"]`);
                if (correctItem) {
                    zone.appendChild(correctItem);
                    zone.style.borderColor = '#198754';
                    zone.style.backgroundColor = '#d1e7dd';
                    zone.classList.add('correct-answer');
                    const fb = zone.parentNode.querySelector('.feedback-msg');
                    if (fb) fb.innerHTML = '<span class="text-primary small fw-bold">Ini jawaban yang benar</span>';
                }
            });
            Swal.fire({
                icon: 'info',
                title: 'Kesempatan Habis',
                text: 'Jangan menyerah, jawaban yang benar telah ditampilkan.',
                confirmButtonColor: '#0d6efd'
            }).then(() => {
                const penguatan = document.getElementById('penguatan-materi-dragdrop');
                if (penguatan) {
                    penguatan.classList.remove('d-none');
                    penguatan.classList.add('animate__animated', 'animate__fadeInUp');
                    setTimeout(() => penguatan.scrollIntoView({ behavior: 'smooth', block: 'center' }), 300);
                }

                selesaikanKesempatanHabisMateri1(
                    'm1_cp2_dragdrop_sisi',
                    '#check-matching',
                    function () {
                        if (resetBtn) resetBtn.click();
                    }
                );
            });
        } else {
            swalLatihanMateri1('#check-matching', {
                icon: 'error',
                title: 'Jawaban Kurang Tepat',
                text: `Sisa kesempatan mencoba: ${maxAttempts - attemptCount} kali. Ayo perbaiki kotak yang berwarna merah!`,
                confirmButtonColor: '#dc3545'
            });
        }
    };
}
document.addEventListener('DOMContentLoaded', initDragAndDropPage1);

/* ==========================================
   MATERI 1: BILANGAN KUADRAT
========================================== */
function initPageKuadrat() {
    const container = document.getElementById('kuadrat-container');
    const penguatanMateri = document.getElementById('penguatan-materi');
    if (!container) return;

    let attemptCount = 0;
    const maxAttempts = 3;
    const checkBtn = container.querySelector('#btnCekKuadrat');
    const allInputs = container.querySelectorAll('.input-kuadrat');
    if (!checkBtn) return;

    function resetKuadrat() {
        attemptCount = 0;
        checkBtn.disabled = false;
        checkBtn.innerHTML = "Periksa Jawaban";
        allInputs.forEach(input => {
            input.value = '';
            input.classList.remove('is-valid', 'is-invalid');
            input.disabled = false;
        });
        if (penguatanMateri) penguatanMateri.classList.add('d-none');
    }

    function showAnswersKuadrat() {
        allInputs.forEach(input => {
            input.value = input.getAttribute('data-answer');
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            input.disabled = true;
        });

        checkBtn.disabled = true;
        checkBtn.innerHTML = "Selesai";

        if (penguatanMateri) {
            penguatanMateri.classList.remove('d-none');
            setTimeout(() => penguatanMateri.scrollIntoView({ behavior: 'smooth', block: 'center' }), 300);
        }

        selesaikanKesempatanHabisMateri1(
            'm1_cp3_tabel_kuadrat',
            '#btnCekKuadrat',
            resetKuadrat
        );
    }

    checkBtn.onclick = function () {
        let allCorrect = true;
        let emptyCount = 0;
        allInputs.forEach(input => {
            if (input.value.trim() === '') emptyCount++;
        });

        if (emptyCount > 0) {
            Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Silakan lengkapi semua kotak kosong bertanda (?) terlebih dahulu.', confirmButtonColor: '#ffc107' });
            return;
        }

        allInputs.forEach(input => {
            if (parseFloat(input.value) === parseFloat(input.getAttribute('data-answer'))) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            } else {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                allCorrect = false;
            }
        });

        attemptCount++;
        if (allCorrect) {
            simpanProgressMateri1('m1_cp3_tabel_kuadrat', 10);

            swalLatihanMateri1('#btnCekKuadrat', {
                icon: 'success',
                title: '+10 Poin!',
                html: 'Hebat! Kamu berhasil melengkapi pola bilangan kuadrat.<br><small class="text-muted">Pertahankan prestasimu!</small>',
                confirmButtonText: 'Lihat Pembahasan',
                confirmButtonColor: '#198754'
            }).then(() => {
                checkBtn.disabled = true;
                checkBtn.innerHTML = "Selesai";
                allInputs.forEach(el => el.disabled = true);

                if (penguatanMateri) {
                    penguatanMateri.classList.remove('d-none');
                    setTimeout(() => penguatanMateri.scrollIntoView({ behavior: 'smooth', block: 'center' }), 500);
                }

                selesaikanAktivitasMateri1(
                    '#btnCekKuadrat',
                    resetKuadrat
                );
            });
        } else {
            if (attemptCount >= maxAttempts) {
                Swal.fire({ icon: 'info', title: 'Kesempatan Habis', html: `Kamu sudah mencoba ${maxAttempts} kali. Mari kita lihat jawabannya.`, confirmButtonText: 'Tampilkan Jawaban', confirmButtonColor: '#0d6efd', allowOutsideClick: false }).then(() => showAnswersKuadrat());
            } else {
                swalLatihanMateri1('#btnCekKuadrat', {
                    icon: 'error',
                    title: 'Jawaban Kurang Tepat',
                    text: `Cek kembali kotak yang berwarna merah. Sisa kesempatan: ${maxAttempts - attemptCount} kali.`,
                    confirmButtonText: 'Coba Lagi',
                    confirmButtonColor: '#dc3545'
                });
            }
        }
    };
}

/* ==========================================
   MATERI 1: AKAR KUADRAT
========================================== */
function initPageAkar() {
    const container = document.getElementById('akar-container');
    if (!container) return;
    let attemptCount = 0;
    const maxAttempts = 3;
    const checkBtn = container.querySelector('#btnCekAkar');

    function resetAkar() {
        attemptCount = 0;
        checkBtn.disabled = false;
        container.querySelectorAll('.input-akar').forEach(input => {
            input.value = '';
            input.classList.remove('is-valid', 'is-invalid');
            input.disabled = false;
        });
        container.querySelectorAll('.select-akar').forEach(sel => {
            sel.value = '';
            sel.classList.remove('is-valid', 'is-invalid');
            sel.disabled = false;
        });
    }

    function showAnswersAkar() {
        container.querySelectorAll('.input-akar').forEach(input => {
            input.value = input.getAttribute('data-answer');
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            input.disabled = true;
        });

        container.querySelectorAll('.select-akar').forEach(sel => {
            sel.value = sel.getAttribute('data-answer');
            sel.classList.remove('is-invalid');
            sel.classList.add('is-valid');
            sel.disabled = true;
        });

        checkBtn.disabled = true;

        selesaikanKesempatanHabisMateri1(
            'm1_cp4_isian_akar',
            '#btnCekAkar',
            resetAkar
        );
    }

    checkBtn.onclick = function () {
        let isKosong = false;
        container.querySelectorAll('.input-akar, .select-akar').forEach(el => {
            if (el.value.trim() === '') isKosong = true;
        });
        if (isKosong) {
            Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Silakan lengkapi semua kolom jawaban terlebih dahulu.', confirmButtonColor: '#ffc107' });
            return;
        }

        let allCorrect = true;
        container.querySelectorAll('.input-akar').forEach(input => {
            if (input.value.trim() == input.getAttribute('data-answer')) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            } else {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                allCorrect = false;
            }
        });
        container.querySelectorAll('.select-akar').forEach(sel => {
            if (sel.value === sel.getAttribute('data-answer')) {
                sel.classList.remove('is-invalid');
                sel.classList.add('is-valid');
            } else {
                sel.classList.remove('is-valid');
                sel.classList.add('is-invalid');
                allCorrect = false;
            }
        });

        attemptCount++;
        if (allCorrect) {
            simpanProgressMateri1('m1_cp4_isian_akar', 10);

            swalLatihanMateri1('#btnCekAkar', {
                icon: 'success',
                title: '+10 Poin!',
                html: 'Semua jawaban benar.<br><small class="text-muted">Luar biasa, teruslah berlatih!</small>',
                confirmButtonColor: '#198754'
            }).then(() => {
                checkBtn.disabled = true;
                container.querySelectorAll('input, select').forEach(el => el.disabled = true);

                selesaikanAktivitasMateri1(
                    '#btnCekAkar',
                    resetAkar
                );
            });
        } else {
            if (attemptCount >= maxAttempts) {
                Swal.fire({ icon: 'info', title: 'Kesempatan Habis', html: 'Sisa percobaan habis.<br>Mari kita lihat jawabannya.', confirmButtonText: 'Tampilkan Jawaban', confirmButtonColor: '#0d6efd', allowOutsideClick: false }).then(() => showAnswersAkar());
            } else {
                swalLatihanMateri1('#btnCekAkar', {
                    icon: 'error',
                    title: 'Jawaban Kurang Tepat',
                    text: `Perbaiki bagian yang berwarna merah. Sisa kesempatan: ${maxAttempts - attemptCount} kali.`,
                    confirmButtonText: 'Coba Lagi',
                    confirmButtonColor: '#dc3545'
                });
            }
        }
    };
}
document.addEventListener('DOMContentLoaded', initPageAkar);

/* =====================================================
   MATERI 1: AYO BERLATIH ANALISIS 1, 2, 3
===================================================== */
const MAX_ATTEMPT_LATIHAN = 3;
let attemptLatihan1 = 0, attemptLatihan2 = 0, attemptLatihan3 = 0;

function setValidVisual(el) {
    if (!el) return;
    el.classList.remove('border-danger', 'text-danger', 'border-secondary', 'bg-light', 'text-muted', 'border-dark', 'text-dark', 'btn-dark', 'btn-outline-dark', 'bg-light-danger');
    el.classList.add('border-success', 'text-success', 'is-valid');
    if (el.classList.contains('btn-pilihan')) el.classList.add('btn-success', 'text-white');
}

function setInvalidVisual(el) {
    if (!el) return;
    el.classList.remove('border-success', 'text-success', 'border-secondary', 'bg-light', 'text-muted', 'border-dark', 'text-dark', 'btn-dark', 'btn-outline-dark', 'is-valid');
    el.classList.add('border-danger', 'text-danger', 'is-invalid');
    if (el.classList.contains('drop-zone')) el.classList.add('bg-light-danger');
    if (el.classList.contains('btn-pilihan')) el.classList.add('btn-danger', 'text-white');
}

function setGreyVisual(el) {
    if (!el) return;
    el.classList.remove('border-danger', 'text-danger', 'border-success', 'text-success', 'border-dark', 'text-dark', 'bg-light-danger', 'is-invalid', 'is-valid');
    el.classList.add('border-secondary', 'bg-light', 'text-muted');
    if (el.tagName === 'INPUT' || el.tagName === 'SELECT') el.disabled = true;
}

function pilihRumusAnalisis(status, btn) {
    const container = btn.closest('.row');
    container.querySelectorAll('.btn-pilihan').forEach(b => {
        b.classList.remove('btn-success', 'btn-danger', 'btn-dark', 'text-white', 'is-selected');
        b.classList.add('btn-outline-dark');
        b.dataset.status = 'salah';
    });
    btn.classList.remove('btn-outline-dark');
    btn.classList.add('btn-dark', 'text-white', 'is-selected');
    btn.dataset.status = status;
}

function resetLatihanAnalisis1() {
    const tanya = document.getElementById('s1_tanya');
    const diket1 = document.getElementById('s1_diketahui_1');
    const diket2 = document.getElementById('s1_diketahui_2');
    const feedback = document.getElementById('s1_feedback');

    [tanya, diket1, diket2].forEach(el => {
        if (el) {
            el.value = '';
            el.disabled = false;
            el.classList.remove(
                'is-valid', 'is-invalid',
                'border-success', 'border-danger',
                'text-success', 'text-danger',
                'border-secondary', 'bg-light', 'text-muted'
            );
        }
    });

    const cardBody = tanya ? tanya.closest('.card-body') : null;
    if (cardBody) {
        cardBody.querySelectorAll('.btn-pilihan').forEach(btn => {
            btn.disabled = false;
            btn.dataset.status = 'salah';
            btn.classList.remove(
                'btn-success', 'btn-danger', 'btn-dark',
                'text-white', 'is-selected',
                'is-valid', 'is-invalid',
                'border-success', 'border-danger'
            );
            btn.classList.add('btn-outline-dark');
        });
    }

    if (feedback) feedback.innerText = '';

    attemptLatihan1 = 0;
}

function cekLatihanAnalisis1() {
    const tanya = document.getElementById('s1_tanya');
    const diket1 = document.getElementById('s1_diketahui_1');
    const diket2 = document.getElementById('s1_diketahui_2');
    if (!tanya) return;
    const btnGroups = document.getElementById('s1_tanya').closest('.card-body').querySelectorAll('.row.g-2, .row.g-3');
    const btnOp = btnGroups[0] ? btnGroups[0].querySelector('.is-selected') : null;
    const btnRumus = btnGroups[1] ? btnGroups[1].querySelector('.is-selected') : null;

    if (!tanya.value || !diket1.value.trim() || !diket2.value.trim() || !btnOp || !btnRumus) {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Lengkapi isian dan pilihan rumus terlebih dahulu.', confirmButtonColor: '#ffc107' });
        return;
    }

    attemptLatihan1++;
    let benarSemua = true;
    if (tanya.value === 'miring') setValidVisual(tanya);
    else {
        setInvalidVisual(tanya);
        benarSemua = false;
    }

    const valDiket = [diket1.value.trim().toUpperCase(), diket2.value.trim().toUpperCase()];
    if (valDiket.includes('AB') && valDiket.includes('BC')) {
        setValidVisual(diket1);
        setValidVisual(diket2);
    } else {
        if (!['AB', 'BC'].includes(valDiket[0])) setInvalidVisual(diket1);
        else setValidVisual(diket1);
        if (!['AB', 'BC'].includes(valDiket[1])) setInvalidVisual(diket2);
        else setValidVisual(diket2);
        benarSemua = false;
    }

    if (btnOp.dataset.status === 'benar') setValidVisual(btnOp);
    else {
        setInvalidVisual(btnOp);
        benarSemua = false;
    }
    if (btnRumus.dataset.status === 'benar') setValidVisual(btnRumus);
    else {
        setInvalidVisual(btnRumus);
        benarSemua = false;
    }

    if (benarSemua) {
        document.getElementById('s1_feedback').innerText = "Tepat sekali!";
        simpanProgressMateri1('m1_cp12_latihan_1', 20);

        swalLatihanMateri1('button[onclick="cekLatihanAnalisis1()"]', {
            icon: 'success',
            title: '+20 Poin!',
            html: 'Semua analisismu benar.<br><small class="text-muted">Keren! Kamu sangat teliti.</small>',
            confirmButtonColor: '#198754'
        }).then(() => {
            selesaikanAktivitasMateri1(
                'button[onclick="cekLatihanAnalisis1()"]',
                resetLatihanAnalisis1
            );
        });
    } else if (attemptLatihan1 >= MAX_ATTEMPT_LATIHAN) {
        Swal.fire({ icon: 'info', title: 'Kesempatan Habis', text: 'Mari kita lihat jawaban yang tepat.', confirmButtonText: 'Tampilkan Jawaban', confirmButtonColor: '#0d6efd', allowOutsideClick: false }).then(() => {
            if (tanya.value !== 'miring') {
                setValidVisual(tanya);
                tanya.value = 'miring';
            }
            if (!['AB', 'BC'].includes(diket1.value.trim().toUpperCase())) {
                setValidVisual(diket1);
                diket1.value = 'AB';
            }
            if (!['AB', 'BC'].includes(diket2.value.trim().toUpperCase())) {
                setValidVisual(diket2);
                diket2.value = 'BC';
            }
            if (btnOp && btnOp.dataset.status !== 'benar') {
                setValidVisual(btnOp);
                const correctBtn = btnGroups[0].querySelector('[onclick*="benar"]');
                if (correctBtn) correctBtn.classList.replace('btn-outline-dark', 'btn-success');
                correctBtn.classList.add('text-white');
            }
            if (btnRumus && btnRumus.dataset.status !== 'benar') {
                setValidVisual(btnRumus);
                const correctBtn = btnGroups[1].querySelector('[onclick*="benar"]');
                if (correctBtn) correctBtn.classList.replace('btn-outline-dark', 'btn-success');
                correctBtn.classList.add('text-white');
            }
            tanya.disabled = true;
            diket1.disabled = true;
            diket2.disabled = true;
            btnGroups.forEach(row => row.querySelectorAll('button').forEach(b => b.disabled = true));

            selesaikanKesempatanHabisMateri1(
                'm1_cp12_latihan_1',
                'button[onclick="cekLatihanAnalisis1()"]',
                resetLatihanAnalisis1
            );
        });
    } else {
        swalLatihanMateri1('button[onclick="cekLatihanAnalisis1()"]', {
            icon: 'error',
            title: 'Kurang Tepat',
            text: `Jawabanmu ada yang salah. Sisa kesempatan: ${MAX_ATTEMPT_LATIHAN - attemptLatihan1}`,
            confirmButtonColor: '#dc3545'
        });
    }
}

function setupDragAndDrop(containerId, targetPrefix) {
    const dragContainer = document.getElementById(containerId);
    if (!dragContainer) return;
    const dragItems = dragContainer.querySelectorAll('.draggable-item');
    for (let i = dragContainer.children.length; i >= 0; i--) dragContainer.appendChild(dragContainer.children[Math.random() * i | 0]);

    dragItems.forEach(item => {
        const newItem = item.cloneNode(true);
        item.parentNode.replaceChild(newItem, item);
        newItem.addEventListener('dragstart', function (e) {
            e.dataTransfer.setData('text/plain', e.target.id);
            e.dataTransfer.effectAllowed = 'move';
            setTimeout(() => e.target.style.opacity = '0.5', 0);
        });
        newItem.addEventListener('dragend', function (e) {
            e.target.style.opacity = '1';
        });
    });

    document.querySelectorAll(`.drop-zone[data-target^="${targetPrefix}"]`).forEach(zone => {
        const newZone = zone.cloneNode(true);
        zone.parentNode.replaceChild(newZone, zone);
        newZone.addEventListener('dragover', function (e) {
            e.preventDefault();
            this.style.backgroundColor = '#e8f5e9';
            this.style.borderStyle = 'solid';
        });
        newZone.addEventListener('dragleave', function (e) {
            this.style.backgroundColor = '';
            this.style.borderStyle = 'dashed';
        });
        newZone.addEventListener('drop', function (e) {
            e.preventDefault();
            this.style.backgroundColor = '';
            const draggedElement = document.getElementById(e.dataTransfer.getData('text/plain'));
            if (draggedElement && draggedElement.id.includes(targetPrefix === 's2_' ? 'item-' : 'item-')) {
                if (this.children.length > 0) {
                    const existingItem = this.querySelector('.draggable-item');
                    if (existingItem) {
                        existingItem.classList.replace('p-1', 'p-2');
                        document.getElementById(containerId).appendChild(existingItem);
                    }
                }
                draggedElement.style.margin = "0";
                draggedElement.classList.replace('p-2', 'p-1');
                this.appendChild(draggedElement);
                this.style.borderStyle = 'solid';
                this.classList.remove('border-danger', 'bg-light-danger');
                this.classList.add('border-dark');
            }
        });
        newZone.addEventListener('click', function (e) {
            if (this.children.length > 0) {
                const item = this.querySelector('.draggable-item');
                if (item) {
                    item.classList.replace('p-1', 'p-2');
                    document.getElementById(containerId).appendChild(item);
                    this.style.borderStyle = 'dashed';
                    this.classList.remove('border-danger', 'border-success', 'bg-light-danger');
                    this.classList.add('border-dark');
                }
            }
        });
    });
}

function initDragDropSoal3() {
    setupDragAndDrop('drag-items-container', 's2_');
    setupDragAndDrop('drag-items-container-s3', 's3_');
}

function resetLatihanAnalisis2() {
    const idsInput = [
        's2_inp_mo_1',
        's2_inp_mo_2',
        's2_inp_mo_3',
        's2_inp_mo_4',
        's2_inp_mn',
        's2_inp_no',
        's2_res_mn_sq',
        's2_res_no_sq',
        's2_res_sum',
        's2_res_sqrt',
        's2_final'
    ];

    idsInput.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.value = '';
            el.disabled = false;
            el.classList.remove(
                'is-valid', 'is-invalid',
                'border-success', 'border-danger',
                'text-success', 'text-danger',
                'border-secondary', 'bg-light', 'text-muted'
            );
            el.classList.add('border-dark');
        }
    });

    const dragContainer = document.getElementById('drag-items-container');
    if (dragContainer) {
        document.querySelectorAll('.drop-zone[data-target^="s2_"] .draggable-item').forEach(item => {
            item.classList.replace('p-1', 'p-2');
            item.style.margin = '';
            dragContainer.appendChild(item);
        });
    }

    document.querySelectorAll('.drop-zone[data-target^="s2_"]').forEach(zone => {
        zone.innerHTML = '';
        zone.style.borderStyle = 'dashed';
        zone.style.backgroundColor = '';
        zone.classList.remove(
            'border-success',
            'border-danger',
            'bg-light-danger',
            'is-valid',
            'is-invalid'
        );
        zone.classList.add('border-dark');
    });

    const feedback = document.getElementById('s2_feedback');
    if (feedback) feedback.innerText = '';

    attemptLatihan2 = 0;

    if (typeof setupDragAndDrop === 'function') {
        setupDragAndDrop('drag-items-container', 's2_');
    }
}

function cekLatihanAnalisis2() {
    const getDropValue = (targetId) => {
        const zone = document.querySelector(`[data-target="${targetId}"]`);
        return zone && zone.querySelector('.draggable-item') ? zone.querySelector('.draggable-item').getAttribute('data-value') : null;
    };
    const inputsText = document.querySelectorAll('#s2_inp_mo_1, #s2_inp_mo_2, #s2_inp_mo_3, #s2_inp_mo_4');
    const inputMn = document.getElementById('s2_inp_mn');
    const inputNo = document.getElementById('s2_inp_no');
    const resMnSq = document.getElementById('s2_res_mn_sq');
    const resNoSq = document.getElementById('s2_res_no_sq');
    const resSum = document.getElementById('s2_res_sum');
    const resSqrt = document.getElementById('s2_res_sqrt');
    const final = document.getElementById('s2_final');

    if (!inputMn) return; // Pengaman

    const isInputEmpty = [...inputsText, inputMn, inputNo, resMnSq, resNoSq, resSum, resSqrt, final].some(input => !input || input.value.trim() === '');
    let isDropEmpty = false;
    if (!getDropValue('s2_diketahui_mn') || !getDropValue('s2_diketahui_no') || !getDropValue('s2_ditanya') || !getDropValue('s2_rumus_miring') || !getDropValue('s2_rumus_tegak1') || !getDropValue('s2_rumus_tegak2')) isDropEmpty = true;

    if (isDropEmpty || isInputEmpty) {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Harap lengkapi susunan gambar dan kotak isian perhitungan terlebih dahulu.', confirmButtonColor: '#ffc107' });
        return;
    }

    attemptLatihan2++;
    let benarSemua = true;
    const checkDrop = (target, validValues) => {
        const zone = document.querySelector(`[data-target="${target}"]`);
        if (!zone) return;
        if (validValues.includes(getDropValue(target))) setValidVisual(zone);
        else {
            setInvalidVisual(zone);
            benarSemua = false;
        }
    };

    checkDrop('s2_diketahui_mn', ['15cm', '8cm']);
    checkDrop('s2_diketahui_no', ['15cm', '8cm']);
    checkDrop('s2_ditanya', ['tanya']);
    checkDrop('s2_rumus_miring', ['MO']);
    checkDrop('s2_rumus_tegak1', ['MN', 'NO']);
    checkDrop('s2_rumus_tegak2', ['MN', 'NO']);

    inputsText.forEach(inp => {
        if (inp && inp.value.trim().toUpperCase() === 'MO') setValidVisual(inp);
        else if (inp) {
            setInvalidVisual(inp);
            benarSemua = false;
        }
    });

    const valMn = parseInt(inputMn.value);
    const valNo = parseInt(inputNo.value);
    if ((valMn === 15 && valNo === 8) || (valMn === 8 && valNo === 15)) {
        setValidVisual(inputMn);
        setValidVisual(inputNo);
    } else {
        setInvalidVisual(inputMn);
        setInvalidVisual(inputNo);
        benarSemua = false;
    }

    if (parseInt(resMnSq.value) === Math.pow(valMn, 2) && valMn > 0) setValidVisual(resMnSq);
    else {
        setInvalidVisual(resMnSq);
        benarSemua = false;
    }
    if (parseInt(resNoSq.value) === Math.pow(valNo, 2) && valNo > 0) setValidVisual(resNoSq);
    else {
        setInvalidVisual(resNoSq);
        benarSemua = false;
    }
    if (parseInt(resSum.value) === 289) setValidVisual(resSum);
    else {
        setInvalidVisual(resSum);
        benarSemua = false;
    }
    if (parseInt(resSqrt.value) === 289) setValidVisual(resSqrt);
    else {
        setInvalidVisual(resSqrt);
        benarSemua = false;
    }
    if (parseInt(final.value) === 17) setValidVisual(final);
    else {
        setInvalidVisual(final);
        benarSemua = false;
    }

    if (benarSemua) {
        if (document.getElementById('s2_feedback')) {
            document.getElementById('s2_feedback').innerText = "Perhitungan Sempurna!";
        }

        simpanProgressMateri1('m1_cp13_latihan_2', 20);

        swalLatihanMateri1('button[onclick="cekLatihanAnalisis2()"]', {
            icon: 'success',
            title: '+20 Poin!',
            html: 'Susunan rumus dan perhitunganmu tepat.<br><small class="text-muted">Luar biasa, kamu menguasai materi!</small>',
            confirmButtonColor: '#198754'
        }).then(() => {
            selesaikanAktivitasMateri1(
                'button[onclick="cekLatihanAnalisis2()"]',
                resetLatihanAnalisis2
            );
        });
        return;
    }

    if (attemptLatihan2 >= MAX_ATTEMPT_LATIHAN) {
        Swal.fire({ icon: 'info', title: 'Kesempatan Habis', text: 'Mari kita lihat jawaban yang benar.', confirmButtonText: 'Tampilkan Jawaban', confirmButtonColor: '#0d6efd', allowOutsideClick: false }).then(() => {
            const checkAndFix = (el, correctVal) => {
                if (el) {
                    setValidVisual(el);
                    el.value = correctVal;
                    el.disabled = true;
                }
            };
            inputsText.forEach(inp => checkAndFix(inp, 'MO'));
            checkAndFix(inputMn, 15);
            checkAndFix(inputNo, 8);
            checkAndFix(resMnSq, 225);
            checkAndFix(resNoSq, 64);
            checkAndFix(resSum, 289);
            checkAndFix(resSqrt, 289);
            checkAndFix(final, 17);

            const fillDrop = (target, correctVal) => {
                const zone = document.querySelector(`[data-target="${target}"]`);
                if (zone) {
                    const dragSrc = document.getElementById('drag-items-container');
                    const correctItem = dragSrc.querySelector(`.draggable-item[data-value="${correctVal}"]`) || document.querySelector(`.draggable-item[data-value="${correctVal}"]`);
                    if (correctItem) {
                        zone.innerHTML = '';
                        correctItem.style.margin = "0";
                        correctItem.classList.replace('p-2', 'p-1');
                        zone.appendChild(correctItem);
                        setValidVisual(zone);
                    }
                }
            };
            fillDrop('s2_diketahui_mn', '15cm');
            fillDrop('s2_diketahui_no', '8cm');
            fillDrop('s2_ditanya', 'tanya');
            fillDrop('s2_rumus_miring', 'MO');
            fillDrop('s2_rumus_tegak1', 'MN');
            fillDrop('s2_rumus_tegak2', 'NO');

            selesaikanKesempatanHabisMateri1(
                'm1_cp13_latihan_2',
                'button[onclick="cekLatihanAnalisis2()"]',
                resetLatihanAnalisis2
            );
        });
    } else {
        swalLatihanMateri1('button[onclick="cekLatihanAnalisis2()"]', {
            icon: 'error',
            title: 'Kurang Tepat',
            text: `Periksa kembali yang berwarna merah. (Sisa kesempatan: ${MAX_ATTEMPT_LATIHAN - attemptLatihan2})`,
            confirmButtonColor: '#dc3545'
        });
    }
}

function resetSoal3() {
    const container = document.getElementById('soal3-container');
    const dragContainer = document.getElementById('drag-items-container-s3');
    if (!container || !dragContainer) return;
    container.querySelectorAll('.draggable-item').forEach(item => {
        item.classList.replace('p-1', 'p-2');
        item.style.opacity = '1';
        item.style.margin = '';
        dragContainer.appendChild(item);
    });
    for (let i = dragContainer.children.length; i >= 0; i--) dragContainer.appendChild(dragContainer.children[Math.random() * i | 0]);
    container.querySelectorAll('.drop-zone[data-target^="s3_"]').forEach(zone => {
        zone.style.borderStyle = 'dashed';
        zone.style.backgroundColor = '';
        zone.classList.remove('border-danger', 'border-success', 'bg-light-danger');
        zone.classList.add('border-dark');
    });
    container.querySelectorAll('input[id^="s3_"]:not([disabled])').forEach(input => {
        input.value = '';
        input.disabled = false;
        input.classList.remove('border-danger', 'text-danger', 'border-success', 'text-success', 'bg-light', 'text-muted', 'is-valid', 'is-invalid');
        input.classList.add('border-dark', 'bg-white');
    });
    attemptLatihan3 = 0;
    if (document.getElementById('s3_feedback')) document.getElementById('s3_feedback').innerText = '';
}

function cekLatihanAnalisis3() {
    const getDropValue = (targetId) => {
        const zone = document.querySelector(`[data-target="${targetId}"]`);
        return zone && zone.querySelector('.draggable-item') ? zone.querySelector('.draggable-item').getAttribute('data-value') : null;
    };
    const getVal = (id) => {
        const el = document.getElementById(id);
        return el ? parseInt(el.value) : NaN;
    };

    const inps = {
        ac_sq1: document.getElementById('s3_ac_sq1'),
        ac_sq2: document.getElementById('s3_ac_sq2'),
        ac_sum1: document.getElementById('s3_ac_sum1'),
        ac_sum2: document.getElementById('s3_ac_sum2'),
        ac_tot: document.getElementById('s3_ac_total'),
        ac_sqrt: document.getElementById('s3_ac_sqrt_val'),
        ac_fin: document.getElementById('s3_ac_final'),
        ab_sq1: document.getElementById('s3_ab_sq1'),
        ab_sq2: document.getElementById('s3_ab_sq2'),
        ab_sum1: document.getElementById('s3_ab_sum1'),
        ab_sum2: document.getElementById('s3_ab_sum2'),
        ab_tot: document.getElementById('s3_ab_total'),
        ab_sqrt: document.getElementById('s3_ab_sqrt_val'),
        ab_fin: document.getElementById('s3_ab_final'),
        bc_sq1: document.getElementById('s3_bc_sq1'),
        bc_sq2: document.getElementById('s3_bc_sq2'),
        bc_diff1: document.getElementById('s3_bc_diff1'),
        bc_diff2: document.getElementById('s3_bc_diff2'),
        bc_tot: document.getElementById('s3_bc_total'),
        bc_sqrt: document.getElementById('s3_bc_sqrt_val'),
        bc_fin: document.getElementById('s3_bc_final')
    };

    if (!inps.ac_sq1) return; // Pengaman

    const zones = {
        diketAE: document.querySelector('[data-target="s3_diket_ae"]'),
        diketCE: document.querySelector('[data-target="s3_diket_ce"]'),
        diketAD: document.querySelector('[data-target="s3_diket_ad"]'),
        diketBD: document.querySelector('[data-target="s3_diket_bd"]'),
        ditanya: document.querySelector('[data-target="s3_ditanya"]'),
        ac1: document.querySelector('[data-target="s3_ac_drop1"]'),
        ac2: document.querySelector('[data-target="s3_ac_drop2"]'),
        ab1: document.querySelector('[data-target="s3_ab_drop1"]'),
        ab2: document.querySelector('[data-target="s3_ab_drop2"]'),
        bc1: document.querySelector('[data-target="s3_bc_drop1"]'),
        bc2: document.querySelector('[data-target="s3_bc_drop2"]')
    };

    const isDropZoneEmpty = Object.values(zones).some(z => !z || z.querySelectorAll('.draggable-item').length === 0);
    const isInputEmpty = Object.values(inps).some(i => !i || i.value.trim() === '');

    if (isDropZoneEmpty || isInputEmpty) {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Lengkapi susunan gambar drag & drop dan semua angka terlebih dahulu.', confirmButtonColor: '#ffc107' });
        return;
    }

    attemptLatihan3++;
    let benarSemua = true;
    const elementsToValidate = [];
    const check = (el, condition) => {
        if (!el) return;
        elementsToValidate.push({ el: el, isCorrect: condition });
        if (!condition) benarSemua = false;
    };
    const checkDropPair = (z1, z2, validArr) => {
        if (!z1 || !z2) return;
        const v1 = getDropValue(z1.dataset.target);
        const v2 = getDropValue(z2.dataset.target);
        const isCor = (v1 === validArr[0] && v2 === validArr[1]) || (v1 === validArr[1] && v2 === validArr[0]);
        check(z1, isCor);
        check(z2, isCor);
    };

    check(zones.diketAE, getDropValue('s3_diket_ae') === '24');
    check(zones.diketCE, getDropValue('s3_diket_ce') === '7');
    check(zones.diketAD, getDropValue('s3_diket_ad') === '16');
    check(zones.diketBD, getDropValue('s3_diket_bd') === '12');
    check(zones.ditanya, getDropValue('s3_ditanya') === 'BC');

    checkDropPair(zones.ac1, zones.ac2, ['AE', 'CE']);
    check(inps.ac_sq1, [24, 7].includes(getVal('s3_ac_sq1')));
    check(inps.ac_sq2, [24, 7].includes(getVal('s3_ac_sq2')));
    check(inps.ac_sum1, [576, 49].includes(getVal('s3_ac_sum1')));
    check(inps.ac_sum2, [576, 49].includes(getVal('s3_ac_sum2')));
    check(inps.ac_tot, getVal('s3_ac_total') === 625);
    check(inps.ac_sqrt, getVal('s3_ac_sqrt_val') === 625);
    check(inps.ac_fin, getVal('s3_ac_final') === 25);

    checkDropPair(zones.ab1, zones.ab2, ['AD', 'BD']);
    check(inps.ab_sq1, [16, 12].includes(getVal('s3_ab_sq1')));
    check(inps.ab_sq2, [16, 12].includes(getVal('s3_ab_sq2')));
    check(inps.ab_sum1, [256, 144].includes(getVal('s3_ab_sum1')));
    check(inps.ab_sum2, [256, 144].includes(getVal('s3_ab_sum2')));
    check(inps.ab_tot, getVal('s3_ab_total') === 400);
    check(inps.ab_sqrt, getVal('s3_ab_sqrt_val') === 400);
    check(inps.ab_fin, getVal('s3_ab_final') === 20);

    check(zones.bc1, getDropValue('s3_bc_drop1') === 'AC');
    check(zones.bc2, getDropValue('s3_bc_drop2') === 'AB');
    check(inps.bc_sq1, getVal('s3_bc_sq1') === 25);
    check(inps.bc_sq2, getVal('s3_bc_sq2') === 20);
    check(inps.bc_diff1, getVal('s3_bc_diff1') === 625);
    check(inps.bc_diff2, getVal('s3_bc_diff2') === 400);
    check(inps.bc_tot, getVal('s3_bc_total') === 225);
    check(inps.bc_sqrt, getVal('s3_bc_sqrt_val') === 225);
    check(inps.bc_fin, getVal('s3_bc_final') === 15);

    elementsToValidate.forEach(item => item.isCorrect ? setValidVisual(item.el) : setInvalidVisual(item.el));

    if (benarSemua) {
        if (document.getElementById('s3_feedback')) document.getElementById('s3_feedback').innerText = "Sempurna!";
        simpanProgressMateri1('m1_cp14_latihan_3', 20);

        swalLatihanMateri1('button[onclick="cekLatihanAnalisis3()"]', {
            icon: 'success',
            title: '+20 Poin!',
            html: 'Semua jawaban benar. Luar biasa!<br><small class="text-muted">Selamat! Kamu sudah mahir.</small>',
            confirmButtonColor: '#198754'
        }).then(() => {
            selesaikanAktivitasMateri1(
                'button[onclick="cekLatihanAnalisis3()"]',
                resetSoal3
            );
        });
    } else {
        if (attemptLatihan3 >= MAX_ATTEMPT_LATIHAN) {
            Swal.fire({ icon: 'info', title: 'Kesempatan Habis', text: 'Mari kita lihat jawaban yang benar.', confirmButtonText: 'Tampilkan Jawaban', confirmButtonColor: '#0d6efd', allowOutsideClick: false }).then(() => {
                elementsToValidate.forEach(item => {
                    if (item.el) {
                        setValidVisual(item.el);
                        item.el.disabled = true;
                    }
                });
                // Auto fill answer
                inps.ac_sq1.value = 24;
                inps.ac_sq2.value = 7;
                inps.ac_sum1.value = 576;
                inps.ac_sum2.value = 49;
                inps.ac_tot.value = 625;
                inps.ac_sqrt.value = 625;
                inps.ac_fin.value = 25;
                inps.ab_sq1.value = 16;
                inps.ab_sq2.value = 12;
                inps.ab_sum1.value = 256;
                inps.ab_sum2.value = 144;
                inps.ab_tot.value = 400;
                inps.ab_sqrt.value = 400;
                inps.ab_fin.value = 20;
                inps.bc_sq1.value = 25;
                inps.bc_sq2.value = 20;
                inps.bc_diff1.value = 625;
                inps.bc_diff2.value = 400;
                inps.bc_tot.value = 225;
                inps.bc_sqrt.value = 225;
                inps.bc_fin.value = 15;

                const fillDrop = (target, correctVal) => {
                    const zone = document.querySelector(`[data-target="${target}"]`);
                    if (zone) {
                        const dragSrc = document.getElementById('drag-items-container-s3');
                        const correctItem = dragSrc.querySelector(`.draggable-item[data-value="${correctVal}"]`) || document.querySelector(`.draggable-item[data-value="${correctVal}"]`);
                        if (correctItem) {
                            zone.innerHTML = '';
                            correctItem.style.margin = "0";
                            correctItem.classList.replace('p-2', 'p-1');
                            zone.appendChild(correctItem);
                            setValidVisual(zone);
                        }
                    }
                };
                fillDrop('s3_diket_ae', '24');
                fillDrop('s3_diket_ce', '7');
                fillDrop('s3_diket_ad', '16');
                fillDrop('s3_diket_bd', '12');
                fillDrop('s3_ditanya', 'BC');
                fillDrop('s3_ac_drop1', 'AE');
                fillDrop('s3_ac_drop2', 'CE');
                fillDrop('s3_ab_drop1', 'AD');
                fillDrop('s3_ab_drop2', 'BD');
                fillDrop('s3_bc_drop1', 'AC');
                fillDrop('s3_bc_drop2', 'AB');

                selesaikanKesempatanHabisMateri1(
                    'm1_cp14_latihan_3',
                    'button[onclick="cekLatihanAnalisis3()"]',
                    resetSoal3
                );
            });
        } else {
            swalLatihanMateri1('button[onclick="cekLatihanAnalisis3()"]', {
                icon: 'error',
                title: 'Ada yang keliru',
                text: `Sisa percobaan: ${MAX_ATTEMPT_LATIHAN - attemptLatihan3}`,
                confirmButtonColor: '#dc3545'
            });
        }
    }
}

/* ===============================
   MATERI 1: VISUAL INTERAKTIF SEGITIGA & KUIS
================================ */
function initPage2() {
    const canvas = document.querySelector('[data-page="2"] #triangleCanvas');
    if (canvas) initTriangleCanvas(canvas);
}

let rightAngleVertexIndex = -1;

function initTriangleCanvas(canvasElement) {
    const ctx = canvasElement.getContext("2d");
    const container = document.getElementById("canvasContainer");
    let points = [];
    let lines = [];
    let isDragging = false;
    let dragStartPoint = null;
    let currentMousePos = { x: 0, y: 0 };
    const gridSize = 32;

    function resizeCanvas() {
        if (!container) return;
        canvasElement.width = container.clientWidth;
        canvasElement.height = 400;
        render();
    }
    window.addEventListener("resize", resizeCanvas);
    setTimeout(resizeCanvas, 100);

    function snapToGrid(pos) {
        return { x: Math.round(pos.x / gridSize) * gridSize, y: Math.round(pos.y / gridSize) * gridSize };
    }
    function getMousePos(e) {
        const r = canvasElement.getBoundingClientRect();
        return { x: e.clientX - r.left, y: e.clientY - r.top };
    }
    function getPointAt(pos) {
        return points.find(p => Math.abs(p.x - pos.x) < 15 && Math.abs(p.y - pos.y) < 15);
    }
    function drawGrid() {
        ctx.save();
        ctx.strokeStyle = "#e9ecef";
        ctx.lineWidth = 1;
        for (let x = 0; x <= canvasElement.width; x += gridSize) {
            ctx.beginPath();
            ctx.moveTo(x, 0);
            ctx.lineTo(x, canvasElement.height);
            ctx.stroke();
        }
        for (let y = 0; y <= canvasElement.height; y += gridSize) {
            ctx.beginPath();
            ctx.moveTo(0, y);
            ctx.lineTo(canvasElement.width, y);
            ctx.stroke();
        }
        ctx.restore();
    }

    canvasElement.addEventListener("mousedown", (e) => {
        const rawPos = getMousePos(e);
        const snappedPos = snapToGrid(rawPos);
        const existingPoint = getPointAt(rawPos);
        if (points.length < 3) {
            if (!getPointAt(snappedPos)) {
                points.push(snappedPos);
                render();
            }
        } else if (points.length === 3 && existingPoint) {
            isDragging = true;
            dragStartPoint = existingPoint;
            currentMousePos = rawPos;
        }
    });
    canvasElement.addEventListener("mousemove", (e) => {
        currentMousePos = getMousePos(e);
        if (isDragging) render();
    });
    canvasElement.addEventListener("mouseup", (e) => {
        if (isDragging) {
            const rawPos = getMousePos(e);
            const targetPoint = getPointAt(rawPos);
            if (targetPoint && targetPoint !== dragStartPoint) {
                const exists = lines.some(l => (l.start === dragStartPoint && l.end === targetPoint) || (l.start === targetPoint && l.end === dragStartPoint));
                if (!exists) {
                    lines.push({ start: dragStartPoint, end: targetPoint });
                    if (lines.length === 3) checkTriangle();
                }
            }
        }
        isDragging = false;
        dragStartPoint = null;
        render();
    });

    function checkTriangle() {
        const [p1, p2, p3] = points;
        const d1 = distSq(p1, p2);
        const d2 = distSq(p2, p3);
        const d3 = distSq(p3, p1);
        const sides = [d1, d2, d3].sort((a, b) => a - b);
        const isRightAngled = (Math.abs((sides[0] + sides[1]) - sides[2]) < 0.1);
        rightAngleVertexIndex = -1;
        if (isRightAngled) {
            for (let i = 0; i < 3; i++) {
                const pCurrent = points[i];
                const pPrev = points[(i + 2) % 3];
                const pNext = points[(i + 1) % 3];
                const v1 = { x: pPrev.x - pCurrent.x, y: pPrev.y - pCurrent.y };
                const v2 = { x: pNext.x - pCurrent.x, y: pNext.y - pCurrent.y };
                const dot = v1.x * v2.x + v1.y * v2.y;
                if (Math.abs(dot) < 0.1) {
                    rightAngleVertexIndex = i;
                    break;
                }
            }
        }
        updateUI(isRightAngled);
    }
    function distSq(p1, p2) {
        return Math.pow((p1.x - p2.x) / gridSize, 2) + Math.pow((p1.y - p2.y) / gridSize, 2);
    }

    function updateUI(isCorrect) {
        const initial = document.getElementById('initialState');
        const success = document.getElementById('successState');
        const fail = document.getElementById('failState');
        initial.classList.add('d-none');
        success.classList.add('d-none');
        fail.classList.add('d-none');
        if (isCorrect) {
            success.classList.remove('d-none');
            document.getElementById('statusCard').style.backgroundColor = "#e8f5e9";
            unlockQuiz();
        } else {
            fail.classList.remove('d-none');
            document.getElementById('statusCard').style.backgroundColor = "#ffebee";
            lockQuiz();
        }
    }

    function render() {
        ctx.clearRect(0, 0, canvasElement.width, canvasElement.height);
        drawGrid();
        ctx.save();
        ctx.lineWidth = 3;
        ctx.strokeStyle = "#212529";
        ctx.beginPath();
        lines.forEach(l => {
            ctx.moveTo(l.start.x, l.start.y);
            ctx.lineTo(l.end.x, l.end.y);
        });
        ctx.stroke();
        if (lines.length === 3) {
            ctx.fillStyle = "rgba(13, 110, 253, 0.1)";
            ctx.beginPath();
            ctx.moveTo(points[0].x, points[0].y);
            ctx.lineTo(points[1].x, points[1].y);
            ctx.lineTo(points[2].x, points[2].y);
            ctx.closePath();
            ctx.fill();
            drawRightAngleSymbol();
        }
        ctx.restore();
        if (isDragging && dragStartPoint) {
            ctx.save();
            ctx.beginPath();
            ctx.moveTo(dragStartPoint.x, dragStartPoint.y);
            ctx.lineTo(currentMousePos.x, currentMousePos.y);
            ctx.strokeStyle = "#adb5bd";
            ctx.setLineDash([5, 5]);
            ctx.lineWidth = 2;
            ctx.stroke();
            ctx.restore();
        }
        points.forEach((p, i) => {
            const labels = ["A", "B", "C"];
            const isHovered = isDragging && Math.abs(p.x - currentMousePos.x) < 15 && Math.abs(p.y - currentMousePos.y) < 15;
            const isActive = (p === dragStartPoint) || isHovered;
            ctx.fillStyle = isActive ? "#198754" : "#0d6efd";
            ctx.strokeStyle = "#fff";
            ctx.lineWidth = 2;
            ctx.beginPath();
            ctx.arc(p.x, p.y, isActive ? 8 : 6, 0, Math.PI * 2);
            ctx.fill();
            ctx.stroke();
            ctx.fillStyle = "#000";
            ctx.font = "bold 14px Arial";
            ctx.fillText(labels[i], p.x + 10, p.y - 10);
        });
    }

    function drawRightAngleSymbol() {
        if (rightAngleVertexIndex !== -1) {
            const i = rightAngleVertexIndex;
            drawSquareSymbol(points[i], points[(i + 2) % 3], points[(i + 1) % 3]);
        }
    }

    function drawSquareSymbol(corner, pA, pB) {
        ctx.save();
        const size = 15;
        const angleA = Math.atan2(pA.y - corner.y, pA.x - corner.x);
        const angleB = Math.atan2(pB.y - corner.y, pB.x - corner.x);
        ctx.strokeStyle = "#dc3545";
        ctx.lineWidth = 2;
        ctx.beginPath();
        const dx1 = Math.cos(angleA) * size;
        const dy1 = Math.sin(angleA) * size;
        const dx2 = Math.cos(angleB) * size;
        const dy2 = Math.sin(angleB) * size;
        ctx.moveTo(corner.x + dx1, corner.y + dy1);
        ctx.lineTo(corner.x + dx1 + dx2, corner.y + dy1 + dy2);
        ctx.lineTo(corner.x + dx2, corner.y + dy2);
        ctx.stroke();
        ctx.fillStyle = "#dc3545";
        ctx.font = "bold 12px Arial";
        ctx.textAlign = "center";
        ctx.textBaseline = "middle";
        ctx.fillText("90°", corner.x + (dx1 + dx2) * 2.2, corner.y + (dy1 + dy2) * 2.2);
        ctx.restore();
    }

    window.resetCanvas = function () {
        points = [];
        lines = [];
        isDragging = false;
        dragStartPoint = null;
        rightAngleVertexIndex = -1;
        document.getElementById('initialState').classList.remove('d-none');
        document.getElementById('successState').classList.add('d-none');
        document.getElementById('failState').classList.add('d-none');
        document.getElementById('statusCard').style.backgroundColor = "";
        lockQuiz();
        render();
    };
    resizeCanvas();
}

let attemptQuiz = 0;
function unlockQuiz() {
    const overlay = document.getElementById('quizLockOverlay');
    if (overlay) overlay.classList.add('d-none');
    ['q1', 'q2', 'q3', 'btnPeriksaQuiz'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.disabled = false;
    });
}

function lockQuiz() {
    const overlay = document.getElementById('quizLockOverlay');
    if (overlay) overlay.classList.remove('d-none');
    if (document.getElementById('triangleQuizForm')) document.getElementById('triangleQuizForm').reset();
    if (document.getElementById('quizFeedback')) document.getElementById('quizFeedback').style.display = 'none';
    ['q1', 'q2', 'q3', 'btnPeriksaQuiz'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.disabled = true;
    });
}

function checkQuizAnswers() {
    const a1 = document.getElementById('q1').value;
    const a2 = document.getElementById('q2').value;
    const a3 = document.getElementById('q3').value;
    const feedback = document.getElementById('quizFeedback');

    if (a1 === '' || a2 === '' || a3 === '') {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Silakan pilih semua dropdown jawaban yang tersedia terlebih dahulu.', confirmButtonColor: '#ffc107' });
        return;
    }

    let correctSidePair = "";
    if (rightAngleVertexIndex === 0) correctSidePair = "ab_ac";
    else if (rightAngleVertexIndex === 1) correctSidePair = "ab_bc";
    else if (rightAngleVertexIndex === 2) correctSidePair = "ac_bc";

    attemptQuiz++;
    if (a1 === '90' && a2 === correctSidePair && a3 === 'depan') {
        feedback.style.display = 'block';
        feedback.className = "alert alert-success border-success mt-4 text-center animate__animated animate__fadeInUp";
        feedback.innerHTML = `<h6 class="fw-bold mb-1">Semua Jawaban Benar!</h6><p class="mb-0 small">Selanjutnya kita memahami penamaan segitiga siku-siku.</p>`;

        simpanProgressMateri1('m1_cp6_kuis_canvas', 15);

        swalLatihanMateri1('#btnPeriksaQuiz', {
            icon: 'success',
            title: '+15 Poin!',
            html: 'Semua jawaban kuis kamu benar!<br><small class="text-muted">Kamu hebat, terus asah kemampuanmu!</small>',
            confirmButtonColor: '#198754'
        }).then(() => {
            selesaikanAktivitasMateri1('#btnPeriksaQuiz', function () {
                if (typeof resetCanvas === 'function') resetCanvas();

                setTimeout(() => {
                    if (typeof lockQuiz === 'function') lockQuiz();
                    attemptQuiz = 0;
                }, 0);
            });
        });
    } else {
        if (attemptQuiz >= MAX_ATTEMPT_LATIHAN) {
            Swal.fire({ icon: 'info', title: 'Kesempatan Habis', text: 'Mari kita lihat jawaban yang tepat.', confirmButtonColor: '#0d6efd', allowOutsideClick: false }).then(() => {
                document.getElementById('q1').value = '90';
                document.getElementById('q2').value = correctSidePair;
                document.getElementById('q3').value = 'depan';
                ['q1', 'q2', 'q3', 'btnPeriksaQuiz'].forEach(id => document.getElementById(id).disabled = true);
                feedback.style.display = 'block';
                feedback.className = "alert alert-primary border-primary mt-4 text-center animate__animated animate__fadeInUp";
                feedback.innerHTML = `<h6 class="fw-bold mb-1">Ini adalah jawaban yang benar</h6><p class="mb-0 small">Selanjutnya kita memahami penamaan segitiga siku-siku.</p>`;

                selesaikanKesempatanHabisMateri1(
                    'm1_cp6_kuis_canvas',
                    '#btnPeriksaQuiz',
                    function () {
                        if (typeof resetCanvas === 'function') resetCanvas();

                        setTimeout(() => {
                            if (typeof lockQuiz === 'function') lockQuiz();
                            attemptQuiz = 0;
                        }, 0);
                    }
                );
            });
        } else {
            feedback.style.display = 'block';
            feedback.className = "alert alert-danger border-danger mt-4 text-center animate__animated animate__shakeX";
            feedback.innerHTML = `<span class="fw-bold small">Ada yang belum tepat.</span><p class="mb-0 small mt-1">Periksa lagi huruf pada sudut siku-siku di gambarmu.</p>`;
            swalLatihanMateri1('#btnPeriksaQuiz', {
                icon: 'error',
                title: 'Kurang Tepat',
                text: `Jawabanmu ada yang salah. Sisa kesempatan: ${MAX_ATTEMPT_LATIHAN - attemptQuiz}`,
                confirmButtonColor: '#dc3545'
            });
        }
    }
}

/* ===============================
   MATERI 1: MENGENAL SISI SEGITIGA & JAWABAN LAINNYA
================================ */
function cekJawabanSikusiku() {
    const jawabanEl = document.getElementById('inputTitikSudut');
    if (!jawabanEl) return;
    const jawabanBersih = jawabanEl.value.toLowerCase().replace(/[^a-z]/g, '');
    const feedbackBenar = document.getElementById('feedbackBenar');
    const feedbackSalah = document.getElementById('feedbackSalah');
    feedbackBenar.classList.add('d-none');
    feedbackSalah.classList.add('d-none');

    if (jawabanBersih === '') {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Silakan isi kotak jawaban Anda terlebih dahulu.', confirmButtonColor: '#ffc107' });
        return;
    }

    // (Bypass karena input ini bukan tipe kuis 3x coba, cukup informatif saja)
    if (jawabanBersih === 'b' || jawabanBersih === 'titikb') {
        feedbackBenar.classList.remove('d-none');
        feedbackBenar.querySelector('.alert div').innerHTML = '<strong>Tepat Sekali</strong>. Sudut B memiliki ukuran tepat 90° dan disebut sudut siku-siku. Oleh karena itu, segitiga tersebut merupakan <strong>segitiga siku-siku</strong>, karena memiliki salah satu sudut yang ukurannya tepat 90°.';
        simpanProgressMateri1('m1_cp5_titik_siku', 10);
    } else {
        feedbackSalah.classList.remove('d-none');
        feedbackSalah.querySelector('.alert').className = 'alert alert-danger d-flex align-items-center py-2 mb-0';
        feedbackSalah.querySelector('.alert div').innerText = 'Jawaban Anda kurang tepat. Perhatikan kembali titik sudut pada GeoGebra.';
    }
}

function normalizeSegment(str) {
    return str ? str.trim().toUpperCase().split('').sort().join('') : "";
}
let attemptSisi = 0;

function resetPenamaanSisi() {
    document.querySelectorAll('.sisi-input, .input-ruas').forEach(input => {
        input.value = '';
        input.disabled = false;
        input.classList.remove('is-valid', 'is-invalid');
    });

    const feedbackEl = document.getElementById('final-feedback');
    if (feedbackEl) {
        feedbackEl.className = 'mt-3 fw-bold';
        feedbackEl.innerHTML = '';
    }

    attemptSisi = 0;
}

function checkAllAnswers() {
    let totalErrors = 0;
    let isKosong = false;
    const sisiInputs = document.querySelectorAll('.sisi-input');
    const ruasInputs = document.querySelectorAll('.input-ruas');
    if (sisiInputs.length === 0) return;

    sisiInputs.forEach(input => {
        if (input.value.trim() === '') isKosong = true;
    });
    ruasInputs.forEach(input => {
        if (input.value.trim() === '') isKosong = true;
    });

    if (isKosong) {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Silakan isi semua kotak penamaan sisi terlebih dahulu.', confirmButtonColor: '#ffc107' });
        return;
    }

    attemptSisi++;
    sisiInputs.forEach(input => {
        let userVal = input.value.trim();
        let correctSmall = input.getAttribute('data-answer');
        let correctSegment = (correctSmall === 'a') ? "BC" : (correctSmall === 'n' ? "MO" : (correctSmall === 'p' ? "QR" : ""));
        let userNormalized = normalizeSegment(userVal);
        let segmentNormalized = normalizeSegment(correctSegment);

        if ((userVal.toLowerCase() === correctSmall) || (userNormalized === segmentNormalized && userNormalized.length === 2)) {
            input.classList.add('is-valid');
            input.classList.remove('is-invalid');
        } else {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            totalErrors++;
        }
    });

    ruasInputs.forEach(input => {
        let userVal = normalizeSegment(input.value);
        let correctVal = normalizeSegment(input.getAttribute('data-correct'));
        if (userVal === correctVal && userVal !== "") {
            input.classList.add('is-valid');
            input.classList.remove('is-invalid');
        } else {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            totalErrors++;
        }
    });

    let feedbackEl = document.getElementById('final-feedback');
    if (totalErrors === 0) {
        if (feedbackEl) {
            feedbackEl.className = "mt-3 fw-bold text-success";
            feedbackEl.innerHTML = "Luar Biasa! Semua jawabanmu benar.";
        }
        simpanProgressMateri1('m1_cp7_tabel_penamaan_sisi', 15);

        swalLatihanMateri1('button[onclick="checkAllAnswers()"]', {
            icon: 'success',
            title: '+15 Poin!',
            html: 'Semua penamaan sisi segitiga benar. Kerja bagus!<br><small class="text-muted">Selamat! Kamu semakin paham.</small>',
            confirmButtonColor: '#198754'
        }).then(() => {
            selesaikanAktivitasMateri1(
                'button[onclick="checkAllAnswers()"]',
                resetPenamaanSisi
            );
        });
    } else if (attemptSisi >= MAX_ATTEMPT_LATIHAN) {
        Swal.fire({ icon: 'info', title: 'Kesempatan Habis', text: 'Mari kita lihat jawaban yang tepat.', confirmButtonText: 'Tampilkan Jawaban', confirmButtonColor: '#0d6efd', allowOutsideClick: false }).then(() => {
            sisiInputs.forEach(input => {
                input.value = input.getAttribute('data-answer');
                input.classList.replace('is-invalid', 'is-valid');
                input.disabled = true;
            });
            ruasInputs.forEach(input => {
                input.value = input.getAttribute('data-correct');
                input.classList.replace('is-invalid', 'is-valid');
                input.disabled = true;
            });
            if (feedbackEl) {
                feedbackEl.className = "mt-3 fw-bold text-primary";
                feedbackEl.innerHTML = "Ini adalah penamaan yang benar.";

            }
            selesaikanKesempatanHabisMateri1(
                'm1_cp7_tabel_penamaan_sisi',
                'button[onclick="checkAllAnswers()"]',
                resetPenamaanSisi
            );
        });
    } else {
        if (feedbackEl) {
            feedbackEl.className = "mt-3 fw-bold text-danger";
            feedbackEl.innerHTML = `Masih ada ${totalErrors} kotak yang belum tepat.`;
        }
        swalLatihanMateri1('button[onclick="checkAllAnswers()"]', {
            icon: 'error',
            title: 'Masih ada kesalahan',
            text: `Perhatikan kotak yang berwarna merah. Sisa kesempatan: ${MAX_ATTEMPT_LATIHAN - attemptSisi}`,
            confirmButtonColor: '#dc3545'
        });
    }
}

function resetTabelGeoGebra() {
    const ids = [
        'sisi_a', 'sisi_b', 'sisi_c',
        'luas_a_1', 'luas_a_2', 'luas_a_sq', 'luas_a_hasil',
        'luas_b_1', 'luas_b_2', 'luas_b_sq', 'luas_b_hasil',
        'luas_c_1', 'luas_c_2', 'luas_c_sq', 'luas_c_hasil'
    ];

    ids.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.value = '';
            el.disabled = false;
            el.classList.remove('is-valid', 'is-invalid');
        }
    });

    const feedbackBox = document.getElementById('feedbackTabelGeoGebra');
    if (feedbackBox) {
        feedbackBox.className = 'mt-2 fw-bold';
        feedbackBox.innerHTML = '';
    }

    attemptTabelGeo = 0;
}

let attemptTabelGeo = 0;
function cekTabelGeoGebra() {
    const kunci = {
        sisi_a: 3, sisi_b: 4, sisi_c: 5,
        luas_a_1: 3, luas_a_2: 3, luas_a_sq: 3, luas_a_hasil: 9,
        luas_b_1: 4, luas_b_2: 4, luas_b_sq: 4, luas_b_hasil: 16,
        luas_c_1: 5, luas_c_2: 5, luas_c_sq: 5, luas_c_hasil: 25
    };
    let benarSemua = true;
    let adaKosong = false;

    for (let id in kunci) {
        let elemenInput = document.getElementById(id);
        if (!elemenInput) continue;
        let nilaiInput = elemenInput.value.trim();
        if (nilaiInput === "") {
            adaKosong = true;
            break;
        }
    }

    if (adaKosong) {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Silakan isi semua kotak penjabaran perhitungan terlebih dahulu.', confirmButtonColor: '#ffc107' });
        return;
    }

    attemptTabelGeo++;
    for (let id in kunci) {
        let elemenInput = document.getElementById(id);
        if (!elemenInput) continue;
        let nilaiInput = elemenInput.value.trim();
        elemenInput.classList.remove('is-valid', 'is-invalid');
        if (parseInt(nilaiInput) === kunci[id]) elemenInput.classList.add('is-valid');
        else {
            elemenInput.classList.add('is-invalid');
            benarSemua = false;
        }
    }

    const feedbackBox = document.getElementById('feedbackTabelGeoGebra');
    if (benarSemua) {
        if (feedbackBox) {
            feedbackBox.className = "mt-2 fw-bold text-success animate__animated animate__fadeInUp";
            feedbackBox.innerHTML = "Luar biasa! Perhitungan luas persegimu sangat tepat.";
        }
        simpanProgressMateri1('m1_cp8_tabel_luas_geogebra', 15);

        swalLatihanMateri1('button[onclick="cekTabelGeoGebra()"]', {
            icon: 'success',
            title: '+15 Poin!',
            html: 'Kamu berhasil menjabarkan perhitungan luas ketiga persegi dengan konsep kuadrat yang benar.<br><small class="text-muted">Mantap! Lanjutkan!</small>',
            confirmButtonColor: '#198754'
        }).then(() => {
            selesaikanAktivitasMateri1(
                'button[onclick="cekTabelGeoGebra()"]',
                resetTabelGeoGebra
            );
        });
    } else if (attemptTabelGeo >= MAX_ATTEMPT_LATIHAN) {
        Swal.fire({
            icon: 'info',
            title: 'Kesempatan Habis',
            text: 'Mari kita lihat jawaban yang tepat.',
            confirmButtonText: 'Tampilkan Jawaban',
            confirmButtonColor: '#0d6efd',
            allowOutsideClick: false
        }).then(() => {
            for (let id in kunci) {
                let el = document.getElementById(id);
                if (el) {
                    el.value = kunci[id];
                    el.classList.replace('is-invalid', 'is-valid');
                    el.disabled = true;
                }
            }

            if (feedbackBox) {
                feedbackBox.className = "mt-2 fw-bold text-primary animate__animated animate__fadeInUp";
                feedbackBox.innerHTML = "Ini adalah perhitungan yang benar.";
            }

            selesaikanKesempatanHabisMateri1(
                'm1_cp8_tabel_luas_geogebra',
                'button[onclick="cekTabelGeoGebra()"]',
                resetTabelGeoGebra
            );
        });
    } else {
        if (feedbackBox) {
            feedbackBox.className = "mt-2 fw-bold text-danger animate__animated animate__shakeX";
            feedbackBox.innerHTML = "Masih ada angka yang keliru. Cek kotak yang berwarna merah.";
        }

        swalLatihanMateri1('button[onclick="cekTabelGeoGebra()"]', {
            icon: 'error',
            title: 'Masih ada yang salah',
            text: `Coba periksa kembali perhitungan pada kotak merah. Sisa kesempatan: ${MAX_ATTEMPT_LATIHAN - attemptTabelGeo}`,
            confirmButtonColor: '#dc3545'
        });
    }
}

// Bagian ini hanya pilihan singkat, jadi langsung bypass tanpa 3x attempt
function cekSoal1geogebra(status, btn) {
    const container = btn.closest('.row');
    container.querySelectorAll('.btn-soal1').forEach(b => {
        b.classList.remove('btn-success', 'btn-danger', 'text-white');
        b.classList.add('btn-outline-success');
    });
    const feedbackBenar = document.getElementById('feedbackBenar1');
    const feedbackSalah = document.getElementById('feedbackSalah1');
    feedbackBenar.classList.add('d-none');
    feedbackSalah.classList.add('d-none');
    btn.classList.remove('btn-outline-success');
    if (status === 'benar') {
        btn.classList.add('btn-success', 'text-white');
        feedbackBenar.classList.remove('d-none');
    } else {
        btn.classList.add('btn-danger', 'text-white');
        feedbackSalah.classList.remove('d-none');
    }
}

function cekPilihan(status, btn) {
    const container = btn.closest('.row');
    container.querySelectorAll('.btn-pilihan').forEach(b => {
        b.classList.remove('btn-success', 'btn-danger', 'text-white');
        b.classList.add('btn-outline-success');
    });
    const feedbackBenar = document.getElementById('feedbackBenar');
    const feedbackSalah = document.getElementById('feedbackSalah');
    const boxPenjelasan = document.getElementById('boxPenjelasanAkhir');
    feedbackBenar.classList.add('d-none');
    feedbackSalah.classList.add('d-none');
    boxPenjelasan.classList.add('d-none');
    btn.classList.remove('btn-outline-success');
    if (status === 'benar') {
        btn.classList.add('btn-success', 'text-white');
        feedbackBenar.classList.remove('d-none');
        boxPenjelasan.classList.remove('d-none');
        simpanProgressMateri1('m1_cp9_kesimpulan_luas', 10);
        setTimeout(() => boxPenjelasan.scrollIntoView({ behavior: 'smooth', block: 'center' }), 300);
    } else {
        btn.classList.add('btn-danger', 'text-white');
        feedbackSalah.classList.remove('d-none');
    }
}

// Fungsi untuk mengecek apakah ada input kosong berdasarkan array ID
function cekKosong(ids) {
    for (let id of ids) {
        let el = document.getElementById(id);
        if (!el || el.value.trim() === '') return true;
    }
    return false;
}

// Fungsi untuk memberi class valid/invalid pada elemen (bisa ID atau elemen langsung)
function setValidasiElTripel(el, condition) {
    // Jika el adalah string (ID), ambil elemennya
    if (typeof el === 'string') {
        el = document.getElementById(el);
    }
    if (!el) return;

    if (condition) {
        el.classList.add('is-valid');
        el.classList.remove('is-invalid');
    } else {
        el.classList.add('is-invalid');
        el.classList.remove('is-valid');
    }
}

function resetContoh1() {
    const ids = [
        'c1_dik_a',
        'c1_dik_b',
        'c1_step1_a',
        'c1_step1_b',
        'c1_step2_a_sq',
        'c1_step2_b_sq',
        'c1_step3_sum',
        'c1_step4_root',
        'c1_final'
    ];

    ids.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.value = '';
            el.disabled = false;
            el.classList.remove('is-valid', 'is-invalid');
        }
    });

    const feedback = document.getElementById('c1_feedback');
    if (feedback) feedback.innerHTML = '';

    attemptContoh1 = 0;
}

let attemptContoh1 = 0;
function cekContoh1() {
    const ids = ['c1_dik_a', 'c1_dik_b', 'c1_step1_a', 'c1_step1_b', 'c1_step2_a_sq', 'c1_step2_b_sq', 'c1_step3_sum', 'c1_step4_root', 'c1_final'];
    if (cekKosong(ids)) {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Lengkapi semua kotak isian terlebih dahulu.', confirmButtonColor: '#ffc107' });
        return;
    }

    attemptContoh1++;
    let benarSemua = true;
    let dik_bc = parseFloat(document.getElementById('c1_dik_a').value);
    let dik_ac = parseFloat(document.getElementById('c1_dik_b').value);
    let s1_a = parseFloat(document.getElementById('c1_step1_a').value);
    let s1_b = parseFloat(document.getElementById('c1_step1_b').value);
    let s2_a = parseFloat(document.getElementById('c1_step2_a_sq').value);
    let s2_b = parseFloat(document.getElementById('c1_step2_b_sq').value);
    let s3_sum = parseFloat(document.getElementById('c1_step3_sum').value);
    let s4_root = parseFloat(document.getElementById('c1_step4_root').value);
    let final = parseFloat(document.getElementById('c1_final').value);

    const chk = (id, cond) => {
        setValidasiElTripel(id, cond);
        if (!cond) benarSemua = false;
    };
    chk('c1_dik_a', dik_bc === 3);
    chk('c1_dik_b', dik_ac === 4);

    let validStep1 = (s1_a === 4 && s1_b === 3) || (s1_a === 3 && s1_b === 4);
    chk('c1_step1_a', validStep1);
    chk('c1_step1_b', validStep1);

    chk('c1_step2_a_sq', s2_a === Math.pow(s1_a, 2));
    chk('c1_step2_b_sq', s2_b === Math.pow(s1_b, 2));
    chk('c1_step3_sum', s3_sum === 25);
    chk('c1_step4_root', s4_root === 25);
    chk('c1_final', final === 5);

    if (benarSemua) {
        simpanProgressMateri1('m1_cp10_contoh_soal_1', 15);

        swalLatihanMateri1('button[onclick="cekContoh1()"]', {
            icon: 'success',
            title: '+15 Poin!',
            html: 'Jawaban kamu benar! Jarak yang ditempuh Ahmad adalah 5 meter.<br><small class="text-muted">Hebat, kamu jago matematika!</small>',
            confirmButtonColor: '#198754'
        }).then(() => {
            selesaikanAktivitasMateri1(
                'button[onclick="cekContoh1()"]',
                resetContoh1
            );
        });
    } else if (attemptContoh1 >= MAX_ATTEMPT_LATIHAN) {
        Swal.fire({ icon: 'info', title: 'Kesempatan Habis', text: 'Mari kita lihat jawaban yang tepat.', confirmButtonText: 'Tampilkan Jawaban', confirmButtonColor: '#0d6efd', allowOutsideClick: false }).then(() => {
            const ans = { 'c1_dik_a': 3, 'c1_dik_b': 4, 'c1_step1_a': 3, 'c1_step1_b': 4, 'c1_step2_a_sq': 9, 'c1_step2_b_sq': 16, 'c1_step3_sum': 25, 'c1_step4_root': 25, 'c1_final': 5 };
            for (let id in ans) {
                let el = document.getElementById(id);
                el.value = ans[id];
                setValidasiElTripel(el, true);
                el.disabled = true;
            }

            selesaikanKesempatanHabisMateri1(
                'm1_cp10_contoh_soal_1',
                'button[onclick="cekContoh1()"]',
                resetContoh1
            );
        });
    } else {
        swalLatihanMateri1('button[onclick="cekContoh1()"]', {
            icon: 'error',
            title: 'Ada yang Salah',
            text: `Periksa kotak berwarna merah. Sisa kesempatan: ${MAX_ATTEMPT_LATIHAN - attemptContoh1}`,
            confirmButtonColor: '#dc3545'
        });
    }
}

function resetContoh2() {
    const ids = [
        'c2_dik_ab',
        'c2_dik_ac',
        'c2_dik_cd',
        'c2_step1_ab',
        'c2_step1_ac',
        'c2_step1_res1',
        'c2_step1_res2',
        'c2_step1_sqrt',
        'c2_bc_result',
        'c2_step2_bc',
        'c2_step2_cd',
        'c2_step2_res1',
        'c2_step2_res2',
        'c2_step2_sqrt',
        'c2_final'
    ];

    ids.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.value = '';
            el.disabled = false;
            el.classList.remove('is-valid', 'is-invalid');
        }
    });

    const feedback = document.getElementById('c2_feedback');
    if (feedback) feedback.innerHTML = '';

    attemptContoh2 = 0;
}

let attemptContoh2 = 0;
function cekContoh2() {
    const ids = ['c2_dik_ab', 'c2_dik_ac', 'c2_dik_cd', 'c2_step1_ab', 'c2_step1_ac', 'c2_step1_res1', 'c2_step1_res2', 'c2_step1_sqrt', 'c2_bc_result', 'c2_step2_bc', 'c2_step2_cd', 'c2_step2_res1', 'c2_step2_res2', 'c2_step2_sqrt', 'c2_final'];
    if (cekKosong(ids)) {
        Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Lengkapi semua kotak isian terlebih dahulu.', confirmButtonColor: '#ffc107' });
        return;
    }

    attemptContoh2++;
    let benarSemua = true;
    const chk = (id, cond) => {
        setValidasiElTripel(id, cond);
        if (!cond) benarSemua = false;
    };

    chk('c2_dik_ab', parseFloat(document.getElementById('c2_dik_ab').value) === 13);
    chk('c2_dik_ac', parseFloat(document.getElementById('c2_dik_ac').value) === 12);
    chk('c2_dik_cd', parseFloat(document.getElementById('c2_dik_cd').value) === 3);
    chk('c2_step1_ab', parseFloat(document.getElementById('c2_step1_ab').value) === 13);
    chk('c2_step1_ac', parseFloat(document.getElementById('c2_step1_ac').value) === 12);
    chk('c2_step1_res1', parseFloat(document.getElementById('c2_step1_res1').value) === 169);
    chk('c2_step1_res2', parseFloat(document.getElementById('c2_step1_res2').value) === 144);
    chk('c2_step1_sqrt', parseFloat(document.getElementById('c2_step1_sqrt').value) === 25);
    chk('c2_bc_result', parseFloat(document.getElementById('c2_bc_result').value) === 5);

    chk('c2_step2_bc', parseFloat(document.getElementById('c2_step2_bc').value) === 5);
    chk('c2_step2_cd', parseFloat(document.getElementById('c2_step2_cd').value) === 3);
    chk('c2_step2_res1', parseFloat(document.getElementById('c2_step2_res1').value) === 25);
    chk('c2_step2_res2', parseFloat(document.getElementById('c2_step2_res2').value) === 9);
    chk('c2_step2_sqrt', parseFloat(document.getElementById('c2_step2_sqrt').value) === 16);
    chk('c2_final', parseFloat(document.getElementById('c2_final').value) === 4);

    if (benarSemua) {
        simpanProgressMateri1('m1_cp11_contoh_soal_2', 15);

        swalLatihanMateri1('button[onclick="cekContoh2()"]', {
            icon: 'success',
            title: '+15 Poin!',
            html: 'Kamu berhasil menyelesaikan soal bertingkat ini dengan benar.<br><small class="text-muted">Pertahankan semangat belajarmu!</small>',
            confirmButtonColor: '#198754'
        }).then(() => {
            selesaikanAktivitasMateri1(
                'button[onclick="cekContoh2()"]',
                resetContoh2
            );
        });
    } else if (attemptContoh2 >= MAX_ATTEMPT_LATIHAN) {
        Swal.fire({ icon: 'info', title: 'Kesempatan Habis', text: 'Mari kita lihat jawaban yang tepat.', confirmButtonText: 'Tampilkan Jawaban', confirmButtonColor: '#0d6efd', allowOutsideClick: false }).then(() => {
            const ans = { 'c2_dik_ab': 13, 'c2_dik_ac': 12, 'c2_dik_cd': 3, 'c2_step1_ab': 13, 'c2_step1_ac': 12, 'c2_step1_res1': 169, 'c2_step1_res2': 144, 'c2_step1_sqrt': 25, 'c2_bc_result': 5, 'c2_step2_bc': 5, 'c2_step2_cd': 3, 'c2_step2_res1': 25, 'c2_step2_res2': 9, 'c2_step2_sqrt': 16, 'c2_final': 4 };
            for (let id in ans) {
                let el = document.getElementById(id);
                el.value = ans[id];
                setValidasiElTripel(el, true);
                el.disabled = true;
            }
            selesaikanKesempatanHabisMateri1(
                'm1_cp11_contoh_soal_2',
                'button[onclick="cekContoh2()"]',
                resetContoh2
            );
        });
    } else {
        swalLatihanMateri1('button[onclick="cekContoh2()"]', {
            icon: 'error',
            title: 'Ada yang Salah',
            text: `Periksa kotak berwarna merah. Sisa kesempatan: ${MAX_ATTEMPT_LATIHAN - attemptContoh2}`,
            confirmButtonColor: '#dc3545'
        });
    }
}

function cekRefleksi() {
    const form = document.getElementById('formRefleksi');
    const formData = new FormData(form);
    const btnSubmit = document.getElementById('btnSimpanRefleksi');
    const feedbackArea = document.getElementById('refleksi_feedback');

    // 1. Validasi: Pastikan semua textarea yang required sudah diisi
    if (!form.checkValidity()) {
        form.reportValidity(); // Memunculkan peringatan bawaan browser
        return;
    }

    // 2. Ubah status tombol untuk memberikan feedback visual ke siswa
    btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    btnSubmit.disabled = true;
    feedbackArea.innerHTML = '';

    // 3. Ambil URL aman dari atribut action form HTML
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
        if(data.status === 'success') {
            // Berikan feedback text di bawah kotak
            feedbackArea.innerHTML = `<div class="alert alert-success py-2 small fw-bold mb-0">${data.message}</div>`;
            btnSubmit.innerHTML = 'Tersimpan <i class="fas fa-check ms-1"></i>';
            btnSubmit.classList.replace('btn-success', 'btn-secondary');
            
            // Simpan progres ke database (bernilai 10 Poin sesuai MATERI1_AKTIVITAS)
            if (typeof simpanProgressMateri1 === 'function') {
                simpanProgressMateri1('m1_cp15_refleksi_akhir', 10);
            }

            // MUNCULKAN SWEETALERT +10 POIN
            if (typeof swalLatihanMateri1 === 'function') {
                swalLatihanMateri1('#btnSimpanRefleksi', {
                    icon: 'success',
                    title: '+10 Poin!',
                    html: 'Terima kasih sudah mengisi refleksi belajarmu dengan jujur!<br><small class="text-muted">Progres belajarmu telah berhasil tersimpan.</small>',
                    confirmButtonColor: '#198754'
                }).then(() => {
                    // Opsional: Gulir sedikit ke bawah agar teks "lanjut ke Kuis 1" terlihat
                    const nextText = document.querySelector('.materi-page[data-page="5"] .border-top p');
                    if (nextText) nextText.scrollIntoView({ behavior: 'smooth', block: 'center' });
                });
            }

        } else {
            feedbackArea.innerHTML = `<div class="alert alert-danger py-2 small fw-bold mb-0">Gagal menyimpan data.</div>`;
            btnSubmit.innerHTML = 'Coba Lagi';
            btnSubmit.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error Refleksi:', error);
        feedbackArea.innerHTML = `<div class="alert alert-danger py-2 small fw-bold mb-0">Terjadi kesalahan koneksi ke server.</div>`;
        btnSubmit.innerHTML = 'Simpan Refleksi';
        btnSubmit.disabled = false;
    });
}

/* =====================================================
   AKTIFASI MODE REVIEW UNTUK SETIAP LATIHAN
===================================================== */
document.addEventListener('DOMContentLoaded', function () {

    // Pastikan fungsi setupReviewMode sudah termuat dari script.js
    if (typeof window.setupReviewMode === 'function') {

        // ---------------------------------------------------------
        // 1. Latihan: Menebak Jenis Segitiga (Halaman 1)
        // ---------------------------------------------------------
        window.setupReviewMode(
            'm1_cp1_segitiga_jembatan',
            'button[onclick="cekJawabanSegitigaSikuSiku()"]',
            function showAnswer() {
                const input = document.getElementById('inputJawaban');
                const penjelasanBox = document.getElementById('penjelasan-pythagoras');
                if (input) {
                    input.value = 'siku-siku';
                    input.disabled = true;
                    input.classList.add('is-valid', 'border-success');
                }
                if (penjelasanBox) penjelasanBox.classList.remove('d-none');
            },
            function resetExercise() {
                const input = document.getElementById('inputJawaban');
                const penjelasanBox = document.getElementById('penjelasan-pythagoras');
                const feedback = document.getElementById('feedbackPesan');
                if (input) {
                    input.value = '';
                    input.disabled = false;
                    input.classList.remove('is-valid', 'border-success');
                }
                if (feedback) feedback.innerHTML = '';
                if (penjelasanBox) penjelasanBox.classList.add('d-none');
            }
        );

        // ---------------------------------------------------------
        // 2. Latihan: Drag & Drop Sisi Segitiga (Halaman 1)
        // ---------------------------------------------------------
        window.setupReviewMode(
            'm1_cp2_dragdrop_sisi',
            '#check-matching',
            function showAnswer() {
                const dragSource = document.getElementById('drag-source');
                const dropZones = document.querySelectorAll('.drop-zone[data-correct]');
                const resetBtn = document.getElementById('reset-matching'); // Tombol ulangi bawaan drag & drop
                const penguatan = document.getElementById('penguatan-materi-dragdrop');

                if (!dragSource || dropZones.length === 0) return;

                // Isi otomatis jawaban yang benar
                dropZones.forEach(zone => {
                    const correctVal = zone.getAttribute('data-correct');
                    const correctItem = dragSource.querySelector(`.drag-item[data-value="${correctVal}"]`) || document.querySelector(`.drag-item[data-value="${correctVal}"]`);
                    if (correctItem) {
                        zone.appendChild(correctItem);
                        zone.style.borderColor = '#198754';
                        zone.style.backgroundColor = '#d1e7dd';
                        zone.classList.add('correct-answer');
                        const fb = zone.parentNode.querySelector('.feedback-msg');
                        if (fb) fb.innerHTML = '<span class="text-success small fw-bold">Tepat!</span>';
                    }
                });

                if (penguatan) penguatan.classList.remove('d-none');
                if (resetBtn) resetBtn.style.display = 'none'; // Sembunyikan tombol Ulangi bawaan HTML
            },
            function resetExercise() {
                const dragSource = document.getElementById('drag-source');
                const dropZones = document.querySelectorAll('.drop-zone[data-correct]');
                const resetBtn = document.getElementById('reset-matching');
                const penguatan = document.getElementById('penguatan-materi-dragdrop');

                // Kembalikan item ke tempat asal
                document.querySelectorAll('.drag-item').forEach(item => {
                    dragSource.appendChild(item);
                });

                dropZones.forEach(zone => {
                    zone.style.borderStyle = 'dashed';
                    zone.style.borderColor = '#198754';
                    zone.style.backgroundColor = '#f8f9fa';
                    zone.classList.remove('correct-answer', 'bg-light-success');
                    const fb = zone.parentNode.querySelector('.feedback-msg');
                    if (fb) fb.innerHTML = '';
                });

                if (penguatan) penguatan.classList.add('d-none');
                if (resetBtn) resetBtn.style.display = 'inline-block'; // Munculkan lagi
            }
        );

        // ---------------------------------------------------------
        // 3. Latihan: Tabel Bilangan Kuadrat (Halaman 2)
        // ---------------------------------------------------------
        window.setupReviewMode(
            'm1_cp3_tabel_kuadrat',
            '#btnCekKuadrat',
            function showAnswer() {
                const container = document.getElementById('kuadrat-container');
                const penguatan = document.getElementById('penguatan-materi');
                if (!container) return;

                container.querySelectorAll('.input-kuadrat').forEach(input => {
                    input.value = input.getAttribute('data-answer');
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                    input.disabled = true;
                });

                if (penguatan) penguatan.classList.remove('d-none');
            },
            function resetExercise() {
                const container = document.getElementById('kuadrat-container');
                const penguatan = document.getElementById('penguatan-materi');
                if (!container) return;

                container.querySelectorAll('.input-kuadrat').forEach(input => {
                    input.value = '';
                    input.classList.remove('is-valid', 'is-invalid');
                    input.disabled = false;
                });

                if (penguatan) penguatan.classList.add('d-none');
            }
        );

        // ---------------------------------------------------------
        // 4. Latihan: Akar Kuadrat (Halaman 2)
        // ---------------------------------------------------------
        window.setupReviewMode(
            'm1_cp4_isian_akar',
            '#btnCekAkar',
            function showAnswer() {
                const container = document.getElementById('akar-container');
                if (!container) return;

                container.querySelectorAll('.input-akar').forEach(input => {
                    input.value = input.getAttribute('data-answer');
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                    input.disabled = true;
                });
            },
            function resetExercise() {
                const container = document.getElementById('akar-container');
                if (!container) return;

                container.querySelectorAll('.input-akar').forEach(input => {
                    input.value = '';
                    input.classList.remove('is-valid', 'is-invalid');
                    input.disabled = false;
                });
            }
        );

        // ---------------------------------------------------------
        // 5. Latihan: Titik Sudut Siku-Siku (GeoGebra 1)
        // ---------------------------------------------------------
        window.setupReviewMode(
            'm1_cp5_titik_siku',
            'button[onclick="cekJawabanSikusiku()"]',
            function showAnswer() {
                const input = document.getElementById('inputTitikSudut');
                const feedbackBenar = document.getElementById('feedbackBenar');
                if (input) {
                    input.value = 'B'; // Titik siku-sikunya adalah B
                    input.disabled = true;
                    input.classList.add('is-valid', 'border-success');
                }
                if (feedbackBenar) feedbackBenar.classList.remove('d-none');
            },
            function resetExercise() {
                const input = document.getElementById('inputTitikSudut');
                const feedbackBenar = document.getElementById('feedbackBenar');
                const feedbackSalah = document.getElementById('feedbackSalah');
                if (input) {
                    input.value = '';
                    input.disabled = false;
                    input.classList.remove('is-valid', 'border-success');
                }
                if (feedbackBenar) feedbackBenar.classList.add('d-none');
                if (feedbackSalah) feedbackSalah.classList.add('d-none');
            }
        );

        // ---------------------------------------------------------
        // 6. Latihan: Kuis Canvas (Ayo Menggambar)
        // ---------------------------------------------------------
        window.setupReviewMode(
            'm1_cp6_kuis_canvas',
            '#btnPeriksaQuiz',
            function showAnswer() {
                const overlay = document.getElementById('quizLockOverlay');
                const q1 = document.getElementById('q1');
                const q2 = document.getElementById('q2');
                const q3 = document.getElementById('q3');
                const feedback = document.getElementById('quizFeedback');

                if (overlay) overlay.classList.add('d-none'); // Buka gembok overlay

                if (q1 && q2 && q3) {
                    q1.value = '90';
                    q2.value = 'ab_bc'; // Asumsi titik siku-siku standar
                    q3.value = 'depan';

                    [q1, q2, q3].forEach(el => {
                        el.disabled = true;
                        el.classList.add('is-valid', 'border-success');
                    });
                }

                if (feedback) {
                    feedback.style.display = 'block';
                    feedback.className = "alert alert-success border-success mt-4 text-center animate__animated animate__fadeInUp";
                    feedback.innerHTML = `<h6 class="fw-bold mb-1">Semua Jawaban Benar!</h6><p class="mb-0 small">Ini adalah jawaban yang benar.</p>`;
                }
            },
            function resetExercise() {
                if (typeof resetCanvas === 'function') resetCanvas(); // Panggil fungsi reset canvas bawaanmu

                const q1 = document.getElementById('q1');
                const q2 = document.getElementById('q2');
                const q3 = document.getElementById('q3');
                const feedback = document.getElementById('quizFeedback');

                if (q1 && q2 && q3) {
                    q1.value = '';
                    q2.value = '';
                    q3.value = '';
                    [q1, q2, q3].forEach(el => el.classList.remove('is-valid', 'border-success'));
                }
                if (feedback) feedback.style.display = 'none';
            }
        );

        // ---------------------------------------------------------
        // 7. Latihan: Tabel Penamaan Sisi Segitiga
        // ---------------------------------------------------------
        window.setupReviewMode(
            'm1_cp7_tabel_penamaan_sisi',
            'button[onclick="checkAllAnswers()"]',
            function showAnswer() {
                const sisiInputs = document.querySelectorAll('.sisi-input');
                const ruasInputs = document.querySelectorAll('.input-ruas');
                const titikInputs = document.querySelectorAll('.input-titik');

                sisiInputs.forEach(input => {
                    input.value = input.getAttribute('data-answer');
                    input.classList.add('is-valid');
                    input.disabled = true;
                });
                ruasInputs.forEach(input => {
                    input.value = input.getAttribute('data-correct');
                    input.classList.add('is-valid');
                    input.disabled = true;
                });
                titikInputs.forEach(input => {
                    input.value = input.getAttribute('data-correct');
                    input.classList.add('is-valid');
                    input.disabled = true;
                });

                const feedbackEl = document.getElementById('final-feedback');
                if (feedbackEl) {
                    feedbackEl.className = "mt-3 fw-bold text-success";
                    feedbackEl.innerHTML = "Luar Biasa! Semua jawabanmu benar.";
                }
            },
            function resetExercise() {
                const allInputs = document.querySelectorAll('.sisi-input, .input-ruas, .input-titik');
                allInputs.forEach(input => {
                    input.value = '';
                    input.classList.remove('is-valid', 'is-invalid');
                    input.disabled = false;
                });
                const feedbackEl = document.getElementById('final-feedback');
                if (feedbackEl) feedbackEl.innerHTML = '';
            }
        );

        // ---------------------------------------------------------
        // 8. Latihan: Tabel Luas Persegi GeoGebra
        // ---------------------------------------------------------
        window.setupReviewMode(
            'm1_cp8_tabel_luas_geogebra',
            'button[onclick="cekTabelGeoGebra()"]',
            function showAnswer() {
                const kunci = {
                    sisi_a: 3, sisi_b: 4, sisi_c: 5,
                    luas_a_1: 3, luas_a_2: 3, luas_a_sq: 3, luas_a_hasil: 9,
                    luas_b_1: 4, luas_b_2: 4, luas_b_sq: 4, luas_b_hasil: 16,
                    luas_c_1: 5, luas_c_2: 5, luas_c_sq: 5, luas_c_hasil: 25
                };
                for (let id in kunci) {
                    let el = document.getElementById(id);
                    if (el) {
                        el.value = kunci[id];
                        el.classList.add('is-valid');
                        el.disabled = true;
                    }
                }
                const feedbackBox = document.getElementById('feedbackTabelGeoGebra');
                if (feedbackBox) {
                    feedbackBox.className = "mt-2 fw-bold text-success animate__animated animate__fadeInUp";
                    feedbackBox.innerHTML = "Perhitungan luas persegimu sangat tepat.";
                }
            },
            function resetExercise() {
                const kunci = ['sisi_a', 'sisi_b', 'sisi_c', 'luas_a_1', 'luas_a_2', 'luas_a_sq', 'luas_a_hasil', 'luas_b_1', 'luas_b_2', 'luas_b_sq', 'luas_b_hasil', 'luas_c_1', 'luas_c_2', 'luas_c_sq', 'luas_c_hasil'];
                kunci.forEach(id => {
                    let el = document.getElementById(id);
                    if (el) {
                        el.value = '';
                        el.classList.remove('is-valid', 'is-invalid');
                        el.disabled = false;
                    }
                });
                const feedbackBox = document.getElementById('feedbackTabelGeoGebra');
                if (feedbackBox) feedbackBox.innerHTML = '';
            }
        );

        // ---------------------------------------------------------
        // 9. Latihan: Soal 1 (Persegi Terbesar)
        // ---------------------------------------------------------
        const fbBenar1 = document.getElementById('feedbackBenar1');
        // Buat tombol hantu tepat di bawah kotak hijau feedback
        if (fbBenar1 && !document.getElementById('dummy-btn-s1')) {
            const dummy1 = document.createElement('button');
            dummy1.id = 'dummy-btn-s1';
            dummy1.style.display = 'none'; // Sembunyikan
            fbBenar1.insertAdjacentElement('afterend', dummy1);
        }

        window.setupReviewMode(
            'm1_cp9_kesimpulan_luas', // Berbagi progres dengan Soal 2
            '#dummy-btn-s1',
            function showAnswer() {
                const btnSoal1 = document.querySelector('.btn-soal1');
                if (btnSoal1) {
                    const row1 = btnSoal1.closest('.row');
                    // Matikan semua tombol
                    row1.querySelectorAll('.btn-soal1').forEach(btn => {
                        btn.disabled = true;
                        btn.classList.remove('btn-success', 'text-white');
                        btn.classList.add('btn-outline-success');
                    });
                    // Cari tombol yang mengandung kata "benar" di onclick (Bebas error VS Code!)
                    const btnBenar1 = row1.querySelector('button[onclick*="benar"]');
                    if (btnBenar1) {
                        btnBenar1.classList.remove('btn-outline-success');
                        btnBenar1.classList.add('btn-success', 'text-white');
                    }
                }
                if (fbBenar1) fbBenar1.classList.remove('d-none');
            },
            function resetExercise() {
                const btnSoal1 = document.querySelector('.btn-soal1');
                if (btnSoal1) {
                    const row1 = btnSoal1.closest('.row');
                    row1.querySelectorAll('.btn-soal1').forEach(btn => {
                        btn.disabled = false;
                        btn.classList.remove('btn-success', 'btn-danger', 'text-white');
                        btn.classList.add('btn-outline-success');
                    });
                }
                const fbSalah1 = document.getElementById('feedbackSalah1');
                if (fbBenar1) fbBenar1.classList.add('d-none');
                if (fbSalah1) fbSalah1.classList.add('d-none');
            }
        );

        // ---------------------------------------------------------
        // 10. Latihan: Kesimpulan Luas Pythagoras (Soal 2)
        // ---------------------------------------------------------
        const boxPenjelasan = document.getElementById('boxPenjelasanAkhir');
        const fbBenar2 = document.getElementById('feedbackBenar');

        if (boxPenjelasan && !document.getElementById('dummy-btn-s2')) {
            const dummy2 = document.createElement('button');
            dummy2.id = 'dummy-btn-s2';
            dummy2.style.display = 'none';
            boxPenjelasan.insertAdjacentElement('afterend', dummy2);
        }

        window.setupReviewMode(
            'm1_cp9_kesimpulan_luas',
            '#dummy-btn-s2',
            function showAnswer() {
                const btnPilihan = document.querySelector('.btn-pilihan');
                if (btnPilihan) {
                    const row2 = btnPilihan.closest('.row');
                    row2.querySelectorAll('.btn-pilihan').forEach(btn => {
                        btn.disabled = true;
                        btn.classList.remove('btn-success', 'text-white');
                        btn.classList.add('btn-outline-success');
                    });
                    // Cari tombol yang mengandung kata "benar" di onclick
                    const btnBenar2 = row2.querySelector('button[onclick*="benar"]');
                    if (btnBenar2) {
                        btnBenar2.classList.remove('btn-outline-success');
                        btnBenar2.classList.add('btn-success', 'text-white');
                    }
                }
                if (fbBenar2) fbBenar2.classList.remove('d-none');
                if (boxPenjelasan) boxPenjelasan.classList.remove('d-none');
            },
            function resetExercise() {
                const btnPilihan = document.querySelector('.btn-pilihan');
                if (btnPilihan) {
                    const row2 = btnPilihan.closest('.row');
                    row2.querySelectorAll('.btn-pilihan').forEach(btn => {
                        btn.disabled = false;
                        btn.classList.remove('btn-success', 'btn-danger', 'text-white');
                        btn.classList.add('btn-outline-success');
                    });
                }
                const fbSalah2 = document.getElementById('feedbackSalah');
                if (fbBenar2) fbBenar2.classList.add('d-none');
                if (fbSalah2) fbSalah2.classList.add('d-none');
                if (boxPenjelasan) boxPenjelasan.classList.add('d-none');
            }
        );

        // ---------------------------------------------------------
        // 11. Latihan: Contoh Soal 1 (Tangga)
        // ---------------------------------------------------------
        window.setupReviewMode(
            'm1_cp10_contoh_soal_1',
            'button[onclick="cekContoh1()"]',
            function showAnswer() {
                const ans1 = {
                    'c1_dik_a': 3, 'c1_dik_b': 4,
                    'c1_step1_a': 3, 'c1_step1_b': 4,
                    'c1_step2_a_sq': 9, 'c1_step2_b_sq': 16,
                    'c1_step3_sum': 25, 'c1_step4_root': 25,
                    'c1_final': 5
                };
                for (let id in ans1) {
                    let el = document.getElementById(id);
                    if (el) {
                        el.value = ans1[id];
                        el.classList.add('is-valid');
                        el.disabled = true;
                    }
                }
                const feedback = document.getElementById('c1_feedback');
                if (feedback) {
                    feedback.className = "small fw-bold text-success animate__animated animate__fadeIn";
                    feedback.innerHTML = "Luar Biasa! Jawaban kamu benar.";
                }
            },
            function resetExercise() {
                const ids1 = ['c1_dik_a', 'c1_dik_b', 'c1_step1_a', 'c1_step1_b', 'c1_step2_a_sq', 'c1_step2_b_sq', 'c1_step3_sum', 'c1_step4_root', 'c1_final'];
                ids1.forEach(id => {
                    let el = document.getElementById(id);
                    if (el) {
                        el.value = '';
                        el.classList.remove('is-valid', 'is-invalid');
                        el.disabled = false;
                    }
                });
                const feedback = document.getElementById('c1_feedback');
                if (feedback) feedback.innerHTML = '';
            }
        );

        // ---------------------------------------------------------
        // 12. Latihan: Contoh Soal 2 (Segitiga Gabungan)
        // ---------------------------------------------------------
        window.setupReviewMode(
            'm1_cp11_contoh_soal_2',
            'button[onclick="cekContoh2()"]',
            function showAnswer() {
                const ans2 = {
                    'c2_dik_ab': 13, 'c2_dik_ac': 12, 'c2_dik_cd': 3,
                    'c2_step1_ab': 13, 'c2_step1_ac': 12,
                    'c2_step1_res1': 169, 'c2_step1_res2': 144, 'c2_step1_sqrt': 25,
                    'c2_bc_result': 5,
                    'c2_step2_bc': 5, 'c2_step2_cd': 3,
                    'c2_step2_res1': 25, 'c2_step2_res2': 9, 'c2_step2_sqrt': 16,
                    'c2_final': 4
                };
                for (let id in ans2) {
                    let el = document.getElementById(id);
                    if (el) {
                        el.value = ans2[id];
                        el.classList.add('is-valid');
                        el.disabled = true;
                    }
                }
                const feedback = document.getElementById('c2_feedback');
                if (feedback) {
                    feedback.className = "small fw-bold text-success animate__animated animate__fadeIn";
                    feedback.innerHTML = "Kerja Bagus! Kamu berhasil menyelesaikannya.";
                }
            },
            function resetExercise() {
                const ids2 = ['c2_dik_ab', 'c2_dik_ac', 'c2_dik_cd', 'c2_step1_ab', 'c2_step1_ac', 'c2_step1_res1', 'c2_step1_res2', 'c2_step1_sqrt', 'c2_bc_result', 'c2_step2_bc', 'c2_step2_cd', 'c2_step2_res1', 'c2_step2_res2', 'c2_step2_sqrt', 'c2_final'];
                ids2.forEach(id => {
                    let el = document.getElementById(id);
                    if (el) {
                        el.value = '';
                        el.classList.remove('is-valid', 'is-invalid');
                        el.disabled = false;
                    }
                });
                const feedback = document.getElementById('c2_feedback');
                if (feedback) feedback.innerHTML = '';
            }
        );

        // ---------------------------------------------------------
        // 13. Latihan Analisis: Soal 1 (Pilih Rumus)
        // ---------------------------------------------------------
        window.setupReviewMode(
            'm1_cp12_latihan_1',
            'button[onclick="cekLatihanAnalisis1()"]',
            function showAnswer() {
                const tanya = document.getElementById('s1_tanya');
                const diket1 = document.getElementById('s1_diketahui_1');
                const diket2 = document.getElementById('s1_diketahui_2');

                if (tanya) { tanya.value = 'miring'; tanya.disabled = true; tanya.classList.add('is-valid', 'border-success'); }
                if (diket1) { diket1.value = 'AB'; diket1.disabled = true; diket1.classList.add('is-valid', 'border-success'); }
                if (diket2) { diket2.value = 'BC'; diket2.disabled = true; diket2.classList.add('is-valid', 'border-success'); }

                const btnGroups = document.getElementById('s1_tanya').closest('.card-body').querySelectorAll('.row.g-2, .row.g-3');
                if (btnGroups[0]) {
                    btnGroups[0].querySelectorAll('button').forEach(b => { b.disabled = true; b.classList.replace('btn-dark', 'btn-outline-dark'); });
                    const correct1 = btnGroups[0].querySelector('[onclick*="benar"]');
                    if (correct1) { correct1.classList.replace('btn-outline-dark', 'btn-success'); correct1.classList.add('text-white'); }
                }
                if (btnGroups[1]) {
                    btnGroups[1].querySelectorAll('button').forEach(b => { b.disabled = true; b.classList.replace('btn-dark', 'btn-outline-dark'); });
                    const correct2 = btnGroups[1].querySelector('[onclick*="benar"]');
                    if (correct2) { correct2.classList.replace('btn-outline-dark', 'btn-success'); correct2.classList.add('text-white'); }
                }

                const fb = document.getElementById('s1_feedback');
                if (fb) fb.innerText = "Tepat sekali!";
            },
            function resetExercise() {
                const tanya = document.getElementById('s1_tanya');
                const diket1 = document.getElementById('s1_diketahui_1');
                const diket2 = document.getElementById('s1_diketahui_2');

                [tanya, diket1, diket2].forEach(el => {
                    if (el) { el.value = ''; el.disabled = false; el.classList.remove('is-valid', 'border-success'); }
                });

                const btnGroups = document.getElementById('s1_tanya').closest('.card-body').querySelectorAll('.row.g-2, .row.g-3');
                btnGroups.forEach(group => {
                    group.querySelectorAll('button').forEach(b => {
                        b.disabled = false;
                        b.classList.remove('btn-success', 'btn-dark', 'text-white');
                        b.classList.add('btn-outline-dark');
                        b.dataset.status = 'salah';
                    });
                });

                const fb = document.getElementById('s1_feedback');
                if (fb) fb.innerText = "";
            }
        );

        // ---------------------------------------------------------
        // 14. Latihan Analisis: Soal 2 (Drag & Drop + Perhitungan 1)
        // ---------------------------------------------------------
        window.setupReviewMode(
            'm1_cp13_latihan_2',
            'button[onclick="cekLatihanAnalisis2()"]',
            function showAnswer() {
                const checkAndFix = (elId, correctVal) => {
                    const el = document.getElementById(elId);
                    if (el) {
                        el.classList.remove('is-invalid', 'border-danger', 'text-danger');
                        el.classList.add('is-valid', 'border-success', 'text-success');
                        el.value = correctVal;
                        el.disabled = true;
                    }
                };
                ['s2_inp_mo_1', 's2_inp_mo_2', 's2_inp_mo_3', 's2_inp_mo_4'].forEach(id => checkAndFix(id, 'MO'));
                checkAndFix('s2_inp_mn', 15); checkAndFix('s2_inp_no', 8); checkAndFix('s2_res_mn_sq', 225);
                checkAndFix('s2_res_no_sq', 64); checkAndFix('s2_res_sum', 289); checkAndFix('s2_res_sqrt', 289); checkAndFix('s2_final', 17);

                const fillDrop = (target, correctVal) => {
                    const zone = document.querySelector(`[data-target="${target}"]`);
                    if (zone) {
                        const dragSrc = document.getElementById('drag-items-container');
                        const correctItem = dragSrc.querySelector(`.draggable-item[data-value="${correctVal}"]`) || document.querySelector(`.draggable-item[data-value="${correctVal}"]`);
                        if (correctItem) {
                            zone.innerHTML = '';
                            correctItem.style.margin = "0";
                            correctItem.classList.replace('p-2', 'p-1');
                            zone.appendChild(correctItem);
                            zone.classList.add('border-success', 'is-valid');
                        }
                    }
                };
                fillDrop('s2_diketahui_mn', '15cm'); fillDrop('s2_diketahui_no', '8cm'); fillDrop('s2_ditanya', 'tanya');
                fillDrop('s2_rumus_miring', 'MO'); fillDrop('s2_rumus_tegak1', 'MN'); fillDrop('s2_rumus_tegak2', 'NO');

                const fb = document.getElementById('s2_feedback');
                if (fb) fb.innerText = "Perhitungan Sempurna!";
            },
            function resetExercise() {
                const inputsText = document.querySelectorAll('#s2_inp_mo_1, #s2_inp_mo_2, #s2_inp_mo_3, #s2_inp_mo_4, #s2_inp_mn, #s2_inp_no, #s2_res_mn_sq, #s2_res_no_sq, #s2_res_sum, #s2_res_sqrt, #s2_final');
                inputsText.forEach(el => {
                    el.value = '';
                    el.disabled = false;
                    el.classList.remove('is-valid', 'border-success', 'text-success', 'is-invalid', 'border-danger', 'text-danger');
                });

                const dragSrc = document.getElementById('drag-items-container');
                document.querySelectorAll('[data-target^="s2_"]').forEach(zone => {
                    const item = zone.querySelector('.draggable-item');
                    if (item) {
                        item.classList.replace('p-1', 'p-2');
                        dragSrc.appendChild(item);
                    }
                    zone.classList.remove('border-success', 'is-valid', 'border-danger');
                    zone.style.borderStyle = 'dashed';
                });

                const fb = document.getElementById('s2_feedback');
                if (fb) fb.innerText = "";
            }
        );

        // ---------------------------------------------------------
        // 15. Latihan Analisis: Soal 3 (Drag & Drop + Perhitungan Bertingkat)
        // ---------------------------------------------------------
        window.setupReviewMode(
            'm1_cp14_latihan_3',
            'button[onclick="cekLatihanAnalisis3()"]',
            function showAnswer() {
                const checkAndFix = (elId, correctVal) => {
                    const el = document.getElementById(elId);
                    if (el) {
                        el.classList.remove('is-invalid', 'border-danger', 'text-danger');
                        el.classList.add('is-valid', 'border-success', 'text-success');
                        el.value = correctVal;
                        el.disabled = true;
                    }
                };
                const ans = {
                    s3_ac_sq1: 24, s3_ac_sq2: 7, s3_ac_sum1: 576, s3_ac_sum2: 49, s3_ac_total: 625, s3_ac_sqrt_val: 625, s3_ac_final: 25,
                    s3_ab_sq1: 16, s3_ab_sq2: 12, s3_ab_sum1: 256, s3_ab_sum2: 144, s3_ab_total: 400, s3_ab_sqrt_val: 400, s3_ab_final: 20,
                    s3_bc_sq1: 25, s3_bc_sq2: 20, s3_bc_diff1: 625, s3_bc_diff2: 400, s3_bc_total: 225, s3_bc_sqrt_val: 225, s3_bc_final: 15
                };
                for (let id in ans) checkAndFix(id, ans[id]);

                const fillDrop = (target, correctVal) => {
                    const zone = document.querySelector(`[data-target="${target}"]`);
                    if (zone) {
                        const dragSrc = document.getElementById('drag-items-container-s3');
                        const correctItem = dragSrc.querySelector(`.draggable-item[data-value="${correctVal}"]`) || document.querySelector(`.draggable-item[data-value="${correctVal}"]`);
                        if (correctItem) {
                            zone.innerHTML = '';
                            correctItem.style.margin = "0";
                            correctItem.classList.replace('p-2', 'p-1');
                            zone.appendChild(correctItem);
                            zone.classList.add('border-success', 'is-valid');
                        }
                    }
                };
                fillDrop('s3_diket_ae', '24'); fillDrop('s3_diket_ce', '7'); fillDrop('s3_diket_ad', '16'); fillDrop('s3_diket_bd', '12'); fillDrop('s3_ditanya', 'BC');
                fillDrop('s3_ac_drop1', 'AE'); fillDrop('s3_ac_drop2', 'CE'); fillDrop('s3_ab_drop1', 'AD'); fillDrop('s3_ab_drop2', 'BD'); fillDrop('s3_bc_drop1', 'AC'); fillDrop('s3_bc_drop2', 'AB');

                const fb = document.getElementById('s3_feedback');
                if (fb) fb.innerText = "Sempurna!";
            },
            function resetExercise() {
                // Beruntungnya kamu sudah bikin fungsi global resetSoal3(), tinggal panggil!
                if (typeof resetSoal3 === 'function') resetSoal3();
            }
        );

        window.setupReviewMode(
            'm1_cp15_refleksi_akhir',
            '#btnSimpanRefleksi',
            function showAnswer() {
                const form = document.getElementById('formRefleksi');
                if (form) {
                    form.querySelectorAll('input, textarea').forEach(el => {
                        el.disabled = true;
                    });
                }

                const btnSubmit = document.getElementById('btnSimpanRefleksi');
                if (btnSubmit) {
                    btnSubmit.innerHTML = 'Tersimpan <i class="fas fa-check ms-1"></i>';
                    btnSubmit.classList.replace('btn-success', 'btn-secondary');
                    btnSubmit.disabled = true;
                }

                const feedbackArea = document.getElementById('refleksi_feedback');
                if (feedbackArea) {
                    feedbackArea.innerHTML = `<div class="alert alert-success py-2 small fw-bold mb-0"><i class="fas fa-info-circle me-1"></i> Refleksi ini sudah kamu kerjakan.</div>`;
                }
            },
            null // <-- KUNCI: Set menjadi null
        );
    }
});
