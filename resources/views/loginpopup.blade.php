<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNJ Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('style-login-popup.css') }}">

</head>
<body>
  

    <!-- Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content d-flex flex-row">
                <div class="left-panel">
                    <img src="https://spm.unj.ac.id/wp-content/uploads/2024/08/cropped-Logo-UNJ-PTNBH-RGB_Logo_Motto_Transparan.png" alt="UNJ Logo"/>
                    <h1>Sign In</h1>
                    <p>Welcome to the Admin Portal. Please login with your credentials to access the system.</p>
                    <input type="text" placeholder="Username"/>
                    <input type="password" placeholder="Password"/>
                    <div class="recaptcha">
                        <img src="https://placehold.co/300x80" alt="reCAPTCHA verification"/>
                    </div>
                    <button>SIGN IN</button>
                    <a href="#">Forgot Your Password?</a>
                </div>
                <div class="right-panel">
                    <h2>UNJ Dashboard</h2>
                    <p>Admin Panel Login</p>
                    <p>Hello, Admin!</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
