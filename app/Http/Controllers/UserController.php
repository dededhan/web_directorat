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
            'status' => 'unactive',
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
    public function toggleStatus(User $user)
    {
        $user->update([
            'status' => $user->status === 'active' ? 'unactive' : 'active'
        ]);

        return redirect()->back()->with('success', 'Status user berhasil diubah');
    }

    public function edit(User $user)
    {
        return view('admin.manageuser', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|string'
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role']
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        // Mulai transaction
        \DB::beginTransaction();
        try {
            // Update user
            $user->update($updateData);

            // Update role-specific data if exists
            switch ($user->role) {
                case 'dosen':
                    if ($user->dosen) {
                        $user->dosen->update([
                            'name' => $validated['name'],
                            'email' => $validated['email'],
                        ]);
                    }
                    break;
                case 'mahasiswa':
                    if ($user->mahasiswa) {
                        $user->mahasiswa->update([
                            'name' => $validated['name'],
                            'email' => $validated['email'],
                        ]);
                    }
                    break;
                case 'fakultas':
                    if ($user->fakultas) {
                        $user->fakultas->update([
                            'name' => $validated['name'],
                            'email' => $validated['email'],
                        ]);
                    }
                    break;
                case 'prodi':
                    if ($user->prodi) {
                        $user->prodi->update([
                            'name' => $validated['name'],
                            'email' => $validated['email'],
                        ]);
                    }
                    break;
            }

            \DB::commit();
            return redirect()->route('admin.manageuser.index')->with('success', 'User berhasil diperbarui');
        } catch (\Exception $e) {
            \DB::rollBack();
            Log::error('Failed to update user', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        Log::debug('Received delete request for user ID: ' . $id);
        $user = User::find($id);

        if (!$user) {
            Log::error('User tidak ditemukan', ['user_id' => $user->id]);
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }
    
        \DB::beginTransaction();
        try {
            Log::debug('Attempting to delete user with ID: ' . $user->id);
            if (!$user || !$user->exists) {
                Log::error('User not found', ['user_id' => request()->route('user')]);
                return redirect()->back()->with('error', 'User tidak ditemukan.');
            }
            // Hapus relasi
            if ($user->dosen) $user->dosen->delete();
            if ($user->mahasiswa) $user->mahasiswa->delete();
            if ($user->fakultas) $user->fakultas->delete();
            if ($user->prodi) $user->prodi->delete();
           
            
            // Hapus user
            $user->delete();
            
            \DB::commit();
    
            Log::info('User deleted successfully', ['user_id' => $user->id]);
            return redirect()->back()->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            \DB::rollBack();
            Log::error('Failed to delete user', [
                'error' => $e->getMessage(), 
                'user_id' => $user->id ?? 'null'
            ]);
            return redirect()->back()->with('error', 'Gagal menghapus: '.$e->getMessage());
        }
    }

}