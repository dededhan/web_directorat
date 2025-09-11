<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_riset_unj_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riset_unj', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 500)->nullable();
            $table->string('ketua_peneliti')->nullable();
            $table->year('tahun')->nullable();
            $table->string('fakultas', 50)->nullable();
            $table->string('skema')->nullable();
            $table->string('bidang_ilmu')->nullable();
             $table->string('sumber_dana')->nullable();
            $table->bigInteger('dana')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riset_unj');
    }
};