// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchText = this.value.toLowerCase();
    const rows = document.getElementById('students-list').getElementsByTagName('tr');

    Array.from(rows).forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchText) ? '' : 'none';
    });
});

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

// Initialize all functionality when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check for PHP flash messages
    if (document.body.dataset.successMessage) {
        showSuccessAlert(document.body.dataset.successMessage);
    }
    
    if (document.body.dataset.errorMessage) {
        showErrorAlert(document.body.dataset.errorMessage);
    }
    
    // Handle flash messages from session
    const successAlert = document.querySelector('.alert-success');
    if (successAlert) {
        showSuccessAlert(successAlert.textContent.trim());
        successAlert.remove();
    }
    
    const errorAlert = document.querySelector('.alert-danger');
    if (errorAlert) {
        showErrorAlert(errorAlert.textContent.trim());
        errorAlert.remove();
    }
    
    // Handle delete button clicks
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            
            showConfirmationDialog('Apakah Anda yakin ingin menghapus data mahasiswa ini?', () => {
                form.submit();
            });
        });
    });
    
    // Handle edit button clicks
    document.querySelectorAll('.edit-student').forEach(button => {
        button.addEventListener('click', function() {
            const studentId = this.dataset.id;

            // Fetch student details via AJAX
            fetch(`/admin/mahasiswainternational/${studentId}/detail`)
                .then(response => response.json())
                .then(data => {
                    // Populate the edit form
                    document.getElementById('edit_nama_mahasiswa').value = data.nama_mahasiswa;
                    document.getElementById('edit_nim').value = data.nim;
                    document.getElementById('edit_negara').value = data.negara;
                    document.getElementById('edit_kategori').value = data.kategori;
                    document.getElementById('edit_status').value = data.status;
                    document.getElementById('edit_fakultas').value = data.fakultas;
                    document.getElementById('edit_program_studi').value = data.program_studi;
                    document.getElementById('edit_periode_mulai').value = data.periode_mulai;
                    document.getElementById('edit_periode_akhir').value = data.periode_akhir;

                    // Set the form action
                    const form = document.getElementById('editStudentForm');
                    form.action = `/admin/mahasiswainternational/${studentId}`;

                    // Show the modal
                    new bootstrap.Modal(document.getElementById('editStudentModal')).show();
                })
                .catch(error => {
                    console.error('Error fetching student details:', error);
                    showErrorAlert('Gagal mengambil data mahasiswa.');
                });
        });
    });

    // Handle save button click
    document.getElementById('saveEditStudent')?.addEventListener('click', function() {
        const form = document.getElementById('editStudentForm');
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close the modal
                bootstrap.Modal.getInstance(document.getElementById('editStudentModal'))
                    .hide();

                // Show success message
                showSuccessAlert(data.message || 'Data mahasiswa berhasil diperbarui!');
                
                // Refresh the page after a short delay
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showErrorAlert(data.message || 'Gagal menyimpan perubahan.');
            }
        })
        .catch(error => {
            console.error('Error saving student data:', error);
            showErrorAlert('Gagal menyimpan perubahan.');
        });
    });
});