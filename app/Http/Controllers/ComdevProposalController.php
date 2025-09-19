<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ComdevProposal; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ComdevProposalController extends Controller 
{
    public function index()
    {
        // DIUBAH: Menggunakan model baru
        $sessions = ComdevProposal::latest()->paginate(10);
        return view('admin_equity.comdev.index', compact('sessions'));
    }

    public function getDetail(ComdevProposal $comdevproposal) 
    {
        return response()->json($comdevproposal);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'dana_maksimal' => 'required|numeric',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
            'min_anggota' => 'required|integer|min:1',
            'max_anggota' => 'required|integer|gte:min_anggota',
        ]);

        ComdevProposal::create($request->all()); 

        return redirect()->route('admin_equity.comdevproposal.index')
                         ->with('success', 'Sesi proposal berhasil dibuat.');
    }

    public function update(Request $request, ComdevProposal $comdevproposal) 
    {
        try {
        $validatedData = $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string', 
            'dana_maksimal' => 'required|numeric',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
            'min_anggota' => 'required|integer|min:1',
            'max_anggota' => 'required|integer|gte:min_anggota',
        ]);

        $comdevproposal->update($validatedData);

      
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Sesi proposal berhasil diperbarui.']);
        }

            
            return redirect()->route('admin_equity.comdevproposal.index')
                            ->with('success', 'Sesi proposal berhasil diperbarui.');

        } catch (ValidationException $e) {
            
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->validator->errors()->first()], 422);
            }
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }
    

    public function destroy(ComdevProposal $comdevproposal) 
    {
        $comdevproposal->delete();
        return redirect()->route('admin_equity.comdevproposal.index')
                         ->with('success', 'Sesi proposal berhasil dihapus.');
    }
}