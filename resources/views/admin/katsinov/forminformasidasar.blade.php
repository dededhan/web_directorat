<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Informasi Dasar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/inovasi/forminformasidasar.css">
</head>


<body>
    @extends('admin.admin')
    <div class="container">
        <!-- Rest of your existing HTML structure remains the same -->
        <div class="header">
            <h1>
                <span>INFORMASI DASAR</span>
                <span class="italic">(BASIC INFORMATION)</span>
            </h1>
        </div>

        <form action="{{ route('admin.Katsinov.informasi.store', $id) }}" method="POST">
            @csrf
            @dump($informasi)
            <!-- Section 1: Informasi Inovator -->
            <div class="section">
                <h2>1. Informasi Inovator</h2>

                <!-- Subsection a -->
                <div class="subsection">
                    <h3>a&#41; Penangungjawab/ Pusat / Alamat Kontak/ Telp /Faks.
                        <span class="italic">(Person in charge / Center for / Address / Telephone / Facsimile)</span>
                    </h3>
                    <table>
                        <tr>
                            <td width="200">Nama Penanggungjawab</td>
                            <td width="20">:</td>
                            <td><input type="text" class="form-control" name="person_in_charge"></td>
                        </tr>
                        <tr>
                            <td>Institusi</td>
                            <td>:</td>
                            <td><input type="text" class="form-control" name="pic_institution"></td>
                        </tr>
                        <tr>
                            <td>Alamat Kontak</td>
                            <td>:</td>
                            <td><textarea class="form-control" rows="3" name="pic_address"></textarea></td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>:</td>
                            <td><input type="tel" class="form-control" name="pic_phone"></td>
                        </tr>
                        <tr>
                            <td>Fax.</td>
                            <td>:</td>
                            <td><input type="tel" class="form-control" name="pic_fax"></td>
                        </tr>
                    </table>
                </div>

                <!-- Subsection b -->
                <div class="subsection">
                    <h3>b&#41; Anggota Tim <span class="italic">(Team Member)</span></h3>
                    <table class="team-table">
                        <thead>
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
                        {{-- @dump($informasi_team) --}}
                            @foreach ($informasi_team as $team)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><input type="text" class="form-control" value="{{ $team['name'] }}"></td>
                                    <td><input type="text" class="form-control" value="{{ $team['skill'] }}"></td>
                                </tr>
                            @endforeach
                        @endif
                            
                        </tbody>
                        
                    </table>
                    <div style="text-align: right; margin-top: 1rem;">
                        <button type="button" class="submit-btn" onclick="addTeamRow()"
                            style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                            + Tambah Anggota Tim
                        </button>
                    </div>
                    <div class="note">Catatan: row tabel anggota tim bisa ditambahkan bila diperlukan.</div>
                </div>
            </div>

            <!-- Section 2: Informasi Tentang Inovasi -->
            <div class="section">
                <h2>2. Informasi Tentang Inovasi Yang Dilaksanakan</h2>

                <!-- Title -->
                <div class="subsection">
                    <h3 class="underline">a&#41; Judul Inovasi:</h3>
                    <input type="text" class="form-control" name="innovation_title">
                </div>

                <!-- Program Name -->
                <div class="subsection">
                    <h3 class="underline">b&#41; Nama Program:</h3>
                    <input type="text" class="form-control" name="innovation_name">
                </div>

                <!-- Innovation Type -->
                <div class="subsection">
                    <h3>c&#41; Jenis Inovasi:</h3>
                    <p class="italic">(pilih salah satu)</p>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="innovation_type" value="produk"> Produk
                        </label>
                        <label>
                            <input type="radio" name="innovation_type" value="pasar"> Pasar
                        </label>
                        <label>
                            <input type="radio" name="innovation_type" value="proses"> Proses
                        </label>
                        <label>
                            {{-- this needs js to prevent unclick else button filling the input --}}
                            <input type="radio" name="innovation_type" value="lainnya"> Lainnya:
                            {{-- temporarily disabled because it may conflict with the other radio input --}}
                            {{-- <input type="text" style="width: 200px;" name="innovation_type_text"> --}}
                        </label>
                    </div>
                </div>

                <!-- Innovation Field -->
                <div class="subsection">
                    <h3>d&#41; Bidang Inovasi:</h3>
                    <p class="italic">(pilih salah satu)</p>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="innovation_field" value="hankam"> Teknologi Hankam
                        </label>
                        <label>
                            <input type="radio" name="innovation_field" value="ict"> ICT
                        </label>
                        <label>
                            <input type="radio" name="innovation_field" value="transportasi"> Teknologi Transportasi
                        </label>
                        <label>
                            <input type="radio" name="innovation_field" value="pertanian"> Teknologi Pertanian
                        </label>
                    </div>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="innovation_field" value="lingkungan"> Teknologi Lingkungan
                        </label>
                        <label>
                            <input type="radio" name="innovation_field" value="manufaktur"> Teknologi Manufaktur
                        </label>
                        <label>
                            <input type="radio" name="innovation_field" value="material"> Teknologi Material
                        </label>
                        <label>
                            <input type="radio" name="innovation_field" value="lainnya"> Lainnya:
                            {{-- <input type="text" style="width: 200px;" name="innovation_field_text"> --}}
                        </label>
                    </div>
                </div>

                <!-- Application and Benefits -->
                <div class="subsection">
                    <h3>e&#41; Aplikasi dan Manfaat Inovasi:</h3>
                    <textarea class="form-control" rows="4" name="innovation_application"></textarea>
                </div>

                <!-- Program Implementation -->
                <div class="subsection">
                    <h3>f&#41; Pelaksanaan Program/Kegiatan:</h3>
                    <div class="form-group">
                        <div class="input-with-unit">
                            <label>Lama program/ kegiatan yang direncanakan:</label>
                            <input type="text" style="width: 100px;" name="innovation_duration">
                            <span>tahun</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-with-unit">
                            <label>Program/ kegiatan yang berjalan tahun ke-:</label>
                            <input type="text" style="width: 100px;" name="innovation_year">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Sumber pendanaan:</label>
                        <table class="funding-table">
                            <thead>
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
                                {{-- @dump($informasi_program) --}}
                                @foreach ($informasi_program as $program)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><input type="text" class="form-control" value="{{ $program['year'] }}"></td>
                                    <td><input type="text" class="form-control" value="{{ $program['funds'] }}"></td>
                                    <td><input type="text" class="form-control" value="{{ $program['source'] }}"></td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Innovation Partners -->
                <div class="subsection">
                    <h3>g&#41; Mitra Dalam Inovasi:</h3>
                    <table class="partner-table">
                        <thead>
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
                                    <td><input type="text" class="form-control" value="{{ $partner['name'] }}"></td>
                                    <td><input type="text" class="form-control" value="{{ $partner['address'] }}"></td>
                                    <td><input type="text" class="form-control" value="{{ $partner['role'] }}"></td>
                                    <td><input type="text" class="form-control" value="{{ $partner['cooperation'] }}"></td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Innovation Summary -->
                <div class="subsection">
                    <h3>h&#41; Ringkasan Inovasi Yang Dilaksanakan Dengan Pencapaian Yang Diharapkan:</h3>
                    <textarea class="form-control" rows="4" name="innovation_summary"></textarea>
                </div>

                <!-- Innovation Novelty -->
                <div class="subsection">
                    <h3>i&#41; Kebaruan dan Keunggulan Inovasi:</h3>
                    <div class="form-group">
                        <label>Kebaruan yang ditawarkan dari inovasi yang dilakukan:</label>
                        <textarea class="form-control" rows="3" name="innovation_novelty"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Keunggulan yang membedakan dengan produk/jasa sejenis yang ada di pasar saat ini:</label>
                        <textarea class="form-control" rows="3" name="innovation_supremacy"></textarea>
                    </div>
                </div>
            </div>

            <!-- Section 3: Progress Information -->
            <div class="section">
                <h2>3. Informasi Tentang Kemajuan Inovasi Yang Dilaksanakan</h2>

                <!-- Technology Development -->
                <div class="subsection">
                    <h3 class="underline">A&#41; Pengembangan Teknologi</h3>
                    <table class="progress-table">
                        <thead>
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
                                <td>Pengembangan prinsip dasar / Ide teknologi (misal: berupa tulisan, makalah
                                    menyangkut sifat dasar suatu teknologi)</td>
                                <td>
                                    <select class="form-control" name="information_tech[0][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if (isset($informasi_tech[0]) && $informasi_tech[0]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if (isset($informasi_tech[0]) && $informasi_tech[0]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_tech[0][explanation]" value="{{ $informasi_tech[0]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Formulasi Konsep dan/ atau aplikasi teknologi</td>
                                <td>
                                    <select class="form-control" name="information_tech[1][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if ($informasi_tech[1]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if ($informasi_tech[1]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_tech[1][explanation]" value="{{ $informasi_tech[1]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Pembuatan prototipe</td>
                                <td>
                                    <select class="form-control" name="information_tech[2][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if ($informasi_tech[2]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if ($informasi_tech[2]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_tech[2][explanation]" value="{{ $informasi_tech[2]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Hasil uji Prototipe dapat berfungsi baik</td>
                                <td>
                                    <select class="form-control" name="information_tech[3][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if ($informasi_tech[3]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if ($informasi_tech[3]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_tech[3][explanation]" value="{{ $informasi_tech[3]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Percobaan fungsi utama prototipe dalam lingkungan yang relevan (simulasi)</td>
                                <td>
                                    <select class="form-control" name="information_tech[4][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if ($informasi_tech[4]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if ($informasi_tech[4]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_tech[4][explanation]" value="{{ $informasi_tech[4]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Validasi prototipe pada lingkungan yang relevan (simulasi)</td>
                                <td>
                                    <select class="form-control" name="information_tech[5][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if ($informasi_tech[5]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if ($informasi_tech[5]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_tech[5][explanation]" value="{{ $informasi_tech[5]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Validasi prototipe pada lingkungan yang sebenarnya</td>
                                <td>
                                    <select class="form-control" name="information_tech[6][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if ($informasi_tech[6]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if ($informasi_tech[6]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_tech[6][explanation]" value="{{ $informasi_tech[6]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Ujicoba/ demonstrasi prototipe pada lingkungan yg relevan</td>
                                <td>
                                    <select class="form-control" name="information_tech[7][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if ($informasi_tech[7]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if ($informasi_tech[7]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_tech[7][explanation]" value="{{ $informasi_tech[7]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>Ujicoba/ demonstrasi prototipe pada lingkungan yg sebenarnya</td>
                                <td>
                                    <select class="form-control" name="information_tech[8][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if ($informasi_tech[8]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if ($informasi_tech[8]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_tech[8][explanation]" value="{{ $informasi_tech[8]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Telah dimanfaatkan sesuai fungsi yang dirancang / telah teruji / proven</td>
                                <td>
                                    <select class="form-control" name="information_tech[9][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if ($informasi_tech[9]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if ($informasi_tech[9]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_tech[9][explanation]" value="{{ $informasi_tech[9]['explanation'] }}"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="note">*&#41; pilih salah satu</div>
                </div>
                <!-- Market Evolution -->
                <div class="subsection">
                    <h3 class="underline">B&#41; Evolusi Pasar</h3>
                    <table class="progress-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Uraian</th>
                                <th>Belum/Sudah Tercapai*&#41;</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Kebutuhan dan permintaan pelanggan teramati</td>
                                <td>
                                    <select class="form-control" name="information_market[0][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if($informasi_market[0]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if($informasi_market[0]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_market[0][explanation]" value="{{ $informasi_market[0]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Pelanggan akhir teridentifikasi</td>
                                <td>
                                    <select class="form-control" name="information_market[1][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if($informasi_market[1]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if($informasi_market[1]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_market[1][explanation]" value="{{ $informasi_market[1]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Telah dikeluarkan rencana luncuran pasar secara rinci</td>
                                <td>
                                    <select class="form-control" name="information_market[2][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if($informasi_market[2]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if($informasi_market[2]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_market[2][explanation]" value="{{ $informasi_market[2]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Kebutuhan khusus dan keperluan pelanggan telah diketahui</td>
                                <td>
                                    <select class="form-control" name="information_market[3][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if($informasi_market[3]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if($informasi_market[3]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_market[3][explanation]" value="{{ $informasi_market[3]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Segmen, ukuran dan pangsa pasar telah diprediksi</td>
                                <td>
                                    <select class="form-control" name="information_market[4][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if($informasi_market[4]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if($informasi_market[4]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_market[4][explanation]" value="{{ $informasi_market[4]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Telah dikeluarkan harga dan luncuran produk</td>
                                <td>
                                    <select class="form-control" name="information_market[5][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if($informasi_market[5]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if($informasi_market[5]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_market[5][explanation]" value="{{ $informasi_market[5]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Posisioning pasar</td>
                                <td>
                                    <select class="form-control" name="information_market[6][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if($informasi_market[6]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if($informasi_market[6]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_market[6][explanation]" value="{{ $informasi_market[6]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Model bisnis ditetapkan</td>
                                <td>
                                    <select class="form-control" name="information_market[7][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if($informasi_market[7]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if($informasi_market[7]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_market[7][explanation]" value="{{ $informasi_market[7]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>Pemasaran ditekankan pada pengenalan dengan baik para pelanggannya</td>
                                <td>
                                    <select class="form-control" name="information_market[8][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if($informasi_market[8]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if($informasi_market[8]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_market[8][explanation]" value="{{ $informasi_market[8]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Pesaing diidentifikasi dengan baik</td>
                                <td>
                                    <select class="form-control" name="information_market[9][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if($informasi_market[9]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if($informasi_market[9]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_market[9][explanation]" value="{{ $informasi_market[9]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>Menggunakan kemitraan untuk memasuki pasar</td>
                                <td>
                                    <select class="form-control" name="information_market[10][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if($informasi_market[10]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if($informasi_market[10]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_market[10][explanation]" value="{{ $informasi_market[10]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td>Diferensiasi produk</td>
                                <td>
                                    <select class="form-control" name="information_market[11][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if($informasi_market[11]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if($informasi_market[11]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_market[11][explanation]" value="{{ $informasi_market[11]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td>Menyediakan pelayanan dan solusi</td>
                                <td>
                                    <select class="form-control" name="information_market[12][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if($informasi_market[12]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if($informasi_market[12]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_market[12][explanation]" value="{{ $informasi_market[12]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td>Dilakukan review secara periodik</td>
                                <td>
                                    <select class="form-control" name="information_market[13][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if($informasi_market[13]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if($informasi_market[13]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_market[13][explanation]" value="{{ $informasi_market[13]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>15</td>
                                <td>Penyempurnaan model bisnis</td>
                                <td>
                                    <select class="form-control" name="information_market[14][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if($informasi_market[14]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if($informasi_market[14]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_market[14][explanation]" value="{{ $informasi_market[14]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>16</td>
                                <td>Menggunakan kemitraan untuk berkompetisi</td>
                                <td>
                                    <select class="form-control" name="information_market[15][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if($informasi_market[15]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if($informasi_market[15]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_market[15][explanation]" value="{{ $informasi_market[15]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>17</td>
                                <td>Penurunan pasar telah dikonfirmasi</td>
                                <td>
                                    <select class="form-control" name="information_market[16][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if($informasi_market[16]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if($informasi_market[16]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_market[16][explanation]" value="{{ $informasi_market[16]['explanation'] }}"></td>
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
                                        <option value="belum" @if($informasi_market[17]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if($informasi_market[17]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_market[17][explanation]" value="{{ $informasi_market[17]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>19</td>
                                <td>Review permintaan pasar</td>
                                <td>
                                    <select class="form-control" name="information_market[18][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if($informasi_market[18]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if($informasi_market[18]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_market[18][explanation]" value="{{ $informasi_market[18]['explanation'] }}"></td>
                            </tr>
                            <tr>
                                <td>20</td>
                                <td>Identifikasi peluang tumbuhnya pasar atau ekspansi pasar baru</td>
                                <td>
                                    <select class="form-control" name="information_market[19][status]">
                                        <option value="">Pilih status</option>
                                        <option value="belum" @if($informasi_market[19]['status'] == 'belum') selected @endif>Belum</option>
                                        <option value="sudah" @if($informasi_market[19]['status'] == 'sudah') selected @endif>Sudah</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="information_market[19][explanation]" value="{{ $informasi_market[19]['explanation'] }}"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="note">*&#41; pilih salah satu</div>
                </div>
            </div>
            <div class="submit-container">
                <button type="submit" class="submit-btn">
                    Submit Form
                </button>
            </div>
            <script>
                function addTeamRow() {
                    const tbody = document.querySelector('.team-table tbody');
                    const rowCount = tbody.rows.length;
                    const newRow = document.createElement('tr');

                    // Membuat cell untuk nomor
                    const numberCell = document.createElement('td');
                    numberCell.textContent = rowCount + 1;

                    // Membuat cell untuk nama
                    const nameCell = document.createElement('td');
                    const nameInput = document.createElement('input');
                    nameInput.type = 'text';
                    nameInput.className = 'form-control';
                    nameInput.name = `team[${numberCell.textContent}][name]`;
                    nameCell.appendChild(nameInput);

                    // Membuat cell untuk keahlian
                    const skillCell = document.createElement('td');
                    const skillInput = document.createElement('input');
                    skillInput.type = 'text';
                    skillInput.className = 'form-control';
                    skillInput.name = `team[${numberCell.textContent}][skill]`;
                    skillCell.appendChild(skillInput);

                    // Menambahkan semua cell ke row
                    newRow.appendChild(numberCell);
                    newRow.appendChild(nameCell);
                    newRow.appendChild(skillCell);

                    // Menambahkan row ke tbody
                    tbody.appendChild(newRow);
                }
            </script>