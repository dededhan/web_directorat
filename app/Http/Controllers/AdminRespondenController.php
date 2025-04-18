<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRespondenRequest;
use App\Http\Requests\UpdateRespondenRequest;
use App\Models\Responden;
use Illuminate\Validation\Rule;
use App\Exports\RespondenExport;
use Maatwebsite\Excel\Facades\Excel;



class AdminRespondenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.respondenadmin', [
            'respondens' => Responden::all()
        ]);
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
    public function store(StoreRespondenRequest $request)
    {
        $respondenValidated = $request->validated();
        $responden = Responden::create([
            'title' => $respondenValidated['responden_title'],
            'fullname' => $respondenValidated['responden_fullname'],
            'jabatan' => $respondenValidated['responden_jabatan'],
            'instansi' => $respondenValidated['responden_instansi'],
            'email' => $respondenValidated['email'],
            'phone_responden' => $respondenValidated['phone_responden'],
            'nama_dosen_pengusul' => $respondenValidated['responden_dosen'],
            'phone_dosen' => $respondenValidated['responden_dosen_phone'],
            'fakultas' => $respondenValidated['responden_fakultas'],
            'category' => $respondenValidated['responden_category'],
        ]);
        return redirect(route('admin.responden.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Responden $responden)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Responden $responden)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRespondenRequest $request, $id)
    {
        $validated = $request->validated(); // Gunakan validasi dari Form Request
        
        $responden = Responden::findOrFail($id);
        $responden->update($validated);
        
        return response()->json([
            'message' => 'Data berhasil diperbarui',
            'data' => $responden
        ]);
    }

    // Buat method terpisah untuk update status
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => [
                'required', 
                Rule::in(['belum', 'done', 'dones', 'clear'])
            ]
        ]);
    
        $responden = Responden::findOrFail($id);
        $responden->update($validated);
    
        return response()->json([
            'message' => 'Status berhasil diperbarui',
            'new_status' => $validated['status']
        ]);
    }

     

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Responden $responden)
    {
        //
    }


    public function export()
    {
        return Excel::download(new RespondenExport, 'responden-data.xlsx');
    }

    /**
     * Export responden data to CSV.
     */
    public function exportCSV()
    {
        return Excel::download(new RespondenExport, 'responden-data.csv');
    }
}
