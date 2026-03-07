console.log("Pagination Loaded");
/* =====================================================
   NAVIGASI HALAMAN (VERSI PERBAIKAN)
===================================================== */
document.addEventListener('DOMContentLoaded', function () {
    const pages = document.querySelectorAll('.materi-page');
    
    // PERUBAHAN: Gunakan querySelectorAll dan class (.prev-btn / .next-btn)
    const prevBtns = document.querySelectorAll('.prev-btn');
    const nextBtns = document.querySelectorAll('.next-btn');
    const pageBtns = document.querySelectorAll('.page-btn');
    const savedPage = localStorage.getItem('materiPage');

    let currentPage = 0;
    const totalPages = pages.length;

    function showPage(index) {
        if (index < 0 || index >= totalPages) return;

        // 1. Sembunyikan semua halaman, lalu tampilkan yang aktif
        pages.forEach(p => p.classList.add('d-none'));
        pages[index].classList.remove('d-none');

        currentPage = index;
        localStorage.setItem('materiPage', index);

        // 2. Update tombol angka (Sinkron atas & bawah)
        pageBtns.forEach(btn => {
            btn.parentElement.classList.remove('active');
            if (parseInt(btn.dataset.page) === index) {
                btn.parentElement.classList.add('active');
            }
        });

        // 3. Update status Disable pada tombol Prev & Next
        prevBtns.forEach(btn => {
            btn.disabled = (index === 0);
            btn.parentElement.classList.toggle('disabled', index === 0);
        });

        nextBtns.forEach(btn => {
            btn.disabled = (index === totalPages - 1);
            btn.parentElement.classList.toggle('disabled', index === totalPages - 1);
        });

        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        // 4. Inisialisasi kode spesifik halaman (Fitur Interaktif)
        initPageSpecificCode(index);
    }

    function initPageSpecificCode(pageIndex) {
        console.log("Membuka halaman index:", pageIndex);

        switch(pageIndex) {
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
            case 4: // Halaman "Ayo Berlatih" (Index ke-4 / Page 5)
                if (typeof initDragDropSoal3 === 'function') initDragDropSoal3();
                break;
        }
    }

    // Event Listeners (Terapkan ke semua tombol atas & bawah)
    pageBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            showPage(parseInt(btn.dataset.page));
        });
    });

    prevBtns.forEach(btn => {
        btn.addEventListener('click', () => showPage(currentPage - 1));
    });

    nextBtns.forEach(btn => {
        btn.addEventListener('click', () => showPage(currentPage + 1));
    });

    // Jalankan pertama kali
    showPage(savedPage ? parseInt(savedPage) : 0);
});

/* ===============================
   SIDEBAR
================================ */
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('mainSidebar'); // Sekarang ID ini sudah ada di HTML
    const overlay = document.getElementById('sidebarOverlay'); // Ini juga sudah ada
    const body = document.body;

    function handleSidebarToggle(e) {
        if(e) e.stopPropagation();

        if (window.innerWidth >= 992) {
            // Desktop: Geser Layout
            body.classList.toggle('sidebar-closed');
        } else {
            // Mobile: Slide In/Out
            if(sidebar) sidebar.classList.toggle('active');
            if(overlay) overlay.classList.toggle('active');
        }
    }

    if(toggleBtn) toggleBtn.addEventListener('click', handleSidebarToggle);
    
    if(overlay) {
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    }
});
/* ==========================================
   LOGIKA DRAG & DROP: PINDAH FISIK (MOVE)
   ========================================== */
function initDragAndDropPage1() {
    
    // --- 1. VARIABEL & SELEKTOR ---
    let attemptCount = 0;
    const maxAttempts = 3;
    let isGameLocked = false;

    const dragSource = document.getElementById('drag-source');
    const checkBtn = document.getElementById('check-matching');
    const resetBtn = document.getElementById('reset-matching');
    
    // Kita ambil dragItems dan dropZones
    const dragItems = document.querySelectorAll('.drag-item');
    const dropZones = document.querySelectorAll('.drop-zone');

    // --- 2. SETUP DRAG ITEMS ---
    dragItems.forEach(item => {
        item.setAttribute('draggable', 'true');
        item.style.cursor = 'grab';

        // Event saat mulai ditarik
        item.addEventListener('dragstart', (e) => {
            if (isGameLocked) {
                e.preventDefault();
                return;
            }
            // Simpan ID elemen yang sedang ditarik
            e.dataTransfer.setData('text/plain', e.target.id);
            e.dataTransfer.effectAllowed = 'move';
            
            // Efek visual sedikit transparan saat melayang
            setTimeout(() => {
                e.target.classList.add('hide-while-dragging');
            }, 0);
        });

        // Event saat selesai ditarik (baik sukses drop maupun batal)
        item.addEventListener('dragend', (e) => {
            e.target.classList.remove('hide-while-dragging');
            e.target.style.cursor = 'grab';
        });
    });

    // --- 3. SETUP DROP ZONES ---
    dropZones.forEach(zone => {
        
        // a. Drag Over (Izinkan drop)
        zone.addEventListener('dragover', (e) => {
            e.preventDefault(); 
            if (!isGameLocked) {
                zone.classList.add('bg-light-success'); 
                zone.style.borderStyle = 'solid';
            }
        });

        // b. Drag Leave (Batal drop)
        zone.addEventListener('dragleave', (e) => {
            if (!isGameLocked) {
                zone.classList.remove('bg-light-success');
                if(!zone.classList.contains('correct-answer')) {
                     zone.style.borderStyle = 'dashed';
                }
            }
        });

        // c. DROP (INTI PERBAIKAN: PINDAH FISIK)
        zone.addEventListener('drop', (e) => {
            e.preventDefault();
            zone.classList.remove('bg-light-success');
            
            if (isGameLocked) return;

            const id = e.dataTransfer.getData('text/plain');
            const draggedElement = document.getElementById(id);

            if (draggedElement) {
                // 1. CEK: Apakah zona ini sudah ada isinya?
                // Jika ya, kita harus "TENDANG" isi lama kembali ke SUMBER (Atas)
                if (zone.children.length > 0) {
                    // Cari elemen .drag-item yang sudah ada di situ
                    const existingItem = zone.querySelector('.drag-item');
                    if (existingItem) {
                        // Pindahkan item lama ke wadah asal (dragSource)
                        dragSource.appendChild(existingItem);
                    }
                }
                
                // 2. PINDAH: Masukkan item baru ke zona ini
                // appendChild otomatis menghapus elemen dari tempat lama (sumber) 
                // dan menaruhnya di tempat baru. Jadi otomatis "hilang dari atas".
                zone.appendChild(draggedElement);
                
                // Styling agar rapi
                zone.style.borderStyle = 'solid';
                zone.style.backgroundColor = '#f8f9fa';
                
                // Hapus pesan feedback lama jika ada
                const feedbackDiv = zone.parentNode.querySelector('.feedback-msg');
                if(feedbackDiv) feedbackDiv.innerHTML = '';
            }
        });

        // d. KLIK ZONA UNTUK BATAL (Kembalikan ke atas)
        zone.addEventListener('click', (e) => {
            // Pastikan yang diklik adalah area zona, bukan tombol cek
            if (!isGameLocked && zone.children.length > 0) {
                const item = zone.querySelector('.drag-item');
                if (item) {
                    // Pindahkan item kembali ke sumber (Atas)
                    dragSource.appendChild(item); 
                    
                    // Reset styling zona
                    zone.style.borderStyle = 'dashed';
                    zone.style.borderColor = '#198754';
                    zone.style.backgroundColor = '#f8f9fa';
                    zone.classList.remove('correct-answer');
                    
                    const feedbackDiv = zone.parentNode.querySelector('.feedback-msg');
                    if(feedbackDiv) feedbackDiv.innerHTML = '';
                }
            }
        });
    });

    // --- 5. LOGIKA RESET / ULANGI (PENYEMPURNAAN FINAL) ---
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            
            // A. Ambil semua item drag yang ada (baik di atas maupun di drop zone)
            // Kita gunakan Array.from agar bisa disortir (opsional)
            const allItems = Array.from(document.querySelectorAll('.drag-item'));
            
            // B. KOSONGKAN WADAH SUMBER (Solusi agar tidak bergeser)
            // Ini akan menghapus spasi kosong atau elemen hantu yang bikin layout rusak
            dragSource.innerHTML = ''; 

            // C. Masukkan kembali item ke wadah sumber
            // Kita pakai Set untuk mencegah duplikat (jika ada bug sebelumnya)
            const processedValues = new Set();
            
            allItems.forEach(item => {
                const val = item.getAttribute('data-value');
                
                // Cek duplikat: Jika value ini belum diproses, masukkan.
                // (Hapus logika 'if' ini jika Anda memang ingin membolehkan item kembar)
                // Tapi untuk layout ini, sepertinya Anda punya 4 item unik/spesifik.
                
                // Reset kondisi item
                item.style.opacity = '1';
                item.classList.remove('hide-while-dragging');
                
                // Masukkan kembali ke dragSource
                dragSource.appendChild(item);
            });

            // D. Bersihkan Zona Drop (Visual)
            dropZones.forEach(zone => {
                // Karena itemnya sudah dipindah di langkah C, zona otomatis kosong.
                // Kita tinggal reset stylenya saja.
                zone.style.borderStyle = 'dashed';
                zone.style.borderColor = '#198754';
                zone.style.backgroundColor = '#f8f9fa';
                zone.classList.remove('correct-answer');
                zone.classList.remove('bg-light-success');
                
                // Hapus pesan feedback
                const feedbackDiv = zone.parentNode.querySelector('.feedback-msg');
                if(feedbackDiv) feedbackDiv.innerHTML = '';
            });

            // E. Reset status game
            isGameLocked = false;
            attemptCount = 0;
            checkBtn.disabled = false;
        });
    }

    // --- 5. TOMBOL CEK (Sama seperti sebelumnya) ---
    if (checkBtn) {
        checkBtn.addEventListener('click', () => {
            if (isGameLocked) return;

            let correctCount = 0;
            let filledCount = 0;
            const totalQuestions = dropZones.length;

            dropZones.forEach(zone => {
                const item = zone.querySelector('.drag-item');
                if (item) {
                    filledCount++;
                    if (item.getAttribute('data-value') === zone.getAttribute('data-correct')) {
                        correctCount++;
                        zone.style.borderColor = '#198754';
                        zone.style.backgroundColor = '#d1e7dd';
                        zone.classList.add('correct-answer');
                        zone.parentNode.querySelector('.feedback-msg').innerHTML = '<span class="text-success small fw-bold"><i class="bi bi-check-circle"></i> Benar!</span>';
                    } else {
                        zone.style.borderColor = '#dc3545';
                        zone.style.backgroundColor = '#f8d7da';
                        zone.parentNode.querySelector('.feedback-msg').innerHTML = '<span class="text-danger small fw-bold"><i class="bi bi-x-circle"></i> Kurang Tepat</span>';
                    }
                } else {
                    zone.parentNode.querySelector('.feedback-msg').innerHTML = '<span class="text-warning small fw-bold">Belum diisi</span>';
                }
            });

            if (filledCount < totalQuestions) {
                Swal.fire({ icon: 'warning', title: 'Belum Lengkap', text: 'Silakan isi semua kotak jawaban!', confirmButtonColor: '#ffc107'});
                return;
            }

            attemptCount++;
            if (correctCount === totalQuestions) {
                isGameLocked = true;
                checkBtn.disabled = true;
                Swal.fire({ icon: 'success', title: 'Luar Biasa!', text: 'Jawaban kamu benar!', confirmButtonColor: '#198754'});
                const penguatan = document.getElementById('penguatan-materi');
                if(penguatan) {
                    penguatan.classList.remove('d-none');
                    // Opsional: Scroll agar siswa langsung melihat teks penguatan
                    setTimeout(() => penguatan.scrollIntoView({ behavior: 'smooth', block: 'center' }), 500);
                }
            } else if (attemptCount >= maxAttempts) {
                // Tampilkan Jawaban (Auto Solve)
                isGameLocked = true;
                checkBtn.disabled = true;
                dropZones.forEach(zone => {
                    const itemInZone = zone.querySelector('.drag-item');
                    if(itemInZone) dragSource.appendChild(itemInZone); // Kosongkan dulu
                });
                dropZones.forEach(zone => {
                    const correctVal = zone.getAttribute('data-correct');
                    const correctItem = dragSource.querySelector(`.drag-item[data-value="${correctVal}"]`);
                    if(correctItem) {
                        zone.appendChild(correctItem);
                        zone.style.borderColor = '#198754';
                        zone.style.backgroundColor = '#d1e7dd';
                        zone.classList.add('correct-answer');
                    }
                });
                Swal.fire({ icon: 'info', title: 'Kesempatan Habis', text: 'Jawaban benar telah ditampilkan.', confirmButtonColor: '#0d6efd'});
                const penguatan = document.getElementById('penguatan-materi');
                if(penguatan) penguatan.classList.remove('d-none');
            } else {
                Swal.fire({ icon: 'error', title: 'Masih Salah', text: `Sisa kesempatan: ${maxAttempts - attemptCount}`, confirmButtonColor: '#dc3545'});
            }
        });
    }
}

// Panggil fungsi ini saat halaman dimuat
document.addEventListener('DOMContentLoaded', initDragAndDropPage1);

/* ==========================================
   HALAMAN 1: BILANGAN KUADRAT (UPDATED)
========================================== */
function initPageKuadrat() {
    console.log("Fungsi initPageKuadrat dijalankan!"); 

    const container = document.getElementById('kuadrat-container');
    // Selektor untuk bagian materi penguatan yang tersembunyi
    const penguatanMateri = document.getElementById('penguatan-materi'); 

    if (!container) {
        console.error("Elemen #kuadrat-container tidak ditemukan!");
        return; 
    }

    let attemptCount = 0;
    const maxAttempts = 3;
    const checkBtn = container.querySelector('#btnCekKuadrat');
    const allInputs = container.querySelectorAll('.input-kuadrat');

    if (!checkBtn) {
        console.error("Tombol #btnCekKuadrat tidak ditemukan!");
        return;
    }

    // --- 1. FUNGSI RESET (TOMBOL ULANGI) ---
    function resetKuadrat() {
        attemptCount = 0;
        checkBtn.disabled = false;
        checkBtn.innerHTML = "Periksa Jawaban"; 

        allInputs.forEach(input => {
            input.value = '';
            input.classList.remove('is-valid', 'is-invalid');
            input.disabled = false;
        });

        // Sembunyikan kembali materi penguatan saat reset agar fokus mengerjakan ulang
        if (penguatanMateri) {
            penguatanMateri.classList.add('d-none');
        }
    }

    // --- 2. FUNGSI TAMPILKAN JAWABAN (SAAT MENYERAH) ---
    function showAnswersKuadrat() {
        allInputs.forEach(input => {
            input.value = input.getAttribute('data-answer');
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            input.disabled = true;
        });
        checkBtn.disabled = true;
        checkBtn.innerHTML = "Selesai";

        // Tampilkan materi penguatan agar siswa tetap bisa membaca kesimpulan
        if (penguatanMateri) {
            penguatanMateri.classList.remove('d-none');
            setTimeout(() => {
                penguatanMateri.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 300);
        }
    }

    // --- 3. LOGIKA TOMBOL PERIKSA ---
    checkBtn.onclick = function() {
        let allCorrect = true;
        let emptyCount = 0;

        // Cek Kolom Kosong
        allInputs.forEach(input => {
            if(input.value.trim() === '') emptyCount++;
        });

        if(emptyCount > 0) {
             Swal.fire({
                icon: 'warning',
                title: 'Belum Lengkap',
                text: 'Silakan lengkapi semua kotak kosong bertanda (?) terlebih dahulu.',
                confirmButtonColor: '#ffc107'
            });
            return;
        }

        // Validasi Jawaban
        allInputs.forEach(input => {
            const userAnswer = parseFloat(input.value);
            const correctAnswer = parseFloat(input.getAttribute('data-answer'));

            if (userAnswer === correctAnswer) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            } else {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                allCorrect = false;
            }
        });

        attemptCount++;

        // --- KONDISI JIKA BENAR SEMUA ---
        if (allCorrect) {
            Swal.fire({
                icon: 'success',
                title: 'Benar Semua!',
                text: `Hebat! Kamu berhasil melengkapi pola bilangan kuadrat.`,
                confirmButtonText: 'Lihat Pembahasan',
                confirmButtonColor: '#198754'
            }).then(() => {
                checkBtn.disabled = true;
                checkBtn.innerHTML = "Selesai";
                allInputs.forEach(el => el.disabled = true);

                // MUNCULKAN MATERI PENGUATAN (Sesuai instruksi: Penguatan di akhir)
                if (penguatanMateri) {
                    penguatanMateri.classList.remove('d-none');
                    // Scroll otomatis ke bagian penguatan
                    setTimeout(() => {
                        penguatanMateri.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 500);
                }
            });
        } 
        // --- KONDISI JIKA MASIH SALAH ---
        else {
            if (attemptCount >= maxAttempts) {
                Swal.fire({
                    icon: 'error',
                    title: 'Kesempatan Habis',
                    html: `Kamu sudah mencoba ${maxAttempts} kali.<br>Ingin melihat jawaban dan kesimpulannya?`,
                    showCancelButton: true,
                    confirmButtonText: 'Lihat Jawaban',
                    confirmButtonColor: '#0d6efd',
                    cancelButtonText: 'Ulangi',
                    cancelButtonColor: '#dc3545',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        showAnswersKuadrat();
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        resetKuadrat();
                    }
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Masih Ada yang Keliru',
                    text: `Cek kembali isianmu. Sisa kesempatan: ${maxAttempts - attemptCount} kali.`,
                    confirmButtonText: 'Coba Lagi',
                    confirmButtonColor: '#ffc107'
                });
            }
        }
    };
}

