@extends('subdirektorat-inovasi.hackaton.public-layout')

@section('title', 'Daftar Akun | Hackaton UNJ')

@section('content_public_hackaton')
    <div class="mx-auto max-w-7xl px-5 py-10 sm:px-8 lg:px-12 lg:py-16">
        <div class="mb-8 flex flex-col gap-3 border-b-4 border-gray-950 pb-8 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="mb-3 text-sm font-black uppercase tracking-[0.2em] text-emerald-700">Pendaftaran peserta</p>
                <h1 class="text-4xl font-black leading-tight text-gray-950 sm:text-5xl">Buat akun HackAthon</h1>
                <p class="mt-3 max-w-2xl text-lg leading-relaxed text-gray-700">Lengkapi data berikut. Pendaftaran akan ditinjau oleh admin sebelum akun diaktifkan.</p>
            </div>
            <a href="{{ route('hackaton.info') }}" class="text-base font-black text-emerald-700 underline-offset-4 hover:text-emerald-800 hover:underline">← Kembali ke informasi</a>
        </div>

        <div class="grid gap-8 lg:grid-cols-[.7fr_1.3fr]">
            <aside class="border-2 border-gray-950 bg-white p-6 lg:p-8">
                <p class="text-sm font-black uppercase tracking-[0.16em] text-gray-600">Sebelum mendaftar</p>
                <h2 class="mt-4 text-3xl font-black leading-tight text-gray-950">Mulai dari ide Anda.</h2>
                <p class="mt-4 text-base leading-relaxed text-gray-700">Bergabung dalam ruang kolaborasi untuk membangun solusi inovatif bersama HackAthon UNJ.</p>
                <ul class="mt-8 space-y-5 text-base font-bold text-gray-950">
                    <li class="flex items-start gap-3"><span class="text-emerald-700" aria-hidden="true">01</span><span>Kolaborasi lintas bidang</span></li>
                    <li class="flex items-start gap-3"><span class="text-emerald-700" aria-hidden="true">02</span><span>Kembangkan solusi berdampak</span></li>
                    <li class="flex items-start gap-3"><span class="text-emerald-700" aria-hidden="true">03</span><span>Tumbuh bersama ekosistem inovasi</span></li>
                </ul>
            </aside>

            <section class="border-2 border-gray-950 bg-white p-6 sm:p-8 lg:p-10" x-data="{ showPassword: false, showConfirmation: false }">
                <h2 class="text-2xl font-black text-gray-950">Data akun</h2>
                <p class="mt-2 text-base text-gray-600"><span class="text-red-700">*</span> Wajib diisi.</p>

                @if (session('success'))
                    <div class="mt-6 border-2 border-emerald-700 bg-emerald-50 p-4 text-base font-bold text-emerald-900" role="status">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="mt-6 border-2 border-red-700 bg-red-50 p-4 text-base text-red-900" role="alert">
                        <p class="font-black">Periksa kembali data Anda:</p>
                        <ul class="mt-2 list-disc space-y-1 pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('hackaton.register.submit') }}" method="POST" class="mt-8 space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="mb-2 block text-base font-black text-gray-950">Nama lengkap <span class="text-red-700">*</span></label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autocomplete="name" class="w-full border-2 border-gray-950 bg-white px-4 py-3 text-base text-gray-950 placeholder:text-gray-500 focus:border-emerald-700 focus:outline-none" placeholder="Masukkan nama lengkap Anda">
                    </div>
                    <div>
                        <label for="email" class="mb-2 block text-base font-black text-gray-950">Email <span class="text-red-700">*</span></label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" class="w-full border-2 border-gray-950 bg-white px-4 py-3 text-base text-gray-950 placeholder:text-gray-500 focus:border-emerald-700 focus:outline-none" placeholder="contoh@email.com">
                    </div>
                    <div>
                        <label for="role" class="mb-2 block text-base font-black text-gray-950">Daftar sebagai <span class="text-red-700">*</span></label>
                        <select id="role" name="role" required class="w-full border-2 border-gray-950 bg-white px-4 py-3 text-base text-gray-950 focus:border-emerald-700 focus:outline-none">
                            <option value="">Pilih role peserta</option>
                            @foreach ($roleLabels as $roleKey => $roleLabel)
                                <option value="{{ $roleKey }}" @selected(old('role') === $roleKey)>{{ $roleLabel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="password" class="mb-2 block text-base font-black text-gray-950">Password <span class="text-red-700">*</span></label>
                            <div class="flex">
                                <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required autocomplete="new-password" class="min-w-0 flex-1 border-2 border-r-0 border-gray-950 bg-white px-4 py-3 text-base text-gray-950 placeholder:text-gray-500 focus:border-emerald-700 focus:outline-none" placeholder="Min. 8 karakter">
                                <button type="button" @click="showPassword = !showPassword" class="border-2 border-gray-950 bg-gray-100 px-3 text-sm font-black text-gray-950 hover:bg-gray-200" :aria-label="showPassword ? 'Sembunyikan password' : 'Tampilkan password'"><span x-text="showPassword ? 'Sembunyikan' : 'Tampilkan'"></span></button>
                            </div>
                        </div>
                        <div>
                            <label for="password_confirmation" class="mb-2 block text-base font-black text-gray-950">Konfirmasi password <span class="text-red-700">*</span></label>
                            <div class="flex">
                                <input :type="showConfirmation ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" class="min-w-0 flex-1 border-2 border-r-0 border-gray-950 bg-white px-4 py-3 text-base text-gray-950 placeholder:text-gray-500 focus:border-emerald-700 focus:outline-none" placeholder="Ulangi password">
                                <button type="button" @click="showConfirmation = !showConfirmation" class="border-2 border-gray-950 bg-gray-100 px-3 text-sm font-black text-gray-950 hover:bg-gray-200" :aria-label="showConfirmation ? 'Sembunyikan konfirmasi password' : 'Tampilkan konfirmasi password'"><span x-text="showConfirmation ? 'Sembunyikan' : 'Tampilkan'"></span></button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="min-h-12 w-full bg-emerald-700 px-6 py-3 text-base font-black text-white hover:bg-emerald-800">Kirim pendaftaran <span aria-hidden="true" class="ml-2">→</span></button>
                    <p class="text-center text-base text-gray-700">Sudah punya akun? <a href="{{ route('hackaton.dashboard') }}" class="font-black text-emerald-700 underline-offset-4 hover:text-emerald-800 hover:underline">Masuk di sini</a></p>
                </form>
            </section>
        </div>
    </div>
@endsection
