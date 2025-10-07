@extends('subdirektorat-inovasi.dosen.index')

@section('content')
    @php
        $firstRoute = $summaryCards->first()['route'] ?? route('subdirektorat-inovasi.dosen.dashboard');
        $metrics = [
            [
                'label' => 'Total Pengajuan',
                'value' => number_format($totalSubmissions),
                'icon' => 'bx bx-line-chart',
                'description' => 'Akumulasi seluruh program yang pernah diajukan.',
                'color' => 'from-blue-500 to-blue-600',
                'bg' => 'bg-blue-50',
                'text' => 'text-blue-600',
            ],
            [
                'label' => 'Fitur Aktif',
                'value' => $activePrograms,
                'icon' => 'bx bx-layer',
                'description' => 'Jumlah layanan dengan pengajuan aktif atau riwayat.',
                'color' => 'from-teal-500 to-teal-600',
                'bg' => 'bg-teal-50',
                'text' => 'text-teal-600',
            ],
        ];
    @endphp

    <div class="space-y-6">
        {{-- Header Section --}}
        <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-teal-600 via-teal-500 to-cyan-500 p-8 shadow-lg">
            <div class="absolute right-0 top-0 h-full w-1/3 bg-white/5"></div>
            <div class="absolute -right-12 -top-12 h-64 w-64 rounded-full bg-white/10"></div>
            <div class="absolute -bottom-8 -right-8 h-48 w-48 rounded-full bg-white/10"></div>
            
            <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="max-w-2xl">
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-white/20 px-4 py-1.5 backdrop-blur-sm">
                        <i class='bx bxs-dashboard text-white'></i>
                        <span class="text-xs font-semibold uppercase tracking-wider text-white">Dashboard Dosen</span>
                    </div>
                    <h1 class="text-4xl font-bold text-white">Halo, {{ $user->name }}! 👋</h1>
                    <p class="mt-3 text-base text-teal-50">Lihat ringkasan singkat semua pengajuan dan tindak lanjut yang perlu Anda lakukan.</p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <a href="{{ $firstRoute }}" class="group inline-flex items-center justify-center gap-2 rounded-xl bg-white px-6 py-3 text-sm font-semibold text-teal-600 shadow-lg transition hover:bg-teal-50 hover:shadow-xl">
                        <i class='bx bx-rocket text-lg transition group-hover:scale-110'></i>
                        Mulai Pengajuan
                    </a>
                    <a href="{{ route('subdirektorat-inovasi.dosen.manageprofile.edit') }}" class="group inline-flex items-center justify-center gap-2 rounded-xl border-2 border-white/30 bg-white/10 px-6 py-3 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/20">
                        <i class='bx bxs-user-circle text-lg transition group-hover:scale-110'></i>
                        Perbarui Profil
                    </a>
                </div>
            </div>
        </section>

        {{-- Metrics Cards --}}
        <div class="grid gap-6 sm:grid-cols-2">
            @foreach ($metrics as $metric)
                <div class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-8 shadow-sm transition hover:shadow-lg">
                    <div class="absolute -right-8 -top-8 h-40 w-40 rounded-full {{ $metric['bg'] }} opacity-50 transition group-hover:scale-125"></div>
                    <div class="relative">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <p class="text-sm font-semibold uppercase tracking-wider text-gray-500">{{ $metric['label'] }}</p>
                                <p class="mt-4 text-5xl font-bold text-gray-900">{{ $metric['value'] }}</p>
                                <p class="mt-3 text-sm leading-relaxed text-gray-600">{{ $metric['description'] }}</p>
                            </div>
                            <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br {{ $metric['color'] }} shadow-lg">
                                <i class='{{ $metric['icon'] }} text-4xl text-white'></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Main Content Grid --}}
        <div class="grid gap-6 lg:grid-cols-3">
            {{-- Main Content --}}
            <div class="space-y-6 lg:col-span-2">
                {{-- Ringkasan Pengajuan --}}
                <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-100">
                                <i class='bx bx-folder-open text-xl text-teal-600'></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Ringkasan Pengajuan</h2>
                                <p class="text-sm text-gray-600">Lihat jumlah pengajuan pada tiap fitur</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid gap-4 p-6 sm:grid-cols-2">
                        @foreach ($summaryCards as $card)
                            <a href="{{ $card['route'] }}" class="group block rounded-xl border-2 border-gray-100 bg-gradient-to-br from-white to-gray-50 p-5 transition hover:border-teal-300 hover:shadow-md">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-gray-900 group-hover:text-teal-600">{{ $card['label'] }}</p>
                                        <p class="mt-1 text-xs leading-relaxed text-gray-500">{{ $card['description'] }}</p>
                                    </div>
                                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-teal-50 transition group-hover:bg-teal-100">
                                        <i class='bx {{ $card['icon'] }} text-2xl text-teal-600'></i>
                                    </div>
                                </div>
                                <div class="mt-5 flex items-center justify-between border-t border-gray-100 pt-4">
                                    <span class="text-2xl font-bold text-teal-600">{{ $card['total'] }}</span>
                                    <span class="text-xs font-semibold text-gray-500">pengajuan</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>

                {{-- Recent Submissions --}}
                <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-100">
                                <i class='bx bx-time-five text-xl text-purple-600'></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Riwayat Pengajuan Terbaru</h2>
                                <p class="text-sm text-gray-600">Catatan aktivitas lintas layanan</p>
                            </div>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse ($recentSubmissions as $item)
                            <div class="group px-6 py-4 transition hover:bg-gray-50">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                    <div class="flex-1">
                                        <div class="mb-2 flex flex-wrap items-center gap-2">
                                            <span class="inline-flex items-center gap-1 rounded-lg bg-teal-50 px-3 py-1 text-xs font-bold text-teal-700">
                                                <i class='bx bx-category text-sm'></i>
                                                {{ $item['feature'] }}
                                            </span>
                                            <span class="flex items-center gap-1 text-xs text-gray-400">
                                                <i class='bx bx-calendar text-sm'></i>
                                                {{ $item['created_at']->format('d M Y, H:i') }}
                                            </span>
                                        </div>
                                        <p class="text-sm font-semibold text-gray-900 group-hover:text-teal-600">{{ $item['title'] }}</p>
                                        @if ($item['note'])
                                            <p class="mt-1 text-xs leading-relaxed text-gray-500">{{ $item['note'] }}</p>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex items-center whitespace-nowrap rounded-lg px-3 py-1.5 text-xs font-bold {{ $item['status_color'] }}">
                                            {{ $item['status'] }}
                                        </span>
                                        <a href="{{ $item['manage_url'] }}" class="inline-flex items-center gap-1 text-sm font-bold text-teal-600 transition hover:text-teal-700">
                                            Lihat <i class='bx bx-right-arrow-alt text-base'></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-12 text-center">
                                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                                    <i class='bx bx-file text-3xl text-gray-400'></i>
                                </div>
                                <p class="text-sm font-medium text-gray-900">Belum ada riwayat pengajuan</p>
                                <p class="mt-1 text-xs text-gray-500">Ajukan proposal pertama Anda untuk mulai melacak progres di sini</p>
                            </div>
                        @endforelse
                    </div>
                    @if ($recentSubmissions->hasPages())
                        <div class="border-t border-gray-100 bg-gray-50 px-6 py-4">
                            {{ $recentSubmissions->withQueryString()->onEachSide(1)->links('vendor.pagination.tailwind-teal') }}
                        </div>
                    @endif
                </section>
            </div>

            {{-- Sidebar Pengingat --}}
            <div class="space-y-6">
                <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="bg-gradient-to-r from-amber-50 to-white px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100">
                                <i class='bx bxs-bell-ring text-xl text-amber-600'></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Pengingat Penting</h2>
                                <p class="text-sm text-gray-600">Tips & reminder</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-3 p-6">
                        <div class="group rounded-xl border-2 border-amber-100 bg-gradient-to-br from-amber-50 to-orange-50 p-4 transition hover:border-amber-300 hover:shadow-md">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-amber-100">
                                    <i class='bx bxs-calendar-exclamation text-xl text-amber-600'></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-amber-900">Periksa tenggat tiap sesi</p>
                                    <p class="mt-1 text-xs leading-relaxed text-amber-700">Masuk ke halaman manajemen fitur untuk melihat tanggal berakhir pengajuan</p>
                                </div>
                            </div>
                        </div>

                        <div class="group rounded-xl border-2 border-teal-100 bg-gradient-to-br from-teal-50 to-cyan-50 p-4 transition hover:border-teal-300 hover:shadow-md">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-teal-100">
                                    <i class='bx bxs-bell-ring text-xl text-teal-600'></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-teal-900">Atur pengingat pribadi</p>
                                    <p class="mt-1 text-xs leading-relaxed text-teal-700">Gunakan kalender pribadi atau pengingat perangkat agar tidak melewatkan jadwal</p>
                                </div>
                            </div>
                        </div>

                        <div class="group rounded-xl border-2 border-blue-100 bg-gradient-to-br from-blue-50 to-indigo-50 p-4 transition hover:border-blue-300 hover:shadow-md">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-blue-100">
                                    <i class='bx bxs-file-find text-xl text-blue-600'></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-blue-900">Siapkan dokumen lebih awal</p>
                                    <p class="mt-1 text-xs leading-relaxed text-blue-700">Pastikan semua berkas siap minimal sehari sebelum sesi ditutup</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

