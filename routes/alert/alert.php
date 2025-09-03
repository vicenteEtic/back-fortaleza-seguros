<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alert\AlertController;
use App\Http\Controllers\Alert\AlertUser\AlertUserController;
use App\Http\Controllers\Alert\CommentAlert\CommentAlertController;
use App\Http\Requests\Alert\CommentAlert\CommentAlertRequest;
use App\Models\Alert\AlertUser\AlertUser;

Route::get('', [AlertController::class, 'index'])
    ->name('alert.index');

Route::get('/user/{id}', [AlertUserController::class, 'findByUser'])
    ->name('alertUser.show');

Route::get('/user', [AlertUserController::class, 'getAllUsersAlertSummary'])
    ->name('alertUser.getAllUsersAlertSummary');

Route::get('/user', [AlertUserController::class, 'getAllUsersAlertSummary'])
    ->name('alertUser.getAllUsersAlertSummary');


Route::get('/total', [AlertController::class, 'getTotalAlerts'])
    ->name('alertUser.store');
Route::put('/user', [AlertUserController::class, 'update'])
    ->name('alertUser.update');


Route::get('/comment', [CommentAlertController::class, 'index'])
    ->name('comment.index');
    Route::get('/comment/{id}', [CommentAlertController::class, 'show'])
    ->name('comment.show');
Route::post('/comment', [CommentAlertController::class, 'store'])
    ->name('comment.store');
