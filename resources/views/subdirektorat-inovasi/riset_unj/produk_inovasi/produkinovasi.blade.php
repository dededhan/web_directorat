<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Inovasi UNJ</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#186569',
                            light: '#2a7a7e',
                            dark: '#0d4b4f',
                        },
                        accent: '#ffb74d',
                        textColor: '#333333',
                        textSecondary: '#555555',
                        backgroundColor: '#f8f9fa',
                        cardColor: '#ffffff',
                    },
                    boxShadow: {
                        card: '0 4px 12px rgba(0, 0, 0, 0.08)',
                        hover: '0 12px 20px rgba(0, 0, 0, 0.1)',
                        search: '0 5px 15px rgba(0, 0, 0, 0.1)',
                    },
                    borderRadius: {
                        card: '12px',
                    },
                    transitionDuration: {
                        DEFAULT: '300ms',
                    },
                },
            },
        }
    </script>
</head>
<body class="bg-backgroundColor text-textColor leading-relaxed text-base font-['Segoe_UI',Tahoma,Geneva,Verdana,sans-serif]">
@include('layout.navbar_hilirisasi')
    
    <section class="bg-gradient-to-br from-primary to-primary-dark py-12 mb-8 relative overflow-hidden">
        <div class="absolute inset-0 opacity-30" style="background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="100" height="100" fill="none"/><path d="M0,0 L100,100" stroke="rgba(255,255,255,0.05)" stroke-width="2"/></svg>');"></div>
        
        <div class="relative text-center text-white max-w-3xl mx-auto px-4">
            <h1 class="text-4xl font-bold mb-4 drop-shadow-md">Produk Inovasi UNJ</h1>
            <p class="text-xl mb-8 opacity-90">Temukan berbagai inovasi dan karya terbaik dari civitas akademika Universitas Negeri Jakarta</p>
            
            <div class="flex w-full max-w-xl mx-auto relative shadow-search rounded-full">
                <input type="text" class="flex-grow py-4 px-6 border-none rounded-l-full outline-none text-base bg-white/95 transition duration-300 text-textColor placeholder-textSecondary placeholder-opacity-70 focus:ring-2 focus:ring-accent" placeholder="Cari produk inovasi, inovator, atau kata kunci...">
                <button class="bg-accent text-textColor border-none px-7 rounded-r-full cursor-pointer transition duration-300 flex items-center justify-center font-semibold hover:bg-[#ffa726] hover:-translate-y-px">
                    <i class="fa-solid fa-search"></i>
                    <span class="ml-2 md:inline hidden">Cari</span>
                </button>
            </div>
        </div>
    </section>

    <div class="pt-28 md:pt-24 overflow-x-hidden">
        <main class="w-[90%] max-w-6xl mx-auto">
            <section>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 my-5">
                    @if($produkInovasi->count() > 0)
                        @foreach($produkInovasi as $produk)
                        <div class="bg-cardColor rounded-card overflow-hidden shadow-card h-full flex flex-col transition duration-300 border border-black/5 hover:transform hover:-translate-y-2 hover:shadow-hover">
                            @if($produk->gambar)
                            <div class="h-[200px] bg-cover bg-center relative transition duration-300 group-hover:h-[210px]" style="background-image: url('{{ asset('storage/' . $produk->gambar) }}')"></div>
                            @else
                            <div class="h-[200px] bg-gradient-to-br from-primary to-primary-light flex items-center justify-center transition duration-300 group-hover:h-[210px]">
                                <i class="fas fa-lightbulb text-5xl text-white opacity-70"></i>
                            </div>
                            @endif
                            
                            <div class="p-5 flex flex-col flex-grow relative">
                                <span class="inline-flex items-center text-xs font-medium text-primary bg-primary/10 px-2.5 py-1 rounded-full mb-3">
                                    <i class="fas fa-user-alt mr-1.5"></i>
                                    {{ $produk->inovator }}
                                </span>
                                
                                <h3 class="text-xl font-bold mb-3">{{ $produk->nama_produk }}</h3>
                                
                                <p class="text-textSecondary text-sm mb-4 line-clamp-3">
                                    {!! Str::limit(strip_tags($produk->deskripsi), 120) !!}
                                </p>
                                
                                <div class="flex justify-between items-center mt-auto mb-3 md:flex-row flex-col md:items-center items-start">
                                    <div class="flex items-center text-textSecondary text-sm">
                                        <i class="fas fa-calendar-alt mr-1.5"></i>
                                        <span>{{ $produk->created_at->format('d M Y') }}</span>
                                    </div>
                                    
                                    @if($produk->nomor_paten)
                                    <div class="bg-accent/20 text-accent rounded-full px-3 py-1 text-xs font-semibold flex items-center mt-2 md:mt-0">
                                        <i class="fas fa-certificate mr-1"></i>
                                        Paten
                                    </div>
                                    @endif
                                </div>
                                
                                <button onclick="openProductModal({{ $produk->id }})" class="w-full mt-2 bg-primary hover:bg-primary-dark text-white transition duration-300 flex items-center justify-center text-sm font-medium py-2.5 px-3 rounded">
                                    Baca Selengkapnya
                                </button>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="col-span-full flex flex-col items-center justify-center py-16 text-center text-textSecondary">
                            <i class="fas fa-lightbulb text-5xl mb-4 opacity-50"></i>
                            <p class="text-lg">Belum ada produk inovasi yang tersedia.</p>
                        </div>
                    @endif
                </div>
            </section>
        </main>
    </div>

    <div id="productModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-300 overflow-y-auto">
        <div class="bg-white w-full max-w-3xl rounded-card overflow-hidden shadow-lg max-h-[90vh] flex flex-col">
            <div class="h-[300px] md:h-[350px] relative bg-primary">
                <img id="modalImg" src="" alt="" class="w-full h-full object-cover">
                <button onclick="closeProductModal()" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-black/30 text-white flex items-center justify-center hover:bg-black/50 transition duration-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="modalBody" class="p-6 md:p-8 overflow-y-auto -webkit-overflow-scrolling-touch max-h-[calc(90vh-350px)]">
            </div>
        </div>
    </div>
    
    @include('layout.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[type="text"]');
            const searchButton = document.querySelector('button');
            
            function performSearch() {
                const searchTerm = searchInput.value.trim().toLowerCase();
                const productCards = document.querySelectorAll('.bg-cardColor');
                let hasResults = false;
                
                productCards.forEach(card => {
                    const title = card.querySelector('h3').textContent.toLowerCase();
                    const excerpt = card.querySelector('p').textContent.toLowerCase();
                    const innovator = card.querySelector('.inline-flex').textContent.toLowerCase();
                    
                    if (title.includes(searchTerm) || excerpt.includes(searchTerm) || innovator.includes(searchTerm)) {
                        card.style.display = 'flex';
                        hasResults = true;
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                const productsGrid = document.querySelector('.grid');
                let noResultsElement = document.querySelector('.no-search-results');
                
                if (!hasResults && searchTerm) {
                    if (!noResultsElement) {
                        noResultsElement = document.createElement('div');
                        noResultsElement.className = 'col-span-full flex flex-col items-center justify-center py-16 text-center text-textSecondary no-search-results';
                        noResultsElement.innerHTML = '<i class="fas fa-search text-5xl mb-4 opacity-50"></i><p class="text-lg">Tidak ada produk inovasi yang cocok dengan pencarian Anda.</p>';
                        productsGrid.appendChild(noResultsElement);
                    }
                } else if (noResultsElement) {
                    noResultsElement.remove();
                }
            }
            
            searchButton.addEventListener('click', performSearch);
            
            searchInput.addEventListener('keyup', function(event) {
                if (event.key === 'Enter') {
                    performSearch();
                }
            });

            searchInput.addEventListener('input', function() {
                if (this.value.trim() === '') {
                    document.querySelectorAll('.bg-cardColor').forEach(card => {
                        card.style.display = 'flex';
                    });
                    const noResultsElement = document.querySelector('.no-search-results');
                    if (noResultsElement) {
                        noResultsElement.remove();
                    }
                }
            });
        });

        function openProductModal(productId) {
            const produkData = @json($produkInovasi->keyBy('id'));
            const produk = produkData[productId];
            
            if (!produk) return;
            
            const modal = document.getElementById('productModal');
            const modalImg = document.getElementById('modalImg');
            const modalBody = document.getElementById('modalBody');
            
            if (produk.gambar) {
                modalImg.src = `/storage/${produk.gambar}`;
                modalImg.alt = produk.nama_produk;
                modalImg.style.display = 'block';
            } else {
                modalImg.style.display = 'none';
            }
            
            let patentInfo = '';
            if (produk.nomor_paten) {
                patentInfo = `
                    <div class="flex items-center text-textSecondary text-sm">
                        <i class="fas fa-certificate mr-1.5"></i>
                        <span>No. Paten: ${produk.nomor_paten}</span>
                    </div>
                `;
            }
            
            const content = `
                <span class="inline-flex items-center text-xs font-medium text-primary bg-primary/10 px-2.5 py-1 rounded-full mb-3">
                    <i class="fas fa-user-alt mr-1.5"></i>
                    ${produk.inovator}
                </span>
                <h2 class="text-2xl md:text-3xl font-bold mb-4">${produk.nama_produk}</h2>
                <div class="flex flex-col md:flex-row gap-3 mb-6 pb-4 border-b border-black/10">
                    <div class="flex items-center text-textSecondary text-sm">
                        <i class="fas fa-calendar-alt mr-1.5"></i>
                        <span>Ditambahkan: ${formatDate(produk.created_at)}</span>
                    </div>
                    ${patentInfo}
                </div>
                <div class="leading-7 text-textColor text-base">
                    <h3 class="font-semibold mb-4 text-primary">Deskripsi Produk:</h3>
                    ${produk.deskripsi}
                </div>
            `;
            
            modalBody.innerHTML = content;
            modal.classList.add('opacity-100');
            modal.classList.remove('pointer-events-none');
            document.body.style.overflow = 'hidden';
        }

        function closeProductModal() {
            const modal = document.getElementById('productModal');
            modal.classList.remove('opacity-100');
            modal.classList.add('pointer-events-none');
            document.body.style.overflow = 'auto';
        }

        function formatDate(dateString) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        }

        document.getElementById('productModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeProductModal();
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeProductModal();
            }
        });
    </script>
</body>
</html>