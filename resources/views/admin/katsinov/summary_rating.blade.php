@extends('admin.admin')

@section('contentadmin')
    <link href="{{ asset('aspect-analysis.css') }}" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

    <div class="head-title">
        <div class="left">
            <h1>KATSINOV Rating Summary</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a href="{{ route('admin.katsinov.TableKatsinov') }}">KATSINOV Data</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Rating Summary</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Innovation Rating Summary for: {{ $katsinov->title }}</h3>
            </div>

            <div class="card mb-4">
                <div class="card-header" style="background-color: #277177; color: white;">
                    <h4 class="m-0">Innovation Details</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Project Name:</strong> {{ $katsinov->project_name }}</p>
                            <p><strong>Focus Area:</strong> {{ $katsinov->focus_area }}</p>
                            <p><strong>Institution:</strong> {{ $katsinov->institution }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Assessment Date:</strong>
                                {{ \Carbon\Carbon::parse($katsinov->assessment_date)->format('d M Y') }}</p>
                            <p><strong>Status:</strong>
                                @php
                                    // This calculation assumes $overallAspectScores is passed from the controller
                                    $avgScore =
                                        array_sum(array_values($overallAspectScores)) / count($overallAspectScores);
                                @endphp
                                <span
                                    class="badge {{ $avgScore >= 80 ? 'bg-success' : ($avgScore >= 60 ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $avgScore >= 80 ? 'Ready' : ($avgScore >= 60 ? 'Developing' : 'Needs Review') }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center"
                    style="background-color: #277177; color: white;">
                    <h4 class="m-0">Overall Aspect Performance</h4>
                </div>
                <div class="card-body">
                    <div class="chart-container position-relative" style="height:400px;">
                        <canvas id="overallChart"></canvas>
                    </div>
                </div>
            </div>

            @php
                $indicators = [1, 2, 3, 4, 5, 6];
                $indicatorTitles = [
                    'Basic Research & Technology Development',
                    'Technology Demonstration',
                    'Technology Refinement & Implementation',
                    'Market Introduction & Commercialization',
                    'Market Expansion & Support',
                    'Sustainable Market & Future Planning',
                ];
                 $aspectNames = [
                    'technology' => 'Technology (T)',
                    'market' => 'Market (M)',
                    'organization' => 'Organization (O)',
                    'manufacturing' => 'Manufacturing (Mf)',
                    'partnership' => 'Partnership (P)',
                    'investment' => 'Investment (I)',
                    'risk' => 'Risk (R)',
                ];
                $aspectColors = [
                    'technology' => 'rgb(255, 99, 132)',
                    'market' => 'rgb(54, 162, 235)',
                    'organization' => 'rgb(255, 206, 86)',
                    'manufacturing' => 'rgb(75, 192, 192)',
                    'partnership' => 'rgb(153, 102, 255)',
                    'investment' => 'rgb(255, 159, 64)',
                    'risk' => 'rgb(70, 150, 130)',
                ];
                 $indicatorQuestions = [
                    1 => [
                        'technology' => ['Ide baru yang memberi solusi permasalahan masyarakat.', 'Telah dilakukan pengamatan prinsip-prinsip ilmiah dasar dan publikasi ilmiah.', 'Faktor yang membedakan temuan dengan temuan lain dan unsur kebaruan dari sebuah ide atau gagasan telah diidentifikasi.', 'Mengidentifikasi tahapan riset dan targetnya.', 'Teknologi yang akan dikembangkan telah layak secara ilmiah (scientific feasibility).'],
                        'market' => ['Inovasi dilakukan berdasarkan permintaan dan/atau kebutuhan pelanggan.', 'Permintaan dan kebutuhan pelanggan telah diidentifikasi.', 'Telah mengidentifikasikan lokasi pasar yang akan dituju.'],
                        'organization' => ['Telah memiliki strategi inovasi.', 'Lingkup proyek dan tugas telah diidentifikasi.', 'Kebutuhan akan sumber daya, dana dan fasilitas penelitian telah dikonfirmasi.', 'Tersedia saluran komunikasi tanpa hambatan.'],
                        'manufacturing' => ['Konsekuensi hasil temuan telah diidentifikasi melalui dasar manufaktur ekonomis.', 'Teridentifikasi dalam konsep manufaktur secara teknis dan ekonomis.', 'Tersedia bukti konsep manufaktur melalui analitik atau eksperimen laboratorium.'],
                        'investment' => ['Ide yang dikembangkan memiliki konsep model bisnis.', 'Ide yang dikembangkan memiliki hasil analisis pelanggan, pasar, dan pesaing.', 'Ide yang dikembangkan telah terbukti memberi solusi bagi pelanggan.'],
                        'partnership' => ['Telah tersusun strategi membangun jaringan kerja dan kemitraan.', 'Mitra potensial telah diidentifikasi.'],
                        'risk' => ['Kajian risiko teknologi telah menjadi pertimbangan dalam setiap langkah penelitian.', 'Pada tahap penelitian dilakukan penyusunan rencana pengendalian risiko teknologi.'],
                    ],
                    2 => [
                        'technology' => ['Telah melakukan validasi terhadap komponen individu dari teknologi.', 'Prototipe telah didemonstrasikan dalam lingkungan yang relevan.', 'Teknologi dinyatakan layak secara teknis.', 'Telah melakukan pendaftaran kekayaan intelektual (misal: paten, desain industri, hak cipta, merek, dll).', 'Secara teknis mampu memberikan solusi terhadap permasalahan yang dihadapi masyarakat.'],
                        'market' => ['Pelanggan akhir teridentifikasi.', 'Telah mengeluarkan rencana peluncuran produk baru ke pasar secara rinci.', 'Telah memulai kesiapan modal intelektual (intellectual capital).'],
                        'organization' => ['Analisis dan rencana bisnis telah dikeluarkan.', 'Telah memiliki keterlibatan dengan individu kunci.', 'Telah melakukan persetujuan persyaratan proyek dan daftar mitra proyek.', 'Telah melakukan persetujuan tanggung jawab dan persetujuan batas waktu dalam pengelolaan suatu proyek.'],
                        'manufacturing' => ['Identifikasi teknologi dan komponen kritikal telah komplit.', 'Material, perkakas dan alat uji prototipe, maupun keahlian personel telah diperlihatkan oleh sub system/system dalam suatu lingkungan produksi yang relevan.'],
                        'investment' => ['Keunggulan jual yang dimiliki telah teruji kepada pelanggan.', 'Solusi yang ditawarkan kepada pelanggan memunculkan daya tarik yang menguntungkan di pasar.', 'Validasi value proposition, channel, segmen pelanggan, model hubungan dengan pelanggan yang ada, dan aliran revenue terbukti telah dilakukan.'],
                        'partnership' => ['Telah melakukan penggalian informasi dan seleksi mitra.', 'Pola kemitraan dibangun dengan tepat.'],
                        'risk' => ['Kajian risiko teknologi telah dilakukan dalam setiap langkah pengembangan teknologi.', 'Pada tahap pengembangan teknologi dilakukan penyusunan rencana pengendalian risiko teknologi.'],
                    ],
                    3 => [
                        'technology' => ['Sistem aktual teknologi telah didemonstrasikan dalam lingkungan yang sebenarnya.', 'Uji eksternal dari teknologi yang dikembangkan telah dilakukan secara lengkap, dalam rangka memenuhi persyaratan teknis dan kesesuaian regulasi.', 'Telah mendokumentasikan teknologi yang dikembangkan.', 'Hasil Inovasi telah diperkenalkan.', 'Telah memperoleh Kekayaan intelektual (misal: paten, desain industri, hak cipta, merek, dll).'],
                        'market' => ['Kebutuhan khusus dan keperluan pelanggan telah diketahui.', 'Segmen, ukuran dan pangsa pasar telah diprediksi.', 'Produk telah diperkenalkan, dan harganya telah ditetapkan.'],
                        'organization' => ['Penetapan organisasi (struktur bisnis dengan staff dan kolaborator).', 'Identifikasi beberapa tambahan staff yang dibutuhkan.', 'Telah merincikan pembagian tanggung jawab dan beban kerja.'],
                        'manufacturing' => ['Desain sistem sebagian besar stabil dan terbukti dalam uji dan evaluasi.', 'Proses dan prosedur manufaktur terbukti dalam skala pilot.', 'Produksi pada laju rendah telah dilaksanakan.'],
                        'investment' => ['Telah mendefinisikan kondisi akhir dari produk teknologi dengan mempertimbangkan target person, pasar vertikal, serta geografik.', 'Validasi terhadap bisnis yang dilakukan sudah diterapkan.', 'Identifikasi dan validasi terhadap indikator kinerja utama yang mengindikasikan keberhasilan bisnis.'],
                        'partnership' => ['Telah terjalin kemitraan secara formal.', 'Telah menyusun dan telah menerapkan rencana kerja sama.'],
                        'risk' => ['Kajian risiko teknologi menjadi dasar pengambilan keputusan teknis dalam tahap engineering & Operation.', 'Pada tahap penerapan teknologi dilakukan penyusunan rencana pengendalian risiko teknologi.'],
                    ],
                    4 => [
                        'technology' => ['Telah terbentuk keahlian terkait pengoperasian dan pemeliharaan produk teknologi.', 'Penggunaan umum produk teknologi oleh cakupan pasar yang luas telah diidentifikasi.', 'Keuntungan teknologi melalui hasil pengujian telah diidentifikasi.', 'Adanya dukungan terhadap adopsi produk teknologi oleh pasar.'],
                        'market' => ['Telah membangun citra produk teknologi kepada pasar.', 'Model bisnis ditetapkan.', 'Pesaing diidentifikasi dengan baik.', 'Pemasaran ditekankan pada pengenalan secara spesifik produk teknologi kepada para pelanggannya.'],
                        'organization' => ['Telah menetapkan bentuk organisasi.', 'Telah mengembangkan kemitraan dengan organisasi independen.', 'Identifikasi peluang untuk memperkenalkan produk kepada mitra dan pasar baru.'],
                        'manufacturing' => ['Telah diperlihatkan produksi yang menguntungkan secara finansial.', 'Mulai menerapkan GMP (Good Manufacturing Practice) atau Lean Manufacturing.', 'Mulai menerapkan jaminan mutu sesuai standar (SNI).', 'Adanya tuntutan masyarakat terhadap mutu, keamanan dan keselamatan produk yang dimanfaatkan.'],
                        'partnership' => ['Melakukan kerja sama di dalam jejaring usaha secara dinamis.', 'Terus melakukan pengelolaan terhadap kerjasama yang sudah berjalan.'],
                        'investment' => ['Potensi pasar teridentifikasi.', 'Daya terima pasar terhadap produk telah teridentifikasi.'],
                        'risk' => ['Penyusunan rencana pengendalian risiko non teknologi (organisasi dan sosial) pada tahap pengenalan produk ke pasar.', 'Kajian risiko organisasi (khususnya indikator keuangan) dilakukan pada tahap pengenalan produk ke pasar.', 'Kajian risiko dampak sosial pada tahap pengenalan produk ke pasar.'],
                    ],
                    5 => [
                        'technology' => ['Adanya garansi terhadap produk teknologi yang dipasarkan.', 'Layanan pemeliharaan produk telah disediakan.', 'Pasokan suku cadang untuk produk teknologi telah disediakan.', 'Adanya aktivitas pengembangan dengan intensitas lebih rendah, untuk peningkatan kerja produk teknologi sesuai permintaan pelanggan.'],
                        'market' => ['Telah menyediakan pelayanan dan solusi yang lengkap.', 'Telah melakukan diferensiasi produk.', 'Telah melakukan penyempurnaan model bisnis.', 'Telah menggunakan kemitraan untuk berkompetisi di pasar.'],
                        'organization' => ['Telah meningkatkan efektivitas dan kerjasama.', 'Telah melakukan penataan kembali struktur perusahaan sesuai kebutuhan.', 'Identifikasi peningkatan peluang pertemuan produk teknologi dengan kebutuhan pasar.', 'Telah melakukan peninjauan proses teknis dan komersial untuk meningkatkan harga dan keuntungan.'],
                        'manufacturing' => ['Menerapkan GMP (Good Manufacturing Practice) atau Lean Manufacturing secara intensif.', 'Adanya kebutuhan saran (baik internal maupun eksternal) kepada manajemen untuk perbaikan kinerja.', 'Telah menerapkan jaminan mutu sesuai standar.', 'Adanya jaminan terhadap mutu, keamanan dan keselamatan produk yang dimanfaatkan oleh masyarakat.'],
                        'investment' => ['Kebutuhan perluasan pasar telah diidentifikasi.', 'Adanya peningkatan kapasitas produksi.'],
                        'partnership' => ['Peningkatan kerjasama di dalam jejaring secara dinamis.', 'Telah melakukan peningkatan mutu pengelolaan pada produk yang sudah berjalan.', 'Kerja sama dalam distribusi dan pemasaran produk.'],
                        'risk' => ['Penyusunan rencana pengendalian risiko non teknologi (organisasi dan sosial) pada tahap kematangan pasar tercapai.', 'Kajian risiko organisasi (khususnya indikator keuangan) pada tahap kematangan pasar tercapai.', 'Kajian risiko dampak sosial pada tahap kematangan pasar tercapai.'],
                    ],
                    6 => [
                        'technology' => ['Produk teknologi milik kompetitor telah ditinjau.', 'Telah meninjau kemampuan teknologi yang dimiliki untuk mendukung inovasi ulang atau pengembangan teknologi baru.', 'Telah memilih antara melakukan inovasi ulang produk teknologi yang ada, atau mengembangkan produk teknologi baru.'],
                        'market' => ['Penurunan pasar telah dikonfirmasi.', 'Riset pasar untuk persetujuan inovasi ulang atau pengembangan teknologi yang lebih maju.', 'Permintaan pasar telah ditinjau.', 'Identifikasi peluang tumbuhnya pasar atau ekspansi pasar baru.'],
                        'organization' => ['Adanya peran jaringan kemitraan dalam mendukung inovasi ulang atau pengembangan teknologi baru.', 'Ada peran jejaring dalam mendukung Inovasi Ulang atau Pengembangan Teknologi Baru.'],
                        'manufacturing' => ['Ada kebutuhan dilakukannya inovasi produksi atau pengembangan teknologi produksi baru.'],
                        'partnership' => ['Telah melakukan tinjauan terhadap kemitraan yang sudah berjalan.', 'Telah melakukan pencarian mitra potensial untuk mendukung Inovasi ulang atau Pengembangan Teknologi Baru.'],
                        'investment' => ['Telah mengidentifikasi inovasi lanjutan dari produk, berdasarkan kebutuhan dan permintaan pasar saat ini dan beberapa tahun ke depan.'],
                        'risk' => ['Telah melakukan kajian risiko untuk mendukung keputusan Inovasi Ulang atau Pengembangan Teknologi Baru.'],
                    ],
                ];
            @endphp

            @foreach ($indicators as $index => $indicator)
                <div class="card mb-5">
                    <div class="card-header" style="background-color: #277177; color: white;">
                        <h4 class="m-0">Indicator {{ $indicator }}: {{ $indicatorTitles[$index] }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($aspectNames as $aspectKey => $aspectName)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-header d-flex align-items-center"
                                            style="background-color: {{ $aspectColors[$aspectKey] }}40; border-left: 5px solid {{ $aspectColors[$aspectKey] }};">
                                            <h5 class="m-0">{{ $aspectName }}</h5>
                                        </div>
                                        <div class="card-body p-3">
                                            <strong>Ratings for Indicator {{ $indicator }}:</strong>
                                            <ul class="list-group list-group-flush mt-2">
                                                @if (isset($indicatorQuestions[$indicator][$aspectKey]))
                                                    @foreach ($indicatorQuestions[$indicator][$aspectKey] as $qIndex => $question)
                                                        @php
                                                            // Assume $dropdownValues is passed from the controller
                                                            // $dropdownValues[$indicator][$aspectKey][$qIndex] should contain 'A', 'B', 'C', etc.
                                                            $ratingValue = $dropdownValues[$indicator][$aspectKey][$qIndex] ?? 'N/A';
                                                            
                                                            $ratingMap = [
                                                                'A' => ['label' => '0 (Not Fulfilled)', 'class' => 'bg-danger'],
                                                                'B' => ['label' => '1 (20%)', 'class' => 'bg-warning'],
                                                                'C' => ['label' => '2 (40%)', 'class' => 'bg-warning'],
                                                                'D' => ['label' => '3 (60%)', 'class' => 'bg-info'],
                                                                'E' => ['label' => '4 (80%)', 'class' => 'bg-success'],
                                                                'F' => ['label' => '5 (100% Fulfilled)', 'class' => 'bg-success'],
                                                                'N/A' => ['label' => 'Not Rated', 'class' => 'bg-secondary'],
                                                            ];
                                                            
                                                            $ratingDisplay = $ratingMap[$ratingValue] ?? $ratingMap['N/A'];
                                                        @endphp
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <span class="small">{{ $qIndex + 1 }}. {{ $question }}</span>
                                                            <span class="badge {{ $ratingDisplay['class'] }} rounded-pill">{{ $ratingDisplay['label'] }}</span>
                                                        </li>
                                                    @endforeach
                                                @else
                                                     <li class="list-group-item">No questions found for this aspect.</li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .chart-container {
            position: relative;
            margin: auto;
            height: 300px;
            width: 100%;
            min-height: 300px;
        }

        canvas {
            display: block;
            max-width: 100%;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // This script assumes the controller provides the necessary JSON data 
            // derived from the dropdown ratings (A=0, B=1, etc.).
            const overallAspectScores = JSON.parse('{!! $overallAspectScoresJson !!}');

            // Data preparation for the overall chart
            const aspectLabels = [
                'Technology (T)', 'Market (M)', 'Organization (O)',
                'Manufacturing (Mf)', 'Partnership (P)', 'Investment (I)', 'Risk (R)'
            ];

            const aspectColors = [
                'rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 206, 86)',
                'rgb(75, 192, 192)', 'rgb(153, 102, 255)', 'rgb(255, 159, 64)',
                'rgb(70, 150, 130)'
            ];

            const aspectData = [
                overallAspectScores.technology || 0,
                overallAspectScores.market || 0,
                overallAspectScores.organization || 0,
                overallAspectScores.manufacturing || 0,
                overallAspectScores.partnership || 0,
                overallAspectScores.investment || 0,
                overallAspectScores.risk || 0
            ];

            // Create bar chart for overall aspects
            const ctx = document.getElementById('overallChart');
            if (ctx) {
                try {
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: aspectLabels,
                            datasets: [{
                                label: 'Aspect Score (%)',
                                data: aspectData,
                                backgroundColor: aspectColors.map(color => color + '80'),
                                borderColor: aspectColors,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 100,
                                    ticks: {
                                        callback: function(value) {
                                            return value + '%';
                                        }
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.parsed.y.toFixed(1) + '%';
                                        }
                                    }
                                }
                            }
                        }
                    });
                } catch (error) {
                    console.error('Error creating bar chart:', error);
                }
            }
        });
    </script>

@endsection