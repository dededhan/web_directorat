<div x-data="{ open: true, mobileOpen: false }" @window.toggle-sidebar.document="mobileOpen = !mobileOpen">

    <!-- Mobile Overlay -->
    <div x-show="mobileOpen" 
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileOpen = false" 
         class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden" 
         style="display: none;"></div>

    <!-- Sidebar Container -->
    <div class="fixed inset-y-0 left-0 z-30 flex h-full transform flex-col bg-gradient-to-b from-gray-800 to-gray-900 text-gray-100 shadow-2xl transition-all duration-300 ease-in-out lg:relative lg:transform-none"
         :class="{
             '-translate-x-full': !mobileOpen,
             'translate-x-0': mobileOpen,
             'w-80': open,
             'w-20': !open
         }">

        <!-- Header -->
        <div class="flex h-16 flex-shrink-0 items-center justify-between border-b border-gray-600 bg-gray-800 px-4">
            <a href="#" class="flex items-center space-x-3 overflow-hidden group" x-show="open">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-teal-400 to-teal-600 shadow-lg transition-all duration-200">
                    <i class='bx bxs-briefcase-alt-2 text-xl text-white'></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-lg font-bold text-white">Admin Equity</span>
                    <span class="text-xs text-gray-400">Management System</span>
                </div>
            </a>
            
            <!-- Collapse Button for Desktop -->
            <button @click="open = !open" 
                    class="hidden rounded-lg p-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200 focus:bg-gray-700 focus:outline-none lg:block">
                <i class='bx bx-menu text-2xl'></i>
            </button>
            
            <!-- Close Button for Mobile -->
            <button @click="mobileOpen = false" 
                    class="rounded-lg p-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200 focus:bg-gray-700 focus:outline-none lg:hidden">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 space-y-2 overflow-y-auto py-4 px-3 scrollbar-thin scrollbar-thumb-gray-600 scrollbar-track-transparent">

            <!-- Main Menu Section -->
            <div class="space-y-1">
                <h3 x-show="open" class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-gray-400">Main Menu</h3>
                <a href="{{ route('admin_equity.dashboard') }}"
                   class="flex items-center space-x-3 rounded-xl p-3 transition-all duration-200 group {{ request()->routeIs('admin_equity.dashboard') ? 'bg-gradient-to-r from-teal-500 to-teal-600 text-white shadow-lg shadow-teal-500/25' : 'hover:bg-gray-700 hover:shadow-lg hover:shadow-gray-900/20' }}">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg {{ request()->routeIs('admin_equity.dashboard') ? 'bg-white/20' : 'bg-gray-600 group-hover:bg-gray-500' }} transition-colors duration-200">
                        <i class='bx bxs-dashboard text-lg {{ request()->routeIs('admin_equity.dashboard') ? 'text-white' : 'text-gray-300' }}'></i>
                    </div>
                    <span x-show="open" class="whitespace-nowrap font-medium">Dashboard</span>
                </a>
            </div>

            <!-- Equity Programs Section -->
            <div class="pt-4 space-y-1">
                <h3 x-show="open" class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-gray-400">Equity Programs</h3>
                
                <!-- 1. Community Development Dropdown -->
                <div x-data="{ dropdownOpen: {{ request()->routeIs('admin_equity.comdev.*') ? 'true' : 'false' }} }">
                    <button @click="dropdownOpen = !dropdownOpen" 
                            class="flex w-full items-center justify-between space-x-3 rounded-xl p-3 transition-all duration-200 hover:bg-gray-700 hover:shadow-lg hover:shadow-gray-900/20 group">
                        <div class="flex items-center space-x-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-600 group-hover:bg-gray-500 transition-colors duration-200">
                                <i class='bx bxs-group text-lg text-gray-300'></i>
                            </div>
                            <span x-show="open" class="whitespace-nowrap font-medium">Community Development</span>
                        </div>
                        <div x-show="open" class="flex items-center justify-center w-6">
                            <i class='bx bx-chevron-down text-lg transition-transform duration-300' :class="{'rotate-180': dropdownOpen}"></i>
                        </div>
                    </button>
                    <div x-show="dropdownOpen" x-collapse class="pt-2 space-y-1">
                        <a href="{{ route('admin_equity.comdev.index') }}" 
                           class="flex items-center space-x-3 rounded-lg p-2 ml-4 text-sm transition-all duration-200 {{ request()->routeIs('admin_equity.comdev.index') ? 'bg-gradient-to-r from-teal-500 to-teal-600 text-white shadow-lg shadow-teal-500/25' : 'hover:bg-gray-700' }}">
                            <div class="flex h-6 w-6 items-center justify-center rounded {{ request()->routeIs('admin_equity.comdev.index') ? 'bg-white/20' : 'bg-gray-600' }}">
                                <i class='bx bx-list-ul text-sm {{ request()->routeIs('admin_equity.comdev.index') ? 'text-white' : 'text-gray-300' }}'></i>
                            </div>
                            <span x-show="open">Management kegiatan</span>
                        </a>
                        <a href="#" 
                           class="flex items-center space-x-3 rounded-lg p-2 ml-4 text-sm transition-all duration-200 hover:bg-gray-700">
                            <div class="flex h-6 w-6 items-center justify-center rounded bg-gray-600">
                                <i class='bx bxs-file-plus text-sm text-gray-300'></i>
                            </div>
                            <span x-show="open">Laporan</span>
                        </a>
                        @if(request()->routeIs('admin_equity.comdev.show') || request()->routeIs('admin_equity.comdev.submissions.*') || request()->routeIs('admin_equity.comdev.modules.*'))
                            @php
                                $currentSesi = request()->route('comdev');
                            @endphp
                            @if($currentSesi)
                                <a href="{{ route('admin_equity.comdev.modules.index', $currentSesi->id) }}" 
                                   class="flex items-center space-x-3 rounded-lg p-2 ml-4 text-sm transition-all duration-200 {{ request()->routeIs('admin_equity.comdev.modules.index') ? 'bg-gradient-to-r from-teal-500 to-teal-600 text-white shadow-lg shadow-teal-500/25' : 'hover:bg-gray-700' }}">
                                    <div class="flex h-6 w-6 items-center justify-center rounded {{ request()->routeIs('admin_equity.comdev.modules.index') ? 'bg-white/20' : 'bg-gray-600' }}">
                                        <i class='bx bx-cog text-sm {{ request()->routeIs('admin_equity.comdev.modules.index') ? 'text-white' : 'text-gray-300' }}'></i>
                                    </div>
                                    <span x-show="open">Manajemen Modul</span>
                                </a>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- 2. APC Dropdown -->
                <div x-data="{ dropdownOpen: {{ request()->routeIs('admin_equity.apc.*') ? 'true' : 'false' }} }">
                    <button @click="dropdownOpen = !dropdownOpen" 
                            class="flex w-full items-center justify-between space-x-3 rounded-xl p-3 transition-all duration-200 hover:bg-gray-700 hover:shadow-lg hover:shadow-gray-900/20 group">
                        <div class="flex items-center space-x-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-600 group-hover:bg-gray-500 transition-colors duration-200">
                                <i class='bx bxs-file-doc text-lg text-gray-300'></i>
                            </div>
                            <span x-show="open" class="whitespace-nowrap font-medium">Article Processing Cost</span>
                        </div>
                        <div x-show="open" class="flex items-center justify-center w-6">
                            <i class='bx bx-chevron-down text-lg transition-transform duration-300' :class="{'rotate-180': dropdownOpen}"></i>
                        </div>
                    </button>
                    <div x-show="dropdownOpen" x-collapse class="pt-2 space-y-1">
                        <a href="{{ route('admin_equity.apc.index') }}" 
                           class="flex items-center space-x-3 rounded-lg p-2 ml-4 text-sm transition-all duration-200 {{ request()->routeIs('admin_equity.apc.index') ? 'bg-gradient-to-r from-teal-500 to-teal-600 text-white shadow-lg shadow-teal-500/25' : 'hover:bg-gray-700' }}">
                            <div class="flex h-6 w-6 items-center justify-center rounded {{ request()->routeIs('admin_equity.apc.index') ? 'bg-white/20' : 'bg-gray-600' }}">
                                <i class='bx bx-list-ul text-sm {{ request()->routeIs('admin_equity.apc.index') ? 'text-white' : 'text-gray-300' }}'></i>
                            </div>
                            <span x-show="open">Daftar</span>
                        </a>
                        <a href="#" 
                           class="flex items-center space-x-3 rounded-lg p-2 ml-4 text-sm transition-all duration-200 hover:bg-gray-700">
                            <div class="flex h-6 w-6 items-center justify-center rounded bg-gray-600">
                                <i class='bx bxs-file-plus text-sm text-gray-300'></i>
                            </div>
                            <span x-show="open">Tambah Baru</span>
                        </a>
                    </div>
                </div>

                <!-- 3. Incentive Dropdown -->
                <div x-data="{ dropdownOpen: {{ request()->routeIs('admin_equity.incentive.*') ? 'true' : 'false' }} }">
                    <button @click="dropdownOpen = !dropdownOpen" 
                            class="flex w-full items-center justify-between space-x-3 rounded-xl p-3 transition-all duration-200 hover:bg-gray-700 hover:shadow-lg hover:shadow-gray-900/20 group">
                        <div class="flex items-center space-x-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-600 group-hover:bg-gray-500 transition-colors duration-200">
                                <i class='bx bxs-award text-lg text-gray-300'></i>
                            </div>
                            <span x-show="open" class="whitespace-nowrap font-medium">Insentif Reviewer</span>
                        </div>
                        <div x-show="open" class="flex items-center justify-center w-6">
                            <i class='bx bx-chevron-down text-lg transition-transform duration-300' :class="{'rotate-180': dropdownOpen}"></i>
                        </div>
                    </button>
                    <div x-show="dropdownOpen" x-collapse class="pt-2 space-y-1">
                        <a href="{{ route('admin_equity.incentive.index') }}" 
                           class="flex items-center space-x-3 rounded-lg p-2 ml-4 text-sm transition-all duration-200 {{ request()->routeIs('admin_equity.incentive.index') ? 'bg-gradient-to-r from-teal-500 to-teal-600 text-white shadow-lg shadow-teal-500/25' : 'hover:bg-gray-700' }}">
                            <div class="flex h-6 w-6 items-center justify-center rounded {{ request()->routeIs('admin_equity.incentive.index') ? 'bg-white/20' : 'bg-gray-600' }}">
                                <i class='bx bx-list-ul text-sm {{ request()->routeIs('admin_equity.incentive.index') ? 'text-white' : 'text-gray-300' }}'></i>
                            </div>
                            <span x-show="open">Daftar</span>
                        </a>
                        <a href="#" 
                           class="flex items-center space-x-3 rounded-lg p-2 ml-4 text-sm transition-all duration-200 hover:bg-gray-700">
                            <div class="flex h-6 w-6 items-center justify-center rounded bg-gray-600">
                                <i class='bx bxs-file-plus text-sm text-gray-300'></i>
                            </div>
                            <span x-show="open">Tambah Baru</span>
                        </a>
                    </div>
                </div>

                <!-- 4. Scopus/WOS Dropdown -->
                <div x-data="{ dropdownOpen: {{ request()->routeIs('admin_equity.scopus.*') ? 'true' : 'false' }} }">
                    <button @click="dropdownOpen = !dropdownOpen" 
                            class="flex w-full items-center justify-between space-x-3 rounded-xl p-3 transition-all duration-200 hover:bg-gray-700 hover:shadow-lg hover:shadow-gray-900/20 group">
                        <div class="flex items-center space-x-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-600 group-hover:bg-gray-500 transition-colors duration-200">
                                <i class='bx bxs-badge-check text-lg text-gray-300'></i>
                            </div>
                            <span x-show="open" class="whitespace-nowrap font-medium">Jurnal Scopus/WOS</span>
                        </div>
                        <div x-show="open" class="flex items-center justify-center w-6">
                            <i class='bx bx-chevron-down text-lg transition-transform duration-300' :class="{'rotate-180': dropdownOpen}"></i>
                        </div>
                    </button>
                    <div x-show="dropdownOpen" x-collapse class="pt-2 space-y-1">
                        <a href="{{ route('admin_equity.scopus.index') }}" 
                           class="flex items-center space-x-3 rounded-lg p-2 ml-4 text-sm transition-all duration-200 {{ request()->routeIs('admin_equity.scopus.index') ? 'bg-gradient-to-r from-teal-500 to-teal-600 text-white shadow-lg shadow-teal-500/25' : 'hover:bg-gray-700' }}">
                            <div class="flex h-6 w-6 items-center justify-center rounded {{ request()->routeIs('admin_equity.scopus.index') ? 'bg-white/20' : 'bg-gray-600' }}">
                                <i class='bx bx-list-ul text-sm {{ request()->routeIs('admin_equity.scopus.index') ? 'text-white' : 'text-gray-300' }}'></i>
                            </div>
                            <span x-show="open">Daftar</span>
                        </a>
                        <a href="#" 
                           class="flex items-center space-x-3 rounded-lg p-2 ml-4 text-sm transition-all duration-200 hover:bg-gray-700">
                            <div class="flex h-6 w-6 items-center justify-center rounded bg-gray-600">
                                <i class='bx bxs-file-plus text-sm text-gray-300'></i>
                            </div>
                            <span x-show="open">Tambah Baru</span>
                        </a>
                    </div>
                </div>

                <!-- 5. Conference & Match Making Dropdown -->
                <div x-data="{ dropdownOpen: {{ request()->routeIs('admin_equity.conference.*') ? 'true' : 'false' }} }">
                    <button @click="dropdownOpen = !dropdownOpen" 
                            class="flex w-full items-center justify-between space-x-3 rounded-xl p-3 transition-all duration-200 hover:bg-gray-700 hover:shadow-lg hover:shadow-gray-900/20 group">
                        <div class="flex items-center space-x-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-600 group-hover:bg-gray-500 transition-colors duration-200">
                                <i class='bx bx-globe text-lg text-gray-300'></i>
                            </div>
                            <span x-show="open" class="whitespace-nowrap font-medium">Konf & Match Making</span>
                        </div>
                        <div x-show="open" class="flex items-center justify-center w-6">
                            <i class='bx bx-chevron-down text-lg transition-transform duration-300' :class="{'rotate-180': dropdownOpen}"></i>
                        </div>
                    </button>
                    <div x-show="dropdownOpen" x-collapse class="pt-2 space-y-1">
                        <a href="{{ route('admin_equity.conference.index') }}" 
                           class="flex items-center space-x-3 rounded-lg p-2 ml-4 text-sm transition-all duration-200 {{ request()->routeIs('admin_equity.conference.index') ? 'bg-gradient-to-r from-teal-500 to-teal-600 text-white shadow-lg shadow-teal-500/25' : 'hover:bg-gray-700' }}">
                            <div class="flex h-6 w-6 items-center justify-center rounded {{ request()->routeIs('admin_equity.conference.index') ? 'bg-white/20' : 'bg-gray-600' }}">
                                <i class='bx bx-list-ul text-sm {{ request()->routeIs('admin_equity.conference.index') ? 'text-white' : 'text-gray-300' }}'></i>
                            </div>
                            <span x-show="open">Daftar</span>
                        </a>
                        <a href="#" 
                           class="flex items-center space-x-3 rounded-lg p-2 ml-4 text-sm transition-all duration-200 hover:bg-gray-700">
                            <div class="flex h-6 w-6 items-center justify-center rounded bg-gray-600">
                                <i class='bx bxs-file-plus text-sm text-gray-300'></i>
                            </div>
                            <span x-show="open">Tambah Baru</span>
                        </a>
                    </div>
                </div>

                <!-- 6. Visiting Professors Dropdown -->
                <div x-data="{ dropdownOpen: {{ request()->routeIs('admin_equity.visiting.*') ? 'true' : 'false' }} }">
                    <button @click="dropdownOpen = !dropdownOpen" 
                            class="flex w-full items-center justify-between space-x-3 rounded-xl p-3 transition-all duration-200 hover:bg-gray-700 hover:shadow-lg hover:shadow-gray-900/20 group">
                        <div class="flex items-center space-x-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-600 group-hover:bg-gray-500 transition-colors duration-200">
                                <i class='bx bxs-user-voice text-lg text-gray-300'></i>
                            </div>
                            <span x-show="open" class="whitespace-nowrap font-medium">Visiting Professors</span>
                        </div>
                        <div x-show="open" class="flex items-center justify-center w-6">
                            <i class='bx bx-chevron-down text-lg transition-transform duration-300' :class="{'rotate-180': dropdownOpen}"></i>
                        </div>
                    </button>
                    <div x-show="dropdownOpen" x-collapse class="pt-2 space-y-1">
                        <a href="{{ route('admin_equity.visiting.index') }}" 
                           class="flex items-center space-x-3 rounded-lg p-2 ml-4 text-sm transition-all duration-200 {{ request()->routeIs('admin_equity.visiting.index') ? 'bg-gradient-to-r from-teal-500 to-teal-600 text-white shadow-lg shadow-teal-500/25' : 'hover:bg-gray-700' }}">
                            <div class="flex h-6 w-6 items-center justify-center rounded {{ request()->routeIs('admin_equity.visiting.index') ? 'bg-white/20' : 'bg-gray-600' }}">
                                <i class='bx bx-list-ul text-sm {{ request()->routeIs('admin_equity.visiting.index') ? 'text-white' : 'text-gray-300' }}'></i>
                            </div>
                            <span x-show="open">Daftar</span>
                        </a>
                        <a href="#" 
                           class="flex items-center space-x-3 rounded-lg p-2 ml-4 text-sm transition-all duration-200 hover:bg-gray-700">
                            <div class="flex h-6 w-6 items-center justify-center rounded bg-gray-600">
                                <i class='bx bxs-file-plus text-sm text-gray-300'></i>
                            </div>
                            <span x-show="open">Tambah Baru</span>
                        </a>
                    </div>
                </div>
                
                <!-- 7. Joint Supervision Dropdown -->
                <div x-data="{ dropdownOpen: {{ request()->routeIs('admin_equity.supervision.*') ? 'true' : 'false' }} }">
                    <button @click="dropdownOpen = !dropdownOpen" 
                            class="flex w-full items-center justify-between space-x-3 rounded-xl p-3 transition-all duration-200 hover:bg-gray-700 hover:shadow-lg hover:shadow-gray-900/20 group">
                        <div class="flex items-center space-x-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-600 group-hover:bg-gray-500 transition-colors duration-200">
                                <i class='bx bxs-graduation text-lg text-gray-300'></i>
                            </div>
                            <span x-show="open" class="whitespace-nowrap font-medium">Joint Supervision</span>
                        </div>
                        <div x-show="open" class="flex items-center justify-center w-6">
                            <i class='bx bx-chevron-down text-lg transition-transform duration-300' :class="{'rotate-180': dropdownOpen}"></i>
                        </div>
                    </button>
                    <div x-show="dropdownOpen" x-collapse class="pt-2 space-y-1">
                        <a href="{{ route('admin_equity.supervision.index') }}" 
                           class="flex items-center space-x-3 rounded-lg p-2 ml-4 text-sm transition-all duration-200 {{ request()->routeIs('admin_equity.supervision.index') ? 'bg-gradient-to-r from-teal-500 to-teal-600 text-white shadow-lg shadow-teal-500/25' : 'hover:bg-gray-700' }}">
                            <div class="flex h-6 w-6 items-center justify-center rounded {{ request()->routeIs('admin_equity.supervision.index') ? 'bg-white/20' : 'bg-gray-600' }}">
                                <i class='bx bx-list-ul text-sm {{ request()->routeIs('admin_equity.supervision.index') ? 'text-white' : 'text-gray-300' }}'></i>
                            </div>
                            <span x-show="open">Daftar</span>
                        </a>
                        <a href="#" 
                           class="flex items-center space-x-3 rounded-lg p-2 ml-4 text-sm transition-all duration-200 hover:bg-gray-700">
                            <div class="flex h-6 w-6 items-center justify-center rounded bg-gray-600">
                                <i class='bx bxs-file-plus text-sm text-gray-300'></i>
                            </div>
                            <span x-show="open">Tambah Baru</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Reports Section -->
            <div class="pt-4 space-y-1">
                <h3 x-show="open" class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-gray-400">Laporan</h3>
                <a href="#" 
                   class="flex items-center space-x-3 rounded-xl p-3 transition-all duration-200 hover:bg-gray-700 hover:shadow-lg hover:shadow-gray-900/20 group">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-600 group-hover:bg-gray-500 transition-colors duration-200">
                        <i class='bx bxs-report text-lg text-gray-300'></i>
                    </div>
                    <span x-show="open" class="whitespace-nowrap font-medium">Laporan</span>
                </a>
            </div>

        </nav>

        <!-- Logout Section -->
        <div class="border-t border-gray-600 p-3">
            <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar">
                @csrf
                <button type="button" 
                        onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"
                        class="flex w-full items-center space-x-3 rounded-xl p-3 transition-all duration-200 hover:bg-red-600 hover:shadow-lg hover:shadow-red-600/25 group text-left">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-500 group-hover:bg-red-400 transition-colors duration-200">
                        <i class='bx bxs-log-out-circle text-lg text-white'></i>
                    </div>
                    <span x-show="open" class="whitespace-nowrap font-medium text-gray-300 group-hover:text-white">Logout</span>
                </button>
            </form>
        </div>
    </div>
</div>