@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8"
     x-data="formIdentitasData()">

    {{-- Header --}}
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Formulir Usulan: Identitas Tim</h1>
            <p class="text-gray-600 mt-1">Anda mengajukan proposal untuk sesi: <span class="font-semibold text-sky-700">{{ $sesi->nama_sesi }}</span></p>
        </div>
        <a href="{{ route('subdirektorat-inovasi.dosen.equity.usulkan-proposal.index') }}" class="btn-secondary-outline">
            <i class='bx bx-arrow-back mr-2'></i><span>Kembali ke Daftar Skema</span>
        </a>
    </div>

    {{-- Notifikasi Error Validasi --}}
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
            <p class="font-bold">Terjadi Kesalahan</p>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('subdirektorat-inovasi.dosen.equity.proposal.storeIdentitas', $sesi->id) }}">
        @csrf

        {{-- Bagian Ketua Tim --}}
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 mb-8">
            <div class="p-6 md:p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Ketua Tim Pengusul</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="ketua_nama" class="form-label">Nama Lengkap</label>
                        <input id="ketua_nama" name="ketua[nama_lengkap]" value="{{ old('ketua.nama_lengkap', $currentUser->name) }}" class="form-input" readonly type="text">
                    </div>
                    <div>
                        <label for="ketua_nip" class="form-label">NIP</label>
                        <input id="ketua_nip" name="ketua[nik_nim_nip]" value="{{ old('ketua.nik_nim_nip', $currentUser->nip ?? '') }}" class="form-input @error('ketua.nik_nim_nip') border-red-500 @enderror" placeholder="Masukkan NIP Anda" type="text">
                        @error('ketua.nik_nim_nip') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="form-label">Alamat Jalan</label>
                        <input name="ketua[alamat_jalan]" value="{{ old('ketua.alamat_jalan') }}" class="form-input @error('ketua.alamat_jalan') border-red-500 @enderror" placeholder="Contoh: Jl. Rawamangun Muka No. 1" type="text">
                        @error('ketua.alamat_jalan') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="form-label">Provinsi</label>
                        <select name="ketua[provinsi]" x-model="ketua.provinsi" @change="ketua.kota = ''; ketua.kecamatan = ''; ketua.kelurahan = ''" class="form-input">
                            <option value="">Pilih Provinsi</option>
                            <template x-for="prov in Object.keys(regions)" :key="prov"><option :value="prov" x-text="prov"></option></template>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Kota/Kabupaten</label>
                        <select name="ketua[kota_kabupaten]" x-model="ketua.kota" @change="ketua.kecamatan = ''; ketua.kelurahan = ''" class="form-input" :disabled="!ketua.provinsi">
                            <option value="">Pilih Kota/Kabupaten</option>
                            <template x-if="ketua.provinsi"><template x-for="kota in Object.keys(regions[ketua.provinsi])" :key="kota"><option :value="kota" x-text="kota"></option></template></template>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Kecamatan</label>
                        <select name="ketua[kecamatan]" x-model="ketua.kecamatan" @change="ketua.kelurahan = ''" class="form-input" :disabled="!ketua.kota">
                             <option value="">Pilih Kecamatan</option>
                             <template x-if="ketua.kota"><template x-for="kec in Object.keys(regions[ketua.provinsi][ketua.kota])" :key="kec"><option :value="kec" x-text="kec"></option></template></template>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Kelurahan</label>
                        <select name="ketua[kelurahan]" x-model="ketua.kelurahan" class="form-input" :disabled="!ketua.kecamatan">
                            <option value="">Pilih Kelurahan</option>
                            <template x-if="ketua.kecamatan"><template x-for="kel in regions[ketua.provinsi][ketua.kota][ketua.kecamatan]" :key="kel"><option :value="kel" x-text="kel"></option></template></template>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="form-label">Kode Pos</label>
                        <input name="ketua[kode_pos]" value="{{ old('ketua.kode_pos') }}" class="form-input" placeholder="Masukkan Kode Pos" type="text">
                    </div>
                </div>
            </div>
        </div>

        {{-- Bagian Anggota Tim --}}
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Anggota Tim Pengusul</h2>
            <button type="button" @click="addAnggota" x-show="anggota.length < maxAnggota" class="btn-primary-outline text-sm">
                <i class='bx bx-user-plus mr-2'></i><span>Tambah Anggota</span>
            </button>
        </div>
        <div class="space-y-6">
            <template x-for="(item, index) in anggota" :key="index">
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 relative animate-fade-in">
                    <div class="p-6 md:p-8">
                        <button type="button" @click="removeAnggota(index)" x-show="anggota.length > minAnggota" class="absolute top-4 right-4 text-gray-400 hover:text-red-500"><i class='bx bx-trash text-xl'></i></button>
                        <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-4" x-text="'Anggota ' + (index + 1)"></h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div><label class="form-label">Nama Lengkap</label><input type="text" :name="`anggota[${index}][nama_lengkap]`" x-model="item.nama_lengkap" class="form-input"></div>
                            <div><label class="form-label">NIK/NIM/NIP</label><input type="text" :name="`anggota[${index}][nik_nim_nip]`" x-model="item.nik_nim_nip" class="form-input"></div>
                            <div class="md:col-span-2"><label class="form-label">Alamat Jalan</label><input type="text" :name="`anggota[${index}][alamat_jalan]`" x-model="item.alamat_jalan" class="form-input"></div>
                            <div><label class="form-label">Provinsi</label><select :name="`anggota[${index}][provinsi]`" x-model="item.provinsi" @change="item.kota = ''; item.kecamatan = ''; item.kelurahan = ''" class="form-input"><option value="">Pilih Provinsi</option><template x-for="prov in Object.keys(regions)" :key="prov"><option :value="prov" x-text="prov"></option></template></select></div>
                            <div><label class="form-label">Kota/Kabupaten</label><select :name="`anggota[${index}][kota_kabupaten]`" x-model="item.kota" @change="item.kecamatan = ''; item.kelurahan = ''" class="form-input" :disabled="!item.provinsi"><option value="">Pilih Kota/Kabupaten</option><template x-if="item.provinsi"><template x-for="kota in Object.keys(regions[item.provinsi])" :key="kota"><option :value="kota" x-text="kota"></option></template></template></select></div>
                            <div><label class="form-label">Kecamatan</label><select :name="`anggota[${index}][kecamatan]`" x-model="item.kecamatan" @change="item.kelurahan = ''" class="form-input" :disabled="!item.kota"><option value="">Pilih Kecamatan</option><template x-if="item.kota"><template x-for="kec in Object.keys(regions[item.provinsi][item.kota])" :key="kec"><option :value="kec" x-text="kec"></option></template></template></select></div>
                            <div><label class="form-label">Kelurahan</label><select :name="`anggota[${index}][kelurahan]`" x-model="item.kelurahan" class="form-input" :disabled="!item.kecamatan"><option value="">Pilih Kelurahan</option><template x-if="item.kecamatan"><template x-for="kel in regions[item.provinsi][item.kota][item.kecamatan]" :key="kel"><option :value="kel" x-text="kel"></option></template></template></select></div>
                            <div class="md:col-span-2"><label class="form-label">Kode Pos</label><input type="text" :name="`anggota[${index}][kode_pos]`" x-model="item.kode_pos" class="form-input"></div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        
         <div class="mt-8 pt-6 border-t border-slate-200 flex items-center justify-end gap-3">
            <a href="{{ route('subdirektorat-inovasi.dosen.equity.usulkan-proposal.index') }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">Simpan dan Lanjutkan <i class='bx bx-chevron-right ml-1'></i></button>
        </div>
    </form>
