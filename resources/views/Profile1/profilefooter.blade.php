<link rel="stylesheet" href="{{ asset('inovasi/footer.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<footer class="text-white footer-custom">
    <style>
        /* Base styling */
        .footer-custom {
            background-color: #006666;
            color: white;
            font-family: Arial, sans-serif;
        }
        
        /* Grid system replacement */
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }
        
        .col-lg-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
            padding: 0 15px;
        }
        
        /* Spacing utilities */
        .p-4 {
            padding: 1.5rem;
        }
        
        .p-3 {
            padding: 1rem;
        }
        
        .my-5 {
            margin-top: 3rem;
            margin-bottom: 3rem;
        }
        
        .mt-4 {
            margin-top: 1.5rem;
        }
        
        .mb-4 {
            margin-bottom: 1.5rem;
        }
        
        .mb-3 {
            margin-bottom: 1rem;
        }
        
        .mt-3 {
            margin-top: 1rem;
        }
        
        .me-3 {
            margin-right: 1rem;
        }
        
        .mb-0 {
            margin-bottom: 0;
        }
        
        .mb-5 {
            margin-bottom: 3rem;
        }
        
        .pb-2 {
            padding-bottom: 0.5rem;
        }
        
        /* Display utilities */
        .d-flex {
            display: flex;
        }
        
        .flex-column {
            flex-direction: column;
        }
        
        .align-items-center {
            align-items: center;
        }
        
        .justify-content-center {
            justify-content: center;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-start {
            text-align: left;
        }
        
        /* Background and text colors */
        .bg-white {
            background-color: white;
        }
        
        .text-white {
            color: white;
        }
        
        .text-uppercase {
            text-transform: uppercase;
        }
        
        .text-decoration-none {
            text-decoration: none;
        }
        
        /* Shadow */
        .shadow {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        /* Rounded elements */
        .rounded-circle {
            border-radius: 50%;
        }
        
        .rounded {
            border-radius: 0.25rem;
        }
        
        /* List styles */
        .list-unstyled {
            list-style: none;
            padding-left: 0;
        }
        
        /* Border utilities */
        .border-bottom {
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Custom footer styles */
        .footer-custom .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .footer-custom .contact-item i {
            margin-right: 10px;
            width: 20px;
        }
        
        .map-container {
            width: 100%;
            height: 100px;
            margin-top: 1rem;
        }
        
        /* Hover effects */
        .hover\:text-yellow-400:hover {
            color: #facc15;
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .col-lg-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }
            
            .mb-md-0 {
                margin-bottom: 0;
            }
        }
        
        @media (max-width: 768px) {
            .col-md-12 {
                flex: 0 0 100%;
                max-width: 100%;
            }
            
            .mb-md-0 {
                margin-bottom: 0;
            }
        }
    </style>

    <div class="p-4">
        <div class="row my-5 mt-4">
            <div class="container col-lg-4 col-md-12 text-center">
                
                <div class="d-flex flex-column align-items-center">
                    <div class="rounded-circle bg-white shadow d-flex align-items-center justify-content-center mb-4"
                        style="width: 150px; height: 150px;">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" 
                            height="120%"
                            width="120%"
                            alt="UNJ Logo" />
                    </div>
                    <h4>Universitas Negeri Jakarta</h4>

                    <!-- Social Media Icons -->
                    <div class="mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-linkedin fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>
            </div>


            <!-- Contact Info Section -->
            <div class="col-lg-4 col-md-16 mb-5 mb-md-0 text-start">
                <h5 class="text-uppercase mb-4 text-center">Address</h5>

                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <p class="mb-0">Jl. Rawamangun Muka, RT.11/RW.14,<br>
                        Rawamangun, Pulo Gadung, East Jakarta City,<br>
                        Special Capital Region of Jakarta 13220</p>
                </div>

                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <p class="mb-0">+123123123</p>
                </div>

                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <p class="mb-0">info@yourmail.com</p>
                </div>

                <div class="contact-item">
                    <i class="fab fa-whatsapp"></i>
                    <p class="mb-0">Whatsapp</p>
                </div>

                {{-- <div class="map-container">
                    <img src="/api/placeholder/400/200" alt="Location Map" class="img-fluid rounded" />
                </div> --}}
            </div>

            <!-- Quick Links Section -->
            <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                <h5 class="text-uppercase mb-4 text-center">Menu</h5>
                <ul class="list-unstyled text-center">
                    <li class="mb-3 border-bottom pb-2">
                        <a href="#" class="text-white text-decoration-none hover:text-yellow-400">Fasilitas</a>
                    </li>
                    <li class="mb-3 border-bottom pb-2">
                        <a href="#" class="text-white text-decoration-none hover:text-yellow-400">Berita</a>
                    </li>
                    <li class="mb-3 border-bottom pb-2">
                        <a href="#" class="text-white text-decoration-none hover:text-yellow-400">Tentang Kami</a>
                    </li>
                    <li class="mb-3">
                        <a href="#" class="text-white text-decoration-none hover:text-yellow-400">Galeri</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
        © 2024 <a class="text-white text-decoration-none" href="#">Universitas Negeri Jakarta</a>.
        All rights reserved.
    </div>

</footer>
<script src="{{ asset('script.js') }}"></script>
</body>
</html>