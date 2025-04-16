<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Inovasi UNJ</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Custom Styles */
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
    </style>
</head>
@include('Inovasi.riset_unj.produk_inovasi.navbarprofile')
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <h1 class="text-3xl font-bold mb-6 text-center">
             <span style="color: #176369;">PRODUK INOVASI UNJ</span> 
        </h1>

        <div class="space-y-4">
            @php
            $products = [
                [
                    'name' => 'Lorem Ipsum',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                    'detail' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                    'image' => 'https://masuk-ptn.com/images/product/6de51bb6b61afd78744eebba0e6e03f040664e9d.jpg'
                ],
                [
                    'name' => 'Lorem Ipsum',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                    'detail' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                    'image' => 'https://masuk-ptn.com/images/product/6de51bb6b61afd78744eebba0e6e03f040664e9d.jpg'
                ],
                [
                    'name' => 'Lorem Ipsum',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                    'detail' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                    'image' => 'https://masuk-ptn.com/images/product/6de51bb6b61afd78744eebba0e6e03f040664e9d.jpg'
                ],
                [
                    'name' => 'Lorem Ipsum',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                    'detail' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                    'image' => 'https://masuk-ptn.com/images/product/6de51bb6b61afd78744eebba0e6e03f040664e9d.jpg'
                ],
                [
                    'name' => 'Lorem Ipsum',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                    'detail' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                    'image' => 'https://masuk-ptn.com/images/product/6de51bb6b61afd78744eebba0e6e03f040664e9d.jpg'
                ],
                [
                    'name' => 'Lorem Ipsum',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                    'detail' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                    'image' => 'https://masuk-ptn.com/images/product/6de51bb6b61afd78744eebba0e6e03f040664e9d.jpg'
                ]
            ];
            @endphp

            @foreach($products as $product)
            <div class="product-item bg-white rounded-lg shadow-md">
                <div class="product-header" onclick="toggleDropdown(this)">
                    <h2 class="font-bold text-lg">{{ $product['name'] }}</h2>
                    <svg class="toggle-icon w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
                <div class="product-content">
                    @if(isset($product['image']))
                    <div class="mb-4 flex justify-center">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="max-w-full h-auto rounded-lg">
                    </div>
                    @endif
                    <p class="text-gray-700 mb-4">{{ $product['description'] }}</p>
                    <div class="flex justify-between items-center">
                        <a href="#" class="text-blue-500 hover:underline selengkapnya-btn">Selengkapnya</a>
                        <span class="text-sm text-gray-500">{{ date('Y') }}</span>
                    </div>
                    <div class="detail-content">
                        <h3 class="text-lg font-semibold mb-2">Detail Produk</h3>
                        <p class="text-gray-700">{{ $product['detail'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

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

        // Add event listener for "Selengkapnya" button
        document.querySelectorAll('.selengkapnya-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation(); // Prevent triggering parent dropdown
                const detailContent = this.closest('.product-content').querySelector('.detail-content');
                detailContent.classList.toggle('active');
            });
        });
    </script>
</body>
@include('Inovasi.riset_unj.produk_inovasi.footerrisetunj')
</html>