/* ==========================================
   HALAMAN AYO MENCOBA (AKAR KUADRAT)
========================================== */
function initPageAkar() {
    const container = document.getElementById('akar-container');
    if (!container) return; // Stop jika elemen tidak ada

    let attemptCount = 0;
    const maxAttempts = 3;
    const checkBtn = container.querySelector('#btnCekAkar');

    // 1. FUNGSI RESET (TOMBOL ULANG)
    function resetAkar() {
        attemptCount = 0;
        checkBtn.disabled = false;

        // Reset Isian
        container.querySelectorAll('.input-akar').forEach(input => {
            input.value = '';
            input.classList.remove('is-valid', 'is-invalid');
            input.disabled = false;
        });

        // Reset Select (True/False)
        container.querySelectorAll('.select-akar').forEach(sel => {
            sel.value = '';
            sel.classList.remove('is-valid', 'is-invalid');
            sel.disabled = false;
        });
    }

    // 2. FUNGSI SHOW ANSWER (TOMBOL LANJUTKAN)
    function showAnswersAkar() {
        // Isian
        container.querySelectorAll('.input-akar').forEach(input => {
            input.value = input.getAttribute('data-answer');
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            input.disabled = true;
        });

        // Select
        container.querySelectorAll('.select-akar').forEach(sel => {
            sel.value = sel.getAttribute('data-answer');
            sel.classList.remove('is-invalid');
            sel.classList.add('is-valid');
            sel.disabled = true;
        });

        checkBtn.disabled = true;
    }

    // 3. LOGIKA PERIKSA
    checkBtn.addEventListener('click', function() {
        let allCorrect = true;
        let totalSoal = 0;
        let correctCount = 0;

        // A. Validasi Isian
        container.querySelectorAll('.input-akar').forEach(input => {
            totalSoal++;
            const userAnswer = input.value.trim();
            const correctAnswer = input.getAttribute('data-answer');

            if (userAnswer == correctAnswer) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                correctCount++;
            } else {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                allCorrect = false;
            }
        });

        // B. Validasi Select (True/False)
        container.querySelectorAll('.select-akar').forEach(sel => {
            totalSoal++;
            if (sel.value === sel.getAttribute('data-answer')) {
                sel.classList.remove('is-invalid');
                sel.classList.add('is-valid');
                correctCount++;
            } else {
                sel.classList.remove('is-valid');
                sel.classList.add('is-invalid');
                allCorrect = false;
            }
        });

        attemptCount++;

        // --- KONDISI HASIL ---
        
        // 1. SEMUA BENAR
        if (allCorrect) {
            Swal.fire({
                icon: 'success',
                title: 'Luar Biasa!',
                text: `Semua jawaban benar pada percobaan ke-${attemptCount}.`,
                confirmButtonText: 'Selesai',
                confirmButtonColor: '#198754'
            }).then(() => {
                // Matikan input
                checkBtn.disabled = true;
                container.querySelectorAll('input, select').forEach(el => el.disabled = true);
            });
        } 
        // 2. MASIH ADA SALAH
        else {
            if (attemptCount >= maxAttempts) {
                // GAGAL 3 KALI
                Swal.fire({
                    icon: 'error',
                    title: 'Kesempatan Habis',
                    html: `Anda sudah mencoba ${maxAttempts} kali.<br>Ingin mengulang dari awal atau melihat jawaban?`,
                    showCancelButton: true,
                    confirmButtonText: 'Lanjutkan',
                    confirmButtonColor: '#0d6efd',
                    cancelButtonText: 'Ulang',
                    cancelButtonColor: '#dc3545',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        showAnswersAkar();
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        resetAkar();
                    }
                });
            } else {
                // SALAH (Masih ada kesempatan)
                Swal.fire({
                    icon: 'warning',
                    title: 'Masih Keliru',
                    text: `Cek kembali hitungan akarnya. Sisa kesempatan: ${maxAttempts - attemptCount} kali.`,
                    confirmButtonText: 'Coba Lagi',
                    confirmButtonColor: '#ffc107'
                });
            }
        }
    });
}

// Panggil fungsi saat dokumen siap
document.addEventListener('DOMContentLoaded', function() {
    initPageAkar();
});




/* =====================================================
   AYO BERLATIH (HALAMAN 5) - SOAL 1, 2, DAN 3
===================================================== */

// Variabel Global untuk Ayo Berlatih
let attemptLatihan1 = 0;
let attemptLatihan2 = 0;
let attemptLatihan3 = 0;
const MAX_ATTEMPT_LATIHAN = 3;

// --- FUNGSI BANTUAN VISUAL UMUM ---
function setValidVisual(el) {
    if (!el) return;
    el.classList.remove('border-danger', 'text-danger', 'border-secondary', 'bg-light', 'text-muted', 'border-dark', 'text-dark', 'btn-dark', 'btn-outline-dark', 'bg-light-danger');
    el.classList.add('border-success', 'text-success');
    if (el.classList.contains('btn-pilihan')) el.classList.add('btn-success', 'text-white');
}

function setInvalidVisual(el) {
    if (!el) return;
    el.classList.remove('border-success', 'text-success', 'border-secondary', 'bg-light', 'text-muted', 'border-dark', 'text-dark', 'btn-dark', 'btn-outline-dark');
    el.classList.add('border-danger', 'text-danger');
    if (el.classList.contains('drop-zone')) el.classList.add('bg-light-danger');
    if (el.classList.contains('btn-pilihan')) el.classList.add('btn-danger', 'text-white');
}

function setGreyVisual(el) {
    if (!el) return;
    el.classList.remove('border-danger', 'text-danger', 'border-success', 'text-success', 'border-dark', 'text-dark', 'bg-light-danger');
    el.classList.add('border-secondary', 'bg-light', 'text-muted');
    if(el.tagName === 'INPUT' || el.tagName === 'SELECT') el.disabled = true;
}


// ==========================================
// SOAL 1
// ==========================================
function pilihRumusAnalisis(status, btn) {
    const container = btn.closest('.row');
    const semuaTombol = container.querySelectorAll('.btn-pilihan');
    semuaTombol.forEach(b => {
        b.classList.remove('btn-success', 'btn-dark', 'text-white', 'is-selected');
        b.classList.add('btn-outline-dark'); 
        b.dataset.status = 'salah'; 
    });
    btn.classList.remove('btn-outline-dark'); 
    btn.classList.add('btn-dark', 'text-white', 'is-selected');
    btn.dataset.status = status; 
}

function cekLatihanAnalisis1() {
    const tanya = document.getElementById('s1_tanya');
    const diket1 = document.getElementById('s1_diketahui_1');
    const diket2 = document.getElementById('s1_diketahui_2');
    
    const btnGroups = document.getElementById('s1_tanya').closest('.card-body').querySelectorAll('.row.g-2, .row.g-3');
    const btnOp = btnGroups[0] ? btnGroups[0].querySelector('.is-selected') : null;
    const btnRumus = btnGroups[1] ? btnGroups[1].querySelector('.is-selected') : null;

    if (!tanya.value || !diket1.value.trim() || !diket2.value.trim() || !btnOp || !btnRumus) {
        Swal.fire({ title: 'Perhatian', text: 'Lengkapi isian dan pilihan rumus.', confirmButtonColor: '#198754'});
        return;
    }

    attemptLatihan1++;
    let benarSemua = true;

    if (tanya.value === 'miring') setValidVisual(tanya); else { setInvalidVisual(tanya); benarSemua = false; }

    const valDiket = [diket1.value.trim().toUpperCase(), diket2.value.trim().toUpperCase()];
    if (valDiket.includes('AB') && valDiket.includes('BC')) {
        setValidVisual(diket1); setValidVisual(diket2);
    } else {
        if(!['AB', 'BC'].includes(valDiket[0])) setInvalidVisual(diket1); else setValidVisual(diket1);
        if(!['AB', 'BC'].includes(valDiket[1])) setInvalidVisual(diket2); else setValidVisual(diket2);
        benarSemua = false;
    }

    if (btnOp.dataset.status === 'benar') setValidVisual(btnOp); else { setInvalidVisual(btnOp); benarSemua = false; }
    if (btnRumus.dataset.status === 'benar') setValidVisual(btnRumus); else { setInvalidVisual(btnRumus); benarSemua = false; }

    if (benarSemua) {
        document.getElementById('s1_feedback').innerText = "Tepat sekali!";
        Swal.fire({ title: 'Berhasil', text: 'Semua analisismu benar.', confirmButtonColor: '#198754' });
    } else if (attemptLatihan1 >= MAX_ATTEMPT_LATIHAN) {
        Swal.fire({ title: 'Kesempatan Habis', text: 'Mari kita lihat jawaban yang tepat.', confirmButtonColor: '#6c757d'}).then(() => {
            if (tanya.value !== 'miring') { setGreyVisual(tanya); tanya.value = 'miring'; }
            if (!['AB', 'BC'].includes(diket1.value.trim().toUpperCase())) { setGreyVisual(diket1); diket1.value = 'AB'; }
            if (!['AB', 'BC'].includes(diket2.value.trim().toUpperCase())) { setGreyVisual(diket2); diket2.value = 'BC'; }
            if (btnOp && btnOp.dataset.status !== 'benar') {
                setGreyVisual(btnOp);
                const correctBtn = btnGroups[0].querySelector('[onclick*="benar"]');
                if (correctBtn) correctBtn.classList.add('bg-secondary', 'text-white');
            }
            if (btnRumus && btnRumus.dataset.status !== 'benar') {
                setGreyVisual(btnRumus);
                const correctBtn = btnGroups[1].querySelector('[onclick*="benar"]');
                if (correctBtn) correctBtn.classList.add('bg-secondary', 'text-white');
            }
        });
    } else {
        Swal.fire({ title: 'Kurang Tepat', text: `Sisa kesempatan: ${MAX_ATTEMPT_LATIHAN - attemptLatihan1}`, confirmButtonColor: '#dc3545'});
    }
}


