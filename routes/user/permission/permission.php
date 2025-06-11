<?php

use App\Http\Controllers\Permission\PermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');
Route::post('/permission', [PermissionController::class, 'store'])->name('permission.store');
Route::get('/permission/{id}', [PermissionController::class, 'show'])->name('permission.show');
Route::put('/permission/{id}', [PermissionController::class, 'update'])->name('permission.update');
Route::delete('/permission/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');