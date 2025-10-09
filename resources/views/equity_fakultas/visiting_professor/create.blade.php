@extends('equity_fakultas.index')

@section('content')
<h3 class="text-3xl font-medium text-gray-700">Form Pengajuan: Visiting Top Professor</h3>

<div class="mt-8">
    <div class="p-6 bg-white rounded-lg shadow-md">
        <form action="{{ route('equity_fakultas.visiting-professors.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="fakultas">
                    Fakultas
                </label>
                
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-200 leading-tight focus:outline-none focus:shadow-outline" 
                       id="fakultas" 
                       type="text" 
                       value="{{ Auth::user()->profile?->fakultas?->name ?? 'Fakultas tidak ditemukan' }}" 
                       disabled>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_pengunggah">
                    Nama Pengunggah
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nama_pengunggah') border-red-500 @enderror" 
                       id="nama_pengunggah" 
                       name="nama_pengunggah"
                       type="text" 
                       value="{{ old('nama_pengunggah') }}">
                @error('nama_pengunggah')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="proposal_file">
                    Unggah Proposal (PDF atau Excel)
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('proposal_file') border-red-500 @enderror" 
                       id="proposal_file" 
                       name="proposal_file"
                       type="file"
                       accept=".pdf,.xlsx,.xls">
                <p class="text-gray-600 text-xs mt-1">Format yang diterima: PDF, Excel (.xlsx, .xls)</p>
                @error('proposal_file')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Ajukan Proposal
                </button>
                <a href="{{ route('equity_fakultas.visiting-professors.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection