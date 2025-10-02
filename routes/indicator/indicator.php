<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Indicator\IndicatorController;
use App\Http\Controllers\Indicator\IndicatorTypeController;

Route::get('', [IndicatorController::class, 'index'])
    ->name('indicator.index');

Route::post('', [IndicatorController::class, 'store'])
    ->name('indicator.store');
Route::put('getIndicatorsByFk/{id}', [IndicatorTypeController::class, 'update'])
    ->name('indicator.getIndicatorsByFk');

    

Route::put('{indicator}', [IndicatorController::class, 'update'])
    ->name('indicator.update');

Route::delete('{indicator}', [IndicatorController::class, 'destroy'])
    ->name('indicator.destroy');

Route::prefix('type')->group(function () {
    Route::get('', [IndicatorTypeController::class, 'index'])
        ->name('indicator.type.index');

    Route::post('identification-capacity', [IndicatorTypeController::class, 'storeCapacidadeIdentificacaoVerificacao'])
        ->name('indicator.type.store.identification-capacity');

    Route::post('profession', [IndicatorTypeController::class, 'storeTipoActividadePrincipal'])
        ->name('indicator.type.store.profession');

    Route::post('product-risk', [IndicatorTypeController::class, 'storeTipoSeguro'])
        ->name('indicator.type.store.product-risk');

    Route::post('country', [IndicatorTypeController::class, 'storeRiscoProdutosServicosTransacoes4'])
        ->name('indicator.type.store.country');

    Route::post('category', [IndicatorTypeController::class, 'storeTipoActividadePrincipalColectiva'])
        ->name('indicator.type.store.category');

    Route::post('canal', [IndicatorTypeController::class, 'storeCanal'])
        ->name('indicator.type.store.canal_type');

    Route::post('cae', [IndicatorTypeController::class, 'storeCae'])
        ->name('indicator.type.store.cae');

    Route::get('{type}', [IndicatorTypeController::class, 'show'])
        ->name('indicator.type.show');

    Route::put('{type}', [IndicatorTypeController::class, 'update'])
        ->name('indicator.type.update');

    Route::delete('{type}', [IndicatorTypeController::class, 'destroy'])
        ->name('indicator.type.destroy');

    Route::post('type-canal-store', [IndicatorTypeController::class, 'storeCanal'])
        ->name('indicator.type.store.canal');
});


Route::get('{indicator}', [IndicatorController::class, 'show'])
    ->name('indicator.show');
