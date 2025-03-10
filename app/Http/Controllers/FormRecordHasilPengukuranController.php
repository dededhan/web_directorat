<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRecordHasilPengukuranRequest;
use App\Models\FormRecordHasilPengukuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class FormRecordHasilPengukuranController extends Controller
{
    public function index()
    {
        // $records = FormRecordHasilPengukuran::all();
        // return view('admin.Katsinov.formrecordhasilpengukuran', compact('records'));

        $records = FormRecordHasilPengukuran::all();

        if (Auth::user()->role === 'admin_direktorat') {
            return view('admin.Katsinov.formrecordhasilpengukuran', compact('records'));
        } else if (Auth::user()->role === 'dosen') {
            return view('inovasi.dosen.formrecordhasilpengukuran', compact('records'));
        } else if (Auth::user()->role === 'admin_hilirisasi') {
            return view('inovasi.admin_hilirisasi.formrecordhasilpengukuran', compact('records'));
        } else if (Auth::user()->role === 'validator') {
            return view('inovasi.validator.formrecordhasilpengukuran', compact('records'));
        }
    }

    public function create()
    {
        return view('formrecordhasilpengukuran.create');
    }

    public function store(FormRecordHasilPengukuranRequest $request)
    {
        // Data sudah tervalidasi lewat Form Request
        FormRecordHasilPengukuran::create($request->validated());

        return redirect()->route('admin.Katsinov.formrecordhasilpengukuran.index')
                         ->with('success', 'Data berhasil disimpan!');
    }

    public function show($id)
    {
        $record = FormRecordHasilPengukuran::findOrFail($id);
        return view('formrecordhasilpengukuran.show', compact('record'));
    }

    public function edit($id)
    {
        $record = FormRecordHasilPengukuran::findOrFail($id);
        return view('formrecordhasilpengukuran.edit', compact('record'));
    }

    public function update(FormRecordHasilPengukuranRequest $request, $id)
    {
        $record = FormRecordHasilPengukuran::findOrFail($id);
        $record->update($request->validated());

        return redirect()->route('formrecordhasilpengukuran.index')
                         ->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $record = FormRecordHasilPengukuran::findOrFail($id);
        $record->delete();

        return redirect()->route('formrecordhasilpengukuran.index')
                         ->with('success', 'Data berhasil dihapus!');
    }
}
