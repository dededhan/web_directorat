<div x-data="{
        open: window.innerWidth >= 1024,
        mobileOpen: false,
        sustainabilityOpen: {{ request()->routeIs('admin.sustainability.*') || request()->routeIs('admin.matakuliah.*') || request()->routeIs('admin.alumniberdampak.*') ? 'true' : 'false' }},
        dataTablesOpen: {{ request()->routeIs('admin.responden.*') || request()->routeIs('admin.qsgeneraltable') || request()->routeIs('admin.qsresponden.*') || request()->routeIs('admin.responden_laporan') || request()->routeIs('admin.responden_graph') ? 'true' : 'false' }},
        internationalOpen: {{ request()->routeIs('admin.mahasiswainternational.*') || request()->routeIs('admin.dataakreditasi.*') || request()->routeIs('admin.internationallecture.*') || request()->routeIs('admin.ranking.*') || request()->routeIs('admin.global.*') || request()->routeIs('admin.indikator.*') ? 'true' : 'false' }},
        lectureStaffOpen: {{ request()->routeIs('admin.international_faculty_staff.*') || request()->routeIs('admin.international-activities') ? 'true' : 'false' }},
        inovasiOpen: {{ request()->routeIs('admin.katsinov.*') || request()->routeIs('admin.katsinov-v2.*') || request()->routeIs('admin.video.*') || request()->routeIs('admin.produk_inovasi') || request()->routeIs('admin.mitra-kolaborasi.*') || request()->routeIs('admin.risetdataunj.*') ? 'true' : 'false' }},
        sdgsOpen: {{ request()->routeIs('admin.SDGs.*') ? 'true' : 'false' }},
        init() {
            this.$watch('mobileOpen', value => {
                if (value) { document.body.style.overflow = 'hidden'; } 
                else { document.body.style.overflow = ''; }
            });
            window.toggleSidebar = () => { this.mobileOpen = !this.mobileOpen; };
        },
        toggleMobile() { this.mobileOpen = !this.mobileOpen; }
    }"
    @resize.window="open = window.innerWidth >= 1024"
    @toggle-sidebar.window="mobileOpen = !this.mobileOpen"
    @keydown.escape.window="toggleMobile()"
    class="relative">

    <button type="button" 
            @click="toggleMobile()"
            x-show="!mobileOpen"
            class="fixed top-4 left-4 z-50 inline-flex items-center justify-center rounded-md p-2 text-gray-600 bg-white shadow-lg hover:bg-gray-100 focus:outline-none lg:hidden">
        <span class="sr-only">Open sidebar</span>
        <i class='bx bx-menu text-xl'></i>
    </button>

    <div x-show="mobileOpen" 
         @click="toggleMobile()"
         x-transition
         class="fixed inset-0 z-30 bg-black bg-opacity-50 lg:hidden"
         style="display: none;"></div>

    <div x-show="mobileOpen || window.innerWidth >= 1024"
         class="fixed inset-y-0 left-0 z-40 flex h-full transform flex-col bg-gray-800 text-gray-200 shadow-lg transition-all duration-300 ease-in-out lg:relative lg:transform-none lg:z-30"
         :class="{
             '-translate-x-full lg:translate-x-0': !mobileOpen && window.innerWidth < 1024,
             'translate-x-0': mobileOpen || window.innerWidth >= 1024,
             'w-80': open || (mobileOpen && window.innerWidth < 1024),
             'w-20': !open && !mobileOpen && window.innerWidth >= 1024
         }">

        <div class="flex h-16 flex-shrink-0 items-center justify-between border-b border-gray-700 px-6">
            <a href="#" class="flex items-center space-x-3 overflow-hidden" x-show="open || mobileOpen">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-teal-400 to-teal-600 shadow-lg">
                    <i class='bx bxs-dashboard text-xl text-white'></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-bold">Admin Direktorat</span>
                    <span class="text-xs text-gray-400">Management System</span>
                </div>
            </a>
            <button @click="open = !open" class="hidden rounded-md p-2 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none lg:block"><i class='bx bx-menu text-2xl'></i></button>
            <button @click="toggleMobile()" class="rounded-md p-2 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none lg:hidden"><i class='bx bx-x text-2xl'></i></button>
        </div>

        <nav class="flex-1 space-y-3 py-6 px-4 overflow-y-auto">
            <div>
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Main Menu</h3>
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}" 
                   :class="{'justify-center': !open && !mobileOpen}">
                   <i class='bx bxs-dashboard text-2xl flex-shrink-0'></i>
                   <span x-show="open || mobileOpen" class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('admin.manageuser.index') }}" 
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.manageuser.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}" 
                   :class="{'justify-center': !open && !mobileOpen}">
                   <i class='bx bxs-user text-2xl flex-shrink-0'></i>
                   <span x-show="open || mobileOpen" class="font-medium">Manage User</span>
                </a>
                <a href="{{ route('admin.news.index') }}" 
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.news.index') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}" 
                   :class="{'justify-center': !open && !mobileOpen}">
                   <i class='bx bxs-news text-2xl flex-shrink-0'></i>
                   <span x-show="open || mobileOpen" class="font-medium">Berita</span>
                </a>
                <a href="{{ route('admin.news-scroll.index') }}" 
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.news-scroll.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}" 
                   :class="{'justify-center': !open && !mobileOpen}">
                   <i class='bx bxs-info-circle text-2xl flex-shrink-0'></i>
                   <span x-show="open || mobileOpen" class="font-medium">Berita Scroll</span>
                </a>
                <a href="{{ route('admin.program-layanan.index') }}" 
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.program-layanan.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}" 
                   :class="{'justify-center': !open && !mobileOpen}">
                   <i class='bx bxs-briefcase text-2xl flex-shrink-0'></i>
                   <span x-show="open || mobileOpen" class="font-medium">Program dan Layanan</span>
                </a>
                <a href="{{ route('admin.document.index') }}" 
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.document.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}" 
                   :class="{'justify-center': !open && !mobileOpen}">
                   <i class='bx bxs-file text-2xl flex-shrink-0'></i>
                   <span x-show="open || mobileOpen" class="font-medium">Document</span>
                </a>
                <a href="{{ route('admin.youtube.index') }}" 
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.youtube.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}" 
                   :class="{'justify-center': !open && !mobileOpen}">
                   <i class='bx bxl-youtube text-2xl flex-shrink-0'></i>
                   <span x-show="open || mobileOpen" class="font-medium">Youtube</span>
                </a>
                <a href="{{ route('admin.instagram.index') }}" 
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.instagram.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}" 
                   :class="{'justify-center': !open && !mobileOpen}">
                   <i class='bx bxl-instagram text-2xl flex-shrink-0'></i>
                   <span x-show="open || mobileOpen" class="font-medium">Instagram</span>
                </a>
                <a href="{{ route('admin.sejarah.index') }}" 
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.sejarah.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}" 
                   :class="{'justify-center': !open && !mobileOpen}">
                   <i class='bx bxs-buildings text-2xl flex-shrink-0'></i>
                   <span x-show="open || mobileOpen" class="font-medium">Sejarah</span>
                </a>
                <a href="{{ route('admin.pimpinan.index') }}" 
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.pimpinan.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}" 
                   :class="{'justify-center': !open && !mobileOpen}">
                   <i class='bx bxs-user-badge text-2xl flex-shrink-0'></i>
                   <span x-show="open || mobileOpen" class="font-medium">Pimpinan</span>
                </a>
                <a href="{{ route('admin.gallery.index') }}" 
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin.gallery.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}" 
                   :class="{'justify-center': !open && !mobileOpen}">
                   <i class='bx bxs-photo-album text-2xl flex-shrink-0'></i>
                   <span x-show="open || mobileOpen" class="font-medium">Galeri</span>
                </a>
            </div>

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
                        <i class='bx bx-chevron-down text-2xl transition-transform duration-300' :class="{'rotate-180': sustainabilityOpen}"></i>
                    </div>
                </button>
                <div x-show="sustainabilityOpen && (open || mobileOpen)" x-collapse class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('admin.sustainability.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.sustainability.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-spreadsheet text-2xl flex-shrink-0'></i>
                        <span>Sustainability</span>
                    </a>
                    <a href="{{ route('admin.matakuliah.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.matakuliah.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-book text-2xl flex-shrink-0'></i>
                        <span>MK Sustainability</span>
                    </a>
                    <a href="{{ route('admin.alumniberdampak.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.alumniberdampak.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-group text-2xl flex-shrink-0'></i>
                        <span>Alumni Berdampak</span>
                    </a>
                </div>
            </div>

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
                        <i class='bx bx-chevron-down text-2xl transition-transform duration-300' :class="{'rotate-180': dataTablesOpen}"></i>
                    </div>
                </button>
                <div x-show="dataTablesOpen && (open || mobileOpen)" x-collapse class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('admin.responden.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.responden.index') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-user-voice text-2xl flex-shrink-0'></i>
                        <span>Responden</span>
                    </a>
                    <a href="{{ route('admin.responden_laporan') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.responden_laporan') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-bar-chart-alt-2 text-2xl flex-shrink-0'></i>
                        <span>Laporan Responden</span>
                    </a>
                    <a href="{{ route('admin.qsgeneraltable') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.qsgeneraltable') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-spreadsheet text-2xl flex-shrink-0'></i>
                        <span>Tabel General</span>
                    </a>
                    <a href="{{ route('admin.qsresponden.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.qsresponden.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-spreadsheet text-2xl flex-shrink-0'></i>
                        <span>Tabel Responden</span>
                    </a>
                    <a href="{{ route('admin.responden_graph') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.responden_graph') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-bar-chart-square text-2xl flex-shrink-0'></i>
                        <span>Grafik Jawaban</span>
                    </a>
                </div>
            </div>

            <div class="pt-3">
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">International</h3>
                <button @click="internationalOpen = !internationalOpen" 
                        class="flex w-full items-center rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700 group"
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'">
                    <div class="flex items-center space-x-4">
                        <i class='bx bxs-globe text-2xl flex-shrink-0'></i>
                        <span x-show="open || mobileOpen" class="font-medium">International</span>
                    </div>
                    <div x-show="open || mobileOpen" class="flex items-center">
                        <i class='bx bx-chevron-down text-2xl transition-transform duration-300' :class="{'rotate-180': internationalOpen}"></i>
                    </div>
                </button>
                <div x-show="internationalOpen && (open || mobileOpen)" x-collapse class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('admin.mahasiswainternational.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.mahasiswainternational.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-graduation text-2xl flex-shrink-0'></i>
                        <span>Mahasiswa International</span>
                    </a>
                    <a href="{{ route('admin.dataakreditasi.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.dataakreditasi.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-spreadsheet text-2xl flex-shrink-0'></i>
                        <span>Data Akreditasi</span>
                    </a>
                    <a href="{{ route('admin.internationallecture.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.internationallecture.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-school text-2xl flex-shrink-0'></i>
                        <span>International Lecture</span>
                    </a>
                    <a href="{{ route('admin.ranking.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.ranking.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-trophy text-2xl flex-shrink-0'></i>
                        <span>Ranking Pemeringkatan</span>
                    </a>
                    <a href="{{ route('admin.global.engagement.dashboard') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.global.engagement.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-globe text-2xl flex-shrink-0'></i>
                        <span>Global Engagement</span>
                    </a>
                    <a href="{{ route('admin.indikator.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.indikator.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-chart text-2xl flex-shrink-0'></i>
                        <span>Indikator Pemeringkatan</span>
                    </a>
                </div>
            </div>

            <div class="pt-3">
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Lecture Staff International</h3>
                <button @click="lectureStaffOpen = !lectureStaffOpen" 
                        class="flex w-full items-center rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700 group"
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'">
                    <div class="flex items-center space-x-4">
                        <i class='bx bxs-user-detail text-2xl flex-shrink-0'></i>
                        <span x-show="open || mobileOpen" class="font-medium">Lecture Staff</span>
                    </div>
                    <div x-show="open || mobileOpen" class="flex items-center">
                        <i class='bx bx-chevron-down text-2xl transition-transform duration-300' :class="{'rotate-180': lectureStaffOpen}"></i>
                    </div>
                </button>
                <div x-show="lectureStaffOpen && (open || mobileOpen)" x-collapse class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('admin.international_faculty_staff.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.international_faculty_staff.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-graduation text-2xl flex-shrink-0'></i>
                        <span>Faculty Staff Profile</span>
                    </a>
                    <a href="{{ route('admin.international-activities.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.international-activities') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-calendar-event text-2xl flex-shrink-0'></i>
                        <span>Aktivitas Dosen Asing</span>
                    </a>
                </div>
            </div>

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
                        <i class='bx bx-chevron-down text-2xl transition-transform duration-300' :class="{'rotate-180': inovasiOpen}"></i>
                    </div>
                </button>
                <div x-show="inovasiOpen && (open || mobileOpen)" x-collapse class="mt-2 ml-3 space-y-1">
                    {{-- KATSINOV V2 (New System) --}}
                    <div class="pl-4 space-y-1">
                        <div class="flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider text-teal-400 py-2">
                            <i class='bx bxs-star'></i>
                            <span>KATSINOV V2 (New)</span>
                        </div>
                        <a href="{{ route('admin.katsinov-v2.index') }}" 
                           class="flex items-center space-x-3 rounded-lg p-2.5 text-sm transition-colors duration-200 {{ request()->routeIs('admin.katsinov-v2.index') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                            <i class='bx bxs-table text-lg flex-shrink-0'></i>
                            <span>Table Data</span>
                        </a>
                        <a href="{{ route('admin.katsinov-v2.create') }}" 
                           class="flex items-center space-x-3 rounded-lg p-2.5 text-sm transition-colors duration-200 {{ request()->routeIs('admin.katsinov-v2.create') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                            <i class='bx bxs-file-plus text-lg flex-shrink-0'></i>
                            <span>Form Pengajuan</span>
                        </a>
                    </div>

                    {{-- KATSINOV V1 (Old System) --}}
                    <div class="pl-4 space-y-1 pt-3 border-t border-gray-700 mt-3">
                        <div class="flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider text-gray-400 py-2">
                            <span>KATSINOV V1</span>
                        </div>
                        <a href="{{ route('admin.katsinov.TableKatsinov') }}" 
                           class="flex items-center space-x-3 rounded-lg p-2.5 text-sm transition-colors duration-200 {{ request()->routeIs('admin.katsinov.TableKatsinov') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                            <i class='bx bxs-table text-lg flex-shrink-0'></i>
                            <span>Tabel Katsinov</span>
                        </a>
                        
                        <a href="{{ route('admin.katsinov.form') }}" 
                           class="flex items-center space-x-3 rounded-lg p-2.5 text-sm transition-colors duration-200 {{ request()->routeIs('admin.katsinov.form') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                            <i class='bx bxs-file-plus text-lg flex-shrink-0'></i>
                            <span>Form Katsinov</span>
                        </a>
                    </div>
                    <a href="{{ route('admin.video.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.video.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-video text-2xl flex-shrink-0'></i>
                        <span>Video Pimpinan</span>
                    </a>
                    <a href="{{ route('admin.produk_inovasi') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.produk_inovasi') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-cube text-2xl flex-shrink-0'></i>
                        <span>Produk Inovasi</span>
                    </a>
                    <a href="{{ route('admin.mitra-kolaborasi.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.mitra-kolaborasi.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-group text-2xl flex-shrink-0'></i>
                        <span>Mitra Kolaborasi</span>
                    </a>
                    <a href="{{ route('admin.risetdataunj.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.risetdataunj.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-flask text-2xl flex-shrink-0'></i>
                        <span>Riset UNJ</span>
                    </a>
                </div>
            </div>

            <div class="pt-3">
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">SDGs</h3>
                <button @click="sdgsOpen = !sdgsOpen" 
                        class="flex w-full items-center rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700 group"
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'">
                    <div class="flex items-center space-x-4">
                        <i class='bx bxs-planet text-2xl flex-shrink-0'></i>
                        <span x-show="open || mobileOpen" class="font-medium">SDGs</span>
                    </div>
                    <div x-show="open || mobileOpen" class="flex items-center">
                        <i class='bx bx-chevron-down text-2xl transition-transform duration-300' :class="{'rotate-180': sdgsOpen}"></i>
                    </div>
                </button>
                <div x-show="sdgsOpen && (open || mobileOpen)" x-collapse class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('admin.SDGs.program-kegiatan.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.SDGs.program-kegiatan.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-briefcase-alt text-2xl flex-shrink-0'></i>
                        <span>Program</span>
                    </a>
                    <a href="{{ route('admin.SDGs.publikasi-riset.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin.SDGs.publikasi-riset.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-book-bookmark text-2xl flex-shrink-0'></i>
                        <span>Publikasi & Riset</span>
                    </a>
                </div>
            </div>
        </nav>

        <div class="border-t border-gray-700 py-4 px-4">
            <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar">
                @csrf
                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" 
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 hover:bg-red-600 hover:text-white" 
                   :class="{'justify-center': !open && !mobileOpen}">
                   <i class='bx bxs-log-out-circle text-2xl flex-shrink-0'></i>
                   <span x-show="open || mobileOpen" class="font-medium">Logout</span>
                </a>
            </form>
        </div>
    </div>
</div>

<style>
[x-cloak] { display: none !important; }

@media (max-width: 1023px) {
    .sidebar-mobile-hidden {
        transform: translateX(-100%);
    }
    
    .sidebar-mobile-visible {
        transform: translateX(0);
    }
}

.sidebar-transition {
    transition: transform 0.3s ease-in-out;
}

.body-scroll-locked {
    overflow: hidden;
}

.flex-shrink-0 {
    flex-shrink: 0;
}
</style>

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
