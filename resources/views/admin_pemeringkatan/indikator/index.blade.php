@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    <div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8 xl:p-10 2xl:p-12">
        <div class="max-w-[1920px] mx-auto">
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Indikator Pemeringkatan</h1>
                    <p class="text-sm text-gray-600 mt-1">Kelola indikator penilaian pemeringkatan</p>
                </div>
                <a href="{{ route('admin_pemeringkatan.indikator.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    <i class='bx bx-plus text-xl mr-2'></i>
                    Tambah Indikator
                </a>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-start">
                    <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="whitespace-pre-line">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6 flex items-start">
                    <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="whitespace-pre-line">{{ session('error') }}</span>
                </div>
            @endif

            <!-- List Indikator Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-white">Daftar Indikator Pemeringkatan</h2>
                            <p class="text-gray-300 text-sm mt-1">{{ $indikators->count() }} indikator terdaftar</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    @if($indikators->isEmpty())
                        <div class="text-center py-16">
                            <i class='bx bx-chart-line text-6xl text-gray-300 mb-4'></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada indikator</h3>
                            <p class="text-sm text-gray-500 mb-6">Mulai dengan menambahkan indikator penilaian pertama</p>
                            <a href="{{ route('admin_pemeringkatan.indikator.create') }}" 
                               class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <i class='bx bx-plus text-lg mr-2'></i>
                                Tambah Indikator
                            </a>
                        </div>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Indikator</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($indikators as $index => $indikator)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ $indikator->judul }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ Str::limit(strip_tags($indikator->deskripsi), 100) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('admin_pemeringkatan.indikator.edit', $indikator->id) }}" 
                                                   class="inline-flex items-center px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium rounded transition-colors duration-200">
                                                    <i class='bx bx-edit text-sm mr-1'></i>
                                                    Edit
                                                </a>
                                                <form 
                                                    method="POST" 
                                                    action="{{ route('admin_pemeringkatan.indikator.destroy', $indikator->id) }}"
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
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // SweetAlert2 confirmation for delete
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        text: 'Apakah Anda yakin ingin menghapus indikator ini?',
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
