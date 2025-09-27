@extends('subdirektorat-inovasi.dosen.index')

@push('styles')
    {{-- CDN for TomSelect.js --}}
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
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="matchmakingForm({ initialMembers: {{ json_encode($submission->members->toArray()) }} })">
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

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <select x-model="member.type" :name="`members[${index}][type]`" class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                                        <option value="unj">Dosen UNJ</option>
                                        <option value="international">Mitra Internasional</option>
                                    </select>
                                </div>


                                <div x-show="member.type === 'unj'" class="mt-4 pt-4 border-t">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Nama Dosen</label>
                                    <select :id="'dosen_search_' + member.id" :name="`members[${index}][user_id]`"></select>
                                </div>


                                <div x-show="member.type === 'international'" class="mt-4 pt-4 border-t">

                                    <p class="text-sm text-gray-600">Detail mitra internasional akan diisi di sini.</p>
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
            let initialData = oldMembers || config.initialMembers || [];
            
            this.members = initialData.map((m, i) => {

                let internationalType = '';
                if(m.type === 'international' && m.details) {
                    const keys = ['h_index', 'editor', 'fellow', 'academy'];
                    internationalType = keys.find(key => m.details[key]) || '';
                }

                return {
                    ...m,
                    id: m.id || Date.now() + i,
                    international_type: internationalType,
                    details: m.details || {},
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
            this.members.push({ id: newId, type: 'unj', user_id: null, details: {} });
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


            if (memberData && memberData.type === 'unj' && memberData.user) {
                tomSelect.addOption({ id: memberData.user.id, text: memberData.user.name });
                tomSelect.setValue(memberData.user.id);
            }

            this.tomSelectInstances[memberId] = tomSelect;
        }
    }
}
</script>
@endsection
