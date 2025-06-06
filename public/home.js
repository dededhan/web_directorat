document.addEventListener("DOMContentLoaded", function () {
    // Make sure we're selecting the correct elements
    const carousel = document.querySelector(".carousel-inner");
    const items = document.querySelectorAll(".carousel-item-enhanced");
    const carouselContainer = document.querySelector(".enhanced-carousel");

    if (carousel && items.length > 0 && carouselContainer) {
        // Create navigation buttons if they don't exist
        let prevBtn = document.querySelector(".carousel-control-prev");
        let nextBtn = document.querySelector(".carousel-control-next");

        if (!prevBtn) {
            prevBtn = document.createElement("div");
            prevBtn.className = "carousel-control carousel-control-prev";
            prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
            carouselContainer.appendChild(prevBtn);
        }

        if (!nextBtn) {
            nextBtn = document.createElement("div");
            nextBtn.className = "carousel-control carousel-control-next";
            nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
            carouselContainer.appendChild(nextBtn);
        }

        // Set up carousel variables
        let position = 0;
        const visibleItems = 3; // Always show exactly 3 items regardless of screen size
        const itemWidth = 100 / visibleItems;
        let autoSlideInterval;
        const totalSlides = items.length;

        // Set initial width of carousel items - forced to show 3 items on all screen sizes
        items.forEach((item) => {
            item.style.flex = `0 0 ${itemWidth}%`;
            item.style.maxWidth = `${itemWidth}%`;
        });

        function updateCarousel() {
            // Use transform for smooth animation
            carousel.style.transition = "transform 0.5s ease";
            carousel.style.transform = `translateX(-${position * itemWidth}%)`;

            // Update progress dots if they exist
            const dots = document.querySelectorAll(".progress-dot");
            if (dots.length > 0) {
                dots.forEach((dot, index) => {
                    dot.classList.toggle("active", index === position);
                });
            }
        }

        function nextSlide() {
            if (position < totalSlides - visibleItems) {
                position++;
            } else {
                position = 0; // Loop back to the beginning
            }
            updateCarousel();
        }

        function prevSlide() {
            if (position > 0) {
                position--;
            } else {
                position = totalSlides - visibleItems; // Loop to the end
            }
            updateCarousel();
        }

        // Add click event listeners
        prevBtn.addEventListener("click", function () {
            prevSlide();
            resetAutoSlide();
        });

        nextBtn.addEventListener("click", function () {
            nextSlide();
            resetAutoSlide();
        });

        // Create progress dots
        const progressContainer = document.createElement("div");
        progressContainer.className = "carousel-progress";

        // Calculate how many dots we need (total slides - visible slides + 1)
        const totalDots = Math.max(1, totalSlides - visibleItems + 1);

        for (let i = 0; i < totalDots; i++) {
            const dot = document.createElement("div");
            dot.className = "progress-dot" + (i === 0 ? " active" : "");
            dot.addEventListener("click", function () {
                position = i;
                updateCarousel();
                resetAutoSlide();
            });
            progressContainer.appendChild(dot);
        }

        // Add progress dots after the carousel
        carouselContainer.appendChild(progressContainer);

        // Function to start auto sliding
        function startAutoSlide() {
            // Clear any existing interval first to prevent multiple intervals
            clearInterval(autoSlideInterval);
            autoSlideInterval = setInterval(nextSlide, 5000); // Auto slide every 5 seconds
        }

        // Function to reset auto slide timer
        function resetAutoSlide() {
            clearInterval(autoSlideInterval);
            startAutoSlide();
        }

        // Start auto sliding immediately
        startAutoSlide();

        // Pause auto sliding when user hovers over the carousel
        carouselContainer.addEventListener("mouseenter", function () {
            clearInterval(autoSlideInterval);
        });

        // Resume auto sliding when user leaves the carousel
        carouselContainer.addEventListener("mouseleave", function () {
            startAutoSlide();
        });

        // Handle touch events for mobile swipe
        let touchStartX = 0;
        let touchEndX = 0;

        carouselContainer.addEventListener(
            "touchstart",
            function (e) {
                touchStartX = e.changedTouches[0].screenX;
            },
            { passive: true }
        );

        carouselContainer.addEventListener(
            "touchend",
            function (e) {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            },
            { passive: true }
        );

        function handleSwipe() {
            const minSwipeDistance = 50;
            if (touchStartX - touchEndX > minSwipeDistance) {
                // Swiped left
                nextSlide();
            } else if (touchEndX - touchStartX > minSwipeDistance) {
                // Swiped right
                prevSlide();
            }
        }

        // Force responsive layout adjustment for small screens
        function adjustForMobile() {
            // This ensures the number of visible items remains consistent across all screen sizes
            items.forEach((item) => {
                item.style.flex = `0 0 ${itemWidth}%`;
                item.style.maxWidth = `${itemWidth}%`;
            });

            // Reset position when screen size changes to avoid broken layout
            position = 0;
            updateCarousel();
        }

        // Adjust layout on window resize
        window.addEventListener("resize", adjustForMobile);

        // Initial adjustment
        adjustForMobile();
    }
});

