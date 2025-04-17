<?php

namespace App\Http\Controllers;

use App\Models\ProgramLayanan;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProgramLayananRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class ProgramLayananController extends Controller
{
    public function index()
    {
        $programs = ProgramLayanan::all();

        if (auth()->user()->hasRole('admin_direktorat')) {
            return view('admin.programlayanan', compact('programs'));
        } elseif (auth()->user()->hasRole('admin_hilirisasi')) {
            return view('subdirektorat-inovasi.admin_hilirisasi.programlayanan', compact('programs'));
        }
    }

    public function store(StoreProgramLayananRequest $request)
    {
        try {
            $data = $request->validated();
            $data['status'] = true; // Default status is active
            
            ProgramLayanan::create($data);
            
            return redirect()->route('admin.program-layanan.index')
                ->with('success', 'Program berhasil ditambahkan');
        } catch (\Exception $e) {
            logger()->error('Error saving program: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan program!');
        }
    }

    /**
     * Get program details for AJAX requests
     */
    public function getProgramDetail($id)
    {
        $program = ProgramLayanan::findOrFail($id);
        return response()->json($program);
    }

    public function update(Request $request, ProgramLayanan $programLayanan)
    {
        try {
            $validated = $request->validate([
                'icon' => 'required|string',
                'judul' => 'required|string|max:50',
                'deskripsi' => 'required|string|max:1500',
                'status' => 'sometimes|boolean'
            ]);

            $programLayanan->update($validated);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Program layanan berhasil diperbarui!']);
            }

            return redirect()->route('admin.program-layanan.index')
                ->with('success', 'Program layanan berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Error updating program: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal memperbarui program: ' . $e->getMessage()]);
            }

            return redirect()->back()
                ->with('error', 'Gagal memperbarui program: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(ProgramLayanan $programLayanan)
    {
        try {
            $programLayanan->delete();
            return redirect()->route('admin.program-layanan.index')
                ->with('success', 'Program berhasil dihapus');
        } catch (\Exception $e) {
            \Log::error('Error deleting program: ' . $e->getMessage());
            return redirect()->route('admin.program-layanan.index')
                ->with('error', 'Gagal menghapus program!');
        }
    }
    
    /**
     * Display active program layanan on the frontend
     */
    public function showFrontend()
    {
        // Get active program layanan, limit to 4 for display
        $programs = ProgramLayanan::where('status', 1)
                                  ->orderBy('id', 'desc')
                                  ->take(4)
                                  ->get();
        
        return view('frontend.program-section', compact('programs'));
    }
}