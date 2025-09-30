<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Responden; 

class RespondenAnswerGraphController extends Controller
{

    public function index()
    {

        return view('admin.responden_graph');
    }
}
