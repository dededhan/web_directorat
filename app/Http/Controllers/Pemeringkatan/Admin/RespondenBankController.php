<?php

namespace App\Http\Controllers\Pemeringkatan\Admin;

use App\Http\Controllers\Controller;
use App\Models\RespondenBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RespondenBankImport;
use App\Exports\RespondenBankExport;

class RespondenBankController extends Controller
{
    public function index(Request $request)
    {
        $query = RespondenBank::query()->with('sourceUser');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('institution', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('job_title', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('country')) {
            $query->where('country', 'like', "%{$request->country}%");
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        $sort = $request->get('sort', 'created_at');
        $direction = in_array($request->get('direction', 'desc'), ['asc', 'desc']) ? $request->get('direction', 'desc') : 'desc';
        $allowedSorts = ['first_name', 'email', 'institution', 'category', 'country', 'created_at', 'source'];
        if (!in_array($sort, $allowedSorts)) $sort = 'created_at';

        $query->orderBy($sort, $direction);

        $perPage = (int) $request->get('per_page', 50);
        if (!in_array($perPage, [25, 50, 100, 200])) $perPage = 50;

        $respondents = $query->paginate($perPage)->appends($request->query());

        return view('admin_pemeringkatan.responden-bank.index', compact('respondents'));
    }

    public function create()
    {
        return view('admin_pemeringkatan.responden-bank.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255|unique:responden_bank,email',
            'title' => 'nullable|string|max:20',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'institution' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'category' => 'nullable|in:academic,employee',
        ]);

        $validated['email'] = strtolower(trim($validated['email']));
        $validated['source'] = 'manual';
        $validated['source_user_id'] = Auth::id();

        RespondenBank::create($validated);

        return redirect()
            ->route('admin_pemeringkatan.responden-bank.index')
            ->with('success', 'Responden berhasil ditambahkan ke bank!');
    }

    public function edit(RespondenBank $responden_bank)
    {
        return view('admin_pemeringkatan.responden-bank.edit', ['respondent' => $responden_bank]);
    }

    public function update(Request $request, RespondenBank $responden_bank)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255|unique:responden_bank,email,' . $responden_bank->id,
            'title' => 'nullable|string|max:20',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'institution' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'category' => 'nullable|in:academic,employee',
        ]);

        $validated['email'] = strtolower(trim($validated['email']));

        $responden_bank->update($validated);

        return redirect()
            ->route('admin_pemeringkatan.responden-bank.index')
            ->with('success', 'Data responden berhasil diperbarui!');
    }

    public function destroy(RespondenBank $responden_bank)
    {
        // Check if in any active session
        $activeSessionCount = $responden_bank->sessionRespondents()
            ->whereHas('session', fn($q) => $q->where('status', 'active'))
            ->count();

        if ($activeSessionCount > 0) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus responden yang ada di session aktif.');
        }

        $responden_bank->delete();

        return redirect()
            ->route('admin_pemeringkatan.responden-bank.index')
            ->with('success', 'Responden berhasil dihapus dari bank.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:10240',
        ]);

        try {
            $import = new RespondenBankImport(Auth::id());
            Excel::import($import, $request->file('file'));

            $imported = $import->getImportedCount();
            $skipped = $import->getSkippedCount();

            return redirect()
                ->route('admin_pemeringkatan.responden-bank.index')
                ->with('success', "Import selesai! {$imported} ditambahkan, {$skipped} dilewati (duplikat).");
        } catch (\Exception $e) {
            Log::error('Bank import error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        $filters = $request->only(['search', 'category', 'country', 'source']);
        $fileName = 'responden-bank-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new RespondenBankExport($filters), $fileName);
    }
}
