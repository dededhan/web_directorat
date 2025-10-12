@extends('admin.admin')

@section('contentadmin')
    @php
        $firstRoute = $summaryCards->first()['route'] ?? route('admin.dashboard');
        $metrics = [
            [
                'label' => 'Total Records',
                'value' => number_format($totalRecords),
                'icon' => 'bx bx-line-chart',
                'description' => 'Akumulasi seluruh data yang dikelola sistem.',
                'color' => 'from-blue-500 to-blue-600',
                'bg' => 'bg-blue-50',
                'text' => 'text-blue-600',
            ],
            [
                'label' => 'Modul Aktif',
                'value' => $activeModules,
                'icon' => 'bx bx-layer',
                'description' => 'Jumlah modul dengan data aktif.',
                'color' => 'from-teal-500 to-teal-600',
                'bg' => 'bg-teal-50',
                'text' => 'text-teal-600',
            ],
        ];
    @endphp

    <div class="space-y-6">
        {{-- Header Section --}}
        <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-600 via-blue-500 to-cyan-500 p-8 shadow-lg">
            <div class="absolute right-0 top-0 h-full w-1/3 bg-white/5"></div>
            <div class="absolute -right-12 -top-12 h-64 w-64 rounded-full bg-white/10"></div>
            <div class="absolute -bottom-8 -right-8 h-48 w-48 rounded-full bg-white/10"></div>
            
            <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="max-w-2xl">
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-white/20 px-4 py-1.5 backdrop-blur-sm">
                        <i class='bx bxs-dashboard text-white'></i>
                        <span class="text-xs font-semibold uppercase tracking-wider text-white">Dashboard Admin</span>
                    </div>
                    <h1 class="text-4xl font-bold text-white">Halo, {{ $user->name }}! 👋</h1>
                    <p class="mt-3 text-base text-blue-50">Kelola dan pantau seluruh data direktorat dengan mudah dari sini.</p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <a href="{{ $firstRoute }}" class="group inline-flex items-center justify-center gap-2 rounded-xl bg-white px-6 py-3 text-sm font-semibold text-blue-600 shadow-lg transition hover:bg-blue-50 hover:shadow-xl">
                        <i class='bx bx-plus-circle text-lg transition group-hover:scale-110'></i>
                        Tambah Data
                    </a>
                    <a href="{{ route('admin.manageuser.index') }}" class="group inline-flex items-center justify-center gap-2 rounded-xl border-2 border-white/30 bg-white/10 px-6 py-3 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/20">
                        <i class='bx bxs-user-circle text-lg transition group-hover:scale-110'></i>
                        Kelola User
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
                {{-- Ringkasan Modul --}}
                <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100">
                                <i class='bx bx-folder-open text-xl text-blue-600'></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Ringkasan Modul</h2>
                                <p class="text-sm text-gray-600">Lihat jumlah data pada tiap modul</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid gap-4 p-6 sm:grid-cols-2">
                        @foreach ($summaryCards as $card)
                            <a href="{{ $card['route'] }}" class="group block rounded-xl border-2 border-gray-100 bg-gradient-to-br from-white to-gray-50 p-5 transition hover:border-blue-300 hover:shadow-md">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-gray-900 group-hover:text-blue-600">{{ $card['label'] }}</p>
                                        <p class="mt-1 text-xs leading-relaxed text-gray-500">{{ $card['description'] }}</p>
                                    </div>
                                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-blue-50 transition group-hover:bg-blue-100">
                                        <i class='bx {{ $card['icon'] }} text-2xl text-blue-600'></i>
                                    </div>
                                </div>
                                <div class="mt-5 flex items-center justify-between border-t border-gray-100 pt-4">
                                    <span class="text-2xl font-bold text-blue-600">{{ $card['total'] }}</span>
                                    <span class="text-xs font-semibold text-gray-500">records</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>

                {{-- Recent Activities --}}
                <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-100">
                                <i class='bx bx-time-five text-xl text-purple-600'></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Aktivitas Terbaru</h2>
                                <p class="text-sm text-gray-600">Catatan aktivitas sistem terkini</p>
                            </div>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse ($recentActivities as $item)
                            <div class="group px-6 py-4 transition hover:bg-gray-50">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                    <div class="flex-1">
                                        <div class="mb-2 flex flex-wrap items-center gap-2">
                                            <span class="inline-flex items-center gap-1 rounded-lg bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">
                                                <i class='bx bx-category text-sm'></i>
                                                {{ $item['feature'] }}
                                            </span>
                                            <span class="flex items-center gap-1 text-xs text-gray-400">
                                                <i class='bx bx-calendar text-sm'></i>
                                                {{ $item['created_at']->format('d M Y, H:i') }}
                                            </span>
                                        </div>
                                        <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600">{{ $item['title'] }}</p>
                                        @if ($item['note'])
                                            <p class="mt-1 text-xs leading-relaxed text-gray-500">{{ $item['note'] }}</p>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex items-center whitespace-nowrap rounded-lg px-3 py-1.5 text-xs font-bold {{ $item['status_color'] }}">
                                            {{ $item['status'] }}
                                        </span>
                                        <a href="{{ $item['manage_url'] }}" class="inline-flex items-center gap-1 text-sm font-bold text-blue-600 transition hover:text-blue-700">
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
                                <p class="text-sm font-medium text-gray-900">Belum ada aktivitas</p>
                                <p class="mt-1 text-xs text-gray-500">Aktivitas sistem akan muncul di sini</p>
                            </div>
                        @endforelse
                    </div>
                    @if ($recentActivities->hasPages())
                        <div class="border-t border-gray-100 bg-gray-50 px-6 py-4">
                            {{ $recentActivities->withQueryString()->onEachSide(1)->links() }}
                        </div>
                    @endif
                </section>
            </div>

            {{-- Sidebar Info --}}
            <div class="space-y-6">
                <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="bg-gradient-to-r from-amber-50 to-white px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100">
                                <i class='bx bxs-info-circle text-xl text-amber-600'></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Info Penting</h2>
                                <p class="text-sm text-gray-600">Tips & reminder</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-3 p-6">
                        <div class="group rounded-xl border-2 border-amber-100 bg-gradient-to-br from-amber-50 to-orange-50 p-4 transition hover:border-amber-300 hover:shadow-md">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-amber-100">
                                    <i class='bx bxs-data text-xl text-amber-600'></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-amber-900">Backup Data Berkala</p>
                                    <p class="mt-1 text-xs leading-relaxed text-amber-700">Pastikan melakukan backup data penting secara rutin</p>
                                </div>
                            </div>
                        </div>

                        <div class="group rounded-xl border-2 border-blue-100 bg-gradient-to-br from-blue-50 to-indigo-50 p-4 transition hover:border-blue-300 hover:shadow-md">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-blue-100">
                                    <i class='bx bxs-shield-alt-2 text-xl text-blue-600'></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-blue-900">Keamanan Akun</p>
                                    <p class="mt-1 text-xs leading-relaxed text-blue-700">Jangan bagikan password akun admin kepada siapapun</p>
                                </div>
                            </div>
                        </div>

                        <div class="group rounded-xl border-2 border-teal-100 bg-gradient-to-br from-teal-50 to-cyan-50 p-4 transition hover:border-teal-300 hover:shadow-md">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-teal-100">
                                    <i class='bx bxs-bell-ring text-xl text-teal-600'></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-teal-900">Update Berkala</p>
                                    <p class="mt-1 text-xs leading-relaxed text-teal-700">Pastikan data selalu up-to-date dan akurat</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
