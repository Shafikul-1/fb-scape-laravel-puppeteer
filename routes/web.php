<?php

use App\Http\Controllers\ScapeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('scape', [ScapeController::class, 'index'])->name('scape');
// Route::get('check', [ScapeController::class, 'check'])->name('check');
