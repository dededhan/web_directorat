<div x-data="{
        open: window.innerWidth >= 1024,
        mobileOpen: false,
        sustainabilityOpen: true,
        dataTablesOpen: true,
        internationalOpen: true,
        lectureStaffOpen: true,
        inovasiOpen: true,
        sdgsOpen: true,
        init() {
            this.$watch('mobileOpen', value => {
                if (value) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            });
            
            window.toggleSidebar = () => {
                this.mobileOpen = !this.mobileOpen;
            };
        },
        toggleMobile() {
            this.mobileOpen = !this.mobileOpen;
        }
     }"
     @resize.window="open = window.innerWidth >= 1024"
     @toggle-sidebar.window="mobileOpen = !mobileOpen"
     @keydown.escape.window="toggleMobile()"
     class="relative">

    <!-- Mobile Overlay -->
    <div x-show="mobileOpen" 
         @click="toggleMobile()"
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-30 bg-black bg-opacity-50 lg:hidden"
         style="display: none;"></div>

    <!-- Sidebar Container -->
    <div x-show="mobileOpen || window.innerWidth >= 1024"
         class="fixed inset-y-0 left-0 z-40 flex h-screen transform flex-col bg-gray-800 text-gray-200 shadow-lg transition-all duration-300 ease-in-out lg:relative lg:transform-none lg:z-30 lg:inset-0 lg:h-full"
         :class="{
             '-translate-x-full lg:translate-x-0': !mobileOpen && window.innerWidth < 1024,
             'translate-x-0': mobileOpen || window.innerWidth >= 1024,
             'w-80': open || (mobileOpen && window.innerWidth < 1024),
             'w-20': !open && !mobileOpen && window.innerWidth >= 1024
         }">

        <!-- Header -->
        <div class="flex h-16 flex-shrink-0 items-center justify-between border-b border-gray-700 px-6">
            <a href="#" class="flex items-center space-x-3 overflow-hidden" x-show="open || mobileOpen">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-blue-700 shadow-lg">
                    <i class='bx bxs-dashboard text-xl text-white'></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-bold">Admin Direktorat</span>
                    <span class="text-xs text-gray-400">Management System</span>
                </div>
            </a>
            
            <!-- Collapse Button for Desktop -->
            <button @click="open = !open" 
                    class="hidden rounded-md p-2 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none lg:block">
                <i class='bx bx-menu text-2xl'></i>
            </button>
            
            <!-- Close Button for Mobile -->
            <button @click="toggleMobile()" 
                    class="rounded-md p-2 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none lg:hidden">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 space-y-3 py-6 px-4 overflow-y-auto">

            <!-- Main Menu Section -->
            <div>
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Main Menu</h3>
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bxs-dashboard text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('admin.manageuser.index') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.manageuser.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bxs-user text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Manage User</span>
                </a>
                
                <a href="{{ route('admin.news.index') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.news.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bxs-news text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Berita</span>
                </a>
                
                <a href="{{ route('admin.news-scroll.index') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.news-scroll.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bx-news text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Berita Scroll</span>
                </a>
                
                <a href="{{ route('admin.program-layanan.index') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.program-layanan.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bx-list-ul text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Program dan Layanan</span>
                </a>
                
                <a href="{{ route('admin.document.index') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.document.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bxs-file text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Document</span>
                </a>
                
                <a href="{{ route('admin.youtube.index') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.youtube.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bxl-youtube text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Youtube</span>
                </a>
                
                <a href="{{ route('admin.instagram.index') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.instagram.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bxl-instagram text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Instagram</span>
                </a>
                
                <a href="{{ route('admin.sejarah.index') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.sejarah.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bx-building text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Sejarah</span>
                </a>
                
                <a href="{{ route('admin.pimpinan.index') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.pimpinan.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bxs-user-badge text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Pimpinan</span>
                </a>
                
                <a href="{{ route('admin.gallery.index') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.gallery.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bx-image text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Galery</span>
                </a>
            </div>

            <!-- Sustainability Section -->
            <div class="pt-3">
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Sustainability</h3>
                
                <button @click="sustainabilityOpen = !sustainabilityOpen" 
                        class="flex w-full items-center rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700 group"
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'">
                    <div class="flex items-center space-x-4">
                        <i class='bx bxs-leaf text-2xl flex-shrink-0'></i>
                        <span x-show="open || mobileOpen" class="font-medium">Sustainability</span>
                    </div>
                    <div x-show="open || mobileOpen" class="flex items-center">
                        <i class='bx bx-chevron-down text-2xl transition-transform duration-300' 
                           :class="{'rotate-180': sustainabilityOpen}"></i>
                    </div>
                </button>
                
                <div x-show="sustainabilityOpen && (open || mobileOpen)" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('admin.sustainability.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.sustainability.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-spreadsheet text-2xl flex-shrink-0'></i>
                        <span>Sustainability Data</span>
                    </a>
                    <a href="{{ route('admin.matakuliah.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.matakuliah.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-book text-2xl flex-shrink-0'></i>
                        <span>MK Sustainability</span>
                    </a>
                    <a href="{{ route('admin.alumniberdampak.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.alumniberdampak.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-group text-2xl flex-shrink-0'></i>
                        <span>Alumni Berdampak</span>
                    </a>
                </div>
            </div>

            <!-- Data Tables Section -->
            <div class="pt-3">
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Data Tables</h3>
                
                <button @click="dataTablesOpen = !dataTablesOpen" 
                        class="flex w-full items-center rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700 group"
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'">
                    <div class="flex items-center space-x-4">
                        <i class='bx bxs-data text-2xl flex-shrink-0'></i>
                        <span x-show="open || mobileOpen" class="font-medium">Data Tables</span>
                    </div>
                    <div x-show="open || mobileOpen" class="flex items-center">
                        <i class='bx bx-chevron-down text-2xl transition-transform duration-300' 
                           :class="{'rotate-180': dataTablesOpen}"></i>
                    </div>
                </button>
                
                <div x-show="dataTablesOpen && (open || mobileOpen)" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('admin.responden.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.responden.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-user-voice text-2xl flex-shrink-0'></i>
                        <span>Responden</span>
                    </a>
                    <a href="{{ route('admin.responden_laporan') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.responden_laporan') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-bar-chart-alt-2 text-2xl flex-shrink-0'></i>
                        <span>Laporan Responden</span>
                    </a>
                    <a href="{{ route('admin.qsgeneraltable') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.qsgeneraltable') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-spreadsheet text-2xl flex-shrink-0'></i>
                        <span>Tabel General</span>
                    </a>
                    <a href="{{ route('admin.qsresponden.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.qsresponden.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-spreadsheet text-2xl flex-shrink-0'></i>
                        <span>Tabel Responden</span>
                    </a>
                    <a href="{{ route('admin.responden_graph') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.responden_graph') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-bar-chart-square text-2xl flex-shrink-0'></i>
                        <span>Grafik Jawaban</span>
                    </a>
                </div>
            </div>

            <!-- International Section -->
            <div class="pt-3">
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">International</h3>
                
                <button @click="internationalOpen = !internationalOpen" 
                        class="flex w-full items-center rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700 group"
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'">
                    <div class="flex items-center space-x-4">
                        <i class='bx bx-world text-2xl flex-shrink-0'></i>
                        <span x-show="open || mobileOpen" class="font-medium">International</span>
                    </div>
                    <div x-show="open || mobileOpen" class="flex items-center">
                        <i class='bx bx-chevron-down text-2xl transition-transform duration-300' 
                           :class="{'rotate-180': internationalOpen}"></i>
                    </div>
                </button>
                
                <div x-show="internationalOpen && (open || mobileOpen)" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('admin.mahasiswainternational.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.mahasiswainternational.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-graduation text-2xl flex-shrink-0'></i>
                        <span>Mahasiswa International</span>
                    </a>
                    <a href="{{ route('admin.dataakreditasi.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.dataakreditasi.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-spreadsheet text-2xl flex-shrink-0'></i>
                        <span>Data Akreditasi</span>
                    </a>
                    <a href="{{ route('admin.internationallecture.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.internationallecture.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-school text-2xl flex-shrink-0'></i>
                        <span>International Lecture</span>
                    </a>
                    <a href="{{ route('admin.ranking.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.ranking.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-trophy text-2xl flex-shrink-0'></i>
                        <span>Ranking Pemeringkatan</span>
                    </a>
                    <a href="{{ route('admin.global.engagement.dashboard') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.global.engagement.*') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-globe text-2xl flex-shrink-0'></i>
                        <span>Global Engagement</span>
                    </a>
                    <a href="{{ route('admin.indikator.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.indikator.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bx-trending-up text-2xl flex-shrink-0'></i>
                        <span>Indikator Pemeringkatan</span>
                    </a>
                </div>
            </div>

            <!-- Lecture Staff International Section -->
            <div class="pt-3">
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Lecture Staff International</h3>
                
                <button @click="lectureStaffOpen = !lectureStaffOpen" 
                        class="flex w-full items-center rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700 group"
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'">
                    <div class="flex items-center space-x-4">
                        <i class='bx bxs-user-voice text-2xl flex-shrink-0'></i>
                        <span x-show="open || mobileOpen" class="font-medium">Faculty Staff</span>
                    </div>
                    <div x-show="open || mobileOpen" class="flex items-center">
                        <i class='bx bx-chevron-down text-2xl transition-transform duration-300' 
                           :class="{'rotate-180': lectureStaffOpen}"></i>
                    </div>
                </button>
                
                <div x-show="lectureStaffOpen && (open || mobileOpen)" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('admin.international_faculty_staff.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.international_faculty_staff.*') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-id-card text-2xl flex-shrink-0'></i>
                        <span>Faculty Staff Profile</span>
                    </a>
                    <a href="{{ route('admin.international-activities.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.international-activities.*') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bx-calendar-event text-2xl flex-shrink-0'></i>
                        <span>Aktivitas Dosen Asing</span>
                    </a>
                </div>
            </div>

            <!-- Inovasi Section -->
            <div class="pt-3">
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Inovasi</h3>
                
                <button @click="inovasiOpen = !inovasiOpen" 
                        class="flex w-full items-center rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700 group"
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'">
                    <div class="flex items-center space-x-4">
                        <i class='bx bxs-bulb text-2xl flex-shrink-0'></i>
                        <span x-show="open || mobileOpen" class="font-medium">Inovasi</span>
                    </div>
                    <div x-show="open || mobileOpen" class="flex items-center">
                        <i class='bx bx-chevron-down text-2xl transition-transform duration-300' 
                           :class="{'rotate-180': inovasiOpen}"></i>
                    </div>
                </button>
                
                <div x-show="inovasiOpen && (open || mobileOpen)" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('admin.katsinov.TableKatsinov') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.katsinov.TableKatsinov') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bx-table text-2xl flex-shrink-0'></i>
                        <span>Tabel Katsinov</span>
                    </a>
                    <a href="{{ route('admin.katsinov.form') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.katsinov.form') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-file-plus text-2xl flex-shrink-0'></i>
                        <span>Form Katsinov</span>
                    </a>
                    <a href="{{ route('admin.video.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.video.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-video text-2xl flex-shrink-0'></i>
                        <span>Video Pimpinan</span>
                    </a>
                    <a href="{{ route('admin.produk_inovasi') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.produk_inovasi') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bx-package text-2xl flex-shrink-0'></i>
                        <span>Produk Inovasi</span>
                    </a>
                    <a href="{{ route('admin.mitra-kolaborasi.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.mitra-kolaborasi.*') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-group text-2xl flex-shrink-0'></i>
                        <span>Mitra Kolaborasi</span>
                    </a>
                    <a href="{{ route('admin.risetdataunj.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.risetdataunj.*') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bx-chart text-2xl flex-shrink-0'></i>
                        <span>Riset UNJ</span>
                    </a>
                </div>
            </div>

            <!-- SDGs Section -->
            <div class="pt-3">
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">SDGs</h3>
                
                <button @click="sdgsOpen = !sdgsOpen" 
                        class="flex w-full items-center rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700 group"
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'">
                    <div class="flex items-center space-x-4">
                        <i class='bx bx-planet text-2xl flex-shrink-0'></i>
                        <span x-show="open || mobileOpen" class="font-medium">SDGs</span>
                    </div>
                    <div x-show="open || mobileOpen" class="flex items-center">
                        <i class='bx bx-chevron-down text-2xl transition-transform duration-300' 
                           :class="{'rotate-180': sdgsOpen}"></i>
                    </div>
                </button>
                
                <div x-show="sdgsOpen && (open || mobileOpen)" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('admin.SDGs.program-kegiatan.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.SDGs.program-kegiatan.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bx-calendar-check text-2xl flex-shrink-0'></i>
                        <span>Program</span>
                    </a>
                    <a href="{{ route('admin.SDGs.publikasi-riset.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.SDGs.publikasi-riset.index') ? 'bg-blue-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bx-file-find text-2xl flex-shrink-0'></i>
                        <span>Publikasi & Riset</span>
                    </a>
                </div>
            </div>

        </nav>

        <!-- Logout Section -->
        <div class="border-t border-gray-700 py-4 px-4">
            <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar">
                @csrf
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 hover:bg-red-600 hover:text-white"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bxs-log-out-circle text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Logout</span>
                </a>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    window.debugSidebar = function() {
        console.log('Sidebar debug called');
        const event = new CustomEvent('toggle-sidebar');
        window.dispatchEvent(event);
    };
    
    window.toggleSidebar = function() {
        const event = new CustomEvent('toggle-sidebar');
        window.dispatchEvent(event);
    };
    
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            if (window.innerWidth >= 1024) {
                document.body.style.overflow = '';
            }
        }, 100);
    });
});
</script>
