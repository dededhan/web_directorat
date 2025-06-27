document.addEventListener('DOMContentLoaded', function() {
    // Sidebar menu functionality
    const allSideMenu = document.querySelectorAll('#sidebar .side-menu li a');
    const toggleSidebar = document.querySelector('#sidebar .brand .toggle-sidebar');
    const sidebar = document.getElementById('sidebar');

    // Toggle sidebar using the menu button in the sidebar
    if (toggleSidebar) {
        toggleSidebar.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent default behavior if within an <a> tag
            sidebar.classList.toggle('hide');
        });
    }

    // Active menu item handling
    allSideMenu.forEach(item => {
        const li = item.parentElement;
        item.addEventListener('click', function () {
            allSideMenu.forEach(i => {
                i.parentElement.classList.remove('active');
            });
            li.classList.add('active');
        });
    });

    // Search functionality (if present)
    const searchButton = document.querySelector('#content nav form .form-input button');
    const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
    const searchForm = document.querySelector('#content nav form');

    if (searchButton && searchButtonIcon && searchForm) {
        searchButton.addEventListener('click', function (e) {
            if(window.innerWidth < 576) {
                e.preventDefault();
                searchForm.classList.toggle('show');
                if(searchForm.classList.contains('show')) {
                    searchButtonIcon.classList.replace('bx-search', 'bx-x');
                } else {
                    searchButtonIcon.classList.replace('bx-x', 'bx-search');
                }
            }
        });
    }

    // Responsive sidebar handling
    function handleResize() {
        if(window.innerWidth < 768) {
            sidebar.classList.add('hide');
        } else if (window.innerWidth > 768 && window.innerWidth < 1200) {
            // Optional: Decide if sidebar should be shown on medium screens
            // sidebar.classList.remove('hide');
        }
        
        if(window.innerWidth > 576) {
            if (searchButtonIcon && searchForm) {
                searchButtonIcon.classList.replace('bx-x', 'bx-search');
                searchForm.classList.remove('show');
            }
        }
    }

    // Initial resize check
    handleResize();

    // Resize event listener
    window.addEventListener('resize', handleResize);

    // Dark mode toggle (if present)
    const switchMode = document.getElementById('switch-mode');
    if (switchMode) {
        switchMode.addEventListener('change', function () {
            if(this.checked) {
                document.body.classList.add('dark');
            } else {
                document.body.classList.remove('dark');
            }
        });
    }
    
    // Add tooltip data attributes to sidebar items
    const sideMenuItems = document.querySelectorAll('#sidebar .side-menu li');
    sideMenuItems.forEach(item => {
        const textElement = item.querySelector('.text');
        if (textElement) {
            const text = textElement.textContent.trim();
            item.setAttribute('data-title', text);
        }
    });
});