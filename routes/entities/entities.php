<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Entities\EntitiesController;

Route::get('', [EntitiesController::class, 'index'])
    ->name('entities.index');

Route::get('', [EntitiesController::class, 'create'])
    ->name('entities.create');

Route::post('', [EntitiesController::class, 'store'])
    ->name('entities.store');

Route::get('{entity}', [EntitiesController::class, 'show'])
    ->name('entities.show');


Route::put('{entity}', [EntitiesController::class, 'update'])
    ->name('entities.update');

Route::delete('{entity}', [EntitiesController::class, 'destroy'])
    ->name('entities.destroy');