document.addEventListener("DOMContentLoaded", function () {
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

    // Force desktop-like layout on mobile
    function forceDesktopLayout() {
        // UNJ dalam Angka - always use 6 columns
        const statsGrid = document.querySelector(
            ".unj-dalam-angka .grid-container"
        );
        if (statsGrid) {
            statsGrid.style.gridTemplateColumns = "repeat(6, 1fr)";
        }

        // Program cards - always use 4 columns
        const programGrid = document.querySelector(".program-grid");
        if (programGrid) {
            programGrid.style.gridTemplateColumns = "repeat(4, 1fr)";
        }

        // News grid - always use 3 columns
        const newsGrid = document.querySelector(
            ".grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3"
        );
        if (newsGrid) {
            newsGrid.style.gridTemplateColumns = "repeat(3, 1fr)";
        }
    }

    // Run initially and on resize
    forceDesktopLayout();
    window.addEventListener("resize", forceDesktopLayout);
});

// IMPORTANT: Removed viewport manipulation that was causing zoom issues
// The following code has been commented out to prevent viewport scaling on mobile

/*
document.addEventListener("DOMContentLoaded", function () {
    function isMobileDevice() {
        return window.innerWidth <= 767;
    }

    if (isMobileDevice()) {
        // This code was causing the zoom issue by forcing a desktop viewport on mobile
        const existingViewport = document.querySelector('meta[name="viewport"]');
        if (existingViewport) {
            existingViewport.setAttribute(
                "content",
                "width=1024, initial-scale=0.5, user-scalable=yes"
            );
        } else {
            const metaTag = document.createElement("meta");
            metaTag.name = "viewport";
            metaTag.content = "width=1024, initial-scale=0.5, user-scalable=yes";
            document.head.appendChild(metaTag);
        }
    }
});
*/

