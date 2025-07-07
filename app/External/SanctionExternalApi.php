<?php

namespace App\External;

use Illuminate\Support\Facades\Http;

class SanctionExternalApi
{
    public static function getDataSanctionExternal($name)
    {
        $api = Http::get(env('URL_PEP_API') . '/sanction/search', [
            "filters" => [
                "name" =>  $name,
                "min_score" => 50,
                "limitSearch" => 5
            ]
        ]);
        if ($api->successful()) {
            return $api->json();
        }
        return response()->json(['error' => 'Failed to fetch data from PEP API'], $api->status());
    }

    public static function getAllSanctions($name)
    {
        $api = Http::get(env('URL_PEP_API') . '/sanction', [
            "filters" => [
                "name" =>  $name
            ]
        ]);
        if ($api->successful()) {
            return $api->json();
        }
        return response()->json(['error' => 'Failed to fetch data from PEP API'], $api->status());
    }
}
