@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="{ 
    anggota: {{ json_encode($proposal->anggota->map(function($a) { 
        return ['nama_dosen' => $a->nama_dosen, 'nip' => $a->nip, 'fakultas' => $a->fakultas, 'prodi' => $a->prodi]; 
    })->toArray()) }},
    publikasiMediaMassa: '{{ old('publikasi_media_massa', $proposal->publikasi_media_massa ?? '') }}',
    hkiStatus: '{{ old('hki', $proposal->hki ?? '') }}'
}">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb dan Header --}}
        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}" class="hover:text-teal-600 transition-colors duration-200">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.manage') }}" class="hover:text-teal-600 transition-colors duration-200">Hibah Modul Ajar</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.show', $proposal->id) }}" class="hover:text-teal-600 transition-colors duration-200">Detail Proposal</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Edit Proposal</li>
                </ol>
            </nav>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Edit Proposal Modul Ajar</h1>
                    <p class="mt-2 text-gray-600 text-base">Sesi: <span class="font-semibold text-teal-600">{{ $proposal->sesi->nama_sesi }}</span></p>
                </div>
                <a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.show', $proposal->id) }}" class="inline-flex items-center px-4 py-2.5 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                    <i class='bx bx-arrow-back mr-2 text-lg'></i>
                    Kembali
                </a>
            </div>
        </header>

        {{-- Alert Messages --}}
        @if($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm" role="alert">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class='bx bx-error-circle text-red-400 text-xl'></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-red-800">Terdapat Kesalahan</h3>
                    <ul class="list-disc list-inside text-sm text-red-700 mt-1">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('subdirektorat-inovasi.dosen.hibah_modul.update', $proposal->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            @csrf
            @method('PUT')

            {{-- Form Header --}}
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-5">
                <h2 class="text-xl lg:text-2xl font-bold text-white flex items-center">
                    <i class='bx bx-edit mr-3 text-2xl'></i>
                    Edit Formulir Proposal
                </h2>
            </div>

            {{-- Form Content --}}
            <div class="p-6 lg:p-8 space-y-6">
                {{-- Informasi Modul Section --}}
                <div class="space-y-5">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center border-b pb-3">
                        <i class='bx bx-book-content text-teal-600 mr-2 text-xl'></i>
                        Informasi Modul
                    </h3>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Judul Modul <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="judul_modul" value="{{ old('judul_modul', $proposal->judul_modul) }}" required 
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all"
                               placeholder="Masukkan judul modul ajar">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Ringkasan Modul <span class="text-red-500">*</span>
                        </label>
                        <textarea name="ringkasan_modul" rows="6" required 
                                  class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all"
                                  placeholder="Tuliskan ringkasan modul ajar Anda (maksimal 300 kata)">{{ old('ringkasan_modul', $proposal->ringkasan_modul) }}</textarea>
                        <p class="text-xs text-gray-500 mt-2 flex items-center">
                            <i class='bx bx-info-circle mr-1'></i>
                            Maksimal 300 kata
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kata Kunci
                        </label>
                        <input type="text" name="kata_kunci" id="kata_kunci" value="{{ old('kata_kunci', is_array($proposal->kata_kunci) ? implode(', ', $proposal->kata_kunci) : '') }}" 
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all"
                               placeholder="pembelajaran, inovatif, digital">
                        <p class="text-xs text-gray-500 mt-2">Pisahkan dengan koma</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            SDGs Fokus (4, 5, 11, 17)
                        </label>
                        <input type="text" name="sdgs_fokus" id="sdgs_fokus" value="{{ old('sdgs_fokus', is_array($proposal->sdgs_fokus ?? null) ? implode(', ', $proposal->sdgs_fokus) : '') }}" 
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all"
                               placeholder="SDG 4, SDG 5, SDG 11, SDG 17">
                        <p class="text-xs text-gray-500 mt-2">Pisahkan dengan koma</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            SDGs Pendukung
                        </label>
                        <input type="text" name="sdgs_pendukung" id="sdgs_pendukung" value="{{ old('sdgs_pendukung', is_array($proposal->sdgs_pendukung ?? null) ? implode(', ', $proposal->sdgs_pendukung) : '') }}" 
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all"
                               placeholder="SDG 1, SDG 2, SDG 3, dll">
                        <p class="text-xs text-gray-500 mt-2">Pisahkan dengan koma</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Tahun Usulan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="tahun_usulan" value="{{ old('tahun_usulan', $proposal->tahun_usulan ?? '') }}" required
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all"
                                   placeholder="Contoh: 2025">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Tahun Pelaksanaan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="tahun_pelaksanaan" value="{{ old('tahun_pelaksanaan', $proposal->tahun_pelaksanaan ?? '') }}" required
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all"
                                   placeholder="Contoh: 2025">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Tempat Pelaksanaan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="tempat_pelaksanaan" value="{{ old('tempat_pelaksanaan', $proposal->tempat_pelaksanaan ?? '') }}" required
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all"
                               placeholder="Masukkan tempat pelaksanaan">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Anggaran Usulan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                            <input type="text" name="anggaran_usulan" value="{{ old('anggaran_usulan', number_format($proposal->anggaran_usulan ?? 0, 0, ',', '.')) }}" required
                                   class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all"
                                   placeholder="0">
                        </div>
                        <p class="text-xs text-gray-500 mt-2"><i class='bx bx-info-circle mr-1'></i>Masukkan anggaran dalam Rupiah</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Platform Digital yang Digunakan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="platform_digital" value="{{ old('platform_digital', $proposal->platform_digital ?? '') }}" required
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all"
                               placeholder="Contoh: Moodle, Google Classroom, dll">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Mitra (Opsional)
                        </label>
                        <input type="text" name="mitra" value="{{ old('mitra', $proposal->mitra ?? '') }}"
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all"
                               placeholder="Masukkan nama mitra jika ada">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Modul Interdisiplin Digital <span class="text-red-500">*</span>
                            </label>
                            <select name="modul_interdisiplin" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all">
                                <option value="">-- Pilih --</option>
                                <option value="Ada" {{ old('modul_interdisiplin', $proposal->modul_interdisiplin ?? '') == 'Ada' ? 'selected' : '' }}>Ada</option>
                                <option value="Draft" {{ old('modul_interdisiplin', $proposal->modul_interdisiplin ?? '') == 'Draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Publikasi Media Massa <span class="text-red-500">*</span>
                            </label>
                            <select name="publikasi_media_massa" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all" x-model="publikasiMediaMassa">
                                <option value="">-- Pilih --</option>
                                <option value="Ada" {{ old('publikasi_media_massa', $proposal->publikasi_media_massa ?? '') == 'Ada' ? 'selected' : '' }}>Ada</option>
                                <option value="Draft" {{ old('publikasi_media_massa', $proposal->publikasi_media_massa ?? '') == 'Draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                HKI <span class="text-red-500">*</span>
                            </label>
                            <select name="hki" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all" x-model="hkiStatus">
                                <option value="">-- Pilih --</option>
                                <option value="Ada" {{ old('hki', $proposal->hki ?? '') == 'Ada' ? 'selected' : '' }}>Ada</option>
                                <option value="Draft" {{ old('hki', $proposal->hki ?? '') == 'Draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                    </div>

                    <div x-show="publikasiMediaMassa === 'Ada' || publikasiMediaMassa === 'Draft'" x-transition>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Media Massa <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_media_massa" value="{{ old('nama_media_massa', $proposal->nama_media_massa ?? '') }}"
                               :required="publikasiMediaMassa === 'Ada' || publikasiMediaMassa === 'Draft'"
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all"
                               placeholder="Masukkan nama media massa">
                    </div>

                    <div x-show="hkiStatus === 'Ada' || hkiStatus === 'Draft'" x-transition>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Jenis HKI dan Judul <span class="text-red-500">*</span>
                        </label>
                        <textarea name="jenis_hki_dan_judul" rows="3" :required="hkiStatus === 'Ada' || hkiStatus === 'Draft'"
                                  class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all"
                                  placeholder="Contoh: Hak Cipta - Modul Pembelajaran Inovatif">{{ old('jenis_hki_dan_judul', $proposal->jenis_hki_dan_judul ?? '') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            File Proposal (PDF)
                        </label>
                        @if($proposal->file_proposal)
                        <div class="mb-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <a href="{{ Storage::url($proposal->file_proposal) }}" target="_blank" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center">
                                <i class='bx bx-file-blank mr-2 text-lg'></i>
                                Lihat file saat ini
                            </a>
                        </div>
                        @endif
                        <div class="relative">
                            <input type="file" name="file_proposal" accept=".pdf" 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        </div>
                        <p class="text-xs text-gray-500 mt-2 flex items-center">
                            <i class='bx bx-info-circle mr-1'></i>
                            Kosongkan jika tidak ingin mengubah file (Maksimal 10MB, format PDF)
                        </p>
                    </div>
                </div>

                {{-- Anggota Penyusun Section --}}
                <div class="space-y-5">
                    <div class="flex items-center justify-between border-b pb-3">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class='bx bx-group text-teal-600 mr-2 text-xl'></i>
                            Anggota Penyusun
                        </h3>
                        <button type="button" @click="anggota.push({ nama_dosen: '', nip: '', fakultas: '', prodi: '' })" 
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-all shadow-sm">
                            <i class='bx bx-plus mr-2'></i>Tambah Anggota
                        </button>
                    </div>

                    <template x-for="(item, index) in anggota" :key="index">
                        <div class="bg-gray-50 border-2 border-gray-200 rounded-xl p-5">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="font-semibold text-gray-700 flex items-center">
                                    <i class='bx bx-user text-blue-500 mr-2'></i>
                                    Anggota <span x-text="index + 1" class="ml-1"></span>
                                </h4>
                                <button type="button" @click="anggota.splice(index, 1)" 
                                        class="text-red-600 hover:text-red-700 text-sm font-medium flex items-center hover:bg-red-50 px-3 py-1 rounded-lg transition-all">
                                    <i class='bx bx-trash mr-1'></i>Hapus
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Dosen</label>
                                    <input type="text" :name="'anggota['+index+'][nama_dosen]'" x-model="item.nama_dosen" 
                                           class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all"
                                           placeholder="Nama lengkap dosen">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">NIP</label>
                                    <input type="text" :name="'anggota['+index+'][nip]'" x-model="item.nip" 
                                           class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all"
                                           placeholder="Nomor Induk Pegawai">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Fakultas</label>
                                    <input type="text" :name="'anggota['+index+'][fakultas]'" x-model="item.fakultas" 
                                           class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all"
                                           placeholder="Nama fakultas">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Prodi</label>
                                    <input type="text" :name="'anggota['+index+'][prodi]'" x-model="item.prodi" 
                                           class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all"
                                           placeholder="Program studi">
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="px-6 lg:px-8 py-5 bg-gray-50 border-t-2 border-gray-100">
                <div class="flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.show', $proposal->id) }}" class="w-full sm:w-auto px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-100 hover:border-gray-400 transition-all text-center">
                        <i class='bx bx-x mr-2'></i>Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class='bx bx-save mr-2'></i>Perbarui Proposal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Kata Kunci
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
    
    // SDGs Fokus
    if (document.getElementById('sdgs_fokus')) {
        var sdgsFokus = document.getElementById('sdgs_fokus');
        sdgsFokus.addEventListener('change', function() {
            var values = sdgsFokus.value.split(',').map(v => v.trim()).filter(v => v);
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'sdgs_fokus';
            input.value = JSON.stringify(values);
            sdgsFokus.parentNode.appendChild(input);
            sdgsFokus.removeAttribute('name');
        });
    }
    
    // SDGs Pendukung
    if (document.getElementById('sdgs_pendukung')) {
        var sdgsPendukung = document.getElementById('sdgs_pendukung');
        sdgsPendukung.addEventListener('change', function() {
            var values = sdgsPendukung.value.split(',').map(v => v.trim()).filter(v => v);
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'sdgs_pendukung';
            input.value = JSON.stringify(values);
            sdgsPendukung.parentNode.appendChild(input);
            sdgsPendukung.removeAttribute('name');
        });
    }
});
</script>
@endsection
