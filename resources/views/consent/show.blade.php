<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QS World University Rankings — Responden Consent | Universitas Negeri Jakarta</title>
    
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-teal-50/30 to-emerald-50/40 min-h-screen flex flex-col justify-between text-gray-800 antialiased selection:bg-teal-500 selection:text-white">

    {{-- Main Container --}}
    <main class="flex-1 flex items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="max-w-2xl w-full bg-white rounded-3xl shadow-xl shadow-teal-900/5 border border-gray-100 overflow-hidden">
            
            {{-- Header with UNJ Branding --}}
            <div class="bg-gradient-to-r from-teal-800 via-teal-700 to-emerald-700 px-6 py-8 text-white text-center relative overflow-hidden">
                <div class="absolute -right-8 -bottom-8 opacity-10 text-9xl">
                    <i class="fas fa-university"></i>
                </div>

                <div class="relative z-10 flex flex-col items-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" 
                         alt="Universitas Negeri Jakarta Logo" 
                         class="h-16 w-16 drop-shadow-md mb-3 object-contain">
                    
                    <h1 class="text-xl sm:text-2xl font-bold tracking-tight">
                        UNIVERSITAS NEGERI JAKARTA
                    </h1>
                    <p class="text-xs sm:text-sm text-teal-100 font-medium tracking-wide uppercase mt-1">
                        QS World University Rankings Campaign
                    </p>
                </div>
            </div>

            {{-- Body Content --}}
            <div class="p-6 sm:p-10 space-y-6">
                
                {{-- Greeting Card --}}
                <div class="bg-teal-50/60 border border-teal-100 rounded-2xl p-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-teal-600 text-white flex items-center justify-center font-bold text-sm flex-shrink-0">
                            {{ strtoupper(substr($fullname ?: 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-xs text-teal-700 font-semibold uppercase tracking-wider">Responden Terhormat</div>
                            <div class="text-base font-bold text-gray-900">{{ $fullname ?: 'Bapak / Ibu' }}</div>
                            <div class="text-xs text-gray-500">{{ $email }}</div>
                        </div>
                    </div>
                </div>

                {{-- Statement / Invitation Text --}}
                <div class="space-y-4 text-sm text-gray-600 leading-relaxed">
                    <p>
                        Salam hangat dari Universitas Negeri Jakarta (UNJ).
                    </p>
                    <p>
                        Dalam rangka partisipasi UNJ pada pemeringkatan internasional 
                        <strong class="text-gray-900">QS World University Rankings (QS WUR)</strong>, 
                        kami memohon kesediaan Bapak/Ibu untuk berpartisipasi sebagai responden evaluasi reputasi akademik / institusi kami.
                    </p>

                    <div class="border-l-4 border-teal-500 pl-4 py-1 bg-gray-50/80 rounded-r-lg">
                        <p class="text-xs text-gray-700 italic">
                            "Dengan menekan tombol <strong>Setuju / I Agree</strong> di bawah ini, Anda memberikan izin kepada Universitas Negeri Jakarta untuk mendaftarkan nama dan email Anda kepada pihak QS (Quacquarelli Symonds) sebagai responden reputasi."
                        </p>
                    </div>

                    <p class="text-xs text-gray-500">
                        Pihak QS kemungkinan akan mengirimkan satu survei singkat melalui email resmi QS. Anda tidak diwajibkan mengisi formulir apa pun pada halaman ini — persetujuan Anda langsung tercatat hanya dengan 1 klik.
                    </p>
                </div>

                {{-- English Translation Note --}}
                <div class="pt-4 border-t border-gray-100 text-xs text-gray-500 space-y-2">
                    <p class="font-semibold text-gray-700">English Notice:</p>
                    <p class="italic">
                        By clicking "I Agree", you consent to Universitas Negeri Jakarta submitting your contact details to QS Quacquarelli Symonds for participation in the QS Global Survey. No form submission is required.
                    </p>
                </div>

                {{-- Action Button (POST Form) --}}
                <form action="{{ route('consent.agree', ['token' => $token]) }}" method="POST" class="pt-2">
                    @csrf
                    <button type="submit" 
                            class="w-full py-4 px-6 bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white font-bold text-base rounded-2xl shadow-lg shadow-teal-600/30 hover:shadow-xl hover:shadow-teal-600/40 transition-all duration-200 transform hover:-translate-y-0.5 flex items-center justify-center gap-3">
                        <i class="fas fa-check-circle text-xl"></i>
                        <span>Saya Setuju / I Agree</span>
                    </button>
                </form>

                <p class="text-[11px] text-center text-gray-400">
                    Tautan ini bersifat pribadi dan aman. Persetujuan Anda dilindungi oleh kebijakan privasi UNJ.
                </p>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="py-4 text-center text-xs text-gray-400">
        &copy; {{ date('Y') }} Kantor Pemeringkatan & Reputasi Internasional — Universitas Negeri Jakarta.
    </footer>

</body>
</html>
