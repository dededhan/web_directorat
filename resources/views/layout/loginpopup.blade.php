<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNJ Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        * {
            font-family: Arial, sans-serif !important;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .modal-container {
            display: flex;
            min-height: 500px;
        }

        .left-panel {
            flex: 1;
            padding: 40px;
            background: white;
        }

        .right-panel {
            flex: 1;
            padding: 40px;
            background: linear-gradient(135deg, #006666 0%, #004d4d 100%);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .right-panel::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .right-panel::after {
            content: "";
            position: absolute;
            bottom: -70px;
            left: -70px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
        }

        .btn-primary {
            background: linear-gradient(135deg, #006666 0%, #005555 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #005555 0%, #004444 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 85, 85, 0.2);
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group i.left-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            z-index: 10;
        }
        
        /* Gaya untuk ikon mata */
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            cursor: pointer;
            z-index: 10;
            padding: 5px; /* Area klik yang lebih besar */
        }

        .decoration-icons {
            position: absolute;
            bottom: 30px;
            right: 30px;
        }

        .decoration-icons i {
            font-size: 20px;
            margin-left: 10px;
            opacity: 0.5;
        }

        /* Modal animation */
        .modal {
            transition: opacity 0.25s ease;
        }

        .modal-dialog {
            transition: transform 0.25s ease;
        }

        /* --- PERBAIKAN RESPONSIVE UNTUK MOBILE --- */
        @media (max-width: 768px) {
            .modal-dialog {
                width: 95%;
                margin: 1rem auto;
                max-height: 90vh;
                overflow-y: auto;
            }

            .modal-container {
                flex-direction: column;
                min-height: auto;
            }

            .right-panel {
                display: none;
            }

            .left-panel {
                flex: 1 1 auto;
                padding: 25px;
            }

            .modal-content {
                max-height: 90vh;
                display: flex;
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .left-panel {
                padding: 20px;
            }
            .left-panel h1 {
                font-size: 1.25rem;
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden" id="loginModal" style="z-index: 99999; position: fixed; top: 0; left: 0; right: 0; bottom: 0;">
        <div class="modal-dialog w-full max-w-4xl mx-auto my-8">
            <div class="modal-content bg-white rounded-3xl overflow-hidden shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="modal-container">
                    <div class="left-panel">
                        <img src="https://spm.unj.ac.id/wp-content/uploads/2024/08/cropped-Logo-UNJ-PTNBH-RGB_Logo_Motto_Transparan.png"
                            alt="UNJ Logo" class="h-16 mb-5" />
                        <h1 class="text-2xl font-semibold text-teal-800 mb-4">Sign In</h1>
                        <p class="text-gray-600 text-sm mb-6">Welcome to the Admin Portal. Please login with your
                            credentials to access the system.</p>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-group">
                                <i class="fas fa-envelope left-icon"></i>
                                <input type="email" name="email" placeholder="Email" required
                                    class="w-full py-3 px-12 border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-teal-800 focus:ring-2 focus:ring-teal-800 focus:ring-opacity-20 transition-all duration-300" />
                            </div>
                            <div class="input-group">
                                <i class="fas fa-lock left-icon"></i>
                                <input type="password" name="password" id="passwordInput" placeholder="Password" required
                                    class="w-full py-3 pl-12 pr-12 border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-teal-800 focus:ring-2 focus:ring-teal-800 focus:ring-opacity-20 transition-all duration-300" />
                                {{-- Ikon Mata untuk toggle password visibility --}}
                                <i class="fas fa-eye toggle-password" id="togglePassword"></i> 
                            </div>

                            <div class="flex justify-center my-4">
                                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                            </div>
                            
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="text-red-500 text-sm block text-center mb-2">
                                    {{ $errors->first('g-recaptcha-response') }}
                                </span>
                            @endif
                            <button type="submit"
                                class="btn-primary w-full py-3 rounded-lg text-white font-medium tracking-wide mt-3">SIGN
                                IN</button>
                        </form>
                        <div class="mt-4">
                            <a href="{{ route('login.google') }}"
                                class="w-full py-3 flex items-center justify-center rounded-lg bg-white border border-gray-300 text-gray-700 font-medium tracking-wide mt-3 text-center transition-all duration-300 hover:bg-gray-50">
                                <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google logo"
                                    class="h-5 mr-2">
                                SIGN IN WITH GOOGLE
                            </a>
                        </div>
                        <a href="#"
                            class="text-center block mt-5 text-teal-800 text-sm hover:text-teal-900 hover:underline transition-all duration-300">Forgot
                            Your Password?</a>
                    </div>
                    <div class="right-panel">
                        <h2 class="text-3xl font-semibold mb-8 relative">UNJ Dashboard
                            <span class="absolute left-0 bottom-0 w-10 h-0.5 bg-yellow-400"
                                style="bottom: -10px;"></span>
                        </h2>
                        <p class="opacity-90 mt-4">Silakan login untuk mengakses berbagai fitur dan layanan administrasi universitas.</p>
                        <div class="decoration-icons">
                            <i class="fas fa-graduation-cap"></i>
                            <i class="fas fa-book"></i>
                            <i class="fas fa-university"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                footer: '<a href="#">Why do I have this issue?</a>'
            });
        </script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('loginModal');
            const loginButtons = document.querySelectorAll('.login');
            
            // Elemen untuk toggle password
            const passwordInput = document.getElementById('passwordInput');
            const togglePassword = document.getElementById('togglePassword');

            // 1. Fungsi Toggle Password
            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    // Cek tipe input: jika 'password', ubah ke 'text', jika 'text', ubah ke 'password'
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    // Ganti ikon mata
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash'); // Menggunakan ikon mata tertutup
                });
            }

            // Ini fungsi untuk menutup sidebar di mobile (dari kode lama)
            const closeMobileSidebar = () => {
                const mobileSidebar = document.getElementById('mobile-sidebar');
                const sidebarOverlay = document.getElementById('sidebar-overlay');
                
                if (mobileSidebar) {
                    mobileSidebar.style.transform = 'translateX(100%)';
                }
                if (sidebarOverlay) {
                    sidebarOverlay.style.opacity = '0';
                    sidebarOverlay.style.pointerEvents = 'none';
                }
                document.body.classList.remove('sidebar-open');
            };

            // Logika menampilkan modal login
            loginButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Tutup sidebar mobile sebelum menampilkan modal
                    closeMobileSidebar();
                    
                    // Tampilkan modal
                    modal.classList.remove('hidden');
                });
            });

            // Logika menutup modal ketika klik di luar area modal
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
</body>

</html>