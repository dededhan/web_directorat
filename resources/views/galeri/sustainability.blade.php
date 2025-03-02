<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sustainability</title>
    <link rel="stylesheet" href="{{ asset('alumni.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

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
        
        .activity-photos {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
            margin: 30px 0;
        }
        
        .photo-card {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .photo-card:hover {
            transform: translateY(-5px);
        }
        
        .card-image {
            height: 200px;
            overflow: hidden;
        }
        
        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .photo-card:hover .card-image img {
            transform: scale(1.05);
        }
        
        .card-content {
            padding: 16px;
        }
        
        .card-title {
            font-size: 18px;
            margin-bottom: 12px;
            color: #333;
            font-weight: 600;
        }
        
        .card-info {
            margin-bottom: 15px;
            font-size: 14px;
        }
        
        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            color: #666;
        }
        
        .info-item i {
            margin-right: 8px;
            color: #3498db;
        }
        
        .detail-link {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 14px;
        }
        
        .detail-link i {
            margin-right: 8px;
        }
        
        .detail-link:hover {
            background-color: #2980b9;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            overflow-y: auto;
        }
        
        .modal-content {
            background-color: white;
            width: 90%;
            max-width: 800px;
            margin: 50px auto;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }
        
        .modal-header {
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #3498db;
            color: white;
        }
        
        .modal-title {
            margin: 0;
            font-size: 20px;
        }
        
        .modal-close {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }
        
        .modal-body {
            padding: 16px;
        }
        
        .modal-image {
            width: 100%;
            border-radius: 8px;
            max-height: 400px;
            object-fit: cover;
            margin-bottom: 20px;
        }
        
        .modal-meta {
            margin-bottom: 24px;
            padding: 16px;
            background-color: #f5f5f5;
            border-radius: 8px;
        }
        
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
        }
        
        .meta-item i {
            margin-right: 10px;
            color: #3498db;
        }
        
        .modal-description p {
            margin-bottom: 16px;
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
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.3s;
        }
        
        .gallery-image:hover {
            transform: scale(1.05);
        }
        
        @media (max-width: 768px) {
            .meta-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>


<body>
    <div class="main-navbar-wrapper">
        @include('navbar')
    </div>
    

    <nav class="alumni-navbar">
        <a href="#" class="navbar-logo mt-2">
            <img src="https://spm.unj.ac.id/wp-content/uploads/2024/08/cropped-Logo-UNJ-PTNBH-RGB_Logo_Motto_Transparan.png" alt="Logo" />
            <span class="navbar-logo-text">SUSTAINABILITY</span>
        </a>
        <ul class="navbar-menu">
            <li><a href="#">Home</a></li>
            <li><a href="#">Sustainability Activities</a></li>
        </ul>
    </nav>
    
    <div class="container">
        <div class="activity-photos">
            @forelse($sustainabilities as $index => $activity)
                <div class="photo-card">
                    <div class="card-image">
                        @if($activity->photos->count() > 0)
                            <img src="{{ asset('storage/' . $activity->photos->first()->path) }}" alt="{{ $activity->judul_kegiatan }}">
                        @else
                            <img src="/api/placeholder/400/300" alt="{{ $activity->judul_kegiatan }}">
                        @endif
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">{{ $activity->judul_kegiatan }}</h3>
                        <div class="card-info">
                            <div class="info-item">
                                <i class="fas fa-calendar"></i>
                                <span>{{ \Carbon\Carbon::parse($activity->tanggal_kegiatan)->format('d F Y') }}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-graduation-cap"></i>
                                <span>{{ $activity->prodi }}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-university"></i>
                                <span>{{ strtoupper($activity->fakultas) }}</span>
                            </div>
                        </div>
                        <button class="detail-link" onclick="openModal('modal-{{ $activity->id }}')">
                            <i class="fas fa-info-circle"></i>
                            Lihat Detail
                        </button>
                    </div>
                </div>
            @empty
                <div class="no-activities">
                    <p>Belum ada kegiatan sustainability yang ditambahkan.</p>
                </div>
            @endforelse
        </div>
    </div>

    @foreach($sustainabilities as $activity)
        <div id="modal-{{ $activity->id }}" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">{{ $activity->judul_kegiatan }}</h2>
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
</body>
</html>
@include('pemeringkatan.footerpemeringkatan')