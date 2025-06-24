<?php

namespace App\External;

use Illuminate\Support\Facades\Http;

class PepExternalApi
{
    public static function getDataPepExternal($name)
    {
        $api = Http::get(env('URL_PEP_API') . '/pep/search', [
            "filters" => [
                "name" =>  $name,
                "min_score" => 50,
                "limitSearch" => 1
            ]
        ]);
        if ($api->successful()) {
            return $api->json();
        }
        return response()->json(['error' => 'Failed to fetch data from PEP API'], $api->status());
    }
}
