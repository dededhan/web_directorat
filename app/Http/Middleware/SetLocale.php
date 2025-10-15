<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if locale is in session, otherwise use default from config
        $locale = Session::get('locale', config('app.locale', 'id'));
        
        // Validate locale to prevent security issues
        if (!in_array($locale, ['id', 'en'])) {
            $locale = 'id';
        }
        
        App::setLocale($locale);
        
        return $next($request);
    }
}
