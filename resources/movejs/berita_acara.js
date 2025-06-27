class SignaturePad {
    constructor(container, id) {
        this.container = container;
        this.id = id;
        this.canvas = document.createElement('canvas');
        this.ctx = this.canvas.getContext('2d');

        // Set canvas size based on container
        this.resizeCanvas();

        // Drawing settings
        this.ctx.lineWidth = 2;
        this.ctx.lineCap = 'round';
        this.ctx.lineJoin = 'round';
        this.ctx.strokeStyle = '#000000';

        this.isDrawing = false;
        this.points = [];

        // Add canvas to container
        this.container.innerHTML = '';
        this.container.appendChild(this.canvas);

        // Setup placeholder
        this.placeholder = document.createElement('div');
        this.placeholder.className = 'signature-placeholder';
        this.placeholder.textContent = 'Klik atau sentuh untuk menandatangani';
        this.container.appendChild(this.placeholder);

        // Find buttons within the closest parent group
        const signatureGroup = this.container.closest('[data-signature-role]') ||
            this.container.closest('[data-signature-id]');

        if (signatureGroup) {
            this.clearBtn = signatureGroup.querySelector('.signature-btn.hapus');
            this.uploadBtn = signatureGroup.querySelector('.signature-btn:not(.hapus)');

            // Create unique file input for this signature area
            this.fileInput = document.createElement('input');
            this.fileInput.type = 'file';
            this.fileInput.accept = 'image/*';
            this.fileInput.className = 'file-input';
            this.fileInput.setAttribute('data-for', this.id);
            signatureGroup.appendChild(this.fileInput);

            this.setupEventListeners();
        }
    }

    resizeCanvas() {
        const rect = this.container.getBoundingClientRect();
        this.canvas.width = rect.width - 40;
        this.canvas.height = rect.height - 40;
        this.canvas.style.backgroundColor = '#ffffff';
        this.ctx.lineWidth = 2;
        this.ctx.lineCap = 'round';
    }

    setupEventListeners() {
        // Mouse events
        this.canvas.addEventListener('mousedown', (e) => {
            e.preventDefault();
            this.startDrawing(e);
        });

        this.canvas.addEventListener('mousemove', (e) => {
            e.preventDefault();
            this.draw(e);
        });

        this.canvas.addEventListener('mouseup', (e) => {
            e.preventDefault();
            this.stopDrawing();
        });

        this.canvas.addEventListener('mouseout', (e) => {
            e.preventDefault();
            this.stopDrawing();
        });

        // Touch events
        this.canvas.addEventListener('touchstart', (e) => {
            e.preventDefault();
            const touch = e.touches[0];
            const rect = this.canvas.getBoundingClientRect();
            this.startDrawing({
                clientX: touch.clientX,
                clientY: touch.clientY,
                target: this.canvas
            });
        });

        this.canvas.addEventListener('touchmove', (e) => {
            e.preventDefault();
            const touch = e.touches[0];
            this.draw({
                clientX: touch.clientX,
                clientY: touch.clientY,
                target: this.canvas
            });
        });

        this.canvas.addEventListener('touchend', (e) => {
            e.preventDefault();
            this.stopDrawing();
        });

        // Button events with proper scoping
        if (this.clearBtn) {
            this.clearBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.clear();
                this.placeholder.style.display = 'block';
            });
        }

        if (this.uploadBtn && this.fileInput) {
            this.uploadBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.fileInput.click();
            });

            this.fileInput.addEventListener('change', (e) => {
                this.handleImageUpload(e);
            });
        }

        // Handle window resize
        window.addEventListener('resize', () => {
            this.resizeCanvas();
        });
    }

    startDrawing(e) {
        const rect = this.canvas.getBoundingClientRect();
        this.isDrawing = true;
        this.points = [{
            x: e.clientX - rect.left,
            y: e.clientY - rect.top
        }];
        this.placeholder.style.display = 'none';
    }

    draw(e) {
        if (!this.isDrawing) return;

        const rect = this.canvas.getBoundingClientRect();
        const point = {
            x: e.clientX - rect.left,
            y: e.clientY - rect.top
        };

        this.points.push(point);

        if (this.points.length > 2) {
            const xc = (this.points[this.points.length - 2].x + point.x) / 2;
            const yc = (this.points[this.points.length - 2].y + point.y) / 2;

            this.ctx.beginPath();
            this.ctx.moveTo(this.points[this.points.length - 3].x, this.points[this.points.length - 3].y);
            this.ctx.quadraticCurveTo(this.points[this.points.length - 2].x, this.points[this.points.length - 2]
                .y, xc, yc);
            this.ctx.stroke();
        }
    }

    stopDrawing() {
        this.isDrawing = false;
    }

    clear() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        this.points = [];
    }

    handleImageUpload(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = (event) => {
            const img = new Image();
            img.onload = () => {
                this.clear();

                // Calculate aspect ratio to fit image within canvas
                const ratio = Math.min(
                    this.canvas.width / img.width,
                    this.canvas.height / img.height
                );

                const newWidth = img.width * ratio;
                const newHeight = img.height * ratio;

                // Center the image
                const x = (this.canvas.width - newWidth) / 2;
                const y = (this.canvas.height - newHeight) / 2;

                this.ctx.drawImage(img, x, y, newWidth, newHeight);
                this.placeholder.style.display = 'none';
            };
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);

        // Reset file input
        this.fileInput.value = '';
    }
}

