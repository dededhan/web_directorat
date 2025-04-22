<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Innovation Database</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
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
<body>
    <!-- Navigation Bar -->
    
        
        @include('subdirektorat-inovasi.riset_unj.navbarprofile')

   
     <div id="mobileMenuButton" class="p-2 rounded-md hover:bg-teal-600 focus:outline-none">
                        
    </div>
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
        <div class="bg-white p-6 rounded-lg shadow-sm mb-8">
            
                
                <div>
                    <span id="dataStatus" class="px-4 py-2 bg-gray-100 rounded-full text-sm">Loading...</span>
                </div>
            </div>
        </div>

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
    @include('subdirektorat-inovasi.riset_unj.footerrisetunj')

    <script>
        // Mobile menu toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', function() {
                const mobileMenu = document.getElementById('mobileMenu');
                if (mobileMenu) {
                    mobileMenu.classList.toggle('hidden');
                }
            });
        }
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
    
    // Elements - safely get elements with null checks
    const getElement = (id) => document.getElementById(id);
    const dataStatus = getElement('dataStatus');
    const loadingOverlay = getElement('loadingOverlay');
    const prevPageBtn = getElement('prevPageBtn');
    const nextPageBtn = getElement('nextPageBtn');
    const pageButtons = getElement('pageButtons');
    const paginationInfo = getElement('paginationInfo');

    // Function to safely get a consistent color for a faculty
    function getFacultyColor(faculty) {
        return facultyColors[faculty] || '#a0aec0'; // Default color
    }

    // Initialize the page
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Document loaded, initializing data table...');
        
        // Check if required elements exist
        if (!dataStatus || !loadingOverlay) {
            console.error('Required elements not found in the DOM');
            return;
        }
        
        // Load the Excel file data immediately
        loadLocalExcelFile();
        
        // Set up search functionality with debounce
        const searchInput = getElement('searchInput');
        if (searchInput) {
            let searchTimeout = null;
            
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    applyFilters();
                }, 300); // 300ms debounce
            });
        }
        
        // Set up filter listeners
        const facultyFilter = getElement('facultyFilter');
        const yearFilter = getElement('yearFilter');
        
        if (facultyFilter) {
            facultyFilter.addEventListener('change', () => applyFilters());
        }
        
        if (yearFilter) {
            yearFilter.addEventListener('change', () => applyFilters());
        }
        
        // Set up pagination listeners
        if (prevPageBtn) {
            prevPageBtn.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    updateTable();
                }
            });
        }
        
        if (nextPageBtn) {
            nextPageBtn.addEventListener('click', () => {
                const totalPages = Math.ceil(filteredData.length / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    updateTable();
                }
            });
        }
    });

    // Load the Excel file from a local path
    function loadLocalExcelFile() {
        // Show loading overlay
        if (loadingOverlay) loadingOverlay.style.display = 'flex';
        if (dataStatus) dataStatus.textContent = 'Loading...';
        
        // Check if XLSX is loaded
        if (typeof XLSX === 'undefined') {
            console.error('XLSX library not loaded');
            if (dataStatus) {
                dataStatus.textContent = 'Error: Required libraries not loaded';
                dataStatus.classList.remove('bg-gray-100');
                dataStatus.classList.add('bg-red-100', 'text-red-800');
            }
            loadFallbackData();
            if (loadingOverlay) loadingOverlay.style.display = 'none';
            return;
        }
        
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
                try {
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
                    if (dataStatus) {
                        dataStatus.textContent = 'Data loaded successfully';
                        dataStatus.classList.remove('bg-gray-100');
                        dataStatus.classList.add('bg-green-100', 'text-green-800');
                    }
                } catch (e) {
                    console.error('Error processing Excel data:', e);
                    throw e;
                }
            })
            .catch(error => {
                console.error('Error loading Excel file:', error);
                if (dataStatus) {
                    dataStatus.textContent = 'Error loading data';
                    dataStatus.classList.remove('bg-gray-100');
                    dataStatus.classList.add('bg-red-100', 'text-red-800');
                }
                
                // Display fallback data
                loadFallbackData();
            })
            .finally(() => {
                // Hide loading overlay
                if (loadingOverlay) loadingOverlay.style.display = 'none';
            });
    }
    
    // Load fallback data if Excel file loading fails
    function loadFallbackData() {
        console.log('Loading fallback data...');
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
            // Keep the rest of your fallback data...
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
        if (!tableBody) {
            console.error('Table body element not found');
            return;
        }
        
        tableBody.innerHTML = '';
        
        if (filteredData.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No matching data found</td>
                </tr>
            `;
            const resultCount = getElement('resultCount');
            if (resultCount) {
                resultCount.textContent = 'No results found';
            }
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
        
        const resultCount = getElement('resultCount');
        if (resultCount) {
            resultCount.textContent = `${filteredData.length} results found`;
        }
    }

    // Function to update pagination controls
    function updatePagination(start, end, total) {
        // Update pagination info text
        if (paginationInfo) {
            paginationInfo.textContent = total > 0 ? 
                `Showing ${start} to ${end} of ${total} items` : 
                'No items to display';
        }
        
        const totalPages = Math.ceil(total / itemsPerPage);
        
        // Enable/disable previous and next buttons
        if (prevPageBtn) {
            prevPageBtn.classList.toggle('disabled', currentPage <= 1);
        }
        
        if (nextPageBtn) {
            nextPageBtn.classList.toggle('disabled', currentPage >= totalPages);
        }
        
        // Generate page buttons
        if (pageButtons) {
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
    }
    
    // Helper function to add a page button
    function addPageButton(pageNum) {
        if (!pageButtons) return;
        
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
        const facultyChartCanvas = getElement('facultyChart');
        if (!facultyChartCanvas) {
            console.error('Faculty chart canvas not found');
            return;
        }
        
        // Check if Chart.js is loaded
        if (typeof Chart === 'undefined') {
            console.error('Chart.js library not loaded');
            return;
        }
        
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
        const ctx = facultyChartCanvas.getContext('2d');
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
        const sourceChartCanvas = getElement('sourceChart');
        if (!sourceChartCanvas) {
            console.error('Source chart canvas not found');
            return;
        }
        
        // Check if Chart.js is loaded
        if (typeof Chart === 'undefined') {
            console.error('Chart.js library not loaded');
            return;
        }
        
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
        const ctx = sourceChartCanvas.getContext('2d');
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
        const facultyFilter = getElement('facultyFilter');
        if (facultyFilter) {
            facultyFilter.innerHTML = '<option value="">All Faculties</option>';
            faculties.forEach(faculty => {
                const option = document.createElement('option');
                option.value = faculty;
                option.textContent = faculty;
                facultyFilter.appendChild(option);
            });
        }
        
        // Populate year filter
        const yearFilter = getElement('yearFilter');
        if (yearFilter) {
            yearFilter.innerHTML = '<option value="">All Years</option>';
            years.forEach(year => {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                yearFilter.appendChild(option);
            });
        }
    }

    // Function to apply filters and search
    function applyFilters() {
        const facultyFilter = getElement('facultyFilter')?.value || '';
        const yearFilter = getElement('yearFilter')?.value || '';
        const searchTerm = getElement('searchInput')?.value.toLowerCase().trim() || '';
        
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
    
    // Initial console log to verify script loading
    console.log('Innovation data script loaded');
    </script>
</body>
</html>