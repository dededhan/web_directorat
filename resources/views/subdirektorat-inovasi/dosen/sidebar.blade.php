<div x-data="{
        open: true,
        mobileOpen: false,
        inovasiOpen: {{ request()->routeIs('subdirektorat-inovasi.dosen.tablekatsinov') || request()->routeIs('subdirektorat-inovasi.dosen.form') ? 'true' : 'false' }},
        equityOpen: {{ request()->routeIs('subdirektorat-inovasi.dosen.equity.*') ? 'true' : 'false' }},
        pengaturanOpen: {{ request()->routeIs('subdirektorat-inovasi.dosen.manageprofile.*') ? 'true' : 'false' }}
     }"
     @window.toggle-sidebar.document="mobileOpen = !mobileOpen">

    <div x-show="mobileOpen" @click="mobileOpen = false" class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden" style="display: none;"></div>

    <div class="fixed inset-y-0 left-0 z-30 flex h-full transform flex-col bg-gray-800 text-gray-200 shadow-lg transition-all duration-300 ease-in-out lg:relative lg:transform-none"
         :class="{
             '-translate-x-full': !mobileOpen,
             'translate-x-0': mobileOpen,
             'w-80': open,
             'w-20': !open
         }">

        <div class="flex h-16 flex-shrink-0 items-center justify-between border-b border-gray-700 px-6">
            <a href="#" class="flex items-center space-x-3 overflow-hidden" x-show="open">
                <i class='bx bxs-graduation text-2xl text-teal-400'></i>
                <span class="text-xl font-bold">Dosen UNJ</span>
            </a>
            <button @click="open = !open" class="hidden rounded-md p-2 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none lg:block">
                <i class='bx bx-menu text-2xl'></i>
            </button>
            <button @click="mobileOpen = false" class="rounded-md p-2 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none lg:hidden">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>

        <nav class="flex-1 space-y-3 py-6 px-4">

            <div>
                <h3 x-show="open" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Main Menu</h3>
                <a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.dashboard') ? 'bg-[#0D9488] font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}">
                    <i class='bx bxs-dashboard text-2xl'></i>
                    <span x-show="open" class="font-medium">Dashboard</span>
                </a>
            </div>
            
            {{-- NEW SECTION FOR PROFILE MANAGEMENT --}}
            <div class="pt-3">
                <h3 x-show="open" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Pengaturan Akun</h3>
                 <a href="{{ route('subdirektorat-inovasi.dosen.manageprofile.edit') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.manageprofile.edit') ? 'bg-[#0D9488] font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}">
                    <i class='bx bxs-user-circle text-2xl'></i>
                    <span x-show="open" class="font-medium">Manajemen Profil</span>
                </a>
            </div>

            <div class="pt-3">
                <h3 x-show="open" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Inovasi</h3>
                <button @click="inovasiOpen = !inovasiOpen" class="flex w-full items-center justify-between rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700 group">
                    <div class="flex items-center space-x-4">
                        <i class='bx bxs-bulb text-2xl'></i>
                        <span x-show="open" class="font-medium">Katsinov</span>
                    </div>
                    <div x-show="open" class="flex items-center">
                        <i class='bx bx-chevron-down text-2xl transition-transform duration-300' :class="{'rotate-180': inovasiOpen}"></i>
                    </div>
                </button>
                <div x-show="inovasiOpen" x-collapse class="mt-2 ml-3 space-y-1" style="display: none;">
                    <a href="{{ route('subdirektorat-inovasi.dosen.tablekatsinov') }}"
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.tablekatsinov') ? 'bg-[#0D9488] font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bx-table text-2xl'></i>
                        <span x-show="open">Tabel Katsinov</span>
                    </a>
                    <a href="{{ route('subdirektorat-inovasi.dosen.form') }}"
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.form') ? 'bg-[#0D9488] font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-file-plus text-2xl'></i>
                        <span x-show="open">Form Katsinov</span>
                    </a>
                </div>
            </div>

            <div class="pt-3">
                <h3 x-show="open" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Equity</h3>
                <button @click="equityOpen = !equityOpen" class="flex w-full items-center justify-between rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700 group">
                    <div class="flex items-center space-x-4">
                        <i class='bx bxs-briefcase-alt-2 text-2xl'></i>
                        <span x-show="open" class="font-medium">Community Development</span>
                    </div>
                    <div x-show="open" class="flex items-center">
                        <i class='bx bx-chevron-down text-2xl transition-transform duration-300' :class="{'rotate-180': equityOpen}"></i>
                    </div>
                </button>
                <div x-show="equityOpen" x-collapse class="mt-2 ml-3 space-y-1" style="display: none;">
                    <a href="{{ route('subdirektorat-inovasi.dosen.equity.manajement.index') }}"
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.equity.manajement.index') ? 'bg-[#0D9488] font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-folder-open text-2xl'></i>
                        <span x-show="open">Manajemen Proposal</span>
                    </a>
                    <a href="{{ route('subdirektorat-inovasi.dosen.equity.usulkan-proposal.index') }}"
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.equity.usulkan-proposal.*') ? 'bg-[#0D9488] font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-file-plus text-2xl'></i>
                        <span x-show="open">Usulkan Proposal</span>
                    </a>
                </div>
            </div>

        </nav>

        <div class="border-t border-gray-700 py-4 px-4">
            <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar">
                @csrf
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 hover:bg-red-600 hover:text-white">
                    <i class='bx bxs-log-out-circle text-2xl'></i>
                    <span x-show="open" class="font-medium">Logout</span>
                </a>
            </form>
        </div>
    </div>
</div>
