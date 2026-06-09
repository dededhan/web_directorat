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
                    <li class="flex items-center"><span class="font-medium text-gray-800">Edit Logbook</span></li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Edit Logbook Kegiatan</h1>
                    <p class="mt-2 text-gray-600 text-base">Proposal: {{ $submission->judul }}</p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('subdirektorat-inovasi.dosen.equity.logbook', $submission->id) }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200 shadow-sm">
                        <i class='bx bx-arrow-back mr-2 text-lg'></i> Kembali
                    </a>
                </div>
            </div>
        </header>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden max-w-3xl mx-auto">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-5 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-bold text-white flex items-center">
                    <i class='bx bx-edit mr-2 text-xl'></i> Edit Data Logbook
                </h3>
            </div>
            
            <form action="{{ route('subdirektorat-inovasi.dosen.logbook.update', $logbook->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="p-6 lg:p-8 space-y-6">
                    
                    @if($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
                            <ul class="list-disc list-inside text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kegiatan <span class="text-red-500">*</span></label>
                        <input type="date" name="activity_date" value="{{ old('activity_date', $logbook->activity_date->format('Y-m-d')) }}" class="w-full bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 @error('activity_date') border-red-500 @enderror" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Kegiatan <span class="text-red-500">*</span></label>
                        <textarea name="notes" rows="6" class="w-full bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 @error('notes') border-red-500 @enderror" required>{{ old('notes', $logbook->notes) }}</textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Persentase Capaian <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="number" name="progress_percentage" value="{{ old('progress_percentage', $logbook->progress_percentage) }}" min="0" max="100" class="w-full bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 @error('progress_percentage') border-red-500 @enderror" required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">%</span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ganti File Lampiran</label>
                            <input type="file" name="attachment" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 @error('attachment') border-red-500 @enderror">
                            <p class="text-xs text-gray-500 mt-2">Kosongkan jika tidak ingin mengubah file.</p>
                            @if($logbook->attachment_path)
                                <p class="text-xs text-teal-600 mt-1 flex items-center">
                                    <i class='bx bx-check-circle mr-1'></i> File saat ini: {{ basename($logbook->attachment_path) }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-6 py-5 border-t border-gray-200 flex items-center justify-end space-x-3 rounded-b-2xl">
                    <a href="{{ route('subdirektorat-inovasi.dosen.equity.logbook', $submission->id) }}" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white text-sm font-medium rounded-xl hover:from-teal-600 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 shadow-sm transition-all transform hover:scale-105">
                        <i class='bx bx-save mr-2'></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#dc2626'
            });
        @endif
    });
</script>
@endpush
@endsection
