<?php

namespace App\Http\Controllers\Pemeringkatan\Admin;

use App\Http\Controllers\Controller;
use App\Models\StructureOrgMember;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StructureOrganizationController extends Controller
{
    /**
     * Display dashboard untuk manajemen struktur organisasi
     */
    public function index()
    {
        return view('admin_pemeringkatan.structure_organization.index');
    }

    /**
     * Get struktur organisasi sebagai tree (untuk chart)
     */
    public function getTree(): JsonResponse
    {
        $root = StructureOrgMember::with('descendants')->whereNull('parent_id')->first();

        if (!$root) {
            return response()->json([
                'success' => false,
                'message' => 'Struktur organisasi belum ada',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $root->toTreeArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:structure_org_members,id',
            'order' => 'nullable|integer|min:1',
            'display_row' => 'nullable|integer|min:1',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('structure-org', 'public');
            $validated['photo'] = $path;
        }

        // Calculate level
        if ($validated['parent_id']) {
            $parent = StructureOrgMember::find($validated['parent_id']);
            $validated['level'] = $parent->level + 1;
        } else {
            $validated['level'] = 1;
        }

        // Default display_row mengikuti level jika tidak diisi
        if (!isset($validated['display_row'])) {
            $validated['display_row'] = $validated['level'];
        }

        // Auto increment order if not provided
        if (!isset($validated['order'])) {
            $maxOrder = StructureOrgMember::where('parent_id', $validated['parent_id'] ?? null)
                ->max('order');
            $validated['order'] = ($maxOrder ?? 0) + 1;
        }

        $member = StructureOrgMember::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan',
            'data' => $member,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(StructureOrgMember $structureOrgMember): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $structureOrgMember->load('parent', 'children'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StructureOrgMember $structureOrgMember): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'title' => 'sometimes|string|max:255',
            'parent_id' => 'nullable|exists:structure_org_members,id',
            'order' => 'nullable|integer|min:1',
            'display_row' => 'nullable|integer|min:1',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($structureOrgMember->photo) {
                \Storage::disk('public')->delete($structureOrgMember->photo);
            }
            $path = $request->file('photo')->store('structure-org', 'public');
            $validated['photo'] = $path;
        }

        // Recalculate level if parent_id changed
        if (isset($validated['parent_id'])) {
            if ($validated['parent_id']) {
                $parent = StructureOrgMember::find($validated['parent_id']);
                $validated['level'] = $parent->level + 1;
            } else {
                $validated['level'] = 1;
            }
        }

        $structureOrgMember->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil memperbarui',
            'data' => $structureOrgMember,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StructureOrgMember $structureOrgMember): JsonResponse
    {
        // Delete photo
        if ($structureOrgMember->photo) {
            \Storage::disk('public')->delete($structureOrgMember->photo);
        }

        $structureOrgMember->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus',
        ]);
    }

    /**
     * Reorder children untuk positioning
     */
    public function reorder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'members' => 'required|array',
            'members.*.id' => 'required|exists:structure_org_members,id',
            'members.*.order' => 'required|integer|min:1',
        ]);

        foreach ($validated['members'] as $item) {
            StructureOrgMember::where('id', $item['id'])
                ->update(['order' => $item['order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan berhasil diperbarui',
        ]);
    }

    public function moveLeft(StructureOrgMember $structureOrgMember): JsonResponse
    {
        // Cari sibling yang berada tepat di sebelah kiri
        $leftSibling = StructureOrgMember::where('parent_id', $structureOrgMember->parent_id)
            ->where('order', '<', $structureOrgMember->order)
            ->orderBy('order', 'desc')
            ->first();

        // Sudah paling kiri
        if (!$leftSibling) {
            return response()->json([
                'success' => false,
                'message' => 'Anggota sudah berada di posisi paling kiri.',
            ]);
        }

        // Tukar order
        $currentOrder = $structureOrgMember->order;

        $structureOrgMember->update([
            'order' => $leftSibling->order,
        ]);

        $leftSibling->update([
            'order' => $currentOrder,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Urutan berhasil diubah.',
        ]);
    }

    public function moveRight(StructureOrgMember $structureOrgMember): JsonResponse
    {
        // Cari sibling yang berada tepat di sebelah kanan
        $rightSibling = StructureOrgMember::where('parent_id', $structureOrgMember->parent_id)
            ->where('order', '>', $structureOrgMember->order)
            ->orderBy('order')
            ->first();

        // Sudah paling kanan
        if (!$rightSibling) {
            return response()->json([
                'success' => false,
                'message' => 'Anggota sudah berada di posisi paling kanan.',
            ]);
        }

        // Tukar order
        $currentOrder = $structureOrgMember->order;

        $structureOrgMember->update([
            'order' => $rightSibling->order,
        ]);

        $rightSibling->update([
            'order' => $currentOrder,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Urutan berhasil diubah.',
        ]);
    }
}
