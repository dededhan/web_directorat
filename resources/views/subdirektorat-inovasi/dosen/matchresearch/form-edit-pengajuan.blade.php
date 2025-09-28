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
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <header class="mb-10">
                <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                    <ol class="list-none p-0 inline-flex items-center space-x-2">
                        <li><a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.manajemen') }}" class="hover:text-teal-600">Manajemen Proposal</a></li>
                        <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                        <li class="font-medium text-gray-800">Edit Pengajuan</li>
                    </ol>
                </nav>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Edit Pengajuan Matchmaking</h1>
                    <p class="mt-2 text-gray-600">Sesi: <strong class="text-teal-700">{{ $submission->session->nama_sesi }}</strong></p>
                </div>
            </header>

            <form action="{{ route('subdirektorat-inovasi.dosen.matchresearch.update', $submission->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">1. Judul Penelitian</h2>
                    <label for="judul_proposal" class="block text-sm font-medium text-gray-700 mb-2">Judul Proposal</label>
                    <input type="text" name="judul_proposal" id="judul_proposal" value="{{ old('judul_proposal', $submission->judul_proposal) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                    @error('judul_proposal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-800">2. Anggota Peneliti</h2>
                        <button @click="addMember" type="button" class="px-4 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 text-sm">
                            <i class='bx bx-plus mr-1'></i> Tambah Anggota
                        </button>
                    </div>
                     @error('members') <p class="text-red-500 text-xs mb-4">{{ $message }}</p> @enderror

                    <div class="space-y-6">
                        <template x-for="(member, index) in members" :key="member.id">
                           <div class="p-6 bg-gray-50 rounded-xl border relative">
                                <button @click="removeMember(index)" type="button" class="absolute top-3 right-3 text-gray-400 hover:text-red-500">
                                    <i class='bx bx-x text-2xl'></i>
                                </button>
                                <input type="hidden" :name="`members[${index}][id]`" :value="member.id">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                     <select x-model="member.type" :name="`members[${index}][type]`" class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                                        <option value="">-- Pilih Tipe --</option>
                                        <option value="unj">Dosen UNJ</option>
                                        <option value="international">Mitra Internasional</option>
                                    </select>
                                </div>

    
                                <div x-show="member.type === 'unj'" x-transition class="mt-4 pt-4 border-t">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Nama Dosen</label>
                                    <select :id="'dosen_search_' + member.id" :name="`members[${index}][user_id]`"></select>
                                </div>


                                <div x-show="member.type === 'international'" x-transition class="mt-4 pt-4 border-t">
                                    <h3 class="font-semibold text-gray-700 mb-4">Detail Mitra Internasional</h3>
                                    <select x-model="member.details.international_type" :name="`members[${index}][international_type]`" class="w-full p-2 border rounded-md mb-6">
                                        <option value="">-- Pilih Tipe Mitra --</option>
                                        <option value="h_index">H-Index Researcher</option>
                                        <option value="editor">Editor Top Tier Journal</option>
                                        <option value="fellow">Fellow Organization Profession</option>
                                        <option value="academy">National Academy Member</option>
                                    </select>

                                    <div x-show="member.details.international_type" x-transition class="space-y-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <input type="text" :name="`members[${index}][${member.details.international_type}][name]`" x-model="member.details.name" placeholder="Nama" class="w-full px-4 py-2 border rounded-md">
                                            <input type="text" :name="`members[${index}][${member.details.international_type}][institution]`" x-model="member.details.institution" placeholder="Instansi/Institusi" class="w-full px-4 py-2 border rounded-md">
                                            
                                            <select :name="`members[${index}][${member.details.international_type}][country]`" x-model="member.details.country" class="w-full px-4 py-2 border rounded-md">
                                                <option value="">-- Pilih Negara --</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country['name'] }}">{{ $country['name'] }}</option>
                                                @endforeach
                                            </select>
                                            
                                            <select :name="`members[${index}][${member.details.international_type}][expertise]`" x-model="member.details.expertise" class="w-full px-4 py-2 border rounded-md">
                                                <option value="">-- Bidang Keahlian --</option>
                                                <option value="STEM">STEM</option>
                                                <option value="Social Sciences and Humanities">Social Sciences and Humanities</option>
                                            </select>
                                            
                                            <template x-if="member.details.international_type === 'h_index'">
                                                <div class="md:col-span-2">
                                                    <input type="url" :name="`members[${index}][h_index][scopus_link]`" x-model="member.details.scopus_link" placeholder="Link ID Scopus" class="w-full px-4 py-2 border rounded-md">
                                                </div>
                                            </template>

                                            <template x-if="member.details.international_type === 'editor'">
                                                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <input type="text" :name="`members[${index}][editor][journal_name]`" x-model="member.details.journal_name" placeholder="Nama Jurnal" class="w-full px-4 py-2 border rounded-md">
                                                    <input type="url" :name="`members[${index}][editor][scimago_link]`" x-model="member.details.scimago_link" placeholder="Link Scimagojr (jurnal)" class="w-full px-4 py-2 border rounded-md">
                                                </div>
                                            </template>
                                            
                                            <template x-if="member.details.international_type === 'fellow'">
                                                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <input type="text" :name="`members[${index}][fellow][organization_name]`" x-model="member.details.organization_name" placeholder="Nama Organisasi" class="w-full px-4 py-2 border rounded-md">
                                                    <input type="url" :name="`members[${index}][fellow][organization_link]`" x-model="member.details.organization_link" placeholder="Link Organisasi" class="w-full px-4 py-2 border rounded-md">
                                                    <input type="text" :name="`members[${index}][fellow][membership_id]`" x-model="member.details.membership_id" placeholder="Nomor ID Keanggotaan" class="md:col-span-2 w-full px-4 py-2 border rounded-md">
                                                    <div class="md:col-span-2">
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Keanggotaan (Opsional: ganti file)</label>
                                                        <input type="file" :name="`members[${index}][fellow][membership_proof]`" class="file-input-style">
                                                        <template x-if="member.details.membership_proof">
                                                            <a :href="`/storage/${member.details.membership_proof}`" target="_blank" class="text-sm text-teal-600 hover:underline mt-1">Lihat file saat ini</a>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>

                                             <template x-if="member.details.international_type === 'academy'">
                                                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <input type="text" :name="`members[${index}][academy][academy_name]`" x-model="member.details.academy_name" placeholder="Nama National Academy" class="w-full px-4 py-2 border rounded-md">
                                                    <input type="text" :name="`members[${index}][academy][membership_year]`" x-model="member.details.membership_year" placeholder="Tahun Keanggotaan" class="w-full px-4 py-2 border rounded-md">
                                                    <div class="md:col-span-2">
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Keanggotaan (Opsional: ganti file)</label>
                                                        <input type="file" :name="`members[${index}][academy][membership_proof]`" class="file-input-style">
                                                         <template x-if="member.details.membership_proof">
                                                            <a :href="`/storage/${member.details.membership_proof}`" target="_blank" class="text-sm text-teal-600 hover:underline mt-1">Lihat file saat ini</a>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('subdirektorat-inovasi.dosen.matchresearch.manajemen') }}" class="px-6 py-3 bg-gray-200 text-gray-800 font-semibold rounded-xl">Batal</a>
                    <button type="submit" class="px-8 py-3 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700">Simpan Perubahan</button>
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