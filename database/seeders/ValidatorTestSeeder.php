<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\InnovatorForm;
use Illuminate\Support\Facades\Hash;

class ValidatorTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Validator User
        $validator = User::firstOrCreate(
            ['email' => 'validator@test.com'],
            [
                'name' => 'Test Validator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        echo "✓ Validator created: {$validator->name} (ID: {$validator->id})\n";

        // Create Dosen User
        $dosen = User::firstOrCreate(
            ['email' => 'dosen@test.com'],
            [
                'name' => 'Test Dosen',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        echo "✓ Dosen created: {$dosen->name} (ID: {$dosen->id})\n";

        // Create Test Form
        $formId = \DB::table('innovator_forms')->insertGetId([
            'judul_inovasi' => 'Test Inovasi Validator V2',
            'nama_penanggungjawab' => $dosen->name,
            'nama_program' => 'Program Test',
            'institusi' => 'UNJ Test',
            'alamat_kontak' => 'Jakarta',
            'phone' => '08123456789',
            'fax' => '-',
            'jenis_inovasi' => 'Teknologi',
            'bidang_inovasi' => 'Pendidikan',
            'aplikasi_manfaat' => 'Test aplikasi',
            'lama_program' => '1 tahun',
            'tahun_berjalan' => '2025',
            'ringkasan_inovasi' => 'Test inovasi untuk validator V2',
            'kebaruan' => 'Inovasi baru',
            'keunggulan' => 'Keunggulan test',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $form = InnovatorForm::find($formId);

        echo "✓ Form created: {$form->judul_inovasi} (ID: {$form->id})\n";

        // Assign Validator to Form
        $existingAssignment = \DB::table('form_validator_assignments')
            ->where('form_id', $form->id)
            ->where('validator_id', $validator->id)
            ->exists();

        if (!$existingAssignment) {
            \DB::table('form_validator_assignments')->insert([
                'form_id' => $form->id,
                'validator_id' => $validator->id,
                'assigned_at' => now(),
                'assigned_by' => $dosen->id,
            ]);
            echo "✓ Validator assigned to form\n";
        } else {
            echo "✓ Validator already assigned to form\n";
        }

        echo "\n";
        echo "=====================================\n";
        echo "TEST CREDENTIALS:\n";
        echo "=====================================\n";
        echo "Validator:\n";
        echo "  Email: validator@test.com\n";
        echo "  Password: password\n";
        echo "\n";
        echo "Dosen:\n";
        echo "  Email: dosen@test.com\n";
        echo "  Password: password\n";
        echo "\n";
        echo "Form ID: {$form->id}\n";
        echo "=====================================\n";
    }
}
