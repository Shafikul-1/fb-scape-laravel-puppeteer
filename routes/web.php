<?php

use App\Http\Controllers\ScapeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('scape', [ScapeController::class, 'index'])->name('scape');
Route::get('sentData', [ScapeController::class, 'sentData'])->name('sentData');
