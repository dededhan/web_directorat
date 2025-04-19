<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SejarahContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'section',
        'content',
        'status'
    ];

    // Define constants for categories
    const CATEGORY_PEMERINGKATAN = 'pemeringkatan';
    const CATEGORY_INOVASI = 'inovasi';

    // Define constants for sections
    const SECTION_SEJARAH = 'sejarah';
    const SECTION_VISI_MISI = 'visi-misi';
    const SECTION_TUJUAN = 'tujuan';
    const SECTION_RENCANA = 'rencana';

    // Get all sections as an array
    public static function getSections()
    {
        return [
            self::SECTION_SEJARAH => 'Sejarah',
            self::SECTION_VISI_MISI => 'Visi Misi',
            self::SECTION_TUJUAN => 'Tujuan',
            self::SECTION_RENCANA => 'Rencana Strategis',
        ];
    }

    // Get all categories as an array
    public static function getCategories()
    {
        return [
            self::CATEGORY_PEMERINGKATAN => 'Pemeringkatan',
            self::CATEGORY_INOVASI => 'Inovasi',
        ];
    }
}