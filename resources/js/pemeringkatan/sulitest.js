// Sulitest Landing Page Scripts

document.addEventListener('DOMContentLoaded', function() {

    // ── Horizontal scroll container logic ──
    const container = document.getElementById('scroll-container');
    const scrollLeftBtn = document.getElementById('scroll-left-btn');
    const scrollRightBtn = document.getElementById('scroll-right-btn');

    if (container && scrollLeftBtn && scrollRightBtn) {
        scrollLeftBtn.addEventListener('click', function() {
            container.scrollBy({ left: -400, behavior: 'smooth' });
        });
        scrollRightBtn.addEventListener('click', function() {
            container.scrollBy({ left: 400, behavior: 'smooth' });
        });
    }

    // ── Scroll-driven reveal animations ──
    const revealElements = document.querySelectorAll('[data-reveal]');

    if (revealElements.length > 0) {
        const revealObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        revealObserver.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.15, rootMargin: '0px 0px -40px 0px' }
        );

        revealElements.forEach((el) => revealObserver.observe(el));
    }
});
