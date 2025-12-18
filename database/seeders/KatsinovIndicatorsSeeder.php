<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KatsinovIndicatorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get category IDs
        $categories = DB::table('katsinov_categories')->get()->keyBy('code');

        $indicators = [
            // IRL1 - KATSINOV 1 (Concept) - 22 indicators
            ['category_code' => 'IRL1', 'code' => 'IRL1.1', 'name' => 'Ide baru yang memberi solusi permasalahan masyarakat', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.55, 'max_score' => 5, 'order' => 1],
            ['category_code' => 'IRL1', 'code' => 'IRL1.2', 'name' => 'Telah dilakukan pengamatan prinsip-prinsip ilmiah dasar dan publikasi ilmiah', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.55, 'max_score' => 5, 'order' => 2],
            ['category_code' => 'IRL1', 'code' => 'IRL1.3', 'name' => 'Faktor yang membedakan temuan dengan temuan lain dan unsur kebaruan dari sebuah ide atau gagasan telah diidentifikasi', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.55, 'max_score' => 5, 'order' => 3],
            ['category_code' => 'IRL1', 'code' => 'IRL1.4', 'name' => 'Mengidentifikasi tahapan riset dan targetnya', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.55, 'max_score' => 5, 'order' => 4],
            ['category_code' => 'IRL1', 'code' => 'IRL1.5', 'name' => 'Teknologi yang akan dikembangkan telah layak secara ilmiah (scientific feasibility)', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.55, 'max_score' => 5, 'order' => 5],
            ['category_code' => 'IRL1', 'code' => 'IRL1.6', 'name' => 'Inovasi dilakukan berdasarkan permintaan dan/atau kebutuhan pelanggan', 'description' => 'Aspek Pasar (M)', 'weight' => 4.55, 'max_score' => 5, 'order' => 6],
            ['category_code' => 'IRL1', 'code' => 'IRL1.7', 'name' => 'Permintaan dan kebutuhan pelanggan telah diidentifikasi', 'description' => 'Aspek Pasar (M)', 'weight' => 4.55, 'max_score' => 5, 'order' => 7],
            ['category_code' => 'IRL1', 'code' => 'IRL1.8', 'name' => 'Telah mengidentifikasikan lokasi pasar yang akan dituju', 'description' => 'Aspek Pasar (M)', 'weight' => 4.55, 'max_score' => 5, 'order' => 8],
            ['category_code' => 'IRL1', 'code' => 'IRL1.9', 'name' => 'Telah memiliki strategi inovasi', 'description' => 'Aspek Organisasi (O)', 'weight' => 4.55, 'max_score' => 5, 'order' => 9],
            ['category_code' => 'IRL1', 'code' => 'IRL1.10', 'name' => 'Lingkup proyek dan tugas telah diidentifikasi', 'description' => 'Aspek Organisasi (O)', 'weight' => 4.55, 'max_score' => 5, 'order' => 10],
            ['category_code' => 'IRL1', 'code' => 'IRL1.11', 'name' => 'Kebutuhan akan sumber daya, dana dan fasilitas penelitian telah dikonfirmasi', 'description' => 'Aspek Organisasi (O)', 'weight' => 4.55, 'max_score' => 5, 'order' => 11],
            ['category_code' => 'IRL1', 'code' => 'IRL1.12', 'name' => 'Tersedia saluran komunikasi tanpa hambatan', 'description' => 'Aspek Organisasi (O)', 'weight' => 4.55, 'max_score' => 5, 'order' => 12],
            ['category_code' => 'IRL1', 'code' => 'IRL1.13', 'name' => 'Konsekuensi hasil temuan telah diidentifikasi melalui dasar manufaktur ekonomis', 'description' => 'Aspek Manufaktur (Mf)', 'weight' => 4.55, 'max_score' => 5, 'order' => 13],
            ['category_code' => 'IRL1', 'code' => 'IRL1.14', 'name' => 'Teridentifikasi dalam konsep manufaktur secara teknis dan ekonomis', 'description' => 'Aspek Manufaktur (Mf)', 'weight' => 4.55, 'max_score' => 5, 'order' => 14],
            ['category_code' => 'IRL1', 'code' => 'IRL1.15', 'name' => 'Tersedia bukti konsep manufaktur melalui analitik atau eksperimen laboratorium', 'description' => 'Aspek Manufaktur (Mf)', 'weight' => 4.55, 'max_score' => 5, 'order' => 15],
            ['category_code' => 'IRL1', 'code' => 'IRL1.16', 'name' => 'Ide yang dikembangkan memiliki konsep model bisnis', 'description' => 'Aspek Investasi (I)', 'weight' => 4.55, 'max_score' => 5, 'order' => 16],
            ['category_code' => 'IRL1', 'code' => 'IRL1.17', 'name' => 'Peluang investasi untuk mewujudkan hasil temuan telah diidentifikasi', 'description' => 'Aspek Investasi (I)', 'weight' => 4.55, 'max_score' => 5, 'order' => 17],
            ['category_code' => 'IRL1', 'code' => 'IRL1.18', 'name' => 'Kebutuhan pembiayaan telah terestimasi', 'description' => 'Aspek Investasi (I)', 'weight' => 4.55, 'max_score' => 5, 'order' => 18],
            ['category_code' => 'IRL1', 'code' => 'IRL1.19', 'name' => 'Terbuka peluang kerjasama dengan industri atau institusi lain', 'description' => 'Aspek Kemitraan (P)', 'weight' => 4.55, 'max_score' => 5, 'order' => 19],
            ['category_code' => 'IRL1', 'code' => 'IRL1.20', 'name' => 'Tersedia atau dapat dipersiapkan perjanjian kerjasama', 'description' => 'Aspek Kemitraan (P)', 'weight' => 4.55, 'max_score' => 5, 'order' => 20],
            ['category_code' => 'IRL1', 'code' => 'IRL1.21', 'name' => 'Tersedia atau dapat disiapkan strategi manajemen risiko', 'description' => 'Aspek Risiko (R)', 'weight' => 4.55, 'max_score' => 5, 'order' => 21],
            ['category_code' => 'IRL1', 'code' => 'IRL1.22', 'name' => 'Risiko secara keseluruhan teridentifikasi', 'description' => 'Aspek Risiko (R)', 'weight' => 4.55, 'max_score' => 5, 'order' => 22],

            // IRL2 - KATSINOV 2 (Component) - 21 indicators
            ['category_code' => 'IRL2', 'code' => 'IRL2.1', 'name' => 'Telah melakukan validasi terhadap komponen individu dari teknologi', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.76, 'max_score' => 5, 'order' => 1],
            ['category_code' => 'IRL2', 'code' => 'IRL2.2', 'name' => 'Prototipe telah didemonstrasikan dalam lingkungan yang relevan', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.76, 'max_score' => 5, 'order' => 2],
            ['category_code' => 'IRL2', 'code' => 'IRL2.3', 'name' => 'Teknologi dinyatakan layak secara teknis', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.76, 'max_score' => 5, 'order' => 3],
            ['category_code' => 'IRL2', 'code' => 'IRL2.4', 'name' => 'Telah melakukan pendaftaran kekayaan intelektual (misal: paten, desain industri, hak cipta, merek, dll)', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.76, 'max_score' => 5, 'order' => 4],
            ['category_code' => 'IRL2', 'code' => 'IRL2.5', 'name' => 'Secara teknis mampu memberikan solusi terhadap permasalahan yang dihadapi masyarakat', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.76, 'max_score' => 5, 'order' => 5],
            ['category_code' => 'IRL2', 'code' => 'IRL2.6', 'name' => 'Pelanggan akhir teridentifikasi', 'description' => 'Aspek Pasar (M)', 'weight' => 4.76, 'max_score' => 5, 'order' => 6],
            ['category_code' => 'IRL2', 'code' => 'IRL2.7', 'name' => 'Telah mengeluarkan rencana peluncuran produk baru ke pasar secara rinci', 'description' => 'Aspek Pasar (M)', 'weight' => 4.76, 'max_score' => 5, 'order' => 7],
            ['category_code' => 'IRL2', 'code' => 'IRL2.8', 'name' => 'Telah memulai kesiapan modal intelektual (intellectual capital)', 'description' => 'Aspek Pasar (M)', 'weight' => 4.76, 'max_score' => 5, 'order' => 8],
            ['category_code' => 'IRL2', 'code' => 'IRL2.9', 'name' => 'Analisis dan rencana bisnis telah dikeluarkan', 'description' => 'Aspek Organisasi (O)', 'weight' => 4.76, 'max_score' => 5, 'order' => 9],
            ['category_code' => 'IRL2', 'code' => 'IRL2.10', 'name' => 'Telah memiliki keterlibatan dengan individu kunci', 'description' => 'Aspek Organisasi (O)', 'weight' => 4.76, 'max_score' => 5, 'order' => 10],
            ['category_code' => 'IRL2', 'code' => 'IRL2.11', 'name' => 'Telah melakukan persetujuan persyaratan proyek dan daftar mitra proyek', 'description' => 'Aspek Organisasi (O)', 'weight' => 4.76, 'max_score' => 5, 'order' => 11],
            ['category_code' => 'IRL2', 'code' => 'IRL2.12', 'name' => 'Telah melakukan persetujuan tanggung jawab dan persetujuan batas waktu dalam pengelolaan suatu proyek', 'description' => 'Aspek Organisasi (O)', 'weight' => 4.76, 'max_score' => 5, 'order' => 12],
            ['category_code' => 'IRL2', 'code' => 'IRL2.13', 'name' => 'Identifikasi teknologi dan komponen kritikal telah komplit', 'description' => 'Aspek Manufaktur (Mf)', 'weight' => 4.76, 'max_score' => 5, 'order' => 13],
            ['category_code' => 'IRL2', 'code' => 'IRL2.14', 'name' => 'Material, perkakas dan alat uji prototipe, maupun keahlian personel telah diperlihatkan oleh sub system/system dalam suatu lingkungan produksi yang relevan', 'description' => 'Aspek Manufaktur (Mf)', 'weight' => 4.76, 'max_score' => 5, 'order' => 14],
            ['category_code' => 'IRL2', 'code' => 'IRL2.15', 'name' => 'Keunggulan jual yang dimiliki telah teruji kepada pelanggan', 'description' => 'Aspek Investasi (I)', 'weight' => 4.76, 'max_score' => 5, 'order' => 15],
            ['category_code' => 'IRL2', 'code' => 'IRL2.16', 'name' => 'Solusi yang ditawarkan kepada pelanggan memunculkan daya tarik yang menguntungkan di pasar', 'description' => 'Aspek Investasi (I)', 'weight' => 4.76, 'max_score' => 5, 'order' => 16],
            ['category_code' => 'IRL2', 'code' => 'IRL2.17', 'name' => 'Validasi value proposition, channel, segmen pelanggan, model hubungan dengan pelanggan yang ada, dan aliran revenue terbukti telah dilakukan', 'description' => 'Aspek Investasi (I)', 'weight' => 4.76, 'max_score' => 5, 'order' => 17],
            ['category_code' => 'IRL2', 'code' => 'IRL2.18', 'name' => 'Telah melakukan penggalian informasi dan seleksi mitra', 'description' => 'Aspek Kemitraan (P)', 'weight' => 4.76, 'max_score' => 5, 'order' => 18],
            ['category_code' => 'IRL2', 'code' => 'IRL2.19', 'name' => 'Pola kemitraan dibangun dengan tepat', 'description' => 'Aspek Kemitraan (P)', 'weight' => 4.76, 'max_score' => 5, 'order' => 19],
            ['category_code' => 'IRL2', 'code' => 'IRL2.20', 'name' => 'Kajian risiko teknologi telah dilakukan dalam setiap langkah pengembangan teknologi', 'description' => 'Aspek Risiko (R)', 'weight' => 4.76, 'max_score' => 5, 'order' => 20],
            ['category_code' => 'IRL2', 'code' => 'IRL2.21', 'name' => 'Pada tahap pengembangan teknologi dilakukan penyusunan rencana pengendalian risiko teknologi', 'description' => 'Aspek Risiko (R)', 'weight' => 4.76, 'max_score' => 5, 'order' => 21],

            // IRL3 - KATSINOV 3 (Completion) - 21 indicators
            ['category_code' => 'IRL3', 'code' => 'IRL3.1', 'name' => 'Sistem aktual teknologi telah didemonstrasikan dalam lingkungan yang sebenarnya', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.76, 'max_score' => 5, 'order' => 1],
            ['category_code' => 'IRL3', 'code' => 'IRL3.2', 'name' => 'Uji eksternal dari teknologi yang dikembangkan telah dilakukan secara lengkap, dalam rangka memenuhi persyaratan teknis dan kesesuaian regulasi', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.76, 'max_score' => 5, 'order' => 2],
            ['category_code' => 'IRL3', 'code' => 'IRL3.3', 'name' => 'Telah mendokumentasikan teknologi yang dikembangkan', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.76, 'max_score' => 5, 'order' => 3],
            ['category_code' => 'IRL3', 'code' => 'IRL3.4', 'name' => 'Hasil Inovasi telah diperkenalkan', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.76, 'max_score' => 5, 'order' => 4],
            ['category_code' => 'IRL3', 'code' => 'IRL3.5', 'name' => 'Telah memperoleh Kekayaan intelektual (misal: paten, desain industri, hak cipta, merek, dll)', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.76, 'max_score' => 5, 'order' => 5],
            ['category_code' => 'IRL3', 'code' => 'IRL3.6', 'name' => 'Kebutuhan khusus dan keperluan pelanggan telah diketahui', 'description' => 'Aspek Pasar (M)', 'weight' => 4.76, 'max_score' => 5, 'order' => 6],
            ['category_code' => 'IRL3', 'code' => 'IRL3.7', 'name' => 'Segmen, ukuran dan pangsa pasar telah diprediksi', 'description' => 'Aspek Pasar (M)', 'weight' => 4.76, 'max_score' => 5, 'order' => 7],
            ['category_code' => 'IRL3', 'code' => 'IRL3.8', 'name' => 'Produk telah diperkenalkan, dan harganya telah ditetapkan', 'description' => 'Aspek Pasar (M)', 'weight' => 4.76, 'max_score' => 5, 'order' => 8],
            ['category_code' => 'IRL3', 'code' => 'IRL3.9', 'name' => 'Penetapan organisasi (struktur bisnis dengan staff dan kolaborator)', 'description' => 'Aspek Organisasi (O)', 'weight' => 4.76, 'max_score' => 5, 'order' => 9],
            ['category_code' => 'IRL3', 'code' => 'IRL3.10', 'name' => 'Identifikasi beberapa tambahan staff yang dibutuhkan', 'description' => 'Aspek Organisasi (O)', 'weight' => 4.76, 'max_score' => 5, 'order' => 10],
            ['category_code' => 'IRL3', 'code' => 'IRL3.11', 'name' => 'Telah merincikan pembagian tanggung jawab dan beban kerja', 'description' => 'Aspek Organisasi (O)', 'weight' => 4.76, 'max_score' => 5, 'order' => 11],
            ['category_code' => 'IRL3', 'code' => 'IRL3.12', 'name' => 'Desain sistem sebagian besar stabil dan terbukti dalam uji dan evaluasi', 'description' => 'Aspek Manufaktur (Mf)', 'weight' => 4.76, 'max_score' => 5, 'order' => 12],
            ['category_code' => 'IRL3', 'code' => 'IRL3.13', 'name' => 'Proses dan prosedur manufaktur terbukti dalam skala pilot', 'description' => 'Aspek Manufaktur (Mf)', 'weight' => 4.76, 'max_score' => 5, 'order' => 13],
            ['category_code' => 'IRL3', 'code' => 'IRL3.14', 'name' => 'Produksi pada laju rendah telah dilaksanakan', 'description' => 'Aspek Manufaktur (Mf)', 'weight' => 4.76, 'max_score' => 5, 'order' => 14],
            ['category_code' => 'IRL3', 'code' => 'IRL3.15', 'name' => 'Telah mendefinisikan kondisi akhir dari produk teknologi dengan mempertimbangkan target person, pasar vertikal, serta geografik', 'description' => 'Aspek Investasi (I)', 'weight' => 4.76, 'max_score' => 5, 'order' => 15],
            ['category_code' => 'IRL3', 'code' => 'IRL3.16', 'name' => 'Validasi terhadap bisnis yang dilakukan sudah diterapkan', 'description' => 'Aspek Investasi (I)', 'weight' => 4.76, 'max_score' => 5, 'order' => 16],
            ['category_code' => 'IRL3', 'code' => 'IRL3.17', 'name' => 'Identifikasi dan validasi terhadap indikator kinerja utama yang mengindikasikan keberhasilan bisnis', 'description' => 'Aspek Investasi (I)', 'weight' => 4.76, 'max_score' => 5, 'order' => 17],
            ['category_code' => 'IRL3', 'code' => 'IRL3.18', 'name' => 'Telah terjalin kemitraan secara formal', 'description' => 'Aspek Kemitraan (P)', 'weight' => 4.76, 'max_score' => 5, 'order' => 18],
            ['category_code' => 'IRL3', 'code' => 'IRL3.19', 'name' => 'Telah menyusun dan telah menerapkan rencana kerja sama', 'description' => 'Aspek Kemitraan (P)', 'weight' => 4.76, 'max_score' => 5, 'order' => 19],
            ['category_code' => 'IRL3', 'code' => 'IRL3.20', 'name' => 'Kajian risiko teknologi menjadi dasar pengambilan keputusan teknis dalam tahap engineering & Operation', 'description' => 'Aspek Risiko (R)', 'weight' => 4.76, 'max_score' => 5, 'order' => 20],
            ['category_code' => 'IRL3', 'code' => 'IRL3.21', 'name' => 'Pada tahap penerapan teknologi dilakukan penyusunan rencana pengendalian risiko teknologi', 'description' => 'Aspek Risiko (R)', 'weight' => 4.76, 'max_score' => 5, 'order' => 21],

            // IRL4 - KATSINOV 4 (Chasin) - 22 indicators
            ['category_code' => 'IRL4', 'code' => 'IRL4.1', 'name' => 'Telah terbentuk keahlian terkait pengoperasian dan pemeliharaan produk teknologi', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.55, 'max_score' => 5, 'order' => 1],
            ['category_code' => 'IRL4', 'code' => 'IRL4.2', 'name' => 'Penggunaan umum produk teknologi oleh cakupan pasar yang luas telah diidentifikasi', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.55, 'max_score' => 5, 'order' => 2],
            ['category_code' => 'IRL4', 'code' => 'IRL4.3', 'name' => 'Keuntungan teknologi melalui hasil pengujian telah diidentifikasi', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.55, 'max_score' => 5, 'order' => 3],
            ['category_code' => 'IRL4', 'code' => 'IRL4.4', 'name' => 'Adanya dukungan terhadap adopsi produk teknologi oleh pasar', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.55, 'max_score' => 5, 'order' => 4],
            ['category_code' => 'IRL4', 'code' => 'IRL4.5', 'name' => 'Telah membangun citra produk teknologi kepada pasar', 'description' => 'Aspek Pasar (M)', 'weight' => 4.55, 'max_score' => 5, 'order' => 5],
            ['category_code' => 'IRL4', 'code' => 'IRL4.6', 'name' => 'Model bisnis ditetapkan', 'description' => 'Aspek Pasar (M)', 'weight' => 4.55, 'max_score' => 5, 'order' => 6],
            ['category_code' => 'IRL4', 'code' => 'IRL4.7', 'name' => 'Pesaing diidentifikasi dengan baik', 'description' => 'Aspek Pasar (M)', 'weight' => 4.55, 'max_score' => 5, 'order' => 7],
            ['category_code' => 'IRL4', 'code' => 'IRL4.8', 'name' => 'Pemasaran ditekankan pada pengenalan secara spesifik produk teknologi kepada para pelanggannya', 'description' => 'Aspek Pasar (M)', 'weight' => 4.55, 'max_score' => 5, 'order' => 8],
            ['category_code' => 'IRL4', 'code' => 'IRL4.9', 'name' => 'Telah menetapkan bentuk organisasi', 'description' => 'Aspek Organisasi (O)', 'weight' => 4.55, 'max_score' => 5, 'order' => 9],
            ['category_code' => 'IRL4', 'code' => 'IRL4.10', 'name' => 'Telah mengembangkan kemitraan dengan organisasi independen', 'description' => 'Aspek Organisasi (O)', 'weight' => 4.55, 'max_score' => 5, 'order' => 10],
            ['category_code' => 'IRL4', 'code' => 'IRL4.11', 'name' => 'Identifikasi peluang untuk memperkenalkan produk kepada mitra dan pasar baru', 'description' => 'Aspek Organisasi (O)', 'weight' => 4.55, 'max_score' => 5, 'order' => 11],
            ['category_code' => 'IRL4', 'code' => 'IRL4.12', 'name' => 'Telah diperlihatkan produksi yang menguntungkan secara finansial', 'description' => 'Aspek Manufaktur (Mf)', 'weight' => 4.55, 'max_score' => 5, 'order' => 12],
            ['category_code' => 'IRL4', 'code' => 'IRL4.13', 'name' => 'Mulai menerapkan GMP (Good Manufacturing Practice) atau Lean Manufacturing', 'description' => 'Aspek Manufaktur (Mf)', 'weight' => 4.55, 'max_score' => 5, 'order' => 13],
            ['category_code' => 'IRL4', 'code' => 'IRL4.14', 'name' => 'Mulai menerapkan jaminan mutu sesuai standar (SNI)', 'description' => 'Aspek Manufaktur (Mf)', 'weight' => 4.55, 'max_score' => 5, 'order' => 14],
            ['category_code' => 'IRL4', 'code' => 'IRL4.15', 'name' => 'Adanya tuntutan masyarakat terhadap mutu, keamanan dan keselamatan produk yang dimanfaatkan', 'description' => 'Aspek Manufaktur (Mf)', 'weight' => 4.55, 'max_score' => 5, 'order' => 15],
            ['category_code' => 'IRL4', 'code' => 'IRL4.16', 'name' => 'Potensi pasar teridentifikasi', 'description' => 'Aspek Investasi (I)', 'weight' => 4.55, 'max_score' => 5, 'order' => 16],
            ['category_code' => 'IRL4', 'code' => 'IRL4.17', 'name' => 'Daya terima pasar terhadap produk telah teridentifikasi', 'description' => 'Aspek Investasi (I)', 'weight' => 4.55, 'max_score' => 5, 'order' => 17],
            ['category_code' => 'IRL4', 'code' => 'IRL4.18', 'name' => 'Melakukan kerja sama di dalam jejaring usaha secara dinamis', 'description' => 'Aspek Kemitraan (P)', 'weight' => 4.55, 'max_score' => 5, 'order' => 18],
            ['category_code' => 'IRL4', 'code' => 'IRL4.19', 'name' => 'Terus melakukan pengelolaan terhadap kerjasama yang sudah berjalan', 'description' => 'Aspek Kemitraan (P)', 'weight' => 4.55, 'max_score' => 5, 'order' => 19],
            ['category_code' => 'IRL4', 'code' => 'IRL4.20', 'name' => 'Penyusunan rencana pengendalian risiko non teknologi (organisasi dan sosial) pada tahap pengenalan produk ke pasar', 'description' => 'Aspek Risiko (R)', 'weight' => 4.55, 'max_score' => 5, 'order' => 20],
            ['category_code' => 'IRL4', 'code' => 'IRL4.21', 'name' => 'Kajian risiko organisasi (khususnya indikator keuangan) dilakukan pada tahap pengenalan produk ke pasar', 'description' => 'Aspek Risiko (R)', 'weight' => 4.55, 'max_score' => 5, 'order' => 21],
            ['category_code' => 'IRL4', 'code' => 'IRL4.22', 'name' => 'Kajian risiko dampak sosial pada tahap pengenalan produk ke pasar', 'description' => 'Aspek Risiko (R)', 'weight' => 4.55, 'max_score' => 5, 'order' => 22],

            // IRL5 - KATSINOV 5 (Competition) - 24 indicators
            ['category_code' => 'IRL5', 'code' => 'IRL5.1', 'name' => 'Adanya garansi terhadap produk teknologi yang dipasarkan', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.17, 'max_score' => 5, 'order' => 1],
            ['category_code' => 'IRL5', 'code' => 'IRL5.2', 'name' => 'Layanan pemeliharaan produk telah disediakan', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.17, 'max_score' => 5, 'order' => 2],
            ['category_code' => 'IRL5', 'code' => 'IRL5.3', 'name' => 'Pasokan suku cadang untuk produk teknologi telah disediakan', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.17, 'max_score' => 5, 'order' => 3],
            ['category_code' => 'IRL5', 'code' => 'IRL5.4', 'name' => 'Adanya aktivitas pengembangan dengan intensitas lebih rendah, untuk peningkatan kerja produk teknologi sesuai permintaan pelanggan', 'description' => 'Aspek Teknologi (T)', 'weight' => 4.17, 'max_score' => 5, 'order' => 4],
            ['category_code' => 'IRL5', 'code' => 'IRL5.5', 'name' => 'Telah menyediakan pelayanan dan solusi yang lengkap', 'description' => 'Aspek Pasar (M)', 'weight' => 4.17, 'max_score' => 5, 'order' => 5],
            ['category_code' => 'IRL5', 'code' => 'IRL5.6', 'name' => 'Telah melakukan diferensiasi produk', 'description' => 'Aspek Pasar (M)', 'weight' => 4.17, 'max_score' => 5, 'order' => 6],
            ['category_code' => 'IRL5', 'code' => 'IRL5.7', 'name' => 'Telah melakukan penyempurnaan model bisnis', 'description' => 'Aspek Pasar (M)', 'weight' => 4.17, 'max_score' => 5, 'order' => 7],
            ['category_code' => 'IRL5', 'code' => 'IRL5.8', 'name' => 'Telah menggunakan kemitraan untuk berkompetisi di pasar', 'description' => 'Aspek Pasar (M)', 'weight' => 4.17, 'max_score' => 5, 'order' => 8],
            ['category_code' => 'IRL5', 'code' => 'IRL5.9', 'name' => 'Telah meningkatkan efektivitas dan kerjasama', 'description' => 'Aspek Organisasi (O)', 'weight' => 4.17, 'max_score' => 5, 'order' => 9],
            ['category_code' => 'IRL5', 'code' => 'IRL5.10', 'name' => 'Telah melakukan penataan kembali struktur perusahaan sesuai kebutuhan', 'description' => 'Aspek Organisasi (O)', 'weight' => 4.17, 'max_score' => 5, 'order' => 10],
            ['category_code' => 'IRL5', 'code' => 'IRL5.11', 'name' => 'Identifikasi peningkatan peluang pertemuan produk teknologi dengan kebutuhan pasar', 'description' => 'Aspek Organisasi (O)', 'weight' => 4.17, 'max_score' => 5, 'order' => 11],
            ['category_code' => 'IRL5', 'code' => 'IRL5.12', 'name' => 'Telah melakukan peninjauan proses teknis dan komersial untuk meningkatkan harga dan keuntungan', 'description' => 'Aspek Organisasi (O)', 'weight' => 4.17, 'max_score' => 5, 'order' => 12],
            ['category_code' => 'IRL5', 'code' => 'IRL5.13', 'name' => 'Menerapkan GMP (Good Manufacturing Practice) atau Lean Manufacturing secara intensif', 'description' => 'Aspek Manufaktur (Mf)', 'weight' => 4.17, 'max_score' => 5, 'order' => 13],
            ['category_code' => 'IRL5', 'code' => 'IRL5.14', 'name' => 'Adanya kebutuhan saran (baik internal maupun eksternal) kepada manajemen untuk perbaikan kinerja', 'description' => 'Aspek Manufaktur (Mf)', 'weight' => 4.17, 'max_score' => 5, 'order' => 14],
            ['category_code' => 'IRL5', 'code' => 'IRL5.15', 'name' => 'Telah menerapkan jaminan mutu sesuai standar', 'description' => 'Aspek Manufaktur (Mf)', 'weight' => 4.17, 'max_score' => 5, 'order' => 15],
            ['category_code' => 'IRL5', 'code' => 'IRL5.16', 'name' => 'Adanya jaminan terhadap mutu, keamanan dan keselamatan produk yang dimanfaatkan oleh masyarakat', 'description' => 'Aspek Manufaktur (Mf)', 'weight' => 4.17, 'max_score' => 5, 'order' => 16],
            ['category_code' => 'IRL5', 'code' => 'IRL5.17', 'name' => 'Kebutuhan perluasan pasar telah diidentifikasi', 'description' => 'Aspek Investasi (I)', 'weight' => 4.17, 'max_score' => 5, 'order' => 17],
            ['category_code' => 'IRL5', 'code' => 'IRL5.18', 'name' => 'Adanya peningkatan kapasitas produksi', 'description' => 'Aspek Investasi (I)', 'weight' => 4.17, 'max_score' => 5, 'order' => 18],
            ['category_code' => 'IRL5', 'code' => 'IRL5.19', 'name' => 'Peningkatan kerjasama di dalam jejaring secara dinamis', 'description' => 'Aspek Kemitraan (P)', 'weight' => 4.17, 'max_score' => 5, 'order' => 19],
            ['category_code' => 'IRL5', 'code' => 'IRL5.20', 'name' => 'Telah melakukan peningkatan mutu pengelolaan pada produk yang sudah berjalan', 'description' => 'Aspek Kemitraan (P)', 'weight' => 4.17, 'max_score' => 5, 'order' => 20],
            ['category_code' => 'IRL5', 'code' => 'IRL5.21', 'name' => 'Kerja sama dalam distribusi dan pemasaran produk', 'description' => 'Aspek Kemitraan (P)', 'weight' => 4.17, 'max_score' => 5, 'order' => 21],
            ['category_code' => 'IRL5', 'code' => 'IRL5.22', 'name' => 'Penyusunan rencana pengendalian risiko non teknologi (organisasi dan sosial) pada tahap kematangan pasar tercapai', 'description' => 'Aspek Risiko (R)', 'weight' => 4.17, 'max_score' => 5, 'order' => 22],
            ['category_code' => 'IRL5', 'code' => 'IRL5.23', 'name' => 'Kajian risiko organisasi (khususnya indikator keuangan) pada tahap kematangan pasar tercapai', 'description' => 'Aspek Risiko (R)', 'weight' => 4.17, 'max_score' => 5, 'order' => 23],
            ['category_code' => 'IRL5', 'code' => 'IRL5.24', 'name' => 'Kajian risiko dampak sosial pada tahap kematangan pasar tercapai', 'description' => 'Aspek Risiko (R)', 'weight' => 4.17, 'max_score' => 5, 'order' => 24],

            // IRL6 - KATSINOV 6 (Changeover/Closedown) - 14 indicators
            ['category_code' => 'IRL6', 'code' => 'IRL6.1', 'name' => 'Produk teknologi milik kompetitor telah ditinjau', 'description' => 'Aspek Teknologi (T)', 'weight' => 7.14, 'max_score' => 5, 'order' => 1],
            ['category_code' => 'IRL6', 'code' => 'IRL6.2', 'name' => 'Telah meninjau kemampuan teknologi yang dimiliki untuk mendukung inovasi ulang atau pengembangan teknologi baru', 'description' => 'Aspek Teknologi (T)', 'weight' => 7.14, 'max_score' => 5, 'order' => 2],
            ['category_code' => 'IRL6', 'code' => 'IRL6.3', 'name' => 'Telah memilih antara melakukan inovasi ulang produk teknologi yang ada, atau mengembangkan produk teknologi baru', 'description' => 'Aspek Teknologi (T)', 'weight' => 7.14, 'max_score' => 5, 'order' => 3],
            ['category_code' => 'IRL6', 'code' => 'IRL6.4', 'name' => 'Penurunan pasar telah dikonfirmasi', 'description' => 'Aspek Pasar (M)', 'weight' => 7.14, 'max_score' => 5, 'order' => 4],
            ['category_code' => 'IRL6', 'code' => 'IRL6.5', 'name' => 'Riset pasar untuk persetujuan inovasi ulang atau pengembangan teknologi yang lebih maju', 'description' => 'Aspek Pasar (M)', 'weight' => 7.14, 'max_score' => 5, 'order' => 5],
            ['category_code' => 'IRL6', 'code' => 'IRL6.6', 'name' => 'Permintaan pasar telah ditinjau', 'description' => 'Aspek Pasar (M)', 'weight' => 7.14, 'max_score' => 5, 'order' => 6],
            ['category_code' => 'IRL6', 'code' => 'IRL6.7', 'name' => 'Identifikasi peluang tumbuhnya pasar atau ekspansi pasar baru', 'description' => 'Aspek Pasar (M)', 'weight' => 7.14, 'max_score' => 5, 'order' => 7],
            ['category_code' => 'IRL6', 'code' => 'IRL6.8', 'name' => 'Adanya peran jaringan kemitraan dalam mendukung inovasi ulang atau pengembangan teknologi baru', 'description' => 'Aspek Organisasi (O)', 'weight' => 7.14, 'max_score' => 5, 'order' => 8],
            ['category_code' => 'IRL6', 'code' => 'IRL6.9', 'name' => 'Ada peran jejaring dalam mendukung Inovasi Ulang atau Pengembangan Teknologi Baru', 'description' => 'Aspek Organisasi (O)', 'weight' => 7.14, 'max_score' => 5, 'order' => 9],
            ['category_code' => 'IRL6', 'code' => 'IRL6.10', 'name' => 'Ada kebutuhan dilakukannya inovasi produksi atau pengembangan teknologi produksi baru', 'description' => 'Aspek Manufaktur (Mf)', 'weight' => 7.14, 'max_score' => 5, 'order' => 10],
            ['category_code' => 'IRL6', 'code' => 'IRL6.11', 'name' => 'Telah mengidentifikasi inovasi lanjutan dari produk, berdasarkan kebutuhan dan permintaan pasar saat ini dan beberapa tahun ke depan', 'description' => 'Aspek Investasi (I)', 'weight' => 7.14, 'max_score' => 5, 'order' => 11],
            ['category_code' => 'IRL6', 'code' => 'IRL6.12', 'name' => 'Telah melakukan tinjauan terhadap kemitraan yang sudah berjalan', 'description' => 'Aspek Kemitraan (P)', 'weight' => 7.14, 'max_score' => 5, 'order' => 12],
            ['category_code' => 'IRL6', 'code' => 'IRL6.13', 'name' => 'Telah melakukan pencarian mitra potensial untuk mendukung Inovasi ulang atau Pengembangan Teknologi Baru', 'description' => 'Aspek Kemitraan (P)', 'weight' => 7.14, 'max_score' => 5, 'order' => 13],
            ['category_code' => 'IRL6', 'code' => 'IRL6.14', 'name' => 'Telah melakukan kajian risiko untuk mendukung keputusan Inovasi Ulang atau Pengembangan Teknologi Baru', 'description' => 'Aspek Risiko (R)', 'weight' => 7.14, 'max_score' => 5, 'order' => 14],
        ];

        foreach ($indicators as $indicator) {
            $categoryCode = $indicator['category_code'];
            unset($indicator['category_code']);

            if (isset($categories[$categoryCode])) {
                DB::table('katsinov_indicators')->updateOrInsert(
                    ['code' => $indicator['code']],
                    array_merge($indicator, [
                        'category_id' => $categories[$categoryCode]->id,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ])
                );
            }
        }
    }
}
