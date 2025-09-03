<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PenelitianImport; // Kita akan buat file ini selanjutnya

class RisetController extends Controller
{
    public function index()
    {
        // Path ke file Excel Anda
        $path2020_2024 = public_path('penelitian/Penelitian_UNJ2020_2024.xlsx');
        $path2025 = public_path('penelitian/Data Penelitian UNJ 2025.xlsx');

        // Membaca data dari kedua file dan menggabungkannya
        $data2020_2024 = Excel::toArray(new \stdClass(), $path2020_2024)[0];
        
        $data2025_internal = Excel::toArray(new \stdClass(), $path2025)[0]; // Sheet "Penelitian Internal UNJ"
        $data2025_dikti = Excel::toArray(new \stdClass(), $path2025)[1];    // Sheet "Penelitian Dikti"
        $data2025_brin = Excel::toArray(new \stdClass(), $path2025)[2];     // Sheet "Penelitian BRIN"
        
        // Menghapus baris header dari setiap set data
        $data2020_2024 = array_slice($data2020_2024, 1);
        $data2025_internal = array_slice($data2025_internal, 1);
        $data2025_dikti = array_slice($data2025_dikti, 3); // Data Dikti memiliki 3 baris header
        $data2025_brin = array_slice($data2025_brin, 3); // Data BRIN memiliki 3 baris header

        // Menggabungkan semua data
        $allData = array_merge($data2020_2024, $data2025_internal, $data2025_dikti, $data2025_brin);
        
        // Mengirim data ke view
        return view('subdirektorat-inovasi.riset_unj.riset_unj', ['allData' => $allData]);
    }
}