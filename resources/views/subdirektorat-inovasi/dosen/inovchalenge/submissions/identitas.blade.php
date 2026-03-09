@extends('subdirektorat-inovasi.dosen.index')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Identitas Tim &amp; Status Produk</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ $submission->session->nama_sesi }}</p>
                </div>
                <a href="{{ route('subdirektorat-inovasi.dosen.inovchalenge.submissions.show', $submission) }}"
                    class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-medium text-sm rounded-xl hover:bg-gray-200 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            {{-- Flash messages --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
                </div>
            @endif

            {{-- Completion status banner --}}
            @if ($submission->identitasIsComplete())
                <div
                    class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm flex items-center gap-2">
                    <i class="fas fa-check-circle text-base"></i>
                    <span class="font-semibold">Identitas Tim sudah lengkap.</span>
                    <span>Anda dapat mengisi tahap-tahap selanjutnya.</span>
                </div>
            @else
                <div
                    class="mb-6 p-4 bg-orange-50 border border-orange-200 text-orange-700 rounded-xl text-sm flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle text-base"></i>
                    <span class="font-semibold">Identitas Tim belum lengkap.</span>
                    <span>Lengkapi semua field dan tambahkan minimal 1 anggota non-Ketua untuk membuka akses tahap.</span>
                </div>
            @endif

            {{-- ═══════════════════ SECTION A: IDENTITAS FORM ═══════════════════ --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-teal-500 to-teal-600">
                    <h2 class="text-lg font-bold text-white">
                        <i class="fas fa-id-card mr-2"></i>Identitas Tim &amp; Produk
                    </h2>
                </div>
                <div class="p-6">
                    <form method="POST"
                        action="{{ route('subdirektorat-inovasi.dosen.inovchalenge.submissions.identitas.save', $submission) }}">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                            {{-- Nama Produk --}}
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-gray-600 mb-1">
                                    Nama Produk <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_produk"
                                    value="{{ old('nama_produk', $submission->identitas?->nama_produk) }}" required
                                    class="w-full rounded-lg border-gray-300 text-sm focus:border-teal-500 focus:ring-teal-500
                                           @error('nama_produk') border-red-400 @enderror"
                                    placeholder="Nama produk inovasi Anda">
                                @error('nama_produk')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Nama Ketua (read-only) --}}
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Ketua Tim</label>
                                <div
                                    class="w-full rounded-lg border border-gray-200 bg-gray-50 text-sm px-3 py-2 text-gray-700">
                                    {{ $ketuaName }}
                                </div>
                            </div>

                            {{-- Fakultas (read-only) --}}
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Fakultas</label>
                                <div
                                    class="w-full rounded-lg border border-gray-200 bg-gray-50 text-sm px-3 py-2 text-gray-700">
                                    {{ $fakultasName }}
                                </div>
                            </div>

                            {{-- Prodi (read-only) --}}
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Program Studi</label>
                                <div
                                    class="w-full rounded-lg border border-gray-200 bg-gray-50 text-sm px-3 py-2 text-gray-700">
                                    {{ $prodiName }}
                                </div>
                            </div>

                            {{-- Skema Inovasi --}}
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-gray-600 mb-1">
                                    Skema Inovasi <span class="text-red-500">*</span>
                                </label>
                                <select name="skema_inovasi" required
                                    class="w-full rounded-lg border-gray-300 text-sm focus:border-teal-500 focus:ring-teal-500
                                           @error('skema_inovasi') border-red-400 @enderror">
                                    <option value="">-- Pilih Skema --</option>
                                    @foreach ($skemaOptions as $skema)
                                        <option value="{{ $skema }}"
                                            {{ old('skema_inovasi', $submission->identitas?->skema_inovasi) === $skema ? 'selected' : '' }}>
                                            {{ $skema }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('skema_inovasi')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Bidang Utama Produk --}}
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-gray-600 mb-1">
                                    Bidang Utama Produk <span class="text-red-500">*</span>
                                </label>
                                <select name="bidang_utama_produk" required
                                    class="w-full rounded-lg border-gray-300 text-sm focus:border-teal-500 focus:ring-teal-500
                                           @error('bidang_utama_produk') border-red-400 @enderror">
                                    <option value="">-- Pilih bidang --</option>
                                    @foreach (['Pangan', 'Kesehatan', 'Pendidikan', 'Energi', 'Lingkungan', 'Instrumentasi / IoT', 'AI / Software', 'Material', 'Lainnya'] as $bidang)
                                        <option value="{{ $bidang }}"
                                            {{ old('bidang_utama_produk', $submission->identitas?->bidang_utama_produk) === $bidang ? 'selected' : '' }}>
                                            {{ $bidang }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bidang_utama_produk')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-5 py-2.5 bg-teal-500 text-white text-sm font-semibold rounded-xl hover:bg-teal-600 transition shadow-sm">
                                <i class="fas fa-save mr-2"></i> Simpan Identitas
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ═══════════════════ SECTION B: ANGGOTA TIM ═══════════════════ --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6" x-data="memberManager()">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-indigo-500 to-indigo-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-bold text-white"><i class="fas fa-users mr-2"></i>Anggota Tim</h2>
                            <p class="text-indigo-100 text-xs mt-0.5">Minimal {{ $minAnggota }} orang, maksimal
                                {{ $maxAnggota }} orang (termasuk Ketua).</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold
                                {{ $currentCount >= $minAnggota ? 'bg-green-500/20 text-green-100' : 'bg-yellow-500/20 text-yellow-100' }}">
                                <i
                                    class="fas {{ $currentCount >= $minAnggota ? 'fa-check-circle' : 'fa-exclamation-circle' }} mr-1 text-[10px]"></i>
                                {{ $currentCount }}/{{ $maxAnggota }} anggota
                            </span>
                        </div>
                    </div>
                    @if ($currentCount < $minAnggota)
                        <div class="mt-2 flex items-center gap-1.5 text-yellow-200 text-[11px]">
                            <i class="fas fa-info-circle"></i>
                            <span>Tambahkan minimal {{ $minAnggota - $currentCount }} anggota lagi untuk memenuhi syarat
                                minimum.</span>
                        </div>
                    @endif
                </div>
                <div class="p-6">
                    {{-- Member list --}}
                    <div class="divide-y divide-gray-100 mb-6">
                        @forelse($submission->members as $member)
                            <div class="flex items-center justify-between py-3">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr($member->nama_lengkap, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $member->nama_lengkap }}</p>
                                        <div class="flex flex-wrap items-center gap-x-2 gap-y-0.5 mt-0.5">
                                            <span class="text-[10px] text-gray-400">{{ $member->getTipeLabel() }}</span>
                                            @if ($member->peran_ic)
                                                <span
                                                    class="inline-flex items-center px-1.5 py-0 rounded text-[9px] font-bold bg-teal-100 text-teal-700">
                                                    <i class="fas fa-tag mr-0.5 text-[7px]"></i> {{ $member->peran_ic }}
                                                </span>
                                            @endif
                                            @if ($member->nik_nim_nip)
                                                <span class="text-[10px] text-gray-400">· NIM/NIP/NIK/NIDN:
                                                    {{ $member->nik_nim_nip }}</span>
                                            @elseif($member->user?->profile?->identifier_number)
                                                <span class="text-[10px] text-gray-400">· NIM/NIP/NIK/NIDN:
                                                    {{ $member->user->profile->identifier_number }}</span>
                                            @endif
                                            @if ($member->tipe_anggota === 'DUDI' && $member->user?->profile?->institusi)
                                                <span class="text-[10px] text-gray-400">·
                                                    {{ $member->user->profile->institusi }}</span>
                                            @elseif ($member->user?->profile?->fakultas)
                                                <span class="text-[10px] text-gray-400">·
                                                    {{ $member->user->profile->fakultas->name }}</span>
                                                @if ($member->user?->profile?->prodi)
                                                    <span class="text-[10px] text-gray-400">/
                                                        {{ $member->user->profile->prodi->name }}</span>
                                                @endif
                                            @elseif ($member->institusi_fakultas)
                                                <span class="text-[10px] text-gray-400">·
                                                    {{ $member->institusi_fakultas }}</span>
                                            @endif
                                        </div>
                                        @if ($member->deskripsi_peran)
                                            <p class="text-[10px] text-gray-500 mt-1 italic">
                                                <i class="fas fa-quote-left text-[7px] mr-0.5 text-gray-300"></i>
                                                {{ $member->deskripsi_peran }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if ($member->peran === 'Ketua')
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-indigo-100 text-indigo-700">
                                            <i class="fas fa-crown mr-1 text-[9px]"></i> Ketua
                                        </span>
                                    @else
                                        {{-- Show approval badge for all members --}}
                                        @php $badge = $member->getApprovalBadge(); @endphp
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $badge['color'] }}">
                                            <i class="{{ $badge['icon'] }} mr-1 text-[9px]"></i>
                                            {{ $badge['label'] }}
                                        </span>
                                        <form method="POST"
                                            action="{{ route('subdirektorat-inovasi.dosen.inovchalenge.members.destroy', [$submission, $member]) }}"
                                            onsubmit="return confirm('Hapus anggota ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-600 text-xs p-1"
                                                title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 py-4 text-center">Belum ada anggota selain ketua.</p>
                        @endforelse
                    </div>

                    {{-- Add member form --}}
                    <div class="border-t border-gray-100 pt-6">
                        @if ($currentCount >= $maxAnggota)
                            <div
                                class="flex items-center gap-2 text-sm text-gray-500 bg-gray-50 rounded-xl px-4 py-3 border border-gray-200">
                                <i class="fas fa-info-circle text-gray-400"></i>
                                <span>Jumlah anggota sudah mencapai batas maksimal (<strong>{{ $maxAnggota }}</strong>
                                    orang).</span>
                            </div>
                        @else
                            <h3 class="text-sm font-bold text-gray-700 mb-4">
                                <i class="fas fa-user-plus mr-1.5 text-indigo-500"></i>Tambah Anggota
                                <span class="text-gray-400 font-normal text-xs ml-1">(sisa
                                    {{ $maxAnggota - $currentCount }} slot)</span>
                            </h3>
                            <form method="POST"
                                action="{{ route('subdirektorat-inovasi.dosen.inovchalenge.members.store', $submission) }}">
                                @csrf
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">
                                            Tipe Anggota <span class="text-red-500">*</span>
                                        </label>
                                        <select name="tipe_anggota" x-model="tipeAnggota" @change="onTipeChange()"
                                            class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            required>
                                            <option value="">-- Pilih --</option>
                                            <option value="dosen">Dosen</option>
                                            <option value="alumni">Alumni</option>
                                            <option value="peneliti">Peneliti</option>
                                            <option value="mahasiswa">Mahasiswa</option>
                                            <option value="DUDI">DUDI</option>
                                            <option value="PPPK">PPPK</option>
                                        </select>
                                        <p x-show="tipeAnggota && tipeAnggota !== 'dosen'"
                                            class="mt-1 text-[10px] text-amber-600">
                                            <i class="fas fa-info-circle mr-0.5"></i>
                                            <span
                                                x-text="tipeAnggota === 'dosen' ? '' : 'Anggota tipe ini memerlukan persetujuan (approval)'"></span>
                                        </p>
                                    </div>

                                    {{-- User search for all registered types --}}
                                    <div
                                        x-show="['dosen','alumni','mahasiswa','peneliti','DUDI','PPPK'].includes(tipeAnggota)">
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Cari User</label>
                                        <div class="relative">
                                            <input type="text" x-model="searchQuery"
                                                @input.debounce.300ms="searchUser()"
                                                placeholder="Ketik nama atau email..."
                                                class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            {{-- Dropdown results --}}
                                            <div x-show="searchResults.length > 0"
                                                class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg max-h-48 overflow-auto">
                                                <template x-for="user in searchResults" :key="user.id">
                                                    <div @click="selectUser(user)"
                                                        class="px-3 py-2 hover:bg-indigo-50 cursor-pointer text-sm border-b border-gray-50">
                                                        <p class="font-medium text-gray-800" x-text="user.name"></p>
                                                        <p class="text-xs text-gray-400" x-text="user.email"></p>
                                                        <div class="flex flex-wrap gap-2 mt-0.5">
                                                            <span x-show="user.identifier_number"
                                                                class="text-[10px] text-indigo-500 bg-indigo-50 px-1.5 py-0.5 rounded"
                                                                x-text="'ID: ' + user.identifier_number"></span>
                                                            <span x-show="user.fakultas"
                                                                class="text-[10px] text-teal-600 bg-teal-50 px-1.5 py-0.5 rounded"
                                                                x-text="user.fakultas"></span>
                                                            <span x-show="user.prodi"
                                                                class="text-[10px] text-purple-600 bg-purple-50 px-1.5 py-0.5 rounded"
                                                                x-text="user.prodi"></span>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                        <input type="hidden" name="user_id" x-model="selectedUserId">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">
                                            Nama Lengkap <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="nama_lengkap" x-model="namaLengkap" required
                                            class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">
                                            NIM/NIP/NIK/NIDN <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="nik_nim_nip" x-model="nikNimNip" required
                                            class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            placeholder="Wajib diisi">
                                    </div>

                                    {{-- Fakultas & Prodi (auto-filled for dosen/alumni, manual for others) --}}
                                    <template x-if="tipeAnggota === 'dosen' || tipeAnggota === 'alumni'">
                                        <div class="sm:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label
                                                    class="block text-xs font-semibold text-gray-600 mb-1">Fakultas</label>
                                                <input type="text" x-model="selectedFakultas" readonly
                                                    class="w-full rounded-lg border-gray-300 bg-gray-50 text-sm cursor-not-allowed"
                                                    placeholder="Otomatis dari profil">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Program
                                                    Studi</label>
                                                <input type="text" x-model="selectedProdi" readonly
                                                    class="w-full rounded-lg border-gray-300 bg-gray-50 text-sm cursor-not-allowed"
                                                    placeholder="Otomatis dari profil">
                                            </div>
                                            <input type="hidden" name="institusi_fakultas" x-model="institusiFakultas">
                                        </div>
                                    </template>
                                    <template x-if="tipeAnggota !== 'dosen' && tipeAnggota !== 'alumni'">
                                        <div>
                                            <label
                                                class="block text-xs font-semibold text-gray-600 mb-1">Institusi/Fakultas</label>
                                            <input type="text" name="institusi_fakultas" x-model="institusiFakultas"
                                                class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                placeholder="Opsional">
                                        </div>
                                    </template>

                                    {{-- Peran IC (Hacker / Hustler / Hipster) --}}
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">
                                            Peran <span class="text-red-500">*</span>
                                        </label>
                                        <select name="peran_ic" required
                                            class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">-- Pilih Peran --</option>
                                            <option value="Hacker">Hacker</option>
                                            <option value="Hustler">Hustler</option>
                                            <option value="Hipster">Hipster</option>
                                        </select>
                                    </div>

                                    {{-- Deskripsi Peran --}}
                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">
                                            Deskripsi Peran <span class="text-red-500">*</span>
                                        </label>
                                        <textarea name="deskripsi_peran" required rows="2"
                                            class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            placeholder="Jelaskan peran anggota dalam tim..."></textarea>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-500 text-white text-sm font-medium rounded-lg hover:bg-indigo-600 transition">
                                        <i class="fas fa-plus mr-1.5"></i> Tambah Anggota
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function memberManager() {
            return {
                tipeAnggota: '',
                searchQuery: '',
                searchResults: [],
                selectedUserId: '',
                namaLengkap: '',
                nikNimNip: '',
                institusiFakultas: '',
                selectedFakultas: '',
                selectedProdi: '',

                onTipeChange() {
                    this.searchQuery = '';
                    this.searchResults = [];
                    this.selectedUserId = '';
                    this.namaLengkap = '';
                    this.nikNimNip = '';
                    this.institusiFakultas = '';
                    this.selectedFakultas = '';
                    this.selectedProdi = '';
                },

                async searchUser() {
                    if (this.searchQuery.length < 2) {
                        this.searchResults = [];
                        return;
                    }
                    try {
                        const res = await fetch(
                            `{{ route('subdirektorat-inovasi.dosen.inovchalenge.members.search') }}?q=${encodeURIComponent(this.searchQuery)}&type=${this.tipeAnggota}`
                        );
                        this.searchResults = await res.json();
                    } catch (e) {
                        this.searchResults = [];
                    }
                },

                selectUser(user) {
                    this.selectedUserId = user.id;
                    this.namaLengkap = user.name;
                    this.nikNimNip = user.identifier_number || '';
                    // Separate fakultas & prodi
                    this.selectedFakultas = user.fakultas || '';
                    this.selectedProdi = user.prodi || '';
                    // Also set combined for hidden input
                    let inst = user.fakultas || '';
                    if (user.prodi) {
                        inst = inst ? inst + ' / ' + user.prodi : user.prodi;
                    }
                    this.institusiFakultas = inst;
                    this.searchQuery = user.name + ' (' + user.email + ')';
                    this.searchResults = [];
                }
            };
        }
    </script>
@endpush
