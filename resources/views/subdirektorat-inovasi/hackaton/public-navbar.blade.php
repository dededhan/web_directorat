<header class="sticky top-0 z-30 border-b-2 border-gray-950 bg-white">
    <nav class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-5 py-4 sm:px-8 lg:px-12" aria-label="Navigasi Hackathon">
        <a href="{{ route('hackaton.info') }}" class="flex min-w-0 items-center gap-3 text-gray-950">
            <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" alt="Logo Universitas Negeri Jakarta" class="h-10 w-10 shrink-0">
            <span class="min-w-0">
                <span class="block text-base font-black leading-tight sm:text-lg">Hackathon Deep Tech UNJ</span>
                <span class="block text-[11px] font-bold uppercase tracking-[0.14em] text-emerald-700">2026 Edition</span>
            </span>
        </a>

        <div class="hidden items-center gap-5 xl:gap-6 lg:flex">
            <a href="{{ route('hackaton.info') }}#tentang" class="text-sm font-bold text-gray-700 underline-offset-4 hover:text-gray-950 hover:underline">Tentang</a>
            <a href="{{ route('hackaton.info') }}#challenge" class="text-sm font-bold text-gray-700 underline-offset-4 hover:text-gray-950 hover:underline">Challenge</a>
            <a href="{{ route('hackaton.info') }}#jadwal" class="text-sm font-bold text-gray-700 underline-offset-4 hover:text-gray-950 hover:underline">Jadwal</a>
            <a href="{{ route('hackaton.info') }}#peserta" class="text-sm font-bold text-gray-700 underline-offset-4 hover:text-gray-950 hover:underline">Peserta & Tim</a>
            <a href="{{ route('hackaton.info') }}#alur" class="text-sm font-bold text-gray-700 underline-offset-4 hover:text-gray-950 hover:underline">Alur</a>
            <a href="{{ route('hackaton.info') }}#benefit" class="text-sm font-bold text-gray-700 underline-offset-4 hover:text-gray-950 hover:underline">Benefit</a>
            <a href="{{ route('hackaton.info') }}#faq" class="text-sm font-bold text-gray-700 underline-offset-4 hover:text-gray-950 hover:underline">FAQ</a>
            <a href="{{ route('hackaton.register.form') }}" class="bg-emerald-700 px-4 py-2.5 text-sm font-black text-white hover:bg-emerald-800">Daftar sekarang</a>
            @if(auth()->check())
                <a href="{{ route('hackaton.dashboard') }}" class="border-2 border-gray-950 bg-white px-4 py-2 text-sm font-bold text-gray-950 hover:bg-gray-100">Dashboard</a>
            @else
                <button type="button" class="login border-2 border-gray-950 bg-white px-4 py-2 text-sm font-bold text-gray-950 hover:bg-gray-100 cursor-pointer">Masuk</button>
            @endif
        </div>

        <div class="flex items-center gap-3 lg:hidden" x-data="{ open: false }">
            <a href="{{ route('hackaton.register.form') }}" class="bg-emerald-700 px-3 py-2 text-xs font-black text-white sm:text-sm">Daftar</a>
            <button type="button" @click="open = !open" :aria-expanded="open.toString()" aria-controls="hackaton-mobile-menu" class="border-2 border-gray-950 px-3 py-2 text-sm font-black text-gray-950">
                Menu
            </button>
            <div id="hackaton-mobile-menu" x-show="open" @click.outside="open = false" x-cloak class="absolute left-5 right-5 top-[68px] z-30 border-2 border-gray-950 bg-white p-4 shadow-lg sm:left-8 sm:right-8">
                <div class="grid gap-2 text-sm font-bold">
                    <a href="{{ route('hackaton.info') }}#tentang" @click="open = false" class="border-b border-gray-200 py-2 text-gray-950">Tentang Program</a>
                    <a href="{{ route('hackaton.info') }}#challenge" @click="open = false" class="border-b border-gray-200 py-2 text-gray-950">Pilih Challenge</a>
                    <a href="{{ route('hackaton.info') }}#jadwal" @click="open = false" class="border-b border-gray-200 py-2 text-gray-950">Jadwal Program</a>
                    <a href="{{ route('hackaton.info') }}#peserta" @click="open = false" class="border-b border-gray-200 py-2 text-gray-950">Peserta & Komponen Tim</a>
                    <a href="{{ route('hackaton.info') }}#proses" @click="open = false" class="border-b border-gray-200 py-2 text-gray-950">Tahapan Kerja</a>
                    <a href="{{ route('hackaton.info') }}#alur" @click="open = false" class="border-b border-gray-200 py-2 text-gray-950">Alur Pendaftaran</a>
                    <a href="{{ route('hackaton.info') }}#benefit" @click="open = false" class="border-b border-gray-200 py-2 text-gray-950">Benefit</a>
                    <a href="{{ route('hackaton.info') }}#faq" @click="open = false" class="border-b border-gray-200 py-2 text-gray-950">FAQ</a>
                    <a href="{{ route('hackaton.register.form') }}" class="mt-2 bg-emerald-700 py-3 text-center text-white font-black">Daftar Sekarang</a>
                    @if(auth()->check())
                        <a href="{{ route('hackaton.dashboard') }}" class="border-2 border-gray-950 py-2 text-center text-gray-950">Buka Dashboard</a>
                    @else
                        <button type="button" class="login border-2 border-gray-950 py-2 text-center text-gray-950 cursor-pointer">Masuk Peserta</button>
                    @endif
                    <a href="{{ route('subdirektorat-inovasi.landingpage') }}" class="text-xs text-gray-500 text-center pt-2">← Kembali ke Direktorat Inovasi</a>
                </div>
            </div>
        </div>
    </nav>
</header>
