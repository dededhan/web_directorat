<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebijakan Privasi DISIP</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ckeditor-list.css') }}">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            text-align: center;
            padding: 40px 0;
        }

        header h1 {
            color: #186862;
            font-size: 42px;
            margin-bottom: 20px;
            letter-spacing: 2px;
        }

        .privacy-content {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .privacy-content h2 {
            color: #186862;
            font-size: 24px;
            margin-top: 30px;
            margin-bottom: 15px;
        }

        .privacy-content h3 {
            color: #186862;
            font-size: 20px;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .privacy-content p {
            margin-bottom: 15px;
        }

        .privacy-content ul {
            margin-bottom: 15px;
            margin-left: 20px;
        }

        .privacy-content li {
            margin-bottom: 8px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .privacy-content {
                padding: 20px;
            }

            header h1 {
                font-size: 32px;
            }
        }
    </style>
    @include('layout.navbar_sticky')
</head>

<body>
    <div class="container">
        <header>
            <h1>Kebijakan Privasi</h1>
        </header>

        <div class="privacy-content">
            <p>
                Kebijakan Privasi ini menjelaskan bagaimana Direktorat Inovasi Sistem Informasi dan Pemeringkatan (DISIP) Universitas Negeri Jakarta mengumpulkan, menggunakan, dan melindungi informasi yang Anda berikan saat menggunakan layanan kami.
            </p>

            <h2>Informasi yang Kami Kumpulkan</h2>
            <p>
                Kami dapat mengumpulkan informasi pribadi seperti nama, alamat email, nomor telepon, dan informasi akademik saat Anda:
            </p>
            <ul>
                <li>Mendaftar untuk menggunakan layanan kami</li>
                <li>Mengisi formulir di situs web kami</li>
                <li>Berpartisipasi dalam survei atau kuesioner</li>
                <li>Menggunakan fitur interaktif pada platform kami</li>
            </ul>

            <h2>Bagaimana Kami Menggunakan Informasi Anda</h2>
            <p>
                Informasi yang Anda berikan akan digunakan untuk:
            </p>
            <ul>
                <li>Memberikan dan meningkatkan layanan kami</li>
                <li>Memproses pendaftaran dan memberikan akses ke layanan</li>
                <li>Mengirimkan informasi terkait layanan dan pembaruan</li>
                <li>Melakukan analisis untuk pengembangan layanan</li>
                <li>Memenuhi kewajiban hukum kami</li>
            </ul>

            <h2>Keamanan Data</h2>
            <p>
                Kami berkomitmen untuk melindungi keamanan data Anda. Kami menerapkan langkah-langkah keamanan fisik, elektronik, dan prosedural yang dirancang untuk melindungi informasi Anda. Meskipun demikian, tidak ada metode transmisi melalui internet atau metode penyimpanan elektronik yang 100% aman.
            </p>

            <h2>Berbagi Informasi</h2>
            <p>
                Kami tidak akan menjual, menyewakan, atau menukar informasi pribadi Anda kepada pihak ketiga tanpa izin Anda, kecuali:
            </p>
            <ul>
                <li>Jika diperlukan untuk menyediakan layanan yang Anda minta</li>
                <li>Untuk kepatuhan terhadap kewajiban hukum</li>
                <li>Untuk melindungi hak, properti, atau keselamatan kami, pengguna kami, atau pihak lain</li>
            </ul>

            <h2>Hak Anda</h2>
            <p>
                Anda memiliki hak untuk:
            </p>
            <ul>
                <li>Mengakses informasi pribadi yang kami simpan tentang Anda</li>
                <li>Meminta koreksi informasi yang tidak akurat</li>
                <li>Meminta penghapusan informasi Anda</li>
                <li>Menolak penggunaan informasi Anda untuk tujuan tertentu</li>
            </ul>

            <h2>Perubahan pada Kebijakan Privasi</h2>
            <p>
                Kami dapat mengubah kebijakan privasi ini dari waktu ke waktu. Perubahan akan diberlakukan segera setelah diposting di situs dan tanggal "Terakhir Diperbarui" akan diubah. Kami mendorong Anda untuk meninjau kebijakan privasi ini secara berkala.
            </p>

            <h2>Hubungi Kami</h2>
            <p>
                Jika Anda memiliki pertanyaan tentang kebijakan privasi ini atau praktik data kami, silakan hubungi kami di:
            </p>
            <p>
                <strong>Direktorat Inovasi Sistem Informasi dan Pemeringkatan (DISIP)</strong><br>
                Universitas Negeri Jakarta<br>
                Email: disip@unj.ac.id<br>
                Telepon: (021) XXXXXXXX
            </p>

            <p class="mt-8">
                <em>Terakhir Diperbarui: Mei 2025</em>
            </p>
        </div>
    </div>

    @include('layout.footer')
</body>
</html>