// ==========================================
// SOAL 2 & 3: SETUP DRAG AND DROP BERSAMA
// ==========================================
// Fungsi universal untuk mengurus Drag & Drop di wadah yang spesifik
function setupDragAndDrop(containerId, targetPrefix) {
    const dragContainer = document.getElementById(containerId);
    if (!dragContainer) return;
    
    const dragItems = dragContainer.querySelectorAll('.draggable-item');
    
    // Acak posisi awal item
    for (let i = dragContainer.children.length; i >= 0; i--) {
        dragContainer.appendChild(dragContainer.children[Math.random() * i | 0]);
    }

    // Setup Drag
    dragItems.forEach(item => {
        // Hilangkan event listener ganda dengan teknik kloning
        const newItem = item.cloneNode(true);
        item.parentNode.replaceChild(newItem, item);
        
        newItem.addEventListener('dragstart', function(e) {
            e.dataTransfer.setData('text/plain', e.target.id);
            e.dataTransfer.effectAllowed = 'move';
            setTimeout(() => e.target.style.opacity = '0.5', 0);
        });

        newItem.addEventListener('dragend', function(e) {
            e.target.style.opacity = '1';
        });
    });

    // Setup Drop Zones
    const dropZones = document.querySelectorAll(`.drop-zone[data-target^="${targetPrefix}"]`);
    dropZones.forEach(zone => {
        const newZone = zone.cloneNode(true);
        zone.parentNode.replaceChild(newZone, zone);

        newZone.addEventListener('dragover', function(e) {
            e.preventDefault(); 
            this.style.backgroundColor = '#e8f5e9'; 
            this.style.borderStyle = 'solid';
        });

        newZone.addEventListener('dragleave', function(e) {
            this.style.backgroundColor = ''; 
            this.style.borderStyle = 'dashed';
        });

        newZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.backgroundColor = '';
            
            const id = e.dataTransfer.getData('text/plain');
            const draggedElement = document.getElementById(id);

            // Cek elemen dari container yang sesuai (menggunakan ID Soal atau prefix)
            if (draggedElement && draggedElement.id.includes(targetPrefix === 's2_' ? 'item-' : 'item-')) {
                
                // Jika sudah ada item di zona ini, kembalikan ke atas
                if (this.children.length > 0) {
                    const existingItem = this.querySelector('.draggable-item');
                    if (existingItem) {
                        existingItem.classList.replace('p-1', 'p-2');
                        document.getElementById(containerId).appendChild(existingItem);
                    }
                }
                
                // Masukkan item baru
                draggedElement.style.margin = "0"; 
                draggedElement.classList.replace('p-2', 'p-1'); 
                
                this.appendChild(draggedElement);
                this.style.borderStyle = 'solid';
                this.classList.remove('border-danger', 'bg-light-danger');
                this.classList.add('border-dark'); 
            }
        });

        // Fitur klik untuk mengembalikan ke asal
        newZone.addEventListener('click', function(e) {
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

// Inisialisasi saat halaman khusus "Ayo Berlatih" (Index 4) dimuat
function initDragDropSoal3() {
    setupDragAndDrop('drag-items-container', 's2_'); // Untuk Soal 2
    setupDragAndDrop('drag-items-container-s3', 's3_'); // Untuk Soal 3
}


// ==========================================
// SOAL 2: LOGIKA VALIDASI
// ==========================================
function cekLatihanAnalisis2() {
    const getDropValue = (targetId) => {
        const zone = document.querySelector(`[data-target="${targetId}"]`);
        if (!zone) return null;
        const item = zone.querySelector('.draggable-item');
        return item ? item.getAttribute('data-value') : null;
    };

    const inputsText = document.querySelectorAll('#s2_inp_mo_1, #s2_inp_mo_2, #s2_inp_mo_3, #s2_inp_mo_4');
    const inputMn = document.getElementById('s2_inp_mn');
    const inputNo = document.getElementById('s2_inp_no');
    const resMnSq = document.getElementById('s2_res_mn_sq');
    const resNoSq = document.getElementById('s2_res_no_sq');
    const resSum = document.getElementById('s2_res_sum');
    const resSqrt = document.getElementById('s2_res_sqrt');
    const final = document.getElementById('s2_final');
    
    const dropZones = [
        'diketahui_mn', 'diketahui_no', 'ditanya', 
        'rumus_miring', 'rumus_tegak1', 'rumus_tegak2'
    ].map(t => document.querySelector(`[data-target="s2_${t}"]`)).filter(el => el !== null);

    // Cek form kosong (Gunakan pengecekan spesifik Soal 2 agar tdk nabrak dgn null value)
    const isInputEmpty = [...inputsText, inputMn, inputNo, resMnSq, resNoSq, resSum, resSqrt, final]
                         .some(input => input && input.value.trim() === '');
    
    // Perbaikan: Cek kekosongan manual dengan getDropValue karena nama target di HTML bisa bervariasi
    let isDropEmpty = false;
    if(!getDropValue('diketahui_mn') || !getDropValue('diketahui_no') || !getDropValue('ditanya') || 
       !getDropValue('rumus_miring') || !getDropValue('rumus_tegak1') || !getDropValue('rumus_tegak2')){
        isDropEmpty = true;
    }

    if (isDropEmpty || isInputEmpty) {
        Swal.fire({ title: 'Perhatian', text: 'Harap lengkapi susunan item dan kotak perhitungan terlebih dahulu.', confirmButtonColor: '#198754' });
        return;
    }

    attemptLatihan2++;
    let benarSemua = true;

    const checkDrop = (target, validValues) => {
        const zone = document.querySelector(`[data-target="${target}"]`);
        if (!zone) return;
        const itemVal = getDropValue(target);
        if (validValues.includes(itemVal)) {
            setValidVisual(zone);
        } else {
            setInvalidVisual(zone);
            benarSemua = false;
        }
    };

    // Validasi Drop Zones Soal 2
    checkDrop('diketahui_mn', ['15cm', '8cm']);
    checkDrop('diketahui_no', ['15cm', '8cm']);
    checkDrop('ditanya', ['tanya']);
    checkDrop('rumus_miring', ['MO']);
    checkDrop('rumus_tegak1', ['MN', 'NO']);
    checkDrop('rumus_tegak2', ['MN', 'NO']);

    inputsText.forEach(inp => {
        if (inp && inp.value.trim().toUpperCase() === 'MO') setValidVisual(inp);
        else if (inp) { setInvalidVisual(inp); benarSemua = false; }
    });

    const valMn = parseInt(inputMn.value);
    const valNo = parseInt(inputNo.value);
    
    if ((valMn === 15 && valNo === 8) || (valMn === 8 && valNo === 15)) {
        setValidVisual(inputMn); setValidVisual(inputNo);
    } else {
        setInvalidVisual(inputMn); setInvalidVisual(inputNo);
        benarSemua = false;
    }

    if (parseInt(resMnSq.value) === Math.pow(valMn, 2) && valMn > 0) setValidVisual(resMnSq); else { setInvalidVisual(resMnSq); benarSemua = false; }
    if (parseInt(resNoSq.value) === Math.pow(valNo, 2) && valNo > 0) setValidVisual(resNoSq); else { setInvalidVisual(resNoSq); benarSemua = false; }
    if (parseInt(resSum.value) === 289) setValidVisual(resSum); else { setInvalidVisual(resSum); benarSemua = false; }
    if (parseInt(resSqrt.value) === 289) setValidVisual(resSqrt); else { setInvalidVisual(resSqrt); benarSemua = false; }
    if (parseInt(final.value) === 17) setValidVisual(final); else { setInvalidVisual(final); benarSemua = false; }

    if (benarSemua) {
        const fb = document.getElementById('s2_feedback');
        if(fb) fb.innerText = "Perhitungan Sempurna!";
        Swal.fire({ title: 'Berhasil', text: 'Susunan rumus dan perhitunganmu tepat.', confirmButtonColor: '#198754' });
        return;
    }

    if (attemptLatihan2 >= MAX_ATTEMPT_LATIHAN) {
        Swal.fire({ title: 'Kesempatan Habis', text: 'Mari perbaiki bagian yang salah menjadi abu-abu.', confirmButtonColor: '#6c757d' }).then(() => {
            const checkAndFix = (el, correctVal) => {
                if (el && el.classList.contains('border-danger')) {
                    setGreyVisual(el);
                    el.value = correctVal;
                }
            };
            inputsText.forEach(inp => checkAndFix(inp, 'MO'));
            checkAndFix(inputMn, 15); checkAndFix(inputNo, 8); checkAndFix(resMnSq, 225);
            checkAndFix(resNoSq, 64); checkAndFix(resSum, 289); checkAndFix(resSqrt, 289); checkAndFix(final, 17);
            
            // Dropzone reset logic (Sederhana: disabled saja visualnya jika salah)
            ['diketahui_mn', 'diketahui_no', 'ditanya', 'rumus_miring', 'rumus_tegak1', 'rumus_tegak2'].forEach(t => {
                const z = document.querySelector(`[data-target="${t}"]`);
                if(z && z.classList.contains('border-danger')) setGreyVisual(z);
            });
        });
    } else {
        Swal.fire({ title: 'Kurang Tepat', text: `Periksa kembali yang berwarna merah. (Sisa kesempatan: ${MAX_ATTEMPT_LATIHAN - attemptLatihan2})`, confirmButtonColor: '#dc3545' });
    }
}


// ==========================================
// SOAL 3: LOGIKA RESET & VALIDASI
// ==========================================
function resetSoal3() {
    const container = document.getElementById('soal3-container');
    const dragContainer = document.getElementById('drag-items-container-s3');
    if(!container || !dragContainer) return;

    // 1. Kembalikan semua item drag ke container aslinya
    const allItems = container.querySelectorAll('.draggable-item');
    allItems.forEach(item => {
        item.classList.replace('p-1', 'p-2');
        item.style.opacity = '1';
        item.style.margin = '';
        dragContainer.appendChild(item);
    });

    // 2. Acak ulang
    for (let i = dragContainer.children.length; i >= 0; i--) {
        dragContainer.appendChild(dragContainer.children[Math.random() * i | 0]);
    }

    // 3. Reset Drop Zones
    const allDropZones = container.querySelectorAll('.drop-zone[data-target^="s3_"]');
    allDropZones.forEach(zone => {
        zone.style.borderStyle = 'dashed';
        zone.style.backgroundColor = '';
        zone.classList.remove('border-danger', 'border-success', 'bg-light-danger');
        zone.classList.add('border-dark');
    });

    // 4. Reset Inputs
    const allInputs = container.querySelectorAll('input[id^="s3_"]:not([disabled])');
    allInputs.forEach(input => {
        input.value = '';
        input.disabled = false;
        input.classList.remove('border-danger', 'text-danger', 'border-success', 'text-success', 'bg-light', 'text-muted');
        input.classList.add('border-dark', 'bg-white');
    });

    // 5. Reset attempts
    attemptLatihan3 = 0;
    const feedback = document.getElementById('s3_feedback');
    if(feedback) feedback.innerText = '';
}

function cekLatihanAnalisis3() {
    const getDropValue = (targetId) => {
        const zone = document.querySelector(`[data-target="${targetId}"]`);
        if (!zone) return null;
        const item = zone.querySelector('.draggable-item');
        return item ? item.getAttribute('data-value') : null;
    };
    
    const getVal = (id) => {
        const el = document.getElementById(id);
        return el ? parseInt(el.value) : NaN;
    };

    // Ambil Elemen Input & Zona Drop
    const inps = {
        ac_sq1: document.getElementById('s3_ac_sq1'), ac_sq2: document.getElementById('s3_ac_sq2'),
        ac_sum1: document.getElementById('s3_ac_sum1'), ac_sum2: document.getElementById('s3_ac_sum2'),
        ac_tot: document.getElementById('s3_ac_total'), ac_sqrt: document.getElementById('s3_ac_sqrt_val'), ac_fin: document.getElementById('s3_ac_final'),
        ab_sq1: document.getElementById('s3_ab_sq1'), ab_sq2: document.getElementById('s3_ab_sq2'),
        ab_sum1: document.getElementById('s3_ab_sum1'), ab_sum2: document.getElementById('s3_ab_sum2'),
        ab_tot: document.getElementById('s3_ab_total'), ab_sqrt: document.getElementById('s3_ab_sqrt_val'), ab_fin: document.getElementById('s3_ab_final'),
        bc_sq1: document.getElementById('s3_bc_sq1'), bc_sq2: document.getElementById('s3_bc_sq2'),
        bc_diff1: document.getElementById('s3_bc_diff1'), bc_diff2: document.getElementById('s3_bc_diff2'),
        bc_tot: document.getElementById('s3_bc_total'), bc_sqrt: document.getElementById('s3_bc_sqrt_val'), bc_fin: document.getElementById('s3_bc_final')
    };

    const zones = {
        diketAE: document.querySelector('[data-target="s3_diket_ae"]'), diketCE: document.querySelector('[data-target="s3_diket_ce"]'),
        diketAD: document.querySelector('[data-target="s3_diket_ad"]'), diketBD: document.querySelector('[data-target="s3_diket_bd"]'),
        ditanya: document.querySelector('[data-target="s3_ditanya"]'),
        ac1: document.querySelector('[data-target="s3_ac_drop1"]'), ac2: document.querySelector('[data-target="s3_ac_drop2"]'),
        ab1: document.querySelector('[data-target="s3_ab_drop1"]'), ab2: document.querySelector('[data-target="s3_ab_drop2"]'),
        bc1: document.querySelector('[data-target="s3_bc_drop1"]'), bc2: document.querySelector('[data-target="s3_bc_drop2"]')
    };

    const isDropZoneEmpty = Object.values(zones).some(z => !z || z.querySelectorAll('.draggable-item').length === 0);
    const isInputEmpty = Object.values(inps).some(i => !i || i.value.trim() === '');

    if (isDropZoneEmpty || isInputEmpty) {
        Swal.fire({ title: 'Perhatian', text: 'Lengkapi kotak drag & drop dan angka terlebih dahulu.', confirmButtonColor: '#198754' });
        return;
    }

    attemptLatihan3++;
    let benarSemua = true;
    const elementsToValidate = []; 

    const check = (el, condition) => {
        if(!el) return;
        elementsToValidate.push({ el: el, isCorrect: condition });
        if (!condition) benarSemua = false;
    };
    
    const checkDropPair = (z1, z2, validArr) => {
        const v1 = getDropValue(z1.dataset.target);
        const v2 = getDropValue(z2.dataset.target);
        const isCor = (v1 === validArr[0] && v2 === validArr[1]) || (v1 === validArr[1] && v2 === validArr[0]);
        check(z1, isCor); check(z2, isCor);
    };

    // Validasi Soal 3
    check(zones.diketAE, getDropValue('s3_diket_ae') === '24');
    check(zones.diketCE, getDropValue('s3_diket_ce') === '7');
    check(zones.diketAD, getDropValue('s3_diket_ad') === '16');
    check(zones.diketBD, getDropValue('s3_diket_bd') === '12');
    check(zones.ditanya, getDropValue('s3_ditanya') === 'BC');

    checkDropPair(zones.ac1, zones.ac2, ['AE', 'CE']);
    check(inps.ac_sq1, [24, 7].includes(getVal('s3_ac_sq1'))); check(inps.ac_sq2, [24, 7].includes(getVal('s3_ac_sq2')));
    check(inps.ac_sum1, [576, 49].includes(getVal('s3_ac_sum1'))); check(inps.ac_sum2, [576, 49].includes(getVal('s3_ac_sum2')));
    check(inps.ac_tot, getVal('s3_ac_total') === 625); check(inps.ac_sqrt, getVal('s3_ac_sqrt_val') === 625); check(inps.ac_fin, getVal('s3_ac_final') === 25);

    checkDropPair(zones.ab1, zones.ab2, ['AD', 'BD']);
    check(inps.ab_sq1, [16, 12].includes(getVal('s3_ab_sq1'))); check(inps.ab_sq2, [16, 12].includes(getVal('s3_ab_sq2')));
    check(inps.ab_sum1, [256, 144].includes(getVal('s3_ab_sum1'))); check(inps.ab_sum2, [256, 144].includes(getVal('s3_ab_sum2')));
    check(inps.ab_tot, getVal('s3_ab_total') === 400); check(inps.ab_sqrt, getVal('s3_ab_sqrt_val') === 400); check(inps.ab_fin, getVal('s3_ab_final') === 20);

    check(zones.bc1, getDropValue('s3_bc_drop1') === 'AC'); check(zones.bc2, getDropValue('s3_bc_drop2') === 'AB');
    check(inps.bc_sq1, getVal('s3_bc_sq1') === 25); check(inps.bc_sq2, getVal('s3_bc_sq2') === 20); 
    check(inps.bc_diff1, getVal('s3_bc_diff1') === 625); check(inps.bc_diff2, getVal('s3_bc_diff2') === 400);
    check(inps.bc_tot, getVal('s3_bc_total') === 225); check(inps.bc_sqrt, getVal('s3_bc_sqrt_val') === 225); check(inps.bc_fin, getVal('s3_bc_final') === 15);

    // Apply Style
    elementsToValidate.forEach(item => item.isCorrect ? setValidVisual(item.el) : setInvalidVisual(item.el));

    if (benarSemua) {
        document.getElementById('s3_feedback').innerText = "Sempurna!";
        Swal.fire({ title: 'Berhasil!', text: 'Semua jawaban benar.', icon: 'success', confirmButtonColor: '#198754' });
    } else {
        if (attemptLatihan3 >= MAX_ATTEMPT_LATIHAN) {
            Swal.fire({ title: 'Kesempatan Habis', text: 'Perbaiki bagian yang berwarna abu-abu.', confirmButtonColor: '#6c757d' }).then(() => {
                 elementsToValidate.forEach(item => { if (!item.isCorrect) setGreyVisual(item.el); });
            });
        } else {
            Swal.fire({ title: 'Ada yang keliru', text: `Sisa percobaan: ${MAX_ATTEMPT_LATIHAN - attemptLatihan3}`, icon: 'warning', confirmButtonColor: '#dc3545' });
        }
    }
}


/* ===============================
   HALAMAN 3 – FUNGSI (VISUAL INTERAKTIF SEGITIGA)
================================ */
function initPage2() {
    // Inisialisasi canvas segitiga
    const canvas = document.querySelector('[data-page="2"] #triangleCanvas');
    if (canvas) {
        initTriangleCanvas(canvas);
    }
    
    // Tambahkan event listener untuk tombol di halaman 3
    const btnTable = document.querySelector('[data-page="2"] button[onclick*="checkTableAnswers"]');
    const btnQuestion = document.querySelector('[data-page="2"] button[onclick*="checkQuestionAnswers"]');
    
    if (btnTable) {
        btnTable.onclick = checkTableAnswers;
    }
    
    if (btnQuestion) {
        btnQuestion.onclick = checkQuestionAnswers;
    }
}
/* ================= LOGIKA INTERAKTIF SEGITIGA & KUIS ================= */

// Global Variable untuk menyimpan index titik sudut siku-siku (0=A, 1=B, 2=C)
let rightAngleVertexIndex = -1; 

function initTriangleCanvas(canvasElement) {
    const ctx = canvasElement.getContext("2d");
    const container = document.getElementById("canvasContainer");

    /* ================= STATE ================= */
    let points = []; 
    let lines = []; 
    let isDragging = false; 
    let dragStartPoint = null; 
    let currentMousePos = { x: 0, y: 0 };
    const gridSize = 32;

    /* ================= RESPONSIVE ================= */
    function resizeCanvas() {
        if (!container) return;
        canvasElement.width = container.clientWidth;
        // Tinggi disesuaikan agar proporsional dengan kolom kanan
        canvasElement.height = 400; 
        render();
    }
    window.addEventListener("resize", resizeCanvas);
    setTimeout(resizeCanvas, 100);

    /* ================= HELPER ================= */
    function snapToGrid(pos) { return { x: Math.round(pos.x / gridSize) * gridSize, y: Math.round(pos.y / gridSize) * gridSize }; }
    function getMousePos(e) { const r = canvasElement.getBoundingClientRect(); return { x: e.clientX - r.left, y: e.clientY - r.top }; }
    function getPointAt(pos) { return points.find(p => Math.abs(p.x - pos.x) < 15 && Math.abs(p.y - pos.y) < 15); }
    function drawGrid() {
        ctx.save(); ctx.strokeStyle = "#e9ecef"; ctx.lineWidth = 1;
        for (let x = 0; x <= canvasElement.width; x += gridSize) { ctx.beginPath(); ctx.moveTo(x, 0); ctx.lineTo(x, canvasElement.height); ctx.stroke(); }
        for (let y = 0; y <= canvasElement.height; y += gridSize) { ctx.beginPath(); ctx.moveTo(0, y); ctx.lineTo(canvasElement.width, y); ctx.stroke(); }
        ctx.restore();
    }

    /* ================= EVENTS ================= */
    canvasElement.addEventListener("mousedown", (e) => {
        const rawPos = getMousePos(e); const snappedPos = snapToGrid(rawPos); const existingPoint = getPointAt(rawPos);
        if (points.length < 3) { if (!getPointAt(snappedPos)) { points.push(snappedPos); render(); } } 
        else if (points.length === 3 && existingPoint) { isDragging = true; dragStartPoint = existingPoint; currentMousePos = rawPos; }
    });
    canvasElement.addEventListener("mousemove", (e) => { currentMousePos = getMousePos(e); if (isDragging) render(); });
    canvasElement.addEventListener("mouseup", (e) => {
        if (isDragging) {
            const rawPos = getMousePos(e); const targetPoint = getPointAt(rawPos);
            if (targetPoint && targetPoint !== dragStartPoint) {
                const exists = lines.some(l => (l.start===dragStartPoint && l.end===targetPoint) || (l.start===targetPoint && l.end===dragStartPoint));
                if (!exists) { lines.push({ start: dragStartPoint, end: targetPoint }); if (lines.length === 3) checkTriangle(); }
            }
        }
        isDragging = false; dragStartPoint = null; render();
    });

    /* ================= VALIDASI & DETEKSI SUDUT ================= */
    function checkTriangle() {
        const [p1, p2, p3] = points;
        const d1 = distSq(p1, p2); const d2 = distSq(p2, p3); const d3 = distSq(p3, p1);
        const sides = [d1, d2, d3].sort((a, b) => a - b);
        
        const isRightAngled = (Math.abs((sides[0] + sides[1]) - sides[2]) < 0.1);
        rightAngleVertexIndex = -1;

        if (isRightAngled) {
            // Deteksi titik sudut mana yang 90 derajat
            for (let i = 0; i < 3; i++) {
                const pCurrent = points[i];
                const pPrev = points[(i + 2) % 3];
                const pNext = points[(i + 1) % 3];
                const v1 = { x: pPrev.x - pCurrent.x, y: pPrev.y - pCurrent.y };
                const v2 = { x: pNext.x - pCurrent.x, y: pNext.y - pCurrent.y };
                const dot = v1.x * v2.x + v1.y * v2.y;
                if (Math.abs(dot) < 0.1) { rightAngleVertexIndex = i; break; }
            }
        }
        updateUI(isRightAngled);
    }
    function distSq(p1, p2) { return Math.pow((p1.x - p2.x)/gridSize, 2) + Math.pow((p1.y - p2.y)/gridSize, 2); }

    function updateUI(isCorrect) {
        const initial = document.getElementById('initialState');
        const success = document.getElementById('successState');
        const fail = document.getElementById('failState');
        
        initial.classList.add('d-none'); success.classList.add('d-none'); fail.classList.add('d-none');

        if (isCorrect) {
            success.classList.remove('d-none');
            // Ganti warna card pembahasan jadi hijau muda
            document.getElementById('statusCard').style.backgroundColor = "#e8f5e9";
            unlockQuiz();
        } else {
            fail.classList.remove('d-none');
            document.getElementById('statusCard').style.backgroundColor = "#ffebee";
            lockQuiz();
        }
    }

    /* ================= RENDER ================= */
    function render() {
        ctx.clearRect(0, 0, canvasElement.width, canvasElement.height); drawGrid();
        
        ctx.save(); ctx.lineWidth = 3; ctx.strokeStyle = "#212529"; ctx.beginPath();
        lines.forEach(l => { ctx.moveTo(l.start.x, l.start.y); ctx.lineTo(l.end.x, l.end.y); });
        ctx.stroke();
        
        if (lines.length === 3) {
            ctx.fillStyle = "rgba(13, 110, 253, 0.1)"; ctx.beginPath();
            ctx.moveTo(points[0].x, points[0].y); ctx.lineTo(points[1].x, points[1].y); ctx.lineTo(points[2].x, points[2].y);
            ctx.closePath(); ctx.fill();
            drawRightAngleSymbol();
        }
        ctx.restore();

        if (isDragging && dragStartPoint) {
            ctx.save(); ctx.beginPath(); ctx.moveTo(dragStartPoint.x, dragStartPoint.y); ctx.lineTo(currentMousePos.x, currentMousePos.y);
            ctx.strokeStyle = "#adb5bd"; ctx.setLineDash([5, 5]); ctx.lineWidth = 2; ctx.stroke(); ctx.restore();
        }

        points.forEach((p, i) => {
            const labels = ["A", "B", "C"];
            const isHovered = isDragging && Math.abs(p.x - currentMousePos.x) < 15 && Math.abs(p.y - currentMousePos.y) < 15;
            const isActive = (p === dragStartPoint) || isHovered;
            
            ctx.fillStyle = isActive ? "#198754" : "#0d6efd"; 
            ctx.strokeStyle = "#fff"; ctx.lineWidth = 2;
            ctx.beginPath(); ctx.arc(p.x, p.y, isActive ? 8 : 6, 0, Math.PI * 2); ctx.fill(); ctx.stroke();
            
            ctx.fillStyle = "#000"; ctx.font = "bold 14px Arial"; 
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
        ctx.save(); const size = 15;
        const angleA = Math.atan2(pA.y - corner.y, pA.x - corner.x);
        const angleB = Math.atan2(pB.y - corner.y, pB.x - corner.x);
        ctx.strokeStyle = "#dc3545"; ctx.lineWidth = 2; ctx.beginPath();
        const dx1 = Math.cos(angleA)*size; const dy1 = Math.sin(angleA)*size;
        const dx2 = Math.cos(angleB)*size; const dy2 = Math.sin(angleB)*size;
        ctx.moveTo(corner.x+dx1, corner.y+dy1); ctx.lineTo(corner.x+dx1+dx2, corner.y+dy1+dy2);
        ctx.lineTo(corner.x+dx2, corner.y+dy2); ctx.stroke();
        
        ctx.fillStyle = "#dc3545"; ctx.font = "bold 12px Arial"; ctx.textAlign = "center"; ctx.textBaseline = "middle";
        ctx.fillText("90°", corner.x+(dx1+dx2)*2.2, corner.y+(dy1+dy2)*2.2);
        ctx.restore();
    }

    window.resetCanvas = function () {
        points = []; lines = []; isDragging = false; dragStartPoint = null; rightAngleVertexIndex = -1;
        document.getElementById('initialState').classList.remove('d-none');
        document.getElementById('successState').classList.add('d-none');
        document.getElementById('failState').classList.add('d-none');
        document.getElementById('statusCard').style.backgroundColor = "";
        lockQuiz();
        render();
    };
    resizeCanvas();
}

/* ================= QUIZ LOGIC ================= */
function unlockQuiz() {
    const overlay = document.getElementById('quizLockOverlay');
    if(overlay) overlay.classList.add('d-none'); 
    ['q1', 'q2', 'q3', 'btnPeriksaQuiz'].forEach(id => document.getElementById(id).disabled = false);
}

function lockQuiz() {
    const overlay = document.getElementById('quizLockOverlay');
    if(overlay) overlay.classList.remove('d-none');
    document.getElementById('triangleQuizForm').reset();
    document.getElementById('quizFeedback').style.display = 'none';
    ['q1', 'q2', 'q3', 'btnPeriksaQuiz'].forEach(id => document.getElementById(id).disabled = true);
}

function checkQuizAnswers() {
    const a1 = document.getElementById('q1').value;
    const a2 = document.getElementById('q2').value;
    const a3 = document.getElementById('q3').value;
    const feedback = document.getElementById('quizFeedback');

    let correctSidePair = "";
    if (rightAngleVertexIndex === 0) correctSidePair = "ab_ac";      // Sudut A
    else if (rightAngleVertexIndex === 1) correctSidePair = "ab_bc"; // Sudut B
    else if (rightAngleVertexIndex === 2) correctSidePair = "ac_bc"; // Sudut C

    if (a1 === '90' && a2 === correctSidePair && a3 === 'depan') {
        feedback.style.display = 'block';
        feedback.className = "alert alert-success border-success mt-4 text-center animate__animated animate__fadeInUp";
        feedback.innerHTML = `<h6 class="fw-bold mb-1">Semua Jawaban Benar!</h6><p class="mb-0 small">Selanjutnya kita memahami penamaan segitiga siku-siku.</p>`;
    } else {
        feedback.style.display = 'block';
        feedback.className = "alert alert-danger border-danger mt-4 text-center animate__animated animate__shakeX";
        feedback.innerHTML = `<span class="fw-bold small">Ada yang belum tepat.</span><p class="mb-0 small mt-1">Periksa lagi huruf pada sudut siku-siku di gambarmu.</p>`;
    }
}

/* ===============================
   HALAMAN 3 – FUNGSI (MENGENAL SISI SEGITIGA)
================================ */
function cekJawabanSikusiku() {
    // 1. Ambil nilai input
    var jawaban = document.getElementById('inputTitikSudut').value;

    // 2. Normalisasi jawaban
    var jawabanBersih = jawaban
        .toLowerCase()
        .replace(/[^a-z]/g, '');

    // 3. Elemen feedback
    var feedbackBenar = document.getElementById('feedbackBenar');
    var feedbackSalah = document.getElementById('feedbackSalah');

    // 4. Reset semua feedback
    feedbackBenar.classList.add('d-none');
    feedbackSalah.classList.add('d-none');

    // 5. KONDISI 1: Jawaban kosong
    if (jawabanBersih === '') {
        feedbackSalah.classList.remove('d-none');
        feedbackSalah.querySelector('.alert')
            .className = 'alert alert-warning d-flex align-items-center py-2 mb-0';
        feedbackSalah.querySelector('.alert div').innerText =
            'Silakan isi jawaban Anda terlebih dahulu.';
        return;
    }

    // 6. KONDISI 2: Jawaban benar (titik B)
    if (jawabanBersih === 'b' || jawabanBersih === 'titikb') {
        feedbackBenar.classList.remove('d-none');
        feedbackBenar.querySelector('.alert div').innerHTML =
            '<strong>Tepat Sekali</strong>. Sudut B memiliki ukuran tepat 90° dan disebut sudut siku-siku. Oleh karena itu, segitiga tersebut merupakan <strong>segitiga siku-siku</strong>, karena memiliki salah satu sudut yang ukurannya tepat 90°.';
        return;
    }

    // 7. KONDISI 3: Jawaban salah
    feedbackSalah.classList.remove('d-none');
    feedbackSalah.querySelector('.alert')
        .className = 'alert alert-danger d-flex align-items-center py-2 mb-0';
    feedbackSalah.querySelector('.alert div').innerText =
        'Jawaban Anda kurang tepat. Perhatikan kembali titik sudut pada GeoGebra.';
}

// 1. Fungsi Helper: Menormalisasi Ruas Garis (Misal: "FG" == "GF")
    function normalizeSegment(str) {
        if (!str) return "";
        // Hapus spasi -> Ubah ke Huruf Besar -> Pisah per huruf -> Urutkan abjad -> Gabung lagi
        return str.trim().toUpperCase().split('').sort().join('');
    }

    // 2. Fungsi Utama: Dijalankan saat tombol diklik
    function checkAllAnswers() {
        let totalErrors = 0;

        // --- A. VALIDASI SISI KECIL (ABC, MNO, PQR) ---
        document.querySelectorAll('.sisi-input').forEach(input => {
            let userVal = input.value.trim().toLowerCase();
            let correctVal = input.getAttribute('data-answer');
            
            if (userVal === correctVal && userVal !== "") {
                input.classList.add('is-valid');
                input.classList.remove('is-invalid');
            } else {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                totalErrors++;
            }
        });

        // --- B. VALIDASI TABEL - TITIK SUDUT (EFG & HIJ) ---
        document.querySelectorAll('.input-titik').forEach(input => {
            let userVal = input.value.trim().toUpperCase();
            let correctVal = input.getAttribute('data-correct');

            if (userVal === correctVal && userVal !== "") {
                input.classList.add('is-valid');
                input.classList.remove('is-invalid');
            } else {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                totalErrors++;
            }
        });

        // --- C. VALIDASI TABEL - RUAS GARIS (EFG & HIJ) ---
        document.querySelectorAll('.input-ruas').forEach(input => {
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

        // --- D. TAMPILKAN HASIL DENGAN SWEETALERT ---
        let feedbackEl = document.getElementById('final-feedback');
        
        if (totalErrors === 0) {
            // Update Text di bawah tombol (Opsional, agar tetap ada status tertulis)
            feedbackEl.className = "mt-3 fw-bold text-success";
            feedbackEl.innerHTML = "Luar Biasa! Semua jawabanmu benar.";

            // Tampilkan SweetAlert SUKSES
            Swal.fire({
                icon: 'success',
                title: 'Luar Biasa!',
                text: 'Semua jawabanmu benar. Kerja bagus!',
                confirmButtonText: 'Mantap!',
                confirmButtonColor: '#198754' // Warna Hijau Bootstrap
            });

        } else {
            // Update Text di bawah tombol
            feedbackEl.className = "mt-3 fw-bold text-danger";
            feedbackEl.innerHTML = "Masih ada " + totalErrors + " kotak yang belum tepat.";

            // Tampilkan SweetAlert ERROR
            Swal.fire({
                icon: 'error',
                title: 'Masih ada kesalahan',
                text: 'Masih ada ' + totalErrors + ' kotak yang belum tepat atau kosong. Coba perhatikan yang berwarna merah.',
                confirmButtonText: 'Coba Lagi',
                confirmButtonColor: '#dc3545' // Warna Merah Bootstrap
            });
        }
    }

document.addEventListener('DOMContentLoaded', function() {
    const btnCekSisi = document.getElementById('btnCekSisi');
    
    if(btnCekSisi) {
        btnCekSisi.addEventListener('click', function() {
            const inputs = document.querySelectorAll('.sisi-input');
            let allCorrect = true;
            let filledCount = 0;

            inputs.forEach(input => {
                const val = input.value.trim(); 
                const ans = input.dataset.answer;

                if(val !== '') filledCount++;

                input.classList.remove('is-valid', 'is-invalid');

                // Validasi: Benar jika sama persis (huruf kecil)
                if (val === ans) {
                    input.classList.add('is-valid');
                } else if (val !== '') {
                    input.classList.add('is-invalid');
                    allCorrect = false;
                } else {
                    allCorrect = false; 
                }
            });

            if (filledCount < inputs.length) {
                Swal.fire({
                    icon: 'info',
                    title: 'Belum Lengkap',
                    text: 'Silakan isi semua kolom jawaban terlebih dahulu.',
                    confirmButtonColor: '#0d6efd'
                });
            } else if (allCorrect) {
                Swal.fire({
                    icon: 'success',
                    title: 'Mantap!',
                    text: 'Kamu sudah paham cara menamai sisi segitiga.',
                    confirmButtonColor: '#198754'
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Masih Belum Tepat',
                    text: 'Coba ingat kembali, nama sisi menggunakan huruf kecil sesuai sudut di depannya.',
                    confirmButtonColor: '#ffc107'
                });
            }
        });
    }
});

/* =========================================
   HUBUNGAN SISI SEGITIGA SIKU-SIKU (NAMESPACE SAFE)
========================================= */

const segitigaStep = {
    canvas: null,
    ctx: null,
    currentStep: 0,
    gridColor: 'rgba(68, 43, 43, 1)',
    gridLineWidth: 1,
    
    // Koordinat segitiga untuk konsistensi (disesuaikan untuk canvas 520×520)
    trianglePoints: {
        leftX: 200,      // Titik kiri bawah
        leftY: 360,
        rightX: 320,     // Titik kanan bawah (sudut siku)
        rightY: 360,
        topX: 320,       // Titik kanan atas
        topY: 200
    },
    
    // Ukuran sisi (dalam pixel) - 1 satuan = 40 pixel
    sizes: {
        horizontal: 120, // 3 satuan (3 × 40)
        vertical: 160,   // 4 satuan (4 × 40)
        hypotenuse: 200  // 5 satuan (5 × 40)
    }
};

/* ================= INIT ================= */
function segitiga_init() {
    const canvas = document.querySelector('[data-page="2"] #psp-canvas');
    if (!canvas) return;

    segitigaStep.canvas = canvas;
    segitigaStep.ctx = canvas.getContext('2d');
    
    // Set initial step
    segitiga_goStep(0);
}

/* ================= BASE DRAWING ================= */
function segitiga_drawGrid() {
    const ctx = segitigaStep.ctx;
    ctx.strokeStyle = segitigaStep.gridColor;
    ctx.lineWidth = segitigaStep.gridLineWidth;

    for (let x = 0; x <= 520; x += 40) {
        ctx.beginPath();
        ctx.moveTo(x, 0);
        ctx.lineTo(x, 520);
        ctx.stroke();
    }

    for (let y = 0; y <= 520; y += 40) {
        ctx.beginPath();
        ctx.moveTo(0, y);
        ctx.lineTo(520, y);
        ctx.stroke();
    }
}

function segitiga_drawTriangle() {
    const ctx = segitigaStep.ctx;
    const tp = segitigaStep.trianglePoints;
    
    // Draw triangle
    ctx.fillStyle = '#d65c5c';
    ctx.beginPath();
    ctx.moveTo(tp.leftX, tp.leftY);     // Kiri bawah
    ctx.lineTo(tp.rightX, tp.rightY);   // Kanan bawah (sudut siku)
    ctx.lineTo(tp.topX, tp.topY);       // Kanan atas
    ctx.closePath();
    ctx.fill();

    // Triangle outline
    ctx.strokeStyle = '#000000ff';
    ctx.lineWidth = 3;
    ctx.stroke();

    // Right angle indicator (di sudut kanan bawah)
    ctx.fillStyle = '#000000ff';
    ctx.fillRect(tp.rightX - 20, tp.rightY - 20, 20, 20);
}

function segitiga_drawBase() {
    const ctx = segitigaStep.ctx;
    ctx.clearRect(0, 0, 520, 520);
    
    // Isi background dulu
    ctx.fillStyle = '#ffffffff';
    ctx.fillRect(0, 0, 520, 520);
    
    segitiga_drawGrid();
    segitiga_drawTriangle();
}

/* ================= DRAWING FUNCTIONS ================= */
function segitiga_drawSquare(x, y, size, color, angle = 0) {
    const ctx = segitigaStep.ctx;
    ctx.save();
    ctx.translate(x, y);
    ctx.rotate(angle);
    ctx.fillStyle = color;
    ctx.fillRect(0, 0, size, size);
    ctx.strokeStyle = '#000000ff';
    ctx.lineWidth = 2;
    ctx.strokeRect(0, 0, size, size);
    ctx.restore();
}

function segitiga_drawSquareGrid(x, y, size, color, angle = 0) {
    const ctx = segitigaStep.ctx;
    ctx.save();
    ctx.translate(x, y);
    ctx.rotate(angle);
    
    // Draw the square first
    ctx.fillStyle = color;
    ctx.fillRect(0, 0, size, size);
    ctx.strokeStyle = '#000000ff';
    ctx.lineWidth = 2;
    ctx.strokeRect(0, 0, size, size);
    
    // Draw grid lines
    ctx.strokeStyle = 'rgba(0, 0, 0, 0.5)';
    ctx.lineWidth = 1;
    
    for (let i = 40; i < size; i += 40) {
        ctx.beginPath();
        ctx.moveTo(i, 0);
        ctx.lineTo(i, size);
        ctx.stroke();

        ctx.beginPath();
        ctx.moveTo(0, i);
        ctx.lineTo(size, i);
        ctx.stroke();
    }
    ctx.restore();
}

/* ================= STEP FUNCTIONS ================= */
function segitiga_goStep(step) {
    segitigaStep.currentStep = Math.max(segitigaStep.currentStep, step);
    segitiga_drawBase();
    
    const info = document.querySelector('[data-page="2"] #psp-info');
    const tp = segitigaStep.trianglePoints;
    const sz = segitigaStep.sizes;
    
    if (!info) return;
    
    // STEP 1: Persegi di sisi tegak (4 satuan × 4 satuan)
    if (segitigaStep.currentStep >= 1) {
        // Posisi di sebelah kanan sisi tegak (vertikal)
        segitiga_drawSquare(tp.rightX, tp.topY, sz.vertical, '#0dcaf0');
    }
    
    // STEP 2: Persegi di sisi datar (3 satuan × 3 satuan)
    if (segitigaStep.currentStep >= 2) {
        // Posisi di bawah sisi datar (horizontal)
        segitiga_drawSquare(tp.leftX, tp.leftY, sz.horizontal, '#dc3545');
    }
    
    // STEP 3: Tampilkan kedua persegi bersamaan
    if (segitigaStep.currentStep >= 3) {
        // Gambar kedua persegi
        segitiga_drawSquare(tp.rightX, tp.topY, sz.vertical, '#0dcaf0');
        segitiga_drawSquare(tp.leftX, tp.leftY, sz.horizontal, '#dc3545');
    }
    
    // STEP 4: Tampilkan grid pada persegi sisi tegak
    if (segitigaStep.currentStep >= 4) {
        segitiga_drawSquare(tp.leftX, tp.leftY, sz.horizontal, '#dc3545');
        segitiga_drawSquareGrid(tp.rightX, tp.topY, sz.vertical, '#0dcaf0');
    }
    
    // STEP 5: Tampilkan grid pada persegi sisi datar
    if (segitigaStep.currentStep >= 5) {
        segitiga_drawSquareGrid(tp.rightX, tp.topY, sz.vertical, '#0dcaf0');
        segitiga_drawSquareGrid(tp.leftX, tp.leftY, sz.horizontal, '#dc3545');
    }
    
    // STEP 6: Tampilkan persegi di sisi miring dan hubungannya
    if (segitigaStep.currentStep >= 6) {
        // Tampilkan persegi sisi tegak dan datar dengan grid
        segitiga_drawSquareGrid(tp.rightX, tp.topY, sz.vertical, '#0dcaf0');
        segitiga_drawSquareGrid(tp.leftX, tp.leftY, sz.horizontal, '#dc3545');
        
        // Hitung sudut sisi miring
        const angleC = Math.atan2(tp.topY - tp.leftY, tp.topX - tp.leftX) - Math.PI / 2;
        const ctx = segitigaStep.ctx;
        
        // Draw hypotenuse square dengan grid
        ctx.save();
        ctx.translate(tp.leftX, tp.leftY);
        ctx.rotate(angleC);
        
        // Main square background (orange)
        ctx.fillStyle = '#fd7e14';
        ctx.fillRect(0, 0, sz.hypotenuse, sz.hypotenuse);
        ctx.strokeStyle = '#000000';
        ctx.lineWidth = 2;
        ctx.strokeRect(0, 0, sz.hypotenuse, sz.hypotenuse);
        
        // Draw grid lines
        ctx.strokeStyle = '#000000';
        ctx.lineWidth = 1;
        
        for (let i = 40; i < sz.hypotenuse; i += 40) {
            ctx.beginPath();
            ctx.moveTo(i, 0);
            ctx.lineTo(i, sz.hypotenuse);
            ctx.stroke();

            ctx.beginPath();
            ctx.moveTo(0, i);
            ctx.lineTo(sz.hypotenuse, i);
            ctx.stroke();
        }
        
        // Kotak biru untuk a² (4×4 = 16 kotak)
        ctx.fillStyle = '#0dcaf0';
        for (let i = 0; i < 4; i++) {
            for (let j = 0; j < 4; j++) {
                ctx.fillRect(i * 40, j * 40, 40, 40);
            }
        }
        
        // Kotak merah untuk b² (9 kotak sisanya)
        ctx.fillStyle = '#dc3545';
        // Area samping kanan (1 kolom × 5 baris)
        for (let j = 0; j < 5; j++) {
            ctx.fillRect(4 * 40, j * 40, 40, 40);
        }
        // Area bawah (4 kolom × 1 baris)
        for (let i = 0; i < 4; i++) {
            ctx.fillRect(i * 40, 4 * 40, 40, 40);
        }
        // Kotak sudut kanan bawah (1×1)
        ctx.fillRect(4 * 40, 4 * 40, 40, 40);
        
        // Outline untuk kotak-kotak kecil
        ctx.strokeStyle = '#000000';
        ctx.lineWidth = 1;
        for (let i = 0; i < 5; i++) {
            for (let j = 0; j < 5; j++) {
                ctx.strokeRect(i * 40, j * 40, 40, 40);
            }
        }
        
        ctx.restore();
    }
    
    // Update informasi berdasarkan step yang diklik
    switch(step) {
        case 1:
            info.innerHTML = 'Langkah 1: Menggambar persegi di sisi TEGAK<br>' +
                            'Ukuran: 4 satuan × 4 satuan<br>' +
                            'Luas: 4 × 4 = 16 satuan²<br>' +
                            'Warna: Biru';
            break;
        case 2:
            info.innerHTML = 'Langkah 2: Menggambar persegi di sisi DATAR<br>' +
                            'Ukuran: 3 satuan × 3 satuan<br>' +
                            'Luas: 3 × 3 = 9 satuan²<br>' +
                            'Warna: Merah';
            break;
        case 3:
            info.innerHTML = 'Langkah 3: Kedua persegi telah terpasang<br>' +
                            'Luas biru (sisi tegak): 16 satuan²<br>' +
                            'Luas merah (sisi datar): 9 satuan²<br>' +
                            'Total luas: 16 + 9 = 25 satuan²';
            break;
        case 4:
            info.innerHTML = 'Langkah 4: Melihat satuan pada persegi biru<br>' +
                            'Setiap kotak = 1 satuan²<br>' +
                            'Jumlah kotak biru: 4 × 4 = 16 satuan²<br>' +
                            'Ini adalah luas persegi di sisi tegak';
            break;
        case 5:
            info.innerHTML = 'Langkah 5: Melihat satuan pada persegi merah<br>' +
                            'Setiap kotak = 1 satuan²<br>' +
                            'Jumlah kotak merah: 3 × 3 = 9 satuan²<br>' +
                            'Ini adalah luas persegi di sisi datar';
            break;
        case 6:
            info.innerHTML = 'Langkah 6: Hubungan Sisi-Sisi Segitiga Siku-siku<br>' +
                            'Luas persegi biru: 16 satuan²<br>' +
                            'Luas persegi merah: 9 satuan²<br>' +
                            'Total: 16 + 9 = 25 satuan²<br>' +
                            'Luas persegi di sisi miring: 5 × 5 = 25 satuan²<br>' +
                            '<strong>Terbukti: a² + b² = c²</strong><br>' +
                            'Luas persegi di sisi miring = Jumlah luas persegi di sisi lainnya';
            break;
        default:
            info.innerHTML = 'Selamat datang di eksplorasi hubungan sisi segitiga siku-siku!<br>' +
                            'Klik tombol 1-6 secara berurutan untuk melihat hubungan antara persegi di setiap sisi.';
    }
    
    // Update button states
    segitiga_updateButtonStates(segitigaStep.currentStep);
}

/* ================= BUTTON STATES ================= */
function segitiga_updateButtonStates(currentStep) {
    const buttons = document.querySelectorAll('[data-page="2"] .psp-step-btn');
    const resetBtn = document.querySelector('[data-page="2"] .psp-reset-btn');
    
    buttons.forEach((btn, index) => {
        const stepNumber = index + 1;
        btn.classList.remove('active');
        
        if (stepNumber <= currentStep) {
            btn.classList.add('active');
        }
    });
    
    if (resetBtn) {
        resetBtn.classList.remove('active');
    }
}

/* ================= RESET FUNCTION ================= */
function segitiga_reset() {
    segitigaStep.currentStep = 0;
    segitiga_drawBase();
    
    const info = document.querySelector('[data-page="2"] #psp-info');
    if (info) {
        info.innerHTML = 'Selamat datang di eksplorasi hubungan sisi segitiga siku-siku!<br>' +
                        'Klik tombol 1-6 secara berurutan untuk melihat hubungan antara persegi di setiap sisi.';
    }
    
    segitiga_updateButtonStates(0);
    
    const resetBtn = document.querySelector('[data-page="2"] .psp-reset-btn');
    if (resetBtn) {
        resetBtn.classList.add('active');
        setTimeout(() => {
            resetBtn.classList.remove('active');
        }, 300);
    }
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    segitiga_init();
});

// --- FUNGSI BAGIAN 1 (Updated: Dropdown) ---

function cekSoal1() {
    let dropdown = document.getElementById('jawab1');
    let jawaban = dropdown.value;
    let feedback = document.getElementById('feedback1');
    
    // 1. Cek apakah user sudah memilih (value masih kosong/default)
    if (jawaban === "") {
        feedback.innerHTML = '<span class="text-warning">Silakan pilih jawaban yang tersedia.</span>';
        return;
    }

    // 2. Cek jawaban (Kunci Jawaban: persegiC)
    if (jawaban === 'persegiC') {
        feedback.innerHTML = '<span class="text-success fw-bold"><i class="bi bi-check-circle me-1"></i>Jawaban Kamu Benar! Persegi C yang terletak pada sisi miring (hipotenusa) memiliki luas paling besar.</span>';
    } else {
        feedback.innerHTML = '<span class="text-danger fw-bold"><i class="bi bi-x-circle me-1"></i>Jawaban Kamu Kurang Tepat. Amati lagi secara teliti, kotak mana yang ukurannya paling besar</span>';
    }
}

function cekSoal2() {
    let dropdown = document.getElementById('jawab2');
    let jawaban = dropdown.value;
    let feedback = document.getElementById('feedback2');
    
    // Cek apakah user sudah memilih
    if (jawaban === "") {
        feedback.innerHTML = '<span class="text-warning">Silakan pilih Ya atau Tidak.</span>';
        return;
    }

    // Cek jawaban
    if (jawaban === 'ya') {
        feedback.innerHTML = '<span class="text-success">Jawaban Kamu Benar! Luas persegi pada sisi miring sama dengan jumlah luas dua persegi lainnya.</span>';
    } else {
        feedback.innerHTML = '<span class="text-danger">Jawaban Kamu Kurang Tepat. Perhatikan kembali luas ketiga persegi.</span>';
    }
}

// --- FUNGSI BAGIAN 2 (TABEL - GAMBAR 3) ---

function cekTabel() {
    let feedback = document.getElementById('feedbackTabel');
    let benarSemua = true;

    // Data Kunci Jawaban [BC^2, AC^2, AB^2, AB]
    // Baris 1: 5, 12 -> 25, 144, 169, 13
    // Baris 2: 8, 15 -> 64, 225, 289, 17
    // Baris 3: 9, 12 -> 81, 144, 225, 15

    const kunci = [
        {id: ['bc_sq_1', 'ac_sq_1', 'ab_sq_1', 'ab_1'], val: [25, 144, 169, 13]},
        {id: ['bc_sq_2', 'ac_sq_2', 'ab_sq_2', 'ab_2'], val: [64, 225, 289, 17]},
        {id: ['bc_sq_3', 'ac_sq_3', 'ab_sq_3', 'ab_3'], val: [81, 144, 225, 15]}
    ];

    // Loop setiap baris untuk cek jawaban
    kunci.forEach(row => {
        row.id.forEach((fieldId, index) => {
            let inputEl = document.getElementById(fieldId);
            let userVal = parseInt(inputEl.value);
            
            if (userVal === row.val[index]) {
                inputEl.classList.remove('is-invalid');
                inputEl.classList.add('is-valid');
            } else {
                inputEl.classList.remove('is-valid');
                inputEl.classList.add('is-invalid');
                benarSemua = false;
            }
        });
    });

    if (benarSemua) {
        feedback.innerHTML = '<span class="text-success">✔ Luar biasa! Semua perhitungan tabel benar.</span>';
    } else {
        feedback.innerHTML = '<span class="text-danger">✘ Masih ada yang salah. Cek kotak yang berwarna merah.</span>';
    }
}

// --- FUNGSI BAGIAN 3 (PILIHAN GANDA - GAMBAR 3) ---
function cekKesimpulan() {
    let dropdown = document.getElementById('pilihanRumus');
    let jawaban = dropdown.value;
    let feedback = document.getElementById('feedbackKesimpulan');
    let boxKesimpulan = document.getElementById('boxKesimpulan'); // Ambil elemen box

    // Cek apakah user sudah memilih
    if (jawaban === "") {
        feedback.innerHTML = '<span class="text-warning">⚠ Silakan pilih rumus terlebih dahulu.</span>';
        boxKesimpulan.classList.add('d-none'); // Pastikan tetap tersembunyi
        return;
    }

    if (jawaban === 'benar') {
        feedback.innerHTML = '<span class="text-success">✔ Tepat sekali! Rumusnya adalah \\( BC^2 + AC^2 = AB^2 \\)</span>';
        
        // MUNCULKAN KESIMPULAN
        boxKesimpulan.classList.remove('d-none');
        // Optional: Tambahkan animasi fade-in simple jika mau
        boxKesimpulan.classList.add('fade-in'); 

    } else {
        feedback.innerHTML = '<span class="text-danger">✘ Kurang tepat. Coba perhatikan kembali tabel perhitungan kuadratnya.</span>';
        
        // SEMBUNYIKAN KEMBALI jika jawaban salah (opsional, biar user tidak bingung)
        boxKesimpulan.classList.add('d-none');
    }

    // Render ulang MathJax untuk feedback
    if (window.MathJax) {
        MathJax.typesetPromise([feedback]).then(() => {}).catch((err) => console.log(err));
    }
}

function cekJawabanPembuktian() {
    var j1 = document.getElementById('jawaban1').value;
    var j2 = document.getElementById('jawaban2').value;
    var j3 = document.getElementById('jawaban3').value;
    var feedback = document.getElementById('pesanFeedback');

    feedback.style.display = 'block';
    
    // Logika: Kiri harus c, Kanan harus a & b (bolak balik boleh)
    var sisiKiriBenar = (j1 === 'c');
    var sisiKananBenar = (j2 === 'a' && j3 === 'b') || (j2 === 'b' && j3 === 'a');

    if (sisiKiriBenar && sisiKananBenar) {
        feedback.className = "alert alert-success";
        feedback.innerHTML = "<strong>Tepat Sekali!</strong> Kesimpulannya adalah c² = a² + b² (Teorema Pythagoras).";
    } else {
        feedback.className = "alert alert-danger";
        feedback.innerHTML = "<strong>Masih keliru.</strong> Perhatikan kembali sisi miring (c) dan sisi tegaknya (a dan b).";
    }
}


function cekTabelGeoGebra() {
    // 1. Definisikan Kunci Jawaban (Berdasarkan simulasi GeoGebra umum: 3-4-5)
    // Sisi: A=3, B=4, C=5 (Hipotenusa)
    // Luas: A=9, B=16, C=25
    const kunci = {
        sisi_a: 3,
        sisi_b: 4,
        sisi_c: 5,
        luas_a: 9,
        luas_b: 16,
        luas_c: 25
    };

    // 2. Ambil elemen input
    const inputs = {
        sisi_a: document.getElementById('sisi_a'),
        sisi_b: document.getElementById('sisi_b'),
        sisi_c: document.getElementById('sisi_c'),
        luas_a: document.getElementById('luas_a'),
        luas_b: document.getElementById('luas_b'),
        luas_c: document.getElementById('luas_c')
    };

    let benarSemua = true;

    // 3. Loop untuk validasi setiap input
    for (let key in inputs) {
        let nilaiInput = parseInt(inputs[key].value);
        
        // Reset style
        inputs[key].classList.remove('is-valid', 'is-invalid');

        // Cek validitas
        if (nilaiInput === kunci[key]) {
            inputs[key].classList.add('is-valid'); // Tambah border hijau (Bootstrap)
        } else {
            inputs[key].classList.add('is-invalid'); // Tambah border merah (Bootstrap)
            benarSemua = false;
        }
    }

    // 4. Berikan Feedback Visual (Alert/Pesan)
    const feedbackBox = document.getElementById('feedbackTabelGeoGebra'); // Pastikan div ini ada di HTML Anda
    
    if (feedbackBox) {
        if (benarSemua) {
            feedbackBox.className = "mt-2 fw-bold text-success animate__animated animate__fadeIn";
            feedbackBox.innerHTML = "<i class='bi bi-check-circle-fill'></i> Luar biasa! Semua jawabanmu benar.";
        } else {
            feedbackBox.className = "mt-2 fw-bold text-danger animate__animated animate__shakeX";
            feedbackBox.innerHTML = "<i class='bi bi-exclamation-triangle-fill'></i> Masih ada yang kurang tepat. Coba perhatikan lagi kotak-kotaknya.";
        }
    } else {
        // Fallback jika div feedback belum dibuat
        if (benarSemua) alert("Benar Semua!");
        else alert("Masih ada yang salah.");
    }
}
// ==========================================
    // VALIDASI CONTOH 1 (Mencari Sisi Miring)
    // ==========================================
    function cekContoh1() {
        // Ambil Nilai Input
        let dik_ac = parseFloat(document.getElementById('c1_dik_b').value); // 4
        let dik_bc = parseFloat(document.getElementById('c1_dik_a').value); // 3
        
        let s1_a = parseFloat(document.getElementById('c1_step1_a').value);
        let s1_b = parseFloat(document.getElementById('c1_step1_b').value);
        
        let s2_a = parseFloat(document.getElementById('c1_step2_a_sq').value);
        let s2_b = parseFloat(document.getElementById('c1_step2_b_sq').value);
        
        let s3_sum = parseFloat(document.getElementById('c1_step3_sum').value);
        let s4_root = parseFloat(document.getElementById('c1_step4_root').value);
        let final = parseFloat(document.getElementById('c1_final').value);

        // --- VALIDASI BERTINGKAT ---

        // 1. Cek Diketahui
        if (dik_ac !== 4 || dik_bc !== 3) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Cek bagian "Diketahui". Jarak dinding (AC) adalah 4m dan Tinggi (BC) adalah 3m.',
                confirmButtonColor: '#d33'
            });
            return;
        }

        // 2. Cek Langkah 1 (Input Rumus) - Bisa dibolak-balik (Komutatif)
        let validStep1 = (s1_a === 4 && s1_b === 3) || (s1_a === 3 && s1_b === 4);
        if (!validStep1) {
            Swal.fire({
                icon: 'warning',
                title: 'Langkah 1 Kurang Tepat',
                text: 'Masukkan angka sisi tegak (3) dan sisi alas (4) ke dalam rumus.',
                confirmButtonColor: '#f39c12'
            });
            return;
        }

        // 3. Cek Langkah 2 (Kuadrat)
        // Pastikan kuadratnya sesuai dengan input di langkah 1
        if (s2_a !== Math.pow(s1_a, 2) || s2_b !== Math.pow(s1_b, 2)) {
            Swal.fire({
                icon: 'error',
                title: 'Perhitungan Salah',
                text: 'Coba hitung kembali hasil kuadrat/pangkat dua dari angka di atasnya.',
                confirmButtonColor: '#d33'
            });
            return;
        }

        // 4. Cek Langkah 3 (Penjumlahan)
        if (s3_sum !== 25) { // 16 + 9
            Swal.fire({
                icon: 'error',
                title: 'Penjumlahan Salah',
                text: 'Hasil penjumlahan 16 + 9 bukan segitu. Coba hitung lagi.',
                confirmButtonColor: '#d33'
            });
            return;
        }

        // 5. Cek Akar & Final
        if (s4_root !== 25) {
            Swal.fire({
                icon: 'warning',
                title: 'Cek Akar',
                text: 'Angka di dalam akar harus sama dengan hasil penjumlahan sebelumnya (25).',
                confirmButtonColor: '#f39c12'
            });
            return;
        }

        if (final !== 5) {
            Swal.fire({
                icon: 'error',
                title: 'Hasil Akhir Salah',
                text: 'Akar dari 25 berapa hayo?',
                confirmButtonColor: '#d33'
            });
            return;
        }

        // JIKA SEMUA BENAR
        Swal.fire({
            icon: 'success',
            title: 'Luar Biasa!',
            text: 'Jawaban kamu benar! Jarak yang ditempuh Ahmad adalah 5 meter.',
            confirmButtonColor: '#198754'
        });
    }

    // ==========================================
    // VALIDASI CONTOH 2 (Dua Segitiga)
    // ==========================================
    function cekContoh2() {
        // Ambil Input Diketahui
        let d_ab = parseFloat(document.getElementById('c2_dik_ab').value); // 13
        let d_ac = parseFloat(document.getElementById('c2_dik_ac').value); // 12
        let d_cd = parseFloat(document.getElementById('c2_dik_cd').value); // 3

        // Cek Diketahui
        if (d_ab !== 13 || d_ac !== 12 || d_cd !== 3) {
            Swal.fire({
                icon: 'error',
                title: 'Diketahui Salah',
                text: 'Perhatikan gambar dengan teliti untuk mengisi bagian Diketahui.',
                confirmButtonColor: '#d33'
            });
            return;
        }

        // --- STEP 1: MENCARI BC ---
        let s1_ab = parseFloat(document.getElementById('c2_step1_ab').value);
        let s1_ac = parseFloat(document.getElementById('c2_step1_ac').value);
        
        let s1_r1 = parseFloat(document.getElementById('c2_step1_res1').value); // 169
        let s1_r2 = parseFloat(document.getElementById('c2_step1_res2').value); // 144
        let s1_sq = parseFloat(document.getElementById('c2_step1_sqrt').value); // 25
        let bc_res = parseFloat(document.getElementById('c2_bc_result').value); // 5

        // Validasi Step 1
        if (s1_ab !== 13 || s1_ac !== 12) {
            Swal.fire({
                icon: 'warning',
                title: 'Langkah 1 Keliru',
                text: 'Untuk mencari BC, masukkan Sisi Miring (13) dikurang Sisi Alas (12).',
                confirmButtonColor: '#f39c12'
            });
            return;
        }
        if (s1_r1 !== 169 || s1_r2 !== 144) {
            Swal.fire({
                icon: 'error',
                title: 'Hitungan Kuadrat Salah',
                text: 'Cek kembali hasil kuadrat dari 13 dan 12.',
                confirmButtonColor: '#d33'
            });
            return;
        }
        if (s1_sq !== 25) {
             Swal.fire({
                icon: 'error',
                title: 'Pengurangan Salah',
                text: 'Hasil 169 - 144 salah. Coba hitung lagi.',
                confirmButtonColor: '#d33'
            });
            return;
        }
        if (bc_res !== 5) {
            Swal.fire({
                icon: 'error',
                title: 'Akar Salah',
                text: 'Akar dari 25 adalah 5.',
                confirmButtonColor: '#d33'
            });
            return;
        }

        // --- STEP 2: MENCARI BD ---
        let s2_bc = parseFloat(document.getElementById('c2_step2_bc').value); // 5
        let s2_cd = parseFloat(document.getElementById('c2_step2_cd').value); // 3
        
        let s2_r1 = parseFloat(document.getElementById('c2_step2_res1').value); // 25
        let s2_r2 = parseFloat(document.getElementById('c2_step2_res2').value); // 9
        let s2_sq = parseFloat(document.getElementById('c2_step2_sqrt').value); // 16
        let final = parseFloat(document.getElementById('c2_final').value); // 4

        // Validasi Step 2
        if (s2_bc !== 5 || s2_cd !== 3) {
            Swal.fire({
                icon: 'warning',
                title: 'Langkah 2 Keliru',
                text: 'Gunakan hasil BC (5) yang baru didapat, dan sisi CD (3).',
                confirmButtonColor: '#f39c12'
            });
            return;
        }
        if (s2_r1 !== 25 || s2_r2 !== 9) {
             Swal.fire({
                icon: 'error',
                title: 'Kuadrat Salah',
                text: 'Cek hasil kuadrat 5 dan 3.',
                confirmButtonColor: '#d33'
            });
            return;
        }
        if (s2_sq !== 16) {
             Swal.fire({
                icon: 'error',
                title: 'Pengurangan Salah',
                text: 'Hasil 25 - 9 bukan segitu.',
                confirmButtonColor: '#d33'
            });
            return;
        }
        if (final !== 4) {
            Swal.fire({
                icon: 'error',
                title: 'Hasil Akhir Salah',
                text: 'Akar dari 16 adalah 4.',
                confirmButtonColor: '#d33'
            });
            return;
        }

        // JIKA SEMUA BENAR
        Swal.fire({
            icon: 'success',
            title: 'Kerja Bagus!',
            text: 'Kamu berhasil menyelesaikan soal bertingkat ini dengan benar.',
            confirmButtonColor: '#198754'
        });
    }

/* ===============================
   HALAMAN 4 – FUNGSI (PYTHAGORAS STEP PROOF)
================================ */
function initPage3() {
    // Inisialisasi canvas Pythagoras proof
    psp_init();
    
    // Inisialisasi drag & drop Pythagoras
    initDragDropPythagoras();
    
    // Tambahkan event listener untuk tombol Pythagoras
    const pspButtons = document.querySelectorAll('[data-page="3"] .psp-step-btn');
    const pspResetBtn = document.querySelector('[data-page="3"] .psp-reset-btn');
    
    pspButtons.forEach(btn => {
        btn.onclick = function() {
            const step = parseInt(this.textContent);
            psp_goStep(step);
        };
    });
    
    if (pspResetBtn) {
        pspResetBtn.onclick = psp_reset;
    }
}

function initDragDropPythagoras() {
    // Cek apakah elemen ini ada di halaman. Jika tidak, hentikan fungsi.
    const container = document.getElementById('pyth-latihan-container');
    if (!container) return;

    // 1. Definisikan Kunci Jawaban
    const correctAnswers = {
        '1': '8',
        '2': '13',
        '3': '25',
        '4': '29',
        '5': '24'
    };

    // State untuk menyimpan jawaban user
    let userAnswers = {};
    let draggedValue = null;

    // --- A. SETUP DRAGGABLE ITEMS (YANG DIGESER) ---
    // Selector diperbarui ke .pyth-drag-item
    const draggables = container.querySelectorAll('.pyth-drag-item');
    
    draggables.forEach(item => {
        item.addEventListener('dragstart', function(e) {
            draggedValue = this.getAttribute('data-value');
            e.dataTransfer.setData('text/plain', draggedValue);
            e.dataTransfer.effectAllowed = 'copy';
            this.style.opacity = '0.4';
        });

        item.addEventListener('dragend', function() {
            this.style.opacity = '1';
            draggedValue = null;
            // Hapus efek hover dari drop zone (selector diperbarui)
            container.querySelectorAll('.pyth-drop-zone').forEach(z => z.classList.remove('drag-over'));
        });
    });

    // --- B. SETUP DROP ZONES (TEMPAT JATUH) ---
    // Selector diperbarui ke .pyth-drop-zone
    const dropZones = container.querySelectorAll('.pyth-drop-zone');

    dropZones.forEach(zone => {
        zone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('drag-over');
            return false;
        });

        zone.addEventListener('dragenter', function(e) {
            e.preventDefault();
            this.classList.add('drag-over');
        });

        zone.addEventListener('dragleave', function() {
            this.classList.remove('drag-over');
        });

        zone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('drag-over');

            const val = e.dataTransfer.getData('text/plain');
            const soalId = this.getAttribute('data-soal');

            if (val && soalId) {
                userAnswers[soalId] = val;

                // Update Tampilan (Class diperbarui)
                this.innerHTML = `<span class="fs-4 fw-bold text-primary">${val}</span>`;
                this.classList.add('filled');
                
                // Reset warna
                this.classList.remove('correct', 'wrong');
            }
        });
    });

    // --- C. LOGIKA TOMBOL PERIKSA ---
    // ID tombol diperbarui
    const btnPeriksa = document.getElementById('btn-pyth-check');
    if (btnPeriksa) {
        btnPeriksa.addEventListener('click', function() {
            let correctCount = 0;
            const totalSoal = 4;
            
            const answeredCount = Object.keys(userAnswers).length;
            if (answeredCount < totalSoal) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Belum Lengkap',
                    text: 'Silakan isi semua kotak jawaban terlebih dahulu!',
                    confirmButtonColor: '#ffc107'
                });
                return;
            }

            for (let id = 1; id <= totalSoal; id++) {
                // Selector diperbarui
                const zone = container.querySelector(`.pyth-drop-zone[data-soal="${id}"]`);
                
                if (zone) {
                    const userVal = userAnswers[id];
                    const correctVal = correctAnswers[id];

                    zone.classList.remove('correct', 'wrong');

                    if (userVal === correctVal) {
                        zone.classList.add('correct');
                        correctCount++;
                    } else {
                        zone.classList.add('wrong');
                    }
                }
            }

            if (correctCount === totalSoal) {
                Swal.fire({
                    icon: 'success',
                    title: 'Luar Biasa!',
                    text: 'Semua perhitungan Pythagoras Anda benar.',
                    confirmButtonText: 'Selesai',
                    confirmButtonColor: '#198754'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Masih Ada Kesalahan',
                    text: `${totalSoal - correctCount} jawaban masih kurang tepat. Coba hitung lagi!`,
                    confirmButtonText: 'Coba Lagi',
                    confirmButtonColor: '#dc3545'
                });
            }
        });
    }

    // --- D. LOGIKA TOMBOL RESET ---
    // ID tombol diperbarui
    const btnReset = document.getElementById('btn-pyth-reset');
    if (btnReset) {
        btnReset.addEventListener('click', function() {
            userAnswers = {};
            // Selector diperbarui
            container.querySelectorAll('.pyth-drop-zone').forEach(zone => {
                zone.innerHTML = '<span class="placeholder-text">?</span>';
                zone.classList.remove('filled', 'correct', 'wrong');
            });
        });
    }
}



