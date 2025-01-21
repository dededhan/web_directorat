<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Route::get('/', function () {
//     return view('admin');
// });
Route::get('/admin', function () {
    return response()->file(public_path('admin'));
});
