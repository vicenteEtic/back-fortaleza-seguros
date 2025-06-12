<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

Route::get('', [UserController::class, 'index'])
    ->name('user.index');

Route::post('', [UserController::class, 'store'])
    ->name('user.store');

Route::get('{id}', [UserController::class, 'show'])
    ->name('user.show');

Route::put('{id}', [UserController::class, 'update'])
    ->name('user.update');

Route::delete('{id}', [UserController::class, 'destroy'])
    ->name('user.destroy');
