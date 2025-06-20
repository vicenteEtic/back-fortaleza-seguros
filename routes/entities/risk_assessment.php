<?php

use App\Http\Controllers\Entities\RiskAssessmentController;
use Illuminate\Support\Facades\Route;

Route::get('', [RiskAssessmentController::class, 'index'])
    ->name('risk_assessment.index');

Route::post('', [RiskAssessmentController::class, 'store'])
    ->name('risk_assessment.store');

Route::put('{id}', [RiskAssessmentController::class, 'update'])
    ->name('risk_assessment.update');

Route::delete('{id}', [RiskAssessmentController::class, 'destroy'])
    ->name('risk_assessment.destroy');

Route::get('total-risk-level-by-category', [RiskAssessmentController::class, 'getTotalRiskLevelByCategory'])
    ->name('risk_assessment.total_risk_level_by_category');

Route::get('total-risk-level-by-profession', [RiskAssessmentController::class, 'getTotalRiskLevelByProfession'])
    ->name('risk_assessment.total_risk_level_by_profession');

Route::get('total-risk-level-by-channel', [RiskAssessmentController::class, 'getTotalRiskLevelByChannel'])
    ->name('risk_assessment.total_risk_level_by_channel');

Route::get('total-risk-level-by-pep', [RiskAssessmentController::class, 'getTotalRiskLevelByPep'])
    ->name('risk_assessment.total_risk_level_by_pep');

Route::get('total-risk-level-by-country-residence', [RiskAssessmentController::class, 'getTotalRiskLevelByCountryResidence'])
    ->name('risk_assessment.total_risk_level_by_country_residence');

Route::get('total-risk-level-by-nationality', [RiskAssessmentController::class, 'getTotalRiskLevelByNationality'])
    ->name('risk_assessment.total_risk_level_by_nationality');

Route::get('heat-map/{year?}', [RiskAssessmentController::class, 'getHeatMap'])
    ->name('risk_assessment.heat_map');

Route::get('{id}', [RiskAssessmentController::class, 'show'])
    ->name('risk_assessment.show');
