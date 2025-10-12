@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')

<div class="mb-6 flex justify-between items-center">
    <div>
        <a href="{{ route('admin_pemeringkatan.the-impact-cms.dashboard') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
        <h1 class="text-3xl font-bold text-gray-800">
            <span class="inline-block w-12 h-12 rounded-full text-white flex items-center justify-center text-xl font-bold mr-3" 
                  style="background-color: {{ $sdg->color }};">{{ $sdg->number }}</span>
            {{ $sdg->title }}
        </h1>
        @if($sdg->subtitle)
        <p class="text-gray-600 mt-1 ml-14">{{ $sdg->subtitle }}</p>
        @endif
    </div>
    <a href="{{ route('admin_pemeringkatan.the-impact-cms.content.create', $sdg->id) }}" 
       class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition flex items-center">
        <i class="fas fa-plus mr-2"></i> Tambah Konten Root
    </a>
</div>

<!-- Content Tree -->
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-700">Struktur Konten (Dikelompokkan per Tahun)</h2>
        <span class="text-sm text-gray-500">Total: {{ $sdg->rootContents->count() }} konten root</span>
    </div>

    @if($sdg->rootContents->count() === 0)
        <div class="text-center py-16 border-2 border-dashed border-gray-300 rounded-lg">
            <i class="fas fa-folder-open text-6xl text-gray-400 mb-4"></i>
            <p class="text-gray-500 text-lg mb-2">Belum ada konten</p>
            <p class="text-gray-400 text-sm">Klik "Tambah Konten Root" untuk memulai</p>
        </div>
    @else
        <div class="space-y-2">
            @foreach($sdg->rootContents as $content)
                @include('admin_pemeringkatan.the_impact_cms.partials.content_item', ['content' => $content, 'sdg' => $sdg])
            @endforeach
        </div>
    @endif
</div>

<script>
function moveContentModal(contentId, currentPointNumber, sdgId, parentId) {
    Swal.fire({
        title: `Pindahkan Point ${currentPointNumber}`,
        html: `
            <div class="text-left">
                <p class="text-sm text-gray-600 mb-4">Masukkan posisi baru untuk point ini (angka urutan).</p>
                <label class="block text-sm font-medium text-gray-700 mb-2">Posisi Baru:</label>
                <input type="number" 
                       id="target-position" 
                       min="1" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                       placeholder="Contoh: 2 (untuk posisi ke-2)">
                <p class="text-xs text-gray-500 mt-2">
                    <i class="fas fa-info-circle"></i> Point akan dipindahkan ke posisi yang Anda tentukan, dan point number akan otomatis diperbarui.
                </p>
            </div>
        `,
        showCancelButton: true,
        confirmButtonColor: '#7c3aed',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-arrows-alt mr-2"></i> Pindahkan',
        cancelButtonText: 'Batal',
        preConfirm: () => {
            const position = document.getElementById('target-position').value;
            if (!position || position < 1) {
                Swal.showValidationMessage('Masukkan posisi yang valid (minimal 1)');
                return false;
            }
            return position;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const targetPosition = result.value;
            
            // Show loading
            Swal.fire({
                title: 'Memindahkan...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Send AJAX request
            fetch(`{{ url('admin_pemeringkatan/the-impact-cms/content') }}/${contentId}/move`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    target_position: parseInt(targetPosition)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        confirmButtonColor: '#10b981'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message,
                        confirmButtonColor: '#ef4444'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan: ' + error.message,
                    confirmButtonColor: '#ef4444'
                });
            });
        }
    });
}
</script>

@endsection
