@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="manageUser({
    fakultas: {{ json_encode($fakultas) }},
    prodi: {{ json_encode($prodi) }},
    initial: {
        fakultas_id: '{{ request('fakultas_id') }}',
        prodi_id: '{{ request('prodi_id') }}'
    }
})">

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

        <!-- Search and Filter Form -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-8 p-6">
            <form action="{{ route('admin_equity.manageuser.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                    <!-- Search Input -->
                    <div class="md:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Nama atau Email</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Masukkan nama atau email..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>

                    <!-- Fakultas Filter -->
                    <div>
                        <label for="fakultas_id" class="block text-sm font-medium text-gray-700 mb-1">Fakultas</label>
                        <select name="fakultas_id" id="fakultas_id" x-model="selectedFakultas" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            <option value="">Semua Fakultas</option>
                             <template x-for="fak in fakultas" :key="fak.id">
                                <option :value="fak.id" x-text="fak.name"></option>
                            </template>
                        </select>
                    </div>

                    <!-- Prodi Filter -->
                    <div>
                        <label for="prodi_id" class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                        <select name="prodi_id" id="prodi_id" x-model="selectedProdi" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" :disabled="!selectedFakultas">
                             <template x-if="!selectedFakultas"><option value="">Pilih Fakultas Dulu</option></template>
                             <template x-if="selectedFakultas && loadingProdi"><option>Memuat...</option></template>
                             <template x-if="selectedFakultas && !loadingProdi"><option value="">Semua Prodi</option></template>
                             <template x-for="prod in prodi" :key="prod.id">
                                <option :value="prod.id" x-text="prod.name"></option>
                            </template>
                        </select>
                    </div>
                </div>
                <div class="flex items-center justify-end mt-6 space-x-3">
                    <a href="{{ route('admin_equity.manageuser.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 text-sm">Reset</a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 text-sm">
                        <i class='bx bx-search-alt-2 mr-2'></i> Terapkan Filter
                    </button>
                </div>
            </form>
        </div>


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
                                    @if($user->role == 'dosen' && $user->profile?->prodi)
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
                                        <i class='bx bx-user-x text-6xl text-gray-400'></i>
                                        <h3 class="font-bold text-xl text-gray-800 mt-4 mb-2">Pengguna Tidak Ditemukan</h3>
                                        <p class="text-gray-500">Tidak ada pengguna yang cocok dengan kriteria filter Anda. Coba reset filter.</p>
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
    Alpine.data('manageUser', (initialData) => ({
        fakultas: initialData.fakultas || [],
        prodi: initialData.prodi || [],
        selectedFakultas: initialData.initial.fakultas_id || '',
        selectedProdi: initialData.initial.prodi_id || '',
        loadingProdi: false,

        init() {
            this.$watch('selectedFakultas', (newValue, oldValue) => {
                if (newValue !== oldValue) {
                    this.selectedProdi = '';
                    this.fetchProdi();
                }
            });
        },

        fetchProdi() {
            if (!this.selectedFakultas) {
                this.prodi = [];
                return;
            }
            this.loadingProdi = true;
            fetch(`/api/prodi/${this.selectedFakultas}`)
                .then(response => response.json())
                .then(data => {
                    this.prodi = data;
                    this.loadingProdi = false;
                })
                .catch(() => {
                    this.prodi = [];
                    this.loadingProdi = false;
                });
        },

        confirmDelete(userId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Pengguna akan dihapus secara permanen!",
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
