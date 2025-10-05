@extends('equity_fakultas.index')

@section('content')
<h3 class="text-3xl font-medium text-gray-700">Form Pengajuan: Joint Supervision</h3>

<div class="mt-8">
    <div class="p-6 bg-white rounded-lg shadow-md">
        {{-- Ganti route ke joint-supervision.store --}}
        <form action="{{ route('equity_fakultas.joint-supervision.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- ... (Isi form sama persis seperti visiting_professor/create.blade.php) ... --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="fakultas">Fakultas</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-200 leading-tight focus:outline-none focus:shadow-outline" id="fakultas" type="text" value="{{ Auth::user()->profile->fakultas->name ?? 'Fakultas tidak ditemukan' }}" disabled>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_pengunggah">Nama Pengunggah</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nama_pengunggah') border-red-500 @enderror" id="nama_pengunggah" name="nama_pengunggah" type="text" value="{{ old('nama_pengunggah', Auth::user()->name) }}">
                @error('nama_pengunggah') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="proposal_file">Unggah Proposal (PDF)</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('proposal_file') border-red-500 @enderror" id="proposal_file" name="proposal_file" type="file" accept=".pdf">
                @error('proposal_file') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Ajukan Proposal
                </button>
                {{-- Ganti route ke joint-supervision.index --}}
                <a href="{{ route('equity_fakultas.joint-supervision.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection