

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pimpinan DISIP</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            text-align: center;
            padding: 40px 0;
        }

        header h1 {
            color: #186862;
            font-size: 42px;
            margin-bottom: 20px;
            letter-spacing: 2px;
        }

        .director-profile {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 60px;
        }

        @media (min-width: 768px) {
            .director-profile {
                flex-direction: row;
                align-items: flex-start;
            }
        }

        .profile-image {
            flex: 0 0 280px;
            margin-right: 30px;
            margin-bottom: 20px;
        }

        .profile-image img {
            width: 100%;
            border-radius: 50%; /* Changed to circular */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            object-fit: cover;
            object-position: center top;
            aspect-ratio: 1/1;
            border: 5px solid #186862;
        }

        .profile-content {
            flex: 1;
        }

        .profile-content h2 {
            font-size: 28px;
            margin-bottom: 5px;
            color: #186862;
        }

        .profile-content h3 {
            color: #186862;
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .profile-content p {
            margin-bottom: 15px;
            text-align: justify;
        }

        .team-section {
            padding: 40px 0;
        }

        /* Updated team members class for maximum spacing */
        .team-members {
            display: flex;
            justify-content: space-between; /* Changed to space-between for maximum separation */
            flex-wrap: wrap;
            gap: 80px; /* Significantly increased spacing to 80px */
            margin: 0 auto;
            padding: 0 10%;  /* Added padding to push items away from edges */
        }

        .team-member {
            flex: 0 0 240px; /* Increased width from 200px to 240px */
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 60px; /* Increased margin to 60px */
            transition: transform 0.3s ease;
        }

        .team-member:hover {
            transform: translateY(-10px);
        }

        .member-image {
            width: 180px; /* Standardized size */
            height: 180px; /* Standardized size */
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 15px;
            border: 5px solid #186862;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .member-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top; /* Standardized positioning */
        }

        .member-info {
            text-align: center;
        }

        .member-info h4 {
            font-size: 18px; /* Increased from 16px */
            margin-bottom: 5px;
            color: #186862;
            font-weight: bold; /* Added bold */
        }

        .member-info h5 {
            color: #666;
            font-size: 16px; /* Increased from 14px */
            font-weight: 500;
            margin-bottom: 10px;
        }

        .member-info p {
            font-size: 14px; /* Increased from 12px */
            color: #555; /* Darkened from #888 */
            line-height: 1.5; /* Added line height for better readability */
        }

        .detail-button {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 15px;
            background-color: #fff;
            color: #333;
            border: 2px solid #186862;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .detail-button:hover {
            background-color: #186862;
            color: #fff;
        }

        .profile-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            overflow: auto;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 30px;
            width: 90%;
            max-width: 900px;
            border-radius: 10px;
            position: relative;
            transform: translateY(-50px);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        @media (min-width: 768px) {
            .modal-content {
                flex-direction: row;
                align-items: flex-start;
            }
        }

        .modal-image {
            flex: 0 0 280px;
            margin-right: 30px;
            margin-bottom: 20px;
        }

        .modal-image img {
            width: 100%;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .modal-text {
            flex: 1;
        }

        .profile-modal.active {
            display: block;
            opacity: 1;
        }

        .profile-modal.active .modal-content {
            transform: translateY(0);
        }

        .close-button {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in forwards;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        .slide-up {
            animation: slideUp 0.5s ease-in forwards;
        }

        @keyframes slideUp {
            0% { transform: translateY(50px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
@include('layout.navbar_sticky')
<body>
    <div class="container">
        <header class="fade-in">
            <h1>Pimpinan DITISIP</h1>
        </header>

        @if($direktur)
        <div class="director-profile slide-up">
            <div class="profile-image">
                <img src="{{ asset('storage/' . $direktur->gambar) }}" alt="{{ $direktur->nama }}">
            </div>
            <div class="profile-content">
                <h2>{{ $direktur->nama }}</h2>
                <h3>{{ $direktur->jabatan }}</h3>
                <div>
                    {!! $direktur->deskripsi !!}
                </div>
            </div>
        </div>
        @else
        <div class="director-profile slide-up">
            <div class="profile-image">
                <img src="/api/placeholder/300/370" alt="Director Photo">
            </div>
            <div class="profile-content">
                <h2>Direktur Inovasi Sistem Informasi dan Pemeringkatan</h2>
                <h3>Belum tersedia</h3>
                <p>Data belum tersedia.</p>
            </div>
        </div>
        @endif

        <div class="team-section fade-in">
            <div class="team-members">
                @forelse($kasubdits as $kasubdit)
                <div class="team-member">
                    <div class="member-image">
                        <img src="{{ asset('storage/' . $kasubdit->gambar) }}" alt="{{ $kasubdit->nama }}">
                    </div>
                    <div class="member-info">
                        <h4>{{ $kasubdit->nama }}</h4>
                        <h5>{{ $kasubdit->jabatan }}</h5>
                        <p>{{ Str::limit(strip_tags($kasubdit->deskripsi), 80) }}</p>
                        <a href="#" class="detail-button" data-id="{{ $kasubdit->id }}">Selengkapnya</a>
                    </div>
                </div>
                @empty
                <div class="text-center w-full">
                    <p>Belum ada data pimpinan Subdirektorat.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="profile-modal" id="profileModal">
        <div class="modal-content">
            <span class="close-button" id="closeModal">&times;</span>
            
            <div class="modal-image">
                <img id="modalImage" src="" alt="Team Member">
            </div>
            
            <div class="modal-text">
                <h2 id="modalName" style="color: #186862; font-size: 28px; margin-bottom: 5px;"></h2>
                <h3 id="modalPosition" style="color: #186862; font-size: 18px; margin-bottom: 20px; font-weight: 500;"></h3>
                
                <div id="modalContent">
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal functionality
            const modal = document.getElementById('profileModal');
            const closeModal = document.getElementById('closeModal');
            const modalName = document.getElementById('modalName');
            const modalPosition = document.getElementById('modalPosition');
            const modalImage = document.getElementById('modalImage');
            const modalContent = document.getElementById('modalContent');
            
            // Team member data with their details
            const teamData = {
                @foreach($kasubdits as $kasubdit)
                "{{ $kasubdit->id }}": {
                    name: "{{ $kasubdit->nama }}",
                    position: "{{ $kasubdit->jabatan }}",
                    imgSrc: "{{ asset('storage/' . $kasubdit->gambar) }}",
                    description: `{!! $kasubdit->deskripsi !!}`
                },
                @endforeach
            };

            // Open modal with specific member data
            document.querySelectorAll('.detail-button').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const memberId = this.getAttribute('data-id');
                    const member = teamData[memberId];
                    
                    if (member) {
                        modalName.textContent = member.name;
                        modalPosition.textContent = member.position;
                        modalImage.src = member.imgSrc;
                        modalImage.alt = member.name;
                        modalContent.innerHTML = member.description;
                        
                        modal.classList.add('active');
                    }
                });
            });

            // Close modal
            closeModal.addEventListener('click', function() {
                modal.classList.remove('active');
            });

            // Close modal when clicking outside of it
            window.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.remove('active');
                }
            });

            // Scroll animation
            const observerOptions = {
                threshold: 0.1
            };

            const observer = new IntersectionObserver(function(entries, observer) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('slide-up');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Observe all team members
            document.querySelectorAll('.team-member').forEach(member => {
                observer.observe(member);
            });
        });
    </script>
</body>
@include('pimpinan.footerlp')
</html>