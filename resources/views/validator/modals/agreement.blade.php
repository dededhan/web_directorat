<!-- Modal Agreement -->
<div class="modal fade" id="modalAgreement" tabindex="-1" aria-labelledby="modalAgreementLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalAgreementLabel">
                    <i class='bx bx-check-shield'></i> Persetujuan Validator
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="agreement-content">
                    <h5>Surat Pernyataan Validator</h5>
                    <p>Dengan ini saya menyatakan bahwa:</p>
                    <ol>
                        <li>Saya telah membaca dan memahami seluruh dokumen Form Pendukung Dosen yang meliputi Informasi
                            Dasar, Detail Inovasi, dan Lampiran pendukung.</li>
                        <li>Saya akan melakukan penilaian secara objektif, profesional, dan independen berdasarkan
                            kriteria KATSINOV yang telah ditetapkan.</li>
                        <li>Saya menjamin kerahasiaan seluruh informasi yang terkandung dalam dokumen yang dinilai.</li>
                        <li>Penilaian yang saya berikan merupakan hasil analisis mendalam dan dapat
                            dipertanggungjawabkan secara akademis.</li>
                        <li>Saya tidak memiliki konflik kepentingan dengan form yang dinilai.</li>
                    </ol>

                    <div class="alert alert-info mt-3">
                        <i class='bx bx-info-circle'></i> <strong>Penting:</strong> Setelah menandatangani persetujuan
                        ini, Anda dapat melanjutkan ke tahap penilaian. Tanda tangan digital Anda akan disimpan sebagai
                        bukti persetujuan.
                    </div>

                    @if ($agreement && $agreement->agreed_at)
                        <!-- Already Signed -->
                        <div class="alert alert-success">
                            <i class='bx bx-check-circle'></i> <strong>Sudah Ditandatangani</strong><br>
                            Tanggal: {{ $agreement->agreed_at->format('d F Y, H:i') }}<br>
                            IP Address: {{ $agreement->ip_address }}
                        </div>

                        <div class="signature-display">
                            <label class="form-label"><strong>Tanda Tangan Digital:</strong></label>
                            <div class="border p-2 bg-light">
                                <img src="{{ $agreement->signature_data }}" alt="Signature"
                                    style="max-width: 100%; height: auto;">
                            </div>
                        </div>
                    @else
                        <!-- Signature Pad -->
                        <div class="mt-4">
                            <label class="form-label"><strong>Tanda Tangan Digital:</strong></label>
                            <div class="signature-pad-wrapper border rounded">
                                <canvas id="signaturePad" width="700" height="200"
                                    style="width: 100%; touch-action: none;"></canvas>
                            </div>
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-outline-danger" id="clearSignature">
                                    <i class='bx bx-eraser'></i> Hapus Tanda Tangan
                                </button>
                                <small class="text-muted ms-2">Gunakan mouse atau touch untuk menandatangani</small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                @if (!$agreement || !$agreement->agreed_at)
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnSaveAgreement">
                        <i class='bx bx-check'></i> Setuju & Tandatangani
                    </button>
                @else
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script>
        $(document).ready(function() {
            let signaturePad = null;

            // Initialize signature pad when modal is shown
            $('#modalAgreement').on('shown.bs.modal', function() {
                @if (!$agreement || !$agreement->agreed_at)
                    const canvas = document.getElementById('signaturePad');
                    if (canvas && !signaturePad) {
                        signaturePad = new SignaturePad(canvas, {
                            backgroundColor: 'rgb(255, 255, 255)',
                            penColor: 'rgb(0, 0, 0)'
                        });

                        // Responsive canvas
                        function resizeCanvas() {
                            const ratio = Math.max(window.devicePixelRatio || 1, 1);
                            const rect = canvas.getBoundingClientRect();
                            canvas.width = rect.width * ratio;
                            canvas.height = rect.height * ratio;
                            canvas.getContext('2d').scale(ratio, ratio);
                            signaturePad.clear();
                        }

                        window.addEventListener('resize', resizeCanvas);
                        resizeCanvas();
                    }
                @endif
            });

            // Clear signature
            $('#clearSignature').on('click', function() {
                if (signaturePad) {
                    signaturePad.clear();
                }
            });

            // Save agreement
            $('#btnSaveAgreement').on('click', function() {
                if (!signaturePad || signaturePad.isEmpty()) {
                    Swal.fire('Peringatan', 'Silakan tandatangani terlebih dahulu', 'warning');
                    return;
                }

                const signatureData = signaturePad.toDataURL('image/png');

                $.ajax({
                    url: `/validator/assess/${window.formId}/agreement`,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        signature: signatureData
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success');
                            $('#modalAgreement').modal('hide');

                            // Refresh progress
                            window.validatorSPA.updateProgress();

                            // Reload page to show signed agreement
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', xhr.responseJSON?.message ||
                            'Gagal menyimpan persetujuan', 'error');
                    }
                });
            });
        });
    </script>
@endpush
