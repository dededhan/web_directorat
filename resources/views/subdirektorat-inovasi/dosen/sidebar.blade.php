@php
    // Cek apakah pengguna adalah dosen dan profilnya (khususnya NIP/NIDN) belum lengkap.
    // Auth::check() memastikan hanya berjalan jika user sudah login.
    $isProfileIncomplete = Auth::check() && 
                           Auth::user()->role === 'dosen' && 
                           !Auth::user()->profile?->prodi_id;
@endphp
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
            :disabled="$store.appState.isSubmitting"
            :class="{'opacity-50 pointer-events-none': $store.appState.isSubmitting}"
            class="fixed top-4 left-4 z-50 inline-flex items-center justify-center rounded-md p-2 text-gray-600 bg-white shadow-lg hover:bg-gray-100 focus:outline-none lg:hidden">
        <span class="sr-only">Open sidebar</span>
        <i class='bx bx-menu text-xl'></i>
    </button>

    <div x-show="mobileOpen" 
         @click="toggleMobile()"
         x-transition
         class="fixed inset-0 z-30 bg-black bg-opacity-50 lg:hidden"
         style="display: none;"></div>

    {{-- KONTENER UTAMA SIDEBAR YANG AKAN DINONAKTIFKAN --}}
    <div x-show="mobileOpen || window.innerWidth >= 1024"
         class="fixed inset-y-0 left-0 z-40 flex h-full transform flex-col bg-gray-800 text-gray-200 shadow-lg transition-all duration-300 ease-in-out lg:relative lg:transform-none lg:z-30"
         :class="{
             'pointer-events-none opacity-50': $store.appState.isSubmitting,
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
            <button @click="open = !open" class="hidden rounded-md p-2 hover:bg-gray-700 lg:block"><i class='bx bx-menu text-2xl'></i></button>
            <button @click="toggleMobile()" class="rounded-md p-2 hover:bg-gray-700 lg:hidden"><i class='bx bx-x text-2xl'></i></button>
        </div>

        <nav class="flex-1 space-y-3 py-6 px-4 overflow-y-auto">
            <div>
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Main Menu</h3>
                <a href="{{ $isProfileIncomplete ? '#' : route('subdirektorat-inovasi.dosen.dashboard') }}" 
                   class="flex items-center space-x-4 rounded-lg p-3 transition-colors {{ request()->routeIs('subdirektorat-inovasi.dosen.dashboard') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} {{ $isProfileIncomplete ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}" 
                   :class="{'justify-center': !open && !mobileOpen}"
                   @if($isProfileIncomplete) title="Harap lengkapi profil Anda terlebih dahulu." @endif>
                   <i class='bx bxs-dashboard text-2xl flex-shrink-0'></i>
                   <span x-show="open || mobileOpen" class="font-medium">Dashboard</span>
                </a>
            </div>
            <div class="pt-3">
                {{-- LINK INI SELALU AKTIF --}}
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Pengaturan Akun</h3>
                <a href="{{ route('subdirektorat-inovasi.dosen.manageprofile.edit') }}" class="flex items-center space-x-4 rounded-lg p-3 transition-colors {{ request()->routeIs('subdirektorat-inovasi.dosen.manageprofile.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }}" :class="{'justify-center': !open && !mobileOpen}">
                   <i class='bx bxs-user-circle text-2xl flex-shrink-0'></i>
                   <span x-show="open || mobileOpen" class="font-medium">Manajemen Profil</span>
                </a>
            </div>
            <div class="pt-3">
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Inovasi</h3>
                <button @click="inovasiOpen = !inovasiOpen" 
                        class="flex w-full items-center rounded-lg p-3 transition-colors hover:bg-gray-700 group {{ $isProfileIncomplete ? 'opacity-50 cursor-not-allowed' : '' }}" 
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'"
                        :disabled="{{ $isProfileIncomplete ? 'true' : 'false' }}"
                        @if($isProfileIncomplete) title="Harap lengkapi profil Anda terlebih dahulu." @endif>
                    <div class="flex items-center space-x-4"><i class='bx bxs-bulb text-2xl flex-shrink-0'></i><span x-show="open || mobileOpen" class="font-medium">Katsinov</span></div>
                    <div x-show="open || mobileOpen" class="flex items-center"><i class='bx bx-chevron-down text-2xl transition-transform' :class="{'rotate-180': inovasiOpen}"></i></div>
                </button>
                <div x-show="inovasiOpen && (open || mobileOpen)" x-collapse class="mt-2 ml-3 space-y-1">
                    {{-- Submenu dinonaktifkan secara otomatis karena parent-nya disabled --}}
                    <a href="{{ route('subdirektorat-inovasi.dosen.tablekatsinov') }}" class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors {{ request()->routeIs('subdirektorat-inovasi.dosen.tablekatsinov') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4"><i class='bx bx-table text-2xl flex-shrink-0'></i><span>Tabel Katsinov</span></a>
                    <a href="{{ route('subdirektorat-inovasi.dosen.form') }}" class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors {{ request()->routeIs('subdirektorat-inovasi.dosen.form') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4"><i class='bx bxs-file-plus text-2xl flex-shrink-0'></i><span>Form Katsinov</span></a>
                </div>
            </div>
            <div class="pt-3">
                <h3 x-show="open || mobileOpen" class="px-3 pb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Equity</h3>
                <button @click="equityOpen = !equityOpen" 
                        class="flex w-full items-center rounded-lg p-3 transition-colors hover:bg-gray-700 group {{ $isProfileIncomplete ? 'opacity-50 cursor-not-allowed' : '' }}" 
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'"
                        :disabled="{{ $isProfileIncomplete ? 'true' : 'false' }}"
                        @if($isProfileIncomplete) title="Harap lengkapi profil Anda terlebih dahulu." @endif>
                    <div class="flex items-center space-x-4"><i class='bx bxs-briefcase-alt-2 text-2xl flex-shrink-0'></i><span x-show="open || mobileOpen" class="font-medium">Community Development</span></div>
                    <div x-show="open || mobileOpen" class="flex items-center"><i class='bx bx-chevron-down text-2xl transition-transform' :class="{'rotate-180': equityOpen}"></i></div>
                </button>
                <div x-show="equityOpen && (open || mobileOpen)" x-collapse class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('subdirektorat-inovasi.dosen.equity.manajement.index') }}" class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors {{ request()->routeIs('subdirektorat-inovasi.dosen.equity.manajement.index') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4"><i class='bx bxs-folder-open text-2xl flex-shrink-0'></i><span>Manajemen Proposal</span></a>
                    <a href="{{ route('subdirektorat-inovasi.dosen.equity.usulkan-proposal.index') }}" class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors {{ request()->routeIs('subdirektorat-inovasi.dosen.equity.usulkan-proposal.*') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4"><i class='bx bxs-file-plus text-2xl flex-shrink-0'></i><span>Usulkan Proposal</span></a>
                </div>
                <button @click="apcOpen = !apcOpen" 
                        class="flex w-full items-center rounded-lg p-3 transition-colors hover:bg-gray-700 group mt-2 {{ $isProfileIncomplete ? 'opacity-50 cursor-not-allowed' : '' }}" 
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'"
                        :disabled="{{ $isProfileIncomplete ? 'true' : 'false' }}"
                        @if($isProfileIncomplete) title="Harap lengkapi profil Anda terlebih dahulu." @endif>
                    <div class="flex items-center space-x-4"><i class='bx bxs-file-doc text-2xl flex-shrink-0'></i><span x-show="open || mobileOpen" class="font-medium">Article Processing Cost</span></div>
                    <div x-show="open || mobileOpen" class="flex items-center"><i class='bx bx-chevron-down text-2xl transition-transform' :class="{'rotate-180': apcOpen}"></i></div>
                </button>
                <div x-show="apcOpen && (open || mobileOpen)" x-collapse class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('subdirektorat-inovasi.dosen.apc.manajemen') }}" class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors {{ request()->routeIs('subdirektorat-inovasi.dosen.apc.manajemen') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4"><i class='bx bxs-folder-open text-2xl flex-shrink-0'></i><span>Manajemen Proposal</span></a>
                    <a href="{{ route('subdirektorat-inovasi.dosen.apc.list-sesi') }}" class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors {{ request()->routeIs('subdirektorat-inovasi.dosen.apc.list-sesi') || request()->routeIs('subdirektorat-inovasi.dosen.apc.form') ? 'bg-teal-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700' }} ml-4"><i class='bx bxs-file-plus text-2xl flex-shrink-0'></i><span>Usulkan Proposal</span></a>
                </div>
                <button @click="matchmakingOpen = !matchmakingOpen" 
                        class="flex w-full items-center rounded-lg p-3 transition-colors hover:bg-gray-700 group mt-2 {{ $isProfileIncomplete ? 'opacity-50 cursor-not-allowed' : '' }}" 
                        :class="open || mobileOpen ? 'justify-between' : 'justify-center'"
                        :disabled="{{ $isProfileIncomplete ? 'true' : 'false' }}"
                        @if($isProfileIncomplete) title="Harap lengkapi profil Anda terlebih dahulu." @endif>
                    <div class="flex items-center space-x-4"><i class='bx bx-user-voice text-2xl flex-shrink-0'></i><span x-show="open || mobileOpen" class="font-medium">Matchmaking Riset</span></div>
                    <div x-show="open || mobileOpen" class="flex items-center"><i class='bx bx-chevron-down text-2xl transition-transform' :class="{'rotate-180': matchmakingOpen}"></i></div>
                </button>
                <div x-show="matchmakingOpen && (open || mobileOpen)" x-collapse class="mt-2 ml-3 space-y-1">
                    <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.manajemen') }}" class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors {{ request()->routeIs('subdirektorat-inovasi.dosen.matchresearch.manajemen') ? 'bg-teal-600 font-semibold text-white' : 'hover:bg-gray-700' }} ml-4"><i class='bx bxs-folder-open text-2xl flex-shrink-0'></i><span>Manajemen Proposal</span></a>
                    <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.list-sesi') }}" class="flex items-center space-x-4 rounded-lg p-3 text-sm transition-colors {{ request()->routeIs('subdirektorat-inovasi.dosen.matchresearch.list-sesi') || request()->routeIs('subdirektorat-inovasi.dosen.matchresearch.form') ? 'bg-teal-600 font-semibold text-white' : 'hover:bg-gray-700' }} ml-4"><i class='bx bxs-file-plus text-2xl flex-shrink-0'></i><span>Usulkan Proposal</span></a>
                </div>
            </div>
        </nav>

     
        <div class="border-t border-gray-700 py-4 px-4">
            <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar">
                @csrf
                <a href="#" onclick="if(Alpine.store('appState').isSubmitting) return false; event.preventDefault(); this.closest('form').submit();" class="flex items-center space-x-4 rounded-lg p-3 transition-colors hover:bg-red-600 hover:text-white" :class="{'justify-center': !open && !mobileOpen}">
                   <i class='bx bxs-log-out-circle text-2xl flex-shrink-0'></i>
                   <span x-show="open || mobileOpen" class="font-medium">Logout</span>
                </a>
            </form>
        </div>
    </div>
</div>