<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dosen_internasionals', function (Blueprint $table) {
            $table->string('jenis_kelamin')->nullable()->after('nama');
            $table->string('jabatan')->nullable()->after('jenis_kelamin');
            $table->string('email')->nullable()->after('universitas_asal')->index();
            $table->string('subject_1')->nullable()->after('email');
            $table->string('subject_2')->nullable()->after('subject_1');
            $table->string('email_status')->default('not_sent')->after('subject_2');
            $table->timestamp('email_sent_at')->nullable()->after('email_status');
            $table->text('email_error')->nullable()->after('email_sent_at');
        });

        Schema::table('aktivitas_dosen_asing', function (Blueprint $table) {
            $table->foreignId('dosen_internasional_id')
                ->nullable()
                ->after('id')
                ->constrained('dosen_internasionals')
                ->nullOnDelete();
            $table->string('jenis_kegiatan')->nullable()->after('judul');
            $table->text('keterangan')->nullable()->after('isi');
            $table->string('gambar')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('aktivitas_dosen_asing', function (Blueprint $table) {
            $table->dropForeign(['dosen_internasional_id']);
            $table->dropColumn(['dosen_internasional_id', 'jenis_kegiatan', 'keterangan']);
            $table->string('gambar')->nullable(false)->change();
        });

        Schema::table('dosen_internasionals', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_kelamin', 'jabatan', 'email', 'subject_1', 'subject_2',
                'email_status', 'email_sent_at', 'email_error'
            ]);
        });
    }
};
