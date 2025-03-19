<!-- resources/views/footernew.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .footer-wrapper {
            background-color: #006666;
            color: white;
            font-family: Arial, sans-serif;
        }
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            display: flex;
            flex-wrap: wrap;
        }
        .footer-column {
            flex: 1;
            min-width: 300px;
            padding: 0 15px;
            margin-bottom: 20px;
            text-align: center;
        }
        .footer-logo img {
            width: 100px;
            height: auto;
            margin-bottom: 15px;
        }
        .footer-social a {
            color: white;
            margin: 0 8px;
        }
        .footer-title {
            text-transform: uppercase;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .footer-address p {
            margin-bottom: 10px;
        }
        .footer-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .footer-menu li {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .footer-menu li:last-child {
            border-bottom: none;
        }
        .footer-menu a {
            color: white;
            text-decoration: none;
        }
        .footer-copyright {
            background-color: rgba(0, 0, 0, 0.2);
            text-align: center;
            padding: 15px 0;
        }
    </style>
</head>
<body>
    <div class="footer-wrapper">
        <div class="footer-container">
            <!-- Logo and social -->
            <div class="footer-column">
                <div class="footer-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" alt="UNJ Logo">
                    <h5>Universitas Negeri Jakarta</h5>
                </div>
                <div class="footer-social">
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <!-- Address -->
            <div class="footer-column">
                <h5 class="footer-title">ADDRESS</h5>
                <div class="footer-address">
                    <p><i class="fas fa-map-marker-alt"></i> Jl. Rawamangun Muka, RT.11/RW.14,<br>Rawamangun, Pulo Gadung, East Jakarta City,<br>Special Capital Region of Jakarta 13220</p>
                    <p><i class="fas fa-phone"></i> +123123123</p>
                    <p><i class="fas fa-envelope"></i> info@yourmail.com</p>
                    <p><i class="fab fa-whatsapp"></i> Whatsapp</p>
                </div>
            </div>
            
            <!-- Menu -->
            <div class="footer-column">
                <h5 class="footer-title">MENU</h5>
                <ul class="footer-menu">
                    <li><a href="#">Fasilitas</a></li>
                    <li><a href="#">Berita</a></li>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Galeri</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-copyright">
            © 2024 Universitas Negeri Jakarta. All rights reserved.
        </div>
    </div>
</body>
</html>