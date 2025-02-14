@extends('admin.admin')

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>International Students</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">International Students</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input International Student Data</h3>
            </div>

            <form id="international-student-form">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="nama_mahasiswa" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="nama_mahasiswa" required>
                        <div class="form-text text-muted">Enter the full name of the international student</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nim" class="form-label">Student ID (NIM)</label>
                        <input type="text" class="form-control" id="nim" required>
                        <div class="form-text text-muted">Enter the student's identification number</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="negara" class="form-label">Country</label>
                        <input type="text" class="form-control" id="negara" required>
                        <div class="form-text text-muted">Enter the student's country of origin</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Category</label>
                        <select class="form-select" id="kategori" required>
                            <option value="">Select Category</option>
                            <option value="inbound">Inbound</option>
                            <option value="outbound">Outbound</option>
                        </select>
                        <div class="form-text text-muted">Select whether the student is inbound or outbound</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" required>
                            <option value="">Select Status</option>
                            <option value="fulltime">Full Time</option>
                            <option value="parttime">Part Time</option>
                            <option value="other">Other</option>
                        </select>
                        <div class="form-text text-muted">Select the student's study status</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fakultas" class="form-label">Faculty</label>
                        <input type="text" class="form-control" id="fakultas" required>
                        <div class="form-text text-muted">Enter the faculty name</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="program_studi" class="form-label">Department</label>
                        <input type="text" class="form-control" id="program_studi" required>
                        <div class="form-text text-muted">Enter the department name</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="periode_mulai" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="periode_mulai" required>
                        <div class="form-text text-muted">Select the start date of the study period</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="periode_akhir" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="periode_akhir" required>
                        <div class="form-text text-muted">Select the end date of the study period</div>
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
                    <h3>International Students List</h3>
                    <div class="d-flex justify-content-end">
                        <div class="search-box">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped" id="students-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Student ID</th>
                                <th>Country</th>
                                <th>Category</th>
                                <th>Department</th>
                                <th>Faculty</th>
                                <th>Status</th>
                                <th>Period</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="students-list">
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

        .form-control:focus,
        .form-select:focus {
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

        .badge {
            font-size: 0.7em;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        .table th {
            white-space: nowrap;
        }
    </style>

    <script>
        const prodisByFaculty = {
            'fmipa': ['Ilmu Komputer', 'Matematika', 'Pendidikan Matematika', 'Fisika', 'Pendidikan Fisika', 'Biologi',
                'Pendidikan Biologi', 'Kimia', 'Pendidikan Kimia'
            ],
            'fik': ['Pendidikan Teknologi Informasi', 'Pendidikan Teknik Elektronika', 'Pendidikan Teknik Elektro',
                'Teknik Informatika dan Komputer'
            ],
            'ft': ['Teknik Sipil', 'Teknik Mesin', 'Teknik Elektro', 'Pendidikan Teknik Bangunan',
                'Pendidikan Teknik Mesin'
            ],
            'fbs': ['Pendidikan Bahasa Indonesia', 'Pendidikan Bahasa Inggris', 'Pendidikan Bahasa Jerman',
                'Pendidikan Bahasa Prancis', 'Pendidikan Seni Rupa'
            ],
            'fip': ['Pendidikan Guru Sekolah Dasar', 'Pendidikan Anak Usia Dini', 'Bimbingan dan Konseling',
                'Teknologi Pendidikan', 'Pendidikan Luar Biasa'
            ],
            'fe': ['Pendidikan Ekonomi', 'Manajemen', 'Akuntansi', 'Pendidikan Administrasi Perkantoran'],
            'fis': ['Pendidikan Pancasila dan Kewarganegaraan', 'Pendidikan Sejarah', 'Pendidikan Geografi',
                'Pendidikan Sosiologi', 'Ilmu Komunikasi'
            ]
        };

        // Faculty change handler
        document.getElementById('fakultas').addEventListener('change', function() {
            const prodiSelect = document.getElementById('program_studi');
            prodiSelect.innerHTML = '<option value="">Select Department</option>';

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
            const tbody = document.getElementById('students-list');
            const row = document.createElement('tr');

            const studentData = {
                name: document.getElementById('nama_mahasiswa').value || 'John Doe',
                nim: document.getElementById('nim').value || '1234567890',
                country: document.getElementById('negara').value || 'United States',
                category: document.getElementById('kategori').value || 'inbound',
                department: document.getElementById('program_studi').value || 'Computer Science',
                faculty: document.getElementById('fakultas').value || 'FMIPA',
                status: document.getElementById('status').value || 'fulltime',
                startDate: document.getElementById('periode_mulai').value || '2024-01-01',
                endDate: document.getElementById('periode_akhir').value || '2024-12-31'
            };

            row.innerHTML = `
                <td>${studentData.name}</td>
                <td>${studentData.nim}</td>
                <td>${studentData.country}</td>
                <td><span class="badge bg-${studentData.category === 'inbound' ? 'success' : 'primary'}">${studentData.category}</span></td>
                <td>${studentData.department}</td>
                <td>${studentData.faculty.toUpperCase()}</td>
                <td>${studentData.status}</td>
                <td>${formatDate(studentData.startDate)} - ${formatDate(studentData.endDate)}</td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-warning">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteRow(this)">Delete</button>
                    </div>
                </td>
            `;

            tbody.appendChild(row);
            document.getElementById('international-student-form').reset();
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
            const rows = document.getElementById('students-list').getElementsByTagName('tr');

            Array.from(rows).forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchText) ? '' : 'none';
            });
        });
    </script>
@endsection
