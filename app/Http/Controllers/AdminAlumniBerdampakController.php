<?php

namespace App\Http\Controllers;


use App\Models\AlumniBerdampak;
use App\Http\Requests\StoreAlumniBerdampakRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class AdminAlumniBerdampakController extends Controller
{
    public function index()
    {
        $alumniBerdampak = AlumniBerdampak::latest()->get();

        if (Auth::user()->role === 'admin_direktorat') {
            return view('admin.alumniberdampak', compact('alumniBerdampak'));
        } else if (Auth::user()->role === 'prodi') {
            return view('prodi.alumniberdampak', compact('alumniBerdampak'));
        } else if (Auth::user()->role === 'fakultas') {
            return view('fakultas.alumniberdampak', compact('alumniBerdampak'));
        } else if (Auth::user()->role === 'admin_pemeringkatan'){
            return view('admin_pemeringkatan.alumniberdampak', compact('alumniBerdampak'));
        }

        // return view('admin.alumniberdampak', compact('alumniBerdampak'));
    }

    public function store(StoreAlumniBerdampakRequest $request)
    {
        AlumniBerdampak::create([
            'judul_berita' => $request->judul_berita,
            'tanggal_berita' => $request->tanggal_berita,
            'fakultas' => $request->fakultas,
            'prodi' => $request->prodi,
            'link_berita' => $request->link_berita,
        ]);

        if (Auth::user()->role === 'admin_direktorat') {
            return redirect()->route('admin.alumniberdampak.index')
                ->with('success', 'Data berhasil disimpan!');
        } else if (Auth::user()->role === 'prodi') {
            return redirect()->route('prodi.alumniberdampak.index')
                ->with('success', 'Data berhasil disimpan!');
        } else if (Auth::user()->role === 'fakultas') {
            return redirect()->route('fakultas.alumniberdampak.index')
                ->with('success', 'Data berhasil disimpan!');
        } else if (Auth::user()->role === 'admin_pemeringkatan'){
            return redirect()->route('admin_pemeringkatan.alumniberdampak.index')
                ->with('success', 'Data berhasil disimpan!');
        }

        // return redirect()->route('admin.alumniberdampak.index')
        //     ->with('success', 'Data berhasil disimpan!');
    }

    public function edit(AlumniBerdampak $alumniberdampak)
    {
        return response()->json($alumniberdampak);
    }

    public function update(StoreAlumniBerdampakRequest $request, AlumniBerdampak $alumniberdampak)
    {
        $alumniberdampak->update([
            'judul_berita' => $request->judul_berita,
            'tanggal_berita' => $request->tanggal_berita,
            'fakultas' => $request->fakultas,
            'prodi' => $request->prodi,
            'link_berita' => $request->link_berita,
        ]);

        return redirect()->back()
                ->with('success', 'Mata kuliah berhasil diperbarui');
    }

    public function destroy(AlumniBerdampak $alumniberdampak)
    {
        $alumniberdampak->delete();
        return redirect()->back()
                ->with('success', 'Mata kuliah berhasil dihapus');
    }
}