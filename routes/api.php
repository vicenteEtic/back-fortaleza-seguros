<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('entities')->group(base_path('routes/entities/entities.php'));
Route::prefix('indicator')->group(base_path('routes/indicator/indicator.php'));
