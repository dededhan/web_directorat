<?php

namespace App\Http\Controllers;

use App\Models\AlumniBerdampak;

class AlumniController extends Controller
{
    public function index()
    {
        $alumniBerdampak = AlumniBerdampak::latest()->get();
        return view('galeri.alumni', compact('alumniBerdampak'));
    }
}