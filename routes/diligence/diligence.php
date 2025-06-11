<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Diligence\DiligenceController;

Route::get('', [DiligenceController::class, 'index'])
    ->name('diligence.index');

Route::post('', [DiligenceController::class, 'store'])
    ->name('diligence.store');

Route::get('{diligence}', [DiligenceController::class, 'show'])
    ->name('diligence.show');

Route::put('{diligence}', [DiligenceController::class, 'update'])
    ->name('diligence.update');

Route::delete('{diligence}', [DiligenceController::class, 'destroy'])
    ->name('diligence.destroy');
