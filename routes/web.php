<?php

use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\SubkriteriaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Route::controller(AlternatifController::class)->prefix('alternatif')->group(function () {
    //     Route::get('/', 'index')->name('alternatif.index');
    // });
});

Route::resource('alternatif', App\Http\Controllers\AlternatifController::class);

Route::get('/alternatif', [AlternatifController::class, 'index'])->name('alternatif.index');
Route::post('/alternatif', [AlternatifController::class, 'store'])->name('alternatif.store');
Route::put('/alternatif/{alternatif}', [AlternatifController::class, 'update'])->name('alternatif.update');
Route::delete('/alternatif/{alternatif}', [AlternatifController::class, 'destroy'])->name('alternatif.destroy');

Route::resource('kriteria', App\Http\Controllers\kriteriaController::class);

Route::get('/kriteria', [kriteriaController::class, 'index'])->name('kriteria.index');
Route::post('/kriteria', [kriteriaController::class, 'store'])->name('kriteria.store');
Route::put('/kriteria/{kriteria}', [kriteriaController::class, 'update'])->name('kriteria.update');
Route::delete('/kriteria/{kriteria}', [kriteriaController::class, 'destroy'])->name('kriteria.destroy');

Route::resource('subkriteria', App\Http\Controllers\SubkriteriaController::class);

Route::get('/subkriteria', [SubkriteriaController::class, 'index'])->name('subkriteria.index');
Route::post('/subkriteria', [SubkriteriaController::class, 'store'])->name('subkriteria.store');
Route::put('/subkriteria/{id}', [SubkriteriaController::class, 'update'])->name('subkriteria.update');

use App\Http\Controllers\PerhitunganController;

Route::get('/perhitungan', [PerhitunganController::class, 'index'])->name('perhitungan.index');


Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