// Enhanced Carousel for both mobile and desktop (featured news section)
document.addEventListener("DOMContentLoaded", function () {
    // Make sure we're selecting the correct elements
    const carousel = document.querySelector(".carousel-inner");
    const items = document.querySelectorAll(".carousel-item-enhanced");
    const carouselContainer = document.querySelector(".enhanced-carousel");

    if (carousel && items.length > 0 && carouselContainer) {
        // Create navigation buttons if they don't exist
        let prevBtn = document.querySelector(".carousel-control-prev");
        let nextBtn = document.querySelector(".carousel-control-next");

        if (!prevBtn) {
            prevBtn = document.createElement("div");
            prevBtn.className = "carousel-control carousel-control-prev";
            prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
            carouselContainer.appendChild(prevBtn);
        }

        if (!nextBtn) {
            nextBtn = document.createElement("div");
            nextBtn.className = "carousel-control carousel-control-next";
            nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
            carouselContainer.appendChild(nextBtn);
        }

        // Set up carousel variables
        let position = 0;
        let visibleItems = 3; // Default for desktop
        let itemWidth;
        let autoSlideInterval;
        const totalSlides = items.length;

        // Function to determine visible items based on screen width
        function updateVisibleItems() {
            if (window.innerWidth < 568) {
                // Small phone screens - show 1 item
                visibleItems = 1;
            } else if (window.innerWidth < 768) {
                // Larger phones/small tablets - show 2 items
                visibleItems = 2;
            } else if (window.innerWidth < 1024) {
                // Tablets - show 2 items
                visibleItems = 2;
            } else {
                // Desktop - show 3 items
                visibleItems = 3;
            }

            // Update item widths based on visible items
            itemWidth = 100 / visibleItems;
            items.forEach((item) => {
                item.style.flex = `0 0 ${itemWidth}%`;
                item.style.maxWidth = `${itemWidth}%`;
            });

            // Make sure position is valid for new visible items count
            // (avoid empty space at the end)
            const maxPosition = Math.max(0, totalSlides - visibleItems);
            if (position > maxPosition) {
                position = maxPosition;
            }

            // Update carousel with new settings
            updateCarousel();
        }

        function updateCarousel() {
            // Use transform for smooth animation
            carousel.style.transition = "transform 0.5s ease";
            carousel.style.transform = `translateX(-${position * itemWidth}%)`;

            // Update button states
            prevBtn.style.opacity = position <= 0 ? "0.5" : "1";
            nextBtn.style.opacity =
                position >= totalSlides - visibleItems ? "0.5" : "1";
        }

        function nextSlide() {
            if (position < totalSlides - visibleItems) {
                position++;
                updateCarousel();
            } else {
                // Add a bounce effect when trying to go past the end
                carousel.style.transition = "transform 0.2s ease";
                carousel.style.transform = `translateX(-${
                    position * itemWidth + 10
                }px)`;

                setTimeout(() => {
                    carousel.style.transition = "transform 0.2s ease";
                    carousel.style.transform = `translateX(-${
                        position * itemWidth
                    }%)`;
                }, 200);
            }
        }

        function prevSlide() {
            if (position > 0) {
                position--;
                updateCarousel();
            } else {
                // Add a bounce effect when trying to go past the beginning
                carousel.style.transition = "transform 0.2s ease";
                carousel.style.transform = `translateX(10px)`;

                setTimeout(() => {
                    carousel.style.transition = "transform 0.2s ease";
                    carousel.style.transform = `translateX(0)`;
                }, 200);
            }
        }

        // Add click event listeners
        prevBtn.addEventListener("click", function () {
            prevSlide();
            resetAutoSlide();
        });

        nextBtn.addEventListener("click", function () {
            nextSlide();
            resetAutoSlide();
        });

        // Create progress dots
        const progressContainer = document.createElement("div");
        progressContainer.className = "carousel-progress";
        carouselContainer.appendChild(progressContainer);

        // Function to update the progress dots - simplified to just one dot
        function updateProgressDots() {
            // Clear existing dots
            progressContainer.innerHTML = "";

            // Just create a single dot
            const dot = document.createElement("div");
            dot.className = "progress-dot active";
            progressContainer.appendChild(dot);
        }

        // Function to start auto sliding
        function startAutoSlide() {
            // Clear any existing interval first to prevent multiple intervals
            clearInterval(autoSlideInterval);
            autoSlideInterval = setInterval(nextSlide, 5000); // Auto slide every 5 seconds
        }

        // Function to reset auto slide timer
        function resetAutoSlide() {
            clearInterval(autoSlideInterval);
            startAutoSlide();
        }

        // Handle touch events for mobile swipe
        let touchStartX = 0;
        let touchEndX = 0;

        carouselContainer.addEventListener(
            "touchstart",
            function (e) {
                // Stop auto sliding on touch
                clearInterval(autoSlideInterval);
                touchStartX = e.changedTouches[0].screenX;
            },
            { passive: true }
        );

        carouselContainer.addEventListener(
            "touchend",
            function (e) {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
                // Resume auto sliding after touch
                startAutoSlide();
            },
            { passive: true }
        );

        function handleSwipe() {
            const minSwipeDistance = 30; // Reduced distance for more responsive swipes
            if (touchStartX - touchEndX > minSwipeDistance) {
                // Swiped left
                nextSlide();
            } else if (touchEndX - touchStartX > minSwipeDistance) {
                // Swiped right
                prevSlide();
            }
        }

        // Pause auto sliding when user hovers over the carousel (desktop only)
        carouselContainer.addEventListener("mouseenter", function () {
            clearInterval(autoSlideInterval);
        });

        // Resume auto sliding when user leaves the carousel
        carouselContainer.addEventListener("mouseleave", function () {
            startAutoSlide();
        });

        // Listen for window resize events to update the carousel
        window.addEventListener("resize", function () {
            // Debounce resize events
            clearTimeout(window.resizeTimeout);
            window.resizeTimeout = setTimeout(function () {
                updateVisibleItems();
                updateProgressDots();
            }, 250);
        });

        // Initial setup
        updateVisibleItems();
        updateProgressDots();
        startAutoSlide();
    }
});

