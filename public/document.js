

// Toggle mo    ile menu
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

// Close search overlay when clicking outside the search box
if (document.getElementById('searchOverlay')) {
    document.getElementById('closeSearch').addEventListener('click', function() {
        document.getElementById('searchOverlay').style.display = 'none';
    });

    document.getElementById('searchOverlay').addEventListener('click', function(e) {
        if (e.target === this) {
            this.style.display = 'none';
        }
    });
}

// Close mobile menu when window is resized above mobile breakpoint
window.addEventListener('resize', function() {
    if (window.innerWidth > 992) {
        const navbarMenu = document.getElementById('navbarMenu');
        if (navbarMenu) {
            navbarMenu.classList.remove('active');
            const icon = document.querySelector('.navbar-toggle i');
            if (icon) {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        }
    }
});

// Fetch documents from the server
let documents = [];

// Fetch documents using AJAX
fetch('/api/documents')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        documents = data;
        renderDocuments(documents);
    })
    .catch(error => {
        console.error('Error fetching documents:', error);
        const documentGrid = document.getElementById('documentGrid');
        if (documentGrid) {
            documentGrid.innerHTML = `
                <div class="empty-results">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>Failed to load documents. Please try refreshing the page.</p>
                </div>
            `;
        }
    });

// Format date for display
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
}

// Format file size for display
function formatFileSize(bytes) {
    if (bytes >= 1000000) {
        return (bytes / 1048576).toFixed(1) + ' MB';
    }
    return Math.round(bytes / 1024) + ' KB';
}

// Render documents with enhanced layout
function renderDocuments(filteredDocs = documents) {
    const grid = document.getElementById('documentGrid');
    if (!grid) return;
    
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
        
        // Determine icon based on file extension
        const icon = doc.kategori === 'pdf' ? 'file-pdf' : 'file-word';
        const iconColor = doc.kategori === 'pdf' ? 'text-red-600' : 'text-blue-600';
        
        // Sanitize document title for use in onclick attribute
        const safeTitle = doc.judul_dokumen.replace(/"/g, '&quot;').replace(/'/g, "&#39;");
        
        card.innerHTML = `
            <div class="document-card-icon">
                <i class="fas fa-${icon} ${iconColor}"></i>
            </div>
            <div class="document-card-title">${doc.judul_dokumen}</div>
            <div class="document-card-meta">
                <span><i class="fas fa-calendar-alt"></i> ${formatDate(doc.tanggal_publikasi)}</span>
                <span><i class="fas fa-weight-hanging"></i> ${formatFileSize(doc.ukuran)}</span>
            </div>
            <div class="document-card-actions">
                <button class="action-btn view-btn" onclick="viewDocument(${doc.id})">
                    <i class="fas fa-eye"></i> View
                </button>
                <button class="action-btn download-btn" onclick="downloadDocument(${doc.id})">
                    <i class="fas fa-download"></i> Download
                </button>
            </div>
        `;
        grid.appendChild(card);
    });
}

// Filter documents by type with active button state
function filterDocuments(type, buttonElement) {
    // Update active button state
    const categoryBtns = document.querySelectorAll('.category-btn');
    if (categoryBtns) {
        categoryBtns.forEach(btn => {
            btn.classList.remove('active');
        });
        
        if (buttonElement) {
            buttonElement.classList.add('active');
        } else {
            const typeButton = document.querySelector(`[data-type="${type}"]`);
            if (typeButton) {
                typeButton.classList.add('active');
            }
        }
    }

    // Apply search filter alongside type filter
    const searchInput = document.getElementById('searchInput');
    const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
    
    let filtered = documents;
    
    // Apply type filter
    if (type !== 'all') {
        filtered = filtered.filter(doc => doc.kategori === type);
    }
    
    // Apply search filter
    if (searchTerm) {
        filtered = filtered.filter(doc => 
            doc.judul_dokumen.toLowerCase().includes(searchTerm)
        );
    }
    
    renderDocuments(filtered);
}

// Search functionality
function searchDocuments() {
    const searchInput = document.getElementById('searchInput');
    if (!searchInput) return;
    
    const searchTerm = searchInput.value.toLowerCase();
    const activeTypeElement = document.querySelector('.category-btn.active');
    
    if (!activeTypeElement) {
        renderDocuments(
            documents.filter(doc => doc.judul_dokumen.toLowerCase().includes(searchTerm))
        );
        return;
    }
    
    const activeType = activeTypeElement.getAttribute('data-type');
    
    let filtered = documents;
    
    // Apply type filter if not 'all'
    if (activeType !== 'all') {
        filtered = filtered.filter(doc => doc.kategori === activeType);
    }
    
    // Apply search filter
    if (searchTerm) {
        filtered = filtered.filter(doc => 
            doc.judul_dokumen.toLowerCase().includes(searchTerm)
        );
    }
    
    renderDocuments(filtered);
}

// Pastikan kode ini dijalankan setelah DOM selesai dimuat
// Handle edit document button clicks


// View document in preview page
function viewDocument(id) {
    window.location.href = `/documents/preview/${id}`;
}

// Download document
function downloadDocument(id) {
    window.location.href = `/documents/download/${id}`;
}