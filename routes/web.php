<?php

use App\External\PepExternalApi;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/teste_api', function () {

    $data = PepExternalApi::getDataPepExternal('Manuel Homem');
    return response()->json($data);
});
