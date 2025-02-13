@extends('fakultas.index')

@section('contentfakultas')
    <div class="head-title">
        <div class="left">
            <h1>Sustainability</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Input Kegiatan Sustainability</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Kegiatan Sustainability</h3>
            </div> 

            <form id="sustainability-form" method="POST" action="{{ route('admin.sustainability.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="judul_kegiatan" class="form-label">Judul Kegiatan</label>
                        <input type="text" class="form-control" name="judul_kegiatan" id="judul_kegiatan">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_kegiatan" class="form-label">Tanggal Kegiatan</label>
                        <input type="date" class="form-control" name="tanggal_kegiatan" id="tanggal_kegiatan">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fakultas" class="form-label">Fakultas</label>
                        <select class="form-select" name="fakultas" id="fakultas">
                            <option value="">Pilih Fakultas</option>
                            <option value="fmipa">FMIPA</option>
                            <option value="fik">FIK</option>
                            <option value="ft">FT</option>
                            <option value="fbs">FBS</option>
                            <option value="fip">FIP</option>
                            <option value="fe">FE</option>
                            <option value="fis">FIS</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select" name="prodi" id="prodi" disabled>
                            <option value="">Pilih Program Studi</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="link_kegiatan" class="form-label">Link Kegiatan</label>
                        <input type="url" class="form-control" name="link_kegiatan" id="link_kegiatan">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="foto_kegiatan" class="form-label">Foto-foto Kegiatan</label>
                        <input type="file" class="form-control" name="foto_kegiatan" id="foto_kegiatan" multiple accept="image/*">
                        <small class="text-muted">You can select images</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi_kegiatan" class="form-label">Deskripsi Kegiatan</label>
                        <textarea class="form-control" name="deskripsi_kegiatan" id="deskripsi_kegiatan" rows="4"></textarea>
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
                    <h3>Daftar Kegiatan Sustainability</h3>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="sustainability-table">
                        <thead>
                            <tr>
                                <th>Judul Kegiatan</th>
                                <th>Tanggal</th>
                                <th>Fakultas</th>
                                <th>Program Studi</th>
                                <th>Link</th>
                                <th>Foto</th>
                                <th>Deskripsi</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sustainability-list">
                            @foreach($sustainabilities as $activity)
                            <tr>
                                <td>{{ $activity->judul_kegiatan }}</td>
                                <td>{{ $activity->tanggal_kegiatan}}</td>
                                <td>{{ strtoupper($activity->fakultas) }}</td>
                                <td>{{ $activity->prodi }}</td>
                                <td>
                                    @if($activity->link_kegiatan)
                                    <a href="{{ $activity->link_kegiatan }}" target="_blank">View Link</a>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info view-photos" 
                                        data-photos='@json($activity->photos->pluck('path'))'>
                                        View Photos ({{ $activity->photos->count() }})
                                    </button>
                                </td>
                                <td>{{ Str::limit($activity->deskripsi_kegiatan, 50) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-warning">Edit</button>
                                        <button class="btn btn-sm btn-danger">Delete</button>
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
    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="photoModalLabel">Foto Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="photoGallery">
                    <!-- Foto akan ditampilkan di sini -->
                </div>
            </div>
        </div>
    </div>
    <script>
        const prodisByFaculty = {
            'fmipa': ['Ilmu Komputer', 'Matematika', 'Pendidikan Matematika', 'Fisika', 'Pendidikan Fisika', 'Biologi', 'Pendidikan Biologi', 'Kimia', 'Pendidikan Kimia'],
            'fik': ['Pendidikan Teknologi Informasi', 'Pendidikan Teknik Elektronika', 'Pendidikan Teknik Elektro', 'Teknik Informatika dan Komputer'],
            'ft': ['Teknik Sipil', 'Teknik Mesin', 'Teknik Elektro', 'Pendidikan Teknik Bangunan', 'Pendidikan Teknik Mesin'],
            'fbs': ['Pendidikan Bahasa Indonesia', 'Pendidikan Bahasa Inggris', 'Pendidikan Bahasa Jerman', 'Pendidikan Bahasa Prancis', 'Pendidikan Seni Rupa'],
            'fip': ['Pendidikan Guru Sekolah Dasar', 'Pendidikan Anak Usia Dini', 'Bimbingan dan Konseling', 'Teknologi Pendidikan', 'Pendidikan Luar Biasa'],
            'fe': ['Pendidikan Ekonomi', 'Manajemen', 'Akuntansi', 'Pendidikan Administrasi Perkantoran'],
            'fis': ['Pendidikan Pancasila dan Kewarganegaraan', 'Pendidikan Sejarah', 'Pendidikan Geografi', 'Pendidikan Sosiologi', 'Ilmu Komunikasi']
        };

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

        // Handle form submission feedback
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
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
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
        
        .badge {
            font-size: 0.7em;
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
    </style>

@endsection