@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="submissions">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Visiting Professors</li>
                </ol>
            </nav>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Proposal: Visiting Professors</h1>
                <p class="mt-2 text-gray-600 text-base">Kelola semua pengajuan proposal dari fakultas untuk program Visiting Professors.</p>
            </div>
        </header>

        {{-- Main Content --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            
            {{-- Header Card --}}
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-white">
                    <div>
                        <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                            <i class='bx bx-user-voice mr-3 text-2xl'></i>
                            Daftar Pengajuan
                        </h2>
                    </div>
                    <div class="bg-white bg-opacity-20 backdrop-blur-sm px-4 py-2.5 rounded-xl border-2 border-white border-opacity-30">
                        <p class="text-xs font-bold uppercase tracking-wide text-teal-100">Total Pengajuan</p>
                        <p class="text-lg font-bold">{{ $submissions->total() }} Proposal</p>
                    </div>
                </div>
            </div>

            {{-- Desktop Table --}}
            <div class="hidden lg:block">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-4/12">Fakultas & Pengunggah</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-3/12">Tanggal Pengajuan</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-2/12">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-2/12">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($submissions as $submission)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-5">
                                    <p class="font-semibold text-gray-900 text-sm">{{ $submission->user->profile->fakultas->name ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $submission->nama_pengunggah }}</p>
                                </td>
                                <td class="px-6 py-5 text-sm">{{ $submission->created_at->isoFormat('D MMMM Y, HH:mm') }}</td>
                                <td class="px-6 py-5 text-center">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold 
                                        @switch($submission->status)
                                            @case('diajukan') bg-blue-100 text-blue-800 border-2 border-blue-200 @break
                                            @case('diverifikasi') bg-yellow-100 text-yellow-800 border-2 border-yellow-200 @break
                                            @case('disetujui') bg-green-100 text-green-800 border-2 border-green-200 @break
                                            @case('ditolak') bg-red-100 text-red-800 border-2 border-red-200 @break
                                            @case('selesai') bg-gray-100 text-gray-800 border-2 border-gray-200 @break
                                        @endswitch">
                                        {{ ucfirst($submission->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin_equity.visiting-professors.show', $submission->id) }}" class="p-2 text-teal-600 bg-teal-100 rounded-lg hover:bg-teal-200 transition-colors" title="Lihat Detail">
                                            <i class='bx bx-search-alt'></i>
                                        </a>
                                        <button @click="confirmDelete({{ $submission->id }})" class="p-2 text-red-600 bg-red-100 rounded-lg hover:bg-red-200 transition-colors" title="Hapus">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                        <form method="POST" action="#" x-ref="deleteForm{{$submission->id}}" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-20">
                                    <h3 class="font-bold text-xl text-gray-800">Belum Ada Pengajuan</h3>
                                    <p class="text-gray-500 mt-2">Saat ini tidak ada proposal yang diajukan untuk program ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
             {{-- Pagination --}}
            @if ($submissions->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">{{ $submissions->links() }}</div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('submissions', () => ({
        confirmDelete(submissionId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Proposal ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#10B981', // Teal
                cancelButtonColor: '#EF4444', // Red
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Belum ada route delete, ini hanya contoh implementasi
                    Swal.fire('Info', 'Fitur hapus belum terhubung ke backend.', 'info');
                    // Jika sudah ada route, gunakan ini:
                    // this.$refs['deleteForm' + submissionId].submit();
                }
            })
        }
    }));
});
</script>
@endsection