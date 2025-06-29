@extends('admin.admin')

@section('contentadmin')

    @vite([
        'resources/css/admin/matakuliah_dashboard.css',
        'resources/js/admin/matakuliah_dashboard.js'
    ])
    
    <div class="head-title">
        <div class="left">
            <h1>Mata Kuliah Sustainability</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="{{ route('admin.matakuliah.index') }}">Input Mata Kuliah</a>
                </li>
            </ul>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Form Input Mata Kuliah --}}
    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Mata Kuliah Sustainability</h3>
            </div>

            <form id="matakuliah-form" action="{{ route('admin.matakuliah.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="sdgs_group" class="form-label">Kelompok Kategori</label>
                        <select class="form-select @error('sdgs_group') is-invalid @enderror" name="sdgs_group" id="sdgs_group">
                            <option value="">Pilih Kelompok Kategori</option>
                            @php
                                $sdgGoalsData = $sdgDetailsList ?? [
                                    1 => 'Tanpa Kemiskinan', 2 => 'Tanpa Kelaparan', 3 => 'Kehidupan Sehat dan Sejahtera', 4 => 'Pendidikan Berkualitas', 5 => 'Kesetaraan Gender', 6 => 'Air Bersih dan Sanitasi Layak', 7 => 'Energi Bersih dan Terjangkau', 8 => 'Pekerjaan Layak dan Pertumbuhan Ekonomi', 9 => 'Industri, Inovasi, dan Infrastruktur', 10 => 'Berkurangnya Kesenjangan', 11 => 'Kota dan Pemukiman yang Berkelanjutan', 12 => 'Konsumsi dan Produksi yang Bertanggung Jawab', 13 => 'Penanganan Perubahan Iklim', 14 => 'Ekosistem Lautan', 15 => 'Ekosistem Daratan', 16 => 'Perdamaian, Keadilan, dan Kelembagaan yang Tangguh', 17 => 'Kemitraan untuk Mencapai Tujuan',
                                ];
                            @endphp
                            @foreach ($sdgGoalsData as $number => $description)
                                @php $optionValue = 'SDGs ' . $number; @endphp
                                <option value="{{ $optionValue }}" {{ old('sdgs_group') == $optionValue ? 'selected' : '' }}>
                                    SDGs {{ $number }}: {{ $description }}
                                </option>
                            @endforeach
                        </select>
                        @error('sdgs_group') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Pilih kelompok SDGs yang relevan dengan mata kuliah ini.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="nama_matkul" class="form-label">Nama Mata Kuliah</label>
                        <input type="text" class="form-control @error('nama_matkul') is-invalid @enderror" name="nama_matkul" id="nama_matkul" value="{{ old('nama_matkul') }}">
                        @error('nama_matkul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Masukkan nama lengkap mata kuliah.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="semester" class="form-label">Semester</label>
                        <input type="text" class="form-control @error('semester') is-invalid @enderror" name="semester" id="semester" value="{{ old('semester') }}">
                        @error('semester') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Contoh: 1, 2, 3, dst.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kode_matkul" class="form-label">Kode Mata Kuliah</label>
                        <input type="text" class="form-control @error('kode_matkul') is-invalid @enderror" name="kode_matkul" id="kode_matkul" value="{{ old('kode_matkul') }}">
                        @error('kode_matkul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Contoh: MK001. Harus unik.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fakultas" class="form-label">Fakultas</label>
                        <select class="form-select @error('fakultas') is-invalid @enderror" name="fakultas" id="fakultas">
                            <option value="">Pilih Fakultas</option>
                            @php
                                $faculties = $faculties_data ?? [];
                            @endphp
                            @foreach ($faculties as $key => $faculty)
                                <option value="{{ strtolower($key) }}" {{ old('fakultas') == strtolower($key) ? 'selected' : '' }}>{{ $faculty['name'] }}</option>
                            @endforeach
                        </select>
                        @error('fakultas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Pilih fakultas penyelenggara.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select @error('prodi') is-invalid @enderror" name="prodi" id="prodi" {{ old('fakultas') ? '' : 'disabled' }}>
                            <option value="">Pilih Program Studi</option>
                        </select>
                        @error('prodi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Pilih program studi (opsional jika mata kuliah level fakultas).</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="rps" class="form-label">RPS Mata Kuliah</label>
                        <input type="file" class="form-control @error('rps') is-invalid @enderror" name="rps" id="rps" accept=".pdf,.doc,.docx">
                        @error('rps') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Upload RPS (PDF, DOC, DOCX, max 10MB).</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Mata Kuliah</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Deskripsi lengkap (minimal 50 karakter).</div>
                    </div>
                </div>
                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Daftar Mata Kuliah --}}
    <div class="table-data mt-4">
        <div class="order">
            <div class="head">
                <h3>Daftar Mata Kuliah Sustainability</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-striped" id="matakuliah-table">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Ditambahkan Oleh</th>
                            <th>Nama Mata Kuliah</th>
                            <th>Kode</th>
                            <th>Semester</th>
                            <th>Fakultas</th>
                            <th>Program Studi</th>
                            <th>RPS</th>
                            <th>Deskripsi</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="matakuliah-list">
                        @forelse($matakuliahs as $matakuliah)
                            <tr>
                                <td>{{ $matakuliah->sdgs_group ?? 'N/A' }}</td>
                                <td>{{ $matakuliah->user->name ?? 'N/A' }}</td>
                                <td>{{ $matakuliah->nama_matkul }}</td>
                                <td>{{ $matakuliah->kode_matkul }}</td>
                                <td>{{ $matakuliah->semester }}</td>
                                <td>{{ strtoupper($matakuliah->fakultas) }}</td>
                                <td>{{ $matakuliah->prodi ?? 'N/A (Fakultas)' }}</td>
                                <td>
                                    @if ($matakuliah->rps_path)
                                        <a href="{{ Storage::url($matakuliah->rps_path) }}" target="_blank" class="btn btn-sm btn-info">View RPS</a>
                                    @else
                                        No RPS
                                    @endif
                                </td>
                                <td>{{ Str::limit($matakuliah->deskripsi, 50) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-warning edit-matakuliah" data-id="{{ $matakuliah->id }}" data-bs-toggle="modal" data-bs-target="#editMatakuliahModal">Edit</button>
                                        <button class="btn btn-sm btn-danger delete-matakuliah" data-id="{{ $matakuliah->id }}" data-nama="{{ $matakuliah->nama_matkul }}">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Belum ada data mata kuliah.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($matakuliahs->hasPages())
                <div class="mt-3">
                    {{ $matakuliahs->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Modal Edit Mata Kuliah --}}
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
                    <input type="hidden" name="matakuliah_id" id="edit_matakuliah_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_sdgs_group" class="form-label">Kelompok Kategori</label>
                                <select class="form-select" name="sdgs_group" id="edit_sdgs_group">
                                    <option value="">Pilih Kelompok Kategori</option>
                                    @foreach ($sdgGoalsData as $number => $description)
                                        @php $optionValue = 'SDGs ' . $number; @endphp
                                        <option value="{{ $optionValue }}">SDGs {{ $number }}: {{ $description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
                                    <option value="">Pilih Fakultas</option>
                                    @foreach ($faculties as $key => $faculty)
                                        <option value="{{ strtolower($key) }}">{{ $faculty['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_prodi" class="form-label">Program Studi</label>
                                <select class="form-select" name="prodi" id="edit_prodi" disabled>
                                    <option value="">Pilih Program Studi</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_rps" class="form-label">RPS Mata Kuliah (Opsional)</label>
                                <input type="file" class="form-control" name="rps" id="edit_rps" accept=".pdf,.doc,.docx">
                                <div class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah file RPS. <span id="current_rps_info"></span></div>
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

    {{-- Delete Form --}}
    <form id="delete-matakuliah-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const facultiesData = @json($faculties_data ?? []);

        function populateProdiDropdown(fakultasValue, prodiSelectElement, selectedProdi = null) {
            prodiSelectElement.innerHTML = '<option value="">Pilih Program Studi</option>';
            prodiSelectElement.disabled = true;

            if (fakultasValue && facultiesData[fakultasValue.toUpperCase()] && facultiesData[fakultasValue.toUpperCase()].programs) {
                prodiSelectElement.disabled = false;
                facultiesData[fakultasValue.toUpperCase()].programs.forEach(prodi => {
                    const option = document.createElement('option');
                    option.value = prodi;
                    option.textContent = prodi;
                    if (selectedProdi && prodi === selectedProdi) {
                        option.selected = true;
                    }
                    prodiSelectElement.appendChild(option);
                });
            }
            const noProdiOption = document.createElement('option');
            noProdiOption.value = "";
            noProdiOption.textContent = "-- Level Fakultas (Tanpa Prodi) --";
            if (selectedProdi === null || selectedProdi === "") {
                noProdiOption.selected = true;
            }
            prodiSelectElement.insertBefore(noProdiOption, prodiSelectElement.firstChild.nextSibling);
        }

        const mainFakultasSelect = document.getElementById('fakultas');
        const mainProdiSelect = document.getElementById('prodi');
        if (mainFakultasSelect) {
            mainFakultasSelect.addEventListener('change', function() {
                populateProdiDropdown(this.value, mainProdiSelect);
            });
            if (mainFakultasSelect.value) {
                populateProdiDropdown(mainFakultasSelect.value, mainProdiSelect, "{{ old('prodi') }}");
            }
        }

        const editFakultasSelect = document.getElementById('edit_fakultas');
        const editProdiSelect = document.getElementById('edit_prodi');
        if (editFakultasSelect) {
            editFakultasSelect.addEventListener('change', function() {
                populateProdiDropdown(this.value, editProdiSelect);
            });
        }

        document.querySelectorAll('.edit-matakuliah').forEach(button => {
            button.addEventListener('click', function() {
                const matkulId = this.dataset.id;
                const editForm = document.getElementById('edit-matakuliah-form');
                editForm.action = `{{ url('admin/matakuliah') }}/${matkulId}`;
                document.getElementById('edit_matakuliah_id').value = matkulId;

                fetch(`{{ url('admin/matakuliah') }}/${matkulId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('edit_sdgs_group').value = data.sdgs_group;
                        document.getElementById('edit_nama_matkul').value = data.nama_matkul;
                        document.getElementById('edit_semester').value = data.semester;
                        document.getElementById('edit_kode_matkul').value = data.kode_matkul;
                        const currentFakultas = data.fakultas ? data.fakultas.toLowerCase() : '';
                        editFakultasSelect.value = currentFakultas;
                        populateProdiDropdown(currentFakultas, editProdiSelect, data.prodi);
                        document.getElementById('edit_deskripsi').value = data.deskripsi;
                        const currentRpsInfo = document.getElementById('current_rps_info');
                        if (data.rps_path) {
                            currentRpsInfo.innerHTML = `File saat ini: <a href="/storage/${data.rps_path}" target="_blank">${data.rps_path.split('/').pop()}</a>`;
                        } else {
                            currentRpsInfo.innerHTML = '<em>Tidak ada file RPS terunggah.</em>';
                        }
                        document.getElementById('edit_rps').value = '';
                    })
                    .catch(error => console.error('Error fetching matakuliah details:', error));
            });
        });

        document.querySelectorAll('.delete-matakuliah').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const matkulId = this.dataset.id;
                const matkulNama = this.dataset.nama;
                const deleteForm = document.getElementById('delete-matakuliah-form');
                deleteForm.action = `{{ url('admin/matakuliah') }}/${matkulId}`;

                Swal.fire({
                    title: 'Anda Yakin?',
                    text: `Apakah Anda ingin menghapus mata kuliah "${matkulNama}"? Tindakan ini tidak dapat dibatalkan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteForm.submit();
                    }
                });
            });
        });

        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', timer: 3000, showConfirmButton: false });
        @endif
        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}', timer: 3000, showConfirmButton: false });
        @endif
    });
    </script>
@endsection
