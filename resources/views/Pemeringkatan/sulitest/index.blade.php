<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SULITEST - Sustainability Literacy Test</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#059669',
                        secondary: '#10b981'
                    }
                }
            }
        }
    </script>
</head>
    @include('layout.navbarpemeringkatan')

<body class="bg-gray-50 min-h-screen">
    <header class="bg-primary text-white shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-2xl md:text-3xl font-bold text-center">SULITEST</h1>
            <p class="text-center text-green-100 mt-2">Sustainability Literacy Test</p>
        </div>
    </header>
    <main class="container mx-auto px-4 py-8 max-w-4xl">
        <section id="description" class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-4">Deskripsi Singkat SULITEST</h2>
            <div class="text-gray-700 leading-relaxed space-y-4">
                <p>Sustainability Literacy Test adalah alat pengukuran yang dirancang untuk menilai pemahaman individu atau kelompok tentang konsep-konsep dasar keberlanjutan (sustainability), termasuk isu-isu lingkungan, sosial, dan ekonomi yang berkaitan dengan pembangunan berkelanjutan.</p>
                <p>Dengan meningkatnya tantangan global seperti krisis iklim dan ketimpangan sosial, pemahaman tentang keberlanjutan menjadi kunci untuk menciptakan solusi yang inovatif dan bertanggung jawab.</p>
            </div>
        </section>

        <section id="identity" class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-6">IDENTITAS PESERTA</h2>
            <form class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Masukkan nama lengkap">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NIM</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Masukkan NIM">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">Pilih jenis kelamin</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Program Studi</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Masukkan program studi">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fakultas</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Masukkan fakultas">
                </div>
            </form>
        </section>

        <section id="instructions" class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-4">INSTRUKSI UJIAN</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>Bacalah setiap soal dengan cermat!</li>
                <li>Jawaban ditulis pada lembar jawaban yang disediakan.</li>
                <li>Waktu ujian: <strong class="text-red-600">100 menit</strong>.</li>
            </ul>
        </section>

        <div class="bg-red-100 border border-red-300 rounded-lg p-4 mb-8">
            <div class="flex items-center justify-between">
                <span class="text-red-800 font-medium">Waktu Tersisa:</span>
                <div id="timer" class="text-2xl font-bold text-red-600">100:00</div>
            </div>
        </div>

        <section id="questions" class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl md:text-2xl font-bold text-gray-800">Soal</h2>
                <span class="bg-primary text-white px-3 py-1 rounded-full text-sm">Halaman <span id="currentPage">1</span> dari 2</span>
            </div>
            
            <p class="text-gray-600 mb-6 font-medium">Jawablah pertanyaan di bawah ini dengan tepat!</p>

            <div id="questionSet1" class="question-set">
                <div class="mb-8 p-4 border border-gray-200 rounded-lg">
                    <h3 class="font-semibold text-gray-800 mb-4">1. Seorang mahasiswa di Jakarta berpenghasilan Rp 15.000 per hari. Jika garis kemiskinan ekstrem di Jakarta adalah Rp 19.000 per hari, pernyataan yang paling tepat menggambarkan kondisi mahasiswa tersebut adalah . . . .</h3>
                    <div class="space-y-3">
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q1" value="a" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">a. Mahasiswa tersebut berada di atas garis kemiskinan, sehingga tidak memerlukan bantuan.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q1" value="b" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">b. Mahasiswa tersebut berada dalam kategori rentan miskin, tetapi belum tergolong miskin ekstrem.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q1" value="c" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">c. Mahasiswa tersebut berada di bawah garis kemiskinan ekstrem dan membutuhkan intervensi segera.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q1" value="d" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">d. Mahasiswa tersebut harus mencari pekerjaan sampingan agar pendapatannya meningkat dan terhindar dari kemiskinan.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q1" value="e" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">e. Mahasiswa tersebut tidak dapat dikategorikan karena data pendapatan tidak mencerminkan pengeluaran.</span>
                        </label>
                    </div>
                </div>

                <div class="mb-8 p-4 border border-gray-200 rounded-lg">
                    <h3 class="font-semibold text-gray-800 mb-4">2. Pemerintah memberikan bantuan tunai kepada keluarga miskin ekstrem di Jakarta. Namun, bantuan tersebut seringkali tidak mencukupi untuk memenuhi kebutuhan dasar. Faktor yang paling relevan menyebabkan situasi ini adalah . . . .</h3>
                    <div class="space-y-3">
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q2" value="a" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">a. Kurangnya sosialisasi program bantuan sehingga banyak keluarga tidak tahu cara mengaksesnya.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q2" value="b" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">b. Nilai bantuan tidak disesuaikan dengan inflasi dan kenaikan harga kebutuhan pokok di Jakarta.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q2" value="c" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">c. Banyak keluarga miskin ekstrem yang tidak memiliki rekening bank untuk menerima bantuan.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q2" value="d" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">d. Bantuan tunai seringkali disalahgunakan untuk membeli barang-barang konsumtif.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q2" value="e" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">e. Keluarga miskin ekstrem tidak memiliki dokumen kependudukan yang lengkap.</span>
                        </label>
                    </div>
                </div>

                <div class="mb-8 p-4 border border-gray-200 rounded-lg">
                    <h3 class="font-semibold text-gray-800 mb-4">3. Indikator paling akurat yang bisa digunakan untuk mengukur keberhasilan program pengentasan kemiskinan ekstrem di lingkungan kampus adalah . . . .</h3>
                    <div class="space-y-3">
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q3" value="a" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">a. Jumlah mahasiswa yang menerima beasiswa.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q3" value="b" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">b. Jumlah mahasiswa yang memiliki pekerjaan sampingan.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q3" value="c" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">c. Persentase mahasiswa yang pendapatannya berada di atas garis kemiskinan ekstrem.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q3" value="d" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">d. Jumlah kegiatan sosial yang diadakan oleh kampus.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q3" value="e" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">e. Tingkat kepuasan mahasiswa terhadap fasilitas kampus.</span>
                        </label>
                    </div>
                </div>
            </div>

            <div id="questionSet2" class="question-set hidden">
                <div class="mb-8 p-4 border border-gray-200 rounded-lg">
                    <h3 class="font-semibold text-gray-800 mb-4">4. Perbedaan yang paling mendasar antara kemiskinan relatif dan kemiskinan ekstrem yang perlu dipahami dalam konteks kebijakan kampus adalah . . . .</h3>
                    <div class="space-y-3">
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q4" value="a" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">a. Kemiskinan relatif lebih mudah diukur daripada kemiskinan ekstrem.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q4" value="b" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">b. Kemiskinan ekstrem fokus pada pemenuhan kebutuhan dasar, sementara kemiskinan relatif melihat kesenjangan sosial.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q4" value="c" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">c. Kemiskinan ekstrem hanya terjadi di daerah pedesaan, sementara kemiskinan relatif ada di perkotaan.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q4" value="d" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">d. Kemiskinan relatif disebabkan oleh kurangnya pendidikan, sementara kemiskinan ekstrem karena kurangnya lapangan kerja.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q4" value="e" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">e. Tidak ada perbedaan signifikan antara kemiskinan relatif dan kemiskinan ekstrem.</span>
                        </label>
                    </div>
                </div>

                <div class="mb-8 p-4 border border-gray-200 rounded-lg">
                    <h3 class="font-semibold text-gray-800 mb-4">5. Program beasiswa Bidikmisi (KIP-Kuliah) merupakan salah satu bentuk perlindungan sosial bagi mahasiswa. Prinsip utama yang mendasari program ini sebagai bentuk perlindungan sosial adalah . . . .</h3>
                    <div class="space-y-3">
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q5" value="a" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">a. Memberikan bantuan kepada semua mahasiswa tanpa memandang kondisi ekonomi.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q5" value="b" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">b. Menjamin akses pendidikan tinggi bagi mahasiswa berprestasi dari keluarga kurang mampu.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q5" value="c" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">c. Memberikan pelatihan keterampilan agar mahasiswa siap kerja setelah lulus.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q5" value="d" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">d. Meningkatkan citra kampus sebagai lembaga pendidikan yang inklusif.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q5" value="e" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">e. Mengurangi angka putus kuliah akibat masalah finansial.</span>
                        </label>
                    </div>
                </div>

                <div class="mb-8 p-4 border border-gray-200 rounded-lg">
                    <h3 class="font-semibold text-gray-800 mb-4">6. Banyak mahasiswa kesulitan mengakses informasi mengenai program-program bantuan ekonomi yang tersedia di kampus. Faktor yang paling signifikan menyebabkan masalah ini adalah . . . .</h3>
                    <div class="space-y-3">
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q6" value="a" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">a. Mahasiswa kurang peduli terhadap informasi yang disediakan oleh kampus.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q6" value="b" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">b. Informasi hanya tersedia dalam bahasa Inggris.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q6" value="c" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">c. Kurangnya koordinasi antara unit-unit di kampus dalam menyebarkan informasi.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q6" value="d" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">d. Website kampus sulit diakses dan tidak user-friendly.</span>
                        </label>
                        <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="radio" name="q6" value="e" class="mt-1 text-primary focus:ring-primary">
                            <span class="text-gray-700">e. Mahasiswa malu untuk mencari informasi mengenai bantuan ekonomi.</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <button id="prevBtn" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    ← Sebelumnya
                </button>
                <div class="text-sm text-gray-600">
                    Soal <span id="questionRange">1-3</span> dari 6
                </div>
                <button id="nextBtn" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                    Selanjutnya →
                </button>
            </div>
        </section>

        <section id="submitSection" class="bg-white rounded-lg shadow-md p-6 mt-8 hidden">
            <div class="text-center">
                <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-4">Selesaikan Ujian</h2>
                <p class="text-gray-600 mb-6">Pastikan semua jawaban telah terisi sebelum mengirimkan ujian.</p>
                <button id="submitBtn" class="bg-red-600 text-white px-8 py-3 rounded-lg hover:bg-red-700 transition-colors text-lg font-semibold">
                    Kirim Ujian
                </button>
            </div>
        </section>
    </main>

        @include('layout.footer')


    <script>
        let timeLeft = 100 * 60; 
        const timerElement = document.getElementById('timer');
        
        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLeft <= 0) {
                alert('Waktu ujian telah habis!');
                return;
            }
            
            timeLeft--;
        }
        
        setInterval(updateTimer, 1000);

        let currentPage = 1;
        const totalPages = 2;
        const questionsPerPage = 3;
        
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const currentPageSpan = document.getElementById('currentPage');
        const questionRangeSpan = document.getElementById('questionRange');
        const submitSection = document.getElementById('submitSection');
        
        function showPage(page) {
            document.querySelectorAll('.question-set').forEach(set => {
                set.classList.add('hidden');
            });
            
            document.getElementById(`questionSet${page}`).classList.remove('hidden');
            currentPageSpan.textContent = page;
            
            const startQ = (page - 1) * questionsPerPage + 1;
            const endQ = Math.min(page * questionsPerPage, 6);
            questionRangeSpan.textContent = `${startQ}-${endQ}`;
            
            prevBtn.disabled = page === 1;
            
            if (page === totalPages) {
                nextBtn.textContent = 'Selesai';
                nextBtn.classList.remove('bg-primary', 'hover:bg-green-700');
                nextBtn.classList.add('bg-red-600', 'hover:bg-red-700');
            } else {
                nextBtn.textContent = 'Selanjutnya →';
                nextBtn.classList.remove('bg-red-600', 'hover:bg-red-700');
                nextBtn.classList.add('bg-primary', 'hover:bg-green-700');
            }
        }
        
        prevBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
                submitSection.classList.add('hidden');
            }
        });
        
        nextBtn.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
            } else {
                submitSection.classList.remove('hidden');
                document.getElementById('questions').scrollIntoView();
            }
        });
        
        document.getElementById('submitBtn').addEventListener('click', () => {
            if (confirm('Apakah Anda yakin ingin mengirimkan ujian? Pastikan semua jawaban telah terisi.')) {
                alert('Ujian telah berhasil dikirim!');
                console.log('Exam submitted');
            }
        });
        
        showPage(1);
    </script>
</body>
</html>