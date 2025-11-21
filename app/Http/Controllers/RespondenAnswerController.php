<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRespondenAnswerRequest;
use App\Models\Responden;
use App\Models\RespondenAnswer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Monarobase\CountryList\CountryListFacade as Countries;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RespondenAnswerExport;


class RespondenAnswerController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $userRole = $user->role;

        $query = RespondenAnswer::query()->with(['responden.user'])->latest();

        //filter gimmick
        if ($userRole === 'prodi') {
            $userRespondents = Responden::where('user_id', $user->id)->get();
            $userEmails = $userRespondents->pluck('email')->filter()->unique();
            $userPhones = $userRespondents->pluck('phone_responden')->filter()->unique();

            $query->where(function ($q) use ($user, $userEmails, $userPhones) {
                //nerapin sama kek admin di model gan
                $q->whereHas('responden', function ($subQ) use ($user) {
                    $subQ->where('user_id', $user->id);
                });

                if ($userEmails->isNotEmpty()) {
                    $q->orWhereIn('email', $userEmails);
                }
                if ($userPhones->isNotEmpty()) {
                    $q->orWhereIn('phone', $userPhones);
                }
            });
        } elseif ($userRole === 'fakultas') {
            $facultyCode = strtolower($user->name);

            $userIds = User::where('id', $user->id)
                ->orWhere(function ($q) use ($facultyCode) {
                    $q->where('role', 'prodi')
                      ->where('name', 'like', $facultyCode . '-%');
                })->pluck('id');
            

            $userRespondents = Responden::whereIn('user_id', $userIds)->get();
            $userEmails = $userRespondents->pluck('email')->filter()->unique();
            $userPhones = $userRespondents->pluck('phone_responden')->filter()->unique();

            $query->where(function ($q) use ($userIds, $userEmails, $userPhones) {
                //nerapin sama kek admin di model gan
                $q->whereHas('responden', function ($subQ) use ($userIds) {
                    $subQ->whereIn('user_id', $userIds);
                });

                if ($userEmails->isNotEmpty()) {
                    $q->orWhereIn('email', $userEmails);
                }
                if ($userPhones->isNotEmpty()) {
                    $q->orWhereIn('phone', $userPhones);
                }
            });
        }

        if ($request->filled('q')) {
            $search = trim($request->get('q'));
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('institution', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('country', 'like', "%{$search}%")
                    ->orWhere('job_title', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $category = $request->get('category');
            if ($category === 'employee' || $category === 'employer') {
                $query->whereIn('category', ['employee', 'employer']);
            } else {
                $query->where('category', $category);
            }
        }

        if ($request->filled('country')) {
            $country = trim($request->get('country'));
            $query->where('country', 'like', "%{$country}%");
        }

        if ($request->filled('survey_2023')) {
            $query->where('survey_2023', $request->get('survey_2023'));
        }

        if ($request->filled('survey_2024')) {
            $query->where('survey_2024', $request->get('survey_2024'));
        }

        if ($request->filled('job_title')) {
            $query->where('job_title', $request->get('job_title'));
        }

        $perPage = (int) $request->get('per_page', 50);
        if (! in_array($perPage, [25, 50, 100, 200])) {
            $perPage = 50;
        }

        $respondens = $query->paginate($perPage)->appends($request->query());

        $viewMap = [
            'admin_direktorat' => 'admin.qsresponden',
            'prodi' => 'prodis.qsresponden',
            'fakultas' => 'fakultas.qsresponden',
            // 'admin_direktorat' => 'admin.qsresponden.index',
            // 'prodi' => 'prodis.qsresponden.index',
            // 'fakultas' => 'fakultas.qsresponden.index',
            'admin_pemeringkatan' => 'admin_pemeringkatan.qsresponden.index',
        ];

        if (array_key_exists($userRole, $viewMap)) {
            return view($viewMap[$userRole], compact('respondens'));
        }

        return redirect('/')->with('error', 'Anda tidak memiliki akses.');
    }

    public function create(Request $request)
    {
        //dibikin simple pake middleware gan
        $responden = $request->attributes->get('responden');
        $view = $request->attributes->get('view');
        $category = $request->attributes->get('category');

        if (!$responden && in_array(Auth::user()->role, ['admin_direktorat', 'admin_pemeringkatan'])) {
            $role = Auth::user()->role;
            $view = $role === 'admin_pemeringkatan' ? 'admin_pemeringkatan.qsresponden.create' : 'admin.qsresponden.create';
            return view($view);
        }

        if (!$responden) {
            return redirect()->route('survey.already_submitted');
        }

        $countries = Countries::getList('en', 'php');

        return view($view, [
            'category' => $category,
            'countries' => $countries,
            'token' => $responden->token,
            'email' => $responden->email,
        ]);
    }

    public function store(Request $request)
    {
        //change output to token if situation (biar langsung masuk tanpa harus cek lagi)
        if ($request->has('token')) {

            $validatedData = app(StoreRespondenAnswerRequest::class)->validated();
            $responden = Responden::where('token', $validatedData['token'])->firstOrFail();

            if (RespondenAnswer::where('responden_id', $responden->id)->exists() || $responden->status === 'clear') {
                return redirect()->route('survey.already_submitted');
            }

            $cleanedCategory = strtolower(trim($responden->category));
            $normalizedCategory = match ($cleanedCategory) {
                'employer', 'employee' => 'employee',
                'academic' => 'academic',
            };

            RespondenAnswer::create([
                'responden_id' => $responden->id,
                'title' => $validatedData['answer_title'],
                'first_name' => $validatedData['answer_firstname'],
                'last_name' => $validatedData['answer_lastname'],
                'job_title' => $validatedData['answer_job_title'],
                'institution' => $validatedData['answer_institution'],
                'department' => $validatedData['answer_department'] ?? null,
                'company_name' => $validatedData['answer_company'] ?? null,
                'position' => $validatedData['answer_position'] ?? null,
                'country' => $validatedData['answer_country'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['answer_phone'],
                'survey_2023' => $validatedData['answer_survey_2023'],
                'survey_2024' => $validatedData['answer_survey_2024'],
                'category' => $normalizedCategory,
            ]);

            $responden->update([
                'status' => 'clear',
                'token' => null
            ]);

            return redirect(route('survey.thankyou'));
        } else {
            // TEMBAK
            $validatedData = $request->validate([
                'title' => 'required|string|max:20',
                'first_name' => 'required|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'institution' => 'required|string|max:255',
                'department' => 'nullable|string|max:255',
                'company_name' => 'nullable|string|max:255',
                'position' => 'nullable|string|max:255',
                'job_title' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:50',
                'survey_2023' => 'required|in:yes,no',
                'survey_2024' => 'required|in:yes,no',
                'category' => 'required|in:academic,employee',
            ]);

            RespondenAnswer::create($validatedData);

            $role = Auth::user()->role;
            $routeName = $role === 'admin_pemeringkatan' ? 'admin_pemeringkatan.qsresponden.index' : 'admin.qsresponden.index';
            
            return redirect()->route($routeName)->with('success', 'QS Responden berhasil ditambahkan.');
        }
    }

    public function show(RespondenAnswer $respondenAnswer) {}

    public function edit(RespondenAnswer $qsresponden)
    {
        $role = Auth::user()->role;
        $view = $role === 'admin_pemeringkatan' ? 'admin_pemeringkatan.qsresponden.edit' : 'admin.qsresponden.edit';
        return view($view, ['responden' => $qsresponden]);
    }

    public function update(Request $request, RespondenAnswer $qsresponden)
    {

        $validatedData = $request->validate([
            'title' => 'required|string|max:20',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'survey_2023' => 'nullable|string|max:255',
            'survey_2024' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
        ]);

        $qsresponden->update($validatedData);

        $role = Auth::user()->role;
        $routeName = $role === 'admin_pemeringkatan' ? 'admin_pemeringkatan.qsresponden.index' : 'admin.qsresponden.index';
        
        return redirect()->route($routeName)->with('success', 'Data responden berhasil diperbarui.');
    }

    public function destroy(RespondenAnswer $qsresponden)
    {
        try {
            $qsresponden->delete();
            
            $role = Auth::user()->role;
            $routeName = $role === 'admin_pemeringkatan' ? 'admin_pemeringkatan.qsresponden.index' : 'admin.qsresponden.index';
            
            return redirect()->route($routeName)->with('success', 'Data responden berhasil dihapus.');
        } catch (\Exception $e) {
            $role = Auth::user()->role;
            $routeName = $role === 'admin_pemeringkatan' ? 'admin_pemeringkatan.qsresponden.index' : 'admin.qsresponden.index';
            
            return redirect()->route($routeName)->with('error', 'Gagal menghapus data.');
        }
    }

    public function export(Request $request)
    {
        $filters = $request->only(['q', 'category', 'country', 'survey_2023', 'survey_2024', 'job_title', 'start_date', 'end_date']);
        $fileName = 'qs-respondens-' . now()->format('Ymd-His') . '.xlsx';
        $export = new RespondenAnswerExport($filters);
        return Excel::download($export, $fileName);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:10240',
        ]);

        try {
            $file = $request->file('file');
            $import = new \App\Imports\RespondenAnswerImport();
            
            Excel::import($import, $file);
            
            $importedCount = $import->getImportedCount();
            $skippedCount = $import->getSkippedCount();
            
            $message = "Import successful! {$importedCount} QS responden(s) imported.";
            if ($skippedCount > 0) {
                $message .= " {$skippedCount} duplicate(s) skipped.";
            }

            $routeName = 'admin.qsresponden.index';
            if (Auth::user()->role === 'admin_pemeringkatan') {
                $routeName = 'admin_pemeringkatan.qsresponden.index';
            }
            
            return redirect()->route($routeName)->with('success', $message);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            
            foreach ($failures as $failure) {
                $errorMessages[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
            }
            
            $routeName = 'admin.qsresponden.index';
            if (Auth::user()->role === 'admin_pemeringkatan') {
                $routeName = 'admin_pemeringkatan.qsresponden.index';
            }
            
            return redirect()->route($routeName)->with('error', 'Import failed: ' . implode(' | ', $errorMessages));
        } catch (\Exception $e) {
            $routeName = 'admin.qsresponden.index';
            if (Auth::user()->role === 'admin_pemeringkatan') {
                $routeName = 'admin_pemeringkatan.qsresponden.index';
            }
            
            return redirect()->route($routeName)->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
