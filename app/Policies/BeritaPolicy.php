<?php

namespace App\Policies;

use App\Models\Berita;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BeritaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return in_array($user->role, [
            'admin_direktorat',
            'admin_hilirisasi',
            'admin_inovasi', 
            'admin_pemeringkatan',
            'fakultas',
            'prodi'
        ]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Berita $berita)
    {
        return true; // Public berita can be viewed by anyone
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return in_array($user->role, [
            'admin_direktorat',
            'admin_hilirisasi',
            'admin_inovasi',
            'admin_pemeringkatan', 
            'fakultas',
            'prodi'
        ]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Berita $berita)
    {
        // Admin direktorat and admin_pemeringkatan can update any berita
        if (in_array($user->role, ['admin_direktorat', 'admin_pemeringkatan'])) {
            return true;
        }
        
        // Users can only update their own berita
        return $user->id === $berita->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Berita $berita)
    {
        // Admin direktorat and admin_pemeringkatan can delete any berita
        if (in_array($user->role, ['admin_direktorat', 'admin_pemeringkatan'])) {
            return true;
        }
        
        // Users can only delete their own berita
        return $user->id === $berita->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Berita $berita)
    {
        return $user->role === 'admin_direktorat';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Berita $berita)
    {
        return $user->role === 'admin_direktorat';
    }
}
