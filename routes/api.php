<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('entities')->group(base_path('routes/entities/entities.php'));
Route::prefix('diligence')->group(base_path('routes/entities/diligence.php'));
