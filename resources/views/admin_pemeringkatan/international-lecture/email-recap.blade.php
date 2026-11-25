@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8">
    <div class="max-w-[1920px] mx-auto">
        {{-- ================= HEADER ================= --}}
        <div class="mb-6">
            <div class="mb-3">
                @include('admin_pemeringkatan.international-lecture.partials.back-button', [
                    'backRoute' => 'admin_pemeringkatan.international-lecture.index',
                    'backParams' => request('from_table') ? ['table' => 1] : [],
                    'backLabel' => 'Kembali ke International Lecture',
                ])
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Email International Lecturer</h1>
            <p class="text-gray-600 mt-1.5 text-sm sm:text-base">
                Kelola pengiriman email dosen asing dan pantau rekapitulasi pengiriman dalam satu fitur.
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

            {{-- Tombol 2: Rekap Email (Sedang Aktif) --}}
            <div class="w-full text-left bg-emerald-50/80 rounded-2xl border-2 border-emerald-600 ring-4 ring-emerald-100 p-5 sm:p-6 shadow-md">
                <div class="flex items-center gap-4 sm:gap-5">
                    <span class="flex h-14 w-14 sm:h-16 sm:w-16 shrink-0 items-center justify-center rounded-2xl bg-emerald-600 text-white shadow-md">
                        <i class="fa-solid fa-chart-column text-2xl"></i>
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block text-lg sm:text-xl font-bold text-emerald-950">
                            Rekap Email
                        </span>
                        <span class="block mt-1 text-sm sm:text-base text-emerald-700">
                            Lihat riwayat, status, dan kontrol kirim ulang
                        </span>
                    </span>
                    <i class="fa-solid fa-chevron-right text-emerald-600 text-lg sm:text-xl"></i>
                </div>
            </div>

            {{-- Tombol 3: Laporan Email --}}
            <a href="{{ route('admin_pemeringkatan.international-lecture.report.index', array_filter(['from_table' => request('from_table')])) }}"
               class="group w-full text-left bg-white rounded-2xl border-2 border-gray-200 p-5 sm:p-6 shadow-sm transition-all duration-200 hover:border-purple-500 hover:bg-purple-50/30 hover:shadow-md focus:outline-none block">
                <div class="flex items-center gap-4 sm:gap-5">
                    <span class="flex h-14 w-14 sm:h-16 sm:w-16 shrink-0 items-center justify-center rounded-2xl bg-purple-600 text-white shadow-md transition-transform duration-200 group-hover:scale-105">
                        <i class="fa-solid fa-chart-pie text-2xl"></i>
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block text-lg sm:text-xl font-bold text-gray-900 group-hover:text-purple-700 transition-colors">
                            Laporan Email
                        </span>
                        <span class="block mt-1 text-sm sm:text-base text-gray-500">
                            Grafik progres, tren, dan respons email dosen asing
                        </span>
                    </span>
                    <i class="fa-solid fa-chevron-right text-gray-400 group-hover:text-purple-600 group-hover:translate-x-1 transition-all text-lg sm:text-xl"></i>
                </div>
            </a>
        </div>

        @if(session('error'))
            <div class="mb-5 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg text-red-700">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="mb-5 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-lg text-emerald-800 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm p-5 mb-6 border border-gray-200/80">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dari tanggal</label>
                    <input type="date" name="from_date" value="{{ $fromDate }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sampai tanggal</label>
                    <input type="date" name="to_date" value="{{ $toDate }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Email</label>
                    <select name="category" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua kategori</option>
                        <option value="template" @selected(request('category') === 'template')>Template Sistem</option>
                        <option value="manual" @selected(request('category') === 'manual')>Tulis Manual</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua status</option>
                        @foreach(['queued'=>'Menunggu','sending'=>'Mengirim','sent'=>'Terkirim','failed'=>'Gagal'] as $value=>$label)
                            <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama / email / subject" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="lg:col-span-5 flex items-center justify-end gap-2 pt-1">
                    <button class="px-5 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded-lg text-sm font-medium transition shadow-xs">Terapkan Filter</button>
                    <a href="{{ route('admin_pemeringkatan.international-lecture.email-recap.index') }}" class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm font-medium transition">Reset Filter</a>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 mb-6"
             x-data="{
                selectedIds: [],
                allIds: {{ json_encode($selectedLecturers->filter(fn($l) => $todaySent->has($l->id) && empty($resetStatus[$l->id]))->pluck('id')->values()) }},
                toggleAll() {
                    if (this.selectedIds.length === this.allIds.length && this.allIds.length > 0) {
                        this.selectedIds = [];
                    } else {
                        this.selectedIds = [...this.allIds];
                    }
                },
                isAllSelected() {
                    return this.allIds.length > 0 && this.selectedIds.length === this.allIds.length;
                }
             }">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                <div>
                    <h2 class="font-semibold text-gray-800">Kontrol Kirim Ulang Hari Ini</h2>
                    <p class="text-xs text-gray-500 mt-1">Pengiriman yang benar-benar <b>Terkirim</b> hari ini akan ditahan agar tidak terkirim dua kali pada tanggal yang sama. Tombol reset akan hilang setelah berhasil di-reset, dan otomatis tereset penuh setelah 1 tahun.</p>
                </div>
                {{-- Tombol Reset Massal --}}
                <div x-show="selectedIds.length > 0" x-cloak class="flex items-center gap-2">
                    <form method="POST" action="{{ route('admin_pemeringkatan.international-lecture.email-recap.reset-bulk') }}"
                          onsubmit="return confirm('Reset ' + selectedIds.length + ' dosen terpilih untuk hari ini?')">
                        @csrf
                        <template x-for="id in selectedIds" :key="id">
                            <input type="hidden" name="lecturer_ids[]" :value="id">
                        </template>
                        <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-semibold shadow-xs flex items-center gap-1.5 transition">
                            <i class="fa-solid fa-arrows-rotate"></i>
                            <span>Reset Terpilih (<span x-text="selectedIds.length"></span>)</span>
                        </button>
                    </form>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b text-left text-gray-500">
                            <th class="py-3 px-3 w-10 text-center">
                                <input type="checkbox"
                                       @change="toggleAll()"
                                       :checked="isAllSelected()"
                                       :disabled="allIds.length === 0"
                                       class="rounded border-gray-300 text-amber-600 focus:ring-amber-500 cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed"
                                       title="Pilih semua yang dapat di-reset">
                            </th>
                            <th class="py-3 pr-4">Dosen</th>
                            <th class="py-3 pr-4">Email</th>
                            <th class="py-3 pr-4">Pengiriman Terakhir</th>
                            <th class="py-3 pr-4">Status Hari Ini</th>
                            <th class="py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($selectedLecturers as $lecturer)
                        @php
                            $todayLog = $todaySent->get($lecturer->id);
                            $isReset = !empty($resetStatus[$lecturer->id]);
                            $canReset = $todayLog && !$isReset;
                        @endphp
                        <tr class="border-b last:border-0 hover:bg-gray-50/70 transition-colors">
                            <td class="py-3 px-3 text-center">
                                @if($canReset)
                                    <input type="checkbox"
                                           :value="{{ $lecturer->id }}"
                                           x-model.number="selectedIds"
                                           class="rounded border-gray-300 text-amber-600 focus:ring-amber-500 cursor-pointer">
                                @else
                                    <span class="inline-block w-4 h-4 text-gray-300 text-xs">-</span>
                                @endif
                            </td>
                            <td class="py-3 pr-4 font-medium text-gray-800">{{ $lecturer->nama }}</td>
                            <td class="py-3 pr-4 text-gray-600">{{ $lecturer->email }}</td>
                            <td class="py-3 pr-4 text-gray-600">{{ $todayLog?->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                            <td class="py-3 pr-4">
                                @if($isReset)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs bg-blue-100 text-blue-700 font-medium">
                                        <i class="fa-solid fa-check text-[10px]"></i> Sudah di-reset (Bisa Kirim Lagi)
                                    </span>
                                @elseif($todayLog)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs bg-green-100 text-green-700 font-medium">
                                        <i class="fa-solid fa-paper-plane text-[10px]"></i> Terkirim hari ini
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs bg-gray-100 text-gray-600">
                                        Belum terkirim hari ini
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 text-right">
                                @if($canReset)
                                    <form method="POST" action="{{ route('admin_pemeringkatan.international-lecture.email-recap.reset', $lecturer->id) }}" onsubmit="return confirm('Reset pengiriman {{ addslashes($lecturer->nama) }} untuk hari ini?')">
                                        @csrf
                                        <button class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-medium shadow-2xs transition">Reset &amp; Kirim Lagi</button>
                                    </form>
                                @elseif($isReset)
                                    <span class="text-xs text-blue-600 font-medium italic">Siap kirim</span>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-8 text-center text-gray-500">Belum ada dosen dengan email.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b"><h2 class="font-semibold text-gray-800">Detail Rekapan</h2></div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs">
                    <thead class="bg-gray-50"><tr class="text-left text-gray-500">
                        <th class="px-4 py-3">Tanggal &amp; Waktu</th><th class="px-4 py-3">Dosen</th><th class="px-4 py-3">Email</th><th class="px-4 py-3">Kategori</th><th class="px-4 py-3">Subject</th><th class="px-4 py-3">Status</th>
                    </tr></thead>
                    <tbody>
                    @forelse($logs as $log)
                        @php
                            $statusLabels=['queued'=>'Menunggu','sending'=>'Mengirim','sent'=>'Terkirim','failed'=>'Gagal'];
                            $categoryLabels=['template'=>'Template Sistem','manual'=>'Tulis Manual'];
                        @endphp
                        <tr class="border-t align-top">
                            <td class="px-4 py-3 whitespace-nowrap">{{ optional($log->created_at)->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3">{{ $log->lecturer?->nama ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $log->recipient_email }}</td>
                            <td class="px-4 py-3">{{ $categoryLabels[$log->mode] ?? ($log->mode ?: '-') }}</td>
                            <td class="px-4 py-3 max-w-xs">{{ $log->subject ?: '-' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex px-2 py-1 rounded-full {{ $log->status === 'sent' ? 'bg-green-100 text-green-700' : ($log->status === 'failed' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">{{ $statusLabels[$log->status] ?? $log->status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-12 text-center text-gray-500">Tidak ada rekapan untuk periode/filter ini.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-4 border-t">{{ $logs->links() }}</div>
        </div>
    </div>
</div>
@endsection
