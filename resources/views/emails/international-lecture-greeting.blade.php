<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $greeting->subject }}</title>
    <style>
        body{font-family:Arial,sans-serif;line-height:1.7;color:#1f2937;background:#f3f4f6;margin:0;padding:24px}
        .wrap{max-width:720px;margin:0 auto;background:#fff;border-radius:12px;padding:32px;box-shadow:0 2px 12px rgba(0,0,0,.06)}
        .brand{font-size:18px;font-weight:700;color:#1d4ed8;margin-bottom:24px}
        .message{white-space:normal}
        .footer{margin-top:28px;padding-top:18px;border-top:1px solid #e5e7eb;color:#4b5563}
        .note{margin-top:28px;font-size:11px;color:#9ca3af}
    </style>
</head>
<body>
<div class="wrap">
    <div class="brand">Universitas Negeri Jakarta</div>

    @if($recipientName)
        <p>Dear {{ $recipientName }},</p>
    @else
        <p>Dear International Lecturer,</p>
    @endif

    <div class="message">{!! nl2br(e($greeting->message)) !!}</div>

    <div class="footer">
        Warm regards,<br>
        <strong>Universitas Negeri Jakarta</strong>
    </div>

    <div class="note">International Lecture — Greeting</div>
</div>
</body>
</html>
