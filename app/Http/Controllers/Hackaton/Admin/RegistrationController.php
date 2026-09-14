<?php

namespace App\Http\Controllers\Hackaton\Admin;

use App\Http\Controllers\Controller;
use App\Models\HackatonRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = HackatonRegistration::query();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        } else {
            $query->where('status', 'pending');
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($registrationQuery) use ($search) {
                $registrationQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $registrations = $query->latest()->paginate(15)->withQueryString();
        $pendingCount = HackatonRegistration::where('status', 'pending')->count();

        return view('admin_hackaton.registrations.index', compact('registrations', 'pendingCount'));
    }

    public function approve(Request $request, HackatonRegistration $registration)
    {
        abort_if($registration->status !== 'pending', 403, 'Pendaftaran ini sudah diproses.');

        $alreadyExists = User::where('email', $registration->email)->exists();

        DB::transaction(function () use ($request, $registration, $alreadyExists) {
            if (! $alreadyExists) {
                User::create([
                    'name' => $registration->name,
                    'email' => $registration->email,
                    'password' => $registration->password,
                    'role' => $registration->role,
                    'status' => 'active',
                ]);
            }

            $adminNotes = $request->input('admin_notes');
            if ($alreadyExists) {
                $adminNotes = trim(($adminNotes ? $adminNotes . ' | ' : '') . 'Email sudah terdaftar sebelumnya, tidak membuat akun baru.');
            }

            $registration->update([
                'status' => 'approved',
                'admin_notes' => $adminNotes,
                'processed_by' => Auth::id(),
                'processed_at' => now(),
            ]);
        });

        return back()->with('success', "Pendaftaran {$registration->name} berhasil disetujui.");
    }

    public function decline(Request $request, HackatonRegistration $registration)
    {
        abort_if($registration->status !== 'pending', 403, 'Pendaftaran ini sudah diproses.');

        $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $registration->update([
            'status' => 'declined',
            'admin_notes' => $request->input('admin_notes'),
            'processed_by' => Auth::id(),
            'processed_at' => now(),
        ]);

        return back()->with('success', "Pendaftaran {$registration->name} telah ditolak.");
    }
}
