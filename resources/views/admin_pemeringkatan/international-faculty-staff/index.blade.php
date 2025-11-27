@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    <!-- Main container with progressive padding and zoom standards -->
    <div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8 xl:p-10 2xl:p-12">
        <div class="max-w-[1920px] mx-auto">
            
            <!-- Header with responsive layout -->
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">International Faculty Staff</h1>
                    <p class="mt-1 text-sm text-gray-600">Manage international faculty members and visiting professors</p>
                </div>
                <a href="{{ route('admin_pemeringkatan.international-faculty-staff.create') }}" 
                   class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-150 w-full sm:w-auto">
                    <i class='bx bx-plus text-lg mr-2'></i>
                    Add New Faculty Staff
                </a>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
                    <div class="flex items-start">
                        <i class='bx bx-check-circle text-green-500 text-xl mr-3 mt-0.5'></i>
                        <p class="text-green-700 whitespace-pre-line">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                    <div class="flex items-start">
                        <i class='bx bx-error-circle text-red-500 text-xl mr-3 mt-0.5'></i>
                        <p class="text-red-700 whitespace-pre-line">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Filter Card -->
            <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class='bx bx-filter text-xl mr-2 text-blue-600'></i>
                        Filter Data
                    </h2>
                    @if(request()->hasAny(['search', 'fakultas', 'category', 'tahun']))
                    <a href="{{ route('admin_pemeringkatan.international-faculty-staff.index') }}" 
                       class="text-sm text-gray-600 hover:text-gray-800 flex items-center">
                        <i class='bx bx-x text-lg mr-1'></i>
                        Reset Filter
                    </a>
                    @endif
                </div>
                
                <div>
                    <form method="GET" action="{{ route('admin_pemeringkatan.international-faculty-staff.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Search -->
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                                <input type="text" 
                                       name="search" 
                                       id="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Name, university, expertise..."
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- Fakultas Filter -->
                            <div>
                                <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-1">Fakultas</label>
                                <select name="fakultas" 
                                        id="fakultas" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Semua Fakultas</option>
                                    <option value="pascasarjana" {{ request('fakultas') == 'pascasarjana' ? 'selected' : '' }}>PASCASARJANA</option>
                                    <option value="fip" {{ request('fakultas') == 'fip' ? 'selected' : '' }}>FIP</option>
                                    <option value="fmipa" {{ request('fakultas') == 'fmipa' ? 'selected' : '' }}>FMIPA</option>
                                    <option value="fppsi" {{ request('fakultas') == 'fppsi' ? 'selected' : '' }}>FPPsi</option>
                                    <option value="fbs" {{ request('fakultas') == 'fbs' ? 'selected' : '' }}>FBS</option>
                                    <option value="ft" {{ request('fakultas') == 'ft' ? 'selected' : '' }}>FT</option>
                                    <option value="fik" {{ request('fakultas') == 'fik' ? 'selected' : '' }}>FIK</option>
                                    <option value="fis" {{ request('fakultas') == 'fis' ? 'selected' : '' }}>FIS</option>
                                    <option value="fe" {{ request('fakultas') == 'fe' ? 'selected' : '' }}>FE</option>
                                    <option value="profesi" {{ request('fakultas') == 'profesi' ? 'selected' : '' }}>PROFESI</option>
                                </select>
                            </div>

                            <!-- Category Filter -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select name="category" 
                                        id="category" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Semua Category</option>
                                    <option value="fulltime" {{ request('category') == 'fulltime' ? 'selected' : '' }}>Full Time</option>
                                    <option value="adjunct" {{ request('category') == 'adjunct' ? 'selected' : '' }}>Adjunct</option>
                                </select>
                            </div>

                            <!-- Year Filter -->
                            <div>
                                <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                                <input type="number" 
                                       name="tahun" 
                                       id="tahun" 
                                       value="{{ request('tahun') }}" 
                                       placeholder="e.g., 2024"
                                       min="2000"
                                       max="{{ date('Y') + 1 }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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

            <!-- Data Table -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-4 sm:px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <i class='bx bx-list-ul text-2xl mr-2'></i>
                        Faculty Staff List
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
                                    Photo
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fakultas
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    University
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Expertise
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Year
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($facultyStaffs as $index => $staff)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $facultyStaffs->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($staff->foto_path)
                                            <img src="{{ Storage::url($staff->foto_path) }}" 
                                                 alt="{{ $staff->nama }}" 
                                                 class="h-12 w-12 rounded-full object-cover border-2 border-gray-200">
                                        @else
                                            <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                                                <i class='bx bx-user text-2xl text-gray-400'></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <div class="font-medium">{{ $staff->nama }}</div>
                                        @if($staff->qs_wur || $staff->scopus)
                                            <div class="text-xs text-gray-500 mt-1">
                                                @if($staff->qs_wur)
                                                    <span class="inline-flex items-center">
                                                        <i class='bx bx-trophy text-yellow-500 mr-1'></i>
                                                        QS: {{ $staff->qs_wur }}
                                                    </span>
                                                @endif
                                                @if($staff->scopus)
                                                    <span class="inline-flex items-center ml-2">
                                                        <i class='bx bx-book text-blue-500 mr-1'></i>
                                                        Scopus: {{ $staff->scopus }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ strtoupper($staff->fakultas) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $staff->universitas_asal }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ Str::limit($staff->bidang_keahlian, 40) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($staff->category == 'fulltime')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                                Full Time
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Adjunct
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $staff->tahun }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('admin_pemeringkatan.international-faculty-staff.edit', $staff->id) }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition-colors duration-150">
                                            <i class='bx bx-edit text-base mr-1'></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin_pemeringkatan.international-faculty-staff.destroy', $staff->id) }}" 
                                              method="POST" 
                                              class="inline-block delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors duration-150">
                                                <i class='bx bx-trash text-base mr-1'></i>
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <i class='bx bx-data text-6xl mb-4'></i>
                                            <p class="text-lg font-medium text-gray-600">No faculty staff data found</p>
                                            <p class="text-sm text-gray-500 mt-1">Try adjusting your filters or add new data</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($facultyStaffs->hasPages())
                    <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 sm:px-6">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="text-sm text-gray-700">
                                Showing 
                                <span class="font-medium">{{ $facultyStaffs->firstItem() }}</span> 
                                to 
                                <span class="font-medium">{{ $facultyStaffs->lastItem() }}</span> 
                                of 
                                <span class="font-medium">{{ $facultyStaffs->total() }}</span> 
                                results
                            </div>
                            <div>
                                {{ $facultyStaffs->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- SweetAlert2 for delete confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-form');
            
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        text: 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus!',
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
