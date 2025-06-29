<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRespondenRequest;
use App\Http\Requests\UpdateRespondenRequest;
use App\Models\Responden;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Imports\RespondenImport;
use App\Exports\RespondenExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // Added for database queries

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
        // $userInfo = $this->getUserFacultyInfo($user);

        $sort = $request->get('sort', 'fullname');
        $direction = $request->get('direction', 'asc');

        $allowedSorts = ['title', 'fullname', 'jabatan', 'instansi', 'email', 'phone_responden', 'nama_dosen_pengusul', 'phone_dosen', 'fakultas', 'category', 'status'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'fullname';
        }
        $direction = in_array(strtolower($direction), ['asc', 'desc']) ? $direction : 'asc';

        $query = Responden::query();

        if ($role === 'fakultas' || $role === 'prodi') {
        $query->where('user_id', $user->id);
        }

        if ($request->filled('kategori')) {
            $query->where('category', $request->kategori);
        }
        if (in_array($role, ['admin_direktorat', 'admin_pemeringkatan']) && $request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }

        // Add year filter if 'tahun' column exists and is provided in request
        // if ($request->filled('tahun') && Schema::hasColumn('respondens', 'tahun')) { // Assuming 'tahun' column
        //     $query->where('tahun', $request->tahun);
        // } elseif ($request->filled('tahun')) { // Fallback to created_at if 'tahun' column doesn't exist
        //     $query->whereYear('created_at', $request->tahun);
        // }


        $query->orderBy($sort, $direction);
        
        // $respondens = $query->paginate(25)->appends($request->query());
        $respondens = $query->paginate(1000)->appends($request->query());

        $userInfo = $this->getUserFacultyInfo($user); 

        $viewData = ['respondens' => $respondens, 'user_info' => $userInfo];
        $routePrefix = '';

        switch ($role) {
            case 'admin_direktorat':
                $routePrefix = 'admin';
                return view('admin.respondenadmin', $viewData + ['routePrefix' => $routePrefix]);
            case 'admin_pemeringkatan':
                $routePrefix = 'admin_pemeringkatan';
                return view('admin_pemeringkatan.respondenadmin', $viewData + ['routePrefix' => $routePrefix]);
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
        if (Auth::user()->role === 'admin_direktorat' || Auth::user()->role === 'admin_pemeringkatan') {
            // $viewData['faculties'] = ... // Fetch faculties if admin needs to select
        }
        return view('admin.responden.create', $viewData);
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
            'user_id' => $user->id, 
            // 'user_id' => $user->id, //
            // 'tahun' => $request->input('tahun_input_field', date('Y')), // Add this if you have a dedicated 'tahun' field in the form/table
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
        // $viewName = 'admin.responden.show'; // Assuming you might have a show view
        // if($role === 'fakultas') $viewName = 'fakultas.responden.show';
        // if($role === 'prodi') $viewName = 'prodi.responden.show';
        // return view($viewName, compact('responden'));
        return response()->json($responden); // If primarily used for AJAX details
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

        if (request()->ajax()) {
            return response()->json($responden);
        }
        $viewData = ['responden' => $responden];
        //  if(Auth::user()->role === 'admin_direktorat' || Auth::user()->role === 'admin_pemeringkatan'){
        // }
        // return view('admin.responden.edit', $viewData); // Or role-specific edit views
        // Fallback or decide on a default edit view if not AJAX
        $editView = 'admin.responden.edit'; // Default
        if ($role === 'fakultas') $editView = 'fakultas.responden.edit';
        // Add other roles if they have specific edit views
        return view($editView, $viewData);
    }

    public function update(UpdateRespondenRequest $request, $id) // UpdateRespondenRequest should have authorize() return true
    {
        $responden = Responden::findOrFail($id);
        $user = Auth::user();
        $role = $user->role;
        $userInfo = $this->getUserFacultyInfo($user);
        $validated = $request->validated(); // Ensure UpdateRespondenRequest has rules() defined

        if ($role === 'fakultas' && $userInfo['faculty_code']) {
            if ($responden->fakultas !== $userInfo['faculty_code']) {
                return response()->json(['message' => 'Anda tidak diizinkan memperbarui responden ini.'], 403);
            }
            // Ensure faculty is not changed by faculty user, or set it explicitly
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

    public function destroy(Request $request, Responden $responden)
    {
        $user = Auth::user();
        $role = $user->role;
        $userInfo = $this->getUserFacultyInfo($user);

        // Authorization logic
        if ($role === 'fakultas' && $userInfo['faculty_code']) {
            if ($responden->fakultas !== $userInfo['faculty_code']) {
                if ($request->ajax()) {
                    return response()->json(['message' => 'Anda tidak diizinkan menghapus responden ini.'], 403);
                }
                return redirect()->back()->with('error', 'Anda tidak diizinkan menghapus responden ini.');
            }
        } elseif (!in_array($role, ['admin_direktorat', 'admin_pemeringkatan'])) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Anda tidak diizinkan menghapus responden ini.'], 403);
            }
            return redirect()->back()->with('error', 'Anda tidak diizinkan menghapus responden ini.');
        }

        try {
            $responden->delete();

            if ($request->ajax()) {
                return response()->json(['message' => 'Responden berhasil dihapus.']);
            }

            $redirectRouteName = 'admin.responden.index';
            if ($role === 'fakultas') $redirectRouteName = 'fakultas.responden.index';
            if ($role === 'admin_pemeringkatan') $redirectRouteName = 'admin_pemeringkatan.responden.index';
            
            return redirect()->route($redirectRouteName)->with('success', 'Responden berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Error deleting responden: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json(['message' => 'Gagal menghapus responden.'], 500);
            }

            return redirect()->back()->with('error', 'Gagal menghapus responden.');
        }
    }

    public function import(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin_direktorat', 'admin_pemeringkatan'])) {
            // Jika request adalah AJAX, kembalikan error JSON
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
            }
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        
        // Validasi tetap sama
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls'
        ]);

        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $errorMessage], 422); // 422 Unprocessable Entity
            }
            return redirect()->back()->with('error', $errorMessage);
        }

        try {
            $userId = Auth::id();
            $import = new RespondenImport($userId, $request->has('skip_duplicates'));
            Excel::import($import, $request->file('file'));

            
            $importedCount = $import->getImportedCount();
            $skippedCount = $import->getSkippedCount();

            // [PENTING] Buat pesan dengan tag HTML
            $successMessage = "Proses impor selesai. <br><br>" .
                            "&bull; Berhasil diimpor: <strong>" . $importedCount . "</strong> baris. <br>" .
                            "&bull; Dilewati (duplikat): <strong>" . $skippedCount . "</strong> baris.";

            // Jika request adalah AJAX, kembalikan respons JSON
            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'message' => $successMessage]);
            }
            
            // Jika request biasa, lakukan redirect dengan flash message
            return redirect()->back()->with('success', $successMessage);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            $finalMessage = 'Error validasi saat impor: ' . implode('; ', $errorMessages);

            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $finalMessage], 422);
            }
            return redirect()->back()->with('error', $finalMessage);

        } catch (\Exception $e) {
            Log::error('Import Error: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            $finalMessage = 'Terjadi kesalahan pada server saat impor: ' . $e->getMessage();
            
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $finalMessage], 500); // 500 Internal Server Error
            }
            return redirect()->back()->with('error', $finalMessage);
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
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }
        // Add year filter if 'tahun' column exists and is provided in request
        if ($request->filled('tahun') && \Illuminate\Support\Facades\Schema::hasColumn('respondens', 'tahun')) {
            $query->where('tahun', $request->tahun);
        } elseif ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        $respondens = $query->paginate(25)->appends($request->query());

        // Determine the correct view based on role, similar to index()
        $role = Auth::user()->role;
        $viewName = 'admin.respondenadmin'; // Default
        if ($role === 'admin_pemeringkatan') {
            $viewName = 'admin_pemeringkatan.respondenadmin';
        } // Add other roles if they have specific views for filtered results

        return view($viewName, compact('respondens'));
    }

    public function export(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin_direktorat', 'admin_pemeringkatan'])) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        $kategori = $request->input('kategori');
        $fakultas = $request->input('fakultas');
        $tahun = $request->input('tahun'); // Added year parameter
        return Excel::download(new RespondenExport($kategori, $fakultas, $tahun), 'responden-data.xlsx');
    }

    public function exportCSV(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin_direktorat', 'admin_pemeringkatan'])) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        $kategori = $request->input('kategori');
        $fakultas = $request->input('fakultas');
        $tahun = $request->input('tahun'); // Added year parameter
        return Excel::download(new RespondenExport($kategori, $fakultas, $tahun), 'responden-data.csv');
    }


    public function getChartData(Request $request)
    {
        try {
            $user = Auth::user();
            $role = $user->role;
            $userInfo = $this->getUserFacultyInfo($user);

            $query = Responden::query();

            // Apply role-based filtering
            if ($role === 'fakultas' || $role === 'prodi') {
                if ($userInfo['faculty_code']) {
                    $query->where('fakultas', $userInfo['faculty_code']);
                } else {
                    Log::warning('Chart Data: Could not determine faculty for user.', ['user_id' => $user->id, 'role' => $role]);
                    return response()->json([]);
                }
            }

            // Get all responden data with required fields
            $respondens = $query->select([
                'id',
                'fullname',
                'fakultas',
                'category',
                'status',
                'created_at'
            ])->get();

            // Transform data for frontend
            $chartData = $respondens->map(function ($responden) {
                return [
                    'id' => $responden->id,
                    'name' => $responden->fullname,
                    'fakultas' => $responden->fakultas,
                    'category' => $responden->category,
                    'status' => $responden->status,
                    'year' => $responden->created_at ? $responden->created_at->year : date('Y')
                ];
            });

            return response()->json($chartData);
        } catch (\Exception $e) {
            Log::error('Error fetching chart data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch chart data'], 500);
        }
    }
}
