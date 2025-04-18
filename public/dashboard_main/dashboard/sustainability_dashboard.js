// Program studi for each fakultas based on the Excel data
const prodisByFaculty = {
    'pascasarjana': [
       
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
        'S1 Ilmu Komunikasi', 
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
        prodis.forEach(prodi => {
            const option = document.createElement('option');
            option.value = prodi;
            option.textContent = prodi;
            prodiSelect.appendChild(option);
        });
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
        prodis.forEach(prodi => {
            const option = document.createElement('option');
            option.value = prodi;
            option.textContent = prodi;
            prodiSelect.appendChild(option);
        });
    } else {
        prodiSelect.disabled = true;
    }
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

// Handle view photos
document.querySelectorAll('.view-photos').forEach(button => {
    button.addEventListener('click', function() {
        const photos = JSON.parse(this.dataset.photos);
        const gallery = document.getElementById('photoGallery');
        gallery.innerHTML = '';
        
        photos.forEach(path => {
            const img = document.createElement('img');
            img.src = `/storage/${path}`;
            img.classList.add('img-fluid', 'mb-3');
            img.style.maxHeight = '500px';
            gallery.appendChild(img);
        });
        
        new bootstrap.Modal(document.getElementById('photoModal')).show();
    });
});

// Initialize all functionality when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
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
    
    // Handle edit button clicks
    document.querySelectorAll('.edit-activity').forEach(button => {
        button.addEventListener('click', function() {
            // Get data attributes
            const activityId = this.dataset.id;
            
            // Populate edit form with data attributes
            document.getElementById('edit_judul_kegiatan').value = this.dataset.judul;
            document.getElementById('edit_tanggal_kegiatan').value = this.dataset.tanggal;
            document.getElementById('edit_fakultas').value = this.dataset.fakultas;
            document.getElementById('edit_link_kegiatan').value = this.dataset.link || '';
            document.getElementById('edit_deskripsi_kegiatan').value = this.dataset.deskripsi;
            
            // Load prodi options based on selected fakultas
            const prodiSelect = document.getElementById('edit_prodi');
            prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
            
            if (this.dataset.fakultas) {
                prodiSelect.disabled = false;
                const prodis = prodisByFaculty[this.dataset.fakultas];
                if (prodis) {
                    prodis.forEach(prodi => {
                        const option = document.createElement('option');
                        option.value = prodi;
                        option.textContent = prodi;
                        prodiSelect.appendChild(option);
                    });
                }
                
                // Set the selected prodi
                prodiSelect.value = this.dataset.prodi;
            }
            
            // Set form action
            document.getElementById('edit-form').action = `/admin/sustainability/${activityId}`;
            
            // Show the modal
            new bootstrap.Modal(document.getElementById('editModal')).show();
        });
    });
    
    // Handle delete button clicks
    document.querySelectorAll('.delete-activity').forEach(button => {
        button.addEventListener('click', function() {
            const activityId = this.dataset.id;
            const activityTitle = this.dataset.judul;
            
            showConfirmationDialog(`Apakah Anda yakin ingin menghapus kegiatan "${activityTitle}"?`, () => {
                const deleteForm = document.getElementById('delete-form');
                deleteForm.action = `/admin/sustainability/${activityId}`;
                deleteForm.submit();
            });
        });
    });
});