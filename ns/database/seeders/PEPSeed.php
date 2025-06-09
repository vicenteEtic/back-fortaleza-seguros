<?php

namespace Database\Seeders;

use App\Models\IndicatorType;
use Illuminate\Database\Seeder;

class PEPSeed extends Seeder
{
    public function run()
    {
           /**IndicatorType */
           $IndicatorType = [

                 /**A entidade é considerada PPE ? */
                 ['description' => 'Sim PEP', 'risk' => 'Muito Elevado', 'score' => 20, 'fk_indicator' => 6],
                 ['description' => 'Não PEP', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 6],


        ];

        //inserindo os indicadores
        foreach ($IndicatorType as $value) {
            if (!IndicatorType::where('description', $value['description'])->exists()) {
                IndicatorType::create($value);
            }
        }

    }
}
