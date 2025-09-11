<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RisetUnj;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; 
use App\Imports\RisetUnjImport;       
use App\Exports\RisetUnjExport; 
use App\Exports\RisetUnjTemplateExport;

class RisetUnjController extends Controller

{
    public function publicIndex()
    {
        
      $allData = RisetUnj::latest()->get(); 

        return view('subdirektorat-inovasi.riset_unj.riset_unj', compact('allData'));
    }


     public function downloadTemplate()
    {
        return Excel::download(new RisetUnjTemplateExport, 'template-riset-unj.xlsx');
    }
    public function index()
    {
        $allRiset = RisetUnj::latest()->paginate(15);
        return view('admin.risetdataexcelunj', compact('allRiset')); // <-- Nama view diubah
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            // Hapus data lama sebelum mengimpor yang baru
            RisetUnj::truncate();
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