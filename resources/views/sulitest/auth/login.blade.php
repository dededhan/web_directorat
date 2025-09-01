<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Peserta - SULITEST UNJ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-xl shadow-lg">
            <div class="flex flex-col items-center">
                <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" alt="Logo UNJ" class="h-20 mb-4">
                <h1 class="text-3xl font-bold text-gray-800">SULITEST</h1>
                <p class="text-gray-500">Silakan login untuk memulai tes.</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <ul class="mt-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('sulitest.login') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1 relative">
                         <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </span>
                        <input id="email" name="email" type="email" autocomplete="email" required
                               class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    </div>
                </div>
                <div>
                    <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1 relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-lock text-gray-400"></i>
                        </span>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    </div>
                </div>
                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors duration-300">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
