@extends('admin_inovasi.index')

@section('contentadmin_inovasi')
    <div class="bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Breadcrumb --}}
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="{{ route('admin_inovasi.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="{{ route('admin_inovasi.inovchalenge.sessions.index') }}"
                            class="hover:text-teal-600">Innovation Challenge</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-gray-700 font-medium">Submissions</li>
                </ol>
            </nav>

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Submissions</h1>
                    <p class="mt-1 text-sm text-gray-500">Kelola semua submission Innovation Challenge</p>
                </div>
            </div>

            {{-- Filters --}}
            <div class="bg-white rounded-2xl shadow border border-gray-100 p-5 mb-6">
                <form method="GET" action="{{ route('admin_inovasi.inovchalenge.submissions.index') }}"
                    class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Sesi</label>
                        <select name="session_id"
                            class="w-full rounded-lg border-gray-300 text-sm focus:border-teal-500 focus:ring-teal-500">
                            <option value="">Semua Sesi</option>
                            @foreach ($sessions as $session)
                                <option value="{{ $session->id }}"
                                    {{ request('session_id') == $session->id ? 'selected' : '' }}>
                                    {{ $session->nama_sesi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Status</label>
                        <select name="status"
                            class="w-full rounded-lg border-gray-300 text-sm focus:border-teal-500 focus:ring-teal-500">
                            <option value="">Semua Status</option>
                            @foreach (['draft', 'diajukan', 'menunggu_direview', 'sedang_direview', 'perbaikan_diperlukan', 'proses_tahap_selanjutnya', 'selesai'] as $st)
                                <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $st)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Cari Dosen</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama dosen..."
                            class="w-full rounded-lg border-gray-300 text-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-teal-500 text-white text-sm font-medium rounded-lg hover:bg-teal-600 transition">
                            <i class="fas fa-filter mr-1.5"></i> Filter
                        </button>
                        <a href="{{ route('admin_inovasi.inovchalenge.submissions.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition">
                            <i class="fas fa-times mr-1.5"></i> Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- Flash --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Table Card --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 rounded-t-2xl">
                    <h2 class="text-white font-semibold text-lg">
                        <i class="fas fa-file-alt mr-2"></i> Daftar Submission
                        <span
                            class="ml-2 bg-white/20 text-white text-sm px-3 py-0.5 rounded-full">{{ $submissions->total() }}</span>
                    </h2>
                </div>

                {{-- Desktop Table --}}
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    #</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Dosen</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Sesi</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Tahap</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Anggota</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Reviewer</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($submissions as $sub)
                                @php
                                    $statusColors = [
                                        'draft' => 'bg-gray-100 text-gray-700',
                                        'diajukan' => 'bg-blue-100 text-blue-700',
                                        'menunggu_direview' => 'bg-yellow-100 text-yellow-700',
                                        'sedang_direview' => 'bg-purple-100 text-purple-700',
                                        'perbaikan_diperlukan' => 'bg-orange-100 text-orange-700',
                                        'proses_tahap_selanjutnya' => 'bg-cyan-100 text-cyan-700',
                                        'selesai' => 'bg-green-100 text-green-700',
                                    ];
                                    $statusKey = is_object($sub->status) ? $sub->status->value : $sub->status;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $loop->iteration + ($submissions->currentPage() - 1) * $submissions->perPage() }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-gray-900">{{ $sub->user->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $sub->user->email }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ Str::limit($sub->session->nama_sesi, 30) }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-1">
                                            @foreach ($sub->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke) as $st)
                                                @php
                                                    $tc = match ($st->status) {
                                                        'belum_diisi' => 'bg-gray-200 text-gray-500',
                                                        'draft' => 'bg-yellow-200 text-yellow-700',
                                                        'diajukan' => 'bg-green-200 text-green-700',
                                                        default => 'bg-gray-200 text-gray-500',
                                                    };
                                                @endphp
                                                <span
                                                    class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-[10px] font-bold {{ $tc }}"
                                                    title="T{{ $st->tahap->tahap_ke }}: {{ $st->status }} / {{ $st->admin_status }}">
                                                    {{ $st->tahap->tahap_ke }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $totalMembers = $sub->members->count();
                                            $pendingMembers = $sub->members->where('approval_status', 'pending')->count();
                                            $approvedMembers = $sub->members->where('approval_status', 'approved')->count()
                                                + $sub->members->where('approval_status', 'not_required')->count();
                                        @endphp
                                        <div class="flex flex-col items-center gap-0.5">
                                            <span class="text-xs text-gray-600 font-medium">{{ $totalMembers }}</span>
                                            @if ($pendingMembers > 0)
                                                <span class="inline-flex items-center px-1.5 py-0 rounded-full text-[9px] font-bold bg-yellow-100 text-yellow-700">
                                                    <i class="fas fa-clock mr-0.5 text-[7px]"></i>{{ $pendingMembers }}
                                                </span>
                                            @elseif($totalMembers > 0)
                                                <span class="inline-flex items-center px-1.5 py-0 rounded-full text-[9px] font-bold bg-green-100 text-green-700">
                                                    <i class="fas fa-check mr-0.5 text-[7px]"></i>OK
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $statusColors[$statusKey] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ ucwords(str_replace('_', ' ', $statusKey)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm text-gray-500">
                                        {{ $sub->reviewers_count }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('admin_inovasi.inovchalenge.submissions.show', $sub) }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-teal-500 text-white text-xs font-medium rounded-lg hover:bg-teal-600 transition">
                                            <i class="fas fa-eye mr-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                                        <i class="fas fa-inbox text-3xl mb-2"></i>
                                        <p>Belum ada submission</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Cards --}}
                <div class="lg:hidden divide-y divide-gray-100">
                    @forelse($submissions as $sub)
                        @php
                            $statusKey = is_object($sub->status) ? $sub->status->value : $sub->status;
                        @endphp
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-semibold text-gray-900">{{ $sub->user->name }}</p>
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $statusColors[$statusKey] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucwords(str_replace('_', ' ', $statusKey)) }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mb-2">{{ $sub->session->nama_sesi }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex gap-1">
                                    @foreach ($sub->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke) as $st)
                                        @php
                                            $tc = match ($st->status) {
                                                'belum_diisi' => 'bg-gray-200 text-gray-500',
                                                'draft' => 'bg-yellow-200 text-yellow-700',
                                                'diajukan' => 'bg-green-200 text-green-700',
                                                default => 'bg-gray-200 text-gray-500',
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex items-center justify-center w-6 h-6 rounded text-[10px] font-bold {{ $tc }}">{{ $st->tahap->tahap_ke }}</span>
                                    @endforeach
                                </div>
                                <a href="{{ route('admin_inovasi.inovchalenge.submissions.show', $sub) }}"
                                    class="text-teal-600 text-xs font-medium hover:underline">Detail →</a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-400">Belum ada submission</div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if ($submissions->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 rounded-b-2xl">
                        {{ $submissions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
