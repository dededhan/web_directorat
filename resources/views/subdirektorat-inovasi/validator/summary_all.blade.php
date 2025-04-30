@extends('subdirektorat-inovasi.validator.index')
@section('contentvalidator')
    <!-- CSS Files -->
    <link href="{{ asset('aspect-analysis.css') }}" rel="stylesheet">

    <!-- Add these at the top of your blade template -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="head-title">
        <div class="left">
            <h1>KATSINOV Overall Summary</h1>
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
                    <a class="active" href="#">Overall Summary</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Innovation Summary for: {{ $katsinov->title }}</h3>
            </div>

            <!-- Basic Information Card -->
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

            <!-- Overall Aspect Performance Card -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center"
                    style="background-color: #277177; color: white;">
                    <h4 class="m-0">Overall Aspect Performance</h4>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-light active" id="showBarChart">Bar Chart</button>
                        <button class="btn btn-sm btn-light" id="showRadarChart">Radar Chart</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container position-relative" style="height:400px;">
                        <canvas id="overallChart"></canvas>
                        <canvas id="radarChart" style="display:none;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Per-Indicator Summary Cards -->
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
            @endphp

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center"
                    style="background-color: #277177; color: white;">
                    <h4 class="m-0">Performance by Indicator</h4>
                </div>
                <div class="card-body">
                    <!-- Aspect selection tabs -->
                    <ul class="nav nav-tabs mb-4" id="aspectTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="technology-tab" data-bs-toggle="tab"
                                data-bs-target="#technology" type="button" role="tab" aria-controls="technology"
                                aria-selected="true">Technology</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="market-tab" data-bs-toggle="tab" data-bs-target="#market"
                                type="button" role="tab" aria-controls="market" aria-selected="false">Market</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="organization-tab" data-bs-toggle="tab"
                                data-bs-target="#organization" type="button" role="tab" aria-controls="organization"
                                aria-selected="false">Organization</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="manufacturing-tab" data-bs-toggle="tab"
                                data-bs-target="#manufacturing" type="button" role="tab" aria-controls="manufacturing"
                                aria-selected="false">Manufacturing</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="partnership-tab" data-bs-toggle="tab" data-bs-target="#partnership"
                                type="button" role="tab" aria-controls="partnership"
                                aria-selected="false">Partnership</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="investment-tab" data-bs-toggle="tab" data-bs-target="#investment"
                                type="button" role="tab" aria-controls="investment"
                                aria-selected="false">Investment</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="risk-tab" data-bs-toggle="tab" data-bs-target="#risk"
                                type="button" role="tab" aria-controls="risk" aria-selected="false">Risk</button>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content" id="aspectTabContent">
                        @php
                            $aspects = [
                                'technology',
                                'market',
                                'organization',
                                'manufacturing',
                                'partnership',
                                'investment',
                                'risk',
                            ];
                            $aspectTitles = [
                                'technology' => 'Aspek Teknologi',
                                'market' => 'Aspek Pasar',
                                'organization' => 'Aspek Organisasi',
                                'manufacturing' => 'Aspek Manufaktur',
                                'partnership' => 'Aspek Partnership',
                                'investment' => 'Aspek Investment',
                                'risk' => 'Aspek Risiko',
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
                        @endphp
                        <!-- All aspects tab -->
                        <div class="tab-pane fade show active" id="all-aspects" role="tabpanel"
                            aria-labelledby="all-aspects-tab">
                            <div class="table-responsive d-block d-md-none">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Indicator</th>
                                            <th>T</th>
                                            <th>M</th>
                                            <th>O</th>
                                            <th>Mf</th>
                                            <th>P</th>
                                            <th>I</th>
                                            <th>R</th>
                                            <th>Avg</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($indicators as $index => $indicator)
                                            <tr>
                                                <td><small>KAT {{ $indicator }}</small></td>
                                                <td>{{ number_format($indicatorAspectScores[$indicator]['technology'], 0) }}
                                                </td>
                                                <td>{{ number_format($indicatorAspectScores[$indicator]['market'], 0) }}
                                                </td>
                                                <td>{{ number_format($indicatorAspectScores[$indicator]['organization'], 0) }}
                                                </td>
                                                <td>{{ number_format($indicatorAspectScores[$indicator]['manufacturing'], 0) }}
                                                </td>
                                                <td>{{ number_format($indicatorAspectScores[$indicator]['partnership'], 0) }}
                                                </td>
                                                <td>{{ number_format($indicatorAspectScores[$indicator]['investment'], 0) }}
                                                </td>
                                                <td>{{ number_format($indicatorAspectScores[$indicator]['risk'], 0) }}</td>
                                                <td>
                                                    @php
                                                        $indicatorAvg =
                                                            array_sum($indicatorAspectScores[$indicator]) /
                                                            count($indicatorAspectScores[$indicator]);
                                                    @endphp
                                                    <strong>{{ number_format($indicatorAvg, 0) }}</strong>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-none d-md-block">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="chart-container" style="height: 400px;">
                                            <canvas id="performanceOverviewChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Individual aspect tabs -->
                        @php
                            $aspects = [
                                'technology',
                                'market',
                                'organization',
                                'manufacturing',
                                'partnership',
                                'investment',
                                'risk',
                            ];
                            $aspectTitles = [
                                'technology' => 'Technology',
                                'market' => 'Market',
                                'organization' => 'Organization',
                                'manufacturing' => 'Manufacturing',
                                'partnership' => 'Partnership',
                                'investment' => 'Investment',
                                'risk' => 'Risk',
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
                            $indicatorNames = [
                                'KATSINOV 1',
                                'KATSINOV 2',
                                'KATSINOV 3',
                                'KATSINOV 4',
                                'KATSINOV 5',
                                'KATSINOV 6',
                            ];
                            $indicatorDescriptions = [
                                'Basic Research & Technology Development',
                                'Technology Demonstration',
                                'Technology Refinement & Implementation',
                                'Market Introduction & Commercialization',
                                'Market Expansion & Support',
                                'Sustainable Market & Future Planning',
                            ];
                        @endphp
                        @foreach ($aspects as $aspect)
                            <div class="tab-pane fade" id="{{ $aspect }}" role="tabpanel"
                                aria-labelledby="{{ $aspect }}-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="chart-container" style="height: 400px;">
                                            <canvas id="{{ $aspect }}Chart"></canvas>
                                        </div>

                                        <div class="card bg-light mt-4">
                                            <div class="card-header">
                                                <h5 class="m-0">{{ $aspectTitles[$aspect] }} Aspect Details</h5>
                                            </div>
                                            <div class="card-body">
                                                <p>
                                                    <strong>Overall Score:</strong>
                                                    {{ number_format($overallAspectScores[$aspect], 1) }}%
                                                    <span
                                                        class="badge {{ $overallAspectScores[$aspect] >= 80 ? 'bg-success' : ($overallAspectScores[$aspect] >= 60 ? 'bg-warning' : 'bg-danger') }} ms-2">
                                                        {{ $overallAspectScores[$aspect] >= 80 ? 'Ready' : ($overallAspectScores[$aspect] >= 60 ? 'Developing' : 'Needs Review') }}
                                                    </span>
                                                </p>

                                                <div class="table-responsive">
                                                    <table class="table table-sm table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Indicator</th>
                                                                <th>Score</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($indicators as $index => $indicator)
                                                                <tr>
                                                                    <td><strong>{{ $indicatorTitles[$index] }}</strong>
                                                                    </td>
                                                                    <td>{{ number_format($indicatorAspectScores[$indicator][$aspect], 1) }}%
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            $score =
                                                                                $indicatorAspectScores[$indicator][
                                                                                    $aspect
                                                                                ];
                                                                            $statusClass =
                                                                                $score >= 80
                                                                                    ? 'bg-success'
                                                                                    : ($score >= 60
                                                                                        ? 'bg-warning'
                                                                                        : 'bg-danger');
                                                                            $statusText =
                                                                                $score >= 80
                                                                                    ? 'Ready'
                                                                                    : ($score >= 60
                                                                                        ? 'Developing'
                                                                                        : 'Needs Review');
                                                                        @endphp
                                                                        <span
                                                                            class="badge {{ $statusClass }}">{{ $statusText }}</span>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Indicators Detail Cards -->
            @foreach ($indicators as $index => $indicator)
                <div class="card mb-5">
                    <div class="card-header" style="background-color: #277177; color: white;">
                        <h4 class="m-0">Indicator {{ $indicator }}: {{ $indicatorTitles[$index] }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="chart-container position-relative" style="height:250px;">
                                    <canvas id="indicator{{ $indicator }}Chart"></canvas>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Aspect</th>
                                                <th>Score</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
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
                                            @endphp
                                            @foreach ($aspectNames as $key => $name)
                                                <tr>
                                                    <td>
                                                        <span class="badge rounded-pill"
                                                            style="background-color: {{ $aspectColors[$key] }}40; color: black; border: 1px solid {{ $aspectColors[$key] }}">
                                                            {{ $name }}
                                                        </span>
                                                    </td>
                                                    <td>{{ number_format($indicatorAspectScores[$indicator][$key], 1) }}%
                                                    </td>
                                                    <td>
                                                        @php
                                                            $score = $indicatorAspectScores[$indicator][$key];
                                                            $statusClass =
                                                                $score >= 80
                                                                    ? 'bg-success'
                                                                    : ($score >= 60
                                                                        ? 'bg-warning'
                                                                        : 'bg-danger');
                                                            $statusText =
                                                                $score >= 80
                                                                    ? 'Ready'
                                                                    : ($score >= 60
                                                                        ? 'Developing'
                                                                        : 'Needs Review');
                                                        @endphp
                                                        <span
                                                            class="badge {{ $statusClass }}">{{ $statusText }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Aspect Details for this indicator -->
                        <div class="row">
                            @php
                                // Define question arrays for each indicator and aspect
                                $indicatorQuestions = [
                                    1 => [
                                        'technology' => [
                                            'Ide baru yang memberi solusi permasalahan masyarakat.',
                                            'Telah dilakukan pengamatan prinsip-prinsip ilmiah dasar dan publikasi ilmiah.',
                                            'Faktor yang membedakan temuan dengan temuan lain dan unsur kebaruan dari sebuah ide atau gagasan telah diidentifikasi.',
                                            'Mengidentifikasi tahapan riset dan targetnya.',
                                            'Teknologi yang akan dikembangkan telah layak secara ilmiah (scientific feasibility).',
                                        ],
                                        'market' => [
                                            'Inovasi dilakukan berdasarkan permintaan dan/atau kebutuhan pelanggan.',
                                            'Permintaan dan kebutuhan pelanggan telah diidentifikasi.',
                                            'Telah mengidentifikasikan lokasi pasar yang akan dituju.',
                                        ],
                                        'organization' => [
                                            'Telah memiliki strategi inovasi.',
                                            'Lingkup proyek dan tugas telah diidentifikasi.',
                                            'Kebutuhan akan sumber daya, dana dan fasilitas penelitian telah dikonfirmasi.',
                                            'Tersedia saluran komunikasi tanpa hambatan.',
                                        ],
                                        'manufacturing' => [
                                            'Konsekuensi hasil temuan telah diidentifikasi melalui dasar manufaktur ekonomis.',
                                            'Tersedia bukti konsep manufaktur melalui analitik atau eksperimen laboratorium.',
                                            'Ide yang dikembangkan memiliki konsep model bisnis.',
                                        ],
                                        'partnership' => [
                                            'Mitra potensial telah diidentifikasi.',
                                            'Kajian risiko teknologi telah menjadi pertimbangan dalam setiap langkah penelitian.',
                                        ],
                                        'investment' => [
                                            'Ide yang dikembangkan memiliki hasil analisis pelanggan, pasar, dan pesaing.',
                                            'Ide yang dikembangkan telah terbukti memberi solusi bagi pelanggan.',
                                            'Telah tersusun strategi membangun jaringan kerja dan kemitraan.',
                                        ],
                                        'risk' => [
                                            'Pada tahap penelitian dilakukan penyusunan rencana pengendalian risiko teknologi.',
                                        ],
                                    ],
                                    2 => [
                                        'technology' => [
                                            'Telah melakukan validasi terhadap komponen individu dari teknologi.',
                                            'Prototipe telah didemonstrasikan dalam lingkungan yang relevan.',
                                            'Teknologi dinyatakan layak secara teknis.',
                                            'Telah melakukan pendaftaran kekayaan intelektual (misal: paten, desain industri, hak cipta, merek, dll).',
                                            'Secara teknis mampu memberikan solusi terhadap permasalahan yang dihadapi masyarakat.',
                                        ],
                                        'market' => [
                                            'Pelanggan akhir teridentifikasi.',
                                            'Telah mengeluarkan rencana peluncuran produk baru ke pasar secara rinci.',
                                            'Telah memulai kesiapan modal intelektual (intellectual capital).',
                                        ],
                                        'organization' => [
                                            'Analisis dan rencana bisnis telah dikeluarkan.',
                                            'Telah memiliki keterlibatan dengan individu kunci.',
                                            'Telah melakukan persetujuan persyaratan proyek dan daftar mitra proyek.',
                                            'Telah melakukan persetujuan tanggung jawab dan persetujuan batas waktu dalam pengelolaan suatu proyek.',
                                        ],
                                        'manufacturing' => [
                                            'Identifikasi teknologi dan komponen kritikal telah komplit.',
                                            'Material, perkakas dan alat uji prototipe, maupun keahlian personel telah diperlihatkan oleh sub system/system dalam suatu lingkungan produksi yang relevan.',
                                        ],
                                        'partnership' => [
                                            'Telah melakukan penggalian informasi dan seleksi mitra.',
                                            'Pola kemitraan dibangun dengan tepat.',
                                        ],
                                        'investment' => [
                                            'Keunggulan jual yang dimiliki telah teruji kepada pelanggan.',
                                            'Keunggulan jual yang dimiliki telah teruji kepada pelanggan.',
                                            'Solusi yang ditawarkan kepada pelanggan memunculkan daya tarik yang menguntungkan di pasar.',
                                            'Validasi value proposition, channel, segmen pelanggan, model hubungan dengan pelanggan yang ada, dan aliran revenue terbukti telah dilakukan.',
                                        ],
                                        'risk' => [
                                            'Kajian risiko teknologi telah dilakukan dalam setiap langkah pengembangan teknologi.',
                                            'Pada tahap pengembangan teknologi dilakukan penyusunan rencana pengendalian risiko teknologi.',
                                        ],
                                    ],
                                    3 => [
                                        'technology' => [
                                            'Sistem aktual teknologi telah didemonstrasikan dalam lingkungan yang sebenarnya.',
                                            'Uji eksternal dari teknologi yang dikembangkan telah dilakukan secara lengkap, dalam rangka memenuhi persyaratan teknis dan kesesuaian regulasi.',
                                            'Telah mendokumentasikan teknologi yang dikembangkan.',
                                            'Hasil Inovasi telah diperkenalkan.',
                                            'Telah memperoleh Kekayaan intelektual (misal: paten, desain industri, hak cipta, merek, dll).',
                                        ],
                                        'market' => [
                                            'Kebutuhan khusus dan keperluan pelanggan telah diketahui.',
                                            'Segmen, ukuran dan pangsa pasar telah diprediksi.',
                                            'Produk telah diperkenalkan, dan harganya telah ditetapkan.',
                                        ],
                                        'organization' => [
                                            'Penetapan organisasi (struktur bisnis dengan staff dan kolaborator).',
                                            'Identifikasi beberapa tambahan staff yang dibutuhkan.',
                                            'Telah merincikan pembagian tanggung jawab dan beban kerja.',
                                        ],
                                        'manufacturing' => [
                                            'Desain sistem sebagian besar stabil dan terbukti dalam uji dan evaluasi.',
                                            'Proses dan prosedur manufaktur terbukti dalam skala pilot.',
                                            'Produksi pada laju rendah telah dilaksanakan.',
                                        ],
                                        'partnership' => [
                                            'Telah terjalin kemitraan secara formal.',
                                            'Telah menyusun dan telah menerapkan rencana kerja sama.',
                                        ],
                                        'investment' => [
                                            'Telah mendefinisikan kondisi akhir dari produk teknologi dengan mempertimbangkan target person, pasar vertikal, serta geografik.',
                                            'Validasi terhadap bisnis yang dilakukan sudah diterapkan.',
                                            'Identifikasi dan validasi terhadap indikator kinerja utama yang mengindikasikan keberhasilan bisnis.',
                                        ],
                                        'risk' => [
                                            'Kajian risiko teknologi menjadi dasar pengambilan keputusan teknis dalam tahap engineering & Operation.',
                                            'Pada tahap penerapan teknologi dilakukan penyusunan rencana pengendalian risiko teknologi.',
                                        ],
                                    ],
                                    4 => [
                                        'technology' => [
                                            'Telah terbentuk keahlian terkait pengoperasian dan pemeliharaan produk teknologi.',
                                            'Penggunaan umum produk teknologi oleh cakupan pasar yang luas telah diidentifikasi.',
                                            'Keuntungan teknologi melalui hasil pengujian telah diidentifikasi.',
                                            'Adanya dukungan terhadap adopsi produk teknologi oleh pasar.',
                                        ],
                                        'market' => [
                                            'Telah membangun citra produk teknologi kepada pasar.',
                                            'Model bisnis ditetapkan.',
                                            'Pesaing diidentifikasi dengan baik.',
                                            'Pemasaran ditekankan pada pengenalan secara spesifik produk teknologi kepada para pelanggannya.',
                                        ],
                                        'organization' => [
                                            'Telah menetapkan bentuk organisasi.',
                                            'Telah mengembangkan kemitraan dengan organisasi independen.',
                                            'Identifikasi peluang untuk memperkenalkan produk kepada mitra dan pasar baru.',
                                        ],
                                        'manufacturing' => [
                                            'Telah diperlihatkan produksi yang menguntungkan secara finansial.',
                                            'Mulai menerapkan GMP (Good Manufacturing Practice) atau Lean Manufacturing.',
                                            'Mulai menerapkan jaminan mutu sesuai standar (SNI).',
                                            'Adanya tuntutan masyarakat terhadap mutu, keamanan dan keselamatan produk yang dimanfaatkan.',
                                        ],
                                        'partnership' => [
                                            'Melakukan kerja sama di dalam jejaring usaha secara dinamis.',
                                            'Terus melakukan pengelolaan terhadap kerjasama yang sudah berjalan.',
                                        ],
                                        'investment' => [
                                            'Potensi pasar teridentifikasi.',
                                            'Daya terima pasar terhadap produk telah teridentifikasi.',
                                        ],
                                        'risk' => [
                                            'Penyusunan rencana pengendalian risiko non teknologi (organisasi dan sosial) pada tahap pengenalan produk ke pasar.',
                                            'Kajian risiko organisasi (khususnya indikator keuangan) dilakukan pada tahap pengenalan produk ke pasar.',
                                            'Kajian risiko dampak sosial pada tahap pengenalan produk ke pasar.',
                                        ],
                                    ],
                                    5 => [
                                        'technology' => [
                                            'Adanya garansi terhadap produk teknologi yang dipasarkan.',
                                            'Layanan pemeliharaan produk telah disediakan.',
                                            'Pasokan suku cadang untuk produk teknologi telah disediakan.',
                                            'Adanya aktivitas pengembangan dengan intensitas lebih rendah, untuk peningkatan kerja produk teknologi sesuai permintaan pelanggan.',
                                        ],
                                        'market' => [
                                            'Telah menyediakan pelayanan dan solusi yang lengkap.',
                                            'Telah melakukan diferensiasi produk.',
                                            'Telah melakukan penyempurnaan model bisnis.',
                                            'Telah menggunakan kemitraan untuk berkompetisi di pasar.',
                                        ],
                                        'organization' => [
                                            'Telah meningkatkan efektivitas dan kerjasama.',
                                            'Telah melakukan penataan kembali struktur perusahaan sesuai kebutuhan.',
                                            'Identifikasi peningkatan peluang pertemuan produk teknologi dengan kebutuhan pasar.',
                                            'Telah melakukan peninjauan proses teknis dan komersial untuk meningkatkan harga dan keuntungan.',
                                        ],
                                        'manufacturing' => [
                                            'Menerapkan GMP (Good Manufacturing Practice) atau Lean Manufacturing secara intensif.',
                                            'Adanya kebutuhan saran (baik internal maupun eksternal) kepada manajemen untuk perbaikan kinerja.',
                                            'Telah menerapkan jaminan mutu sesuai standar.',
                                            'Adanya jaminan terhadap mutu, keamanan dan keselamatan produk yang dimanfaatkan oleh masyarakat.',
                                        ],
                                        'partnership' => [
                                            'Peningkatan kerjasama di dalam jejaring secara dinamis.',
                                            'Telah melakukan peningkatan mutu pengelolaan pada produk yang sudah berjalan.',
                                            'Kerja sama dalam distribusi dan pemasaran produk.',
                                        ],
                                        'investment' => [
                                            'Kebutuhan perluasan pasar telah diidentifikasi.',
                                            'Adanya peningkatan kapasitas produksi.',
                                        ],
                                        'risk' => [
                                            'Penyusunan rencana pengendalian risiko non teknologi (organisasi dan sosial) pada tahap kematangan pasar tercapai.',
                                            'Kajian risiko organisasi (khususnya indikator keuangan) pada tahap kematangan pasar tercapai.',
                                            'Kajian risiko dampak sosial pada tahap kematangan pasar tercapai.',
                                        ],
                                    ],
                                    6 => [
                                        'technology' => [
                                            'Produk teknologi milik kompetitor telah ditinjau.',
                                            'Telah meninjau kemampuan teknologi yang dimiliki untuk mendukung inovasi ulang atau pengembangan teknologi baru.',
                                            'Telah memilih antara melakukan inovasi ulang produk teknologi yang ada, atau mengembangkan produk teknologi baru.',
                                        ],
                                        'market' => [
                                            'Penurunan pasar telah dikonfirmasi.',
                                            'Riset pasar untuk persetujuan inovasi ulang atau pengembangan teknologi yang lebih maju.',
                                            'Permintaan pasar telah ditinjau.',
                                            'Identifikasi peluang tumbuhnya pasar atau ekspansi pasar baru.',
                                        ],
                                        'organization' => [
                                            'Adanya peran jaringan kemitraan dalam mendukung inovasi ulang atau pengembangan teknologi baru.',
                                            'Ada peran jejaring dalam mendukung Inovasi Ulang atau Pengembangan Teknologi Baru.',
                                        ],
                                        'manufacturing' => [
                                            'Ada kebutuhan dilakukannya inovasi produksi atau pengembangan teknologi produksi baru.',
                                        ],
                                        'partnership' => [
                                            'Telah melakukan tinjauan terhadap kemitraan yang sudah berjalan.',
                                            'Telah melakukan pencarian mitra potensial untuk mendukung Inovasi ulang atau Pengembangan Teknologi Baru.',
                                        ],
                                        'investment' => [
                                            'Telah mengidentifikasi inovasi lanjutan dari produk, berdasarkan kebutuhan dan permintaan pasar saat ini dan beberapa tahun ke depan.',
                                        ],
                                        'risk' => [
                                            'Telah melakukan kajian risiko untuk mendukung keputusan Inovasi Ulang atau Pengembangan Teknologi Baru.',
                                        ],
                                    ],
                                ];
                            @endphp

                            @foreach ($aspectNames as $aspectKey => $aspectName)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 border-0 shadow-sm aspect-card">
                                        <div class="card-header d-flex align-items-center"
                                            style="background-color: {{ $aspectColors[$aspectKey] }}40; border-left: 5px solid {{ $aspectColors[$aspectKey] }};">
                                            <i
                                                class='bx bx-{{ $aspectKey == 'technology'
                                                    ? 'chip'
                                                    : ($aspectKey == 'market'
                                                        ? 'store'
                                                        : ($aspectKey == 'organization'
                                                            ? 'building'
                                                            : ($aspectKey == 'manufacturing'
                                                                ? 'factory'
                                                                : ($aspectKey == 'partnership'
                                                                    ? 'handshake'
                                                                    : ($aspectKey == 'investment'
                                                                        ? 'money'
                                                                        : 'error-circle'))))) }} fs-3 me-2'></i>
                                            <h5 class="m-0">{{ $aspectName }}</h5>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="aspect-score-chart mb-3" style="height: 200px;">
                                                        <canvas
                                                            id="chart_{{ $indicator }}_{{ $aspectKey }}"></canvas>
                                                    </div>
                                                    <div class="aspect-status text-center">
                                                        <h6>Status:</h6>
                                                        @php
                                                            $score = $indicatorAspectScores[$indicator][$aspectKey];
                                                            $statusClass =
                                                                $score >= 80
                                                                    ? 'bg-success'
                                                                    : ($score >= 60
                                                                        ? 'bg-warning'
                                                                        : 'bg-danger');
                                                            $statusText =
                                                                $score >= 80
                                                                    ? 'Ready'
                                                                    : ($score >= 60
                                                                        ? 'Developing'
                                                                        : 'Needs Review');
                                                        @endphp
                                                        <span class="badge {{ $statusClass }} px-3 py-2">
                                                            {{ $statusText }}
                                                        </span>
                                                        <div class="mt-1">
                                                            <small>Overall:
                                                                {{ number_format($indicatorAspectScores[$indicator][$aspectKey], 1) }}%</small>
                                                        </div>
                                                    </div>

                                                    <div class="aspect-questions mt-3">
                                                        <strong>Pertanyaan Indikator {{ $indicator }}:</strong>
                                                        <ul class="ps-3 mt-2">
                                                            @foreach ($indicatorQuestions[$indicator][$aspectKey] as $qIndex => $question)
                                                                @php
                                                                    $score =
                                                                        $questionScores[$indicator][$aspectKey][
                                                                            $qIndex
                                                                        ] ?? 0;
                                                                    $scorePercent = $score * 20; // Convert 0-5 to percentage
                                                                @endphp
                                                                <li class="mb-1 small">
                                                                    {{ $question }}
                                                                    <div class="mt-1">
                                                                        <div class="progress" style="height: 8px;">
                                                                            <div class="progress-bar" role="progressbar"
                                                                                style="width: {{ $scorePercent }}%; background-color: {{ $aspectColors[$aspectKey] }};"
                                                                                aria-valuenow="{{ $scorePercent }}"
                                                                                aria-valuemin="0" aria-valuemax="100">
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex justify-content-between mt-1">
                                                                            <small class="text-muted">Score:
                                                                                {{ $score }}/5</small>
                                                                            <small
                                                                                class="text-muted">{{ $scorePercent }}%</small>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Recommendations Section -->
            <div class="card mb-4">
                <div class="card-header" style="background-color: #277177; color: white;">
                    <h4 class="m-0">Overall Analysis & Recommendations</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Innovation Readiness Analysis</h5>
                            <p>The assessment of <strong>{{ $katsinov->title }}</strong> reveals the following insights:
                            </p>

                            <ul>
                                @php
                                    $strengths = [];
                                    $weaknesses = [];

                                    foreach ($overallAspectScores as $key => $score) {
                                        if ($score >= 80) {
                                            $strengths[] = $aspectNames[$key];
                                        }
                                        if ($score < 60) {
                                            $weaknesses[] = $aspectNames[$key];
                                        }
                                    }

                                    // Check for stage-specific strengths and weaknesses
                                    $earlyStageScore =
                                        array_sum([
                                            $indicatorAspectScores[1]['technology'],
                                            $indicatorAspectScores[1]['market'],
                                            $indicatorAspectScores[1]['organization'],
                                        ]) / 3;

                                    $midStageScore =
                                        array_sum([
                                            $indicatorAspectScores[3]['technology'],
                                            $indicatorAspectScores[3]['manufacturing'],
                                            $indicatorAspectScores[3]['partnership'],
                                        ]) / 3;

                                    $lateStageScore =
                                        array_sum([
                                            $indicatorAspectScores[5]['market'],
                                            $indicatorAspectScores[5]['investment'],
                                            $indicatorAspectScores[5]['risk'],
                                        ]) / 3;
                                @endphp

                                @if (count($strengths) > 0)
                                    <li>
                                        <strong>Strengths:</strong>
                                        {{ implode(', ', $strengths) }}
                                        {{ count($strengths) > 1 ? 'are showing excellent readiness' : 'is showing excellent readiness' }}
                                    </li>
                                @endif

                                @if (count($weaknesses) > 0)
                                    <li>
                                        <strong>Areas for improvement:</strong>
                                        {{ implode(', ', $weaknesses) }}
                                        {{ count($weaknesses) > 1 ? 'need' : 'needs' }} further development
                                    </li>
                                @endif

                                <li>
                                    <strong>Stage assessment:</strong>
                                    @if ($earlyStageScore > $midStageScore && $earlyStageScore > $lateStageScore)
                                        This innovation is strongest in early-stage development (research and
                                        conceptualization)
                                    @elseif($midStageScore > $earlyStageScore && $midStageScore > $lateStageScore)
                                        This innovation is strongest in mid-stage development (implementation and
                                        refinement)
                                    @else
                                        This innovation is strongest in late-stage development (commercialization and market
                                        expansion)
                                    @endif
                                </li>

                                <li>
                                    <strong>Overall readiness:</strong>
                                    @if ($avgScore >= 80)
                                        This innovation shows strong overall readiness, suggesting it has a solid foundation
                                        across most aspects.
                                    @elseif($avgScore >= 60)
                                        This innovation shows moderate readiness, with some aspects requiring improvement
                                        before proceeding.
                                    @else
                                        This innovation requires significant development across multiple aspects before
                                        proceeding.
                                    @endif
                                </li>
                            </ul>

                            <h5 class="mt-4">Recommendations</h5>
                            <div class="recommendations">
                                <div class="form-group">
                                    <textarea id="recommendationsText" class="form-control" rows="5">Based on the assessment, focus on improving the following aspects: {{ implode(', ', $weaknesses) }}. Next steps should include strengthening these areas while maintaining the current performance in {{ implode(', ', $strengths) }}.</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        #content{
            margin-left: -130px;
        }
        .indicator-bar {
            height: 30px;
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        .indicator-label {
            min-width: 120px;
            padding: 0 10px;
            font-weight: 500;
        }

        .indicator-value {
            height: 100%;
            display: flex;
            align-items: center;
            padding: 0 10px;
            color: white;
            font-weight: 500;
            border-radius: 0 4px 4px 0;
        }

        /* Responsive fixes for tabs */
        @media (max-width: 768px) {
            .nav-tabs {
                display: flex;
                flex-wrap: nowrap;
                overflow-x: auto;
                overflow-y: hidden;
                white-space: nowrap;
                -webkit-overflow-scrolling: touch;
            }

            .nav-tabs .nav-link {
                padding: 0.5rem 0.7rem;
                font-size: 0.85rem;
            }
        }

        /* Fixed styles for charts */
        .chart-container {
            position: relative;
            margin: auto;
            height: 300px;
            width: 100%;
            min-height: 300px;
            /* Ensure minimum height */
        }

        .aspect-score-chart {
            width: 100%;
            height: 120px;
            min-height: 120px;
            /* Ensure minimum height */
            display: block;
            position: relative;
            background: white;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        /* Ensure chart canvases are visible */
        canvas {
            display: block;
            max-width: 100%;
        }

        /* Override any styles that might hide charts */
        #overallChart,
        #radarChart,
        [id^="indicator"],
        [id^="lineChart_"] {
            display: block !important;
        }
    </style>
    <style>
        .aspect-card {
            transition: transform 0.3s ease;
        }

        .aspect-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .aspect-score-chart {
            width: 100%;
            height: 200px;
            min-height: 200px;
            display: block;
            position: relative;
            background: white;
            border-radius: 4px;
        }

        @media (max-width: 768px) {
            .aspect-card {
                margin-bottom: 15px;
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing charts...');

            const overallAspectScores = JSON.parse('{!! $overallAspectScoresJson !!}');
            const indicatorAspectScores = JSON.parse('{!! $indicatorAspectScoresJson !!}');
            const questionScores = JSON.parse('{!! $questionScoresJson !!}');
            // Ensure Chart.js is loaded
            if (typeof Chart === 'undefined') {
                console.error('Chart.js is not loaded!');
                return;
            }

            // Chart.js setup for main charts
            const ctx = document.getElementById('overallChart');
            const radarCtx = document.getElementById('radarChart');

            if (!ctx || !radarCtx) {
                console.error('Cannot find chart canvases:', {
                    'overallChart': !!ctx,
                    'radarChart': !!radarCtx
                });
                return;
            }

            // Data preparation for overall charts
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

            console.log('Chart data ready:', {
                aspectLabels,
                aspectColors,
                aspectData
            });

            // Create bar chart for overall aspects
            try {
                const barChart = new Chart(ctx, {
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
                console.log('Bar chart created successfully');
            } catch (error) {
                console.error('Error creating bar chart:', error);
            }

            // Create radar chart for overall aspects
            try {
                const radarChart = new Chart(radarCtx, {
                    type: 'radar',
                    data: {
                        labels: aspectLabels,
                        datasets: [{
                            label: 'Aspect Score (%)',
                            data: aspectData,
                            backgroundColor: 'rgba(39, 113, 119, 0.2)',
                            borderColor: 'rgb(39, 113, 119)',
                            pointBackgroundColor: aspectColors,
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: aspectColors
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            r: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    stepSize: 20,
                                    callback: function(value) {
                                        return value + '%';
                                    }
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.raw.toFixed(1) + '%';
                                    }
                                }
                            }
                        }
                    }
                });
                console.log('Radar chart created successfully');
            } catch (error) {
                console.error('Error creating radar chart:', error);
            }

            // Chart toggle functionality
            const showBarChartBtn = document.getElementById('showBarChart');
            const showRadarChartBtn = document.getElementById('showRadarChart');

            if (showBarChartBtn && showRadarChartBtn) {
                showBarChartBtn.addEventListener('click', function() {
                    document.getElementById('overallChart').style.display = 'block';
                    document.getElementById('radarChart').style.display = 'none';
                    this.classList.add('active');
                    showRadarChartBtn.classList.remove('active');
                });

                showRadarChartBtn.addEventListener('click', function() {
                    document.getElementById('overallChart').style.display = 'none';
                    document.getElementById('radarChart').style.display = 'block';
                    this.classList.add('active');
                    showBarChartBtn.classList.remove('active');
                });
            }

            // Create charts for each indicator
            for (let i = 1; i <= 6; i++) {
                try {
                    const indicatorCtx = document.getElementById(`indicator${i}Chart`);
                    if (!indicatorCtx) {
                        console.error(`Cannot find indicator${i}Chart canvas`);
                        continue;
                    }

                    const indicatorData = [
                        indicatorAspectScores[i].technology || 0,
                        indicatorAspectScores[i].market || 0,
                        indicatorAspectScores[i].organization || 0,
                        indicatorAspectScores[i].manufacturing || 0,
                        indicatorAspectScores[i].partnership || 0,
                        indicatorAspectScores[i].investment || 0,
                        indicatorAspectScores[i].risk || 0
                    ];

                    new Chart(indicatorCtx, {
                        type: 'radar', // Changed from 'bar' to 'radar'
                        data: {
                            labels: aspectLabels,
                            datasets: [{
                                label: 'Aspect Score (%)',
                                data: indicatorData,
                                backgroundColor: 'rgba(39, 113, 119, 0.2)',
                                borderColor: 'rgb(39, 113, 119)',
                                pointBackgroundColor: aspectColors,
                                pointBorderColor: '#fff',
                                pointHoverBackgroundColor: '#fff',
                                pointHoverBorderColor: aspectColors,
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                r: { // Changed from 'y' to 'r' for radar chart
                                    beginAtZero: true,
                                    max: 100,
                                    ticks: {
                                        stepSize: 20,
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
                                            return context.raw.toFixed(1) + '%';
                                        }
                                    }
                                }
                            }
                        }
                    });
                    console.log(`Indicator ${i} radar chart created successfully`);
                } catch (error) {
                    console.error(`Error creating indicator ${i} chart:`, error);
                }
            }

            // Create individual aspect charts for each indicator
            const aspects = ['technology', 'market', 'organization', 'manufacturing', 'partnership', 'investment',
                'risk'
            ];
            const colorMap = {
                'technology': 'rgb(255, 99, 132)',
                'market': 'rgb(54, 162, 235)',
                'organization': 'rgb(255, 206, 86)',
                'manufacturing': 'rgb(75, 192, 192)',
                'partnership': 'rgb(153, 102, 255)',
                'investment': 'rgb(255, 159, 64)',
                'risk': 'rgb(70, 150, 130)'
            };

            // Define question counts for each aspect in each indicator
            const questionCounts = {
                1: {
                    'technology': 5,
                    'market': 3,
                    'organization': 4,
                    'manufacturing': 3,
                    'partnership': 2,
                    'investment': 3,
                    'risk': 1
                },
                2: {
                    'technology': 5,
                    'market': 3,
                    'organization': 4,
                    'manufacturing': 2,
                    'partnership': 2,
                    'investment': 4,
                    'risk': 2
                },
                3: {
                    'technology': 5,
                    'market': 3,
                    'organization': 3,
                    'manufacturing': 3,
                    'partnership': 2,
                    'investment': 3,
                    'risk': 2
                },
                4: {
                    'technology': 4,
                    'market': 4,
                    'organization': 3,
                    'manufacturing': 4,
                    'partnership': 2,
                    'investment': 2,
                    'risk': 3
                },
                5: {
                    'technology': 4,
                    'market': 4,
                    'organization': 4,
                    'manufacturing': 4,
                    'partnership': 3,
                    'investment': 2,
                    'risk': 3
                },
                6: {
                    'technology': 3,
                    'market': 4,
                    'organization': 2,
                    'manufacturing': 1,
                    'partnership': 2,
                    'investment': 1,
                    'risk': 1
                }
            };

            // Create charts for each aspect in each indicator
            for (let i = 1; i <= 6; i++) {
                aspects.forEach(aspect => {
                    console.log(`Aspect: ${aspect}, Color: ${colorMap[aspect]}`);
                    try {
                        const chartCtx = document.getElementById(`chart_${i}_${aspect}`);
                        if (!chartCtx) {
                            console.log(`Skipping chart for ${aspect} in indicator ${i} - no canvas found`);
                            return;
                        }

                        const questionCount = questionCounts[i][aspect] || 0;

                        // Single question case (use bar chart)
                        if (questionCount === 1) {
                            const score = (questionScores[i] && questionScores[i][aspect] && questionScores[
                                    i][aspect][0]) ?
                                questionScores[i][aspect][0] * 20 : 0;

                            new Chart(chartCtx, {
                                type: 'bar',
                                data: {
                                    labels: [
                                        `${aspect.charAt(0).toUpperCase() + aspect.slice(1)} Assessment`
                                    ],
                                    datasets: [{
                                        label: 'Score',
                                        data: [score],
                                        backgroundColor: `#ADD9E6`,
                                        borderColor: colorMap[aspect],
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
                                                    const value = context.parsed.y;
                                                    const rawScore = value /
                                                    20; // Convert percentage back to 0-5 score
                                                    return `Score: ${rawScore}/5 (${value.toFixed(0)}%)`;
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                            console.log(`Bar chart for ${aspect} in indicator ${i} created successfully`);
                        }
                        // Multiple questions case (use line chart)
                        else if (questionCount > 1) {
                            const labels = [];
                            const data = [];

                            for (let q = 0; q < questionCount; q++) {
                                labels.push(`Q${q+1}`);
                                const score = (questionScores[i] && questionScores[i][aspect] &&
                                        questionScores[i][aspect][q] !== undefined) ?
                                    questionScores[i][aspect][q] * 20 : 0;
                                data.push(score);
                            }

                            new Chart(chartCtx, {
                                type: 'line',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Question Scores',
                                        data: data,
                                        borderColor: colorMap[aspect],
                                        backgroundColor: `#ADD9E6`,
                                        borderWidth: 2,
                                        pointBackgroundColor: colorMap[aspect],
                                        pointRadius: 5,
                                        pointHoverRadius: 7,
                                        fill: true,
                                        tension: 0.1
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
                                                title: function(context) {
                                                    const index = context[0].dataIndex;
                                                    return `Question ${index + 1}`;
                                                },
                                                label: function(context) {
                                                    const value = context.parsed.y;
                                                    const rawScore = value /
                                                    20; // Convert percentage back to 0-5 score
                                                    return `Score: ${rawScore}/5 (${value.toFixed(0)}%)`;
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                            console.log(`Line chart for ${aspect} in indicator ${i} created successfully`);
                        }
                    } catch (error) {
                        console.error(`Error creating chart for ${aspect} in indicator ${i}:`, error);
                    }
                });
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const aspectColors = {
                'technology': 'rgb(255, 99, 132)', // Bright Pink
                'market': 'rgb(54, 162, 235)', // Bright Blue
                'organization': 'rgb(255, 206, 86)', // Bright Yellow
                'manufacturing': 'rgb(75, 192, 192)', // Teal
                'partnership': 'rgb(153, 102, 255)', // Purple
                'investment': 'rgb(255, 159, 64)', // Orange
                'risk': 'rgb(70, 150, 130)' // Dark Green
            };

            const indicatorLabels = [
                'KATSINOV 1', 'KATSINOV 2', 'KATSINOV 3',
                'KATSINOV 4', 'KATSINOV 5', 'KATSINOV 6'
            ];

            const indicatorAspectScores = JSON.parse('{!! $indicatorAspectScoresJson !!}');

            function createLineChart(ctx, aspect) {
                const data = [];
                for (let i = 1; i <= 6; i++) {
                    data.push(indicatorAspectScores[i][aspect] || 0);
                }

                return new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: indicatorLabels,
                        datasets: [{
                            label: aspect.charAt(0).toUpperCase() + aspect.slice(1),
                            data: data,
                            borderColor: aspectColors[aspect],
                            backgroundColor: aspectColors[aspect] + '40',
                            borderWidth: 3,
                            fill: false,
                            tension: 0.4,
                            pointRadius: 6,
                            pointHoverRadius: 8,
                            pointBackgroundColor: aspectColors[aspect],
                            pointBorderColor: 'white',
                            pointHoverBackgroundColor: 'white',
                            pointHoverBorderColor: aspectColors[aspect],
                            pointHoverBorderWidth: 2
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
                                    },
                                    color: 'rgba(0,0,0,0.7)',
                                    font: {
                                        weight: 'bold'
                                    }
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.1)',
                                    borderDash: [5, 5]
                                }
                            },
                            x: {
                                ticks: {
                                    color: 'rgba(0,0,0,0.7)',
                                    font: {
                                        weight: 'bold'
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: aspect.charAt(0).toUpperCase() + aspect.slice(1) + ' Performance',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                color: aspectColors[aspect]
                            },
                            tooltip: {
                                backgroundColor: 'white',
                                borderColor: aspectColors[aspect],
                                borderWidth: 1,
                                titleColor: aspectColors[aspect],
                                bodyColor: 'black',
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.parsed.y.toFixed(
                                            1) + '%';
                                    }
                                }
                            },
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }

            // Initialize charts for each aspect
            ['technology', 'market', 'organization', 'manufacturing', 'partnership', 'investment', 'risk'].forEach(
                aspect => {
                    const ctx = document.getElementById(`${aspect}Chart`);
                    if (ctx) {
                        createLineChart(ctx, aspect);
                    }
                });

            // Performance Overview Chart
            const overviewCtx = document.getElementById('performanceOverviewChart');
            if (overviewCtx) {
                const datasets = Object.keys(aspectColors).map(aspect => {
                    const data = [];
                    for (let i = 1; i <= 6; i++) {
                        data.push(indicatorAspectScores[i][aspect] || 0);
                    }

                    return {
                        label: aspect.charAt(0).toUpperCase() + aspect.slice(1),
                        data: data,
                        borderColor: aspectColors[aspect],
                        backgroundColor: aspectColors[aspect] + '40',
                        borderWidth: 3,
                        fill: false,
                        tension: 0.4,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        pointBackgroundColor: aspectColors[aspect],
                        pointBorderColor: 'white',
                        pointHoverBackgroundColor: 'white',
                        pointHoverBorderColor: aspectColors[aspect],
                        pointHoverBorderWidth: 2
                    };
                });

                new Chart(overviewCtx, {
                    type: 'line',
                    data: {
                        labels: indicatorLabels,
                        datasets: datasets
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
                                    },
                                    color: 'rgba(0,0,0,0.7)',
                                    font: {
                                        weight: 'bold'
                                    }
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.1)',
                                    borderDash: [5, 5]
                                }
                            },
                            x: {
                                ticks: {
                                    color: 'rgba(0,0,0,0.7)',
                                    font: {
                                        weight: 'bold'
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Performance Overview by Indicator',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                color: 'rgba(0,0,0,0.7)'
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                backgroundColor: 'white',
                                borderWidth: 1,
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.parsed.y.toFixed(
                                            1) + '%';
                                    }
                                }
                            },
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: 'rgba(0,0,0,0.7)',
                                    font: {
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const aspectColors = {
                'technology': {
                    line: '#FF6384',
                    area: 'rgba(255, 99, 132, 0.2)'
                },
                'market': {
                    line: '#36A2EB',
                    area: 'rgba(54, 162, 235, 0.2)'
                },
                'organization': {
                    line: '#FFCE56',
                    area: 'rgba(255, 206, 86, 0.2)'
                },
                'manufacturing': {
                    line: '#4BC0C0',
                    area: 'rgba(75, 192, 192, 0.2)'
                },
                'partnership': {
                    line: '#9966FF',
                    area: 'rgba(153, 102, 255, 0.2)'
                },
                'investment': {
                    line: '#FF9F40',
                    area: 'rgba(255, 159, 64, 0.2)'
                },
                'risk': {
                    line: '#46966E',
                    area: 'rgba(70, 150, 130, 0.2)'
                }
            };

            const indicatorLabels = [
                'KATSINOV 1', 'KATSINOV 2', 'KATSINOV 3',
                'KATSINOV 4', 'KATSINOV 5', 'KATSINOV 6'
            ];

            const indicatorAspectScores = JSON.parse('{!! $indicatorAspectScoresJson !!}');

            function createAreaChart(ctx, aspect) {
                const data = [];
                for (let i = 1; i <= 6; i++) {
                    data.push(indicatorAspectScores[i][aspect] || 0);
                }

                return new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: indicatorLabels,
                        datasets: [{
                            label: aspect.charAt(0).toUpperCase() + aspect.slice(1),
                            data: data,
                            borderColor: aspectColors[aspect].line,
                            backgroundColor: aspectColors[aspect].area,
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            pointBackgroundColor: aspectColors[aspect].line,
                            pointBorderColor: 'white',
                            pointHoverBackgroundColor: 'white',
                            pointHoverBorderColor: aspectColors[aspect].line,
                            pointHoverBorderWidth: 2
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
                                    },
                                    color: 'rgba(0,0,0,0.6)',
                                    font: {
                                        weight: 'normal'
                                    }
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.05)',
                                    borderDash: [5, 5]
                                }
                            },
                            x: {
                                ticks: {
                                    color: 'rgba(0,0,0,0.6)',
                                    font: {
                                        weight: 'normal'
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'white',
                                borderColor: aspectColors[aspect].line,
                                borderWidth: 1,
                                titleColor: aspectColors[aspect].line,
                                bodyColor: 'black',
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.parsed.y.toFixed(
                                            1) + '%';
                                    }
                                }
                            },
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }

            // Inisialisasi chart untuk setiap aspek
            ['technology', 'market', 'organization', 'manufacturing', 'partnership', 'investment', 'risk'].forEach(
                aspect => {
                    const ctx = document.getElementById(`${aspect}Chart`);
                    if (ctx) {
                        createAreaChart(ctx, aspect);
                    }
                });

            // Performance Overview Chart
            const overviewCtx = document.getElementById('performanceOverviewChart');
            if (overviewCtx) {
                const datasets = Object.keys(aspectColors).map(aspect => {
                    const data = [];
                    for (let i = 1; i <= 6; i++) {
                        data.push(indicatorAspectScores[i][aspect] || 0);
                    }

                    return {
                        label: aspect.charAt(0).toUpperCase() + aspect.slice(1),
                        data: data,
                        borderColor: aspectColors[aspect].line,
                        backgroundColor: aspectColors[aspect].area,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointBackgroundColor: aspectColors[aspect].line,
                        pointBorderColor: 'white',
                        pointHoverBackgroundColor: 'white',
                        pointHoverBorderColor: aspectColors[aspect].line,
                        pointHoverBorderWidth: 2
                    };
                });

                new Chart(overviewCtx, {
                    type: 'line',
                    data: {
                        labels: indicatorLabels,
                        datasets: datasets
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
                                    },
                                    color: 'rgba(0,0,0,0.6)',
                                    font: {
                                        weight: 'normal'
                                    }
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.05)',
                                    borderDash: [5, 5]
                                }
                            },
                            x: {
                                ticks: {
                                    color: 'rgba(0,0,0,0.6)',
                                    font: {
                                        weight: 'normal'
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                backgroundColor: 'white',
                                borderWidth: 1,
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.parsed.y.toFixed(
                                            1) + '%';
                                    }
                                }
                            },
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: 'rgba(0,0,0,0.6)',
                                    font: {
                                        weight: 'normal'
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add print functionality
            window.printSummary = function() {
                // Apply print-specific CSS
                const printCSS = document.createElement('style');
                printCSS.type = 'text/css';
                printCSS.innerHTML = `
            @media print {
                body { 
                    font-size: 12pt; 
                    padding: 0; 
                    margin: 0;
                }
                
                /* Hide elements not needed in print */
                .head-title .left a, 
                .breadcrumb, 
                button, 
                .btn-group, 
                .nav-tabs, 
                .recommendations textarea,
                #overallSpiderWeb {
                    display: none !important;
                }
                
                /* Ensure all charts are visible */
                .chart-container {
                    display: block !important;
                    page-break-inside: avoid;
                    height: 300px !important;
                    width: 100% !important;
                    margin-bottom: 20px;
                }
                
                canvas {
                    max-width: 100%;
                    height: auto !important;
                }
                
                /* Page break control */
                .card {
                    page-break-inside: avoid;
                    margin-bottom: 20px;
                }
                
                /* Ensure tables fit well */
                table {
                    font-size: 10pt;
                    width: 100%;
                }
                
                /* Create page breaks after sections */
                .indicators-section-break {
                    page-break-after: always;
                }
                
                /* Header on each page */
                .head-title h1 {
                    font-size: 16pt;
                    margin-top: 0;
                }
            }
        `;
                document.head.appendChild(printCSS);

                // Add page break markers
                const cards = document.querySelectorAll('.card');
                if (cards.length > 3) {
                    // Add page break after basic info and overall performance
                    cards[2].classList.add('indicators-section-break');

                    // Add additional page breaks every 2 indicator cards
                    for (let i = 4; i < cards.length; i += 2) {
                        if (i < cards.length) {
                            cards[i].classList.add('indicators-section-break');
                        }
                    }
                }

                // Wait a moment for charts to render properly before printing
                setTimeout(function() {
                    window.print();

                    // Remove the print styles after printing dialog closes
                    setTimeout(function() {
                        document.head.removeChild(printCSS);

                        // Remove page break markers
                        document.querySelectorAll('.indicators-section-break').forEach(function(
                            el) {
                            el.classList.remove('indicators-section-break');
                        });
                    }, 1000);
                }, 500);
            };

            // Add print button if it doesn't exist
            if (!document.getElementById('printSummaryBtn')) {
                const headerDiv = document.querySelector('.head-title .left');
                if (headerDiv) {
                    const printBtn = document.createElement('button');
                    printBtn.id = 'printSummaryBtn';
                    printBtn.className = 'btn btn-info ms-2';
                    printBtn.innerHTML = '<i class="bx bx-printer"></i> Print Summary';
                    printBtn.onclick = window.printSummary;
                    headerDiv.appendChild(printBtn);
                }
            }
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if URL has print parameter to auto-trigger print
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('print')) {
            // Delay printing slightly to ensure all charts are fully rendered
            setTimeout(function() {
                window.print();
            }, 1500);
        }
    });
    </script>
    
    <style>
    /* Print styles that ensure everything is visible */
    @media print {
        /* Reset any size limitations */
        html, body {
            width: 100%;
            height: auto;
            margin: 0;
            padding: 0;
            overflow: visible;
        }
        
        /* Ensure all elements are visible */
        .card, .chart-container, canvas, .table-responsive {
            display: block !important;
            page-break-inside: auto;
            overflow: visible !important;
        }
        
        /* Make sure charts are displayed properly */
        canvas {
            max-width: 100%;
            height: auto !important;
        }
        
        /* Hide non-essential UI elements */
        .btn:not(.btn-tab), 
        button:not(.nav-link), 
        .nav-tabs .nav-link:not(.active),
        .user-dropdown,
        .toggle-details,
        .search-box,
        .btn-group:not(.tab-btn-group) {
            display: none !important;
        }
        
        /* Keep all essential content */
        .tab-content,
        .tab-pane,
        .card-body,
        .table-responsive,
        .detail-content,
        .aspect-card,
        .recommendations,
        #recommendationsText {
            display: block !important;
            visibility: visible !important;
            height: auto !important;
            overflow: visible !important;
        }
        
        /* Preserve background colors for status indicators */
        .bg-success {
            background-color: #d4edda !important;
            color: #155724 !important;
            border: 1px solid #c3e6cb !important;
        }
        
        .bg-warning {
            background-color: #fff3cd !important;
            color: #856404 !important;
            border: 1px solid #ffeeba !important;
        }
        
        .bg-danger {
            background-color: #f8d7da !important;
            color: #721c24 !important;
            border: 1px solid #f5c6cb !important;
        }
        * {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        
        /* Make sure tables print completely */
        table {
            width: 100% !important;
            page-break-inside: auto;
        }
        
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        
        /* Set reasonable text sizes for print */
        p, li, td, th {
            font-size: 12pt;
        }
        
        h1 {
            font-size: 18pt;
        }
        
        h2 {
            font-size: 16pt;
        }
        
        h3, h4 {
            font-size: 14pt;
        }
        
        /* Use page breaks only after major sections */
        .indicators-section,
        .recommendations-section {
            page-break-after: always;
        }
    }
    </style>
@endsection
