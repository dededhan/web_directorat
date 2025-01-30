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
            <form>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-control" id="role" name="role">
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
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection