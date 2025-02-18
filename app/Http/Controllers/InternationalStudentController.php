<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternationalStudent;
use App\Http\Requests\StoreInternationalStudentRequest;


class InternationalStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $students = InternationalStudent::latest()->get();
        return view('admin.mahasiswainternational', compact('students'));  
   
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
    public function store(StoreInternationalStudentRequest $request)
    {
        
        try {
            InternationalStudent::create($request->validated());
            return redirect()->back()->with('success', 'Data mahasiswa berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
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
