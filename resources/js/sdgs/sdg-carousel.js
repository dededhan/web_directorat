/**
 * Inisialisasi Carousel Fullscreen untuk SDG.
 * Mengelola perpindahan slide dan navigasi dot.
 */
export default function initSdgCarousel() {
    const sdgsSection = document.getElementById('goals');
    if (!sdgsSection) return;

    const sliderContainer = sdgsSection.querySelector('.sdgs-slider-container');
    const navDots = sdgsSection.querySelectorAll('.sdgs-pagination-number');
    
    // Pastikan elemen ada sebelum melanjutkan
    if (!sliderContainer || !navDots.length) return;

    const totalSlides = navDots.length;
    let currentIndex = 0;
    let autoPlayInterval;

    function goToSlide(index) {
        if (index < 0 || index >= totalSlides) return;
        
        sliderContainer.style.transform = `translateX(-${index * 100}%)`;

        navDots.forEach(dot => dot.classList.remove('active'));
        navDots[index].classList.add('active');

        currentIndex = index;
    }

    function nextSlide() {
        const nextIndex = (currentIndex + 1) % totalSlides;
        goToSlide(nextIndex);
    }

    navDots.forEach(dot => {
        dot.addEventListener('click', () => {
            goToSlide(parseInt(dot.dataset.index));
            resetAutoPlay();
        });
    });

    function startAutoPlay() {
        autoPlayInterval = setInterval(nextSlide, 7000); // Ganti slide setiap 7 detik
    }

    function resetAutoPlay() {
        clearInterval(autoPlayInterval);
        startAutoPlay();
    }

    // Inisialisasi slide pertama dan autoplay
    goToSlide(0);
    startAutoPlay();
}
