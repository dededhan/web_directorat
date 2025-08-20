<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    {{-- Viewport ini penting untuk desain responsif yang benar --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universitas Negeri Jakarta - Direktorat Pemeringkatan</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    
    {{-- 
      - Hapus referensi ke mobile.css dan mobile.js
      - Gabungkan JS yang diperlukan ke dalam app.js atau home.js 
    --}}
    @vite([
        'resources/css/home.css',
        'resources/js/home.js',
        'resources/js/app.js', // Tambahkan file JS baru untuk interaksi
        'resources/js/instagram-api-feed.js', 
    ])

    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Roboto', sans-serif; overflow-x: hidden; }
        .prose { max-width: 100%; }
        /* Mencegah body scroll saat sidebar mobile terbuka */
        body.sidebar-open { overflow: hidden; }
    </style>
</head>

<body class="font-sans bg-gray-100">

    @include('layout.navbar')

    {{-- Header dibuat lebih pendek di mobile (h-[60vh]) dan tinggi di desktop (md:h-screen) --}}
    <header class="relative h-[60vh] md:h-screen">
        <img alt="Universitas Negeri Jakarta building" class="w-full h-full object-cover" src="https://media.quipper.com/media/W1siZiIsIjIwMTgvMDEvMjMvMDkvNDMvMjcvYWVjNTQ1OTctOTJiNi00Y2EyLWEzZDctMGZiNTg1ZTU1MDEzLyJdLFsicCIsInRodW1iIiwiMTIwMHhcdTAwM2UiLHt9XSxbInAiLCJjb252ZXJ0IiwiLWNvbG9yc3BhY2Ugc1JHQiAtc3RyaXAiLHsiZm9ybWF0IjoianBnIn1dXQ?sha=9c61a35270604434" />
        <div class="absolute inset-0 bg-teal-900 bg-opacity-50 flex flex-col justify-center items-start p-6 md:p-12">
            {{-- Konten di atas gambar header bisa ditambahkan di sini --}}
        </div>
    </header>

    <div class="bg-gradient-to-r from-teal-700 to-teal-800 py-3 shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex items-center space-x-4">
                <div class="bg-yellow-400 p-2 rounded-full flex-shrink-0">
                    <i class="fas fa-bullhorn text-teal-800 text-lg"></i>
                </div>
                <marquee class="flex-1 text-white font-medium news-marquee">
                    @if (isset($announcements) && count($announcements) > 0)
                        {!! $announcements[0]->icon !!} <span class="text-yellow-400 font-bold">{{ $announcements[0]->judul_pengumuman }}</span>
                        {{ strip_tags($announcements[0]->isi_pengumuman) }}
                    @else
                        <span class="text-yellow-400 font-bold">Belum ada pengumuman</span>
                    @endif
                </marquee>
            </div>
        </div>
    </div>

    <main class="container mx-auto py-12 px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-teal-700">Berita Terbaru</h2>
            <p class="text-gray-600 mt-2">Informasi terkini dari Universitas Negeri Jakarta</p>
        </div>

        {{-- Grid Responsif: 1 kolom di mobile, 2 di tablet, 3 di desktop --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            @if ($regularNews && $regularNews->count() > 0)
                @foreach ($regularNews as $news)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="relative">
                            <img alt="{{ $news->judul }}" class="w-full h-56 object-cover" src="{{ asset('storage/' . $news->gambar) }}" />
                            <div class="absolute top-3 right-3 bg-yellow-400 text-teal-800 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ ucfirst($news->kategori) }}
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center justify-between mb-3 text-gray-500 text-sm">
                                <span><i class="fas fa-user-circle mr-2"></i>Admin</span>
                                <span><i class="fas fa-calendar-alt mr-1"></i>{{ date('d M Y', strtotime($news->tanggal)) }}</span>
                            </div>
                            <a href="{{ route('Berita.show', ['slug' => $news->slug]) }}" class="block">
                                <h2 class="font-bold text-xl mb-3 text-teal-800 hover:text-yellow-600 transition-colors">
                                    {{ $news->judul }}
                                </h2>
                            </a>
                            <p class="text-gray-600 mb-4">{{ Str::limit(strip_tags($news->isi), 100) }}</p>
                            <a href="{{ route('Berita.show', ['slug' => $news->slug]) }}" class="inline-block text-teal-700 hover:text-yellow-500 font-medium">
                                Baca selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="col-span-full text-center text-gray-500">Tidak ada berita untuk ditampilkan.</p>
            @endif
        </div>

        <div class="enhanced-carousel">
            <div class="enhanced-carousel-title">Berita Unggulan</div>
            <div class="carousel">
                <div class="carousel-inner">
                    @if ($featuredNews && $featuredNews->count() > 0)
                        @foreach ($featuredNews as $featured)
                            <div class="carousel-item-enhanced">
                                <div class="news-card-enhanced">
                                    <div class="news-image-container">
                                        <img alt="{{ $featured->judul }}" class="news-image" src="{{ asset('storage/' . $featured->gambar) }}" />
                                        <div class="news-tag-enhanced">{{ ucfirst($featured->kategori) }}</div>
                                    </div>
                                    <div class="news-content">
                                        <div class="news-meta">
                                            <span><i class="fas fa-user-circle mr-2"></i>Admin</span>
                                            <span class="mx-2">|</span>
                                            <span><i class="fas fa-calendar-alt mr-2"></i>{{ date('d M Y', strtotime($featured->tanggal)) }}</span>
                                        </div>
                                        <a href="{{ route('Berita.show', ['slug' => $featured->slug]) }}">
                                            <h3 class="news-title">{{ $featured->judul }}</h3>
                                        </a>
                                        <p class="news-excerpt">{{ Str::limit(strip_tags($featured->isi), 120) }}</p>
                                        <a href="{{ route('Berita.show', ['slug' => $featured->slug]) }}" class="news-link">
                                            Baca selengkapnya <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-gray-500 p-4">Tidak ada berita unggulan untuk ditampilkan.</div>
                    @endif
                </div>
            </div>
        </div>
    </main>
    
    <section class="program-section">
        <div class="container mx-auto px-6">
            <div class="section-header">
                <h2 class="section-title">Program & Layanan</h2>
                <p class="section-description">Jelajahi berbagai program dan layanan unggulan yang kami sediakan untuk mendukung inovasi dan pemeringkatan.</p>
            </div>
    
            {{-- Grid Responsif: 1 kolom di mobile, 2 di tablet, 4 di desktop --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($programLayanan as $program)
                    <div class="program-card">
                        <div class="icon-container">
                            <i class="{{ $program->icon ?? 'fas fa-cogs' }}"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">{{ $program->judul }}</h3>
                            <p class="card-description">{!! Str::limit(strip_tags($program->deskripsi), 100) !!}</p>
                            <a href="#" class="card-link program-details-btn" data-program-id="{{ $program->id }}" data-title="{{ $program->judul }}" data-full-description="{!! htmlspecialchars($program->deskripsi_lengkap ?? $program->deskripsi) !!}">
                                Selengkapnya <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">Belum ada program layanan yang tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="media-section py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-teal-700">Instagram DITSIP UNJ</h2>
                 <p class="text-gray-600 max-w-2xl mx-auto mt-2">Ikuti akun Instagram kami untuk mendapatkan informasi terbaru.</p>
                <a href="https://www.instagram.com/dit.isipunj/" target="_blank" class="inline-flex items-center text-teal-700 hover:text-yellow-500 mt-2 font-medium">
                    <span>@dit.isipunj</span>
                    <i class="fas fa-external-link-alt ml-2"></i>
                </a>
            </div>

            {{-- Grid Responsif: 1 kolom di mobile, 2 di tablet, 3 di desktop --}}
            <div id="instagram-api-feed-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                @for ($i = 0; $i < 3; $i++)
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg animate-pulse">
                        <div class="h-48 bg-gray-200"></div>
                        <div class="p-6"><div class="h-4 bg-gray-200 rounded w-3/4"></div></div>
                    </div>
                @endfor
            </div>
             <div class="text-center mt-8">
                <a href="https://www.instagram.com/dit.isipunj/" target="_blank" class="inline-flex items-center justify-center px-6 py-3 bg-teal-700 hover:bg-teal-600 text-white font-medium rounded-lg">
                    <span>Lihat Semua Postingan</span>
                    <i class="fas fa-external-link-alt ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <section class="media-section py-16">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-teal-700">Galeri Video</h2>
                 <p class="text-gray-600 max-w-2xl mx-auto mt-2">Tonton video dokumentasi kegiatan dan informasi dari kanal YouTube kami.</p>
            </div>
            
            {{-- Grid Responsif: 1 kolom di mobile, 2 di tablet, 3 di desktop --}}
            <div id="dynamic-videos-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                 @for ($i = 0; $i < 3; $i++)
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg animate-pulse">
                        <div class="h-48 bg-gray-200"></div>
                        <div class="p-6"><div class="h-4 bg-gray-200 rounded w-3/4"></div></div>
                    </div>
                @endfor
            </div>
            <div class="text-center mt-8">
                <a href="https://www.youtube.com/channel/UCjQ4lIzs8Zm3zVD3wiL-KMw" target="_blank" class="inline-flex items-center justify-center px-6 py-3 bg-teal-700 hover:bg-teal-600 text-white font-medium rounded-lg">
                    <span>Lihat Semua Video</span>
                    <i class="fas fa-external-link-alt ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <section class="unj-prestasi-container">
        <div class="container mx-auto px-4">
            <div class="section-title text-center mb-12">
                <h2 class="text-3xl font-bold text-white">UNJ dalam <span class="highlight">Prestasi</span></h2>
                <div class="title-underline"></div>
            </div>
            
            {{-- Grid Responsif: 2 kolom di mobile, 3 di tablet, 6 di desktop --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 text-center text-white">
                <div class="prestasi-item"><div class="prestasi-icon"><i class="fa fa-user-graduate"></i></div><div class="prestasi-number">30.673</div><div class="prestasi-title">Mahasiswa</div></div>
                <div class="prestasi-item"><div class="prestasi-icon"><i class="fa fa-globe"></i></div><div class="prestasi-number">125</div><div class="prestasi-title">Mahasiswa Internasional</div></div>
                <div class="prestasi-item"><div class="prestasi-icon"><i class="fa fa-chalkboard-teacher"></i></div><div class="prestasi-number">131</div><div class="prestasi-title">Guru Besar</div></div>
                <div class="prestasi-item"><div class="prestasi-icon"><i class="fa fa-user-tie"></i></div><div class="prestasi-number">1.132</div><div class="prestasi-title">Dosen</div></div>
                <div class="prestasi-item"><div class="prestasi-icon"><i class="fa fa-users"></i></div><div class="prestasi-number">4</div><div class="prestasi-title">Dosen Internasional</div></div>
                <div class="prestasi-item"><div class="prestasi-icon"><i class="fa fa-book"></i></div><div class="prestasi-number">3.681</div><div class="prestasi-title">Terindeks Scopus</div></div>
            </div>
        </div>
    </section>

    @include('layout.footer')

    <div id="programDetailsModal" class="fixed inset-0 bg-black bg-opacity-60 z-[1100] hidden items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto relative">
            <button id="closeModalBtn" class="absolute top-4 right-4 bg-gray-200 rounded-full p-2 z-10 hover:bg-gray-300 transition-colors">
                <i class="fas fa-times"></i>
            </button>
            <div class="p-6 md:p-8">
                 <h2 id="programModalTitle" class="text-2xl font-bold text-teal-700 mb-4"></h2>
                 <div id="programModalDescription" class="prose text-gray-700"></div>
            </div>
        </div>
    </div>
    
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Script untuk modal program (sudah baik, tidak perlu diubah)
            const modal = document.getElementById('programDetailsModal');
            const closeModalBtn = document.getElementById('closeModalBtn');
            document.querySelectorAll('.program-details-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.getElementById('programModalTitle').innerText = this.dataset.title;
                    document.getElementById('programModalDescription').innerHTML = this.dataset.fullDescription;
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
            });
            closeModalBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            });


            // Script untuk mengambil data video YouTube dari API (sudah baik)
            fetch('/api/youtube-videos')
                .then(response => response.json())
                .then(videos => {
                    const container = document.getElementById('dynamic-videos-container');
                    container.innerHTML = ''; 
                    if (!videos || videos.length === 0) {
                        container.innerHTML = `<p class="col-span-full text-center">Video tidak tersedia.</p>`;
                        return;
                    }
                    videos.slice(0, 3).forEach(video => { // Ambil 3 video pertama
                        const videoId = new URL(video.link).searchParams.get('v');
                        const embedUrl = `https://www.youtube.com/embed/${videoId}`;
                        const card = `
                        <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300">
                            <div class="aspect-w-16 aspect-h-9">
                                <iframe class="w-full h-full" src="${embedUrl}" title="${video.judul}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-2 text-teal-800">${video.judul}</h3>
                            </div>
                        </div>`;
                        container.innerHTML += card;
                    });
                })
                .catch(error => {
                    console.error('Gagal memuat video YouTube:', error);
                    document.getElementById('dynamic-videos-container').innerHTML = `<p class="col-span-full text-center">Gagal memuat video.</p>`;
                });
        });
    </script>

</body>
</html>
