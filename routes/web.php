<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\SocialiteController;

Route::get('/clear-cache', function () {
    // $exitCode1 = Artisan::call('route:clear');
    // $exitCode2 = Artisan::call('config:clear');
    // $exitCode3 = Artisan::call('view:clear');
    // $exitCode4 = Artisan::call('cache:clear');
    $exitCode5 = Artisan::call('optimize:clear');
    // return what you want
    return "Clear Success";
});

Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('socialite.callback');
Route::get('/export/biodata-wisudawan', [ExportController::class, 'cetakBiodataWisudawan'])->name('export.biodata-wisudawan');
Route::get('/export/biodata-alumni', [ExportController::class, 'cetakBiodataAlumni'])->name('export.biodata-alumni');
Route::get('/export/biodata-vandel', [ExportController::class, 'cetakBiodataVandel'])->name('export.biodata-vandel');
