<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNJ Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <!-- Removed Google Fonts import for Roboto -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
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

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            z-index: 10;
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
    </style>
</head>

<body class="bg-gray-100">
    <!-- Modal -->
    <div class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden" id="loginModal">
        <div class="modal-dialog w-full max-w-4xl mx-auto">
            <div class="modal-content bg-white rounded-3xl overflow-hidden shadow-2xl">
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
                                <i class="fas fa-envelope"></i>
                                <input type="email" name="email" placeholder="Email" required
                                    class="w-full py-3 px-12 border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-teal-800 focus:ring-2 focus:ring-teal-800 focus:ring-opacity-20 transition-all duration-300" />
                            </div>
                            <div class="input-group">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password" placeholder="Password" required
                                    class="w-full py-3 px-12 border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-teal-800 focus:ring-2 focus:ring-teal-800 focus:ring-opacity-20 transition-all duration-300" />
                            </div>
                            <div class="flex justify-center my-4">
                                <img src="https://placehold.co/300x80" alt="reCAPTCHA verification" />
                            </div>
                            <button type="submit"
                                class="btn-primary w-full py-3 rounded-lg text-white font-medium tracking-wide mt-3">SIGN
                                IN</button>
                        </form>
                        <!-- Google Sign-in Button -->
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
                        <p>Admin Panel Login</p>
                        <p class="text-xl font-medium mt-5">Hello, Admin!</p>
                        <p class="opacity-90">Access your admin tools and manage university content with ease.</p>
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
            // First, make sure the modal is hidden by default
            const modal = document.getElementById('loginModal');
            modal.classList.add('hidden');
            modal.classList.remove('block');

            // Only show login modal when login buttons are clicked
            const loginButtons = document.querySelectorAll('.login');
            loginButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    modal.classList.remove('hidden');
                    modal.classList.add('block');
                });
            });

            // Add ability to close modal by clicking outside
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('block');
                }
            });

            // Optional: Add close button functionality
            const closeModalButton = modal.querySelector('[data-dismiss="modal"]');
            if (closeModalButton) {
                closeModalButton.addEventListener('click', function() {
                    modal.classList.add('hidden');
                    modal.classList.remove('block');
                });
            }
        });
    </script>
</body>

</html>