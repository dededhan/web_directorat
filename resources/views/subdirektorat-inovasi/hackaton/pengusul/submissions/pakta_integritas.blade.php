@extends('subdirektorat-inovasi.hackaton.layout')

@section('title', 'Template Pakta Integritas | Hackaton UNJ')

@section('content_hackaton')
    <script>
        function paktaIntegritasPage() {
            return {
                form: {!! json_encode($paktaInitial, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!}
            };
        }
    </script>

    <div class="max-w-4xl mx-auto space-y-6" x-data="paktaIntegritasPage()">
        {{-- Header & Breadcrumb --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-300">
            <div>
                <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                    <a href="{{ route('hackaton.submissions.index') }}" class="hover:text-indigo-700">Proposal Saya</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <a href="{{ route('hackaton.submissions.show', $submission) }}" class="hover:text-indigo-700">
                        {{ Str::limit($submission->identitas?->nama_produk ?? 'Detail Proposal', 25) }}
                    </a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span class="text-gray-900 font-bold">Template Pakta Integritas</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">
                    Template Pakta Integritas
                </h1>
                <p class="mt-1 text-xs text-gray-600">
                    Sesi: <strong>{{ $submission->session->nama_sesi }}</strong> &bull; Produk: <strong>{{ $submission->identitas?->nama_produk ?? 'Belum diisi' }}</strong>
                </p>
            </div>
            <a href="{{ route('hackaton.submissions.show', $submission) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-xs font-semibold rounded-xl text-gray-700 hover:bg-gray-50 transition shadow-sm self-start sm:self-auto">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke Proposal
            </a>
        </div>

        {{-- Guide Banner --}}
        <div class="bg-indigo-50 border border-indigo-200 p-4 rounded-xl flex items-start gap-3.5 text-indigo-950">
            <div class="w-8 h-8 rounded-lg bg-indigo-700 text-white flex items-center justify-center text-sm shrink-0 mt-0.5">
                <i class="fas fa-file-contract"></i>
            </div>
            <div class="text-xs leading-relaxed">
                <strong class="font-bold block text-indigo-900 mb-0.5">Petunjuk Pengisian Pakta Integritas:</strong>
                Ketik dan sesuaikan isian di bawah ini (Nama Lengkap, NIK/NIM/NIP, Institusi, Nama Tim, Judul Inovasi, Tahun, dan Tanggal). Setelah isian sesuai, klik tombol <strong>Generate into PDF</strong> untuk mencetak dokumen format PDF resmi. Dokumen PDF ini dilengkapi area Materai Rp10.000 untuk ditandatangani oleh Ketua Pengusul.
            </div>
        </div>

        {{-- Main Form --}}
        <form method="POST" action="{{ route('hackaton.submissions.pakta_integritas.pdf', $submission) }}" target="_blank" class="space-y-6">
            @csrf

            {{-- 1. Info Kegiatan & Tahun --}}
            <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm space-y-4">
                <div class="border-b border-gray-200 pb-3 flex items-center gap-2">
                    <span class="w-6 h-6 bg-gray-900 text-white text-xs font-bold rounded-full flex items-center justify-center">1</span>
                    <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Judul Dokumen & Tahun Kegiatan</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            Nama Kegiatan
                        </label>
                        <input type="text" value="Peserta HackAthon DeepTech Universitas Negeri Jakarta" disabled
                            class="w-full border border-gray-200 rounded-xl p-2.5 text-xs font-semibold bg-gray-100 text-gray-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            Tahun Kegiatan <span class="text-rose-600">*</span>
                        </label>
                        <input type="text" name="tahun" x-model="form.tahun" required
                            class="w-full border border-gray-300 rounded-xl p-2.5 text-xs font-medium focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 bg-white"
                            placeholder="Contoh: 2026">
                    </div>
                </div>
            </div>

            {{-- 2. Data Pengusul / Yang Bertanda Tangan --}}
            <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm space-y-4">
                <div class="border-b border-gray-200 pb-3 flex items-center gap-2">
                    <span class="w-6 h-6 bg-gray-900 text-white text-xs font-bold rounded-full flex items-center justify-center">2</span>
                    <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Identitas Yang Bertanda Tangan</h2>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                - Nama Lengkap <span class="text-rose-600">*</span>
                            </label>
                            <input type="text" name="nama_lengkap" x-model="form.nama_lengkap" required
                                class="w-full border border-gray-300 rounded-xl p-2.5 text-xs font-medium focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 bg-white"
                                placeholder="Ketik nama lengkap pengusul...">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                - NIM / NIP / NIK <span class="text-rose-600">*</span>
                            </label>
                            <input type="text" name="nik_nim_nip" x-model="form.nik_nim_nip" required
                                class="w-full border border-gray-300 rounded-xl p-2.5 text-xs font-medium focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 bg-white"
                                placeholder="Ketik NIM / NIP / NIK...">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                - Institusi <span class="text-rose-600">*</span>
                            </label>
                            <input type="text" name="institusi" x-model="form.institusi" required
                                class="w-full border border-gray-300 rounded-xl p-2.5 text-xs font-medium focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 bg-white"
                                placeholder="Contoh: Universitas Negeri Jakarta / Fakultas Teknik">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                - Nama Tim <span class="text-rose-600">*</span>
                            </label>
                            <input type="text" name="nama_tim" x-model="form.nama_tim" required
                                class="w-full border border-gray-300 rounded-xl p-2.5 text-xs font-medium focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 bg-white"
                                placeholder="Contoh: Tim Inovator UNJ">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            - Judul Inovasi <span class="text-rose-600">*</span>
                        </label>
                        <textarea name="judul_inovasi" x-model="form.judul_inovasi" rows="2" required
                            class="w-full border border-gray-300 rounded-xl p-3 text-xs font-medium focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 bg-white"
                            placeholder="Ketik Judul Inovasi yang diajukan..."></textarea>
                    </div>
                </div>
            </div>

            {{-- 3. Butir Pernyataan Pakta Integritas (Preview) --}}
            <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm space-y-4">
                <div class="border-b border-gray-200 pb-3 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 bg-gray-900 text-white text-xs font-bold rounded-full flex items-center justify-center">3</span>
                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Poin Pernyataan Pakta Integritas</h2>
                    </div>
                    <span class="text-[11px] font-bold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">6 Poin Resmi</span>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 text-xs text-gray-700 space-y-2.5 leading-relaxed">
                    <p class="font-medium text-gray-800">
                        Dalam rangka pengusulan dan pelaksanaan kegiatan Hackathon Deeptech Universitas Negeri Jakarta <span class="font-bold" x-text="form.tahun || '2026'"></span>, dengan ini menyatakan dengan sesungguhnya bahwa saya:
                    </p>
                    <ol class="list-decimal pl-5 space-y-2">
                        <li>menjamin bahwa proposal, ide, karya, purwarupa, dan inovasi yang diajukan merupakan karya orisinal, tidak mengandung plagiarisme, serta tidak mengandung fabrikasi data;</li>
                        <li>menjamin bahwa proposal, ide, karya, purwarupa, atau inovasi yang diajukan tidak melanggar hak kekayaan intelektual pihak lain serta tidak sedang diajukan secara ganda pada kegiatan lain;</li>
                        <li>melaksanakan tugas dan tanggung jawab dalam kegiatan Hackathon sesuai dengan proposal yang diajukan dan perjanjian yang disepakati dengan penyelenggara;</li>
                        <li>tidak memiliki dan tidak akan menciptakan konflik kepentingan (conflict of interest) yang dapat memengaruhi objektivitas pelaksanaan kegiatan maupun proses seleksi, pendampingan, penilaian, dan evaluasi;</li>
                        <li>menggunakan fasilitas, dukungan pendanaan, data, perangkat, bahan, serta sumber daya lain yang diberikan oleh penyelenggara sesuai dengan peruntukan dan ketentuan yang berlaku, serta bertanggung jawab penuh atas penggunaan dan pelaporannya;</li>
                        <li>menjaga kerahasiaan data, informasi, dokumen, teknologi, proses bisnis, dan informasi lain yang dinyatakan bersifat rahasia oleh penyelenggara, mitra, dan pihak terkait, serta menggunakan kecerdasan buatan, perangkat lunak, dataset, dan teknologi pihak ketiga secara bertanggung jawab sesuai dengan ketentuan yang berlaku.</li>
                    </ol>
                </div>
            </div>

            {{-- 4. Tempat, Tanggal & Tanda Tangan Ketua Pengusul --}}
            <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm space-y-4">
                <div class="border-b border-gray-200 pb-3 flex items-center gap-2">
                    <span class="w-6 h-6 bg-gray-900 text-white text-xs font-bold rounded-full flex items-center justify-center">4</span>
                    <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Tempat, Tanggal & Penandatangan</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Info Box Materai --}}
                    <div class="border border-dashed border-gray-400 rounded-xl p-4 bg-gray-50 flex items-center gap-4">
                        <div class="w-16 h-20 border-2 border-dashed border-gray-400 bg-white rounded-lg flex flex-col items-center justify-center text-center p-1 shrink-0">
                            <span class="text-[9px] font-bold text-gray-500 uppercase leading-tight">Materai<br>Rp10.000</span>
                        </div>
                        <div class="text-xs text-gray-600 leading-relaxed">
                            <strong class="text-gray-900 block font-bold mb-1">Ketentuan Penandatanganan:</strong>
                            Dokumen PDF yang diunduh wajib dibubuhi <strong>Materai Rp10.000</strong> (atau e-meterai) pada bagian tanda tangan Ketua Pengusul sebelum diunggah ke sistem.
                        </div>
                    </div>

                    {{-- Form Tanda Tangan --}}
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1 text-right">
                                Tempat & Tanggal (Position in right)
                            </label>
                            <input type="text" name="tanggal_tempat" x-model="form.tanggal_tempat"
                                class="w-full border border-gray-300 rounded-xl p-2.5 text-xs font-medium bg-white text-right focus:ring-2 focus:ring-indigo-600"
                                placeholder="Contoh: Jakarta, 18 September 2026">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase text-gray-600 mb-1 text-right">
                                Nama Ketua Pengusul (input by typing)
                            </label>
                            <input type="text" name="penandatangan_nama" x-model="form.penandatangan_nama"
                                class="w-full border border-gray-300 rounded-lg p-2 text-xs font-semibold bg-white text-right focus:ring-1 focus:ring-indigo-600"
                                placeholder="Ketik nama Ketua Pengusul...">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase text-gray-600 mb-1 text-right">
                                NIK / NIM / NIP Ketua Pengusul (input by typing)
                            </label>
                            <input type="text" name="penandatangan_nik" x-model="form.penandatangan_nik"
                                class="w-full border border-gray-300 rounded-lg p-2 text-xs bg-white text-right focus:ring-1 focus:ring-indigo-600"
                                placeholder="Ketik NIK / NIM / NIP...">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ route('hackaton.submissions.show', $submission) }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3 border border-gray-400 text-xs font-bold uppercase tracking-wider text-gray-700 hover:bg-gray-100 rounded-xl transition text-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Proposal
                </a>

                <div class="w-full sm:w-auto flex flex-col sm:flex-row items-center gap-3">
                    <button type="submit" name="download" value="0"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3 bg-gray-900 hover:bg-black text-white text-xs font-bold uppercase tracking-wider rounded-xl transition shadow cursor-pointer">
                        <i class="fas fa-eye mr-2"></i> Buka / Preview PDF
                    </button>
                    <button type="submit" name="download" value="1"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-indigo-700 hover:bg-indigo-800 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition shadow cursor-pointer">
                        <i class="fas fa-file-pdf mr-2"></i> Generate into PDF
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
