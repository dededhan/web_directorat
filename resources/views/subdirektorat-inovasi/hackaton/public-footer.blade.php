<footer class="border-t-4 border-gray-950 bg-white">
    <div class="mx-auto max-w-7xl px-5 py-12 sm:px-8 lg:px-12">
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4 pb-8 border-b-2 border-gray-200">
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" alt="Logo UNJ" class="h-10 w-10 shrink-0">
                    <div>
                        <p class="text-lg font-black text-gray-950">Hackathon Deep Tech UNJ 2026</p>
                        <p class="text-xs font-bold text-emerald-700 uppercase tracking-wider">From Real-World Challenges to Deep Tech Innovation</p>
                    </div>
                </div>
                <p class="mt-4 max-w-md text-sm text-gray-600 leading-relaxed">
                    Program akselerasi inovasi berbasis deep technology yang mempertemukan civitas akademika dan mitra industri melalui jalur D-MARC UNJ & D-FARM UNJ.
                </p>
            </div>

            <div>
                <p class="text-xs font-black uppercase tracking-[0.16em] text-gray-500">Program & Jalur</p>
                <ul class="mt-3 space-y-2 text-sm font-bold text-gray-800">
                    <li><a href="{{ route('hackaton.info') }}#dmarc" class="hover:text-emerald-700 hover:underline">🏥 D-MARC UNJ (Health & MedTech)</a></li>
                    <li><a href="{{ route('hackaton.info') }}#dfarm" class="hover:text-emerald-700 hover:underline">🌾 D-FARM UNJ (Food & Smart Agro)</a></li>
                    <li><a href="{{ route('hackaton.info') }}#challenge" class="hover:text-emerald-700 hover:underline">Daftar Challenge & Problem Statement</a></li>
                    <li><a href="{{ route('hackaton.info') }}#jadwal" class="hover:text-emerald-700 hover:underline">Jadwal & Rangkaian 10 Bulan</a></li>
                </ul>
            </div>

            <div>
                <p class="text-xs font-black uppercase tracking-[0.16em] text-gray-500">Navigasi Cepat</p>
                <ul class="mt-3 space-y-2 text-sm font-bold text-gray-800">
                    <li><a href="{{ route('hackaton.info') }}#alur" class="hover:text-emerald-700 hover:underline">Alur Pendaftaran</a></li>
                    <li><a href="{{ route('hackaton.info') }}#peserta" class="hover:text-emerald-700 hover:underline">Komposisi Tim & Peserta</a></li>
                    <li><a href="{{ route('hackaton.info') }}#benefit" class="hover:text-emerald-700 hover:underline">Benefit & Fasilitasi</a></li>
                    <li><a href="{{ route('hackaton.info') }}#faq" class="hover:text-emerald-700 hover:underline">Tanya Jawab (FAQ)</a></li>
                    <li><a href="{{ route('hackaton.register.form') }}" class="text-emerald-700 hover:underline">Pendaftaran Akun Peserta →</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between text-xs text-gray-600">
            <div>
                <p class="font-bold text-gray-900">Direktorat Inovasi dan Hilirisasi Universitas Negeri Jakarta</p>
                <p class="mt-0.5">Gedung Ki Hajar Dewantara, Kampus A UNJ, Rawamangun, Jakarta Timur</p>
            </div>
            <a href="{{ route('subdirektorat-inovasi.landingpage') }}" class="font-bold text-emerald-700 underline-offset-4 hover:text-emerald-800 hover:underline">
                ← Kembali ke Portal Direktorat Inovasi
            </a>
        </div>
    </div>
</footer>
