<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMataKuliahRequest;
use Illuminate\Support\Facades\Storage;

class AdminMataKuliahController extends Controller
{

    public function index()
    {
        $matakuliahs = MataKuliah::all(); // <-- Variable plural
    return view('admin.matakuliah', compact('matakuliahs'));

    }

    public function store(StoreMataKuliahRequest $request)
    {
        // Handle file upload
        $path = $request->file('rps')->store('rps', 'public');

        MataKuliah::create([
            'nama_matkul' => $request->nama_matkul,
            'semester' => $request->semester,
            'kode_matkul' => $request->kode_matkul,
            'fakultas' => $request->fakultas,
            'prodi' => $request->prodi,
            'rps_path' => $path,
            'deskripsi' => $request->deskripsi
        ]);
        return redirect()->route('admin.matakuliah.index')
            ->with('success', 'Data berhasil disimpan!');

    }
}