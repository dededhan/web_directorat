<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GlobalEngagementAbout;
use App\Models\GlobalEngagementProgram;
use App\Models\GlobalEngagementPartner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class GlobalEngagementController extends Controller
{
    // --- CONSTRUCTOR TO SHARE VIEW VARIABLES ---
    public function __construct()
    {
        // Share the route prefix with all views
        View::share('routePrefix', $this->getRoutePrefix());
    }

    private function getRoutePrefix()
    {
        $currentRouteName = request()->route()->getName();
        if (str_starts_with($currentRouteName, 'admin.')) {
            return 'admin';
        }
        // Add other prefixes if needed
        return 'admin'; // Default prefix
    }


    // --- DASHBOARD ---
    public function dashboard()
    {
        $about = GlobalEngagementAbout::first();
        $programs = GlobalEngagementProgram::orderBy('order')->get();
        $partners = GlobalEngagementPartner::orderBy('order')->get();

        return view('admin.global.engagement_dashboard', compact('about', 'programs', 'partners'));
    }

    // --- PUBLIC FACING PAGE ---
    public function publicPage()
    {
        $about = GlobalEngagementAbout::first();
        $programs = GlobalEngagementProgram::orderBy('order')->get();
        $partners = GlobalEngagementPartner::orderBy('order')->get();

        return view('Pemeringkatan.program.global-engagement', compact('about', 'programs', 'partners'));
    }

    // --- "TENTANG" SECTION ---
    public function updateAbout(Request $request)
    {
        $request->validate(['content' => 'required|string']);
        GlobalEngagementAbout::updateOrCreate(['id' => 1], ['content' => $request->content]);

        return back()->with('success_about', 'Section "Tentang" has been updated successfully.');
    }

    // --- "PROGRAM" SECTION ---
    public function storeProgram(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'objectives' => 'required|string', // Changed back to required
            'activities' => 'required|string', // Changed back to required
        ]);

        // Create the program with the validated data.
        GlobalEngagementProgram::create($validatedData);

        return back()->with('success_program', 'New program has been added successfully.');
    }

    public function editProgram($id)
    {
        $program = GlobalEngagementProgram::findOrFail($id);
        return view('admin.global.engagement_program_edit', compact('program'));
    }

    public function updateProgram(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'objectives' => 'nullable|string', // FIX: Changed to nullable
            'activities' => 'nullable|string', // FIX: Changed to nullable
            'order' => 'required|integer',
        ]);

        $program = GlobalEngagementProgram::findOrFail($id);
        $program->update($request->all());

        return redirect()->route('admin.global.engagement.dashboard')->with('success_program', 'Program has been updated.');
    }

    public function destroyProgram($id)
    {
        $program = GlobalEngagementProgram::findOrFail($id);
        $program->delete();
        return back()->with('success_program', 'Program has been deleted.');
    }


    // --- "PARTNER" SECTION ---
    public function storePartner(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website_url' => 'nullable|url',
        ]);

        $path = $request->file('logo')->store('public/partners');

        GlobalEngagementPartner::create([
            'name' => $request->name,
            'logo_path' => $path,
            'website_url' => $request->website_url,
        ]);

        return back()->with('success_partner', 'New partner has been added.');
    }

    public function editPartner($id)
    {
        $partner = GlobalEngagementPartner::findOrFail($id);
        return view('admin.global.engagement_partner_edit', compact('partner'));
    }

    public function updatePartner(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website_url' => 'nullable|url',
            'order' => 'required|integer',
        ]);

        $partner = GlobalEngagementPartner::findOrFail($id);
        $data = $request->only(['name', 'website_url', 'order']);

        if ($request->hasFile('logo')) {
            // Delete old logo
            Storage::delete($partner->logo_path);
            // Store new logo
            $data['logo_path'] = $request->file('logo')->store('public/partners');
        }

        $partner->update($data);

        return redirect()->route('admin.global.engagement.dashboard')->with('success_partner', 'Partner has been updated.');
    }

    public function destroyPartner($id)
    {
        $partner = GlobalEngagementPartner::findOrFail($id);
        Storage::delete($partner->logo_path);
        $partner->delete();

        return back()->with('success_partner', 'Partner has been deleted.');
    }
}
