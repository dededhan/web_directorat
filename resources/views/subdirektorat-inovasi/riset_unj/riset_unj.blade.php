<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riset Unggulan - Universitas Negeri Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .card-container { display: flex; flex-direction: column; height: 100%; transition: all 0.3s ease; }
        .card-container:hover { transform: translateY(-5px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
        .pagination-btn {
            padding: 0.5rem 1rem; border: 1px solid #ddd; background-color: white;
            border-radius: 0.375rem; cursor: pointer; transition: all 0.2s; margin: 0 0.25rem;
        }
        .pagination-btn:hover { background-color: #f3f4f6; }
        .pagination-btn.active { background-color: #186862; color: white; border-color: #186862; cursor: default; }
        .pagination-btn:disabled { background-color: #e5e7eb; color: #9ca3af; cursor: not-allowed; }
        .pagination-btn.ellipsis:disabled { border-color: transparent; background-color: transparent; }
        .modal-overlay { transition: opacity 0.3s ease; }
        .modal-content { transition: transform 0.3s ease; }
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #186862;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body class="bg-gray-100">

    @include('layout.navbar_hilirisasi')

    <main class="py-10 pt-28">
        <div class="container mx-auto px-4 lg:px-8">

            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Riset Unggulan UNJ</h1>
                <p class="mt-2 text-gray-600">Jelajahi inovasi dan penelitian terkini dari para akademisi UNJ.</p>
            </div>

            @php
                $faculties = collect($allData)->pluck(5)->merge(collect($allData)->pluck(3))
                    ->unique()
                    ->filter(function ($value) {
                        return !empty($value) && is_string($value) && strlen($value) <= 10 && !str_contains($value, ' ');
                    })
                    ->sort()->values();
                $years = collect($allData)->pluck(1)->unique()->filter()->sortDesc()->values();
            @endphp

            <div class="bg-white p-4 rounded-lg shadow-md mb-6 flex flex-col md:flex-row gap-4 items-center sticky top-0 z-10">
                <div class="relative w-full md:flex-grow">
                    <input type="text" id="searchInput" placeholder="Cari judul riset atau peneliti..." class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#186862]">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
                <div class="w-full md:w-auto">
                    <select id="facultyFilter" class="w-full border rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#186862]">
                        <option value="">Semua Fakultas</option>
                        @foreach($faculties as $faculty)
                            <option value="{{ $faculty }}">{{ $faculty }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full md:w-auto">
                    <select id="yearFilter" class="w-full border rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#186862]">
                        <option value="">Semua Tahun</option>
                         @foreach($years as $year)
                            @if(!empty($year))
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <button id="filterButton" class="w-full md:w-auto bg-[#186862] text-white px-6 py-2 rounded-lg hover:bg-[#125a54] transition duration-300">
                    Cari
                </button>
                <button id="resetButton" class="w-full md:w-auto bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-300">
                    Reset
                </button>
            </div>
            
            <div id="results-info" class="text-sm text-gray-600 mb-4"></div>

            <div id="loading-indicator" class="hidden justify-center items-center py-20"><div class="loader"></div></div>
            
            <div id="no-results" class="hidden text-center py-20">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" /></svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Data Tidak Ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">Coba sesuaikan filter pencarian Anda.</p>
            </div>

            <div id="riset-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"></div>
            <div id="pagination-controls" class="flex justify-center items-center mt-8 space-x-2"></div>
        </div>
    </main>
    
    <div id="detail-modal" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 opacity-0 pointer-events-none">
        <div class="modal-content bg-white rounded-lg shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto transform scale-95">
            <div class="flex justify-between items-center p-4 border-b sticky top-0 bg-white">
                <h3 class="text-xl font-semibold text-gray-800">Detail Penelitian</h3>
                <button id="close-modal-btn" class="text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
            </div>
            <div class="p-6">
                <h4 id="modal-judul" class="text-lg font-bold text-[#186862] mb-4"></h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div><strong class="text-gray-600 block">Ketua Peneliti:</strong> <span id="modal-ketua">-</span></div>
                    <div><strong class="text-gray-600 block">Tahun:</strong> <span id="modal-tahun">-</span></div>
                    <div><strong class="text-gray-600 block">Fakultas:</strong> <span id="modal-fakultas">-</span></div>
                    <div><strong class="text-gray-600 block">Skema:</strong> <span id="modal-skema">-</span></div>
                    <div class="md:col-span-2"><strong class="text-gray-600 block">Bidang Ilmu:</strong> <span id="modal-bidangilmu">-</span></div>
                    <div class="md:col-span-2"><strong class="text-gray-600 block">No. Kontrak Induk:</strong> <span id="modal-kontrakinduk">-</span></div>
                    <div><strong class="text-gray-600 block">Tgl. Kontrak Induk:</strong> <span id="modal-tglkontrakinduk">-</span></div>
                    <div><strong class="text-gray-600 block">No. Kontrak Turunan:</strong> <span id="modal-kontrakturunan">-</span></div>
                    <div><strong class="text-gray-600 block">Tgl. Kontrak Turunan:</strong> <span id="modal-tglkontrakturunan">-</span></div>
                    <div class="mt-4 pt-4 border-t md:col-span-2"><strong class="text-gray-600 block text-base">Dana Penelitian:</strong> <span id="modal-dana" class="text-xl font-bold text-gray-800">-</span></div>
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const allData = @json($allData);

        let currentPage = 1;
        const itemsPerPage = 12;
        let currentFilteredData = [];

        const gridContainer = document.getElementById('riset-grid');
        const paginationContainer = document.getElementById('pagination-controls');
        const noResultsMessage = document.getElementById('no-results');
        const loadingIndicator = document.getElementById('loading-indicator');
        const resultsInfo = document.getElementById('results-info');
        const searchInput = document.getElementById('searchInput');
        const facultyFilter = document.getElementById('facultyFilter');
        const yearFilter = document.getElementById('yearFilter');
        const filterButton = document.getElementById('filterButton');
        const resetButton = document.getElementById('resetButton');

        const modal = document.getElementById('detail-modal');
        const modalContent = modal.querySelector('.modal-content');
        const closeModalBtn = document.getElementById('close-modal-btn');
        
        function createCardHTML(penelitian, globalIndex) {
            const dana_string = penelitian[11] || penelitian[9] || '0';
            const dana_numeric = dana_string.toString().replace(/[^0-9]/g, '');
            const dana_final = parseFloat(dana_numeric) || 0;
            const formatted_dana = new Intl.NumberFormat('id-ID').format(dana_final);
            const judul = penelitian[4] || penelitian[6] || 'Judul Tidak Tersedia';
            const ketua = penelitian[2] || penelitian[3] || 'Ketua Peneliti Tidak Tersedia';
            const fakultas = penelitian[3] || penelitian[5] || 'N/A';
            const tahun = penelitian[1] || 'N/A';

            return `
                <div class="card-container bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                    <div class="p-5 flex-grow flex flex-col">
                        <div class="flex-grow">
                            <div class="flex justify-between items-start mb-3">
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-green-600 bg-green-200">${fakultas}</span>
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200">${tahun}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-700 mb-2">
                               <i class="fas fa-user-tie w-4 mr-2 text-gray-500"></i>
                               <span>${ketua}</span>
                            </div>
                            <h3 class="text-gray-900 font-bold text-lg leading-tight mb-2 h-20 overflow-hidden" title="${judul}">
                                ${judul.substring(0, 90)}${judul.length > 90 ? '...' : ''}
                            </h3>
                        </div>
                        <div class="border-t pt-4 mt-auto">
                            <div class="text-lg font-semibold text-gray-800">Rp ${formatted_dana}</div>
                            <button class="show-details-btn text-sm text-[#186862] font-semibold hover:underline mt-2" data-index="${globalIndex}">
                                Lihat Detail &rarr;
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }

        function displayPage() {
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const paginatedData = currentFilteredData.slice(startIndex, endIndex);

            gridContainer.innerHTML = '';
            
            if (currentFilteredData.length > 0) {
                resultsInfo.textContent = `Menampilkan ${paginatedData.length} dari ${currentFilteredData.length} hasil.`;
                gridContainer.classList.remove('hidden');
                noResultsMessage.classList.add('hidden');
                gridContainer.innerHTML = paginatedData.map(item => {
                    const globalIndex = allData.indexOf(item);
                    return createCardHTML(item, globalIndex);
                }).join('');
            } else {
                resultsInfo.textContent = 'Menampilkan 0 hasil.';
                gridContainer.classList.add('hidden');
                noResultsMessage.classList.remove('hidden');
            }
            setupPagination();
        }

        function setupPagination() {
            paginationContainer.innerHTML = '';
            const totalPages = Math.ceil(currentFilteredData.length / itemsPerPage);
            if (totalPages <= 1) return;

            const pageNumbers = getPageNumbers(totalPages, currentPage);
            
            const prevButton = createPaginationButton('&laquo;', () => {
                if (currentPage > 1) { currentPage--; displayPage(); window.scrollTo(0, 0); }
            }, currentPage === 1);
            paginationContainer.appendChild(prevButton);

            pageNumbers.forEach(page => {
                const pageButton = createPaginationButton(page, () => {
                    currentPage = page; displayPage(); window.scrollTo(0, 0);
                }, false, page === '...', page === currentPage);
                paginationContainer.appendChild(pageButton);
            });

            const nextButton = createPaginationButton('&raquo;', () => {
                if (currentPage < totalPages) { currentPage++; displayPage(); window.scrollTo(0, 0); }
            }, currentPage === totalPages);
            paginationContainer.appendChild(nextButton);
        }

        function createPaginationButton(content, onClick, disabled = false, isEllipsis = false, isActive = false) {
            const button = document.createElement('button');
            button.innerHTML = content;
            button.className = 'pagination-btn';
            if(disabled) button.disabled = true;
            if(isEllipsis) {
                button.disabled = true;
                button.classList.add('ellipsis');
            }
            if(isActive) button.classList.add('active');
            if(!isEllipsis) button.addEventListener('click', onClick);
            return button;
        }

        function getPageNumbers(totalPages, currentPage) {
            const siblingCount = 1;
            const totalPageNumbersToShow = siblingCount * 2 + 5;

            if (totalPages <= totalPageNumbersToShow) {
                return Array.from({ length: totalPages }, (_, i) => i + 1);
            }

            const leftSiblingIndex = Math.max(currentPage - siblingCount, 1);
            const rightSiblingIndex = Math.min(currentPage + siblingCount, totalPages);
            const shouldShowLeftDots = leftSiblingIndex > 2;
            const shouldShowRightDots = rightSiblingIndex < totalPages - 2;

            if (!shouldShowLeftDots && shouldShowRightDots) {
                let leftRange = Array.from({ length: 3 + 2 * siblingCount }, (_, i) => i + 1);
                return [...leftRange, '...', totalPages];
            }

            if (shouldShowLeftDots && !shouldShowRightDots) {
                let rightRange = Array.from({ length: 3 + 2 * siblingCount }, (_, i) => totalPages - (3 + 2 * siblingCount) + 1 + i);
                return [1, '...', ...rightRange];
            }

            if (shouldShowLeftDots && shouldShowRightDots) {
                let middleRange = Array.from({ length: rightSiblingIndex - leftSiblingIndex + 1 }, (_, i) => leftSiblingIndex + i);
                return [1, '...', ...middleRange, '...', totalPages];
            }
            return [];
        }

        function applyFilters() {
            loadingIndicator.style.display = 'flex';
            gridContainer.classList.add('hidden');
            noResultsMessage.classList.add('hidden');
            paginationContainer.innerHTML = '';
            resultsInfo.textContent = '';

            setTimeout(() => {
                if (!Array.isArray(allData)) { currentFilteredData = []; }
                else {
                    const searchTerm = searchInput.value.toLowerCase();
                    const selectedFaculty = facultyFilter.value;
                    const selectedYear = yearFilter.value;

                    currentFilteredData = allData.filter(item => {
                        if (!item) return false;
                        const title = (item[4] || item[6] || '').toLowerCase();
                        const researcher = (item[2] || item[3] || '').toLowerCase();
                        const faculty = item[3] || item[5] || '';
                        const year = item[1] || '';
                        const matchesSearch = title.includes(searchTerm) || researcher.includes(searchTerm);
                        const matchesFaculty = !selectedFaculty || faculty === selectedFaculty;
                        const matchesYear = !selectedYear || year.toString() == selectedYear;
                        return matchesSearch && matchesFaculty && matchesYear;
                    });
                }
                currentPage = 1;
                loadingIndicator.style.display = 'none';
                displayPage();
            }, 250); // Penundaan kecil untuk memastikan loading spinner terlihat
        }
        
        function resetFilters() {
            searchInput.value = ''; facultyFilter.value = ''; yearFilter.value = '';
            applyFilters();
        }

        function openModal(penelitian) {
            document.getElementById('modal-judul').innerText = penelitian[4] || penelitian[6] || 'N/A';
            document.getElementById('modal-ketua').innerText = penelitian[2] || penelitian[3] || 'N/A';
            document.getElementById('modal-tahun').innerText = penelitian[1] || 'N/A';
            document.getElementById('modal-fakultas').innerText = penelitian[3] || penelitian[5] || 'N/A';
            document.getElementById('modal-skema').innerText = penelitian[5] || penelitian[7] || 'N/A';
            document.getElementById('modal-bidangilmu').innerText = penelitian[10] || 'N/A';
            document.getElementById('modal-kontrakinduk').innerText = penelitian[6] || 'N/A';
            document.getElementById('modal-tglkontrakinduk').innerText = penelitian[7] || 'N/A';
            document.getElementById('modal-kontrakturunan').innerText = penelitian[8] || 'N/A';
            document.getElementById('modal-tglkontrakturunan').innerText = penelitian[9] || 'N/A';
            const dana_string = penelitian[11] || penelitian[9] || '0';
            const dana_numeric = dana_string.toString().replace(/[^0-9]/g, '');
            document.getElementById('modal-dana').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(parseFloat(dana_numeric) || 0);

            modal.classList.remove('opacity-0', 'pointer-events-none');
            modalContent.classList.remove('scale-95');
        }

        function closeModal() {
            modal.classList.add('opacity-0');
            modalContent.classList.add('scale-95');
            setTimeout(() => modal.classList.add('pointer-events-none'), 300);
        }

        filterButton.addEventListener('click', applyFilters);
        resetButton.addEventListener('click', resetFilters);
        closeModalBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === "Escape" && !modal.classList.contains('pointer-events-none')) closeModal();
        });

        gridContainer.addEventListener('click', function(e) {
            const detailButton = e.target.closest('.show-details-btn');
            if (detailButton) {
                const index = detailButton.dataset.index;
                const penelitianData = allData[index];
                if (penelitianData) {
                    openModal(penelitianData);
                }
            }
        });

        applyFilters();
    });
    </script>
</body>
</html>


