<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Akreditasi;
use App\Http\Requests\StoreAkreditasiRequest;

class AkreditasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $akreditasis = Akreditasi::latest()->get();
        return view('admin.dataakreditasi', compact('akreditasis'));  
   
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
    public function store(StoreAkreditasiRequest $request)
    {
        Akreditasi::create($request->validated());
        
        return redirect()->back()->with('success', 'Data mahasiswa berhasil disimpan');
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
