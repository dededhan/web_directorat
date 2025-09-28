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
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="matchmakingForm({ initialMembers: {{ json_encode($submission->members->map(function($member) {
        return [
            'id' => $member->id,
            'type' => $member->type,
            'user_id' => $member->user_id,
            'details' => $member->details ?: [],
            'user' => $member->user ? [
                'id' => $member->user->id,
                'name' => $member->user->name
            ] : null
        ];
    })) }} })">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Breadcrumb dan Judul Halaman --}}
            <header class="mb-10">
                <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                    <ol class="list-none p-0 inline-flex items-center space-x-2">
                        <li><a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.manajemen') }}" class="hover:text-teal-600 transition-colors duration-200">Manajemen Proposal</a></li>
                        <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                        <li class="font-medium text-gray-800">Edit Pengajuan</li>
                    </ol>
                </nav>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Edit Pengajuan Matchmaking</h1>
                        <p class="mt-2 text-gray-600 text-base">Sesi: <strong class="text-teal-700">{{ $submission->session->nama_sesi }}</strong></p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.manajemen') }}"
                            class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold rounded-xl hover:from-gray-600 hover:to-gray-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class='bx bx-arrow-back mr-2 text-lg'></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </header>

            <form action="{{ route('subdirektorat-inovasi.dosen.matchresearch.update', $submission->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                {{-- Judul Penelitian --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                        <div class="flex items-center text-white">
                            <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                                <i class='bx bx-edit-alt mr-3 text-2xl'></i>
                                1. Judul Penelitian
                            </h2>
                        </div>
                    </div>
                    
                    <div class="p-6 lg:p-8">
                        <div class="space-y-6">
                            <div>
                                <label for="judul_proposal" class="block text-sm font-bold text-gray-700 mb-3">
                                    <div class="flex items-center space-x-2">
                                        <i class='bx bx-file-blank text-base text-teal-500'></i>
                                        <span>Judul Proposal</span>
                                        <span class="text-red-500">*</span>
                                    </div>
                                </label>
                                <input type="text" 
                                       name="judul_proposal" 
                                       id="judul_proposal" 
                                       value="{{ old('judul_proposal', $submission->judul_proposal) }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200"
                                       placeholder="Masukkan judul proposal penelitian"
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
                                        <input type="hidden" :name="`members[${index}][id]`" :value="member.id">

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
                                                <select x-model="member.details.international_type" 
                                                        :name="`members[${index}][international_type]`" 
                                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                                                    <option value="">-- Pilih Tipe Mitra --</option>
                                                    <option value="h_index">H-Index Researcher</option>
                                                    <option value="editor">Editor Top Tier Journal</option>
                                                    <option value="fellow">Fellow Organization Profession</option>
                                                    <option value="academy">National Academy Member</option>
                                                </select>
                                            </div>

                                            <div x-show="member.details.international_type" 
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
                                                                   :name="`members[${index}][${member.details.international_type}][name]`" 
                                                                   x-model="member.details.name" 
                                                                   placeholder="Nama lengkap" 
                                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all">
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-2">Instansi/Institusi</label>
                                                            <input type="text" 
                                                                   :name="`members[${index}][${member.details.international_type}][institution]`" 
                                                                   x-model="member.details.institution" 
                                                                   placeholder="Nama institusi" 
                                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all">
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-2">Negara</label>
                                                            <select :name="`members[${index}][${member.details.international_type}][country]`" 
                                                                    x-model="member.details.country" 
                                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all">
                                                                <option value="">-- Pilih Negara --</option>
                                                                @foreach ($countries as $country)
                                                                    <option value="{{ $country['name'] }}">{{ $country['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-2">Bidang Keahlian</label>
                                                            <select :name="`members[${index}][${member.details.international_type}][expertise]`" 
                                                                    x-model="member.details.expertise" 
                                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all">
                                                                <option value="">-- Bidang Keahlian --</option>
                                                                <option value="STEM">STEM</option>
                                                                <option value="Social Sciences and Humanities">Social Sciences and Humanities</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- H-Index Specific Fields --}}
                                                <template x-if="member.details.international_type === 'h_index'">
                                                    <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-xl p-6 border border-yellow-200">
                                                        <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
                                                            <i class='bx bx-trending-up text-yellow-600 mr-2'></i>
                                                            H-Index Details
                                                        </h5>
                                                        <input type="url" 
                                                               :name="`members[${index}][h_index][scopus_link]`" 
                                                               x-model="member.details.scopus_link" 
                                                               placeholder="Link ID Scopus (https://...)" 
                                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all">
                                                    </div>
                                                </template>

                                                {{-- Editor Specific Fields --}}
                                                <template x-if="member.details.international_type === 'editor'">
                                                    <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
                                                        <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
                                                            <i class='bx bx-book-content text-green-500 mr-2'></i>
                                                            Editor Details
                                                        </h5>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <input type="text" 
                                                                   :name="`members[${index}][editor][journal_name]`" 
                                                                   x-model="member.details.journal_name" 
                                                                   placeholder="Nama Jurnal" 
                                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                                                            <input type="url" 
                                                                   :name="`members[${index}][editor][scimago_link]`" 
                                                                   x-model="member.details.scimago_link" 
                                                                   placeholder="Link Scimagojr (https://...)" 
                                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                                                        </div>
                                                    </div>
                                                </template>

                                                {{-- Fellow Specific Fields --}}
                                                <template x-if="member.details.international_type === 'fellow'">
                                                    <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                                                        <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
                                                            <i class='bx bx-award text-purple-500 mr-2'></i>
                                                            Fellow Organization Details
                                                        </h5>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <input type="text" 
                                                                   :name="`members[${index}][fellow][organization_name]`" 
                                                                   x-model="member.details.organization_name" 
                                                                   placeholder="Nama Organisasi" 
                                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
                                                            <input type="url" 
                                                                   :name="`members[${index}][fellow][organization_link]`" 
                                                                   x-model="member.details.organization_link" 
                                                                   placeholder="Link Organisasi (https://...)" 
                                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
                                                            <div class="md:col-span-2">
                                                                <input type="text" 
                                                                       :name="`members[${index}][fellow][membership_id]`" 
                                                                       x-model="member.details.membership_id" 
                                                                       placeholder="Nomor ID Keanggotaan" 
                                                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all mb-4">
                                                                <div>
                                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Keanggotaan (Opsional: ganti file)</label>
                                                                    <input type="file" 
                                                                           :name="`members[${index}][fellow][membership_proof]`" 
                                                                           class="file-input-style">
                                                                    <template x-if="member.details.membership_proof">
                                                                        <a :href="`/storage/${member.details.membership_proof}`" 
                                                                           target="_blank" 
                                                                           class="inline-flex items-center text-sm text-teal-600 hover:text-teal-800 hover:underline mt-2 transition-colors">
                                                                            <i class='bx bx-link-external mr-1'></i>
                                                                            Lihat file saat ini
                                                                        </a>
                                                                    </template>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>

                                                {{-- Academy Specific Fields --}}
                                                <template x-if="member.details.international_type === 'academy'">
                                                    <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-xl p-6 border border-red-200">
                                                        <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
                                                            <i class='bx bx-medal text-red-500 mr-2'></i>
                                                            National Academy Details
                                                        </h5>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <input type="text" 
                                                                   :name="`members[${index}][academy][academy_name]`" 
                                                                   x-model="member.details.academy_name" 
                                                                   placeholder="Nama National Academy" 
                                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                                                            <input type="text" 
                                                                   :name="`members[${index}][academy][membership_year]`" 
                                                                   x-model="member.details.membership_year" 
                                                                   placeholder="Tahun Keanggotaan" 
                                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                                                            <div class="md:col-span-2">
                                                                <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Keanggotaan (Opsional: ganti file)</label>
                                                                <input type="file" 
                                                                       :name="`members[${index}][academy][membership_proof]`" 
                                                                       class="file-input-style">
                                                                <template x-if="member.details.membership_proof">
                                                                    <a :href="`/storage/${member.details.membership_proof}`" 
                                                                       target="_blank" 
                                                                       class="inline-flex items-center text-sm text-teal-600 hover:text-teal-800 hover:underline mt-2 transition-colors">
                                                                        <i class='bx bx-link-external mr-1'></i>
                                                                        Lihat file saat ini
                                                                    </a>
                                                                </template>
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
                                    <p class="text-gray-500 text-sm mb-6">Tambahkan anggota peneliti untuk melanjutkan</p>
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
                        <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.manajemen') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold rounded-xl hover:from-gray-600 hover:to-gray-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class='bx bx-x mr-2'></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class='bx bx-save mr-2'></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
function matchmakingForm(config) {
    return {
        members: [],
        tomSelectInstances: {},
        init() {
            const oldMembers = {!! json_encode(old('members')) !!};
            let initialData = oldMembers && oldMembers.length > 0 ? oldMembers : config.initialMembers;

            this.members = initialData.map((m, i) => {
                let details = m.details || {};

                if (typeof details === 'string') {
                    try {
                        details = JSON.parse(details);
                    } catch (e) {
                        details = {};
                    }
                }
                

                if (m.type === 'international' && !details.international_type) {

                    if (details.scopus_link) details.international_type = 'h_index';
                    else if (details.journal_name) details.international_type = 'editor';
                    else if (details.organization_name) details.international_type = 'fellow';
                    else if (details.academy_name) details.international_type = 'academy';
                }
                
                return {
                    id: m.id || Date.now() + i,
                    type: m.type || '',
                    user_id: m.user_id || null,
                    details: details,
                    user: m.user || null
                };
            });
            
            if (this.members.length === 0) this.addMember();

            this.$nextTick(() => {
                this.members.forEach(member => {
                    this.initTomSelect(member.id, member);
                });
            });
        },
        addMember() {
            const newId = Date.now();
            this.members.push({ 
                id: newId, 
                type: 'unj', 
                user_id: null, 
                details: {},
                user: null
            });
            this.$nextTick(() => this.initTomSelect(newId));
        },
        removeMember(index) {
            const memberId = this.members[index].id;
            if (this.tomSelectInstances[memberId]) {
                this.tomSelectInstances[memberId].destroy();
                delete this.tomSelectInstances[memberId];
            }
            this.members.splice(index, 1);
        },
        initTomSelect(memberId, memberData = null) {
            const el = document.getElementById('dosen_search_' + memberId);
            if (!el) return;
            

            if (this.tomSelectInstances[memberId]) {
                this.tomSelectInstances[memberId].destroy();
            }

            const tomSelect = new TomSelect(el, {
                valueField: 'id',
                labelField: 'text',
                searchField: 'text',
                create: false,
                load: (query, callback) => {
                    fetch(`{{ route('subdirektorat-inovasi.dosen.search-dosen') }}?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(callback)
                        .catch(() => callback());
                }
            });

            if (memberData && memberData.type === 'unj' && memberData.user_id) {

                if (memberData.user) {
                    tomSelect.addOption({ 
                        id: memberData.user.id, 
                        text: memberData.user.name 
                    });
                    tomSelect.setValue(memberData.user.id);
                } else if (memberData.user_id) {

                    tomSelect.setValue(memberData.user_id);
                }
            }

            this.tomSelectInstances[memberId] = tomSelect;
        }
    }
}
</script>
@endsection