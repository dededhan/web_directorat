@extends('prodi.index')

@section('contentprodi')

<div class="head-title">
    <div class="left">
        <h1>Manage Account</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Dashboard</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="#">Manage Account</a>
            </li>
        </ul>
    </div>
</div>

<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Informasi Akun</h3>
        </div>
        <div class="form-container p-4">
            {{-- The form's action, method, and values will be added when you implement the backend logic --}}
            <form>
                @csrf {{-- CSRF token is a good practice to include even in the layout --}}

                <div class="row">
                    {{-- Name Input --}}
                    <div class="col-12 mb-3">
                        <label for="name" class="form-label">Nama</label>
                        {{-- The name is typically read-only on this kind of page --}}
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Pengguna Anda" readonly>
                        <small class="form-text text-muted">Nama akun (role) tidak dapat diubah.</small>
                    </div>

                    {{-- Email Input --}}
                    <div class="col-12 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="email.anda@example.com">
                    </div>

                    {{-- New Password Input --}}
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password baru">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                    </div>

                    {{-- Confirm New Password Input --}}
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password baru">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Akun</button>
            </form>
        </div>
    </div>
</div>

{{-- I've included some basic styling here to match your existing pages. --}}
{{-- You can move this to your main CSS file. --}}
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
    }
    .form-control[readonly] {
        background-color: #e9ecef;
        opacity: 1;
    }
</style>

@endsection
