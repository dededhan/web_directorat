@extends('admin.admin')

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Responden</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Input Responden</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Responden Survey Input</h3>
                <div class="mb-3">
                    <label class="form-label">Tipe Responden</label>
                    <select class="form-select" id="respondent-type" name="type" style="width: auto;">
                        <option value="academic">Academic</option>
                        <option value="employee">Employee</option>
                    </select>
                </div>
            </div>
            

            <form id="survey-form">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="title" class="form-label">Mr/Mrs/Ms</label>
                        <select class="form-select" id="title" required>
                            <option value="">Select Title</option>
                            <option value="mr">Mr.</option>
                            <option value="mrs">Mrs.</option>
                            <option value="ms">Ms.</option>
                        </select>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="instansi" class="form-label">Instansi</label>
                        <input type="text" class="form-control" id="instansi" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nomor_responden" class="form-label">Nomor Responden</label>
                        <input type="text" class="form-control" id="nomor_responden" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_dosen" class="form-label">Nama Dosen</label>
                        <input type="text" class="form-control" id="nama_dosen" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nomor_narahubung" class="form-label">Nomor Narahubung</label>
                        <input type="text" class="form-control" id="nomor_narahubung" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="fakultas_narahubung" class="form-label">Fakultas Narahubung</label>
                        <select class="form-select" id="fakultas_narahubung" required>
                            <option value="">Pilih Fakultas</option>
                            <option value="fmipa">FMIPA</option>
                            <option value="fik">FIK</option>
                            <option value="ft">FT</option>
                            <option value="fbs">FBS</option>
                            <option value="fip">FIP</option>
                            <option value="fe">FE</option>
                            <option value="fis">FIS</option>
                            <option value="ft">FT</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori" required>
                            <option value="">Pilih Kategori</option>
                            <option value="kategori1">Kategori 1</option>
                            <option value="kategori2">Kategori 2</option>
                            <option value="kategori3">Kategori 3</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="column" class="form-label">Column</label>
                        <select class="form-select" id="column" required>
                            <option value="">Pilih Column</option>
                            <option value="column1">Column 1</option>
                            <option value="column2">Column 2</option>
                            <option value="column3">Column 3</option>
                        </select>
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
                    <h3>Daftar Responden</h3>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="respondent-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Nama Lengkap</th>
                                <th>Jabatan</th>
                                <th>Instansi</th>
                                <th>Email</th>
                                <th>No. Responden</th>
                                <th>Nama Dosen</th>
                                <th>No. Narahubung</th>
                                <th>Fakultas</th>
                                <th>Kategori</th>
                                <th>Type</th>
                                <th>Column</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="respondent-list">
                            <!-- Dynamically added rows will appear here -->
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
        
        .badge {
            font-size: 0.7em;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }
    </style>
@endsection