<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddSecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $csp = "default-src 'self'; " .
               "script-src 'self' https://cdn.tailwindcss.com https://unpkg.com; " .
               "style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://unpkg.com; " .
               "img-src 'self' data: https://upload.wikimedia.org https://media.quipper.com; " .
               "font-src 'self' https://cdnjs.cloudflare.com; " .
               "frame-src https://www.youtube.com/embed/$;";

        $response->headers->set('Content-Security-Policy', $csp);
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        return $response;
    }
}