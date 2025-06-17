<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('entities')->group(base_path('routes/entities/entities.php'));
    Route::prefix('diligence')->group(base_path('routes/diligence/diligence.php'));
    Route::prefix('indicator')->group(base_path('routes/indicator/indicator.php'));
    Route::prefix('permission')->group(base_path('routes/user/permission/permission.php'));
    Route::prefix('role')->group(base_path('routes/user/permission/role.php'));
    Route::prefix('indicator')->group(base_path('routes/indicator/indicator.php'));
    Route::prefix('diligence')->group(base_path('routes/diligence/diligence.php'));
    Route::prefix('history')->group(base_path('routes/history/history.php'));
    Route::prefix('user')->group(base_path('routes/user/user.php'));
    Route::prefix('risk_assessment')->group(base_path('routes/entities/risk_assessment.php'));
});

Route::prefix('auth')->middleware('guest')->group(base_path('routes/user/auth.php'));
