document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const loadingIndicator = document.querySelector('.loading-indicator');
    
    // Add focus effects for input fields
    const inputFields = document.querySelectorAll('.input-field');
    inputFields.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading indicator
        loadingIndicator.style.display = 'block';
        
        // Form validation
        const password = form.querySelector('input[name="password"]').value;
        const confirmPassword = form.querySelector('input[name="password_confirmation"]').value;
        
        setTimeout(() => {
            loadingIndicator.style.display = 'none';
            
            if (password !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Mismatch',
                    text: 'Your password and confirmation password do not match.',
                    confirmButtonColor: '#006666'
                });
                return;
            }
            
            // Show success message (since there's no backend)
            Swal.fire({
                icon: 'success',
                title: 'Registration Successful!',
                text: 'Your account has been created successfully.',
                confirmButtonColor: '#006666'
            });
            
            // Reset form
            form.reset();
        }, 1500);
    });
});