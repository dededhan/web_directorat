<div x-data="{
        open: window.innerWidth >= 1024,
        mobileOpen: false,
        inovasiOpen: {{ request()->routeIs('subdirektorat-inovasi.dosen.tablekatsinov') || request()->routeIs('subdirektorat-inovasi.dosen.form') ? 'true' : 'false' }},
        equityOpen: {{ request()->routeIs('subdirektorat-inovasi.dosen.equity.*') ? 'true' : 'false' }},
        apcOpen: {{ request()->routeIs('subdirektorat-inovasi.dosen.apc.*') ? 'true' : 'false' }},
        matchmakingOpen: {{ request()->routeIs('subdirektorat-inovasi.dosen.matchresearch.*') ? 'true' : 'false' }},
        pengaturanOpen: {{ request()->routeIs('subdirektorat-inovasi.dosen.manageprofile.*') ? 'true' : 'false' }},
        init() {
            this.$watch('mobileOpen', value => {
                if (value) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            });
            
            // Global function untuk toggle dari luar
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

    <button type="button" 
            @click="toggleMobile()"
            x-show="!mobileOpen"
            class="fixed top-4 left-4 z-50 inline-flex items-center justify-center rounded-md p-2 text-gray-600 bg-white shadow-lg hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-teal-500 lg:hidden">
        <span class="sr-only">Open sidebar</span>
        <i class='bx bx-menu text-xl'></i>
    </button>

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

    <div x-show="mobileOpen || window.innerWidth >= 1024"
         class="fixed inset-y-0 left-0 z-40 flex h-full transform flex-col bg-gray-800 text-gray-200 shadow-lg transition-all duration-300 ease-in-out lg:relative lg:transform-none lg:z-30 lg:mt-0"
         :class="{
             '-translate-x-full lg:translate-x-0': !mobileOpen && window.innerWidth < 1024,
             'translate-x-0': mobileOpen || window.innerWidth >= 1024,
             'w-80': open || (mobileOpen && window.innerWidth < 1024),
             'w-20': !open && !mobileOpen && window.innerWidth >= 1024
         }">

        <div class="flex h-16 flex-shrink-0 items-center justify-between border-b border-gray-700 px-6">
            <a href="#" class="flex items-center space-x-3 overflow-hidden" x-show="open || mobileOpen">
                <i class='bx bxs-graduation text-2xl text-teal-400'></i>
                <div class="flex flex-col">
                    <span class="text-xl font-bold">Dosen UNJ</span>
                    <span class="text-xs text-gray-400">Academic System</span>
                </div>
            </a>
            
            <button @click="open = !open" 
                    class="hidden rounded-md p-2 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none lg:block">
                <i class='bx bx-menu text-2xl'></i>
            </button>
            
            <button @click="toggleMobile()" 
                    class="rounded-md p-2 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none lg:hidden">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>

        <nav class="flex-1 space-y-3 py-6 px-4 overflow-y-auto">

            <div>
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Main Menu</h3>
                <a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.dashboard') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}"
                   :class="{'justify-center': !open && !mobileOpen}"> <i class='bx bxs-dashboard text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Dashboard</span>
                </a>
            </div>
            
            <div class="pt-3">
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Pengaturan Akun</h3>
                <a href="{{ route('subdirektorat-inovasi.dosen.manageprofile.edit') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.manageprofile.edit') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}"
                   :class="{'justify-center': !open && !mobileOpen}"> <i class='bx bxs-user-circle text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Manajemen Profil</span>
                </a>
            </div>

            <div class="pt-3">
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Inovasi</h3>
                
                <button @click="inovasiOpen = !inovasiOpen" 
                        class="flex w-full items-center rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700 group"
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'"> <div class="flex items-center space-x-4">
                        <i class='bx bxs-bulb text-2xl flex-shrink-0'></i>
                        <span x-show="open || mobileOpen" class="font-medium">Katsinov</span>
                    </div>
                    <div x-show="open || mobileOpen" class="flex items-center">
                        <i class='bx bx-chevron-down text-2xl transition-transform duration-300' 
                           :class="{'rotate-180': inovasiOpen}"></i>
                    </div>
                </button>
                
                <div x-show="inovasiOpen && (open || mobileOpen)" x-collapse class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('subdirektorat-inovasi.dosen.tablekatsinov') }}"
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.tablekatsinov') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bx-table text-2xl flex-shrink-0'></i>
                        <span>Tabel Katsinov</span>
                    </a>
                    <a href="{{ route('subdirektorat-inovasi.dosen.form') }}"
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.form') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-file-plus text-2xl flex-shrink-0'></i>
                        <span>Form Katsinov</span>
                    </a>
                </div>
            </div>

            <div class="pt-3">
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Equity</h3>
                
                <button @click="equityOpen = !equityOpen" 
                        class="flex w-full items-center rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700 group"
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'"> <div class="flex items-center space-x-4">
                        <i class='bx bxs-briefcase-alt-2 text-2xl flex-shrink-0'></i>
                        <span x-show="open || mobileOpen" class="font-medium">Community Development</span>
                    </div>
                    <div x-show="open || mobileOpen" class="flex items-center">
                        <i class='bx bx-chevron-down text-2xl transition-transform duration-300' 
                           :class="{'rotate-180': equityOpen}"></i>
                    </div>
                </button>
                
                <div x-show="equityOpen && (open || mobileOpen)" x-collapse class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('subdirektorat-inovasi.dosen.equity.manajement.index') }}"
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.equity.manajement.index') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-folder-open text-2xl flex-shrink-0'></i>
                        <span>Manajemen Proposal</span>
                    </a>
                    <a href="{{ route('subdirektorat-inovasi.dosen.equity.usulkan-proposal.index') }}"
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.equity.usulkan-proposal.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-file-plus text-2xl flex-shrink-0'></i>
                        <span>Usulkan Proposal</span>
                    </a>
                </div>

                <!-- AWAL DARI BAGIAN APC YANG BARU -->
                <button @click="apcOpen = !apcOpen"
                        class="flex w-full items-center rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700 group mt-2"
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'">
                    <div class="flex items-center space-x-4">
                        <i class='bx bxs-file-doc text-2xl flex-shrink-0'></i>
                        <span x-show="open || mobileOpen" class="font-medium">Article Processing Cost</span>
                    </div>
                    <div x-show="open || mobileOpen" class="flex items-center">
                        <i class='bx bx-chevron-down text-2xl transition-transform duration-300'
                           :class="{'rotate-180': apcOpen}"></i>
                    </div>
                </button>
                
                <div x-show="apcOpen && (open || mobileOpen)" x-collapse class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('subdirektorat-inovasi.dosen.apc.manajemen') }}"
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.apc.manajemen') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-folder-open text-2xl flex-shrink-0'></i>
                        <span>Manajemen Proposal</span>
                    </a>
                    <a href="{{ route('subdirektorat-inovasi.dosen.apc.list-sesi') }}"
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.apc.list-sesi') || request()->routeIs('subdirektorat-inovasi.dosen.apc.form') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-file-plus text-2xl flex-shrink-0'></i>
                        <span>Usulkan Proposal</span>
                    </a>
                </div>
                <!-- AKHIR DARI BAGIAN APC YANG BARU -->


                                <button @click="matchmakingOpen = !matchmakingOpen"
                        class="flex w-full items-center rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700 group mt-2"
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'">
                    <div class="flex items-center space-x-4">
                        <i class='bx bx-user-voice text-2xl flex-shrink-0'></i>
                        <span x-show="open || mobileOpen" class="font-medium">Matchmaking Riset</span>
                    </div>
                    <div x-show="open || mobileOpen" class="flex items-center">
                        <i class='bx bx-chevron-down text-2xl transition-transform duration-300'
                           :class="{'rotate-180': matchmakingOpen}"></i>
                    </div>
                </button>
                
                <div x-show="matchmakingOpen && (open || mobileOpen)" x-collapse class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.manajemen') }}"
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.matchresearch.manajemen') ? 'bg-teal-600 font-semibold text-white' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-folder-open text-2xl flex-shrink-0'></i>
                        <span>Manajemen Proposal</span>
                    </a>
                    <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.list-sesi') }}"
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.dosen.matchresearch.list-sesi') || request()->routeIs('subdirektorat-inovasi.dosen.matchresearch.form') ? 'bg-teal-600 font-semibold text-white' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-file-plus text-2xl flex-shrink-0'></i>
                        <span>Usulkan Proposal</span>
                    </a>
                </div>
            </div>

        </nav>

        <div class="border-t border-gray-700 py-4 px-4">
            <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar">
                @csrf
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 hover:bg-red-600 hover:text-white"
                   :class="{'justify-center': !open && !mobileOpen}"> <i class='bx bxs-log-out-circle text-2xl flex-shrink-0'></i>
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
