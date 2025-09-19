@extends('admin.admin')

@section('contentadmin')
{{-- Pastikan Anda memuat CSS Bootstrap jika belum --}}
{{-- @vite(['resources/css/admin/mitra_kolaborasi.css']) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="head-title">
    <div class="left">
        <h1>Manajemen Sesi Proposal</h1>
        <ul class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="{{ route('admin.proposal-sessions.index') }}">Sesi Proposal</a></li>
        </ul>
    </div>
</div>

{{-- FORM CREATE --}}
<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Input Sesi Proposal Baru</h3>
        </div>
        <form method="POST" action="{{ route('admin.proposal-sessions.store') }}" id="createSessionForm">
            @csrf
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="nama_sesi" class="form-label">Nama Sesi / Skema</label>
                    <input type="text" class="form-control @error('nama_sesi') is-invalid @enderror" name="nama_sesi" value="{{ old('nama_sesi') }}" required>
                    @error('nama_sesi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Singkat</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="dana_maksimal" class="form-label">Dana Maksimal (Rp)</label>
                    <input type="number" class="form-control @error('dana_maksimal') is-invalid @enderror" name="dana_maksimal" value="{{ old('dana_maksimal') }}" required>
                    @error('dana_maksimal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Periode Submit</label>
                    <div class="input-group">
                        <input type="date" name="periode_awal" class="form-control @error('periode_awal') is-invalid @enderror" value="{{ old('periode_awal') }}" required>
                        <span class="input-group-text">-</span>
                        <input type="date" name="periode_akhir" class="form-control @error('periode_akhir') is-invalid @enderror" value="{{ old('periode_akhir') }}" required>
                    </div>
                     @error('periode_awal')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                     @error('periode_akhir')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>
             <div class="row">
                 <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah Anggota</label>
                    <div class="input-group">
                        <input type="number" name="min_anggota" class="form-control @error('min_anggota') is-invalid @enderror" placeholder="Min" value="{{ old('min_anggota') }}" required>
                        <span class="input-group-text">-</span>
                        <input type="number" name="max_anggota" class="form-control @error('max_anggota') is-invalid @enderror" placeholder="Max" value="{{ old('max_anggota') }}" required>
                    </div>
                    @error('min_anggota')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    @error('max_anggota')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mb-3 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan Sesi</button>
            </div>
        </form>
    </div>
</div>

{{-- TABEL DATA --}}
<div class="table-data mt-4">
    <div class="order">
        <div class="head">
            <h3>Daftar Sesi Proposal</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Sesi</th>
                        <th>Periode</th>
                        <th>Dana</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sessions as $index => $session)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $session->nama_sesi }}</td>
                            <td>{{ \Carbon\Carbon::parse($session->periode_awal)->format('d M Y') }} - {{ \Carbon\Carbon::parse($session->periode_akhir)->format('d M Y') }}</td>
                            <td>Rp {{ number_format($session->dana_maksimal, 0, ',', '.') }}</td>
                            <td>
                                @if (\Carbon\Carbon::now()->isAfter(\Carbon\Carbon::parse($session->periode_akhir)->endOfDay()))
                                    <span class="badge bg-danger">Tutup</span>
                                @else
                                    <span class="badge bg-success">Buka</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-warning edit-session" data-id="{{ $session->id }}">Edit</button>
                                    <form method="POST" action="{{ route('admin.proposal-sessions.destroy', $session->id) }}" class="delete-form d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-btn">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $sessions->links() }}</div>
    </div>
</div>