// Variabel untuk menyimpan jumlah percobaan
let tableAttempts = 0;
let questionAttempts = 0;
const maxAttempts = 3;

// Jawaban yang benar untuk tabel
const correctTableAnswers = {
    'abc-sudut': 'B',
    'abc-tegak': 'AB',
    'abc-mendatar': 'BC',
    'bac-sudut': 'A',
    'bac-mendatar': 'AB',
    'bac-miring': 'BC'
};

const correctQuestionAnswers = {
    q1: 'q1c',
    q2: 'q2a',
    q3: 'q3c'
};

// Fungsi Periksa Jawaban Tabel
function checkTableAnswers() {
    // Cek apakah ada input yang kosong
    const inputs = document.querySelectorAll('.table-input');
    let emptyInputs = [];
    
    inputs.forEach(input => {
        if (input.value.trim() === '') {
            emptyInputs.push(input);
        }
    });
    
    // Jika ada input yang kosong
    if (emptyInputs.length > 0) {
        Swal.fire({
            title: 'Masih Kosong',
            text: `Masih ada ${emptyInputs.length} kolom yang belum diisi.`,
            icon: 'warning',
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#ffc107'
        });
        
        // Highlight input yang kosong
        emptyInputs.forEach(input => {
            input.classList.add('is-invalid');
        });
        
        return; // Stop fungsi, tidak dihitung sebagai percobaan
    }
    
    // Reset highlight jika ada yang kosong sebelumnya
    inputs.forEach(input => {
        input.classList.remove('is-invalid');
    });
    
    // Lanjutkan validasi
    tableAttempts++;
    const remainingAttempts = maxAttempts - tableAttempts;
    
    // Reset semua input ke normal
    inputs.forEach(input => {
        input.classList.remove('is-valid', 'is-invalid');
    });
    
    // Hitung jawaban benar
    let correctCount = 0;
    let allCorrect = true;
    
    inputs.forEach(input => {
        const key = `${input.dataset.row}-${input.dataset.col}`;
        const userAnswer = input.value.trim().toUpperCase();
        const correctAnswer = correctTableAnswers[key].toUpperCase();
        
        if (userAnswer === correctAnswer) {
            input.classList.add('is-valid');
            correctCount++;
        } else {
            input.classList.add('is-invalid');
            allCorrect = false;
        }
    });
    
    // Update info percobaan
    document.getElementById('table-attempt-info').innerHTML = 
        `Percobaan ke-${tableAttempts} dari ${maxAttempts} kesempatan`;
    
    // Tampilkan SweetAlert berdasarkan hasil
    if (allCorrect) {
        // Semua jawaban benar
        Swal.fire({
            title: 'Bagus Sekali!',
            text: `Semua jawaban tabel benar! (${correctCount}/${inputs.length})`,
            icon: 'success',
            confirmButtonText: 'Lanjutkan',
            confirmButtonColor: '#28a745'
        });
    } else if (tableAttempts >= maxAttempts) {
        // Sudah 3 kali salah
        Swal.fire({
            title: 'Perlu Bantuan?',
            html: `Kesempatan mencoba sudah habis.<br>
                  <button class="btn btn-info btn-sm mt-2" onclick="showTableAnswers()">
                      Tampilkan Jawaban
                  </button>`,
            icon: 'info',
            showConfirmButton: false,
            showCloseButton: true
        });
    } else {
        // Masih ada kesempatan
        Swal.fire({
            title: 'Masih Ada yang Salah',
            text: `Sisa ${remainingAttempts} kesempatan.`,
            icon: 'warning',
            confirmButtonText: 'Coba Lagi',
            confirmButtonColor: '#ffc107'
        });
    }
}

