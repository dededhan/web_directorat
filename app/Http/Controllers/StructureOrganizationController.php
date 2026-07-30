<?php

namespace App\Http\Controllers;

use App\Models\StructureOrgMember;
use Illuminate\Http\Request;

class StructureOrganizationController extends Controller
{
    /**
     * Tampilkan halaman publik struktur organisasi
     */
    public function show()
    {
        $root = StructureOrgMember::with('descendants')
            ->whereNull('parent_id')
            ->first();

        return view('pemeringkatan.struktur-organisasi.index', [
            'root' => $root,
        ]);
    }

    /**
     * Get struktur organisasi sebagai JSON
     */
    public function getTree()
    {
        $root = StructureOrgMember::with('descendants')
            ->whereNull('parent_id')
            ->first();

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
}
