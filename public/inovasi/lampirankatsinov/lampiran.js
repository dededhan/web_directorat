document.addEventListener('DOMContentLoaded', function() {
    // References to DOM elements
    const fileInputs = document.querySelectorAll('input[type="file"]');
    const uploadAllBtn = document.getElementById('uploadAllBtn');
    const alertContainer = document.getElementById('alertContainer');

    // File upload handler
    function handleFileUpload(input) {
        const file = input.files[0];
        if (!file) return;

        // Get progress bar related to this input
        const progressContainer = input.nextElementSibling;
        const progressBar = progressContainer.querySelector('.progress-bar');
        
        // Show progress container
        progressContainer.style.display = 'block';
        
        // Simulate upload with progress updates
        let progress = 0;
        const interval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress >= 100) {
                progress = 100;
                clearInterval(interval);
                
                // After "upload" completes
                setTimeout(() => {
                    // Hide progress
                    progressContainer.style.display = 'none';
                    
                    // Reset progress bar for future uploads
                    progressBar.style.width = '0%';
                    
                    // Show success message
                    showAlert('success', `File "${file.name}" berhasil diupload.`);
                }, 500);
            }
            
            // Update progress bar
            progressBar.style.width = `${progress}%`;
        }, 300);
    }

    // Add event listeners to all file inputs
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            handleFileUpload(this);
        });
    });

    // Upload all button handler
    uploadAllBtn.addEventListener('click', function() {
        const filledInputs = Array.from(fileInputs).filter(input => input.files.length > 0);
        
        if (filledInputs.length === 0) {
            showAlert('warning', 'Silakan pilih setidaknya satu file untuk diupload.');
            return;
        }
        
        // Display loading state on button
        this.disabled = true;
        this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengupload...';
        
        // Simulate batch upload process
        setTimeout(() => {
            // Reset button state
            this.disabled = false;
            this.innerHTML = '<i class="bi bi-cloud-arrow-up"></i> Upload Semua';
            
            // Show success message
            showAlert('success', `${filledInputs.length} file berhasil diupload.`);
            
            // Reset all inputs
            fileInputs.forEach(input => {
                input.value = '';
                const progressContainer = input.nextElementSibling;
                if (progressContainer) {
                    progressContainer.style.display = 'none';
                    const progressBar = progressContainer.querySelector('.progress-bar');
                    if (progressBar) {
                        progressBar.style.width = '0%';
                    }
                }
            });
        }, 2000);
    });

    // Show alert message
    function showAlert(type, message) {
        const alertEl = document.createElement('div');
        alertEl.className = `alert alert-${type} alert-dismissible fade show`;
        alertEl.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        // Add to container
        alertContainer.appendChild(alertEl);
        
        // Auto dismiss after 5 seconds
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alertEl);
            bsAlert.close();
        }, 5000);
    }

    // Automatically dismiss alerts when they're closed
    document.addEventListener('closed.bs.alert', function(e) {
        e.target.remove();
    });

    // Add validation to all file inputs
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            handleFileUpload(this);
        });
    });

    // Add tooltip initialization
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});