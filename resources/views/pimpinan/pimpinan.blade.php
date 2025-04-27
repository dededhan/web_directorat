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
    <link rel="stylesheet" href="{{ asset('css/ckeditor-list.css') }}">

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

        .leadership-triangle {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 40px;
            padding: 20px;
        }

        .director-profile {
            width: 100%;
            max-width: 800px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 40px;
        }

        .director-profile .profile-image {
            width: 280px;
            height: 280px;
            margin-bottom: 20px;
        }

        .director-profile .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #186862;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .team-members {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 40px;
            width: 100%;
        }

        .team-member {
            width: 240px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .team-member .member-image {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 15px;
            border: 5px solid #186862;
        }

        .team-member .member-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .team-member .member-info h4 {
            color: #186862;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .team-member .member-info h5 {
            color: #666;
            margin-bottom: 10px;
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
            transition: all 0.3s ease;
        }

        .detail-button:hover {
            background-color: #186862;
            color: #fff;
        }

        /* Modal styles remain the same as in the original code */
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

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .leadership-triangle {
                gap: 20px;
            }

            .director-profile,
            .team-member {
                width: 100%;
                max-width: none;
            }
        }
    </style>
    @include('layout.navbar_sticky')

<body>
    <div class="container">
        <header>
            <h1>Pimpinan DITISIP</h1>
        </header>

        <div class="leadership-triangle">
            @if ($direktur)
                <div class="director-profile">
                    <div class="profile-image">
                        <img src="{{ asset('storage/' . $direktur->gambar) }}" alt="{{ $direktur->nama }}">
                    </div>
                    <div class="profile-content">
                        <h2 style="color: #186862; font-size: 28px; margin-bottom: 5px;">{{ $direktur->nama }}</h2>
                        <h3 style="color: #186862; font-size: 18px; margin-bottom: 20px;">{{ $direktur->jabatan }}</h3>
                        <div class="ck-content">
                            {!! $direktur->deskripsi !!}
                        </div>
                    </div>
                </div>
            @else
                <div class="director-profile">
                    <div class="profile-image">
                        <img src="/api/placeholder/300/300" alt="Director Photo">
                    </div>
                    <div class="profile-content">
                        <h2>Direktur Inovasi Sistem Informasi dan Pemeringkatan</h2>
                        <h3>Belum tersedia</h3>
                        <p>Data belum tersedia.</p>
                    </div>
                </div>
            @endif

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

    <!-- Modal remains the same as in the original code -->
    <div class="profile-modal" id="profileModal">
        <div class="modal-content">
            <span class="close-button" id="closeModal">&times;</span>

            <div class="modal-image">
                <img id="modalImage" src="" alt="Team Member">
            </div>

            <div class="modal-text">
                <h2 id="modalName" style="color: #186862; font-size: 28px; margin-bottom: 5px;"></h2>
                <h3 id="modalPosition" style="color: #186862; font-size: 18px; margin-bottom: 20px; font-weight: 500;">
                </h3>

                <div id="modalContent" class="ck-content">
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
                @foreach ($kasubdits as $kasubdit)
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
        });
    </script>
</body>
@include('pimpinan.footerlp')
</html>