<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleRespondenForm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $url = explode('/', $request->uri()->path())[1];
        // dd($url, $request->uri()->path());
        $request->method();
        switch($url){
            case 'qs-employee':
                $request->attributes->add([
                    'category' => 'employee',
                    'view' => 'qsrangking.qs_employee',
                ]);
                redirect(route('qs-employee.index'));
                break;
            case 'qs-academic':
                $request->attributes->add([
                    'category' => 'academic',
                    'view' => 'qsrangking.qs_academic',
                ]);
                redirect(route('qs-academic.index'));
                break;
            }
        return $next($request);
    }
}
