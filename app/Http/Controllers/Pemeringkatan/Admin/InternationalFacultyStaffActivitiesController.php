<?php

namespace App\Http\Controllers\Pemeringkatan\Admin;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Traits\HasRoleBasedViews;
use App\Models\AktivitasDosenAsing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class InternationalFacultyStaffActivitiesController extends Controller
{
    use HasRoleBasedViews;

    public function index(Request $request)
    {
        $query = AktivitasDosenAsing::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%");
            });
        }

        // Date range filter
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        $activities = $query->latest('tanggal')->paginate(20)->appends($request->query());

        return view($this->resolveViewByRole('international-faculty-activities.index'), compact('activities'));
    }

    public function create()
    {
        return view($this->resolveViewByRole('international-faculty-activities.create'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'tanggal' => 'required|date',
                'judul' => 'required|string|max:200',
                'isi' => 'required|string',
                'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($request->hasFile('gambar')) {
                $namaFile = time() . '_' . uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
                $gambarPath = $request->file('gambar')->storeAs(
                    'aktivitas-dosen-asing',
                    $namaFile,
                    'public'
                );
                $isi = $this->sanitizeHtmlContent($validated['isi']);

                AktivitasDosenAsing::create([
                    'tanggal' => $validated['tanggal'],
                    'judul' => $validated['judul'],
                    'isi' => $isi,
                    'gambar' => $gambarPath
                ]);

                return redirect()
                    ->route($this->resolveRedirectByRole('international-faculty-activities.index'))
                    ->with('success', 'Aktivitas berhasil disimpan!');
            }

            return redirect()->back()
                ->with('error', 'Upload gambar gagal.')
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error storing activity: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menambahkan aktivitas: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(string $id)
    {
        $activity = AktivitasDosenAsing::findOrFail($id);
        return view($this->resolveViewByRole('international-faculty-activities.edit'), compact('activity'));
    }
    

    public function update(Request $request, string $id)
    {
        try {
            $activity = AktivitasDosenAsing::findOrFail($id);

            $validated = $request->validate([
                'tanggal' => 'required|date',
                'judul' => 'required|string|max:200',
                'isi' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $isi = $this->sanitizeHtmlContent($validated['isi']);

            $activity->tanggal = $validated['tanggal'];
            $activity->judul = $validated['judul'];
            $activity->isi = $isi;

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

            return redirect()
                ->route($this->resolveRedirectByRole('international-faculty-activities.index'))
                ->with('success', 'Aktivitas berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error updating activity: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal memperbarui aktivitas: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $activity = AktivitasDosenAsing::findOrFail($id);

            if ($activity->gambar && Storage::disk('public')->exists($activity->gambar)) {
                Storage::disk('public')->delete($activity->gambar);
            }

            $activity->delete();

            return redirect()
                ->route($this->resolveRedirectByRole('international-faculty-activities.index'))
                ->with('success', 'Aktivitas berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting activity: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus aktivitas: ' . $e->getMessage());
        }
    }
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $namaFile = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('aktivitas-dosen-asing/content-images', $namaFile, 'public');
            
            $url = Storage::url($path);
            
            return response()->json([
                'url' => $url,
                'uploaded' => 1,
                'fileName' => $namaFile
            ]);
        }
        
        return response()->json(['uploaded' => 0, 'error' => ['message' => 'No file uploaded']], 400);
    }

    private function sanitizeHtmlContent($content)
    {
        $config = \HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'p,br,strong,em,u,h1,h2,h3,h4,h5,h6,ul,ol,li,a[href|target],img[src|alt|width|height],table,thead,tbody,tr,th,td,blockquote,code,pre,span[style]');
        $config->set('CSS.AllowedProperties', 'color,background-color,font-size,font-weight,text-align');
        $config->set('HTML.Nofollow', true);
        $config->set('Attr.AllowedFrameTargets', ['_blank']);
        
        $purifier = new \HTMLPurifier($config);
        return $purifier->purify($content);
    }
}
