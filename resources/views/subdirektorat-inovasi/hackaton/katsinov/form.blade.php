@extends('subdirektorat-inovasi.hackaton.layout')

@section('title', ($isEdit ? 'Edit' : 'Mulai') . ' KATSINOV Self-Assessment | Hackathon UNJ')

@section('content_hackaton')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

    @php
        $initialResponses = (object) ($assessment->responses ?: []);
        $initialNotes = (object) ($assessment->notes ?: []);
        $initialSignature = $assessment->signature_image ?: null;
        $initialShareToken = $assessment->share_token ?: null;
    @endphp

    <script>
        function katsinovGenerator() {
            return {
                isEdit: {{ $isEdit ? 'true' : 'false' }},
                assessmentId: {{ $assessment->id ?: 'null' }},
                submissionId: {{ $submission ? $submission->id : 'null' }},
                minThreshold: 80.0,
                activeIndicator: 1,
                saving: false,
                savingSignature: false,
                showSignatureModal: false,
                signatureMode: 'draw', // 'draw' or 'upload'
                signaturePad: null,
                uploadedSignatureData: null,
                existingSignature: {!! json_encode($initialSignature) !!},
                shareUrl: {!! $initialShareToken ? json_encode(route('hackaton.katsinov.show_public', $initialShareToken)) : 'null' !!},
                downloadUrl: {!! $assessment->id ? json_encode(route('hackaton.katsinov.download_pdf', $assessment->id)) : 'null' !!},
                isCompleted: {{ $assessment->signed_at ? 'true' : 'false' }},
                responses: {!! json_encode($initialResponses, JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!},
                notes: {!! json_encode($initialNotes, JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!},

                // Config count of questions per indicator
                indicatorCounts: {
                    1: 22,
                    2: 21,
                    3: 21,
                    4: 22,
                    5: 24,
                    6: 14
                },

                init() {
                    // Check if signature already exists
                    if (this.existingSignature) {
                        this.uploadedSignatureData = this.existingSignature;
                    }
                },

                // Calculate single indicator stats
                getIndicatorStats(lvl) {
                    const count = this.indicatorCounts[lvl] || 0;
                    const maxScore = count * 5;
                    let earned = 0;
                    let answeredCount = 0;

                    for (let q = 1; q <= count; q++) {
                        const key = `i${lvl}_q${q}`;
                        if (this.responses[key] !== undefined && this.responses[key] !== null && this.responses[key] !== '') {
                            earned += parseInt(this.responses[key]) || 0;
                            answeredCount++;
                        }
                    }

                    const percentage = maxScore > 0 ? (earned / maxScore) * 100 : 0;
                    const isComplete = answeredCount === count;
                    const isPassed = percentage >= this.minThreshold;

                    return {
                        earned,
                        max: maxScore,
                        percentage: percentage.toFixed(1),
                        answeredCount,
                        totalCount: count,
                        isComplete,
                        isPassed
                    };
                },

                // Progressive unlock logic: Indicator N is unlocked if (N == 1) OR (Indicator N-1 is passed >= 80%)
                isUnlocked(lvl) {
                    if (lvl === 1) return true;
                    for (let i = 1; i < lvl; i++) {
                        const stats = this.getIndicatorStats(i);
                        if (!stats.isPassed) {
                            return false;
                        }
                    }
                    return true;
                },

                // Determine official achieved level
                getAchievedLevel() {
                    let level = 0;
                    for (let lvl = 1; lvl <= 6; lvl++) {
                        if (!this.isUnlocked(lvl)) break;
                        const stats = this.getIndicatorStats(lvl);
                        if (stats.isPassed) {
                            level = lvl;
                        } else {
                            break;
                        }
                    }
                    return level;
                },

                // Calculate overall average across unlocked/answered indicators
                getOverallPercentage() {
                    let totalPercent = 0;
                    let count = 0;
                    for (let lvl = 1; lvl <= 6; lvl++) {
                        if (this.isUnlocked(lvl)) {
                            const stats = this.getIndicatorStats(lvl);
                            totalPercent += parseFloat(stats.percentage);
                            count++;
                        }
                    }
                    return count > 0 ? (totalPercent / count).toFixed(1) : '0.0';
                },

                // Quick fill all remaining in current indicator with a score
                quickFill(lvl, value) {
                    const count = this.indicatorCounts[lvl] || 0;
                    for (let q = 1; q <= count; q++) {
                        this.responses[`i${lvl}_q${q}`] = value;
                    }
                },

                // Open Signature Modal
                async openSignatureModal() {
                    // First save current responses silently
                    const saved = await this.saveAssessmentData(false);
                    if (!saved) return;

                    this.showSignatureModal = true;
                    this.$nextTick(() => {
                        this.initSignaturePad();
                    });
                },

                initSignaturePad() {
                    const canvas = document.getElementById('signatureCanvas');
                    if (canvas && !this.signaturePad) {
                        // Adjust canvas for high DPI
                        const ratio = Math.max(window.devicePixelRatio || 1, 1);
                        canvas.width = canvas.offsetWidth * ratio;
                        canvas.height = canvas.offsetHeight * ratio;
                        canvas.getContext("2d").scale(ratio, ratio);

                        this.signaturePad = new SignaturePad(canvas, {
                            backgroundColor: 'rgb(255, 255, 255)',
                            penColor: 'rgb(15, 23, 42)',
                            minWidth: 1.5,
                            maxWidth: 3.5
                        });
                    }
                },

                clearSignature() {
                    if (this.signaturePad) {
                        this.signaturePad.clear();
                    }
                },

                handleFileUpload(event) {
                    const file = event.target.files[0];
                    if (!file) return;

                    if (!file.type.match('image.*')) {
                        Swal.fire('Format Salah', 'Silakan pilih berkas gambar (PNG, JPG, atau JPEG).', 'warning');
                        return;
                    }

                    if (file.size > 2 * 1024 * 1024) {
                        Swal.fire('Ukuran Terlalu Besar', 'Maksimal ukuran berkas tanda tangan adalah 2MB.', 'warning');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.uploadedSignatureData = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },

                // Save basic form + indicators responses
                async saveAssessmentData(showSuccessToast = true) {
                    this.saving = true;
                    const formElement = document.getElementById('katsinovForm');
                    const formData = new FormData(formElement);

                    // Ensure responses & notes are sent as pure objects to preserve key-value pairs
                    const safeResponses = (this.responses && typeof this.responses === 'object')
                        ? Object.assign({}, this.responses)
                        : {};
                    const safeNotes = (this.notes && typeof this.notes === 'object')
                        ? Object.assign({}, this.notes)
                        : {};

                    const payload = {
                        _token: '{{ csrf_token() }}',
                        assessment_id: this.assessmentId,
                        submission_id: this.submissionId,
                        judul_inovasi: formData.get('judul_inovasi'),
                        fokus_bidang: formData.get('fokus_bidang'),
                        nama_tim: formData.get('nama_tim'),
                        institusi: formData.get('institusi'),
                        alamat: formData.get('alamat'),
                        kontak: formData.get('kontak'),
                        assessment_date: formData.get('assessment_date'),
                        responses: safeResponses,
                        notes: safeNotes
                    };

                    try {
                        const res = await fetch("{{ route('hackaton.katsinov.store') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(payload)
                        });

                        const result = await res.json();

                        if (!res.ok) {
                            if (result.errors) {
                                const errorList = Object.values(result.errors).flat().join('<br>');
                                throw new Error(errorList || result.message);
                            }
                            throw new Error(result.message || 'Gagal menyimpan assessment.');
                        }

                        this.assessmentId = result.id;
                        this.downloadUrl = result.download_url;

                        if (showSuccessToast) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: result.message || 'Draft assessment berhasil disimpan!',
                                showConfirmButton: false,
                                timer: 2500
                            });
                        }

                        return true;
                    } catch (err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Menyimpan',
                            html: err.message
                        });
                        return false;
                    } finally {
                        this.saving = false;
                    }
                },

                // Save Signature to Server
                async saveSignature() {
                    let sigData = null;

                    if (this.signatureMode === 'draw') {
                        if (!this.signaturePad || this.signaturePad.isEmpty()) {
                            Swal.fire('Tanda Tangan Kosong', 'Silakan goreskan tanda tangan Anda pada kanvas terlebih dahulu.', 'warning');
                            return;
                        }
                        sigData = this.signaturePad.toDataURL('image/png');
                    } else {
                        if (!this.uploadedSignatureData) {
                            Swal.fire('Berkas Kosong', 'Silakan pilih berkas gambar tanda tangan Anda.', 'warning');
                            return;
                        }
                        sigData = this.uploadedSignatureData;
                    }

                    this.savingSignature = true;

                    try {
                        const url = `/hackathon/katsinov/${this.assessmentId}/signature`;
                        const res = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                signature_data: sigData
                            })
                        });

                        const result = await res.json();

                        if (!res.ok) {
                            throw new Error(result.message || 'Gagal menyimpan tanda tangan.');
                        }

                        this.existingSignature = result.signature_image;
                        this.shareUrl = result.share_url;
                        this.downloadUrl = result.download_url;
                        this.isCompleted = true;
                        this.showSignatureModal = false;

                        Swal.fire({
                            icon: 'success',
                            title: 'Pengesahan KATSINOV Selesai!',
                            html: `
                                <div class="text-left text-xs space-y-2 mt-2">
                                    <p>Tanda tangan Anda berhasil disahkan pada dokumen KATSINOV.</p>
                                    <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-200">
                                        <strong>Capaian Resmi: KATSINOV Level ${result.achieved_level} (${result.overall_percentage}%)</strong>
                                    </div>
                                    <p class="text-gray-500">Anda dapat langsung mengunduh PDF atau menggunakan tautan khusus untuk dilampirkan pada program Hackathon.</p>
                                </div>
                            `,
                            confirmButtonText: 'Bagus, Tampilkan Hasil',
                            confirmButtonColor: '#10b981'
                        });
                    } catch (err) {
                        Swal.fire('Gagal Menyimpan Tanda Tangan', err.message, 'error');
                    } finally {
                        this.savingSignature = false;
                    }
                },

                copyShareLink() {
                    if (!this.shareUrl) return;
                    navigator.clipboard.writeText(this.shareUrl).then(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Tautan Disalin!',
                            text: 'Tautan verifikasi KATSINOV telah disalin ke clipboard.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    });
                }
            };
        }
    </script>

    <div class="max-w-5xl mx-auto space-y-6 pb-28" x-data="katsinovGenerator()">
        {{-- Breadcrumb & Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-300">
            <div>
                <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                    <a href="{{ route('hackaton.dashboard') }}" class="hover:text-black">Dashboard</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <a href="{{ route('hackaton.katsinov.index') }}" class="hover:text-black">Generator KATSINOV</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span class="text-gray-900 font-bold">{{ $isEdit ? 'Edit Assessment' : 'Form Baru' }}</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
                    {{ $isEdit ? 'Edit Self-Assessment KATSINOV' : 'Form Pengukuran KATSINOV Mandiri' }}
                </h1>
                <p class="mt-1 text-xs text-gray-600">
                    @if($submission)
                        Terkait Proposal Tim: <strong>{{ $submission->identitas?->nama_produk ?? $submission->session->nama_sesi }}</strong>
                    @else
                        Pengukuran Kesiapan Inovasi Mandiri (KATSINOV 1 s/d 6)
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('hackaton.katsinov.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-xs font-semibold rounded-xl text-gray-700 hover:bg-gray-50 transition shadow-sm">
                    <i class="fas fa-arrow-left mr-1.5"></i> Kembali
                </a>
            </div>
        </div>

        {{-- SUCCESS COMPLETION BANNER IF ALREADY SIGNED --}}
        <template x-if="isCompleted">
            <div class="bg-gradient-to-r from-emerald-50 via-teal-50 to-white border border-emerald-300 rounded-2xl p-6 shadow-sm space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-emerald-200/60 pb-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-xl bg-emerald-700 text-white flex items-center justify-center text-xl shadow shrink-0">
                            <i class="fas fa-file-signature"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-emerald-200 text-emerald-900">
                                DOKUMEN SAH & BERTANDA TANGAN
                            </span>
                            <h3 class="text-lg font-bold text-gray-900 mt-1">Laporan KATSINOV Siap Digunakan</h3>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a :href="downloadUrl" class="inline-flex items-center px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl transition shadow">
                            <i class="fas fa-file-pdf mr-2 text-sm"></i> Unduh PDF Resmi
                        </a>
                        <button type="button" @click="openSignatureModal()" class="inline-flex items-center px-3 py-2 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 text-xs font-semibold rounded-xl transition">
                            <i class="fas fa-pen mr-1.5"></i> Ubah TTD
                        </button>
                    </div>
                </div>

                {{-- Shareable Link for Hackathon Proposal --}}
                <div class="bg-white rounded-xl p-4 border border-emerald-200 space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700">
                        <i class="fas fa-link text-emerald-600 mr-1"></i> Tautan Bukti KATSINOV untuk Pengajuan Proposal:
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="text" :value="shareUrl" readonly class="w-full bg-gray-50 border border-gray-300 rounded-xl p-2.5 text-xs text-gray-700 font-mono select-all">
                        <button type="button" @click="copyShareLink()" class="px-4 py-2.5 bg-gray-900 hover:bg-black text-white text-xs font-bold rounded-xl transition shrink-0 flex items-center gap-1.5">
                            <i class="fas fa-copy"></i>
                            <span>Salin Link</span>
                        </button>
                    </div>
                    <p class="text-[11px] text-gray-500 italic">
                        *Tautan ini dapat Anda gunakan atau lampirkan pada form pendaftaran Hackathon Tahap 1 di field <em>Hasil Katsinov</em>.
                    </p>
                </div>
            </div>
        </template>

        {{-- Main Form Container --}}
        <form id="katsinovForm" @submit.prevent="openSignatureModal()" class="space-y-6">
            {{-- 1. INFORMASI DASAR --}}
            <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm space-y-4">
                <div class="border-b border-gray-200 pb-3 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 bg-gray-900 text-white text-xs font-bold rounded-full flex items-center justify-center">1</span>
                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Informasi Dasar Inovasi</h2>
                    </div>
                    <span class="text-[11px] text-gray-500 italic">*Dicetak pada lembar pengesahan resmi</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                            Nama / Judul Inovasi <span class="text-rose-600">*</span>
                        </label>
                        <input type="text" name="judul_inovasi" value="{{ old('judul_inovasi', $assessment->judul_inovasi) }}" required
                            class="w-full border border-gray-300 rounded-xl p-2.5 text-xs font-medium focus:ring-2 focus:ring-black focus:border-black bg-white"
                            placeholder="Contoh: Mesin Pencacah Sampah Otomatis Berbasis IoT">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                            Fokus Bidang Inovasi
                        </label>
                        <input type="text" name="fokus_bidang" value="{{ old('fokus_bidang', $assessment->fokus_bidang) }}"
                            class="w-full border border-gray-300 rounded-xl p-2.5 text-xs font-medium focus:ring-2 focus:ring-black focus:border-black bg-white"
                            placeholder="Contoh: Energi Terbarukan / Smart Farming / Kesehatan">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                            Nama Tim Pengusul
                        </label>
                        <input type="text" name="nama_tim" value="{{ old('nama_tim', $assessment->nama_tim) }}"
                            class="w-full border border-gray-300 rounded-xl p-2.5 text-xs font-medium focus:ring-2 focus:ring-black focus:border-black bg-white"
                            placeholder="Nama Tim Inovasi">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                            Nama Lembaga / Institusi
                        </label>
                        <input type="text" name="institusi" value="{{ old('institusi', $assessment->institusi ?: 'Universitas Negeri Jakarta') }}"
                            class="w-full border border-gray-300 rounded-xl p-2.5 text-xs font-medium focus:ring-2 focus:ring-black focus:border-black bg-white"
                            placeholder="Institusi">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                            Kontak (No HP / Email)
                        </label>
                        <input type="text" name="kontak" value="{{ old('kontak', $assessment->kontak) }}"
                            class="w-full border border-gray-300 rounded-xl p-2.5 text-xs font-medium focus:ring-2 focus:ring-black focus:border-black bg-white"
                            placeholder="0812xxxx / email@unj.ac.id">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                            Tanggal Pengukuran <span class="text-rose-600">*</span>
                        </label>
                        <input type="date" name="assessment_date" value="{{ old('assessment_date', $assessment->assessment_date ? $assessment->assessment_date->format('Y-m-d') : date('Y-m-d')) }}" required
                            class="w-full border border-gray-300 rounded-xl p-2.5 text-xs font-medium focus:ring-2 focus:ring-black focus:border-black bg-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                            Alamat Lembaga
                        </label>
                        <input type="text" name="alamat" value="{{ old('alamat', $assessment->alamat ?: 'Kampus A UNJ, Jl. Rawamangun Muka, Jakarta Timur') }}"
                            class="w-full border border-gray-300 rounded-xl p-2.5 text-xs font-medium focus:ring-2 focus:ring-black focus:border-black bg-white"
                            placeholder="Alamat">
                    </div>
                </div>
            </div>

            {{-- 2. LIVE DASHBOARD CAPAIAN & ATURAN 80% --}}
            <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-black text-white rounded-2xl p-6 shadow-md space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-700 pb-4">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-amber-400">Ringkasan Hasil Real-Time</span>
                        <h3 class="text-lg font-bold">Hasil Pengukuran Kesiapan Inovasi</h3>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <span class="text-[10px] uppercase tracking-wider text-gray-400 block">Level Tercapai:</span>
                            <span class="text-2xl font-black text-amber-400" x-text="`KATSINOV ${getAchievedLevel()}`"></span>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-amber-400/20 border border-amber-400/40 flex items-center justify-center text-xl text-amber-300">
                            <i class="fas fa-award"></i>
                        </div>
                    </div>
                </div>

                {{-- Mini Status per Indicator 1..6 --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-2 pt-1">
                    @for($lvl = 1; $lvl <= 6; $lvl++)
                        <div class="rounded-xl p-3 border transition cursor-pointer"
                            :class="{
                                'bg-white/10 border-white/20': activeIndicator === {{ $lvl }},
                                'bg-black/30 border-white/5 opacity-60': activeIndicator !== {{ $lvl }},
                                'ring-2 ring-amber-400': activeIndicator === {{ $lvl }}
                            }"
                            @click="if(isUnlocked({{ $lvl }})) activeIndicator = {{ $lvl }}">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-[10px] font-bold uppercase">Level {{ $lvl }}</span>
                                <template x-if="!isUnlocked({{ $lvl }})">
                                    <i class="fas fa-lock text-[10px] text-gray-400" title="Terkunci"></i>
                                </template>
                                <template x-if="isUnlocked({{ $lvl }})">
                                    <i class="fas text-[10px]" :class="getIndicatorStats({{ $lvl }}).isPassed ? 'fa-check-circle text-emerald-400' : 'fa-circle text-amber-400'"></i>
                                </template>
                            </div>
                            <div class="text-sm font-bold" x-text="`${getIndicatorStats({{ $lvl }}).percentage}%`"></div>
                            <div class="text-[9px] text-gray-300" x-text="isUnlocked({{ $lvl }}) ? (getIndicatorStats({{ $lvl }}).isPassed ? 'Terpenuhi (≥80%)' : 'Tersimpan (<80%)') : 'Terkunci'"></div>
                        </div>
                    @endfor
                </div>

                <div class="text-[11px] text-gray-300 bg-white/5 rounded-xl p-3 flex items-start gap-2.5">
                    <i class="fas fa-info-circle text-amber-400 mt-0.5"></i>
                    <span>
                        <strong>Aturan Standar Minimal:</strong> Sebuah level dinyatakan lulus jika skor mencapai minimal <strong>80.0%</strong>. Jika misal Indikator 3 berhasil ($\ge 80\%$) dan Indikator 4 belum mencapai standar ($< 80\%$), seluruh jawaban Indikator 4 <strong>tetap tersimpan</strong> di sistem dan capaian resmi Anda tercatat di <strong>KATSINOV 3</strong>.
                    </span>
                </div>
            </div>

            {{-- 3. KUESIONER INDIKATOR 1 s/d 6 --}}
            <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm space-y-6">
                {{-- Tabs Navigation --}}
                <div class="flex items-center gap-1.5 border-b border-gray-200 pb-3 overflow-x-auto">
                    @for($lvl = 1; $lvl <= 6; $lvl++)
                        <button type="button"
                            @click="if(isUnlocked({{ $lvl }})) activeIndicator = {{ $lvl }}"
                            :disabled="!isUnlocked({{ $lvl }})"
                            class="px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 shrink-0"
                            :class="{
                                'bg-black text-white shadow': activeIndicator === {{ $lvl }},
                                'bg-gray-100 text-gray-700 hover:bg-gray-200': activeIndicator !== {{ $lvl }} && isUnlocked({{ $lvl }}),
                                'bg-gray-50 text-gray-300 cursor-not-allowed': !isUnlocked({{ $lvl }})
                            }">
                            <span>Indikator {{ $lvl }}</span>
                            <template x-if="!isUnlocked({{ $lvl }})">
                                <i class="fas fa-lock text-[10px]"></i>
                            </template>
                            <template x-if="isUnlocked({{ $lvl }}) && getIndicatorStats({{ $lvl }}).isPassed">
                                <i class="fas fa-check text-[10px] text-emerald-400"></i>
                            </template>
                        </button>
                    @endfor
                </div>

                {{-- Indicator Questions Panes --}}
                @foreach($questions as $lvl => $qList)
                    <div x-show="activeIndicator === {{ $lvl }}" class="space-y-4">
                        {{-- Indicator Header Info --}}
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">
                                    Indikator KATSINOV {{ $lvl }} (Total {{ count($qList) }} Butir Pertanyaan)
                                </h3>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    Pilih nilai <strong>0 s/d 5</strong> untuk setiap butir pernyataan berdasarkan kondisi inovasi Anda saat ini.
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-500">Skor Indikator {{ $lvl }}:</span>
                                <span class="px-2.5 py-1 rounded-lg bg-black text-white text-xs font-bold" x-text="`${getIndicatorStats({{ $lvl }}).percentage}%`"></span>
                            </div>
                        </div>

                        {{-- Table of Questions --}}
                        <div class="overflow-x-auto border border-gray-200 rounded-xl">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-100/80 text-[10px] font-bold uppercase tracking-wider text-gray-700 border-b border-gray-200">
                                        <th class="p-3 text-center w-12">No</th>
                                        <th class="p-3 text-center w-16">Aspek</th>
                                        <th class="p-3">Pernyataan Indikator</th>
                                        <th class="p-3 text-center w-64">Penilaian (0 - 5)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 text-xs">
                                    @foreach($qList as $q)
                                        @php
                                            $aspectInfo = $aspects[$q['aspect']] ?? ['name' => $q['aspect'], 'color' => '#6b7280'];
                                        @endphp
                                        <tr class="hover:bg-gray-50/70 transition">
                                            <td class="p-3 text-center font-bold text-gray-500">
                                                {{ $q['no'] }}
                                            </td>
                                            <td class="p-3 text-center">
                                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold text-white shadow-sm" style="background-color: {{ $aspectInfo['color'] }};" title="{{ $aspectInfo['name'] }}">
                                                    {{ $q['aspect'] }}
                                                </span>
                                            </td>
                                            <td class="p-3 text-gray-800 leading-relaxed font-medium">
                                                {{ $q['desc'] }}
                                            </td>
                                            <td class="p-3">
                                                <div class="flex items-center justify-center gap-1.5">
                                                    @for($val = 0; $val <= 5; $val++)
                                                        <label class="cursor-pointer select-none">
                                                            <input type="radio"
                                                                name="i{{ $lvl }}_q{{ $q['no'] }}"
                                                                value="{{ $val }}"
                                                                x-model="responses['i{{ $lvl }}_q{{ $q['no'] }}']"
                                                                class="sr-only peer">
                                                            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold border transition peer-checked:bg-black peer-checked:text-white peer-checked:border-black peer-checked:shadow bg-white text-gray-700 border-gray-300 hover:bg-gray-100">
                                                                {{ $val }}
                                                            </span>
                                                        </label>
                                                    @endfor
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Footer of Indicator Tab --}}
                        <div class="flex items-center justify-between pt-2">
                            <button type="button" @click="quickFill({{ $lvl }}, 4)" class="text-xs text-gray-500 hover:text-black underline">
                                Isi cepat nilai 4 untuk semua butir Indikator {{ $lvl }}
                            </button>

                            <div class="flex items-center gap-2">
                                @if($lvl > 1)
                                    <button type="button" @click="activeIndicator = {{ $lvl - 1 }}" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-xs font-bold rounded-lg text-gray-700">
                                        &larr; Indikator {{ $lvl - 1 }}
                                    </button>
                                @endif
                                @if($lvl < 6)
                                    <button type="button"
                                        @click="if(isUnlocked({{ $lvl + 1 }})) activeIndicator = {{ $lvl + 1 }}"
                                        :disabled="!isUnlocked({{ $lvl + 1 }})"
                                        class="px-3 py-1.5 text-xs font-bold rounded-lg transition"
                                        :class="isUnlocked({{ $lvl + 1 }}) ? 'bg-black text-white hover:bg-gray-800' : 'bg-gray-200 text-gray-400 cursor-not-allowed'">
                                        Lanjut ke Indikator {{ $lvl + 1 }} &rarr;
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </form>

        {{-- STICKY FLOATING BOTTOM ACTION BAR --}}
        <div class="fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-md border-t border-gray-300 py-3.5 px-6 shadow-2xl z-30">
            <div class="max-w-5xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-black text-amber-400 flex items-center justify-center text-lg font-black shrink-0">
                        <span x-text="getAchievedLevel()"></span>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-500 block">Status Capaian:</span>
                        <div class="text-sm font-bold text-gray-900">
                            KATSINOV Level <span x-text="getAchievedLevel()"></span>
                            <span class="text-xs font-normal text-gray-500" x-text="`(Rata-rata: ${getOverallPercentage()}%)`"></span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button"
                        @click="saveAssessmentData(true)"
                        :disabled="saving"
                        class="px-4 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-800 text-xs font-bold rounded-xl transition shadow-sm flex items-center gap-2">
                        <i class="fas" :class="saving ? 'fa-spinner fa-spin' : 'fa-save'"></i>
                        <span x-text="saving ? 'Menyimpan...' : 'Simpan Draft'"></span>
                    </button>

                    <button type="button"
                        @click="openSignatureModal()"
                        :disabled="saving"
                        class="px-5 py-2.5 bg-black hover:bg-gray-800 text-white text-xs font-bold rounded-xl transition shadow flex items-center gap-2">
                        <i class="fas fa-file-signature text-amber-400"></i>
                        <span>Simpan & Tanda Tangani</span>
                    </button>

                    <template x-if="isCompleted">
                        <a :href="downloadUrl"
                            class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl transition shadow flex items-center gap-2 border border-emerald-800">
                            <i class="fas fa-file-pdf"></i>
                            <span>Unduh PDF</span>
                        </a>
                    </template>
                </div>
            </div>
        </div>

        {{-- SIGNATURE MODAL --}}
        <div x-show="showSignatureModal"
            x-cloak
            class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm flex items-center justify-center p-4"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">

            <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl space-y-5"
                @click.away="showSignatureModal = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100">

                <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-amber-600 block">Pengesahan Dokumen</span>
                        <h3 class="text-base font-bold text-gray-900">Tanda Tangan Ketua Pengusul</h3>
                    </div>
                    <button type="button" @click="showSignatureModal = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 text-xs text-amber-900 flex items-start gap-2.5">
                    <i class="fas fa-award text-amber-600 mt-0.5"></i>
                    <div>
                        Hasil Capaian: <strong>KATSINOV Level <span x-text="getAchievedLevel()"></span> (<span x-text="getOverallPercentage()"></span>%)</strong>.<br>
                        Tanda tangan ini akan dicetak langsung pada Lembar Pengesahan laporan PDF resmi.
                    </div>
                </div>

                {{-- Mode Switcher: Draw vs Upload --}}
                <div class="flex rounded-xl bg-gray-100 p-1 text-xs font-bold">
                    <button type="button"
                        @click="signatureMode = 'draw'; $nextTick(() => initSignaturePad())"
                        class="flex-1 py-2 rounded-lg transition"
                        :class="signatureMode === 'draw' ? 'bg-white text-black shadow-sm' : 'text-gray-600 hover:text-black'">
                        <i class="fas fa-pen-nib mr-1.5"></i> Tanda Tangan Langsung
                    </button>
                    <button type="button"
                        @click="signatureMode = 'upload'"
                        class="flex-1 py-2 rounded-lg transition"
                        :class="signatureMode === 'upload' ? 'bg-white text-black shadow-sm' : 'text-gray-600 hover:text-black'">
                        <i class="fas fa-upload mr-1.5"></i> Unggah Gambar TTD
                    </button>
                </div>

                {{-- Mode 1: Signature Canvas --}}
                <div x-show="signatureMode === 'draw'" class="space-y-2">
                    <div class="border-2 border-dashed border-gray-300 rounded-2xl p-2 bg-gray-50 flex flex-col items-center justify-center relative">
                        <canvas id="signatureCanvas" class="w-full h-44 bg-white rounded-xl touch-none border border-gray-200 cursor-crosshair"></canvas>
                        <div class="absolute bottom-4 right-4">
                            <button type="button" @click="clearSignature()" class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-lg shadow-sm border border-gray-300">
                                <i class="fas fa-redo mr-1"></i> Bersihkan
                            </button>
                        </div>
                    </div>
                    <p class="text-[11px] text-gray-500 text-center">Goreskan tanda tangan Anda pada kotak di atas menggunakan mouse atau sentuhan layar.</p>
                </div>

                {{-- Mode 2: File Upload --}}
                <div x-show="signatureMode === 'upload'" class="space-y-3">
                    <div class="border-2 border-dashed border-gray-300 rounded-2xl p-4 bg-gray-50 text-center space-y-2">
                        <template x-if="uploadedSignatureData">
                            <div class="flex flex-col items-center space-y-2">
                                <img :src="uploadedSignatureData" alt="Preview TTD" class="max-h-32 object-contain bg-white p-2 border border-gray-200 rounded-xl shadow-sm">
                                <span class="text-xs text-emerald-600 font-semibold"><i class="fas fa-check-circle"></i> Berkas gambar siap digunakan</span>
                            </div>
                        </template>
                        <template x-if="!uploadedSignatureData">
                            <div class="py-4">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <p class="text-xs font-semibold text-gray-700">Pilih gambar tanda tangan (PNG / JPG)</p>
                                <p class="text-[10px] text-gray-400">Disarankan gambar berlatar belakang putih atau transparan</p>
                            </div>
                        </template>
                        <input type="file" accept="image/png,image/jpeg,image/jpg" @change="handleFileUpload($event)" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-black file:text-white hover:file:bg-gray-800 cursor-pointer">
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-200">
                    <button type="button" @click="showSignatureModal = false" class="px-4 py-2.5 text-xs font-bold text-gray-600 hover:text-black">
                        Batal
                    </button>
                    <button type="button"
                        @click="saveSignature()"
                        :disabled="savingSignature"
                        class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl transition shadow flex items-center gap-2">
                        <i class="fas" :class="savingSignature ? 'fa-spinner fa-spin' : 'fa-check'"></i>
                        <span x-text="savingSignature ? 'Menyimpan...' : 'Simpan Tanda Tangan & Selesaikan'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
