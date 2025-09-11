<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RisetUnj;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; 
use App\Imports\RisetUnjImport;       
use App\Exports\RisetUnjExport; 
use App\Exports\RisetUnjTemplateExport;
use Illuminate\Support\Facades\DB; 
use App\Exports\RisetSearchResultExport; 

class RisetUnjController extends Controller
{
    public function publicIndex()
    {
        $allData = RisetUnj::latest()->get(); 
        return view('subdirektorat-inovasi.riset_unj.riset_unj', compact('allData'));
    }
  
     public function showDownloadForm(Request $request)
    {
        // Cukup tampilkan view, data pencarian akan diambil dari URL
        return view('password-download');
    }

    // METHOD BARU 2: Memverifikasi password dan mengunduh file
    public function verifyAndDownload(Request $request)
    {
        // 1. Validasi password
        if ($request->input('password') !== 'risetdataunj') {
            // Jika salah, kembalikan ke halaman sebelumnya dengan pesan error
            return back()->with('error', 'Kata sandi yang Anda masukkan salah.');
        }

        // 2. Jika password benar, ambil parameter pencarian dari hidden field
        $search = $request->input('search');
        $fakultas = $request->input('fakultas');
        $tahun = $request->input('tahun');

        $fileName = 'hasil-pencarian-riset-unj-' . date('Y-m-d') . '.xlsx';

        // 3. Mulai proses export dan unduh
        return Excel::download(new RisetSearchResultExport($search, $fakultas, $tahun), $fileName);
    }

    // **METHOD BARU DITAMBAHKAN DI SINI**
    // Method ini menangani rute halaman dan hanya menampilkan file view.
    public function showGraph()
    {
        return view('subdirektorat-inovasi.riset_unj.riset_graph');
    }

    public function downloadTemplate()
    {
        return Excel::download(new RisetUnjTemplateExport, 'template-riset-unj.xlsx');
    }

    public function index()
    {
        $allRiset = RisetUnj::latest()->paginate(15);
        return view('admin.risetdataexcelunj', compact('allRiset'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            
            Excel::import(new RisetUnjImport, $request->file('file'));
            return back()->with('success', 'Data riset berhasil ditambahkan!');
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

    public function getGraphData()
    {
        $rawData = RisetUnj::select('tahun', 'fakultas', DB::raw('count(*) as total'))
            ->whereNotNull('tahun')
            ->whereNotNull('fakultas')
            ->where('fakultas', '!=', '')
            ->groupBy('tahun', 'fakultas')
            ->orderBy('tahun', 'asc')
            ->get();

        $labels = $rawData->pluck('tahun')->unique()->sort()->values()->all(); // Label untuk sumbu X (Tahun)
        $faculties = $rawData->pluck('fakultas')->unique()->sort()->values()->all(); // Daftar semua fakultas unik
        $datasets = [];
        
        $colors = [
            'rgba(54, 162, 235, 0.8)', 'rgba(255, 99, 132, 0.8)', 'rgba(75, 192, 192, 0.8)',
            'rgba(255, 206, 86, 0.8)', 'rgba(153, 102, 255, 0.8)', 'rgba(255, 159, 64, 0.8)',
            'rgba(99, 255, 132, 0.8)', 'rgba(201, 203, 207, 0.8)', 'rgba(50, 150, 200, 0.8)',
            'rgba(230, 80, 80, 0.8)'
        ];

        foreach ($faculties as $index => $faculty) {
            $dataForFaculty = [];
            foreach ($labels as $labelYear) {
                $record = $rawData->first(function ($item) use ($faculty, $labelYear) {
                    return $item->fakultas === $faculty && $item->tahun == $labelYear;
                });
                $dataForFaculty[] = $record ? $record->total : 0;
            }

            $datasets[] = [
                'label' => $faculty,
                'data' => $dataForFaculty,
                'backgroundColor' => $colors[$index % count($colors)], // Ambil warna dari palet
                'borderColor' => str_replace('0.8', '1', $colors[$index % count($colors)]),
                'borderWidth' => 1,
            ];
        }

        return response()->json([
            'labels' => $labels,
            'datasets' => $datasets,
        ]);
    }
    }