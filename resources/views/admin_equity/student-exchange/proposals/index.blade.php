@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li><a href="{{ route('admin_equity.student_exchange.sesi.index') }}" class="hover:text-teal-600">Student Exchange</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li><a href="{{ route('admin_equity.student_exchange.sesi.show', $sesi->id) }}" class="hover:text-teal-600">{{ $sesi->nama_sesi }}</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li class="font-medium text-gray-800">Daftar Proposal</li>
                </ol>
            </nav>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Proposal - {{ $sesi->nama_sesi }}</h1>
                <p class="mt-2 text-gray-600">Kelola dan review proposal pertukaran mahasiswa</p>
            </div>
        </header>

        {{-- Filter & Search --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
            <form method="GET" action="{{ route('admin_equity.student_exchange.proposals.index', $sesi->id) }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    {{-- Search --}}
                    <div class="md:col-span-2">
                        <input type="text" 
                               name="search"
                               value="{{ request('search') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                               placeholder="Cari judul proposal atau nama pengusul...">
                    </div>
                    {{-- Status Filter --}}
                    <div>
                        <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            <option value="">Semua Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="menunggu_verifikasi" {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="menunggu_direview" {{ request('status') == 'menunggu_direview' ? 'selected' : '' }}>Menunggu Direview</option>
                            <option value="sedang_direview" {{ request('status') == 'sedang_direview' ? 'selected' : '' }}>Sedang Direview</option>
                            <option value="lolos" {{ request('status') == 'lolos' ? 'selected' : '' }}>Lolos</option>
                            <option value="tidak_lolos" {{ request('status') == 'tidak_lolos' ? 'selected' : '' }}>Tidak Lolos</option>
                        </select>
                    </div>
                    {{-- Jenis Filter --}}
                    <div>
                        <select name="jenis" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            <option value="">Semua Jenis</option>
                            <option value="inbound" {{ request('jenis') == 'inbound' ? 'selected' : '' }}>Inbound</option>
                            <option value="outbound" {{ request('jenis') == 'outbound' ? 'selected' : '' }}>Outbound</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ route('admin_equity.student_exchange.proposals.index', $sesi->id) }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Reset
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700 transition-all">
                        <i class='bx bx-search mr-2'></i>
                        Cari
                    </button>
                </div>
            </form>
        </div>

        {{-- Alert Messages --}}
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <div class="flex items-center">
                <i class='bx bx-check-circle text-green-500 text-2xl mr-3'></i>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        {{-- Proposals Table --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-6">
                <div class="flex items-center justify-between text-white">
                    <h2 class="text-xl font-bold flex items-center">
                        <i class='bx bx-file-find mr-3 text-2xl'></i>
                        Daftar Proposal
                    </h2>
                    <span class="text-teal-100 text-sm">Total: <span class="font-semibold text-white">{{ $proposals->total() }}</span></span>
                </div>
            </div>

            {{-- Desktop View --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Judul Kegiatan</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Pengusul</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Jenis</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Peserta</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($proposals as $index => $proposal)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $proposals->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">{{ Str::limit($proposal->judul_kegiatan, 50) }}</div>
                                @if($proposal->ringkasan_kegiatan)
                                <div class="text-sm text-gray-500 mt-1">{{ Str::limit($proposal->ringkasan_kegiatan, 60) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div>{{ $proposal->user->name ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500">{{ $proposal->user->email ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($proposal->jenis_kegiatan === 'inbound')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                    <i class='bx bx-log-in mr-1'></i>Inbound
                                </span>
                                @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                    <i class='bx bx-log-out mr-1'></i>Outbound
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div class="flex items-center">
                                    <i class='bx bx-user text-teal-500 mr-1'></i>
                                    {{ $proposal->jumlah_peserta }} mahasiswa
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @include('admin_equity.student-exchange.partials.status-badge', ['status' => $proposal->status])
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin_equity.student_exchange.proposals.show', [$sesi->id, $proposal->id]) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail">
                                        <i class='bx bx-show text-xl'></i>
                                    </a>
                                    @if($proposal->status === 'menunggu_verifikasi')
                                    <button onclick="verifyProposal({{ $proposal->id }})" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Verifikasi">
                                        <i class='bx bx-check-circle text-xl'></i>
                                    </button>
                                    <button onclick="rejectProposal({{ $proposal->id }})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Tolak">
                                        <i class='bx bx-x-circle text-xl'></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center">
                                <i class='bx bx-inbox text-5xl text-gray-300 mb-2'></i>
                                <p class="text-gray-500">Tidak ada proposal ditemukan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile View --}}
            <div class="lg:hidden space-y-4 p-4">
                @forelse($proposals as $proposal)
                <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 mb-1">{{ Str::limit($proposal->judul_kegiatan, 40) }}</h3>
                                <p class="text-sm text-gray-500">{{ $proposal->user->name ?? 'N/A' }}</p>
                            </div>
                            @include('admin_equity.student-exchange.partials.status-badge', ['status' => $proposal->status])
                        </div>
                        <div class="space-y-2 mb-3">
                            <div class="flex items-center text-sm text-gray-600">
                                @if($proposal->jenis_kegiatan === 'inbound')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                    <i class='bx bx-log-in mr-1'></i>Inbound
                                </span>
                                @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                    <i class='bx bx-log-out mr-1'></i>Outbound
                                </span>
                                @endif
                                <span class="ml-3 flex items-center">
                                    <i class='bx bx-user text-teal-500 mr-1'></i>
                                    {{ $proposal->jumlah_peserta }} mahasiswa
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center justify-end space-x-2 pt-3 border-t">
                            <a href="{{ route('admin_equity.student_exchange.proposals.show', [$sesi->id, $proposal->id]) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <i class='bx bx-show text-xl'></i>
                            </a>
                            @if($proposal->status === 'menunggu_verifikasi')
                            <button onclick="verifyProposal({{ $proposal->id }})" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors">
                                <i class='bx bx-check-circle text-xl'></i>
                            </button>
                            <button onclick="rejectProposal({{ $proposal->id }})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                <i class='bx bx-x-circle text-xl'></i>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-xl shadow p-8 text-center">
                    <i class='bx bx-inbox text-5xl text-gray-300 mb-2'></i>
                    <p class="text-gray-500">Tidak ada proposal ditemukan</p>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($proposals->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t">
                {{ $proposals->appends(request()->query())->links() }}
            </div>
            @endif
        </div>

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function verifyProposal(id) {
    Swal.fire({
        title: 'Verifikasi Proposal',
        text: "Proposal akan diverifikasi dan masuk tahap review",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10B981',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Verifikasi!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin-equity/student-exchange/sesi/{{ $sesi->id }}/proposals/${id}/verify`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function rejectProposal(id) {
    Swal.fire({
        title: 'Tolak Proposal',
        input: 'textarea',
        inputLabel: 'Alasan Penolakan',
        inputPlaceholder: 'Jelaskan alasan penolakan proposal...',
        inputAttributes: {
            'aria-label': 'Alasan penolakan'
        },
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Tolak',
        cancelButtonText: 'Batal',
        inputValidator: (value) => {
            if (!value) {
                return 'Alasan penolakan harus diisi!'
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin-equity/student-exchange/sesi/{{ $sesi->id }}/proposals/${id}/reject`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const alasanInput = document.createElement('input');
            alasanInput.type = 'hidden';
            alasanInput.name = 'alasan_penolakan';
            alasanInput.value = result.value;
            
            form.appendChild(csrfToken);
            form.appendChild(alasanInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush
@endsection
