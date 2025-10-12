@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')

<div class="space-y-8">
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white shadow-lg">
        <div class="absolute -right-10 -top-10 h-52 w-52 rounded-full bg-white/20 blur-3xl"></div>
        <div class="absolute -bottom-20 left-1/3 h-56 w-56 rounded-full bg-white/10 blur-2xl"></div>
        <div class="relative px-8 py-12 lg:px-12">
            <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-1.5 text-sm font-medium">
                <i class="fas fa-crown"></i>
                Admin Pemeringkatan
            </span>
            <div class="mt-6 max-w-2xl space-y-3">
                <h1 class="text-3xl font-semibold md:text-4xl">THE Impact Rankings CMS</h1>
                <p class="text-white/80">Kelola dan kurasi konten untuk 17 Sustainable Development Goals pada platform THE Impact Rankings.</p>
            </div>
            <div class="mt-8 flex flex-wrap gap-3 text-sm font-medium text-white/90">
                <div class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-2">
                    <i class="fas fa-layer-group"></i>
                    <span>{{ number_format($stats['total_contents']) }} konten tersimpan</span>
                </div>
                <div class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-2">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ $stats['completed_sdgs'] }} SDG aktif</span>'
                
                </div>
                <div class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-2">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $stats['empty_sdgs'] }} SDG belum terisi</span>
                </div>
                @if($stats['last_update_at'])
                <div class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-2">
                    <i class="fas fa-clock"></i>
                    <span>Pembaruan {{ optional($stats['last_update_at'])->diffForHumans() }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total SDG</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-800">{{ $stats['total_sdgs'] }}</p>
                </div>
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
                    <i class="fas fa-globe-asia text-xl"></i>
                </span>
            </div>
            <p class="mt-4 text-xs text-gray-400">Jumlah keseluruhan SDG yang tersedia pada CMS.</p>
        </div>
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">SDG Aktif</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-800">{{ $stats['active_sdgs'] }}</p>
                </div>
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
                    <i class="fas fa-bolt text-xl"></i>
                </span>
            </div>
            <p class="mt-4 text-xs text-gray-400">SDG yang ditandai aktif dan siap dipublikasikan.</p>
        </div>
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Konten SDG</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-800">{{ number_format($stats['total_contents']) }}</p>
                </div>
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-600">
                    <i class="fas fa-file-alt text-xl"></i>
                </span>
            </div>
            <p class="mt-4 text-xs text-gray-400">Total poin konten yang telah dikurasi pada semua SDG.</p>
        </div>
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">SDG Belum Terisi</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-800">{{ $stats['empty_sdgs'] }}</p>
                </div>
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-100 text-rose-600">
                    <i class="fas fa-hourglass-half text-xl"></i>
                </span>
            </div>
            <p class="mt-4 text-xs text-gray-400">SDG yang belum memiliki poin konten sama sekali.</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
        <div class="flex flex-col gap-4 border-b border-gray-100 px-6 py-6 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Kelola SDG</h2>
                <p class="text-sm text-gray-500">Pilih salah satu SDG untuk melihat dan mengatur konten pendukungnya.</p>
            </div>
            @if($sdgs->isEmpty())
            <button onclick="initializeSdgs()" class="inline-flex items-center gap-2 rounded-full bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow hover:bg-emerald-700 transition">
                <i class="fas fa-sync-alt"></i>
                Inisialisasi 17 SDGs
            </button>
            @else
            <div class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-4 py-2 text-sm font-medium text-indigo-600">
                <i class="fas fa-info-circle"></i>
                {{ $stats['completed_sdgs'] }} SDG telah memiliki konten
            </div>
            @endif
        </div>

        @if($sdgs->isEmpty())
        <div class="px-6 py-16 text-center">
            <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-indigo-50 text-indigo-500">
                <i class="fas fa-database text-3xl"></i>
            </div>
            <h3 class="mt-6 text-lg font-semibold text-gray-700">Belum ada SDG yang terinisialisasi</h3>
            <p class="mt-2 text-sm text-gray-500">Klik tombol di atas untuk membuat otomatis 17 SDG dengan informasi dasar.</p>
            <button onclick="initializeSdgs()" class="mt-6 inline-flex items-center gap-2 rounded-full bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow hover:bg-indigo-700 transition">
                <i class="fas fa-sync-alt"></i>
                Inisialisasi 17 SDGs
            </button>
        </div>
        @else
        <div class="grid grid-cols-1 gap-4 px-6 py-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($sdgs as $sdg)
            <a href="{{ route('admin_pemeringkatan.the-impact-cms.editor', $sdg->id) }}" class="group relative overflow-hidden rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                <span class="absolute inset-x-0 top-0 h-1.5" style="background-color: {{ $sdg->color }};"></span>
                <div class="relative flex items-start justify-between">
                    <div class="flex items-center gap-4">
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl text-2xl font-semibold text-white shadow-lg" style="background-color: {{ $sdg->color }};">
                            {{ $sdg->number }}
                        </span>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ $sdg->title }}</h3>
                            @if($sdg->subtitle)
                            <p class="mt-1 text-sm text-gray-500 line-clamp-2">{{ $sdg->subtitle }}</p>
                            @endif
                        </div>
                    </div>
                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 group-hover:bg-gray-200">
                        {{ $sdg->is_active ? 'Aktif' : 'Draft' }}
                    </span>
                </div>
                <div class="relative mt-6 flex items-center justify-between text-sm font-medium text-gray-600">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-file-alt text-indigo-500"></i>
                        {{ $sdg->contents_count ?? $sdg->contents->count() }} konten
                    </span>
                    <span class="flex items-center gap-2 text-indigo-600">
                        Kelola
                        <i class="fas fa-arrow-right transform transition-transform group-hover:translate-x-1"></i>
                    </span>
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function initializeSdgs() {
    Swal.fire({
        title: 'Inisialisasi 17 SDGs?',
        text: 'Ini akan membuat 17 SDG dengan data default',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Inisialisasi!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.post('{{ route('admin_pemeringkatan.the-impact-cms.initialize') }}')
                .then(response => {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.data.message,
                        icon: 'success'
                    }).then(() => {
                        window.location.reload();
                    });
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal menginisialisasi SDGs',
                        icon: 'error'
                    });
                });
        }
    });
}
</script>
@endpush

@endsection
