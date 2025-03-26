<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use App\Http\Requests\StorePengumumanRequest;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengumumans = Pengumuman::all();
        return view('admin.newsscroll', compact('pengumumans'));
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
    public function store(StorePengumumanRequest $request)
    {
        try {
            $data = $request->validated();
            $data['status'] = true; 
    
            // Debug data sebelum disimpan
            logger()->info('Data to save:', $data);
    
            Pengumuman::create($data);
            
            return redirect()->route('admin.news-scroll.index')
                   ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            // Log error
            logger()->error('Error saving data: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan data!');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Pengumuman $pengumuman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengumuman $pengumuman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();
        return redirect()->route('admin.news-scroll.index')->with('success', 'Data berhasil dihapus!');
    }
}
