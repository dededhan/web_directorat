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

    // --- Fetch Instagram Posts ---
    const instaContainer = document.getElementById('instagram-api-feed-container');
    if (instaContainer) {
        fetch('/api/instagram-posts')
            .then(response => response.json())
            .then(posts => {
                instaContainer.innerHTML = ''; 
                if (!posts || posts.length === 0) {
                    instaContainer.innerHTML = '<p class="col-span-full text-center text-gray-500">Gagal memuat post Instagram.</p>';
                    return;
                }
                posts.slice(0, 3).forEach(post => {
                    const postDate = new Date(post.posted_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
                    const card = `
                        <a href="${post.permalink}" target="_blank" class="group block bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                            <div class="relative">
                                <img src="${post.media_url}" alt="${post.title || 'Instagram Post'}" class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 p-4 text-white">
                                    <h3 class="font-bold text-lg">${post.title || 'Postingan Instagram'}</h3>
                                    <p class="text-sm opacity-90">${postDate}</p>
                                </div>
                            </div>
                        </a>`;
                    instaContainer.innerHTML += card;
                });
            })
            .catch(error => {
                console.error('Error fetching Instagram posts:', error);
                instaContainer.innerHTML = '<p class="col-span-full text-center text-gray-500">Gagal memuat post Instagram.</p>';
            });
    }

    // --- Fetch YouTube Videos ---
    const videoContainer = document.getElementById('dynamic-videos-container');
    if (videoContainer) {
        fetch('/api/youtube-videos')
            .then(response => response.json())
            .then(videos => {
                videoContainer.innerHTML = '';
                if (!videos || videos.length === 0) {
                    videoContainer.innerHTML = '<p class="col-span-full text-center text-gray-500">Belum ada video tersedia.</p>';
                    return;
                }
                videos.slice(0, 3).forEach(video => {
                    let videoId = '';
                    try {
                        if (video.link.includes('youtu.be/')) {
                            videoId = new URL(video.link).pathname.substring(1);
                        } else {
                            videoId = new URL(video.link).searchParams.get('v');
                        }
                    } catch (e) { console.error('Invalid YouTube URL:', video.link); return; }
                    
                    if (!videoId) return;

                    const thumbnailUrl = `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;
                    const card = `
                        <a href="${video.link}" target="_blank" class="group block bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                            <div class="relative">
                                <img src="${thumbnailUrl}" alt="${video.judul}" class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                    <i class="fab fa-youtube text-white text-5xl opacity-80 group-hover:opacity-100 group-hover:scale-110 transition-all"></i>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-gray-800 group-hover:text-teal-600 transition-colors">${video.judul}</h3>
                            </div>
                        </a>`;
                    videoContainer.innerHTML += card;
                });
            })
            .catch(error => {
                console.error('Error fetching YouTube videos:', error);
                videoContainer.innerHTML = '<p class="col-span-full text-center text-gray-500">Gagal memuat video.</p>';
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
