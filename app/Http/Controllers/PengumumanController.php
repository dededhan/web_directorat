<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;

use Illuminate\Http\Request;
use App\Http\Requests\StorePengumumanRequest;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengumumans = Pengumuman::all();
        return view('admin.newsscroll', compact('pengumumans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getPengumumanDetail($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return response()->json($pengumuman);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePengumumanRequest $request)
    {
        try {
            $data = $request->validated();
            $data['status'] = true;

            // Debug data sebelum disimpan
            logger()->info('Data to save:', $data);

            Pengumuman::create($data);

            return redirect()->route('admin.news-scroll.index')
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            // Log error
            logger()->error('Error saving data: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan data!');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Pengumuman $pengumuman)
    {
        //
    }

    public function update(Request $request, Pengumuman $news_scroll)
    {
        try {
            $validated = $request->validate([
                'judul_pengumuman' => 'required|string|max:50',
                'icon' => 'nullable|string',
                'isi_pengumuman' => 'required|string|max:200',
                'status' => 'sometimes|boolean'
            ]);

            $news_scroll->update($validated);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Pengumuman berhasil diperbarui!']);
            }

            return redirect()->route('admin.news-scroll.index')
                ->with('success', 'Pengumuman berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Error updating pengumuman: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal memperbarui pengumuman: ' . $e->getMessage()]);
            }

            return redirect()->back()
                ->with('error', 'Gagal memperbarui pengumuman: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengumuman $news_scroll)
    {
        try {
            $news_scroll->delete();
            return redirect()->route('admin.news-scroll.index')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Error deleting: ' . $e->getMessage());
            return redirect()->route('admin.news-scroll.index')->with('error', 'Gagal menghapus data!');
        }
    }

    public function getActiveAnnouncements()
    {
        $announcements = Pengumuman::where('status', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($announcements);
    }
}
