<footer class="bg-teal-700 text-white">
    <div class="p-4">
        <div class="flex flex-wrap my-5 mt-4">
            <!-- University Logo & Info -->
            <div class="w-full lg:w-1/3 md:w-full text-center mb-6 lg:mb-0">
                <div class="flex flex-col items-center">
                    <div class="rounded-full bg-white shadow flex items-center justify-center mb-4"
                        style="width: 150px; height: 150px;">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" 
                            class="h-full w-full p-2"
                            alt="UNJ Logo" />
                    </div>
                    <h4 class="text-xl font-bold">Universitas Negeri Jakarta</h4>

                    <!-- Social Media Icons -->
                    <div class="mt-3 flex space-x-4">
                        <a href="#" class="text-white hover:text-yellow-400 transition-colors"><i class="fab fa-twitter text-lg"></i></a>
                        <a href="#" class="text-white hover:text-yellow-400 transition-colors"><i class="fab fa-facebook text-lg"></i></a>
                        <a href="#" class="text-white hover:text-yellow-400 transition-colors"><i class="fab fa-linkedin text-lg"></i></a>
                        <a href="#" class="text-white hover:text-yellow-400 transition-colors"><i class="fab fa-youtube text-lg"></i></a>
                    </div>
                </div>
            </div>

            <!-- Contact Info Section -->
            <div class="w-full lg:w-1/3 md:w-full mb-6 lg:mb-0">
                <h5 class="uppercase mb-4 text-center font-bold">Address</h5>

                <div class="flex items-center mb-4">
                    <i class="fas fa-map-marker-alt w-5 mr-3"></i>
                    <p class="mb-0">Jl. Rawamangun Muka, RT.11/RW.14,<br>
                        Rawamangun, Pulo Gadung, East Jakarta City,<br>
                        Special Capital Region of Jakarta 13220</p>
                </div>

                <div class="flex items-center mb-4">
                    <i class="fas fa-phone w-5 mr-3"></i>
                    <p class="mb-0">+123123123</p>
                </div>

                <div class="flex items-center mb-4">
                    <i class="fas fa-envelope w-5 mr-3"></i>
                    <p class="mb-0">info@yourmail.com</p>
                </div>

                <div class="flex items-center mb-4">
                    <i class="fab fa-whatsapp w-5 mr-3"></i>
                    <p class="mb-0">Whatsapp</p>
                </div>
            </div>

            <!-- Quick Links Section -->
            <div class="w-full lg:w-1/3 md:w-full">
                <h5 class="uppercase mb-4 text-center font-bold">Menu</h5>
                <ul class="list-none text-center">
                    <li class="mb-3 border-b border-teal-600 pb-2">
                        <a href="#" class="text-white hover:text-yellow-400 transition-colors">Fasilitas</a>
                    </li>
                    <li class="mb-3 border-b border-teal-600 pb-2">
                        <a href="#" class="text-white hover:text-yellow-400 transition-colors">Berita</a>
                    </li>
                    <li class="mb-3 border-b border-teal-600 pb-2">
                        <a href="#" class="text-white hover:text-yellow-400 transition-colors">Tentang Kami</a>
                    </li>
                    <li class="mb-3">
                        <a href="#" class="text-white hover:text-yellow-400 transition-colors">Galeri</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="text-center p-3 bg-black bg-opacity-20">
        © 2024 <a class="text-white hover:text-yellow-400 transition-colors" href="#">Universitas Negeri Jakarta</a>.
        All rights reserved.
    </div>
</footer>

<script>
(function() {
    // Create a unique namespace for your footer functionality
    window.UNJFooter = window.UNJFooter || {};
    
    // Initialize footer functionality
    UNJFooter.init = function() {
        console.log('UNJ Footer initialized');
        // Add any footer-specific functionality here
    };
    
    // Call initialization when document is ready
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        setTimeout(UNJFooter.init, 1);
    } else {
        document.addEventListener('DOMContentLoaded', UNJFooter.init);
    }
})();
</script>