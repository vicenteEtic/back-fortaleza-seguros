<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

Route::post('/login', [UserController::class, 'login']);
