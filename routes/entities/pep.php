<?php

use App\Http\Controllers\Entities\PepController;
use Illuminate\Support\Facades\Route;

Route::get('', [PepController::class, 'index'])
    ->name('pep.index');

Route::get('external', [PepController::class, 'pepExternalGetAll'])
    ->name('pep.external');