<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produk->nama_produk }} - Produk Inovasi UNJ</title>
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
            <h1 class="text-3xl md:text-4xl font-bold text-primary mt-4">{{ $produk->nama_produk }}</h1>
            <p class="text-textSecondary mt-2">Oleh: {{ $produk->inovator }}</p>
             <div class="w-fit bg-accent/20 text-accent rounded-full px-3 py-1 text-x font-semibold">
                                        {{ $produk->kategori }} No:{{ $produk->nomor_paten }}
            </div>
        </div>

        <div class="bg-cardColor rounded-card shadow-lg p-6 md:p-8">

            {{-- Bagian Video Produk --}}
            @if($produk->video_path)
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-primary mb-4 border-b pb-2">Video Produk</h2>
                <div id="video-container" class="max-w-4xl mx-auto bg-black rounded-card shadow-lg overflow-hidden aspect-video relative">
                    
                    @php
                        $youtubeId = '';
                        if ($produk->video_type == 'youtube') {
                            preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $produk->video_path, $matches);
                            if (isset($matches[1])) {
                                $youtubeId = $matches[1];
                            }
                        }
                    @endphp

                    @if($produk->video_type == 'youtube' && $youtubeId)
                        <div id="video-placeholder" class="w-full h-full bg-cover bg-center cursor-pointer relative group"
                             style="background-image: url('https://img.youtube.com/vi/{{ $youtubeId }}/maxresdefault.jpg');"
                             data-video-type="{{ $produk->video_type }}" data-video-path="{{ $youtubeId }}">
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center text-center text-white p-4 transition-colors duration-300 group-hover:bg-black/20">
                                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300 ease-out-expo">
                                    <i class="fa-solid fa-play text-white text-3xl ml-1"></i>
                                </div>
                            </div>
                        </div>
                    @elseif($produk->video_type == 'mp4')
                        <div id="video-placeholder" class="w-full h-full bg-gradient-to-br from-primary to-primary-light flex items-center justify-center cursor-pointer group"
                             data-video-type="{{ $produk->video_type }}" data-video-path="{{ asset('storage/' . $produk->video_path) }}">
                            <div class="text-center text-white">
                                <i class="fas fa-play-circle text-6xl mb-4 opacity-80 transform group-hover:scale-110 transition-transform duration-300 ease-out-expo"></i>
                                <p class="text-xl">Putar Video</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @endif


            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                {{-- Kolom Kiri: Poster --}}
                <div>
                    <h2 class="text-xl font-bold text-primary mb-4 border-b pb-2">Poster</h2>
                    @if($produk->foto_poster)
                        <img src="{{ asset('storage/' . $produk->foto_poster) }}" alt="Poster {{ $produk->nama_produk }}" class="w-full h-auto object-cover rounded-lg shadow-md">
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
                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="w-full h-auto object-cover rounded-lg shadow-md mb-8">
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
                    {!! $produk->deskripsi !!}
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

    // Video Player Script
    document.addEventListener('DOMContentLoaded', function () {
        const placeholder = document.getElementById('video-placeholder');
        const videoContainer = document.getElementById('video-container');

        if (placeholder) {
            placeholder.addEventListener('click', function () {
                const type = this.dataset.videoType;
                const path = this.dataset.videoPath;
                let playerHtml = '';

                if (type === 'youtube') {
                    playerHtml = `<iframe class="w-full h-full" src="https://www.youtube.com/embed/${path}?autoplay=1&rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;
                } else if (type === 'mp4') {
                    playerHtml = `<video class="w-full h-full" controls autoplay><source src="${path}" type="video/mp4">Browser Anda tidak mendukung tag video.</video>`;
                }

                if (playerHtml) {
                    videoContainer.innerHTML = playerHtml;
                }
            });
        }
    });
</script>

</body>
</html>