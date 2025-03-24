<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>KATSINOV-MeterO - Innovation Measurement System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link href="{{ asset('aspect-analysis.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('inovasi/dashboard/form_katsinov/css/form.css') }}">

    <script src="{{ asset('aspect-legend.js') }}"></script>
    <script src="{{ asset('aspect-analysis-integrated.js') }}"></script>
    <script src="{{ asset('spiderweb-chart-script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

@extends('inovasi.admin_hilirisasi.index')

{{-- @include('admin.sidebaradmin') --}}

{{-- @section('contentadmin')
@endsection --}}

<body x-data="aspectLegend()" x-init="init()">


    <!-- Main Content -->
    <main class="container">
        <form id="katsinovForm" method="POST" action="{{ route('katsinov.store') }}">
            {{-- @include('admin.navbaradmin') --}}
            @csrf

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
                    <input type="text" class="form-input" name="title" placeholder="Masukkan nama/judul">
                </div>

                <div class="form-group">
                    <div class="form-label">Fokus Bidang</div>
                    <input type="text" class="form-input" name="focus_area" placeholder="Masukkan fokus bidang">
                </div>

                <div class="form-group">
                    <div class="form-label">Nama Proyek</div>
                    <input type="text" class="form-input" name="project_name" placeholder="Masukkan nama proyek">
                </div>

                <div class="form-group">
                    <div class="form-label">Nama Lembaga/Perusahaan</div>
                    <input type="text" class="form-input" name="institution"
                        placeholder="Masukkan nama lembaga/perusahaan">
                </div>

                <div class="form-group">
                    <div class="form-label">Alamat / Kontak</div>
                    <div>
                        <input type="text" class="form-input" name="address" placeholder="Masukkan alamat lengkap">
                        <div style="margin-top: 0.75rem;">
                            <input type="text" class="form-input" name="contact" placeholder="Telp / Fax / email">
                        </div>
                    </div>
                </div>

                <div class="date-section">
                    <div class="form-group">
                        <div class="form-label">Tanggal</div>
                        <input type="date" id="assessment_date" name="assessment_date"
                            class="form-input @error('assessment_date') border-red-500 @enderror"
                            value="{{ old('assessment_date', date('Y-m-d')) }}" required>
                    </div>
                </div>

                <div class="progress-container">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                        <span style="font-weight: 500; color: var(--text);">Batas Minimum Capaian</span>
                        <span
                            style="padding: 0.5rem 1rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px;">80.0%</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-weight: 500; color: var(--text);">Batas Maksimum Capaian</span>
                        <span
                            style="padding: 0.5rem 1rem; background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); color: var(--text-dark); border-radius: 8px;">100.0%</span>
                    </div>
                </div>

                <div class="legend" x-data="aspectLegend()">
                    <h3 class="text-gray-700 mb-6 text-lg">Keterangan:</h3>
                    <div class="legend-grid">
                        <!-- Teknologi -->
                        <div class="legend-item cursor-pointer" @click="openAspectAnalysis('T')">
                            <div class="legend-box"
                                style="background: linear-gradient(135deg, #fad961 0%, #f76b1c 100%);"></div>
                            <span>Aspek Teknologi (T)</span>
                        </div>

                        <!-- Organisasi -->
                        <div class="legend-item cursor-pointer" @click="openAspectAnalysis('O')">
                            <div class="legend-box"
                                style="background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);"></div>
                            <span>Aspek Organisasi (O)</span>
                        </div>

                        <!-- Risiko -->
                        <div class="legend-item cursor-pointer" @click="openAspectAnalysis('R')">
                            <div class="legend-box"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                            <span>Aspek Risiko (R)</span>
                        </div>

                        <!-- Pasar -->
                        <div class="legend-item cursor-pointer" @click="openAspectAnalysis('M')">
                            <div class="legend-box"
                                style="background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);"></div>
                            <span>Aspek Pasar (M)</span>
                        </div>

                        <!-- Kemitraan -->
                        <div class="legend-item cursor-pointer" @click="openAspectAnalysis('P')">
                            <div class="legend-box"
                                style="background: linear-gradient(135deg, #ffd1ff 0%, #fab2ff 100%);"></div>
                            <span>Aspek Kemitraan (P)</span>
                        </div>

                        <!-- Manufaktur -->
                        <div class="legend-item cursor-pointer" @click="openAspectAnalysis('Mf')">
                            <div class="legend-box"
                                style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);"></div>
                            <span>Aspek Manufaktur (Mf)</span>
                        </div>

                        <!-- Investasi -->
                        <div class="legend-item cursor-pointer" @click="openAspectAnalysis('I')">
                            <div class="legend-box"
                                style="background: linear-gradient(135deg, #96fbc4 0%, #f9f586 100%);"></div>
                            <span>Aspek Investasi (I)</span>
                        </div>
                    </div>
                    <!-- Aspect Analysis Popup -->
                    <div x-show="showPopup" class="aspect-popup" @click.self="showPopup = false"
                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                        <div class="popup-content">
                            <div class="popup-header" :style="{ background: selectedAspect?.gradient }">
                                <h3 class="text-white text-xl font-semibold"
                                    x-text="'Analysis ' + selectedAspect?.name"></h3>
                                <button @click="showPopup = false" class="popup-close">&times;</button>
                            </div>

                            <div class="popup-body">
                                <div class="chart-container">
                                    <canvas id="aspectChart"></canvas>
                                </div>

                                <div class="summary-container">
                                    <div class="summary-item">
                                        <span class="label">Rata-rata Pencapaian:</span>
                                        <span class="value" x-text="calculateAverage() + '%'"></span>
                                    </div>
                                    <div class="summary-item">
                                        <span class="label">Level KATSINOV Tercapai:</span>
                                        <span class="value" x-text="getMaxKatsinovLevel()"></span>
                                    </div>
                                    <div class="summary-item">
                                        <span class="label">Status:</span>
                                        <span class="value" :class="getStatusClass()" x-text="getStatus()"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="spiderweb-trigger" style="position: fixed; bottom: 20px; right: 20px; z-index: 100;">
                    <button type="button" @click="openSpiderwebAnalysis()"
                        class="bg-primary text-white px-4 py-2 rounded-full shadow-lg hover:bg-primary-dark transition-colors"
                        style="background-color: #176369; color: white; padding: 10px 20px; border-radius: 30px;">
                        Lihat Analisis Aspek
                    </button>
                </div>

                <!-- Spiderweb Analysis Popup -->
                <div x-show="showSpiderwebPopup" class="spiderweb-popup" @click.self="showSpiderwebPopup = false"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; z-index: 1000;">
                    <div class="popup-content"
                        style="background: white; border-radius: 10px; width: 90%; max-width: 800px; max-height: 90%; overflow: auto; padding: 20px;">
                        <div class="popup-header"
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h3 class="text-xl font-semibold">Analisis Keseluruhan Aspek KATSINOV</h3>
                            <button @click="showSpiderwebPopup = false" class="popup-close"
                                style="background: none; border: none; font-size: 24px; cursor: pointer;">&times;</button>
                        </div>

                        <div class="popup-body" style="display: flex; flex-direction: column; gap: 20px;">
                            <div class="chart-container" style="width: 100%; height: 400px;">
                                <canvas id="spiderwebChart"></canvas>
                            </div>

                            <div class="summary-container"
                                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                                <div class="summary-item"
                                    style="background: #f0f4f8; padding: 15px; border-radius: 8px;">
                                    <span class="label block text-gray-600 mb-2">Rata-rata Pencapaian:</span>
                                    <span class="rata-rata-pencapaian text-xl font-bold text-primary">0.0%</span>
                                </div>
                                <div class="summary-item"
                                    style="background: #f0f4f8; padding: 15px; border-radius: 8px;">
                                    <span class="label block text-gray-600 mb-2">Aspek Terpenuhi:</span>
                                    <span class="aspek-terpenuhi text-xl font-bold text-primary">0 dari 7</span>
                                </div>
                                <div class="summary-item"
                                    style="background: #f0f4f8; padding: 15px; border-radius: 8px;">
                                    <span class="label block text-gray-600 mb-2">Status Keseluruhan:</span>
                                    <span class="status-keseluruhan text-xl font-bold">BELUM TERPENUHI</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <buttom>
                <a href="{{ route('admin.hilirisasi.lampiran') }}">
                    <button type="button"
                        style="background-color: #176369; color: white; padding: 10px 20px; border: none; cursor: pointer;">Lampiran</button>
                </a>
            </buttom>
            </div>
            @include('Inovasi.admin_hilirisasi.indikator1')
            @include('Inovasi.admin_hilirisasi.indikator2')
            @include('Inovasi.admin_hilirisasi.indikator3')
            @include('Inovasi.admin_hilirisasi.indikator4')
            @include('Inovasi.admin_hilirisasi.indikator5')
            @include('Inovasi.admin_hilirisasi.indikator6')
            @include('Inovasi.admin_hilirisasi.jumlahindikator')
            <!-- Submit All Button -->
            <div class="submit-all-container"
                style="
            display: flex;
            justify-content: center;
            margin-top: 2rem;
            margin-bottom: 2rem;
        ">
                <button type="submit" id="submitAllBtn" class="submit-all-btn"
                    style="
                    background-color: #176369;
                    color: white;
                    padding: 12px 24px;
                    border: none;
                    border-radius: 8px;
                    font-size: 1rem;
                    font-weight: 600;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                "
                    onclick="submitAllIndicators()">
                    Submit Semua Indikator KATSINOV
                </button>
            </div>
        </form>
    </main>

    {{-- <script>
        function validateForm() {
            let isValid = true;

            // Cek semua radio button terisi
            document.querySelectorAll('.katsinov-table').forEach(table => {
                const filled = table.querySelectorAll('input[type="radio"]:checked').length;
                const totalRows = table.querySelectorAll('tr:not(.total-row)').length - 1; // Exclude header

                if (filled < totalRows) {
                    isValid = false;
                    table.scrollIntoView({
                        behavior: 'smooth'
                    });
                    table.style.border = '2px solid red';
                    setTimeout(() => table.style.border = '', 3000);
                }
            });

            return isValid;
        }

        async function submitAllIndicators() {

            const btn = document.getElementById('submitAllBtn');

            btn.disabled = true;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Menyimpan...';

            try {
                const formData = new FormData(document.getElementById('katsinovForm'));
                const indicators = collectAspectScores();

                indicators.forEach((indicator, index) => {
                    for (const [key, value] of Object.entries(indicator)) {
                        formData.append(`indicators[${index}][${key}]`, value);
                    }
                });

                const response = await fetch('/katsinov/store', { // ✏️ Perbaiki disini
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();
                if (!response.ok) throw new Error(data.message || 'Gagal menyimpan data');

                Swal.fire({
                icon: 'success',
                title: '🎉 Selamat!',
                html: `
                    <div style="
                        background: linear-gradient(135deg, #ffffff 0%, #f0f4f8 100%);
                        border-radius: 20px; 
                        padding: 30px; 
                        text-align: center;
                        max-width: 450px;
                        margin: 0 auto;
                        border: 1px solid rgba(23, 99, 105, 0.1);
                        box-shadow: 0 20px 40px rgba(23, 99, 105, 0.1);
                    ">
                        <div style="
                            width: 80px;
                            height: 80px;
                            background-color: #e6f6f7;
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            margin: 0 auto 20px;
                            box-shadow: 0 10px 20px rgba(23, 99, 105, 0.1);
                        ">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#176369" stroke-width="2.5">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                <polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                        </div>
                        
                        <h2 style="
                            color: #176369;
                            font-size: 22px;
                            font-weight: 700;
                            margin-bottom: 15px;
                        ">
                            Indikator KATSINOV Berhasil
                        </h2>
                        
                        <p style="
                            color: #2d3748; 
                            font-size: 16px; 
                            line-height: 1.6;
                            margin-bottom: 20px;
                        ">
                            Terima kasih atas partisipasi Anda. Data Anda telah berhasil disimpan dalam sistem kami dengan sempurna.
                        </p>
                        
                        <div style="
                            background-color: #f0f9fa; 
                            border-left: 5px solid #176369;
                            padding: 12px 15px;
                            border-radius: 8px;
                            margin-bottom: 20px;
                            text-align: left;
                        ">
                            <p style="
                                color: #4a5568;
                                font-size: 14px;
                                margin: 0;
                            ">
                                ⏳ Halaman akan dimuat ulang dalam beberapa saat...
                            </p>
                        </div>
                    </div>
                `,
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#176369',
                showCloseButton: false,
                allowOutsideClick: false,
                width: '500px',
                willClose: () => window.location.reload(),
                didOpen: () => {
                    const style = document.createElement('style');
                    style.textContent = `
                        .swal2-popup {
                            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
                            border-radius: 20px;
                            box-shadow: 0 30px 60px rgba(23, 99, 105, 0.15);
                            animation: softBounce 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
                        }

                        @keyframes softBounce {
                            0% { transform: scale(0.8); opacity: 0; }
                            70% { transform: scale(1.03); opacity: 0.9; }
                            100% { transform: scale(1); opacity: 1; }
                        }

                        .swal2-confirm {
                            padding: 12px 24px !important;
                            font-weight: 700;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                            border-radius: 10px;
                            transition: all 0.3s ease;
                        }

                        .swal2-confirm:hover {
                            transform: translateY(-3px);
                            box-shadow: 0 6px 20px rgba(23, 99, 105, 0.3);
                        }

                        .swal2-icon.swal2-success {
                            border-color: rgba(23, 99, 105, 0.2) !important;
                        }

                        .swal2-success-ring {
                            border-color: #176369 !important;
                            opacity: 0.3;
                        }
                    `;
                    document.head.appendChild(style);
                }
            });

            } catch (error) {
                Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    html: `
        <div style="
            background-color: #fff0f3;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            max-width: 400px;
            margin: 0 auto;
        ">
            <p style="
                color: #4a4a4a;
                font-size: 16px;
                line-height: 1.6;
                margin-bottom: 10px;
            ">
                ${error.message}
            </p>
        </div>
    `,
    confirmButtonText: 'Tutup',
    confirmButtonColor: '#dc2626',
    didOpen: () => {
        const style = document.createElement('style');
        style.textContent = `
            .swal2-popup {
                font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
                border-radius: 15px;
                box-shadow: 0 10px 25px rgba(220, 38, 38, 0.1);
            }
            .swal2-confirm {
                padding: 10px 20px !important;
                font-weight: 600;
                text-transform: uppercase;
                transition: all 0.3s ease;
            }
            .swal2-confirm:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(220, 38, 38, 0.2);
            }
            .swal2-icon.swal2-error {
                margin-bottom: 10px !important;
            }
        `;
        document.head.appendChild(style);
    }
});
            } finally {
                btn.disabled = false;
                btn.innerHTML = 'Submit Semua Indikator KATSINOV';
            }
        }
    </script>

    <!-- Sweet Alert Library untuk notifikasi -->


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
    </script> --}}
    <!-- In the head section -->


    <script src="{{ asset('inovasi/dashboard/form_katsinov/js/form.js') }}"></script>
</body>


</html>
