@extends('admin.admin')

@section('contentadmin')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Form Berita Acara Penilaian</h1>
            <p class="text-gray-600">Dokumen resmi hasil penilaian inovasi</p>
        </div>

        {{-- Alert --}}
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('admin.katsinov-v2.form-berita-acara.store', $katsinov->id) }}" method="POST" class="bg-white shadow-lg rounded-lg p-8">
            @csrf

            <div class="space-y-6">
                {{-- Section 1: Tanggal & Tempat --}}
                <div class="border-b pb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Tanggal & Tempat</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Hari <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="hari" value="{{ old('hari', $beritaAcara->hari ?? '') }}" required
                                   placeholder="Senin"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('hari')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="tanggal" value="{{ old('tanggal', $beritaAcara->tanggal ?? '') }}" required
                                   placeholder="01"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('tanggal')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Bulan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="bulan" value="{{ old('bulan', $beritaAcara->bulan ?? '') }}" required
                                   placeholder="Januari"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('bulan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tahun <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="tahun" value="{{ old('tahun', $beritaAcara->tahun ?? date('Y')) }}" required
                                   placeholder="2024"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('tahun')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Keterangan Tanggal (Opsional)
                            </label>
                            <input type="text" name="keterangan_tanggal" value="{{ old('keterangan_tanggal', $beritaAcara->keterangan_tanggal ?? '') }}"
                                   placeholder="Pukul 09.00 WIB"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tempat <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="tempat" value="{{ old('tempat', $beritaAcara->tempat ?? '') }}" required
                                   placeholder="Ruang Rapat Gedung A"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('tempat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Section 2: Dokumen & Inovasi --}}
                <div class="border-b pb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Dokumen</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Surat Keputusan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="surat_keputusan" value="{{ old('surat_keputusan', $beritaAcara->surat_keputusan ?? '') }}" required
                                   placeholder="No. SK/123/DIR/2024"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('surat_keputusan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Inovasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="judul_inovasi" value="{{ old('judul_inovasi', $beritaAcara->judul_inovasi ?? $katsinov->title) }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('judul_inovasi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Inovasi <span class="text-red-500">*</span>
                            </label>
                            <select name="jenis_inovasi" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih Jenis</option>
                                <option value="Produk" {{ old('jenis_inovasi', $beritaAcara->jenis_inovasi ?? '') == 'Produk' ? 'selected' : '' }}>Produk</option>
                                <option value="Proses" {{ old('jenis_inovasi', $beritaAcara->jenis_inovasi ?? '') == 'Proses' ? 'selected' : '' }}>Proses</option>
                                <option value="Layanan" {{ old('jenis_inovasi', $beritaAcara->jenis_inovasi ?? '') == 'Layanan' ? 'selected' : '' }}>Layanan</option>
                            </select>
                            @error('jenis_inovasi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nilai TKI <span class="text-red-500">*</span>
                            </label>
                            <input type="number" step="0.01" name="nilai_tki" value="{{ old('nilai_tki', $beritaAcara->nilai_tki ?? '') }}" required
                                   placeholder="85.50"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('nilai_tki')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Section 3: Opini & Penutupan --}}
                <div class="border-b pb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Hasil Penilaian</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Opini Penilai <span class="text-red-500">*</span>
                            </label>
                            <textarea name="opini_penilai" rows="6" required
                                      placeholder="Tuliskan opini dan rekomendasi penilai terhadap inovasi ini..."
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('opini_penilai', $beritaAcara->opini_penilai ?? '') }}</textarea>
                            @error('opini_penilai')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Penutupan <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_penutupan" value="{{ old('tanggal_penutupan', $beritaAcara->tanggal_penutupan ?? date('Y-m-d')) }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('tanggal_penutupan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Section 4: Tim Penilai --}}
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Tim Penilai</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Penanggung Jawab <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_penanggungjawab" value="{{ old('nama_penanggungjawab', $beritaAcara->nama_penanggungjawab ?? '') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('nama_penanggungjawab')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Ketua Tim <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_ketua_tim" value="{{ old('nama_ketua_tim', $beritaAcara->nama_ketua_tim ?? '') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('nama_ketua_tim')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Anggota 1 <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_anggota1" value="{{ old('nama_anggota1', $beritaAcara->nama_anggota1 ?? '') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('nama_anggota1')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Anggota 2 <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_anggota2" value="{{ old('nama_anggota2', $beritaAcara->nama_anggota2 ?? '') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('nama_anggota2')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-between mt-8 pt-6 border-t">
                <a href="{{ route('admin.katsinov-v2.show', $katsinov->id) }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Kembali
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Simpan Berita Acara
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
