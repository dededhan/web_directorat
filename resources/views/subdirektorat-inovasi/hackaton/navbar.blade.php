<header class="flex h-20 flex-shrink-0 items-center justify-between border-b-2 border-gray-950 bg-white px-6">
    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = !sidebarOpen" type="button" aria-label="Buka atau tutup navigasi"
            class="border-2 border-gray-950 px-3 py-2 text-gray-950 hover:bg-gray-100 focus:outline-none">
            <i class="fas fa-bars text-lg" aria-hidden="true"></i>
        </button>
        <div class="hidden border-l-2 border-gray-300 pl-4 sm:block">
            <p class="text-xs font-black uppercase tracking-[0.16em] text-emerald-700">Ruang peserta</p>
            <p class="text-sm font-bold text-gray-950">Hackaton UNJ</p>
        </div>
    </div>

    <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" :aria-expanded="open.toString()" type="button" class="flex items-center gap-3 text-left focus:outline-none">
            <span class="hidden text-sm font-bold text-gray-700 md:block">{{ auth()->user()->name ?? 'Peserta' }}</span>
            <span class="flex h-10 w-10 items-center justify-center border-2 border-gray-950 bg-emerald-700 font-black text-white" aria-hidden="true">
                {{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 1)) }}
            </span>
        </button>

        <div x-show="open" @click.away="open = false"
            class="absolute right-0 z-20 mt-3 w-64 border-2 border-gray-950 bg-white py-2" x-transition x-cloak>
            <div class="border-b-2 border-gray-950 px-4 py-3 text-sm text-gray-700">
                Masuk sebagai <strong class="text-gray-950">{{ auth()->user()->role ?? 'Peserta' }}</strong>
            </div>
            <a href="{{ route('hackaton.dashboard') }}" class="block px-4 py-3 text-sm font-bold text-gray-950 hover:bg-gray-100">
                Profil dan akun
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full border-t border-gray-300 px-4 py-3 text-left text-sm font-bold text-gray-950 hover:bg-gray-100">
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>
