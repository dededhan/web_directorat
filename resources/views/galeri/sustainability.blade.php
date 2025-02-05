
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUSTAINABILITY</title>
    <link rel="stylesheet" href="{{ asset('sustainability.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
       
</head>
<body>
<nav class="navbar">
        <a href="#" class="navbar-logo">
            <img src="https://spm.unj.ac.id/wp-content/uploads/2024/08/cropped-Logo-UNJ-PTNBH-RGB_Logo_Motto_Transparan.png" alt="Logo" />
            <span class="navbar-logo-text"> SUSTAINABILITY</span>
        </a>
        <ul class="navbar-menu">
            <li><a href="#">Home</a></li>
            <li><a href="#">Sustainability</a></li>
        </ul>
    </nav>

    <!-- Rest of the existing content remains the same -->
    <div class="container">
        <div class="activity-photos">
            <!-- [Previous Card 1 content remains the same] -->
            <div class="photo-card">
                <div class="card-image">
                    <img src="/api/placeholder/400/300" alt="Workshop UI/UX">
                </div>
                <div class="card-content">
                    <h3 class="card-title">Workshop UI/UX Design</h3>
                    <div class="card-info">
                        <div class="info-item">
                            <i class="fas fa-calendar"></i>
                            <span>15 Februari 2025</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Teknik Informatika</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-university"></i>
                            <span>Fakultas Teknik</span>
                        </div>
                    </div>
                    <button class="detail-link" onclick="openModal('modal1')">
                        <i class="fas fa-info-circle"></i>
                        Lihat Detail
                    </button>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="photo-card">
                <div class="card-image">
                    <img src="/api/placeholder/400/300" alt="Seminar Artificial Intelligence">
                </div>
                <div class="card-content">
                    <h3 class="card-title">Seminar Artificial Intelligence</h3>
                    <div class="card-info">
                        <div class="info-item">
                            <i class="fas fa-calendar"></i>
                            <span>20 Maret 2025</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Ilmu Komputer</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-university"></i>
                            <span>Fakultas MIPA</span>
                        </div>
                    </div>
                    <button class="detail-link" onclick="openModal('modal2')">
                        <i class="fas fa-info-circle"></i>
                        Lihat Detail
                    </button>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="photo-card">
                <div class="card-image">
                    <img src="/api/placeholder/800/400" alt="Workshop Data Science">
                </div>
                <div class="card-content">
                    <h3 class="card-title">Workshop Data Science</h3>
                    <div class="card-info">
                        <div class="info-item">
                            <i class="fas fa-calendar"></i>
                            <span>5 April 2025</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Matematika</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-university"></i>
                            <span>Fakultas MIPA</span>
                        </div>
                    </div>
                    <button class="detail-link" onclick="openModal('modal3')">
                        <i class="fas fa-info-circle"></i>
                        Lihat Detail
                    </button>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="photo-card">
                <div class="card-image">
                    <img src="/api/placeholder/400/300" alt="Seminar Cyber Security">
                </div>
                <div class="card-content">
                    <h3 class="card-title">Seminar Cyber Security</h3>
                    <div class="card-info">
                        <div class="info-item">
                            <i class="fas fa-calendar"></i>
                            <span>12 Mei 2025</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Teknik Informatika</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-university"></i>
                            <span>Fakultas Teknik</span>
                        </div>
                    </div>
                    <button class="detail-link" onclick="openModal('modal4')">
                        <i class="fas fa-info-circle"></i>
                        Lihat Detail
                    </button>
                </div>
            </div>
            
            <!-- Card 5 -->
            <div class="photo-card">
                <div class="card-image">
                    <img src="/api/placeholder/400/300" alt="Seminar Cyber Security">
                </div>
                <div class="card-content">
                    <h3 class="card-title">Seminar Cyber Security</h3>
                    <div class="card-info">
                        <div class="info-item">
                            <i class="fas fa-calendar"></i>
                            <span>12 Mei 2025</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Teknik Informatika</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-university"></i>
                            <span>Fakultas Teknik</span>
                        </div>
                    </div>
                    <button class="detail-link" onclick="openModal('modal5')">
                        <i class="fas fa-info-circle"></i>
                        Lihat Detail
                    </button>
                </div>
            </div>
             <!-- Card 6 -->
             <div class="photo-card">
                <div class="card-image">
                    <img src="/api/placeholder/400/300" alt="Seminar Artificial Intelligence">
                </div>
                <div class="card-content">
                    <h3 class="card-title">Seminar Artificial Intelligence</h3>
                    <div class="card-info">
                        <div class="info-item">
                            <i class="fas fa-calendar"></i>
                            <span>20 Maret 2025</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Ilmu Komputer</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-university"></i>
                            <span>Fakultas MIPA</span>
                        </div>
                    </div>
                    <button class="detail-link" onclick="openModal('modal6')">
                        <i class="fas fa-info-circle"></i>
                        Lihat Detail
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal 1 -->
    <div id="modal1" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Workshop UI/UX Design</h2>
                <button class="modal-close" onclick="closeModal('modal1')">&times;</button>
            </div>
            <div class="modal-body">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR6fjrLyQ1dLHr4L7lGYdYkgY4-yHXo0emYAw&s" alt="Detail Workshop UI/UX" class="modal-image">
                <div class="modal-meta">
                    <div class="meta-grid">
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>15 Februari 2025</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            <span>09:00 - 17:00 WIB</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Teknik Informatika</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-university"></i>
                            <span>Fakultas Teknik</span>
                        </div>
                    </div>
                </div>
                <div class="modal-description">
                    <p>Workshop UI/UX Design ini akan membahas tentang prinsip-prinsip dasar desain antarmuka pengguna dan pengalaman pengguna. Peserta akan belajar tentang wireframing, prototyping, dan user testing.</p>
                    <p>Workshop ini akan dipandu oleh praktisi UI/UX berpengalaman dari berbagai perusahaan teknologi terkemuka. Peserta akan mendapatkan sertifikat resmi setelah menyelesaikan workshop.</p>
                    <p>Fasilitas yang akan didapatkan: Modul pelatihan, sertifikat, makan siang, dan coffee break.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2 -->
    <div id="modal2" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Seminar Artificial Intelligence</h2>
                <button class="modal-close" onclick="closeModal('modal2')">&times;</button>
            </div>
            <div class="modal-body">
                <img src="/api/placeholder/800/400" alt="Detail Seminar AI" class="modal-image">
                <div class="modal-meta">
                    <div class="meta-grid">
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>20 Maret 2025</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            <span>13:00 - 16:00 WIB</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Ilmu Komputer</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-university"></i>
                            <span>Fakultas MIPA</span>
                        </div>
                    </div>
                </div>
                <div class="modal-description">
                    <p>Seminar Artificial Intelligence ini akan membahas perkembangan terkini dalam dunia kecerdasan buatan dan dampaknya terhadap berbagai sektor industri.</p>
                    <p>Pembicara yang akan hadir adalah pakar AI dari berbagai institusi terkemuka, termasuk peneliti dari Google AI dan Microsoft Research Asia.</p>
                    <p>Agenda akan mencakup: Machine Learning, Deep Learning, Computer Vision, dan Natural Language Processing.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 3 -->
    <div id="modal3" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Workshop Data Science</h2>
                <button class="modal-close" onclick="closeModal('modal3')">&times;</button>
            </div>
            <div class="modal-body">
                <img src="/api/placeholder/800/400" alt="Detail Workshop Data Science" class="modal-image">
                <div class="modal-meta">
                    <div class="meta-grid">
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>5 April 2025</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            <span>08:00 - 16:00 WIB</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Matematika</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-university"></i>
                            <span>Fakultas MIPA</span>
                        </div>
                    </div>
                </div>
                <div class="modal-description">
                    <p>Workshop Data Science ini dirancang untuk memperkenalkan peserta pada konsep dasar ilmu data dan analisis statistik menggunakan Python dan R.</p>
                    <p>Peserta akan belajar teknik-teknik pengolahan data, visualisasi data, dan implementasi model machine learning sederhana.</p>
                    <p>Workshop ini cocok untuk pemula yang ingin memulai karir di bidang Data Science. Peserta akan mendapatkan sertifikat dan akses ke materi online selama 3 bulan.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 4 -->
    <div id="modal4" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Seminar Cyber Security</h2>
                <button class="modal-close" onclick="closeModal('modal4')">&times;</button>
            </div>
            <div class="modal-body">
                <img src="/api/placeholder/800/400" alt="Detail Seminar Cyber Security" class="modal-image">
                <div class="modal-meta">
                    <div class="meta-grid">
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>12 Mei 2025</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            <span>10:00 - 15:00 WIB</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Teknik Informatika</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-university"></i>
                            <span>Fakultas Teknik</span>
                        </div>
                    </div>
                </div>
                <div class="modal-description">
                    <p>Seminar Cyber Security ini akan membahas berbagai aspek keamanan siber yang penting di era digital saat ini, termasuk threat detection, incident response, dan best practices dalam pengamanan sistem.</p>
                    <p>Para pembicara adalah praktisi keamanan siber berpengalaman dari berbagai perusahaan keamanan terkemuka dan institusi pemerintah.</p>
                    <p>Peserta akan mendapatkan pengetahuan tentang tren ancaman siber terkini dan cara mengatasinya, serta networking dengan para profesional di bidang cyber security.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 5 -->
    <div id="modal5" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Seminar Cyber Security</h2>
                <button class="modal-close" onclick="closeModal('modal5')">&times;</button>
            </div>
            <div class="modal-body">
                <img src="/api/placeholder/800/400" alt="Detail Seminar Cyber Security" class="modal-image">
                <div class="modal-meta">
                    <div class="meta-grid">
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>12 Mei 2025</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            <span>10:00 - 15:00 WIB</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Teknik Informatika</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-university"></i>
                            <span>Fakultas Teknik</span>
                        </div>
                    </div>
                </div>
                <div class="modal-description">
                    <p>Seminar Cyber Security ini akan membahas berbagai aspek keamanan siber yang penting di era digital saat ini, termasuk threat detection, incident response, dan best practices dalam pengamanan sistem.</p>
                    <p>Para pembicara adalah praktisi keamanan siber berpengalaman dari berbagai perusahaan keamanan terkemuka dan institusi pemerintah.</p>
                    <p>Peserta akan mendapatkan pengetahuan tentang tren ancaman siber terkini dan cara mengatasinya, serta networking dengan para profesional di bidang cyber security.</p>
                </div>
            </div>
        </div>
    </div>

     <!-- Modal 6 -->
     <div id="modal6" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Seminar Artificial Intelligence</h2>
                <button class="modal-close" onclick="closeModal('modal6')">&times;</button>
            </div>
            <div class="modal-body">
                <img src="/api/placeholder/800/400" alt="Detail Seminar AI" class="modal-image">
                <div class="modal-meta">
                    <div class="meta-grid">
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>20 Maret 2025</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            <span>13:00 - 16:00 WIB</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Ilmu Komputer</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-university"></i>
                            <span>Fakultas MIPA</span>
                        </div>
                    </div>
                </div>
                <div class="modal-description">
                    <p>Seminar Artificial Intelligence ini akan membahas perkembangan terkini dalam dunia kecerdasan buatan dan dampaknya terhadap berbagai sektor industri.</p>
                    <p>Pembicara yang akan hadir adalah pakar AI dari berbagai institusi terkemuka, termasuk peneliti dari Google AI dan Microsoft Research Asia.</p>
                    <p>Agenda akan mencakup: Machine Learning, Deep Learning, Computer Vision, dan Natural Language Processing.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).style.display = "block";
            document.body.style.overflow = "hidden";
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
            document.body.style.overflow = "auto";
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = "none";
                document.body.style.overflow = "auto";
            }
        }
        function openModal(modalId) {
            document.getElementById(modalId).style.display = "block";
            document.body.style.overflow = "hidden";
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
            document.body.style.overflow = "auto";
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = "none";
                document.body.style.overflow = "auto";
            }
        }
    </script>
</body>
</html>
@include('pemeringkatan.footerpemeringkatan')