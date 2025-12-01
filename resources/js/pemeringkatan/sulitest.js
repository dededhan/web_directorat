// Sulitest Landing Page Scripts

document.addEventListener('DOMContentLoaded', function() {
    // Horizontal scroll container logic
    const container = document.getElementById('scroll-container');
    const scrollLeftBtn = document.getElementById('scroll-left-btn');
    const scrollRightBtn = document.getElementById('scroll-right-btn');

    if (container && scrollLeftBtn && scrollRightBtn) {
        scrollLeftBtn.addEventListener('click', function() {
            container.scrollBy({
                left: -400,
                behavior: 'smooth'
            });
        });

        scrollRightBtn.addEventListener('click', function() {
            container.scrollBy({
                left: 400,
                behavior: 'smooth'
            });
        });
    }
});
