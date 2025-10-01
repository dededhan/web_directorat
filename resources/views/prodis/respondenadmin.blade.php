@extends('prodis.index')
@vite([
        'resources/css/admin/responden_dashboard.css'
    ])
@section('contentprodis')

    @if ($errors->has('email'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan Data',
                    text: '{{ $errors->first('email') }}',
                });
            });
        </script>
    @endif
    <div class="head-title">
        <div class="left">
            <h1>Responden</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('prodis.dashboard') }}">Dashboard</a>
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
            @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
            <form id="survey-form" method="POST" action="{{ route('prodis.responden.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="title" class="form-label">Mr/Mrs/Ms <span style="color: red;">*</span></label>
                        <select class="form-select" name="responden_title" id="title" required>
                            <option value="">Select Title</option>
                            <option value="mr">Mr.</option>
                            <option value="mrs">Mrs.</option>
                            <option value="ms">Ms.</option>
                        </select>
                        <div class="form-text text-muted">Pilih title/gelar yang sesuai dengan responden</div>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" name="responden_fullname" id="nama_lengkap" required>
                        <div class="form-text text-muted">Masukkan nama lengkap responden beserta gelar akademik (jika ada)
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="jabatan" class="form-label">Jabatan <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" name="responden_jabatan" id="jabatan" required>
                        <div class="form-text text-muted">Masukkan jabatan/posisi responden di instansi tempat bekerja</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="instansi" class="form-label">Instansi <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" name="responden_instansi" id="instansi" required>
                        <div class="form-text text-muted">Masukkan nama instansi/perusahaan tempat responden bekerja</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span style="color: red;">*</span></label>
                        <input type="email" class="form-control" name="email" id="email" required>
                        <div class="form-text text-muted">Masukkan alamat email aktif responden untuk keperluan survey</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nomor_responden" class="form-label">Nomor Responden (Opsional)</label>
                        <input type="text" class="form-control" name="phone_responden" id="nomor_responden">
                        <div class="form-text text-muted">Masukkan nomor telepon aktif responden (format: 08xxxx)</div>
                        @error('phone_responden')
                            <span style="color: red">Nomor hp sama</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_dosen" class="form-label">Nama Dosen <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" name="responden_dosen" id="nama_dosen" required>
                        <div class="form-text text-muted">Masukkan nama lengkap dosen yang mengusulkan responden</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nomor_narahubung" class="form-label">Nomor Narahubung <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" name="responden_dosen_phone" id="nomor_narahubung"
                            required>
                        <div class="form-text text-muted">Masukkan nomor telepon aktif dosen pengusul (format: 08xxxx)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fakultas_narahubung" class="form-label">Fakultas Narahubung <span style="color: red;">*</span></label>
                        <select class="form-select" name="responden_fakultas" id="fakultas_narahubung" required>
                            <option value="">Pilih Fakultas</option>
                            <option value="pascasarjana">PASCASARJANA</option>
                            <option value="fip">FIP</option>
                            <option value="fmipa">FMIPA</option>
                            <option value="fpsi">FPsi</option>
                            <option value="fbs">FBS</option>
                            <option value="ft">FT</option>
                            <option value="fikk">FIKK</option>
                            <option value="fish">FISH</option>
                            <option value="feb">FEB</option>
                            <option value="profesi">PROFESI</option>
                        </select>
                        <div class="form-text text-muted">Pilih fakultas dari dosen pengusul</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipe Responden <span style="color: red;">*</span></label>
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
                        <form method="GET" action="{{ route('prodis.responden.index') }}" class="me-3 w-100">
                             <div class="row g-2 align-items-center">
                                <div class="col-md-3">
                                    <input type="text" name="search" id="searchInput" class="form-control"
                                        placeholder="Search..." value="{{ request('search') }}">
                                </div>
                                <div class="col-auto">
                                    <select class="form-select" name="kategori" id="filterKategori">
                                        <option value="">Semua Kategori</option>
                                        <option value="academic" {{ request('kategori') == 'academic' ? 'selected' : '' }}>
                                            Academic</option>
                                        <option value="employer" {{ in_array(request('kategori'), ['employer', 'employee']) ? 'selected' : '' }}>
                                            Employer</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <select class="form-select" name="status" id="filterStatus">
                                        <option value="">Semua Status</option>
                                        <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum di-email</option>
                                        <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Sudah di-email, belum di-follow up</option>
                                        <option value="dones" {{ request('status') == 'dones' ? 'selected' : '' }}>Sudah di-email, sudah di-follow up</option>
                                        <option value="clear" {{ request('status') == 'clear' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <label for="perPageFilter" class="form-label visually-hidden">Show</label>
                                    <select class="form-select" name="per_page" id="perPageFilter">
                                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                        <option value="2000" {{ request('per_page') == 2000 ? 'selected' : '' }}>All</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <input type="date" name="filter_date" class="form-control" value="{{ request('filter_date') }}">
                                </div>

                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="{{ route('prodis.responden.index') }}" class="btn btn-secondary">Reset</a>
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
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody id="respondent-list">
                            @forelse($respondens as $i => $responden)
                                <tr id="responden-row-{{ $responden->id }}">
                                    <td>{{ $respondens->firstItem() + $i }}</td>
                                    <td class="responden-title">{{ Str::ucfirst($responden->title) }}</td>
                                    <td class="responden-fullname">{{ $responden->fullname }}</td>
                                    <td class="responden-jabatan">{{ $responden->jabatan }}</td>
                                    <td class="responden-instansi">{{ $responden->instansi }}</td>
                                    <td class="responden-email">{{ $responden->email }}</td>
                                    <td class="responden-phone_responden">{{ $responden->phone_responden }}</td>
                                    <td class="responden-nama_dosen_pengusul">{{ $responden->nama_dosen_pengusul }}</td>
                                    <td class="responden-phone_dosen">{{ $responden->phone_dosen }}</td>
                                    <td class="responden-fakultas">{{ strtoupper($responden->fakultas) }}</td>
                                    <td class="responden-category">{{ $responden->category }}</td>
                                    <td>
                                        @switch(strtolower($responden->status))
                                            @case('belum')
                                                <span class="badge-status pending">
                                                    <i class='bx bx-time-five'></i> Belum di-email
                                                </span>
                                                @break
                                            @case('done')
                                                <span class="badge-status emailed">
                                                    <i class='bx bxs-paper-plane'></i> Sudah di-email
                                                </span>
                                                @break
                                            @case('dones')
                                                <span class="badge-status followed-up">
                                                    <i class='bx bx-check-double'></i> Di-follow up
                                                </span>
                                                @break
                                            @case('clear')
                                                <span class="badge-status completed">
                                                    <i class='bx bxs-check-circle'></i> Selesai
                                                </span>
                                                @break
                                            @default
                                                <span class="badge-status default">
                                                    {{ $responden->status }}
                                                </span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-warning btn-sm edit-btn" data-id="{{ $responden->id }}" data-bs-toggle="modal" data-bs-target="#editRespondenModal">
                                                <i class='bx bxs-edit'></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $responden->id }}">
                                                <i class='bx bxs-trash'></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center">Data Belum Ada</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            @if ($respondens->total() > 0)
                                <span class="text-muted">
                                    Showing {{ $respondens->firstItem() }} to {{ $respondens->lastItem() }} of
                                    {{ $respondens->total() }} results
                                </span>
                            @else
                                <span class="text-muted">No results found</span>
                            @endif
                        </div>
                        <div>
                            <div class="btn-group">
                                <a href="{{ $respondens->appends(request()->query())->previousPageUrl() }}"
                                   class="btn btn-outline-primary @if ($respondens->onFirstPage()) disabled @endif">
                                    &laquo; Previous
                                </a>
                                <a href="{{ $respondens->appends(request()->query())->nextPageUrl() }}"
                                   class="btn btn-outline-primary @if (!$respondens->hasMorePages()) disabled @endif">
                                    Next &raquo;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- MODAL EDIT --}}
    <div class="modal fade" id="editRespondenModal" tabindex="-1" aria-labelledby="editRespondenModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRespondenModalLabel">Edit Responden</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit-survey-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="edit_title" class="form-label">Mr/Mrs/Ms</label>
                                <select class="form-select" name="title" id="edit_title" required>
                                    <option value="mr">Mr.</option>
                                    <option value="mrs">Mrs.</option>
                                    <option value="ms">Ms.</option>
                                </select>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="edit_fullname" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="fullname" id="edit_fullname" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_jabatan" class="form-label">Jabatan</label>
                                <input type="text" class="form-control" name="jabatan" id="edit_jabatan" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_instansi" class="form-label">Instansi</label>
                                <input type="text" class="form-control" name="instansi" id="edit_instansi" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="edit_email" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_phone_responden" class="form-label">Nomor Responden</label>
                                <input type="text" class="form-control" name="phone_responden" id="edit_phone_responden">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_nama_dosen_pengusul" class="form-label">Nama Dosen</label>
                                <input type="text" class="form-control" name="nama_dosen_pengusul" id="edit_nama_dosen_pengusul" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_phone_dosen" class="form-label">Nomor Narahubung</label>
                                <input type="text" class="form-control" name="phone_dosen" id="edit_phone_dosen" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_fakultas" class="form-label">Fakultas Narahubung</label>
                                <select class="form-select" name="fakultas" id="edit_fakultas" required>
                                    <option value="pascasarjana">PASCASARJANA</option>
                                    <option value="fip">FIP</option>
                                    <option value="fmipa">FMIPA</option>
                                    <option value="fpsi">FPsi</option>
                                    <option value="fbs">FBS</option>
                                    <option value="ft">FT</option>
                                    <option value="fikk">FIKK</option>
                                    <option value="fish">FISH</option>
                                    <option value="feb">FEB</option>
                                    <option value="profesi">PROFESI</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_category" class="form-label">Tipe Responden</label>
                                <select class="form-select" name="category" id="edit_category" required>
                                    <option value="academic">Academic</option>
                                    <option value="employer">Employer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
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
                <form id="importForm" action="{{ route('prodis.responden.import') }}" method="POST"
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
                         <hr> {{-- Section for DOWNLOADING the template --}}
                        <div class="mb-2">
                            <label class="form-label">Don't have the template?</label>
                            <br>
                            {{-- This is the download button --}}
                            <a href="{{ asset('templates/template_responden.xlsx') }}" class="btn btn-sm btn-success" download>
                                Download Format Here
                            </a>
                        </div>
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
                        <label for="exportFilterCategory" class="form-label">Kategori</label>
                        <select class="form-select" id="exportFilterCategory">
                            <option value="">Semua Kategori</option>
                            <option value="academic">Academic</option>
                            <option value="employer">Employer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exportFilterFakultas" class="form-label">Fakultas</label>
                        <select class="form-select" id="exportFilterFakultas">
                            <option value="">Semua Fakultas</option>
                            <option value="pascasarjana">PASCASARJANA</option>
                            <option value="fip">FIP</option>
                            <option value="fmipa">FMIPA</option>
                            <option value="fpsi">FPsi</option>
                            <option value="fbs">FBS</option>
                            <option value="ft">FT</option>
                            <option value="fikk">FIKK</option>
                            <option value="fish">FISH</option>
                            <option value="feb">FEB</option>
                            <option value="profesi">PROFESI</option>
                        </select>
                    </div>
                     <div class="mb-3">
                        <label for="exportFilterStatus" class="form-label">Status</label>
                        <select class="form-select" id="exportFilterStatus">
                            <option value="">Semua Status</option>
                            <option value="belum">Belum di-email</option>
                            <option value="done">Sudah di-email, belum di-follow up</option>
                            <option value="dones">Sudah di-email, sudah di-follow up</option>
                            <option value="clear">Selesai</option>
                        </select>
                    </div>
                     <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="exportStartDate" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="exportStartDate">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="exportEndDate" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="exportEndDate">
                        </div>
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
        // edit delete 
    document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const routePrefix = "{{ $routePrefix ?? 'prodis' }}";

            // Handle Edit button click
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const respondenId = this.dataset.id;
                    const url = `/${routePrefix}/responden/${respondenId}/edit`;
                    
                    axios.get(url)
                        .then(response => {
                            const responden = response.data;
                            const form = document.getElementById('edit-survey-form');
                            
                            form.action = `/${routePrefix}/responden/${respondenId}`;
                            
                            form.querySelector('#edit_title').value = responden.title;
                            form.querySelector('#edit_fullname').value = responden.fullname;
                            form.querySelector('#edit_jabatan').value = responden.jabatan;
                            form.querySelector('#edit_instansi').value = responden.instansi;
                            form.querySelector('#edit_email').value = responden.email;
                            form.querySelector('#edit_phone_responden').value = responden.phone_responden;
                            form.querySelector('#edit_nama_dosen_pengusul').value = responden.nama_dosen_pengusul;
                            form.querySelector('#edit_phone_dosen').value = responden.phone_dosen;
                            form.querySelector('#edit_fakultas').value = responden.fakultas;
                            form.querySelector('#edit_category').value = responden.category;
                        })
                        .catch(error => {
                             Swal.fire({
                                icon: 'error',
                                title: 'Gagal Memuat Data',
                                text: 'Tidak dapat memuat data untuk diedit.',
                            });
                            console.error('Error fetching responden data:', error);
                        });
                });
            });

            // Handle Edit form submission
            document.getElementById('edit-survey-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const form = e.target;
                const url = form.action;
                const formData = new FormData(form);

                axios.post(url, formData)
                    .then(response => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editRespondenModal'));
                        modal.hide();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.data.message,
                        });
                        
                        // Update table row with new data
                        const updatedData = response.data.data;
                        const row = document.getElementById(`responden-row-${updatedData.id}`);
                        if(row) {
                            row.querySelector('.responden-title').textContent = updatedData.title.charAt(0).toUpperCase() + updatedData.title.slice(1);
                            row.querySelector('.responden-fullname').textContent = updatedData.fullname;
                            row.querySelector('.responden-jabatan').textContent = updatedData.jabatan;
                            row.querySelector('.responden-instansi').textContent = updatedData.instansi;
                            row.querySelector('.responden-email').textContent = updatedData.email;
                            row.querySelector('.responden-phone_responden').textContent = updatedData.phone_responden;
                            row.querySelector('.responden-nama_dosen_pengusul').textContent = updatedData.nama_dosen_pengusul;
                            row.querySelector('.responden-phone_dosen').textContent = updatedData.phone_dosen;
                            row.querySelector('.responden-fakultas').textContent = updatedData.fakultas.toUpperCase();
                            row.querySelector('.responden-category').textContent = updatedData.category;
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: error.response?.data?.message || 'Terjadi kesalahan saat memperbarui data.',
                        });
                        console.error('Error updating responden:', error);
                    });
            });

            // Handle Delete button click
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const respondenId = this.dataset.id;
                    const url = `/${routePrefix}/responden/${respondenId}`;

                    Swal.fire({
                        title: 'Anda yakin?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                           axios.post(url, {
                                    _method: 'delete', // The magic ingredient for method spoofing
                                    _token: csrfToken // Send the CSRF token in the data
                                })
                                .then(response => {
                                    Swal.fire(
                                        'Dihapus!',
                                        'Data responden berhasil dihapus.',
                                        'success'
                                    );
                                    document.getElementById(`responden-row-${respondenId}`).remove();
                                })
                                .catch(error => {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal!',
                                        text: error.response?.data?.message || 'Terjadi kesalahan saat menghapus data.',
                                    });
                                    console.error('Error deleting responden:', error);
                                });
                        }
                    });
                });
            });

        // Import form submission
        document.getElementById('importForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            axios.post(this.action, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Accept': 'application/json' 
                }
            })
            .then(response => {
                const importModal = bootstrap.Modal.getInstance(document.getElementById('importModal'));
                importModal.hide();
                Swal.fire({
                    icon: 'success',
                    title: 'Import Selesai!',
                    html: response.data.message, 
                }).then(() => {
                    window.location.reload();
                });
            })
            .catch(error => {
                let errorMessage = 'Terjadi kesalahan tidak diketahui.';
                if (error.response && error.response.data && error.response.data.message) {
                    errorMessage = error.response.data.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Import Gagal',
                    html: errorMessage,
                });
            });
        });

    }); 
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            document.getElementById('exportFilteredExcel').addEventListener('click', function() {
                const category = document.getElementById('exportFilterCategory').value;
                const fakultas = document.getElementById('exportFilterFakultas').value;
                const status = document.getElementById('exportFilterStatus').value;
                const startDate = document.getElementById('exportStartDate').value;
                const endDate = document.getElementById('exportEndDate').value;
                
                let url = '{{ route("prodis.responden.export.excel") }}?';
                const params = [];
                if (category) params.push(`kategori=${encodeURIComponent(category)}`);
                if (fakultas) params.push(`fakultas=${encodeURIComponent(fakultas)}`);
                if (status) params.push(`status=${encodeURIComponent(status)}`);
                if (startDate) params.push(`start_date=${encodeURIComponent(startDate)}`);
                if (endDate) params.push(`end_date=${encodeURIComponent(endDate)}`);
                url += params.join('&');
                
                window.location.href = url;
            });

            // Handle CSV Export
            document.getElementById('exportFilteredCSV').addEventListener('click', function() {
                const category = document.getElementById('exportFilterCategory').value;
                const fakultas = document.getElementById('exportFilterFakultas').value;
                const status = document.getElementById('exportFilterStatus').value;
                const startDate = document.getElementById('exportStartDate').value;
                const endDate = document.getElementById('exportEndDate').value;
                
                let url = '{{ route("prodis.responden.export.csv") }}?';
                const params = [];
                if (category) params.push(`kategori=${encodeURIComponent(category)}`);
                if (fakultas) params.push(`fakultas=${encodeURIComponent(fakultas)}`);
                if (status) params.push(`status=${encodeURIComponent(status)}`);
                if (startDate) params.push(`start_date=${encodeURIComponent(startDate)}`);
                if (endDate) params.push(`end_date=${encodeURIComponent(endDate)}`);
                url += params.join('&');
                
                window.location.href = url;
            });
        });
    </script>

    <style>
        .badge-status {
            display: inline-flex;
            align-items: center;
            padding: 0.3em 0.6em;
            font-size: 0.85em;
            font-weight: 600;
            border-radius: 0.375rem;
            white-space: nowrap;
        }

        .badge-status i {
            margin-right: 5px;
            font-size: 1.1em;
            vertical-align: middle;
        }

        .badge-status.pending {
            background-color: #ffc107; /* Warning yellow */
            color: #000;
        }

        .badge-status.emailed {
            background-color: #0d6efd; /* Primary blue */
            color: #fff;
        }

        .badge-status.followed-up {
            background-color: #0dcaf0; /* Info cyan */
            color: #000;
        }

        .badge-status.completed {
            background-color: #198754; /* Success green */
            color: #fff;
        }
        
        .badge-status.default {
            background-color: #6c757d; /* Secondary gray */
            color: #fff;
        }
    </style>
@endsection

