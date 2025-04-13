<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form B - Judul Inovasi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/inovasi/formjudul.css">
</head>
<body>

    @extends('admin.admin')
    <div class="container">
        <div class="header">
            <h1>Form Pengajuan Inovasi</h1>
            <p>Formulir untuk pendaftaran dan dokumentasi inovasi baru</p>
        </div>

        <div class="form-content">
            <div class="progress-bar">
                <div class="progress" id="progress-bar" style="width: 0%"></div>
            </div>

            <div class="section-tabs">
                <div class="section-tab active" data-target="info-inovasi">Informasi Inovasi</div>
                <div class="section-tab" data-target="produk-teknologi">Produk & Teknologi</div>
                <div class="section-tab" data-target="kesiapan-pasar">Kesiapan Pasar</div>
                <div class="section-tab" data-target="kontak-person">Kontak Person</div>
            </div>

            <form id="innovation-form" action="{{route('admin.Katsinov.inovasi.store', $id)}}" method="POST">
                @dump($inovasi)
                @csrf
                <!-- Informasi Inovasi -->
                <div class="form-section" id="info-inovasi">
                    <h2><i class="fas fa-lightbulb"></i> Informasi Inovasi</h2>
                    
                    <div class="form-group">
                        <label for="judul">Judul Inovasi</label>
                        <input type="text" id="judul" name="judul" placeholder="Contoh: Sistem Pengelolaan Limbah Cerdas" value="{{ !is_null($inovasi)? $inovasi->title : '' }}">
                        <span class="form-hint">Gunakan tiga atau empat kata yang menggambarkan inovasi</span>
                        <div class="char-counter" id="judul-counter">0/50 karakter</div>
                    </div>

                    <div class="form-group">
                        <label for="sub-judul">Sub Judul Inovasi 
                            <div class="tooltip">
                                <i class="fas fa-info-circle"></i>
                                <span class="tooltip-text">Jelaskan fitur unik atau lisensi yang membedakan inovasi Anda</span>
                            </div>
                        </label>
                        <input type="text" id="sub-judul" name="sub_judul" placeholder="Masukkan sub judul inovasi atau unique selling point" value="{{ !is_null($inovasi)? $inovasi->sub_title : '' }}">
                        <div class="char-counter" id="subjudul-counter">0/100 karakter</div>
                    </div>

                    <div class="form-group">
                        <label for="pendahuluan">Pendahuluan</label>
                        <textarea id="pendahuluan" name="pendahuluan" placeholder="Contoh: Inovasi ini bertujuan untuk mengelola limbah dengan lebih efisien...">{{ !is_null($inovasi)? $inovasi->introduction : '' }}</textarea>
                        <span class="form-hint">Jelaskan secara singkat maksimal 3 baris</span>
                        <div class="char-counter" id="pendahuluan-counter">0/300 karakter</div>
                    </div>
                </div>

                <!-- Produk Teknologi -->
                <div class="form-section" id="produk-teknologi" style="display: none;">
                    <h2><i class="fas fa-microchip"></i> Produk & Teknologi</h2>
                    
                    <div class="form-group">
                        <label for="produk-teknologi-desc">Deskripsi Produk Teknologi</label>
                        <textarea id="produk-teknologi-desc" name="produk_teknologi" placeholder="Jelaskan tentang produk teknologi, kegunaan, dan manfaat bisnisnya">{{ !is_null($inovasi)? $inovasi->tech_product : '' }}</textarea>
                        <span class="form-hint">Jelaskan secara rinci tentang teknologi yang digunakan dan nilai bisnisnya</span>
                    </div>

                    <div class="form-group">
                        <label for="keunggulan">Keunggulan Kompetitif (Unique Selling Point)</label>
                        <textarea id="keunggulan" name="keunggulan" placeholder="Jelaskan keunggulan produk dibandingkan dengan produk lain di pasar">{{ !is_null($inovasi)? $inovasi->supremacy : '' }}</textarea>
                        <span class="form-hint">Identifikasi minimal 3 keunggulan yang membedakan dengan kompetitor</span>
                    </div>

                    <div class="form-group">
                        <label for="paten">Deskripsi Perlindungan Paten</label>
                        <textarea id="paten" name="paten" placeholder="Jelaskan apa yang dilindungi oleh paten (metode, komposisi, dll)">{{ !is_null($inovasi)? $inovasi->patent : '' }}</textarea>
                        <span class="form-hint">Jelaskan aspek-aspek unik yang dilindungi atau akan dilindungi paten</span>
                    </div>
                </div>

                <!-- Kesiapan Pasar -->
                <div class="form-section" id="kesiapan-pasar" style="display: none;">
                    <h2><i class="fas fa-chart-line"></i> Kesiapan Teknologi & Pasar</h2>
                    
                    <div class="form-group">
                        <label for="kesiapan-teknologi">Kesiapan Teknologi (Technology Readiness)
                            <div class="tooltip">
                                <i class="fas fa-info-circle"></i>
                                <span class="tooltip-text">TRL 1-9, dari konsep dasar hingga sistem teruji di lingkungan sebenarnya</span>
                            </div>
                        </label>
                        <textarea id="kesiapan-teknologi" name="kesiapan_teknologi" placeholder="Jelaskan kesiapan teknologi (proof of concept, prototipe, validasi, dll)">{{ !is_null($inovasi)? $inovasi->tech_preparation : '' }}</textarea>
                        <span class="form-hint">Indikasikan tingkat kesiapan teknologi (TRL) dan bukti yang mendukung</span>
                    </div>

                    <div class="form-group">
                        <label for="kesiapan-pasar">Kesiapan Pasar (Market Readiness)</label>
                        <textarea id="kesiapan-pasar-desc" name="kesiapan_pasar" placeholder="Jelaskan kesiapan pasar (target pengguna, mitra komersial, investasi, dll)">{{ !is_null($inovasi)? $inovasi->market_preparation : '' }}</textarea>
                        <span class="form-hint">Deskripsikan target pasar, feedback pengguna, dan peluang komersialisasi</span>
                    </div>
                </div>

                <!-- Kontak Person -->
                <div class="form-section" id="kontak-person" style="display: none;">
                    <h2><i class="fas fa-user-circle"></i> Kontak Person</h2>
                    
                    <div class="contact-grid">
                        <div class="form-group">
                            <label for="nama">Nama Penanggungjawab Invensi</label>
                            <div class="input-icon">
                                <i class="fas fa-user"></i>
                                <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" value="{{ !is_null($inovasi)? $inovasi->name : '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone">Nomor Telepon Kantor</label>
                            <div class="input-icon">
                                <i class="fas fa-phone"></i>
                                <input type="text" id="phone" name="phone" placeholder="Contoh: 021-7654321" value="{{ !is_null($inovasi)? $inovasi->phone : '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mobile">Nomor Handphone</label>
                            <div class="input-icon">
                                <i class="fas fa-mobile-alt"></i>
                                <input type="text" id="mobile" name="mobile" placeholder="Contoh: 08123456789" value="{{ !is_null($inovasi)? $inovasi->mobile : '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fax">Nomor Fax</label>
                            <div class="input-icon">
                                <i class="fas fa-fax"></i>
                                <input type="text" id="fax" name="fax" placeholder="Contoh: 021-7654321" value="{{ !is_null($inovasi)? $inovasi->fax : '' }}">
                            </div>
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label for="email">Alamat Email</label>
                            <div class="input-icon">
                                <i class="fas fa-envelope"></i>
                                <input type="email" id="email" name="email" placeholder="Contoh: nama@institusi.ac.id" value="{{ !is_null($inovasi)? $inovasi->email : '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                @if (is_null($inovasi))    
                <div class="submit-button">
                    <button type="submit" class="btn" id="submit-btn"><i class="fas fa-paper-plane"></i> Kirim Formulir</button>
                </div>
                @endif
            </form>

            <!-- Pesan Sukses -->
            {{-- <div id="success-message" class="alert alert-success" style="display: none;">
                <i class="fas fa-check-circle"></i>
                <div>
                    <strong>Berhasil!</strong> Form pengajuan inovasi Anda telah dikirim. Tim kami akan menghubungi Anda dalam 2-3 hari kerja.
                </div>
            </div>
        </div> --}}

        <div class="footer">
            &copy; 2025 Pusat Inovasi dan Teknologi. Semua hak dilindungi.
        </div>
    </div>

    <script>
        // Tab Navigation
        document.querySelectorAll('.section-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                // Hide all sections
                document.querySelectorAll('.form-section').forEach(section => {
                    section.style.display = 'none';
                });
                
                // Deactivate all tabs
                document.querySelectorAll('.section-tab').forEach(t => {
                    t.classList.remove('active');
                });
                
                // Show target section and activate tab
                const targetId = tab.getAttribute('data-target');
                document.getElementById(targetId).style.display = 'block';
                tab.classList.add('active');
                
                // Update progress
                updateProgress();
            });
        });
        
        // the rest of your js is preventing the form to be submitted 
        // sorry for the wall of omments below
        // // Character counters
        // function setupCharCounter(inputId, counterId, maxChars) {
        //     const input = document.getElementById(inputId);
        //     const counter = document.getElementById(counterId);
            
        //     input.addEventListener('input', () => {
        //         const charCount = input.value.length;
        //         counter.textContent = `${charCount}/${maxChars} karakter`;
                
        //         if (charCount > maxChars) {
        //             counter.style.color = '#e53e3e';
        //         } else {
        //             counter.style.color = 'var(--text-light)';
        //         }
                
        //         updateProgress();
        //     });
        // }
        
        // setupCharCounter('judul', 'judul-counter', 50);
        // setupCharCounter('sub-judul', 'subjudul-counter', 100);
        // setupCharCounter('pendahuluan', 'pendahuluan-counter', 300);
        
        // // Form submission
        // document.getElementById('innovation-form').addEventListener('submit', function(event) {
        //     event.preventDefault();
            
        //     // Basic validation
        //     let judul = document.getElementById('judul').value;
        //     let pendahuluan = document.getElementById('pendahuluan').value;
            
        //     if (judul === '' || pendahuluan === '') {
        //         alert('Harap isi semua field yang diperlukan.');
        //         return;
        //     }
            
        //     // Simulate form submission
        //     const submitButton = document.getElementById('submit-btn');
        //     submitButton.disabled = true;
        //     submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            
        //     setTimeout(function() {
        //         submitButton.style.display = 'none';
        //         document.getElementById('success-message').style.display = 'flex';
        //         document.getElementById('success-message').classList.add('animate-pulse');
                
        //         // Hide pulse animation after 3 seconds
        //         setTimeout(() => {
        //             document.getElementById('success-message').classList.remove('animate-pulse');
        //         }, 3000);
        //     }, 1500);
        // });
        
        // // Update progress bar
        // function updateProgress() {
        //     const form = document.getElementById('innovation-form');
        //     const inputs = form.querySelectorAll('input, textarea');
        //     let filledInputs = 0;
            
        //     inputs.forEach(input => {
        //         if (input.value.trim() !== '') {
        //             filledInputs++;
        //         }
        //     });
            
        //     const progressPercentage = Math.min(100, Math.round((filledInputs / inputs.length) * 100));
        //     document.getElementById('progress-bar').style.width = progressPercentage + '%';
        // }
        
        // // Initialize
        // document.getElementById('info-inovasi').style.display = 'block';
        // updateProgress();
    </script>
</body>
</html>