<div x-data="{ 
        open: true, 
        mobileOpen: false,
        inovasiOpen: {{ request()->routeIs('subdirektorat-inovasi.dosen.tablekatsinov') || request()->routeIs('subdirektorat-inovasi.dosen.form') ? 'true' : 'false' }} 
     }"
     @window.toggle-sidebar.document="mobileOpen = !mobileOpen">

    <div x-show="mobileOpen" @click="mobileOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden" style="display: none;"></div>

    <div class="flex flex-col h-full bg-gray-800 text-gray-200 shadow-lg transition-all duration-300 ease-in-out fixed lg:relative inset-y-0 left-0 z-30 transform lg:transform-none"
         :class="{
            '-translate-x-full': !mobileOpen, 
            'translate-x-0': mobileOpen,
            'w-64': open,
            'w-20': !open
         }">

        <div class="flex items-center justify-between h-16 px-4 border-b border-gray-700 flex-shrink-0">
            <a href="#" class="flex items-center space-x-2 overflow-hidden" x-show="open">
                <i class='bx bxs-graduation text-3xl text-teal-400'></i>
                <span class="font-bold text-lg whitespace-nowrap">Dosen UNJ</span>
            </a>
            <button @click="open = !open" class="p-2 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700 hidden lg:block">
                <i class='bx bx-menu text-2xl'></i>
            </button>
            <button @click="mobileOpen = false" class="p-2 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700 lg:hidden">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>

        <nav class="flex-1 py-4 px-2 space-y-2 overflow-y-auto">
            
            <div>
                <h3 x-show="open" class="px-3 pb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Main Menu</h3>
                <a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}"
                   class="flex items-center p-2 space-x-3 rounded-md transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.dashboard') ? 'bg-teal-600 text-white font-semibold' : 'hover:bg-gray-700' }}">
                    <i class='bx bxs-dashboard text-xl'></i>
                    <span x-show="open" class="whitespace-nowrap">Dashboard</span>
                </a>
            </div>
            
            <div class="pt-2">
                <h3 x-show="open" class="px-3 pb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Inovasi</h3>
                <button @click="inovasiOpen = !inovasiOpen" class="w-full flex items-center justify-between p-2 space-x-3 rounded-md transition-colors duration-200 hover:bg-gray-700">
                    <div class="flex items-center space-x-3">
                        <i class='bx bxs-bulb text-xl'></i>
                        <span x-show="open" class="whitespace-nowrap">Katsinov</span>
                    </div>
                    <i x-show="open" class='bx bx-chevron-down transition-transform duration-300' :class="{'rotate-180': inovasiOpen}"></i>
                </button>
                <div x-show="inovasiOpen" x-collapse class="pl-5 pt-1" style="display: none;">
                    <a href="{{ route('subdirektorat-inovasi.dosen.tablekatsinov') }}"
                       class="flex items-center p-2 space-x-3 rounded-md text-sm transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.tablekatsinov') ? 'bg-gray-900 font-medium' : 'hover:bg-gray-700' }}">
                        <i class='bx bx-table text-lg'></i>
                        <span x-show="open">Tabel Katsinov</span>
                    </a>
                    <a href="{{ route('subdirektorat-inovasi.dosen.form') }}"
                       class="flex items-center p-2 space-x-3 rounded-md text-sm transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.form') ? 'bg-gray-900 font-medium' : 'hover:bg-gray-700' }}">
                        <i class='bx bxs-file-plus text-lg'></i>
                        <span x-show="open">Form Katsinov</span>
                    </a>
                </div>
            </div>

            <div class="pt-2">
                <h3 x-show="open" class="px-3 pb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Manajemen</h3>
                <div class="space-y-1">
                    <a href="{{ route('subdirektorat-inovasi.dosen.equity.index') }}"
                       class="flex items-center p-2 space-x-3 rounded-md transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.equity.index') ? 'bg-sky-600 text-white font-semibold' : 'hover:bg-gray-700' }}">
                        <i class='bx bxs-file-doc text-xl'></i>
                        <span x-show="open" class="whitespace-nowrap">Manajemen Proposal</span>
                    </a>
                    <a href="{{ route('subdirektorat-inovasi.dosen.equity.usulkan-proposal') }}"
                        class="flex items-center p-2 space-x-3 rounded-md transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.equity.usulkan-proposal') ? 'bg-sky-600 text-white font-semibold' : 'hover:bg-gray-700' }}">
                        <i class='bx bx-check-square text-xl'></i>
                        <span x-show="open" class="whitespace-nowrap">Usulkan Proposal</span>
                    </a>
                    <a href="{{ route('subdirektorat-inovasi.dosen.equity.portofolio') }}"
                        class="flex items-center p-2 space-x-3 rounded-md transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.equity.portofolio') ? 'bg-sky-600 text-white font-semibold' : 'hover:bg-gray-700' }}">
                        <i class='bx bxs-briefcase text-xl'></i>
                        <span x-show="open" class="whitespace-nowrap">Portofolio</span>
                    </a>
                    <a href="{{ route('subdirektorat-inovasi.dosen.equity.mendaftar-reviewer') }}"
                        class="flex items-center p-2 space-x-3 rounded-md transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.equity.mendaftar-reviewer') ? 'bg-sky-600 text-white font-semibold' : 'hover:bg-gray-700' }}">
                        <i class='bx bxs-group text-xl'></i>
                        <span x-show="open" class="whitespace-nowrap">Mendaftar Reviewer</span>
                    </a>
                    <a href="{{ route('subdirektorat-inovasi.dosen.equity.tahap-penilaian') }}"
                        class="flex items-center p-2 space-x-3 rounded-md transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.equity.tahap-penilaian') ? 'bg-sky-600 text-white font-semibold' : 'hover:bg-gray-700' }}">
                        <i class='bx bxs-file-doc text-xl'></i>
                        <span x-show="open" class="whitespace-nowrap">Tahap Penilaian</span>
                    </a>
                </div>
            </div>

            <div class="pt-2">
                <h3 x-show="open" class="px-3 pb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Data Pendukung</h3>
                <a href="#" class="flex items-center p-2 space-x-3 rounded-md transition-colors duration-200 hover:bg-gray-700">
                    <i class='bx bxs-megaphone text-xl'></i>
                    <span x-show="open" class="whitespace-nowrap">Pengumuman</span>
                </a>
            </div>

        </nav>

        <div class="py-2 px-2 border-t border-gray-700">
            <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar">
                @csrf
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"
                   class="flex items-center p-2 space-x-3 rounded-md transition-colors duration-200 hover:bg-red-600 hover:text-white">
                    <i class='bx bxs-log-out-circle text-xl'></i>
                    <span x-show="open" class="whitespace-nowrap">Logout</span>
                </a>
            </form>
        </div>
    </div>
</div>