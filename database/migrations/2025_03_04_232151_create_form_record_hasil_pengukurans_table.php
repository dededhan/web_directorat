<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('form_record_hasil_pengukurans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penanggung_jawab');
            $table->string('institusi');
            $table->string('judul_inovasi');
            $table->string('jenis_inovasi');
            $table->text('alamat_kontak');
            $table->string('phone');
            $table->string('fax');
            $table->date('tanggal_penilaian');

            // Data untuk 5 baris input detail
            for ($i = 1; $i <= 5; $i++) {
                $table->string("aspek_$i");
                $table->string("aktivitas_$i");
                $table->integer("capaian_$i");
                $table->string("keterangan_$i");
                $table->string("catatan_$i");
            }

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_record_hasil_pengukurans');
    }
};
