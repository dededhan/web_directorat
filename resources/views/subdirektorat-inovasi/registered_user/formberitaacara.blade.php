<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara Pengukuran</title>
    {{-- <link rel="stylesheet" href="/inovasi/formberitaacara.css"> --}}
    <link rel="stylesheet" href="{{ asset('inovasi/dashboard/form_katsinov/css/berita_acara.css') }}">
    <link rel="stylesheet" href="{{ asset('inovasi/dashboard/form_katsinov/css/formberitaacara.css') }}">
</head>
@extends('Inovasi.registered_user.index')

@section('contentregistered_user')

<header class="header">
    <h1>Berita Acara Pengukuran Tingkat Kesiapan Teknologi</h1>
</header>

<section class="form-section">
    <p>
        Pada hari ini, <input type="text" class="input-inline">,
        tanggal <input type="text" class="input-inline">
        bulan <input type="text" class="input-inline">
        tahun <input type="text" class="input-inline">
        (<input type="text" class="input-inline">),
    </p>
    <p>
        bertempat di <input type="text" class="input-inline">,
        dari hasil pengukuran Tingkat Kesiapan Inovasi (KATSINOV) yang dilakukan oleh Tim yang dibentuk
        berdasarkan Surat Keputusan <input type="text" class="input-inline"> menyatakan:
    </p>
</section>

<!-- Innovation Details Section -->
<section class="form-section">
    <div class="form-row">
        <label class="label">Judul Inovasi</label>
        <input type="text" class="input-field">
    </div>

    <div class="form-row">
        <label class="label">Jenis Inovasi</label>
        <input type="text" class="input-field">
    </div>

    <div class="form-row">
        <label class="label">Nilai TKI</label>
        <input type="text" class="input-field">
    </div>

    <div class="form-row">
        <label class="label">Opini Penilai</label>
        <textarea class="input-field"></textarea>
    </div>
</section>

<!-- Closing Statement -->
<section class="form-section">
    <p>
        Demikian Berita Acara Pengukuran Tingkat Kesiapan Inovasi (KATSINOV) ini dibuat dengan
        sebenar-benarnya,
        kemudian ditutup dan ditandatangani di
        pada <input type="date" class="input-inline date-picker" style="min-width: 180px;">
        pada hari dan tanggal, bulan, tahun tersebut di atas.
    </p>
</section>

<!-- Signature Section -->
<section class="signature-section">
    <div class="signature-box" data-signature-id="penanggung-jawab">
        <h3 class="signature-box-title">Penanggungjawab Inovasi</h3>
        <div class="signature-area"></div>
        <input type="text" class="input-field" placeholder="Nama Lengkap">
        <div class="signature-buttons">
            <button class="signature-btn hapus">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Hapus
            </button>
            <button class="signature-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Upload
            </button>
        </div>
    </div>

    <div class="signature-box" data-signature-id="tim-penilai">
        <h3 class="signature-box-title">Tim Penilai</h3>

        <div data-signature-role="ketua">
            <p class="signature-subtitle">Ketua Tim Penilai</p>
            <div class="signature-area"></div>
            <input type="text" class="input-field" placeholder="Nama Lengkap">
            <div class="signature-buttons">
                <button class="signature-btn hapus">Hapus</button>
                <button class="signature-btn">Upload</button>
            </div>
        </div>

        <div data-signature-role="anggota-1">
            <p class="signature-subtitle">Anggota 1</p>
            <div class="signature-area"></div>
            <input type="text" class="input-field" placeholder="Nama Lengkap">
            <div class="signature-buttons">
                <button class="signature-btn hapus">Hapus</button>
                <button class="signature-btn">Upload</button>
            </div>
        </div>

        <div data-signature-role="anggota-2">
            <p class="signature-subtitle">Anggota 2</p>
            <div class="signature-area"></div>
            <input type="text" class="input-field" placeholder="Nama Lengkap">
            <div class="signature-buttons">
                <button class="signature-btn hapus">Hapus</button>
                <button class="signature-btn">Upload</button>
            </div>
        </div>
    </div>
</section>
<!-- Submit Button Section -->
<section class="form-section" style="text-align: center;">
    <button id="submitBtn" class="submit-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" style="margin-right: 8px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Submit Form
    </button>
</section>
@endsection


{{-- <body>

    <div class="">
        <main class="main-content">
        </main>
    </div>

</body> --}}


<script src="{{ asset('inovasi/dashboard/form_katsinov/js/berita_acara.js') }}"></script>



</html>
