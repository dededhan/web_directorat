// mobile.js - Enhanced to force desktop layout while preserving mobile navbar

document.addEventListener('DOMContentLoaded', function() {
    console.log('Mobile script initialized - desktop layout force version');
    
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
    
    // 3. Force mobile navbar but desktop layout content
    function forceDesktopLayoutOnMobile() {
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
            
            // Force desktop-like layout for content areas
            
            // 1. News grid - force 3 columns
            const newsGrid = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3');
            if (newsGrid) {
                newsGrid.style.display = 'grid';
                newsGrid.style.gridTemplateColumns = 'repeat(3, 1fr)';
                newsGrid.style.gap = '0.5rem';
                log('News grid set to 3 columns');
            }
            
            // 2. Carousel - force 3 items
            const carouselItems = document.querySelectorAll('.carousel-item-enhanced');
            carouselItems.forEach(function(item) {
                item.style.flex = '0 0 33.333%';
                item.style.maxWidth = '33.333%';
            });
            log('Carousel set to 3 items');
            
            // 3. Program grid - force 4 columns
            const programGrid = document.querySelector('.program-grid, .grid.grid-cols-1.sm\\:grid-cols-2.lg\\:grid-cols-4');
            if (programGrid) {
                programGrid.style.display = 'grid';
                programGrid.style.gridTemplateColumns = 'repeat(4, 1fr)';
                programGrid.style.gap = '0.5rem';
                log('Program grid set to 4 columns');
            }
            
            // 4. Instagram/YouTube grid - force 3 columns
            const mediaGrids = document.querySelectorAll('#instagram-api-feed-container, #dynamic-videos-container, .grid.grid-cols-1.sm\\:grid-cols-2.md\\:grid-cols-3');
            mediaGrids.forEach(function(grid) {
                grid.style.display = 'grid';
                grid.style.gridTemplateColumns = 'repeat(3, 1fr)';
                grid.style.gap = '0.5rem';
            });
            log('Media grids set to 3 columns');
            
            // 5. Footer grid - force 3 columns
            const footerGrid = document.querySelector('footer .grid');
            if (footerGrid) {
                footerGrid.style.display = 'grid';
                footerGrid.style.gridTemplateColumns = 'repeat(3, 1fr)';
                footerGrid.style.gap = '1rem';
                log('Footer grid set to 3 columns');
            }
            
            // Check for very small screens and adjust if needed
            if (window.innerWidth <= 359) {
                // Reduce to 2 columns for very small screens
                const allGrids = document.querySelectorAll('.grid');
                allGrids.forEach(function(grid) {
                    grid.style.gridTemplateColumns = 'repeat(2, 1fr)';
                });
                
                // Make carousel 2 items
                carouselItems.forEach(function(item) {
                    item.style.flex = '0 0 50%';
                    item.style.maxWidth = '50%';
                });
                
                log('Adjusted to 2 columns for very small screen');
            }
        }
    }
    
    // 4. Run immediately
    forceDesktopLayoutOnMobile();
    
    // 5. Run after short delays to override any other scripts
    setTimeout(forceDesktopLayoutOnMobile, 100);
    setTimeout(forceDesktopLayoutOnMobile, 500);
    
    // 6. Show sidebar function with proper overlay handling
    function showSidebar() {
        log('Opening sidebar');
        
        // Add sidebar-open class to body
        document.body.classList.add('sidebar-open');
        
        // Apply styles directly to sidebar
        if (mobileSidebar) {
            mobileSidebar.style.transform = 'translateX(0)';
            mobileSidebar.style.display = 'block';
            log('Sidebar transform applied');
        }
        
        // Apply styles to overlay
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
    
    // 7. Hide sidebar function with proper overlay handling
    function hideSidebar() {
        log('Closing sidebar');
        
        // Apply styles to sidebar
        if (mobileSidebar) {
            mobileSidebar.style.transform = 'translateX(100%)';
            log('Sidebar transform reset');
        }
        
        // Apply styles to overlay
        if (sidebarOverlay) {
            sidebarOverlay.style.opacity = '0';
            sidebarOverlay.style.visibility = 'hidden';
            sidebarOverlay.style.pointerEvents = 'none';
            log('Overlay styles reset');
        }
        
        // Remove sidebar-open class from body
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
    
    // 10. Handle overlay clicks to close sidebar
    if (sidebarOverlay) {
        log('Overlay found');
        sidebarOverlay.addEventListener('click', function(e) {
            log('Overlay clicked');
            hideSidebar();
        });
    } else {
        log('ERROR: Sidebar overlay not found!');
        
        // If overlay doesn't exist, create it
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
    window.addEventListener('resize', forceDesktopLayoutOnMobile);
    
    // 14. Run after page load
    window.addEventListener('load', forceDesktopLayoutOnMobile);
    
    // 15. Override any existing forceDesktopLayout function
    if (window.forceDesktopLayout) {
        log('Original forceDesktopLayout function found, overriding');
        const originalFn = window.forceDesktopLayout;
        window.forceDesktopLayout = function() {
            originalFn.apply(this, arguments);
            forceDesktopLayoutOnMobile();
        };
    } else {
        // Create the function if it doesn't exist
        window.forceDesktopLayout = forceDesktopLayoutOnMobile;
    }
    
    // 16. Setup event listeners for dynamically loaded content
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                // Something was added to the DOM, check if we need to update layout
                forceDesktopLayoutOnMobile();
            }
        });
    });
    
    // Observe the entire body for changes
    observer.observe(document.body, { childList: true, subtree: true });
    
    log('Mobile initialization complete - desktop layout force enabled');
});