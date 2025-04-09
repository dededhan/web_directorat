<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Lampiran</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('inovasi/lampirankatsinov/lampiran.css') }}">
</head>
<body class="bg-light p-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1 class="text-center mb-4">Sistem Upload Lampiran</h1>
                <p class="lead text-center mb-5">Silakan upload dokumen-dokumen yang diperlukan sesuai dengan kategori.</p>
                
                <!-- Alert Container -->
                <div id="alertContainer"></div>

                <!-- Accordion for File Uploads -->
                <div class="accordion custom-accordion" id="katsinovAccordion">
                    <!-- Aspek Teknologi -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#teknologiCollapse">
                                Aspek Teknologi
                            </button>
                        </h2>
                        <div id="teknologiCollapse" class="accordion-collapse collapse show" data-bs-parent="#katsinovAccordion">
                            <div class="accordion-body">
                                <!-- Dokumen Perencanaan -->
                                <div class="upload-section mb-4">
                                    <h6 class="section-title">Dokumen Perencanaan</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Proposal penelitian dan pengembangan</label>
                                            <input type="file" class="form-control">
                                            <div class="upload-progress-container">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Jadwal program (Program Schedule)</label>
                                            <input type="file" class="form-control">
                                            <div class="upload-progress-container">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <!-- Dokumen Pelaksanaan -->
                                    <div class="upload-section mb-4">
                                        <h6 class="section-title">Dokumen Pelaksanaan</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Desain secara teori dan empiris</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Hasil simulasi dan pemodelan</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Hasil penelitian analitik</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Hasil eksperimen laboratorium</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Prototipe skala laboratorium</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Prototipe skala pilot</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Hasil uji kelayakan teknis</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Prototipe skala 1:1</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Uji pada simulasi lingkungan operasional</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Hasil test dan evaluasi</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dokumen Publikasi -->
                                    <div class="upload-section">
                                        <h6 class="section-title">Dokumen Publikasi</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Publikasi ilmiah: paper, prosiding, jurnal, dll</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Kekayaan Intelektual: paten, lisensi, desain industri, dll</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Aspek Pasar -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pasarCollapse">
                                    Aspek Pasar
                                </button>
                            </h2>
                            <div id="pasarCollapse" class="accordion-collapse collapse" data-bs-parent="#katsinovAccordion">
                                <div class="accordion-body">
                                    <div class="upload-section">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Hasil Penelitian pasar (marketing research)</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Identifikasi segmen, ukuran dan pangsa pasar</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Perhitungan kebutuhan investasi</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Estimasi harga produksi dibandingkan kompetitor</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Identifikasi kompetitor</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Model bisnis</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Posisioning pasar</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Aspek Organisasi -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#organisasiCollapse">
                                    Aspek Organisasi
                                </button>
                            </h2>
                            <div id="organisasiCollapse" class="accordion-collapse collapse" data-bs-parent="#katsinovAccordion">
                                <div class="accordion-body">
                                    <div class="upload-section">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Strategi Inovasi</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Sumber daya manusia</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Analisis dan rencana bisnis</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Organisasi formal (struktur bisnis dengan staff dan kolaborator)</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Aspek Mitra -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#mitraCollapse">
                                    Aspek Mitra
                                </button>
                            </h2>
                            <div id="mitraCollapse" class="accordion-collapse collapse" data-bs-parent="#katsinovAccordion">
                                <div class="accordion-body">
                                    <div class="upload-section">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Daftar mitra potensial</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Kerjasama</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Pengelolaan kerjasama yang telah berjalan</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Aspek Pengendalian Risiko -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#risikoCollapse">
                                    Aspek Pengendalian Risiko
                                </button>
                            </h2>
                            <div id="risikoCollapse" class="accordion-collapse collapse" data-bs-parent="#katsinovAccordion">
                                <div class="accordion-body">
                                    <div class="upload-section">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Kajian risiko teknologi</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Kajian risiko pasar</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Kajian risiko organisasi</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Aspek Manufaktur -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#manufakturCollapse">
                                    Aspek Manufaktur
                                </button>
                            </h2>
                            <div id="manufakturCollapse" class="accordion-collapse collapse" data-bs-parent="#katsinovAccordion">
                                <div class="accordion-body">
                                    <div class="upload-section">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Analisis awal solusi material</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Material, perkakas dan alat uji prototype</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Analisis rincian biaya</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Proses dan prosedur manufaktur</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Jaminan Mutu (Quality Assurance)</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Penerapan lean manufacturing</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Aspek Investasi -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#investasiCollapse">
                                    Aspek Investasi
                                </button>
                            </h2>
                            <div id="investasiCollapse" class="accordion-collapse collapse" data-bs-parent="#katsinovAccordion">
                                <div class="accordion-body">
                                    <div class="upload-section">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Analisis pelanggan, pasar dan pesaing</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Market Value Proposition (MVP)</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Estimasi kondisi akhir produk</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Estimasi potensi pasar</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Estimasi ekspansi pasar</label>
                                                <input type="file" class="form-control">
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 bg-light">
                    <button type="button" class="btn btn-primary d-flex align-items-center gap-2" id="uploadAllBtn">
                        <i class="bi bi-cloud-arrow-up"></i>
                        Upload Semua
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('inovasi/lampirankatsinov/lampiran.js') }}"></script>
</body>
</html> 