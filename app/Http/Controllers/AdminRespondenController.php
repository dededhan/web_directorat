<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRespondenRequest;
use App\Http\Requests\UpdateRespondenRequest;
use App\Models\Responden;
use App\Models\User; // Added
use Illuminate\Validation\Rule;
use App\Imports\RespondenImport;
use App\Exports\RespondenExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth; // Added
use Illuminate\Support\Facades\Log;   // Added

class AdminRespondenController extends Controller
{

    private function getUserFacultyInfo(User $user)
    {
        $userFaculty = null;

        if ($user->role === 'fakultas') {
            $userFaculty = strtolower($user->name); 
        } elseif ($user->role === 'prodi') {
            $parts = explode('-', $user->name, 2);
            if (count($parts) === 2) {
                $userFaculty = strtolower($parts[0]); 
            } else {
                Log::warning('Responden: Unexpected name format for prodi user: ' . $user->name, ['user_id' => $user->id]);
                $userFaculty = strtolower($user->name);
            }
        }
        return ['faculty_code' => $userFaculty];
    }


    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        $userInfo = $this->getUserFacultyInfo($user);

        $sort = $request->get('sort', 'fullname');
        $direction = $request->get('direction', 'asc');
    
        $allowedSorts = ['title', 'fullname', 'jabatan', 'instansi', 'email', 'phone_responden', 'nama_dosen_pengusul', 'phone_dosen', 'fakultas', 'category', 'status'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'fullname'; 
        }
        $direction = in_array(strtolower($direction), ['asc', 'desc']) ? $direction : 'asc';
    
        $query = Responden::query();
    
        if ($role === 'fakultas' || $role === 'prodi') {
            if ($userInfo['faculty_code']) {
                $query->where('fakultas', $userInfo['faculty_code']);
            } else {
                Log::warning('Responden Index: Could not determine faculty for user.', ['user_id' => $user->id, 'role' => $role]);
                $query->whereRaw('1 = 0'); 
            }
        }

        if ($request->filled('kategori')) {
            $query->where('category', $request->kategori);
        }
        if (in_array($role, ['admin_direktorat', 'admin_pemeringkatan']) && $request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }
    
        $query->orderBy($sort, $direction);
        $respondens = $query->paginate(25)->appends($request->query());
    
        $viewData = ['respondens' => $respondens, 'user_info' => $userInfo]; 
        $routePrefix = ''; 

