<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRespondenRequest;
use App\Http\Requests\UpdateRespondenRequest;
use App\Models\User;
use App\Imports\RespondenImport;
use App\Exports\RespondenExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\RespondenInvitationMail;
use Illuminate\Validation\Rule;
use App\Models\Responden;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
    public function laporan()
    {
        if (Auth::user()->role !== 'admin_direktorat') {
            return redirect()->route('admin.dashboard')->with('error', 'Tidak ada akses');
        }
        $faculties = Responden::query()
            ->select('fakultas')
            ->whereNotNull('fakultas')
            ->where('fakultas', '!=', '')
            ->distinct()
            ->orderBy('fakultas')
            ->get()
            ->map(function ($item) {
                $item->fakultas_cleaned = $this->normalizeFacultyName($item->fakultas);
                return $item;
            })
            ->pluck('fakultas_cleaned', 'fakultas_cleaned')
            ->sort()
            ->unique();

        return view('admin.responden_laporan', compact('faculties'));
    }

    public function laporanFakultas()
    {
        if (Auth::user()->role !== 'fakultas') {
            return redirect()->route('fakultas.dashboard')->with('error', 'Tidak ada akses');
        }
        return view('fakultas.responden_laporan');
    }



    private function normalizeFacultyName($faculty)
    {
        $faculty = strtolower(trim($faculty));
        $map = [
            'teknik' => 'ft',
            'fpbs' => 'fbs',
            'fkip' => 'fip',

        ];

        if (array_key_exists($faculty, $map)) {
            return $map[$faculty];
        }

        if (empty($faculty)) {
            return 'tidak terdefinisi';
        }

        return $faculty;
    }

    private function normalizeCategoryName($category)
    {
        $category = strtolower(trim($category));

        if (Str::contains($category, ['academic', 'researcher', 'reseracher'])) {
            return 'academic';
        }

        if (Str::contains($category, 'employer')) {
            return 'employer';
        }

        if (empty($category)) {
            return 'lainnya';
        }

        return 'lainnya';
    }



    public function getChartSummaryData(Request $request)
    {
        try {
            $query = Responden::query();

            //Validation anabel
            if (
                $request->has('start_date') && $request->filled('start_date') &&
                $request->has('end_date') && $request->filled('end_date')
            ) {

                try {
                    $startDate = Carbon::parse($request->start_date)->startOfDay();
                    $endDate = Carbon::parse($request->end_date)->endOfDay();

                    if ($startDate->isValid() && $endDate->isValid()) {
                        $query->whereBetween('created_at', [$startDate, $endDate]);
                    }
                } catch (\Exception $e) {
                    Log::warning('Invalid date format in chart summary request', [
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            $respondens = $query->get();
            $normalizedRespondens = $respondens->map(function ($responden) {
                $responden->fakultas = $this->normalizeFacultyName($responden->fakultas);
                $responden->category = $this->normalizeCategoryName($responden->category);
                return $responden;
            });

            $byFaculty = $normalizedRespondens->groupBy('fakultas')->map->count();
            $byCategory = $normalizedRespondens->groupBy('category')->map->count();
            $byStatus = $respondens->groupBy('status')->map->count();

            $inputterIds = Responden::query()->distinct()->pluck('user_id');
            $inputters = User::whereIn('id', $inputterIds)->get();

            $byInputterFaculty = $inputters->map(function ($user) {
                if ($user->role === 'fakultas') {
                    return $this->normalizeFacultyName(strtolower($user->name));
                } elseif ($user->role === 'prodi') {
                    $parts = explode('-', $user->name, 2);
                    return $this->normalizeFacultyName(strtolower($parts[0] ?? 'unknown'));
                }
                return 'lainnya';
            })->countBy();

            return response()->json([
                'byFaculty' => $byFaculty,
                'byCategory' => $byCategory,
                'byStatus' => $byStatus,
                'byInputterFaculty' => $byInputterFaculty
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching chart summary data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch chart data'], 500);
        }
    }

    public function getProdiChartData(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        // validation anabel
        $request->validate([
            'fakultas' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        try {
            $facultyCode = null;

            //fakultas anabel
            if ($role === 'fakultas') {
                $userInfo = $this->getUserFacultyInfo($user);
                $facultyCode = $userInfo['faculty_code'];
            } elseif ($request->filled('fakultas')) {
                $facultyCode = $request->fakultas;
            }

            if (!$facultyCode) {
                return response()->json([]);
            }

            $query = Responden::query()
                ->join('users', 'respondens.user_id', '=', 'users.id')
                ->where('users.role', 'prodi')
                ->where('users.name', 'like', $facultyCode . '-%');

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $startDate = Carbon::parse($request->start_date)->startOfDay();
                $endDate = Carbon::parse($request->end_date)->endOfDay();
                $query->whereBetween('respondens.created_at', [$startDate, $endDate]);
            }

            $data = $query->select('users.name as prodi_name', DB::raw('count(respondens.id) as count'))
                ->groupBy('users.name')
                ->get()
                ->mapWithKeys(function ($item) {
                    $prodiName = Str::after($item->prodi_name, '-');
                    $prodiName = ucwords(trim($prodiName));
                    return [$prodiName => $item->count];
                });

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error fetching prodi chart data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch prodi chart data'], 500);
        }
    }




    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        $userInfo = $this->getUserFacultyInfo($user);


        $sort = $request->get('sort', 'fullname');
        $direction = $request->get('direction', 'asc');


        $perPage = $request->input('per_page', 10);
        if (!in_array($perPage, [10, 50, 100, 2000])) {
            $perPage = 10;
        }


        $allowedSorts = ['title', 'fullname', 'jabatan', 'instansi', 'email', 'phone_responden', 'nama_dosen_pengusul', 'phone_dosen', 'fakultas', 'category', 'status', 'created_at'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'fullname';
        }
        $direction = in_array(strtolower($direction), ['asc', 'desc']) ? $direction : 'asc';

        $query = Responden::query();
        if ($role === 'prodi') {
            $query->where('user_id', $user->id);
        } elseif ($role === 'fakultas') {
            $facultyCode = $userInfo['faculty_code'];
            if ($facultyCode) {
                $prodiUserIds = User::where('role', 'prodi')
                    ->where('name', 'like', $facultyCode . '-%')
                    ->pluck('id');
                $allUserIds = $prodiUserIds->push($user->id)->all();
                $query->whereIn('user_id', $allUserIds);
            } else {
                Log::warning('Tidak dapat menemukan kode fakultas untuk user: ' . $user->name, ['user_id' => $user->id]);
                $query->where('user_id', $user->id);
            }
        }
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('fullname', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%")
                    ->orWhere('instansi', 'like', "%{$searchTerm}%")
                    ->orWhere('jabatan', 'like', "%{$searchTerm}%")
                    ->orWhere('fakultas', 'like', "%{$searchTerm}%")
                    ->orWhere('category', 'like', "%{$searchTerm}%")
                    ->orWhere('nama_dosen_pengusul', 'like', "%{$searchTerm}%");
            });
        }
        if ($request->filled('kategori')) {
            $query->where('category', $request->kategori);
        }
        if (in_array($role, ['admin_direktorat', 'admin_pemeringkatan']) && $request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }

        if ($request->filled('filter_date')) {
            $query->whereDate('created_at', $request->filter_date);
        }
        $query->orderBy($sort, $direction);


        $respondens = $query->paginate($perPage)->appends($request->query());


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
        }
        return view('admin.responden.create', $viewData);
    }

    public function store(StoreRespondenRequest $request)
    {
        $user = Auth::user();
        $role = $user->role;
        $respondenValidated = $request->validated();

        if (!in_array($role, ['admin_direktorat', 'admin_pemeringkatan', 'fakultas', 'prodi'])) {
            return redirect()->back()->with('error', 'Anda tidak diizinkan menyimpan responden.')->withInput();
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

        ]);

        $redirectRouteName = 'admin.responden.index';
        if ($role === 'fakultas') {
            $redirectRouteName = 'fakultas.responden.index';
        } elseif ($role === 'prodi') {
            $redirectRouteName = 'prodi.responden.index';
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

        return response()->json($responden);
    }

    public function edit(Responden $responden)
    {
        $user = Auth::user();
        $role = $user->role;
        $userInfo = $this->getUserFacultyInfo($user);


        if ($role === 'fakultas') {
            $userInfo = $this->getUserFacultyInfo($user);
            if (!$userInfo['faculty_code'] || $responden->fakultas !== $userInfo['faculty_code']) {
                return response()->json(['message' => 'Akses ditolak.'], 403);
            }
        } elseif ($role === 'prodi') {
            if ($responden->user_id !== $user->id) {
                return response()->json(['message' => 'Akses ditolak. Anda hanya boleh mengedit data yang Anda buat.'], 403);
            }
        } elseif (!in_array($role, ['admin_direktorat', 'admin_pemeringkatan'])) {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        return response()->json($responden);
    }


    public function update(UpdateRespondenRequest $request, Responden $responden)
    {
        $user = Auth::user();
        $role = $user->role;
        $validated = $request->validated();


        if ($role === 'prodi') {
            if ($responden->user_id !== $user->id) {
                return response()->json(['message' => 'Akses ditolak. Anda tidak diizinkan memperbarui data ini.'], 403);
            }
        } elseif ($role === 'fakultas') {
            $userInfo = $this->getUserFacultyInfo($user);
            if ($responden->fakultas !== $userInfo['faculty_code']) {
                return response()->json(['message' => 'Anda tidak diizinkan memperbarui responden ini.'], 403);
            }
        }



        $responden->update($validated);


        return response()->json([
            'message' => 'Data berhasil diperbarui',
            'data' => $responden->fresh()
        ]);
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
        $newStatus = $validated['status'];

        if ($newStatus === 'done' && $responden->status !== 'done') {
            // Generate token if doesn't exist
            $token = $responden->token ?? Str::random(40);

            // Update with token and status
            $responden->update([
                'status' => $newStatus,
                'token' => $token
            ]);

            try {
                // Verify required fields
                if (empty($responden->email)) {
                    throw new \Exception('Email responden tidak boleh kosong');
                }
                if (empty($responden->fullname)) {
                    throw new \Exception('Nama responden tidak boleh kosong');
                }

                // Send email
                Mail::to($responden->email)->send(new RespondenInvitationMail($responden));

                return response()->json([
                    'message' => 'Status berhasil diperbarui dan email telah dikirim.',
                    'new_status' => $newStatus
                ]);
            } catch (\Exception $e) {
                Log::error('Email error for responden ' . $responden->id . ': ' . $e->getMessage());

                return response()->json([
                    'message' => 'Status berhasil diupdate, tapi email gagal dikirim: ' . $e->getMessage(),
                    'new_status' => $newStatus
                ], 200);
            }
        } else {

            $responden->update(['status' => $newStatus]);
            return response()->json([
                'message' => 'Status berhasil diperbarui.',
                'new_status' => $newStatus
            ]);
        }
    }

    public function destroy(Request $request, Responden $responden)
    {
        $user = Auth::user();
        $role = $user->role;
        $userInfo = $this->getUserFacultyInfo($user);

        // Authorization logic
        if ($role === 'fakultas') {
            if ($responden->fakultas !== $userInfo['faculty_code']) {
                if ($request->ajax()) {
                    return response()->json(['message' => 'Anda tidak diizinkan menghapus responden ini.'], 403);
                }
                return redirect()->back()->with('error', 'Anda tidak diizinkan menghapus responden ini.');
            }
        } elseif ($role === 'prodi') {
            if ($responden->user_id !== $user->id) {
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
            elseif ($role === 'prodi') $redirectRouteName = 'prodi.responden.index';
            elseif ($role === 'admin_pemeringkatan') $redirectRouteName = 'admin_pemeringkatan.responden.index';

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
        if (!in_array(Auth::user()->role, ['admin_direktorat', 'admin_pemeringkatan', 'fakultas', 'prodi'])) {

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


            $successMessage = "Proses impor selesai. <br><br>" .
                "&bull; Berhasil diimpor: <strong>" . $importedCount . "</strong> baris. <br>" .
                "&bull; Dilewati (duplikat): <strong>" . $skippedCount . "</strong> baris.";


            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'message' => $successMessage]);
            }


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
                return response()->json(['success' => false, 'message' => $finalMessage], 500); // 
            }
            return redirect()->back()->with('error', $finalMessage);
        }
        $redirectRouteName = 'admin.responden.index';
        if ($role === 'fakultas') {
            $redirectRouteName = 'fakultas.responden.index';
        } elseif ($role === 'prodi') {
            $redirectRouteName = 'prodi.responden.index';
        } elseif ($role === 'admin_pemeringkatan') {
            $redirectRouteName = 'admin_pemeringkatan.responden.index';
        }

        return redirect(route($redirectRouteName))->with('success', 'Responden berhasil ditambahkan!');
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
        if ($request->filled('tahun') && \Illuminate\Support\Facades\Schema::hasColumn('respondens', 'tahun')) {
            $query->where('tahun', $request->tahun);
        } elseif ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        $respondens = $query->paginate(25)->appends($request->query());


        $role = Auth::user()->role;
        $viewName = 'admin.respondenadmin'; // Default
        if ($role === 'admin_pemeringkatan') {
            $viewName = 'admin_pemeringkatan.respondenadmin';
        }

        return view($viewName, compact('respondens'));
    }

    public function export(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin_direktorat', 'admin_pemeringkatan', 'fakultas', 'prodi'])) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $kategori = $request->input('kategori');
        $fakultas = $request->input('fakultas');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $fileName = 'responden-data-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new RespondenExport($user, $kategori, $fakultas, $startDate, $endDate), $fileName);
    }

    public function exportCSV(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin_direktorat', 'admin_pemeringkatan', 'fakultas', 'prodi'])) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $kategori = $request->input('kategori');
        $fakultas = $request->input('fakultas');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $fileName = 'responden-data-' . now()->format('Ymd-His') . '.csv';
        return Excel::download(new RespondenExport($user, $kategori, $fakultas, $startDate, $endDate), $fileName);
    }



    public function getChartData(Request $request)
    {
        try {
            $user = Auth::user();
            $role = $user->role;
            $userInfo = $this->getUserFacultyInfo($user);

            $query = Responden::query();

            if ($role === 'fakultas' || $role === 'prodi') {
                if ($userInfo['faculty_code']) {
                    $query->where('fakultas', $userInfo['faculty_code']);
                } else {
                    Log::warning('Chart Data: Could not determine faculty for user.', ['user_id' => $user->id, 'role' => $role]);
                    return response()->json([]);
                }
            }

            $respondens = $query->select([
                'id',
                'fullname',
                'fakultas',
                'category',
                'status',
                'created_at'
            ])->get();

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
