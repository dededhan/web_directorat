
<div x-data="{ 
        open: true, 
        inovasiOpen: {{ request()->routeIs('subdirektorat-inovasi.dosen.tablekatsinov') || request()->routeIs('subdirektorat-inovasi.dosen.form') ? 'true' : 'false' }} 
     }" 
     class="flex flex-col bg-gray-800 text-white transition-all duration-300 ease-in-out"
     :class="open ? 'w-64' : 'w-20'">


    <div class="flex items-center justify-between h-16 px-4 border-b border-gray-700">
        <a href="#" class="flex items-center space-x-2" x-show="open">
            <i class='bx bxs-graduation text-2xl text-teal-400'></i>
            <span class="font-bold text-lg">Dosen UNJ</span>
        </a>
        <button @click="open = !open" class="p-2 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700">
            <i class='bx bx-menu text-2xl'></i>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 py-4 px-2 space-y-2">
        <h3 x-show="open" class="px-4 text-xs text-gray-400 uppercase tracking-wider">Main Menu</h3>
        
        <a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}"
           class="flex items-center p-2 space-x-3 rounded-md hover:bg-gray-700 {{ request()->routeIs('subdirektorat-inovasi.dosen.dashboard') ? 'bg-gray-900' : '' }}">
            <i class='bx bxs-dashboard text-xl'></i>
            <span x-show="open">Dashboard</span>
        </a>

                <div class="pt-2">
            <h3 x-show="open" class="px-4 text-xs text-gray-400 uppercase tracking-wider">Inovasi</h3>
            <div x-data="{}" class="space-y-1">
                <button @click="inovasiOpen = !inovasiOpen" class="w-full flex items-center justify-between p-2 space-x-3 rounded-md hover:bg-gray-700">
                    <div class="flex items-center space-x-3">
                        <i class='bx bxs-bulb text-xl'></i>
                        <span x-show="open">Katsinov</span>
                    </div>
                    <i x-show="open" class='bx bx-chevron-down transition-transform' :class="{'rotate-180': inovasiOpen}"></i>
                </button>

                <div x-show="inovasiOpen" x-collapse class="pl-5">
                    <ul class="flex flex-col space-y-1 mt-1">
                        <li>
                            <a href="{{ route('subdirektorat-inovasi.dosen.tablekatsinov') }}"
                               class="flex items-center p-2 space-x-3 rounded-md hover:bg-gray-700 text-sm {{ request()->routeIs('subdirektorat-inovasi.dosen.tablekatsinov') ? 'bg-gray-900' : '' }}">
                                <i class='bx bx-table text-lg'></i>
                                <span x-show="open">Tabel Katsinov</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('subdirektorat-inovasi.dosen.form') }}"
                               class="flex items-center p-2 space-x-3 rounded-md hover:bg-gray-700 text-sm {{ request()->routeIs('subdirektorat-inovasi.dosen.form') ? 'bg-gray-900' : '' }}">
                                <i class='bx bxs-file-plus text-lg'></i>
                                <span x-show="open">Form Katsinov</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="pt-2">
            <h3 x-show="open" class="px-4 text-xs text-gray-400 uppercase tracking-wider">MANAJEMEN</h3>
            <div class="space-y-1">
                <a href="{{ route('subdirektorat-inovasi.dosen.equity.index') }}"
                   class="flex items-center p-2 space-x-3 rounded-md hover:bg-gray-700 {{ request()->routeIs('subdirektorat-inovasi.dosen.equity.*') ? 'bg-blue-600' : '' }}">
                    <i class='bx bxs-file-doc text-xl'></i>
                    <span x-show="open">Manajemen Proposal</span>
                </a>
                <a href="#"
                   class="flex items-center p-2 space-x-3 rounded-md hover:bg-gray-700">
                    <i class='bx bx-check-square text-xl'></i>
                    <span x-show="open">Usulkan Proposal</span>
                </a>
                <a href="#"
                   class="flex items-center p-2 space-x-3 rounded-md hover:bg-gray-700">
                    <i class='bx bxs-briefcase text-xl'></i>
                    <span x-show="open">Portofolio</span>
                </a>
                <a href="#"
                   class="flex items-center p-2 space-x-3 rounded-md hover:bg-gray-700">
                    <i class='bx bxs-group text-xl'></i>
                    <span x-show="open">Mendaftar Reviewer</span>
                </a>
            </div>
        </div>

        <div class="pt-2">
            <h3 x-show="open" class="px-4 text-xs text-gray-400 uppercase tracking-wider">DATA PENDUKUNG</h3>
            <div class="space-y-1">
                <a href="#"
                   class="flex items-center p-2 space-x-3 rounded-md hover:bg-gray-700">
                    <i class='bx bxs-megaphone text-xl'></i>
                    <span x-show="open">Pengumuman</span>
                </a>
            </div>
        </div>

        <div class="pt-2">
            <h3 x-show="open" class="px-4 text-xs text-gray-400 uppercase tracking-wider">DATA REFERENSI</h3>
            <div class="space-y-1">
                <a href="#"
                   class="flex items-center p-2 space-x-3 rounded-md hover:bg-gray-700">
                    <i class='bx bxs-file-doc text-xl'></i>
                    <span x-show="open">Tahap Penilaian</span>
                </a>
            </div>
        </div>
        

        <!-- Spacer -->
        <div class="flex-grow"></div>

        <!-- Settings Section at the bottom -->
        <div class="pt-4 border-t border-gray-700">
            <h3 x-show="open" class="px-4 text-xs text-gray-400 uppercase tracking-wider">Settings</h3>
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="flex items-center p-2 space-x-3 rounded-md hover:bg-gray-700">
                    <i class='bx bxs-log-out-circle text-xl'></i>
                    <span x-show="open">Logout</span>
                </a>
            </form>
        </div>
    </nav>
</div>
