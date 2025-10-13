@extends('admin.admin')

@section('contentadmin')
    {{-- Data sudah dikirim dari controller: $user, $metrics, $quickLinks, $stats, $recentActivities, $systemInfo --}}

    <div class="space-y-6 p-6">
        {{-- Header Section --}}
        <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-teal-600 via-teal-500 to-cyan-500 p-8 shadow-lg">
            <div class="absolute right-0 top-0 h-full w-1/3 bg-white/5"></div>
            <div class="absolute -right-12 -top-12 h-64 w-64 rounded-full bg-white/10"></div>
            <div class="absolute -bottom-8 -right-8 h-48 w-48 rounded-full bg-white/10"></div>
            
            <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="max-w-2xl">
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-white/20 px-4 py-1.5 backdrop-blur-sm">
                        <i class='bx bxs-dashboard text-white'></i>
                        <span class="text-xs font-semibold uppercase tracking-wider text-white">Dashboard Admin</span>
                    </div>
                    <h1 class="text-4xl font-bold text-white">Selamat Datang, {{ $user->name }}! 👋</h1>
                    <p class="mt-3 text-base text-teal-50">Kelola seluruh konten dan data sistem Direktorat UNJ dengan mudah dari sini.</p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('admin.news.index') }}" class="group inline-flex items-center justify-center gap-2 rounded-xl bg-white px-6 py-3 text-sm font-semibold text-teal-600 shadow-lg transition hover:bg-teal-50 hover:shadow-xl">
                        <i class='bx bx-plus-circle text-lg transition group-hover:scale-110'></i>
                        Tambah Berita
                    </a>
                </div>
            </div>
        </section>

        {{-- Metrics Cards --}}
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($metrics as $metric)
                <div class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-lg">
                    <div class="absolute -right-6 -top-6 h-32 w-32 rounded-full {{ $metric['bg'] }} opacity-50 transition group-hover:scale-125"></div>
                    <div class="relative">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">{{ $metric['label'] }}</p>
                                <p class="mt-3 text-4xl font-bold text-gray-900">{{ $metric['value'] }}</p>
                                <p class="mt-2 text-xs leading-relaxed text-gray-600">{{ $metric['description'] }}</p>
                            </div>
                            <div class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br {{ $metric['color'] }} shadow-lg">
                                <i class='{{ $metric['icon'] }} text-3xl text-white'></i>
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
                {{-- Quick Access --}}
                <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-100">
                                <i class='bx bx-rocket text-xl text-teal-600'></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Quick Access</h2>
                                <p class="text-sm text-gray-600">Akses cepat ke fitur utama</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid gap-4 p-6 sm:grid-cols-2">
                        @foreach ($quickLinks as $link)
                            <a href="{{ $link['route'] }}" class="group block rounded-xl border-2 border-gray-100 bg-gradient-to-br from-white to-gray-50 p-5 transition hover:border-teal-300 hover:shadow-md">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-gray-900 group-hover:text-teal-600">{{ $link['title'] }}</p>
                                        <p class="mt-1 text-xs leading-relaxed text-gray-500">{{ $link['description'] }}</p>
                                    </div>
                                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl {{ $link['bg'] }} transition group-hover:scale-110">
                                        <i class='{{ $link['icon'] }} text-2xl {{ $link['color'] }}'></i>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>

                {{-- UNJ Statistics --}}
                <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100">
                                <i class='bx bxs-graduation text-xl text-blue-600'></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">UNJ dalam Angka</h2>
                                <p class="text-sm text-gray-600">Statistik Universitas Negeri Jakarta</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid gap-4 p-6 sm:grid-cols-3">
                        @foreach ($stats as $stat)
                            <div class="rounded-xl border border-gray-100 bg-gradient-to-br from-{{ $stat['color'] }}-50 to-white p-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-{{ $stat['color'] }}-100">
                                        <i class='{{ $stat['icon'] }} text-xl text-{{ $stat['color'] }}-600'></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-2xl font-bold text-gray-900">{{ $stat['value'] }}</p>
                                        <p class="text-xs text-gray-600">{{ $stat['label'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>

            {{-- Sidebar Info --}}
            <div class="space-y-6">
                {{-- System Info --}}
                <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="bg-gradient-to-r from-amber-50 to-white px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100">
                                <i class='bx bxs-info-circle text-xl text-amber-600'></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Informasi Sistem</h2>
                                <p class="text-sm text-gray-600">Status & info penting</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-3 p-6">
                        <div class="group rounded-xl border-2 border-green-100 bg-gradient-to-br from-green-50 to-emerald-50 p-4 transition hover:border-green-300 hover:shadow-md">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-green-100">
                                    <i class='bx bxs-check-circle text-xl text-green-600'></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-green-900">Sistem Berjalan Normal</p>
                                    <p class="mt-1 text-xs leading-relaxed text-green-700">Semua layanan berfungsi dengan baik</p>
                                </div>
                            </div>
                        </div>

                        <div class="group rounded-xl border-2 border-blue-100 bg-gradient-to-br from-blue-50 to-cyan-50 p-4 transition hover:border-blue-300 hover:shadow-md">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-blue-100">
                                    <i class='bx bxs-server text-xl text-blue-600'></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-blue-900">Server Status</p>
                                    <p class="mt-1 text-xs leading-relaxed text-blue-700">{{ $systemInfo['status'] === 'online' ? 'Online' : 'Offline' }} • Uptime: {{ $systemInfo['uptime'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="group rounded-xl border-2 border-purple-100 bg-gradient-to-br from-purple-50 to-indigo-50 p-4 transition hover:border-purple-300 hover:shadow-md">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-purple-100">
                                    <i class='bx bxs-data text-xl text-purple-600'></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-purple-900">Database</p>
                                    <p class="mt-1 text-xs leading-relaxed text-purple-700">Connected • Size: {{ $systemInfo['database_size'] }} • {{ $systemInfo['total_tables'] }} Tables</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Akreditasi Info --}}
                <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="bg-gradient-to-r from-teal-50 to-white px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-100">
                                <i class='bx bxs-award text-xl text-teal-600'></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Akreditasi</h2>
                                <p class="text-sm text-gray-600">Status akreditasi prodi</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-3 p-6">
                        <div class="rounded-xl border-2 border-blue-200 bg-gradient-to-br from-blue-50 to-blue-100 p-5">
                            <div class="text-center">
                                <p class="text-3xl font-bold text-blue-900">116</p>
                                <p class="mt-1 text-sm font-semibold text-blue-700">Prodi Terakreditasi Nasional</p>
                            </div>
                        </div>
                        <div class="rounded-xl border-2 border-teal-200 bg-gradient-to-br from-teal-50 to-teal-100 p-5">
                            <div class="text-center">
                                <p class="text-3xl font-bold text-teal-900">60</p>
                                <p class="mt-1 text-sm font-semibold text-teal-700">Prodi Terakreditasi Internasional</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
