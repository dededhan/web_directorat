// Custom upload adapter
class MyUploadAdapter {
    constructor(loader) {
        this.loader = loader;
    }

    upload() {
        return this.loader.file.then(file => new Promise((resolve, reject) => {
            const data = new FormData();
            data.append('upload', file);
            data.append('_token', '{{ csrf_token() }}');

            fetch('{{ route("admin.news.upload") }}', {
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
ClassicEditor
    .create(document.querySelector('#isi_berita'), {
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
    .catch(error => {
        console.error(error);
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
    document.querySelectorAll('.edit-berita').forEach(button => {
        button.addEventListener('click', function() {
            const beritaId = this.dataset.id;

            // Fetch berita details via AJAX
            fetch(`/admin/berita/${beritaId}/detail`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Populate the edit form
                    document.getElementById('edit_kategori').value = data.kategori;
                    document.getElementById('edit_tanggal').value = data.tanggal;
                    document.getElementById('edit_judul_berita').value = data.judul;

                    // Set content to the CKEditor
                    if (editBeritaEditor) {
                        editBeritaEditor.setData(data.isi);
                    }

                    // Set the current image
                    const currentImage = document.getElementById('current_image');
                    currentImage.src = `/storage/${data.gambar}`;

                    // Set the form action
                    const form = document.getElementById('editBeritaForm');
                    form.action = `/admin/berita/${beritaId}`;

                    // Show the modal
                    const editModal = new bootstrap.Modal(document.getElementById('editBeritaModal'));
                    editModal.show();
                })
                .catch(error => {
                    console.error('Error fetching berita details:', error);
                    showErrorAlert('Gagal mengambil data berita.');
                });
        });
    });

    // Handle save button click
    document.getElementById('saveEditBerita').addEventListener('click', function() {
        const editorData = editBeritaEditor.getData();
        document.getElementById('edit_isi_berita').value = editorData;

        const form = document.getElementById('editBeritaForm');
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close the modal
                const modalElement = document.getElementById('editBeritaModal');
                const modal = bootstrap.Modal.getInstance(modalElement);
                modal.hide();

                // Show success message
                showSuccessAlert(data.message || 'Berita berhasil diperbarui!');
                
                // Refresh the page after a short delay
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showErrorAlert(data.message || 'Gagal menyimpan perubahan.');
            }
        })
        .catch(error => {
            console.error('Error saving berita:', error);
            showErrorAlert('Gagal menyimpan perubahan.');
        });
    });
});