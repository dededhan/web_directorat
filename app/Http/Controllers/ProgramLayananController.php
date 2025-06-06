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

            // Handle image upload
            if ($request->hasFile('image')) {
                \Log::info('Image upload attempt for new program');

                if ($request->file('image')->isValid()) {
                    $imagePath = $request->file('image')->store('program_images', 'public');
                    \Log::info('Image stored at: ' . $imagePath);
                    $data['image'] = $imagePath;
                } else {
                    \Log::error('Invalid image upload in new program');
                    return back()->withInput()->with('error', 'Gambar yang diunggah tidak valid!');
                }
            } else {
                \Log::info('No image uploaded for new program');
            }

            $program = ProgramLayanan::create($data);
            \Log::info('Program created successfully with ID: ' . $program->id);

            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.program-layanan.index')
                ->with('success', 'Program berhasil ditambahkan');
        } catch (\Exception $e) {
            \Log::error('Error saving program: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan program: ' . $e->getMessage());
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
                'kategori' => 'required|in:direktorat,pemeringkatan,inovasi',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'judul' => 'required|string|max:50',
                'deskripsi' => 'required|string|max:1500',
                'status' => 'sometimes|boolean'
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                \Log::info('Image upload attempt for program update');

                if ($request->file('image')->isValid()) {
                    // Delete old image if exists
                    if ($programLayanan->image && Storage::disk('public')->exists($programLayanan->image)) {
                        Storage::disk('public')->delete($programLayanan->image);
                        \Log::info('Old image deleted: ' . $programLayanan->image);
                    }

                    // Store new image
                    $imagePath = $request->file('image')->store('program_images', 'public');
                    \Log::info('New image stored at: ' . $imagePath);

                    // Add image path to validated data
                    $validated['image'] = $imagePath;
                } else {
                    \Log::error('Invalid image upload in program update');
                }
            }

            // Update the program with validated data
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
            ->take(6)
            ->get();

        return view('frontend.program-section', compact('programs'));
    }
}
