<aside class="flex-shrink-0 w-64 bg-gray-800 text-gray-300 flex flex-col transition-all duration-300"
    :class="{ '-ml-64': !sidebarOpen }" x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300"
    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in-out duration-300" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full" x-cloak>

    {{-- Brand --}}
    <div class="h-16 flex items-center justify-center bg-gray-900 shadow-md">
        <i class="fas fa-trophy text-yellow-400 text-2xl mr-3"></i>
        <span class="text-white text-lg font-semibold">Admin InovChallenge</span>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

        {{-- Dashboard --}}
        <a href="{{ route('admin_inovchalenge.dashboard') }}"
            class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin_inovchalenge.dashboard') ? 'bg-teal-600 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
            <i class="fas fa-home fa-fw w-6 text-center"></i>
            <span class="ml-4">Dashboard</span>
        </a>

        {{-- Innovation Challenge Menu --}}
        <div x-data="{ open: {{ request()->routeIs('admin_inovchalenge.inovchalenge.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 focus:outline-none {{ request()->routeIs('admin_inovchalenge.inovchalenge.*') ? 'bg-teal-600 text-white' : '' }}">
                <div class="flex items-center">
                    <i class="fas fa-trophy fa-fw w-6 text-center"></i>
                    <span class="ml-4">Innovation Challenge</span>
                </div>
                <i class="fas fa-chevron-down transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
            </button>
            <div x-show="open" x-transition class="mt-2 pl-8 space-y-2" x-cloak>
                <a href="{{ route('admin_inovchalenge.inovchalenge.sessions.index') }}"
                    class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin_inovchalenge.inovchalenge.sessions.*') || request()->routeIs('admin_inovchalenge.inovchalenge.submissions.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-list fa-fw w-5 text-center mr-2"></i>
                    Daftar Sesi
                </a>
                <a href="{{ route('admin_inovchalenge.inovchalenge.sessions.create') }}"
                    class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin_inovchalenge.inovchalenge.sessions.create') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-plus-circle fa-fw w-5 text-center mr-2"></i>
                    Buat Sesi Baru
                </a>
            </div>
        </div>

        {{-- Manajemen Akun Menu --}}
        <div x-data="{ open: {{ request()->routeIs('admin_inovchalenge.accounts.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 focus:outline-none {{ request()->routeIs('admin_inovchalenge.accounts.*') ? 'bg-teal-600 text-white' : '' }}">
                <div class="flex items-center">
                    <i class="fas fa-users-cog fa-fw w-6 text-center"></i>
                    <span class="ml-4">Manajemen Akun</span>
                </div>
                <i class="fas fa-chevron-down transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
            </button>
            <div x-show="open" x-transition class="mt-2 pl-8 space-y-2" x-cloak>
                <a href="{{ route('admin_inovchalenge.accounts.index') }}"
                    class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin_inovchalenge.accounts.index') || request()->routeIs('admin_inovchalenge.accounts.create') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-users fa-fw w-5 text-center mr-2"></i>
                    Daftar Akun
                </a>
                <a href="{{ route('admin_inovchalenge.accounts.registrations') }}"
                    class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin_inovchalenge.accounts.registrations*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-user-clock fa-fw w-5 text-center mr-2"></i>
                    Pendaftaran Akun
                    @php
                        $pendingRegCount = \App\Models\InovChalengeRegistration::where('status', 'pending')->count();
                    @endphp
                    @if ($pendingRegCount > 0)
                        <span
                            class="ml-auto inline-flex items-center justify-center w-5 h-5 text-xs font-bold rounded-full bg-red-500 text-white">
                            {{ $pendingRegCount }}
                        </span>
                    @endif
                </a>
            </div>
        </div>

        {{-- Reviewer Section --}}
        <div x-data="{ open: false }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 focus:outline-none">
                <div class="flex items-center">
                    <i class="fas fa-user-check fa-fw w-6 text-center"></i>
                    <span class="ml-4">Reviewer</span>
                </div>
                <i class="fas fa-chevron-down transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
            </button>
            <div x-show="open" x-transition class="mt-2 pl-8 space-y-2" x-cloak>
                <a href="#"
                    class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200">
                    <i class="fas fa-clipboard-list fa-fw w-5 text-center mr-2"></i>
                    Daftar Reviewer
                </a>
            </div>
        </div>

    </nav>

    {{-- Logout --}}
    <div class="p-4 border-t border-gray-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center px-4 py-2.5 rounded-lg hover:bg-red-600 hover:text-white transition-colors duration-200">
                <i class="fas fa-sign-out-alt fa-fw w-6 text-center"></i>
                <span class="ml-4">Logout</span>
            </button>
        </form>
    </div>
</aside>
