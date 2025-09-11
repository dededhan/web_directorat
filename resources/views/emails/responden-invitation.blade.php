<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universitas Negeri Jakarta QS World University Ranking Survey</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin: 15px 0;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #555;
        }
        hr {
            border: 0;
            border-top: 1px solid #eeeeee;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">

        @if($responden->category == 'academic')

            {{-- londong --}}
            <p>Dear {{ $responden->title }}. {{ $responden->fullname }},</p>
            <p>
                We are writing to you as an important stakeholder of our university. We value our ongoing engagement with you and would like to be certain that we are not using your information for any purpose that you would prefer us not to. For the purposes of an important global survey of academic opinion, we would like to seek your permission to pass on your contact details (name, job title, institution and email address) to the QS. We feel that your impartial responses would contribute to the insight and precision of the survey’s outcomes.
            </p>
            <p>
                If you agree, you should be contacted by QS in the next few months with an invitation to participate in the annual <strong>QS Global Academic Survey</strong>, along with a maximum of three reminders. Their email will come from <strong>rankings@qs.com</strong>; please add to your safe senders and check your spam.
            </p>
            <p>
                The resulting data will be used in aggregate form only. QS will not contact you for any other reason, or for more than two editions of their annual survey, without supplementary or separate consent. Your responses will be combined with those of many others around the world to form academic reputation indicators used in the QS World University Rankings at global, regional, subject and program levels where relevant.
            </p>
            <p>
                To participate in the survey, please click the button below:
            </p>
            <a href="{{ $surveyLink }}" class="button">Click here to fill out the survey</a>
            <p>
                Many thanks in advance for your cooperation.
            </p>
            <div class="footer">
                Kind regards,<br>
                <strong>Dr. RA Murti Kusuma W. S.IP, M.Si</strong><br>
                Director of Innovation, Downstreaming, Information System, and Rankings<br>
                Universitas Negeri Jakarta, Indonesia
            </div>

            <hr>

            {{-- indo --}}
            <p>Kepada Yth. Bapak/Ibu {{ $responden->fullname }},</p>
            <p>
                Kami menghubungi Anda sebagai salah satu pemangku kepentingan penting di universitas kami. Kami sangat menghargai hubungan baik yang telah terjalin dan ingin memastikan bahwa informasi Anda hanya digunakan dengan izin Anda.
            </p>
            <p>
                Saat ini, kami ingin meminta izin Anda untuk membagikan data kontak Anda (nama, jabatan, institusi, dan email) kepada QS untuk keperluan survei global tentang pendapat akademik. Kami percaya tanggapan Anda yang jujur akan membantu meningkatkan kualitas hasil survei ini.
            </p>
            <p>
                Jika Anda setuju, QS akan mengirimkan undangan kepada Anda dalam beberapa bulan mendatang untuk berpartisipasi dalam <strong>QS Global Academic Survey</strong> tahunan, dengan maksimal tiga pengingat. Email dari QS akan dikirim melalui <strong>rankings@qs.com</strong>, jadi harap tambahkan email ini ke daftar aman Anda dan cek folder spam jika diperlukan.
            </p>
             <p>
                Data Anda hanya akan digunakan secara agregat dan tidak akan digunakan untuk keperluan lain tanpa persetujuan tambahan. Hasil survei akan digunakan untuk menyusun indikator reputasi akademik dalam QS World University Rankings di tingkat global, regional, subjek, dan program.
            </p>
            <p>
                Untuk berpartisipasi dalam survei, silakan klik tombol di bawah ini:
            </p>
            <a href="{{ $surveyLink }}" class="button">Klik di sini untuk mengisi survei</a>
            <p>
                Terima kasih atas kerja sama Anda.
            </p>
            <div class="footer">
                Hormat kami,<br>
                <strong>Dr. RA Murti Kusuma W. S.IP, M.Si</strong><br>
                Direktur Inovasi, Hilirisasi, Sistem Informasi, dan Pemeringkatan<br>
                Universitas Negeri Jakarta, Indonesia
            </div>


        @elseif($responden->category == 'employer')

            {{-- lodnong --}}
            <p>Dear {{ $responden->title }}. {{ $responden->fullname }},</p>
            <p>
                We are writing to you as an important stakeholder of our university. We value our ongoing engagement with you and would like to be certain that we are not using your information for any purpose that you would prefer us not to. For the purposes of an important global survey of employer opinion, we would like to seek your permission to pass on your contact details (name, job title, institution and email address) to the QS. We feel that your impartial responses would contribute to the insight and precision of the survey’s outcomes.
            </p>
            <p>
                If you agree, you should be contacted by QS in the next few months with an invitation to participate in the annual <strong>QS Global Employer Survey</strong>, along with a maximum of three reminders. Their email will come from <strong>rankings@qs.com</strong>; please add to your safe senders and check your spam.
            </p>
            <p>
                The resulting data will be used in aggregate form only. QS will not contact you for any other reason, or for more than two editions of their annual survey, without supplementary or separate consent. Your responses will be combined with those of many others around the world to form employer reputation indicators used in the QS World University Rankings at global, regional, subject and program levels where relevant.
            </p>
            <p>
                To participate in the survey, please click the button below:
            </p>
            <a href="{{ $surveyLink }}" class="button">Click here to fill out the survey</a>
            <p>
                Many thanks in advance for your cooperation.
            </p>
             <div class="footer">
                Kind regards,<br>
                <strong>Dr. RA Murti Kusuma W. S.IP, M.Si</strong><br>
                Director of Innovation, Downstreaming, Information System, and Rankings<br>
                Universitas Negeri Jakarta, Indonesia
            </div>

            <hr>

            {{-- indo --}}
            <p>Kepada Yth. Bapak/Ibu {{ $responden->fullname }},</p>
            <p>
                Kami menghubungi Anda sebagai salah satu pemangku kepentingan penting di universitas kami. Kami sangat menghargai hubungan baik yang telah terjalin dan ingin memastikan bahwa informasi Anda hanya digunakan dengan izin Anda.
            </p>
            <p>
                Saat ini, kami ingin meminta izin Anda untuk membagikan data kontak Anda (nama, jabatan, institusi, dan email) kepada QS untuk keperluan survei global tentang pendapat pemberi kerja. Kami percaya tanggapan Anda yang jujur akan membantu meningkatkan kualitas hasil survei ini.
            </p>
            <p>
                Jika Anda setuju, QS akan mengirimkan undangan kepada Anda dalam beberapa bulan mendatang untuk berpartisipasi dalam <strong>QS Global Employer Survey</strong> tahunan, dengan maksimal tiga pengingat. Email dari QS akan dikirim melalui <strong>rankings@qs.com</strong>, jadi harap tambahkan email ini ke daftar aman Anda dan cek folder spam jika diperlukan.
            </p>
            <p>
                Data Anda hanya akan digunakan secara agregat dan tidak akan digunakan untuk keperluan lain tanpa persetujuan tambahan. Hasil survei akan digunakan untuk menyusun indikator reputasi pemberi kerja dalam QS World University Rankings di tingkat global, regional, subjek, dan program.
            </p>
            <p>
                Untuk berpartisipasi dalam survei, silakan klik tombol di bawah ini:
            </p>
            <a href="{{ $surveyLink }}" class="button">Klik di sini untuk mengisi survei</a>
            <p>
                Terima kasih atas kerja sama Anda.
            </p>
            <div class="footer">
                Hormat kami,<br>
                <strong>Dr. RA Murti Kusuma W. S.IP, M.Si</strong><br>
                Direktur Inovasi, Hilirisasi, Sistem Informasi, dan Pemeringkatan<br>
                Universitas Negeri Jakarta, Indonesia
            </div>

        @endif
    </div>
</body>
</html>
