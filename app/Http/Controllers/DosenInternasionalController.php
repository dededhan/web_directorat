<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DosenInternasional;
use App\Http\Requests\StoreDosenInternasionalRequest;


class DosenInternasionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dosen = DosenInternasional::all();
        return view('admin.internationallecture', compact('dosen'));
    }

    public function create()
    {
        //
    }

    public function store(StoreDosenInternasionalRequest $request)
    {
        DosenInternasional::create($request->validated());
        
        return redirect()->back()->with('success', 'Data Dosen International berhasil disimpan');
    }


    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    
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
