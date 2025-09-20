<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class Wilayah
{
    protected static $baseUrl = 'https://www.emsifa.com/api-wilayah-indonesia/api/';

    private static function getNameById($endpoint, $id)
    {
        if (empty($id)) return null;
        
        try {
            $response = Http::get(self::$baseUrl . $endpoint . $id . '.json');
            if ($response->successful()) {
                return $response->json()['name'] ?? $id;
            }
        } catch (\Exception $e) {
            // Log the error or handle it as needed
        }
        return $id; // Return ID as fallback
    }

    public static function getNamaProvinsi($id)
    {
        return self::getNameById('province/', $id);
    }

    public static function getNamaKota($id)
    {
        return self::getNameById('regency/', $id);
    }

    public static function getNamaKecamatan($id)
    {
        return self::getNameById('district/', $id);
    }

    public static function getNamaKelurahan($id)
    {
        return self::getNameById('village/', $id);
    }
}
