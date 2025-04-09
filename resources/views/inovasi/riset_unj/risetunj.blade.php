<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Innovation Database</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        .header {
            background: linear-gradient(to right, #3490dc, #6574cd);
            color: white;
            padding: 2rem;
        }
        .navbar {
            background-color: #277177;
            color: white;
        }
        .nav-link {
            transition: all 0.2s ease;
        }
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .active-nav {
            border-bottom: 3px solid white;
        }
        .table-container {
            max-height: 600px;
            overflow-y: auto;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        table th {
            position: sticky;
            top: 0;
            background-color: #f8fafc;
            z-index: 10;
        }
        .search-bar {
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .chart-container {
            height: 400px;
            margin-bottom: 2rem;
        }
        .faculty-pill {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .year-pill {
            padding: 0.15rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 500;
            background-color: #e2e8f0;
        }
        .file-upload {
            cursor: pointer;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s;
        }
        .file-upload:hover {
            background-color: #2d3748;
        }
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .pagination-button {
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            margin: 0 0.25rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .pagination-button:hover {
            background-color: #4299e1;
            color: white;
        }
        .pagination-button.active {
            background-color: #3182ce;
            color: white;
        }
        .pagination-button.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation Bar -->
    <nav class="navbar sticky top-0 z-50 shadow-md">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-3">
                <div class="flex items-center">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/46/Lambang_baru_UNJ.png/960px-Lambang_baru_UNJ.png" alt="Riset UNJ Logo" class="h-8 w-auto mr-2">
                    <span class="font-bold text-xl">Riset UNJ</span>
                </div>
                <div class="hidden md:flex space-x-1">
                <a href="{{ route('inovasi.landingpage') }}" class="nav-link px-4 py-2 rounded font-medium">Home</a>
                    <a href="#" class="nav-link active-nav px-4 py-2 rounded font-medium">Dashboard</a>                  
                </div>
                <div class="md:hidden">
                    <button id="mobileMenuButton" class="p-2 rounded-md hover:bg-teal-600 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Mobile Menu -->
            <div id="mobileMenu" class="md:hidden hidden pb-3">
                <a href="#" class="nav-link block px-4 py-2 rounded font-medium">Dashboard</a>
                <a href="#" class="nav-link block px-4 py-2 rounded font-medium">Products</a>
                <a href="#" class="nav-link block px-4 py-2 rounded font-medium">Researchers</a>
                <a href="#" class="nav-link block px-4 py-2 rounded font-medium">Analytics</a>
                <a href="#" class="nav-link block px-4 py-2 rounded font-medium">About</a>
            </div>
        </div>
    </nav>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto"></div>
            <p class="mt-4 text-gray-700">Processing your data, please wait...</p>
        </div>
    </div>


    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Data Source Info Area -->
        {{-- <div class="bg-white p-6 rounded-lg shadow-sm mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold">Data Source: <span class="text-blue-600">product_innovations.xlsx</span></h2>
                    <p class="text-gray-600 mt-1">Data is loaded automatically from local Excel file</p>
                </div>
                <div>
                    <span id="dataStatus" class="px-4 py-2 bg-gray-100 rounded-full text-sm">Loading...</span>
                </div>
            </div>
        </div> --}}

        <!-- Search and Filters -->
        <div class="bg-white p-6 rounded-lg shadow-sm mb-8">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-grow">
                    <input id="searchInput" type="text" placeholder="Search by product name, researcher, faculty or source..." 
                           class="search-bar w-full p-3 border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>
                <div class="flex gap-2">
                    <select id="facultyFilter" class="p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        <option value="">All Faculties</option>
                    </select>
                    <select id="yearFilter" class="p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        <option value="">All Years</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Faculty Distribution Chart -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h2 class="text-xl font-semibold mb-4">Innovations by Faculty</h2>
                <div class="chart-container">
                    <canvas id="facultyChart"></canvas>
                </div>
            </div>
            
            <!-- Source Distribution Chart -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h2 class="text-xl font-semibold mb-4">Innovations by Source</h2>
                <div class="chart-container">
                    <canvas id="sourceChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold">Innovation Products</h2>
                <p id="resultCount" class="text-gray-500 mt-1">No data loaded yet</p>
            </div>
            <div class="table-container">
                <table id="dataTable" class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NO</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NAMA PRODUK</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NAMA DOSEN / PENELITI</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">FAKULTAS</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TAHUN</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SUMBER</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No data loaded. Please upload an Excel file.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="p-4 border-t flex justify-between items-center">
                <div>
                    <span id="paginationInfo" class="text-sm text-gray-600">Showing 0-0 of 0 items</span>
                </div>
                <div class="flex" id="paginationControls">
                    <button id="prevPageBtn" class="pagination-button disabled">Previous</button>
                    <div id="pageButtons" class="flex">
                        <!-- Page buttons will be inserted here -->
                    </div>
                    <button id="nextPageBtn" class="pagination-button disabled">Next</button>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    @include('Inovasi.riset_unj.footerrisetunj')

    <script>
        // Mobile menu toggle functionality
        document.getElementById('mobileMenuButton').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('hidden');
        });

        // Define faculty colors for consistent visualization
        const facultyColors = {
            'FT': '#3490dc',
            'FMIPA': '#f6ad55',
            'FIP': '#9f7aea',
            'FIK': '#38b2ac',
            'FE': '#ed64a6',
            'FBS': '#667eea',
            'FIS': '#48bb78',
            'FPPsi': '#fc8181',
            'Pascasarjana': '#4fd1c5',
            'LPPM': '#805ad5',
            'PUIPT': '#dd6b20',
            'PUPT': '#ecc94b'
        };

        // Global variables
        let productData = [];
        let filteredData = [];
        let facultyChart = null;
        let sourceChart = null;
        
        // Pagination variables
        let currentPage = 1;
        const itemsPerPage = 10;
        
        // Elements
        const dataStatus = document.getElementById('dataStatus');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const prevPageBtn = document.getElementById('prevPageBtn');
        const nextPageBtn = document.getElementById('nextPageBtn');
        const pageButtons = document.getElementById('pageButtons');
        const paginationInfo = document.getElementById('paginationInfo');

        // Function to get a consistent color for a faculty
        function getFacultyColor(faculty) {
            return facultyColors[faculty] || '#a0aec0'; // Default color
        }

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            // Load the Excel file data immediately
            loadLocalExcelFile();
            
            // Set up search functionality with debounce
            const searchInput = document.getElementById('searchInput');
            let searchTimeout = null;
            
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    applyFilters();
                }, 300); // 300ms debounce
            });
            
            // Set up filter listeners
            document.getElementById('facultyFilter').addEventListener('change', () => applyFilters());
            document.getElementById('yearFilter').addEventListener('change', () => applyFilters());
            
            // Set up pagination listeners
            prevPageBtn.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    updateTable();
                }
            });
            
            nextPageBtn.addEventListener('click', () => {
                const totalPages = Math.ceil(filteredData.length / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    updateTable();
                }
            });
        });

        // Load the Excel file from a local path
        function loadLocalExcelFile() {
            // Show loading overlay
            loadingOverlay.style.display = 'flex';
            dataStatus.textContent = 'Loading...';
            
            // Define the path to your local Excel file
            const excelFilePath = '/data/product_innovations.xlsx';
            
            // Fetch the file using AJAX
            fetch(excelFilePath)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Failed to load file: ${response.status} ${response.statusText}`);
                    }
                    return response.arrayBuffer();
                })
                .then(arrayBuffer => {
                    // Use SheetJS to parse the Excel file
                    const data = new Uint8Array(arrayBuffer);
                    const workbook = XLSX.read(data, { type: 'array', cellDates: true });
                    
                    // Get the first sheet
                    const firstSheetName = workbook.SheetNames[0];
                    const worksheet = workbook.Sheets[firstSheetName];
                    
                    // Convert to JSON
                    const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 'A' });
                    
                    // Process the data
                    processExcelData(jsonData);
                    
                    // Update status
                    dataStatus.textContent = 'Data loaded successfully';
                    dataStatus.classList.remove('bg-gray-100');
                    dataStatus.classList.add('bg-green-100', 'text-green-800');
                })
                .catch(error => {
                    console.error('Error loading Excel file:', error);
                    dataStatus.textContent = 'Error loading data';
                    dataStatus.classList.remove('bg-gray-100');
                    dataStatus.classList.add('bg-red-100', 'text-red-800');
                    
                    // Display fallback data
                    loadFallbackData();
                })
                .finally(() => {
                    // Hide loading overlay
                    loadingOverlay.style.display = 'none';
                });
        }
        
        // Load fallback data if Excel file loading fails
        function loadFallbackData() {
            // Use the hardcoded data from the original implementation
            const fallbackData = [
                {
                    "no": "1",
                    "productName": "Bio Taris (Tata Rias Makeup)",
                    "researcher": "Titin Supiani, S.Pd., M.Pd.",
                    "faculty": "FT",
                    "year": "2023",
                    "source": "Pendanaan Inkubator"
                },
                {
                    "no": "2",
                    "productName": "D'yari Food (Produk makanan)",
                    "researcher": "Dr. Ir. Mahdiyah, M.Kes, Nur Riska, S.Pd., M.Si, Dra. Sachriani, M.Kes",
                    "faculty": "FT",
                    "year": "2023",
                    "source": "Pendanaan Inkubator"
                },
                {
                    "no": "3",
                    "productName": "Gethuk Gula Merah",
                    "researcher": "Dr. Alsuhendra, M.Si",
                    "faculty": "FT",
                    "year": "2022",
                    "source": "Pendanaan Inkubator"
                },
                {
                    "no": "4",
                    "productName": "Konsentrat Tempe Bubuk",
                    "researcher": "Dr. Ir. Ridawati, M.Si",
                    "faculty": "FT",
                    "year": "2022",
                    "source": "Pendanaan Inkubator"
                },
                {
                    "no": "5",
                    "productName": "Minuman Sari Secang",
                    "researcher": "Cucu Cahyana, S.Pd, M.Sc",
                    "faculty": "FT",
                    "year": "2023",
                    "source": "Pendanaan Inkubator"
                },
                {
                    "no": "6",
                    "productName": "on.choco.com (Makanan Tradisional / Oncom instan)",
                    "researcher": "Dr. Ir. Alsuhendra, M.Si.",
                    "faculty": "FT",
                    "year": "2021",
                    "source": "Pendanaan Inkubator"
                },
                {
                    "no": "7",
                    "productName": "Bahan ajar berbasis AR",
                    "researcher": "Dr. Yuliatri Sastrawijaya, M.Pd",
                    "faculty": "FT",
                    "year": "2022",
                    "source": "PUPT"
                },
                {
                    "no": "8",
                    "productName": "Edible Spoon",
                    "researcher": "Dr. Guspri Devi Artanti, S.Pd, M.Si",
                    "faculty": "FT",
                    "year": "2023",
                    "source": "PUPT"
                },
                {
                    "no": "9",
                    "productName": "Aplikasi Sistem Informasi Manajemen Sekolah",
                    "researcher": "Dr. Ir. Harliyana Chalik, M.Sc",
                    "faculty": "FT",
                    "year": "2022",
                    "source": "PUPT"
                },
                {
                    "no": "10",
                    "productName": "Kompor Perajang Kerupuk",
                    "researcher": "Siska Titik Dwiyati, S.Pd, M.Si",
                    "faculty": "FT",
                    "year": "2021",
                    "source": "PUPT"
                },
                {
                    "no": "11",
                    "productName": "Produk Halal dan Toyyib Berbasis IPTEK",
                    "researcher": "Dr. Mahdiyah, M.Kes",
                    "faculty": "FT",
                    "year": "2023",
                    "source": "PUPT"
                },
                {
                    "no": "12",
                    "productName": "Rumah Budaya Betawi",
                    "researcher": "Dr. Uswatun Hasanah, M.Si",
                    "faculty": "FT",
                    "year": "2022",
                    "source": "PUPT"
                }
            ];
            
            productData = fallbackData;
            filteredData = [...productData];
            setupFilters(productData);
            createFacultyChart(productData);
            createSourceChart(productData);
            updateTable();
        }

        // Process Excel data
        function processExcelData(jsonData) {
            // Skip header row if present
            const headerRow = jsonData[0];
            const dataStartIndex = typeof headerRow.A === 'string' && 
                                  (headerRow.A.toLowerCase().includes('no') || 
                                   headerRow.A.toLowerCase().includes('number')) ? 1 : 0;
            
            // Map Excel columns to our expected structure
            productData = jsonData.slice(dataStartIndex).map((row, index) => {
                return {
                    no: row.A?.toString() || (index + 1).toString(),
                    productName: row.B || '',
                    researcher: row.C || '',
                    faculty: row.D || '',
                    year: row.E?.toString() || '',
                    source: row.F || ''
                };
            });
            
            // Filter out empty rows
            productData = productData.filter(item => item.productName);
            
            // Initialize the UI with data
            filteredData = [...productData];
            setupFilters(productData);
            createFacultyChart(productData);
            createSourceChart(productData);
            updateTable();
        }

        // Function to update the table with the current page data
        function updateTable() {
            const tableBody = document.querySelector('#dataTable tbody');
            tableBody.innerHTML = '';
            
            if (filteredData.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No matching data found</td>
                    </tr>
                `;
                document.getElementById('resultCount').textContent = 'No results found';
                updatePagination(0, 0, 0);
                return;
            }
            
            // Calculate pagination
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredData.length);
            const currentPageData = filteredData.slice(startIndex, endIndex);
            
            // Update pagination info
            updatePagination(startIndex + 1, endIndex, filteredData.length);
            
            // Populate table with current page data
            currentPageData.forEach(item => {
                const row = document.createElement('tr');
                row.classList.add('hover:bg-gray-50');
                
                // Get faculty color for styling
                const facultyColor = getFacultyColor(item.faculty);
                
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${item.no || '-'}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">${item.productName || '-'}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">${item.researcher || '-'}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span class="faculty-pill" style="background-color: ${facultyColor}25; color: ${facultyColor}">
                            ${item.faculty || '-'}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                        <span class="year-pill">
                            ${item.year || '-'}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">${item.source || '-'}</td>
                `;
                
                tableBody.appendChild(row);
            });
            
            document.getElementById('resultCount').textContent = `${filteredData.length} results found`;
        }

        // Function to update pagination controls
        function updatePagination(start, end, total) {
            // Update pagination info text
            paginationInfo.textContent = total > 0 ? 
                `Showing ${start} to ${end} of ${total} items` : 
                'No items to display';
            
            const totalPages = Math.ceil(total / itemsPerPage);
            
            // Enable/disable previous and next buttons
            prevPageBtn.classList.toggle('disabled', currentPage <= 1);
            nextPageBtn.classList.toggle('disabled', currentPage >= totalPages);
            
            // Generate page buttons
            pageButtons.innerHTML = '';
            
            // Determine which page buttons to show
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, startPage + 4);
            
            // Adjust if we're near the end
            if (endPage - startPage < 4 && startPage > 1) {
                startPage = Math.max(1, endPage - 4);
            }
            
            // Add first page button if not starting from page 1
            if (startPage > 1) {
                addPageButton(1);
                if (startPage > 2) {
                    // Add ellipsis
                    const ellipsis = document.createElement('span');
                    ellipsis.textContent = '...';
                    ellipsis.className = 'px-3 py-2 text-gray-500';
                    pageButtons.appendChild(ellipsis);
                }
            }
            
            // Add numbered page buttons
            for (let i = startPage; i <= endPage; i++) {
                addPageButton(i);
            }
            
            // Add last page button if not ending at last page
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    // Add ellipsis
                    const ellipsis = document.createElement('span');
                    ellipsis.textContent = '...';
                    ellipsis.className = 'px-3 py-2 text-gray-500';
                    pageButtons.appendChild(ellipsis);
                }
                addPageButton(totalPages);
            }
        }
        
        // Helper function to add a page button
        function addPageButton(pageNum) {
            const button = document.createElement('button');
            button.textContent = pageNum;
            button.className = `pagination-button ${pageNum === currentPage ? 'active' : ''}`;
            button.addEventListener('click', () => {
                if (pageNum !== currentPage) {
                    currentPage = pageNum;
                    updateTable();
                }
            });
            pageButtons.appendChild(button);
        }

        // Function to create faculty distribution chart
        function createFacultyChart(data) {
            // Destroy existing chart if it exists
            if (facultyChart) {
                facultyChart.destroy();
            }
            
            // Count products by faculty
            const facultyCounts = {};
            data.forEach(item => {
                if (item.faculty) {
                    facultyCounts[item.faculty] = (facultyCounts[item.faculty] || 0) + 1;
                }
            });
            
            // Prepare data for chart
            const faculties = Object.keys(facultyCounts);
            const counts = Object.values(facultyCounts);
            const colors = faculties.map(getFacultyColor);
            
            // Create chart
            const ctx = document.getElementById('facultyChart').getContext('2d');
            facultyChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: faculties,
                    datasets: [{
                        label: 'Number of Innovations',
                        data: counts,
                        backgroundColor: colors,
                        borderColor: colors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Products'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Faculty'
                            }
                        }
                    }
                }
            });
        }

        // Function to create source distribution chart
        function createSourceChart(data) {
            // Destroy existing chart if it exists
            if (sourceChart) {
                sourceChart.destroy();
            }
            
            // Count products by source
            const sourceCounts = {};
            data.forEach(item => {
                if (item.source) {
                    sourceCounts[item.source] = (sourceCounts[item.source] || 0) + 1;
                }
            });
            
            // Sort sources by count (descending)
            const sources = Object.keys(sourceCounts).sort((a, b) => sourceCounts[b] - sourceCounts[a]);
            const counts = sources.map(source => sourceCounts[source]);
            
            // Generate colors for each source
            const sourceColors = sources.map((_, index) => {
                const hue = (index * 137) % 360; // Golden ratio to distribute colors nicely
                return `hsl(${hue}, 70%, 60%)`; 
            });
            
            // Create chart
            const ctx = document.getElementById('sourceChart').getContext('2d');
            sourceChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: sources,
                    datasets: [{
                        label: 'Funding Sources',
                        data: counts,
                        backgroundColor: sourceColors,
                        borderColor: 'white',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 15,
                                padding: 15
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Function to set up filter dropdowns
        function setupFilters(data) {
            // Get unique faculties and years
            const faculties = [...new Set(data.filter(item => item.faculty).map(item => item.faculty))].sort();
            const years = [...new Set(data.filter(item => item.year).map(item => item.year))].sort((a, b) => b - a);
            
            // Populate faculty dropdown
            const facultyFilter = document.getElementById('facultyFilter');
            facultyFilter.innerHTML = '<option value="">All Faculties</option>';
            faculties.forEach(faculty => {
                const option = document.createElement('option');
                option.value = faculty;
                option.textContent = faculty;
                facultyFilter.appendChild(option);
            });
            
            // Populate year filter
            const yearFilter = document.getElementById('yearFilter');
            yearFilter.innerHTML = '<option value="">All Years</option>';
            years.forEach(year => {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                yearFilter.appendChild(option);
            });
        }

        // Function to apply filters and search
        function applyFilters() {
            const facultyFilter = document.getElementById('facultyFilter').value;
            const yearFilter = document.getElementById('yearFilter').value;
            const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
            
            // Reset pagination to first page
            currentPage = 1;
            
            // Create a new filtered dataset
            filteredData = productData.filter(item => {
                // Apply faculty filter
                if (facultyFilter && item.faculty !== facultyFilter) {
                    return false;
                }
                
                // Apply year filter
                if (yearFilter && item.year !== yearFilter) {
                    return false;
                }
                
                // Apply search filter (improved to search across all fields)
                if (searchTerm) {
                    // Check multiple fields with null/undefined protection
                    return (
                        (item.productName && item.productName.toLowerCase().includes(searchTerm)) || 
                        (item.researcher && item.researcher.toLowerCase().includes(searchTerm)) || 
                        (item.faculty && item.faculty.toLowerCase().includes(searchTerm)) || 
                        (item.source && item.source.toLowerCase().includes(searchTerm)) || 
                        (item.no && item.no.toString().includes(searchTerm)) ||
                        (item.year && item.year.toString().includes(searchTerm))
                    );
                }
                
                return true;
            });
            
            // Update charts with filtered data
            createFacultyChart(filteredData);
            createSourceChart(filteredData);
            
            // Update table with filtered data
            updateTable();
        }
    </script>
</body>
</html>