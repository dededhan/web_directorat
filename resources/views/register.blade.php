<!DOCTYPE html>
<html lang="en">
<!-- REGISTER.BLADE.PHP HEAD SECTION -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNJ Dashboard - Register</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    <!-- Removed Google Fonts import for Poppins -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('register.css') }}">
    <style>
        * {
            font-family: Arial, sans-serif !important;
        }
    </style>
</head>

<!-- FOOTERLP.BLADE.PHP - ADD STYLE TO FOOTER SECTION -->
<style>
    * {
        font-family: Arial, sans-serif !important;
    }
</style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-5xl mx-auto p-5">
        <div class="main-container bg-white rounded-2xl overflow-hidden shadow-2xl">
            <div class="container">
                <div class="left-panel form-container">
                    <img src="https://spm.unj.ac.id/wp-content/uploads/2024/08/Logo-UNJ-PTNBH-RGB_Logo_Motto_Transparan.png" alt="UNJ Logo" class="h-16 mb-5 logo"/>
                    <h1 class="text-2xl font-semibold text-teal-800 form-title">Create Account</h1>
                    <p class="text-gray-600 text-sm mb-8">Join our premium membership to unlock exclusive features and content.</p>
                    <form id="registerForm">
                        <div class="input-group">
                            <input type="text" name="name" placeholder="Full Name" required
                                class="input-field"/>
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="input-group">
                            <input type="email" name="email" placeholder="Email Address" required
                                class="input-field"/>
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="input-group">
                            <input type="password" name="password" placeholder="Create Password" required
                                class="input-field"/>
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" placeholder="Confirm Password" required
                                class="input-field"/>
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="flex justify-center my-6 captcha-container">
                            <img src="/api/placeholder/300/80" alt="reCAPTCHA verification"/>
                        </div>
                        <div class="relative">
                            <button type="submit" class="btn-primary w-full py-4 rounded-xl text-white font-medium tracking-wide mt-3 text-center">
                                CREATE ACCOUNT
                            </button>
                            <div class="loading-indicator">
                                <div class="dot-pulse"></div>
                            </div>
                        </div>
                    </form>
                    <p class="text-center block mt-8 text-gray-600 text-sm">
                        Already have an account? 
                        <a href="#" class="text-teal-700 font-medium hover:text-teal-900 hover:underline transition-all duration-300">Sign In</a>
                    </p>
                </div>
                <div class="right-panel">
                    <div class="circles">
                        <div class="circle"></div>
                        <div class="circle"></div>
                        <div class="circle"></div>
                    </div>
                    <div class="welcome-text">
                        <h2 class="text-3xl font-bold mb-8 relative">Premium Access
                            <span class="absolute left-0 bottom-0 w-12 h-1 bg-yellow-400" style="bottom: -10px;"></span>
                        </h2>
                        <p class="text-teal-100 uppercase tracking-wider text-sm font-medium">Paid User Registration</p>
                        <p class="text-2xl font-medium mt-6">Welcome!</p>
                        <p class="opacity-90 mt-2 leading-relaxed">Create your account to access exclusive content and premium features designed to elevate your experience.</p>
                        
                        <div class="mt-10 space-y-4">
                            <div class="flex items-center">
                                <div class="bg-teal-700 bg-opacity-30 p-2 rounded-full mr-3">
                                    <i class="fas fa-check text-teal-200"></i>
                                </div>
                                <span>Premium content access</span>
                            </div>
                            <div class="flex items-center">
                                <div class="bg-teal-700 bg-opacity-30 p-2 rounded-full mr-3">
                                    <i class="fas fa-check text-teal-200"></i>
                                </div>
                                <span>Priority customer support</span>
                            </div>
                            <div class="flex items-center">
                                <div class="bg-teal-700 bg-opacity-30 p-2 rounded-full mr-3">
                                    <i class="fas fa-check text-teal-200"></i>
                                </div>
                                <span>Exclusive member benefits</span>
                            </div>
                        </div>
                    </div>
                    <div class="decoration-icons">
                        <i class="fas fa-award"></i>
                        <i class="fas fa-crown"></i>
                        <i class="fas fa-gem"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('register.js') }}"></script>
</body>
</html>