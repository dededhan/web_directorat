<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DosenSearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('q');

        if (empty($search)) {
            return response()->json([]);
        }

        $dosens = User::where('role', 'dosen')
            ->where('name', 'LIKE', "%{$search}%")
            ->with('profile.prodi.fakultas')
            ->limit(10)
            ->get();

        $results = $dosens->map(function ($dosen) {
            return [
                'id' => $dosen->id,
                'text' => $dosen->name, // 'text' is used by TomSelect for display
                'identifier_number' => $dosen->profile->identifier_number ?? 'N/A',
                'prodi' => $dosen->profile->prodi->name ?? 'N/A',
                'fakultas' => $dosen->profile->prodi->fakultas->name ?? 'N/A',
            ];
        });

        return response()->json($results);
    }
}
