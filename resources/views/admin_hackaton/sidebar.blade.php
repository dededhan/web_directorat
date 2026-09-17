<aside class="flex w-64 flex-shrink-0 flex-col border-r border-black bg-black text-white transition-all duration-300"
    :class="{ '-ml-64': !sidebarOpen }" x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300"
    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in-out duration-300" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full" x-cloak>

    <div class="flex min-h-24 flex-shrink-0 items-end border-b border-white px-6 pb-5">
        <div>
            <p class="mb-2 text-[10px] font-bold uppercase tracking-[0.3em] text-white/60">UNJ / 2026</p>
            <span class="editorial-serif text-2xl font-semibold">Admin<br>HackAthon</span>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto px-4 py-8">
        <p class="mb-3 px-2 text-[10px] font-bold uppercase tracking-[0.25em] text-white/50">Navigasi</p>
        <div class="border-t border-white">
            <a href="{{ route('admin_hackaton.dashboard') }}"
                class="flex items-center border-b border-white px-2 py-4 text-xs font-semibold uppercase tracking-[0.12em] transition-colors {{ request()->routeIs('admin_hackaton.dashboard') ? 'bg-white text-black' : 'text-white hover:bg-white hover:text-black' }}">
                <span class="mr-3 text-[10px]">01</span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin_hackaton.registrations.index') }}"
                class="flex items-center border-b border-white px-2 py-4 text-xs font-semibold uppercase tracking-[0.12em] transition-colors {{ request()->routeIs('admin_hackaton.registrations.*') ? 'bg-white text-black' : 'text-white hover:bg-white hover:text-black' }}">
                <span class="mr-3 text-[10px]">02</span>
                <span>Pendaftaran</span>
            </a>

            <a href="{{ route('admin_hackaton.sessions.index') }}"
                class="flex items-center border-b border-white px-2 py-4 text-xs font-semibold uppercase tracking-[0.12em] transition-colors {{ request()->routeIs('admin_hackaton.sessions.*', 'admin_hackaton.tahap.*') ? 'bg-white text-black' : 'text-white hover:bg-white hover:text-black' }}">
                <span class="mr-3 text-[10px]">03</span>
                <span>Sesi Hackaton</span>
            </a>

            <a href="{{ route('admin_hackaton.accounts.index') }}"
                class="flex items-center border-b border-white px-2 py-4 text-xs font-semibold uppercase tracking-[0.12em] transition-colors {{ request()->routeIs('admin_hackaton.accounts.*') ? 'bg-white text-black' : 'text-white hover:bg-white hover:text-black' }}">
                <span class="mr-3 text-[10px]">04</span>
                <span>Kelola Akun</span>
            </a>
        </div>
    </nav>

    <div class="flex-shrink-0 border-t border-white p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex w-full items-center px-2 py-3 text-left text-xs font-semibold uppercase tracking-[0.12em] transition-colors hover:bg-white hover:text-black">
                <span class="mr-3 text-[10px]">↳</span>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>
