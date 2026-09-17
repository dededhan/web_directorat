@extends('admin_hackaton.index')

@section('contentadmin_hackaton')
    <div class="space-y-8">
        <section class="border-b-4 border-gray-950 pb-8">
            <p class="mb-3 text-sm font-bold uppercase tracking-[0.18em] text-gray-600">Admin HackAthon / Ringkasan</p>
            <h1 class="max-w-4xl text-4xl font-black leading-tight tracking-tight text-gray-950 sm:text-5xl">
                Dashboard pendaftaran HackAthon
            </h1>
            <p class="mt-4 max-w-2xl text-lg leading-relaxed text-gray-700">
                Pantau peserta yang masuk dan lanjutkan proses verifikasi dari satu tempat.
            </p>
        </section>

        <section aria-labelledby="registration-summary-heading">
            <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 id="registration-summary-heading" class="text-2xl font-black text-gray-950">Ringkasan pendaftaran</h2>
                    <p class="mt-1 text-base text-gray-600">Jumlah pendaftaran berdasarkan status saat ini.</p>
                </div>
                <span class="text-sm font-bold uppercase tracking-wide text-gray-500">Data langsung</span>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ( [
                    ['label' => 'Total pendaftar', 'key' => 'totalRegistrations'],
                    ['label' => 'Menunggu ditinjau', 'key' => 'pendingRegistrations'],
                    ['label' => 'Disetujui', 'key' => 'approvedRegistrations'],
                    ['label' => 'Ditolak', 'key' => 'declinedRegistrations'],
                ] as $stat )
                    <div class="border-2 border-gray-950 bg-white p-5">
                        <p class="text-4xl font-black tabular-nums text-gray-950">{{ $stats[$stat['key']] }}</p>
                        <p class="mt-3 text-base font-bold text-gray-700">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="grid gap-6 border-2 border-gray-950 bg-white p-6 sm:p-8 lg:grid-cols-[1fr_auto] lg:items-center">
            <div>
                <p class="mb-2 text-sm font-bold uppercase tracking-[0.16em] text-gray-600">Tindakan berikutnya</p>
                <h2 class="text-2xl font-black text-gray-950">Tinjau pendaftaran peserta</h2>
                <p class="mt-2 max-w-2xl text-base leading-relaxed text-gray-700">
                    Buka daftar peserta untuk memeriksa data, menyetujui pendaftaran, atau menolak dengan catatan.
                </p>
            </div>
            <a href="{{ route('admin_hackaton.registrations.index') }}"
                class="inline-flex min-h-12 items-center justify-center bg-emerald-700 px-6 py-3 text-base font-black text-white transition-colors hover:bg-emerald-800 focus:outline-none focus:ring-4 focus:ring-emerald-200">
                Lihat pendaftaran
                <span aria-hidden="true" class="ml-3 text-xl">→</span>
            </a>
        </section>
    </div>
@endsection
