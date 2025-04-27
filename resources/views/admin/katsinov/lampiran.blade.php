@extends('admin.admin')

<link rel="stylesheet" href="{{ asset('inovasi/lampirankatsinov/lampiran.css') }}">

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Upload Lampiran</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Upload Lampiran</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Sistem Upload Dokumen Lampiran</h3>
            </div>

            <form method="POST" action="{{ route('admin.Katsinov.lampiran.store', $id) }}" enctype="multipart/form-data">
                @csrf
                
                <!-- Aspek Teknologi -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>1. Aspek Teknologi</h4>
                    </div>
                    <div class="card-body">
                        <!-- Dokumen Perencanaan -->
                        <div class="subsection mb-4">
                            <h5>a) Dokumen Perencanaan</h5>
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
                                                    onclick="confirmDelete('{{ route($deleteRoute, $lampiran['aspek_teknologi']['proposal']->id )}}')">
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
                                                    onclick="confirmDelete('{{ route($deleteRoute, $lampiran['aspek_teknologi']['jadwal']->id )}}')">
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
                        <div class="subsection mb-4">
                            <h5>b) Dokumen Pelaksanaan</h5>
                            <div class="row">
                                @foreach([
                                    'desain' => 'Desain secara teori dan empiris',
                                    'simulasi_pemodelan' => 'Hasil simulasi dan pemodelan',
                                    'penelitian_analitik' => 'Hasil penelitian analitik',
                                    'eksperimen_laboratorium' => 'Hasil eksperimen laboratorium',
                                    'prototipe_laboratorium' => 'Prototipe skala laboratorium',
                                    'prototipe_pilot' => 'Prototipe skala pilot',
                                    'uji_kelayakan' => 'Hasil uji kelayakan teknis',
                                    'prototipe_sebanding' => 'Prototipe skala 1:1',
                                    'simulasi_lingkungan' => 'Uji pada simulasi lingkungan operasional',
                                    'test_evaluasi' => 'Hasil test dan evaluasi'
                                ] as $key => $label)
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">{{ $label }}</label>
                                        <input type="file" class="form-control" name="aspek_teknologi[{{ $key }}]">
                                        @if(isset($lampiran['aspek_teknologi'][$key]))
                                            <div class="mt-2">
                                                <span>File terupload:</span>
                                                <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_teknologi'][$key]->id) }}" 
                                                    target="_blank" 
                                                    class="document-preview">
                                                    Lihat Dokumen
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                        onclick="confirmDelete('{{ route($deleteRoute, $lampiran['aspek_teknologi'][$key]->id )}}')">
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
                                @endforeach
                            </div>
                        </div>

                        <!-- Dokumen Publikasi -->
                        <div class="subsection">
                            <h5>c) Dokumen Publikasi</h5>
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
                                                    onclick="confirmDelete('{{ route($deleteRoute, $lampiran['aspek_teknologi']['dokumen_ilmiah']->id )}}')"
                                                    >
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
                                                    onclick="confirmDelete('{{ route($deleteRoute, $lampiran['aspek_teknologi']['dokumen_haki']->id )}}')">
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

                <!-- Aspek Pasar -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>2. Aspek Pasar</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach([
                                'penelitian_pasar' => 'Hasil Penelitian pasar (marketing research)',
                                'identifkasi_segmen' => 'Identifikasi segmen, ukuran dan pangsa pasar',
                                'perhitungan_kebutuhan' => 'Perhitungan kebutuhan investasi',
                                'estimasi_harga' => 'Estimasi harga produksi dibandingkan kompetitor',
                                'identifikasi_kompetitor' => 'Identifikasi kompetitor',
                                'model_bisnis' => 'Model bisnis',
                                'posisioning_pasar' => 'Posisioning pasar'
                            ] as $key => $label)
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ $label }}</label>
                                    <input type="file" class="form-control" name="aspek_pasar[{{ $key }}]">
                                    @if(isset($lampiran['aspek_pasar'][$key]))
                                        <div class="mt-2">
                                            <span>File terupload:</span>
                                            <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_pasar'][$key]->id) }}" 
                                                target="_blank" 
                                                class="document-preview">
                                                Lihat Dokumen
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                    onclick="confirmDelete('{{ route($deleteRoute, $lampiran['aspek_pasar'][$key]->id )}}')">
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
                            @endforeach
                        </div>
                    </div>
                </div>

      <!-- Aspek Organisasi -->
      <div class="card mb-4">
                <div class="card-header">
                    <h4>3. Aspek Organisasi</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach([
                            'strategi_inovasi' => 'Strategi Inovasi',
                            'sdm' => 'Sumber Daya Manusia',
                            'analisis_bisnis' => 'Analisis dan Rencana Bisnis',
                            'struktur_bisnis' => 'Organisasi Formal (Struktur Bisnis dengan Staff dan Kolaborator)'
                        ] as $key => $label)
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ $label }}</label>
                                <input type="file" class="form-control" name="aspek_organisasi[{{ $key }}]">
                                @if(isset($lampiran['aspek_organisasi'][$key]))
                                    <div class="mt-2">
                                        <span>File terupload:</span>
                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_organisasi'][$key]->id) }}" 
                                            target="_blank" 
                                            class="document-preview">
                                            Lihat Dokumen
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                onclick="confirmDelete('{{ route($deleteRoute, $lampiran['aspek_organisasi'][$key]->id )}}')">
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
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Aspek Mitra -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>4. Aspek Mitra</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach([
                            'mitra_potensial' => 'Daftar Mitra Potensial',
                            'kerjasama' => 'Kerjasama',
                            'pengelolaan_kerjasama' => 'Pengelolaan Kerjasama yang Telah Berjalan'
                        ] as $key => $label)
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ $label }}</label>
                                <input type="file" class="form-control" name="aspek_mitra[{{ $key }}]">
                                @if(isset($lampiran['aspek_mitra'][$key]))
                                    <div class="mt-2">
                                        <span>File terupload:</span>
                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_mitra'][$key]->id) }}" 
                                            target="_blank" 
                                            class="document-preview">
                                            Lihat Dokumen
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                onclick="confirmDelete('{{ route($deleteRoute, $lampiran['aspek_mitra'][$key]->id )}}')">
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
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Aspek Pengendalian Risiko -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>5. Aspek Pengendalian Risiko</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach([
                            'kajian_teknologi' => 'Kajian Risiko Teknologi',
                            'kajian_pasar' => 'Kajian Risiko Pasar',
                            'kajian_organisasi' => 'Kajian Risiko Organisasi'
                        ] as $key => $label)
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ $label }}</label>
                                <input type="file" class="form-control" name="aspek_risiko[{{ $key }}]">
                                @if(isset($lampiran['aspek_risiko'][$key]))
                                    <div class="mt-2">
                                        <span>File terupload:</span>
                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_risiko'][$key]->id) }}" 
                                            target="_blank" 
                                            class="document-preview">
                                            Lihat Dokumen
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                onclick="confirmDelete('{{ route($deleteRoute, $lampiran['aspek_risiko'][$key]->id )}}')">
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
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Aspek Manufaktur -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>6. Aspek Manufaktur</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach([
                            'analisis_materil' => 'Analisis Awal Solusi Material',
                            'material_prototipe' => 'Material, Perkakas dan Alat Uji Prototipe',
                            'analisis_biaya' => 'Analisis Rincian Biaya',
                            'proses_prosedur' => 'Proses dan Prosedur Manufaktur',
                            'jaminan_mutu' => 'Jaminan Mutu (Quality Assurance)',
                            'lean_manufaktur' => 'Penerapan Lean Manufacturing'
                        ] as $key => $label)
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ $label }}</label>
                                <input type="file" class="form-control" name="aspek_manufaktur[{{ $key }}]">
                                @if(isset($lampiran['aspek_manufaktur'][$key]))
                                    <div class="mt-2">
                                        <span>File terupload:</span>
                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_manufaktur'][$key]->id) }}" 
                                            target="_blank" 
                                            class="document-preview">
                                            Lihat Dokumen
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                onclick="confirmDelete('{{ route($deleteRoute, $lampiran['aspek_manufaktur'][$key]->id )}}')">
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
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Aspek Investasi -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>7. Aspek Investasi</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach([
                            'pelanggan_pasar' => 'Analisis Pelanggan, Pasar dan Pesaing',
                            'mvp' => 'Market Value Proposition (MVP)',
                            'kondisi_produk' => 'Estimasi Kondisi Akhir Produk',
                            'potensi_pasar' => 'Estimasi Potensi Pasar',
                            'ekspansi_pasar' => 'Estimasi Ekspansi Pasar'
                        ] as $key => $label)
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ $label }}</label>
                                <input type="file" class="form-control" name="aspek_investasi[{{ $key }}]">
                                @if(isset($lampiran['aspek_investasi'][$key]))
                                    <div class="mt-2">
                                        <span>File terupload:</span>
                                        <a href="{{ route('admin.Katsinov.document.view', $lampiran['aspek_investasi'][$key]->id) }}" 
                                            target="_blank" 
                                            class="document-preview">
                                            Lihat Dokumen
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger ms-2" 
                                                onclick="confirmDelete('{{ route($deleteRoute, $lampiran['aspek_investasi'][$key]->id )}}')">
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
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="mb-3 d-flex justify-content-center mt-4">
                <button type="submit" class="btn" style="background-color: #277177; color: white;">
                    <i class="fas fa-cloud-upload-alt"></i> Upload Semua Dokumen
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(url) {
        if (confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) {
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (response.ok) {
                    window.location.reload();
                } else {
                    alert('Gagal menghapus dokumen');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }
</script>
@endsection