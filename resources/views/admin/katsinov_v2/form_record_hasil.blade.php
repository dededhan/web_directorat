@extends('admin.admin')

@section('contentadmin')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Form Record Hasil Pengukuran</h1>
            <p class="text-gray-600">Dokumentasi detail hasil pengukuran dan penilaian</p>
        </div>

        {{-- Alert --}}
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('admin.katsinov-v2.form-record-hasil.store', $katsinov->id) }}" method="POST" class="bg-white shadow-lg rounded-lg p-8">
            @csrf

            <div class="space-y-6">
                {{-- Section 1: Informasi Umum --}}
                <div class="border-b pb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Umum</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Penanggung Jawab <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_penanggung_jawab" value="{{ old('nama_penanggung_jawab', $recordHasil->nama_penanggung_jawab ?? '') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('nama_penanggung_jawab')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Institusi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="institusi" value="{{ old('institusi', $recordHasil->institusi ?? $katsinov->institution) }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('institusi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Penilaian <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_penilaian" value="{{ old('tanggal_penilaian', $recordHasil->tanggal_penilaian ?? date('Y-m-d')) }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('tanggal_penilaian')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Inovasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="judul_inovasi" value="{{ old('judul_inovasi', $recordHasil->judul_inovasi ?? $katsinov->title) }}" required
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
                                <option value="Produk" {{ old('jenis_inovasi', $recordHasil->jenis_inovasi ?? '') == 'Produk' ? 'selected' : '' }}>Produk</option>
                                <option value="Proses" {{ old('jenis_inovasi', $recordHasil->jenis_inovasi ?? '') == 'Proses' ? 'selected' : '' }}>Proses</option>
                                <option value="Layanan" {{ old('jenis_inovasi', $recordHasil->jenis_inovasi ?? '') == 'Layanan' ? 'selected' : '' }}>Layanan</option>
                            </select>
                            @error('jenis_inovasi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Telepon <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="phone" value="{{ old('phone', $recordHasil->phone ?? $katsinov->contact) }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Fax (Opsional)
                            </label>
                            <input type="text" name="fax" value="{{ old('fax', $recordHasil->fax ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Kontak <span class="text-red-500">*</span>
                            </label>
                            <textarea name="alamat_kontak" rows="3" required
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('alamat_kontak', $recordHasil->alamat_kontak ?? $katsinov->address) }}</textarea>
                            @error('alamat_kontak')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Section 2: Detail Pengukuran (5 Rows) --}}
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Pengukuran</h2>
                    <p class="text-sm text-gray-600 mb-4">Isi data pengukuran untuk setiap aspek yang dinilai</p>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aspek</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktivitas</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Capaian (%)</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @for($i = 1; $i <= 5; $i++)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $i }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="text" name="aspek_{{ $i }}" value="{{ old('aspek_'.$i, $recordHasil->{'aspek_'.$i} ?? '') }}" required
                                               placeholder="Aspek {{ $i }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                        @error('aspek_'.$i)
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="text" name="aktivitas_{{ $i }}" value="{{ old('aktivitas_'.$i, $recordHasil->{'aktivitas_'.$i} ?? '') }}" required
                                               placeholder="Aktivitas"
                                               class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                        @error('aktivitas_'.$i)
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="number" name="capaian_{{ $i }}" value="{{ old('capaian_'.$i, $recordHasil->{'capaian_'.$i} ?? '') }}" required
                                               min="0" max="100"
                                               placeholder="85"
                                               class="w-20 px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                        @error('capaian_'.$i)
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="text" name="keterangan_{{ $i }}" value="{{ old('keterangan_'.$i, $recordHasil->{'keterangan_'.$i} ?? '') }}" required
                                               placeholder="Keterangan"
                                               class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                        @error('keterangan_'.$i)
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </td>
                                    <td class="px-4 py-3">
                                        <textarea name="catatan_{{ $i }}" rows="2"
                                                  placeholder="Catatan tambahan..."
                                                  class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">{{ old('catatan_'.$i, $recordHasil->{'catatan_'.$i} ?? '') }}</textarea>
                                    </td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-between mt-8 pt-6 border-t">
                <a href="{{ route('admin.katsinov-v2.show', $katsinov->id) }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Kembali
                </a>
                
                <div class="flex gap-3">
                    <button type="submit" name="save_as_draft" value="1"
                            class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Simpan Draft
                    </button>
                    
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Simpan & Selesai
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
