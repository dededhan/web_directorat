{{--
    Partial filter data dosen asing.
    Dipakai di halaman utama International Lecture & halaman Kirim Email.

    Parameter:
    - $filterRoute (string) : nama route tujuan form filter & tombol reset.
    - $persistQuery (array) : query string tambahan yang selalu dipertahankan (mis. ['compose' => 1]).
    - $filterAnchor (string|null) : id elemen tujuan scroll setelah filter diterapkan.
--}}
@php
    $filterRoute = $filterRoute ?? 'admin_pemeringkatan.international-lecture.index';
    $showBulkActions = $showBulkActions ?? false;
    $persistQuery = $persistQuery ?? [];
    $filterHash = !empty($filterAnchor) ? '#' . $filterAnchor : '';
    $filterResetUrl = route($filterRoute, $persistQuery) . $filterHash;
    $removeFilterUrl = fn (string $key) => request()->fullUrlWithQuery(array_merge($persistQuery, [$key => null, 'page' => 1])) . $filterHash;
@endphp
<div x-data="{
    category: '{{ request('category') ?: (request('email_belum_fix') || request('email_status') === 'email_belum_fix' || request('kelengkapan_data') === 'email_belum_fix' ? 'email_belum_fix' : (request('tahun') ? 'tahun' : (request('sesi') ? 'sesi' : (request('fakultas') ? 'fakultas' : (request('subject') ? 'subject' : (request('kelengkapan_data') ? 'kelengkapan_data' : (request('email_status') ? 'email_status' : 'tahun'))))))) }}',
    advancedOpen: false,
}" class="bg-white rounded-xl shadow-xs border border-gray-200/80 p-4 sm:p-5 mb-6 space-y-4">
    
    {{-- Top Controls Bar --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-end gap-3 pb-3 border-b border-gray-100">
        <div class="flex flex-wrap items-center gap-2">
            @if(!empty($showBulkActions) && isset($filteredRecipients))
                <div class="flex items-center gap-1.5 text-xs text-gray-600 mr-1">
                    <label for="per_page_filter" class="text-xs">Tampil</label>
                    <select id="per_page_filter" @change="changePerPage($event.target.value)"
                            class="px-2 py-1 text-xs bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        @foreach([20, 50, 100] as $n)
                            <option value="{{ $n }}" @selected(($perPage ?? 20) === $n)>{{ $n }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <button type="button" @click="advancedOpen = !advancedOpen" 
                    class="text-xs font-semibold text-teal-700 hover:text-teal-800 bg-teal-50 hover:bg-teal-100 px-3 py-1.5 rounded-lg border border-teal-200 transition-colors flex items-center gap-1 shadow-2xs">
                <i class='bx' :class="advancedOpen ? 'bx-collapse-alt' : 'bx-expand-alt'"></i>
                <span x-text="advancedOpen ? 'Mode Kategori Ringkas' : 'Tampilkan Semua Filter'"></span>
            </button>
            @if(request()->hasAny(['search','tahun','sesi','fakultas','status','subject','kelengkapan_data','email_status','email_belum_fix']))
                <a href="{{ $filterResetUrl }}" 
                    class="text-xs text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg border border-red-200 font-semibold transition-colors flex items-center gap-1 shadow-2xs">
                    <i class='bx bx-reset'></i> Reset
                </a>
            @endif
        </div>
    </div>

    {{-- Form Filter Utama --}}
    <form method="GET" action="{{ route($filterRoute) }}{{ $filterHash }}" class="space-y-4">
        @if(request('per_page'))
            <input type="hidden" name="per_page" value="{{ request('per_page') }}">
        @endif
        @foreach($persistQuery as $pqKey => $pqValue)
            <input type="hidden" name="{{ $pqKey }}" value="{{ $pqValue }}">
        @endforeach
        
        {{-- Mode 1: Ringkas dengan Dropdown Kategori & Opsi Dinamis --}}
        <div x-show="!advancedOpen" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
            
            {{-- 1. Input Pencarian Manual --}}
            <div class="md:col-span-5">
                <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">
                    Pencarian Manual
                </label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Ketik nama dosen, email, negara, universitas, prodi..." 
                           class="w-full pl-9 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:bg-white focus:outline-none transition-all">
                    <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                </div>
            </div>

            {{-- 2. Dropdown Pilih Kategori Filter --}}
            <div class="md:col-span-3">
                <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">
                    Pilih Kategori Filter
                </label>
                <select name="category" x-model="category" 
                        class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:bg-white focus:outline-none transition-all font-medium text-gray-800">
                    <option value="tahun">Tahun</option>
                    <option value="sesi">Sesi / Semester</option>
                    <option value="fakultas">Fakultas</option>
                    <option value="subject">Subject</option>
                    <option value="kelengkapan_data">Data yang Masih Kosong</option>
                    <option value="email_status">Status Email</option>
                    <option value="email_belum_fix">Email Belum Fix</option>
                    <option value="status">Status Kepegawaian</option>
                </select>
            </div>

            {{-- 3. Opsi dari Kategori yang Dipilih --}}
            <div class="md:col-span-3">
                <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">
                    <span x-show="category === 'tahun'">Ketik Tahun</span>
                    <span x-show="category === 'sesi'">Ketik Sesi (Semester)</span>
                    <span x-show="category === 'fakultas'">Pilih Fakultas</span>
                    <span x-show="category === 'subject'">Pilih Subject</span>
                    <span x-show="category === 'kelengkapan_data'">Pilih Kelengkapan Data</span>
                    <span x-show="category === 'email_status'">Pilih Status Email</span>
                    <span x-show="category === 'email_belum_fix'">Filter Email Belum Fix</span>
                    <span x-show="category === 'status'">Pilih Status Kepegawaian</span>
                </label>

                {{-- Opsi: Tahun --}}
                <div x-show="category === 'tahun'">
                    <input type="text" name="tahun" :disabled="advancedOpen" value="{{ request('tahun') }}"
                           maxlength="10" autocomplete="off" placeholder="Ketik tahun, contoh: 2026"
                           class="w-full px-3 py-2.5 text-sm bg-white border border-teal-400 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none font-medium text-gray-800">
                </div>

                {{-- Opsi: Sesi --}}
                <div x-show="category === 'sesi'">
                    <input type="text" name="sesi" :disabled="advancedOpen" value="{{ request('sesi') }}"
                           maxlength="50" autocomplete="off" placeholder="Ketik sesi, contoh: 125"
                           class="w-full px-3 py-2.5 text-sm bg-white border border-teal-400 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none font-medium text-gray-800">
                </div>

                {{-- Opsi: Fakultas --}}
                <div x-show="category === 'fakultas'">
                    <select name="fakultas" :disabled="advancedOpen" class="w-full px-3 py-2.5 text-sm bg-white border border-teal-400 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none font-medium text-gray-800">
                        <option value="">Semua Fakultas</option>
                        @foreach(['pascasarjana'=>'PASCASARJANA','fip'=>'FIP','fmipa'=>'FMIPA','fppsi'=>'FPPsi','fbs'=>'FBS','ft'=>'FT','fik'=>'FIK','fis'=>'FIS','fe'=>'FE','profesi'=>'PROFESI','lainnya'=>'LAINNYA'] as $key=>$label)
                            <option value="{{ $key }}" @selected(request('fakultas') === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Opsi: Subject --}}
                <div x-show="category === 'subject'">
                    <select name="subject" :disabled="advancedOpen" class="w-full px-3 py-2.5 text-sm bg-white border border-teal-400 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none font-medium text-gray-800">
                        <option value="">Semua Subject</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject }}" @selected(request('subject') === $subject)>{{ $subject }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Opsi: Kelengkapan Data --}}
                <div x-show="category === 'kelengkapan_data'">
                    <select name="kelengkapan_data" :disabled="advancedOpen" class="w-full px-3 py-2.5 text-sm bg-white border border-teal-400 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none font-medium text-gray-800">
                        <option value="">Semua Data</option>
                        <option value="incomplete" @selected(request('kelengkapan_data') === 'incomplete')>Data Belum Lengkap (Ada Data Kosong)</option>
                        <option value="email_belum_fix" @selected(request('kelengkapan_data') === 'email_belum_fix')>Email Belum Fix (Flag Belum Fix)</option>
                        <option value="missing_nama" @selected(request('kelengkapan_data') === 'missing_nama')>Nama Dosen Asing Masih Kosong</option>
                        <option value="missing_jabatan" @selected(request('kelengkapan_data') === 'missing_jabatan')>Jabatan Masih Kosong</option>
                        <option value="missing_gender" @selected(request('kelengkapan_data') === 'missing_gender')>Gender Masih Kosong</option>
                        <option value="missing_universitas" @selected(request('kelengkapan_data') === 'missing_universitas')>Institusi Masih Kosong</option>
                        <option value="missing_negara" @selected(request('kelengkapan_data') === 'missing_negara')>Negara Masih Kosong</option>
                        <option value="missing_subject" @selected(request('kelengkapan_data') === 'missing_subject')>Subject Masih Kosong</option>
                        <option value="missing_email" @selected(request('kelengkapan_data') === 'missing_email')>Email Masih Kosong</option>
                        <option value="missing_tahun" @selected(request('kelengkapan_data') === 'missing_tahun')>Tahun Masih Kosong</option>
                        <option value="missing_kegiatan" @selected(request('kelengkapan_data') === 'missing_kegiatan')>Kegiatan Masih Kosong</option>
                        <option value="complete" @selected(request('kelengkapan_data') === 'complete')>Data Lengkap (Semua Terisi)</option>
                    </select>
                </div>

                {{-- Opsi: Email Status --}}
                <div x-show="category === 'email_status'">
                    <select name="email_status" :disabled="advancedOpen" class="w-full px-3 py-2.5 text-sm bg-white border border-teal-400 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none font-medium text-gray-800">
                        <option value="">Semua Status Email</option>
                        <option value="email_belum_fix" @selected(request('email_status') === 'email_belum_fix')>Email Belum Fix (Flag Belum Fix)</option>
                        <option value="sent" @selected(request('email_status') === 'sent')>Sudah Terkirim</option>
                        <option value="not_sent" @selected(request('email_status') === 'not_sent')>Belum Terkirim</option>
                        <option value="failed" @selected(request('email_status') === 'failed')>Gagal</option>
                    </select>
                </div>

                {{-- Opsi: Email Belum Fix (Kategori Khusus) --}}
                <div x-show="category === 'email_belum_fix'">
                    <select name="email_status" :disabled="advancedOpen || category !== 'email_belum_fix'" class="w-full px-3 py-2.5 text-sm bg-white border border-rose-400 rounded-lg focus:ring-2 focus:ring-rose-500 focus:outline-none font-semibold text-rose-700">
                        <option value="email_belum_fix" selected>Email Belum Fix (Flag Belum Fix)</option>
                    </select>
                </div>

                {{-- Opsi: Status Kepegawaian --}}
                <div x-show="category === 'status'">
                    <select name="status" :disabled="advancedOpen" class="w-full px-3 py-2.5 text-sm bg-white border border-teal-400 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none font-medium text-gray-800">
                        <option value="">Semua Status</option>
                        <option value="fulltime" @selected(request('status') === 'fulltime')>Full Time</option>
                        <option value="parttime" @selected(request('status') === 'parttime')>Part Time</option>
                    </select>
                </div>
            </div>

            {{-- 4. Tombol Submit --}}
            <div class="md:col-span-1">
                <button type="submit" 
                        class="w-full py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow transition-all flex items-center justify-center gap-1">
                    <i class='bx bx-search text-base'></i>
                    <span class="md:hidden lg:inline">Cari</span>
                </button>
            </div>
        </div>

        {{-- Mode 2: Tampilkan Semua Filter Sekaligus (Mode Lengkap) --}}
        <div x-show="advancedOpen" x-transition class="pt-3 border-t border-gray-100" x-cloak>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Cari Manual (Kata Kunci)</label>
                    <input type="text" name="search" :disabled="!advancedOpen" value="{{ request('search') }}" placeholder="Nama, email, negara, institusi..." class="w-full px-3.5 py-2 text-sm border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Tahun</label>
                    <input type="text" name="tahun" :disabled="!advancedOpen" value="{{ request('tahun') }}"
                           maxlength="10" autocomplete="off" placeholder="Contoh: 2026"
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Sesi (Semester)</label>
                    <input type="text" name="sesi" :disabled="!advancedOpen" value="{{ request('sesi') }}"
                           maxlength="50" autocomplete="off" placeholder="Ketik sesi, contoh: 125"
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Fakultas</label>
                    <select name="fakultas" :disabled="!advancedOpen" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg">
                        <option value="">Semua Fakultas</option>
                        @foreach(['pascasarjana'=>'PASCASARJANA','fip'=>'FIP','fmipa'=>'FMIPA','fppsi'=>'FPPsi','fbs'=>'FBS','ft'=>'FT','fik'=>'FIK','fis'=>'FIS','fe'=>'FE','profesi'=>'PROFESI','lainnya'=>'LAINNYA'] as $key=>$label)
                            <option value="{{ $key }}" @selected(request('fakultas') === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Subject</label>
                    <select name="subject" :disabled="!advancedOpen" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg">
                        <option value="">Semua Subject</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject }}" @selected(request('subject') === $subject)>{{ $subject }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Data yang Masih Kosong</label>
                    <select name="kelengkapan_data" :disabled="!advancedOpen" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg">
                        <option value="">Semua Data</option>
                        <option value="incomplete" @selected(request('kelengkapan_data') === 'incomplete')>Data Belum Lengkap</option>
                        <option value="email_belum_fix" @selected(request('kelengkapan_data') === 'email_belum_fix')>Email Belum Fix</option>
                        <option value="missing_nama" @selected(request('kelengkapan_data') === 'missing_nama')>Nama Dosen Asing Kosong</option>
                        <option value="missing_jabatan" @selected(request('kelengkapan_data') === 'missing_jabatan')>Jabatan Kosong</option>
                        <option value="missing_gender" @selected(request('kelengkapan_data') === 'missing_gender')>Gender Kosong</option>
                        <option value="missing_universitas" @selected(request('kelengkapan_data') === 'missing_universitas')>Institusi Kosong</option>
                        <option value="missing_negara" @selected(request('kelengkapan_data') === 'missing_negara')>Negara Kosong</option>
                        <option value="missing_subject" @selected(request('kelengkapan_data') === 'missing_subject')>Subject Kosong</option>
                        <option value="missing_email" @selected(request('kelengkapan_data') === 'missing_email')>Email Kosong</option>
                        <option value="missing_tahun" @selected(request('kelengkapan_data') === 'missing_tahun')>Tahun Kosong</option>
                        <option value="missing_kegiatan" @selected(request('kelengkapan_data') === 'missing_kegiatan')>Kegiatan Kosong</option>
                        <option value="complete" @selected(request('kelengkapan_data') === 'complete')>Data Lengkap</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Status Email</label>
                    <select name="email_status" :disabled="!advancedOpen" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg">
                        <option value="">Semua Status Email</option>
                        <option value="email_belum_fix" @selected(request('email_status') === 'email_belum_fix')>Email Belum Fix</option>
                        <option value="sent" @selected(request('email_status') === 'sent')>Sudah Terkirim</option>
                        <option value="not_sent" @selected(request('email_status') === 'not_sent')>Belum Terkirim</option>
                        <option value="failed" @selected(request('email_status') === 'failed')>Gagal</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Status Kepegawaian</label>
                    <select name="status" :disabled="!advancedOpen" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg">
                        <option value="">Semua Status</option>
                        <option value="fulltime" @selected(request('status') === 'fulltime')>Full Time</option>
                        <option value="parttime" @selected(request('status') === 'parttime')>Part Time</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 flex flex-wrap items-center gap-2 {{ (!empty($showBulkActions) && isset($filteredRecipients)) ? 'justify-between' : 'justify-end' }}">
                @if(!empty($showBulkActions) && isset($filteredRecipients))
                    <button type="button" id="select-all-filtered-btn" @click="selectAllFiltered()"
                            class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold rounded-lg bg-white text-gray-800 border border-gray-300 hover:bg-gray-50 transition shadow-2xs">
                        <i class="fa-solid fa-check-double text-gray-700 text-xs"></i>
                        <span>Pilih Semua Hasil Filter</span>
                        <span class="ml-0.5 px-1.5 py-0.5 rounded bg-gray-100 border border-gray-300 text-gray-800 text-[10px] font-bold">{{ $filteredRecipients->count() }}</span>
                    </button>
                @endif
                <button type="submit" class="px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold rounded-lg shadow-sm">
                    <i class='bx bx-check mr-1'></i> Terapkan Filter yang Dipilih
                </button>
            </div>
        </div>
    </form>

    {{-- Badges Filter Aktif --}}
    @if(request()->hasAny(['search', 'tahun', 'sesi', 'fakultas', 'subject', 'status', 'kelengkapan_data', 'email_status', 'email_belum_fix']))
        <div class="pt-3 border-t border-gray-100 flex flex-wrap items-center gap-2">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Filter Aktif:</span>
            
            @if(request('search'))
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                    Cari: "{{ request('search') }}"
                    <a href="{{ $removeFilterUrl('search') }}" class="hover:text-blue-900 ml-0.5"><i class='bx bx-x'></i></a>
                </span>
            @endif

            @if(request('tahun'))
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-800 border border-blue-300">
                    Tahun: {{ request('tahun') }}
                    <a href="{{ $removeFilterUrl('tahun') }}" class="hover:text-blue-950 ml-0.5"><i class='bx bx-x'></i></a>
                </span>
            @endif

            @if(request('sesi'))
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-teal-50 text-teal-800 border border-teal-300">
                    Sesi: {{ request('sesi') }} {{ request('sesi') == '125' ? '(Semester Ini)' : '' }}
                    <a href="{{ $removeFilterUrl('sesi') }}" class="hover:text-teal-950 ml-0.5"><i class='bx bx-x'></i></a>
                </span>
            @endif

            @if(request('fakultas'))
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-200">
                    Fakultas: {{ strtoupper(request('fakultas')) }}
                    <a href="{{ $removeFilterUrl('fakultas') }}" class="hover:text-purple-900 ml-0.5"><i class='bx bx-x'></i></a>
                </span>
            @endif

            @if(request('subject'))
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                    Subject: {{ request('subject') }}
                    <a href="{{ $removeFilterUrl('subject') }}" class="hover:text-amber-900 ml-0.5"><i class='bx bx-x'></i></a>
                </span>
            @endif

            @if(request('kelengkapan_data'))
                @php
                    $kdLabel = match(request('kelengkapan_data')) {
                        'incomplete' => 'Data Belum Lengkap',
                        'email_belum_fix' => 'Email Belum Fix',
                        'missing_nama' => 'Nama Dosen Asing Kosong',
                        'missing_jabatan' => 'Jabatan Kosong',
                        'missing_gender' => 'Gender Kosong',
                        'missing_universitas' => 'Institusi Kosong',
                        'missing_negara' => 'Negara Kosong',
                        'missing_subject' => 'Subject Kosong',
                        'missing_email' => 'Email Kosong',
                        'missing_tahun' => 'Tahun Kosong',
                        'missing_kegiatan' => 'Kegiatan Kosong',
                        'complete' => 'Data Lengkap',
                        default => request('kelengkapan_data'),
                    };
                @endphp
                @if(request('kelengkapan_data') === 'email_belum_fix')
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-300">
                        <i class='bx bx-error-circle'></i> Email: Belum Fix
                        <a href="{{ $removeFilterUrl('kelengkapan_data') }}" class="hover:text-rose-950 ml-0.5"><i class='bx bx-x'></i></a>
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-800 border border-amber-300">
                        Data: {{ $kdLabel }}
                        <a href="{{ $removeFilterUrl('kelengkapan_data') }}" class="hover:text-amber-950 ml-0.5"><i class='bx bx-x'></i></a>
                    </span>
                @endif
            @endif

            @if(request('email_status') === 'email_belum_fix' || request('category') === 'email_belum_fix' || request('email_belum_fix'))
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-300">
                    <i class='bx bx-error-circle'></i> Email: Belum Fix
                    <a href="{{ $removeFilterUrl('email_status') }}" class="hover:text-rose-950 ml-0.5"><i class='bx bx-x'></i></a>
                </span>
            @elseif(request('email_status'))
                @php
                    $emailStatusLabel = match(request('email_status')) {
                        'sent' => 'Sudah Terkirim',
                        'not_sent' => 'Belum Terkirim',
                        'failed' => 'Gagal',
                        default => ucfirst(request('email_status')),
                    };
                @endphp
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">
                    Email: {{ $emailStatusLabel }}
                    <a href="{{ $removeFilterUrl('email_status') }}" class="hover:text-indigo-900 ml-0.5"><i class='bx bx-x'></i></a>
                </span>
            @endif

            @if(request('status'))
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-300">
                    Status: {{ ucfirst(request('status')) }}
                    <a href="{{ $removeFilterUrl('status') }}" class="hover:text-gray-900 ml-0.5"><i class='bx bx-x'></i></a>
                </span>
            @endif

            <a href="{{ $filterResetUrl }}" 
               class="text-xs text-red-600 hover:text-red-800 font-semibold ml-1 hover:underline">
                Hapus Semua
            </a>
        </div>
    @endif
</div>
