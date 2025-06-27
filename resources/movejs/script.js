(() => {
    const topBar = document.getElementById('topBar');
    const navbar = document.getElementById('navbar');
    let lastScrollY = window.scrollY;

    window.addEventListener('scroll', () => {
        const currentScrollY = window.scrollY;
        
        if (currentScrollY > lastScrollY) {
            topBar.style.transform = 'translateY(-100%)';
            navbar.style.top = '0';
        } else {
            topBar.style.transform = 'translateY(0)';
            navbar.style.top = '35px';
        }
        
        lastScrollY = currentScrollY;
    });
})();