// Fungsi Tampilkan Jawaban Tabel
function showTableAnswers() {
    Swal.close(); // Tutup alert sebelumnya
    
    // Isi semua jawaban yang benar
    document.querySelectorAll('.table-input').forEach(input => {
        const key = `${input.dataset.row}-${input.dataset.col}`;
        input.value = correctTableAnswers[key];
        input.classList.add('is-valid');
        input.disabled = true; // Nonaktifkan input
    });
    
    Swal.fire({
        title: 'Jawaban Tabel',
        text: 'Semua jawaban telah ditampilkan.',
        icon: 'info',
        confirmButtonText: 'Mengerti',
        confirmButtonColor: '#17a2b8'
    });
}

// Fungsi Periksa Jawaban Pertanyaan
function checkQuestionAnswers() {
    // Cek apakah semua pertanyaan sudah dijawab
    let unansweredQuestions = [];
    
    for (let i = 1; i <= 3; i++) {
        const selected = document.querySelector(`input[name="q${i}"]:checked`);
        if (!selected) {
            unansweredQuestions.push(i);
        }
    }
    
    // Jika ada pertanyaan yang belum dijawab
    if (unansweredQuestions.length > 0) {
        Swal.fire({
            title: 'Belum Lengkap',
            text: `Masih ada ${unansweredQuestions.length} pertanyaan yang belum dijawab.`,
            icon: 'warning',
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#ffc107'
        });
        
        return; // Stop fungsi, tidak dihitung sebagai percobaan
    }
    
    // Lanjutkan validasi
    questionAttempts++;
    const remainingAttempts = maxAttempts - questionAttempts;
    
    // Reset styling
    document.querySelectorAll('.form-check').forEach(div => {
        div.classList.remove('text-success', 'text-danger', 'fw-bold');
    });
    
    // Hitung jawaban benar
    let correctCount = 0;
    let allCorrect = true;
    
    for (let i = 1; i <= 3; i++) {
        const questionName = 'q' + i;
        const selected = document.querySelector(`input[name="${questionName}"]:checked`);
        const correctId = correctQuestionAnswers[questionName];
        
        if (selected && selected.id === correctId) {
            correctCount++;
        } else {
            allCorrect = false;
        }
    }
    
    // Update info percobaan
    document.getElementById('question-attempt-info').innerHTML = 
        `Percobaan ke-${questionAttempts} dari ${maxAttempts} kesempatan`;
    
    // Tampilkan SweetAlert berdasarkan hasil
    if (allCorrect) {
        // Semua jawaban benar
        Swal.fire({
            title: 'Hebat!',
            text: `Semua jawaban pertanyaan benar! (${correctCount}/3)`,
            icon: 'success',
            confirmButtonText: 'Lanjutkan',
            confirmButtonColor: '#28a745'
        });
        
        // Tandai jawaban yang benar
        for (let i = 1; i <= 3; i++) {
            const questionName = 'q' + i;
            const correctId = correctQuestionAnswers[questionName];
            const correctElement = document.getElementById(correctId);
            if (correctElement) {
                correctElement.parentElement.classList.add('text-success', 'fw-bold');
            }
        }
        
    } else if (questionAttempts >= maxAttempts) {
        // Sudah 3 kali salah
        Swal.fire({
            title: 'Perlu Bantuan?',
            html: `Kesempatan mencoba sudah habis.<br>
                  <button class="btn btn-info btn-sm mt-2" onclick="showQuestionAnswers()">
                      Tampilkan Jawaban
                  </button>`,
            icon: 'info',
            showConfirmButton: false,
            showCloseButton: true
        });
    } else {
        // Masih ada kesempatan
        Swal.fire({
            title: 'Masih Ada yang Salah',
            text: `Sisa ${remainingAttempts} kesempatan.`,
            icon: 'warning',
            confirmButtonText: 'Coba Lagi',
            confirmButtonColor: '#ffc107'
        });
    }
}

