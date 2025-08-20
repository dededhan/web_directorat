<footer class="text-white" style="background-color: #115E59;">
    {{-- Container dengan padding responsif --}}
    <div class="container mx-auto px-6 py-12">
        {{-- flex-col untuk mobile, md:flex-row untuk desktop --}}
        <div class="flex flex-col md:flex-row text-center md:text-left items-center md:items-start gap-10 md:gap-6">

            {{-- Bagian Logo: items-center di semua ukuran layar, text-center di mobile --}}
            <div class="w-full md:w-1/3 flex flex-col items-center md:items-start">
                <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" alt="UNJ Logo" class="h-24 w-24 mb-4" />
                <h3 class="font-bold text-lg">Direktorat Inovasi, Sistem Informasi, dan Pemeringkatan</h3>
                <p class="text-sm opacity-80">Universitas Negeri Jakarta</p>
                {{-- Social media icons: justify-center di mobile --}}
                <div class="flex space-x-4 mt-6 justify-center md:justify-start">
                    <a href="https://www.facebook.com/people/Direktorat-Isip-Unj/pfbid05sxgwir3WJi1yZirTaAdvbs3nQ2jypLKp349jsk6BmzxJqZaKvyYHPGUiVQr1Zu8l/" class="text-2xl hover:text-yellow-400 transition-colors"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/dit.isipunj/" target="_blank" class="text-2xl hover:text-yellow-400 transition-colors"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/channel/UCjQ4lIzs8Zm3zVD3wiL-KMw" target="_blank" class="text-2xl hover:text-yellow-400 transition-colors"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            {{-- Bagian Kontak Kami --}}
            <div class="w-full md:w-1/3">
                <h4 class="text-lg font-semibold mb-4">Kontak Kami</h4>
                <div class="space-y-3 text-sm">
                    {{-- justify-center di mobile, md:justify-start di desktop --}}
                    <p class="flex items-center justify-center md:justify-start">
                        <i class="fas fa-map-marker-alt w-5 mr-2"></i>
                        <span>Gedung M. Syafe'i Lt. 6, Kampus A UNJ</span>
                    </p>
                    <p class="flex items-center justify-center md:justify-start">
                         <i class="fas fa-envelope w-5 mr-2"></i>
                        <a href="mailto:dir.inovasi@unj.ac.id" class="hover:text-yellow-400">dir.inovasi@unj.ac.id</a>
                    </p>
                </div>
            </div>

            {{-- Bagian Lokasi --}}
            <div class="w-full md:w-1/3">
                <h4 class="text-lg font-semibold mb-4">Lokasi</h4>
                <div class="h-48 w-full rounded-lg overflow-hidden shadow-lg">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.529528749714!2d106.8767393153429!3d-6.193630662408765!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f4e8562f256d%3A0x80a5991365851483!2sState%20University%20of%20Jakarta!5e0!3m2!1sen!2sid!4v1622542848731!5m2!1sen!2sid"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
    
    <div class="border-t border-white/20 mt-8">
        <div class="container mx-auto px-6 py-4 text-center text-sm opacity-80">
            &copy; {{ date('Y') }} Universitas Negeri Jakarta. All rights reserved.
        </div>
    </div>
</footer>
