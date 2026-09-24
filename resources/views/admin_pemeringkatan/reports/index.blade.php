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
                                    <button @click="openSessionDetail(item.id)" 
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 rounded-lg transition-colors">
                                        <i class="fas fa-sitemap mr-1.5"></i>
                                        Breakdown Unit
                                    </button>
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
                    <span class="font-bold text-gray-800 text-sm">Filter Arsip Responden</span>
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

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                {{-- Year Filter --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Tahun Dibuat</label>
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
                    <select x-model="legacyFilters.fakultas" @change="loadLegacyData(1)"
                            class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500">
                        <option value="all">Semua Fakultas</option>
                        @foreach($legacyFaculties as $fak)
                            <option value="{{ strtolower($fak) }}">{{ $fak }}</option>
                        @endforeach
                    </select>
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

                {{-- Search Box --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Pencarian</label>
                    <div class="relative">
                        <input type="text" 
                               x-model="legacyFilters.search" 
                               @input.debounce.400ms="loadLegacyData(1)"
                               placeholder="Nama, email, instansi..."
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

        {{-- Legacy Data Table --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-gray-800">Daftar Arsip Responden</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Data responden dari tabel legacy dengan indikator status email dan status pengisian form (Status Akhir)</p>
                </div>
                <div x-show="loadingLegacy" class="text-teal-600 text-xs font-medium flex items-center gap-1.5">
                    <i class="fas fa-spinner fa-spin"></i> Memuat data...
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50/75 text-xs uppercase text-gray-500 font-semibold border-b border-gray-100">
                        <tr>
                            <th class="px-5 py-3.5">Responden</th>
                            <th class="px-5 py-3.5">Kontak</th>
                            <th class="px-5 py-3.5">Instansi & Jabatan</th>
                            <th class="px-4 py-3.5 text-center">Fakultas</th>
                            <th class="px-4 py-3.5 text-center">Kategori</th>
                            <th class="px-4 py-3.5 text-center">Status Email</th>
                            <th class="px-5 py-3.5 text-center">Status Akhir</th>
                            <th class="px-4 py-3.5 text-center">Tahun</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <template x-for="item in legacyItems" :key="item.id">
                            <tr class="hover:bg-gray-50/60 transition-colors">
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
                                <td class="px-4 py-3.5 text-center text-xs text-gray-500 font-medium" 
                                    x-text="item.created_at ? new Date(item.created_at).getFullYear() : '-'">
                                </td>
                            </tr>
                        </template>

                        <tr x-show="legacyItems.length === 0 && !loadingLegacy">
                            <td colspan="8" class="text-center py-10 text-gray-400">
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
                            class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed transition font-medium">
                        <i class="fas fa-chevron-left mr-1"></i> Prev
                    </button>
                    <span class="px-3 py-1.5 text-gray-700 font-bold">
                        Halaman <span x-text="legacyPagination.current_page"></span> dari <span x-text="legacyPagination.last_page || 1"></span>
                    </span>
                    <button @click="loadLegacyData(legacyPagination.current_page + 1)" 
                            :disabled="legacyPagination.current_page >= legacyPagination.last_page"
                            class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed transition font-medium">
                        Next <i class="fas fa-chevron-right ml-1"></i>
                    </button>
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
        legacyFilters: {
            year: 'all',
            fakultas: 'all',
            category: 'all',
            status: 'all',
            search: '',
        },
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
                    fakultas: this.legacyFilters.fakultas,
                    category: this.legacyFilters.category,
                    status: this.legacyFilters.status,
                    search: this.legacyFilters.search,
                }
            })
            .then(res => {
                const data = res.data;
                this.legacyStats = data.stats;
                this.legacyItems = data.data;
                this.legacyPagination = data.pagination;
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
                fakultas: 'all',
                category: 'all',
                status: 'all',
                search: '',
            };
            this.loadLegacyData(1);
        },

        getLegacyExportUrl() {
            const params = new URLSearchParams({
                year: this.legacyFilters.year,
                fakultas: this.legacyFilters.fakultas,
                category: this.legacyFilters.category,
                status: this.legacyFilters.status,
                search: this.legacyFilters.search,
            });
            return '{{ route("admin_pemeringkatan.reports.export-legacy") }}?' + params.toString();
        }
    };
}
</script>
@endsection