// Fungsi Tampilkan Jawaban Pertanyaan
function showQuestionAnswers() {
    Swal.close(); // Tutup alert sebelumnya
    
    // Tandai semua jawaban yang benar
    for (let i = 1; i <= 3; i++) {
        const questionName = 'q' + i;
        const correctId = correctQuestionAnswers[questionName];
        const correctElement = document.getElementById(correctId);
        
        if (correctElement) {
            correctElement.checked = true;
            correctElement.parentElement.classList.add('text-success', 'fw-bold');
            correctElement.disabled = true; // Nonaktifkan radio button
        }
    }
    
    // Nonaktifkan semua radio button yang salah
    for (let i = 1; i <= 3; i++) {
        const radios = document.querySelectorAll(`input[name="q${i}"]`);
        radios.forEach(radio => {
            const correctId = correctQuestionAnswers[`q${i}`];
            if (radio.id !== correctId) {
                radio.disabled = true;
            }
        });
    }
    
    Swal.fire({
        title: 'Jawaban Pertanyaan',
        text: 'Semua jawaban telah ditampilkan.',
        icon: 'info',
        confirmButtonText: 'Mengerti',
        confirmButtonColor: '#17a2b8'
    });
}

// CSS untuk styling
const style = document.createElement('style');
style.textContent = `
    .table-input.is-valid {
        border-color: #28a745;
        background-color: #f8fff9;
    }
    
    .table-input.is-invalid {
        border-color: #dc3545;
        background-color: #fff8f8;
    }
    
    #table-attempt-info, #question-attempt-info {
        font-size: 0.9rem;
    }
    
    .form-check-label.text-success {
        color: #28a745 !important;
        font-weight: bold;
    }
`;
document.head.appendChild(style);


