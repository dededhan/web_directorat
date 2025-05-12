@extends('admin.admin')

<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/matakuliah_dashboard.css') }}">

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>International Faculty Staff Profile</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">International Faculty Staff</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input International Faculty Staff</h3>
            </div> 

            <form id="faculty-staff-form" action="{{ route('admin.international_faculty_staff.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama" id="nama">
                        <div class="form-text text-muted">Masukkan nama lengkap staf/dosen internasional</div>
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
                            <option value="fppsi">FPsi</option>
                            <option value="fbs">FBS</option>
                            <option value="ft">FT</option>
                            <option value="fik">FIKK</option>
                            <option value="fis">FISH</option>
                            <option value="fe">FEB</option>
                            <option value="profesi">PROFESI</option>
                        </select>
                        <div class="form-text text-muted">Pilih fakultas tempat dosen/staf internasional bekerja</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="universitas_asal" class="form-label">Universitas Asal</label>
                        <input type="text" class="form-control" name="universitas_asal" id="universitas_asal">
                        <div class="form-text text-muted">Masukkan nama universitas asal</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="bidang_keahlian" class="form-label">Bidang Keahlian</label>
                        <input type="text" class="form-control" name="bidang_keahlian" id="bidang_keahlian">
                        <div class="form-text text-muted">Masukkan bidang keahlian dosen/staf internasional</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" name="category" id="category">
                            <option value="">Pilih Category</option>
                            <option value="fulltime">Full Time</option>
                            <option value="adjunct">Adjunct</option>
                        </select>
                        <div class="form-text text-muted">Pilih category dosen/staf (full time atau adjunct)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="qs_wur" class="form-label">QS WUR (Optional)</label>
                        <input type="text" class="form-control" name="qs_wur" id="qs_wur">
                        <div class="form-text text-muted">Masukkan data QS World University Rankings (opsional)</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="qs_subject" class="form-label">QS Subject (Optional)</label>
                        <input type="text" class="form-control" name="qs_subject" id="qs_subject">
                        <div class="form-text text-muted">Masukkan data QS Subject (opsional)</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="scopus" class="form-label">Scopus (Optional)</label>
                        <input type="text" class="form-control" name="scopus" id="scopus">
                        <div class="form-text text-muted">Masukkan data Scopus (opsional)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" class="form-control" name="foto" id="foto" accept=".jpg,.jpeg,.png,.gif">
                        <div class="form-text text-muted">Upload foto dengan format JPG, JPEG, PNG, atau GIF (maks 2MB)</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input type="number" class="form-control" name="tahun" id="tahun" min="1900" max="{{ date('Y')+1 }}">
                        <div class="form-text text-muted">Masukkan tahun (contoh: 2023)</div>
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
                    <h3>Daftar International Faculty Staff</h3>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="staff-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Fakultas</th>
                                <th>Universitas Asal</th>
                                <th>Bidang Keahlian</th>
                                <th>Category</th>
                                <th>Foto</th>
                                <th>Tahun</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="staff-list">
                            @foreach($facultyStaffs as $staff)
                                <tr>
                                    <td>{{ $staff->nama }}</td>
                                    <td>{{ ucfirst($staff->fakultas) }}</td>
                                    <td>{{ $staff->universitas_asal }}</td>
                                    <td>{{ $staff->bidang_keahlian }}</td>
                                    <td>{{ ucfirst($staff->category) }}</td>
                                    <td>
                                        @if($staff->foto_path)
                                            <img src="{{ Storage::url($staff->foto_path) }}" alt="{{ $staff->nama }}" class="img-thumbnail" style="max-width: 100px;">
                                        @else
                                            <span class="text-muted">No Photo</span>
                                        @endif
                                    </td>
                                    <td>{{ $staff->tahun }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-warning edit-staff" 
                                                    data-id="{{ $staff->id }}"
                                                    data-nama="{{ $staff->nama }}"
                                                    data-fakultas="{{ $staff->fakultas }}"
                                                    data-universitas_asal="{{ $staff->universitas_asal }}"
                                                    data-bidang_keahlian="{{ $staff->bidang_keahlian }}"
                                                    data-category="{{ $staff->category }}"
                                                    data-qs_wur="{{ $staff->qs_wur }}"
                                                    data-qs_subject="{{ $staff->qs_subject }}"
                                                    data-scopus="{{ $staff->scopus }}"
                                                    data-tahun="{{ $staff->tahun }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.international_faculty_staff.destroy', $staff->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger delete-staff">
                                                    Delete
                                                </button>
                                            </form>
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

    <!-- Edit Modal -->
    <div class="modal fade" id="editStaffModal" tabindex="-1" role="dialog" aria-labelledby="editStaffModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStaffModalLabel">Edit International Faculty Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit-staff-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama" id="edit_nama">
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
                                <label for="edit_universitas_asal" class="form-label">Universitas Asal</label>
                                <input type="text" class="form-control" name="universitas_asal" id="edit_universitas_asal">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_bidang_keahlian" class="form-label">Bidang Keahlian</label>
                                <input type="text" class="form-control" name="bidang_keahlian" id="edit_bidang_keahlian">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_category" class="form-label">Category</label>
                                <select class="form-select" name="category" id="edit_category">
                                    <option value="">Pilih Category</option>
                                    <option value="fulltime">Full Time</option>
                                    <option value="adjunct">Adjunct</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="edit_qs_wur" class="form-label">QS WUR (Optional)</label>
                                <input type="text" class="form-control" name="qs_wur" id="edit_qs_wur">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_qs_subject" class="form-label">QS Subject (Optional)</label>
                                <input type="text" class="form-control" name="qs_subject" id="edit_qs_subject">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_scopus" class="form-label">Scopus (Optional)</label>
                                <input type="text" class="form-control" name="scopus" id="edit_scopus">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_foto" class="form-label">Foto (Opsional)</label>
                                <input type="file" class="form-control" name="foto" id="edit_foto" accept=".jpg,.jpeg,.png,.gif">
                                <div class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah foto</div>
                                <div id="current-photo-container" class="mt-2">
                                    <!-- Current photo will be displayed here -->
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_tahun" class="form-label">Tahun</label>
                                <input type="number" class="form-control" name="tahun" id="edit_tahun" min="1900" max="{{ date('Y')+1 }}">
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

    <!-- Include jQuery if not already included -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
    // Handle edit button
    document.querySelectorAll('.edit-staff').forEach(button => {
        button.addEventListener('click', function() {
            const staffId = this.dataset.id;
            const modal = new bootstrap.Modal(document.getElementById('editStaffModal'));
            
            // Populate form data
            document.getElementById('edit_nama').value = this.dataset.nama;
            document.getElementById('edit_fakultas').value = this.dataset.fakultas;
            document.getElementById('edit_universitas_asal').value = this.dataset.universitas_asal;
            document.getElementById('edit_bidang_keahlian').value = this.dataset.bidang_keahlian;
            document.getElementById('edit_category').value = this.dataset.category;
            document.getElementById('edit_qs_wur').value = this.dataset.qs_wur;
            document.getElementById('edit_qs_subject').value = this.dataset.qs_subject;
            document.getElementById('edit_scopus').value = this.dataset.scopus;
            document.getElementById('edit_tahun').value = this.dataset.tahun;
            
            // Get staff detail to display the current photo
            fetch(`/admin/international_faculty_staff/${staffId}/detail`)
                .then(response => response.json())
                .then(data => {
                    const photoContainer = document.getElementById('current-photo-container');
                    if (data.foto_path) {
                        photoContainer.innerHTML = `
                            <p>Current Photo:</p>
                            <img src="/storage/${data.foto_path}" alt="${data.nama}" class="img-thumbnail" style="max-width: 150px;">
                        `;
                    } else {
                        photoContainer.innerHTML = `<p>No current photo</p>`;
                    }
                });
            
            // Set form action
            document.getElementById('edit-staff-form').action = `/admin/international_faculty_staff/${staffId}`;
            
            // Show modal
            modal.show();
        });
    });

    // Handle delete confirmation
    document.querySelectorAll('.delete-staff').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

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