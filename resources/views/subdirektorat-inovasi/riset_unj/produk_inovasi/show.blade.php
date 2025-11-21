<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produk->getTranslatedName() }} - Produk Inovasi UNJ</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#186569', light: '#2a7a7e', dark: '#0d4b4f' },
                        accent: '#ffb74d',
                        textColor: '#333333',
                        textSecondary: '#555555',
                        backgroundColor: '#f8f9fa',
                        cardColor: '#ffffff',
                    },
                    borderRadius: { card: '12px' },
                    transitionTimingFunction: { 'out-expo': 'cubic-bezier(0.19, 1, 0.22, 1)' }
                },
            },
        }
    </script>
    <style>
        .prose iframe { width: 100%; aspect-ratio: 16 / 9; border-radius: 0.5rem; }
    </style>
</head>
<body class="bg-backgroundColor text-textColor leading-relaxed font-['Segoe_UI',Tahoma,Geneva,Verdana,sans-serif]">

<div class="pt-20 md:pt-24 pb-16">
  <main class="w-[90%] max-w-7xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('subdirektorat-inovasi.riset_unj.produk_inovasi.produkinovasi') }}#katalog" class="text-primary hover:text-primary-dark font-semibold transition-colors duration-300">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Katalog
            </a>
            <h1 class="text-3xl md:text-4xl font-bold text-primary mt-4">{{ $produk->getTranslatedName() }}</h1>
            <p class="text-textSecondary mt-2">Oleh: {{ $produk->inovator }}</p>
             <div class="w-fit bg-accent/20 text-accent rounded-full px-3 py-1 text-x font-semibold">
                                        {{ $produk->kategori }} No:{{ $produk->nomor_paten }}
            </div>
        </div>

        <div class="bg-cardColor rounded-card shadow-lg p-6 md:p-8">

            {{-- Bagian Video Produk (Slider) --}}
            @if($produk->videos->count() > 0)
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-primary mb-4 border-b pb-2">Video Produk</h2>
                <div class="relative max-w-4xl mx-auto bg-black rounded-card shadow-lg overflow-hidden aspect-video">
                    <div id="video-slider" class="relative w-full h-full">
                        @foreach($produk->videos as $index => $video)
                            @php
                                $youtubeId = '';
                                if ($video->type == 'youtube') {
                                    // Extract YouTube ID from various URL formats
                                    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video->path, $matches);
                                    if (isset($matches[1])) {
                                        $youtubeId = $matches[1];
                                    }
                                }
                            @endphp
                            <div class="video-slide absolute w-full h-full top-0 left-0 transition-opacity duration-500 ease-in-out {{ $index == 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}" 
                                 data-index="{{ $index }}"
                                 data-video-type="{{ $video->type }}"
                                 @if($youtubeId) data-youtube-id="{{ $youtubeId }}" @endif>
                                 
                                @if($video->type == 'youtube' && $youtubeId)
                                    <div class="video-placeholder w-full h-full bg-cover bg-center cursor-pointer relative group"
                                         style="background-image: url('https://img.youtube.com/vi/{{ $youtubeId }}/maxresdefault.jpg');"
                                         data-youtube-id="{{ $youtubeId }}">
                                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center text-center text-white p-4 transition-colors duration-300 group-hover:bg-black/20">
                                            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300 ease-out-expo">
                                                <i class="fa-solid fa-play text-white text-3xl ml-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($video->type == 'mp4')
                                    <div class="w-full h-full flex items-center justify-center bg-gray-900">
                                        <video class="w-full h-full" controls muted preload="metadata" controlsList="nodownload">
                                            <source src="{{ \Illuminate\Support\Facades\Storage::url($video->path) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-900 text-white">
                                        <p>Video tidak dapat dimuat.</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Slider Navigation --}}
                    @if($produk->videos->count() > 1)
                    <button id="prevBtn" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/30 hover:bg-white/50 text-white p-3 rounded-full z-20 transition-all duration-300">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button id="nextBtn" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/30 hover:bg-white/50 text-white p-3 rounded-full z-20 transition-all duration-300">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    @endif
                </div>
            </div>
            @endif


            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                {{-- Kolom Kiri: Poster --}}
                <div>
                    <h2 class="text-xl font-bold text-primary mb-4 border-b pb-2">Poster</h2>
                    @if($produk->foto_poster)
                        <img src="{{ asset('storage/' . $produk->foto_poster) }}" alt="Poster {{ $produk->getTranslatedName() }}" class="w-full h-auto object-cover rounded-lg shadow-md">
                    @else
                        <div class="w-full aspect-[3/4] bg-gray-200 flex items-center justify-center rounded-lg text-center p-4">
                           <span class="text-gray-400">Poster tidak tersedia</span>
                        </div>
                    @endif
                </div>

                {{-- Kolom Kanan: Thumbnail & Barcode --}}
                <div>
                    <h2 class="text-xl font-bold text-primary mb-4 border-b pb-2">Foto Alat</h2>
                    @if($produk->gambar)
                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->getTranslatedName() }}" class="w-full h-auto object-cover rounded-lg shadow-md mb-8">
                    @else
                        <div class="w-full aspect-video bg-gray-200 flex items-center justify-center rounded-lg mb-8">
                            <i class="fas fa-image text-gray-400 text-5xl"></i>
                        </div>
                    @endif
                    
                    
                </div>
            </div>

            {{-- Penjelasan Alat --}}
            <div class="mt-6">
                <h2 class="text-2xl font-bold text-primary mb-4 border-b pb-2">Penjelasan Alat</h2>
                <div class="prose max-w-none text-textColor leading-7">
                    {!! $produk->getTranslatedDescription() !!}
                </div>
            </div>

            {{-- Link E-Book --}}
            @if($produk->link_ebook)
            <div class="mt-8">
                <h2 class="text-xl font-bold text-primary mb-4 border-b pb-2">Link E-Book</h2>
                <a href="{{ $produk->link_ebook }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-transform duration-300 hover:scale-105">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    Link E-Book
                </a>
            </div>
            @endif
        </div>
    </main>