function cekRefleksi() {

    /* =========================
       REFLEKSI 1 (YA / TIDAK)
    ========================== */
    const opsi1 = document.querySelector('input[name="ref1_opsi"]:checked');
    const teks1 = document.getElementById("ref1_text").value.toLowerCase();
    const fb1 = document.getElementById("fb1");

    const kunci1 = ["kuadrat", "pangkat", "akar", "luas", "persegi"];

    if (!opsi1) {
        fb1.innerHTML = "⚠️ Silakan pilih Ya atau Tidak terlebih dahulu.";
        fb1.className = "feedback mt-2 small text-warning";
    } else if (opsi1.value === "ya" && kunci1.some(k => teks1.includes(k))) {
        fb1.innerHTML = "✅ Jawabanmu tepat. Kamu sudah memahami bahwa Teorema Pythagoras dibangun dari hubungan kuadrat sisi.";
        fb1.className = "feedback mt-2 small text-success";
    } else if (opsi1.value === "ya") {
        fb1.innerHTML = "🔍 Pilihanmu sudah benar, coba perjelas kaitannya dengan kuadrat atau luas persegi.";
        fb1.className = "feedback mt-2 small text-primary";
    } else {
        fb1.innerHTML = "❌ Pilihanmu masih kurang tepat. Coba perhatikan kembali hubungan kuadrat sisi pada segitiga siku-siku.";
        fb1.className = "feedback mt-2 small text-danger";
    }

    /* =========================
       REFLEKSI 2
    ========================== */
    cekUmum(
        "ref2",
        ["hipotenusa", "jumlah", "kuadrat"],
        "fb2",
        "Hubungan sisi-sisi segitiga siku-siku sudah kamu pahami dengan baik."
    );

    /* =========================
       REFLEKSI 3
    ========================== */
    cekUmum(
        "ref3",
        ["kuadrat", "jumlah", "akar"],
        "fb3",
        "Langkah-langkah yang kamu tuliskan sudah sesuai dengan Teorema Pythagoras."
    );
}

/* FUNGSI UMUM */
function cekUmum(idInput, keywords, idFb, pesanBenar) {
    const teks = document.getElementById(idInput).value.toLowerCase();
    const fb = document.getElementById(idFb);

    if (teks.trim() === "") {
        fb.innerHTML = "⚠️ Silakan isi jawaban terlebih dahulu.";
        fb.className = "feedback mt-2 small text-warning";
    } else if (keywords.some(k => teks.includes(k))) {
        fb.innerHTML = "✅ " + pesanBenar;
        fb.className = "feedback mt-2 small text-success";
    } else {
        fb.innerHTML = "🔍 Jawabanmu sudah mengarah, coba hubungkan lebih jelas dengan konsep Pythagoras.";
        fb.className = "feedback mt-2 small text-primary";
    }
}

function toggleJawaban() {
    document.getElementById("kunciJawaban").classList.toggle("d-none");
}



/* ===============================
   JS Tripel
================================ */
function cekTripel() {
    const inputs = document.querySelectorAll('.tripel-input');
    let benar = 0;

    inputs.forEach(input => {
        const jawaban = input.value;
        const kunci = input.dataset.answer;

        input.classList.remove('is-valid', 'is-invalid');

        if (jawaban === '') return;

        if (jawaban === kunci) {
            input.classList.add('is-valid');
            benar++;
        } else {
            input.classList.add('is-invalid');
        }
    });

    const feedback = document.getElementById('feedbackTripel');

    if (benar === inputs.length) {
        feedback.className = 'text-success';
        feedback.innerHTML = '✔ Semua jawaban benar. Kamu sudah memahami Tripel Pythagoras!';
    } else {
        feedback.className = 'text-danger';
        feedback.innerHTML = '✘ Masih ada jawaban yang kurang tepat. Coba periksa kembali.';
    }
}


// ========== FUNGSI UNTUK INTERAKTIF TEKS ==========

// Fungsi untuk menampilkan teks tertentu
// ========== FUNGSI UNTUK INTERAKTIF TEKS (DIPERBAIKI) ==========

// Fungsi untuk menampilkan teks tertentu
function showText(textId) {
    // BAGIAN YANG DIHAPUS: hideAllText(); -> Agar label sebelumnya tidak hilang
    // BAGIAN YANG DIHAPUS: hideAllSegText(); 
    
    // Tampilkan teks yang dipilih
    const textElement = document.getElementById(textId);
    
    if (textElement) {
        // Cek jika sudah aktif, tidak perlu animasi ulang (opsional)
        // Tapi kita paksa add class active agar tetap muncul
        textElement.classList.add('active');
        
        // Reset animasi agar bisa play ulang jika diperlukan, 
        // atau biarkan 'forwards' agar posisi terkunci di akhir animasi
        textElement.style.animation = 'none';
        textElement.offsetHeight; /* trigger reflow */
        
        // Jalankan animasi muncul sesuai ID-nya (logic CSS tetap jalan)
        if(textId === 'text-tegak') {
             textElement.style.animation = 'tegakMove 0.5s ease forwards';
        } else if (textId === 'text-datar') {
             textElement.style.animation = 'datarMove 0.5s ease forwards';
        } else if (textId === 'text-miring') {
             textElement.style.animation = 'miringMove 0.5s ease forwards';
        } else {
             // Fallback animasi umum
             textElement.style.animation = 'popIn 0.5s ease forwards';
        }
        
        // Update status tombol (Opsional: agar tombol teks berubah warna)
        const correspondingBtn = document.querySelector(`.clickable-text[onclick="showText('${textId}')"]`);
        if (correspondingBtn) {
            // Kita tidak perlu menghapus class active dari tombol lain
            correspondingBtn.classList.add('active-text-clicked'); 
        }
        
        // BAGIAN YANG DIHAPUS: setTimeout(...) 
        // Penghapusan setTimeout membuat teks TIDAK hilang otomatis setelah 5 detik.
    }
}

// Fungsi untuk menyembunyikan semua teks pada gambar jembatan
function hideAllText() {
    const textElements = document.querySelectorAll('.text-tegak, .text-datar, .text-miring');
    textElements.forEach(element => {
        element.classList.remove('active');
        element.style.animation = 'fadeOut 0.3s ease forwards';
    });
    
    document.querySelectorAll('.interactive-btn[data-target^="text-"]').forEach(btn => {
        btn.classList.remove('active');
    });
}

// ============================================================
// GANTI BAGIAN PALING BAWAH (LOGIKA CEK JAWABAN JEMBATAN)
// ============================================================

function showPart(id) {
    const target = document.getElementById(id);
    if (!target) return;

    // JANGAN hapus overlay yang sudah aktif
    target.classList.add('active');
}

function resetHighlight() {
    document.querySelectorAll('.overlay-text')
        .forEach(el => el.classList.remove('active'));

    const feedback = document.getElementById('feedbackPesan');
    if (feedback) feedback.innerHTML = '';
}

function cekJawabanSegitigaSikuSiku() {
    const input = document.getElementById('inputJawaban');
    const feedback = document.getElementById('feedbackPesan');
    const jawaban = input.value;
    
    // Ambil elemen kotak penjelasan
    const penjelasanBox = document.getElementById('penjelasan-pythagoras'); 

    // Reset feedback
    feedback.className = 'fw-bold text-center mt-3';

    if (jawaban === '') {
        feedback.classList.add('text-warning');
        feedback.innerHTML = 'Silakan pilih jenis segitiga terlebih dahulu.';
        
        // Pastikan penjelasan tetap sembunyi
        penjelasanBox.classList.add('d-none'); 
        
    } else if (jawaban === 'siku-siku') {
        feedback.classList.add('text-success');
        feedback.innerHTML = 'Tepat Sekali! Segitiga yang terbentuk adalah segitiga siku-siku.';
        
        // MUNCULKAN bagian penjelasan pythagoras!
        penjelasanBox.classList.remove('d-none');
        
        // (Opsional) Scroll layar sedikit ke bawah agar siswa langsung melihat penjelasan baru
        setTimeout(() => {
            penjelasanBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }, 300);

    } else {
        feedback.classList.add('text-danger');
        feedback.innerHTML = 'Kurang tepat. Coba perhatikan kembali setiap sudut yang ada pada segitiga.';
        
        // Pastikan penjelasan tetap sembunyi jika salah
        penjelasanBox.classList.add('d-none'); 
    }
}



// Fungsi agar tombol Enter di keyboard juga bisa dipakai
function handleEnter(e) {
    if (e.key === "Enter") {
        cekJawabanSegitigaSikuSiku();
    }
}




// ============================================================
// SUBBAB 2
// ============================================================

// Variabel untuk menyimpan jawaban
const jawaban = {
    tabel: {
        '3,2': { c: 13, a: 5, b: 12 },
        '4,1': { c: 17, a: 15, b: 8 },
        '4,2': { c: 20, a: 12, b: 16 }
    },
    latihan1: {
        'a': 'ya',   // 6,8,10 adalah tripel
        'b': 'tidak', // 7,12,14 bukan tripel
        'c': 'ya',   // 8,15,17 adalah tripel
        'd': 'tidak', // 9,10,13 bukan tripel
        'e': 'ya'    // 10,24,26 adalah tripel
    },
    latihan2: 'A', // 7,24,25 adalah tripel
    latihan3: {
        c2: 225,
        a2: 144,
        b2: 81,
        c2_val: 225,
        a2_val: 144,
        b2_val: 81,
        jenis: 'siku' // 9² + 12² = 81 + 144 = 225 = 15²
    },
    latihan4: 'C', // 6,8,10 adalah tripel
    latihan5: 'D'  // 7,14,17 membentuk segitiga tumpul (17² > 7² + 14²)
};


// Fungsi untuk cek baris tabel
function cekBaris(p, q) {
    const key = `${p},${q}`;
    const jawabanBenar = jawaban.tabel[key];
    
    const inputC = document.getElementById(`p${p}q${q}_c`);
    const inputA = document.getElementById(`p${p}q${q}_a`);
    const inputB = document.getElementById(`p${p}q${q}_b`);
    
    const benarC = parseInt(inputC.value) === jawabanBenar.c;
    const benarA = parseInt(inputA.value) === jawabanBenar.a;
    const benarB = parseInt(inputB.value) === jawabanBenar.b;
    
    if (benarC && benarA && benarB) {
        inputC.classList.remove('is-invalid');
        inputA.classList.remove('is-invalid');
        inputB.classList.remove('is-invalid');
        inputC.classList.add('is-valid');
        inputA.classList.add('is-valid');
        inputB.classList.add('is-valid');
        Swal.fire('Benar!', `Jawaban untuk p=${p}, q=${q} sudah tepat!`, 'success');
    } else {
        inputC.classList.remove('is-valid');
        inputA.classList.remove('is-valid');
        inputB.classList.remove('is-valid');
        inputC.classList.add('is-invalid');
        inputA.classList.add('is-invalid');
        inputB.classList.add('is-invalid');
        Swal.fire('Perbaiki', 'Beberapa jawaban belum tepat. Coba lagi!', 'error');
    }
}

// Fungsi cek semua baris tabel
function cekSemua() {
    let semuaBenar = true;
    
    for (const key in jawaban.tabel) {
        const [p, q] = key.split(',');
        const jawabanBenar = jawaban.tabel[key];
        
        const inputC = document.getElementById(`p${p}q${q}_c`);
        const inputA = document.getElementById(`p${p}q${q}_a`);
        const inputB = document.getElementById(`p${p}q${q}_b`);
        
        if (parseInt(inputC.value) !== jawabanBenar.c || 
            parseInt(inputA.value) !== jawabanBenar.a || 
            parseInt(inputB.value) !== jawabanBenar.b) {
            semuaBenar = false;
        }
    }
    
    if (semuaBenar) {
        Swal.fire('Sempurna!', 'Semua jawaban tabel sudah benar!', 'success');
    } else {
        Swal.fire('Periksa Kembali', 'Masih ada jawaban yang kurang tepat.', 'warning');
    }
}

// Fungsi reset tabel
function resetTabel() {
    document.querySelectorAll('#tripelTable input').forEach(input => {
        input.value = '';
        input.classList.remove('is-valid', 'is-invalid');
    });
}

// Fungsi cek latihan 1
function cekLatihan1() {
    let benar = 0;
    let total = 5;
    
    for (const soal in jawaban.latihan1) {
        const select = document.getElementById(`soal1${soal}`);
        if (select.value === jawaban.latihan1[soal]) {
            select.classList.remove('is-invalid');
            select.classList.add('is-valid');
            benar++;
        } else {
            select.classList.remove('is-valid');
            select.classList.add('is-invalid');
        }
    }
    
    const hasil = document.getElementById('hasilLatihan1');
    hasil.innerHTML = `<div class="alert alert-${benar === total ? 'success' : 'warning'}">
        <strong>${benar} dari ${total} benar</strong>
    </div>`;
}

