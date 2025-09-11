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
@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({ icon: 'success', title: 'Sukses!', text: '{{ session('success') }}' });
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
                <div class="flex-shrink-0 bg-gray-100 p-3 rounded-full">
                    {{-- SVG Icon Download --}}
                    <svg class="w-6 h-6 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-800">1. Unduh Template</h4>
                    <p class="text-sm text-gray-500 mt-1">Gunakan template ini sebagai panduan untuk memastikan format data yang Anda unggah sudah benar.</p>
                </div>
            </div>
        </div>
        <div class="mt-6">
            <a href="{{ route('admin.risetdataunj.template') }}" class="bg-gray-500 text-white font-semibold py-2.5 px-4 rounded-lg inline-flex items-center w-full justify-center hover:bg-gray-600 transition-colors text-sm">
                Unduh Template.xlsx
            </a>
        </div>
    </div>

    {{-- Card 2: Import Data --}}
    <div class="bg-white p-6 rounded-lg border border-gray-200 flex flex-col">
        <div class="flex-grow">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 bg-blue-100 p-3 rounded-full">
                     {{-- SVG Icon Import --}}
                    <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-800">2. Import Data</h4>
                    <p class="text-sm text-gray-500 mt-1">Pilih file .xlsx yang sudah diisi. <strong>Perhatikan Data sesuai dengan format xlsx/excel</strong>.</p>
                </div>
            </div>
        </div>
        <div class="mt-6">
            <button id="import-modal-btn" class="bg-blue-500 text-white font-semibold py-2.5 px-4 rounded-lg inline-flex items-center w-full justify-center hover:bg-blue-600 transition-colors text-sm">
                Import Data Riset
            </button>
        </div>
    </div>

    {{-- Card 3: Export Data --}}
    <div class="bg-white p-6 rounded-lg border border-gray-200 flex flex-col">
        <div class="flex-grow">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 bg-green-100 p-3 rounded-full">
                    {{-- SVG Icon Export --}}
                    <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-800">3. Export Data</h4>
                    <p class="text-sm text-gray-500 mt-1">Unduh semua data riset yang saat ini ada di database ke dalam satu file Excel.</p>
                </div>
            </div>
        </div>
        <div class="mt-6">
            <button id="export-btn" data-url="{{ route('admin.risetdataunj.export') }}" class="bg-green-500 text-white font-semibold py-2.5 px-4 rounded-lg inline-flex items-center w-full justify-center hover:bg-green-600 transition-colors text-sm">
                <span class="button-content">Export ke Excel</span>
            </button>
        </div>
    </div>
</div>

{{-- Modal untuk Import Data --}}
<div id="import-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-xl font-semibold text-gray-800">Import Data Riset</h3>
            <button id="close-modal-btn" class="text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
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
                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-5 rounded-lg inline-flex items-center hover:bg-blue-600">
                    Import
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Tabel Data Riset --}}
<div class="bg-white rounded-lg border border-gray-200">
    <div class="order">
        <div class="head p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Data Riset Saat Ini ({{ $allRiset->total() }} data)</h3>
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
                        <td class="p-4 text-sm text-gray-700">{{ $loop->iteration + $allRiset->firstItem() - 1 }}</td>
                        <td class="p-4 text-sm text-gray-700" title="{{ $riset->judul }}">{{ \Illuminate\Support\Str::limit($riset->judul, 50) }}</td>
                        <td class="p-4 text-sm text-gray-700">{{ $riset->ketua_peneliti }}</td>
                        <td class="p-4 text-sm text-gray-700"><span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">{{ $riset->fakultas }}</span></td>
                        <td class="p-4 text-sm text-gray-700">{{ $riset->tahun }}</td>
                        <td class="p-4 text-sm text-gray-700">Rp {{ number_format($riset->dana, 0, ',', '.') }}</td>
                        <td class="p-4 text-sm">
                            <form action="{{ route('admin.risetdataunj.destroy', $riset->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center p-8 text-gray-500">
                            Tidak ada data. Silakan import file Excel terlebih dahulu.
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const exportBtn = document.getElementById('export-btn');
        if (exportBtn) {
            exportBtn.addEventListener('click', function() {
                const url = this.dataset.url;
                const buttonContent = this.querySelector('.button-content');
                this.disabled = true;
                const originalText = buttonContent.innerHTML;
                buttonContent.innerHTML = `Mengekspor...`;

                const spinner = document.createElement('span');
                spinner.innerHTML = `<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;
                this.prepend(spinner);

                window.location.href = url;

                setTimeout(() => {
                    this.disabled = false;
                    this.removeChild(spinner);
                    buttonContent.innerHTML = originalText;
                }, 2000);
            });
        }

        const importModal = document.getElementById('import-modal');
        const importModalBtn = document.getElementById('import-modal-btn');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const fileUploadModal = document.getElementById('file-upload-modal');
        const fileNameDisplayModal = document.getElementById('file-name-modal');

        if (importModalBtn) {
            importModalBtn.addEventListener('click', () => {
                importModal.classList.remove('hidden');
            });
        }

        const hideModal = () => {
            importModal.classList.add('hidden');
            fileUploadModal.value = ''; // Reset file input
            fileNameDisplayModal.textContent = 'Tidak ada file yang dipilih';
        };

        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', hideModal);
        }
        
        if (importModal) {
            importModal.addEventListener('click', (e) => {
                if (e.target === importModal) {
                    hideModal();
                }
            });
        }

        if (fileUploadModal && fileNameDisplayModal) {
            fileUploadModal.addEventListener('change', function() {
                if (this.files.length > 0) {
                    fileNameDisplayModal.textContent = this.files[0].name;
                } else {
                    fileNameDisplayModal.textContent = 'Tidak ada file yang dipilih';
                }
            });
        }
    });
</script>
@endsection