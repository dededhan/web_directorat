<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUSTAINABILITY IMPACT</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('alumni.css') }}">
    
    <style>
        #navbar, .top-bar {
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
            left: 0 !important;
            right: 0 !important;
        }
        
        body > div:first-of-type {
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Custom modal styles to match existing design */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            display: none;
            z-index: 1000;
            overflow-y: auto;
        }

        .modal-content {
            background: white;
            width: 90%;
            max-width: 800px;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .modal-header {
            background-color: var(--primary-color);
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .modal-close {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .modal-meta {
            background-color: #f4f4f4;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .modal-meta .meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
        }

        .modal-meta .meta-item {
            display: flex;
            align-items: center;
        }

        .modal-meta .meta-item i {
            margin-right: 10px;
            color: var(--primary-color);
        }

        .modal-description {
            line-height: 1.6;
        }

        .gallery-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
            margin-top: 20px;
        }

        .gallery-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .gallery-image:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div class="main-navbar-wrapper">
    </div>
    
    <nav class="alumni-navbar">
        <a href="#" class="navbar-logo">
            <img src="https://spm.unj.ac.id/wp-content/uploads/2024/08/cropped-Logo-UNJ-PTNBH-RGB_Logo_Motto_Transparan.png" alt="Logo" />
            <span class="navbar-logo-text">SUSTAINABILITY</span>
        </a>
        <ul class="navbar-menu">
            <li><a href="{{ route('home') }}" class="menu-link">Home</a></li>
            <li><a href="#" class="menu-link active">Sustainability Activities</a></li>
        </ul>
    </nav>

    <div class="hero-section">
        <div class="hero-content">
            <h1>Our Sustainability Initiatives</h1>
            <p>Discover how UNJ is driving positive environmental and social change</p>
        </div>
    </div>
    
    <div class="container">
        <div class="section-header">
            <h2>Sustainability Activities</h2>
            <div class="section-divider"></div>
        </div>
        
        <div class="alumni-grid">
            @forelse($sustainabilities as $activity)
                <div class="alumni-card">
                    <div class="card-image">
                        @if($activity->photos->count() > 0)
                            <img src="{{ asset('storage/' . $activity->photos->first()->path) }}" alt="{{ $activity->judul_kegiatan }}">
                        @else
                            <img src="/api/placeholder/400/300" alt="{{ $activity->judul_kegiatan }}">
                        @endif
                        <div class="faculty-badge">{{ strtoupper($activity->fakultas) }}</div>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">{{ $activity->judul_kegiatan }}</h3>
                        <div class="card-meta">
                            <div class="meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>{{ \Carbon\Carbon::parse($activity->tanggal_kegiatan)->format('d F Y') }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-graduation-cap"></i>
                                <span>{{ $activity->prodi }}</span>
                            </div>
                        </div>
                        <button onclick="openModal('modal-{{ $activity->id }}')" class="read-more">
                            <span>View Details</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>No Sustainability Activities</h3>
                    <p>Belum ada kegiatan sustainability yang tersedia</p>
                </div>
            @endforelse
        </div>
    </div>

    @foreach($sustainabilities as $activity)
        <div id="modal-{{ $activity->id }}" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>{{ $activity->judul_kegiatan }}</h2>
                    <button class="modal-close" onclick="closeModal('modal-{{ $activity->id }}')">&times;</button>
                </div>
                <div class="modal-body">
                    @if($activity->photos->count() > 0)
                        <img src="{{ asset('storage/' . $activity->photos->first()->path) }}" alt="{{ $activity->judul_kegiatan }}" class="modal-image">
                    @else
                        <img src="/api/placeholder/800/400" alt="{{ $activity->judul_kegiatan }}" class="modal-image">
                    @endif
                    
                    <div class="modal-meta">
                        <div class="meta-grid">
                            <div class="meta-item">
                                <i class="fas fa-calendar"></i>
                                <span>{{ \Carbon\Carbon::parse($activity->tanggal_kegiatan)->format('d F Y') }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-graduation-cap"></i>
                                <span>{{ $activity->prodi }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-university"></i>
                                <span>{{ strtoupper($activity->fakultas) }}</span>
                            </div>
                            @if($activity->link_kegiatan)
                            <div class="meta-item">
                                <i class="fas fa-link"></i>
                                <a href="{{ $activity->link_kegiatan }}" target="_blank">Link Kegiatan</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="modal-description">
                        <p>{{ $activity->deskripsi_kegiatan }}</p>
                    </div>
                    
                    @if($activity->photos->count() > 1)
                    <h4>Galeri Foto</h4>
                    <div class="gallery-container">
                        @foreach($activity->photos as $photo)
                            <img src="{{ asset('storage/' . $photo->path) }}" class="gallery-image" 
                                 onclick="openFullImage('{{ asset('storage/' . $photo->path) }}')">
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    <!-- Full Image Modal -->
    <div id="fullImageModal" class="modal">
        <div class="modal-content" style="background: transparent; box-shadow: none; max-width: 90%;">
            <button class="modal-close" style="position: absolute; right: 20px; top: 20px; background: rgba(0,0,0,0.5); border-radius: 50%; width: 40px; height: 40px; display: flex; justify-content: center; align-items: center;" onclick="closeFullImage()">&times;</button>
            <img id="fullImage" style="width: 100%; max-height: 90vh; object-fit: contain;" src="" alt="Full Image">
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
        
        function openFullImage(imgSrc) {
            document.getElementById('fullImage').src = imgSrc;
            document.getElementById('fullImageModal').style.display = "block";
            document.body.style.overflow = "hidden";
        }
        
        function closeFullImage() {
            document.getElementById('fullImageModal').style.display = "none";
            document.body.style.overflow = "auto";
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = "none";
                document.body.style.overflow = "auto";
            }
        }
    </script>

    @include('galeri.footersustainability')
</body>
</html>