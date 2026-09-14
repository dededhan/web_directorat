@extends('subdirektorat-inovasi.hackaton.layout')

@section('title', 'Dashboard ' . $roleLabel . ' | Hackaton UNJ')

@section('content_hackaton')
    <div class="space-y-6">
        <section class="rounded-2xl bg-gradient-to-r from-amber-500 to-orange-500 p-6 text-gray-900 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/30">
                    <i class="fas {{ $roleIcon }} text-3xl"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wider text-amber-950">Hackaton UNJ</p>
                    <h1 class="text-2xl font-bold">Selamat datang, {{ $user->name }}!</h1>
                    <p class="mt-1 text-sm text-amber-950">Dashboard {{ $roleLabel }}.</p>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <section class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm lg:col-span-2">
                <div class="mb-5 flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-amber-100 text-amber-700">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Profil Peserta</h2>
                        <p class="text-sm text-gray-500">Informasi akun yang digunakan untuk Hackaton.</p>
                    </div>
                </div>

                <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-gray-400">Nama</dt>
                        <dd class="mt-1 text-sm font-medium text-gray-800">{{ $user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-gray-400">Email</dt>
                        <dd class="mt-1 break-words text-sm font-medium text-gray-800">{{ $user->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-gray-400">Role</dt>
                        <dd class="mt-1 text-sm font-medium text-gray-800">{{ $roleLabel }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-gray-400">Fakultas</dt>
                        <dd class="mt-1 text-sm font-medium text-gray-800">{{ $user->profile?->fakultas?->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-gray-400">Program Studi</dt>
                        <dd class="mt-1 text-sm font-medium text-gray-800">{{ $user->profile?->prodi?->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-gray-400">Terdaftar Sejak</dt>
                        <dd class="mt-1 text-sm font-medium text-gray-800">{{ $user->created_at?->format('d M Y') ?? '-' }}</dd>
                    </div>
                </dl>
            </section>

            <section class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="mb-5 flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-green-100 text-green-700">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Status Akun</h2>
                        <p class="text-sm text-gray-500">Status akses Anda.</p>
                    </div>
                </div>
                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-700">
                    {{ ucfirst($user->status ?? 'active') }}
                </span>
                @if ($registration)
                    <p class="mt-4 text-sm leading-6 text-gray-600">
                        Registrasi Hackaton Anda telah {{ $registration->status_label }}.
                    </p>
                @else
                    <p class="mt-4 text-sm leading-6 text-gray-600">
                        Akun Anda aktif dan siap digunakan untuk mengikuti informasi Hackaton.
                    </p>
                @endif
            </section>
        </div>

        <section class="rounded-xl border border-dashed border-amber-300 bg-amber-50 p-8 text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-amber-100 text-amber-700">
                <i class="fas fa-rocket text-xl"></i>
            </div>
            <h2 class="mt-4 text-xl font-bold text-gray-800">Belum ada kegiatan aktif</h2>
            <p class="mx-auto mt-2 max-w-xl text-sm leading-6 text-gray-600">
                Informasi event, tim, dan pengumpulan karya akan muncul di sini ketika kegiatan Hackaton dibuka.
            </p>
            <a href="{{ route('hackaton.info') }}"
                class="mt-5 inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800">
                <i class="fas fa-info-circle"></i> Lihat Informasi
            </a>
        </section>
    </div>
@endsection
