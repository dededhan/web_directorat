<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumen</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('document.css') }}">        
</head>
<body>
     <!-- Main Navbar -->
     <div class="navbar-wrapper">
        <div class="container main-navbar">
            <a href="#" class="navbar-logo">
                <img src="https://spm.unj.ac.id/wp-content/uploads/2024/08/cropped-Logo-UNJ-PTNBH-RGB_Logo_Motto_Transparan.png" alt="Logo UNJ">
                <div class="navbar-logo-text">
                    <span class="logo-title">DOKUMEN</span>
                    <span class="logo-subtitle">Universitas Negeri Jakarta</span>
                </div>
            </a>
            
            <button class="navbar-toggle" id="navbarToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <ul class="navbar-menu" id="navbarMenu">
                <li><a href="{{ route('home') }}" class="menu-link">Home</a></li>
                <li><a href="#" class="menu-link active">Dokumen</a></li>
            </ul>
        </div>
    </div>

   <!-- Search Overlay -->
   <div class="search-overlay" id="searchOverlay">
        <button class="close-search" id="closeSearch">&times;</button>
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Search...">
            <button class="search-btn">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
    
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Document Repository Section -->
        <div class="container">
            <div class="section-header">
                
            </div>
            
            <div class="document-container">
                <div class="search-bar">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" id="searchInput" placeholder="Search for documents..." oninput="searchDocuments()">
                </div>

                <div class="document-categories">
                    <button class="category-btn active" data-type="all" onclick="filterDocuments('all', this)">
                        <i class="fas fa-folder-open"></i> All Documents
                    </button>
                    <button class="category-btn" data-type="pdf" onclick="filterDocuments('pdf', this)">
                        <i class="fas fa-file-pdf"></i> PDF Documents
                    </button>
                    <button class="category-btn" data-type="docx" onclick="filterDocuments('docx', this)">
                        <i class="fas fa-file-word"></i> Word Documents
                    </button>
                </div>

                <div id="documentGrid" class="document-grid">
                    <!-- Documents will be populated dynamically with JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Document Preview Modal -->
    <div id="documentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalTitle">Document Preview</h3>
                <span class="modal-close" onclick="closeModal()">&times;</span>
            </div>
            <div id="modalContent" class="document-viewer"></div>
        </div>
    </div>
    <div class="footer-wrapper">
    @include('document.documentfooter')
</div>

    <script>
        // Toggle mobile menu
        document.getElementById('navbarToggle').addEventListener('click', function() {
            const menu = document.getElementById('navbarMenu');
            menu.classList.toggle('active');
            
            // Change icon based on menu state
            const icon = this.querySelector('i');
            if (menu.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });

        // Close search overlay
        document.getElementById('closeSearch').addEventListener('click', function() {
            document.getElementById('searchOverlay').style.display = 'none';
        });

        // Close search overlay when clicking outside the search box
        document.getElementById('searchOverlay').addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
            }
        });

        // Close mobile menu when window is resized above mobile breakpoint
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                document.getElementById('navbarMenu').classList.remove('active');
                const icon = document.querySelector('.navbar-toggle i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });

        // Document Repository Functionality
        // Load documents from database instead of hard-coded array
        const documents = [
            @foreach($dokumens as $dokumen)
            {
                id: {{ $dokumen->id }},
                type: '{{ $dokumen->kategori }}',
                name: '{{ $dokumen->judul_dokumen }}',
                icon: '{{ $dokumen->kategori === "pdf" ? "file-pdf" : "file-word" }}',
                path: '{{ route("admin.document.download", $dokumen->id) }}',
                date: '{{ $dokumen->tanggal_publikasi }}',
                size: '{{ 
                    $dokumen->ukuran > 1000000 
                    ? number_format($dokumen->ukuran / 1048576, 1) . " MB" 
                    : number_format($dokumen->ukuran / 1024, 0) . " KB" 
                }}'
            }{{ !$loop->last ? ',' : '' }}
            @endforeach
        ];

        // Format date for display
        function formatDate(dateString) {
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return new Date(dateString).toLocaleDateString(undefined, options);
        }

        // Render documents with enhanced layout
        function renderDocuments(filteredDocs = documents) {
            const grid = document.getElementById('documentGrid');
            grid.innerHTML = '';

            if (filteredDocs.length === 0) {
                grid.innerHTML = `
                    <div class="empty-results">
                        <i class="fas fa-search"></i>
                        <p>No documents found matching your search criteria. Please try a different search term or category.</p>
                    </div>
                `;
                return;
            }

            filteredDocs.forEach(doc => {
                const card = document.createElement('div');
                card.className = 'document-card';
                card.innerHTML = `
                    <div class="document-card-icon">
                        <i class="fas fa-${doc.icon}"></i>
                    </div>
                    <div class="document-card-title">${doc.name}</div>
                    <div class="document-card-meta">
                        <span><i class="fas fa-calendar-alt"></i> ${formatDate(doc.date)}</span>
                        <span><i class="fas fa-weight-hanging"></i> ${doc.size}</span>
                    </div>
                    <div class="document-card-actions">
                        <button class="action-btn view-btn" onclick="viewDocument('${doc.path}', '${doc.name}')">
                            <i class="fas fa-eye"></i> View
                        </button>
                        <a href="${doc.path}" class="action-btn download-btn" download>
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                `;
                grid.appendChild(card);
            });
        }

        // Filter documents by type with active button state
        function filterDocuments(type, buttonElement) {
            // Update active button state
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            if (buttonElement) {
                buttonElement.classList.add('active');
            } else {
                document.querySelector(`[data-type="${type}"]`).classList.add('active');
            }

            // Apply search filter alongside type filter
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            
            let filtered = documents;
            
            // Apply type filter
            if (type !== 'all') {
                filtered = filtered.filter(doc => doc.type === type);
            }
            
            // Apply search filter
            if (searchTerm) {
                filtered = filtered.filter(doc => 
                    doc.name.toLowerCase().includes(searchTerm)
                );
            }
            
            renderDocuments(filtered);
        }

        // Search functionality
        function searchDocuments() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const activeType = document.querySelector('.category-btn.active').getAttribute('data-type');
            
            let filtered = documents;
            
            // Apply type filter if not 'all'
            if (activeType !== 'all') {
                filtered = filtered.filter(doc => doc.type === activeType);
            }
            
            // Apply search filter
            if (searchTerm) {
                filtered = filtered.filter(doc => 
                    doc.name.toLowerCase().includes(searchTerm)
                );
            }
            
            renderDocuments(filtered);
        }

        // View document in modal 
        function viewDocument(path, name) {
            const modal = document.getElementById('documentModal');
            const modalContent = document.getElementById('modalContent');
            const modalTitle = document.getElementById('modalTitle');
            
            modalTitle.textContent = name;
            
            modalContent.innerHTML = `
                <iframe src="${path}" width="100%" height="500px" frameborder="0">
                    <p>Your browser does not support iframes.</p>
                </iframe>
            `;
            
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        // Modal control functions
        function closeModal() {
            document.getElementById('documentModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Close modal if clicked outside
        window.onclick = function(event) {
            const modal = document.getElementById('documentModal');
            if (event.target == modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        // Keyboard accessibility for modal
        window.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        // Initial render
        renderDocuments();
    </script>
</body>
</html>