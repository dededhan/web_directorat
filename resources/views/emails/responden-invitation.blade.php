<!DOCTYPE html>
<html>
<head>
    <title>Undangan Pengisian Survei QS</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3490dc;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <p>Yth. Bapak/Ibu {{ $responden->fullname ?? '' }},</p>
    
    <p>
        Kami mengundang Anda untuk berpartisipasi dalam survei QS Ranking.
        Partisipasi Anda sangat berarti bagi kami.
    </p>
    
    @isset($surveyLink)
        <p>Silakan klik tautan di bawah ini untuk mengisi survei:</p>
        <a href="{{ $surveyLink }}" class="button">
            Klik di sini untuk mengisi survei
        </a>
    @else
        <p style="color: red;">
            Maaf, terjadi kesalahan dalam menghasilkan tautan survei. 
            Silakan hubungi administrator.
        </p>
    @endisset

    <p>
        Terima kasih atas perhatian dan partisipasinya.
    </p>
    
    <p>
        Hormat kami,<br>
        Tim Pemeringkatan
    </p>
</body>
</html>