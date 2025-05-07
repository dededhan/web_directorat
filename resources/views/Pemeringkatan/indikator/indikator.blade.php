<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indikator Pemeringkatan</title>
    
    <!-- External CSS Libraries -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ckeditor-list.css') }}">
</head>
<style>
/* Global Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Roboto', sans-serif;
}

body {
    background-color: #f5f5f5;
    color: #333;
    line-height: 1.6;
}

/* Back Button Styles */
.back-button {
    display: inline-flex;
    align-items: center;
    padding: 8px 15px;
    background-color: #277177;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-weight: 500;
    transition: all 0.3s ease;
    margin: 20px 0 0 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.back-button:hover {
    background-color: #1c5a5f;
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
}

.back-button i {
    margin-right: 8px;
}

/* Main Title Section */
.page-title {
    color: #277177;
    padding: 15px 20px;
    text-align: center;
    font-size: 28px;
    font-weight: 600;
    letter-spacing: 0.5px;
    margin-top: 10px;  /* Reduced spacing between navbar and title */
    margin-bottom: 0;
}

/* Banner Styles */
.indikator-banner {
    background-color: #277177; /* Teal background */
    color: #fff;
    padding: 40px 20px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.indikator-banner h2 {
    font-size: 32px;
    font-weight: 700;
    margin: 0;
}

/* Info Section Layout */
.info-section {
    display: flex;
    max-width: 1200px;
    margin: 30px auto;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

/* Sidebar Navigation */
.info-sidebar {
    flex: 0 0 250px;
    background-color: #f0f4f8;
    padding: 20px 0;
}

.info-sidebar ul {
    list-style: none;
}

.info-sidebar li {
    margin-bottom: 2px;
}

.info-sidebar a {
    display: block;
    padding: 12px 20px;
    color: #555;
    text-decoration: none;
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.info-sidebar a:hover {
    background-color: #e3e8f0;
    color: #277177;
}

.info-sidebar a.active {
    background-color: #e6f3f3;
    color: #277177;
    border-left: 4px solid #277177;
    font-weight: 700;
}

/* Content Area */
.info-content {
    flex: 1;
    padding: 30px;
}

.info-content h2 {
    color: #277177;
    margin-bottom: 20px;
    font-size: 24px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e6f3f3;
}

.info-content p {
    margin-bottom: 20px;
    color: #555;
}

/* Footer Spacer */
.footer-spacer {
    height: 60px;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .back-button {
        margin: 15px 0 0 15px;
        font-size: 14px;
        padding: 6px 12px;
    }
    
    .info-section {
        flex-direction: column;
        margin: 20px 15px;
    }
    
    .info-sidebar {
        flex: auto;
        width: 100%;
    }
    
    .info-sidebar ul {
        display: flex;
        flex-wrap: wrap;
        padding: 0 10px;
    }
    
    .info-sidebar li {
        margin: 5px;
    }
    
    .info-sidebar a {
        padding: 8px 15px;
        border-left: none;
        border-bottom: 2px solid transparent;
        font-size: 14px;
        text-align: center;
        border-radius: 4px;
    }
    
    .info-sidebar a.active {
        border-left: none;
        border-bottom: 2px solid #277177;
    }
    
    .info-content {
        padding: 20px;
    }
}

/* Smooth Scrolling */
html {
    scroll-behavior: smooth;
}

/* Additional section styles */
#struktur-organisasi img {
    max-width: 100%;
    margin: 20px 0;
}

#prestasi ul {
    list-style-type: disc;
    margin-left: 20px;
    margin-bottom: 20px;
}

#kontak .contact-info {
    background-color: #f0f4f8;
    padding: 20px;
    border-radius: 8px;
    margin-top: 20px;
}

#kontak .contact-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

#kontak .contact-item i {
    margin-right: 15px;
    color: #277177;
    font-size: 20px;
}

/* Animation effects */
.info-content {
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Link styling within content */
.info-content a {
    color: #277177;
    text-decoration: none;
    border-bottom: 1px dotted #277177;
    transition: all 0.3s ease;
}

.info-content a:hover {
    color: #277177;
    border-bottom-color: #277177;
}

/* Tables within content (if needed) */
.info-content table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}

.info-content table th, 
.info-content table td {
    border: 1px solid #e0e0e0;
    padding: 12px;
    text-align: left;
}

.info-content table th {
    background-color: #f0f4f8;
    color: #277177;
}

