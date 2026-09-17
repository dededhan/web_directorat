<aside class="flex w-64 flex-shrink-0 flex-col border-r border-black bg-black text-white transition-all duration-300"
    :class="{ '-ml-64': !sidebarOpen }" x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300"
    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in-out duration-300" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full" x-cloak>

    <div class="flex min-h-24 flex-shrink-0 items-end border-b border-white px-6 pb-5">
        <div>
            <p class="mb-2 text-[10px] font-bold uppercase tracking-[0.3em] text-white/60">UNJ / 2026</p>
            <span class="editorial-serif text-2xl font-semibold">
                @if(in_array(auth()->user()->role ?? '', ['reviewer_hackaton', 'reviewer_inovchalenge']))
                    Reviewer<br>HackAthon
                @else
                    Peserta<br>HackAthon
                @endif
            </span>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto px-4 py-8">
        <p class="mb-3 px-2 text-[10px] font-bold uppercase tracking-[0.25em] text-white/50">Navigasi</p>
        <div class="border-t border-white">
            <a href="{{ route('hackaton.dashboard') }}"
                class="flex items-center border-b border-white px-2 py-4 text-xs font-semibold uppercase tracking-[0.12em] transition-colors {{ request()->routeIs('hackaton.dashboard') ? 'bg-white text-black' : 'text-white hover:bg-white hover:text-black' }}">
                <span class="mr-3 text-[10px]">01</span>
                <span>Dashboard</span>
            </a>

            @if(in_array(auth()->user()->role, ['hackaton_dosen', 'hackaton_tendik', 'dosen', 'tendik']))
                <a href="{{ route('hackaton.sessions.index') }}"
                    class="flex items-center border-b border-white px-2 py-4 text-xs font-semibold uppercase tracking-[0.12em] transition-colors {{ request()->routeIs('hackaton.sessions.*') ? 'bg-white text-black' : 'text-white hover:bg-white hover:text-black' }}">
                    <span class="mr-3 text-[10px]">02</span>
                    <span>Sesi HackAthon</span>
                </a>

                <a href="{{ route('hackaton.submissions.index') }}"
                    class="flex items-center border-b border-white px-2 py-4 text-xs font-semibold uppercase tracking-[0.12em] transition-colors {{ request()->routeIs('hackaton.submissions.*') ? 'bg-white text-black' : 'text-white hover:bg-white hover:text-black' }}">
                    <span class="mr-3 text-[10px]">03</span>
                    <span>Proposal Saya</span>
                </a>

                <a href="{{ route('hackaton.members.team_index') }}"
                    class="flex items-center border-b border-white px-2 py-4 text-xs font-semibold uppercase tracking-[0.12em] transition-colors {{ request()->routeIs('hackaton.members.team_index') ? 'bg-white text-black' : 'text-white hover:bg-white hover:text-black' }}">
                    <span class="mr-3 text-[10px]">04</span>
                    <span>Proposal Tim Lain</span>
                </a>
            @endif

            @if(in_array(auth()->user()->role, ['reviewer_hackaton', 'reviewer_inovchalenge']))
                <a href="{{ route('hackaton.reviewer.dashboard') }}"
                    class="flex items-center border-b border-white px-2 py-4 text-xs font-semibold uppercase tracking-[0.12em] transition-colors {{ request()->routeIs('hackaton.reviewer.dashboard') ? 'bg-white text-black' : 'text-white hover:bg-white hover:text-black' }}">
                    <span class="mr-3 text-[10px]">02</span>
                    <span>Dashboard Reviewer</span>
                </a>

                <a href="{{ route('hackaton.reviewer.assignments.index') }}"
                    class="flex items-center border-b border-white px-2 py-4 text-xs font-semibold uppercase tracking-[0.12em] transition-colors {{ request()->routeIs('hackaton.reviewer.assignments.*') ? 'bg-white text-black' : 'text-white hover:bg-white hover:text-black' }}">
                    <span class="mr-3 text-[10px]">03</span>
                    <span>Tugas Penilaian</span>
                </a>
            @endif

            <a href="{{ route('hackaton.info') }}"
                class="flex items-center border-b border-white px-2 py-4 text-xs font-semibold uppercase tracking-[0.12em] transition-colors {{ request()->routeIs('hackaton.info') ? 'bg-white text-black' : 'text-white hover:bg-white hover:text-black' }}">
                <span class="mr-3 text-[10px]">↳</span>
                <span>Informasi HackAthon</span>
            </a>

            @if(in_array(auth()->user()->role, ['dosen', 'tendik']))
                <a href="{{ auth()->user()->role === 'dosen' ? route('subdirektorat-inovasi.dosen.dashboard') : route('subdirektorat-inovasi.tendik.dashboard') }}"
                    class="flex items-center border-b border-white px-2 py-4 text-xs font-semibold uppercase tracking-[0.12em] text-emerald-400 transition-colors hover:bg-white hover:text-black">
                    <span class="mr-3 text-[10px]">←</span>
                    <span>Portal Utama</span>
                </a>
            @endif
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
