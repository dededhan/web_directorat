// Enhanced Mobile Navbar JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const menuIcon = document.getElementById('menu-icon');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const closeSidebar = document.getElementById('close-sidebar');
    const dropdownButtons = document.querySelectorAll('.sidebar-dropdown button');
    
    // Track sidebar state
    let isSidebarOpen = false;
    
    // Enhanced show/hide functions with smooth animations
    function showSidebar() {
        if (isSidebarOpen) return;
        
        mobileSidebar.classList.add('active');
        sidebarOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        menuIcon.classList.remove('fa-bars');
        menuIcon.classList.add('fa-times');
        isSidebarOpen = true;
        
        // Add aria attributes for accessibility
        mobileMenuToggle.setAttribute('aria-expanded', 'true');
    }
    
    function hideSidebar() {
        if (!isSidebarOpen) return;
        
        mobileSidebar.classList.remove('active');
        sidebarOverlay.classList.remove('active');
        document.body.style.overflow = '';
        menuIcon.classList.remove('fa-times');
        menuIcon.classList.add('fa-bars');
        isSidebarOpen = false;
        
        // Update aria attributes
        mobileMenuToggle.setAttribute('aria-expanded', 'false');
    }
    
    // Toggle sidebar
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            if (isSidebarOpen) {
                hideSidebar();
            } else {
                showSidebar();
            }
        });
    }
    
    // Close sidebar when clicking close button
    if (closeSidebar) {
        closeSidebar.addEventListener('click', function(e) {
            e.preventDefault();
            hideSidebar();
        });
    }
    
    // Close sidebar when clicking overlay
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            hideSidebar();
        });
    }
    
    // Enhanced dropdown functionality
    dropdownButtons.forEach(button => {
        const dropdown = button.nextElementSibling;
        const icon = button.querySelector('.fa-chevron-down');
        
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Close other dropdowns
            dropdownButtons.forEach(otherButton => {
                if (otherButton !== button) {
                    const otherDropdown = otherButton.nextElementSibling;
                    const otherIcon = otherButton.querySelector('.fa-chevron-down');
                    
                    if (!otherDropdown.classList.contains('hidden')) {
                        otherDropdown.classList.add('hidden');
                        otherIcon.style.transform = 'rotate(0)';
                        otherButton.setAttribute('aria-expanded', 'false');
                    }
                }
            });
            
            // Toggle current dropdown
            const isHidden = dropdown.classList.contains('hidden');
            dropdown.classList.toggle('hidden');
            icon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0)';
            button.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
        });
    });
    
    // Close sidebar on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isSidebarOpen) {
            hideSidebar();
        }
    });
    
    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth > 767 && isSidebarOpen) {
                hideSidebar();
            }
        }, 250);
    });
    
    // Prevent body scroll when sidebar is open
    function preventBodyScroll(e) {
        if (isSidebarOpen) {
            e.preventDefault();
        }
    }
    
    // Touch event handling for better mobile experience
    let touchStartX = 0;
    let touchStartY = 0;
    let touchEndX = 0;
    let touchEndY = 0;
    
    document.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
        touchStartY = e.changedTouches[0].screenY;
    }, { passive: true });
    
    document.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        touchEndY = e.changedTouches[0].screenY;
        handleSwipe();
    }, { passive: true });
    
    function handleSwipe() {
        const swipeThreshold = 50;
        const swipeDistanceX = touchStartX - touchEndX;
        const swipeDistanceY = Math.abs(touchStartY - touchEndY);
        
        // Only handle horizontal swipes
        if (swipeDistanceY < swipeThreshold) {
            if (swipeDistanceX > swipeThreshold && !isSidebarOpen) {
                // Swipe left - open sidebar
                showSidebar();
            } else if (swipeDistanceX < -swipeThreshold && isSidebarOpen) {
                // Swipe right - close sidebar
                hideSidebar();
            }
        }
    }
    
    // Initialize aria attributes
    if (mobileMenuToggle) {
        mobileMenuToggle.setAttribute('aria-expanded', 'false');
        mobileMenuToggle.setAttribute('aria-label', 'Toggle navigation menu');
    }
    
    dropdownButtons.forEach(button => {
        button.setAttribute('aria-expanded', 'false');
        button.setAttribute('aria-haspopup', 'true');
    });
});

// Helper function to check if device is mobile
function isMobileDevice() {
    return window.innerWidth <= 767 || 
           /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

// Ensure proper display on page load
window.addEventListener('load', function() {
    if (isMobileDevice()) {
        // Force mobile navbar display
        const mobileNavbar = document.getElementById('mobile-navbar');
        const desktopNavbar = document.querySelector('.navbar.hidden.md\\:block');
        
        if (mobileNavbar) {
            mobileNavbar.style.display = 'block';
        }
        
        if (desktopNavbar) {
            desktopNavbar.style.display = 'none';
        }
    }
});