</div>

<div id="qrcode" style="display:none"></div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>
<script type="text/javascript">
    // QR Code Generator
    new QRCode(document.getElementById("qrcode"), {
        text: window.location.href,
        width: 180,
        height: 180,
        colorDark : "#0d4b4f",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
    });

    document.addEventListener('DOMContentLoaded', function () {
        const slides = document.querySelectorAll('.video-slide');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let currentSlide = 0;

        function showSlide(index) {
            if (index === currentSlide && document.querySelector('.video-slide[data-index="' + index + '"] iframe')) {
                 // Do not interrupt a video that is already playing on the current slide.
                return;
            }
            
            slides.forEach((slide, i) => {
                const isCurrent = i === index;
                slide.classList.toggle('opacity-100', isCurrent);
                slide.classList.toggle('z-10', isCurrent);
                slide.classList.toggle('opacity-0', !isCurrent);
                slide.classList.toggle('z-0', !isCurrent);

                const videoElement = slide.querySelector('video');
                if (videoElement) {
                    if (isCurrent) {
                        videoElement.play().catch(error => console.log("Autoplay was prevented.", error));
                    } else {
                        videoElement.pause();
                    }
                }
                
                const iframe = slide.querySelector('iframe');
                if (iframe) {
                    slide.querySelector('.video-placeholder').style.display = 'block';
                    iframe.remove();
                }
            });
            currentSlide = index;
        }

        function nextSlide() {
            showSlide((currentSlide + 1) % slides.length);
        }

        function prevSlide() {
            showSlide((currentSlide - 1 + slides.length) % slides.length);
        }

        if (nextBtn) nextBtn.addEventListener('click', nextSlide);
        if (prevBtn) prevBtn.addEventListener('click', prevSlide);

        // Handle clicking on YouTube placeholders
        document.getElementById('video-slider').addEventListener('click', function(e) {
            const placeholder = e.target.closest('.video-placeholder');
            if (placeholder && placeholder.dataset.youtubeId) {
                const youtubeId = placeholder.dataset.youtubeId;
                const iframe = document.createElement('iframe');
                iframe.className = 'w-full h-full';
                iframe.src = `https://www.youtube.com/embed/${youtubeId}?autoplay=1&rel=0&mute=1`;
                iframe.setAttribute('frameborder', '0');
                iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share');
                iframe.setAttribute('allowfullscreen', '');
                
                placeholder.style.display = 'none';
                placeholder.parentNode.appendChild(iframe);
            }
        });


        // Initialize slider
        if (slides.length > 0) {
            showSlide(currentSlide);
        }
    });
</script>

</body>
</html>