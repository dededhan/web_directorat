@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8">
    <div class="max-w-[1920px] mx-auto font-sans">

        {{-- ================= HEADER ================= --}}
        <div class="mb-8 sm:mb-10">
            <div class="mb-4">
                @include('admin_pemeringkatan.international-lecture.partials.back-button', [
                    'backRoute' => 'admin_pemeringkatan.international-lecture.index',
                    'backParams' => request('from_table') ? ['table' => 1] : [],
                    'backLabel' => 'Kembali ke International Lecture',
                ])
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Laporan Email Dosen Asing</h1>
            <p class="text-gray-600 mt-1.5 text-sm sm:text-base">
                Pantau progres pengiriman email per fakultas, tren pengiriman harian, dan respons consent dosen asing.
            </p>
        </div>

        {{-- ================= PILIHAN FITUR (3 TOMBOL TERPISAH) ================= --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 mb-6">
            {{-- Tombol 1: Isi & Kirim Email (Link) --}}
            <a href="{{ route('admin_pemeringkatan.international-lecture.email.index', array_filter(['compose' => 1, 'from_table' => request('from_table')])) }}"
               class="group w-full text-left bg-white rounded-2xl border-2 border-gray-200 p-5 sm:p-6 shadow-sm transition-all duration-200 hover:border-blue-500 hover:bg-blue-50/30 hover:shadow-md focus:outline-none block">
                <div class="flex items-center gap-4 sm:gap-5">
                    <span class="flex h-14 w-14 sm:h-16 sm:w-16 shrink-0 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-md transition-transform duration-200 group-hover:scale-105">
                        <i class="fa-solid fa-paper-plane text-2xl"></i>
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block text-lg sm:text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                            Isi &amp; Kirim Email
                        </span>
                        <span class="block mt-1 text-sm sm:text-base text-gray-500">
                            Buat template, pilih dosen, dan kirim email
                        </span>
                    </span>
                    <i class="fa-solid fa-chevron-right text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all text-lg sm:text-xl"></i>
                </div>
            </a>

            {{-- Tombol 2: Rekap Email (Link) --}}
            <a href="{{ route('admin_pemeringkatan.international-lecture.email-recap.index', array_filter(['from_table' => request('from_table')])) }}"
               class="group w-full text-left bg-white rounded-2xl border-2 border-gray-200 p-5 sm:p-6 shadow-sm transition-all duration-200 hover:border-emerald-500 hover:bg-emerald-50/30 hover:shadow-md focus:outline-none block">
                <div class="flex items-center gap-4 sm:gap-5">
                    <span class="flex h-14 w-14 sm:h-16 sm:w-16 shrink-0 items-center justify-center rounded-2xl bg-emerald-600 text-white shadow-md transition-transform duration-200 group-hover:scale-105">
                        <i class="fa-solid fa-chart-column text-2xl"></i>
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block text-lg sm:text-xl font-bold text-gray-900 group-hover:text-emerald-700 transition-colors">
                            Rekap Email
                        </span>
                        <span class="block mt-1 text-sm sm:text-base text-gray-500">
                            Lihat riwayat, status, dan kontrol kirim ulang
                        </span>
                    </span>
                    <i class="fa-solid fa-chevron-right text-gray-400 group-hover:text-emerald-600 group-hover:translate-x-1 transition-all text-lg sm:text-xl"></i>
                </div>
            </a>

            {{-- Tombol 3: Laporan Email (Sedang Aktif) --}}
            <div class="w-full text-left bg-purple-50/80 rounded-2xl border-2 border-purple-600 ring-4 ring-purple-100 p-5 sm:p-6 shadow-md">
                <div class="flex items-center gap-4 sm:gap-5">
                    <span class="flex h-14 w-14 sm:h-16 sm:w-16 shrink-0 items-center justify-center rounded-2xl bg-purple-600 text-white shadow-md">
                        <i class="fa-solid fa-chart-pie text-2xl"></i>
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block text-lg sm:text-xl font-bold text-purple-950">
                            Laporan Email
                        </span>
                        <span class="block mt-1 text-sm sm:text-base text-purple-700">
                            Grafik progres, tren, dan respons email dosen asing
                        </span>
                    </span>
                    <i class="fa-solid fa-chevron-right text-purple-600 text-lg sm:text-xl"></i>
                </div>
            </div>
        </div>

        {{-- ================= FILTER LAPORAN ================= --}}
        <div class="bg-white p-5 sm:p-7 rounded-2xl shadow-sm border border-gray-200/80 mb-5 sm:mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 mb-4">
                <h3 class="text-base font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-filter text-purple-600"></i>
                    <span>Filter Laporan</span>
                </h3>
                <span class="text-xs text-gray-500">
                    Rentang tanggal berlaku untuk tren &amp; mode pengiriman (default 30 hari terakhir).
                </span>
            </div>
            <form method="GET" action="{{ route('admin_pemeringkatan.international-lecture.report.index') }}">
                @if(request('email_year'))
                    <input type="hidden" name="email_year" value="{{ request('email_year') }}">
                @endif
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3.5 items-end">
                    <div>
                        <label for="start_date" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Tanggal Mulai</label>
                        <input type="date" id="start_date" name="start_date" value="{{ $startDate->format('Y-m-d') }}"
                               class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:bg-white focus:outline-none">
                    </div>
                    <div>
                        <label for="end_date" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Tanggal Selesai</label>
                        <input type="date" id="end_date" name="end_date" value="{{ $endDate->format('Y-m-d') }}"
                               class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:bg-white focus:outline-none">
                    </div>
                    <div>
                        <label for="sesi_filter" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Sesi / Semester</label>
                        <input type="text" id="sesi_filter" name="sesi" value="{{ request('sesi') }}" placeholder="Contoh: 125"
                               class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:bg-white focus:outline-none">
                    </div>
                    <div>
                        <label for="faculty_filter" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Fakultas</label>
                        <select id="faculty_filter" name="fakultas"
                                class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:bg-white focus:outline-none font-medium">
                            <option value="semua">Semua Fakultas</option>
                            @foreach($faculties as $k => $label)
                                <option value="{{ $k }}" @selected(request('fakultas') === $k)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="email_status_filter" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Status Email</label>
                        <select id="email_status_filter" name="email_status"
                                class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:bg-white focus:outline-none font-medium">
                            <option value="">Semua Status</option>
                            <option value="sent" @selected(request('email_status') === 'sent')>Sudah Terkirim</option>
                            <option value="not_sent" @selected(request('email_status') === 'not_sent')>Belum Terkirim</option>
                            <option value="failed" @selected(request('email_status') === 'failed')>Gagal</option>
                            <option value="no_email" @selected(request('email_status') === 'no_email')>Tanpa Alamat Email</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="submit"
                                class="flex-1 py-2 px-3 text-sm font-semibold rounded-lg bg-purple-600 text-white hover:bg-purple-700 transition shadow-2xs flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            <span>Terapkan</span>
                        </button>
                        <a href="{{ route('admin_pemeringkatan.international-lecture.report.index') }}"
                           class="py-2 px-3 text-sm font-semibold rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition shadow-2xs flex items-center justify-center gap-1"
                           title="Reset filter">
                            <i class="fa-solid fa-rotate-left text-xs"></i>
                            <span>Reset</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- ================= KARTU METRIK RINGKASAN (KPI EMAIL) ================= --}}
        @php
            $pctOf = fn ($v, $t) => $t > 0 ? round(($v / $t) * 100, 1) : 0;
            $kpis = [
                ['label' => 'Total Dosen Asing', 'value' => $summary->total, 'note' => 'Sesuai filter aktif'],
                ['label' => 'Memiliki Alamat Email', 'value' => $summary->has_email, 'note' => $pctOf($summary->has_email, $summary->total) . '% dari total dosen'],
                ['label' => 'Tanpa Alamat Email', 'value' => $summary->no_email, 'note' => $summary->no_email > 0 ? 'Tidak bisa dikirimi email' : 'Semua dosen punya email'],
                ['label' => 'Email Terkirim', 'value' => $summary->sent, 'note' => $pctOf($summary->sent, $summary->total) . '% dari total dosen'],
                ['label' => 'Belum Terkirim', 'value' => $summary->not_sent + $summary->in_progress, 'note' => $summary->in_progress > 0 ? $summary->in_progress . ' dalam antrean' : 'Siap untuk dikirim'],
                ['label' => 'Gagal Terkirim', 'value' => $summary->failed, 'note' => $summary->failed > 0 ? 'Perlu dikirim ulang' : 'Tidak ada kegagalan'],
            ];
        @endphp
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-3.5 sm:gap-4 mb-12 sm:mb-16">
            @foreach($kpis as $kpi)
                <div class="bg-white p-4 rounded-xl border border-gray-200/80 shadow-2xs">
                    <div class="text-xs font-bold text-gray-800">{{ $kpi['label'] }}</div>
                    <div class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($kpi['value']) }}</div>
                    <div class="text-[11px] text-gray-400 mt-0.5">{{ $kpi['note'] }}</div>
                </div>
            @endforeach
        </div>

        <div class="space-y-12 sm:space-y-16">

            {{-- ================= 1. PROGRES PENGIRIMAN EMAIL PER FAKULTAS ================= --}}
            <div class="bg-white p-5 sm:p-7 rounded-2xl shadow-sm border border-gray-200/80">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-6">
                    <div>
                        <h3 class="text-base sm:text-lg font-bold text-gray-800">Status Pengiriman Email per Fakultas</h3>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Garis tebal menunjukkan email yang sudah terkirim, garis transparan di belakangnya adalah total dosen di fakultas tersebut.
                        </p>
                    </div>
                    <div class="flex items-center gap-4 text-xs font-semibold text-gray-600 shrink-0">
                        <span class="inline-flex items-center gap-1.5">
                            <span class="h-2.5 w-5 rounded-full bg-emerald-500"></span> Email Terkirim
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <span class="h-2.5 w-5 rounded-full bg-emerald-500/20"></span> Belum Terkirim
                        </span>
                    </div>
                </div>

                <div class="space-y-5 sm:space-y-6">
                    @forelse($activeFacultyRows as $row)
                        <div class="grid grid-cols-[88px_1fr] sm:grid-cols-[120px_1fr_150px] items-center gap-x-4 gap-y-1 {{ $row['total'] === 0 ? 'opacity-50' : '' }}">
                            <div class="text-sm font-bold text-gray-800 truncate" title="{{ $row['label'] }}">{{ $row['label'] }}</div>

                            <div class="relative h-3.5 w-full rounded-full bg-emerald-500/20 overflow-hidden"
                                 role="progressbar" aria-valuemin="0" aria-valuemax="{{ $row['total'] }}" aria-valuenow="{{ $row['sent'] }}"
                                 aria-label="Email terkirim {{ $row['label'] }}"
                                 title="{{ $row['label'] }}: {{ $row['sent'] }} terkirim, {{ $row['not_sent'] }} belum terkirim{{ $row['failed'] ? ', ' . $row['failed'] . ' gagal' : '' }}">
                                @if($row['sent'] > 0)
                                    <div class="h-full rounded-full bg-emerald-500"
                                         style="width: {{ max($row['pct'], 1.5) }}%"></div>
                                @endif
                            </div>

                            <div class="col-start-2 sm:col-start-auto flex items-baseline justify-between sm:justify-end gap-2 text-xs">
                                <span class="text-gray-600">
                                    <b class="text-gray-900 text-sm">{{ number_format($row['sent']) }}</b> / {{ number_format($row['total']) }}
                                    @if($row['failed'] > 0)
                                        <span class="ml-1 text-rose-600 font-semibold" title="Email gagal">· {{ $row['failed'] }} gagal</span>
                                    @endif
                                </span>
                                <span class="w-12 text-right font-bold {{ $row['pct'] > 0 ? 'text-emerald-600' : 'text-gray-400' }}">{{ rtrim(rtrim(number_format($row['pct'], 1), '0'), '.') }}%</span>
                            </div>
                        </div>
                    @empty
                        <p class="py-6 text-center text-sm text-gray-500">Tidak ada data fakultas yang sesuai dengan filter.</p>
                    @endforelse
                </div>

                @php
                    $overallPct = $summary->total > 0 ? round(($summary->sent / $summary->total) * 100, 1) : 0;
                @endphp
                <div class="mt-8 pt-6 border-t border-gray-100 grid grid-cols-[88px_1fr] sm:grid-cols-[120px_1fr_150px] items-center gap-x-4 gap-y-1">
                    <div class="text-sm font-extrabold text-gray-900">TOTAL</div>
                    <div class="relative h-4 w-full rounded-full bg-emerald-500/20 overflow-hidden">
                        @if($summary->sent > 0)
                            <div class="h-full rounded-full bg-emerald-600" style="width: {{ max($overallPct, 1.5) }}%"></div>
                        @endif
                    </div>
                    <div class="col-start-2 sm:col-start-auto flex items-baseline justify-between sm:justify-end gap-2 text-xs">
                        <span class="text-gray-600"><b class="text-gray-900 text-sm">{{ number_format($summary->sent) }}</b> / {{ number_format($summary->total) }}</span>
                        <span class="w-12 text-right font-extrabold text-emerald-700">{{ rtrim(rtrim(number_format($overallPct, 1), '0'), '.') }}%</span>
                    </div>
                </div>
            </div>

            {{-- ================= 2. REKAPAN PENGIRIMAN EMAIL PER TAHUN ================= --}}
            <div class="bg-white p-5 sm:p-7 rounded-2xl shadow-sm border border-gray-200/80">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-base sm:text-lg font-bold text-gray-800">
                            Rekapan Pengiriman Email per Tahun
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Distribusi dan total volume pengiriman email ke dosen asing dalam setahun (Januari – Desember).
                        </p>
                    </div>

                    {{-- Pemilih Tahun Email --}}
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-600">Pilih Tahun:</span>
                        <form method="GET" action="{{ route('admin_pemeringkatan.international-lecture.report.index') }}" class="flex items-center gap-1.5">
                            @if(request('start_date')) <input type="hidden" name="start_date" value="{{ request('start_date') }}"> @endif
                            @if(request('end_date')) <input type="hidden" name="end_date" value="{{ request('end_date') }}"> @endif
                            @if(request('sesi')) <input type="hidden" name="sesi" value="{{ request('sesi') }}"> @endif
                            @if(request('fakultas')) <input type="hidden" name="fakultas" value="{{ request('fakultas') }}"> @endif
                            @if(request('email_status')) <input type="hidden" name="email_status" value="{{ request('email_status') }}"> @endif

                            <select name="email_year" onchange="this.form.submit()"
                                    class="px-3 py-1.5 text-xs font-bold bg-gray-50 border border-gray-300 rounded-lg text-gray-800 focus:ring-2 focus:ring-purple-500 focus:bg-white focus:outline-none">
                                @foreach($yearlyEmailRecap['availableYears'] as $yr)
                                    <option value="{{ $yr }}" @selected($yr === $yearlyEmailRecap['selectedYear'])>Tahun {{ $yr }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>

                {{-- 4 Kotak Ringkasan Tahunan Email --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 my-5">
                    <div class="rounded-xl bg-gray-50/80 border border-gray-200/80 p-3.5">
                        <div class="text-xs font-semibold text-gray-500">Total Email Diproses</div>
                        <div class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($yearlyEmailRecap['summary']->total) }}</div>
                        <div class="text-[11px] text-gray-400 mt-0.5">Tahun {{ $yearlyEmailRecap['selectedYear'] }}</div>
                    </div>
                    <div class="rounded-xl bg-emerald-50/60 border border-emerald-200/80 p-3.5">
                        <div class="text-xs font-semibold text-emerald-700">Berhasil Terkirim</div>
                        <div class="text-2xl font-bold text-emerald-800 mt-1">{{ number_format($yearlyEmailRecap['summary']->sent) }}</div>
                        <div class="text-[11px] text-emerald-600 mt-0.5">{{ $yearlyEmailRecap['summary']->success_rate }}% tingkat keberhasilan</div>
                    </div>
                    <div class="rounded-xl bg-rose-50/60 border border-rose-200/80 p-3.5">
                        <div class="text-xs font-semibold text-rose-700">Gagal Terkirim</div>
                        <div class="text-2xl font-bold text-rose-800 mt-1">{{ number_format($yearlyEmailRecap['summary']->failed) }}</div>
                        <div class="text-[11px] text-rose-500 mt-0.5">{{ $yearlyEmailRecap['summary']->failed > 0 ? 'Perlu kirim ulang' : 'Tidak ada kegagalan' }}</div>
                    </div>
                    <div class="rounded-xl bg-purple-50/60 border border-purple-200/80 p-3.5">
                        <div class="text-xs font-semibold text-purple-700">Bulan Puncak Pengiriman</div>
                        <div class="text-base font-bold text-purple-900 mt-1 truncate" title="{{ $yearlyEmailRecap['peakMonth'] }}">
                            {{ $yearlyEmailRecap['peakMonth'] }}
                        </div>
                        <div class="text-[11px] text-purple-600 mt-0.5">Aktivitas pengiriman tertinggi</div>
                    </div>
                </div>

                {{-- Diagram Batang Bulanan (Jan - Des) --}}
                <div class="mt-4">
                    <div class="h-64 sm:h-72 w-full">
                        <canvas id="yearlyEmailBarChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- ================= 3. TREN PENGIRIMAN EMAIL HARIAN ================= --}}
            <div class="bg-white p-5 sm:p-7 rounded-2xl shadow-sm border border-gray-200/80">
                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-3 mb-5">
                    <div>
                        <h3 class="text-base sm:text-lg font-bold text-gray-800">Tren Pengiriman Email Harian</h3>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Jumlah email yang diproses per hari, {{ $startDate->translatedFormat('d M Y') }} – {{ $endDate->translatedFormat('d M Y') }}
                        </p>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                        <div class="rounded-lg bg-gray-50 border border-gray-200 px-3 py-1.5">
                            <div class="text-gray-500">Total Diproses</div>
                            <div class="font-bold text-gray-900 text-sm">{{ number_format($logSummary->total) }}</div>
                        </div>
                        <div class="rounded-lg bg-emerald-50 border border-emerald-200 px-3 py-1.5">
                            <div class="text-emerald-700">Terkirim</div>
                            <div class="font-bold text-emerald-800 text-sm">{{ number_format($logSummary->sent) }}</div>
                        </div>
                        <div class="rounded-lg bg-rose-50 border border-rose-200 px-3 py-1.5">
                            <div class="text-rose-700">Gagal</div>
                            <div class="font-bold text-rose-800 text-sm">{{ number_format($logSummary->failed) }}</div>
                        </div>
                        <div class="rounded-lg bg-purple-50 border border-purple-200 px-3 py-1.5">
                            <div class="text-purple-700">Hari Tersibuk</div>
                            <div class="font-bold text-purple-800 text-sm">{{ $busiestDay ? $busiestDay['label'] . ' (' . $busiestDay['total'] . ')' : '-' }}</div>
                        </div>
                    </div>
                </div>
                <div class="h-72 w-full">
                    <canvas id="emailTrendChart"></canvas>
                </div>
            </div>

            {{-- ================= 3. TIGA DIAGRAM DONAT ================= --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 lg:gap-10">
                <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200/80">
                    <h3 class="text-base font-bold text-gray-800 mb-1">Persentase Status Email</h3>
                    <p class="text-xs text-gray-500 mb-4">Status email terakhir setiap dosen asing</p>
                    <div class="h-64 w-full"><canvas id="emailStatusDoughnutChart"></canvas></div>
                </div>

                <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200/80">
                    <h3 class="text-base font-bold text-gray-800 mb-1">Mode Pengiriman</h3>
                    <p class="text-xs text-gray-500 mb-4">Template vs tulis manual dalam rentang tanggal</p>
                    <div class="h-64 w-full"><canvas id="emailModeChart"></canvas></div>
                </div>

                <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200/80 flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between gap-3 mb-1">
                            <div>
                                <h3 class="text-base font-bold text-gray-800">Respons Consent</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Tanggapan dosen yang sudah menerima email</p>
                            </div>
                            <a href="{{ route('admin_pemeringkatan.international-lecture.report.consent-detail', array_filter(['fakultas' => request('fakultas'), 'sesi' => request('sesi')])) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-purple-50 text-purple-700 hover:bg-purple-100 hover:text-purple-800 border border-purple-200 transition-all duration-150 shadow-2xs shrink-0"
                               title="Buka rincian nama dosen dan status respons consent">
                                <i class="fa-solid fa-list-check text-xs"></i>
                                <span>Lihat Rincian Dosen</span>
                                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </a>
                        </div>
                        <div class="h-64 w-full mt-3"><canvas id="consentChart"></canvas></div>
                    </div>
                </div>
            </div>

            {{-- ================= 4. TABEL RINCIAN EMAIL PER FAKULTAS ================= --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden">
                <div class="px-5 sm:px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-base font-bold text-gray-800">Tabel Rincian Email per Fakultas</h3>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-gray-100 text-gray-700 border border-gray-200">
                        {{ count($activeFacultyRows) }} Fakultas
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs sm:text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 border-b border-gray-200 uppercase text-[11px] tracking-wider font-semibold">
                                <th class="py-3 px-4">No</th>
                                <th class="py-3 px-4">Fakultas</th>
                                <th class="py-3 px-4 text-center">Total Dosen</th>
                                <th class="py-3 px-4 text-center">Punya Email</th>
                                <th class="py-3 px-4 text-center">Terkirim</th>
                                <th class="py-3 px-4 text-center">Belum Terkirim</th>
                                <th class="py-3 px-4 text-center">Gagal</th>
                                <th class="py-3 px-4 text-center">Tanpa Email</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @php $no = 1; @endphp
                            @forelse($activeFacultyRows as $row)
                                <tr class="hover:bg-gray-50/80 transition-colors">
                                    <td class="py-3 px-4 text-gray-400 font-medium">{{ $no++ }}</td>
                                    <td class="py-3 px-4 font-bold text-gray-900">{{ $row['label'] }}</td>
                                    <td class="py-3 px-4 text-center font-bold text-gray-800">{{ number_format($row['total']) }}</td>
                                    <td class="py-3 px-4 text-center">{{ number_format($row['has_email']) }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded font-semibold text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            {{ number_format($row['sent']) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center text-gray-600 font-medium">{{ number_format($row['not_sent']) }}</td>
                                    <td class="py-3 px-4 text-center">
                                        @if($row['failed'] > 0)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded font-semibold text-xs bg-rose-50 text-rose-700 border border-rose-200">{{ number_format($row['failed']) }}</span>
                                        @else
                                            <span class="text-gray-400">0</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        @if($row['no_email'] > 0)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded font-semibold text-xs bg-slate-100 text-slate-700 border border-slate-200">{{ number_format($row['no_email']) }}</span>
                                        @else
                                            <span class="text-gray-400">0</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <a href="{{ route('admin_pemeringkatan.international-lecture.email.index', ['compose' => 1, 'category' => 'fakultas', 'fakultas' => $row['key']]) }}"
                                           class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold text-purple-700 bg-purple-50 hover:bg-purple-100 rounded-lg border border-purple-200 transition">
                                            <span>Kirim Email</span>
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="py-8 text-center text-gray-500">
                                        Tidak ada data dosen asing yang sesuai dengan filter.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ================= SCRIPTS CHART.JS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    Chart.register(ChartDataLabels);

    const configData = @json($chartData);

    const legendOpts = {
        display: true,
        position: 'bottom',
        labels: { boxWidth: 12, boxHeight: 12, usePointStyle: true, pointStyle: 'circle', font: { weight: 'bold', size: 12 } }
    };

    const doughnutLabel = (value, ctx) => {
        const sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
        if (sum === 0 || value === 0) return '';
        return ((value * 100) / sum).toFixed(0) + '%';
    };

    // Teks di tengah donat saat data kosong / total
    const centerTextPlugin = {
        id: 'centerText',
        afterDraw(chart) {
            const ds = chart.data.datasets[0];
            if (!ds) return;
            const sum = ds.data.reduce((a, b) => a + b, 0);
            const { ctx, chartArea } = chart;
            if (!chartArea) return;
            const x = (chartArea.left + chartArea.right) / 2;
            const y = (chartArea.top + chartArea.bottom) / 2;
            ctx.save();
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillStyle = sum === 0 ? '#9CA3AF' : '#111827';
            ctx.font = 'bold 20px sans-serif';
            ctx.fillText(sum === 0 ? 'Belum ada data' : sum.toLocaleString('id-ID'), x, sum === 0 ? y : y - 8);
            if (sum > 0) {
                ctx.font = '11px sans-serif';
                ctx.fillStyle = '#6B7280';
                ctx.fillText('total', x, y + 12);
            }
            ctx.restore();
        }
    };

    const makeDoughnut = (id, dist, colors) => {
        const el = document.getElementById(id);
        if (!el) return;
        const empty = dist.data.reduce((a, b) => a + b, 0) === 0;
        new Chart(el.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: dist.labels,
                datasets: [{
                    data: empty ? dist.data.map(() => 0) : dist.data,
                    backgroundColor: colors,
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '62%',
                plugins: {
                    legend: legendOpts,
                    datalabels: { color: '#ffffff', font: { weight: 'bold', size: 11 }, formatter: doughnutLabel },
                    tooltip: {
                        callbacks: {
                            label: (c) => {
                                const sum = c.dataset.data.reduce((a, b) => a + b, 0);
                                const pct = sum ? ((c.parsed * 100) / sum).toFixed(1) : 0;
                                return ` ${c.label}: ${c.parsed} (${pct}%)`;
                            }
                        }
                    }
                }
            },
            plugins: [centerTextPlugin]
        });
    };

    // ================= 1. REKAPAN EMAIL PER TAHUN (BAR CHART JAN - DES) =================
    const yearlyEmailEl = document.getElementById('yearlyEmailBarChart');
    if (yearlyEmailEl) {
        const ye = configData.yearlyEmail;
        new Chart(yearlyEmailEl.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ye.labels,
                datasets: [
                    {
                        label: 'Email Terkirim',
                        data: ye.sent,
                        backgroundColor: '#10B981',
                        borderRadius: 4,
                        maxBarThickness: 32,
                        order: 1
                    },
                    {
                        label: 'Gagal',
                        data: ye.failed,
                        backgroundColor: '#EF4444',
                        borderRadius: 4,
                        maxBarThickness: 32,
                        order: 2
                    },
                    {
                        type: 'line',
                        label: 'Total Email Diproses',
                        data: ye.total,
                        borderColor: '#7C3AED',
                        backgroundColor: 'rgba(124,58,237,.08)',
                        borderWidth: 2,
                        tension: 0.35,
                        fill: false,
                        pointRadius: 3,
                        pointHoverRadius: 6,
                        order: 0,
                        datalabels: { display: false }
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                layout: { padding: { top: 20 } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 11, weight: '600' } } },
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#F3F4F6' } }
                },
                plugins: {
                    legend: { ...legendOpts, position: 'top' },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: '#065F46',
                        font: { weight: 'bold', size: 10 },
                        formatter: v => v > 0 ? v : ''
                    }
                }
            }
        });
    }

    // ================= 2. TREN HARIAN (STACKED BAR + GARIS) =================
    const trendEl = document.getElementById('emailTrendChart');
    if (trendEl) {
        const t = configData.trend;
        const total = t.labels.map((_, i) => (t.sent[i] || 0) + (t.failed[i] || 0) + (t.pending[i] || 0));
        new Chart(trendEl.getContext('2d'), {
            type: 'bar',
            data: {
                labels: t.labels,
                datasets: [
                    { type: 'line', label: 'Total Diproses', data: total, borderColor: '#7C3AED', backgroundColor: 'rgba(124,58,237,.08)', borderWidth: 2, tension: .35, fill: true, pointRadius: 2, pointHoverRadius: 5, order: 0, datalabels: { display: false } },
                    { label: 'Terkirim', data: t.sent, backgroundColor: '#10B981', borderRadius: 3, stack: 's', order: 1 },
                    { label: 'Dalam Proses', data: t.pending, backgroundColor: '#F59E0B', borderRadius: 3, stack: 's', order: 1 },
                    { label: 'Gagal', data: t.failed, backgroundColor: '#EF4444', borderRadius: 3, stack: 's', order: 1 },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                scales: {
                    x: { stacked: true, grid: { display: false }, ticks: { maxRotation: 0, autoSkip: true, maxTicksLimit: 15, font: { size: 11 } } },
                    y: { stacked: true, beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#F3F4F6' } }
                },
                plugins: {
                    legend: { ...legendOpts, position: 'top' },
                    datalabels: { display: false }
                }
            }
        });
    }

    // ================= 2-4. DONAT =================
    makeDoughnut('emailStatusDoughnutChart', configData.statusDistribution, ['#10B981', '#94A3B8', '#F59E0B', '#EF4444']);
    makeDoughnut('emailModeChart', configData.modeDistribution, ['#2563EB', '#7C3AED']);
    makeDoughnut('consentChart', configData.consentDistribution, ['#10B981', '#EF4444', '#CBD5E1']);
});
</script>
@endsection
