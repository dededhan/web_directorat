@php
$statusConfig = [
    'draft' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => 'Draft'],
    'diajukan' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Diajukan'],
    'menunggu_verifikasi' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Menunggu Verifikasi'],
    'diterima' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Diterima'],
    'ditolak' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Ditolak'],
    'menunggu_direview' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'label' => 'Menunggu Direview'],
    'sedang_direview' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-800', 'label' => 'Sedang Direview'],
    'lolos' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-800', 'label' => 'Lolos'],
    'tidak_lolos' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-800', 'label' => 'Tidak Lolos'],
];
$config = $statusConfig[$status] ?? $statusConfig['draft'];
@endphp

<span class="px-3 py-1 text-xs font-semibold rounded-full {{ $config['bg'] }} {{ $config['text'] }}">
    {{ $config['label'] }}
</span>
