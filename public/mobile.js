// mobile.js - Complete Implementation

document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const closeSidebar = document.getElementById('close-sidebar');
    const menuIcon = document.getElementById('menu-icon');
    
    // Show sidebar
    function showSidebar() {
        mobileSidebar.classList.add('active');
        sidebarOverlay.classList.add('active');
        document.body.classList.add('sidebar-open');
        menuIcon.classList.remove('fa-bars');
        menuIcon.classList.add('fa-times');
    }
    
    // Hide sidebar
    function hideSidebar() {
        mobileSidebar.classList.remove('active');
        sidebarOverlay.classList.remove('active');
        document.body.classList.remove('sidebar-open');
        menuIcon.classList.remove('fa-times');
        menuIcon.classList.add('fa-bars');
    }
    
    // Toggle sidebar when menu button is clicked
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (mobileSidebar.classList.contains('active')) {
                hideSidebar();
            } else {
                showSidebar();
            }
        });
    }
    
    // Close sidebar when close button is clicked
    if (closeSidebar) {
        closeSidebar.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            hideSidebar();
        });
    }
    
    // Close sidebar when overlay is clicked
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            hideSidebar();
        });
    }
    
    // Handle dropdown menus
    const dropdownButtons = document.querySelectorAll('.sidebar-dropdown button');
    
    dropdownButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdown = this.nextElementSibling;
            const icon = this.querySelector('.fa-chevron-down');
            
            // Toggle dropdown
            if (dropdown.classList.contains('active')) {
                dropdown.classList.remove('active');
                icon.style.transform = 'rotate(0)';
            } else {
                // Close other dropdowns first
                document.querySelectorAll('.sidebar-dropdown ul.active').forEach(openDropdown => {
                    openDropdown.classList.remove('active');
                    openDropdown.previousElementSibling.querySelector('.fa-chevron-down').style.transform = 'rotate(0)';
                });
                
                dropdown.classList.add('active');
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });
    
    // Close sidebar on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileSidebar.classList.contains('active')) {
            hideSidebar();
        }
    });
    
    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth > 767 && mobileSidebar.classList.contains('active')) {
                hideSidebar();
            }
        }, 250);
    });
});

// Ensure proper display on page load
window.addEventListener('load', function() {
    // Fix viewport meta tag
    const viewportMeta = document.querySelector('meta[name="viewport"]');
    if (viewportMeta) {
        viewportMeta.setAttribute('content', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no');
    }
    
    // Ensure mobile display
    if (window.innerWidth <= 767) {
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
// mobile-fixes.js - Add this to your existing mobile.js file
document.addEventListener('DOMContentLoaded', function() {
    // Fix 1: Prevent default zooming on mobile
    const viewport = document.querySelector('meta[name="viewport"]');
    if (viewport) {
        viewport.setAttribute('content', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no');
    }

    // Fix 2: Mobile sidebar functionality
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const closeSidebar = document.getElementById('close-sidebar');
    const dropdownButtons = document.querySelectorAll('.sidebar-dropdown button');
    
    // Function to show sidebar
    function showSidebar() {
        mobileSidebar.style.transform = 'translateX(0)';
        sidebarOverlay.style.opacity = '1';
        sidebarOverlay.style.visibility = 'visible';
        sidebarOverlay.style.pointerEvents = 'auto';
        document.body.classList.add('sidebar-open');
    }
    
    // Function to hide sidebar
    function hideSidebar() {
        mobileSidebar.style.transform = 'translateX(100%)';
        sidebarOverlay.style.opacity = '0';
        sidebarOverlay.style.visibility = 'hidden';
        sidebarOverlay.style.pointerEvents = 'none';
        document.body.classList.remove('sidebar-open');
    }
    
    // Toggle sidebar when menu button is clicked
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            showSidebar();
        });
    }
    
    // Close sidebar when close button is clicked
    if (closeSidebar) {
        closeSidebar.addEventListener('click', function(e) {
            e.preventDefault();
            hideSidebar();
        });
    }
    
    // Close sidebar when overlay is clicked
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            hideSidebar();
        });
    }
    
    // Handle dropdown menus in sidebar
    dropdownButtons.forEach(button => {
        button.addEventListener('click', function() {
            const dropdown = this.nextElementSibling;
            const icon = this.querySelector('.fa-chevron-down');
            
            dropdown.classList.toggle('hidden');
            
            if (!dropdown.classList.contains('hidden')) {
                icon.style.transform = 'rotate(180deg)';
            } else {
                icon.style.transform = 'rotate(0)';
            }
        });
    });
    
    // Close sidebar on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !mobileSidebar.style.transform.includes('100%')) {
            hideSidebar();
        }
    });
});