.info-content table tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Blockquote styling */
.info-content blockquote {
    border-left: 4px solid #277177;
    padding-left: 20px;
    margin: 20px 0;
    color: #555;
    font-style: italic;
}
</style>
<body>
    <!-- Navigation -->
    @include('layout.navbar_pemeringkatan')
    
    <!-- Back Button -->
    <a href="{{ route('Pemeringkatan.ranking_unj.rankingunj') }}" class="back-button"> 
    <i class="fas fa-arrow-left"></i> Back to Rankings
    </a>
    <!-- Main Title Section -->
    <div class="page-title">
        Indikator Penilaian
    </div>
    
    <!-- Main Content -->
    <div class="info-section">
        <!-- Sidebar Navigation - Dynamically generated from database -->
        <div class="info-sidebar">
            <ul>
                @forelse ($indikators as $index => $indikator)
                    <li>
                        <a href="#indikator-{{ $indikator->id }}" class="{{ $index === 0 ? 'active' : '' }}">
                            {{ $indikator->judul }}
                        </a>
                    </li>
                @empty
                    <!-- Default items if no indikators exist -->
                    <li><a href="#default" class="active">Default</a></li>

                @endforelse
            </ul>
        </div>

        <!-- Content Area -->
        @if($indikators->isNotEmpty())
            <div class="info-content" id="indikator-{{ $indikators->first()->id }}">
                <h2>{{ $indikators->first()->judul }}</h2>
                <div class="ck-content">
                    {!! $indikators->first()->deskripsi !!}
                </div>
            </div>
        @else
            <div class="info-content" id="default">
                <h2>Default</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sed sapien quam. Sed dapibus est id enim facilisis, at posuere turpis adipiscing. Quisque sit amet dui dui. Duis rhoncus velit nec est condimentum feugiat. Donec aliquam augue nec gravida lobortis. Nunc arcu mi, pretium quis dolor id, iaculis euismod libero. Pellentesque ultricies ante eu velit vulputate, nec mattis justo suscipit.</p>
                <p>Curabitur mollis metus in nunc malesuada, vel placerat tellus vestibulum. Maecenas dignissim egestas lacus, ac elementum metus ultrices ac. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Nullam quis sapien a nulla venenatis ullamcorper. Suspendisse euismod, mauris non gravida placerat, ipsum velit sollicitudin ipsum.</p>
            </div>
        @endif
    </div>

    <!-- Spacer before footer -->
    @include('layout.footer')


    <!-- External JavaScript Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <!-- Smooth Scrolling Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a[href*="#"]');
            const indikators = @json($indikators);
            
            for (const link of links) {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    
                    // Only prevent default for in-page links
                    if (href.startsWith('#')) {
                        e.preventDefault();
                        
                        const targetId = this.getAttribute('href').substring(1);
                        const targetElement = document.getElementById(targetId);
                        
                        if (targetElement) {
                            targetElement.scrollIntoView({
                                behavior: 'smooth'
                            });
                        }
                        
                        // For sidebar navigation - toggle active class
                        if (this.closest('.info-sidebar')) {
                            const sidebarLinks = document.querySelectorAll('.info-sidebar a');
                            sidebarLinks.forEach(link => link.classList.remove('active'));
                            this.classList.add('active');
                            
                            // Update content based on clicked link
                            const contentArea = document.querySelector('.info-content');
                            contentArea.id = targetId;
                            
                            // If we have indikators (from database)
                            if (indikators.length > 0) {
                                // For database items
                                if (targetId.startsWith('indikator-')) {
                                    const indikatorId = parseInt(targetId.replace('indikator-', ''));
                                    const indikator = indikators.find(item => item.id === indikatorId);
                                    
                                    if (indikator) {
                                        contentArea.innerHTML = `<h2>${indikator.judul}</h2>${indikator.deskripsi}`;
                                    }
                                } else {
                                    // Default content for hardcoded items when database has entries
                                    const labelText = this.textContent.trim();
                                    contentArea.innerHTML = `<h2>${labelText}</h2><p>Informasi akan segera ditambahkan.</p>`;
                                }
                            } else {
                                // Default content when no database entries
                                const labelText = this.textContent.trim();
                                contentArea.innerHTML = `<h2>${labelText}</h2><p>Informasi akan segera ditambahkan.</p>`;
                            }
                        }
                    }
                });
            }
        });
    </script>

    <!-- Footer -->

</body>
</html>