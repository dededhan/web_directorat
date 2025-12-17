@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Upload Lampiran Dokumen</h1>
                    <p class="mt-2 text-sm text-gray-600">Upload dokumen pendukung untuk setiap aspek inovasi</p>
                </div>
                <a href="{{ route('subdirektorat-inovasi.dosen.katsinov-v2.show', $katsinov->id) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="mb-6 rounded-md bg-green-50 p-4">
                <div class="flex">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <form id="form-lampiran" method="POST" action="{{ route('subdirektorat-inovasi.dosen.katsinov-v2.form-lampiran.store', $katsinov->id) }}" enctype="multipart/form-data">
            @csrf

            {{-- Aspek Teknologi --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        1. Aspek Teknologi
                    </h2>
                </div>
                <div class="p-6">
                    {{-- a) Dokumen Perencanaan --}}
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">a) Dokumen Perencanaan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach(['proposal' => 'Proposal penelitian dan pengembangan', 'jadwal' => 'Jadwal program (Program Schedule)'] as $key => $label)
                                @include('subdirektorat-inovasi.dosen.katsinov_v2.partials.file_upload_field', [
                                    'aspek' => 'aspek_teknologi',
                                    'key' => $key,
                                    'label' => $label,
                                    'color' => 'blue',
                                    'lampiran' => $lampiran,
                                    'katsinov' => $katsinov
                                ])
                            @endforeach
                        </div>
                    </div>

                    {{-- b) Dokumen Pelaksanaan --}}
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">b) Dokumen Pelaksanaan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach([
                                'desain' => 'Desain secara teori dan empiris',
                                'simulasi_pemodelan' => 'Hasil simulasi dan pemodelan',
                                'penelitian_analitik' => 'Hasil penelitian analitik',
                                'eksperimen_laboratorium' => 'Hasil eksperimen laboratorium',
                                'prototipe_laboratorium' => 'Prototipe skala laboratorium',
                                'prototipe_pilot' => 'Prototipe skala pilot',
                                'uji_kelayakan' => 'Hasil uji kelayakan teknis',
                                'prototipe_sebanding' => 'Prototipe skala 1:1',
                                'simulasi_lingkungan' => 'Uji pada simulasi lingkungan operasional',
                                'test_evaluasi' => 'Hasil test dan evaluasi'
                            ] as $key => $label)
                                @include('subdirektorat-inovasi.dosen.katsinov_v2.partials.file_upload_field', [
                                    'aspek' => 'aspek_teknologi',
                                    'key' => $key,
                                    'label' => $label,
                                    'color' => 'blue',
                                    'lampiran' => $lampiran,
                                    'katsinov' => $katsinov
                                ])
                            @endforeach
                        </div>
                    </div>

                    {{-- c) Dokumen Publikasi --}}
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">c) Dokumen Publikasi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach(['dokumen_ilmiah' => 'Publikasi ilmiah: paper, prosiding, jurnal, dll', 'dokumen_haki' => 'Kekayaan Intelektual: paten, lisensi, desain industri, dll'] as $key => $label)
                                @include('subdirektorat-inovasi.dosen.katsinov_v2.partials.file_upload_field', [
                                    'aspek' => 'aspek_teknologi',
                                    'key' => $key,
                                    'label' => $label,
                                    'color' => 'blue',
                                    'lampiran' => $lampiran,
                                    'katsinov' => $katsinov
                                ])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Aspek Pasar --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        2. Aspek Pasar
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach([
                            'penelitian_pasar' => 'Hasil Penelitian pasar (marketing research)',
                            'identifkasi_segmen' => 'Identifikasi segmen, ukuran dan pangsa pasar',
                            'perhitungan_kebutuhan' => 'Perhitungan kebutuhan investasi',
                            'estimasi_harga' => 'Estimasi harga produksi dibandingkan kompetitor',
                            'identifikasi_kompetitor' => 'Identifikasi kompetitor',
                            'model_bisnis' => 'Model bisnis',
                            'posisioning_pasar' => 'Posisioning pasar'
                        ] as $key => $label)
                            @include('subdirektorat-inovasi.dosen.katsinov_v2.partials.file_upload_field', [
                                'aspek' => 'aspek_pasar',
                                'key' => $key,
                                'label' => $label,
                                'color' => 'green',
                                'lampiran' => $lampiran,
                                'katsinov' => $katsinov
                            ])
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Aspek Organisasi --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        3. Aspek Organisasi
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach([
                            'strategi_inovasi' => 'Strategi Inovasi',
                            'sdm' => 'Sumber Daya Manusia',
                            'analisis_bisnis' => 'Analisis dan Rencana Bisnis',
                            'struktur_bisnis' => 'Organisasi Formal (Struktur Bisnis dengan Staff dan Kolaborator)'
                        ] as $key => $label)
                            @include('subdirektorat-inovasi.dosen.katsinov_v2.partials.file_upload_field', [
                                'aspek' => 'aspek_organisasi',
                                'key' => $key,
                                'label' => $label,
                                'color' => 'purple',
                                'lampiran' => $lampiran,
                                'katsinov' => $katsinov
                            ])
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Aspek Mitra --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        4. Aspek Kemitraan
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach([
                            'mitra_potensial' => 'Daftar Mitra Potensial',
                            'kerjasama' => 'Kerjasama',
                            'pengelolaan_kerjasama' => 'Pengelolaan Kerjasama yang Telah Berjalan'
                        ] as $key => $label)
                            @include('subdirektorat-inovasi.dosen.katsinov_v2.partials.file_upload_field', [
                                'aspek' => 'aspek_mitra',
                                'key' => $key,
                                'label' => $label,
                                'color' => 'yellow',
                                'lampiran' => $lampiran,
                                'katsinov' => $katsinov
                            ])
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Aspek Risiko --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        5. Aspek Pengendalian Risiko
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach([
                            'kajian_teknologi' => 'Kajian Risiko Teknologi',
                            'kajian_pasar' => 'Kajian Risiko Pasar',
                            'kajian_organisasi' => 'Kajian Risiko Organisasi'
                        ] as $key => $label)
                            @include('subdirektorat-inovasi.dosen.katsinov_v2.partials.file_upload_field', [
                                'aspek' => 'aspek_risiko',
                                'key' => $key,
                                'label' => $label,
                                'color' => 'red',
                                'lampiran' => $lampiran,
                                'katsinov' => $katsinov
                            ])
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Aspek Manufaktur --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                        6. Aspek Manufaktur
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach([
                            'analisis_materil' => 'Analisis Awal Solusi Material',
                            'material_prototipe' => 'Material, Perkakas dan Alat Uji Prototipe',
                            'analisis_biaya' => 'Analisis Rincian Biaya',
                            'proses_prosedur' => 'Proses dan Prosedur Manufaktur',
                            'jaminan_mutu' => 'Jaminan Mutu (Quality Assurance)',
                            'lean_manufaktur' => 'Penerapan Lean Manufacturing'
                        ] as $key => $label)
                            @include('subdirektorat-inovasi.dosen.katsinov_v2.partials.file_upload_field', [
                                'aspek' => 'aspek_manufaktur',
                                'key' => $key,
                                'label' => $label,
                                'color' => 'indigo',
                                'lampiran' => $lampiran,
                                'katsinov' => $katsinov
                            ])
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Aspek Investasi --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-pink-500 to-pink-600 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        7. Aspek Investasi
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach([
                            'pelanggan_pasar' => 'Analisis Pelanggan, Pasar dan Pesaing',
                            'mvp' => 'Market Value Proposition (MVP)',
                            'kondisi_produk' => 'Estimasi Kondisi Akhir Produk',
                            'potensi_pasar' => 'Estimasi Potensi Pasar',
                            'ekspansi_pasar' => 'Estimasi Ekspansi Pasar'
                        ] as $key => $label)
                            @include('subdirektorat-inovasi.dosen.katsinov_v2.partials.file_upload_field', [
                                'aspek' => 'aspek_investasi',
                                'key' => $key,
                                'label' => $label,
                                'color' => 'pink',
                                'lampiran' => $lampiran,
                                'katsinov' => $katsinov
                            ])
                        @endforeach
                    </div>
                </div>
            </div>

        </form>
    </div>

    {{-- Floating Action Button - Only Simpan Draft --}}
    <div class="fixed bottom-6 right-6 z-50">
        @if($katsinov->status !== 'draft')
            <div class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg shadow-lg text-gray-500 bg-gray-200 cursor-not-allowed">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Form Terkunci ({{ $katsinov->status }})
            </div>
        @else
            <button type="submit" form="form-lampiran" name="save_as_draft" value="1"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
                Simpan Draft
            </button>
        @endif
    </div>
</div>
</div>

<script>
function deleteFile(fileId, aspek, category) {
    if (!confirm('Apakah Anda yakin ingin menghapus file ini?')) {
        return;
    }

    fetch(`{{ route('subdirektorat-inovasi.dosen.katsinov-v2.lampiran.delete', ['katsinov_id' => $katsinov->id, 'lampiran_id' => '__FILE_ID__']) }}`.replace('__FILE_ID__', fileId), {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Gagal menghapus file: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menghapus file');
    });
}
</script>

@endsection

