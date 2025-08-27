<?php

// file: app/Http/Controllers/SettingController.php
namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman pengaturan.
     */
    public function index()
    {
    $setting = \App\Models\Setting::where('key', 'katsinov_threshold')->first();

    // 2. Cek apakah record-nya ada. Jika ada, ambil nilainya. Jika tidak, beri nilai default.
    $threshold = $setting ? $setting->value : '80.0';

    // 3. Kirim ke view
    return view('admin.katsinov.setting_treshold', compact('threshold'));
}
    /**
     * Menyimpan perubahan pengaturan.
     */
    public function update(Request $request)
    {
        // Validasi input, harus angka antara 0-100
        $request->validate([
            'katsinov_threshold' => 'required|numeric|min:0|max:100',
        ]);

        // Gunakan updateOrCreate untuk membuat atau mengupdate setting
        Setting::updateOrCreate(
            ['key' => 'katsinov_threshold'],
            ['value' => $request->katsinov_threshold]
        );

        // Redirect kembali ke halaman pengaturan dengan pesan sukses
        return redirect()->route('admin.katsinov.settings.index')->with('success', 'Pengaturan ambang batas berhasil diperbarui!');
    }
}