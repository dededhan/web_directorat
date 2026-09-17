<header class="border-b-2 border-gray-950 bg-white">
    <nav class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-5 py-5 sm:px-8 lg:px-12" aria-label="Navigasi Hackathon">
        <a href="{{ route('hackaton.info') }}" class="flex min-w-0 items-center gap-3 text-gray-950">
            <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" alt="Logo Universitas Negeri Jakarta" class="h-11 w-11 shrink-0">
            <span class="min-w-0">
                <span class="block text-lg font-black leading-tight">Hackathon UNJ</span>
                <span class="block text-xs font-bold uppercase tracking-[0.14em] text-gray-600">Program inovasi</span>
            </span>
        </a>

        <div class="hidden items-center gap-6 md:flex">
            <a href="{{ route('hackaton.info') }}#tentang" class="text-sm font-bold text-gray-700 underline-offset-4 hover:text-gray-950 hover:underline">Tentang</a>
            <a href="{{ route('hackaton.info') }}#alur" class="text-sm font-bold text-gray-700 underline-offset-4 hover:text-gray-950 hover:underline">Alur</a>
            <a href="{{ route('hackaton.register.form') }}" class="bg-emerald-700 px-5 py-3 text-sm font-black text-white hover:bg-emerald-800">Daftar sekarang</a>
            <a href="{{ route('subdirektorat-inovasi.landingpage') }}" class="text-sm font-bold text-gray-700 underline-offset-4 hover:text-gray-950 hover:underline">Kembali ke Direktorat Inovasi</a>
        </div>

        <div class="flex items-center gap-3 md:hidden" x-data="{ open: false }">
            <button type="button" @click="open = !open" :aria-expanded="open.toString()" aria-controls="hackaton-mobile-menu" class="border-2 border-gray-950 px-3 py-2 text-sm font-black text-gray-950">
                Menu
            </button>
            <div id="hackaton-mobile-menu" x-show="open" @click.outside="open = false" x-cloak class="absolute left-5 right-5 top-[76px] z-20 border-2 border-gray-950 bg-white p-4 sm:left-8 sm:right-8">
                <div class="grid gap-3">
                    <a href="{{ route('hackaton.info') }}#tentang" class="border-b border-gray-300 py-2 text-sm font-bold text-gray-950">Tentang</a>
                    <a href="{{ route('hackaton.info') }}#alur" class="border-b border-gray-300 py-2 text-sm font-bold text-gray-950">Alur</a>
                    <a href="{{ route('hackaton.register.form') }}" class="bg-emerald-700 px-4 py-3 text-center text-sm font-black text-white">Daftar sekarang</a>
                    <a href="{{ route('subdirektorat-inovasi.landingpage') }}" class="border-2 border-gray-950 px-4 py-3 text-center text-sm font-black text-gray-950">Kembali ke Direktorat Inovasi</a>
                </div>
            </div>
        </div>
    </nav>
</header>
