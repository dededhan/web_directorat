@extends('fakultas.index')
<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/sustainability_dashboard.css') }}">
@section('contentfakultas')
    <div class="head-title">
        <div class="left">
            <h1>Sustainability</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('fakultas.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Input Kegiatan Sustainability</a>
                </li>
            </ul>
        </div>
    </div>

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

            {{-- Corrected form action for fakultas store route --}}
            <form id="sustainability-form" method="POST" action="{{ route('fakultas.sustainability.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="judul_kegiatan" class="form-label">Judul Kegiatan</label>
                        <input type="text" class="form-control @error('judul_kegiatan') is-invalid @enderror" name="judul_kegiatan" id="judul_kegiatan" value="{{ old('judul_kegiatan') }}">
                        @error('judul_kegiatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Masukkan judul kegiatan sustainability yang dilaksanakan</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_kegiatan" class="form-label">Tanggal Kegiatan</label>
                        <input type="date" class="form-control @error('tanggal_kegiatan') is-invalid @enderror" name="tanggal_kegiatan" id="tanggal_kegiatan" value="{{ old('tanggal_kegiatan') }}">
                        @error('tanggal_kegiatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Pilih tanggal pelaksanaan kegiatan</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fakultas" class="form-label">Fakultas</label>
                        {{-- Fakultas field is pre-filled and disabled for faculty users --}}
                        <input type="text" class="form-control" id="fakultas_display" value="{{ strtoupper(Auth::user()->name) }}" disabled>
                        <input type="hidden" name="fakultas" id="fakultas" value="{{ $user_info['faculty_code'] ?? '' }}">
                        @error('fakultas') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Fakultas penyelenggara kegiatan (otomatis terisi).</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select @error('prodi') is-invalid @enderror" name="prodi" id="prodi">
                            <option value="">-- Fakultas Level (Tanpa Prodi) --</option>
                            @if(isset($prodi_list_for_fakultas) && !empty($prodi_list_for_fakultas))
                                @foreach($prodi_list_for_fakultas as $prodi_item)
                                    <option value="{{ $prodi_item }}" {{ old('prodi') == $prodi_item ? 'selected' : '' }}>{{ $prodi_item }}</option>
                                @endforeach
                            @else
                                <option value="" disabled>Tidak ada program studi ditemukan untuk fakultas Anda.</option>
                            @endif
                        </select>
                        @error('prodi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Pilih program studi terkait (opsional, untuk kegiatan level fakultas biarkan kosong).</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="link_kegiatan" class="form-label">Link Kegiatan</label>
                        <input type="url" class="form-control @error('link_kegiatan') is-invalid @enderror" name="link_kegiatan" id="link_kegiatan" value="{{ old('link_kegiatan') }}">
                        @error('link_kegiatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Masukkan link dokumentasi kegiatan (YouTube/Media Sosial/Google Drive)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="foto_kegiatan" class="form-label">Foto-foto Kegiatan</label>
                        {{-- Changed name to foto_kegiatan[] for multiple file uploads --}}
                        <input type="file" class="form-control @error('foto_kegiatan') is-invalid @enderror @error('foto_kegiatan.*') is-invalid @enderror" name="foto_kegiatan[]" id="foto_kegiatan" multiple accept="image/*">
                        @error('foto_kegiatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @error('foto_kegiatan.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Upload foto-foto dokumentasi kegiatan (format: JPG, PNG, WEBP, JPEG, max 2MB per foto).</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi_kegiatan" class="form-label">Deskripsi Kegiatan</label>
                        <textarea class="form-control @error('deskripsi_kegiatan') is-invalid @enderror" name="deskripsi_kegiatan" id="deskripsi_kegiatan" rows="4">{{ old('deskripsi_kegiatan') }}</textarea>
                        @error('deskripsi_kegiatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                            @forelse($sustainabilities as $activity)
                            <tr>
                                <td>{{ $activity->judul_kegiatan }}</td>
                                <td>{{ \Carbon\Carbon::parse($activity->tanggal_kegiatan)->format('d M Y') }}</td>
                                <td>{{ strtoupper($activity->fakultas) }}</td>
                                <td>{{ $activity->prodi ?? 'N/A (Fakultas Level)' }}</td>
                                <td>
                                    @if($activity->link_kegiatan)
                                    <a href="{{ $activity->link_kegiatan }}" target="_blank" class="btn btn-sm btn-outline-info">View Link</a>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    @if($activity->photos && $activity->photos->count() > 0)
                                    <button class="btn btn-sm btn-info view-photos" 
                                        data-photos='@json($activity->photos->pluck("path"))'
                                        data-bs-toggle="modal" data-bs-target="#photoModal">
                                        View Photos ({{ $activity->photos->count() }})
                                    </button>
                                    @else
                                    No Photos
                                    @endif
                                </td>
                                <td>{{ Str::limit($activity->deskripsi_kegiatan, 50) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-warning edit-activity" 
                                                data-id="{{ $activity->id }}"
                                                data-bs-toggle="modal" data-bs-target="#editModal">
                                            Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-activity" data-id="{{ $activity->id }}" data-judul="{{ $activity->judul_kegiatan }}">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Belum ada data kegiatan sustainability.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($sustainabilities->hasPages())
                    <div class="mt-3">
                        {{ $sustainabilities->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="photoModalLabel">Foto Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="photoGallery" style="max-height: 70vh; overflow-y: auto;">
                    {{-- Photos will be displayed here by JavaScript --}}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Kegiatan Sustainability</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- Form action will be set by JavaScript --}}
                <form id="edit-form" method="POST" enctype="multipart/form-data"> 
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit_activity_id" name="activity_id">
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
                                <label for="edit_fakultas_display" class="form-label">Fakultas</label>
                                {{-- Fakultas field is pre-filled and disabled --}}
                                <input type="text" class="form-control" id="edit_fakultas_display" value="{{ strtoupper(Auth::user()->name) }}" disabled>
                                <input type="hidden" name="fakultas" id="edit_fakultas" value="{{ $user_info['faculty_code'] ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_prodi" class="form-label">Program Studi</label>
                                <select class="form-select" name="prodi" id="edit_prodi">
                                    <option value="">-- Fakultas Level (Tanpa Prodi) --</option>
                                    @if(isset($prodi_list_for_fakultas) && !empty($prodi_list_for_fakultas))
                                        @foreach($prodi_list_for_fakultas as $prodi_item)
                                            <option value="{{ $prodi_item }}">{{ $prodi_item }}</option>
                                        @endforeach
                                    @endif
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
                                <label for="edit_foto_kegiatan" class="form-label">Tambah Foto Kegiatan (Opsional)</label>
                                {{-- Changed name to foto_kegiatan[] for multiple file uploads --}}
                                <input type="file" class="form-control" name="foto_kegiatan[]" id="edit_foto_kegiatan" multiple accept="image/*">
                                <div class="form-text text-muted">Upload foto baru jika ingin menambah. Foto lama tidak akan dihapus otomatis. Biarkan kosong jika tidak ingin menambah foto.</div>
                                <div id="edit_current_photos" class="mt-2">
                                    <p>Foto saat ini:</p>
                                    {{-- Current photos will be listed here by JavaScript --}}
                                </div>
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

    {{-- Delete Form (action set by JavaScript) --}}
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    {{-- Include jQuery if not already included, or ensure it's loaded in fakultas.index --}}
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    {{-- Bootstrap JS and SweetAlert2 should also be loaded, possibly in fakultas.index --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    
    {{-- Remove or ensure sustainability_dashboard.js does not conflict with the JS below --}}
    {{-- <script src="{{ asset('dashboard_main/dashboard/sustainability_dashboard.js') }}"></script> --}}
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // CSRF Token for AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // Handle View Photos button
        document.querySelectorAll('.view-photos').forEach(button => {
            button.addEventListener('click', function() {
                const photos = JSON.parse(this.dataset.photos);
                const gallery = document.getElementById('photoGallery');
                gallery.innerHTML = ''; // Clear previous photos

                if (photos && photos.length > 0) {
                    photos.forEach(path => {
                        const img = document.createElement('img');
                        // Assuming 'storage/' prefix is needed if paths are like 'sustainability/image.jpg'
                        img.src = `/storage/${path}`; 
                        img.classList.add('img-fluid', 'mb-3', 'rounded');
                        img.style.maxHeight = '400px'; // Adjust as needed
                        img.style.objectFit = 'contain';
                        gallery.appendChild(img);
                    });
                } else {
                    gallery.innerHTML = '<p>Tidak ada foto untuk ditampilkan.</p>';
                }
                // Modal is toggled by data-bs-toggle attributes, no need to call .show() here unless those are removed
            });
        });

        // Handle Edit button clicks
        document.querySelectorAll('.edit-activity').forEach(button => {
            button.addEventListener('click', function() {
                const activityId = this.dataset.id;
                
                // Set the form action for the edit modal
                const editForm = document.getElementById('edit-form');
                editForm.action = `{{ url('fakultas/sustainability') }}/${activityId}`; // Correct route for update

                // Fetch activity data
                fetch(`{{ url('fakultas/sustainability') }}/${activityId}/detail`, { // Correct route for detail
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken 
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('edit_activity_id').value = data.id;
                    document.getElementById('edit_judul_kegiatan').value = data.judul_kegiatan;
                    // Format date correctly for input type="date" which expects YYYY-MM-DD
                    if (data.tanggal_kegiatan) {
                        document.getElementById('edit_tanggal_kegiatan').value = data.tanggal_kegiatan.split('T')[0];
                    }
                    // Fakultas is already set and disabled based on logged-in user
                    // document.getElementById('edit_fakultas').value = data.fakultas; // This is now a hidden input
                    
                    // Pre-select prodi
                    const editProdiSelect = document.getElementById('edit_prodi');
                    if (data.prodi) {
                        editProdiSelect.value = data.prodi;
                    } else {
                        editProdiSelect.value = ""; // For "Fakultas Level"
                    }

                    document.getElementById('edit_link_kegiatan').value = data.link_kegiatan || '';
                    document.getElementById('edit_deskripsi_kegiatan').value = data.deskripsi_kegiatan;

                    // Display current photos in edit modal
                    const currentPhotosDiv = document.getElementById('edit_current_photos');
                    currentPhotosDiv.innerHTML = '<p>Foto saat ini:</p>';
                    if (data.photos && data.photos.length > 0) {
                        data.photos.forEach(photo => {
                            const imgContainer = document.createElement('div');
                            imgContainer.classList.add('mb-2', 'd-inline-block', 'position-relative');
                            const img = document.createElement('img');
                            img.src = `/storage/${photo.path}`;
                            img.classList.add('img-thumbnail');
                            img.style.width = '100px';
                            img.style.height = '100px';
                            img.style.objectFit = 'cover';
                            imgContainer.appendChild(img);
                            // Add delete button for individual photos if needed (more complex, requires separate route/logic)
                            currentPhotosDiv.appendChild(imgContainer);
                        });
                    } else {
                        currentPhotosDiv.innerHTML += '<p><em>Tidak ada foto terunggah.</em></p>';
                    }
                    // Modal is toggled by data-bs-toggle attributes
                })
                .catch(error => {
                    console.error('Error fetching activity details:', error);
                    Swal.fire('Error', 'Gagal mengambil detail kegiatan. ' + error.message, 'error');
                });
            });
        });

        // Handle Delete button clicks
        document.querySelectorAll('.delete-activity').forEach(button => {
            button.addEventListener('click', function() {
                const activityId = this.dataset.id;
                const activityJudul = this.dataset.judul;
                const deleteForm = document.getElementById('delete-form');
                deleteForm.action = `{{ url('fakultas/sustainability') }}/${activityId}`; // Correct route for delete

                Swal.fire({
                    title: 'Anda Yakin?',
                    text: `Apakah Anda ingin menghapus kegiatan "${activityJudul}"? Tindakan ini tidak dapat dibatalkan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteForm.submit();
                    }
                });
            });
        });
        
        // Display SweetAlert for flash messages from session
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        // Clear file input after form submission (optional, for better UX)
        const sustainabilityForm = document.getElementById('sustainability-form');
        if (sustainabilityForm) {
            sustainabilityForm.addEventListener('submit', function() {
                // Optional: disable submit button to prevent multiple submissions
                // this.querySelector('button[type="submit"]').disabled = true;
                // No need to reset file input here, server-side redirect will reload the page
            });
        }
    });
    </script>
@endsection
