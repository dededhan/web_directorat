@extends('subdirektorat-inovasi.admin_hilirisasi.index')



<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/youtube_dashboard.css') }}">
@section('content-admin-hilirisasi')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="head-title">
        <div class="left">
            <h1>YouTube</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Kelola Video</a>
                </li>
            </ul>
        </div>
    </div>


    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Video YouTube</h3>
            </div> 

            <form method="POST" action="{{ route($routePrefix . '.youtube.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="judul" class="form-label">Judul Video</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" id="judul" value="{{ old('judul') }}">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Masukkan judul video (maksimal 100 karakter)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Tuliskan deskripsi singkat tentang video ini</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="link" class="form-label">Link YouTube</label>
                        <input type="url" class="form-control @error('link') is-invalid @enderror" name="link" id="link" value="{{ old('link') }}" placeholder="https://www.youtube.com/watch?v=...">
                        @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Masukkan URL video YouTube (format: https://www.youtube.com/watch?v=...)</div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan Video</button>
                </div>
            </form>
        </div>

        <div class="table-data mt-4">
            <div class="order">
                <div class="head d-flex justify-content-between align-items-center mb-3">
                    <h3>Daftar Video YouTube</h3>
                    <div class="search-container">
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari video...">
                            <button class="btn btn-primary" type="button">
                                <i class='bx bx-search'></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="video-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Link</th>
                                <th>Preview</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($videos ?? [] as $index => $video)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $video->judul }}</td>
                                <td>{{ Str::limit($video->deskripsi, 50) }}</td>
                                <td>
                                    <a href="{{ $video->link }}" target="_blank" class="text-primary">
                                        {{ Str::limit($video->link, 40) }}
                                    </a>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info view-video" 
                                        data-video="{{ $video->link }}"
                                        data-title="{{ $video->judul }}">
                                        Lihat Video
                                    </button>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-warning edit-video"
                                            data-id="{{ $video->id }}">
                                            <i class='bx bx-edit'></i> Edit
                                        </button>
                                        <form method="POST"
                                            action="{{ route($routePrefix . '.youtube.destroy', $video->id) }}"
                                            class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-btn">
                                                <i class='bx bx-trash'></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data video</td>
                            </tr>
                            @endforelse
                        </tbody>                        
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk menampilkan video -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">Preview Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="ratio ratio-16x9">
                        <iframe id="modalVideo" src="" title="YouTube video player" frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk mengedit video -->
    <div class="modal fade" id="editVideoModal" tabindex="-1" aria-labelledby="editVideoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editVideoModalLabel">Edit Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editVideoForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_judul" class="form-label">Judul Video</label>
                                <input type="text" class="form-control" name="judul" id="edit_judul">
                                <div class="form-text text-muted">Masukkan judul video (maksimal 100 karakter)</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" id="edit_deskripsi" rows="4"></textarea>
                                <div class="form-text text-muted">Tuliskan deskripsi singkat tentang video ini</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_link" class="form-label">Link YouTube</label>
                                <input type="url" class="form-control" name="link" id="edit_link" placeholder="https://www.youtube.com/watch?v=...">
                                <div class="form-text text-muted">Masukkan URL video YouTube (format: https://www.youtube.com/watch?v=...)</div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEditVideo">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script section -->
    <script>
        // Set global variables for use in external JS file
        const appConfig = {
            csrfToken: '{{ csrf_token() }}',
            routePrefix: '{{ $routePrefix }}'
        };

        // SweetAlert helper functions
        function showSuccessAlert(message) {
            Swal.fire({
                title: 'Berhasil!',
                text: message,
                icon: 'success',
                confirmButtonColor: '#3498db',
                confirmButtonText: 'OK'
            });
        }

        function showErrorAlert(message) {
            Swal.fire({
                title: 'Gagal!',
                text: message,
                icon: 'error',
                confirmButtonColor: '#3498db',
                confirmButtonText: 'OK'
            });
        }

        function showConfirmationDialog(message, callback) {
            Swal.fire({
                title: 'Konfirmasi',
                text: message,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3498db',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    callback();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                document.querySelectorAll('.alert').forEach(function(alert) {
                    if (alert && bootstrap.Alert) {
                        var bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                });
            }, 5000);

            // Search functionality
            const searchInput = document.getElementById('searchInput');
            
            searchInput.addEventListener('keyup', function() {
                const searchText = this.value.toLowerCase();
                const table = document.getElementById('video-table');
                const rows = table.getElementsByTagName('tr');
                
                // Start from index 1 to skip the header row
                for (let i = 1; i < rows.length; i++) {
                    const rowData = rows[i].textContent.toLowerCase();
                    if (rowData.includes(searchText)) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            });

            // Handle view video
            document.querySelectorAll('.view-video').forEach(button => {
                button.addEventListener('click', function() {
                    const videoUrl = this.dataset.video;
                    const title = this.dataset.title;
                    
                    // Convert YouTube URL to embed URL
                    let embedUrl = '';
                    // Handle different YouTube URL formats
                    if (videoUrl.includes('youtu.be/')) {
                        // Short URL format: https://youtu.be/VIDEO_ID
                        const videoId = videoUrl.split('youtu.be/')[1].split('?')[0];
                        embedUrl = 'https://www.youtube.com/embed/' + videoId;
                    } else if (videoUrl.includes('watch?v=')) {
                        // Standard URL format: https://www.youtube.com/watch?v=VIDEO_ID
                        const videoId = new URLSearchParams(videoUrl.split('?')[1]).get('v');
                        embedUrl = 'https://www.youtube.com/embed/' + videoId;
                    } else if (videoUrl.includes('/embed/')) {
                        // Already in embed format
                        embedUrl = videoUrl;
                    } else {
                        // Fallback
                        embedUrl = videoUrl.replace('watch?v=', 'embed/');
                    }
                    
                    document.getElementById('videoModalLabel').textContent = title;
                    document.getElementById('modalVideo').src = embedUrl;
                    
                    new bootstrap.Modal(document.getElementById('videoModal')).show();
                });
            });
            
            // Clean up modal when it's closed
            document.getElementById('videoModal').addEventListener('hidden.bs.modal', function () {
                document.getElementById('modalVideo').src = '';
            });

            // Handle delete button clicks
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');

                    showConfirmationDialog('Apakah Anda yakin ingin menghapus video ini?',
                        () => {
                            form.submit();
                        });
                });
            });

            // Handle edit button clicks
            document.querySelectorAll('.edit-video').forEach(button => {
                button.addEventListener('click', function() {
                    const videoId = this.dataset.id;
                    const routePrefix = '{{ $routePrefix }}';

                    // Convert route prefix with dots to path with slashes
                    const routePath = routePrefix.replace(/\./g, '/');

                    // Fetch video details via AJAX
                    fetch(`/${routePath}/youtube/${videoId}/detail`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Populate the edit form
                            document.getElementById('edit_judul').value = data.judul;
                            document.getElementById('edit_deskripsi').value = data.deskripsi;
                            document.getElementById('edit_link').value = data.link;

                            // Set the form action with correct path structure
                            const form = document.getElementById('editVideoForm');
                            form.action = `/${routePath}/youtube/${videoId}`;

                            // Show the modal
                            new bootstrap.Modal(document.getElementById('editVideoModal')).show();
                        })
                        .catch(error => {
                            console.error('Error fetching video details:', error);
                            showErrorAlert('Gagal mengambil data video.');
                        });
                });
            });

            // Handle save button click in edit modal
            document.getElementById('saveEditVideo').addEventListener('click', function() {
                const form = document.getElementById('editVideoForm');
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
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(errorData => {
                                throw new Error(JSON.stringify(errorData));
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Close the modal
                            const modalElement = document.getElementById('editVideoModal');
                            const modal = bootstrap.Modal.getInstance(modalElement);
                            modal.hide();

                            // Show success message
                            showSuccessAlert(data.message || 'Video berhasil diperbarui!');

                            // Refresh the page after a short delay
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            showErrorAlert(data.message || 'Gagal menyimpan perubahan.');
                        }
                    })
                    .catch(error => {
                        console.error('Error saving video:', error);
                        try {
                            const errorData = JSON.parse(error.message);
                            if (errorData.errors) {
                                const errorMessages = Object.values(errorData.errors).flat().join('\n');
                                showErrorAlert('Error: ' + errorMessages);
                            } else {
                                showErrorAlert('Gagal menyimpan perubahan: ' + error.message);
                            }
                        } catch (e) {
                            showErrorAlert('Gagal menyimpan perubahan.');
                        }
                    });
            });
        });
    </script>

    <style>
        
    </style>
@endsection