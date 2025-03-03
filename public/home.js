document.addEventListener('DOMContentLoaded', function() {
    // Make sure we're selecting the correct elements
    const carousel = document.querySelector('.carousel-inner');
    const items = document.querySelectorAll('.carousel-item-enhanced');
    const carouselContainer = document.querySelector('.enhanced-carousel');
    
    // Create navigation buttons if they don't exist
    let prevBtn = document.querySelector('.carousel-control-prev');
    let nextBtn = document.querySelector('.carousel-control-next');
    
    if (!prevBtn) {
        prevBtn = document.createElement('div');
        prevBtn.className = 'carousel-control carousel-control-prev';
        prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
        carouselContainer.appendChild(prevBtn);
    }
    
    if (!nextBtn) {
        nextBtn = document.createElement('div');
        nextBtn.className = 'carousel-control carousel-control-next';
        nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
        carouselContainer.appendChild(nextBtn);
    }
    
    // Set up carousel variables
    let position = 0;
    const visibleItems = 3; // Always show exactly 3 items
    const itemWidth = 100 / visibleItems;
    let autoSlideInterval;
    const totalSlides = items.length;
    
    // Set initial width of carousel items
    items.forEach(item => {
        item.style.flex = `0 0 ${itemWidth}%`;
        item.style.maxWidth = `${itemWidth}%`;
    });
    
    function updateCarousel() {
        // Use transform for smooth animation
        carousel.style.transition = 'transform 0.5s ease';
        carousel.style.transform = `translateX(-${position * itemWidth}%)`;
        
        // Update progress dots if they exist
        const dots = document.querySelectorAll('.progress-dot');
        if (dots.length > 0) {
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === position);
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
    prevBtn.addEventListener('click', function() {
        prevSlide();
        resetAutoSlide();
    });
    
    nextBtn.addEventListener('click', function() {
        nextSlide();
        resetAutoSlide();
    });
    
    // Create progress dots
    const progressContainer = document.createElement('div');
    progressContainer.className = 'carousel-progress';
    
    // Calculate how many dots we need (total slides - visible slides + 1)
    const totalDots = Math.max(1, totalSlides - visibleItems + 1);
    
    for (let i = 0; i < totalDots; i++) {
        const dot = document.createElement('div');
        dot.className = 'progress-dot' + (i === 0 ? ' active' : '');
        dot.addEventListener('click', function() {
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
        console.log("Auto slide started"); // Debug message
    }
    
    // Function to reset auto slide timer
    function resetAutoSlide() {
        clearInterval(autoSlideInterval);
        startAutoSlide();
    }
    
    // Start auto sliding immediately
    startAutoSlide();
    
    // Pause auto sliding when user hovers over the carousel
    carouselContainer.addEventListener('mouseenter', function() {
        clearInterval(autoSlideInterval);
        console.log("Auto slide paused"); // Debug message
    });
    
    // Resume auto sliding when user leaves the carousel
    carouselContainer.addEventListener('mouseleave', function() {
        startAutoSlide();
    });
    
    // Debug output to confirm the script is running
    console.log("Carousel initialized with " + totalSlides + " slides");
    console.log("Showing " + visibleItems + " items at once");
});

document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.querySelector('.navbar');
    const scrollThreshold = 50; // Jarak scroll untuk mengubah warna navbar

    let isScrolling;

    window.addEventListener('scroll', function () {
        // Batasi frekuensi pemanggilan fungsi dengan requestAnimationFrame
        window.cancelAnimationFrame(isScrolling);

        isScrolling = window.requestAnimationFrame(function () {
            if (window.scrollY > scrollThreshold) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const socialMediaBar = document.querySelector('.social-media-bar');
    const scrollThreshold = 100; // Jarak scroll untuk menyembunyikan bar

    window.addEventListener('scroll', function () {
        if (window.scrollY > scrollThreshold) {
            socialMediaBar.classList.add('hidden');
        } else {
            socialMediaBar.classList.remove('hidden');
        }
    });
});
document.addEventListener('click', function (event) {
    const loginPopup = document.querySelector('.login-popup');
    if (!loginPopup.contains(event.target) && event.target.id !== 'openLoginBtn') {
        loginPopup.style.display = 'none';
    }
});
