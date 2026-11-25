@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8">
    <div class="max-w-[1920px] mx-auto font-sans">

        {{-- ================= HEADER ================= --}}
        <div class="mb-6 sm:mb-8">
            <div class="mb-3">
                @include('admin_pemeringkatan.international-lecture.partials.back-button', [
                    'backRoute' => 'admin_pemeringkatan.international-lecture.report.index',
                    'backParams' => array_filter(['fakultas' => request('fakultas'), 'sesi' => request('sesi')]),
                    'backLabel' => 'Kembali ke Laporan Email',
                ])
            </div>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">
                        Rincian Respons Consent Dosen Asing
                    </h1>
                </div>
                <div class="flex items-center gap-2.5 shrink-0">
                    <a href="{{ request()->fullUrlWithQuery(['export' => 'csv']) }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 text-xs sm:text-sm font-semibold rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 shadow-sm transition">
                        <i class="fa-solid fa-file-csv text-base"></i>
                        <span>Unduh CSV</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- ================= KARTU RINGKASAN STATISTIK (KPIS) ================= --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
            {{-- Kartu 1: Total Dosen dalam Lingkup --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-200/80 shadow-sm">
                <p class="text-xs font-semibold text-gray-900 uppercase tracking-wider">
                    {{ $scope === 'sent_only' ? 'Total Email Terkirim' : 'Total Dosen Asing' }}
                </p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1">
                    {{ number_format($stats['total']) }}
                </h3>
                <div class="mt-3 text-xs text-gray-900 font-medium">
                    <span>{{ $stats['response_rate'] }}% tingkat respons ({{ $stats['responded_total'] }} dosen telah merespons)</span>
                </div>
            </div>

            {{-- Kartu 2: Setuju (Agreed) --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-200/80 shadow-sm">
                <p class="text-xs font-semibold text-gray-900 uppercase tracking-wider">
                    Setuju (Agreed)
                </p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-emerald-700 mt-1">
                    {{ number_format($stats['agreed']) }}
                </h3>
                <div class="mt-3 text-xs text-gray-900 font-medium">
                    {{ $stats['agreed_pct'] }}% dari total
                </div>
            </div>

            {{-- Kartu 3: Menolak (Declined) --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-200/80 shadow-sm">
                <p class="text-xs font-semibold text-gray-900 uppercase tracking-wider">
                    Menolak (Declined)
                </p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-rose-700 mt-1">
                    {{ number_format($stats['declined']) }}
                </h3>
                <div class="mt-3 text-xs text-gray-900 font-medium">
                    {{ $stats['declined_pct'] }}% dari total
                </div>
            </div>

            {{-- Kartu 4: Belum Merespons (Pending) --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-200/80 shadow-sm">
                <p class="text-xs font-semibold text-gray-900 uppercase tracking-wider">
                    Belum Merespons
                </p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-amber-700 mt-1">
                    {{ number_format($stats['pending']) }}
                </h3>
                <div class="mt-3 text-xs text-gray-900 font-medium">
                    {{ $stats['pending_pct'] }}% dari total
                </div>
            </div>
        </div>

        {{-- ================= FILTER FORM ================= --}}
        <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200/80 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4 pb-3.5 border-b border-gray-100">
                <div class="flex items-center gap-2.5">
                    <h3 class="text-base font-bold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-filter text-purple-600"></i>
                        <span>Filter Data Respons Consent</span>
                    </h3>
                    @if(request()->hasAny(['status', 'fakultas', 'sesi', 'search']) && (request('status') !== 'semua' || request('fakultas') !== 'semua' || request()->filled('sesi') || request()->filled('search')))
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                            <i class="fa-solid fa-check text-[10px]"></i>
                            Filter Aktif
                        </span>
                    @endif
                </div>

                {{-- Tombol Lingkup Data (Scope) --}}
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider hidden sm:inline">Lingkup:</span>
                    <div class="inline-flex p-1 rounded-xl bg-gray-100 text-xs sm:text-sm font-medium">
                        <a href="{{ request()->fullUrlWithQuery(['scope' => 'sent_only', 'page' => 1]) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg transition text-gray-900 {{ $scope === 'sent_only' ? 'bg-white font-bold shadow-xs' : 'hover:text-black' }}"
                           title="Dosen yang sudah dikirim email (sinkron dengan diagram donat)">
                            <span class="text-gray-900">Dosen Penerima Email</span>
                            <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-gray-200 text-gray-900 font-bold">
                                {{ $stats['total'] }}
                            </span>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['scope' => 'all', 'page' => 1]) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg transition text-gray-900 {{ $scope === 'all' ? 'bg-white font-bold shadow-xs' : 'hover:text-black' }}"
                           title="Seluruh data dosen asing di sistem">
                            <span class="text-gray-900">Semua Data Dosen Asing</span>
                        </a>
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ route('admin_pemeringkatan.international-lecture.report.consent-detail') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3.5 items-end">
                <input type="hidden" name="scope" value="{{ $scope }}">

                {{-- Filter Status Consent --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Status Consent</label>
                    <select name="status" class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:bg-white focus:outline-none font-medium">
                        <option value="semua" @selected($selectedStatus === 'semua')>Semua Status</option>
                        <option value="agreed" @selected($selectedStatus === 'agreed')>Setuju (Agreed)</option>
                        <option value="declined" @selected($selectedStatus === 'declined')>Menolak (Declined)</option>
                        <option value="pending" @selected($selectedStatus === 'pending')>Belum Merespons (Pending)</option>
                    </select>
                </div>

                {{-- Filter Fakultas --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Fakultas</label>
                    <select name="fakultas" class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:bg-white focus:outline-none font-medium">
                        <option value="semua">Semua Fakultas</option>
                        @foreach($faculties as $k => $label)
                            <option value="{{ $k }}" @selected($selectedFaculty === $k)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Sesi / Semester --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Sesi / Semester</label>
                    <input type="text" name="sesi" value="{{ request('sesi') }}" placeholder="Contoh: 125"
                           class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:bg-white focus:outline-none">
                </div>

                {{-- Cari Nama / Email / Universitas --}}
                <div class="sm:col-span-2 md:col-span-3 lg:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Cari Dosen / Email / Kampus</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama, email, kampus asal, atau prodi..."
                               class="w-full pl-9 pr-3 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:bg-white focus:outline-none">
                    </div>
                </div>

                {{-- Tombol Submit & Reset --}}
                <div class="sm:col-span-2 md:col-span-3 lg:col-span-5 flex items-center justify-end gap-2 pt-2 border-t border-gray-100">
                    <button type="submit" class="px-5 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-xs sm:text-sm font-semibold transition shadow-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-filter text-xs"></i>
                        <span>Terapkan Filter</span>
                    </button>
                    <a href="{{ route('admin_pemeringkatan.international-lecture.report.consent-detail', ['scope' => $scope]) }}"
                       class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-xs sm:text-sm font-medium transition flex items-center gap-1.5">
                        <i class="fa-solid fa-rotate-left text-xs"></i>
                        <span>Reset Filter</span>
                    </a>
                </div>
            </form>
        </div>

        {{-- ================= TABEL DAFTAR DOSEN & STATUS CONSENT ================= --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden">
            <div class="px-5 sm:px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <h3 class="text-base font-bold text-gray-800">
                        Daftar Dosen &amp; Status Respons Consent
                    </h3>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-gray-100 text-gray-700 border border-gray-200">
                        Total {{ $lecturers->total() }} Data
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 border-b border-gray-200 uppercase text-[11px] tracking-wider font-semibold">
                            <th class="py-3.5 px-4 text-center w-12">No</th>
                            <th class="py-3.5 px-4 min-w-[220px]">Nama Dosen Asing</th>
                            <th class="py-3.5 px-4 min-w-[220px]">Kontak &amp; Fakultas</th>
                            <th class="py-3.5 px-4 text-center min-w-[120px]">Sesi / Tahun</th>
                            <th class="py-3.5 px-4 min-w-[160px]">Status Pengiriman Email</th>
                            <th class="py-3.5 px-4 text-center min-w-[170px]">Status Consent</th>
                            <th class="py-3.5 px-4 min-w-[170px]">Waktu Respons Consent</th>
                            <th class="py-3.5 px-4 text-center min-w-[110px]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($lecturers as $index => $lecturer)
                            @php
                                $statusConsent = $lecturer->consent_status;
                                if (empty($statusConsent)) {
                                    $statusConsent = 'pending';
                                }
                            @endphp
                            <tr class="hover:bg-purple-50/20 transition-colors">
                                {{-- 1. No --}}
                                <td class="py-3.5 px-4 text-center text-gray-500 font-medium">
                                    {{ $lecturers->firstItem() + $index }}
                                </td>

                                {{-- 2. Nama Dosen Asing & Institusi --}}
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-gray-900 text-sm">
                                        {{ $lecturer->nama }}
                                    </div>
                                    <div class="text-xs text-gray-600 mt-0.5 flex items-center gap-1.5 flex-wrap">
                                        <span class="inline-flex items-center gap-1 text-gray-500">
                                            <i class="fa-solid fa-building-columns text-[10px]"></i>
                                            {{ $lecturer->universitas_asal ?: '-' }}
                                        </span>
                                        @if($lecturer->negara)
                                            <span class="text-gray-300">•</span>
                                            <span class="inline-flex items-center gap-1 text-gray-500">
                                                <i class="fa-solid fa-globe text-[10px]"></i>
                                                {{ $lecturer->negara }}
                                            </span>
                                        @endif
                                    </div>
                                    @if($lecturer->jabatan)
                                        <div class="text-[11px] text-gray-400 mt-0.5">
                                            {{ $lecturer->jabatan }}
                                        </div>
                                    @endif
                                </td>

                                {{-- 3. Kontak & Fakultas --}}
                                <td class="py-3.5 px-4">
                                    @if($lecturer->email)
                                        <div class="flex items-center gap-1.5 group">
                                            <a href="mailto:{{ $lecturer->email }}" class="text-purple-700 hover:text-purple-900 font-medium hover:underline flex items-center gap-1">
                                                <i class="fa-regular fa-envelope text-xs text-gray-400"></i>
                                                <span>{{ $lecturer->email }}</span>
                                            </a>
                                            <button type="button"
                                                    onclick="navigator.clipboard.writeText('{{ $lecturer->email }}'); this.innerHTML='<i class=\'fa-solid fa-check text-[10px] text-emerald-600\'></i>'; setTimeout(() => this.innerHTML='<i class=\'fa-regular fa-copy text-[10px]\'></i>', 1500);"
                                                    class="text-gray-400 hover:text-gray-600 p-0.5 rounded cursor-pointer"
                                                    title="Salin email">
                                                <i class="fa-regular fa-copy text-[10px]"></i>
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-xs text-rose-500 italic flex items-center gap-1">
                                            <i class="fa-solid fa-triangle-exclamation text-[10px]"></i>
                                            Email belum diisi
                                        </span>
                                    @endif
                                    <div class="mt-1 flex items-center gap-1.5 flex-wrap text-xs">
                                        <span class="font-bold text-gray-900 uppercase">
                                            {{ $lecturer->fakultas ?: 'Lainnya' }}
                                        </span>
                                        @if($lecturer->prodi)
                                            <span class="text-gray-400">•</span>
                                            <span class="text-gray-600 truncate max-w-[180px]" title="{{ $lecturer->prodi }}">
                                                {{ $lecturer->prodi }}
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                {{-- 4. Sesi / Tahun --}}
                                <td class="py-3.5 px-4 text-center">
                                    <div class="font-semibold text-gray-700">
                                        {{ $lecturer->sesi ?: '-' }}
                                    </div>
                                    <div class="text-xs text-gray-400 mt-0.5">
                                        Tahun {{ $lecturer->tahun ?: '-' }}
                                    </div>
                                </td>

                                {{-- 5. Status Pengiriman Email --}}
                                <td class="py-3.5 px-4">
                                    @if($lecturer->email_status === 'sent')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <i class="fa-solid fa-circle-check text-[10px]"></i>
                                            Terkirim
                                        </span>
                                        <div class="text-[11px] text-gray-500 mt-1">
                                            {{ $lecturer->email_sent_at ? $lecturer->email_sent_at->translatedFormat('d M Y, H:i') . ' WIB' : '-' }}
                                        </div>
                                    @elseif(in_array($lecturer->email_status, ['queued', 'sending']))
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                            <i class="fa-solid fa-spinner fa-spin text-[10px]"></i>
                                            Dalam Proses
                                        </span>
                                    @elseif($lecturer->email_status === 'failed')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                            <i class="fa-solid fa-circle-xmark text-[10px]"></i>
                                            Gagal
                                        </span>
                                        @if($lecturer->email_error)
                                            <div class="text-[10px] text-rose-600 mt-0.5 truncate max-w-xs" title="{{ $lecturer->email_error }}">
                                                {{ $lecturer->email_error }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200">
                                            <i class="fa-regular fa-clock text-[10px]"></i>
                                            Belum Terkirim
                                        </span>
                                    @endif
                                </td>

                                {{-- 6. Status Consent --}}
                                <td class="py-3.5 px-4 text-center">
                                    @if($statusConsent === 'agreed')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300 shadow-2xs">
                                            <i class="fa-solid fa-circle-check text-emerald-600 text-xs"></i>
                                            <span>Setuju (Agreed)</span>
                                        </span>
                                    @elseif(in_array($statusConsent, ['declined', 'rejected']))
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-300 shadow-2xs">
                                            <i class="fa-solid fa-circle-xmark text-rose-600 text-xs"></i>
                                            <span>Menolak (Declined)</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-300 shadow-2xs">
                                            <i class="fa-solid fa-clock text-amber-600 text-xs"></i>
                                            <span>Belum Merespons</span>
                                        </span>
                                    @endif
                                </td>

                                {{-- 7. Waktu Respons Consent --}}
                                <td class="py-3.5 px-4">
                                    @if($lecturer->consented_at)
                                        <div class="font-semibold text-gray-800 flex items-center gap-1.5">
                                            <i class="fa-regular fa-calendar-check text-emerald-600 text-xs"></i>
                                            <span>{{ $lecturer->consented_at->translatedFormat('d M Y, H:i') }} WIB</span>
                                        </div>
                                        <div class="text-[11px] text-gray-500 mt-0.5">
                                            {{ $lecturer->consented_at->diffForHumans() }}
                                        </div>
                                    @else
                                        <div class="text-xs text-gray-400 italic flex items-center gap-1">
                                            <i class="fa-regular fa-hourglass-half text-[11px]"></i>
                                            <span>Menunggu tanggapan dosen</span>
                                        </div>
                                    @endif
                                </td>

                                {{-- 8. Aksi --}}
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        {{-- Link ke Halaman Data Dosen dengan Pencarian Nama --}}
                                        <a href="{{ route('admin_pemeringkatan.international-lecture.index', ['table' => 1, 'search' => $lecturer->nama]) }}#dosenTableSection"
                                           class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-gray-100 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition"
                                           title="Lihat profil dosen lengkap di Tabel Dosen">
                                            <i class="fa-solid fa-user-pen text-xs"></i>
                                        </a>

                                        {{-- Link ke Rekap Email untuk cek / kontrol pengiriman --}}
                                        <a href="{{ route('admin_pemeringkatan.international-lecture.email-recap.index', ['search' => $lecturer->nama]) }}"
                                           class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-gray-100 text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition"
                                           title="Lihat riwayat pengiriman email dosen ini">
                                            <i class="fa-solid fa-envelope-open-text text-xs"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 px-4 text-center text-gray-500 bg-gray-50/50">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 mb-3 text-2xl">
                                            <i class="fa-solid fa-inbox"></i>
                                        </div>
                                        <h4 class="text-base font-bold text-gray-700">Tidak ada data dosen yang sesuai</h4>
                                        <p class="text-xs text-gray-500 mt-1 max-w-sm">
                                            Coba ubah kata kunci pencarian atau sesuaikan opsi filter status consent dan fakultas di atas.
                                        </p>
                                        <div class="mt-4">
                                            <a href="{{ route('admin_pemeringkatan.international-lecture.report.consent-detail', ['scope' => $scope]) }}"
                                               class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold rounded-lg bg-purple-600 text-white hover:bg-purple-700 transition">
                                                <i class="fa-solid fa-rotate-left text-xs"></i>
                                                <span>Reset Filter</span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            @if($lecturers->hasPages())
                <div class="px-5 sm:px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $lecturers->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection

