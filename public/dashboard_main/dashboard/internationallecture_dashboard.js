// Program studi for each fakultas based on the sustainability data
const prodisByFaculty = {
    'pascasarjana': [
        'S3 Penelitian Dan Evaluasi Pendidikan', 
        'S2 Penelitian Dan Evaluasi Pendidikan', 
        'S2 Manajemen Lingkungan', 
        'S3 Ilmu Manajemen', 
        'S3 Manajemen Pendidikan', 
        'S3 Pendidikan Dasar', 
        'S2 Linguistik Terapan', 
        'S3 Pendidikan Kependudukan Dan Lingkungan Hidup', 
        'S2 Pendidikan Lingkungan', 
        'S3 Pendidikan Jasmani', 
        'S3 Teknologi Pendidikan', 
        'S3 Linguistik Terapan', 
        'S3 Pendidikan Anak Usia Dini', 
        'S2 Manajemen Pendidikan Tinggi'
    ],
    'fip': [
        'S2 Bimbingan Konseling', 
        'S1 Bimbingan Dan Konseling', 
        'S1 Pendidikan Luar Biasa', 
        'S1 Manajemen Pendidikan', 
        'S1 Pendidikan Masyarakat', 
        'S1 Pendidikan Guru Pendidikan Anak Usia Dini', 
        'S2 Pendidikan Dasar', 
        'S2 Teknologi Pendidikan', 
        'S1 Pendidikan Guru Sekolah Dasar', 
        'S1 Teknologi Pendidikan', 
        'S2 Pendidikan Masyarakat', 
        'S2 Pendidikan Khusus', 
        'S1 Perpustakaan dan Sains Informasi'
    ],
    'fmipa': [
        'S1 Kimia', 
        'S1 Statistika', 
        'S1 Matematika', 
        'S1 Pendidikan Matematika', 
        'S1 Biologi', 
        'S1 Ilmu Komputer', 
        'S1 Fisika', 
        'S2 Pendidikan Kimia', 
        'S2 Pendidikan Biologi', 
        'S2 Pendidikan Matematika', 
        'S1 Pendidikan Biologi', 
        'S1 Pendidikan Fisika', 
        'S1 Pendidikan Kimia', 
        'S2 Pendidikan Fisika'
    ],
    'fppsi': [
        'S1 Psikologi', 
        'S2 Psikologi'
    ],
    'fbs': [
        'S1 Pendidikan Musik', 
        'S1 Pendidikan Tari', 
        'S1 Pendidikan Seni Rupa', 
        'S1 Pendidikan Bahasa Jepang', 
        'S1 Sastra Indonesia', 
        'S1 Pendidikan Bahasa Dan Sastra Indonesia', 
        'S1 Pendidikan Bahasa Perancis', 
        'S1 Sastra Inggris', 
        'S1 Pendidikan Bahasa Jerman', 
        'S1 Pendidikan Bahasa Inggris', 
        'S2 Pendidikan Bahasa Inggris', 
        'S1 Pendidikan Bahasa Arab', 
        'S2 Pendidikan Bahasa Arab', 
        'S1 Pendidikan Bahasa Mandarin', 
        'S2 Pendidikan Seni'
    ],
    'ft': [
        'S1 Pendidikan Teknik Elektronika', 
        'D4 Kosmetik dan Perawatan Kecantikan', 
        'D4 Teknik Rekayasa Manufaktur', 
        'D4 Seni Kuliner dan Pengolahan Jasa Makanan', 
        'D4 Desain mode', 
        'D4 Manajemen Pelabuhan dan Logistik Maritim', 
        'S1 Pendidikan Teknik Informatika Dan Komputer', 
        'S1 Pendidikan Tata Boga', 
        'S1 Pendidikan Tata Busana', 
        'S1 Pendidikan Tata Rias', 
        'S1 Pendidikan Kesejahteraan Keluarga', 
        'S2 Pendidikan Teknologi Dan Kejuruan', 
        'S1 Pendidikan Teknik Bangunan', 
        'S1 Pendidikan Teknik Elektro', 
        'S1 Pendidikan Teknik Mesin', 
        'D4 Teknik Rekayasa Otomasi', 
        'D4 Teknologi Rekayasa Konstruksi Bangunan Gedung', 
        'S1 Rekayasa Keselamatan Kebakaran', 
        'S1 Teknik Mesin', 
        'S1 Sistem dan Teknologi Informasi'
    ],
    'fik': [
        'S1 Ilmu Keolahragaan', 
        'S1 Pendidikan Kepelatihan Olahraga', 
        'S1 Pendidikan Jasmani, Kesehatan Dan Rekreasi', 
        'S2 Pendidikan Jasmani', 
        'S1 Kepelatihan Kecabangan Olahraga', 
        'S1 Olahraga Rekreasi', 
        'S2 Ilmu Keolahragaan'
    ],
    'fis': [
        'D4 Usaha Perjalanan Wisata', 
        'S1 Sosiologi', 
        'S1 Pendidikan Agama Islam', 
        'S1 Pendidikan Sosiologi', 
        'S2 Pendidikan Sejarah', 
        'D4 Hubungan Masyarakat dan Komunikasi Digital', 
        'S1 Pendidikan Pancasila Dan Kewarganegaraan', 
        'S1 Pendidikan Geografi', 
        'S1 Pendidikan IPS', 
        'S1 Pendidikan Sejarah', 
        'S1 Ilmu Komunikasi (ILKOM)', 
        'S1 Geografi', 
        'S2 Pendidikan Geografi', 
        'S2 Pendidikan Pancasila Dan Kewarganegaraan'
    ],
    'fe': [
        'D4 Akuntansi Sektor Publik', 
        'D4 Administrasi Perkantoran Digital', 
        'D4 Pemasaran Digital', 
        'S1 Akuntansi', 
        'S1 Manajemen', 
        'S1 Pendidikan Ekonomi', 
        'S2 Manajemen', 
        'S1 Pendidikan Administrasi Perkantoran', 
        'S1 Bisnis Digital', 
        'S2 Akuntansi', 
        'S1 Pendidikan Akuntansi', 
        'S2 Pendidikan Ekonomi', 
        'S1 Pendidikan Bisnis'
    ],
    'profesi': [
        'Profesi PPG'
    ]
};

