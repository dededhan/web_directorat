<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Universitas Negeri Jakarta QS World University Rankings - Consent Letter</title>
    <style>
        body{font-family:Arial,sans-serif;line-height:1.65;color:#1f2937;background:#f3f4f6;margin:0;padding:24px}
        .wrap{max-width:720px;margin:0 auto;background:#fff;border-radius:12px;padding:32px;box-shadow:0 2px 12px rgba(0,0,0,.06)}
        .button{display:inline-block;padding:12px 20px;background:#2563eb;color:#fff!important;text-decoration:none;border-radius:7px;font-weight:600}
        .footer{margin-top:28px;padding-top:18px;border-top:1px solid #e5e7eb}
        hr{border:0;border-top:1px solid #e5e7eb;margin:28px 0}
        .note{font-size:12px;color:#6b7280}
    </style>
</head>
<body>
<div class="wrap">
    @php
        $data = ['title' => $displayTitle, 'fullname' => $lecturer->nama, 'surveyLink' => $consentLink];
    @endphp

    @if(in_array($languageMode, ['bilingual','en']))
        @if($templateEn)
            <p>{!! $templateEn->replacePlaceholders($templateEn->greeting, $data) !!}</p>
            {!! $templateEn->replacePlaceholders($templateEn->email_content, $data) !!}
            <a href="{{ $consentLink }}" class="button">{{ $templateEn->button_text }}</a>
            <p>{!! $templateEn->replacePlaceholders($templateEn->closing, $data) !!}</p>
            <div class="footer">
                Kind regards,<br>
                <strong>{{ $templateEn->signature_name }}</strong><br>
                {!! $templateEn->signature_title !!}
            </div>
        @endif
    @endif

    @if($languageMode === 'bilingual')
        <hr>
    @endif

    @if(in_array($languageMode, ['bilingual','id']))
        @if($templateId)
            <p>{!! $templateId->replacePlaceholders($templateId->greeting, $data) !!}</p>
            {!! $templateId->replacePlaceholders($templateId->email_content, $data) !!}
            <a href="{{ $consentLink }}" class="button">{{ $templateId->button_text }}</a>
            <p>{!! $templateId->replacePlaceholders($templateId->closing, $data) !!}</p>
            <div class="footer">
                Hormat kami,<br>
                <strong>{{ $templateId->signature_name }}</strong><br>
                {!! $templateId->signature_title !!}
            </div>
        @endif
    @endif

    <p class="note">This message uses the Academic Respondent email template configured in the UNJ QS system.</p>
</div>
</body>
</html>
