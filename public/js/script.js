/* =====================================================
   NAVIGASI HALAMAN
===================================================== */
document.addEventListener('DOMContentLoaded', function () {
    const pages = document.querySelectorAll('.materi-page');
    const prevBtn = document.getElementById('prevPage');
    const nextBtn = document.getElementById('nextPage');
    const pageBtns = document.querySelectorAll('.page-btn');
    const savedPage = localStorage.getItem('materiPage');

    let currentPage = 0;
    const totalPages = pages.length;

    function showPage(index) {
        if (index < 0 || index >= totalPages) return;

        pages.forEach(p => p.classList.add('d-none'));
        pages[index].classList.remove('d-none');

        currentPage = index;
        localStorage.setItem('materiPage', index);

        pageBtns.forEach(btn => {
            btn.parentElement.classList.remove('active');
            if (parseInt(btn.dataset.page) === index) {
                btn.parentElement.classList.add('active');
            }
        });

        prevBtn.disabled = (index === 0);
        nextBtn.disabled = (index === totalPages - 1);

        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        // Inisialisasi kode spesifik halaman
        initPageSpecificCode(index);
    }

    function initPageSpecificCode(pageIndex) {
            // Hentikan semua event listener sebelumnya jika perlu
            removeAllEventListeners();
            
            console.log("Membuka halaman index:", pageIndex); // Debugging

            switch(pageIndex) {
                case 0:
                    // Halaman 1: Struktur (Drag & Drop)
                    if (typeof initPage0 === 'function') initPage0();
                    break;
                case 1:
                    // Halaman 2: Bilangan Berpangkat & Akar
                    // GANTI initPage1() MENJADI DUA FUNGSI INI:
                    if (typeof initPageKuadrat === 'function') initPageKuadrat();
                    if (typeof initPageAkar === 'function') initPageAkar();
                    break;
                case 2:
                    // Halaman 3: Visual Segitiga
                    if (typeof initPage2 === 'function') initPage2();
                    break;
                case 3:
                    // Halaman 4: Pembuktian Pythagoras
                    if (typeof initPage3 === 'function') initPage3();
                    break;
                case 4:
                    // Jika ada halaman 5
                    if (typeof initPage4 === 'function') initPage4();
                    break;
            }
        }

    // Fungsi untuk menghapus event listeners lama
    function removeAllEventListeners() {
        // Anda mungkin perlu menyimpan referensi event listener 
        // untuk bisa menghapusnya nanti
    }

    pageBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            showPage(parseInt(btn.dataset.page));
        });
    });

    // Cek dulu apakah tombolnya ada
    if (prevBtn) {
        prevBtn.onclick = () => showPage(currentPage - 1);
    }
    
    if (nextBtn) {
        nextBtn.onclick = () => showPage(currentPage + 1);
    }

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

