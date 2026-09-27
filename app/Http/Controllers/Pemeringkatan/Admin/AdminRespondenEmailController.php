<?php

namespace App\Http\Controllers\Pemeringkatan\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\QsSession;
use App\Models\RespondenBank;
use App\Models\QsSessionRespondent;
use App\Mail\SessionConsentMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AdminRespondenEmailController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        if (!in_array($role, ['admin_direktorat', 'admin_pemeringkatan'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $templates = EmailTemplate::orderBy('category')->orderBy('language')->get();

        $view = $role === 'admin_pemeringkatan' 
            ? 'admin_pemeringkatan.email.index' 
            : 'admin.email.index';

        return view($view, compact('templates'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $role = $user->role;

        if (!in_array($role, ['admin_direktorat', 'admin_pemeringkatan'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $template = EmailTemplate::findOrFail($id);

        // Fetch sibling template of opposite language for paired editing/preview
        $oppositeLang = $template->language === 'en' ? 'id' : 'en';
        $siblingTemplate = EmailTemplate::where('category', $template->category)
            ->where('language', $oppositeLang)
            ->first();

        $view = $role === 'admin_pemeringkatan' 
            ? 'admin_pemeringkatan.email.edit' 
            : 'admin.email.edit';

        return view($view, compact('template', 'siblingTemplate'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $role = $user->role;

        if (!in_array($role, ['admin_direktorat', 'admin_pemeringkatan'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengupdate template.');
        }

        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:500',
            'greeting' => 'required|string',
            'email_content' => 'required|string',
            'button_text' => 'required|string|max:100',
            'closing' => 'required|string',
            'signature_name' => 'required|string|max:255',
            'signature_title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terdapat kesalahan validasi. Silakan periksa form kembali.');
        }

        $template = EmailTemplate::findOrFail($id);
        
        $template->update([
            'subject' => $request->subject,
            'greeting' => $request->greeting,
            'email_content' => $request->email_content,
            'button_text' => $request->button_text,
            'closing' => $request->closing,
            'signature_name' => $request->signature_name,
            'signature_title' => $request->signature_title,
        ]);

        $redirectRoute = $role === 'admin_pemeringkatan' 
            ? 'admin_pemeringkatan.email.index' 
            : 'admin.email.index';

        return redirect()->route($redirectRoute)
            ->with('success', 'Template email berhasil diperbarui!');
    }

    public function reset($id)
    {
        $user = Auth::user();
        $role = $user->role;

        if (!in_array($role, ['admin_direktorat', 'admin_pemeringkatan'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mereset template.');
        }

        $template = EmailTemplate::findOrFail($id);
        $defaults = $this->getDefaultTemplates();
        
        $key = $template->category . '_' . $template->language;
        
        if (isset($defaults[$key])) {
            $template->update($defaults[$key]);
            
            $redirectRoute = $role === 'admin_pemeringkatan' 
                ? 'admin_pemeringkatan.email.index' 
                : 'admin.email.index';

            return redirect()->route($redirectRoute)
                ->with('success', 'Template email berhasil direset ke default!');
        }

        return redirect()->back()->with('error', 'Gagal mereset template.');
    }

    public function preview($id, Request $request)
    {
        $template = EmailTemplate::findOrFail($id);

        $oppositeLang = $template->language === 'en' ? 'id' : 'en';
        $oppositeTemplate = EmailTemplate::where('category', $template->category)
            ->where('language', $oppositeLang)
            ->first();

        $templateEn = $template->language === 'en' ? $template : $oppositeTemplate;
        $templateId = $template->language === 'id' ? $template : $oppositeTemplate;

        $languageMode = $request->query('mode', 'bilingual');

        $dummyBank = (object)[
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'title' => 'Prof. Dr.'
        ];

        $dummySessionRespondent = (object)[
            'category' => $template->category,
            'token' => 'preview-sample-token',
        ];

        return view('emails.session-consent-invitation', [
            'bankRespondent' => $dummyBank,
            'sessionRespondent' => $dummySessionRespondent,
            'session' => null,
            'consentLink' => 'https://unj.ac.id/consent/sample-preview-link',
            'normalizedCategory' => $template->category,
            'displayTitle' => 'Prof. Dr.',
            'templateEn' => $templateEn,
            'templateId' => $templateId,
            'languageMode' => $languageMode,
        ]);
    }

    public function sendTest(Request $request, $id)
    {
        $user = Auth::user();
        $role = $user->role;

        if (!in_array($role, ['admin_direktorat', 'admin_pemeringkatan'])) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        $request->validate([
            'email' => 'required|email',
            'language_mode' => 'nullable|in:bilingual,en,id',
        ]);

        $template = EmailTemplate::findOrFail($id);
        $languageMode = $request->input('language_mode', 'bilingual');

        $dummyBank = new RespondenBank([
            'title' => 'Prof. Dr.',
            'first_name' => 'Test',
            'last_name' => 'Recipient',
            'email' => $request->email,
            'category' => $template->category,
        ]);

        $dummySession = new QsSession([
            'name' => 'Simulasi / Test Sesi QS UNJ',
            'mode' => 'consent_only',
        ]);

        $dummySessionRespondent = new QsSessionRespondent([
            'category' => $template->category,
            'token' => 'test-simulation-token',
        ]);

        try {
            Mail::to($request->email)->send(
                new SessionConsentMail($dummyBank, $dummySessionRespondent, $dummySession, $languageMode)
            );

            return response()->json([
                'success' => true,
                'message' => "Email uji coba berhasil dikirim ke {$request->email}!"
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to send test email: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email uji coba: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getDefaultTemplates()
    {
        return [
            'academic_en' => [
                'subject' => 'Consent Letter for Academic Respondent Universitas Negeri Jakarta QS World University Ranking',
                'greeting' => 'Dear {title} {fullname},',
                'email_content' => '<p>We are writing to you as an important stakeholder of Universitas Negeri Jakarta (UNJ). We value our ongoing engagement with you and would like to be certain that we are not using your information for any purpose that you would prefer us not to.</p><p>For the purposes of an important global survey of academic opinion, we would like to seek your permission to pass on your contact details (name, job title, institution and email address) to QS. We feel that your impartial responses would contribute to the insight and precision of the survey\'s outcomes.</p><p>If you agree, you should be contacted by QS in the next few months with an invitation to participate in the annual <strong>QS Global Academic Survey</strong>, along with a maximum of three reminders. Their email will come from <strong>rankings@qs.com</strong>; please add to your safe senders and check your spam.</p><p>The resulting data will be used in aggregate form only. QS will not contact you for any other reason without supplementary consent. Your responses will be combined with those of many others around the world to form academic reputation indicators used in the QS World University Rankings.</p><p>Please confirm your consent by clicking the button below:</p>',
                'button_text' => 'Click here to fill out the consent letter',
                'closing' => 'Many thanks in advance for your cooperation.',
                'signature_name' => 'Dr. RA Murti Kusuma W. S.IP, M.Si',
                'signature_title' => 'Director of Innovation, Downstreaming, Information System, and Rankings<br>Universitas Negeri Jakarta, Indonesia',
            ],
            'academic_id' => [
                'subject' => 'Surat Persetujuan untuk Responden Akademik Universitas Negeri Jakarta QS World University Ranking',
                'greeting' => 'Kepada Yth. Bapak/Ibu {fullname},',
                'email_content' => '<p>Kami menghubungi Anda sebagai salah satu pemangku kepentingan penting di Universitas Negeri Jakarta (UNJ). Kami sangat menghargai hubungan baik yang telah terjalin dan ingin memastikan bahwa informasi Anda hanya digunakan dengan izin Anda.</p><p>Saat ini, kami ingin meminta izin Anda untuk membagikan data kontak Anda (nama, jabatan, institusi, dan email) kepada QS untuk keperluan survei global tentang pendapat akademik. Kami percaya tanggapan Anda yang jujur akan membantu meningkatkan kualitas hasil survei ini.</p><p>Jika Anda setuju, QS akan mengirimkan undangan kepada Anda dalam beberapa bulan mendatang untuk berpartisipasi dalam <strong>QS Global Academic Survey</strong> tahunan, dengan maksimal tiga pengingat. Email dari QS akan dikirim melalui <strong>rankings@qs.com</strong>, jadi harap tambahkan email ini ke daftar aman Anda dan cek folder spam jika diperlukan.</p><p>Data Anda hanya akan digunakan secara agregat dan tidak akan digunakan untuk keperluan lain tanpa persetujuan tambahan. Hasil survei akan digunakan untuk menyusun indikator reputasi akademik dalam QS World University Rankings di tingkat global, regional, subjek, dan program.</p><p>Untuk berpartisipasi dalam survei, silakan klik tombol di bawah ini:</p>',
                'button_text' => 'Klik disini untuk mengisi consent letter',
                'closing' => 'Terima kasih atas kerja sama Anda.',
                'signature_name' => 'Dr. RA Murti Kusuma W. S.IP, M.Si',
                'signature_title' => 'Direktur Inovasi, Hilirisasi, Sistem Informasi, dan Pemeringkatan<br>Universitas Negeri Jakarta, Indonesia',
            ],
            'employee_en' => [
                'subject' => 'Consent Letter for Employer Respondent Universitas Negeri Jakarta QS World University Ranking',
                'greeting' => 'Dear {title} {fullname},',
                'email_content' => '<p>We are writing to you as an important employer stakeholder of Universitas Negeri Jakarta (UNJ). We value our ongoing engagement with you and would like to be certain that we are not using your information for any purpose that you would prefer us not to.</p><p>For the purposes of an important global survey of employer opinion, we would like to seek your permission to pass on your contact details (name, job title, company/institution and email address) to QS. We feel that your impartial responses would contribute to the insight and precision of the survey\'s outcomes.</p><p>If you agree, you should be contacted by QS in the next few months with an invitation to participate in the annual <strong>QS Global Employer Survey</strong>, along with a maximum of three reminders. Their email will come from <strong>rankings@qs.com</strong>; please add to your safe senders and check your spam.</p><p>The resulting data will be used in aggregate form only. QS will not contact you for any other reason without supplementary consent. Your responses will be combined with those of many others around the world to form employer reputation indicators used in the QS World University Rankings.</p><p>Please confirm your consent by clicking the button below:</p>',
                'button_text' => 'Click here to fill out the consent letter',
                'closing' => 'Many thanks in advance for your cooperation.',
                'signature_name' => 'Dr. RA Murti Kusuma W. S.IP, M.Si',
                'signature_title' => 'Director of Innovation, Downstreaming, Information System, and Rankings<br>Universitas Negeri Jakarta, Indonesia',
            ],
            'employee_id' => [
                'subject' => 'Surat Persetujuan untuk Responden Pemberi Kerja Universitas Negeri Jakarta QS World University Ranking',
                'greeting' => 'Kepada Yth. Bapak/Ibu {fullname},',
                'email_content' => '<p>Kami menghubungi Anda sebagai salah satu mitra pemberi kerja penting di Universitas Negeri Jakarta (UNJ). Kami sangat menghargai hubungan baik yang telah terjalin dan ingin memastikan bahwa informasi Anda hanya digunakan dengan izin Anda.</p><p>Saat ini, kami ingin meminta izin Anda untuk membagikan data kontak Anda (nama, jabatan, institusi/perusahaan, dan email) kepada QS untuk keperluan survei global tentang pendapat pemberi kerja. Kami percaya tanggapan Anda yang jujur akan membantu meningkatkan kualitas hasil survei ini.</p><p>Jika Anda setuju, QS akan mengirimkan undangan kepada Anda dalam beberapa bulan mendatang untuk berpartisipasi dalam <strong>QS Global Employer Survey</strong> tahunan, dengan maksimal tiga pengingat. Email dari QS akan dikirim melalui <strong>rankings@qs.com</strong>, jadi harap tambahkan email ini ke daftar aman Anda dan cek folder spam jika diperlukan.</p><p>Data Anda hanya akan digunakan secara agregat dan tidak akan digunakan untuk keperluan lain tanpa persetujuan tambahan. Hasil survei akan digunakan untuk menyusun indikator reputasi pemberi kerja dalam QS World University Rankings.</p><p>Untuk berpartisipasi dalam survei, silakan klik tombol di bawah ini:</p>',
                'button_text' => 'Klik disini untuk mengisi consent letter',
                'closing' => 'Terima kasih atas kerja sama Anda.',
                'signature_name' => 'Dr. RA Murti Kusuma W. S.IP, M.Si',
                'signature_title' => 'Direktur Inovasi, Hilirisasi, Sistem Informasi, dan Pemeringkatan<br>Universitas Negeri Jakarta, Indonesia',
            ],
        ];
    }
}
