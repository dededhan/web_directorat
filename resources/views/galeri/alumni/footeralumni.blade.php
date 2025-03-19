
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('pemeringkatan/footer.css') }}">

<footer class="text-white footer-custom">
    <style>
        .footer-custom {
            background-color: #006666;
        }

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