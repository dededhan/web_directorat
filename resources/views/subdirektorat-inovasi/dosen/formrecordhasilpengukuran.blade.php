@extends('subdirektorat-inovasi.dosen.index')

@section('contentdosen')

    <div class="head-title">
        <div class="left">
            <h1>Record Hasil Pengukuran</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Record Hasil Pengukuran</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Form Record Hasil Pengukuran Katsinov</h3>
            </div>

            <form id="innovationForm" action="{{ route('admin.Katsinov.record.store', $id) }}" method="POST">
                @csrf
                
                <!-- Section 1: Informasi Penanggungjawab -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>1. Informasi Penanggungjawab</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-md-3 form-label">Nama Penanggungjawab</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="nama_penanggung_jawab" 
                                    placeholder="Masukkan nama penanggungjawab" 
                                    value="{{ $record->nama_penanggung_jawab ?? '' }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-3 form-label">Institusi</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="institusi" 
                                    placeholder="Masukkan nama institusi" 
                                    value="{{ $record->institusi ?? '' }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-3 form-label">Judul Inovasi</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="judul_inovasi" 
                                    placeholder="Masukkan judul inovasi" 
                                    value="{{ $record->judul_inovasi ?? '' }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-3 form-label">Jenis Inovasi</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="jenis_inovasi" 
                                    placeholder="Masukkan jenis inovasi" 
                                    value="{{ $record->jenis_inovasi ?? '' }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-3 form-label">Alamat Kontak</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="alamat_kontak" 
                                    placeholder="Masukkan alamat kontak" required>{{ $record->alamat_kontak ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-3 form-label">Phone</label>
                            <div class="col-md-9">
                                <input type="tel" class="form-control" name="phone" 
                                    placeholder="Masukkan nomor telepon" 
                                    value="{{ $record->phone ?? '' }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-3 form-label">Fax</label>
                            <div class="col-md-9">
                                <input type="tel" class="form-control" name="fax" 
                                    placeholder="Masukkan nomor fax" 
                                    value="{{ $record->fax ?? '' }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-3 form-label">Tanggal Penilaian</label>
                            <div class="col-md-9">
                                <input type="date" class="form-control" name="tanggal_penilaian" 
                                    value="{{ $record->tanggal_penilaian ?? '' }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Penilaian Inovasi -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>2. Penilaian Inovasi</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="50">No.</th>
                                        <th>Aspek</th>
                                        <th>Aktivitas Kunci</th>
                                        <th>Capaian (%)</th>
                                        <th>Keterangan</th>
                                        <th>Catatan Secara Umum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i = 1; $i <= 5; $i++)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>
                                            <input type="text" class="form-control" name="aspek_{{ $i }}" 
                                                value="{{ $record ? $record['aspek_'.$i] : '' }}" required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="aktivitas_{{ $i }}" 
                                                value="{{ $record ? $record['aktivitas_'.$i] : '' }}" required>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="capaian_{{ $i }}" 
                                                min="0" max="100" 
                                                value="{{ $record ? $record['capaian_'.$i] : '' }}" required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="keterangan_{{ $i }}" 
                                                value="{{ $record ? $record['keterangan_'.$i] : '' }}" required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="catatan_{{ $i }}" 
                                                value="{{ $record ? $record['catatan_'.$i] : '' }}" required>
                                        </td>
                                    </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3 d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ $record ? 'Update' : 'Submit' }} Form
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script>
        document.getElementById('innovationForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Validate all required fields
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            let errorMessage = 'Harap lengkapi semua field:\n';

            requiredFields.forEach(field => {
                // Remove previous error highlights
                field.classList.remove('input-error');

                // Check if field is empty
                if (!field.value.trim()) {
                    field.classList.add('input-error');
                    isValid = false;
                    errorMessage +=
                        `- ${field.previousElementSibling ? field.previousElementSibling.textContent : 'Field'}\n`;
                }

                // Special validation for percentage fields
                if (field.type === 'number' && field.min !== '' && field.max !== '') {
                    const value = parseFloat(field.value);
                    const min = parseFloat(field.min);
                    const max = parseFloat(field.max);

                    if (isNaN(value) || value < min || value > max) {
                        field.classList.add('input-error');
                        isValid = false;
                        errorMessage +=
                            `- ${field.previousElementSibling ? field.previousElementSibling.textContent : 'Persentase'} harus antara ${min} dan ${max}\n`;
                    }
                }
            });

            // If form is not valid, show error alert
            if (!isValid) {
                alert(errorMessage);
                return;
            }

            // If all validations pass, show success alert
            const formData = new FormData(this);
            let submissionDetails = 'Data yang diinput:\n\n';

            for (let [name, value] of formData.entries()) {
                submissionDetails += `${name}: ${value}\n`;
            }

            alert('Formulir berhasil disubmit!\n\n' + submissionDetails);

            // Optional: Submit the form
            this.submit();
        });
    </script>
@endsection