// Fungsi cek latihan 2
function cekLatihan2() {
    const selected = document.querySelector('input[name="soal2"]:checked');
    const hasil = document.getElementById('hasilLatihan2');
    
    if (!selected) {
        hasil.innerHTML = '<div class="alert alert-warning">Pilih jawaban terlebih dahulu!</div>';
        return;
    }
    
    if (selected.value === jawaban.latihan2) {
        hasil.innerHTML = '<div class="alert alert-success"><strong>Benar!</strong> 7, 24, 25 adalah Tripel Pythagoras (7² + 24² = 49 + 576 = 625 = 25²)</div>';
    } else {
        hasil.innerHTML = '<div class="alert alert-danger"><strong>Belum tepat.</strong> Coba hitung kembali!</div>';
    }
}

// Fungsi cek latihan 3
function cekLatihan3() {
    const jawabanUser = {
        c2: parseInt(document.getElementById('soal3_c2').value) || 0,
        a2: parseInt(document.getElementById('soal3_a2').value) || 0,
        b2: parseInt(document.getElementById('soal3_b2').value) || 0,
        c2_val: parseInt(document.getElementById('soal3_c2_val').value) || 0,
        a2_val: parseInt(document.getElementById('soal3_a2_val').value) || 0,
        b2_val: parseInt(document.getElementById('soal3_b2_val').value) || 0,
        jenis: document.getElementById('soal3_jenis').value
    };
    
    const jawabanBenar = jawaban.latihan3;
    let benar = true;
    
    // Cek setiap field
    for (const key in jawabanUser) {
        const input = document.getElementById(`soal3_${key}`);
        if (key === 'jenis') {
            if (jawabanUser[key] !== jawabanBenar[key]) {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                benar = false;
            } else {
                input.classList.add('is-valid');
                input.classList.remove('is-invalid');
            }
        } else {
            if (jawabanUser[key] !== jawabanBenar[key]) {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                benar = false;
            } else {
                input.classList.add('is-valid');
                input.classList.remove('is-invalid');
            }
        }
    }
    
    const hasil = document.getElementById('hasilLatihan3');
    if (benar) {
        hasil.innerHTML = '<div class="alert alert-success"><strong>Benar!</strong> 9² + 12² = 81 + 144 = 225 = 15², jadi segitiga siku-siku</div>';
    } else {
        hasil.innerHTML = '<div class="alert alert-danger"><strong>Masih ada kesalahan.</strong> Periksa kembali perhitunganmu!</div>';
    }
}

// Fungsi cek latihan 4 dan 5
function cekLatihan45() {
    const soal4 = document.querySelector('input[name="soal4"]:checked');
    const soal5 = document.querySelector('input[name="soal5"]:checked');
    const hasil = document.getElementById('hasilLatihan45');
    
    if (!soal4 || !soal5) {
        hasil.innerHTML = '<div class="alert alert-warning">Jawab semua soal terlebih dahulu!</div>';
        return;
    }
    
    const benar4 = soal4.value === jawaban.latihan4;
    const benar5 = soal5.value === jawaban.latihan5;
    
    // Update tampilan
    document.querySelectorAll('input[name="soal4"]').forEach(radio => {
        radio.parentElement.classList.remove('text-success', 'text-danger');
        if (radio.value === jawaban.latihan4) {
            radio.parentElement.classList.add('text-success', 'fw-bold');
        }
    });
    
    document.querySelectorAll('input[name="soal5"]').forEach(radio => {
        radio.parentElement.classList.remove('text-success', 'text-danger');
        if (radio.value === jawaban.latihan5) {
            radio.parentElement.classList.add('text-success', 'fw-bold');
        }
    });
    
    if (benar4 && benar5) {
        hasil.innerHTML = '<div class="alert alert-success"><strong>Sempurna!</strong> Kedua jawaban benar!</div>';
    } else {
        hasil.innerHTML = `<div class="alert alert-warning">
            <strong>Hasil:</strong><br>
            Soal 4: ${benar4 ? 'Benar' : 'Salah'} (Jawaban: C. 6, 8, dan 10)<br>
            Soal 5: ${benar5 ? 'Benar' : 'Salah'} (Jawaban: D. Tumpul)
        </div>`;
    }
}

// Fungsi evaluasi semua
function evaluasiSemua() {
    Swal.fire({
        title: 'Evaluasi Selesai!',
        html: `
            <div class="text-start">
                <p>Anda telah menyelesaikan latihan Tripel Pythagoras.</p>
                <p><strong>Ringkasan Materi:</strong></p>
                <ul>
                    <li>Tripel Pythagoras adalah tiga bilangan bulat positif yang memenuhi a² + b² = c²</li>
                    <li>Dapat dihitung dengan rumus: p²+q², p²-q², 2pq (dengan p>q)</li>
                    <li>Dapat menentukan jenis segitiga dengan membandingkan c² dengan a²+b²</li>
                </ul>
            </div>
        `,
        icon: 'success',
        confirmButtonText: 'Mengerti'
    });
}

// Inisialisasi pagination dan event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Navigasi dengan tombol pagination atas
    document.querySelectorAll('.page-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const page = parseInt(this.getAttribute('data-page'));
            navigateToPage(page);
        });
    });
    
    // Navigasi dengan tombol pagination bawah
    document.querySelectorAll('.page-btn-bottom').forEach(btn => {
        btn.addEventListener('click', function() {
            const page = parseInt(this.getAttribute('data-page'));
            navigateToPage(page);
        });
    });
    
    // Tombol next
    document.getElementById('nextPage').addEventListener('click', function() {
        const currentPage = parseInt(document.querySelector('.page-item.active .page-btn').getAttribute('data-page'));
        if (currentPage < 4) navigateToPage(currentPage + 1);
    });
    
    document.getElementById('nextPageBottom').addEventListener('click', function() {
        const currentPage = parseInt(document.querySelector('.page-item.active .page-btn-bottom').getAttribute('data-page'));
        if (currentPage < 4) navigateToPage(currentPage + 1);
    });
    
    // Tombol previous
    document.getElementById('prevPage').addEventListener('click', function() {
        const currentPage = parseInt(document.querySelector('.page-item.active .page-btn').getAttribute('data-page'));
        if (currentPage > 0) navigateToPage(currentPage - 1);
    });
    
    document.getElementById('prevPageBottom').addEventListener('click', function() {
        const currentPage = parseInt(document.querySelector('.page-item.active .page-btn-bottom').getAttribute('data-page'));
        if (currentPage > 0) navigateToPage(currentPage - 1);
    });
    
    // Auto-fill contoh soal 3 untuk memudahkan
    document.getElementById('soal3_c2').value = 225;
    document.getElementById('soal3_a2').value = 81;
    document.getElementById('soal3_b2').value = 144;
    document.getElementById('soal3_c2_val').value = 225;
    document.getElementById('soal3_a2_val').value = 81;
    document.getElementById('soal3_b2_val').value = 144;
});


function cekSemuaRumus() {
    const konfigurasi = {
        A: { utama: 'a', lain: ['b','c'] },
        B: { utama: 'b', lain: ['a','c'] },
        C: { utama: 'c', lain: ['a','b'] }
    };

    // =========================
    // TAHAP 1: CEK KELENGKAPAN
    // =========================
    for (const tipe in konfigurasi) {
        const v1 = document.getElementById(`rumus${tipe}_1`).value;
        const v2 = document.getElementById(`rumus${tipe}_2`).value;
        const v3 = document.getElementById(`rumus${tipe}_3`).value;

        if (!v1 || !v2 || !v3) {
            Swal.fire({
                icon: 'warning',
                title: 'Belum lengkap',
                text: 'Lengkapi semua rumus terlebih dahulu sebelum mengecek jawaban.',
                confirmButtonColor: '#198754'
            });
            return; // ⛔ STOP, JANGAN LANJUT
        }
    }

    // =========================
    // TAHAP 2: CEK KEBENARAN
    // =========================
    let semuaBenar = true;

    for (const tipe in konfigurasi) {
        const v1 = document.getElementById(`rumus${tipe}_1`).value;
        const v2 = document.getElementById(`rumus${tipe}_2`).value;
        const v3 = document.getElementById(`rumus${tipe}_3`).value;

        const feedback = document.getElementById(`feedback${tipe}`);
        const kesimpulan = document.getElementById(`kesimpulan${tipe}`);

        // reset tampilan
        feedback.innerHTML = '';
        kesimpulan.classList.add('d-none');

        const benar =
            v1 === konfigurasi[tipe].utama &&
            (
                (v2 === konfigurasi[tipe].lain[0] && v3 === konfigurasi[tipe].lain[1]) ||
                (v2 === konfigurasi[tipe].lain[1] && v3 === konfigurasi[tipe].lain[0])
            );

        if (benar) {
            feedback.innerHTML = '<span class="text-success">Jawaban anda benar semua</span>';
            kesimpulan.classList.remove('d-none');
        } else {
            feedback.innerHTML = '<span class="text-danger">Masih ada jawaban anda yang kurang tepat</span>';
            semuaBenar = false;
        }
    }

    // =========================
    // TAHAP 3: SWEET ALERT HASIL
    // =========================
    if (!semuaBenar) {
        Swal.fire({
            icon: 'error',
            title: 'Masih kurang tepat',
            text: 'Perhatikan kembali segitiga dan sisi terpanjang.',
            confirmButtonColor: '#dc3545'
        });
        return;
    }

    Swal.fire({
        icon: 'success',
        title: 'Jawaban Benar!',
        text: 'Semua jawaban dari Kebalikan Teorema Pythagoras sudah tepat.',
        confirmButtonColor: '#198754'
    });
}

function cekTabel() {
    const inputs = document.querySelectorAll('#tabelTripel input');
    let kosong = false;
    let salah = 0;

    inputs.forEach(inp => {
        inp.classList.remove('is-valid', 'is-invalid');

        if (inp.value.trim() === '') {
            kosong = true;
        }
    });

    if (kosong) {
        Swal.fire({
            icon: 'warning',
            title: 'Belum Lengkap',
            text: 'Lengkapi semua isian pada tabel terlebih dahulu.'
        });
        return;
    }

    inputs.forEach(inp => {
        const benar = inp.dataset.jawaban.replace(/\s/g,'');
        const isi = inp.value.replace(/\s/g,'');

        if (isi == benar) {
            inp.classList.add('is-valid');
        } else {
            inp.classList.add('is-invalid');
            salah++;
        }
    });

    if (salah === 0) {
        Swal.fire({
            icon: 'success',
            title: 'Hebat 🎉',
            text: 'Semua tripel Pythagoras berhasil ditemukan!'
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Masih Salah',
            text: 'Periksa kembali isian yang berwarna merah.'
        });
    }
}
function cekJawabanLatihan() {
    // --- KUNCI JAWABAN ---
    const kunciSoal1 = {
        'soal1a': 'ya',
        'soal1b': 'tidak',
        'soal1c': 'ya',
        'soal1d': 'tidak',
        'soal1e': 'ya'
    };
    const kunciSoal2 = 'A'; // 7, 24, 25

    // Soal 3: 9, 12, 15
    const kunciSoal3 = [
        15, // Index 0: Sisi C
        15, // Index 1: Sisi C (di rumus)
        225, // Index 2: C kuadrat
        9, // Index 3: Sisi A
        12, // Index 4: Sisi B
        81, // Index 5: A kuadrat
        144, // Index 6: B kuadrat
        225 // Index 7: Hasil jumlah
    ];
    const kunciSelect3 = "Siku-siku";

    // --- CEK KELENGKAPAN ---
    let belumLengkap = false;

    // Cek Soal 1 & 2
    for (let key in kunciSoal1) {
        if (!document.querySelector(`input[name="${key}"]:checked`)) belumLengkap = true;
    }
    if (!document.querySelector('input[name="soal2"]:checked')) belumLengkap = true;

    // Cek Soal 3 Inputs
    const inputsSoal3 = document.querySelectorAll('.input-soal3');
    inputsSoal3.forEach(input => {
        if (input.value.trim() === "") belumLengkap = true;
    });

    // Cek Soal 3 Select
    const selectSoal3 = document.getElementById('selectSoal3');
    if (selectSoal3.value === "") belumLengkap = true;


    // --- [PERUBAHAN DISINI] Mengambil ID yang baru (_soal3) ---
    const inpCompareC = document.getElementById('inp_compare_c_soal3');
    const inpSign = document.getElementById('inp_sign_soal3');
    const inpCompareAB = document.getElementById('inp_compare_ab_soal3');

    // Cek apakah kosong (Bagian Perbandingan)
    if (inpCompareC.value.trim() === "" || inpSign.value === "" || inpCompareAB.value.trim() === "") {
        belumLengkap = true;
    }

    // SweetAlert jika belum lengkap
    if (belumLengkap) {
        Swal.fire({
            icon: 'warning',
            title: 'Belum Lengkap!',
            text: 'Silakan lengkapi semua jawaban kamu terlebih dahulu.',
            confirmButtonColor: '#ffc107',
            confirmButtonText: 'Oke, Saya Lengkapi'
        });
        return; 
    }

    // --- VALIDASI JAWABAN ---
    let benarSemua = true; 

    // 1. Validasi Soal 1
    for (let key in kunciSoal1) {
        const pilihan = document.querySelector(`input[name="${key}"]:checked`);
        const semuaRadio = document.querySelectorAll(`input[name="${key}"]`);
        semuaRadio.forEach(r => r.classList.remove('is-valid', 'is-invalid'));
        if (pilihan.value === kunciSoal1[key]) {
            pilihan.classList.add('is-valid');
        } else {
            pilihan.classList.add('is-invalid');
            benarSemua = false; 
        }
    }

    // 2. Validasi Soal 2
    const pilihanSoal2 = document.querySelector('input[name="soal2"]:checked');
    const labelsSoal2 = document.querySelectorAll('input[name="soal2"] + label');
    labelsSoal2.forEach(lbl => {
        lbl.classList.remove('btn-success', 'btn-danger');
        lbl.classList.add('btn-outline-success');
    });
    const labelTerpilih = document.querySelector(`label[for="${pilihanSoal2.id}"]`);
    if (pilihanSoal2.value === kunciSoal2) {
        labelTerpilih.classList.remove('btn-outline-success');
        labelTerpilih.classList.add('btn-success');
    } else {
        labelTerpilih.classList.remove('btn-outline-success');
        labelTerpilih.classList.add('btn-danger');
        benarSemua = false; 
    }

    // 3. Validasi Soal 3 (Input)
    inputsSoal3.forEach((input, index) => {
        input.classList.remove('is-valid', 'is-invalid');
        let val = parseFloat(input.value);
        let benar = false;
        // Logika tukar tempat 9 dan 12
        if (index === 3 || index === 4) {
            if (val === 9 || val === 12) benar = true;
        } else if (index === 5 || index === 6) {
            if (val === 81 || val === 144) benar = true;
        } else {
            if (val === kunciSoal3[index]) benar = true;
        }

        if (benar) input.classList.add('is-valid');
        else {
            input.classList.add('is-invalid');
            benarSemua = false;
        }
    });

    // 4. Validasi Soal 3 (Select Kesimpulan)
    selectSoal3.classList.remove('is-valid', 'is-invalid');
    if (selectSoal3.value === kunciSelect3) {
        selectSoal3.classList.add('is-valid');
    } else {
        selectSoal3.classList.add('is-invalid');
        benarSemua = false;
    }

    // --- [VALIDASI BAGIAN PERBANDINGAN] ---
    
    // Cek Nilai c^2 (Harus 225)
    inpCompareC.classList.remove('is-valid', 'is-invalid');
    if (parseFloat(inpCompareC.value) === 225) { 
        inpCompareC.classList.add('is-valid');
    } else {
        inpCompareC.classList.add('is-invalid');
        benarSemua = false;
    }

    // Cek Tanda (Harus "=")
    inpSign.classList.remove('is-valid', 'is-invalid');
    if (inpSign.value === "=") {
        inpSign.classList.add('is-valid');
    } else {
        inpSign.classList.add('is-invalid');
        benarSemua = false;
    }

    // Cek Nilai a^2 + b^2 (Harus 225)
    inpCompareAB.classList.remove('is-valid', 'is-invalid');
    if (parseFloat(inpCompareAB.value) === 225) {
        inpCompareAB.classList.add('is-valid');
    } else {
        inpCompareAB.classList.add('is-invalid');
        benarSemua = false;
    }

    // --- HASIL AKHIR ---
    if (benarSemua) {
        Swal.fire({
            icon: 'success',
            title: 'Luar Biasa!',
            text: 'Selamat, semua jawaban kamu BENAR!',
            confirmButtonColor: '#198754',
            confirmButtonText: 'Mantap!'
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Masih Ada yang Salah',
            text: 'Coba periksa kembali jawaban yang berwarna merah.',
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Coba Lagi'
        });
    }
}