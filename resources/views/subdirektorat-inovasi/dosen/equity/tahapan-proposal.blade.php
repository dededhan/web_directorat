@extends('subdirektorat-inovasi.dosen.index')

{{-- Ganti 'content' dengan 'contentdosen' jika layout Anda menggunakan itu --}}
@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb dan Tombol Kembali --}}
    <div class="flex flex-wrap justify-between items-center gap-4 mb-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Proposal Penelitian Pengabdian</h1>
            <nav class="text-sm" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex space-x-2 text-gray-500">
                    <li class="flex items-center">
                        <a href="#" class="hover:text-gray-700">Home</a>
                        <i class='bx bx-chevron-right text-gray-400 mx-2'></i>
                    </li>
                    <li class="flex items-center">
                        <span class="font-medium">Manajemen Proposal</span>
                    </li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('subdirektorat-inovasi.dosen.equity.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg shadow-sm hover:bg-gray-50 transition-colors duration-200">
            <i class='bx bx-arrow-back mr-2'></i>
            <span>Kembali</span>
        </a>
    </div>

    {{-- Informasi Header Proposal --}}
    <div class="bg-gray-50 border border-gray-200 p-6 rounded-lg mb-8">
        <h2 class="text-xl font-semibold text-gray-800">Tahap Penilaian Proposal: Pengembangan Sistem Monitoring Kualitas Air</h2>
        <p class="text-gray-600 mt-2">Silahkan ikuti tahap penilaian proposal pada menu ini. Beberapa tahap memiliki persyaratan yang perlu dipenuhi untuk mendukung proses penilaian.</p>
    </div>

    {{-- Kontainer Utama untuk semua seksi --}}
    <div class="space-y-12">
        
        <!-- SEKSI 1: DESK EVALUASI PROPOSAL -->
        <div class="flex items-start gap-4 md:gap-6">
            <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-[#3A4D8F] text-white rounded-full font-bold text-lg ring-4 ring-white sticky top-8">1</div>
            <div id="desk-evaluasi" class="w-full bg-white rounded-xl shadow-lg overflow-hidden" x-data="{ tab: 'syarat' }">
                <div class="p-6"><h3 class="text-lg font-bold text-gray-800">Desk Evaluasi Proposal</h3></div>
                <div class="border-b border-gray-200"><nav class="-mb-px flex px-6"><a href="#" @click.prevent="tab = 'syarat'" :class="{ 'border-blue-500 text-blue-600': tab === 'syarat', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'syarat' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Syarat</a><a href="#" @click.prevent="tab = 'penilaian'" :class="{ 'border-blue-500 text-blue-600': tab === 'penilaian', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'penilaian' }" class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm">Penilaian</a></nav></div>
                <div class="p-6">
                    <div x-show="tab === 'syarat'" x-transition><p class="text-sm text-gray-600 mb-4">Dokumen yang diperlukan pada penilaian tahap ini:</p><div class="overflow-x-auto"><table class="w-full text-sm text-left text-gray-500"><thead class="text-xs text-gray-700 uppercase bg-gray-50"><tr><th scope="col" class="px-6 py-3">Jenis Dokumen</th><th scope="col" class="px-6 py-3">Batas Waktu</th><th scope="col" class="px-6 py-3 text-right">Aksi</th></tr></thead><tbody><tr class="bg-white border-b"><td class="px-6 py-4 font-medium text-gray-900">Surat Pernyataan Orisinalitas <span class="ml-2 text-xs font-medium text-red-800 bg-red-100 px-2 py-0.5 rounded-full">Wajib</span></td><td class="px-6 py-4">08 Maret 2025 | 12:00:00</td><td class="px-6 py-4 text-right space-x-2"><button class="font-medium text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded-md text-xs">Unduh</button><button class="font-medium text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded-md text-xs">Edit</button><button class="font-medium text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md text-xs">Hapus</button></td></tr><tr class="bg-white border-b"><td class="px-6 py-4 font-medium text-gray-900">Surat Kesediaan Memenuhi Luaran Wajib <span class="ml-2 text-xs font-medium text-red-800 bg-red-100 px-2 py-0.5 rounded-full">Wajib</span></td><td class="px-6 py-4">08 Maret 2025 | 12:00:00</td><td class="px-6 py-4 text-right space-x-2"><button class="font-medium text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded-md text-xs">Unduh</button><button class="font-medium text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded-md text-xs">Edit</button><button class="font-medium text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md text-xs">Hapus</button></td></tr><tr class="bg-white"><td class="px-6 py-4 font-medium text-gray-900">Dokumen Self Assessment Ethics <span class="ml-2 text-xs font-medium text-red-800 bg-red-100 px-2 py-0.5 rounded-full">Wajib</span></td><td class="px-6 py-4">08 Maret 2025 | 12:00:00</td><td class="px-6 py-4 text-right space-x-2"><button class="font-medium text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded-md text-xs">Unduh</button><button class="font-medium text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded-md text-xs">Edit</button><button class="font-medium text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md text-xs">Hapus</button></td></tr></tbody></table></div></div>
                    <div x-show="tab === 'penilaian'" x-transition style="display: none;"><div class="overflow-x-auto"><table class="w-full text-sm text-left text-gray-500"><thead class="text-xs text-gray-700 uppercase bg-gray-50"><tr><th scope="col" class="px-6 py-3 w-1/6">Reviewer</th><th scope="col" class="px-6 py-3">Catatan</th></tr></thead><tbody><tr class="bg-white border-b"><td class="px-6 py-4 font-medium text-gray-900">Reviewer 1</td><td class="px-6 py-4">Surat kesediaan publikasi harus bermaterai, tidak ada road map.</td></tr><tr class="bg-white"><td class="px-6 py-4 font-medium text-gray-900">Reviewer 2</td><td class="px-6 py-4">Tema dan substansi kegiatan penelitian cukup baik. Mohon diperhatikan jadwal pelaksanaan penelitian...</td></tr></tbody></table></div></div>
                </div>
                <div class="p-6 bg-gray-50 text-center text-sm text-gray-700">Sudah difinalisasi pada tahap ini dengan status <span class="font-bold text-green-600">Lolos</span> dan nominal evaluasi Rp. 15.250.000</div>
            </div>
        </div>

        <!-- SEKSI 2: PERBAIKAN PROPOSAL -->
        <div class="flex items-start gap-4 md:gap-6">
            <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-[#3A4D8F] text-white rounded-full font-bold text-lg ring-4 ring-white sticky top-8">2</div>
            <div id="perbaikan-proposal" class="w-full bg-white rounded-xl shadow-lg overflow-hidden" x-data="{ tab: 'syarat' }">
                <div class="p-6"><h3 class="text-lg font-bold text-gray-800">Perbaikan Proposal</h3></div>
                <div class="border-b border-gray-200"><nav class="-mb-px flex px-6"><a href="#" @click.prevent="tab = 'syarat'" :class="{ 'border-blue-500 text-blue-600': tab === 'syarat', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'syarat' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Syarat</a><a href="#" @click.prevent="tab = 'penilaian'" :class="{ 'border-blue-500 text-blue-600': tab === 'penilaian', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'penilaian' }" class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm">Penilaian</a></nav></div>
                <div class="p-6">
                    <div x-show="tab === 'syarat'" x-transition><div class="overflow-x-auto"><table class="w-full text-sm text-left text-gray-500"><thead class="text-xs text-gray-700 uppercase bg-gray-50"><tr><th scope="col" class="px-6 py-3">Jenis Dokumen</th><th scope="col" class="px-6 py-3">Batas Waktu</th><th scope="col" class="px-6 py-3 text-right">Aksi</th></tr></thead><tbody><tr class="bg-white border-b"><td class="px-6 py-4 font-medium text-gray-900">Proposal Perbaikan <span class="ml-2 text-xs font-medium text-red-800 bg-red-100 px-2 py-0.5 rounded-full">Wajib</span></td><td class="px-6 py-4">30 April 2025 | 23:59:00</td><td class="px-6 py-4 text-right"><span class="font-bold text-red-500">Sudah Ditutup</span></td></tr></tbody></table></div></div>
                    <div x-show="tab === 'penilaian'" x-transition style="display: none;"><p class="text-sm text-center text-gray-500">Belum ada penilaian untuk tahap ini.</p></div>
                </div>
            </div>
        </div>

        <!-- SEKSI 3: LAPORAN KEMAJUAN -->
        <div class="flex items-start gap-4 md:gap-6">
            <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-[#3A4D8F] text-white rounded-full font-bold text-lg ring-4 ring-white sticky top-8">3</div>
            <div id="laporan-kemajuan" class="w-full bg-white rounded-xl shadow-lg overflow-hidden" x-data="{ tab: 'syarat' }">
                <div class="p-6"><h3 class="text-lg font-bold text-gray-800">Laporan Kemajuan dan Monitoring Evaluasi</h3></div>
                <div class="border-b border-gray-200"><nav class="-mb-px flex px-6"><a href="#" @click.prevent="tab = 'syarat'" :class="{ 'border-blue-500 text-blue-600': tab === 'syarat', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'syarat' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Syarat</a><a href="#" @click.prevent="tab = 'penilaian'" :class="{ 'border-blue-500 text-blue-600': tab === 'penilaian', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'penilaian' }" class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm">Penilaian</a></nav></div>
                <div class="p-6">
                    <div x-show="tab === 'syarat'" x-transition><div class="overflow-x-auto"><table class="w-full text-sm text-left text-gray-500"><thead class="text-xs text-gray-700 uppercase bg-gray-50"><tr><th scope="col" class="px-6 py-3">Jenis Dokumen</th><th scope="col" class="px-6 py-3">Batas Waktu</th><th scope="col" class="px-6 py-3 text-right">Aksi</th></tr></thead><tbody><tr class="bg-white border-b"><td class="px-6 py-4 font-medium text-gray-900">Laporan Kemajuan Penelitian <span class="ml-2 text-xs font-medium text-red-800 bg-red-100 px-2 py-0.5 rounded-full">Wajib</span></td><td class="px-6 py-4">25 Agustus 2025 | 23:59:00</td><td class="px-6 py-4 text-right space-x-2"><button class="font-medium text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded-md text-xs">Edit</button><button class="font-medium text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md text-xs">Hapus</button></td></tr><tr class="bg-white border-b"><td class="px-6 py-4 font-medium text-gray-900">SPTB Penelitian 70% <span class="ml-2 text-xs font-medium text-red-800 bg-red-100 px-2 py-0.5 rounded-full">Wajib</span></td><td class="px-6 py-4">25 Agustus 2025 | 23:59:00</td><td class="px-6 py-4 text-right space-x-2"><button class="font-medium text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded-md text-xs">Edit</button><button class="font-medium text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md text-xs">Hapus</button></td></tr><tr class="bg-white border-b"><td class="px-6 py-4 font-medium text-gray-900">Hak Cipta <span class="ml-2 text-xs font-medium text-orange-800 bg-orange-100 px-2 py-0.5 rounded-full">Wajib (Pilih Salah Satu)</span></td><td class="px-6 py-4">25 Agustus 2025 | 23:59:00</td><td class="px-6 py-4 text-right"><span class="font-bold text-red-500">Sudah Ditutup</span></td></tr></tbody></table></div></div>
                    <div x-show="tab === 'penilaian'" x-transition style="display: none;"><p class="text-sm text-center text-gray-500">Belum ada penilaian untuk tahap ini.</p></div>
                </div>
            </div>
        </div>

        <!-- SEKSI 4: LAPORAN AKHIR -->
        <div class="flex items-start gap-4 md:gap-6">
            <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-[#3A4D8F] text-white rounded-full font-bold text-lg ring-4 ring-white sticky top-8">4</div>
            <div id="laporan-akhir" class="w-full bg-white rounded-xl shadow-lg overflow-hidden" x-data="{ tab: 'syarat' }">
                <div class="p-6"><h3 class="text-lg font-bold text-gray-800">Laporan Akhir Penelitian</h3></div>
                <div class="border-b border-gray-200"><nav class="-mb-px flex px-6"><a href="#" @click.prevent="tab = 'syarat'" :class="{ 'border-blue-500 text-blue-600': tab === 'syarat', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'syarat' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Syarat</a><a href="#" @click.prevent="tab = 'penilaian'" :class="{ 'border-blue-500 text-blue-600': tab === 'penilaian', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'penilaian' }" class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm">Penilaian</a></nav></div>
                <div class="p-6">
                    <div x-show="tab === 'syarat'" x-transition><div class="overflow-x-auto"><table class="w-full text-sm text-left text-gray-500"><thead class="text-xs text-gray-700 uppercase bg-gray-50"><tr><th scope="col" class="px-6 py-3">Jenis Dokumen</th><th scope="col" class="px-6 py-3">Batas Waktu</th><th scope="col" class="px-6 py-3 text-right">Aksi</th></tr></thead><tbody><tr class="bg-white border-b"><td class="px-6 py-4 font-medium text-gray-900">Laporan Akhir Penelitian <span class="ml-2 text-xs font-medium text-red-800 bg-red-100 px-2 py-0.5 rounded-full">Wajib</span></td><td class="px-6 py-4">14 November 2025 | 23:59:00</td><td class="px-6 py-4 text-right"><button class="font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md text-xs">Unggah</button></td></tr><tr class="bg-white border-b"><td class="px-6 py-4 font-medium text-gray-900">Laporan Keuangan 100% <span class="ml-2 text-xs font-medium text-red-800 bg-red-100 px-2 py-0.5 rounded-full">Wajib</span></td><td class="px-6 py-4">14 November 2025 | 23:59:00</td><td class="px-6 py-4 text-right"><button class="font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md text-xs">Unggah</button></td></tr><tr class="bg-white"><td class="px-6 py-4 font-medium text-gray-900">SPTB Penelitian 100% <span class="ml-2 text-xs font-medium text-red-800 bg-red-100 px-2 py-0.5 rounded-full">Wajib</span></td><td class="px-6 py-4">14 November 2025 | 23:59:00</td><td class="px-6 py-4 text-right"><button class="font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md text-xs">Unggah</button></td></tr></tbody></table></div></div>
                    <div x-show="tab === 'penilaian'" x-transition style="display: none;"><p class="text-sm text-center text-gray-500">Belum ada penilaian untuk tahap ini.</p></div>
                </div>
            </div>
        </div>

        <!-- SEKSI 5: SEMINAR HASIL -->
        <div class="flex items-start gap-4 md:gap-6">
            <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-[#3A4D8F] text-white rounded-full font-bold text-lg ring-4 ring-white sticky top-8">5</div>
            <div id="seminar-hasil" class="w-full bg-white rounded-xl shadow-lg overflow-hidden" x-data="{ tab: 'syarat' }">
                <div class="p-6"><h3 class="text-lg font-bold text-gray-800">Seminar Hasil/Penilaian Luaran</h3></div>
                <div class="border-b border-gray-200"><nav class="-mb-px flex px-6"><a href="#" @click.prevent="tab = 'syarat'" :class="{ 'border-blue-500 text-blue-600': tab === 'syarat', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'syarat' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Syarat</a><a href="#" @click.prevent="tab = 'penilaian'" :class="{ 'border-blue-500 text-blue-600': tab === 'penilaian', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'penilaian' }" class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm">Penilaian</a></nav></div>
                <div class="p-6">
                    <div x-show="tab === 'syarat'" x-transition><p class="text-sm text-center text-gray-500">Belum ada dokumen yang perlu diunggah untuk tahap ini.</p></div>
                    <div x-show="tab === 'penilaian'" x-transition style="display: none;"><p class="text-sm text-center text-gray-500">Belum ada penilaian untuk tahap ini.</p></div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

