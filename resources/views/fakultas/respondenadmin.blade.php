@extends('fakultas.index')
@vite(['resources/css/admin/responden_dashboard.css'])

@section('contentfakultas')
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
                    <a href="{{ route('fakultas.dashboard') }}">Dashboard</a>
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

            <form id="survey-form" method="POST" action="{{ route('fakultas.responden.store') }}">
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
                            <option value="fikk">FIKK</option>
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
                        <form method="GET" action="{{ route('fakultas.responden.index') }}" class="me-3 w-100">
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
                                        <option value="employer" {{ request('kategori') == 'employer' ? 'selected' : '' }}>
                                            Employer</option>
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
                                    <a href="{{ route('fakultas.responden.index') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>

                        </form>
                        <div class="export-buttons me-3">
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#importModal">
                                    <i class='bx bx-import'></i> Import Excel
                                </button>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#exportFilterModal">
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
                                <th>User ID</th>
                                <th>Title</th>
                                <th>Nama Lengkap</th>
                                <th>Jabatan</th>
                                <th>Instansi</th>
                                <th>Email</th>
                                <th>No. Responden</th>
                                <th>Nama Dosen</th>
                                <th>No. Narahubung</th>
                                <th>
                                    <a
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'fakultas', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                        Fakultas
                                        @if (request('sort') == 'fakultas')
                                            {!! request('direction') == 'asc' ? '↑' : '↓' !!}
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'category', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                        Category
                                        @if (request('sort') == 'category')
                                            {!! request('direction') == 'asc' ? '↑' : '↓' !!}
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                        Tanggal Dibuat
                                        @if (request('sort') == 'created_at')
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
                                    <td>{{ $responden->user->name ?? 'N/A' }}</td>
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
                                    <td>{{ $responden->created_at?->format('d M Y H:i') ?? 'N/A' }}</td>
                                    <td>
                                        <span class="status {{ strtolower($responden->status) }}">{{ $responden->status }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-warning btn-sm edit-btn"
                                                data-id="{{ $responden->id }}" data-bs-toggle="modal"
                                                data-bs-target="#editRespondenModal">
                                                <i class='bx bxs-edit'></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                data-id="{{ $responden->id }}">
                                                <i class='bx bxs-trash'></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="15" class="text-center">Data Belum Ada</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            @if ($respondens->total() > 0)
                                <span class="text-muted">
                                    Showing {{ $respondens->firstItem() }} to {{ $respondens->lastItem() }} of {{ $respondens->total() }} results
                                </span>
                            @else
                                 <span class="text-muted">No results found</span>
                            @endif
                        </div>
                          <div>
                           <div class="btn-group">
                                <a href="{{ $respondens->appends(request()->query())->previousPageUrl() }}" class="btn btn-outline-primary @if($respondens->onFirstPage()) disabled @endif">
                                    &laquo; Previous
                                </a>
                                <a href="{{ $respondens->appends(request()->query())->nextPageUrl() }}" class="btn btn-outline-primary @if(!$respondens->hasMorePages()) disabled @endif">
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
    <div class="modal fade" id="editRespondenModal" tabindex="-1" aria-labelledby="editRespondenModalLabel"
        aria-hidden="true">
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
                                <input type="text" class="form-control" name="phone_responden"
                                    id="edit_phone_responden">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_nama_dosen_pengusul" class="form-label">Nama Dosen</label>
                                <input type="text" class="form-control" name="nama_dosen_pengusul"
                                    id="edit_nama_dosen_pengusul" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_phone_dosen" class="form-label">Nomor Narahubung</label>
                                <input type="text" class="form-control" name="phone_dosen" id="edit_phone_dosen"
                                    required>
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
                <form id="importForm" action="{{ route('fakultas.responden.import') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="excelFile" class="form-label">Select Excel File</label>
                            <input class="form-control" type="file" id="excelFile" name="file"
                                accept=".xlsx,.xls" required>
                            <div class="form-text">File harus sesuai dengan format yang ditentukan</div>
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
    <div class="modal fade pt-3" id="exportFilterModal" tabindex="-1" aria-labelledby="exportFilterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog pt-3">
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
        document.addEventListener('DOMContentLoaded', function() {
            const perPageFilter = document.getElementById('perPageFilter');
            if (perPageFilter) {
                perPageFilter.addEventListener('change', function() {
                    this.form.submit();
                });
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const routePrefix = "fakultas";

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
                        .catch(error => console.error('Error fetching data:', error));
                });
            });

            document.getElementById('edit-survey-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const form = e.target;
                axios.post(form.action, new FormData(form))
                    .then(response => {
                        bootstrap.Modal.getInstance(document.getElementById('editRespondenModal')).hide();
                        Swal.fire('Success', response.data.message, 'success')
                            .then(() => window.location.reload());
                    })
                    .catch(error => Swal.fire('Error', error.response.data.message, 'error'));
            });

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
                        confirmButtonText: 'Ya, hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.post(url, { _method: 'DELETE', _token: csrfToken })
                                .then(response => {
                                    Swal.fire('Dihapus!', response.data.message, 'success');
                                    document.getElementById(`responden-row-${respondenId}`).remove();
                                })
                                .catch(error => Swal.fire('Gagal!', error.response.data.message, 'error'));
                        }
                    });
                });
            });
            document.getElementById('exportFilteredExcel').addEventListener('click', function() {
                const category = document.getElementById('exportFilterCategory').value;
                 const fakultas = document.getElementById('exportFilterFakultas').value;
                const startDate = document.getElementById('exportStartDate').value;
                const endDate = document.getElementById('exportEndDate').value;

                let url = '{{ route("fakultas.responden.export") }}?';
                const params = [];
                if (category) params.push(`kategori=${encodeURIComponent(category)}`);
                if (fakultas) params.push(`fakultas=${encodeURIComponent(fakultas)}`);
                if (startDate) params.push(`start_date=${encodeURIComponent(startDate)}`);
                if (endDate) params.push(`end_date=${encodeURIComponent(endDate)}`);
                
                url += params.join('&');
                window.location.href = url;
            });

            document.getElementById('exportFilteredCSV').addEventListener('click', function() {
                const category = document.getElementById('exportFilterCategory').value;
                const fakultas = document.getElementById('exportFilterFakultas').value;
                const startDate = document.getElementById('exportStartDate').value;
                const endDate = document.getElementById('exportEndDate').value;

                let url = '{{ route("fakultas.responden.exportCSV") }}?';
                const params = [];
                if (category) params.push(`kategori=${encodeURIComponent(category)}`);
                if (fakultas) params.push(`fakultas=${encodeURIComponent(fakultas)}`); 
                if (startDate) params.push(`start_date=${encodeURIComponent(startDate)}`);
                if (endDate) params.push(`end_date=${encodeURIComponent(endDate)}`);

                url += params.join('&');
                window.location.href = url;
            });
        });
    </script>
@endsection
