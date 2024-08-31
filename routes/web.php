<?php

use App\Http\Controllers\CollectDataController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScapeController;
use SebastianBergmann\Comparator\ScalarComparator;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::resource('link', LinkController::class)->middleware('auth');
// Route::post('link-multiwork',[LinkController::class, 'multiwork'])->name('link.multiwork')->middleware('auth');
Route::post('link/multiwork', [LinkController::class, 'multiwork'])->name('link.multiwork')->middleware('auth');

Route::middleware('auth')->controller(CollectDataController::class)->group(function(){
    Route::get('all-data', 'index')->name('allData');
    Route::get('all-data/collect', 'collectData')->name('allData.collectData');
    Route::post('all-data', 'store')->name('allData.store');
    Route::delete('all-data/{id}', 'destroy')->name('allData.destroy');
    Route::post('all-data/multiwork', 'multiwork')->name('allData.multiwork');
    Route::get('all-data/export', 'exportData')->name('allData.export');
});


Route::get('scape', [ScapeController::class, 'index']);





require __DIR__.'/auth.php';
