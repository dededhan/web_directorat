@extends('layouts.pemeringkatan')

@section('title', 'Kegiatan Sustainability')

@push('styles')
    @vite('resources/css/pemeringkatan/kegiatan-sustainability.css')
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">
                Kegiatan Sustainability
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Berbagai kegiatan berkelanjutan yang dilaksanakan oleh fakultas di Universitas Negeri Jakarta
            </p>
        </div>

        @if($sustainabilities->isEmpty())
            <div class="text-center py-16">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum ada kegiatan</h3>
                <p class="text-gray-500">Kegiatan sustainability akan ditampilkan di sini</p>
            </div>
        @else
            <!-- Faculty Sections -->
            <div class="space-y-12">
                @foreach($sustainabilities as $fakultas => $activities)
                    <div class="faculty-section">
                        <!-- Faculty Header -->
                        <div class="mb-6">
                            <div class="flex items-center space-x-4 mb-2">
                                <h2 class="text-3xl font-bold text-gray-900">{{ strtoupper($fakultas) }}</h2>
                                <span class="px-4 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                    {{ $activities->count() }} Kegiatan
                                </span>
                            </div>
                            <div class="h-1 w-24 bg-gradient-to-r from-blue-600 to-green-600 rounded-full"></div>
                        </div>

                        <!-- Activities Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($activities as $activity)
                                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col h-full">
                                    <!-- Activity Image -->
                                    <div class="relative h-48 overflow-hidden bg-gradient-to-br from-blue-500 to-green-500 flex-shrink-0">
                                        @if($activity->photos->count() > 0)
                                            <img src="{{ asset('storage/' . $activity->photos->first()->path) }}" 
                                                 alt="{{ $activity->judul_kegiatan }}" 
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-24 h-24 text-white/30" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="p-6 flex flex-col flex-grow">
                                        <!-- Badges -->
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($activity->tanggal_kegiatan)->format('d M Y') }}
                                            </span>
                                            @if($activity->prodi)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    {{ $activity->prodi }}
                                                </span>
                                            @endif
                                        </div>

                                        <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2">
                                            {{ $activity->judul_kegiatan }}
                                        </h3>

                                        <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-grow">
                                            {{ $activity->deskripsi_kegiatan }}
                                        </p>

                                        <div class="flex flex-wrap gap-2 mt-auto">
                                            <button onclick="showActivityDetail({{ json_encode($activity) }})" 
                                                    class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Lihat Detail
                                            </button>
                                            @if($activity->link_kegiatan)
                                                <a href="{{ $activity->link_kegiatan }}" 
                                                   target="_blank"
                                                   class="inline-flex items-center justify-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>



<!-- Activity Detail Modal -->
<div id="detail-modal" class="hidden fixed inset-0 z-[60] overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeDetailModal()"></div>

        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-white">Detail Kegiatan</h3>
                    <button onclick="closeDetailModal()" class="text-white hover:text-gray-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="bg-white px-6 py-6 max-h-[70vh] overflow-y-auto" id="detail-content">
                <!-- Content will be inserted by JavaScript -->
            </div>
        </div>
    </div>
</div>

<script>
function openModal(fakultas) {
    document.getElementById('modal-' + fakultas).classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal(fakultas) {
    document.getElementById('modal-' + fakultas).classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function showActivityDetail(activity) {
    const modal = document.getElementById('detail-modal');
    const content = document.getElementById('detail-content');
    
    let photosHtml = '';
    if (activity.photos && activity.photos.length > 0) {
        photosHtml = `
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Galeri Foto</h4>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    ${activity.photos.map(photo => `
                        <img src="/storage/${photo.path}" 
                             alt="${activity.judul_kegiatan}"
                             class="w-full h-48 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow cursor-pointer"
                             onclick="window.open('/storage/${photo.path}', '_blank')">
                    `).join('')}
                </div>
            </div>
        `;
    }

    const date = new Date(activity.tanggal_kegiatan);
    const formattedDate = date.toLocaleDateString('id-ID', { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    });

    content.innerHTML = `
        <div class="space-y-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">${activity.judul_kegiatan}</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="flex items-center space-x-3 text-gray-700">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-medium">${formattedDate}</span>
                    </div>
                    
                    <div class="flex items-center space-x-3 text-gray-700">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                        </svg>
                        <span class="font-medium">${activity.fakultas.toUpperCase()}</span>
                    </div>
                    
                    ${activity.prodi ? `
                        <div class="flex items-center space-x-3 text-gray-700">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="font-medium">${activity.prodi}</span>
                        </div>
                    ` : ''}
                    
                    ${activity.link_kegiatan ? `
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            <a href="${activity.link_kegiatan}" target="_blank" class="text-indigo-600 hover:text-indigo-800 font-medium underline">
                                Kunjungi Link Kegiatan
                            </a>
                        </div>
                    ` : ''}
                </div>
            </div>

            <div class="border-t pt-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi Kegiatan</h4>
                <p class="text-gray-700 leading-relaxed whitespace-pre-line">${activity.deskripsi_kegiatan}</p>
            </div>

            ${photosHtml}
        </div>
    `;
    
    modal.classList.remove('hidden');
}

function closeDetailModal() {
    document.getElementById('detail-modal').classList.add('hidden');
}

// Close modal on Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeDetailModal();
        @foreach($sustainabilities as $fakultas => $activities)
            closeModal('{{ $fakultas }}');
        @endforeach
    }
});
</script>
@endsection

@push('scripts')
    @vite('resources/js/pemeringkatan/kegiatan-sustainability.js')
@endpush