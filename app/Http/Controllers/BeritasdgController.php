<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class BeritasdgController extends Controller
{
    /**
     * Menampilkan halaman detail berita untuk SDG tertentu.
     *
     * @param int $sdg_id
     * @param string $slug
     * @return View
     */
    // Method show() yang sudah diperbaiki
    public function show(int $sdg_id, string $slug): View
    {
        $sdg = $this->getSdgData($sdg_id);
        $all_berita = $this->getAllBeritaData();

        // Cari berita yang sedang dibuka berdasarkan slug-nya
        $berita = $all_berita[$slug] ?? null;

        // Validasi: Jika SDG atau Berita tidak ditemukan, atau berita tidak cocok dengan SDG-nya, tampilkan halaman 404.
        if (!$sdg || !$berita || $berita['sdg_id'] !== $sdg_id) {
            abort(404, 'Berita tidak ditemukan.');
        }


        $related_berita = [];
        foreach ($all_berita as $related_slug => $related_item) {
            if ($related_item['sdg_id'] === $sdg_id && $related_slug !== $slug) {
                // Tambahkan slug ke dalam array agar bisa digunakan di view untuk membuat URL
                $related_item['slug'] = $related_slug;
                $related_berita[] = $related_item;
            }
        }

        // Mengirim semua data yang dibutuhkan ke view
        return view('subdirektorat-inovasi.sdg.berita.detail', [
            'sdg' => $sdg,
            'berita' => $berita,
            'sdg_id' => $sdg_id,
            // Kirim 4 berita terkait pertama ke view
            'related_berita' => array_slice($related_berita, 0, 4)
        ]);
    }

    /**
     * Simulasi pengambilan data SDG dari database.
     *
     * @param int $id
     * @return array|null
     */
    private function getSdgData(int $id): ?array
    {
        $all_sdgs = [
            1 => ['title' => 'Tanpa Kemiskinan', 'icon' => 'https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-01.jpg', 'color' => '#e5243b'],
            2 => ['title' => 'Tanpa Kelaparan', 'icon' => 'https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-02.jpg', 'color' => '#dda63a'],
            3 => ['title' => 'Kehidupan Sehat dan Sejahtera', 'icon' => 'https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-03.jpg', 'color' => '#4c9f38'],
            4 => ['title' => 'Pendidikan Berkualitas', 'icon' => 'https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-04.jpg', 'color' => '#C5192D'],
            5 => ['title' => 'Kesetaraan Gender', 'icon' => 'https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-05.jpg', 'color' => '#FF3A21'],
            6 => ['title' => 'Air Bersih dan Sanitasi Layak', 'icon' => 'https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-06.jpg', 'color' => '#26BDE2'],
            7 => ['title' => 'Energi Bersih dan Terjangkau', 'icon' => 'https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-07.jpg', 'color' => '#FCC30B'],
            8 => ['title' => 'Pekerjaan Layak dan Pertumbuhan Ekonomi', 'icon' => 'https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-08.jpg', 'color' => '#A21942'],
            9 => ['title' => 'Industri, Inovasi, dan Infrastruktur', 'icon' => 'https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-09.jpg', 'color' => '#FD6925'],
            10 => ['title' => 'Berkurangnya Kesenjangan', 'icon' => 'https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-10.jpg', 'color' => '#DD1367'],
            11 => ['title' => 'Kota dan Permukiman Berkelanjutan', 'icon' => 'https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-11.jpg', 'color' => '#FD9D24'],
            12 => ['title' => 'Konsumsi dan Produksi Bertanggung Jawab', 'icon' => 'https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-12.jpg', 'color' => '#BF8B2E'],
            13 => ['title' => 'Penanganan Perubahan Iklim', 'icon' => 'https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-13.jpg', 'color' => '#3F7E44'],
            14 => ['title' => 'Ekosistem Lautan', 'icon' => 'https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-14.jpg', 'color' => '#0A97D9'],
            15 => ['title' => 'Ekosistem Daratan', 'icon' => 'https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-15.jpg', 'color' => '#56C02B'],
            16 => ['title' => 'Perdamaian, Keadilan, dan Kelembagaan Tangguh', 'icon' => 'https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-16.jpg', 'color' => '#00689D'],
            17 => ['title' => 'Kemitraan untuk Mencapai Tujuan', 'icon' => 'https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-17.jpg', 'color' => '#19486A'],
        ];

        return $all_sdgs[$id] ?? null;
    }

    /**
     * Simulasi pengambilan data berita dari database.
     *
     * @param string $slug
     * @param int $sdg_id
     * @return array|null
     */
    private function getAllBeritaData(): array
    {
        return [
            'unj-gelar-pelatihan-kewirausahaan-untuk-masyarakat-rentan' => [
                'sdg_id' => 1,
                'title' => 'UNJ Gelar Pelatihan Kewirausahaan untuk Masyarakat Rentan',
                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Tim Humas UNJ',
                'date' => '25 Juni 2025',
                'content' => '<p>Dalam rangka mendukung pencapaian Tujuan Pembangunan Berkelanjutan (SDG) 1: Tanpa Kemiskinan, Universitas Negeri Jakarta (UNJ) melalui program pengabdian kepada masyarakat menyelenggarakan pelatihan kewirausahaan digital. Program ini dirancang khusus untuk membekali masyarakat dari kelompok rentan dengan keterampilan praktis yang relevan dengan ekonomi digital saat ini.</p><p>Acara yang berlangsung selama tiga hari ini diikuti oleh lebih dari 200 peserta dari berbagai komunitas di sekitar Jakarta. Materi yang diberikan mencakup dasar-dasar pemasaran digital, manajemen media sosial untuk bisnis, hingga strategi branding produk lokal. Dengan adanya pelatihan ini, UNJ berharap dapat menciptakan wirausahawan baru yang mandiri secara ekonomi dan mampu berkontribusi pada pengurangan angka kemiskinan di lingkungan mereka.</p><p>"Kami percaya bahwa pendidikan dan pemberdayaan adalah kunci untuk memutus mata rantai kemiskinan. UNJ berkomitmen untuk terus hadir di tengah masyarakat, tidak hanya sebagai menara gading, tetapi sebagai motor penggerak perubahan sosial," ujar Rektor UNJ dalam sambutannya.</p>'
            ],
            'studi-fis-unj-krisis-iklim-dan-kemiskinan-petani' => [
                'sdg_id' => 1,
                'title' => 'Studi FIS UNJ: Krisis Iklim & Kemiskinan Petani',
                'image' => 'https://images.unsplash.com/photo-1560493676-04071c5f467b?q=80&w=1974&auto=format&fit=crop',
                'author' => 'Pusat Riset FIS',
                'date' => '18 Juni 2025',
                'content' => '<p>Penelitian terbaru dari Fakultas Ilmu Sosial (FIS) Universitas Negeri Jakarta menyoroti hubungan erat antara krisis iklim dan peningkatan angka kemiskinan di kalangan petani di pesisir Pantura. Studi ini menemukan bahwa perubahan pola cuaca yang tidak menentu telah menyebabkan gagal panen dan penurunan produktivitas pertanian secara signifikan, yang secara langsung berdampak pada pendapatan rumah tangga petani.</p><p>Riset ini merekomendasikan adanya intervensi kebijakan yang bersifat adaptif, termasuk pengembangan varietas tanaman yang tahan terhadap perubahan iklim dan penguatan skema asuransi pertanian. "Solusi parsial tidak akan cukup. Diperlukan pendekatan holistik yang mengintegrasikan adaptasi iklim ke dalam strategi pengentasan kemiskinan nasional," ungkap ketua tim peneliti.</p>'
            ],
            'kolaborasi-program-perlindungan-sosial' => [
                'sdg_id' => 1,
                'title' => 'Kolaborasi Program Perlindungan Sosial',
                'image' => 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Pusat Studi SDGs UNJ',
                'date' => '12 Juni 2025',
                'content' => '<p>Pusat Studi SDGs Universitas Negeri Jakarta (UNJ) bekerja sama dengan pemerintah daerah untuk merancang skema jaminan sosial yang lebih efektif. Kolaborasi ini bertujuan untuk memastikan bantuan sosial dapat tepat sasaran dan memberikan dampak signifikan dalam upaya pengentasan kemiskinan, sejalan dengan komitmen UNJ dalam mendukung SDG 1.</p><p>Dalam kerja sama ini, para peneliti dan ahli dari UNJ akan melakukan kajian mendalam terhadap data kemiskinan dan efektivitas program yang ada. Masukan berbasis riset ini akan digunakan untuk menyusun rekomendasi kebijakan guna menyempurnakan mekanisme penargetan dan distribusi bantuan. Diharapkan, sinergi antara dunia akademis dan pemerintah ini dapat menciptakan sebuah model jaminan sosial yang lebih adil, transparan, dan berkelanjutan untuk melindungi kelompok miskin serta rentan.</p>'
            ],
            'unj-kembangkan-model-pertanian-urban' => [
                'sdg_id' => 2,
                'title' => 'UNJ Kembangkan Model Pertanian Urban untuk Ketahanan Pangan Kota',
                'image' => 'https://images.unsplash.com/photo-1599599810694-b5b37304c272?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Tim Fakultas Teknik & MIPA',
                'date' => '28 Juni 2025',
                'content' => '<p>Menjawab tantangan ketahanan pangan di kota besar, Universitas Negeri Jakarta (UNJ) meluncurkan inisiatif pertanian urban. Melalui program pengabdian kepada masyarakat, tim gabungan dari Fakultas Teknik dan Fakultas MIPA mengimplementasikan sistem hidroponik dan akuaponik di lahan terbatas di beberapa titik di perkotaan Jakarta.</p><p>Program ini tidak hanya bertujuan untuk meningkatkan ketersediaan pangan segar dan bergizi bagi warga sekitar, tetapi juga berfungsi sebagai laboratorium hidup dan pusat edukasi. Warga diajarkan cara membangun, merawat, dan memanen dari sistem pertanian modern ini, membuka peluang untuk kemandirian pangan di tingkat komunitas. Inisiatif ini merupakan kontribusi nyata UNJ dalam mendukung SDG 2: Tanpa Kelaparan, dengan fokus pada inovasi sistem produksi pangan berkelanjutan.</p>'
            ],
            'program-gizi-seimbang-anak-usia-dini' => [
                'sdg_id' => 2,
                'title' => 'Program Gizi Seimbang untuk Anak Usia Dini',
                'image' => 'https://images.unsplash.com/photo-1627822459390-34907a5144a2?q=80&w=1974&auto=format&fit=crop',
                'author' => 'Mahasiswa Peduli Gizi UNJ',
                'date' => '22 Juni 2025',
                'content' => '<p>Sebagai bagian dari upaya pencegahan stunting, sekelompok mahasiswa UNJ yang tergabung dalam komunitas "Mahasiswa Peduli Gizi" menyelenggarakan program penyuluhan dan pembagian makanan bergizi. Sasaran program ini adalah anak-anak di Pendidikan Anak Usia Dini (PAUD) yang berlokasi di sekitar kampus UNJ.</p><p>Kegiatan ini mencakup edukasi interaktif bagi orang tua mengenai pentingnya gizi seimbang serta demo masak makanan sehat dengan bahan lokal yang terjangkau. Program ini diharapkan dapat meningkatkan kesadaran gizi masyarakat dan secara langsung berkontribusi pada perbaikan nutrisi anak-anak, sejalan dengan target SDG 2 untuk mengakhiri segala bentuk malnutrisi.</p>'
            ],
            'kolaborasi-rantai-pasok-petani-lokal' => [
                'sdg_id' => 2,
                'title' => 'Kolaborasi Rantai Pasok dengan Petani Lokal',
                'image' => 'https://images.unsplash.com/photo-1579202773197-a72d7f8d601a?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Fakultas Ekonomi UNJ',
                'date' => '15 Juni 2025',
                'content' => '<p>Fakultas Ekonomi Universitas Negeri Jakarta (FE UNJ) mengambil peran strategis dalam memperpendek rantai pasok pangan. Melalui sebuah program kemitraan, FE UNJ memfasilitasi kerja sama langsung antara kelompok petani di daerah penyangga Jakarta dengan koperasi mahasiswa dan kantin di lingkungan kampus.</p><p>Kemitraan ini bertujuan untuk memastikan petani mendapatkan harga jual yang lebih adil sekaligus menyediakan produk segar berkualitas bagi civitas academica UNJ dengan harga yang lebih terjangkau. Program ini tidak hanya mendukung peningkatan pendapatan produsen makanan skala kecil sesuai target SDG 2.3, tetapi juga mempromosikan model bisnis yang berkelanjutan dan berkeadilan.</p>'
            ],
            // === DATA BERITA SDG 3 ===
            'fio-unj-gelar-gerak-sehat-jakarta' => [
                'sdg_id' => 3,
                'title' => 'FIO UNJ Gelar "Gerak Sehat Jakarta" untuk Promosikan Gaya Hidup Aktif',
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Humas FIO UNJ',
                'date' => '5 Juli 2025',
                'content' => '<p>Fakultas Ilmu Olahraga (FIO) Universitas Negeri Jakarta (UNJ) sukses menyelenggarakan acara "Gerak Sehat Jakarta" yang bertujuan untuk mempromosikan gaya hidup aktif di kalangan masyarakat. Kegiatan ini meliputi senam bersama, jalan sehat, dan seminar tentang pentingnya olahraga untuk mencegah penyakit tidak menular. Acara ini merupakan wujud nyata kontribusi UNJ dalam mendukung SDG 3, yaitu memastikan kehidupan yang sehat dan sejahtera bagi semua usia.</p>'
            ],
            'riset-unj-polusi-udara-dan-penyakit-pernapasan' => [
                'sdg_id' => 3,
                'title' => 'Riset UNJ: Hubungan Polusi Udara dan Penyakit Pernapasan',
                'image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Tim Riset FMIPA',
                'date' => '2 Juli 2025',
                'content' => '<p>Tim peneliti dari Fakultas MIPA UNJ mempublikasikan hasil studi yang menunjukkan korelasi kuat antara tingkat polusi udara di Jakarta dengan peningkatan kasus Infeksi Saluran Pernapasan Akut (ISPA). Riset ini memberikan data penting bagi para pemangku kebijakan untuk merumuskan strategi pengendalian polusi udara yang lebih efektif guna melindungi kesehatan warga.</p>'
            ],
            'unj-luncurkan-layanan-konseling-psikologis-gratis' => [
                'sdg_id' => 3,
                'title' => 'UNJ Luncurkan Layanan Konseling Psikologis Gratis',
                'image' => 'https://plus.unsplash.com/premium_photo-1661281397737-926d71b9f712?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Fakultas Pendidikan Psikologi',
                'date' => '1 Juli 2025',
                'content' => '<p>Mendukung kesehatan mental sebagai bagian integral dari kesejahteraan, Fakultas Pendidikan Psikologi UNJ meresmikan pusat layanan konseling. Layanan ini dapat diakses secara gratis oleh mahasiswa UNJ dan masyarakat umum, menyediakan dukungan profesional untuk mengatasi berbagai tantangan psikologis.</p>'
            ],

            // === DATA BERITA SDG 4 ===
            'unj-kirim-mahasiswa-kampus-mengajar-ke-daerah-3t' => [
                'sdg_id' => 4,
                'title' => 'UNJ Kirim Ratusan Mahasiswa Program Kampus Mengajar ke Daerah 3T',
                'image' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=2070&auto=format&fit=crop',
                'author' => 'LPPM UNJ',
                'date' => '10 Juli 2025',
                'content' => '<p>Sebagai wujud nyata komitmen pada tridarma perguruan tinggi dan dukungan terhadap SDG 4, Universitas Negeri Jakarta (UNJ) kembali mengirimkan ratusan mahasiswa terbaiknya untuk berpartisipasi dalam program Kampus Mengajar. Para mahasiswa ini akan ditugaskan di berbagai sekolah di daerah terdepan, terluar, dan tertinggal (3T) untuk membantu meningkatkan kualitas literasi dan numerasi siswa.</p>'
            ],
            'fip-unj-gelar-workshop-kurikulum-adaptif' => [
                'sdg_id' => 4,
                'title' => 'FIP UNJ Gelar Workshop Pengembangan Kurikulum Adaptif',
                'image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=1932&auto=format&fit=crop',
                'author' => 'Humas FIP UNJ',
                'date' => '8 Juli 2025',
                'content' => '<p>Fakultas Ilmu Pendidikan (FIP) UNJ menyelenggarakan workshop bagi para guru dari berbagai sekolah mitra. Pelatihan ini berfokus pada strategi pengembangan kurikulum yang adaptif, yang mampu menjawab tantangan abad ke-21 serta mengakomodasi kebutuhan siswa yang beragam, sejalan dengan prinsip pendidikan berkualitas untuk semua.</p>'
            ],
            'unj-fasilitasi-beasiswa-mahasiswa-disabilitas' => [
                'sdg_id' => 4,
                'title' => 'UNJ Fasilitasi Beasiswa Bagi Mahasiswa Disabilitas',
                'image' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Bagian Kemahasiswaan UNJ',
                'date' => '7 Juli 2025',
                'content' => '<p>Dalam upaya menciptakan lingkungan belajar yang inklusif, UNJ terus berkomitmen untuk memfasilitasi mahasiswa dengan disabilitas. Salah satu wujudnya adalah penyediaan berbagai skema beasiswa dan fasilitas pendukung untuk memastikan mereka mendapatkan akses yang setara terhadap pendidikan berkualitas.</p>'
            ],

            // === DATA BERITA SDG 5 ===
            'pusat-studi-gender-unj-luncurkan-satgas-ppks' => [
                'sdg_id' => 5,
                'title' => 'Pusat Studi Gender UNJ Luncurkan Satgas PPKS untuk Ciptakan Kampus Aman',
                'image' => 'https://images.unsplash.com/photo-1593113598332-cd288d649433?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Pusat Studi Gender UNJ',
                'date' => '15 Juli 2025',
                'content' => '<p>Pusat Studi Gender Universitas Negeri Jakarta (UNJ) meresmikan Satuan Tugas Pencegahan dan Penanganan Kekerasan Seksual (Satgas PPKS). Pembentukan satgas ini adalah langkah krusial dalam upaya menciptakan lingkungan kampus yang aman, adil, dan bebas dari segala bentuk kekerasan berbasis gender, sejalan dengan tujuan SDG 5 untuk mencapai kesetaraan gender.</p>'
            ],
            'program-women-in-leadership-bekali-mahasiswi-unj' => [
                'sdg_id' => 5,
                'title' => 'Program "Women in Leadership" Bekali Mahasiswi UNJ',
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop',
                'author' => 'BEM UNJ',
                'date' => '14 Juli 2025',
                'content' => '<p>Untuk mendorong partisipasi perempuan dalam kepemimpinan, UNJ menggelar program "Women in Leadership". Program ini terdiri dari serangkaian workshop dan sesi mentoring yang dirancang untuk meningkatkan kapasitas kepemimpinan mahasiswi UNJ, mempersiapkan mereka untuk mengambil peran strategis di berbagai bidang organisasi baik di dalam maupun di luar kampus.</p>'
            ],
            'fis-unj-teliti-kesenjangan-upah-berbasis-gender' => [
                'sdg_id' => 5,
                'title' => 'FIS UNJ Teliti Kesenjangan Upah Berbasis Gender di Sektor Informal',
                'image' => 'https://images.unsplash.com/photo-1556761175-b413da4baf72?q=80&w=1974&auto=format&fit=crop',
                'author' => 'Tim Riset FIS',
                'date' => '12 Juli 2025',
                'content' => '<p>Riset terbaru dari Fakultas Ilmu Sosial (FIS) UNJ menyoroti tantangan signifikan yang dihadapi oleh perempuan pekerja di sektor informal Jakarta, terutama terkait kesenjangan upah berbasis gender. Penelitian ini memberikan data empiris yang penting untuk advokasi kebijakan yang lebih adil dan setara bagi pekerja perempuan.</p>'
            ],

            // === DATA BERITA SDG 6 ===
            'ft-unj-kembangkan-teknologi-filtrasi-air-sederhana' => [
                'sdg_id' => 6,
                'title' => 'FT UNJ Kembangkan Teknologi Filtrasi Air Sederhana untuk Komunitas Pesisir',
                'image' => 'https://images.unsplash.com/photo-1576053139221-88a2a95a8991?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Tim Pengabdian FT UNJ',
                'date' => '20 Juli 2025',
                'content' => '<p>Tim peneliti dan mahasiswa dari Fakultas Teknik (FT) UNJ berhasil merancang dan mengimplementasikan sistem penyaringan air sederhana. Teknologi ini menggunakan bahan-bahan lokal yang murah dan efektif untuk menyediakan akses air bersih bagi masyarakat di kawasan pesisir Marunda, Jakarta Utara, yang selama ini kesulitan mendapatkan air layak konsumsi.</p>'
            ],
            'kampanye-tangan-bersih-generasi-sehat' => [
                'sdg_id' => 6,
                'title' => 'Kampanye "Tangan Bersih, Generasi Sehat" oleh Mahasiswa UNJ',
                'image' => 'https://images.unsplash.com/photo-1628186981116-281896dd6297?q=80&w=1964&auto=format&fit=crop',
                'author' => 'Mahasiswa KKN UNJ',
                'date' => '19 Juli 2025',
                'content' => '<p>Mahasiswa Kuliah Kerja Nyata (KKN) UNJ menggelar kampanye edukasi tentang pentingnya Cuci Tangan Pakai Sabun (CTPS). Kampanye yang menyasar puluhan sekolah dasar di sekitar Depok ini bertujuan untuk menanamkan perilaku hidup bersih dan sehat sejak dini, sebagai upaya mendukung pencapaian SDG 6 terkait sanitasi dan kebersihan.</p>'
            ],
            'riset-fmipa-pemetaan-polusi-mikroplastik-ciliwung' => [
                'sdg_id' => 6,
                'title' => 'Riset FMIPA UNJ: Pemetaan Sumber Polusi Mikroplastik di Sungai Ciliwung',
                'image' => 'https://images.unsplash.com/photo-1543086494-3cb439543328?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Pusat Riset Lingkungan FMIPA',
                'date' => '18 Juli 2025',
                'content' => '<p>Sebuah penelitian jangka panjang yang dilakukan oleh FMIPA UNJ berhasil memetakan sumber-sumber utama polusi mikroplastik di sepanjang aliran Sungai Ciliwung. Hasil penelitian ini telah diserahkan kepada pemerintah sebagai data krusial untuk menyusun kebijakan strategis dalam pengendalian polusi plastik dan peningkatan kualitas air sungai.</p>'
            ],

            // === DATA BERITA SDG 7 ===
            'unj-jadi-percontohan-kampus-hijau-plts' => [
                'sdg_id' => 7,
                'title' => 'UNJ Jadi Percontohan Kampus Hijau dengan Pemasangan Panel Surya Skala Besar',
                'image' => 'https://images.unsplash.com/photo-1508554792037-77f6544b6248?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Humas UNJ',
                'date' => '25 Juli 2025',
                'content' => '<p>Bekerja sama dengan BUMN di sektor energi, Universitas Negeri Jakarta (UNJ) mengukuhkan komitmennya pada energi bersih dengan menginstalasi sistem Pembangkit Listrik Tenaga Surya (PLTS) Atap di beberapa gedung utama kampus. Proyek ini tidak hanya bertujuan mengurangi jejak karbon dan biaya listrik, tetapi juga berfungsi sebagai laboratorium hidup bagi mahasiswa untuk mempelajari teknologi energi terbarukan.</p>'
            ],
            'riset-ft-unj-pemanfaatan-limbah-organik-pasar' => [
                'sdg_id' => 7,
                'title' => 'Riset FT UNJ: Pemanfaatan Limbah Organik Pasar Menjadi Biogas',
                'image' => 'https://images.unsplash.com/photo-1621237042598-7517a945037d?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Tim Riset Energi Terbarukan FT',
                'date' => '24 Juli 2025',
                'content' => '<p>Tim peneliti dari Fakultas Teknik UNJ berhasil mengembangkan reaktor digester biogas skala kecil. Inovasi ini dirancang untuk mengolah sampah organik dari pasar-pasar tradisional menjadi biogas yang dapat dimanfaatkan sebagai energi untuk memasak oleh para pedagang, menciptakan solusi energi bersih dari masalah sampah.</p>'
            ],
            'unj-gelar-lomba-inovasi-efisiensi-energi' => [
                'sdg_id' => 7,
                'title' => 'UNJ Gelar Lomba Inovasi Efisiensi Energi untuk Mahasiswa',
                'image' => 'https://images.unsplash.com/photo-1542332213-9b5a5a3236a1?q=80&w=1920&auto=format&fit=crop',
                'author' => 'BEM FT UNJ',
                'date' => '22 Juli 2025',
                'content' => '<p>Dalam rangka mendorong budaya hemat energi, UNJ menyelenggarakan kompetisi inovasi tahunan. Lomba ini menantang kreativitas mahasiswa untuk menciptakan alat atau sistem yang dapat meningkatkan efisiensi penggunaan energi di tingkat rumah tangga, mendukung target SDG 7 untuk menggandakan tingkat efisiensi energi global.</p>'
            ],

            // === DATA BERITA SDG 8 ===
            'feb-unj-luncurkan-inkubator-bisnis-unjpreneur' => [
                'sdg_id' => 8,
                'title' => 'FEB UNJ Luncurkan Inkubator Bisnis "UNJPreneur" untuk Cetak Wirausahawan Muda',
                'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Humas FEB UNJ',
                'date' => '30 Juli 2025',
                'content' => '<p>Fakultas Ekonomi dan Bisnis (FEB) UNJ meresmikan "UNJPreneur", sebuah pusat inkubasi bisnis modern. Fasilitas ini menyediakan pendampingan intensif, akses ke jaringan permodalan, dan ruang kerja kolaboratif bagi mahasiswa dan alumni yang ingin merintis usaha. Program ini bertujuan untuk meningkatkan jumlah wirausahawan baru yang inovatif dan menciptakan lapangan kerja layak, sesuai dengan semangat SDG 8.</p>'
            ],
            'unj-adakan-pelatihan-pemasaran-digital-umkm' => [
                'sdg_id' => 8,
                'title' => 'UNJ Adakan Pelatihan Pemasaran Digital untuk UMKM Binaan',
                'image' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=2070&auto=format&fit=crop',
                'author' => 'LPPM UNJ',
                'date' => '29 Juli 2025',
                'content' => '<p>Melalui program pengabdian masyarakat, UNJ memberikan pelatihan pemasaran digital gratis kepada puluhan Usaha Mikro, Kecil, dan Menengah (UMKM) di sekitar kampus. Pelatihan ini membekali para pelaku usaha dengan keterampilan untuk go-digital, meningkatkan daya saing, dan pada akhirnya mendukung pertumbuhan ekonomi lokal.</p>'
            ],
            'pusat-karir-unj-sukses-gelar-job-fair-tahunan' => [
                'sdg_id' => 8,
                'title' => 'Pusat Karir UNJ Sukses Gelar Job Fair Tahunan',
                'image' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Pusat Karir UNJ',
                'date' => '28 Juli 2025',
                'content' => '<p>Untuk menjembatani lulusan dengan dunia industri, Pusat Karir UNJ kembali menggelar Job Fair tahunan. Acara ini berhasil menarik puluhan perusahaan ternama dan membuka ribuan lowongan pekerjaan, memberikan kontribusi langsung dalam mengurangi angka pengangguran usia muda dan memastikan akses ke pekerjaan yang layak.</p>'
            ],

            // === DATA BERITA SDG 9 ===
            'tim-robotika-unj-raih-juara-krsti' => [
                'sdg_id' => 9,
                'title' => 'Tim Robotika UNJ Raih Juara di Kontes Robot Terbang Indonesia',
                'image' => 'https://images.unsplash.com/photo-1518314916381-77a37c2a49ae?q=80&w=2071&auto=format&fit=crop',
                'author' => 'Tim Robotika UNJ',
                'date' => '5 Agustus 2025',
                'content' => '<p>Mahasiswa dari Fakultas Teknik UNJ kembali menorehkan prestasi gemilang di kancah nasional. Tim Robotika UNJ berhasil memenangkan kategori inovasi terbaik dalam Kontes Robot Terbang Indonesia (KRTI) dengan mengembangkan drone yang dilengkapi sensor untuk pemantauan lahan pertanian. Inovasi ini menunjukkan kapasitas UNJ dalam teknologi terapan yang mendukung industrialisasi di sektor agrikultur, sejalan dengan SDG 9.</p>'
            ],
            'startup-digital-binaan-unj-dapatkan-pendanaan' => [
                'sdg_id' => 9,
                'title' => 'Startup Digital Binaan UNJ Dapatkan Pendanaan Awal',
                'image' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Inkubator Bisnis UNJ',
                'date' => '4 Agustus 2025',
                'content' => '<p>Sebuah startup edutech yang berfokus pada platform pembelajaran adaptif, yang didirikan oleh alumni UNJ dan dibina oleh inkubator bisnis kampus, berhasil mendapatkan pendanaan tahap awal (seed funding) dari salah satu perusahaan modal ventura terkemuka. Ini membuktikan ekosistem inovasi di UNJ berjalan dengan baik.</p>'
            ],
            'kolaborasi-riset-unj-dan-industri-otomotif' => [
                'sdg_id' => 9,
                'title' => 'Kolaborasi Riset UNJ dan Industri Otomotif',
                'image' => 'https://images.unsplash.com/photo-1581092921449-41b93f2c3516?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Humas FT UNJ',
                'date' => '2 Agustus 2025',
                'content' => '<p>Fakultas Teknik UNJ resmi menjalin kerja sama riset dan pengembangan dengan salah satu perusahaan otomotif besar di Indonesia. Fokus kolaborasi ini adalah untuk mengembangkan material komposit ringan dari bahan lokal sebagai alternatif bodi kendaraan, mendorong inovasi dan penggunaan sumber daya yang efisien di industri manufaktur.</p>'
            ],

            // === DATA BERITA SDG 10 ===
            'unj-perkuat-komitmen-pendidikan-inklusif-pld' => [
                'sdg_id' => 10,
                'title' => 'UNJ Perkuat Komitmen Pendidikan Inklusif Melalui Pusat Layanan Disabilitas',
                'image' => 'https://images.unsplash.com/photo-1605648916319-487652792d29?q=80&w=2070&auto=format&fit=crop',
                'author' => 'PLD UNJ',
                'date' => '10 Agustus 2025',
                'content' => '<p>Untuk mengurangi hambatan dan kesenjangan akses pendidikan tinggi, Universitas Negeri Jakarta (UNJ) meresmikan Pusat Layanan Disabilitas (PLD). Pusat ini didedikasikan untuk menyediakan pendampingan akademik, fasilitas yang aksesibel, serta teknologi asistif bagi mahasiswa berkebutuhan khusus, memastikan mereka memiliki kesempatan yang sama untuk sukses.</p>'
            ],
            'riset-fis-unj-kesenjangan-akses-digital-pelajar' => [
                'sdg_id' => 10,
                'title' => 'Riset FIS UNJ: Kesenjangan Akses Digital di Kalangan Pelajar Jakarta',
                'image' => 'https://images.unsplash.com/photo-1543269865-cbf427effbad?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Tim Riset FIS',
                'date' => '9 Agustus 2025',
                'content' => '<p>Sebuah studi komprehensif dari Fakultas Ilmu Sosial (FIS) UNJ berhasil memetakan adanya disparitas yang signifikan dalam akses internet dan kepemilikan perangkat digital di kalangan pelajar di Jakarta. Riset ini menyoroti bagaimana kesenjangan digital ini berdampak langsung pada ketimpangan hasil pembelajaran dan merekomendasikan intervensi kebijakan yang tepat sasaran.</p>'
            ],
            'unj-tingkatkan-kuota-beasiswa-afirmasi' => [
                'sdg_id' => 10,
                'title' => 'Perluas Jangkauan, UNJ Tingkatkan Kuota Beasiswa Afirmasi',
                'image' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=1974&auto=format&fit=crop',
                'author' => 'Bagian Kemahasiswaan UNJ',
                'date' => '8 Agustus 2025',
                'content' => '<p>Dalam upaya mengurangi kesenjangan kesempatan, UNJ secara resmi mengumumkan penambahan alokasi beasiswa dan kuota pada jalur penerimaan khusus (afirmasi). Kebijakan ini ditujukan bagi calon mahasiswa berprestasi yang berasal dari daerah 3T (terdepan, terluar, tertinggal) dan keluarga prasejahtera, memberikan mereka jalan untuk mengakses pendidikan tinggi berkualitas.</p>'
            ],
            
            // === DATA BERITA SDG 11 ===
            'fis-unj-lakukan-pemetaan-partisipatif' => [
                'sdg_id' => 11,
                'title' => 'FIS UNJ Lakukan Pemetaan Partisipatif untuk Revitalisasi Ruang Publik di Jakarta',
                'image' => 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Tim FIS UNJ',
                'date' => '12 Agustus 2025',
                'content' => '<p>Melibatkan warga lokal, mahasiswa dari Fakultas Ilmu Sosial (FIS) memetakan kebutuhan dan potensi ruang-ruang publik yang terbengkalai untuk diusulkan menjadi taman, area bermain, atau ruang interaksi warga yang lebih bermanfaat.</p>'
            ],
            'riset-ft-unj-model-integrasi-transportasi-publik' => [
                'sdg_id' => 11,
                'title' => 'Riset FT UNJ: Model Integrasi Transportasi Publik Jabodetabek',
                'image' => 'https://images.unsplash.com/photo-1517488629431-1d5843433a4c?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Tim Teknik Sipil UNJ',
                'date' => '13 Agustus 2025',
                'content' => '<p>Tim dari Teknik Sipil merancang model untuk meningkatkan konektivitas antara berbagai moda transportasi publik guna mengurangi kemacetan.</p>'
            ],
            'kkn-tematik-unj-fokus-bank-sampah-digital' => [
                'sdg_id' => 11,
                'title' => 'KKN Tematik UNJ Fokus pada Program Bank Sampah Digital',
                'image' => 'https://images.unsplash.com/photo-1599056262426-521639c43d81?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Mahasiswa KKN UNJ',
                'date' => '14 Agustus 2025',
                'content' => '<p>Mahasiswa KKN UNJ mendampingi warga di beberapa RW untuk mengimplementasikan sistem bank sampah berbasis aplikasi mobile.</p>'
            ],

            // === DATA BERITA SDG 12 ===
            'unj-luncurkan-gerakan-zero-waste-campus' => [
                'sdg_id' => 12,
                'title' => 'UNJ Luncurkan Gerakan "Zero Waste Campus" dengan Pengelolaan Sampah Terpadu',
                'image' => 'https://images.unsplash.com/photo-1604187351543-04114775c87a?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Humas UNJ',
                'date' => '15 Agustus 2025',
                'content' => '<p>UNJ mengimplementasikan sistem pengelolaan sampah terpadu yang mewajibkan pemilahan sampah di seluruh area kampus. Sampah organik diolah menjadi kompos, sementara sampah anorganik disalurkan ke bank sampah untuk didaur ulang.</p>'
            ],
            'prodi-tata-boga-ciptakan-produk-dari-sisa-pangan' => [
                'sdg_id' => 12,
                'title' => 'Prodi Tata Boga UNJ Ciptakan Produk dari Sisa Pangan (Food Loss)',
                'image' => 'https://images.unsplash.com/photo-1593105544959-28c64c931a37?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Prodi Tata Boga UNJ',
                'date' => '16 Agustus 2025',
                'content' => '<p>Mahasiswa mengembangkan produk pangan inovatif seperti keripik dari kulit sayuran dan kaldu dari tulang sisa untuk mengurangi limbah makanan.</p>'
            ],
            'peragaan-busana-berkelanjutan-tata-busana-unj' => [
                'sdg_id' => 12,
                'title' => 'Peragaan Busana Berkelanjutan oleh Mahasiswa Tata Busana UNJ',
                'image' => 'https://images.unsplash.com/photo-1611212879685-53535957dc5a?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Prodi Tata Busana UNJ',
                'date' => '17 Agustus 2025',
                'content' => '<p>Mahasiswa menampilkan koleksi busana yang dibuat dari bahan daur ulang dan limbah kain perca sebagai kampanye melawan fast fashion.</p>'
            ],

            // === DATA BERITA SDG 13 ===
            'pusat-studi-lingkungan-rilis-peta-kerentanan' => [
                'sdg_id' => 13,
                'title' => 'Pusat Studi Lingkungan UNJ Rilis Peta Kerentanan Kenaikan Permukaan Laut di Pesisir Jakarta',
                'image' => 'https://images.unsplash.com/photo-1611273635951-87a323a65213?q=80&w=1932&auto=format&fit=crop',
                'author' => 'Pusat Studi Lingkungan UNJ',
                'date' => '18 Agustus 2025',
                'content' => '<p>Berdasarkan data multi-tahun, tim peneliti dari UNJ memodelkan dan memetakan area-area di pesisir Jakarta yang paling rentan terhadap dampak kenaikan permukaan laut. Hasil riset ini diserahkan kepada pemerintah sebagai dasar perencanaan adaptasi.</p>'
            ],
            'mahasiswa-unj-gelar-aksi-satu-pohon-satu-harapan' => [
                'sdg_id' => 13,
                'title' => 'Mahasiswa UNJ Gelar Aksi "Satu Pohon, Satu Harapan"',
                'image' => 'https://images.unsplash.com/photo-1542601906-823816a75393?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Mahasiswa Pecinta Alam UNJ',
                'date' => '19 Agustus 2025',
                'content' => '<p>Bekerja sama dengan komunitas lokal, mahasiswa menanam ribuan pohon di area resapan air sebagai aksi nyata mitigasi perubahan iklim.</p>'
            ],
            'unj-kembangkan-modul-pendidikan-perubahan-iklim' => [
                'sdg_id' => 13,
                'title' => 'UNJ Kembangkan Modul Pendidikan Perubahan Iklim untuk Sekolah',
                'image' => 'https://images.unsplash.com/photo-1491841550275-5b462bf48569?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Fakultas Ilmu Pendidikan UNJ',
                'date' => '20 Agustus 2025',
                'content' => '<p>Fakultas Ilmu Pendidikan (FIP) menyusun modul ajar interaktif untuk membantu guru menjelaskan isu perubahan iklim kepada siswa.</p>'
            ],

            // === DATA BERITA SDG 14 ===
            'mahasiswa-biologi-tanam-mangrove-muara-gembong' => [
                'sdg_id' => 14,
                'title' => 'Mahasiswa Biologi UNJ dan Komunitas Lokal Tanam Ribuan Mangrove di Pesisir Muara Gembong',
                'image' => 'https://images.unsplash.com/photo-1582202242940-27a363b7b51e?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Tim Biologi UNJ',
                'date' => '21 Agustus 2025',
                'content' => '<p>Sebagai bagian dari program pengabdian masyarakat, tim dari UNJ berkolaborasi dengan kelompok pemuda dan nelayan lokal untuk merehabilitasi ekosistem mangrove yang rusak akibat abrasi. Kegiatan ini bertujuan untuk melindungi garis pantai dan mengembalikan habitat biota laut.</p>'
            ],
            'riset-kimia-unj-deteksi-mikroplastik' => [
                'sdg_id' => 14,
                'title' => 'Riset Kimia UNJ: Deteksi Mikroplastik pada Ikan Konsumsi',
                'image' => 'https://images.unsplash.com/photo-1597931333425-11b6a2431713?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Tim Kimia UNJ',
                'date' => '22 Agustus 2025',
                'content' => '<p>Penelitian yang dipublikasikan di jurnal internasional ini mengungkap tingkat kontaminasi mikroplastik pada ikan yang dijual di pasar-pasar Jakarta.</p>'
            ],
            'unj-adakan-pelatihan-transplantasi-terumbu-karang' => [
                'sdg_id' => 14,
                'title' => 'UNJ Adakan Pelatihan Transplantasi Terumbu Karang',
                'image' => 'https://images.unsplash.com/photo-1564993356612-9da288b53580?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Humas UNJ',
                'date' => '23 Agustus 2025',
                'content' => '<p>Bekerja sama dengan Balai Taman Nasional Kepulauan Seribu, UNJ melatih pemandu wisata selam menjadi kader konservasi terumbu karang.</p>'
            ],

            // === DATA BERITA SDG 15 ===
            'unj-resmikan-arboretum-laboratorium-hidup' => [
                'sdg_id' => 15,
                'title' => 'UNJ Resmikan Arboretum sebagai Laboratorium Hidup dan Paru-paru Kampus',
                'image' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?q=80&w=2071&auto=format&fit=crop',
                'author' => 'Humas UNJ',
                'date' => '24 Agustus 2025',
                'content' => '<p>UNJ mendedikasikan sebagian lahan kampusnya sebagai arboretum yang menampung berbagai jenis tanaman lokal dan langka. Area ini berfungsi sebagai pusat penelitian botani, sarana edukasi lingkungan, sekaligus area resapan air untuk kampus.</p>'
            ],
            'riset-unj-pemetaan-koridor-satwa-liar' => [
                'sdg_id' => 15,
                'title' => 'Riset UNJ: Pemetaan Koridor Satwa Liar di Lanskap Perkotaan',
                'image' => 'https://images.unsplash.com/photo-1594723453368-47253856868a?q=80&w=1964&auto=format&fit=crop',
                'author' => 'Tim Biologi UNJ',
                'date' => '25 Agustus 2025',
                'content' => '<p>Tim Biologi menggunakan kamera jebak dan GPS tracking untuk memetakan pergerakan satwa liar di area hijau sekitar Jakarta sebagai dasar kebijakan konservasi.</p>'
            ],
            'kkn-tematik-unj-fokus-reboisasi-lahan-kritis' => [
                'sdg_id' => 15,
                'title' => 'KKN Tematik UNJ Fokus pada Reboisasi Lahan Kritis di Hulu Sungai',
                'image' => 'https://images.unsplash.com/photo-1599399008985-e0b82b9846a8?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Mahasiswa KKN UNJ',
                'date' => '26 Agustus 2025',
                'content' => '<p>Mahasiswa melakukan penanaman pohon di lahan kritis di kawasan hulu sungai untuk mencegah erosi dan menjaga ketersediaan air tanah.</p>'
            ],

            // === DATA BERITA SDG 16 ===
            'pusat-studi-hukum-gelar-penyuluhan-hukum-gratis' => [
                'sdg_id' => 16,
                'title' => 'Pusat Studi Hukum UNJ Gelar Penyuluhan Hukum Gratis dan Bantuan Hukum bagi Masyarakat',
                'image' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Pusat Studi Hukum UNJ',
                'date' => '27 Agustus 2025',
                'content' => '<p>Dalam rangka meningkatkan akses terhadap keadilan, UNJ menyediakan layanan konsultasi dan bantuan hukum cuma-cuma bagi masyarakat kurang mampu. Program ini melibatkan dosen dan mahasiswa sebagai paralegal untuk memberikan pendampingan.</p>'
            ],
            'unj-deklarasikan-zona-integritas' => [
                'sdg_id' => 16,
                'title' => 'UNJ Deklarasikan Zona Integritas Menuju Wilayah Bebas Korupsi',
                'image' => 'https://images.unsplash.com/photo-1600880292210-2ad6a4a13433?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Humas UNJ',
                'date' => '28 Agustus 2025',
                'content' => '<p>Sebagai komitmen institusional, UNJ mencanangkan pembangunan zona integritas untuk menciptakan tata kelola yang bersih dan transparan.</p>'
            ],
            'prodi-pkn-inisiasi-sekolah-demokrasi' => [
                'sdg_id' => 16,
                'title' => 'Prodi PKn UNJ Inisiasi "Sekolah Demokrasi" untuk Pelajar SMA',
                'image' => 'https://images.unsplash.com/photo-1529070538774-1843cb3265df?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Prodi PKn UNJ',
                'date' => '29 Agustus 2025',
                'content' => '<p>Program ini bertujuan untuk menanamkan nilai-nilai demokrasi, toleransi, dan partisipasi aktif kepada generasi muda sejak dini.</p>'
            ],

            // === DATA BERITA SDG 17 ===
            'unj-gelar-forum-multi-pihak' => [
                'sdg_id' => 17,
                'title' => 'UNJ Gelar Forum Multi-Pihak, Satukan Pemerintah, Swasta, dan Komunitas untuk Aksi SDGs',
                'image' => 'https://images.unsplash.com/photo-1543269865-cbf427effbad?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Humas UNJ',
                'date' => '30 Agustus 2025',
                'content' => '<p>Sebagai wujud nyata kemitraan, UNJ menjadi tuan rumah forum tahunan yang mempertemukan berbagai pemangku kepentingan untuk berdiskusi, berbagi praktik baik, dan merancang proyek kolaboratif guna mempercepat pencapaian Tujuan Pembangunan Berkelanjutan di Indonesia.</p>'
            ],
            'unj-jalin-kemitraan-riset-dengan-universitas-asean' => [
                'sdg_id' => 17,
                'title' => 'UNJ Jalin Kemitraan Riset dengan Universitas di ASEAN',
                'image' => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Kantor Urusan Internasional UNJ',
                'date' => '31 Agustus 2025',
                'content' => '<p>UNJ menandatangani MoU dengan beberapa universitas terkemuka di Asia Tenggara untuk melakukan riset bersama tentang isu-isu pembangunan berkelanjutan lintas negara.</p>'
            ],
            'kolaborasi-unj-dan-sektor-swasta-untuk-program-magang' => [
                'sdg_id' => 17,
                'title' => 'Kolaborasi UNJ dan Sektor Swasta untuk Program Magang SDGs',
                'image' => 'https://images.unsplash.com/photo-1581092921449-41b93f2c3516?q=80&w=2070&auto=format&fit=crop',
                'author' => 'Pusat Karir UNJ',
                'date' => '1 September 2025',
                'content' => '<p>Program magang baru ini menempatkan mahasiswa di perusahaan-perusahaan yang memiliki komitmen kuat pada praktik bisnis berkelanjutan.</p>'
            ],
        ];


        // Cek apakah berita ada dan sesuai dengan sdg_id yang diminta
        if (isset($all_berita[$slug]) && $all_berita[$slug]['sdg_id'] === $sdg_id) {
            return $all_berita[$slug];
        }

        return null;
    }
}