// Initialize all signature pads when document loads
document.addEventListener('DOMContentLoaded', () => {
    // Initialize signature areas with unique IDs
    const initializeSignatures = () => {
        document.querySelectorAll('.signature-area').forEach((area, index) => {
            const signatureGroup = area.closest('[data-signature-role]') ||
                area.closest('[data-signature-id]');
            const id = signatureGroup ?
                (signatureGroup.dataset.signatureRole || signatureGroup.dataset.signatureId) :
                `signature-${index}`;
            new SignaturePad(area, id);
        });
    };

    initializeSignatures();

    // Handle form submission
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.addEventListener('click', async (e) => {
        e.preventDefault();

        // Disable button and show loading state
        submitBtn.disabled = true;
        submitBtn.classList.add('loading');

        try {
            // Collect form data
            const formData = new FormData();

            // Get all inline inputs
            const inlineInputs = document.querySelectorAll('.input-inline');
            inlineInputs.forEach((input, index) => {
                formData.append(`inline_input_${index}`, input.value);
            });

            // Get innovation details
            const innovationTitle = document.querySelector(
                '.form-row input[class="input-field"]').value;
            const innovationType = document.querySelectorAll(
                '.form-row input[class="input-field"]')[1].value;
            const tkiValue = document.querySelectorAll('.form-row input[class="input-field"]')[
                2].value;
            const opinion = document.querySelector('.form-row textarea').value;

            formData.append('innovation_title', innovationTitle);
            formData.append('innovation_type', innovationType);
            formData.append('tki_value', tkiValue);
            formData.append('opinion', opinion);

            // Get signatures
            const signatureAreas = document.querySelectorAll('.signature-area');
            signatureAreas.forEach((area, index) => {
                const canvas = area.querySelector('canvas');
                if (canvas) {
                    const signatureData = canvas.toDataURL('image/png');
                    formData.append(`signature_${index}`, signatureData);
                }
            });

            // Get names
            const names = document.querySelectorAll('input[placeholder="Nama Lengkap"]');
            names.forEach((input, index) => {
                formData.append(`name_${index}`, input.value);
            });

            // Validate required fields
            const required = [
                innovationTitle,
                innovationType,
                tkiValue,
                opinion
            ];

            if (required.some(field => !field)) {
                throw new Error('Harap isi semua field yang diperlukan');
            }

            // Here you would normally send the formData to your server
            // For demonstration, we'll simulate an API call
            await new Promise(resolve => setTimeout(resolve, 1500));

            // Show success message
            alert('Form berhasil disubmit!');

            // Optional: Reset form
            // document.querySelector('form').reset();

        } catch (error) {
            // Show error message
            alert(error.message || 'Terjadi kesalahan saat submit form');
        } finally {
            // Re-enable button and remove loading state
            submitBtn.disabled = false;
            submitBtn.classList.remove('loading');
        }
    });
});