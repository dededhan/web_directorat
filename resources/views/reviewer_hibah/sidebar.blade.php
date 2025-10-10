<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-purple-600 to-purple-800 text-white transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 shadow-2xl"
       x-data="{ hibahModulOpen: false }">
    
    <div class="flex items-center justify-between h-16 px-6 border-b border-purple-500/30">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                <i class='bx bxs-book-reader text-2xl text-white'></i>
            </div>
            <span class="text-lg font-bold">Reviewer Hibah</span>
        </div>
        <button @click="sidebarOpen = false" class="lg:hidden text-white hover:bg-white/10 p-2 rounded-lg transition-colors">
            <i class='bx bx-x text-2xl'></i>
        </button>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <!-- Dashboard -->
        <a href="{{ route('reviewer_hibah.dashboard') }}"
           class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('reviewer_hibah.dashboard') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}">
            <i class='bx bx-home-alt text-xl'></i>
            <span class="font-medium">Dashboard</span>
        </a>

        <!-- Hibah Modul Ajar -->
        <div x-data="{ open: {{ request()->routeIs('reviewer_hibah.hibah_modul.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/10"
                    :class="open ? 'bg-white/20' : ''">
                <div class="flex items-center space-x-3">
                    <i class='bx bx-book-content text-xl'></i>
                    <span class="font-medium">Hibah Modul Ajar</span>
                </div>
                <i class='bx bx-chevron-down text-xl transition-transform duration-200' :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-collapse class="ml-4 mt-2 space-y-1">
                <a href="{{ route('reviewer_hibah.hibah_modul.index') }}"
                   class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('reviewer_hibah.hibah_modul.index') || request()->routeIs('reviewer_hibah.hibah_modul.show') ? 'bg-white/20' : 'hover:bg-white/10' }}">
                    <i class='bx bx-list-ul'></i>
                    <span>Daftar Review</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="p-4 border-t border-purple-500/30">
        <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                    <i class='bx bx-user text-xl'></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-purple-200">Reviewer Hibah</p>
                </div>
            </div>
        </div>
    </div>
</aside>
