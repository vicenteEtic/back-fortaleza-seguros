<?php

use App\Http\Controllers\Log\EntititeLogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Log\LogController;

Route::get('/user', [LogController::class, 'index'])
    ->name('user.index');
    Route::get('/user/{id_user}', [LogController::class, 'show'])
    ->name('user.show');


    Route::get('/entite', [EntititeLogController::class, 'index'])
    ->name('entite.index');
    Route::get('/entite/{id_entite}', [EntititeLogController::class, 'show'])
    ->name('entite.show');
