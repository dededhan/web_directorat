@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="presentingForm()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}"
                            class="hover:text-teal-600 transition-colors duration-200">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.presenting.list-sesi') }}"
                            class="hover:text-teal-600 transition-colors duration-200">Bantuan Presentasi</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Formulir Edit Pengajuan</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Formulir Edit Pengajuan Bantuan Presentasi</h1>
                    <p class="mt-2 text-gray-600 text-base">Anda mengajukan untuk sesi: <strong class="text-teal-700">{{ $session->nama_sesi }}</strong></p>
                </div>
            </div>
        </header>

        @if (session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm" role="alert">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class='bx bx-error-circle text-red-400 text-xl'></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800">Terjadi Kesalahan</h3>
                        <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm" role="alert">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class='bx bx-error-circle text-red-400 text-xl'></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800">Terjadi Kesalahan</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('subdirektorat-inovasi.dosen.presenting.update', $report->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            {{-- Informasi Conference --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                    <div class="flex items-center text-white">
                        <i class='bx bx-calendar-event text-2xl mr-3'></i>
                        <h2 class="text-xl lg:text-2xl font-bold">Informasi Conference</h2>
                    </div>
                </div>

                <div class="p-6 lg:p-8 space-y-6">
                    <div>
                        <label for="nama_conference" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-file-blank text-blue-500 mr-2'></i>
                            Nama Conference <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="text" name="nama_conference" id="nama_conference" required 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                               placeholder="Masukkan nama conference"
                               value="{{ old('nama_conference', $report->nama_conference ?? '') }}">
                        @error('nama_conference')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="penyelenggaraan_ke" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-hash text-purple-500 mr-2'></i>
                            Penyelenggaraan yang ke- <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="number" name="penyelenggaraan_ke" id="penyelenggaraan_ke" required min="1"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                               placeholder="Contoh: 1, 2, 3, dst"
                               value="{{ old('penyelenggaraan_ke', $report->penyelenggaraan_ke ?? '') }}">
                        @error('penyelenggaraan_ke')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="lembaga_penyelenggara" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-buildings text-green-500 mr-2'></i>
                            Lembaga Penyelenggara <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="text" name="lembaga_penyelenggara" id="lembaga_penyelenggara" required 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                               placeholder="Masukkan lembaga penyelenggara"
                               value="{{ old('lembaga_penyelenggara', $report->lembaga_penyelenggara ?? '') }}">
                        @error('lembaga_penyelenggara')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="link_website" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-link text-blue-500 mr-2'></i>
                            Link Website Conference <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="url" name="link_website" id="link_website" required 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                               placeholder="https://..."
                               value="{{ old('link_website', $report->link_website ?? '') }}">
                        @error('link_website')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="tempat_pelaksanaan" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i class='bx bx-map text-orange-500 mr-2'></i>
                                Tempat Pelaksanaan (Kota) <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="text" name="tempat_pelaksanaan" id="tempat_pelaksanaan" required 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                                   placeholder="Contoh: Jakarta"
                                   value="{{ old('tempat_pelaksanaan', $report->tempat_pelaksanaan ?? '') }}">
                            @error('tempat_pelaksanaan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="negara_pelaksanaan" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i class='bx bx-world text-indigo-500 mr-2'></i>
                                Negara Tempat Pelaksanaan <span class="text-red-500 ml-1">*</span>
                            </label>
                            <select name="negara_pelaksanaan" id="negara_pelaksanaan" required x-model="selectedCountry"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 shadow-sm">
                                <option value="">Pilih Negara...</option>
                            </select>
                            @error('negara_pelaksanaan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-calendar text-purple-500 mr-2'></i>
                            Waktu Pelaksanaan <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="waktu_pelaksanaan_awal" class="block text-xs text-gray-500 mb-1">Dari</label>
                                <input type="date" name="waktu_pelaksanaan_awal" id="waktu_pelaksanaan_awal" required 
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 shadow-sm"
                                       value="{{ old('waktu_pelaksanaan_awal') }}">
                            </div>
                            <div>
                                <label for="waktu_pelaksanaan_akhir" class="block text-xs text-gray-500 mb-1">Sampai</label>
                                <input type="date" name="waktu_pelaksanaan_akhir" id="waktu_pelaksanaan_akhir" required 
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 shadow-sm"
                                       value="{{ old('waktu_pelaksanaan_akhir') }}">
                            </div>
                        </div>
                        @error('waktu_pelaksanaan_awal')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        @error('waktu_pelaksanaan_akhir')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Informasi Artikel & SDG --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 lg:px-8 py-6">
                    <div class="flex items-center text-white">
                        <i class='bx bx-book-open text-2xl mr-3'></i>
                        <h2 class="text-xl lg:text-2xl font-bold">Informasi Artikel & SDG</h2>
                    </div>
                </div>

                <div class="p-6 lg:p-8 space-y-6">
                    <div>
                        <label for="judul_artikel" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-file-blank text-blue-500 mr-2'></i>
                            Judul Artikel yang Dipresentasikan <span class="text-red-500 ml-1">*</span>
                        </label>
                        <textarea name="judul_artikel" id="judul_artikel" required rows="3"
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                                  placeholder="Masukkan judul artikel">{{ old('judul_artikel', $report->judul_artikel ?? '') }}</textarea>
                        @error('judul_artikel')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                            <i class='bx bx-target-lock text-green-500 mr-2'></i>
                            SDG(s) yang Terkait dengan Konferensi <span class="text-red-500 ml-1">*</span> <span class="text-xs text-gray-500 ml-2">(Pilih minimal 1)</span>
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @php
                                $existingSDGs = json_decode($report->sdg_terkait ?? '[]', true);
                            @endphp
                            @for($i = 1; $i <= 16; $i++)
                                <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg hover:border-teal-500 transition-all cursor-pointer">
                                    <input type="checkbox" name="sdg_terkait[]" value="SDG-{{ $i }}" 
                                           @change="updateKeywords()"
                                           x-model="selectedSDGs"
                                           {{ in_array('SDG-' . $i, $existingSDGs) ? 'checked' : '' }}
                                           class="w-5 h-5 text-teal-600 border-gray-300 rounded focus:ring-teal-500">
                                    <span class="ml-2 text-sm font-medium text-gray-700">SDG-{{ $i }}</span>
                                </label>
                            @endfor
                        </div>
                        @error('sdg_terkait')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div x-show="selectedSDGs.length > 0" x-transition>
                        <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                            <i class='bx bx-key text-orange-500 mr-2'></i>
                            Keywords SDG <span class="text-red-500 ml-1">*</span> <span class="text-xs text-gray-500 ml-2">(Pilih minimal 1)</span>
                        </label>
                        <div class="max-h-96 overflow-y-auto border-2 border-gray-200 rounded-xl p-4 space-y-4">
                            <template x-for="sdg in selectedSDGs" :key="sdg">
                                <div>
                                    <h4 class="font-bold text-sm text-teal-700 mb-2" x-text="sdg"></h4>
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="keyword in sdgKeywords[sdg]" :key="keyword">
                                            <label class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-full hover:border-teal-500 hover:bg-teal-50 transition-all cursor-pointer">
                                                <input type="checkbox" name="keywords_sdg[]" :value="keyword"
                                                       :checked="selectedKeywords.includes(keyword)"
                                                       class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500">
                                                <span class="ml-2 text-xs text-gray-700" x-text="keyword"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                        @error('keywords_sdg')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Dokumen Pendukung --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 lg:px-8 py-6">
                    <div class="flex items-center text-white">
                        <i class='bx bx-file text-2xl mr-3'></i>
                        <h2 class="text-xl lg:text-2xl font-bold">Dokumen Pendukung</h2>
                    </div>
                </div>

                <div class="p-6 lg:p-8 space-y-6">
                    <div>
                        <label for="bukti_pendaftaran" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-file-blank text-blue-500 mr-2'></i>
                            Bukti Pendaftaran/Registrasi @if(!$report->bukti_pendaftaran_path)<span class="text-red-500 ml-1">*</span>@endif
                        </label>
                        @if($report->bukti_pendaftaran_path)
                            <div class="mb-2 p-2 bg-green-50 border border-green-200 rounded-lg text-sm">
                                <a href="{{ asset('storage/' . $report->bukti_pendaftaran_path) }}" target="_blank" class="text-green-700 hover:underline flex items-center">
                                    <i class='bx bx-file-blank mr-2'></i>
                                    Lihat file yang sudah diunggah
                                </a>
                            </div>
                        @endif
                        <input type="file" name="bukti_pendaftaran" id="bukti_pendaftaran" accept=".pdf"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 shadow-sm">
                        <p class="text-xs text-gray-500 mt-1">Format: PDF (Max: 10MB)</p>
                        @error('bukti_pendaftaran')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="bukti_loa" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-file-blank text-purple-500 mr-2'></i>
                            Bukti LoA (Letter of Acceptance) @if(!$report->bukti_loa_path)<span class="text-red-500 ml-1">*</span>@endif
                        </label>
                        @if($report->bukti_loa_path)
                            <div class="mb-2 p-2 bg-green-50 border border-green-200 rounded-lg text-sm">
                                <a href="{{ asset('storage/' . $report->bukti_loa_path) }}" target="_blank" class="text-green-700 hover:underline flex items-center">
                                    <i class='bx bx-file-blank mr-2'></i>
                                    Lihat file yang sudah diunggah
                                </a>
                            </div>
                        @endif
                        <input type="file" name="bukti_loa" id="bukti_loa" accept=".pdf"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 shadow-sm">
                        <p class="text-xs text-gray-500 mt-1">Format: PDF (Max: 10MB)</p>
                        @error('bukti_loa')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="rencana_anggaran" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-file-blank text-green-500 mr-2'></i>
                            Rencana Anggaran (Mengacu pada SBM) @if(!$report->rencana_anggaran)<span class="text-red-500 ml-1">*</span>@endif
                        </label>
                        @if($report->rencana_anggaran)
                            <div class="mb-2 p-2 bg-green-50 border border-green-200 rounded-lg text-sm">
                                <a href="{{ asset('storage/' . $report->rencana_anggaran) }}" target="_blank" class="text-green-700 hover:underline flex items-center">
                                    <i class='bx bx-file-blank mr-2'></i>
                                    Lihat file yang sudah diunggah
                                </a>
                            </div>
                        @endif
                        <input type="file" name="rencana_anggaran" id="rencana_anggaran" accept=".pdf"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 shadow-sm">
                        <p class="text-xs text-gray-500 mt-1">Format: PDF (Max: 10MB)</p>
                        @error('rencana_anggaran')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('subdirektorat-inovasi.dosen.presenting.manajemen') }}" 
                   class="px-6 py-2.5 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300 transition-all duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md">
                    <i class='bx bx-save text-lg mr-2'></i> Update Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function presentingForm() {
    return {
        selectedSDGs: @json(json_decode($report->sdg_terkait ?? '[]', true)),
        selectedKeywords: @json(json_decode($report->keywords_sdg ?? '[]', true)),
        selectedCountry: '{{ old("negara_pelaksanaan", $report->negara_pelaksanaan ?? "") }}',
        sdgKeywords: @json(config('sdg.keywords')),
        
        init() {
            this.loadCountries();
        },
        
        async loadCountries() {
            try {
                const response = await fetch('/api/countries');
                const countries = await response.json();
                const select = document.getElementById('negara_pelaksanaan');
                countries.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.name;
                    option.textContent = country.name;
                    if (country.name === this.selectedCountry) {
                        option.selected = true;
                    }
                    select.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading countries:', error);
            }
        },
        
        updateKeywords() {
        }
    }
}
</script>
@endsection
