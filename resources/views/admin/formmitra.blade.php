@extends('admin.admin')

@section('contentadmin')
@vite(['resources/css/admin/mitra_kolaborasi.css'])
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="head-title">
    <div class="left">
        <h1>Mitra Kolaborasi</h1>
        <ul class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a href="#">Inovasi</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="{{ route($routePrefix . '.mitra-kolaborasi.index') }}">Mitra Kolaborasi</a></li>
        </ul>
    </div>
</div>

<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Input Mitra Baru</h3>
        </div>

        <form method="POST" action="{{ route($routePrefix . '.mitra-kolaborasi.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label">Nama Mitra</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="link_website" class="form-label">Link Website Mitra</label>
                    <input type="url" class="form-control @error('link_website') is-invalid @enderror" name="link_website" id="link_website" value="{{ old('link_website') }}" required>
                    @error('link_website')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select class="form-control @error('kategori') is-invalid @enderror" name="kategori" id="kategori" required>
                        <option value="">Pilih Kategori...</option>
                        <option value="Pendidikan" {{ old('kategori') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                        <option value="Sains & Teknologi" {{ old('kategori') == 'Sains & Teknologi' ? 'selected' : '' }}>Sains & Teknologi</option>
                        <option value="Sosial Humaniora & Seni" {{ old('kategori') == 'Sosial Humaniora & Seni' ? 'selected' : '' }}>Sosial Humaniora & Seni</option>
                        <option value="Kesehatan & Psikologi" {{ old('kategori') == 'Kesehatan & Psikologi' ? 'selected' : '' }}>Kesehatan & Psikologi</option>
                    </select>
                    @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="foto" class="form-label">Logo/Foto Mitra</label>
                    <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto" accept="image/*" required>
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan Mitra</button>
            </div>
        </form>
    </div>
</div>

<div class="table-data mt-4">
    <div class="order">
        <div class="head">
            <h3>Daftar Mitra Kolaborasi</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mitra</th>
                        <th>Kategori</th>
                        <th>Link Website</th>
                        <th>Foto</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mitraKolaborasi as $index => $mitra)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $mitra->nama }}</td>
                            <td>{{ $mitra->kategori }}</td>
                            <td><a href="{{ $mitra->link_website }}" target="_blank">Kunjungi</a></td>
                            <td>
                                <button class="btn btn-sm btn-info view-image" data-image="{{ asset('storage/' . $mitra->foto) }}" data-title="{{ $mitra->nama }}">
                                    Lihat Foto
                                </button>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-warning edit-mitra" data-id="{{ $mitra->id }}">
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route($routePrefix . '.mitra-kolaborasi.destroy', $mitra->id) }}" class="delete-form d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-btn">Delete</button>
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

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Foto Mitra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Foto Mitra">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editMitraModal" tabindex="-1" aria-labelledby="editMitraModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMitraModalLabel">Edit Mitra Kolaborasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editMitraForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_nama" class="form-label">Nama Mitra</label>
                            <input type="text" class="form-control" name="nama" id="edit_nama" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_link_website" class="form-label">Link Website</label>
                            <input type="url" class="form-control" name="link_website" id="edit_link_website" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_kategori" class="form-label">Kategori</label>
                            <select class="form-control" name="kategori" id="edit_kategori" required>
                                <option value="Pendidikan">Pendidikan</option>
                                <option value="Sains & Teknologi">Sains & Teknologi</option>
                                <option value="Sosial Humaniora & Seni">Sosial Humaniora & Seni</option>
                                <option value="Kesehatan & Psikologi">Kesehatan & Psikologi</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                             <label for="edit_foto" class="form-label">Foto Baru (opsional)</label>
                            <input type="file" class="form-control" name="foto" id="edit_foto" accept="image/*">
                            <div class="mt-2">
                                <p>Foto saat ini:</p>
                                <img id="current_image" src="" class="img-fluid mt-2" style="max-height: 100px;" alt="Current Image">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveEditMitra">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle Create Form Submission
    const createForm = document.querySelector('form[action*="mitra-kolaborasi.store"]');
    if (createForm) {
        createForm.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi', text: 'Apakah Anda yakin ingin menyimpan mitra ini?',
                icon: 'question', showCancelButton: true, confirmButtonColor: '#3498db',
                cancelButtonColor: '#d33', confirmButtonText: 'Ya, Simpan!', cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({ title: 'Menyimpan...', text: 'Mohon tunggu sebentar', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                    this.submit();
                }
            });
        });
    }

    // Handle Delete Button Clicks
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            Swal.fire({
                title: 'Konfirmasi Penghapusan', text: 'Apakah Anda yakin ingin menghapus mitra ini? Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33',
                cancelButtonColor: '#3498db', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({ title: 'Menghapus...', text: 'Mohon tunggu sebentar', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                    form.submit();
                }
            });
        });
    });

    // Handle Edit Button Clicks
    document.querySelectorAll('.edit-mitra').forEach(button => {
        button.addEventListener('click', function() {
            const mitraId = this.dataset.id;
            const routePrefix = '{{ $routePrefix }}';
            const routePath = routePrefix.replace(/\./g, '/');

            Swal.fire({ title: 'Memuat Data...', text: 'Mohon tunggu sebentar', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

            fetch(`/admin/mitra-kolaborasi/${mitraId}/detail`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    Swal.close();
                    document.getElementById('edit_nama').value = data.nama;
                    document.getElementById('edit_link_website').value = data.link_website;
                    document.getElementById('edit_kategori').value = data.kategori;
                    
                    const currentImage = document.getElementById('current_image');
                    if (data.foto) {
                        currentImage.src = `/storage/${data.foto}`;
                        currentImage.style.display = 'block';
                    } else {
                        currentImage.style.display = 'none';
                    }

                    const form = document.getElementById('editMitraForm');
                    form.action = `/admin/mitra-kolaborasi/${mitraId}`;

                    const editModal = new bootstrap.Modal(document.getElementById('editMitraModal'));
                    editModal.show();
                })
                .catch(error => {
                    console.error('Error fetching mitra details:', error);
                    Swal.fire({ title: 'Error!', text: 'Gagal mengambil data mitra.', icon: 'error', confirmButtonColor: '#3498db' });
                });
        });
    });

    // Handle Save Button Click for Edit Form
    document.getElementById('saveEditMitra').addEventListener('click', function() {
        Swal.fire({
            title: 'Konfirmasi', text: 'Apakah Anda yakin ingin menyimpan perubahan?',
            icon: 'question', showCancelButton: true, confirmButtonColor: '#3498db',
            cancelButtonColor: '#d33', confirmButtonText: 'Ya, Simpan!', cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('editMitraForm');
                const formData = new FormData(form);
                
                //
                // Untuk mengirimkan method PUT melalui AJAX dengan FormData, kita perlu menambahkannya secara manual
                formData.append('_method', 'PUT');

                Swal.fire({ title: 'Menyimpan Perubahan...', text: 'Mohon tunggu sebentar', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

                fetch(form.action, {
                    method: 'POST', // Form method spoofing in Laravel
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const modalElement = document.getElementById('editMitraModal');
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                        Swal.fire({ title: 'Berhasil!', text: data.message || 'Mitra berhasil diperbarui!', icon: 'success', confirmButtonColor: '#3498db' })
                        .then(() => window.location.reload());
                    } else {
                        Swal.fire({ title: 'Gagal!', text: data.message || 'Gagal menyimpan perubahan.', icon: 'error', confirmButtonColor: '#3498db' });
                    }
                })
                .catch(error => {
                    console.error('Error saving mitra:', error);
                    Swal.fire({ title: 'Error!', text: 'Terjadi kesalahan saat menyimpan perubahan.', icon: 'error', confirmButtonColor: '#3498db' });
                });
            }
        });
    });

    // Handle View Image
    document.querySelectorAll('.view-image').forEach(button => {
        button.addEventListener('click', function() {
            const imageUrl = this.dataset.image;
            const title = this.dataset.title;
            document.getElementById('imageModalLabel').textContent = title;
            document.getElementById('modalImage').src = imageUrl;
            const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            imageModal.show();
        });
    });

    // Flash Message Handling
    const flashSuccess = "{{ session('success') }}";
    const flashError = "{{ session('error') }}";
    if (flashSuccess) {
        Swal.fire({ title: 'Berhasil!', text: flashSuccess, icon: 'success', confirmButtonColor: '#3498db' });
    }
    if (flashError) {
        Swal.fire({ title: 'Error!', text: flashError, icon: 'error', confirmButtonColor: '#3498db' });
    }
});
</script>
@endsection