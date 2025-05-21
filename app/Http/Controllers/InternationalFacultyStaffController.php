<?php

namespace App\Http\Controllers;

use App\Models\InternationalFacultyStaff;
use App\Models\AktivitasDosenAsing;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInternationalFacultyStaffRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class InternationalFacultyStaffController extends Controller
{
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
    public function index()
    {
        $facultyStaffs = InternationalFacultyStaff::all();

        if (Auth::user()->role === 'admin_direktorat') {
            return view('admin.international_faculty_staff_profile', compact('facultyStaffs'));
        } else if (Auth::user()->role === 'prodi') {
            return view('prodi.international_faculty_staff_profile', compact('facultyStaffs'));
        } else if (Auth::user()->role === 'fakultas') {
            return view('fakultas.international_faculty_staff_profile', compact('facultyStaffs'));
        } else if (Auth::user()->role === 'admin_pemeringkatan') {
            return view('admin_pemeringkatan.international_faculty_staff_profile', compact('facultyStaffs'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInternationalFacultyStaffRequest $request)
    {
        // Handle file upload
        $path = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('faculty_staff', 'public');
        }

        InternationalFacultyStaff::create([
            'nama' => $request->nama,
            'fakultas' => $request->fakultas,
            'universitas_asal' => $request->universitas_asal,
            'bidang_keahlian' => $request->bidang_keahlian,
            'qs_wur' => $request->qs_wur,
            'qs_subject' => $request->qs_subject,
            'scopus' => $request->scopus,
            'foto_path' => $path,
            'tahun' => $request->tahun,
            'category' => $request->category
        ]);

        if (Auth::user()->role === 'admin_direktorat') {
            return redirect()->route('admin.international_faculty_staff.index')
                ->with('success', 'Data berhasil disimpan!');
        } else if (Auth::user()->role === 'prodi') {
            return redirect()->route('prodi.international_faculty_staff.index')
                ->with('success', 'Data berhasil disimpan!');
        } else if (Auth::user()->role === 'fakultas') {
            return redirect()->route('fakultas.international_faculty_staff.index')
                ->with('success', 'Data berhasil disimpan!');
        } else if (Auth::user()->role === 'admin_pemeringkatan') {
            return redirect()->route('admin_pemeringkatan.international_faculty_staff.index')
                ->with('success', 'Data berhasil disimpan!');
        }
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

            // Handle file update only if a new file is uploaded
            if ($request->hasFile('foto')) {
                // Delete old file
                if (Storage::disk('public')->exists($internationalFacultyStaff->foto_path)) {
                    Storage::disk('public')->delete($internationalFacultyStaff->foto_path);
                }

                // Store new file
                $path = $request->file('foto')->store('faculty_staff', 'public');
                $data['foto_path'] = $path;
            }

            $internationalFacultyStaff->update($data);

            return redirect()->back()
                ->with('success', 'Data dosen internasional berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data dosen internasional: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InternationalFacultyStaff $internationalFacultyStaff)
    {
        try {
            // Delete file
            if (Storage::disk('public')->exists($internationalFacultyStaff->foto_path)) {
                Storage::disk('public')->delete($internationalFacultyStaff->foto_path);
            }

            // Delete record
            $internationalFacultyStaff->delete();

            return redirect()->back()
                ->with('success', 'Data dosen internasional berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data dosen internasional: ' . $e->getMessage());
        }
    }
    public function showInternationalFacultyStaff()
    {
        // Fetch activities for the International Faculty Staff page
        $activities = AktivitasDosenAsing::latest()->get();
        
        // Fetch faculty staff data
        $facultyStaffs = FacultyStaff::all();
        
        // Statistics that appear to be used in the view
        $stats = [
            'adjunctProfessors' => FacultyStaff::where('type', 'adjunct')->count(),
            'fullTimeProfessors' => FacultyStaff::where('type', 'full-time')->count(),
            'uniqueUniversities' => FacultyStaff::distinct()->count('universitas_asal')
        ];
        
        return view('layout.pemeringkatan.international_faculty_staff', compact('activities', 'facultyStaffs', 'stats'));
    }
    
    // Your other controller methods...
    
    // API endpoint for modal content
    public function getActivityDetails($id)
    {
        $activity = AktivitasDosenAsing::findOrFail($id);
        return response()->json($activity);
    }

}
