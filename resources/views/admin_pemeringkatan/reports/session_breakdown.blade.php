@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div x-data="sessionBreakdownManager()" class="p-4 sm:p-6 lg:p-8 space-y-6 max-w-7xl mx-auto">

    {{-- Breadcrumb & Top Navigation --}}
    <div class="flex items-center justify-between gap-4 flex-wrap">
        <nav class="flex items-center text-xs text-gray-500 font-medium gap-2">
            <a href="{{ route('admin_pemeringkatan.reports.index') }}" class="hover:text-teal-600 transition flex items-center gap-1">
                <i class="fas fa-chart-pie text-gray-400"></i>
                <span>Laporan & Analitik</span>
            </a>
            <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            <span class="text-gray-900 font-semibold truncate max-w-xs sm:max-w-md">Breakdown Unit: {{ $session->name }}</span>
        </nav>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin_pemeringkatan.reports.index') }}" 
               class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl transition shadow-2xs">
                <i class="fas fa-arrow-left mr-1.5 text-gray-400"></i>
                <span>Kembali ke Laporan</span>
            </a>
            <a href="{{ route('admin_pemeringkatan.reports.export-session') }}?session_id={{ $session->id }}"
               class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-xs hover:shadow transition">
                <i class="fas fa-file-excel mr-1.5 text-sm"></i>
                <span>Export Excel Sesi</span>
            </a>
        </div>
    </div>

    {{-- Header Card --}}
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-teal-50 border border-teal-100 flex items-center justify-center text-teal-600 shadow-xs shrink-0 mt-0.5">
                <i class="fas fa-sitemap text-xl"></i>
            </div>
            <div>
                <div class="flex items-center gap-2.5 flex-wrap">
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">{{ $session->name }}</h1>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $session->status === 'active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($session->status === 'draft' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-gray-100 text-gray-600') }}">
                        <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $session->status === 'active' ? 'bg-emerald-500 animate-pulse' : ($session->status === 'draft' ? 'bg-amber-500' : 'bg-gray-400') }}"></span>
                        {{ strtoupper($session->status) }}
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium {{ $session->isFormBased() ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-teal-50 text-teal-700 border border-teal-200' }}">
                        <i class="fas mr-1.5 text-[11px] {{ $session->isFormBased() ? 'fa-file-alt' : 'fa-handshake' }}"></i>
                        {{ $session->isFormBased() ? 'Form Kuesioner' : 'Consent Saja' }}
                    </span>
                </div>
                <p class="text-sm text-gray-500 mt-1">
                    Detail capaian respon per unit fakultas dan program studi dengan pemisahan kategori responden <strong>Academic</strong> dan <strong>Employer / Employee</strong>.
                </p>
                <div class="flex items-center gap-4 text-xs text-gray-400 mt-2">
                    <span><i class="far fa-calendar-alt mr-1 text-gray-400"></i> {{ $stats['start_date'] }} s/d {{ $stats['end_date'] }}</span>
                    @if(!empty($session->description))
                        <span class="hidden sm:inline">&bull;</span>
                        <span class="hidden sm:inline truncate max-w-md">{{ $session->description }}</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Role badge --}}
        <div class="shrink-0">
            @if(Auth::user()->isDirectorateAdmin())
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-teal-50 text-teal-700 border border-teal-200">
                    <i class="fas fa-shield-alt mr-1.5"></i> Akses Direktorat
                </span>
            @elseif(Auth::user()->isFakultas())
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                    <i class="fas fa-university mr-1.5"></i> Akses Fakultas: {{ Auth::user()->name }}
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                    <i class="fas fa-graduation-cap mr-1.5"></i> Akses Prodi: {{ Auth::user()->name }}
                </span>
            @endif
        </div>
    </div>

    {{-- Stat Cards Row: Separated by Academic & Employee --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Card 1: Total Responden --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Responden</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total_respondents'] }}</p>
                <p class="text-xs text-gray-500 mt-0.5">
                    <span class="text-emerald-600 font-semibold">{{ $stats['agreed_count'] }}</span> selesai &middot;
                    <span class="text-amber-500 font-semibold">{{ $stats['pending_count'] }}</span> pending
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-teal-50 border border-teal-100 flex items-center justify-center text-teal-600 shadow-xs">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>

        {{-- Card 2: Responden Academic --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Academic (Dosen/Peneliti)</p>
                </div>
                <p class="text-2xl font-bold text-indigo-700 mt-1">{{ $stats['academic_total'] }}</p>
                <p class="text-xs text-gray-500 mt-0.5">
                    <span class="text-emerald-600 font-semibold">{{ $stats['academic_agreed'] }}</span> setuju ({{ $stats['academic_rate'] }}%)
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                <i class="fas fa-graduation-cap text-xl"></i>
            </div>
        </div>

        {{-- Card 3: Responden Employee / Employer --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Employee / Industri</p>
                </div>
                <p class="text-2xl font-bold text-amber-600 mt-1">{{ $stats['employee_total'] }}</p>
                <p class="text-xs text-gray-500 mt-0.5">
                    <span class="text-emerald-600 font-semibold">{{ $stats['employee_agreed'] }}</span> setuju ({{ $stats['employee_rate'] }}%)
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 shadow-xs">
                <i class="fas fa-briefcase text-xl"></i>
            </div>
        </div>

        {{-- Card 4: Consent Rate Total --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Tingkat Persetujuan</p>
                <p class="text-2xl font-bold text-teal-700 mt-1">{{ $stats['rate'] }}%</p>
                <div class="w-28 bg-gray-100 rounded-full h-1.5 mt-2 overflow-hidden">
                    <div class="bg-teal-600 h-1.5 rounded-full transition-all duration-500" 
                         style="width: {{ min($stats['rate'], 100) }}%"></div>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-teal-50 border border-teal-100 flex items-center justify-center text-teal-700 shadow-xs">
                <i class="fas fa-percentage text-xl"></i>
            </div>
        </div>
    </div>

    {{-- Academic vs Employee Ratio Comparison Banner --}}
    @if($stats['total_respondents'] > 0)
        @php
            $acadShare = round(($stats['academic_total'] / $stats['total_respondents']) * 100, 1);
            $empShare = round(($stats['employee_total'] / $stats['total_respondents']) * 100, 1);
        @endphp
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm space-y-3">
            <div class="flex items-center justify-between text-xs font-semibold text-gray-700 flex-wrap gap-2">
                <div class="flex items-center gap-2">
                    <i class="fas fa-balance-scale text-teal-600"></i>
                    <span>Komposisi Responden Sesi</span>
                </div>
                <div class="flex items-center gap-4 text-xs">
                    <span class="inline-flex items-center gap-1.5 text-indigo-700">
                        <span class="w-2.5 h-2.5 rounded-sm bg-indigo-600"></span>
                        Academic: <strong>{{ $stats['academic_total'] }}</strong> ({{ $acadShare }}%)
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-amber-700">
                        <span class="w-2.5 h-2.5 rounded-sm bg-amber-500"></span>
                        Employee: <strong>{{ $stats['employee_total'] }}</strong> ({{ $empShare }}%)
                    </span>
                </div>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden flex">
                <div class="bg-indigo-600 h-3 transition-all duration-500" style="width: {{ $acadShare }}%" title="Academic: {{ $stats['academic_total'] }} ({{ $acadShare }}%)"></div>
                <div class="bg-amber-500 h-3 transition-all duration-500" style="width: {{ $empShare }}%" title="Employee: {{ $stats['employee_total'] }} ({{ $empShare }}%)"></div>
            </div>
        </div>
    @endif

    {{-- Detailed Unit Breakdown Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        {{-- Table Toolbar --}}
        <div class="p-5 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-base font-bold text-gray-800">Capaian Unit & Program Studi</h2>
                <p class="text-xs text-gray-400 mt-0.5">Breakdown lengkap dengan rincian kategori Academic vs Employee per unit</p>
            </div>
            
            <div class="flex items-center gap-3 flex-wrap">
                {{-- Quick Search Box --}}
                <div class="relative min-w-[220px]">
                    <input type="text" 
                           x-model="searchQuery" 
                           placeholder="Cari fakultas atau prodi..."
                           class="w-full pl-8 pr-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500">
                    <i class="fas fa-search absolute left-2.5 top-2.5 text-gray-400 text-xs"></i>
                </div>

                {{-- Toggle Expand/Collapse All --}}
                <button type="button" 
                        @click="toggleAllUnits()" 
                        class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 hover:text-gray-900 rounded-xl transition">
                    <i class="fas mr-1 text-[10px]" :class="allExpanded ? 'fa-compress-alt' : 'fa-expand-alt'"></i>
                    <span x-text="allExpanded ? 'Tutup Semua Prodi' : 'Buka Semua Prodi'"></span>
                </button>
            </div>
        </div>

        {{-- Table Container --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/75 text-xs uppercase text-gray-500 font-semibold border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3.5">Unit / Fakultas / Prodi</th>
                        <th class="px-4 py-3.5 text-center">Total Responden</th>
                        <th class="px-4 py-3.5 text-center bg-indigo-50/40 text-indigo-700">
                            <i class="fas fa-graduation-cap mr-1"></i> Academic (Total / Setuju)
                        </th>
                        <th class="px-4 py-3.5 text-center bg-amber-50/40 text-amber-700">
                            <i class="fas fa-briefcase mr-1"></i> Employee (Total / Setuju)
                        </th>
                        <th class="px-4 py-3.5 text-center text-emerald-700">Setuju (Selesai)</th>
                        <th class="px-4 py-3.5 text-center text-amber-700">Pending</th>
                        <th class="px-5 py-3.5 text-center">Consent Rate</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-for="unit in filteredUnits" :key="unit.unit">
                        <!-- Unit row + prodi subrows container -->
                        <tr class="hover:bg-gray-50/60 transition-colors bg-white">
                            {{-- Unit Name with Expand toggle --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2.5">
                                    <button type="button" 
                                            @click="toggleUnit(unit.unit)"
                                            class="w-6 h-6 rounded-md flex items-center justify-center text-gray-400 hover:text-teal-600 hover:bg-teal-50 transition shrink-0"
                                            x-show="unit.prodis && unit.prodis.length > 0">
                                        <i class="fas fa-chevron-right text-xs transition-transform duration-200"
                                           :class="{ 'rotate-90 text-teal-600': isUnitExpanded(unit.unit) }"></i>
                                    </button>
                                    <div class="w-6 h-6 shrink-0" x-show="!unit.prodis || unit.prodis.length === 0"></div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-sm" x-text="unit.unit"></div>
                                        <div class="text-[11px] text-gray-400 mt-0.5" x-show="unit.prodis && unit.prodis.length > 0">
                                            <span x-text="unit.prodis.length"></span> Program Studi terdata
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Total Responden --}}
                            <td class="px-4 py-4 text-center font-bold text-gray-900" x-text="unit.total"></td>

                            {{-- Academic breakdown --}}
                            <td class="px-4 py-4 text-center bg-indigo-50/20">
                                <span class="font-semibold text-indigo-700" x-text="unit.academic_total"></span>
                                <span class="text-xs text-gray-400">/</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200" 
                                      x-text="unit.academic_agreed"></span>
                                <span class="text-[10px] text-gray-400 block mt-0.5" x-text="'(' + unit.academic_rate + '%)'"></span>
                            </td>

                            {{-- Employee breakdown --}}
                            <td class="px-4 py-4 text-center bg-amber-50/20">
                                <span class="font-semibold text-amber-700" x-text="unit.employee_total"></span>
                                <span class="text-xs text-gray-400">/</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200" 
                                      x-text="unit.employee_agreed"></span>
                                <span class="text-[10px] text-gray-400 block mt-0.5" x-text="'(' + unit.employee_rate + '%)'"></span>
                            </td>

                            {{-- Total Agreed --}}
                            <td class="px-4 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800" x-text="unit.agreed"></span>
                            </td>

                            {{-- Total Pending --}}
                            <td class="px-4 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700" x-text="unit.pending"></span>
                            </td>

                            {{-- Consent Rate with Progress bar --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2 justify-center">
                                    <div class="flex-1 bg-gray-100 rounded-full h-2 overflow-hidden max-w-[90px]">
                                        <div class="bg-teal-600 h-2 rounded-full transition-all" :style="'width: ' + Math.min(unit.rate, 100) + '%'"></div>
                                    </div>
                                    <span class="text-xs font-bold text-gray-800" x-text="unit.rate + '%'"></span>
                                </div>
                            </td>
                        </tr>

                        <!-- Sub-rows: Prodis under this unit -->
                        <template x-if="isUnitExpanded(unit.unit)">
                            <template x-for="prodi in unit.prodis" :key="unit.unit + '-' + prodi.name">
                                <tr class="bg-slate-50/70 hover:bg-slate-100/70 transition-colors border-l-4 border-l-teal-500">
                                    <td class="px-5 py-2.5 pl-12">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-graduation-cap text-gray-400 text-xs"></i>
                                            <span class="text-xs font-medium text-gray-800" x-text="prodi.name"></span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2.5 text-center text-xs font-bold text-gray-700" x-text="prodi.total"></td>
                                    <td class="px-4 py-2.5 text-center text-xs bg-indigo-50/10">
                                        <span class="font-medium text-indigo-700" x-text="prodi.academic_total"></span>
                                        <span class="text-gray-400">/</span>
                                        <span class="text-emerald-700 font-semibold" x-text="prodi.academic_agreed"></span>
                                    </td>
                                    <td class="px-4 py-2.5 text-center text-xs bg-amber-50/10">
                                        <span class="font-medium text-amber-700" x-text="prodi.employee_total"></span>
                                        <span class="text-gray-400">/</span>
                                        <span class="text-emerald-700 font-semibold" x-text="prodi.employee_agreed"></span>
                                    </td>
                                    <td class="px-4 py-2.5 text-center text-xs font-semibold text-emerald-700" x-text="prodi.agreed"></td>
                                    <td class="px-4 py-2.5 text-center text-xs font-semibold text-amber-600" x-text="prodi.pending"></td>
                                    <td class="px-5 py-2.5 text-center text-xs font-bold text-teal-700" x-text="prodi.rate + '%'"></td>
                                </tr>
                            </template>
                        </template>
                    </template>

                    <tr x-show="filteredUnits.length === 0">
                        <td colspan="7" class="text-center py-12 text-gray-400">
                            <i class="fas fa-search text-3xl mb-2 block"></i>
                            Tidak ada unit atau prodi yang sesuai dengan pencarian.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Footer Summary --}}
        <div class="p-4 bg-gray-50/75 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-gray-500">
            <div>
                Menampilkan <span class="font-bold text-gray-700" x-text="filteredUnits.length"></span> unit capaian
            </div>
            <div class="flex items-center gap-4 text-xs font-semibold">
                <span class="text-indigo-700">Total Academic: {{ $stats['academic_total'] }} ({{ $stats['academic_agreed'] }} setuju)</span>
                <span class="text-amber-700">Total Employee: {{ $stats['employee_total'] }} ({{ $stats['employee_agreed'] }} setuju)</span>
            </div>
        </div>
    </div>

</div>

<script>
function sessionBreakdownManager() {
    return {
        units: @json($units),
        searchQuery: '',
        expandedUnits: {},
        allExpanded: false,

        init() {
            // Expand all by default if <= 4 units
            if (this.units.length <= 4) {
                this.units.forEach(u => {
                    this.expandedUnits[u.unit] = true;
                });
                this.allExpanded = true;
            }
        },

        get filteredUnits() {
            if (!this.searchQuery.trim()) {
                return this.units;
            }
            const q = this.searchQuery.toLowerCase();
            return this.units.filter(u => {
                if (u.unit.toLowerCase().includes(q)) return true;
                return (u.prodis || []).some(p => p.name.toLowerCase().includes(q));
            });
        },

        isUnitExpanded(unitKey) {
            return !!this.expandedUnits[unitKey];
        },

        toggleUnit(unitKey) {
            this.expandedUnits[unitKey] = !this.expandedUnits[unitKey];
        },

        toggleAllUnits() {
            this.allExpanded = !this.allExpanded;
            const state = this.allExpanded;
            this.units.forEach(u => {
                this.expandedUnits[u.unit] = state;
            });
        }
    };
}
</script>
@endsection
