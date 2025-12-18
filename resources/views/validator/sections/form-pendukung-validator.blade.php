<div class="form-pendukung-validator-section">
    <div class="row">
        <!-- Berita Acara -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class='bx bx-file-blank'></i> Berita Acara</h5>
                </div>
                <div class="card-body">
                    <form id="form-berita-acara">
                        <div class="mb-3">
                            <label class="form-label">Nomor BA</label>
                            <input type="text" class="form-control" name="nomor_ba"
                                value="{{ $beritaAcara->nomor_ba ?? '' }}" placeholder="No: 001/BA/XII/2024"
                                {{ $isReadOnly ? 'readonly' : '' }}>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal"
                                    value="{{ $beritaAcara->tanggal ?? '' }}" {{ $isReadOnly ? 'readonly' : '' }}>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tempat</label>
                                <input type="text" class="form-control" name="tempat"
                                    value="{{ $beritaAcara->tempat ?? '' }}" placeholder="Ruang Meeting"
                                    {{ $isReadOnly ? 'readonly' : '' }}>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Waktu Mulai</label>
                                <input type="time" class="form-control" name="waktu_mulai"
                                    value="{{ $beritaAcara->waktu_mulai ?? '' }}" {{ $isReadOnly ? 'readonly' : '' }}>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Waktu Selesai</label>
                                <input type="time" class="form-control" name="waktu_selesai"
                                    value="{{ $beritaAcara->waktu_selesai ?? '' }}" {{ $isReadOnly ? 'readonly' : '' }}>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Peserta <small class="text-muted">(satu per baris)</small></label>
                            @if ($isReadOnly)
                                <div class="alert alert-light">
                                    @if ($beritaAcara && $beritaAcara->peserta)
                                        @foreach ($beritaAcara->peserta as $peserta)
                                            <div>• {{ $peserta }}</div>
                                        @endforeach
                                    @else
                                        Tidak ada data peserta
                                    @endif
                                </div>
                            @else
                                <textarea class="form-control" name="peserta" rows="3"
                                    placeholder="Nama Peserta 1&#10;Nama Peserta 2&#10;Nama Peserta 3" {{ $isReadOnly ? 'readonly' : '' }}>{{ is_array($beritaAcara->peserta ?? null) ? implode("\n", $beritaAcara->peserta) : '' }}</textarea>
                                <small class="text-muted">Pisahkan setiap peserta dengan enter/baris baru</small>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Agenda</label>
                            @if ($isReadOnly)
                                <div class="alert alert-light">{{ $beritaAcara->agenda ?? 'Tidak ada data' }}</div>
                            @else
                                <textarea class="form-control" name="agenda" rows="3" placeholder="Daftar agenda pembahasan..."
                                    {{ $isReadOnly ? 'readonly' : '' }}>{{ $beritaAcara->agenda ?? '' }}</textarea>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hasil Pembahasan</label>
                            @if ($isReadOnly)
                                <div class="alert alert-light">{{ $beritaAcara->hasil_pembahasan ?? 'Tidak ada data' }}
                                </div>
                            @else
                                <textarea class="form-control" name="hasil_pembahasan" rows="4" placeholder="Rangkuman hasil pembahasan..."
                                    {{ $isReadOnly ? 'readonly' : '' }}>{{ $beritaAcara->hasil_pembahasan ?? '' }}</textarea>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kesimpulan</label>
                            @if ($isReadOnly)
                                <div class="alert alert-light">{{ $beritaAcara->kesimpulan ?? 'Tidak ada data' }}</div>
                            @else
                                <textarea class="form-control" name="kesimpulan" rows="3" placeholder="Kesimpulan dari pembahasan..."
                                    {{ $isReadOnly ? 'readonly' : '' }}>{{ $beritaAcara->kesimpulan ?? '' }}</textarea>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rekomendasi</label>
                            @if ($isReadOnly)
                                <div class="alert alert-light">{{ $beritaAcara->rekomendasi ?? 'Tidak ada data' }}
                                </div>
                            @else
                                <textarea class="form-control" name="rekomendasi" rows="3" placeholder="Rekomendasi tindak lanjut..."
                                    {{ $isReadOnly ? 'readonly' : '' }}>{{ $beritaAcara->rekomendasi ?? '' }}</textarea>
                            @endif
                        </div>

                        @if (!$isReadOnly)
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-save-draft-ba">
                                    <i class='bx bx-save'></i> Simpan Draft
                                </button>
                                <button type="button" class="btn btn-success btn-save-final-ba">
                                    <i class='bx bx-check-circle'></i> Simpan Final
                                </button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <!-- Record Hasil Pengukuran -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class='bx bx-bar-chart-alt-2'></i> Record Hasil Pengukuran</h5>
                </div>
                <div class="card-body">
                    <form id="form-validator-record">
                        <div class="mb-3">
                            <label class="form-label">Executive Summary</label>
                            @if ($isReadOnly)
                                <div class="alert alert-light">
                                    {{ $validatorRecord->executive_summary ?? 'Tidak ada data' }}</div>
                            @else
                                <textarea class="form-control" name="executive_summary" rows="4"
                                    placeholder="Ringkasan eksekutif hasil penilaian..." {{ $isReadOnly ? 'readonly' : '' }}>{{ $validatorRecord->executive_summary ?? '' }}</textarea>
                            @endif
                        </div>

                        <h6 class="mt-4">Analisis SWOT</h6>

                        <div class="mb-3">
                            <label class="form-label"><i class='bx bx-trending-up text-success'></i> Strengths
                                (Kekuatan)</label>
                            @if ($isReadOnly)
                                <div class="alert alert-light">{{ $validatorRecord->strengths ?? 'Tidak ada data' }}
                                </div>
                            @else
                                <textarea class="form-control" name="strengths" rows="3" placeholder="Kekuatan yang ditemukan..."
                                    {{ $isReadOnly ? 'readonly' : '' }}>{{ $validatorRecord->strengths ?? '' }}</textarea>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class='bx bx-trending-down text-danger'></i> Weaknesses
                                (Kelemahan)</label>
                            @if ($isReadOnly)
                                <div class="alert alert-light">{{ $validatorRecord->weaknesses ?? 'Tidak ada data' }}
                                </div>
                            @else
                                <textarea class="form-control" name="weaknesses" rows="3" placeholder="Kelemahan yang ditemukan..."
                                    {{ $isReadOnly ? 'readonly' : '' }}>{{ $validatorRecord->weaknesses ?? '' }}</textarea>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class='bx bx-bulb text-warning'></i> Opportunities
                                (Peluang)</label>
                            @if ($isReadOnly)
                                <div class="alert alert-light">
                                    {{ $validatorRecord->opportunities ?? 'Tidak ada data' }}</div>
                            @else
                                <textarea class="form-control" name="opportunities" rows="3" placeholder="Peluang pengembangan..."
                                    {{ $isReadOnly ? 'readonly' : '' }}>{{ $validatorRecord->opportunities ?? '' }}</textarea>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class='bx bx-error text-danger'></i> Threats
                                (Ancaman)</label>
                            @if ($isReadOnly)
                                <div class="alert alert-light">{{ $validatorRecord->threats ?? 'Tidak ada data' }}
                                </div>
                            @else
                                <textarea class="form-control" name="threats" rows="3" placeholder="Ancaman/tantangan yang dihadapi..."
                                    {{ $isReadOnly ? 'readonly' : '' }}>{{ $validatorRecord->threats ?? '' }}</textarea>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Saran Perbaikan</label>
                            @if ($isReadOnly)
                                <div class="alert alert-light">
                                    {{ $validatorRecord->improvement_suggestions ?? 'Tidak ada data' }}</div>
                            @else
                                <textarea class="form-control" name="improvement_suggestions" rows="4" placeholder="Saran-saran perbaikan..."
                                    {{ $isReadOnly ? 'readonly' : '' }}>{{ $validatorRecord->improvement_suggestions ?? '' }}</textarea>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rekomendasi Implementasi</label>
                            @if ($isReadOnly)
                                <div class="alert alert-light">
                                    {{ $validatorRecord->implementation_recommendations ?? 'Tidak ada data' }}</div>
                            @else
                                <textarea class="form-control" name="implementation_recommendations" rows="4"
                                    placeholder="Rekomendasi untuk implementasi..." {{ $isReadOnly ? 'readonly' : '' }}>{{ $validatorRecord->implementation_recommendations ?? '' }}</textarea>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan Akhir</label>
                            @if ($isReadOnly)
                                <div class="alert alert-light">{{ $validatorRecord->final_notes ?? 'Tidak ada data' }}
                                </div>
                            @else
                                <textarea class="form-control" name="final_notes" rows="3" placeholder="Catatan akhir validator..."
                                    {{ $isReadOnly ? 'readonly' : '' }}>{{ $validatorRecord->final_notes ?? '' }}</textarea>
                            @endif
                        </div>

                        @if (!$isReadOnly)
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-save-draft-record">
                                    <i class='bx bx-save'></i> Simpan Draft
                                </button>
                                <button type="button" class="btn btn-info btn-save-final-record">
                                    <i class='bx bx-check-circle'></i> Simpan Final
                                </button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // Save Berita Acara Draft
            $('.btn-save-draft-ba').on('click', function() {
                saveBeritaAcara(false);
            });

            // Save Berita Acara Final
            $('.btn-save-final-ba').on('click', function() {
                saveBeritaAcara(true);
            });

            // Save Validator Record Draft
            $('.btn-save-draft-record').on('click', function() {
                saveValidatorRecord(false);
            });

            // Save Validator Record Final
            $('.btn-save-final-record').on('click', function() {
                saveValidatorRecord(true);
            });

            function saveBeritaAcara(isFinal) {
                if (window.isReadOnly) {
                    Swal.fire('Info', 'Penilaian dalam mode read-only', 'info');
                    return;
                }

                const formData = $('#form-berita-acara').serializeArray();
                const data = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    is_final: isFinal
                };

                // Convert peserta to array
                const pesertaText = $('textarea[name="peserta"]').val();
                data.peserta = pesertaText.split('\n').filter(p => p.trim() !== '');

                formData.forEach(item => {
                    if (item.name !== 'peserta') {
                        data[item.name] = item.value;
                    }
                });

                $.ajax({
                    url: `/validator/assess/${window.formId}/berita-acara`,
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success');
                            window.validatorSPA.updateProgress();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', xhr.responseJSON?.message || 'Gagal menyimpan', 'error');
                    }
                });
            }

            function saveValidatorRecord(isFinal) {
                if (window.isReadOnly) {
                    Swal.fire('Info', 'Penilaian dalam mode read-only', 'info');
                    return;
                }

                const data = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    is_final: isFinal,
                    executive_summary: $('textarea[name="executive_summary"]').val(),
                    strengths: $('textarea[name="strengths"]').val(),
                    weaknesses: $('textarea[name="weaknesses"]').val(),
                    opportunities: $('textarea[name="opportunities"]').val(),
                    threats: $('textarea[name="threats"]').val(),
                    improvement_suggestions: $('textarea[name="improvement_suggestions"]').val(),
                    implementation_recommendations: $('textarea[name="implementation_recommendations"]').val(),
                    final_notes: $('textarea[name="final_notes"]').val()
                };

                $.ajax({
                    url: `/validator/assess/${window.formId}/validator-record`,
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success');
                            window.validatorSPA.updateProgress();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', xhr.responseJSON?.message || 'Gagal menyimpan', 'error');
                    }
                });
            }
        });
    </script>
@endpush
