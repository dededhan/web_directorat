<?php

namespace App\Http\Controllers;

use App\Exports\RisetSearchResultExport;
use App\Exports\RisetUnjExport;
use App\Exports\RisetUnjTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\RisetUnjImport;
use App\Models\RisetUnj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RisetUnjController extends Controller
{
    public function publicIndex()
    {
        $allData = RisetUnj::latest()->get();
        return view('subdirektorat-inovasi.riset_unj.riset_unj', compact('allData'));
    }

    public function showDownloadForm(Request $request)
    {
        return view('password-download');
    }

    public function verifyAndDownload(Request $request)
    {
        if ($request->input('password') !== 'risetdataunj') {
            return back()->with('error', 'Kata sandi yang Anda masukkan salah.');
        }

        $search = $request->input('search');
        $fakultas = $request->input('fakultas');
        $tahun = $request->input('tahun');

        $fileName = 'hasil-pencarian-riset-unj-' . date('Y-m-d') . '.xlsx';

        return Excel::download(new RisetSearchResultExport($search, $fakultas, $tahun), $fileName);
    }

    public function showGraph()
    {
        $years = RisetUnj::select('tahun')
            ->whereNotNull('tahun')
            ->where('fakultas', 'NOT LIKE', '=%') // Pastikan hanya dari data yang valid
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('subdirektorat-inovasi.riset_unj.riset_graph', compact('years'));
    }

    public function getGraphData(Request $request)
    {
        $query = RisetUnj::select('tahun', 'fakultas', DB::raw('count(*) as total'))
            ->whereNotNull('tahun')
            ->whereNotNull('fakultas')
            ->where('fakultas', '!=', '')
            ->where('fakultas', 'NOT LIKE', '=%')
            ->where('fakultas', 'NOT LIKE', '+%')
            ->whereRaw('LENGTH(fakultas) < 50');

        if ($request->has('tahun') && $request->tahun != 'all') {
            $query->where('tahun', $request->tahun);
        }

        $rawData = $query->groupBy('tahun', 'fakultas')
                         ->orderBy('tahun', 'asc')
                         ->get();

        if ($request->has('tahun') && $request->tahun != 'all') {
            $labels = $rawData->pluck('fakultas')->unique()->sort()->values()->all();
            $datasets = [];

            $backgroundColors = [
                'rgba(59, 130, 246, 0.8)', 'rgba(239, 68, 68, 0.8)', 'rgba(16, 185, 129, 0.8)',
                'rgba(245, 158, 11, 0.8)', 'rgba(139, 92, 246, 0.8)', 'rgba(236, 72, 153, 0.8)',
                'rgba(22, 163, 74, 0.8)',  'rgba(99, 102, 241, 0.8)', 'rgba(249, 115, 22, 0.8)'
            ];
            
            $datasetData = [];
            foreach ($labels as $faculty) {
                $record = $rawData->firstWhere('fakultas', $faculty);
                $datasetData[] = $record ? $record->total : 0;
            }

            $datasets[] = [
                'label' => 'Jumlah Riset Tahun ' . $request->tahun,
                'data' => $datasetData,
                'backgroundColor' => $backgroundColors,
                'borderColor' => array_map(fn($c) => str_replace('0.8', '1', $c), $backgroundColors),
                'borderWidth' => 1.5,
                'borderRadius' => 6,
            ];
        } else {
            $labels = $rawData->pluck('tahun')->unique()->sort()->values()->all();
            $faculties = $rawData->pluck('fakultas')->unique()->sort()->values()->all();
            $datasets = [];
            
            $backgroundColors = [
                'rgba(59, 130, 246, 0.8)', 'rgba(239, 68, 68, 0.8)', 'rgba(16, 185, 129, 0.8)',
                'rgba(245, 158, 11, 0.8)', 'rgba(139, 92, 246, 0.8)', 'rgba(236, 72, 153, 0.8)',
                'rgba(22, 163, 74, 0.8)',  'rgba(99, 102, 241, 0.8)', 'rgba(249, 115, 22, 0.8)'
            ];

            foreach ($faculties as $index => $faculty) {
                $dataForFaculty = [];
                foreach ($labels as $labelYear) {
                    $record = $rawData->first(fn($item) => $item->fakultas === $faculty && $item->tahun == $labelYear);
                    $dataForFaculty[] = $record ? $record->total : 0;
                }
                $color = $backgroundColors[$index % count($backgroundColors)];
                $datasets[] = [
                    'label' => $faculty,
                    'data' => $dataForFaculty,
                    'backgroundColor' => $color,
                    'borderColor' => str_replace('0.8', '1', $color),
                    'borderWidth' => 1.5,
                    'borderRadius' => 6,
                ];
            }
        }

        return response()->json([
            'labels' => $labels,
            'datasets' => $datasets,
            'type' => ($request->has('tahun') && $request->tahun != 'all') ? 'yearly' : 'all'
        ]);
    }

    public function index()
    {
        $allRiset = RisetUnj::latest()->paginate(15);
        return view('admin.risetdataexcelunj', compact('allRiset'));
    }

    public function downloadTemplate()
    {
        return Excel::download(new RisetUnjTemplateExport, 'template-riset-unj.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new RisetUnjImport, $request->file('file'));
            return back()->with('success', 'Data riset berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new RisetUnjExport, 'data-riset-unj.xlsx');
    }

    public function destroy(RisetUnj $risetdataunj)
    {
        $risetdataunj->delete();
        return redirect()->route('admin.risetdataunj.index')
                        ->with('success', 'Data riset berhasil dihapus.');
    }
}