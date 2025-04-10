<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0, user-scalable=yes" name="viewport"/>
    <title>Pemeringkatan Klaster Perguruan Tinggi - UNJ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <script src="{{ asset('home.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('mobile.css') }}">
    <script src="{{ asset('mobile.js') }}"></script>
    <style>
        /* Add custom styles for this page */
        .active-nav-item {
            color: #facc15 !important; /* yellow-400 in Tailwind */
            font-weight: bold;
        }
        
        /* Main content section styling */
        .main-content {
            min-height: 60vh;
            padding: 2rem 0;
        }
        
        /* Page header styling */
        .page-header {
            background-color: rgba(23, 99, 105, 0.9);
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        
        .breadcrumb {
            display: flex;
            flex-wrap: wrap;
            padding: 0.5rem 1rem;
            margin-bottom: 1rem;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.25rem;
        }
        
        .breadcrumb-item {
            color: #fff;
            padding: 0 0.5rem;
        }
        
        .breadcrumb-item:first-child {
            padding-left: 0;
        }
        
        .breadcrumb-separator {
            color: #facc15;
        }
    </style>
</head>
<body class="font-sans bg-gray-100">
    <!-- Include the navbar -->
    @include('Pemeringkatan.Ranking_Universitas.Navbar')
    
    <!-- Empty div for spacing due to fixed navbar on mobile -->
    <div class="md:hidden h-16"></div>
    
    <!-- Page Header with Breadcrumbs -->
    <div class="page-header">
        <div class="container mx-auto px-6">
            <h1 class="text-white text-3xl font-bold mb-4">Pemeringkatan Klaster Perguruan Tinggi</h1>
            
            <!-- Breadcrumbs -->
            <div class="breadcrumb">
                <span class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="hover:text-yellow-400">Beranda</a>
                </span>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-item">
                    <a href="#" class="hover:text-yellow-400">Ranking Universitas Negeri Jakarta</a>
                </span>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-item">
                    Pemeringkatan Klaster Perguruan Tinggi
                </span>
            </div>
        </div>
    </div>
    
    <!-- Main Content Section -->
    <main class="main-content container mx-auto px-6">
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="border-l-4 border-yellow-400 pl-4 mb-6">
                <h2 class="text-teal-700 text-2xl font-bold">Pemeringkatan Klaster Perguruan Tinggi</h2>
                <p class="text-gray-600">Informasi tentang pemeringkatan klaster perguruan tinggi</p>
            </div>
            
            <!-- Your content will go here -->
            <div class="content-placeholder">
                <!-- Replace this with your actual content -->
                <p class="text-gray-700 mb-4">
                    Halaman ini berisi informasi tentang pemeringkatan klaster perguruan tinggi.
                </p>
                
                <!-- Example content structure that you can modify -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 my-8">
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <!-- Content box 1 -->
                        <h3 class="text-teal-700 text-xl font-semibold mb-4">Placeholder Content 1</h3>
                        <p class="text-gray-600">
                            Isi dengan konten yang sesuai tentang pemeringkatan klaster perguruan tinggi.
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <!-- Content box 2 -->
                        <h3 class="text-teal-700 text-xl font-semibold mb-4">Placeholder Content 2</h3>
                        <p class="text-gray-600">
                            Isi dengan konten yang sesuai tentang pemeringkatan klaster perguruan tinggi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Include the footer -->
    @include('Pemeringkatan.Ranking_Universitas.Footer')
    
    <!-- Additional Scripts -->
    <script>
        // You can add page-specific JavaScript here
    </script>
</body>
</html>