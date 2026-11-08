@extends('admin_hackaton.index')

@section('contentadmin_hackaton')
    @php
        $sortedSubmissionTahap = $submission->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke ?? 0)->values();
        $defaultActiveTahapKe = $sortedSubmissionTahap->first()?->tahap?->tahap_ke ?? 1;
    @endphp
    <script>
        window.adminSubmissionDetails = function () {
            return {
                activeTahapTab: {{ (int) $defaultActiveTahapKe }},
                showAssignReviewer: false,
                showAddMember: false,
                showEditMemberModal: false,
                editMemberAction: '',
                editMemberPeran: '',
                editMemberName: '',
                editMemberIdentifier: '',
                editMemberInstitusi: '',
                editMemberPeranIc: '',
                editMemberDeskripsi: '',
                showFilePreviewModal: false,
                previewFileUrl: '',
                previewFileLabel: '',
                previewFileType: 'other',
                openEditMember(id, peran, name, identifier, institusi, peranIc, deskripsi) {
                    const baseUrl = "{{ route('admin_hackaton.submissions.members.update', [$session, $submission, 'PLACEHOLDER_ID']) }}";
                    this.editMemberAction = baseUrl.replace('PLACEHOLDER_ID', id);
                    this.editMemberPeran = peran;
                    this.editMemberName = name;
                    this.editMemberIdentifier = identifier;
                    this.editMemberInstitusi = institusi;
                    this.editMemberPeranIc = peranIc;
                    this.editMemberDeskripsi = deskripsi;
                    this.showEditMemberModal = true;
                },
                openFilePreview(url, label) {
                    this.previewFileUrl = url;
                    this.previewFileLabel = label;
                    const cleanUrl = (url || '').split('?')[0].toLowerCase();
                    if (cleanUrl.endsWith('.pdf')) {
                        this.previewFileType = 'pdf';
                    } else if (/\.(png|jpg|jpeg|gif|webp|svg)$/.test(cleanUrl)) {
                        this.previewFileType = 'image';
                    } else {
                        this.previewFileType = 'other';
                    }
                    this.showFilePreviewModal = true;
                }
            };
        };
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
                <a href="{{ route('hackaton.submissions.show', $submission) }}" target="_blank" class="border-2 border-gray-950 bg-amber-400 hover:bg-amber-500 text-gray-950 text-xs font-bold uppercase tracking-wider px-4 py-2.5 transition shadow-sm inline-flex items-center">
                    <i class="fas fa-eye mr-1.5"></i> Preview Tampilan Pengusul
                </a>
                <a href="{{ route('admin_hackaton.submissions.export_single', [$session, $submission]) }}" class="border-2 border-emerald-900 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold uppercase tracking-wider px-4 py-2.5 transition shadow-sm inline-flex items-center">
                    <i class="fas fa-file-excel mr-1.5"></i> Export Proposal
                </a>
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
            <h2 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-4">Linimasa Progres Tahapan (Klik tahap untuk melihat isian & berkas)</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($sortedSubmissionTahap as $st)
                    @php
                        $tk = $st->tahap->tahap_ke ?? $loop->iteration;
                        $tracking = $st->getTrackingStatus($hasReviewer ?? false);
                        $fVals = $st->loadedFieldValues ?? collect();
                        $totalFieldsCount = $st->tahap?->fields?->count() ?? 0;
                        $filledFieldsCount = $fVals->filter(fn($fv) => filled($fv->value))->count();
                        $boxBg = match ($tracking['key']) {
                            'lolos' => 'border-emerald-600 bg-emerald-50 text-emerald-900',
                            'perbaikan' => 'border-amber-500 bg-amber-50 text-amber-900',
                            'sedang_direview' => 'border-purple-600 bg-purple-50 text-purple-900',
                            'menunggu_review' => 'border-blue-600 bg-blue-50 text-blue-900',
                            'draft' => 'border-amber-400 bg-amber-50/50 text-amber-800',
                            default => 'border-gray-300 bg-gray-50 text-gray-600'
                        };
                    @endphp
                    <button type="button" @click="activeTahapTab = {{ (int) $tk }}"
                        class="text-left border-2 p-4 flex items-start gap-3 transition hover:border-gray-950 {{ $boxBg }}"
                        :class="activeTahapTab === {{ (int) $tk }} ? 'ring-2 ring-gray-950 border-gray-950' : ''">
                        <span class="w-8 h-8 rounded-none bg-gray-950 text-white font-black text-sm flex items-center justify-center shrink-0">
                            {{ $tk }}
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-bold uppercase tracking-wider truncate">Tahap {{ $tk }}: {{ $st->tahap->nama_tahap }}</p>
                            <p class="font-black text-sm mt-0.5">{{ $tracking['label'] }}</p>
                            <p class="text-[11px] font-semibold mt-1 opacity-80">
                                <i class="fas fa-tasks mr-1"></i> {{ $filledFieldsCount }} / {{ $totalFieldsCount }} isian terisi
                            </p>
                        </div>
                    </button>
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
                            @php
                                $isDFarm = $submission->kategori === 'd-farm' || str_contains($submission->tema, 'D-FARM');
                            @endphp
                            <div class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-black {{ $isDFarm ? 'bg-amber-100 text-amber-950 border border-amber-300' : 'bg-rose-100 text-rose-950 border border-rose-300' }}">
                                    <i class="fas {{ $isDFarm ? 'fa-wheat-awn' : 'fa-heart-pulse' }} mr-1.5"></i>
                                    {{ $isDFarm ? 'D-FARM' : 'D-MARC' }} — {{ $submission->tema_label ?? $submission->tema }}
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
                                    <option value="dosen">Dosen Internal UNJ</option>
                                    <option value="dosen_eksternal">Dosen Eksternal UNJ</option>
                                    <option value="DUDI">Mitra DUDI (Industri)</option>
                                    <option value="alumni">Alumni</option>
                                    <option value="tendik">Tendik</option>
                                    <option value="peneliti">Peneliti</option>
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

                                <button type="button"
                                    @click="openEditMember({{ $m->id }}, '{{ $m->peran }}', '{{ addslashes($m->nama_lengkap) }}', '{{ $m->nik_nim_nip }}', '{{ addslashes(str_replace(["\r", "\n"], ' ', $m->institusi_fakultas ?? '')) }}', '{{ $m->peran_ic }}', '{{ addslashes(str_replace(["\r", "\n"], ' ', $m->deskripsi_peran ?? '')) }}')"
                                    class="text-blue-600 hover:text-blue-800 p-1 text-xs font-bold" title="Edit Anggota / Peran IC">
                                    <i class="fas fa-edit"></i>
                                </button>

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

        {{-- Modal Edit Member (Admin) --}}
        <div x-show="showEditMemberModal" x-cloak
            class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-gray-950/60 backdrop-blur-sm">
            <div class="bg-white border-2 border-gray-950 max-w-lg w-full p-6 space-y-4 shadow-xl"
                @click.away="showEditMemberModal = false">
                <div class="flex items-center justify-between border-b-2 border-gray-950 pb-3">
                    <h3 class="font-black text-gray-950 text-sm uppercase tracking-wider" x-text="editMemberPeran === 'Ketua' ? 'Ubah Data Ketua / Peran IC' : 'Ubah Data Anggota'"></h3>
                    <button type="button" @click="showEditMemberModal = false" class="text-gray-500 hover:text-gray-950 font-bold text-sm">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form :action="editMemberAction" method="POST" class="space-y-3 text-xs">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-bold text-gray-900 mb-1">Nama Lengkap *</label>
                        <input type="text" name="nama_lengkap" x-model="editMemberName" required
                            class="w-full border-2 border-gray-950 px-3 py-2 text-xs bg-white">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-gray-900 mb-1">NIM / NIP / NIK</label>
                            <input type="text" name="nik_nim_nip" x-model="editMemberIdentifier"
                                class="w-full border-2 border-gray-950 px-3 py-2 text-xs bg-white">
                        </div>
                        <div>
                            <label class="block font-bold text-gray-900 mb-1">Institusi / Fakultas</label>
                            <input type="text" name="institusi_fakultas" x-model="editMemberInstitusi"
                                class="w-full border-2 border-gray-950 px-3 py-2 text-xs bg-white">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-gray-900 mb-1">Peran IC (Hacker / Hustler / Hipster) *</label>
                        <select name="peran_ic" x-model="editMemberPeranIc" required
                            class="w-full border-2 border-gray-950 px-3 py-2 text-xs bg-white font-bold">
                            <option value="Hacker">Hacker (Teknis / Developer)</option>
                            <option value="Hustler">Hustler (Bisnis / Manajerial)</option>
                            <option value="Hipster">Hipster (Desain / Kreatif)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-gray-900 mb-1">Deskripsi Tugas Spesifik</label>
                        <textarea name="deskripsi_peran" x-model="editMemberDeskripsi" rows="2"
                            class="w-full border-2 border-gray-950 px-3 py-2 text-xs bg-white"></textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-2 border-t-2 border-gray-100">
                        <button type="button" @click="showEditMemberModal = false"
                            class="px-3 py-1 font-bold text-xs uppercase border-2 border-gray-300 hover:bg-gray-100">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-1 bg-gray-950 hover:bg-gray-800 text-white font-bold text-xs uppercase">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
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
                @foreach ($sortedSubmissionTahap as $st)
                    @php
                        $tk = (int) ($st->tahap->tahap_ke ?? $loop->iteration);
                        $fVals = $st->loadedFieldValues ?? collect();
                        $totalF = $st->tahap?->fields?->count() ?? 0;
                        $filledF = $fVals->filter(fn($fv) => filled($fv->value))->count();
                    @endphp
                    <button type="button" @click="activeTahapTab = {{ $tk }}"
                        class="px-5 py-3 text-xs font-black uppercase tracking-wider border-r-2 border-gray-950 transition flex items-center gap-2"
                        :class="activeTahapTab === {{ $tk }} ? 'bg-gray-950 text-white' : 'bg-white text-gray-700 hover:bg-gray-100'">
                        <span>Tahap {{ $tk }}: {{ $st->tahap->nama_tahap }}</span>
                        <span class="px-1.5 py-0.5 text-[10px] border"
                            :class="activeTahapTab === {{ $tk }} ? 'bg-amber-400 text-gray-950 border-amber-500' : 'bg-gray-100 text-gray-700 border-gray-300'">
                            {{ $filledF }}/{{ $totalF }}
                        </span>
                    </button>
                @endforeach
            </div>

            {{-- Tab Contents --}}
            @foreach ($sortedSubmissionTahap as $st)
                @php
                    $tk = (int) ($st->tahap->tahap_ke ?? $loop->iteration);
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

                            <div class="text-xs">
                                <label class="block font-bold mb-1 uppercase tracking-wider">Keputusan Status *</label>
                                <select name="admin_status" class="w-full border-2 border-gray-950 px-3 py-2 bg-white font-bold">
                                    <option value="menunggu" {{ $st->admin_status === 'menunggu' ? 'selected' : '' }}>MENUNGGU (Belum Diputuskan)</option>
                                    <option value="disetujui" {{ $st->admin_status === 'disetujui' ? 'selected' : '' }}>DISETUJUI / LOLOS (Buka Tahap Berikutnya)</option>
                                    <option value="perbaikan" {{ $st->admin_status === 'perbaikan' ? 'selected' : '' }}>PERBAIKAN (Kembalikan ke Pengusul untuk Revisi)</option>
                                    <option value="selesai" {{ $st->admin_status === 'selesai' ? 'selected' : '' }}>SELESAI (Final Tahap)</option>
                                </select>
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
                        <div class="border-b border-gray-200 pb-3 flex flex-wrap items-center justify-between gap-2">
                            <div>
                                <h3 class="font-bold text-gray-950 uppercase tracking-wider text-xs flex items-center gap-2">
                                    <i class="fas fa-file-invoice"></i> Berkas & Isian Pengusul (Tahap {{ $tk }}: {{ $st->tahap->nama_tahap }})
                                </h3>
                                @if ($st->submitted_at)
                                    <p class="text-[11px] text-emerald-700 font-semibold mt-0.5">
                                        <i class="fas fa-check-circle mr-1"></i> Disubmit pada: {{ $st->submitted_at->format('d M Y, H:i') }}
                                    </p>
                                @endif
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-bold px-2.5 py-1 border border-gray-300 bg-gray-100 text-gray-700 uppercase">
                                    Status Pengisian: {{ strtoupper($st->status) }}
                                </span>
                                <a href="{{ route('hackaton.team.tahap', [$submission, $st->hackaton_tahap_id]) }}" target="_blank"
                                    class="inline-flex items-center gap-1.5 border border-gray-950 bg-amber-100 hover:bg-amber-200 text-gray-950 px-3 py-1 text-xs font-bold uppercase transition">
                                    <i class="fas fa-external-link-alt"></i> Preview Form Tahap {{ $tk }}
                                </a>
                            </div>
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
                                                    @php
                                                        $fileUrl = asset('storage/' . $val);
                                                        $ext = strtolower(pathinfo($val, PATHINFO_EXTENSION));
                                                        $isPreviewable = in_array($ext, ['pdf', 'png', 'jpg', 'jpeg', 'gif', 'webp', 'svg']);
                                                    @endphp
                                                    <div class="flex flex-wrap items-center gap-2">
                                                        @if ($isPreviewable)
                                                            <button type="button"
                                                                @click="openFilePreview('{{ addslashes($fileUrl) }}', '{{ addslashes($f->field_label) }}')"
                                                                class="inline-flex items-center gap-1.5 font-bold bg-gray-950 text-white px-3 py-1.5 hover:bg-gray-800 transition">
                                                                <i class="fas fa-eye"></i> Preview Berkas
                                                            </button>
                                                        @endif
                                                        <a href="{{ $fileUrl }}" target="_blank" download class="inline-flex items-center gap-1.5 font-bold border border-blue-700 bg-blue-50 text-blue-800 px-3 py-1.5 hover:bg-blue-100 transition">
                                                            <i class="fas fa-download"></i> Unduh Berkas ({{ strtoupper($ext ?: 'FILE') }})
                                                        </a>
                                                    </div>
                                                @elseif ($f->field_type === 'url' && $val)
                                                    <a href="{{ $val }}" target="_blank" class="inline-flex items-center gap-1.5 font-bold text-blue-700 hover:underline break-all">
                                                        <i class="fas fa-external-link-alt"></i> {{ $val }}
                                                    </a>
                                                @elseif (filled($val))
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
                                                    @php
                                                        $fileUrl = asset('storage/' . $val);
                                                        $ext = strtolower(pathinfo($val, PATHINFO_EXTENSION));
                                                        $isPreviewable = in_array($ext, ['pdf', 'png', 'jpg', 'jpeg', 'gif', 'webp', 'svg']);
                                                    @endphp
                                                    <div class="flex flex-wrap items-center gap-2">
                                                        @if ($isPreviewable)
                                                            <button type="button"
                                                                @click="openFilePreview('{{ addslashes($fileUrl) }}', '{{ addslashes($f->field_label) }}')"
                                                                class="inline-flex items-center gap-1.5 font-bold bg-gray-950 text-white px-3 py-1.5 hover:bg-gray-800 transition">
                                                                <i class="fas fa-eye"></i> Preview Berkas
                                                            </button>
                                                        @endif
                                                        <a href="{{ $fileUrl }}" target="_blank" download class="inline-flex items-center gap-1.5 font-bold border border-blue-700 bg-blue-50 text-blue-800 px-3 py-1.5 hover:bg-blue-100 transition">
                                                            <i class="fas fa-download"></i> Unduh Berkas ({{ strtoupper($ext ?: 'FILE') }})
                                                        </a>
                                                    </div>
                                                @elseif ($f->field_type === 'url' && $val)
                                                    <a href="{{ $val }}" target="_blank" class="inline-flex items-center gap-1.5 font-bold text-blue-700 hover:underline break-all">
                                                        <i class="fas fa-external-link-alt"></i> {{ $val }}
                                                    </a>
                                                @elseif (filled($val))
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

        {{-- Modal Preview Berkas --}}
        <div x-show="showFilePreviewModal" x-cloak
            class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-gray-950/70 backdrop-blur-sm">
            <div class="bg-white border-2 border-gray-950 max-w-5xl w-full overflow-hidden flex flex-col max-h-[90vh]"
                @click.away="showFilePreviewModal = false">
                <div class="flex items-center justify-between border-b-2 border-gray-950 bg-gray-100 px-5 py-3">
                    <h3 class="font-black text-gray-950 text-sm uppercase tracking-wider truncate" x-text="'Preview Berkas: ' + previewFileLabel"></h3>
                    <div class="flex items-center gap-2">
                        <a :href="previewFileUrl" target="_blank" class="bg-gray-950 text-white px-3 py-1 text-xs font-bold uppercase hover:bg-gray-800">
                            <i class="fas fa-external-link-alt mr-1"></i> Buka di Tab Baru
                        </a>
                        <button type="button" @click="showFilePreviewModal = false" class="text-gray-600 hover:text-gray-950 font-bold text-sm px-2 py-1">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 flex-1 overflow-auto flex items-center justify-center min-h-[65vh]">
                    <template x-if="previewFileType === 'pdf'">
                        <iframe :src="previewFileUrl" class="w-full h-[70vh] border border-gray-300 bg-white"></iframe>
                    </template>
                    <template x-if="previewFileType === 'image'">
                        <img :src="previewFileUrl" :alt="previewFileLabel" class="max-h-[70vh] max-w-full object-contain border border-gray-300 bg-white">
                    </template>
                    <template x-if="previewFileType === 'other'">
                        <div class="text-center space-y-3 p-8">
                            <p class="text-sm text-gray-700 font-semibold">Format berkas ini tidak dapat ditampilkan langsung di dalam browser.</p>
                            <a :href="previewFileUrl" target="_blank" download class="inline-flex items-center gap-2 bg-gray-950 text-white px-4 py-2 text-xs font-bold uppercase">
                                <i class="fas fa-download"></i> Unduh Berkas
                            </a>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
@endsection
