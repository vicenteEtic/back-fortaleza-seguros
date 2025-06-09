<?php

use Illuminate\Support\Facades\Route;

Route::post('/login', 'AuthController@login')->name('login');

Route::middleware(['auth.token', 'cors'])->group(function () {
    /** logout */
    Route::get('/logout', 'AuthController@logout')->name('logout');

    /**users */
    Route::prefix('users')->group(function () {
        Route::get('validate', 'Api\User\UserController@profileLoger');
        Route::get('', 'Api\User\UserController@index');
        Route::post('', 'Api\User\UserController@store');
        Route::get('/{id}', 'Api\User\UserController@show');
        Route::put('/{id}', 'Api\User\UserController@update');
        Route::delete('/{id}', 'Api\User\UserController@destroy');
    });

    /**type_entities */
    Route::prefix('entities/type')->group(function () {
        Route::get('', 'Api\TypeEntities\TypeEntities@index');
        Route::post('', 'Api\TypeEntities\TypeEntities@store');
        Route::get('/{id}', 'Api\TypeEntities\TypeEntities@show');
        Route::put('/{id}', 'Api\TypeEntities\TypeEntities@update');
        Route::delete('/{id}', 'Api\TypeEntities\TypeEntities@destroy');
    });
    /**type_entities */

    /**entities */
    Route::prefix('entities')->group(function () {
        Route::get('', 'Api\Entities\EntitiesController@index');
        Route::post('', 'Api\Entities\EntitiesController@store');
        Route::get('/{id}', 'Api\Entities\EntitiesController@show');
        Route::put('/{id}', 'Api\Entities\EntitiesController@update');
        Route::delete('/{id}', 'Api\Entities\EntitiesController@destroy');
    });
    /**entities */

    /**risk_Type */

    Route::prefix('risk/Type')->group(function () {
        Route::get('', 'Api\RiskType\RickTypeController@index');
        Route::post('', 'Api\RiskType\RickTypeController@store');
        Route::get('/{id}', 'Api\RiskType\RickTypeController@show');
        Route::put('/{id}', 'Api\RiskType\RickTypeController@update');
        Route::delete('/{id}', 'Api\RiskType\RickTypeController@destroy');
    });
    /**end riskType */
    /**risk */

    Route::prefix('risk')->group(function () {
        Route::get('', 'Api\Risk\RickController@index');
        Route::post('', 'Api\Risk\RickController@store');
        Route::get('/{id}', 'Api\Risk\RickController@show');
        Route::put('/{id}', 'Api\Risk\RickController@update');
        Route::delete('/{id}', 'Api\Risk\RickController@destroy');
    });
    /**end risk */

    /**channel */
    Route::prefix('channel')->group(function () {
        Route::get('', 'Api\Channel\ChannelController@index');
        Route::post('', 'Api\Channel\ChannelController@store');
        Route::get('/{id}', 'Api\Channel\ChannelController@show');
        Route::put('/{id}', 'Api\Channel\ChannelController@update');
        Route::delete('/{id}', 'Api\Channel\ChannelController@destroy');
    });
    /**end channel */

    /**indicator */
    Route::prefix('indicator')->group(function () {
        Route::get('', 'Api\Indicator\IndicatorController@index');
        Route::post('', 'Api\Indicator\IndicatorController@store');
        Route::get('/{id}', 'Api\Indicator\IndicatorController@show');
        Route::put('/{id}', 'Api\Indicator\IndicatorController@update');
        Route::delete('/{id}', 'Api\Indicator\IndicatorController@destroy');
    });

    /**end indicator */
    /**IndicatorType */
    Route::prefix('indicator/type')->group(function () {
        Route::get('', 'Api\IndicatorType\IndicatorTypeController@index');
        Route::post('', 'Api\IndicatorType\IndicatorTypeController@store');
        Route::get('/{id}', 'Api\IndicatorType\IndicatorTypeController@show');
        Route::put('/{id}', 'Api\IndicatorType\IndicatorTypeController@update');
        Route::delete('/{id}', 'Api\IndicatorType\IndicatorTypeController@destroy');
    });

    /**roles */
    Route::prefix('roles')->group(function () {
        Route::get('', 'Api\Roles\RoleController@index');
        Route::post('', 'Api\Roles\RoleController@store');
        Route::get('/{id}', 'Api\Roles\RoleController@show');
        Route::put('/{id}', 'Api\Roles\RoleController@update');
        Route::delete('/{id}', 'Api\Roles\RoleController@destroy');
    });

    Route::prefix('permission')->group(function () {
        Route::get('', 'Api\Roles\RolePermissionController@index');
        Route::post('', 'Api\Roles\RolePermissionController@store');
        Route::get('/{id}', 'Api\Roles\RolePermissionController@show');
        Route::put('/{id}', 'Api\Roles\RolePermissionController@update');
        Route::delete('/{id}', 'Api\Roles\RolePermissionController@destroy');
    });

    /**deligences */
    Route::prefix('deligences')->group(function () {
        Route::get('', 'Api\Deligence\DeligenceController@index');
        Route::post('', 'Api\Deligence\DeligenceController@store');
        Route::get('/{id}', 'Api\Deligence\DeligenceController@show');
        Route::put('/{id}', 'Api\Deligence\DeligenceController@update');
        Route::delete('/{id}', 'Api\Deligence\DeligenceController@destroy');
    });

    /**evaluations */
    Route::prefix('evaluations')->group(function () {
        Route::get('', 'Api\Assessment\AssessmentController@index');
        Route::get('/pep', 'Api\Assessment\AssessmentController@pep');
        Route::post('', 'Api\Assessment\AssessmentController@store');
        Route::get('/{id}', 'Api\Assessment\AssessmentController@show');
        Route::put('/{id}', 'Api\Assessment\AssessmentController@update');
        Route::delete('/{id}', 'Api\Assessment\AssessmentController@destroy');
    });
    /**end deligences */

    Route::post('imports', 'Api\Importacao\ImportacaoController@index');
    Route::get('/imports', 'Api\Importacao\ImportacaoController@errorEvaluation');
    Route::get('/imports/{id}', 'Api\Importacao\ImportacaoController@show');
    /**Countries */
    Route::prefix('Countries')->group(function () {
        Route::get('', 'Api\Countries\CountrieController@index');
        Route::post('', 'Api\Countries\CountrieController@store');
        Route::get('/{id}', 'Api\Countries\CountrieController@show');
        Route::put('/{id}', 'Api\Countries\CountrieController@update');
        Route::delete('/{id}', 'Api\Countries\CountrieController@destroy');
    });
    /**end Countries */

    /**profession */
    Route::prefix('profession')->group(function () {
        Route::get('', 'Api\Profession\ProfessionController@index');
        Route::post('', 'Api\Profession\ProfessionController@store');
        Route::get('/{id}', 'Api\Profession\ProfessionController@show');
        Route::put('/{id}', 'Api\Profession\ProfessionController@update');
        Route::delete('/{id}', 'Api\Profession\ProfessionController@destroy');
    });
    /**end profession */

    /**Category */
    Route::prefix('Category')->group(function () {
        Route::get('', 'Api\Category\CategoryController@index');
        Route::post('', 'Api\Category\CategoryController@store');
        Route::get('/{id}', 'Api\Category\CategoryController@show');
        Route::put('/{id}', 'Api\Category\CategoryController@update');
        Route::delete('/{id}', 'Api\Category\CategoryController@destroy');
    });
    /**end Category */

    /**identification-capacity */
    Route::prefix('identification-capacity')->group(function () {
        Route::get('', 'Api\IdentificationCapacity\IdentificationCapacityController@index');
        Route::post('', 'Api\IdentificationCapacity\IdentificationCapacityController@store');
        Route::get('/{id}', 'Api\IdentificationCapacity\IdentificationCapacityController@show');
        Route::put('/{id}', 'Api\IdentificationCapacity\IdentificationCapacityController@update');
        Route::delete('/{id}', 'Api\IdentificationCapacity\IdentificationCapacityController@destroy');
    });
    /**end identification-capacity */

    /**identification-capacity */
    Route::prefix('product-risk')->group(function () {
        Route::get('', 'Api\ProductRisk\ProductRiskController@index');
        Route::post('', 'Api\ProductRisk\ProductRiskController@store');
        Route::get('/{id}', 'Api\ProductRisk\ProductRiskController@show');
        Route::put('/{id}', 'Api\ProductRisk\ProductRiskController@update');
        Route::delete('/{id}', 'Api\ProductRisk\ProductRiskController@destroy');
    });
    /**end identification-capacity */


    /**identification-capacity */
    Route::prefix('cae')->group(function () {
        Route::get('', 'Api\Cae\CaeController@index');
        Route::post('', 'Api\Cae\CaeController@store');
        Route::get('/{id}', 'Api\Cae\CaeController@show');
        Route::put('/{id}', 'Api\Cae\CaeController@update');
        Route::delete('/{id}', 'Api\Cae\CaeController@destroy');
    });
    /**end identification-capacity */
    Route::get('history', 'Api\History\HistroyController@index');
    Route::get('history/user/{id}', 'Api\History\HistroyController@history');
    Route::post('history', 'Api\History\HistroyController@store');
    Route::get('myHistory', 'Api\History\HistroyController@myHistory');
    /**end identification-capacity */


    /**EntitieHistorieHistroy */
    Route::prefix('history')->group(function () {
        Route::get('/entitie', 'Api\History\EntitieHistorieHistroyController@index');
        Route::get('/entitie/{id}', 'Api\History\EntitieHistorieHistroyController@history');
        Route::post('/entitie', 'Api\History\EntitieHistorieHistroyController@store');

    });
     /**end EntitieHistorieHistroy */

    /**estatistica */
    Route::prefix('analytic')->group(function () {
        Route::get('/category', 'Api\Estatistica\Collective\CollectiveEntitieController@index');
        Route::get('/cae', 'Api\Estatistica\Collective\CAEController@index');
        Route::get('/pep', 'Api\Estatistica\Collective\PEPController@index');
        Route::get('/residence', 'Api\Estatistica\Collective\ResidenceController@index');
        Route::get('/nationality', 'Api\Estatistica\Collective\NationalityController@index');
        Route::get('/product', 'Api\Estatistica\Collective\ProductController@index');
        Route::get('/heat-map', 'Api\Estatistica\HeatMapController@index');
        Route::get('/channel', 'Api\Estatistica\ChannelController@index');
        Route::get('/error-channel', 'Api\Estatistica\ErrorChannelController@index');

    });

    Route::prefix('analytic')->group(function () {
        Route::get('/dasboard', 'Api\Estatistica\Dasbordad@index');

    });
    /**importação de dados  */
});
