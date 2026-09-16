@extends('subdirektorat-inovasi.hackaton.public-layout')

@section('title', 'Hackaton UNJ | Direktorat Inovasi')

@section('content_public_hackaton')
    <div class="mx-auto max-w-7xl px-5 py-10 sm:px-8 lg:px-12 lg:py-16">
        <section class="border-b-4 border-gray-950 pb-12 lg:pb-16">
            <div class="grid gap-10 lg:grid-cols-[1.25fr_.75fr] lg:items-end">
                <div>
                    <p class="mb-5 text-sm font-black uppercase tracking-[0.2em] text-emerald-700">Program inovasi UNJ</p>
                    <h1 class="max-w-5xl text-5xl font-black leading-[0.98] tracking-tight text-gray-950 sm:text-6xl lg:text-7xl">Hackaton UNJ</h1>
                    <p class="mt-7 max-w-3xl text-xl leading-relaxed text-gray-700">Ruang kolaborasi untuk mengubah ide kreatif menjadi solusi inovatif yang menjawab tantangan nyata.</p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('hackaton.register.form') }}" class="inline-flex min-h-12 items-center justify-center bg-emerald-700 px-6 py-3 text-base font-black text-white hover:bg-emerald-800">Daftar sekarang <span aria-hidden="true" class="ml-3">→</span></a>
                        <a href="{{ route('hackaton.dashboard') }}" class="inline-flex min-h-12 items-center justify-center border-2 border-gray-950 bg-white px-6 py-3 text-base font-black text-gray-950 hover:bg-gray-100">{{ auth()->check() ? 'Buka dashboard' : 'Masuk peserta' }}</a>
                    </div>
                </div>
                <div class="border-2 border-gray-950 bg-white p-6 lg:p-8">
                    <p class="text-sm font-black uppercase tracking-[0.16em] text-gray-600">Untuk siapa?</p>
                    <p class="mt-4 text-2xl font-black leading-tight text-gray-950">Civitas akademika dan mitra yang ingin membuat solusi berdampak.</p>
                    <a href="#tentang" class="mt-6 inline-block text-base font-black text-emerald-700 underline-offset-4 hover:text-emerald-800 hover:underline">Pelajari program <span aria-hidden="true">↓</span></a>
                </div>
            </div>
        </section>

        <section id="tentang" class="scroll-mt-8 border-b-2 border-gray-950 py-12 lg:py-16">
            <div class="grid gap-8 lg:grid-cols-[.7fr_1.3fr]">
                <h2 class="text-4xl font-black leading-tight text-gray-950">Tentang Hackaton</h2>
                <div>
                    <p class="text-lg leading-relaxed text-gray-700">Hackaton UNJ merupakan wadah bagi civitas akademika dan mitra untuk berkolaborasi, merumuskan masalah, serta mengembangkan prototipe solusi berbasis inovasi. Peserta akan mengikuti rangkaian kegiatan sesuai ketentuan event yang dibuka oleh Direktorat Inovasi dan Hilirisasi.</p>
                    <div class="mt-10 grid gap-4 md:grid-cols-3">
                        @foreach ([['number' => '01', 'title' => 'Kembangkan ide', 'text' => 'Rumuskan gagasan yang relevan untuk menjawab tantangan dan kebutuhan nyata.'], ['number' => '02', 'title' => 'Kolaborasi', 'text' => 'Bangun tim lintas disiplin dan belajar dari peserta serta mentor lainnya.'], ['number' => '03', 'title' => 'Ciptakan dampak', 'text' => 'Kembangkan solusi yang dapat diuji, dipresentasikan, dan memberi manfaat.']] as $item)
                            <article class="border-2 border-gray-950 bg-white p-5">
                                <p class="text-sm font-black text-emerald-700">{{ $item['number'] }}</p>
                                <h3 class="mt-8 text-xl font-black text-gray-950">{{ $item['title'] }}</h3>
                                <p class="mt-3 text-base leading-relaxed text-gray-700">{{ $item['text'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section id="alur" class="scroll-mt-8 border-b-2 border-gray-950 py-12 lg:py-16">
            <div class="grid gap-8 lg:grid-cols-[.7fr_1.3fr]">
                <h2 class="text-4xl font-black leading-tight text-gray-950">Alur keikutsertaan</h2>
                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach ([['number' => '01', 'title' => 'Registrasi', 'text' => 'Buat akun peserta melalui halaman pendaftaran.'], ['number' => '02', 'title' => 'Verifikasi', 'text' => 'Admin memeriksa dan menyetujui pendaftaran.'], ['number' => '03', 'title' => 'Ikuti event', 'text' => 'Lengkapi ketentuan dan rangkaian kegiatan Hackaton.'], ['number' => '04', 'title' => 'Presentasi', 'text' => 'Tampilkan solusi dan raih kesempatan pengembangan.']] as $item)
                        <article class="border-2 border-gray-950 bg-white p-5">
                            <p class="text-sm font-black text-emerald-700">Langkah {{ $item['number'] }}</p>
                            <h3 class="mt-3 text-xl font-black text-gray-950">{{ $item['title'] }}</h3>
                            <p class="mt-2 text-base leading-relaxed text-gray-700">{{ $item['text'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="border-2 border-gray-950 bg-white px-6 py-10 sm:px-10 lg:flex lg:items-center lg:justify-between lg:gap-8">
            <div>
                <p class="text-sm font-black uppercase tracking-[0.16em] text-gray-600">Mulai sekarang</p>
                <h2 class="mt-3 text-3xl font-black text-gray-950 sm:text-4xl">Siap membawa ide Anda lebih jauh?</h2>
                <p class="mt-3 max-w-2xl text-base leading-relaxed text-gray-700">Buat akun Hackaton sekarang. Informasi event, ketentuan, dan jadwal lengkap akan mengikuti pembukaan program.</p>
            </div>
            <a href="{{ route('hackaton.register.form') }}" class="mt-7 inline-flex min-h-12 shrink-0 items-center justify-center bg-emerald-700 px-6 py-3 text-base font-black text-white hover:bg-emerald-800 lg:mt-0">Mulai pendaftaran <span aria-hidden="true" class="ml-3">→</span></a>
        </section>
    </div>
@endsection

