<div x-data="{
    open: window.innerWidth >= 1024,
    mobileOpen: false,
    init() {
        this.$watch('mobileOpen', value => {
            if (value) { document.body.style.overflow = 'hidden'; } else { document.body.style.overflow = ''; }
        });
        window.toggleSidebar = () => { this.mobileOpen = !this.mobileOpen; };
    },
    toggleMobile() { this.mobileOpen = !this.mobileOpen; }
}" @resize.window="open = window.innerWidth >= 1024"
    @toggle-sidebar.window="mobileOpen = !this.mobileOpen" @keydown.escape.window="toggleMobile()" class="relative">

    {{-- Mobile toggle --}}
    <button type="button" @click="toggleMobile()" x-show="!mobileOpen"
        class="fixed top-4 left-4 z-50 inline-flex items-center justify-center rounded-md p-2 text-gray-600 bg-white shadow-lg hover:bg-gray-100 focus:outline-none lg:hidden">
        <span class="sr-only">Open sidebar</span>
        <i class='bx bx-menu text-xl'></i>
    </button>

    {{-- Mobile overlay --}}
    <div x-show="mobileOpen" @click="toggleMobile()" x-transition
        class="fixed inset-0 z-30 bg-black bg-opacity-50 lg:hidden" style="display: none;"></div>

    {{-- Sidebar --}}
    <div x-show="mobileOpen || window.innerWidth >= 1024"
        class="fixed inset-y-0 left-0 z-40 flex h-full transform flex-col bg-gray-800 text-gray-200 shadow-lg transition-all duration-300 ease-in-out lg:relative lg:transform-none lg:z-30"
        :class="{
            '-translate-x-full lg:translate-x-0': !mobileOpen && window.innerWidth < 1024,
            'translate-x-0': mobileOpen || window.innerWidth >= 1024,
            'w-72': open || (mobileOpen && window.innerWidth < 1024),
            'w-20': !open && !mobileOpen && window.innerWidth >= 1024
        }">

        {{-- Logo / Brand --}}
        <div class="flex h-16 flex-shrink-0 items-center justify-between border-b border-gray-700 px-6">
            <a href="{{ route('reviewer_inovchalenge.dashboard') }}" class="flex items-center space-x-3 overflow-hidden"
                x-show="open || mobileOpen">
                <div
                    class="w-9 h-9 rounded-xl bg-gradient-to-br from-cyan-400 to-cyan-600 flex items-center justify-center flex-shrink-0">
                    <i class='bx bxs-star text-white text-lg'></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-lg font-bold text-white">Reviewer</span>
                    <span class="text-[10px] text-gray-400 -mt-0.5">Innovation Challenge</span>
                </div>
            </a>
            <a href="{{ route('reviewer_inovchalenge.dashboard') }}" x-show="!open && !mobileOpen" class="mx-auto">
                <div
                    class="w-9 h-9 rounded-xl bg-gradient-to-br from-cyan-400 to-cyan-600 flex items-center justify-center">
                    <i class='bx bxs-star text-white text-lg'></i>
                </div>
            </a>
            <button @click="open = !open" class="hidden rounded-md p-2 hover:bg-gray-700 lg:block">
                <i class='bx bx-menu text-2xl'></i>
            </button>
            <button @click="toggleMobile()" class="rounded-md p-2 hover:bg-gray-700 lg:hidden">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 space-y-2 py-6 px-4 overflow-y-auto">
            <h3 x-show="open || mobileOpen"
                class="px-3 pb-2 text-[10px] font-semibold uppercase tracking-wider text-gray-500">Menu Utama</h3>

            {{-- Dashboard --}}
            <a href="{{ route('reviewer_inovchalenge.dashboard') }}"
                class="flex items-center space-x-3 rounded-xl p-3 transition-colors {{ request()->routeIs('reviewer_inovchalenge.dashboard') ? 'bg-cyan-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700 text-gray-300' }}"
                :class="{ 'justify-center': !open && !mobileOpen }">
                <i class='bx bxs-dashboard text-xl flex-shrink-0'></i>
                <span x-show="open || mobileOpen" class="font-medium text-sm">Dashboard</span>
            </a>

            {{-- Tugas Review --}}
            <a href="{{ route('reviewer_inovchalenge.assignments.index') }}"
                class="flex items-center space-x-3 rounded-xl p-3 transition-colors {{ request()->routeIs('reviewer_inovchalenge.assignments.*') ? 'bg-cyan-600 font-semibold text-white shadow-md' : 'hover:bg-gray-700 text-gray-300' }}"
                :class="{ 'justify-center': !open && !mobileOpen }">
                <i class='bx bxs-file-find text-xl flex-shrink-0'></i>
                <span x-show="open || mobileOpen" class="font-medium text-sm">Tugas Review</span>
            </a>

            {{-- Divider --}}
            <div class="border-t border-gray-700 my-4"></div>

            <h3 x-show="open || mobileOpen"
                class="px-3 pb-2 text-[10px] font-semibold uppercase tracking-wider text-gray-500">Navigasi</h3>

            {{-- Kembali ke Dashboard Dosen --}}
            <a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}"
                class="flex items-center space-x-3 rounded-xl p-3 transition-colors hover:bg-gray-700 text-gray-400"
                :class="{ 'justify-center': !open && !mobileOpen }">
                <i class='bx bx-arrow-back text-xl flex-shrink-0'></i>
                <span x-show="open || mobileOpen" class="font-medium text-sm">Dashboard Dosen</span>
            </a>
        </nav>

        {{-- Logout --}}
        <div class="border-t border-gray-700 py-4 px-4">
            <form method="POST" action="{{ route('logout') }}" id="logout-form-reviewer">
                @csrf
                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"
                    class="flex items-center space-x-3 rounded-xl p-3 transition-colors hover:bg-red-600 hover:text-white text-gray-400"
                    :class="{ 'justify-center': !open && !mobileOpen }">
                    <i class='bx bxs-log-out-circle text-xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium text-sm">Logout</span>
                </a>
            </form>
        </div>
    </div>
</div>
