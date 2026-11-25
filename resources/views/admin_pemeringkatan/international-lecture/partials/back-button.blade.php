@php
    $backRoute = $backRoute ?? 'admin_pemeringkatan.international-lecture.index';
    $backParams = $backParams ?? (request('from_table') ? ['table' => 1] : []);
    $backLabel = $backLabel ?? 'Kembali';
@endphp

<a href="{{ route($backRoute, $backParams) }}"
   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-colors duration-150 mb-2">
    <i class="fas fa-arrow-left text-xs"></i>
    <span>{{ $backLabel }}</span>
</a>
