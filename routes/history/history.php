<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Log\LogController;

Route::get('', [LogController::class, 'index'])
    ->name('history.index');

Route::post('', [LogController::class, 'store'])
    ->name('history.store');

Route::get('{history}', [LogController::class, 'show'])
    ->name('history.show');

Route::put('{history}', [LogController::class, 'update'])
    ->name('history.update');

Route::delete('{history}', [LogController::class, 'destroy'])
    ->name('history.destroy');