<div class="modal fade" id="editSessionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Edit Sesi Proposal</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
            <div class="modal-body">
                <form id="editSessionForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12 mb-3"><label for="edit_nama_sesi" class="form-label">Nama Sesi</label><input type="text" class="form-control" name="nama_sesi" id="edit_nama_sesi" required></div>
                        <div class="col-md-12 mb-3"><label for="edit_deskripsi" class="form-label">Deskripsi</label><textarea class="form-control" name="deskripsi" id="edit_deskripsi" rows="3"></textarea></div>
                    </div>
                    <div class="row">
                         <div class="col-md-6 mb-3"><label for="edit_dana_maksimal" class="form-label">Dana Maksimal</label><input type="number" class="form-control" name="dana_maksimal" id="edit_dana_maksimal" required></div>
                         <div class="col-md-6 mb-3"><label class="form-label">Periode</label><div class="input-group"><input type="date" name="periode_awal" id="edit_periode_awal" class="form-control" required><input type="date" name="periode_akhir" id="edit_periode_akhir" class="form-control" required></div></div>
                    </div>
                     <div class="row">
                         <div class="col-md-6 mb-3"><label class="form-label">Jumlah Anggota</label><div class="input-group"><input type="number" name="min_anggota" id="edit_min_anggota" class="form-control" placeholder="Min" required><input type="number" name="max_anggota" id="edit_max_anggota" class="form-control" placeholder="Max" required></div></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveEditSession">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Menangani konfirmasi sebelum submit form create
    document.getElementById('createSessionForm').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Konfirmasi', text: 'Apakah Anda yakin ingin menyimpan sesi baru?',
            icon: 'question', showCancelButton: true, confirmButtonColor: '#3498db',
            cancelButtonColor: '#d33', confirmButtonText: 'Ya, Simpan!', cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'Menyimpan...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                this.submit();
            }
        });
    });

    // Menangani konfirmasi untuk tombol delete
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            Swal.fire({
                title: 'Anda Yakin?', text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33',
                cancelButtonColor: '#3498db', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({ title: 'Menghapus...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                    form.submit();
                }
            });
        });
    });

    // Menangani klik tombol edit untuk membuka modal
    document.querySelectorAll('.edit-session').forEach(button => {
        button.addEventListener('click', function() {
            const sessionId = this.dataset.id;
            Swal.fire({ title: 'Memuat Data...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

            fetch(`/admin/proposal-sessions/${sessionId}/detail`)
                .then(response => {
                    if (!response.ok) throw new Error('Gagal mengambil data');
                    return response.json();
                })
                .then(data => {
                    Swal.close();
                    // Mengisi form di dalam modal dengan data yang didapat
                    document.getElementById('edit_nama_sesi').value = data.nama_sesi;
                    document.getElementById('edit_deskripsi').value = data.deskripsi;
                    document.getElementById('edit_dana_maksimal').value = data.dana_maksimal;
                    document.getElementById('edit_periode_awal').value = data.periode_awal;
                    document.getElementById('edit_periode_akhir').value = data.periode_akhir;
                    document.getElementById('edit_min_anggota').value = data.min_anggota;
                    document.getElementById('edit_max_anggota').value = data.max_anggota;
                    
                    const form = document.getElementById('editSessionForm');
                    form.action = `/admin/proposal-sessions/${sessionId}`;

                    const editModal = new bootstrap.Modal(document.getElementById('editSessionModal'));
                    editModal.show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error!', 'Gagal mengambil detail data.', 'error');
                });
        });
    });

    // Menangani klik tombol 'Simpan Perubahan' di modal edit
    document.getElementById('saveEditSession').addEventListener('click', function() {
        const form = document.getElementById('editSessionForm');
        const formData = new FormData(form);
        formData.append('_method', 'PUT'); // Menambahkan method spoofing untuk Laravel

        Swal.fire({
            title: 'Menyimpan Perubahan...', allowOutsideClick: false, didOpen: () => Swal.showLoading()
        });

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modalElement = document.getElementById('editSessionModal');
                const modal = bootstrap.Modal.getInstance(modalElement);
                modal.hide();
                Swal.fire('Berhasil!', data.message, 'success').then(() => window.location.reload());
            } else {
                Swal.fire('Gagal!', data.message || 'Gagal menyimpan perubahan.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan.', 'error');
        });
    });
    
    // Menampilkan notifikasi session dari server
    @if(session('success'))
        Swal.fire({ title: 'Berhasil!', text: "{{ session('success') }}", icon: 'success' });
    @endif
    @if(session('error'))
        Swal.fire({ title: 'Gagal!', text: "{{ session('error') }}", icon: 'error' });
    @endif
});
</script>
@endsection