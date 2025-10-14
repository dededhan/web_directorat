<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\EquityNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Mews\Purifier\Facades\Purifier;

class EquityNewsController extends Controller
{
    public function index()
    {
        $news = EquityNews::with('user')->orderBy('order')->orderBy('created_at', 'desc')->get();
        return view('admin_equity.news.index', compact('news'));
    }

    public function create()
    {
        $gradientColors = $this->getGradientColors();
        return view('admin_equity.news.create', compact('gradientColors'));
    }

    public function store(Request $request)
    {
        \Log::info('Equity News Store Method Called');
        \Log::info('Request Data: ', $request->all());

        $validated = $request->validate([
            'category' => 'required|string|max:100',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gradient_color' => 'required|string|max:50',
            'is_active' => 'nullable',
            'order' => 'nullable|integer|min:0'
        ]);

        \Log::info('Validation Passed');

        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $namaFile = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $imagePath = $file->storeAs('equity-news', $namaFile, 'public');

                $cleanTitle = strip_tags($validated['title']);
                $cleanDescription = $validated['description'] ? Purifier::clean($validated['description']) : null;

                EquityNews::create([
                    'user_id' => Auth::id(),
                    'category' => $validated['category'],
                    'title' => $cleanTitle,
                    'description' => $cleanDescription,
                    'image' => $imagePath,
                    'gradient_color' => $validated['gradient_color'],
                    'is_active' => $request->has('is_active'),
                    'order' => $validated['order'] ?? 0
                ]);

                return redirect()->route('admin_equity.news.index')
                    ->with('success', 'Berita EQUITY berhasil ditambahkan!');
            }

            return redirect()->back()
                ->with('error', 'Upload gambar gagal.')
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Error creating equity news: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menambahkan berita: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(EquityNews $news)
    {
        $gradientColors = $this->getGradientColors();
        return view('admin_equity.news.edit', compact('news', 'gradientColors'));
    }

    public function update(Request $request, EquityNews $news)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:100',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gradient_color' => 'required|string|max:50',
            'is_active' => 'nullable',
            'order' => 'nullable|integer|min:0'
        ]);

        try {
            $cleanTitle = strip_tags($validated['title']);
            $cleanDescription = $validated['description'] ? Purifier::clean($validated['description']) : null;

            $news->category = $validated['category'];
            $news->title = $cleanTitle;
            $news->description = $cleanDescription;
            $news->gradient_color = $validated['gradient_color'];
            $news->is_active = $request->has('is_active');
            $news->order = $validated['order'] ?? 0;

            if ($request->hasFile('image')) {
                if ($news->image && Storage::disk('public')->exists($news->image)) {
                    Storage::disk('public')->delete($news->image);
                }

                $file = $request->file('image');
                $namaFile = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $imagePath = $file->storeAs('equity-news', $namaFile, 'public');
                $news->image = $imagePath;
            }

            $news->save();

            return redirect()->route('admin_equity.news.index')
                ->with('success', 'Berita EQUITY berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Error updating equity news: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal memperbarui berita: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(EquityNews $news)
    {
        try {
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }

            $news->delete();

            return redirect()->route('admin_equity.news.index')
                ->with('success', 'Berita EQUITY berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Error deleting equity news: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus berita: ' . $e->getMessage());
        }
    }

    private function getGradientColors()
    {
        return [
            'blue' => 'Blue',
            'cyan' => 'Cyan',
            'teal' => 'Teal',
            'orange' => 'Orange',
            'purple' => 'Purple',
            'green' => 'Green',
            'red' => 'Red',
            'indigo' => 'Indigo'
        ];
    }
}