function initHeaderCarousel(images) {
    // Get the header element
    const header = document.querySelector("header");
    if (!header) return;

    // Check if header already has a carousel
    if (header.querySelector(".header-carousel")) return;

    // Create carousel container
    const carouselContainer = document.createElement("div");
    carouselContainer.className = "header-carousel";

    // Create slides
    const slidesContainer = document.createElement("div");
    slidesContainer.className = "header-carousel-slides";

    // Add slides with images
    images.forEach((imgSrc, index) => {
        const slide = document.createElement("div");
        slide.className = `header-slide ${index === 0 ? "active" : ""}`;

        const img = document.createElement("img");
        img.src = imgSrc;
        img.alt = `Universitas Negeri Jakarta campus view ${index + 1}`;
        img.className = "w-full h-screen object-cover";

        slide.appendChild(img);
        slidesContainer.appendChild(slide);
    });

    // Create navigation dots
    const dotsContainer = document.createElement("div");
    dotsContainer.className = "header-carousel-dots";

    images.forEach((_, index) => {
        const dot = document.createElement("span");
        dot.className = `header-carousel-dot ${index === 0 ? "active" : ""}`;
        dot.setAttribute("data-index", index);
        dotsContainer.appendChild(dot);
    });

    // Add all elements to the carousel container
    carouselContainer.appendChild(slidesContainer);
    carouselContainer.appendChild(dotsContainer);

    // Find the overlay or create one if it doesn't exist
    let overlay = header.querySelector(".absolute.inset-0");

    // Clear existing content from header
    const currentImg = header.querySelector("img");
    if (currentImg) currentImg.remove();

    // Insert carousel before overlay if it exists, otherwise append to header
    if (overlay) {
        header.insertBefore(carouselContainer, overlay);
    } else {
        header.appendChild(carouselContainer);
    }

    // Carousel functionality
    let currentSlide = 0;
    const totalSlides = images.length;
    let autoplayInterval;

    // Function to show a specific slide
    function showSlide(index) {
        // Handle bounds
        if (index >= totalSlides) index = 0;
        if (index < 0) index = totalSlides - 1;

        // Update current slide
        currentSlide = index;

        // Update slides
        const slides = document.querySelectorAll(".header-slide");
        slides.forEach((slide, i) => {
            slide.classList.toggle("active", i === currentSlide);
        });

        // Update dots
        const dots = document.querySelectorAll(".header-carousel-dot");
        dots.forEach((dot, i) => {
            dot.classList.toggle("active", i === currentSlide);
        });
    }

    // Navigate to next slide
    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    // Navigate to previous slide
    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    // Add event listeners for dots
    document.querySelectorAll(".header-carousel-dot").forEach((dot) => {
        dot.addEventListener("click", () => {
            const index = parseInt(dot.getAttribute("data-index"));
            showSlide(index);
            resetAutoplay();
        });
    });

    // Autoplay functionality
    function startAutoplay() {
        autoplayInterval = setInterval(nextSlide, 10000); // Change slide every 10 seconds
    }

    function resetAutoplay() {
        clearInterval(autoplayInterval);
        startAutoplay();
    }

    // Start autoplay
    startAutoplay();

    // Pause autoplay on hover
    carouselContainer.addEventListener("mouseenter", () => {
        clearInterval(autoplayInterval);
    });

    carouselContainer.addEventListener("mouseleave", () => {
        startAutoplay();
    });

    // Add touch swipe support
    let touchStartX = 0;
    let touchEndX = 0;

    carouselContainer.addEventListener(
        "touchstart",
        (e) => {
            touchStartX = e.changedTouches[0].screenX;
        },
        { passive: true }
    );

    carouselContainer.addEventListener(
        "touchend",
        (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        },
        { passive: true }
    );

    function handleSwipe() {
        const swipeThreshold = 50;
        if (touchEndX < touchStartX - swipeThreshold) {
            // Swiped left, go to next slide
            nextSlide();
            resetAutoplay();
        } else if (touchEndX > touchStartX + swipeThreshold) {
            // Swiped right, go to previous slide
            prevSlide();
            resetAutoplay();
        }
    }
}

