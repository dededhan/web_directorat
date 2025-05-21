@extends('admin.admin')

<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/matakuliah_dashboard.css') }}">


@section('contentadmin')
<div class="head-title">
    <div class="left">
        <h1>Aktivitas Dosen Asing</h1>
        <ul class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="#">Kelola Aktivitas</a></li>
        </ul>
    </div>
</div>

<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Input Aktivitas Baru</h3>
        </div>

        <form method="POST" action="{{ route($routePrefix . '.international-activities.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal"
                        id="tanggal" value="{{ old('tanggal') }}">
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text text-muted">Pilih tanggal publikasi activity</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="judul_berita" class="form-label">Judul activity</label>
                    <input type="text" class="form-control @error('judul_berita') is-invalid @enderror"
                        name="judul_berita" id="judul_berita" value="{{ old('judul_berita') }}">
                    @error('judul_berita')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text text-muted">Masukkan judul berita (maksimal 200 karakter)</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="isi_berita" class="form-label">Isi Berita</label>
                    <textarea class="form-control @error('isi_berita') is-invalid @enderror" name="isi_berita" id="isi_berita"
                        rows="8">{{ old('isi_berita') }}</textarea>
                    @error('isi_berita')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text text-muted">Tuliskan isi berita secara lengkap dan detail</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="gambar" class="form-label">Cover Gambar</label>
                    <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar"
                        id="gambar" accept="image/*">
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text text-muted">Upload gambar cover berita (format: JPG, PNG, atau JPEG, max 2MB)
                    </div>
                </div>
            </div>

            <div class="mb-3 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan Aktivitas</button>
            </div>
        </form>
    </div>

    <!-- Table List -->
    <div class="table-data mt-4">
        <div class="order">
            <div class="head">
                <h3>Daftar Aktivitas</h3>
            </div>

            <div class="table-responsive">
                <table class="table table-striped" id="aktivitas-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Judul Activitas</th>
                            <th>Isi</th>
                            <th>Cover Gambar</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activities as $index => $activity)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $activity->tanggal }}</td>
                                <td>{{ $activity->judul }}</td>
                                <td>{{ Str::limit(strip_tags($activity->isi), 50) }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info view-image"
                                        data-image="{{ asset('storage/' . $activity->gambar) }}"
                                        data-title="{{ $activity->judul }}">
                                        Lihat Gambar
                                    </button>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-warning edit-activity"
                                            data-id="{{ $activity->id }}">
                                            Edit
                                        </button>
                                        <form method="POST"
                                            action="{{ route($routePrefix . '.international-activities.destroy', $activity->id) }}"
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
        </div>
    </div>
</div>
{{-- modal --}}
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Gambar Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Gambar Berita">
            </div>
        </div>
    </div>
</div>
<!-- Include similar modals and scripts as in your news form -->

 <!-- Modal untuk mengedit berita -->
 <div class="modal fade" id="editActivityModal" tabindex="-1" aria-labelledby="editActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editActivityModalLabel">Edit Aktivitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editActivityForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" id="edit_tanggal">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="edit_judul_berita" class="form-label">Judul Aktivitas</label>
                            <input type="text" class="form-control" name="judul_berita" id="edit_judul_berita">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="edit_isi_berita" class="form-label">Isi Aktivitas</label>
                            <textarea class="form-control" name="isi_berita" id="edit_isi_berita" rows="8"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="edit_gambar" class="form-label">Gambar Baru (opsional)</label>
                            <input type="file" class="form-control" name="gambar" id="edit_gambar" accept="image/*">
                            <div class="mt-2">
                                <p>Gambar saat ini:</p>
                                <img id="current_image" src="" class="img-fluid mt-2" style="max-height: 200px;" alt="Current Image">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveEditActivity">Simpan Perubahan</button>
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
</script>

{{-- <script src="{{ asset('dashboard_main/dashboard/berita_dashboard.js') }}"></script> --}}

<script>
 // Custom upload adapter needs to be defined inline to access Blade variables
 class MyUploadAdapter {
     constructor(loader) {
         this.loader = loader;
     }

     upload() {
         return this.loader.file.then(file => new Promise((resolve, reject) => {
             const data = new FormData();
             data.append('upload', file);
             data.append('_token', '{{ csrf_token() }}');

             fetch('{{ route($routePrefix . '.news.upload') }}', {
                     method: 'POST',
                     body: data
                 })
                 .then(response => response.json())
                 .then(result => {
                     if (result.error) {
                         return reject(result.error.message);
                     }
                     resolve({
                         default: result.url
                     });
                 })
                 .catch(error => {
                     reject('Upload failed: ' + error.message);
                 });
         }));
     }

     abort() {
         return Promise.reject();
     }
 }

 function MyCustomUploadAdapterPlugin(editor) {
     editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
         return new MyUploadAdapter(loader);
     };
 }

 // Initialize CKEditor for new berita
 // Initialize CKEditor for new berita
