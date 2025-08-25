<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alert\AlertController;
use App\Http\Controllers\Alert\AlertUser\AlertUserController;
use App\Models\Alert\AlertUser\AlertUser;

Route::get('', [AlertController::class, 'index'])
    ->name('alert.index');

Route::get('/user', [AlertUserController::class, 'index'])
    ->name('alertUser.index');
Route::post('/user', [AlertUserController::class, 'store'])
    ->name('alertUser.store');
Route::put('/user', [AlertUserController::class, 'update'])
    ->name('alertUser.update');
