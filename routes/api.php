<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('entities')->group(base_path('routes/entities/entities.php'));
Route::prefix('indicator')->group(base_path('routes/indicator/indicator.php'));
Route::prefix('diligence')->group(base_path('routes/diligence/diligence.php'));
Route::prefix('history')->group(base_path('routes/history/history.php'));
