@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li><a href="{{ route('admin_equity.employer-meetings.index') }}" class="hover:text-teal-600">Employer Meetings</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li class="font-medium text-gray-800">Detail Proposal</li>
                </ol>
            </nav>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Detail Pengajuan</h1>
                    <p class="mt-2 text-gray-600">Verifikasi dan ubah status pengajuan proposal.</p>
                </div>
                <a href="{{ route('admin_equity.employer-meetings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300">
                    <i class='bx bx-arrow-back mr-2'></i> Kembali
                </a>
            </div>
        </header>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column: Details --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg border p-6 sm:p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4 flex items-center">
                    <i class='bx bx-info-circle mr-3 text-teal-500 text-2xl'></i>
                    Informasi Proposal
                </h2>
                <div class="space-y-5">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Fakultas</label>
                        <p class="text-gray-800 font-semibold text-lg">{{ $submission->user->profile->fakultas->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Nama Pengunggah</label>
                        <p class="text-gray-800 text-lg">{{ $submission->nama_pengunggah }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Tanggal Pengajuan</label>
                        <p class="text-gray-800 text-lg">{{ $submission->created_at->isoFormat('dddd, D MMMM Y - HH:mm') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">File Proposal</label>
                        <a href="{{ Storage::url($submission->proposal_path) }}" target="_blank" class="flex items-center mt-1 text-teal-600 hover:text-teal-800 font-semibold">
                            <i class='bx bxs-file-pdf text-xl mr-2'></i>
                            Lihat Proposal.pdf
                        </a>
                    </div>
                     @if($submission->status == 'selesai' && $submission->bukti_keuangan_path)
                    <div class="border-t pt-5">
                        <label class="text-sm font-medium text-gray-500">File Bukti Keuangan</label>
                        <a href="{{ Storage::url($submission->bukti_keuangan_path) }}" target="_blank" class="flex items-center mt-1 text-teal-600 hover:text-teal-800 font-semibold">
                            <i class='bx bxs-file-pdf text-xl mr-2'></i>
                            Lihat Bukti_Keuangan.pdf
                        </a>
                    </div>
                    @endif
                    
                    {{-- Bagian Khusus untuk Menampilkan Nama Calon Responden --}}
                    @if(isset($submission->nama_calon_responden) && $submission->status == 'selesai')
                    <div class="border-t pt-5">
                        <label class="text-sm font-medium text-gray-500">Nama Calon Responden</label>
                        <p class="text-gray-800 text-lg whitespace-pre-wrap bg-gray-50 p-3 rounded-md">{{ $submission->nama_calon_responden }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Right Column: Actions --}}
            <div class="bg-white rounded-2xl shadow-lg border p-6 sm:p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4 flex items-center">
                    <i class='bx bx-edit mr-3 text-teal-500 text-2xl'></i>
                    Aksi Verifikasi
                </h2>
                <form action="{{ route('admin_equity.employer-meetings.updateStatus', $submission->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Saat Ini</label>
                            <div class="p-3 bg-gray-100 rounded-lg text-center font-bold text-gray-800">
                                {{ ucfirst($submission->status) }}
                            </div>
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Ubah Status Menjadi</label>
                            <select id="status" name="status" class="w-full text-gray-800 bg-gray-50 border border-gray-200 rounded-lg focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 p-3">
                                <option value="diverifikasi" {{ $submission->status == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                                <option value="disetujui" {{ $submission->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="ditolak" {{ $submission->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div>
                            <label for="catatan_admin" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                            <textarea id="catatan_admin" name="catatan_admin" rows="4" class="w-full text-gray-800 bg-gray-50 border border-gray-200 rounded-lg focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 p-3" placeholder="Berikan alasan jika ditolak...">{{ $submission->catatan_admin }}</textarea>
                        </div>
                        <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all">
                            <i class='bx bx-save text-lg mr-2'></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection