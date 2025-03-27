<style>
/* New Footer Styles */
.unj-footer {
    font-family: 'Poppins', sans-serif;
    color: #ffffff;
    width: 100%;
}

.footer-main {
    background-color: rgba(23, 99, 105, 0.9);
    padding: 50px 0 30px;
}

.footer-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.footer-sections {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 30px;
}

/* Logo Section */
.footer-logo-section {
    flex: 1;
    min-width: 250px;
    max-width: 300px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.logo-circle {
    width: 200px;
    height: 200px;
    background-color: rgba(23, 99, 105, 0.9);
    border-radius: 50%;
    padding: 3px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 25px;
}

.logo-circle img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.social-icons {
    display: flex;
    gap: 20px;
    justify-content: center;
}

.social-icon {
    color: #ffffff;
    font-size: 18px;
    transition: color 0.3s ease;
}

.social-icon:hover {
    color: #f8b739;
}

/* Contact Section */
.footer-contact-section {
    flex: 1;
    min-width: 250px;
    max-width: 350px;
}

.footer-heading {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.contact-item {
    display: flex;
    align-items: flex-start;
}

.contact-item i {
    margin-right: 15px;
    min-width: 16px;
    margin-top: 3px;
}

.contact-item p, 
.contact-item a {
    color: #ffffff;
    text-decoration: none;
    transition: color 0.3s ease;
    font-size: 14px;
    line-height: 1.6;
}

.contact-item a:hover {
    color: #f8b739;
}

/* Map Section */
.footer-map-section {
    flex: 1;
    min-width: 250px;
    max-width: 350px;
}

.map-container {
    height: 250px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

/* Footer Bottom */
.footer-bottom {
    background-color: rgba(20, 85, 90, 0.95);
    padding: 20px 0;
}

.footer-bottom .footer-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
}

.footer-links {
    display: flex;
    flex-wrap: wrap;
    gap: 25px;
}

.footer-links a {
    color: #ffffff;
    text-decoration: none;
    font-size: 14px;
    transition: color 0.3s ease;
}

.footer-links a:hover {
    color: #f8b739;
}

.copyright {
    font-size: 14px;
    opacity: 0.8;
}

/* Responsive Adjustments */
@media (max-width: 992px) {
    .footer-sections {
        justify-content: center;
    }
    
    .footer-logo-section,
    .footer-contact-section,
    .footer-map-section {
        max-width: 400px;
    }
}

@media (max-width: 768px) {
    .footer-bottom .footer-container {
        flex-direction: column;
        text-align: center;
    }
    
    .footer-links {
        justify-content: center;
        margin-bottom: 15px;
    }
}

@media (max-width: 576px) {
    .footer-main {
        padding: 30px 0 20px;
    }
    
    .logo-circle {
        width: 150px;
        height: 150px;
    }
    
    .footer-heading {
        font-size: 16px;
    }
    
    .map-container {
        height: 200px;
    }
    
    .footer-links {
        gap: 15px;
    }
}
</style>

<footer class="unj-footer">
    <div class="footer-main">
        <div class="footer-container">
            <div class="footer-sections">
                <!-- Logo Section -->
                <div class="footer-logo-section">
                    <div class="logo-circle">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" alt="UNJ Logo">
                    </div>
                    <div class="social-icons">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <!-- Contact Section -->
                <div class="footer-contact-section">
                    <h4 class="footer-heading">Kontak Kami</h4>
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <p>Gedung M.Syafe'i Universitas Negeri Jakarta<br>
                                Jl. Rawamangun Muka, RT.11/RW.14, Rawamangun<br>
                                Jakarta Timur 13220</p>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <a href="tel:+123123123">+123123123</a>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:info@unj.ac.id">info@unj.ac.id</a>
                        </div>
                        <div class="contact-item">
                            <i class="fab fa-whatsapp"></i>
                            <a href="https://wa.me/6281234567890">+62 812 3456 7890</a>
                        </div>
                    </div>
                </div>

                <!-- Map Section -->
                <div class="footer-map-section">
                    <h4 class="footer-heading">Lokasi Kami</h4>
                    <div class="map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.507858284444!2d106.87609567499013!3d-6.19652469379116!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f492ebd4c571%3A0x1300caf054b25550!2sGedung%20M.Syafe&#39;i%20Universitas%20Negeri%20Jakarta!5e0!3m2!1sid!2sid!4v1742964176588!5m2!1sid!2sid"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="footer-container">
            <div class="footer-links">
                <a href="#">Beranda</a>
                <a href="#">Fasilitas</a>
                <a href="#">Berita</a>
                <a href="#">Tentang Kami</a>
                <a href="#">Galeri</a>
            </div>
            <div class="copyright">
                © 2025 Universitas Negeri Jakarta. All rights reserved.
            </div>
        </div>
    </div>
</footer>