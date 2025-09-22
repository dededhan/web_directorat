<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Responden;
use App\Models\RespondenAnswer;

class HandleRespondenForm
{

    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->has('token')) {
            abort(404, 'Tautan tidak valid atau kedaluwarsa.');
        }

        $token = $request->get('token');
        $responden = Responden::where('token', $token)->first();

        if (!$responden) {
            return redirect()->route('survey.already_submitted');
        }

        $existingAnswer = RespondenAnswer::where('responden_id', $responden->id)->exists();
        if ($existingAnswer || $responden->status === 'clear') {
            return redirect()->route('survey.already_submitted');
        }
        $view = $responden->category === 'academic' ? 'qsrangking.qs_academic' : 'qsrangking.qs_employee';
        
        $request->attributes->add([
            'category' => $responden->category,
            'view' => $view,
            'responden' => $responden,
        ]);

        return $next($request);
    }
}