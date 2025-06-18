<?php

use App\Http\Controllers\Entities\RiskAssessmentController;
use Illuminate\Support\Facades\Route;

Route::get('', [RiskAssessmentController::class, 'index'])
    ->name('risk_assessment.index');

Route::post('', [RiskAssessmentController::class, 'store'])
    ->name('risk_assessment.store');

Route::get('{id}', [RiskAssessmentController::class, 'show'])
    ->name('risk_assessment.show');

Route::put('{id}', [RiskAssessmentController::class, 'update'])
    ->name('risk_assessment.update');

Route::delete('{id}', [RiskAssessmentController::class, 'destroy'])
    ->name('risk_assessment.destroy');

