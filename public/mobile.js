// mobile.js - Complete implementation with fixes for sidebar and black background

document.addEventListener('DOMContentLoaded', function() {
    console.log('Mobile script initialized - enhanced version');
    
    // 1. Fix viewport settings
    const viewport = document.querySelector('meta[name="viewport"]');
    if (viewport) {
        viewport.setAttribute('content', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no');
        console.log('Viewport meta tag updated');
    }

    // 2. Get mobile elements
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const menuIcon = document.getElementById('menu-icon');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const closeSidebar = document.getElementById('close-sidebar');
    const dropdownButtons = document.querySelectorAll('.sidebar-dropdown button');
    
    // Debug logger
    function log(message) {
        console.log('Mobile Debug: ' + message);
    }
    
    // 3. Force mobile layout for mobile devices
    function forceMobileLayout() {
        if (window.innerWidth <= 767) {
            // Get navbar elements
            const mobileNavbar = document.getElementById('mobile-navbar');
            const desktopNavbar = document.querySelector('.navbar.hidden.md\\:block');
            
            if (mobileNavbar) {
                mobileNavbar.style.display = 'block';
                mobileNavbar.style.visibility = 'visible';
                log('Mobile navbar displayed');
            }
            
            if (desktopNavbar) {
                desktopNavbar.style.display = 'none';
                desktopNavbar.style.visibility = 'hidden';
                log('Desktop navbar hidden');
            }
            
            // Add mobile class to body
            document.body.classList.add('mobile-view');
            
            // Make sure sidebar is in the correct initial state
            if (mobileSidebar) {
                mobileSidebar.style.transform = 'translateX(100%)';
            }
            
            if (sidebarOverlay) {
                sidebarOverlay.style.opacity = '0';
                sidebarOverlay.style.visibility = 'hidden';
                sidebarOverlay.style.pointerEvents = 'none';
            }
            
            // Override any desktop styles that might be applied
            const grid = document.querySelectorAll('.grid');
            grid.forEach(function(item) {
                if (window.innerWidth < 480) {
                    item.style.gridTemplateColumns = 'repeat(1, 1fr)';
                } else {
                    item.style.gridTemplateColumns = 'repeat(2, 1fr)';
                }
            });
            
            // Fix header height
            const header = document.querySelector('header.h-screen');
            if (header) {
                header.style.height = '60vh';
            }
        }
    }
    
    // 4. Run forceMobileLayout immediately
    forceMobileLayout();
    
    // 5. Run after short delays to override any other scripts
    setTimeout(forceMobileLayout, 100);
    setTimeout(forceMobileLayout, 500);
    
    // 6. CRITICAL FIX: Show sidebar function with proper overlay handling
    function showSidebar() {
        log('Opening sidebar');
        
        // CRITICAL: First make sure the body is marked as having sidebar open
        // This applies CSS that prevents scrolling and fixes the overlay
        document.body.classList.add('sidebar-open');
        
        // Apply styles directly to sidebar
        if (mobileSidebar) {
            mobileSidebar.style.transform = 'translateX(0)';
            mobileSidebar.style.display = 'block';
            log('Sidebar transform applied');
        }
        
        // CRITICAL: Apply styles directly to overlay - must be visible and have pointer events
        if (sidebarOverlay) {
            sidebarOverlay.style.opacity = '1';
            sidebarOverlay.style.visibility = 'visible';
            sidebarOverlay.style.pointerEvents = 'auto';
            log('Overlay styles applied');
        }
        
        // Change menu icon
        if (menuIcon) {
            menuIcon.classList.remove('fa-bars');
            menuIcon.classList.add('fa-times');
        }
    }
    
    // 7. CRITICAL FIX: Hide sidebar function with proper overlay handling
    function hideSidebar() {
        log('Closing sidebar');
        
        // Apply styles directly to sidebar
        if (mobileSidebar) {
            mobileSidebar.style.transform = 'translateX(100%)';
            log('Sidebar transform reset');
        }
        
        // CRITICAL: Apply styles directly to overlay - must be invisible and have no pointer events
        if (sidebarOverlay) {
            sidebarOverlay.style.opacity = '0';
            sidebarOverlay.style.visibility = 'hidden';
            sidebarOverlay.style.pointerEvents = 'none';
            log('Overlay styles reset');
        }
        
        // CRITICAL: Remove the sidebar-open class from body AFTER changing the overlay
        // This will allow the page to scroll again
        document.body.classList.remove('sidebar-open');
        
        // Change menu icon back
        if (menuIcon) {
            menuIcon.classList.remove('fa-times');
            menuIcon.classList.add('fa-bars');
        }
    }
    
    // 8. Toggle sidebar with click handler
    if (mobileMenuToggle) {
        log('Menu toggle button found');
        mobileMenuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            log('Menu toggle clicked');
            showSidebar();
        });
    } else {
        log('ERROR: Menu toggle button not found!');
    }
    
    // 9. Close sidebar handlers
    if (closeSidebar) {
        log('Close button found');
        closeSidebar.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            log('Close button clicked');
            hideSidebar();
        });
    } else {
        log('ERROR: Close sidebar button not found!');
    }
    
    // 10. CRITICAL: Handle overlay clicks to close sidebar
    if (sidebarOverlay) {
        log('Overlay found');
        sidebarOverlay.addEventListener('click', function(e) {
            log('Overlay clicked');
            hideSidebar();
        });
    } else {
        log('ERROR: Sidebar overlay not found!');
        
        // If the overlay doesn't exist, create it
        const body = document.body;
        const newOverlay = document.createElement('div');
        newOverlay.id = 'sidebar-overlay';
        newOverlay.className = 'fixed inset-0 bg-black opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out z-30 hidden md:hidden';
        body.appendChild(newOverlay);
        
        // Add click handler to new overlay
        newOverlay.addEventListener('click', function(e) {
            log('New overlay clicked');
            hideSidebar();
        });
    }
    
    // 11. Handle dropdown menus in sidebar
    if (dropdownButtons && dropdownButtons.length > 0) {
        log('Found ' + dropdownButtons.length + ' dropdown buttons');
        dropdownButtons.forEach(function(button, index) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                log('Dropdown button ' + (index + 1) + ' clicked');
                
                const dropdown = this.nextElementSibling;
                const icon = this.querySelector('.fa-chevron-down');
                
                if (dropdown) {
                    dropdown.classList.toggle('hidden');
                    const isHidden = dropdown.classList.contains('hidden');
                    log('Dropdown ' + (index + 1) + ' is now ' + (isHidden ? 'hidden' : 'visible'));
                    
                    if (icon) {
                        icon.style.transform = isHidden ? 'rotate(0)' : 'rotate(180deg)';
                    }
                } else {
                    log('ERROR: No dropdown found for button ' + (index + 1));
                }
            });
        });
    } else {
        log('No dropdown buttons found');
    }
    
    // 12. Close sidebar on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            log('Escape key pressed');
            hideSidebar();
        }
    });
    
    // 13. Run on resize to maintain correct display
    window.addEventListener('resize', forceMobileLayout);
    
    // 14. Run after page load
    window.addEventListener('load', forceMobileLayout);
    
    // 15. CRITICAL: Override any existing force desktop layout functions
    if (window.forceDesktopLayout) {
        log('Overriding forceDesktopLayout function');
        const originalFn = window.forceDesktopLayout;
        window.forceDesktopLayout = function() {
            // Call original function
            originalFn.apply(this, arguments);
            
            // Then forcefully apply our mobile layout if needed
            if (window.innerWidth <= 767) {
                forceMobileLayout();
            }
        };
    }
    
    // 16. Add debug function
    window.debugMobileSidebar = function() {
        const elements = {
            viewport: viewport ? viewport.getAttribute('content') : 'Not found',
            mobileMenuToggle: mobileMenuToggle ? 'Found' : 'Not found',
            mobileSidebar: mobileSidebar ? 'Found' : 'Not found',
            sidebarOverlay: sidebarOverlay ? 'Found' : 'Not found',
            closeSidebar: closeSidebar ? 'Found' : 'Not found',
            dropdownButtons: dropdownButtons ? dropdownButtons.length + ' found' : 'None found'
        };
        
        const styles = {
            sidebarTransform: mobileSidebar ? mobileSidebar.style.transform : 'N/A',
            sidebarDisplay: mobileSidebar ? getComputedStyle(mobileSidebar).display : 'N/A',
            overlayOpacity: sidebarOverlay ? sidebarOverlay.style.opacity : 'N/A',
            overlayVisibility: sidebarOverlay ? sidebarOverlay.style.visibility : 'N/A',
            bodyHasClass: document.body.classList.contains('sidebar-open')
        };
        
        log('Mobile Debug Info:');
        log('Elements: ' + JSON.stringify(elements));
        log('Styles: ' + JSON.stringify(styles));
        log('Window width: ' + window.innerWidth);
        
        return { elements, styles };
    };
    
    // Run final check to make sure all key elements are properly styled
    if (mobileSidebar && sidebarOverlay) {
        log('Final setup complete');
    } else {
        log('ERROR: Critical elements missing!');
    }
});