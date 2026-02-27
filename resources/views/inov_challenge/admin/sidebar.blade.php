<div x-data="{
    open: window.innerWidth >= 1024,
    mobileOpen: false,
    formBuilderOpen: {{ request()->routeIs('admin.inov_challenge.forms.*') ? 'true' : 'false' }},
    submissionsOpen: {{ request()->routeIs('admin.inov_challenge.submissions.*') ? 'true' : 'false' }},
    reportsOpen: {{ request()->routeIs('admin.inov_challenge.reports.*') ? 'true' : 'false' }},
    init() {
        this.$watch('mobileOpen', value => {
            if (value) { document.body.style.overflow = 'hidden'; } else { document.body.style.overflow = ''; }
        });
        window.toggleSidebar = () => { this.mobileOpen = !this.mobileOpen; };
    },
    toggleMobile() { this.mobileOpen = !this.mobileOpen; }
}" @resize.window="open = window.innerWidth >= 1024"
    @toggle-sidebar.window="mobileOpen = !this.mobileOpen" @keydown.escape.window="toggleMobile()" class="relative">

    <!-- Mobile Menu Button -->
    <button type="button" @click="toggleMobile()" x-show="!mobileOpen"
        class="fixed top-4 left-4 z-50 inline-flex items-center justify-center rounded-md p-2 text-gray-600 bg-white shadow-lg hover:bg-gray-100 focus:outline-none lg:hidden">
        <span class="sr-only">Open sidebar</span>
        <i class='bx bx-menu text-xl'></i>
    </button>

    <!-- Overlay -->
    <div x-show="mobileOpen" @click="toggleMobile()" x-transition
        class="fixed inset-0 z-30 bg-black bg-opacity-50 lg:hidden" style="display: none;"></div>

    <!-- Sidebar -->
    <div x-show="mobileOpen || window.innerWidth >= 1024"
        class="fixed inset-y-0 left-0 z-40 flex h-full transform flex-col bg-gradient-to-b from-indigo-900 via-indigo-800 to-indigo-900 text-gray-100 shadow-2xl transition-all duration-300 ease-in-out lg:relative lg:transform-none lg:z-30"
        :class="{
            '-translate-x-full lg:translate-x-0': !mobileOpen && window.innerWidth < 1024,
            'translate-x-0': mobileOpen || window.innerWidth >= 1024,
            'w-80': open || (mobileOpen && window.innerWidth < 1024),
            'w-20': !open && !mobileOpen && window.innerWidth >= 1024
        }">

        <!-- Header -->
        <div
            class="flex h-16 flex-shrink-0 items-center justify-between border-b border-indigo-700 px-6 bg-indigo-900/50">
            <a href="{{ route('admin.inov_challenge.dashboard') }}" class="flex items-center space-x-3 overflow-hidden"
                x-show="open || mobileOpen">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-yellow-400 to-orange-500 shadow-lg">
                    <i class='bx bxs-trophy text-xl text-white'></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-lg font-bold text-white">Innovation Challenge</span>
                    <span class="text-xs text-indigo-300">Admin Panel</span>
                </div>
            </a>
            <button @click="open = !open"
                class="hidden rounded-md p-2 hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none lg:block">
                <i class='bx bx-menu text-2xl'></i>
            </button>
            <button @click="toggleMobile()"
                class="rounded-md p-2 hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none lg:hidden">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 space-y-2 py-6 px-4 overflow-y-auto">
            <!-- Main Menu Section -->
            <div>
                <h3 x-show="open || mobileOpen"
                    class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-indigo-300">
                    Main Menu
                </h3>

                <!-- Dashboard -->
                <a href="{{ route('admin.inov_challenge.dashboard') }}"
                    class="flex items-center space-x-4 rounded-lg p-3 transition-all duration-200 {{ request()->routeIs('admin.inov_challenge.dashboard') ? 'bg-gradient-to-r from-yellow-500 to-orange-500 font-semibold text-white shadow-lg' : 'hover:bg-indigo-700/50' }}"
                    :class="{ 'justify-center': !open && !mobileOpen }">
                    <i class='bx bxs-dashboard text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Dashboard</span>
                </a>
            </div>

            <!-- Session Management Section -->
            <div class="pt-4">
                <h3 x-show="open || mobileOpen"
                    class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-indigo-300">
                    Session Management
                </h3>

                <!-- Kelola Sesi -->
                <a href="{{ route('admin.inov_challenge.sessions.index') }}"
                    class="flex items-center space-x-4 rounded-lg p-3 transition-all duration-200 {{ request()->routeIs('admin.inov_challenge.sessions.*') ? 'bg-gradient-to-r from-yellow-500 to-orange-500 font-semibold text-white shadow-lg' : 'hover:bg-indigo-700/50' }}"
                    :class="{ 'justify-center': !open && !mobileOpen }">
                    <i class='bx bxs-calendar text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Kelola Sesi</span>
                </a>

                <!-- Form Builder (with dropdown) -->
                <div>
                    <button @click="formBuilderOpen = !formBuilderOpen"
                        class="flex w-full items-center justify-between space-x-4 rounded-lg p-3 transition-all duration-200 {{ request()->routeIs('admin.inov_challenge.forms.*') ? 'bg-gradient-to-r from-yellow-500 to-orange-500 font-semibold text-white shadow-lg' : 'hover:bg-indigo-700/50' }}"
                        :class="{ 'justify-center': !open && !mobileOpen }">
                        <div class="flex items-center space-x-4">
                            <i class='bx bxs-edit text-2xl flex-shrink-0'></i>
                            <span x-show="open || mobileOpen" class="font-medium">Form Builder</span>
                        </div>
                        <i x-show="open || mobileOpen" class='bx text-lg transition-transform duration-200'
                            :class="formBuilderOpen ? 'bx-chevron-down' : 'bx-chevron-right'"></i>
                    </button>
                    <div x-show="formBuilderOpen && (open || mobileOpen)" x-collapse class="ml-11 mt-2 space-y-1">
                        <a href="{{ route('admin.inov_challenge.sessions.index') }}"
                            class="block rounded-md px-3 py-2 text-sm hover:bg-indigo-700/50 {{ request()->routeIs('admin.inov_challenge.forms.index') ? 'bg-indigo-700/50 font-medium' : '' }}">
                            Phase 1 Forms
                        </a>
                        <a href="{{ route('admin.inov_challenge.sessions.index') }}"
                            class="block rounded-md px-3 py-2 text-sm hover:bg-indigo-700/50">
                            Phase 2 Forms
                        </a>
                        <a href="{{ route('admin.inov_challenge.sessions.index') }}"
                            class="block rounded-md px-3 py-2 text-sm hover:bg-indigo-700/50">
                            Phase 3 Forms
                        </a>
                    </div>
                </div>
            </div>

            <!-- Submission Management Section -->
            <div class="pt-4">
                <h3 x-show="open || mobileOpen"
                    class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-indigo-300">
                    Submission Management
                </h3>

                <!-- Submissions -->
                <a href="{{ route('admin.inov_challenge.submissions.index') }}"
                    class="flex items-center space-x-4 rounded-lg p-3 transition-all duration-200 {{ request()->routeIs('admin.inov_challenge.submissions.*') ? 'bg-gradient-to-r from-yellow-500 to-orange-500 font-semibold text-white shadow-lg' : 'hover:bg-indigo-700/50' }}"
                    :class="{ 'justify-center': !open && !mobileOpen }">
                    <i class='bx bxs-file-doc text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Submissions</span>
                    <span x-show="open || mobileOpen"
                        class="ml-auto rounded-full bg-red-500 px-2 py-0.5 text-xs font-bold text-white">
                        New
                    </span>
                </a>

                <!-- Reviewer Assignment -->
                <a href="{{ route('admin.inov_challenge.submissions.index') }}?tab=reviewers"
                    class="flex items-center space-x-4 rounded-lg p-3 transition-all duration-200 {{ request()->routeIs('admin.inov_challenge.reviewers.*') ? 'bg-gradient-to-r from-yellow-500 to-orange-500 font-semibold text-white shadow-lg' : 'hover:bg-indigo-700/50' }}"
                    :class="{ 'justify-center': !open && !mobileOpen }">
                    <i class='bx bxs-user-check text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Reviewer Assignment</span>
                </a>
            </div>

            <!-- Reports Section -->
            <div class="pt-4">
                <h3 x-show="open || mobileOpen"
                    class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-indigo-300">
                    Reports & Analytics
                </h3>

                <!-- Laporan -->
                <a href="{{ route('admin.inov_challenge.reports.index') }}"
                    class="flex items-center space-x-4 rounded-lg p-3 transition-all duration-200 {{ request()->routeIs('admin.inov_challenge.reports.*') ? 'bg-gradient-to-r from-yellow-500 to-orange-500 font-semibold text-white shadow-lg' : 'hover:bg-indigo-700/50' }}"
                    :class="{ 'justify-center': !open && !mobileOpen }">
                    <i class='bx bxs-bar-chart-alt-2 text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Laporan</span>
                </a>
            </div>

            <!-- Settings Section -->
            <div class="pt-4">
                <h3 x-show="open || mobileOpen"
                    class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-indigo-300">
                    Others
                </h3>

                <!-- Pengaturan -->
                <a href="#"
                    class="flex items-center space-x-4 rounded-lg p-3 transition-all duration-200 hover:bg-indigo-700/50"
                    :class="{ 'justify-center': !open && !mobileOpen }">
                    <i class='bx bxs-cog text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Pengaturan</span>
                </a>

                <!-- Back to Main Admin -->
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center space-x-4 rounded-lg p-3 transition-all duration-200 hover:bg-indigo-700/50 border-t border-indigo-700 mt-4"
                    :class="{ 'justify-center': !open && !mobileOpen }">
                    <i class='bx bx-arrow-back text-2xl flex-shrink-0'></i>
                    <span x-show="open || mobileOpen" class="font-medium">Back to Admin</span>
                </a>
            </div>
        </nav>

        <!-- Footer / User Info -->
        <div class="flex-shrink-0 border-t border-indigo-700 p-4 bg-indigo-900/50">
            <div class="flex items-center space-x-3" :class="{ 'justify-center': !open && !mobileOpen }">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 text-white font-bold flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div x-show="open || mobileOpen" class="flex flex-col overflow-hidden">
                    <span class="truncate text-sm font-semibold">{{ Auth::user()->name ?? 'Admin' }}</span>
                    <span class="truncate text-xs text-indigo-300">{{ Auth::user()->email ?? '' }}</span>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar" class="mt-3"
                x-show="open || mobileOpen">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center space-x-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors">
                    <i class='bx bx-log-out text-lg'></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }

    /* Custom scrollbar for sidebar */
    .overflow-y-auto::-webkit-scrollbar {
        width: 6px;
    }

    .overflow-y-auto::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 3px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }
</style>