// Faculty change handler for add form
document.getElementById('fakultas').addEventListener('change', function() {
    const prodiSelect = document.getElementById('prodi');
    prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
    
    if (this.value) {
        prodiSelect.disabled = false;
        const prodis = prodisByFaculty[this.value];
        if (prodis) {
            prodis.forEach(prodi => {
                const option = document.createElement('option');
                option.value = prodi.toLowerCase().replace(/ /g, '_');
                option.textContent = prodi;
                prodiSelect.appendChild(option);
            });
        }
    } else {
        prodiSelect.disabled = true;
    }
});

// Faculty change handler for edit form
document.getElementById('edit_fakultas').addEventListener('change', function() {
    const prodiSelect = document.getElementById('edit_prodi');
    prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
    
    if (this.value) {
        prodiSelect.disabled = false;
        const prodis = prodisByFaculty[this.value];
        if (prodis) {
            prodis.forEach(prodi => {
                const option = document.createElement('option');
                option.value = prodi.toLowerCase().replace(/ /g, '_');
                option.textContent = prodi;
                prodiSelect.appendChild(option);
            });
        }
    } else {
        prodiSelect.disabled = true;
    }
});

// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchText = this.value.toLowerCase();
    const rows = document.querySelector('#lecture-table tbody').getElementsByTagName('tr');

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
    
    // Handle delete button clicks
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            
            showConfirmationDialog('Apakah Anda yakin ingin menghapus data dosen ini?', () => {
                form.submit();
            });
        });
    });
    
    // Handle edit button clicks
    document.querySelectorAll('.edit-dosen').forEach(button => {
        button.addEventListener('click', function() {
            const dosenId = this.dataset.id;

            // Fetch dosen details via AJAX
            fetch(`/admin/internationallecture/${dosenId}/detail`)
                .then(response => response.json())
                .then(data => {
                    // Populate the edit form
                    document.getElementById('edit_fakultas').value = data.fakultas;
                    
                    // Load the prodi options based on the selected fakultas
                    const prodiSelect = document.getElementById('edit_prodi');
                    prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
                    
                    if (data.fakultas) {
                        prodiSelect.disabled = false;
                        const prodis = prodisByFaculty[data.fakultas];
                        if (prodis) {
                            prodis.forEach(prodi => {
                                const option = document.createElement('option');
                                option.value = prodi.toLowerCase().replace(/ /g, '_');
                                option.textContent = prodi;
                                prodiSelect.appendChild(option);
                            });
                        }
                        
                        // Set the selected prodi
                        prodiSelect.value = data.prodi;
                    }
                    
                    document.getElementById('edit_nama').value = data.nama;
                    document.getElementById('edit_negara').value = data.negara;
                    document.getElementById('edit_universitas_asal').value = data.universitas_asal;
                    document.getElementById('edit_status').value = data.status;
                    document.getElementById('edit_bidang_keahlian').value = data.bidang_keahlian;

                    // Set the form action
                    const form = document.getElementById('editDosenForm');
                    form.action = `/admin/internationallecture/${dosenId}`;

                    // Show the modal
                    new bootstrap.Modal(document.getElementById('editDosenModal')).show();
                })
                .catch(error => {
                    console.error('Error fetching dosen details:', error);
                    showErrorAlert('Gagal mengambil data dosen.');
                });
        });
    });

    // Handle save button click
    document.getElementById('saveEditDosen').addEventListener('click', function() {
        const form = document.getElementById('editDosenForm');
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
                bootstrap.Modal.getInstance(document.getElementById('editDosenModal'))
                    .hide();

                // Show success message
                showSuccessAlert(data.message || 'Data dosen berhasil diperbarui!');
                
                // Refresh the page after a short delay
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showErrorAlert(data.message || 'Gagal menyimpan perubahan.');
            }
        })
        .catch(error => {
            console.error('Error saving dosen data:', error);
            showErrorAlert('Gagal menyimpan perubahan.');
        });
    });
});