<?php

namespace Database\Seeders;

use App\Models\InternationalLecturerEmailTemplate;
use Illuminate\Database\Seeder;

class InternationalLecturerEmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        InternationalLecturerEmailTemplate::firstOrCreate(
            ['title' => 'QS Academic Survey Consent', 'is_system' => true],
            [
                'subject' => 'Invitation to participate in the QS Academic Reputation Survey',
                'body' => "Dear {{nama}},\n\nWe are contacting you regarding participation in the QS Academic Reputation Survey on behalf of Universitas Negeri Jakarta.\n\nInstitution: {{universitas_asal}}\nCountry: {{negara}}\nSubject: {{subject_1}}\n\nKindly confirm your willingness to be listed as our academic respondent through the link below.\n\nWarm regards,\nUniversitas Negeri Jakarta",
                'include_consent_button' => true,
                'button_text' => 'Give Consent / Berikan Persetujuan',
                'created_by_name' => 'Admin Pemeringkatan',
                'created_by_email' => 'adminpemeringkatan@gmail.com',
            ]
        );

        InternationalLecturerEmailTemplate::firstOrCreate(
            ['title' => 'Undangan Kuliah Tamu (Guest Lecture)', 'is_system' => true],
            [
                'subject' => 'Invitation for Guest Lecture — Universitas Negeri Jakarta',
                'body' => "Dear {{nama}},\n\nGreetings from Universitas Negeri Jakarta, Indonesia.\n\nOn behalf of {{fakultas}} and {{prodi}}, we would like to invite you from {{universitas_asal}} to deliver a guest lecture session for our students and faculty members in the field of {{bidang_keahlian}}.\n\nWe would be honored by your presence and participation. Please let us know your availability at your earliest convenience.\n\nWarm regards,\nUniversitas Negeri Jakarta",
                'include_consent_button' => false,
                'button_text' => null,
                'created_by_name' => 'Admin Pemeringkatan',
                'created_by_email' => 'adminpemeringkatan@gmail.com',
            ]
        );

        InternationalLecturerEmailTemplate::firstOrCreate(
            ['title' => 'Ucapan Terima Kasih Kolaborasi Akademik', 'is_system' => true],
            [
                'subject' => 'Thank You for Your Academic Collaboration with Universitas Negeri Jakarta',
                'body' => "Dear {{nama}},\n\nOn behalf of Universitas Negeri Jakarta, we would like to express our sincere gratitude for your valuable academic contribution and collaboration with {{prodi}}.\n\nYour expertise and partnership from {{universitas_asal}}, {{negara}}, mean a great deal to our academic community, and we look forward to continuing our fruitful partnership in future academic cycles.\n\nWarm regards,\nUniversitas Negeri Jakarta",
                'include_consent_button' => false,
                'button_text' => null,
                'created_by_name' => 'Admin Pemeringkatan',
                'created_by_email' => 'adminpemeringkatan@gmail.com',
            ]
        );
    }
}
