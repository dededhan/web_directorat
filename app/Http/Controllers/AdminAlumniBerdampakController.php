<?php

namespace App\Http\Controllers;


use App\Models\AlumniBerdampak;
use App\Http\Requests\StoreAlumniBerdampakRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class AdminAlumniBerdampakController extends Controller
{
    public function index()
    {
       $alumniBerdampak = AlumniBerdampak::with('user')->latest()->get();

        $viewMap = [
            'admin_direktorat' => 'admin.alumniberdampak',
            'prodi' => 'prodi.alumniberdampak',
            'fakultas' => 'fakultas.alumniberdampak',
            'admin_pemeringkatan' => 'admin_pemeringkatan.alumniberdampak',
        ];

        $view = $viewMap[Auth::user()->role] ?? 'admin.alumniberdampak';

        return view($view, compact('alumniBerdampak'));
    }

    public function store(StoreAlumniBerdampakRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('public/images');
        }

        AlumniBerdampak::create($data);

        return back()->with('success', 'Data berhasil disimpan!');
    }


    public function edit(AlumniBerdampak $alumniberdampak)
    {
        return response()->json($alumniberdampak);
    }

    public function update(StoreAlumniBerdampakRequest $request, AlumniBerdampak $alumniberdampak)
{
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($alumniberdampak->image) {
                Storage::delete($alumniberdampak->image);
            }
            $data['image'] = $request->file('image')->store('public/images');
        }

        $alumniberdampak->update($data);

        return back()->with('success', 'Data berhasil diperbarui');
    }

     public function destroy(AlumniBerdampak $alumniberdampak)
    {
        if ($alumniberdampak->image) {
            Storage::delete($alumniberdampak->image);
        }
        $alumniberdampak->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }
}