/* ===============================
   HALAMAN 1 – DRAG & DROP (PERBAIKAN LOGIKA)
================================ */
function initPage0() {
    let draggedElement = null;
    let attemptCount = 0;
    const maxAttempts = 3;

    // Selector elemen penting
    const dragContainer = document.querySelector('[data-page="0"] #dragContainer');
    const resultSection = document.querySelector('[data-page="0"] #hasilStruktur');
    const checkBtn = document.querySelector('[data-page="0"] #checkAnswer');

    // 1. FUNGSI ACAK POSISI
    function shuffleDragItems() {
        if (dragContainer) {
            const items = Array.from(dragContainer.children);
            // Acak urutan
            for (let i = items.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                dragContainer.appendChild(items[j]);
            }
        }
    }

    // Panggil acak saat pertama kali load
    shuffleDragItems();

    // 2. FUNGSI RESET GAME (UNTUK TOMBOL 'ULANG')
    function resetGame() {
        attemptCount = 0;
        
        // Reset Drop Zones
        document.querySelectorAll('[data-page="0"] .drop-h1').forEach(zone => {
            zone.textContent = '...';
            zone.removeAttribute('data-user');
            zone.classList.remove('filled', 'correct', 'wrong');
        });

        // Reset Drag Items
        document.querySelectorAll('[data-page="0"] .drag-item').forEach(item => {
            item.style.display = 'block';
            item.setAttribute('draggable', 'true');
            item.style.opacity = '1';
            item.style.cursor = 'grab';
            item.style.backgroundColor = ''; // Hapus warna hijau/merah
            item.style.borderColor = '';
        });

        // Sembunyikan Hasil
        if (resultSection) {
            resultSection.classList.add('d-none');
        }

        // Aktifkan Tombol Cek
        if (checkBtn) {
            checkBtn.disabled = false;
            checkBtn.classList.remove('disabled');
        }

        // Acak ulang posisi
        shuffleDragItems();
    }

    // 3. EVENT LISTENER DRAG & DROP
    document.querySelectorAll('[data-page="0"] .drag-item').forEach(item => {
        item.addEventListener('dragstart', function(e) {
            draggedElement = this;
            this.classList.add('dragging');
            e.dataTransfer.setData('text/plain', this.dataset.value);
            e.dataTransfer.effectAllowed = 'move';
        });

        item.addEventListener('dragend', function() {
            this.classList.remove('dragging');
            draggedElement = null;
        });
    });

    document.querySelectorAll('[data-page="0"] .drop-h1').forEach(zone => {
        zone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('drag-over');
        });

        zone.addEventListener('dragleave', function() {
            this.classList.remove('drag-over');
        });

        zone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('drag-over');
            
            if (!draggedElement) return;

            const draggedValue = e.dataTransfer.getData('text/plain');
            
            // Cek apakah item ini sudah ada di drop zone lain, jika ya kosongkan yang lama
            const existingDrop = document.querySelector(`[data-page="0"] .drop-h1[data-user="${draggedValue}"]`);
            if (existingDrop && existingDrop !== this) {
                existingDrop.textContent = '...';
                existingDrop.removeAttribute('data-user');
                existingDrop.classList.remove('filled');
            }
            
            // Isi drop zone baru
            this.textContent = draggedElement.textContent;
            this.dataset.user = draggedValue;
            this.classList.add('filled');
            
            // Sembunyikan item sumber agar terlihat seperti "pindah"
            draggedElement.classList.remove('dragging');
            draggedElement = null;
        });

        // Klik untuk menghapus jawaban
        zone.addEventListener('click', function(e) {
            if (this.dataset.user && !e.target.classList.contains('badge')) {
                this.textContent = '...';
                this.removeAttribute('data-user');
                this.classList.remove('filled', 'correct', 'wrong');
            }
        });
    });

    // 4. FUNGSI VALIDASI
    function validateAnswers() {
        document.querySelectorAll('[data-page="0"] .drop-h1').forEach(zone => {
            zone.classList.remove('correct', 'wrong');
        });

        let allFilled = true;
        let correctCount = 0;
        let total = 0;

        document.querySelectorAll('[data-page="0"] .drop-h1').forEach(zone => {
            if (zone.dataset.user) {
                total++;
                if (zone.dataset.user === zone.dataset.answer) {
                    zone.classList.add('correct');
                    correctCount++;
                } else {
                    zone.classList.add('wrong');
                }
            } else {
                allFilled = false;
            }
        });

        if (!allFilled) {
            Swal.fire({
                icon: 'warning',
                title: 'Belum Lengkap',
                text: 'Isi semua kotak jawaban terlebih dahulu!',
                confirmButtonColor: '#ffc107'
            });
            return false;
        }

        return { correctCount, total };
    }

    // 5. TAMPILKAN KUNCI JAWABAN (Saat Lanjutkan / Menyerah)
    function showCorrectAnswers() {
        document.querySelectorAll('[data-page="0"] .drop-h1').forEach(zone => {
            const correctAnswer = zone.dataset.answer;
            
            // Isi drop zone dengan jawaban benar
            zone.textContent = correctAnswer; // Opsional: Sesuaikan teks jika ingin huruf kapital
            zone.dataset.user = correctAnswer;
            zone.classList.remove('wrong', 'filled');
            zone.classList.add('correct');
        });
        
        // Matikan interaksi
        document.querySelectorAll('[data-page="0"] .drag-item').forEach(item => {
            item.setAttribute('draggable', 'false');
            item.style.cursor = 'default';
            item.style.opacity = '0.5';
        });
    }

    // 6. LOGIKA TOMBOL PERIKSA
    if (checkBtn) {
        checkBtn.addEventListener('click', () => {
            const result = validateAnswers();
            if (!result) return;
            
            const { correctCount, total } = result;
            attemptCount++;
            
            // KONDISI 1 & 3: JIKA BENAR (Di percobaan 1, 2, atau 3)
            if (correctCount === total) {
                Swal.fire({
                    icon: 'success',
                    title: 'Luar Biasa!',
                    text: `Jawaban Anda benar pada percobaan ke-${attemptCount}.`,
                    confirmButtonText: 'Lanjutkan',
                    confirmButtonColor: '#198754'
                }).then(() => {
                    // Munculkan Gambar 3 (Hasil Struktur)
                    if (resultSection) {
                        resultSection.classList.remove('d-none');
                        resultSection.scrollIntoView({ behavior: 'smooth' });
                    }
                    // Matikan tombol
                    checkBtn.disabled = true;
                });
            } 
            // JIKA SALAH
            else {
                // KONDISI 2: JIKA SUDAH 3 KALI SALAH
                if (attemptCount >= maxAttempts) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesempatan Habis',
                        html: `
                            <p>Anda telah mencoba ${maxAttempts} kali dan masih ada yang kurang tepat.</p>
                            <p class="small text-muted">Pilih <b>Ulang</b> untuk mencoba dari awal, atau <b>Lanjutkan</b> untuk melihat jawaban dan materi selanjutnya.</p>
                        `,
                        showCancelButton: true, // Munculkan tombol kedua
                        confirmButtonText: 'Lanjutkan', // Tombol kanan (Confirm)
                        confirmButtonColor: '#0d6efd',
                        cancelButtonText: 'Ulang', // Tombol kiri (Cancel)
                        cancelButtonColor: '#dc3545',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // PILIHAN: LANJUTKAN
                            // 1. Tampilkan jawaban benar di kotak
                            showCorrectAnswers();
                            // 2. Munculkan Gambar 3 (Hasil Struktur)
                            if (resultSection) {
                                resultSection.classList.remove('d-none');
                                resultSection.scrollIntoView({ behavior: 'smooth' });
                            }
                            // 3. Matikan tombol periksa
                            checkBtn.disabled = true;
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            // PILIHAN: ULANG
                            resetGame();
                        }
                    });
                } 
                // MASIH ADA KESEMPATAN (Percobaan 1 atau 2 tapi salah)
                else {
                    const remaining = maxAttempts - attemptCount;
                    Swal.fire({
                        icon: 'warning',
                        title: 'Masih Kurang Tepat',
                        html: `
                            <p>Periksa kembali jawaban kamu.</p>
                            <p class="small text-muted">Sisa kesempatan: <b>${remaining}</b> kali lagi.</p>
                        `,
                        confirmButtonText: 'Coba Lagi',
                        confirmButtonColor: '#ffc107'
                    });
                }
            }
        });
    }
}

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

