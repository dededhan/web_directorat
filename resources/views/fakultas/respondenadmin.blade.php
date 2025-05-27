@extends('fakultas.index')
<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/responden_dashboard.css') }}">
@section('contentfakultas')
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
            </div>

            <form id="survey-form" method="POST" action="{{ route('admin.responden.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="title" class="form-label">Mr/Mrs/Ms</label>
                        <select class="form-select" name="responden_title" id="title" required>
                            <option value="">Select Title</option>
                            <option value="mr">Mr.</option>
                            <option value="mrs">Mrs.</option>
                            <option value="ms">Ms.</option>
                        </select>
                        <div class="form-text text-muted">Pilih title/gelar yang sesuai dengan responden</div>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="responden_fullname" id="nama_lengkap" required>
                        <div class="form-text text-muted">Masukkan nama lengkap responden beserta gelar akademik (jika ada)
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" name="responden_jabatan" id="jabatan" required>
                        <div class="form-text text-muted">Masukkan jabatan/posisi responden di instansi tempat bekerja</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="instansi" class="form-label">Instansi</label>
                        <input type="text" class="form-control" name="responden_instansi" id="instansi" required>
                        <div class="form-text text-muted">Masukkan nama instansi/perusahaan tempat responden bekerja</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                        <div class="form-text text-muted">Masukkan alamat email aktif responden untuk keperluan survey</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nomor_responden" class="form-label">Nomor Responden</label>
                        <input type="text" class="form-control" name="phone_responden" id="nomor_responden">
                        <div class="form-text text-muted">Masukkan nomor telepon aktif responden (format: 08xxxx)</div>
                        @error('phone_responden')
                            <span style="color: red">Nomor hp sama</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_dosen" class="form-label">Nama Dosen</label>
                        <input type="text" class="form-control" name="responden_dosen" id="nama_dosen" required>
                        <div class="form-text text-muted">Masukkan nama lengkap dosen yang mengusulkan responden</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nomor_narahubung" class="form-label">Nomor Narahubung</label>
                        <input type="text" class="form-control" name="responden_dosen_phone" id="nomor_narahubung"
                            required>
                        <div class="form-text text-muted">Masukkan nomor telepon aktif dosen pengusul (format: 08xxxx)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fakultas_narahubung" class="form-label">Fakultas Narahubung</label>
                        <select class="form-select" name="responden_fakultas" id="fakultas_narahubung" required>
                            <option value="">Pilih Fakultas</option>
                            <option value="pascasarjana">PASCASARJANA</option>
                            <option value="fip">FIP</option>
                            <option value="fmipa">FMIPA</option>
                            <option value="fpsi">FPsi</option>
                            <option value="fbs">FBS</option>
                            <option value="ft">FT</option>
                            <option value="fik">FIKK</option>
                            <option value="fish">FISH</option>
                            <option value="feb">FEB</option>
                            <option value="profesi">PROFESI</option>
                        </select>
                        <div class="form-text text-muted">Pilih fakultas dari dosen pengusul</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipe Responden</label>
                        <select class="form-select" id="respondent-type" name="responden_category" style="width: auto;">
                            <option value="academic">Academic</option>
                            <option value="employer">Employer</option>
                        </select>
                        <div class="form-text text-muted">Pilih kategori responden: Academic (dari institusi pendidikan)
                            atau Employer (dari dunia kerja/industri)</div>
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
                    <div class="d-flex justify-content-end align-items-center">
                        <form method="GET" action="{{ route('admin.responden.index') }}" class="me-3">
                            <div class="row g-2 align-items-center">
                                <div class="col-auto">
                                    <select class="form-select" name="kategori" id="filterKategori">
                                        <option value="">Semua Kategori</option>
                                        <option value="academic" {{ request('kategori') == 'academic' ? 'selected' : '' }}>Academic</option>
                                        <option value="employer" {{ request('kategori') == 'employer' ? 'selected' : '' }}>Employer</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <select class="form-select" name="fakultas" id="filterFakultas">
                                        <option value="">Semua Fakultas</option>
                                        <option value="pascasarjana" {{ request('fakultas') == 'pascasarjana' ? 'selected' : '' }}>PASCASARJANA</option>
                                        <option value="fip" {{ request('fakultas') == 'fip' ? 'selected' : '' }}>FIP</option>
                                        <option value="fmipa" {{ request('fakultas') == 'fmipa' ? 'selected' : '' }}>FMIPA</option>
                                        <option value="fpsi" {{ request('fakultas') == 'fpsi' ? 'selected' : '' }}>FPsi</option>
                                        <option value="fbs" {{ request('fakultas') == 'fbs' ? 'selected' : '' }}>FBS</option>
                                        <option value="ft" {{ request('fakultas') == 'ft' ? 'selected' : '' }}>FT</option>
                                        <option value="fik" {{ request('fakultas') == 'fik' ? 'selected' : '' }}>FIKK</option>
                                        <option value="fish" {{ request('fakultas') == 'fish' ? 'selected' : '' }}>FISH</option>
                                        <option value="feb" {{ request('fakultas') == 'feb' ? 'selected' : '' }}>FEB</option>
                                        <option value="profesi" {{ request('fakultas') == 'profesi' ? 'selected' : '' }}>PROFESI</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="{{ route('admin.responden.index') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </form>
                        <div class="export-buttons me-3">
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal">
                                    <i class='bx bx-import'></i> Import Excel
                                </button>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exportFilterModal">
                                    <i class='bx bx-export'></i> Export Excel
                                </button>
                            </div>
                        </div>
                        <div class="search-box">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                        </div>
                        
                    </div>
                </div>
                

                <div class="table-responsive">
                    <table class="table table-striped" id="respondent-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Nama Lengkap</th>
                                <th>Jabatan</th>
                                <th>Instansi</th>
                                <th>Email</th>
                                <th>No. Responden</th>
                                <th>Nama Dosen</th>
                                <th>No. Narahubung</th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'fakultas', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                        fakultas
                                        @if(request('sort') == 'fakultas')
                                            {!! request('direction') == 'asc' ? '↑' : '↓' !!}
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'category', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                        category
                                        @if(request('sort') == 'category')
                                            {!! request('direction') == 'asc' ? '↑' : '↓' !!}
                                        @endif
                                    </a>
                                </th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody id="respondent-list">
                            @forelse($respondens as $i => $responden)
                                <tr>
                                    <td>{{ $respondens->firstItem() + $i }}</td>
                                    <td>{{ Str::ucfirst($responden->title) }}</td>
                                    <td>{{ $responden->fullname }}</td>
                                    <td>{{ $responden->jabatan }}</td>
                                    <td>{{ $responden->instansi }}</td>
                                    <td>{{ $responden->email }}</td>
                                    <td>{{ $responden->phone_responden }}</td>
                                    <td>{{ $responden->nama_dosen_pengusul }}</td>
                                    <td>{{ $responden->phone_dosen }}</td>
                                    <td>{{ $responden->fakultas }}</td>
                                    <td>{{ $responden->category }}</td>
                                    <td>
                                        <select class="form-select status-dropdown" data-id="{{ $responden->id }}"
                                            {{ $responden->status == 'dones' ? 'disabled' : '' }}>
                                            <option value="belum" {{ $responden->status == 'belum' ? 'selected' : '' }}>
                                                Belum di-email</option>
                                            <option value="done" {{ $responden->status == 'done' ? 'selected' : '' }}>
                                                Sudah di-email, belum di-follow up</option>
                                            <option value="dones" {{ $responden->status == 'dones' ? 'selected' : '' }}>
                                                Sudah di-email, sudah di-follow up</option>
                                            @if ($responden->status == 'clear')
                                                <option value="clear" selected>selesai</option>
                                            @endif
                                        </select>
                                    </td>

                                </tr>
                            @empty
                                <span>Data Belum Ada</span>
                            @endforelse
                            <!-- Pagination -->
                            
                        </tbody>
                    </table>
                    <div class="custom-pagination d-flex justify-content-end mt-3">
                        {{ $respondens->links('pagination::bootstrap-5') }}
                    </div>
                  

                </div>
            </div>
        </div>
    </div>

    <!-- Import Excel Modal -->
    <div class="modal fade pt-3" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog pt-3">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Responden from Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="importForm" action="{{ route('admin.responden.import') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="excelFile" class="form-label">Select Excel File</label>
                            <input class="form-control" type="file" id="excelFile" name="file"
                                accept=".xlsx,.xls" required>
                            <div class="form-text">File harus sesuai dengan format yang ditentukan</div>
                        </div>
                        {{-- <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="skipDuplicates"
                                    name="skip_duplicates" checked>
                                <label class="form-check-label" for="skipDuplicates">
                                    Skip duplicate entries (based on email and phone)
                                </label>
                            </div>
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Export Filter Modal -->
    <div class="modal fade pt-3" id="exportFilterModal" tabindex="-1" aria-labelledby="exportFilterModalLabel" aria-hidden="true" >
        <div class="modal-dialog pt-3" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportFilterModalLabel">Filter Export</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="filterCategory" class="form-label">Kategori</label>
                        <select class="form-select" id="filterCategory">
                            <option value="">Semua Kategori</option>
                            <option value="academic">Academic</option>
                            <option value="employer">Employer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="filterFakultas" class="form-label">Fakultas</label>
                        <select class="form-select" id="filterFakultas">
                            <option value="">Semua Fakultas</option>
                            <option value="pascasarjana">PASCASARJANA</option>
                            <option value="fip">FIP</option>
                            <option value="fmipa">FMIPA</option>
                            <option value="fpsi">FPsi</option>
                            <option value="fbs">FBS</option>
                            <option value="ft">FT</option>
                            <option value="fik">FIKK</option>
                            <option value="fish">FISH</option>
                            <option value="feb">FEB</option>
                            <option value="profesi">PROFESI</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="exportFilteredExcel">Export Excel</button>
                    <button type="button" class="btn btn-info" id="exportFilteredCSV">Export CSV</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Import form submission
        document.getElementById('importForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            axios.post(this.action, formData)
                .then(response => {
                    $('#importModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.data.message || 'Data imported successfully',
                    }).then(() => {
                        window.location.reload();
                    });
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Import Failed',
                        text: error.response?.data?.message || 'Error importing file',
                    });
                });
        });

        // Filter functionality
        document.getElementById('emailFilter').addEventListener('keyup', function() {
            filterRespondents();
        });

        document.getElementById('phoneFilter').addEventListener('keyup', function() {
            filterRespondents();
        });

        document.getElementById('resetFilters').addEventListener('click', function() {
            document.getElementById('emailFilter').value = '';
            document.getElementById('phoneFilter').value = '';
            filterRespondents();
        });

        function filterRespondents() {
            const email = document.getElementById('emailFilter').value.toLowerCase();
            const phone = document.getElementById('phoneFilter').value.toLowerCase();
            const rows = document.querySelectorAll('#respondent-table tbody tr');

            rows.forEach(row => {
                const rowEmail = row.cells[4].textContent.toLowerCase();
                const rowPhone = row.cells[5].textContent.toLowerCase();

                const emailMatch = email === '' || rowEmail.includes(email);
                const phoneMatch = phone === '' || rowPhone.includes(phone);

                row.style.display = emailMatch && phoneMatch ? '' : 'none';
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            document.getElementById('exportFilteredExcel').addEventListener('click', function() {
                const category = document.getElementById('filterCategory').value;
                const fakultas = document.getElementById('filterFakultas').value;
                
                let url = '{{ route("admin.responden.export") }}?';
                const params = [];
                if (category) params.push(`kategori=${encodeURIComponent(category)}`);
                if (fakultas) params.push(`fakultas=${encodeURIComponent(fakultas)}`);
                url += params.join('&');
                
                window.location.href = url;
            });

            // Handle CSV Export
            document.getElementById('exportFilteredCSV').addEventListener('click', function() {
                const category = document.getElementById('filterCategory').value;
                const fakultas = document.getElementById('filterFakultas').value;
                
                let url = '{{ route("admin.responden.exportCSV") }}?';
                const params = [];
                if (category) params.push(`kategori=${encodeURIComponent(category)}`);
                if (fakultas) params.push(`fakultas=${encodeURIComponent(fakultas)}`);
                url += params.join('&');
                
                window.location.href = url;
            });
            document.querySelectorAll('.status-dropdown').forEach(select => {
                // Initial state check
                const updateButton = select.closest('tr').querySelector('.update-status');
                if (select.value === 'clear') {
                    // Disable button when status is clear
                    updateButton.disabled = true;
                    updateButton.classList.add('btn-secondary');
                    updateButton.classList.remove('btn-warning');
                }

                select.addEventListener('change', function() {
                    const respondenId = this.dataset.id;
                    const newStatus = this.value;
                    const updateButton = this.closest('tr').querySelector('.update-status');

                    // Store previous value for rollback if needed
                    const previousValue = this.dataset.previousValue;

                    // Prevent selecting 'clear' status manually
                    if (newStatus === 'clear') {
                        this.value = previousValue;
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Action',
                            text: 'Status "selesai" cannot be set manually',
                        });
                        return;
                    }

                    updateStatus(this, respondenId, newStatus, updateButton);
                });

                // Store initial value
                select.dataset.previousValue = select.value;
            });

            function updateStatus(selectElement, respondenId, newStatus, updateButton) {
                axios.post(`/admin/responden/update-status/${respondenId}`, {
                        status: newStatus,
                        _token: csrfToken
                    })
                    .then(response => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.data.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        const badge = selectElement.closest('tr').querySelector('.status-badge');
                        if (badge) {
                            badge.textContent = response.data.new_status;
                        }
                    })
                    .catch(error => {
                        // Revert to previous value on error
                        selectElement.value = selectElement.dataset.previousValue;
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: error.response?.data?.message || 'Terjadi kesalahan',
                        });
                    })
                    .finally(() => {
                        selectElement.dataset.previousValue = newStatus;
                    });
            }
        });


        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const table = document.getElementById('respondent-table');
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

    <style>
        
    </style>
@endsection
