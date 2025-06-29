/**
 * Inisialisasi slider gambar latar belakang untuk Hero Section.
 */
export default function initHeroSlider() {
    const heroSection = document.getElementById('heroSection');
    if (!heroSection) return;

    const backgroundImages = [
        "/images/logos/image_corousel.jpg",
        "/images/TERBUK TAMPAK DEPAN.png",
        "/images/GEDUNG REKTORAT.png",
        "/images/om.png",
    ];

    if (backgroundImages.length === 0) return;

    let currentImageIndex = 0;
    setInterval(() => {
        currentImageIndex = (currentImageIndex + 1) % backgroundImages.length;
        const newImageUrl = backgroundImages[currentImageIndex] || '/images/GEDUNG%20REKTORAT.png';
        heroSection.style.backgroundImage =
            `linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('${newImageUrl}')`;
    }, 5000); // Ganti gambar setiap 5 detik
}
