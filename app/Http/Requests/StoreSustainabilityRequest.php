<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth; // Added to check user role for conditional validation
use Illuminate\Validation\Rule;

class StoreSustainabilityRequest extends FormRequest
{
    public function authorize()
    {
        // Allow all authenticated users who can reach this request.
        // Further specific authorization is handled in the controller.
        return Auth::check();
    }

    public function rules()
    {
        $user = Auth::user();
        $fakultasRules = 'required|in:pascasarjana,fip,fmipa,fppsi,fbs,ft,fik,fis,fe,profesi';
        $prodiRules = 'nullable|string|max:255'; // Max length can be adjusted

        // If the user is 'fakultas' or 'prodi', these fields are set by the controller,
        // so they don't need to be 'required' from the request payload itself for these roles.
        // However, for 'admin_direktorat', they are required from the form.
        if ($user && ($user->role === 'fakultas' || $user->role === 'prodi')) {
            $fakultasRules = 'nullable|string|max:50'; // Will be overridden by controller
            // Prodi for fakultas can be empty (faculty-level) or a specific prodi.
            // Prodi for prodi role is fixed.
        }

        return [
            'judul_kegiatan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'fakultas' => $fakultasRules,
            'prodi' => $prodiRules,
            'link_kegiatan' => 'nullable|url|max:2048', // Increased max length for URLs
            // Validating multiple file uploads for 'foto_kegiatan'
            // Assumes HTML input is <input type="file" name="foto_kegiatan[]" multiple>
            'foto_kegiatan' => 'nullable|array', // The array of photos is optional
            'foto_kegiatan.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:8192', // If photos are provided, validate each. Max 8MB.
            'deskripsi_kegiatan' => 'required|string',
            'sdg_goal' => ['nullable', 'string', Rule::in($sdgOptions)],
        ];
    }

    public function messages()
    {
        return [
            // 'foto_kegiatan.required' => 'Setidaknya satu foto kegiatan harus diunggah.', // No longer required
            // 'foto_kegiatan.*.required' => 'Setiap file foto kegiatan harus diisi.', // No longer required if array is optional
            'foto_kegiatan.*.image' => 'Salah satu file yang diunggah bukan format gambar yang valid.',
            'foto_kegiatan.*.mimes' => 'Format setiap gambar harus jpeg, png, jpg, gif, atau webp.',
            'foto_kegiatan.*.max' => 'Ukuran setiap gambar tidak boleh melebihi 8MB.', // Updated max size message
            'fakultas.required' => 'Kolom fakultas wajib diisi.',
            'fakultas.in' => 'Nilai fakultas yang dipilih tidak valid.',
            // Add other custom messages as needed
        ];
    }
}
