<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produk->nama_produk }} - Produk Inovasi UNJ</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
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
                },
            },
        }
    </script>
</head>
<body class="bg-backgroundColor text-textColor leading-relaxed font-['Segoe_UI',Tahoma,Geneva,Verdana,sans-serif]">
@include('layout.navbar_hilirisasi')

<div class="pt-20 md:pt-24 pb-16">
    <main class="w-[90%] max-w-5xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('subdirektorat-inovasi.riset_unj.produk_inovasi.produkinovasi') }}#katalog" class="text-primary hover:text-primary-dark font-semibold transition-colors duration-300">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Katalog
            </a>
            <h1 class="text-3xl md:text-4xl font-bold text-primary mt-4">{{ $produk->nama_produk }}</h1>
            <p class="text-textSecondary mt-2">Oleh: {{ $produk->inovator }}</p>
        </div>

        <div class="bg-cardColor rounded-card shadow-lg p-6 md:p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                {{-- Kolom Kiri: Foto Alat --}}
                <div class="md:col-span-2">
                    <h2 class="text-xl font-bold text-primary mb-4 border-b pb-2">Foto Alat</h2>
                    @if($produk->gambar)
                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="w-full h-auto object-cover rounded-lg shadow-md">
                    @else
                        <div class="w-full aspect-video bg-gray-200 flex items-center justify-center rounded-lg">
                            <i class="fas fa-image text-gray-400 text-5xl"></i>
                        </div>
                    @endif
                </div>

                {{-- Kolom Kanan: Barcode --}}
                <div class="md:col-span-1">
                    <h2 class="text-xl font-bold text-primary mb-4 border-b pb-2">Barcode</h2>
                    <div class="flex flex-col items-center justify-center bg-gray-50 p-4 rounded-lg">
                        <div id="qrcode" class="p-2 bg-white rounded-md shadow-inner"></div>
                        <p class="text-sm text-textSecondary mt-3 text-center">Pindai untuk membuka halaman ini di perangkat lain.</p>
                    </div>
                </div>

                {{-- Baris Bawah: Penjelasan Alat --}}
                <div class="md:col-span-3 mt-6">
                    <h2 class="text-xl font-bold text-primary mb-4 border-b pb-2">Penjelasan Alat</h2>
                    <div class="prose max-w-none text-textColor leading-7">
                        {!! $produk->deskripsi !!}
                    </div>
                </div>

                {{-- Baris Paling Bawah: Link Poster --}}
                @if($produk->link_ebook)
                <div class="md:col-span-3 mt-6">
                    <h2 class="text-xl font-bold text-primary mb-4 border-b pb-2">Link Poster / E-Book</h2>
                    <a href="{{ $produk->link_ebook }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-transform duration-300 hover:scale-105">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        Lihat Poster / E-Book
                    </a>
                </div>
                @endif

            </div>
        </div>
    </main>
</div>

@include('layout.footer')

{{-- Script untuk generate QR Code --}}
<script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>
<script type="text/javascript">
    new QRCode(document.getElementById("qrcode"), {
        text: window.location.href,
        width: 180,
        height: 180,
        colorDark : "#0d4b4f",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
    });
</script>

</body>
</html>