document.addEventListener('DOMContentLoaded', function() {
    fetchDocuments();
    
    // Event listeners for navbar toggle
    document.getElementById('navbarToggle').addEventListener('click', function() {
        const menu = document.getElementById('navbarMenu');
        if (menu) {
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
        }
    });

    // Handle search overlay
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
});

// Global documents array
let documents = [];

// Function to fetch documents from the server
function fetchDocuments() {
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
}

// Format date for display
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
}

// Format file size for display
function formatFileSize(bytes) {
    if (bytes >= 1000000) {
        return (bytes / 1048576).toFixed(1) + ' MB';
    }
    return Math.round(bytes / 1024) + ' KB';
}

// Get category label with proper formatting
function getCategoryLabel(category) {
    const labels = {
        'umum': 'Umum',
        'pemeringkatan': 'Pemeringkatan',
        'inovasi': 'Inovasi'
    };
    
    return labels[category] || category;
}

// Function to render documents in the grid
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
        card.dataset.category = doc.kategori;
        
        // All documents now use PDF icon
        const icon = 'file-pdf';
        const iconColor = 'text-red-600';
        
        card.innerHTML = `
            <div class="document-card-icon">
                <i class="fas fa-${icon} ${iconColor}"></i>
            </div>
            <div class="document-card-title">${doc.judul_dokumen}</div>
            <div class="document-card-meta">
                <span><i class="fas fa-calendar-alt"></i> ${formatDate(doc.tanggal_publikasi)}</span>
                <span><i class="fas fa-weight-hanging"></i> ${formatFileSize(doc.ukuran)}</span>
                <span><i class="fas fa-folder"></i> ${getCategoryLabel(doc.kategori)}</span>
            </div>
            <div class="document-card-actions">
                <a href="/documents/preview/${doc.id}" class="action-btn view-btn" target="_blank">
                    <i class="fas fa-eye"></i> View
                </a>
                <a href="/documents/download/${doc.id}" class="action-btn download-btn">
                    <i class="fas fa-download"></i> Download
                </a>
            </div>
        `;
        grid.appendChild(card);
    });
}

// Function to filter documents by category
function filterDocuments(category, buttonElement) {
    // Update active button state
    const categoryBtns = document.querySelectorAll('.category-btn');
    if (categoryBtns) {
        categoryBtns.forEach(btn => {
            btn.classList.remove('active');
        });
        
        if (buttonElement) {
            buttonElement.classList.add('active');
        } else {
            const categoryButton = document.querySelector(`[data-category="${category}"]`);
            if (categoryButton) {
                categoryButton.classList.add('active');
            }
        }
    }

    // Apply search filter alongside category filter
    const searchInput = document.getElementById('searchInput');
    const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
    
    let filtered = documents;
    
    // Apply category filter
    if (category !== 'all') {
        filtered = filtered.filter(doc => doc.kategori === category);
    }
    
    // Apply search filter
    if (searchTerm) {
        filtered = filtered.filter(doc => 
            doc.judul_dokumen.toLowerCase().includes(searchTerm)
        );
    }
    
    renderDocuments(filtered);
}

// Function to search documents
function searchDocuments() {
    const searchInput = document.getElementById('searchInput');
    if (!searchInput) return;
    
    const searchTerm = searchInput.value.toLowerCase();
    const activeCategory = document.querySelector('.category-btn.active')?.dataset.category || 'all';
    
    let filtered = documents;
    
    // Apply category filter if not 'all'
    if (activeCategory !== 'all') {
        filtered = filtered.filter(doc => doc.kategori === activeCategory);
    }
    
    // Apply search filter
    if (searchTerm) {
        filtered = filtered.filter(doc => 
            doc.judul_dokumen.toLowerCase().includes(searchTerm)
        );
    }
    
    renderDocuments(filtered);
}

// View document in preview page
function viewDocument(id) {
    window.location.href = `/documents/preview/${id}`;
}

// Download document
function downloadDocument(id) {
    window.location.href = `/documents/download/${id}`;
}