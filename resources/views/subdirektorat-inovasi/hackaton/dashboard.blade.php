@extends('subdirektorat-inovasi.hackaton.layout')

@section('title', 'Dashboard ' . $roleLabel . ' | Hackaton UNJ')

@section('content_hackaton')
    <div class="space-y-6" x-data="{ activeTab: '{{ $pendingInvitations->count() > 0 ? 'participations' : 'biodata' }}' }">
        {{-- Hero Welcome Banner --}}
        <section class="border-b-4 border-gray-950 pb-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="mb-3 text-sm font-black uppercase tracking-[0.18em] text-emerald-700">Program HackAthon UNJ</p>
                    <h1 class="text-4xl font-black leading-tight text-gray-950 sm:text-5xl">Halo, {{ $user->name }}.</h1>
                    <p class="mt-3 max-w-2xl text-lg text-gray-700">Selamat datang di dashboard {{ $isReviewer ? 'reviewer' : 'peserta dan kolaborator' }} HackAthon. Role Anda: <strong class="text-gray-950">{{ $roleLabel }}</strong>.</p>
                </div>

                {{-- Action Quick Button --}}
                @if ($isPengusul)
                    <a href="{{ route('hackaton.sessions.index') }}" class="inline-flex min-h-12 items-center justify-center bg-emerald-700 px-6 py-3 text-base font-black text-white hover:bg-emerald-800">Daftar Sesi Baru <span aria-hidden="true" class="ml-2">→</span></a>
                @elseif ($isReviewer)
                    <a href="{{ route('hackaton.reviewer.assignments.index') }}" class="inline-flex min-h-12 items-center justify-center bg-emerald-700 px-6 py-3 text-base font-black text-white hover:bg-emerald-800">Mulai Penilaian <span aria-hidden="true" class="ml-2">→</span></a>
                @endif
            </div>
        </section>

        {{-- Navigation Tabs --}}
        <div class="border-b border-gray-200 flex flex-wrap gap-2">
            <button type="button" @click="activeTab = 'biodata'"
                class="px-5 py-3 text-xs font-bold uppercase tracking-wider border-b-2 transition flex items-center gap-2"
                :class="activeTab === 'biodata' ? 'border-amber-500 text-amber-600 bg-white rounded-t-xl' : 'border-transparent text-gray-500 hover:text-gray-900'">
                <i class="fas fa-id-card"></i> Biodata & Profil
            </button>

            <button type="button" @click="activeTab = 'participations'"
                class="px-5 py-3 text-xs font-bold uppercase tracking-wider border-b-2 transition flex items-center gap-2 relative"
                :class="activeTab === 'participations' ? 'border-amber-500 text-amber-600 bg-white rounded-t-xl' : 'border-transparent text-gray-500 hover:text-gray-900'">
                <i class="fas fa-users"></i> Undangan & Tim Saya
                @if ($pendingInvitations->count() > 0)
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-500 text-white">
                        {{ $pendingInvitations->count() }}
                    </span>
                @endif
            </button>

            <button type="button" @click="activeTab = 'notifications'"
                class="px-5 py-3 text-xs font-bold uppercase tracking-wider border-b-2 transition flex items-center gap-2"
                :class="activeTab === 'notifications' ? 'border-amber-500 text-amber-600 bg-white rounded-t-xl' : 'border-transparent text-gray-500 hover:text-gray-900'">
                <i class="fas fa-bell"></i> Notifikasi & Riwayat ({{ $statusLogs->count() }})
            </button>

            @if ($isPengusul)
                <button type="button" @click="activeTab = 'my_proposals'"
                    class="px-5 py-3 text-xs font-bold uppercase tracking-wider border-b-2 transition flex items-center gap-2"
                    :class="activeTab === 'my_proposals' ? 'border-amber-500 text-amber-600 bg-white rounded-t-xl' : 'border-transparent text-gray-500 hover:text-gray-900'">
                    <i class="fas fa-file-alt"></i> Proposal Ketua Tim ({{ $mySubmissions->count() }})
                </button>
            @endif

            @if ($isReviewer)
                <button type="button" @click="activeTab = 'reviews'"
                    class="px-5 py-3 text-xs font-bold uppercase tracking-wider border-b-2 transition flex items-center gap-2"
                    :class="activeTab === 'reviews' ? 'border-amber-500 text-amber-600 bg-white rounded-t-xl' : 'border-transparent text-gray-500 hover:text-gray-900'">
                    <i class="fas fa-clipboard-check"></i> Tugas Penilaian ({{ $assignedReviewsCount }})
                </button>
            @endif
        </div>

        {{-- ═════════ TAB 1: BIODATA & PROFIL ═════════ --}}
        <div x-show="activeTab === 'biodata'" x-cloak class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Form Edit Profile --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-6 sm:p-8 shadow-sm lg:col-span-2 space-y-6">
                    <div class="border-b border-gray-100 pb-4 flex items-center justify-between">
                        <div>
                            <h2 class="text-base font-bold text-gray-900">Perbarui Biodata {{ $isReviewer ? 'Reviewer' : 'Peserta' }}</h2>
                            <p class="text-xs text-gray-500 mt-0.5">Informasi profil untuk verifikasi akun HackAthon.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('hackaton.profile.update') }}" class="space-y-4 text-xs">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-bold text-gray-700 mb-1">Nama Lengkap *</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-amber-500">
                                @error('name') <p class="text-rose-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block font-bold text-gray-700 mb-1">Email Akun</label>
                                <input type="email" value="{{ $user->email }}" disabled
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-500 cursor-not-allowed">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-bold text-gray-700 mb-1">NIM / NIP / NIK *</label>
                                <input type="text" name="identifier_number" value="{{ old('identifier_number', $user->profile?->identifier_number) }}" required
                                    class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-amber-500"
                                    placeholder="Nomor identitas resmi...">
                                @error('identifier_number') <p class="text-rose-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            @if ($role === 'hackaton_dudi')
                                <div>
                                    <label class="block font-bold text-gray-700 mb-1">Nama Institusi / Perusahaan (DUDI) *</label>
                                    <input type="text" name="institusi" value="{{ old('institusi', $user->profile?->institusi) }}" required
                                        class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-amber-500"
                                        placeholder="Nama PT / CV / Industri...">
                                    @error('institusi') <p class="text-rose-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                            @else
                                <div>
                                    <label class="block font-bold text-gray-700 mb-1">Institusi / Mitra (Opsional)</label>
                                    <input type="text" name="institusi" value="{{ old('institusi', $user->profile?->institusi) }}"
                                        class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-amber-500">
                                </div>
                            @endif
                        </div>

                        @if ($role !== 'hackaton_dudi')
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-bold text-gray-700 mb-1">Fakultas</label>
                                    <select name="fakultas_id" class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm">
                                        <option value="">— Pilih Fakultas —</option>
                                        @foreach ($fakultasList as $fak)
                                            <option value="{{ $fak->id }}" {{ old('fakultas_id', $user->profile?->fakultas_id) == $fak->id ? 'selected' : '' }}>
                                                {{ $fak->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block font-bold text-gray-700 mb-1">Program Studi</label>
                                    <select name="prodi_id" class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm">
                                        <option value="">— Pilih Prodi —</option>
                                        @foreach ($prodiList as $prd)
                                            <option value="{{ $prd->id }}" {{ old('prodi_id', $user->profile?->prodi_id) == $prd->id ? 'selected' : '' }}>
                                                {{ $prd->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block font-bold text-gray-700 mb-1">Alamat Domisili</label>
                                <input type="text" name="alamat" value="{{ old('alamat', $user->profile?->alamat) }}"
                                    class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-amber-500"
                                    placeholder="Jalan, No, Kelurahan, Kecamatan...">
                            </div>
                            <div>
                                <label class="block font-bold text-gray-700 mb-1">Kode Pos</label>
                                <input type="text" name="kode_pos" value="{{ old('kode_pos', $user->profile?->kode_pos) }}"
                                    class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-amber-500"
                                    placeholder="13220">
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-gray-900 font-bold rounded-xl text-xs uppercase tracking-wider transition shadow-sm">
                                <i class="fas fa-save mr-1.5"></i> Simpan Biodata
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Status Card Sidebar --}}
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-4 text-xs">
                        <h3 class="font-bold text-gray-900 uppercase tracking-wider text-xs border-b border-gray-100 pb-3">
                            Status Akun HackAthon
                        </h3>
                        <div>
                            <span class="text-gray-400 font-bold uppercase text-[10px] block">Role Terdaftar</span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-900 mt-1">
                                {{ $roleLabel }}
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-400 font-bold uppercase text-[10px] block">Status Pendaftaran Akun</span>
                            @if ($registration)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $registration->status === 'approved' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }} mt-1">
                                    {{ ucfirst($registration->status) }}
                                </span>
                            @else
                                <span class="text-gray-700 font-bold mt-1 block">Aktif</span>
                            @endif
                        </div>
                        <div>
                            <span class="text-gray-400 font-bold uppercase text-[10px] block">Terdaftar Pada</span>
                            <span class="text-gray-700 font-medium mt-1 block">{{ $user->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═════════ TAB 2: UNDANGAN & TIM SAYA ═════════ --}}
        <div x-show="activeTab === 'participations'" x-cloak class="space-y-6">
            {{-- Undangan Tim Pending --}}
            @if ($pendingInvitations->isNotEmpty())
                <div class="bg-amber-50 border-2 border-amber-300 rounded-2xl p-6 shadow-sm space-y-4">
                    <h2 class="text-base font-bold text-amber-950 flex items-center gap-2">
                        <i class="fas fa-envelope-open-text text-amber-600"></i> Undangan Bergabung Tim Baru
                        <span class="px-2 py-0.5 rounded-full text-xs font-black bg-rose-500 text-white">
                            {{ $pendingInvitations->count() }} Menunggu Respon
                        </span>
                    </h2>

                    <div class="space-y-3">
                        @foreach ($pendingInvitations as $inv)
                            @php $sub = $inv->submission; @endphp
                            <div class="bg-white p-5 rounded-xl border border-amber-200 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-xs">
                                <div class="space-y-1 flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-gray-900 text-sm">
                                            {{ $sub->identitas?->nama_produk ?? 'Proposal: ' . $sub->session->nama_sesi }}
                                        </span>
                                        <span class="px-2 py-0.5 rounded-full font-black text-[10px] bg-purple-100 text-purple-900">
                                            Posisi: {{ $inv->peran_ic }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600">
                                        Ketua Pengusul: <strong>{{ $sub->user->name }}</strong> • Sesi: {{ $sub->session->nama_sesi }}
                                    </p>
                                    @if ($inv->deskripsi_peran)
                                        <p class="text-gray-500 italic">Tugas Anda: "{{ $inv->deskripsi_peran }}"</p>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2 shrink-0">
                                    <form action="{{ route('hackaton.invitations.approve', $inv) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl uppercase tracking-wider text-xs transition shadow-sm">
                                            <i class="fas fa-check mr-1"></i> Terima Undangan
                                        </button>
                                    </form>
                                    <form action="{{ route('hackaton.invitations.reject', $inv) }}" method="POST" class="inline" onsubmit="return confirm('Tolak undangan bergabung ke tim ini?')">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl uppercase tracking-wider text-xs transition shadow-sm">
                                            <i class="fas fa-times mr-1"></i> Tolak
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Tim & Proposal yang Diikuti --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-6 sm:p-8 shadow-sm space-y-4">
                <div class="border-b border-gray-100 pb-4">
                    <h2 class="text-base font-bold text-gray-900">Tim & Proposal yang Anda Ikuti</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Daftar tim HackAthon di mana Anda terdaftar sebagai kolaborator aktif.</p>
                </div>

                <div class="space-y-4">
                    @forelse ($approvedParticipations as $part)
                        @php $sub = $part->submission; @endphp
                        <div class="p-5 rounded-xl border border-gray-200 hover:border-amber-300 transition flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 text-xs">
                            <div class="space-y-2 flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold px-2 py-0.5 rounded-full bg-gray-100 text-gray-700 text-[11px]">
                                        {{ $sub->session->nama_sesi }}
                                    </span>
                                    <span class="font-black px-2 py-0.5 rounded-full bg-purple-100 text-purple-900 text-[10px]">
                                        Peran Anda: {{ $part->peran_ic }}
                                    </span>
                                    <span class="font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px]">
                                        Tergabung
                                    </span>
                                </div>

                                <h3 class="text-base font-bold text-gray-900">
                                    {{ $sub->identitas?->nama_produk ?? 'Proposal #' . $sub->id }}
                                </h3>

                                <p class="text-gray-500">
                                    Ketua Pengusul: <strong>{{ $sub->user->name }}</strong> • {{ $sub->members->count() }} Anggota Tim
                                </p>
                            </div>

                            {{-- Tahap Mini Status --}}
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-1.5">
                                    @foreach ($sub->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke ?? 0) as $st)
                                        @php
                                            $tk = $st->tahap->tahap_ke ?? $loop->iteration;
                                            $tracking = $st->getTrackingStatus($sub->reviewers->isNotEmpty());
                                            $bg = match ($tracking['key']) {
                                                'lolos' => 'bg-emerald-600 text-white',
                                                'perbaikan' => 'bg-amber-500 text-black',
                                                'sedang_direview' => 'bg-purple-600 text-white',
                                                'menunggu_review' => 'bg-blue-600 text-white',
                                                'draft' => 'bg-amber-200 text-amber-900',
                                                default => 'bg-gray-100 text-gray-500'
                                            };
                                        @endphp
                                        <span class="w-7 h-7 rounded-lg text-[11px] font-black flex items-center justify-center {{ $bg }}" title="Tahap {{ $tk }}: {{ $tracking['label'] }}">
                                            T{{ $tk }}
                                        </span>
                                    @endforeach
                                </div>

                                <a href="{{ route('hackaton.team.show', $sub) }}" class="inline-flex items-center px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-xl text-xs transition shadow">
                                    Lihat Berkas <i class="fas fa-arrow-right ml-1.5"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-400 text-xs italic">
                            Belum ada tim yang Anda ikuti saat ini.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ═════════ TAB 3: NOTIFIKASI & RIWAYAT ═════════ --}}
        <div x-show="activeTab === 'notifications'" x-cloak class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-200 p-6 sm:p-8 shadow-sm space-y-4">
                <div class="border-b border-gray-100 pb-4">
                    <h2 class="text-base font-bold text-gray-900">Notifikasi & Riwayat Perubahan Status</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Catatan evaluasi admin, hasil review, dan perbaikan pada tim Anda.</p>
                </div>

                <div class="divide-y divide-gray-100 text-xs">
                    @forelse ($statusLogs as $log)
                        <div class="py-4 flex items-start gap-4">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 mt-1.5 shrink-0"></span>
                            <div class="space-y-1 flex-1">
                                <p class="font-bold text-gray-900 text-sm">{{ $log->keterangan }}</p>
                                <p class="text-gray-500">
                                    Proposal: <strong>{{ $log->submission->identitas?->nama_produk ?? $log->submission->session->nama_sesi }}</strong>
                                    @if ($log->tahap) • Tahap: {{ $log->tahap->nama_tahap }} @endif
                                </p>
                                <p class="text-gray-400 text-[11px]">
                                    {{ $log->created_at->format('d M Y, H:i') }} • Oleh: {{ $log->causer->name ?? 'Sistem' }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-400 text-xs italic">
                            Belum ada riwayat aktivitas atau notifikasi.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ═════════ TAB 4: PROPOSAL SAYA (KHUSUS PENGUSUL) ═════════ --}}
        @if ($isPengusul)
            <div x-show="activeTab === 'my_proposals'" x-cloak class="space-y-6">
                <div class="bg-white rounded-2xl border border-gray-200 p-6 sm:p-8 shadow-sm space-y-4">
                    <div class="border-b border-gray-100 pb-4 flex items-center justify-between">
                        <div>
                            <h2 class="text-base font-bold text-gray-900">Proposal yang Anda Ketuai</h2>
                            <p class="text-xs text-gray-500 mt-0.5">Kelola isian dan submission dari proposal Anda.</p>
                        </div>
                        <a href="{{ route('hackaton.submissions.index') }}" class="text-xs font-bold text-amber-600 hover:underline">
                            Buka Halaman Lengkap →
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse ($mySubmissions as $sub)
                            <div class="p-5 rounded-xl border border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-xs">
                                <div class="space-y-1">
                                    <span class="text-[10px] font-bold px-2 py-0.5 bg-gray-100 rounded-full text-gray-600">{{ $sub->session->nama_sesi }}</span>
                                    <h3 class="font-bold text-gray-900 text-sm">{{ $sub->identitas?->nama_produk ?? '— Belum ada nama produk —' }}</h3>
                                    <p class="text-gray-500">{{ $sub->members->count() }} Anggota Tim</p>
                                </div>
                                <a href="{{ route('hackaton.submissions.show', $sub) }}" class="inline-flex items-center px-4 py-2 bg-gray-900 text-white font-bold rounded-xl text-xs hover:bg-gray-800 transition">
                                    Buka Progres <i class="fas fa-arrow-right ml-1.5"></i>
                                </a>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic py-4">Belum ada proposal yang diajukan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif

        {{-- ═════════ TAB 5: TUGAS PENILAIAN (KHUSUS REVIEWER) ═════════ --}}
        @if ($isReviewer)
            <div x-show="activeTab === 'reviews'" x-cloak class="space-y-6">
                <div class="bg-white rounded-2xl border border-gray-200 p-6 sm:p-8 shadow-sm space-y-4">
                    <div class="border-b border-gray-100 pb-4 flex items-center justify-between">
                        <div>
                            <h2 class="text-base font-bold text-gray-900">Ringkasan Tugas Penilaian</h2>
                            <p class="text-xs text-gray-500 mt-0.5">Proposal yang ditugaskan kepada Anda oleh admin HackAthon.</p>
                        </div>
                        <a href="{{ route('hackaton.reviewer.assignments.index') }}" class="text-xs font-bold text-amber-600 hover:underline">
                            Lihat Semua Penugasan →
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <span class="text-gray-400 font-bold uppercase text-[10px]">Ditugaskan</span>
                            <span class="text-xl font-black text-gray-900 block mt-1">{{ $assignedReviewsCount }} Proposal</span>
                        </div>
                        <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-200">
                            <span class="text-emerald-700 font-bold uppercase text-[10px]">Selesai Dinilai</span>
                            <span class="text-xl font-black text-emerald-800 block mt-1">{{ $reviewedCount }} Proposal</span>
                        </div>
                        <div class="p-4 bg-amber-50 rounded-xl border border-amber-200">
                            <span class="text-amber-800 font-bold uppercase text-[10px]">Menunggu Nilai</span>
                            <span class="text-xl font-black text-amber-900 block mt-1">{{ $pendingReviewsCount }} Proposal</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
