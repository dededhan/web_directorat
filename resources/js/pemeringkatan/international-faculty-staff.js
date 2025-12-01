 // Filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const facultyProfiles = document.querySelectorAll('.faculty-profile');
            const loadMoreBtn = document.getElementById('load-more-btn');
            const facultyGrid = document.getElementById('faculty-grid');
            const searchInput = document.getElementById('faculty-search');
            const yearDropdown = document.getElementById('year-dropdown');

            // This entire block is wrapped in a try-catch to prevent errors from stopping other scripts.
            try {
                // Get all the faculty profiles from the grid
                const facultyProfilesInGrid = Array.from(facultyGrid.querySelectorAll('.faculty-profile'));

                // Initially, display a limited number of faculty profiles
                const initialDisplayCount = 9; // Show first 9 items
                let displayCount = initialDisplayCount;

                if (yearDropdown) {
                    yearDropdown.addEventListener('change', function() {
                        const selectedYear = this.value;

                        // Filter profiles by year
                        facultyProfilesInGrid.forEach(profile => {
                            const profileYear = profile.getAttribute('data-year');

                            if (profileYear === selectedYear) {
                                profile.classList.remove('year-hidden');
                            } else {
                                profile.classList.add('year-hidden');
                            }
                        });

                        // Reset display count and update display
                        displayCount = initialDisplayCount;
                        updateDisplayedItems();
                    });
                }

                // Function to update the displayed items
                function updateDisplayedItems() {
                    let visibleCount = 0;
                    facultyProfilesInGrid.forEach((profile, index) => {
                        const isFilterHidden = profile.classList.contains('filter-hidden');
                        const isSearchHidden = profile.classList.contains('search-hidden');
                        const isYearHidden = profile.classList.contains('year-hidden');

                        if (!isFilterHidden && !isSearchHidden && !isYearHidden && visibleCount <
                            displayCount) {
                            profile.style.display = 'block';
                            visibleCount++;
                        } else {
                            profile.style.display = 'none';
                        }
                    });

                    // Hide load more button if all visible items are displayed
                    const totalVisible = facultyProfilesInGrid.filter(profile =>
                        !profile.classList.contains('filter-hidden') &&
                        !profile.classList.contains('search-hidden') &&
                        !profile.classList.contains('year-hidden')).length;

                    if (loadMoreBtn) {
                        if (totalVisible <= visibleCount) {
                            loadMoreBtn.style.display = 'none';
                        } else {
                            loadMoreBtn.style.display = 'flex';
                        }
                    }
                }

                // Apply initial display
                facultyProfilesInGrid.forEach((profile) => {
                    profile.classList.remove('filter-hidden', 'search-hidden');
                });
                updateDisplayedItems();

                // Load more button functionality
                if (loadMoreBtn) {
                    loadMoreBtn.addEventListener('click', function() {
                        displayCount += 6; // Load 6 more items
                        updateDisplayedItems();
                    });
                }

                // Filter buttons functionality
                filterButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Reset display count to initial
                        displayCount = initialDisplayCount;

                        // Remove active class from all buttons
                        filterButtons.forEach(btn => btn.classList.remove('active'));

                        // Add active class to clicked button
                        this.classList.add('active');

                        const filterValue = this.getAttribute('data-filter');

                        // Show/hide faculty profiles based on filter
                        facultyProfilesInGrid.forEach(profile => {
                            if (filterValue === 'all' || profile.getAttribute(
                                    'data-faculty') === filterValue) {
                                profile.classList.remove('filter-hidden');
                            } else {
                                profile.classList.add('filter-hidden');
                            }
                        });

                        // Update displayed items
                        updateDisplayedItems();
                    });
                });

                // Search functionality
                if (searchInput) {
                    searchInput.addEventListener('input', function() {
                        // Reset display count to initial
                        displayCount = initialDisplayCount;

                        const searchTerm = this.value.toLowerCase();

                        facultyProfilesInGrid.forEach(profile => {
                            const name = profile.querySelector('h3').textContent.toLowerCase();
                            const expertise = profile.querySelector('p').textContent.toLowerCase();

                            if (name.includes(searchTerm) || expertise.includes(searchTerm)) {
                                profile.classList.remove('search-hidden');
                            } else {
                                profile.classList.add('search-hidden');
                            }
                        });

                        updateDisplayedItems();
                    });
                }
            } catch (e) {
                console.error("An error occurred in the faculty filter/search script:", e);
            }
        });
      
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('detailModal');
        const closeModalBtn = document.getElementById('closeModal');
        const detailButtons = document.querySelectorAll('.show-details-btn');
        
        if (!modal || !closeModalBtn || !detailButtons.length) {
            console.error("Modal elements not found. The modal will not function.");
            return;
        }
        
        closeModalBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
        
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
        
        detailButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Use the new data-detail-url attribute which contains the correct URL
                const fetchUrl = this.getAttribute('data-detail-url');
                fetchActivityDetails(fetchUrl);
            });
        });
        
        function fetchActivityDetails(url) {
            if (!url) {
                console.error('Fetch URL is not provided.');
                return;
            }

            document.getElementById('modalTitle').textContent = 'Loading...';
            document.getElementById('modalHeading').textContent = 'Loading...';
            document.getElementById('modalBody').innerHTML = '<div class="flex justify-center"><div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-teal-700"></div></div>';
            document.getElementById('modalImage').src = '';
            document.getElementById('modalDate').textContent = '';
            
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Network response was not ok, status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('modalTitle').textContent = 'Detail Aktivitas';
                    document.getElementById('modalHeading').textContent = data.judul;
                    document.getElementById('modalBody').innerHTML = data.isi;
                    
                    // Construct image URL using the application's base URL for robustness
                    const baseUrl = window.location.origin;
                    const imageUrl = `${baseUrl}/storage/${data.gambar}`;
                    document.getElementById('modalImage').src = imageUrl;
                    document.getElementById('modalImage').alt = data.judul;
                    
                    const date = new Date(data.tanggal);
                    const formattedDate = new Intl.DateTimeFormat('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    }).format(date);
                    document.getElementById('modalDate').textContent = formattedDate;
                })
                .catch(error => {
                    console.error('Error fetching activity details:', error);
                    document.getElementById('modalTitle').textContent = 'Error';
                    document.getElementById('modalHeading').textContent = 'Gagal Memuat';
                    document.getElementById('modalBody').innerHTML = '<p class="text-red-500">Gagal memuat detail aktivitas. Pastikan Anda terhubung ke internet dan coba lagi.</p>';
                    document.getElementById('modalImage').src = '';
                });
        }
    });
