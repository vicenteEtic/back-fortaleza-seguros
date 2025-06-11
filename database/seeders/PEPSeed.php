<?php

namespace Database\Seeders;

use App\Models\Indicator\IndicatorType as IndicatorIndicatorType;
use App\Models\IndicatorType;
use Illuminate\Database\Seeder;

class PEPSeed extends Seeder
{
    public function run()
    {
           /**IndicatorType */
           $IndicatorType = [

                 /**A entidade é considerada PPE ? */
                 ['description' => 'Sim PEP', 'risk' => 'Muito Elevado', 'score' => 20, 'indicator_id' => 6],
                 ['description' => 'Não PEP', 'risk' => 'Baixo', 'score' => 1, 'indicator_id' => 6],


        ];

        //inserindo os indicadores
        foreach ($IndicatorType as $value) {
            if (!IndicatorIndicatorType::where('description', $value['description'])->exists()) {
                IndicatorIndicatorType::create($value);
            }
        }

    }
}
