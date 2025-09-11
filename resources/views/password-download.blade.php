<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Unduhan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="w-full max-w-sm bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">Verifikasi Unduhan</h2>
        <p class="text-center text-gray-600 mb-6">
            Silakan masukkan kata sandi untuk melanjutkan.
        </p>

        <form method="POST" action="{{ route('riset.public.verify_and_download') }}">
            @csrf

            {{-- Hidden fields to carry over search parameters --}}
            <input type="hidden" name="search" value="{{ request('search') }}">
            <input type="hidden" name="fakultas" value="{{ request('fakultas') }}">
            <input type="hidden" name="tahun" value="{{ request('tahun') }}">

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                <input id="password" type="password" name="password" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                
                @if (session('error'))
                    <p class="mt-2 text-sm text-red-600">{{ session('error') }}</p>
                @endif
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                    Unduh File
                </button>
            </div>
        </form>
    </div>

</body>
</html>