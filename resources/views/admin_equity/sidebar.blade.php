<div x-data="{
        open: window.innerWidth >= 1024,
        mobileOpen: false,
        comdevOpen: {{ request()->routeIs('admin_equity.comdev.*') ? 'true' : 'false' }},
        incentiveOpen: {{ request()->routeIs('admin_equity.incentive*') || request()->routeIs('admin_equity.scopus.*') ? 'true' : 'false' }},
        pengaturanOpen: {{ request()->routeIs('admin_equity.manageuser.*') ? 'true' : 'false' }},
        init() {
            this.$watch('mobileOpen', value => {
                if (value) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            });
        }
     }"
     @resize.window="open = window.innerWidth >= 1024"
     @toggle-sidebar.window="mobileOpen = !mobileOpen"
     @keydown.escape.window="mobileOpen = false"
     class="relative">

    <div x-show="mobileOpen" 
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileOpen = false" 
         class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
         style="display: none;"></div>

    <div class="fixed inset-y-0 left-0 z-50 flex h-full transform flex-col bg-gray-800 text-gray-200 shadow-lg transition-all duration-300 ease-in-out lg:relative lg:transform-none lg:z-30 lg:mt-0"
         :class="{
             '-translate-x-full': !mobileOpen && window.innerWidth < 1024,
             'translate-x-0': mobileOpen || window.innerWidth >= 1024,
             'w-80': open || (mobileOpen && window.innerWidth < 1024),
             'w-20': !open && !mobileOpen && window.innerWidth >= 1024
         }">

        <div class="flex h-16 flex-shrink-0 items-center justify-between border-b border-gray-700 px-6">
            <a href="#" class="flex items-center space-x-3 overflow-hidden" x-show="open || mobileOpen">
                <i class='bx bxs-briefcase-alt-2 text-2xl text-teal-400'></i>
                <div class="flex flex-col">
                    <span class="text-xl font-bold">Admin Equity</span>
                    <span class="text-xs text-gray-400">Management System</span>
                </div>
            </a>
            
            <button @click="open = !open" 
                    class="hidden rounded-md p-2 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none lg:block">
                <i class='bx bx-menu text-2xl'></i>
            </button>
            
            <button @click="mobileOpen = false" 
                    class="rounded-md p-2 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none lg:hidden">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>

        <nav class="flex-1 space-y-3 py-6 px-4 overflow-y-auto">

            <div>
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Main Menu</h3>
                <a href="{{ route('admin_equity.dashboard') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin_equity.dashboard') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}">
                    <i class='bx bxs-dashboard text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Dashboard</span>
                </a>
            </div>

            <div class="pt-3">
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Equity Programs</h3>
                
                <button @click="comdevOpen = !comdevOpen" 
                        class="flex w-full items-center justify-between rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700 group">
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

                <a href="{{ route('admin_equity.apc.index') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin_equity.apc.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}">
                    <i class='bx bxs-file-doc text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Article Processing Cost</span>
                </a>

                <button @click="incentiveOpen = !incentiveOpen" 
                        class="flex w-full items-center justify-between rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700 group">
                    <div class="flex items-center space-x-4">
                        <i class='bx bxs-award text-2xl flex-shrink-0'></i>
                        <span x-show="open || mobileOpen" class="font-medium">Insentif</span>
                    </div>
                    <div x-show="open || mobileOpen" class="flex items-center">
                        <i class='bx bx-chevron-down text-2xl transition-transform duration-300' 
                           :class="{'rotate-180': incentiveOpen}"></i>
                    </div>
                </button>
                
                <div x-show="incentiveOpen && (open || mobileOpen)" x-collapse class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('admin_equity.incentivereviewer.index') }}"
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin_equity.incentive.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-award text-2xl flex-shrink-0'></i>
                        <span>Insentif Reviewer</span>
                    </a>
                    <a href="{{ route('admin_equity.incentiveeditor.index') }}"
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('admin_equity.scopus.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4">
                        <i class='bx bxs-badge-check text-2xl flex-shrink-0'></i>
                        <span>Insentif Editorial Board</span>
                    </a>
                </div>

                <a href="{{ route('admin_equity.conference.index') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin_equity.conference.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}">
                    <i class='bx bx-globe text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Presenting at international conferences</span>
                </a>

                <a href="{{ route('admin_equity.matchresearch.index') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin_equity.visiting.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}">
                    <i class='bx bxs-user-voice text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Match research interest</span>
                </a>
            </div>

            <div class="pt-3">
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Pengaturan</h3>
                <a href="{{ route('admin_equity.manageuser.index') }}"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('admin_equity.manageuser.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}">
                    <i class='bx bxs-user-account text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Manajemen Pengguna</span>
                </a>
            </div>

        </nav>

        <div class="border-t border-gray-700 py-4 px-4">
            <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar">
                @csrf
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 hover:bg-red-600 hover:text-white">
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
    window.toggleSidebar = function() {
        window.dispatchEvent(new CustomEvent('toggle-sidebar'));
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