@extends('admin.admin')

@section('contentadmin')
<div class="head-title">
    <div class="left">
        <h1>Manage Users</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Dashboard</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="#">Manage Users</a>
            </li>
        </ul>
    </div>
</div>

<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Add New User</h3>
        </div>
        <div class="form-container p-4">
            <form method="POST" action="{{ route('admin.manageuser.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="">Select Role</option>
                            <option value="admin_direktorat">Admin Direktorat</option>
                            <option value="kepala_direktorat">Kepala Direktorat</option>
                            <option value="admin_pemeringkatan">Admin Pemeringkatan</option>
                            <option value="fakultas">Fakultas</option>
                            <option value="prodi">Prodi</option>
                            <option value="admin_hilirisasi">Admin Hilirisasi</option>
                            <option value="kepala_sub_direktorat">Kepala Sub Direktorat</option>
                            <option value="wr3">Wakil Rektor 3</option>
                            <option value="dosen">Dosen</option>
                            <option value="mahasiswa">mahasiswa</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<div class="table-data mt-4">
    <div class="order">
        <div class="head">
            <h3>Users List</h3>
            <div class="search-box">
                <input type="text" id="searchInput" class="form-control" placeholder="Search users...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table" id="users-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary">
                                    <i class='bx bx-edit-alt'></i>
                                </button>
                                <button class="btn btn-sm btn-danger">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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

    .head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
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
    }

    .search-box {
        width: 300px;
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .table td {
        vertical-align: middle;
    }

    .btn-group {
        display: flex;
        gap: 5px;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
    }

    @media (max-width: 768px) {
        .search-box {
            width: 100%;
            margin-top: 10px;
        }

        .head {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const table = document.getElementById('users-table');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        for (let row of rows) {
            let text = '';
            for (let cell of row.getElementsByTagName('td')) {
                text += cell.textContent.toLowerCase() + ' ';
            }
            row.style.display = text.includes(searchText) ? '' : 'none';
        }
    });
</script>
@endsection