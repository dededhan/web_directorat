<aside class="flex w-64 flex-shrink-0 flex-col bg-gray-900 text-gray-300 transition-all duration-300"
    :class="{ '-ml-64': !sidebarOpen }" x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300"
    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in-out duration-300" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full" x-cloak>

    <div class="flex h-16 flex-shrink-0 items-center justify-center border-b border-gray-800">
        <i class="fas fa-lightbulb mr-3 text-2xl text-amber-400"></i>
        <span class="text-lg font-semibold text-white">Admin Hackaton</span>
    </div>

    <nav class="flex-1 space-y-2 overflow-y-auto px-4 py-6">
        <a href="{{ route('admin_hackaton.dashboard') }}"
            class="flex items-center rounded-lg px-4 py-2.5 transition-colors duration-200 {{ request()->routeIs('admin_hackaton.dashboard') ? 'bg-amber-500 text-gray-900' : 'hover:bg-gray-800 hover:text-white' }}">
            <i class="fas fa-home fa-fw w-6 text-center"></i>
            <span class="ml-4">Dashboard</span>
        </a>

        <a href="{{ route('admin_hackaton.registrations.index') }}"
            class="flex items-center rounded-lg px-4 py-2.5 transition-colors duration-200 {{ request()->routeIs('admin_hackaton.registrations.*') ? 'bg-amber-500 text-gray-900' : 'hover:bg-gray-800 hover:text-white' }}">
            <i class="fas fa-user-clock fa-fw w-6 text-center"></i>
            <span class="ml-4">Pendaftaran</span>
        </a>
    </nav>

    <div class="flex-shrink-0 border-t border-gray-800 p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex w-full items-center rounded-lg px-4 py-2.5 transition-colors duration-200 hover:bg-red-600 hover:text-white">
                <i class="fas fa-sign-out-alt fa-fw w-6 text-center"></i>
                <span class="ml-4">Logout</span>
            </button>
        </form>
    </div>
</aside>
