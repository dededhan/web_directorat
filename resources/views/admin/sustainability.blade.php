@extends('admin.admin')

<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/sustainability_dashboard.css') }}">

@section('contentadmin')
    {{-- ... (head-title, alerts, errors sections remain the same) ... --}}
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
                {{-- ... (SDG Goal, Judul Kegiatan, Tanggal Kegiatan rows remain the same) ... --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="edit_sdg_goal" class="form-label">Kelompok Kategori</label>
                        <select class="form-select" name="sdg_goal" id="sdg_goal_main"> {{-- Changed ID to be unique --}}
                            <option value="">Pilih Kelompok Kategori</option>
                            @php
                                $sdgGoalsData = $sdgDetailsList ?? [
                                    1 => "Tanpa Kemiskinan", 2 => "Tanpa Kelaparan", 3 => "Kehidupan Sehat dan Sejahtera",
                                    4 => "Pendidikan Berkualitas", 5 => "Kesetaraan Gender", 6 => "Air Bersih dan Sanitasi Layak",
                                    7 => "Energi Bersih dan Terjangkau", 8 => "Pekerjaan Layak dan Pertumbuhan Ekonomi",
                                    9 => "Industri, Inovasi, dan Infrastruktur", 10 => "Berkurangnya Kesenjangan",
                                    11 => "Kota dan Pemukiman yang Berkelanjutan", 12 => "Konsumsi dan Produksi yang Bertanggung Jawab",
                                    13 => "Penanganan Perubahan Iklim", 14 => "Ekosistem Lautan", 15 => "Ekosistem Daratan",
                                    16 => "Perdamaian, Keadilan, dan Kelembagaan yang Tangguh", 17 => "Kemitraan untuk Mencapai Tujuan",
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
                     <div class="col-md-12 mb-3"> {{-- Moved Judul Kegiatan here if preferred, or keep original layout --}}
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
                            {{-- Dynamically populate from $faculties_data --}}
                            @if(isset($faculties_data) && is_array($faculties_data))
                                @foreach($faculties_data as $key => $facultyInfo)
                                    <option value="{{ strtolower($key) }}" {{ old('fakultas') == strtolower($key) ? 'selected' : '' }}>
                                        {{ $facultyInfo['name'] }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('fakultas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Pilih fakultas penyelenggara kegiatan</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select @error('prodi') is-invalid @enderror" name="prodi" id="prodi" disabled>
                            <option value="">Pilih Program Studi</option>
                            {{-- Options will be populated by JavaScript --}}
                        </select>
                        @error('prodi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Pilih program studi terkait kegiatan (opsional jika level fakultas)</div>
                    </div>
                </div>

                {{-- ... (Link Kegiatan, Foto Kegiatan, Deskripsi Kegiatan, Submit button rows remain the same) ... --}}
                 <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="link_kegiatan" class="form-label">Link Kegiatan</label>
                        <input type="url" class="form-control @error('link_kegiatan') is-invalid @enderror"
                            name="link_kegiatan" id="link_kegiatan" value="{{ old('link_kegiatan') }}">
                        @error('link_kegiatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Masukkan link dokumentasi kegiatan (YouTube/Media Sosial/Google Drive)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="foto_kegiatan" class="form-label">Foto-foto Kegiatan</label>
                        <input type="file"
                            class="form-control @error('foto_kegiatan') is-invalid @enderror @error('foto_kegiatan.*') is-invalid @enderror"
                            name="foto_kegiatan[]" id="foto_kegiatan" multiple accept="image/*">
                        @error('foto_kegiatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('foto_kegiatan.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Upload foto-foto dokumentasi kegiatan (format: JPG, PNG, WEBP, JPEG, max 8MB per foto).</div>
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
                        <div class="form-text text-muted">Tuliskan deskripsi lengkap mengenai kegiatan yang dilaksanakan</div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>

        {{-- ... (Table of activities, pagination, photoModal remain the same) ... --}}
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
                                    <td>{{ \Carbon\Carbon::parse($activity->tanggal_kegiatan)->format('d M Y') }}</td>
                                    <td>{{ strtoupper($activity->fakultas) }}</td>
                                    <td>{{ $activity->prodi ?? 'N/A (Fakultas)' }}</td>
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
                                                data-photos='@json($activity->photos->pluck("path"))' data-bs-toggle="modal"
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
                                                data-id="{{ $activity->id }}"
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
                                    <td colspan="10" class="text-center">Belum ada data kegiatan sustainability.</td>
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

    {{-- Photo Modal --}}
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

    {{-- Edit Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Kegiatan Sustainability</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit-form" method="POST" enctype="multipart/form-data"> {{-- Action set by JS --}}
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit_activity_id" name="activity_id"> {{-- Still useful if not using route model binding in JS form action --}}
                        {{-- ... (SDG Goal, Judul Kegiatan, Tanggal Kegiatan rows for edit modal remain the same) ... --}}
                         <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_sdg_goal_modal" class="form-label">Kelompok Kategori</label> {{-- Changed ID --}}
                                <select class="form-select" name="sdg_goal" id="edit_sdg_goal_modal">
                                    <option value="">Pilih Kelompok Kategori (Opsional)</option>
                                     @foreach ($sdgGoalsData as $number => $description) {{-- Re-use $sdgGoalsData --}}
                                        @php $optionValue = "SDG " . $number; @endphp
                                        <option value="{{ $optionValue }}">
                                            SDGs {{ $number }}: {{ $description }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
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
                                     @if(isset($faculties_data) && is_array($faculties_data))
                                        @foreach($faculties_data as $key => $facultyInfo)
                                            <option value="{{ strtolower($key) }}">{{ $facultyInfo['name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_prodi" class="form-label">Program Studi</label>
                                <select class="form-select" name="prodi" id="edit_prodi" disabled>
                                    <option value="">Pilih Program Studi</option>
                                    {{-- Populated by JS --}}
                                </select>
                            </div>
                        </div>

                        {{-- ... (Link Kegiatan, Foto Kegiatan, Deskripsi Kegiatan rows for edit modal remain the same) ... --}}
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_link_kegiatan" class="form-label">Link Kegiatan</label>
                                <input type="url" class="form-control" name="link_kegiatan" id="edit_link_kegiatan">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_foto_kegiatan" class="form-label">Tambah Foto-foto Kegiatan (Opsional)</label>
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

    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script src="{{ asset('dashboard_main/dashboard/sustainability_dashboard.js') }}"></script>
    {{-- ^ This JS likely handles the dynamic prodi dropdown based on fakultas selection for admin for the OLD setup.
         We will add new JS below to override/enhance this for sustainability.blade.php specifically,
         following the matakuliah.blade.php pattern. --}}

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        // Ensure $faculties_data is available from the controller, otherwise provide an empty object.
        const facultiesData = @json($faculties_data ?? []);

        function populateProdiDropdown(fakultasValue, prodiSelectElement, selectedProdi = null, currentFacultiesData) {
            prodiSelectElement.innerHTML = '<option value="">Pilih Program Studi</option>'; // Default first
            const fakultasLevelOptionHTML = '<option value="">-- Level Fakultas (Tanpa Prodi) --</option>';
            prodiSelectElement.disabled = true;

            if (fakultasValue && typeof fakultasValue === 'string') { // fakultasValue is lowercase e.g. "fmipa"
                const facultyKey = fakultasValue.toUpperCase(); // Convert to UPPERCASE for lookup e.g. "FMIPA"

                if (currentFacultiesData[facultyKey] && currentFacultiesData[facultyKey].programs) {
                    const programs = currentFacultiesData[facultyKey].programs;
                    if (programs.length > 0) {
                        prodiSelectElement.disabled = false;
                        prodiSelectElement.innerHTML += fakultasLevelOptionHTML; // Add level fakultas option

                        programs.forEach(prodi => {
                            const option = document.createElement('option');
                            option.value = prodi;
                            option.textContent = prodi;
                            prodiSelectElement.appendChild(option);
                        });
                    } else { // Faculty exists but has no programs listed, still allow "Level Fakultas"
                        prodiSelectElement.disabled = false;
                        prodiSelectElement.innerHTML += fakultasLevelOptionHTML;
                    }
                } else { // No valid faculty key found or no programs defined for it
                     prodiSelectElement.innerHTML += fakultasLevelOptionHTML; // Still allow "Level Fakultas"
                     prodiSelectElement.disabled = false; // Keep it enabled for "Level Fakultas" selection
                }
            } else { // No faculty selected
                prodiSelectElement.innerHTML += fakultasLevelOptionHTML;
                prodiSelectElement.disabled = true; // Or false if you want to allow selecting "Level Fakultas" even without parent faculty
            }

            // Set the selected prodi if provided
            if (selectedProdi) {
                prodiSelectElement.value = selectedProdi;
            } else if (!prodiSelectElement.disabled) {
                 // If prodi is not pre-selected, and dropdown is enabled,
                 // default to "Pilih Program Studi" or "-- Level Fakultas --"
                 // Check if the "-- Level Fakultas --" was explicitly chosen (empty string for prodi)
                 if (selectedProdi === "" && selectedProdi !== null) { // Explicitly faculty level
                     prodiSelectElement.value = "";
                 } else if (selectedProdi === null) { // Nothing was pre-selected for prodi
                     prodiSelectElement.value = ""; // Default to "Pilih Program Studi" which might also be the value for "Level Fakultas" if structured that way
                 }
            }
             // Ensure "Pilih Program Studi" is selected if no prodi and no specific "Level Fakultas" indicated
            if (prodiSelectElement.disabled || (!selectedProdi && selectedProdi !== "" )) {
                 if(prodiSelectElement.options.length > 0 && prodiSelectElement.options[0].value === "") {
                    prodiSelectElement.value = ""; // Default to "Pilih Program Studi"
                 }
            }
        }

        // Main form: Fakultas and Prodi dropdown logic
        const mainFakultasSelect = document.getElementById('fakultas');
        const mainProdiSelect = document.getElementById('prodi');

        if (mainFakultasSelect && mainProdiSelect) {
            mainFakultasSelect.addEventListener('change', function() {
                populateProdiDropdown(this.value, mainProdiSelect, null, facultiesData);
            });

            // Initial population on page load if a faculty is already selected (e.g., from old input)
            if (mainFakultasSelect.value) {
                const oldProdiValue = "{{ old('prodi') }}";
                populateProdiDropdown(mainFakultasSelect.value, mainProdiSelect, oldProdiValue, facultiesData);
            } else {
                mainProdiSelect.innerHTML = '<option value="">Pilih Program Studi</option><option value="">-- Level Fakultas (Tanpa Prodi) --</option>';
                mainProdiSelect.disabled = true;
            }
        }

        // Handle View Photos button
        document.querySelectorAll('.view-photos').forEach(button => {
            button.addEventListener('click', function() {
                const photos = JSON.parse(this.dataset.photos);
                const gallery = document.getElementById('photoGallery');
                gallery.innerHTML = '';
                if (photos && photos.length > 0) {
                    photos.forEach(path => {
                        const img = document.createElement('img');
                        img.src = path.startsWith('http') ? path : `/storage/${path}`;
                        img.classList.add('img-fluid', 'mb-3', 'rounded');
                        img.style.maxHeight = '400px'; img.style.objectFit = 'contain';
                        img.style.display = 'block'; img.style.marginLeft = 'auto'; img.style.marginRight = 'auto';
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
                editForm.action = `{{ url('admin/sustainability') }}/${activityId}`;

                fetch(`{{ url('admin/sustainability') }}/${activityId}/detail`, {
                    method: 'GET',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrfToken }
                })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    document.getElementById('edit_activity_id').value = data.id;
                    document.getElementById('edit_judul_kegiatan').value = data.judul_kegiatan;
                    if (data.tanggal_kegiatan) {
                        document.getElementById('edit_tanggal_kegiatan').value = data.tanggal_kegiatan.split('T')[0];
                    }
                    document.getElementById('edit_sdg_goal_modal').value = data.sdg_goal || ""; // Use correct ID

                    const editFakultasSelect = document.getElementById('edit_fakultas');
                    editFakultasSelect.value = data.fakultas; // data.fakultas is lowercase from DB

                    const editProdiSelect = document.getElementById('edit_prodi');
                    populateProdiDropdown(data.fakultas, editProdiSelect, data.prodi, facultiesData);

                    document.getElementById('edit_link_kegiatan').value = data.link_kegiatan || '';
                    document.getElementById('edit_deskripsi_kegiatan').value = data.deskripsi_kegiatan;

                    const currentPhotosDiv = document.getElementById('edit_current_photos');
                    currentPhotosDiv.innerHTML = '<p>Foto saat ini:</p>';
                    if (data.photos && data.photos.length > 0) {
                        data.photos.forEach(photo => {
                            // ... (photo display logic remains the same)
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
                    document.getElementById('edit_foto_kegiatan').value = '';
                })
                .catch(error => {
                    console.error('Error fetching activity details:', error);
                    Swal.fire('Error', 'Gagal mengambil detail kegiatan. ' + error.message, 'error');
                });
            });
        });

        // Handle Delete button clicks (remains the same)
        document.querySelectorAll('.delete-activity').forEach(button => {
            button.addEventListener('click', function() {
                const activityId = this.dataset.id;
                const activityJudul = this.dataset.judul;
                const deleteForm = document.getElementById('delete-form');
                deleteForm.action = `{{ url('admin/sustainability') }}/${activityId}`;

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
                        deleteForm.submit(); // Submit the form
                    }
                });
            });
        });


        // SweetAlert for flash messages (remains the same)
        @if(session('success'))
            Swal.fire({
                icon: 'success', title: 'Berhasil!', text: '{{ session("success") }}',
                timer: 3000, showConfirmButton: false
            });
        @endif
        @if(session('error'))
            Swal.fire({
                icon: 'error', title: 'Gagal!', text: '{{ session("error") }}',
                showConfirmButton: true // Keep true for errors
            });
        @endif

        // Optional: Clear Bootstrap alerts after SweetAlert
        setTimeout(() => {
            let alertSuccessNode = document.querySelector('.alert-success');
            if(alertSuccessNode) new bootstrap.Alert(alertSuccessNode).close();
            let alertErrorNode = document.querySelector('.alert-danger');
             if(alertErrorNode && !alertErrorNode.querySelector('ul')) {
                new bootstrap.Alert(alertErrorNode).close();
            }
        }, 3500);
    });
    </script>
@endsection