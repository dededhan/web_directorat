<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Fakultas;
use App\Models\Prodi;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        // Get all users and apply some basic sorting by creation date (newest first)
        $users = User::latest()->get();
        
        // Log the number of users fetched for debugging
        Log::info('Fetched users for manage page', ['count' => $users->count()]);
        
        return view('admin.manageuser', compact('users'));
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
        ]);
        
        try {
            // Create role-specific record if needed
            switch ($validated['role']) {
                case 'dosen':
                    Dosen::create([
                        'user_id' => $user->id,
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'password' => $user->password,
                    ]);
                    break;
                case 'mahasiswa':
                    Mahasiswa::create([
                        'user_id' => $user->id,
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'password' => $user->password,
                    ]);
                    break;
                case 'fakultas':
                    Fakultas::create([
                        'user_id' => $user->id,
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'password' => $user->password,
                    ]);
                    break;
                case 'prodi':
                    Prodi::create([
                        'user_id' => $user->id,
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'password' => $user->password,
                    ]);
                    break;
            }
            
            Log::info('User created manually', ['user_id' => $user->id, 'role' => $user->role]);
            return redirect()->back()->with('success', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Failed to create role-specific record', [
                'user_id' => $user->id,
                'role' => $validated['role'],
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with('error', 'Gagal membuat data role: ' . $e->getMessage());
        }
    }
}