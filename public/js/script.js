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

// Fungsi agar tombol Enter di keyboard juga bisa dipakai
function handleEnter(e) {
    if (e.key === "Enter") {
        cekJawabanSegitigaSikuSiku();
    }
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
    // Tombol next & prev (KODE BARU YANG AMAN)
    const btnNextPage = document.getElementById('nextPage');
    if (btnNextPage) {
        btnNextPage.addEventListener('click', function() {
            const activePageBtn = document.querySelector('.page-item.active .page-btn');
            if(activePageBtn) {
                const currentPage = parseInt(activePageBtn.getAttribute('data-page'));
                if (currentPage < 4) navigateToPage(currentPage + 1);
            }
        });
    }
    
    const btnNextPageBottom = document.getElementById('nextPageBottom');
    if (btnNextPageBottom) {
        btnNextPageBottom.addEventListener('click', function() {
            const activePageBtn = document.querySelector('.page-item.active .page-btn-bottom');
            if(activePageBtn) {
                const currentPage = parseInt(activePageBtn.getAttribute('data-page'));
                if (currentPage < 4) navigateToPage(currentPage + 1);
            }
        });
    }
    
    const btnPrevPage = document.getElementById('prevPage');
    if (btnPrevPage) {
        btnPrevPage.addEventListener('click', function() {
            const activePageBtn = document.querySelector('.page-item.active .page-btn');
            if(activePageBtn) {
                const currentPage = parseInt(activePageBtn.getAttribute('data-page'));
                if (currentPage > 0) navigateToPage(currentPage - 1);
            }
        });
    }
    
    const btnPrevPageBottom = document.getElementById('prevPageBottom');
    if (btnPrevPageBottom) {
        btnPrevPageBottom.addEventListener('click', function() {
            const activePageBtn = document.querySelector('.page-item.active .page-btn-bottom');
            if(activePageBtn) {
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

window.updateProgress = function(idMateri, idCheckpoint) {
    console.log(`Mengirim progress ke server... Materi: ${idMateri}, Checkpoint: ${idCheckpoint}`);

    // 1. Tentukan URL (menggunakan URL langsung agar aman dari error 500)
    const endpointUrl = '/siswa/progress/update'; 

    // 2. Ambil elemen token CSRF dari HTML
    const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
    
    // Validasi apakah token ditemukan
    if (!csrfTokenElement) {
        console.error("Meta CSRF Token tidak ditemukan di tag <head> HTML!");
        return; // Hentikan proses jika token tidak ada
    }

    // 3. Eksekusi pengiriman data ke server
    fetch(endpointUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            // Ambil isi content dari elemen token tadi
            'X-CSRF-TOKEN': csrfTokenElement.getAttribute('content')
        },
        body: JSON.stringify({
            materi_id: idMateri,
            checkpoint_code: idCheckpoint
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Gagal menghubungi server! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if(data.success) {
            console.log("Progres berhasil disimpan! Total:", data.progress_percentage, "%");
            if(data.badge_earned) {
                console.log("Hore! Kamu mendapatkan badge:", data.badge_data.name);
            }
        }
    })
    .catch(error => console.error("Terjadi kesalahan saat mengirim progres:", error));
};