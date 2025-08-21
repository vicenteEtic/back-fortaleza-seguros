<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alert\AlertController;

Route::get('', [AlertController::class, 'index'])
    ->name('alert.index');
