<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Universitas Negeri Jakarta QS World University Rankings - Consent Letter</title>
    <!--[if mso]>
    <style type="text/css">
        body, table, td, p, a, li, blockquote {font-family: Arial, Helvetica, sans-serif !important;}
    </style>
    <![endif]-->
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; line-height: 1.6; color: #1e293b;">

    @php
        use App\Models\EmailTemplate;

        $fullname = trim(($bankRespondent->first_name ?? '') . ' ' . ($bankRespondent->last_name ?? ''));
        if (empty($fullname)) {
            $fullname = $bankRespondent->email ?? 'Responden';
        }

        $placeholderData = [
            'title' => $displayTitle ?? '',
            'fullname' => $fullname,
            'surveyLink' => $consentLink,
            'consentLink' => $consentLink,
        ];

        $render = function($text) use ($placeholderData) {
            return EmailTemplate::renderText($text, $placeholderData);
        };

        $isForm = isset($session) && method_exists($session, 'isFormBased') && $session->isFormBased();
        $langMode = $languageMode ?? 'bilingual';

        $btnTextEn = $isForm ? 'Complete Questionnaire & Consent' : ($templateEn->button_text ?? 'I Agree to Participate');
        $btnTextId = $isForm ? 'Isi Formulir & Berikan Persetujuan' : ($templateId->button_text ?? 'Klik disini untuk menyetujui');
    @endphp

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f1f5f9; padding: 30px 15px;">
        <tr>
            <td align="center">
                <!-- Main Card Container -->
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 650px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;">
                    
                    <!-- Official Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #0f766e 0%, #047857 100%); padding: 32px 30px; text-align: center;">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" 
                                 alt="Universitas Negeri Jakarta" 
                                 width="64" 
                                 height="64" 
                                 style="display: block; margin: 0 auto 12px auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">
                            <h1 style="margin: 0; color: #ffffff; font-size: 20px; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase;">
                                UNIVERSITAS NEGERI JAKARTA
                            </h1>
                            <p style="margin: 6px 0 0 0; color: #ccfbf1; font-size: 13px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">
                                QS World University Rankings Campaign
                            </p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 35px 35px 25px 35px;">
                            
                            {{-- Responden Salutation Badge --}}
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 24px; background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px;">
                                <tr>
                                    <td style="padding: 14px 18px;">
                                        <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #166534; font-weight: 700;">
                                            Responden Terhormat / Dear Distinguished Respondent:
                                        </div>
                                        <div style="font-size: 16px; font-weight: 700; color: #0f172a; margin-top: 2px;">
                                            {{ trim(($displayTitle ? $displayTitle . ' ' : '') . $fullname) }}
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            {{-- CONTENT RENDERING BASED ON LANGUAGE MODE AND CATEGORY --}}

                            @if($langMode === 'en')
                                {{-- ENGLISH ONLY --}}
                                @if($templateEn)
                                    <div style="font-size: 15px; color: #1e293b; line-height: 1.7;">
                                        <p style="margin: 0 0 16px 0; font-weight: 600;">{!! $render($templateEn->greeting) !!}</p>
                                        <div style="color: #334155; margin-bottom: 24px;">{!! $render($templateEn->email_content) !!}</div>
                                        
                                        <!-- CTA Button -->
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin: 25px 0;">
                                            <tr>
                                                <td align="center" style="border-radius: 8px; background: #0d9488;">
                                                    <a href="{{ $consentLink }}" target="_blank" 
                                                       style="display: inline-block; padding: 14px 28px; font-size: 15px; font-weight: 700; color: #ffffff; text-decoration: none; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(13, 148, 136, 0.3);">
                                                        {{ $btnTextEn }} &rarr;
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>

                                        <p style="margin: 20px 0 16px 0; color: #334155;">{!! $render($templateEn->closing) !!}</p>
                                        
                                        <div style="border-top: 1px dashed #e2e8f0; padding-top: 16px; margin-top: 20px; font-size: 13px; color: #64748b;">
                                            <strong style="color: #0f172a;">{{ $templateEn->signature_name }}</strong><br>
                                            {!! $templateEn->signature_title !!}
                                        </div>
                                    </div>
                                @endif

                            @elseif($langMode === 'id')
                                {{-- INDONESIAN ONLY --}}
                                @if($templateId)
                                    <div style="font-size: 15px; color: #1e293b; line-height: 1.7;">
                                        <p style="margin: 0 0 16px 0; font-weight: 600;">{!! $render($templateId->greeting) !!}</p>
                                        <div style="color: #334155; margin-bottom: 24px;">{!! $render($templateId->email_content) !!}</div>
                                        
                                        <!-- CTA Button -->
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin: 25px 0;">
                                            <tr>
                                                <td align="center" style="border-radius: 8px; background: #0d9488;">
                                                    <a href="{{ $consentLink }}" target="_blank" 
                                                       style="display: inline-block; padding: 14px 28px; font-size: 15px; font-weight: 700; color: #ffffff; text-decoration: none; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(13, 148, 136, 0.3);">
                                                        {{ $btnTextId }} &rarr;
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>

                                        <p style="margin: 20px 0 16px 0; color: #334155;">{!! $render($templateId->closing) !!}</p>
                                        
                                        <div style="border-top: 1px dashed #e2e8f0; padding-top: 16px; margin-top: 20px; font-size: 13px; color: #64748b;">
                                            <strong style="color: #0f172a;">{{ $templateId->signature_name }}</strong><br>
                                            {!! $templateId->signature_title !!}
                                        </div>
                                    </div>
                                @endif

                            @else
                                {{-- BILINGUAL MODE (EN + ID) --}}
                                @if($normalizedCategory === 'academic')
                                    {{-- Academic: English first, Indonesian second --}}
                                    @if($templateEn)
                                        <div style="font-size: 15px; color: #1e293b; line-height: 1.7;">
                                            <div style="display: inline-block; padding: 3px 10px; background-color: #e0f2fe; color: #0369a1; font-size: 11px; font-weight: 700; border-radius: 20px; margin-bottom: 12px; text-transform: uppercase;">
                                                English Version
                                            </div>
                                            <p style="margin: 0 0 16px 0; font-weight: 600;">{!! $render($templateEn->greeting) !!}</p>
                                            <div style="color: #334155; margin-bottom: 20px;">{!! $render($templateEn->email_content) !!}</div>
                                            
                                            <!-- CTA Button EN -->
                                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin: 20px 0;">
                                                <tr>
                                                    <td align="center" style="border-radius: 8px; background: #0d9488;">
                                                        <a href="{{ $consentLink }}" target="_blank" 
                                                           style="display: inline-block; padding: 13px 26px; font-size: 14px; font-weight: 700; color: #ffffff; text-decoration: none; border-radius: 8px;">
                                                            {{ $btnTextEn }} &rarr;
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>

                                            <p style="margin: 16px 0 12px 0; color: #334155;">{!! $render($templateEn->closing) !!}</p>
                                            <div style="font-size: 13px; color: #64748b; margin-bottom: 25px;">
                                                <strong style="color: #0f172a;">{{ $templateEn->signature_name }}</strong><br>
                                                {!! $templateEn->signature_title !!}
                                            </div>
                                        </div>
                                    @endif

                                    @if($templateId)
                                        <div style="margin: 30px 0 25px 0; border-top: 2px dashed #cbd5e1; position: relative; text-align: center;">
                                            <span style="position: relative; top: -11px; background-color: #ffffff; padding: 2px 14px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px; border-radius: 12px; border: 1px solid #e2e8f0;">
                                                Versi Bahasa Indonesia
                                            </span>
                                        </div>

                                        <div style="font-size: 15px; color: #1e293b; line-height: 1.7;">
                                            <p style="margin: 0 0 16px 0; font-weight: 600;">{!! $render($templateId->greeting) !!}</p>
                                            <div style="color: #334155; margin-bottom: 20px;">{!! $render($templateId->email_content) !!}</div>
                                            
                                            <!-- CTA Button ID -->
                                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin: 20px 0;">
                                                <tr>
                                                    <td align="center" style="border-radius: 8px; background: #047857;">
                                                        <a href="{{ $consentLink }}" target="_blank" 
                                                           style="display: inline-block; padding: 13px 26px; font-size: 14px; font-weight: 700; color: #ffffff; text-decoration: none; border-radius: 8px;">
                                                            {{ $btnTextId }} &rarr;
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>

                                            <p style="margin: 16px 0 12px 0; color: #334155;">{!! $render($templateId->closing) !!}</p>
                                            <div style="font-size: 13px; color: #64748b;">
                                                <strong style="color: #0f172a;">{{ $templateId->signature_name }}</strong><br>
                                                {!! $templateId->signature_title !!}
                                            </div>
                                        </div>
                                    @endif

                                @else
                                    {{-- Employer: Indonesian first, English second --}}
                                    @if($templateId)
                                        <div style="font-size: 15px; color: #1e293b; line-height: 1.7;">
                                            <div style="display: inline-block; padding: 3px 10px; background-color: #ecfdf5; color: #047857; font-size: 11px; font-weight: 700; border-radius: 20px; margin-bottom: 12px; text-transform: uppercase;">
                                                Versi Bahasa Indonesia
                                            </div>
                                            <p style="margin: 0 0 16px 0; font-weight: 600;">{!! $render($templateId->greeting) !!}</p>
                                            <div style="color: #334155; margin-bottom: 20px;">{!! $render($templateId->email_content) !!}</div>
                                            
                                            <!-- CTA Button ID -->
                                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin: 20px 0;">
                                                <tr>
                                                    <td align="center" style="border-radius: 8px; background: #047857;">
                                                        <a href="{{ $consentLink }}" target="_blank" 
                                                           style="display: inline-block; padding: 13px 26px; font-size: 14px; font-weight: 700; color: #ffffff; text-decoration: none; border-radius: 8px;">
                                                            {{ $btnTextId }} &rarr;
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>

                                            <p style="margin: 16px 0 12px 0; color: #334155;">{!! $render($templateId->closing) !!}</p>
                                            <div style="font-size: 13px; color: #64748b; margin-bottom: 25px;">
                                                <strong style="color: #0f172a;">{{ $templateId->signature_name }}</strong><br>
                                                {!! $templateId->signature_title !!}
                                            </div>
                                        </div>
                                    @endif

                                    @if($templateEn)
                                        <div style="margin: 30px 0 25px 0; border-top: 2px dashed #cbd5e1; position: relative; text-align: center;">
                                            <span style="position: relative; top: -11px; background-color: #ffffff; padding: 2px 14px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px; border-radius: 12px; border: 1px solid #e2e8f0;">
                                                English Version
                                            </span>
                                        </div>

                                        <div style="font-size: 15px; color: #1e293b; line-height: 1.7;">
                                            <p style="margin: 0 0 16px 0; font-weight: 600;">{!! $render($templateEn->greeting) !!}</p>
                                            <div style="color: #334155; margin-bottom: 20px;">{!! $render($templateEn->email_content) !!}</div>
                                            
                                            <!-- CTA Button EN -->
                                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin: 20px 0;">
                                                <tr>
                                                    <td align="center" style="border-radius: 8px; background: #0d9488;">
                                                        <a href="{{ $consentLink }}" target="_blank" 
                                                           style="display: inline-block; padding: 13px 26px; font-size: 14px; font-weight: 700; color: #ffffff; text-decoration: none; border-radius: 8px;">
                                                            {{ $btnTextEn }} &rarr;
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>

                                            <p style="margin: 16px 0 12px 0; color: #334155;">{!! $render($templateEn->closing) !!}</p>
                                            <div style="font-size: 13px; color: #64748b;">
                                                <strong style="color: #0f172a;">{{ $templateEn->signature_name }}</strong><br>
                                                {!! $templateEn->signature_title !!}
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endif

                        </td>
                    </tr>

                    <!-- Institutional Safe Sender Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 22px 30px; text-align: center;">
                            <p style="margin: 0 0 6px 0; font-size: 12px; color: #64748b; line-height: 1.5;">
                                Official Email from <strong>Kantor Pemeringkatan & Reputasi Internasional</strong><br>
                                Universitas Negeri Jakarta (UNJ) &bull; Gedung Rektorat UNJ, Rawamangun, Jakarta Timur
                            </p>
                            <p style="margin: 0; font-size: 11px; color: #94a3b8;">
                                Undangan resmi QS akan dikirimkan melalui <strong>rankings@qs.com</strong>. Harap tambahkan ke safe sender list.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
