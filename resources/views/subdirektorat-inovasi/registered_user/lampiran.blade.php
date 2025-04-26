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
        <form class="row justify-content-center" method="POST" action="{{ route('admin.Katsinov.lampiran.store', $id) }}" enctype="multipart/form-data">
            @csrf
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
                                            <input type="file" class="form-control" name="aspek_teknologi[proposal]">
                                            @if(isset($lampiran['aspek_teknologi']['proposal']))
                                                <div class="mt-2">
                                                    <span>File terupload:</span>
                                                    <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_teknologi']['proposal']->id) }}" 
                                                        target="_blank" 
                                                        class="document-preview">
                                                        Lihat Dokumen
                                                     </a>
                                                    <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                            onclick="confirmDelete('{{ $lampiran['aspek_teknologi']['proposal']->id }}')">
                                                        Hapus
                                                    </button>
                                                </div>
                                            @endif
                                            <div class="upload-progress-container">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Jadwal program (Program Schedule)</label>
                                            <input type="file" class="form-control" name="aspek_teknologi[jadwal]">
                                            @if(isset($lampiran['aspek_teknologi']['jadwal']))
                                                <div class="mt-2">
                                                    <span>File terupload:</span>
                                                    <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_teknologi']['jadwal']->id) }}" 
                                                        target="_blank" 
                                                        class="document-preview">
                                                        Lihat Dokumen
                                                     </a>
                                                    <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                            onclick="confirmDelete('{{ $lampiran['aspek_teknologi']['jadwal']->id }}')">
                                                        Hapus
                                                    </button>
                                                </div>
                                            @endif
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
                                                <input type="file" class="form-control" name="aspek_teknologi[desain]">
                                                @if(isset($lampiran['aspek_teknologi']['desain']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_teknologi']['desain']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_teknologi']['desain']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Hasil simulasi dan pemodelan</label>
                                                <input type="file" class="form-control" name="aspek_teknologi[simulasi_pemodelan]">
                                                @if(isset($lampiran['aspek_teknologi']['simulasi_pemodelan']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_teknologi']['simulasi_pemodelan']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_teknologi']['simulasi_pemodelan']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Hasil penelitian analitik</label>
                                                <input type="file" class="form-control" name="aspek_teknologi[penelitian_analitik]">
                                                @if(isset($lampiran['aspek_teknologi']['penelitian_analitik']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_teknologi']['penelitian_analitik']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_teknologi']['penelitian_analitik']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Hasil eksperimen laboratorium</label>
                                                <input type="file" class="form-control" name="aspek_teknologi[eksperimen_laboratorium]">
                                                @if(isset($lampiran['aspek_teknologi']['eksperimen_laboratorium']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_teknologi']['eksperimen_laboratorium']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_teknologi']['eksperimen_laboratorium']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Prototipe skala laboratorium</label>
                                                <input type="file" class="form-control" name="aspek_teknologi[prototipe_laboratorium]">
                                                @if(isset($lampiran['aspek_teknologi']['prototipe_laboratorium']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_teknologi']['prototipe_laboratorium']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_teknologi']['prototipe_laboratorium']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Prototipe skala pilot</label>
                                                <input type="file" class="form-control" name="aspek_teknologi[prototipe_pilot]">
                                                @if(isset($lampiran['aspek_teknologi']['prototipe_pilot']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_teknologi']['prototipe_pilot']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_teknologi']['prototipe_pilot']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Hasil uji kelayakan teknis</label>
                                                <input type="file" class="form-control" name="aspek_teknologi[uji_kelayakan]">
                                                @if(isset($lampiran['aspek_teknologi']['uji_kelayakan']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_teknologi']['uji_kelayakan']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_teknologi']['uji_kelayakan']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Prototipe skala 1:1</label>
                                                <input type="file" class="form-control" name="aspek_teknologi[prototipe_sebanding]">
                                                @if(isset($lampiran['aspek_teknologi']['prototipe_sebanding']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_teknologi']['prototipe_sebanding']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_teknologi']['prototipe_sebanding']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Uji pada simulasi lingkungan operasional</label>
                                                <input type="file" class="form-control" name="aspek_teknologi[simulasi_lingkungan]">
                                                @if(isset($lampiran['aspek_teknologi']['simulasi_lingkungan']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_teknologi']['simulasi_lingkungan']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_teknologi']['simulasi_lingkungan']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Hasil test dan evaluasi</label>
                                                <input type="file" class="form-control" name="aspek_teknologi[test_evaluasi]">
                                                @if(isset($lampiran['aspek_teknologi']['test_evaluasi']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_teknologi']['test_evaluasi']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_teknologi']['test_evaluasi']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
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
                                                <input type="file" class="form-control" name="aspek_teknologi[dokumen_ilmiah]">

                                                @if(isset($lampiran['aspek_teknologi']['dokumen_ilmiah']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_teknologi']['dokumen_ilmiah']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_teknologi']['dokumen_ilmiah']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Kekayaan Intelektual: paten, lisensi, desain industri, dll</label>
                                                <input type="file" class="form-control" name="aspek_teknologi[dokumen_haki]">
                                                @if(isset($lampiran['aspek_teknologi']['dokumen_haki']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_teknologi']['dokumen_haki']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_teknologi']['dokumen_haki']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
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
                                                <input type="file" class="form-control" name="aspek_pasar[penelitian_pasar]">
                                                @if(isset($lampiran['aspek_pasar']['penelitian_pasar']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_pasar']['penelitian_pasar']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_pasar']['penelitian_pasar']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Identifikasi segmen, ukuran dan pangsa pasar</label>
                                                <input type="file" class="form-control" name="aspek_pasar[identifkasi_segmen]">
                                                @if(isset($lampiran['aspek_pasar']['identifkasi_segmen']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_pasar']['identifkasi_segmen']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_pasar']['identifkasi_segmen']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Perhitungan kebutuhan investasi</label>
                                                <input type="file" class="form-control" name="aspek_pasar[perhitungan_kebutuhan]">
                                                @if(isset($lampiran['aspek_pasar']['perhitungan_kebutuhan']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_pasar']['perhitungan_kebutuhan']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_pasar']['perhitungan_kebutuhan']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Estimasi harga produksi dibandingkan kompetitor</label>
                                                <input type="file" class="form-control" name="aspek_pasar[estimasi_harga]">
                                                @if(isset($lampiran['aspek_pasar']['estimasi_harga']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_pasar']['estimasi_harga']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_pasar']['estimasi_harga']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Identifikasi kompetitor</label>
                                                <input type="file" class="form-control" name="aspek_pasar[identifikasi_kompetitor]">
                                                @if(isset($lampiran['aspek_pasar']['identifikasi_kompetitor']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_pasar']['identifikasi_kompetitor']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_pasar']['identifikasi_kompetitor']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Model bisnis</label>
                                                <input type="file" class="form-control" name="aspek_pasar[model_bisnis]">
                                                @if(isset($lampiran['aspek_pasar']['model_bisnis']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_pasar']['model_bisnis']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_pasar']['model_bisnis']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Posisioning pasar</label>
                                                <input type="file" class="form-control" name="aspek_pasar[posisioning_pasar]">
                                                @if(isset($lampiran['aspek_pasar']['posisioning_pasar']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_pasar']['posisioning_pasar']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_pasar']['posisioning_pasar']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
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
                                                <input type="file" class="form-control" name="aspek_organisasi[strategi_inovasi]">
                                                @if(isset($lampiran['aspek_organisasi']['strategi_inovasi']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_organisasi']['strategi_inovasi']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_organisasi']['strategi_inovasi']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Sumber daya manusia</label>
                                                <input type="file" class="form-control" name="aspek_organisasi[sdm]">
                                                @if(isset($lampiran['aspek_organisasi']['sdm']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_organisasi']['sdm']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_organisasi']['sdm']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Analisis dan rencana bisnis</label>
                                                <input type="file" class="form-control" name="aspek_organisasi[analisis_bisnis]">
                                                @if(isset($lampiran['aspek_organisasi']['analisis_bisnis']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_organisasi']['analisis_bisnis']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_organisasi']['analisis_bisnis']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Organisasi formal (struktur bisnis dengan staff dan kolaborator)</label>
                                                <input type="file" class="form-control" name="aspek_organisasi[struktur_bisnis]">
                                                @if(isset($lampiran['aspek_organisasi']['struktur_bisnis']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_organisasi']['struktur_bisnis']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_organisasi']['struktur_bisnis']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
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
                                                <input type="file" class="form-control" name="aspek_mitra[mitra_potensial]">
                                                @if(isset($lampiran['aspek_mitra']['mitra_potensial']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_mitra']['mitra_potensial']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_mitra']['mitra_potensial']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Kerjasama</label>
                                                <input type="file" class="form-control" name="aspek_mitra[kerjasama]">
                                                @if(isset($lampiran['aspek_mitra']['kerjasama']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_mitra']['kerjasama']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_mitra']['kerjasama']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Pengelolaan kerjasama yang telah berjalan</label>
                                                <input type="file" class="form-control" name="aspek_mitra[pengelolaan_kerjasama]">
                                                @if(isset($lampiran['aspek_mitra']['pengelolaan_kerjasama']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_mitra']['pengelolaan_kerjasama']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_mitra']['pengelolaan_kerjasama']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
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
                                                <input type="file" class="form-control" name="aspek_risiko[kajian_teknologi]">
                                                @if(isset($lampiran['aspek_risiko']['kajian_teknologi']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_risiko']['kajian_teknologi']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_risiko']['kajian_teknologi']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Kajian risiko pasar</label>
                                                <input type="file" class="form-control" name="aspek_risiko[kajian_pasar]">
                                                @if(isset($lampiran['aspek_risiko']['kajian_pasar']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_risiko']['kajian_pasar']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_risiko']['kajian_pasar']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Kajian risiko organisasi</label>
                                                <input type="file" class="form-control" name="aspek_risiko[kajian_organisasi]">
                                                @if(isset($lampiran['aspek_risiko']['kajian_organisasi']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_risiko']['kajian_organisasi']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_risiko']['kajian_organisasi']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
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
                                                <input type="file" class="form-control" name="aspek_manufaktur[analisis_materil]">
                                                @if(isset($lampiran['aspek_manufaktur']['analisis_materil']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_manufaktur']['analisis_materil']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_manufaktur']['analisis_materil']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Material, perkakas dan alat uji prototype</label>
                                                <input type="file" class="form-control" name="aspek_manufaktur[material_prototipe]">
                                                @if(isset($lampiran['aspek_manufaktur']['material_prototipe']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_manufaktur']['material_prototipe']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_manufaktur']['material_prototipe']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Analisis rincian biaya</label>
                                                <input type="file" class="form-control" name="aspek_manufaktur[analisis_biaya]">
                                                @if(isset($lampiran['aspek_manufaktur']['analisis_biaya']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_manufaktur']['analisis_biaya']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_manufaktur']['analisis_biaya']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Proses dan prosedur manufaktur</label>
                                                <input type="file" class="form-control" name="aspek_manufaktur[proses_prosedur]">
                                                @if(isset($lampiran['aspek_manufaktur']['proses_prosedur']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_manufaktur']['proses_prosedur']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_manufaktur']['proses_prosedur']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Jaminan Mutu (Quality Assurance)</label>
                                                <input type="file" class="form-control" name="aspek_manufaktur[jaminan_mutu]">
                                                @if(isset($lampiran['aspek_manufaktur']['jaminan_mutu']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_manufaktur']['jaminan_mutu']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_manufaktur']['jaminan_mutu']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Penerapan lean manufacturing</label>
                                                <input type="file" class="form-control" name="aspek_manufaktur[lean_manufaktur]">
                                                @if(isset($lampiran['aspek_manufaktur']['lean_manufaktur']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_manufaktur']['lean_manufaktur']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_manufaktur']['lean_manufaktur']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
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
                                                <input type="file" class="form-control" name="aspek_investasi[pelanggan_pasar]">
                                                @if(isset($lampiran['aspek_investasi']['pelanggan_pasar']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_investasi']['pelanggan_pasar']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_investasi']['pelanggan_pasar']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Market Value Proposition (MVP)</label>
                                                <input type="file" class="form-control" name="aspek_investasi[mvp]">
                                                @if(isset($lampiran['aspek_investasi']['mvp']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_investasi']['mvp']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_investasi']['mvp']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Estimasi kondisi akhir produk</label>
                                                <input type="file" class="form-control" name="aspek_investasi[kondisi_produk]">
                                                @if(isset($lampiran['aspek_investasi']['kondisi_produk']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_investasi']['kondisi_produk']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_investasi']['kondisi_produk']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Estimasi potensi pasar</label>
                                                <input type="file" class="form-control" name="aspek_investasi[potensi_pasar]">
                                                @if(isset($lampiran['aspek_investasi']['potensi_pasar']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_investasi']['potensi_pasar']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_investasi']['potensi_pasar']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="upload-progress-container">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Estimasi ekspansi pasar</label>
                                                <input type="file" class="form-control" name="aspek_investasi[ekspansi_pasar]">
                                                @if(isset($lampiran['aspek_investasi']['ekspansi_pasar']))
                                                    <div class="mt-2">
                                                        <span>File terupload:</span>
                                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_investasi']['ekspansi_pasar']->id) }}" 
                                                            target="_blank" 
                                                            class="document-preview">
                                                            Lihat Dokumen
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                                onclick="confirmDelete('{{ $lampiran['aspek_investasi']['ekspansi_pasar']->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endif
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
                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-2" id="uploadAllBtn">
                        <i class="bi bi-cloud-arrow-up"></i>
                        Upload Semua
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    {{-- <script src="{{ asset('inovasi/lampirankatsinov/lampiran.js') }}"></script> --}}
</body>
</html> 