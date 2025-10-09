@extends('equity_fakultas.index')

@section('content')
<h3 class="text-3xl font-medium text-gray-700">Lengkapi Data: Joint Supervision</h3>

<div class="mt-8">
    <div class="p-6 bg-white rounded-lg shadow-md">
        <form action="{{ route('equity_fakultas.joint-supervision.update', $submission->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
                <h4 class="text-lg font-semibold text-gray-700 mb-2">Informasi Proposal</h4>
                <p class="text-sm text-gray-600">
                    <strong>Pengunggah:</strong> {{ $submission->nama_pengunggah }} <br>
                    <strong>Tanggal Diajukan:</strong> {{ $submission->created_at->format('d F Y') }}
                </p>
                 @if($submission->catatan_admin)
                <div class="mt-2 text-sm text-yellow-800 bg-yellow-100 p-3 rounded-md">
                    <strong>Catatan dari Admin:</strong> {{ $submission->catatan_admin }}
                </div>
                @endif
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="bukti_keuangan_file">
                    Unggah Bukti Keuangan (PDF) <span class="text-red-500">*</span>
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('bukti_keuangan_file') border-red-500 @enderror" 
                       id="bukti_keuangan_file" 
                       name="bukti_keuangan_file"
                       type="file"
                       accept=".pdf"
                       required>
                @error('bukti_keuangan_file')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="laporan_kegiatan_file">
                    Unggah Laporan Kegiatan (PDF) <span class="text-red-500">*</span>
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('laporan_kegiatan_file') border-red-500 @enderror" 
                       id="laporan_kegiatan_file" 
                       name="laporan_kegiatan_file"
                       type="file"
                       accept=".pdf"
                       required>
                @error('laporan_kegiatan_file')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Simpan dan Selesaikan
                </button>
                <a href="{{ route('equity_fakultas.joint-supervision.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection