@extends('subdirektorat-inovasi.dosen.index')

@section('content')
    {{-- PERUBAHAN 1: Sederhanakan state Alpine.js untuk langsung mengontrol tipe input --}}
    <div x-data="{
        isModalOpen: false,
        modalTitle: '',
        formAction: '',
        isLinkOnly: false, // State baru: true jika ini khusus untuk link
        judulLuaran: '', // <-- State baru
        statusLuaran: '',
    
        openModal(title, action, isLink = false, judul = '', status = '') { // Parameter diubah menjadi isLink
            this.modalTitle = title;
            this.formAction = action;
            this.isModalOpen = true;
            this.isLinkOnly = isLink;
            this.judulLuaran = judul;
            this.statusLuaran = status;
    
        }
    }">

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- ... (Seluruh bagian header, notifikasi, dan card modul tidak berubah) ... --}}
            <div class="flex flex-wrap justify-between items-center gap-4 mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Tahapan Proposal</h1>
                    <nav class="text-sm" aria-label="Breadcrumb">
                        <ol class="list-none p-0 inline-flex space-x-2 text-gray-500">
                            <li class="flex items-center">
                                <a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}"
                                    class="hover:text-gray-700">Dashboard</a>
                                <i class='bx bx-chevron-right text-gray-400 mx-2'></i>
                            </li>
                            <li class="flex items-center">
                                <a href="{{ route('subdirektorat-inovasi.dosen.equity.manajement.index') }}"
                                    class="hover:text-gray-700">Manajemen Proposal</a>
                                <i class='bx bx-chevron-right text-gray-400 mx-2'></i>
                            </li>
                            <li class="flex items-center">
                                <span class="font-medium">Tahapan Proposal</span>
                            </li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('subdirektorat-inovasi.dosen.equity.manajement.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg shadow-sm hover:bg-gray-50 transition-colors duration-200">
                    <i class='bx bx-arrow-back mr-2'></i>
                    <span>Kembali</span>
                </a>
            </div>
            <div class="bg-gray-50 border border-gray-200 p-6 rounded-lg mb-8">
                <h2 class="text-xl font-semibold text-gray-800">Tahap Penilaian Proposal: {{ $submission->judul }}</h2>
                <p class="text-gray-600 mt-2">Silahkan ikuti tahap penilaian proposal pada menu ini. Beberapa tahap memiliki
                    persyaratan yang perlu dipenuhi.</p>
            </div>
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p class="font-bold">Terjadi Kesalahan:</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="list-disc ml-4">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="space-y-12">
                @php
                    $uploadedFiles = $submission->files->keyBy('comdev_sub_chapter_id');
                @endphp
                @forelse ($modules as $module)
                    <div class="flex items-start gap-4 md:gap-6">
                        <div
                            class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-[#3A4D8F] text-white rounded-full font-bold text-lg ring-4 ring-white sticky top-8">
                            {{ $loop->iteration }}
                        </div>
                        <div class="w-full bg-white rounded-xl shadow-lg overflow-hidden" x-data="{ tab: 'syarat' }">
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-gray-800">{{ $module->nama_modul }}</h3>
                                <p class="text-sm text-gray-500 mt-1">{{ $module->deskripsi }}</p>
                            </div>
                            <div class="border-b border-gray-200">
                                <nav class="-mb-px flex px-6">
                                    <a href="#" @click.prevent="tab = 'syarat'"
                                        :class="{ 'border-blue-500 text-blue-600': tab === 'syarat', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'syarat' }"
                                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Syarat</a>
                                    <a href="#" @click.prevent="tab = 'penilaian'"
                                        :class="{ 'border-blue-500 text-blue-600': tab === 'penilaian', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'penilaian' }"
                                        class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm">Penilaian</a>
                                </nav>
                            </div>
                            <div class="p-6">
                                <div x-show="tab === 'syarat'" x-transition>
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-sm text-left text-gray-500">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3">Jenis Dokumen</th>
                                                    <th scope="col" class="px-6 py-3">Status</th>
                                                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($module->subChapters as $subChapter)
                                                    @if ($subChapter)
                                                        @php
                                                            $userFile = $uploadedFiles->get($subChapter->id);
                                                            $isSesiAktif =
                                                                $subChapter->periode_awal &&
                                                                $subChapter->periode_akhir &&
                                                                \Carbon\Carbon::now()->isBefore(
                                                                    $subChapter->periode_akhir,
                                                                );
                                                            $isLinkType = str_contains(
                                                                strtolower($subChapter->nama_sub_bab),
                                                                'link',
                                                            );
                                                        @endphp
                                                        <tr class="bg-white border-b">
                                                            <td
                                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                                <div>{{ $subChapter->nama_sub_bab }}</div>
                                                                <div class="text-xs text-gray-500 mt-1 font-normal">
                                                                    @if ($subChapter->periode_awal && $subChapter->periode_akhir)
                                                                        <i class='bx bx-calendar text-orange-500'></i>
                                                                        <span>
                                                                            {{ \Carbon\Carbon::parse($subChapter->periode_awal)->isoFormat('D MMM Y') }}
                                                                            -
                                                                            {{ \Carbon\Carbon::parse($subChapter->periode_akhir)->isoFormat('D MMM Y') }}
                                                                        </span>
                                                                    @else
                                                                        <span class="italic">Periode tidak diatur</span>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                @if ($userFile)
                                                                    @if ($userFile->type === 'file')
                                                                        <span
                                                                            class="inline-flex items-center px-2 py-1 bg-sky-100 text-sky-800 text-xs font-medium rounded-full"><i
                                                                                class='bx bxs-file-pdf mr-1'></i> File
                                                                            Terunggah</span>
                                                                    @else
                                                                        <span
                                                                            class="inline-flex items-center px-2 py-1 bg-indigo-100 text-indigo-800 text-xs font-medium rounded-full"><i
                                                                                class='bx bx-link mr-1'></i> Link
                                                                            Tersimpan</span>
                                                                    @endif
                                                                @else
                                                                    <span
                                                                        class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">Belum
                                                                        Ada</span>
                                                                @endif
                                                            </td>
                                                            <td class="px-6 py-4 text-right space-x-2">
                                                                {{-- PERUBAHAN 2: Logika Tombol Aksi diubah untuk mengirim boolean isLink --}}
                                                                @if ($userFile)
                                                                    <a href="{{ $userFile->type === 'file' ? route('subdirektorat-inovasi.dosen.equity.files.download', $userFile->id) : $userFile->url }}"
                                                                        {{ $userFile->type === 'link' ? 'target="_blank"' : '' }}
                                                                        class="font-medium text-white {{ $userFile->type === 'file' ? 'bg-sky-600 hover:bg-sky-700' : 'bg-indigo-600 hover:bg-indigo-700' }} px-3 py-1 rounded-md text-xs inline-block">
                                                                        {{ $userFile->type === 'file' ? 'Unduh' : 'Buka Link' }}
                                                                    </a>
                                                                    @if ($isSesiAktif)
                                                                        <button
                                                                            @click="openModal(
    'Edit: {{ addslashes($subChapter->nama_sub_bab) }}', 
    '{{ route('subdirektorat-inovasi.dosen.equity.files.store', ['submission' => $submission->id, 'subChapter' => $subChapter->id]) }}', 
    {{ $isLinkType ? 'true' : 'false' }},
    '{{ addslashes($userFile->judul_luaran) }}', 
    '{{ $userFile->status_luaran }}'
)"
                                                                            class="font-medium text-white bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded-md text-xs">Edit</button>

                                                                        <form
                                                                            action="{{ route('subdirektorat-inovasi.dosen.equity.files.destroy', $userFile->id) }}"
                                                                            method="POST" class="inline-block"
                                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                                            @csrf @method('DELETE')
                                                                            <button type="submit"
                                                                                class="font-medium text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md text-xs">Hapus</button>
                                                                        </form>
                                                                    @endif
                                                                @else
                                                                    @if ($isSesiAktif)
                                                                        @if ($isLinkType)
                                                                            <button
                                                                                @click="openModal(
        'Masukkan Link: {{ addslashes($subChapter->nama_sub_bab) }}', 
        '{{ route('subdirektorat-inovasi.dosen.equity.files.store', ['submission' => $submission->id, 'subChapter' => $subChapter->id]) }}', 
        true,
        '{{ addslashes($subChapter->nama_sub_bab) }}',
        ''
    )"
                                                                                class="font-medium text-white bg-indigo-600 hover:bg-indigo-700 px-3 py-1 rounded-md text-xs">Masukkan
                                                                                Link</button>
                                                                            {{-- Tombol Unggah (saat belum ada data) --}}
                                                                        @else
                                                                            <button
                                                                                @click="openModal(
        'Unggah Dokumen: {{ addslashes($subChapter->nama_sub_bab) }}', 
        '{{ route('subdirektorat-inovasi.dosen.equity.files.store', ['submission' => $submission->id, 'subChapter' => $subChapter->id]) }}', 
        false,
        '{{ addslashes($subChapter->nama_sub_bab) }}',
        ''
    )"
                                                                                class="font-medium text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded-md text-xs">Unggah</button>
                                                                        @endif
                                                                    @else
                                                                        <span class="text-xs text-red-500 italic">Sesi
                                                                            Ditutup</span>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endif 
                                                    @empty
                                                        <tr>
                                                            <td colspan="3" class="text-center py-4 text-gray-500">Belum
                                                                ada syarat dokumen untuk modul ini.</td>
                                                        </tr>
                                                    @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div x-show="tab === 'penilaian'" x-transition style="display: none;">
                                    {{-- Konten Tab Penilaian --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 text-gray-500">
                        <i class='bx bx-data text-4xl mb-2'></i>
                        <p>Admin belum menambahkan modul penilaian untuk sesi proposal ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- PERUBAHAN 3: Modal disederhanakan, tidak ada lagi radio button pilihan --}}
        <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 px-4"
            style="display: none;">
            <div @click.away="isModalOpen = false" class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6 sm:p-8"
                x-show="isModalOpen" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90">
                <h3 class="text-xl font-bold text-gray-800 mb-6" x-text="modalTitle"></h3>

                <form :action="formAction" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- Field Judul Luaran --}}
                    <div>
                        <label for="judul_luaran_modal" class="block text-sm font-medium text-gray-700">Judul File /
                            Luaran</label>
                        <input type="text" name="judul_luaran" id="judul_luaran_modal" x-model="judulLuaran" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>

                    {{-- Field Status Luaran --}}
                    <div>
                        <label for="status_luaran_modal" class="block text-sm font-medium text-gray-700">Status
                            Luaran</label>
                        @php
                            $statusOptions = [
                                'Submitted',
                                'Under Review',
                                'Accepted',
                                'Published/Terbit',
                                'HKI - Draf',
                                'HKI - Terdaftar',
                                'HKI - Bersertifikat/Granted',
                                'Tersedia/Ada',
                            ];
                        @endphp
                        <select name="status_luaran" id="status_luaran_modal" x-model="statusLuaran" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Pilih...</option>
                            @foreach ($statusOptions as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Input untuk File (HANYA MUNCUL JIKA BUKAN LINK) --}}
                    <div x-show="!isLinkOnly" x-transition>
                        <label for="file_dokumen" class="block text-sm font-medium text-gray-700">Pilih File PDF (Maks:
                            5MB)</label>
                        <input type="file" name="file_dokumen" id="file_dokumen" accept=".pdf"
                            :disabled="isLinkOnly" {{-- <-- TAMBAHKAN INI --}}
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <input type="hidden" name="type" value="file" :disabled="isLinkOnly">
                        {{-- <-- TAMBAHKAN INI --}}
                    </div>

                    {{-- Input untuk Link (HANYA MUNCUL JIKA LINK) --}}
                    <div x-show="isLinkOnly" x-transition>
                        <label for="url" class="block text-sm font-medium text-gray-700">Masukkan URL</label>
                        <input type="url" name="url" id="url" placeholder="https://..."
                            :disabled="!isLinkOnly" {{-- <-- TAMBAHKAN INI --}}
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <input type="hidden" name="type" value="link" :disabled="!isLinkOnly">
                        {{-- <-- TAMBAHKAN INI --}}
                    </div>

                    <div class="mt-8 flex justify-end space-x-3 pt-5 border-t">
                        <button type="button" @click="isModalOpen = false"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
