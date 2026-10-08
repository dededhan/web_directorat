@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div x-data="inputerAnalyticsManager()" class="p-4 sm:p-6 lg:p-8 space-y-6 max-w-7xl mx-auto">

    {{-- Breadcrumbs & Top Navigation --}}
    <div class="flex items-center justify-between gap-4 flex-wrap">
        <nav class="flex items-center text-xs text-gray-500 font-medium gap-2">
            <a href="{{ route('admin_pemeringkatan.reports.index') }}" class="hover:text-teal-600 transition flex items-center gap-1">
                <i class="fas fa-chart-pie text-gray-400"></i>
                <span>Laporan & Analitik</span>
            </a>
            <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            <a href="{{ route('admin_pemeringkatan.reports.index') }}?tab=legacy" class="hover:text-teal-600 transition">
                <span>Arsip Legacy</span>
            </a>
            <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            <span class="text-gray-900 font-semibold">Analisis Sebaran Penginput</span>
        </nav>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin_pemeringkatan.reports.index') }}?tab=legacy" 
               class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl transition shadow-2xs">
                <i class="fas fa-arrow-left mr-1.5 text-gray-400"></i>
                <span>Kembali ke Laporan</span>
            </a>
            <a href="{{ route('admin_pemeringkatan.reports.export-legacy') }}"
               class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-xs hover:shadow transition">
                <i class="fas fa-file-excel mr-1.5 text-sm"></i>
                <span>Export Rekap Excel</span>
            </a>
        </div>
    </div>

    {{-- Hero Title Card --}}
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shadow-xs shrink-0 mt-0.5">
                <i class="fas fa-user-edit text-xl"></i>
            </div>
            <div>
                <div class="flex items-center gap-2.5 flex-wrap">
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Analisis Sebaran Penginput & Kontribusi Prodi</h1>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                        <i class="fas fa-database mr-1.5 text-[10px]"></i> Arsip Legacy
                    </span>
                </div>
                <p class="text-sm text-gray-500 mt-1">
                    Visualisasi komprehensif kontribusi data responden berdasarkan akun penginput dari Direktorat, Fakultas, dan seluruh Program Studi.
                </p>
            </div>
        </div>

        {{-- Role badge --}}
        <div class="shrink-0">
            @if(Auth::user()->isDirectorateAdmin())
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-teal-50 text-teal-700 border border-teal-200">
                    <i class="fas fa-shield-alt mr-1.5"></i> Akses Direktorat (Semua Unit)
                </span>
            @elseif(Auth::user()->isFakultas())
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                    <i class="fas fa-university mr-1.5"></i> Akses Fakultas: {{ Auth::user()->name }}
                </span>
            @endif
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
        <form method="GET" action="{{ route('admin_pemeringkatan.reports.inputer-analytics') }}" class="flex flex-wrap items-center gap-3">
            {{-- Filter Tahun --}}
            <div class="min-w-[140px]">
                <label class="block text-[11px] font-semibold text-gray-500 uppercase mb-1">Tahun Input</label>
                <select name="year" 
                        class="w-full px-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-gray-700 cursor-pointer">
                    <option value="all">Semua Tahun</option>
                    @foreach($years as $yr)
                        <option value="{{ $yr }}" {{ (string)$filters['year'] === (string)$yr ? 'selected' : '' }}>Tahun {{ $yr }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Fakultas --}}
            @if(Auth::user()->isDirectorateAdmin() && count($fakultasOptions) > 0)
                <div class="min-w-[180px]">
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase mb-1">Fakultas</label>
                    <select name="fakultas" 
                            class="w-full px-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-gray-700 cursor-pointer">
                        <option value="all">Semua Fakultas</option>
                        @foreach($fakultasOptions as $fak)
                            <option value="{{ strtolower($fak) }}" {{ strtolower($filters['fakultas'] ?? '') === strtolower($fak) ? 'selected' : '' }}>{{ $fak }}</option>
                        @endforeach
                    </select>
                </div>
            @elseif(Auth::user()->isFakultas() && count($fakultasOptions) > 0)
                <div class="min-w-[180px]">
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase mb-1">Fakultas</label>
                    <div class="w-full px-3 py-1.5 text-xs bg-gray-100 border border-gray-200 rounded-xl text-gray-600 flex items-center justify-between" title="Dibatasi hanya data fakultas Anda">
                        <span class="font-medium truncate">{{ $fakultasOptions[0] ?? Auth::user()->name }}</span>
                        <span class="text-[10px] text-indigo-600 font-semibold bg-indigo-50 px-1.5 py-0.5 rounded shrink-0">Terkunci</span>
                    </div>
                </div>
            @endif

            {{-- Rentang Tanggal --}}
            <div class="min-w-[150px]">
                <label class="block text-[11px] font-semibold text-gray-500 uppercase mb-1">Dari Tanggal</label>
                <input type="date" 
                       name="start_date" 
                       value="{{ $filters['start_date'] }}" 
                       class="w-full px-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-gray-700">
            </div>

            <div class="min-w-[150px]">
                <label class="block text-[11px] font-semibold text-gray-500 uppercase mb-1">Sampai Tanggal</label>
                <input type="date" 
                       name="end_date" 
                       value="{{ $filters['end_date'] }}" 
                       class="w-full px-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-gray-700">
            </div>

            <div class="flex items-center gap-2 pt-4 sm:pt-4">
                <button type="submit" 
                        class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-xs transition cursor-pointer">
                    <i class="fas fa-filter mr-1.5"></i> Terapkan Filter
                </button>
                <a href="{{ route('admin_pemeringkatan.reports.inputer-analytics') }}" 
                   class="px-3 py-2 text-xs font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Top KPI Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Card 1: Total Responden Legacy --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Responden Legacy</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($overallStats['total']) }}</p>
                <p class="text-xs text-gray-500 mt-0.5">
                    <span class="text-emerald-600 font-semibold">{{ number_format($overallStats['finished']) }}</span> selesai &middot;
                    <span class="text-amber-500 font-semibold">{{ number_format($overallStats['pending']) }}</span> pending
                </p>
                <p class="text-[11px] text-gray-500 mt-1 flex items-center gap-1.5 flex-wrap">
                    <span class="inline-flex items-center gap-1 text-indigo-700 font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> {{ number_format($overallStats['academic_total'] ?? 0) }} Acad
                    </span>
                    <span class="text-gray-300">&middot;</span>
                    <span class="inline-flex items-center gap-1 text-amber-700 font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> {{ number_format($overallStats['employee_total'] ?? 0) }} Emp
                    </span>
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-teal-50 border border-teal-100 flex items-center justify-center text-teal-600 shadow-xs">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>

        {{-- Card 2: Tingkat Penyelesaian Form --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Tingkat Penyelesaian (Clear)</p>
                <p class="text-2xl font-bold text-emerald-700 mt-1">{{ $overallStats['rate'] }}%</p>
                <div class="w-28 bg-gray-100 rounded-full h-1.5 mt-2 overflow-hidden">
                    <div class="bg-emerald-600 h-1.5 rounded-full transition-all duration-500" 
                         style="width: {{ min($overallStats['rate'], 100) }}%"></div>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shadow-xs">
                <i class="fas fa-check-double text-xl"></i>
            </div>
        </div>

        {{-- Card 3: Total Kontribusi Prodi --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Kontribusi Akun Prodi</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">{{ number_format($prodiStats['total']) }}</p>
                <p class="text-xs text-gray-500 mt-0.5">
                    Dari <strong>{{ $prodiStats['count'] }}</strong> program studi aktif ({{ $prodiStats['rate'] }}% selesai)
                </p>
                <p class="text-[11px] text-gray-500 mt-1 flex items-center gap-1.5 flex-wrap">
                    <span class="inline-flex items-center gap-1 text-indigo-700 font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> {{ number_format($prodiStats['academic_total'] ?? 0) }} Acad
                    </span>
                    <span class="text-gray-300">&middot;</span>
                    <span class="inline-flex items-center gap-1 text-amber-700 font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> {{ number_format($prodiStats['employee_total'] ?? 0) }} Emp
                    </span>
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shadow-xs">
                <i class="fas fa-graduation-cap text-xl"></i>
            </div>
        </div>

        {{-- Card 4: Rata-rata per Prodi & Top Kontributor --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div class="min-w-0 pr-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Rata-rata / Prodi</p>
                <p class="text-2xl font-bold text-indigo-700 mt-1">{{ $prodiStats['avg'] }} <span class="text-xs text-gray-400 font-normal">responden</span></p>
                <p class="text-[11px] text-gray-500 mt-0.5 truncate" title="{{ $prodiStats['top']['name'] ?? '-' }}">
                    Top: <strong class="text-indigo-900">{{ $prodiStats['top']['name'] ?? '-' }}</strong> ({{ $prodiStats['top']['total'] ?? 0 }})
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs shrink-0">
                <i class="fas fa-award text-xl"></i>
            </div>
        </div>
    </div>

    {{-- Visual Analytics & Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
        
        {{-- Chart 1: Donut Chart Komposisi Penginput per Kategori (4 Cols) --}}
        <div class="lg:col-span-4 bg-white p-5 sm:p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-chart-pie text-teal-600"></i>
                        <span>Proporsi Kategori Penginput</span>
                    </h3>
                </div>
                <p class="text-xs text-gray-400 mt-0.5">Sebaran total responden berdasarkan tingkat akun penginput</p>
                
                {{-- Donut Chart Container --}}
                <div class="relative h-56 mt-4 flex items-center justify-center">
                    <canvas id="categoryDonutChart"></canvas>
                </div>
            </div>

            {{-- Legend List --}}
            <div class="pt-4 border-t border-gray-100 space-y-2 text-xs">
                @foreach($breakdown as $grp)
                    @php
                        $pct = $overallStats['total'] > 0 ? round(($grp['total'] / $overallStats['total']) * 100, 1) : 0;
                    @endphp
                    <div class="flex items-center justify-between text-gray-600">
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="w-2.5 h-2.5 rounded-full shrink-0" 
                                  style="background-color: {{ $grp['type'] === 'prodi' ? '#3B82F6' : ($grp['type'] === 'fakultas' ? '#6366F1' : ($grp['type'] === 'direktorat' ? '#0D9488' : '#94A3B8')) }}"></span>
                            <span class="truncate font-medium">{{ $grp['label'] }}</span>
                            <span class="text-[11px] text-gray-400">({{ count($grp['inputers']) }} akun)</span>
                        </div>
                        <div class="text-right shrink-0 font-bold text-gray-900">
                            {{ number_format($grp['total']) }} <span class="text-[11px] font-normal text-gray-400">({{ $pct }}%)</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Chart 2: Horizontal Bar Chart Peringkat Kontribusi (8 Cols) --}}
        <div class="lg:col-span-8 bg-white p-5 sm:p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-chart-bar text-blue-600"></i>
                            <span x-text="chartTitle"></span>
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5" x-text="chartSubtitle"></p>
                    </div>
                    <div class="flex items-center gap-2.5 flex-wrap">
                        {{-- Mode Switcher (jika 'Semua Fakultas' dipilih) --}}
                        <template x-if="isAllFaculties && facultyList.length > 0">
                            <div class="inline-flex p-0.5 rounded-lg bg-gray-100 text-xs font-semibold">
                                <button type="button" 
                                        @click="setChartViewMode('fakultas')" 
                                        :class="chartViewMode === 'fakultas' ? 'bg-white text-blue-700 shadow-2xs' : 'text-gray-500 hover:text-gray-800'"
                                        class="px-2.5 py-1 rounded-md transition cursor-pointer">
                                    <i class="fas fa-university mr-1 text-[10px]"></i> Per Fakultas
                                </button>
                                <button type="button" 
                                        @click="setChartViewMode('prodi')" 
                                        :class="chartViewMode === 'prodi' ? 'bg-white text-blue-700 shadow-2xs' : 'text-gray-500 hover:text-gray-800'"
                                        class="px-2.5 py-1 rounded-md transition cursor-pointer">
                                    <i class="fas fa-graduation-cap mr-1 text-[10px]"></i> Per Prodi
                                </button>
                            </div>
                        </template>

                        {{-- Metric Mode Switcher: Status vs Academic/Employee --}}
                        <div class="inline-flex p-0.5 rounded-lg bg-gray-100 text-xs font-semibold">
                            <button type="button" 
                                    @click="setChartMetricType('status')" 
                                    :class="chartMetricType === 'status' ? 'bg-white text-emerald-700 shadow-2xs' : 'text-gray-500 hover:text-gray-800'"
                                    class="px-2.5 py-1 rounded-md transition cursor-pointer"
                                    title="Tampilkan grafik berdasarkan status selesai form">
                                <i class="fas fa-check-circle mr-1 text-[10px]"></i> Status
                            </button>
                            <button type="button" 
                                    @click="setChartMetricType('category')" 
                                    :class="chartMetricType === 'category' ? 'bg-white text-indigo-700 shadow-2xs' : 'text-gray-500 hover:text-gray-800'"
                                    class="px-2.5 py-1 rounded-md transition cursor-pointer"
                                    title="Tampilkan grafik berdasarkan kategori Academic vs Employee">
                                <i class="fas fa-users mr-1 text-[10px]"></i> Academic / Employee
                            </button>
                        </div>

                        {{-- Legend dynamic based on chartMetricType --}}
                        <div class="flex items-center gap-3 text-xs" x-show="chartMetricType === 'status'">
                            <span class="inline-flex items-center gap-1.5 text-emerald-700 font-semibold">
                                <span class="w-3 h-3 rounded bg-emerald-500"></span> Selesai
                            </span>
                            <span class="inline-flex items-center gap-1.5 text-slate-500 font-semibold">
                                <span class="w-3 h-3 rounded bg-slate-300"></span> Belum Selesai
                            </span>
                        </div>
                        <div class="flex items-center gap-3 text-xs" x-show="chartMetricType === 'category'" style="display: none;">
                            <span class="inline-flex items-center gap-1.5 text-indigo-700 font-semibold">
                                <span class="w-3 h-3 rounded bg-indigo-500"></span> Academic
                            </span>
                            <span class="inline-flex items-center gap-1.5 text-amber-700 font-semibold">
                                <span class="w-3 h-3 rounded bg-amber-500"></span> Employee
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Chart Container --}}
                <div class="relative w-full overflow-hidden mt-4" :style="'height: ' + (chartViewMode === 'fakultas' ? Math.max(280, Math.min(520, (facultyList ? facultyList.length : 0) * 38 + 50)) : Math.max(320, Math.min(650, (prodiList ? prodiList.length : 0) * 26 + 50))) + 'px'">
                    <canvas id="prodiHorizontalChart"></canvas>
                </div>
            </div>

            <div class="pt-3 border-t border-gray-100 text-xs text-gray-400 flex items-center justify-between">
                <span>Tips: Arahkan kursor atau klik batang pada grafik untuk melihat rincian detail.</span>
                <span class="font-semibold text-gray-600" x-text="chartFooterCount"></span>
            </div>
        </div>

    </div>

    {{-- Full Interactive Ranking Table --}}
    <div id="rankingTableSection" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden scroll-mt-6">
        {{-- Toolbar --}}
        <div class="p-5 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-gray-900">Rincian Lengkap Seluruh Akun Penginput</h3>
                <p class="text-xs text-gray-400 mt-0.5">Filter berdasarkan kategori atau cari akun tertentu untuk melihat performa penginputan</p>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                {{-- Category Pill Tabs --}}
                <div class="inline-flex p-1 bg-gray-100 rounded-xl text-xs font-semibold">
                    <button type="button" 
                            @click="selectedCategoryTab = 'all'"
                            :class="selectedCategoryTab === 'all' ? 'bg-white text-blue-700 shadow-2xs' : 'text-gray-500 hover:text-gray-900'"
                            class="px-3 py-1.5 rounded-lg transition cursor-pointer">
                        Semua Akun
                    </button>
                    <button type="button" 
                            @click="selectedCategoryTab = 'prodi'"
                            :class="selectedCategoryTab === 'prodi' ? 'bg-white text-blue-700 shadow-2xs' : 'text-gray-500 hover:text-gray-900'"
                            class="px-3 py-1.5 rounded-lg transition cursor-pointer">
                        Prodi ({{ $prodiStats['count'] }})
                    </button>
                    <button type="button" 
                            @click="selectedCategoryTab = 'fakultas'"
                            :class="selectedCategoryTab === 'fakultas' ? 'bg-white text-blue-700 shadow-2xs' : 'text-gray-500 hover:text-gray-900'"
                            class="px-3 py-1.5 rounded-lg transition cursor-pointer">
                        Fakultas
                    </button>
                    <button type="button" 
                            @click="selectedCategoryTab = 'direktorat'"
                            :class="selectedCategoryTab === 'direktorat' ? 'bg-white text-blue-700 shadow-2xs' : 'text-gray-500 hover:text-gray-900'"
                            class="px-3 py-1.5 rounded-lg transition cursor-pointer">
                        Direktorat
                    </button>
                </div>

                {{-- Live Search Box --}}
                <div class="relative min-w-[220px]">
                    <input type="text" 
                           x-model="searchQuery" 
                           placeholder="Cari akun atau prodi..."
                           class="w-full pl-8 pr-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-gray-700">
                    <i class="fas fa-search absolute left-2.5 top-2.5 text-gray-400 text-xs"></i>
                </div>
            </div>
        </div>

        {{-- Table Container --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/75 text-xs uppercase text-gray-500 font-semibold border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3.5 text-center w-14">#</th>
                        <th class="px-5 py-3.5">Akun Penginput</th>
                        <th class="px-4 py-3.5 text-center">Kategori</th>
                        <th class="px-4 py-3.5 text-center">Total Responden</th>
                        <th class="px-3 py-3.5 text-center text-indigo-700">Academic</th>
                        <th class="px-3 py-3.5 text-center text-amber-700">Employee</th>
                        <th class="px-4 py-3.5 text-center text-emerald-700">Selesai</th>
                        <th class="px-4 py-3.5 text-center text-slate-600">Pending</th>
                        <th class="px-5 py-3.5 w-40">Tingkat Selesai</th>
                        <th class="px-5 py-3.5 text-right w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-for="(row, idx) in filteredTableRows" :key="row.category + '-' + row.id">
                        <tr class="hover:bg-blue-50/20 transition-colors">
                            <td class="px-5 py-3.5 text-center font-bold text-gray-400" x-text="idx + 1"></td>
                            <td class="px-5 py-3.5">
                                <div class="font-bold text-gray-900 text-xs sm:text-sm" x-text="row.name"></div>
                                <div class="text-[11px] text-gray-400 mt-0.5" x-text="'ID: #' + row.id"></div>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded border text-[11px] font-semibold"
                                      :class="row.category === 'prodi' ? 'bg-blue-50 text-blue-700 border-blue-200' : (row.category === 'fakultas' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : (row.category === 'direktorat' ? 'bg-teal-50 text-teal-700 border-teal-200' : 'bg-gray-100 text-gray-600 border-gray-200'))">
                                    <i class="fas text-[9px]" :class="row.category === 'prodi' ? 'fa-graduation-cap' : (row.category === 'fakultas' ? 'fa-university' : 'fa-shield-alt')"></i>
                                    <span x-text="row.categoryLabel"></span>
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-center font-bold text-gray-900 text-sm" x-text="row.total"></td>
                            <td class="px-3 py-3.5 text-center font-bold text-indigo-700 text-xs sm:text-sm" x-text="row.academic_total"></td>
                            <td class="px-3 py-3.5 text-center font-bold text-amber-700 text-xs sm:text-sm" x-text="row.employee_total"></td>
                            <td class="px-4 py-3.5 text-center font-bold text-emerald-600 text-sm" x-text="row.finished"></td>
                            <td class="px-4 py-3.5 text-center font-medium text-slate-600 text-xs" x-text="row.total - row.finished"></td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 bg-gray-100 rounded-full h-2 overflow-hidden">
                                        <div class="bg-emerald-500 h-2 rounded-full transition-all duration-300" 
                                             :style="'width: ' + Math.min(row.rate, 100) + '%'"></div>
                                    </div>
                                    <span class="text-xs font-bold text-gray-700" x-text="row.rate + '%'"></span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <a :href="'{{ route('admin_pemeringkatan.reports.index') }}?tab=legacy&inputer=' + row.id"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 border border-teal-200 transition shadow-2xs"
                                   title="Buka data responden dari akun ini pada tabel utama Arsip">
                                    <i class="fas fa-table-list text-[10px]"></i>
                                    <span>Tabel</span>
                                </a>
                            </td>
                        </tr>
                    </template>

                    <tr x-show="filteredTableRows.length === 0">
                        <td colspan="10" class="text-center py-12 text-gray-400">
                            <i class="fas fa-search text-3xl mb-2 block"></i>
                            Tidak ada akun penginput yang sesuai dengan filter atau kata kunci pencarian.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Footer summary --}}
        <div class="p-4 bg-gray-50/75 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-500">
            <div>
                Menampilkan <span class="font-bold text-gray-700" x-text="filteredTableRows.length"></span> akun penginput
            </div>
            <div class="flex items-center gap-4 text-xs font-semibold flex-wrap">
                <span class="text-indigo-700"><i class="fas fa-graduation-cap mr-1 text-[10px]"></i> Academic: {{ number_format($overallStats['academic_total'] ?? 0) }}</span>
                <span class="text-amber-700"><i class="fas fa-briefcase mr-1 text-[10px]"></i> Employee: {{ number_format($overallStats['employee_total'] ?? 0) }}</span>
                <span class="text-blue-700">Total Prodi: {{ $prodiStats['count'] }} akun ({{ number_format($prodiStats['total']) }} responden)</span>
                <span class="text-teal-700">Total Keseluruhan: {{ number_format($overallStats['total']) }} responden</span>
            </div>
        </div>
    </div>

</div>

<script>
function inputerAnalyticsManager() {
    return {
        filters: @json($filters),
        breakdown: @json($breakdown),
        prodiList: @json($prodiList),
        facultyList: @json($facultyList),
        overallStats: @json($overallStats),
        prodiStats: @json($prodiStats),
        chartViewMode: @json(($filters['fakultas'] === 'all' || empty($filters['fakultas'])) ? 'fakultas' : 'prodi'),
        chartMetricType: 'status', // 'status' (Selesai vs Belum) or 'category' (Academic vs Employee)

        selectedCategoryTab: 'all', // 'all', 'prodi', 'fakultas', 'direktorat'
        searchQuery: '',

        categoryDonutInstance: null,
        prodiHorizontalInstance: null,

        get isAllFaculties() {
            return !this.filters.fakultas || this.filters.fakultas === 'all';
        },

        get chartTitle() {
            if (this.chartViewMode === 'fakultas') {
                return 'Distribusi Kontribusi Seluruh Fakultas';
            }
            if (this.filters.fakultas && this.filters.fakultas !== 'all') {
                return 'Distribusi Kontribusi Program Studi (' + this.filters.fakultas.toUpperCase() + ')';
            }
            return 'Distribusi Kontribusi Seluruh Program Studi';
        },

        get chartSubtitle() {
            const scope = this.chartViewMode === 'fakultas' ? 'fakultas' : 'program studi';
            if (this.chartMetricType === 'category') {
                return `Sebaran kontribusi responden Academic (Peneliti/Dosen) vs Employee (Praktisi) dari setiap ${scope}`;
            }
            return `Perbandingan responden Selesai (Form Clear) vs Belum Selesai dari setiap ${scope}`;
        },

        get chartFooterCount() {
            if (this.chartViewMode === 'fakultas') {
                return (this.facultyList?.length || 0) + ' Fakultas Terdata';
            }
            return (this.prodiList?.length || 0) + ' Program Studi Terdata';
        },

        setChartViewMode(mode) {
            this.chartViewMode = mode;
            this.$nextTick(() => {
                this.renderProdiHorizontalChart();
            });
        },

        setChartMetricType(type) {
            this.chartMetricType = type;
            this.$nextTick(() => {
                this.renderProdiHorizontalChart();
            });
        },

        filterTableByAccount(id) {
            const found = this.allRows.find(r => String(r.id) === String(id));
            if (found) {
                this.searchQuery = found.name;
                this.selectedCategoryTab = 'all';
                const el = document.getElementById('rankingTableSection');
                if (el) el.scrollIntoView({ behavior: 'smooth' });
            }
        },

        init() {
            this.$nextTick(() => {
                this.renderCharts();
            });
        },

        get allRows() {
            const rows = [];
            (this.breakdown || []).forEach(grp => {
                (grp.inputers || []).forEach(inp => {
                    rows.push({
                        id: inp.id,
                        name: inp.name,
                        category: grp.type,
                        categoryLabel: grp.label,
                        total: inp.total,
                        finished: inp.finished,
                        academic_total: inp.academic_total || 0,
                        employee_total: inp.employee_total || 0,
                        rate: inp.rate,
                    });
                });
            });
            rows.sort((a, b) => b.total - a.total);
            return rows;
        },

        get filteredTableRows() {
            let list = this.allRows;
            if (this.selectedCategoryTab !== 'all') {
                list = list.filter(r => r.category === this.selectedCategoryTab);
            }
            if (this.searchQuery.trim()) {
                const q = this.searchQuery.toLowerCase();
                list = list.filter(r => r.name.toLowerCase().includes(q));
            }
            return list;
        },

        renderCharts() {
            this.renderDonutChart();
            this.renderProdiHorizontalChart();
        },

        renderDonutChart() {
            const canvas = document.getElementById('categoryDonutChart');
            if (!canvas) return;

            const labels = (this.breakdown || []).map(b => b.label);
            const data = (this.breakdown || []).map(b => b.total);
            const bgColors = (this.breakdown || []).map(b => {
                if (b.type === 'prodi') return '#3B82F6';
                if (b.type === 'fakultas') return '#6366F1';
                if (b.type === 'direktorat') return '#0D9488';
                return '#94A3B8';
            });

            if (this.categoryDonutInstance) {
                this.categoryDonutInstance.destroy();
            }

            const ctx = canvas.getContext('2d');
            this.categoryDonutInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: bgColors,
                        borderWidth: 2,
                        borderColor: '#FFFFFF',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: (context) => {
                                    const val = context.parsed;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                                    return ` ${context.label}: ${val} responden (${pct}%)`;
                                }
                            }
                        }
                    }
                }
            });
        },

        renderProdiHorizontalChart() {
            const canvas = document.getElementById('prodiHorizontalChart');
            if (!canvas) return;

            const isFacultyMode = this.chartViewMode === 'fakultas';
            const rawList = isFacultyMode ? this.facultyList : this.prodiList;
            const list = [...(rawList || [])];
            if (list.length === 0) return;

            list.sort((a, b) => b.total - a.total);

            const labels = list.map(i => {
                if (isFacultyMode) {
                    return i.short_name ? 'Fakultas ' + i.short_name : i.name;
                }
                const name = i.name.replace(/^(FT|FEB|FIP|FBS|FMIPA|FIK|FISH|FPsi|Vokasi)-/, '');
                return name.length > 28 ? name.substring(0, 26) + '...' : name;
            });

            const barThick = isFacultyMode ? 20 : 13;

            let datasets = [];
            if (this.chartMetricType === 'category') {
                datasets = [
                    {
                        label: 'Academic',
                        data: list.map(i => i.academic_total || 0),
                        backgroundColor: '#6366F1',
                        hoverBackgroundColor: '#4F46E5',
                        borderRadius: 4,
                        barThickness: barThick,
                    },
                    {
                        label: 'Employee',
                        data: list.map(i => i.employee_total || 0),
                        backgroundColor: '#F59E0B',
                        hoverBackgroundColor: '#D97706',
                        borderRadius: 4,
                        barThickness: barThick,
                    }
                ];
            } else {
                datasets = [
                    {
                        label: 'Selesai',
                        data: list.map(i => i.finished || 0),
                        backgroundColor: '#10B981',
                        hoverBackgroundColor: '#059669',
                        borderRadius: 4,
                        barThickness: barThick,
                    },
                    {
                        label: 'Belum Selesai',
                        data: list.map(i => Math.max(0, (i.total || 0) - (i.finished || 0))),
                        backgroundColor: '#CBD5E1',
                        hoverBackgroundColor: '#94A3B8',
                        borderRadius: 4,
                        barThickness: barThick,
                    }
                ];
            }

            if (this.prodiHorizontalInstance) {
                this.prodiHorizontalInstance.destroy();
            }

            // Custom inline plugin to draw numbers and breakdown at the end of each bar
            const customBarLabelsPlugin = {
                id: 'customBarLabels',
                afterDatasetsDraw(chart) {
                    const { ctx, scales: { x } } = chart;
                    const metaLast = chart.getDatasetMeta(chart.data.datasets.length - 1);
                    if (!metaLast || !metaLast.data) return;

                    ctx.save();
                    ctx.textBaseline = 'middle';

                    list.forEach((item, index) => {
                        const bar = metaLast.data[index];
                        if (!bar) return;

                        const xPos = Math.max(bar.x + 8, x.getPixelForValue(0) + 8);
                        const yPos = bar.y;

                        const totalStr = String(item.total || 0);
                        const acad = item.academic_total || 0;
                        const emp = item.employee_total || 0;

                        const isNarrow = chart.width < 580;
                        const detailStr = isNarrow 
                            ? ` (${acad}A · ${emp}E)` 
                            : ` (${acad} Acad · ${emp} Emp)`;

                        // 1. Draw total number in bold dark
                        ctx.font = 'bold 11px Inter, system-ui, -apple-system, sans-serif';
                        ctx.fillStyle = '#0F172A';
                        ctx.fillText(totalStr, xPos, yPos);

                        const totalWidth = ctx.measureText(totalStr).width;

                        // 2. Draw Academic & Employee count in soft secondary style
                        ctx.font = '500 10px Inter, system-ui, -apple-system, sans-serif';
                        ctx.fillStyle = '#64748B';
                        ctx.fillText(detailStr, xPos + totalWidth + 2, yPos);
                    });

                    ctx.restore();
                }
            };

            const ctx = canvas.getContext('2d');
            this.prodiHorizontalInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                plugins: [customBarLabelsPlugin],
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            right: 90,
                            top: 6,
                            bottom: 6
                        }
                    },
                    scales: {
                        x: {
                            stacked: true,
                            beginAtZero: true,
                            grace: '35%',
                            grid: { color: '#F1F5F9' },
                            ticks: { precision: 0 }
                        },
                        y: {
                            stacked: true,
                            grid: { display: false },
                            ticks: {
                                font: { size: 11, family: 'Inter, system-ui, sans-serif' },
                                autoSkip: false
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0F172A',
                            titleFont: { size: 12, weight: 'bold' },
                            bodyFont: { size: 11 },
                            padding: 10,
                            cornerRadius: 8,
                            callbacks: {
                                afterBody: (context) => {
                                    const idx = context[0].dataIndex;
                                    const item = list[idx];
                                    const total = item.total || 0;
                                    const acad = item.academic_total || 0;
                                    const emp = item.employee_total || 0;
                                    const acadPct = total > 0 ? Math.round((acad / total) * 100) : 0;
                                    const empPct = total > 0 ? Math.round((emp / total) * 100) : 0;
                                    return [
                                        `------------------------------`,
                                        `Total Responden: ${total}`,
                                        `• Academic: ${acad} (${acadPct}%)`,
                                        `• Employee: ${emp} (${empPct}%)`,
                                        `• Selesai (Clear): ${item.finished} (${item.rate}%)`,
                                        `• Pending: ${Math.max(0, total - item.finished)}`
                                    ];
                                }
                            }
                        }
                    },
                    onClick: (event, elements) => {
                        if (elements.length > 0) {
                            const idx = elements[0].index;
                            const clickedItem = list[idx];
                            if (isFacultyMode && clickedItem.short_name) {
                                const url = new URL(window.location.href);
                                url.searchParams.set('fakultas', clickedItem.short_name.toLowerCase());
                                window.location.href = url.toString();
                            } else if (!isFacultyMode && clickedItem.id) {
                                this.filterTableByAccount(clickedItem.id);
                            }
                        }
                    }
                }
            });
        }
    };
}
</script>
@endsection
