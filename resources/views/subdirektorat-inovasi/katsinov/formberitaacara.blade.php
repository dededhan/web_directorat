<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara Pengukuran</title>
    <link rel="stylesheet" href="/inovasi/formberitaacara.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Berita Acara Pengukuran Tingkat Kesiapan Teknologi</h1>
        </header>

        <main class="main-content">
            <!-- Date and Location Section -->
            <section class="form-section">
                <p>
                    Pada hari ini, <input type="text" class="input-inline" name="hari">, 
                    tanggal <input type="text" class="input-inline" name="tanggal">
                    bulan <input type="text" class="input-inline" name="bulan">
                    tahun <input type="text" class="input-inline" name="tahun">
                    (<input type="text" class="input-inline" name="keterangan_tanggal">),
                </p>
                <p>
                    bertempat di <input type="text" class="input-inline" name="tempat">,
                    dari hasil pengukuran Tingkat Kesiapan Inovasi (KATSINOV) yang dilakukan oleh Tim yang dibentuk 
                    berdasarkan Surat Keputusan <input type="text" class="input-inline" name="surat_keputusan"> menyatakan:
                </p>
            </section>

            <!-- Innovation Details Section -->
            <section class="form-section">
                <div class="form-row">
                    <label class="label">Judul Inovasi</label>
                    <input type="text" class="input-field" name="judul_inovasi">
                </div>
                
                <div class="form-row">
                    <label class="label">Jenis Inovasi</label>
                    <input type="text" class="input-field" name="jenis_inovasi">
                </div>
                
                <div class="form-row">
                    <label class="label">Nilai TKI</label>
                    <input type="text" class="input-field" name="nilai_tki">
                </div>
                
                <div class="form-row">
                    <label class="label">Opini Penilai</label>
                    <textarea class="input-field" name="opini_penilai"></textarea>
                </div>
            </section>

            <!-- Closing Statement -->
            <section class="form-section">
                <p>
                    Demikian Berita Acara Pengukuran Tingkat Kesiapan Inovasi (KATSINOV) ini dibuat dengan sebenar-benarnya, 
                    kemudian ditutup dan ditandatangani di
                    pada <input type="date" class="input-inline date-picker" name="tanggal_penutupan" style="min-width: 180px;"> 
                    pada hari dan tanggal, bulan, tahun tersebut di atas.
                </p>
            </section>
            

            <!-- Signature Section -->
            <section class="signature-section">
                <div class="signature-box" data-signature-id="penanggung-jawab" >
                    <h3 class="signature-box-title">Penanggungjawab Inovasi</h3>
                    <div class="signature-area"></div>
                    <input type="text" class="input-field" placeholder="Nama Lengkap" name="nama_penanggungjawab">
                    <div class="signature-buttons">
                        <button class="signature-btn hapus">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus
                        </button>
                        <button class="signature-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Upload
                        </button>
                    </div>
                </div>

                <div class="signature-box" data-signature-id="tim-penilai">
                    <h3 class="signature-box-title">Tim Penilai</h3>
                    
                    <div data-signature-role="ketua">
                        <p class="signature-subtitle">Ketua Tim Penilai</p>
                        <div class="signature-area"></div>
                        <input type="text" class="input-field" placeholder="Nama Lengkap" name="nama_ketua_tim">
                        <div class="signature-buttons">
                            <button class="signature-btn hapus">Hapus</button>
                            <button class="signature-btn">Upload</button>
                        </div>
                    </div>

                    <div data-signature-role="anggota-1">
                        <p class="signature-subtitle">Anggota 1</p>
                        <div class="signature-area"></div>
                        <input type="text" class="input-field" placeholder="Nama Lengkap" name="nama_anggota1">
                        <div class="signature-buttons">
                            <button class="signature-btn hapus">Hapus</button>
                            <button class="signature-btn">Upload</button>
                        </div>
                    </div>

                    <div data-signature-role="anggota-2">
                        <p class="signature-subtitle">Anggota 2</p>
                        <div class="signature-area"></div>
                        <input type="text" class="input-field" placeholder="Nama Lengkap" name="nama_anggota2">
                        <div class="signature-buttons">
                            <button class="signature-btn hapus">Hapus</button>
                            <button class="signature-btn">Upload</button>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Submit Button Section -->
            <section class="form-section" style="text-align: center;">
                <button id="submitBtn" class="submit-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-right: 8px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Submit Form
                </button>
            </section>
        </main>
    </div>

    <style>
        .submit-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 1rem 2rem;
            background: #176369;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .submit-btn:hover {
            background: #145458;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            transform: none;
        }

        /* Loading spinner for submit button */
        .submit-btn.loading {
            position: relative;
            color: transparent;
        }

        .submit-btn.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border: 3px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>

    <script>
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
            this.ctx.quadraticCurveTo(this.points[this.points.length - 2].x, this.points[this.points.length - 2].y, xc, yc);
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
// Ganti bagian try dalam event listener submitBtn

        try {
            const formData = new FormData();

            // 1. Ambil data input inline dengan name attribute
            const inlineInputs = [
                'hari', 'tanggal', 'bulan', 'tahun', 
                'keterangan_tanggal', 'tempat', 'surat_keputusan'
            ];
            
            inlineInputs.forEach(name => {
                const input = document.querySelector(`[name="${name}"]`);
                if (input) formData.append(name, input.value);
            });

            // 2. Ambil data input field dengan name attribute
            const fieldInputs = [
                'judul_inovasi', 'jenis_inovasi', 'nilai_tki', 
                'opini_penilai', 'tanggal_penutupan'
            ];
            
            fieldInputs.forEach(name => {
                const input = document.querySelector(`[name="${name}"]`);
                if (input) formData.append(name, input.value);
            });

            // 3. Ambil tanda tangan dan nama dengan selector yang lebih spesifik
            const signatureMappings = [
                { 
                    canvas: '[data-signature-id="penanggung-jawab"] .signature-area canvas',
                    name: '[data-signature-id="penanggung-jawab"] input[placeholder="Nama Lengkap"]',
                    field: 'ttd_penanggungjawab',
                    nameField: 'nama_penanggungjawab'
                },
                {
                    canvas: '[data-signature-role="ketua"] .signature-area canvas',
                    name: '[data-signature-role="ketua"] input[placeholder="Nama Lengkap"]',
                    field: 'ttd_ketua_tim',
                    nameField: 'nama_ketua_tim'
                },
                {
                    canvas: '[data-signature-role="anggota-1"] .signature-area canvas',
                    name: '[data-signature-role="anggota-1"] input[placeholder="Nama Lengkap"]',
                    field: 'ttd_anggota1',
                    nameField: 'nama_anggota1'
                },
                {
                    canvas: '[data-signature-role="anggota-2"] .signature-area canvas',
                    name: '[data-signature-role="anggota-2"] input[placeholder="Nama Lengkap"]',
                    field: 'ttd_anggota2',
                    nameField: 'nama_anggota2'
                }
            ];

            signatureMappings.forEach(({canvas, name, field, nameField}) => {
                const canvasElement = document.querySelector(canvas);
                const nameInput = document.querySelector(name);
                
                if (canvasElement) {
                    formData.append(field, canvasElement.toDataURL());
                }
                if (nameInput) {
                    formData.append(nameField, nameInput.value);
                }
            });

            // 4. Tambahkan validasi client-side sederhana
            let isValid = true;
            document.querySelectorAll('[required]').forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('error');
                    alert(`Field ${input.name} harus diisi`);
                }
            });
            
            if (!isValid) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('loading');
                return;
            }

            // 5. Kirim request dengan error handling lebih baik
            const response = await fetch('/admin/Katsinov/formberitaacara', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || result.error || 'Terjadi kesalahan server');
            }

            alert('Data berhasil disimpan!');
            window.location.href = result.redirect || '/';

        } catch (error) {
            console.error('Error:', error);
            alert(error.message || 'Terjadi kesalahan saat mengirim formulir');
            
            // Re-enable button
            submitBtn.disabled = false;
            submitBtn.classList.remove('loading');
        }
    });
});
    </script>
</body>
</html>