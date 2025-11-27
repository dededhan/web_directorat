@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    <div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8 xl:p-10 2xl:p-12">
        <div class="max-w-[1920px] mx-auto">
            <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Ranking Pemeringkatan</h1>
                    <p class="text-sm sm:text-base text-gray-600">Kelola data ranking pemeringkatan universitas</p>
                </div>
                <a href="{{ route('admin_pemeringkatan.ranking.create') }}" 
                   class="inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm sm:text-base font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 w-full sm:w-auto">
                    <i class='bx bx-plus text-lg sm:text-xl mr-2'></i>
                    Tambah Ranking
                </a>
            </div>
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
                    <div class="flex items-start">
                        <i class='bx bx-check-circle text-2xl text-green-500 mr-3 flex-shrink-0'></i>
                        <p class="text-green-800 whitespace-pre-line">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                    <div class="flex items-start">
                        <i class='bx bx-error-circle text-2xl text-red-500 mr-3 flex-shrink-0'></i>
                        <p class="text-red-800 whitespace-pre-line">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class='bx bx-filter text-xl mr-2 text-blue-600'></i>
                        Filter Data
                    </h2>
                    @if(request()->hasAny(['search', 'has_score', 'sort']))
                    <a href="{{ route('admin_pemeringkatan.ranking.index') }}" 
                       class="text-sm text-gray-600 hover:text-gray-800 flex items-center">
                        <i class='bx bx-x text-lg mr-1'></i>
                        Reset Filter
                    </a>
                    @endif
                </div>
                
                <div>
                    <form method="GET" action="{{ route('admin_pemeringkatan.ranking.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                            <input type="text" 
                                   name="search" 
                                   id="search"
                                   value="{{ request('search') }}"
                                   placeholder="Judul ranking, deskripsi..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div>
                                <label for="has_score" class="block text-sm font-medium text-gray-700 mb-1">Filter Skor</label>
                            <select name="has_score" 
                                    id="has_score"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Semua</option>
                                <option value="1" {{ request('has_score') === '1' ? 'selected' : '' }}>Memiliki Skor</option>
                                <option value="0" {{ request('has_score') === '0' ? 'selected' : '' }}>Tanpa Skor</option>
                            </select>
                            </div>

                            <div>
                                <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                            <select name="sort" 
                                    id="sort"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                                <option value="title_asc" {{ request('sort') === 'title_asc' ? 'selected' : '' }}>Judul A-Z</option>
                                <option value="title_desc" {{ request('sort') === 'title_desc' ? 'selected' : '' }}>Judul Z-A</option>
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
            </div>
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-4 sm:px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <i class='bx bx-list-ul text-2xl mr-2'></i>
                        Daftar Ranking Pemeringkatan
                    </h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Judul Ranking
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Skor
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Logo
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Deskripsi
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($rankings as $index => $ranking)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $rankings->firstItem() + $index }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ $ranking->judul }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($ranking->score_ranking)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                <i class='bx bx-trophy text-sm mr-1'></i>
                                                {{ $ranking->score_ranking }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                                Tidak ada
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($ranking->gambar)
                                            <button type="button"
                                                onclick="viewImage('{{ asset('storage/' . $ranking->gambar) }}', '{{ $ranking->judul }}')"
                                                class="inline-flex items-center px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-medium rounded transition-colors duration-200">
                                                <i class='bx bx-image text-sm mr-1'></i>
                                                Lihat Logo
                                            </button>
                                        @else
                                            <span class="text-gray-400 text-xs italic">Tidak ada logo</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ Str::limit(strip_tags($ranking->deskripsi), 100) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin_pemeringkatan.ranking.edit', $ranking->id) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium rounded transition-colors duration-200">
                                                <i class='bx bx-edit text-sm mr-1'></i>
                                                Edit
                                            </a>
                                            <form 
                                                method="POST" 
                                                action="{{ route('admin_pemeringkatan.ranking.destroy', $ranking->id) }}"
                                                class="inline-block delete-form"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="button" 
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded transition-colors duration-200 delete-btn"
                                                >
                                                    <i class='bx bx-trash text-sm mr-1'></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <i class='bx bx-trophy text-6xl text-gray-300 mb-4'></i>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada ranking</h3>
                                        <p class="text-sm text-gray-500 mb-6">Mulai dengan menambahkan ranking pertama</p>
                                        <a href="{{ route('admin_pemeringkatan.ranking.create') }}" 
                                           class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                            <i class='bx bx-plus text-lg mr-2'></i>
                                            Tambah Ranking
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($rankings->hasPages())
                    <div class="bg-gray-50 px-4 sm:px-6 py-4 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div class="text-sm text-gray-700">
                                Menampilkan 
                                <span class="font-medium">{{ $rankings->firstItem() }}</span>
                                sampai
                                <span class="font-medium">{{ $rankings->lastItem() }}</span>
                                dari
                                <span class="font-medium">{{ $rankings->total() }}</span>
                                hasil
                            </div>
                            <div>
                                {{ $rankings->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4 flex justify-between items-center">
                <h3 id="imageModalTitle" class="text-xl font-semibold text-white">Logo Ranking</h3>
                <button type="button" onclick="closeImageModal()"
                    class="text-white hover:text-gray-300 transition-colors duration-200">
                    <i class='bx bx-x text-3xl'></i>
                </button>
            </div>
            <div class="p-6 text-center">
                <img id="modalImage" src="" alt="Logo Ranking" class="max-w-full max-h-[70vh] mx-auto rounded-lg shadow-lg">
            </div>
        </div>
    </div>

    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4 flex justify-between items-center">
                <h3 id="imageModalTitle" class="text-xl font-semibold text-white">Logo Ranking</h3>
                <button type="button" onclick="closeImageModal()"
                    class="text-white hover:text-gray-300 transition-colors duration-200">
                    <i class='bx bx-x text-3xl'></i>
                </button>
            </div>
            <div class="p-6 text-center">
                <img id="modalImage" src="" alt="Logo Ranking" class="max-w-full max-h-[70vh] mx-auto rounded-lg shadow-lg">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        function viewImage(imageUrl, title) {
            document.getElementById('imageModalTitle').textContent = title;
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('imageModal').classList.remove('hidden');
            document.getElementById('imageModal').classList.add('flex');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.getElementById('imageModal').classList.remove('flex');
        }

        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        text: 'Apakah Anda yakin ingin menghapus ranking ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
