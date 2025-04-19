<?php

namespace App\Http\Controllers;

use App\Models\SejarahContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SejarahContentController extends Controller
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
     * Get the categories that the current user can manage
     */
    private function getUserCategories()
    {
        $userRole = auth()->user()->role;
        
        if ($userRole === 'admin_direktorat') {
            return [SejarahContent::CATEGORY_PEMERINGKATAN, SejarahContent::CATEGORY_INOVASI];
        } else if ($userRole === 'admin_hilirisasi') {
            return [SejarahContent::CATEGORY_INOVASI];
        } else if ($userRole === 'admin_pemeringkatan') {
            return [SejarahContent::CATEGORY_PEMERINGKATAN];
        }
        
        return [];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userCategories = $this->getUserCategories();
        $routePrefix = $this->getRoutePrefix();
        
        $contents = SejarahContent::whereIn('category', $userCategories)
            ->orderBy('category')
            ->orderBy('section')
            ->get();
        
        $sections = SejarahContent::getSections();
        $categories = array_intersect_key(SejarahContent::getCategories(), array_flip($userCategories));
        
        return view('admin.sejarah_dashboard', compact('contents', 'sections', 'categories', 'routePrefix'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userCategories = $this->getUserCategories();
        $routePrefix = $this->getRoutePrefix();
        
        $sections = SejarahContent::getSections();
        $categories = array_intersect_key(SejarahContent::getCategories(), array_flip($userCategories));
        
        return view('admin.sejarah_create', compact('sections', 'categories', 'routePrefix'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userCategories = $this->getUserCategories();
        
        // Validate the request
        $validated = $request->validate([
            'category' => 'required|in:' . implode(',', $userCategories),
            'section' => 'required|in:' . implode(',', array_keys(SejarahContent::getSections())),
            'content' => 'required|string',
        ]);
        
        try {
            // Check if content with the same category and section already exists
            $existing = SejarahContent::where('category', $validated['category'])
                ->where('section', $validated['section'])
                ->first();
            
            if ($existing) {
                // Update existing content
                $existing->update([
                    'content' => $validated['content'],
                ]);
                
                return redirect()->route($this->getRoutePrefix() . '.sejarah.index')
                    ->with('success', 'Konten berhasil diperbarui!');
            } else {
                // Create new content
                SejarahContent::create($validated);
                
                return redirect()->route($this->getRoutePrefix() . '.sejarah.index')
                    ->with('success', 'Konten berhasil disimpan!');
            }
        } catch (\Exception $e) {
            Log::error('Error storing sejarah content: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Gagal menyimpan konten: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userCategories = $this->getUserCategories();
        $content = SejarahContent::findOrFail($id);
        
        // Check if user has access to this category
        if (!in_array($content->category, $userCategories)) {
            abort(403, 'Unauthorized');
        }
        
        return response()->json($content);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $userCategories = $this->getUserCategories();
        $routePrefix = $this->getRoutePrefix();
        
        $content = SejarahContent::findOrFail($id);
        
        // Check if user has access to this category
        if (!in_array($content->category, $userCategories)) {
            abort(403, 'Unauthorized');
        }
        
        $sections = SejarahContent::getSections();
        $categories = array_intersect_key(SejarahContent::getCategories(), array_flip($userCategories));
        
        return view('admin.sejarah_create', compact('content', 'sections', 'categories', 'routePrefix'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $userCategories = $this->getUserCategories();
        
        $content = SejarahContent::findOrFail($id);
        
        // Check if user has access to this category
        if (!in_array($content->category, $userCategories)) {
            abort(403, 'Unauthorized');
        }
        
        // Validate the request
        $validated = $request->validate([
            'category' => 'required|in:' . implode(',', $userCategories),
            'section' => 'required|in:' . implode(',', array_keys(SejarahContent::getSections())),
            'content' => 'required|string',
        ]);
        
        try {
            // Check if changing category/section would create a duplicate
            if ($content->category != $validated['category'] || $content->section != $validated['section']) {
                $exists = SejarahContent::where('category', $validated['category'])
                    ->where('section', $validated['section'])
                    ->where('id', '!=', $id)
                    ->exists();
                
                if ($exists) {
                    return redirect()->back()
                        ->with('error', 'Konten dengan kategori dan bagian yang sama sudah ada.')
                        ->withInput();
                }
            }
            
            $content->update($validated);
            
            return redirect()->route($this->getRoutePrefix() . '.sejarah.index')
                ->with('success', 'Konten berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error updating sejarah content: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Gagal memperbarui konten: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $userCategories = $this->getUserCategories();
        
        $content = SejarahContent::findOrFail($id);
        
        // Check if user has access to this category
        if (!in_array($content->category, $userCategories)) {
            abort(403, 'Unauthorized');
        }
        
        try {
            $content->delete();
            
            return redirect()->route($this->getRoutePrefix() . '.sejarah.index')
                ->with('success', 'Konten berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting sejarah content: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Gagal menghapus konten: ' . $e->getMessage());
        }
    }
    
    /**
     * Display the specified resource to the public.
     */
    public function showPublic(Request $request)
    {
        // Determine category from the URL
        $routeName = $request->route()->getName();
        
        if ($routeName === 'Pemeringkatan.sejarah.sejarah') {
            $category = SejarahContent::CATEGORY_PEMERINGKATAN;
        } elseif ($routeName === 'subdirektorat-inovasi.sejarah.sejarah') {
            $category = SejarahContent::CATEGORY_INOVASI;
        } else {
            abort(404, 'Category not found');
        }
        
        $contents = SejarahContent::where('category', $category)
            ->where('status', true)
            ->get()
            ->keyBy('section');
        
        $sections = SejarahContent::getSections();
        
        if ($category === SejarahContent::CATEGORY_PEMERINGKATAN) {
            return view('Pemeringkatan.sejarah.sejarah', compact('contents', 'sections'));
        } else {
            return view('subdirektorat-inovasi.sejarah.sejarah', compact('contents', 'sections'));
        }
    }
}