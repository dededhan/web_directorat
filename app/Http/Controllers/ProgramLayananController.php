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
    /**
     * Get the correct route name prefix based on authenticated user role
     */
    private function getRoutePrefix()
    {
        if (auth()->user()->role === 'admin_direktorat') {
            return 'admin';
        } else if (auth()->user()->role === 'admin_hilirisasi') {
            return 'subdirektorat-inovasi.admin_hilirisasi';
        } else if (auth()->user()->role === 'admin_pemeringkatan') {
            return 'admin_pemeringkatan';
        }
        
        return 'admin';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programs = ProgramLayanan::all();
        $routePrefix = $this->getRoutePrefix();
        
        if (auth()->user()->role === 'admin_direktorat') {
            return view('admin.programlayanan', compact('programs', 'routePrefix'));
        } else if (auth()->user()->role === 'admin_hilirisasi') {
            return view('subdirektorat-inovasi.admin_hilirisasi.programlayanan', compact('programs', 'routePrefix'));
        } else if (auth()->user()->role === 'admin_pemeringkatan') {
            return view('admin_pemeringkatan.programlayanan', compact('programs', 'routePrefix'));
        }
    }

    public function store(StoreProgramLayananRequest $request)
    {
        try {
            $data = $request->validated();
            $data['status'] = true; // Default status is active
            
            ProgramLayanan::create($data);
            
            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.program-layanan.index')
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

            $routePrefix = $this->getRoutePrefix();
            
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Program layanan berhasil diperbarui!']);
            }

            return redirect()->route($routePrefix . '.program-layanan.index')
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
            
            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.program-layanan.index')
                ->with('success', 'Program berhasil dihapus');
        } catch (\Exception $e) {
            \Log::error('Error deleting program: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus program: ' . $e->getMessage());
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