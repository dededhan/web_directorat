// Scroll detection
let lastScrollTop = 0;
const topBar = document.querySelector('.top-bar');
const navbar = document.querySelector('.navbar');

window.addEventListener('scroll', () => {
  const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

  if (scrollTop > lastScrollTop) {
    // Scrolling down
    if (topBar) topBar.classList.add('top-bar-hidden');
  } else {
    // Scrolling up
    if (topBar) topBar.classList.remove('top-bar-hidden');
  }

  lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // Avoid negative scroll
  
});

// // Slider functionality
// document.addEventListener("DOMContentLoaded", function () {
//   let currentIndex = 0;
//   const images = document.querySelectorAll(".slider-image");
//   const interval = 7000; // 7 detik

//   function showNextImage() {
//     images[currentIndex].classList.remove("active");
//     currentIndex = (currentIndex + 1) % images.length;
//     images[currentIndex].classList.add("active");
//   }

//   // Inisialisasi slider
//   if (images.length > 0) {
//     images[currentIndex].classList.add("active");
//     setInterval(showNextImage, interval);
//   }
// });
