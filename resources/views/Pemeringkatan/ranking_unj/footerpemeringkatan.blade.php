<footer class="text-white" style="background-color: rgba(23, 99, 105, 0.9);">
    <div class="container mx-auto p-6">
        <div class="flex flex-wrap justify-between">
            <!-- University Logo Section - Larger and centered logo -->
            <div class="w-full md:w-1/3 mb-8 md:mb-0 flex flex-col items-center">
                <div class="rounded-full p-3 mb-6" 
                style="width: 200px; height: 200px; background-color: rgba(23, 99, 105, 0.9); background-clip: padding-box;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" 
                    alt="UNJ Logo" class="h-full w-full object-contain" />
            </div>
            

                <!-- Social Media Icons -->
                <div class="flex space-x-5">
                    <a href="https://www.facebook.com/people/Direktorat-Isip-Unj/pfbid05sxgwir3WJi1yZirTaAdvbs3nQ2jypLKp349jsk6BmzxJqZaKvyYHPGUiVQr1Zu8l/" class="hover:text-yellow-500">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    {{-- <a href="#" class="hover:text-yellow-400 transition-colors text-xl">
                        <i class="fab fa-twitter"></i>
                    </a> --}}
                    <a href="https://www.instagram.com/dit.isipunj/" target="_blank" class="hover:text-yellow-400 transition-colors text-xl">
                        <i class="fab fa-instagram"></i>
                    </a>
                    {{-- <a href="#" class="hover:text-yellow-400 transition-colors text-xl">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="#" class="hover:text-yellow-400 transition-colors text-xl">
                        <i class="fab fa-linkedin-in"></i>
                    </a> --}}
                </div>
            </div>

            <!-- Contact Info - Enhanced -->
            <div class="w-full md:w-1/3 mb-8 md:mb-0">
                <h4 class="text-lg font-semibold mb-4 border-b border-teal-600 pb-2">Kontak Kami</h4>

                <div class="space-y-4 text-sm">
                    <div class="flex items-start group">
                        <i class="fas fa-map-marker-alt mt-1 mr-3 group-hover:text-yellow-400 transition-colors"></i>
                        <p>Gedung M. Syafe'i Lantai 6<br>
                            Jl. Rawamangun Muka, RT.11/RW14, Rawamangun<br>
                            Pulo Gadung, Jakarta Timur, Daerah Khusus Jakarta, 13320</p>
                    </div>

                    {{-- <div class="flex items-center group">
                        <i class="fas fa-phone mr-3 group-hover:text-yellow-400 transition-colors"></i>
                        <a href="tel:+123123123" class="hover:text-yellow-400 transition-colors">+123123123</a>
                    </div> --}}

                    <div class="flex items-center group">
                        <i class="fas fa-envelope mr-3 group-hover:text-yellow-400 transition-colors"></i>
                        <a href="mailto:info@unj.ac.id"
                        class="hover:text-yellow-400 transition-colors">dir.inovasi@unj.ac.id</a>
                    </div>
{{-- 
                    <div class="flex items-center group">
                        <i class="fab fa-whatsapp mr-3 group-hover:text-yellow-400 transition-colors"></i>
                        <a href="https://wa.me/6281234567890" class="hover:text-yellow-400 transition-colors">+62 812
                            3456 7890</a>
                    </div> --}}
                </div>
            </div>

            <!-- Google Maps - Kept the same -->
            <div class="w-full md:w-1/3">
                <h4 class="text-lg font-semibold mb-4 border-b border-teal-600 pb-2">Lokasi Kami</h4>
                <div class="h-64 w-full rounded-lg overflow-hidden shadow-lg">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.507858284444!2d106.87609567499013!3d-6.19652469379116!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f492ebd4c571%3A0x1300caf054b25550!2sGedung%20M.Syafe&#39;i%20Universitas%20Negeri%20Jakarta!5e0!3m2!1sid!2sid!4v1742964176588!5m2!1sid!2sid"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links & Copyright - Simplified -->
    <div class="border-t border-teal-600">
        <div class="container mx-auto px-6 py-4">
            <div class="flex flex-wrap justify-center md:justify-between items-center">
                <div class="flex flex-wrap justify-center space-x-6 mb-4 md:mb-0">
                    <a href="#" class="text-sm hover:text-yellow-400 transition-colors">Beranda</a>
                    <a href="#" class="text-sm hover:text-yellow-400 transition-colors">Fasilitas</a>
                    <a href="#" class="text-sm hover:text-yellow-400 transition-colors">Berita</a>
                    <a href="#" class="text-sm hover:text-yellow-400 transition-colors">Tentang Kami</a>
                    <a href="#" class="text-sm hover:text-yellow-400 transition-colors">Galeri</a>
                </div>

                <div class="text-sm opacity-80">
                    © 2025 Universitas Negeri Jakarta. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</footer>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script>
    (function() {
        // Create a unique namespace for your footer functionality
        window.UNJFooter = window.UNJFooter || {};

        // Initialize footer functionality
        UNJFooter.init = function() {
            console.log('UNJ Modern Footer initialized');

            // Add hover effect for contact items
            const contactItems = document.querySelectorAll('.group');
            contactItems.forEach(item => {
                item.addEventListener('mouseenter', () => {
                    const icon = item.querySelector('i');
                    if (icon) icon.classList.add('text-yellow-400');
                });

                item.addEventListener('mouseleave', () => {
                    const icon = item.querySelector('i');
                    if (icon) icon.classList.remove('text-yellow-400');
                });
            });
        };

        // Call initialization when document is ready
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            setTimeout(UNJFooter.init, 1);
        } else {
            document.addEventListener('DOMContentLoaded', UNJFooter.init);
        }
    })();
</script>
