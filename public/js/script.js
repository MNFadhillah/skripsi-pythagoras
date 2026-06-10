/* =====================================================
   NAVIGASI HALAMAN (VERSI PERBAIKAN - PER MATERI)
===================================================== */
document.addEventListener('DOMContentLoaded', function () {
    const pages = document.querySelectorAll('.materi-page');
    const prevBtns = document.querySelectorAll('.prev-btn');
    const nextBtns = document.querySelectorAll('.next-btn');
    const pageBtns = document.querySelectorAll('.page-btn');

    // ========== FUNGSI UNTUK MENDAPATKAN ID MATERI ==========
    function getMateriId() {
        const path = window.location.pathname;
        if (path.includes('/konsep/')) return 1;
        if (path.includes('/tripel/')) return 2;
        if (path.includes('/istimewa/')) return 3;
        if (path.includes('/penerapan/')) return 4;
        // fallback jika tidak terdeteksi (misal halaman utama)
        return 0;
    }

    const materiId = getMateriId();
    const storageKey = `materiPage_${materiId}`;
    const savedPage = localStorage.getItem(storageKey);

    let currentPage = 0;
    const totalPages = pages.length;

    function showPage(index) {
        if (index < 0 || index >= totalPages) return;

        pages.forEach(p => p.classList.add('d-none'));
        pages[index].classList.remove('d-none');

        currentPage = index;
        localStorage.setItem(storageKey, index); // SIMPAN PER MATERI

        // Update tombol angka
        pageBtns.forEach(btn => {
            btn.parentElement.classList.remove('active');
            if (parseInt(btn.dataset.page) === index) {
                btn.parentElement.classList.add('active');
            }
        });

        // Update status disabled Prev/Next
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
        // Sama seperti kode Anda sebelumnya
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

    // Event listeners
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
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('mainSidebar'); // Sekarang ID ini sudah ada di HTML
    const overlay = document.getElementById('sidebarOverlay'); // Ini juga sudah ada
    const body = document.body;

    function handleSidebarToggle(e) {
        if (e) e.stopPropagation();

        if (window.innerWidth >= 992) {
            // Desktop: Geser Layout
            body.classList.toggle('sidebar-closed');
        } else {
            // Mobile: Slide In/Out
            if (sidebar) sidebar.classList.toggle('active');
            if (overlay) overlay.classList.toggle('active');
        }
    }

    if (toggleBtn) toggleBtn.addEventListener('click', handleSidebarToggle);

    if (overlay) {
        overlay.addEventListener('click', function () {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    }
});

// Fungsi agar tombol Enter di keyboard juga bisa dipakai
function handleEnter(e) {
    if (e.key === "Enter") {
        cekJawabanSegitigaSikuSiku();
    }
}

// Inisialisasi pagination dan event listeners
document.addEventListener('DOMContentLoaded', function () {
    // Navigasi dengan tombol pagination atas
    document.querySelectorAll('.page-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const page = parseInt(this.getAttribute('data-page'));
            navigateToPage(page);
        });
    });

    // Navigasi dengan tombol pagination bawah
    document.querySelectorAll('.page-btn-bottom').forEach(btn => {
        btn.addEventListener('click', function () {
            const page = parseInt(this.getAttribute('data-page'));
            navigateToPage(page);
        });
    });

    // Tombol next
    // Tombol next & prev (KODE BARU YANG AMAN)
    const btnNextPage = document.getElementById('nextPage');
    if (btnNextPage) {
        btnNextPage.addEventListener('click', function () {
            const activePageBtn = document.querySelector('.page-item.active .page-btn');
            if (activePageBtn) {
                const currentPage = parseInt(activePageBtn.getAttribute('data-page'));
                if (currentPage < 4) navigateToPage(currentPage + 1);
            }
        });
    }

    const btnNextPageBottom = document.getElementById('nextPageBottom');
    if (btnNextPageBottom) {
        btnNextPageBottom.addEventListener('click', function () {
            const activePageBtn = document.querySelector('.page-item.active .page-btn-bottom');
            if (activePageBtn) {
                const currentPage = parseInt(activePageBtn.getAttribute('data-page'));
                if (currentPage < 4) navigateToPage(currentPage + 1);
            }
        });
    }

    const btnPrevPage = document.getElementById('prevPage');
    if (btnPrevPage) {
        btnPrevPage.addEventListener('click', function () {
            const activePageBtn = document.querySelector('.page-item.active .page-btn');
            if (activePageBtn) {
                const currentPage = parseInt(activePageBtn.getAttribute('data-page'));
                if (currentPage > 0) navigateToPage(currentPage - 1);
            }
        });
    }

    const btnPrevPageBottom = document.getElementById('prevPageBottom');
    if (btnPrevPageBottom) {
        btnPrevPageBottom.addEventListener('click', function () {
            const activePageBtn = document.querySelector('.page-item.active .page-btn-bottom');
            if (activePageBtn) {
                const currentPage = parseInt(activePageBtn.getAttribute('data-page'));
                if (currentPage > 0) navigateToPage(currentPage - 1);
            }
        });
    }

    // Auto-fill contoh soal 3 untuk memudahkan
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


// =====================================================
// OVERRIDE FUNGSI UPDATE PROGRESS (AUTO-UPDATE DOM GLOBAL)
// =====================================================
// Tambahkan parameter ke-4: isSilent (default false)
window.updateProgress = async function (idMateri, idCheckpoint, earnedPoints = 0, isSilent = false) {
    console.log(`Mengirim progress... Materi: ${idMateri}, Checkpoint: ${idCheckpoint}, Poin: ${earnedPoints}, Silent: ${isSilent}`);

    const kelasMeta = document.querySelector('meta[name="user-kelas-id"]');
    if (kelasMeta && (!kelasMeta.getAttribute('content') || kelasMeta.getAttribute('content') === '')) {
        Swal.fire({
            icon: 'info',
            title: 'Progres Tidak Tersimpan',
            text: 'Anda belum bergabung ke kelas.',
            confirmButtonColor: '#198754'
        });
        return;
    }

    const endpointUrl = '/siswa/progress/update';
    const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');

    if (!csrfTokenElement) return;

    try {
        const response = await fetch(endpointUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfTokenElement.getAttribute('content')
            },
            body: JSON.stringify({
                materi_id: idMateri,
                checkpoint_code: idCheckpoint,
                points: earnedPoints
            })
        });

        const data = await response.json();

        if (data.success) {
            console.log("Response Server:", data);

            // --- A. MUNCULKAN TOAST HANYA JIKA TIDAK SILENT ---
            if (!isSilent && data.is_new_record) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });

                Toast.fire({
                    icon: 'success',
                    title: `+${earnedPoints} Poin Tersimpan!`
                });
            }

            // --- B. UPDATE TEKS POIN & ANIMASI ---
            const poinDisplay = document.getElementById('poinDisplay');
            if (poinDisplay && data.total_points !== undefined) {
                poinDisplay.innerText = `${data.total_points} Poin`;
                // Tambahkan efek denyut sesaat agar interaktif
                poinDisplay.parentElement.classList.add('animate__animated', 'animate__pulse');
                setTimeout(() => {
                    poinDisplay.parentElement.classList.remove('animate__animated', 'animate__pulse');
                }, 1000);
            }

            // --- C. UPDATE PROGRESS BAR ---
            const progressBar = document.getElementById('materiProgressBar');
            const progressText = document.getElementById('materiProgressText');

            // Gunakan materi_progress, jika kosong (undefined), pakai progress_percentage sebagai fallback
            let persentase = data.materi_progress !== undefined ? data.materi_progress : data.progress_percentage;

            if (progressBar && persentase !== undefined) {
                progressBar.style.width = `${persentase}%`;
                progressBar.style.setProperty('--w', `${persentase}%`);
                progressBar.setAttribute('aria-valuenow', persentase);
            }

            if (progressText && persentase !== undefined) {
                progressText.innerText = `${persentase}% Selesai`;
            }

            // --- D. SIMPAN BADGE TERTUNDA ---
            if (data.badge_earned && data.badge_data) {
                simpanBadgeTertunda(data.badge_data);
                jadwalkanTampilkanBadgeTertunda(1200);
            }
        }
    } catch (error) {
        console.error("Terjadi kesalahan saat auto-update DOM:", error);
    }
};
let badgeDisplayTimer = null;

