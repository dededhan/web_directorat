@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.incentivereviewer.index') }}" class="hover:text-teal-600">Insentif Reviewer</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Edit Pengajuan</li>
                </ol>
            </nav>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Edit Pengajuan Insentif</h1>
                <p class="mt-2 text-gray-600">Perbarui detail pengajuan insentif untuk reviewer.</p>
            </div>
        </header>

        {{-- Form --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <form method="POST" action="{{ route('admin_equity.incentivereviewer.update', $submission->id) }}">
                @csrf
                @method('PUT')
                <div class="p-6 sm:p-8 space-y-6">
                    <div>
                        <label for="nama_reviewer" class="block text-sm font-medium text-gray-700 mb-2">Nama Reviewer</label>
                        <input type="text" name="nama_reviewer" id="nama_reviewer" class="w-full text-gray-800 bg-gray-50 border border-gray-200 rounded-lg p-3" value="{{ $submission->nama_reviewer }}" required>
                    </div>

                    <div>
                        <label for="judul_artikel" class="block text-sm font-medium text-gray-700 mb-2">Judul Artikel yang Direview</label>
                        <input type="text" name="judul_artikel" id="judul_artikel" class="w-full text-gray-800 bg-gray-50 border border-gray-200 rounded-lg p-3" value="{{ $submission->judul_artikel }}" required>
                    </div>

                    <div>
                        <label for="tanggal_pengajuan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengajuan</label>
                        <input type="date" name="tanggal_pengajuan" id="tanggal_pengajuan" class="w-full text-gray-800 bg-gray-50 border border-gray-200 rounded-lg p-3" value="{{ isset($submission->tanggal_pengajuan) ? \Carbon\Carbon::parse($submission->tanggal_pengajuan)->format('Y-m-d') : '' }}" required>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" id="status" class="w-full text-gray-800 bg-gray-50 border border-gray-200 rounded-lg p-3" required>
                            <option value="Menunggu" {{ $submission->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Disetujui" {{ $submission->status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Ditolak" {{ $submission->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end p-6 bg-gray-50/50 border-t">
                    <a href="{{ route('admin_equity.incentivereviewer.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300">
                        Batal
                    </a>
                    <button type="submit" class="ml-3 inline-flex items-center px-6 py-2.5 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700">
                        <i class='bx bx-save text-lg mr-2'></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
