<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
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
        } else if (auth()->user()->role === 'admin_inovasi') {
            return 'subdirektorat-inovasi.admin_inovasi';
        } else if (auth()->user()->role === 'admin_pemeringkatan') {
            return 'admin_pemeringkatan';
        }

        return 'admin';
    }


    public function index()
    {
        $galleries = Gallery::latest()->paginate(10);
        $routePrefix = $this->getRoutePrefix();

        if (auth()->user()->role === 'admin_direktorat') {
            return view('admin.gallery', compact('galleries', 'routePrefix'));
        } else if (auth()->user()->role === 'admin_hilirisasi') {
            return view('subdirektorat-inovasi.admin_hilirisasi.gallery', compact('galleries', 'routePrefix'));
        } else if (auth()->user()->role === 'admin_inovasi') {
            return view('subdirektorat-inovasi.admin_inovasi.gallery', compact('galleries', 'routePrefix'));
        } else if (auth()->user()->role === 'admin_pemeringkatan') {
            return view('admin_pemeringkatan.gallery', compact('galleries', 'routePrefix'));
        }
    }

    public function store(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'category' => 'required|in:direktorat,inovasi,pemeringkatan',
                'image' => 'required|image|max:102400', // 100MB max
            ]);

            // Check if image exists and is valid
            if ($request->hasFile('image')) {
                $fileName = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
                $imagePath = $request->file('image')->storeAs(
                    'gallery-images',
                    $fileName,
                    'public'
                );

                // Create the gallery record with the image path
                Gallery::create([
                    'category' => $request->category,
                    'image' => $imagePath
                ]);

                $routePrefix = $this->getRoutePrefix();
                return redirect()->route($routePrefix . '.gallery.index')
                    ->with('success', 'Gallery item successfully saved!');
            } else {
                // Handle the case where image upload failed
                return redirect()->back()
                    ->with('error', 'Image upload failed. Please ensure the file is valid.')
                    ->withInput();
            }
        } catch (\Exception $e) {
            // Log the error and return with error message
            \Log::error('Error storing gallery item: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to add gallery item: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Get gallery item details for editing
     */
    public function getGalleryDetail($id)
    {
        $gallery = Gallery::findOrFail($id);
        return response()->json($gallery);
    }
    public function getCarouselImages()
    {
        $carouselImages = Gallery::latest()->take(4)->get();
        return response()->json($carouselImages);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $gallery = Gallery::findOrFail($id);

            // Validate the request
            $validated = $request->validate([
                'category' => 'required|in:direktorat,inovasi,pemeringkatan',
                'image' => 'nullable|image|max:102400', // 100MB max
            ]);

            // Update the category
            $gallery->category = $validated['category'];

            // Handle image update if a new one was uploaded
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // Delete old image
                if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                    Storage::disk('public')->delete($gallery->image);
                }

                // Store new image
                $fileName = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
                $imagePath = $request->file('image')->storeAs(
                    'gallery-images',
                    $fileName,
                    'public'
                );

                $gallery->image = $imagePath;
            }

            $gallery->save();

            $routePrefix = $this->getRoutePrefix();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Gallery item successfully updated!']);
            }

            return redirect()->route($routePrefix . '.gallery.index')
                ->with('success', 'Gallery item successfully updated!');
        } catch (\Exception $e) {
            \Log::error('Error updating gallery item: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Failed to update gallery item: ' . $e->getMessage()]);
            }

            return redirect()->back()
                ->with('error', 'Failed to update gallery item: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $gallery = Gallery::findOrFail($id);

            // Delete the image file from storage
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }

            // Delete the record
            $gallery->delete();

            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.gallery.index')
                ->with('success', 'Gallery item successfully deleted!');
        } catch (\Exception $e) {
            \Log::error('Error deleting gallery item: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to delete gallery item: ' . $e->getMessage());
        }
    }
}
