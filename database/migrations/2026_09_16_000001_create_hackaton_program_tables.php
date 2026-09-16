<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. hackaton_sessions
        Schema::create('hackaton_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sesi');
            $table->text('deskripsi')->nullable();
            $table->decimal('dana_minimal', 15, 2)->nullable();
            $table->decimal('dana_maksimal', 15, 2)->nullable();
            $table->date('periode_awal');
            $table->date('periode_akhir');
            $table->unsignedTinyInteger('min_anggota')->default(1);
            $table->unsignedTinyInteger('max_anggota')->default(4);
            $table->enum('status', ['draft', 'active', 'closed'])->default('draft');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // 3. hackaton_tahap
        Schema::create('hackaton_tahap', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hackaton_session_id')
                ->constrained('hackaton_sessions')
                ->cascadeOnDelete();
            $table->unsignedTinyInteger('tahap_ke');
            $table->string('nama_tahap')->default('');
            $table->text('deskripsi')->nullable();
            $table->dateTime('periode_awal')->nullable();
            $table->dateTime('periode_akhir')->nullable();
            $table->boolean('has_anggota')->default(false);
            $table->boolean('has_fakultas')->default(false);
            $table->timestamps();

            $table->unique(['hackaton_session_id', 'tahap_ke'], 'hackaton_session_tahap_ke_unique');
        });

        // 4. hackaton_tahap_sections
        Schema::create('hackaton_tahap_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hackaton_tahap_id')
                ->constrained('hackaton_tahap')
                ->cascadeOnDelete();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
        });

        // 5. hackaton_tahap_fields
        Schema::create('hackaton_tahap_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hackaton_tahap_id')
                ->constrained('hackaton_tahap')
                ->cascadeOnDelete();
            $table->foreignId('hackaton_tahap_section_id')
                ->nullable()
                ->constrained('hackaton_tahap_sections')
                ->nullOnDelete();
            $table->string('field_label');
            $table->enum('field_type', ['text', 'textarea', 'number', 'date', 'dropdown', 'checkbox', 'file', 'url']);
            $table->json('field_options')->nullable();
            $table->boolean('is_required')->default(true);
            $table->unsignedTinyInteger('urutan')->default(0);
            $table->timestamps();
        });

        // 6. hackaton_submissions
        Schema::create('hackaton_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hackaton_session_id')
                ->constrained('hackaton_sessions')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->enum('status', [
                'draft',
                'diajukan',
                'menunggu_direview',
                'sedang_direview',
                'perbaikan_diperlukan',
                'proses_tahap_selanjutnya',
                'selesai',
            ])->default('draft');
            $table->foreignId('reviewer_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();

            $table->unique(['hackaton_session_id', 'user_id'], 'hackaton_sub_session_user_unique');
        });

        // 7. hackaton_submission_identitas
        Schema::create('hackaton_submission_identitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hackaton_submission_id')
                ->constrained('hackaton_submissions')
                ->cascadeOnDelete();
            $table->string('nama_produk');
            $table->string('skema_inovasi');
            $table->string('bidang_utama_produk');
            $table->timestamps();

            $table->unique('hackaton_submission_id', 'hackaton_sub_identitas_uq');
        });

        // 8. hackaton_submission_tahap
        Schema::create('hackaton_submission_tahap', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hackaton_submission_id')
                ->constrained('hackaton_submissions')
                ->cascadeOnDelete();
            $table->foreignId('hackaton_tahap_id')
                ->constrained('hackaton_tahap')
                ->cascadeOnDelete();
            $table->enum('status', ['belum_diisi', 'draft', 'diajukan'])->default('belum_diisi');
            $table->timestamp('submitted_at')->nullable();
            $table->enum('admin_status', ['menunggu', 'disetujui', 'perbaikan', 'selesai'])->default('menunggu');
            $table->decimal('nominal_evaluasi', 15, 2)->nullable();
            $table->text('catatan_admin')->nullable();
            $table->timestamps();

            $table->unique(['hackaton_submission_id', 'hackaton_tahap_id'], 'hackaton_sub_tahap_unique');
        });

        // 9. hackaton_submission_field_values
        Schema::create('hackaton_submission_field_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hackaton_submission_id')
                ->constrained('hackaton_submissions')
                ->cascadeOnDelete();
            $table->foreignId('hackaton_tahap_id')
                ->constrained('hackaton_tahap')
                ->cascadeOnDelete();
            $table->foreignId('hackaton_tahap_field_id')
                ->constrained('hackaton_tahap_fields')
                ->cascadeOnDelete();
            $table->longText('value')->nullable();
            $table->timestamps();

            $table->unique(['hackaton_submission_id', 'hackaton_tahap_field_id'], 'hackaton_sub_field_unique');
        });

        // 10. hackaton_submission_members
        Schema::create('hackaton_submission_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hackaton_submission_id')
                ->constrained('hackaton_submissions')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->enum('peran', ['Ketua', 'Anggota']);
            $table->enum('tipe_anggota', ['dosen', 'alumni', 'DUDI', 'mahasiswa', 'PPPK', 'peneliti', 'tendik']);
            $table->enum('peran_ic', ['Hacker', 'Hustler', 'Hipster'])->default('Hacker');
            $table->text('deskripsi_peran')->nullable();
            $table->string('nama_lengkap');
            $table->string('nik_nim_nip')->nullable();
            $table->string('institusi_fakultas')->nullable();
            $table->enum('approval_status', ['not_required', 'pending', 'approved', 'rejected'])
                ->default('not_required');
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
        });

        // 11. hackaton_submission_reviewer
        Schema::create('hackaton_submission_reviewer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hackaton_submission_id')
                ->constrained('hackaton_submissions')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['hackaton_submission_id', 'user_id'], 'hackaton_sub_rev_unique');
        });

        // 12. hackaton_reviews
        Schema::create('hackaton_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hackaton_submission_id')
                ->constrained('hackaton_submissions')
                ->cascadeOnDelete();
            $table->foreignId('hackaton_tahap_id')
                ->constrained('hackaton_tahap')
                ->cascadeOnDelete();
            $table->foreignId('reviewer_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->unsignedTinyInteger('skor')->nullable();
            $table->text('komentar');
            $table->text('penilaian')->nullable();
            $table->timestamps();
        });

        // 13. hackaton_status_logs
        Schema::create('hackaton_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hackaton_submission_id')
                ->constrained('hackaton_submissions')
                ->cascadeOnDelete();
            $table->foreignId('hackaton_tahap_id')
                ->nullable()
                ->constrained('hackaton_tahap')
                ->nullOnDelete();
            $table->string('tipe', 50);
            $table->string('status_dari', 100)->nullable();
            $table->string('status_ke', 100);
            $table->string('keterangan')->nullable();
            $table->foreignId('causer_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('causer_role', 50)->nullable();
            $table->timestamps();

            $table->index(['hackaton_submission_id', 'created_at'], 'hackaton_logs_sub_created_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hackaton_status_logs');
        Schema::dropIfExists('hackaton_reviews');
        Schema::dropIfExists('hackaton_submission_reviewer');
        Schema::dropIfExists('hackaton_submission_members');
        Schema::dropIfExists('hackaton_submission_field_values');
        Schema::dropIfExists('hackaton_submission_tahap');
        Schema::dropIfExists('hackaton_submission_identitas');
        Schema::dropIfExists('hackaton_submissions');
        Schema::dropIfExists('hackaton_tahap_fields');
        Schema::dropIfExists('hackaton_tahap_sections');
        Schema::dropIfExists('hackaton_tahap');
        Schema::dropIfExists('hackaton_sessions');
    }
};
