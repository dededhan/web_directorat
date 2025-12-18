<!-- Modal Form Pendukung Dosen -->
<div class="modal fade" id="modalFormPendukungDosen" tabindex="-1" aria-labelledby="modalFormPendukungDosenLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalFormPendukungDosenLabel">
                    <i class='bx bx-file'></i> Form Pendukung Dosen
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs" id="formDosenTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-informasi-dasar" data-bs-toggle="tab"
                            data-bs-target="#content-informasi-dasar" type="button" role="tab">
                            <i class='bx bx-info-circle'></i> Informasi Dasar
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-inovasi" data-bs-toggle="tab" data-bs-target="#content-inovasi"
                            type="button" role="tab">
                            <i class='bx bx-bulb'></i> Inovasi
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-lampiran" data-bs-toggle="tab"
                            data-bs-target="#content-lampiran" type="button" role="tab">
                            <i class='bx bx-paperclip'></i> Lampiran
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content mt-3" id="formDosenTabContent">
                    <!-- Informasi Dasar -->
                    <div class="tab-pane fade show active" id="content-informasi-dasar" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Informasi Dasar Inovasi</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"><strong>Judul Inovasi:</strong></label>
                                            <p>{{ $form->informasiDasar->judul ?? '-' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><strong>Fokus Bidang:</strong></label>
                                            <p>{{ $form->informasiDasar->fokus_bidang ?? '-' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><strong>Kategori:</strong></label>
                                            <p>{{ $form->informasiDasar->kategori ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"><strong>Tahun:</strong></label>
                                            <p>{{ $form->informasiDasar->tahun ?? '-' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><strong>Lokasi:</strong></label>
                                            <p>{{ $form->informasiDasar->lokasi ?? '-' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><strong>Status:</strong></label>
                                            <p><span
                                                    class="badge bg-info">{{ $form->informasiDasar->status ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                @if ($form->informasiDasar->deskripsi ?? false)
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Deskripsi:</strong></label>
                                        <div class="alert alert-light">
                                            {{ $form->informasiDasar->deskripsi }}
                                        </div>
                                    </div>
                                @endif

                                @if ($form->informasiDasar->tujuan ?? false)
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Tujuan:</strong></label>
                                        <div class="alert alert-light">
                                            {{ $form->informasiDasar->tujuan }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Inovasi -->
                    <div class="tab-pane fade" id="content-inovasi" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Detail Inovasi</h5>

                                @if ($form->inovasi->masalah ?? false)
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Permasalahan yang
                                                Diselesaikan:</strong></label>
                                        <div class="alert alert-light">
                                            {{ $form->inovasi->masalah }}
                                        </div>
                                    </div>
                                @endif

                                @if ($form->inovasi->solusi ?? false)
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Solusi yang Ditawarkan:</strong></label>
                                        <div class="alert alert-light">
                                            {{ $form->inovasi->solusi }}
                                        </div>
                                    </div>
                                @endif

                                @if ($form->inovasi->keunikan ?? false)
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Keunikan/Keunggulan:</strong></label>
                                        <div class="alert alert-light">
                                            {{ $form->inovasi->keunikan }}
                                        </div>
                                    </div>
                                @endif

                                @if ($form->inovasi->manfaat ?? false)
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Manfaat:</strong></label>
                                        <div class="alert alert-light">
                                            {{ $form->inovasi->manfaat }}
                                        </div>
                                    </div>
                                @endif

                                @if ($form->inovasi->target_pengguna ?? false)
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Target Pengguna:</strong></label>
                                        <div class="alert alert-light">
                                            {{ $form->inovasi->target_pengguna }}
                                        </div>
                                    </div>
                                @endif

                                @if ($form->inovasi->implementasi ?? false)
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Strategi Implementasi:</strong></label>
                                        <div class="alert alert-light">
                                            {{ $form->inovasi->implementasi }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Lampiran -->
                    <div class="tab-pane fade" id="content-lampiran" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Lampiran & Dokumen</h5>

                                @if ($form->lampiran && count($form->lampiran) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th width="30%">Jenis Dokumen</th>
                                                    <th width="45%">Nama File</th>
                                                    <th width="20%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($form->lampiran as $index => $lampiran)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $lampiran->jenis_dokumen ?? '-' }}</td>
                                                        <td>{{ $lampiran->nama_file ?? '-' }}</td>
                                                        <td>
                                                            @if ($lampiran->file_path)
                                                                <a href="{{ Storage::url($lampiran->file_path) }}"
                                                                    target="_blank" class="btn btn-sm btn-primary">
                                                                    <i class='bx bx-download'></i> Download
                                                                </a>
                                                            @else
                                                                <span class="text-muted">File tidak tersedia</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class='bx bx-info-circle'></i> Tidak ada lampiran yang tersedia.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
