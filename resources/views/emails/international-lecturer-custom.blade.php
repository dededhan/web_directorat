<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Universitas Negeri Jakarta</title>
    <style>
        body{font-family:Arial,sans-serif;line-height:1.65;color:#1f2937;background:#f3f4f6;margin:0;padding:24px}
        .wrap{max-width:720px;margin:0 auto;background:#fff;border-radius:12px;padding:32px;box-shadow:0 2px 12px rgba(0,0,0,.06)}
        .button{display:inline-block;padding:12px 20px;background:#2563eb;color:#fff!important;text-decoration:none;border-radius:7px;font-weight:600}
        .actions{margin-top:24px}
        .email-photo-wrap{text-align:center;margin-bottom:24px}
        .email-photo-wrap img{max-width:100%;height:auto;display:inline-block;border-radius:8px}
    </style>
</head>
<body>
<div class="wrap">
    @if(!empty($inlinePhotoPath) && file_exists($inlinePhotoPath))
        <div class="email-photo-wrap">
            <img src="{{ $message->embed($inlinePhotoPath) }}" alt="Email Photo">
        </div>
    @endif

    <div>{!! $bodyHtml !!}</div>

    @if($includeConsentButton)
        <div class="actions">
            <a href="{{ $consentLink }}" class="button">{{ $buttonText }}</a>
        </div>
    @endif
</div>
</body>
</html>