        switch ($role) {
            case 'admin_direktorat':
                $routePrefix = 'admin';
                return view('admin.respondenadmin', $viewData + ['routePrefix' => $routePrefix]);
            case 'admin_pemeringkatan':
                $routePrefix = 'admin_pemeringkatan';
                return view('admin_pemeringkatan.respondenadmin', $viewData + ['routePrefix' => $routePrefix]); // Ensure this view exists
            case 'fakultas':
                $routePrefix = 'fakultas';
                return view('fakultas.respondenadmin', $viewData + ['routePrefix' => $routePrefix]);
            case 'prodi':
                $routePrefix = 'prodi';
                return view('prodi.respondenadmin', $viewData + ['routePrefix' => $routePrefix]); 
            default:
                Log::error('Responden Index: Unhandled role.', ['user_id' => $user->id, 'role' => $role]);
                return redirect('/')->with('error', 'Akses tidak sah.');
        }
    }
    

    public function create()
    {
        if (!in_array(Auth::user()->role, ['admin_direktorat', 'admin_pemeringkatan', 'fakultas'])) {
             return redirect()->back()->with('error', 'Anda tidak diizinkan membuat responden.');
        }
        $viewData = [];
        if(Auth::user()->role === 'admin_direktorat' || Auth::user()->role === 'admin_pemeringkatan'){
            // $viewData['faculties'] = ... // Fetch faculties if admin needs to select
        }
        return view('admin.responden.create', $viewData); // A generic create view, or role-specific
    }

    public function store(StoreRespondenRequest $request)
    {
        $user = Auth::user();
        $role = $user->role;
        $respondenValidated = $request->validated();
        
        if (!in_array($role, ['admin_direktorat', 'admin_pemeringkatan', 'fakultas'])) {
             return redirect()->back()->with('error', 'Anda tidak diizinkan menyimpan responden.')->withInput();
        }

        if ($role === 'fakultas') {
            $userInfo = $this->getUserFacultyInfo($user);
            if ($userInfo['faculty_code']) {
                if (isset($respondenValidated['responden_fakultas']) && $respondenValidated['responden_fakultas'] !== $userInfo['faculty_code']) {
                    Log::warning('Fakultas user trying to store responden for different faculty.', [
                        'user_id' => $user->id, 
                        'submitted_fakultas' => $respondenValidated['responden_fakultas'],
                        'user_fakultas' => $userInfo['faculty_code']
                    ]);
                }
                $respondenValidated['responden_fakultas'] = $userInfo['faculty_code'];
            } else {
                return redirect()->back()->with('error', 'Tidak dapat menentukan fakultas Anda.')->withInput();
            }
        }

        $responden = Responden::create([
            'title' => $respondenValidated['responden_title'],
            'fullname' => $respondenValidated['responden_fullname'],
            'jabatan' => $respondenValidated['responden_jabatan'],
            'instansi' => $respondenValidated['responden_instansi'],
            'email' => $respondenValidated['email'],
            'phone_responden' => $respondenValidated['phone_responden'],
            'nama_dosen_pengusul' => $respondenValidated['responden_dosen'],
            'phone_dosen' => $respondenValidated['responden_dosen_phone'],
            'fakultas' => $respondenValidated['responden_fakultas'], 
            'category' => $respondenValidated['responden_category'],
            // 'user_id' => $user->id, // kalo mau simpan unlock aje - grants
        ]);

        $redirectRouteName = 'admin.responden.index';
        if ($role === 'fakultas') {
            $redirectRouteName = 'fakultas.responden.index';
        } elseif ($role === 'admin_pemeringkatan') {
            $redirectRouteName = 'admin_pemeringkatan.responden.index';
        }

        return redirect(route($redirectRouteName))->with('success', 'Responden berhasil ditambahkan!');
    }

    public function show(Responden $responden)
    {
        $user = Auth::user();
        $role = $user->role;
        $userInfo = $this->getUserFacultyInfo($user);

        if (($role === 'fakultas' || $role === 'prodi') && $userInfo['faculty_code']) {
            if ($responden->fakultas !== $userInfo['faculty_code']) {
                return redirect()->route($role . '.responden.index')->with('error', 'Anda tidak diizinkan melihat detail responden ini.');
            }
        } elseif (!in_array($role, ['admin_direktorat', 'admin_pemeringkatan'])) {
             return redirect()->route($role . '.dashboard')->with('error', 'Akses tidak sah.');
        }
        $viewName = 'admin.responden.show';
        if($role === 'fakultas') $viewName = 'fakultas.responden.show';
        if($role === 'prodi') $viewName = 'prodi.responden.show';
        return response()->json($responden);
    }

    public function edit(Responden $responden)
    {
        $user = Auth::user();
        $role = $user->role;
        $userInfo = $this->getUserFacultyInfo($user);

        if ($role === 'fakultas' && $userInfo['faculty_code']) {
            if ($responden->fakultas !== $userInfo['faculty_code']) {
                return response()->json(['message' => 'Anda tidak diizinkan mengedit responden ini.'], 403); 
            }
        } elseif (!in_array($role, ['admin_direktorat', 'admin_pemeringkatan'])) {
             return response()->json(['message' => 'Anda tidak diizinkan mengedit responden ini.'], 403); 

        }

        if(request()->ajax()){
            return response()->json($responden);
        }
        $viewData = ['responden' => $responden];
         if(Auth::user()->role === 'admin_direktorat' || Auth::user()->role === 'admin_pemeringkatan'){
        }
        return view('admin.responden.edit', $viewData); 
    }

    public function update(UpdateRespondenRequest $request, $id)
    {
        $responden = Responden::findOrFail($id);
        $user = Auth::user();
        $role = $user->role;
        $userInfo = $this->getUserFacultyInfo($user);
        $validated = $request->validated();

        if ($role === 'fakultas' && $userInfo['faculty_code']) {
            if ($responden->fakultas !== $userInfo['faculty_code']) {
                return response()->json(['message' => 'Anda tidak diizinkan memperbarui responden ini.'], 403);
            }
            $validated['fakultas'] = $userInfo['faculty_code'];
        } elseif (!in_array($role, ['admin_direktorat', 'admin_pemeringkatan'])) {
             return response()->json(['message' => 'Anda tidak diizinkan memperbarui responden ini.'], 403);
        }
        
        $responden->update($validated);
        
        if ($request->ajax()) {
            return response()->json([
                'message' => 'Data berhasil diperbarui',
                'data' => $responden
            ]);
        }
        // role standard
        $redirectRouteName = 'admin.responden.index';
        if ($role === 'fakultas') $redirectRouteName = 'fakultas.responden.index';
        if ($role === 'admin_pemeringkatan') $redirectRouteName = 'admin_pemeringkatan.responden.index';
        return redirect()->route($redirectRouteName)->with('success', 'Data berhasil diperbarui');
    }

    public function updateStatus(Request $request, $id)
    {
        if (!in_array(Auth::user()->role, ['admin_direktorat', 'admin_pemeringkatan'])) {
            return response()->json(['message' => 'Unauthorized to update status'], 403);
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in(['belum', 'done', 'dones', 'clear'])]
        ]);
    
        $responden = Responden::findOrFail($id);
        $responden->update($validated);
    
        return response()->json([
            'message' => 'Status berhasil diperbarui',
            'new_status' => $validated['status']
        ]);
    }
     
    public function destroy(Responden $responden)
    {
        $user = Auth::user();
        $role = $user->role;
        $userInfo = $this->getUserFacultyInfo($user);

        if ($role === 'fakultas' && $userInfo['faculty_code']) {
            if ($responden->fakultas !== $userInfo['faculty_code']) {
                return redirect()->back()->with('error', 'Anda tidak diizinkan menghapus responden ini.');
            }
        } elseif (!in_array($role, ['admin_direktorat', 'admin_pemeringkatan'])) {
            return redirect()->back()->with('error', 'Anda tidak diizinkan menghapus responden ini.');
        }

        try {
            $responden->delete();
            $redirectRouteName = 'admin.responden.index'; 
            if ($role === 'fakultas') $redirectRouteName = 'fakultas.responden.index';
            if ($role === 'admin_pemeringkatan') $redirectRouteName = 'admin_pemeringkatan.responden.index';

            return redirect()->route($redirectRouteName)->with('success', 'Responden berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting responden: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus responden.');
        }
    }

    public function import(Request $request)
    {
         if (!in_array(Auth::user()->role, ['admin_direktorat', 'admin_pemeringkatan'])) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        try {
            Excel::import(new RespondenImport($request->has('skip_duplicates')), $request->file('file'));
            return redirect()->back()->with('success', 'Data responden berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    public function filter(Request $request) 
    {
        if (!in_array(Auth::user()->role, ['admin_direktorat', 'admin_pemeringkatan'])) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        $query = Responden::query();
        if ($request->filled('email')) { 
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->filled('phone')) {
            $query->where('phone_responden', 'like', '%' . $request->phone . '%');
        }
        //pusing wak
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }
        $respondens = $query->paginate(25)->appends($request->query());
        
        return view('admin.respondenadmin', compact('respondens')); 
    }

    public function export(Request $request)
    {
         if (!in_array(Auth::user()->role, ['admin_direktorat', 'admin_pemeringkatan'])) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        $kategori = $request->input('kategori');
        $fakultas = $request->input('fakultas');
        return Excel::download(new RespondenExport($kategori, $fakultas), 'responden-data.xlsx');
    }
    
    public function exportCSV(Request $request)
    {
         if (!in_array(Auth::user()->role, ['admin_direktorat', 'admin_pemeringkatan'])) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        $kategori = $request->input('kategori');
        $fakultas = $request->input('fakultas');
        return Excel::download(new RespondenExport($kategori, $fakultas), 'responden-data.csv');
    }
}
