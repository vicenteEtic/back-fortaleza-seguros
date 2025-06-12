<?php

namespace Database\Seeders;

use App\Models\Indicator\IndicatorType as IndicatorIndicatorType;
use App\Models\IndicatorType;
use Illuminate\Database\Seeder;

class IdentificationCapacitySeeder extends Seeder
{
    public function run()
    {
        $IndicatorType = [
            ['description' => "Capacidade para realizar a totalidade dos procedimentos de ID&V",  "risk" => "Baixo", "score" => "1", "indicator_id" => 1],
        ];

        //inserindo os indicadores
        foreach ($IndicatorType as $value) {
            if (!IndicatorIndicatorType::where('description', $value['description'])->exists()) {
                IndicatorIndicatorType::create($value);
            }
        }
    }
}
