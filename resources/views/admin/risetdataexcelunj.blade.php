@extends('admin.admin')

@section('contentadmin')
<div class="head-title">
    <div class="left">
        <h1>Manajemen Data Riset UNJ</h1>
        <ul class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="#">Riset UNJ</a></li>
        </ul>
    </div>
</div>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire('Sukses!', '{{ session('success') }}', 'success');
    });
</script>
@endif
@if (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire('Gagal!', '{{ session('error') }}', 'error');
    });
</script>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    {{-- Card 1: Unduh Template --}}
    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-gray-400">
        <div class="flex items-center mb-3">
            <div class="bg-gray-100 p-3 rounded-full mr-4">
                <i class='bx bxs-download text-2xl text-gray-600'></i>
            </div>
            <h4 class="text-lg font-bold">1. Unduh Template</h4>
        </div>
        <p class="text-sm text-gray-600 mb-4">
            Gunakan template ini sebagai panduan untuk memastikan format data yang Anda unggah sudah benar.
        </p>
        <a href="{{ route('admin.risetdataunj.template') }}" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full inline-flex items-center w-full justify-center">
            <i class='bx bxs-file-blank'></i> &nbsp; Unduh Template.xlsx
        </a>
    </div>

    {{-- Card 2: Tombol Trigger Import Modal --}}
    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
        <div class="flex items-center mb-3">
            <div class="bg-blue-100 p-3 rounded-full mr-4">
                <i class='bx bxs-file-import text-2xl text-blue-600'></i>
            </div>
            <h4 class="text-lg font-bold">2. Import Data</h4>
        </div>
        <p class="text-sm text-gray-600 mb-4">
           Pilih file .xlsx yang sudah diisi. <strong>Perhatikan Data sesuai dengan format xlsx/excel</strong>.
        </p>
        <button id="import-modal-btn" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-full inline-flex items-center w-full justify-center">
            <i class='bx bx-upload'></i> &nbsp;  Import Data Riset
        </button>
    </div>

    {{-- Card 3: Export Data --}}
    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
        <div class="flex items-center mb-3">
            <div class="bg-green-100 p-3 rounded-full mr-4">
                <i class='bx bxs-file-export text-2xl text-green-600'></i>
            </div>
            <h4 class="text-lg font-bold">3. Export Data</h4>
        </div>
        <p class="text-sm text-gray-600 mb-4">
            Unduh semua data riset yang saat ini ada di database ke dalam satu file Excel.
        </p>
        <button id="export-btn" data-url="{{ route('admin.risetdataunj.export') }}" class="bg-green-500 text-white font-bold py-2 px-4 rounded-full inline-flex items-center w-full justify-center transition-opacity duration-200">
            <span class="button-content">
                <i class='bx bxs-file-export'></i> &nbsp; Export ke Excel
            </span>
        </button>
    </div>
</div>

{{-- Modal untuk Import Data --}}
<div id="import-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md transform transition-all">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-xl font-semibold text-gray-800">Import Data Riset</h3>
            <button id="close-modal-btn" class="text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.risetdataunj.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <p class="text-sm text-gray-600 mb-4">
                  Pilih file .xlsx yang sudah diisi. <strong>Perhatikan Data sesuai dengan format xlsx/excel</strong>
                </p>
                <label for="file-upload-modal" class="cursor-pointer bg-blue-500 text-white font-bold py-2 px-4 rounded-full inline-flex items-center w-full justify-center">
                    <i class='bx bx-file'></i> &nbsp; Pilih File...
                </label>
                <input id="file-upload-modal" name="file" type="file" class="hidden" required>
                <p id="file-name-modal" class="text-sm text-gray-500 mt-2 text-center truncate">Tidak ada file yang dipilih</p>
                <div class="mt-6 pt-4 border-t flex justify-end">
                    <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center">
                        <i class='bx bx-upload'></i> &nbsp; Import Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Tabel Data Riset --}}
<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Data Riset Saat Ini ({{ $allRiset->total() }} data)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Ketua Peneliti</th>
                        <th>Fakultas</th>
                        <th>Tahun</th>
                        <th>Dana</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($allRiset as $riset)
                    <tr>
                        <td>{{ $loop->iteration + $allRiset->firstItem() - 1 }}</td>
                        <td title="{{ $riset->judul }}">{{ \Illuminate\Support\Str::limit($riset->judul, 60) }}</td>
                        <td>{{ $riset->ketua_peneliti }}</td>
                        <td><span class="status completed">{{ $riset->fakultas }}</span></td>
                        <td>{{ $riset->tahun }}</td>
                        <td>Rp {{ number_format($riset->dana, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('admin.risetdataunj.destroy', $riset->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center p-4">Tidak ada data. Silakan import file Excel terlebih dahulu.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6 p-4">
            {{ $allRiset->links() }}
        </div>
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
                buttonContent.innerHTML = `<i class='bx bx-loader-alt animate-spin'></i> &nbsp; Mengekspor...`;
                window.location.href = url;
                setTimeout(() => {
                    this.disabled = false;
                    buttonContent.innerHTML = `<i class='bx bxs-file-export'></i> &nbsp; Export ke Excel`;
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

        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', () => {
                importModal.classList.add('hidden');
            });
        }
        
        if (importModal) {
            importModal.addEventListener('click', (e) => {
                if (e.target === importModal) {
                    importModal.classList.add('hidden');
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