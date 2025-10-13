@php
    $isUserInactive = Auth::user()->status === 'unactive';
@endphp

<div x-data="{
        open: window.innerWidth >= 1024,
        mobileOpen: false,
        inovasiOpen: {{ request()->routeIs('subdirektorat-inovasi.registered_user.tablekatsinov') || request()->routeIs('subdirektorat-inovasi.registered_user.form') ? 'true' : 'false' }},
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
             'pointer-events-none opacity-50': {{ $isUserInactive ? 'true' : 'false' }},
             '-translate-x-full lg:translate-x-0': !mobileOpen && window.innerWidth < 1024,
             'translate-x-0': mobileOpen || window.innerWidth >= 1024,
             'w-80': open || (mobileOpen && window.innerWidth < 1024),
             'w-20': !open && !mobileOpen && window.innerWidth >= 1024
         }">

        <div class="flex h-16 flex-shrink-0 items-center justify-between border-b border-gray-700 px-6">
            <a href="#" class="flex items-center space-x-3 overflow-hidden" x-show="open || mobileOpen">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-teal-400 to-teal-600 shadow-lg">
                    <i class='bx bxs-user text-xl text-white'></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-bold">Registered User</span>
                    <span class="text-xs text-gray-400">Dashboard System</span>
                </div>
            </a>
            <button @click="open = !open" class="hidden rounded-md p-2 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none lg:block"><i class='bx bx-menu text-2xl'></i></button>
            <button @click="toggleMobile()" class="rounded-md p-2 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none lg:hidden"><i class='bx bx-x text-2xl'></i></button>
        </div>

        <nav class="flex-1 space-y-3 py-6 px-4 overflow-y-auto">
            @if ($isUserInactive)
                {{-- Warning untuk user inactive --}}
                <div class="mx-3 mb-4 rounded-xl border-2 border-amber-500 bg-amber-50 p-4">
                    <div class="flex items-start gap-3">
                        <i class='bx bxs-error-circle text-2xl text-amber-600 flex-shrink-0'></i>
                        <div>
                            <p class="text-sm font-bold text-amber-900">Akun Belum Aktif</p>
                            <p class="mt-1 text-xs text-amber-800">Silakan hubungi admin untuk mengaktifkan akun Anda.</p>
                        </div>
                    </div>
                </div>
            @endif

            <div>
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Main Menu</h3>
                <a href="{{ $isUserInactive ? '#' : route('subdirektorat-inovasi.registered_user.dashboard') }}" 
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.registered_user.dashboard') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} {{ $isUserInactive ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}" 
                   :class="{'justify-center': !open && !mobileOpen}"
                   @if($isUserInactive) title="Akun belum aktif" @endif>
                   <i class='bx bxs-dashboard text-2xl flex-shrink-0'></i>
                   <span x-show="open || mobileOpen" class="font-medium">Dashboard</span>
                </a>
            </div>

            <div class="pt-3">
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Inovasi</h3>
                <button @click="inovasiOpen = !inovasiOpen" 
                        class="flex w-full items-center rounded-lg p-3 transition-colors duration-200 hover:bg-gray-700 group {{ $isUserInactive ? 'opacity-50 cursor-not-allowed' : '' }}" 
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'"
                        :disabled="{{ $isUserInactive ? 'true' : 'false' }}"
                        @if($isUserInactive) title="Akun belum aktif" @endif>
                    <div class="flex items-center space-x-4">
                        <i class='bx bxs-bulb text-2xl flex-shrink-0'></i>
                        <span x-show="open || mobileOpen" class="font-medium">Katsinov</span>
                    </div>
                    <div x-show="open || mobileOpen" class="flex items-center">
                        <i class='bx bx-chevron-down text-2xl transition-transform duration-300' :class="{'rotate-180': inovasiOpen}"></i>
                    </div>
                </button>
                <div x-show="inovasiOpen && (open || mobileOpen)" x-collapse class="mt-2 ml-3 space-y-1">
                    <a href="{{ $isUserInactive ? '#' : route('subdirektorat-inovasi.registered_user.tablekatsinov') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.registered_user.tablekatsinov') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4 {{ $isUserInactive ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}"
                       @if($isUserInactive) title="Akun belum aktif" @endif>
                        <i class='bx bxs-table text-2xl flex-shrink-0'></i>
                        <span>Tabel Katsinov</span>
                    </a>
                    <a href="{{ $isUserInactive ? '#' : route('subdirektorat-inovasi.registered_user.form') }}" 
                       class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors duration-200 {{ request()->routeIs('subdirektorat-inovasi.registered_user.form') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4 {{ $isUserInactive ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}"
                       @if($isUserInactive) title="Akun belum aktif" @endif>
                        <i class='bx bxs-file-plus text-2xl flex-shrink-0'></i>
                        <span>Form Katsinov</span>
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
