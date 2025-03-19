document.addEventListener('DOMContentLoaded', function() {
    // Sidebar menu functionality
    const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');
    const menuBar = document.querySelector('#content nav .bx.bx-menu');
    const sidebar = document.getElementById('sidebar');

    // Toggle sidebar
    menuBar.addEventListener('click', function () {
        sidebar.classList.toggle('hide');
    });

    // Active menu item handling
    allSideMenu.forEach(item => {
        const li = item.parentElement;
        item.addEventListener('click', function () {
            allSideMenu.forEach(i => {
                i.parentElement.classList.remove('active');
            })
            li.classList.add('active');
        });
    });

    // Search functionality
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

    // Dark mode toggle
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
});

// Add tooltip data attributes to sidebar items
document.addEventListener('DOMContentLoaded', function() {
    const sideMenuItems = document.querySelectorAll('#sidebar .side-menu li');
    
    sideMenuItems.forEach(item => {
        const text = item.querySelector('.text').textContent.trim();
        item.setAttribute('data-title', text);
    });
});