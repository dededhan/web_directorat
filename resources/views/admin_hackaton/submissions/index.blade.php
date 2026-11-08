@extends('admin_hackaton.index')

@section('contentadmin_hackaton')
    <div class="space-y-8">
        {{-- Breadcrumb & Header --}}
        <div class="border-b-4 border-gray-950 pb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <p class="mb-2 text-sm font-bold uppercase tracking-[0.18em] text-gray-600">
                    <a href="{{ route('admin_hackaton.sessions.index') }}" class="hover:underline">Admin Hackaton / Sesi</a> /
                    <a href="{{ route('admin_hackaton.sessions.show', $session) }}" class="hover:underline">{{ $session->nama_sesi }}</a> /
                    Proposal
                </p>
                <h1 class="text-3xl font-black text-gray-950 sm:text-4xl">Daftar Proposal Hackaton</h1>
                <p class="mt-2 text-base text-gray-700">Proposal pengusul untuk sesi: <strong>{{ $session->nama_sesi }}</strong></p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin_hackaton.submissions.export', array_merge(['session' => $session], request()->query())) }}"
                    class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold uppercase tracking-wider px-4 py-3 transition flex items-center gap-2 border border-black">
                    <i class="fas fa-file-excel"></i> Export Proposal
                </a>
                <a href="{{ route('admin_hackaton.submissions.scores', $session) }}" class="bg-amber-500 hover:bg-amber-600 text-gray-950 text-xs font-bold uppercase tracking-wider px-4 py-3 transition flex items-center gap-2 border border-black">
                    <i class="fas fa-trophy"></i> Ranking Nilai
                </a>
                <a href="{{ route('admin_hackaton.sessions.show', $session) }}" class="bg-white hover:bg-gray-100 text-gray-950 text-xs font-bold uppercase tracking-wider px-4 py-3 transition flex items-center gap-2 border border-black">
                    <i class="fas fa-arrow-left"></i> Kembali ke Sesi
                </a>
            </div>
        </div>

        {{-- Filter & Search --}}
        @php
            $hasActiveFilter = request()->anyFilled(['search', 'kategori', 'status', 'role', 'skema', 'tahap_id', 'tahap_status', 'reviewer_status']);
            $roleFilterOptions = [
                'hackaton_dosen' => 'Dosen Internal UNJ',
                'hackaton_dosen_eksternal' => 'Dosen Eksternal UNJ',
                'hackaton_tendik' => 'Tendik',
                'hackaton_mahasiswa' => 'Mahasiswa',
                'hackaton_alumni' => 'Alumni',
                'hackaton_peneliti' => 'Peneliti',
                'hackaton_dudi' => 'DUDI',
            ];
            $statusFilterOptions = [
                'submitted' => 'Semua Proposal Diajukan (Non-Draft)',
                'draft' => 'Draft',
                'diajukan' => 'Diajukan',
                'menunggu_direview' => 'Menunggu Direview',
                'sedang_direview' => 'Sedang Direview',
                'perbaikan_diperlukan' => 'Perbaikan Diperlukan',
                'proses_tahap_selanjutnya' => 'Proses Tahap Selanjutnya',
                'selesai' => 'Selesai',
            ];
            $tahapStatusOptions = [
                'diajukan' => 'Sudah Submit (Diajukan)',
                'lolos' => 'Lolos / Disetujui Admin',
                'menunggu_admin' => 'Menunggu Keputusan Admin',
                'perbaikan' => 'Perbaikan Diperlukan',
                'draft' => 'Masih Draft',
                'belum_diisi' => 'Belum Diisi',
            ];
        @endphp
        <div class="border-2 border-gray-950 bg-white p-5 space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-200 pb-3">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500 mr-2">Filter Kategori:</span>
                    <a href="{{ route('admin_hackaton.submissions.index', array_merge(['session' => $session], request()->except(['kategori', 'page']))) }}"
                        class="px-3 py-1.5 text-xs font-bold uppercase tracking-wider border {{ !request('kategori') ? 'bg-gray-950 text-white border-gray-950' : 'bg-white text-gray-700 border-gray-300 hover:border-black' }}">
                        Semua ({{ $session->submissions->count() }})
                    </a>
                    <a href="{{ route('admin_hackaton.submissions.index', array_merge(['session' => $session, 'kategori' => 'd-farm'], request()->except(['kategori', 'page']))) }}"
                        class="px-3 py-1.5 text-xs font-bold uppercase tracking-wider border {{ request('kategori') === 'd-farm' ? 'bg-amber-500 text-gray-950 border-amber-600' : 'bg-amber-50 text-amber-900 border-amber-200 hover:border-amber-400' }}">
                        <i class="fas fa-wheat-awn mr-1"></i> D-FARM ({{ $dFarmCount ?? 0 }})
                    </a>
                    <a href="{{ route('admin_hackaton.submissions.index', array_merge(['session' => $session, 'kategori' => 'd-marc'], request()->except(['kategori', 'page']))) }}"
                        class="px-3 py-1.5 text-xs font-bold uppercase tracking-wider border {{ in_array(request('kategori'), ['d-marc', 'd-tech']) ? 'bg-rose-600 text-white border-rose-700' : 'bg-rose-50 text-rose-900 border-rose-200 hover:border-rose-400' }}">
                        <i class="fas fa-heart-pulse mr-1"></i> D-MARC ({{ $dMarcCount ?? $dTechCount ?? 0 }})
                    </a>
                </div>

                <a href="{{ route('admin_hackaton.submissions.export', array_merge(['session' => $session], request()->query())) }}"
                    class="inline-flex items-center gap-1.5 bg-emerald-700 hover:bg-emerald-800 text-white px-3.5 py-1.5 text-xs font-bold uppercase tracking-wider border border-black transition">
                    <i class="fas fa-download"></i> Export Sesuai Filter ({{ $submissions->total() }})
                </a>
            </div>

            <form method="GET" action="{{ route('admin_hackaton.submissions.index', $session) }}" class="space-y-4">
                @if (request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div class="sm:col-span-2">
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-600 mb-1">Pencarian</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama ketua, email, nama produk, bidang, atau anggota..."
                            class="w-full border-2 border-gray-950 px-3.5 py-2 text-xs focus:bg-amber-50 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-600 mb-1">Status Proposal</label>
                        <select name="status" class="w-full border-2 border-gray-950 px-3 py-2 text-xs bg-white focus:outline-none">
                            <option value="">-- Semua Status Proposal --</option>
                            @foreach ($statusFilterOptions as $sKey => $sLabel)
                                <option value="{{ $sKey }}" {{ request('status') === $sKey ? 'selected' : '' }}>{{ $sLabel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-600 mb-1">Role Ketua Pengusul</label>
                        <select name="role" class="w-full border-2 border-gray-950 px-3 py-2 text-xs bg-white focus:outline-none">
                            <option value="">-- Semua Role Ketua --</option>
                            @foreach ($roleFilterOptions as $rKey => $rLabel)
                                <option value="{{ $rKey }}" {{ request('role') === $rKey ? 'selected' : '' }}>{{ $rLabel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-600 mb-1">Tahap Evaluasi</label>
                        <select name="tahap_id" class="w-full border-2 border-gray-950 px-3 py-2 text-xs bg-white focus:outline-none">
                            <option value="">-- Semua Tahap --</option>
                            @foreach ($session->tahap as $thp)
                                <option value="{{ $thp->id }}" {{ (string) request('tahap_id') === (string) $thp->id ? 'selected' : '' }}>
                                    Tahap {{ $thp->tahap_ke }}: {{ $thp->nama_tahap }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-600 mb-1">Status pada Tahap</label>
                        <select name="tahap_status" class="w-full border-2 border-gray-950 px-3 py-2 text-xs bg-white focus:outline-none">
                            <option value="">-- Semua Status Tahap --</option>
                            @foreach ($tahapStatusOptions as $tsKey => $tsLabel)
                                <option value="{{ $tsKey }}" {{ request('tahap_status') === $tsKey ? 'selected' : '' }}>{{ $tsLabel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-600 mb-1">Skema Inovasi</label>
                        <select name="skema" class="w-full border-2 border-gray-950 px-3 py-2 text-xs bg-white focus:outline-none">
                            <option value="">-- Semua Skema --</option>
                            @foreach ($skemaList ?? [] as $skemaItem)
                                <option value="{{ $skemaItem }}" {{ request('skema') === $skemaItem ? 'selected' : '' }}>{{ $skemaItem }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-600 mb-1">Penugasan Reviewer</label>
                        <select name="reviewer_status" class="w-full border-2 border-gray-950 px-3 py-2 text-xs bg-white focus:outline-none">
                            <option value="">-- Semua Reviewer --</option>
                            <option value="assigned" {{ request('reviewer_status') === 'assigned' ? 'selected' : '' }}>Sudah Ada Reviewer</option>
                            <option value="unassigned" {{ request('reviewer_status') === 'unassigned' ? 'selected' : '' }}>Belum Diassign Reviewer</option>
                            @if (!empty($availableReviewers) && $availableReviewers->isNotEmpty())
                                <optgroup label="Filter Nama Reviewer">
                                    @foreach ($availableReviewers as $rev)
                                        <option value="{{ $rev->id }}" {{ (string) request('reviewer_status') === (string) $rev->id ? 'selected' : '' }}>
                                            {{ $rev->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif
                        </select>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-end gap-2 pt-2 border-t border-gray-100">
                    @if ($hasActiveFilter)
                        <a href="{{ route('admin_hackaton.submissions.index', $session) }}"
                            class="border-2 border-gray-950 bg-white px-4 py-2 text-xs font-bold uppercase text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-undo mr-1"></i> Reset Filter
                        </a>
                    @endif
                    <button type="submit" class="bg-gray-950 text-white px-5 py-2 text-xs font-bold uppercase tracking-wider hover:bg-gray-800 border-2 border-gray-950">
                        <i class="fas fa-filter mr-1"></i> Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        {{-- Submissions Table --}}
        <div class="border-2 border-gray-950 bg-white overflow-hidden">
            <div class="border-b-2 border-gray-950 bg-gray-100 px-6 py-4 flex items-center justify-between">
                <h2 class="font-bold text-gray-900 uppercase tracking-wider text-sm flex items-center gap-2">
                    <i class="fas fa-file-alt"></i> Semua Proposal Masuk
                </h2>
                <span class="bg-gray-950 text-white text-xs font-bold px-2.5 py-1">{{ $submissions->total() }} Proposal</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b-2 border-gray-950 bg-white text-xs uppercase tracking-wider text-gray-700">
                            <th class="p-4 w-12 text-center">#</th>
                            <th class="p-4">Ketua Tim / Pengusul</th>
                            <th class="p-4">Produk & Skema</th>
                            <th class="p-4 text-center">Anggota</th>
                            <th class="p-4 text-center">Progress Tahapan</th>
                            <th class="p-4 text-center">Reviewer</th>
                            <th class="p-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse ($submissions as $sub)
                            @php
                                $isDFarm = $sub->kategori === 'd-farm' || str_contains($sub->tema ?? '', 'D-FARM');
                                $roleName = match($sub->user->role ?? '') {
                                    'hackaton_dosen', 'dosen' => 'Dosen Internal UNJ',
                                    'hackaton_dosen_eksternal' => 'Dosen Eksternal UNJ',
                                    'hackaton_tendik', 'tendik' => 'Tendik',
                                    'hackaton_alumni' => 'Alumni',
                                    'hackaton_peneliti' => 'Peneliti',
                                    'hackaton_dudi' => 'DUDI',
                                    'hackaton_mahasiswa' => 'Mahasiswa',
                                    default => ucfirst(str_replace('hackaton_', '', $sub->user->role ?? 'Pengusul')),
                                };
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 text-center text-gray-500 font-semibold">
                                    {{ $loop->iteration + ($submissions->currentPage() - 1) * $submissions->perPage() }}
                                </td>
                                <td class="p-4">
                                    <div class="font-bold text-gray-950">{{ $sub->user->name ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $sub->user->email ?? '-' }}</div>
                                    <span class="inline-block mt-1 text-[10px] font-bold uppercase px-2 py-0.5 border border-gray-300 bg-gray-100 text-gray-700">
                                        {{ $roleName }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <div class="font-bold text-gray-900">{{ $sub->identitas?->nama_produk ?? '— Belum Diisi —' }}</div>
                                    @if ($sub->identitas?->bidang_utama_produk)
                                        <div class="text-[11px] text-gray-400 mt-0.5">Bidang: {{ $sub->identitas->bidang_utama_produk }}</div>
                                    @endif
                                    <div class="mt-1">
                                        <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-black {{ $isDFarm ? 'bg-amber-100 text-amber-950 border border-amber-300' : 'bg-rose-100 text-rose-950 border border-rose-300' }}">
                                            <i class="fas {{ $isDFarm ? 'fa-wheat-awn' : 'fa-heart-pulse' }} mr-1"></i>
                                            {{ $isDFarm ? 'D-FARM' : 'D-MARC' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-4 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-bold bg-purple-100 text-purple-900 border border-purple-300">
                                        <i class="fas fa-users mr-1 text-[10px]"></i> {{ $sub->members->count() }} orang
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="inline-flex items-center gap-1.5">
                                        @foreach ($sub->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke ?? 0) as $st)
                                            @php
                                                $tk = $st->tahap->tahap_ke ?? $loop->iteration;
                                                $tracking = $st->getTrackingStatus($hasReviewerMap[$sub->id] ?? false);
                                                $badgeBg = match ($tracking['key']) {
                                                    'lolos' => 'bg-emerald-600 text-white',
                                                    'perbaikan' => 'bg-amber-500 text-black',
                                                    'sedang_direview' => 'bg-purple-600 text-white',
                                                    'menunggu_review' => 'bg-blue-600 text-white',
                                                    'draft' => 'bg-amber-200 text-amber-900',
                                                    default => 'bg-gray-200 text-gray-600'
                                                };
                                            @endphp
                                            <span class="w-6 h-6 text-xs font-black flex items-center justify-center {{ $badgeBg }}" title="Tahap {{ $tk }}: {{ $tracking['label'] }}">
                                                T{{ $tk }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="p-4 text-center text-xs">
                                    @if ($sub->reviewers->isNotEmpty())
                                        <span class="inline-flex items-center px-2 py-1 font-bold bg-blue-100 text-blue-900 border border-blue-300">
                                            {{ $sub->reviewers->count() }} Reviewer
                                        </span>
                                    @else
                                        <span class="text-gray-400 italic text-[11px]">Belum diassign</span>
                                    @endif
                                </td>
                                <td class="p-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1">
                                        <a href="{{ route('admin_hackaton.submissions.show', [$session, $sub]) }}" class="bg-gray-950 text-white text-xs font-bold uppercase tracking-wider px-3 py-2 hover:bg-gray-800 transition">
                                            Detail & Review
                                        </a>

                                        <a href="{{ route('admin_hackaton.submissions.export_single', [$session, $sub]) }}" class="border border-emerald-300 bg-white text-emerald-700 p-2 text-xs hover:bg-emerald-50 transition" title="Export Proposal Ini (Excel)">
                                            <i class="fas fa-file-excel"></i>
                                        </a>

                                        <form action="{{ route('admin_hackaton.submissions.destroy', [$session, $sub]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus submission ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="border border-rose-300 bg-white text-rose-600 p-2 text-xs hover:bg-rose-50" title="Hapus Proposal">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-500 italic">
                                    Belum ada proposal yang diajukan pada sesi ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($submissions->hasPages())
                <div class="p-4 border-t-2 border-gray-950 bg-gray-50">
                    {{ $submissions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
