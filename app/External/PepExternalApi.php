<?php

namespace App\External;

use Illuminate\Support\Facades\Http;

class PepExternalApi
{
    public static function getDataPepExternal($name)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_PORT => "1090",
            CURLOPT_URL => "http://172.17.100.11:1090/api/pep",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_COOKIE => "laravel_session=hM4q4gLOqZwLcPXUpHPUdmTyUSWP7KIgcFlpPgu7; portal_de_denucias_session=2dxlNyPTiTpKkDWXqvHYHZs9AUvZujoe9K675j6f",
            CURLOPT_HTTPHEADER => [
                "User-Agent: insomnia/10.0.0"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
}
