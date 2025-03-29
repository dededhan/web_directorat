@extends('admin.admin')

@section('contentadmin')
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

    <!-- Debug Info - Remove after testing -->
    @if(isset($videos))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            Found {{ $videos->count() }} videos in the database.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @else
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            $videos variable is not set.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Flash Messages -->
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

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Video YouTube</h3>
            </div> 

            <form method="POST" action="{{ route('admin.youtube.store') }}" enctype="multipart/form-data">
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
                <div class="head">
                    <h3>Daftar Video YouTube</h3>
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
                                        <form method="POST" action="{{ route('admin.youtube.destroy', $video->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus video ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                document.querySelectorAll('.alert').forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

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
        });
    </script>

    <style>
        .table-data {
            margin-top: 24px;
        }
        
        .order {
            background: #fff;
            padding: 24px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus, .form-select:focus {
            border-color: #3498db;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .table-responsive {
            overflow-x: auto;
        }
        
        .btn-group {
            display: flex;
            gap: 5px;
        }

        textarea {
            resize: vertical;
        }
        
        .table th {
            white-space: nowrap;
        }
        
        /* Alert styling */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
        }
        
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        
        .alert-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }
        
        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeeba;
            color: #856404;
        }
    </style>
@endsection