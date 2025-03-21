<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBeritaAcaraRequest;
use App\Models\BeritaAcara;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; 

class BeritaAcaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $beritaAcaras = BeritaAcara::latest()->get();
        // return view('admin.katsinov.formberitaacara', compact('beritaAcaras'));


        $beritaAcaras = BeritaAcara::latest()->get();

        if (Auth::user()->role === 'admin_direktorat') {
            return view('admin.katsinov.formberitaacara', compact('beritaAcaras'));
        } else if (Auth::user()->role === 'dosen') {
            return view('inovasi.dosen.formberitaacara', compact('beritaAcaras'));
        } else if (Auth::user()->role === 'admin_hilirisasi') {
            return view('inovasi.admin_hilirisasi.formberitaacara', compact('beritaAcaras'));
        } else if (Auth::user()->role === 'validator') {
            return view('inovasi.validator.formberitaacara', compact('beritaAcaras'));
        } else if (Auth::user()->role === 'registered_user') {
            return view('inovasi.registered_user.formberitaacara', compact('beritaAcaras'));
        } 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
// app/Http/Controllers/BeritaAcaraController.php

    public function store(StoreBeritaAcaraRequest $request)
    {
        try {
            $validated = $request->validated();
            
            // Convert signature dengan error handling
            $signatureFields = [
                'ttd_penanggungjawab',
                'ttd_ketua_tim',
                'ttd_anggota1',
                'ttd_anggota2'
            ];

            foreach ($signatureFields as $field) {
                if (empty($validated[$field])) {
                    continue;
                }
                
                if (!preg_match('/^data:image\/(png|jpeg|jpg);base64,/', $validated[$field])) {
                    continue;
                }

                $imageParts = explode(";base64,", $validated[$field]);
                $imageType = str_replace('data:image/', '', $imageParts[0]);
                $imageData = base64_decode($imageParts[1]);

                $filename = 'signature_'.$field.'_'.time().'.'.$imageType;
                Storage::put('public/signatures/'.$filename, $imageData);
                $validated[$field] = 'signatures/'.$filename;
            }

            BeritaAcara::create($validated);

            return response()->json([
                'message' => 'Data berhasil disimpan',
                'redirect' => route('admin.Katsinov.formberitaacara.index')
            ]);

        } catch (\Exception $e) {
            Log::error('Error menyimpan berita acara: '.$e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan server: '.$e->getMessage()
            ], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
