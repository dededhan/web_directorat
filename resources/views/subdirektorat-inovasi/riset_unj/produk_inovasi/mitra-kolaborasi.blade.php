<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mitra Kolaborasi - Inovasi UNJ</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            DEFAULT: '#186569',
                            light: '#2a7a7e',
                            dark: '#0d4b4f',
                        },
                        secondary: '#F1F8F8',
                        accent: '#ffb74d',
                        textColor: '#1A202C',
                        textSecondary: '#4A5568',
                        backgroundColor: '#FFFFFF',
                        cardColor: '#FFFFFF',
                    },
                    boxShadow: {
                        card: '0 4px 12px rgba(0, 0, 0, 0.05)',
                        'card-hover': '0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1)',
                    },
                    borderRadius: {
                        card: '1rem',
                        'button': '0.5rem',
                    },
                },
            },
        }
    </script>
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #F1F8F8 0%, #FFFFFF 100%);
        }
        .section-bg {
            background-color: #F7FAFC;
        }
    </style>
    
    <style>
        .fa, .fas, .far, .fal, .fab {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 6 Brands" !important;
        }
    </style>
    
</head>
<body class="bg-backgroundColor text-textColor font-sans antialiased">

    @php
        //dummy data
        $kategori = request()->query('kategori', 'pendidikan');

        // Data dummy untuk setiap kategori
        $mitraData = [
            'pendidikan' => [
                'title' => 'Pendidikan',
                'icon' => 'fa-school',
                'description' => 'Kolaborasi strategis dengan berbagai institusi pendidikan untuk meningkatkan mutu pembelajaran, mengembangkan teknologi edukasi terapan, dan mencetak talenta masa depan yang unggul dan berdaya saing.',
                'partners' => [
                    ['name' => 'Kemendikbudristek', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg/200px-Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg.png'],
                    ['name' => 'Dinas Pendidikan DKI', 'logo' => 'https://disdik.jakarta.go.id/wp-content/uploads/2022/07/Logo-Disdik-DKI-Jakarta-Transparan-1.png'],
                    ['name' => 'Sampoerna University', 'logo' => 'https://www.sampoernauniversity.ac.id/wp-content/uploads/2023/04/SU-Logo-Horizontal.png'],
                    ['name' => 'Ruangguru', 'logo' => 'https://www.ruangguru.com/hubfs/updated-logo-rg.png'],
                ],
                'projects' => [
                    ['title' => 'Pengembangan Kurikulum Merdeka Belajar', 'description' => 'Bermitra dengan Kemendikbudristek untuk implementasi dan evaluasi Kurikulum Merdeka di sekolah percontohan.', 'image' => 'https://images.unsplash.com/photo-1543269865-cbf427effbad?q=80&w=800'],
                    ['title' => 'Platform Pembelajaran Adaptif', 'description' => 'Riset bersama untuk menciptakan platform e-learning yang dapat menyesuaikan materi berdasarkan kemampuan siswa.', 'image' => 'https://images.unsplash.com/photo-1516321497487-e288fb19713f?q=80&w=800'],
                ]
            ],
            'sains-teknologi' => [
                'title' => 'Sains & Teknologi',
                'icon' => 'fa-flask',
                'description' => 'Bermitra dengan industri teknologi terdepan dan lembaga riset untuk mendorong batas-batas inovasi, menciptakan solusi masa depan, dan mempercepat transformasi digital di Indonesia.',
                'partners' => [
                    ['name' => 'BRIN', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/21/Logo_BRIN_Lanskap.svg/2560px-Logo_BRIN_Lanskap.svg.png'],
                    ['name' => 'Telkom Indonesia', 'logo' => 'https://upload.wikimedia.org/wikipedia/id/thumb/c/c4/Telkom_Indonesia_2013.svg/2560px-Telkom_Indonesia_2013.svg.png'],
                    ['name' => 'Gojek', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/18/Gojek_logo_2022.svg/2560px-Gojek_logo_2022.svg.png'],
                    ['name' => 'Bio Farma', 'logo' => 'https://upload.wikimedia.org/wikipedia/id/thumb/8/8a/Bio_Farma_logo.svg/1200px-Bio_Farma_logo.svg.png'],
                ],
                'projects' => [
                    ['title' => 'Riset Material Grafena', 'description' => 'Kolaborasi dengan BRIN untuk meneliti aplikasi material grafena untuk industri semikonduktor.', 'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=800'],
                    ['title' => 'AI untuk Logistik Perkotaan', 'description' => 'Mengembangkan algoritma optimisasi rute berbasis AI untuk meningkatkan efisiensi logistik bersama Gojek.', 'image' => 'https://images.unsplash.com/photo-1610403372251-c00cde23d18c?q=80&w=800'],
                ]
            ],
            'sosial-humaniora-seni' => [
                'title' => 'Sosial Humaniora & Seni',
                'icon' => 'fa-palette',
                'description' => 'Menggali potensi kreativitas dan kearifan lokal melalui kolaborasi di bidang sosial, humaniora, dan seni untuk mengembangkan inovasi yang memperkaya kehidupan masyarakat dan budaya bangsa.',
                'partners' => [
                    ['name' => 'Kemenparekraf', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/06/Logo_Kementerian_Pariwisata_dan_Ekonomi_Kreatif_RI.svg/2560px-Logo_Kementerian_Pariwisata_dan_Ekonomi_Kreatif_RI.svg.png'],
                    ['name' => 'Museum Nasional', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/4/4b/Logo_Museum_Nasional_Indonesia.png'],
                    ['name' => 'Komunitas Narasi', 'logo' => 'https://narasi.tv/wp-content/themes/narasi-theme/assets/images/logo-narasi.png'],
                ],
                'projects' => [
                    ['title' => 'Digitalisasi Arsip Budaya', 'description' => 'Bekerja sama dengan Museum Nasional untuk mendigitalisasi manuskrip kuno dan artefak budaya.', 'image' => 'https://images.unsplash.com/photo-1569052671510-7e3f25c279a4?q=80&w=800'],
                    ['title' => 'Pengembangan Desa Wisata Kreatif', 'description' => 'Program pendampingan UMKM dan komunitas lokal bersama Kemenparekraf untuk menciptakan destinasi wisata berbasis ekonomi kreatif.', 'image' => 'https://images.unsplash.com/photo-1528495612343-9ca96a0411a9?q=80&w=800'],
                ]
            ],
            'kesehatan-psikologi' => [
                'title' => 'Kesehatan & Psikologi',
                'icon' => 'fa-heart-pulse',
                'description' => 'Bekerja sama dengan institusi kesehatan dan para ahli untuk menciptakan inovasi terapan yang meningkatkan kesejahteraan fisik dan mental, serta membangun masyarakat yang lebih sehat dan tangguh.',
                 'partners' => [
                    ['name' => 'Kementerian Kesehatan', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/95/Logo_Kementerian_Kesehatan_RI.png/1955px-Logo_Kementerian_Kesehatan_RI.png'],
                    ['name' => 'RS Cipto Mangunkusumo', 'logo' => 'https://rscm.co.id/asset/images/logo/logorscm.png'],
                    ['name' => 'Halodoc', 'logo' => 'https://www.halodoc.com/assets/img/logo/logocrop.png'],
                    ['name' => 'Ikatan Psikolog Klinis', 'logo' => 'https://ipkindonesia.or.id/wp-content/uploads/2021/05/cropped-logo-ipk-2018-final-1-1.png'],
                ],
                'projects' => [
                    ['title' => 'Aplikasi Telekonseling Mahasiswa', 'description' => 'Mengembangkan platform konseling daring untuk mendukung kesehatan mental mahasiswa di lingkungan kampus.', 'image' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=800'],
                    ['title' => 'Program Edukasi Gizi Anak', 'description' => 'Kolaborasi dengan Kemenkes untuk membuat materi edukasi interaktif mengenai gizi seimbang untuk anak usia sekolah dasar.', 'image' => 'https://images.unsplash.com/photo-1543353071-873f6b6a6a89?q=80&w=800'],
                ]
            ],
        ];

        $data = $mitraData[$kategori] ?? $mitraData['pendidikan'];
    @endphp

    <header class="fixed top-0 left-0 w-full z-50">
        @include('layout.navbar_hilirisasi')
    </header>

    <main class="pt-20">
        <section class="hero-gradient pt-20 pb-20 md:pt-28 md:pb-24">
            <div class="container mx-auto px-6 lg:px-8 max-w-screen-xl text-center">
                <div class="w-20 h-20 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas {{ $data['icon'] }} text-4xl"></i>
                </div>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-primary leading-tight mb-4">
                    Mitra Kolaborasi: {{ $data['title'] }}
                </h1>
                <p class="text-lg text-textSecondary max-w-3xl mx-auto">
                    {{ $data['description'] }}
                </p>
                 <div class="mt-8">
                    <a href="{{ url()->previous() }}#katalog" class="text-primary font-semibold hover:underline">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Laman Inovasi
                    </a>
                </div>
            </div>
        </section>

        <section class="py-20">
            <div class="container mx-auto px-6 lg:px-8 max-w-screen-xl">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-primary mb-3">Mitra Kami</h2>
                    <p class="text-textSecondary text-lg max-w-2xl mx-auto">Kami bangga dapat berkolaborasi dengan institusi dan perusahaan terkemuka.</p>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center">
                    @foreach ($data['partners'] as $partner)
                    <div class="flex justify-center items-center p-6 bg-gray-50 rounded-lg transition-transform duration-300 hover:scale-105 hover:shadow-sm">
                        <img src="{{ $partner['logo'] }}" alt="{{ $partner['name'] }}" class="max-h-16 w-auto object-contain grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="py-20 section-bg">
            <div class="container mx-auto px-6 lg:px-8 max-w-screen-xl">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">Proyek Kolaborasi Unggulan</h2>
                    <p class="text-textSecondary text-lg max-w-3xl mx-auto">Contoh nyata bagaimana kolaborasi kami menghasilkan dampak positif.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @forelse($data['projects'] as $project)
                    <div class="group bg-cardColor rounded-card overflow-hidden shadow-card hover:shadow-card-hover transition-all duration-300 transform hover:-translate-y-2">
                        <div class="h-56 bg-cover bg-center transition-transform duration-300 ease-out-expo group-hover:scale-105" style="background-image: url('{{ $project['image'] }}')"></div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2 text-textColor">{{ $project['title'] }}</h3>
                            <p class="text-textSecondary leading-relaxed">{{ $project['description'] }}</p>
                        </div>
                    </div>
                    @empty
                     <div class="col-span-full flex flex-col items-center justify-center py-16 text-center text-textSecondary">
                        <i class="fas fa-folder-open text-6xl mb-4 text-gray-300"></i>
                        <p class="text-xl font-semibold">Proyek Unggulan Belum Tersedia</p>
                        <p>Informasi mengenai proyek kolaborasi akan segera diperbarui.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </section>

    </main>
    
    @include('layout.footer')

</body>
</html>