// Script untuk menyembunyikan top bar ketika di-scroll
let lastScrollTop = 0;
const topBar = document.getElementById('topBar');
const navbar = document.getElementById('navbar');

window.addEventListener('scroll', () => {
    const scrollTop = window.scrollY;
    if (scrollTop > lastScrollTop) {
        // Ketika scroll ke bawah, sembunyikan top bar
        topBar.classList.add('hidden');
    } else {
        // Ketika scroll ke atas, tampilkan top bar
        topBar.classList.remove('hidden');
    }
    lastScrollTop = scrollTop;
});
