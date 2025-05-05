// mobile.js - Force desktop layout while keeping mobile navbar

document.addEventListener('DOMContentLoaded', function() {
    console.log('Mobile script initialized - desktop layout hybrid version');
    
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
    
    // 3. Force mobile navbar but desktop layout for content
    function forceDesktopOnMobile() {
        if (window.innerWidth <= 767) {
            // Mobile navbar setup
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
            
            // === FORCE DESKTOP LAYOUT FOR ALL CONTENT SECTIONS ===
            
            // 1. News Grid - Force 3 columns like desktop
            const newsGrid = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3');
            if (newsGrid) {
                newsGrid.style.display = 'grid';
                newsGrid.style.gridTemplateColumns = 'repeat(3, 1fr)';
                newsGrid.style.gap = '1rem';
                log('News grid set to desktop layout (3 columns)');
            }
            
            // 2. Featured News Carousel - Force 3 items
            const carouselItems = document.querySelectorAll('.carousel-item-enhanced');
            carouselItems.forEach(function(item) {
                item.style.flex = '0 0 33.333%';
                item.style.maxWidth = '33.333%';
            });
            log('Carousel set to desktop layout (3 items)');
            
            // 3. Program Grid - Force 4 columns like desktop
            const programGrid = document.querySelector('.program-section .grid, .grid.grid-cols-1.sm\\:grid-cols-2.lg\\:grid-cols-4');
            if (programGrid) {
                programGrid.style.display = 'grid';
                programGrid.style.gridTemplateColumns = 'repeat(4, 1fr)';
                programGrid.style.gap = '0.75rem';
                log('Program grid set to desktop layout (4 columns)');
            }
            
            // 4. Instagram & YouTube grids - Force 3 columns like desktop
            const instagramGrid = document.getElementById('instagram-api-feed-container');
            const youtubeGrid = document.getElementById('dynamic-videos-container');
            
            if (instagramGrid) {
                instagramGrid.style.display = 'grid';
                instagramGrid.style.gridTemplateColumns = 'repeat(3, 1fr)';
                instagramGrid.style.gap = '0.75rem';
                log('Instagram grid set to desktop layout (3 columns)');
            }
            
            if (youtubeGrid) {
                youtubeGrid.style.display = 'grid';
                youtubeGrid.style.gridTemplateColumns = 'repeat(3, 1fr)';
                youtubeGrid.style.gap = '0.75rem';
                log('YouTube grid set to desktop layout (3 columns)');
            }
            
            // 5. Footer grid - Force 3 columns like desktop
            const footerGrid = document.querySelector('footer .grid');
            if (footerGrid) {
                footerGrid.style.display = 'grid';
                footerGrid.style.gridTemplateColumns = 'repeat(3, 1fr)';
                footerGrid.style.gap = '1rem';
                log('Footer grid set to desktop layout (3 columns)');
            }
            
            // Handle very small screens (under 360px)
            if (window.innerWidth < 360) {
                // Switch to 2 columns for very small screens
                const allGrids = [newsGrid, programGrid, instagramGrid, youtubeGrid];
                allGrids.forEach(function(grid) {
                    if (grid) {
                        grid.style.gridTemplateColumns = 'repeat(2, 1fr)';
                    }
                });
                
                // Carousel 2 items
                carouselItems.forEach(function(item) {
                    item.style.flex = '0 0 50%';
                    item.style.maxWidth = '50%';
                });
                
                log('Adjusted to 2 columns for very small screen width: ' + window.innerWidth);
            }
        }
    }
    
    // 4. Run immediately
    forceDesktopOnMobile();
    
    // 5. Run after short delays to override any other scripts
    setTimeout(forceDesktopOnMobile, 100);
    setTimeout(forceDesktopOnMobile, 500);
    
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
    
    // 13. Observe DOM changes to maintain desktop layout on dynamic content
    const observer = new MutationObserver(function(mutations) {
        // Check if any of the content sections have been changed
        let needsUpdate = false;
        
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' && 
                (mutation.target.id === 'instagram-api-feed-container' || 
                 mutation.target.id === 'dynamic-videos-container' ||
                 mutation.target.classList.contains('grid'))) {
                needsUpdate = true;
            }
        });
        
        if (needsUpdate) {
            log('Content changed, reapplying desktop layout');
            forceDesktopOnMobile();
        }
    });
    
    // Start observing the entire document
    observer.observe(document.body, { 
        childList: true, 
        subtree: true,
        attributes: true,
        attributeFilter: ['class', 'style']
    });
    
    // 14. Run on resize to maintain correct display
    window.addEventListener('resize', forceDesktopOnMobile);
    
    // 15. Run after page load
    window.addEventListener('load', forceDesktopOnMobile);
    
    // 16. Override existing forceDesktopLayout function if it exists
    if (window.forceDesktopLayout) {
        log('Overriding existing forceDesktopLayout function');
        const originalFn = window.forceDesktopLayout;
        window.forceDesktopLayout = function() {
            originalFn.apply(this, arguments);
            forceDesktopOnMobile();
        };
    } else {
        // Create a global function
        window.forceDesktopLayout = forceDesktopOnMobile;
    }
    
    // Fix carousel if needed by overriding its functions
    if (typeof window.adjustForMobile === 'function') {
        const originalAdjust = window.adjustForMobile;
        window.adjustForMobile = function() {
            originalAdjust.apply(this, arguments);
            // Force our desktop layout after the carousel tries to adjust
            setTimeout(forceDesktopOnMobile, 10);
        };
        log('Carousel adjustForMobile function overridden');
    }
    
    // Initial style setup for sidebar and overlay
    if (mobileSidebar) {
        log('Setting initial sidebar style');
        mobileSidebar.style.transform = 'translateX(100%)';
    }
    
    if (sidebarOverlay) {
        log('Setting initial overlay style');
        sidebarOverlay.style.opacity = '0';
        sidebarOverlay.style.visibility = 'hidden';
        sidebarOverlay.style.pointerEvents = 'none';
    }
    
    log('Mobile initialization complete - desktop content layout enabled');
});