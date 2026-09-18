@extends('admin_hackaton.index')

@section('contentadmin_hackaton')
    <script>
        function adminSubmissionDetails() {
            return {
                activeTahapTab: 1,
                showAssignReviewer: false,
                showAddMember: false
            };
        }
    </script>

    <div class="space-y-8" x-data="adminSubmissionDetails()">
        {{-- Breadcrumb & Header --}}
        <div class="border-b-4 border-gray-950 pb-6 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
            <div>
                <p class="mb-2 text-sm font-bold uppercase tracking-[0.18em] text-gray-600">
                    <a href="{{ route('admin_hackaton.sessions.index') }}" class="hover:underline">Admin Hackaton / Sesi</a> /
                    <a href="{{ route('admin_hackaton.sessions.show', $session) }}" class="hover:underline">{{ $session->nama_sesi }}</a> /
                    <a href="{{ route('admin_hackaton.submissions.index', $session) }}" class="hover:underline">Proposal</a> /
                    Detail
                </p>
                <h1 class="text-3xl font-black text-gray-950 sm:text-4xl">
                    {{ $submission->identitas?->nama_produk ?? 'Proposal: ' . ($submission->user->name ?? 'Tim') }}
                </h1>
                <p class="mt-2 text-base text-gray-700">
                    Ketua Tim / Pengusul: <strong>{{ $submission->user->name }}</strong> ({{ $submission->user->email }})
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('hackaton.submissions.lembar_pengesahan', $submission) }}" class="border-2 border-emerald-800 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold uppercase tracking-wider px-4 py-2.5 transition shadow-sm inline-flex items-center">
                    <i class="fas fa-file-signature mr-1.5"></i> Lembar Pengesahan
                </a>
                <a href="{{ route('hackaton.submissions.pakta_integritas', $submission) }}" class="border-2 border-indigo-800 bg-indigo-700 hover:bg-indigo-800 text-white text-xs font-bold uppercase tracking-wider px-4 py-2.5 transition shadow-sm inline-flex items-center">
                    <i class="fas fa-file-contract mr-1.5"></i> Pakta Integritas
                </a>
                <a href="{{ route('admin_hackaton.submissions.index', $session) }}" class="border-2 border-gray-950 bg-white hover:bg-gray-100 text-gray-950 text-xs font-bold uppercase tracking-wider px-4 py-2.5">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
                </a>
            </div>
        </div>

        {{-- Tracker Tahapan Horizontal --}}
        <div class="border-2 border-gray-950 bg-white p-6">
            <h2 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-4">Linimasa Progres Tahapan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($submission->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke ?? 0) as $st)
                    @php
                        $tk = $st->tahap->tahap_ke ?? $loop->iteration;
                        $tracking = $st->getTrackingStatus($hasReviewer ?? false);
                        $boxBg = match ($tracking['key']) {
                            'lolos' => 'border-emerald-600 bg-emerald-50 text-emerald-900',
                            'perbaikan' => 'border-amber-500 bg-amber-50 text-amber-900',
                            'sedang_direview' => 'border-purple-600 bg-purple-50 text-purple-900',
                            'menunggu_review' => 'border-blue-600 bg-blue-50 text-blue-900',
                            'draft' => 'border-amber-400 bg-amber-50/50 text-amber-800',
                            default => 'border-gray-300 bg-gray-50 text-gray-600'
                        };
                    @endphp
                    <div class="border-2 p-4 flex items-start gap-3 {{ $boxBg }}">
                        <span class="w-8 h-8 rounded-none bg-gray-950 text-white font-black text-sm flex items-center justify-center shrink-0">
                            {{ $tk }}
                        </span>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider">Tahap {{ $tk }}: {{ $st->tahap->nama_tahap }}</p>
                            <p class="font-black text-sm mt-0.5">{{ $tracking['label'] }}</p>
                            @if ($st->nominal_evaluasi)
                                <p class="text-[11px] font-bold mt-1 text-emerald-700">Dana: Rp {{ number_format($st->nominal_evaluasi, 0, ',', '.') }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Identitas Produk & Anggota Tim --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Identitas Produk --}}
            <div class="border-2 border-gray-950 bg-white p-6 space-y-4">
                <div class="border-b border-gray-200 pb-3 flex items-center justify-between">
                    <h2 class="font-bold text-gray-950 uppercase tracking-wider text-xs flex items-center gap-2">
                        <i class="fas fa-id-card"></i> Identitas Tim & Produk
                    </h2>
                    @if ($submission->identitasIsComplete())
                        <span class="text-[10px] font-bold bg-emerald-100 text-emerald-800 px-2 py-0.5 border border-emerald-300">Lengkap</span>
                    @else
                        <span class="text-[10px] font-bold bg-amber-100 text-amber-800 px-2 py-0.5 border border-amber-300">Belum Lengkap</span>
                    @endif
                </div>

                <div class="space-y-3 text-xs">
                    <div>
                        <span class="font-bold text-gray-500 uppercase tracking-wider text-[10px]">Nama Produk / Inovasi</span>
                        <p class="font-bold text-gray-950 text-sm mt-0.5">{{ $submission->identitas?->nama_produk ?? '— Belum diisi —' }}</p>
                    </div>
                    <div>
                        <span class="font-bold text-gray-500 uppercase tracking-wider text-[10px]">Skema</span>
                        <p class="font-medium text-gray-800 mt-0.5">{{ $submission->identitas?->skema_inovasi ?? '— Belum dipilih —' }}</p>
                    </div>
                    @if ($submission->tema)
                        <div>
                            <span class="font-bold text-gray-500 uppercase tracking-wider text-[10px]">Fokus Tema Inovasi</span>
                            <div class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold {{ str_contains($submission->tema, 'D-FARM') ? 'bg-amber-100 text-amber-950 border border-amber-300' : 'bg-rose-100 text-rose-950 border border-rose-300' }}">
                                    <i class="fas {{ str_contains($submission->tema, 'D-FARM') ? 'fa-wheat-awn' : 'fa-heart-pulse' }} mr-1.5"></i>
                                    {{ $submission->tema_label ?? $submission->tema }}
                                </span>
                            </div>
                        </div>
                    @endif
                    <div>
                        <span class="font-bold text-gray-500 uppercase tracking-wider text-[10px]">Bidang Utama</span>
                        <p class="font-medium text-gray-800 mt-0.5">{{ $submission->identitas?->bidang_utama_produk ?? '— Belum diisi —' }}</p>
                    </div>
                </div>
            </div>

            {{-- Anggota Tim --}}
            <div class="border-2 border-gray-950 bg-white p-6 lg:col-span-2 space-y-4">
                <div class="border-b border-gray-200 pb-3 flex items-center justify-between">
                    <h2 class="font-bold text-gray-950 uppercase tracking-wider text-xs flex items-center gap-2">
                        <i class="fas fa-users"></i> Anggota Tim ({{ $submission->members->count() }} Orang)
                    </h2>
                    <button type="button" @click="showAddMember = !showAddMember" class="text-xs font-bold bg-gray-950 text-white px-3 py-1 uppercase hover:bg-gray-800">
                        <i class="fas fa-user-plus mr-1"></i> Tambah Anggota
                    </button>
                </div>

                {{-- Form Tambah Anggota oleh Admin --}}
                <div x-show="showAddMember" x-cloak class="border-2 border-dashed border-gray-950 bg-amber-50 p-4 space-y-3">
                    <form action="{{ route('admin_hackaton.submissions.members.store', [$session, $submission]) }}" method="POST" class="space-y-3">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                            <div>
                                <label class="block font-bold mb-1">Nama Lengkap *</label>
                                <input type="text" name="nama_lengkap" required class="w-full border-2 border-gray-950 px-2.5 py-1.5 bg-white">
                            </div>
                            <div>
                                <label class="block font-bold mb-1">NIM / NIP / NIK *</label>
                                <input type="text" name="nik_nim_nip" required class="w-full border-2 border-gray-950 px-2.5 py-1.5 bg-white">
                            </div>
                            <div>
                                <label class="block font-bold mb-1">Tipe Anggota *</label>
                                <select name="tipe_anggota" class="w-full border-2 border-gray-950 px-2.5 py-1.5 bg-white">
                                    <option value="mahasiswa">Mahasiswa</option>
                                    <option value="dosen">Dosen</option>
                                    <option value="DUDI">Mitra DUDI (Industri)</option>
                                    <option value="alumni">Alumni</option>
                                    <option value="tendik">Tendik</option>
                                    <option value="peneliti">Peneliti</option>
                                    <option value="PPPK">PPPK</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                            <div>
                                <label class="block font-bold mb-1">Peran IC *</label>
                                <select name="peran_ic" class="w-full border-2 border-gray-950 px-2.5 py-1.5 bg-white">
                                    <option value="Hacker">Hacker (Teknis/Developer)</option>
                                    <option value="Hustler">Hustler (Bisnis/Manajemen)</option>
                                    <option value="Hipster">Hipster (Desain/UI/UX)</option>
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block font-bold mb-1">Fakultas / Institusi</label>
                                <input type="text" name="institusi_fakultas" class="w-full border-2 border-gray-950 px-2.5 py-1.5 bg-white" placeholder="Contoh: Fakultas Teknik / PT Inovasi">
                            </div>
                        </div>

                        <div class="text-xs">
                            <label class="block font-bold mb-1">Deskripsi Tugas & Peran *</label>
                            <input type="text" name="deskripsi_peran" required class="w-full border-2 border-gray-950 px-2.5 py-1.5 bg-white" placeholder="Tugas spesifik dalam proyek Hackaton...">
                        </div>

                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="showAddMember = false" class="px-3 py-1 font-bold text-xs">Batal</button>
                            <button type="submit" class="bg-gray-950 text-white px-4 py-1 text-xs font-bold uppercase">Tambah Anggota</button>
                        </div>
                    </form>
                </div>

                <div class="divide-y divide-gray-200">
                    @foreach ($submission->members as $m)
                        <div class="py-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-gray-950 text-sm">{{ $m->nama_lengkap }}</span>
                                    <span class="px-2 py-0.5 font-bold uppercase text-[10px] {{ $m->peran === 'Ketua' ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-gray-100 text-gray-700 border border-gray-300' }}">
                                        {{ $m->peran }}
                                    </span>
                                    <span class="px-1.5 py-0.5 font-black text-[10px] bg-purple-100 text-purple-900 border border-purple-300">
                                        {{ $m->peran_ic }}
                                    </span>
                                    <span class="px-1.5 py-0.5 text-[10px] border border-blue-200 bg-blue-50 text-blue-800">
                                        {{ $m->getTipeLabel() }}
                                    </span>
                                </div>
                                <p class="text-gray-500 mt-0.5 text-[11px]">
                                    {{ $m->nik_nim_nip ?? '-' }} • {{ $m->institusi_fakultas ?? '-' }}
                                    @if ($m->deskripsi_peran) — <em>{{ $m->deskripsi_peran }}</em>@endif
                                </p>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                @if ($m->approval_status === 'pending')
                                    <span class="px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-300">Menunggu</span>
                                    <form action="{{ route('admin_hackaton.submissions.members.approve', [$session, $submission, $m]) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="bg-emerald-600 text-white px-2 py-1 text-[10px] font-bold uppercase hover:bg-emerald-700">Approve</button>
                                    </form>
                                    <form action="{{ route('admin_hackaton.submissions.members.reject', [$session, $submission, $m]) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="bg-rose-600 text-white px-2 py-1 text-[10px] font-bold uppercase hover:bg-rose-700">Reject</button>
                                    </form>
                                @elseif ($m->approval_status === 'approved' || $m->approval_status === 'not_required')
                                    <span class="px-2 py-0.5 text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">Disetujui</span>
                                @else
                                    <span class="px-2 py-0.5 text-[10px] font-bold bg-rose-100 text-rose-800 border border-rose-300">Ditolak</span>
                                @endif

                                @if ($m->peran !== 'Ketua')
                                    <form action="{{ route('admin_hackaton.submissions.members.destroy', [$session, $submission, $m]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus anggota ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-rose-600 p-1 hover:text-rose-800" title="Hapus">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Penugasan Reviewer --}}
        <div class="border-2 border-gray-950 bg-white p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                <div>
                    <h2 class="font-bold text-gray-950 uppercase tracking-wider text-xs flex items-center gap-2">
                        <i class="fas fa-clipboard-check"></i> Reviewer Ditugaskan
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Reviewer yang memiliki hak menilai berkas dan memberikan skor pada proposal ini.</p>
                </div>
                <button type="button" @click="showAssignReviewer = !showAssignReviewer" class="text-xs font-bold bg-gray-950 text-white px-3 py-1.5 uppercase hover:bg-gray-800">
                    <i class="fas fa-user-tag mr-1"></i> Atur Reviewer
                </button>
            </div>

            {{-- Form Penugasan Reviewer --}}
            <div x-show="showAssignReviewer" x-cloak class="border-2 border-dashed border-gray-950 bg-amber-50 p-4">
                <form action="{{ route('admin_hackaton.submissions.assignReviewer', [$session, $submission]) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <p class="text-xs font-bold text-gray-800">Pilih Reviewer:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 max-h-60 overflow-y-auto p-2 bg-white border border-gray-300">
                        @foreach ($availableReviewers as $rev)
                            <label class="flex items-center gap-2 text-xs text-gray-800 cursor-pointer hover:bg-amber-50 p-1">
                                <input type="checkbox" name="reviewer_ids[]" value="{{ $rev->id }}"
                                    {{ $submission->reviewers->contains($rev->id) ? 'checked' : '' }}
                                    class="w-4 h-4 border-2 border-gray-950">
                                <div>
                                    <p class="font-bold">{{ $rev->name }}</p>
                                    <p class="text-[10px] text-gray-500">{{ $rev->email }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="showAssignReviewer = false" class="px-3 py-1.5 text-xs font-bold uppercase">Batal</button>
                        <button type="submit" class="bg-gray-950 text-white px-4 py-1.5 text-xs font-bold uppercase">Simpan Penugasan</button>
                    </div>
                </form>
            </div>

            <div class="flex flex-wrap gap-2">
                @forelse ($submission->reviewers as $r)
                    <div class="inline-flex items-center gap-2 border-2 border-gray-950 px-3 py-1.5 text-xs bg-gray-50">
                        <i class="fas fa-user-shield text-gray-600"></i>
                        <span class="font-bold text-gray-900">{{ $r->name }}</span>
                        <span class="text-[10px] text-gray-500">({{ $r->email }})</span>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 italic">Belum ada reviewer yang ditugaskan ke proposal ini.</p>
                @endforelse
            </div>
        </div>

        {{-- Tabs Tahapan Evaluasi & Penilaian --}}
        <div class="space-y-4">
            <div class="flex flex-wrap border-b-2 border-gray-950">
                @foreach ($submission->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke ?? 0) as $st)
                    @php
                        $tk = $st->tahap->tahap_ke ?? $loop->iteration;
                    @endphp
                    <button type="button" @click="activeTahapTab = {{ $tk }}"
                        class="px-6 py-3 text-xs font-black uppercase tracking-wider border-r-2 border-gray-950 transition"
                        :class="activeTahapTab === {{ $tk }} ? 'bg-gray-950 text-white' : 'bg-white text-gray-700 hover:bg-gray-100'">
                        Tahap {{ $tk }}: {{ $st->tahap->nama_tahap }}
                    </button>
                @endforeach
            </div>

            {{-- Tab Contents --}}
            @foreach ($submission->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke ?? 0) as $st)
                @php
                    $tk = $st->tahap->tahap_ke ?? $loop->iteration;
                @endphp
                <div x-show="activeTahapTab === {{ $tk }}" x-cloak class="space-y-6">

                    {{-- Form Keputusan Admin per Tahap --}}
                    <div class="border-2 border-gray-950 bg-white p-6 space-y-4">
                        <div class="border-b border-gray-200 pb-3 flex items-center justify-between">
                            <h3 class="font-bold text-gray-950 uppercase tracking-wider text-xs flex items-center gap-2">
                                <i class="fas fa-gavel"></i> Keputusan & Evaluasi Admin (Tahap {{ $tk }})
                            </h3>
                            <span class="text-xs font-bold uppercase px-2 py-0.5 border border-black bg-gray-100">
                                Status Admin: {{ ucfirst($st->admin_status) }}
                            </span>
                        </div>

                        <form action="{{ route('admin_hackaton.submissions.updateTahapStatus', $st) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PATCH')

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                                <div>
                                    <label class="block font-bold mb-1 uppercase tracking-wider">Keputusan Status *</label>
                                    <select name="admin_status" class="w-full border-2 border-gray-950 px-3 py-2 bg-white font-bold">
                                        <option value="menunggu" {{ $st->admin_status === 'menunggu' ? 'selected' : '' }}>MENUNGGU (Belum Diputuskan)</option>
                                        <option value="disetujui" {{ $st->admin_status === 'disetujui' ? 'selected' : '' }}>DISETUJUI / LOLOS (Buka Tahap Berikutnya)</option>
                                        <option value="perbaikan" {{ $st->admin_status === 'perbaikan' ? 'selected' : '' }}>PERBAIKAN (Kembalikan ke Pengusul untuk Revisi)</option>
                                        <option value="selesai" {{ $st->admin_status === 'selesai' ? 'selected' : '' }}>SELESAI (Final Tahap)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block font-bold mb-1 uppercase tracking-wider">Nominal Dana Evaluasi (Rp)</label>
                                    <input type="number" name="nominal_evaluasi" value="{{ old('nominal_evaluasi', $st->nominal_evaluasi) }}" step="1000" min="0"
                                        class="w-full border-2 border-gray-950 px-3 py-2 bg-white" placeholder="Contoh: 15000000">
                                </div>
                            </div>

                            <div class="text-xs">
                                <label class="block font-bold mb-1 uppercase tracking-wider">Catatan Admin / Feedback untuk Pengusul</label>
                                <textarea name="catatan_admin" rows="3" class="w-full border-2 border-gray-950 px-3 py-2 bg-white focus:outline-none"
                                    placeholder="Tuliskan catatan perbaikan atau feedback kelulusan...">{{ old('catatan_admin', $st->catatan_admin) }}</textarea>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="bg-gray-950 text-white px-5 py-2.5 text-xs font-bold uppercase tracking-wider hover:bg-gray-800">
                                    Simpan Keputusan Tahap {{ $tk }}
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Reviewer Scores & Feedbacks for this Tahap --}}
                    @php
                        $tahapReviews = $submission->reviews->where('hackaton_tahap_id', $st->hackaton_tahap_id);
                    @endphp
                    <div class="border-2 border-gray-950 bg-white p-6 space-y-4">
                        <div class="border-b border-gray-200 pb-3 flex items-center justify-between">
                            <h3 class="font-bold text-gray-950 uppercase tracking-wider text-xs flex items-center gap-2">
                                <i class="fas fa-star text-amber-500"></i> Hasil Penilaian Reviewer (Tahap {{ $tk }})
                            </h3>
                            @if ($tahapReviews->isNotEmpty() && $tahapReviews->whereNotNull('skor')->count() > 0)
                                <span class="bg-amber-100 text-amber-900 border border-amber-300 text-xs font-black px-2.5 py-1">
                                    Rata-rata Skor: {{ round($tahapReviews->avg('skor'), 1) }} / 100
                                </span>
                            @endif
                        </div>

                        <div class="space-y-3">
                            @forelse ($tahapReviews as $rev)
                                <div class="border-2 border-gray-200 p-4 bg-gray-50 space-y-2 text-xs">
                                    <div class="flex items-center justify-between">
                                        <p class="font-bold text-gray-900"><i class="fas fa-user-edit mr-1"></i> {{ $rev->reviewer->name ?? 'Reviewer' }}</p>
                                        <span class="text-xs font-black bg-gray-950 text-white px-2 py-0.5">
                                            Skor: {{ $rev->skor ?? '-' }} / 100
                                        </span>
                                    </div>
                                    <p class="text-gray-700 leading-relaxed"><strong class="text-gray-900">Komentar:</strong> {{ $rev->komentar }}</p>
                                    @if ($rev->penilaian)
                                        <p class="text-gray-600"><strong class="text-gray-900">Catatan Evaluasi:</strong> {{ $rev->penilaian }}</p>
                                    @endif
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic">Belum ada reviewer yang memberikan penilaian untuk Tahap {{ $tk }}.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Isian Form Tahap (Field Values) --}}
                    <div class="border-2 border-gray-950 bg-white p-6 space-y-4">
                        <div class="border-b border-gray-200 pb-3 flex items-center justify-between">
                            <h3 class="font-bold text-gray-950 uppercase tracking-wider text-xs flex items-center gap-2">
                                <i class="fas fa-file-invoice"></i> Berkas & Isian Pengusul (Tahap {{ $tk }})
                            </h3>
                            <span class="text-xs font-bold text-gray-500 uppercase">
                                Status Pengisian: {{ strtoupper($st->status) }}
                            </span>
                        </div>

                        @php
                            $fValues = $st->loadedFieldValues ?? collect();
                        @endphp

                        @if ($st->tahap->sections->isEmpty() && $st->tahap->unsectionedFields->isEmpty())
                            <p class="text-xs text-gray-400 italic">Belum ada field yang dikonfigurasi pada tahap ini.</p>
                        @endif

                        {{-- Sectioned Fields --}}
                        @foreach ($st->tahap->sections as $sec)
                            <div class="border-2 border-gray-200 overflow-hidden">
                                <div class="bg-gray-100 px-4 py-2 border-b border-gray-200 font-bold text-xs text-gray-900">
                                    {{ $sec->judul }}
                                </div>
                                <div class="divide-y divide-gray-100">
                                    @foreach ($sec->fields as $f)
                                        @php
                                            $valRow = $fValues[$f->id] ?? null;
                                            $val = $valRow?->value;
                                        @endphp
                                        <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-2 text-xs">
                                            <div class="font-bold text-gray-700">{{ $f->field_label }}</div>
                                            <div class="sm:col-span-2 text-gray-900">
                                                @if ($f->field_type === 'file' && $val)
                                                    <a href="{{ asset('storage/' . $val) }}" target="_blank" class="inline-flex items-center gap-1.5 font-bold text-blue-700 hover:underline">
                                                        <i class="fas fa-download"></i> Unduh Berkas Lampiran
                                                    </a>
                                                @elseif ($f->field_type === 'url' && $val)
                                                    <a href="{{ $val }}" target="_blank" class="inline-flex items-center gap-1.5 font-bold text-blue-700 hover:underline break-all">
                                                        <i class="fas fa-external-link-alt"></i> {{ $val }}
                                                    </a>
                                                @elseif ($val)
                                                    <p class="whitespace-pre-line leading-relaxed">{{ $val }}</p>
                                                @else
                                                    <span class="text-gray-400 italic">— Belum diisi —</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        {{-- Unsectioned Fields --}}
                        @if ($st->tahap->unsectionedFields->isNotEmpty())
                            <div class="border-2 border-gray-200 overflow-hidden">
                                <div class="bg-gray-100 px-4 py-2 border-b border-gray-200 font-bold text-xs text-gray-900">
                                    Field Umum / Lainnya
                                </div>
                                <div class="divide-y divide-gray-100">
                                    @foreach ($st->tahap->unsectionedFields as $f)
                                        @php
                                            $valRow = $fValues[$f->id] ?? null;
                                            $val = $valRow?->value;
                                        @endphp
                                        <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-2 text-xs">
                                            <div class="font-bold text-gray-700">{{ $f->field_label }}</div>
                                            <div class="sm:col-span-2 text-gray-900">
                                                @if ($f->field_type === 'file' && $val)
                                                    <a href="{{ asset('storage/' . $val) }}" target="_blank" class="inline-flex items-center gap-1.5 font-bold text-blue-700 hover:underline">
                                                        <i class="fas fa-download"></i> Unduh Berkas
                                                    </a>
                                                @elseif ($f->field_type === 'url' && $val)
                                                    <a href="{{ $val }}" target="_blank" class="inline-flex items-center gap-1.5 font-bold text-blue-700 hover:underline break-all">
                                                        <i class="fas fa-external-link-alt"></i> {{ $val }}
                                                    </a>
                                                @elseif ($val)
                                                    <p class="whitespace-pre-line leading-relaxed">{{ $val }}</p>
                                                @else
                                                    <span class="text-gray-400 italic">— Belum diisi —</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
