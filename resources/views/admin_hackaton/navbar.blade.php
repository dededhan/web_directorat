<header class="flex min-h-20 flex-shrink-0 items-center justify-between border-b border-black bg-white px-5 sm:px-8 lg:px-12">
    <div class="flex items-center gap-5">
        <button @click="sidebarOpen = !sidebarOpen" type="button" aria-label="Buka atau tutup navigasi"
            class="text-xl text-black transition hover:rotate-90">
            <span aria-hidden="true">☰</span>
        </button>
        <div class="hidden border-l border-black pl-5 sm:block">
            <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-gray-500">Panel administrasi</p>
            <p class="mt-1 text-xs font-semibold uppercase tracking-[0.12em]">Program HackAthon UNJ</p>
        </div>
    </div>

    <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" type="button" class="flex items-center gap-3 text-left">
            <span class="hidden text-xs font-semibold uppercase tracking-[0.1em] md:block">{{ auth()->user()->name ?? 'Admin' }}</span>
            <div class="flex h-10 w-10 items-center justify-center border border-black bg-black text-sm font-bold text-white">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
        </button>

        <div x-show="open" @click.away="open = false"
            class="absolute right-0 z-20 mt-4 w-48 border border-black bg-white py-1" x-transition x-cloak>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.1em] transition hover:bg-black hover:text-white">
                    ↳ &nbsp; Keluar
                </button>
            </form>
        </div>
    </div>
</header>
