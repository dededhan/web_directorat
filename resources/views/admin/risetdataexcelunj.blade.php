@extends('admin.admin')

@section('contentadmin')
<div class="head-title">
    <div class="left">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Manajemen Data Riset UNJ</h1>
        <ul class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="#">Riset UNJ</a></li>
        </ul>
    </div>
</div>

{{-- Script Notifikasi Swal --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({ icon: 'success', title: 'Sukses!', text: '{{ session('success') }}', timer: 2500, showConfirmButton: false });
    });
</script>
@endif
@if (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}' });
    });
</script>
@endif

{{-- Grid Kartu Aksi --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 my-8">
    {{-- Card 1: Unduh Template --}}
    <div class="bg-white p-6 rounded-lg border border-gray-200 flex flex-col">
        <div class="flex-grow">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 bg-gray-100 p-3 rounded-full"><svg class="w-6 h-6 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg></div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-800">1. Unduh Template</h4>
                    <p class="text-sm text-gray-500 mt-1">Gunakan template ini untuk memastikan format data yang Anda unggah sudah benar.</p>
                </div>
            </div>
        </div>
        <div class="mt-6">
            <a href="{{ route('admin.risetdataunj.template') }}" class="bg-gray-500 text-white font-semibold py-2.5 px-4 rounded-lg inline-flex items-center w-full justify-center hover:bg-gray-600 transition-colors text-sm">Unduh Template.xlsx</a>
        </div>
    </div>
    {{-- Card 2: Import Data --}}
    <div class="bg-white p-6 rounded-lg border border-gray-200 flex flex-col">
        <div class="flex-grow">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 bg-blue-100 p-3 rounded-full"><svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" /></svg></div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-800">2. Import Data</h4>
                    <p class="text-sm text-gray-500 mt-1">Pilih file .xlsx yang sudah diisi. <strong>Perhatikan format data</strong>.</p>
                </div>
            </div>
        </div>
        <div class="mt-6">
            <button id="import-modal-btn" class="bg-blue-500 text-white font-semibold py-2.5 px-4 rounded-lg inline-flex items-center w-full justify-center hover:bg-blue-600 transition-colors text-sm">Import Data Riset</button>
        </div>
    </div>
    {{-- Card 3: Export Data --}}
    <div class="bg-white p-6 rounded-lg border border-gray-200 flex flex-col">
        <div class="flex-grow">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 bg-green-100 p-3 rounded-full"><svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg></div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-800">3. Export Data</h4>
                    <p class="text-sm text-gray-500 mt-1">Unduh semua data riset yang saat ini ada di database ke dalam satu file Excel.</p>
                </div>
            </div>
        </div>
        <div class="mt-6">
            <a href="{{ route('admin.risetdataunj.export') }}" id="export-btn" class="bg-green-500 text-white font-semibold py-2.5 px-4 rounded-lg inline-flex items-center w-full justify-center hover:bg-green-600 transition-colors text-sm">Export ke Excel</a>
        </div>
    </div>
</div>

{{-- Tabel Data Riset --}}
<div class="bg-white rounded-lg border border-gray-200">
    <div class="order">
        <div class="head p-4 border-b border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Data Riset Saat Ini ({{ $allRiset->total() }} data)</h3>
            </div>
            <div class="flex items-center gap-2 w-full md:w-auto">
                {{-- Form Pencarian --}}
                <form action="{{ route('admin.risetdataunj.index') }}" method="GET" class="flex-grow">
                    <div class="relative">
                        <input type="text" name="search" class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Cari judul, peneliti, fakultas..." value="{{ request('search') }}">
                        <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400'></i>
                    </div>
                </form>
                {{-- Tombol Hapus Semua --}}
                 @if($allRiset->total() > 0)
                <form action="{{ route('admin.risetdataunj.destroyAll') }}" method="POST" id="delete-all-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white p-2 rounded-lg hover:bg-red-700 transition-colors" title="Hapus Semua Data">
                        <i class='bx bx-trash-alt text-lg'></i>
                    </button>
                </form>
                @endif
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px]">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul</th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ketua Peneliti</th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fakultas</th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tahun</th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Dana</th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($allRiset as $riset)
                    <tr>
                        <td class="p-4 text-sm text-gray-700 align-top">{{ $loop->iteration + $allRiset->firstItem() - 1 }}</td>
                        <td class="p-4 text-sm text-gray-700 align-top" title="{{ $riset->judul }}">{{ \Illuminate\Support\Str::limit($riset->judul, 50) }}</td>
                        <td class="p-4 text-sm text-gray-700 align-top">{{ $riset->ketua_peneliti }}</td>
                        <td class="p-4 text-sm text-gray-700 align-top"><span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">{{ $riset->fakultas }}</span></td>
                        <td class="p-4 text-sm text-gray-700 align-top">{{ $riset->tahun }}</td>
                        <td class="p-4 text-sm text-gray-700 align-top">Rp {{ number_format($riset->dana, 0, ',', '.') }}</td>
                        <td class="p-4 text-sm align-top">
                            <div class="flex items-center gap-3">
                                {{-- Tombol Edit --}}
                                <button type="button" class="text-yellow-600 hover:text-yellow-800 font-semibold edit-btn"
                                    data-id="{{ $riset->id }}"
                                    data-judul="{{ $riset->judul }}"
                                    data-ketua="{{ $riset->ketua_peneliti }}"
                                    data-fakultas="{{ $riset->fakultas }}"
                                    data-tahun="{{ $riset->tahun }}"
                                    data-dana="{{ $riset->dana }}"
                                    data-action="{{ route('admin.risetdataunj.update', $riset->id) }}">
                                    Edit
                                </button>
                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.risetdataunj.destroy', $riset->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center p-8 text-gray-500">
                            Tidak ada data ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($allRiset->hasPages())
            <div class="p-4 border-t border-gray-200">
                {{ $allRiset->links() }}
            </div>
        @endif
    </div>
</div>

{{-- MODALS --}}
{{-- Modal untuk Import Data --}}
<div id="import-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-xl font-semibold text-gray-800">Import Data Riset</h3>
            <button class="close-modal-btn text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        <form action="{{ route('admin.risetdataunj.import') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <label for="file-upload-modal" class="cursor-pointer border-2 border-dashed border-gray-300 rounded-lg p-8 w-full flex flex-col items-center justify-center text-center hover:border-blue-500 hover:bg-gray-50 transition-colors">
                <svg class="w-12 h-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" /></svg>
                <span class="mt-4 text-sm font-semibold text-gray-600">Klik untuk memilih file</span>
                <span id="file-name-modal" class="text-xs text-gray-500 mt-1 truncate">Tidak ada file yang dipilih</span>
            </label>
            <input id="file-upload-modal" name="file" type="file" class="hidden" required accept=".xlsx,.xls">
            <div class="mt-6 pt-4 border-t flex justify-end">
                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-5 rounded-lg inline-flex items-center hover:bg-blue-600">Import</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal untuk Edit Data --}}
<div id="edit-modal" class="fixed inset-0 bg-black bg-opacity-10 flex items-center justify-center p-4 z-50 hidden">
    {{-- Animasi saat modal muncul --}}
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl transform transition-all duration-300 ease-in-out scale-95">
        
        {{-- Header Modal --}}
        <div class="flex justify-between items-center p-5 border-b border-gray-200 bg-gray-50 rounded-t-xl">
            <div class="flex items-center gap-3">
                <div class="bg-blue-100 p-2 rounded-full">
                    <i class='bx bxs-edit-alt text-blue-600 text-xl'></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Edit Data Riset</h3>
            </div>
            <button class="close-modal-btn text-gray-400 hover:text-red-500 text-3xl transition-colors">&times;</button>
        </div>

        {{-- Form Content --}}
        <form id="edit-form" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            {{-- Field Judul --}}
            <div>
                <label for="edit_judul" class="block text-sm font-semibold text-gray-600 mb-1">Judul</label>
                <textarea id="edit_judul" name="judul" rows="3" class="mt-1 block w-full px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow" placeholder="Contoh: Pengembangan Aplikasi Mobile Edukasi" required></textarea>
            </div>
            
            {{-- Field Ketua Peneliti --}}
            <div>
                <label for="edit_ketua_peneliti" class="block text-sm font-semibold text-gray-600 mb-1">Ketua Peneliti</label>
                <input type="text" id="edit_ketua_peneliti" name="ketua_peneliti" class="mt-1 block w-full px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow" placeholder="Contoh: Prof. Dr. Nama Dosen, M.Kom." required>
            </div>
            
            {{-- Grid untuk Fakultas, Tahun, Dana --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="edit_fakultas" class="block text-sm font-semibold text-gray-600 mb-1">Fakultas</label>
                    <input type="text" id="edit_fakultas" name="fakultas" class="mt-1 block w-full px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow" placeholder="Contoh: FT" required>
                </div>
                 <div>
                    <label for="edit_tahun" class="block text-sm font-semibold text-gray-600 mb-1">Tahun</label>
                    <input type="number" id="edit_tahun" name="tahun" class="mt-1 block w-full px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow" placeholder="Contoh: 2025" required>
                </div>
                <div>
                    <label for="edit_dana" class="block text-sm font-semibold text-gray-600 mb-1">Dana (Rp)</label>
                    <input type="number" id="edit_dana" name="dana" class="mt-1 block w-full px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow" placeholder="Contoh: 50000000" required>
                </div>
            </div>

            {{-- Footer Tombol Aksi --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-3 font-bold text-white bg-gradient-to-r from-amber-500 to-orange-500 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-300 ease-in-out">
                    <i class='bx bx-save text-xl'></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('edit-modal');
    const modalContent = editModal.querySelector('.transform');

    // Modifikasi fungsi showModal yang sudah ada
    const originalShowModal = (modal) => {
        if (modal.id === 'edit-modal') {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95');
            }, 10); // small delay to ensure transition triggers
        } else {
            modal.classList.remove('hidden');
        }
    };
    
    // Modifikasi fungsi hideModal
    const originalHideModal = (modal) => {
        if (modal.id === 'edit-modal') {
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300); // Wait for animation to finish
        } else {
            modal.classList.add('hidden');
        }
    };

    // ... (sisa dari JavaScript Anda untuk event listener)
    // Pastikan Anda mengganti pemanggilan showModal dan hideModal dengan versi baru ini
    // Contoh:
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            // ... (kode Anda untuk mengisi data form)
            originalShowModal(editModal);
        });
    });

    document.querySelectorAll('.close-modal-btn').forEach(btn => {
        btn.addEventListener('click', () => {
             const modal = btn.closest('#edit-modal, #import-modal');
             if(modal) originalHideModal(modal);
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // === Logic untuk Modal (Import & Edit) ===
    const importModal = document.getElementById('import-modal');
    const editModal = document.getElementById('edit-modal');
    const importModalBtn = document.getElementById('import-modal-btn');
    const closeButtons = document.querySelectorAll('.close-modal-btn');

    const showModal = (modal) => modal.classList.remove('hidden');
    const hideModal = (modal) => modal.classList.add('hidden');

    if (importModalBtn) {
        importModalBtn.addEventListener('click', () => showModal(importModal));
    }

    closeButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            hideModal(importModal);
            hideModal(editModal);
        });
    });

    window.addEventListener('click', (e) => {
        if (e.target === importModal) hideModal(importModal);
        if (e.target === editModal) hideModal(editModal);
    });

    const fileUploadModal = document.getElementById('file-upload-modal');
    const fileNameDisplayModal = document.getElementById('file-name-modal');
    if (fileUploadModal) {
        fileUploadModal.addEventListener('change', function() {
            fileNameDisplayModal.textContent = this.files.length > 0 ? this.files[0].name : 'Tidak ada file yang dipilih';
        });
    }

    // === Logic untuk Edit Data ===
    const editForm = document.getElementById('edit-form');
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const data = this.dataset;
            editForm.action = data.action;
            document.getElementById('edit_judul').value = data.judul;
            document.getElementById('edit_ketua_peneliti').value = data.ketua;
            document.getElementById('edit_fakultas').value = data.fakultas;
            document.getElementById('edit_tahun').value = data.tahun;
            document.getElementById('edit_dana').value = data.dana;
            showModal(editModal);
        });
    });
    
    // === Logic Konfirmasi Hapus dengan SweetAlert ===
    // Untuk hapus satu per satu
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            Swal.fire({
                title: 'Anda Yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
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

    // Untuk hapus semua data
    const deleteAllForm = document.getElementById('delete-all-form');
    if (deleteAllForm) {
        deleteAllForm.addEventListener('submit', function (event) {
            event.preventDefault();
            Swal.fire({
                title: 'Anda Yakin Ingin Menghapus SEMUA Data?',
                text: "Tindakan ini bersifat permanen dan akan mengosongkan seluruh tabel riset!",
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus Semua!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteAllForm.submit();
                }
            });
        });
    }
});
</script>
@endsection