@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div x-data="reportManager()" class="p-4 sm:p-6 lg:p-8 space-y-6 max-w-7xl mx-auto">
    
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-teal-50 border border-teal-100 flex items-center justify-center text-teal-600 shadow-xs">
                    <i class="fas fa-chart-pie text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Laporan & Analitik Pemeringkatan</h1>
                    <p class="text-sm text-gray-500 mt-0.5">
                        Statistik respon kampanye QS WUR dan arsip data responden lama dalam satu dashboard terpadu.
                    </p>
                </div>
            </div>
        </div>

        {{-- Role & Scope Badge --}}
        <div class="flex items-center gap-2">
            @if(Auth::user()->isDirectorateAdmin())
                <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold bg-teal-50 text-teal-700 border border-teal-200">
                    <span class="w-2 h-2 rounded-full bg-teal-500 mr-2 animate-pulse"></span>
                    <i class="fas fa-shield-alt mr-1.5 text-teal-600"></i>
                    Akses Direktorat (Semua Data)
                </span>
            @elseif(Auth::user()->isFakultas())
                <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                    <span class="w-2 h-2 rounded-full bg-indigo-500 mr-2"></span>
                    <i class="fas fa-university mr-1.5 text-indigo-600"></i>
                    Akses Fakultas: {{ Auth::user()->name }}
                </span>
            @elseif(Auth::user()->isProdi())
                <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                    <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
                    <i class="fas fa-graduation-cap mr-1.5 text-blue-600"></i>
                    Akses Prodi: {{ Auth::user()->name }}
                </span>
            @endif
        </div>
    </div>

    {{-- Main Tabs Navigation --}}
    <div class="flex border-b border-gray-200 bg-white px-6 pt-3 rounded-t-2xl border-t border-x border-gray-100 shadow-xs">
        <nav class="flex space-x-8" aria-label="Tabs">
            <button @click="switchTab('sessions')"
                    :class="activeTab === 'sessions' ? 'border-teal-600 text-teal-700 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium'"
                    class="py-3 px-1 border-b-2 text-sm flex items-center gap-2.5 transition-all">
                <i class="fas fa-bullhorn" :class="activeTab === 'sessions' ? 'text-teal-600' : 'text-gray-400'"></i>
                <span>Laporan QS Campaign (Sesi)</span>
                <span class="px-2 py-0.5 rounded-full text-xs"
                      :class="activeTab === 'sessions' ? 'bg-teal-100 text-teal-800' : 'bg-gray-100 text-gray-600'">
                    {{ $sessions->count() }} Sesi
                </span>
            </button>

            <button @click="switchTab('legacy')"
                    :class="activeTab === 'legacy' ? 'border-teal-600 text-teal-700 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium'"
                    class="py-3 px-1 border-b-2 text-sm flex items-center gap-2.5 transition-all">
                <i class="fas fa-archive" :class="activeTab === 'legacy' ? 'text-teal-600' : 'text-gray-400'"></i>
                <span>Arsip Responden Legacy</span>
                <span class="px-2 py-0.5 rounded-full text-xs"
                      :class="activeTab === 'legacy' ? 'bg-teal-100 text-teal-800' : 'bg-gray-100 text-gray-600'">
                    Legacy
                </span>
            </button>
        </nav>
    </div>

    {{-- TAB 1: QS CAMPAIGN SESSIONS --}}
    <div x-show="activeTab === 'sessions'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
        
        {{-- Session Filter & Action Controls --}}
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3">
                <label for="sessionSelect" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                    <i class="fas fa-filter text-teal-600"></i>
                    Pilih Sesi:
                </label>
                <div class="relative min-w-[280px]">
                    <select id="sessionSelect" 
                            x-model="sessionFilter" 
                            @change="loadSessionOverview()"
                            class="w-full pl-3 pr-10 py-2 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all font-medium text-gray-800">
                        <option value="all"> Semua Sesi Kampanye (Agregat)</option>
                        @foreach($sessions as $sess)
                            <option value="{{ $sess->id }}">{{ $sess->name }} ({{ ucfirst($sess->status) }})</option>
                        @endforeach
                    </select>
                </div>

                <button @click="loadSessionOverview()" 
                        class="px-3.5 py-2 text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 hover:text-gray-900 rounded-xl transition font-medium flex items-center gap-1.5"
                        :class="{'animate-spin': loadingSession}">
                    <i class="fas fa-sync-alt" :class="{'fa-spin': loadingSession}"></i>
                    <span>Refresh</span>
                </button>
            </div>

            <div class="flex items-center gap-3">
                <a :href="'{{ route('admin_pemeringkatan.reports.export-session') }}?session_id=' + sessionFilter"
                   class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-xs hover:shadow transition-all duration-150">
                    <i class="fas fa-file-excel mr-2 text-base"></i>
                    <span>Export Excel (2 Sheet)</span>
                </a>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Card 1: Total Responden --}}
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Responden</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1" x-text="sessionStats.total_respondents"></p>
                    <p class="text-xs text-gray-500 mt-0.5">
                        <span class="text-teal-600 font-semibold" x-text="sessionStats.total_sessions"></span> sesi tercakup
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-teal-50 border border-teal-100 flex items-center justify-center text-teal-600 shadow-xs">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>

            {{-- Card 2: Responden Setuju --}}
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Setuju (Selesai)</p>
                    <p class="text-2xl font-bold text-emerald-600 mt-1" x-text="sessionStats.agreed_count"></p>
                    <p class="text-xs text-gray-500 mt-0.5">Sudah memberikan consent</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shadow-xs">
                    <i class="fas fa-check-double text-xl"></i>
                </div>
            </div>

            {{-- Card 3: Menunggu (Pending) --}}
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menunggu (Pending)</p>
                    <p class="text-2xl font-bold text-amber-500 mt-1" x-text="sessionStats.pending_count"></p>
                    <p class="text-xs text-gray-500 mt-0.5">
                        <span x-text="sessionStats.not_emailed_count"></span> belum dikirim email
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-500 shadow-xs">
                    <i class="fas fa-hourglass-half text-xl"></i>
                </div>
            </div>

            {{-- Card 4: Consent Rate --}}
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Tingkat Persetujuan</p>
                    <p class="text-2xl font-bold text-teal-700 mt-1">
                        <span x-text="sessionStats.consent_rate"></span>%
                    </p>
                    <div class="w-28 bg-gray-100 rounded-full h-1.5 mt-2 overflow-hidden">
                        <div class="bg-teal-600 h-1.5 rounded-full transition-all duration-500" 
                             :style="'width: ' + Math.min(sessionStats.consent_rate, 100) + '%'"></div>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-teal-50 border border-teal-100 flex items-center justify-center text-teal-700 shadow-xs">
                    <i class="fas fa-percentage text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Visualizations Row: Charts --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Doughnut / Pie Chart: Status Persetujuan --}}
            <div class="lg:col-span-5 bg-white p-5 sm:p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                    <div>
                        <h2 class="text-base font-bold text-gray-800">Distribusi Status Responden</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Proporsi persetujuan & pengiriman email</p>
                    </div>
                    <span class="p-1.5 bg-gray-50 rounded-lg text-gray-400">
                        <i class="fas fa-chart-pie"></i>
                    </span>
                </div>
                <div class="relative flex-1 flex items-center justify-center min-h-[260px]">
                    <div x-show="loadingSession" class="absolute inset-0 bg-white/70 flex items-center justify-center z-10">
                        <i class="fas fa-spinner fa-spin text-teal-600 text-2xl"></i>
                    </div>
                    <canvas id="consentPieChart" class="max-h-[260px]"></canvas>
                </div>
            </div>

            {{-- Bar Chart: Progres Selesai vs Pending per Fakultas --}}
            <div class="lg:col-span-7 bg-white p-5 sm:p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                    <div>
                        <h2 class="text-base font-bold text-gray-800">Sebaran Selesai vs Pending per Fakultas</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Jumlah responden setuju (selesai) dan pending berdasarkan unit penginput</p>
                    </div>
                    <span class="p-1.5 bg-gray-50 rounded-lg text-gray-400">
                        <i class="fas fa-chart-bar"></i>
                    </span>
                </div>
                <div class="relative flex-1 min-h-[260px]">
                    <div x-show="loadingSession" class="absolute inset-0 bg-white/70 flex items-center justify-center z-10">
                        <i class="fas fa-spinner fa-spin text-teal-600 text-2xl"></i>
                    </div>
                    <canvas id="fakultasBarChart" class="w-full max-h-[260px]"></canvas>
                </div>
            </div>
        </div>

        {{-- Sessions Summary Table --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-gray-800">Daftar Sesi Kampanye & Kinerja</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Ringkasan metrik setiap sesi yang Anda miliki aksesnya</p>
                </div>
                <span class="px-3 py-1 bg-teal-50 text-teal-700 rounded-lg text-xs font-semibold">
                    <span x-text="sessionList.length"></span> Sesi
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50/75 text-xs uppercase text-gray-500 font-semibold border-b border-gray-100">
                        <tr>
                            <th class="px-5 py-3.5">Nama Sesi</th>
                            <th class="px-4 py-3.5">Tipe Sesi</th>
                            <th class="px-4 py-3.5 text-center">Total Responden</th>
                            <th class="px-4 py-3.5 text-center">Setuju (Selesai)</th>
                            <th class="px-4 py-3.5 text-center">Pending</th>
                            <th class="px-4 py-3.5 text-center">Belum Email</th>
                            <th class="px-5 py-3.5">Consent Rate</th>
                            <th class="px-5 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <template x-for="item in sessionList" :key="item.id">
                            <tr class="hover:bg-gray-50/60 transition-colors">
                                <td class="px-5 py-4">
                                    <div class="font-semibold text-gray-900" x-text="item.name"></div>
                                    <div class="text-xs text-gray-400 mt-0.5 flex items-center gap-2">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium"
                                              :class="{
                                                  'bg-emerald-50 text-emerald-700': item.status === 'active',
                                                  'bg-amber-50 text-amber-700': item.status === 'draft',
                                                  'bg-gray-100 text-gray-600': item.status === 'closed'
                                              }"
                                              x-text="item.status.toUpperCase()"></span>
                                        <span x-text="item.start_date + ' s/d ' + item.end_date"></span>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium"
                                          :class="item.is_form_based ? 'bg-indigo-50 text-indigo-700' : 'bg-teal-50 text-teal-700'">
                                        <i class="fas mr-1.5" :class="item.is_form_based ? 'fa-file-alt' : 'fa-handshake'"></i>
                                        <span x-text="item.is_form_based ? 'Form Kuesioner' : 'Consent Saja'"></span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center font-bold text-gray-800" x-text="item.total_count"></td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700" x-text="item.agreed_count"></span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700" x-text="item.pending_count"></span>
                                </td>
                                <td class="px-4 py-4 text-center text-xs text-gray-400" x-text="item.not_emailed_count"></td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 bg-gray-100 rounded-full h-2 overflow-hidden max-w-[90px]">
                                            <div class="bg-teal-600 h-2 rounded-full transition-all" :style="'width: ' + Math.min(item.consent_rate, 100) + '%'"></div>
                                        </div>
                                        <span class="text-xs font-bold text-gray-700" x-text="item.consent_rate + '%'"></span>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <a :href="'{{ url('admin_pemeringkatan/reports/session-breakdown') }}/' + item.id" 
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 rounded-lg transition-colors shadow-2xs hover:shadow-xs">
                                        <i class="fas fa-sitemap mr-1.5"></i>
                                        Breakdown Unit
                                    </a>
                                </td>
                            </tr>
                        </template>

                        <tr x-show="sessionList.length === 0 && !loadingSession">
                            <td colspan="8" class="text-center py-10 text-gray-400">
                                <i class="fas fa-folder-open text-3xl mb-2 block"></i>
                                Belum ada data sesi kampanye yang tersedia.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- TAB 2: ARSIP RESPONDEN LEGACY --}}
    <div x-show="activeTab === 'legacy'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
        
        {{-- Legacy Filter Bar --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm space-y-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 border-b border-gray-100 pb-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center font-bold text-sm">
                        <i class="fas fa-filter"></i>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="font-bold text-gray-800 text-sm">Filter Arsip Responden</span>
                        @if(Auth::user()->isProdi())
                            <span class="text-[11px] font-medium text-blue-700 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded-full inline-flex items-center gap-1">
                                <i class="fas fa-user-lock text-[10px]"></i> Responden Inputan Akun Anda
                            </span>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button @click="resetLegacyFilters()" 
                            class="px-3 py-1.5 text-xs font-medium text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                        <i class="fas fa-undo mr-1"></i> Reset
                    </button>
                    <a :href="getLegacyExportUrl()"
                       class="inline-flex items-center px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg shadow-xs transition">
                        <i class="fas fa-file-excel mr-1.5"></i> Export Excel
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">
                {{-- Jenjang Tanggal (Date Created) Filter --}}
                <div class="sm:col-span-2 lg:col-span-2">
                    <label class="block text-xs font-medium text-gray-500 mb-1 flex items-center justify-between">
                        <span class="flex items-center gap-1">
                            <i class="far fa-calendar-alt text-teal-600"></i>
                            <span class="font-semibold text-gray-700">Jenjang Tanggal</span>
                            <span class="text-[10px] text-gray-400 font-normal">(Date Created)</span>
                        </span>
                        <template x-if="legacyFilters.start_date || legacyFilters.end_date">
                            <button type="button" 
                                    @click="legacyFilters.start_date = ''; legacyFilters.end_date = ''; loadLegacyData(1);" 
                                    class="text-[10px] text-red-500 hover:text-red-700 font-medium hover:underline flex items-center gap-0.5">
                                <i class="fas fa-times-circle text-[9px]"></i> Reset Tgl
                            </button>
                        </template>
                    </label>
                    <div class="flex items-center gap-1.5">
                        <input type="date" 
                               x-model="legacyFilters.start_date" 
                               @change="loadLegacyData(1)"
                               title="Dari Tanggal (Date Created Mulai)"
                               class="w-full px-2.5 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500">
                        <span class="text-xs text-gray-400 font-medium shrink-0">s/d</span>
                        <input type="date" 
                               x-model="legacyFilters.end_date" 
                               @change="loadLegacyData(1)"
                               title="Sampai Tanggal (Date Created Selesai)"
                               class="w-full px-2.5 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500">
                    </div>
                </div>

                {{-- Year Filter --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Tahun</label>
                    <select x-model="legacyFilters.year" @change="loadLegacyData(1)"
                            class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500">
                        <option value="all">Semua Tahun</option>
                        @foreach($legacyYears as $yr)
                            <option value="{{ $yr }}">{{ $yr }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Fakultas Filter --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Fakultas</label>
                    @if(Auth::user()->isProdi())
                        <div class="w-full px-3 py-2 text-xs bg-gray-100 border border-gray-200 rounded-xl text-gray-600 flex items-center justify-between" title="Dibatasi hanya data responden yang Anda input">
                            <span class="font-medium truncate">{{ $legacyFaculties[0] ?? 'Prodi' }}</span>
                            <span class="text-[10px] text-blue-600 font-semibold bg-blue-50 px-1.5 py-0.5 rounded shrink-0">Terkunci</span>
                        </div>
                    @else
                        <select x-model="legacyFilters.fakultas" @change="legacyFilters.inputer = 'all'; loadLegacyData(1)"
                                class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500">
                            <option value="all">Semua Fakultas</option>
                            @foreach($legacyFaculties as $fak)
                                <option value="{{ strtolower($fak) }}">{{ $fak }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>

                {{-- Kategori Filter --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Kategori</label>
                    <select x-model="legacyFilters.category" @change="loadLegacyData(1)"
                            class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500">
                        <option value="all">Semua Kategori</option>
                        <option value="academic">Academic</option>
                        <option value="employer">Employer / Industri</option>
                    </select>
                </div>

                {{-- Status Filter --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                    <select x-model="legacyFilters.status" @change="loadLegacyData(1)"
                            class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500">
                        <option value="all">Semua Status</option>
                        <optgroup label="Status Akhir (Pengisian Form)">
                            <option value="selesai">Selesai (Form Terisi)</option>
                            <option value="belum_selesai">Belum Selesai</option>
                        </optgroup>
                        <optgroup label="Status Pengiriman Email">
                            <option value="belum">Belum di-email</option>
                            <option value="done">Sudah di-email</option>
                            <option value="dones">Follow up done</option>
                        </optgroup>
                    </select>
                </div>

                {{-- Penginput Filter (options follow current scope, built from breakdown) --}}
                @if(!Auth::user()->isProdi())
                    <div class="sm:col-span-2 lg:col-span-2">
                        <label for="legacyInputerSelect" class="block text-xs font-medium text-gray-500 mb-1 flex items-center gap-1">
                            <i class="fas fa-user-edit text-teal-600"></i>
                            <span>Penginput</span>
                        </label>
                        <select id="legacyInputerSelect"
                                x-model="legacyFilters.inputer"
                                @change="loadLegacyData(1)"
                                class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500">
                            <option value="all">Semua Penginput</option>
                            <template x-for="item in flattenedInputerOptions" :key="'opt-' + item.id">
                                <option :value="item.id"
                                        :disabled="item.disabled"
                                        :class="item.disabled ? 'font-bold bg-gray-100 text-gray-400' : ''"
                                        x-text="item.label"></option>
                            </template>
                        </select>
                    </div>
                @endif

                {{-- Search Box --}}
                <div class="sm:col-span-2 {{ Auth::user()->isProdi() ? 'lg:col-span-6' : 'lg:col-span-4' }}">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Pencarian Cepat</label>
                    <div class="relative">
                        <input type="text" 
                               x-model="legacyFilters.search" 
                               @input.debounce.400ms="loadLegacyData(1)"
                               placeholder="Nama, email, instansi, jabatan, no. telepon..."
                               class="w-full pl-8 pr-3 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500">
                        <i class="fas fa-search absolute left-2.5 top-2.5 text-gray-400 text-xs"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Legacy Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Responden Legacy</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1" x-text="legacyStats.total"></p>
                    <p class="text-xs text-gray-500 mt-0.5">Sesuai filter aktif</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center shadow-xs">
                    <i class="fas fa-address-book text-xl"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Selesai (Form Terisi)</p>
                    <p class="text-2xl font-bold text-emerald-600 mt-1" x-text="legacyStats.finished"></p>
                    <p class="text-xs text-gray-500 mt-0.5">Sudah mengisi form survey</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-xs">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Belum Selesai</p>
                    <p class="text-2xl font-bold text-amber-500 mt-1" x-text="legacyStats.pending"></p>
                    <p class="text-xs text-gray-500 mt-0.5">Belum mengisi form survey</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center shadow-xs">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Rasio Selesai</p>
                    <p class="text-2xl font-bold text-teal-700 mt-1">
                        <span x-text="legacyStats.rate"></span>%
                    </p>
                    <div class="w-28 bg-gray-100 rounded-full h-1.5 mt-2 overflow-hidden">
                        <div class="bg-teal-600 h-1.5 rounded-full transition-all" 
                             :style="'width: ' + Math.min(legacyStats.rate, 100) + '%'"></div>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center shadow-xs">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Layout: Sebaran Penginput on the Left & Daftar Arsip Responden Table on the Right --}}
        <div class="grid grid-cols-1 @if(!Auth::user()->isProdi()) xl:grid-cols-12 @endif gap-6 items-start">

            {{-- Left Column: Sebaran Penginput --}}
            @if(!Auth::user()->isProdi())
                <div x-show="showInputerSidebar" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-x-2"
                     x-transition:enter-end="opacity-100 translate-x-0"
                     class="xl:col-span-3 space-y-4 xl:sticky xl:top-6">
                    <div id="legacyInputerPanel" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden relative">
                        <div class="p-4 sm:p-5 border-b border-gray-100 flex flex-col gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-teal-50 border border-teal-100 text-teal-600 flex items-center justify-center shadow-xs shrink-0">
                                    <i class="fas fa-user-edit"></i>
                                </div>
                                <div class="min-w-0">
                                    <h2 class="text-base font-bold text-gray-800 truncate">Sebaran Penginput</h2>
                                    <p class="text-[11px] text-gray-400 mt-0.5 line-clamp-2">
                                        Klik akun untuk memfilter data pada tabel di sebelah kanan.
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between gap-2 flex-wrap pt-1 border-t border-gray-50">
                                <template x-if="legacyFilters.inputer !== 'all'">
                                    <button type="button"
                                            id="legacyInputerClearChip"
                                            @click="filterByInputer(legacyFilters.inputer)"
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-teal-600 text-white hover:bg-teal-700 shadow-xs transition max-w-[220px]"
                                            title="Hapus filter penginput">
                                        <i class="fas fa-times-circle text-[10px]"></i>
                                        <span class="truncate" x-text="selectedInputerName()"></span>
                                    </button>
                                </template>
                                <div class="flex items-center gap-1.5 ml-auto flex-wrap">
                                    <button type="button"
                                            @click="openProdiStatsModal()"
                                            x-show="prodiStats.count > 0"
                                            class="px-2 py-1 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg transition flex items-center gap-1 cursor-pointer shadow-2xs"
                                            title="Lihat grafik visual & rincian angka seluruh akun program studi">
                                        <i class="fas fa-chart-bar text-[11px] text-blue-600"></i>
                                        <span>Grafik Prodi</span>
                                    </button>
                                    <button type="button"
                                            id="legacyInputerToggleAll"
                                            x-show="legacyBreakdown.length > 0"
                                            @click="toggleAllInputerGroups()"
                                            class="px-2 py-1 text-xs font-medium text-gray-600 bg-gray-100 hover:bg-200 hover:text-gray-900 rounded-lg transition cursor-pointer">
                                        <i class="fas mr-1 text-[10px]" :class="allInputerGroupsOpen() ? 'fa-compress-alt' : 'fa-expand-alt'"></i>
                                        <span x-text="allInputerGroupsOpen() ? 'Tutup' : 'Buka'"></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div x-show="loadingLegacy" class="absolute inset-0 bg-white/60 flex items-center justify-center z-10">
                            <i class="fas fa-spinner fa-spin text-teal-600 text-2xl"></i>
                        </div>

                        <div class="p-4 sm:p-5">
                            <div x-show="legacyBreakdown.length === 0 && !loadingLegacy" class="text-center py-8 text-gray-400 text-sm">
                                <i class="fas fa-user-slash text-3xl mb-2 block"></i>
                                Tidak ada data penginput untuk filter ini.
                            </div>

                            <div class="space-y-3">
                                <template x-for="group in legacyBreakdown" :key="group.type">
                                    <div class="rounded-xl border overflow-hidden transition-shadow hover:shadow-xs" :class="inputerTypeMeta(group.type).border">
                                        {{-- Group header --}}
                                        <button type="button"
                                                @click="toggleInputerGroup(group.type)"
                                                class="w-full flex items-center justify-between gap-2.5 px-3.5 py-2.5 text-left transition-colors cursor-pointer"
                                                :class="inputerTypeMeta(group.type).headerBg">
                                            <div class="flex items-center gap-2.5 min-w-0">
                                                <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0" :class="inputerTypeMeta(group.type).iconBg">
                                                    <i class="fas text-xs" :class="inputerTypeMeta(group.type).icon"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="text-xs font-bold text-gray-800 truncate" x-text="group.label"></div>
                                                    <div class="text-[10px] text-gray-500">
                                                        <span x-text="group.inputers.length"></span> akun &middot;
                                                        <span x-text="group.finished"></span>/<span x-text="group.total"></span> selesai
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2 shrink-0">
                                                <template x-if="group.type === 'prodi'">
                                                    <span @click.stop="openProdiStatsModal()" 
                                                          class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-700 hover:bg-blue-200 transition cursor-pointer"
                                                          title="Buka grafik & peringkat prodi">
                                                        <i class="fas fa-chart-bar text-[9px]"></i>
                                                        <span>Grafik</span>
                                                    </span>
                                                </template>
                                                <div class="text-right">
                                                    <div class="text-base font-bold text-gray-900 leading-tight" x-text="group.total"></div>
                                                    <div class="text-[9px] font-semibold" :class="inputerTypeMeta(group.type).text" x-text="group.rate + '%'"></div>
                                                </div>
                                                <i class="fas fa-chevron-down text-gray-400 text-[10px] transition-transform duration-200"
                                                   :class="{ 'rotate-180': isInputerGroupOpen(group.type) }"></i>
                                            </div>
                                        </button>

                                        {{-- Inputer accounts --}}
                                        <div x-show="isInputerGroupOpen(group.type)"
                                             x-transition:enter="transition ease-out duration-150"
                                             x-transition:enter-start="opacity-0 -translate-y-1"
                                             x-transition:enter-end="opacity-100 translate-y-0"
                                             class="bg-white border-t border-gray-100">

                                            {{-- Mini Summary Banner & Search for Prodi --}}
                                            <template x-if="group.type === 'prodi'">
                                                <div class="p-2.5 bg-blue-50/50 border-b border-blue-100/70 space-y-2">
                                                    <div class="flex items-center justify-between text-[11px] text-blue-900 font-semibold">
                                                        <span>Rata-rata: <strong x-text="prodiStats.avg"></strong> /prodi</span>
                                                        <button type="button" 
                                                                @click="openProdiStatsModal()"
                                                                class="text-blue-700 hover:underline flex items-center gap-1 font-bold cursor-pointer">
                                                            <i class="fas fa-chart-bar text-[10px]"></i>
                                                            <span>Lihat Grafik</span>
                                                        </button>
                                                    </div>
                                                    <div class="relative" x-show="group.inputers.length > 5">
                                                        <input type="text" 
                                                               x-model="prodiSearchQuery" 
                                                               placeholder="Cari nama prodi..."
                                                               class="w-full pl-7 pr-2.5 py-1 text-[11px] bg-white border border-blue-200 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 text-gray-700">
                                                        <i class="fas fa-search absolute left-2 top-2 text-blue-400 text-[10px]"></i>
                                                    </div>
                                                </div>
                                            </template>

                                            <ul class="divide-y divide-gray-100 max-h-56 overflow-y-auto">
                                                <template x-for="inp in (group.type === 'prodi' && prodiSearchQuery.trim() ? group.inputers.filter(i => i.name.toLowerCase().includes(prodiSearchQuery.toLowerCase())) : group.inputers)" :key="group.type + '-' + inp.id">
                                                    <li>
                                                        <button type="button"
                                                                @click="filterByInputer(inp.id)"
                                                                class="w-full flex items-center gap-2.5 px-3.5 py-2 text-left transition-colors hover:bg-gray-50 cursor-pointer"
                                                                :class="legacyFilters.inputer === inp.id ? 'bg-teal-50 ring-1 ring-inset ring-teal-300' : ''"
                                                                :title="legacyFilters.inputer === inp.id ? 'Klik untuk menghapus filter' : 'Tampilkan responden yang diinput oleh ' + inp.name">
                                                            <div class="flex-1 min-w-0">
                                                                <div class="text-xs font-semibold text-gray-800 truncate" x-text="inp.name"></div>
                                                                <div class="mt-0.5 flex items-center gap-1.5">
                                                                    <div class="flex-1 bg-gray-100 rounded-full h-1 overflow-hidden max-w-[100px]">
                                                                        <div class="h-1 rounded-full transition-all duration-500"
                                                                             :class="inputerTypeMeta(group.type).bar"
                                                                             :style="'width: ' + Math.min(inp.rate, 100) + '%'"></div>
                                                                    </div>
                                                                    <span class="text-[9px] text-gray-500 whitespace-nowrap" x-text="inp.finished + ' sel. · ' + inp.rate + '%'"></span>
                                                                </div>
                                                            </div>
                                                            <span class="text-xs font-bold text-gray-900 shrink-0" x-text="inp.total"></span>
                                                            <i class="fas text-[10px] shrink-0"
                                                               :class="legacyFilters.inputer === inp.id ? 'fa-check-circle text-teal-600' : 'fa-filter text-gray-300'"></i>
                                                        </button>
                                                    </li>
                                                </template>
                                            </ul>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Right Column: Daftar Arsip Responden Table --}}
            <div :class="(!showInputerSidebar || {{ Auth::user()->isProdi() ? 'true' : 'false' }}) ? 'col-span-12 w-full' : 'xl:col-span-9 w-full'" 
                 class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-200">
                <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <div class="flex items-center gap-2.5">
                            <h2 class="text-base font-bold text-gray-800">Daftar Arsip Responden</h2>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-700" 
                                  x-text="(legacyPagination.total || 0) + ' data'"></span>
                        </div>
                        <p class="text-xs text-gray-400 mt-0.5">Semua detail responden terdata langsung tanpa perlu geser/scroll horizontal.</p>
                    </div>

                    <div class="flex items-center gap-2.5 flex-wrap">
                        <div x-show="loadingLegacy" class="text-teal-600 text-xs font-medium flex items-center gap-1.5 mr-1">
                            <i class="fas fa-spinner fa-spin"></i> Memuat data...
                        </div>

                        {{-- Mode View Toggle: Fit Layar (No Scroll) vs 9 Kolom --}}
                        <div class="inline-flex p-0.5 bg-gray-100 rounded-xl text-xs font-medium">
                            <button type="button" 
                                    @click="legacyTableMode = 'compact'"
                                    :class="legacyTableMode === 'compact' ? 'bg-white text-teal-700 shadow-2xs font-bold' : 'text-gray-500 hover:text-gray-900 font-medium'"
                                    class="px-2.5 py-1 rounded-lg transition flex items-center gap-1.5 cursor-pointer"
                                    title="Tampilkan seluruh detail dalam 5 kolom rapi yang pas di layar tanpa scroll bar">
                                <i class="fas fa-table-cells text-[10px]"></i>
                                <span>Fit Layar</span>
                            </button>
                            <button type="button" 
                                    @click="legacyTableMode = 'full'"
                                    :class="legacyTableMode === 'full' ? 'bg-white text-teal-700 shadow-2xs font-bold' : 'text-gray-500 hover:text-gray-900 font-medium'"
                                    class="px-2.5 py-1 rounded-lg transition flex items-center gap-1.5 cursor-pointer"
                                    title="Tampilkan tabel klasik 9 kolom terpisah dengan scroll horizontal">
                                <i class="fas fa-table-columns text-[10px]"></i>
                                <span>9 Kolom</span>
                            </button>
                        </div>

                        {{-- Toggle Sidebar Penginput (if not Prodi) --}}
                        @if(!Auth::user()->isProdi())
                            <button type="button" 
                                    @click="showInputerSidebar = !showInputerSidebar"
                                    class="px-3 py-1.5 text-xs font-medium rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 transition shadow-2xs flex items-center gap-1.5 cursor-pointer"
                                    :title="showInputerSidebar ? 'Sembunyikan panel sebaran penginput agar tabel lebih lebar' : 'Tampilkan panel sebaran penginput'">
                                <i class="fas text-[11px]" :class="showInputerSidebar ? 'fa-arrows-alt-h text-teal-600' : 'fa-columns text-gray-500'"></i>
                                <span x-text="showInputerSidebar ? 'Lebarkan Tabel' : 'Buka Penginput'"></span>
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Table 1: Fit Layar (Compact & Integrated Columns - NO Horizontal Scroll) --}}
                <div x-show="legacyTableMode === 'compact'" class="w-full overflow-x-visible">
                    <table class="w-full text-left text-sm text-gray-600 table-auto">
                        <thead class="bg-gray-50/75 text-xs uppercase text-gray-500 font-semibold border-b border-gray-100">
                            <tr>
                                <th class="px-4 py-3.5 w-[18%]">Penginput</th>
                                <th class="px-4 py-3.5 w-[28%]">Responden & Kontak</th>
                                <th class="px-4 py-3.5 w-[24%]">Instansi & Posisi</th>
                                <th class="px-4 py-3.5 w-[18%] text-center">Kategori & Status</th>
                                <th class="px-4 py-3.5 w-[12%] text-right">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <template x-for="item in legacyItems" :key="'compact-' + item.id">
                                <tr class="hover:bg-gray-50/60 transition-colors">
                                    {{-- 1. Penginput --}}
                                    <td class="px-4 py-3.5 align-top">
                                        <div class="text-xs font-bold text-gray-900 break-words line-clamp-2"
                                             :title="item.inputer_name"
                                             x-text="item.inputer_name || '-'"></div>
                                        <div class="mt-1 flex items-center gap-1 flex-wrap">
                                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded border text-[10px] font-semibold"
                                                  :class="inputerTypeMeta(item.inputer_type).badge">
                                                <i class="fas text-[8px]" :class="inputerTypeMeta(item.inputer_type).icon"></i>
                                                <span x-text="inputerTypeMeta(item.inputer_type).short"></span>
                                            </span>
                                        </div>
                                    </td>

                                    {{-- 2. Responden & Kontak --}}
                                    <td class="px-4 py-3.5 align-top">
                                        <div class="flex items-baseline gap-1.5 flex-wrap">
                                            <span class="font-bold text-gray-900 text-xs sm:text-sm" x-text="item.fullname || '-'"></span>
                                            <span class="text-[11px] font-medium text-teal-700" x-show="item.title" x-text="'(' + item.title + ')'"></span>
                                        </div>
                                        <div class="mt-1 space-y-0.5 text-xs">
                                            <div class="text-gray-600 flex items-center gap-1.5 break-all">
                                                <i class="far fa-envelope text-gray-400 text-[10px] shrink-0"></i>
                                                <span x-text="item.email || '-'"></span>
                                            </div>
                                            <div class="text-gray-500 text-[11px] flex items-center gap-1.5" x-show="item.phone_responden">
                                                <i class="fas fa-phone-alt text-gray-400 text-[9px] shrink-0"></i>
                                                <span x-text="item.phone_responden"></span>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- 3. Instansi & Posisi --}}
                                    <td class="px-4 py-3.5 align-top">
                                        <div class="text-xs font-bold text-gray-900 break-words" x-text="item.instansi || '-'"></div>
                                        <div class="text-xs text-gray-500 mt-0.5" x-text="item.jabatan || '-'"></div>
                                        <div class="mt-1.5 flex items-center gap-1.5 flex-wrap">
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200"
                                                  title="Fakultas">
                                                <i class="fas fa-university mr-1 text-[9px] text-slate-400"></i>
                                                <span x-text="item.fakultas ? item.fakultas.toUpperCase() : '-'"></span>
                                            </span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold"
                                                  :class="item.category === 'academic' ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-amber-50 text-amber-700 border border-amber-200'">
                                                <i class="fas mr-1 text-[8px]" :class="item.category === 'academic' ? 'fa-graduation-cap' : 'fa-briefcase'"></i>
                                                <span x-text="item.category ? item.category.toUpperCase() : '-'"></span>
                                            </span>
                                        </div>
                                    </td>

                                    {{-- 4. Kategori & Status --}}
                                    <td class="px-4 py-3.5 align-top text-center">
                                        <div class="inline-flex flex-col items-center gap-1.5">
                                            {{-- Status Akhir --}}
                                            <template x-if="item.is_finished == 1 || item.status === 'clear' || item.status === 'selesai'">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                                    <i class="fas fa-check-circle mr-1 text-emerald-600"></i> Selesai
                                                </span>
                                            </template>
                                            <template x-if="item.is_finished != 1 && item.status !== 'clear' && item.status !== 'selesai'">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                    <i class="fas fa-hourglass-half mr-1 text-amber-500"></i> Belum Selesai
                                                </span>
                                            </template>

                                            {{-- Status Email --}}
                                            <div>
                                                <template x-if="item.status === 'done'">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                                        <i class="fas fa-paper-plane mr-1 text-blue-500 text-[9px]"></i> Di-email
                                                    </span>
                                                </template>
                                                <template x-if="item.status === 'dones'">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">
                                                        <i class="fas fa-envelope-open-text mr-1 text-indigo-500 text-[9px]"></i> Follow up
                                                    </span>
                                                </template>
                                                <template x-if="item.status === 'clear' || item.status === 'selesai'">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-emerald-50 text-emerald-700">
                                                        <i class="fas fa-check mr-1 text-[9px]"></i> Form Clear
                                                    </span>
                                                </template>
                                                <template x-if="!['done', 'dones', 'clear', 'selesai'].includes(item.status)">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-gray-100 text-gray-500">
                                                        <i class="fas fa-clock mr-1 text-[9px]"></i> Belum Email
                                                    </span>
                                                </template>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- 5. Tanggal & Aksi Detail --}}
                                    <td class="px-4 py-3.5 align-top text-right">
                                        <div class="text-xs font-semibold text-gray-800" x-text="formatDate(item.created_at)"></div>
                                        <div class="text-[10px] text-gray-400" x-text="formatTime(item.created_at)"></div>
                                        <button type="button" 
                                                @click="openRespondentDetail(item)"
                                                class="mt-1.5 inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 transition cursor-pointer">
                                            <i class="fas fa-eye text-[10px]"></i>
                                            <span>Detail</span>
                                        </button>
                                    </td>
                                </tr>
                            </template>

                            <tr x-show="legacyItems.length === 0 && !loadingLegacy">
                                <td colspan="5" class="text-center py-12 text-gray-400">
                                    <i class="fas fa-search text-3xl mb-2 block"></i>
                                    Tidak ada data responden legacy yang sesuai dengan filter.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Table 2: Full 9 Columns View (Horizontal Scroll) --}}
                <div x-show="legacyTableMode === 'full'" class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600 min-w-[950px]">
                        <thead class="bg-gray-50/75 text-xs uppercase text-gray-500 font-semibold border-b border-gray-100">
                            <tr>
                                <th class="px-4 py-3.5">Penginput</th>
                                <th class="px-5 py-3.5">Responden</th>
                                <th class="px-5 py-3.5">Kontak</th>
                                <th class="px-5 py-3.5">Instansi & Jabatan</th>
                                <th class="px-4 py-3.5 text-center">Fakultas</th>
                                <th class="px-4 py-3.5 text-center">Kategori</th>
                                <th class="px-4 py-3.5 text-center">Status Email</th>
                                <th class="px-5 py-3.5 text-center">Status Akhir</th>
                                <th class="px-4 py-3.5 text-center">Tanggal Dibuat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <template x-for="item in legacyItems" :key="'full-' + item.id">
                                <tr class="hover:bg-gray-50/60 transition-colors">
                                    <td class="px-4 py-3.5">
                                        <div class="text-xs font-semibold text-gray-800 max-w-[150px] truncate"
                                             :title="item.inputer_name"
                                             x-text="item.inputer_name || '-'"></div>
                                        <span class="mt-1 inline-flex items-center gap-1 px-1.5 py-0.5 rounded border text-[10px] font-semibold"
                                              :class="inputerTypeMeta(item.inputer_type).badge">
                                            <i class="fas text-[9px]" :class="inputerTypeMeta(item.inputer_type).icon"></i>
                                            <span x-text="inputerTypeMeta(item.inputer_type).short"></span>
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <div class="font-semibold text-gray-900" x-text="item.fullname || '-'"></div>
                                        <div class="text-xs text-gray-400" x-text="item.title ? item.title.toUpperCase() : ''"></div>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <div class="text-xs font-medium text-gray-800" x-text="item.email || '-'"></div>
                                        <div class="text-xs text-gray-400" x-text="item.phone_responden || '-'"></div>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <div class="text-xs font-semibold text-gray-800" x-text="item.instansi || '-'"></div>
                                        <div class="text-xs text-gray-400" x-text="item.jabatan || '-'"></div>
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <span class="px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700" 
                                              x-text="item.fakultas ? item.fakultas.toUpperCase() : '-'"></span>
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold"
                                              :class="item.category === 'academic' ? 'bg-indigo-50 text-indigo-700' : 'bg-amber-50 text-amber-700'"
                                              x-text="item.category ? item.category.toUpperCase() : '-'"></span>
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <template x-if="item.status === 'done'">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                                <i class="fas fa-paper-plane mr-1 text-blue-500 text-[10px]"></i> Sudah di-email
                                            </span>
                                        </template>
                                        <template x-if="item.status === 'dones'">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">
                                                <i class="fas fa-envelope-open-text mr-1 text-indigo-500 text-[10px]"></i> Follow up done
                                            </span>
                                        </template>
                                        <template x-if="item.status === 'clear' || item.status === 'selesai'">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <i class="fas fa-check mr-1 text-emerald-500 text-[10px]"></i> Selesai
                                            </span>
                                        </template>
                                        <template x-if="!['done', 'dones', 'clear', 'selesai'].includes(item.status)">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                                <i class="fas fa-clock mr-1 text-gray-400 text-[10px]"></i> Belum di-email
                                            </span>
                                        </template>
                                    </td>
                                    <td class="px-5 py-3.5 text-center">
                                        <template x-if="item.is_finished == 1 || item.status === 'clear' || item.status === 'selesai'">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                                <i class="fas fa-check-circle mr-1.5 text-emerald-600"></i>
                                                Selesai
                                            </span>
                                        </template>
                                        <template x-if="item.is_finished != 1 && item.status !== 'clear' && item.status !== 'selesai'">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                <i class="fas fa-hourglass-half mr-1.5 text-amber-500"></i>
                                                Belum Selesai
                                            </span>
                                        </template>
                                    </td>
                                    <td class="px-4 py-3.5 text-center text-xs text-gray-600 font-medium whitespace-nowrap">
                                        <div class="font-semibold text-gray-800" x-text="formatDate(item.created_at)"></div>
                                        <div class="text-[10px] text-gray-400" x-text="formatTime(item.created_at)"></div>
                                    </td>
                                </tr>
                            </template>

                            <tr x-show="legacyItems.length === 0 && !loadingLegacy">
                                <td colspan="9" class="text-center py-10 text-gray-400">
                                    <i class="fas fa-search text-3xl mb-2 block"></i>
                                    Tidak ada data responden legacy yang sesuai dengan filter.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Footer --}}
                <div class="px-5 py-3.5 bg-gray-50/75 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-500">
                    <div>
                        Menampilkan <span class="font-bold text-gray-700" x-text="legacyPagination.from || 0"></span> - 
                        <span class="font-bold text-gray-700" x-text="legacyPagination.to || 0"></span> dari 
                        <span class="font-bold text-gray-700" x-text="legacyPagination.total || 0"></span> data
                    </div>
                    <div class="flex items-center gap-1.5">
                        <button @click="loadLegacyData(legacyPagination.current_page - 1)" 
                                :disabled="legacyPagination.current_page <= 1"
                                class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed transition font-medium cursor-pointer">
                            <i class="fas fa-chevron-left mr-1"></i> Prev
                        </button>
                        <span class="px-3 py-1.5 text-gray-700 font-bold">
                            Halaman <span x-text="legacyPagination.current_page"></span> dari <span x-text="legacyPagination.last_page || 1"></span>
                        </span>
                        <button @click="loadLegacyData(legacyPagination.current_page + 1)" 
                                :disabled="legacyPagination.current_page >= legacyPagination.last_page"
                                class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed transition font-medium cursor-pointer">
                            Next <i class="fas fa-chevron-right ml-1"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>

    </div>

    {{-- MODAL: BREAKDOWN DETAIL UNIT PER SESI --}}
    <div x-show="detailModalOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-xs flex items-center justify-center p-4"
         x-cloak>
        <div @click.away="detailModalOpen = false" 
             class="bg-white rounded-2xl border border-gray-100 shadow-2xl max-w-4xl w-full max-h-[90vh] flex flex-col overflow-hidden">
            
            {{-- Modal Header --}}
            <div class="p-6 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                        <i class="fas fa-sitemap text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900" x-text="selectedSessionDetail?.session?.name || 'Detail Sesi'"></h3>
                        <p class="text-xs text-gray-500 mt-0.5">Breakdown capaian responden per fakultas dan prodi</p>
                    </div>
                </div>
                <button @click="detailModalOpen = false" class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-6 space-y-6 overflow-y-auto flex-1">
                {{-- Session Summary Pills --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 text-center">
                        <span class="text-[11px] font-semibold text-gray-400 uppercase">Total Responden</span>
                        <p class="text-xl font-bold text-gray-900 mt-0.5" x-text="selectedSessionDetail?.session?.total_respondents || 0"></p>
                    </div>
                    <div class="bg-emerald-50/60 p-3.5 rounded-xl border border-emerald-100 text-center">
                        <span class="text-[11px] font-semibold text-emerald-600 uppercase">Setuju (Selesai)</span>
                        <p class="text-xl font-bold text-emerald-700 mt-0.5" x-text="selectedSessionDetail?.session?.agreed_count || 0"></p>
                    </div>
                    <div class="bg-teal-50/60 p-3.5 rounded-xl border border-teal-100 text-center">
                        <span class="text-[11px] font-semibold text-teal-600 uppercase">Consent Rate</span>
                        <p class="text-xl font-bold text-teal-800 mt-0.5" x-text="(selectedSessionDetail?.session?.rate || 0) + '%'"></p>
                    </div>
                    <div class="bg-indigo-50/60 p-3.5 rounded-xl border border-indigo-100 text-center">
                        <span class="text-[11px] font-semibold text-indigo-600 uppercase">Tipe Sesi</span>
                        <p class="text-xs font-bold text-indigo-700 mt-1.5" x-text="selectedSessionDetail?.session?.mode === 'form_based' ? 'Form Kuesioner' : 'Consent Saja'"></p>
                    </div>
                </div>

                {{-- Unit Breakdown Table --}}
                <div class="border border-gray-100 rounded-xl overflow-hidden shadow-2xs">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500 font-semibold border-b border-gray-100">
                            <tr>
                                <th class="px-4 py-3">Fakultas / Unit</th>
                                <th class="px-3 py-3 text-center">Total</th>
                                <th class="px-3 py-3 text-center">Setuju</th>
                                <th class="px-3 py-3 text-center">Pending</th>
                                <th class="px-3 py-3 text-center">Belum Email</th>
                                <th class="px-4 py-3">Persetujuan (%)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <template x-for="u in selectedSessionDetail?.units || []" :key="u.unit">
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-4 py-3 font-semibold text-gray-900">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-university text-teal-600 text-xs"></i>
                                            <span x-text="u.unit"></span>
                                        </div>
                                        {{-- Sub-prodis if available --}}
                                        <template x-if="u.prodis && u.prodis.length > 0">
                                            <div class="mt-1 pl-5 space-y-0.5">
                                                <template x-for="p in u.prodis" :key="p.name">
                                                    <div class="text-[11px] text-gray-500 flex items-center gap-1.5">
                                                        <span class="w-1 h-1 rounded-full bg-gray-400"></span>
                                                        <span x-text="p.name"></span>: 
                                                        <span class="font-semibold text-gray-700" x-text="p.total"></span> responden
                                                        (<span class="text-emerald-600 font-medium" x-text="p.agreed + ' setuju'"></span>)
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                    </td>
                                    <td class="px-3 py-3 text-center font-bold text-gray-800" x-text="u.total"></td>
                                    <td class="px-3 py-3 text-center">
                                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700" x-text="u.agreed"></span>
                                    </td>
                                    <td class="px-3 py-3 text-center">
                                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700" x-text="u.pending"></span>
                                    </td>
                                    <td class="px-3 py-3 text-center text-xs text-gray-400" x-text="u.not_emailed"></td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 bg-gray-100 rounded-full h-2 overflow-hidden max-w-[80px]">
                                                <div class="bg-teal-600 h-2 rounded-full" :style="'width: ' + Math.min(u.rate, 100) + '%'"></div>
                                            </div>
                                            <span class="text-xs font-bold text-gray-700" x-text="u.rate + '%'"></span>
                                        </div>
                                    </td>
                                </tr>
                            </template>

                            <tr x-show="!selectedSessionDetail?.units || selectedSessionDetail.units.length === 0">
                                <td colspan="6" class="text-center py-6 text-gray-400 text-xs">
                                    Belum ada data unit yang tercatat pada sesi ini.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="p-4 border-t border-gray-100 bg-gray-50 flex items-center justify-end">
                <button @click="detailModalOpen = false" 
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs font-semibold rounded-xl transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL: DETAIL LENGKAP RESPONDEN LEGACY --}}
    <div x-show="respondentDetailModalOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-xs flex items-center justify-center p-4"
         x-cloak>
        <div @click.away="closeRespondentDetail()" 
             class="bg-white rounded-2xl border border-gray-100 shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col overflow-hidden">
            
            {{-- Modal Header --}}
            <div class="p-6 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                        <i class="fas fa-user-circle text-xl"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="text-base font-bold text-gray-900 truncate" x-text="selectedRespondentDetail?.fullname || 'Detail Responden'"></h3>
                            <span class="text-xs font-semibold text-teal-700" x-show="selectedRespondentDetail?.title" x-text="'(' + selectedRespondentDetail?.title + ')'"></span>
                        </div>
                        <p class="text-xs text-gray-400 mt-0.5">Informasi lengkap data responden arsip legacy</p>
                    </div>
                </div>
                <button @click="closeRespondentDetail()" class="text-gray-400 hover:text-gray-600 transition cursor-pointer p-1">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-6 space-y-5 overflow-y-auto flex-1 text-xs">
                
                {{-- Toast copy alert --}}
                <div x-show="copiedToast" 
                     x-transition 
                     class="p-2.5 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-semibold flex items-center gap-2">
                    <i class="fas fa-check-circle text-emerald-600"></i>
                    <span>Teks berhasil disalin ke clipboard!</span>
                </div>

                {{-- Status Overview Bar --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider block">Status Akhir</span>
                        <div class="mt-1">
                            <template x-if="selectedRespondentDetail?.is_finished == 1 || selectedRespondentDetail?.status === 'clear' || selectedRespondentDetail?.status === 'selesai'">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                    <i class="fas fa-check-circle mr-1 text-emerald-600"></i> Selesai
                                </span>
                            </template>
                            <template x-if="selectedRespondentDetail?.is_finished != 1 && selectedRespondentDetail?.status !== 'clear' && selectedRespondentDetail?.status !== 'selesai'">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700">
                                    <i class="fas fa-hourglass-half mr-1 text-amber-500"></i> Belum Selesai
                                </span>
                            </template>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider block">Status Email</span>
                        <div class="mt-1">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium"
                                  :class="selectedRespondentDetail?.status === 'done' ? 'bg-blue-50 text-blue-700' : (selectedRespondentDetail?.status === 'dones' ? 'bg-indigo-50 text-indigo-700' : 'bg-gray-100 text-gray-600')">
                                <span x-text="selectedRespondentDetail?.status ? selectedRespondentDetail.status.toUpperCase() : 'BELUM EMAIL'"></span>
                            </span>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100 col-span-2 sm:col-span-1">
                        <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider block">Kategori</span>
                        <div class="mt-1">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold"
                                  :class="selectedRespondentDetail?.category === 'academic' ? 'bg-indigo-50 text-indigo-700' : 'bg-amber-50 text-amber-700'">
                                <i class="fas mr-1 text-[10px]" :class="selectedRespondentDetail?.category === 'academic' ? 'fa-graduation-cap' : 'fa-briefcase'"></i>
                                <span x-text="selectedRespondentDetail?.category ? selectedRespondentDetail.category.toUpperCase() : '-'"></span>
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Detail Sections --}}
                <div class="space-y-3">
                    {{-- Section 1: Kontak & Identitas --}}
                    <div class="border border-gray-100 rounded-xl p-4 bg-white shadow-2xs space-y-2.5">
                        <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider flex items-center gap-1.5 text-teal-700">
                            <i class="fas fa-address-card"></i> Identitas & Kontak
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs pt-1">
                            <div>
                                <span class="text-gray-400 block text-[11px]">Nama Lengkap:</span>
                                <span class="font-semibold text-gray-900" x-text="selectedRespondentDetail?.fullname || '-'"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[11px]">Gelar:</span>
                                <span class="font-semibold text-gray-900" x-text="selectedRespondentDetail?.title || '-'"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[11px]">Email:</span>
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-gray-900 break-all" x-text="selectedRespondentDetail?.email || '-'"></span>
                                    <button type="button" 
                                            x-show="selectedRespondentDetail?.email"
                                            @click="copyText(selectedRespondentDetail?.email)"
                                            class="text-gray-400 hover:text-teal-600 transition cursor-pointer"
                                            title="Salin email">
                                        <i class="far fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[11px]">Nomor Telepon:</span>
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-gray-900" x-text="selectedRespondentDetail?.phone_responden || '-'"></span>
                                    <button type="button" 
                                            x-show="selectedRespondentDetail?.phone_responden"
                                            @click="copyText(selectedRespondentDetail?.phone_responden)"
                                            class="text-gray-400 hover:text-teal-600 transition cursor-pointer"
                                            title="Salin nomor telepon">
                                        <i class="far fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Instansi & Posisi --}}
                    <div class="border border-gray-100 rounded-xl p-4 bg-white shadow-2xs space-y-2.5">
                        <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider flex items-center gap-1.5 text-indigo-700">
                            <i class="fas fa-building"></i> Instansi & Jabatan
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs pt-1">
                            <div>
                                <span class="text-gray-400 block text-[11px]">Nama Instansi:</span>
                                <span class="font-semibold text-gray-900" x-text="selectedRespondentDetail?.instansi || '-'"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[11px]">Jabatan:</span>
                                <span class="font-semibold text-gray-900" x-text="selectedRespondentDetail?.jabatan || '-'"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[11px]">Fakultas / Unit Terkait:</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-slate-100 text-slate-700" 
                                      x-text="selectedRespondentDetail?.fakultas ? selectedRespondentDetail.fakultas.toUpperCase() : '-'"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[11px]">Waktu Input / Dibuat:</span>
                                <span class="text-gray-700 font-medium" 
                                      x-text="formatDate(selectedRespondentDetail?.created_at) + ' pukul ' + formatTime(selectedRespondentDetail?.created_at)"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Section 3: Data Penginput --}}
                    <div class="border border-gray-100 rounded-xl p-4 bg-white shadow-2xs space-y-2.5">
                        <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider flex items-center gap-1.5 text-amber-700">
                            <i class="fas fa-user-edit"></i> Akun Penginput
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs pt-1">
                            <div>
                                <span class="text-gray-400 block text-[11px]">Nama Akun Penginput:</span>
                                <span class="font-bold text-gray-900" x-text="selectedRespondentDetail?.inputer_name || '-'"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[11px]">Tipe Penginput:</span>
                                <template x-if="selectedRespondentDetail">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded border text-[11px] font-semibold"
                                          :class="inputerTypeMeta(selectedRespondentDetail.inputer_type).badge">
                                        <i class="fas text-[9px]" :class="inputerTypeMeta(selectedRespondentDetail.inputer_type).icon"></i>
                                        <span x-text="inputerTypeMeta(selectedRespondentDetail.inputer_type).short"></span>
                                    </span>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Modal Footer --}}
            <div class="p-4 border-t border-gray-100 bg-gray-50 flex items-center justify-end">
                <button type="button" 
                        @click="closeRespondentDetail()" 
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs font-semibold rounded-xl transition cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL: GRAFIK & STATISTIK KONTRIBUSI PROGRAM STUDI --}}
    <div x-show="prodiStatsModalOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-xs flex items-center justify-center p-4"
         x-cloak>
        <div @click.away="closeProdiStatsModal()" 
             class="bg-white rounded-2xl border border-gray-100 shadow-2xl max-w-4xl w-full max-h-[90vh] flex flex-col overflow-hidden">
            
            {{-- Modal Header --}}
            <div class="p-5 sm:p-6 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-blue-50/70 to-indigo-50/40">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center shrink-0 shadow-2xs">
                        <i class="fas fa-graduation-cap text-xl"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="text-lg font-bold text-gray-900">Statistik & Kontribusi Akun Program Studi</h3>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800" 
                                  x-text="prodiStats.count + ' Prodi Aktif'"></span>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Rincian angka input, penyelesaian form, serta grafik sebaran responden dari setiap akun prodi
                        </p>
                    </div>
                </div>
                <button type="button" @click="closeProdiStatsModal()" class="text-gray-400 hover:text-gray-600 transition cursor-pointer p-1">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-5 sm:p-6 space-y-6 overflow-y-auto flex-1">
                
                {{-- KPI Summary Cards --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="bg-gray-50/90 p-4 rounded-xl border border-gray-100">
                        <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider block">Total Input Prodi</span>
                        <p class="text-2xl font-bold text-gray-900 mt-1" x-text="prodiStats.total"></p>
                        <span class="text-[11px] text-gray-400 mt-0.5 block">Responden diinput</span>
                    </div>

                    <div class="bg-emerald-50/70 p-4 rounded-xl border border-emerald-100">
                        <span class="text-[11px] font-semibold text-emerald-700 uppercase tracking-wider block">Selesai (Form Clear)</span>
                        <p class="text-2xl font-bold text-emerald-700 mt-1" x-text="prodiStats.finished"></p>
                        <span class="text-[11px] text-emerald-600 mt-0.5 font-semibold block" x-text="prodiStats.rate + '% rasio selesai'"></span>
                    </div>

                    <div class="bg-blue-50/70 p-4 rounded-xl border border-blue-100">
                        <span class="text-[11px] font-semibold text-blue-700 uppercase tracking-wider block">Rata-rata / Prodi</span>
                        <p class="text-2xl font-bold text-blue-700 mt-1" x-text="prodiStats.avg"></p>
                        <span class="text-[11px] text-blue-600 mt-0.5 block" x-text="'Dari ' + prodiStats.count + ' akun prodi'"></span>
                    </div>

                    <div class="bg-indigo-50/70 p-4 rounded-xl border border-indigo-100">
                        <span class="text-[11px] font-semibold text-indigo-700 uppercase tracking-wider block">Top Kontributor</span>
                        <p class="text-sm font-bold text-indigo-900 mt-1.5 truncate" :title="prodiStats.topProdi?.name" x-text="prodiStats.topProdi?.name || '-'"></p>
                        <span class="text-[11px] text-indigo-600 mt-0.5 font-semibold block" x-text="(prodiStats.topProdi?.total || 0) + ' responden (' + (prodiStats.topProdi?.rate || 0) + '%)'"></span>
                    </div>
                </div>

                {{-- Chart Section --}}
                <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-2xs space-y-3">
                    <div class="flex items-center justify-between flex-wrap gap-2">
                        <div>
                            <h4 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-chart-bar text-blue-600"></i>
                                <span>Grafik Distribusi Kontribusi Responden per Program Studi</span>
                            </h4>
                            <p class="text-xs text-gray-400 mt-0.5">Klik pada salah satu batang grafik untuk langsung memfilter tabel responden utama.</p>
                        </div>
                        <div class="flex items-center gap-3 text-xs">
                            <span class="inline-flex items-center gap-1.5 text-emerald-700 font-medium">
                                <span class="w-3 h-3 rounded bg-emerald-500"></span> Selesai
                            </span>
                            <span class="inline-flex items-center gap-1.5 text-slate-500 font-medium">
                                <span class="w-3 h-3 rounded bg-slate-300"></span> Belum Selesai
                            </span>
                        </div>
                    </div>

                    {{-- Dynamic Chart Container --}}
                    <div class="relative w-full overflow-hidden pt-2" :style="'height: ' + Math.max(280, Math.min(500, (prodiGroup.inputers?.length || 0) * 24 + 60)) + 'px'">
                        <canvas id="prodiContributionChart"></canvas>
                    </div>
                </div>

                {{-- Full Ranking / Detail Table --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs overflow-hidden space-y-0">
                    <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-gray-50/50">
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">Daftar Peringkat & Angka Input Seluruh Prodi</h4>
                            <p class="text-xs text-gray-400 mt-0.5">Urutan kontribusi program studi dari yang terbanyak</p>
                        </div>
                        <div class="relative min-w-[220px]">
                            <input type="text" 
                                   x-model="prodiModalSearch" 
                                   placeholder="Cari program studi..."
                                   class="w-full pl-8 pr-3 py-1.5 text-xs bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-gray-700">
                            <i class="fas fa-search absolute left-2.5 top-2.5 text-gray-400 text-xs"></i>
                        </div>
                    </div>

                    <div class="max-h-72 overflow-y-auto">
                        <table class="w-full text-left text-xs text-gray-600">
                            <thead class="bg-gray-50 text-[11px] uppercase text-gray-500 font-semibold border-b border-gray-100 sticky top-0 z-10">
                                <tr>
                                    <th class="px-4 py-2.5 text-center w-12">#</th>
                                    <th class="px-4 py-2.5">Program Studi</th>
                                    <th class="px-4 py-2.5 text-center">Total Input</th>
                                    <th class="px-4 py-2.5 text-center">Selesai</th>
                                    <th class="px-4 py-2.5 w-40">Tingkat Selesai</th>
                                    <th class="px-4 py-2.5 text-right w-24">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <template x-for="(inp, idx) in filteredProdiModalList" :key="'prodi-rank-' + inp.id">
                                    <tr class="hover:bg-blue-50/30 transition-colors">
                                        <td class="px-4 py-2.5 text-center font-bold text-gray-400" x-text="idx + 1"></td>
                                        <td class="px-4 py-2.5 font-semibold text-gray-900" x-text="inp.name"></td>
                                        <td class="px-4 py-2.5 text-center font-bold text-blue-700 text-sm" x-text="inp.total"></td>
                                        <td class="px-4 py-2.5 text-center font-semibold text-emerald-600" x-text="inp.finished"></td>
                                        <td class="px-4 py-2.5">
                                            <div class="flex items-center gap-2">
                                                <div class="flex-1 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                                    <div class="bg-emerald-500 h-1.5 rounded-full transition-all" :style="'width: ' + Math.min(inp.rate, 100) + '%'"></div>
                                                </div>
                                                <span class="text-[11px] font-bold text-gray-700" x-text="inp.rate + '%'"></span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2.5 text-right">
                                            <button type="button" 
                                                    @click="filterByInputer(inp.id); closeProdiStatsModal();"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 border border-teal-200 transition cursor-pointer">
                                                <i class="fas fa-filter text-[9px]"></i>
                                                <span>Filter</span>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                                <tr x-show="filteredProdiModalList.length === 0">
                                    <td colspan="6" class="text-center py-8 text-gray-400">
                                        Tidak ada program studi yang cocok dengan pencarian.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            {{-- Modal Footer --}}
            <div class="p-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between text-xs text-gray-500">
                <span>Klik <strong>Filter</strong> pada prodi mana pun untuk langsung menampilkan datanya pada tabel utama.</span>
                <button type="button" 
                        @click="closeProdiStatsModal()" 
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs font-semibold rounded-xl transition cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>

</div>

<script>
function reportManager() {
    return {
        activeTab: 'sessions', // 'sessions' or 'legacy'
        
        // Session Tab State
        sessionFilter: 'all',
        loadingSession: false,
        sessionStats: {
            total_sessions: 0,
            total_respondents: 0,
            agreed_count: 0,
            pending_count: 0,
            not_emailed_count: 0,
            consent_rate: 0,
        },
        sessionList: [],
        pieChartInstance: null,
        barChartInstance: null,

        // Session Detail Modal
        detailModalOpen: false,
        selectedSessionDetail: null,

        // Legacy Tab State
        loadingLegacy: false,
        showInputerSidebar: true,
        legacyTableMode: 'compact', // 'compact' (fit without horizontal scroll) or 'full' (all 9 separated columns)
        selectedRespondentDetail: null,
        respondentDetailModalOpen: false,
        copiedToast: false,

        legacyFilters: {
            year: 'all',
            start_date: '',
            end_date: '',
            fakultas: 'all',
            category: 'all',
            status: 'all',
            search: '',
            inputer: 'all',
        },
        // Inputer (Penginput) breakdown
        isFakultasUser: @json(Auth::user()->isFakultas()),
        legacyBreakdown: [],
        expandedInputerGroups: {},
        breakdownScopeKey: null,
        prodiStatsModalOpen: false,
        prodiChartInstance: null,
        prodiSearchQuery: '',
        prodiModalSearch: '',
        legacyStats: {
            total: 0,
            finished: 0,
            pending: 0,
            rate: 0,
        },
        legacyItems: [],
        legacyPagination: {
            current_page: 1,
            last_page: 1,
            total: 0,
            from: 0,
            to: 0,
        },

        init() {
            this.loadSessionOverview();
        },

        switchTab(tab) {
            this.activeTab = tab;
            if (tab === 'legacy' && this.legacyItems.length === 0) {
                this.loadLegacyData(1);
            } else if (tab === 'sessions') {
                this.$nextTick(() => {
                    this.renderCharts();
                });
            }
        },

        // --- SESSION REPORT METHODS ---
        loadSessionOverview() {
            this.loadingSession = true;
            axios.get('{{ route("admin_pemeringkatan.reports.session-overview") }}', {
                params: { session_id: this.sessionFilter }
            })
            .then(res => {
                const data = res.data;
                this.sessionStats = data.stats;
                this.sessionList = data.sessions;
                this.$nextTick(() => {
                    setTimeout(() => {
                        this.renderPieChart(data.consent_chart);
                        this.renderBarChart(data.fakultas_chart);
                    }, 50);
                });
            })
            .catch(err => {
                console.error('Gagal memuat overview sesi:', err);
            })
            .finally(() => {
                this.loadingSession = false;
            });
        },

        renderPieChart(chartData) {
            const canvas = document.getElementById('consentPieChart');
            if (!canvas) return;

            // Safely destroy existing chart on this canvas
            const existingChart = Chart.getChart(canvas);
            if (existingChart) {
                existingChart.destroy();
            }
            this.pieChartInstance = null;

            if (!chartData || !chartData.datasets) return;

            const ctx = canvas.getContext('2d');
            if (!ctx) return;

            this.pieChartInstance = new Chart(ctx, {
                type: 'doughnut',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 16,
                                font: { size: 12, family: 'Inter, sans-serif' }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const val = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const pct = total > 0 ? Math.round((val / total) * 100) : 0;
                                    return ` ${context.label}: ${val} (${pct}%)`;
                                }
                            }
                        }
                    },
                    cutout: '68%'
                }
            });
        },

        renderBarChart(chartData) {
            const canvas = document.getElementById('fakultasBarChart');
            if (!canvas) return;

            // Safely destroy existing chart on this canvas
            const existingChart = Chart.getChart(canvas);
            if (existingChart) {
                existingChart.destroy();
            }
            this.barChartInstance = null;

            if (!chartData || !chartData.datasets) return;

            const ctx = canvas.getContext('2d');
            if (!ctx) return;

            this.barChartInstance = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true,
                            grid: { display: false },
                            ticks: {
                                font: { size: 11, family: 'Inter, sans-serif' },
                                maxRotation: 35,
                                minRotation: 0,
                            }
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            grid: { color: '#F3F4F6' },
                            ticks: { stepSize: 1, precision: 0 }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                boxWidth: 12,
                                font: { size: 12, family: 'Inter, sans-serif' }
                            }
                        }
                    }
                }
            });
        },

        renderCharts() {
            if (this.pieChartInstance && typeof this.pieChartInstance.resize === 'function') {
                this.pieChartInstance.resize();
            }
            if (this.barChartInstance && typeof this.barChartInstance.resize === 'function') {
                this.barChartInstance.resize();
            }
        },

        openSessionDetail(sessionId) {
            axios.get('{{ url("admin_pemeringkatan/reports/session-detail") }}/' + sessionId)
            .then(res => {
                this.selectedSessionDetail = res.data;
                this.detailModalOpen = true;
            })
            .catch(err => {
                console.error('Gagal memuat detail sesi:', err);
            });
        },

        // --- LEGACY REPORT METHODS ---
        loadLegacyData(page = 1) {
            this.loadingLegacy = true;
            axios.get('{{ route("admin_pemeringkatan.reports.legacy-data") }}', {
                params: {
                    page: page,
                    year: this.legacyFilters.year,
                    start_date: this.legacyFilters.start_date,
                    end_date: this.legacyFilters.end_date,
                    fakultas: this.legacyFilters.fakultas,
                    category: this.legacyFilters.category,
                    status: this.legacyFilters.status,
                    search: this.legacyFilters.search,
                    inputer: this.legacyFilters.inputer,
                }
            })
            .then(res => {
                const data = res.data;
                this.legacyStats = data.stats;
                this.legacyItems = data.data;
                this.legacyPagination = data.pagination;
                this.applyInputerBreakdown(data.inputer_breakdown || []);
            })
            .catch(err => {
                console.error('Gagal memuat data legacy:', err);
            })
            .finally(() => {
                this.loadingLegacy = false;
            });
        },

        resetLegacyFilters() {
            this.legacyFilters = {
                year: 'all',
                start_date: '',
                end_date: '',
                fakultas: 'all',
                category: 'all',
                status: 'all',
                search: '',
                inputer: 'all',
            };
            this.loadLegacyData(1);
        },

        getLegacyExportUrl() {
            const params = new URLSearchParams({
                year: this.legacyFilters.year,
                start_date: this.legacyFilters.start_date || '',
                end_date: this.legacyFilters.end_date || '',
                fakultas: this.legacyFilters.fakultas,
                category: this.legacyFilters.category,
                status: this.legacyFilters.status,
                search: this.legacyFilters.search,
                inputer: this.legacyFilters.inputer,
            });
            return '{{ route("admin_pemeringkatan.reports.export-legacy") }}?' + params.toString();
        },

        // --- INPUTER (PENGINPUT) METHODS ---
        applyInputerBreakdown(breakdown) {
            this.legacyBreakdown = breakdown;

            // Reset default expand state whenever the fakultas scope changes;
            // otherwise keep the user's manual toggles (paging, inputer clicks, etc.).
            const scopeKey = this.legacyFilters.fakultas;
            const scopeChanged = scopeKey !== this.breakdownScopeKey;
            this.breakdownScopeKey = scopeKey;
            const singleFaculty = scopeKey !== 'all' || this.isFakultasUser;

            const next = scopeChanged ? {} : { ...this.expandedInputerGroups };
            breakdown.forEach((group, idx) => {
                if (next[group.type] === undefined) {
                    next[group.type] = singleFaculty || idx === 0;
                }
            });
            this.expandedInputerGroups = next;
        },

        isInputerGroupOpen(type) {
            return !!this.expandedInputerGroups[type];
        },

        toggleInputerGroup(type) {
            this.expandedInputerGroups = { ...this.expandedInputerGroups, [type]: !this.expandedInputerGroups[type] };
        },

        allInputerGroupsOpen() {
            return this.legacyBreakdown.length > 0
                && this.legacyBreakdown.every(g => this.expandedInputerGroups[g.type]);
        },

        toggleAllInputerGroups() {
            const open = !this.allInputerGroupsOpen();
            const next = {};
            this.legacyBreakdown.forEach(g => { next[g.type] = open; });
            this.expandedInputerGroups = next;
        },

        get flattenedInputerOptions() {
            const list = [];
            (this.legacyBreakdown || []).forEach(group => {
                list.push({ id: '__header__' + group.type, label: '── ' + group.label + ' ──', disabled: true });
                group.inputers.forEach(inp => {
                    list.push({ id: inp.id, label: inp.name + ' (' + inp.total + ')', disabled: false });
                });
            });
            return list;
        },

        filterByInputer(id) {
            const val = String(id);
            this.legacyFilters.inputer = (this.legacyFilters.inputer === val) ? 'all' : val;
            this.loadLegacyData(1);
        },

        selectedInputerName() {
            for (const group of this.legacyBreakdown) {
                const found = group.inputers.find(i => i.id === this.legacyFilters.inputer);
                if (found) return found.name;
            }
            return this.legacyFilters.inputer === 'none' ? 'Tidak Diketahui' : '#' + this.legacyFilters.inputer;
        },

        inputerTypeMeta(type) {
            const map = {
                direktorat: {
                    short: 'Direktorat', icon: 'fa-shield-alt',
                    iconBg: 'bg-teal-100 text-teal-700', headerBg: 'bg-teal-50/60 hover:bg-teal-50',
                    border: 'border-teal-100', text: 'text-teal-700', bar: 'bg-teal-500',
                    badge: 'bg-teal-50 text-teal-700 border-teal-200',
                },
                fakultas: {
                    short: 'Fakultas', icon: 'fa-university',
                    iconBg: 'bg-indigo-100 text-indigo-700', headerBg: 'bg-indigo-50/60 hover:bg-indigo-50',
                    border: 'border-indigo-100', text: 'text-indigo-700', bar: 'bg-indigo-500',
                    badge: 'bg-indigo-50 text-indigo-700 border-indigo-200',
                },
                prodi: {
                    short: 'Prodi', icon: 'fa-graduation-cap',
                    iconBg: 'bg-blue-100 text-blue-700', headerBg: 'bg-blue-50/60 hover:bg-blue-50',
                    border: 'border-blue-100', text: 'text-blue-700', bar: 'bg-blue-500',
                    badge: 'bg-blue-50 text-blue-700 border-blue-200',
                },
                unknown: {
                    short: 'Tidak Diketahui', icon: 'fa-question-circle',
                    iconBg: 'bg-gray-200 text-gray-600', headerBg: 'bg-gray-50 hover:bg-gray-100',
                    border: 'border-gray-200', text: 'text-gray-600', bar: 'bg-gray-400',
                    badge: 'bg-gray-100 text-gray-600 border-gray-200',
                },
            };
            return map[type] || map.unknown;
        },

        get prodiGroup() {
            return (this.legacyBreakdown || []).find(g => g.type === 'prodi') || { inputers: [], total: 0, finished: 0, rate: 0 };
        },

        get prodiStats() {
            const group = this.prodiGroup;
            const inputers = group.inputers || [];
            const count = inputers.length;
            const total = group.total || 0;
            const finished = group.finished || 0;
            const avg = count > 0 ? (total / count).toFixed(1) : '0';
            const topProdi = inputers.length > 0 ? inputers[0] : null;
            return {
                count,
                total,
                finished,
                rate: group.rate || 0,
                avg,
                topProdi,
            };
        },

        get filteredProdiModalList() {
            const list = [...(this.prodiGroup.inputers || [])];
            list.sort((a, b) => b.total - a.total);
            if (!this.prodiModalSearch.trim()) {
                return list;
            }
            const q = this.prodiModalSearch.toLowerCase();
            return list.filter(i => i.name.toLowerCase().includes(q));
        },

        openProdiStatsModal() {
            this.prodiStatsModalOpen = true;
            this.$nextTick(() => {
                this.renderProdiChart();
            });
        },

        closeProdiStatsModal() {
            this.prodiStatsModalOpen = false;
        },

        renderProdiChart() {
            const canvas = document.getElementById('prodiContributionChart');
            if (!canvas) return;

            const inputers = [...(this.prodiGroup.inputers || [])];
            if (inputers.length === 0) return;

            inputers.sort((a, b) => b.total - a.total);

            const labels = inputers.map(i => {
                const name = i.name.replace(/^(FT|FEB|FIP|FBS|FMIPA|FIK|FISH|FPsi|Vokasi)-/, '');
                return name.length > 28 ? name.substring(0, 26) + '...' : name;
            });
            const finishedData = inputers.map(i => i.finished);
            const pendingData = inputers.map(i => Math.max(0, i.total - i.finished));

            if (this.prodiChartInstance) {
                this.prodiChartInstance.destroy();
            }

            const ctx = canvas.getContext('2d');
            this.prodiChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Selesai (Form Clear)',
                            data: finishedData,
                            backgroundColor: '#10B981',
                            borderRadius: 4,
                            barThickness: 14,
                        },
                        {
                            label: 'Belum Selesai',
                            data: pendingData,
                            backgroundColor: '#CBD5E1',
                            borderRadius: 4,
                            barThickness: 14,
                        }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true,
                            beginAtZero: true,
                            grid: { color: '#F1F5F9' },
                            ticks: { precision: 0 }
                        },
                        y: {
                            stacked: true,
                            grid: { display: false },
                            ticks: {
                                font: { size: 11, family: 'Inter, sans-serif' },
                                autoSkip: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                afterBody: (context) => {
                                    const idx = context[0].dataIndex;
                                    const item = inputers[idx];
                                    return `Total: ${item.total} responden (${item.rate}% selesai)`;
                                }
                            }
                        }
                    },
                    onClick: (event, elements) => {
                        if (elements.length > 0) {
                            const idx = elements[0].index;
                            const clickedItem = inputers[idx];
                            this.filterByInputer(clickedItem.id);
                            this.closeProdiStatsModal();
                        }
                    }
                }
            });
        },

        formatDate(dateStr) {
            if (!dateStr) return '-';
            const d = new Date(dateStr);
            if (isNaN(d.getTime())) return dateStr;
            return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
        },

        formatTime(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            if (isNaN(d.getTime())) return '';
            return d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        },

        openRespondentDetail(item) {
            this.selectedRespondentDetail = item;
            this.respondentDetailModalOpen = true;
        },

        closeRespondentDetail() {
            this.respondentDetailModalOpen = false;
            this.selectedRespondentDetail = null;
        },

        copyText(text) {
            if (!text) return;
            if (navigator && navigator.clipboard) {
                navigator.clipboard.writeText(text);
                this.copiedToast = true;
                setTimeout(() => { this.copiedToast = false; }, 2000);
            }
        }
    };
}
</script>
@endsection
