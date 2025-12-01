<?php

namespace App\Http\Controllers\Pemeringkatan;

use App\Http\Controllers\Controller;

use App\Models\InternationalFacultyStaff;
use App\Models\AktivitasDosenAsing;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInternationalFacultyStaffRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Traits\HasRoleBasedViews;

class InternationalFacultyStaffController extends Controller
{
    use HasRoleBasedViews;

    public function publicIndex()
    {
        $facultyStaffs = InternationalFacultyStaff::all();
        $activities = AktivitasDosenAsing::latest()->get();
        
        $stats = [
            'adjunctProfessors' => InternationalFacultyStaff::where('category', 'adjunct')->count(),
            'fullTimeProfessors' => InternationalFacultyStaff::where('category', 'fulltime')->count(),
            'uniqueUniversities' => InternationalFacultyStaff::distinct('universitas_asal')->count('universitas_asal')
        ];
        
        return view('Pemeringkatan.program.international-faculty-staff', compact('facultyStaffs', 'stats', 'activities'));
    }

    public function index(Request $request)
    {
        $query = InternationalFacultyStaff::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('universitas_asal', 'like', "%{$search}%")
                  ->orWhere('bidang_keahlian', 'like', "%{$search}%");
            });
        }

        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $facultyStaffs = $query->latest()->paginate(20);
        
        return view($this->resolveViewByRole('international-faculty-staff.index'), compact('facultyStaffs'));
    }

    public function create()
    {
        return view($this->resolveViewByRole('international-faculty-staff.create'));
    }

    public function store(StoreInternationalFacultyStaffRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('foto')) {
                $data['foto_path'] = $request->file('foto')->store('faculty_staff', 'public');
            }

            InternationalFacultyStaff::create($data);

            return redirect()
                ->route($this->resolveRedirectByRole('international-faculty-staff.index'))
                ->with('success', 'Faculty staff data has been successfully added!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to save data: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $staff = InternationalFacultyStaff::findOrFail($id);
        return view($this->resolveViewByRole('international-faculty-staff.edit'), compact('staff'));
    }

    public function getStaffDetail($id)
    {
        $staff = InternationalFacultyStaff::findOrFail($id);
        return response()->json($staff);
    }

    public function update(StoreInternationalFacultyStaffRequest $request, InternationalFacultyStaff $internationalFacultyStaff)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('foto')) {
                if ($internationalFacultyStaff->foto_path && Storage::disk('public')->exists($internationalFacultyStaff->foto_path)) {
                    Storage::disk('public')->delete($internationalFacultyStaff->foto_path);
                }
                $data['foto_path'] = $request->file('foto')->store('faculty_staff', 'public');
            }

            $internationalFacultyStaff->update($data);

            return redirect()
                ->route($this->resolveRedirectByRole('international-faculty-staff.index'))
                ->with('success', 'Faculty staff data has been successfully updated!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update data: ' . $e->getMessage());
        }
    }

    public function destroy(InternationalFacultyStaff $internationalFacultyStaff)
    {
        try {
            if ($internationalFacultyStaff->foto_path && Storage::disk('public')->exists($internationalFacultyStaff->foto_path)) {
                Storage::disk('public')->delete($internationalFacultyStaff->foto_path);
            }
            $internationalFacultyStaff->delete();

            return redirect()
                ->route($this->resolveRedirectByRole('international-faculty-staff.index'))
                ->with('success', 'Faculty staff data has been successfully deleted!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete data: ' . $e->getMessage());
        }
    }
    public function showInternationalFacultyStaff()
    {
        $activities = AktivitasDosenAsing::latest()->get();
        $facultyStaffs = InternationalFacultyStaff::all();
        $stats = [
            'adjunctProfessors' => InternationalFacultyStaff::where('type', 'adjunct')->count(),
            'fullTimeProfessors' => InternationalFacultyStaff::where('type', 'full-time')->count(),
            'uniqueUniversities' => InternationalFacultyStaff::distinct()->count('universitas_asal')
        ];
        
        return view('layout.pemeringkatan.international_faculty_staff', compact('activities', 'facultyStaffs', 'stats'));
    }

    public function getActivityDetails($id)
    {
        $activity = AktivitasDosenAsing::findOrFail($id);
        return response()->json($activity);
    }

}
