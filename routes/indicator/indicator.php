<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Indicator\IndicatorController;
use App\Http\Controllers\Indicator\IndicatorTypeController;

Route::get('', [IndicatorController::class, 'index'])
    ->name('indicator.index');

Route::post('', [IndicatorController::class, 'store'])
    ->name('indicator.store');
    Route::get('getIndicatorsByFk', [IndicatorController::class, 'getIndicatorsByFk'])
    ->name('indicator.getIndicatorsByFk');
Route::get('{indicator}', [IndicatorController::class, 'show'])
    ->name('indicator.show');

Route::put('{indicator}', [IndicatorController::class, 'update'])
    ->name('indicator.update');

Route::delete('{indicator}', [IndicatorController::class, 'destroy'])
    ->name('indicator.destroy');




Route::get('type', [IndicatorTypeController::class, 'index'])
    ->name('indicator.type.index');

Route::post('type', [IndicatorTypeController::class, 'store'])
    ->name('indicator.type.store');

Route::get('type/{type}', [IndicatorTypeController::class, 'show'])
    ->name('indicator.type.show');

Route::put('type/{type}', [IndicatorTypeController::class, 'update'])
    ->name('indicator.type.update');

Route::delete('type/{type}', [IndicatorTypeController::class, 'destroy'])
    ->name('indicator.type.destroy');
