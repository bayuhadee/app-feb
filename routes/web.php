<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\SocialiteController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('socialite.callback');
Route::get('/export/biodata-wisudawan', [ExportController::class, 'cetakBiodataWisudawan'])->name('export.biodata-wisudawan');
Route::get('/export/biodata-alumni', [ExportController::class, 'cetakBiodataAlumni'])->name('export.biodata-alumni');
Route::get('/export/biodata-vandel', [ExportController::class, 'cetakBiodataVandel'])->name('export.biodata-vandel');
