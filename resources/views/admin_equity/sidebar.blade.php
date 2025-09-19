<div x-data="{ open: true, mobileOpen: false }" @window.toggle-sidebar.document="mobileOpen = !mobileOpen">

    <div x-show="mobileOpen" @click="mobileOpen = false" class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden" style="display: none;"></div>

    <div class="fixed inset-y-0 left-0 z-30 flex h-full transform flex-col bg-gray-800 text-gray-200 shadow-lg transition-all duration-300 ease-in-out lg:relative lg:transform-none"
         :class="{
             '-translate-x-full': !mobileOpen,
             'translate-x-0': mobileOpen,
             'w-64': open,
             'w-20': !open
         }">

        <div class="flex h-16 flex-shrink-0 items-center justify-between border-b border-gray-700 px-4">
            <a href="#" class="flex items-center space-x-2 overflow-hidden" x-show="open">
                <i class='bx bxs-briefcase-alt-2 text-3xl text-teal-400'></i>
                <span class="whitespace-nowrap text-lg font-bold">Admin Equity</span>
            </a>
            <button @click="open = !open" class="hidden rounded-md p-2 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none lg:block">
                <i class='bx bx-menu text-2xl'></i>
            </button>
            <button @click="mobileOpen = false" class="rounded-md p-2 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none lg:hidden">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>

        <nav class="flex-1 space-y-2 overflow-y-auto py-4 px-2">

            <div>
                <h3 x-show="open" class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-gray-400">Main Menu</h3>
                <a href="{{ route('admin_equity.dashboard') }}"
                   class="flex items-center space-x-3 rounded-md p-2 transition-colors duration-200 {{ request()->routeIs('admin_equity.dashboard') ? 'bg-[#0D9488] font-semibold text-white' : 'hover:bg-gray-700' }}">
                    <i class='bx bxs-dashboard text-xl'></i>
                    <span x-show="open" class="whitespace-nowrap">Dashboard</span>
                </a>
            </div>

            <div class="pt-2">
                <h3 x-show="open" class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-gray-400">Equity Programs</h3>
                
                <!-- 1. Community Development Dropdown -->
                <div x-data="{ dropdownOpen: {{ request()->routeIs('admin_equity.comdev.*') ? 'true' : 'false' }} }">
                    <button @click="dropdownOpen = !dropdownOpen" class="flex w-full items-center justify-between space-x-3 rounded-md p-2 transition-colors duration-200 hover:bg-gray-700">
                        <div class="flex items-center space-x-3">
                            <i class='bx bxs-group text-xl'></i>
                            <span x-show="open" class="whitespace-nowrap">Community Development</span>
                        </div>
                        <i x-show="open" class='bx bx-chevron-down transition-transform duration-300' :class="{'rotate-180': dropdownOpen}"></i>
                    </button>
                    <div x-show="dropdownOpen" x-collapse class="pt-1 pl-5">
                        <a href="{{ route('admin_equity.comdev.index') }}" class="flex items-center space-x-3 rounded-md p-2 text-sm transition-colors duration-200 {{ request()->routeIs('admin_equity.comdev.index') ? 'bg-[#0D9488] font-semibold text-white' : 'hover:bg-gray-700' }}">
                            <i class='bx bx-list-ul text-lg'></i><span x-show="open">Daftar</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 rounded-md p-2 text-sm transition-colors duration-200 hover:bg-gray-700">
                            <i class='bx bxs-file-plus text-lg'></i><span x-show="open">Tambah Baru</span>
                        </a>
                    </div>
                </div>

                <!-- 2. APC Dropdown -->
                <div x-data="{ dropdownOpen: {{ request()->routeIs('admin_equity.apc.*') ? 'true' : 'false' }} }">
                    <button @click="dropdownOpen = !dropdownOpen" class="flex w-full items-center justify-between space-x-3 rounded-md p-2 transition-colors duration-200 hover:bg-gray-700">
                        <div class="flex items-center space-x-3">
                            <i class='bx bxs-file-doc text-xl'></i>
                            <span x-show="open" class="whitespace-nowrap">Article Processing Cost</span>
                        </div>
                        <i x-show="open" class='bx bx-chevron-down transition-transform duration-300' :class="{'rotate-180': dropdownOpen}"></i>
                    </button>
                    <div x-show="dropdownOpen" x-collapse class="pt-1 pl-5">
                        <a href="{{ route('admin_equity.apc.index') }}" class="flex items-center space-x-3 rounded-md p-2 text-sm transition-colors duration-200 {{ request()->routeIs('admin_equity.apc.index') ? 'bg-[#0D9488] font-semibold text-white' : 'hover:bg-gray-700' }}">
                            <i class='bx bx-list-ul text-lg'></i><span x-show="open">Daftar</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 rounded-md p-2 text-sm transition-colors duration-200 hover:bg-gray-700">
                            <i class='bx bxs-file-plus text-lg'></i><span x-show="open">Tambah Baru</span>
                        </a>
                    </div>
                </div>

                <!-- 3. Incentive Dropdown -->
                <div x-data="{ dropdownOpen: {{ request()->routeIs('admin_equity.incentive.*') ? 'true' : 'false' }} }">
                    <button @click="dropdownOpen = !dropdownOpen" class="flex w-full items-center justify-between space-x-3 rounded-md p-2 transition-colors duration-200 hover:bg-gray-700">
                        <div class="flex items-center space-x-3">
                            <i class='bx bxs-award text-xl'></i>
                            <span x-show="open" class="whitespace-nowrap">Insentif Reviewer</span>
                        </div>
                        <i x-show="open" class='bx bx-chevron-down transition-transform duration-300' :class="{'rotate-180': dropdownOpen}"></i>
                    </button>
                    <div x-show="dropdownOpen" x-collapse class="pt-1 pl-5">
                        <a href="{{ route('admin_equity.incentive.index') }}" class="flex items-center space-x-3 rounded-md p-2 text-sm transition-colors duration-200 {{ request()->routeIs('admin_equity.incentive.index') ? 'bg-[#0D9488] font-semibold text-white' : 'hover:bg-gray-700' }}">
                            <i class='bx bx-list-ul text-lg'></i><span x-show="open">Daftar</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 rounded-md p-2 text-sm transition-colors duration-200 hover:bg-gray-700">
                            <i class='bx bxs-file-plus text-lg'></i><span x-show="open">Tambah Baru</span>
                        </a>
                    </div>
                </div>

                <!-- 4. Scopus/WOS Dropdown -->
                <div x-data="{ dropdownOpen: {{ request()->routeIs('admin_equity.scopus.*') ? 'true' : 'false' }} }">
                    <button @click="dropdownOpen = !dropdownOpen" class="flex w-full items-center justify-between space-x-3 rounded-md p-2 transition-colors duration-200 hover:bg-gray-700">
                        <div class="flex items-center space-x-3">
                            <i class='bx bxs-badge-check text-xl'></i>
                            <span x-show="open" class="whitespace-nowrap">Jurnal Scopus/WOS</span>
                        </div>
                        <i x-show="open" class='bx bx-chevron-down transition-transform duration-300' :class="{'rotate-180': dropdownOpen}"></i>
                    </button>
                    <div x-show="dropdownOpen" x-collapse class="pt-1 pl-5">
                        <a href="{{ route('admin_equity.scopus.index') }}" class="flex items-center space-x-3 rounded-md p-2 text-sm transition-colors duration-200 {{ request()->routeIs('admin_equity.scopus.index') ? 'bg-[#0D9488] font-semibold text-white' : 'hover:bg-gray-700' }}">
                            <i class='bx bx-list-ul text-lg'></i><span x-show="open">Daftar</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 rounded-md p-2 text-sm transition-colors duration-200 hover:bg-gray-700">
                            <i class='bx bxs-file-plus text-lg'></i><span x-show="open">Tambah Baru</span>
                        </a>
                    </div>
                </div>

                <!-- 5. Conference & Match Making Dropdown -->
                <div x-data="{ dropdownOpen: {{ request()->routeIs('admin_equity.conference.*') ? 'true' : 'false' }} }">
                    <button @click="dropdownOpen = !dropdownOpen" class="flex w-full items-center justify-between space-x-3 rounded-md p-2 transition-colors duration-200 hover:bg-gray-700">
                        <div class="flex items-center space-x-3">
                            <i class='bx bx-globe text-xl'></i>
                            <span x-show="open" class="whitespace-nowrap">Konferensi & Match Making</span>
                        </div>
                        <i x-show="open" class='bx bx-chevron-down transition-transform duration-300' :class="{'rotate-180': dropdownOpen}"></i>
                    </button>
                    <div x-show="dropdownOpen" x-collapse class="pt-1 pl-5">
                        <a href="{{ route('admin_equity.conference.index') }}" class="flex items-center space-x-3 rounded-md p-2 text-sm transition-colors duration-200 {{ request()->routeIs('admin_equity.conference.index') ? 'bg-[#0D9488] font-semibold text-white' : 'hover:bg-gray-700' }}">
                            <i class='bx bx-list-ul text-lg'></i><span x-show="open">Daftar</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 rounded-md p-2 text-sm transition-colors duration-200 hover:bg-gray-700">
                            <i class='bx bxs-file-plus text-lg'></i><span x-show="open">Tambah Baru</span>
                        </a>
                    </div>
                </div>

                <!-- 6. Visiting Professors Dropdown -->
                <div x-data="{ dropdownOpen: {{ request()->routeIs('admin_equity.visiting.*') ? 'true' : 'false' }} }">
                    <button @click="dropdownOpen = !dropdownOpen" class="flex w-full items-center justify-between space-x-3 rounded-md p-2 transition-colors duration-200 hover:bg-gray-700">
                        <div class="flex items-center space-x-3">
                            <i class='bx bxs-user-voice text-xl'></i>
                            <span x-show="open" class="whitespace-nowrap">Visiting Professors</span>
                        </div>
                        <i x-show="open" class='bx bx-chevron-down transition-transform duration-300' :class="{'rotate-180': dropdownOpen}"></i>
                    </button>
                    <div x-show="dropdownOpen" x-collapse class="pt-1 pl-5">
                        <a href="{{ route('admin_equity.visiting.index') }}" class="flex items-center space-x-3 rounded-md p-2 text-sm transition-colors duration-200 {{ request()->routeIs('admin_equity.visiting.index') ? 'bg-[#0D9488] font-semibold text-white' : 'hover:bg-gray-700' }}">
                            <i class='bx bx-list-ul text-lg'></i><span x-show="open">Daftar</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 rounded-md p-2 text-sm transition-colors duration-200 hover:bg-gray-700">
                            <i class='bx bxs-file-plus text-lg'></i><span x-show="open">Tambah Baru</span>
                        </a>
                    </div>
                </div>
                
                <!-- 7. Joint Supervision Dropdown -->
                <div x-data="{ dropdownOpen: {{ request()->routeIs('admin_equity.supervision.*') ? 'true' : 'false' }} }">
                    <button @click="dropdownOpen = !dropdownOpen" class="flex w-full items-center justify-between space-x-3 rounded-md p-2 transition-colors duration-200 hover:bg-gray-700">
                        <div class="flex items-center space-x-3">
                            <i class='bx bxs-graduation text-xl'></i>
                            <span x-show="open" class="whitespace-nowrap">Joint Supervision</span>
                        </div>
                        <i x-show="open" class='bx bx-chevron-down transition-transform duration-300' :class="{'rotate-180': dropdownOpen}"></i>
                    </button>
                    <div x-show="dropdownOpen" x-collapse class="pt-1 pl-5">
                        <a href="{{ route('admin_equity.supervision.index') }}" class="flex items-center space-x-3 rounded-md p-2 text-sm transition-colors duration-200 {{ request()->routeIs('admin_equity.supervision.index') ? 'bg-[#0D9488] font-semibold text-white' : 'hover:bg-gray-700' }}">
                            <i class='bx bx-list-ul text-lg'></i><span x-show="open">Daftar</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 rounded-md p-2 text-sm transition-colors duration-200 hover:bg-gray-700">
                            <i class='bx bxs-file-plus text-lg'></i><span x-show="open">Tambah Baru</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <h3 x-show="open" class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-gray-400">Laporan</h3>
                <a href="#" class="flex items-center space-x-3 rounded-md p-2 transition-colors duration-200 hover:bg-gray-700">
                    <i class='bx bxs-report text-xl'></i>
                    <span x-show="open" class="whitespace-nowrap">Laporan</span>
                </a>
            </div>

        </nav>

        <div class="border-t border-gray-700 py-2 px-2">
            <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar">
                @csrf
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"
                   class="flex items-center space-x-3 rounded-md p-2 transition-colors duration-200 hover:bg-red-600 hover:text-white">
                    <i class='bx bxs-log-out-circle text-xl'></i>
                    <span x-show="open" class="whitespace-nowrap">Logout</span>
                </a>
            </form>
        </div>
    </div>
</div>

