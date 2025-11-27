@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    <div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8 xl:p-10 2xl:p-12">
        <div class="max-w-[1920px] mx-auto">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">
                            Faculty Activities
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Manage news and activities about international faculty members
                        </p>
                    </div>
                    <a href="{{ route('admin_pemeringkatan.international-faculty-activities.create') }}"
                       class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-md w-full sm:w-auto">
                        <i class='bx bx-plus text-xl mr-2'></i>
                        Add New Activity
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
                    <div class="flex items-start">
                        <i class='bx bx-check-circle text-2xl text-green-500 mr-3 mt-0.5'></i>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                    <div class="flex items-start">
                        <i class='bx bx-error-circle text-2xl text-red-500 mr-3 mt-0.5'></i>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-red-800 whitespace-pre-line">{{ session('error') }}</p>
                        </div>
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
                    @if(request()->hasAny(['search', 'start_date', 'end_date']))
                        <a href="{{ route('admin_pemeringkatan.international-faculty-activities.index') }}" 
                           class="text-sm text-gray-600 hover:text-gray-800 flex items-center transition-colors">
                            <i class='bx bx-x text-lg mr-1'></i>
                            Reset Filter
                        </a>
                    @endif
                </div>

                <form method="GET" action="{{ route('admin_pemeringkatan.international-faculty-activities.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Title or content..." 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                            <input type="date" 
                                   name="start_date" 
                                   value="{{ request('start_date') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                        </div>

                        <!-- End Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                            <input type="date" 
                                   name="end_date" 
                                   value="{{ request('end_date') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                            <i class='bx bx-search mr-2'></i>
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Data Table -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white">Faculty Activities List</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content Preview</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($activities as $index => $activity)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $activities->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ \Carbon\Carbon::parse($activity->tanggal)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $activity->judul }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        <div class="max-w-md">
                                            {{ Str::limit(strip_tags($activity->isi), 100) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin_pemeringkatan.international-faculty-activities.edit', $activity->id) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition-colors duration-150">
                                                <i class='bx bx-edit text-base mr-1'></i>
                                                <span class="hidden sm:inline">Edit</span>
                                            </a>
                                            <form action="{{ route('admin_pemeringkatan.international-faculty-activities.destroy', $activity->id) }}" 
                                                  method="POST" 
                                                  class="inline-block delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors duration-150">
                                                    <i class='bx bx-trash text-base mr-1'></i>
                                                    <span class="hidden sm:inline">Delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <i class='bx bx-news text-5xl mb-2'></i>
                                            <p class="text-sm">No activities found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($activities->hasPages())
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="text-sm text-gray-600">
                                Showing {{ $activities->firstItem() }} to {{ $activities->lastItem() }} of {{ $activities->total() }} activities
                            </div>
                            <div>
                                {{ $activities->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Image Preview Modal -->
    @include('admin_pemeringkatan.international-faculty-activities.modals')

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Image preview modal
        document.querySelectorAll('.view-image-btn').forEach(button => {
            button.addEventListener('click', function() {
                const imageUrl = this.getAttribute('data-image');
                const title = this.getAttribute('data-title');
                
                document.getElementById('modalImage').src = imageUrl;
                document.getElementById('modalTitle').textContent = title;
                document.getElementById('imageModal').classList.remove('hidden');
            });
        });

        // Delete confirmation
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: 'Apakah Anda yakin ingin menghapus aktivitas ini? Tindakan ini tidak dapat dibatalkan.',
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
    </script>
    @endpush
@endsection
