@extends('subdirektorat-inovasi.validator.index')



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --accent-color: #4895ef;
        --success-color: #4cc9f0;
        --light-color: #f8f9fa;
        --dark-color: #212529;
        --gray-color: #6c757d;
        --light-gray: #e9ecef;
        --border-radius: 8px;
        --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    .form-content {
        background-color: #fff;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .progress-container {
        margin-bottom: 1.5rem;
    }

    .progress-bar {
        height: 8px;
        background-color: var(--light-gray);
        border-radius: 4px;
        overflow: hidden;
        margin-bottom: 0.5rem;
    }

    .progress {
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        height: 100%;
        transition: width 0.5s ease;
        border-radius: 4px;
    }

    .progress-text {
        display: flex;
        justify-content: space-between;
        font-size: 0.875rem;
        color: var(--gray-color);
    }

    .section-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 2rem;
    }

    .section-tab {
        padding: 0.75rem 1.5rem;
        background-color: var(--light-gray);
        border-radius: var(--border-radius);
        color: var(--gray-color);
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        flex: 1;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .section-tab i {
        font-size: 1rem;
    }

    .section-tab.active {
        background-color: var(--primary-color);
        color: white;
    }

    .section-tab:hover:not(.active) {
        background-color: #dee2e6;
    }

    .form-section {
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-section h2 {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.5rem;
        color: var(--dark-color);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--light-gray);
    }

    .form-section h2 i {
        color: var(--primary-color);
    }

    .form-control {
        border-radius: var(--border-radius);
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
        transition: var(--transition);
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
    }

    .form-text {
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label i {
        color: var(--primary-color);
        font-size: 0.875rem;
    }

    .tooltip-icon {
        color: var(--gray-color);
        cursor: help;
        position: relative;
    }

    .tooltip-icon:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        background-color: var(--dark-color);
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 4px;
        font-size: 0.75rem;
        z-index: 10;
        width: max-content;
        max-width: 200px;
        white-space: normal;
        margin-top: 0.5rem;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        border-radius: var(--border-radius);
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: var(--transition);
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
    }

    .btn-outline-secondary {
        color: var(--gray-color);
        border-color: var(--gray-color);
        border-radius: var(--border-radius);
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: var(--transition);
    }

    .btn-outline-secondary:hover {
        background-color: var(--light-gray);
        color: var(--dark-color);
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
    }

    .char-counter {
        text-align: right;
        font-size: 0.75rem;
        color: var(--gray-color);
        margin-top: 0.25rem;
    }

    .input-icon-wrapper {
        position: relative;
    }

    .input-icon-wrapper i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-color);
    }

    .input-icon-wrapper input {
        padding-left: 2.5rem;
    }

    @media (max-width: 768px) {
        .section-tabs {
            flex-direction: column;
        }
        
        .form-actions {
            flex-direction: column;
            gap: 1rem;
        }
        
        .form-actions button {
            width: 100%;
        }
    }
    
    .form-completion {
        text-align: right;
        font-size: 0.875rem;
        color: var(--gray-color);
        margin-bottom: 0.5rem;
    }
</style>

