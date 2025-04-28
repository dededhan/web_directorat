@extends('subdirektorat-inovasi.registered_user.index')

<link rel="stylesheet" href="{{ asset('inovasi/forminformasidasar.css') }}">


@section('contentregistered_user')
<div class="head-title">
    <div class="left">
        <h1>Informasi Dasar</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Dashboard</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="#">Informasi Dasar</a>
            </li>
        </ul>
    </div>
</div>

<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Form Informasi Dasar (Basic Information)</h3>
        </div>
       
      
       
        <form action="{{ route('subdirektorat-inovasi.registered_user.informasi.store', $id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Section 1: Informasi Inovator -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>1. Informasi Inovator</h4>
                </div>
                <div class="card-body">
                    <!-- Subsection a -->
                    <div class="subsection mb-4">
                        <h5>a) Penangungjawab/ Pusat / Alamat Kontak/ Telp /Faks.
                            <span class="fst-italic">(Person in charge / Center for / Address / Telephone / Facsimile)</span>
                        </h5>
                        <div class="row mb-3">
                            <label class="col-md-3 form-label">Nama Penanggungjawab</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="person_in_charge" value="{{ !is_null($informasi)? $informasi->pic : '' }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-3 form-label">Institusi</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="pic_institution" value="{{ !is_null($informasi)? $informasi->institution : '' }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-3 form-label">Alamat Kontak</label>
                            <div class="col-md-9">
                                <textarea class="form-control" rows="3" name="pic_address">{{ !is_null($informasi)? $informasi->address : '' }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-3 form-label">Phone</label>
                            <div class="col-md-9">
                                <input type="tel" class="form-control" name="pic_phone" value="{{ !is_null($informasi)? $informasi->phone : '' }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-3 form-label">Fax.</label>
                            <div class="col-md-9">
                                <input type="tel" class="form-control" name="pic_fax" value="{{ !is_null($informasi)? $informasi->fax : '' }}">
                            </div>
                        </div>
                    </div>

                    <!-- Subsection b -->
                    <div class="subsection">
                        <h5>b) Anggota Tim <span class="fst-italic">(Team Member)</span></h5>
                        <div class="table-responsive">
                            <table class="table table-bordered team-table">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="50">No.</th>
                                        <th>Nama</th>
                                        <th>Keahlian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if (is_null($informasi_team))
                                <tr>
                                    <td>1</td>
                                    <td><input type="text" class="form-control" name="team[0][name]"></td>
                                    <td><input type="text" class="form-control" name="team[0][skill]"></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><input type="text" class="form-control" name="team[1][name]"></td>
                                    <td><input type="text" class="form-control" name="team[1][skill]"></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td><input type="text" class="form-control" name="team[2][name]"></td>
                                    <td><input type="text" class="form-control" name="team[2][skill]"></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td><input type="text" class="form-control" name="team[3][name]"></td>
                                    <td><input type="text" class="form-control" name="team[3][skill]"></td>
                                </tr>
                                @else
                                    @foreach ($informasi_team as $team)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><input type="text" class="form-control"  name="team[{{ $loop->index }}][name]" value="{{ $team['name'] }}"></td>
                                            <td><input type="text" class="form-control" name="team[{{ $loop->index }}][skill]" value="{{ $team['skill'] }}"></td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-primary" onclick="addTeamRow()">
                                <i class="fas fa-plus"></i> Tambah Anggota Tim
                            </button>
                        </div>
                        <div class="form-text text-muted mt-2">Catatan: row tabel anggota tim bisa ditambahkan bila diperlukan.</div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Informasi Tentang Inovasi -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>2. Informasi Tentang Inovasi Yang Dilaksanakan</h4>
                </div>
                <div class="card-body">
                    <!-- Title -->
                    <div class="row mb-4">
                        <label class="col-md-3 form-label">a) Judul Inovasi:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="innovation_title" value="{{ !is_null($informasi)? $informasi->innovation_title : '' }}">
                        </div>
                    </div>

                    <!-- Program Name -->
                    <div class="row mb-4">
                        <label class="col-md-3 form-label">b) Nama Program:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="innovation_name" value="{{ !is_null($informasi)? $informasi->innovation_name : '' }}">
                        </div>
                    </div>

                    <!-- Innovation Type -->
                    <div class="row mb-4">
                        <label class="col-md-3 form-label">c) Jenis Inovasi:</label>
                        <div class="col-md-9">
                            <div class="form-text mb-2 fst-italic">(pilih salah satu)</div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="innovation_type" id="produk" value="produk" @checked(!is_null($informasi) && $informasi->innovation_type == 'produk' )>
                                <label class="form-check-label" for="produk">Produk</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="innovation_type" id="pasar" value="pasar" @checked(!is_null($informasi) && $informasi->innovation_type == 'pasar' )>
                                <label class="form-check-label" for="pasar">Pasar</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="innovation_type" id="proses" value="proses" @checked(!is_null($informasi) && $informasi->innovation_type == 'proses' )>
                                <label class="form-check-label" for="proses">Proses</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="innovation_type" id="lainnya" value="lainnya" @checked(!is_null($informasi) && $informasi->innovation_type == 'lainnya' )>
                                <label class="form-check-label" for="lainnya">Lainnya</label>
                            </div>
                        </div>
                    </div>

                    <!-- Innovation Field -->
                    <div class="row mb-4">
                        <label class="col-md-3 form-label">d) Bidang Inovasi:</label>
                        <div class="col-md-9">
                            <div class="form-text mb-2 fst-italic">(pilih salah satu)</div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="innovation_field" id="hankam" value="hankam" @checked(!is_null($informasi) && $informasi->innovation_field == 'hankam' )>
                                        <label class="form-check-label" for="hankam">Teknologi Hankam</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="innovation_field" id="ict" value="ict" @checked(!is_null($informasi) && $informasi->innovation_field == 'ict' )>
                                        <label class="form-check-label" for="ict">ICT</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="innovation_field" id="transportasi" value="transportasi" @checked(!is_null($informasi) && $informasi->innovation_field == 'transportasi' )>
                                        <label class="form-check-label" for="transportasi">Teknologi Transportasi</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="innovation_field" id="pertanian" value="pertanian" @checked(!is_null($informasi) && $informasi->innovation_field == 'pertanian' )>
                                        <label class="form-check-label" for="pertanian">Teknologi Pertanian</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="innovation_field" id="lingkungan" value="lingkungan" @checked(!is_null($informasi) && $informasi->innovation_field == 'lingkungan' )>
                                        <label class="form-check-label" for="lingkungan">Teknologi Lingkungan</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="innovation_field" id="manufaktur" value="manufaktur" @checked(!is_null($informasi) && $informasi->innovation_field == 'manufaktur' )>
                                        <label class="form-check-label" for="manufaktur">Teknologi Manufaktur</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="innovation_field" id="material" value="material" @checked(!is_null($informasi) && $informasi->innovation_field == 'material' )>
                                        <label class="form-check-label" for="material">Teknologi Material</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="innovation_field" id="field-lainnya" value="lainnya" @checked(!is_null($informasi) && $informasi->innovation_field == 'lainnya' )>
                                        <label class="form-check-label" for="field-lainnya">Lainnya</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Application and Benefits -->
                    <div class="row mb-4">
                        <label class="col-md-3 form-label">e) Aplikasi dan Manfaat Inovasi:</label>
                        <div class="col-md-9">
                            <textarea class="form-control" rows="4" name="innovation_application">{{ !is_null($informasi)? $informasi->innovation_application : '' }}</textarea>
                        </div>
                    </div>

                    <!-- Program Implementation -->
                    <div class="row mb-4">
                        <label class="col-md-3 form-label">f) Pelaksanaan Program/Kegiatan:</label>
                        <div class="col-md-9">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Lama program/kegiatan yang direncanakan:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="innovation_duration" value="{{ !is_null($informasi)? $informasi->innovation_duration : ''}}">
                                        <span class="input-group-text">tahun</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Program/kegiatan yang berjalan tahun ke-:</label>
                                    <input type="text" class="form-control" name="innovation_year" value="{{ !is_null($informasi)? $informasi->innovation_year : ''}}">
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <label class="form-label">Sumber pendanaan:</label>
                                <div class="table-responsive">
                                    <table class="table table-bordered funding-table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th width="50">No</th>
                                                <th>Tahun ke-</th>
                                                <th>Total Dana</th>
                                                <th>Sumber Dana</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (is_null($informasi_program))
                                                <tr>
                                                    <td>1</td>
                                                    <td><input type="text" class="form-control" name="program_implementation[0][year]"></td>
                                                    <td><input type="text" class="form-control" name="program_implementation[0][funds]"></td>
                                                    <td><input type="text" class="form-control" name="program_implementation[0][source]"></td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td><input type="text" class="form-control" name="program_implementation[1][year]"></td>
                                                    <td><input type="text" class="form-control" name="program_implementation[1][funds]"></td>
                                                    <td><input type="text" class="form-control" name="program_implementation[1][source]"></td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td><input type="text" class="form-control" name="program_implementation[2][year]"></td>
                                                    <td><input type="text" class="form-control" name="program_implementation[2][funds]"></td>
                                                    <td><input type="text" class="form-control" name="program_implementation[2][source]"></td>
                                                </tr>
                                            @else
                                            @foreach ($informasi_program as $program)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <input type="text" class="form-control" 
                                                           name="program_implementation[{{ $loop->index }}][year]" 
                                                           value="{{ $program['year'] }}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" 
                                                           name="program_implementation[{{ $loop->index }}][funds]" 
                                                           value="{{ $program['funds'] }}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" 
                                                           name="program_implementation[{{ $loop->index }}][source]" 
                                                           value="{{ $program['source'] }}">
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Innovation Partners -->
                    <div class="row mb-4">
                        <label class="col-md-3 form-label">g) Mitra Dalam Inovasi:</label>
                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="table table-bordered partner-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th width="50">No</th>
                                            <th>Nama Mitra (Organisasi/perseorangan)</th>
                                            <th>Alamat Mitra</th>
                                            <th>Peran Mitra Dalam Inovasi</th>
                                            <th>Status Kerjasama Dengan Mitra</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (is_null($informasi_partner))
                                            <tr>
                                                <td>1</td>
                                                <td><input type="text" class="form-control" name="innovation_partner[0][name]"></td>
                                                <td><input type="text" class="form-control" name="innovation_partner[0][address]"></td>
                                                <td><input type="text" class="form-control" name="innovation_partner[0][role]"></td>
                                                <td><input type="text" class="form-control" name="innovation_partner[0][cooperation]"></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td><input type="text" class="form-control" name="innovation_partner[1][name]"></td>
                                                <td><input type="text" class="form-control" name="innovation_partner[1][address]"></td>
                                                <td><input type="text" class="form-control" name="innovation_partner[1][role]"></td>
                                                <td><input type="text" class="form-control" name="innovation_partner[1][cooperation]"></td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td><input type="text" class="form-control" name="innovation_partner[2][name]"></td>
                                                <td><input type="text" class="form-control" name="innovation_partner[2][address]"></td>
                                                <td><input type="text" class="form-control" name="innovation_partner[2][role]"></td>
                                                <td><input type="text" class="form-control" name="innovation_partner[2][cooperation]"></td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td><input type="text" class="form-control" name="innovation_partner[3][name]"></td>
                                                <td><input type="text" class="form-control" name="innovation_partner[3][address]"></td>
                                                <td><input type="text" class="form-control" name="innovation_partner[3][role]"></td>
                                                <td><input type="text" class="form-control" name="innovation_partner[3][cooperation]"></td>
                                            </tr>
                                        @else
                                            @foreach ($informasi_partner as $partner)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <input type="text" class="form-control" 
                                                           name="innovation_partner[{{ $loop->index }}][name]" 
                                                           value="{{ $partner['name'] }}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" 
                                                           name="innovation_partner[{{ $loop->index }}][address]" 
                                                           value="{{ $partner['address'] }}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" 
                                                           name="innovation_partner[{{ $loop->index }}][role]" 
                                                           value="{{ $partner['role'] }}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" 
                                                           name="innovation_partner[{{ $loop->index }}][cooperation]" 
                                                           value="{{ $partner['cooperation'] }}">
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Innovation Summary -->
                    <div class="row mb-4">
                        <label class="col-md-3 form-label">h) Ringkasan Inovasi Yang Dilaksanakan Dengan Pencapaian Yang Diharapkan:</label>
                        <div class="col-md-9">
                            <textarea class="form-control" rows="4" name="innovation_summary">{{ !is_null($informasi)? $informasi->innovation_summary : '' }}</textarea>
                        </div>
                    </div>

                    <!-- Innovation Novelty -->
                    <div class="row mb-4">
                        <label class="col-md-3 form-label">i) Kebaruan dan Keunggulan Inovasi:</label>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label class="form-label">Kebaruan yang ditawarkan dari inovasi yang dilakukan:</label>
                                <textarea class="form-control" rows="3" name="innovation_novelty">{{ !is_null($informasi)? $informasi->innovation_novelty : '' }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keunggulan yang membedakan dengan produk/jasa sejenis yang ada di pasar saat ini:</label>
                                <textarea class="form-control" rows="3" name="innovation_supremacy">{{ !is_null($informasi)? $informasi->innovation_supremacy : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Progress Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>3. Informasi Tentang Kemajuan Inovasi Yang Dilaksanakan</h4>
                </div>
                <div class="card-body">
                    <!-- Technology Development -->
                     <h5 class="mb-3">A) Pengembangan Teknologi</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered progress-table">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Uraian</th>
                                        <th>Belum/Sudah Tercapai*)</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                tr>
                                        <td>1</td>
                                        <td>Pengembangan prinsip dasar / Ide teknologi (misal: berupa tulisan, makalah menyangkut sifat dasar suatu teknologi)</td>
                                        <td>
                                            <select class="form-select" name="information_tech[0][status]">
                                                <option value="">Pilih status</option>
                                                <option value="belum" @if (isset($informasi_tech[0]) && $informasi_tech[0]['status'] == 'belum') selected @endif>Belum</option>
                                                <option value="sudah" @if (isset($informasi_tech[0]) && $informasi_tech[0]['status'] == 'sudah') selected @endif>Sudah</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="information_tech[0][explanation]" value="{{ isset($informasi_tech[0])? $informasi_tech[0]['explanation'] : '' }}"></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Formulasi Konsep dan/ atau aplikasi teknologi</td>
                                        <td>
                                            <select class="form-select" name="information_tech[1][status]">
                                                <option value="">Pilih status</option>
                                                <option value="belum" @if (isset($informasi_tech[1]) && $informasi_tech[1]['status'] == 'belum') selected @endif>Belum</option>
                                                <option value="sudah" @if (isset($informasi_tech[1]) && $informasi_tech[1]['status'] == 'sudah') selected @endif>Sudah</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="information_tech[1][explanation]" value="{{ isset($informasi_tech[1])? $informasi_tech[1]['explanation'] : '' }}"></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Pembuatan prototipe</td>
                                        <td>
                                            <select class="form-select" name="information_tech[2][status]">
                                                <option value="">Pilih status</option>
                                                <option value="belum" @if (isset($informasi_tech[2]) && $informasi_tech[2]['status'] == 'belum') selected @endif>Belum</option>
                                                <option value="sudah" @if (isset($informasi_tech[2]) && $informasi_tech[2]['status'] == 'sudah') selected @endif>Sudah</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="information_tech[2][explanation]" value="{{ isset($informasi_tech[2])? $informasi_tech[2]['explanation'] : '' }}"></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Hasil uji Prototipe dapat berfungsi baik</td>
                                        <td>
                                            <select class="form-select" name="information_tech[3][status]">
                                                <option value="">Pilih status</option>
                                                <option value="belum" @if (isset($informasi_tech[3]) && $informasi_tech[3]['status'] == 'belum') selected @endif>Belum</option>
                                                <option value="sudah" @if (isset($informasi_tech[3]) && $informasi_tech[3]['status'] == 'sudah') selected @endif>Sudah</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="information_tech[3][explanation]" value="{{ isset($informasi_tech[3])? $informasi_tech[3]['explanation'] : '' }}"></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Percobaan fungsi utama prototipe dalam lingkungan yang relevan (simulasi)</td>
                                        <td>
                                            <select class="form-select" name="information_tech[4][status]">
                                                <option value="">Pilih status</option>
                                                <option value="belum" @if (isset($informasi_tech[4]) && $informasi_tech[4]['status'] == 'belum') selected @endif>Belum</option>
                                                <option value="sudah" @if (isset($informasi_tech[4]) && $informasi_tech[4]['status'] == 'sudah') selected @endif>Sudah</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="information_tech[4][explanation]" value="{{ isset($informasi_tech[4])? $informasi_tech[4]['explanation'] : '' }}"></td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Validasi prototipe pada lingkungan yang relevan (simulasi)</td>
                                        <td>
                                            <select class="form-select" name="information_tech[5][status]">
                                                <option value="">Pilih status</option>
                                                <option value="belum" @if (isset($informasi_tech[5]) && $informasi_tech[5]['status'] == 'belum') selected @endif>Belum</option>
                                                <option value="sudah" @if (isset($informasi_tech[5]) && $informasi_tech[5]['status'] == 'sudah') selected @endif>Sudah</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="information_tech[5][explanation]" value="{{ isset($informasi_tech[5])? $informasi_tech[5]['explanation'] : '' }}"></td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>Validasi prototipe pada lingkungan yang sebenarnya</td>
                                        <td>
                                            <select class="form-select" name="information_tech[6][status]">
                                                <option value="">Pilih status</option>
                                                <option value="belum" @if (isset($informasi_tech[6]) && $informasi_tech[6]['status'] == 'belum') selected @endif>Belum</option>
                                                <option value="sudah" @if (isset($informasi_tech[6]) && $informasi_tech[6]['status'] == 'sudah') selected @endif>Sudah</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="information_tech[6][explanation]" value="{{ isset($informasi_tech[6])? $informasi_tech[6]['explanation'] : '' }}"></td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>Ujicoba/ demonstrasi prototipe pada lingkungan yg relevan</td>
                                        <td>
                                            <select class="form-select" name="information_tech[7][status]">
                                                <option value="">Pilih status</option>
                                                <option value="belum" @if (isset($informasi_tech[7]) && $informasi_tech[7]['status'] == 'belum') selected @endif>Belum</option>
                                                <option value="sudah" @if (isset($informasi_tech[7]) && $informasi_tech[7]['status'] == 'sudah') selected @endif>Sudah</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="information_tech[7][explanation]" value="{{ isset($informasi_tech[7])? $informasi_tech[7]['explanation'] : '' }}"></td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>Ujicoba/ demonstrasi prototipe pada lingkungan yg sebenarnya</td>
                                        <td>
                                            <select class="form-select" name="information_tech[8][status]">
                                                <option value="">Pilih status</option>
                                                <option value="belum" @if (isset($informasi_tech[8]) && $informasi_tech[8]['status'] == 'belum') selected @endif>Belum</option>
                                                <option value="sudah" @if (isset($informasi_tech[8]) && $informasi_tech[8]['status'] == 'sudah') selected @endif>Sudah</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="information_tech[8][explanation]" value="{{ isset($informasi_tech[8])? $informasi_tech[8]['explanation'] : '' }}"></td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>Telah dimanfaatkan sesuai fungsi yang dirancang / telah teruji / proven</td>
                                        <td>
                                            <select class="form-select" name="information_tech[9][status]">
                                                <option value="">Pilih status</option>
                                                <option value="belum" @if (isset($informasi_tech[9]) && $informasi_tech[9]['status'] == 'belum') selected @endif>Belum</option>
                                                <option value="sudah" @if (isset($informasi_tech[9]) && $informasi_tech[9]['status'] == 'sudah') selected @endif>Sudah</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="information_tech[9][explanation]" value="{{ isset($informasi_tech[9])? $informasi_tech[9]['explanation'] : '' }}"></td>
                                    </tr>
                                    <!-- ... More tech rows would continue here ... -->
                                </tbody>
                            </table>
                        </div>
                        <div class="form-text text-muted mt-2">*) pilih salah satu</div>
                    </div>
                    <!-- Market Evolution -->
                    <div class="subsection">
                        <h5 class="mb-3">B) Evolusi Pasar</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered progress-table">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Uraian</th>
                                        <th>Belum/Sudah Tercapai*)</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Kebutuhan dan permintaan pelanggan teramati</td>
                                        <td>
                                            <select class="form-select" name="information_market[0][status]">
                                                <option value="">Pilih status</option>
                                                <option value="belum" @if(isset($informasi_market[0]) && $informasi_market[0]['status'] == 'belum') selected @endif>Belum</option>
                                                <option value="sudah" @if(isset($informasi_market[0]) && $informasi_market[0]['status'] == 'sudah') selected @endif>Sudah</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="information_market[0][explanation]" value="{{ isset($informasi_market[0])? $informasi_market[0]['explanation'] : '' }}"></td>
                                    </tr>
                                    <tr>
                            <td>2</td>
                            <td>Pelanggan akhir teridentifikasi</td>
                            <td>
                                <select class="form-control" name="information_market[1][status]">
                                    <option value="">Pilih status</option>
                                    <option value="belum" @if(isset($informasi_market[1]) && $informasi_market[1]['status'] == 'belum') selected @endif>Belum</option>
                                    <option value="sudah" @if(isset($informasi_market[1]) && $informasi_market[1]['status'] == 'sudah') selected @endif>Sudah</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="information_market[1][explanation]" value="{{ isset($informasi_market[1])? $informasi_market[1]['explanation'] : '' }}"></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Telah dikeluarkan rencana luncuran pasar secara rinci</td>
                            <td>
                                <select class="form-control" name="information_market[2][status]">
                                    <option value="">Pilih status</option>
                                    <option value="belum" @if(isset($informasi_market[2]) && $informasi_market[2]['status'] == 'belum') selected @endif>Belum</option>
                                    <option value="sudah" @if(isset($informasi_market[2]) && $informasi_market[2]['status'] == 'sudah') selected @endif>Sudah</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="information_market[2][explanation]" value="{{ isset($informasi_market[2])? $informasi_market[2]['explanation'] : '' }}"></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Kebutuhan khusus dan keperluan pelanggan telah diketahui</td>
                            <td>
                                <select class="form-control" name="information_market[3][status]">
                                    <option value="">Pilih status</option>
                                    <option value="belum" @if(isset($informasi_market[3]) && $informasi_market[3]['status'] == 'belum') selected @endif>Belum</option>
                                    <option value="sudah" @if(isset($informasi_market[3]) && $informasi_market[3]['status'] == 'sudah') selected @endif>Sudah</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="information_market[3][explanation]" value="{{ isset($informasi_market[3])? $informasi_market[3]['explanation'] : '' }}"></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Segmen, ukuran dan pangsa pasar telah diprediksi</td>
                            <td>
                                <select class="form-control" name="information_market[4][status]">
                                    <option value="">Pilih status</option>
                                    <option value="belum" @if(isset($informasi_market[4]) && $informasi_market[4]['status'] == 'belum') selected @endif>Belum</option>
                                    <option value="sudah" @if(isset($informasi_market[4]) && $informasi_market[4]['status'] == 'sudah') selected @endif>Sudah</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="information_market[4][explanation]" value="{{ isset($informasi_market[4])? $informasi_market[4]['explanation'] : '' }}"></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Telah dikeluarkan harga dan luncuran produk</td>
                            <td>
                                <select class="form-control" name="information_market[5][status]">
                                    <option value="">Pilih status</option>
                                    <option value="belum" @if(isset($informasi_market[5]) && $informasi_market[5]['status'] == 'belum') selected @endif>Belum</option>
                                    <option value="sudah" @if(isset($informasi_market[5]) && $informasi_market[5]['status'] == 'sudah') selected @endif>Sudah</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="information_market[5][explanation]" value="{{ isset($informasi_market[5])? $informasi_market[5]['explanation'] : '' }}"></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Posisioning pasar</td>
                            <td>
                                <select class="form-control" name="information_market[6][status]">
                                    <option value="">Pilih status</option>
                                    <option value="belum" @if(isset($informasi_market[6]) && $informasi_market[6]['status'] == 'belum') selected @endif>Belum</option>
                                    <option value="sudah" @if(isset($informasi_market[6]) && $informasi_market[6]['status'] == 'sudah') selected @endif>Sudah</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="information_market[6][explanation]" value="{{ isset($informasi_market[6])? $informasi_market[6]['explanation'] : '' }}"></td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Model bisnis ditetapkan</td>
                            <td>
                                <select class="form-control" name="information_market[7][status]">
                                    <option value="">Pilih status</option>
                                    <option value="belum" @if(isset($informasi_market[7]) && $informasi_market[7]['status'] == 'belum') selected @endif>Belum</option>
                                    <option value="sudah" @if(isset($informasi_market[7]) && $informasi_market[7]['status'] == 'sudah') selected @endif>Sudah</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="information_market[7][explanation]" value="{{ isset($informasi_market[7])? $informasi_market[7]['explanation'] : '' }}"></td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Pemasaran ditekankan pada pengenalan dengan baik para pelanggannya</td>
                            <td>
                                <select class="form-control" name="information_market[8][status]">
                                    <option value="">Pilih status</option>
                                    <option value="belum" @if(isset($informasi_market[8]) && $informasi_market[8]['status'] == 'belum') selected @endif>Belum</option>
                                    <option value="sudah" @if(isset($informasi_market[8]) && $informasi_market[8]['status'] == 'sudah') selected @endif>Sudah</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="information_market[8][explanation]" value="{{ isset($informasi_market[8])? $informasi_market[8]['explanation'] : '' }}"></td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Pesaing diidentifikasi dengan baik</td>
                            <td>
                                <select class="form-control" name="information_market[9][status]">
                                    <option value="">Pilih status</option>
                                    <option value="belum" @if(isset($informasi_market[9]) && $informasi_market[9]['status'] == 'belum') selected @endif>Belum</option>
                                    <option value="sudah" @if(isset($informasi_market[9]) && $informasi_market[9]['status'] == 'sudah') selected @endif>Sudah</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="information_market[9][explanation]" value="{{  isset($informasi_market[9])? $informasi_market[9]['explanation'] : '' }}"></td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td>Menggunakan kemitraan untuk memasuki pasar</td>
                            <td>
                                <select class="form-control" name="information_market[10][status]">
                                    <option value="">Pilih status</option>
                                    <option value="belum" @if(isset($informasi_market[10]) && $informasi_market[10]['status'] == 'belum') selected @endif>Belum</option>
                                    <option value="sudah" @if(isset($informasi_market[10]) && $informasi_market[10]['status'] == 'sudah') selected @endif>Sudah</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="information_market[10][explanation]" value="{{  isset($informasi_market[10])? $informasi_market[10]['explanation'] : '' }}"></td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td>Diferensiasi produk</td>
                            <td>
                                <select class="form-control" name="information_market[11][status]">
                                    <option value="">Pilih status</option>
                                    <option value="belum" @if(isset($informasi_market[11]) &&$informasi_market[11]['status'] == 'belum') selected @endif>Belum</option>
                                    <option value="sudah" @if(isset($informasi_market[11]) &&$informasi_market[11]['status'] == 'sudah') selected @endif>Sudah</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="information_market[11][explanation]" value="{{  isset($informasi_market[11])? $informasi_market[11]['explanation'] : '' }}"></td>
                        </tr>
                        <tr>
                            <td>13</td>
                            <td>Menyediakan pelayanan dan solusi</td>
                            <td>
                                <select class="form-control" name="information_market[12][status]">
                                    <option value="">Pilih status</option>
                                    <option value="belum" @if(isset($informasi_market[12]) &&$informasi_market[12]['status'] == 'belum') selected @endif>Belum</option>
                                    <option value="sudah" @if(isset($informasi_market[12]) &&$informasi_market[12]['status'] == 'sudah') selected @endif>Sudah</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="information_market[12][explanation]" value="{{  isset($informasi_market[12])? $informasi_market[12]['explanation'] : '' }}"></td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td>Dilakukan review secara periodik</td>
                            <td>
                                <select class="form-control" name="information_market[13][status]">
                                    <option value="">Pilih status</option>
                                    <option value="belum" @if(isset($informasi_market[13]) &&$informasi_market[13]['status'] == 'belum') selected @endif>Belum</option>
                                    <option value="sudah" @if(isset($informasi_market[13]) &&$informasi_market[13]['status'] == 'sudah') selected @endif>Sudah</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="information_market[13][explanation]" value="{{  isset($informasi_market[13])? $informasi_market[13]['explanation'] : '' }}"></td>
                        </tr>
                        <tr>
                            <td>15</td>
                            <td>Penyempurnaan model bisnis</td>
                            <td>
                                <select class="form-control" name="information_market[14][status]">
                                    <option value="">Pilih status</option>
                                    <option value="belum" @if(isset($informasi_market[14]) &&$informasi_market[14]['status'] == 'belum') selected @endif>Belum</option>
                                    <option value="sudah" @if(isset($informasi_market[14]) &&$informasi_market[14]['status'] == 'sudah') selected @endif>Sudah</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="information_market[14][explanation]" value="{{  isset($informasi_market[14])? $informasi_market[14]['explanation'] : '' }}"></td>
                        </tr>
                        <tr>
                            <td>16</td>
                            <td>Menggunakan kemitraan untuk berkompetisi</td>
                            <td>
                                <select class="form-control" name="information_market[15][status]">
                                    <option value="">Pilih status</option>
                                    <option value="belum" @if(isset($informasi_market[15]) &&$informasi_market[15]['status'] == 'belum') selected @endif>Belum</option>
                                    <option value="sudah" @if(isset($informasi_market[15]) &&$informasi_market[15]['status'] == 'sudah') selected @endif>Sudah</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="information_market[15][explanation]" value="{{  isset($informasi_market[15])? $informasi_market[15]['explanation'] : '' }}"></td>
                        </tr>
                        <tr>
                            <td>17</td>
                            <td>Penurunan pasar telah dikonfirmasi</td>
                            <td>
                                <select class="form-control" name="information_market[16][status]">
                                    <option value="">Pilih status</option>
                                    <option value="belum" @if(isset($informasi_market[16]) &&$informasi_market[16]['status'] == 'belum') selected @endif>Belum</option>
                                    <option value="sudah" @if(isset($informasi_market[16]) &&$informasi_market[16]['status'] == 'sudah') selected @endif>Sudah</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="information_market[16][explanation]" value="{{  isset($informasi_market[16])? $informasi_market[16]['explanation'] : '' }}"></td>
                        </tr>
                        <tr>
                            <td>18</td>
                            <td>Riset pasar untuk persetujuan inovasi ulang (sebagai <i>incremental innovation</i>)
                                atau meninggalkannya menuju pengembangan teknologi yang lebih maju (sebagai
                                <i>breakthrough innovation</i>)
                            </td>
                            <td>
                                <select class="form-control" name="information_market[17][status]">
                                    <option value="">Pilih status</option>
                                    <option value="belum" @if(isset($informasi_market[17]) &&$informasi_market[17]['status'] == 'belum') selected @endif>Belum</option>
                                    <option value="sudah" @if(isset($informasi_market[17]) &&$informasi_market[17]['status'] == 'sudah') selected @endif>Sudah</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="information_market[17][explanation]" value="{{  isset($informasi_market[17])? $informasi_market[17]['explanation'] : '' }}"></td>
                        </tr>
                        <tr>
                            <td>19</td>
                            <td>Review permintaan pasar</td>
                            <td>
                                <select class="form-control" name="information_market[18][status]">
                                    <option value="">Pilih status</option>
                                    <option value="belum" @if(isset($informasi_market[18]) &&$informasi_market[18]['status'] == 'belum') selected @endif>Belum</option>
                                    <option value="sudah" @if(isset($informasi_market[18]) &&$informasi_market[18]['status'] == 'sudah') selected @endif>Sudah</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="information_market[18][explanation]" value="{{  isset($informasi_market[18])? $informasi_market[18]['explanation'] : '' }}"></td>
                        </tr>
                        <tr>
                            <td>20</td>
                            <td>Identifikasi peluang tumbuhnya pasar atau ekspansi pasar baru</td>
                            <td>
                                <select class="form-control" name="information_market[19][status]">
                                    <option value="">Pilih status</option>
                                    <option value="belum" @if(isset($informasi_market[19]) &&$informasi_market[19]['status'] == 'belum') selected @endif>Belum</option>
                                    <option value="sudah" @if(isset($informasi_market[19]) &&$informasi_market[19]['status'] == 'sudah') selected @endif>Sudah</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="information_market[19][explanation]" value="{{ isset($informasi_market[19])? $informasi_market[19]['explanation'] : '' }}"></td>
                        </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-text text-muted mt-2">*) pilih salah satu</div>
                    </div>
                </div>
            </div>
            
            <div class="mb-3 d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ $informasi ? 'Update Form' : 'Submit Form' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script>
    function addTeamRow() {
        const tbody = document.querySelector('.team-table tbody');
        const rowCount = tbody.rows.length;
        const newRow = document.createElement('tr');

        // Membuat cell untuk nomor
        const numberCell = document.createElement('td');
        numberCell.textContent = rowCount + 1;

        // Membuat cell untuk nama<div class="subsection mb-4">

        const nameCell = document.createElement('td');
        const nameInput = document.createElement('input');
        nameInput.type = 'text';
        nameInput.className = 'form-control';
        nameInput.name = `team[${rowCount}][name]`;
        nameCell.appendChild(nameInput);

        // Membuat cell untuk keahlian
        const skillCell = document.createElement('td');
        const skillInput = document.createElement('input');
        skillInput.type = 'text';
        skillInput.className = 'form-control';
        skillInput.name = `team[${rowCount}][skill]`;
        skillCell.appendChild(skillInput);

        // Menambahkan semua cell ke row
        newRow.appendChild(numberCell);
        newRow.appendChild(nameCell);
        newRow.appendChild(skillCell);

        // Menambahkan row ke tbody
        tbody.appendChild(newRow);
    }
</script>
@endsection