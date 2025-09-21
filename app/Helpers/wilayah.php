<?php

namespace App\Helpers;

class Wilayah
{
    /**
     * Mengambil nama provinsi berdasarkan ID.
     * (Untuk sekarang, kita gunakan data dummy. Nanti bisa dihubungkan ke database atau API)
     *
     * @param string $id
     * @return string
     */
    public static function getNamaProvinsi($id)
    {
        // Contoh data, ganti dengan logika Anda nanti
        $provinsi = [
            'Banten' => 'Banten',
            'DKI Jakarta' => 'DKI Jakarta',
            'Jawa Barat' => 'Jawa Barat',
        ];
        return $provinsi[$id] ?? $id;
    }

    /**
     * Mengambil nama kota/kabupaten berdasarkan ID.
     *
     * @param string $id
     * @return string
     */
    public static function getNamaKota($id)
    {
        $kota = [
            'Kota Serang' => 'Kota Serang',
            'Kota Tangerang' => 'Kota Tangerang',
            'Jakarta Pusat' => 'Jakarta Pusat',
            'Kota Bandung' => 'Kota Bandung',
        ];
        return $kota[$id] ?? $id;
    }

    /**
     * Mengambil nama kecamatan berdasarkan ID.
     *
     * @param string $id
     * @return string
     */
    public static function getNamaKecamatan($id)
    {
        $kecamatan = [
            'Serang' => 'Serang',
            'Taktakan' => 'Taktakan',
            'Cipondoh' => 'Cipondoh',
            'Karawaci' => 'Karawaci',
            'Gambir' => 'Gambir',
            'Tanah Abang' => 'Tanah Abang',
            'Coblong' => 'Coblong',
            'Sukasari' => 'Sukasari',
        ];
        return $kecamatan[$id] ?? $id;
    }

    /**
     * Mengambil nama kelurahan berdasarkan ID.
     *
     * @param string $id
     * @return string
     */
    public static function getNamaKelurahan($id)
    {
        $kelurahan = [
            'Cipare' => 'Cipare', 'Cimuncang' => 'Cimuncang',
            'Pancur' => 'Pancur', 'Sayar' => 'Sayar',
            'Cipondoh' => 'Cipondoh', 'Poris Plawad' => 'Poris Plawad',
            'Karawaci' => 'Karawaci', 'Nambo Jaya' => 'Nambo Jaya',
            'Gambir' => 'Gambir', 'Cideng' => 'Cideng',
            'Bendungan Hilir' => 'Bendungan Hilir', 'Karet Tengsin' => 'Karet Tengsin',
            'Dago' => 'Dago', 'Sekeloa' => 'Sekeloa',
            'Gegerkalong' => 'Gegerkalong', 'Sarijadi' => 'Sarijadi',
        ];
        return $kelurahan[$id] ?? $id;
    }
}
```

#### Langkah 3: Perbarui Autoloader

Setelah membuat file helper baru, Anda perlu memberitahu Composer (manajer dependensi PHP) untuk mengenalinya. Jalankan perintah ini di terminal Anda:

```bash
composer dump-autoload
