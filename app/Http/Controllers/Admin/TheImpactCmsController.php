<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TheImpactSdg;
use App\Models\TheImpactContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TheImpactCmsController extends Controller
{
    public function dashboard()
    {
        $sdgs = TheImpactSdg::withCount('contents')->orderBy('number')->get();

        $lastUpdatedContent = TheImpactContent::latest('updated_at')->first();

        $stats = [
            'total_sdgs' => $sdgs->count(),
            'active_sdgs' => $sdgs->where('is_active', true)->count(),
            'completed_sdgs' => $sdgs->where('contents_count', '>', 0)->count(),
            'empty_sdgs' => $sdgs->where('contents_count', 0)->count(),
            'total_contents' => $sdgs->sum('contents_count'),
            'last_update_at' => optional($lastUpdatedContent)->updated_at,
        ];

        return view('admin_pemeringkatan.the_impact_cms.dashboard', compact('sdgs', 'stats'));
    }

    public function editor($sdgId)
    {
        $sdg = TheImpactSdg::with(['rootContents.children'])->findOrFail($sdgId);
        return view('admin_pemeringkatan.the_impact_cms.editor', compact('sdg'));
    }

    public function create($sdgId, Request $request)
    {
        $sdg = TheImpactSdg::findOrFail($sdgId);
        $parentContent = null;
        
        if ($request->has('parent_id')) {
            $parentContent = TheImpactContent::findOrFail($request->parent_id);
        }
        
        return view('admin_pemeringkatan.the_impact_cms.create', compact('sdg', 'parentContent'));
    }

    public function edit($contentId)
    {
        $content = TheImpactContent::with(['sdg', 'children'])->findOrFail($contentId);
        $sdg = $content->sdg;
        
        return view('admin_pemeringkatan.the_impact_cms.edit', compact('content', 'sdg'));
    }

    public function getContents($sdgId)
    {
        $contents = TheImpactContent::where('sdg_id', $sdgId)
            ->with('children')
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();
        
        return response()->json($contents);
    }

    public function storeContent(Request $request, $sdgId)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:the_impact_contents,id',
            'title' => 'required|string|max:255',
            'content_type' => 'required|in:text',
            'content' => 'required|string',
            'year' => 'nullable|integer|min:2020|max:' . (date('Y') + 1),
        ]);

        DB::beginTransaction();
        try {
            $sdg = TheImpactSdg::findOrFail($sdgId);
            
            // Year constraint: if parent exists, child must have same year
            if (isset($validated['parent_id'])) {
                $parent = TheImpactContent::findOrFail($validated['parent_id']);
                $validated['year'] = $parent->year; // Force child to inherit parent's year
            }
            
            // Generate point number
            $pointNumber = $this->generatePointNumber($sdgId, $validated['parent_id'] ?? null);
            
            // Get max order
            $maxOrder = TheImpactContent::where('sdg_id', $sdgId)
                ->where('parent_id', $validated['parent_id'] ?? null)
                ->max('order') ?? 0;

            $content = TheImpactContent::create([
                'sdg_id' => $sdgId,
                'parent_id' => $validated['parent_id'] ?? null,
                'point_number' => $pointNumber,
                'title' => $validated['title'],
                'content_type' => 'text',
                'content' => $validated['content'],
                'link_url' => null,
                'year' => $validated['year'] ?? null,
                'order' => $maxOrder + 1,
            ]);

            DB::commit();
            
            return redirect()
                ->route('admin_pemeringkatan.the-impact-cms.editor', $sdgId)
                ->with('success', 'Konten berhasil ditambahkan dengan point number: ' . $pointNumber);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal menambahkan konten: ' . $e->getMessage()]);
        }
    }

    public function updateContent(Request $request, $contentId)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content_type' => 'required|in:text',
            'content' => 'required|string',
            'year' => 'nullable|integer|min:2020|max:' . (date('Y') + 1),
        ]);

        DB::beginTransaction();
        try {
            $content = TheImpactContent::findOrFail($contentId);
            
            // Year constraint: if content has parent, must match parent's year
            if ($content->parent_id) {
                $parent = TheImpactContent::findOrFail($content->parent_id);
                $validated['year'] = $parent->year; // Force to match parent's year
            }
            
            // If this content has children and year changed, update all children
            if ($content->children->count() > 0 && isset($validated['year']) && $validated['year'] != $content->year) {
                $this->updateChildrenYear($content->id, $validated['year']);
            }
            
            // Force content_type to text and link_url to null
            $validated['content_type'] = 'text';
            $validated['link_url'] = null;
            
            $content->update($validated);

            DB::commit();

            return redirect()
                ->route('admin_pemeringkatan.the-impact-cms.editor', $content->sdg_id)
                ->with('success', 'Konten berhasil diupdate: ' . $content->point_number . ' ' . $content->title);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal mengupdate konten: ' . $e->getMessage()]);
        }
    }

    public function deleteContent($contentId)
    {
        try {
            $content = TheImpactContent::findOrFail($contentId);
            $sdgId = $content->sdg_id;
            $pointNumber = $content->point_number;
            
            $content->delete();

            return redirect()
                ->route('admin_pemeringkatan.the-impact-cms.editor', $sdgId)
                ->with('success', 'Konten berhasil dihapus: ' . $pointNumber);
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Gagal menghapus konten: ' . $e->getMessage()]);
        }
    }

    public function reorderContent(Request $request, $sdgId)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:the_impact_contents,id',
            'items.*.order' => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
            foreach ($validated['items'] as $item) {
                TheImpactContent::where('id', $item['id'])
                    ->update(['order' => $item['order']]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Urutan berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate urutan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function moveContent(Request $request, $contentId)
    {
        $validated = $request->validate([
            'target_position' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $content = TheImpactContent::findOrFail($contentId);
            $targetPosition = $validated['target_position'];
            
            // Get all siblings (same parent and sdg)
            $siblings = TheImpactContent::where('sdg_id', $content->sdg_id)
                ->where('parent_id', $content->parent_id)
                ->orderBy('order')
                ->get();

            $currentIndex = $siblings->search(function($item) use ($content) {
                return $item->id === $content->id;
            });

            if ($currentIndex === false) {
                throw new \Exception('Content tidak ditemukan dalam siblings');
            }

            // Validate target position
            if ($targetPosition < 1 || $targetPosition > $siblings->count()) {
                throw new \Exception('Posisi target tidak valid. Harus antara 1 dan ' . $siblings->count());
            }

            // Convert to 0-based index
            $targetIndex = $targetPosition - 1;

            if ($currentIndex === $targetIndex) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Konten sudah berada di posisi tersebut'
                ]);
            }

            // Remove content from current position
            $siblings->splice($currentIndex, 1);
            
            // Insert at new position
            $siblings->splice($targetIndex, 0, [$content]);

            // Update order and point numbers
            foreach ($siblings as $index => $sibling) {
                $sibling->order = $index + 1;
                $newPointNumber = $this->generatePointNumberAtPosition($content->sdg_id, $content->parent_id, $index + 1);
                $sibling->point_number = $newPointNumber;
                $sibling->save();
                
                // Update children point numbers recursively
                $this->updateChildrenPointNumbers($sibling);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Konten berhasil dipindahkan ke posisi ' . $targetPosition,
                'new_point_number' => $content->fresh()->point_number
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memindahkan konten: ' . $e->getMessage()
            ], 500);
        }
    }

    private function generatePointNumberAtPosition($sdgId, $parentId, $position)
    {
        if (!$parentId) {
            return (string)$position;
        }

        $parent = TheImpactContent::findOrFail($parentId);
        return $parent->point_number . '.' . $position;
    }

    private function updateChildrenPointNumbers($parent)
    {
        $children = TheImpactContent::where('parent_id', $parent->id)
            ->orderBy('order')
            ->get();

        foreach ($children as $index => $child) {
            $child->point_number = $parent->point_number . '.' . ($index + 1);
            $child->save();
            
            // Recursively update grandchildren
            if ($child->children->count() > 0) {
                $this->updateChildrenPointNumbers($child);
            }
        }
    }

    private function generatePointNumber($sdgId, $parentId = null)
    {
        if (!$parentId) {
            // Root level
            $maxNumber = TheImpactContent::where('sdg_id', $sdgId)
                ->whereNull('parent_id')
                ->max(DB::raw('CAST(point_number AS UNSIGNED)'));
            
            return (string)($maxNumber ? $maxNumber + 1 : 1);
        }

        $parent = TheImpactContent::findOrFail($parentId);
        $maxNumber = TheImpactContent::where('parent_id', $parentId)
            ->max(DB::raw("CAST(SUBSTRING_INDEX(point_number, '.', -1) AS UNSIGNED)"));
        
        $nextNumber = $maxNumber ? $maxNumber + 1 : 1;
        return $parent->point_number . '.' . $nextNumber;
    }

    private function updateChildrenYear($parentId, $year)
    {
        $children = TheImpactContent::where('parent_id', $parentId)->get();
        
        foreach ($children as $child) {
            $child->update(['year' => $year]);
            
            // Recursively update grandchildren
            if ($child->children->count() > 0) {
                $this->updateChildrenYear($child->id, $year);
            }
        }
    }

    public function initializeSdgs()
    {
        $sdgsData = [
            ['number' => 1, 'title' => 'No Poverty', 'color' => '#e5243b'],
            ['number' => 2, 'title' => 'Zero Hunger', 'color' => '#DDA63A'],
            ['number' => 3, 'title' => 'Good Health and Well-Being', 'color' => '#4C9F38'],
            ['number' => 4, 'title' => 'Quality Education', 'color' => '#C5192D'],
            ['number' => 5, 'title' => 'Gender Equality', 'color' => '#FF3A21'],
            ['number' => 6, 'title' => 'Clean Water and Sanitation', 'color' => '#26BDE2'],
            ['number' => 7, 'title' => 'Affordable and Clean Energy', 'color' => '#FCC30B'],
            ['number' => 8, 'title' => 'Decent Work and Economic Growth', 'color' => '#A21942'],
            ['number' => 9, 'title' => 'Industry, Innovation and Infrastructure', 'color' => '#FD6925'],
            ['number' => 10, 'title' => 'Reduced Inequalities', 'color' => '#DD1367'],
            ['number' => 11, 'title' => 'Sustainable Cities and Communities', 'color' => '#FD9D24'],
            ['number' => 12, 'title' => 'Responsible Consumption and Production', 'color' => '#BF8B2E'],
            ['number' => 13, 'title' => 'Climate Action', 'color' => '#3F7E44'],
            ['number' => 14, 'title' => 'Life Below Water', 'color' => '#0A97D9'],
            ['number' => 15, 'title' => 'Life on Land', 'color' => '#56C02B'],
            ['number' => 16, 'title' => 'Peace, Justice and Strong Institutions', 'color' => '#00689D'],
            ['number' => 17, 'title' => 'Partnerships for the Goals', 'color' => '#19486A'],
        ];

        foreach ($sdgsData as $sdg) {
            TheImpactSdg::updateOrCreate(
                ['number' => $sdg['number']],
                $sdg
            );
        }

        return response()->json([
            'success' => true,
            'message' => '17 SDGs berhasil diinisialisasi'
        ]);
    }
}