@section('contentvalidator')
    <div class="head-title">
        <div class="left">
            <h1>Form Pengajuan Inovasi</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Form Inovasi</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">

            <div class="form-content">
                <div class="progress-container">
                    <div class="form-completion">
                        <span id="completion-text">0% Lengkap</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress" id="progress-bar" style="width: 0%"></div>
                    </div>
                    <div class="progress-text">
                        <span>Mulai</span>
                        <span>Selesai</span>
                    </div>
                </div>

                <div class="section-tabs">
                    <div class="section-tab active" data-target="info-inovasi">
                        <i class="fas fa-lightbulb"></i>
                        <span>Informasi Inovasi</span>
                    </div>
                    <div class="section-tab" data-target="produk-teknologi">
                        <i class="fas fa-microchip"></i>
                        <span>Produk & Teknologi</span>
                    </div>
                    <div class="section-tab" data-target="kesiapan-pasar">
                        <i class="fas fa-chart-line"></i>
                        <span>Kesiapan Pasar</span>
                    </div>
                    <div class="section-tab" data-target="kontak-person">
                        <i class="fas fa-user-circle"></i>
                        <span>Kontak Person</span>
                    </div>
                </div>

                <form id="innovation-form" action="{{route('subdirektorat-inovasi.validator.inovasi.store', $id)}}" method="POST">
                    @csrf
                    <!-- Informasi Inovasi -->
                    <div class="form-section" id="info-inovasi">
                        <h2><i class="fas fa-lightbulb"></i> Informasi Inovasi</h2>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="judul" class="form-label">
                                    Judul Inovasi
                                    <i class="fas fa-info-circle tooltip-icon" data-tooltip="Gunakan tiga atau empat kata yang menggambarkan inovasi dengan jelas"></i>
                                </label>
                                <input type="text" class="form-control" id="judul" name="judul" 
                                       placeholder="Contoh: Sistem Pengelolaan Limbah Cerdas" 
                                       value="{{ !is_null($inovasi)? $inovasi->title : '' }}"
                                       maxlength="50">
                                <div class="char-counter" id="judul-counter">0/50 karakter</div>
                                <div class="form-text text-muted">Gunakan tiga atau empat kata yang menggambarkan inovasi</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="sub-judul" class="form-label">
                                    Sub Judul Inovasi
                                    <i class="fas fa-info-circle tooltip-icon" data-tooltip="Jelaskan fitur unik atau lisensi yang membedakan inovasi Anda"></i>
                                </label>
                                <input type="text" class="form-control" id="sub-judul" name="sub_judul" 
                                       placeholder="Masukkan sub judul inovasi atau unique selling point" 
                                       value="{{ !is_null($inovasi)? $inovasi->sub_title : '' }}"
                                       maxlength="100">
                                <div class="char-counter" id="subjudul-counter">0/100 karakter</div>
                                <div class="form-text text-muted">Jelaskan fitur unik atau lisensi yang membedakan inovasi Anda</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="pendahuluan" class="form-label">
                                    Pendahuluan
                                    <i class="fas fa-info-circle tooltip-icon" data-tooltip="Jelaskan secara singkat maksimal 3 baris tentang tujuan, masalah yang diselesaikan, dan manfaat inovasi"></i>
                                </label>
                                <textarea class="form-control" id="pendahuluan" name="pendahuluan" 
                                         placeholder="Contoh: Inovasi ini bertujuan untuk mengelola limbah dengan lebih efisien..."
                                         rows="4" maxlength="300">{{ !is_null($inovasi)? $inovasi->introduction : '' }}</textarea>
                                <div class="char-counter" id="pendahuluan-counter">0/300 karakter</div>
                                <div class="form-text text-muted">Jelaskan secara singkat maksimal 3 baris</div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <div></div> <!-- Empty div for spacing -->
                            <button type="button" class="btn btn-primary next-section" data-target="produk-teknologi">
                                Selanjutnya <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Produk Teknologi -->
                    <div class="form-section" id="produk-teknologi" style="display: none;">
                        <h2><i class="fas fa-microchip"></i> Produk & Teknologi</h2>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="produk-teknologi-desc" class="form-label">
                                    Deskripsi Produk Teknologi
                                    <i class="fas fa-info-circle tooltip-icon" data-tooltip="Jelaskan secara rinci tentang teknologi yang digunakan dan nilai bisnisnya"></i>
                                </label>
                                <textarea class="form-control" id="produk-teknologi-desc" name="produk_teknologi" 
                                          placeholder="Jelaskan tentang produk teknologi, kegunaan, dan manfaat bisnisnya" 
                                          rows="4">{{ !is_null($inovasi)? $inovasi->tech_product : '' }}</textarea>
                                <div class="form-text text-muted">Jelaskan secara rinci tentang teknologi yang digunakan dan nilai bisnisnya</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="keunggulan" class="form-label">
                                    Keunggulan Kompetitif (Unique Selling Point)
                                    <i class="fas fa-info-circle tooltip-icon" data-tooltip="Identifikasi minimal 3 keunggulan yang membedakan dengan kompetitor"></i>
                                </label>
                                <textarea class="form-control" id="keunggulan" name="keunggulan" 
                                          placeholder="Jelaskan keunggulan produk dibandingkan dengan produk lain di pasar" 
                                          rows="4">{{ !is_null($inovasi)? $inovasi->supremacy : '' }}</textarea>
                                <div class="form-text text-muted">Identifikasi minimal 3 keunggulan yang membedakan dengan kompetitor</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="paten" class="form-label">
                                    Deskripsi Perlindungan Paten
                                    <i class="fas fa-info-circle tooltip-icon" data-tooltip="Jelaskan aspek-aspek unik yang dilindungi atau akan dilindungi paten"></i>
                                </label>
                                <textarea class="form-control" id="paten" name="paten" 
                                          placeholder="Jelaskan apa yang dilindungi oleh paten (metode, komposisi, dll)" 
                                          rows="4">{{ !is_null($inovasi)? $inovasi->patent : '' }}</textarea>
                                <div class="form-text text-muted">Jelaskan aspek-aspek unik yang dilindungi atau akan dilindungi paten</div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn btn-outline-secondary prev-section" data-target="info-inovasi">
                                <i class="fas fa-arrow-left"></i> Sebelumnya
                            </button>
                            <button type="button" class="btn btn-primary next-section" data-target="kesiapan-pasar">
                                Selanjutnya <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Kesiapan Pasar -->
                    <div class="form-section" id="kesiapan-pasar" style="display: none;">
                        <h2><i class="fas fa-chart-line"></i> Kesiapan Teknologi & Pasar</h2>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="kesiapan-teknologi" class="form-label">
                                    Kesiapan Teknologi (Technology Readiness)
                                    <i class="fas fa-info-circle tooltip-icon" data-tooltip="TRL 1-9, dari konsep dasar hingga sistem teruji di lingkungan sebenarnya"></i>
                                </label>
                                <textarea class="form-control" id="kesiapan-teknologi" name="kesiapan_teknologi" 
                                          placeholder="Jelaskan kesiapan teknologi (proof of concept, prototipe, validasi, dll)" 
                                          rows="4">{{ !is_null($inovasi)? $inovasi->tech_preparation : '' }}</textarea>
                                <div class="form-text text-muted">Indikasikan tingkat kesiapan teknologi (TRL) dan bukti yang mendukung</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="kesiapan-pasar-desc" class="form-label">
                                    Kesiapan Pasar (Market Readiness)
                                    <i class="fas fa-info-circle tooltip-icon" data-tooltip="Deskripsikan target pasar, feedback pengguna, dan peluang komersialisasi"></i>
                                </label>
                                <textarea class="form-control" id="kesiapan-pasar-desc" name="kesiapan_pasar" 
                                          placeholder="Jelaskan kesiapan pasar (target pengguna, mitra komersial, investasi, dll)" 
                                          rows="4">{{ !is_null($inovasi)? $inovasi->market_preparation : '' }}</textarea>
                                <div class="form-text text-muted">Deskripsikan target pasar, feedback pengguna, dan peluang komersialisasi</div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn btn-outline-secondary prev-section" data-target="produk-teknologi">
                                <i class="fas fa-arrow-left"></i> Sebelumnya
                            </button>
                            <button type="button" class="btn btn-primary next-section" data-target="kontak-person">
                                Selanjutnya <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Kontak Person -->
                    <div class="form-section" id="kontak-person" style="display: none;">
                        <h2><i class="fas fa-user-circle"></i> Kontak Person</h2>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">Nama Penanggungjawab Invensi</label>
                                <div class="input-icon-wrapper">
                                    <i class="fas fa-user"></i>
                                    <input type="text" class="form-control" id="nama" name="nama" 
                                           placeholder="Masukkan nama lengkap" value="{{ !is_null($inovasi)? $inovasi->name : '' }}">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Nomor Telepon Kantor</label>
                                <div class="input-icon-wrapper">
                                    <i class="fas fa-phone"></i>
                                    <input type="text" class="form-control" id="phone" name="phone" 
                                           placeholder="Contoh: 021-7654321" value="{{ !is_null($inovasi)? $inovasi->phone : '' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="mobile" class="form-label">Nomor Handphone</label>
                                <div class="input-icon-wrapper">
                                    <i class="fas fa-mobile-alt"></i>
                                    <input type="text" class="form-control" id="mobile" name="mobile" 
                                           placeholder="Contoh: 08123456789" value="{{ !is_null($inovasi)? $inovasi->mobile : '' }}">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fax" class="form-label">Nomor Fax</label>
                                <div class="input-icon-wrapper">
                                    <i class="fas fa-fax"></i>
                                    <input type="text" class="form-control" id="fax" name="fax" 
                                           placeholder="Contoh: 021-7654321" value="{{ !is_null($inovasi)? $inovasi->fax : '' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <div class="input-icon-wrapper">
                                    <i class="fas fa-envelope"></i>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           placeholder="Contoh: nama@institusi.ac.id" value="{{ !is_null($inovasi)? $inovasi->email : '' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn btn-outline-secondary prev-section" data-target="kesiapan-pasar">
                                <i class="fas fa-arrow-left"></i> Sebelumnya
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ $inovasi ? 'Update' : 'Kirim' }} Formulir
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab Navigation
            document.querySelectorAll('.section-tab').forEach(tab => {
                tab.addEventListener('click', () => {
                    navigateToSection(tab.getAttribute('data-target'));
                });
            });
            
            // Next/Previous buttons
            document.querySelectorAll('.next-section, .prev-section').forEach(button => {
                button.addEventListener('click', () => {
                    navigateToSection(button.getAttribute('data-target'));
                });
            });
            
            function navigateToSection(targetId) {
                // Hide all sections
                document.querySelectorAll('.form-section').forEach(section => {
                    section.style.display = 'none';
                });
                
                // Deactivate all tabs
                document.querySelectorAll('.section-tab').forEach(t => {
                    t.classList.remove('active');
                });
                
                // Show target section and activate tab
                document.getElementById(targetId).style.display = 'block';
                document.querySelector(`.section-tab[data-target="${targetId}"]`).classList.add('active');
                
                // Update progress
                updateProgress();
            }
            
            // Character counters
            function setupCharCounter(inputId, counterId, maxChars) {
                const input = document.getElementById(inputId);
                const counter = document.getElementById(counterId);
                
                if (input && counter) {
                    // Initial count
                    counter.textContent = `${input.value.length}/${maxChars} karakter`;
                    
                    // Update on input
                    input.addEventListener('input', () => {
                        const charCount = input.value.length;
                        counter.textContent = `${charCount}/${maxChars} karakter`;
                        
                        if (charCount > maxChars) {
                            counter.style.color = '#e53e3e';
                        } else {
                            counter.style.color = '#6c757d';
                        }
                        
                        updateProgress();
                    });
                }
            }
            
            setupCharCounter('judul', 'judul-counter', 50);
            setupCharCounter('sub-judul', 'subjudul-counter', 100);
            setupCharCounter('pendahuluan', 'pendahuluan-counter', 300);
            
            // Update progress bar
            function updateProgress() {
                const form = document.getElementById('innovation-form');
                const inputs = form.querySelectorAll('input, textarea');
                let filledInputs = 0;
                let totalInputs = inputs.length;
                
                inputs.forEach(input => {
                    if (input.value.trim() !== '') {
                        filledInputs++;
                    }
                });
                
                const progressPercentage = Math.min(100, Math.round((filledInputs / totalInputs) * 100));
                document.getElementById('progress-bar').style.width = progressPercentage + '%';
                document.getElementById('completion-text').textContent = `${progressPercentage}% Lengkap`;
            }
            
            // Initialize
            document.getElementById('info-inovasi').style.display = 'block';
            updateProgress();
        });
    </script>
@endsection