document.addEventListener('DOMContentLoaded', () => {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const closeSidebar = document.getElementById('close-sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const dropdownButtons = document.querySelectorAll('.sidebar-dropdown > button');

    const openSidebar = () => {
        if (mobileSidebar && sidebarOverlay) {
            mobileSidebar.classList.remove('translate-x-full');
            sidebarOverlay.classList.remove('hidden');
            document.body.classList.add('sidebar-open'); // Mencegah scroll body
        }
    };

    const closeTheSidebar = () => {
        if (mobileSidebar && sidebarOverlay) {
            mobileSidebar.classList.add('translate-x-full');
            sidebarOverlay.classList.add('hidden');
            document.body.classList.remove('sidebar-open'); // Mengizinkan scroll body kembali
        }
    };

    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', openSidebar);
    }

    if (closeSidebar) {
        closeSidebar.addEventListener('click', closeTheSidebar);
    }
    
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeTheSidebar);
    }

    // Logika untuk dropdown di dalam sidebar
    if (dropdownButtons) {
        dropdownButtons.forEach(button => {
            button.addEventListener('click', () => {
                const dropdownMenu = button.nextElementSibling;
                const dropdownIcon = button.querySelector('i.fa-chevron-down');
                
                if (dropdownMenu) {
                    dropdownMenu.classList.toggle('hidden');
                }
                if(dropdownIcon) {
                    dropdownIcon.classList.toggle('rotate-180');
                }
            });
        });
    }
});
