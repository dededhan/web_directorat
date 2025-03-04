<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormRecordHasilPengukuran extends Model
{
    use HasFactory;

    protected $table = 'form_record_hasil_pengukurans';

    protected $fillable = [
        'nama_penanggung_jawab',
        'institusi',
        'judul_inovasi',
        'jenis_inovasi',
        'alamat_kontak',
        'phone',
        'fax',
        'tanggal_penilaian',

        // Kolom untuk masing-masing baris (1 sampai 5)
        'aspek_1', 'aktivitas_1', 'capaian_1', 'keterangan_1', 'catatan_1',
        'aspek_2', 'aktivitas_2', 'capaian_2', 'keterangan_2', 'catatan_2',
        'aspek_3', 'aktivitas_3', 'capaian_3', 'keterangan_3', 'catatan_3',
        'aspek_4', 'aktivitas_4', 'capaian_4', 'keterangan_4', 'catatan_4',
        'aspek_5', 'aktivitas_5', 'capaian_5', 'keterangan_5', 'catatan_5',
    ];
}

