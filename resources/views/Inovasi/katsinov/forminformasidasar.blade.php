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
    <div class="container">
        <!-- Rest of your existing HTML structure remains the same -->
        <div class="header">
            <h1>
                <span>INFORMASI DASAR</span>
                <span class="italic">(BASIC INFORMATION)</span>
            </h1>
        </div>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif    
        <form method="POST" action="{{ route('admin.Katsinov.forminformasidasar.store') }}" >
            @csrf

            <!-- Section 1: Informasi Inovator -->
            <div class="section">
                <h2>1. Informasi Inovator</h2>

                <!-- Subsection a -->
                <div class="subsection">
                    <h3>a) Penangungjawab/ Pusat / Alamat Kontak/ Telp /Faks.
                        <span class="italic">(Person in charge / Center for / Address / Telephone / Facsimile)</span>
                    </h3>
                    <table>
                        <tr>
                            <td width="200">Nama Penanggungjawab</td>
                            <td width="20">:</td>
                            <td><input type="text" name="nama_penanggungjawab" class="form-control">
                        </tr>
                        <tr>
                            <td>Institusi</td>
                            <td>:</td>
                            <td><input type="text" name="institusi" class="form-control">
                        </tr>
                        <tr>
                            <td>Alamat Kontak</td>
                            <td>:</td>
                            <td>
                                <textarea name="alamat_kontak" class="form-control" rows="3"></textarea>
                        <tr>
                            <td>Phone</td>
                            <td>:</td>
                            <td><input type="tel" name="phone" class="form-control">
                        </tr>
                        <tr>
                            <td>Fax.</td>
                            <td>:</td>
                            <td><input type="tel" name="fax" class="form-control">
                        </tr>
                    </table>
                </div>

                <!-- Subsection b -->
                <div class="subsection">
                    <h3>b) Anggota Tim <span class="italic">(Team Member)</span></h3>
                    <table class="team-table">
                        <thead>
                            <tr>
                                <th width="50">No.</th>
                                <th>Nama</th>
                                <th>Keahlian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teamMembers as $index => $member)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <input type="text" name="team_members[{{ $index }}][nama]"
                                            class="form-control"
                                            value="{{ old('team_members.' . $index . '.nama', $member->nama ?? '') }}">
                                    </td>
                                    <td>
                                        <input type="text" name="team_members[{{ $index }}][keahlian]"
                                            class="form-control"
                                            value="{{ old('team_members.' . $index . '.keahlian', $member->keahlian ?? '') }}">
                                    </td>
                                </tr>
                            @endforeach
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
                    <h3 class="underline">a) Judul Inovasi:</h3>
                    <input type="text" name="judul_inovasi" class="form-control">
                </div>

                <!-- Program Name -->
                <div class="subsection">
                    <h3 class="underline">b) Nama Program:</h3>
                    <input type="text" name="nama_program" class="form-control">
                </div>

                <!-- Innovation Type -->
                <div class="subsection">
                    <h3>c) Jenis Inovasi:</h3>
                    <p class="italic">(pilih salah satu)</p>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="jenis_inovasi" value="produk"> Produk
                        </label>
                        <label>
                            <input type="radio" name="jenis_inovasi" value="pasar"> Pasar
                        </label>
                        <label>
                            <input type="radio" name="jenis_inovasi" value="proses"> Proses
                        </label>
                        <label>
                            <input type="radio" name="jenis_inovasi" value="lainnya"> Lainnya:
                            <input type="text" name="jenis_lainnya" style="width: 200px;">
                        </label>
                    </div>
                </div>

                <!-- Innovation Field -->
                <div class="subsection">
                    <h3>d) Bidang Inovasi:</h3>
                    <p class="italic">(pilih salah satu)</p>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="bidang_inovasi" value="hankam"> Teknologi Hankam
                        </label>
                        <label>
                            <input type="radio" name="bidang_inovasi" value="ict"> ICT
                        </label>
                        <label>
                            <input type="radio" name="bidang_inovasi" value="transportasi"> Teknologi Transportasi
                        </label>
                        <label>
                            <input type="radio" name="bidang_inovasi" value="pertanian"> Teknologi Pertanian
                        </label>
                    </div>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="bidang_inovasi" value="lingkungan"> Teknologi Lingkungan
                        </label>
                        <label>
                            <input type="radio" name="bidang_inovasi" value="manufaktur"> Teknologi Manufaktur
                        </label>
                        <label>
                            <input type="radio" name="bidang_inovasi" value="material"> Teknologi Material
                        </label>
                        <label>
                            <input type="radio" name="bidang_inovasi" value="lainnya"> Lainnya:
                            <input type="text" name="bidang_lainnya" style="width: 200px;">
                        </label>
                    </div>
                </div>

                <!-- Application and Benefits -->
                <div class="subsection">
                    <h3>e) Aplikasi dan Manfaat Inovasi:</h3>
                    <textarea name="aplikasi_manfaat" class="form-control" rows="4"></textarea>
                </div>

                <!-- Program Implementation -->
                <div class="subsection">
                    <h3>f) Pelaksanaan Program/Kegiatan:</h3>
                    <div class="form-group">
                        <div class="input-with-unit">
                            <label>Lama program/ kegiatan yang direncanakan:</label>
                            <input type="text" name="lama_program" style="width: 100px;">
                            <span>tahun</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-with-unit">
                            <label>Program/ kegiatan yang berjalan tahun ke-:</label>
                            <input type="text" name="tahun_berjalan" style="width: 100px;">
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
                                <tr>
                                    <td>1</td>
                                    <td><input type="text" name="funding_sources[0][tahun_ke]"
                                            class="form-control"></td>
                                    <td><input type="text" name="funding_sources[0][total_dana]"
                                            class="form-control"></td>
                                    <td><input type="text" name="funding_sources[0][sumber_dana]"
                                            class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><input type="text" name="funding_sources[1][tahun_ke]"
                                            class="form-control"></td>
                                    <td><input type="text" name="funding_sources[1][total_dana]"
                                            class="form-control"></td>
                                    <td><input type="text" name="funding_sources[1][sumber_dana]"
                                            class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td><input type="text" name="funding_sources[2][tahun_ke]"
                                            class="form-control"></td>
                                    <td><input type="text" name="funding_sources[2][total_dana]"
                                            class="form-control"></td>
                                    <td><input type="text" name="funding_sources[2][sumber_dana]"
                                            class="form-control"></td>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Innovation Partners -->
                <div class="subsection">
                    <h3>g) Mitra Dalam Inovasi:</h3>
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
                            <tr>
                                <td>1</td>
                                <td><input type="text" name="partners[0][nama_mitra]" class="form-control"></td>
                                <td><input type="text" name="partners[0][alamat_mitra]" class="form-control"></td>
                                <td><input type="text" name="partners[0][peran_mitra]" class="form-control"></td>
                                <td><input type="text" name="partners[0][status_kerjasama]" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><input type="text" name="partners[1][nama_mitra]" class="form-control"></td>
                                <td><input type="text" name="partners[1][alamat_mitra]" class="form-control"></td>
                                <td><input type="text" name="partners[1][peran_mitra]" class="form-control"></td>
                                <td><input type="text" name="partners[1][status_kerjasama]" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><input type="text" name="partners[2][nama_mitra]" class="form-control"></td>
                                <td><input type="text" name="partners[2][alamat_mitra]" class="form-control"></td>
                                <td><input type="text" name="partners[2][peran_mitra]" class="form-control"></td>
                                <td><input type="text" name="partners[2][status_kerjasama]" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><input type="text" name="partners[3][nama_mitra]" class="form-control"></td>
                                <td><input type="text" name="partners[3][alamat_mitra]" class="form-control"></td>
                                <td><input type="text" name="partners[3][peran_mitra]" class="form-control"></td>
                                <td><input type="text" name="partners[3][status_kerjasama]" class="form-control">
                                </td>
                        </tbody>
                    </table>
                </div>

                <!-- Innovation Summary -->
                <div class="subsection">
                    <h3>h) Ringkasan Inovasi Yang Dilaksanakan Dengan Pencapaian Yang Diharapkan:</h3>
                    <textarea name="ringkasan_inovasi" class="form-control" rows="4"></textarea>
                </div>

                <!-- Innovation Novelty -->
                <div class="subsection">
                    <h3>i) Kebaruan dan Keunggulan Inovasi:</h3>
                    <div class="form-group">
                        <label>Kebaruan yang ditawarkan dari inovasi yang dilakukan:</label>
                        <textarea name="kebaruan" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Keunggulan yang membedakan dengan produk/jasa sejenis yang ada di pasar saat ini:</label>
                        <textarea name="keunggulan" class="form-control" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <!-- Section 3: Progress Information -->
            <div class="section">
                <h2>3. Informasi Tentang Kemajuan Inovasi Yang Dilaksanakan</h2>

                <!-- Technology Development -->
                <div class="subsection">
                    <h3 class="underline">A) Pengembangan Teknologi</h3>
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
                            @foreach (['Pengembangan prinsip dasar / Ide teknologi (misal: berupa tulisan, makalah menyangkut sifat dasar suatu teknologi)', 'Formulasi Konsep dan/ atau aplikasi teknologi', 'Pembuatan prototipe', 'Hasil uji Prototipe dapat berfungsi baik', 'Percobaan fungsi utama prototipe dalam lingkungan yang relevan (simulasi)', 'Validasi prototipe pada lingkungan yang relevan (simulasi)', 'Validasi prototipe pada lingkungan yang sebenarnya', 'Ujicoba/ demonstrasi prototipe pada lingkungan yg relevan', 'Ujicoba/ demonstrasi prototipe pada lingkungan yg sebenarnya', 'Telah dimanfaatkan sesuai fungsi yang dirancang / telah teruji / proven'] as $index => $uraian)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        {{ $uraian }}
                                        <input type="hidden" name="technology_progress[{{ $index }}][uraian]"
                                            value="{{ $uraian }}">
                                    </td>
                                    <td>
                                        <select name="technology_progress[{{ $index }}][status]"
                                            class="form-control" required>
                                            <option value="">Pilih status</option>
                                            <option value="belum">Belum</option>
                                            <option value="sudah">Sudah</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text"
                                            name="technology_progress[{{ $index }}][keterangan]"
                                            class="form-control">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="note">*) pilih salah satu</div>
                </div>
                <!-- Market Evolution -->
                <div class="subsection">
                    <h3 class="underline">B) Evolusi Pasar</h3>
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
                            @foreach (['Kebutuhan dan permintaan pelanggan teramati', 'Pelanggan akhir teridentifikasi', 'Telah dikeluarkan rencana luncuran pasar secara rinci', 'Kebutuhan khusus dan keperluan pelanggan telah diketahui', 'Segmen, ukuran dan pangsa pasar telah diprediksi', 'Telah dikeluarkan harga dan luncuran produk', 'Posisioning pasar', 'Model bisnis ditetapkan', 'Pemasaran ditekankan pada pengenalan dengan baik para pelanggannya', 'Pesaing diidentifikasi dengan baik', 'Menggunakan kemitraan untuk memasuki pasar', 'Diferensiasi produk', 'Menyediakan pelayanan dan solusi', 'Dilakukan review secara periodik', 'Penyempurnaan model bisnis', 'Menggunakan kemitraan untuk berkompetisi', 'Penurunan pasar telah dikonfirmasi', 'Riset pasar untuk persetujuan inovasi ulang (sebagai incremental innovation) atau meninggalkannya menuju pengembangan teknologi yang lebih maju (sebagai breakthrough innovation)', 'Review permintaan pasar', 'Identifikasi peluang tumbuhnya pasar atau ekspansi pasar baru'] as $index => $uraian)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        {{ $uraian }}
                                        <input type="hidden" name="market_progress[{{ $index }}][uraian]"
                                            value="{{ $uraian }}">
                                    </td>
                                    <td>
                                        <select name="market_progress[{{ $index }}][status]"
                                            class="form-control" required>
                                            <option value="">Pilih status</option>
                                            <option value="belum">Belum</option>
                                            <option value="sudah">Sudah</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="market_progress[{{ $index }}][keterangan]"
                                            class="form-control">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="note">*) pilih salah satu</div>
                </div>
                <div class="submit-container">
                    <button type="submit" class="submit-btn">
                        Submit Form
                    </button>
                </div>
        </form>
    </div>

    <script>
        function addTeamRow() {
            const tbody = document.querySelector('.team-table tbody');
            const rowCount = tbody.rows.length;

            const newRow = document.createElement('tr');

            // Nomor
            const numberCell = document.createElement('td');
            numberCell.textContent = rowCount + 1;

            // Nama
            const nameCell = document.createElement('td');
            const nameInput = document.createElement('input');
            nameInput.type = 'text';
            nameInput.className = 'form-control';
            nameInput.name = `team_members[${rowCount}][nama]`; // Perubahan disini

            // Keahlian
            const skillCell = document.createElement('td');
            const skillInput = document.createElement('input');
            skillInput.type = 'text';
            skillInput.className = 'form-control';
            skillInput.name = `team_members[${rowCount}][keahlian]`; // Perubahan disini

            // Append elements
            nameCell.appendChild(nameInput);
            skillCell.appendChild(skillInput);
            newRow.appendChild(numberCell);
            newRow.appendChild(nameCell);
            newRow.appendChild(skillCell);

            tbody.appendChild(newRow);
        }
    </script>
</body>

</html>
