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
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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

        .team-members {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }

        .team-member {
            flex: 0 0 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }

        .team-member:hover {
            transform: translateY(-10px);
        }

        .member-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 15px;
            border: 5px solid #186862;
        }

        .member-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .member-info {
            text-align: center;
        }

        .member-info h4 {
            font-size: 16px;
            margin-bottom: 5px;
            color: #186862;
        }

        .member-info h5 {
            color: #666;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .member-info p {
            font-size: 12px;
            color: #888;
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
@include('pimpinan.navbar')
<body>
    <!-- Navbar placeholder - would be included from another file -->
    
    <div class="container">
        <header class="fade-in">
            <h1>Pimpinan DISIP</h1>
        </header>

        <div class="director-profile slide-up">
            <div class="profile-image">
                <img src="/api/placeholder/300/370" alt="Director Photo">
            </div>
            <div class="profile-content">
                <h2>Nama Direktur</h2>
                <h3>Consectetur Adipiscing Elit</h3>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum vestibulum. Cras porttitor metus justo, vitae tincidunt ipsum fermentum sit amet. Maecenas fringilla consectetur tempor. Fusce ultrices quam vel maximus vehicula. Vivamus feugiat urna in magna dictum lacinia.
                </p>
                <p>
                    Nullam rhoncus, libero sed facilisis feugiat, turpis quam gravida nisl, a pulvinar quam massa quis nibh. Proin eget arcu nec turpis facilisis interdum. Vivamus vitae magna eget ligula auctor sagittis. Suspendisse potenti. Etiam fermentum felis eget urna faucibus, nec tincidunt nisl pellentesque.
                </p>
                <p>
                    Curabitur dignissim elit eu risus pharetra, a feugiat est tincidunt. Mauris varius lacinia diam, id feugiat mauris luctus et. Phasellus vulputate rhoncus nulla et euismod. Fusce ac libero vel nulla pulvinar tempus lobortis sit amet justo. Sed consectetur, nunc vitae tincidunt elementum, sem lorem vestibulum ipsum.
                </p>
                <p>
                    Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec dapibus velit nec tellus condimentum, id eleifend eros vestibulum. Aliquam erat volutpat. Praesent eget magna sit amet nibh finibus tempus eget sit amet ligula. Fusce tempor neque at lectus scelerisque finibus.
                </p>
            </div>
        </div>

        <div class="team-section fade-in">
            <div class="team-members">
                <div class="team-member">
                    <div class="member-image">
                        <img src="/api/placeholder/150/150" alt="Team Member 1">
                    </div>
                    <div class="member-info">
                        <h4>LOREM IPSUM DOLOR</h4>
                        <h5>CONSECTETUR ADIPISCING ELIT</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce euismod lacus vel magna gravida, id aliquet nibh vehicula.</p>
                        <a href="#" class="detail-button" data-id="member1">Selengkapnya</a>
                    </div>
                </div>

                <div class="team-member">
                    <div class="member-image">
                        <img src="/api/placeholder/150/150" alt="Team Member 2">
                    </div>
                    <div class="member-info">
                        <h4>VIVAMUS LACINIA ODIO</h4>
                        <h5>VITAE VESTIBULUM VESTIBULUM</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum vitae magna ac odio eleifend tempus vel ac neque.</p>
                        <a href="#" class="detail-button" data-id="member2">Selengkapnya</a>
                    </div>
                </div>

                <div class="team-member">
                    <div class="member-image">
                        <img src="/api/placeholder/150/150" alt="Team Member 3">
                    </div>
                    <div class="member-info">
                        <h4>MAECENAS FRINGILLA CONSECTETUR</h4>
                        <h5>FUSCE ULTRICES QUAM VEL MAXIMUS</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames.</p>
                        <a href="#" class="detail-button" data-id="member3">Selengkapnya</a>
                    </div>
                </div>

                <div class="team-member">
                    <div class="member-image">
                        <img src="/api/placeholder/150/150" alt="Team Member 4">
                    </div>
                    <div class="member-info">
                        <h4>NULLAM RHONCUS LIBERO</h4>
                        <h5>PULVINAR QUAM MASSA QUIS</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec venenatis magna in metus rutrum ultricies. Suspendisse potenti.</p>
                        <a href="#" class="detail-button" data-id="member4">Selengkapnya</a>
                    </div>
                </div>

                <div class="team-member">
                    <div class="member-image">
                        <img src="/api/placeholder/150/150" alt="Team Member 5">
                    </div>
                    <div class="member-info">
                        <h4>CURABITUR DIGNISSIM ELIT</h4>
                        <h5>FEUGIAT EST TINCIDUNT</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eu metus fermentum, fringilla quam vel, consequat turpis.</p>
                        <a href="#" class="detail-button" data-id="member5">Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="profile-modal" id="profileModal">
        <div class="modal-content">
            <span class="close-button" id="closeModal">&times;</span>
            
            <div class="modal-image">
                <img id="modalImage" src="/api/placeholder/300/370" alt="Team Member">
            </div>
            
            <div class="modal-text">
                <h2 id="modalName" style="color: #186862; font-size: 28px; margin-bottom: 5px;"></h2>
                <h3 id="modalPosition" style="color: #186862; font-size: 18px; margin-bottom: 20px; font-weight: 500;"></h3>
                
                <div id="modalContent">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla accumsan, metus ultrices eleifend gravida, nulla nunc varius lectus, nec rutrum justo nibh eu lectus. Ut vulputate semper dui. Fusce erat odio, sollicitudin vel erat vel, interdum mattis neque. Sed quis semper magna. Sed a risus in felis bibendum ullamcorper.</p>
                    <p>Maecenas eget justo sem. Nullam feugiat, augue in consectetur ultricies, risus elit eleifend orci, quis maximus justo nulla non orci. Suspendisse tincidunt venenatis purus in interdum. Fusce eget nisl a est suscipit ultricies in sed ante. Nunc porttitor sapien a scelerisque aliquet. Maecenas dignissim sem in justo sollicitudin convallis.</p>
                    <p>Vivamus at iaculis nunc. Pellentesque suscipit magna sit amet eros placerat, sed condimentum quam congue. Cras ultricies, augue in hendrerit sagittis, turpis nulla feugiat magna, eu lobortis turpis justo id justo. Nulla rhoncus a risus eu placerat. Quisque feugiat justo vel nulla blandit, vitae bibendum risus tempus.</p>
                    <p>Praesent rutrum velit a lorem finibus feugiat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vivamus ornare velit id enim eleifend, in malesuada sapien semper. Proin maximus diam sem, quis malesuada metus faucibus vel.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer placeholder - would be included from another file -->
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll effect
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Modal functionality
            const modal = document.getElementById('profileModal');
            const closeModal = document.getElementById('closeModal');
            const modalName = document.getElementById('modalName');
            const modalPosition = document.getElementById('modalPosition');
            const modalImage = document.getElementById('modalImage');
            
            // Team member data
            const teamData = {
                member1: {
                    name: 'LOREM IPSUM DOLOR',
                    position: 'CONSECTETUR ADIPISCING ELIT',
                    imgSrc: '/api/placeholder/300/370'
                },
                member2: {
                    name: 'VIVAMUS LACINIA ODIO',
                    position: 'VITAE VESTIBULUM VESTIBULUM',
                    imgSrc: '/api/placeholder/300/370'
                },
                member3: {
                    name: 'MAECENAS FRINGILLA CONSECTETUR',
                    position: 'FUSCE ULTRICES QUAM VEL MAXIMUS',
                    imgSrc: '/api/placeholder/300/370'
                },
                member4: {
                    name: 'NULLAM RHONCUS LIBERO',
                    position: 'PULVINAR QUAM MASSA QUIS',
                    imgSrc: '/api/placeholder/300/370'
                },
                member5: {
                    name: 'CURABITUR DIGNISSIM ELIT',
                    position: 'FEUGIAT EST TINCIDUNT',
                    imgSrc: '/api/placeholder/300/370'
                }
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