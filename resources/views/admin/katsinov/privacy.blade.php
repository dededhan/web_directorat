<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pernyataan Kerahasiaan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        /* Sedikit style tambahan agar konten di tengah */
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1rem 0;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Pernyataan Kerahasiaan dan Integritas</h4>
                </div>
                <div class="card-body">
                    <p>Sebelum melanjutkan ke halaman penilaian, Anda harus membaca, memahami, dan menyetujui poin-poin berikut:</p>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item">
                            <i class='bx bxs-shield-x' style='color:#ff0000; vertical-align: middle;'></i>
                            <strong>DILARANG KERAS</strong> mengambil tangkapan layar (screenshot), memfoto, atau merekam dalam bentuk apapun seluruh atau sebagian isi dari halaman penilaian.
                        </li>
                        <li class="list-group-item">
                            <i class='bx bxs-shield-x' style='color:#ff0000; vertical-align: middle;'></i>
                            <strong>DILARANG KERAS</strong> mengubah, memanipulasi, atau menyalin isian, data, maupun informasi yang ditampilkan.
                        </li>
                        <li class="list-group-item">
                            <i class='bx bxs-shield-x' style='color:#ff0000; vertical-align: middle;'></i>
                            <strong>DILARANG KERAS</strong> menyebarluaskan informasi, data, dokumen, atau konten apapun dari halaman penilaian kepada pihak yang tidak berwenang.
                        </li>
                    </ul>

                    <h5>Konsekuensi Hukum</h5>
                    <p>
                        Seluruh data yang akan Anda akses bersifat <strong>RAHASIA</strong> dan dilindungi oleh undang-undang yang berlaku di Indonesia, termasuk namun tidak terbatas pada <strong>Undang-Undang No. 27 Tahun 2022 tentang Pelindungan Data Pribadi (UU PDP)</strong> dan <strong>Undang-Undang No. 19 Tahun 2016 tentang Informasi dan Transaksi Elektronik (UU ITE)</strong>. Pelanggaran terhadap poin-poin di atas dapat dikenakan sanksi.
                    </p>
                    <hr>

                    <p class="fw-bold">Dengan membubuhkan tanda tangan di bawah ini, saya menyatakan telah membaca, memahami, dan setuju untuk mematuhi seluruh ketentuan di atas.</p>

                    {{-- Area Tanda Tangan --}}
                    <div id="signature-pad-container" style="border: 2px dashed #ccc; border-radius: 5px; touch-action: none;">
                        <canvas id="signature-canvas" style="width: 100%; height: 200px; cursor: crosshair;"></canvas>
                    </div>
                    <button id="clear-signature" class="btn btn-secondary btn-sm mt-2">Ulangi Tanda Tangan</button>

                    <div class="text-center mt-4">
                        <a id="proceed-button" href="{{ route('admin.katsinov.show', $katsinov->id) }}" class="btn btn-primary btn-lg disabled" aria-disabled="true">
                            Lanjutkan ke Penilaian
                        </a>
                        <small id="signature-alert" class="d-block mt-2 text-danger">
                            * Anda harus menandatangani di atas untuk melanjutkan.
                        </small>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Memuat library Signature Pad dari CDN --}}
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const canvas = document.getElementById('signature-canvas');
        const proceedButton = document.getElementById('proceed-button');
        const clearButton = document.getElementById('clear-signature');
        const signatureAlert = document.getElementById('signature-alert');
        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)'
        });

        function resizeCanvas() {
            const ratio =  Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear();
        }
        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();

        signaturePad.addEventListener("beginStroke", () => {
            proceedButton.classList.remove('disabled');
            proceedButton.setAttribute('aria-disabled', 'false');
            signatureAlert.style.display = 'none';
        });

        clearButton.addEventListener('click', function (event) {
            event.preventDefault();
            signaturePad.clear();
            proceedButton.classList.add('disabled');
            proceedButton.setAttribute('aria-disabled', 'true');
            signatureAlert.style.display = 'block';
        });
    });
</script>

</body>
</html>