/* ================= VISUAL INTERAKTIF SEGITIGA ================= */ 
function initTriangleCanvas(canvasElement) {
    const ctx = canvasElement.getContext("2d");
    
    let points = [];
    let drawing = false;
    let startPoint = null;
    let previewPoint = null;
    let snapEnabled = true;

    /* ================= GRID ================= */
    function drawGrid() {
        const step = 20;
        ctx.strokeStyle = "#e0e0e0";
        ctx.lineWidth = 1;

        for (let x = 0; x <= canvasElement.width; x += step) {
            ctx.beginPath();
            ctx.moveTo(x, 0);
            ctx.lineTo(x, canvasElement.height);
            ctx.stroke();
        }

        for (let y = 0; y <= canvasElement.height; y += step) {
            ctx.beginPath();
            ctx.moveTo(0, y);
            ctx.lineTo(canvasElement.width, y);
            ctx.stroke();
        }
    }

    /* ================= EVENT ================= */
    canvasElement.addEventListener("mousedown", e => {
        if (points.length >= 3) return;
        drawing = true;
        startPoint = getMouse(e);
    });

    canvasElement.addEventListener("mousemove", e => {
        if (!drawing) return;
        let end = getMouse(e);
        if (snapEnabled && points.length > 0) {
            end = snapLine(points[points.length - 1], end);
        }
        previewPoint = end;
        redraw();
    });

    canvasElement.addEventListener("mouseup", e => {
        if (!drawing) return;
        let end = getMouse(e);
        if (snapEnabled && points.length > 0) {
            end = snapLine(points[points.length - 1], end);
        }

        points.push(end);
        drawing = false;
        previewPoint = null;
        redraw();
    });

    /* ================= SNAP ================= */
    function snapLine(p1, p2) {
        const dx = p2.x - p1.x;
        const dy = p2.y - p1.y;
        const angle = Math.atan2(dy, dx);
        const tol = Math.PI / 18;

        if (Math.abs(angle) < tol || Math.abs(Math.abs(angle) - Math.PI) < tol)
            return { x: p2.x, y: p1.y };

        if (Math.abs(Math.abs(angle) - Math.PI / 2) < tol)
            return { x: p1.x, y: p2.y };

        if (Math.abs(Math.abs(angle) - Math.PI / 4) < tol ||
            Math.abs(Math.abs(angle) - 3 * Math.PI / 4) < tol) {
            const d = Math.min(Math.abs(dx), Math.abs(dy));
            return {
                x: p1.x + Math.sign(dx) * d,
                y: p1.y + Math.sign(dy) * d
            };
        }
        return p2;
    }

    /* ================= DRAW ================= */
    function redraw() {
        ctx.clearRect(0, 0, canvasElement.width, canvasElement.height);
        drawGrid();

        ctx.strokeStyle = "#000";
        ctx.lineWidth = 2;

        if (points.length > 0) {
            ctx.beginPath();
            ctx.moveTo(points[0].x, points[0].y);
            points.slice(1).forEach(p => ctx.lineTo(p.x, p.y));
            if (previewPoint) ctx.lineTo(previewPoint.x, previewPoint.y);
            if (points.length === 3) ctx.closePath();
            ctx.stroke();
        }

        points.forEach(p => {
            ctx.beginPath();
            ctx.arc(p.x, p.y, 4, 0, Math.PI * 2);
            ctx.fillStyle = "#198754";
            ctx.fill();
        });

        if (points.length === 3) analyzeTriangle();
    }

    /* ================= ANALISIS SEGITIGA ================= */
    function analyzeTriangle() {
        const [A, B, C] = points;

        const ab = dist(A, B);
        const bc = dist(B, C);
        const ca = dist(C, A);
        const sides = [ab, bc, ca].sort((a, b) => a - b);

        let type = "Segitiga Sembarang";

        if (Math.abs(sides[0]**2 + sides[1]**2 - sides[2]**2) < 1000)
            type = "Segitiga Siku-siku";
        else if (Math.abs(ab - bc) < 10 && Math.abs(bc - ca) < 10)
            type = "Segitiga Sama Sisi";
        else if (
            Math.abs(ab - bc) < 10 ||
            Math.abs(bc - ca) < 10 ||
            Math.abs(ab - ca) < 10
        )
            type = "Segitiga Sama Kaki";

        const triangleInfo = document.querySelector('[data-page="2"] #triangleInfo');
        if (triangleInfo) {
            triangleInfo.innerHTML = `Jenis segitiga: <strong>${type}</strong>`;
        }
    }

    /* ================= UTIL ================= */
    function dist(p1, p2) {
        return Math.hypot(p2.x - p1.x, p2.y - p1.y);
    }

    function getMouse(e) {
        const r = canvasElement.getBoundingClientRect();
        return { x: e.clientX - r.left, y: e.clientY - r.top };
    }

    /* ================= CONTROL ================= */
    function resetCanvas() {
        points = [];
        previewPoint = null;
        redraw();
        const triangleInfo = document.querySelector('[data-page="2"] #triangleInfo');
        if (triangleInfo) {
            triangleInfo.innerText = "Jenis segitiga: ";
        }
    }

    // Tambahkan event listener untuk tombol reset
    const resetBtn = document.querySelector('[data-page="2"] button[onclick*="resetCanvas"]');
    if (resetBtn) {
        resetBtn.onclick = resetCanvas;
    }

    // Inisialisasi grid
    drawGrid();
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

/* =========================================
   PYTHAGORAS STEP PROOF (NAMESPACE SAFE)
========================================= */

const pythaStepProof = {
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
    
    // Ukuran sisi (dalam pixel)
    sizes: {
        horizontal: 120, // 3 kotak (b) - SISI DATAR
        vertical: 160,   // 4 kotak (a) - SISI TEGAK
        hypotenuse: 200  // 5 kotak (c) - SISI MIRING
    }
};

/* ================= INIT ================= */
function psp_init() {
    const canvas = document.querySelector('[data-page="3"] #psp-canvas');
    if (!canvas) return;

    pythaStepProof.canvas = canvas;
    pythaStepProof.ctx = canvas.getContext('2d');
    
    // Set initial step
    psp_goStep(0);
}

/* ================= BASE DRAWING ================= */
function psp_drawGrid() {
    const ctx = pythaStepProof.ctx;
    ctx.strokeStyle = pythaStepProof.gridColor;
    ctx.lineWidth = pythaStepProof.gridLineWidth;

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

function psp_drawTriangle() {
    const ctx = pythaStepProof.ctx;
    const tp = pythaStepProof.trianglePoints;
    
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

function psp_drawBase() {
    const ctx = pythaStepProof.ctx;
    ctx.clearRect(0, 0, 520, 520);
    
    // Isi background dulu
    ctx.fillStyle = '#ffffffff';
    ctx.fillRect(0, 0, 520, 520);
    
    psp_drawGrid();
    psp_drawTriangle();
}

/* ================= DRAWING FUNCTIONS ================= */
function psp_drawSquare(x, y, size, color, angle = 0) {
    const ctx = pythaStepProof.ctx;
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

function psp_drawSquareGrid(x, y, size, color, angle = 0) {
    const ctx = pythaStepProof.ctx;
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
function psp_goStep(step) {
    pythaStepProof.currentStep = Math.max(pythaStepProof.currentStep, step);
    psp_drawBase();
    
    const info = document.querySelector('[data-page="3"] #psp-info');
    const tp = pythaStepProof.trianglePoints;
    const sz = pythaStepProof.sizes;
    
    if (!info) return;
    
    // STEP 1: Persegi sisi tegak (a²) - di samping kanan sisi tegak
    if (pythaStepProof.currentStep >= 1) {
        // Posisi di sebelah KANAN sisi tegak (menempel)
        psp_drawSquare(tp.rightX, tp.topY, sz.vertical, '#0dcaf0');
    }
    
    // STEP 2: Persegi sisi datar (b²) - di BAWAH sisi datar (KEMBALI KE POSISI AWAL)
    if (pythaStepProof.currentStep >= 2) {
        // Posisi di BAWAH sisi datar (seperti di kode awal)
        psp_drawSquare(tp.leftX, tp.leftY, sz.horizontal, '#dc3545');
    }
    
    // STEP 3: Persegi sisi miring (c²) - PERBAIKI POSISI DI SISI MIRING
    if (pythaStepProof.currentStep >= 3) {

        // Sudut sisi miring (B ke C)
        const angle = Math.atan2(
            tp.topY - tp.leftY,
            tp.topX - tp.leftX
        ) - Math.PI / 2;

        // Tempelkan persegi tepat di titik B (leftX, leftY)
        psp_drawSquare(
            tp.leftX,
            tp.leftY,
            sz.hypotenuse,
            '#fd7e14',
            angle
        );
    }
    
    // STEP 4: Grid pada persegi sisi tegak
    if (pythaStepProof.currentStep >= 4) {
        psp_drawSquareGrid(tp.rightX, tp.topY, sz.vertical, '#0dcaf0');
    }
    
    // STEP 5: Grid pada persegi sisi datar
    if (pythaStepProof.currentStep >= 5) {
        psp_drawSquareGrid(tp.leftX, tp.leftY, sz.horizontal, '#dc3545');
    }
    
    // STEP 6: Pembuktian - a² + b² = c²
    if (pythaStepProof.currentStep >= 6) {
        // Tampilkan semua persegi dengan grid
        psp_drawSquareGrid(tp.rightX, tp.topY, sz.vertical, '#0dcaf0');
        psp_drawSquareGrid(tp.leftX, tp.leftY, sz.horizontal, '#dc3545');
        
        // Hitung sudut sisi miring
        const angleC = Math.atan2(tp.topY - tp.leftY, tp.topX - tp.leftX) - Math.PI / 2;
        const ctx = pythaStepProof.ctx;
        
        // Draw hypotenuse square dengan grid
        ctx.save();
        ctx.translate(tp.leftX, tp.leftY);
        ctx.rotate(angleC);
        
        // Main square background (orange)
        ctx.fillStyle = '#fd7e14';
        ctx.fillRect(0, 0, sz.hypotenuse, sz.hypotenuse);
        ctx.strokeStyle = '#000000'; // Warna hitam untuk outline
        ctx.lineWidth = 2;
        ctx.strokeRect(0, 0, sz.hypotenuse, sz.hypotenuse);
        
        // Draw grid lines - UBAH INI MENJADI HITAM
        ctx.strokeStyle = '#000000'; // Warna hitam untuk grid
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
        
        // Kotak biru SOLID untuk a² (4×4 = 16 kotak)
        ctx.fillStyle = '#0dcaf0'; // Biru solid, tidak transparan
        
        for (let i = 0; i < 4; i++) {
            for (let j = 0; j < 4; j++) {
                ctx.fillRect(i * 40, j * 40, 40, 40);
            }
        }
        
        // Kotak merah SOLID untuk b² (9 kotak sisanya)
        ctx.fillStyle = '#dc3545'; // Merah solid, tidak transparan
        
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
        
        // Juga ubah outline untuk kotak-kotak kecil menjadi hitam
        ctx.strokeStyle = '#000000';
        ctx.lineWidth = 1;
        
        // Gambar outline untuk semua kotak kecil (opsional)
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
            info.innerHTML = 'Langkah 1: Memasang persegi di sisi TEGAK (a²)<br>Ukuran: 4×4 = 16 satuan<br>Posisi: di samping kanan sisi tegak';
            break;
        case 2:
            info.innerHTML = 'Langkah 2: Memasang persegi di sisi DATAR (b²)<br>Ukuran: 3×3 = 9 satuan<br>Posisi: di bawah sisi datar';
            break;
        case 3:
            info.innerHTML = 'Langkah 3: Memasang persegi di sisi MIRING (c²)<br>Ukuran: 5×5 = 25 satuan<br>Posisi: sepanjang sisi miring';
            break;
        case 4:
            info.innerHTML = 'Langkah 4: Memasang grid di persegi sisi TEGAK<br>a² = 4×4 = 16 satuan';
            break;
        case 5:
            info.innerHTML = 'Langkah 5: Memasang grid di persegi sisi DATAR<br>b² = 3×3 = 9 satuan';
            break;
        case 6:
            info.innerHTML = 'Langkah 6: Pembuktian a² + b² = c²<br>' +
                            'a² (biru) = 4×4 = 16 satuan<br>' +
                            'b² (merah) = 3×3 = 9 satuan<br>' +
                            'c² (total) = 5×5 = 25 satuan<br>' +
                            '<strong>16 + 9 = 25 ✓</strong>';
            break;
        default:
            info.innerHTML = 'Klik langkah 1 untuk memulai pembuktian.<br>' +
                            'Gunakan tombol 1-6 untuk melihat setiap langkah.';
    }
    
    // Update button states
    updateButtonStates(pythaStepProof.currentStep);
}

/* ================= BUTTON STATES ================= */
function updateButtonStates(currentStep) {
    const buttons = document.querySelectorAll('[data-page="3"] .psp-step-btn');
    const resetBtn = document.querySelector('[data-page="3"] .psp-reset-btn');
    
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
function psp_reset() {
    pythaStepProof.currentStep = 0;
    psp_drawBase();
    
    const info = document.querySelector('[data-page="3"] #psp-info');
    if (info) {
        info.innerHTML = 'Klik langkah 1 untuk memulai pembuktian.<br>' +
                        'Gunakan tombol 1-6 untuk melihat setiap langkah.';
    }
    
    updateButtonStates(0);
    
    const resetBtn = document.querySelector('[data-page="3"] .psp-reset-btn');
    if (resetBtn) {
        resetBtn.classList.add('active');
        setTimeout(() => {
            resetBtn.classList.remove('active');
        }, 300);
    }
}


document.addEventListener('DOMContentLoaded', function() {
    initDragDropPythagoras();
});

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



// Script Drag & Drop Pythagoras - Versi Sederhana
(function() {
    // State
    let dragState = {
        answers: {},
        draggingElement: null
    };
    
    // Jawaban yang benar
    const correctAnswers = {
        '1': '8', // Soal 1
        '2': '13',  // Soal 2
        '3': '25',  // Soal 3
        '4': '29'   // Soal 4
    };
    
    // Inisialisasi
    function initDragDrop() {
        setupDragEvents();
        setupCheckButton();
    }
    
    // Setup event listeners untuk drag & drop
    function setupDragEvents() {
        // Event untuk elemen yang bisa di-drag (jawaban)
        document.querySelectorAll('.draggable').forEach(item => {
            item.addEventListener('dragstart', handleDragStart);
            item.addEventListener('dragend', handleDragEnd);
        });
        
        // Event untuk drop zone
        document.querySelectorAll('.drop-zone').forEach(zone => {
            zone.addEventListener('dragover', handleDragOver);
            zone.addEventListener('dragenter', handleDragEnter);
            zone.addEventListener('dragleave', handleDragLeave);
            zone.addEventListener('drop', handleDrop);
        });
    }
    
    // Setup tombol periksa jawaban
    function setupCheckButton() {
        const checkButton = document.getElementById('periksa-jawaban');
        if (checkButton) {
            checkButton.addEventListener('click', checkAllAnswers);
        }
    }
    
    // Event Handlers
    function handleDragStart(e) {
        dragState.draggingElement = this;
        this.classList.add('dragging');
        
        // Set data yang akan ditransfer
        const value = this.getAttribute('data-value');
        e.dataTransfer.setData('text/plain', value);
        e.dataTransfer.effectAllowed = 'move';
    }
    
    function handleDragEnd(e) {
        if (dragState.draggingElement) {
            dragState.draggingElement.classList.remove('dragging');
        }
        dragState.draggingElement = null;
        
        // Reset semua drop zone yang sedang di-hover
        document.querySelectorAll('.drop-zone.drag-over').forEach(zone => {
            zone.classList.remove('drag-over');
        });
    }
    
    function handleDragOver(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
    }
    
    function handleDragEnter(e) {
        e.preventDefault();
        this.classList.add('drag-over');
    }
    
    function handleDragLeave(e) {
        this.classList.remove('drag-over');
    }
    
    function handleDrop(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
        
        // Ambil data dari elemen yang di-drag
        const draggedValue = e.dataTransfer.getData('text/plain');
        const soalId = this.getAttribute('data-soal');
        
        // Update jawaban di state
        dragState.answers[soalId] = draggedValue;
        
        // Update tampilan drop zone
        updateDropZoneDisplay(this, draggedValue);
        
        // Reset status pemeriksaan jika ada
        resetCheckStatus();
    }
    
    // Update tampilan drop zone
    function updateDropZoneDisplay(zone, value) {
        // Reset kelas status
        zone.classList.remove('correct-answer', 'incorrect-answer');
        zone.classList.add('has-answer');
        
        // Update teks
        const placeholder = zone.querySelector('.drop-placeholder');
        if (placeholder) {
            placeholder.innerHTML = `<span class="placeholder-text">${value}</span>`;
        }
        
        // Update soal item untuk menghapus status benar/salah
        const soalItem = zone.closest('.soal-item');
        if (soalItem) {
            soalItem.classList.remove('correct', 'incorrect');
        }
    }
    
    // Reset status pemeriksaan
    function resetCheckStatus() {
        const hasilDiv = document.getElementById('hasil-pemeriksaan');
        if (hasilDiv && !hasilDiv.innerHTML.includes('Belum ada jawaban')) {
            hasilDiv.innerHTML = `
                <p class="mb-1">Jawaban telah diubah.</p>
                <p class="mb-0 text-muted small">Klik tombol "Periksa Jawaban" untuk melihat hasil.</p>
            `;
        }
    }
    
    // Fungsi Periksa semua jawaban - Versi SweetAlert
function checkAllAnswers() {
    const totalSoal = Object.keys(correctAnswers).length;
    const answeredSoal = Object.keys(dragState.answers).length;
    
    // Cek apakah semua soal sudah dijawab
    if (answeredSoal < totalSoal) {
        Swal.fire({
            icon: 'warning',
            title: 'Belum Lengkap',
            html: `<div class="text-start">
                    <p>Harap jawab semua soal terlebih dahulu!</p>
                    <p class="text-muted small">${answeredSoal} dari ${totalSoal} soal terjawab</p>
                   </div>`,
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#ffc107'
        });
        return;
    }
    
    let correctCount = 0;
    let incorrectSoals = [];
    
    // Periksa setiap jawaban
    for (let i = 1; i <= totalSoal; i++) {
        const soalId = i.toString();
        const userAnswer = dragState.answers[soalId];
        const correctAnswer = correctAnswers[soalId];
        const isCorrect = userAnswer === correctAnswer;
        
        // Update tampilan visual
        const dropZone = document.querySelector(`.drop-zone[data-soal="${soalId}"]`);
        if (dropZone) {
            if (isCorrect) {
                dropZone.classList.add('correct-answer');
                dropZone.classList.remove('incorrect-answer');
                correctCount++;
            } else {
                dropZone.classList.add('incorrect-answer');
                dropZone.classList.remove('correct-answer');
                incorrectSoals.push(soalId);
            }
        }
        
        // Update soal item
        const soalItem = dropZone?.closest('.soal-item');
        if (soalItem) {
            if (isCorrect) {
                soalItem.classList.add('correct');
                soalItem.classList.remove('incorrect');
            } else {
                soalItem.classList.add('incorrect');
                soalItem.classList.remove('correct');
            }
        }
    }
    
    // Tampilkan SweetAlert berdasarkan hasil
    if (correctCount === totalSoal) {
        // Semua jawaban benar
        Swal.fire({
            icon: 'success',
            title: 'Selamat!',
            html: `<div class="text-center">
                    <p><strong>Semua jawaban Anda benar!</strong></p>
                   </div>`,
            confirmButtonText: 'Lanjutkan',
            confirmButtonColor: '#28a745'
        });
    } else {
        // Ada jawaban salah
        const incorrectCount = totalSoal - correctCount;
        
        Swal.fire({
            icon: 'warning',
            title: 'Jawaban Masih Kurang Tepat',
            html: `<div class="text-center">
                    <p><strong>${correctCount} dari ${totalSoal} jawaban benar</strong></p>
                    <p class="mb-2">Masih ada ${incorrectCount} jawaban yang perlu diperbaiki.</p>
                    <p class="text-muted small">Periksa kembali perhitungan Anda.</p>
                   </div>`,
            confirmButtonText: 'Coba Lagi',
            confirmButtonColor: '#ffc107'
        });
    }
}
    
    // Inisialisasi saat DOM siap
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDragDrop);
    } else {
        initDragDrop();
    }
})

document.addEventListener('DOMContentLoaded', function () {

    /* =========================
       FUNGSI RESET JAWABAN
    ========================== */
    window.resetInputs = function () {

        // Reset textarea
        document.getElementById('jawaban1').value = '';
        document.getElementById('jawaban4').value = '';

        // Reset radio
        document.querySelectorAll('input[name="refleksi2"]')
            .forEach(el => el.checked = false);

        // Reset select
        document.getElementById('jawaban3').value = '';

        // Notifikasi reset
        Swal.fire({
            icon: 'info',
            title: 'Jawaban Direset',
            text: 'Semua jawaban sudah dikosongkan.',
            confirmButtonColor: '#6c757d',
            confirmButtonText: 'Oke'
        });
    }

    /* =========================
       LOGIC SIMPAN JAWABAN
    ========================== */
    document.getElementById('btnSimpan').addEventListener('click', function () {

        let jawaban1 = document.getElementById('jawaban1').value.trim();
        let jawaban2 = document.querySelector('input[name="refleksi2"]:checked');
        let jawaban3 = document.getElementById('jawaban3').value;
        let jawaban4 = document.getElementById('jawaban4').value.trim();

        if (!jawaban1 || !jawaban2 || !jawaban3 || !jawaban4) {
            Swal.fire({
                icon: 'warning',
                title: 'Jawaban Belum Lengkap',
                text: 'Silakan lengkapi semua pertanyaan sebelum menyimpan.',
                confirmButtonColor: '#ffc107',
                confirmButtonText: 'Baik'
            });
            return;
        }

        Swal.fire({
            icon: 'success',
            title: 'Jawaban Berhasil Disimpan',
            text: 'Refleksimu sudah tercatat. Kamu bisa membacanya kembali.',
            confirmButtonColor: '#198754',
            confirmButtonText: 'Oke'
        });

    });


}); 