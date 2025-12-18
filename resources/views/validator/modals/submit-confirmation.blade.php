<!-- Modal Submit Confirmation -->
<div class="modal fade" id="modalSubmitConfirmation" tabindex="-1" aria-labelledby="modalSubmitConfirmationLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalSubmitConfirmationLabel">
                    <i class='bx bx-send'></i> Konfirmasi Submit Final
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class='bx bx-error-circle'></i> <strong>Perhatian!</strong>
                </div>

                <p>Anda akan melakukan submit final untuk penilaian ini.</p>

                <p><strong>Setelah submit:</strong></p>
                <ul>
                    <li>Semua data penilaian akan menjadi <strong>final</strong></li>
                    <li>Anda <strong>tidak dapat mengubah</strong> penilaian yang sudah disubmit</li>
                    <li>Data akan tetap dapat <strong>dilihat</strong> dalam mode read-only</li>
                    <li>Admin akan menerima notifikasi bahwa penilaian sudah selesai</li>
                </ul>

                <div class="alert alert-info">
                    <strong>Checklist Kelengkapan:</strong>
                    <ul class="mb-0" id="completion-checklist">
                        <li><i class='bx bx-loader-circle'></i> Loading...</li>
                    </ul>
                </div>

                <p class="text-danger"><strong>Apakah Anda yakin ingin melanjutkan?</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="btnConfirmSubmit">
                    <i class='bx bx-send'></i> Ya, Submit Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // When modal is shown, check completion status
            $('#modalSubmitConfirmation').on('shown.bs.modal', function() {
                $.ajax({
                    url: `/validator/assess/${window.formId}/progress`,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const progress = response.data;
                            const checklist = [{
                                    label: 'Persetujuan ditandatangani',
                                    completed: progress.agreement_completed
                                },
                                {
                                    label: 'Penilaian selesai',
                                    completed: progress.assessment_completed
                                },
                                {
                                    label: 'Berita Acara final',
                                    completed: progress.berita_acara_completed
                                },
                                {
                                    label: 'Record Hasil final',
                                    completed: progress.record_completed
                                }
                            ];

                            let html = '';
                            let allCompleted = true;

                            checklist.forEach(item => {
                                const icon = item.completed ?
                                    'bx-check-circle text-success' :
                                    'bx-x-circle text-danger';
                                html +=
                                    `<li><i class='bx ${icon}'></i> ${item.label}</li>`;
                                if (!item.completed) allCompleted = false;
                            });

                            $('#completion-checklist').html(html);

                            if (!allCompleted) {
                                $('#btnConfirmSubmit').prop('disabled', true);
                                $('#completion-checklist').after(
                                    '<div class="alert alert-danger mt-2">Lengkapi semua bagian sebelum submit</div>'
                                    );
                            }
                        }
                    }
                });
            });

            // Confirm submit
            $('#btnConfirmSubmit').on('click', function() {
                $(this).prop('disabled', true).html(
                    '<i class="bx bx-loader-circle bx-spin"></i> Submitting...');

                $.ajax({
                    url: `/validator/assess/${window.formId}/submit`,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', xhr.responseJSON?.message || 'Gagal submit',
                            'error');
                        $('#btnConfirmSubmit').prop('disabled', false).html(
                            '<i class="bx bx-send"></i> Ya, Submit Sekarang');
                    }
                });
            });
        });
    </script>
@endpush
