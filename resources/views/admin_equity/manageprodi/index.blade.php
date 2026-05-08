@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
        <header class="mb-8">
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
                        <span class="font-medium text-gray-800">Manajemen Prodi</span>
                    </li>
                </ol>
            </nav>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 p-3 bg-gradient-to-br from-teal-100 to-teal-100 rounded-xl">
                            <i class='bx bxs-book-content text-2xl text-teal-600'></i>
                        </div>
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">Manajemen Prodi</h1>
                            <p class="text-gray-600 text-base lg:text-lg">Kelola data program studi per fakultas</p>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('admin_equity.manageprodi.create') }}"
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class='bx bx-plus-circle mr-2 text-lg'></i>
                            <span class="hidden sm:inline">Tambah Prodi</span>
                            <span class="sm:hidden">Tambah</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class='bx bx-filter text-teal-600 mr-2'></i>
                    Filter & Pencarian
                </h3>
            </div>
            <form action="{{ route('admin_equity.manageprodi.index') }}" method="GET" class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <div class="lg:col-span-6">
                        <label for="search" class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class='bx bx-search text-teal-600 mr-2 text-base'></i>
                            Cari Nama Prodi
                        </label>
                        <input type="text" name="search" id="search"
                               value="{{ request('search') }}"
                               placeholder="Masukkan nama program studi..."
                               class="block w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 text-base transition-all duration-200 hover:border-gray-300">
                    </div>
                    <div class="lg:col-span-6">
                        <label for="fakultas_id" class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class='bx bx-buildings text-teal-600 mr-2 text-base'></i>
                            Fakultas
                        </label>
                        <select name="fakultas_id" id="fakultas_id"
                                class="block w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 text-base transition-all duration-200 hover:border-gray-300 appearance-none bg-white">
                            <option value="">Semua Fakultas</option>
                            @foreach($fakultas as $fak)
                                <option value="{{ $fak->id }}" @if(request('fakultas_id') == $fak->id) selected @endif>
                                    {{ $fak->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-end mt-8 space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('admin_equity.manageprodi.index') }}"
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

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-xl lg:text-2xl font-bold text-white flex items-center">
                            <i class='bx bx-list-ul mr-3 text-2xl'></i>
                            Daftar Prodi
                        </h2>
                        <p class="text-teal-100 text-sm mt-1">Kelola program studi pada setiap fakultas</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                        <div class="text-teal-100 text-xs uppercase tracking-wide">Total Prodi</div>
                        <div class="text-white text-xl font-bold">{{ $prodi->total() }}</div>
                    </div>
                </div>
            </div>

            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-8 py-5 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class='bx bx-book text-emerald-600 mr-2'></i>
                                    Nama Prodi
                                </div>
                            </th>
                            <th scope="col" class="px-8 py-5 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class='bx bx-buildings text-emerald-600 mr-2'></i>
                                    Fakultas
                                </div>
                            </th>
                            <th scope="col" class="px-8 py-5 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center justify-center">
                                    <i class='bx bx-cog text-emerald-600 mr-2'></i>
                                    Aksi
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($prodi as $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-base font-semibold text-gray-900">{{ $item->name }}</div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-sm text-gray-700">{{ $item->fakultas->name ?? '-' }}</div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap text-center">
                                    <a href="{{ route('admin_equity.manageprodi.edit', $item->id) }}"
                                       class="inline-flex items-center justify-center p-2.5 text-amber-600 bg-amber-100 rounded-lg hover:bg-amber-200 transition-all duration-200 hover:scale-105"
                                       title="Edit Prodi">
                                        <i class='bx bxs-edit text-lg'></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="text-center py-16 px-6">
                                        <div class="mx-auto h-24 w-24 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                            <i class='bx bx-book text-4xl text-gray-400'></i>
                                        </div>
                                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Prodi Tidak Ditemukan</h3>
                                        <p class="text-gray-500 max-w-sm mx-auto">Tidak ada prodi yang cocok dengan filter Anda.</p>
                                        <a href="{{ route('admin_equity.manageprodi.index') }}"
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

            <div class="lg:hidden">
                <div class="divide-y divide-gray-200">
                    @forelse($prodi as $item)
                        <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-base font-semibold text-gray-900">{{ $item->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $item->fakultas->name ?? '-' }}</p>
                                </div>
                                <a href="{{ route('admin_equity.manageprodi.edit', $item->id) }}"
                                   class="p-2 text-amber-600 bg-amber-100 rounded-lg hover:bg-amber-200 transition-colors"
                                   title="Edit Prodi">
                                    <i class='bx bxs-edit text-lg'></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 px-6">
                            <div class="mx-auto h-20 w-20 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                <i class='bx bx-book text-3xl text-gray-400'></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Prodi Tidak Ditemukan</h3>
                            <p class="text-gray-500 text-sm">Tidak ada prodi yang cocok dengan filter Anda.</p>
                            <a href="{{ route('admin_equity.manageprodi.index') }}"
                               class="mt-3 inline-flex items-center px-3 py-2 bg-teal-100 text-teal-700 rounded-lg hover:bg-teal-200 transition-colors text-sm">
                                <i class='bx bx-refresh mr-2'></i>
                                Reset Filter
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            @if ($prodi->hasPages())
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-t border-gray-200">
                    {{ $prodi->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
