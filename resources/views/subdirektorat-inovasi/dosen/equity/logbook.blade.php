{{-- file: resources/views/subdirektorat-inovasi/dosen/logbook.blade.php --}}

@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="{ showForm: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Breadcrumb dan Judul --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li class="flex items-center"><a href="#" class="hover:text-teal-600 transition-colors duration-200">Home</a><i class='bx bx-chevron-right text-base text-gray-400 mx-2'></i></li>
                    <li class="flex items-center"><a href="#" class="hover:text-teal-600 transition-colors duration-200">Manajemen Proposal</a><i class='bx bx-chevron-right text-base text-gray-400 mx-2'></i></li>
                    <li class="flex items-center"><span class="font-medium text-gray-800" x-text="showForm ? 'Tambah Logbook Kegiatan' : 'Logbook Kegiatan'"></span></li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Logbook Kegiatan</h1>
                    {{-- PERUBAHAN: Judul proposal diambil dari database --}}
                    <p class="mt-2 text-gray-600 text-base">Proposal: {{ $submission->judul }}</p>
                </div>
                <div class="flex-shrink-0">
                    <button @click="showForm = !showForm" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class='bx' :class="showForm ? 'bx-arrow-back' : 'bx-plus-circle'" class="mr-2 text-lg"></i>
                        <span x-text="showForm ? 'Kembali' : 'Tambah Logbook Kegiatan'"></span>
                    </button>
                </div>
            </div>
        </header>

        {{-- Tampilan Tabel Logbook --}}
        <div x-show="!showForm" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-visible">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                    <div class="flex items-center justify-between text-white">
                        <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                            <i class='bx bx-list-ul mr-3 text-2xl'></i>
                            Manajemen Data Logbook Kegiatan
                        </h2>
                        <div class="text-teal-100 text-sm">
                            {{-- PERUBAHAN: Jumlah kegiatan diambil dari database --}}
                            Total: <span class="font-semibold text-white">{{ $logbooks->count() }} kegiatan</span>
                        </div>
                    </div>
                    {{-- PERUBAHAN: Judul proposal diambil dari database --}}
                    <p class="text-teal-100 mt-1">{{ $submission->judul }}</p>
                </div>

                {{-- PERUBAHAN: Cek jika tidak ada data logbook --}}
                @if($logbooks->isEmpty())
                    <div class="text-center py-12 px-6">
                        <i class='bx bx-data text-6xl text-gray-300'></i>
                        <h3 class="mt-4 text-lg font-semibold text-gray-700">Belum Ada Data</h3>
                        <p class="mt-1 text-gray-500">Belum ada catatan logbook untuk proposal ini. Silakan tambahkan.</p>
                    </div>
                @else
                    {{-- Desktop Table View --}}
                    <div class="hidden lg:block overflow-visible">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    {{-- Headers tetap sama --}}
                                    <th class="px-4 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-[5%]">No.</th>
                                    <th class="px-4 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-[15%]">Tgl Kegiatan</th>
                                    <th class="px-4 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-[35%]">Catatan</th>
                                    <th class="px-4 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-[15%]">Persen Capaian</th>
                                    <th class="px-4 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-[10%]">Opsi</th>
                                    <th class="px-4 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-[20%]">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                {{-- PERUBAHAN: Looping data logbook dari database --}}
                                @foreach($logbooks as $logbook)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-4 py-5 text-sm text-gray-900 align-middle">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-5 text-sm text-gray-900 align-middle">
                                        <div class="flex items-center">
                                            <i class='bx bx-time text-orange-500 mr-2'></i>
                                            {{ $logbook->activity_date->format('d F Y') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-5 text-sm text-gray-900 break-words align-middle">{{ $logbook->notes }}</td>
                                    <td class="px-4 py-5 text-sm text-gray-900 align-middle">
                                        <div class="flex items-center">
                                            <i class='bx bx-line-chart text-teal-500 mr-2'></i>
                                            {{ $logbook->progress_percentage }}%
                                        </div>
                                    </td>
                                    <td class="px-4 py-5 text-center align-middle">
                                        {{-- Tombol Opsi (jika diperlukan) --}}
                                    </td>
                                    <td class="px-4 py-5 text-center space-x-2 align-middle">
                                        {{-- Tombol Aksi (Detail, Edit, Hapus) --}}
                                        <button class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-md hover:bg-blue-600">Detail</button>
                                        <button class="inline-flex items-center px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-md hover:bg-green-600">Edit</button>
                                        <button class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-md hover:bg-red-600">Hapus</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile Card View --}}
                    <div class="lg:hidden divide-y divide-gray-200">
                        {{-- PERUBAHAN: Looping data logbook untuk tampilan mobile --}}
                        @foreach($logbooks as $logbook)
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-start space-x-3 flex-1 min-w-0">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                                            <i class='bx bx-list-ul text-blue-500 text-lg'></i>
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3 class="font-semibold text-gray-900 text-sm leading-snug mb-1 break-words">{{ $logbook->notes }}</h3>
                                        <p class="text-xs text-gray-500 flex items-center">
                                            <i class='bx bx-calendar text-xs mr-1 text-orange-500'></i>
                                            {{ $logbook->activity_date->format('d F Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                                <div>
                                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Persen Capaian</span>
                                    <p class="text-gray-900 font-medium flex items-center">
                                        <i class='bx bx-line-chart text-teal-500 text-xs mr-1'></i>
                                        {{ $logbook->progress_percentage }}%
                                    </p>
                                </div>
                            </div>
                            {{-- Tombol Opsi Mobile --}}
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Form Tambah Logbook --}}
        <div x-show="showForm" style="display: none;">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                    <h2 class="text-xl lg:text-2xl font-bold text-white flex items-center">Form Logbook Kegiatan</h2>
                    <p class="text-teal-100 mt-1">Isi semua form di bawah dengan benar</p>
                </div>
                <div class="p-6 lg:p-8">
                    {{-- PERUBAHAN: Form action dan method ditambahkan --}}
                    <form action="{{ route('subdirektorat-inovasi.dosen.logbook.store', $submission->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        {{-- PERUBAHAN: CSRF Token untuk keamanan --}}
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Judul Proposal</label>
                            <p class="w-full bg-gray-100 rounded-lg p-3 text-sm text-gray-800 font-semibold">{{ $submission->judul }}</p>
                        </div>
                        <div>
                            <label for="activity_date" class="block text-sm font-medium text-gray-600 mb-1">Tanggal Kegiatan</label>
                            <input type="date" id="activity_date" name="activity_date" class="w-full md:w-1/2 bg-white border border-gray-200 rounded-lg" required>
                        </div>
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-600 mb-1">Catatan</label>
                            <textarea id="notes" name="notes" rows="4" class="w-full bg-white border border-gray-200 rounded-lg" required></textarea>
                        </div>
                        <div>
                            <label for="attachment" class="block text-sm font-medium text-gray-600 mb-1">File Lampiran (Opsional)</label>
                            <input type="file" id="attachment" name="attachment" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                            <p class="text-xs text-gray-500 mt-1">PDF, DOCX, XLSX, PNG, JPG hingga 2MB</p>
                        </div>
                        <div>
                            <label for="progress_percentage" class="block text-sm font-medium text-gray-600 mb-1">Persentase Capaian Fisik</label>
                            <div class="relative w-full md:w-1/2">
                                <input type="number" id="progress_percentage" name="progress_percentage" placeholder="0" min="0" max="100" class="w-full bg-white border border-gray-200 rounded-lg" required>
                                <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm text-gray-500">%</span>
                            </div>
                        </div>
                        <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-end gap-3">
                            <button @click="showForm = false" type="button" class="px-5 py-2 bg-white border border-gray-200 text-gray-800 text-sm font-semibold rounded-lg">Batal</button>
                            <button type="submit" class="px-5 py-2 bg-gradient-to-r from-teal-500 to-teal-600 text-white text-sm font-semibold rounded-lg">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection