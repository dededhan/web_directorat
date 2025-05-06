@extends('admin.admin')
<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/alumniberdampak_dashboard.css') }}">
@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Alumni Berdampak</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Input Berita Alumni Berdampak</a>
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
                <h3>Input Berita Alumni Berdampak</h3>
            </div> 

            <form id="alumni-form" action="{{ route('admin.alumniberdampak.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="judul_berita" class="form-label">Judul Berita/Artikel</label>
                        <input type="text" class="form-control" name="judul_berita" id="judul_berita">
                        <div class="form-text text-muted">Masukkan judul berita/artikel sesuai dengan sumber aslinya. Pastikan judul mencerminkan dampak alumni terhadap sustainability</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_berita" class="form-label">Tanggal Berita/Artikel</label>
                        <input type="date" class="form-control" name="tanggal_berita" id="tanggal_berita">
                        <div class="form-text text-muted">Pilih tanggal publikasi berita/artikel asli</div>
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
                            <option value="fppsi">FPsi</option>
                            <option value="fbs">FBS</option>
                            <option value="ft">FT</option>
                            <option value="fik">FIK</option>
                            <option value="fis">FISH</option>
                            <option value="fe">FEB</option>
                            <option value="profesi">PROFESI</option>
                        </select>
                        <div class="form-text text-muted">Pilih fakultas asal alumni yang bersangkutan</div>
                    </div>
                    {{-- <div class="col-md-6 mb-3">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select" name="prodi" id="prodi" disabled>
                            <option value="">Pilih Program Studi</option>
                        </select>
                        <div class="form-text text-muted">Pilih program studi asal alumni yang bersangkutan</div>
                    </div> --}}
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="link_berita" class="form-label">Link Berita/Artikel</label>
                        <input type="url" class="form-control" name="link_berita" id="link_berita">
                        <div class="form-text text-muted">Masukkan link berita/artikel dari sumber terpercaya (media massa online, website resmi institusi, atau publikasi resmi lainnya)</div>
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
                    <h3>Daftar Berita Alumni Berdampak</h3>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="alumni-table">
                        <thead>
                            <tr>
                                <th>Judul Berita/Artikel</th>
                                <th>Tanggal</th>
                                <th>Fakultas</th>
                                {{-- <th>Program Studi</th> --}}
                                <th>Link</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="alumni-list">
                            @foreach($alumniBerdampak as $alumni)
                            <tr>
                                <td>{{ $alumni->judul_berita }}</td>
                                <td>{{ $alumni->tanggal_berita }}</td>
                                <td>{{ strtoupper($alumni->fakultas) }}</td>
                                {{-- <td>{{ $alumni->prodi }}</td> --}}
                                <td>
                                    <a href="{{ $alumni->link_berita }}" target="_blank" class="btn btn-sm btn-info">
                                        View Link
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-warning edit-alumni" 
                                                data-id="{{ $alumni->id }}"
                                                data-judul="{{ $alumni->judul_berita }}"
                                                data-tanggal="{{ $alumni->tanggal_berita }}"
                                                data-fakultas="{{ $alumni->fakultas }}"
                                                data-prodi="{{ $alumni->prodi }}"
                                                data-link="{{ $alumni->link_berita }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('admin.alumniberdampak.destroy', $alumni->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger delete-alumni">
                                                <i class="fas fa-trash"></i> Delete
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

    <div class="modal fade" id="editAlumniModal" tabindex="-1" role="dialog" aria-labelledby="editAlumniModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAlumniModalLabel">Edit Alumni Berdampak</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit-alumni-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_judul_berita" class="form-label">Judul Berita/Artikel</label>
                                <input type="text" class="form-control" name="judul_berita" id="edit_judul_berita">
                                <div class="form-text text-muted">Masukkan judul berita/artikel sesuai dengan sumber aslinya</div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_tanggal_berita" class="form-label">Tanggal Berita/Artikel</label>
                                <input type="date" class="form-control" name="tanggal_berita" id="edit_tanggal_berita">
                                <div class="form-text text-muted">Pilih tanggal publikasi berita/artikel asli</div>
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
                                <div class="form-text text-muted">Pilih fakultas asal alumni yang bersangkutan</div>
                            </div>
                            {{-- <div class="col-md-6 mb-3">
                                <label for="edit_prodi" class="form-label">Program Studi</label>
                                <select class="form-select" name="prodi" id="edit_prodi">
                                    <option value="">Pilih Program Studi</option>
                                </select>
                                <div class="form-text text-muted">Pilih program studi asal alumni yang bersangkutan</div>
                            </div> --}}
                        </div>
    
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_link_berita" class="form-label">Link Berita/Artikel</label>
                                <input type="url" class="form-control" name="link_berita" id="edit_link_berita">
                                <div class="form-text text-muted">Masukkan link berita/artikel dari sumber terpercaya</div>
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
    
    <!-- Include Bootstrap JS and SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('dashboard_main/dashboard/alumniberdampak_dashboard.js') }}"></script>

    <script>
        // Program studi options
        const prodiOptions = {
            'pascasarjana': ['S3 Penelitian Dan Evaluasi Pendidikan', 'S2 Penelitian Dan Evaluasi Pendidikan', 'S2 Manajemen Lingkungan', 'S3 Ilmu Manajemen', 'S3 Manajemen Pendidikan', 'S3 Pendidikan Dasar', 'S2 Linguistik Terapan', 'S3 Pendidikan Kependudukan Dan Lingkungan Hidup', 'S2 Pendidikan Lingkungan', 'S3 Pendidikan Jasmani', 'S3 Teknologi Pendidikan', 'S3 Linguistik Terapan', 'S3 Pendidikan Anak Usia Dini', 'S2 Manajemen Pendidikan Tinggi'],
            'fip': ['S2 Bimbingan Konseling', 'S1 Bimbingan Dan Konseling', 'S1 Pendidikan Luar Biasa', 'S1 Manajemen Pendidikan', 'S1 Pendidikan Masyarakat', 'S1 Pendidikan Guru Pendidikan Anak Usia Dini', 'S2 Pendidikan Dasar', 'S2 Teknologi Pendidikan', 'S1 Pendidikan Guru Sekolah Dasar', 'S1 Teknologi Pendidikan', 'S2 Pendidikan Masyarakat', 'S2 Pendidikan Khusus', 'S1 Perpustakaan dan Sains Informasi'],
            'fmipa': ['S1 Kimia', 'S1 Statistika', 'S1 Matematika', 'S1 Pendidikan Matematika', 'S1 Biologi', 'S1 Ilmu Komputer', 'S1 Fisika', 'S2 Pendidikan Kimia', 'S2 Pendidikan Biologi', 'S2 Pendidikan Matematika', 'S1 Pendidikan Biologi', 'S1 Pendidikan Fisika', 'S1 Pendidikan Kimia', 'S2 Pendidikan Fisika'],
            'fppsi': ['S1 Psikologi', 'S2 Psikologi'],
            'fbs': ['S1 Pendidikan Musik', 'S1 Pendidikan Tari', 'S1 Pendidikan Seni Rupa', 'S1 Pendidikan Bahasa Jepang', 'S1 Sastra Indonesia', 'S1 Pendidikan Bahasa Dan Sastra Indonesia', 'S1 Pendidikan Bahasa Perancis', 'S1 Sastra Inggris', 'S1 Pendidikan Bahasa Jerman', 'S1 Pendidikan Bahasa Inggris', 'S2 Pendidikan Bahasa Inggris', 'S1 Pendidikan Bahasa Arab', 'S2 Pendidikan Bahasa Arab', 'S1 Pendidikan Bahasa Mandarin', 'S2 Pendidikan Seni'],
            'ft': ['S1 Pendidikan Teknik Elektronika', 'D4 Kosmetik dan Perawatan Kecantikan', 'D4 Teknik Rekayasa Manufaktur', 'D4 Seni Kuliner dan Pengolahan Jasa Makanan', 'D4 Desain mode', 'D4 Manajemen Pelabuhan dan Logistik Maritim', 'S1 Pendidikan Teknik Informatika Dan Komputer', 'S1 Pendidikan Tata Boga', 'S1 Pendidikan Tata Busana', 'S1 Pendidikan Tata Rias', 'S1 Pendidikan Kesejahteraan Keluarga', 'S2 Pendidikan Teknologi Dan Kejuruan', 'S1 Pendidikan Teknik Bangunan', 'S1 Pendidikan Teknik Elektro', 'S1 Pendidikan Teknik Mesin', 'D4 Teknik Rekayasa Otomasi', 'D4 Teknologi Rekayasa Konstruksi Bangunan Gedung', 'S1 Rekayasa Keselamatan Kebakaran', 'S1 Teknik Mesin', 'S1 Sistem dan Teknologi Informasi'],
            'fik': ['S1 Ilmu Keolahragaan', 'S1 Pendidikan Kepelatihan Olahraga', 'S1 Pendidikan Jasmani, Kesehatan Dan Rekreasi', 'S2 Pendidikan Jasmani', 'S1 Kepelatihan Kecabangan Olahraga', 'S1 Olahraga Rekreasi', 'S2 Ilmu Keolahragaan'],
            'fis': ['D4 Usaha Perjalanan Wisata', 'S1 Sosiologi', 'S1 Pendidikan Agama Islam', 'S1 Pendidikan Sosiologi', 'S2 Pendidikan Sejarah', 'D4 Hubungan Masyarakat dan Komunikasi Digital', 'S1 Pendidikan Pancasila Dan Kewarganegaraan', 'S1 Pendidikan Geografi', 'S1 Pendidikan IPS', 'S1 Pendidikan Sejarah', 'S1 Ilmu Komunikasi (ILKOM)', 'S1 Geografi', 'S2 Pendidikan Geografi', 'S2 Pendidikan Pancasila Dan Kewarganegaraan'],
            'fe': ['D4 Akuntansi Sektor Publik', 'D4 Administrasi Perkantoran Digital', 'D4 Pemasaran Digital', 'S1 Akuntansi', 'S1 Manajemen', 'S1 Pendidikan Ekonomi', 'S2 Manajemen', 'S1 Pendidikan Administrasi Perkantoran', 'S1 Bisnis Digital', 'S2 Akuntansi', 'S1 Pendidikan Akuntansi', 'S2 Pendidikan Ekonomi', 'S1 Pendidikan Bisnis'],
            'profesi': ['Profesi PPG']
        };
    
        // Update prodi options when fakultas changes
        function updateProdiOptions(fakultas, selectElement) {
            selectElement.innerHTML = '<option value="">Pilih Program Studi</option>';
            
            if (prodiOptions[fakultas]) {
                prodiOptions[fakultas].forEach(prodi => {
                    const option = document.createElement('option');
                    option.value = prodi;
                    option.textContent = prodi;
                    selectElement.appendChild(option);
                });
            }
        }
    
        // Handle fakultas change for create form
        document.getElementById('fakultas').addEventListener('change', function() {
            const prodiSelect = document.getElementById('prodi');
            prodiSelect.disabled = false;
            updateProdiOptions(this.value, prodiSelect);
        });
    
        // Handle edit button
        document.querySelectorAll('.edit-alumni').forEach(button => {
            button.addEventListener('click', function() {
                const alumniId = this.dataset.id;
                const modal = new bootstrap.Modal(document.getElementById('editAlumniModal'));
                
                // Populate form data
                document.getElementById('edit_judul_berita').value = this.dataset.judul;
                document.getElementById('edit_tanggal_berita').value = this.dataset.tanggal;
                document.getElementById('edit_fakultas').value = this.dataset.fakultas;
                document.getElementById('edit_link_berita').value = this.dataset.link;
                
                // Enable and populate prodi
                const editProdiSelect = document.getElementById('edit_prodi');
                editProdiSelect.disabled = false;
                updateProdiOptions(this.dataset.fakultas, editProdiSelect);
                editProdiSelect.value = this.dataset.prodi;
                
                // Set form action
                document.getElementById('edit-alumni-form').action = `/admin/alumniberdampak/${alumniId}`;
                
                // Show modal
                modal.show();
            });
        });
    
        // Handle fakultas change for edit form
        document.getElementById('edit_fakultas').addEventListener('change', function() {
            const prodiSelect = document.getElementById('edit_prodi');
            prodiSelect.disabled = false;
            updateProdiOptions(this.value, prodiSelect);
        });
    
        // Handle delete confirmation
        document.querySelectorAll('.delete-alumni').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: "Apakah Anda yakin ingin menghapus data alumni ini?",
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
    
        // Handle form submission feedback
        const editForm = document.getElementById('edit-alumni-form');
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                const submitButton = this.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
            });
        }
    </script>
    <script>
        // Program studi for each fakultas based on the sustainability_dashboard.js data
        

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