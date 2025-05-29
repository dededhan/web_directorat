@extends('admin.admin')

<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/sustainability_dashboard.css') }}">

@section('contentadmin')
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

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
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

            <form id="sustainability-form" method="POST" action="{{ route('admin.sustainability.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="edit_sdg_goal" class="form-label">Kelompok Kategori</label>
                        <select class="form-select" name="sdg_goal" id="edit_sdg_goal">
                            <option value="">Pilih Kelompok Kategori</option>
                            @php
                                // Fallback if $sdgDetailsList is not passed from controller,
                                // but passing from controller is preferred.
                                $sdgGoalsData = $sdgDetailsList ?? [
                                    1 => "Tanpa Kemiskinan",
                                    2 => "Tanpa Kelaparan",
                                    3 => "Kehidupan Sehat dan Sejahtera",
                                    4 => "Pendidikan Berkualitas",
                                    5 => "Kesetaraan Gender",
                                    6 => "Air Bersih dan Sanitasi Layak",
                                    7 => "Energi Bersih dan Terjangkau",
                                    8 => "Pekerjaan Layak dan Pertumbuhan Ekonomi",
                                    9 => "Industri, Inovasi, dan Infrastruktur",
                                    10 => "Berkurangnya Kesenjangan",
                                    11 => "Kota dan Pemukiman yang Berkelanjutan",
                                    12 => "Konsumsi dan Produksi yang Bertanggung Jawab",
                                    13 => "Penanganan Perubahan Iklim",
                                    14 => "Ekosistem Lautan",
                                    15 => "Ekosistem Daratan",
                                    16 => "Perdamaian, Keadilan, dan Kelembagaan yang Tangguh",
                                    17 => "Kemitraan untuk Mencapai Tujuan",
                                ];
                            @endphp
                            @foreach ($sdgGoalsData as $number => $description)
                                @php $optionValue = "SDG " . $number; @endphp
                                <option value="{{ $optionValue }}" {{ old('sdg_goal', $sustainability->sdg_goal ?? '') == $optionValue ? 'selected' : '' }}>
                                    SDGs {{ $number }}: {{ $description }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="judul_kegiatan" class="form-label">Judul Kegiatan</label>
                        <input type="text" class="form-control @error('judul_kegiatan') is-invalid @enderror"
                            name="judul_kegiatan" id="judul_kegiatan" value="{{ old('judul_kegiatan') }}">
                        @error('judul_kegiatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Masukkan judul kegiatan sustainability yang dilaksanakan</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_kegiatan" class="form-label">Tanggal Kegiatan</label>
                        <input type="date" class="form-control @error('tanggal_kegiatan') is-invalid @enderror"
                            name="tanggal_kegiatan" id="tanggal_kegiatan" value="{{ old('tanggal_kegiatan') }}">
                        @error('tanggal_kegiatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Pilih tanggal pelaksanaan kegiatan</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fakultas" class="form-label">Fakultas</label>
                        <select class="form-select @error('fakultas') is-invalid @enderror" name="fakultas" id="fakultas">
                            <option value="">Pilih Fakultas</option>
                            <option value="pascasarjana" {{ old('fakultas') == 'pascasarjana' ? 'selected' : '' }}>
                                PASCASARJANA</option>
                            <option value="fip" {{ old('fakultas') == 'fip' ? 'selected' : '' }}>FIP</option>
                            <option value="fmipa" {{ old('fakultas') == 'fmipa' ? 'selected' : '' }}>FMIPA</option>
                            <option value="fppsi" {{ old('fakultas') == 'fppsi' ? 'selected' : '' }}>FPsi</option>
                            <option value="fbs" {{ old('fakultas') == 'fbs' ? 'selected' : '' }}>FBS</option>
                            <option value="ft" {{ old('fakultas') == 'ft' ? 'selected' : '' }}>FT</option>
                            <option value="fik" {{ old('fakultas') == 'fik' ? 'selected' : '' }}>FIKK</option>
                            <option value="fis" {{ old('fakultas') == 'fis' ? 'selected' : '' }}>FISH</option>
                            <option value="fe" {{ old('fakultas') == 'fe' ? 'selected' : '' }}>FEB</option>
                            <option value="profesi" {{ old('fakultas') == 'profesi' ? 'selected' : '' }}>PROFESI</option>
                        </select>
                        @error('fakultas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Pilih fakultas penyelenggara kegiatan</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select @error('prodi') is-invalid @enderror" name="prodi" id="prodi"
                            disabled>
                            <option value="">Pilih Program Studi</option>
                            {{-- Options will be populated by sustainability_dashboard.js --}}
                        </select>
                        @error('prodi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Pilih program studi terkait kegiatan</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="link_kegiatan" class="form-label">Link Kegiatan</label>
                        <input type="url" class="form-control @error('link_kegiatan') is-invalid @enderror"
                            name="link_kegiatan" id="link_kegiatan" value="{{ old('link_kegiatan') }}">
                        @error('link_kegiatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Masukkan link dokumentasi kegiatan (YouTube/Media Sosial/Google
                            Drive)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="foto_kegiatan" class="form-label">Foto-foto Kegiatan</label>
                        {{-- Changed name to foto_kegiatan[] for multiple file uploads --}}
                        <input type="file"
                            class="form-control @error('foto_kegiatan') is-invalid @enderror @error('foto_kegiatan.*') is-invalid @enderror"
                            name="foto_kegiatan[]" id="foto_kegiatan" multiple accept="image/*">
                        @error('foto_kegiatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('foto_kegiatan.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Upload foto-foto dokumentasi kegiatan (format: JPG, PNG, WEBP,
                            JPEG, max 8MB per foto).</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi_kegiatan" class="form-label">Deskripsi Kegiatan</label>
                        <textarea class="form-control @error('deskripsi_kegiatan') is-invalid @enderror" name="deskripsi_kegiatan"
                            id="deskripsi_kegiatan" rows="4">{{ old('deskripsi_kegiatan') }}</textarea>
                        @error('deskripsi_kegiatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Tuliskan deskripsi lengkap mengenai kegiatan yang dilaksanakan
                        </div>
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
                                <th>Ditambahkan Oleh</th>
                                <th>Kategori kelompok</th> 
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
                                    <td>{{ $activity->user->name ?? ($activity->user_id ?? 'N/A') }}</td>
                                    <td>{{ $activity->sdg_goal ?? 'N/A' }}</td> 
                                    <td>{{ $activity->judul_kegiatan }}</td>
                                    {{-- Ensure tanggal_kegiatan is Carbon instance or cast to date in model --}}
                                    <td>{{ \Carbon\Carbon::parse($activity->tanggal_kegiatan)->format('d M Y') }}</td>
                                    <td>{{ strtoupper($activity->fakultas) }}</td>
                                    <td>{{ $activity->prodi ?? 'N/A' }}</td>
                                    <td>
                                        @if ($activity->link_kegiatan)
                                            <a href="{{ $activity->link_kegiatan }}" target="_blank"
                                                class="btn btn-sm btn-outline-info">View Link</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($activity->photos && $activity->photos->count() > 0)
                                            <button class="btn btn-sm btn-info view-photos"
                                                data-photos='@json($activity->photos->pluck('path'))' data-bs-toggle="modal"
                                                data-bs-target="#photoModal">
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
                                                data-id="{{ $activity->id }}" {{-- data-judul, data-tanggal etc. will be fetched via AJAX now for consistency --}}
                                                data-bs-toggle="modal" data-bs-target="#editModal">
                                                Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger delete-activity"
                                                data-id="{{ $activity->id }}"
                                                data-judul="{{ $activity->judul_kegiatan }}">
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
                @if ($sustainabilities->hasPages())
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
                            <div class="col-md-6 mb-3">
                                <label for="edit_sdg_goal" class="form-label">SDG Goal</label>
                                <select class="form-select" name="sdg_goal" id="edit_sdg_goal">
                                    <option value="">Pilih SDG Goal (Opsional)</option>
                                    @for ($i = 1; $i <= 17; $i++)
                                        <option value="SDG {{ $i }}">SDG {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="edit_judul_kegiatan" class="form-label">Judul Kegiatan</label>
                                <input type="text" class="form-control" name="judul_kegiatan"
                                    id="edit_judul_kegiatan">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_tanggal_kegiatan" class="form-label">Tanggal Kegiatan</label>
                                <input type="date" class="form-control" name="tanggal_kegiatan"
                                    id="edit_tanggal_kegiatan">
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
                                    <option value="fppsi">FPsi</option>
                                    <option value="fbs">FBS</option>
                                    <option value="ft">FT</option>
                                    <option value="fik">FIKK</option>
                                    <option value="fis">FISH</option>
                                    <option value="fe">FEB</option>
                                    <option value="profesi">PROFESI</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_prodi" class="form-label">Program Studi</label>
                                {{-- This will be populated by JS based on #edit_fakultas selection --}}
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
                                <label for="edit_foto_kegiatan" class="form-label">Tambah Foto-foto Kegiatan
                                    (Opsional)</label>
                                {{-- Changed name to foto_kegiatan[] --}}
                                <input type="file" class="form-control" name="foto_kegiatan[]"
                                    id="edit_foto_kegiatan" multiple accept="image/*">
                                <div class="form-text text-muted">Upload foto baru jika ingin menambah. Foto lama tidak
                                    akan dihapus otomatis. Biarkan kosong jika tidak ingin menambah foto.</div>
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

    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    {{-- Assuming jQuery, Bootstrap JS, SweetAlert2 are loaded in admin.admin layout --}}
    {{-- This script might rely on sustainability_dashboard.js for prodi dropdown population --}}
    {{-- The JS for edit/delete AJAX should be here or in a loaded JS specific to this admin view --}}
    <script src="{{ asset('dashboard_main/dashboard/sustainability_dashboard.js') }}"></script>
    {{-- ^ This JS likely handles the dynamic prodi dropdown based on fakultas selection for admin --}}

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // Handle View Photos button
        document.querySelectorAll('.view-photos').forEach(button => {
            button.addEventListener('click', function() {
                const photos = JSON.parse(this.dataset.photos);
                const gallery = document.getElementById('photoGallery');
                gallery.innerHTML = '';

                if (photos && photos.length > 0) {
                    photos.forEach(path => {
                        const img = document.createElement('img');
                        // Ensure the path starts with /storage/ if it's coming directly from DB
                        // Or adjust if your $activity->photos->pluck("path") already has it.
                        img.src = path.startsWith('http') ? path : `/storage/${path}`;
                        img.classList.add('img-fluid', 'mb-3', 'rounded');
                        img.style.maxHeight = '400px';
                        img.style.objectFit = 'contain';
                        img.style.display = 'block'; // Ensure images are block elements
                        img.style.marginLeft = 'auto'; // Center images
                        img.style.marginRight = 'auto';
                        gallery.appendChild(img);
                    });
                } else {
                    gallery.innerHTML = '<p>Tidak ada foto untuk ditampilkan.</p>';
                }
            });
        });

        // Handle Edit button clicks
        document.querySelectorAll('.edit-activity').forEach(button => {
            button.addEventListener('click', function() {
                const activityId = this.dataset.id;
                const editForm = document.getElementById('edit-form');
                // Make sure your update route name is correct, or use url() helper
                editForm.action = `{{ url('admin/sustainability') }}/${activityId}`; // Assuming this matches your PUT route

                fetch(`{{ url('admin/sustainability') }}/${activityId}/detail`, { // Your AJAX detail route
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    // document.getElementById('edit_activity_id').value = data.id; // Not needed if using route model binding for form action
                    document.getElementById('edit_judul_kegiatan').value = data.judul_kegiatan;
                    if (data.tanggal_kegiatan) {
                        document.getElementById('edit_tanggal_kegiatan').value = data.tanggal_kegiatan.split('T')[0];
                    }
                    document.getElementById('edit_sdg_goal').value = data.sdg_goal || ""; // Set SDG Goal

                    const editFakultasSelect = document.getElementById('edit_fakultas');
                    editFakultasSelect.value = data.fakultas;

                    // Trigger change on fakultas to populate prodi
                    const event = new Event('change', { bubbles: true }); // Ensure event bubbles if needed
                    editFakultasSelect.dispatchEvent(event);

                    setTimeout(() => {
                        const editProdiSelect = document.getElementById('edit_prodi');
                        if (data.prodi) {
                            editProdiSelect.value = data.prodi;
                        } else {
                           editProdiSelect.value = "";
                        }
                    }, 300); // Increased delay slightly, adjust if prodi options load slower

                    document.getElementById('edit_link_kegiatan').value = data.link_kegiatan || '';
                    document.getElementById('edit_deskripsi_kegiatan').value = data.deskripsi_kegiatan;

                    const currentPhotosDiv = document.getElementById('edit_current_photos');
                    currentPhotosDiv.innerHTML = '<p>Foto saat ini:</p>';
                    if (data.photos && data.photos.length > 0) {
                        data.photos.forEach(photo => {
                            const imgContainer = document.createElement('div');
                            imgContainer.classList.add('mb-2', 'd-inline-block', 'position-relative', 'me-2');
                            const img = document.createElement('img');
                            img.src = `/storage/${photo.path}`;
                            img.classList.add('img-thumbnail');
                            img.style.width = '100px'; img.style.height = '100px'; img.style.objectFit = 'cover';
                            imgContainer.appendChild(img);
                            currentPhotosDiv.appendChild(imgContainer);
                        });
                    } else {
                        currentPhotosDiv.innerHTML += '<p><em>Tidak ada foto terunggah.</em></p>';
                    }
                    document.getElementById('edit_foto_kegiatan').value = ''; // Clear file input
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
                // Make sure your delete route name is correct or use url() helper
                deleteForm.action = `{{ url('admin/sustainability') }}/${activityId}`; // Assuming this matches your DELETE route

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

        // Display SweetAlert for flash messages from PHP session
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session("error") }}',
                timer: 3000, // You can adjust timer or make it require confirmation
                showConfirmButton: true // Changed to true for errors, user might want to read it
            });
        @endif

        // Clear Bootstrap alert messages after SweetAlert displays them (optional)
        setTimeout(() => {
            let alertSuccessNode = document.querySelector('.alert-success');
            if(alertSuccessNode) {
                new bootstrap.Alert(alertSuccessNode).close();
            }
            let alertErrorNode = document.querySelector('.alert-danger'); // General error, not session('error')
             if(alertErrorNode && !alertErrorNode.querySelector('ul')) { // Don't close validation errors
                new bootstrap.Alert(alertErrorNode).close();
            }
        }, 3500); // A bit after SweetAlert timer

    });
    </script>
@endsection
