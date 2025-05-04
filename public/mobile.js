// Add this code at the top of your mobile.js file

document.addEventListener('DOMContentLoaded', function() {
    // Immediately set correct navbar visibility based on screen width
    function setCorrectNavbar() {
        const isMobile = window.innerWidth <= 767;
        
        // Get navbar elements
        const mobileNavbar = document.getElementById('mobile-navbar');
        const desktopNavbar = document.querySelector('.navbar.hidden.md\\:block');
        
        if (!mobileNavbar || !desktopNavbar) {
            console.error('Navbar elements not found');
            return;
        }
        
        // Force correct display based on viewport width
        if (isMobile) {
            // Mobile mode - show mobile navbar, hide desktop
            mobileNavbar.style.display = 'block';
            desktopNavbar.style.display = 'none';
            document.body.classList.add('mobile-view');
        } else {
            // Desktop mode - hide mobile navbar, show desktop
            mobileNavbar.style.display = 'none';
            desktopNavbar.style.display = 'block';
            document.body.classList.remove('mobile-view');
        }
    }
    
    // Run immediately
    setCorrectNavbar();
    
    // Also run on resize
    window.addEventListener('resize', setCorrectNavbar);
    
    // Add a MutationObserver to prevent other scripts from changing navbar visibility
    const observer = new MutationObserver(function(mutations) {
        const isMobile = window.innerWidth <= 767;
        
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && 
                (mutation.attributeName === 'style' || mutation.attributeName === 'class')) {
                // If display style was changed, force it back to our preferred state
                setCorrectNavbar();
            }
        });
    });
    
    // Observe both navbars for changes
    const mobileNavbar = document.getElementById('mobile-navbar');
    const desktopNavbar = document.querySelector('.navbar.hidden.md\\:block');
    
    if (mobileNavbar && desktopNavbar) {
        observer.observe(mobileNavbar, { attributes: true });
        observer.observe(desktopNavbar, { attributes: true });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // 1. Fix viewport settings
    const viewport = document.querySelector('meta[name="viewport"]');
    if (viewport) {
        viewport.setAttribute('content', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no');
    }

    // 2. Mobile elements
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const menuIcon = document.getElementById('menu-icon');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const closeSidebar = document.getElementById('close-sidebar');
    const dropdownButtons = document.querySelectorAll('.sidebar-dropdown button');
    
    // 3. Debug logger
    function log(message) {
        console.log('Mobile Debug: ' + message);
    }
    
    log('Mobile script initialized');
    
    // 4. Show sidebar function with direct style manipulation
    function showSidebar() {
        log('Opening sidebar');
        
        // Apply styles directly
        if (mobileSidebar) {
            mobileSidebar.style.transform = 'translateX(0)';
            log('Sidebar transform applied');
        }
        
        if (sidebarOverlay) {
            sidebarOverlay.style.opacity = '1';
            sidebarOverlay.style.visibility = 'visible';
            sidebarOverlay.style.pointerEvents = 'auto';
            log('Overlay styles applied');
        }
        
        document.body.classList.add('sidebar-open');
        
        if (menuIcon) {
            menuIcon.classList.remove('fa-bars');
            menuIcon.classList.add('fa-times');
        }
    }
    
    // 5. Hide sidebar function with direct style manipulation
    function hideSidebar() {
        log('Closing sidebar');
        
        // Apply styles directly
        if (mobileSidebar) {
            mobileSidebar.style.transform = 'translateX(100%)';
            log('Sidebar transform reset');
        }
        
        if (sidebarOverlay) {
            sidebarOverlay.style.opacity = '0';
            sidebarOverlay.style.visibility = 'hidden';
            sidebarOverlay.style.pointerEvents = 'none';
            log('Overlay styles reset');
        }
        
        document.body.classList.remove('sidebar-open');
        
        if (menuIcon) {
            menuIcon.classList.remove('fa-times');
            menuIcon.classList.add('fa-bars');
        }
    }
    
    // 6. Toggle sidebar with click handler
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
    
    // 7. Close sidebar handlers
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
    
    if (sidebarOverlay) {
        log('Overlay found');
        sidebarOverlay.addEventListener('click', function(e) {
            log('Overlay clicked');
            hideSidebar();
        });
    } else {
        log('ERROR: Sidebar overlay not found!');
    }
    
    // 8. Handle dropdown menus in sidebar
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
    
    // 9. Close sidebar on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            log('Escape key pressed');
            hideSidebar();
        }
    });
    
    // 10. Fix mobile classes on load
    function fixMobileDisplay() {
        log('Fixing mobile display');
        if (window.innerWidth <= 767) {
            // Mobile mode
            log('Mobile width detected: ' + window.innerWidth);
            
            // Show mobile navbar
            const mobileNavbar = document.getElementById('mobile-navbar');
            if (mobileNavbar) {
                mobileNavbar.style.display = 'block';
                log('Mobile navbar displayed');
            }
            
            // Hide desktop navbar
            const desktopNavbar = document.querySelector('.navbar.hidden.md\\:block');
            if (desktopNavbar) {
                desktopNavbar.style.display = 'none';
                log('Desktop navbar hidden');
            }
            
            // Ensure sidebar and overlay are in DOM
            if (mobileSidebar) {
                mobileSidebar.style.display = 'block';
                log('Sidebar display set');
            }
            
            if (sidebarOverlay) {
                sidebarOverlay.style.display = 'block';
                log('Overlay display set');
            }
        }
    }
    
    // Run on page load
    fixMobileDisplay();
    
    // Run on resize
    window.addEventListener('resize', fixMobileDisplay);
    
    // 11. Add debug function to global scope
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
        
        console.log('Mobile Debug Info:');
        console.log('Elements:', elements);
        console.log('Styles:', styles);
        console.log('Window width:', window.innerWidth);
        
        return { elements, styles };
    };
    
    // Initial styles setup
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
    
    log('Mobile initialization complete');
});
