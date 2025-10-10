@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="{ 
    anggota: {{ json_encode($proposal->anggota->map(function($a) { 
        return ['nama_dosen' => $a->nama_dosen, 'nip' => $a->nip, 'fakultas' => $a->fakultas, 'prodi' => $a->prodi]; 
    })->toArray()) }} 
}">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Edit Proposal Modul Ajar</h1>
            <p class="mt-2 text-gray-600">{{ $proposal->sesi->nama_sesi }}</p>
        </header>

        @if($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
            <ul class="list-disc list-inside text-red-800">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('subdirektorat-inovasi.dosen.hibah_modul.update', $proposal->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-lg p-8 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Modul <span class="text-red-500">*</span></label>
                <input type="text" name="judul_modul" value="{{ old('judul_modul', $proposal->judul_modul) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Ringkasan Modul (max 300 kata) <span class="text-red-500">*</span></label>
                <textarea name="ringkasan_modul" rows="5" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">{{ old('ringkasan_modul', $proposal->ringkasan_modul) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kata Kunci</label>
                <input type="text" name="kata_kunci" id="kata_kunci" value="{{ old('kata_kunci', is_array($proposal->kata_kunci) ? implode(', ', $proposal->kata_kunci) : '') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">SDGs Terkait</label>
                <input type="text" name="sdgs" id="sdgs" value="{{ old('sdgs', is_array($proposal->sdgs) ? implode(', ', $proposal->sdgs) : '') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">File Proposal (PDF)</label>
                @if($proposal->file_proposal)
                <div class="mb-2">
                    <a href="{{ Storage::url($proposal->file_proposal) }}" target="_blank" class="text-blue-600 hover:text-blue-700 text-sm">
                        <i class='bx bx-file-blank mr-1'></i>Lihat file saat ini
                    </a>
                </div>
                @endif
                <input type="file" name="file_proposal" accept=".pdf" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah file</p>
            </div>

            <div class="border-t pt-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Anggota Penyusun</h3>
                    <button type="button" @click="anggota.push({ nama_dosen: '', nip: '', fakultas: '', prodi: '' })" class="px-3 py-1 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                        <i class='bx bx-plus mr-1'></i>Tambah Anggota
                    </button>
                </div>

                <template x-for="(item, index) in anggota" :key="index">
                    <div class="border rounded-lg p-4 mb-4">
                        <div class="grid grid-cols-2 gap-4 mb-3">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Dosen</label>
                                <input type="text" :name="'anggota['+index+'][nama_dosen]'" x-model="item.nama_dosen" class="w-full px-3 py-2 border rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">NIP</label>
                                <input type="text" :name="'anggota['+index+'][nip]'" x-model="item.nip" class="w-full px-3 py-2 border rounded-lg">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-3">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Fakultas</label>
                                <input type="text" :name="'anggota['+index+'][fakultas]'" x-model="item.fakultas" class="w-full px-3 py-2 border rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Prodi</label>
                                <input type="text" :name="'anggota['+index+'][prodi]'" x-model="item.prodi" class="w-full px-3 py-2 border rounded-lg">
                            </div>
                        </div>
                        <button type="button" @click="anggota.splice(index, 1)" class="text-red-600 hover:text-red-700 text-sm">
                            <i class='bx bx-trash mr-1'></i>Hapus Anggota
                        </button>
                    </div>
                </template>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.manage') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-lg hover:from-teal-600 hover:to-teal-700 shadow-md">
                    <i class='bx bx-save mr-2'></i>Update Proposal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('kata_kunci')) {
        var kataKunci = document.getElementById('kata_kunci');
        kataKunci.addEventListener('change', function() {
            var values = kataKunci.value.split(',').map(v => v.trim()).filter(v => v);
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'kata_kunci';
            input.value = JSON.stringify(values);
            kataKunci.parentNode.appendChild(input);
            kataKunci.removeAttribute('name');
        });
    }
    
    if (document.getElementById('sdgs')) {
        var sdgs = document.getElementById('sdgs');
        sdgs.addEventListener('change', function() {
            var values = sdgs.value.split(',').map(v => v.trim()).filter(v => v);
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'sdgs';
            input.value = JSON.stringify(values);
            sdgs.parentNode.appendChild(input);
            sdgs.removeAttribute('name');
        });
    }
});
</script>
@endsection