// Wait for DOM to load
document.addEventListener("DOMContentLoaded", function () {
    const defaultImages = [];
    fetch("/api/carousel-images")
        .then((response) => response.json())
        .then((data) => {
            const galleryImages = data.map((item) => "/storage/" + item.image);
            if (data && data.length > 0) {
                const galleryImages = data.map(
                    (item) => "/storage/" + item.image
                );
                initHeaderCarousel(galleryImages);
                console.log(
                    "Carousel initialized with gallery images:",
                    galleryImages
                );
            } else {
                // Otherwise use default images
                initHeaderCarousel(defaultImages);
                console.log("No gallery images found, using defaults");
            }
        })
        .catch((error) => {
            console.error("Error fetching carousel images:", error);
            // Use default images on error
            initHeaderCarousel(defaultImages);
        });
});

    // Check if Font Awesome is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Function to check if Font Awesome is loaded
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

        // If Font Awesome is not loaded, add it
        if (!isFontAwesomeLoaded()) {
            console.log('Font Awesome not detected, adding it');
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css';
            document.head.appendChild(link);
        }
        
        // Fallback solution if icons still don't appear
        setTimeout(function() {
            const icons = document.querySelectorAll('.prestasi-icon i');
            const fallbackIcons = {
                'fa-user-graduate': '👨‍🎓',
                'fa-globe': '🌎',
                'fa-chalkboard-teacher': '👨‍🏫',
                'fa-user-tie': '👨‍💼',
                'fa-users': '👥',
                'fa-user-cog': '👨‍🔧',
                'fa-university': '🏛️',
                'fa-graduation-cap': '🎓',
                'fa-th-large': '📋',
                'fa-book': '📚',
                'fa-file-alt': '📄',
                'fa-certificate': '🏅'
            };
            
            icons.forEach(function(icon) {
                if (getComputedStyle(icon, ':before').content === 'none' || 
                    getComputedStyle(icon, ':before').content === '') {
                    // Find which icon class is applied
                    for (const [iconClass, emoji] of Object.entries(fallbackIcons)) {
                        if (icon.classList.contains(iconClass)) {
                            // Use emoji as fallback
                            icon.textContent = emoji;
                            break;
                        }
                    }
                    // Default fallback
                    if (icon.textContent === '') {
                        icon.textContent = '🔣';
                    }
                }
            });
        }, 1000);
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Function to animate counting up
        function animateCountUp(el) {
            const target = parseInt(el.innerText.replace(/[.,]/g, ''));
            const duration = 2000; // Duration in milliseconds
            const step = Math.ceil(target / (duration / 16)); // ~60fps
            let current = 0;
            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    el.innerText = target.toLocaleString('id-ID');
                    clearInterval(timer);
                } else {
                    el.innerText = current.toLocaleString('id-ID');
                }
            }, 16);
        }
        
        // Check if an element is in viewport
        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }
        
        // Get all number elements
        const numberElements = document.querySelectorAll('.prestasi-number, .akreditasi-number');
        let animated = false;
        
        // Function to check scroll position and animate if in viewport
        function checkScroll() {
            if (animated) return;
            
            const section = document.querySelector('.unj-prestasi-container');
            if (isInViewport(section)) {
                numberElements.forEach(el => {
                    // Skip if it's "Prodi" text in the number
                    if (el.innerText.includes('Prodi')) {
                        // Extract the number part
                        const numText = el.innerText.split(' ')[0];
                        const num = parseInt(numText.replace(/[.,]/g, ''));
                        
                        // Animate just the number
                        const originalText = el.innerText;
                        const countUp = (current) => {
                            if (current <= num) {
                                el.innerText = current + ' ' + originalText.split(' ').slice(1).join(' ');
                                setTimeout(() => countUp(current + Math.ceil(num/50)), 30);
                            }
                        };
                        countUp(0);
                    } else {
                        animateCountUp(el);
                    }
                });
                animated = true;
            }
        }
        
        // Listen for scroll events
        window.addEventListener('scroll', checkScroll);
        
        // Check on initial load too
        checkScroll();
    });