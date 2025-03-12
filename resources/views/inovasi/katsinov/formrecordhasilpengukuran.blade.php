<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/inovasi/formrecordhasilpengukuran.css">
</head>

<body>
    <div class="form-container">
        @if (session('success'))
            <script>
                alert("{{ session('success') }}");
            </script>
        @endif
        <!-- Perhatikan atribut action dan method di form -->
        <form id="innovationForm" action="{{ route('admin.Katsinov.formrecordhasilpengukuran.store') }}" method="POST">
            @csrf
            <div class="form-header">
                <h1 class="form-title">Record Hasil Pengukuran Katsinov</h1>

                <div class="form-group">
                    <label class="form-label">Nama Penanggungjawab</label>
                    <input type="text" name="nama_penanggung_jawab" class="form-input"
                        placeholder="Masukkan nama penanggungjawab" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Institusi</label>
                    <input type="text" name="institusi" class="form-input" placeholder="Masukkan nama institusi"
                        required>
                </div>
                <div class="form-group">
                    <label class="form-label">Judul Inovasi</label>
                    <input type="text" name="judul_inovasi" class="form-input" placeholder="Masukkan judul inovasi"
                        required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis Inovasi</label>
                    <input type="text" name="jenis_inovasi" class="form-input" placeholder="Masukkan jenis inovasi"
                        required>
                </div>
                <div class="form-group">
                    <label class="form-label">Alamat Kontak</label>
                    <textarea name="alamat_kontak" class="form-input" rows="2" placeholder="Masukkan alamat kontak" required></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="tel" name="phone" class="form-input" placeholder="Masukkan nomor telepon"
                        required>
                </div>
                <div class="form-group">
                    <label class="form-label">Fax</label>
                    <input type="tel" name="fax" class="form-input" placeholder="Masukkan nomor fax" required>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th class="header-no-border no-column centered-column" scope="col">No.</th>
                        <th class="header-no-border aspek-column centered-column" scope="col">Aspek</th>
                        <th class="header-no-border aktivitas-column centered-column" scope="col">Aktivitas Kunci
                        </th>
                        <th colspan="2">
                            <div class="flex flex-col items-center">
                                <span>Penilaian</span>
                                <label class="date-label">Tanggal Penilaian</label>
                                <input type="date" name="tanggal_penilaian" class="date-input" required>
                            </div>
                        </th>
                        <th class="header-no-border centered-column" scope="col">Catatan Secara Umum</th>
                    </tr>
                    <tr>
                        <th class="cell-no-border no-column"></th>
                        <th class="cell-no-border"></th>
                        <th class="cell-no-border"></th>
                        <th>Capaian (%)</th>
                        <th>Keterangan</th>
                        <th class="cell-no-border"></th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i <= 5; $i++)
                        <tr>
                            <td class="no-column centered-column">{{ $i }}</td>
                            <td><input type="text" name="aspek_{{ $i }}" class="table-input"
                                    placeholder="Masukkan aspek" required></td>
                            <td><input type="text" name="aktivitas_{{ $i }}" class="table-input"
                                    placeholder="Masukkan aktivitas kunci" required></td>
                            <td><input type="number" name="capaian_{{ $i }}" min="0" max="100"
                                    class="table-input percentage-input" placeholder="%" required></td>
                            <td><input type="text" name="keterangan_{{ $i }}" class="table-input"
                                    placeholder="Masukkan keterangan" required></td>
                            <td><input type="text" name="catatan_{{ $i }}" class="table-input"
                                    placeholder="Masukkan catatan" required></td>
                        </tr>
                    @endfor
                </tbody>
            </table>

            <div class="mt-6 flex justify-center">
                <button type="submit" class="submit-button">
                    Submit Form
                </button>
            </div>
        </form>
    </div>

    <!-- Script validasi tetap bisa digunakan jika diperlukan -->
    <script>
        document.getElementById('innovationForm').addEventListener('submit', function(event) {
            // Client side validation, optional jika Anda sudah mengandalkan validasi dari backend
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            let errorMessage = 'Harap lengkapi semua field:\n';

            requiredFields.forEach(field => {
                field.classList.remove('input-error');

                if (!field.value.trim()) {
                    field.classList.add('input-error');
                    isValid = false;
                    errorMessage +=
                        `- ${field.previousElementSibling ? field.previousElementSibling.textContent : 'Field'}\n`;
                }

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

            if (!isValid) {
                alert(errorMessage);
                event.preventDefault();
            }
        });
    </script>
</body>

</html>
