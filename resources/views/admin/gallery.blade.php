@extends('admin.admin')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/berita_dashboard.css') }}">

@section('contentadmin')
{{-- Awal: Perubahan untuk Vite --}}
    @vite([
        'resources/css/admin/berita_dashboard.css'
    ])
    {{-- Akhir: Perubahan untuk Vite --}}
    <div class="head-title">
        <div class="left">
            <h1>Gallery</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Manage Gallery</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Add Gallery Item</h3>
            </div>

            <form method="POST" action="{{ route($routePrefix . '.gallery.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select @error('category') is-invalid @enderror" name="category" id="category">
                            <option value="">Select Category</option>
                            <option value="direktorat" {{ old('category') == 'direktorat' ? 'selected' : '' }}>Direktorat</option>
                            <option value="inovasi" {{ old('category') == 'inovasi' ? 'selected' : '' }}>Inovasi</option>
                            <option value="pemeringkatan" {{ old('category') == 'pemeringkatan' ? 'selected' : '' }}>Pemeringkatan</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Select the appropriate gallery category</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"
                            id="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Upload gallery image (format: JPG, PNG, or JPEG, max 100MB)</div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save Gallery Item</button>
                </div>
            </form>
        </div>

        <div class="table-data mt-4">
            <div class="order">
                <div class="head">
                    <h3>Gallery List</h3>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped" id="gallery-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Category</th>
                                <th>Image</th>
                                <th>Added Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($galleries as $index => $gallery)
                                <tr>
                                    <td>{{ ($galleries->currentPage() - 1) * $galleries->perPage() + $index + 1 }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ [
                                                'direktorat' => 'primary',
                                                'inovasi' => 'success',
                                                'pemeringkatan' => 'info',
                                            ][$gallery->category] }}">
                                            {{ ucfirst($gallery->category) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info view-image"
                                            data-image="{{ asset('storage/' . $gallery->image) }}"
                                            data-title="Gallery Image">
                                            View Image
                                        </button>
                                    </td>
                                    <td>{{ $gallery->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-warning edit-gallery"
                                                data-id="{{ $gallery->id }}">
                                                Edit
                                            </button>
                                            <form method="POST"
                                                action="{{ route($routePrefix . '.gallery.destroy', $gallery->id) }}"
                                                class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-danger delete-btn">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $galleries->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for displaying image -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Gallery Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Gallery Image">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for editing gallery item -->
    <div class="modal fade" id="editGalleryModal" tabindex="-1" aria-labelledby="editGalleryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGalleryModalLabel">Edit Gallery Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editGalleryForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_category" class="form-label">Category</label>
                                <select class="form-select" name="category" id="edit_category">
                                    <option value="direktorat">Direktorat</option>
                                    <option value="inovasi">Inovasi</option>
                                    <option value="pemeringkatan">Pemeringkatan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_image" class="form-label">New Image (optional)</label>
                                <input type="file" class="form-control" name="image" id="edit_image"
                                    accept="image/*">
                                <div class="mt-2">
                                    <p>Current Image:</p>
                                    <img id="current_image" src="" class="img-fluid mt-2"
                                        style="max-height: 200px;" alt="Current Image">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveEditGallery">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script section -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // SweetAlert helper functions
            function showSuccessAlert(message) {
                Swal.fire({
                    title: 'Success!',
                    text: message,
                    icon: 'success',
                    confirmButtonColor: '#3498db',
                    confirmButtonText: 'OK'
                });
            }

            function showErrorAlert(message) {
                Swal.fire({
                    title: 'Failed!',
                    text: message,
                    icon: 'error',
                    confirmButtonColor: '#3498db',
                    confirmButtonText: 'OK'
                });
            }

            function showConfirmationDialog(message, callback) {
                Swal.fire({
                    title: 'Confirmation',
                    text: message,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3498db',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        callback();
                    }
                });
            }

            // Handle view image
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

            // Handle delete button clicks
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');

                    showConfirmationDialog('Are you sure you want to delete this gallery item?', () => {
                        form.submit();
                    });
                });
            });

            // Handle edit button clicks
            document.querySelectorAll('.edit-gallery').forEach(button => {
                button.addEventListener('click', function() {
                    const galleryId = this.dataset.id;
                    const routePrefix = '{{ $routePrefix }}';

                    // Convert route prefix with dots to path with slashes
                    const routePath = routePrefix.replace(/\./g, '/');

                    // Fetch gallery details via AJAX
                    fetch(`/${routePath}/gallery/${galleryId}/detail`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Populate the edit form
                            document.getElementById('edit_category').value = data.category;

                            // Set the current image
                            const currentImage = document.getElementById('current_image');
                            currentImage.src = `/storage/${data.image}`;

                            // Set the form action with correct path structure
                            const form = document.getElementById('editGalleryForm');
                            form.action = `/${routePath}/gallery/${galleryId}`;

                            // Show the modal
                            const editModal = new bootstrap.Modal(document.getElementById('editGalleryModal'));
                            editModal.show();
                        })
                        .catch(error => {
                            console.error('Error fetching gallery details:', error);
                            showErrorAlert('Failed to retrieve gallery details.');
                        });
                });
            });

            // Handle save button click
            document.getElementById('saveEditGallery').addEventListener('click', function() {
                const form = document.getElementById('editGalleryForm');
                const formData = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Close the modal
                            const modalElement = document.getElementById('editGalleryModal');
                            const modal = bootstrap.Modal.getInstance(modalElement);
                            modal.hide();

                            // Show success message
                            showSuccessAlert(data.message || 'Gallery item successfully updated!');

                            // Refresh the page after a short delay
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            showErrorAlert(data.message || 'Failed to save changes.');
                        }
                    })
                    .catch(error => {
                        console.error('Error saving gallery item:', error);
                        showErrorAlert('Failed to save changes.');
                    });
            });

            // Display flash messages using SweetAlert if they exist
            @if(session('success'))
                showSuccessAlert("{{ session('success') }}");
            @endif

            @if(session('error'))
                showErrorAlert("{{ session('error') }}");
            @endif
        });
    </script>
@endsection