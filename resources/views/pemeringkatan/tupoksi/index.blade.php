@extends('layouts.pemeringkatan')

@section('title', 'Tupoksi - Subdirektorat Sistem Informasi dan Pemeringkatan')

@push('styles')
    @vite('resources/css/pemeringkatan/tupoksi.css')
@endpush

@section('content')
    <main>
        <section class="functions" id="functions">
            <h2 class="section-title">Fungsi Utama</h2>
            <p>Direktorat Inovasi dan Hilirisasi, Sistem Informasi dan Pemeringkatan menyelenggarakan fungsi:</p>
            <ul class="function-list">
                <li>penyusunan dan pengembangan kebijakan inovasi;</li>
                <li>pengembangan dan pengelolaan kegiatan inovasi dan hilirisasi di seluruh Fakultas dan Program Studi;</li>
                <li>pemberian dukungan proses hilirisasi produk inovasi dari hasil riset untuk dapat dimanfaatkan masyarakat atau dikomersialisasikan;</li>
                <li>perumusan langkah strategis dalam peningkatan peringkat UNJ di tingkat nasional maupun internasional;</li>
                <li>pembuatan panduan untuk Fakultas dan Program Studi tentang peningkatan indikator pemeringkatan; dan</li>
                <li>pengembangan kemitraan di tingkat nasional dan internasional untuk mendukung kegiatan inovasi dan hilirisasi.</li>
            </ul>
        </section>
        
        <section class="organization" id="organization">
            <h2 class="section-title">Struktur Organisasi</h2>
            <p>Direktorat Inovasi dan Hilirisasi, Sistem Informasi dan Pemeringkatan didukung oleh:</p>
            
            <ul class="function-list">
                <li>Subdirektorat Inovasi dan Hilirisasi;</li>
                <li>Subdirektorat Sistem Informasi dan Pemeringkatan; dan</li>
                <li>Kelompok Jabatan Fungsional.</li>
            </ul>
            <div class="subdir-wrapper">
                <article>
                    <h3>Subdirektorat Inovasi dan Hilirisasi</h3>
                    <p>Mempunyai tugas melakukan pengembangan inovasi dan hilirisasi hasil riset. Subdirektorat Inovasi dan Hilirisasi menyelenggarakan fungsi:</p>
                    <ul class="function-list">
                        <li>pengelolaan program inkubasi untuk mendukung usaha rintisan berbasis inovasi;</li>
                        <li>pengelolaan dana riset yang diperoleh dari hibah atau kerja sama dengan mitra untuk mendukung pengembangan inovasi;</li>
                        <li>pelaksana pelatihan dalam pengembangan inovasi dan hilirisasi hasil penelitian;</li>
                        <li>pemantauan dan evaluasi terhadap proyek inovasi dan hilirisasi; dan</li>
                        <li>penyusunan laporan perkembangan inovasi dan hilirisasi.</li>
                    </ul>
                </article>
                
                <article>
                    <h3>Subdirektorat Sistem Informasi dan Pemeringkatan</h3>
                    <p>Mempunyai tugas melakukan peningkatan sistem informasi dan pemeringkatan. Subdirektorat Sistem Informasi dan Pemeringkatan menyelenggarakan fungsi:</p>
                    <ul class="function-list">
                        <li>pengumpulan, pengelolaan, dan analisis data yang dibutuhkan untuk pemeringkatan universitas;</li>
                        <li>penyusunan dan pelaksanaan strategi untuk meningkatkan posisi universitas dalam pemeringkatan nasional dan internasional;</li>
                        <li>pengordinasian dengan Fakultas, Program Studi, dan unit terkait untuk memastikan data yang diperlukan pemeringkatan terkumpul dengan baik dan valid;</li>
                        <li>penyusunan laporan pemeringkatan universitas;</li>
                        <li>penyusunan laporan berkala terkait pencapaian indikator pemeringkatan yang diperlukan.</li>
                    </ul>
                </article>
                
                <article>
                    <h3>Kelompok Jabatan Fungsional</h3>
                    <p>Mendukung pelaksanaan tugas dan fungsi Direktorat sesuai dengan keahlian dan kebutuhan.</p>
                </article>
            </div>
        </section>
@endsection