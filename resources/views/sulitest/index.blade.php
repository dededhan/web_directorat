<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Peserta Sulitest</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    <div x-data="{ sidebarOpen: true }" class="flex h-screen bg-gray-100">
        @include('sulitest.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('sulitest.navbar')

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <div class="container mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

</body>
</html>
