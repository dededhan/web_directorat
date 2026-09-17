@extends('admin_hackaton.index')

@section('contentadmin_hackaton')
    <div class="space-y-8">
        {{-- Breadcrumb & Header --}}
        <div class="border-b-4 border-gray-950 pb-6 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
            <div>
                <p class="mb-2 text-sm font-bold uppercase tracking-[0.18em] text-gray-600">
                    <a href="{{ route('admin_hackaton.sessions.index') }}" class="hover:underline">Admin Hackaton / Sesi</a> / Detail
                </p>
                <h1 class="text-3xl font-black text-gray-950 sm:text-4xl">{{ $session->nama_sesi }}</h1>
                <p class="mt-2 text-base text-gray-700">
                    Periode: <strong class="text-black">{{ $session->periode_awal->format('d M Y') }} — {{ $session->periode_akhir->format('d M Y') }}</strong>
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                @if ($session->status === 'draft')
                    <form action="{{ route('admin_hackaton.sessions.activate', $session) }}" method="POST" class="inline">
                        @csrf @method('PATCH')
                        <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold uppercase tracking-wider px-4 py-3 transition flex items-center gap-2">
                            <i class="fas fa-play"></i> Aktifkan Sesi
                        </button>
                    </form>
                @elseif ($session->status === 'active')
                    <form action="{{ route('admin_hackaton.sessions.close', $session) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menutup sesi ini?')">
                        @csrf @method('PATCH')
                        <button type="submit" class="bg-rose-700 hover:bg-rose-800 text-white text-xs font-bold uppercase tracking-wider px-4 py-3 transition flex items-center gap-2">
                            <i class="fas fa-stop"></i> Tutup Sesi
                        </button>
                    </form>
                @endif

                <a href="{{ route('admin_hackaton.submissions.index', $session) }}" class="bg-amber-500 hover:bg-amber-600 text-gray-950 text-xs font-bold uppercase tracking-wider px-4 py-3 transition flex items-center gap-2 border border-black">
                    <i class="fas fa-file-alt"></i> Lihat Proposal ({{ $session->submissions->count() }})
                </a>

                <a href="{{ route('admin_hackaton.submissions.scores', $session) }}" class="bg-white hover:bg-gray-100 text-gray-950 text-xs font-bold uppercase tracking-wider px-4 py-3 transition flex items-center gap-2 border border-black">
                    <i class="fas fa-trophy"></i> Ranking Nilai
                </a>

                <a href="{{ route('admin_hackaton.sessions.edit', $session) }}" class="bg-gray-950 hover:bg-gray-800 text-white text-xs font-bold uppercase tracking-wider px-4 py-3 transition flex items-center gap-2">
                    <i class="fas fa-edit"></i> Edit Sesi
                </a>
            </div>
        </div>

        {{-- Info Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="border-2 border-gray-950 bg-white p-5">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Status Sesi</p>
                <div class="mt-2 flex items-center gap-2">
                    @if ($session->status === 'active')
                        <span class="inline-flex items-center px-3 py-1 text-xs font-black bg-emerald-100 text-emerald-800 border border-emerald-300">
                            AKTIF (DIBUKA)
                        </span>
                    @elseif ($session->status === 'closed')
                        <span class="inline-flex items-center px-3 py-1 text-xs font-black bg-rose-100 text-rose-800 border border-rose-300">
                            DITUTUP
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 text-xs font-black bg-gray-100 text-gray-700 border border-gray-300">
                            DRAFT
                        </span>
                    @endif
                </div>
            </div>

            <div class="border-2 border-gray-950 bg-white p-5">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Anggota Tim</p>
                <p class="mt-2 text-2xl font-black text-gray-950">
                    {{ $session->min_anggota }} — {{ $session->max_anggota }} <span class="text-sm font-semibold text-gray-600">orang</span>
                </p>
            </div>

            <div class="border-2 border-gray-950 bg-white p-5">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Plafon Pendanaan</p>
                <p class="mt-2 text-sm font-black text-gray-950">
                    @if ($session->dana_minimal || $session->dana_maksimal)
                        Rp {{ number_format($session->dana_minimal ?? 0, 0, ',', '.') }} — Rp {{ number_format($session->dana_maksimal ?? 0, 0, ',', '.') }}
                    @else
                        <span class="text-gray-400 italic">Tidak ditetapkan</span>
                    @endif
                </p>
            </div>

            <div class="border-2 border-gray-950 bg-white p-5">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Total Proposal</p>
                <p class="mt-2 text-2xl font-black text-gray-950">{{ $session->submissions->count() }}</p>
            </div>
        </div>

        @if ($session->deskripsi)
            <div class="border-2 border-gray-950 bg-white p-6">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Petunjuk & Deskripsi Sesi</h3>
                <p class="text-sm text-gray-800 leading-relaxed whitespace-pre-line">{{ $session->deskripsi }}</p>
            </div>
        @endif

        {{-- Dynamic Tahap Cards & Form Builder Section --}}
        <div class="space-y-4" x-data="{ showAddTahap: false }">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b-2 border-gray-950 pb-3 gap-3">
                <div>
                    <h2 class="text-2xl font-black text-gray-950">Tahapan Evaluasi Hackaton ({{ $session->tahap->count() }} Tahap)</h2>
                    <p class="text-sm text-gray-600">Sistem terstruktur dinamis bertingkat. Tambah, atur jadwal, atau sesuaikan form tiap tahap.</p>
                </div>
                <button type="button" @click="showAddTahap = !showAddTahap"
                    class="bg-gray-950 hover:bg-gray-800 text-white text-xs font-bold uppercase tracking-wider px-4 py-2.5 flex items-center gap-2 self-start sm:self-auto transition">
                    <i class="fas fa-plus"></i> Tambah Tahap Baru
                </button>
            </div>

            {{-- Form Tambah Tahap Baru --}}
            <div x-show="showAddTahap" x-cloak class="border-2 border-dashed border-gray-950 bg-amber-50 p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-amber-300 pb-2">
                    <h3 class="text-sm font-black uppercase tracking-wider text-gray-950 flex items-center gap-2">
                        <i class="fas fa-layer-group"></i> Tambah Tahap {{ $session->tahap->count() + 1 }}
                    </h3>
                    <button type="button" @click="showAddTahap = false" class="text-gray-500 hover:text-black">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form action="{{ route('admin_hackaton.tahap.store', $session) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">
                                Nama Tahap <span class="text-rose-600">*</span>
                            </label>
                            <input type="text" name="nama_tahap" required
                                placeholder="Contoh: Tahap {{ $session->tahap->count() + 1 }} - Pitching / Presentasi"
                                class="w-full border-2 border-gray-950 bg-white px-3 py-2 text-sm focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">
                                Deskripsi / Instruksi Singkat
                            </label>
                            <input type="text" name="deskripsi"
                                placeholder="Petunjuk khusus pengusul untuk tahap ini..."
                                class="w-full border-2 border-gray-950 bg-white px-3 py-2 text-sm focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">
                                Periode Mulai (Opsional)
                            </label>
                            <input type="datetime-local" name="periode_awal"
                                class="w-full border-2 border-gray-950 bg-white px-3 py-2 text-sm focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">
                                Periode Selesai (Opsional)
                            </label>
                            <input type="datetime-local" name="periode_akhir"
                                class="w-full border-2 border-gray-950 bg-white px-3 py-2 text-sm focus:outline-none">
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-4 pt-2">
                        <div class="flex items-center gap-6">
                            <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-bold text-gray-800">
                                <input type="checkbox" name="has_anggota" value="1" class="w-4 h-4 border-2 border-gray-950">
                                Aktifkan Pengisian Anggota
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-bold text-gray-800">
                                <input type="checkbox" name="has_fakultas" value="1" class="w-4 h-4 border-2 border-gray-950">
                                Aktifkan Pilihan Fakultas
                            </label>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" @click="showAddTahap = false" class="px-4 py-2 text-xs font-bold uppercase text-gray-700 hover:text-black">
                                Batal
                            </button>
                            <button type="submit" class="bg-gray-950 text-white px-5 py-2 text-xs font-bold uppercase hover:bg-gray-800 transition">
                                Simpan Tahap
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($session->tahap as $tahap)
                    <div class="border-2 border-gray-950 bg-white flex flex-col justify-between overflow-hidden shadow-sm">
                        <div>
                            {{-- Header Card --}}
                            <div class="border-b-2 border-gray-950 bg-gray-100 p-5 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-none bg-gray-950 text-white font-black text-sm flex items-center justify-center">
                                        {{ $tahap->tahap_ke }}
                                    </span>
                                    <div>
                                        <h3 class="font-black text-gray-950 text-base leading-tight">{{ $tahap->nama_tahap }}</h3>
                                        <span class="text-[10px] uppercase tracking-wider font-bold text-gray-500">
                                            Tahap {{ $tahap->tahap_ke }} of {{ $session->tahap->count() }}
                                        </span>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 text-[10px] font-bold border border-gray-400 bg-white">
                                    {{ $tahap->getTimingStatus() === 'dibuka' ? 'Buka' : ($tahap->getTimingStatus() === 'ditutup' ? 'Tutup' : 'Belum Buka') }}
                                </span>
                            </div>

                            {{-- Body Card --}}
                            <div class="p-5 space-y-4 text-xs">
                                <div>
                                    <p class="font-bold uppercase tracking-wider text-gray-500 text-[10px]">Jadwal Pelaksanaan</p>
                                    <p class="mt-1 text-gray-800 font-medium">
                                        @if ($tahap->periode_awal && $tahap->periode_akhir)
                                            {{ $tahap->periode_awal->format('d M Y H:i') }} — {{ $tahap->periode_akhir->format('d M Y H:i') }}
                                        @else
                                            <span class="text-gray-400 italic">Mengikuti jadwal umum sesi</span>
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <p class="font-bold uppercase tracking-wider text-gray-500 text-[10px]">Form Builder</p>
                                    <p class="mt-1 text-gray-800 font-medium">
                                        {{ $tahap->fields->count() }} Field Isian ({{ $tahap->sections->count() }} Section)
                                    </p>
                                </div>

                                @if ($tahap->deskripsi)
                                    <div>
                                        <p class="font-bold uppercase tracking-wider text-gray-500 text-[10px]">Deskripsi / Instruksi</p>
                                        <p class="mt-1 text-gray-600 line-clamp-3">{{ $tahap->deskripsi }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Footer Actions --}}
                        <div class="border-t-2 border-gray-950 p-4 bg-gray-50 flex items-center justify-between gap-2">
                            <div>
                                @if ($session->tahap->count() > 1)
                                    <form action="{{ route('admin_hackaton.tahap.destroy', $tahap) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Hapus Tahap {{ $tahap->tahap_ke }} ({{ $tahap->nama_tahap }}) beserta seluruh form dan isian di dalamnya?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="border border-rose-400 bg-white text-rose-700 hover:bg-rose-50 text-xs font-bold px-2.5 py-2 transition" title="Hapus Tahap">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <a href="{{ route('admin_hackaton.tahap.edit', $tahap) }}"
                                class="inline-flex items-center gap-1.5 bg-gray-950 text-white text-xs font-bold uppercase tracking-wider px-3 py-2 hover:bg-gray-800 transition">
                                <i class="fas fa-sliders-h text-[10px]"></i> Edit Form & Tahap
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full border-2 border-dashed border-gray-400 p-8 text-center bg-gray-50">
                        <p class="text-sm font-bold text-gray-500">Belum ada tahap yang dibuat untuk sesi ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
