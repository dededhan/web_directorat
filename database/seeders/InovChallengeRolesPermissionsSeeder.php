<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class InovChallengeRolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for Innovation Challenge
        $permissions = [
            // Session Management (Admin Only)
            'manage_inov_challenge_sessions',
            'create_inov_challenge_session',
            'edit_inov_challenge_session',
            'delete_inov_challenge_session',
            'activate_inov_challenge_session',
            
            // Form Builder (Admin Only)
            'manage_inov_challenge_forms',
            'create_inov_challenge_form',
            'edit_inov_challenge_form',
            'delete_inov_challenge_form',
            
            // Submission Management (Dosen)
            'submit_inov_challenge',
            'view_own_inov_challenge_submission',
            'edit_own_inov_challenge_submission',
            'delete_own_inov_challenge_submission',
            
            // Team Management (Dosen & Alumni)
            'manage_inov_challenge_team',
            'invite_inov_challenge_team_member',
            'remove_inov_challenge_team_member',
            'accept_inov_challenge_invitation',
            'reject_inov_challenge_invitation',
            
            // Review & Scoring (Reviewer)
            'review_inov_challenge',
            'score_inov_challenge_submission',
            'view_assigned_inov_challenge_reviews',
            'submit_inov_challenge_review',
            
            // Approval (Admin Only)
            'approve_inov_challenge_submission',
            'reject_inov_challenge_submission',
            'assign_inov_challenge_reviewer',
            'view_all_inov_challenge_submissions',
            
            // Reports & Statistics (Admin)
            'view_inov_challenge_reports',
            'export_inov_challenge_data',
            
            // Notifications
            'view_inov_challenge_notifications',
            'mark_inov_challenge_notification_read',
        ];

        // Create all permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // 1. Admin Innovation Challenge (inovchalange)
        $adminRole = Role::firstOrCreate(['name' => 'inovchalange']);
        $adminRole->givePermissionTo([
            'manage_inov_challenge_sessions',
            'create_inov_challenge_session',
            'edit_inov_challenge_session',
            'delete_inov_challenge_session',
            'activate_inov_challenge_session',
            'manage_inov_challenge_forms',
            'create_inov_challenge_form',
            'edit_inov_challenge_form',
            'delete_inov_challenge_form',
            'approve_inov_challenge_submission',
            'reject_inov_challenge_submission',
            'assign_inov_challenge_reviewer',
            'view_all_inov_challenge_submissions',
            'view_inov_challenge_reports',
            'export_inov_challenge_data',
            'view_inov_challenge_notifications',
            'mark_inov_challenge_notification_read',
        ]);

        // 2. Reviewer Innovation Challenge (reviewer_inovchalange)
        $reviewerRole = Role::firstOrCreate(['name' => 'reviewer_inovchalange']);
        $reviewerRole->givePermissionTo([
            'review_inov_challenge',
            'score_inov_challenge_submission',
            'view_assigned_inov_challenge_reviews',
            'submit_inov_challenge_review',
            'view_inov_challenge_notifications',
            'mark_inov_challenge_notification_read',
        ]);

        // 3. Alumni (already exists, just add Innovation Challenge permissions)
        $alumniRole = Role::firstOrCreate(['name' => 'alumni']);
        $alumniRole->givePermissionTo([
            'view_own_inov_challenge_submission',
            'accept_inov_challenge_invitation',
            'reject_inov_challenge_invitation',
            'view_inov_challenge_notifications',
            'mark_inov_challenge_notification_read',
        ]);

        // 4. Dosen (existing role, add Innovation Challenge permissions)
        $dosenRole = Role::firstOrCreate(['name' => 'dosen']);
        $dosenRole->givePermissionTo([
            'submit_inov_challenge',
            'view_own_inov_challenge_submission',
            'edit_own_inov_challenge_submission',
            'delete_own_inov_challenge_submission',
            'manage_inov_challenge_team',
            'invite_inov_challenge_team_member',
            'remove_inov_challenge_team_member',
            'view_inov_challenge_notifications',
            'mark_inov_challenge_notification_read',
        ]);

        $this->command->info('Innovation Challenge roles and permissions have been seeded successfully!');
    }
}