function ambilBadgeTertunda() {
    try {
        return JSON.parse(sessionStorage.getItem('pendingBadges')) || [];
    } catch (e) {
        return [];
    }
}

function simpanDaftarBadgeTertunda(pendingBadges) {
    sessionStorage.setItem('pendingBadges', JSON.stringify(pendingBadges));
}

function simpanBadgeTertunda(badgeData) {
    if (!badgeData) return;

    const pendingBadges = ambilBadgeTertunda();

    const badgeSudahAda = pendingBadges.some(badge => badge.name === badgeData.name);

    if (!badgeSudahAda) {
        pendingBadges.push(badgeData);
        simpanDaftarBadgeTertunda(pendingBadges);
    }
}

function jadwalkanTampilkanBadgeTertunda(delay = 1000) {
    if (badgeDisplayTimer) {
        clearTimeout(badgeDisplayTimer);
    }

    badgeDisplayTimer = setTimeout(() => {
        badgeDisplayTimer = null;
        tampilkanBadgeTertunda();
    }, delay);
}

function tampilkanBadgeTertunda() {
    const pendingBadges = ambilBadgeTertunda();

    if (pendingBadges.length === 0) {
        return;
    }

    // Kalau masih ada popup latihan/refleksi/progress yang terbuka, tunggu dulu.
    if (typeof Swal !== 'undefined' && Swal.isVisible()) {
        jadwalkanTampilkanBadgeTertunda(800);
        return;
    }

    const badge = pendingBadges.shift();
    simpanDaftarBadgeTertunda(pendingBadges);

    Swal.fire({
        title: 'Badge Baru Terbuka!',
        html: `
            <div class="text-center">
                <p class="mb-3">Selamat, kamu mendapatkan badge:</p>
                <h5 class="fw-bold text-success">${badge.name}</h5>
            </div>
        `,
        imageUrl: badge.image,
        imageWidth: 100,
        imageHeight: 100,
        confirmButtonText: 'OK',
        confirmButtonColor: '#198754',
        allowOutsideClick: false
    }).then(() => {
        // Kalau ada lebih dari satu badge yang terbuka, tampilkan berikutnya setelah jeda.
        jadwalkanTampilkanBadgeTertunda(600);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    jadwalkanTampilkanBadgeTertunda(1500);
});


/* =====================================================
   FITUR MODE REVIEW & ULANGI LATIHAN (FINAL & AMAN)
===================================================== */
window.tampilkanLatihanSelesai = function (buttonSelectorOrElement, resetCallback) {
    const btnCek = typeof buttonSelectorOrElement === 'string'
        ? document.querySelector(buttonSelectorOrElement)
        : buttonSelectorOrElement;

    if (!btnCek) return;

    const container = btnCek.parentElement;
    if (!container) return;

    // Ketika latihan sudah selesai lagi, mode ulangi dimatikan
    btnCek.removeAttribute('data-latihan-ulang');
    window.__modeLatihanUlangAktif = false;

    // Hindari UI dobel
    const existingReviewUI = container.querySelector('.review-mode-ui');
    if (existingReviewUI) {
        existingReviewUI.remove();
    }

    // Sembunyikan tombol asli dengan tegas
    btnCek.disabled = true;
    btnCek.classList.add('d-none');
    btnCek.style.display = 'none';

    const reviewUI = document.createElement('div');
    reviewUI.className = 'review-mode-ui mt-3 animate__animated animate__fadeIn';
    reviewUI.innerHTML = `
        <div class="d-flex flex-column align-items-center">
            <div class="alert alert-success border-success py-2 mb-2 shadow-sm" style="border-radius: 8px;">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong class="small">Latihan Selesai!</strong>
            </div>

            <button class="btn btn-outline-success btn-sm fw-bold btn-ulangi shadow-sm" type="button" style="border-radius: 8px;">
                <i class="bi bi-arrow-counterclockwise me-1"></i>Ulangi Latihan
            </button>
        </div>
    `;

    btnCek.insertAdjacentElement('afterend', reviewUI);

    reviewUI.querySelector('.btn-ulangi').addEventListener('click', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Ulangi Latihan?',
            text: 'Mengulang latihan tidak akan menambah poin atau mengubah progresmu. Lanjut?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Ulangi!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Aktifkan mode latihan ulang
                window.__modeLatihanUlangAktif = true;

                btnCek.setAttribute('data-latihan-ulang', 'true');

                if (typeof resetCallback === 'function') {
                    resetCallback();
                }

                btnCek.disabled = false;
                btnCek.classList.remove('d-none');
                btnCek.style.display = 'inline-block';
                btnCek.removeAttribute('data-review-setup');

                reviewUI.remove();
            }
        });
    });
};



window.setupReviewMode = function (checkpointCode, buttonSelector, showAnswerCallback, resetCallback) {
    if (!window.completedCheckpoints || !window.completedCheckpoints.includes(checkpointCode)) {
        return;
    }

    const btnCek = document.querySelector(buttonSelector);
    if (!btnCek) return;

    if (btnCek.getAttribute('data-review-setup') === 'true') return;
    btnCek.setAttribute('data-review-setup', 'true');

    if (typeof showAnswerCallback === 'function') {
        showAnswerCallback();
    }

    window.tampilkanLatihanSelesai(btnCek, resetCallback);
};