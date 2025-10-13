@extends('admin.admin')

@section('contentadmin')
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 500: '#0d6d38', 600: '#095629', 700: '#064520' }
                    }
                }
            }
        }
    </script>

    <!-- Breadcrumb Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Kelola Dokumen</h1>
                <div class="flex items-center text-sm text-gray-600 space-x-2">
                    <a href="#" class="hover:text-primary-500 transition-colors">Dashboard</a>
                    <i class='bx bx-chevron-right'></i>
                    <span class="text-primary-500 font-semibold">Kelola Dokumen</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm animate-fade-in">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                <div class="flex-1">
                    <p class="text-green-800 font-semibold">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-green-500 hover:text-green-700 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm animate-fade-in">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                <div class="flex-1">
                    <p class="text-red-800 font-semibold">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-red-500 hover:text-red-700 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif
    
    @if ($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm animate-fade-in">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-red-500 text-xl mr-3 mt-1"></i>
                <div class="flex-1">
                    <p class="text-red-800 font-semibold mb-2">Terjadi kesalahan:</p>
                    <ul class="list-disc list-inside text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-red-500 hover:text-red-700 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Input Form -->
    <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8 mb-8 border border-gray-200 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center mb-6 pb-4 border-b border-gray-200">
            <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg flex items-center justify-center mr-4 shadow-md">
                <i class="fas fa-file-upload text-white text-lg"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">Input Dokumen Baru</h3>
        </div> 
        
        <form method="POST" action="{{ route('admin.document.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kategori -->
                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-tags text-primary-500 mr-2"></i>Kategori
                    </label>
                    <select name="kategori" id="category" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-4 focus:ring-primary-500 focus:ring-opacity-20 transition-all duration-300 bg-white">
                        <option value="">Pilih Kategori</option>
                        <option value="umum">Umum</option>
                        <option value="pemeringkatan">Pemeringkatan</option>
                        <option value="inovasi">Inovasi</option>
                    </select>
                    <p class="mt-2 text-xs text-gray-500">Pilih kategori dokumen yang sesuai</p>
                </div>

                <!-- Tanggal Publikasi -->
                <div>
                    <label for="tanggal" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt text-primary-500 mr-2"></i>Tanggal Publikasi
                    </label>
                    <input type="date" name="tanggal" id="tanggal" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-4 focus:ring-primary-500 focus:ring-opacity-20 transition-all duration-300">
                    <p class="mt-2 text-xs text-gray-500">Pilih tanggal publikasi dokumen</p>
                </div>
            </div>

            <!-- Judul Dokumen -->
            <div>
                <label for="judul_dokumen" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-heading text-primary-500 mr-2"></i>Judul Dokumen
                </label>
                <input type="text" name="judul_dokumen" id="judul_dokumen" required maxlength="200"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-4 focus:ring-primary-500 focus:ring-opacity-20 transition-all duration-300"
                       placeholder="Masukkan judul dokumen...">
                <p class="mt-2 text-xs text-gray-500">Masukkan judul dokumen (maksimal 200 karakter)</p>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-align-left text-primary-500 mr-2"></i>Deskripsi Dokumen
                </label>
                <textarea name="deskripsi" id="deskripsi" rows="4"
                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-4 focus:ring-primary-500 focus:ring-opacity-20 transition-all duration-300 resize-none"
                          placeholder="Tuliskan deskripsi singkat tentang dokumen..."></textarea>
                <p class="mt-2 text-xs text-gray-500">Tuliskan deskripsi singkat tentang dokumen (opsional)</p>
            </div>

            <!-- File Upload -->
            <div>
                <label for="file_dokumen" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-cloud-upload-alt text-primary-500 mr-2"></i>File Dokumen
                </label>
                <div class="relative">
                    <input type="file" name="file_dokumen" id="file_dokumen" accept=".pdf,.docx,.doc" required
                           class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-4 focus:ring-primary-500 focus:ring-opacity-20 transition-all duration-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary-500 file:text-white file:font-semibold hover:file:bg-primary-600 cursor-pointer">
                </div>
                <p class="mt-2 text-xs text-gray-500"><i class="fas fa-info-circle mr-1"></i>Upload file dokumen (format: PDF, DOC, atau DOCX, maks 10MB)</p>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4 border-t border-gray-200">
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-lg hover:from-primary-600 hover:to-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    <span>Simpan Dokumen</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Documents Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-5 flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-list text-white text-lg"></i>
                </div>
                <h3 class="text-2xl font-bold text-white">Daftar Dokumen</h3>
            </div>
            <span class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-lg font-semibold">
                {{ count($dokumens) }} Dokumen
            </span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Judul Dokumen</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Ukuran</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($dokumens as $dokumen)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($dokumen->kategori === 'umum') bg-blue-100 text-blue-800
                                @elseif($dokumen->kategori === 'pemeringkatan') bg-green-100 text-green-800
                                @elseif($dokumen->kategori === 'inovasi') bg-orange-100 text-orange-800
                                @endif">
                                {{ strtoupper($dokumen->kategori) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>{{ $dokumen->tanggal_publikasi }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 max-w-md">
                            <div class="line-clamp-2">{{ $dokumen->judul_dokumen }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                            @if($dokumen->ukuran > 1000000)
                                {{ number_format($dokumen->ukuran / 1048576, 1) }} MB
                            @else
                                {{ number_format($dokumen->ukuran / 1024, 0) }} KB
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.document.download', $dokumen->id) }}" 
                                   class="inline-flex items-center px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold rounded-lg transition-colors duration-300 shadow-sm hover:shadow-md"
                                   title="Download {{ $dokumen->nama_file }}">
                                    <i class="fas fa-download mr-1"></i> Download
                                </a>
                                <button class="edit-document inline-flex items-center px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold rounded-lg transition-colors duration-300 shadow-sm hover:shadow-md" 
                                        data-id="{{ $dokumen->id }}"
                                        data-kategori="{{ $dokumen->kategori }}"
                                        data-tanggal="{{ $dokumen->tanggal_publikasi }}"
                                        data-judul="{{ $dokumen->judul_dokumen }}"
                                        data-deskripsi="{{ $dokumen->deskripsi }}">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </button>
                                <form action="{{ route('admin.document.destroy', $dokumen) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-dokumen inline-flex items-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-lg transition-colors duration-300 shadow-sm hover:shadow-md">
                                        <i class="fas fa-trash-alt mr-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editDocumentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-5 flex items-center justify-between rounded-t-2xl">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-edit text-white text-lg"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white">Edit Dokumen</h3>
                </div>
                <button onclick="closeEditModal()" class="text-white hover:text-gray-200 transition-colors">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            
            <form id="edit-document-form" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="edit_kategori" class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                        <select name="kategori" id="edit_kategori" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-4 focus:ring-primary-500 focus:ring-opacity-20 transition-all">
                            <option value="umum">Umum</option>
                            <option value="pemeringkatan">Pemeringkatan</option>
                            <option value="inovasi">Inovasi</option>
                        </select>
                    </div>
                    <div>
                        <label for="edit_tanggal" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Publikasi</label>
                        <input type="date" name="tanggal" id="edit_tanggal" required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-4 focus:ring-primary-500 focus:ring-opacity-20 transition-all">
                    </div>
                </div>

                <div>
                    <label for="edit_judul_dokumen" class="block text-sm font-semibold text-gray-700 mb-2">Judul Dokumen</label>
                    <input type="text" name="judul_dokumen" id="edit_judul_dokumen" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-4 focus:ring-primary-500 focus:ring-opacity-20 transition-all">
                </div>

                <div>
                    <label for="edit_deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Dokumen</label>
                    <textarea name="deskripsi" id="edit_deskripsi" rows="3"
                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-4 focus:ring-primary-500 focus:ring-opacity-20 transition-all resize-none"></textarea>
                </div>

                <div>
                    <label for="edit_file_dokumen" class="block text-sm font-semibold text-gray-700 mb-2">File Dokumen (Opsional)</label>
                    <input type="file" name="file_dokumen" id="edit_file_dokumen"
                           class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary-500 file:text-white file:font-semibold hover:file:bg-primary-600">
                    <p class="mt-2 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah file</p>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeEditModal()" 
                            class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors duration-300">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-lg hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    function closeEditModal() {
        document.getElementById('editDocumentModal').classList.add('hidden');
        document.getElementById('editDocumentModal').classList.remove('flex');
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Edit Document Modal
        document.querySelectorAll('.edit-document').forEach(button => {
            button.addEventListener('click', function() {
                const docId = this.dataset.id;
                const modal = document.getElementById('editDocumentModal');
                
                document.getElementById('edit_kategori').value = this.dataset.kategori;
                document.getElementById('edit_tanggal').value = this.dataset.tanggal;
                document.getElementById('edit_judul_dokumen').value = this.dataset.judul;
                document.getElementById('edit_deskripsi').value = this.dataset.deskripsi;
                document.getElementById('edit-document-form').action = `/admin/document/${docId}`;
                
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });

        // Handle delete confirmation
        document.querySelectorAll('.delete-dokumen').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: "Apakah Anda yakin ingin menghapus dokumen ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Handle flash messages
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                timer: 2000,
                showConfirmButton: false
            });
        @endif
    });
    </script>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
@endsection