</div>

@push('styles')
<style>
    .form-label { @apply block text-sm font-medium text-gray-700 mb-1; }
    .form-input { @apply w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all disabled:bg-gray-200 disabled:cursor-not-allowed; }
    .form-error { @apply text-red-500 text-xs mt-1; }
    .btn-primary { @apply inline-flex items-center px-5 py-2.5 bg-sky-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-sky-700 transition-all; }
    .btn-secondary { @apply px-5 py-2.5 bg-white border border-gray-300 text-gray-800 text-sm font-semibold rounded-lg hover:bg-gray-100 transition-all shadow-sm; }
    .btn-primary-outline { @apply inline-flex items-center px-4 py-2 bg-sky-50 text-sky-700 border border-sky-200 rounded-lg hover:bg-sky-100 transition-colors; }
    .btn-secondary-outline { @apply inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg shadow-sm hover:bg-gray-50 transition-colors; }
    @keyframes fade-in { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fade-in 0.3s ease-out forwards; }
</style>
@endpush

@push('scripts')
<script>
    function formIdentitasData() {
        return {
            ketua: { 
                provinsi: '{{ old('ketua.provinsi') }}', 
                kota: '{{ old('ketua.kota_kabupaten') }}', 
                kecamatan: '{{ old('ketua.kecamatan') }}', 
                kelurahan: '{{ old('ketua.kelurahan') }}'
            },
            anggota: @json(old('anggota', [])),
            regions: {
                'Banten': { 'Kota Serang': { 'Serang': ['Cipare', 'Cimuncang'], 'Taktakan': ['Pancur', 'Sayar'] }, 'Kota Tangerang': { 'Cipondoh': ['Cipondoh', 'Poris Plawad'], 'Karawaci': ['Karawaci', 'Nambo Jaya'] } },
                'DKI Jakarta': { 'Jakarta Pusat': { 'Gambir': ['Gambir', 'Cideng'], 'Tanah Abang': ['Bendungan Hilir', 'Karet Tengsin'] } },
                'Jawa Barat': { 'Kota Bandung': { 'Coblong': ['Dago', 'Sekeloa'], 'Sukasari': ['Gegerkalong', 'Sarijadi'] } }
            },
            minAnggota: {{ $sesi->min_anggota > 1 ? $sesi->min_anggota - 1 : 0 }},
            maxAnggota: {{ $sesi->max_anggota > 1 ? $sesi->max_anggota - 1 : 0 }},
            
            addAnggota() {
                if (this.anggota.length < this.maxAnggota) {
                    this.anggota.push({ nama_lengkap: '', nik_nim_nip: '', alamat_jalan: '', provinsi: '', kota: '', kecamatan: '', kelurahan: '', kode_pos: '' });
                }
            },
            removeAnggota(index) { this.anggota.splice(index, 1); },
            
            init() {
                if (@json(old('anggota')) === null && this.anggota.length === 0 && this.minAnggota > 0) {
                    for (let i = 0; i < this.minAnggota; i++) {
                        this.addAnggota();
                    }
                }
            }
        }
    }
</script>
@endpush