@extends('subdirektorat-inovasi.hackaton.layout')

@section('title', 'Template Lembar Pengesahan | Hackaton UNJ')

@section('content_hackaton')
    <script>
        function lembarPengesahanPage() {
            return {
                form: {!! json_encode($lembarInitial, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!},
                addAnggota() {
                    if (!this.form.anggota_tim) this.form.anggota_tim = [];
                    this.form.anggota_tim.push('');
                },
                removeAnggota(i) {
                    this.form.anggota_tim.splice(i, 1);
                }
            };
        }
    </script>

    <div class="max-w-4xl mx-auto space-y-6" x-data="lembarPengesahanPage()">
        {{-- Header & Breadcrumb --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-300">
            <div>
                <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                    <a href="{{ route('hackaton.submissions.index') }}" class="hover:text-emerald-700">Proposal Saya</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <a href="{{ route('hackaton.submissions.show', $submission) }}" class="hover:text-emerald-700">
                        {{ Str::limit($submission->identitas?->nama_produk ?? 'Detail Proposal', 25) }}
                    </a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span class="text-gray-900 font-bold">Template Lembar Pengesahan</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">
                    Template Lembar Pengesahan
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
        <div class="bg-emerald-50 border border-emerald-300 p-4 rounded-xl flex items-start gap-3.5 text-emerald-950">
            <div class="w-8 h-8 rounded-lg bg-emerald-700 text-white flex items-center justify-center text-sm shrink-0 mt-0.5">
                <i class="fas fa-file-signature"></i>
            </div>
            <div class="text-xs leading-relaxed">
                <strong class="font-bold block text-emerald-900 mb-0.5">Petunjuk Pengisian Lembar Pengesahan:</strong>
                Ketik dan sesuaikan isian di bawah ini. Anda dapat menambahkan anggota tim dengan mengklik tombol <strong>+ Tambah Anggota Tim</strong>. Setelah isian lengkap, klik tombol <strong>Generate into PDF</strong> di bagian bawah untuk mencetak dokumen format PDF resmi UNJ.
            </div>
        </div>

        {{-- Main Form --}}
        <form method="POST" action="{{ route('hackaton.submissions.lembar_pengesahan.pdf', $submission) }}" target="_blank" class="space-y-6">
            @csrf

            {{-- 1. Judul Inovasi & Kategori Focus Challenge --}}
            <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm space-y-4">
                <div class="border-b border-gray-200 pb-3 flex items-center gap-2">
                    <span class="w-6 h-6 bg-gray-900 text-white text-xs font-bold rounded-full flex items-center justify-center">1</span>
                    <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Judul & Kategori</h2>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            Judul Inovasi <span class="text-rose-600">*</span>
                        </label>
                        <textarea name="judul_inovasi" x-model="form.judul_inovasi" rows="3" required
                            class="w-full border border-gray-300 rounded-xl p-3 text-xs font-medium focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 bg-white"
                            placeholder="Ketik Judul Inovasi..."></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            Kategori Focus Challenge <span class="text-rose-600">*</span>
                        </label>
                        <input type="text" name="kategori_focus_challenge" x-model="form.kategori_focus_challenge" required
                            class="w-full border border-gray-300 rounded-xl p-2.5 text-xs font-medium focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 bg-white"
                            placeholder="Ketik Kategori Focus Challenge (contoh: D-FARM / D-MARC)...">
                    </div>
                </div>
            </div>

            {{-- 2. Data Ketua Tim --}}
            <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm space-y-4">
                <div class="border-b border-gray-200 pb-3 flex items-center gap-2">
                    <span class="w-6 h-6 bg-gray-900 text-white text-xs font-bold rounded-full flex items-center justify-center">2</span>
                    <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Data Ketua Tim</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            - Nama Lengkap <span class="text-rose-600">*</span>
                        </label>
                        <input type="text" name="ketua_nama" x-model="form.ketua_nama" required
                            class="w-full border border-gray-300 rounded-xl p-2.5 text-xs font-medium bg-white focus:ring-2 focus:ring-emerald-600"
                            placeholder="Nama Lengkap Ketua Tim">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            - NIM / NIP / NIK
                        </label>
                        <input type="text" name="ketua_nik_nim_nip" x-model="form.ketua_nik_nim_nip"
                            class="w-full border border-gray-300 rounded-xl p-2.5 text-xs font-medium bg-white focus:ring-2 focus:ring-emerald-600"
                            placeholder="NIM / NIP / NIK Ketua Tim">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            - Prodi / Fakultas / Instansi
                        </label>
                        <input type="text" name="ketua_instansi" x-model="form.ketua_instansi"
                            class="w-full border border-gray-300 rounded-xl p-2.5 text-xs font-medium bg-white focus:ring-2 focus:ring-emerald-600"
                            placeholder="Contoh: Pendidikan Teknik Elektro / FT / UNJ">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            - Pekerjaan
                        </label>
                        <input type="text" name="ketua_pekerjaan" x-model="form.ketua_pekerjaan"
                            class="w-full border border-gray-300 rounded-xl p-2.5 text-xs font-medium bg-white focus:ring-2 focus:ring-emerald-600"
                            placeholder="Contoh: Dosen UNJ / Tendik UNJ">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            - No. HP / WA
                        </label>
                        <input type="text" name="ketua_no_hp" x-model="form.ketua_no_hp"
                            class="w-full border border-gray-300 rounded-xl p-2.5 text-xs font-medium bg-white focus:ring-2 focus:ring-emerald-600"
                            placeholder="Contoh: 081234567890">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            - Email
                        </label>
                        <input type="email" name="ketua_email" x-model="form.ketua_email"
                            class="w-full border border-gray-300 rounded-xl p-2.5 text-xs font-medium bg-white focus:ring-2 focus:ring-emerald-600"
                            placeholder="Contoh: ketua@unj.ac.id">
                    </div>
                </div>
            </div>

            {{-- 3. Anggota Tim (add button plus) --}}
            <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm space-y-4">
                <div class="border-b border-gray-200 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 bg-gray-900 text-white text-xs font-bold rounded-full flex items-center justify-center">3</span>
                        <div>
                            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Anggota Tim</h2>
                            <p class="text-[11px] text-gray-500">
                                Format isian per baris: <code>Nama Lengkap / Pekerjaan</code> (Contoh: <code>Taryudi / Dosen UNJ</code>)
                            </p>
                        </div>
                    </div>
                    <button type="button" @click="addAnggota()"
                        class="inline-flex items-center px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl transition shadow-sm self-start sm:self-auto cursor-pointer">
                        <i class="fas fa-plus mr-1.5"></i> Tambah Anggota Tim
                    </button>
                </div>

                <div class="space-y-3 pt-2">
                    <template x-for="(anggota, index) in form.anggota_tim" :key="index">
                        <div class="flex items-center gap-2.5">
                            <span class="w-36 text-xs font-bold text-gray-700 shrink-0" x-text="'- Anggota Tim ' + (index + 1) + ' / pekerjaan :'"></span>
                            <input type="text" name="anggota_tim[]" x-model="form.anggota_tim[index]"
                                class="flex-1 border border-gray-300 rounded-xl p-2.5 text-xs font-medium bg-white focus:ring-2 focus:ring-emerald-600"
                                placeholder="Contoh : Taryudi / Dosen UNJ">
                            <button type="button" @click="removeAnggota(index)"
                                class="p-2.5 text-rose-600 hover:bg-rose-50 border border-gray-300 hover:border-rose-400 rounded-xl transition cursor-pointer shrink-0"
                                title="Hapus Anggota Ini">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </template>

                    <div x-show="!form.anggota_tim || form.anggota_tim.length === 0" class="p-6 text-center text-xs text-gray-500 border border-dashed border-gray-300 rounded-xl">
                        Belum ada anggota tim tambahan. Klik tombol <strong>+ Tambah Anggota Tim</strong> di atas untuk menambahkan.
                    </div>
                </div>
            </div>

            {{-- 4. Tanggal & Pengesahan Tanda Tangan --}}
            <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm space-y-4">
                <div class="border-b border-gray-200 pb-3 flex items-center gap-2">
                    <span class="w-6 h-6 bg-gray-900 text-white text-xs font-bold rounded-full flex items-center justify-center">4</span>
                    <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Tempat, Tanggal & Pengesahan</h2>
                </div>

                {{-- Jakarta, (position in right) --}}
                <div class="flex justify-end">
                    <div class="w-full sm:w-1/2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5 text-right">
                            Tempat & Tanggal (Position in right)
                        </label>
                        <input type="text" name="tanggal_tempat" x-model="form.tanggal_tempat"
                            class="w-full border border-gray-300 rounded-xl p-2.5 text-xs font-medium bg-white text-right focus:ring-2 focus:ring-emerald-600"
                            placeholder="Contoh: Jakarta, 17 September 2026">
                    </div>
                </div>

                {{-- Mengetahui (left) & Ketua Tim (right) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                    {{-- Mengetahui, (position in left) --}}
                    <div class="border border-gray-300 rounded-xl bg-gray-50/50 p-4 space-y-3">
                        <div class="bg-gray-200/80 p-2 text-center text-xs font-bold uppercase tracking-wider text-gray-800 rounded-lg">
                            Mengetahui, (Position in left)
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-gray-600 mb-1">Jabatan Mengetahui</label>
                            <input type="text" name="mengetahui_jabatan" x-model="form.mengetahui_jabatan"
                                class="w-full border border-gray-300 rounded-lg p-2 text-xs bg-white focus:ring-1 focus:ring-emerald-600"
                                placeholder="Contoh: Dekan Fakultas Teknik / Pimpinan Unit">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-gray-600 mb-1">Nama Pejabat (input by typing)</label>
                            <input type="text" name="mengetahui_nama" x-model="form.mengetahui_nama"
                                class="w-full border border-gray-300 rounded-lg p-2 text-xs bg-white focus:ring-1 focus:ring-emerald-600"
                                placeholder="Ketik nama lengkap pejabat mengetahui...">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-gray-600 mb-1">NIP / NIK Pejabat</label>
                            <input type="text" name="mengetahui_nip" x-model="form.mengetahui_nip"
                                class="w-full border border-gray-300 rounded-lg p-2 text-xs bg-white focus:ring-1 focus:ring-emerald-600"
                                placeholder="Ketik NIP / NIK pejabat...">
                        </div>
                    </div>

                    {{-- Ketua Tim (position in right) --}}
                    <div class="border border-gray-300 rounded-xl bg-gray-50/50 p-4 space-y-3">
                        <div class="bg-gray-200/80 p-2 text-center text-xs font-bold uppercase tracking-wider text-gray-800 rounded-lg">
                            Ketua Tim (Position in right)
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-gray-600 mb-1">Jabatan</label>
                            <input type="text" value="Ketua Tim" disabled
                                class="w-full border border-gray-200 rounded-lg p-2 text-xs bg-gray-100 text-gray-700 font-bold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-gray-600 mb-1">Nama Ketua Tim (input by typing)</label>
                            <input type="text" name="ketua_ttd_nama" x-model="form.ketua_ttd_nama"
                                class="w-full border border-gray-300 rounded-lg p-2 text-xs font-semibold bg-white focus:ring-1 focus:ring-emerald-600"
                                placeholder="Ketik nama Ketua Tim...">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-gray-600 mb-1">NIM / NIP / NIK Ketua Tim</label>
                            <input type="text" name="ketua_ttd_nip" x-model="form.ketua_ttd_nip"
                                class="w-full border border-gray-300 rounded-lg p-2 text-xs bg-white focus:ring-1 focus:ring-emerald-600"
                                placeholder="Ketik NIM / NIP / NIK Ketua Tim...">
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
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition shadow cursor-pointer">
                        <i class="fas fa-file-pdf mr-2"></i> Generate into PDF
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
