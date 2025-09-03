<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mitra Kolaborasi: {{ $data['title'] }} - Inovasi UNJ</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'], },
                    colors: {
                        primary: { DEFAULT: '#186569', light: '#2a7a7e', dark: '#0d4b4f', },
                        secondary: '#F1F8F8', accent: '#ffb74d', textColor: '#1A202C',
                        textSecondary: '#4A5568', backgroundColor: '#FFFFFF', cardColor: '#FFFFFF',
                    },
                    boxShadow: { card: '0 4px 12px rgba(0, 0, 0, 0.05)', 'card-hover': '0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1)', },
                    borderRadius: { card: '1rem', 'button': '0.5rem', },
                },
            },
        }
    </script>
    <style> .hero-gradient { background: linear-gradient(135deg, #F1F8F8 0%, #FFFFFF 100%); } .section-bg { background-color: #F7FAFC; } </style>
</head>
<body class="bg-backgroundColor text-textColor font-sans antialiased">

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
                     <a href="{{ route('subdirektorat-inovasi.riset_unj.produk_inovasi.produkinovasi') }}#mitra" class="text-primary font-semibold hover:underline">
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
                    @forelse ($partners as $partner)
                    <a href="{{ $partner->link_website }}" target="_blank" rel="noopener noreferrer" class="flex justify-center items-center p-6 bg-gray-50 rounded-lg transition-transform duration-300 hover:scale-105 hover:shadow-sm" title="{{ $partner->nama }}">
                        <img src="{{ asset('storage/' . $partner->foto) }}" alt="{{ $partner->nama }}" class="max-h-16 w-auto object-contain grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                    </a>
                    @empty
                    <div class="col-span-full text-center text-gray-500">
                        Belum ada mitra untuk kategori ini.
                    </div>
                    @endforelse
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
                     <p class="text-center col-span-full text-gray-500">(Konten Proyek Unggulan Akan Ditampilkan di Sini)</p>
                </div>
            </div>
        </section>
    </main>
    
    @include('layout.footer')

</body>
</html>