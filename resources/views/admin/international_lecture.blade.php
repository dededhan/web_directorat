@extends('admin.admin')

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Dosen Internasional</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Input Dosen Internasional</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Data Dosen Internasional</h3>
            </div> 

            <form id="lecture-form">
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
                        <div class="form-text text-muted">Pilih fakultas tempat dosen mengajar</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select" id="prodi" disabled>
                            <option value="">Pilih Program Studi</option>
                        </select>
                        <div class="form-text text-muted">Pilih program studi tempat dosen mengajar</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="nama" class="form-label">Nama Dosen</label>
                        <input type="text" class="form-control" id="nama" required>
                        <div class="form-text text-muted">Masukkan nama lengkap dosen</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="negara" class="form-label">Negara Asal</label>
                        <input type="text" class="form-control" id="negara" required>
                        <div class="form-text text-muted">Masukkan negara asal dosen</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="universitas_asal" class="form-label">Universitas Asal</label>
                        <input type="text" class="form-control" id="universitas_asal" required>
                        <div class="form-text text-muted">Masukkan universitas asal dosen</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" required>
                            <option value="">Pilih Status</option>
                            <option value="fulltime">Full Time</option>
                            <option value="parttime">Part Time</option>
                        </select>
                        <div class="form-text text-muted">Pilih status kepegawaian dosen</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="bidang_keahlian" class="form-label">Bidang Keahlian</label>
                        <input type="text" class="form-control" id="bidang_keahlian" required>
                        <div class="form-text text-muted">Masukkan bidang keahlian dosen</div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" onclick="addDummyData()">Simpan</button>
                </div>
            </form>
        </div>

        <div class="table-data mt-4">
            <div class="order">
                <div class="head">
                    <h3>Daftar Dosen Internasional</h3>
                    <div class="d-flex justify-content-end">
                        <div class="search-box">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="lecture-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Fakultas</th>
                                <th>Program Studi</th>
                                <th>Negara Asal</th>
                                <th>Universitas Asal</th>
                                <th>Status</th>
                                <th>Bidang Keahlian</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="lecture-list">
                            <!-- Data akan ditampilkan di sini -->
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
            const tbody = document.getElementById('lecture-list');
            const row = document.createElement('tr');
            
            const lectureData = {
                nama: document.getElementById('nama').value || 'John Smith',
                fakultas: document.getElementById('fakultas').value || 'fmipa',
                prodi: document.getElementById('prodi').value || 'ilmu_komputer',
                negara: document.getElementById('negara').value || 'Amerika Serikat',
                universitasAsal: document.getElementById('universitas_asal').value || 'MIT',
                status: document.getElementById('status').value || 'fulltime',
                bidangKeahlian: document.getElementById('bidang_keahlian').value || 'Ilmu Komputer'
            };

            row.innerHTML = `
                <td>${lectureData.nama}</td>
                <td>${lectureData.fakultas.toUpperCase()}</td>
                <td>${lectureData.prodi.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}</td>
                <td>${lectureData.negara}</td>
                <td>${lectureData.universitasAsal}</td>
                <td><span class="badge bg-${lectureData.status === 'fulltime' ? 'success' : 'primary'}">${lectureData.status.toUpperCase()}</span></td>
                <td>${lectureData.bidangKeahlian}</td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-warning">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteRow(this)">Hapus</button>
                    </div>
                </td>
            `;

            tbody.appendChild(row);
            document.getElementById('lecture-form').reset();
        }

        // Delete row function
        function deleteRow(button) {
            button.closest('tr').remove();
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.getElementById('lecture-list').getElementsByTagName('tr');

            Array.from(rows).forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchText) ? '' : 'none';
            });
        });
    </script>
@endsection