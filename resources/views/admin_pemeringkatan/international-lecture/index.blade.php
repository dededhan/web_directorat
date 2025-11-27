@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    <!-- Main container with progressive padding and zoom standards -->
    <div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8 xl:p-10 2xl:p-12">
        <div class="max-w-[1920px] mx-auto">
            
            <!-- Header with responsive layout -->
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">International Lecture</h1>
                    <p class="mt-1 text-sm text-gray-600">Manage international visiting lecturers and professors</p>
                </div>
                <a href="{{ route('admin_pemeringkatan.international-lecture.create') }}" 
                   class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-150 w-full sm:w-auto">
                    <i class='bx bx-plus text-lg mr-2'></i>
                    Add New Lecturer
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
                    @if(request()->hasAny(['search', 'fakultas', 'status']))
                    <a href="{{ route('admin_pemeringkatan.international-lecture.index') }}" 
                       class="text-sm text-gray-600 hover:text-gray-800 flex items-center">
                        <i class='bx bx-x text-lg mr-1'></i>
                        Reset Filter
                    </a>
                    @endif
                </div>
                
                <div>
                    <form method="GET" action="{{ route('admin_pemeringkatan.international-lecture.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Search -->
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                                <input type="text" 
                                       name="search" 
                                       id="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Name, country, university..."
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

                            <!-- Status Filter -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" 
                                        id="status" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Semua Status</option>
                                    <option value="fulltime" {{ request('status') == 'fulltime' ? 'selected' : '' }}>Full Time</option>
                                    <option value="parttime" {{ request('status') == 'parttime' ? 'selected' : '' }}>Part Time</option>
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

            <!-- Data Table Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-700 to-gray-800">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Lecturer Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Fakultas</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Program Studi</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Country</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">University</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Expertise</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-200 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($lecturers as $index => $lecturer)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $lecturers->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $lecturer->nama }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ strtoupper($lecturer->fakultas) }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $lecturer->prodi }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $lecturer->negara }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $lecturer->universitas_asal }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($lecturer->status === 'fulltime')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                <i class='bx bx-briefcase text-sm mr-1'></i>
                                                Full Time
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class='bx bx-time text-sm mr-1'></i>
                                                Part Time
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $lecturer->bidang_keahlian }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin_pemeringkatan.international-lecture.edit', $lecturer->id) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium rounded-lg transition-colors duration-150">
                                                <i class='bx bx-edit text-base mr-1'></i>
                                                Edit
                                            </a>
                                            <form action="{{ route('admin_pemeringkatan.international-lecture.destroy', $lecturer->id) }}" 
                                                  method="POST" 
                                                  class="inline-block delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-lg transition-colors duration-150 delete-btn">
                                                    <i class='bx bx-trash text-base mr-1'></i>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-12 text-center">
                                        <i class='bx bx-data text-gray-400 text-5xl mb-3'></i>
                                        <p class="text-gray-500 text-sm">No lecturers found</p>
                                        <a href="{{ route('admin_pemeringkatan.international-lecture.create') }}" 
                                           class="inline-block mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-150">
                                            Add First Lecturer
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($lecturers->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        <div class="flex items-center justify-between flex-wrap gap-3">
                            <div class="text-sm text-gray-700">
                                Showing <span class="font-medium">{{ $lecturers->firstItem() }}</span> to 
                                <span class="font-medium">{{ $lecturers->lastItem() }}</span> of 
                                <span class="font-medium">{{ $lecturers->total() }}</span> results
                            </div>
                            <div>
                                {{ $lecturers->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- SweetAlert2 for Delete Confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Delete confirmation
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('.delete-form');
                    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This lecturer data will be permanently deleted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#EF4444',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
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
