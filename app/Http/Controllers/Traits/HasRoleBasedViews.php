<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Auth;

trait HasRoleBasedViews
{
    protected function resolveViewByRole(string $baseName, array $customMap = []): string
    {
        $user = Auth::user();
        $role = $user->role ?? 'guest';
        if (!empty($customMap)) {
            return $customMap[$role] ?? $customMap['admin_direktorat'] ?? "admin.{$baseName}";
        }
        return match($role) {
            'admin_pemeringkatan' => "admin_pemeringkatan.{$baseName}",
            'admin_direktorat' => "admin.{$baseName}",
            default => "admin.{$baseName}"
        };
    }

    protected function resolveRedirectByRole(string $baseRoute, array $customMap = []): string
    {
        $user = Auth::user();
        $role = $user->role ?? 'guest';

        if (!empty($customMap)) {
            return $customMap[$role] ?? $customMap['admin_direktorat'] ?? "admin.{$baseRoute}";
        }

        return match($role) {
            'admin_pemeringkatan' => "admin_pemeringkatan.{$baseRoute}",
            'admin_direktorat' => "admin.{$baseRoute}",
            default => "admin.{$baseRoute}"
        };
    }


    protected function getCurrentRole(): string
    {
        return Auth::user()->role ?? 'guest';
    }
    protected function isAdminPemeringkatan(): bool
    {
        return $this->getCurrentRole() === 'admin_pemeringkatan';
    }

    protected function isAdminDirektorat(): bool
    {
        return $this->getCurrentRole() === 'admin_direktorat';
    }

    protected function isSupportedAdminRole(): bool
    {
        return in_array($this->getCurrentRole(), ['admin_pemeringkatan', 'admin_direktorat']);
    }
}
