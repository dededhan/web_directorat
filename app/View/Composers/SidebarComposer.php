<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\SubAdminAssignment;

class SidebarComposer
{
    public function compose(View $view)
    {
        $user = auth()->user();
        $hasAccessTo = [];
        
        if ($user && $user->role === 'sub_admin_equity') {
            $assignment = $user->subAdminAssignment;
            if ($assignment) {
                $modules = $assignment->assigned_modules ?? [];
                foreach ($modules as $module) {
                    $hasAccessTo[$module] = true;
                }
            }
        } else {
            // Admin_equity punya akses ke semua
            foreach (SubAdminAssignment::availableModules() as $key => $name) {
                $hasAccessTo[$key] = true;
            }
        }
        
        $view->with('hasAccessTo', $hasAccessTo);
    }
}
