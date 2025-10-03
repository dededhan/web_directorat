<div x-data="{
        open: window.innerWidth >= 1024,
        mobileOpen: false,
        comdevOpen: {{ request()->routeIs('admin_equity.comdev.*') ? 'true' : 'false' }},
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
         class="fixed inset-y-0 left-0 z-40 flex h-full transform flex-col bg-gray-800 text-gray-200 shadow-lg transition-all duration-300 ease-in-out lg:relative lg:transform-none lg:z-30 lg:mt-0"
         :class="{
             '-translate-x-full lg:translate-x-0': !mobileOpen && window.innerWidth < 1024,
             'translate-x-0': mobileOpen || window.innerWidth >= 1024,
             'w-80': open || (mobileOpen && window.innerWidth < 1024),
             'w-20': !open && !mobileOpen && window.innerWidth >= 1024
         }">

        <!-- Header -->
        <div class="flex h-16 flex-shrink-0 items-center justify-between border-b border-gray-700 px-6">
            <a href="#" class="flex items-center space-x-3 overflow-hidden" x-show="open || mobileOpen">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-teal-400 to-teal-600 shadow-lg">
                    <i class='bx bxs-briefcase-alt-2 text-xl text-white'></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-bold">Admin Equity</span>
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
                <a href="{{ route('admin_equity.dashboard') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin_equity.dashboard') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bxs-dashboard text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Dashboard</span>
                </a>
            </div>

            <!-- Equity Programs Section -->
            <div class="pt-3">
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Equity Programs</h3>
                
                <!-- 1. Community Development Dropdown -->
                <button @click="comdevOpen = !comdevOpen" 
                        class="flex w-full items-center rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700 group"
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'">
                    <div class="flex items-center space-x-4">
                        <i class='bx bxs-group text-2xl flex-shrink-0'></i>
                        <span x-show="open || mobileOpen" class="font-medium">Community Development</span>
                    </div>
                    <div x-show="open || mobileOpen" class="flex items-center">
                        <i class='bx bx-chevron-down text-2xl transition-transform duration-300' 
                           :class="{'rotate-180': comdevOpen}"></i>
                    </div>
                </button>
                
                <div x-show="comdevOpen && (open || mobileOpen)" x-collapse class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('admin_equity.comdev.index') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin_equity.comdev.index') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bx-list-ul text-2xl flex-shrink-0'></i>
                        <span>Management kegiatan</span>
                    </a>
                    <a href="#" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 hover:bg-gray-700 ml-4">
                        <i class='bx bxs-file-plus text-2xl flex-shrink-0'></i>
                        <span>Laporan</span>
                    </a>
                    @if(request()->routeIs('admin_equity.comdev.show') || request()->routeIs('admin_equity.comdev.submissions.*') || request()->routeIs('admin_equity.comdev.modules.*'))
                        @php
                            $currentSesi = request()->route('comdev');
                        @endphp
                        @if($currentSesi)
                            <a href="{{ route('admin_equity.comdev.modules.index', $currentSesi->id) }}" 
                               class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin_equity.comdev.modules.index') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                                <i class='bx bx-cog text-2xl flex-shrink-0'></i>
                                <span>Manajemen Modul</span>
                            </a>
                        @endif
                    @endif
                </div>

                <!-- 2. APC -->
                <a href="{{ route('admin_equity.apc.index') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin_equity.apc.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bxs-file-doc text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Article Processing Cost</span>
                </a>

                 <a href="{{ route('admin_equity.fee_reviewer.index') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin_equity.fee_reviewer.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bxs-award text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Fee Reviewer</span>
                </a>

                <a href="{{ route('admin_equity.fee_editor.index') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin_equity.fee_editor.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bxs-edit text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Fee Editor</span>
                </a>

                <!-- 3. Incentive -->
                <a href="{{ route('admin_equity.incentivereviewer.index') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin_equity.incentivereviewer.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bxs-award text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Insentif Reviewer</span>
                </a>

                <!-- 4. Scopus/WOS -->
                <a href="#"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bxs-badge-check text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Jurnal Scopus/WOS</span>
                </a>

                <!-- 5. Matchmaking Riset-->
                <a href="{{ route('admin_equity.matchresearch.index') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin_equity.matchresearch.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bx-user-voice text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Matchmaking Riset</span>
                </a>

                <!-- 6. Visiting Professors -->
                <a href="#"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bxs-user-voice text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Visiting Professors</span>
                </a>
                
                <!-- 7. Joint Supervision -->
                <a href="#"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bxs-graduation text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Joint Supervision</span>
                </a>
            </div>

            <!-- Settings Section -->
            <div class="pt-3">
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Pengaturan</h3>
                <a href="{{ route('admin_equity.manageuser.index') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700"
                   :class="{'justify-center': !open && !mobileOpen}">
                    <i class='bx bxs-user-account text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Manajemen Pengguna</span>
                </a>
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
