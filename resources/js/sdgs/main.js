import initSdgCarousel from './sdg-carousel.js';
import initHeroSlider from './hero-slider.js';
import initDynamicContent from './dynamic-content.js';

// Menjalankan semua skrip setelah halaman (DOM) selesai dimuat
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi setiap modul
    initHeroSlider();
    initSdgCarousel();
    initDynamicContent();
});
