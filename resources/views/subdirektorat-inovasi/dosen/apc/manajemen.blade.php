@extends('subdirektorat-inovasi.dosen.index')

@php
    // Fungsi helper untuk status, bisa dipindahkan ke file helper jika digunakan di banyak tempat
    if (!function_exists('getStatusInfoDosen')) {
        function getStatusInfoDosen($status)
        {
            switch ($status) {
                case 'diajukan':
                    return ['color' => 'blue', 'icon' => 'bx-info-circle', 'text' => 'Diajukan'];
                case 'verifikasi':
                    return ['color' => 'yellow', 'icon' => 'bx-search-alt', 'text' => 'Verifikasi'];
                case 'disetujui':
                    return ['color' => 'green', 'icon' => 'bx-check-circle', 'text' => 'Disetujui'];
                case 'ditolak':
                    return ['color' => 'red', 'icon' => 'bx-x-circle', 'text' => 'Ditolak'];
                default:
                    return ['color' => 'gray', 'icon' => 'bx-question-mark', 'text' => 'Unknown'];
            }
        }
    }
@endphp

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">
        <div class="max-w-7xl mx-auto" x-data="{ showDeleteModal: false, deleteUrl: '', showDetailModal: false, detailSubmission: null }">
            {{-- Header --}}
            <header class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Manajemen Proposal APC</h1>
                    <p class="mt-2 text-gray-600">Daftar semua proposal Article Processing Cost yang telah Anda ajukan.</p>
                </div>
                <a href="{{ route('subdirektorat-inovasi.dosen.apc.list-sesi') }}"
                    class="inline-flex items-center px-4 py-2.5 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700 transition-colors shadow-md hover:shadow-lg whitespace-nowrap">
                    <i class='bx bx-plus-circle mr-2'></i>
                    Usulkan Proposal Baru
                </a>
            </header>

            {{-- Notifikasi --}}
            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg" role="alert">
                    <p class="font-bold">Sukses</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                    <p class="font-bold">Gagal</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            {{-- Daftar Proposal Berdasarkan Sesi --}}
            <div class="space-y-8">
                @forelse ($groupedSubmissions as $sessionId => $submissions)
                    @php
                        $session = $submissions->first()->session;
                        $isSessionOpen = $session->computed_status === 'Buka';
                    @endphp
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        {{-- Header Sesi --}}
                        <div
                            class="p-5 bg-gray-50 border-b flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                            <div>
                                <h2 class="text-xl font-bold text-teal-700">{{ $session->nama_sesi }}</h2>
                                <p class="text-sm text-gray-500 mt-1">{{ $session->deskripsi }}</p>
                            </div>
                            <div
                                class="text-sm text-center sm:text-right {{ $isSessionOpen ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} font-semibold px-4 py-2 rounded-lg">
                                @if ($isSessionOpen)
                                    Batas Akhir:
                                    {{ \Carbon\Carbon::parse($session->periode_akhir)->isoFormat('D MMMM YYYY') }}
                                @else
                                    Sesi Ditutup
                                @endif
                            </div>
                        </div>

                        {{-- Tabel Proposal --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            Jurnal & Judul Artikel</th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($submissions as $submission)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="font-semibold text-gray-800">{{ $submission->nama_jurnal_q1 }}
                                                </div>
                                                <div class="text-sm text-gray-500 mt-1">{{ $submission->judul_artikel }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                @php
                                                    $displayStatus = $submission->status;
                                                    if (!$isSessionOpen && $submission->status === 'diajukan') {
                                                        $displayStatus = 'verifikasi';
                                                    }
                                                    $status = getStatusInfoDosen($displayStatus);
                                                @endphp
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-800">
                                                    <i class='bx {{ $status['icon'] }} mr-1.5'></i>
                                                    {{ $status['text'] }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex justify-center items-center gap-2">
                                                    <button
                                                        @click="showDetailModal = true; detailSubmission = {{ $submission->toJson() }}"
                                                        class="text-gray-500 hover:text-teal-600" title="Lihat Detail">
                                                        <i class='bx bx-show-alt text-xl'></i>
                                                    </button>
                                                    @if ($isSessionOpen && $submission->status === 'diajukan')
                                                        <a href="{{ route('subdirektorat-inovasi.dosen.apc.edit', $submission->id) }}"
                                                            class="text-blue-600 hover:text-blue-800" title="Edit Proposal">
                                                            <i class='bx bxs-edit text-xl'></i>
                                                        </a>
                                                        <button
                                                            @click="showDeleteModal = true; deleteUrl = '{{ route('subdirektorat-inovasi.dosen.apc.destroy', $submission->id) }}'"
                                                            class="text-red-600 hover:text-red-800" title="Hapus Proposal">
                                                            <i class='bx bxs-trash-alt text-xl'></i>
                                                        </button>
                                                    @else
                                                        <span class="text-gray-400 cursor-not-allowed"
                                                            title="Aksi terkunci karena sesi telah ditutup"><i
                                                                class='bx bxs-lock text-xl'></i></span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 bg-white rounded-2xl shadow-lg border">
                        <i class='bx bx-data text-6xl text-gray-300'></i>
                        <h3 class="mt-4 text-xl font-semibold text-gray-700">Anda belum memiliki proposal.</h3>
                        <p class="mt-2 text-gray-500">Silakan usulkan proposal baru melalui sesi yang tersedia.</p>
                    </div>
                @endforelse
            </div>

            <!-- Modal Konfirmasi Hapus -->
            <div x-show="showDeleteModal" x-cloak @keydown.escape.window="showDeleteModal = false"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                <div @click.away="showDeleteModal = false" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
                    <h3 class="text-lg font-bold text-gray-900">Konfirmasi Hapus</h3>
                    <p class="mt-2 text-sm text-gray-600">Apakah Anda yakin ingin menghapus proposal ini? Tindakan ini tidak
                        dapat dibatalkan.</p>
                    <form :action="deleteUrl" method="POST" class="mt-6 flex justify-end gap-4">
                        @csrf
                        @method('DELETE')
                        <button type="button" @click="showDeleteModal = false"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Ya,
                            Hapus</button>
                    </form>
                </div>
            </div>

            <!-- Modal Detail Proposal -->
            <div x-show="showDetailModal" x-cloak @keydown.escape.window="showDetailModal = false"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                <div @click.away="showDetailModal = false"
                    class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col">
                    <div class="p-6 border-b">
                        <h3 class="text-xl font-bold text-gray-900">Detail Proposal</h3>
                    </div>
                    <div class="p-6 space-y-6 overflow-y-auto">
                        {{-- Detail Info --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                            <div>
                                <p class="text-xs font-bold uppercase text-gray-500">Judul Artikel</p>
                                <p class="mt-1 text-gray-800 font-semibold" x-text="detailSubmission?.judul_artikel"></p>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase text-gray-500">Nama Jurnal (Q1)</p>
                                <p class="mt-1 text-gray-800" x-text="detailSubmission?.nama_jurnal_q1"></p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="text-xs font-bold uppercase text-gray-500">Link ScimagoJR</p>
                                <a :href="detailSubmission?.link_scimagojr" target="_blank"
                                    class="mt-1 text-teal-600 hover:underline break-all"
                                    x-text="detailSubmission?.link_scimagojr"></a>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase text-gray-500">Volume & Issue</p>
                                <p class="mt-1 text-gray-800"
                                    x-text="`Volume ${detailSubmission?.volume || '-'}, Issue ${detailSubmission?.issue || '-'}`">
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase text-gray-500">Biaya Diajukan</p>
                                <p class="mt-1 text-base font-bold text-red-600"
                                    x-text="`Rp ${new Intl.NumberFormat('id-ID').format(detailSubmission?.biaya_publikasi)}`">
                                </p>
                            </div>
                        </div>
                        {{-- Daftar Penulis --}}
                        <div class="border-t pt-4">
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-2">Daftar Penulis</h4>
                            <ul class="space-y-2">
                                <template x-for="author in detailSubmission?.authors.sort((a, b) => a.urutan - b.urutan)"
                                    :key="author.id">
                                    <li class="flex items-start bg-gray-50 p-2 rounded-md text-sm">
                                        <span class="font-bold text-gray-600 mr-2" x-text="`${author.urutan}.`"></span>
                                        <div>
                                            <p class="font-semibold text-gray-800" x-text="author.nama"></p>
                                            <p class="text-xs text-gray-500" x-text="author.afiliasi"></p>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </div>
                        {{-- Dokumen --}}
                        <div class="border-t pt-4">
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-2">Dokumen Pendukung</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <a :href="`/storage/${detailSubmission?.artikel_path}`" target="_blank"
                                    class="flex items-center p-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                                    <i class='bx bxs-file-pdf text-red-500 text-lg mr-2'></i> Artikel
                                </a>
                                <a :href="`/storage/${detailSubmission?.invoice_path}`" target="_blank"
                                    class="flex items-center p-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                                    <i class='bx bxs-file-image text-yellow-500 text-lg mr-2'></i> Invoice
                                </a>
                                <a :href="`/storage/${detailSubmission?.submission_process_path}`" target="_blank"
                                    class="flex items-center p-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                                    <i class='bx bxs-file-archive text-blue-500 text-lg mr-2'></i> Bukti Proses
                                </a>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <h4 class="text-xs font-bold uppercase text-gray-500 mb-3">Riwayat Status</h4>
                            <ul class="space-y-3 border-l-2 border-gray-200 ml-2">
                                <template x-if="detailSubmission && detailSubmission.status_history">
                                    <template x-for="(log, index) in detailSubmission.status_history.slice().reverse()"
                                        :key="index">
                                        <li class="relative pl-6">
                                            <div class="absolute -left-[7px] top-1.5 w-3 h-3 bg-gray-300 rounded-full">
                                            </div>
                                            <p class="font-semibold text-gray-800 text-sm"
                                                x-text="`Status berubah menjadi '${log.status}'`"></p>
                                            <p class="text-xs text-gray-500"
                                                x-text="new Date(log.timestamp).toLocaleString('id-ID', { dateStyle: 'long', timeStyle: 'short' })">
                                            </p>
                                            <p class="text-xs text-gray-500 italic mt-1" x-text="log.notes"
                                                x-show="log.notes"></p>
                                        </li>
                                    </template>
                                </template>
                                <template
                                    x-if="!detailSubmission || !detailSubmission.status_history || detailSubmission.status_history.length === 0">
                                    <li class="relative pl-6 text-sm text-gray-500">Tidak ada riwayat.</li>
                                </template>
                            </ul>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 border-t flex justify-end">
                        <button @click="showDetailModal = false"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 text-sm font-semibold">Tutup</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
