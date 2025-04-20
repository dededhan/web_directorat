@extends('admin_pemeringkatan.index')


<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/sustainability_dashboard.css') }}">

@section('contentadmin_pemeringkatan')
    <div class="head-title">
        <div class="left">
            <h1>Sustainability</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Input Kegiatan Sustainability</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Kegiatan Sustainability</h3>
            </div> 

            <form id="sustainability-form" method="POST" action="{{ route('admin.sustainability.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="judul_kegiatan" class="form-label">Judul Kegiatan</label>
                        <input type="text" class="form-control" name="judul_kegiatan" id="judul_kegiatan">
                        <div class="form-text text-muted">Masukkan judul kegiatan sustainability yang dilaksanakan</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_kegiatan" class="form-label">Tanggal Kegiatan</label>
                        <input type="date" class="form-control" name="tanggal_kegiatan" id="tanggal_kegiatan">
                        <div class="form-text text-muted">Pilih tanggal pelaksanaan kegiatan</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fakultas" class="form-label">Fakultas</label>
                        <select class="form-select" name="fakultas" id="fakultas">
                            <option value="">Pilih Fakultas</option>
                            <option value="pascasarjana">PASCASARJANA</option>
                            <option value="fip">FIP</option>
                            <option value="fmipa">FMIPA</option>
                            <option value="fppsi">FPPsi</option>
                            <option value="fbs">FBS</option>
                            <option value="ft">FT</option>
                            <option value="fik">FIK</option>
                            <option value="fis">FIS</option>
                            <option value="fe">FE</option>
                            <option value="profesi">PROFESI</option>
                        </select>
                        <div class="form-text text-muted">Pilih fakultas penyelenggara kegiatan</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select" name="prodi" id="prodi" disabled>
                            <option value="">Pilih Program Studi</option>
                        </select>
                        <div class="form-text text-muted">Pilih program studi terkait kegiatan</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="link_kegiatan" class="form-label">Link Kegiatan</label>
                        <input type="url" class="form-control" name="link_kegiatan" id="link_kegiatan">
                        <div class="form-text text-muted">Masukkan link dokumentasi kegiatan (YouTube/Media Sosial/Google Drive)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="foto_kegiatan" class="form-label">Foto-foto Kegiatan</label>
                        <input type="file" class="form-control" name="foto_kegiatan" id="foto_kegiatan" multiple accept="image/*">
                        <div class="form-text text-muted">Upload foto-foto dokumentasi kegiatan (format: JPG, PNG, atau JPEG)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi_kegiatan" class="form-label">Deskripsi Kegiatan</label>
                        <textarea class="form-control" name="deskripsi_kegiatan" id="deskripsi_kegiatan" rows="4"></textarea>
                        <div class="form-text text-muted">Tuliskan deskripsi lengkap mengenai kegiatan yang dilaksanakan</div>
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
                    <h3>Daftar Kegiatan Sustainability</h3>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="sustainability-table">
                        <thead>
                            <tr>
                                <th>Judul Kegiatan</th>
                                <th>Tanggal</th>
                                <th>Fakultas</th>
                                <th>Program Studi</th>
                                <th>Link</th>
                                <th>Foto</th>
                                <th>Deskripsi</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sustainability-list">
                            @foreach($sustainabilities as $activity)
                            <tr>
                                <td>{{ $activity->judul_kegiatan }}</td>
                                <td>{{ $activity->tanggal_kegiatan}}</td>
                                <td>{{ strtoupper($activity->fakultas) }}</td>
                                <td>{{ $activity->prodi }}</td>
                                <td>
                                    @if($activity->link_kegiatan)
                                    <a href="{{ $activity->link_kegiatan }}" target="_blank">View Link</a>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info view-photos" 
                                        data-photos='@json($activity->photos->pluck('path'))'>
                                        View Photos ({{ $activity->photos->count() }})
                                    </button>
                                </td>
                                <td>{{ Str::limit($activity->deskripsi_kegiatan, 50) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-warning edit-activity" 
                                                data-id="{{ $activity->id }}"
                                                data-judul="{{ $activity->judul_kegiatan }}"
                                                data-tanggal="{{ $activity->tanggal_kegiatan->format('Y-m-d') }}"
                                                data-fakultas="{{ $activity->fakultas }}"
                                                data-prodi="{{ $activity->prodi }}"
                                                data-link="{{ $activity->link_kegiatan }}"
                                                data-deskripsi="{{ $activity->deskripsi_kegiatan }}">
                                            Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-activity" data-id="{{ $activity->id }}" data-judul="{{ $activity->judul_kegiatan }}">
                                            Delete
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
    </div>

    <!-- Photo Modal -->
    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="photoModalLabel">Foto Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="photoGallery">
                    <!-- Foto akan ditampilkan di sini -->
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Kegiatan Sustainability</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_judul_kegiatan" class="form-label">Judul Kegiatan</label>
                                <input type="text" class="form-control" name="judul_kegiatan" id="edit_judul_kegiatan">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_tanggal_kegiatan" class="form-label">Tanggal Kegiatan</label>
                                <input type="date" class="form-control" name="tanggal_kegiatan" id="edit_tanggal_kegiatan">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_fakultas" class="form-label">Fakultas</label>
                                <select class="form-select" name="fakultas" id="edit_fakultas">
                                    <option value="">Pilih Fakultas</option>
                                    <option value="pascasarjana">PASCASARJANA</option>
                                    <option value="fip">FIP</option>
                                    <option value="fmipa">FMIPA</option>
                                    <option value="fppsi">FPPsi</option>
                                    <option value="fbs">FBS</option>
                                    <option value="ft">FT</option>
                                    <option value="fik">FIK</option>
                                    <option value="fis">FIS</option>
                                    <option value="fe">FE</option>
                                    <option value="profesi">PROFESI</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_prodi" class="form-label">Program Studi</label>
                                <select class="form-select" name="prodi" id="edit_prodi">
                                    <option value="">Pilih Program Studi</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_link_kegiatan" class="form-label">Link Kegiatan</label>
                                <input type="url" class="form-control" name="link_kegiatan" id="edit_link_kegiatan">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_foto_kegiatan" class="form-label">Foto-foto Kegiatan (Opsional)</label>
                                <input type="file" class="form-control" name="foto_kegiatan" id="edit_foto_kegiatan" accept="image/*">
                                <div class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah foto</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_deskripsi_kegiatan" class="form-label">Deskripsi Kegiatan</label>
                                <textarea class="form-control" name="deskripsi_kegiatan" id="edit_deskripsi_kegiatan" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Form -->
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- Include jQuery if not already included -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Include Bootstrap JS and SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Load sustainability_dashboard.js for fakultas & prodi dropdown logic -->
    <script src="{{ asset('dashboard_main/dashboard/sustainability_dashboard.js') }}"></script>
    
    <script>
        // Handle edit button clicks
    
        
        // Display SweetAlert for flash messages
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 2000
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    timer: 2000
                });
            @endif
        });
    </script>
@endsection