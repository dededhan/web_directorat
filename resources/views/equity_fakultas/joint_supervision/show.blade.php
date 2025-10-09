@extends('equity_fakultas.index')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <h3 class="text-3xl font-medium text-gray-700">Detail Proposal: Joint Supervision</h3>
        <a href="{{ route('equity_fakultas.joint-supervision.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-bold rounded-lg shadow-md transition-colors duration-200">
            <i class='bx bx-arrow-back mr-2'></i>
            Kembali
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6">
        <!-- Informasi Umum -->
        <div class="mb-6 pb-6 border-b border-gray-200">
            <h4 class="text-xl font-semibold text-gray-800 mb-4">Informasi Umum</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Nama Pengunggah</p>
                    <p class="text-base font-medium text-gray-900">{{ $submission->nama_pengunggah }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Fakultas</p>
                    <p class="text-base font-medium text-gray-900">{{ $submission->user->profile?->fakultas?->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Tanggal Diajukan</p>
                    <p class="text-base font-medium text-gray-900">{{ $submission->created_at->format('d F Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Status</p>
                    <span class="inline-block px-3 py-1 font-semibold leading-tight rounded-full @switch($submission->status) @case('diajukan') bg-blue-100 text-blue-900 @break @case('menunggu diverifikasi') bg-purple-100 text-purple-900 @break @case('diverifikasi') bg-yellow-100 text-yellow-900 @break @case('disetujui') bg-green-100 text-green-900 @break @case('ditolak') bg-red-100 text-red-900 @break @case('selesai') bg-gray-200 text-gray-800 @break @endswitch">
                        {{ ucfirst($submission->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- File Proposal -->
        <div class="mb-6 pb-6 border-b border-gray-200">
            <h4 class="text-xl font-semibold text-gray-800 mb-4">File Proposal</h4>
            <div class="flex items-center gap-3">
                @if($submission->proposal_path)
                    @php
                        $extension = pathinfo($submission->proposal_path, PATHINFO_EXTENSION);
                        $icon = in_array(strtolower($extension), ['xlsx', 'xls']) ? 'bx-spreadsheet' : 'bxs-file-pdf';
                        $color = in_array(strtolower($extension), ['xlsx', 'xls']) ? 'text-green-600' : 'text-red-600';
                    @endphp
                    <i class='bx {{ $icon }} text-3xl {{ $color }}'></i>
                    <div>
                        <p class="text-base font-medium text-gray-900">{{ basename($submission->proposal_path) }}</p>
                        <a href="{{ Storage::url($submission->proposal_path) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 hover:underline">
                            <i class='bx bx-download'></i> Download File
                        </a>
                    </div>
                @else
                    <p class="text-gray-500">Tidak ada file proposal</p>
                @endif
            </div>
        </div>

        <!-- Catatan Admin (jika ada) -->
        @if($submission->catatan_admin)
        <div class="mb-6 pb-6 border-b border-gray-200">
            <h4 class="text-xl font-semibold text-gray-800 mb-4">Catatan dari Admin</h4>
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                <p class="text-sm text-yellow-800">{{ $submission->catatan_admin }}</p>
            </div>
        </div>
        @endif

        <!-- Data Tambahan (jika sudah diisi) -->
        @if($submission->status == 'selesai')
        <div class="mb-6 pb-6 border-b border-gray-200">
            <h4 class="text-xl font-semibold text-gray-800 mb-4">Data Laporan</h4>

            <!-- File Bukti Keuangan -->
            @if($submission->bukti_keuangan_path)
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-2">Bukti Keuangan</p>
                <div class="flex items-center gap-3">
                    <i class='bx bxs-file-pdf text-3xl text-red-600'></i>
                    <div>
                        <p class="text-base font-medium text-gray-900">{{ basename($submission->bukti_keuangan_path) }}</p>
                        <a href="{{ Storage::url($submission->bukti_keuangan_path) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 hover:underline">
                            <i class='bx bx-download'></i> Download File
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- File Laporan Kegiatan -->
            @if($submission->laporan_kegiatan_path)
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-2">Laporan Kegiatan</p>
                <div class="flex items-center gap-3">
                    <i class='bx bxs-file-pdf text-3xl text-red-600'></i>
                    <div>
                        <p class="text-base font-medium text-gray-900">{{ basename($submission->laporan_kegiatan_path) }}</p>
                        <a href="{{ Storage::url($submission->laporan_kegiatan_path) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 hover:underline">
                            <i class='bx bx-download'></i> Download File
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Timeline Status -->
        <div class="mb-6">
            <h4 class="text-xl font-semibold text-gray-800 mb-4">Timeline</h4>
            <div class="relative">
                <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-300"></div>
                
                <div class="relative flex items-start mb-4 pl-12">
                    <div class="absolute left-0 w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center">
                        <i class='bx bx-check text-white'></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Proposal Diajukan</p>
                        <p class="text-sm text-gray-600">{{ $submission->created_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>

                @if($submission->is_confirmed)
                <div class="relative flex items-start mb-4 pl-12">
                    <div class="absolute left-0 w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center">
                        <i class='bx bx-check text-white'></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Dikonfirmasi & Dikirim ke Admin</p>
                        <p class="text-sm text-gray-600">{{ $submission->updated_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>
                @endif

                @if(in_array($submission->status, ['diverifikasi', 'disetujui', 'ditolak', 'selesai']))
                <div class="relative flex items-start mb-4 pl-12">
                    <div class="absolute left-0 w-8 h-8 rounded-full {{ $submission->status == 'ditolak' ? 'bg-red-500' : 'bg-yellow-500' }} flex items-center justify-center">
                        <i class='bx bx-check text-white'></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $submission->status == 'ditolak' ? 'Ditolak' : 'Diverifikasi' }}</p>
                        <p class="text-sm text-gray-600">{{ $submission->updated_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>
                @endif

                @if(in_array($submission->status, ['disetujui', 'selesai']))
                <div class="relative flex items-start mb-4 pl-12">
                    <div class="absolute left-0 w-8 h-8 rounded-full bg-green-500 flex items-center justify-center">
                        <i class='bx bx-check text-white'></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Disetujui</p>
                        <p class="text-sm text-gray-600">{{ $submission->updated_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>
                @endif

                @if($submission->status == 'selesai')
                <div class="relative flex items-start pl-12">
                    <div class="absolute left-0 w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center">
                        <i class='bx bx-check text-white'></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Selesai</p>
                        <p class="text-sm text-gray-600">{{ $submission->updated_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
