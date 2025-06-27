@extends('admin.admin')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/international_student_dashboard.css') }}"> -->

@section('contentadmin')

    {{-- Awal: Perubahan untuk Vite --}}
    @vite([
        'resources/css/admin/international_student_dashboard.css',
        'resources/js/admin/international_student_dashboard.js'
    ])
    {{-- Akhir: Perubahan untuk Vite --}}
    
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

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input International Student Data</h3>
            </div>

            <form id="international-student-form" method="POST" action="{{ route('admin.mahasiswainternational.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="nama_mahasiswa" class="form-label">Student Name</label>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif                        
                        <input type="text" class="form-control" name="nama_mahasiswa" id="nama_mahasiswa"  value="{{ old('nama_mahasiswa') }}" required>
                        <div class="form-text text-muted">Enter the full name of the international student</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nim" class="form-label">Student ID (NIM)(OPTIONAL)</label>
                        <input type="text" class="form-control" id="nim" name="nim">
                        <div class="form-text text-muted">Enter the student's identification number</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="negara" class="form-label">Country</label>
                        <input type="text" class="form-control" id="negara" name="negara" required>
                        <div class="form-text text-muted">Enter the student's country of origin</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Category</label>
                        <select class="form-select" id="kategori" name="kategori"required>
                            <option value="">Select Category</option>
                            <option value="inbound">Inbound</option>
                            <option value="outbound">Outbound</option>
                        </select>
                        <div class="form-text text-muted">Select whether the student is inbound or outbound</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
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
                        <label for="fakultas" class="form-label">Faculty(OPTIONAL)</label>
                        <input type="text" class="form-control" id="fakultas" name="fakultas" >
                        <div class="form-text text-muted">Enter the faculty name</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="program_studi" class="form-label">Department(OPTIONAL)</label>
                        <input type="text" class="form-control" id="program_studi" name="program_studi" >
                        <div class="form-text text-muted">Enter the department name</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="periode_mulai" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="periode_mulai" name="periode_mulai" required>
                        <div class="form-text text-muted">Select the start date of the study period</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="periode_akhir" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="periode_akhir" name="periode_akhir" required>
                        <div class="form-text text-muted">Select the end date of the study period</div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
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
                            @foreach ($students as $student)
                                <tr>
                                    <td>{{ $student->nama_mahasiswa }}</td>
                                    <td>{{ $student->nim }}</td>
                                    <td>{{ $student->negara }}</td>
                                    <td>{{ ucfirst($student->kategori) }}</td>
                                    <td>{{ $student->program_studi }}</td>
                                    <td>{{ $student->fakultas }}</td>
                                    <td>{{ ucfirst($student->status) }}</td>
                                    <td>{{ $student->periode_mulai }} - {{ $student->periode_akhir }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-warning edit-student" 
                                                data-id="{{ $student->id }}">Edit</button>
                                            <form method="POST"
                                                action="{{ route('admin.mahasiswainternational.destroy', $student->id) }}"
                                                class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger delete-btn">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk mengedit mahasiswa -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentModalLabel">Edit International Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editStudentForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_nama_mahasiswa" class="form-label">Student Name</label>
                                <input type="text" class="form-control" name="nama_mahasiswa" id="edit_nama_mahasiswa" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_nim" class="form-label">Student ID (NIM)</label>
                                <input type="text" class="form-control" name="nim" id="edit_nim" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_negara" class="form-label">Country</label>
                                <input type="text" class="form-control" name="negara" id="edit_negara" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_kategori" class="form-label">Category</label>
                                <select class="form-select" name="kategori" id="edit_kategori" required>
                                    <option value="">Select Category</option>
                                    <option value="inbound">Inbound</option>
                                    <option value="outbound">Outbound</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_status" class="form-label">Status</label>
                                <select class="form-select" name="status" id="edit_status" required>
                                    <option value="">Select Status</option>
                                    <option value="fulltime">Full Time</option>
                                    <option value="parttime">Part Time</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_fakultas" class="form-label">Faculty</label>
                                <input type="text" class="form-control" name="fakultas" id="edit_fakultas" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_program_studi" class="form-label">Department</label>
                                <input type="text" class="form-control" name="program_studi" id="edit_program_studi" >
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_periode_mulai" class="form-label">Start Date</label>
                                <input type="date" class="form-control" name="periode_mulai" id="edit_periode_mulai" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_periode_akhir" class="form-label">End Date</label>
                                <input type="date" class="form-control" name="periode_akhir" id="edit_periode_akhir" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveEditStudent">Save Changes</button>
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

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Include international_student_dashboard.js for functionality -->
    <!-- <script src="{{ asset('resources/movejs/international_student_dashboard.js') }}"></script> -->
@endsection