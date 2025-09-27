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

    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">

        {{-- Enhanced Header Section --}}
        <header class="mb-8">
            <!-- Breadcrumb Navigation -->
            <nav class="mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="{{ route('admin_equity.dashboard') }}" class="flex items-center text-gray-500 hover:text-teal-600 transition-colors duration-200">
                            <i class='bx bx-home text-base mr-1'></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-chevron-right text-gray-400 mx-2'></i>
                        <span class="font-medium text-gray-800">Manajemen Pengguna</span>
                    </li>
                </ol>
            </nav>

            <!-- Page Title and Action -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 p-3 bg-gradient-to-br from-teal-100 to-teal-100 rounded-xl">
                            <i class='bx bx-user-check text-2xl text-teal-600'></i>
                        </div>
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">
                                Manajemen Pengguna
                            </h1>
                            <p class="text-gray-600 text-base lg:text-lg">
                                Kelola akun untuk Dosen dan Reviewer Equity
                            </p>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('admin_equity.manageuser.create') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class='bx bxs-user-plus mr-2 text-lg'></i>
                            <span class="hidden sm:inline">Tambah Pengguna Baru</span>
                            <span class="sm:hidden">Tambah User</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        {{-- Enhanced Search and Filter Section --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class='bx bx-filter text-teal-600 mr-2'></i>
                    Filter & Pencarian
                </h3>
            </div>
            
            <form action="{{ route('admin_equity.manageuser.index') }}" method="GET" class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <!-- Search Input - Wider on desktop -->
                    <div class="lg:col-span-5">
                        <label for="search" class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class='bx bx-search text-teal-600 mr-2 text-base'></i>
                            Cari Nama atau Email
                        </label>
                        <input type="text" name="search" id="search" 
                               value="{{ request('search') }}" 
                               placeholder="Masukkan nama atau email pengguna..." 
                               class="block w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 text-base transition-all duration-200 hover:border-gray-300">
                    </div>

                    <!-- Fakultas Filter -->
                    <div class="lg:col-span-3">
                        <label for="fakultas_id" class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class='bx bx-building text-teal-600 mr-2 text-base'></i>
                            Fakultas
                        </label>
                        <select name="fakultas_id" id="fakultas_id" x-model="selectedFakultas" 
                                class="block w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 text-base transition-all duration-200 hover:border-gray-300 appearance-none bg-white">
                            <option value="">Semua Fakultas</option>
                            <template x-for="fak in fakultas" :key="fak.id">
                                <option :value="fak.id" x-text="fak.name"></option>
                            </template>
                        </select>
                    </div>

                    <!-- Prodi Filter -->
                    <div class="lg:col-span-4">
                        <label for="prodi_id" class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class='bx bx-book text-teal-600 mr-2 text-base'></i>
                            Program Studi
                        </label>
                        <select name="prodi_id" id="prodi_id" x-model="selectedProdi" 
                                class="block w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 text-base transition-all duration-200 hover:border-gray-300 appearance-none bg-white" 
                                :disabled="!selectedFakultas"
                                :class="{'opacity-60 cursor-not-allowed': !selectedFakultas}">
                            <template x-if="!selectedFakultas">
                                <option value="">Pilih Fakultas Terlebih Dahulu</option>
                            </template>
                            <template x-if="selectedFakultas && loadingProdi">
                                <option>Memuat program studi...</option>
                            </template>
                            <template x-if="selectedFakultas && !loadingProdi">
                                <option value="">Semua Program Studi</option>
                            </template>
                            <template x-for="prod in prodi" :key="prod.id">
                                <option :value="prod.id" x-text="prod.name"></option>
                            </template>
                        </select>
                    </div>
                </div>
                
                <!-- Filter Actions -->
                <div class="flex flex-col sm:flex-row items-center justify-end mt-8 space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('admin_equity.manageuser.index') }}" 
                       class="w-full sm:w-auto px-6 py-3.5 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all duration-200 text-base text-center border-2 border-transparent hover:border-gray-300">
                        <i class='bx bx-refresh mr-2'></i>
                        Reset Filter
                    </a>
                    <button type="submit" 
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transition-all duration-200 text-base shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class='bx bx-search-alt-2 mr-2 text-lg'></i> 
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        {{-- Enhanced Main Content - User List --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header with Statistics -->
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-xl lg:text-2xl font-bold text-white flex items-center">
                            <i class='bx bx-list-ul mr-3 text-2xl'></i>
                            Daftar Pengguna
                        </h2>
                        <p class="text-teal-100 text-sm mt-1">Kelola semua pengguna sistem</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                            <div class="text-teal-100 text-xs uppercase tracking-wide">Total Pengguna</div>
                            <div class="text-white text-xl font-bold">{{ $users->total() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-8 py-5 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class='bx bx-user mr-2 text-emerald-600'></i>
                                    Informasi Pengguna
                                </div>
                            </th>
                            <th scope="col" class="px-8 py-5 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class='bx bx-envelope mr-2 text-emerald-600'></i>
                                    Kontak
                                </div>
                            </th>
                            <th scope="col" class="px-8 py-5 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class='bx bx-shield mr-2 text-emerald-600'></i>
                                    Role
                                </div>
                            </th>
                            <th scope="col" class="px-8 py-5 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class='bx bx-building mr-2 text-emerald-600'></i>
                                    Detail Dosen
                                </div>
                            </th>
                            <th scope="col" class="px-8 py-5 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center justify-center">
                                    <i class='bx bx-cog mr-2 text-emerald-600'></i>
                                    Aksi
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <div class="h-12 w-12 rounded-full bg-gradient-to-br from-teal-100 to-teal-100 flex items-center justify-center">
                                                <i class='bx bx-user text-teal-600 text-xl'></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-base font-semibold text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">ID: {{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 flex items-center">
                                        <i class='bx bx-envelope mr-2 text-gray-400'></i>
                                        {{ $user->email }}
                                    </div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    @if($user->role == 'dosen')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                            <i class='bx bx-user-voice mr-1'></i>
                                            Dosen
                                        </span>
                                    @elseif($user->role == 'reviewer_equity')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-teal-100 text-teal-800">
                                            <i class='bx bx-user-check mr-1'></i>
                                            Reviewer
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    @if($user->role == 'dosen' && $user->profile?->prodi)
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-900">{{ $user->profile->prodi->fakultas->abbreviation ?? 'N/A' }}</div>
                                            <div class="text-gray-500">{{ $user->profile->prodi->name ?? 'N/A' }}</div>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin_equity.manageuser.show', $user->id) }}" 
                                           class="p-2.5 text-blue-600 bg-blue-100 rounded-lg hover:bg-blue-200 transition-all duration-200 hover:scale-105" 
                                           title="Lihat Detail">
                                            <i class='bx bx-show text-lg'></i>
                                        </a>
                                        <a href="{{ route('admin_equity.manageuser.edit', $user->id) }}" 
                                           class="p-2.5 text-amber-600 bg-amber-100 rounded-lg hover:bg-amber-200 transition-all duration-200 hover:scale-105" 
                                           title="Edit Pengguna">
                                            <i class='bx bxs-edit text-lg'></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin_equity.manageuser.destroy', $user->id) }}" 
                                              x-ref="deleteForm{{$user->id}}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    @click="confirmDelete({{ $user->id }})" 
                                                    class="p-2.5 text-red-600 bg-red-100 rounded-lg hover:bg-red-200 transition-all duration-200 hover:scale-105" 
                                                    title="Hapus Pengguna">
                                               <i class='bx bxs-trash text-lg'></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="text-center py-16 px-6">
                                        <div class="mx-auto h-24 w-24 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                            <i class='bx bx-user-x text-4xl text-gray-400'></i>
                                        </div>
                                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Pengguna Tidak Ditemukan</h3>
                                        <p class="text-gray-500 max-w-sm mx-auto">Tidak ada pengguna yang cocok dengan kriteria filter Anda. Coba ubah atau reset filter.</p>
                                        <a href="{{ route('admin_equity.manageuser.index') }}" 
                                           class="mt-4 inline-flex items-center px-4 py-2 bg-teal-100 text-teal-700 rounded-lg hover:bg-teal-200 transition-colors">
                                            <i class='bx bx-refresh mr-2'></i>
                                            Reset Filter
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden">
                <div class="divide-y divide-gray-200">
                    @forelse ($users as $user)
                        <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                            <!-- User Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-teal-100 to-teal-100 flex items-center justify-center">
                                        <i class='bx bx-user text-teal-600 text-lg'></i>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-semibold text-gray-900">{{ $user->name }}</h3>
                                        <p class="text-sm text-gray-500">ID: {{ $user->id }}</p>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    @if($user->role == 'dosen')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                            <i class='bx bx-user-voice mr-1'></i>
                                            Dosen
                                        </span>
                                    @elseif($user->role == 'reviewer_equity')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-teal-100 text-teal-800">
                                            <i class='bx bx-user-check mr-1'></i>
                                            Reviewer
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- User Details -->
                            <div class="space-y-3 mb-4">
                                <div class="flex items-center text-sm">
                                    <i class='bx bx-envelope mr-2 text-gray-400'></i>
                                    <span class="text-gray-700">{{ $user->email }}</span>
                                </div>
                                @if($user->role == 'dosen' && $user->profile?->prodi)
                                    <div class="flex items-start text-sm">
                                        <i class='bx bx-building mr-2 text-gray-400 mt-0.5'></i>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $user->profile->prodi->fakultas->abbreviation ?? 'N/A' }}</div>
                                            <div class="text-gray-500">{{ $user->profile->prodi->name ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin_equity.manageuser.show', $user->id) }}" 
                                   class="p-2 text-blue-600 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors" 
                                   title="Lihat Detail">
                                    <i class='bx bx-show text-lg'></i>
                                </a>
                                <a href="{{ route('admin_equity.manageuser.edit', $user->id) }}" 
                                   class="p-2 text-amber-600 bg-amber-100 rounded-lg hover:bg-amber-200 transition-colors" 
                                   title="Edit Pengguna">
                                    <i class='bx bxs-edit text-lg'></i>
                                </a>
                                <form method="POST" action="{{ route('admin_equity.manageuser.destroy', $user->id) }}" 
                                      x-ref="deleteForm{{$user->id}}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            @click="confirmDelete({{ $user->id }})" 
                                            class="p-2 text-red-600 bg-red-100 rounded-lg hover:bg-red-200 transition-colors" 
                                            title="Hapus Pengguna">
                                       <i class='bx bxs-trash text-lg'></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 px-6">
                            <div class="mx-auto h-20 w-20 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                <i class='bx bx-user-x text-3xl text-gray-400'></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Pengguna Tidak Ditemukan</h3>
                            <p class="text-gray-500 text-sm">Tidak ada pengguna yang cocok dengan kriteria filter Anda.</p>
                            <a href="{{ route('admin_equity.manageuser.index') }}" 
                               class="mt-3 inline-flex items-center px-3 py-2 bg-teal-100 text-teal-700 rounded-lg hover:bg-teal-200 transition-colors text-sm">
                                <i class='bx bx-refresh mr-2'></i>
                                Reset Filter
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Enhanced Pagination --}}
            @if ($users->hasPages())
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-t border-gray-200">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <!-- Left side - Results info -->
                        <div class="flex items-center space-x-4">
                            <div class="text-sm text-gray-600 bg-white px-4 py-2.5 rounded-lg border border-gray-200 shadow-sm">
                                <span class="font-medium text-gray-900">Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }}</span> 
                                <span class="text-gray-500">dari</span> 
                                <span class="font-bold text-teal-600">{{ $users->total() }} pengguna</span>
                            </div>
                            
                            <!-- Results per page info -->
                            <div class="text-xs text-gray-500 bg-white px-3 py-2 rounded-lg border border-gray-200">
                                Showing {{ $users->count() }} entries
                            </div>
                        </div>

                        <!-- Right side - Pagination -->
                        <div class="flex justify-center lg:justify-end">
                            <nav class="relative z-0 inline-flex rounded-xl shadow-sm border border-gray-200 bg-white" aria-label="Pagination">
                                {{-- Previous Page Link --}}
                                @if ($users->onFirstPage())
                                    <span class="relative inline-flex items-center px-3 py-2.5 rounded-l-xl border-r border-gray-200 bg-gray-50 text-gray-400 cursor-not-allowed">
                                        <i class='bx bx-chevron-left text-lg'></i>
                                    </span>
                                @else
                                    <a href="{{ $users->previousPageUrl() }}" class="relative inline-flex items-center px-3 py-2.5 rounded-l-xl border-r border-gray-200 bg-white text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition-all duration-200">
                                        <i class='bx bx-chevron-left text-lg'></i>
                                    </a>
                                @endif

                                {{-- Page Number Links --}}
                                @foreach ($users->getUrlRange(max(1, $users->currentPage() - 2), min($users->lastPage(), $users->currentPage() + 2)) as $page => $url)
                                    @if ($page == $users->currentPage())
                                        <span class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold text-sm">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition-all duration-200 font-medium text-sm">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                {{-- Show dots if there are more pages --}}
                                @if ($users->currentPage() < $users->lastPage() - 3)
                                    <span class="relative inline-flex items-center px-3 py-2.5 border-r border-gray-200 bg-white text-gray-400 text-sm">
                                        ...
                                    </span>
                                    <a href="{{ $users->url($users->lastPage()) }}" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition-all duration-200 font-medium text-sm">
                                        {{ $users->lastPage() }}
                                    </a>
                                @endif

                                {{-- Next Page Link --}}
                                @if ($users->hasMorePages())
                                    <a href="{{ $users->nextPageUrl() }}" class="relative inline-flex items-center px-3 py-2.5 rounded-r-xl bg-white text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition-all duration-200">
                                        <i class='bx bx-chevron-right text-lg'></i>
                                    </a>
                                @else
                                    <span class="relative inline-flex items-center px-3 py-2.5 rounded-r-xl bg-gray-50 text-gray-400 cursor-not-allowed">
                                        <i class='bx bx-chevron-right text-lg'></i>
                                    </span>
                                @endif
                            </nav>
                        </div>
                    </div>
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
                text: "Pengguna akan dihapus secara permanen dan tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-xl',
                    confirmButton: 'rounded-lg px-4 py-2',
                    cancelButton: 'rounded-lg px-4 py-2'
                }
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