document.addEventListener("DOMContentLoaded", function () {
    fetchDocuments();

    // Category filter buttons
    document.querySelectorAll(".category-btn").forEach((button) => {
        button.addEventListener("click", function () {
            const category = this.dataset.category;
            filterDocuments(category, this);
        });
    });
});

// Global documents array
let documents = [];

// Function to fetch documents from the server
function fetchDocuments() {
    fetch("/api/documents")
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((data) => {
            documents = data;
            updateDocumentCounter(documents.length);
            renderDocuments(documents);
        })
        .catch((error) => {
            console.error("Error fetching documents:", error);
            const documentGrid = document.getElementById("documentGrid");
            if (documentGrid) {
                documentGrid.innerHTML = `
                    <div class="col-span-full flex flex-col items-center justify-center py-24">
                        <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-exclamation-triangle text-red-500 text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Gagal Memuat Dokumen</h3>
                        <p class="text-gray-500 text-center max-w-md mb-4">Terjadi kesalahan saat mengambil data. Silakan refresh halaman.</p>
                        <button onclick="location.reload()" class="px-6 py-2.5 bg-primary-600 text-white rounded-lg font-semibold hover:bg-primary-700 transition-colors">
                            <i class="fas fa-sync-alt mr-2"></i>Refresh Halaman
                        </button>
                    </div>
                `;
            }
        });
}

// Function to update document counter
function updateDocumentCounter(count) {
    const counterElement = document.getElementById("totalDocs");
    if (counterElement) {
        // Animate counter
        let current = 0;
        const increment = count / 30;
        const timer = setInterval(() => {
            current += increment;
            if (current >= count) {
                counterElement.textContent = count;
                clearInterval(timer);
            } else {
                counterElement.textContent = Math.floor(current);
            }
        }, 20);
    }
}

// Format date for display
function formatDate(dateString) {
    const options = { year: "numeric", month: "short", day: "numeric" };
    return new Date(dateString).toLocaleDateString("id-ID", options);
}

// Format file size for display
function formatFileSize(bytes) {
    if (bytes >= 1000000) {
        return (bytes / 1048576).toFixed(1) + " MB";
    }
    return Math.round(bytes / 1024) + " KB";
}

// Get category label with proper formatting
function getCategoryLabel(category) {
    const labels = {
        umum: "Umum",
        pemeringkatan: "Pemeringkatan",
        inovasi: "Inovasi",
    };

    return labels[category] || category;
}

// Function to render documents in the grid
function renderDocuments(filteredDocs = documents) {
    const grid = document.getElementById("documentGrid");
    if (!grid) return;

    // Add fade out effect
    grid.style.opacity = "0";
    
    setTimeout(() => {
        grid.innerHTML = "";

        if (filteredDocs.length === 0) {
            grid.innerHTML = `
                <div class="col-span-full flex flex-col items-center justify-center py-24 animate-fade-in">
                    <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6 shadow-inner">
                        <i class="fas fa-search text-gray-400 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-3">Tidak Ada Dokumen Ditemukan</h3>
                    <p class="text-gray-500 text-center max-w-md leading-relaxed">Tidak ada dokumen yang sesuai dengan kriteria pencarian Anda. Silakan coba kata kunci atau kategori yang berbeda.</p>
                </div>
            `;
            grid.style.opacity = "1";
            return;
        }

        filteredDocs.forEach((doc, index) => {
            const card = document.createElement("div");
            card.className = "group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-primary-500 transform hover:-translate-y-2 animate-scale-in";
            card.style.animationDelay = `${index * 0.05}s`;
            card.dataset.category = doc.kategori;

            // Category colors dengan gradient modern
            const categoryColors = {
                umum: { 
                    bg: 'bg-gradient-to-br from-blue-50 to-blue-100', 
                    text: 'text-blue-600', 
                    icon: 'fa-file-alt',
                    badge: 'bg-blue-100 text-blue-700 border-blue-200'
                },
                pemeringkatan: { 
                    bg: 'bg-gradient-to-br from-green-50 to-green-100', 
                    text: 'text-green-600', 
                    icon: 'fa-trophy',
                    badge: 'bg-green-100 text-green-700 border-green-200'
                },
                inovasi: { 
                    bg: 'bg-gradient-to-br from-orange-50 to-orange-100', 
                    text: 'text-orange-600', 
                    icon: 'fa-lightbulb',
                    badge: 'bg-orange-100 text-orange-700 border-orange-200'
                }
            };
            
            const categoryStyle = categoryColors[doc.kategori] || categoryColors.umum;

            card.innerHTML = `
                <div class="p-6 flex flex-col h-full">
                    <!-- Document Icon & Category Badge -->
                    <div class="mb-5 flex items-start justify-between">
                        <div class="w-16 h-16 ${categoryStyle.bg} rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-sm">
                            <i class="fas ${categoryStyle.icon} ${categoryStyle.text} text-2xl"></i>
                        </div>
                        <span class="px-3 py-1.5 ${categoryStyle.badge} text-xs font-bold rounded-full border shadow-sm">
                            ${getCategoryLabel(doc.kategori)}
                        </span>
                    </div>
                    
                    <!-- Document Title -->
                    <h3 class="text-lg font-bold text-gray-800 mb-4 line-clamp-2 group-hover:text-primary-600 transition-colors min-h-[3.5rem] leading-snug">
                        ${doc.judul_dokumen}
                    </h3>
                    
                    <!-- Document Meta Info -->
                    <div class="space-y-2.5 mb-6 flex-grow">
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center mr-2.5">
                                <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                            </div>
                            <span class="font-medium">${formatDate(doc.tanggal_publikasi)}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center mr-2.5">
                                <i class="fas fa-file-pdf text-red-500 text-xs"></i>
                            </div>
                            <span class="font-medium">${formatFileSize(doc.ukuran)}</span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="grid grid-cols-2 gap-3 mt-auto">
                        <a href="/documents/preview/${doc.id}" 
                           class="flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-primary-600 to-primary-500 text-white rounded-xl font-semibold text-sm hover:from-primary-700 hover:to-primary-600 transition-all duration-300 hover:shadow-lg transform hover:scale-105" 
                           target="_blank">
                            <i class="fas fa-eye"></i>
                            <span>Lihat</span>
                        </a>
                        <a href="/documents/download/${doc.id}" 
                           class="flex items-center justify-center gap-2 px-4 py-3 bg-white border-2 border-primary-500 text-primary-600 rounded-xl font-semibold text-sm hover:bg-primary-50 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-download"></i>
                            <span>Unduh</span>
                        </a>
                    </div>
                </div>
            `;
            grid.appendChild(card);
        });

        // Fade in effect
        grid.style.opacity = "1";
    }, 150);
}

