<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KATSINOV-MeterO - Innovation Measurement System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('kasinov123.css') }}">

</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <div class="container">
            <h1>
                <span class="logo-katsinov">KATSINOV</span>
                <span class="accent-dot"></span>
                <span class="logo-meter">MeterO</span>
            </h1>
            <div class="header-subtitle">INNOVATION MEASUREMENT SYSTEM</div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container">
        <!-- Explanation Card -->
        <div class="card" data-aos="fade-up">
            <div class="main-title">
                PENGUKURAN TINGKAT KESIAPAN INOVASI (KATSINOV)
            </div>
            <div class="content">
                <div class="content-title">Penjelasan</div>
                <div class="content-text">
                    <span class="highlight">IRL-Meter (Innovation Readiness Level - Meter)</span> atau 
                    <span class="highlight">KATSINOV-Meter (Tingkat Kesiapan Inovasi - Meter)</span> 
                    adalah sebuah alat ukur yang digunakan untuk mengukur tingkat kesiapan atau kematangan 
                    inovasi yang dilakukan oleh suatu perusahaan dan/ atau proyek/program/kegiatan. 
                    KATSINOV-Meter menggunakan pendekatan siklus hidup inovasi, dimana dapat menggambarkan 
                    perkembangan inovasi.
                </div>
                
                <div class="content-text">
                    Kerangka konseptual IRL adalah model <span class="highlight">6"C" (Concept, Component, 
                    Completion, Chasin, Competition, Changeover/ Closedown)</span>, yang memisahkan secara 
                    komprehensif siklus hidup inovasi ke dalam 6 fase (tingkat kesiapan), dan memberikan 
                    arah bagi manajemen dalam melaksanakan proses inovasi dengan memperhatikan 7 aspek 
                    kunci (teknologi, pasar, organisasi, manufaktur, investment, kemitraan dan risiko).
                </div>

                <div class="content-text">
                    Pengukuran IRL sangat penting untuk:
                </div>
                <div class="list-container">
                    <div class="list-item" data-aos="fade-right" data-aos-delay="100">
                        Menggambarkan perkembangan inovasi
                    </div>
                    <div class="list-item" data-aos="fade-right" data-aos-delay="200">
                        Membantu mengimplementasikan inovasi diatas siklus-hidup yang lebih efektif
                    </div>
                    <div class="list-item" data-aos="fade-right" data-aos-delay="300">
                        Mengantisipasi persaingan pasar yang semakin sengit
                    </div>
                    <div class="list-item" data-aos="fade-right" data-aos-delay="400">
                        Mengantisipasi tingkat inovasi atau siklus hidup teknologi yang lebih cepat
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="form-container" data-aos="fade-up" data-aos-delay="500">
            <div class="document-number">No: 20190802-001</div>

            <div class="form-group">
                <div class="form-label">Nama/Judul</div>
                <input type="text" class="form-input" placeholder="Masukkan nama/judul">
            </div>

            <div class="form-group">
                <div class="form-label">Fokus Bidang</div>
                <input type="text" class="form-input" placeholder="Masukkan fokus bidang">
            </div>

            <div class="form-group">
                <div class="form-label">Nama Proyek</div>
                <input type="text" class="form-input" placeholder="Masukkan nama proyek">
            </div>

            <div class="form-group">
                <div class="form-label">Nama Lembaga/Perusahaan</div>
                <input type="text" class="form-input" placeholder="Masukkan nama lembaga/perusahaan">
            </div>

            <div class="form-group">
                <div class="form-label">Alamat / Kontak</div>
                <div>
                    <input type="text" class="form-input" placeholder="Masukkan alamat lengkap">
                    <div style="margin-top: 0.75rem;">
                        <input type="text" class="form-input" placeholder="Telp / Fax / email">
                    </div>
                </div>
            </div>

            <div class="date-section">
        <div class="form-group">
            <div class="form-label">Tanggal</div>
            <input 
                type="date" 
                class="form-input" 
                id="measurement-date" 
                value="2019-08-02" 
                min="2000-01-01" 
                max="2050-12-31"
            >
        </div>
    </div>

            <div class="progress-container">
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                    <span style="font-weight: 500; color: var(--text);">Batas Minimum Capaian</span>
                    <span style="padding: 0.5rem 1rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px;">80.0%</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="font-weight: 500; color: var(--text);">Batas Maksimum Capaian</span>
                    <span style="padding: 0.5rem 1rem; background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); color: var(--text-dark); border-radius: 8px;">100.0%</span>
                </div>
            </div>

            <div class="legend">
                <h3 style="color: var(--text); margin-bottom: 1.5rem; font-size: 1.2rem;">Keterangan:</h3>
                <div class="legend-grid">
                    <div class="legend-item">
                        <div class="legend-box" style="background: linear-gradient(135deg, #fad961 0%, #f76b1c 100%);"></div>
                        <span>Aspek Teknologi (T)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-box" style="background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);"></div>
                        <span>Aspek Organisasi (O)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-box" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                        <span>Aspek Risiko (R)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-box" style="background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);"></div>
                        <span>Aspek Pasar (M)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-box" style="background: linear-gradient(135deg, #ffd1ff 0%, #fab2ff 100%);"></div>
                        <span>Aspek Kemitraan (P)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-box" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);"></div>
                        <span>Aspek Manufaktur (Mf)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-box" style="background: linear-gradient(135deg, #96fbc4 0%, #f9f586 100%);"></div>
                        <span>Aspek Investasi (I)</span>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('inovasi.Kasinov.Indikator1')
    @include('inovasi.Kasinov.Indikator2')
    @include('inovasi.Kasinov.Indikator3')
    @include('inovasi.Kasinov.Indikator4')
    @include('inovasi.Kasinov.Indikator5')
    @include('inovasi.Kasinov.Indikator6')
    @include('inovasi.Kasinov.jumlahindikator')
    <footer style="background: #176369; color: white; text-align: center; padding: 1rem; margin-top: 2rem;">
        <p>&copy; 2024 KATSINOV-MeterO. Innovation Measurement System</p>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        // Initialize AOS (Animate On Scroll)
        AOS.init({
            duration: 800, 
            offset: 100,
            once: true
        });

        // Form Interactivity
        document.addEventListener('DOMContentLoaded', () => {
            const formInputs = document.querySelectorAll('.form-input');
            
            formInputs.forEach(input => {
                input.addEventListener('focus', (e) => {
                    e.target.style.borderColor = 'var(--primary)';
                });

                input.addEventListener('blur', (e) => {
                    e.target.style.borderColor = 'var(--background)';
                });
            });

            // Simple form validation (optional)
            const form = document.querySelector('.form-container');
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                let isValid = true;

                formInputs.forEach(input => {
                    if (!input.value.trim()) {
                        input.style.borderColor = '#FF6B6B';
                        isValid = false;
                    }
                });

                if (isValid) {
                    alert('Formulir berhasil disubmit!');
                    // You can add more complex submission logic here
                }
            });
        });
    </script>
</body>
</html>
