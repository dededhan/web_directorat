@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div x-data="{ 
    showTable: ({{ request()->hasAny(['table', 'show_table', 'search', 'sesi', 'fakultas', 'subject', 'status', 'kelengkapan_data', 'email_status', 'email_belum_fix', 'page']) ? 'true' : 'false' }}) || (typeof sessionStorage !== 'undefined' && sessionStorage.getItem('intl_lecture_show_table') === 'true'),
    toggleTable() {
        this.showTable = !this.showTable;
        try {
            sessionStorage.setItem('intl_lecture_show_table', this.showTable ? 'true' : 'false');
        } catch(e) {}
        if (this.showTable) {
            this.$nextTick(() => {
                document.getElementById('dosenTableSection')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        } else {
            if (window.history && window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('table');
                url.searchParams.delete('show_table');
                window.history.replaceState({}, '', url.pathname + (url.search ? url.search : ''));
            }
        }
    },
    hideTable() {
        this.showTable = false;
        try {
            sessionStorage.setItem('intl_lecture_show_table', 'false');
        } catch(e) {}
        if (window.history && window.history.replaceState) {
            const url = new URL(window.location);
            url.searchParams.delete('table');
            url.searchParams.delete('show_table');
            window.history.replaceState({}, '', url.pathname + (url.search ? url.search : ''));
        }
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },
    init() {
        try {
            const stored = sessionStorage.getItem('intl_lecture_show_table');
            const hasUrlParam = {{ request()->hasAny(['table', 'show_table', 'search', 'sesi', 'fakultas', 'subject', 'status', 'kelengkapan_data', 'email_status', 'email_belum_fix', 'page']) ? 'true' : 'false' }};
            if (hasUrlParam) {
                this.showTable = true;
                sessionStorage.setItem('intl_lecture_show_table', 'true');
            } else if (stored === 'true') {
                this.showTable = true;
            } else if (stored === 'false') {
                this.showTable = false;
            }
        } catch(e) {}

        if (this.showTable) {
            this.$nextTick(() => {
                const referrer = document.referrer || '';
                const isFromSub = referrer.includes('/create') || referrer.includes('/recap') || referrer.includes('/edit');
                const hasUrlParam = {{ request()->hasAny(['table', 'show_table']) ? 'true' : 'false' }};
                if (hasUrlParam || isFromSub || window.location.hash === '#dosenTableSection') {
                    setTimeout(() => {
                        document.getElementById('dosenTableSection')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 50);
                }
            });
        }

        window.addEventListener('pageshow', (event) => {
            try {
                if (sessionStorage.getItem('intl_lecture_show_table') === 'true') {
                    this.showTable = true;
                }
            } catch(e) {}
        });
    }
}" class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8 xl:p-10">
    <div class="max-w-[1920px] mx-auto space-y-6">

        {{-- ================= HEADER ================= --}}
        <div class="rounded-2xl bg-blue-600 p-6 sm:p-8 text-white shadow-md">
            <div class="max-w-3xl">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold tracking-tight text-white">
                    International Lecture Dashboard
                </h1>
                <p class="mt-2 text-sm sm:text-base text-blue-50 leading-relaxed">
                    Pusat tata kelola data dosen asing, korespondensi email, dan administrasi akademik internasional Universitas Negeri Jakarta.
                </p>
            </div>
        </div>

        {{-- ================= FITUR UTAMA / ACTION BUTTON CARDS (FULL TOMBOL) ================= --}}
        <div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                
                {{-- TOMBOL 1: Tabel Data Dosen (Toggle Dinamis) --}}
                <button type="button" @click="toggleTable()"
                        class="text-left group relative overflow-hidden rounded-2xl border-2 p-5 sm:p-6 transition-all duration-200 shadow-sm hover:shadow-md cursor-pointer"
                        :class="showTable ? 'border-blue-600 bg-blue-50/70 ring-2 ring-blue-200' : 'border-gray-200 bg-white hover:border-blue-400 hover:bg-gray-50/80'">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <span class="text-base font-bold text-gray-900 group-hover:text-blue-700 transition">
                                    Tabel Data Dosen
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                    {{ $lecturers->total() }} Dosen
                                </span>
                            </div>
                        </div>
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow-md group-hover:scale-105 transition-transform">
                            <i class="fas fa-table-list text-2xl"></i>
                        </div>
                    </div>
                </button>

                {{-- TOMBOL 2: Kirim Email --}}
                <a :href="showTable ? '{{ route('admin_pemeringkatan.international-lecture.email.index', ['from_table' => 1]) }}' : '{{ route('admin_pemeringkatan.international-lecture.email.index') }}'"
                   @click="try { sessionStorage.setItem('intl_lecture_show_table', showTable ? 'true' : 'false'); } catch(e) {}"
                   class="group relative overflow-hidden rounded-2xl border-2 border-gray-200 bg-white p-5 sm:p-6 transition-all duration-200 shadow-sm hover:border-blue-400 hover:shadow-md hover:bg-gray-50/80">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex-1">
                            <div class="text-base font-bold text-gray-900 group-hover:text-blue-700 transition">
                                Kirim Email
                            </div>
                        </div>
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-600 text-white shadow-md group-hover:scale-105 transition-transform">
                            <i class="fas fa-paper-plane text-2xl"></i>
                        </div>
                    </div>
                </a>

            </div>
        </div>

        {{-- ================= TABEL DATA DOSEN (DYNAMIC ACCORDION / TOGGLE) ================= --}}
        {{-- ================= NOTIFIKASI DATA KOSONG ================= --}}
        @if(($stats['incomplete'] ?? 0) > 0)
            <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-sm font-bold text-amber-900">Data Dosen Belum Lengkap</span>
                            <span class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-bold text-amber-800">{{ $stats['incomplete'] }} dosen</span>
                        </div>
                        <div class="mt-1 flex flex-wrap gap-x-3 gap-y-1 text-xs text-amber-800">
                            @foreach([
                                ['Nama Dosen', $stats['missing']['nama'] ?? 0],
                                ['Jabatan', $stats['missing']['jabatan'] ?? 0],
                                ['Gender', $stats['missing']['jenis_kelamin'] ?? 0],
                                ['Institusi', $stats['missing']['universitas_asal'] ?? 0],
                                ['Negara', $stats['missing']['negara'] ?? 0],
                                ['Subject', $stats['missing']['subject_1'] ?? 0],
                                ['Email Kosong', $stats['missing']['email'] ?? 0],
                                ['Email Belum Fix', $stats['missing']['email_belum_fix'] ?? 0],
                                ['Tahun', $stats['missing']['tahun'] ?? 0],
                                ['Kegiatan', $stats['missing']['kegiatan'] ?? 0],
                            ] as $item)
                                @if($item[1] > 0)
                                    <span><strong>{{ $item[1] }}</strong> {{ $item[0] }}</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <a href="{{ route('admin_pemeringkatan.international-lecture.index', ['table' => 1, 'kelengkapan_data' => 'incomplete']) }}#dosenTableSection"
                       onclick="try{sessionStorage.setItem('intl_lecture_show_table','true')}catch(e){}"
                       class="inline-flex shrink-0 items-center justify-center rounded-lg bg-amber-500 px-3.5 py-2 text-xs font-semibold text-white hover:bg-amber-600 transition">
                        Lihat Data Kosong
                    </a>
                </div>
            </div>
        @endif

        <section id="dosenTableSection" x-show="showTable" x-transition.duration.300ms x-cloak class="pt-4 border-t border-gray-200 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white p-4 sm:p-5 rounded-xl border border-gray-200 shadow-2xs">
                <div>
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-table-list text-blue-600"></i>
                        <span>Tabel Data Dosen Internasional</span>
                    </h2>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('admin_pemeringkatan.international-lecture.create') }}"
                       onclick="try{sessionStorage.setItem('intl_lecture_show_table', 'true')}catch(e){}"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-xs transition">
                        <i class="fas fa-user-plus text-xs"></i>
                        <span>Tambah Dosen Baru</span>
                    </a>
                    <button type="button" onclick="document.getElementById('importModal').classList.remove('hidden')"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-white bg-teal-600 hover:bg-teal-700 rounded-lg shadow-xs transition cursor-pointer">
                        <i class="fas fa-file-excel text-xs"></i>
                        <span>Import Data Excel</span>
                    </button>
                    <a href="{{ route('admin_pemeringkatan.international-lecture.export', request()->query()) }}"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-white bg-teal-600 hover:bg-teal-700 rounded-lg shadow-xs transition cursor-pointer">
                        <i class="fas fa-file-export text-xs"></i>
                        <span>Export Data</span>
                    </a>
                    <a href="{{ route('admin_pemeringkatan.international-lecture.template') }}"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-gray-700 bg-white hover:bg-gray-100 border border-gray-300 rounded-lg shadow-2xs transition">
                        <i class="fas fa-download text-xs text-gray-500"></i>
                        <span>Unduh Template Excel</span>
                    </a>
                    <a href="{{ route('admin_pemeringkatan.international-lecture.recap.index') }}" id="btn-rekapan-data"
                       onclick="try{sessionStorage.setItem('intl_lecture_show_table', 'true')}catch(e){}"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-xs transition">
                        <i class="fas fa-chart-pie text-xs"></i>
                        <span>Rekapan Data</span>
                    </a>
                    <button type="button" @click="hideTable()"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition cursor-pointer">
                        <i class="fas fa-eye-slash text-xs"></i>
                        <span>Sembunyikan Tabel</span>
                    </button>
                </div>
            </div>

            {{-- Filter --}}
            @include('admin_pemeringkatan.international-lecture.partials.filter', [
                'filterRoute' => 'admin_pemeringkatan.international-lecture.index',
                'persistQuery' => ['table' => 1],
                'filterAnchor' => 'dosenTableSection'
            ])

            {{-- Table --}}
            @include('admin_pemeringkatan.international-lecture.partials.table', [
                'showActions' => true,
                'selectable' => false,
                'persistQuery' => ['table' => 1],
                'filterAnchor' => 'dosenTableSection'
            ])
        </section>

    </div>
