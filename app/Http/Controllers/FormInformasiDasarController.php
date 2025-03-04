<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreFormInformasiDasarRequest;
use App\Models\InnovatorForm;
use App\Models\FormProgress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FormInformasiDasarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forms = InnovatorForm::all(); // Ambil data dari database
        return view('admin.katsinov.forminformasidasar', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       //
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFormInformasiDasarRequest $request)
    {
        try {
            // dd($request->all());
            DB::beginTransaction();
            
            $validated = $request->validated();
            Log::info('Validated data:', $validated);
            
            $form = InnovatorForm::create($validated);
            
            $this->saveRelations($form, $request);
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving form: '.$e->getMessage());
            Log::error('Error trace: '.$e->getTraceAsString());
            return redirect()->back()->with('error', 'Gagal menyimpan data: '.$e->getMessage());
        }
    }
    
    private function saveRelations($form, $request)
    {
        // Team members
        if ($request->has('team_members')) {
            $members = array_filter($request->team_members, function($m) {
                return !empty($m['nama']);
            });
            $form->teamMembers()->createMany($members);
        }
        
        // Funding sources
        if ($request->has('funding_sources')) {
            $sources = array_filter($request->funding_sources, function($s) {
                return !empty($s['tahun_ke']);
            });
            $form->fundingSources()->createMany($sources);
        }
        //partner
        if ($request->has('partners')) {
            $partners = array_filter($request->partners, function($p) {
                return !empty($p['nama_mitra']);
            });
            $form->partners()->createMany($partners);
        }

        // Progress
        $this->saveProgress($form, $request);
    }
    
    private function saveProgress($form, $request)
    {
        $progress = [];
        
        // Technology Progress
        if ($request->has('technology_progress')) {
            foreach ($request->technology_progress as $tp) {
                if (!empty($tp['status'])) {
                    $progress[] = new FormProgress([
                        'type' => 'technology',
                        'uraian' => $tp['uraian'],
                        'status' => $tp['status'],
                        'keterangan' => $tp['keterangan']
                    ]);
                }
            }
        }
        
        // Market Progress
        if ($request->has('market_progress')) {
            foreach ($request->market_progress as $mp) {
                if (!empty($mp['status'])) {
                    $progress[] = new FormProgress([
                        'type' => 'market',
                        'uraian' => $mp['uraian'],
                        'status' => $mp['status'],
                        'keterangan' => $mp['keterangan']
                    ]);
                }
            }
        }
        
        $form->progress()->saveMany($progress);
    }
        
        // Similar logic for market progress
        
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
