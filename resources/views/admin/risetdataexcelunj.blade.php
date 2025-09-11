@extends('admin.admin') @section('contentadmin')
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

{{-- SweetAlert Notifikasi --}}
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

{{-- Panel Aksi Import & Export --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
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
        <a href="{{ route('admin.risetdataunj.template') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full inline-flex items-center w-full justify-center">
            <i class='bx bxs-file-blank'></i> &nbsp; Unduh Template.xlsx
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
         <div class="flex items-center mb-3">
            <div class="bg-blue-100 p-3 rounded-full mr-4">
                <i class='bx bxs-file-import text-2xl text-blue-600'></i>
            </div>
            <h4 class="text-lg font-bold">2. Import Data</h4>
        </div>
        <p class="text-sm text-gray-600 mb-2">
           Pilih file .xlsx yang sudah diisi. <strong>Data lama akan terhapus</strong> dan diganti dengan yang baru.
        </p>
        <form action="{{ route('admin.risetdataunj.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 mb-3" required>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full inline-flex items-center w-full justify-center">
                <i class='bx bx-upload'></i> &nbsp; Import File
            </button>
        </form>
    </div>

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
        <a href="{{ route('admin.risetdataunj.export') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full inline-flex items-center w-full justify-center">
            <i class='bx bxs-file-export'></i> &nbsp; Export ke Excel
        </a>
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

        {{-- Pagination --}}
        <div class="mt-6 p-4">
            {{ $allRiset->links() }}
        </div>
    </div>
</div>
@endsection