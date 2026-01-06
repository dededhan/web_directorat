@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    <div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8 xl:p-10 2xl:p-12">
        <div class="max-w-[1920px] mx-auto">
            <!-- Header -->
            <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Kegiatan Sustainability</h1>
                    <p class="text-sm sm:text-base text-gray-600">Kelola kegiatan dan program sustainability</p>
                </div>
                <a href="{{ route('admin_pemeringkatan.kegiatan-sustainability.create') }}" 
                   class="inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm sm:text-base font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 w-full sm:w-auto">
                    <i class='bx bx-plus text-lg sm:text-xl mr-2'></i>
                    Tambah Kegiatan
                </a>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
                <div class="flex items-start">
                    <i class='bx bx-check-circle text-green-500 text-2xl mr-3 flex-shrink-0'></i>
                    <p class="text-green-700 whitespace-pre-line">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                <div class="flex items-start">
                    <i class='bx bx-error-circle text-red-500 text-2xl mr-3 flex-shrink-0'></i>
                    <p class="text-red-700 whitespace-pre-line">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            <!-- Filters Card -->
            <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class='bx bx-filter text-xl mr-2 text-blue-600'></i>
                        Filter Data
                    </h2>
                    @if(request()->hasAny(['search', 'fakultas']))
                    <a href="{{ route('admin_pemeringkatan.kegiatan-sustainability.index') }}" 
                       class="text-sm text-gray-600 hover:text-gray-800 flex items-center">
                        <i class='bx bx-x text-lg mr-1'></i>
                        Reset Filter
                    </a>
                    @endif
                </div>
                
                <form method="GET" action="{{ route('admin_pemeringkatan.kegiatan-sustainability.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                            <input type="text" 
                                   name="search" 
                                   id="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Judul kegiatan..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Fakultas Filter -->
                        <div>
                            <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-1">Fakultas</label>
                            <select name="fakultas" 
                                    id="fakultas" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Semua Fakultas</option>
                                @php
                                    $faculties = $faculties_data ?? [];
                                @endphp
                                @foreach($faculties as $key => $faculty)
                                    <option value="{{ strtolower($key) }}" {{ request('fakultas') == strtolower($key) ? 'selected' : '' }}>
                                        {{ $faculty['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-2 sm:justify-end">
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 w-full sm:w-auto">
                            <i class='bx bx-search text-lg mr-2'></i>
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Data Table -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <i class='bx bx-calendar-event text-2xl mr-2'></i>
                        Daftar Kegiatan Sustainability
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b-2 border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Judul Kegiatan</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Fakultas</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Program Studi</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Link</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Foto</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($sustainabilities as $activity)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-4 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $activity->judul_kegiatan }}</div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($activity->tanggal_kegiatan)->format('d M Y') }}</span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900">{{ strtoupper($activity->fakultas) }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="text-sm text-gray-900">{{ $activity->prodi ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @if($activity->link_kegiatan)
                                        <a href="{{ $activity->link_kegiatan }}" 
                                           target="_blank"
                                           class="inline-flex items-center px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-xs font-medium rounded-lg transition-colors">
                                            <i class='bx bx-link-external mr-1'></i>
                                            Lihat
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @if($activity->photos->count() > 0)
                                        <button type="button" 
                                                class="inline-flex items-center px-3 py-1 bg-purple-100 hover:bg-purple-200 text-purple-700 text-xs font-medium rounded-lg transition-colors view-photos"
                                                data-photos='@json($activity->photos->pluck("path"))'>
                                            <i class='bx bx-image mr-1'></i>
                                            {{ $activity->photos->count() }} Foto
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin_pemeringkatan.kegiatan-sustainability.edit', $activity->id) }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium rounded-lg transition-colors duration-200">
                                            <i class='bx bx-edit mr-1'></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin_pemeringkatan.kegiatan-sustainability.destroy', $activity->id) }}" 
                                              method="POST" 
                                              class="inline-block"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan {{ $activity->judul_kegiatan }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-lg transition-colors duration-200">
                                                <i class='bx bx-trash mr-1'></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <i class='bx bx-folder-open text-6xl mb-4'></i>
                                        <p class="text-lg font-medium">Belum ada data kegiatan sustainability</p>
                                        <p class="text-sm mt-1">Tambahkan data baru dengan klik tombol di atas</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($sustainabilities->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    {{ $sustainabilities->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Photo Modal -->
    <div id="photoModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-75" x-data="{ open: false }" x-show="open" x-cloak>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto" @click.away="open = false">
                <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-xl">
                    <h3 class="text-xl font-semibold text-gray-800">Foto Kegiatan</h3>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class='bx bx-x text-3xl'></i>
                    </button>
                </div>
                <div id="photoGallery" class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Photos will be inserted here -->
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // View photos modal
        const photoButtons = document.querySelectorAll('.view-photos');
        const photoModal = document.getElementById('photoModal');
        const photoGallery = document.getElementById('photoGallery');
        
        photoButtons.forEach(button => {
            button.addEventListener('click', function() {
                const photos = JSON.parse(this.dataset.photos);
                photoGallery.innerHTML = '';
                
                photos.forEach(photoPath => {
                    const imageUrl = '/storage/' + photoPath;
                    const imgContainer = document.createElement('div');
                    imgContainer.className = 'relative group';
                    imgContainer.innerHTML = `
                        <img src="${imageUrl}" 
                             alt="Foto Kegiatan" 
                             class="w-full h-64 object-cover rounded-lg shadow-md group-hover:shadow-xl transition-shadow duration-200">
                        <a href="${imageUrl}" 
                           target="_blank"
                           class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-200 rounded-lg">
                            <i class='bx bx-search text-white text-4xl opacity-0 group-hover:opacity-100 transition-opacity duration-200'></i>
                        </a>
                    `;
                    photoGallery.appendChild(imgContainer);
                });
                
                photoModal.classList.remove('hidden');
                photoModal.setAttribute('x-data', '{ open: true }');
            });
        });
        
        // Close modal when clicking outside
        photoModal.addEventListener('click', function(e) {
            if (e.target === photoModal) {
                photoModal.classList.add('hidden');
            }
        });
    });
    </script>
@endsection
