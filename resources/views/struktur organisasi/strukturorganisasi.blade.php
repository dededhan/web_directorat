<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Struktur Organisasi - DITISIP UNJ</title>
  <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />

  <style>
    body {
      font-family: Arial, sans-serif;
      overflow-x: hidden;
    }

    .org-chart-shell {
      --chart-scale: min(1, calc(100vw / var(--chart-width)));
      display: flex;
      justify-content: center;
    }

    .org-chart-stage {
      width: calc(var(--chart-width) * var(--chart-scale));
      height: calc(var(--chart-height) * var(--chart-scale));
      position: relative;
    }

    .org-chart-wrap {
      width: var(--chart-width);
      height: var(--chart-height);
      position: relative;
      transform: scale(var(--chart-scale));
      transform-origin: top center;
    }

    .org-node {
      position: absolute;
    }

    .org-line {
      position: absolute;
      background-color: #64748b;
    }

    .org-line.vertical {
      width: 2px;
    }

    .org-line.horizontal {
      height: 2px;
    }
  </style>
</head>
<body class="bg-slate-50 text-slate-800">
  @include('layout.navbarSearch')
  <div class="h-16"></div>

  @php
    $xOffset = 380;
    $chartWidth = 2100;
    $chartHeight = 1400;

    $nodes = [
      [
        'x' => 30,
        'y' => 60,
        'w' => 200,
        'h' => 180,
        'photo' => 'https://cdn-1.timesmedia.co.id/images/2025/02/23/UNJ-Prof-Komarudin.jpg',
        'name' => 'Prof. Dr. Komarudin, M.Si',
        'roles' => ['REKTOR'],
      ],
      [
        'x' => 10,
        'y' => 280,
        'w' => 240,
        'h' => 180,
        'photo' => 'https://fip.unj.ac.id/wp-content/uploads/2022/10/Prof-Fahrurrozi.jpg',
        'name' => 'Prof. Dr. Fahrurrozi, M.Pd',
        'roles' => ['WAKIL REKTOR BID. RISET, INOVASI DAN SISTEM INFORMASI'],
      ],
      [
        'x' => 0,
        'y' => 500,
        'w' => 260,
        'h' => 180,
        'photo' => 'images/murti.jpg',
        'name' => 'Dr.R.A. Murti Kusuma W. S.IP. M.Si.',
        'roles' => ['DIREKTOR INOVASI, SISTEM INFORMASI DAN PEMERINGKATAN'],
      ],
      [
        'x' => 320,
        'y' => 593,
        'w' => 200,
        'h' => 200,
        'photo' => 'images/ervina-maulida.jpg',
        'name' => 'Ervina Maulida, S.Pd., M.B.A',
        'roles' => ['Staf Ahli WR III', 'Bid. Inovasi dan Hilirisasi'],
      ],
      [
        'x' => 520,
        'y' => 593,
        'w' => 200,
        'h' => 200,
        'photo' => 'https://ft.unj.ac.id/wp-content/uploads/2021/10/Massus-Subekti-S.Pd_.-M.T..png',
        'name' => 'Massus Subekti, S.Pd, M.T.',
        'roles' => ['Staf Ahli WR III', 'Bid. Sistem Informasi'],
      ],
      [
        'x' => 720,
        'y' => 593,
        'w' => 200,
        'h' => 200,
        'photo' => 'https://fip.unj.ac.id/wp-content/uploads/2022/06/Uswatun-Hasanah.jpg',
        'name' => 'Dr. Uswatun Hasanah, M.Pd.',
        'roles' => ['Staf Ahli WR III', 'Bid. Pemeringkatan'],
      ],
      [
        'x' => 1020,
        'y' => 560,
        'w' => 220,
        'h' => 180,
        'photo' => 'https://fis.unj.ac.id/bose/wp-content/uploads/2023/12/Syaifudin-M.-Kesos.png',
        'name' => 'Syaifudin, S.Pd, M.Kesos.',
        'roles' => ['Kepala Kantor Hubungan Masyarakat dan Informasi Publik'],
      ],
      [
        'x' => 1400,
        'y' => 700,
        'w' => 200,
        'h' => 200,
        'photo' => '/images/nada-arina-romli.jpg',
        'name' => 'Nada Arina Romli, S.I.Kom, M.I.kom.',
        'roles' => ['Seketaris Kantor Hubungan Masyarakat dan Informasi Publik'],
      ],
      [
        'x' => 906,
        'y' => 860,
        'w' => 200,
        'h' => 220,
        'photo' => 'images/mentari-anugrah-imsa.jpg',
        'name' => 'Mentari Anugrah Imsa, M.Si.',
        'roles' => ['Kepala Divisi Peliputan dan Pemberitaan Kantor Hubungan Masyarakat dan Informasi Publik'],
      ],
      [
        'x' => 1160,
        'y' => 860,
        'w' => 200,
        'h' => 220,
        'photo' => 'https://fis.unj.ac.id/wp-content/uploads/2024/03/Foto-Dosen-FIS-22-Wina-Puspita-Sari.jpg',
        'name' => 'Wina Puspita Sari, M.Si',
        'roles' => ['Kepala Divisi Layanan Informasi Kantor Hubungan Masyarakat dan Informasi Publik'],
      ],
      [
        'x' => -110,
        'y' => 830,
        'w' => 200,
        'h' => 200,
        'photo' => 'data:image/jpeg;base64,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',
        'name' => 'Taryudi, ST, MT, Ph.D.',
        'roles' => ['Kepala Subdit Inovasi dan Hilirisasi'],
      ],
      [
        'x' => 170,
        'y' => 830,
        'w' => 200,
        'h' => 200,
        'photo' => 'https://fmipa.unj.ac.id/s2pmath/wp-content/uploads/2023/08/Pak-Tian-2.jpeg',
        'name' => 'Tian Abdul Azis, S.Pd, Ph.D.',
        'roles' => ['Kepala Subdit Pemeringkatan dan Sistem Informasi'],
      ],
      [
        'x' => -360,
        'y' => 1140,
        'w' => 180,
        'h' => 200,
        'photo' => 'images/irna-khaerunnisa-azzahra.jpg',
        'name' => 'Irna Khaerunnisa Azzahra, S.S.',
        'roles' => ['Staf'],
      ],
      [
        'x' => -160,
        'y' => 1140,
        'w' => 180,
        'h' => 200,
        'photo' => 'images/nungky-ratna-anggraini.jpg',
        'name' => 'Nungky Ratna Anggraini, S.E.',
        'roles' => ['Staf'],
      ],
      [
        'x' => 40,
        'y' => 1140,
        'w' => 180,
        'h' => 200,
        'photo' => 'images/hana.jpg',
        'name' => 'Hana Nurina, S.Sos',
        'roles' => ['Staf'],
      ],
      [
        'x' => 240,
        'y' => 1140,
        'w' => 180,
        'h' => 200,
        'photo' => 'images/yusi.jpg',
        'name' => 'Yusi Rahmaniar, S.E, M.M',
        'roles' => ['Staf'],
      ],
      [
        'x' => 440,
        'y' => 1140,
        'w' => 180,
        'h' => 200,
        'photo' => 'images/ririn-listiana.jpg',
        'name' => 'Ririn Listiana',
        'roles' => ['Staf'],
      ],
      [
        'x' => 640,
        'y' => 1140,
        'w' => 180,
        'h' => 200,
        'photo' => '/api/placeholder/150/150',
        'name' => 'Edi Supriadi',
        'roles' => ['Driver'],
      ],
    ];

    $lines = [
      ['orientation' => 'vertical', 'x' => 129.5, 'y' => 240, 'length' => 40],
      ['orientation' => 'vertical', 'x' => 129.5, 'y' => 460, 'length' => 651],
      ['orientation' => 'horizontal', 'x' => 130, 'y' => 480, 'length' => 1007],
      ['orientation' => 'vertical', 'x' => 620, 'y' => 483, 'length' => 80],
      ['orientation' => 'vertical', 'x' => 1135, 'y' => 483, 'length' => 110],
      ['orientation' => 'horizontal', 'x' => 420, 'y' => 563, 'length' => 400],
      ['orientation' => 'vertical', 'x' => 420, 'y' => 563, 'length' => 30],
      ['orientation' => 'vertical', 'x' => 620, 'y' => 563, 'length' => 30],
      ['orientation' => 'vertical', 'x' => 820, 'y' => 563, 'length' => 30],
      ['orientation' => 'horizontal', 'x' => 1240, 'y' => 650, 'length' => 262],
      ['orientation' => 'vertical', 'x' => 1500, 'y' => 650, 'length' => 50],
      ['orientation' => 'vertical', 'x' => 1130, 'y' => 740, 'length' => 90],
      ['orientation' => 'horizontal', 'x' => 1000, 'y' => 830, 'length' => 260],
      ['orientation' => 'vertical', 'x' => 1000, 'y' => 830, 'length' => 30],
      ['orientation' => 'vertical', 'x' => 1257, 'y' => 830, 'length' => 30],
      ['orientation' => 'vertical', 'x' => 129, 'y' => 680, 'length' => 260],
      ['orientation' => 'horizontal', 'x' => -10, 'y' => 800, 'length' => 280],
      ['orientation' => 'vertical', 'x' => -10, 'y' => 800, 'length' => 30],
      ['orientation' => 'vertical', 'x' => 270, 'y' => 800, 'length' => 30],
      ['orientation' => 'horizontal', 'x' => -270, 'y' => 1110, 'length' => 1000],
      ['orientation' => 'vertical', 'x' => -270, 'y' => 1110, 'length' => 30],
      ['orientation' => 'vertical', 'x' => -70, 'y' => 1110, 'length' => 30],
      ['orientation' => 'vertical', 'x' => 130, 'y' => 1110, 'length' => 30],
      ['orientation' => 'vertical', 'x' => 330, 'y' => 1110, 'length' => 30],
      ['orientation' => 'vertical', 'x' => 530, 'y' => 1110, 'length' => 30],
      ['orientation' => 'vertical', 'x' => 730, 'y' => 1110, 'length' => 30],
    ];
  @endphp

  <main class="container mx-auto px-6 py-12">
    <div class="text-center mb-10">
      <h1 class="text-3xl md:text-4xl font-bold text-teal-800 uppercase tracking-wider">Struktur Organisasi</h1>
      <p class="text-slate-600 mt-2">Direktorat Inovasi, Sistem Informasi dan Pemeringkatan</p>
    </div>

    <div class="org-chart-shell pb-10" style="--chart-width: {{ $chartWidth }}px; --chart-height: {{ $chartHeight }}px;">
      <div class="org-chart-stage">
        <div class="org-chart-wrap">
          @foreach ($lines as $line)
            @php
              $left = $line['x'] + $xOffset;
              $top = $line['y'];
              $lengthStyle = $line['orientation'] === 'vertical'
                ? 'height: ' . $line['length'] . 'px;'
                : 'width: ' . $line['length'] . 'px;';
            @endphp
            <span class="org-line {{ $line['orientation'] }}" style="left: {{ $left }}px; top: {{ $top }}px; {{ $lengthStyle }}"></span>
          @endforeach

          @foreach ($nodes as $node)
            @php
              $left = $node['x'] + $xOffset;
              $top = $node['y'];
            @endphp
            <div class="org-node" style="left: {{ $left }}px; top: {{ $top }}px; width: {{ $node['w'] }}px; height: {{ $node['h'] }}px;">
              <div class="h-full w-full rounded-xl bg-white border border-slate-200 shadow-sm transition-all duration-200 hover:shadow-lg flex flex-col items-center text-center px-3 pb-3">
                <div class="mt-3 h-20 w-20 rounded-full bg-slate-200 bg-cover bg-center border-4 border-slate-50" style="background-image: url('{{ $node['photo'] }}');"></div>
                <div class="mt-2 text-sm font-semibold text-slate-800 leading-snug">{{ $node['name'] }}</div>
                @foreach ($node['roles'] as $role)
                  <div class="text-[11px] text-slate-600 leading-snug">{{ $role }}</div>
                @endforeach
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </main>

  @include('layout.footer')
</body>
</html>