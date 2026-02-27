<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Innovation Challenge Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for the Innovation Challenge
    | System, including session management, submission rules, and more.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Session Management
    |--------------------------------------------------------------------------
    |
    | Configure session activation behavior
    |
    */

    // Auto-close active session when activating a new one
    // If false, only one session can be active at a time (strict mode)
    // If true, activating a new session will automatically close the current active session
    'auto_close_active_session' => env('INOV_CHALLENGE_AUTO_CLOSE_SESSION', false),

    /*
    |--------------------------------------------------------------------------
    | Submission Settings
    |--------------------------------------------------------------------------
    |
    | Configure submission-related behavior
    |
    */

    // Maximum team members per submission (excluding leader)
    'max_team_members' => env('INOV_CHALLENGE_MAX_TEAM_MEMBERS', 5),

    // Allow draft submissions after registration deadline
    'allow_draft_after_deadline' => env('INOV_CHALLENGE_ALLOW_DRAFT_AFTER_DEADLINE', true),

    // Automatically cancel draft submissions when session closes
    'auto_cancel_drafts_on_close' => env('INOV_CHALLENGE_AUTO_CANCEL_DRAFTS', true),

    /*
    |--------------------------------------------------------------------------
    | Review Settings
    |--------------------------------------------------------------------------
    |
    | Configure review and reviewer behavior
    |
    */

    // Minimum number of reviewers required per submission phase
    'min_reviewers_per_phase' => env('INOV_CHALLENGE_MIN_REVIEWERS', 2),

    // Maximum workload per reviewer (active reviews)
    'max_reviewer_workload' => env('INOV_CHALLENGE_MAX_REVIEWER_WORKLOAD', 10),

    // Prevent reviewers from reviewing their own submissions or team submissions
    'prevent_self_review' => env('INOV_CHALLENGE_PREVENT_SELF_REVIEW', true),

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    |
    | Configure notification behavior
    |
    */

    // Send email notifications for status changes
    'send_email_notifications' => env('INOV_CHALLENGE_SEND_EMAIL_NOTIFICATIONS', true),

    // Send notifications when reviewer is assigned
    'notify_reviewer_assignment' => env('INOV_CHALLENGE_NOTIFY_REVIEWER_ASSIGNMENT', true),

    // Send notifications when phase is approved/rejected
    'notify_phase_decision' => env('INOV_CHALLENGE_NOTIFY_PHASE_DECISION', true),

    /*
    |--------------------------------------------------------------------------
    | File Upload Settings
    |--------------------------------------------------------------------------
    |
    | Configure file upload limits
    |
    */

    // Default max file size in KB (can be overridden per field)
    'default_max_file_size' => env('INOV_CHALLENGE_MAX_FILE_SIZE', 10240), // 10MB

    // Allowed file extensions (can be overridden per field)
    'allowed_file_extensions' => [
        'documents' => ['.pdf', '.doc', '.docx'],
        'images' => ['.jpg', '.jpeg', '.png', '.gif'],
        'videos' => ['.mp4', '.avi', '.mov'],
        'archives' => ['.zip', '.rar'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Scoring Settings
    |--------------------------------------------------------------------------
    |
    | Configure scoring and evaluation
    |
    */

    // Minimum score for phase approval
    'min_score_for_approval' => env('INOV_CHALLENGE_MIN_SCORE', 70),

    // Maximum score per review
    'max_score' => env('INOV_CHALLENGE_MAX_SCORE', 100),

    // Score calculation method: 'average', 'median', 'weighted'
    'score_calculation_method' => env('INOV_CHALLENGE_SCORE_METHOD', 'average'),

    /*
    |--------------------------------------------------------------------------
    | Phase Settings
    |--------------------------------------------------------------------------
    |
    | Configure phase progression rules
    |
    */

    // Require approval of previous phase before submitting to next phase
    'require_sequential_phases' => env('INOV_CHALLENGE_SEQUENTIAL_PHASES', true),

    // Automatically unlock next phase upon approval
    'auto_unlock_next_phase' => env('INOV_CHALLENGE_AUTO_UNLOCK_PHASE', true),

    /*
    |--------------------------------------------------------------------------
    | Export Settings
    |--------------------------------------------------------------------------
    |
    | Configure data export options
    |
    */

    // Default export format: 'xlsx', 'csv', 'pdf'
    'default_export_format' => env('INOV_CHALLENGE_EXPORT_FORMAT', 'xlsx'),

    // Include team member details in exports
    'export_include_team_members' => env('INOV_CHALLENGE_EXPORT_TEAM_MEMBERS', true),

    // Include review comments in exports
    'export_include_reviews' => env('INOV_CHALLENGE_EXPORT_REVIEWS', true),
];
