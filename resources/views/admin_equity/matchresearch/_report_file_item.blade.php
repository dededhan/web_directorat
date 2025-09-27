<div>
    <h3 class="text-sm font-medium text-gray-500">{{ $label }}</h3>
    @if($path)
        <a href="{{ Storage::url($path) }}" target="_blank" class="inline-flex items-center mt-2 px-3 py-1.5 bg-teal-50 text-teal-700 font-semibold rounded-lg hover:bg-teal-100 text-sm">
            <i class='bx bx-download mr-2'></i> Lihat/Unduh File
        </a>
    @else
        <p class="mt-2 text-sm text-gray-400 italic">Tidak diunggah</p>
    @endif
</div>
