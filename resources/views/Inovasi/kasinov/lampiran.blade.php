<!-- Button trigger modal -->
<button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#katsinovModal">
    <i class="bi bi-cloud-upload"></i>
    Upload Dokumen KATSINOV
</button>

<!-- Include Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<!-- Modal -->
<div class="modal fade" id="katsinovModal" tabindex="-1" aria-labelledby="katsinovModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 bg-light">
                <h5 class="modal-title d-flex align-items-center gap-2" id="katsinovModalLabel">
                    <i class="bi bi-folder-plus text-primary"></i>
                    Upload Dokumen KATSINOV
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Jadwal program (Program Schedule)</label>
                                            <input type="file" class="form-control">
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
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Hasil simulasi dan pemodelan</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Hasil penelitian analitik</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Hasil eksperimen laboratorium</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Prototipe skala laboratorium</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Prototipe skala pilot</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Hasil uji kelayakan teknis</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Prototipe skala 1:1</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Uji pada simulasi lingkungan operasional</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Hasil test dan evaluasi</label>
                                            <input type="file" class="form-control">
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
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Kekayaan Intelektual: paten, lisensi, desain industri, dll</label>
                                            <input type="file" class="form-control">
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
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Identifikasi segmen, ukuran dan pangsa pasar</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Perhitungan kebutuhan investasi</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Estimasi harga produksi dibandingkan kompetitor</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Identifikasi kompetitor</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Model bisnis</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Posisioning pasar</label>
                                            <input type="file" class="form-control">
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
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Sumber daya manusia</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Analisis dan rencana bisnis</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Organisasi formal (struktur bisnis dengan staff dan kolaborator)</label>
                                            <input type="file" class="form-control">
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
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Kerjasama</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Pengelolaan kerjasama yang telah berjalan</label>
                                            <input type="file" class="form-control">
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
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Kajian risiko pasar</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Kajian risiko organisasi</label>
                                            <input type="file" class="form-control">
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
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Material, perkakas dan alat uji prototype</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Analisis rincian biaya</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Proses dan prosedur manufaktur</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Jaminan Mutu (Quality Assurance)</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Penerapan lean manufacturing</label>
                                            <input type="file" class="form-control">
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
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Market Value Proposition (MVP)</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Estimasi kondisi akhir produk</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Estimasi potensi pasar</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Estimasi ekspansi pasar</label>
                                            <input type="file" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 bg-light">
                <button type="button" class="btn btn-light d-flex align-items-center gap-2" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i>
                    Tutup
                </button>
                <button type="button" class="btn btn-primary d-flex align-items-center gap-2">
                    <i class="bi bi-cloud-arrow-up"></i>
                    Upload Semua
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* General Modal Styling */
.modal-content {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 0 40px rgba(0, 0, 0, 0.1);
}

.modal-xl {
    max-width: 90%;
}

/* Accordion Styling */
.accordion-item {
    border: none;
    margin-bottom: 0.5rem;
    border-radius: 0.5rem !important;
    overflow: hidden;
}

.accordion-button {
    padding: 1rem 1.25rem;
    background: #f8f9fa;
    font-weight: 600;
    border-radius: 0.5rem !important;
    transition: all 0.3s ease;
}

.accordion-button:not(.collapsed) {
    background: linear-gradient(135deg, #176369 0%, #1c7e86 100%);
    color: white;
}

.accordion-button:hover {
    background: linear-gradient(135deg, #176369 0%, #1c7e86 100%);
    color: white;
}

.accordion-button::after {
    transition: all 0.3s ease;
}

.accordion-body {
    padding: 1.5rem;
    background: #ffffff;
}

/* Section Styling */
.section-title {
    color: #176369;
    font-weight: 600;
    margin-bottom: 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid rgba(23, 99, 105, 0.2);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.upload-section {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 0.75rem;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.03);
    transition: all 0.3s ease;
}

.upload-section:hover {
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
}

/* Form Elements */
.form-label {
    color: #495057;
    font-weight: 500;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.form-control {
    border: 2px solid #e9ecef;
    border-radius: 0.5rem;
    padding: 0.625rem 1rem;
    transition: all 0.3s ease;
}

.form-control:hover {
    border-color: #176369;
}

.form-control:focus {
    border-color: #176369;
    box-shadow: 0 0 0 0.25rem rgba(23, 99, 105, 0.1);
}

/* Button Styling */
.btn {
    padding: 0.5rem 1.25rem;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #176369 0%, #1c7e86 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #145257 0%, #166970 100%);
    transform: translateY(-1px);
}

.btn-light {
    background: #f8f9fa;
    border: 2px solid #e9ecef;
}

.btn-light:hover {
    background: #e9ecef;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .modal-xl {
        margin: 0.5rem;
    }
    
    .upload-section {
        padding: 1rem;
    }
    
    .accordion-button {
        padding: 0.75rem 1rem;
    }
}

/* Custom File Input */
input[type="file"] {
    cursor: pointer;
}

input[type="file"]::-webkit-file-upload-button {
    visibility: hidden;
    display: none;
}

input[type="file"]::before {
    content: 'Pilih File';
    display: inline-block;
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-radius: 0.5rem;
    padding: 0.375rem 0.75rem;
    outline: none;
    white-space: nowrap;
    cursor: pointer;
    font-weight: 500;
    font-size: 0.9rem;
    margin-right: 0.5rem;
    transition: all 0.3s ease;
}

input[type="file"]:hover::before {
    border-color: #176369;
    color: #176369;
}

/* Loading States */
.uploading {
    position: relative;
    pointer-events: none;
}

.uploading::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<script>
// File input enhancement
document.querySelectorAll('input[type="file"]').forEach(input => {
    input.addEventListener('change', function(e) {
        const label = this.previousElementSibling;
        if (this.files.length > 0) {
            let fileName = this.files[0].name;
            if (fileName.length > 25) {
                fileName = fileName.substring(0, 22) + '...';
            }
            label.innerHTML = `
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-check-circle-fill text-success"></i>
                    ${fileName}
                </div>
            `;
        }
    });
});

// Upload button enhancement
document.querySelector('.btn-primary').addEventListener('click', function() {
    const sections = document.querySelectorAll('.upload-section');
    sections.forEach(section => {
        section.classList.add('uploading');
    });
    
    // Remove loading state after simulated upload (2 seconds)
    setTimeout(() => {
        sections.forEach(section => {
            section.classList.remove('uploading');
        });
    }, 2000);
});
</script>