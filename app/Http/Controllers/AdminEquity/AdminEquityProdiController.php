<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminEquityProdiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $fakultasId = $request->input('fakultas_id');

        $query = Prodi::with('fakultas')->orderBy('name');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($fakultasId) {
            $query->where('fakultas_id', $fakultasId);
        }

        $prodi = $query->paginate(10)->appends($request->query());
        $fakultas = Fakultas::orderBy('name')->get();

        return view('admin_equity.manageprodi.index', compact('prodi', 'fakultas'));
    }

    public function create()
    {
        $fakultas = Fakultas::orderBy('name')->get();

        return view('admin_equity.manageprodi.create', compact('fakultas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fakultas_id' => ['required', 'exists:equity_fakultas,id'],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('equity_prodi', 'name')
                    ->where(fn ($query) => $query->where('fakultas_id', $request->input('fakultas_id'))),
            ],
        ]);

        Prodi::create($validated);

        return redirect()
            ->route('admin_equity.manageprodi.index')
            ->with('success', 'Prodi berhasil ditambahkan.');
    }

    public function edit(Prodi $prodi)
    {
        $fakultas = Fakultas::orderBy('name')->get();

        return view('admin_equity.manageprodi.edit', compact('prodi', 'fakultas'));
    }

    public function update(Request $request, Prodi $prodi)
    {
        $validated = $request->validate([
            'fakultas_id' => ['required', 'exists:equity_fakultas,id'],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('equity_prodi', 'name')
                    ->where(fn ($query) => $query->where('fakultas_id', $request->input('fakultas_id')))
                    ->ignore($prodi->id),
            ],
        ]);

        $prodi->update($validated);

        return redirect()
            ->route('admin_equity.manageprodi.index')
            ->with('success', 'Prodi berhasil diperbarui.');
    }
}
