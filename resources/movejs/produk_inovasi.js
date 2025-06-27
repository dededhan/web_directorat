document.addEventListener('DOMContentLoaded', function() {
    // Create Form Submission with SweetAlert
    const createForm = document.querySelector('form[action*="produk_inovasi.store"]');
    if (createForm) {
        createForm.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menyimpan produk inovasi ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3498db',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Menyimpan...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit the form
                    this.submit();
                }
            });
        });
    }

    // Handle delete button clicks
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');

            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                text: 'Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3498db',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    form.submit();
                }
            });
        });
    });

    // Handle edit button clicks
    document.querySelectorAll('.edit-produk').forEach(button => {
        button.addEventListener('click', function() {
            const produkId = this.dataset.id;

            // Show loading state
            Swal.fire({
                title: 'Memuat Data...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Fetch produk details via AJAX
            fetch(`/admin/Katsinov/produk_inovasi/${produkId}/detail`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    Swal.close(); // Close loading dialog

                    // Populate the edit form
                    document.getElementById('edit_nama_produk').value = data
                    .nama_produk;
                    document.getElementById('edit_inovator').value = data.inovator;
                    document.getElementById('edit_nomor_paten').value = data
                        .nomor_paten || '';

                    // Set content to the CKEditor
                    if (editDeskripsiEditor) {
                        editDeskripsiEditor.setData(data.deskripsi);
                    }

                    // Set the current image
                    const currentImage = document.getElementById('current_image');
                    if (data.gambar) {
                        currentImage.src = `/storage/${data.gambar}`;
                        currentImage.style.display = 'block';
                    } else {
                        currentImage.style.display = 'none';
                    }

                    // Set the form action
                    const form = document.getElementById('editProdukForm');
                    form.action = `/admin/Katsinov/produk_inovasi/${produkId}`;

                    // Show the modal
                    const editModal = new bootstrap.Modal(document.getElementById(
                        'editProdukModal'));
                    editModal.show();
                })
                .catch(error => {
                    console.error('Error fetching produk details:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal mengambil data produk.',
                        icon: 'error',
                        confirmButtonColor: '#3498db'
                    });
                });
        });
    });

    // Handle save button click for edit form
    document.getElementById('saveEditProduk').addEventListener('click', function() {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menyimpan perubahan?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan Perubahan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Get the data from CKEditor and set it to the textarea
                const editorData = editDeskripsiEditor.getData();

                // Update textarea with editor content
                document.getElementById('edit_deskripsi').value = editorData;

                const form = document.getElementById('editProdukForm');
                const formData = new FormData(form);

                // Show loading state
                Swal.fire({
                    title: 'Menyimpan Perubahan...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Close the modal
                            const modalElement = document.getElementById(
                                'editProdukModal');
                            const modal = bootstrap.Modal.getInstance(modalElement);
                            modal.hide();

                            // Show success message
                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message ||
                                    'Produk berhasil diperbarui!',
                                icon: 'success',
                                confirmButtonColor: '#3498db'
                            }).then(() => {
                                // Reload the page
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: data.message ||
                                    'Gagal menyimpan perubahan.',
                                icon: 'error',
                                confirmButtonColor: '#3498db'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error saving produk:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal menyimpan perubahan.',
                            icon: 'error',
                            confirmButtonColor: '#3498db'
                        });
                    });
            }
        });
    });

    // Flash message handling
    const flashSuccess = "{{ session('success') }}";
    const flashError = "{{ session('error') }}";

    if (flashSuccess) {
        Swal.fire({
            title: 'Berhasil!',
            text: flashSuccess,
            icon: 'success',
            confirmButtonColor: '#3498db'
        });
    }

    if (flashError) {
        Swal.fire({
            title: 'Error!',
            text: flashError,
            icon: 'error',
            confirmButtonColor: '#3498db'
        });
    }
});