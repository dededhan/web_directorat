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
    <style>
        /* Base styles */
        body {
            font-family: 'Roboto', sans-serif;
        }
        
        /* Product Styles */
        .product-item {
            border: 1px solid #e0e0e0;
            margin-bottom: 10px;
            border-radius: 8px;
            overflow: hidden;
        }
        .product-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: #f0f0f0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .product-header:hover {
            background-color: #e0e0e0;
        }
        .product-content {
            display: none;
            padding: 15px;
            background-color: white;
        }
        .product-content.active {
            display: block;
        }
        .detail-content {
            display: none;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
        }
        .detail-content.active {
            display: block;
        }
        .toggle-icon {
            transition: transform 0.3s ease;
        }
        .toggle-icon.rotated {
            transform: rotate(180deg);
        }
        .product-meta {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #e0e0e0;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .meta-item {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            color: #555;
        }
        .meta-item i {
            margin-right: 5px;
            color: #176369;
        }
        
        /* Important: Add proper spacing for fixed navbar */
        .content-wrapper {
            padding-top: 7rem; /* Increased desktop padding */
        }
        
        @media (max-width: 768px) {
            .content-wrapper {
                padding-top: 6rem; /* Increased mobile padding */
            }
        }
        /* Ensure the modal appears on top of everything else */
.modal {
    z-index: 9999 !important; /* Higher z-index to ensure it's on top */
}

.modal-backdrop {
    z-index: 9998 !important; /* Backdrop should be just below the modal */
}

/* Additional styling for the modal */
.modal-content {
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    border: none;
}

.modal-header {
    border-bottom: 1px solid #e5e5e5;
    padding: 1rem 1.5rem;
}

.modal-body {
    padding: 1.5rem;
}

.btn-close {
    opacity: 0.7;
}

.btn-close:hover {
    opacity: 1;
}

.form-control {
    padding: 0.6rem 0.75rem;
    border: 1px solid #ced4da;
}

.form-control:focus {
    border-color: #176369;
    box-shadow: 0 0 0 0.25rem rgba(23, 99, 105, 0.25);
}

/* Button styling */
.btn-primary {
    padding: 0.5rem 1rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #125a54 !important;
    border-color: #125a54 !important;
}
    </style>
</head>
<body class="bg-gray-100">
    @include('subdirektorat-inovasi.riset_unj.produk_inovasi.navbarprofile')

    <!-- Main Content with increased spacing -->
    <div class="content-wrapper">
        <div class="container mx-auto px-4 py-8 max-w-4xl">
            <h1 class="text-3xl font-bold mb-8 text-center">
                 <span style="color: #176369;">PRODUK INOVASI UNJ</span> 
            </h1>

            <div class="space-y-4">
                @if($produkInovasi->count() > 0)
                    @foreach($produkInovasi as $produk)
                    <div class="product-item bg-white rounded-lg shadow-md">
                        <div class="product-header" onclick="toggleDropdown(this)">
                            <h2 class="font-bold text-lg">{{ $produk->nama_produk }}</h2>
                            <svg class="toggle-icon w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <div class="product-content">
                            <div class="flex flex-col md:flex-row gap-6">
                                @if($produk->gambar)
                                <div class="md:w-1/3 mb-4 md:mb-0">
                                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="w-full h-auto rounded-lg object-cover">
                                </div>
                                @endif
                                <div class="md:w-2/3">
                                    <h3 class="text-xl font-semibold mb-3">{{ $produk->nama_produk }}</h3>
                                    <div class="product-meta mb-4">
                                        <div class="meta-item">
                                            <i class="fas fa-user-alt"></i>
                                            <span>Inovator: {{ $produk->inovator }}</span>
                                        </div>
                                        @if($produk->nomor_paten)
                                        <div class="meta-item">
                                            <i class="fas fa-certificate"></i>
                                            <span>No. Paten: {{ $produk->nomor_paten }}</span>
                                        </div>
                                        @endif
                                        <div class="meta-item">
                                            <i class="fas fa-calendar-alt"></i>
                                            <span>Ditambahkan: {{ $produk->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="description">
                                        <h4 class="font-semibold mb-2">Deskripsi Singkat:</h4>
                                        <div class="text-gray-700 mb-3">
                                            {!! Str::limit(strip_tags($produk->deskripsi), 150) !!}
                                        </div>
                                        <button class="text-blue-500 hover:underline selengkapnya-btn focus:outline-none">
                                            Lihat Detail Lengkap
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="detail-content">
                                <h3 class="text-lg font-semibold mb-3">Detail Produk Inovasi</h3>
                                <div class="text-gray-700">
                                    {!! $produk->deskripsi !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="bg-white rounded-lg shadow-md p-6 text-center">
                        <p class="text-gray-500">Belum ada produk inovasi yang ditambahkan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('subdirektorat-inovasi.riset_unj.produk_inovasi.footerrisetunj')

    <script>
        function toggleDropdown(element) {
            // Close all other open dropdowns first
            const allContents = document.querySelectorAll('.product-content');
            const allIcons = document.querySelectorAll('.toggle-icon');
            const allDetailContents = document.querySelectorAll('.detail-content');
            
            allContents.forEach(content => {
                if (content !== element.nextElementSibling) {
                    content.classList.remove('active');
                }
            });
            
            allIcons.forEach(icon => {
                if (icon !== element.querySelector('.toggle-icon')) {
                    icon.classList.remove('rotated');
                }
            });

            allDetailContents.forEach(detailContent => {
                detailContent.classList.remove('active');
            });

            // Toggle the clicked dropdown
            const content = element.nextElementSibling;
            content.classList.toggle('active');

            // Rotate the toggle icon
            const icon = element.querySelector('.toggle-icon');
            icon.classList.toggle('rotated');
        }

        // Add event listener for "Selengkapnya" button after the DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.selengkapnya-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation(); // Prevent triggering parent dropdown
                    const detailContent = this.closest('.product-content').querySelector('.detail-content');
                    detailContent.classList.toggle('active');
                    
                    // Change button text based on state
                    if (detailContent.classList.contains('active')) {
                        this.textContent = 'Sembunyikan Detail';
                    } else {
                        this.textContent = 'Lihat Detail Lengkap';
                    }
                });
            });
        });
    </script>
</body>
</html>