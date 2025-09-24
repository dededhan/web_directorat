@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="manageUser">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb and Page Title --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600 transition-colors duration-200">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Manajemen Pengguna</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Pengguna (Dosen & Reviewer)</h1>
                    <p class="mt-2 text-gray-600 text-base">Kelola akun untuk Dosen dan Reviewer Equity.</p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('admin_equity.manageuser.create') }}" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class='bx bxs-user-plus mr-2 text-lg'></i>
                        Tambah Pengguna Baru
                    </a>
                </div>
            </div>
        </header>

        {{-- Main Content - User List --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between text-white">
                    <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                        <i class='bx bx-list-ul mr-3 text-2xl'></i>
                        Daftar Pengguna
                    </h2>
                    <div class="text-teal-100 text-sm">
                        Total: <span class="font-semibold text-white">{{ $users->total() }} pengguna</span>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nama</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Role</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Detail (Dosen)</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="font-semibold text-gray-900 text-base">{{ $user->name }}</div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-700">{{ $user->email }}</td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    @if($user->role == 'dosen')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Dosen</span>
                                    @elseif($user->role == 'reviewer_equity')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Reviewer</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-600">
                                    @if($user->role == 'dosen' && $user->profile)
                                        <div>{{ $user->profile->prodi->fakultas->abbreviation ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->profile->prodi->name ?? 'N/A' }}</div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin_equity.manageuser.show', $user->id) }}" class="p-2 text-blue-600 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors" title="Lihat Detail">
                                            <i class='bx bx-show text-lg'></i>
                                        </a>
                                        <a href="{{ route('admin_equity.manageuser.edit', $user->id) }}" class="p-2 text-yellow-600 bg-yellow-100 rounded-lg hover:bg-yellow-200 transition-colors" title="Edit Pengguna">
                                            <i class='bx bxs-edit text-lg'></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin_equity.manageuser.destroy', $user->id) }}" x-ref="deleteForm{{$user->id}}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" @click="confirmDelete({{ $user->id }})" class="p-2 text-red-600 bg-red-100 rounded-lg hover:bg-red-200 transition-colors" title="Hapus Pengguna">
                                               <i class='bx bxs-trash text-lg'></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="text-center py-20 px-6">
                                        <h3 class="font-bold text-xl text-gray-800 mb-2">Belum Ada Pengguna</h3>
                                        <p class="text-gray-500">Mulai dengan menambahkan pengguna baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($users->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('manageUser', () => ({
        confirmDelete(userId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$refs['deleteForm' + userId].submit();
                }
            })
        }
    }));
});
</script>
@endsection

