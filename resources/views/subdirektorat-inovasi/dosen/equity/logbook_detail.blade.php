@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Breadcrumb dan Judul --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li class="flex items-center"><a href="#" class="hover:text-teal-600 transition-colors duration-200">Home</a><i class='bx bx-chevron-right text-base text-gray-400 mx-2'></i></li>
                    <li class="flex items-center"><a href="#" class="hover:text-teal-600 transition-colors duration-200">Manajemen Proposal</a><i class='bx bx-chevron-right text-base text-gray-400 mx-2'></i></li>
                    <li class="flex items-center"><a href="{{ route('subdirektorat-inovasi.dosen.equity.logbook', $submission->id) }}" class="hover:text-teal-600 transition-colors duration-200">Logbook Kegiatan</a><i class='bx bx-chevron-right text-base text-gray-400 mx-2'></i></li>
                    <li class="flex items-center"><span class="font-medium text-gray-800">Detail Logbook</span></li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Detail Logbook Kegiatan</h1>
                    <p class="mt-2 text-gray-600 text-base">Proposal: {{ $submission->judul }}</p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('subdirektorat-inovasi.dosen.equity.logbook', $submission->id) }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200 shadow-sm">
                        <i class='bx bx-arrow-back mr-2 text-lg'></i> Kembali
                    </a>
                </div>
            </div>
        </header>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-5 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-bold text-white flex items-center">
                    <i class='bx bx-list-check mr-2 text-xl'></i> Informasi Logbook
                </h3>
            </div>
            
            <div class="p-6 lg:p-8 space-y-6">
                <div>
                    <span class="text-sm font-semibold text-gray-500 uppercase tracking-wider block mb-2">Tanggal Kegiatan</span>
                    <p class="text-gray-900 font-medium flex items-center bg-gray-50 p-3 rounded-lg border border-gray-200 w-fit">
                        <i class='bx bx-calendar text-orange-500 mr-2 text-lg'></i>
                        {{ $logbook->activity_date->format('d F Y') }}
                    </p>
                </div>
                
                <div>
                    <span class="text-sm font-semibold text-gray-500 uppercase tracking-wider block mb-2">Persentase Capaian</span>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col items-start w-full max-w-md">
                        <span class="text-3xl font-bold text-teal-600 mb-2">{{ $logbook->progress_percentage }}%</span>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-teal-500 h-3 rounded-full" style="width: {{ $logbook->progress_percentage }}%"></div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <span class="text-sm font-semibold text-gray-500 uppercase tracking-wider block mb-2">Catatan Kegiatan</span>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 min-h-[100px] text-gray-800 whitespace-pre-wrap leading-relaxed">
                        {{ $logbook->notes }}
                    </div>
                </div>
                
                <div>
                    <span class="text-sm font-semibold text-gray-500 uppercase tracking-wider block mb-2">File Lampiran</span>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 w-fit">
                        @if($logbook->attachment_path)
                            <a href="{{ Storage::url($logbook->attachment_path) }}" target="_blank" class="flex items-center text-blue-600 hover:text-blue-800 hover:underline">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3 shrink-0">
                                    <i class='bx bx-file-blank text-2xl'></i>
                                </div>
                                <span class="font-medium text-base">{{ basename($logbook->attachment_path) }}</span>
                            </a>
                        @else
                            <div class="flex items-center text-gray-500">
                                <i class='bx bx-hide mr-2 text-xl'></i>
                                <span class="text-base italic">Tidak ada file lampiran</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 px-6 py-5 border-t border-gray-200 flex justify-end space-x-3">
                <a href="{{ route('subdirektorat-inovasi.dosen.logbook.edit', $logbook->id) }}" class="inline-flex items-center px-5 py-2.5 bg-teal-500 text-white font-semibold rounded-xl hover:bg-teal-600 transition-colors shadow-sm">
                    <i class='bx bx-edit mr-2 text-lg'></i> Edit Logbook
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
