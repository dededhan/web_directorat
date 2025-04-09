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
                            <option value="validator">Penilai</option>
                            <option value="registered_user">Pengguna Terdaftar</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<!-- System Users Table -->
<div class="table-data mt-4">
    <div class="order">
        <div class="head">
            <h3>System Users</h3>
            <div class="search-box">
                <input type="text" id="searchSystemInput" class="form-control" placeholder="Search system users...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table" id="system-users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users->where('role', '!=', 'registered_user') as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            @if($user->avatar)
                                <div class="d-flex align-items-center">
                                    <img src="{{ $user->avatar }}" alt="Avatar" class="rounded-circle me-2" width="30">
                                    {{ $user->name }}
                                </div>
                            @else
                                {{ $user->name }}
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <div class="password-field position-relative">
                                <input type="password" class="form-control password-input" value="{{ $user->password }}" readonly>
                                <button type="button" class="btn btn-sm btn-outline-secondary toggle-password position-absolute end-0 top-0 h-100">
                                    <i class='bx bx-show'></i>
                                </button>
                            </div>
                        </td>
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

<!-- Registered Users Table -->
<div class="table-data mt-4">
    <div class="order">
        <div class="head">
            <h3>Registered Users</h3>
            <div class="d-flex align-items-center">
                <span class="badge bg-info me-3">Total: {{ $users->where('role', 'registered_user')->count() }}</span>
                <div class="search-box">
                    <input type="text" id="searchRegisteredInput" class="form-control" placeholder="Search registered users...">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table" id="registered-users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Registration</th>
                        <th>Joined</th>
                        <th>status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users->where('role', 'registered_user') as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($user->avatar)
                                    <img src="{{ $user->avatar }}" alt="Avatar" class="rounded-circle me-2" width="30">
                                @else
                                    <div class="rounded-circle me-2 bg-secondary d-flex align-items-center justify-content-center text-white" style="width: 30px; height: 30px;">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                                {{ $user->name }}
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->google_id)
                                <span class="badge bg-primary">
                                    <i class="bx bxl-google me-1"></i> Google
                                </span>
                            @else
                                <span class="badge bg-secondary">Standard</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            @if($user->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Unactive</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.manageuser.toggleStatus', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-{{ $user->status === 'active' ? 'danger' : 'success' }}">
                                    {{ $user->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                        </td>
                        {{-- <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary">
                                    <i class='bx bx-edit-alt'></i>
                                </button>
                                <button class="btn btn-sm btn-danger">
                                    <i class='bx bx-trash'></i>
                                </button>
                                <button class="btn btn-sm btn-info">
                                    <i class='bx bx-user-check'></i>
                                </button>
                            </div>
                        </td> --}}
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

    .password-field {
        width: 200px;
    }

    .toggle-password {
        background: transparent;
        border: none;
        border-left: 1px solid #ced4da;
        border-radius: 0;
    }

    .toggle-password:hover {
        background-color: #f8f9fa;
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

        .password-field {
            width: 100%;
        }
    }
</style>

<script>
    // Search functionality for system users table
    document.getElementById('searchSystemInput').addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const table = document.getElementById('system-users-table');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        for (let row of rows) {
            let text = '';
            for (let cell of row.getElementsByTagName('td')) {
                text += cell.textContent.toLowerCase() + ' ';
            }
            row.style.display = text.includes(searchText) ? '' : 'none';
        }
    });
    
    // Search functionality for registered users table
    document.getElementById('searchRegisteredInput').addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const table = document.getElementById('registered-users-table');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        for (let row of rows) {
            let text = '';
            for (let cell of row.getElementsByTagName('td')) {
                text += cell.textContent.toLowerCase() + ' ';
            }
            row.style.display = text.includes(searchText) ? '' : 'none';
        }
    });

    // Toggle password visibility
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = document.querySelectorAll('.toggle-password');
        
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const passwordInput = this.previousElementSibling;
                const icon = this.querySelector('i');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('bx-show');
                    icon.classList.add('bx-hide');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('bx-hide');
                    icon.classList.add('bx-show');
                }
            });
        });
    });
</script>
@endsection