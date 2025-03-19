<?php

namespace App\Http\Controllers;

use App\Models\AlumniBerdampak;

class AlumniController extends Controller
{
    public function index()
    {
        // Fetch alumni data
        $alumniBerdampak = AlumniBerdampak::all(); 
        
        // Update the view path to match the new location
        return view('galeri.alumni.alumni', compact('alumniBerdampak'));
    }
}