/* mobile.js - Specific functionality for mobile devices */

/**
 * Comprehensive mobile device detection
 */
function isMobileDevice() {
    // Check multiple indicators
    const userAgent = navigator.userAgent.toLowerCase();
    const mobileKeywords = /android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i;
    const isMobileUA = mobileKeywords.test(userAgent);
    const isMobileWidth = window.innerWidth <= 768;
    const hasTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
    
    // Return true if any two conditions are met
    return (isMobileUA && hasTouch) || (isMobileWidth && hasTouch) || (isMobileUA && isMobileWidth);
}

// Track mobile state
let isMobile = isMobileDevice();

document.addEventListener('DOMContentLoaded', function() {
    // Debug information
    console.log('=== Mobile Detection Debug ===');
    console.log('Screen width:', window.innerWidth);
    console.log('Screen height:', window.innerHeight);
    console.log('User Agent:', navigator.userAgent);
    console.log('Has touch:', 'ontouchstart' in window || navigator.maxTouchPoints > 0);
    console.log('Is Mobile Device:', isMobileDevice());
    console.log('===========================');
    
    // Apply mobile optimizations if detected as mobile
    if (isMobileDevice()) {
        // Add class to body for CSS targeting
        document.body.classList.add('mobile-mode');
        
        // Run mobile optimizations
        setupMobileViewport();
        initMobileCarousels();
        optimizeTapTargets();
        improveScrollPerformance();
        applyAndroidFixes();
        initLazyLoading();
        
        // Add visual indicator for testing (remove in production)
        if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
            const debugBadge = document.createElement('div');
            debugBadge.style.cssText = 'position: fixed; bottom: 10px; right: 10px; background: rgba(0,128,0,0.8); color: white; padding: 5px 10px; border-radius: 5px; z-index: 9999; font-size: 12px;';
            debugBadge.textContent = 'Mobile Mode Active';
            document.body.appendChild(debugBadge);
        }
    }
    
    // Always listen for orientation changes and resize
    window.addEventListener('orientationchange', handleOrientationChange);
    window.addEventListener('resize', handleResize);
});

/**
 * Handle window resize events
 */
function handleResize() {
    const wasMobile = isMobile;
    isMobile = isMobileDevice();
    
    if (wasMobile !== isMobile) {
        // Device type changed (e.g., rotated or resized)
        if (isMobile) {
            console.log('Switched to mobile mode');
            document.body.classList.add('mobile-mode');
            
            // Apply mobile optimizations
            setupMobileViewport();
            initMobileCarousels();
            optimizeTapTargets();
            improveScrollPerformance();
            applyAndroidFixes();
            initLazyLoading();
        } else {
            console.log('Switched to desktop mode');
            document.body.classList.remove('mobile-mode');
        }
    }
}

/**
 * Sets up the proper viewport for mobile devices
 */
function setupMobileViewport() {
    const existingViewport = document.querySelector('meta[name="viewport"]');
    if (existingViewport) {
        // Log current viewport settings
        console.log('Current viewport:', existingViewport.getAttribute('content'));
        
        // Ensure proper viewport settings for mobile
        // Don't change user-scalable=no as it's an accessibility concern
        existingViewport.setAttribute('content', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no');
    } else {
        // Create viewport meta tag if it doesn't exist
        const viewport = document.createElement('meta');
        viewport.name = 'viewport';
        viewport.content = 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no';
        document.head.appendChild(viewport);
    }
}

/**
 * Optimize carousels for mobile viewing
 */
function initMobileCarousels() {
    console.log('Initializing mobile carousels');
    
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
    console.log('Optimizing tap targets');
    
    // Find all clickable elements
    const clickableElements = document.querySelectorAll('a, button, .card-link, .news-link, [role="button"]');
    
    // Ensure they have adequate size for tapping
    clickableElements.forEach(el => {
        const rect = el.getBoundingClientRect();
        
        // Skip if element is hidden
        if (rect.width === 0 && rect.height === 0) return;
        
        if (rect.height < 44 || rect.width < 44) {
            // Add padding if the element is too small
            el.style.padding = el.style.padding || '0.5rem';
            el.style.minHeight = '44px';
            el.style.display = 'inline-flex';
            el.style.alignItems = 'center';
            el.style.justifyContent = 'center';
        }
    });
}

/**
 * Improve scrolling performance on mobile
 */
function improveScrollPerformance() {
    console.log('Improving scroll performance');
    
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
        el.style.backfaceVisibility = 'hidden';
        el.style.webkitBackfaceVisibility = 'hidden';
    });
    
    // Fix for smooth scrolling
    document.addEventListener('touchstart', function() {}, {passive: true});
    document.addEventListener('touchmove', function() {}, {passive: true});
    document.addEventListener('wheel', function() {}, {passive: true});
}

