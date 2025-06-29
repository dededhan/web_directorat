@extends('fakultas.index')

@vite(['resources/css/admin/sustainability_dashboard.css'])

@section('contentfakultas')
    <div class="head-title">
        <div class="left">
            <h1>Sustainability</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('fakultas.dashboard') }}">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="{{ route('fakultas.sustainability.index') }}">Input Kegiatan Sustainability</a></li>
            </ul>
        </div>
    </div>

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
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Kegiatan Sustainability</h3>
            </div>
            <form id="sustainability-form" method="POST" action="{{ route('fakultas.sustainability.store') }}" enctype="multipart/form-data">
                @csrf
                @php
                    $sdgGoalsData = $sdgDetailsList ?? [
                        1 => "Tanpa Kemiskinan", 2 => "Tanpa Kelaparan", 3 => "Kehidupan Sehat dan Sejahtera", 4 => "Pendidikan Berkualitas", 5 => "Kesetaraan Gender", 6 => "Air Bersih dan Sanitasi Layak", 7 => "Energi Bersih dan Terjangkau", 8 => "Pekerjaan Layak dan Pertumbuhan Ekonomi", 9 => "Industri, Inovasi, dan Infrastruktur", 10 => "Berkurangnya Kesenjangan", 11 => "Kota dan Pemukiman yang Berkelanjutan", 12 => "Konsumsi dan Produksi yang Bertanggung Jawab", 13 => "Penanganan Perubahan Iklim", 14 => "Ekosistem Lautan", 15 => "Ekosistem Daratan", 16 => "Perdamaian, Keadilan, dan Kelembagaan yang Tangguh", 17 => "Kemitraan untuk Mencapai Tujuan",
                    ];
                @endphp
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="sdg_goal_main" class="form-label">Kelompok Kategori</label>
                        <select class="form-select" name="sdg_goal" id="sdg_goal_main">
                            <option value="">Pilih Kelompok Kategori</option>
                            @foreach ($sdgGoalsData as $number => $description)
                                @php $optionValue = "SDGs " . $number; @endphp
                                <option value="{{ $optionValue }}" {{ old('sdg_goal') == $optionValue ? 'selected' : '' }}>
                                    SDGs {{ $number }}: {{ $description }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="judul_kegiatan" class="form-label">Judul Kegiatan</label>
                        <input type="text" class="form-control @error('judul_kegiatan') is-invalid @enderror" name="judul_kegiatan" id="judul_kegiatan" value="{{ old('judul_kegiatan') }}">
                        @error('judul_kegiatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_kegiatan" class="form-label">Tanggal Kegiatan</label>
                        <input type="date" class="form-control @error('tanggal_kegiatan') is-invalid @enderror" name="tanggal_kegiatan" id="tanggal_kegiatan" value="{{ old('tanggal_kegiatan') }}">
                        @error('tanggal_kegiatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                     <div class="col-md-6 mb-3">
                        <label for="link_kegiatan" class="form-label">Link Kegiatan</label>
                        <input type="url" class="form-control @error('link_kegiatan') is-invalid @enderror" name="link_kegiatan" id="link_kegiatan" value="{{ old('link_kegiatan') }}">
                        @error('link_kegiatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fakultas" class="form-label">Fakultas</label>
                        <input type="text" class="form-control" value="{{ strtoupper(Auth::user()->name) }}" disabled>
                        <input type="hidden" name="fakultas" value="{{ $user_info['faculty_code'] ?? '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select @error('prodi') is-invalid @enderror" name="prodi" id="prodi">
                            <option value="">-- Level Fakultas (Tanpa Prodi) --</option>
                            @foreach($prodi_list_for_fakultas as $prodi_item)
                                <option value="{{ $prodi_item }}" {{ old('prodi') == $prodi_item ? 'selected' : '' }}>{{ $prodi_item }}</option>
                            @endforeach
                        </select>
                        @error('prodi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi_kegiatan" class="form-label">Deskripsi Kegiatan</label>
                        <textarea class="form-control @error('deskripsi_kegiatan') is-invalid @enderror" name="deskripsi_kegiatan" id="deskripsi_kegiatan" rows="4">{{ old('deskripsi_kegiatan') }}</textarea>
                        @error('deskripsi_kegiatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="foto_kegiatan" class="form-label">Foto-foto Kegiatan</label>
                        <input type="file" class="form-control" name="foto_kegiatan[]" id="foto_kegiatan" multiple accept="image/*">
                    </div>
                </div>
                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="table-data mt-4">
        <div class="order">
            <div class="head"><h3>Daftar Kegiatan Sustainability</h3></div>
            <div class="table-responsive">
                <table class="table table-striped" id="sustainability-table">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Judul Kegiatan</th>
                            <th>Tanggal</th>
                            <th>Prodi</th>
                            <th>Link</th>
                            <th>Foto</th>
                            <th>Deskripsi</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sustainabilities as $activity)
                            <tr>
                                <td>{{ $activity->sdg_goal ?? 'N/A' }}</td>
                                <td>{{ $activity->judul_kegiatan }}</td>
                                <td>{{ \Carbon\Carbon::parse($activity->tanggal_kegiatan)->format('d M Y') }}</td>
                                <td>{{ $activity->prodi ?? 'N/A (Fakultas)' }}</td>
                                <td>
                                    @if($activity->link_kegiatan)<a href="{{ $activity->link_kegiatan }}" target="_blank" class="btn btn-sm btn-outline-info">View Link</a>@else - @endif
                                </td>
                                <td>
                                    @if($activity->photos->isNotEmpty())
                                        <button class="btn btn-sm btn-info view-photos" data-photos='@json($activity->photos->pluck("path"))' data-bs-toggle="modal" data-bs-target="#photoModal">
                                            View Photos ({{ $activity->photos->count() }})
                                        </button>
                                    @else No Photos @endif
                                </td>
                                <td>{{ Str::limit($activity->deskripsi_kegiatan, 50) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-warning edit-activity" data-id="{{ $activity->id }}" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                                        <button class="btn btn-sm btn-danger delete-activity" data-id="{{ $activity->id }}" data-judul="{{ $activity->judul_kegiatan }}">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center">Belum ada data kegiatan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($sustainabilities->hasPages())<div class="mt-3">{{ $sustainabilities->links() }}</div>@endif
        </div>
    </div>

    {{-- Photo Modal --}}
    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true"><div class="modal-dialog modal-lg modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="photoModalLabel">Foto Kegiatan</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body" id="photoGallery"></div></div></div></div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title" id="editModalLabel">Edit Kegiatan</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <form id="edit-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_sdg_goal_modal" class="form-label">Kelompok Kategori</label>
                                <select class="form-select" name="sdg_goal" id="edit_sdg_goal_modal">
                                    <option value="">Pilih Kelompok Kategori</option>
                                    @foreach ($sdgGoalsData as $number => $description)
                                        @php $optionValue = "SDGs " . $number; @endphp
                                        <option value="{{ $optionValue }}">SDGs {{ $number }}: {{ $description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_judul_kegiatan" class="form-label">Judul Kegiatan</label>
                                <input type="text" class="form-control" name="judul_kegiatan" id="edit_judul_kegiatan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_tanggal_kegiatan" class="form-label">Tanggal Kegiatan</label>
                                <input type="date" class="form-control" name="tanggal_kegiatan" id="edit_tanggal_kegiatan">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_link_kegiatan" class="form-label">Link Kegiatan</label>
                                <input type="url" class="form-control" name="link_kegiatan" id="edit_link_kegiatan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fakultas</label>
                                <input type="text" class="form-control" value="{{ strtoupper(Auth::user()->name) }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_prodi" class="form-label">Program Studi</label>
                                <select class="form-select" name="prodi" id="edit_prodi">
                                    <option value="">-- Level Fakultas (Tanpa Prodi) --</option>
                                    @foreach($prodi_list_for_fakultas as $prodi_item)
                                        <option value="{{ $prodi_item }}">{{ $prodi_item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_deskripsi_kegiatan" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi_kegiatan" id="edit_deskripsi_kegiatan" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_foto_kegiatan" class="form-label">Tambah Foto (Opsional)</label>
                            <input type="file" class="form-control" name="foto_kegiatan[]" multiple accept="image/*">
                            <div id="edit_current_photos" class="mt-2"></div>
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

    <form id="delete-form" method="POST" style="display: none;">@csrf @method('DELETE')</form>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.view-photos').forEach(button => {
            button.addEventListener('click', function() {
                const photos = JSON.parse(this.dataset.photos);
                const gallery = document.getElementById('photoGallery');
                gallery.innerHTML = photos.length > 0
                    ? photos.map(path => `<img src="/storage/${path}" class="img-fluid mb-3 rounded" style="max-height: 400px; object-fit: contain; display: block; margin: auto;">`).join('')
                    : '<p>Tidak ada foto.</p>';
            });
        });

        document.querySelectorAll('.edit-activity').forEach(button => {
            button.addEventListener('click', function() {
                const activityId = this.dataset.id;
                document.getElementById('edit-form').action = `{{ url('fakultas/sustainability') }}/${activityId}`;

                fetch(`{{ url('fakultas/sustainability') }}/${activityId}/detail`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_sdg_goal_modal').value = data.sdg_goal || "";
                    document.getElementById('edit_judul_kegiatan').value = data.judul_kegiatan;
                    document.getElementById('edit_tanggal_kegiatan').value = data.tanggal_kegiatan.split('T')[0];
                    document.getElementById('edit_link_kegiatan').value = data.link_kegiatan || '';
                    document.getElementById('edit_deskripsi_kegiatan').value = data.deskripsi_kegiatan;
                    document.getElementById('edit_prodi').value = data.prodi || "";

                    const currentPhotosDiv = document.getElementById('edit_current_photos');
                    currentPhotosDiv.innerHTML = data.photos.length > 0
                        ? '<p>Foto saat ini:</p>' + data.photos.map(p => `<img src="/storage/${p.path}" class="img-thumbnail" style="width:100px; height:100px; object-fit:cover;">`).join(' ')
                        : '<p><em>Tidak ada foto terunggah.</em></p>';
                }).catch(err => console.error('Fetch error:', err));
            });
        });

        document.querySelectorAll('.delete-activity').forEach(button => {
            button.addEventListener('click', function() {
                Swal.fire({
                    title: 'Anda Yakin?',
                    text: `Hapus kegiatan "${this.dataset.judul}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const deleteForm = document.getElementById('delete-form');
                        deleteForm.action = `{{ url('fakultas/sustainability') }}/${this.dataset.id}`;
                        deleteForm.submit();
                    }
                });
            });
        });
    });
    </script>
@endsection
