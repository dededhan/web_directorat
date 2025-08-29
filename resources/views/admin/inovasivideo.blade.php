@extends('admin.admin')

@section('contentadmin')
@vite(['resources/css/admin/produk_inovasi.css'])

<div class="head-title">
    <div class="left">
        <h1>Video Sambutan Pimpinan</h1>
        <ul class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="#">Video Pimpinan</a></li>
        </ul>
    </div>
</div>

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire('Berhasil!', '{{ session('success') }}', 'success');
        });
    </script>
@endif

<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Kelola Video</h3>
        </div>

        <form method="POST" action="{{ route('admin.video.storeOrUpdate') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="title" class="form-label">Judul Video</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                        name="title" id="title" value="{{ old('title', $video->title ?? '') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="description" class="form-label">Deskripsi Singkat</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3">{{ old('description', $video->description ?? '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Jenis Video</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="type_youtube" value="youtube" {{ old('type', $video->type ?? 'youtube') == 'youtube' ? 'checked' : '' }}>
                            <label class="form-check-label" for="type_youtube">YouTube</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="type_mp4" value="mp4" {{ old('type', $video->type ?? '') == 'mp4' ? 'checked' : '' }}>
                            <label class="form-check-label" for="type_mp4">Upload MP4</label>
                        </div>
                    </div>
                </div>
            </div>

            <div id="youtube_input" class="row {{ old('type', $video->type ?? 'youtube') == 'youtube' ? '' : 'd-none' }}">
                <div class="col-md-12 mb-3">
                    <label for="path" class="form-label">Link YouTube</label>
                    <input type="text" class="form-control @error('path') is-invalid @enderror"
                        name="path" id="path" placeholder="Contoh: https://www.youtube.com/watch?v=dQw4w9WgXcQ" value="{{ old('path', ($video->type ?? '') == 'youtube' ? 'https://www.youtube.com/watch?v=' . $video->path : '') }}">
                    @error('path')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div id="mp4_input" class="row {{ old('type', $video->type ?? '') == 'mp4' ? '' : 'd-none' }}">
                <div class="col-md-12 mb-3">
                    <label for="video_file" class="form-label">File Video (MP4, maks 20MB)</label>
                    <input type="file" class="form-control @error('video_file') is-invalid @enderror" name="video_file" id="video_file" accept="video/mp4">
                    @if (($video->type ?? '') == 'mp4' && $video->path)
                        <div class="form-text text-muted mt-2">Video saat ini: <a href="{{ asset('storage/' . $video->path) }}" target="_blank">Lihat File</a></div>
                    @endif
                    @error('video_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan Video</button>
            </div>
        </form>
    </div>
</div>

@if($video)
<div class="table-data mt-4">
    <div class="order">
        <div class="head">
            <h3>Video Aktif Saat Ini</h3>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Tipe</th>
                    <th>Path/ID</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $video->title }}</td>
                    <td><span class="badge bg-primary">{{ strtoupper($video->type) }}</span></td>
                    <td style="word-break: break-all;">{{ $video->path }}</td>
                    <td>
                        <button class="btn btn-info btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#videoPreviewModal"
                                data-video-type="{{ $video->type }}"
                                data-video-path="{{ $video->type == 'mp4' ? asset('storage/' . $video->path) : $video->path }}"
                                data-video-title="{{ $video->title }}">
                            <i class='bx bx-play-circle'></i> Preview
                        </button>
                        <form action="{{ route('admin.video.destroy') }}" method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm delete-btn">
                                <i class='bx bxs-trash'></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="videoPreviewModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">Preview Video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div id="video-player-container" class="ratio ratio-16x9"></div>
            </div>
        </div>
    </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Script untuk toggle form ---
    const typeYoutube = document.getElementById('type_youtube');
    const typeMp4 = document.getElementById('type_mp4');
    const youtubeInput = document.getElementById('youtube_input');
    const mp4Input = document.getElementById('mp4_input');

    function toggleInputs() {
        if (typeYoutube.checked) {
            youtubeInput.classList.remove('d-none');
            mp4Input.classList.add('d-none');
        } else {
            youtubeInput.classList.add('d-none');
            mp4Input.classList.remove('d-none');
        }
    }

    typeYoutube.addEventListener('change', toggleInputs);
    typeMp4.addEventListener('change', toggleInputs);

    // --- Script untuk modal preview video ---
    const videoModal = document.getElementById('videoPreviewModal');
    if(videoModal) {
        const videoPlayerContainer = document.getElementById('video-player-container');
        const modalTitle = videoModal.querySelector('.modal-title');

        videoModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const type = button.dataset.videoType;
            const path = button.dataset.videoPath;
            const title = button.dataset.videoTitle;
            
            modalTitle.textContent = title; // Update judul modal
            let playerHtml = '';

            if (type === 'youtube') {
                playerHtml = `<iframe src="https://www.youtube.com/embed/${path}?autoplay=1&rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
            } else if (type === 'mp4') {
                playerHtml = `<video controls autoplay style="width: 100%; height: 100%;"><source src="${path}" type="video/mp4">Browser Anda tidak mendukung tag video.</video>`;
            }

            videoPlayerContainer.innerHTML = playerHtml;
        });

        videoModal.addEventListener('hidden.bs.modal', function () {
            // Hentikan video saat modal ditutup
            videoPlayerContainer.innerHTML = '';
        });
    }
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: 'Anda Yakin?',
                text: "Video ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

@endsection