@extends('admin_hackaton.index')

@section('contentadmin_hackaton')
    <div class="space-y-8" x-data="{
        createModalOpen: false,
        editModalOpen: false,
        editItem: { id: null, title: '', content: '', type: 'info', link_url: '', link_text: '', is_active: true },
        openEdit(item) {
            this.editItem = {
                id: item.id,
                title: item.title,
                content: item.content,
                type: item.type,
                link_url: item.link_url || '',
                link_text: item.link_text || '',
                is_active: Boolean(item.is_active)
            };
            this.editModalOpen = true;
        }
    }">
        {{-- Header Section --}}
        <section class="border-b-4 border-gray-950 pb-8 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6">
            <div>
                <p class="mb-3 text-sm font-bold uppercase tracking-[0.18em] text-gray-600">Admin HackAthon / Modul Pengumuman</p>
                <h1 class="max-w-4xl text-4xl font-black leading-tight tracking-tight text-gray-950 sm:text-5xl">
                    Kelola Pengumuman
                </h1>
                <p class="mt-4 max-w-2xl text-lg leading-relaxed text-gray-700">
                    Terbitkan informasi, jadwal penting, dan pengumuman resmi yang tayang langsung di halaman utama dan dashboard peserta Hackathon.
                </p>
            </div>
            <div>
                <button type="button" @click="createModalOpen = true"
                    class="inline-flex min-h-12 items-center justify-center bg-emerald-700 px-6 py-3 text-base font-black text-white transition hover:bg-emerald-800 shadow-sm cursor-pointer">
                    <i class="fas fa-plus mr-2"></i> Buat Pengumuman Baru
                </button>
            </div>
        </section>

        {{-- Stats Overview --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="border-2 border-gray-950 bg-white p-5">
                <p class="text-3xl font-black tabular-nums text-gray-950">{{ $totalCount }}</p>
                <p class="mt-2 text-sm font-bold text-gray-600 uppercase tracking-wider">Total Pengumuman</p>
            </div>
            <div class="border-2 border-gray-950 bg-emerald-50 p-5">
                <p class="text-3xl font-black tabular-nums text-emerald-800">{{ $activeCount }}</p>
                <p class="mt-2 text-sm font-bold text-emerald-900 uppercase tracking-wider">Sedang Tayang (Aktif)</p>
            </div>
            <div class="border-2 border-gray-950 bg-gray-50 p-5">
                <p class="text-3xl font-black tabular-nums text-gray-700">{{ $totalCount - $activeCount }}</p>
                <p class="mt-2 text-sm font-bold text-gray-600 uppercase tracking-wider">Arsip / Nonaktif</p>
            </div>
        </div>

        {{-- Filter & Search Form --}}
        <form method="GET" action="{{ route('admin_hackaton.announcements.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari judul atau isi pengumuman..."
                    class="w-full border-2 border-gray-950 bg-white px-4 py-3 text-sm text-gray-950 focus:border-emerald-700 focus:outline-none">
            </div>
            <div class="w-full sm:w-48">
                <select name="type" class="w-full border-2 border-gray-950 bg-white px-4 py-3 text-sm text-gray-950 focus:border-emerald-700 focus:outline-none">
                    <option value="">Semua Tipe</option>
                    <option value="info" @selected(request('type') === 'info')>Informasi</option>
                    <option value="penting" @selected(request('type') === 'penting')>Penting</option>
                    <option value="urgent" @selected(request('type') === 'urgent')>Mendesak / Urgent</option>
                </select>
            </div>
            <div class="w-full sm:w-44">
                <select name="status" class="w-full border-2 border-gray-950 bg-white px-4 py-3 text-sm text-gray-950 focus:border-emerald-700 focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="active" @selected(request('status') === 'active')>Aktif</option>
                    <option value="inactive" @selected(request('status') === 'inactive')>Nonaktif</option>
                </select>
            </div>
            <button type="submit" class="border-2 border-gray-950 bg-gray-900 px-6 py-3 text-sm font-black text-white hover:bg-gray-800 transition">
                <i class="fas fa-filter mr-1.5"></i> Filter
            </button>
            @if(request()->anyFilled(['search', 'type', 'status']))
                <a href="{{ route('admin_hackaton.announcements.index') }}" class="border-2 border-gray-950 bg-white px-4 py-3 text-sm font-bold text-gray-700 hover:bg-gray-100 flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>

        {{-- Announcements List --}}
        <div class="space-y-4">
            @forelse ($announcements as $item)
                <div class="border-2 border-gray-950 bg-white p-6 transition hover:border-emerald-700">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-5">
                        <div class="space-y-3 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="border px-2.5 py-0.5 text-xs font-black uppercase tracking-wider {{ $item->badge_class }}">
                                    <i class="fas {{ $item->icon }} mr-1"></i> {{ $item->type_label }}
                                </span>
                                @if ($item->is_active)
                                    <span class="border border-emerald-300 bg-emerald-50 px-2.5 py-0.5 text-xs font-bold text-emerald-800">
                                        ● Sedang Tayang
                                    </span>
                                @else
                                    <span class="border border-gray-300 bg-gray-100 px-2.5 py-0.5 text-xs font-bold text-gray-600">
                                        ○ Nonaktif
                                    </span>
                                @endif
                                <span class="text-xs text-gray-500">
                                    {{ $item->created_at->format('d M Y, H:i') }}
                                </span>
                                @if ($item->author)
                                    <span class="text-xs text-gray-400">
                                        • Oleh: {{ $item->author->name }}
                                    </span>
                                @endif
                            </div>

                            <h2 class="text-xl font-black text-gray-950 leading-tight">
                                {{ $item->title }}
                            </h2>

                            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                                {{ $item->content }}
                            </p>

                            @if ($item->link_url)
                                <div class="pt-1">
                                    <a href="{{ $item->link_url }}" target="_blank" rel="noopener noreferrer"
                                        class="inline-flex items-center gap-1.5 text-xs font-black text-emerald-700 hover:text-emerald-800 underline underline-offset-4">
                                        <span>{{ $item->link_text ?: 'Buka Tautan Lampiran' }}</span>
                                        <i class="fas fa-external-link-alt text-[10px]"></i>
                                    </a>
                                </div>
                            @endif
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-wrap lg:flex-col items-end gap-2 shrink-0 border-t lg:border-t-0 pt-3 lg:pt-0 border-gray-100">
                            {{-- Toggle Status --}}
                            <form action="{{ route('admin_hackaton.announcements.toggle', $item) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="border-2 border-gray-950 px-4 py-2 text-xs font-black uppercase tracking-wider transition cursor-pointer {{ $item->is_active ? 'bg-amber-100 text-amber-900 hover:bg-amber-200' : 'bg-emerald-100 text-emerald-900 hover:bg-emerald-200' }}">
                                    <i class="fas {{ $item->is_active ? 'fa-pause' : 'fa-play' }} mr-1"></i>
                                    {{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>

                            {{-- Edit Trigger --}}
                            <button type="button" @click="openEdit({{ json_encode($item) }})"
                                class="border-2 border-gray-950 bg-white px-4 py-2 text-xs font-black uppercase tracking-wider text-gray-950 hover:bg-gray-100 transition cursor-pointer">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </button>

                            {{-- Delete --}}
                            <form action="{{ route('admin_hackaton.announcements.destroy', $item) }}" method="POST"
                                onsubmit="return confirm('Hapus pengumuman ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="border-2 border-gray-950 bg-rose-50 px-4 py-2 text-xs font-black uppercase tracking-wider text-rose-800 hover:bg-rose-100 transition cursor-pointer">
                                    <i class="fas fa-trash-alt mr-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="border-2 border-dashed border-gray-400 bg-white p-12 text-center text-gray-500">
                    <i class="fas fa-bullhorn text-3xl mb-3 text-gray-400"></i>
                    <p class="text-base font-bold">Belum ada pengumuman yang dibuat.</p>
                    <p class="text-sm mt-1 text-gray-500">Klik tombol "Buat Pengumuman Baru" di atas untuk menambahkan pengumuman pertama.</p>
                </div>
            @endforelse
        </div>

        <div>
            {{ $announcements->links() }}
        </div>

        {{-- ═════════ MODAL: TAMBAH PENGUMUMAN ═════════ --}}
        <div x-show="createModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-950/80 backdrop-blur-sm p-4 overflow-y-auto"
            @keydown.escape.window="createModalOpen = false">
            <div class="relative w-full max-w-2xl border-4 border-gray-950 bg-white p-6 sm:p-8 shadow-2xl" @click.away="createModalOpen = false">
                <div class="flex items-start justify-between border-b-2 border-gray-950 pb-4">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-emerald-700">Formulir</p>
                        <h2 class="text-2xl font-black text-gray-950">Buat Pengumuman Baru</h2>
                    </div>
                    <button type="button" @click="createModalOpen = false" class="text-gray-500 hover:text-gray-950 text-xl font-bold cursor-pointer">
                        &times;
                    </button>
                </div>

                <form action="{{ route('admin_hackaton.announcements.store') }}" method="POST" class="mt-6 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-gray-950 mb-1.5">
                            Judul Pengumuman <span class="text-red-700">*</span>
                        </label>
                        <input type="text" name="title" required value="{{ old('title') }}"
                            class="w-full border-2 border-gray-950 bg-white px-4 py-2.5 text-sm text-gray-950 focus:border-emerald-700 focus:outline-none"
                            placeholder="Contoh: Jadwal Presentasi Tahap 2 Dimulai">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-gray-950 mb-1.5">
                                Kategori / Tipe <span class="text-red-700">*</span>
                            </label>
                            <select name="type" required
                                class="w-full border-2 border-gray-950 bg-white px-4 py-2.5 text-sm text-gray-950 focus:border-emerald-700 focus:outline-none">
                                <option value="info">Informasi (Hijau)</option>
                                <option value="penting">Penting (Kuning/Amber)</option>
                                <option value="urgent">Mendesak / Urgent (Merah)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-gray-950 mb-1.5">
                                Status Publikasi
                            </label>
                            <select name="is_active"
                                class="w-full border-2 border-gray-950 bg-white px-4 py-2.5 text-sm text-gray-950 focus:border-emerald-700 focus:outline-none">
                                <option value="1">Langsung Aktif (Tayang)</option>
                                <option value="0">Simpan sebagai Draf (Nonaktif)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-gray-950 mb-1.5">
                            Isi Pengumuman <span class="text-red-700">*</span>
                        </label>
                        <textarea name="content" rows="4" required
                            class="w-full border-2 border-gray-950 bg-white px-4 py-2.5 text-sm text-gray-950 focus:border-emerald-700 focus:outline-none"
                            placeholder="Tuliskan isi pengumuman atau instruksi lengkap untuk peserta...">{{ old('content') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-gray-950 mb-1.5">
                                Tautan Lampiran / URL (Opsional)
                            </label>
                            <input type="url" name="link_url" value="{{ old('link_url') }}"
                                class="w-full border-2 border-gray-950 bg-white px-4 py-2.5 text-sm text-gray-950 focus:border-emerald-700 focus:outline-none"
                                placeholder="https://...">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-gray-950 mb-1.5">
                                Teks Tombol Tautan (Opsional)
                            </label>
                            <input type="text" name="link_text" value="{{ old('link_text') }}"
                                class="w-full border-2 border-gray-950 bg-white px-4 py-2.5 text-sm text-gray-950 focus:border-emerald-700 focus:outline-none"
                                placeholder="Contoh: Buka Panduan / Link Zoom">
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
                        <button type="button" @click="createModalOpen = false"
                            class="border-2 border-gray-950 bg-white px-5 py-2.5 text-xs font-black uppercase tracking-wider text-gray-950 hover:bg-gray-100">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-emerald-700 px-6 py-2.5 text-xs font-black uppercase tracking-wider text-white hover:bg-emerald-800">
                            Terbitkan Pengumuman
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ═════════ MODAL: EDIT PENGUMUMAN ═════════ --}}
        <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-950/80 backdrop-blur-sm p-4 overflow-y-auto"
            @keydown.escape.window="editModalOpen = false">
            <div class="relative w-full max-w-2xl border-4 border-gray-950 bg-white p-6 sm:p-8 shadow-2xl" @click.away="editModalOpen = false">
                <div class="flex items-start justify-between border-b-2 border-gray-950 pb-4">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-emerald-700">Perbarui Data</p>
                        <h2 class="text-2xl font-black text-gray-950">Edit Pengumuman</h2>
                    </div>
                    <button type="button" @click="editModalOpen = false" class="text-gray-500 hover:text-gray-950 text-xl font-bold cursor-pointer">
                        &times;
                    </button>
                </div>

                <form :action="'{{ url('admin-hackathon/announcements') }}/' + editItem.id" method="POST" class="mt-6 space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-gray-950 mb-1.5">
                            Judul Pengumuman <span class="text-red-700">*</span>
                        </label>
                        <input type="text" name="title" required x-model="editItem.title"
                            class="w-full border-2 border-gray-950 bg-white px-4 py-2.5 text-sm text-gray-950 focus:border-emerald-700 focus:outline-none">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-gray-950 mb-1.5">
                                Kategori / Tipe <span class="text-red-700">*</span>
                            </label>
                            <select name="type" required x-model="editItem.type"
                                class="w-full border-2 border-gray-950 bg-white px-4 py-2.5 text-sm text-gray-950 focus:border-emerald-700 focus:outline-none">
                                <option value="info">Informasi (Hijau)</option>
                                <option value="penting">Penting (Kuning/Amber)</option>
                                <option value="urgent">Mendesak / Urgent (Merah)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-gray-950 mb-1.5">
                                Status Publikasi
                            </label>
                            <select name="is_active" :value="editItem.is_active ? '1' : '0'"
                                class="w-full border-2 border-gray-950 bg-white px-4 py-2.5 text-sm text-gray-950 focus:border-emerald-700 focus:outline-none">
                                <option value="1">Aktif (Tayang)</option>
                                <option value="0">Nonaktif (Draf)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-gray-950 mb-1.5">
                            Isi Pengumuman <span class="text-red-700">*</span>
                        </label>
                        <textarea name="content" rows="4" required x-model="editItem.content"
                            class="w-full border-2 border-gray-950 bg-white px-4 py-2.5 text-sm text-gray-950 focus:border-emerald-700 focus:outline-none"></textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-gray-950 mb-1.5">
                                Tautan Lampiran / URL (Opsional)
                            </label>
                            <input type="url" name="link_url" x-model="editItem.link_url"
                                class="w-full border-2 border-gray-950 bg-white px-4 py-2.5 text-sm text-gray-950 focus:border-emerald-700 focus:outline-none"
                                placeholder="https://...">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-gray-950 mb-1.5">
                                Teks Tombol Tautan (Opsional)
                            </label>
                            <input type="text" name="link_text" x-model="editItem.link_text"
                                class="w-full border-2 border-gray-950 bg-white px-4 py-2.5 text-sm text-gray-950 focus:border-emerald-700 focus:outline-none"
                                placeholder="Contoh: Buka Panduan / Link Zoom">
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
                        <button type="button" @click="editModalOpen = false"
                            class="border-2 border-gray-950 bg-white px-5 py-2.5 text-xs font-black uppercase tracking-wider text-gray-950 hover:bg-gray-100">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-emerald-700 px-6 py-2.5 text-xs font-black uppercase tracking-wider text-white hover:bg-emerald-800">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
