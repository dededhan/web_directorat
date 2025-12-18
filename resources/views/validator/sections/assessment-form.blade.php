<div class="assessment-section">
    <!-- Score Summary Sticky Card -->
    <div class="card sticky-summary mb-4">
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-3">
                    <h6 class="text-muted">Total Skor Dosen</h6>
                    <h3 id="total-skor-dosen">0</h3>
                </div>
                <div class="col-md-3">
                    <h6 class="text-muted">Total Skor Validator</h6>
                    <h3 id="total-skor-validator">0</h3>
                </div>
                <div class="col-md-3">
                    <h6 class="text-muted">Selisih</h6>
                    <h3 id="selisih-skor">0</h3>
                </div>
                <div class="col-md-3">
                    <h6 class="text-muted">Nilai Tertimbang</h6>
                    <h3 id="nilai-tertimbang">0</h3>
                </div>
            </div>
        </div>
    </div>

    @foreach ($categories as $category)
        <div class="card mb-4 category-card" data-category-id="{{ $category->id }}">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">{{ $category->name }}</h5>
                <small>{{ $category->description ?? '' }}</small>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered assessment-table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="35%">Indikator</th>
                                <th width="10%">Bobot (%)</th>
                                <th width="10%">Skor Dosen</th>
                                <th width="10%">Skor Validator</th>
                                <th width="10%">Nilai Tertimbang</th>
                                <th width="20%">Komentar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($category->indicators as $index => $indicator)
                                @php
                                    $assessment = $assessments->get($indicator->id);
                                    $dosenScore = $assessment->dosen_score ?? 0;
                                    $validatorScore = $assessment->validator_score ?? null;
                                    $bobot = $indicator->bobot ?? 0;
                                    $comment = $assessment->indicator_comment ?? '';
                                @endphp
                                <tr data-indicator-id="{{ $indicator->id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $indicator->name }}</strong>
                                        @if ($indicator->description)
                                            <br><small class="text-muted">{{ $indicator->description }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $bobot }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-info">{{ $dosenScore }}</span>
                                    </td>
                                    <td>
                                        @if ($isReadOnly)
                                            <span class="badge bg-success">{{ $validatorScore ?? '-' }}</span>
                                        @else
                                            <input type="number" class="form-control form-control-sm validator-score"
                                                min="0" max="100" step="0.01"
                                                value="{{ $validatorScore }}" data-indicator-id="{{ $indicator->id }}"
                                                data-bobot="{{ $bobot }}" placeholder="0-100"
                                                {{ $isReadOnly ? 'readonly' : '' }}>
                                        @endif
                                    </td>
                                    <td class="text-center nilai-tertimbang-cell">
                                        <span class="nilai-tertimbang">0.00</span>
                                    </td>
                                    <td>
                                        @if ($isReadOnly)
                                            <small>{{ $comment ?: '-' }}</small>
                                        @else
                                            <textarea class="form-control form-control-sm indicator-comment" rows="2" placeholder="Komentar indikator"
                                                data-indicator-id="{{ $indicator->id }}" {{ $isReadOnly ? 'readonly' : '' }}>{{ $comment }}</textarea>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-secondary">
                                <td colspan="3" class="text-end"><strong>Total Kategori:</strong></td>
                                <td class="text-center"><strong class="category-dosen-total">0</strong></td>
                                <td class="text-center"><strong class="category-validator-total">0</strong></td>
                                <td class="text-center"><strong class="category-tertimbang-total">0.00</strong></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Category Comment -->
                <div class="mt-3">
                    <label class="form-label"><strong>Komentar Kategori {{ $category->name }}:</strong></label>
                    @php
                        $categoryComment = $categoryComments->get($category->id);
                    @endphp
                    @if ($isReadOnly)
                        <div class="alert alert-light">
                            {{ $categoryComment->comment ?? 'Tidak ada komentar' }}
                        </div>
                    @else
                        <textarea class="form-control category-comment" rows="4" placeholder="Berikan komentar umum untuk kategori ini..."
                            data-category-id="{{ $category->id }}" {{ $isReadOnly ? 'readonly' : '' }}>{{ $categoryComment->comment ?? '' }}</textarea>
                    @endif
                </div>

                <!-- Save Button -->
                @if (!$isReadOnly)
                    <div class="mt-3 text-end">
                        <button type="button" class="btn btn-primary btn-save-category"
                            data-category-id="{{ $category->id }}">
                            <i class='bx bx-save'></i> Simpan Penilaian Kategori
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // Calculate scores in real-time
            function calculateScores() {
                let totalDosenScore = 0;
                let totalValidatorScore = 0;
                let totalNilaiTertimbang = 0;

                $('.category-card').each(function() {
                    let categoryDosenTotal = 0;
                    let categoryValidatorTotal = 0;
                    let categoryTertimbangTotal = 0;

                    $(this).find('tbody tr').each(function() {
                        const dosenScore = parseFloat($(this).find('.badge.bg-info').text()) || 0;
                        const validatorScore = parseFloat($(this).find('.validator-score').val()) ||
                            0;
                        const bobot = parseFloat($(this).find('.validator-score').data('bobot')) ||
                            0;

                        const nilaiTertimbang = (validatorScore * bobot) / 100;

                        $(this).find('.nilai-tertimbang').text(nilaiTertimbang.toFixed(2));

                        categoryDosenTotal += dosenScore;
                        categoryValidatorTotal += validatorScore;
                        categoryTertimbangTotal += nilaiTertimbang;
                    });

                    $(this).find('.category-dosen-total').text(categoryDosenTotal.toFixed(2));
                    $(this).find('.category-validator-total').text(categoryValidatorTotal.toFixed(2));
                    $(this).find('.category-tertimbang-total').text(categoryTertimbangTotal.toFixed(2));

                    totalDosenScore += categoryDosenTotal;
                    totalValidatorScore += categoryValidatorTotal;
                    totalNilaiTertimbang += categoryTertimbangTotal;
                });

                $('#total-skor-dosen').text(totalDosenScore.toFixed(2));
                $('#total-skor-validator').text(totalValidatorScore.toFixed(2));
                $('#selisih-skor').text(Math.abs(totalDosenScore - totalValidatorScore).toFixed(2));
                $('#nilai-tertimbang').text(totalNilaiTertimbang.toFixed(2));
            }

            // Bind input events
            $('.validator-score').on('input', calculateScores);

            // Initial calculation
            calculateScores();

            // Save category assessment
            $('.btn-save-category').on('click', function() {
                if (window.isReadOnly) {
                    Swal.fire('Info', 'Penilaian dalam mode read-only', 'info');
                    return;
                }

                const categoryId = $(this).data('category-id');
                const categoryCard = $(`.category-card[data-category-id="${categoryId}"]`);

                const indicators = [];
                categoryCard.find('tbody tr').each(function() {
                    const indicatorId = $(this).data('indicator-id');
                    const dosenScore = parseFloat($(this).find('.badge.bg-info').text()) || 0;
                    const validatorScore = parseFloat($(this).find('.validator-score').val()) ||
                        null;
                    const bobot = parseFloat($(this).find('.validator-score').data('bobot')) || 0;
                    const comment = $(this).find('.indicator-comment').val() || '';

                    indicators.push({
                        indicator_id: indicatorId,
                        dosen_score: dosenScore,
                        validator_score: validatorScore,
                        bobot: bobot,
                        comment: comment
                    });
                });

                const categoryComment = categoryCard.find('.category-comment').val() || '';

                $.ajax({
                    url: `/validator/assess/${window.formId}/assessment`,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        category_id: categoryId,
                        indicators: indicators,
                        category_comment: categoryComment
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success');
                            // Refresh progress
                            window.validatorSPA.updateProgress();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', xhr.responseJSON?.message || 'Gagal menyimpan',
                            'error');
                    }
                });
            });
        });
    </script>
@endpush
