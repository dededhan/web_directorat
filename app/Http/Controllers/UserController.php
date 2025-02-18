<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Fakultas;
use App\Models\Prodi;

class UserController extends Controller
{
    public function index()
    {
        $users = user::all();

        
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
        // Create role-specific record
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
        }
            catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal membuat data role: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'User berhasil ditambahkan');
    }
}