</div>

{{-- Modal Import Excel --}}
<div id="importModal" class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden border border-gray-100">
        <div class="p-5 sm:p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/70">
            <div>
                <h3 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                    <i class="fas fa-file-excel text-emerald-600"></i>
                    <span>Import Data Excel Dosen</span>
                </h3>
                <p class="text-xs text-gray-500 mt-1">Kolom akan dipetakan otomatis berdasarkan nama header pada berkas Excel.</p>
            </div>
            <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="h-8 w-8 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-200 flex items-center justify-center transition">&times;</button>
        </div>
        <form action="{{ route('admin_pemeringkatan.international-lecture.import') }}" method="POST" enctype="multipart/form-data" class="p-5 sm:p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Pilih Berkas Excel / CSV</label>
                <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                       class="w-full text-sm border border-gray-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div class="text-xs text-gray-600 bg-blue-50/70 border border-blue-200 rounded-xl p-3.5 leading-relaxed">
                <div class="font-bold text-blue-900 mb-1">Panduan Kolom:</div>
                Nama Dosen, Lecturer Name, Job Title, Gender, Institution, University, Country, Email, Subject, Faculty, Department.
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')"
                        class="px-4 py-2.5 text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition">Batal</button>
                <button type="submit"
                        class="px-5 py-2.5 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-sm transition flex items-center gap-1.5">
                    <i class="fas fa-upload"></i> Upload & Import Data
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.delete-btn').forEach(btn => btn.addEventListener('click', function(e){
        e.preventDefault(); 
        const form = this.closest('form');
        Swal.fire({
            title: 'Hapus data dosen?',
            text: 'Data dosen beserta seluruh kegiatan terkait akan dihapus secara permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#ef4444'
        }).then(r => {
            if (r.isConfirmed) form.submit();
        });
    }));
});
</script>
@endsection
