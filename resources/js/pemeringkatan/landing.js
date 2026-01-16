// Landing Page JavaScript - Extracted from landing.blade.php

document.addEventListener('DOMContentLoaded', function () {
    
    // --- Navbar Scroll Effect - IMPROVED untuk mempertahankan warna teal ---
    const navbar = document.querySelector('.navbar.hidden.md\\:block');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }, { passive: true });
    }
    
    // --- SEMUA LOGIKA JAVASCRIPT UNTUK SIDEBAR TELAH DIHAPUS DARI SINI ---
    // --- KARENA SUDAH ADA DI FILE navbarpemeringkatan.blade.php ---

    // --- Swiper Carousel for Programs ---
    const programCarouselElement = document.querySelector('.program-carousel');
    if (programCarouselElement) {
        new Swiper('.program-carousel', {
            loop: true,
            spaceBetween: 24,
            autoplay: { delay: 3000, disableOnInteraction: false },
            pagination: { el: '.program-carousel-container .swiper-pagination', clickable: true },
            navigation: { nextEl: '.program-carousel-container .swiper-button-next', prevEl: '.program-carousel-container .swiper-button-prev' },
            breakpoints: {
                320: { slidesPerView: 1, spaceBetween: 16 },
                768: { slidesPerView: 2, spaceBetween: 20 },
                1024: { slidesPerView: 3, spaceBetween: 24 },
            },
            observer: true,
            observeParents: true,
        });
    }

    // --- Swiper Carousel for Featured News ---
    const newsCarouselElement = document.querySelector('.news-carousel');
    if (newsCarouselElement) {
        new Swiper('.news-carousel', {
            loop: true,
            spaceBetween: 24,
            autoplay: { delay: 3500, disableOnInteraction: false },
            pagination: { el: '.news-carousel-container .swiper-pagination', clickable: true },
            navigation: { nextEl: '.news-carousel-container .swiper-button-next', prevEl: '.news-carousel-container .swiper-button-prev' },
            breakpoints: {
                320: { slidesPerView: 1, spaceBetween: 16 },
                768: { slidesPerView: 2, spaceBetween: 20 },
                1024: { slidesPerView: 3, spaceBetween: 24 },
            },
            observer: true,
            observeParents: true,
        });
    }

    // --- Swiper Carousel for Sustainability ---
    const sustainabilityCarouselElement = document.querySelector('.sustainability-carousel');
    if (sustainabilityCarouselElement) {
        new Swiper('.sustainability-carousel', {
            loop: true,
            spaceBetween: 24,
            autoplay: { delay: 4000, disableOnInteraction: false },
            pagination: { el: '.sustainability-carousel .swiper-pagination', clickable: true },
            navigation: { nextEl: '.sustainability-carousel .swiper-button-next', prevEl: '.sustainability-carousel .swiper-button-prev' },
            breakpoints: {
                320: { slidesPerView: 1, spaceBetween: 16 },
                768: { slidesPerView: 2, spaceBetween: 20 },
                1024: { slidesPerView: 3, spaceBetween: 24 },
            },
            observer: true,
            observeParents: true,
        });
    }

    // --- Swiper Carousel for Alumni ---
    const alumniCarouselElement = document.querySelector('.alumni-carousel');
    if (alumniCarouselElement) {
        new Swiper('.alumni-carousel', {
            loop: true,
            spaceBetween: 24,
            autoplay: { delay: 4500, disableOnInteraction: false },
            pagination: { el: '.alumni-carousel .swiper-pagination', clickable: true },
            navigation: { nextEl: '.alumni-carousel .swiper-button-next', prevEl: '.alumni-carousel .swiper-button-prev' },
            breakpoints: {
                320: { slidesPerView: 1, spaceBetween: 16 },
                768: { slidesPerView: 2, spaceBetween: 20 },
                1024: { slidesPerView: 3, spaceBetween: 24 },
            },
            observer: true,
            observeParents: true,
        });
    }

    // --- Header Carousel Logic ---
    function initHeaderCarousel(images) {
        const header = document.querySelector("header");
        if (!header || header.querySelector(".header-carousel")) return;

        const carouselContainer = document.createElement("div");
        carouselContainer.className = "header-carousel";

        const slidesContainer = document.createElement("div");
        slidesContainer.className = "header-carousel-slides";
        images.forEach((imgSrc, index) => {
            const slide = document.createElement("div");
            slide.className = `header-slide ${index === 0 ? "active" : ""}`;
            slide.innerHTML = `<img src="${imgSrc}" alt="UNJ Campus View ${index + 1}">`;
            slidesContainer.appendChild(slide);
        });

        const dotsContainer = document.createElement("div");
        dotsContainer.className = "header-carousel-dots";
        images.forEach((_, index) => {
            const dot = document.createElement("span");
            dot.className = `header-carousel-dot ${index === 0 ? "active" : ""}`;
            dot.dataset.index = index;
            dotsContainer.appendChild(dot);
        });

        carouselContainer.appendChild(slidesContainer);
        carouselContainer.appendChild(dotsContainer);
        
        const overlay = header.querySelector(".absolute.inset-0");
        header.insertBefore(carouselContainer, overlay);

        let currentSlide = 0;
        const totalSlides = images.length;
        let autoplayInterval;

        function showSlide(index) {
            currentSlide = (index + totalSlides) % totalSlides;
            slidesContainer.querySelectorAll(".header-slide").forEach((s, i) => s.classList.toggle("active", i === currentSlide));
            dotsContainer.querySelectorAll(".header-carousel-dot").forEach((d, i) => d.classList.toggle("active", i === currentSlide));
        }

        function nextSlide() { showSlide(currentSlide + 1); }

        function resetAutoplay() {
            clearInterval(autoplayInterval);
            autoplayInterval = setInterval(nextSlide, 5000);
        }

        dotsContainer.addEventListener("click", (e) => {
            if (e.target.matches(".header-carousel-dot")) {
                showSlide(parseInt(e.target.dataset.index));
                resetAutoplay();
            }
        });
        resetAutoplay();
    }

    const defaultImages = [
        "https://media.quipper.com/media/W1siZiIsIjIwMTgvMDEvMjMvMDkvNDMvMjcvYWVjNTQ1OTctOTJiNi00Y2EyLWEzZDctMGZiNTg1ZTU1MDEzLyJdLFsicCIsInRodW1iIiwiMTIwMHhcdTAwM2UiLHt9XSxbInAiLCJjb252ZXJ0IiwiLWNvbG9yc3BhY2Ugc1JHQiAtc3RyaXAiLHsiZm9ybWF0IjoianBnIn1dXQ?sha=9c61a35270604434",
        "https://www.unj.ac.id/wp-content/uploads/2020/02/DJI_0007-1024x576.jpg",
        "https://cdns.klimg.com/merdeka.com/i/w/news/2023/07/20/1578964/670x335/potret-gedung-baru-unj-yang-megah-dan-modern-berkonsep-green-building-dan-smart-building.jpg"
    ];

    fetch("/api/carousel-images")
        .then(response => response.ok ? response.json() : Promise.reject('API response not OK'))
        .then(data => {
            const galleryImages = data.map(item => "/storage/" + item.image);
            initHeaderCarousel(galleryImages.length > 0 ? galleryImages : defaultImages);
        })
        .catch(error => {
            console.error("Error fetching carousel images, using defaults:", error);
            initHeaderCarousel(defaultImages);
        });
});
