<?php

namespace App\Http\Controllers;

use App\Exports\RespondenExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AdminRespondenExportController extends Controller
{
    public function exportExcel(Request $request)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['admin_direktorat', 'admin_pemeringkatan', 'fakultas', 'prodi'])) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $kategori = $request->input('kategori');
        $fakultas = $request->input('fakultas');
        $status = $request->input('status');
        $sumber_data = $request->input('sumber_data');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $fileName = 'responden-data-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new RespondenExport($user, $kategori, $fakultas, $startDate, $endDate, $status, $sumber_data), $fileName);
    }

    public function exportCSV(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin_direktorat', 'admin_pemeringkatan', 'fakultas', 'prodi'])) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $kategori = $request->input('kategori');
        $fakultas = $request->input('fakultas');
        $status = $request->input('status');
        $sumber_data = $request->input('sumber_data');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $fileName = 'responden-data-' . now()->format('Ymd-His') . '.csv';
        return Excel::download(new RespondenExport($user, $kategori, $fakultas, $startDate, $endDate, $status, $sumber_data), $fileName, \Maatwebsite\Excel\Excel::CSV);
    }
}

