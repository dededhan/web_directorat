document.addEventListener("DOMContentLoaded", function () {
    fetchDocuments();

    // Event listeners for navbar toggle
    document
        .getElementById("navbarToggle")
        .addEventListener("click", function () {
            const menu = document.getElementById("navbarMenu");
            if (menu) {
                menu.classList.toggle("active");

                // Change icon based on menu state
                const icon = this.querySelector("i");
                if (menu.classList.contains("active")) {
                    icon.classList.remove("fa-bars");
                    icon.classList.add("fa-times");
                } else {
                    icon.classList.remove("fa-times");
                    icon.classList.add("fa-bars");
                }
            }
        });

    // Handle search overlay
    if (document.getElementById("searchOverlay")) {
        document
            .getElementById("closeSearch")
            .addEventListener("click", function () {
                document.getElementById("searchOverlay").style.display = "none";
            });

        document
            .getElementById("searchOverlay")
            .addEventListener("click", function (e) {
                if (e.target === this) {
                    this.style.display = "none";
                }
            });
    }

    // Close mobile menu when window is resized above mobile breakpoint
    window.addEventListener("resize", function () {
        if (window.innerWidth > 992) {
            const navbarMenu = document.getElementById("navbarMenu");
            if (navbarMenu) {
                navbarMenu.classList.remove("active");
                const icon = document.querySelector(".navbar-toggle i");
                if (icon) {
                    icon.classList.remove("fa-times");
                    icon.classList.add("fa-bars");
                }
            }
        }
    });

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
            renderDocuments(documents);
        })
        .catch((error) => {
            console.error("Error fetching documents:", error);
            const documentGrid = document.getElementById("documentGrid");
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

    grid.innerHTML = "";

    if (filteredDocs.length === 0) {
        grid.innerHTML = `
            <div class="col-span-full flex flex-col items-center justify-center py-20">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-search text-gray-400 text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak Ada Dokumen Ditemukan</h3>
                <p class="text-gray-500 text-center max-w-md">Tidak ada dokumen yang sesuai dengan kriteria pencarian Anda. Silakan coba kata kunci atau kategori yang berbeda.</p>
            </div>
        `;
        return;
    }

    filteredDocs.forEach((doc) => {
        const card = document.createElement("div");
        card.className = "group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-primary-500 transform hover:-translate-y-2";
        card.dataset.category = doc.kategori;

        // Category colors
        const categoryColors = {
            umum: { bg: 'bg-blue-50', text: 'text-blue-600', icon: 'fa-file-alt' },
            pemeringkatan: { bg: 'bg-green-50', text: 'text-green-600', icon: 'fa-trophy' },
            inovasi: { bg: 'bg-orange-50', text: 'text-orange-600', icon: 'fa-lightbulb' }
        };
        
        const categoryStyle = categoryColors[doc.kategori] || categoryColors.umum;

        card.innerHTML = `
            <div class="p-6 flex flex-col h-full">
                <!-- Document Icon -->
                <div class="mb-5 flex items-start justify-between">
                    <div class="w-16 h-16 ${categoryStyle.bg} rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas ${categoryStyle.icon} ${categoryStyle.text} text-2xl"></i>
                    </div>
                    <span class="px-3 py-1 ${categoryStyle.bg} ${categoryStyle.text} text-xs font-semibold rounded-full">
                        ${getCategoryLabel(doc.kategori)}
                    </span>
                </div>
                
                <!-- Document Title -->
                <h3 class="text-lg font-bold text-gray-800 mb-4 line-clamp-2 group-hover:text-primary-600 transition-colors min-h-[3.5rem]">
                    ${doc.judul_dokumen}
                </h3>
                
                <!-- Document Meta Info -->
                <div class="space-y-2 mb-6 flex-grow">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-calendar-alt w-5 text-gray-400"></i>
                        <span class="ml-2">${formatDate(doc.tanggal_publikasi)}</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-file-pdf w-5 text-red-500"></i>
                        <span class="ml-2">${formatFileSize(doc.ukuran)}</span>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="grid grid-cols-2 gap-3 mt-auto">
                    <a href="/documents/preview/${doc.id}" 
                       class="flex items-center justify-center gap-2 px-4 py-2.5 bg-primary-500 text-white rounded-lg font-semibold text-sm hover:bg-primary-600 transition-all duration-300 hover:shadow-lg" 
                       target="_blank">
                        <i class="fas fa-eye"></i>
                        <span>Lihat</span>
                    </a>
                    <a href="/documents/download/${doc.id}" 
                       class="flex items-center justify-center gap-2 px-4 py-2.5 bg-white border-2 border-primary-500 text-primary-500 rounded-lg font-semibold text-sm hover:bg-primary-50 transition-all duration-300">
                        <i class="fas fa-download"></i>
                        <span>Unduh</span>
                    </a>
                </div>
            </div>
        `;
        grid.appendChild(card);
    });
}

// Function to filter documents by category
function filterDocuments(category, buttonElement) {
    // Update active button state
    const categoryBtns = document.querySelectorAll(".category-btn");
    if (categoryBtns) {
        categoryBtns.forEach((btn) => {
            btn.classList.remove("active");
        });

        if (buttonElement) {
            buttonElement.classList.add("active");
        } else {
            const categoryButton = document.querySelector(
                `[data-category="${category}"]`
            );
            if (categoryButton) {
                categoryButton.classList.add("active");
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