ClassicEditor
.create(document.querySelector('#isi_berita'), {
 licenseKey: 'GPL',
 extraPlugins: [MyCustomUploadAdapterPlugin],
 toolbar: {
     items: [
         // Text formatting
         'heading', '|',
         'bold', 'italic', 'underline', 'strikethrough', '|',
         'fontColor', 'fontBackgroundColor', '|',
         'alignment', '|',
         'subscript', 'superscript', '|',
         
         // Paragraph formatting
         'indent', 'outdent', '|',
         
         // Lists
         'bulletedList', 'numberedList', '|',
         
         // Media and links
         'imageUpload', 'mediaEmbed', 'link', '|',
         
         // Block elements
         'blockQuote', 'insertTable', 'codeBlock', 'htmlEmbed', 'horizontalLine', '|',
         
         // Special characters
         'specialCharacters', 'emoji', '|',
         
         // Utility
         'undo', 'redo', 'findAndReplace', '|',
         
         // Source editing
         'sourceEditing'
     ],
     shouldNotGroupWhenFull: true
 },
 image: {
     toolbar: [
         'imageTextAlternative',
         'toggleImageCaption',
         'imageStyle:inline',
         'imageStyle:block', 
         'imageStyle:side',
         'linkImage'
     ],
     styles: [
         'full',
         'side',
         'alignLeft',
         'alignCenter',
         'alignRight'
     ],
     resizeOptions: [
         {
             name: 'resizeImage:original',
             label: 'Original',
             value: null
         },
         {
             name: 'resizeImage:50',
             label: '50%',
             value: '50'
         },
         {
             name: 'resizeImage:75',
             label: '75%',
             value: '75'
         }
     ]
 },
 table: {
     contentToolbar: [
         'tableColumn',
         'tableRow',
         'mergeTableCells',
         'tableCellProperties',
         'tableProperties'
     ]
 },
 link: {
     defaultProtocol: 'https://',
     decorators: {
         openInNewTab: {
             mode: 'manual',
             label: 'Open in a new tab',
             attributes: {
                 target: '_blank',
                 rel: 'noopener noreferrer'
             }
         }
     }
 },
 heading: {
     options: [
         { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
         { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
         { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
         { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
         { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
         { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
         { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
     ]
 },
 fontColor: {
     colors: [
         { color: 'hsl(0, 0%, 0%)', label: 'Black' },
         { color: 'hsl(0, 0%, 30%)', label: 'Dim grey' },
         { color: 'hsl(0, 0%, 60%)', label: 'Grey' },
         { color: 'hsl(0, 0%, 90%)', label: 'Light grey' },
         { color: 'hsl(0, 0%, 100%)', label: 'White' },
         { color: 'hsl(0, 75%, 60%)', label: 'Red' },
         { color: 'hsl(30, 75%, 60%)', label: 'Orange' },
         { color: 'hsl(60, 75%, 60%)', label: 'Yellow' },
         { color: 'hsl(90, 75%, 60%)', label: 'Light green' },
         { color: 'hsl(120, 75%, 60%)', label: 'Green' },
         { color: 'hsl(150, 75%, 60%)', label: 'Aquamarine' },
         { color: 'hsl(180, 75%, 60%)', label: 'Turquoise' },
         { color: 'hsl(210, 75%, 60%)', label: 'Light blue' },
         { color: 'hsl(240, 75%, 60%)', label: 'Blue' },
         { color: 'hsl(270, 75%, 60%)', label: 'Purple' }
     ]
 },
 fontBackgroundColor: {
     colors: [
         { color: 'hsl(0, 0%, 0%)', label: 'Black' },
         { color: 'hsl(0, 0%, 30%)', label: 'Dim grey' },
         { color: 'hsl(0, 0%, 60%)', label: 'Grey' },
         { color: 'hsl(0, 0%, 90%)', label: 'Light grey' },
         { color: 'hsl(0, 0%, 100%)', label: 'White' },
         { color: 'hsl(0, 75%, 60%)', label: 'Red' },
         { color: 'hsl(30, 75%, 60%)', label: 'Orange' },
         { color: 'hsl(60, 75%, 60%)', label: 'Yellow' },
         { color: 'hsl(90, 75%, 60%)', label: 'Light green' },
         { color: 'hsl(120, 75%, 60%)', label: 'Green' },
         { color: 'hsl(150, 75%, 60%)', label: 'Aquamarine' },
         { color: 'hsl(180, 75%, 60%)', label: 'Turquoise' },
         { color: 'hsl(210, 75%, 60%)', label: 'Light blue' },
         { color: 'hsl(240, 75%, 60%)', label: 'Blue' },
         { color: 'hsl(270, 75%, 60%)', label: 'Purple' }
     ]
 },
 htmlEmbed: {
     showPreviews: true
 },
 mention: {
     feeds: [
         {
             marker: '@',
             feed: ['@alice', '@bob', '@charlie']
         }
     ]
 },
 placeholder: 'Type or paste your content here...',
 typing: {
     transformations: {
         include: [
             'quotes',
             'typography',
             'symbols',
             'mathematical',
             'arrows'
         ]
     }
 },
 language: 'en'
})
.then(editor => {
 console.log('Editor initialized successfully', editor);
 window.editor = editor;
})
.catch(error => {
 console.error('Error initializing editor:', error);
});
 // Initialize CKEditor for edit form
 let editBeritaEditor;
 ClassicEditor
     .create(document.querySelector('#edit_isi_berita'), {
         extraPlugins: [MyCustomUploadAdapterPlugin],
         toolbar: {
             items: [
                 'heading', '|',
                 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                 'imageUpload', 'blockQuote', 'undo', 'redo'
             ]
         },
         image: {
             toolbar: ['imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side']
         }
     })
     .then(editor => {
         editBeritaEditor = editor;
     })
     .catch(error => {
         console.error(error);
     });

     

 document.addEventListener('DOMContentLoaded', function() {
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

             showConfirmationDialog('Apakah Anda yakin ingin menghapus berita ini?', () => {
                 form.submit();
             });
         });
     });

     // Handle edit button clicks
     // Handle edit button clicks
     document.addEventListener('click', function(e) {
        if (e.target.classList.contains('edit-activity')) {
            const activityId = e.target.dataset.id;
            const routePrefix = '{{ $routePrefix }}';

            // Fetch activity details via AJAX
            fetch(`/${routePrefix.replace('.', '/')}/international-activities/${activityId}/detail`)

                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Populate the edit form
                    document.getElementById('edit_tanggal').value = data.tanggal;
                    document.getElementById('edit_judul_berita').value = data.judul;
                    document.getElementById('edit_isi_berita').value = data.isi;

                    // Set the current image
                    const currentImage = document.getElementById('current_image');
                    currentImage.src = `/storage/${data.gambar}`;

                    // Set the form action
                    const form = document.getElementById('editActivityForm');
                    form.action = `/${routePrefix.replace('.', '/')}/international-activities/${activityId}`;

                    // Show the modal
                    const editModal = new bootstrap.Modal(document.getElementById('editActivityModal'));
                    editModal.show();
                })
                .catch(error => {
                    console.error('Error fetching activity details:', error);
                    showErrorAlert('Gagal mengambil data aktivitas.');
                });
        }
    });

    // Handle save button click - CORRECTED VERSION
    document.getElementById('saveEditActivity').addEventListener('click', function() {
        const form = document.getElementById('editActivityForm');
        const formData = new FormData(form);

        fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const modalElement = document.getElementById('editActivityModal');
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    modal.hide();

                    showSuccessAlert(data.message || 'Aktivitas berhasil diperbarui!');
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    showErrorAlert(data.message || 'Gagal menyimpan perubahan.');
                }
            })
            .catch(error => {
                console.error('Error saving activity:', error);
                showErrorAlert('Gagal menyimpan perubahan.');
            });
    });
});
    


</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection