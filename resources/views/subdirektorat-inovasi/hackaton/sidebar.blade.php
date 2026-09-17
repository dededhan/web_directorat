<aside class="flex w-64 flex-shrink-0 flex-col border-r-2 border-gray-950 bg-white text-gray-950 transition-all duration-300"
    :class="{ '-ml-64': !sidebarOpen }" x-show="sidebarOpen" x-cloak>

    <div class="flex h-16 flex-shrink-0 items-center gap-3 border-b-2 border-gray-950 px-5">
        <i class="fas fa-lightbulb text-xl text-emerald-700"></i>
        <span class="text-lg font-black">Hackaton UNJ</span>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-5">
        {{-- Keep all existing role-based navigation links, but use the new border-left active-state styling. --}}
        <a href="{{ route('hackaton.dashboard') }}"
            class="flex items-center border-l-4 px-4 py-3 text-sm font-bold transition-colors {{ request()->routeIs('hackaton.dashboard') ? 'border-emerald-700 bg-emerald-50 text-emerald-800' : 'border-transparent text-gray-700 hover:bg-gray-100 hover:text-gray-950' }}">
            <i class="fas fa-home fa-fw w-6 text-center"></i><span class="ml-3">Dashboard</span>
        </a>

        @if(in_array(auth()->user()->role, ['hackaton_dosen', 'hackaton_tendik', 'dosen', 'tendik']))
            <a href="{{ route('hackaton.sessions.index') }}" class="flex items-center border-l-4 px-4 py-3 text-sm font-bold transition-colors {{ request()->routeIs('hackaton.sessions.*') ? 'border-emerald-700 bg-emerald-50 text-emerald-800' : 'border-transparent text-gray-700 hover:bg-gray-100 hover:text-gray-950' }}"><i class="fas fa-calendar-alt fa-fw w-6 text-center"></i><span class="ml-3">Sesi Hackaton</span></a>
            <a href="{{ route('hackaton.submissions.index') }}" class="flex items-center border-l-4 px-4 py-3 text-sm font-bold transition-colors {{ request()->routeIs('hackaton.submissions.*') ? 'border-emerald-700 bg-emerald-50 text-emerald-800' : 'border-transparent text-gray-700 hover:bg-gray-100 hover:text-gray-950' }}"><i class="fas fa-file-alt fa-fw w-6 text-center"></i><span class="ml-3">Proposal Saya</span></a>
            <a href="{{ route('hackaton.members.team_index') }}" class="flex items-center border-l-4 px-4 py-3 text-sm font-bold transition-colors {{ request()->routeIs('hackaton.members.team_index') ? 'border-emerald-700 bg-emerald-50 text-emerald-800' : 'border-transparent text-gray-700 hover:bg-gray-100 hover:text-gray-950' }}"><i class="fas fa-users fa-fw w-6 text-center"></i><span class="ml-3">Proposal Tim Lain</span></a>
        @endif

        @if(in_array(auth()->user()->role, ['reviewer_hackaton', 'reviewer_inovchalenge']))
            <a href="{{ route('hackaton.reviewer.dashboard') }}" class="flex items-center border-l-4 px-4 py-3 text-sm font-bold transition-colors {{ request()->routeIs('hackaton.reviewer.dashboard') ? 'border-emerald-700 bg-emerald-50 text-emerald-800' : 'border-transparent text-gray-700 hover:bg-gray-100 hover:text-gray-950' }}"><i class="fas fa-chart-pie fa-fw w-6 text-center"></i><span class="ml-3">Dashboard Reviewer</span></a>
            <a href="{{ route('hackaton.reviewer.assignments.index') }}" class="flex items-center border-l-4 px-4 py-3 text-sm font-bold transition-colors {{ request()->routeIs('hackaton.reviewer.assignments.*') ? 'border-emerald-700 bg-emerald-50 text-emerald-800' : 'border-transparent text-gray-700 hover:bg-gray-100 hover:text-gray-950' }}"><i class="fas fa-clipboard-check fa-fw w-6 text-center"></i><span class="ml-3">Tugas Penilaian</span></a>
        @endif

        <a href="{{ route('hackaton.info') }}" class="flex items-center border-l-4 px-4 py-3 text-sm font-bold transition-colors {{ request()->routeIs('hackaton.info') ? 'border-emerald-700 bg-emerald-50 text-emerald-800' : 'border-transparent text-gray-700 hover:bg-gray-100 hover:text-gray-950' }}"><i class="fas fa-info-circle fa-fw w-6 text-center"></i><span class="ml-3">Informasi Hackaton</span></a>
    </nav>

    <div class="flex-shrink-0 border-t-2 border-gray-950 p-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex w-full items-center border-2 border-gray-950 px-4 py-3 text-sm font-black text-gray-950 transition-colors hover:bg-gray-950 hover:text-white"><i class="fas fa-sign-out-alt fa-fw w-6 text-center"></i><span class="ml-3">Logout</span></button>
        </form>
    </div>
</aside>
