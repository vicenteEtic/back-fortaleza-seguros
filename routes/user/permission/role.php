<?php

use App\Http\Controllers\Permission\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('', [RoleController::class, 'index'])
    ->name('role.index');

Route::post('', [RoleController::class, 'store'])
    ->name('role.store');

Route::put('{role}', [RoleController::class, 'update'])
    ->name('role.update');

Route::delete('{role}', [RoleController::class, 'destroy'])
    ->name('role.destroy');

Route::get('{role}', [RoleController::class, 'show'])
    ->name('role.show');
