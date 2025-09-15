<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Security Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains security-related configuration settings for the
    | application to prevent common vulnerabilities.
    |
    */

    'file_upload' => [
        'allowed_mimes' => [
            'image/jpeg',
            'image/png', 
            'image/jpg',
            'image/gif'
        ],
        'max_size' => 2048, // KB
        'max_files' => 5,
        'scan_uploads' => true, // Enable virus scanning if available
    ],

    'rate_limiting' => [
        'berita_create' => '10,1', // 10 requests per minute
        'berita_update' => '5,1',  // 5 requests per minute
        'berita_delete' => '3,1',  // 3 requests per minute
        'file_upload' => '20,1',   // 20 uploads per minute
    ],

    'xss_protection' => [
        'enabled' => true,
        'purifier_config' => [
            'HTML.Allowed' => 'p,br,strong,em,u,ol,ul,li,h1,h2,h3,h4,h5,h6,blockquote,img[src|alt|width|height],a[href|target],table,tr,td,th',
            'HTML.AllowedAttributes' => 'src,alt,width,height,href,target,class,id',
            'HTML.AllowedProtocols' => 'http,https,mailto',
            'AutoFormat.RemoveEmpty' => true,
        ]
    ],

    'csrf_protection' => [
        'enabled' => true,
        'excluded_routes' => [
            // Add routes that should be excluded from CSRF protection
        ]
    ],

    'session_security' => [
        'timeout' => 120, // minutes
        'regenerate_on_login' => true,
        'secure_cookies' => env('SESSION_SECURE_COOKIE', false),
        'http_only' => true,
        'same_site' => 'lax'
    ],

    'password_policy' => [
        'min_length' => 8,
        'require_uppercase' => true,
        'require_lowercase' => true,
        'require_numbers' => true,
        'require_symbols' => false,
        'max_age_days' => 90
    ],

    'audit_logging' => [
        'enabled' => true,
        'log_events' => [
            'berita_created',
            'berita_updated', 
            'berita_deleted',
            'file_uploaded',
            'login_attempts',
            'permission_denied'
        ]
    ]
];
