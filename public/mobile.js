/* mobile.js - Specific functionality for mobile devices */

document.addEventListener('DOMContentLoaded', function() {
    // Only run this code on mobile devices
    if (window.innerWidth <= 767) {
        // Set proper viewport for mobile
        setupMobileViewport();
        
        // Optimize carousels for mobile
        initMobileCarousels();
        
        // Improve tap target performance
        optimizeTapTargets();
        
        // Optimize scrolling performance
        improveScrollPerformance();
        
        // Fix any Android-specific issues
        applyAndroidFixes();
        
        // Initialize lazy loading for images
        initLazyLoading();
    }
    
    // Always listen for orientation changes
    window.addEventListener('orientationchange', handleOrientationChange);
});

/**
 * Sets up the proper viewport for mobile devices
 */
function setupMobileViewport() {
    const existingViewport = document.querySelector('meta[name="viewport"]');
    if (existingViewport) {
        // Ensure proper viewport settings for mobile
        existingViewport.setAttribute('content', 'width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes');
    }
}

/**
 * Optimize carousels for mobile viewing
 */
function initMobileCarousels() {
    // Handle enhanced carousel
    const enhancedCarousel = document.querySelector('.enhanced-carousel');
    if (enhancedCarousel) {
        const items = enhancedCarousel.querySelectorAll('.carousel-item-enhanced');
        const carousel = enhancedCarousel.querySelector('.carousel-inner');
        
        // Set proper item width based on screen orientation
        const isLandscape = window.innerWidth > window.innerHeight;
        const itemsPerView = isLandscape ? 2 : 1;
        const itemWidth = 100 / itemsPerView;
        
        // Apply width to all items
        items.forEach(item => {
            item.style.flex = `0 0 ${itemWidth}%`;
            item.style.maxWidth = `${itemWidth}%`;
        });
        
        // Ensure proper transition speed for smoother experience
        if (carousel) {
            carousel.style.transition = 'transform 0.4s ease';
        }
    }
    
    // Handle header carousel
    const headerCarousel = document.querySelector('.header-carousel');
    if (headerCarousel) {
        // Reduce autoplay time for better mobile experience
        if (window.headerCarouselAutoplay) {
            clearInterval(window.headerCarouselAutoplay);
            window.headerCarouselAutoplay = setInterval(() => {
                const nextSlideEvent = new Event('nextSlide');
                headerCarousel.dispatchEvent(nextSlideEvent);
            }, 4000); // Faster changing on mobile
        }
    }
}

/**
 * Optimize tap targets for better mobile interaction
 */
function optimizeTapTargets() {
    // Find all clickable elements
    const clickableElements = document.querySelectorAll('a, button, .card-link, .news-link, [role="button"]');
    
    // Ensure they have adequate size for tapping
    clickableElements.forEach(el => {
        const rect = el.getBoundingClientRect();
        if (rect.height < 44 || rect.width < 44) {
            // Add padding if the element is too small
            el.style.padding = el.style.padding || '0.5rem';
            el.style.minHeight = '44px';
            el.style.display = 'inline-flex';
            el.style.alignItems = 'center';
        }
    });
}

/**
 * Improve scrolling performance on mobile
 */
function improveScrollPerformance() {
    // Optimize heavy elements that might cause scroll jank
    const heavyElements = document.querySelectorAll('.carousel, .header-carousel, .grid, iframe');
    
    heavyElements.forEach(el => {
        // Apply will-change for elements that will animate
        if (el.classList.contains('carousel') || el.classList.contains('header-carousel')) {
            el.style.willChange = 'transform';
        }
        
        // Apply hardware acceleration
        el.style.transform = 'translateZ(0)';
        el.style.webkitTransform = 'translateZ(0)';
    });
    
    // Fix for smooth scrolling
    document.addEventListener('touchstart', function() {}, {passive: true});
}

/**
 * Apply fixes specific to Android devices
 */
function applyAndroidFixes() {
    // Detect Android
    const isAndroid = navigator.userAgent.toLowerCase().indexOf('android') > -1;
    
    if (isAndroid) {
        // Fix for input fields on Android
        const inputFields = document.querySelectorAll('input, textarea, select');
        inputFields.forEach(input => {
            input.addEventListener('focus', function() {
                // Force redraw to prevent visual glitches
                document.body.style.transform = 'translateZ(0)';
            });
            
            input.addEventListener('blur', function() {
                // Reset transform after blur
                document.body.style.transform = '';
            });
        });
        
        // Fix for Android WebView rendering issues
        document.body.style.webkitTextSizeAdjust = '100%';
        
        // Fix for image rendering on Android
        const images = document.querySelectorAll('img');
        images.forEach(img => {
            img.style.imageRendering = '-webkit-optimize-contrast';
        });
    }
}

/**
 * Initialize lazy loading for images
 */
function initLazyLoading() {
    // Check if IntersectionObserver is available
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    const src = img.dataset.src;
                    
                    if (src) {
                        img.src = src;
                        img.removeAttribute('data-src');
                    }
                    
                    observer.unobserve(img);
                }
            });
        });
        
        // Find all images that can be lazy loaded
        const lazyImages = document.querySelectorAll('img[data-src]');
        lazyImages.forEach(img => {
            imageObserver.observe(img);
        });
    } else {
        // Fallback for browsers without IntersectionObserver
        // Load all images immediately
        const lazyImages = document.querySelectorAll('img[data-src]');
        lazyImages.forEach(img => {
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
        });
    }
}

/**
 * Handle orientation changes on mobile devices
 */
function handleOrientationChange() {
    // Wait for the orientation change to complete
    setTimeout(() => {
        // Update carousels for new orientation
        initMobileCarousels();
        
        // Fix any layout issues
        document.body.style.transform = 'translateZ(0)';
        setTimeout(() => {
            document.body.style.transform = '';
        }, 100);
        
        // Reset scroll position if needed
        if (window.scrollY > 100) {
            window.scrollTo({top: 0, behavior: 'auto'});
        }
    }, 200);
}