/**
 * Apply fixes specific to Android devices
 */
function applyAndroidFixes() {
    // Detect Android
    const isAndroid = navigator.userAgent.toLowerCase().indexOf('android') > -1;
    
    if (isAndroid) {
        console.log('Applying Android-specific fixes');
        
        // Fix for input fields on Android
        const inputFields = document.querySelectorAll('input, textarea, select');
        inputFields.forEach(input => {
            input.addEventListener('focus', function() {
                // Force redraw to prevent visual glitches
                document.body.style.transform = 'translateZ(0)';
                
                // Scroll input into view
                setTimeout(() => {
                    input.scrollIntoView({behavior: 'smooth', block: 'center'});
                }, 300);
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
        
        // Fix for Android Chrome address bar hiding issues
        let lastScrollPosition = 0;
        window.addEventListener('scroll', function() {
            const currentScrollPosition = window.pageYOffset;
            
            if (currentScrollPosition > lastScrollPosition && currentScrollPosition > 50) {
                // Scrolling down
                document.body.classList.add('scrolling-down');
            } else {
                // Scrolling up
                document.body.classList.remove('scrolling-down');
            }
            
            lastScrollPosition = currentScrollPosition;
        }, {passive: true});
    }
}

/**
 * Initialize lazy loading for images
 */
function initLazyLoading() {
    console.log('Initializing lazy loading');
    
    // Check if IntersectionObserver is available
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    const src = img.dataset.src;
                    
                    if (src) {
                        // Preload image to avoid layout shift
                        const tempImage = new Image();
                        tempImage.onload = function() {
                            img.src = src;
                            img.removeAttribute('data-src');
                            img.classList.add('lazy-loaded');
                        };
                        tempImage.src = src;
                    }
                    
                    observer.unobserve(img);
                }
            });
        }, {
            rootMargin: '50px 0px', // Start loading 50px before the image enters viewport
            threshold: 0.01
        });
        
        // Find all images that can be lazy loaded
        const lazyImages = document.querySelectorAll('img[data-src]');
        lazyImages.forEach(img => {
            imageObserver.observe(img);
        });
    } else {
        // Fallback for browsers without IntersectionObserver
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
    console.log('Orientation changed');
    
    // Wait for the orientation change to complete
    setTimeout(() => {
        // Update carousels for new orientation
        initMobileCarousels();
        
        // Fix any layout issues
        document.body.style.transform = 'translateZ(0)';
        setTimeout(() => {
            document.body.style.transform = '';
        }, 100);
        
        // Reoptimize tap targets after orientation change
        optimizeTapTargets();
        
        // Force a layout recalculation
        window.dispatchEvent(new Event('resize'));
    }, 200);
}

// Additional utility functions for mobile
function disableBodyScroll() {
    document.body.style.overflow = 'hidden';
    document.body.style.position = 'fixed';
    document.body.style.width = '100%';
}

function enableBodyScroll() {
    document.body.style.overflow = '';
    document.body.style.position = '';
    document.body.style.width = '';
}

// Export functions for use in other scripts
window.mobileUtils = {
    isMobileDevice,
    disableBodyScroll,
    enableBodyScroll,
    optimizeTapTargets
};