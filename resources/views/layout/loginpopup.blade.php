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

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            pointer-events: none;
            z-index: 10;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 0.75rem 0.75rem 2.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            background-color: #f9fafb;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #006666;
            box-shadow: 0 0 0 3px rgba(0, 102, 102, 0.2);
            background-color: #fff;
        }

        .decoration-icons {
            position: absolute;
            bottom: 30px;
            right: 30px;
            display: flex;
            gap: 15px;
        }

        .decoration-icons i {
            font-size: 20px;
            opacity: 0.5;
            transition: opacity 0.2s ease;
        }

        .decoration-icons i:hover {
            opacity: 0.8;
        }

        /* Modal animation */
        .modal {
            transition: opacity 0.25s ease;
        }

        .modal-dialog {
            transition: transform 0.25s ease;
        }
        
        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            background-color: #fff;
            color: #4b5563;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .google-btn:hover {
            background-color: #f9fafb;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
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
                                <span class="input-icon">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" name="email" placeholder="Email" required
                                    class="form-input" />
                            </div>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" name="password" placeholder="Password" required
                                    class="form-input" />
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
                        <!-- Google Sign-in Button -->
                        <div class="mt-4">
                            <a href="{{ route('login.google') }}" class="google-btn">
                                <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google logo"
                                    class="h-5">
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
            // Make sure the modal is hidden by default
            const modal = document.getElementById('loginModal');
            
            // Hide modal first
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('block');
            }

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
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.classList.add('hidden');
                        modal.classList.remove('block');
                    }
                });
            }

            // Add close button functionality
            const closeModalButton = modal?.querySelector('[data-dismiss="modal"]');
            if (closeModalButton) {
                closeModalButton.addEventListener('click', function() {
                    modal.classList.add('hidden');
                    modal.classList.remove('block');
                });
            }
            
            // Add escape key to close modal
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                    modal.classList.add('hidden');
                    modal.classList.remove('block');
                }
            });
        });
    </script>
</body>

</html>