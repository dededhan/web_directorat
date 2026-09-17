@extends('subdirektorat-inovasi.hackaton.layout')

@section('title', 'Identitas Tim & Anggota | Hackaton UNJ')

@section('content_hackaton')
    <div class="max-w-4xl mx-auto space-y-6" x-data="identitasManager()">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-200 pb-5">
            <div>
                <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                    <a href="{{ route('hackaton.submissions.index') }}" class="hover:text-amber-600">Proposal Saya</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <a href="{{ route('hackaton.submissions.show', $submission) }}" class="hover:text-amber-600">Detail</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span class="text-gray-800 font-medium">Identitas Tim & Anggota</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">Identitas Tim &amp; Anggota</h1>
                <p class="mt-1 text-xs text-gray-500">Sesi: <strong>{{ $submission->session->nama_sesi }}</strong></p>
            </div>
            <a href="{{ route('hackaton.submissions.show', $submission) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-xs font-semibold rounded-xl text-gray-700 hover:bg-gray-50 transition shadow-sm">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke Proposal
            </a>
        </div>

        {{-- Gate Status Alert --}}
        @if ($submission->identitasIsComplete())
            <div class="p-4 bg-emerald-50 border border-emerald-300 text-emerald-800 rounded-2xl text-xs flex items-center gap-3">
                <i class="fas fa-check-circle text-lg text-emerald-600"></i>
                <div>
                    <p class="font-bold">Identitas Tim & Anggota telah lengkap!</p>
                    <p class="text-emerald-700">Akses untuk mengisi Tahap 1 sudah terbuka.</p>
                </div>
            </div>
        @else
            <div class="p-4 bg-amber-50 border border-amber-300 text-amber-900 rounded-2xl text-xs flex items-center gap-3">
                <i class="fas fa-exclamation-triangle text-lg text-amber-600"></i>
                <div>
                    <p class="font-bold">Identitas Tim Belum Lengkap</p>
                    <p class="text-amber-800">Mohon lengkapi data produk di bawah dan undang minimal 1 anggota tim (Hacker/Hustler/Hipster) untuk membuka akses pengisian Tahap 1.</p>
                </div>
            </div>
        @endif

        {{-- ═════ BAGIAN A: FORM IDENTITAS PRODUK ═════ --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 sm:p-8 shadow-sm space-y-6">
            <div class="border-b border-gray-100 pb-4 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-id-card text-amber-500"></i> Data Produk & Inovasi
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Informasi umum ide, prototipe, atau karya inovasi yang diajukan.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('hackaton.submissions.identitas.save', $submission) }}" class="space-y-4 text-xs">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block font-bold text-gray-700 mb-1">Tema Inovasi Hackaton <span class="text-rose-600">*</span></label>
                        <select name="tema" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500 font-semibold bg-amber-50/40">
                            <option value="D-FARM (DeepTech Food Acceleration Research to Market)" {{ old('tema', $submission->tema) === 'D-FARM (DeepTech Food Acceleration Research to Market)' ? 'selected' : '' }}>
                                D-FARM (DeepTech Food Acceleration Research to Market)
                            </option>
                            <option value="D-MARC (DeepTack Medical Acceleraton Research to Challenge)" {{ old('tema', $submission->tema) === 'D-MARC (DeepTack Medical Acceleraton Research to Challenge)' ? 'selected' : '' }}>
                                D-MARC (DeepTack Medical Acceleraton Research to Challenge)
                            </option>
                        </select>
                        <p class="text-[11px] text-gray-500 mt-1">Fokus tema yang Anda pilih saat mendaftarkan proposal.</p>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block font-bold text-gray-700 mb-1">Nama Produk / Karya Inovasi <span class="text-rose-600">*</span></label>
                        <input type="text" name="nama_produk" value="{{ old('nama_produk', $submission->identitas?->nama_produk) }}" required
                            class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500"
                            placeholder="Contoh: Aplikasi Sistem Deteksi Dini Bencana Berbasis IoT">
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Ketua Tim (Pengusul)</label>
                        <input type="text" value="{{ $ketuaName ?? $submission->user?->name ?? 'Ketua' }}" disabled class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-600 font-semibold">
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Fakultas / Program Studi</label>
                        <input type="text" value="{{ $fakultasName ?? '-' }} / {{ $prodiName ?? '-' }}" disabled class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-600">
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Skema Hackaton <span class="text-rose-600">*</span></label>
                        <select name="skema_inovasi" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500 font-medium">
                            <option value="">— Pilih Skema Inovasi —</option>
                            @foreach ($skemaOptions ?? ['Hilirisasi Produk Riset Inovasi', 'Hilirisasi Produk Kolaborasi Dosen dan Alumni', 'Hibah Komersialisasi Produk / Jasa Kepakaran Dosen (Income generating)', 'Kolaborasi DUDI (Industri)'] as $skema)
                                <option value="{{ $skema }}" {{ old('skema_inovasi', $submission->identitas?->skema_inovasi) === $skema ? 'selected' : '' }}>
                                    {{ $skema }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Bidang Utama Produk <span class="text-rose-600">*</span></label>
                        <input type="text" name="bidang_utama_produk" value="{{ old('bidang_utama_produk', $submission->identitas?->bidang_utama_produk) }}" required
                            class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500"
                            placeholder="Contoh: Teknologi Informasi & Kecerdasan Buatan">
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-gray-900 font-bold rounded-xl text-xs uppercase tracking-wider transition shadow-sm">
                        <i class="fas fa-save mr-1.5"></i> Simpan Identitas Produk
                    </button>
                </div>
            </form>
        </div>

        {{-- ═════ BAGIAN B: ANGGOTA TIM (HACKER, HUSTLER, HIPSTER) ═════ --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 sm:p-8 shadow-sm space-y-6">
            <div class="border-b border-gray-100 pb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <h2 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-users text-amber-500"></i> Anggota Tim Hackaton
                        <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-gray-100 text-gray-700">
                            {{ $currentCount ?? $submission->members->count() }} / {{ $maxAnggota ?? ($submission->session?->max_anggota ?? 4) }} Orang
                        </span>
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Komposisi tim ideal mencakup peran: <strong>Hacker</strong> (Teknis), <strong>Hustler</strong> (Bisnis), dan <strong>Hipster</strong> (Desain).
                    </p>
                </div>

                @if (($currentCount ?? $submission->members->count()) < ($maxAnggota ?? ($submission->session?->max_anggota ?? 4)))
                    <button type="button" @click="showAddMemberForm = !showAddMemberForm"
                        class="inline-flex items-center px-4 py-2 bg-gray-900 text-white font-bold text-xs rounded-xl hover:bg-gray-800 transition">
                        <i class="fas fa-user-plus mr-1.5"></i> Tambah Anggota
                    </button>
                @endif
            </div>

            {{-- Form Tambah Anggota dengan Autocomplete --}}
            <div x-show="showAddMemberForm" x-cloak class="p-6 bg-amber-50/70 border border-amber-200 rounded-2xl space-y-4 text-xs">
                <h3 class="font-bold text-gray-900 uppercase tracking-wider text-xs">Tambah Anggota Tim Baru</h3>

                <form method="POST" action="{{ route('hackaton.members.store', $submission) }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="user_id" x-model="selectedUserId">

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Tipe Anggota *</label>
                            <select name="tipe_anggota" x-model="memberType" @change="resetSearch()" required
                                class="w-full rounded-xl border border-gray-300 px-3 py-2 bg-white text-sm">
                                <option value="mahasiswa">Mahasiswa</option>
                                <option value="dosen">Dosen</option>
                                <option value="DUDI">Mitra DUDI (Industri)</option>
                                <option value="alumni">Alumni</option>
                                <option value="tendik">Tendik</option>
                                <option value="peneliti">Peneliti</option>
                                <option value="PPPK">PPPK</option>
                            </select>
                        </div>

                        {{-- Search Autocomplete Input --}}
                        <div class="sm:col-span-2 relative">
                            <label class="block font-bold text-gray-700 mb-1">Cari Akun Pengguna (Nama atau Email)</label>
                            <input type="text" x-model="searchQuery" @input.debounce.300ms="searchUsers()"
                                placeholder="Ketik minimal 2 huruf untuk mencari akun..."
                                class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-1 focus:ring-amber-500">

                            {{-- Autocomplete Dropdown --}}
                            <div x-show="searchResults.length > 0" x-cloak
                                class="absolute z-20 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg max-h-48 overflow-y-auto divide-y divide-gray-100">
                                <template x-for="usr in searchResults" :key="usr.id">
                                    <div @click="selectUser(usr)" class="p-2.5 hover:bg-amber-50 cursor-pointer transition text-xs">
                                        <p class="font-bold text-gray-900" x-text="usr.name"></p>
                                        <p class="text-gray-500 text-[11px]" x-text="usr.email + (usr.institusi_fakultas ? ' • ' + usr.institusi_fakultas : '')"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Nama Lengkap *</label>
                            <input type="text" name="nama_lengkap" x-model="selectedName" required
                                class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm bg-white">
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 mb-1">NIM / NIP / NIK *</label>
                            <input type="text" name="nik_nim_nip" x-model="selectedIdentifier" required
                                class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm bg-white">
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Fakultas / Instansi</label>
                            <input type="text" name="institusi_fakultas" x-model="selectedInstitusi"
                                class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm bg-white">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Peran IC *</label>
                            <select name="peran_ic" required class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm bg-white">
                                <option value="Hacker">Hacker (Teknologi & Produk)</option>
                                <option value="Hustler">Hustler (Bisnis, Model & Pasar)</option>
                                <option value="Hipster">Hipster (Desain, Branding & UI/UX)</option>
                            </select>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block font-bold text-gray-700 mb-1">Deskripsi Tugas Spesifik Anggota *</label>
                            <input type="text" name="deskripsi_peran" required
                                placeholder="Contoh: Bertanggung jawab merancang prototipe mobile app..."
                                class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm bg-white">
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="showAddMemberForm = false" class="px-4 py-2 font-bold text-gray-600 hover:text-black">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 bg-amber-500 hover:bg-amber-600 text-gray-900 font-bold rounded-xl uppercase tracking-wider text-xs transition shadow-sm">
                            Undang / Tambah Anggota
                        </button>
                    </div>
                </form>
            </div>

            {{-- Daftar Anggota Saat Ini --}}
            <div class="divide-y divide-gray-100 text-xs">
                @foreach ($submission->members as $member)
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-gray-900 text-sm">{{ $member->nama_lengkap }}</span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $member->peran === 'Ketua' ? 'bg-amber-100 text-amber-900' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $member->peran }}
                                </span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-purple-100 text-purple-900">
                                    {{ $member->peran_ic }}
                                </span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] bg-blue-50 text-blue-800">
                                    {{ $member->getTipeLabel() }}
                                </span>
                            </div>
                            <p class="text-gray-500">
                                {{ $member->nik_nim_nip ?? '-' }} • {{ $member->institusi_fakultas ?? '-' }}
                                @if ($member->deskripsi_peran) — <span class="text-gray-700 italic">{{ $member->deskripsi_peran }}</span>@endif
                            </p>
                        </div>

                        <div class="flex items-center gap-3 shrink-0">
                            @php
                                $badge = $member->getApprovalBadge();
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $badge['color'] }}">
                                <i class="{{ $badge['icon'] }} mr-1"></i> {{ $badge['label'] }}
                            </span>

                            @if ($member->peran !== 'Ketua' && $member->approval_status !== 'approved')
                                <form action="{{ route('hackaton.members.destroy', [$submission, $member]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus anggota ini dari tim?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 p-1" title="Hapus Anggota">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function identitasManager() {
            return {
                showAddMemberForm: false,
                memberType: 'mahasiswa',
                searchQuery: '',
                searchResults: [],
                selectedUserId: null,
                selectedName: '',
                selectedIdentifier: '',
                selectedInstitusi: '',
                resetSearch() {
                    this.searchQuery = '';
                    this.searchResults = [];
                    this.selectedUserId = null;
                },
                async searchUsers() {
                    if (this.searchQuery.length < 2) {
                        this.searchResults = [];
                        return;
                    }
                    try {
                        const res = await fetch(`{{ route('hackaton.members.search') }}?q=${encodeURIComponent(this.searchQuery)}&tipe=${encodeURIComponent(this.memberType)}`);
                        this.searchResults = await res.json();
                    } catch (e) {
                        this.searchResults = [];
                    }
                },
                selectUser(u) {
                    this.selectedUserId = u.id;
                    this.selectedName = u.name;
                    this.selectedIdentifier = u.identifier_number || '';
                    this.selectedInstitusi = u.institusi_fakultas || '';
                    this.searchQuery = u.name;
                    this.searchResults = [];
                }
            }
        }
    </script>
@endsection
