@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8">
    <div class="max-w-[1920px] mx-auto font-sans space-y-12 sm:space-y-16">

        {{-- ================= HEADER & TOTAL DOSEN ASING ================= --}}
        <div>
            <div class="mb-4">
                @include('admin_pemeringkatan.international-lecture.partials.back-button', [
                    'backRoute' => 'admin_pemeringkatan.international-lecture.index',
                    'backParams' => ['table' => 1],
                    'backLabel' => 'Kembali ke International Lecture',
                ])
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Rekapan Data Dosen Asing</h1>
                    <p class="text-gray-500 mt-1.5 text-xs sm:text-sm">
                        Ringkasan statistik dosen asing, komposisi gender, jabatan, subject, fakultas, serta rekapan waktu input data per tahun.
                    </p>
                </div>
                <div class="bg-white px-5 py-3.5 rounded-xl border border-gray-200/80 shadow-2xs shrink-0 sm:min-w-[180px]">
                    <div class="text-xs font-bold text-gray-800">Total Dosen Asing</div>
                    <div class="text-2xl font-bold text-gray-900 mt-0.5">{{ number_format($summary['total']) }}</div>
                </div>
            </div>

            {{-- ================= FILTER BAR ================= --}}
            <div class="mt-5 bg-white rounded-xl border border-gray-200/80 shadow-2xs p-3.5 sm:p-4">
                <form method="GET" action="{{ route('admin_pemeringkatan.international-lecture.recap.index') }}"
                      class="flex flex-wrap items-center justify-between gap-3">
                    @if(request()->filled('year'))
                        <input type="hidden" name="year" value="{{ $yearlyRecap['selectedYear'] }}">
                    @endif

                    <div class="flex flex-wrap items-center gap-2.5">
                        <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">FILTER:</span>

                        <span class="hidden sm:inline-block h-5 w-px bg-gray-200"></span>

                        {{-- Opsi Keseluruhan (tampilkan semua data) --}}
                        <a href="{{ route('admin_pemeringkatan.international-lecture.recap.index', request()->filled('year') ? ['year' => $yearlyRecap['selectedYear']] : []) }}"
                           class="px-3 py-1.5 rounded-lg text-xs font-semibold border transition {{ !$filters['hasActive'] ? 'bg-blue-600 text-white border-blue-600 shadow-2xs' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100' }}">
                            Keseluruhan
                        </a>

                        <span class="hidden sm:inline-block h-5 w-px bg-gray-200"></span>

                        {{-- Filter Semester (Sesi) --}}
                        <div class="flex items-center gap-1.5">
                            <label for="filter_sesi" class="text-xs font-semibold text-gray-600">Semester:</label>
                            <select id="filter_sesi" name="sesi" onchange="this.form.submit()"
                                    class="px-2.5 py-1.5 text-xs font-medium bg-gray-50 border border-gray-200 rounded-lg text-gray-800 focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none">
                                <option value="">Semua Semester</option>
                                @foreach($filters['semesters'] as $sem)
                                    <option value="{{ $sem }}" @selected((string) $filters['sesi'] === (string) $sem)>Semester {{ $sem }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter Waktu Kedatangan Dosen ke UNJ (Tahun & Bulan) --}}
                        <div class="flex flex-wrap items-center gap-1.5">
                            <label for="filter_visit_year" class="text-xs font-semibold text-gray-600">Waktu Datang ke UNJ:</label>
                            <select id="filter_visit_year" name="visit_year" onchange="this.form.submit()"
                                    class="px-2.5 py-1.5 text-xs font-medium bg-gray-50 border border-gray-200 rounded-lg text-gray-800 focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none">
                                <option value="">Semua Tahun</option>
                                @foreach($filters['visitYears'] as $vy)
                                    <option value="{{ $vy }}" @selected((int) $filters['visit_year'] === (int) $vy)>{{ $vy }}</option>
                                @endforeach
                            </select>
                            <select id="filter_visit_month" name="visit_month" onchange="this.form.submit()"
                                    class="px-2.5 py-1.5 text-xs font-medium bg-gray-50 border border-gray-200 rounded-lg text-gray-800 focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none">
                                <option value="">Semua Bulan</option>
                                @foreach($filters['months'] as $mNum => $mName)
                                    <option value="{{ $mNum }}" @selected((int) $filters['visit_month'] === (int) $mNum)>{{ $mName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if($filters['hasActive'])
                        <div class="flex items-center gap-2.5 text-xs text-gray-500">
                            <span>Menampilkan <strong class="text-gray-800">{{ number_format($summary['total']) }}</strong> dosen</span>
                            <a href="{{ route('admin_pemeringkatan.international-lecture.recap.index', request()->filled('year') ? ['year' => $yearlyRecap['selectedYear']] : []) }}"
                               class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">
                                Reset
                            </a>
                        </div>
                    @endif
                </form>

                @if($filters['hasActive'] && $summary['total'] === 0)
                    <div class="mt-3 pt-2.5 border-t border-gray-100 text-xs text-amber-700">
                        Belum ada data dosen yang sesuai dengan filter yang dipilih.
                    </div>
                @endif
            </div>
        </div>

        {{-- ================= GENDER & JABATAN ================= --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

            {{-- Gender --}}
            <section class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 sm:p-6">
                <h2 class="text-base font-bold text-gray-800">
                    Komposisi Gender
                </h2>
                <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
                    <div class="relative h-64">
                        <canvas id="genderChart"></canvas>
                    </div>
                    <ul class="space-y-3">
                        @foreach($genderRows as $i => $row)
                            <li class="flex items-center justify-between gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100">
                                <span class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                    <span class="h-3 w-3 rounded-full" style="background: {{ ['#3B82F6', '#EC4899', '#9CA3AF'][$i] ?? '#9CA3AF' }}"></span>
                                    {{ $row['label'] }}
                                </span>
                                <span class="text-sm text-gray-900">
                                    <span class="font-bold">{{ $row['count'] }}</span>
                                    <span class="text-gray-500">({{ $row['percent'] }}%)</span>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>

            {{-- Jabatan --}}
            <section class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 sm:p-6">
                <h2 class="text-base font-bold text-gray-800">
                    Persentase Jabatan
                </h2>
                <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-6 items-start">
                    <div class="relative h-64">
                        <canvas id="positionChart"></canvas>
                    </div>
                    <div class="max-h-64 overflow-y-auto rounded-xl border border-gray-100">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-50 sticky top-0">
                                <tr>
                                    <th class="px-3 py-2 text-left text-[11px] font-bold text-gray-500 uppercase">Jabatan</th>
                                    <th class="px-3 py-2 text-right text-[11px] font-bold text-gray-500 uppercase">Jumlah</th>
                                    <th class="px-3 py-2 text-right text-[11px] font-bold text-gray-500 uppercase">%</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($positionRows as $row)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-2 text-gray-700">{{ $row['label'] }}</td>
                                        <td class="px-3 py-2 text-right font-semibold text-gray-900">{{ $row['count'] }}</td>
                                        <td class="px-3 py-2 text-right text-gray-500">{{ $row['percent'] }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>

        {{-- ================= REKAP NEGARA ASAL DOSEN ================= --}}
        <section class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <h2 class="text-base font-bold text-gray-800">
                        Rekap Negara Asal Dosen Asing
                    </h2>
                </div>
                <span class="text-xs font-semibold text-sky-700 bg-sky-50 border border-sky-200 px-2.5 py-1 rounded-full w-fit">
                    {{ $totalCountries ?? count($countryRows) }} negara
                </span>
            </div>
            <div class="mt-5 max-h-[560px] overflow-y-auto pr-1">
                <div class="relative" style="height: {{ max(260, count($countryRows) * 26) }}px">
                    <canvas id="countryChart"></canvas>
                </div>
            </div>
        </section>

        {{-- ================= SUBJECT ================= --}}
        <section class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <h2 class="text-base font-bold text-gray-800">
                        Jumlah Dosen per Subject
                    </h2>
                </div>
                <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-full w-fit">
                    {{ count($subjectRows) }} subject
                </span>
            </div>
            <div class="mt-5 max-h-[560px] overflow-y-auto pr-1">
                <div class="relative" style="height: {{ max(240, count($subjectRows) * 26) }}px">
                    <canvas id="subjectChart"></canvas>
                </div>
            </div>
        </section>

        {{-- ================= FAKULTAS ================= --}}
        <section class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <h2 class="text-base font-bold text-gray-800">
                        Sebaran Dosen per Fakultas
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Tiap warna menunjukkan komposisi subject dosen di masing-masing fakultas. Arahkan kursor ke warna atau klik keterangan di bawah untuk menyaring.
                    </p>
                </div>
                <span class="text-xs font-semibold text-violet-700 bg-violet-50 border border-violet-200 px-2.5 py-1 rounded-full w-fit">
                    {{ count($chartData['faculties']['datasets'] ?? []) }} subject
                </span>
            </div>
            <div class="mt-5 relative h-80 sm:h-96">
                <canvas id="facultyChart"></canvas>
            </div>
            <div id="facultySubjectLegendWrapper" class="mt-5 pt-4 border-t border-gray-100">
                <button type="button" id="toggleFacultySubjectLegend" aria-expanded="false"
                        class="w-full flex items-center justify-between gap-2 px-3.5 py-2.5 rounded-xl border border-gray-200 bg-gray-50 hover:bg-gray-100 text-left transition cursor-pointer">
                    <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Keterangan Warna Subject ({{ count($chartData['faculties']['datasets'] ?? []) }})
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-600">
                        <span id="toggleFacultySubjectLegendText">Lihat Keterangan</span>
                        <svg id="toggleFacultySubjectLegendIcon" class="w-4 h-4 text-gray-500 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </button>

                <div id="facultySubjectLegendPanel" class="hidden mt-3 pt-3 border-t border-gray-100">
                    <div class="flex flex-wrap items-center justify-end gap-2 mb-3">
                        <button type="button" id="unselectFacultySubjectLegend"
                                class="px-2.5 py-1 text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-200 rounded-lg transition cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed whitespace-nowrap">
                            Unselect All
                        </button>
                        <input type="text" id="facultySubjectSearch" placeholder="Cari subject..."
                               class="px-2.5 py-1 text-xs border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-violet-400 w-44 sm:w-56">
                        <button type="button" id="resetFacultySubjectLegend" class="hidden text-xs font-semibold text-blue-600 hover:text-blue-800 hover:underline whitespace-nowrap">
                            Tampilkan Semua
                        </button>
                    </div>
                    <div id="facultySubjectLegend" class="flex flex-wrap gap-2 max-h-56 overflow-y-auto pr-1"></div>
                </div>
            </div>
        </section>

        {{-- ================= SEMESTER / SESI DOSEN DATANG ================= --}}
        <section class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 sm:p-6">
            <div>
                <h2 class="text-base font-bold text-gray-800">
                    Sebaran Dosen per Semester / Sesi
                </h2>
                @if(($withoutSesiCount ?? 0) > 0)
                    <p class="text-xs text-gray-500 mt-0.5">
                        {{ number_format($withoutSesiCount) }} dosen belum memiliki keterangan semester/sesi.
                    </p>
                @endif
            </div>
            <div class="mt-5 relative h-72 sm:h-80">
                <canvas id="visitSemesterChart"></canvas>
            </div>
        </section>

        {{-- ================= REKAPAN WAKTU INPUT DATA DOSEN PER TAHUN DAN PER SEMESTER ================= --}}
        <section class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 sm:p-7">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-5 border-b border-gray-100">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">
                        Rekapan Waktu Input Data Dosen per Tahun/Semester
                    </h2>
                </div>

                {{-- Pemilih Tahun --}}
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-gray-600">Pilih Tahun:</span>
                    <form method="GET" action="{{ route('admin_pemeringkatan.international-lecture.recap.index') }}" class="flex items-center gap-1.5">
                        @if($filters['sesi'] !== '')
                            <input type="hidden" name="sesi" value="{{ $filters['sesi'] }}">
                        @endif
                        @if($filters['visit_year'] !== null)
                            <input type="hidden" name="visit_year" value="{{ $filters['visit_year'] }}">
                        @endif
                        @if($filters['visit_month'] !== null)
                            <input type="hidden" name="visit_month" value="{{ $filters['visit_month'] }}">
                        @endif
                        <select name="year" onchange="this.form.submit()"
                                class="px-3 py-1.5 text-xs font-bold bg-gray-50 border border-gray-300 rounded-lg text-gray-800 focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none">
                            @foreach($yearlyRecap['availableYears'] as $yr)
                                <option value="{{ $yr }}" @selected($yr === $yearlyRecap['selectedYear'])>Tahun {{ $yr }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            {{-- 3 Kotak Ringkasan Tahunan --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 sm:gap-4 my-6">
                <div class="bg-gray-50/80 rounded-xl border border-gray-200/70 p-4">
                    <div class="text-xs font-bold text-gray-600">Total Diinput Tahun {{ $yearlyRecap['selectedYear'] }}</div>
                    <div class="text-2xl font-extrabold text-blue-600 mt-1">{{ number_format($yearlyRecap['totalYear']) }}</div>
                    <div class="text-[11px] text-gray-500 mt-0.5">{{ $yearlyRecap['percentOfTotal'] }}% dari total {{ number_format($summary['total']) }} di database</div>
                </div>

                <div class="bg-gray-50/80 rounded-xl border border-gray-200/70 p-4">
                    <div class="text-xs font-bold text-gray-600">Bulan Puncak Input</div>
                    <div class="text-lg font-bold text-emerald-700 mt-1 truncate" title="{{ $yearlyRecap['peakMonth'] }}">
                        {{ $yearlyRecap['peakMonth'] }}
                    </div>
                    <div class="text-[11px] text-gray-500 mt-0.5">Volume input data tertinggi</div>
                </div>

                <div class="bg-gray-50/80 rounded-xl border border-gray-200/70 p-4">
                    <div class="text-xs font-bold text-gray-600">Rata-rata per Bulan</div>
                    <div class="text-2xl font-extrabold text-gray-800 mt-1">{{ $yearlyRecap['averagePerMonth'] }}</div>
                    <div class="text-[11px] text-gray-500 mt-0.5">Data dosen / bulan di {{ $yearlyRecap['selectedYear'] }}</div>
                </div>
            </div>

            {{-- 2 Diagram: Tren Bulanan & Sesi --}}
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 pt-2">
                {{-- Diagram 1: Tren Bulanan (Jan - Des) --}}
                <div class="rounded-xl border border-gray-100 p-4 sm:p-5 bg-white">
                    <div class="mb-3">
                        <h3 class="text-sm font-bold text-gray-800">
                            Tren Input Bulanan (Tahun {{ $yearlyRecap['selectedYear'] }})
                        </h3>
                    </div>
                    <div class="relative h-64 sm:h-72">
                        <canvas id="yearlyMonthlyChart"></canvas>
                    </div>
                </div>

                {{-- Diagram 2: Sebaran Sesi / Semester --}}
                <div class="rounded-xl border border-gray-100 p-4 sm:p-5 bg-white">
                    <div class="mb-3">
                        <h3 class="text-sm font-bold text-gray-800">
                            Sebaran Sesi / Semester (Tahun {{ $yearlyRecap['selectedYear'] }})
                        </h3>
                    </div>
                    <div class="relative h-64 sm:h-72">
                        <canvas id="yearlySesiChart"></canvas>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const data = @json($chartData);
    const palette = ['#3B82F6', '#F59E0B', '#10B981', '#8B5CF6', '#EF4444', '#06B6D4', '#EC4899', '#84CC16', '#9CA3AF'];

    // Persentase di dalam irisan doughnut; irisan kecil (<4%) disembunyikan agar tidak bertumpuk.
    const percentLabels = {
        color: '#fff',
        font: { weight: 'bold', size: 11 },
        formatter: (value, ctx) => {
            const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
            const pct = total ? (value / total * 100) : 0;
            return pct >= 4 ? pct.toFixed(1) + '%' : '';
        },
    };

    const doughnutTooltip = {
        callbacks: {
            label: (ctx) => {
                const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                const pct = total ? (ctx.parsed / total * 100).toFixed(1) : 0;
                return ` ${ctx.label}: ${ctx.parsed} dosen (${pct}%)`;
            },
        },
    };

    // ---------- Gender ----------
    new Chart(document.getElementById('genderChart'), {
        type: 'doughnut',
        data: {
            labels: data.gender.labels,
            datasets: [{ data: data.gender.data, backgroundColor: ['#3B82F6', '#EC4899', '#9CA3AF'], borderWidth: 2, borderColor: '#fff' }],
        },
        plugins: [ChartDataLabels],
        options: {
            responsive: true, maintainAspectRatio: false, cutout: '55%',
            plugins: { legend: { display: false }, tooltip: doughnutTooltip, datalabels: percentLabels },
        },
    });

    // ---------- Jabatan ----------
    new Chart(document.getElementById('positionChart'), {
        type: 'doughnut',
        data: {
            labels: data.positions.labels,
            datasets: [{ data: data.positions.data, backgroundColor: palette, borderWidth: 2, borderColor: '#fff' }],
        },
        plugins: [ChartDataLabels],
        options: {
            responsive: true, maintainAspectRatio: false, cutout: '50%',
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } },
                tooltip: doughnutTooltip,
                datalabels: percentLabels,
            },
        },
    });

    // ---------- Negara Asal (horizontal bar) ----------
    const countryCanvas = document.getElementById('countryChart');
    if (countryCanvas && data.countries) {
        new Chart(countryCanvas, {
            type: 'bar',
            data: {
                labels: data.countries.labels,
                datasets: [{
                    label: 'Jumlah Dosen',
                    data: data.countries.data,
                    backgroundColor: data.countries.labels.map(l => (l === 'Belum Diisi' || l === 'Belum Ditentukan') ? '#D1D5DB' : '#0284C7'),
                    hoverBackgroundColor: '#0369A1',
                    borderRadius: 4,
                    barThickness: 16,
                }],
            },
            plugins: [ChartDataLabels],
            options: {
                indexAxis: 'y', responsive: true, maintainAspectRatio: false,
                layout: { padding: { right: 35 } },
                scales: {
                    x: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#F3F4F6' } },
                    y: { grid: { display: false }, ticks: { font: { size: 11 } } },
                },
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        anchor: 'end', align: 'right', color: '#1E293B', font: { weight: 'bold', size: 11 },
                        formatter: v => v > 0 ? v : '',
                    },
                },
            },
        });
    }

    // ---------- Subject (horizontal bar) ----------
    new Chart(document.getElementById('subjectChart'), {
        type: 'bar',
        data: {
            labels: data.subjects.labels,
            datasets: [{
                label: 'Jumlah Dosen',
                data: data.subjects.data,
                backgroundColor: data.subjects.labels.map(l => l === 'Belum diisi' ? '#D1D5DB' : '#10B981'),
                borderRadius: 4,
                barThickness: 16,
            }],
        },
        plugins: [ChartDataLabels],
        options: {
            indexAxis: 'y', responsive: true, maintainAspectRatio: false,
            layout: { padding: { right: 30 } },
            scales: {
                x: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#F3F4F6' } },
                y: { grid: { display: false }, ticks: { font: { size: 11 } } },
            },
            plugins: {
                legend: { display: false },
                datalabels: { anchor: 'end', align: 'right', color: '#374151', font: { weight: 'bold', size: 11 } },
            },
        },
    });

    // ---------- Fakultas (Stacked Bar per Subject) ----------
    const facultyCanvas = document.getElementById('facultyChart');
    if (facultyCanvas && data.faculties) {
        const subjectPalette = [
            '#2563EB', '#DC2626', '#10B981', '#F59E0B', '#8B5CF6', '#06B6D4',
            '#EC4899', '#84CC16', '#EA580C', '#6366F1', '#14B8A6', '#E11D48',
            '#0284C7', '#D97706', '#7C3AED', '#059669', '#DB2777', '#65A30D',
            '#4F46E5', '#0D9488', '#B91C1C', '#1D4ED8', '#A855F7', '#CA8A04',
        ];

        const getSubjectColor = (idx, isEmpty) => {
            if (isEmpty) return '#CBD5E1';
            if (idx < subjectPalette.length) return subjectPalette[idx];
            const offset = idx - subjectPalette.length;
            const hue = Math.round((offset * 137.508) % 360);
            const sat = [72, 62, 80][offset % 3];
            const light = [45, 56, 38, 63][offset % 4];
            return `hsl(${hue}, ${sat}%, ${light}%)`;
        };

        const rawSubjectDatasets = Array.isArray(data.faculties.datasets) ? data.faculties.datasets : [];
        let colorCursor = 0;

        const facultyDatasets = rawSubjectDatasets.map((ds) => {
            const bg = getSubjectColor(colorCursor, Boolean(ds.isEmpty));
            if (!ds.isEmpty) colorCursor++;

            return {
                label: ds.label,
                data: ds.data,
                totalCount: ds.total ?? ds.data.reduce((a, b) => a + b, 0),
                isEmpty: Boolean(ds.isEmpty),
                backgroundColor: bg,
                borderColor: '#FFFFFF',
                borderWidth: 1,
                borderRadius: 2,
                maxBarThickness: 48,
                datalabels: {
                    color: ds.isEmpty ? '#334155' : '#FFFFFF',
                },
            };
        });

        const stackedTotalsPlugin = {
            id: 'stackedTotalsPlugin',
            afterDatasetsDraw(chart) {
                const { ctx, data: chartData, scales: { x, y } } = chart;
                if (!x || !y) return;

                ctx.save();
                ctx.font = 'bold 11px sans-serif';
                ctx.fillStyle = '#374151';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                chartData.labels.forEach((_, idx) => {
                    let sum = 0;
                    chartData.datasets.forEach((ds, dsIdx) => {
                        if (chart.isDatasetVisible(dsIdx)) {
                            sum += Number(ds.data[idx] || 0);
                        }
                    });

                    if (sum > 0) {
                        const xPos = x.getPixelForValue(idx);
                        const yPos = y.getPixelForValue(sum);
                        ctx.fillText(String(sum), xPos, yPos - 5);
                    }
                });

                ctx.restore();
            },
        };

        const facultyChart = new Chart(facultyCanvas, {
            type: 'bar',
            data: {
                labels: data.faculties.labels,
                datasets: facultyDatasets,
            },
            plugins: [ChartDataLabels, stackedTotalsPlugin],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: { top: 24 } },
                scales: {
                    x: {
                        stacked: true,
                        grid: { display: false },
                        ticks: { font: { weight: 'bold', size: 11 } },
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        grace: '12%',
                        ticks: { precision: 0 },
                        grid: { color: '#F3F4F6' },
                    },
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            title: (items) => {
                                if (!items.length) return '';
                                const idx = items[0].dataIndex;
                                const facName = items[0].label;
                                let facTotal = 0;
                                items[0].chart.data.datasets.forEach((ds, dsIdx) => {
                                    if (items[0].chart.isDatasetVisible(dsIdx)) {
                                        facTotal += Number(ds.data[idx] || 0);
                                    }
                                });
                                return `${facName} (Total tampil: ${facTotal} dosen)`;
                            },
                            label: (ctx) => {
                                const val = ctx.parsed.y || 0;
                                const idx = ctx.dataIndex;
                                let facTotal = 0;
                                ctx.chart.data.datasets.forEach((ds, dsIdx) => {
                                    if (ctx.chart.isDatasetVisible(dsIdx)) {
                                        facTotal += Number(ds.data[idx] || 0);
                                    }
                                });
                                const pct = facTotal > 0 ? ((val / facTotal) * 100).toFixed(1) : '0.0';
                                return ` ${ctx.dataset.label}: ${val} dosen (${pct}%)`;
                            },
                        },
                    },
                    datalabels: {
                        font: { weight: 'bold', size: 10 },
                        anchor: 'center',
                        align: 'center',
                        display: (ctx) => {
                            const val = ctx.dataset.data[ctx.dataIndex];
                            if (!val || val <= 0) return false;
                            const bar = ctx.chart.getDatasetMeta(ctx.datasetIndex)?.data?.[ctx.dataIndex];
                            return bar ? Math.abs(bar.base - bar.y) >= 15 : val >= 3;
                        },
                        formatter: (v) => v > 0 ? v : '',
                    },
                },
            },
        });

        // Render keterangan warna subject di bawah diagram (collapsible dropdown)
        const legendContainer = document.getElementById('facultySubjectLegend');
        const legendWrapper = document.getElementById('facultySubjectLegendWrapper');
        const legendPanel = document.getElementById('facultySubjectLegendPanel');
        const toggleLegendBtn = document.getElementById('toggleFacultySubjectLegend');
        const toggleLegendText = document.getElementById('toggleFacultySubjectLegendText');
        const toggleLegendIcon = document.getElementById('toggleFacultySubjectLegendIcon');
        const resetLegendBtn = document.getElementById('resetFacultySubjectLegend');
        const unselectLegendBtn = document.getElementById('unselectFacultySubjectLegend');
        const searchLegendInput = document.getElementById('facultySubjectSearch');

        if (toggleLegendBtn && legendPanel) {
            toggleLegendBtn.addEventListener('click', () => {
                const isHidden = legendPanel.classList.toggle('hidden');
                const expanded = !isHidden;
                toggleLegendBtn.setAttribute('aria-expanded', expanded ? 'true' : 'false');
                if (toggleLegendText) {
                    toggleLegendText.textContent = expanded ? 'Sembunyikan Keterangan' : 'Lihat Keterangan';
                }
                if (toggleLegendIcon) {
                    toggleLegendIcon.classList.toggle('rotate-180', expanded);
                }
            });
        }

        if (legendContainer && facultyDatasets.length > 0) {
            const renderLegend = () => {
                const query = (searchLegendInput?.value || '').trim().toLowerCase();
                legendContainer.innerHTML = '';
                let hasHidden = false;
                let hasVisible = false;
                let shownCount = 0;

                facultyDatasets.forEach((ds, dsIdx) => {
                    const visible = facultyChart.isDatasetVisible(dsIdx);
                    if (visible) {
                        hasVisible = true;
                    } else {
                        hasHidden = true;
                    }

                    if (query && !ds.label.toLowerCase().includes(query)) {
                        return;
                    }
                    shownCount++;

                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = [
                        'inline-flex items-center gap-2 px-2.5 py-1.5 rounded-lg border text-xs transition cursor-pointer max-w-full',
                        visible
                            ? 'bg-gray-50 hover:bg-gray-100 border-gray-200 text-gray-800'
                            : 'bg-white border-gray-200 text-gray-400 opacity-55 line-through',
                    ].join(' ');
                    btn.title = `${ds.label} (${ds.totalCount} dosen) — ${visible ? 'klik untuk menyembunyikan' : 'klik untuk menampilkan'}`;

                    const swatch = document.createElement('span');
                    swatch.className = 'w-3 h-3 rounded-sm shrink-0 border border-black/10';
                    swatch.style.backgroundColor = ds.backgroundColor;

                    const text = document.createElement('span');
                    text.className = 'font-medium text-left truncate max-w-[240px]';
                    text.textContent = ds.label;

                    const count = document.createElement('span');
                    count.className = 'text-[11px] font-bold text-gray-500 shrink-0';
                    count.textContent = `(${ds.totalCount})`;

                    btn.appendChild(swatch);
                    btn.appendChild(text);
                    btn.appendChild(count);

                    btn.addEventListener('click', () => {
                        facultyChart.setDatasetVisibility(dsIdx, !facultyChart.isDatasetVisible(dsIdx));
                        facultyChart.update();
                        renderLegend();
                    });

                    legendContainer.appendChild(btn);
                });

                if (shownCount === 0) {
                    const emptyNote = document.createElement('span');
                    emptyNote.className = 'text-xs text-gray-400 italic';
                    emptyNote.textContent = 'Subject tidak ditemukan.';
                    legendContainer.appendChild(emptyNote);
                }

                if (resetLegendBtn) {
                    resetLegendBtn.classList.toggle('hidden', !hasHidden);
                }
                if (unselectLegendBtn) {
                    unselectLegendBtn.disabled = !hasVisible;
                }
            };

            if (searchLegendInput) {
                searchLegendInput.addEventListener('input', renderLegend);
            }

            if (unselectLegendBtn) {
                unselectLegendBtn.addEventListener('click', () => {
                    facultyDatasets.forEach((_, dsIdx) => {
                        facultyChart.setDatasetVisibility(dsIdx, false);
                    });
                    facultyChart.update();
                    renderLegend();
                });
            }

            if (resetLegendBtn) {
                resetLegendBtn.addEventListener('click', () => {
                    facultyDatasets.forEach((_, dsIdx) => {
                        facultyChart.setDatasetVisibility(dsIdx, true);
                    });
                    facultyChart.update();
                    renderLegend();
                });
            }

            renderLegend();
        } else if (legendWrapper) {
            legendWrapper.classList.add('hidden');
        }
    }

    // ---------- Semester / Sesi Dosen Datang (123 - 126) ----------
    const visitSemesterCanvas = document.getElementById('visitSemesterChart');
    if (visitSemesterCanvas && data.semesters) {
        new Chart(visitSemesterCanvas, {
            type: 'bar',
            data: {
                labels: data.semesters.labels,
                datasets: [{
                    label: 'Jumlah Dosen',
                    data: data.semesters.data,
                    backgroundColor: '#0EA5E9',
                    hoverBackgroundColor: '#0284C7',
                    borderRadius: 6,
                    maxBarThickness: 56,
                }],
            },
            plugins: [ChartDataLabels],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: { top: 24 } },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { weight: 'bold', size: 11 } },
                    },
                    y: {
                        beginAtZero: true,
                        suggestedMax: 5,
                        grace: '15%',
                        ticks: { precision: 0 },
                        grid: { color: '#F3F4F6' },
                    },
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => ` ${ctx.label}: ${ctx.parsed.y} dosen`,
                        },
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: '#0369A1',
                        font: { weight: 'bold', size: 11 },
                        formatter: (v) => v > 0 ? v : '',
                    },
                },
            },
        });
    }

    // ---------- Rekapan Input Bulanan (Jan - Des) ----------
    const monthlyCanvas = document.getElementById('yearlyMonthlyChart');
    if (monthlyCanvas) {
        new Chart(monthlyCanvas, {
            type: 'bar',
            data: {
                labels: data.yearlyMonthly.labels,
                datasets: [{
                    label: 'Dosen Diinput',
                    data: data.yearlyMonthly.data,
                    backgroundColor: '#3B82F6',
                    hoverBackgroundColor: '#2563EB',
                    borderRadius: 5,
                    maxBarThickness: 32,
                }],
            },
            plugins: [ChartDataLabels],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: { top: 20 } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 11, weight: '600' } } },
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#F3F4F6' } },
                },
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: '#1E40AF',
                        font: { weight: 'bold', size: 11 },
                        formatter: v => v > 0 ? v : '',
                    },
                },
            },
        });
    }

    // ---------- Rekapan Sebaran Sesi / Semester ----------
    const sesiCanvas = document.getElementById('yearlySesiChart');
    if (sesiCanvas) {
        new Chart(sesiCanvas, {
            type: 'bar',
            data: {
                labels: data.yearlySesi.labels,
                datasets: [{
                    label: 'Jumlah Dosen',
                    data: data.yearlySesi.data,
                    backgroundColor: '#8B5CF6',
                    hoverBackgroundColor: '#7C3AED',
                    borderRadius: 5,
                    maxBarThickness: 42,
                }],
            },
            plugins: [ChartDataLabels],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: { top: 20 } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 11, weight: '600' } } },
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#F3F4F6' } },
                },
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: '#5B21B6',
                        font: { weight: 'bold', size: 11 },
                        formatter: v => v > 0 ? v : '',
                    },
                },
            },
        });
    }
});
</script>
@endsection
