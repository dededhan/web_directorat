<?php

namespace App\Http\Controllers;

use App\Models\AktivitasDosenAsing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\InternationalActivity;


class InternationalFacultyStaffActivitiesController extends Controller
{
    private function getRoutePrefix()
    {
        $role = auth()->user()->role;
        switch ($role) {
            case 'admin_direktorat':
                return 'admin';
            case 'admin_hilirisasi':
                return 'subdirektorat-inovasi.admin_hilirisasi';
            case 'admin_inovasi':
                return 'subdirektorat-inovasi.admin_inovasi';
            case 'admin_pemeringkatan':
                return 'admin_pemeringkatan';
            default:
                return 'admin';
        }
    }

    public function index()
    {
        $activities = AktivitasDosenAsing::latest()->get();
        $routePrefix = $this->getRoutePrefix();
        $userRole = Auth::user()->role;

        $viewMap = [
            'admin_direktorat' => 'admin.international_faculty_staff_activities',
            'prodi' => 'prodi.international_faculty_staff_activities',
            'fakultas' => 'fakultas.international_faculty_staff_activities',
            'admin_pemeringkatan' => 'admin_pemeringkatan.international_faculty_staff_activities',
        ];
        
        if (isset($viewMap[$userRole])) {
            return view($viewMap[$userRole], compact('activities', 'routePrefix'));
        }

        // Fallback for any other roles if necessary
        return view('admin.international_faculty_staff_activities', compact('activities', 'routePrefix'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'tanggal' => 'required|date',
                'judul_berita' => 'required|string|max:200',
                'isi_berita' => 'required|string',
                'gambar' => 'required|image|max:2048',
            ]);

            if ($request->hasFile('gambar')) {
                $namaFile = time() . '_' . uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
                $gambarPath = $request->file('gambar')->storeAs(
                    'aktivitas-dosen-asing',
                    $namaFile,
                    'public'
                );

                AktivitasDosenAsing::create([
                    'tanggal' => $validated['tanggal'],
                    'judul' => $validated['judul_berita'],
                    'isi' => $validated['isi_berita'],
                    'gambar' => $gambarPath
                ]);

                $routePrefix = $this->getRoutePrefix();
                return redirect()->route($routePrefix . '.international-faculty.index')
                    ->with('success', 'Aktivitas berhasil disimpan!');
            }

            return redirect()->back()
                ->with('error', 'Upload gambar gagal.')
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Error storing activity: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menambahkan aktivitas: ' . $e->getMessage())
                ->withInput();
        }
    }
    

    public function update(Request $request, string $id)
    {
        try {
            $activity = AktivitasDosenAsing::findOrFail($id);

            $validated = $request->validate([
                'tanggal' => 'required|date',
                'judul_berita' => 'required|string|max:200',
                'isi_berita' => 'required|string',
                'gambar' => 'nullable|image|max:2048',
            ]);

            $activity->tanggal = $validated['tanggal'];
            $activity->judul = $validated['judul_berita'];
            $activity->isi = $validated['isi_berita'];

            if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
                if ($activity->gambar && Storage::disk('public')->exists($activity->gambar)) {
                    Storage::disk('public')->delete($activity->gambar);
                }

                $namaFile = time() . '_' . uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
                $gambarPath = $request->file('gambar')->storeAs(
                    'aktivitas-dosen-asing',
                    $namaFile,
                    'public'
                );

                $activity->gambar = $gambarPath;
            }

            $activity->save();

            $routePrefix = $this->getRoutePrefix();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Aktivitas berhasil diperbarui!']);
            }

            return redirect()->route($routePrefix . '.international-faculty.index')
                ->with('success', 'Aktivitas berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Error updating activity: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal memperbarui aktivitas: ' . $e->getMessage()]);
            }

            return redirect()->back()
                ->with('error', 'Gagal memperbarui aktivitas: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * FIX: This function was using the wrong Model. 
     * Corrected from InternationalActivity to AktivitasDosenAsing.
     * It's better to use the show() method and remove this one to avoid duplication,
     * but this fix will make it work.
     */
    public function detail($id)
    {
        $activity = AktivitasDosenAsing::findOrFail($id);
        return response()->json($activity);
    }

    public function destroy(string $id)
    {
        try {
            $activity = AktivitasDosenAsing::findOrFail($id);

            if ($activity->gambar && Storage::disk('public')->exists($activity->gambar)) {
                Storage::disk('public')->delete($activity->gambar);
            }

            $activity->delete();

            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.international-faculty.index')
                ->with('success', 'Aktivitas berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Error deleting activity: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus aktivitas: ' . $e->getMessage());
        }
    }

    /**
     * This is the recommended function to fetch activity details for an API call.
     * Ensure your route in routes/api.php points to this method.
     * Example: Route::get('/aktivitas-dosen-asing/{id}', [InternationalFacultyStaffActivitiesController::class, 'show']);
     */
    public function show($id)
    {
        try {
            $activity = AktivitasDosenAsing::findOrFail($id);
            return response()->json($activity);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Activity not found'], 404);
        }
    }
}
