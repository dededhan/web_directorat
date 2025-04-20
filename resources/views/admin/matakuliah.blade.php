@extends('admin.admin')

<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/matakuliah_dashboard.css') }}">

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Mata Kuliah Sustainability</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Input Mata Kuliah</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Alert Messages -->
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

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Mata Kuliah Sustainability</h3>
            </div> 

            <form id="matakuliah-form" action="{{ route('admin.matakuliah.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="nama_matkul" class="form-label">Nama Mata Kuliah</label>
                        <input type="text" class="form-control" name="nama_matkul" id="nama_matkul">
                        <div class="form-text text-muted">Masukkan nama lengkap mata kuliah sesuai dengan kurikulum</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="semester" class="form-label">Semester</label>
                        <input type="text" class="form-control" name="semester" id="semester">
                        <div class="form-text text-muted">Masukkan semester berapa mata kuliah ini diajarkan (contoh: 1, 2, 3, dst)</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="kode_matkul" class="form-label">Kode Mata Kuliah</label>
                        <input type="text" class="form-control" name="kode_matkul" id="kode_matkul">
                        <div class="form-text text-muted">Masukkan kode mata kuliah sesuai dengan kurikulum (contoh: MK001)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fakultas" class="form-label">Fakultas</label>
                        <select class="form-select" name="fakultas" id="fakultas">
                            <option value="">Pilih Fakultas</option>
                            <option value="pascasarjana">PASCASARJANA</option>
                            <option value="fip">FIP</option>
                            <option value="fmipa">FMIPA</option>
                            <option value="fppsi">FPPsi</option>
                            <option value="fbs">FBS</option>
                            <option value="ft">FT</option>
                            <option value="fik">FIK</option>
                            <option value="fis">FIS</option>
                            <option value="fe">FE</option>
                            <option value="profesi">PROFESI</option>
                        </select>
                        <div class="form-text text-muted">Pilih fakultas yang menyelenggarakan mata kuliah ini</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select" name="prodi" id="prodi" disabled>
                            <option value="">Pilih Program Studi</option>
                        </select>
                        <div class="form-text text-muted">Pilih program studi yang menyelenggarakan mata kuliah ini</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="rps" class="form-label">RPS Mata Kuliah</label>
                        <input type="file" class="form-control" name="rps" id="rps" accept=".pdf,.doc,.docx">
                        <div class="form-text text-muted">Upload dokumen RPS dalam format PDF, DOC, atau DOCX. Pastikan RPS sudah disetujui dan ditandatangani</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Mata Kuliah</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4"></textarea>
                        <div class="form-text text-muted">Deskripsikan mata kuliah secara lengkap (minimal 100 kata), termasuk tujuan pembelajaran, capaian pembelajaran, dan keterkaitan dengan sustainability</div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>

        <div class="table-data mt-4">
            <div class="order">
                <div class="head">
                    <h3>Daftar Mata Kuliah Sustainability</h3>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="matakuliah-table">
                        <thead>
                            <tr>
                                <th>Nama Mata Kuliah</th>
                                <th>Semester</th>
                                <th>Fakultas</th>
                                <th>Program Studi</th>
                                <th>RPS</th>
                                <th>Deskripsi</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="matakuliah-list">
                            @foreach($matakuliahs as $matakuliah)
                                <tr>
                                    <td>{{ $matakuliah->nama_matkul }}</td>
                                    <td>{{ $matakuliah->semester }}</td>
                                    <td>{{ ucfirst($matakuliah->fakultas) }}</td> {{-- Contoh konversi ke huruf kapital --}}
                                    <td>{{ $matakuliah->prodi }}</td>
                                    <td>
                                        <a href="{{ Storage::url($matakuliah->rps_path) }}" class="btn btn-sm btn-info">
                                            Download RPS
                                        </a>
                                    </td>
                                    <td>{{ Str::limit($matakuliah->deskripsi, 50) }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-warning edit-matakuliah" 
                                                    data-id="{{ $matakuliah->id }}"
                                                    data-nama="{{ $matakuliah->nama_matkul }}"
                                                    data-semester="{{ $matakuliah->semester }}"
                                                    data-kode="{{ $matakuliah->kode_matkul }}"
                                                    data-fakultas="{{ $matakuliah->fakultas }}"
                                                    data-prodi="{{ $matakuliah->prodi }}"
                                                    data-rps="{{ $matakuliah->rps_path }}"
                                                    data-deskripsi="{{ $matakuliah->deskripsi }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.matakuliah.destroy', $matakuliah->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger delete-matakuliah">
                                                    Delete
                                                </button>
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

    <!-- Edit Modal -->
    <div class="modal fade" id="editMatakuliahModal" tabindex="-1" role="dialog" aria-labelledby="editMatakuliahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMatakuliahModalLabel">Edit Mata Kuliah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit-matakuliah-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_nama_matkul" class="form-label">Nama Mata Kuliah</label>
                                <input type="text" class="form-control" name="nama_matkul" id="edit_nama_matkul">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_semester" class="form-label">Semester</label>
                                <input type="text" class="form-control" name="semester" id="edit_semester">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="edit_kode_matkul" class="form-label">Kode Mata Kuliah</label>
                                <input type="text" class="form-control" name="kode_matkul" id="edit_kode_matkul">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_fakultas" class="form-label">Fakultas</label>
                                <select class="form-select" name="fakultas" id="edit_fakultas">
                                    <option value="pascasarjana">PASCASARJANA</option>
                                    <option value="fip">FIP</option>
                                    <option value="fmipa">FMIPA</option>
                                    <option value="fppsi">FPPsi</option>
                                    <option value="fbs">FBS</option>
                                    <option value="ft">FT</option>
                                    <option value="fik">FIK</option>
                                    <option value="fis">FIS</option>
                                    <option value="fe">FE</option>
                                    <option value="profesi">PROFESI</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_prodi" class="form-label">Program Studi</label>
                                <select class="form-select" name="prodi" id="edit_prodi">
                                    <option value="">Pilih Program Studi</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_rps" class="form-label">RPS Mata Kuliah (Opsional)</label>
                                <input type="file" class="form-control" name="rps" id="edit_rps" accept=".pdf,.doc,.docx">
                                <div class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah file RPS</div>
                             
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_deskripsi" class="form-label">Deskripsi Mata Kuliah</label>
                                <textarea class="form-control" name="deskripsi" id="edit_deskripsi" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include jQuery if not already included -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/matakuliah_dashboard.css') }}">
    
    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('dashboard_main/dashboard/matakuliah_dashboard.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Handle edit button
document.querySelectorAll('.edit-matakuliah').forEach(button => {
    button.addEventListener('click', function() {
        const matkulId = this.dataset.id;
        const modal = new bootstrap.Modal(document.getElementById('editMatakuliahModal'));
        
        // Populate form data
        document.getElementById('edit_nama_matkul').value = this.dataset.nama;
        document.getElementById('edit_semester').value = this.dataset.semester;
        document.getElementById('edit_kode_matkul').value = this.dataset.kode;
        document.getElementById('edit_fakultas').value = this.dataset.fakultas;
        document.getElementById('edit_deskripsi').value = this.dataset.deskripsi;
        
        // Set prodi value and enable it
        const prodiSelect = document.getElementById('edit_prodi');
        prodiSelect.value = this.dataset.prodi;
        prodiSelect.disabled = false;
        
        
        
        // Set form action
        document.getElementById('edit-matakuliah-form').action = `/admin/matakuliah/${matkulId}`;
        
        // Show modal
        modal.show();
    });
});

// Handle delete confirmation
document.querySelectorAll('.delete-matakuliah').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('form');
        
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: "Apakah Anda yakin ingin menghapus mata kuliah ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

// Handle fakultas change for prodi selection
document.getElementById('edit_fakultas').addEventListener('change', function() {
    const prodiSelect = document.getElementById('edit_prodi');
    prodiSelect.disabled = false;
    updateProdiOptions(this.value, prodiSelect);
});

function updateProdiOptions(fakultas, selectElement) {
    // Clear existing options
    selectElement.innerHTML = '<option value="">Pilih Program Studi</option>';
    
    // Add options based on fakultas
    const prodiOptions = {
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
    
    if (prodiOptions[fakultas]) {
        prodiOptions[fakultas].forEach(prodi => {
            const option = document.createElement('option');
            option.value = prodi;
            option.textContent = prodi;
            selectElement.appendChild(option);
        });
    }
}
</script>

    <script>
        // Display SweetAlert for flash messages
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2000
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 2000
        });
    @endif
});
    </script>

    <style>
       
    </style>
@endsection