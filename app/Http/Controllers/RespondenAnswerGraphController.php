<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RespondenAnswer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RespondenAnswerGraphController extends Controller
{

    public function index()
    {
        // Mengambil tahun unik untuk filter
        $years = RespondenAnswer::select(DB::raw('YEAR(created_at) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Mengambil daftar fakultas unik dari user yang menginput
        $faculties = \App\Models\User::where('role', 'fakultas')
            ->select('name')
            ->distinct()
            ->pluck('name')
            ->map(function ($name) {
                return strtoupper($name);
            })
            ->sort()
            ->values();

        return view('admin.responden_graph', compact('years', 'faculties'));
    }

    /**
     * Mengambil dan memformat data untuk ditampilkan di grafik.
     */
    public function getGraphData(Request $request)
    {
        $query = RespondenAnswer::with('responden.user');

        // Terapkan filter tanggal jika ada
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $data = $query->get();

        // 1. Data Per Sumber Input (Admin vs Fakultas/Prodi)
        $sumberInput = $data->groupBy(function ($item) {
            if (optional(optional($item->responden)->user)->role === 'admin_direktorat') {
                return 'Direktorat';
            }
            // Semua selain admin_direktorat dianggap dari Fakultas/Prodi
            return 'Fakultas & Prodi';
        })->map->count();


        // 2. Data Per Kategori (Academic vs Employee)
        $kategori = $data->groupBy(function ($item) {
            $category = strtolower($item->category);
            if (in_array($category, ['employer', 'employee'])) {
                return 'Employee';
            }
            return 'Academic';
        })->map->count();


        // 3. Data Tren Bulanan (Saran)
        $tren = $data->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('Y-m');
        })->map(function ($group) {
            return $group->count();
        })->sortKeys();

        // 4. Data per Fakultas (Detail)
        $perFakultas = $data->filter(function ($item) {
            // Hanya ambil data yang diinput oleh fakultas atau prodi
            return optional(optional($item->responden)->user)->role === 'fakultas' || optional(optional($item->responden)->user)->role === 'prodi';
        })->groupBy(function ($item) {
            // Ambil kode fakultas dari nama user
            $userName = optional(optional($item->responden)->user)->name;
            if (Str::contains($userName, '-')) {
                return strtoupper(Str::before($userName, '-'));
            }
            return strtoupper($userName);
        })->map->count()->sortKeys();


        return response()->json([
            'sumberInput' => $sumberInput,
            'kategori' => $kategori,
            'tren' => $tren,
            'perFakultas' => $perFakultas,
        ]);
    }
}
