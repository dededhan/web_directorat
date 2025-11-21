<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;

class EmailTemplateSeeder extends Seeder
{

    public function run(): void
    {
        
        $templates = [
            [
                'category' => 'academic',
                'language' => 'en',
                'subject' => 'Consent Letter for Academic Respondent Universitas Negeri Jakarta QS World University Ranking',
                'greeting' => 'Dear {title} {fullname},',
                'email_content' => '<p>We are writing to you as an important stakeholder of our university. We value our ongoing engagement with you and would like to be certain that we are not using your information for any purpose that you would prefer us not to. For the purposes of an important global survey of academic opinion, we would like to seek your permission to pass on your contact details (name, job title, institution and email address) to QS. We feel that your impartial responses would contribute to the insight and precision of the survey\'s outcomes.</p><p>If you agree, you should be contacted by QS in the next few months with an invitation to participate in the annual <strong>QS Global Academic Survey</strong>, along with a maximum of three reminders. Their email will come from <strong>rankings@qs.com</strong>; please add to your safe senders and check your spam.</p><p>The resulting data will be used in aggregate form only. QS will not contact you for any other reason, or for more than two editions of their annual survey, without supplementary or separate consent. Your responses will be combined with those of many others around the world to form academic reputation indicators used in the QS World University Rankings at global, regional, subject and program levels where relevant.</p><p>If we do not receive a response from you by November 14, 2025, we will assume that consent is not given for your contact details to be shared.</p><p>To participate in the survey, please click the button below:</p>',
                'button_text' => 'Click here to fill out the consent letter',
                'closing' => 'Many thanks in advance for your cooperation.',
                'signature_name' => 'Dr. RA Murti Kusuma W. S.IP, M.Si',
                'signature_title' => 'Director of Innovation, Downstreaming, Information System, and Rankings<br>Universitas Negeri Jakarta, Indonesia',
            ],
        
            [
                'category' => 'academic',
                'language' => 'id',
                'subject' => 'Surat Persetujuan untuk Responden Akademik Universitas Negeri Jakarta QS World University Ranking',
                'greeting' => 'Kepada Yth. Bapak/Ibu {fullname},',
                'email_content' => '<p>Kami menghubungi Anda sebagai salah satu pemangku kepentingan penting di universitas kami. Kami sangat menghargai hubungan baik yang telah terjalin dan ingin memastikan bahwa informasi Anda hanya digunakan dengan izin Anda.</p><p>Saat ini, kami ingin meminta izin Anda untuk membagikan data kontak Anda (nama, jabatan, institusi, dan email) kepada QS untuk keperluan survei global tentang pendapat akademik. Kami percaya tanggapan Anda yang jujur akan membantu meningkatkan kualitas hasil survei ini.</p><p>Jika Anda setuju, QS akan mengirimkan undangan kepada Anda dalam beberapa bulan mendatang untuk berpartisipasi dalam <strong>QS Global Academic Survey</strong> tahunan, dengan maksimal tiga pengingat. Email dari QS akan dikirim melalui <strong>rankings@qs.com</strong>, jadi harap tambahkan email ini ke daftar aman Anda dan cek folder spam jika diperlukan.</p><p>Data Anda hanya akan digunakan secara agregat dan tidak akan digunakan untuk keperluan lain tanpa persetujuan tambahan. Hasil survei akan digunakan untuk menyusun indikator reputasi akademik dalam QS World University Rankings di tingkat global, regional, subjek, dan program.</p><p>Apabila kami tidak menerima tanggapan dari Anda sebelum 14 November 2025, kami akan menganggap Anda tidak memberikan persetujuan untuk membagikan data kontak Anda.</p><p>Untuk berpartisipasi dalam survei, silakan klik tombol di bawah ini:</p>',
                'button_text' => 'Klik disini untuk mengisi consent letter',
                'closing' => 'Terima kasih atas kerja sama Anda.',
                'signature_name' => 'Dr. RA Murti Kusuma W. S.IP, M.Si',
                'signature_title' => 'Direktur Inovasi, Hilirisasi, Sistem Informasi, dan Pemeringkatan<br>Universitas Negeri Jakarta, Indonesia',
            ],
            
            [
                'category' => 'employee',
                'language' => 'en',
                'subject' => 'Consent Letter for Employee Respondent Universitas Negeri Jakarta QS World University Ranking',
                'greeting' => 'Dear {title} {fullname},',
                'email_content' => '<p>We are writing to you as an important stakeholder of our university. We value our ongoing engagement with you and would like to be certain that we are not using your information for any purpose that you would prefer us not to. For the purposes of an important global survey of employer opinion, we would like to seek your permission to pass on your contact details (name, job title, institution and email address) to the QS. We feel that your impartial responses would contribute to the insight and precision of the survey\'s outcomes.</p><p>If you agree, you should be contacted by QS in the next few months with an invitation to participate in the annual <strong>QS Global Employer Survey</strong>, along with a maximum of three reminders. Their email will come from <strong>rankings@qs.com</strong>; please add to your safe senders and check your spam.</p><p>The resulting data will be used in aggregate form only. QS will not contact you for any other reason, or for more than two editions of their annual survey, without supplementary or separate consent. Your responses will be combined with those of many others around the world to form employer reputation indicators used in the QS World University Rankings at global, regional, subject and program levels where relevant.</p><p>If we do not receive a response from you by November 14, 2025, we will assume that consent is not given for your contact details to be shared.</p><p>To participate in the survey, please click the button below:</p>',
                'button_text' => 'Click here to fill out the consent letter',
                'closing' => 'Many thanks in advance for your cooperation.',
                'signature_name' => 'Dr. RA Murti Kusuma W. S.IP, M.Si',
                'signature_title' => 'Director of Innovation, Downstreaming, Information System, and Rankings<br>Universitas Negeri Jakarta, Indonesia',
            ],
            
            [
                'category' => 'employee',
                'language' => 'id',
                'subject' => 'Surat Persetujuan untuk Responden Pemberi Kerja Universitas Negeri Jakarta QS World University Ranking',
                'greeting' => 'Kepada Yth. Bapak/Ibu {fullname},',
                'email_content' => '<p>Kami menghubungi Anda sebagai salah satu pemangku kepentingan penting di universitas kami. Kami sangat menghargai hubungan baik yang telah terjalin dan ingin memastikan bahwa informasi Anda hanya digunakan dengan izin Anda.</p><p>Saat ini, kami ingin meminta izin Anda untuk membagikan data kontak Anda (nama, jabatan, institusi, dan email) kepada QS untuk keperluan survei global tentang pendapat pemberi kerja. Kami percaya tanggapan Anda yang jujur akan membantu meningkatkan kualitas hasil survei ini.</p><p>Jika Anda setuju, QS akan mengirimkan undangan kepada Anda dalam beberapa bulan mendatang untuk berpartisipasi dalam <strong>QS Global Employer Survey</strong> tahunan, dengan maksimal tiga pengingat. Email dari QS akan dikirim melalui <strong>rankings@qs.com</strong>, jadi harap tambahkan email ini ke daftar aman Anda dan cek folder spam jika diperlukan.</p><p>Data Anda hanya akan digunakan secara agregat dan tidak akan digunakan untuk keperluan lain tanpa persetujuan tambahan. Hasil survei akan digunakan untuk menyusun indikator reputasi pemberi kerja dalam QS World University Rankings di tingkat global, regional, subjek, dan program.</p><p>Apabila kami tidak menerima tanggapan dari Anda sebelum 14 November 2025, kami akan menganggap Anda tidak memberikan persetujuan untuk membagikan data kontak Anda.</p><p>Untuk berpartisipasi dalam survei, silakan klik tombol di bawah ini:</p>',
                'button_text' => 'Klik disini untuk mengisi consent letter',
                'closing' => 'Terima kasih atas kerja sama Anda.',
                'signature_name' => 'Dr. RA Murti Kusuma W. S.IP, M.Si',
                'signature_title' => 'Direktur Inovasi, Hilirisasi, Sistem Informasi, dan Pemeringkatan<br>Universitas Negeri Jakarta, Indonesia',
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::updateOrCreate(
                [
                    'category' => $template['category'],
                    'language' => $template['language'],
                ],
                $template
            );
        }

        $this->command->info('Email templates seeded successfully!');
    }
}
