<?php

namespace App\Http\Controllers;

use App\Models\Sustainability;
use App\Models\SustainabilityPhoto;
use App\Http\Requests\StoreSustainabilityRequest;
use Illuminate\Support\Facades\Storage;

class SustainabilityController extends Controller
{
    public function store(StoreSustainabilityRequest $request)
    {
        try {
            // Validate the request
            $validatedData = $request->validated();

            // Create a new Sustainability entry
            $sustainability = Sustainability::create([
                'judul_kegiatan' => $validatedData['judul_kegiatan'],
                'tanggal_kegiatan' => $validatedData['tanggal_kegiatan'],
                'fakultas' => $validatedData['fakultas'],
                'prodi' => $validatedData['prodi'],
                'link_kegiatan' => $validatedData['link_kegiatan'] ?? null,
                'deskripsi_kegiatan' => $validatedData['deskripsi_kegiatan']
            ]);

            // Handle file uploads
            if ($request->hasFile('foto_kegiatan')) {
                foreach ($request->file('foto_kegiatan') as $photo) {
                    // Generate a unique filename
                    $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
                    
                    // Store the file in the storage/app/public/sustainability directory
                    $path = $photo->storeAs('sustainability', $filename, 'public');

                    // Create a photo entry linked to the sustainability activity
                    SustainabilityPhoto::create([
                        'sustainability_id' => $sustainability->id,
                        'path' => $path
                    ]);
                }
            }

            // Redirect back with success message
            return redirect()->back()->with('success', 'Kegiatan Sustainability berhasil ditambahkan');
        } catch (\Exception $e) {
            // Log the error and return with error message
            \Log::error('Error storing sustainability activity: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan kegiatan: ' . $e->getMessage());
        }
    }
}