/**
 * Perbaikan untuk memastikan fungsi mobile.js dijalankan dengan benar
 * Tambahkan kode ini di bagian bawah file mobile.js yang ada 
 * ATAU tambahkan sebagai file baru dan panggil setelah mobile.js
 */

// Segera deteksi perangkat mobile saat script dimuat
const _isMobileDevice = (function() {
    // Deteksi dengan beberapa metode
    const userAgent = navigator.userAgent.toLowerCase();
    const mobileKeywords = /android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i;
    const isMobileUA = mobileKeywords.test(userAgent);
    const isMobileWidth = window.innerWidth <= 768;
    const hasTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
    
    // Kembalikan true jika setidaknya dua kriteria terpenuhi
    return (isMobileUA && hasTouch) || (isMobileWidth && hasTouch) || (isMobileUA && isMobileWidth);
})();

// Fungsi perbaikan untuk layout mobile
function fixMobileLayout() {
    if (!_isMobileDevice) return;
    
    console.log('Applying mobile layout fixes');
    
    // Tambahkan class mobile-mode ke body
    document.body.classList.add('mobile-mode');
    
    // Perbaikan grid layout untuk mobile
    const grids = document.querySelectorAll('.grid');
    if (window.innerWidth <= 768) {
        grids.forEach(grid => {
            // Ubah grid multi-kolom menjadi satu kolom untuk mobile
            if (grid.classList.contains('md:grid-cols-2') || 
                grid.classList.contains('lg:grid-cols-3') ||
                grid.classList.contains('md:grid-cols-3')) {
                grid.style.display = 'grid';
                grid.style.gridTemplateColumns = '1fr';
                grid.style.gap = '1rem';
            }
        });
    }
    
    // Perbaikan carousel untuk mobile
    const carousels = document.querySelectorAll('.carousel-inner');
    carousels.forEach(carousel => {
        carousel.style.display = 'flex';
        carousel.style.overflowX = 'auto';
        carousel.style.webkitOverflowScrolling = 'touch';
        carousel.style.scrollSnapType = 'x mandatory';
        carousel.style.paddingBottom = '15px';
        
        // Atur ukuran item carousel
        const items = carousel.querySelectorAll('.carousel-item-enhanced');
        items.forEach(item => {
            item.style.flex = '0 0 90%';
            item.style.maxWidth = '90%';
            item.style.marginRight = '10px';
            item.style.scrollSnapAlign = 'start';
        });
    });
    
    // Perbaikan ukuran card
    const mediaCards = document.querySelectorAll('.media-card');
    mediaCards.forEach(card => {
        card.style.height = 'auto';
    });
    
    // Perbaikan gambar untuk tidak overflow
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.style.maxWidth = '100%';
        img.style.height = 'auto';
    });
    
    // Perbaikan untuk modal pada mobile
    const modal = document.getElementById('programDetailsModal');
    if (modal) {
        modal.style.padding = '0';
        
        const modalContent = modal.querySelector('.bg-white');
        if (modalContent) {
            // Untuk tampilan modal full-bottom pada mobile
            modalContent.addEventListener('click', function(e) {
                e.stopPropagation(); // Prevent modal from closing when content is clicked
            });
        }
    }
    
    // Perbaikan spacing untuk mobile
    if (window.innerWidth <= 480) {
        // Atur padding pada elemen dengan class p-6, p-5
        document.querySelectorAll('.p-6, .p-5').forEach(el => {
            el.style.padding = '0.75rem';
        });
        
        // Atur margin pada elemen dengan class mb-12, mb-16
        document.querySelectorAll('.mb-12, .mb-16').forEach(el => {
            el.style.marginBottom = '1.5rem';
        });
        
        // Atur padding pada elemen dengan class py-16, py-12
        document.querySelectorAll('.py-16').forEach(el => {
            el.style.paddingTop = '2rem';
            el.style.paddingBottom = '2rem';
        });
        
        document.querySelectorAll('.py-12').forEach(el => {
            el.style.paddingTop = '1.5rem';
            el.style.paddingBottom = '1.5rem';
        });
    }
}

// Panggil fungsi saat DOM selesai dimuat
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', fixMobileLayout);
} else {
    // Jika DOMContentLoaded sudah terjadi
    fixMobileLayout();
}

// Panggil ulang saat window di-resize
window.addEventListener('resize', function() {
    fixMobileLayout();
});

// Panggil ulang saat orientasi berubah
window.addEventListener('orientationchange', function() {
    setTimeout(fixMobileLayout, 200);
});

// Pastikan fungsi berjalan dengan baik meskipun mobile.js utama gagal
window.mobileFixesApplied = true;