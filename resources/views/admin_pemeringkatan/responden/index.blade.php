@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    <div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8 xl:p-10 2xl:p-12">
        <div class="max-w-[1920px] mx-auto">
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Daftar Responden</h1>
                    <nav class="flex text-sm text-gray-600 mt-2" aria-label="Breadcrumb">
                        <a href="{{ route('admin_pemeringkatan.dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
                        <span class="mx-2">/</span>
                        <span class="text-gray-800 font-medium">Responden</span>
                    </nav>
                </div>
                <a href="{{ route('admin_pemeringkatan.responden.create') }}" 
                    class="w-full sm:w-auto px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition duration-200 shadow-md hover:shadow-lg flex items-center justify-center">
                    <i class='bx bx-plus-circle text-xl mr-2'></i>
                    <span class="hidden sm:inline">Tambah Responden Baru</span>
                    <span class="sm:hidden">Tambah Baru</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700 whitespace-pre-line">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Filters Card -->
        <div class="bg-white rounded-xl shadow-md mb-6 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-4 sm:px-6 py-3">
                <h2 class="text-base sm:text-lg font-semibold text-white">Filter & Pencarian</h2>
            </div>
            
            <form method="GET" action="{{ route('admin_pemeringkatan.responden.index') }}" class="p-4 sm:p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Cari nama, email, instansi..." 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select name="kategori" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Kategori</option>
                            <option value="academic" {{ request('kategori') == 'academic' ? 'selected' : '' }}>Academic</option>
                            <option value="employer" {{ in_array(request('kategori'), ['employer', 'employee']) ? 'selected' : '' }}>Employee</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fakultas</label>
                        <select name="fakultas" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Fakultas</option>
                            <option value="pascasarjana" {{ request('fakultas') == 'pascasarjana' ? 'selected' : '' }}>PASCASARJANA</option>
                            <option value="fip" {{ request('fakultas') == 'fip' ? 'selected' : '' }}>FIP</option>
                            <option value="fmipa" {{ request('fakultas') == 'fmipa' ? 'selected' : '' }}>FMIPA</option>
                            <option value="fpsi" {{ request('fakultas') == 'fpsi' ? 'selected' : '' }}>FPsi</option>
                            <option value="fbs" {{ request('fakultas') == 'fbs' ? 'selected' : '' }}>FBS</option>
                            <option value="ft" {{ request('fakultas') == 'ft' ? 'selected' : '' }}>FT</option>
                            <option value="fikk" {{ strtolower(request('fakultas')) == 'fikk' ? 'selected' : '' }}>FIKK</option>
                            <option value="fish" {{ request('fakultas') == 'fish' ? 'selected' : '' }}>FISH</option>
                            <option value="feb" {{ request('fakultas') == 'feb' ? 'selected' : '' }}>FEB</option>
                            <option value="profesi" {{ request('fakultas') == 'profesi' ? 'selected' : '' }}>PROFESI</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Status</option>
                            <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum di-email</option>
                            <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Sudah di-email, belum di-follow up</option>
                            <option value="dones" {{ request('status') == 'dones' ? 'selected' : '' }}>Sudah di-email, sudah di-follow up</option>
                            <option value="clear" {{ request('status') == 'clear' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sumber Data</label>
                        <select name="sumber_data" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Sumber</option>
                            <option value="admin_only" {{ request('sumber_data') == 'admin_only' ? 'selected' : '' }}>Admin Direktorat</option>
                            <option value="non_admin" {{ request('sumber_data') == 'non_admin' ? 'selected' : '' }}>Fakultas & Prodi</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                        <input type="date" name="filter_date" value="{{ request('filter_date') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Show Per Page</label>
                        <select name="per_page" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            <option value="2000" {{ request('per_page') == 2000 ? 'selected' : '' }}>All</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <button type="submit" class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center justify-center">
                        <i class='bx bx-filter-alt mr-2'></i>Filter
                    </button>
                    <a href="{{ route('admin_pemeringkatan.responden.index') }}" 
                        class="w-full sm:w-auto px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition flex items-center justify-center">
                        <i class='bx bx-reset mr-2'></i>Reset
                    </a>
                    <div class="hidden sm:block sm:flex-1"></div>
                    <div class="grid grid-cols-2 sm:flex gap-3">
                        <button type="button" class="px-4 sm:px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition flex items-center justify-center" 
                            @click="$dispatch('open-import-modal')">
                            <i class='bx bx-import mr-2'></i><span class="hidden sm:inline">Import Excel</span><span class="sm:hidden">Import</span>
                        </button>
                        <button type="button" class="px-4 sm:px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center justify-center" 
                            @click="$dispatch('open-export-modal')">
                            <i class='bx bx-export mr-2'></i><span class="hidden sm:inline">Export Excel</span><span class="sm:hidden">Export</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">User</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Title</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nama Lengkap</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Jabatan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Instansi</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">No. HP</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'fakultas', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                                    class="hover:text-blue-600">
                                    Fakultas {!! request('sort') == 'fakultas' ? (request('direction') == 'asc' ? '↑' : '↓') : '' !!}
                                </a>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'category', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                                    class="hover:text-blue-600">
                                    Kategori {!! request('sort') == 'category' ? (request('direction') == 'asc' ? '↑' : '↓') : '' !!}
                                </a>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                                    class="hover:text-blue-600">
                                    Tanggal {!! request('sort') == 'created_at' ? (request('direction') == 'asc' ? '↑' : '↓') : '' !!}
                                </a>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($respondens as $i => $responden)
                            <tr class="hover:bg-gray-50 transition" id="responden-row-{{ $responden->id }}">
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $respondens->firstItem() + $i }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                    {{ $responden->user->name ?? 'ADMIN' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ Str::ucfirst($responden->title) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $responden->fullname }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $responden->jabatan }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $responden->instansi }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $responden->email }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $responden->phone_responden }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                    @php
                                        $fakultasValue = strtolower(trim($responden->fakultas));
                                        $displayFakultas = $fakultasValue;
                                        $normalizationMap = [
                                            'teknik' => 'ft',
                                            'fpbs' => 'fbs',
                                            'fkip' => 'fip',
                                            'fis' => 'fish',
                                            'fe' => 'feb',
                                            'fppsi' => 'fpsi',
                                        ];
                                        if (isset($normalizationMap[$fakultasValue])) {
                                            $displayFakultas = $normalizationMap[$fakultasValue];
                                        }
                                    @endphp
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ strtoupper($displayFakultas) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    @if(in_array(strtolower($responden->category), ['employee', 'employer', 'employeer', 'industri']))
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                            Employee
                                        </span>
                                    @elseif(in_array(strtolower($responden->category), ['academic', 'researcher', 'reseracher']))
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Academic
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ Str::ucfirst($responden->category) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                    {{ $responden->created_at?->format('d M Y') ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <select class="status-dropdown px-3 py-1 border border-gray-300 rounded-md text-xs focus:ring-2 focus:ring-blue-500" 
                                        data-id="{{ $responden->id }}" {{ $responden->status == 'clear' ? 'disabled' : '' }}>
                                        <option value="belum" {{ $responden->status == 'belum' ? 'selected' : '' }}>Belum di-email</option>
                                        <option value="done" {{ $responden->status == 'done' ? 'selected' : '' }}>Sudah di-email</option>
                                        <option value="dones" {{ $responden->status == 'dones' ? 'selected' : '' }}>Follow up done</option>
                                        <option value="clear" {{ $responden->status == 'clear' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin_pemeringkatan.responden.edit', $responden->id) }}" 
                                            class="px-3 py-1 bg-amber-500 text-white rounded hover:bg-amber-600 transition">
                                            <i class='bx bxs-edit'></i>
                                        </a>
                                        <button type="button" class="delete-btn px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition" 
                                            data-id="{{ $responden->id }}">
                                            <i class='bx bxs-trash'></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="px-4 py-8 text-center text-gray-500">
                                    <i class='bx bx-folder-open text-4xl mb-2'></i>
                                    <p>Tidak ada data responden</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($respondens->total() > 0)
                <div class="bg-gray-50 px-6 py-4 flex items-center justify-between border-t border-gray-200">
                    <div class="text-sm text-gray-600">
                        Menampilkan {{ $respondens->firstItem() }} sampai {{ $respondens->lastItem() }} dari {{ $respondens->total() }} hasil
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ $respondens->appends(request()->query())->previousPageUrl() }}" 
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition {{ $respondens->onFirstPage() ? 'opacity-50 cursor-not-allowed' : '' }}">
                            <i class='bx bx-chevron-left'></i> Previous
                        </a>
                        <a href="{{ $respondens->appends(request()->query())->nextPageUrl() }}" 
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition {{ !$respondens->hasMorePages() ? 'opacity-50 cursor-not-allowed' : '' }}">
                            Next <i class='bx bx-chevron-right'></i>
                        </a>
                    </div>
                </div>
            @endif
        </div>
        </div>
    </div>

    @include('admin_pemeringkatan.responden.modals')

    <script>
        //handler status
        document.querySelectorAll('.status-dropdown').forEach(dropdown => {
            dropdown.addEventListener('change', function() {
                const respondenId = this.dataset.id;
                const newStatus = this.value;
                const previousValue = this.dataset.previousValue || this.value;
                this.dataset.previousValue = previousValue;
                
                fetch(`/admin_pemeringkatan/responden/update-status/${respondenId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        })
                        this.dataset.previousValue = newStatus;
                        
                        if (newStatus === 'clear') {
                            this.disabled = true;
                        }
                        
                        // to do, ini gweh set timer tpi keknya kurang efisien meskipun bisa aja buat user tapi waiting 2000 tuh biar gk buru buru aja
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Gagal mengupdate status. Silakan coba lagi.',
                    });
                    
                    this.value = previousValue;
                });
            });
        });
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const respondenId = this.dataset.id;
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data responden akan dihapus permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EF4444',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/admin_pemeringkatan/responden/${respondenId}`;
                        
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
                        
                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'DELETE';
                        
                        form.appendChild(csrfToken);
                        form.appendChild(methodField);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
