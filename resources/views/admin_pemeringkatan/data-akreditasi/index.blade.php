@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    <!-- Main Container with Zoom Standards -->
    <div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8 xl:p-10 2xl:p-12">
        <div class="max-w-[1920px] mx-auto">
            
            <!-- Header -->
            <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Data Akreditasi</h1>
                    <p class="text-sm sm:text-base text-gray-600">Kelola data akreditasi program studi</p>
                </div>
                <a href="{{ route('admin_pemeringkatan.data-akreditasi.create') }}" 
                   class="inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm sm:text-base font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 w-full sm:w-auto">
                    <i class='bx bx-plus text-lg sm:text-xl mr-2'></i>
                    Tambah Data Akreditasi
                </a>
            </div>

            

            <!-- Alert Messages -->
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

            <!-- Filters Card -->
            <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class='bx bx-filter text-xl mr-2 text-blue-600'></i>
                        Filter Data
                    </h2>
                    @if(request()->hasAny(['search', 'fakultas', 'lembaga', 'peringkat']))
                    <a href="{{ route('admin_pemeringkatan.data-akreditasi.index') }}" 
                       class="text-sm text-gray-600 hover:text-gray-800 flex items-center">
                        <i class='bx bx-x text-lg mr-1'></i>
                        Reset Filter
                    </a>
                    @endif
                </div>
                
                <div>
                    <form method="GET" action="{{ route('admin_pemeringkatan.data-akreditasi.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        
                            <!-- Search -->
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                            <input type="text" 
                                   name="search" 
                                   id="search"
                                   value="{{ request('search') }}"
                                   placeholder="Program studi, nomor SK..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- Fakultas -->
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

                            <!-- Lembaga -->
                            <div>
                                <label for="lembaga" class="block text-sm font-medium text-gray-700 mb-1">Lembaga Akreditasi</label>
                            <select name="lembaga" 
                                    id="lembaga"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Semua Lembaga</option>
                                <option value="ban-pt" {{ request('lembaga') == 'ban-pt' ? 'selected' : '' }}>BAN-PT</option>
                                <option value="lam-infokom" {{ request('lembaga') == 'lam-infokom' ? 'selected' : '' }}>LAM INFOKOM</option>
                                <option value="lam-teknik" {{ request('lembaga') == 'lam-teknik' ? 'selected' : '' }}>LAM TEKNIK</option>
                                <option value="lam-ekonomi" {{ request('lembaga') == 'lam-ekonomi' ? 'selected' : '' }}>LAMEMBA</option>
                                <option value="lam-pendidikan" {{ request('lembaga') == 'lam-pendidikan' ? 'selected' : '' }}>LAMDIK</option>
                                <option value="lam-sains" {{ request('lembaga') == 'lam-sains' ? 'selected' : '' }}>LAMSAMA</option>
                            </select>
                            </div>

                            <!-- Peringkat -->
                            <div>
                                <label for="peringkat" class="block text-sm font-medium text-gray-700 mb-1">Peringkat</label>
                            <select name="peringkat" 
                                    id="peringkat"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Semua Peringkat</option>
                                <option value="unggul" {{ request('peringkat') == 'unggul' ? 'selected' : '' }}>Unggul</option>
                                <option value="baik_sekali" {{ request('peringkat') == 'baik_sekali' ? 'selected' : '' }}>Baik Sekali</option>
                                <option value="baik" {{ request('peringkat') == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="a" {{ request('peringkat') == 'a' ? 'selected' : '' }}>A</option>
                                <option value="b" {{ request('peringkat') == 'b' ? 'selected' : '' }}>B</option>
                                <option value="c" {{ request('peringkat') == 'c' ? 'selected' : '' }}>C</option>
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

            <!-- Data Table -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-4 sm:px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <i class='bx bx-list-ul text-2xl mr-2'></i>
                        Daftar Data Akreditasi
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
                                    Fakultas
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Program Studi
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Lembaga
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Peringkat
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nomor SK
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Periode Berlaku
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($akreditasis as $index => $akreditasi)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $akreditasis->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ strtoupper($akreditasi->fakultas) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $akreditasi->prodi }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @php
                                            $lembagaMapping = [
                                                'ban-pt' => 'BAN-PT',
                                                'lam-infokom' => 'LAM INFOKOM',
                                                'lam-teknik' => 'LAM TEKNIK',
                                                'lam-ekonomi' => 'LAMEMBA',
                                                'lam-pendidikan' => 'LAMDIK',
                                                'lam-sains' => 'LAMSAMA'
                                            ];
                                        @endphp
                                        {{ $lembagaMapping[$akreditasi->lembaga_akreditasi] ?? $akreditasi->lembaga_akreditasi }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $peringkatLabels = [
                                                'unggul' => ['label' => 'Unggul', 'class' => 'bg-purple-100 text-purple-800'],
                                                'baik_sekali' => ['label' => 'Baik Sekali', 'class' => 'bg-green-100 text-green-800'],
                                                'baik' => ['label' => 'Baik', 'class' => 'bg-blue-100 text-blue-800'],
                                                'a' => ['label' => 'A', 'class' => 'bg-green-100 text-green-800'],
                                                'b' => ['label' => 'B', 'class' => 'bg-yellow-100 text-yellow-800'],
                                                'c' => ['label' => 'C', 'class' => 'bg-orange-100 text-orange-800']
                                            ];
                                            $peringkat = $peringkatLabels[$akreditasi->peringkat] ?? ['label' => $akreditasi->peringkat, 'class' => 'bg-gray-100 text-gray-800'];
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $peringkat['class'] }}">
                                            {{ $peringkat['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $akreditasi->nomor_sk }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($akreditasi->periode_awal)->format('d/m/Y') }} - 
                                        {{ \Carbon\Carbon::parse($akreditasi->periode_akhir)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin_pemeringkatan.data-akreditasi.edit', $akreditasi->id) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-lg transition duration-150 ease-in-out">
                                                <i class='bx bx-edit text-base mr-1'></i>
                                                Edit
                                            </a>
                                            <form action="{{ route('admin_pemeringkatan.data-akreditasi.destroy', $akreditasi->id) }}" 
                                                  method="POST" 
                                                  class="inline-block delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-lg transition duration-150 ease-in-out">
                                                    <i class='bx bx-trash text-base mr-1'></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <i class='bx bx-data text-6xl mb-4 text-gray-300'></i>
                                            <p class="text-lg font-medium">Tidak ada data akreditasi</p>
                                            <p class="text-sm mt-1">Silakan tambah data akreditasi baru</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($akreditasis->hasPages())
                    <div class="bg-gray-50 px-4 sm:px-6 py-4 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div class="text-sm text-gray-700">
                                Menampilkan 
                                <span class="font-medium">{{ $akreditasis->firstItem() }}</span>
                                sampai 
                                <span class="font-medium">{{ $akreditasis->lastItem() }}</span>
                                dari 
                                <span class="font-medium">{{ $akreditasis->total() }}</span>
                                data
                            </div>
                            <div>
                                {{ $akreditasis->appends(request()->except('page'))->links() }}
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
        // Delete confirmation
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: "Apakah Anda yakin ingin menghapus data akreditasi ini?",
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
@endsection
