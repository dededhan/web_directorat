@extends('subdirektorat-inovasi.dosen.index')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.css" rel="stylesheet">
    <style>
        .ts-control {
            padding: 0.75rem 1rem !important;
            border-radius: 0.5rem !important;
        }

        .file-input-style {
            @apply w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100;
        }

        input:focus,
        select:focus,
        button:focus {
            box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
        }

        button:hover {
            transform: translateY(-1px);
        }

        .bg-white:hover {
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 10px 10px -5px rgb(0 0 0 / 0.04);
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="matchmakingForm()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Breadcrumb dan Judul Halaman --}}
            <header class="mb-10">
                <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                    <ol class="list-none p-0 inline-flex items-center space-x-2">
                        <li><a href="#" class="hover:text-teal-600 transition-colors duration-200">Home</a></li>
                        <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                        <li><a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.list-sesi') }}" class="hover:text-teal-600 transition-colors duration-200">Pilih Sesi</a></li>
                        <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                        <li class="font-medium text-gray-800">Formulir Pengajuan</li>
                    </ol>
                </nav>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Formulir Pengajuan Matchmaking</h1>
                        <p class="mt-2 text-gray-600 text-base">Sesi: <strong class="text-teal-700">{{ $session->nama_sesi }}</strong></p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.list-sesi') }}"
                            class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold rounded-xl hover:from-gray-600 hover:to-gray-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class='bx bx-arrow-back mr-2 text-lg'></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </header>

            <form action="{{ route('subdirektorat-inovasi.dosen.matchresearch.store', $session->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                {{-- Judul Penelitian --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                        <div class="flex items-center text-white">
                            <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                                <i class='bx bx-text mr-3 text-2xl'></i>
                                1. Judul 
                            </h2>
                        </div>
                    </div>
                    
                    <div class="p-6 lg:p-8">
                        <div class="space-y-6">
                            <div>
                                <label for="judul_proposal" class="block text-sm font-bold text-gray-700 mb-3">
                                    <div class="flex items-center space-x-2">
                                        <i class='bx bx-file-blank text-base text-teal-500'></i>
                                        <span>Judul Kegiatan</span>
                                        <span class="text-red-500">*</span>
                                    </div>
                                </label>
                                <input type="text" 
                                       name="judul_proposal" 
                                       id="judul_proposal" 
                                       value="{{ old('judul_proposal') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200"
                                       placeholder="Masukkan judul kegiatan"
                                       required>
                                @error('judul_proposal') 
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p> 
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Anggota Peneliti --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                        <div class="flex items-center justify-between text-white">
                            <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                                <i class='bx bx-group mr-3 text-2xl'></i>
                                2. Anggota Peneliti
                            </h2>
                            <button @click="addMember" 
                                    type="button" 
                                    class="inline-flex items-center px-4 py-2 bg-white/20 text-white font-semibold rounded-xl hover:bg-white/30 transform hover:scale-105 transition-all duration-200 backdrop-blur-sm">
                                <i class='bx bx-plus mr-2 text-lg'></i> 
                                Tambah Anggota
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6 lg:p-8">
                        @error('members') 
                            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 rounded-lg">
                                <p class="text-red-700 text-sm flex items-center">
                                    <i class='bx bx-error-circle mr-2'></i>
                                    {{ $message }}
                                </p>
                            </div> 
                        @enderror

                        <div class="space-y-6">
                            <template x-for="(member, index) in members" :key="member.id">
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border-2 border-gray-200 relative overflow-hidden">
                                    {{-- Header Card --}}
                                    <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 px-6 py-4">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-lg font-semibold text-white flex items-center">
                                                <i class='bx bx-user mr-2'></i>
                                                <span x-text="`Anggota ${index + 1}`"></span>
                                            </h3>
                                            <button @click="removeMember(index)" 
                                                    type="button" 
                                                    class="p-2 text-white/80 hover:text-white hover:bg-white/20 rounded-lg transition-all">
                                                <i class='bx bx-x text-xl'></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="p-6">
                                        {{-- Tipe Anggota --}}
                                        <div class="mb-6">
                                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                                <div class="flex items-center space-x-2">
                                                    <i class='bx bx-category text-base text-purple-500'></i>
                                                    <span>Tipe Anggota</span>
                                                    <span class="text-red-500">*</span>
                                                </div>
                                            </label>
                                            <select x-model="member.type" 
                                                    :name="`members[${index}][type]`"
                                                    :id="'member_type_' + member.id" 
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200" 
                                                    required>
                                                <option value="">-- Pilih Tipe Anggota --</option>
                                                <option value="unj">Dosen UNJ</option>
                                                <option value="international">Mitra Internasional</option>
                                            </select>
                                        </div>

                                        {{-- Dosen UNJ Section --}}
                                        <div x-show="member.type === 'unj'" 
                                             x-transition:enter="transition ease-out duration-300"
                                             x-transition:enter-start="opacity-0 transform scale-95"
                                             x-transition:enter-end="opacity-100 transform scale-100"
                                             class="bg-white rounded-xl p-6 border-2 border-teal-100">
                                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                                <div class="flex items-center space-x-2">
                                                    <i class='bx bx-search text-base text-teal-500'></i>
                                                    <span>Cari Nama Dosen</span>
                                                    <span class="text-red-500">*</span>
                                                </div>
                                            </label>
                                            <select :id="'dosen_search_' + member.id" :name="`members[${index}][user_id]`" class="w-full"></select>
                                            
                                            <div x-show="member.unj_details" 
                                                 x-transition:enter="transition ease-out duration-300"
                                                 x-transition:enter-start="opacity-0 transform scale-95"
                                                 x-transition:enter-end="opacity-100 transform scale-100"
                                                 class="mt-4 p-4 bg-gradient-to-r from-teal-50 to-teal-100 border-2 border-teal-200 rounded-xl">
                                                <div class="flex items-start">
                                                    <i class='bx bx-info-circle text-teal-600 text-lg mr-3 mt-0.5'></i>
                                                    <div class="text-sm">
                                                        <h5 class="font-semibold text-teal-800 mb-2">Informasi Dosen:</h5>
                                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-teal-700">
                                                            <p><strong>NIDN/NIP:</strong> <span x-text="member.unj_details?.identifier_number || 'Tidak ada'"></span></p>
                                                            <p><strong>Fakultas:</strong> <span x-text="member.unj_details?.fakultas"></span></p>
                                                            <p class="sm:col-span-2"><strong>Program Studi:</strong> <span x-text="member.unj_details?.prodi"></span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Mitra Internasional Section --}}
                                        <div x-show="member.type === 'international'" 
                                             x-transition:enter="transition ease-out duration-300"
                                             x-transition:enter-start="opacity-0 transform scale-95"
                                             x-transition:enter-end="opacity-100 transform scale-100"
                                             class="bg-white rounded-xl p-6 border-2 border-orange-100">
                                            
                                            <div class="flex items-center mb-6 pb-4 border-b border-orange-200">
                                                <i class='bx bx-globe text-2xl text-orange-500 mr-3'></i>
                                                <h4 class="text-lg font-bold text-gray-800">Detail Mitra Internasional</h4>
                                            </div>

                                            <div class="mb-6">
                                                <label class="block text-sm font-bold text-gray-700 mb-3">
                                                    <div class="flex items-center space-x-2">
                                                        <i class='bx bx-category text-base text-orange-500'></i>
                                                        <span>Tipe Mitra</span>
                                                        <span class="text-red-500">*</span>
                                                    </div>
                                                </label>
                                                <select x-model="member.international_type" 
                                                        :name="`members[${index}][international_type]`" 
                                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                                                    <option value="">-- Pilih Tipe Mitra --</option>
                                                    <option value="h_index">H-Index Researcher</option>
                                                    <option value="editor">Editor Top Tier Journal</option>
                                                    <option value="fellow">Fellow Organization Profession</option>
                                                    <option value="academy">National Academy Member</option>
                                                </select>
                                            </div>

                                            <div x-show="member.international_type" 
                                                 x-transition:enter="transition ease-out duration-300"
                                                 x-transition:enter-start="opacity-0 transform scale-95"
                                                 x-transition:enter-end="opacity-100 transform scale-100"
                                                 class="space-y-6">
                                                
                                                {{-- Basic Info --}}
                                                <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-xl p-6 border border-orange-200">
                                                    <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
                                                        <i class='bx bx-info-circle text-orange-500 mr-2'></i>
                                                        Informasi Dasar
                                                    </h5>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                                                            <input type="text" 
                                                                   :name="`members[${index}][${member.international_type}][name]`" 
                                                                   placeholder="Nama lengkap" 
                                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all">
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-2">Instansi/Institusi</label>
                                                            <input type="text" 
                                                                   :name="`members[${index}][${member.international_type}][institution]`" 
                                                                   placeholder="Nama institusi" 
                                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all">
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-2">Negara</label>
                                                            <select :name="`members[${index}][${member.international_type}][country]`" 
                                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all">
                                                                <option value="">-- Pilih Negara --</option>
                                                                @foreach ($countries as $country)
                                                                    <option value="{{ $country['name'] }}">{{ $country['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-2">Bidang Keahlian</label>
                                                            <select :name="`members[${index}][${member.international_type}][expertise]`" 
                                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all">
                                                                <option value="">-- Bidang Keahlian --</option>
                                                                <option value="STEM">STEM</option>
                                                                <option value="Social Sciences and Humanities">Social Sciences and Humanities</option>
                                                            </select>
                                                        </div>
                                                        <div class="md:col-span-2">
                                                            <label class="block text-sm font-medium text-gray-700 mb-2">Surat Ketersediaan Mitra</label>
                                                            <div class="p-4 bg-gray-50 rounded-lg border-2 border-dashed" x-data="{ fileName: '' }">
                                                                <div class="flex items-center justify-center w-full">
                                                                    <label :for="`dropzone-file-${index}-${member.international_type}-letter`" class="flex flex-col items-center justify-center w-full h-32 rounded-lg cursor-pointer bg-gray-100 hover:bg-gray-200 transition-colors">
                                                                        <div class="flex flex-col items-center justify-center pt-5 pb-6" x-show="!fileName">
                                                                            <i class='bx bxs-cloud-upload text-4xl text-gray-400'></i>
                                                                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk mengunggah</span></p>
                                                                            <p class="text-xs text-gray-500">PDF (MAX. 5MB)</p>
                                                                        </div>
                                                                        <div class="flex flex-col items-center justify-center text-center p-4" x-show="fileName">
                                                                            <i class='bx bxs-file-pdf text-4xl text-teal-500 mb-2'></i>
                                                                            <p class="text-sm font-semibold text-gray-700 truncate" x-text="fileName"></p>
                                                                            <p class="text-xs text-gray-500 mt-1">Klik untuk mengganti file</p>
                                                                        </div>
                                                                        <input :id="`dropzone-file-${index}-${member.international_type}-letter`" type="file" class="hidden" :name="`members[${index}][${member.international_type}][partner_availability_letter]`" accept=".pdf" @change="fileName = $event.target.files.length > 0 ? $event.target.files[0].name : ''" />
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- H-Index Specific Fields --}}
                                                <template x-if="member.international_type === 'h_index'">
                                                    <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-xl p-6 border border-yellow-200">
                                                        <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
                                                            <i class='bx bx-trending-up text-yellow-600 mr-2'></i>
                                                            Link ID Scopus
                                                        </h5>
                                                        <input type="url" 
                                                               :name="`members[${index}][h_index][scopus_link]`" 
                                                               placeholder="Link ID Scopus (https://...)" 
                                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all">
                                                    </div>
                                                </template>

                                                {{-- Editor Specific Fields --}}
                                                <template x-if="member.international_type === 'editor'">
                                                    <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
                                                        <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
                                                            <i class='bx bx-book-content text-green-500 mr-2'></i>
                                                            Editor Details
                                                        </h5>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <input type="text" 
                                                                   :name="`members[${index}][editor][journal_name]`" 
                                                                   placeholder="Nama Jurnal" 
                                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                                                            <input type="url" 
                                                                   :name="`members[${index}][editor][scimago_link]`" 
                                                                   placeholder="Link Scimagojr (https://...)" 
                                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                                                        </div>
                                                    </div>
                                                </template>

                                                {{-- Fellow Specific Fields --}}
                                                <template x-if="member.international_type === 'fellow'">
                                                    <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                                                        <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
                                                            <i class='bx bx-award text-purple-500 mr-2'></i>
                                                            Fellow Organization Details
                                                        </h5>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <input type="text" 
                                                                   :name="`members[${index}][fellow][organization_name]`" 
                                                                   placeholder="Nama Organisasi" 
                                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
                                                            <input type="url" 
                                                                   :name="`members[${index}][fellow][organization_link]`" 
                                                                   placeholder="Link Organisasi (https://...)" 
                                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
                                                            <div class="md:col-span-2">
                                                                <input type="text" 
                                                                       :name="`members[${index}][fellow][membership_id]`" 
                                                                       placeholder="Nomor ID Keanggotaan" 
                                                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all mb-4">
                                                                <div>
                                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Keanggotaan</label>
                                                                    <div class="p-4 bg-gray-50 rounded-lg border-2 border-dashed" x-data="{ fileName: '' }">
                                                                        <div class="flex items-center justify-center w-full">
                                                                            <label :for="`dropzone-file-${index}-fellow-proof`" class="flex flex-col items-center justify-center w-full h-32 rounded-lg cursor-pointer bg-gray-100 hover:bg-gray-200 transition-colors">
                                                                                <div class="flex flex-col items-center justify-center pt-5 pb-6" x-show="!fileName">
                                                                                    <i class='bx bxs-cloud-upload text-4xl text-gray-400'></i>
                                                                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk mengunggah</span></p>
                                                                                    <p class="text-xs text-gray-500">PDF (MAX. 5MB)</p>
                                                                                </div>
                                                                                <div class="flex flex-col items-center justify-center text-center p-4" x-show="fileName">
                                                                                     <i class='bx bxs-file-pdf text-4xl text-teal-500 mb-2'></i>
                                                                                     <p class="text-sm font-semibold text-gray-700 truncate" x-text="fileName"></p>
                                                                                     <p class="text-xs text-gray-500 mt-1">Klik untuk mengganti file</p>
                                                                                </div>
                                                                                <input :id="`dropzone-file-${index}-fellow-proof`" type="file" class="hidden" :name="`members[${index}][fellow][membership_proof]`" accept=".pdf" @change="fileName = $event.target.files.length > 0 ? $event.target.files[0].name : ''"/>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>

                                                {{-- Academy Specific Fields --}}
                                                <template x-if="member.international_type === 'academy'">
                                                    <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-xl p-6 border border-red-200">
                                                        <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
                                                            <i class='bx bx-medal text-red-500 mr-2'></i>
                                                            National Academy Details
                                                        </h5>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <input type="text" 
                                                                   :name="`members[${index}][academy][academy_name]`" 
                                                                   placeholder="Nama National Academy" 
                                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                                                            <div>
                                                                <label class="block text-sm font-medium text-gray-700 mb-2">Rentang Tahun Keanggotaan</label>
                                                                <div class="flex items-center space-x-2">
                                                                    <input type="number" 
                                                                           :name="`members[${index}][academy][membership_year_start]`" 
                                                                           placeholder="Tahun Mulai" 
                                                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                                                                           min="1900" max="{{ date('Y') + 5 }}">
                                                                    <span class="text-gray-500 font-semibold">-</span>
                                                                    <input type="number" 
                                                                           :name="`members[${index}][academy][membership_year_end]`" 
                                                                           placeholder="Tahun Selesai" 
                                                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                                                                           min="1900" max="{{ date('Y') + 10 }}">
                                                                </div>
                                                            </div>
                                                            <div class="md:col-span-2">
                                                                <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Keanggotaan</label>
                                                                <div class="p-4 bg-gray-50 rounded-lg border-2 border-dashed" x-data="{ fileName: '' }">
                                                                    <div class="flex items-center justify-center w-full">
                                                                        <label :for="`dropzone-file-${index}-academy-proof`" class="flex flex-col items-center justify-center w-full h-32 rounded-lg cursor-pointer bg-gray-100 hover:bg-gray-200 transition-colors">
                                                                            <div class="flex flex-col items-center justify-center pt-5 pb-6" x-show="!fileName">
                                                                                <i class='bx bxs-cloud-upload text-4xl text-gray-400'></i>
                                                                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk mengunggah</span></p>
                                                                                <p class="text-xs text-gray-500">PDF (MAX. 5MB)</p>
                                                                            </div>
                                                                            <div class="flex flex-col items-center justify-center text-center p-4" x-show="fileName">
                                                                                 <i class='bx bxs-file-pdf text-4xl text-teal-500 mb-2'></i>
                                                                                 <p class="text-sm font-semibold text-gray-700 truncate" x-text="fileName"></p>
                                                                                 <p class="text-xs text-gray-500 mt-1">Klik untuk mengganti file</p>
                                                                            </div>
                                                                            <input :id="`dropzone-file-${index}-academy-proof`" type="file" class="hidden" :name="`members[${index}][academy][membership_proof]`" accept=".pdf" @change="fileName = $event.target.files.length > 0 ? $event.target.files[0].name : ''" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            {{-- Empty State --}}
                            <div x-show="members.length === 0" class="text-center py-12">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-4">
                                        <i class='bx bx-user-plus text-3xl text-gray-400'></i>
                                    </div>
                                    <h3 class="font-bold text-lg text-gray-800 mb-2">Belum Ada Anggota</h3>
                                    <p class="text-gray-500 text-sm mb-6">Tambahkan anggota peneliti untuk melanjutkan pengajuan</p>
                                    <button @click="addMember" 
                                            type="button" 
                                            class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                        <i class='bx bx-plus mr-2 text-lg'></i>
                                        Tambah Anggota Pertama
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 lg:p-8">
                    <div class="flex flex-col sm:flex-row justify-end gap-4">
                        <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.list-sesi') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold rounded-xl hover:from-gray-600 hover:to-gray-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class='bx bx-x mr-2'></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class='bx bx-paper-plane mr-2'></i>
                            Ajukan Proposal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        function matchmakingForm() {
            return {
                members: [],
                tomSelectInstances: {},
                init() {
                    const oldMembers = {!! json_encode(old('members')) !!} || [];
                    if (oldMembers.length > 0) {
                        this.members = oldMembers.map((m, i) => ({...m, id: Date.now() + i, unj_details: null}));
                    } else {
                        this.addMember();
                    }
                    
                    this.$nextTick(() => {
                       this.members.forEach(m => this.initTomSelect(m.id));
                    });
                },
                addMember() {
                    const newId = Date.now();
                    this.members.push({
                        id: newId,
                        type: '', 
                        international_type: '',
                        unj_details: null
                    });
                    this.$nextTick(() => {
                        this.initTomSelect(newId);
                    });
                },
                removeMember(index) {
                    const memberId = this.members[index].id;
                    if (this.tomSelectInstances[memberId]) {
                        this.tomSelectInstances[memberId].destroy();
                        delete this.tomSelectInstances[memberId];
                    }
                    this.members.splice(index, 1);
                },
                initTomSelect(memberId) {
                    const el = document.getElementById('dosen_search_' + memberId);
                    if (el) {
                        this.tomSelectInstances[memberId] = new TomSelect(el, {
                            valueField: 'id',
                            labelField: 'text',
                            searchField: 'text',
                            create: false,
                            load: (query, callback) => {
                                if (!query.length) return callback();
                                fetch( `{{ route('subdirektorat-inovasi.dosen.search-dosen') }}?q=${encodeURIComponent(query)}`)
                                    .then(response => response.json())
                                    .then(json => {
                                        callback(json);
                                    }).catch(() => {
                                        callback();
                                    });
                            },
                            onChange: (value) => {
                                const index = this.members.findIndex(m => m.id === memberId);
                                if (index !== -1) {
                                    const selectedData = this.tomSelectInstances[memberId].options[value];
                                    if (selectedData) {
                                        this.members[index].unj_details = {
                                            id: selectedData.id,
                                            name: selectedData.text,
                                            identifier_number: selectedData.identifier_number,
                                            prodi: selectedData.prodi,
                                            fakultas: selectedData.fakultas
                                        };
                                    } else {
                                        this.members[index].unj_details = null;
                                    }
                                }
                            }
                        });
                    }
                }
            }
        }
    </script>
@endsection

