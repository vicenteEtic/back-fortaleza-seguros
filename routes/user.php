<?php

use App\Http\Controllers\User\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('', [UserController::class, 'index'])->name('user.index');
Route::post('', [UserController::class, 'store'])->name('user.store');
Route::get('{user}', [UserController::class, 'show'])->name('user.show');
Route::put('{user}', [UserController::class, 'update'])->name('user.update');
Route::delete('{user}', [UserController::class, 'destroy'])->name('user.destroy');
Route::get('restore/{user}', [UserController::class, 'restore'])->name('user.restore');

