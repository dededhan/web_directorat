{{-- Footer khusus untuk halaman Sulitest --}}
<footer class="bg-gray-800 text-white">
    <div class="container mx-auto px-6 py-10">
        <div class="flex flex-col items-center text-center">
            <div class="flex items-center space-x-4 mb-4">
                <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" alt="UNJ Logo" class="h-14 w-auto" />
                <img src="{{ asset('images/logoditisip.png') }}" alt="DITISIP Logo" class="h-12 w-auto"/>
            </div>
            <p class="max-w-xl text-gray-400">
                Tes Literasi Keberlanjutan ini diselenggarakan oleh Subdirektorat Pemeringkatan dan Sistem Informasi Universitas Negeri Jakarta untuk meningkatkan kesadaran terhadap Tujuan Pembangunan Berkelanjutan (SDGs).
            </p>
            <div class="mt-6 border-t border-gray-700 w-full pt-6">
                <p class="text-sm text-gray-500">
                    © {{ date('Y') }} Universitas Negeri Jakarta. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</footer>
