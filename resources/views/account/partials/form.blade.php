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

{{-- Alert Messages --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class='bx bx-check-circle'></i>
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class='bx bx-x-circle'></i>
        <strong>Gagal!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class='bx bx-error-circle'></i>
        <strong>Terdapat kesalahan:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Informasi Akun</h3>
        </div>
        <div class="form-container p-4">
            <form action="{{ route(auth()->user()->role . '.manage.account.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Name Input --}}
                    <div class="col-12 mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" readonly>
                        <small class="form-text text-muted">Nama akun (role) tidak dapat diubah.</small>
                    </div>

                    {{-- Email Input --}}
                    <div class="col-12 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="email.anda@example.com" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- New Password Input --}}
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password baru">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Confirm New Password Input --}}
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password baru">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class='bx bx-save'></i> Update Akun
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .alert {
        margin-top: 24px;
        border-radius: 12px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .alert i {
        font-size: 24px;
    }
    
    .alert-success {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }
    
    .alert ul {
        padding-left: 20px;
    }
    
    .alert .btn-close {
        margin-left: auto;
    }
    
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
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }
    
    .form-control.is-invalid {
        border-color: #dc3545;
    }
    
    .form-control.is-invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    .invalid-feedback {
        display: block;
        margin-top: 0.25rem;
        font-size: 0.875rem;
        color: #dc3545;
    }
    
    .btn-primary {
        background-color: #3498db;
        border-color: #3498db;
        padding: 10px 24px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-primary:hover {
        background-color: #2980b9;
        border-color: #2980b9;
    }
    
    .form-control[readonly] {
        background-color: #e9ecef;
        opacity: 1;
    }
    
    .text-danger {
        color: #dc3545;
    }
</style>

<script>
    // Auto-dismiss alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
