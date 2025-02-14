@extends('admin.admin')

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Data Akreditasi</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Input Data Akreditasi</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Data Akreditasi</h3>
            </div> 

            <form id="akreditasi-form">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fakultas" class="form-label">Fakultas</label>
                        <select class="form-select" id="fakultas">
                            <option value="">Pilih Fakultas</option>
                            <option value="fmipa">FMIPA</option>
                            <option value="fik">FIK</option>
                            <option value="ft">FT</option>
                            <option value="fbs">FBS</option>
                            <option value="fip">FIP</option>
                            <option value="fe">FE</option>
                            <option value="fis">FIS</option>
                        </select>
                        <div class="form-text text-muted">Pilih fakultas yang akan diinput data akreditasinya</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select" id="prodi" disabled>
                            <option value="">Pilih Program Studi</option>
                        </select>
                        <div class="form-text text-muted">Pilih program studi yang akan diinput data akreditasinya</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="lembaga_akreditasi" class="form-label">Lembaga Akreditasi</label>
                        <select class="form-select" id="lembaga_akreditasi">
                            <option value="">Pilih Lembaga Akreditasi</option>
                            <option value="ban-pt">BAN-PT</option>
                            <option value="lam-infokom">LAM INFOKOM</option>
                            <option value="lam-teknik">LAM TEKNIK</option>
                            <option value="lam-ekonomi">LAM EKONOMI</option>
                            <option value="lam-pendidikan">LAM PENDIDIKAN</option>
                        </select>
                        <div class="form-text text-muted">Pilih lembaga yang mengeluarkan akreditasi</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="peringkat" class="form-label">Peringkat Akreditasi</label>
                        <select class="form-select" id="peringkat">
                            <option value="">Pilih Peringkat</option>
                            <option value="unggul">Unggul</option>
                            <option value="baik_sekali">Baik Sekali</option>
                            <option value="baik">Baik</option>
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                        </select>
                        <div class="form-text text-muted">Pilih peringkat akreditasi yang diperoleh</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="nomor_sk" class="form-label">Nomor SK</label>
                        <input type="text" class="form-control" id="nomor_sk">
                        <div class="form-text text-muted">Masukkan nomor SK akreditasi (contoh: 1234/SK/BAN-PT/2024)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="periode_awal" class="form-label">Periode Awal Berlaku</label>
                        <input type="date" class="form-control" id="periode_awal">
                        <div class="form-text text-muted">Pilih tanggal mulai berlakunya akreditasi</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="periode_akhir" class="form-label">Periode Akhir Berlaku</label>
                        <input type="date" class="form-control" id="periode_akhir">
                        <div class="form-text text-muted">Pilih tanggal berakhirnya akreditasi</div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" onclick="addDummyData()">Submit</button>
                </div>
            </form>
        </div>

        <div class="table-data mt-4">
            <div class="order">
                <div class="head">
                    <h3>Daftar Data Akreditasi</h3>
                    <div class="d-flex justify-content-end">
                        <div class="search-box">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="akreditasi-table">
                        <thead>
                            <tr>
                                <th>Fakultas</th>
                                <th>Program Studi</th>
                                <th>Lembaga Akreditasi</th>
                                <th>Peringkat</th>
                                <th>Nomor SK</th>
                                <th>Periode Berlaku</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="akreditasi-list">
                            <!-- Dummy data will be inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table-data {
            margin-top: 24px;
        }
        
        .order {
            background: #fff;
            padding: 24px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus, .form-select:focus {
            border-color: #3498db;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        .badge {
            font-size: 0.7em;
        }
    </style>

    <script>
        const prodisByFaculty = {
            'fmipa': ['Ilmu Komputer', 'Matematika', 'Pendidikan Matematika', 'Fisika', 'Pendidikan Fisika', 'Biologi', 'Pendidikan Biologi', 'Kimia', 'Pendidikan Kimia'],
            'fik': ['Pendidikan Teknologi Informasi', 'Pendidikan Teknik Elektronika', 'Pendidikan Teknik Elektro', 'Teknik Informatika dan Komputer'],
            'ft': ['Teknik Sipil', 'Teknik Mesin', 'Teknik Elektro', 'Pendidikan Teknik Bangunan', 'Pendidikan Teknik Mesin'],
            'fbs': ['Pendidikan Bahasa Indonesia', 'Pendidikan Bahasa Inggris', 'Pendidikan Bahasa Jerman', 'Pendidikan Bahasa Prancis', 'Pendidian Seni Rupa'],
            'fip': ['Pendidikan Guru Sekolah Dasar', 'Pendidikan Anak Usia Dini', 'Bimbingan dan Konseling', 'Teknologi Pendidikan', 'Pendidikan Luar Biasa'],
            'fe': ['Pendidikan Ekonomi', 'Manajemen', 'Akuntansi', 'Pendidikan Administrasi Perkantoran'],
            'fis': ['Pendidikan Pancasila dan Kewarganegaraan', 'Pendidikan Sejarah', 'Pendidikan Geografi', 'Pendidikan Sosiologi', 'Ilmu Komunikasi']
        };

        // Faculty change handler
        document.getElementById('fakultas').addEventListener('change', function() {
            const prodiSelect = document.getElementById('prodi');
            prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
            
            if (this.value) {
                prodiSelect.disabled = false;
                const prodis = prodisByFaculty[this.value];
                prodis.forEach(prodi => {
                    const option = document.createElement('option');
                    option.value = prodi.toLowerCase().replace(/ /g, '_');
                    option.textContent = prodi;
                    prodiSelect.appendChild(option);
                });
            } else {
                prodiSelect.disabled = true;
            }
        });

        // Add dummy data function
        function addDummyData() {
            const tbody = document.getElementById('akreditasi-list');
            const row = document.createElement('tr');
            
            const akreditasiData = {
                fakultas: document.getElementById('fakultas').value || 'fmipa',
                prodi: document.getElementById('prodi').value || 'ilmu_komputer',
                lembaga: document.getElementById('lembaga_akreditasi').value || 'ban-pt',
                peringkat: document.getElementById('peringkat').value || 'unggul',
                nomorSK: document.getElementById('nomor_sk').value || '1234/SK/BAN-PT/2024',
                periodeAwal: document.getElementById('periode_awal').value || '2024-01-01',
                periodeAkhir: document.getElementById('periode_akhir').value || '2029-01-01'
            };

            row.innerHTML = `
                <td>${akreditasiData.fakultas.toUpperCase()}</td>
                <td>${akreditasiData.prodi.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}</td>
                <td>${akreditasiData.lembaga.toUpperCase()}</td>
                <td><span class="badge bg-success">${akreditasiData.peringkat.replace(/_/g, ' ').toUpperCase()}</span></td>
                <td>${akreditasiData.nomorSK}</td>
                <td>${formatDate(akreditasiData.periodeAwal)} - ${formatDate(akreditasiData.periodeAkhir)}</td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-warning">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteRow(this)">Delete</button>
                    </div>
                </td>
            `;

            tbody.appendChild(row);
            document.getElementById('akreditasi-form').reset();
        }

        // Format date helper function
        function formatDate(dateString) {
            if (!dateString) return '';
            return new Date(dateString).toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
        }

        // Delete row function
        function deleteRow(button) {
            button.closest('tr').remove();
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.getElementById('akreditasi-list').getElementsByTagName('tr');

            Array.from(rows).forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchText) ? '' : 'none';
            });
        });
    </script>
@endsection