// Function to filter documents by category
function filterDocuments(category, buttonElement) {
    // Update active button state dengan styling modern
    const categoryBtns = document.querySelectorAll(".category-btn");
    if (categoryBtns) {
        categoryBtns.forEach((btn) => {
            // Reset ke style default
            if (btn.dataset.category === 'all') {
                btn.className = "category-btn group relative flex items-center gap-2.5 px-6 sm:px-7 py-3.5 rounded-xl font-semibold text-sm sm:text-base transition-all duration-300 bg-white text-gray-700 shadow-md hover:shadow-xl border-2 border-transparent transform hover:-translate-y-1";
            } else {
                const categoryColors = {
                    'umum': 'hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:border-blue-200',
                    'pemeringkatan': 'hover:bg-gradient-to-r hover:from-green-50 hover:to-green-100 hover:border-green-200',
                    'inovasi': 'hover:bg-gradient-to-r hover:from-orange-50 hover:to-orange-100 hover:border-orange-200'
                };
                const hoverColor = categoryColors[btn.dataset.category] || '';
                btn.className = `category-btn group relative flex items-center gap-2.5 px-6 sm:px-7 py-3.5 rounded-xl font-semibold text-sm sm:text-base transition-all duration-300 bg-white text-gray-700 shadow-md hover:shadow-xl ${hoverColor} border-2 border-transparent transform hover:-translate-y-1`;
            }
        });

        if (buttonElement) {
            // Set active state dengan styling menarik
            if (category === 'all') {
                buttonElement.className = "category-btn group relative flex items-center gap-2.5 px-6 sm:px-7 py-3.5 rounded-xl font-semibold text-sm sm:text-base transition-all duration-300 bg-primary-600 text-white shadow-lg hover:shadow-2xl hover:bg-primary-700 transform hover:-translate-y-1 hover:scale-105 active";
            } else {
                const activeColors = {
                    'umum': 'bg-blue-600 text-white hover:bg-blue-700',
                    'pemeringkatan': 'bg-green-600 text-white hover:bg-green-700',
                    'inovasi': 'bg-orange-600 text-white hover:bg-orange-700'
                };
                const activeColor = activeColors[category] || 'bg-primary-600 text-white hover:bg-primary-700';
                buttonElement.className = `category-btn group relative flex items-center gap-2.5 px-6 sm:px-7 py-3.5 rounded-xl font-semibold text-sm sm:text-base transition-all duration-300 ${activeColor} shadow-lg hover:shadow-2xl border-2 border-transparent transform hover:-translate-y-1 hover:scale-105 active`;
            }
        }
    }

    // Apply search filter alongside category filter
    const searchInput = document.getElementById("searchInput");
    const searchTerm = searchInput ? searchInput.value.toLowerCase() : "";

    let filtered = documents;

    // Apply category filter
    if (category !== "all") {
        filtered = filtered.filter((doc) => doc.kategori === category);
    }

    // Apply search filter
    if (searchTerm) {
        filtered = filtered.filter((doc) =>
            doc.judul_dokumen.toLowerCase().includes(searchTerm)
        );
    }

    renderDocuments(filtered);
}

// Function to search documents
function searchDocuments() {
    const searchInput = document.getElementById("searchInput");
    if (!searchInput) return;

    const searchTerm = searchInput.value.toLowerCase();
    const activeCategory =
        document.querySelector(".category-btn.active")?.dataset.category ||
        "all";

    let filtered = documents;

    // Apply category filter if not 'all'
    if (activeCategory !== "all") {
        filtered = filtered.filter((doc) => doc.kategori === activeCategory);
    }

    // Apply search filter
    if (searchTerm) {
        filtered = filtered.filter((doc) =>
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

window.filterDocuments = filterDocuments;
window.searchDocuments = searchDocuments;
window.viewDocument = viewDocument;
window.downloadDocument = downloadDocument;
