<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universitas Negeri Jakarta QS World University Ranking - Consent</title>
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
            padding: 12px 30px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin: 15px 0;
            font-weight: bold;
            font-size: 16px;
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
        @php
            $fullname = trim(($bankRespondent->first_name ?? '') . ' ' . ($bankRespondent->last_name ?? ''));
            if (empty($fullname)) {
                $fullname = $bankRespondent->email;
            }
        @endphp

        @php
            $isForm = $session->isFormBased();
            $btnTextEn = $isForm ? 'Complete Questionnaire & Consent' : ($templateEn->button_text ?? 'I Agree to Participate');
            $btnTextId = $isForm ? 'Isi Formulir & Berikan Persetujuan' : ($templateId->button_text ?? 'Klik disini untuk menyetujui');
        @endphp

        @if($normalizedCategory === 'academic')
            {{-- Academic: English first, Indonesian second --}}
            @if($templateEn)
                <p>{!! $templateEn->replacePlaceholders($templateEn->greeting, ['title' => $displayTitle, 'fullname' => $fullname]) !!}</p>
                {!! $templateEn->replacePlaceholders($templateEn->email_content, ['title' => $displayTitle, 'fullname' => $fullname]) !!}
                <a href="{{ $consentLink }}" class="button">{{ $btnTextEn }}</a>
                <p>{!! $templateEn->replacePlaceholders($templateEn->closing, ['title' => $displayTitle, 'fullname' => $fullname]) !!}</p>
                <div class="footer">
                    <strong>{{ $templateEn->signature_name }}</strong><br>
                    {!! $templateEn->signature_title !!}
                </div>
            @else
                <p>Dear {{ $displayTitle }} {{ $fullname }},</p>
                <p>We are writing to you as an important stakeholder of our university. We would like to seek your permission to pass on your contact details to QS for their annual Global Academic Survey.</p>
                <p>Please click the button below to {{ $isForm ? 'complete our survey and register your consent' : 'confirm your participation' }}:</p>
                <a href="{{ $consentLink }}" class="button">{{ $btnTextEn }}</a>
                <p>Many thanks in advance for your cooperation.</p>
            @endif

            @if($templateId)
                <hr>
                <p>{!! $templateId->replacePlaceholders($templateId->greeting, ['title' => $displayTitle, 'fullname' => $fullname]) !!}</p>
                {!! $templateId->replacePlaceholders($templateId->email_content, ['title' => $displayTitle, 'fullname' => $fullname]) !!}
                <a href="{{ $consentLink }}" class="button">{{ $btnTextId }}</a>
                <p>{!! $templateId->replacePlaceholders($templateId->closing, ['title' => $displayTitle, 'fullname' => $fullname]) !!}</p>
                <div class="footer">
                    <strong>{{ $templateId->signature_name }}</strong><br>
                    {!! $templateId->signature_title !!}
                </div>
            @endif
        @else
            {{-- Employee/Employer: Indonesian first, English second --}}
            @if($templateId)
                <p>{!! $templateId->replacePlaceholders($templateId->greeting, ['title' => $displayTitle, 'fullname' => $fullname]) !!}</p>
                {!! $templateId->replacePlaceholders($templateId->email_content, ['title' => $displayTitle, 'fullname' => $fullname]) !!}
                <a href="{{ $consentLink }}" class="button">{{ $btnTextId }}</a>
                <p>{!! $templateId->replacePlaceholders($templateId->closing, ['title' => $displayTitle, 'fullname' => $fullname]) !!}</p>
                <div class="footer">
                    <strong>{{ $templateId->signature_name }}</strong><br>
                    {!! $templateId->signature_title !!}
                </div>
            @else
                <p>Kepada Yth. {{ $fullname }},</p>
                <p>Kami menghubungi Anda sebagai salah satu pemangku kepentingan penting di universitas kami. Kami ingin meminta izin Anda untuk membagikan data kontak Anda kepada QS.</p>
                <p>Silakan klik tombol di bawah ini untuk {{ $isForm ? 'mengisi kuesioner dan memberikan persetujuan' : 'memberikan persetujuan' }}:</p>
                <a href="{{ $consentLink }}" class="button">{{ $btnTextId }}</a>
                <p>Terima kasih atas kerja sama Anda.</p>
            @endif

            @if($templateEn)
                <hr>
                <p>{!! $templateEn->replacePlaceholders($templateEn->greeting, ['title' => $displayTitle, 'fullname' => $fullname]) !!}</p>
                {!! $templateEn->replacePlaceholders($templateEn->email_content, ['title' => $displayTitle, 'fullname' => $fullname]) !!}
                <a href="{{ $consentLink }}" class="button">{{ $btnTextEn }}</a>
                <p>{!! $templateEn->replacePlaceholders($templateEn->closing, ['title' => $displayTitle, 'fullname' => $fullname]) !!}</p>
                <div class="footer">
                    <strong>{{ $templateEn->signature_name }}</strong><br>
                    {!! $templateEn->signature_title !!}
                </div>
            @endif
        @endif
    </div>
</body>
</html>
