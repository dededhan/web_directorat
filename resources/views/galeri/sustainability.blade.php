<!DOCTYPE html>
<html lang="id">
<head>
<link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUSTAINABILITY IMPACT</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('unj-navbar.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    
    <style>
       @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

:root {
    --primary-color: #186666;
    --secondary-color: #2A8D8D;
    --accent-color: #3AA6A6;
    --text-color: #1f2937;
    --light-text: #6b7280;
    --border-color: #e5e7eb;
    --background-color: #f9fafb;
    --card-bg: #ffffff;
    --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --hover-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    --transition: all 0.3s ease;
}

body {
    background-color: var(--background-color);
    color: var(--text-color);
    line-height: 1.6;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

.hero-section {
    background-color: #D1E7DD;
    padding: 5rem 2rem;
    color: #186666; /* Changed to match brand color */
    text-align: center;
    clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
    margin-bottom: 3rem; /* Added margin to create space between sections */
}

.hero-content {
    max-width: 800px;
    margin: 0 auto;
}

.hero-content h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.hero-content p {
    font-size: 1.2rem;
    font-weight: 400; /* Increased from 300 */
    opacity: 0.9;
}

/* Container */
.sustainability-container {
    max-width: 1280px;
    margin: 3rem auto;
    padding: 0 1.5rem;
}
/* Section Header */
.section-header {
    text-align: center;
    margin-bottom: 3rem;
}

.section-header h2 {
    font-size: 2rem;
    font-weight: 700;
    color: #186666;
    margin-bottom: 1rem;
}

.section-divider {
    height: 4px;
    width: 60px;
    background: #186666;
    margin: 0 auto;
    border-radius: 2px;
}

/* Alumni Grid */
.alumni-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
}

.alumni-card {
    background-color: var(--card-bg);
    border-radius: 1rem;
    overflow: hidden;
    transition: var(--transition);
    box-shadow: var(--shadow);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.alumni-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--hover-shadow);
}

.card-image {
    height: 220px;
    position: relative;
    overflow: hidden;
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.7s ease;
}

.alumni-card:hover .card-image img {
    transform: scale(1.05);
}

.faculty-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background-color: #186666;
    color: white;
    padding: 0.3rem 0.7rem;
    border-radius: 99px;
    font-size: 0.8rem;
    font-weight: 500;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.card-content {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.card-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #186666;
    line-height: 1.4;
}

.card-meta {
    margin-bottom: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 0.7rem;
}

.meta-item {
    display: flex !important;
    align-items: center !important;
    gap: 0.5rem;
    color: var(--light-text);
    font-size: 0.9rem;
    line-height: 1.5 !important;
}

.meta-item i {
    color: #3AA6A6;
    font-size: 1rem;
    width: 20px !important;
    text-align: center !important;
    margin-right: 5px !important;
    transform: none !important;
    vertical-align: middle !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    position: relative !important;
    top: 0 !important;
}

.read-more {
    margin-top: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.7rem 1.2rem;
    background-color: rgba(24, 102, 102, 0.1);
    color: #186666;
    text-decoration: none;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: var(--transition);
}

.read-more:hover {
    background-color: #186666;
    color: white;
}

.read-more i {
    transition: transform 0.3s ease;
}

.read-more:hover i {
    transform: translateX(3px);
}

/* Empty State */
.sustainability-empty-state {
    grid-column: 1 / -1;
    background-color: var(--card-bg);
    padding: 3rem;
    border-radius: 1rem;
    text-align: center;
    box-shadow: var(--shadow);
}

.sustainability-empty-icon {
    background-color: rgba(24, 102, 102, 0.1);
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.sustainability-empty-icon i {
    font-size: 2rem;
    color: #186666;
}

.sustainability-empty-state h3 {
    font-size: 1.5rem;
    color: #186666;
    margin-bottom: 0.5rem;
}

.sustainability-empty-state p {
    color: var(--light-text);
}

/* Icon fixes for all FontAwesome icons */
.fa, .fas, .far, .fab {
    transform: none !important;
    vertical-align: middle !important;
    line-height: 1 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
}

/* Specific fix for common icons */
.fa-calendar-alt, .fa-calendar, .fa-university, .fa-graduation-cap, .fa-document, .fa-file, .fa-link, .fa-leaf {
    position: relative !important;
    top: 0 !important; 
}

/* Modal meta item icons fix */
.modal-meta .meta-item i {
    margin-right: 10px;
    color: var(--primary-color);
    transform: none !important;
    vertical-align: middle !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 20px !important;
    text-align: center !important;
}

/* Update responsive styles to use the new class name */
@media (max-width: 768px) {
    .alumni-navbar {
        flex-direction: column;
        padding: 1rem;
    }
    
    .navbar-logo {
        margin-bottom: 1rem;
    }
    
    .navbar-menu {
        width: 100%;
        justify-content: center;
        gap: 1.5rem;
    }
    
    .hero-section {
        padding: 3rem 1rem;
    }
    
    .hero-content h1 {
        font-size: 2rem;
    }
    
    .hero-content p {
        font-size: 1rem;
    }
    
    .sustainability-container {
        padding: 0 1rem;
    }
    
    .alumni-grid {
        grid-template-columns: repeat(1, 1fr);
    }
}

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
@include('layout.navbar_sticky')
<body>
    
    
    <div class="hero-section">
        <div class="hero-content">
            <h1>Our Sustainability Initiatives</h1>
            <p>Discover how UNJ is driving positive environmental and social change</p>
        </div>
    </div>
    
    <!-- Replace the existing container div with this updated version -->
<div class="sustainability-container">
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
            <div class="sustainability-empty-state">
                <div class="sustainability-empty-icon">
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

@include('layout.footer')
</body>
</html>