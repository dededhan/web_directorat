@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">THE Impact Rankings CMS</h1>
    <p class="text-gray-600 mt-1">Kelola konten untuk 17 SDGs THE Impact Rankings</p>
</div>

<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-700">Pilih SDG untuk di-edit</h2>
        @if($sdgs->isEmpty())
        <button onclick="initializeSdgs()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
            <i class="fas fa-sync-alt mr-2"></i> Inisialisasi 17 SDGs
        </button>
        @endif
    </div>

    @if($sdgs->isEmpty())
    <div class="text-center py-16 border-2 border-dashed border-gray-300 rounded-lg">
        <i class="fas fa-database text-6xl text-gray-400 mb-4"></i>
        <p class="text-gray-500 text-lg mb-4">Belum ada SDG yang terinisialisasi</p>
        <p class="text-gray-400 text-sm">Klik tombol "Inisialisasi 17 SDGs" untuk memulai</p>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @foreach($sdgs as $sdg)
        <a href="{{ route('admin_pemeringkatan.the-impact-cms.editor', $sdg->id) }}" 
           class="group block p-6 rounded-lg shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105"
           style="background-color: {{ $sdg->color }};">
            <div class="text-white">
                <div class="flex justify-between items-start mb-3">
                    <span class="text-4xl font-bold opacity-90">{{ $sdg->number }}</span>
                    <i class="fas fa-edit text-2xl opacity-0 group-hover:opacity-100 transition-opacity"></i>
                </div>
                <h3 class="text-lg font-bold mb-2">{{ $sdg->title }}</h3>
                @if($sdg->subtitle)
                <p class="text-sm opacity-90 line-clamp-2">{{ $sdg->subtitle }}</p>
                @endif
                <div class="mt-4 flex items-center justify-between">
                    <span class="text-sm opacity-75">
                        <i class="fas fa-file-alt mr-1"></i> {{ $sdg->contents->count() }} konten
                    </span>
                    <span class="text-sm font-semibold opacity-90 group-hover:opacity-100">
                        Kelola <i class="fas fa-arrow-right ml-1"></i>
                    </span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endif
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
