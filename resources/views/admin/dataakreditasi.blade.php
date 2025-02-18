@extends('admin.admin')

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Data Akreditasi</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Input Data Akreditasi</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Data Akreditasi</h3>
            </div> 

            <form action="{{ route('admin.dataakreditasi.store') }}" method="POST" id="akreditasi-form">
            
                @csrf
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
                        <div class="form-text text-muted">Pilih fakultas yang akan diinput data akreditasinya</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select" name="prodi" id="prodi" disabled>
                            <option value="">Pilih Program Studi</option>
                        </select>
                        <div class="form-text text-muted">Pilih program studi yang akan diinput data akreditasinya</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="lembaga_akreditasi" class="form-label">Lembaga Akreditasi</label>
                        <select class="form-select" name="lembaga_akreditasi" id="lembaga_akreditasi">
                            <option value="">Pilih Lembaga Akreditasi</option>
                            <option value="ban-pt">BAN-PT</option>
                            <option value="lam-infokom">LAM INFOKOM</option>
                            <option value="lam-teknik">LAM TEKNIK</option>
                            <option value="lam-ekonomi">LAM EKONOMI</option>
                            <option value="lam-pendidikan">LAM PENDIDIKAN</option>
                        </select>
                        <div class="form-text text-muted">Pilih lembaga yang mengeluarkan akreditasi</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="peringkat" class="form-label">Peringkat Akreditasi</label>
                        <select class="form-select" name="peringkat" id="peringkat">
                            <option value="">Pilih Peringkat</option>
                            <option value="unggul">Unggul</option>
                            <option value="baik_sekali">Baik Sekali</option>
                            <option value="baik">Baik</option>
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                        </select>
                        <div class="form-text text-muted">Pilih peringkat akreditasi yang diperoleh</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="nomor_sk" class="form-label">Nomor SK</label>
                        <input type="text" class="form-control" name="nomor_sk" id="nomor_sk">
                        <div class="form-text text-muted">Masukkan nomor SK akreditasi (contoh: 1234/SK/BAN-PT/2024)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="periode_awal" class="form-label">Periode Awal Berlaku</label>
                        <input type="date" class="form-control" name="periode_awal" id="periode_awal">
                        <div class="form-text text-muted">Pilih tanggal mulai berlakunya akreditasi</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="periode_akhir" class="form-label">Periode Akhir Berlaku</label>
                        <input type="date" class="form-control" name="periode_akhir" id="periode_akhir">
                        <div class="form-text text-muted">Pilih tanggal berakhirnya akreditasi</div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" >Submit</button>
                </div>
            </form>
        </div>

        <div class="table-data mt-4">
            <div class="order">
                <div class="head">
                    <h3>Daftar Data Akreditasi</h3>
                    <div class="d-flex justify-content-end">
                        <div class="search-box">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="akreditasi-table">
                        <thead>
                            <tr>
                                <th>Fakultas</th>
                                <th>Program Studi</th>
                                <th>Lembaga Akreditasi</th>
                                <th>Peringkat</th>
                                <th>Nomor SK</th>
                                <th>Periode Berlaku</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="akreditasi-list">
                            @forelse ($akreditasis as $akreditasi)
                            <tr>
                                <td>{{ strtoupper($akreditasi->fakultas) }}</td>
                                <td>{{ $akreditasi->prodi }}</td>
                                <td>{{ ucwords(str_replace('-', ' ', $akreditasi->lembaga_akreditasi)) }}</td>
                                <td>
                                    @php
                                        $peringkatLabels = [
                                            'unggul' => 'Unggul',
                                            'baik_sekali' => 'Baik Sekali',
                                            'baik' => 'Baik',
                                            'a' => 'A',
                                            'b' => 'B',
                                            'c' => 'C'
                                        ];
                                    @endphp
                                    {{ $peringkatLabels[$akreditasi->peringkat] ?? $akreditasi->peringkat }}
                                </td>
                                <td>{{ $akreditasi->nomor_sk }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($akreditasi->periode_awal)->format('d/m/Y') }} - 
                                    {{ \Carbon\Carbon::parse($akreditasi->periode_akhir)->format('d/m/Y') }}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-warning">Edit</button>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </div>
                                    {{-- <div class="btn-group">
                                        <a href="{{ route('admin.dataakreditasi.edit', $akreditasi->id) }}" 
                                           class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('admin.dataakreditasi.destroy', $akreditasi->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                        </form>
                                    </div> --}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data akreditasi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

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

        .btn-group {
            display: flex;
            gap: 5px;
        }

        .badge {
            font-size: 0.7em;
        }
    </style>

    <script>
        const prodisByFaculty = {
            'fmipa': ['Ilmu Komputer', 'Matematika', 'Pendidikan Matematika', 'Fisika', 'Pendidikan Fisika', 'Biologi', 'Pendidikan Biologi', 'Kimia', 'Pendidikan Kimia'],
            'fik': ['Pendidikan Teknologi Informasi', 'Pendidikan Teknik Elektronika', 'Pendidikan Teknik Elektro', 'Teknik Informatika dan Komputer'],
            'ft': ['Teknik Sipil', 'Teknik Mesin', 'Teknik Elektro', 'Pendidikan Teknik Bangunan', 'Pendidikan Teknik Mesin'],
            'fbs': ['Pendidikan Bahasa Indonesia', 'Pendidikan Bahasa Inggris', 'Pendidikan Bahasa Jerman', 'Pendidikan Bahasa Prancis', 'Pendidian Seni Rupa'],
            'fip': ['Pendidikan Guru Sekolah Dasar', 'Pendidikan Anak Usia Dini', 'Bimbingan dan Konseling', 'Teknologi Pendidikan', 'Pendidikan Luar Biasa'],
            'fe': ['Pendidikan Ekonomi', 'Manajemen', 'Akuntansi', 'Pendidikan Administrasi Perkantoran'],
            'fis': ['Pendidikan Pancasila dan Kewarganegaraan', 'Pendidikan Sejarah', 'Pendidikan Geografi', 'Pendidikan Sosiologi', 'Ilmu Komunikasi']
        };

        // Faculty change handler
        document.getElementById('fakultas').addEventListener('change', function() {
            const prodiSelect = document.getElementById('prodi');
            prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
            
            if (this.value) {
                prodiSelect.disabled = false;
                const prodis = prodisByFaculty[this.value];
                prodis.forEach(prodi => {
                    const option = document.createElement('option');
                    option.value = prodi.toLowerCase().replace(/ /g, '_');
                    option.textContent = prodi;
                    prodiSelect.appendChild(option);
                });
            } else {
                prodiSelect.disabled = true;
            }
        });


        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.getElementById('akreditasi-list').getElementsByTagName('tr');

            Array.from(rows).forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchText) ? '' : 'none';
            });
        });
    </script>
@endsection