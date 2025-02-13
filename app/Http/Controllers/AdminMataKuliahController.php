<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMataKuliahRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; 

class AdminMataKuliahController extends Controller
{

    public function index()
    {
        $matakuliahs = MataKuliah::all(); // <-- Variable plural

        
        if (Auth::user()->role === 'admin_direktorat') {
            return view('admin.matakuliah', compact('matakuliahs'));
        } else if (Auth::user()->role === 'prodi') {
            return view('prodi.matakuliah', compact('matakuliahs'));
        }else if (Auth::user()->role === 'fakultas') {
            return view('fakultas.matakuliah', compact('matakuliahs'));
        } else if (Auth::user()->role === 'admin_pemeringkatan'){
            return view('admin_pemeringkatan.matakuliah', compact('matakuliahs'));
        }
        // return view('admin.matakuliah', compact('matakuliahs'));

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

        if (Auth::user()->role === 'admin_direktorat') {
            return redirect()->route('admin.matakuliah.index')
                ->with('success', 'Data berhasil disimpan!');
        } else if (Auth::user()->role === 'prodi') {
            return redirect()->route('prodi.matakuliah.index')
                ->with('success', 'Data berhasil disimpan!');
        } else if (Auth::user()->role === 'admin_pemeringkatan'){ 
            return redirect()->route('admin_pemeringkatan.matakuliah.index')
                ->with('success', 'Data berhasil disimpan!');
        } else if (Auth::user()->role === 'fakultas') {
            return redirect()->route('fakultas.matakuliah.index')
                ->with('success', 'Data berhasil disimpan!');
        }


        // return redirect()->route('admin.matakuliah.index')
        //     ->with('success', 'Data berhasil disimpan!');

    }
}