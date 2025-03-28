<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreFormInformasiDasarRequest;
use App\Models\InnovatorForm;
use App\Models\FormProgress;
use App\Models\Katsinov;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; 

class FormInformasiDasarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $katsinov_id = $request->query('katsinov_id');
        $katsinov = null;
        
        if ($katsinov_id) {
            $katsinov = Katsinov::find($katsinov_id);
            if (!$katsinov) {
                return redirect()->back()->with('error', 'Katsinov data not found');
            }
        }
        
        // Get forms that may be linked to this katsinov
        $forms = InnovatorForm::when($katsinov_id, function($query) use ($katsinov_id) {
            return $query->where('katsinov_id', $katsinov_id);
        })->get();

        $view = '';
        if (Auth::user()->role === 'admin_direktorat') {
            $view = 'admin.katsinov.forminformasidasar';
        } else if (Auth::user()->role === 'dosen') {
            $view = 'Inovasi.dosen.forminformasidasar';
        } else if (Auth::user()->role === 'admin_hilirisasi') {
            $view = 'Inovasi.admin_hilirisasi.forminformasidasar';
        } else if (Auth::user()->role === 'validator') {
            $view = 'Inovasi.validator.forminformasidasar';
        } else if (Auth::user()->role === 'registered_user') {
            $view = 'Inovasi.registered_user.forminformasidasar';
        }

        return view($view, compact('forms', 'katsinov'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $katsinov_id = $request->query('katsinov_id');
        $katsinov = null;
        
        if ($katsinov_id) {
            $katsinov = Katsinov::find($katsinov_id);
            if (!$katsinov) {
                return redirect()->back()->with('error', 'Katsinov data not found');
            }
        }
        
        $view = '';
        if (Auth::user()->role === 'admin_direktorat') {
            $view = 'admin.katsinov.forminformasidasar';
        } else if (Auth::user()->role === 'dosen') {
            $view = 'Inovasi.dosen.forminformasidasar';
        } else if (Auth::user()->role === 'admin_hilirisasi') {
            $view = 'Inovasi.admin_hilirisasi.forminformasidasar';
        } else if (Auth::user()->role === 'validator') {
            $view = 'Inovasi.validator.forminformasidasar';
        } else if (Auth::user()->role === 'registered_user') {
            $view = 'Inovasi.registered_user.forminformasidasar';
        }

        return view($view, compact('katsinov'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFormInformasiDasarRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $validated = $request->validated();
            Log::info('Validated data:', $validated);
            
            // Add the katsinov_id if provided
            if ($request->has('katsinov_id')) {
                $validated['katsinov_id'] = $request->katsinov_id;
            }
            
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
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $form = InnovatorForm::findOrFail($id);
        $katsinov = null;
        
        if ($form->katsinov_id) {
            $katsinov = Katsinov::find($form->katsinov_id);
        }
        
        $view = '';
        if (Auth::user()->role === 'admin_direktorat') {
            $view = 'admin.katsinov.forminformasidasar-show';
        } else if (Auth::user()->role === 'dosen') {
            $view = 'Inovasi.dosen.forminformasidasar-show';
        } else if (Auth::user()->role === 'admin_hilirisasi') {
            $view = 'Inovasi.admin_hilirisasi.forminformasidasar-show';
        } else if (Auth::user()->role === 'validator') {
            $view = 'Inovasi.validator.forminformasidasar-show';
        } else if (Auth::user()->role === 'registered_user') {
            $view = 'Inovasi.registered_user.forminformasidasar-show';
        }

        return view($view, compact('form', 'katsinov'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Here we can handle two cases:
        // 1. $id is a InnovatorForm ID
        // 2. $id is a Katsinov ID (when redirected from TableKatsinov)
        
        $form = null;
        $katsinov = null;
        
        // First, try to find an InnovatorForm
        $form = InnovatorForm::find($id);
        
        if (!$form) {
            // If not found, try to find a Katsinov and get/create associated form
            $katsinov = Katsinov::find($id);
            
            if (!$katsinov) {
                return redirect()->back()->with('error', 'Data not found');
            }
            
            // Try to find an existing form for this katsinov
            $form = InnovatorForm::where('katsinov_id', $katsinov->id)->first();
            
            // If no form exists yet, we'll just pass the katsinov to the view
            // The view will show an empty form that can be submitted with the katsinov_id
        }
        else {
            // If we found a form, get its associated katsinov
            if ($form->katsinov_id) {
                $katsinov = Katsinov::find($form->katsinov_id);
            }
        }
        
        $view = '';
        if (Auth::user()->role === 'admin_direktorat') {
            $view = 'admin.katsinov.forminformasidasar';
        } else if (Auth::user()->role === 'dosen') {
            $view = 'Inovasi.dosen.forminformasidasar';
        } else if (Auth::user()->role === 'admin_hilirisasi') {
            $view = 'Inovasi.admin_hilirisasi.forminformasidasar';
        } else if (Auth::user()->role === 'validator') {
            $view = 'Inovasi.validator.forminformasidasar';
        } else if (Auth::user()->role === 'registered_user') {
            $view = 'Inovasi.registered_user.forminformasidasar';
        }

        return view($view, compact('form', 'katsinov'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreFormInformasiDasarRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            
            $form = InnovatorForm::findOrFail($id);
            
            $validated = $request->validated();
            
            // Preserve or update the katsinov_id
            if ($request->has('katsinov_id')) {
                $validated['katsinov_id'] = $request->katsinov_id;
            }
            
            $form->update($validated);
            
            // Clear and recreate relations
            $form->teamMembers()->delete();
            $form->fundingSources()->delete();
            $form->partners()->delete();
            $form->progress()->delete();
            
            $this->saveRelations($form, $request);
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating form: '.$e->getMessage());
            Log::error('Error trace: '.$e->getTraceAsString());
            return redirect()->back()->with('error', 'Gagal memperbarui data: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $form = InnovatorForm::findOrFail($id);
            
            // Delete associated records
            $form->teamMembers()->delete();
            $form->fundingSources()->delete();
            $form->partners()->delete();
            $form->progress()->delete();
            
            $form->delete();
            
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error deleting form: '.$e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus data: '.$e->getMessage());
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
}