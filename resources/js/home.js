document.addEventListener("DOMContentLoaded", function () {
    // Efek scroll untuk navbar
    const navbar = document.querySelector(".navbar");
    if (navbar) {
        const scrollThreshold = 50;
        let isScrolling;

        window.addEventListener("scroll", function () {
            window.cancelAnimationFrame(isScrolling);

            isScrolling = window.requestAnimationFrame(function () {
                if (window.scrollY > scrollThreshold) {
                    navbar.classList.add("scrolled");
                } else {
                    navbar.classList.remove("scrolled");
                }
            });
        });
    }

    // Fungsi untuk inisialisasi Header Carousel (gambar besar di atas)
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
            const img = document.createElement("img");
            img.src = imgSrc;
            img.alt = `Universitas Negeri Jakarta campus view ${index + 1}`;
            slide.appendChild(img);
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
        if (overlay) {
            header.insertBefore(carouselContainer, overlay);
        } else {
            header.appendChild(carouselContainer);
        }

        let currentSlide = 0;
        const totalSlides = images.length;
        let autoplayInterval;

        function showSlide(index) {
            currentSlide = (index + totalSlides) % totalSlides;
            slidesContainer.querySelectorAll(".header-slide").forEach((slide, i) => {
                slide.classList.toggle("active", i === currentSlide);
            });
            dotsContainer.querySelectorAll(".header-carousel-dot").forEach((dot, i) => {
                dot.classList.toggle("active", i === currentSlide);
            });
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

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

    // Fetch gambar untuk Header Carousel dari API
    const defaultImages = [
        "https://media.quipper.com/media/W1siZiIsIjIwMTgvMDEvMjMvMDkvNDMvMjcvYWVjNTQ1OTctOTJiNi00Y2EyLWEzZDctMGZiNTg1ZTU1MDEzLyJdLFsicCIsInRodW1iIiwiMTIwMHhcdTAwM2UiLHt9XSxbInAiLCJjb252ZXJ0IiwiLWNvbGG9yc3BhY2Ugc1JHQiAtc3RyaXAiLHsiZm9ybWF0IjoianBnIn1dXQ?sha=9c61a35270604434",
        "https://www.unj.ac.id/wp-content/uploads/2020/02/DJI_0007-1024x576.jpg",
        "https://cdns.klimg.com/merdeka.com/i/w/news/2023/07/20/1578964/670x335/potret-gedung-baru-unj-yang-megah-dan-modern-berkonsep-green-building-dan-smart-building.jpg"
    ];

    fetch("/api/carousel-images")
        .then(response => {
            if (!response.ok) throw new Error('API response not OK');
            return response.json();
        })
        .then(data => {
            const galleryImages = data.map(item => "/storage/" + item.image);
            if (galleryImages.length > 0) {
                initHeaderCarousel(galleryImages);
            } else {
                initHeaderCarousel(defaultImages);
            }
        })
        .catch(error => {
            console.error("Error fetching carousel images, using defaults:", error);
            initHeaderCarousel(defaultImages);
        });

    // Pengecekan dan fallback untuk Font Awesome Icons
    function isFontAwesomeLoaded() {
        const span = document.createElement('span');
        span.className = 'fa';
        span.style.display = 'none';
        document.body.insertBefore(span, document.body.firstChild);
        const beforeStyle = window.getComputedStyle(span, ':before');
        const loaded = beforeStyle.getPropertyValue('font-family').includes('Font');
        document.body.removeChild(span);
        return loaded;
    }

    if (!isFontAwesomeLoaded()) {
        console.log('Font Awesome not detected, adding it');
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css';
        document.head.appendChild(link);
    }

    // Animasi hitung angka untuk seksi "UNJ dalam Prestasi"
    function animateCountUp(el) {
        const target = parseInt(el.innerText.replace(/[.,]/g, ''));
        if (isNaN(target)) return;
        const duration = 2000;
        const stepTime = 16;
        const totalSteps = duration / stepTime;
        const step = Math.max(1, Math.ceil(target / totalSteps));
        let current = 0;

        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                el.innerText = target.toLocaleString('id-ID');
                clearInterval(timer);
            } else {
                el.innerText = current.toLocaleString('id-ID');
            }
        }, stepTime);
    }

    function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top < window.innerHeight && rect.bottom >= 0
        );
    }

    const numberElements = document.querySelectorAll('.prestasi-number, .akreditasi-number');
    let animated = false;

    function checkScrollAndAnimate() {
        if (animated) {
            window.removeEventListener('scroll', checkScrollAndAnimate);
            return;
        }

        const section = document.querySelector('.unj-prestasi-container');
        if (section && isInViewport(section)) {
            numberElements.forEach(animateCountUp);
            animated = true;
        }
    }

    window.addEventListener('scroll', checkScrollAndAnimate);
    checkScrollAndAnimate(); // Cek juga saat pertama kali load
});