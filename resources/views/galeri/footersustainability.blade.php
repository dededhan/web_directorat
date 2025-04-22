<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<footer class="text-white" style="background-color: #176369;">
    <div class="container p-6">
        <div class="row justify-content-between">
            <!-- University Logo Section -->
            <div class="col-md-4 mb-4 mb-md-0 d-flex flex-column align-items-center">
                <div class="rounded-circle p-3 mb-4" 
                    style="width: 200px; height: 200px; background-color: rgba(23, 99, 105, 0.9); background-clip: padding-box;">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" 
                        alt="UNJ Logo" class="h-100 w-100 object-fit-contain" />
                </div>
                
                <!-- Social Media Icons -->
                <div class="d-flex gap-4">
                    <a href="https://www.facebook.com/people/Direktorat-Isip-Unj/pfbid05sxgwir3WJi1yZirTaAdvbs3nQ2jypLKp349jsk6BmzxJqZaKvyYHPGUiVQr1Zu8l/" class="text-white hover-text-warning">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/dit.isipunj/" target="_blank" class="text-white hover-text-warning fs-5">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-md-4 mb-4 mb-md-0">
                <h4 class="fs-5 fw-semibold mb-4 border-bottom border-teal pb-2">Kontak Kami</h4>

                <div class="d-flex flex-column gap-4 small">
                    <div class="d-flex align-items-start group">
                        <i class="fas fa-map-marker-alt mt-1 me-3"></i>
                        <p>Gedung M. Syafe'i Lantai 6<br>
                            Jl. Rawamangun Muka, RT.11/RW14, Rawamangun<br>
                            Pulo Gadung, Jakarta Timur, Daerah Khusus Jakarta, 13320</p>
                    </div>

                    <div class="d-flex align-items-center group">
                        <i class="fas fa-envelope me-3"></i>
                        <a href="mailto:dir.inovasi@unj.ac.id" class="text-white text-decoration-none">dir.inovasi@unj.ac.id</a>
                    </div>
                </div>
            </div>

            <!-- Google Maps -->
            <div class="col-md-4">
                <h4 class="fs-5 fw-semibold mb-4 border-bottom border-teal pb-2">Lokasi Kami</h4>
                <div class="rounded overflow-hidden shadow h-100" style="max-height: 250px;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.507858284444!2d106.87609567499013!3d-6.19652469379116!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f492ebd4c571%3A0x1300caf054b25550!2sGedung%20M.Syafe&#39;i%20Universitas%20Negeri%20Jakarta!5e0!3m2!1sid!2sid!4v1742964176588!5m2!1sid!2sid"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Added padding to create more space -->
    <div style="padding-top: 40px;"></div>

    <div class="w-100 text-white py-2" style="background-color: #176369; border-top: 1px solid rgba(255,255,255,0.2);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="d-flex gap-4">
                    <a href="#" class="text-white text-decoration-none">Beranda</a>
                    <a href="#" class="text-white text-decoration-none">Fasilitas</a>
                    <a href="#" class="text-white text-decoration-none">Berita</a>
                    <a href="#" class="text-white text-decoration-none">Tentang Kami</a>
                    <a href="#" class="text-white text-decoration-none">Galeri</a>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <span class="small">© 2025 Universitas Negeri Jakarta. All rights reserved.</span>
            </div>
        </div>
    </div>
</div>
</footer>

<style>
    /* Ensure hover effect on links */
    div.py-2 a:hover {
        color: #ffc107 !important;
        transition: color 0.3s ease;
    }
    
    /* Position at bottom of page */
    html, body {
        min-height: 100vh;
    }
    
    body {
        display: flex;
        flex-direction: column;
    }
    
    main, .content-wrapper {
        flex: 1;
    }
    
    div.py-2 {
        margin-top: auto;
    }
</style>

<script>
    (function() {
        // Initialize footer functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effect for contact items
            const contactItems = document.querySelectorAll('.group');
            contactItems.forEach(item => {
                item.addEventListener('mouseenter', () => {
                    const icon = item.querySelector('i');
                    if (icon) icon.classList.add('text-warning');
                });

                item.addEventListener('mouseleave', () => {
                    const icon = item.querySelector('i');
                    if (icon) icon.classList.remove('text-warning');
                });
            });
        });
    })();
</script>