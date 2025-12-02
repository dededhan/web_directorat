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
                    <li class="font-medium text-gray-800">Student Exchange</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Manajemen Sesi Student Exchange</h1>
                    <p class="mt-2 text-gray-600">Kelola sesi pertukaran mahasiswa untuk dosen</p>
                </div>
                <a href="{{ route('admin_equity.student_exchange.sesi.create') }}" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md">
                    <i class='bx bx-plus mr-2'></i>
                    Buat Sesi Baru
                </a>
            </div>
        </header>

        {{-- Alert Messages --}}
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <div class="flex items-center">
                <i class='bx bx-check-circle text-green-500 text-2xl mr-3'></i>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
            <div class="flex items-center">
                <i class='bx bx-error-circle text-red-500 text-2xl mr-3'></i>
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-6">
                <div class="flex items-center justify-between text-white">
                    <h2 class="text-xl font-bold flex items-center">
                        <i class='bx bx-list-ul mr-3 text-2xl'></i>
                        Daftar Sesi
                    </h2>
                    <span class="text-teal-100 text-sm">Total: <span class="font-semibold text-white">{{ $sessions->total() }}</span></span>
                </div>
            </div>

            {{-- Desktop View --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Nama Sesi</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Periode</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Jumlah Proposal</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($sessions as $index => $session)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $sessions->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">{{ $session->nama_sesi }}</div>
                                @if($session->deskripsi)
                                <div class="text-sm text-gray-500 mt-1">{{ Str::limit($session->deskripsi, 50) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div class="flex items-center space-x-2">
                                    <i class='bx bx-calendar text-orange-500'></i>
                                    <span>{{ $session->periode_awal->format('d M Y') }} - {{ $session->periode_akhir->format('d M Y') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($session->status === 'dibuka')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Dibuka</span>
                                @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditutup</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                    <i class='bx bx-file mr-1'></i>
                                    {{ $session->proposals_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin_equity.student_exchange.sesi.show', $session->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail">
                                        <i class='bx bx-show text-xl'></i>
                                    </a>
                                    <a href="{{ route('admin_equity.student_exchange.sesi.edit', $session->id) }}" class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors" title="Edit">
                                        <i class='bx bx-edit text-xl'></i>
                                    </a>
                                    <button onclick="confirmDelete({{ $session->id }})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <i class='bx bx-trash text-xl'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center">
                                <i class='bx bx-inbox text-5xl text-gray-300 mb-2'></i>
                                <p class="text-gray-500">Belum ada sesi student exchange</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile View --}}
            <div class="lg:hidden space-y-4 p-4">
                @forelse($sessions as $session)
                <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 mb-1">{{ $session->nama_sesi }}</h3>
                                @if($session->deskripsi)
                                <p class="text-sm text-gray-500">{{ Str::limit($session->deskripsi, 50) }}</p>
                                @endif
                            </div>
                            @if($session->status === 'dibuka')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Dibuka</span>
                            @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditutup</span>
                            @endif
                        </div>
                        <div class="space-y-2 mb-3">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class='bx bx-calendar text-orange-500 mr-2'></i>
                                <span>{{ $session->periode_awal->format('d M Y') }} - {{ $session->periode_akhir->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class='bx bx-file text-blue-500 mr-2'></i>
                                <span>{{ $session->proposals_count }} Proposal</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-end space-x-2 pt-3 border-t">
                            <a href="{{ route('admin_equity.student_exchange.sesi.show', $session->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <i class='bx bx-show text-xl'></i>
                            </a>
                            <a href="{{ route('admin_equity.student_exchange.sesi.edit', $session->id) }}" class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors">
                                <i class='bx bx-edit text-xl'></i>
                            </a>
                            <button onclick="confirmDelete({{ $session->id }})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                <i class='bx bx-trash text-xl'></i>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-xl shadow p-8 text-center">
                    <i class='bx bx-inbox text-5xl text-gray-300 mb-2'></i>
                    <p class="text-gray-500">Belum ada sesi student exchange</p>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($sessions->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t">
                {{ $sessions->links() }}
            </div>
            @endif
        </div>

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data sesi dan semua proposal terkait akan dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin-equity/student-exchange/sesi/${id}`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(methodInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush
@endsection
